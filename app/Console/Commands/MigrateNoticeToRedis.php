<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class MigrateNoticeToRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notice:migrate-redis {--dry-run : Preview counts without writing to Redis or touching files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One-time backfill of storage/notice/*.txt into Redis lists (notice:{id}), matching the LPUSH/LPOP format now used by the controllers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dryRun = (bool) $this->option('dry-run');
        $dir = storage_path('app/public/notice');
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
                    // File starts with the delimiter, so the first exploded piece is empty.
                    $records = explode('#!:*&', $contents);
                    array_shift($records);
                    $records = array_values(array_filter($records, fn ($r) => $r !== ''));

                    if ($records) {
                        if (!$dryRun) {
                            // Args are pushed in order, so head..tail ends up newest..oldest —
                            // the same order load_notice()'s old file-based LPOP-equivalent used.
                            Redis::rpush("notice:$id", ...$records);
                        }
                        $migrated++;
                    } else {
                        $emptySkipped++;
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

        $this->info(($dryRun ? '[dry-run] ' : '') . "Migrated: $migrated, empty skipped: $emptySkipped, non-user files skipped: $nonUserSkipped, errors: $errors, total: " . count($files));

        return 0;
    }
}
