<?php

namespace App\Console\Commands;

use App\Services\AttackDetectionService;
use App\Services\RobustStats;
use Illuminate\Console\Command;

/**
 * Офлайн-прогін нової (v2, baseline-based) формули attack score на вже
 * накопиченому storage/logs/cloudflare-protection-*.log — БЕЗ жодного
 * звернення до Redis/Cloudflare/Telegram і без впливу на продакшн-стан.
 *
 * Свідомо НЕ використовує App\Services\BaselineRepository (той працює з
 * живим Redis): тут власна, повністю in-memory копія тієї самої логіки
 * (пул 3 сусідніх годин → глобальний fallback → immature), яка читає й
 * пише в звичайні PHP-масиви, побудовані ЧАСОВО-ПОСЛІДОВНО з історичного
 * логу — так само, як це відбувалось би хвилина за хвилиною в проді, без
 * "підглядання" в майбутні цикли при оцінці baseline для цикла в минулому.
 *
 * Стара статистика (old_score/old_state) береться напряму з уже записаних
 * рядків логу — вона й так там є, перераховувати нічого не треба.
 */
class BacktestCloudflareProtection extends Command
{
    protected $signature = 'protection:backtest {--top=20 : Скільки найаномальніших циклів показати}';

    protected $description = 'Backtest нової формули attack score на історії storage/logs/cloudflare-protection-*.log (read-only)';

    private const HOUR_BUCKET_CAP = 1000;
    private const MIN_SAMPLES = 30;

    private array $hourBuckets = []; // [metric => [hour => [values...]]]
    private array $globalHistory = []; // [metric => [values...]]

    public function handle(): int
    {
        $files = glob(storage_path('logs/cloudflare-protection-*.log'));
        sort($files);

        if (empty($files)) {
            $this->error('Логів cloudflare-protection ще немає.');
            return self::FAILURE;
        }

        $cycles = $this->parseLogFiles($files);
        if (empty($cycles)) {
            $this->error('Не вдалось розпарсити жодного циклу.');
            return self::FAILURE;
        }

        $this->info('Прочитано циклів: ' . count($cycles));

        $detector = new AttackDetectionService();
        $rows = [];

        // Гістерезис реплеюється теж, але окремо від продакшн-Redis — самі
        // лічильники серій тут локальні змінні, не Redis-ключі.
        $thresholds = config('cloudflare_protection.thresholds');
        $hysteresis = config('cloudflare_protection.hysteresis');
        $newState = 'NORMAL';
        $attackStreak = 0;
        $suspiciousStreak = 0;
        $calmStreak = 0;

        foreach ($cycles as $c) {
            $hour = (int) date('G', strtotime($c['_ts']));

            $baselines = $this->getBaselinesForHour($hour);

            $snapshot = [
                'total_requests' => $c['requests_per_min'],
                'unique_ips' => $c['unique_ip'],
                'top_ip_share' => $c['top_ip_share_pct'] / 100,
                'top5_share' => $c['top5_share_pct'] / 100,
                'load15' => $c['load15'],
                // http_total історично не логувався — беремо requests_per_min як
                // наближення знаменника (порядок величини той самий: обидва —
                // весь трафік сайту за ту саму хвилину, з різних джерел).
                'http4xx_rate' => $c['requests_per_min'] > 0 ? min(1, $c['http_4xx'] / max(1, $c['requests_per_min'])) : null,
                'worst_url' => $c['worst_url'],
                'worst_url_requests' => $c['worst_url_requests'] ?? 0,
                'worst_url_unique_ips' => $c['worst_url_unique_ips'] ?? 0,
            ];

            $detection = $detector->score($snapshot, $baselines);
            $newScore = $detection['score'];

            $oldState = $newState;
            $attackStreak = $newScore >= $thresholds['attack_score'] ? $attackStreak + 1 : 0;
            $suspiciousStreak = $newScore >= $thresholds['suspicious_score'] ? $suspiciousStreak + 1 : 0;
            $calmStreak = $newScore < $thresholds['suspicious_score'] ? $calmStreak + 1 : 0;

            if ($newScore >= $thresholds['attack_score_immediate']) {
                $newState = 'ATTACK';
            } elseif ($oldState === 'NORMAL') {
                if ($attackStreak >= $hysteresis['attack_enter_cycles']) {
                    $newState = 'ATTACK';
                } elseif ($suspiciousStreak >= $hysteresis['suspicious_enter_cycles']) {
                    $newState = 'SUSPICIOUS';
                }
            } elseif ($oldState === 'SUSPICIOUS') {
                if ($attackStreak >= $hysteresis['attack_enter_cycles']) {
                    $newState = 'ATTACK';
                } elseif ($calmStreak >= $hysteresis['suspicious_exit_cycles']) {
                    $newState = 'NORMAL';
                }
            } elseif ($oldState === 'ATTACK') {
                if ($calmStreak >= $hysteresis['attack_exit_cycles']) {
                    $newState = 'NORMAL';
                }
            }

            $this->pushSample($snapshot, $hour, $newState === 'NORMAL');

            $rows[] = [
                'time' => substr($c['_ts'], 11),
                'old_score' => $c['attack_score'],
                'new_score' => $newScore,
                'requests' => $c['requests_per_min'],
                'unique_ip' => $c['unique_ip'],
                'top_ip_share' => $c['top_ip_share_pct'],
                'load15' => $c['load15'],
                'old_state' => $c['state'],
                'new_state' => $newState,
                'reasons' => $detection['reasons'],
            ];
        }

        $this->printSummary($rows);
        $this->printOldSuspiciousComparison($rows);
        $this->printTopAnomalous($rows, (int) $this->option('top'));
        $this->printFocusWindow($rows, '16:0', '16:1');

        return self::SUCCESS;
    }

