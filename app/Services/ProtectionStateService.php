<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

/**
 * Гістерезис-машина станів NORMAL → SUSPICIOUS → ATTACK → NORMAL.
 *
 * Вхід у ATTACK/SUSPICIOUS вимагає N ПОСЛІДОВНИХ циклів з високим score
 * (швидко), або одного екстремального score (attack_score_immediate) для
 * миттєвої реакції на різкий сплеск. Вихід з ATTACK вимагає значно довшої
 * серії стабільно низького score (за замовчуванням 15 циклів ≈ 15 хв проти
 * 3 циклів на вхід) — це і є захист від NORMAL→ATTACK→NORMAL "мигання".
 *
 * Стан і лічильники серій зберігаються в Redis (переживають рестарт cron,
 * не переживають лише повне очищення Redis — це прийнятно, після рестарту
 * система за хвилини знову накопичить власну історію).
 */
class ProtectionStateService
{
    private const REDIS_STATE_KEY = 'cfprot:state';

    public function __construct(
        private readonly CloudflareProtectionService $cloudflare,
        private readonly BaselineRepository $baseline,
        private readonly array $thresholds,
        private readonly array $hysteresis,
        private readonly bool $telegramNotify,
    ) {
    }

    /**
     * Знімок метрик у формі, якої очікує BaselineRepository (ключі
     * BaselineRepository::METRICS), з того ж $snapshot, що йде в
     * AttackDetectionService (там інші назви ключів — total_requests/
     * unique_ips — тому що ці назви вже усталені в TrafficAnalyzer).
     */
    private function extractBaselineMetrics(array $snapshot): array
    {
        return [
            'requests' => $snapshot['total_requests'],
            'unique_ip' => $snapshot['unique_ips'],
            'top_ip_share' => $snapshot['top_ip_share'] ?? null,
            'top5_share' => $snapshot['top5_share'] ?? null,
            'load15' => $snapshot['load15'] ?? null,
            'http4xx_rate' => $snapshot['http4xx_rate'] ?? null,
        ];
    }

    /**
     * @return array{state:string, previous_state:string, transitioned:bool}
     */
    public function decide(int $score, array $snapshot): array
    {
        $stored = Redis::hgetall(self::REDIS_STATE_KEY) ?: [];
        $currentState = $stored['state'] ?? 'NORMAL';
        $attackStreak = (int) ($stored['attack_streak'] ?? 0);
        $suspiciousStreak = (int) ($stored['suspicious_streak'] ?? 0);
        $calmStreak = (int) ($stored['calm_streak'] ?? 0);
        $enteredAt = (int) ($stored['entered_at'] ?? now()->timestamp);

        $loadOverride = ($snapshot['load5'] ?? 0) >= $this->thresholds['load_attack_threshold'];

        $attackStreak = $score >= $this->thresholds['attack_score'] ? $attackStreak + 1 : 0;
        $suspiciousStreak = $score >= $this->thresholds['suspicious_score'] ? $suspiciousStreak + 1 : 0;
        // Поки loadOverride активний, ми НЕ "спокійні", навіть якщо attack score
        // низький — інакше calmStreak тихо накопичується під час реального
        // навантаження і на першому ж циклі, де load на мить провалюється нижче
        // порогу, стан встигає вискочити в NORMAL і одразу назад — зайві переходи
        // (і Telegram-сповіщення) без реальної зміни ситуації.
        $calmStreak = ($score < $this->thresholds['suspicious_score'] && !$loadOverride) ? $calmStreak + 1 : 0;

        $newState = $currentState;

        if ($score >= $this->thresholds['attack_score_immediate'] || $loadOverride) {
            $newState = 'ATTACK';
        } elseif ($currentState === 'NORMAL') {
            if ($attackStreak >= $this->hysteresis['attack_enter_cycles']) {
                $newState = 'ATTACK';
            } elseif ($suspiciousStreak >= $this->hysteresis['suspicious_enter_cycles']) {
                $newState = 'SUSPICIOUS';
            }
        } elseif ($currentState === 'SUSPICIOUS') {
            if ($attackStreak >= $this->hysteresis['attack_enter_cycles']) {
                $newState = 'ATTACK';
            } elseif ($calmStreak >= $this->hysteresis['suspicious_exit_cycles']) {
                $newState = 'NORMAL';
            }
        } elseif ($currentState === 'ATTACK') {
            if ($calmStreak >= $this->hysteresis['attack_exit_cycles']) {
                $newState = 'NORMAL';
            }
        }

        $transitioned = $newState !== $currentState;
        $enteredAt = $transitioned ? now()->timestamp : $enteredAt;

        Redis::hmset(self::REDIS_STATE_KEY, [
            'state' => $newState,
            'attack_streak' => $attackStreak,
            'suspicious_streak' => $suspiciousStreak,
            'calm_streak' => $calmStreak,
            'entered_at' => $enteredAt,
            'last_score' => $score,
        ]);
        Redis::expire(self::REDIS_STATE_KEY, 86400);

        // Baseline вчиться лише на трафіку, який сама система вважає нормальним —
        // інакше тривала атака поступово "стане новою нормою" і перестане
        // виявлятись власним же алгоритмом. SUSPICIOUS теж повністю виключений
        // (не лише ATTACK) — на 346 тестових циклах SUSPICIOUS був лише 3.5%,
        // тому повне виключення не "голодує" baseline, а лишається найпростішим
        // з можливих правил.
        $this->baseline->pushSample(
            $this->extractBaselineMetrics($snapshot),
            (int) now()->format('G'),
            $newState === 'NORMAL'
        );

        if ($transitioned) {
            $this->cloudflare->applyState($newState);
            $this->notifyTransition($currentState, $newState, $score, $snapshot, $enteredAt, $loadOverride);
        }

        return [
            'state' => $newState,
            'previous_state' => $currentState,
            'transitioned' => $transitioned,
            'load_override' => $loadOverride,
        ];
    }

