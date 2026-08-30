<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class volyn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'volyn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'volyn';

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


        $vfilename0 = "apps/radar_volyn0.png";
        $vfilename = "apps/radar_volyn.png";
        $vfrom_file  = file_get_contents("https://pogoda.by/files/radars/static/33008/Radar_33008_MAP_PHEN_$Md.png");
        $aff = Storage::disk('public')->put($vfilename0, $vfrom_file);
        if($aff) {
            $size = Storage::disk('public')->size($vfilename0);
            if ($size > 5000) {
                $ggg = Storage::disk('public')->delete($vfilename);
                if($ggg) {Storage::disk('public')->move($vfilename0, $vfilename);}
            }
        }

    }


}
