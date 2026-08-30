<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class about_cities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'about_cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'about_cities';

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
		
		$obl = (int)date('i');

		        $nf=1; $idfh=1; $idh=""; $idf_old=0; 
        $Allm = DB::table('Foto')->select('id')
        ->where('obl', '=', $obl)
        ->orderBy('id')
        ->get();

        foreach ($Allm as $All) {
         $idf=$All->id;
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
        $Allm = DB::table('Memory')->select('id')
        ->where('obl', '=', $obl)
        ->orderBy('id')
        ->get();

        foreach ($Allm as $All) {
         $idf=$All->id;
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
        $Allm = DB::table('users')->select('idc')
        ->where('obl', '=', $obl)
        ->orderBy('idc')
        ->get();

        foreach ($Allm as $All) {
         $idf=$All->idc;
            if (strstr("$idh","$idf")==""){
               if($idfh!=1){
                $regpeople[$idf_old]=$nf;
               }
		        $idfh=5; $idf_old=$idf; $idh.=" $idf"; $nf=0;
	        }
        $nf++;
        }
        $regpeople[$idf_old]=$nf;


        $Allm = DB::table('Allcities')->select('id','City','City2','City3','ray','status','vol_karta','domen')
        ->where('obl', '=', $obl)
        ->get();


        foreach ($Allm as $All) {

            $id=$All->id; $City=$All->City; $City2=$All->City2; $City3=$All->City3;
            $ray=$All->ray; $status=$All->status; $vol_karta=$All->vol_karta; $domen=$All->domen;

            if(isset($Foto[$id])){$f=$Foto[$id];}
            else{$f="";};
            if(isset($Memory[$id])){$m=$Memory[$id];}
            else{$m="";};
            if(isset($regpeople[$id])){$r=$regpeople[$id];}
            else{$r="";};

            /*
            if(isset($Video[$id])){$v=$Video[$id];}
            else{$v="";};
            if(isset($gc[$id])){$g=$gc[$id];}
            else{$g="";};
            if(isset($gf[$id])){$gf=$gf[$id];}
            else{$gf="";};
            */
            // $ab = "#!$City#!$City2#!$obl#!$ray#!$status#!$vol_karta#!$f#!$m#!$v#!$r#!$City3#!$domen#!$g#!$gf";
			

            $ab = "#!$City#!$City2#!$obl#!$ray#!$status#!$vol_karta#!$f#!$m#!#!$r#!$City3#!$domen#!#!";

             $affected = DB::table('Allcities')
            ->where('id', $id)
            ->update(['ab' => $ab]);
        }

    }


}
