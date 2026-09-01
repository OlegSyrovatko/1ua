<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RedisBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:backup {--keep=7 : How many days of backups to retain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Snapshot the Redis dataset (notice/last_visit/life_views/cache) to a local .rdb file and prune old backups';

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
    public function handle()
    {
        $dir = storage_path('app/redis-backups');
        if (!is_dir($dir)) {
            mkdir($dir, 0750, true);
        }

        $config = config('database.redis.default');
        $filename = 'redis-' . date('Y-m-d-His') . '.rdb';
        $path = $dir . '/' . $filename;

        $cmd = 'redis-cli -h ' . escapeshellarg($config['host']) . ' -p ' . escapeshellarg($config['port']);
        if (!empty($config['password'])) {
            $cmd .= ' -a ' . escapeshellarg($config['password']) . ' --no-auth-warning';
        }
        $cmd .= ' --rdb ' . escapeshellarg($path) . ' 2>&1';

        exec($cmd, $output, $exitCode);

        if ($exitCode !== 0 || !is_file($path)) {
            $this->error('Redis backup failed: ' . implode(' ', $output));
            return 1;
        }

        $this->info("Backup written: $path (" . round(filesize($path) / 1024 / 1024, 1) . " MB)");

        $keepDays = (int) $this->option('keep');
        $cutoff = time() - $keepDays * 86400;
        $pruned = 0;
        foreach (glob($dir . '/redis-*.rdb') as $file) {
            if (filemtime($file) < $cutoff) {
                unlink($file);
                $pruned++;
            }
        }
        $this->info("Pruned $pruned backup(s) older than $keepDays day(s).");

        return 0;
    }
}
