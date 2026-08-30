<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App;
class LA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'LA';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'LA';

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
        $load1 = round($load[0], 1); $load5 = round($load[1], 1);$load15 = round($load[2], 1);
        $la = " $load1 $load5 $load15 ";
        if($load15>5){
            $details['email'] = "sirov@ukr.net";
            $details['subject'] = "LA";
            $details['blade'] = "emails.LA";
            $details['det'] = array('la' => $la);
            $details['unsub'] = "sirov@ukr.net, <https://1ua.com.ua/unsubscribe/>";
            dispatch(new App\Jobs\SendEmailJob($details));

            try {
                Http::asForm()->post(
                    'https://api.telegram.org/bot' . config('services.telegram.bot_token') . '/sendMessage',
                    [
                        'chat_id' => config('services.telegram.chat_id'),
                        'text' => "LA:$la",
                    ]
                );
            } catch (\Throwable $e) {
                \Log::error('TELEGRAM LA EXCEPTION', ['message' => $e->getMessage()]);
            }
        }

    }
}
