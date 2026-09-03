<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class hero_build extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hero_build {--pool-only : лише era-pool, не чіпаючи знімок/cooldown трендів}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Перебудова даних для hero-блоку головної сторінки: (1) добірка фото за рейтингом,
        розбита по епохах, щоб пік оцінок 2011-2013 не витісняв назавжди фото пізніших років;
        (2) список "найпопулярніше за добу" за приростом переглядів, з cooldown 30 днів на фото,
        щоб воно не залипало в списку. Друга частина рахує приріст від попереднього запуску команди,
        тому має виконуватись лише за розкладом — див. --pool-only.';

    private const COOLDOWN_DAYS = 30;
    private const TRENDING_CANDIDATES = 5000;
    private const ERA_RANGES = [
        ['2005-01-01', '2010-12-31'],
        ['2011-01-01', '2013-12-31'],
        ['2014-01-01', '2017-12-31'],
        ['2018-01-01', '2021-12-31'],
        ['2022-01-01', '2100-01-01'],
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $excludedIds = $this->readList('hero_excluded_photos.txt');

        $this->buildEraPool($excludedIds);

        if ($this->option('pool-only')) {
            // знімок/cooldown трендів не чіпаємо (щоб не збивати "годинник" приросту переглядів),
            // але щойно приховане фото все одно має одразу зникнути з уже готового списку трендів
            $this->pruneTrendingResult($excludedIds);
            $this->info('Hero era-pool rebuilt (trending snapshot untouched).');
            return;
        }

        $this->buildTrending($excludedIds);

        $this->info('Hero data rebuilt.');
    }

    private function readList(string $file): array
    {
        $path = storage_path('app/public/' . $file);
        if (!file_exists($path)) {
            return [];
        }

        return array_filter(explode(',', file_get_contents($path)));
    }

    private function readJson(string $file, $default)
    {
        $path = storage_path('app/public/' . $file);
        if (!file_exists($path)) {
            return $default;
        }

        $data = json_decode(file_get_contents($path), true);

        return $data === null ? $default : $data;
    }

    private function pruneTrendingResult(array $excludedIds): void
    {
        if (count($excludedIds) === 0) {
            return;
        }

        $current = $this->readJson('hero_trending_result.json', []);
        if (count($current) === 0) {
            return;
        }

        $filtered = array_values(array_filter($current, function ($row) use ($excludedIds) {
            return !in_array((string) $row['Namef'], $excludedIds);
        }));

        if (count($filtered) !== count($current)) {
            Storage::disk('public')->put('hero_trending_result.json', json_encode($filtered));
        }
    }

    private function buildEraPool(array $excludedIds): void
    {
        $seenCities = [];
        $picked = [];

        foreach (self::ERA_RANGES as $range) {
            $rows = DB::table('Foto')
                ->select('Namef', 'City', 'Fd', 'Formf', 'w', 'h', 'avt', 'id')
                ->where('w', '>', 400)
                ->where('h', '>', 300)
                ->whereBetween('Fd', $range)
                ->when(count($excludedIds) > 0, function ($query) use ($excludedIds) {
                    return $query->whereNotIn('Namef', $excludedIds);
                })
                ->orderBy('r_gol', 'desc')
                ->limit(80)
                ->get();

            foreach ($rows as $row) {
                if (isset($seenCities[$row->City])) {
                    continue;
                }
                $seenCities[$row->City] = true;
                $picked[] = $row;
            }
        }

        Storage::disk('public')->put('hero_photos_pool.json', json_encode(array_values($picked)));
    }

    private function buildTrending(array $excludedIds): void
    {
        $today = now()->toDateString();

        $candidates = DB::table('Foto')
            ->select('Namef', 'City', 'Fd', 'Formf', 'w', 'h', 'avt', 'id', 'views')
            ->where('w', '>', 400)
            ->where('h', '>', 300)
            ->when(count($excludedIds) > 0, function ($query) use ($excludedIds) {
                return $query->whereNotIn('Namef', $excludedIds);
            })
            ->orderBy('views', 'desc')
            ->limit(self::TRENDING_CANDIDATES)
            ->get()
            ->keyBy('Namef');

        $previousSnapshot = $this->readJson('hero_trending_snapshot.json', []);
        $cooldown = $this->readJson('hero_trending_cooldown.json', []);

        // прибираємо записи cooldown, старші за 30 днів
        $cooldown = array_filter($cooldown, function ($date) use ($today) {
            return (strtotime($today) - strtotime($date)) < self::COOLDOWN_DAYS * 86400;
        });

        $deltas = [];
        foreach ($candidates as $namef => $row) {
            $prevViews = $previousSnapshot[$namef] ?? $row->views;
            $delta = $row->views - $prevViews;
            if ($delta > 0 && !isset($cooldown[$namef])) {
                $deltas[$namef] = $delta;
            }
        }
        arsort($deltas);

        $seenCities = [];
        $picked = [];
        foreach ($deltas as $namef => $delta) {
            $row = $candidates[$namef];
            if (isset($seenCities[$row->City])) {
                continue;
            }
            $seenCities[$row->City] = true;
            $row->delta = $delta;
            $picked[] = $row;
            $cooldown[(string) $namef] = $today;
            if (count($picked) >= 8) {
                break;
            }
        }

        Storage::disk('public')->put('hero_trending_result.json', json_encode(array_values($picked)));
        Storage::disk('public')->put('hero_trending_cooldown.json', json_encode($cooldown));

        $newSnapshot = [];
        foreach ($candidates as $namef => $row) {
            $newSnapshot[$namef] = $row->views;
        }
        Storage::disk('public')->put('hero_trending_snapshot.json', json_encode($newSnapshot));
    }
}
