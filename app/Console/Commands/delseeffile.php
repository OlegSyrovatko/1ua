<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class delseeffile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delseeffile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delseeffile Scheduler';

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
        

        // $memory_ips = Storage::disk('public')->get('ip.txt');
        // $nip=substr_count($memory_ips, " ");
        // $nip_google=substr_count($memory_ips, "66.249.");
        // $txt = "nip $nip nip_google $nip_google#";
        // Storage::disk('public')->put('ip.txt', $txt);

        $filename = storage_path('app/public/ip.txt');

        $fp = fopen($filename, 'c+');

        if ($fp) {

            flock($fp, LOCK_EX);

            rewind($fp);
            $memory_ips = stream_get_contents($fp);

            $nip = substr_count($memory_ips, " ");
            $nip_google = substr_count($memory_ips, "66.249.");

            $txt = "nip $nip nip_google $nip_google#";

            ftruncate($fp, 0);
            rewind($fp);
            fwrite($fp, $txt);

            fflush($fp);

            flock($fp, LOCK_UN);
            fclose($fp);
        }

        Storage::disk('public')->put('delseeffile.txt', 'aaa');


    }
}
