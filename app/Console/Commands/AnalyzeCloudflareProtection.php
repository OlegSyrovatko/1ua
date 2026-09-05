<?php

namespace App\Console\Commands;

use App\Services\AttackDetectionService;
use App\Services\BaselineRepository;
use App\Services\CloudflareProtectionService;
use App\Services\ProtectionStateService;
use App\Services\TrafficAnalyzer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Запускається щохвилини (Kernel.php), синхронно з ротацією ip.txt, яку ця
 * команда тепер і виконує (див. TrafficAnalyzer::rotateIpLog() — раніше цю
 * атомарну операцію робив delseeffile).
 *
 * MONITOR_ONLY (CLOUDFLARE_PROTECTION_MONITOR_ONLY, за замовчуванням true):
 * увесь аналіз, attack score і "рекомендований" стан рахуються по-справжньому,
 * але жодного реального виклику Cloudflare API не відбувається — замість
 * цього CloudflareProtectionService лише пише в лог, яку дію він би зробив.
 */
class AnalyzeCloudflareProtection extends Command
{
    protected $signature = 'protection:analyze';

    protected $description = 'Аналізує ip.txt + метрики сервера, рахує attack score (v2, погодинний baseline), керує Cloudflare protection (або лише логує в MONITOR_ONLY)';

