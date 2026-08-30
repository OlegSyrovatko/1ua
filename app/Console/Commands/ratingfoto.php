<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ratingfoto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratingfoto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ratingfoto';

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

        $Allu = DB::table('Foto')
        ->select('avt', DB::raw('SUM(r_gol)+SUM(views)+COUNT(Namef)+count(DISTINCT(x))*25 as summem'))
        ->where('avt','>',0)
        ->whereNull('Namefpi')
        ->groupBy('avt')
        ->get();

            foreach ($Allu as $Alu) {
                $avt=$Alu->avt;
                $summem=$Alu->summem;

                if((int)$avt>0){
                    DB::table('users')
                        ->where('id', $avt)
                        ->update(['ratingfoto' => $summem]);
                }

            }

    }


}
