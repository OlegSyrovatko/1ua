<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

/**
 * Погодинний baseline (24 buckets) для метрик трафіку, з поступовим навчанням
 * і швидким fallback'ом там, де даних ще замало.
 *
 * Кожна година завжди дивиться на ПУЛ із трьох сусідніх годин (h-1, h, h+1),
 * а не лише на "свій" bucket — це і є розв'язання проблеми стрибка на межі
 * 13:59→14:00 (п.11 запиту): сусідні години перекриваються на 2/3, тому
 * baseline змінюється плавно, а не крок-функцією. Якщо навіть пулу з 3 годин
 * замало (перші дні роботи) — падаємо до глобальної історії (усі години
 * разом, останні ~24 год), а якщо і того замало — компонент вважається
 * "immature" і не додає балів (а не вигадує сигнал з повітря).
 *
 * У baseline потрапляють ТІЛЬКИ зразки з циклів, які самі отримали стан
 * NORMAL (isNormal=false для SUSPICIOUS/ATTACK повністю виключає зразок) —
 * це і є захист від "навчання атаки" (п.6 запиту): тривала атака не встигає
 * стати "новою нормою", бо поки вона триває, її дані просто не пишуться в
 * baseline.
 */
class BaselineRepository
{
    private const HOUR_BUCKET_CAP = 1000;    // ~16 днів по 60 хвилинних зразків/год
    private const GLOBAL_HISTORY_KEY = 'cfprot:history';

    public const METRICS = ['requests', 'unique_ip', 'top_ip_share', 'top5_share', 'load15', 'http4xx_rate'];

    // Нижня межа "робастної сигми" на метрику — щоб на дуже стабільних величинах
    // (MAD≈0, наприклад top_ip_share тижнями тримається в межах 1-2 п.п.)
    // випадковий шум не роздувався у величезний z-score.
    private const MIN_SIGMA = [
        'requests' => 15.0,       // запитів/хв
        'unique_ip' => 4.0,       // унікальних IP
        'top_ip_share' => 0.03,   // 3 в.п. частки
        'top5_share' => 0.04,     // 4 в.п. частки
        'load15' => 0.4,
        'http4xx_rate' => 0.02,   // 2 в.п. частки 4xx
    ];

    public function __construct(
        private readonly int $historySize,
        private readonly int $minSamplesPerBucket,
    ) {
    }

    /**
     * @return array<string, array{median:float,sigma:float,samples:int,maturity:string}|null>
     */
    public function getBaselineForHour(int $hour): array
    {
        $result = [];

        foreach (self::METRICS as $metric) {
            $result[$metric] = $this->resolveMetricBaseline($metric, $hour);
        }

        return $result;
    }

    private function resolveMetricBaseline(string $metric, int $hour): ?array
    {
        $pooled = [];
        foreach ([$hour - 1, $hour, $hour + 1] as $h) {
            $h = ($h + 24) % 24;
            $pooled = array_merge($pooled, $this->readBucket($metric, $h));
        }

        $stats = RobustStats::compute($pooled, self::MIN_SIGMA[$metric]);
        if ($stats !== null && $stats['samples'] >= $this->minSamplesPerBucket) {
            $stats['maturity'] = 'pooled_3h';
            return $stats;
        }

        // Fallback: глобальна історія (усі години разом, останні ~24 год) —
        // рятує перші години роботи системи, поки погодинні відра ще порожні.
        $global = $this->readGlobalHistory($metric);
        $stats = RobustStats::compute($global, self::MIN_SIGMA[$metric]);
        if ($stats !== null && $stats['samples'] >= $this->minSamplesPerBucket) {
            $stats['maturity'] = 'global';
            return $stats;
        }

        return null; // "immature" — компонент, що це використовує, дає 0 балів
    }

    /**
     * @param array<string,float|null> $metrics ['requests'=>.., 'unique_ip'=>.., ...]
     */
    public function pushSample(array $metrics, int $hour, bool $isNormal): void
    {
        if (!$isNormal) {
            return;
        }

        foreach (self::METRICS as $metric) {
            if (!array_key_exists($metric, $metrics) || $metrics[$metric] === null) {
                continue;
            }

            $key = $this->bucketKey($metric, $hour);
            Redis::rpush($key, $metrics[$metric]);
            Redis::ltrim($key, -self::HOUR_BUCKET_CAP, -1);
            Redis::expire($key, 60 * 60 * 24 * 30);
        }

        Redis::rpush(self::GLOBAL_HISTORY_KEY, json_encode(array_merge($metrics, ['ts' => now()->timestamp])));
        Redis::ltrim(self::GLOBAL_HISTORY_KEY, -$this->historySize, -1);
    }

    private function readBucket(string $metric, int $hour): array
    {
        $raw = Redis::lrange($this->bucketKey($metric, $hour), 0, -1) ?: [];
        return array_map('floatval', $raw);
    }

    private function readGlobalHistory(string $metric): array
    {
        $raw = Redis::lrange(self::GLOBAL_HISTORY_KEY, 0, -1) ?: [];
        $values = [];

        foreach ($raw as $entry) {
            $decoded = json_decode($entry, true);
            if (is_array($decoded) && isset($decoded[$metric])) {
                $values[] = (float) $decoded[$metric];
            }
        }

        return $values;
    }

    private function bucketKey(string $metric, int $hour): string
    {
        return "cfprot:baseline:hour:{$hour}:{$metric}";
    }
}
