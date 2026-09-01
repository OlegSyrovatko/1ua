<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Demo::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('Create_domen_for_users')->cron('*/5 * * * *');

        $schedule->command('delseeffile')->cron('* * * * *');
        // $schedule->command('delseeffile')
        //     ->everyMinute()
        //     ->appendOutputTo(storage_path('logs/delseeffile.log'));
        $schedule->command('sixhours')->cron('1 */6 * * *');

        $schedule->command('oneday')->cron('1 0 * * *');
        $schedule->command('redis:backup')->cron('33 3 * * *');
        $schedule->command('Del_news_more_10_days')->cron('27 4 * * *');
        $schedule->command('insert_idrayc')->cron('18 23 * * *');
        $schedule->command('questions_in_forum')->cron('15 */6 * * *');

	//	$schedule->command('passw')->cron('* * * * *');
    //   $schedule->command('s3')->cron('*/2 * * * *');

        $schedule->command('obl_future_news1')->everyFiveMinutes()->between('21:10', '23:59');
        $schedule->command('obl_future_news2')->everyFiveMinutes()->between('21:10', '23:59');
        $schedule->command('obl_future_news3')->everyFiveMinutes()->between('21:10', '23:59');
        $schedule->command('obl_future_news4')->everyFiveMinutes()->between('21:10', '23:59');
        $schedule->command('obl_future_news5')->everyFiveMinutes()->between('21:10', '23:59');
        $schedule->command('obl_future_news6')->everyFiveMinutes()->between('21:15', '23:59');
        $schedule->command('obl_future_news7')->everyFiveMinutes()->between('21:15', '23:59');
        $schedule->command('obl_future_news8')->everyFiveMinutes()->between('21:15', '23:59');
        $schedule->command('obl_future_news9')->everyFiveMinutes()->between('21:15', '23:59');
        $schedule->command('obl_future_news10')->everyFiveMinutes()->between('21:15', '23:59');
        $schedule->command('obl_future_news11')->everyFiveMinutes()->between('21:20', '23:59');
        $schedule->command('obl_future_news12')->everyFiveMinutes()->between('21:20', '23:59');
        $schedule->command('obl_future_news13')->everyFiveMinutes()->between('21:20', '23:59');
        $schedule->command('obl_future_news14')->everyFiveMinutes()->between('21:20', '23:59');
        $schedule->command('obl_future_news15')->everyFiveMinutes()->between('21:20', '23:59');
        $schedule->command('obl_future_news16')->everyFiveMinutes()->between('21:25', '23:59');
        $schedule->command('obl_future_news17')->everyFiveMinutes()->between('21:25', '23:59');
        $schedule->command('obl_future_news18')->everyFiveMinutes()->between('21:25', '23:59');
        $schedule->command('obl_future_news19')->everyFiveMinutes()->between('21:25', '23:59');
        $schedule->command('obl_future_news20')->everyFiveMinutes()->between('21:25', '23:59');
        $schedule->command('obl_future_news21')->everyFiveMinutes()->between('21:25', '23:59');
        $schedule->command('obl_future_news22')->everyFiveMinutes()->between('21:25', '23:59');
        $schedule->command('obl_future_news23')->everyFiveMinutes()->between('21:25', '23:59');
        $schedule->command('obl_future_news24')->everyFiveMinutes()->between('21:25', '23:59');
        $schedule->command('obl_future_news25')->everyFiveMinutes()->between('21:25', '23:59');

        $schedule->command('obl_save_combine')->cron('5 12,15,16,21 * * *');
		$schedule->command('del_memory_city_news')->cron('50-59 5 * * *');
		// $schedule->command('test_insert_fotop_w_h')->cron('* * * * *');
        $schedule->command('send_low_jobs')->cron('* * * * *');
        $schedule->command('LA')->cron('* * * * *');
        $schedule->command('process_mail_bounces')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('gmail_bulk_autotune')->dailyAt('09:00')->withoutOverlapping();

       // $schedule->command('send_mail_fotoc')->cron('28 * * * *');
        // $schedule->command('send_test_mail')->cron('* * * * *');
        $schedule->command('about_cities')->cron('1-25 1 * * *');
		$schedule->command('about_cities_perc')->cron('26 1 * * *');
        $schedule->command('about_peoples')->cron('17 0 * * *');
        $schedule->command('ratingmemory')->cron('45 2 * * *');
        $schedule->command('ratingfoto')->cron('45 3 * * *');
        $schedule->command('allstat')->cron('16 0 * * *');
        $schedule->command('update_cities_views')->cron('0 0 * * *');
        $schedule->command('oneday')->cron('1 0 * * *');
/*
       $schedule->command('sm_allcities')->cron('38 0 1 * *');
        $schedule->command('sm_users')->cron('7 2 1 * *');
        $schedule->command('sm_foto')->cron('29 2 3 * *');
        $schedule->command('sm_fotop')->cron('39 2 5 * *');
        $schedule->command('sm_fotonf')->cron('44 2 7 * *');
		$schedule->command('sm_fotoni')->cron('44 2 9 * *');
        $schedule->command('sm_mview')->cron('11 2 11 * *');
        $schedule->command('sm_blogallcities')->cron('11 2 14 * *');
        $schedule->command('sm_recc')->cron('11 2 16 * *');
        $schedule->command('sm_recp')->cron('11 2 18 * *');
*/

        $schedule->command('ratep_low')->cron('39 2 * * *');
        $schedule->command('ratec_low')->cron('36 2 * * *');
        $schedule->command('allstat')->cron('16 0 * * *');
//        $schedule->command('about_cities_perc')->cron('15 1 * * *');
        $schedule->command('about_cities_perc')->cron('49 2 * * *');
    //    $schedule->command('volyn')->cron('* * * * *');
    //    $schedule->command('chernigiv')->cron('* * * * *');
    //    $schedule->command('sumy')->cron('* * * * *');

        $schedule->command('emails:work')->cron('* * * * *');
        $schedule->command('send_mail')->cron('* * * * *');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
