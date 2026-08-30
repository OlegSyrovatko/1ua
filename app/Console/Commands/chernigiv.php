<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class chernigiv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chernigiv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'chernigiv';

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

        $filename0 = "apps/radar_chernigiv0.png";
        $filename = "apps/radar_chernigiv.png";
        $from_file  = file_get_contents("https://pogoda.by/files/radars/static/33041/Radar_33041_MAP_PHEN_$Md.png");
        $aff = Storage::disk('public')->put($filename0, $from_file);

        if($aff){
            $size = Storage::disk('public')->size($filename0);
            if($size>5000){
                $ggg = Storage::disk('public')->delete($filename);
                Storage::disk('public')->move( $filename0, $filename);
            }

        }

    }


}
