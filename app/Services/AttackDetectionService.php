<?php

namespace App\Services;

/**
 * V2: оцінює АНОМАЛІЮ (відхилення від власного погодинного baseline сайту),
 * а не абсолютні пороги. Причина переписування: перші 346 циклів моніторингу
 * показали, що постійний фоновий бот (~30-50% трафіку цілодобово) та звичний
 * пік load15≈5 щоразу тягнули score майже до порогу SUSPICIOUS — це "нормальна
 * форма" трафіку САМЕ ЦЬОГО сайту, не ознака атаки.
 *
 * Кожен компонент, включно з нульовими, завжди присутній у reasons — щоб було
 * видно НЕ ЛИШЕ що підняло score, а й що явно перевірили й визнали нормою.
 *
 * Напрямок аномалії свідомо різний по метриках: для requests/top_ip_share/
 * top5_share/load15/4xx-rate підозріле лише ЗРОСТАННЯ понад типове; для
 * unique_ip підозріле лише ПАДІННЯ (той самий обсяг трафіку з меншої кількості
 * відвідувачів, ніж зазвичай для цієї години) — зростання unique_ip саме по
 * собі ніколи не карається (інакше "вірусний" день з напливом нових
 * відвідувачів вважався б атакою).
 */
class AttackDetectionService
{
    // Максимальна вага кожного компонента. Сума = 100.
    private const MAX_POINTS = [
        'requests' => 22,
        'unique_ip' => 8,
        'top_ip_share' => 22,
        'top5_share' => 13,
        'url_concentration' => 13,
        'load15' => 12,
        'http4xx_rate' => 10,
    ];

    private const LABELS = [
        'requests' => 'requests/min anomaly',
        'unique_ip' => 'unique IP anomaly (fewer than usual)',
        'top_ip_share' => 'top IP anomaly',
        'top5_share' => 'top 5 IP anomaly',
        'load15' => 'load anomaly',
        'http4xx_rate' => '4xx rate anomaly',
    ];