    private function parseLogFiles(array $files): array
    {
        $cycles = [];
        foreach ($files as $file) {
            foreach (file($file) as $line) {
                if (!preg_match('/^\[(.*?)\].*?(\{.*\})\s*$/', $line, $m)) {
                    continue;
                }
                $json = json_decode($m[2], true);
                if (!$json || !isset($json['attack_score'])) {
                    continue;
                }
                $json['_ts'] = $m[1];
                $cycles[] = $json;
            }
        }
        usort($cycles, fn ($a, $b) => strcmp($a['_ts'], $b['_ts']));
        return $cycles;
    }

    private function getBaselinesForHour(int $hour): array
    {
        $result = [];
        $minSigma = [
            'requests' => 15.0, 'unique_ip' => 4.0, 'top_ip_share' => 0.03,
            'top5_share' => 0.04, 'load15' => 0.4, 'http4xx_rate' => 0.02,
        ];

        foreach (array_keys($minSigma) as $metric) {
            $pooled = [];
            foreach ([$hour - 1, $hour, $hour + 1] as $h) {
                $h = ($h + 24) % 24;
                $pooled = array_merge($pooled, $this->hourBuckets[$metric][$h] ?? []);
            }

            $stats = RobustStats::compute($pooled, $minSigma[$metric]);
            if ($stats !== null && $stats['samples'] >= self::MIN_SAMPLES) {
                $stats['maturity'] = 'pooled_3h';
                $result[$metric] = $stats;
                continue;
            }

            $stats = RobustStats::compute($this->globalHistory[$metric] ?? [], $minSigma[$metric]);
            if ($stats !== null && $stats['samples'] >= self::MIN_SAMPLES) {
                $stats['maturity'] = 'global';
                $result[$metric] = $stats;
                continue;
            }

            $result[$metric] = null;
        }

        return $result;
    }

    private function pushSample(array $snapshot, int $hour, bool $isNormal): void
    {
        if (!$isNormal) {
            return;
        }

        $map = [
            'requests' => $snapshot['total_requests'],
            'unique_ip' => $snapshot['unique_ips'],
            'top_ip_share' => $snapshot['top_ip_share'],
            'top5_share' => $snapshot['top5_share'],
            'load15' => $snapshot['load15'],
            'http4xx_rate' => $snapshot['http4xx_rate'],
        ];

        foreach ($map as $metric => $value) {
            if ($value === null) {
                continue;
            }
            $this->hourBuckets[$metric][$hour][] = $value;
            if (count($this->hourBuckets[$metric][$hour]) > self::HOUR_BUCKET_CAP) {
                array_shift($this->hourBuckets[$metric][$hour]);
            }
            $this->globalHistory[$metric][] = $value;
            if (count($this->globalHistory[$metric]) > 1440) {
                array_shift($this->globalHistory[$metric]);
            }
        }
    }

