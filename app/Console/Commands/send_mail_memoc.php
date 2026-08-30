<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App;

class send_mail_memoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_mail_memoc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send_mail_memoc';

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

            $Fd_0 = date('Y-m-d-H:i:00', strtotime('-300 seconds'));

            // SELECT Memory.id, Memory.Aboutec, Memory.Aboutece, Allcities.ab, Allcities.closers FROM Memory, Allcities
            // where Memory.Md > \"$Fd_0\" and Memory.id = Allcities.id and Memory.avt is null group by Memory.id order BY Memory.id desc

            $Alls = DB::table('Memory')->select('id', 'Aboutec')->
            where('Md', '>', $Fd_0)->
            where('id', '!=', 234)->
            where('id', '!=', 224)->
            where('id', '!=', 187)->
            where('id', '!=', 247)->
            where('id', '!=', 298)->
            where('id', '!=', 342)->
            where('id', '!=', 373)->
            where('id', '!=', 383)->
            where('id', '!=', 414)->
            where('id', '!=', 233)->
            where('id', '!=', 471)->
            where('id', '!=', 557)->
            where('id', '!=', 520)->
            where('id', '!=', 585)->
            where('id', '!=', 614)->
            where('id', '!=', 644)->
            where('id', '!=', 665)->
            where('id', '!=', 687)->
            where('id', '!=', 712)->
            where('id', '!=', 787)->
            where('id', '!=', 741)->
            where('id', '!=', 764)->
            where('id', '!=', 853)->
            where('id', '!=', 811)->
            where('id', '!=', 838)->
            where('id', '!=', 254)->
            whereNull('avt')->
            groupBy('id')->
            orderBy('id', 'desc')->
            get();

            foreach ($Alls as $Allu) {
                $id = $Allu->id;
                $Aboutec = $Allu->Aboutec;
                if (strstr($Aboutec, "^&@")==""){
                    $Alla = DB::table('Allcities')->select('ab', 'closers')->
                    where('id', $id)->
                    get();
                    foreach ($Alla as $Allc) {$ab = $Allc->ab; $closers = $Allc->closers;}

                    $finish = "<a href"; $position = strpos($Aboutec, $finish); $Aboutec = substr($Aboutec, 0, $position);
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

                    echo"<br /><br />$id Новини з $statusm $City $Aboutec<br>
                         Новости с $statusm2 $City2 $Aboutec<br />
                         News from $City3 $statusm3 $Aboutec<br />";


                    $closerse = explode("#", $closers);
                    $closersen = substr_count($closers, '#');
                    $allusersm=" d ";

                    if($closersen>0){echo"Проживаючі:";}
                    for($a=1;$a<$closersen+1;$a++)
                    {
                        $allusersm="";
                        $idm=$closerse[$a];

                        $Allu = DB::table('users')->select('Num', 'Im', 'email')
                            ->orWhere(function($query) use ($idm) {
                                $query->where('idc',$idm)
                                    ->orWhere('idrayc',$idm);
                            })
                            ->where('idc', '!=', 234)->
                            where('idc', '!=', 224)->
                            where('idc', '!=', 187)->
                            where('idc', '!=', 247)->
                            where('idc', '!=', 298)->
                            where('idc', '!=', 342)->
                            where('idc', '!=', 373)->
                            where('idc', '!=', 383)->
                            where('idc', '!=', 414)->
                            where('idc', '!=', 233)->
                            where('idc', '!=', 471)->
                            where('idc', '!=', 557)->
                            where('idc', '!=', 520)->
                            where('idc', '!=', 585)->
                            where('idc', '!=', 614)->
                            where('idc', '!=', 644)->
                            where('idc', '!=', 665)->
                            where('idc', '!=', 687)->
                            where('idc', '!=', 712)->
                            where('idc', '!=', 787)->
                            where('idc', '!=', 741)->
                            where('idc', '!=', 764)->
                            where('idc', '!=', 853)->
                            where('idc', '!=', 811)->
                            where('idc', '!=', 838)->
                            where('idc', '!=', 254)
                            ->where('adm_send','!=','1')
                            ->WhereNotNull('email')
                            ->get();
                        foreach ($Allu as $Alu) {
                            $Numx = $Alu->Num;  $Imx = $Alu->Im; $mail_adminx = $Alu->email; $allusersm.=" $mail_adminx";

                            $filename = "last_visit/$Numx.txt";
                            if (Storage::disk('public')->exists($filename)) {

                                $memory_contents = Storage::disk('public')->get($filename);
                                if ($memory_contents) {
                                    $notices = explode("#!:*&", $memory_contents);
                                    $lan_user=$notices[4];
                                } else {$lan_user="ua";}
                            }
                            else {$lan_user="ua";}

                            if($lan_user == "ua"){$blade = "emails.city_newsme";
                                $subj = "Новини з $statusm $City";
                            }
                            if($lan_user == "ru"){$blade = "emails.rcity_newsme";
                                $subj = "Новости с $statusm2 $City2";
                            }
                            if($lan_user == "en"){$blade = "emails.ecity_newsme";
                                $subj = "News from $City3 $statusm3";
                            }
                            $Pmail = trim($mail_adminx);
                            $fcei1 = substr($Pmail, 3, 1);
                            $fcei2 = substr($Pmail, 7, 1);
                            $pas2 = "$fcei1$fcei2";

                            $details['email'] = $Pmail;
                            $details['subject'] = $subj;
                            $details['blade'] = $blade;
                            $details['det'] = array('Im' => $Imx, 'theme' => $Aboutec, 'domen' => $domen, 'pas' => $pas2, 'email' => $Pmail);
                            $details['unsub'] = "<$Pmail>, <https://1ua.com.ua/admin_unsubscribe/$Pmail/$pas2>";
                            dispatch(new App\Jobs\SendEmailJob($details));


                            echo"$Numx $Imx  $mail_adminx lan $lan_user<br />";
                        } // проживаючі

                    } // перелік сусідніх міст


                    $mailput = "forumlist$id";
                    $q_s1[0] = ['forum', 1];
                    $q_s2[0] = ['forum', 1];
                    $q_s3[0] = ['forum', 1];

                    $filename = "sixhours.txt";
                    $truestat_file_contents = Storage::disk('public')->get($filename);
                    $lastmail = strstr($truestat_file_contents, $mailput);

                    if ($lastmail == "") {
                        $q_s2[0] = ['forum', 2];
                        Storage::disk('public')->append($filename, $mailput);
                    }

                    $filename = "oneday.txt";
                    $truestat_file_contents = Storage::disk('public')->get($filename);
                    $lastmail = strstr($truestat_file_contents, $mailput);

                    if ($lastmail == "") {
                        $q_s3[0] = ['forum', 3];
                        Storage::disk('public')->append($filename, $mailput);
                    }

                    $Allm = DB::table('Citymailpost')
                        ->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3) {
                            $query->whereNull('forum')
                                ->orWhere($q_s1)
                                ->orWhere($q_s2)
                                ->orWhere($q_s3);
                        })
                        ->where('id', $id)
                        ->select('mail_visitor')
                        ->get();

                    foreach ($Allm as $Alm) {

                        $Pmail = trim($Alm->mail_visitor);
                        if(strstr($allusersm,"$Pmail")==""){

                            $details['email'] = $Pmail;
                            $details['subject'] = "Новини з $statusm $City";
                            $details['City'] = $City;
                            $details['blade'] = "emails.city_news";
                            $details['det'] = array('theme' => $Aboutec,'id' => $id, 'domen' => $domen, 'City' => $City, 'email' => $Pmail);
                            $details['unsub'] = "<$Pmail>, <https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                            dispatch(new App\Jobs\SendEmailJob($details));
                        }
                    }

                } // якщо не пусті запитання
            } // перелік  id

        } // if($load_now<2){

    } // public function handle()


} // class send_mail_memoc
