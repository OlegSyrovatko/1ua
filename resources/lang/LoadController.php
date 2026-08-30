<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use File;

class LoadController extends Controller
{
    //         $_mktmy = microtime(true);
// echo"<br /> "; $_mktmy2 = microtime(true); echo round($_mktmy2 - $_mktmy,2);


    public function frie(Request $request)
    {

        $id = $request['id'];
        $npass1 = $request['npass1'];
        $npass1 = $npass1-1;
        $purp = $request['purp'];
        $sort = $request['sort'];
        $pref_page = __('messages.pref_page');
        $add_fr = __('messages.add_fr');
        $del_fr = __('messages.del_fr');
        $refuse = __('messages.refuse');
        $Delete = __('messages.Delete');
        $No = __('messages.cancel');
        $confirm = __('messages.confirm');
        $my_l = "i";
        $time_sec=time();

        if(Auth::user()) {
            $Numm =  Auth::user()->id;
        } else{$Numm = 0;}
        $Num = $id;
        $id = $id + 1;
        $id = $id - 1;
        if (is_int($id) != "true") {
            die("");
        }
        $Privatpass="stop";

        if (Auth::user()){

            $Alls = DB::table('Friends')->select('Num1', 'Num2')->
            where(function($query1) use ($Num) {
                $query1->where('Num1', $Num)
                    ->where('Argue', '=', 2);
            })->
            orWhere(function($query2) use ($Num) {
                $query2->where('Num2', $Num)
                    ->where('Argue', '=', 2);
            })->
            get();
            $fr_avt="";  $Numfr = "";
            foreach ($Alls as $All) { $Num1=$All->Num1; $Num2=$All->Num2;
                if($Num1==$Num){$Numfr=$Num2;} else{$Numfr=$Num1; }
                $fr_avt.= " $Numfr";  }
            $my_id = Auth::user()->id; $my_id2 = "$my_id";
            $isfriend = mb_strstr("$fr_avt", "$my_id2");
        } else {$isfriend = ""; $my_id = "999999999999999";}

        $Alls = DB::table('Private')->select('Page', 'ipban', 'ban')->
        where('Num', $id)->
        limit(1)->
        get();
        $pr=0;
        foreach ($Alls as $All) { $Sh_Page=$All->Page; $ipban=$All->ipban; $ban=$All->ban;
            $pr++; }
        if($pr==0) {$Sh_Page=1; $ipban=""; $ban="";}


        if($Sh_Page==1 || !$Sh_Page){$Privatpass="go";}
        else{if($Sh_Page==2 && Auth::user()){$Privatpass="go";}
        else{
            if($Sh_Page==3 && ($id==$my_id || $isfriend != "")){ $Privatpass="go"; }
            else if($Sh_Page==4&&$Num==$my_id){$Privatpass="go";}
        }
        }

        if (Auth::user()){
            if ($ban){
                if(mb_strstr((string)$ban, (string)$my_id)!=""){$Privatpass="stop";}
            }
        }
        else if($purp=="ourfriends"){
            $Privatpass="stop";
        }


        if($Privatpass == "stop"){

        }

        else{
            $Allf = DB::table('Friends')->select('Num1', 'Im1', 'Priz1', 'avatar1', 'Md', 'Num2', 'Im2', 'Priz2', 'avatar2', 'Argue')->
            where('Num1', $id)->
            orWhere('Num2', $id)->
            get();
            $nrfr = $Allf->count();


            if($Numm==0){$isfriend="";}
            $fr_avt=" "; $fr_avt2=" ";
            $a_fr=0; $a_rin=0; $a_onl=0;

            if($Numm>0&&$id!=$Numm){
                $group_our = array('Im','Priz','friend','avatar','dd','lv'); $a_our=0;

                $Allf2 = DB::table('Friends')->select('Num1','Num2')->
                where(function($query1) use ($Numm) {
                    $query1->where('Num1', $Numm)
                        ->where('Argue', '=', 2);
                })->
                orWhere(function($query2) use ($Numm) {
                    $query2->where('Num2', $Numm)
                        ->where('Argue', '=', 2);
                })->
                get();
                foreach ($Allf2 as $All) {
                    $Num1=$All->Num1; $Num2=$All->Num2;
                    if($Numm==$Num2){$fr_avt2.=" $Num1";} else{$fr_avt2.=" $Num2";}
                }
            }

            $group_fr = array('Im','Priz','friend','avatar','dd','lv');
            $group_in = array('Im','Priz','friend','avatar','dd','lv');

            if($nrfr!=0){

                foreach ($Allf as $All) {
                    $Num1=$All->Num1; $Im1=$All->Im1; $Priz1=$All->Priz1; $avatar1=$All->avatar1; $dd=$All->Md;
                    $Num2=$All->Num2; $Im2=$All->Im2; $Priz2=$All->Priz2; $avatar2=$All->avatar2; $Argue=$All->Argue;


                    if($Num2==$id&&$Argue==1&&$id==$Numm){
                        $group_in['Im'][$a_rin]=$Im1; $group_in['Priz'][$a_rin]=$Priz1; $group_in['friend'][$a_rin]=$Num1; $group_in['avatar'][$a_rin]=$avatar1; $group_in['dd'][$a_rin]=$dd;
                        $filename = "storage/last_visit/$Im1.txt";
                        $time_file=filemtime($filename);
                        $t=$time_sec-$time_file;
                        echo"t $t <br />";
                        $group_in['lv'][$a_rin]=$t;
                        $a_rin++;
                    }

                    if($Argue==2){

                        if($Num1==$Num){$Numfr=$Num2; $Imfr=$Im2; $Prizfr=$Priz2; $avatarfr=$avatar2;}
                        else{$Numfr=$Num1; $Imfr=$Im1; $Prizfr=$Priz1; $avatarfr=$avatar1;} $fr_avt.= " $Numfr";

                        if($Numm&&$Num!=$Numm){$isfriend = mb_strstr($fr_avt, $Numm);}

                        $group_fr['Im'][$a_fr]=$Imfr; $group_fr['Priz'][$a_fr]=$Prizfr; $group_fr['friend'][$a_fr]=$Numfr;
                        $group_fr['avatar'][$a_fr]=$avatarfr; $group_fr['dd'][$a_fr]=$dd;
                        $filename = "storage/last_visit/$Numfr.txt";
                        $time_file=filemtime($filename);
                        $t=$time_sec-$time_file;
                        $group_fr['lv'][$a_fr]=$t;


                        $isfriend2 = mb_strstr($fr_avt2, $Numfr);
                        if($isfriend2!=""&&($Numm&&$Num!=$Numm)){
                            $group_our['Im'][$a_our]=$Imfr; $group_our['Priz'][$a_our]=$Prizfr; $group_our['friend'][$a_our]=$Numfr;
                            $group_our['avatar'][$a_our]=$avatarfr; $group_our['dd'][$a_our]=$dd; $group_our['lv'][$a_our]=$t;
                            $a_our++;
                        }

                        $a_fr++;
                    }
                }
            }


            if($purp=="friends"){
                $group=$group_fr; $nr=$a_fr;
            }

            if($purp=="reqin"){
                $group=$group_in; $nr=$a_rin;
            }

            if($purp=="ourfriends" && $Numm>0){
                $group=$group_our; $nr=$a_our;
            }

            if($nr!=0){
                if ($sort=="date"){
                    array_multisort($group['dd'], SORT_DESC, $group['lv'], $group['Im'], $group['Priz'], $group['friend'], $group['avatar']);
                }

                if ($sort=="visit"){
                    array_multisort($group['lv'], SORT_ASC, $group['dd'], $group['Im'], $group['Priz'], $group['friend'], $group['avatar']);
                }

                if ($sort=="name"){
                    array_multisort($group['Im'], SORT_ASC, $group['Priz'], SORT_ASC, $group['lv'], $group['friend'], $group['dd'], $group['avatar']);
                }
            }



            $npass2=$npass1+101;
            $nrow=1;
            if($nr<$npass2){$npass2=$nr;}
            $fdiv = "shut";
            $arow=1;
            for($npass1; $npass1<$npass2; $npass1++){
                if($arow<=100){
                    $Img=$group['Im'][$npass1]; $Prizg=$group['Priz'][$npass1];
                    $Num_a=$group['friend'][$npass1]; $M1=$Num_a; $l_visit=$group['lv'][$npass1]; $Num_ag=$group['avatar'][$npass1];

                    if($nrow==1 || $nrow==3){
                        echo"<div class=\"layer1\"><table style=\"height: 200px; overflow: hidden\"><tr valign=top>";
                        $fdiv = "open";
                    }
                    echo"<td align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">";

                    if($Num_ag<10){$Num_ag=7;}

                    $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}
                    $f_l = "i";
                    $f_link = "$pref_page$my_l$M1";
                    $online = __('messages.online');
                    if ($l_visit<=500){}else{echo"<br />";}
                    echo"<div style=\"width: 128px; overflow: hidden\"><b><a href=/$f_link>";
                    if(mb_strlen($Img)>15){$Img = mb_substr($Img, 0, 15); $Img.="...";}
                    if(mb_strlen($Prizg)>15){$Prizg = mb_substr($Prizg, 0, 15); $Prizg.="...";}
                    echo"$Img<br />$Prizg</a></b><br />";
                    if ($l_visit<=500){echo"<br /><b><font color=green>$online</font></b>";}
                    echo"<div class=\"scale\" style=\"height: 100px; overflow: hidden\"><a href=/$f_link><img SRC=/storage/avatar/$Num_ag.jpg border=0></a></div>";

                    if($Numm>0){
                        $add_frl = "<div id=\"add_fr$M1\"><a onclick=add_fr('add_fr$M1','$M1')><b> $add_fr</b></a><br /></div>";
                        $del_frl = "<div id=\"del_fr0$M1\"><a onclick=del_fr0('del_fr0$M1','del_fr$M1')> $del_fr</a></div>
                                        <div id=\"del_fr$M1\" style=\"display: none;\"> $confirm <b><a href=### onclick=del_fr('del_fr$M1','$M1')>$Delete</a></b>
                                        <br /><br /><a  onclick=del_fr1('del_fr0$M1','del_fr$M1')>$No</a></br><br /> </div>";
                        $refuse_frl = "<div id=\"refuse_fr$M1\"><a onclick=refuse_fr('refuse_fr$M1','$M1')> <b>$refuse</b> </a><br /></div>";


                        if($purp=="friends"){
                            if ($Numm==$Num){
                                echo"$del_frl";
                            }
                            else{
                                $isfriend2 = mb_strstr($fr_avt2, $M1);
                                if($isfriend2!=""&&($Numm&&$M1!=$Numm)){echo"$del_frl";}
                                else{if($Numm!=$M1){echo"$add_frl";}}
                            }
                        }

                        if($purp=="reqin"){if($Numm==$Num){echo"$add_frl $refuse_frl";}} else{}
                        if($purp=="ourfriends"){echo"$del_frl";}

                    }

                    echo"</div>";
                    $nrow++;
                    echo"</td>";
                    if($nrow==3 || $nrow==5){ echo"</td></tr></table></div>"; $fdiv = "shut"; }
                    if($nrow==5){$nrow=1;}

                }
                $arow++;
            }
            if($fdiv == "open"){
                echo"<td width=50%> </td></tr></table></div>";
            }

            if($arow==102){
                $nnext = __('messages.nnext');
                echo"<div id=dp$npass1><br />
                        <table>
                        <tr><td class=\"fcomblue\" width=530>
                        <ul class=\"intop\"><li><a onClick=frie('$npass1','dp$npass1')>$nnext</a></a></li></ul>
                        </td></tr>
                        </table>
                        <br /><br /></div>";
            }

        }

    }



    public function add_fr(Request $request)
    {
        $Numfr = $request['fr'];
        $Md = date('Y-m-d H:i:s');
        $Numfr=$Numfr+1; $Numfr=$Numfr-1;
        if(is_int($Numfr)!="true"){die("");}

        if (Auth::user()) {
            $Numm = Auth::user()->id;
            $Alls = DB::table('Friends')->
            select('Argue')->
            where('Num1', '=', $Numfr)->
            where('Num2', '=', $Numm)->
            where('Argue', 1)->
            get();
            $nresultfr = $Alls->count();

            if ($nresultfr>0){
                $Imm2 = Auth::user()->Im;
                $Prizm2 = Auth::user()->Priz;
                $avatar2 = Auth::user()->avatar;
                $affected = DB::table('Friends')
                    ->where('Num2', $Numm)
                    ->where('Num1', $Numfr)
                    ->update(['Argue' => 2, 'Im2' => $Imm2, 'Priz2' => $Prizm2, 'avatar2' => $avatar2]);

                    $memory_contents = "";
                    $Allc = DB::table('users')->select('abin')->
                    where('Num', $Numm)->limit(1)->get();
                    foreach ($Allc as $All) {
                        $memory_contents = $All->abin;
                    }
                    if(mb_strlen($memory_contents)==0 || (!$memory_contents)){$memory_contents="mes0fr0";}
                    $frall = mb_strstr($memory_contents,"fr");
                    list($fr_old) = sscanf($frall, "fr%d"); if($fr_old<0){$fr=0;}
                    $fr=$fr_old-1;
                    $memory_contents_new = str_replace("fr$fr_old", "fr$fr", $memory_contents);
                    $affected = DB::table('users')
                    ->where('Num', $Numm)
                    ->update(['abin' => $memory_contents_new]);

                if($affected) {
                    $friend_added = __('messages.friend_added');
                    echo"$friend_added";

                    $filename0 = "storage/last_visit/$Numfr.txt";
                    if (file_exists($filename0) && filesize($filename0) > 0) {
                        $whattoread0 = @fopen($filename0, "r");
                        $memory_contents0 = fread($whattoread0, filesize($filename0));
                        fclose($whattoread0);
                        $notices = explode("#!:*&", $memory_contents0);
                        $lan_user = $notices[4];
                        $time_file0 = filemtime($filename0);
                    } else{$lan_user = "ua"; $time_file0 = 0;}


                    $time_sec = time();
                    $t = $time_sec - $time_file0;
                    if ($t <= 50000) {
                        if($avatar2>5){} else{$avatar2=7;}

                        if($lan_user=="ua"){
                            $r_else="#!:*&<table><tr><td valign=top width=150>
                                <b><font color=white>Новий друг</font></b><br>
                                <a href=/i$Numm><img style=\"margin: 0px 5px 0px 0px;\" border=0 SRC=/storage/avatar/s$avatar2.jpg align=left></a>
                                <a href=/i$Numm><font color=white>$Imm2 $Prizm2</font></a><br>
                                підтверджує Ваш запит і знаходиться в <br><a href=\"/friends/$Numfr/date\">списку Ваших друзів</a>
                                </td></tr></table>";
                        }
                        if($lan_user=="ru"){
                            $r_else="#!:*&<table><tr><td valign=top width=150>
                                <b><font color=white>Новый друг</font></b><br>
                                <a href=/ri$Numm><img style=\"margin: 0px 5px 0px 0px;\" border=0 SRC=/storage/avatar/s$avatar2.jpg align=left></a>
                                <a href=/ri$Numm><font color=white>$Imm2 $Prizm2</font></a><br>
                                подтверждает Ваш запрос и находится в <br><a href=\"/rfriends/$Numfr/date\">списке Ваших друзей</a>
                                </td></tr></table>";
                        }
                        if($lan_user=="en"){
                            $r_else="#!:*&<table><tr><td valign=top width=150>
                                <b><font color=white>New friend</font></b><br>
                                <a href=/ei$Numm><img style=\"margin: 0px 5px 0px 0px;\" border=0 SRC=/storage/avatar/s$avatar2.jpg align=left></a>
                                <a href=/ei$Numm><font color=white>$Imm2 $Prizm2</font></a><br>
                                confirms your request and is on <a href=\"/efriends/$Numfr/date\">Your friends list</a>
                                </td></tr></table>";
                        }


                        $filename = "storage/notice/$Numfr.txt";
                        $fsize = filesize($filename);
                        if ($fsize == 0) {
                            $records_else = $r_else;
                        } else {
                            $whattoread = @fopen($filename, "r");
                            $memory_contents = fread($whattoread, filesize($filename));
                            fclose($whattoread);
                            $records_else = $r_else .= "$memory_contents";
                        }

                        $fp = fopen($filename, 'a');
                        ftruncate($fp, 0);
                        fclose($fp);
                        $newfile = @fopen($filename, "a");
                        @fwrite($newfile, "$records_else");
                        fclose($newfile);
                    } // якщо недавно зайшов



                    if ($t > 25) {

                        $Allq = DB::table('users')->select('Im', 'friend', 'email')->
                        where('id', $Numfr)->limit(1)->get();
                        foreach ($Allq as $Alq) {
                            $Imfr = $Alq->Im;
                            $friendfr = $Alq->friend;
                            $email = $Alq->email;
                        }


                        $mailgo = "off";
                        $mailput = "friend$Numfr";
                        if (!$friendfr || $friendfr == 0) {
                            $mailgo = "on";
                        }
                        if ($friendfr == 1) {

                            $filename = "storage/sixhours.txt";
                            $whattoread = @fopen($filename, "r");
                            $truestat_file_contents = fread($whattoread, filesize($filename));
                            fclose($whattoread);
                            $lastmail = strstr($truestat_file_contents, $mailput);

                            if ($lastmail == "") {
                                $mailgo = "on";
                                $newfile = @fopen($filename, "a");
                                @fwrite($newfile, $mailput);
                                fclose($newfile);
                            }
                        }
                        if ($friendfr == 2) {

                            $filename = "storage/oneday.txt";
                            $whattoread = @fopen($filename, "r");
                            $truestat_file_contents = fread($whattoread, filesize($filename));
                            fclose($whattoread);

                            $lastmail = strstr($truestat_file_contents, $mailput);

                            if ($lastmail == "") {
                                $mailgo = "on";
                                $newfile = @fopen($filename, "a");
                                @fwrite($newfile, $mailput);
                                fclose($newfile);
                            }
                        }


                        if ($mailgo == "on") {
                            if ($lan_user == "ua") {
                                $subj = "$Imm2 $Prizm2 додає Вас до списку своїх друзів...";
                                $blade = "emails.frend_accept";
                            }
                            if ($lan_user == "ru") {
                                $subj = "$Imm2 $Prizm2 добавляет Вас в список своих друзей...";
                                $blade = "emails.rfrend_accept";
                            }
                            if ($lan_user == "en") {
                                $subj = "$Imm2 $Prizm2 adds You to his friends list...";
                                $blade = "emails.efrend_accept";
                            }
                            $Nameg = "$Imm2 $Prizm2";
                            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $details['email'] = trim($email);
                                $details['subject'] = $subj;
                                $details['blade'] = $blade;
                                $details['det'] = array('Nameg' => $Nameg, 'Namefr' => $Imfr, 'id' => $Numfr);
                                $details['unsub'] = "";
                                dispatch(new App\Jobs\SendEmailJob($details));
                            }
                        }
                    }





                } // якщо доданий був друг
            } // якщо була заявка

            if ($nresultfr==0){
                $Allsend = DB::table('Friends')->
                select('Argue')->
                where('Num1', '=', $Numm)->
                where('Num2', '=', $Numfr)->
                where('Argue', 1)->
                get();
                $Allsendn = $Allsend->count();
                if($Allsendn>0){
                    $q_waiting = __('messages.q_waiting');
                    echo"$q_waiting";
                }
                else{

                    $Imm = Auth::user()->Im;
                    $Prizm = Auth::user()->Priz;
                    $avatar1 = Auth::user()->avatar;
                    if($avatar1>5){} else{$avatar1=7;}
                    $aff = DB::table('Friends')->insert(['Num1' => $Numm, 'Im1' => $Imm, 'Priz1' => $Prizm, 'avatar1' => $avatar1,
                        'Num2' => $Numfr, 'Argue' => 1, 'Md' => $Md]);

                        $memory_contents = "";
                        $Allc = DB::table('users')->select('abin')->
                        where('Num', $Numfr)->limit(1)->get();
                        foreach ($Allc as $All) {
                            $memory_contents = $All->abin;
                        }
                        if(mb_strlen($memory_contents)==0 || (!$memory_contents)){$memory_contents="mes0fr0";}
                        $frall = mb_strstr($memory_contents,"fr");
                        list($fr_old) = sscanf($frall, "fr%d"); if($fr_old<0){$fr=0;}
                        $fr=$fr_old+1;
                        $memory_contents_new = str_replace("fr$fr_old", "fr$fr", $memory_contents);
                        $affected = DB::table('users')
                        ->where('Num', $Numfr)
                        ->update(['abin' => $memory_contents_new]);

                    if($aff){

                        $friend_send = __('messages.friend_send');
                        echo "$friend_send";


                        $filename0 = "storage/last_visit/$Numfr.txt";
                        if (file_exists($filename0) && filesize($filename0) > 0) {
                            $whattoread0 = @fopen($filename0, "r");
                            $memory_contents0 = fread($whattoread0, filesize($filename0));
                            fclose($whattoread0);
                            $notices = explode("#!:*&", $memory_contents0);
                            $lan_user = $notices[4];
                            $time_file0 = filemtime($filename0);
                        } else{$lan_user = "ua"; $time_file0 = 0;}


                        $time_sec = time();
                        $t = $time_sec - $time_file0;
                        if ($t <= 50000) {


                            if($lan_user=="ua"){
                                $r_else="#!:*&<table><tr><td valign=top width=150>
                                <b><font color=white>Новий друг</font></b><br>
                                <a href=/i$Numm><img style=\"margin: 0px 5px 0px 0px;\" border=0 SRC=/storage/avatar/s$avatar1.jpg align=left></a>
                                <a href=/i$Numm><font color=white>$Imm $Prizm</font></a><br>
                                хоче з Вами дружити <br><br><a href=\"/infriends/$Numfr/date\">Ви можете додати або відхилити заявку в друзі</a>
                                </td></tr></table>";
                            }
                            if($lan_user=="ru"){
                                $r_else="#!:*&<table><tr><td valign=top width=150>
                                <b><font color=white>Новый друг</font></b><br>
                                <a href=/ri$Numm><img style=\"margin: 0px 5px 0px 0px;\" border=0 SRC=/storage/avatar/s$avatar1.jpg align=left></a>
                                <a href=/ri$Numm><font color=white>$Imm $Prizm</font></a><br>
                                хочет с Вами дружить <br><br><a href=\"/rinfriends/$Numfr/date\">Вы можете добавить или отклонить заявку в друзья</a>
                                </td></tr></table>";
                            }
                            if($lan_user=="en"){
                                $r_else="#!:*&<table><tr><td valign=top width=150>
                                <b><font color=white>New friend</font></b><br>
                                <a href=/ei$Numm><img style=\"margin: 0px 5px 0px 0px;\" border=0 SRC=/storage/avatar/s$avatar1.jpg align=left></a>
                                <a href=/ei$Numm><font color=white>$Imm $Prizm</font></a><br>
                                wants to be friends with You <br><br><a href=\"/einfriends/$Numfr/date\">You can add or reject an request in friends</a>
                                </td></tr></table>";
                            }


                            $filename = "storage/notice/$Numfr.txt";
                            $fsize = filesize($filename);
                            if ($fsize == 0) {
                                $records_else = $r_else;
                            } else {
                                $whattoread = @fopen($filename, "r");
                                $memory_contents = fread($whattoread, filesize($filename));
                                fclose($whattoread);
                                $records_else = $r_else .= "$memory_contents";
                            }

                            $fp = fopen($filename, 'a');
                            ftruncate($fp, 0);
                            fclose($fp);
                            $newfile = @fopen($filename, "a");
                            @fwrite($newfile, "$records_else");
                            fclose($newfile);
                        } // якщо недавно зайшов



                        if ($t > 25) {

                            $Allq = DB::table('users')->select('Im', 'friend', 'email')->
                            where('id', $Numfr)->limit(1)->get();
                            foreach ($Allq as $Alq) {
                                $Imfr = $Alq->Im;
                                $friendfr = $Alq->friend;
                                $email = $Alq->email;
                            }


                            $mailgo = "off";
                            $mailput = "friend$Numfr";
                            if (!$friendfr || $friendfr == 0) {
                                $mailgo = "on";
                            }
                            if ($friendfr == 1) {

                                $filename = "storage/sixhours.txt";
                                $whattoread = @fopen($filename, "r");
                                $truestat_file_contents = fread($whattoread, filesize($filename));
                                fclose($whattoread);
                                $lastmail = strstr($truestat_file_contents, $mailput);

                                if ($lastmail == "") {
                                    $mailgo = "on";
                                    $newfile = @fopen($filename, "a");
                                    @fwrite($newfile, $mailput);
                                    fclose($newfile);
                                }
                            }
                            if ($friendfr == 2) {

                                $filename = "storage/oneday.txt";
                                $whattoread = @fopen($filename, "r");
                                $truestat_file_contents = fread($whattoread, filesize($filename));
                                fclose($whattoread);

                                $lastmail = strstr($truestat_file_contents, $mailput);

                                if ($lastmail == "") {
                                    $mailgo = "on";
                                    $newfile = @fopen($filename, "a");
                                    @fwrite($newfile, $mailput);
                                    fclose($newfile);
                                }
                            }


                            if ($mailgo == "on") {
                                if ($lan_user == "ua") {
                                    $subj = "$Imm $Prizm хоче додати Вас в друзі...";
                                    $blade = "emails.frendin";
                                }
                                if ($lan_user == "ru") {
                                    $subj = "$Imm $Prizm хочет добавить Вас в друзья...";
                                    $blade = "emails.rfrendin";
                                }
                                if ($lan_user == "en") {
                                    $subj = "$Imm $Prizm wants to add you as a friend...";
                                    $blade = "emails.efrendin";
                                }
                                $Nameg = "$Imm $Prizm";
                                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    $details['email'] = trim($email);
                                    $details['subject'] = $subj;
                                    $details['blade'] = $blade;
                                    $details['det'] = array('Nameg' => $Nameg, 'Namefr' => $Imfr, 'id' => $Numfr);
                                    $details['unsub'] = "";
                                    dispatch(new App\Jobs\SendEmailJob($details));
                                }
                            }
                        }

                    } // якщо доданий запис
                } // якщо не було раніше заявки
            } // якщо не було заявки
        } // якщо не було заявки
    }

    public function del_fr(Request $request)
    {
        $Numfr = $request['fr'];

        $Numfr=$Numfr+1; $Numfr=$Numfr-1;
        if(is_int($Numfr)!="true"){die("");}

        if (Auth::user()) {
            $Numm = Auth::user()->id;

            $aff = DB::table('Friends')->
            where(function($query1) use ($Numm, $Numfr) {
                $query1->where('Num1', $Numm)
                    ->where('Num2', $Numfr);
            })->
            orWhere(function($query2) use ($Numm, $Numfr) {
                $query2->where('Num2', $Numm)
                    ->where('Num1', $Numfr);
            })->
            delete();
            $mdelete = __('messages.mdelete');
            if($aff){echo"$mdelete";}

        }
    }

    public function ref_fr(Request $request)
    {
        $Numfr = $request['fr'];
        $Numfr=$Numfr+1; $Numfr=$Numfr-1;
        if(is_int($Numfr)!="true"){die("");}
        if (Auth::user()) {
            $Numm = Auth::user()->id;

            $aff = DB::table('Friends')->
            where('Num1', $Numfr)->
            where('Num2', $Numm)->
            where('Argue', 1)->
            delete();


            $memory_contents = "";
            $Allc = DB::table('users')->select('abin')->
            where('Num', $Numm)->limit(1)->get();
            foreach ($Allc as $All) {
                $memory_contents = $All->abin;
            }
            if(mb_strlen($memory_contents)==0 || (!$memory_contents)){$memory_contents="mes0fr0";}
            $frall = mb_strstr($memory_contents,"fr");
            list($fr_old) = sscanf($frall, "fr%d"); if($fr_old<0){$fr=0;}
            $fr=$fr_old-1;
            $memory_contents_new = str_replace("fr$fr_old", "fr$fr", $memory_contents);
            $affected = DB::table('users')
                ->where('Num', $Numm)
                ->update(['abin' => $memory_contents_new]);

            $mdelete = __('messages.mdelete');
            if($aff){
                echo"$mdelete";
            }

        }
    }




    public function redo(Request $request)
    {

        if (Auth::user()) {

            $Numm = Auth::user()->id;

            $Allb = DB::table('Msg')->select('readed')->
            where('Numreceive', $Numm)->
            where('readed', 2)->get();
            $nrredo = $Allb->count();

            $Allb = DB::table('Friends')->select('Num1')->
            where('Num2', $Numm)->
            where('Argue', 1)->get();
            $nrfrs = $Allb->count();

            $m_c_n = "mes$nrredo";
            $m_c_n.="fr$nrfrs";

            $affected = DB::table('users')
                ->where('Num', $Numm)
                ->update(['abin' => $m_c_n]);
            if($affected){echo"done";}

        }
    }



    public function sitemap(Request $request)
    {
        $sitemap = Storage::disk('public')->get('sitemap.xml');
        echo"$sitemap";
    }


    public function weather(Request $request)
    {
        $x = $request['x'];
        $y = $request['y'];

		function weatherForFive($x, $y) {
			try {
						
				$apiKey = "6e0df8e82af781ce5f5883bfecde10de";

				$url = "https://api.openweathermap.org/data/2.5/forecast?lat=$y&lon=$x&appid=$apiKey";
				$data = file_get_contents($url);

	
					$start = "list";

	            $pagec = explode("{\"dt\":", $data);
            $count_news = substr_count($data, "{\"dt\":");
            echo "count_news $count_news <br><br>";

            for ($n = 1; $n <= $count_news; $n++) {
                $contentpol = $pagec[$n];
				if($n == 1){continue;}
				    $start = "temp_min";
                    $position = strpos($contentpol, $start);
                    $tmin = substr($contentpol, $position + 10);
     
                    $finish = ",";
				    $position = strpos($tmin, $finish);
                    $tmin = substr($tmin, 0, $position);

					$tempmin = round((int)$tmin - 273.15);
					echo"min $tempmin ";
					
					$start = "temp_max";
                    $position = strpos($contentpol, $start);
                    $tmax = substr($contentpol, $position + 10);
     
                    $finish = ",";
				    $position = strpos($tmax, $finish);
                    $tmax = substr($tmax, 0, $position);
					$tempmax = round((int)$tmax - 273.15);
					echo"max $tempmax ";


					$start = "icon";
                    $position = strpos($contentpol, $start);
                    $icon = substr($contentpol, $position + 7);
     
                    $finish = "\"}]";
				    $position = strpos($icon, $finish);
                    $icon = substr($icon, 0, $position);
					echo"<img src=\"https://openweathermap.org/img/wn/$icon.png\";>";
					

					$start = "dt_txt";
                    $position = strpos($contentpol, $start);
                    $time = substr($contentpol, $position + 9);
     
                    $finish = "\"}";
				    $position = strpos($time, $finish);
                    $time = substr($time, 0, $position);
	
					$date = substr($time, 0, 10);

					$todayDate = date("Y-m-d");
					$tomorrowDate = date("Y-m-d", strtotime("+1 day"));
					$dayOfWeek = date("l", strtotime($date));
					if($date==$todayDate){$dayOfWeek=__('messages.today');}
					else if($date==$tomorrowDate){$dayOfWeek=__('messages.tomorrow');}
					echo"<br />$dayOfWeek ";
					
					$hours = substr($time, 11, 5);
					echo" $hours <br />";
					
		
					
			}
			
			
				// $stringToRender = renderWeatherForWeek($weatherArrayForWeek, $data['city']['name']);
				// $refsWeather['weatherBox']->innerHTML = $stringToRender;
			} catch (\Exception $error) {
				echo $error->getMessage(); 
			}
		}
		/*
		function renderWeatherForWeek($arr, $city) {
			$output = '';
			foreach ($arr as $data) {
				$weather = $data['weather'][0];
				$dt = explode(' ', $data['dt_txt'])[0];
				$temp = $data['main']['temp'];
				$weatherIcon = $weather['icon'];
				$weatherDescription = $weather['main'];

				$output .= "
				<div class=\"weather-day\">
					<p class=\"weather-day__temp\">" . (round($temp - 273) . '&deg;') . "</p>
					<div class=\"weather-day__icon-box\">
						<img src=\"http://openweathermap.org/img/wn/$weatherIcon@2x.png\" alt=\"Weather Icon\" class=\"weather-day__img\" />
					</div>
					<p class=\"weather-day__description\">$weatherDescription</p>
					<div class=\"weather-day__ds-box\">
						<p class=\"weather-day__date\">$dt</p>
						<div class=\"weather-day__city-box\">
							<p class=\"weather-day__sity\">$city</p>
						</div>
					</div>
				</div>";
			}

			return $output;
		}
		*/
function onWeatherForFive($data) {
	

/*     $arrDate = [];
    $decodedData = json_decode($data, true);

    if (isset($decodedData['list'])) {
        foreach ($decodedData['list'] as $item) {
            $dt = explode(' ', $item['dt_txt'])[0];

            if ($dt === date('Y-m-d') && date('H', strtotime($item['dt_txt'])) === '12:00:00') {
                $arrDate[] = $item;
				echo"$item ";
            }
        }
    } */

    return $arrDate;
}



	weatherForFive($x,$y);
    }

}