    private function printSummary(array $rows): void
    {
        $n = count($rows);
        $oldStates = array_count_values(array_column($rows, 'old_state'));
        $newStates = array_count_values(array_column($rows, 'new_state'));

        $this->info("\n=== Порівняння станів (усього циклів: {$n}) ===");
        $this->table(['State', 'Old (v1)', 'New (v2)'], collect(['NORMAL', 'SUSPICIOUS', 'ATTACK'])->map(fn ($s) => [
            $s, $oldStates[$s] ?? 0, $newStates[$s] ?? 0,
        ]));

        $oldScores = array_column($rows, 'old_score');
        $newScores = array_column($rows, 'new_score');
        $this->line(sprintf(
            'old_score: max=%d avg=%.1f | new_score: max=%d avg=%.1f',
            max($oldScores), array_sum($oldScores) / $n,
            max($newScores), array_sum($newScores) / $n
        ));
    }

    private function printOldSuspiciousComparison(array $rows): void
    {
        $this->info("\n=== Усі старі SUSPICIOUS цикли (v1), як їх оцінює v2 ===");
        $old = array_filter($rows, fn ($r) => $r['old_state'] === 'SUSPICIOUS');
        $this->table(
            ['time', 'old_score', 'new_score', 'requests', 'unique_ip', 'top_ip_share%', 'load15', 'old_state', 'new_state'],
            collect($old)->map(fn ($r) => [
                $r['time'], $r['old_score'], $r['new_score'], $r['requests'],
                $r['unique_ip'], $r['top_ip_share'], $r['load15'], $r['old_state'], $r['new_state'],
            ])
        );
    }

    private function printTopAnomalous(array $rows, int $top): void
    {
        $sorted = $rows;
        usort($sorted, fn ($a, $b) => $b['new_score'] <=> $a['new_score']);
        $sorted = array_slice($sorted, 0, $top);

        $this->info("\n=== Топ-{$top} найаномальніших циклів за новою формулою ===");
        $this->table(
            ['time', 'old_score', 'new_score', 'requests', 'unique_ip', 'top_ip_share%', 'load15', 'old_state', 'new_state'],
            collect($sorted)->map(fn ($r) => [
                $r['time'], $r['old_score'], $r['new_score'], $r['requests'],
                $r['unique_ip'], $r['top_ip_share'], $r['load15'], $r['old_state'], $r['new_state'],
            ])
        );
        foreach (array_slice($sorted, 0, 3) as $r) {
            $this->line("  {$r['time']} (new_score={$r['new_score']}): " . implode(' | ', $r['reasons']));
        }
    }

    private function printFocusWindow(array $rows, string $fromPrefix, string $toPrefix): void
    {
        $this->info("\n=== Фокус: 16:0x-16:1x (проблемні цикли 16:01-16:02 з v1) ===");
        $window = array_filter($rows, fn ($r) => str_starts_with($r['time'], $fromPrefix) || str_starts_with($r['time'], $toPrefix));
        $this->table(
            ['time', 'old_score', 'new_score', 'requests', 'unique_ip', 'top_ip_share%', 'load15', 'old_state', 'new_state'],
            collect($window)->map(fn ($r) => [
                $r['time'], $r['old_score'], $r['new_score'], $r['requests'],
                $r['unique_ip'], $r['top_ip_share'], $r['load15'], $r['old_state'], $r['new_state'],
            ])
        );
        foreach ($window as $r) {
            if (str_starts_with($r['time'], '16:01') || str_starts_with($r['time'], '16:02')) {
                $this->line("  {$r['time']} (new_score={$r['new_score']}): " . implode(' | ', $r['reasons']));
            }
        }
    }
}
