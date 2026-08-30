<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class allstat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allstat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'allstat';

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


        $Allm = DB::table('users')
		->select(DB::raw("count(Num) as result_count"))
		->where('aktiv','=',1)
		->get();
		$result_count = 25;
        foreach ($Allm as $All) {
			$result_count = $All->result_count;
        }
        $memory_contents_new="reg$result_count";

        $Allm = DB::table('Allcities')
            ->select(DB::raw("count(id) as result_count"))
            ->get();
        $result_count = 25855;
        foreach ($Allm as $All) {
            $result_count = $All->result_count;
        }
        $memory_contents_new.="Allc$result_count";


        $filename = "allstat.txt";
		Storage::disk('public')->put($filename, $memory_contents_new);
    }


}
