<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App;

class send_mail_fotoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_mail_fotoc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send_mail_fotoc';

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
        if($load_now<2){

            $Fd_0 = date('Y-m-d-H:i:00', strtotime('-3600 seconds'));

            // SELECT Memory.id, Memory.Aboutec, Memory.Aboutece, Allcities.ab, Allcities.closers FROM Memory, Allcities
            // where Memory.Md > \"$Fd_0\" and Memory.id = Allcities.id and Memory.avt is null group by Memory.id order BY Memory.id desc

            $Alls = DB::table('Foto')->select('id', 'Nameg', 'mail_admin')->
            where('Fd', '>', $Fd_0)->
            groupBy('id')->
            orderBy('id', 'desc')->
            get();

            foreach ($Alls as $Allu) {
                $id = $Allu->id; $Nameg = $Allu->Nameg; $mail_admin = $Allu->mail_admin;

                $Alla = DB::table('Allcities')->select('ab', 'closers')->
                where('id', $id)->
                get();
                foreach ($Alla as $Allc) {$ab = $Allc->ab;}

                $pagec = explode("#!", $ab);

                $City=$pagec[1]; $City2=$pagec[2]; $status=$pagec[5]; $vol_karta=$pagec[6]; $City3=$pagec[11]; $domen=$pagec[12];

                if ($status){
                    if ($status==1){$statusm="міста"; $statusm2="города"; $statusm3="City";}
                    if ($status==2){$statusm="смт"; $statusm2="смт"; $statusm3="Town";}
                    if ($status==3){$statusm="селища"; $statusm2="селения"; $statusm3="Village";}
                    if ($status==4){$statusm="села"; $statusm2="села"; $statusm3="Village";}
                    if ($status==5){$statusm="хутора"; $statusm2="хутора"; $statusm3="Hamlet";}
                }
                else{
                    if (!$vol_karta||$vol_karta<20000){$statusm="села"; $statusm2="села"; $statusm3="Village";}
                    if ($vol_karta>=20000&&$vol_karta<50000){$statusm="міста (села)"; $statusm2="городе (селе)"; $statusm3="Town";}
                    if ($vol_karta>=50000){$statusm="міста"; $statusm2="города"; $statusm3="Сity";}
                }

                echo"<br /><br />$id Фото з $statusm $City від $Nameg<br />";
                $theme = "Фото з $statusm $City";
                $mailput = "fotolist$id";
                $q_s1[0] = ['foto', 1];
                $q_s2[0] = ['foto', 1];
                $q_s3[0] = ['foto', 1];

                $filename = "sixhours.txt";
                $truestat_file_contents = Storage::disk('public')->get($filename);
                $lastmail = strstr($truestat_file_contents, $mailput);

                if ($lastmail == "") {
                    $q_s2[0] = ['foto', 2];
                    Storage::disk('public')->append($filename, $mailput);
                }

                $filename = "oneday.txt";
                $truestat_file_contents = Storage::disk('public')->get($filename);
                $lastmail = strstr($truestat_file_contents, $mailput);

                if ($lastmail == "") {
                    $q_s3[0] = ['foto', 3];
                    Storage::disk('public')->append($filename, $mailput);
                }

                $Allm = DB::table('Citymailpost')
                    ->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3) {
                        $query->whereNull('foto')
                            ->orWhere($q_s1)
                            ->orWhere($q_s2)
                            ->orWhere($q_s3);
                    })
                    ->where('id', $id)
                    ->select('mail_visitor')
                    ->get();

                foreach ($Allm as $Alm) {

                    $Pmail = trim($Alm->mail_visitor);
					if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
						if($mail_admin != $Pmail){

							$details['email'] = $Pmail;
							$details['subject'] = "Фото з $statusm $City";
							$details['City'] = $City;
							$details['blade'] = "emails.city_fotos";
							$details['det'] = array('theme' => $theme,'id' => $id, 'Nameg' => $Nameg, 'domen' => $domen, 'City' => $City, 'email' => $Pmail);
							$details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
							dispatch(new App\Jobs\SendEmailJob($details));
						}
					}
                }

            } // перелік  id

        } // if($load_now<2){

    } // public function handle()


} // class send_mail_memoc
