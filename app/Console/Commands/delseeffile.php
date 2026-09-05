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
        // Ротацію/обнулення ip.txt (nip/nip_google) з 2026-09 виконує
        // protection:analyze (App\Services\TrafficAnalyzer::rotateIpLog()) —
        // той самий атомарний read+truncate, але з повним аналізом трафіку
        // для Cloudflare protection. Лишати цю логіку тут теж означало б два
        // процеси, що одночасно truncate'ять один файл щохвилини.
        Storage::disk('public')->put('delseeffile.txt', 'aaa');
    }
}
