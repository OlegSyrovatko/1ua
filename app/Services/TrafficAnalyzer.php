<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

/**
 * Читає той самий storage/app/public/ip.txt, який на кожен запит дописує
 * layouts/app.blade.php (fopen 'a' + flock(LOCK_EX)) — це напряму лічильник
 * усього трафіку сайту за останню ~хвилину, без жодного окремого збору IP.
 *
 * Раніше атомарне "прочитати все + обнулити" робив delseeffile (Kernel.php,
 * кожну хвилину): він рахував лише nip/nip_google і писав короткий заголовок
 * "nip X nip_google Y#" назад у файл. Цей заголовок читають:
 *  - layouts/app.blade.php:603 (адмінська підказка над сайтом для id=72372396);
 *  - AddScriptController::up_vote()/up_votec() (грубий анти-дубль-голос: чи це
 *    IP+URL вже зустрічались у поточному буфері).
 * Обидва мають лишитись робочими 1:1, тому rotate() тут відтворює той самий
 * формат заголовка. delseeffile.php більше не чіпає ip.txt (щоб не було двох
 * процесів, які одночасно truncate'ять один і той же файл) — всю атомарну
 * операцію тепер виконує лише цей клас, з одним flock на весь час читання.
 */
class TrafficAnalyzer
{
    private const REDIS_PREFIX = 'cfprot:';

    public function __construct(
        private readonly string $ipLogPath,
        private readonly string $accessLogPath,
    ) {
    }

    /**
     * Атомарно вичитує ip.txt, одразу обнуляє його і лишає легасі-заголовок
     * "nip X nip_google Y#" — так само, як раніше робив delseeffile.
     * Повертає сирий вміст файлу ДО обнулення (те, що реально накопичилось
     * за останню хвилину).
     */
    public function rotateIpLog(): string
    {
        $fp = @fopen($this->ipLogPath, 'c+');

        if (!$fp) {
            // Немає доступу до файлу — це стан "дані недоступні", а не атака.
            // Кидати exception тут не можна: одна відсутня flock-точка не повинна
            // валити весь цикл аналізу.
            return '';
        }

        try {
            flock($fp, LOCK_EX);
            rewind($fp);
            $raw = stream_get_contents($fp) ?: '';

            $nip = substr_count($raw, ' ');
            $nipGoogle = substr_count($raw, '66.249.');
            $header = "nip {$nip} nip_google {$nipGoogle}#";

            ftruncate($fp, 0);
            rewind($fp);
            fwrite($fp, $header);
            fflush($fp);
        } finally {
            flock($fp, LOCK_UN);
            fclose($fp);
        }

        return $raw;
    }

    /**
     * Стійкий парсер "IP URL IP URL ...". Не довіряє формату: пропускає токени,
     * які не є валідною IP (замість падати чи зсувати всі наступні пари),
     * ігнорує незавершену останню пару (URL міг не встигнути дописатись).
     *
     * @return array{
     *   total_requests: int,
     *   unique_ips: int,
     *   ip_counts: array<string,int>,
     *   url_counts: array<string,int>,
     *   url_ip_counts: array<string,array<string,int>>,
     * }
     */
    public function parse(string $raw): array
    {
        $result = [
            'total_requests' => 0,
            'unique_ips' => 0,
            'ip_counts' => [],
            'url_counts' => [],
            'url_ip_counts' => [],
        ];

        if ($raw === '') {
            return $result;
        }

        $tokens = preg_split('/\s+/', trim($raw), -1, PREG_SPLIT_NO_EMPTY);
        if (!$tokens) {
            return $result;
        }

        $count = count($tokens);
        $i = 0;

        while ($i < $count - 1) {
            $ip = $tokens[$i];

            if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                // Токен на місці IP не є IP (пошкоджений рядок, зсув через
                // одночасний запис) — пропускаємо один токен і пробуємо знову,
                // а не викидаємо exception і не зупиняємо парсинг.
                $i++;
                continue;
            }

            $url = $tokens[$i + 1];
            // URL теж може виявитись валідною IP, якщо попередній запис був
            // неповним (втрачений URL) — тоді це насправді "IP IP", і другий
            // токен трактуємо як окремий новий запис, а не як чиюсь URL.
            if (filter_var($url, FILTER_VALIDATE_IP)) {
                $i++;
                continue;
            }

            $url = mb_substr($url, 0, 512);

            $result['total_requests']++;
            $result['ip_counts'][$ip] = ($result['ip_counts'][$ip] ?? 0) + 1;
            $result['url_counts'][$url] = ($result['url_counts'][$url] ?? 0) + 1;
            $result['url_ip_counts'][$url][$ip] = ($result['url_ip_counts'][$url][$ip] ?? 0) + 1;

            $i += 2;
        }

