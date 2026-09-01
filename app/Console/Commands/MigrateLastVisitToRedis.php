<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class MigrateLastVisitToRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'last_visit:migrate-redis {--dry-run : Preview counts without writing to Redis or touching files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One-time backfill of storage/last_visit/*.txt into Redis hashes (last_visit:{id}), using file mtime as the ts field';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dryRun = (bool) $this->option('dry-run');
        $dir = storage_path('app/public/last_visit');
        $files = glob($dir . '/*.txt');

        if (!$files) {
            $this->info('No files found in ' . $dir);
            return 0;
        }

        $bar = $this->output->createProgressBar(count($files));
        $bar->start();

        $migrated = 0;
        $emptySkipped = 0;
        $nonUserSkipped = 0;
        $keptFresher = 0;
        $errors = 0;

        foreach ($files as $path) {
            $id = basename($path, '.txt');

            if (!ctype_digit($id)) {
                // e.g. default.txt (template copied for new users) — not a real user id
                $nonUserSkipped++;
                $bar->advance();
                continue;
            }

            try {
                $contents = file_get_contents($path);

                if ($contents === false || $contents === '') {
                    $emptySkipped++;
                } else {
                    $records = explode('#!:*&', $contents);
                    array_shift($records);

                    $im = $records[0] ?? '';
                    $priz = $records[1] ?? '';
                    $avatar = $records[2] ?? '';
                    $lang = $records[3] ?? '';
                    $uri = $records[4] ?? '';
                    $avH = $records[5] ?? null;
                    $avW = $records[6] ?? null;
                    $ts = filemtime($path) ?: time();

                    // Fresher dual-write data (Phase 1, live traffic) already in Redis
                    // must not be clobbered by this backfill of historical file data.
                    $existingTs = $dryRun ? null : Redis::hget("last_visit:$id", 'ts');

                    if ($existingTs !== null && (int) $existingTs >= $ts) {
                        $keptFresher++;
                    } else {
                        if (!$dryRun) {
                            last_visit_write($id, $im, $priz, $avatar, $lang, $uri, $avH, $avW, $ts);
                        }
                        $migrated++;
                    }
                }

                if (!$dryRun) {
                    rename($path, $path . '.migrated');
                }
            } catch (\Throwable $e) {
                $errors++;
                $this->newLine();
                $this->error("Failed on $path: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info(($dryRun ? '[dry-run] ' : '') . "Migrated: $migrated, kept fresher live data: $keptFresher, empty skipped: $emptySkipped, non-user files skipped: $nonUserSkipped, errors: $errors, total: " . count($files));

        return 0;
    }
}
