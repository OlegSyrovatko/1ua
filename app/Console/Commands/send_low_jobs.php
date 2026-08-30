<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App;

class send_low_jobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_low_jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send_low_jobs';

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
			$limit=round(20/$load_now);
			$currentHour = date('G');
			if ($currentHour < 7) {
				$limit *= 2; 
			}
			$Allq = DB::table('jobs')
				->select('id')
				->where('queue', 'low')
				->orderBy('id', 'asc')
				->limit($limit)
				->get();
			$Allqn = $Allq->count();


			foreach ($Allq as $Alq) {
				$id = $Alq->id;

				$affected = DB::table('jobs')
					->where('id', $id)
					->update(['queue' => 'default']);
			}
		}

    }
}
