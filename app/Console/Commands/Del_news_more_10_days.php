<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class Del_news_more_10_days extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Del_news_more_10_days';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Del_news_more_10_days Scheduler';

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

        $m_is_10past = date('Y-n-j-H-i', strtotime('-10 days'));
       // delete FROM `News` WHERE Nd < \"$m_is_10past\"
                DB::table('News')
                    ->where('Nd', '<', "$m_is_10past")
                    ->delete();

    }


}
