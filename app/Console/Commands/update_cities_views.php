<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class update_cities_views extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update_cities_views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update_cities_views';

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
		DB::table('stat')
            ->where('views', '>', 0)
            ->update(['views' => 0]);

    }


}
