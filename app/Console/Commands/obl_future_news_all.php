<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class obl_future_news_all extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obl_future_news_all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'obl_future_news_all';

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
     * Тонкий оркестратор замість 25 окремих записів у розкладі: викликає всі
     * obl_future_news1..25 в ОДНОМУ процесі/bootstrap'і Laravel, замість того щоб
     * cron-планувальник спавнив 25 окремих PHP-процесів кожні 5 хв. Бізнес-логіку
     * кожної з 25 команд не чіпаємо — кожна сама вирішує пропустити роботу, якщо
     * вже є новини за сьогодні для своєї області ($Alladn) або якщо навантаження
     * задосить високе (sys_getloadavg) — це і є той самий retry-механізм "спробуй
     * знову за 5 хв, коли навантаження спаде", що був задуманий раніше.
     *
     * @return int
     */
    public function handle()
    {
        for ($obl = 1; $obl <= 25; $obl++) {
            Artisan::call('obl_future_news' . $obl);
        }
    }
}
