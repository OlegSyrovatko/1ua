<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App;

class test_insert_fotop_w_h extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test_insert_fotop_w_h';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test_insert_fotop_w_h';

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

        $load = sys_getloadavg();
        $load_now = $load[0];
		if($load_now>0){
			$limit=round(300/$load_now);
			$currentHour = date('G');
			if ($currentHour < 7) {
				$limit *= 2; 
			}
			
			
			       // пошук і оновлення висоти Fotop в таблицю
        $Alltest = DB::table('Fotop')
        ->select('Namef','Fd','Formf')
        // ->where('Num', '=', "72372396")
        ->where('w', '=', 0)
        ->orderBy('Fd', 'desc')
        ->limit($limit)
         ->get();
        $Alltestn = $Alltest->count();


        foreach ($Alltest as $Alf) {
            $Namef=$Alf->Namef;
            $M6=$Alf->Fd;
            $M7=$Alf->Formf;

            $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
            if ($monm<10){$monmf = substr($M6, 6, 1);}
            else{$monmf=$monm;}
            if($yem<=2007){$yem = "2005-2007"; $monmf="";}

            $katalogb = "Fotop/$yem$monmf/b$Namef.$M7";

            if (Storage::disk('public')->exists($katalogb)) {
                $katalogface=Storage::disk('public')->url($katalogb);
                $imageInfo = getimagesize($katalogface);

                if ($imageInfo) {
                    $avheight = $imageInfo[1];
                    $avw = $imageInfo[0];
                    echo"ni$Namef w $avw h $avheight ";

                    DB::table('Fotop')
                    ->where('Namef', $Namef)
                    ->update(['h' => $avheight, 'w' => $avw]);
                }

            }
            else{


                    DB::table('Fotop')
                    ->where('Namef', $Namef)
                    ->update(['h' => -1, 'w' => -1]);

            }
		}


			
			
			

		}

    }
}
