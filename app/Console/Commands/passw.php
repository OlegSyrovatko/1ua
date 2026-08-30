<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class passw extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passw';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'passw';

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

        $Allus = DB::table('users')->select('Num', 'passw')->
        whereNull('id')->
        whereNotNull('passw')->
        limit(500)->
        get();

        foreach ($Allus as $Allu) {
            $passw = $Allu->passw;
            $Num = $Allu->Num;
           $passw2 = Hash::make($passw);


            $affected = DB::table('users')
                ->where('Num', $Num)
                ->update(
                    ['password' => $passw2, 'id' => $Num]);
        }
        /*

        $Allus = DB::table('users')->select('Num')->
        whereNull('id')->
        limit(50000)->
        get();
        foreach ($Allus as $Allu) {
            $Num = $Allu->Num;

            $affected = DB::table('users')
                ->where('Num', $Num)
                ->update(
                    ['id' => $Num]);
        }
        */

    }


}
