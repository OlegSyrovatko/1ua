<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ratingmemory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratingmemory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ratingmemory';

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

        $Allu = DB::table('Memory')
        ->select('avt', DB::raw('SUM(LENGTH(Aboutec)) as summem'))
        ->where('avt','>',0)
        ->groupBy('avt')
        ->get();

            foreach ($Allu as $Alu) {
                $avt=$Alu->avt;
                $summem=$Alu->summem;
                if((int)$avt>0){
                    DB::table('users')
                        ->where('id', $avt)
                        ->update(['ratingmemory' => $summem]);
                }
            }

    }


}
