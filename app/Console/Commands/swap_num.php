<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class swap_num extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swap_num';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swap_num';

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



        $time_past = date('Y-n-j-H-i-s', strtotime('-90 days'));
        $nd=0;

        $Alld = DB::table('Private')->select('Num')->
        where('Page', 5)->get();
        $nrnd = $Alld->count();
        foreach ($Alld as $Ald) {
            $Num = $Ald->Num;
            DB::table('users')
                ->where('id', $Num)
                ->update(['adm_send' => '1']);

            $Allq = DB::table('users')->
            where('l_visit', '<', $time_past)->
            where('Num', $Num)->
            limit(1)->
            get();
            $nrno = $Allq->count();
            if($nrno>0){echo "$Num  <br>";
                DB::table('users')->where('Num', $Num)->delete();
                $nd++;
            }
        }

        echo"<br>Must deleted: $nrnd <br>";
        echo"<br>I deleted >90: $nd <br>";

        DB::table('gp')
            ->leftjoin('users', 'gp.Num', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('gpf')
            ->leftjoin('users', 'gpf.Num', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Memoryf')
            ->leftjoin('Foto', 'Memoryf.Num', '=', 'Foto.Namef')
            ->whereNull('Foto.Namef')
            ->delete();

        DB::table('Memoryfp')
            ->leftjoin('Fotop', 'Memoryfp.Num', '=', 'Fotop.Namef')
            ->whereNull('Fotop.Namef')
            ->delete();

        DB::table('City_Admin2')
            ->leftjoin('users', 'City_Admin2.Num', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Private')
            ->leftjoin('users', 'Private.Num', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Fotop')
            ->leftjoin('users', 'Fotop.Num', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Friends')
            ->leftjoin('users', 'Friends.Num1', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Friends')
            ->leftjoin('users', 'Friends.Num2', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Mailpost')
            ->leftjoin('users', 'Mailpost.Nump', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Memoryp')
            ->leftjoin('users', 'Memoryp.Num', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Memoryfp')
            ->leftjoin('users', 'Memoryfp.Nump', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Memoryvp')
            ->leftjoin('users', 'Memoryvp.Nump', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Msg')
            ->leftjoin('users', 'Msg.Numpost', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Msg')
            ->leftjoin('users', 'Msg.Numreceive', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Videop')
            ->leftjoin('users', 'Videop.avt', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

        DB::table('Videop')
            ->leftjoin('users', 'Videop.Num', '=', 'users.Num')
            ->whereNull('users.Num')
            ->delete();

    }
}
