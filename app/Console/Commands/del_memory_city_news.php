<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App;

class del_memory_city_news extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'del_memory_city_news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'del_memory_city_news';

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

		$results = DB::table('Memory')
		->select('id','City', DB::raw('COUNT(*) as row_count'))
		->where('id', '!=', 78498) // Рашівка
		 ->where('Md', '<', now()->subYear())
		->whereNull('City2')
		->whereNull('avt')
		->whereNull('Ip')
		->whereNull('Nameg')
		->whereNull('Whog')
		->groupBy('id', 'City') 
		->havingRaw('COUNT(*) > 100')
		->orderByDesc('row_count')
		->limit(10)
		->get();


		foreach ($results as $result) {
			$idToDelete = $result->id;
			$CityToDelete = $result->City;
			$row_count = $result->row_count;
			// echo " <a href=\"c$idToDelete\" target=_blank> rows $row_count,  id $idToDelete - $CityToDelete</a><br /> ";

			DB::table('Memory')
				->where('id', $idToDelete)
				->whereNull('City2')
				->whereNull('avt')
				->whereNull('Ip')
				->whereNull('Nameg')
				->whereNull('Whog')
				 ->where('Md', '<', now()->subYear()) 
				->delete();

		}

    }
}
