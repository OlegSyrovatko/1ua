<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Єдина точка звернення до Cloudflare API. Кожен публічний метод ПЕРШИМ ділом
 * перевіряє monitor_only — якщо true, реального HTTP-запиту не буде взагалі,
 * лише запис у cloudflare-protection.log з описом, яку дію систему зробила б.
 *
 * Навмисно НЕ використовує глобальний "Under Attack" за замовчуванням.
 * Замість цього керує Security Level зони (essentially_off/medium/high/
 * under_attack) — це працює одразу, без попереднього ручного налаштування
 * будь-чого в Cloudflare dashboard. Under Attack Mode вмикається лише як
 * рівень security_level="under_attack" на стані ATTACK — це той самий режим,
 * просто керований через API замість dashboard-перемикача.
 *
 * Додатково, ЯКЩО в .env вказані CLOUDFLARE_RULESET_ID/CLOUDFLARE_RULE_ID
 * (custom rule з managed_challenge, який власник сайту створює вручну один
 * раз в Cloudflare dashboard — WAF → Custom rules, дію див. в README нижче),
 * сервіс також вмикає/вимикає саме це правило для стану SUSPICIOUS, не чіпаючи
 * security_level всього сайту. Якщо ці id не задані — цей крок просто
 * пропускається з логом, без помилки.
 */
class CloudflareProtectionService
{
    private const API_BASE = 'https://api.cloudflare.com/client/v4';

    public function __construct(
        private readonly bool $monitorOnly,
        private readonly ?string $apiToken,
        private readonly ?string $zoneId,
        private readonly ?string $rulesetId,
        private readonly ?string $ruleId,
    ) {
    }

    public function applyState(string $state): void
    {
        [$level, $ruleEnabled] = match ($state) {
            'ATTACK' => ['under_attack', true],
            'SUSPICIOUS' => ['high', true],
            default => ['medium', false],
        };

        // Обидва виклики виконуються незалежно: невдача одного (напр. мережева
        // помилка на security_level) не повинна тихо скасувати другий.
        $this->setSecurityLevel($level);
        $this->setCustomRuleEnabled($ruleEnabled);
    }

    private function setSecurityLevel(string $level): bool
    {
        $action = "PATCH /zones/{$this->maskedZone()}/settings/security_level -> \"{$level}\"";

        if ($this->monitorOnly) {
            Log::channel('cloudflare-protection')->info("MONITOR_ONLY: would run {$action}");
            return true;
        }

        if (!$this->apiToken || !$this->zoneId) {
            Log::channel('cloudflare-protection')->warning(
                "Cloudflare credentials missing, skipped: {$action}"
            );
            return false;
        }

        try {
            $response = Http::withToken($this->apiToken)
                ->timeout(10)
                ->patch(self::API_BASE . "/zones/{$this->zoneId}/settings/security_level", [
                    'value' => $level,
                ]);

            if (!$response->successful()) {
                Log::channel('cloudflare-protection')->error(
                    "Cloudflare API error on {$action}: HTTP {$response->status()}"
                );
                return false;
            }

            Log::channel('cloudflare-protection')->info("Applied: {$action}");
            return true;
        } catch (\Throwable $e) {
            // Token/секрети у виняток PHP не потрапляють — HTTP-клієнт кидає
            // повідомлення про мережеву помилку, не про вміст запиту/токен.
            Log::channel('cloudflare-protection')->error(
                "Cloudflare API exception on {$action}: {$e->getMessage()}"
            );
            return false;
        }
    }

    private function setCustomRuleEnabled(bool $enabled): bool
    {
        if (!$this->rulesetId || !$this->ruleId) {
            // Правило ще не створене в dashboard — це очікуваний стан на
            // MONITOR_ONLY етапі, не помилка.
            return true;
        }

        $action = sprintf(
            'PATCH /zones/%s/rulesets/%s/rules/%s -> enabled=%s',
            $this->maskedZone(),
            $this->rulesetId,
            $this->ruleId,
            $enabled ? 'true' : 'false'
        );

        if ($this->monitorOnly) {
            Log::channel('cloudflare-protection')->info("MONITOR_ONLY: would run {$action}");
            return true;
        }

        if (!$this->apiToken || !$this->zoneId) {
            Log::channel('cloudflare-protection')->warning(
                "Cloudflare credentials missing, skipped: {$action}"
            );
            return false;
        }

        try {
            $response = Http::withToken($this->apiToken)
                ->timeout(10)
                ->patch(
                    self::API_BASE . "/zones/{$this->zoneId}/rulesets/{$this->rulesetId}/rules/{$this->ruleId}",
                    ['enabled' => $enabled]
                );

            if (!$response->successful()) {
                Log::channel('cloudflare-protection')->error(
                    "Cloudflare API error on {$action}: HTTP {$response->status()}"
                );
                return false;
            }

            Log::channel('cloudflare-protection')->info("Applied: {$action}");
            return true;
        } catch (\Throwable $e) {
            Log::channel('cloudflare-protection')->error(
                "Cloudflare API exception on {$action}: {$e->getMessage()}"
            );
            return false;
        }
    }

    private function maskedZone(): string
    {
        if (!$this->zoneId) {
            return '{ZONE_NOT_CONFIGURED}';
        }

        return substr($this->zoneId, 0, 4) . '...';
    }
}
