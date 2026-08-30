<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class insert_idrayc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert_idrayc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insert_idrayc';

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

        $Allr = DB::table('users')
            ->select('idc','idrayc','Md')
            ->orWhere(function ($query) {
                $query->whereNull('idrayc')
                    ->orWhere('idrayc', '0');
            })
            ->where('idc', '>', 0)
            ->get();

        foreach ($Allr as $Alw) {
            $idc = $Alw->idc;
            $idrayc = $Alw->idrayc;
            $Md = $Alw->Md;

            $Allc = DB::table('Allcities')
                ->select('rayc')
                ->where('id', $idc)
                ->limit(1)
                ->get();
            foreach ($Allc as $Alc) {
                $rayc = $Alc->rayc;
            }
            echo "idc $idc idrayc $idrayc rayc $rayc $Md <br />";

            DB::table('users')
                ->where('idc', $idc)
                ->update(['idrayc' => $rayc]);

        }

    }


}
