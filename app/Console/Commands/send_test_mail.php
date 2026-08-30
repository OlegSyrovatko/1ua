<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App;

class send_test_mail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_test_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send_test_mail';

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
        if($load_now<6){

    // update users set mail_send_cron = "" where id > 0
// SELECT *  FROM `users` WHERE  email != "" and adm_send != "1" and mail_send_cron = "1"  ORDER BY `Md` DESC;

            $Alls = DB::table('users')->select('id', 'email')->
            where('adm_send', '!=', "1")->
            where('mail_send_cron', '!=', "1")->
            where('id', '=', "72372396")->
            orderBy('id', 'desc')->
            limit(50)->
            get();

            foreach ($Alls as $Allu) {
                $id = $Allu->id;  $Pmail = $Allu->email;

                    // $Pmail = "sirov@ukr.net";
                    $fcei1 = substr($Pmail, 3, 1);
                    $fcei2 = substr($Pmail, 7, 1);
                    $pas2 = "$fcei1$fcei2";
                    
					if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {

                        $details['email'] = $Pmail;
                        $details['subject'] = "Допоможіть зберегти 1ua — памʼять про наші рідні місця ❤️";
                        $details['blade'] = "emails.user_adm_letter";
                        $details['det'] = array( 'email' => $Pmail, 'pas' => $pas2);
                        $details['unsub'] = "<https://1ua.com.ua/admin_unsubscribe/$Pmail/$pas2>";
                        dispatch(new App\Jobs\SendEmailJob($details));
            
					}
                    $affected = DB::table('users')
                        ->where('id', $id)
                        ->update(['mail_send_cron' => "1"]);

            } // перелік  id

        } // if($load_now<2){

    } // public function handle()


} // class send_mail_memoc
