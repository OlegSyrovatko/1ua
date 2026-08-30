<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ratec_low extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratec_low';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ratec_low';

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

        $Allu = DB::table('Allcities')
        ->select('id', 'sumr')
        ->where('sumr','>',50)
        ->get();

            foreach ($Allu as $Alu) {
                $id=$Alu->id;
                $sumr=$Alu->sumr;
                if($sumr>50000){$sumr = $sumr-500;}
                else if($sumr>5000){$sumr = $sumr-50;}
                else if($sumr>1000){$sumr = $sumr-10;}
                else if($sumr>500){$sumr = $sumr-7;}
                else if($sumr>200){$sumr = $sumr-5;}
                else if($sumr>70){$sumr = $sumr-3;}
                else if($sumr>50){$sumr = $sumr-1;}
                    DB::table('Allcities')
                        ->where('id', $id)
                        ->update(['sumr' => $sumr]);

            }

    }


}
