<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class send_mail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send_mail Scheduler';

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


          $Allus2 = DB::table('mail_sender')->select('id', 'mail', 'subj', 'text')->
          orderBy('id', 'asc')->
          limit(50)->
          get();


                       foreach ($Allus2 as $All2) {
                           $id = $All2->id; $mail_in = $All2->mail; $subj = $All2->subj; $text = $All2->text;
                           // $text = stripslashes($text);
                           $adds = "MIME-Version: 1.0\n";
                           $adds.="From:1ua <no_reply@1ua.com.ua> \n";
                           if(strstr($text, "style")==""){$adds.="Content-Type: text/plain; charset=utf8\n";}
                           else{$adds.="Content-Type: text/html; charset=utf8\n";}

                           // $subj = "=?utf8?b?" . base64_encode($subj) . "?=";
                            mail("$mail_in", "$subj", "$text","$adds");

                           DB::table('mail_sender')->where('id', $id)->delete();

                       }



    }
}
