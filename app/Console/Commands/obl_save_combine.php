<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App;

class obl_save_combine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obl_save_combine';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'obl_save_combine';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    private function isFileFromYesterday($filename)
    {
        if (!file_exists($filename)) {
            return false;
        }

        $fileDate = now()
            ->setTimestamp(filemtime($filename))
            ->toDateString();

        return $fileDate === now()->subDay()->toDateString();
    }

    private function extractTodayNewsSections($html)
    {
        preg_match_all(
            '~<section\b(?=[^>]*\bclass=("|\')[^"\']*\bim\b[^"\']*\1)[^>]*>.*?</section>~is',
            $html,
            $matches
        );

        $sections = [];

        foreach ($matches[0] as $section) {
            if (preg_match(
                '~<time\b(?=[^>]*\bclass=("|\')[^"\']*\bim-tm\b[^"\']*\1)[^>]*>\s*[^<]*:[^<]*\s*</time>~is',
                $section
            )) {
                $sections[] = trim($section);
            }
        }

        return $sections;
    }
    
    private function getStoredSectionInnerHtml($content)
    {
        $content = trim($content);

        if ($content === '') {
            return '';
        }

        // Новий формат: <article><noindex> ... </noindex></article>
        if (preg_match('~^\s*<article\b[^>]*>\s*<noindex\b[^>]*>(.*)</noindex>\s*</article>\s*$~is', $content, $match)) {
            return trim($match[1]);
        }

        // Старий формат: <section> ... </section>
        // Щоб старі файли автоматично перезаписались у новий формат
        if (preg_match('~^\s*<section\s*>(.*)</section>\s*$~is', $content, $match)) {
            return trim($match[1]);
        }

        // Якщо раніше у файлі був повний HTML — нормалізуємо його
        return trim(implode(PHP_EOL, $this->extractTodayNewsSections($content)));
    }

    private function extractNewsIds($html)
    {
        preg_match_all('~\bid=("|\')([^"\']+)\1~i', $html, $matches);

        $ids = [];

        foreach ($matches[2] as $id) {
            $ids[$id] = true;
        }

        return $ids;
    }

    private function extractSectionId($section)
    {
        if (preg_match('~\bid=("|\')([^"\']+)\1~i', $section, $match)) {
            return $match[2];
        }

        return null;
    }

    public function handle()
    {

        $regions = [
            1  => 'crimea',
            2  => 'lutsk',
            3  => 'vinnitsa',
            4  => 'dnepropetrovsk',
            5  => 'donetsk',
            6  => 'zhitomir',
            7  => 'uzhgorod',
            8  => 'zaporozhje',
            9  => 'ivano_frankovsk',
            10 => 'kiev',
            11 => 'kirovograd',
            12 => 'lvov',
            13 => 'lugansk',
            14 => 'nikolaev',
            15 => 'odessa',
            16 => 'poltava',
            17 => 'rovno',
            18 => 'sumy',
            19 => 'ternopol',
            20 => 'hmelnitskij',
            21 => 'kharkov',
            22 => 'herson',
            23 => 'chernovtsy',
            24 => 'cherkassy',
            25 => 'chernigov',
        ];

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.0 Safari/605.1.15',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0',
            'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',
        ];

        $keys = array_keys($regions);
        $hour = (int) date('G'); // година серверу VPS: 0-23

        $skipBefore20 = [
            1,  // crimea
            5,  // donetsk
            7,  // uzhgorod
            23, // chernovtsy
        ];

        $skipAt12And16 = [
            2,  // lutsk
            6,  // zhitomir
            8,  // zaporozhje
            9,  // ivano_frankovsk
            11, // kirovograd
            13, // lugansk
            14, // nikolaev
            15, // odessa
            16, // poltava
            17, // rovno
            18, // sumy
            19, // ternopol
            20, // hmelnitskij
            22, // herson
            24, // cherkassy
            25, // chernigov
        ];
        $keys = array_filter($keys, function ($id) use ($hour, $skipBefore20, $skipAt12And16) {
            // Ці регіони запускаємо тільки з 20:00
            if (in_array($id, $skipBefore20, true) && $hour < 20) {
                // \Log::info("SKIP region {$id}: before 20:00");
                return false;
            }

            // Ці регіони пропускаємо в годинах 12:00-12:59 та 16:00-16:59
            if (in_array($id, $skipAt12And16, true) && in_array($hour, [12, 16], true)) {
                // \Log::info("SKIP region {$id}: hour {$hour}:00");
                return false;
            }

            return true;
        });
        shuffle($keys);

        $dir = storage_path('app/public/obl_news');

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // \Log::info('Start downloading ukr.net regions');

        foreach ($keys as $id) {

            $city = $regions[$id];
            $filename = $dir . DIRECTORY_SEPARATOR . $id . '.html';
            $tmpFilename = $dir . DIRECTORY_SEPARATOR . $id . '.tmp.html';
            $userAgent = $userAgents[array_rand($userAgents)];

            // Якщо файл учорашній — очищаємо його до порожньої секції
            if ($this->isFileFromYesterday($filename)) {
                file_put_contents($filename, '<article><noindex></noindex></article>');
            }

            // \Log::info("Downloading {$city} ({$id})");

            $command = sprintf(
                'wget ' .
                '--user-agent=%s ' .
                '--referer=%s ' .
                '--header=%s ' .
                '--header=%s ' .
                '--timeout=30 ' .
                '--tries=2 ' .
                '-q ' .
                '-O %s %s 2>&1',
                escapeshellarg($userAgent),
                escapeshellarg('https://www.ukr.net/'),
                escapeshellarg('Accept-Language: uk-UA,uk;q=0.9,en;q=0.8'),
                escapeshellarg('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'),
                escapeshellarg($tmpFilename),
                escapeshellarg("https://www.ukr.net/news/{$city}.html")
            );

            $output = [];
            $returnCode = 0;

            exec($command, $output, $returnCode);

            clearstatcache();

            if (
                $returnCode === 0 &&
                file_exists($tmpFilename) &&
                filesize($tmpFilename) > 1000
            ) {
                $downloadedHtml = file_get_contents($tmpFilename);

                // Беремо тільки сьогоднішні новини, де час містить ":"
                $newSections = $this->extractTodayNewsSections($downloadedHtml);

                $currentContent = file_exists($filename)
                    ? file_get_contents($filename)
                    : '<article><noindex></noindex></article>';

                $currentInnerHtml = $this->getStoredSectionInnerHtml($currentContent);
                $existingIds = $this->extractNewsIds($currentInnerHtml);

                $added = 0;

                foreach ($newSections as $section) {
                    $newsId = $this->extractSectionId($section);

                    if ($newsId === null) {
                        continue;
                    }

                    // Якщо такий id уже є — не дублюємо
                    if (isset($existingIds[$newsId])) {
                        continue;
                    }

                    $currentInnerHtml .= ($currentInnerHtml === '' ? '' : PHP_EOL) . trim($section);
                    $existingIds[$newsId] = true;
                    $added++;
                }

                $finalContent = '<article><noindex>';

                if (trim($currentInnerHtml) !== '') {
                    $finalContent .= PHP_EOL . trim($currentInnerHtml) . PHP_EOL;
                }

                $finalContent .= '</noindex></article>';

                file_put_contents($filename, $finalContent);

                @unlink($tmpFilename);

                // \Log::info("OK {$city}", [
                //     'file' => basename($filename),
                //     'added' => $added,
                //     'size' => filesize($filename),
                // ]);

            } else {

                \Log::warning("FAILED {$city}", [
                    'code' => $returnCode,
                    'size' => file_exists($tmpFilename) ? filesize($tmpFilename) : 0,
                    'output' => implode("\n", $output),
                ]);
            }

            // Пауза 2-5 секунд
            if (random_int(1, 5) === 1) {
                usleep(random_int(7000000, 12000000));
            } else {
                usleep(random_int(2000000, 5000000));
            }
        }

        // \Log::info('All regions downloaded.');

        return Command::SUCCESS;
    }
}