    /**
     * @param array $snapshot total_requests, unique_ips, top_ip_share (0-1),
     *              top5_share (0-1), load15, http4xx_rate (0-1|null),
     *              worst_url, worst_url_requests, worst_url_unique_ips
     * @param array $baselines Результат BaselineRepository::getBaselineForHour()
     *              (або еквівалент з backtest) — по кожній метриці з
     *              AttackDetectionService::MAX_POINTS ключем, крім url_concentration.
     */
    public function score(array $snapshot, array $baselines): array
    {
        $reasons = [];
        $score = 0;
        $componentPoints = [];

        [$reqPoints, $reqNote] = $this->anomaly(
            $snapshot['total_requests'],
            $baselines['requests'] ?? null,
            self::MAX_POINTS['requests'],
            'high'
        );
        $componentPoints['requests'] = $reqPoints;
        $reasons[] = $this->formatReason('requests', $reqPoints, $reqNote, $snapshot['total_requests'], $baselines['requests'] ?? null);

        [$uniqPoints, $uniqNote] = $this->anomaly(
            $snapshot['unique_ips'],
            $baselines['unique_ip'] ?? null,
            self::MAX_POINTS['unique_ip'],
            'low'
        );
        $componentPoints['unique_ip'] = $uniqPoints;
        $reasons[] = $this->formatReason('unique_ip', $uniqPoints, $uniqNote, $snapshot['unique_ips'], $baselines['unique_ip'] ?? null);

        [$topIpPoints, $topIpNote] = $this->anomaly(
            $snapshot['top_ip_share'],
            $baselines['top_ip_share'] ?? null,
            self::MAX_POINTS['top_ip_share'],
            'high'
        );
        $componentPoints['top_ip_share'] = $topIpPoints;
        $reasons[] = $this->formatReason('top_ip_share', $topIpPoints, $topIpNote, $snapshot['top_ip_share'], $baselines['top_ip_share'] ?? null, true);

        [$top5Points, $top5Note] = $this->anomaly(
            $snapshot['top5_share'],
            $baselines['top5_share'] ?? null,
            self::MAX_POINTS['top5_share'],
            'high'
        );
        $componentPoints['top5_share'] = $top5Points;
        $reasons[] = $this->formatReason('top5_share', $top5Points, $top5Note, $snapshot['top5_share'], $baselines['top5_share'] ?? null, true);

        // URL-концентрація лишається структурним (не baseline) показником:
        // це не тренд у часі, а форма ОДНОГО циклу — багато запитів на URL від
        // малої кількості IP видно одразу, без потреби в історії. Жодного
        // false positive на цьому компоненті в перших 346 циклах не було.
        $worstRatio = ($snapshot['worst_url_unique_ips'] ?? 0) > 0
            ? $snapshot['worst_url_requests'] / $snapshot['worst_url_unique_ips']
            : 0;
        $urlPoints = match (true) {
            $worstRatio >= 50 => 13,
            $worstRatio >= 20 => 9,
            $worstRatio >= 10 => 4,
            default => 0,
        };
        $componentPoints['url_concentration'] = $urlPoints;
        $reasons[] = $urlPoints > 0
            ? sprintf(
                '+%d URL concentration: %s got %d requests from only %d IP (%.0f req/IP)',
                $urlPoints,
                $snapshot['worst_url'],
                $snapshot['worst_url_requests'],
                $snapshot['worst_url_unique_ips'],
                $worstRatio
            )
            : '+0 URL concentration (normal)';

        [$loadPoints, $loadNote] = $this->anomaly(
            $snapshot['load15'],
            $baselines['load15'] ?? null,
            self::MAX_POINTS['load15'],
            'high'
        );
        // Високий load сам по собі не є ознакою атаки (п.2 запиту) — рахуємо
        // його лише якщо є ЩЕ ХОЧА Б ОДИН компонент з ненульовими балами.
        $otherPointsSoFar = $reqPoints + $uniqPoints + $topIpPoints + $top5Points + $urlPoints;
        if ($loadPoints > 0 && $otherPointsSoFar === 0) {
            $loadNote = 'no corroborating signal';
            $loadPoints = 0;
        }
        $componentPoints['load15'] = $loadPoints;
        $reasons[] = $this->formatReason('load15', $loadPoints, $loadNote, $snapshot['load15'], $baselines['load15'] ?? null);

        [$httpPoints, $httpNote] = $this->anomaly(
            $snapshot['http4xx_rate'],
            $baselines['http4xx_rate'] ?? null,
            self::MAX_POINTS['http4xx_rate'],
            'high'
        );
        $componentPoints['http4xx_rate'] = $httpPoints;
        $reasons[] = $this->formatReason('http4xx_rate', $httpPoints, $httpNote, $snapshot['http4xx_rate'], $baselines['http4xx_rate'] ?? null, true);

        $score = min(100, array_sum($componentPoints));

        return [
            'score' => $score,
            'reasons' => $reasons,
            'components' => $componentPoints,
            'top_ip_share' => $snapshot['top_ip_share'],
            'top5_share' => $snapshot['top5_share'],
        ];
    }

    /**
     * @return array{0:int,1:string} [бали, короткий стан для reason-тексту]
     */
    private function anomaly(?float $value, ?array $baseline, int $maxPoints, string $direction): array
    {
        if ($value === null) {
            return [0, 'no data'];
        }

        if ($baseline === null) {
            return [0, 'learning'];
        }

        $z = RobustStats::zScore($value, $baseline);

        if (($direction === 'high' && $z <= 0) || ($direction === 'low' && $z >= 0)) {
            return [0, 'normal'];
        }

        $absZ = abs($z);
        $pct = match (true) {
            $absZ >= 4.0 => 1.0,
            $absZ >= 2.5 => 0.6,
            $absZ >= 1.5 => 0.3,
            default => 0.0,
        };

        return [(int) round($maxPoints * $pct), sprintf('z=%.1f', $absZ)];
    }

    private function formatReason(
        string $metric,
        int $points,
        string $note,
        ?float $value,
        ?array $baseline,
        bool $asPercent = false
    ): string {
        $label = self::LABELS[$metric];

        if ($points > 0) {
            $valueStr = $asPercent ? round($value * 100) . '%' : $value;
            $medianStr = $asPercent ? round($baseline['median'] * 100) . '%' : $baseline['median'];
            return "+{$points} {$label} ({$note}, {$valueStr} vs baseline {$medianStr} for this hour)";
        }

        return match ($note) {
            'learning' => "+0 {$label} (baseline learning)",
            'no data' => "+0 {$label} (no data)",
            'no corroborating signal' => "+0 {$label} (no corroborating signal)",
            default => "+0 {$label} (normal for this hour)",
        };
    }
}
