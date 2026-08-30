<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class about_peoples extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'about_peoples';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'about_peoples';

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

        $nf=1; $idfh=1; $idh=""; $idf_old=0;
        $Allm = DB::table('Fotop')->select('Num')
        ->orderBy('Num')
        ->get();

        foreach ($Allm as $All) {
         $idf=$All->Num;
            if (strstr("$idh","$idf")==""){

               if($idfh!=1){
                $Foto[$idf_old]=$nf;
               }
		        $idfh=5; $idf_old=$idf; $idh.=" $idf"; $nf=0;
	        }
        $nf++;
        }
        $Foto[$idf_old]=$nf;


        $nf=1; $idfh=1; $idh="";
        $Allm = DB::table('Memoryp')->select('Num')
        ->orderBy('Num')
        ->get();

        foreach ($Allm as $All) {
         $idf=$All->Num;
            if (strstr("$idh","$idf")==""){

               if($idfh!=1){
                $Memory[$idf_old]=$nf;
               }
		        $idfh=5; $idf_old=$idf; $idh.=" $idf"; $nf=0;
	        }
        $nf++;
        }
        $Memory[$idf_old]=$nf;



        $nf=1; $idfh=1; $idh="";
        $Allm = DB::table('City_Admin2')->select('Num')
        ->orderBy('Num')
        ->get();

        foreach ($Allm as $All) {
         $idf=$All->Num;
            if (strstr("$idh","$idf")==""){
               if($idfh!=1){
                $City_Admin[$idf_old]=$nf;
               }
		        $idfh=5; $idf_old=$idf; $idh.=" $idf"; $nf=0;
	        }
        $nf++;
        }
        $City_Admin[$idf_old]=$nf;


/*
        $nf=1; $idfh=1; $idh="";
        $Allm = DB::table('video')->select('id')
        ->orderBy('idc')
        ->get();

        foreach ($Allm as $All) {
         $idf=$All->id;
            if (strstr("$idh","$idf")==""){

               if($idfh!=1){
                $video[$idf_old]=$nf;
               }
		        $idfh=5; $idf_old=$idf; $idh.=" $idf"; $nf=0;
	        }
        $nf++;
        }
        $video[$idf_old]=$nf;



        $nf=1; $idfh=1; $idh="";
        $Allm = DB::table('gc')->select('Num')
        ->orderBy('Num')
        ->get();

        foreach ($Allm as $All) {
         $idf=$All->Num;
            if (strstr("$idh","$idf")==""){

               if($idfh!=1){
                $gc[$idf_old]=$nf;
               }
		        $idfh=5; $idf_old=$idf; $idh.=" $idf"; $nf=0;
	        }
        $nf++;
        }
        $gc[$idf_old]=$nf;



        $nf=1; $idfh=1; $idh="";
        $Allm = DB::table('gcf')->select('Num')
        ->orderBy('Num')
        ->get();

        foreach ($Allm as $All) {
         $idf=$All->Num;
            if (strstr("$idh","$idf")==""){

               if($idfh!=1){
                $gcf[$idf_old]=$nf;
               }
		        $idfh=5; $idf_old=$idf; $idh.=" $idf"; $nf=0;
	        }
        $nf++;
        }
        $gcf[$idf_old]=$nf;

*/

        $Allm = DB::table('users')->select('id')
        ->get();

        foreach ($Allm as $All) {

            $id=$All->id;

            if(isset($Foto[$id])){$f=$Foto[$id];}
            else{$f="";};
            if(isset($Memory[$id])){$m=$Memory[$id];}
            else{$m="";};
            if(isset($City_Admin[$id])){$ca=$City_Admin[$id];}
            else{$ca="";};

            /*
            if(isset($Video[$id])){$v=$Video[$id];}
            else{$v="";};
            if(isset($gc[$id])){$g=$gc[$id];}
            else{$g="";};
            if(isset($gf[$id])){$gf=$gf[$id];}
            else{$gf="";};
            */


            if($f>0||$m>0||$ca>0){
                $v=""; $g=""; $gf=""; $a="";
                $ab = "#!$f#!$m#!$v#!$a#!$g#!$gf#!$ca";

                DB::table('users')
                ->where('id', $id)
                ->update(['ab' => $ab]);
            }
        }
    }
}