    private function notifyTransition(
        string $from,
        string $to,
        int $score,
        array $snapshot,
        int $enteredAt,
        bool $loadOverride = false
    ): void {
        if (!$this->telegramNotify || !config('services.telegram.bot_token')) {
            return;
        }

        $text = $this->buildTelegramText($from, $to, $score, $snapshot, $enteredAt, $loadOverride);

        try {
            Http::asForm()->timeout(10)->post(
                'https://api.telegram.org/bot' . config('services.telegram.bot_token') . '/sendMessage',
                [
                    'chat_id' => config('services.telegram.chat_id'),
                    'text' => $text,
                ]
            );
        } catch (\Throwable $e) {
            Log::channel('cloudflare-protection')->error('Telegram notify failed: ' . $e->getMessage());
        }
    }

    private function buildTelegramText(
        string $from,
        string $to,
        int $score,
        array $snapshot,
        int $enteredAt,
        bool $loadOverride = false
    ): string {
        $requestsPerMin = $snapshot['total_requests'];
        $uniqueIps = $snapshot['unique_ips'];
        $topIpShare = round(($snapshot['top_ip_share'] ?? 0) * 100);
        $load = $snapshot['load15'] ?? 0;

        if ($to === 'ATTACK') {
            $trigger = $loadOverride ? "Trigger: load5 ≥ threshold (capacity breaker)\n\n" : '';
            return "🔴 Cloudflare protection activated\n\n"
                . $trigger
                . "Attack score: {$score}\n\n"
                . "Requests/min: {$requestsPerMin}\n"
                . "Unique IP: {$uniqueIps}\n"
                . "Top IP share: {$topIpShare}%\n"
                . "Load: {$load}\n\n"
                . "State:\n{$from} → {$to}";
        }

        if ($from === 'ATTACK' && $to === 'NORMAL') {
            $durationMinutes = max(1, (int) round((now()->timestamp - $enteredAt) / 60));
            return "🟢 Cloudflare protection disabled\n\n"
                . "Attack score: {$score}\n"
                . "Duration: {$durationMinutes} minutes\n\n"
                . "State:\n{$from} → {$to}";
        }

        return "⚠️ Cloudflare protection state changed\n\n"
            . "Attack score: {$score}\n"
            . "State:\n{$from} → {$to}";
    }
}
