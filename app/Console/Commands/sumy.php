<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class sumy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sumy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sumy';

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
        $Md = date('Ymd_Hi', strtotime('-3 hours'));
        $Md = substr($Md, 0, mb_strlen($Md)-1);
        $Md.="0";



        $sfilename0 = "apps/radar_sumy0.png";
        $sfilename = "apps/radar_sumy.png";
        $sfrom_file  = file_get_contents("https://pogoda.by/files/radars/static/39566/Radar_39566_MAP_PHEN_$Md.png");
        $aff = Storage::disk('public')->put($sfilename0, $sfrom_file);
        if($aff) {
            $size = Storage::disk('public')->size($sfilename0);
            if ($size > 5000) {
                $ggg = Storage::disk('public')->delete($sfilename);
                if($ggg) {Storage::disk('public')->move($sfilename0, $sfilename);}
            }
        }

    }


}