        $result['unique_ips'] = count($result['ip_counts']);

        return $result;
    }

    /**
     * CPU% без блокуючого usleep: беремо дельту /proc/stat між цим і минулим
     * циклом (минулий знімок лежить у Redis, цикли й так ~60с одна від одної).
     */
    public function getCpuPercent(): ?float
    {
        $stat = @file_get_contents('/proc/stat');
        if ($stat === false || !preg_match('/^cpu\s+(.+)$/m', $stat, $m)) {
            return null;
        }

        $parts = array_map('intval', preg_split('/\s+/', trim($m[1])));
        if (count($parts) < 4) {
            return null;
        }

        $idle = $parts[3] + ($parts[4] ?? 0); // idle + iowait
        $total = array_sum($parts);

        $prevKey = self::REDIS_PREFIX . 'proc_stat_prev';
        $prev = Redis::get($prevKey);
        Redis::setex($prevKey, 300, "{$idle}:{$total}");

        if (!$prev) {
            return null; // перший запуск — ще нема з чим порівнювати
        }

        [$prevIdle, $prevTotal] = array_map('intval', explode(':', $prev));
        $totalDelta = $total - $prevTotal;
        $idleDelta = $idle - $prevIdle;

        if ($totalDelta <= 0) {
            return null;
        }

        return round((1 - $idleDelta / $totalDelta) * 100, 1);
    }

    public function getMemoryPercent(): ?float
    {
        $mem = @file_get_contents('/proc/meminfo');
        if ($mem === false) {
            return null;
        }

        if (!preg_match('/MemTotal:\s+(\d+)/', $mem, $total)
            || !preg_match('/MemAvailable:\s+(\d+)/', $mem, $avail)) {
            return null;
        }

        $totalKb = (int) $total[1];
        $availKb = (int) $avail[1];

        if ($totalKb <= 0) {
            return null;
        }

        return round((1 - $availKb / $totalKb) * 100, 1);
    }

    public function getLoadAverage(): array
    {
        $load = sys_getloadavg();

        return [
            'load1' => round($load[0], 2),
            'load5' => round($load[1], 2),
            'load15' => round($load[2], 2),
        ];
    }

    /**
     * Дельта 2xx/4xx/5xx з Apache access-логу цього vhost'у з минулого циклу.
     * Читає лише новододані байти (offset у Redis), а не весь файл щоразу.
     * Ротація логу (logrotate) виявляється через зменшення розміру файлу.
     */
    public function getHttpStatusDelta(): ?array
    {
        if (!is_readable($this->accessLogPath)) {
            return null;
        }

        $size = @filesize($this->accessLogPath);
        if ($size === false) {
            return null;
        }

        $offsetKey = self::REDIS_PREFIX . 'access_log_offset';
        $offset = (int) (Redis::get($offsetKey) ?? $size);

        if ($offset > $size) {
            // Логротейт — файл менший, ніж збережений offset. Читаємо з початку.
            $offset = 0;
        }

        // Захист від разового величезного вичитування після простою/деплою.
        $maxBytes = 5 * 1024 * 1024;
        if ($size - $offset > $maxBytes) {
            $offset = $size - $maxBytes;
        }

        $bytesToRead = $size - $offset;
        $counts = ['2xx' => 0, '4xx' => 0, '5xx' => 0, 'other' => 0];

        if ($bytesToRead > 0) {
            $fp = @fopen($this->accessLogPath, 'rb');
            if (!$fp) {
                return null;
            }

            fseek($fp, $offset);
            $chunk = fread($fp, $bytesToRead) ?: '';
            fclose($fp);

            if (preg_match_all('/"\s(\d{3})\s\d+\s/', $chunk, $matches)) {
                foreach ($matches[1] as $status) {
                    $group = match (true) {
                        $status[0] === '2' => '2xx',
                        $status[0] === '4' => '4xx',
                        $status[0] === '5' => '5xx',
                        default => 'other',
                    };
                    $counts[$group]++;
                }
            }
        }

        Redis::setex($offsetKey, 3600, (string) $size);

        return $counts;
    }
}
