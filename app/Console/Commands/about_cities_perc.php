<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class about_cities_perc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'about_cities_perc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'about_cities_perc';

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



        $Allm = DB::table('Allcities')->select('id','obl','rayc','ab')
        ->orderBy('obl')
        ->orderBy('rayc')
        ->get();


        $nfr=0; $nfo=0;
        $nmr=0; $nmo=0;
        $oblh=0; $raych=0;
        $City1h=""; $City2h=""; $City3h="";
		$All = 25853; $all_ray = 0; $ray_true=0;

        foreach ($Allm as $All) {
            $id=$All->id;
            $obl=$All->obl;
            $rayc=$All->rayc;
            $ab=$All->ab;

            if($raych!=$rayc && $ray_true>0){

				$perc_f_ray=round(($nfr/$all_ray*100),1);
				$perc_m_ray=round(($nmr/$all_ray*100),1);

                    echo"$ray_true $City1h $City2h $City3h f $perc_f_ray m $perc_m_ray <br /> ";
                //    DB::table('stat')->insert(['id' => $ray_true, 'obl' => $oblh, 'perc_f' => $perc_f_ray, 'perc_m' => $perc_m_ray,
                //     'City1' => $City1h, 'City2' => $City2h, 'City3' => $City3h]);

                    DB::table('stat')
                        ->where('id', $ray_true)
                        ->update(['perc_f' => $perc_f_ray, 'perc_m' => $perc_m_ray,
                     'City1' => $City1h, 'City2' => $City2h, 'City3' => $City3h]);


				$nfr=0;
                $nmr=0;
				$all_ray=0;
                $ray_true=0;
            }
            if($oblh!=$obl && $oblh>0){

                if($oblh==1){$percf=round(($nfo/910*100),1); $percm=round(($nmo/910*100),1);}
                if($oblh==2){$percf=round(($nfo/998*100),1); $percm=round(($nmo/998*100),1);}
                if($oblh==3){$percf=round(($nfo/1330*100),1); $percm=round(($nmo/1330*100),1);}
                if($oblh==4){$percf=round(($nfo/1097*100),1); $percm=round(($nmo/1097*100),1);}
                if($oblh==5){$percf=round(($nfo/1026*100),1); $percm=round(($nmo/1026*100),1);}
                if($oblh==6){$percf=round(($nfo/1448*100),1); $percm=round(($nmo/1448*100),1);}
                if($oblh==7){$percf=round(($nfo/581*100),1); $percm=round(($nmo/581*100),1);}
                if($oblh==8){$percf=round(($nfo/758*100),1); $percm=round(($nmo/758*100),1);}
                if($oblh==9){$percf=round(($nfo/754*100),1); $percm=round(($nmo/754*100),1);}
                if($oblh==10){$percf=round(($nfo/1068*100),1); $percm=round(($nmo/1068*100),1);}
                if($oblh==11){$percf=round(($nfo/856*100),1); $percm=round(($nmo/856*100),1);}
                if($oblh==12){$percf=round(($nfo/1746*100),1); $percm=round(($nmo/1746*100),1);}
                if($oblh==13){$percf=round(($nfo/828*100),1); $percm=round(($nmo/828*100),1);}
                if($oblh==14){$percf=round(($nfo/726*100),1); $percm=round(($nmo/726*100),1);}
                if($oblh==15){$percf=round(($nfo/992*100),1); $percm=round(($nmo/992*100),1);}
                if($oblh==16){$percf=round(($nfo/1616*100),1); $percm=round(($nmo/1616*100),1);}
                if($oblh==17){$percf=round(($nfo/954*100),1); $percm=round(($nmo/954*100),1);}
                if($oblh==18){$percf=round(($nfo/1320*100),1); $percm=round(($nmo/1320*100),1);}
                if($oblh==19){$percf=round(($nfo/977*100),1); $percm=round(($nmo/977*100),1);}
                if($oblh==20){$percf=round(($nfo/1307*100),1); $percm=round(($nmo/1307*100),1);}
                if($oblh==21){$percf=round(($nfo/1378*100),1); $percm=round(($nmo/1378*100),1);}
                if($oblh==22){$percf=round(($nfo/617*100),1); $percm=round(($nmo/617*100),1);}
                if($oblh==23){$percf=round(($nfo/405*100),1); $percm=round(($nmo/405*100),1);}
                if($oblh==24){$percf=round(($nfo/798*100),1); $percm=round(($nmo/798*100),1);}
                if($oblh==25){$percf=round(($nfo/1363*100),1); $percm=round(($nmo/1363*100),1);}


				echo"$oblh f $percf m $percm <br /><br />";

				    // DB::table('stat')->insert(['id' => $oblh, 'perc_f' => $percf, 'perc_m' => $percm]);

                    DB::table('stat')
                        ->where('id', $oblh)
                        ->update(['perc_f' => $percf, 'perc_m' => $percm]);

                $nfo=0;
                $nmo=0;
            }


            // echo"$obl $rayc <br />";
            $pagec = explode("#!", $ab);
            $City1=$pagec[1]; $City2=$pagec[2]; $City3=$pagec[11];
            if(isset($pagec[7])){$nrf=$pagec[7];}
            else{$nrf=0;}
            if(isset($pagec[8])){$nrm=$pagec[8];}
            else{$nrm=0;}
			if($nrf>0){
				$nfo = (int)$nfo+1;
				$nfr = (int)$nfr+1;
			}
			if($nrm>0){
				$nmo = (int)$nmo+1;
				$nmr = (int)$nmr+1;
			}

             $oblh=$obl; $raych=$rayc;
            if($id==$rayc){
                $City1h = $City1; $City2h = $City2; $City3h = $City3;
                $ray_true=$rayc;
			}
			$all_ray++;

            // $obl7=$pagec[3]; $domen7=$pagec[12];  $nrv7=$pagec[9]; $nrp7=$pagec[10];

        }

            $perc_f_ray=round(($nfr/$all_ray*100),1);
            $perc_m_ray=round(($nmr/$all_ray*100),1);
            echo"$ray_true $City1h $City2h $City3h f $perc_f_ray m $perc_m_ray <br /> ";
             // DB::table('stat')->insert(['id' => $ray_true, 'obl' => $oblh, 'perc_f' => $perc_f_ray, 'perc_m' => $perc_m_ray,
             //    'City1' => $City1h, 'City2' => $City2h, 'City3' => $City3h]);

                DB::table('stat')
                    ->where('id', $ray_true)
                    ->update(['perc_f' => $perc_f_ray, 'perc_m' => $perc_m_ray,
                 'City1' => $City1h, 'City2' => $City2h, 'City3' => $City3h]);

            if($oblh==25){
                $percf=round(($nfo/1363*100),1);
                $percm=round(($nmo/1363*100),1);
            }
            echo"$oblh f $percf m $percm<br /><br />";

            // DB::table('stat')->insert(['id' => $oblh, 'perc_f' => $percf, 'perc_m' => $percm]);

                    DB::table('stat')
                        ->where('id', $oblh)
                        ->update(['perc_f' => $percf, 'perc_m' => $percm]);


    }


}