    public function handle(): int
    {
        $log = Log::channel('cloudflare-protection');

        try {
            $analyzer = new TrafficAnalyzer(
                config('cloudflare_protection.ip_log_path'),
                config('cloudflare_protection.access_log_path'),
            );

            $raw = $analyzer->rotateIpLog();
            $parsed = $analyzer->parse($raw);
            $load = $analyzer->getLoadAverage();
            $httpDelta = $analyzer->getHttpStatusDelta();
            $cpuPercent = $analyzer->getCpuPercent();
            $memPercent = $analyzer->getMemoryPercent();
            $httpTotal = $httpDelta ? array_sum($httpDelta) : 0;

            $snapshot = $this->buildSnapshot($parsed, $load, $httpDelta, $httpTotal, $cpuPercent, $memPercent);

            $hour = (int) now()->format('G');
            $baselineRepo = new BaselineRepository(
                config('cloudflare_protection.history_size'),
                config('cloudflare_protection.baseline_min_samples'),
            );
            $baselines = $baselineRepo->getBaselineForHour($hour);

            $detection = (new AttackDetectionService())->score($snapshot, $baselines);

            $stateService = new ProtectionStateService(
                app(CloudflareProtectionService::class),
                $baselineRepo,
                config('cloudflare_protection.thresholds'),
                config('cloudflare_protection.hysteresis'),
                config('cloudflare_protection.telegram.notify'),
            );

            $decision = $stateService->decide($detection['score'], $snapshot);

            $this->logCycle($log, $snapshot, $baselines, $detection, $decision, $hour);
        } catch (\Throwable $e) {
            // Будь-яка несподівана помилка аналізу — це окремий стан "аналіз
            // недоступний", а НЕ підстава автоматично рахувати це атакою.
            $log->error('protection:analyze failed: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'trace_head' => substr($e->getTraceAsString(), 0, 500),
            ]);
            $this->error('Analyze failed: ' . $e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function buildSnapshot(array $parsed, array $load, ?array $httpDelta, int $httpTotal, ?float $cpuPercent, ?float $memPercent): array
    {
        $ipCounts = $parsed['ip_counts'];
        arsort($ipCounts);
        $topIp = array_key_first($ipCounts);
        $topIpRequests = $topIp !== null ? $ipCounts[$topIp] : 0;
        $top5Requests = array_sum(array_slice($ipCounts, 0, 5, true));

        $total = max(1, $parsed['total_requests']);
        $topIpShare = $topIpRequests / $total;
        $top5Share = $top5Requests / $total;

        [$worstUrl, $worstUrlRequests, $worstUrlIps] = $this->findWorstUrl($parsed['url_counts'], $parsed['url_ip_counts']);

        $http4xxRate = $httpTotal >= 20 ? ($httpDelta['4xx'] ?? 0) / $httpTotal : null;

        return [
            'total_requests' => $parsed['total_requests'],
            'unique_ips' => $parsed['unique_ips'],
            'top_ip' => $topIp,
            'top_ip_requests' => $topIpRequests,
            'top_ip_share' => round($topIpShare, 4),
            'top5_share' => round($top5Share, 4),
            'worst_url' => $worstUrl,
            'worst_url_requests' => $worstUrlRequests,
            'worst_url_unique_ips' => $worstUrlIps,
            'load15' => $load['load15'],
            'load5' => $load['load5'],
            'load1' => $load['load1'],
            'cpu_percent' => $cpuPercent,
            'mem_percent' => $memPercent,
            'http_5xx' => $httpDelta['5xx'] ?? 0,
            'http_4xx' => $httpDelta['4xx'] ?? 0,
            'http_total' => $httpTotal,
            'http4xx_rate' => $http4xxRate !== null ? round($http4xxRate, 4) : null,
        ];
    }

    /**
     * @return array{0:?string,1:int,2:int} [url, requests, unique_ips]
     */
    private function findWorstUrl(array $urlCounts, array $urlIpCounts): array
    {
        $worstUrl = null;
        $worstRatio = 0;
        $worstRequests = 0;
        $worstIps = 0;

        foreach ($urlCounts as $url => $requests) {
            if ($requests < 20) {
                continue;
            }
            $ipsOnUrl = count($urlIpCounts[$url] ?? []);
            if ($ipsOnUrl === 0) {
                continue;
            }
            $ratio = $requests / $ipsOnUrl;
            if ($ratio > $worstRatio) {
                $worstRatio = $ratio;
                $worstUrl = $url;
                $worstRequests = $requests;
                $worstIps = $ipsOnUrl;
            }
        }

        return [$worstUrl, $worstRequests, $worstIps];
    }

    private function logCycle($log, array $snapshot, array $baselines, array $detection, array $decision, int $hour): void
    {
        $monitorOnly = config('cloudflare_protection.monitor_only');

        $baselineSummary = [];
        foreach ($baselines as $metric => $b) {
            $baselineSummary[$metric] = $b === null
                ? 'immature'
                : sprintf('%.1f (%s, n=%d)', $b['median'], $b['maturity'], $b['samples']);
        }

        $context = [
            'hour' => $hour,
            'requests_per_min' => $snapshot['total_requests'],
            'unique_ip' => $snapshot['unique_ips'],
            'top_ip' => $snapshot['top_ip'],
            'top_ip_requests' => $snapshot['top_ip_requests'],
            'top_ip_share_pct' => round($snapshot['top_ip_share'] * 100, 1),
            'top5_share_pct' => round($snapshot['top5_share'] * 100, 1),
            'worst_url' => $snapshot['worst_url'],
            'worst_url_requests' => $snapshot['worst_url_requests'],
            'worst_url_unique_ips' => $snapshot['worst_url_unique_ips'],
            'baseline' => $baselineSummary,
            'load15' => $snapshot['load15'],
            'cpu_percent' => $snapshot['cpu_percent'],
            'mem_percent' => $snapshot['mem_percent'],
            'http_4xx' => $snapshot['http_4xx'],
            'http_5xx' => $snapshot['http_5xx'],
            'http_total' => $snapshot['http_total'],
            'attack_score' => $detection['score'],
            'components' => $detection['components'],
            'reasons' => $detection['reasons'],
            'previous_state' => $decision['previous_state'],
            'state' => $decision['state'],
            'transitioned' => $decision['transitioned'],
            'monitor_only' => $monitorOnly,
        ];

        $line = sprintf(
            'requests/min=%d unique_ip=%d top_ip_share=%.1f%% attack_score=%d state=%s%s',
            $snapshot['total_requests'],
            $snapshot['unique_ips'],
            $snapshot['top_ip_share'] * 100,
            $detection['score'],
            $decision['state'],
            $decision['transitioned'] ? " (CHANGED from {$decision['previous_state']})" : ''
        );

        if ($decision['transitioned']) {
            $action = $monitorOnly
                ? 'would ' . ($decision['state'] === 'NORMAL' ? 'restore normal Cloudflare settings' : 'enable Cloudflare protection')
                : ($decision['state'] === 'NORMAL' ? 'restored normal Cloudflare settings' : 'enabled Cloudflare protection');
            $log->warning($line . " | ACTION: {$action}", $context);
        } else {
            $log->info($line, $context);
        }

        $this->line($line);
    }
}
