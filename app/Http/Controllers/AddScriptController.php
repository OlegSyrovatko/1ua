<?php

// use App\Models\Allcitie;
namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;


class AddScriptController extends Controller
{
    public function rayc(Request $request)
    {
        $data = $request->validate([
            'nobl' => 'required'
        ]);
        $nobl = $data['nobl'];
        if(isset($request['qrayc'])){$qrayc = $request['qrayc'];}
        else{$qrayc = "";}

        if (App::isLocale('ua')) $cq = "City";
        if (App::isLocale('ru')) $cq = "City2";
        if (App::isLocale('en')) $cq = "City3";

        $Alls = DB::table('Allcities')->select('id', $cq)->
        where('obl', $nobl)->
        whereColumn('id', '=', 'rayc')->
        orderBy($cq, 'asc')->
        get();
        $opt_def = __('messages.chregionalcenter');
        $aaa = "<option value=> $opt_def </option>";
        foreach ($Alls as $All) {
            $id = $All->id;
            $City = $All->$cq;
            $sel_e = "";
            if($qrayc == $id){$sel_e = "selected";}
            $aaa .= "<option value=$id $sel_e>$City</option>";
        }
        return $aaa;
    }


    public function idc(Request $request)
    {
        $data = $request->validate([
            'rayc' => 'required'
        ]);
        $rayc = $data['rayc'];
        if(isset($request['qidc'])){$qidc = $request['qidc'];}
        else{$qidc = "";}

        if (App::isLocale('ua')) $cq = "City";
        if (App::isLocale('ru')) $cq = "City2";
        if (App::isLocale('en')) $cq = "City3";

        $Alls = DB::table('Allcities')->select('id', $cq)->
        where('rayc', $rayc)->
        orderBy($cq, 'asc')->
        get();
        $opt_def = __('messages.chCityvil');

        $aaa = "<option value=> $opt_def </option>";
        foreach ($Alls as $All) {
            $id = $All->id;
            $City = $All->$cq;
            $sel_e = "";
            if($qidc == $id){$sel_e = "selected";}
            $aaa .= "<option value=$id $sel_e>$City</option>";
        }

        return $aaa;
    }

/*
    public function addpassword()
    {

        $Allus = DB::table('users')->select('Num', 'passw')->
        whereNull('id')->
        whereNotNull('passw')->
        limit(500)->
        get();


        $aaa = "500";
        foreach ($Allus as $Allu) {
            $passw = $Allu->passw;
            $Num = $Allu->Num;
            $passw2 = Hash::make($passw);
            // $aaa.= "$Num ";

            $affected = DB::table('users')
                ->where('Num', $Num)
                ->update(['password' => $passw2, 'id' => $Num]);

        }
        return $aaa;


    }
*/

    public function emailconfirm($id, $key, $lanem)
    {

        $Allus2 = DB::table('users')->select('Num', 'email')->
        where('Num', $id)->
        limit(1)->
        get();
        $nu = 0;
        foreach ($Allus2 as $All2) {
            $idbd = $All2->Num;
            $embd = $All2->email;
            $nu++;
        }
        if ($lanem == "ua") {
            $me = "E-mail успішно підтверджений";
            $me2 = "E-mail не підтверджений, посилання не вірне";
            $me3 = "Перейти на головну сторінку";
        }
        if ($lanem == "ru") {
            $me = "E-mail успешно подтвержден";
            $me2 = "E-mail не подтвержден, ссылка не полная";
            $me3 = "Перейти на главную страницу";
        }
        if ($lanem == "en") {
            $me = "Email successfully verified";
            $me2 = "E-mail is not confirmed, the link is not valid";
            $me3 = "Go to the main page";
        }

        if ($nu == 1) {
            $fcei1 = substr($embd, 3, 1);
            $fcei2 = substr($embd, 7, 1);
            $fcii1 = substr($idbd, 2, 1);
            $fcii2 = substr($idbd, 4, 1);
            $fcii3 = substr($idbd, 6, 1);
            $uie = "$fcii1$fcei1$fcii2$fcei2$fcii3";
            if ($uie == $key) {
                $uie = "ok";
            } else {
                $uie = "null";
            }
        } else {
            $uie = "null";
        }
        if ($uie == "ok") {
            DB::table('users')
                ->where('id', $id)
                ->update(['aktiv' => 1]);
            return "<style>TABLE { COLOR:#29476b; FONT-FAMILY: \"Verdana\"}
             A { color : #2a507e; font-family : Verdana; text-decoration : none; }
                A:Active { color : #FF9966; } A:Hover { color : #000000; } </style>
                <div align='center'><table><tr><td align = center><br /><br /><h3> $me</h3><br /><br /><br />
                <a href='/'> $me3</a></td></tr></table></div>
               <script>
         setTimeout(function(){
            window.location.href = 'https://1ua.com.ua/';
         }, 5000);
      </script>
      ";

        } else {
            return "<style>TABLE { COLOR:#29476b; FONT-FAMILY: \"Verdana\"} </style>
                <div align='center'><table><tr><td align = center><br /><br /><h3> $me2  </h3><br /><br /><br />
                </td></tr></table></div>";
        }
    }


    public function emailremind(Request $request)
    {
        $data = $request->validate([
            'email3' => 'required|email'
        ]);
        $email3 = trim($data['email3']);

        $Allus3 = DB::table('users')->select('id', 'password')->
        where('email', $email3)->
        limit(1)->
        get();
        $nu = 0;
        foreach ($Allus3 as $All3) {
            $id = $All3->id;
            $password = $All3->password;
            $nu++;
        }
        if ($nu == 0) {
            $no_user = __('messages.no_user');
            $no_user_e = "$no_user $email3";
            return $no_user_e;
        } else {

            $fcei1 = substr($email3, 3, 1);
            $fcei2 = substr($email3, 7, 1);
            $fcii1 = substr($id, 2, 1);
            $fcii2 = substr($id, 4, 1);
            $fcii3 = substr($id, 6, 1);

            $lanem = App::currentLocale();
            if (!$lanem) {
                $lanem = "ua";
            }
            $lsend = "https://1ua.com.ua/password/$id/$fcii1$fcei1$fcii2$fcei2$fcii3";

            if ($lanem == "ua") {
                $blade = "emails.emailremind";
                $them = "Відновлення паролю на 1ua.com.ua";
            }
            if ($lanem == "ru") {
                $blade = "emails.remailremind";
                $them = "Восстановление пароля на 1ua.com.ua";
            }
            if ($lanem == "en") {
                $blade = "emails.eemailremind";
                $them = "1ua.com.ua: Password recovery";
            }
            // $subject = "=?utf8?b?" . base64_encode($them) . "?=";

            Mail::send($blade, array('lsend' => $lsend),
                function ($message) use ($email3, $them) {
                    $message->subject($them)->to($email3);
                });

            $Passsende = __('messages.Passsende');
            return $Passsende;
        }
    }


    public function setpassw(Request $request)
    {

        $data = $request->validate([
            'passw3' => 'required',
            'passw32' => 'required',
            'idbd' => 'required',
            'my_key' => 'required',
        ]);

        $passw3 = $data['passw3'];
        $passw32 = $data['passw32'];
        $idbd = $data['idbd'];
        $my_key = $data['my_key'];

        $Allus2 = DB::table('users')->select('Num', 'email')->
        where('Num', $idbd)->
        limit(1)->
        get();
        $nu = 0;
        foreach ($Allus2 as $All2) {
            $idbd2 = $All2->Num;
            $embd = $All2->email;
            $nu++;
        }

        if ($nu == 1) {
            $fcei1 = substr($embd, 3, 1);
            $fcei2 = substr($embd, 7, 1);
            $fcii1 = substr($idbd2, 2, 1);
            $fcii2 = substr($idbd2, 4, 1);
            $fcii3 = substr($idbd2, 6, 1);
            $uie = "$fcii1$fcei1$fcii2$fcei2$fcii3";
            if ($uie == $my_key) {
                $uie = "ok";
            } else {
                $uie = "null";
            }
        } else {
            $uie = "null";
        }

        if ($uie == "null") {
            return __('messages.nonlink');
        } else if (mb_strlen($passw3) < 6) {
            return __('messages.minpas');
        } else if (mb_strlen($passw3) > 20) {
            return __('messages.maxpas');
        } else if ($passw3 <> $passw32) {
            return __('messages.nontwopas');
        } else {
            $passw3 = Hash::make($passw3);
            $affected = DB::table('users')
                ->where('Num', $idbd)
                ->update(['password' => $passw3]);
            if ($affected) {
                return __('messages.welcomein');
            }
        }
    }


    public function ch_reg(Request $request)
    {
        if(Auth::user()) {
            $data = $request->validate([
                'Im3' => 'max:50',
                'Priz3' => 'max:50',
                'Who3' => 'max:50',
                'Bat3' => 'max:50',
            ]);

            $Im3 = $data['Im3'];
            $Priz3 = $data['Priz3'];
            $Who3 = $data['Who3'];
            $Bat3 = $data['Bat3'];
            $ctrl_hss= mb_strtolower($Im3);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $ctrl_hss= mb_strtolower($Priz3);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $ctrl_hss= mb_strtolower($Who3);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $ctrl_hss= mb_strtolower($Bat3);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            if ((!$Im3) || (!$Priz3) || (!$Who3)) {
                return __('messages.mydata_need');
            }
            if (mb_strlen($Im3) < 2 || mb_strlen($Priz3) < 2 || mb_strlen($Who3) < 2) {
                return __('messages.minpas2');
            } else if (mb_strlen($Im3) > 50 || mb_strlen($Priz3) > 50 || mb_strlen($Who3) > 50 || mb_strlen($Bat3) > 50) {
                return __('messages.maxpas');
            } else {

                $affected = DB::table('users')
                    ->where('Num', Auth::user()->id)
                    ->update(['Im' => $Im3, 'Priz' => $Priz3, 'Who' => $Who3, 'Bat' => $Bat3,]);
                DB::table('Friends')
                    ->where('Num1', Auth::user()->id)
                    ->update(['Im1' => $Im3, 'Priz1' => $Priz3]);
                DB::table('Friends')
                    ->where('Num2', Auth::user()->id)
                    ->update(['Im2' => $Im3, 'Priz2' => $Priz3]);
                if ($affected) {
                    return __('messages.mydatas');
                }
            }
        }
    }


    public function ch_eml_lgn(Request $request)
    {
        if(Auth::user()) {

            $data = $request->validate([
                'email3' => 'max:50|email',
                'passw3' => 'max:50',
                'passw23' => 'max:50',
            ]);

            $email3 = $data['email3'];
            $passw3 = $data['passw3'];
            $passw23 = $data['passw23'];

            if ((!$email3) || (!$passw3) || (!$passw23)) {
                return __('messages.mydata_need');
            } else if (mb_strlen($email3) < 6 || mb_strlen($passw3) < 6 || mb_strlen($passw23) < 6) {
                return __('messages.minpas6');
            } else if (mb_strlen($email3) > 50 || mb_strlen($passw3) > 50 || mb_strlen($passw23) > 50) {
                return __('messages.maxpas');
            } else if ($passw3 <> $passw23) {
                return __('messages.nontwopas');
            } else {

                $Alls = DB::table('users')->select('email')->
                where('id', Auth::user()->id)->
                limit(1)->
                get();
                foreach ($Alls as $All) {
                    $emailbd = $All->email;
                }

                $nem = 0;
                if ($emailbd <> $email3) {

                    $Alls2 = DB::table('users')->select('email')->
                    where('email', $email3)->
                    limit(1)->
                    get();

                    foreach ($Alls2 as $All) {
                        $emailbd2 = $All->email;
                        $nem++;
                    }
                }

                if ($nem > 0) {
                    return __('messages.log_eml_two');
                } else {
                    $passw33 = Hash::make($passw3);
                    $affected = DB::table('users')
                        ->where('Num', Auth::user()->id)
                        ->update(['password' => $passw33, 'passw' => $passw3]);
                    if ($affected) {
                        $mecho1 = __('messages.myemlpass');
                    }

                    $lanem = App::currentLocale();
                    if (!$lanem) {
                        $lanem = "ua";
                    }
                    if ($lanem == "ua") {
                        $blade = "emails.ch_eml_lgn";
                        $them = "Оновлення паролю на 1ua.com.ua";
                    }
                    if ($lanem == "ru") {
                        $blade = "emails.rch_eml_lgn";
                        $them = "Обновновление пароля на 1ua.com.ua";
                    }
                    if ($lanem == "en") {
                        $blade = "emails.ech_eml_lgn";
                        $them = "1ua.com.ua: Password update";
                    }

                    if ($emailbd <> $email3) {
                        $to = "$emailbd, $email3";
                        $mecho2 = __('messages.myemlupd');
                    } else {
                        $to = trim($emailbd);
                        $mecho2 = "";

                        // $subject = "=?utf8?b?" . base64_encode($them) . "?=";
                        Mail::send($blade, array('emailbd' => $to, 'passw3' => $passw3),
                            function ($message) use ($to, $them) {
                                $message->subject($them)->to($to);
                            });
                    }


                    if ($emailbd <> $email3) {

                        $id_old = Auth::user()->id;
                        $id = (Auth::user()->id) * 3;
                        $fcei1 = substr($email3, 3, 1);
                        $fcei2 = substr($email3, 7, 1);
                        $fcii1 = substr($id, 2, 1);
                        $fcii2 = substr($id, 4, 1);
                        $fcii3 = substr($id, 6, 1);

                        $lsend = "https://1ua.com.ua/emlupd/$id_old/$email3/$fcii1$fcei1$fcii2$fcei2$fcii3";

                        $lanem = App::currentLocale();
                        if (!$lanem) {
                            $lanem = "ua";
                        }
                        if ($lanem == "ua") {
                            $blade = "emails.ch_eml_lgn2";
                            $them = "Зміна Логіну (E-mail) на 1ua.com.ua";
                        }
                        if ($lanem == "ru") {
                            $blade = "emails.rch_eml_lgn2";
                            $them = "Изменение Логина (E-mail) на 1ua.com.ua";
                        }
                        if ($lanem == "en") {
                            $blade = "emails.ech_eml_lgn2";
                            $them = "1ua.com.ua: сhange of Login (E-mail)";
                        }

                        // $subject = "=?utf8?b?" . base64_encode($them) . "?=";
                        Mail::send($blade, array('lsend' => $lsend),
                            function ($message) use ($email3, $them) {
                                $message->subject($them)->to($email3);
                            });

                    }

                    $mecho = "$mecho1 $mecho2";
                    return $mecho;
                }
            }
        }
    }


    public function ch_domen(Request $request)
    {
        if(Auth::user()) {
            $data = $request->validate([
                'domen1' => 'max:30',
                'domen2' => 'max:30',
            ]);

            $domen1 = $data['domen1'];
            $domen2 = $data['domen2'];
            if ((!$domen1) || (!$domen2)) {
                return __('messages.mydata_need');
            }
            $ctrl_hss= mb_strtolower($domen1);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $ctrl_hss= mb_strtolower($domen2);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            if (mb_strlen($domen1) < 2 || mb_strlen($domen2) < 2) {
                return __('messages.minpas1');
            } else if (mb_strlen($domen1) > 20 || mb_strlen($domen2) > 30) {
                return __('messages.maxpas');
            } else {
                $nd = 0;
                $domen = "$domen1.$domen2";
                $Alls2 = DB::table('users')->select('domen')->
                where('domen', $domen)->
                limit(1)->
                get();
                foreach ($Alls2 as $All) {
                    $nd++;
                }

                if ($nd > 0) {
                    return __('messages.domen_in_use');
                } else {
                    if ((!preg_match('/[^A-Za-z0-9]/', $domen1)) && (!preg_match('/[^A-Za-z0-9]/', $domen2))) {

                        $affected = DB::table('users')
                            ->where('Num', Auth::user()->id)
                            ->update(['domen' => $domen]);
                        if ($affected) {
                            return __('messages.mydatas');
                        }
                    } else {
                        return __('messages.domen_only_en');
                    }
                }
            }
        }
    }


    public function setnews(Request $request)
    {
        if(Auth::user()) {
            $data = $request;
            $mnews_s = $data['mnews_s'];

            $affected = DB::table('users')
                ->where('Num', Auth::user()->id)
                ->update(['show_news' => $mnews_s]);
            if ($affected) {
                return __('messages.mydatas');
            }
        }
    }


    public function ch_data(Request $request)
    {
        if(Auth::user()) {
            $data = $request->validate([
                'sex' => 'max:1',
                'partner' => 'max:1',
                'bday' => 'max:2',
                'bmonth' => 'max:2',
                'byear' => 'max:4',
                'bday_visib' => 'max:1',
                'political' => 'max:1',
                'tabak' => 'max:1',
                'alkoh' => 'max:1',
                'insign' => 'max:120',
                'religion' => 'max:120',
                'mtel' => 'max:60',
            ]);

            $sex = $data['sex'];
            $partner = $data['partner'];
            $bday = $data['bday'];
            $bmonth = $data['bmonth'];
            $byear = $data['byear'];
            $bday_visib = $data['bday_visib'];
            $political = $data['political'];
            $tabak = $data['tabak'];
            $alkoh = $data['alkoh'];
            $insign = $data['insign'];
            $religion = $data['religion'];
            $mtel = $data['mtel'];
            $ctrl_hss= mb_strtolower($insign);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $ctrl_hss= mb_strtolower($religion);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $ctrl_hss= mb_strtolower($mtel);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $insignn = mb_strlen($insign);
            $religionn = mb_strlen($religion);
            $mteln = mb_strlen($mtel);
            if ($insignn > 119 || $religionn > 119 || $mteln > 60) {
                return __('messages.maxdata');
            } else {

                $affected = DB::table('users')
                    ->where('Num', Auth::user()->id)
                    ->update(['sex' => $sex, 'partner' => $partner, 'bday' => $bday, 'bmonth' => $bmonth, 'byear' => $byear,
                        'bday_visib' => $bday_visib, 'political' => $political, 'tabak' => $tabak, 'alkoh' => $alkoh,
                        'insign' => $insign, 'religion' => $religion, 'mtel' => $mtel]);


                $s_news = Auth::user()->show_news;
                $nowns = substr($s_news, 8, 1);
                if ($nowns == "" || $nowns == 1) {
                    // визначити старі дані до збереження нових. При порівнянні відправити в таблицю новин if($purp == "anketa"){ - adm.php
                    // $Nd = date('Y-n-j-H-i');

                }

                if ($affected) {
                    return __('messages.mydatas');
                }
            }
        }
    }


    public function avload(Request $request)
    {
        if(Auth::user()) {
            $a = 0;
            while ($a < 2) {
                $a = 0;
                $Num_av = round(rand(1, 9000000));
                $Num_av = $Num_av + 10000000;
                $SRC_f = "/avatar/$Num_av.jpg";
                $SRC_fb = "/avatar/b$Num_av.jpg";
                $SRC_f0 = "$Num_av.jpg";
                if (Storage::disk('public')->exists($SRC_f)) {
                    $msg = "<P> Файл $Num_av не створений!  </p>";
                } else {
                    $msg = "<P> Файл $Num_av створений!</p>";
                    $a = 2;
                }
                $a++;
            }

            $image = $request->file('image');
            if($image){
                $image_resize = Image::make($image->getRealPath());
                $image_resize->save(Storage::path('/public/tmp/') . $SRC_f0);

                $size = getimagesize(Storage::path('/public/tmp/') . $SRC_f0);
                $w = $size[0];
                $h = $size[1];
                $hw = $h / $w;
                if ($w >= 200) {
                    $new_h = round(200 * $hw);
                    $h_px=$new_h;
                    $w_px=200;
                    $image_resize->resize(200, $new_h);
                }
                else{
                    $h_px = $h;
                    $w_px = $w;
                }
                $path1 = $image_resize->save(Storage::path('/public/avatar/b') . $SRC_f0);
                if ($w >= 100) {
                    $new_h = round(100 * $hw);
                    $image_resize->resize(100, $new_h);
                }
                $path2 = $image_resize->save(Storage::path('/public/avatar/') . $SRC_f0);
                if ($w >= 50) {
                    $new_h = round(50 * $hw);
                    $image_resize->resize(50, $new_h);
                }
                $path3 = $image_resize->save(Storage::path('/public/avatar/s') . $SRC_f0);

                $affected = DB::table('users')
                    ->where('Num', Auth::user()->id)
                    ->update(['avatar' => $Num_av, 'avy' => $h_px, 'avx' => $w_px]);
                    DB::table('Friends')
                    ->where('Num1', Auth::user()->id)
                    ->update(['avatar1' => $Num_av, 'avx1' => $w_px, 'avy1' => $h_px]);
                    DB::table('Friends')
                    ->where('Num2', Auth::user()->id)
                    ->update(['avatar2' => $Num_av, 'avx2' => $w_px, 'avy2' => $h_px]);
                if ($path1 && $path2 && $path3 && $affected) {
                    $file = "<img src='/storage$SRC_fb'>";
                    $fdel = "/tmp/$SRC_f0";
                    $affected1 = Storage::disk('public')->delete($fdel);
                    return $file;
                }
            }
            else{return __('messages.sel_foto');}
        }
    }


    public function del_ava(Request $request)
    {
        if(Auth::user()) {
            $SRC_fdel = Auth::user()->avatar;
            $fdel = "/avatar/$SRC_fdel.jpg";
            $affected1 = Storage::disk('public')->delete($fdel);

            $affected2 = DB::table('users')
                ->where('Num', Auth::user()->id)
                ->update(['avatar' => NULL, 'avy' => 0, 'avx' => 0]);
            DB::table('Friends')
                ->where('Num1', Auth::user()->id)
                ->update(['avatar1' => 7, 'avy1' => 0, 'avx1' => 0]);
            DB::table('Friends')
                ->where('Num2', Auth::user()->id)
                ->update(['avatar2' => 7, 'avy2' => 0, 'avx2' => 0]);
            if ($affected1 && $affected2) {
                $file = "<img src=/b7.jpg>";
                return $file;
            }
        }
    }


    public function chadrr(Request $request)
    {
        if(Auth::user()) {
            $data = $request->validate([
                'Wherer' => 'required|max:20',
                'obl' => 'max:2',
                'idc' => 'max:7',
                'Adr' => 'max:200',
            ]);

            $Wherer = $data['Wherer'];
            $obl = $data['obl'];
            $idc = $data['idc'];
            $Adr = $data['Adr'];
            $ctrl_hss= mb_strtolower($Adr);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $Wherern = mb_strlen($Wherer);
            $Adrn = mb_strlen($Adr);
            if ($Wherern > 20) {
                return __('messages.maxdata');
            } else if ($Adrn > 200) {
                return __('messages.maxdata');
            } else if ($obl > 25 || $obl < 1 || (!$obl)) {
                return __('messages.oblneed');
            } else if (!$idc) {
                return __('messages.idneed');
            } else {
                $affected = DB::table('users')
                    ->where('Num', Auth::user()->id)
                    ->update(['obl' => $obl, 'idc' => $idc, 'Adr' => $Adr, 'Wherer' => $Wherer]);

                $s_news = Auth::user()->show_news;
                $nowns = substr($s_news, 8, 1);
                if ($nowns == "" || $nowns == 1) {
                    // в новини змінена прописка
                }
                if ($affected) {
                    return __('messages.mydatas');
                }
            }
        }
    }


    public function setprivate(Request $request)
    {
        if(Auth::user()) {
            $data = $request->validate([
                'mypage_show' => 'required|max:1',
                'mypage_do_forum' => 'required|max:1',
                's_l_visit' => 'required|max:1',
                'l_visit' => 'required|max:1',
                'do_message' => 'required|max:1',
                'set_q' => 'required|max:1',
                'ipban' => 'max:500',
            ]);

            $Page = $data['mypage_show'];
            $Page = "$Page";
            $Forum = $data['mypage_do_forum'];
            $s_l_visit = $data['s_l_visit'];
            $l_visit = $data['l_visit'];
            $do_mess = $data['do_message'];
            $set_q = $data['set_q'];
            $ipban = $data['ipban'];

            $Allws = DB::table('Mailpost')->select('Pmail')->
            where('Nump', Auth::user()->id)->get();
            $npm = 0;
            $Pmail_list = "";
            foreach ($Allws as $All) {
                $Pmail = $All->Pmail;
                $Pmail_list .= "$Pmail, ";
                $npm++;
            }

            if ($Page == "5") {
                $adm_send = "1";
            } else {
                $adm_send = "0";
            }
            DB::table('users')
                ->where('Num', Auth::user()->id)
                ->update(['adm_send' => $adm_send]);

            $ipbann = mb_strlen($ipban);
            if ($ipbann > 500) {
                return __('messages.maxdata');
            } else if ($npm > 0 && $Page <> "1") {
                $part1 = __('messages.del_followers1');
                $part2 = __('messages.del_followers2');
                $part3 = __('messages.del_followers3');
                $part4 = __('messages.del_followers4');
                $part_e = "$part1 $Pmail_list <br /><h3>$part2</h3> <table>
<tr><td class=\"fcomblue\" width=250>
<ul class=\"intop\"><li><a onclick = del_pmail()>$part3</a></li></ul>
</td><td class=\"fcomblue\" width=100>
<ul class=\"intop\"><li><a onclick = no_del_pmail()>$part4</a></li></ul>
</td></tr>
</table>";
                return $part_e;
            } else {

                $Allws = DB::table('Private')->select('Page')->
                where('Num', Auth::user()->id)->limit(1)->get();
                $npr = 0;
                foreach ($Allws as $All) {
                    $Pag = $All->Page;
                    $npr++;
                }

                $Forum = "$Forum";
                $s_l_visit = "$s_l_visit";
                $l_visit = "$l_visit";
                $do_mess = "$do_mess";
                $set_q = "$set_q";

                if ($npr == 0) {
                    $affected = DB::table('Private')->insert([
                        'Num' => Auth::user()->id, 'Page' => $Page, 'Forum' => $Forum, 's_l_visit' => $s_l_visit, 'l_visit' => $l_visit, 'do_mess' => $do_mess, 'set_q' => $set_q, 'ipban' => $ipban
                    ]);
                } else {
                    $affected = DB::table('Private')
                        ->where('Num', Auth::user()->id)
                        ->update(['Page' => $Page, 'Forum' => $Forum, 's_l_visit' => $s_l_visit, 'l_visit' => $l_visit, 'do_mess' => $do_mess, 'set_q' => $set_q, 'ipban' => $ipban]);
                }
                if ($affected) {
                    if ($Page == "5") {
                        return __('messages.del_followers6');
                    } else {
                        return __('messages.mydatas');
                    }
                }
            }
        }
    }


    public function del_all_followers(Request $request)
    {
        if(Auth::user()) {
            $affected = DB::table('Mailpost')
                ->where('Nump', Auth::user()->id)
                ->delete();
            if ($affected) {
                $part5 = __('messages.del_followers5');
                $part5 = "<b>$part5</b>";
                return $part5;
            }
        }
    }


    public function setnote(Request $request)
    {
        if(Auth::user()) {
            $data = $request->validate([
                'ntfriend' => 'required',
                'ntmail' => 'required',
                'ntforum' => 'required',
                'ntfrating' => 'required',
                'ntcomment' => 'required',
                'ntbd_send' => 'required',
                'ntadm_send' => 'required',
            ]);

            $friend = $data['ntfriend'];
            $friend = "$friend";
            $mail = $data['ntmail'];
            $mail = "$mail";
            $forum = $data['ntforum'];
            $forum = "$forum";
            $frating = $data['ntfrating'];
            $frating = "$frating";
            $comment = $data['ntcomment'];
            $comment = "$comment";
            $bd_send = $data['ntbd_send'];
            $adm_send = $data['ntadm_send'];


            $affected = DB::table('users')
                ->where('Num', Auth::user()->id)
                ->update(['friend' => $friend, 'mail' => $mail, 'forum' => $forum,
                    'frating' => $frating, 'comment' => $comment, 'bd_send' => $bd_send, 'adm_send' => $adm_send]);

            if ($affected) {
                return __('messages.myemlpass');
            }
        }
    }


    public function setonline()
    {

        if (Auth::user()) {
            $my_lv = Auth::user()->l_visit;
            $time_is = date('Y-m-d H:i:s');
            $to2 = strtotime($time_is);
            $from2 = strtotime($my_lv);
            $min5s_late = $to2 - $from2;

            if ($min5s_late > 200) {
                DB::table('users')
                    ->where('Num', Auth::user()->id)
                    ->update(['l_visit' => $time_is]);
            }
        }
    }


    public function up_vote(Request $request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $fc = $request['fc'];
        $id = $request['idpage'];
        $rate = $request['rate'];
        $m_new = "$ip $fc ";

        $filename = storage_path('app/public/ip.txt');
        $memory_ips = file_exists($filename)
            ? file_get_contents($filename)
            : '';

        $n = substr_count($memory_ips, $m_new);

      
        if ($rate) {
            if ($n < 2) {  
                //  \Log::info("increment {$n} ");
                DB::table('users')->where('Num', $id)->increment('rate', 1);
            }
            //  \Log::info("skip {$n} ");
        } else {
            DB::table('users')
                ->where('Num', $id)
                ->update(['rate' => 1]);
        }
    }


    public function up_votec(Request $request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $fc = $request['fc'];
        $obl = $request->input('obl_vote');
        $rayc = $request->input('rayc_vote');
        $id = $request->input('idpage');
        $rate = $request->input('rate');
        $m_new = "$ip $fc ";

        $obl = empty($obl) ? null : (int) $obl;
        $rayc = empty($rayc) ? null : (int) $rayc;
        $id = empty($id) ? 0 : (int) $id;

        $filename = storage_path('app/public/ip.txt');
        $memory_ips = file_exists($filename)
            ? file_get_contents($filename)
            : '';

        $n = substr_count($memory_ips, $m_new);

        if ($rate) {
            if ($n < 2) {
                //  \Log::info("increment {$n} ");
                DB::table('Allcities')->where('id', $id)->increment('sumr', 1);
            }
            // \Log::info("skip {$n} ");
        } else {
             
            DB::table('Allcities')
                ->where('id', $id)
                ->update(['sumr' => 1]);
        }

        if (!empty($rayc) && !empty($id)) {
            DB::table('stat')->updateOrInsert(
                ['city_id' => $id, 'id' => $rayc],
                ['views' => DB::raw('views + 1')]
            );
        }

        if (!empty($rayc) && !empty($obl)) {
            DB::table('stat')->updateOrInsert(
                ['id' => $rayc, 'obl' => $obl],
                ['views' => DB::raw('views + 1')]
            );
        }

        if (!empty($obl)) {
            DB::table('stat')->where('id', $obl)->increment('views', 1);
        }
    }


    public function question_inc(Request $request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $question = $request['question'];
        $id = $request['id'];
        $avt = $request['avt'];
        $id = $id + 1;
        $id = $id - 1;

        $ctrl_hss= mb_strtolower($question);
		if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        if ($question == "") {
            return __('messages.quest2');
        } else if (mb_strlen($question) > 500) {
            return __('messages.quest3');
        } else if ((!$ip) || (!$question) || (!$id) || (!$avt)) {
            return __('messages.no_data');
        } else {
            $Allb = DB::table('Privatec')->select('ipban')->
            where('id', $id)->limit(1)->get();
            foreach ($Allb as $Alb) {
                $ipban = $Alb->ipban;
            }
            $Allbn = $Allb->count();
            if ($Allbn == 0) {
                $ipban = "";
            }

            $isban = mb_strstr((string)$ipban, (string)$ip);
            if ($isban != "") {
                return __('messages.ip_ban');
            } else {

                if ($avt == "me") {
                    $avt = Auth::user()->id;
                    $sexm = Auth::user()->sex;
                    $Num_am = Auth::user()->avatar;
                    if ((!$Num_am) || $Num_am < 10) {
                        $Num_am = 7;
                    }
                    $sex = "$sexm$Num_am";
                    $Imm = Auth::user()->Im;
                    $Prizm = Auth::user()->Priz;
                    $my_email = Auth::user()->email;

                    $show_news = Auth::user()->show_news;
                    if (!$show_news) {
                        $nforum = 1;
                    } else {
                        $nforum = substr($show_news, 1, 1);
                    }

                } else {
                    $avt = "";
                    $Imm = "Хтось";
                    $Prizm = "";
                    $sex = 7;
                    $my_email = "";
                    $nforum = 1;
                }

                $Qd = date('Y-m-d-H-i-s');
                $questions_add = "#!^:*&#!:*&$question#!:*&$Qd#!:*&$avt#!:*&$ip";

                $Allq = DB::table('Allcities')
                    ->select('questions', 'ab', 'map_w', 'map_h')
                    ->where('id', $id)
                    ->limit(1)->get();
                foreach ($Allq as $Alq) {
                    $questions = $Alq->questions;
                    $ab = $Alq->ab;
                    $map_w = $Alq->map_w;
                    $map_h = $Alq->map_h;
                }

                if ($questions) {
                    $questions .= "$questions_add";
                } else {
                    $questions = "$questions_add";
                }

                $aff = DB::table('Allcities')
                    ->where('id', $id)
                    ->update(['questions' => $questions]);
                if ($aff) {

                    $pagec = explode("#!", $ab);
                    $status = $pagec[5];
                    $vol_karta = $pagec[6];
                    $City = $pagec[1];
                    $City2 = $pagec[2];
                    $obl = $pagec[3];
                    $City11 = $pagec[11];
                    $domen = $pagec[12];


                    if ($status) {
                        if ($status == 1) {
                            $ss = 1;
                            $statusnv = "Місто";
                            $statusn = "місто";
                            $statusr = "міста";
                            $statusd = "місту";
                            $statusm = "місті";
                            $statuso = "містом";
                        }
                        if ($status == 2) {
                            $ss = 2;
                            $statusnv = "Смт";
                            $statusn = "смт";
                            $statusr = "смт";
                            $statusd = "смт";
                            $statusm = "смт";
                            $statuso = "смт";
                        }
                        if ($status == 3) {
                            $ss = 3;
                            $statusnv = "Селище";
                            $statusn = "селище";
                            $statusr = "селища";
                            $statusd = "селищу";
                            $statusm = "селищі";
                            $statuso = "селищем";
                        }
                        if ($status == 4) {
                            $ss = 4;
                            $statusnv = "Село";
                            $statusn = "село";
                            $statusr = "села";
                            $statusd = "селі";
                            $statusm = "селі";
                            $statuso = "селом";
                        }
                        if ($status == 5) {
                            $ss = 5;
                            $statusnv = "Хутір";
                            $statusn = "хутір";
                            $statusr = "хутора";
                            $statusd = "хутору";
                            $statusm = "хуторі";
                            $statuso = "хутором";
                        }
                    } else {
                        if (!$vol_karta || $vol_karta < 20000) {
                            $ss = 4;
                            $statusnv = "Село";
                            $statusn = "село";
                            $statusr = "села";
                            $statusd = "селі";
                            $statusm = "селі";
                            $statuso = "селом";
                        }
                        if ($vol_karta >= 20000 && $vol_karta < 50000) {
                            $ss = 2;
                            $statusnv = "Місто (село)";
                            $statusn = "місто (село)";
                            $statusr = "міста (села)";
                            $statusd = "місту (селу)";
                            $statusm = "місті (селі)";
                            $statuso = "містом (селом)";
                        }
                        if ($vol_karta >= 50000) {
                            $ss = 1;
                            $statusnv = "Місто";
                            $statusn = "місто";
                            $statusr = "міста";
                            $statusd = "місту";
                            $statusm = "місті";
                            $statuso = "містом";
                        }
                    }


                    if ($nforum != "0") {

                        $Allw = DB::table('Memory')->select('news', 'avt')->
                        where('id', $id)->get();
                        $allusersn = " $avt";
                        foreach ($Allw as $Alw) {
                            $news = $Alw->news;
                            $whom = $Alw->avt;
                            if($whom>0){
                                if (mb_strstr((string)$allusersn, (string)$whom) == "" && $news != 1) {
                                    $allusersn .= " $whom ";
                                }
                            }

                        }

                        $flink1 = "/storage/karta/$obl/$id.jpg";
                        $flink0 = "/storage/karta/$obl/face_$id.jpg";
                        $file1 = public_path($flink1);
                        $file0 = public_path($flink0);
                        $map_w = $map_w/2.0212766;
                        $map_h = $map_h/2.0212766;
                        $src_ua = "";
                        $src_ru = "";
                        $src_en = "";
                        if(file_exists($file0)){
                            $src_ua = "<br /><a href='/c$id' class=\"scale\">
                                         <img  width=$map_w height=$map_h alt=\"Топографічна карта - $City\" title=\"Топографічна карта - $City\" src=\"$flink0\">
                                       </a>";
                            $src_ru = "<br /><a href='/rc$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Топографическая карта - $City2\" title=\"Топографическая карта - $City2\" src=\"$flink0\">
                                       </a>";
                            $src_en = "<br /><a href='/ec$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Topographic map - $City11\" title=\"Topographic map - $City11\" src=\"$flink0\">
                                       </a>";
                        }
                        else if(file_exists($file1)){
                            $src_ua = "<br /><a href='/c$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Топографічна карта - $City\" title=\"Топографічна карта - $City\" src=\"$flink1\">
                                       </a>";
                            $src_ru = "<br /><a href='/rc$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Топографическая карта - $City2\" title=\"Топографическая карта - $City2\" src=\"$flink1\">
                                       </a>";
                            $src_en = "<br /><a href='/ec$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Topographic map - $City11\" title=\"Topographic map - $City11\" src=\"$flink1\">
                                       </a>";
                        }
                        $theme = "c#&~$id#&~";
                        $ualine = "<a>Стіна-Запитання<br> $City</a>$src_ua";
                        $ruline = "<a>Стена-Вопросы<br> $City2</a>$src_ru";
                        $enline = "<a>Wall-Questions<br> $City11</a>$src_en";


                        DB::table('News')->insert([
                            'act' => 'nforum', 'Im' => $Imm, 'Priz' => $Prizm, 'sex' => $sex, 'theme' => $theme,
                            'ualine' => $ualine, 'ruline' => $ruline, 'enline' => $enline,
                            'avt' => $avt, 'whom' => $allusersn, 'forum' => $question, 'avt_fr' => $avt, 'obl' => $obl, 'Nd' => $Qd
                        ]);

                    }

                    $mailput = "forumlist$id";
                    $q_s1[0] = ['forum', 1];
                    $q_s2[0] = ['forum', 1];
                    $q_s3[0] = ['forum', 1];

                    $filename = "storage/sixhours.txt";
                    $whattoread = @fopen($filename, "r");
                    $truestat_file_contents = fread($whattoread, filesize($filename));

                    fclose($whattoread);
                    $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                    if ($lastmail == "") {
                        $q_s2[0] = ['forum', 2];
                        $newfile = @fopen($filename, "a") or die("Неможливо відкрити файл.");
                        @fwrite($newfile, $mailput) or die("Неможливо записати в файл.");
                        fclose($newfile);
                    }

                    $filename = "storage/oneday.txt";
                    $whattoread = @fopen($filename, "r") or die("Неможливо відкрити файл.");
                    $truestat_file_contents = fread($whattoread, filesize($filename));
                    fclose($whattoread);

                    $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                    if ($lastmail == "") {
                        $q_s3[0] = ['forum', 3];
                        $newfile = @fopen($filename, "a") or die("Неможливо відкрити файл.");
                        @fwrite($newfile, $mailput) or die("Неможливо записати в файл.");
                        fclose($newfile);
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
                        $subj = "Хтось залишив запитання на форумі $statusr $City";
                        // $subject = "=?utf8?b?" . base64_encode($subj) . "?=";
                        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                            $details['email'] = $Pmail;
                            $details['subject'] = $subj;
                            $details['blade'] = 'emails.question_inc';
                            $details['det'] = array('statusm' => $statusm, 'City' => $City, 'domen' => $domen, 'id' => $id, 'Pmail' => $Pmail);
                            $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                            dispatch(new App\Jobs\SendEmailJob($details));
                        }

                    }

                    $quest7 = __('messages.quest7');
                    $quest8 = __('messages.quest8');
                    $q78 = "<div style=\"text-align: left \"><b>$quest7</b><br />$quest8 </div><br />";

                    return $q78;
                } // if($aff){


            } // $isban!=""){return __(


        } // !$ip) || (!$question) || (!$id) || (!$avt)


    } // public function question_inc


    public function question_inp(Request $request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $question = $request['question'];
        $id = $request['id'];
        $avt = $request['avt'];
        $id = $id + 1;
        $id = $id - 1;

        $ctrl_hss= mb_strtolower($question);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        if ($question == "") {
            return __('messages.quest2');
        } else if (mb_strlen($question) > 500) {
            return __('messages.quest3');
        } else if ((!$ip) || (!$question) || (!$id) || (!$avt)) {
            return __('messages.no_data');
        } else {
            $Allb = DB::table('Private')->select('ipban')->
            where('Num', $id)->limit(1)->get();
            foreach ($Allb as $Alb) {
                $ipban = $Alb->ipban;
            }
            $Allbn = $Allb->count();
            if ($Allbn == 0) {
                $ipban = "";
            }

            $isban = mb_strstr((string)$ipban, (string)$ip);
            if ($isban != "") {
                return __('messages.ip_ban');
            } else {

                if ($avt == "me") {
                    $avt = Auth::user()->id;
                    $sexm = Auth::user()->sex;
                    $Num_am = Auth::user()->avatar;
                    if ((!$Num_am) || $Num_am < 10) {
                        $Num_am = 7;
                    }
                    $sex = "$sexm$Num_am";
                    $Imm = Auth::user()->Im;
                    $Prizm = Auth::user()->Priz;
                    $my_email = Auth::user()->email;

                    $show_news = Auth::user()->show_news;
                    if (!$show_news) {
                        $nforum = 1;
                    } else {
                        $nforum = substr($show_news, 1, 1);
                    }

                } else {
                    $avt = "";
                    $Imm = "Хтось";
                    $Prizm = "";
                    $sex = 7;
                    $my_email = "";
                    $nforum = 1;
                }

                $Qd = date('Y-m-d-H-i-s');
                $questions_add = "#!^:*&#!:*&$question#!:*&$Qd#!:*&$avt#!:*&$ip";

                $Allq = DB::table('users')->select('mail', 'Im', 'email', 'questions')->
                where('id', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {
                    $questions = $Alq->questions;
                    $mails = $Alq->mail;
                    $Imu = $Alq->Im;
                    $emailu = $Alq->email;
                }

                if ($questions) {
                    $questions .= "$questions_add";
                } else {
                    $questions = "$questions_add";
                }

                $aff = DB::table('users')
                    ->where('id', $id)
                    ->update(['questions' => $questions]);
                if ($aff) {


                    $filename0 = "storage/last_visit/$id.txt";
                    if (file_exists($filename0) && filesize($filename0) > 0) {
                        $whattoread0 = @fopen($filename0, "r");
                        $memory_contents0 = fread($whattoread0, filesize($filename0));
                        fclose($whattoread0);
                        $notices = explode("#!:*&", $memory_contents0);
                        $lan_user = $notices[4];

                        $time_file0 = filemtime($filename0);
                    } else {
                        $time_file0 = 0;
                        $lan_user = "ua";
                    }
                    $time_sec = time();
                    $t = $time_sec - $time_file0;


                    if ($t <= 50000) {

                        if ($lan_user == "ua") {
                            $qu_e = "Нове Запитання";
                            $qu_in = "i";
                        }
                        if ($lan_user == "ru") {
                            $qu_e = "Новый вопрос";
                            $qu_in = "ri";
                        }
                        if ($lan_user == "en") {
                            $qu_e = "New question";
                            $qu_in = "ei";
                        }
                        $r_else = "#!:*&<table><tr><td valign=top width=150><P style=\"color:white;\"><b>$qu_e</b><br /> <a href=\"/$qu_in$id\">$question</a></p><br /></td></tr></table>";

                        $filename = "storage/notice/$id.txt";
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
                    }

                    $mailgo = "off";
                    $mailput = "mail$id";
                    if (!$mails || $mails == 0) {
                        $mailgo = "on";
                    } else if ($mails == 1) {

                        $filename = "storage/sixhours.txt";
                        $whattoread = @fopen($filename, "r");
                        $truestat_file_contents = fread($whattoread, filesize($filename));
                        fclose($whattoread);
                        $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                        if ($lastmail == "") {
                            $mailgo = "on";
                            $newfile = @fopen($filename, "a");
                            @fwrite($newfile, $mailput);
                            fclose($newfile);
                        }
                    } else if ($mails == 2) {

                        $filename = "storage/oneday.txt";
                        $whattoread = @fopen($filename, "r");
                        $truestat_file_contents = fread($whattoread, filesize($filename));
                        fclose($whattoread);

                        $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                        if ($lastmail == "") {
                            $mailgo = "on";
                            $newfile = @fopen($filename, "a");
                            @fwrite($newfile, $mailput);
                            fclose($newfile);
                        }

                    }

                    if ($mailgo == "on") {
                        if ($lan_user == "ua") {
                            $subj = "Хтось залишив Вам запитання...";
                            $blade = "emails.question_inp";
                        }
                        if ($lan_user == "ru") {
                            $subj = "Кто-то оставил Вам вопрос...";
                            $blade = "emails.rquestion_inp";
                        }
                        if ($lan_user == "en") {
                            $subj = "Someone left You a question...";
                            $blade = "emails.equestion_inp";
                        }

                        // $subject = "=?utf8?b?" . base64_encode($subj) . "?=";
                        if (filter_var($emailu, FILTER_VALIDATE_EMAIL)) {
                            $details['email'] = trim($emailu);
                            $details['subject'] = $subj;
                            $details['blade'] = $blade;
                            $details['det'] = array('id' => $id, 'Imu' => $Imu);
                            $details['unsub'] = "";
                            dispatch(new App\Jobs\SendEmailJob($details));
                        }
                    }

                    $quest7 = __('messages.quest7');
                    $quest9 = __('messages.quest9');
                    $quest9 = str_replace("користувач", "$Imu", $quest9);
                    $quest9 = str_replace("пользователь", "$Imu", $quest9);
                    $quest9 = str_replace("user", "$Imu", $quest9);
                    $q79 = "<div style=\"text-align: left \"><b>$quest7</b><br />$quest9 </div><br />";

                    return $q79;
                } // if($aff){
            } // $isban!=""){return __(
        } // !$ip) || (!$question) || (!$id) || (!$avt)
    } // public function question_inp


    public function del_notice()
    {
        if(Auth::user()) {
            $Numm = Auth::user()->id;
            $filename = "storage/notice/$Numm.txt";

            $fp = fopen($filename, 'a');
            ftruncate($fp, 0);
            fclose($fp);
            $newfile = @fopen($filename, "a");
            @fwrite($newfile, "");
            fclose($newfile);
        }
    }


    public function load_notice()
    {
        if(Auth::user()) {
            $Numm = Auth::user()->id;
            $filename = "storage/notice/$Numm.txt";
            if (filesize($filename) > 0) {
                $whattoread = @fopen($filename, "r");
                $memory_contents = fread($whattoread, filesize($filename));
                fclose($whattoread);
                $records = explode("#!:*&", $memory_contents);
                $first_record = $records[1];

                $records_else = str_replace("#!:*&$first_record", "", $memory_contents);
                $records_else_n = substr_count($records_else, "#!:*&");
                $records_else_n2 = $records_else_n + 1;
                if ($records_else_n2 < 5) {
                    $records_else_n2 = "";
                }

                if ($first_record) {

                    echo "<table><tr><td align='center'>
                <div id=mainn>
                <table><tr valign='top'><td>$first_record</td><td width='20' align=right><br />";

                    if ($records_else_n > 0) {
                        echo "<a onclick=shutn() class=shutover> </a><br /><a>$records_else_n2</a><br />";
                    } else {
                        echo "<a class=shutover onclick=delnotice()> </a>";
                    }


                    echo "</td></tr></table>
                </div>";

                    /*
                    <table><tr><td>
                        <?
                        if((!$sound)||$sound=="on"){echo"<div id=sound><a href=## onclick=sound_off()><img border=0 src=/images/sound_on.png></a></div>";

                            if(strstr($first_record, "friend")!="" && strstr($first_record, "Old")==""){$audio_file="friend.swf";}
                            else if(strstr($first_record, "коментар")!=""||strstr($first_record, "комментарий")!=""||strstr($first_record, "запис")!=""||strstr($first_record, "omment")!=""||strstr($first_record, "mast.png")!=""){$audio_file="notice.swf";}
                            else if(strstr($first_record, "do_msg.php")!=""||strstr($first_record, "овідомлення")!=""||strstr($first_record, "ообщени")!=""||strstr($first_record, "essage")!=""){$audio_file="msg.swf";}
                            else if(strstr($first_record, "дивиться її :")!=""||strstr($first_record, "смотрит на Вас :")!=""||strstr($first_record, "look")!=""||strstr($first_record, "watch")!=""||strstr($first_record, "fotop.php>Ваших фото")!=""){$audio_file="guest.swf";}
                            else if(strstr($first_record, "hite>Стар")!=""||strstr($first_record, "hite>Old")!=""){$audio_file="hallo.swf";}
                            else {$audio_file="mark.swf";}

                            ?>
                            <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="0" HEIGHT="0">
                                <PARAM NAME="movie" VALUE="/ad_out/<?=$audio_file?>"><PARAM NAME="quality" VALUE="high"><PARAM NAME="bgcolor" VALUE="#FFFFFF">
                                <EMBED src="ad_out/<?=$audio_file?>" quality="high" bgcolor="#FFFFFF" WIDTH="0" HEIGHT="0" loop="1" TYPE="application/x-shockwave-flash" PLUGINSPAGE="https://www.macromedia.com/go/getflashplayer"></EMBED>
                            </OBJECT>

                            <?
                        }
                        if($sound=="off"){echo"<div id=sound><a href=## onclick=sound_on()><img border=0 src=/images/sound_off.png></a></div>";}
                        ?>
                    </td></tr></table>
                    */

                    echo "
            <table><tr><td width=200><div id=\"deln\" style=\"display: none;\">";

                    $lan_user = App::currentLocale();
                    if (!$lan_user) {
                        $lan_user = "ua";
                    }
                    if ($lan_user == "ua") {
                        $deln1 = "Видалити";
                        $deln2 = "всі сповіщення";
                    }
                    if ($lan_user == "ru") {
                        $deln1 = "Удалить";
                        $deln2 = "все оповещения";
                    }
                    if ($lan_user == "en") {
                        $deln1 = "Delete";
                        $deln2 = "all notifications";
                    }

                    echo "<br /><br /><table><tr><td align='center'>
                    <a class=shutover onclick=delnotice()></a>
                    <a onclick=delnotice()> <p style=\"color:white;\">$deln1<br /> $deln2 ($records_else_n) </p></a>
                 </td></tr></table><br /><br />";

                    echo "
            </div></td></tr></table>

            </td></tr></table>";

                    $fp = fopen($filename, 'a');
                    ftruncate($fp, 0);
                    fclose($fp);
                    $newfile = @fopen($filename, "a");
                    @fwrite($newfile, "$records_else");
                    fclose($newfile);

                }
            }
        }
    }


    public function ban_qc(Request $request)
    {
        $ipq = $request['ipq'];
        $id = $request['id'];
        if(Auth::user()) {

            $my_id = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $my_id)->where('Page', 'Memory')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if ($Alladn > 0 || $my_id = 72372396) {

                $Allb = DB::table('Privatec')->select('ipban')->
                where('id', $id)->limit(1)->get();
                $nr = $Allb->count();
                foreach ($Allb as $Alb) {
                    $ipban = $Alb->ipban;
                }
                $Allbn = $Allb->count();
                if ($Allbn == 0) {
                    $ipban = "";
                }
                $lock2 = __('messages.lock2');
                $lock3 = __('messages.lock3');

                if (mb_strstr((string)$ipban, (string)$ipq) != "") {
                    $res = "<p style=\" color:red; \">Ip $lock2</p>";
                } else {
                    if ($nr > 0) {
                        $ipban_new = $ipban .= " $ipq";
                        $aff = DB::table('Privatec')
                            ->where('id', $id)
                            ->update(['ipban' => $ipban_new]);
                    } else {
                        $aff = DB::table('Privatec')->insert(['id' => $id, 'ipban' => $ipq]);
                    }
                    if ($aff) {
                        $res = "<p style=\" color:red; \">Ip $lock3</p>";
                    }
                }
                return $res;
            }
        }
    }


    public function del_qc(Request $request)
    {
        $nq = $request['nq'] - 99;
        $id = $request['id'];
        if(Auth::user()) {

            $my_id = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $my_id)->where('Page', 'Memory')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();


            $Allb = DB::table('Allcities')->select('questions')->
            where('id', $id)->limit(1)->get();
            $nr = $Allb->count();
            foreach ($Allb as $Alb) {
                $questions = $Alb->questions;
            }
            $Allbn = $Allb->count();
            if ($Allbn == 0) {
                $questions = "";
            }
            if ($Allbn > 0) {


                $allquestions = $questions;
                $questions = explode("#!^:*&", $questions);
                $ques = $questions[$nq];
                $ques2 = $ques;
                $ques = "#!^:*&$ques";
                $que = explode("#!:*&", $ques2);
                $q_avt = $que[3];
				$q_data = $que[2];
                DB::table('News')
                    ->where('act', 'nforum')
                    ->where('Nd', $q_data)
                    ->where('avt', $q_avt)
                    ->delete();


                $questions_in = str_ireplace($ques, "", $allquestions);

                if ($Alladn > 0 || $my_id == $q_avt) {
                    $aff = DB::table('Allcities')
                        ->where('id', $id)
                        ->update(['questions' => $questions_in]);
                    if ($aff) {
                        $qdel = __('messages.qdel');
                        return $qdel;
                    }
                }
            }
        }
    }


    public function ask_publc(Request $request)
    {

        $nq = $request['nq'] - 99;
        $id = $request['id'];
        $ask = $request['ask'];

        $my_id = ""; $my_id2 = "5";
        if(Auth::user()) {
            $my_id = Auth::user()->id; $my_id2 = $my_id;
        }
        $ctrl_hss= mb_strtolower($ask);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        if (!$ask) {
            $ask_err = __('messages.ask_err');
            $ask_err = "s235*64@75$ask_err";
            return $ask_err;
        } else if (mb_strlen($ask) > 500) {
            $ask_err = __('messages.ask_err2');
            $ask_err = "s235*64@75$ask_err";
            return $ask_err;
        } else {

            $sq=0;
            $ip = $_SERVER['REMOTE_ADDR'];
            $Allq = DB::table('Privatec')->select('set_q','ipban','ComForBan')->
            where('id', $id)->limit(1)->get();
            foreach ($Allq as $Alq) { $set_q=$Alq->set_q; $ipban=$Alq->ipban; $ComForBan=$Alq->ComForBan; $sq++; }
            if($sq==0){$set_q=""; $ipban = ""; $ComForBan = "";}
            $go_q="stop";
            if($set_q=="a" || (!$set_q)){$go_q="go";}
            if($set_q=="b" && Auth::user()){$go_q="go";}
            if($set_q=="c"){$go_q="stop";}
            if(mb_strstr((string)$ipban, (string)$ip)!=""){$go_q="stop";}
            if(Auth::user()) {
                $my_id2 = Auth::user()->id;
                if(mb_strstr((string)$ComForBan, (string)$my_id2)!=""){$go_q="stop";}
            }
            if($go_q=="go"){

                $Allb = DB::table('Allcities')->select('questions', 'obl', 'ab', 'map_w', 'map_h')->
                where('id', $id)->limit(1)->get();

                foreach ($Allb as $Alb) {
                    $questions = $Alb->questions; $obl = $Alb->obl; $ab = $Alb->ab;
                    $map_w = $Alb->map_w; $map_h = $Alb->map_h;
                }
                $Allbn = $Allb->count();
                if ($Allbn == 0) {
                    $questions = "";
                }
                if ($Allbn > 0) {

                    $allquestions = $questions;
                    $questions = explode("#!^:*&", $questions);
                    $ques = $questions[$nq];
                    $question = explode("#!:*&", $ques);
                    $q_question = $question[1];
                    $q_avt = $question[3];


                    $Md = date('Y-m-d-H-i-s');
                    $Aboutep = "*&^@$q_avt <b>%^&@#</b> - $q_question<br \><b>&@#%^</b>- $ask";
                    $aff = DB::table('Memory')
                        ->insert(['id' => $id, 'obl' => $obl, 'Aboutec' => $Aboutep, 'avt' => $my_id, 'Md' => $Md, 'ip' => $ip]);

                    $ques = "#!^:*&$ques";
                    $questions_in = str_ireplace($ques, "", $allquestions);

                    $aff2 = DB::table('Allcities')->where('id', $id)
                        ->update(['questions' => $questions_in]);

                    if ($aff && $aff2) {

                        $pagec = explode("#!", $ab);
                        $status = $pagec[5];
                        $vol_karta = $pagec[6];
                        $City = $pagec[1];
                        $City2 = $pagec[2];
                        $obl = $pagec[3];
                        $City11 = $pagec[11];
                        $domen = $pagec[12];


                        if ($status) {
                            if ($status == 1) {
                                $statusr = "міста";
                                $statusm = "місті";
                            }
                            if ($status == 2) {
                                $statusr = "смт";
                                $statusm = "смт";
                            }
                            if ($status == 3) {
                                $statusr = "селища";
                                $statusm = "селищі";
                            }
                            if ($status == 4) {
                                $statusr = "села";
                                $statusm = "селі";
                            }
                            if ($status == 5) {
                                $statusr = "хутора";
                                $statusm = "хуторі";
                            }
                        } else {
                            if (!$vol_karta || $vol_karta < 20000) {
                                $statusr = "села";
                                $statusm = "селі";
                            }
                            if ($vol_karta >= 20000 && $vol_karta < 50000) {
                                $statusr = "міста (села)";
                                $statusm = "місті (селі)";
                            }
                            if ($vol_karta >= 50000) {
                                $statusr = "міста";
                                $statusm = "місті";
                            }
                        }

                        if(Auth::user()) {
                            $show_news = Auth::user()->show_news;
                            if (!$show_news) {
                                $nforum = 1;
                            } else {
                                $nforum = substr($show_news, 1, 1);
                            }
                        }
                        else{$nforum = 1;}
                        if ($nforum != 0) {

                            $Allw = DB::table('Memory')->select('news', 'avt')->
                            where('id', $id)->get();
                            $allusersn = " $my_id2 ";
                            foreach ($Allw as $Alw) {
                                $news = $Alw->news;
                                $whom = $Alw->avt;
                                if($whom){
                                    if (mb_strstr((string)$allusersn, (string)$whom) == "" && $news != 1) {
                                        $allusersn .= " $whom ";
                                    }
                                }

                            }
                            $flink1 = "/storage/karta/$obl/$id.jpg";
                            $flink0 = "/storage/karta/$obl/face_$id.jpg";
                            $file1 = public_path($flink1);
                            $file0 = public_path($flink0);
                            $map_w = $map_w/2.0212766;
                            $map_h = $map_h/2.0212766;
                            $src_ua = "";
                            $src_ru = "";
                            $src_en = "";
                            if(file_exists($file0)){
                                $src_ua = "<br /><a href='/c$id' class=\"scale\">
                                         <img  width=$map_w height=$map_h alt=\"Топографічна карта - $City\" title=\"Топографічна карта - $City\" src=\"$flink0\">
                                       </a>";
                                $src_ru = "<br /><a href='/rc$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Топографическая карта - $City2\" title=\"Топографическая карта - $City2\" src=\"$flink0\">
                                       </a>";
                                $src_en = "<br /><a href='/ec$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Topographic map - $City11\" title=\"Topographic map - $City11\" src=\"$flink0\">
                                       </a>";
                            }
                            else if(file_exists($file1)){
                                $src_ua = "<br /><a href='/c$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Топографічна карта - $City\" title=\"Топографічна карта - $City\" src=\"$flink1\">
                                       </a>";
                                $src_ru = "<br /><a href='/rc$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Топографическая карта - $City2\" title=\"Топографическая карта - $City2\" src=\"$flink1\">
                                       </a>";
                                $src_en = "<br /><a href='/ec$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Topographic map - $City11\" title=\"Topographic map - $City11\" src=\"$flink1\">
                                       </a>";
                            }
                            $theme = "c#&~$id#&~";
                            $ualine = "<a>Стіна-Запитання<br> $City</a>$src_ua";
                            $ruline = "<a>Стена-Вопросы<br> $City2</a>$src_ru";
                            $enline = "<a>Wall-Questions<br> $City11</a>$src_en";

                            if(Auth::user()) {
                                $Num_am = Auth::user()->avatar;
                                $Imm = Auth::user()->Im;
                                $Prizm = Auth::user()->Priz;
                                $sexm = Auth::user()->sex;
                                $sex = "$sexm$Num_am";
                                if (!$sex) {
                                    $sex = 0;
                                }
                            }
                            else{
                                $Imm = "Хтось";
                                $Prizm = "";
                                $sex = 0;
                            }

                            DB::table('News')->insert([
                                'act' => 'nforum', 'Im' => $Imm, 'Priz' => $Prizm, 'sex' => $sex, 'theme' => $theme,
                                'ualine' => $ualine, 'ruline' => $ruline, 'enline' => $enline,
                                'avt' => $my_id, 'whom' => $allusersn, 'forum' => $Aboutep, 'avt_fr' => $my_id, 'obl' => $obl, 'Nd' => $Md
                            ]);

                        }

                        $mailput = "forumlist$id";
                        $q_s1[0] = ['forum', 1];
                        $q_s2[0] = ['forum', 1];
                        $q_s3[0] = ['forum', 1];

                        $filename = "storage/sixhours.txt";
                        $whattoread = @fopen($filename, "r");
                        $truestat_file_contents = fread($whattoread, filesize($filename));

                        fclose($whattoread);
                        $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                        if ($lastmail == "") {
                            $q_s2[0] = ['forum', 2];
                            $newfile = @fopen($filename, "a");
                            @fwrite($newfile, $mailput);
                            fclose($newfile);
                        }

                        $filename = "storage/oneday.txt";
                        $whattoread = @fopen($filename, "r");
                        $truestat_file_contents = fread($whattoread, filesize($filename));
                        fclose($whattoread);

                        $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                        if ($lastmail == "") {
                            $q_s3[0] = ['forum', 3];
                            $newfile = @fopen($filename, "a");
                            @fwrite($newfile, $mailput);
                            fclose($newfile);
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
                            $subj = "Хтось відповів на запитання на форумі $statusr $City";
                            // $subject = "=?utf8?b?" . base64_encode($subj) . "?=";
                            if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                $details['email'] = $Pmail;
                                $details['subject'] = $subj;
                                $details['blade'] = 'emails.ask_publc';
                                $details['det'] = array('statusm' => $statusm, 'City' => $City, 'domen' => $domen, 'id' => $id, 'Pmail' => $Pmail);
                                $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                                dispatch(new App\Jobs\SendEmailJob($details));
                            }
                        }

                        $ask_result = __('messages.to_answ4');
                        return $ask_result;

                    }
                }
            }
        }
    }


    public function del_qp(Request $request)
    {
        $nq = $request['nq'] - 99;
        if(Auth::user()) {
            $id = Auth::user()->id;

            $Allb = DB::table('users')->select('questions')->
            where('id', $id)->limit(1)->get();
            $nr = $Allb->count();
            foreach ($Allb as $Alb) {
                $questions = $Alb->questions;
            }
            $Allbn = $Allb->count();
            if ($Allbn == 0) {
                $questions = "";
            }
            if ($Allbn > 0) {

                $allquestions = $questions;
                $questions = explode("#!^:*&", $questions);
                $ques = $questions[$nq];
                $ques2 = $ques;
                $ques = "#!^:*&$ques";

                $questions_in = str_ireplace($ques, "", $allquestions);

                $aff = DB::table('users')
                    ->where('id', $id)
                    ->update(['questions' => $questions_in]);
                if ($aff) {
                    $qdel = __('messages.qdel');
                    return $qdel;
                }
            }
        }
    }


    public function ban_qp(Request $request)
    {
        $ipq = $request['ipq'];
        if(Auth::user()){
            $id = Auth::user()->id;

            $Allb = DB::table('Private')->select('ipban')->
            where('Num', $id)->limit(1)->get();

            foreach ($Allb as $Alb) {
                $ipban = $Alb->ipban;
            }
            $Allbn = $Allb->count();
            if ($Allbn == 0) {
                $ipban = "";
            }
            $lock2 = __('messages.lock2');
            $lock3 = __('messages.lock3');

            if (mb_strstr((string)$ipban, (string)$ipq) != "") {
                $res = "<p style=\" color:red; \">Ip $lock2</p>";
            } else {
                if ($Allbn > 0) {
                    $ipban_new = $ipban .= " $ipq";
                    $aff = DB::table('Private')
                        ->where('Num', $id)
                        ->update(['ipban' => $ipban_new]);
                } else {
                    $aff = DB::table('Private')->insert(['Num' => $id, 'ipban' => $ipq]);
                }
                if ($aff) {
                    $res = "<p style=\" color:red; \">Ip $lock3</p>";
                }
            }
            return $res;
        }
    }


    public function ask_publp(Request $request)
    {
        $nq = $request['nq'] - 99;
        $ask = $request['ask'];
        if(Auth::user()) {
            $ctrl_hss= mb_strtolower($ask);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $id = Auth::user()->id;
            if (!$ask) {
                $ask_err = __('messages.ask_err');
                $ask_err = "s235*64@75$ask_err";
                return $ask_err;
            } else if (mb_strlen($ask) > 500) {
                $ask_err = __('messages.ask_err2');
                $ask_err = "s235*64@75$ask_err";
                return $ask_err;
            } else {

                $questions = Auth::user()->questions;

                $allquestions = $questions;
                $questions = explode("#!^:*&", $questions);
                $ques = $questions[$nq];
                $question = explode("#!:*&", $ques);
                $q_question = $question[1];
                $q_avt = $question[3];


                $Md = date('Y-m-d-H-i-s');
                $ip = $_SERVER['REMOTE_ADDR'];
                $Aboutep = "*&^@$q_avt <b>%^&@#</b> - $q_question<br \><b>&@#%^</b>- $ask";
                $aff = DB::table('Memoryp')
                    ->insert(['Num' => $id, 'Aboutep' => $Aboutep, 'avt' => $id, 'Md' => $Md, 'ip' => $ip]);

                $ques = "#!^:*&$ques";
                $questions_in = str_ireplace($ques, "", $allquestions);

                $aff2 = DB::table('users')->where('id', $id)
                    ->update(['questions' => $questions_in]);

                if ($aff && $aff2) {

                    $Num_am = Auth::user()->avatar;
                    if ((!$Num_am) || $Num_am < 10) {
                        $Num_am = 7;
                    }
                    $Imm = Auth::user()->Im;
                    $Prizm = Auth::user()->Priz;
                    $sexm = Auth::user()->sex;

                    $show_news = Auth::user()->show_news;
                    if (!$show_news) {
                        $nforum = 1;
                    } else {
                        $nforum = substr($show_news, 1, 1);
                    }

                    if ($nforum != 0) {

                        $Allw = DB::table('Private')->select('Page')->
                        where('Num', $id)->limit(1)->get();
                        $nr_private = $Allw->count();
                        foreach ($Allw as $Alw) {
                            $Pagep = $Alw->Page;
                        }
                        if ($nr_private == 0) {
                            $main_page = "1";
                        } else {
                            $main_page = "1";
                            if ((int)$Pagep > 1) {
                                $main_page = "2";
                            }
                        }

                        $theme = "p#&~$id#&~";
                        $ualine = "<a>Стіна-Запитання<br> своєї сторінки</a>";
                        $ruline = "<a>Стена-Вопросы<br> своей страницы</a>";
                        $enline = "<a>Wall-Questions<br> of page</a>";
                        $sex = "$sexm$Num_am";
                        if (!$sex) {
                            $sex = 0;
                        }

                        DB::table('News')->insert([
                            'act' => 'nforum', 'Im' => $Imm, 'Priz' => $Prizm, 'sex' => $sex, 'theme' => $theme,
                            'ualine' => $ualine, 'ruline' => $ruline, 'enline' => $enline,
                            'avt' => $id, 'forum' => $Aboutep, 'avt_fr' => $id, 'Nd' => $Md, 'main_page' => $main_page
                        ]);

                    }

                    $mailput = "forumlist$id";
                    $q_s1[0] = ['forum', 1];
                    $q_s2[0] = ['forum', 1];
                    $q_s3[0] = ['forum', 1];

                    $filename = "storage/sixhours.txt";
                    $whattoread = @fopen($filename, "r");
                    $truestat_file_contents = fread($whattoread, filesize($filename));

                    fclose($whattoread);
                    $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                    if ($lastmail == "") {
                        $q_s2[0] = ['forum', 2];
                        $newfile = @fopen($filename, "a");
                        @fwrite($newfile, $mailput);
                        fclose($newfile);
                    }

                    $filename = "storage/oneday.txt";
                    $whattoread = @fopen($filename, "r");
                    $truestat_file_contents = fread($whattoread, filesize($filename));
                    fclose($whattoread);

                    $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                    if ($lastmail == "") {
                        $q_s3[0] = ['forum', 3];
                        $newfile = @fopen($filename, "a");
                        @fwrite($newfile, $mailput);
                        fclose($newfile);
                    }

                    $Allm = DB::table('Mailpost')
                        ->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3) {
                            $query->whereNull('forum')
                                ->orWhere($q_s1)
                                ->orWhere($q_s2)
                                ->orWhere($q_s3);
                        })
                        ->where('Nump', $id)
                        ->select('Pmail')
                        ->get();

                    $nr_mail = $Allm->count();
                    if ($nr_mail > 0) {

                        $domen = Auth::user()->domen;
                        foreach ($Allm as $Alm) {
                            $Pmail = trim($Alm->Pmail);
                            if ($sexm == 1) {
                                $sexm_e = "додав";
                                $subj = "$Imm відповів на запитання";
                            } else if ($sexm == 2) {
                                $sexm_e = "додала";
                                $subj = "$Imm відповіла на запитання";
                            } else {
                                $sexm_e = "додав (ла)";
                                $subj = "$Imm відповів (ла) на запитання";
                            }
                            if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                $details['email'] = $Pmail;
                                $details['subject'] = $subj;
                                $details['blade'] = 'emails.ask_publp';
                                $details['det'] = array('Imm' => $Imm, 'Prizm' => $Prizm, 'sexm_e' => $sexm_e, 'domen' => $domen, 'id' => $id, 'Pmail' => $Pmail);
                                $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                                dispatch(new App\Jobs\SendEmailJob($details));
                            }
                        }
                    }

                    $ask_result = __('messages.to_answ4');
                    return $ask_result;

                }
            }
        }
    }


    public function mailadd(Request $request)
    {
        $Pmail = trim($request['Pmail']);
        $id = $request['id'];
        $ctrl_hss= mb_strtolower($Pmail);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {

            $Allb = DB::table('Mailpost')->select('Nump')->
            where('Nump', $id)->where('Pmail', $Pmail)->limit(1)->get();
            $Allbn = $Allb->count();
            if ($Allbn > 0) {
                $subscr4 = __('messages.subscr4');
                return $subscr4;
            } else {
                $Md = date('Y-m-d-H-i');
                $ip = $_SERVER['REMOTE_ADDR'];

                $aff = DB::table('Mailpost')->insert(['Nump' => $id, 'Pmail' => $Pmail, 'Md' => $Md, 'ip' => $ip]);
                if ($aff) {

                    $filename = "storage/last_visit/$id.txt";
                    if (file_exists($filename) && filesize($filename) > 0) {
                        $whattoread = @fopen($filename, "r");
                        $file_contents = fread($whattoread, filesize($filename));
                        fclose($whattoread);
                        $page = explode("#!:*&", $file_contents);
                        $Im = $page[1];
                        $Priz = $page[2];
                    } else {
                        $Im = "";
                        $Priz = "";
                    }

                    $lan_user = App::currentLocale();
                    if (!$lan_user) {
                        $lan_user = "ua";
                    }
                    if ($lan_user == "ua") {
                        $subj = "Підписка на розсилку";
                        $blade = "emails.mailadd";
                    }
                    if ($lan_user == "ru") {
                        $subj = "Подписка на рассылку";
                        $blade = "emails.rmailadd";
                    }
                    if ($lan_user == "en") {
                        $subj = "Newsletter subscription";
                        $blade = "emails.emailadd";
                    }

                    // $subject = "=?utf8?b?" . base64_encode($subj) . "?=";
                    if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                        $details['email'] = $Pmail;
                        $details['subject'] = $subj;
                        $details['blade'] = $blade;
                        $details['det'] = array('Im' => $Im, 'Priz' => $Priz, 'id' => $id, 'Pmail' => $Pmail);
                        $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                        dispatch(new App\Jobs\SendEmailJob($details));
                    }
                    $subscr5 = __('messages.subscr5');
                    return $subscr5;
                }
            }
        } else {
            $subscr3 = __('messages.subscr3');
            return $subscr3;
        }
    }


    public function mailchange(Request $request)
    {
        $Pmail = trim($request['Pmail']);
        $id = $request['id'];
        $ctrl_hss= mb_strtolower($Pmail);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {

            $Allm = DB::table('Mailpost')->select('forum', 'foto', 'comment')->
            where('Nump', $id)->
            where('Pmail', $Pmail)->
            limit(1)->get();
            $mbn = $Allm->count();

            if ($mbn == 0) {
                $subscr7 = __('messages.subscr7');
                return $subscr7;
            } else {
                foreach ($Allm as $All) {
                    $forum = $All->forum;
                    $foto = $All->foto;
                    $comment = $All->comment;
                }
                return view('inc.mailchange', ['id' => $id, 'forum' => $forum, 'foto' => $foto, 'comment' => $comment, 'Pmail' => $Pmail]);
            }
        } else {
            $subscr3 = __('messages.subscr3');
            return $subscr3;
        }
    }


    public function mailchangeset(Request $request)
    {
        $Pmail = trim($request['Pmail']);
        $id = $request['id'];
        $forum = $request['forum'];
        $foto = $request['foto'];
        $comment = $request['comment'];
        $ctrl_hss= mb_strtolower($Pmail);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {

            $affected = DB::table('Mailpost')
                ->where('Nump', $id)->where('Pmail', $Pmail)
                ->update(['forum' => $forum, 'foto' => $foto, 'comment' => $comment]);

            if ($affected) {
                return __('messages.myemlpass');
            }

        } else {
            $subscr3 = __('messages.subscr3');
            return $subscr3;
        }

    }

    public function maildel(Request $request)
    {
        $Pmail = trim($request['Pmail']);
        $id = $request['id'];
        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {

            $affected = DB::table('Mailpost')
                ->where('Nump', $id)->where('Pmail', $Pmail)
                ->delete();
            if ($affected) {
                $subscr6 = __('messages.subscr6');
                return $subscr6;
            }

        } else {
            $subscr3 = __('messages.subscr3');
            return $subscr3;
        }
    }


    public function mailaddc(Request $request)
    {
        $Pmail = trim($request['Pmail']);
        $ctrl_hss= mb_strtolower($Pmail);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        $id = $request['id'];
        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {

            $Allb = DB::table('Citymailpost')->select('id')->
            where('id', $id)->where('mail_visitor', $Pmail)->limit(1)->get();
            $Allbn = $Allb->count();
            if ($Allbn > 0) {
                $subscr4 = __('messages.subscr4');
                return $subscr4;
            } else {

                $aff = DB::table('Citymailpost')->insert(['id' => $id, 'mail_visitor' => $Pmail]);
                if ($aff) {

                    $Allc = DB::table('Allcities')->select('ab')->
                    where('id', $id)->limit(1)->get();

                    foreach ($Allc as $All) {
                        $ab = $All->ab;
                    }

                    $pagec = explode("#!", $ab);
                    $City = $pagec[1];
                    $City2 = $pagec[2];
                    $City11 = $pagec[11];

                    $lan_user = App::currentLocale();
                    if (!$lan_user) {
                        $lan_user = "ua";
                    }
                    if ($lan_user == "ua") {
                        $subj = "Підписка на розсилку";
                        $blade = "emails.mailaddc";
                        $Citym = $City;
                    }
                    if ($lan_user == "ru") {
                        $subj = "Подписка на рассылку";
                        $blade = "emails.rmailaddc";
                        $Citym = $City2;
                    }
                    if ($lan_user == "en") {
                        $subj = "Newsletter subscription";
                        $blade = "emails.emailaddc";
                        $Citym = $City11;
                    }

                    // $subject = "=?utf8?b?" . base64_encode($subj) . "?=";
                    if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                        $details['email'] = $Pmail;
                        $details['subject'] = $subj;
                        $details['blade'] = $blade;
                        $details['det'] = array('City' => $Citym, 'id' => $id, 'Pmail' => $Pmail);
                        $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                        dispatch(new App\Jobs\SendEmailJob($details));
                    }
                    $subscr5 = __('messages.subscr5');
                    return $subscr5;
                }
            }
        } else {
            $subscr3 = __('messages.subscr3');
            return $subscr3;
        }
    }


    public function mailchangec(Request $request)
    {
        $Pmail = trim($request['Pmail']);
        $ctrl_hss= mb_strtolower($Pmail);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        $id = $request['id'];
        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {

            $Allm = DB::table('Citymailpost')->select('forum', 'foto', 'comment', 'regp')->
            where('id', $id)->
            where('mail_visitor', $Pmail)->
            limit(1)->get();
            $mbn = $Allm->count();

            if ($mbn == 0) {
                $subscr7 = __('messages.subscr7');
                return $subscr7;
            } else {
                foreach ($Allm as $All) {
                    $forum = $All->forum;
                    $foto = $All->foto;
                    $comment = $All->comment;
                    $regp = $All->regp;
                }
                return view('inc.mailchangec', ['id' => $id, 'forum' => $forum, 'foto' => $foto, 'comment' => $comment, 'Pmail' => $Pmail, 'regp' => $regp]);
            }
        } else {
            $subscr3 = __('messages.subscr3');
            return $subscr3;
        }
    }


    public function mailchangecset(Request $request)
    {
        $Pmail = trim($request['Pmail']);
        $id = $request['id'];
        $forum = $request['forum'];
        $foto = $request['foto'];
        $comment = $request['comment'];
        $regp = $request['regp'];
        $ctrl_hss= mb_strtolower($Pmail);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {

            $affected = DB::table('Citymailpost')
                ->where('id', $id)->where('mail_visitor', $Pmail)
                ->update(['forum' => $forum, 'foto' => $foto, 'comment' => $comment, 'regp' => $regp]);

            if ($affected) {
                return __('messages.myemlpass');
            }

        } else {
            $subscr3 = __('messages.subscr3');
            return $subscr3;
        }

    }

    public function maildelc(Request $request)
    {
        $Pmail = trim($request['Pmail']);
        $id = $request['id'];
        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {

            $affected = DB::table('Citymailpost')
                ->where('id', $id)->where('mail_visitor', $Pmail)
                ->delete();
            if ($affected) {
                $subscr6 = __('messages.subscr6');
                return $subscr6;
            }

        } else {
            $subscr3 = __('messages.subscr3');
            return $subscr3;
        }
    }


    public function delmc(Request $request)
    {
        if(Auth::user()) {
            $id = $request['id'];
            $idrec = $request['idrec'];

            $id = $id + 1;
            $id = $id - 1;
            if (is_int($id) != "true") {
                die("");
            }
            $idrec = $idrec + 1;
            $idrec = $idrec - 1;
            if (is_int($idrec) != "true") {
                die("");
            }

            $Allm = DB::table('Memory')->select('Md', 'avt')->
            where('idrec', $idrec)->
            limit(1)->get();
            $Md = "";
            $avt = "";
            foreach ($Allm as $All) {
                $Md = $All->Md;
                $avt = $All->avt;
            }

            $Alld = DB::table('Allcities')->select('domen')->
            where('id', $id)->
            limit(1)->get();
            foreach ($Alld as $All) {
                $domen = $All->domen;
            }

            if (Auth::user()) {
                $my_id = Auth::user()->id;
            } else {
                $my_id = "";
            }
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $my_id)->where('Page', 'Memory')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();

            if ($Alladn > 0 || ($avt == $my_id && $avt > 10) || $my_id==72372396) {

                $like_s = "c#&~$id%";
                $like_s2 = "c#&~$domen%";
                $affected = DB::table('Memory')
                    ->where('idrec', $idrec)->delete();
                $Allc = DB::table('Memorym')->select('Md', 'avt')->
                where('idrec', $idrec)->get();
                foreach ($Allc as $Alc) {
                    $Mdm = $Alc->Md; $avtc = $Alc->avt;
                    DB::table('News')
                        ->where('act', 'ncomentm')
                        ->where('Nd', $Mdm)
                        ->where('avt', $avtc)
                        ->delete();
                }
                DB::table('Memorym')
                    ->where('idrec', $idrec)->delete();
                DB::table('News')
                    ->where('act', 'nforum')
                    ->where('Nd', $Md)
                    ->where('theme', 'like', $like_s)
                    ->delete();
                DB::table('News')
                    ->where('act', 'nforum')
                    ->where('Nd', $Md)
                    ->where('theme', 'like', $like_s)
                    ->delete();
                DB::table('News')
                    ->where('act', 'nforum')
                    ->where('Nd', $Md)
                    ->where('theme', 'like', $like_s2)
                    ->delete();
                if ($affected) {
                    $mdelete = __('messages.mdelete');
                    echo"<table><tr><td align=center><p style=\" margin: 5px 0px 10px 0px; \">$mdelete</p></td></tr></table>";
                }
            }
        }
    }


    public function fastenc(Request $request)
    {
        if(Auth::user()) {
            $id = $request['id'];
            $idrec = $request['idrec'];
            $afisha = $request['afisha'];
            $id = $id + 1;
            $id = $id - 1;
            if (is_int($id) != "true") {
                die("");
            }
            $idrec = $idrec + 1;
            $idrec = $idrec - 1;
            if (is_int($idrec) != "true") {
                die("");
            }

            if (Auth::user()) {
                $my_id = Auth::user()->id;
            } else {
                $my_id = "";
            }
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $my_id)->where('Page', 'Memory')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();

            if ($Alladn > 0) {

                $affected = DB::table('Memory')
                    ->where('idrec', $idrec)
                    ->update(['afisha' => $afisha]);

                if ($affected) {
                    if ($afisha == 1) {
                        $fast_e = __('messages.fasten2');
                    } else {
                        $fast_e = __('messages.unfasten2');
                    }
                    return $fast_e;
                }
            }
        }
    }


    public function delmp(Request $request)
    {
        if(Auth::user()) {
            $id = $request['id'];
            $idrec = $request['idrec'];

            $id = $id + 1;
            $id = $id - 1;
            if (is_int($id) != "true") {
                die("");
            }
            $idrec = $idrec + 1;
            $idrec = $idrec - 1;
            if (is_int($idrec) != "true") {
                die("");
            }

            $Allm = DB::table('Memoryp')->select('Md', 'avt')->
            where('idrec', $idrec)->
            limit(1)->get();
            $Md = "";
            $avt = "";
            foreach ($Allm as $All) {
                $Md = $All->Md;
                $avt = $All->avt;
            }

            if (Auth::user()) {
                $my_id = Auth::user()->id;
            } else {
                $my_id = "";
            }

            if ($my_id == $id || ($avt == $my_id && $avt > 10) || $my_id==72372396) {
                $domen = "";
                $Allu = DB::table('users')->select('domen')->
                where('id', $id)->
                limit(1)->get();
                foreach ($Allu as $All) {
                    $domen = $All->domen;
                }

                $like_s = "p#&~$domen%";
                $affected = DB::table('Memoryp')
                    ->where('idrec', $idrec)->delete();
                $Allc = DB::table('Memorymp')->select('Md', 'avt')->
                where('idrec', $idrec)->get();
                foreach ($Allc as $Alc) {
                    $Mdm = $Alc->Md; $avtc = $Alc->avt;
                    DB::table('News')
                        ->where('act', 'ncomentm')
                        ->where('Nd', $Mdm)
                        ->where('avt', $avtc)
                        ->delete();
                }
                DB::table('Memorymp')
                    ->where('idrec', $idrec)->delete();
                DB::table('News')
                    ->where('act', 'nforum')
                    ->where('Nd', $Md)
                    ->where('theme', 'like', $like_s)
                    ->delete();

                if ($affected) {
                    $mdelete = __('messages.mdelete');
                    echo"<table><tr><td align=center><p style=\" margin: 0px 0px 10px 0px; \">$mdelete</p></td></tr></table>";
                }
            }
        }
    }


    public function fastenp(Request $request)
    {
        if(Auth::user()) {
            $id = $request['id'];
            $idrec = $request['idrec'];
            $afisha = $request['afisha'];
            $id = $id + 1;
            $id = $id - 1;
            if (is_int($id) != "true") {
                die("");
            }
            $idrec = $idrec + 1;
            $idrec = $idrec - 1;
            if (is_int($idrec) != "true") {
                die("");
            }

            if (Auth::user()) {
                $my_id = Auth::user()->Num;
            } else {
                $my_id = "";
            }
            if ($my_id = $id) {

                $affected = DB::table('Memoryp')
                    ->where('idrec', $idrec)
                    ->update(['afisha' => $afisha]);

                if ($affected) {
                    if ($afisha == 1) {
                        $fast_e = __('messages.fasten2');
                    } else {
                        $fast_e = __('messages.unfasten2');
                    }
                    return $fast_e;
                }
            }
        }
    }


    public function memc(Request $request)
    {
        $id = $request['id'];
        $rayc = $request['rayc'];
        $page = $request['page'];
        $theme = $request['theme'];

        $move = $request['move'];
        if($move == "Desc"){$moves = "Desc"; $moves2 = "Asc";} else {$moves = "Asc"; $moves2 = "Desc";}
        $id = $id + 1; $id = $id - 1;
        if (is_int($id) != "true") { die("");}
        $rayc = $rayc + 1; $rayc = $rayc - 1;
        if (is_int($rayc) != "true") { die("");}
        $page = $page + 1; $page = $page - 1;
        $page2 = $page+1;

        if(Auth::user()){ $my_id = Auth::user()->Num;} else {$my_id = "";}

        $Allad = DB::table('City_Admin2')->select('id')->
        where('Num', $my_id)->where('Page', 'Memory')->where('id', $id)->
        limit(1)->get();
        $Alladn = $Allad->count();
        if ($Alladn > 0) {$admpass="ok";} else{$admpass="no";}

        if($page==1){$skip = 0;
            $qwans = __('messages.qwans');
            $enterv = __('messages.enterv');
            $unsort = __('messages.unsort');
            if($theme != "") {
                if($theme=="*&^@72438484"){$theme_e=$enterv;}
                else if($theme=="%^&@#"){$theme_e=$qwans;}
                else{$theme_e=$theme;}
                $goout_t = __('messages.goout_t');
                $go_main = __('messages.go_main');

                echo"<ul class=\"forum-menu\">
                        <li class=\"fcombold forum-menu-item w100\" onClick=\"mem($id, $rayc, '',1,'Desc');\">
                            <b > $goout_t \"$theme_e\" $go_main</b >
                        </li >
                    </ul >";
            }

            echo"
            <ul class=\"forum-menu\">
                <li class=\"fcom forum-menu-item w39\" onclick=\"mem($id,$rayc,'%^&@#',1,'$moves');\">
                    <b>$qwans</b>
                </li>
                <li class=\"fcom forum-menu-item w22\" onclick=\"mem($id,$rayc,'*&^@72438484',1,'$moves');\">
                    <b>$enterv</b>
                </li>
                <li class=\"fcom forum-menu-item w39\" onclick=\"mem($id,$rayc,'$theme',1,'$moves2');\">
                    <b>$unsort</b>
                </li>
            </ul>
           ";


        } else{$skip = ($page-1)*10;}


        if ($theme){$theme_s = "%$theme%";

            $Allm =DB::table('Memory')->select('afisha', 'theme', 'idrec','Aboutec','Nameg','Whog','r_gol','r_kol','rh','Md','Ip','avt')
                ->orWhere(function($query) use ($theme_s, $theme) {
                 $query->where('Aboutec', 'like', $theme_s)
                 ->orWhere('theme',$theme);
                })
                ->where('id',$id)
                ->orderBy('Md',$moves)
                ->skip($skip)->take(11)
                ->get();

        }
        else{
            $Allm =DB::table('Memory')->select('afisha', 'theme', 'idrec','Aboutec','Nameg','Whog','r_gol','r_kol','rh','Md','Ip','avt')
                 ->orWhere(function($query) {
                     $query->whereNull('theme')
                         ->orWhere('theme','');
                 })
                ->where('id',$id)
                ->orWhere('ray',$rayc)
                ->orderBy('Md',$moves)
                ->skip($skip)->take(11)
                ->get();
        }
        $nm=1;
        foreach ($Allm as $All) {
            if($nm<11){
                $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutec; $M2=$All->Nameg; $M3=$All->Whog; $r_gol=$All->r_gol; $rh=$All->rh;
                $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt;

                echo view('inc.memory', ['id' => $id, 'afisha' => $afisha, 'themeg' => $themeg, 'idrec' => $idrec, 'M1' => $M1, 'M2' => $M2, 'M3' => $M3, 'r_gol' => $r_gol, 'r_kol' => $r_kol,
                    'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'admpass' => $admpass, 'rh' => $rh, 'purp' => 'def']);

            }
            else { $nnext = __('messages.nnext');

            echo "<ul class=\"forum-menu\" id=\"fnext$page2\">
                    <li class=\"fcombold forum-menu-item w100\" onMouseOver=\"mem($id, $rayc, '$theme', $page2, '$moves');\" onClick=\"mem($id, $rayc, '$theme', $page2, '$moves');\">
                        <b>$nnext</b>
                    </li>
                </ul>";

            }
            $nm++;
        }

    }




    public function memp(Request $request)
    {
        $id = $request['id'];
        $page = $request['page'];
        $theme = $request['theme'];
        $move = $request['move'];
        if($move == "Desc"){$moves = "Desc"; $moves2 = "Asc";} else {$moves = "Asc"; $moves2 = "Desc";}
        $id = $id + 1; $id = $id - 1;
        if (is_int($id) != "true") { die("");}
         $page = $page + 1; $page = $page - 1;
        $page2 = $page+1;
         if($page==1){$skip = 0;
             $qwans = __('messages.qwans');
             $enterv = __('messages.enterv');
             $unsort = __('messages.unsort');
                if($theme != "") {
                    if($theme=="*&^@72438484"){$theme_e=$enterv;}
                    else if($theme=="%^&@#"){$theme_e=$qwans;}
                    else{$theme_e=$theme;}
                    $goout_t = __('messages.goout_t');
                    $go_main = __('messages.go_main');

                    echo"<ul class=\"forum-menu\">
                        <li class=\"fcombold forum-menu-item w100\" onClick=\"memp($id, '',1,'Desc');\">
                            <b > $goout_t \"$theme_e\" $go_main</b >
                        </li >
                    </ul >";

                }


             echo"
                <ul class=\"forum-menu\">
                    <li class=\"fcom forum-menu-item w39\" onclick=\"memp($id,'%^&@#',1,'$moves');\">
                        <b>$qwans</b>
                    </li>
                    <li class=\"fcom forum-menu-item w22\" onclick=\"memp($id,'*&^@72438484',1,'$moves');\">
                        <b>$enterv</b>
                    </li>
                    <li class=\"fcom forum-menu-item w39\" onclick=\"memp($id,'$theme',1,'$moves2');\">
                        <b>$unsort</b>
                    </li>
                </ul>
               ";

         } else{$skip = ($page-1)*10;}


            if ($theme){$theme_s = "%$theme%";
                $Allm =DB::table('Memoryp')->select('afisha', 'theme', 'idrec','Aboutep','r_gol','r_kol','rh','Md','Ip','avt')
                    ->orWhere(function($query) use ($theme_s, $theme) {
                        $query->where('Aboutep', 'like', $theme_s)
                            ->orWhere('theme',$theme);
                    })
                    ->where('Num',$id)
                    ->orderBy('Md',$moves)
                    ->skip($skip)->take(11)
                    ->get();
            }
            else{
                $Allm =DB::table('Memoryp')->select('afisha', 'theme', 'idrec','Aboutep','r_gol','r_kol','rh','Md','Ip','avt')
                    ->orWhere(function($query) {
                        $query->whereNull('theme')
                            ->orWhere('theme','');
                    })
                    ->where('Num',$id)
                    ->orderBy('Md',$moves)
                    ->skip($skip)->take(11)
                    ->get();
            }
        $nm=1;
        foreach ($Allm as $All) {
            if($nm<11){
                $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutep; $r_gol=$All->r_gol;
                $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt; $rh=$All->rh;

                echo view('inc.memoryp', ['id' => $id, 'afisha' => $afisha, 'themeg' => $themeg, 'idrec' => $idrec, 'M1' => $M1,
                    'r_gol' => $r_gol, 'r_kol' => $r_kol, 'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'rh' => $rh, 'purp' => 'def']);
            }
            else { $nnext = __('messages.nnext');

                echo "<ul class=\"forum-menu\" id=\"fnext$page2\">
                    <li class=\"fcombold forum-menu-item w100\" onMouseOver=\"memp($id, '$theme', $page2, '$moves');\" onClick=\"memp($id, '$theme', $page2, '$moves');\">
                        <b>$nnext</b>
                    </li>
                </ul>";

            }
            $nm++;
        }
    }



    public function mem_add(Request $request)
    {


        if(Auth::user()) {
            $id = $request['id'];
            $purp = $request['purp'];
            $id = $id + 1;
            $id = $id - 1;
            if (is_int($id) != "true") {
                die("");
            }
            $Aboutec = $request['memt'];
            $ctrl_hss= mb_strtolower($Aboutec);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            if(!$Aboutec){
                $mem_add0 = __('messages.mem_add0');
                $mem_add0 = "<table><tr><td>$mem_add0</td></tr></table>";
                return $mem_add0;
            }
            else if(substr_count($Aboutec,"youtu")>1){
                $one_youtube = __('messages.one_youtube');
                $one_youtube = "<table><tr><td>$one_youtube</td></tr></table>";
                return $one_youtube;
            }
            else{
                $Numm = Auth::user()->id;
                $sq=0;
                $Allq = DB::table('Privatec')->select('ComForBan')->
                where('id', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {$ComForBan=$Alq->ComForBan; $sq++; }
                if($sq==0){ $ComForBan = "";}
                if(mb_strstr((string)$ComForBan, (string)$Numm)=="") {

                    $theme = $request['theme_in'];
							$ctrl_hss= mb_strtolower($theme);
							if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
							$ctrl_hss2=$ctrl_hss.=">";
							if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
                    $theme = str_ireplace("\"", "'", $theme);
                    $Aboutec = str_ireplace("\n", "<br />", $Aboutec);
                    $Aboutec = str_ireplace("http://localhost:8000/sml", "<img src=/sml", $Aboutec);
                    $Aboutec = str_ireplace("https://1ua.com.ua/sml", "<img src=/sml", $Aboutec);
                    $Aboutec = str_ireplace("https://25ua.com/sml", "<img src=/sml", $Aboutec);


                    $ip = getenv('REMOTE_ADDR');

                    $Im = Auth::user()->Im;
                    $Priz = Auth::user()->Priz;
                    $email = Auth::user()->email;
                    $Who = Auth::user()->Who;
                    $Nameg = "$Im $Priz";
                    $Md = date('Y-m-d-H-i-s');

                    $Allc = DB::table('Allcities')->select('ab', 'map_w', 'map_h')->
                    where('id', $id)->limit(1)->get();
                    $nc = 0;
                    foreach ($Allc as $All) {
                        $ab = $All->ab;
						$map_w = $All->map_w;
						$map_h = $All->map_h;
                        $nc++;
                    }
                    if ($nc != 0) {
                        $pagec = explode("#!", $ab);
                        $status = $pagec[5];
                        $vol_karta = $pagec[6];
                        $City = $pagec[1];
                        $City2 = $pagec[2];
                        $obl = $pagec[3];
                        $City3 = $pagec[11];
                        $domen = $pagec[12];
                    }
                    if($purp=="do"){

                        $affected = DB::table('Memory')->insert([
                            'City' => $City, 'City2' => $City2, 'Nameg' => $Nameg, 'Whog' => $Who, 'obl' => $obl, 'id' => $id,
                            'Aboutec' => $Aboutec, 'theme' => $theme, 'mail_admin' => $email, 'avt' => $Numm, 'Md' => $Md, 'ip' => $ip
                        ]);




                        $show_news = Auth::user()->show_news;
                        if (!$show_news) {
                            $nforum = 1;
                        } else {
                            $nforum = substr($show_news, 1, 1);
                        }

                        if ($nforum != 0) {
                            if($theme){
                                $th_whe="Форум"; $th_wher="Форум"; $th_whee="Forum";
                                $Allw = DB::table('Memory')->select('news', 'avt')
                                    ->where('id', $id)
                                    ->where('theme', $theme)
                                    ->get();
                            }
                            else {
                                $th_whe="Стіна"; $th_wher="Стена"; $th_whee="Wall";
                                $Allw = DB::table('Memory')->select('news', 'avt')->
                                where('id', $id)->get();
                            }

                            $allusersn = " $Numm";
                            foreach ($Allw as $Alw) {
                                $news = $Alw->news;
                                $whom = $Alw->avt;
                                if($whom>0){
                                    if (mb_strstr((string)$allusersn, (string)$whom) == "" && $news != 1) {
                                        $allusersn .= " $whom ";
                                    }
                                }

                            }

							$flink1 = "/storage/karta/$obl/$id.jpg";
							$flink0 = "/storage/karta/$obl/face_$id.jpg";
							$file1 = public_path($flink1);
							$file0 = public_path($flink0);
							$map_w = $map_w/2.0212766;
							$map_h = $map_h/2.0212766;
							$src_ua = "";
							$src_ru = "";
							$src_en = "";
							if(file_exists($file0)){
								$src_ua = "<br /><a href='/c$id' class=\"scale\">
											 <img  width=$map_w height=$map_h alt=\"Топографічна карта - $City\" title=\"Топографічна карта - $City\" src=\"$flink0\">
										   </a>";
								$src_ru = "<br /><a href='/rc$id' class=\"scale\">
											 <img width=$map_w height=$map_h alt=\"Топографическая карта - $City2\" title=\"Топографическая карта - $City2\" src=\"$flink0\">
										   </a>";
								$src_en = "<br /><a href='/ec$id' class=\"scale\">
											 <img width=$map_w height=$map_h alt=\"Topographic map - $City3\" title=\"Topographic map - $City3\" src=\"$flink0\">
										   </a>";
							}
							else if(file_exists($file1)){
								$src_ua = "<br /><a href='/c$id' class=\"scale\">
											 <img width=$map_w height=$map_h alt=\"Топографічна карта - $City\" title=\"Топографічна карта - $City\" src=\"$flink1\">
										   </a>";
								$src_ru = "<br /><a href='/rc$id' class=\"scale\">
											 <img width=$map_w height=$map_h alt=\"Топографическая карта - $City2\" title=\"Топографическая карта - $City2\" src=\"$flink1\">
										   </a>";
								$src_en = "<br /><a href='/ec$id' class=\"scale\">
											 <img width=$map_w height=$map_h alt=\"Topographic map - $City3\" title=\"Topographic map - $City3\" src=\"$flink1\">
										   </a>";
							}

                            $ualine="<a>$th_whe<br /> $City<br />$theme</a>$src_ua";
                            $ruline="<a>$th_wher<br /> $City2<br />$theme</a>$src_ru";
                            $enline="<a>$th_whee<br /> $City3<br />$theme</a>$src_en";
                            $themen="c#&~$domen#&~$theme";
                            $Num_am = Auth::user()->avatar;
                            if ((!$Num_am) || $Num_am < 10) {
                                $Num_am = 7;
                            }
                            $Imm = Auth::user()->Im;
                            $Prizm = Auth::user()->Priz;
                            $sexm = Auth::user()->sex;
                            $sex = "$sexm$Num_am";
                            if (!$sex) {
                                $sex = 0;
                            }

                            DB::table('News')->insert([
                                'act' => 'nforum', 'Im' => $Imm, 'Priz' => $Prizm, 'sex' => $sex, 'theme' => $themen,
                                'ualine' => $ualine, 'ruline' => $ruline, 'enline' => $enline,
                                'avt' => $Numm, 'whom' => $allusersn, 'forum' => $Aboutec, 'avt_fr' => $Numm, 'obl' => $obl, 'Nd' => $Md
                            ]);

                        }

                        if($affected){


                            $mailput = "forumlist$id";
                            $q_s1[0] = ['forum', 1];
                            $q_s2[0] = ['forum', 1];
                            $q_s3[0] = ['forum', 1];

                            $filename = "storage/sixhours.txt";
                            $whattoread = @fopen($filename, "r");
                            $truestat_file_contents = fread($whattoread, filesize($filename));

                            fclose($whattoread);
                            $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                            if ($lastmail == "") {
                                $q_s2[0] = ['forum', 2];
                                $newfile = @fopen($filename, "a");
                                @fwrite($newfile, $mailput);
                                fclose($newfile);
                            }

                            $filename = "storage/oneday.txt";
                            $whattoread = @fopen($filename, "r");
                            $truestat_file_contents = fread($whattoread, filesize($filename));
                            fclose($whattoread);

                            $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                            if ($lastmail == "") {
                                $q_s3[0] = ['forum', 3];
                                $newfile = @fopen($filename, "a");
                                @fwrite($newfile, $mailput);
                                fclose($newfile);
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



                            if ($status) {
                                if ($status == 1) {
                                    $ss = 1;
                                    $statusr = "міста";
                                    $statusm = "місті";
                                }
                                if ($status == 2) {
                                    $ss = 2;
                                    $statusr = "смт";
                                    $statusm = "смт";
                                }
                                if ($status == 3) {
                                    $ss = 3;
                                    $statusr = "селища";
                                    $statusm = "селищі";
                                }
                                if ($status == 4) {
                                    $ss = 4;
                                    $statusr = "села";
                                    $statusm = "селі";
                                }
                                if ($status == 5) {
                                    $ss = 5;
                                    $statusr = "хутора";
                                    $statusm = "хуторі";
                                }
                            } else {
                                if (!$vol_karta || $vol_karta < 20000) {
                                    $ss = 4;
                                    $statusr = "села";
                                    $statusm = "селі";
                                }
                                if ($vol_karta >= 20000 && $vol_karta < 50000) {
                                    $ss = 2;
                                    $statusr = "міста (села)";
                                    $statusm = "місті (селі)";
                                }
                                if ($vol_karta >= 50000) {
                                    $ss = 1;
                                    $statusr = "міста";
                                    $statusm = "місті";
                                }
                            }

                            foreach ($Allm as $Alm) {

                                $Pmail = trim($Alm->mail_visitor);
                                $subj = "Хтось зробив на форумі $statusr $City";
                                // $subject = "=?utf8?b?" . base64_encode($subj) . "?=";
                                if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                    $details['email'] = $Pmail;
                                    $details['subject'] = $subj;
                                    $details['blade'] = 'emails.publc';
                                    $details['det'] = array('statusm' => $statusm, 'City' => $City, 'domen' => $domen, 'id' => $id, 'Pmail' => $Pmail);
                                    $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                                    dispatch(new App\Jobs\SendEmailJob($details));
                                }
                            }


                        }


                        $Alidc = DB::table('Memory')->select('idrec')->
                        where('id', $id)->orderBy('Md', 'desc')->limit(1)->get();
                        foreach ($Alidc as $Ali) {  $idrec = $Ali->idrec;}
                    }
                    if($purp=="red"){
                        $idrec = $request['idrec'];
                        $Md_s = $request['md'];

                        $affected = DB::table('Memory')
                            ->where('idrec', $idrec)
                            ->update(['Aboutec' => $Aboutec, 'Md' => $Md]);
                        $affected2 = DB::table('News')
                            ->where('avt', $Numm)
                            ->where('Nd', $Md_s)
                            ->update(['forum' => $Aboutec, 'Nd' => $Md]);
                    }

                    if($affected) {


                        $admpass="off";
                        $Allad = DB::table('City_Admin2')->select('id')->
                        where('Num', $Numm)->where('Page', 'Memory')->where('id', $id)->
                        limit(1)->get();
                        $Alladn = $Allad->count();
                        if($Alladn>0){$admpass="ok";}

                        $res = view('inc.memory', ['id' => $id, 'afisha' => 0, 'themeg' => $theme, 'idrec' => $idrec, 'M1' => $Aboutec, 'M2' => $Nameg, 'M3' => $Who, 'r_gol' => 0, 'r_kol' => 0,
                            'M6' => $Md, 'Ipmp' => $ip, 'avt' => $Numm, 'admpass' => $admpass, 'rh' => '', 'purp' => 'def']);

                        $edit = __('messages.edit'); $edit1 = __('messages.edit1'); $edit2 = __('messages.edit2');
                        $res .="<table><tr><td>
                                    <div id='red1'><a onclick=\"document.getElementById('red1').style.display = 'none'; document.getElementById('red2').style.display = 'block'; \">$edit <b>$edit1</b></a></div>
                                    <div id='red2' style=\"display: none;\">
                                        <textarea ID=\"memt_red\" rows=2 cols=40  onFocus=\"clearsq('memt_red','mem_red_add');\">$Aboutec</textarea>
                                        <input type=\"hidden\" id=\"idrec\" value=\"$idrec\">
                                        <input type=\"hidden\" id=\"md\" value=\"$Md\">
                                        <div id=\"mem_red_add\" style=\"display: none;\">
                                           <table><tr><td class=\"fcomblue\" width=200>
                                                <ul class=\"intop\"><li><a href = ### onclick=mem_red('$id')> $edit2 </a></li></ul>
                                            </td></tr></table>
                                        </div>
                                    </div>
                                </td></tr></table><br />";
                        return $res;
                    }


                }
            }
        }

    }





    public function mem_addp(Request $request)
    {
        if(Auth::user()) {
            $id = $request['id'];
            $purp = $request['purp'];
            $id = $id + 1;
            $id = $id - 1;
            if (is_int($id) != "true") {
                die("");
            }
            $Aboutec = $request['memt'];
            $ctrl_hss= mb_strtolower($Aboutec);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            if(!$Aboutec){
                $mem_add0 = __('messages.mem_add0');
                $mem_add0 = "<table><tr><td>$mem_add0</td></tr></table>";
                return $mem_add0;
            }
            else if(substr_count($Aboutec,"youtu")>1){
                $one_youtube = __('messages.one_youtube');
                $one_youtube = "<table><tr><td>$one_youtube</td></tr></table>";
                return $one_youtube;
            }
            else{
                $Numm = Auth::user()->id;
                $sq=0; $doforum=0;
                $Allq = DB::table('Private')->select('ban','Forum')->
                where('Num', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {$ComForBan=$Alq->ban;  $doforum=$Alq->Forum; $sq++; }
                if($sq==0){ $ComForBan = "";}

                if(mb_strstr((string)$ComForBan, (string)$Numm)=="") {

                    $Privatpass="stop";
                    if(!$doforum || $doforum==0 || $doforum==1 || $doforum==2){$Privatpass="go";}
                    else{

                        $Alls = DB::table('Friends')->select('Num1', 'Num2')->
                        where(function($query1) use ($id) {
                            $query1->where('Num1', $id)
                                ->where('Argue', '=', 2);
                        })->
                        orWhere(function($query2) use ($id) {
                            $query2->where('Num2', $id)
                                ->where('Argue', '=', 2);
                        })->
                        get();
                        $fr_avt="";  $Numfr = "";
                        foreach ($Alls as $All) { $Num1=$All->Num1; $Num2=$All->Num2;
                            if($Num1==$id){$Numfr=$Num2;} else{$Numfr=$Num1; }
                            $fr_avt.= " $Numfr"; }
                        $my_id = Auth::user()->id; $my_id2 = "$my_id";
                        $isfriend = mb_strstr((string)$fr_avt, (string)$my_id2);

                        if($doforum==3&&($id==$Numm||$isfriend!="")){$Privatpass="go";}

                        else{
                            if($doforum==4&&$id==$Numm){$Privatpass="go";}
                        }
                    }

                    if($Privatpass == "go") {

                        $theme = $request['theme_in'];
						    $ctrl_hss= mb_strtolower($theme);
							if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
										$ctrl_hss2=$ctrl_hss.=">";
										if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
                        $theme = str_ireplace("\"", "'", $theme);
                        $Aboutec = str_ireplace("\n", "<br />", $Aboutec);
                        $Aboutec = str_ireplace("http://localhost:8000/sml", "<img src=/sml", $Aboutec);
                        $Aboutec = str_ireplace("https://1ua.com.ua/sml", "<img src=/sml", $Aboutec);
                        $Aboutec = str_ireplace("https://25ua.com/sml", "<img src=/sml", $Aboutec);

                        $ip = getenv('REMOTE_ADDR');
                        $Md = date('Y-m-d-H-i-s');
                        $Imm = Auth::user()->Im;
                        $Prizm = Auth::user()->Priz;
                        $sexm = Auth::user()->sex;
                        $domenm = Auth::user()->domen;
                        if ($Numm == $id) {
                            $Im = $Imm;
                            $Priz = $Prizm;
                            $domen = $domenm;
                        } else {
                            $Allc = DB::table('users')->select('email', 'Im', 'Priz', 'domen', 'forum', 'aktiv')->
                            where('id', $id)->limit(1)->get();
                            foreach ($Allc as $All) {
                                $email = $All->email;
                                $Im = $All->Im;
                                $Priz = $All->Priz;
                                $domen = $All->domen;
                                $forum = $All->forum;
                                $aktiv = $All->aktiv;
                            }
                        }
                        if ($purp == "do") {

                            $affected = DB::table('Memoryp')->insert([
                                'Num' => $id, 'Aboutep' => $Aboutec, 'theme' => $theme, 'avt' => $Numm, 'Md' => $Md, 'ip' => $ip
                            ]);

                            $show_news = Auth::user()->show_news;
                            if (!$show_news) {
                                $nforum = 1;
                            } else {
                                $nforum = substr($show_news, 1, 1);
                            }

                            if ($nforum != 0) {
                                if ($theme) {
                                    $th_whe = "Форум";
                                    $th_wher = "Форум";
                                    $th_whee = "Forum";
                                    $Allw = DB::table('Memoryp')->select('news', 'avt')
                                        ->where('Num', $id)
                                        ->where('theme', $theme)
                                        ->get();
                                } else {
                                    $th_whe = "Стіна";
                                    $th_wher = "Стена";
                                    $th_whee = "Wall";
                                    $Allw = DB::table('Memoryp')->select('news', 'avt')->
                                    where('Num', $id)->get();
                                }

                                $allusersn = " $Numm";
                                foreach ($Allw as $Alw) {
                                    $news = $Alw->news;
                                    $whom = $Alw->avt;
                                    if (mb_strstr((string)$allusersn, (string)$whom) == "" && $news != 1) {
                                        $allusersn .= " $whom ";
                                    }
                                }


                                $ualine = "<a>$th_whe<br /> $Im<br />$Priz<br />$theme</a>";
                                $ruline = "<a>$th_wher<br />$Im<br />$Priz<br />$theme</a>";
                                $enline = "<a>$th_whee<br /> $Im<br />$Priz<br />$theme</a>";
                                $themen = "p#&~$domen#&~$theme";
                                $Num_am = Auth::user()->avatar;
                                if ((!$Num_am) || $Num_am < 10) {
                                    $Num_am = 7;
                                }

                                $sex = "$sexm$Num_am";
                                if (!$sex) {
                                    $sex = 0;
                                }

                                DB::table('News')->insert([
                                    'act' => 'nforum', 'Im' => $Imm, 'Priz' => $Prizm, 'sex' => $sex, 'theme' => $themen,
                                    'ualine' => $ualine, 'ruline' => $ruline, 'enline' => $enline,
                                    'avt' => $Numm, 'whom' => $allusersn, 'forum' => $Aboutec, 'avt_fr' => $Numm, 'Nd' => $Md
                                ]);

                            } // if ($nforum != 0) {

                            if ($affected) {

                                $mailput = "forumlist$id";
                                $q_s1[0] = ['forum', 1];
                                $q_s2[0] = ['forum', 1];
                                $q_s3[0] = ['forum', 1];

                                $filename = "storage/sixhours.txt";
                                $whattoread = @fopen($filename, "r");
                                $truestat_file_contents = fread($whattoread, filesize($filename));

                                fclose($whattoread);
                                $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                                if ($lastmail == "") {
                                    $q_s2[0] = ['forum', 2];
                                    $newfile = @fopen($filename, "a");
                                    @fwrite($newfile, $mailput);
                                    fclose($newfile);
                                }

                                $filename = "storage/oneday.txt";
                                $whattoread = @fopen($filename, "r");
                                $truestat_file_contents = fread($whattoread, filesize($filename));
                                fclose($whattoread);

                                $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                                if ($lastmail == "") {
                                    $q_s3[0] = ['forum', 3];
                                    $newfile = @fopen($filename, "a");
                                    @fwrite($newfile, $mailput);
                                    fclose($newfile);
                                }

                                if ($Numm == $id) {

                                    $Allm = DB::table('Mailpost')
                                        ->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3) {
                                            $query->whereNull('forum')
                                                ->orWhere($q_s1)
                                                ->orWhere($q_s2)
                                                ->orWhere($q_s3);
                                        })
                                        ->where('Nump', $id)
                                        ->select('Pmail')
                                        ->get();

                                    if ($sexm == 1) {
                                        $sexm_e = "додав";
                                    } else if ($sexm == 2) {
                                        $sexm_e = "додала";
                                    } else {
                                        $sexm_e = "додав (ла)";
                                    }

                                    foreach ($Allm as $Alm) {

                                        $Pmail = trim($Alm->Pmail);
                                        $subj = "$Im $Priz $sexm_e запис на своєму форумі";
                                        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                            $details['email'] = $Pmail;
                                            $details['subject'] = $subj;
                                            $details['blade'] = 'emails.publp';
                                            $details['det'] = array('Im' => $Im, 'Priz' => $Priz, 'domen' => $domen, 'id' => $id, 'Pmail' => $Pmail, 'sexm_e' => $sexm_e);
                                            $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                                            dispatch(new App\Jobs\SendEmailJob($details));
                                        }
                                    } // foreach ($Allm as $Alm) {
                                } // if ($Numm == $id) {
                                else {
                                    if ($aktiv == 1) {


                                        $filename0 = "storage/last_visit/$id.txt";
                                        if (file_exists($filename0) && filesize($filename0) > 0) {
                                            $whattoread0 = @fopen($filename0, "r");
                                            $memory_contents0 = fread($whattoread0, filesize($filename0));
                                            fclose($whattoread0);
                                            $notices = explode("#!:*&", $memory_contents0);
                                            $lan_user = $notices[4];
                                            $time_file0 = filemtime($filename0);
                                        } else {
                                            $lan_user = "ua";
                                            $time_file0 = 0;
                                        }


                                        $time_sec = time();
                                        $t = $time_sec - $time_file0;


                                        if ($t <= 50000) {

                                            if ($lan_user == "ua") {
                                                $qu_e = "Новий Запис";
                                                $qu_in = "i";
                                            }
                                            if ($lan_user == "ru") {
                                                $qu_e = "Новая запись";
                                                $qu_in = "ri";
                                            }
                                            if ($lan_user == "en") {
                                                $qu_e = "New record";
                                                $qu_in = "ei";
                                            }

                                            if (mb_strlen($Aboutec) > 350) {
                                                $Aboutec_me = mb_substr($Aboutec, 0, 350);
                                                $Aboutec_me .= "...";
                                            } else {
                                                $Aboutec_me = $Aboutec;
                                            }
                                            $r_else = "#!:*&<table><tr><td valign=top width=150><P style=\"color:white;\"><b>$qu_e</b><br /> <a href=\"/$qu_in$id\">$Aboutec_me</a></p><br /></td></tr></table>";

                                            $filename = "storage/notice/$id.txt";
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
                                        }


                                        $mailgo = "off";
                                        if (!$forum || $forum == 0) {
                                            $mailgo = "on";
                                        } else if ($forum == 1) {
                                            $mailput = "forum$id";

                                            $filename = "storage/sixhours.txt";
                                            $whattoread = @fopen($filename, "r") or die("Неможливо відкрити файл.");
                                            $truestat_file_contents = fread($whattoread, filesize($filename));
                                            fclose($whattoread);
                                            $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                                            if ($lastmail == "") {
                                                $mailgo = "on";
                                                $newfile = @fopen($filename, "a") or die("Неможливо відкрити файл.");
                                                @fwrite($newfile, $mailput) or die("Неможливо записати в файл.");
                                                fclose($newfile);
                                            }
                                        } else if ($forum == 2) {
                                            $mailput = "forum$id";

                                            $filename = "storage/oneday.txt";
                                            $whattoread = @fopen($filename, "r") or die("Неможливо відкрити файл.");
                                            $truestat_file_contents = fread($whattoread, filesize($filename));
                                            fclose($whattoread);
                                            $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                                            if ($lastmail == "") {
                                                $mailgo = "on";
                                                $newfile = @fopen($filename, "a") or die("Неможливо відкрити файл.");
                                                @fwrite($newfile, $mailput) or die("Неможливо записати в файл.");
                                                fclose($newfile);
                                            }
                                        }


                                        if ($mailgo == "on") {
                                            if ($lan_user == "ua") {
                                                $blade = "emails.publpme";
                                                if ($sexm == 1) {
                                                    $sexm_e = "додав";
                                                } else if ($sexm == 2) {
                                                    $sexm_e = "додала";
                                                } else {
                                                    $sexm_e = "додав (ла)";
                                                }
                                                $subj = "$Imm $Prizm $sexm_e запис на Вашому форумі";
                                            }
                                            if ($lan_user == "ru") {
                                                $blade = "emails.rpublpme";
                                                if ($sexm == 1) {
                                                    $sexm_e = "добавил";
                                                } else if ($sexm == 2) {
                                                    $sexm_e = "добавила";
                                                } else {
                                                    $sexm_e = "добавил (ла)";
                                                }
                                                $subj = "$Imm $Prizm $sexm_e запись на Вашем форуме";
                                            }
                                            if ($lan_user == "en") {
                                                $blade = "emails.epublpme";
                                                $subj = "$Imm $Prizm added a record on Your forum";
                                            }
                                            $Pmail = trim($email);
                                            if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                                $details['email'] = $Pmail;
                                                $details['subject'] = $subj;
                                                $details['blade'] = $blade;
                                                $details['det'] = array('Im' => $Im, 'subj' => $subj, 'domen' => $domen, 'id' => $id, 'Pmail' => $Pmail);
                                                $details['unsub'] = " ";
                                                dispatch(new App\Jobs\SendEmailJob($details));
                                            }
                                        } else {
                                            $mailgo = "of";
                                        } // if($mailgo=="on") {
                                    } // if ($aktiv==1){
                                } // if ($Numm != $id) {
                            } // if($affected) {


                            $Alidc = DB::table('Memoryp')->select('idrec')->
                            where('Num', $id)->orderBy('Md', 'desc')->limit(1)->get();
                            foreach ($Alidc as $Ali) {
                                $idrec = $Ali->idrec;
                            }

                        } // if($purp=="do"){

                        if ($purp == "red") {
                            $idrec = $request['idrec'];
                            $Md_s = $request['md'];

                            $affected = DB::table('Memoryp')
                                ->where('idrec', $idrec)
                                ->update(['Aboutep' => $Aboutec, 'Md' => $Md]);
                            $affected2 = DB::table('News')
                                ->where('avt', $Numm)
                                ->where('Nd', $Md_s)
                                ->update(['forum' => $Aboutec, 'Nd' => $Md]);
                        }

                        if ($affected) {

                            $res = view('inc.memoryp', ['id' => $id, 'afisha' => 0, 'themeg' => $theme, 'idrec' => $idrec, 'M1' => $Aboutec, 'r_gol' => 0, 'r_kol' => 0,
                                'M6' => $Md, 'Ipmp' => $ip, 'avt' => $Numm, 'rh' => '', 'purp' => 'def']);

                            $edit = __('messages.edit');
                            $edit1 = __('messages.edit1');
                            $edit2 = __('messages.edit2');
                            $res .= "<table><tr><td>
                                            <div id='red1'><a onclick=\"document.getElementById('red1').style.display = 'none'; document.getElementById('red2').style.display = 'block'; \">$edit <b>$edit1</b></a></div>
                                            <div id='red2' style=\"display: none;\">
                                                <textarea ID=\"memt_red\" rows=2 cols=40  onFocus=\"clearsp('memt_red','mem_red_add');\">$Aboutec</textarea>
                                                <input type=\"hidden\" id=\"idrec\" value=\"$idrec\">
                                                <input type=\"hidden\" id=\"md\" value=\"$Md\">
                                                <div id=\"mem_red_add\" style=\"display: none;\">
                                                   <table><tr><td class=\"fcomblue\" width=200>
                                                        <ul class=\"intop\"><li><a href = ### onclick=mem_redp('$id')> $edit2 </a></li></ul>
                                                    </td></tr></table>
                                                </div>
                                            </div>
                                        </td></tr></table><br />";
                            return $res;

                        }
                    }
                    else{
                        $ask_err = __('messages.for_block');
                        echo"<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
                    }

                }
            }
        }
    }



    public function radar(Request $request)
    {
        $obl = $request['obl'];
        $radar2 = __('messages.radar2');
        if($obl==25 || $obl==18 || $obl==2){
            if($obl==25){$rfile = "storage/apps/radar_chernigiv.png";}
            if($obl==18){$rfile = "storage/apps/radar_sumy.png";}
            if($obl==2){$rfile = "storage/apps/radar_volyn.png";}

            $kfilesize = filesize($rfile);
                if($kfilesize>500){
                    $_mkt = microtime(true);
                    $timed = round($_mkt);
                    echo"
            <table align=center><tr><td height=4></td></tr></table>
            <table><tr><td align=center width=535 class=fcom align=center>
            <table><tr><td width=500 align=center>
            <a href=\"/$rfile?$timed\"><img width = 500 border=0 SRC=\"/$rfile?$timed\"></a>
            <br />$radar2 <br /><br />
            </td></tr></table>
            </td></tr></table>
            ";



            }
        }
    }








    function rate_addm(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1; $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {die("");}
        $rate = $request['rate'];
        $rate=$rate+1; $rate=$rate-1;
        if(is_int($rate)!="true"){die("");}
        $lan = __('messages.lan');

        if (Auth::user()) {

            $Allb = DB::table('Memory')->select('id','r_gol','r_kol','avt','Md','Aboutec','Aboutece','theme','rh')->
            where('idrec', $Namef)->limit(1)->get();

            foreach ($Allb as $All) {
                $id = $All->id; $r_gol = $All->r_gol; $r_kol = $All->r_kol; $avt = $All->avt; $M6 = $All->Md;
                $Aboutec = $All->Aboutec; $Aboutece = $All->Aboutece;
                $rh = $All->rh; $theme = $All->theme; $whom = $avt;
            }

            $secm = substr($M6, 14, 2); $hourm = substr($M6, 11, 2); $timep=", $hourm:$secm";
            $fM6 = substr($M6, 0, 10);
            $Md_tod = date('Y-m-d');
            $Md_yes = date('Y-m-d', strtotime('-1 days'));
            $Md_yes_yes = date('Y-m-d', strtotime('-2 days'));

            if($lan == "en"){$pr="e";}
            else if($lan == "ru"){$pr="r";}
            else{$pr="";}

            $Numm = Auth::user()->id;

            $sq=0;
            $Allq = DB::table('Private')->select('ban')->
            where('Num', $whom)->limit(1)->get();
            foreach ($Allq as $Alq) {$ComForBan=$Alq->ban; $sq++; }
            if($sq==0){ $ComForBan = "";}

            $sq=0;
            $Allq = DB::table('Privatec')->select('ComForBan')->
            where('id', $id)->limit(1)->get();
            foreach ($Allq as $Alq) {$ComForBan2=$Alq->ComForBan; $sq++; }
            if($sq==0){ $ComForBan2 = "";}


            if(mb_strstr((string)$ComForBan, (string)$Numm)=="" && mb_strstr((string)$ComForBan2, (string)$Numm)=="" ) {

                if(!$Aboutece){$Aboutece=$Aboutec;}
                $Aboutecr=$Aboutec;

                if(mb_strstr((string)$Aboutec,"%^&@#")!=""){

                    $start = "%^&@#";
                    $positionqw = strpos($Aboutec, $start); $qw = substr($Aboutec, $positionqw+5);

                    $finish = "&@#%^";
                    $positionqw = strpos($qw, $finish); $qw = substr($qw, 0, $positionqw);

                    $start = "&@#%^";
                    $positionask = strpos($Aboutec, $start); $ask = substr($Aboutec, $positionask+5);

                    $qw = str_replace("<b>", "", $qw); $qw = str_replace("</b>", "", $qw);
                    $ask = str_replace("<b>", "", $ask); $ask = str_replace("</b>", "", $ask);

                    if(strlen($qw)>100){$qw = substr($qw, 0, 100); $qw.="...";}
                    if(strlen($ask)>100){$ask = substr($ask, 0, 100); $ask.="...";}

                    $Aboutec = "<a href=/rec$Namef><b>Запитання</b> $qw <b>Відповідь</b> $ask</a>";
                    $Aboutecr = "<a href=/rrec$Namef><b>Вопрос</b> $qw <b>Ответ</b> $ask</a>";
                    $Aboutece = "<a href=/erec$Namef><b>Question</b> $qw <b>Answer</b> $ask</a>";
                }
                else{
                    if(mb_strstr((string)$Aboutec,"<")!=""){
                        if($fM6==$Md_tod){$M6_e="сьогодні"; $M6_er="сегодня"; $M6_ee="today";}
                        else if($fM6==$Md_yes){$M6_e="вчора"; $M6_er="вчера"; $M6_ee="yesterday";}
                        else if($fM6==$Md_yes_yes){$M6_e="позавчора"; $M6_er="позавчера"; $M6_ee="day before yesterday";}
                        else {
                            $daym = substr($M6, 8, 2); $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
                            if($monm == "1") {$monm = "січня"; $monmr = "января"; $monme = "January"; } if($monm == "2") {$monm = "лютого";   $monmr = "февраля";$monme = "February";} if($monm == "3") {$monm = "березня";$monmr = "марта";$monme = "March";}
                            if($monm == "4") {$monm = "квітня";$monmr = "апреля";$monme = "April";}     if($monm == "5") {$monm = "травня";   $monmr = "мая";    $monme = "May";     } if($monm == "6") {$monm = "червня"; $monmr = "июня"; $monme = "June"; }
                            if($monm == "7") {$monm = "липня"; $monmr = "июля"; $monme = "July"; }      if($monm == "8") {$monm = "серпня";   $monmr = "августа";$monme = "August";  } if($monm == "9") {$monm = "вересня";$monmr = "сентября";$monme = "September";}
                            if($monm == "10"){$monm = "жовтня";$monmr = "октября";$monme = "October";}  if($monm == "11"){$monm = "листопада";$monmr = "ноября"; $monme = "November";} if($monm == "12"){$monm = "грудня"; $monmr = "декабря"; $monme = "December"; }
                            if(substr($daym, 0, 1)==0){$daym = substr($daym, 1, 1);}

                            $M6_e="$daym $monm $yem"; $M6_er="$daym $monmr $yem"; $M6_ee="$monme $daym, $yem"; $timep="";}

                        $Aboutec = "<a href=/rec$Namef>Запис від $M6_e$timep</a>";
                        $Aboutecr = "<a href=/rrec$Namef>Запись от $M6_er$timep</a>";
                        $Aboutece = "<a href=/erec$Namef>Record of $M6_ee$timep</a>";
                    }
                    else{
                        $Aboutec = substr($Aboutec, 0, 699); $Aboutec.="..."; $Aboutec = "<a href=/rec$Namef>$Aboutec</a>";
                        $Aboutecr = substr($Aboutecr, 0, 699); $Aboutecr.="..."; $Aboutecr = "<a href=/rrec$Namef>$Aboutecr</a>";
                        $Aboutece = substr($Aboutece, 0, 699); $Aboutece.="..."; $Aboutece = "<a href=/erec$Namef>$Aboutece</a>";
                    }
                }



                if($Numm==$avt){
                    $ch_e = __('messages.mark_own2');
                    echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
                }
                else{
                    if(mb_strstr((string)$rh, (string)$Numm)!="") {
                        $ch_e = __('messages.mark_once2');
                        echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
                    }
                    else{

                        $rhn=$rh.=":*$Numm*$rate";
                        $Newr_gol = $r_gol + $rate; $Newr_kol = $r_kol+1; $rr=round($Newr_gol/$Newr_kol);
                        $affected = DB::table('Memory')
                            ->where('idrec', $Namef)
                            ->update(['r_gol' => $Newr_gol, 'r_kol' => $Newr_kol, 'rh' => $rhn]);

                        if($affected){

                            $sexm = Auth::user()->sex;
                            $Imm = Auth::user()->Im;
                            $Prizm = Auth::user()->Priz;
                            $Num_am = Auth::user()->avatar;
                            if ((!$Num_am) || $Num_am < 10) {
                                $Num_am = 7;
                            }
                            if(!$sexm){$sexm=0;}


                            $show_news = Auth::user()->show_news;
                            if (!$show_news) {
                                $nratef = 1;
                            } else {
                                $nratef=substr($show_news, 4, 1);
                            }
                            if($nratef==1) {

                                $sq=0;
                                $Alld = DB::table('Allcities')->select('domen')->
                                where('id', $id)->limit(1)->get();
                                foreach ($Alld as $Alq) {$domen=$Alq->domen; $sq++; }
                                if($sq==0){ $domen = "";}

                                $theme="$rate#&~c#&~$id#&~$theme";
                                $Nd = date('Y-m-d-H-i');

                                DB::table('News')->insert(['act' => 'nratem', 'Im' => $Imm, 'Priz' => $Prizm,
                                    'sex' => $sexm, 'ualine' => $Aboutec, 'ruline' => $Aboutecr, 'enline' => $Aboutece,
                                    'theme' => $theme, 'avt' => $Numm, 'whom' => $whom, 'Nd' => $Nd]);

                            }

                            if($avt>0){

                                $filename0 = "storage/last_visit/$avt.txt";
                                if (file_exists($filename0) && filesize($filename0) > 0) {
                                    $whattoread0 = @fopen($filename0, "r");
                                    $memory_contents0 = fread($whattoread0, filesize($filename0));
                                    fclose($whattoread0);
                                    $notices = explode("#!:*&", $memory_contents0);
                                    $lan_user = $notices[4];
                                    $time_file0 = filemtime($filename0);
                                } else{$lan_user = "ua"; $time_file0 = 0;}

                                if ($lan_user == "ua") {
                                    $qu_in = "";
                                    $abn = "<a href=rec$Namef>$Aboutec</a>";
                                }
                                if ($lan_user == "ru") {
                                    $qu_in = "r";
                                    $abn = "<a href=rrec$Namef>$Aboutecr</a>";
                                }
                                if ($lan_user == "en") {
                                    $qu_in = "e";
                                    $abn = "<a href=erec$Namef>$Aboutece</a>";
                                }

                                $time_sec = time();
                                $t = $time_sec - $time_file0;
                                if ($t <= 50000) {

                                    if($rate>=1){$star1="on";}else{$star1="off";}
                                    if($rate>=2){$star2="on";}else{$star2="off";}
                                    if($rate>=3){$star3="on";}else{$star3="off";}
                                    if($rate>=4){$star4="on";}else{$star4="off";}
                                    if($rate>=5){$star5="on";}else{$star5="off";}

                                    $prlink3 = $qu_in; $prlink3.="i"; $prlink3.=$Numm;

                                    $r_else="#!:*&<table><tr><td width=100 valign=top align=right>
                                        <table>
                                        <tr><td><p style=\" color:white; margin: 0px 0px 8px 0px;\">$abn</p></td></tr>
                                        <tr><td align=right>

                                        <img src=\"/$star1.png\" border=0><img src=\"/$star2.png\" border=0><img src=\"/$star3.png\" border=0><img src=\"/$star4.png\" border=0><img src=\"/$star5.png\" border=0>

                                        </td></tr>
                                        </table>
                                        </td>
                                        <td valign=top>
                                        <a href=/$prlink3><div style=\"height: 50px; overflow: hidden\"><img border=0 SRC=/storage/avatar/s$Num_am.jpg align=left></div></a>
                                        <a href=/$prlink3><p style=\" color:white; margin: 8px 0px 8px 0px;\">$Imm $Prizm</p></a>
                                        </td></tr></table>";

                                    $filename = "storage/notice/$avt.txt";
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
                                }




                                $Allq = DB::table('users')->select('frating', 'email')->
                                where('id', $avt)->limit(1)->get();
                                foreach ($Allq as $Alq) {
                                    $frating = $Alq->frating;
                                    $emailu = $Alq->email;
                                }

                                $mailgo = "off";
                                $mailput = "mrating$avt";
                                if (!$frating || $frating == 0) {
                                    $frating = 1;
                                }
                                if ($frating == 1) {

                                    $filename = "storage/sixhours.txt";
                                    $whattoread = @fopen($filename, "r");
                                    $truestat_file_contents = fread($whattoread, filesize($filename));
                                    fclose($whattoread);
                                    $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                                    if ($lastmail == "") {
                                        $mailgo = "on";
                                        $newfile = @fopen($filename, "a");
                                        @fwrite($newfile, $mailput);
                                        fclose($newfile);
                                    }
                                }
                                else if ($frating == 2) {

                                    $filename = "storage/oneday.txt";
                                    $whattoread = @fopen($filename, "r");
                                    $truestat_file_contents = fread($whattoread, filesize($filename));
                                    fclose($whattoread);

                                    $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                                    if ($lastmail == "") {
                                        $mailgo = "on";
                                        $newfile = @fopen($filename, "a");
                                        @fwrite($newfile, $mailput);
                                        fclose($newfile);
                                    }
                                }



                                if ($mailgo == "on") {
                                    if ($lan_user == "ua") {
                                        if($sexm==1){$sexm_e1="поставив"; $sexm_e2="змінив";}
                                        else if($sexm==2){$sexm_e1="поставила"; $sexm_e2="змінила";}
                                        else{$sexm_e1="поставив (ла)"; $sexm_e2="змінив (ла)";}
                                        $subj = "$Imm $Prizm $sexm_e1 оцінку Вашому запису...";
                                        $blade = "emails.memory_mark";
                                    }
                                    if ($lan_user == "ru") {
                                        if($sexm==1){$sexm_e1="поставил"; $sexm_e2="изменил";}
                                        else if($sexm==2){$sexm_e1="поставила"; $sexm_e2="изменила";}
                                        else{$sexm_e1="поставил (ла)"; $sexm_e2="изменил (ла)";}
                                        $subj = "$Imm $Prizm $sexm_e1 оценку Вашей записи...";
                                        $blade = "emails.rmemory_mark";
                                    }
                                    if ($lan_user == "en") {
                                        $subj = "$Imm $Prizm put an assessment of Your record...";
                                        $sexm_e1 = "";
                                        $sexm_e2 = "";
                                        $blade = "emails.ememory_mark";
                                    }
                                    if (filter_var($emailu, FILTER_VALIDATE_EMAIL)) {
                                        $abn = strip_tags($abn);
                                        $Nameg = "$Imm $Prizm";
                                        $details['email'] = trim($emailu);
                                        $details['subject'] = $subj;
                                        $details['blade'] = $blade;
                                        $details['det'] = array('abn' => $abn, 'rec' => $Namef, 'Nameg' => $Nameg, 'sexm_e2' => $sexm_e2);
                                        $details['unsub'] = "";
                                        dispatch(new App\Jobs\SendEmailJob($details));
                                    }
                                }
                            }



                            $r_gol=$Newr_gol; $r_kol=$Newr_kol;
                            $r_gol2=round($r_gol/$r_kol,2); $r_gol=round($r_gol/$r_kol);
                            if($r_gol>0.5){$star1="on";}else{$star1="off";}
                            if($r_gol>1.5){$star2="on";}else{$star2="off";}
                            if($r_gol>2.5){$star3="on";}else{$star3="off";}
                            if($r_gol>3.5){$star4="on";}else{$star4="off";}
                            if($r_gol>4.5){$star5="on"; $star55="onm";}else{$star5="off"; $star55="offm";}

                            echo"<table><tr><td>
                                <div class=hidblok>
                                <img src=\"/$star1.png\" border=0><img src=\"/$star2.png\" border=0><img src=\"/$star3.png\" border=0><img src=\"/$star4.png\" border=0><img src=\"/$star5.png\" border=0>
                                </div>
                                <div class=hidblokwide>
                                <img src=\"/$star55.png\" border=0>
                                </div>
                            </td><td>
                                <a onclick=rate_hm('r$Namef',$Namef)> <b>$r_gol2|$r_kol</b></a><br />
                            </td></tr></table>";

                        }
                    }
                }
            }
            else{
                $ch_e = __('messages.mark_ban2');
                echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
            }

        }
        else{
            $ch_e = __('messages.mark_need_reg');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }
    }








    function rate_addmp(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1; $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {die("");}
        $rate = $request['rate'];
        $rate=$rate+1; $rate=$rate-1;
        if(is_int($rate)!="true"){die("");}
        $lan = __('messages.lan');

        if (Auth::user()) {


            $Allb = DB::table('Memoryp')->select('Num','r_gol','r_kol','avt','Md','Aboutep','Aboutepr','Aboutepe','theme','rh')->
            where('idrec', $Namef)->limit(1)->get();

            foreach ($Allb as $All) {
                $id = $All->Num; $r_gol = $All->r_gol; $r_kol = $All->r_kol; $avt = $All->avt; $M6 = $All->Md;
                $Aboutep = $All->Aboutep; $Aboutepr = $All->Aboutepr; $Aboutepe = $All->Aboutepe;
                $rh = $All->rh; $theme = $All->theme; $whom = $avt;
            }
            if(!$Aboutepr){$Aboutepr=$Aboutep;}
            if(!$Aboutepe){$Aboutepe=$Aboutep;}
            $secm = substr($M6, 14, 2); $hourm = substr($M6, 11, 2); $timep=", $hourm:$secm";
            $fM6 = substr($M6, 0, 10);
            $Md_tod = date('Y-m-d');
            $Md_yes = date('Y-m-d', strtotime('-1 days'));
            $Md_yes_yes = date('Y-m-d', strtotime('-2 days'));

            if($lan == "en"){$pr="e";}
            else if($lan == "ru"){$pr="r";}
            else{$pr="";}

            $Numm = Auth::user()->id;

            $sq=0;
            $Allq = DB::table('Private')->select('ban')->
            where('Num', $whom)->limit(1)->get();
            foreach ($Allq as $Alq) {$ComForBan=$Alq->ban; $sq++; }
            if($sq==0){ $ComForBan = "";}


            if(mb_strstr((string)$ComForBan, (string)$Numm)=="") {


                if(mb_strstr((string)$Aboutep,"%^&@#")!=""){

                    $start = "%^&@#";
                    $positionqw = strpos($Aboutep, $start); $qw = substr($Aboutep, $positionqw+5);

                    $finish = "&@#%^";
                    $positionqw = strpos($qw, $finish); $qw = substr($qw, 0, $positionqw);

                    $start = "&@#%^";
                    $positionask = strpos($Aboutep, $start); $ask = substr($Aboutep, $positionask+5);

                    $qw = str_replace("<b>", "", $qw); $qw = str_replace("</b>", "", $qw);
                    $ask = str_replace("<b>", "", $ask); $ask = str_replace("</b>", "", $ask);

                    if(strlen($qw)>100){$qw = substr($qw, 0, 100); $qw.="...";}
                    if(strlen($ask)>100){$ask = substr($ask, 0, 100); $ask.="...";}

                    $Aboutep = "<a href=/recp$Namef><b>Запитання</b> $qw <b>Відповідь</b> $ask</a>";
                    $Aboutepr = "<a href=/rrecp$Namef><b>Вопрос</b> $qw <b>Ответ</b> $ask</a>";
                    $Aboutepe = "<a href=/erecp$Namef><b>Question</b> $qw <b>Answer</b> $ask</a>";
                }
                else{
                    if(mb_strstr((string)$Aboutep,"<")!=""){
                        if($fM6==$Md_tod){$M6_e="сьогодні"; $M6_er="сегодня"; $M6_ee="today";}
                        else if($fM6==$Md_yes){$M6_e="вчора"; $M6_er="вчера"; $M6_ee="yesterday";}
                        else if($fM6==$Md_yes_yes){$M6_e="позавчора"; $M6_er="позавчера"; $M6_ee="day before yesterday";}
                        else {
                            $daym = substr($M6, 8, 2); $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
                            if($monm == "1") {$monm = "січня"; $monmr = "января"; $monme = "January"; } if($monm == "2") {$monm = "лютого";   $monmr = "февраля";$monme = "February";} if($monm == "3") {$monm = "березня";$monmr = "марта";$monme = "March";}
                            if($monm == "4") {$monm = "квітня";$monmr = "апреля";$monme = "April";}     if($monm == "5") {$monm = "травня";   $monmr = "мая";    $monme = "May";     } if($monm == "6") {$monm = "червня"; $monmr = "июня"; $monme = "June"; }
                            if($monm == "7") {$monm = "липня"; $monmr = "июля"; $monme = "July"; }      if($monm == "8") {$monm = "серпня";   $monmr = "августа";$monme = "August";  } if($monm == "9") {$monm = "вересня";$monmr = "сентября";$monme = "September";}
                            if($monm == "10"){$monm = "жовтня";$monmr = "октября";$monme = "October";}  if($monm == "11"){$monm = "листопада";$monmr = "ноября"; $monme = "November";} if($monm == "12"){$monm = "грудня"; $monmr = "декабря"; $monme = "December"; }
                            if(substr($daym, 0, 1)==0){$daym = substr($daym, 1, 1);}

                            $M6_e="$daym $monm $yem"; $M6_er="$daym $monmr $yem"; $M6_ee="$monme $daym, $yem"; $timep="";}

                        $Aboutep = "<a href=/recp$Namef>Запис від $M6_e$timep</a>";
                        $Aboutepr = "<a href=/rrecp$Namef>Запись от $M6_er$timep</a>";
                        $Aboutepe = "<a href=/erecp$Namef>Record of $M6_ee$timep</a>";
                    }
                    else{
                        $Aboutep = substr($Aboutep, 0, 699); $Aboutep.="..."; $Aboutep = "<a href=/recp$Namef>$Aboutep</a>";
                        $Aboutepr = substr($Aboutepr, 0, 699); $Aboutepr.="..."; $Aboutepr = "<a href=/rrecp$Namef>$Aboutepr</a>";
                        $Aboutepe = substr($Aboutepe, 0, 699); $Aboutepe.="..."; $Aboutepe = "<a href=/erecp$Namef>$Aboutepe</a>";
                    }
                }



                if($Numm==$avt){
                    $ch_e = __('messages.mark_own2');
                    echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
                }
                else{
                    if(mb_strstr((string)$rh, (string)$Numm)!="") {
                        $ch_e = __('messages.mark_once2');
                        echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
                    }
                    else{

                        $rhn=$rh.=":*$Numm*$rate";
                        $Newr_gol = $r_gol + $rate; $Newr_kol = $r_kol+1; $rr=round($Newr_gol/$Newr_kol);
                        $affected = DB::table('Memoryp')
                            ->where('idrec', $Namef)
                            ->update(['r_gol' => $Newr_gol, 'r_kol' => $Newr_kol, 'rh' => $rhn]);

                        if($affected){

                            $sexm = Auth::user()->sex;
                            $Imm = Auth::user()->Im;
                            $Prizm = Auth::user()->Priz;
                            $Num_am = Auth::user()->avatar;
                            if ((!$Num_am) || $Num_am < 10) {
                                $Num_am = 7;
                            }
                            if(!$sexm){$sexm=0;}


                            $show_news = Auth::user()->show_news;
                            if (!$show_news) {
                                $nratef = 1;
                            } else {
                                $nratef=substr($show_news, 4, 1);
                            }
                            if($nratef==1) {

                                $sq=0;
                                $Alld = DB::table('users')->select('domen')->
                                where('id', $id)->limit(1)->get();
                                foreach ($Alld as $Alq) {$domen=$Alq->domen; $sq++; }
                                if($sq==0){ $domen = "";}

                                $theme="$rate#&~p#&~$id#&~$theme";
                                $Nd = date('Y-m-d-H-i');

                                DB::table('News')->insert(['act' => 'nratem', 'Im' => $Imm, 'Priz' => $Prizm,
                                    'sex' => $sexm, 'ualine' => $Aboutep, 'ruline' => $Aboutepr, 'enline' => $Aboutepe,
                                    'theme' => $theme, 'avt' => $Numm, 'whom' => $whom, 'Nd' => $Nd]);

                            }

                            if($avt>0){

                                $filename0 = "storage/last_visit/$avt.txt";
                                if (file_exists($filename0) && filesize($filename0) > 0) {
                                    $whattoread0 = @fopen($filename0, "r");
                                    $memory_contents0 = fread($whattoread0, filesize($filename0));
                                    fclose($whattoread0);
                                    $notices = explode("#!:*&", $memory_contents0);
                                    $lan_user = $notices[4];
                                    $time_file0 = filemtime($filename0);
                                } else{$lan_user = "ua"; $time_file0 = 0;}


                                if ($lan_user == "ua") {
                                    $qu_in = "";
                                    $abn = "<a href=recp$Namef>$Aboutep</a>";
                                }
                                if ($lan_user == "ru") {
                                    $qu_in = "r";
                                    $abn = "<a href=rrecp$Namef>$Aboutepr</a>";
                                }
                                if ($lan_user == "en") {
                                    $qu_in = "e";
                                    $abn = "<a href=erecp$Namef>$Aboutepe</a>";
                                }

                                $time_sec = time();
                                $t = $time_sec - $time_file0;
                                if ($t <= 50000) {

                                    if($rate>=1){$star1="on";}else{$star1="off";}
                                    if($rate>=2){$star2="on";}else{$star2="off";}
                                    if($rate>=3){$star3="on";}else{$star3="off";}
                                    if($rate>=4){$star4="on";}else{$star4="off";}
                                    if($rate>=5){$star5="on";}else{$star5="off";}

                                    $prlink3 = $qu_in; $prlink3.="i"; $prlink3.=$Numm;

                                    $r_else="#!:*&<table><tr><td width=100 valign=top align=right>
                                        <table>
                                        <tr><td><p style=\" color:white; margin: 0px 0px 8px 0px;\">$abn</p></td></tr>
                                        <tr><td align=right>

                                        <img src=\"/$star1.png\" border=0><img src=\"/$star2.png\" border=0><img src=\"/$star3.png\" border=0><img src=\"/$star4.png\" border=0><img src=\"/$star5.png\" border=0>

                                        </td></tr>
                                        </table>
                                        </td>
                                        <td valign=top>
                                        <a href=/$prlink3><div style=\"height: 50px; overflow: hidden\"><img border=0 SRC=/storage/avatar/s$Num_am.jpg align=left></div></a>
                                        <a href=/$prlink3><p style=\" color:white; margin: 8px 0px 8px 0px;\">$Imm $Prizm</p></a>
                                        </td></tr></table>";

                                    $filename = "storage/notice/$avt.txt";
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
                                }


                                $Allq = DB::table('users')->select('frating', 'email')->
                                where('id', $avt)->limit(1)->get();
                                foreach ($Allq as $Alq) {
                                    $frating = $Alq->frating;
                                    $emailu = $Alq->email;
                                }

                                $mailgo = "off";
                                $mailput = "mrating$avt";
                                if (!$frating || $frating == 0) {
                                    $frating = 1;
                                }
                                if ($frating == 1) {

                                    $filename = "storage/sixhours.txt";
                                    $whattoread = @fopen($filename, "r");
                                    $truestat_file_contents = fread($whattoread, filesize($filename));
                                    fclose($whattoread);
                                    $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                                    if ($lastmail == "") {
                                        $mailgo = "on";
                                        $newfile = @fopen($filename, "a");
                                        @fwrite($newfile, $mailput);
                                        fclose($newfile);
                                    }
                                }
                                else if ($frating == 2) {

                                    $filename = "storage/oneday.txt";
                                    $whattoread = @fopen($filename, "r");
                                    $truestat_file_contents = fread($whattoread, filesize($filename));
                                    fclose($whattoread);

                                    $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                                    if ($lastmail == "") {
                                        $mailgo = "on";
                                        $newfile = @fopen($filename, "a");
                                        @fwrite($newfile, $mailput);
                                        fclose($newfile);
                                    }
                                }



                                if ($mailgo == "on") {
                                    if ($lan_user == "ua") {
                                        if($sexm==1){$sexm_e1="поставив"; $sexm_e2="змінив";}
                                        else if($sexm==2){$sexm_e1="поставила"; $sexm_e2="змінила";}
                                        else{$sexm_e1="поставив (ла)"; $sexm_e2="змінив (ла)";}
                                        $subj = "$Imm $Prizm $sexm_e1 оцінку Вашому запису...";
                                        $blade = "emails.memoryp_mark";
                                    }
                                    if ($lan_user == "ru") {
                                        if($sexm==1){$sexm_e1="поставил"; $sexm_e2="изменил";}
                                        else if($sexm==2){$sexm_e1="поставила"; $sexm_e2="изменила";}
                                        else{$sexm_e1="поставил (ла)"; $sexm_e2="изменил (ла)";}
                                        $subj = "$Imm $Prizm $sexm_e1 оценку Вашей записи...";
                                        $blade = "emails.rmemoryp_mark";
                                    }
                                    if ($lan_user == "en") {
                                        $subj = "$Imm $Prizm put an assessment of Your record...";
                                        $sexm_e1 = "";
                                        $sexm_e2 = "";
                                        $blade = "emails.ememoryp_mark";
                                    }
                                    if (filter_var($emailu, FILTER_VALIDATE_EMAIL)) {
                                        $abn = strip_tags($abn);
                                        $Nameg = "$Imm $Prizm";
                                        $details['email'] = trim($emailu);
                                        $details['subject'] = $subj;
                                        $details['blade'] = $blade;
                                        $details['det'] = array('rec' => $Namef, 'abn' => $abn, 'Nameg' => $Nameg, 'sexm_e2' => $sexm_e2);
                                        $details['unsub'] = "";
                                        dispatch(new App\Jobs\SendEmailJob($details));
                                    }
                                }
                            }



                            $r_gol=$Newr_gol; $r_kol=$Newr_kol;
                            $r_gol2=round($r_gol/$r_kol,2); $r_gol=round($r_gol/$r_kol);
                            if($r_gol>0.5){$star1="on";}else{$star1="off";}
                            if($r_gol>1.5){$star2="on";}else{$star2="off";}
                            if($r_gol>2.5){$star3="on";}else{$star3="off";}
                            if($r_gol>3.5){$star4="on";}else{$star4="off";}
                            if($r_gol>4.5){$star5="on"; $star55="onm";}else{$star5="off"; $star55="offm";}

                            echo"<table><tr><td>
                                <div class=hidblok>
                                <img src=\"/$star1.png\" border=0><img src=\"/$star2.png\" border=0><img src=\"/$star3.png\" border=0><img src=\"/$star4.png\" border=0><img src=\"/$star5.png\" border=0>
                                </div>
                                <div class=hidblokwide>
                                <img src=\"/$star55.png\" border=0>
                                </div>
                            </td><td>
                                <a onclick=rate_hmp('r$Namef',$Namef)> <b>$r_gol2|$r_kol</b></a><br />
                            </td></tr></table>";

                        }
                    }
                }
            }
            else{
                $ch_e = __('messages.mark_ban2');
                echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
            }

        }
        else{
            $ch_e = __('messages.mark_need_reg');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }
    }





    function rate_hm(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1; $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {die("");}
        if(Auth::user()){$Numm = Auth::user()->id;} else{$Numm="999999999";}

        if (Auth::user()) {
            $Numm = Auth::user()->id;
        }
        else{$Numm = 999999;}

        $Allb = DB::table('Memory')->select('rh')->
        where('idrec', $Namef)->limit(1)->get();

        foreach ($Allb as $All) {
            $rh = $All->rh;
        }

        $n=substr_count($rh, ':');
        if($n>0){
            $v_page = explode(":", $rh);

            echo"<ul class='non-list mark-hist'>";

            for($a=1; $a<=$n; $a++){

                $page=$v_page[$a];
                $page = explode("*", $page);

                $avt=$page[1]; $rate=$page[2];
                if($rate>=1){$star1="on";}else{$star1="off";}
                if($rate>=2){$star2="on";}else{$star2="off";}
                if($rate>=3){$star3="on";}else{$star3="off";}
                if($rate>=4){$star4="on";}else{$star4="off";}
                if($rate>=5){$star5="on";}else{$star5="off";}

                $stars = "<img src=\"/$star1.png\"><img src=\"/$star2.png\"><img src=\"/$star3.png\"><img src=\"/$star4.png\"><img src=\"/$star5.png\">";
                if((int)$avt>0){
                    $aavt = avt($avt,$Numm);
                    $aavt = str_replace("</a>", "<br /> $stars</a>", $aavt);
                    echo "<li style='width: 150px; text-align: left; '>
                              $aavt
                          </li>";
                }
            }
            echo"</ul>";
        }

        else{
            $ch_e = __('messages.mark_history2');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }

    }





    function rate_hmp(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1; $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {die("");}
        if(Auth::user()){$Numm = Auth::user()->id;} else{$Numm="999999999";}

        if (Auth::user()) {
            $Numm = Auth::user()->id;
        }
        else{$Numm = 999999;}

        $Allb = DB::table('Memoryp')->select('rh')->
        where('idrec', $Namef)->limit(1)->get();

        foreach ($Allb as $All) {
            $rh = $All->rh;
        }

        $n=substr_count($rh, ':');
        if($n>0){
            $v_page = explode(":", $rh);

            echo"<ul class='non-list mark-hist'>";

            for($a=1; $a<=$n; $a++){

                $page=$v_page[$a];
                $page = explode("*", $page);

                $avt=$page[1]; $rate=$page[2];
                if($rate>=1){$star1="on";}else{$star1="off";}
                if($rate>=2){$star2="on";}else{$star2="off";}
                if($rate>=3){$star3="on";}else{$star3="off";}
                if($rate>=4){$star4="on";}else{$star4="off";}
                if($rate>=5){$star5="on";}else{$star5="off";}

                $stars = "<img src=\"/$star1.png\"><img src=\"/$star2.png\"><img src=\"/$star3.png\"><img src=\"/$star4.png\"><img src=\"/$star5.png\">";
                if((int)$avt>0){
                    $aavt = avt($avt,$Numm);
                    $aavt = str_replace("</a>", "<br /> $stars</a>", $aavt);
                    echo "<li style='width: 150px; text-align: left; '>
                              $aavt
                          </li>";
                    }
            }
            echo"</ul>";
        }

        else{
            $ch_e = __('messages.mark_history2');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }

    }










    function commm_add(Request $request)
    {
        $Namef = $request['M5'];
        $Aboutef = $request['Aboutef'];
        $purp = $request['purp'];
        $Aboutef = getDescriptionAttribute($Aboutef);
        $Aboutef = nl2br($Aboutef);
        $Namef = $Namef + 1; $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {die("");}
        $abuse_ban = __('messages.abuse_ban');
        $lan = __('messages.lan');

        if(Auth::user()) {
            $ctrl_hss = $Aboutef;
            $my_id = Auth::user()->id;

            $ctrl_hss = htmlspecialchars_decode($ctrl_hss, ENT_QUOTES);
            $ctrl_hss = strip_tags($ctrl_hss); // Видаляє HTML

            if (preg_match("/<[^<]+>/", $ctrl_hss) && $my_id != 29724907) { exit; }

            $ctrl_hss2 = $ctrl_hss . ">";
            if (preg_match("/<[^<]+>/", $ctrl_hss2) && $my_id != 29724907) { exit; }

            $Aboutef = preg_replace_callback(
                '/(https?:\/\/[^\s<]+[^.,:;"\')\]\s<])/u',
                function ($matches) {
                    $url = $matches[0];
                    $shortUrl = (strlen($url) > 35) ? substr($url, 0, 35) . "..." : $url;


                    $urlParts = explode('/', rtrim($shortUrl, '/'));
                    $lastPart = array_pop($urlParts); // Остання частина URL
                    $boldUrl = implode('/', $urlParts) . '/<b>' . $lastPart . '</b>'; // Додаємо жирний стиль

                    return '<a target="_blank" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($boldUrl, ENT_QUOTES, 'UTF-8') . '</a>';
                },
                $ctrl_hss
            );

            $Aboutef = htmlspecialchars_decode($Aboutef, ENT_QUOTES);
            if (!$Aboutef) {
                $ask_err = __('messages.comm_err');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }
            else if (mb_strlen($Aboutef) > 500) {
                $ask_err = __('messages.ask_err2');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }

            else if (mb_strstr((string)$Aboutef,"хуй")!=""||mb_strstr((string)$Aboutef,"пизд")!=""||mb_strstr((string)$Aboutef," конч")!=""||mb_strstr((string)$Aboutef,"вафл")!=""||mb_strstr((string)$Aboutef,"шлюх")!=""||mb_strstr((string)$Aboutef,"fuck")!=""||mb_strstr((string)$Aboutef," гом")!=""||mb_strstr((string)$Aboutef," бля")!=""||mb_strstr((string)$Aboutef," манд")!=""||mb_strstr((string)$Aboutef,"член")!=""||mb_strstr((string)$Aboutef," еба")!=""||mb_strstr((string)$Aboutef," єба")!=""||mb_strstr((string)$Aboutef,"суч")!=""||mb_strstr((string)$Aboutef,"сук")!=""||mb_strstr((string)$Aboutef,"дроч")!=""||mb_strstr((string)$Aboutef," писк")!=""||mb_strstr((string)$Aboutef," піськ")!=""||mb_strstr((string)$Aboutef,"урод")!=""||mb_strstr((string)$Aboutef,"ублюд")!=""||mb_strstr((string)$Aboutef,"соса")!=""||mb_strstr((string)$Aboutef,"соси")!=""||mb_strstr((string)$Aboutef,"сран")!=""||mb_strstr((string)$Aboutef,"срак")!=""||mb_strstr((string)$Aboutef,"срат")!=""||mb_strstr((string)$Aboutef,"хуев")!=""||mb_strstr((string)$Aboutef,"костр")!=""||mb_strstr((string)$Aboutef,"блев")!=""||mb_strstr((string)$Aboutef,"яйц")!=""||mb_strstr((string)$Aboutef," трах")!=""||mb_strstr((string)$Aboutef,"влагал")!=""||mb_strstr((string)$Aboutef," онан")!=""){

                $bad_words="<font color=red>";
                if (mb_strstr((string)$Aboutef,"хуй")!=""){$bad_words.=" хуй";}
                if (mb_strstr((string)$Aboutef,"пизд")!=""){$bad_words.=" пизд";}
                if (mb_strstr((string)$Aboutef,"сперм")!=""){$bad_words.=" сперм";}
                if (mb_strstr((string)$Aboutef,"шлюх")!=""){$bad_words.=" шлюх";}
                if (mb_strstr((string)$Aboutef,"гом")!=""){$bad_words.=" гом";}
                if (mb_strstr((string)$Aboutef,"бля")!=""){$bad_words.=" бля";}
                if (mb_strstr((string)$Aboutef,"еба")!=""){$bad_words.=" еба";}
                if (mb_strstr((string)$Aboutef,"єба")!=""){$bad_words.=" єба";}
                if (mb_strstr((string)$Aboutef,"сук")!=""){$bad_words.=" сукa";}
                if (mb_strstr((string)$Aboutef,"дроч")!=""){$bad_words.=" дроч";}
                if (mb_strstr((string)$Aboutef,"піськ")!=""){$bad_words.=" піськ";}
                if (mb_strstr((string)$Aboutef,"ублюд")!=""){$bad_words.=" ублюд";}
                if (mb_strstr((string)$Aboutef,"сран")!=""){$bad_words.=" сран";}
                if (mb_strstr((string)$Aboutef,"срак")!=""){$bad_words.=" срак";}
                if (mb_strstr((string)$Aboutef,"срат")!=""){$bad_words.=" срат";}
                if (mb_strstr((string)$Aboutef,"хуев")!=""){$bad_words.=" хуев";}
                if (mb_strstr((string)$Aboutef,"трах")!=""){$bad_words.=" трах";}
                if (mb_strstr((string)$Aboutef,"онан")!=""){$bad_words.=" онан";}
                if (mb_strstr((string)$Aboutef,"хуя")!=""){$bad_words.=" хуя";}
                $bad_words.="</font>";

                echo"s235*64@75<table><tr><td align=center><p style=\"margin: 8px 0px 8px 0px; \">$abuse_ban: $bad_words</p></td></tr></table>";
            }
            else {

                $Allb = DB::table('Memory')->select('id', 'City', 'obl', 'theme', 'Md', 'avt','Aboutec','Aboutece','rh')->
                where('idrec', $Namef)->limit(1)->get();

                foreach ($Allb as $All) {
                    $id = $All->id; $City = $All->City; $obl = $All->obl; $theme = $All->theme;
                    $avt = $All->avt; $fM6 = $All->Md; $M6= $fM6;
                    $Aboutec = $All->Aboutec; $Aboutece = $All->Aboutece;
                    $rh = $All->rh; $whom = $avt;
                }

                $allusersn = "";
                $nmark=substr_count($rh, ':');
                if($nmark>0){
                    $v_page = explode(":", $rh);
                    for($a=1; $a<=$nmark; $a++){
                        $pm=$v_page[$a]; $pm = explode("*", $pm); $avtm=$pm[1];
                        if (mb_strstr((string)$allusersn,(string)$avtm)==""){$allusersn.=" $avtm ";}
                    }
                }

                $admpass = "off";
                $my_id = Auth::user()->Num;
                $Allad = DB::table('City_Admin2')->select('Num')->
                where('Num', $my_id)->where('Page', 'Memory')->where('id', $id)->
                limit(1)->get();
                $Alladn = $Allad->count();
                if ($Alladn > 0) {
                    $admpass = "ok";
                    foreach ($Allad as $All) {
                        $Num_adm = $All->Num;
                        if (mb_strstr((string)$allusersn,(string)$Num_adm)==""){$allusersn.=" $Num_adm ";}
                    }
                }

                if($whom>0){
                    if (mb_strstr((string)$allusersn,(string)$whom)==""){$allusersn.=" $whom ";}
                }


                $Numm = Auth::user()->id;
                $sq=0;
                $Allq = DB::table('Private')->select('ban')->
                where('Num', $whom)->limit(1)->get();
                foreach ($Allq as $Alq) {$ban=$Alq->ban; $sq++; }
                if($sq==0){ $ban = "";}

                $sq=0;
                $Allq = DB::table('Privatec')->select('ComForBan')->
                where('id', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {$ComForBan=$Alq->ComForBan; $sq++; }
                if($sq==0){ $ComForBan = "";}

                if(mb_strstr((string)$ComForBan, (string)$Numm)=="" && mb_strstr((string)$ban, (string)$Numm)=="" ) {

					if(!$Aboutece){$Aboutece=$Aboutec;}
					$Aboutecr=$Aboutec;

					if(strstr((string)$Aboutec,"%^&@#")!=""){

						$start = "%^&@#";
						$positionqw = strpos($Aboutec, $start); $qw = substr($Aboutec, $positionqw+5);

						$finish = "&@#%^";
						$positionqw = strpos($qw, $finish); $qw = substr($qw, 0, $positionqw);

						$start = "&@#%^";
						$positionask = strpos($Aboutec, $start); $ask = substr($Aboutec, $positionask+5);

						$qw = str_replace("<b>", "", $qw); $qw = str_replace("</b>", "", $qw);
						$ask = str_replace("<b>", "", $ask); $ask = str_replace("</b>", "", $ask);

						if(strlen($qw)>100){$qw = substr($qw, 0, 100); $qw.="...";}
						if(strlen($ask)>100){$ask = substr($ask, 0, 100); $ask.="...";}

						$Aboutec = "<b>Запитання</b> $qw <b>Відповідь</b> $ask";
						$Aboutecr = "<b>Вопрос</b> $qw <b>Ответ</b> $ask";
						$Aboutece = "<b>Question</b> $qw <b>Answer</b> $ask";
					}
					else{
						if(mb_strstr((string)$Aboutec,"<")!=""){
                            $Md_tod = date('Y-m-d');
                            $Md_yes = date('Y-m-d', strtotime('-1 days'));
                            $Md_yes_yes = date('Y-m-d', strtotime('-2 days'));
							if($fM6==$Md_tod){$M6_e="сьогодні"; $M6_er="сегодня"; $M6_ee="today";}
							else if($fM6==$Md_yes){$M6_e="вчора"; $M6_er="вчера"; $M6_ee="yesterday";}
							else if($fM6==$Md_yes_yes){$M6_e="позавчора"; $M6_er="позавчера"; $M6_ee="day before yesterday";}
							else {
								$daym = substr($M6, 8, 2); $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
								if($monm == "1") {$monm = "січня"; $monmr = "января"; $monme = "January"; } if($monm == "2") {$monm = "лютого";   $monmr = "февраля";$monme = "February";} if($monm == "3") {$monm = "березня";$monmr = "марта";$monme = "March";}
								if($monm == "4") {$monm = "квітня";$monmr = "апреля";$monme = "April";}     if($monm == "5") {$monm = "травня";   $monmr = "мая";    $monme = "May";     } if($monm == "6") {$monm = "червня"; $monmr = "июня"; $monme = "June"; }
								if($monm == "7") {$monm = "липня"; $monmr = "июля"; $monme = "July"; }      if($monm == "8") {$monm = "серпня";   $monmr = "августа";$monme = "August";  } if($monm == "9") {$monm = "вересня";$monmr = "сентября";$monme = "September";}
								if($monm == "10"){$monm = "жовтня";$monmr = "октября";$monme = "October";}  if($monm == "11"){$monm = "листопада";$monmr = "ноября"; $monme = "November";} if($monm == "12"){$monm = "грудня"; $monmr = "декабря"; $monme = "December"; }
								if(substr($daym, 0, 1)==0){$daym = substr($daym, 1, 1);}

								$M6_e="$daym $monm $yem"; $M6_er="$daym $monmr $yem"; $M6_ee="$monme $daym, $yem"; $timep="";}

							$Aboutec = "Запис від $M6_e$timep";
							$Aboutecr = "Запись от $M6_er$timep";
							$Aboutece = "Record of $M6_ee$timep";
						}
						else{
							$Aboutec = substr($Aboutec, 0, 699); $Aboutec.="...";
							$Aboutecr = substr($Aboutecr, 0, 699); $Aboutecr.="...";
							$Aboutece = substr($Aboutece, 0, 699); $Aboutece.="...";
						}
					}

                    $ip = getenv('REMOTE_ADDR');
                    $Md = date('Y-m-d-H-i-s');
                    $aff = DB::table('Memorym')->insert(['id' => $id, 'idrec' => $Namef, 'avt' => $Numm, 'Aboutef' => $Aboutef,
                        'Md' => $Md]);

                    if($aff){

                        $sexm = Auth::user()->sex;
                        $Imm = Auth::user()->Im;
                        $Prizm = Auth::user()->Priz;
                        $Num_am = Auth::user()->avatar;
                        if ((!$Num_am) || $Num_am < 10) {
                            $Num_am = 7;
                        }
                        if(!$sexm){$sexm=0;}
                        $sex = "$sexm$Num_am";

                        $show_news = Auth::user()->show_news;
                        if (!$show_news) {
                            $ncoment = 1;
                        } else {
                            $ncoment=substr($show_news, 3, 1);
                        }
                        if($ncoment==1) {

                            $Allcm = DB::table('Memorym')->select('avt')->
                            where('idrec', $Namef)->get();
                            foreach ($Allcm as $All) {
                                $avt_other = $All->avt;
                                if (mb_strstr((string)$allusersn,(string)$avt_other)==""){$allusersn.=" $avt_other ";}
                            }
                            $Allc = DB::table('Allcities')->select('City','City2','City3')->
                            where('id', $id)->limit(1)->get();
                            foreach ($Allc as $All) {
                                $City = $All->City; $City2 = $All->City2; $City3 = $All->City3;
                            }

                            $theme="c#&~$Namef#&~$City#&~$City2#&~$City3#&~$theme";
                            $ualine="<a href=/rec$Namef><b>Запис:</b><br /><font size=1> $Aboutec</font><br /><b>Коментар:</b><br />";
                            $ruline="<a href=/rrec$Namef><b>Запись:</b><br /><font size=1> $Aboutecr</font><br /><b>Комментарий:</b><br />";
                            $enline="<a href=/erec$Namef><b>Record:</b><br /><font size=1> $Aboutece</font><br /><b>Comment:</b><br />";
                            DB::table('News')->insert(['act' => 'ncomentm', 'obl' => $obl, 'Im' => $Imm, 'Priz' => $Prizm,
                                'sex' => $sex, 'ualine' => $ualine, 'ruline' => $ruline, 'enline' => $enline, 'theme' => $theme, 'avt' => $Numm, 'whom' => $allusersn,
                                'forum' => $Aboutef, 'avt_fr' => $Numm, 'Nd' => $Md]);
                        }


                        $emailu="";
                        if($avt>0 && $avt != $Numm){

                            $filename0 = "storage/last_visit/$avt.txt";
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

                                if ($lan_user == "ua") {
                                    $qu_in = "";
                                    $abn = "<a href=/rec$Namef>$Aboutec</a>";
                                    $Aboutef_e = "<a href=/rec$Namef>$Aboutef</a>";
                                }
                                if ($lan_user == "ru") {
                                    $qu_in = "r";
                                    $abn = "<a href=/rrec$Namef>$Aboutecr</a>";
                                    $Aboutef_e = "<a href=/rrec$Namef>$Aboutef</a>";
                                }
                                if ($lan_user == "en") {
                                    $qu_in = "e";
                                    $abn = "<a href=/erec$Namef>$Aboutece</a>";
                                    $Aboutef_e = "<a href=/erec$Namef>$Aboutef</a>";
                                }

                                $prlink3 = $qu_in; $prlink3.="i"; $prlink3.=$Numm;

                                $r_else="#!:*&<table><tr><td width=100 valign=top align=right>
                                        <table>
                                        <tr><td>$abn</td></tr>
                                        </table>
                                        </td>
                                        <td valign=top width=150>
                                        <a href=/$prlink3><div style=\"height: 50px; overflow: hidden\">
                                        <img style=\"margin: 0px 5px 0px 0px;\" border=0 SRC=/storage/avatar/s$Num_am.jpg align=left>
                                        $Imm $Prizm</div></a>
                                        <div style=\"width: 150px; overflow: hidden\">$Aboutef_e</div>
                                        </td></tr></table>";

                                $filename = "storage/notice/$avt.txt";
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

                            }


                            $Allq = DB::table('users')->select('comment', 'email')->
                            where('id', $avt)->limit(1)->get();
                            foreach ($Allq as $Alq) {
                                $comment = $Alq->comment;
                                $emailu = $Alq->email;
                            }

                            $mailgo = "off";
                            $mailput = "commment$avt";
                            if (!$comment || $comment == 0) {
                                $mailgo="on";
                            }
                            if ($comment == 1) {

                                $filename = "storage/sixhours.txt";
                                $whattoread = @fopen($filename, "r");
                                $truestat_file_contents = fread($whattoread, filesize($filename));
                                fclose($whattoread);
                                $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                                if ($lastmail == "") {
                                    $mailgo = "on";
                                    $newfile = @fopen($filename, "a");
                                    @fwrite($newfile, $mailput);
                                    fclose($newfile);
                                }
                            }
                            else if ($comment == 2) {

                                $filename = "storage/oneday.txt";
                                $whattoread = @fopen($filename, "r");
                                $truestat_file_contents = fread($whattoread, filesize($filename));
                                fclose($whattoread);

                                $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                                if ($lastmail == "") {
                                    $mailgo = "on";
                                    $newfile = @fopen($filename, "a");
                                    @fwrite($newfile, $mailput);
                                    fclose($newfile);
                                }
                            }



                            if ($mailgo == "on") {
                                if ($lan_user == "ua") {
                                    if($sexm==1){$sexm_e1="додав"; $sexm_e2="прокоментував";}
                                    else if($sexm==2){$sexm_e1="додала"; $sexm_e2="прокоментувала";}
                                    else{$sexm_e1="додав (ла)"; $sexm_e2="прокоментував (ла)";}

                                    $subj = "$Imm $Prizm $sexm_e2 Ваш запис...";
                                    $blade = "emails.rec_commment";
                                }
                                if ($lan_user == "ru") {
                                    if($sexm==1){$sexm_e1="добавил"; $sexm_e2="прокомментировал";}
                                    else if($sexm==2){$sexm_e1="добавила"; $sexm_e2="прокомментировала";}
                                    else{$sexm_e1="добавил (ла)"; $sexm_e2="прокомментировал (ла)";}

                                    $subj = "$Imm $Prizm $sexm_e2 Вашу запись...";
                                    $blade = "emails.rrec_commment";
                                }
                                if ($lan_user == "en") {
                                    $subj = "$Imm $Prizm commented on Your record...";
                                    $sexm_e1 = "";
                                    $sexm_e2 = "";
                                    $blade = "emails.erec_commment";
                                }
                                if (filter_var($emailu, FILTER_VALIDATE_EMAIL)) {
                                    $Nameg = "$Imm $Prizm";
                                    $details['email'] = trim($emailu);
                                    $details['subject'] = $subj;
                                    $details['blade'] = $blade;
                                    $details['det'] = array('Namef' => $Namef, 'Nameg' => $Nameg, 'sexm_e1' => $sexm_e1);
                                    $details['unsub'] = "";
                                    dispatch(new App\Jobs\SendEmailJob($details));
                                }
                            }
                        }


                        $mailput = "commment_i$id";
                        $q_s1[0] = ['comment', 1];
                        $q_s2[0] = ['comment', 1];
                        $q_s3[0] = ['comment', 1];

                        $filename = "storage/sixhours.txt";
                        $whattoread = @fopen($filename, "r");
                        $truestat_file_contents = fread($whattoread, filesize($filename));

                        fclose($whattoread);
                        $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                        if ($lastmail == "") {
                            $q_s2[0] = ['comment', 2];
                            $newfile = @fopen($filename, "a");
                            @fwrite($newfile, $mailput);
                            fclose($newfile);
                        }

                        $filename = "storage/oneday.txt";
                        $whattoread = @fopen($filename, "r");
                        $truestat_file_contents = fread($whattoread, filesize($filename));
                        fclose($whattoread);

                        $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                        if ($lastmail == "") {
                            $q_s3[0] = ['forum', 3];
                            $newfile = @fopen($filename, "a");
                            @fwrite($newfile, $mailput);
                            fclose($newfile);
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

                        $myemail = Auth::user()->email;
                        foreach ($Allm as $Alm) {

                            $Pmail = trim($Alm->mail_visitor);
                            if($myemail!=$Pmail && $emailu!=$Pmail){
                                $subj = "Доданий коментар до запису $City";
                                if($sexm==1){$sexm_e1="додав"; }
                                else if($sexm==2){$sexm_e1="додала";}
                                else{$sexm_e1="додав (ла)";}
                                $Nameg = "$Imm $Prizm";
                                if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                    $details['email'] = $Pmail;
                                    $details['subject'] = $subj;
                                    $details['blade'] = 'emails.commmentc';
                                    $details['det'] = array('City' => $City, 'Nameg' => $Nameg, 'Namef' => $Namef, 'id' => $id, 'rec' => $Namef, 'sexm_e1' => $sexm_e1, 'Pmail' => $Pmail);
                                    $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                                    dispatch(new App\Jobs\SendEmailJob($details));
                                }
                            }
                        }

                        echo view('inc.commment', ['M5' => $Namef, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'on', 'purp' => $purp]);

                    }
                }
                else{
                    $ask_err = __('messages.comm_ban');
                    echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
                }
            }
        }
        else{
            $ch_e = __('messages.comment_need_reg');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }
    }








    function commm_addp(Request $request)
    {
        $Namef = $request['M5'];
        $Aboutef = $request['Aboutef'];
        $purp = $request['purp'];
        $Aboutef = getDescriptionAttribute($Aboutef);
        $Aboutef = nl2br($Aboutef);
        $Namef = $Namef + 1; $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {die("");}
        $abuse_ban = __('messages.abuse_ban');
        $lan = __('messages.lan');

        if(Auth::user()) {
            $ctrl_hss = $Aboutef;
            $my_id = Auth::user()->id;

            $ctrl_hss = htmlspecialchars_decode($ctrl_hss, ENT_QUOTES);
            $ctrl_hss = strip_tags($ctrl_hss); // Видаляє HTML

            if (preg_match("/<[^<]+>/", $ctrl_hss) && $my_id != 29724907) { exit; }

            $ctrl_hss2 = $ctrl_hss . ">";
            if (preg_match("/<[^<]+>/", $ctrl_hss2) && $my_id != 29724907) { exit; }

            $Aboutef = preg_replace_callback(
                '/(https?:\/\/[^\s<]+[^.,:;"\')\]\s<])/u',
                function ($matches) {
                    $url = $matches[0];
                    $shortUrl = (strlen($url) > 35) ? substr($url, 0, 35) . "..." : $url;


                    $urlParts = explode('/', rtrim($shortUrl, '/'));
                    $lastPart = array_pop($urlParts); // Остання частина URL
                    $boldUrl = implode('/', $urlParts) . '/<b>' . $lastPart . '</b>'; // Додаємо жирний стиль

                    return '<a target="_blank" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($boldUrl, ENT_QUOTES, 'UTF-8') . '</a>';
                },
                $ctrl_hss
            );

            $Aboutef = htmlspecialchars_decode($Aboutef, ENT_QUOTES);
            if (!$Aboutef) {
                $ask_err = __('messages.comm_err');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }
            else if (mb_strlen($Aboutef) > 500) {
                $ask_err = __('messages.ask_err2');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }

            else if (mb_strstr($Aboutef,"хуй")!=""||mb_strstr($Aboutef,"пизд")!=""||mb_strstr($Aboutef," конч")!=""||mb_strstr($Aboutef,"вафл")!=""||mb_strstr($Aboutef,"шлюх")!=""||mb_strstr($Aboutef,"fuck")!=""||mb_strstr($Aboutef," гом")!=""||mb_strstr($Aboutef," бля")!=""||mb_strstr($Aboutef," манд")!=""||mb_strstr($Aboutef,"член")!=""||mb_strstr($Aboutef," еба")!=""||mb_strstr($Aboutef," єба")!=""||mb_strstr($Aboutef,"суч")!=""||mb_strstr($Aboutef,"сук")!=""||mb_strstr($Aboutef,"дроч")!=""||mb_strstr($Aboutef," писк")!=""||mb_strstr($Aboutef," піськ")!=""||mb_strstr($Aboutef,"урод")!=""||mb_strstr($Aboutef,"ублюд")!=""||mb_strstr($Aboutef,"соса")!=""||mb_strstr($Aboutef,"соси")!=""||mb_strstr($Aboutef,"сран")!=""||mb_strstr($Aboutef,"срак")!=""||mb_strstr($Aboutef,"срат")!=""||mb_strstr($Aboutef,"хуев")!=""||mb_strstr($Aboutef,"костр")!=""||mb_strstr($Aboutef,"блев")!=""||mb_strstr($Aboutef,"яйц")!=""||mb_strstr($Aboutef," трах")!=""||mb_strstr($Aboutef,"влагал")!=""||mb_strstr($Aboutef," онан")!=""){

                $bad_words="<font color=red>";
                if (mb_strstr((string)$Aboutef,"хуй")!=""){$bad_words.=" хуй";}
                if (mb_strstr((string)$Aboutef,"пизд")!=""){$bad_words.=" пизд";}
                if (mb_strstr((string)$Aboutef,"сперм")!=""){$bad_words.=" сперм";}
                if (mb_strstr((string)$Aboutef,"шлюх")!=""){$bad_words.=" шлюх";}
                if (mb_strstr((string)$Aboutef,"гом")!=""){$bad_words.=" гом";}
                if (mb_strstr((string)$Aboutef,"бля")!=""){$bad_words.=" бля";}
                if (mb_strstr((string)$Aboutef,"еба")!=""){$bad_words.=" еба";}
                if (mb_strstr((string)$Aboutef,"єба")!=""){$bad_words.=" єба";}
                if (mb_strstr((string)$Aboutef,"сук")!=""){$bad_words.=" сукa";}
                if (mb_strstr((string)$Aboutef,"дроч")!=""){$bad_words.=" дроч";}
                if (mb_strstr((string)$Aboutef,"піськ")!=""){$bad_words.=" піськ";}
                if (mb_strstr((string)$Aboutef,"ублюд")!=""){$bad_words.=" ублюд";}
                if (mb_strstr((string)$Aboutef,"сран")!=""){$bad_words.=" сран";}
                if (mb_strstr((string)$Aboutef,"срак")!=""){$bad_words.=" срак";}
                if (mb_strstr((string)$Aboutef,"срат")!=""){$bad_words.=" срат";}
                if (mb_strstr((string)$Aboutef,"хуев")!=""){$bad_words.=" хуев";}
                if (mb_strstr((string)$Aboutef,"трах")!=""){$bad_words.=" трах";}
                if (mb_strstr((string)$Aboutef,"онан")!=""){$bad_words.=" онан";}
                if (mb_strstr((string)$Aboutef,"хуя")!=""){$bad_words.=" хуя";}
                $bad_words.="</font>";

                echo"s235*64@75<table><tr><td align=center><p style=\"margin: 8px 0px 8px 0px; \">$abuse_ban: $bad_words</p></td></tr></table>";
            }
            else {

                $Allb = DB::table('Memoryp')->select('Num', 'theme', 'avt', 'Md','Aboutep','Aboutepr','Aboutepe','rh')->
                where('idrec', $Namef)->limit(1)->get();

                foreach ($Allb as $All) {
                    $id = $All->Num; $theme = $All->theme;
                    $avt = $All->avt; $fM6 = $All->Md; $M6= $fM6;
                    $Aboutep = $All->Aboutep; $Aboutepr = $All->Aboutepr; $Aboutepe = $All->Aboutepe;
                    $rh = $All->rh; $whom = $avt;
                }
				if(!$Aboutepr){$Aboutepr=$Aboutep;}
				if(!$Aboutepe){$Aboutepe=$Aboutep;}

                $allusersn = "";
                $nmark=substr_count($rh, ':');
                if($nmark>0){
                    $v_page = explode(":", $rh);
                    for($a=1; $a<=$nmark; $a++){
                        $pm=$v_page[$a]; $pm = explode("*", $pm); $avtm=$pm[1];
                        if (mb_strstr((string)$allusersn,(string)$avtm)==""){$allusersn.=" $avtm ";}
                    }
                }

                if($whom>0){
                    if (mb_strstr((string)$allusersn,(string)$whom)==""){$allusersn.=" $whom ";}
                }

                $Numm = Auth::user()->id;
                $sq = 0;
                $Allq = DB::table('Private')->select('ban')->
                where('Num', $whom)->limit(1)->get();
                foreach ($Allq as $Alq) {
                    $ComForBan = $Alq->ban;
                    $sq++;
                }
                if ($sq == 0) {
                    $ComForBan = "";
                }

                $sq = 0;
                $Forum = 1;
                $Allq = DB::table('Private')->select('ban', 'Forum')->
                where('Num', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {
                    $Ban = $Alq->ban;
                    $Forum = $Alq->Forum;
                    $sq++;
                }
                if ($sq == 0) {
                    $Ban = "";
                }

                $admpass = "off";
                if ($id == $Numm) {
                    $admpass = "ok";
                }

                $Privatpass = "stop";
                if (!$Forum || $Forum == 0 || $Forum == 1 || $Forum == 2) {
                    $Privatpass = "go";
                } else {

                    $Alls = DB::table('Friends')->select('Num1', 'Num2')->
                    where(function ($query1) use ($id) {
                        $query1->where('Num1', $id)
                            ->where('Argue', '=', 2);
                    })->
                    orWhere(function ($query2) use ($id) {
                        $query2->where('Num2', $id)
                            ->where('Argue', '=', 2);
                    })->
                    get();
                    $fr_avt = "";
                    $Numfr = "";
                    foreach ($Alls as $All) {
                        $Num1 = $All->Num1;
                        $Num2 = $All->Num2;
                        if ($Num1 == $id) {
                            $Numfr = $Num2;
                        } else {
                            $Numfr = $Num1;
                        }
                        $fr_avt .= " $Numfr";
                    }
                    $my_id = Auth::user()->id;
                    $my_id2 = "$my_id";
                    $isfriend = mb_strstr((string)$fr_avt, (string)$my_id2);

                    if ($Forum == 3 && ($id == $Numm || $isfriend != "")) {
                        $Privatpass = "go";
                    } else {
                        if ($Forum == 4 && $id == $Numm) {
                            $Privatpass = "go";
                        }
                    }
                }


                if (mb_strstr((string)$ComForBan, (string)$Numm) == "" && mb_strstr((string)$Ban, (string)$Numm) == "") {
                    if ($Privatpass == "go") {

						if(mb_strstr((string)$Aboutep,"%^&@#")!=""){

							$start = "%^&@#";
							$positionqw = strpos($Aboutep, $start); $qw = substr($Aboutep, $positionqw+5);

							$finish = "&@#%^";
							$positionqw = strpos($qw, $finish); $qw = substr($qw, 0, $positionqw);

							$start = "&@#%^";
							$positionask = strpos($Aboutep, $start); $ask = substr($Aboutep, $positionask+5);

							$qw = str_replace("<b>", "", $qw); $qw = str_replace("</b>", "", $qw);
							$ask = str_replace("<b>", "", $ask); $ask = str_replace("</b>", "", $ask);

							if(strlen($qw)>100){$qw = substr($qw, 0, 100); $qw.="...";}
							if(strlen($ask)>100){$ask = substr($ask, 0, 100); $ask.="...";}

							$Aboutep = "<b>Запитання</b> $qw <b>Відповідь</b> $ask";
							$Aboutepr = "<b>Вопрос</b> $qw <b>Ответ</b> $ask";
							$Aboutepe = "<b>Question</b> $qw <b>Answer</b> $ask";
						}
						else{
							if(mb_strstr((string)$Aboutep,"<")!=""){
                                $Md_tod = date('Y-m-d');
                                $Md_yes = date('Y-m-d', strtotime('-1 days'));
                                $Md_yes_yes = date('Y-m-d', strtotime('-2 days'));
								if($fM6==$Md_tod){$M6_e="сьогодні"; $M6_er="сегодня"; $M6_ee="today";}
								else if($fM6==$Md_yes){$M6_e="вчора"; $M6_er="вчера"; $M6_ee="yesterday";}
								else if($fM6==$Md_yes_yes){$M6_e="позавчора"; $M6_er="позавчера"; $M6_ee="day before yesterday";}
								else {
									$daym = substr($M6, 8, 2); $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
									if($monm == "1") {$monm = "січня"; $monmr = "января"; $monme = "January"; } if($monm == "2") {$monm = "лютого";   $monmr = "февраля";$monme = "February";} if($monm == "3") {$monm = "березня";$monmr = "марта";$monme = "March";}
									if($monm == "4") {$monm = "квітня";$monmr = "апреля";$monme = "April";}     if($monm == "5") {$monm = "травня";   $monmr = "мая";    $monme = "May";     } if($monm == "6") {$monm = "червня"; $monmr = "июня"; $monme = "June"; }
									if($monm == "7") {$monm = "липня"; $monmr = "июля"; $monme = "July"; }      if($monm == "8") {$monm = "серпня";   $monmr = "августа";$monme = "August";  } if($monm == "9") {$monm = "вересня";$monmr = "сентября";$monme = "September";}
									if($monm == "10"){$monm = "жовтня";$monmr = "октября";$monme = "October";}  if($monm == "11"){$monm = "листопада";$monmr = "ноября"; $monme = "November";} if($monm == "12"){$monm = "грудня"; $monmr = "декабря"; $monme = "December"; }
									if(substr($daym, 0, 1)==0){$daym = substr($daym, 1, 1);}

									$M6_e="$daym $monm $yem"; $M6_er="$daym $monmr $yem"; $M6_ee="$monme $daym, $yem"; $timep="";}

								$Aboutep = "Запис від $M6_e$timep";
								$Aboutepr = "Запись от $M6_er$timep";
								$Aboutepe = "Record of $M6_ee$timep";
							}
							else{
								$Aboutep = substr($Aboutep, 0, 699); $Aboutep.="...";
								$Aboutepr = substr($Aboutepr, 0, 699); $Aboutepr.="...";
								$Aboutepe = substr($Aboutepe, 0, 699); $Aboutepe.="...";
							}
						}

						$ip = getenv('REMOTE_ADDR');
						$Md = date('Y-m-d-H-i-s');
						$aff = DB::table('Memorymp')->insert(['Nump' => $id, 'idrec' => $Namef, 'avt' => $Numm, 'Aboutef' => $Aboutef,
							'Md' => $Md]);

						if($aff){

							$sexm = Auth::user()->sex;
							$Imm = Auth::user()->Im;
							$Prizm = Auth::user()->Priz;
							$Num_am = Auth::user()->avatar;
							if ((!$Num_am) || $Num_am < 10) {
								$Num_am = 7;
							}
							if(!$sexm){$sexm=0;}
							$sex = "$sexm$Num_am";

							$show_news = Auth::user()->show_news;
							if (!$show_news) {
								$ncoment = 1;
							} else {
								$ncoment=substr($show_news, 3, 1);
							}
							if($ncoment==1) {

								$Allcm = DB::table('Memorymp')->select('avt')->
								where('idrec', $Namef)->get();
								foreach ($Allcm as $All) {
									$avt_other = $All->avt;
									if (mb_strstr((string)$allusersn,(string)$avt_other)==""){$allusersn.=" $avt_other ";}
								}
								if($Numm==$id){
									$Im = $Imm; $Priz = $Prizm;
								}
								else{
									$Allc = DB::table('users')->select('Im','Priz')->
									where('id', $id)->limit(1)->get();
									foreach ($Allc as $All) {
										$Im = $All->Im; $Priz = $All->Priz;
									}
								}


								$theme="p#&~$Namef#&~$Im#&~$Priz#&~$Priz#&~$theme";
								$ualine="<a href=/recp$Namef><b>Запис:</b><br /><font size=1> $Aboutep</font><br /><b>Коментар:</b><br />";
								$ruline="<a href=/rrecp$Namef><b>Запись:</b><br /><font size=1> $Aboutepr</font><br /><b>Комментарий:</b><br />";
								$enline="<a href=/erecp$Namef><b>Record:</b><br /><font size=1> $Aboutepe</font><br /><b>Comment:</b><br />";
								DB::table('News')->insert(['act' => 'ncomentm', 'Im' => $Imm, 'Priz' => $Prizm,
									'sex' => $sex, 'ualine' => $ualine, 'ruline' => $ruline, 'enline' => $enline, 'theme' => $theme, 'avt' => $Numm, 'whom' => $allusersn,
									'forum' => $Aboutef, 'avt_fr' => $Numm, 'Nd' => $Md]);
							}


							$emailu="";
							if($avt>0 && $avt != $Numm){

								$filename0 = "storage/last_visit/$avt.txt";
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

									if ($lan_user == "ua") {
										$qu_in = "";
										$abn = "<a href=/recp$Namef>$Aboutep</a>";
										$Aboutef_e = "<a href=/recp$Namef>$Aboutef</a>";
									}
									if ($lan_user == "ru") {
										$qu_in = "r";
										$abn = "<a href=/rrecp$Namef>$Aboutepr</a>";
										$Aboutef_e = "<a href=/rrecp$Namef>$Aboutef</a>";
									}
									if ($lan_user == "en") {
										$qu_in = "e";
										$abn = "<a href=/erecp$Namef>$Aboutepe</a>";
										$Aboutef_e = "<a href=/erecp$Namef>$Aboutef</a>";
									}

									$prlink3 = $qu_in; $prlink3.="i"; $prlink3.=$Numm;

									$r_else="#!:*&<table><tr><td width=100 valign=top align=right>
											<table>
											<tr><td>$abn</td></tr>
											</table>
											</td>
											<td valign=top width=150>
											<a href=/$prlink3><div style=\"height: 50px; overflow: hidden\">
											<img style=\"margin: 0px 5px 0px 0px;\" border=0 SRC=/storage/avatar/s$Num_am.jpg align=left>
											$Imm $Prizm</div></a>
											<div style=\"width: 150px; overflow: hidden\">$Aboutef_e</div>
											</td></tr></table>";

									$filename = "storage/notice/$avt.txt";
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

								}


								$Allq = DB::table('users')->select('comment', 'email')->
								where('id', $avt)->limit(1)->get();
								foreach ($Allq as $Alq) {
									$comment = $Alq->comment;
									$emailu = $Alq->email;
								}

								$mailgo = "off";
								$mailput = "commment$avt";
								if (!$comment || $comment == 0) {
									$mailgo="on";
								}
								if ($comment == 1) {

									$filename = "storage/sixhours.txt";
									$whattoread = @fopen($filename, "r");
									$truestat_file_contents = fread($whattoread, filesize($filename));
									fclose($whattoread);
									$lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

									if ($lastmail == "") {
										$mailgo = "on";
										$newfile = @fopen($filename, "a");
										@fwrite($newfile, $mailput);
										fclose($newfile);
									}
								}
								else if ($comment == 2) {

									$filename = "storage/oneday.txt";
									$whattoread = @fopen($filename, "r");
									$truestat_file_contents = fread($whattoread, filesize($filename));
									fclose($whattoread);

									$lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

									if ($lastmail == "") {
										$mailgo = "on";
										$newfile = @fopen($filename, "a");
										@fwrite($newfile, $mailput);
										fclose($newfile);
									}
								}



								if ($mailgo == "on") {
									if ($lan_user == "ua") {
										if($sexm==1){$sexm_e1="додав"; $sexm_e2="прокоментував";}
										else if($sexm==2){$sexm_e1="додала"; $sexm_e2="прокоментувала";}
										else{$sexm_e1="додав (ла)"; $sexm_e2="прокоментував (ла)";}

										$subj = "$Imm $Prizm $sexm_e2 Ваш запис...";
										$blade = "emails.recp_commment";
									}
									if ($lan_user == "ru") {
										if($sexm==1){$sexm_e1="добавил"; $sexm_e2="прокомментировал";}
										else if($sexm==2){$sexm_e1="добавила"; $sexm_e2="прокомментировала";}
										else{$sexm_e1="добавил (ла)"; $sexm_e2="прокомментировал (ла)";}

										$subj = "$Imm $Prizm $sexm_e2 Вашу запись...";
										$blade = "emails.rrecp_commment";
									}
									if ($lan_user == "en") {
										$subj = "$Imm $Prizm commented on Your record...";
										$sexm_e1 = "";
										$sexm_e2 = "";
										$blade = "emails.erecp_commment";
									}
                                    if (filter_var($emailu, FILTER_VALIDATE_EMAIL)) {
                                        $Nameg = "$Imm $Prizm";
                                        $details['email'] = trim($emailu);
                                        $details['subject'] = $subj;
                                        $details['blade'] = $blade;
                                        $details['det'] = array('Namef' => $Namef, 'Nameg' => $Nameg, 'sexm_e1' => $sexm_e1);
                                        $details['unsub'] = "";
                                        dispatch(new App\Jobs\SendEmailJob($details));
                                    }
								}
							}

							if($Numm == $id){
								$mailput = "commment_i$id";
								$q_s1[0] = ['comment', 1];
								$q_s2[0] = ['comment', 1];
								$q_s3[0] = ['comment', 1];

								$filename = "storage/sixhours.txt";
								$whattoread = @fopen($filename, "r");
								$truestat_file_contents = fread($whattoread, filesize($filename));

								fclose($whattoread);
								$lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

								if ($lastmail == "") {
									$q_s2[0] = ['comment', 2];
									$newfile = @fopen($filename, "a");
									@fwrite($newfile, $mailput);
									fclose($newfile);
								}

								$filename = "storage/oneday.txt";
								$whattoread = @fopen($filename, "r");
								$truestat_file_contents = fread($whattoread, filesize($filename));
								fclose($whattoread);

								$lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

								if ($lastmail == "") {
									$q_s3[0] = ['forum', 3];
									$newfile = @fopen($filename, "a");
									@fwrite($newfile, $mailput);
									fclose($newfile);
								}

								$Allm = DB::table('Mailpost')
									->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3) {
										$query->whereNull('forum')
											->orWhere($q_s1)
											->orWhere($q_s2)
											->orWhere($q_s3);
									})
									->where('Nump', $id)
									->select('Pmail')
									->get();

								$myemail = Auth::user()->email;
								foreach ($Allm as $Alm) {

									$Pmail = trim($Alm->Pmail);
									if($myemail!=$Pmail && $emailu!=$Pmail){
										$Nameg = "$Imm $Prizm";
										$subj = "Доданий коментар до запису сторінки $Nameg";
										if($sexm==1){$sexm_e1="додав"; }
										else if($sexm==2){$sexm_e1="додала";}
										else{$sexm_e1="додав (ла)";}
                                        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                            $details['email'] = $Pmail;
                                            $details['subject'] = $subj;
                                            $details['blade'] = 'emails.commmentp';
                                            $details['det'] = array('Nameg' => $Nameg, 'Namef' => $Namef, 'id' => $id, 'rec' => $Namef, 'sexm_e1' => $sexm_e1, 'Pmail' => $Pmail);
                                            $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                                            dispatch(new App\Jobs\SendEmailJob($details));
                                        }
									}
								}
							}

							echo view('inc.commmentp', ['M5' => $Namef, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'on', 'purp' => $purp]);

						}
					}
                }
                else{
                    $ask_err = __('messages.comm_ban');
                    echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
                }
            }
        }
        else{
            $ch_e = __('messages.comment_need_reg');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }
    }






    function commm_red(Request $request)
    {
        $idrec = $request['idrec'];
        $Aboutef = $request['Aboutef'];
        $purp = $request['purp'];

        $Aboutef = getDescriptionAttribute($Aboutef);
        $Aboutef = nl2br($Aboutef);
        $ctrl_hss = $Aboutef;
        $my_id = Auth::user()->id;

        $ctrl_hss = htmlspecialchars_decode($ctrl_hss, ENT_QUOTES);
        $ctrl_hss = strip_tags($ctrl_hss); // Видаляє HTML

        if (preg_match("/<[^<]+>/", $ctrl_hss) && $my_id != 29724907) { exit; }

        $ctrl_hss2 = $ctrl_hss . ">";
        if (preg_match("/<[^<]+>/", $ctrl_hss2) && $my_id != 29724907) { exit; }

        $Aboutef = htmlspecialchars_decode($ctrl_hss, ENT_QUOTES);
        $idrec = $idrec + 1; $idrec = $idrec - 1;
        if (is_int($idrec) != "true") {die("");}
        $abuse_ban = __('messages.abuse_ban');

        if(Auth::user()) {
            $ctrl_hss = $Aboutef;
            $my_id = Auth::user()->id;

            $ctrl_hss = htmlspecialchars_decode($ctrl_hss, ENT_QUOTES);
            $ctrl_hss = strip_tags($ctrl_hss); // Видаляє HTML

            if (preg_match("/<[^<]+>/", $ctrl_hss) && $my_id != 29724907) { exit; }

            $ctrl_hss2 = $ctrl_hss . ">";
            if (preg_match("/<[^<]+>/", $ctrl_hss2) && $my_id != 29724907) { exit; }

            $Aboutef = preg_replace_callback(
                '/(https?:\/\/[^\s<]+[^.,:;"\')\]\s<])/u',
                function ($matches) {
                    $url = $matches[0];
                    $shortUrl = (strlen($url) > 35) ? substr($url, 0, 35) . "..." : $url;


                    $urlParts = explode('/', rtrim($shortUrl, '/'));
                    $lastPart = array_pop($urlParts); // Остання частина URL
                    $boldUrl = implode('/', $urlParts) . '/<b>' . $lastPart . '</b>'; // Додаємо жирний стиль

                    return '<a target="_blank" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($boldUrl, ENT_QUOTES, 'UTF-8') . '</a>';
                },
                $ctrl_hss
            );

            $Aboutef = htmlspecialchars_decode($Aboutef, ENT_QUOTES);
            if (!$Aboutef) {
                $ask_err = __('messages.comm_err');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }
            else if (mb_strlen($Aboutef) > 500) {
                $ask_err = __('messages.ask_err2');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }

            else if (mb_strstr((string)$Aboutef,"хуй")!=""||mb_strstr((string)$Aboutef,"пизд")!=""||mb_strstr((string)$Aboutef," конч")!=""||mb_strstr((string)$Aboutef,"вафл")!=""||mb_strstr((string)$Aboutef,"шлюх")!=""||mb_strstr((string)$Aboutef,"fuck")!=""||mb_strstr((string)$Aboutef," гом")!=""||mb_strstr((string)$Aboutef," бля")!=""||mb_strstr((string)$Aboutef," манд")!=""||mb_strstr((string)$Aboutef,"член")!=""||mb_strstr((string)$Aboutef," еба")!=""||mb_strstr((string)$Aboutef," єба")!=""||mb_strstr((string)$Aboutef,"суч")!=""||mb_strstr((string)$Aboutef,"сук")!=""||mb_strstr((string)$Aboutef,"дроч")!=""||mb_strstr((string)$Aboutef," писк")!=""||mb_strstr((string)$Aboutef," піськ")!=""||mb_strstr((string)$Aboutef,"урод")!=""||mb_strstr((string)$Aboutef,"ублюд")!=""||mb_strstr((string)$Aboutef,"соса")!=""||mb_strstr((string)$Aboutef,"соси")!=""||mb_strstr((string)$Aboutef,"сран")!=""||mb_strstr((string)$Aboutef,"срак")!=""||mb_strstr((string)$Aboutef,"срат")!=""||mb_strstr((string)$Aboutef,"хуев")!=""||mb_strstr((string)$Aboutef,"костр")!=""||mb_strstr((string)$Aboutef,"блев")!=""||mb_strstr((string)$Aboutef,"яйц")!=""||mb_strstr((string)$Aboutef," трах")!=""||mb_strstr((string)$Aboutef,"влагал")!=""||mb_strstr((string)$Aboutef," онан")!=""){

                $bad_words="<font color=red>";
                if (mb_strstr((string)$Aboutef,"хуй")!=""){$bad_words.=" хуй";}
                if (mb_strstr((string)$Aboutef,"пизд")!=""){$bad_words.=" пизд";}
                if (mb_strstr((string)$Aboutef,"сперм")!=""){$bad_words.=" сперм";}
                if (mb_strstr((string)$Aboutef,"шлюх")!=""){$bad_words.=" шлюх";}
                if (mb_strstr((string)$Aboutef,"гом")!=""){$bad_words.=" гом";}
                if (mb_strstr((string)$Aboutef,"бля")!=""){$bad_words.=" бля";}
                if (mb_strstr((string)$Aboutef,"еба")!=""){$bad_words.=" еба";}
                if (mb_strstr((string)$Aboutef,"єба")!=""){$bad_words.=" єба";}
                if (mb_strstr((string)$Aboutef,"сук")!=""){$bad_words.=" сукa";}
                if (mb_strstr((string)$Aboutef,"дроч")!=""){$bad_words.=" дроч";}
                if (mb_strstr((string)$Aboutef,"піськ")!=""){$bad_words.=" піськ";}
                if (mb_strstr((string)$Aboutef,"ублюд")!=""){$bad_words.=" ублюд";}
                if (mb_strstr((string)$Aboutef,"сран")!=""){$bad_words.=" сран";}
                if (mb_strstr((string)$Aboutef,"срак")!=""){$bad_words.=" срак";}
                if (mb_strstr((string)$Aboutef,"срат")!=""){$bad_words.=" срат";}
                if (mb_strstr((string)$Aboutef,"хуев")!=""){$bad_words.=" хуев";}
                if (mb_strstr((string)$Aboutef,"трах")!=""){$bad_words.=" трах";}
                if (mb_strstr((string)$Aboutef,"онан")!=""){$bad_words.=" онан";}
                if (mb_strstr((string)$Aboutef,"хуя")!=""){$bad_words.=" хуя";}
                $bad_words.="</font>";

                echo"s235*64@75<table><tr><td align=center><p style=\"margin: 8px 0px 8px 0px; \">$abuse_ban: $bad_words</p></td></tr></table>";
            }
            else {

                $my_id = Auth::user()->id;

                $Allb = DB::table('Memorym')->select('id', 'idrec', 'avt', 'Md')->
                where('idrec2', $idrec)->limit(1)->get();
                foreach ($Allb as $All) {
                    $id = $All->id;  $Namef = $All->idrec; $avtc = $All->avt; $Md = $All->Md;
                }
                $avt = 0;
                $Allb = DB::table('Memory')->select('avt')->
                where('idrec', $Namef)->limit(1)->get();
                foreach ($Allb as $All) {
                    $avt = $All->avt;
                }

                $admpass = "off";
                $Allad = DB::table('City_Admin2')->select('Num')->
                where('Num', $my_id)->where('Page', 'Memory')->where('id', $id)->
                limit(1)->get();
                $Alladn = $Allad->count();
                if ($Alladn > 0) {
                    $admpass = "ok";
                }

                $Numm = Auth::user()->id;
                $sq=0;
                $Allq = DB::table('Privatec')->select('ComForBan')->
                where('id', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {$ComForBan=$Alq->ComForBan; $sq++; }
                if($sq==0){ $ComForBan = "";}


                if(mb_strstr((string)$ComForBan, (string)$Numm)=="") {

                    $affected = DB::table('Memorym')
                        ->where('idrec2', $idrec)
                        ->update(['Aboutef' => $Aboutef]);

                    DB::table('News')
                        ->where('act', 'ncomentm')
                        ->where('avt', $avtc)
                        ->where('Nd', $Md)
                        ->update(['forum' => $Aboutef]);

                    if($affected){
                        echo view('inc.commment', ['M5' => $Namef, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'on', 'purp' => $purp]);
                    }

                }
                else{
                    $ask_err = __('messages.comm_ban');
                    echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
                }

            }
        }
        else{
            $ch_e = __('messages.comment_need_reg');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }

    }







    function commm_redp(Request $request)
    {

        $idrec = $request['idrec'];
        $Aboutef = $request['Aboutef'];
        $purp = $request['purp'];
        $Aboutef = getDescriptionAttribute($Aboutef);
        $Aboutef = nl2br($Aboutef);
        $ctrl_hss = $Aboutef;
        $my_id = Auth::user()->id;

        $ctrl_hss = htmlspecialchars_decode($ctrl_hss, ENT_QUOTES);
        $ctrl_hss = strip_tags($ctrl_hss); // Видаляє HTML

        if (preg_match("/<[^<]+>/", $ctrl_hss) && $my_id != 29724907) { exit; }

        $ctrl_hss2 = $ctrl_hss . ">";
        if (preg_match("/<[^<]+>/", $ctrl_hss2) && $my_id != 29724907) { exit; }

        $Aboutef = htmlspecialchars_decode($ctrl_hss, ENT_QUOTES);

        $idrec = $idrec + 1; $idrec = $idrec - 1;
        if (is_int($idrec) != "true") {die("");}
        $abuse_ban = __('messages.abuse_ban');

        if(Auth::user()) {
            $ctrl_hss= mb_strtolower($Aboutef);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            if (!$Aboutef) {
                $ask_err = __('messages.comm_err');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }
            else if (mb_strlen($Aboutef) > 500) {
                $ask_err = __('messages.ask_err2');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }

            else if (mb_strstr((string)$Aboutef,"хуй")!=""||mb_strstr((string)$Aboutef,"пизд")!=""||mb_strstr((string)$Aboutef," конч")!=""||mb_strstr((string)$Aboutef,"вафл")!=""||mb_strstr((string)$Aboutef,"шлюх")!=""||mb_strstr((string)$Aboutef,"fuck")!=""||mb_strstr((string)$Aboutef," гом")!=""||mb_strstr((string)$Aboutef," бля")!=""||mb_strstr((string)$Aboutef," манд")!=""||mb_strstr((string)$Aboutef,"член")!=""||mb_strstr((string)$Aboutef," еба")!=""||mb_strstr((string)$Aboutef," єба")!=""||mb_strstr((string)$Aboutef,"суч")!=""||mb_strstr((string)$Aboutef,"сук")!=""||mb_strstr((string)$Aboutef,"дроч")!=""||mb_strstr((string)$Aboutef," писк")!=""||mb_strstr((string)$Aboutef," піськ")!=""||mb_strstr((string)$Aboutef,"урод")!=""||mb_strstr((string)$Aboutef,"ублюд")!=""||mb_strstr((string)$Aboutef,"соса")!=""||mb_strstr((string)$Aboutef,"соси")!=""||mb_strstr((string)$Aboutef,"сран")!=""||mb_strstr((string)$Aboutef,"срак")!=""||mb_strstr((string)$Aboutef,"срат")!=""||mb_strstr((string)$Aboutef,"хуев")!=""||mb_strstr((string)$Aboutef,"костр")!=""||mb_strstr((string)$Aboutef,"блев")!=""||mb_strstr((string)$Aboutef,"яйц")!=""||mb_strstr((string)$Aboutef," трах")!=""||mb_strstr((string)$Aboutef,"влагал")!=""||mb_strstr((string)$Aboutef," онан")!=""){

                $bad_words="<font color=red>";
                if (mb_strstr((string)$Aboutef,"хуй")!=""){$bad_words.=" хуй";}
                if (mb_strstr((string)$Aboutef,"пизд")!=""){$bad_words.=" пизд";}
                if (mb_strstr((string)$Aboutef,"сперм")!=""){$bad_words.=" сперм";}
                if (mb_strstr((string)$Aboutef,"шлюх")!=""){$bad_words.=" шлюх";}
                if (mb_strstr((string)$Aboutef,"гом")!=""){$bad_words.=" гом";}
                if (mb_strstr((string)$Aboutef,"бля")!=""){$bad_words.=" бля";}
                if (mb_strstr((string)$Aboutef,"еба")!=""){$bad_words.=" еба";}
                if (mb_strstr((string)$Aboutef,"єба")!=""){$bad_words.=" єба";}
                if (mb_strstr((string)$Aboutef,"сук")!=""){$bad_words.=" сукa";}
                if (mb_strstr((string)$Aboutef,"дроч")!=""){$bad_words.=" дроч";}
                if (mb_strstr((string)$Aboutef,"піськ")!=""){$bad_words.=" піськ";}
                if (mb_strstr((string)$Aboutef,"ублюд")!=""){$bad_words.=" ублюд";}
                if (mb_strstr((string)$Aboutef,"сран")!=""){$bad_words.=" сран";}
                if (mb_strstr((string)$Aboutef,"срак")!=""){$bad_words.=" срак";}
                if (mb_strstr((string)$Aboutef,"срат")!=""){$bad_words.=" срат";}
                if (mb_strstr((string)$Aboutef,"хуев")!=""){$bad_words.=" хуев";}
                if (mb_strstr((string)$Aboutef,"трах")!=""){$bad_words.=" трах";}
                if (mb_strstr((string)$Aboutef,"онан")!=""){$bad_words.=" онан";}
                if (mb_strstr((string)$Aboutef,"хуя")!=""){$bad_words.=" хуя";}
                $bad_words.="</font>";

                echo"s235*64@75<table><tr><td align=center><p style=\"margin: 8px 0px 8px 0px; \">$abuse_ban: $bad_words</p></td></tr></table>";
            }
            else {

                $my_id = Auth::user()->id;

                $Allb = DB::table('Memorymp')->select('Nump', 'idrec', 'avt', 'Md')->
                where('idrec2', $idrec)->limit(1)->get();
                foreach ($Allb as $All) {
                    $id = $All->Nump;  $Namef = $All->idrec; $avtc = $All->avt; $Md = $All->Md;
                }
                $avt = 0;
                $Allb = DB::table('Memoryp')->select('avt')->
                where('idrec', $Namef)->limit(1)->get();
                foreach ($Allb as $All) {
                    $avt = $All->avt;
                }

                $admpass = "off";
                if ($my_id == $id) {
                    $admpass = "ok";
                }


                $Numm = Auth::user()->id;
                $sq = 0;
                $Forum = 1;
                $Allq = DB::table('Private')->select('ban', 'Forum')->
                where('Num', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {
                    $Ban = $Alq->ban;
                    $Forum = $Alq->Forum;
                    $sq++;
                }
                if ($sq == 0) {
                    $Ban = "";
                }

                if(mb_strstr((string)$Ban, (string)$Numm)=="") {


                    $affected = DB::table('Memorymp')
                        ->where('idrec2', $idrec)
                        ->update(['Aboutef' => $Aboutef]);

                    DB::table('News')
                        ->where('act', 'ncomentm')
                        ->where('avt', $avtc)
                        ->where('Nd', $Md)
                        ->update(['forum' => $Aboutef]);

                    if($affected){
                        echo view('inc.commmentp', ['M5' => $Namef, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'on', 'purp' => $purp]);
                    }

                }
                else{
                    $ask_err = __('messages.comm_ban');
                    echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
                }

            }
        }
        else{
            $ch_e = __('messages.comment_need_reg');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }

    }











	function commm_del(Request $request)
	{

		$idrec = $request['idrec'];
		$idrec = $idrec + 1; $idrec = $idrec - 1;
		if (is_int($idrec) != "true") {die("");}


		if(Auth::user()) {

			$my_id = Auth::user()->id;



			$Allb = DB::table('Memorym')->select('id', 'idrec', 'avt', 'Md')->
			where('idrec2', $idrec)->limit(1)->get();
			foreach ($Allb as $All) {
				$id = $All->id;  $Namef = $All->idrec; $avtc = $All->avt; $Md = $All->Md;
			}
			$avt = 0;
			$Allb = DB::table('Memory')->select('avt')->
			where('idrec', $Namef)->limit(1)->get();
			foreach ($Allb as $All) {
				$avt = $All->avt;
			}

			$admpass = "off";
			$Allad = DB::table('City_Admin2')->select('Num')->
			where('Num', $my_id)->where('Page', 'Memory')->where('id', $id)->
			limit(1)->get();
			$Alladn = $Allad->count();
			if ($Alladn > 0) {
				$admpass = "ok";
			}


			if ($admpass=="ok"||($avtc==$my_id&&$avtc>10)||($avt==$my_id&&$avt>10)|| $my_id=="72372396"){

				$aff = DB::table('Memorym')->where('idrec2', $idrec)->delete();
				DB::table('News')->
				where('act', 'ncomentm')->
				where('avt', $avtc)->
				where('Nd', $Md)->
				delete();
				if($aff){
					$ch_e = __('messages.comment_del');
					echo " $ch_e ";
				}
			}
		}
		else{
			$ch_e = __('messages.comment_del_need_reg');
			echo " $ch_e ";
		}
	}






	function commm_delp(Request $request)
	{

		$idrec = $request['idrec'];
		$idrec = $idrec + 1; $idrec = $idrec - 1;
		if (is_int($idrec) != "true") {die("");}


		if(Auth::user()) {

			$my_id = Auth::user()->id;

			$Allb = DB::table('Memorymp')->select('Nump', 'idrec', 'avt', 'Md')->
			where('idrec2', $idrec)->limit(1)->get();
			foreach ($Allb as $All) {
				$id = $All->Nump;  $Namef = $All->idrec; $avtc = $All->avt; $Md = $All->Md;
			}
			$avt = 0;
			$Allb = DB::table('Memoryp')->select('avt')->
			where('idrec', $Namef)->limit(1)->get();
			foreach ($Allb as $All) {
				$avt = $All->avt;
			}

			if ($id==$my_id||($avtc==$my_id&&$avtc>10)||($avt==$my_id&&$avt>10)|| $my_id=="72372396"){

				$aff = DB::table('Memorymp')->where('idrec2', $idrec)->delete();
				DB::table('News')->
				where('act', 'ncomentm')->
				where('avt', $avtc)->
				where('Nd', $Md)->
				delete();
				if($aff){
					$ch_e = __('messages.comment_del');
					echo " $ch_e ";
				}
			}
		}
		else{
			$ch_e = __('messages.comment_del_need_reg');
			echo " $ch_e ";
		}
	}



    function stat(Request $request)
    {
        $idfrom = $request['id'];
        $purp = $request['purp'];
        $lan = __('messages.lan');

		$fff = ""; $All_ratef = 0; $All_ratem = 0;
		if($purp=="Foto"){$perc_s='perc_f';} else{$perc_s='perc_m';}
		$All_ratef = 0;
		$All_ratem = 0;

        $Allb = DB::table('stat')->select('id','perc_f','perc_m','views')->
        where('id', '<', '26')->
        where('id', '>', '0')->
        orderBy('views','desc')->limit(25)->get();


		foreach ($Allb as $All) {
			$id = $All->id; $perc_f = $All->perc_f; $perc_m = $All->perc_m; $views = $All->views;
			$All_ratef = $All_ratef+$perc_f;
			$All_ratem = $All_ratem+$perc_m;
			if($purp=="Foto"){$perc_e=$perc_f;} else{$perc_e=$perc_m;}

			$oi = "messages.ooo$id"; $obl =__($oi);

            if($views==0){$display="display: none;";}
            else{$display="";}

            $fff .="<li class=\"stat-td\">
                        <a onclick=stat('$id','$purp')>
                            <div class=\"mb5\">$obl</div>
                            <div class=\"stats-item\">$perc_e% </div>
                            <div id=\"genOblViews$id\" class=\"stats-item stats-item-view\" style=\"$display\">
                                <svg style=\"margin-right: -2px;\" title='" . __('messages.views') . "' alt='" . __('messages.views') . "' width=\"12\" height=\"12\"><use href=\"/images/icons.svg#icon-magnifying-glass\"></use></svg>
                                <span class=\"in-dif\" id=\"inDif$id\"></span><span id=\"oblViews$id\">$views</span>
                            </div>
                        </a>
                  </li>";
		}

		$obl_e = ""; $ua_e = "";
        if((int)$idfrom>0 && (int)$idfrom<26){

            if($lan == "en") {
                $ua_e = "Ukraine";
            } elseif($lan == "ru") {
                $ua_e = "Украина";
            } else {
                $ua_e = "Україна";
            }
            $ua_e = "<a onclick=stat('0','$purp')><b>$ua_e </b></a> ->";
            $oi = "messages.ooo$idfrom";
            $obl = __($oi);
            $obl_e = "<b>$obl</b><br />";

            $fff = "";
            $Allb = DB::table('stat')
                ->select('id','City1','City2','City3','perc_f','perc_m', 'views')
                ->where('obl', $idfrom)
                ->orderByDesc('views')
                ->get();

            foreach ($Allb as $All) {
                $id = $All->id;
                $City1 = $All->City1;
                $City2 = $All->City2;
                $City3 = $All->City3;
                $perc_f = $All->perc_f;
                $perc_m = $All->perc_m;
                $views = $All->views;

                if($lan == "en") {
                    $City_e = $City3;
                } elseif($lan == "ru") {
                    $City_e = $City2;
                } else {
                    $City_e = $City1;
                }

                if($purp=="Foto") {
                    $perc_e=$perc_f;
                } else {
                    $perc_e=$perc_m;
                }

                if($views == 0) {
                    $display = "display: none;";
                } else {
                    $display = "";
                }

                $fff .="<li class=\"stat-td\">
            <a onclick=stat('$id','$purp')>
                <div class=\"mb5\">$City_e</div>
                <div class=\"stats-item\">$perc_e% </div>
                <div id=\"genRayViews$id\" class=\"stats-item stats-item-view\" style=\"$display\">
                    <svg style=\"margin-right: -2px;\" title='" . __('messages.views') . "' alt='" . __('messages.views') . "' width=\"12\" height=\"12\"><use href=\"/images/icons.svg#icon-magnifying-glass\"></use></svg>
                    <span class=\"in-dif\" id=\"inDif$id\"></span><span id=\"rayViews$id\">$views</span>
                </div>
            </a>
      </li>";
            }

		}


        $ray_e = "";
        if((int)$idfrom>25){

            $results = DB::table('stat')
                ->select('city_id', 'views')
                ->where('id', '=', $idfrom)
                ->where('city_id', '>', 0)
                ->pluck('views', 'city_id');

            $ua_e = ""; $obl_e = "";
			if($lan == "en"){$ua_e = "Ukraine"; $ppr="esp";}
			else if($lan == "ru"){$ua_e = "Украина"; $ppr="rsp";}
			else {$ua_e = "Україна"; $ppr="sp";}
			$ua_e = "<a onclick=stat('0','$purp')><b>$ua_e </b></a> ->";

            $Allb = DB::table('Allcities')
                ->select('id', 'rayc', 'ab')
                ->where('rayc', $idfrom)
                ->get();

            $mergedData = [];

            foreach ($Allb as $All) {
                $id = $All->id;
                $rayc = $All->rayc;
                $ab = $All->ab;
                $pagec = explode("#!", $ab);
                $City1 = $pagec[1];
                $City2 = $pagec[2];
                $oblc = $pagec[3];
                $City3 = $pagec[11];
                $domen = $pagec[12];
                if(isset($pagec[7])) {
                    $nrf = $pagec[7];
                } else {
                    $nrf = 0;
                }
                if(isset($pagec[8])) {
                    $nrm = $pagec[8];
                } else {
                    $nrm = 0;
                }
                if(isset($pagec[10])) {
                    $nrp = $pagec[10];
                } else {
                    $nrp = 0;
                }


                if ($nrf > 0) {
                    $statusf = "<a href=/$domen/foto/$lan/>
                        <div class=\"stats-item stats-item-view\">
                            <svg alt='" . __('messages.fotom'). " ' width=\"12\" height=\"11\" >
                                <use href=\"/images/icons-searc.svg#icon-images\"></use>
                            </svg>
                            $nrf
                        </div>
                    </a>";
                } else {
                    $statusf = "";
                }
                if ($nrm > 0) {
                    $statusm = "<a href=/$domen/$lan>
                        <div class=\"stats-item stats-item-view\">
                            <svg alt='" . __('messages.publs'). " ' width=\"12\" height=\"11\" >
                                <use href=\"/images/icons-searc.svg#icon-bubble\"></use>
                            </svg>
                            $nrm
                        </div>
                    </a>";
                } else {
                    $statusm = "";
                }
                if ($nrp > 0) {
                    $statusp = "<a href=/$ppr$id>
                        <div class=\"stats-item stats-item-view\">
                            <svg alt='" . __('messages.users'). " ' width=\"12\" height=\"11\" >
                                <use href=\"/images/icons-searc.svg#icon-bubble\"></use>
                            </svg>
                            $nrp
                        </div>
                    </a>";
                } else {
                    $statusp = "";
                }

                if($lan == "en") {
                    $City_e = $City3;
                } elseif($lan == "ru") {
                    $City_e = $City2;
                } else {
                    $City_e = $City1;
                }
                if($id == $rayc) {
                    $City_e = "<b>$City_e</b>";
                    $ray_e = "$City_e <br />";
                }
                $views = isset($results[$id]) ? $results[$id] : 0;
                $mergedData[] = [
                    'id' => $id,
                    'City_e' => $City_e,
                    'statusf' => $statusf,
                    'statusm' => $statusm,
                    'statusp' => $statusp,
                    'views' => $views,
                    'domen' => $domen
                ];
            }

            usort($mergedData, function($a, $b) {
                if ($b['views'] == $a['views']) {

                    return strcmp($a['City_e'], $b['City_e']);
                }
                return $b['views'] - $a['views'];
            });


            $fff = "";
            foreach ($mergedData as $data) {
                $views_e = $data['views'];
                $id = $data['id'];
                if ($views_e == 0) {
                    $display="display: none;";
                }
                else{$display="";}
                    $viewse = "<div id=\"genIdViews$id\" class=\"stats-item stats-item-view\" style=\"$display\">
                                <svg style=\"margin-right: -2px;\" title='" . __('messages.views') . "' alt='" . __('messages.views') . "' width=\"12\" height=\"12\"><use href=\"/images/icons.svg#icon-magnifying-glass\"></use></svg>
                                <span class=\"in-dif\" id=\"inDif$id\"></span><span id=\"idViews$id\">$views_e</span>
                            </div>";


                $fff .= "<li class=\"stat-td\"><a href=/" . $data['domen'] . "/$lan>" . $data['City_e'] . " </a> "
                    . $data['statusf'] . " " . $data['statusm'] . " " . $data['statusp'] . " " . $viewse . "</li>";
			}
			$oi = "messages.ooo$oblc"; $obl =__($oi); $obl_e = "<a onclick=stat('$oblc','$purp')><b>$obl</b></a> ->";

		}


		$All_ratef = round($All_ratef/25);
		$All_ratem = round($All_ratem/25);

		$Photos = __('messages.Foto');
		$Memorys = __('messages.records');
		if($purp=="Foto"){
            echo "
		    <table class=\"stat-tb\">
                <tr><td class=\"fcom ind-button\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                    <b>$Photos $All_ratef%</b>
                </td>
                <td class=\"fcomblue intop ind-button\">
                    <a onclick=stat('0','memory')> $Memorys $All_ratem%</a>
                </td></tr>
            </table>";
		}
		if($purp=="memory"){
            echo "
		    <table class=\"stat-tb\">
                <tr><td class=\"fcomblue intop ind-button\">
                    <a onclick=stat('0','Foto')>$Photos $All_ratef% </a>
                </td>
                <td class=\"fcom ind-button\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                    <b>$Memorys $All_ratem% </b>
                </td></tr>
            </table>";
		}
			echo "<h3>$ua_e $obl_e $ray_e</h3><ul class=\"stat-list\">$fff</ul>";

    }


    function news(Request $request)
    {

        $page = $request['page'];
        $lan = __('messages.lan');
		$pref_page = __('messages.pref_page');
        $pref_page_i = $pref_page.="i";
        $writen = __('messages.writen');
        $writen2 = __('messages.writen2');
        $Someone = __('messages.Someone');
        $added1 = __('messages.added1');
        $added2 = __('messages.added2');
        $in_album = __('messages.in_album');
        $fotom = __('messages.fotom');
        $appreciated1 = __('messages.appreciated1');
        $appreciated2 = __('messages.appreciated2');
        $skip = ((int)$page-1)*60;
		$my_domen = $_SERVER['SERVER_NAME'];

        if(isset($request['go_news'])){
            $go_news = $request['go_news'];
        }
        else if (isset($_COOKIE['go_news'])){
            $go_news = $_COOKIE['go_news'];
        }
        else {$go_news = "111100";}

        $nforum = substr($go_news, 0, 1);
        $nfoto = substr($go_news, 1, 1);
        $nratef = substr($go_news, 2, 1);
        $ncoment = substr($go_news, 3, 1);
        $lnews = substr($go_news, 4, 2);
        $q_s1[0] = ['act', 100];
        $q_s2[0] = ['act', 100];
        $q_s3[0] = ['act', 100];
        $q_s4[0] = ['act', 100];
        $q_s_mainp[0] = ['main_page', "!=", '3'];
        $q_s_mainp2[0] = ['main_page', "!=", '2'];
        $my_id = "";
        if(Auth::user()) {
            $my_id =  Auth::user()->id;
            $q_s34[0] = ['whom', 'like', $my_id];
            $q_s_mainp2[0] = ['main_page', "!=", '3'];
        }
        else{
            $q_s34[0] = ['whom', '>', 0];
        }
        $q_s5[0] = ['act', 100];
        $q_s6[0] = ['act', 100];
        $q_s7[0] = ['act', 100];
        if($nforum!="0"){$q_s1[0] = ['act', 'nforum'];}
        if($nfoto!="0"){$q_s2[0] = ['act', 'nfoto'];}
        if($nratef!="0"){$q_s3[0] = ['act', 'nratef']; $q_s4[0] = ['act', 'nratem']; }
        if($ncoment!="0"){$q_s5[0] = ['act', 'ncoment']; $q_s6[0] = ['act', 'ncomentm']; }
        if(Auth::user()) {
        }
        else{
            $q_s3[0] = ['act', 100];
            $q_s4[0] = ['act', 100];
        }
        if($lnews!="00"){
            $lnews_obl = (int)$lnews;
            $q_s7[0] = ['act', (string)$lnews_obl];
        }

        $Alln = DB::table('News')->select('act','obl','avt','Im','Priz','sex','theme','ualine','ruline','enline',
            'Nd','whom','forum','avt_fr')->
        orWhere(function ($query) use ($q_s1, $q_s2, $q_s3, $q_s4, $q_s34, $q_s5, $q_s6, $q_s7) {
            $query->whereNull('act')
                ->orWhere($q_s1)
                ->orWhere($q_s2)
                ->orWhere(function ($query) use ($q_s3,$q_s34){$query->Where($q_s3)->Where($q_s34);})
                ->orWhere(function ($query) use ($q_s4,$q_s34){$query->Where($q_s4)->Where($q_s34);})
                ->orWhere($q_s5)
                ->orWhere($q_s6)
                ->orWhere($q_s7);
        })
        ->Where($q_s_mainp)
        ->Where($q_s_mainp2)->
        orderBy('Nd', 'desc')->
        skip($skip)->take(61)->
        get();
        $Allnn = $Alln->count();
        $afmtable="shut";
        $fotable = "shut";
        $afotable="shut";
        $fortable = "shut";
        $afortable = "shut";
        $acttable="shut";

        if($Allnn>0) {

            $nfm = 1; $Nd_f_h=""; $act_old = ""; $titleh="";

            $linef="go"; $nforum_e3 = ""; $nfoto_e3 = ""; $nratef_e3 = ""; $ncoment_e3="";

            foreach ($Alln as $Alb) {
                if ($nfm < 61) {

                    $theme = $Alb->theme; $ualine = $Alb->ualine; $ruline = $Alb->ruline; $enline = $Alb->enline;
                    $act = $Alb->act; $obl = $Alb->obl; $avt = $Alb->avt; $Im = $Alb->Im; $Priz = $Alb->Priz; $sex = $Alb->sex;
                    $Nd = $Alb->Nd; $whom = $Alb->whom; $forum = $Alb->forum; $avt_fr = $Alb->avt_fr;

                    if($lan=="en" && mb_strlen($enline)>1){$ualine = $enline;}
                    else if($lan=="ru" && mb_strlen($ruline)>1){$ualine = $ruline;}
                    if($act>0 && $act<26){} else{
                        $ualine = str_replace("<br />"," ", $ualine);
                        $ualine = str_replace(" </a>","</a>", $ualine);
                    }

                    $monm = substr($Nd, 5, 2);
                    if($monm == "1") {$monm = "січня"; $monmr = "января"; $monme = "January"; } if($monm == "2") {$monm = "лютого";   $monmr = "февраля";$monme = "February";} if($monm == "3") {$monm = "березня";$monmr = "марта";$monme = "March";}
                    if($monm == "4") {$monm = "квітня";$monmr = "апреля";$monme = "April";}     if($monm == "5") {$monm = "травня";   $monmr = "мая";    $monme = "May";     } if($monm == "6") {$monm = "червня"; $monmr = "июня"; $monme = "June"; }
                    if($monm == "7") {$monm = "липня"; $monmr = "июля"; $monme = "July"; }      if($monm == "8") {$monm = "серпня";   $monmr = "августа";$monme = "August";  } if($monm == "9") {$monm = "вересня";$monmr = "сентября";$monme = "September";}
                    if($monm == "10"){$monm = "жовтня";$monmr = "октября";$monme = "October";}  if($monm == "11"){$monm = "листопада";$monmr = "ноября"; $monme = "November";} if($monm == "12"){$monm = "грудня"; $monmr = "декабря"; $monme = "December"; }

                    if($lan=="en"){$monm_lv=$monme;}
                    else if($lan=="ru"){$monm_lv=$monmr;}
                    else{$monm_lv=$monm;}
                    $daym_lv = substr($Nd, 8, 2); if(substr($daym_lv, 0, 1)==0){$daym_lv = substr($daym_lv, 1, 1);}

                    $Nd_is = date('Y-m-d');
                    $Nd_past1 = date('Y-m-d', strtotime('-1 days'));
                    $Nd_past2 = date('Y-m-d', strtotime('-2 days'));
                    $Nd_f = substr($Nd, 0, 10);
                    $hourm_lv = substr($Nd, 11, 2); $min_lv = substr($Nd, 14, 2);
                    if(substr($hourm_lv, 0, 1)==0){$hourm_lv = substr($Nd, 12, 1);}

                    if($Nd_f==$Nd_is){$title="Сьогодні"; $titler="Сегодня"; $titlee="Today";
                        if($lan=="en"){$title=$titlee;}
                        else if($lan=="ru"){$title=$titler;}
                    }
                    else if($Nd_f==$Nd_past1){$title="Вчора"; $titler="Вчера"; $titlee="Yestarday";
                        if($lan=="en"){$title=$titlee;}
                        else if($lan=="ru"){$title=$titler;}
                    }
                    else if($Nd_f==$Nd_past2){$title="Позавчора"; $titler="Позавчера"; $titlee="Day before yesterday";
                        if($lan=="en"){$title=$titlee;}
                        else if($lan=="ru"){$title=$titler;}
                    }
                    else{$title="$daym_lv $monm_lv ";}

                    $time="$hourm_lv:$min_lv";
                    if($titleh!=$title||$act_old!=$act) {


                        if($afmtable=="open"){echo"</td></tr></table>"; $afmtable="shut";}
                        if($fotable=="open"){echo"</tr>"; $fotable="shut"; $nrowf=1;}
                        if($afotable=="open"){echo"</table>"; $afotable="shut"; $nrowf=1;}
                        if($fortable=="open"){echo"</tr>"; $fortable="shut";}
                        if($afortable=="open"){echo"</table>"; $afortable="shut"; $nrowfr=1;}
                        if($acttable=="open"){echo"</td></tr></table>"; $acttable="shut";}
                        /*
                        if($actvtable=="open"){echo"</td></tr></table></div>"; $actvtable="shut";}
                        */
                        if($nfm==1 || $Nd_f_h!=$Nd_f){echo"<br /><h3>$title</h3>";}
                        $linef="go";
                    }



                    if($act=="nratef"){

                        if($sex=="1"){$nratef_e1=$appreciated1;}
                        else if($sex=="2"){$nratef_e1=$appreciated2;}
                        else{$nratef_e1="";}

                        $nratef_e2 = "$avt";

                        if($nratef_e2!=$nratef_e3 || $titleh!=$title){
                            if($fortable=="open"){echo"</tr>"; $fortable="shut";}
                            if($afortable=="open"){echo"</table>"; $afortable="shut";}

                            $time_e=$time;	$nrowfr=1;
                            echo"<table class=\"fcom0 margin-top\"><tr><td align=left width=392>
                                        <div class=\"min-padding\">
                                            <b><a href=/$pref_page_i$avt>$Im $Priz</a></b> $nratef_e1
                                        </div>
                                    </td>
                                    <td width=40 align=right valign=top><div class=\"min-padding\">$time_e </div></td></tr></table>";
                            echo"<table>"; $afortable="open";

                        }

                        $nratef_e3 = "$avt";
                        if($theme>0.5){$star1="on";}else{$star1="off";}
                        if($theme>1.5){$star2="on";}else{$star2="off";}
                        if($theme>2.5){$star3="on";}else{$star3="off";}
                        if($theme>3.5){$star4="on";}else{$star4="off";}
                        if($theme>4.5){$star5="on";}else{$star5="off";}

                        if($nrowfr==1){echo"<tr>"; $fortable="open";}
                        echo"<td class=\"fcom\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" valign=center><div class=\"min-photo\">
                                    <img src=$star1.png><img src=$star2.png><img src=$star3.png><img src=$star4.png><img src=$star5.png><br />$ualine</div></td>";
                        $nrowfr++;

                        if($nrowfr==5){$nrowfr=1; echo"</tr>"; $fortable="shut";}

                    }




                    if($act=="ncoment"){

                        $Num_a=7; $e1="";
                        if(mb_strlen($sex)==9){$Num_a=substr($sex, 1, 8); $sex2=substr($sex, 0, 1);
                            if($sex2=="1"||$avt==0){$e1="$writen:";}
                            else if($sex2=="2"){$e1="$writen2:";}
                            else{$e1="";}
                        }
                        if(mb_strlen($sex)==8){$Num_a=substr($sex, 0, 8);}

                        $ncoment_e2 = "$theme";

                        if($ncoment_e2!=$ncoment_e3){$linec="go";
                            if($acttable=="open"){echo"</td></tr></table>"; $acttable="shut";}
                        }

                        if($linec=="go"){

                            $ncoment_e="
                                         <table class=\"fcom0 margin-top\"><tr valign=top>
                                            <td><div class=\"com-photo\">$ualine </div></td>
                                            <td width=322 align=left class=\"com-photo-pad\">";

                            $acttable="open"; $linec="stop";
                        }
                        else{$ncoment_e="";}
                        $ncoment_e3 = "$theme";

                        $filename = "storage/last_visit/$avt.txt";
                        $av_height="auto";
                        $av_width=200;
                        if (file_exists($filename)) {
                            $whattoread = @fopen($filename, "r");
                            $file_contents = fread($whattoread, filesize($filename)); fclose($whattoread);
                            $pagea = explode("#!:*&", $file_contents);
                            $av_height = isset($pagea[6]) ? $pagea[6] : null;
                            $av_width = isset($pagea[7]) ? $pagea[7] : null;
                        }
                        $time_file = filemtime($filename);
                        $time_sec=time();
                        $online = "";
                        $t = $time_sec - $time_file;
                        if ($t <= 500 && $my_id != $avt) {
                            $online = "online";
                        }
                        $user_icon = generateUserIcon($Num_a, $Im, $Priz, "forum", $av_width, $av_height, $online);

                        echo"$ncoment_e

									<article class=\"comblock\">
									<div class=\"time\">$time</div>
										<a href=/$pref_page_i$avt>$user_icon</a>
										<a href=/$pref_page_i$avt><b>$Im $Priz</b></a> $e1<br />
										<div class=\"forum-content\">$forum <br /><br /></div>
									</article>";
                    }




                    if($act=="ncomentm"){

                        $Num_a=7; $e1="";
                        if(mb_strlen($sex)==9){$Num_a=substr($sex, 1, 8); $sex2=substr($sex, 0, 1);
                            if($sex2=="1"||$avt==0){$e1="$writen:";}
                            else if($sex2=="2"){$e1="$writen2:";}
                            else{$e1="";}
                        }
                        if(mb_strlen($sex)==8){$Num_a=substr($sex, 0, 8);}

                        $ua_e="<a href=\"";
                        $tof = strtok($theme,"#&~");
                        $tf=1;
                        $ttheme = ""; $tpage = "";  $tnpage = "";
                        $name1=""; $name2=""; $name3="";
                        while($tof) {
                            if($tf==1){$tpage=$tof;}
                            if($tf==2){$tnpage=$tof;}
                            if($tf==3){$name1=$tof;}
                            if($tf==4){$name2=$tof;}
                            if($tf==5){$name3=$tof;}
                            if($tf==6){$ttheme=$tof;}
                            $tof = strtok("#&~");
                            $tf++;
                        }
                        $nname="";
                        if($lan=="en"){$ua_e.="e";}
                        else if($lan=="ru"){$ua_e.="r";}
                        if($tpage=="c"){
                            $ua_e.="rec$tnpage";
                            $nname = $name1;
                            if($lan=="en"){$nname = $name3;}
                            if($lan=="ru"){$nname = $name2;}
                        }
                        else{
                            $ua_e.="recp$tnpage";
                            $nname = "$name1 $name2";
                        }
                        $ua_e.="\">";
                        $ua_e.="$nname $ttheme</a>";
                        $ualine = str_ireplace("</font>", "</font><br />", $ualine);

                        echo"<table  class=\"margin-top\"><tr valign=top>
                                        <td align=right class=\"fcom0\">
                                            <div class=\"com-mem-city\">$ua_e </div>
                                        </td><td class=\"fcom0 padd5 com-mem-block\" width=330 align=left>
                                            <div class=\"time-mem\">$time</div>
                                            <div class=\"forum-com-content\">$ualine  $forum</div>
                                    </td></tr></table>";

                    }



                    if($act=="nfoto"){

                        if($sex=="1"){$nfoto_e1=$added1;}
                        else if($sex=="2"){$nfoto_e1=$added2;}
                        else{$nfoto_e1="-";}
                        $themef=$theme;

                        if(mb_strlen($themef)>12){
                            $theme_e="<a href=\"";
                            $tokf = strtok($themef,"#&~");
                            $tn=1;
                            $theme_alt="";
                            while($tokf) {
                                if($tn==1){
                                    if($tokf=="fotop"){$ide="fi";}
                                    else{$ide="fc";}
                                }
                                if($tn==2){
                                    if((int)$tokf>0){
                                        $domengo="stop";
                                        $theme_e.="/$ide$tokf";
                                    }
                                    else{
                                        $domengo="go";
                                        $theme_e.="/$tokf/foto/$lan/";
                                    }
                                }
                                if($tn==3){
                                    if($obl>0){
                                        $ni = "messages.ooo$obl";
                                        $fno_e=__($ni); $fno_e=" ($fno_e)";
                                    }
                                    else{$fno_e="";}
                                    if($domengo=="go"){
                                        $tokf = str_ireplace(" з panoramio.com", "", $tokf);
                                        $theme_e.="$tokf";
                                    }
                                    $theme_e.="\"> $in_album <b>$tokf$fno_e</b></a>";
                                    $theme_alt=$tokf;
                                }
                                $tokf = strtok("#&~");
                                $tn++;
                            }
                        }
                        else{$theme_e="";}


                        $nfoto_e2 = "$avt$theme";

                        if($nfoto_e2!=$nfoto_e3 || $titleh!=$title ||$act_old!=$act){
                            if($fotable=="open"){echo"</tr>"; $fotable="shut";}
                            if($afotable=="open"){echo"</table>"; $afotable="shut";}
                            $time_e=$time;	$nrowf=1;

                            echo"<table class=\"fcom0 margin-top\"><tr><td align=left width=430 class=\"padd05 td-rel\">
												<div class=\"time padd5\">$time_e</div>
                                                <h3 class=\"news-photo\"><b><a href=/$pref_page_i$avt>$Im $Priz</a></b> $nfoto_e1 $fotom$theme_e</h3>
                                        </td></tr></table>
                                        <table>";
                            $afotable="open";
                        }

                        $nfoto_e3 = "$avt$theme";

                        if($nrowf==1){echo"<tr>"; $fotable="open";}
                        echo"<td align=center class=\"fcom\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                                            <div class=\"height70\">$ualine</div>
                                     </td>";
                        $nrowf++;

                        if($nrowf==5){
                            $nrowf=1; echo"</tr>";
                            $fotable="shut";
                        }

                    }



                    if($act=="nratem"){

                        if($sex=="1"){$nratef_e1=$appreciated1;}
                        else if($sex=="2"){$nratef_e1=$appreciated2;}
                        else{$nratef_e1="";}

                        $ua_e="<a href=\"";
                        $tof = strtok($theme,"#&~");
                        $tf=1; $ttheme = ""; $tpage = "";  $tnpage = "";
                        while($tof) {
                            if($tf==1){$mark=$tof;}
                            if($tf==2){$tpage=$tof;}
                            if($tf==3){$tnpage=$tof;}
                            if($tf==4){$ttheme=$tof;}
                            $tof = strtok("#&~");
                            $tf++;
                        }

                        if($lan=="en"){$ua_e.="e";}
                        else if($lan=="ru"){$ua_e.="r";}
                        if($tpage=="c"){$ua_e.="c$tnpage";}
                        else{$ua_e.="i$tnpage";}
                        $ua_e.="\">";

                        if($tnpage<1000000){
                            $City="";
                            $Allc = DB::table('Allcities')->select('City','City2','City3')->
                            where('id', $tnpage)->limit(1)->get();
                            foreach ($Allc as $All) {
                                $City = $All->City; $City2 = $All->City2; $City3 = $All->City3;
                            }
                            $Citydrn = $City;
                            if($lan=="en"){$Citydrn = $City3;}
                            if($lan=="ru"){$Citydrn = $City2;}
                            $ua_e.="$Citydrn $ttheme</a>";
                        }
                        else{
                            $Imn=""; $Prizn="";
                            $Allc = DB::table('users')->select('Im','Priz')->
                            where('id', $tnpage)->limit(1)->get();
                            foreach ($Allc as $All) {
                                $Imn = $All->Im; $Prizn = $All->Priz;
                            }
                            $ua_e.="$Imn $Prizn $ttheme</a>";
                        }

                        if($mark>0.5){$star1="on";}else{$star1="off";}
                        if($mark>1.5){$star2="on";}else{$star2="off";}
                        if($mark>2.5){$star3="on";}else{$star3="off";}
                        if($mark>3.5){$star4="on";}else{$star4="off";}
                        if($mark>4.5){$star5="on";}else{$star5="off";}

                        echo"<table class=\"fcom0 margin-top\"><tr><td align=left class=\"padd05 td-rel\">
                                        <div class=\"time padd5\">$time </div>
                                        <h3 class=\"news-photo\"><b><a href=/$pref_page_i$avt>$Im $Priz</a></b> $nratef_e1</h3>
                                            <table>
                                            <tr valign=top><td align=right width=110>
                                                <div class=\"com-photo\">
                                                <img src=/$star1.png><img src=/$star2.png><img src=/$star3.png><img src=/$star4.png><img src=/$star5.png>
                                                <br /> $ua_e</div>
                                            </td><td align=right>
                                                <table><tr valign=top><td><div class=\"com-photo-pad com-est-block\">$ualine</div></td></tr></table>
                                            </td></tr></table>
                                        </td></tr></table>";


                    }




                    if($act=="nforum"){

                        $Num_a=7; $e1="";
                        $sex2=substr($sex, 0, 1);
                        if($sex2=="1"){$e1="$writen: <br />";}
                        if($sex2=="2"){$e1="$writen2: <br />";}
                        if(mb_strlen($sex)==9){$Num_a=substr($sex, 1, 8);}
                        if(mb_strlen($sex)==8){$Num_a=substr($sex, 0, 8);}

                        $nforum_e2 = "$theme";

                        if($nforum_e2!=$nforum_e3){$linef="go";
                            if($afmtable=="open"){echo"</td></tr></table>"; $afmtable="shut";}

                        }

                        if($linef=="go"){

                            $ua_e="<a href=\"";
                            $tof = strtok($theme,"#&~");
                            $tf=1; $ttheme = ""; $tpage = "";  $tnpage = "";
                            while($tof) {
                                if($tf==1){$tpage=$tof;}
                                if($tf==2){$tnpage=$tof;}
                                if($tf==3){$ttheme=$tof;}
                                $tof = strtok("#&~");
                                $tf++;
                            }
                            if((int)($tnpage)>0){
                                if($lan=="en"){$ua_e.="e";}
                                else if($lan=="ru"){$ua_e.="r";}
                                if($tpage=="c"){$ua_e.="c$tnpage";}
                                else{$ua_e.="i$tnpage";}
                            }
                            else{
                                $ua_e.="/$tnpage/forum/$lan/0/";
                                if(mb_strlen($ttheme)>0){$ua_e.="$ttheme";}
                                else{$ua_e.="0";}
                            }

                            $ua_e.="\">";

                            $ualine = str_replace("<a>","$ua_e","$ualine");
                            if($obl>0){
                                $oi = "messages.ooo$obl"; $obl_e =__($oi); $obl_e = " $obl_e";
                            }
                            else{
                                $obl_e = "";
                            }

                            $nforum_e="<table class=\"margin-top\"><tr valign=top>
                                        <td align=right width=110 class=\"fcom0\">
                                            <h3 class=\"nforum-h3\"><b>$ualine</b>$obl_e</h3>";
                            $nforum_eee="</td><td align=left width=318 class=\"fcom0 td-rel forum-news\">";

                            $afmtable="open"; $linef="stop";
                        }
                        else{$nforum_e=""; $nforum_eee="<br />"; $avt=0; $e1=""; }
                        $nforum_e3 = "$theme";

                        $av_avt = "";
                        $av_height="auto";
                        $av_width=200;
                        if($avt>7){
                            $filename = "storage/last_visit/$avt.txt";

                            if (file_exists($filename)) {
                                $whattoread = @fopen($filename, "r");
                                $file_contents = fread($whattoread, filesize($filename)); fclose($whattoread);
                                $pagea = explode("#!:*&", $file_contents);
                                $av_height = isset($pagea[6]) ? $pagea[6] : null;
                                $av_width = isset($pagea[7]) ? $pagea[7] : null;
                                if(!$av_height){$av_height="auto";}
                            }
                            $time_file = filemtime($filename);
                            $time_sec=time();
                            $online = "";
                            $t = $time_sec - $time_file;
                            if ($t <= 500 && $my_id != $avt) {
                                $online = "online";
                            }
                            $user_icon = generateUserIcon($Num_a, $Im, $Priz, "forum", $av_width, $av_height, $online);
                            $av_avt = "<a href=/$pref_page_i$avt>$user_icon <b>$Im $Priz</b></a>";
                        }

                        $avtall = mb_strstr($forum,"*&^@");
                        list($avt_old) = sscanf($avtall, "*&^@%d");

                        if($avt_old>0){
                            $filename = "storage/last_visit/$avt_old.txt";
                            $whattoread = @fopen($filename, "r");
                            $file_contents = fread($whattoread, filesize($filename)); fclose($whattoread);
                            $pageq = explode("#!:*&", $file_contents);

                            $Imq=$pageq[1]; $Prizq=$pageq[2]; $Num_aq=$pageq[3];

                            $av_height = isset($pageq[6]) ? $pageq[6] : "auto";
                            $av_width = isset($pageq[7]) ? $pageq[7] : 200;

                            $time_file = filemtime($filename);
                            $time_sec=time();
                            $online = "";
                            $t = $time_sec - $time_file;
                            if ($t <= 500 && $my_id != $avt) {
                                $online = "online";
                            }
                            $user_icon = generateUserIcon($Num_aq, $Imq, $Prizq, "forum", $av_width, $av_height, $online);

                            $forum=str_replace("*&^@$avt_old",
                                "<a href=/$pref_page_i$avt_old> $user_icon $Imq $Prizq</a><br />", $forum);
                        }
                        else{$forum=str_replace("*&^@", "", $forum);}

                        $quest = __('messages.quest');
                        $answ5 = __('messages.answ5');
                        $forum=str_replace("%^&@#", "$quest: <br />", $forum);
                        $forum=str_replace("&@#%^", "$answ5: <br />", $forum);

                        echo"$nforum_e $nforum_eee
                                    <div class=\"time-mem\">$time </div>
                                    $av_avt $e1 <div class=\"forum-com-content\">$forum</div> ";

                    }


                    if((int)$act>0 && (int)$act<26){
                        echo"$ualine";
                    }

                    $Nd_f_h=$Nd_f; $act_old = $act; $titleh = $title;
                }
                $nfm++;
            }

        }
        else{
            $no_news = __('messages.no_news');
            echo"<table class=\"no_news\"><tr><td class=fcom0 align=center valign=top width=\"445\">
                                <br /><b>$no_news</b><br /><br />
                            </td></tr></table>";
        }
        if($afmtable=="open"){echo"</td></tr></table>"; $afmtable="shut";}
        if($fotable=="open"){echo"</tr>"; $fotable="shut";}
        if($afotable=="open"){echo"</table>"; $afotable="shut";}
        if($fortable=="open"){echo"</tr>"; $fortable="shut";}
        if($afortable=="open"){echo"</table>"; $afortable="shut";}
        if($acttable=="open"){echo"</td></tr></table>"; $acttable="shut";}

        if($nfm==62){
            $next_e = __('messages.nnext');
            $page = $page+1;
            $next_div = "next_div$page";
            echo"<div id=$next_div><br /><table class=fcom><tr>
                    <td align=center width=442 onMouseOver=news('$page')>
                        <a href=## onclick=news('$page')><h3 class=\"font18\">$next_e </h3> </a>
                    </td></tr></table></div>";
        }


    }



    public function top_ask(Request $request)
    {
        $id = $request['id'];
        $na = $request['na'];
        $from_history = $request['from_history'];
        $answ = __('messages.answ');
        $skip = __('messages.skip');
        $qenter = __('messages.qenter');
        $lan = __('messages.lan');
        $q_a = "qua";
        if($lan=="ru"){$q_a = "qru";}
        if($lan=="en"){$q_a = "qen";}

        $allq = ""; $qw = "";

        $Alli = DB::table('Allcities')->select('ab')->
        where('id', $id)->limit(1)->get();
        foreach ($Alli as $All) {
            $ab = $All->ab;
        }
        $pagec = explode("#!", $ab);
        $City=$pagec[1]; $City2=$pagec[2]; $City11=$pagec[11]; $status=$pagec[5]; $vol_karta=$pagec[6];
        $lan = __('messages.lan');

        if ($status){
            if ($status==1){$statusm="місті";}
            if ($status==2){$statusm="смт";}
            if ($status==3){$statusm="селищі";}
            if ($status==4){$statusm="селі";}
            if ($status==5){$statusm="хуторі";}
        }
        else{
            if (!$vol_karta||$vol_karta<20000){ $statusm="селі";}
            if ($vol_karta>=20000&&$vol_karta<50000){$statusm="місті (селі)";}
            if ($vol_karta>=50000){ $statusm="місті";}
        }
        $in_ad = " в $statusm $City";
        if($lan=="ru"){

            if ($status){
                if ($status==1){$statusne="городе";}
                if ($status==2){$statusne="пгт"; }
                if ($status==3){$statusne="поселке";}
                if ($status==4){$statusne="селе";}
                if ($status==5){$statusne="хуторе";}
            }
            else{
                if (!$vol_karta||$vol_karta<20000){$statusne="селе";}
                if ($vol_karta>=20000&&$vol_karta<50000){$statusne="городе (селе)";}
                if ($vol_karta>=50000){$statusne="городе";}
            }
            $in_ad = " в $statusne $City2";
        }
        if($lan=="en"){
            $in_ad = " in $City11";
        }
        $Allc = DB::table('questions')->select('idq',$q_a)->
        inRandomOrder()->
        get();
        $q_count = $Allc->count();
        $n_count=0;
        foreach ($Allc as $All) {
            $idq = $All->idq;  $q_aa = $All->$q_a;
            if(mb_strstr((string)$from_history, "&$idq")=="") {
                $qw = $q_aa;
                $from_history.="&$idq"; $na=$idq; break;
            }
            $n_count++;
        }
        $d_e = rand(0,1);
        if($d_e>0){$qw.="$in_ad?";}
        else {$qw.="?";}
        if($n_count == $q_count){
            $qw =  __('messages.q_end');
        }
        echo"<table><tr><td valign='top'>
                <div style='margin: 5px 5px 5px 5px;'>
                    <div style=\"float:left\">
                        <div style=\"margin: 0px 7px 5px 0px; \">
                            <img width=50 border=0 SRC=/images/mast.png>
                        </div>
                    </div> $qw
                </div>
            </td></tr></table>";
            if($n_count != $q_count) {
                echo "
                <table><tr><td>
                <textarea id=\"from_ask\" rows=2 style=\"width: 95%;\" placeholder = \"$qenter\"
                 onFocus=clearss('from_ask');></textarea>
                    <table><tr><td width=220 align=center>
                        <table><tr><td class=fcomblue width=90 valign=center><ul class=intop><li>
                            <a onclick=answer_interview($id,$na)>$answ</a></li></ul>
                        </td>
                        <td class=fcomblue width=90 valign=center><ul class=intop><li>
                            <a onclick=top_ask($id,$na)>$skip</a></li></ul>
                        </td>
                        </tr></table>
                        <input type=\"hidden\" id=\"from_history\" value=\"$from_history\">
                    </td></tr></table>
                </td></tr></table>";
            }
    }





    public function answer_interview(Request $request)
    {
        $id = $request['id'];
        $na = $request['na'];
        $id = $id + 1; $id = $id - 1;
        if (is_int($id) != "true") {die("");}
        $na=$na+1; $na=$na-1;
        if(is_int($na)!="true"){die("");}
        $lan = __('messages.lan');
        $Aboutef = $request['Aboutef'];
		$ctrl_hss= mb_strtolower($Aboutef);
		if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
		$ctrl_hss2=$ctrl_hss.=">";
		if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}

        $Aboutef = getDescriptionAttribute($Aboutef);
        $Aboutef = nl2br($Aboutef);
        $Aboute = $Aboutef;
        $Aboutef = mb_strtolower($Aboutef);
        $abuse_ban = __('messages.abuse_ban');

        $my_id = ""; $my_id2 = "5";
        if(Auth::user()) {
            $my_id = Auth::user()->id; $my_id2 = $my_id;
        }

        if (!$Aboutef) {
            $ask_err = __('messages.comm_err');
            echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
        }
        else if (mb_strlen($Aboutef) > 500) {
            $ask_err = __('messages.ask_err2');
            echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
        }

        else if (mb_strstr((string)$Aboutef,"хуй")!=""||mb_strstr((string)$Aboutef,"пизд")!=""||mb_strstr((string)$Aboutef," конч")!=""||mb_strstr((string)$Aboutef,"вафл")!=""||mb_strstr((string)$Aboutef,"шлюх")!=""||mb_strstr((string)$Aboutef,"fuck")!=""||mb_strstr((string)$Aboutef," гом")!=""||mb_strstr((string)$Aboutef," бля")!=""||mb_strstr((string)$Aboutef," манд")!=""||mb_strstr((string)$Aboutef,"член")!=""||mb_strstr((string)$Aboutef," еба")!=""||mb_strstr((string)$Aboutef," єба")!=""||mb_strstr((string)$Aboutef,"суч")!=""||mb_strstr((string)$Aboutef,"сук")!=""||mb_strstr((string)$Aboutef,"дроч")!=""||mb_strstr((string)$Aboutef," писк")!=""||mb_strstr((string)$Aboutef," піськ")!=""||mb_strstr((string)$Aboutef,"урод")!=""||mb_strstr((string)$Aboutef,"ублюд")!=""||mb_strstr((string)$Aboutef,"соса")!=""||mb_strstr((string)$Aboutef,"соси")!=""||mb_strstr((string)$Aboutef,"сран")!=""||mb_strstr((string)$Aboutef,"срак")!=""||mb_strstr((string)$Aboutef,"срат")!=""||mb_strstr((string)$Aboutef,"хуев")!=""||mb_strstr((string)$Aboutef,"костр")!=""||mb_strstr((string)$Aboutef,"блев")!=""||mb_strstr((string)$Aboutef,"яйц")!=""||mb_strstr((string)$Aboutef," трах")!=""||mb_strstr((string)$Aboutef,"влагал")!=""||mb_strstr((string)$Aboutef," онан")!=""){

            $bad_words="<font color=red>";
            if (mb_strstr((string)$Aboutef,"хуй")!=""){$bad_words.=" хуй";}
            if (mb_strstr((string)$Aboutef,"пизд")!=""){$bad_words.=" пизд";}
            if (mb_strstr((string)$Aboutef,"сперм")!=""){$bad_words.=" сперм";}
            if (mb_strstr((string)$Aboutef,"шлюх")!=""){$bad_words.=" шлюх";}
            if (mb_strstr((string)$Aboutef,"гом")!=""){$bad_words.=" гом";}
            if (mb_strstr((string)$Aboutef,"бля")!=""){$bad_words.=" бля";}
            if (mb_strstr((string)$Aboutef,"еба")!=""){$bad_words.=" еба";}
            if (mb_strstr((string)$Aboutef,"єба")!=""){$bad_words.=" єба";}
            if (mb_strstr((string)$Aboutef,"сук")!=""){$bad_words.=" сукa";}
            if (mb_strstr((string)$Aboutef,"дроч")!=""){$bad_words.=" дроч";}
            if (mb_strstr((string)$Aboutef,"піськ")!=""){$bad_words.=" піськ";}
            if (mb_strstr((string)$Aboutef,"ублюд")!=""){$bad_words.=" ублюд";}
            if (mb_strstr((string)$Aboutef,"сран")!=""){$bad_words.=" сран";}
            if (mb_strstr((string)$Aboutef,"срак")!=""){$bad_words.=" срак";}
            if (mb_strstr((string)$Aboutef,"срат")!=""){$bad_words.=" срат";}
            if (mb_strstr((string)$Aboutef,"хуев")!=""){$bad_words.=" хуев";}
            if (mb_strstr((string)$Aboutef,"трах")!=""){$bad_words.=" трах";}
            if (mb_strstr((string)$Aboutef,"онан")!=""){$bad_words.=" онан";}
            if (mb_strstr((string)$Aboutef,"хуя")!=""){$bad_words.=" хуя";}
            $bad_words.="</font>";

            echo"s235*64@75<table><tr><td align=center><p style=\"margin: 8px 0px 8px 0px; \">$abuse_ban: $bad_words</p></td></tr></table>";
        }
        else {

            $sq=0;
            $ip = $_SERVER['REMOTE_ADDR'];
            $Allq = DB::table('Privatec')->select('set_q','ipban','ComForBan')->
            where('id', $id)->limit(1)->get();
            foreach ($Allq as $Alq) { $set_q=$Alq->set_q; $ipban=$Alq->ipban; $ComForBan=$Alq->ComForBan; $sq++; }
            if($sq==0){$set_q=""; $ipban = ""; $ComForBan = "";}
            $go_q="stop";
            if($set_q=="a" || (!$set_q)){$go_q="go";}
            if($set_q=="b" && Auth::user()){$go_q="go";}
            if($set_q=="c"){$go_q="stop";}
            if(mb_strstr((string)$ipban, (string)$ip)!=""){$go_q="stop";}
            if(Auth::user()) {
                $my_id2 = Auth::user()->id;
                if(mb_strstr((string)$ComForBan, (string)$my_id2)!=""){$go_q="stop";}
            }
            if($go_q=="go"){



                $q_a = "qua";
                if($lan=="ru"){$q_a = "qru";}
                if($lan=="en"){$q_a = "qen";}

                $Allc = DB::table('questions')->select('idq',$q_a)->
                where('idq', $na)->limit(1)->
                get();
                foreach ($Allc as $All) {
                    $q_aa = $All->$q_a;
                }
                $Aboute = strtr($Aboute, "\"", "'");
                $q_aa = strtr($q_aa, "\"", "'");
                $Md = date('Y-n-j-H-i-s');
                $Aboutep="*&^@ <b>%^&@#</b> - $q_aa?<br /><b>&@#%^</b>
                - $Aboute";


                $Allc = DB::table('Allcities')->select('ab', 'map_w', 'map_h')->
                where('id', $id)->limit(1)->get();
                $nc = 0;
                foreach ($Allc as $All) {
                    $ab = $All->ab;
                    $map_w = $All->map_w; $map_h = $All->map_h;
                    $nc++;
                }

                $pagec = explode("#!", $ab);
                $status = $pagec[5];
                $vol_karta = $pagec[6];
                $City = $pagec[1];
                $City2 = $pagec[2];
                $obl = $pagec[3];
                $City11 = $pagec[11];
                $domen = $pagec[12];

                if ($status) {
                    if ($status == 1) {
                        $statusr = "міста";
                        $statusm = "місті";
                    }
                    if ($status == 2) {
                        $statusr = "смт";
                        $statusm = "смт";
                    }
                    if ($status == 3) {
                        $statusr = "селища";
                        $statusm = "селищі";
                    }
                    if ($status == 4) {
                        $statusr = "села";
                        $statusm = "селі";
                    }
                    if ($status == 5) {
                        $statusr = "хутора";
                        $statusm = "хуторі";
                    }
                } else {
                    if (!$vol_karta || $vol_karta < 20000) {
                        $statusr = "села";
                        $statusm = "селі";
                    }
                    if ($vol_karta >= 20000 && $vol_karta < 50000) {
                        $statusr = "міста (села)";
                        $statusm = "місті (селі)";
                    }
                    if ($vol_karta >= 50000) {
                        $statusr = "міста";
                        $statusm = "місті";
                    }
                }

                $aff = DB::table('Memory')->insert(['id' => $id, 'obl' => $obl, 'Aboutec' => $Aboutep, 'avt' => $my_id,
                    'Md' => $Md, 'Ip' => $ip]);

                if ($aff) {

                    if(Auth::user()) {
                        $show_news = Auth::user()->show_news;
                        if (!$show_news) {
                            $nforum = 1;
                        } else {
                            $nforum = substr($show_news, 1, 1);
                        }
                    }
                    else{$nforum = 1;}
                    if ($nforum != 0) {

                        $Allw = DB::table('Memory')->select('news', 'avt')->
                        where('id', $id)->get();
                        $allusersn = " $my_id2";
                        foreach ($Allw as $Alw) {
                            $news = $Alw->news;
                            $whom = $Alw->avt;
                            if($whom){
                                if (mb_strstr((string)$allusersn, (string)$whom) == "" && $news != 1) {
                                    $allusersn .= " $whom ";
                                }
                            }
                        }
                        $flink1 = "/storage/karta/$obl/$id.jpg";
                        $flink0 = "/storage/karta/$obl/face_$id.jpg";
                        $file1 = public_path($flink1);
                        $file0 = public_path($flink0);
                        $map_w = $map_w/2.0212766;
                        $map_h = $map_h/2.0212766;
                        $src_ua = "";
                        $src_ru = "";
                        $src_en = "";
                        if(file_exists($file0)){
                            $src_ua = "<br /><a href='/c$id' class=\"scale\">
                                         <img  width=$map_w height=$map_h alt=\"Топографічна карта - $City\" title=\"Топографічна карта - $City\" src=\"$flink0\">
                                       </a>";
                            $src_ru = "<br /><a href='/rc$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Топографическая карта - $City2\" title=\"Топографическая карта - $City2\" src=\"$flink0\">
                                       </a>";
                            $src_en = "<br /><a href='/ec$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Topographic map - $City11\" title=\"Topographic map - $City11\" src=\"$flink0\">
                                       </a>";
                        }
                        else if(file_exists($file1)){
                            $src_ua = "<br /><a href='/c$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Топографічна карта - $City\" title=\"Топографічна карта - $City\" src=\"$flink1\">
                                       </a>";
                            $src_ru = "<br /><a href='/rc$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Топографическая карта - $City2\" title=\"Топографическая карта - $City2\" src=\"$flink1\">
                                       </a>";
                            $src_en = "<br /><a href='/ec$id' class=\"scale\">
                                         <img width=$map_w height=$map_h alt=\"Topographic map - $City11\" title=\"Topographic map - $City11\" src=\"$flink1\">
                                       </a>";
                        }
                        $theme = "c#&~$id#&~";
                        $ualine = "<a>Стіна-Запитання<br> $City</a>$src_ua";
                        $ruline = "<a>Стена-Вопросы<br> $City2</a>$src_ru";
                        $enline = "<a>Wall-Questions<br> $City11</a>$src_en";

                        if(Auth::user()) {
                            $Num_am = Auth::user()->avatar;
                            $Imm = Auth::user()->Im;
                            $Prizm = Auth::user()->Priz;
                            $sexm = Auth::user()->sex;
                            $sex = "$sexm$Num_am";
                            if (!$sex) {
                                $sex = 0;
                            }
                        }
                        else{
                            $Imm = "Хтось";
                            $Prizm = "";
                            $sex = 0;
                        }

                        DB::table('News')->insert([
                            'act' => 'nforum', 'Im' => $Imm, 'Priz' => $Prizm, 'sex' => $sex, 'theme' => $theme,
                            'ualine' => $ualine, 'ruline' => $ruline, 'enline' => $enline,
                            'avt' => $my_id, 'whom' => $allusersn, 'forum' => $Aboutep, 'avt_fr' => $my_id, 'obl' => $obl, 'Nd' => $Md
                        ]);

                    }

                    $mailput = "forumlist$id";
                    $q_s1[0] = ['forum', 1];
                    $q_s2[0] = ['forum', 1];
                    $q_s3[0] = ['forum', 1];

                    $filename = "storage/sixhours.txt";
                    $whattoread = @fopen($filename, "r");
                    $truestat_file_contents = fread($whattoread, filesize($filename));

                    fclose($whattoread);
                    $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                    if ($lastmail == "") {

                        $q_s2[0] = ['forum', 2];
                        $newfile = @fopen($filename, "a");
                        @fwrite($newfile, $mailput);
                        fclose($newfile);

                        $filename = "storage/oneday.txt";
                        $whattoread = @fopen($filename, "r");
                        $truestat_file_contents = fread($whattoread, filesize($filename));
                        fclose($whattoread);

                        $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                        if ($lastmail == "") {
                            $q_s3[0] = ['forum', 3];
                            $newfile = @fopen($filename, "a");
                            @fwrite($newfile, $mailput);
                            fclose($newfile);
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
                            if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                $subj = "Хтось відповів на запитання на форумі $statusr $City";
                                $details['email'] = $Pmail;
                                $details['subject'] = $subj;
                                $details['blade'] = 'emails.ask_publc';
                                $details['det'] = array('statusm' => $statusm, 'City' => $City, 'domen' => $domen, 'id' => $id, 'Pmail' => $Pmail);
                                $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                                dispatch(new App\Jobs\SendEmailJob($details));
                            }
                        }
                    }
                }
            }
        }
    }



    public function top_askp(Request $request)
    {
        if(Auth::user()) {

            $na = $request['na'];
            $from_history = $request['from_history'];
            $answ = __('messages.answ');
            $skip = __('messages.skip');
            $qenter = __('messages.qenter');
            $lan = __('messages.lan');
            $q_a = "qua";
            if ($lan == "ru") {
                $q_a = "qru";
            }
            if ($lan == "en") {
                $q_a = "qen";
            }

            $qw = "";
            $Allc = DB::table('questionsp')->select('idq', $q_a)->
            inRandomOrder()->
            get();

            $q_count = $Allc->count();
            $n_count = 0;
            foreach ($Allc as $All) {
                $idq = $All->idq;
                $q_aa = $All->$q_a;
                if (mb_strstr((string)$from_history, "&$idq") == "") {
                    $qw = $q_aa;
                    $from_history .= "&$idq";
                    $na = $idq;
                    break;
                }
                $n_count++;
            }
            $qw .= "?";
            if ($n_count == $q_count) {
                $qw = __('messages.q_end');
            }
            echo "<table><tr><td valign='top'>
                    <div style='margin: 5px 5px 5px 5px;'>
                        <div style=\"float:left\">
                            <div style=\"margin: 0px 7px 5px 0px; \">
                                <img width=70 border=0 SRC=/images/mast.png>
                            </div>
                        </div> $qw
                    </div>
                </td></tr></table>";
            if ($n_count != $q_count) {
                echo "
                    <table><tr><td>
                    <textarea id=\"from_ask\" rows=2 style=\"width: 95%;\" placeholder = \"$qenter\"
                     onFocus=clearss('from_ask');></textarea>
                        <table><tr><td width=220 align=center>
                            <table><tr><td class=fcomblue width=90 valign=center><ul class=intop><li>
                                <a onclick=answer_interviewp($na)>$answ</a></li></ul>
                            </td>
                            <td class=fcomblue width=90 valign=center><ul class=intop><li>
                                <a onclick=top_askp($na)>$skip</a></li></ul>
                            </td>
                            </tr></table>
                            <input type=\"hidden\" id=\"from_history\" value=\"$from_history\">
                        </td></tr></table>
                    </td></tr></table>";
            }
        }
    }



    public function answer_interviewp(Request $request)
    {
        if(Auth::user()) {
            $id = Auth::user()->id;
            $na = $request['na'];
            $na=$na+1; $na=$na-1;
            if(is_int($na)!="true"){die("");}
            $lan = __('messages.lan');
            $Aboutef = $request['Aboutef'];
			$ctrl_hss= mb_strtolower($Aboutef);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}

            $Aboutef = getDescriptionAttribute($Aboutef);
            $Aboutef = nl2br($Aboutef);
            $Aboute = $Aboutef;
            $Aboutef = mb_strtolower($Aboutef);
            $abuse_ban = __('messages.abuse_ban');


            if (!$Aboutef) {
                $ask_err = __('messages.comm_err');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }
            else if (mb_strlen($Aboutef) > 500) {
                $ask_err = __('messages.ask_err2');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }

            else if (mb_strstr((string)$Aboutef,"хуй")!=""||mb_strstr((string)$Aboutef,"пизд")!=""||mb_strstr((string)$Aboutef," конч")!=""||mb_strstr((string)$Aboutef,"вафл")!=""||mb_strstr((string)$Aboutef,"шлюх")!=""||mb_strstr((string)$Aboutef,"fuck")!=""||mb_strstr((string)$Aboutef," гом")!=""||mb_strstr((string)$Aboutef," бля")!=""||mb_strstr((string)$Aboutef," манд")!=""||mb_strstr((string)$Aboutef,"член")!=""||mb_strstr((string)$Aboutef," еба")!=""||mb_strstr((string)$Aboutef," єба")!=""||mb_strstr((string)$Aboutef,"суч")!=""||mb_strstr((string)$Aboutef,"сук")!=""||mb_strstr((string)$Aboutef,"дроч")!=""||mb_strstr((string)$Aboutef," писк")!=""||mb_strstr((string)$Aboutef," піськ")!=""||mb_strstr((string)$Aboutef,"урод")!=""||mb_strstr((string)$Aboutef,"ублюд")!=""||mb_strstr((string)$Aboutef,"соса")!=""||mb_strstr((string)$Aboutef,"соси")!=""||mb_strstr((string)$Aboutef,"сран")!=""||mb_strstr((string)$Aboutef,"срак")!=""||mb_strstr((string)$Aboutef,"срат")!=""||mb_strstr((string)$Aboutef,"хуев")!=""||mb_strstr((string)$Aboutef,"костр")!=""||mb_strstr((string)$Aboutef,"блев")!=""||mb_strstr((string)$Aboutef,"яйц")!=""||mb_strstr((string)$Aboutef," трах")!=""||mb_strstr((string)$Aboutef,"влагал")!=""||mb_strstr((string)$Aboutef," онан")!=""){

                $bad_words="<font color=red>";
                if (mb_strstr((string)$Aboutef,"хуй")!=""){$bad_words.=" хуй";}
                if (mb_strstr((string)$Aboutef,"пизд")!=""){$bad_words.=" пизд";}
                if (mb_strstr((string)$Aboutef,"сперм")!=""){$bad_words.=" сперм";}
                if (mb_strstr((string)$Aboutef,"шлюх")!=""){$bad_words.=" шлюх";}
                if (mb_strstr((string)$Aboutef,"гом")!=""){$bad_words.=" гом";}
                if (mb_strstr((string)$Aboutef,"бля")!=""){$bad_words.=" бля";}
                if (mb_strstr((string)$Aboutef,"еба")!=""){$bad_words.=" еба";}
                if (mb_strstr((string)$Aboutef,"єба")!=""){$bad_words.=" єба";}
                if (mb_strstr((string)$Aboutef,"сук")!=""){$bad_words.=" сукa";}
                if (mb_strstr((string)$Aboutef,"дроч")!=""){$bad_words.=" дроч";}
                if (mb_strstr((string)$Aboutef,"піськ")!=""){$bad_words.=" піськ";}
                if (mb_strstr((string)$Aboutef,"ублюд")!=""){$bad_words.=" ублюд";}
                if (mb_strstr((string)$Aboutef,"сран")!=""){$bad_words.=" сран";}
                if (mb_strstr((string)$Aboutef,"срак")!=""){$bad_words.=" срак";}
                if (mb_strstr((string)$Aboutef,"срат")!=""){$bad_words.=" срат";}
                if (mb_strstr((string)$Aboutef,"хуев")!=""){$bad_words.=" хуев";}
                if (mb_strstr((string)$Aboutef,"трах")!=""){$bad_words.=" трах";}
                if (mb_strstr((string)$Aboutef,"онан")!=""){$bad_words.=" онан";}
                if (mb_strstr((string)$Aboutef,"хуя")!=""){$bad_words.=" хуя";}
                $bad_words.="</font>";

                echo"s235*64@75<table><tr><td align=center><p style=\"margin: 8px 0px 8px 0px; \">$abuse_ban: $bad_words</p></td></tr></table>";
            }
            else {

                $q_a = "qua";
                if($lan=="ru"){$q_a = "qru";}
                if($lan=="en"){$q_a = "qen";}

                $Allc = DB::table('questionsp')->select('idq',$q_a)->
                where('idq', $na)->limit(1)->
                get();
                foreach ($Allc as $All) {
                    $q_aa = $All->$q_a;
                }
                $Aboute = strtr($Aboute, "\"", "'");
                $q_aa = strtr($q_aa, "\"", "'");
                $Md = date('Y-n-j-H-i-s'); $ip = getenv('REMOTE_ADDR');
                $Aboutep="*&^@ <b>%^&@#</b> - $q_aa?<br /><b>&@#%^</b>
				- $Aboute";
                $aff = DB::table('Memoryp')->insert(['Num' => $id, 'Aboutep' => $Aboutep, 'avt' => $id,
                    'Md' => $Md, 'Ip' => $ip]);

                if ($aff) {

                    if(Auth::user()) {
                        $show_news = Auth::user()->show_news;
                        if (!$show_news) {
                            $nforum = 1;
                        } else {
                            $nforum = substr($show_news, 1, 1);
                        }
                    }
                    else{$nforum = 1;}
                    if ($nforum != 0) {


                        $Allw = DB::table('Private')->select('Page')->
                        where('Num', $id)->limit(1)->get();
                        $nr_private = $Allw->count();
                        foreach ($Allw as $Alw) {
                            $Pagep = $Alw->Page;
                        }
                        if ($nr_private == 0) {
                            $main_page = "1";
                        } else {
                            $main_page = "1";
                            if ((int)$Pagep > 1) {
                                $main_page = "2";
                            }
                        }

                        $theme = "p#&~$id#&~";
                        $ualine = "<a>Стіна-Запитання<br> своєї сторінки</a>";
                        $ruline = "<a>Стена-Вопросы<br> своей страницы</a>";
                        $enline = "<a>Wall-Questions<br> of page</a>";

                        $Num_am = Auth::user()->avatar;
                        $Imm = Auth::user()->Im;
                        $Prizm = Auth::user()->Priz;
                        $sexm = Auth::user()->sex;
                        $sex = "$sexm$Num_am";


                        DB::table('News')->insert([
                            'act' => 'nforum', 'Im' => $Imm, 'Priz' => $Prizm, 'sex' => $sex, 'theme' => $theme,
                            'ualine' => $ualine, 'ruline' => $ruline, 'enline' => $enline,
                            'avt' => $id, 'forum' => $Aboutep, 'avt_fr' => $id, 'Nd' => $Md, 'main_page' => $main_page
                        ]);

                    }

                    $mailput = "forumlist$id";
                    $q_s1[0] = ['forum', 1];
                    $q_s2[0] = ['forum', 1];
                    $q_s3[0] = ['forum', 1];

                    $filename = "storage/sixhours.txt";
                    $whattoread = @fopen($filename, "r");
                    $truestat_file_contents = fread($whattoread, filesize($filename));

                    fclose($whattoread);
                    $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                    if ($lastmail == "") {

                        $q_s2[0] = ['forum', 2];
                        $newfile = @fopen($filename, "a");
                        @fwrite($newfile, $mailput);
                        fclose($newfile);

                        $filename = "storage/oneday.txt";
                        $whattoread = @fopen($filename, "r");
                        $truestat_file_contents = fread($whattoread, filesize($filename));
                        fclose($whattoread);

                        $lastmail = mb_strstr((string)$truestat_file_contents, (string)$mailput);

                        if ($lastmail == "") {
                            $q_s3[0] = ['forum', 3];
                            $newfile = @fopen($filename, "a");
                            @fwrite($newfile, $mailput);
                            fclose($newfile);
                        }

                        $Allm = DB::table('Mailpost')
                            ->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3) {
                                $query->whereNull('forum')
                                    ->orWhere($q_s1)
                                    ->orWhere($q_s2)
                                    ->orWhere($q_s3);
                            })
                            ->where('Nump', $id)
                            ->select('Pmail')
                            ->get();


                        $nr_mail = $Allm->count();
                        if ($nr_mail > 0) {


                            $domen = Auth::user()->domen;
                            foreach ($Allm as $Alm) {
                                $Pmail = trim($Alm->Pmail);
                                if ($sexm == 1) {
                                    $sexm_e = "додав";
                                    $subj = "$Imm відповів на запитання";
                                } else if ($sexm == 2) {
                                    $sexm_e = "додала";
                                    $subj = "$Imm відповіла на запитання";
                                } else {
                                    $sexm_e = "додав (ла)";
                                    $subj = "$Imm відповів (ла) на запитання";
                                }
                                if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                    $details['email'] = $Pmail;
                                    $details['subject'] = $subj;
                                    $details['blade'] = 'emails.ask_publp';
                                    $details['det'] = array('Imm' => $Imm, 'Prizm' => $Prizm, 'sexm_e' => $sexm_e, 'domen' => $domen, 'id' => $id, 'Pmail' => $Pmail);
                                    $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                                    dispatch(new App\Jobs\SendEmailJob($details));
                                }
                            }
                        }
                    }
                }
            }
        }
    }




    function ipban(Request $request)
    {
        $id = $request['id'];
        $ipban = $request['ipban'];
        if(Auth::user()) {

            $my_id = Auth::user()->id;
            $Alla = DB::table('City_Admin2')->
            where('id', $id)->
            where('Num', $my_id)->
            limit(1)->
            get();
            $nra = $Alla->count();

            if ($nra > 0) {

                $Allp = DB::table('Privatec')->
                select('ipban')->
                where('id', $id)->
                limit(1)->
                get();
                $nrp = $Allp->count();
                if($nrp==0){
                    $affected = DB::table('Privatec')->insert([
                        'id' => $id, 'ipban' => $ipban
                    ]);
                }
                else{
                    foreach ($Allp as $All) {
                        $ipban2 = $All->ipban;
                    }
                    $affected = DB::table('Privatec')
                        ->where('id', $id)
                        ->update(['ipban' => $ipban]);
                    if($ipban2==$ipban){echo"$ipban";}
                }
                if($affected){echo"$ipban";}

            }
        }
    }





    function user_ban(Request $request)
    {
        $id = $request['id'];
        $user_ban = $request['user_ban'];
        $user_ban2 = $user_ban;
        if(Auth::user()) {

            $my_id = Auth::user()->id;
            $Alla = DB::table('City_Admin2')->
            where('id', $id)->
            where('Num', $my_id)->
            limit(1)->
            get();
            $nra = $Alla->count();

            if ($nra > 0) {

                $user_ban = str_replace("1ua", '', $user_ban);
                $user_ban = str_replace("25ua", '', $user_ban);
                $user_ban = str_replace("st:8000", '', $user_ban);
                $user_ban = preg_replace("/[^0-9]/", '', $user_ban);
                $user_ban = substr($user_ban, 0, 8);
                if($user_ban>=70000000 && $user_ban < 80000000){}
                else{
                    $wh_domen=$_SERVER["HTTP_HOST"];

                    if(mb_strstr((string)$wh_domen,"25ua.com/")!=""){
                        $startt = "com/";
                        $positiont = strpos($user_ban2, $startt);
                    }
                    if(mb_strstr((string)$wh_domen,"1ua.com.u")!=""){
                        $startt = ".ua/";
                        $positiont = strpos($user_ban2, $startt);
                    }
                    if(mb_strstr((string)$wh_domen,"localhost:8000")!=""){
                        $startt = "000/";
                        $positiont = strpos($user_ban2, $startt);
                    }
                    $user_ban2 = substr($user_ban2, $positiont+4);
                    if(mb_strstr((string)$user_ban2,"/")!="") {
                        $finishx = "/";
                        $positionx = strpos($user_ban2, $finishx);
                        $user_ban2 = substr($user_ban2, 0, $positionx);
                    }

                    $Allu = DB::table('users')->select('Num')->
                    where('domen', $user_ban2)->
                    limit(1)->
                    get();

                    foreach ($Allu as $All) {
                        $user_ban = $All->Num;
                    }

                }

                if(strlen($user_ban)==8){$user_ban="#$user_ban";}
                else{$user_ban="";}

                $Allp = DB::table('Privatec')->
                select('ComForBan')->
                where('id', $id)->
                limit(1)->
                get();
                $nrp = $Allp->count();
                if($nrp==0){
                    DB::table('Privatec')->insert([
                        'id' => $id, 'ComForBan' => $user_ban
                    ]);
                }
                else{
                    foreach ($Allp as $All) {
                        $user_ban0 = $All->ComForBan;
                    }
                    if($user_ban0){$user_ban=$user_ban0.="$user_ban";}
                    DB::table('Privatec')
                        ->where('id', $id)
                        ->update(['ComForBan' => $user_ban]);

                }

                $ban_n = substr_count($user_ban,"#");
                if($ban_n>0){
                    $ban_pages = explode("#", $user_ban);
                    $b=1;
                    for($a=$ban_n; $a>0; $a--){

                        $pageb=$ban_pages[$a];

                        $filename = "storage/last_visit/$pageb.txt";
                        $whattoread = @fopen($filename, "r");
                        $file_contents = fread($whattoread, filesize($filename)); 		 fclose($whattoread);
                        $pageq = explode("#!:*&", $file_contents);

                        $Imb=$pageq[1]; $Prizb=$pageq[2];
                        $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}

                        if($b==3){echo"<div id=\"hid_ban\" style=\"display: none;\">";}
                        $ppi = __('messages.pref_page'); $ppi.="i";
                        $delete = __('messages.Delete');
                        $show_all = __('messages.show_all');
                        echo"<div style = \"margin: 7px 0px 7px 0px;\" id=\"$t3\"><a href=/$ppi$pageb>$Imb $Prizb</a> <a href=## onclick=user_ban_del('$pageb','$t3')> <font size=0.5>$delete</font></a></div>";
                        $b++;
                    }
                }
                if($b>3){
                    echo"</div><div id=\"hid_ban2\"><a href=## onclick=ban_see()>$show_all ($ban_n)</a></div>";
                }
            }
        }
    }




    function user_ban_del(Request $request)
    {
        $id = $request['id'];
        $user_ban = $request['user_ban'];
        if(Auth::user()) {

            $my_id = Auth::user()->id;
            $Alla = DB::table('City_Admin2')->
            where('id', $id)->
            where('Num', $my_id)->
            limit(1)->
            get();
            $nra = $Alla->count();

            if ($nra > 0) {

                if(strlen($user_ban)==8){

                    $Allp = DB::table('Privatec')->
                    select('ComForBan')->
                    where('id', $id)->
                    limit(1)->
                    get();

                    foreach ($Allp as $All) {
                        $user_bans = $All->ComForBan;
                    }

                    $user_bans = str_replace("#$user_ban", '', $user_bans);
                    $affected = DB::table('Privatec')
                        ->where('id', $id)
                        ->update(['ComForBan' => $user_bans]);

                    if($affected){$unlock = __('messages.unlock'); echo"$unlock";}
                }
            }
        }
    }









    function user_banp(Request $request)
    {

        $user_ban = $request['user_ban'];
        $user_ban2 = $user_ban;
        if(Auth::user()) {

            $my_id = Auth::user()->id;

            $user_ban = str_replace("1ua", '', $user_ban);
            $user_ban = str_replace("25ua", '', $user_ban);
            $user_ban = str_replace("st:8000", '', $user_ban);
            $user_ban = preg_replace("/[^0-9]/", '', $user_ban);
            $user_ban = substr($user_ban, 0, 8);
            if($user_ban>=70000000 && $user_ban < 80000000){}
            else{
                $wh_domen=$_SERVER["HTTP_HOST"];

                if(mb_strstr((string)$wh_domen,"25ua.com/")!=""){
                    $startt = "com/";
                    $positiont = strpos($user_ban2, $startt);
                }
                if(mb_strstr((string)$wh_domen,"1ua.com.u")!=""){
                    $startt = ".ua/";
                    $positiont = strpos($user_ban2, $startt);
                }
                if(mb_((string)$wh_domen,"localhost:8000")!=""){
                    $startt = "000/";
                    $positiont = strpos($user_ban2, $startt);
                }
                $user_ban2 = substr($user_ban2, $positiont+4);
                if(mb_strstr((string)$user_ban2,"/")!="") {
                    $finishx = "/";
                    $positionx = strpos($user_ban2, $finishx);
                    $user_ban2 = substr($user_ban2, 0, $positionx);
                }

                $Allu = DB::table('users')->select('Num')->
                where('domen', $user_ban2)->
                limit(1)->
                get();

                foreach ($Allu as $All) {
                    $user_ban = $All->Num;
                }
            }

            if(strlen($user_ban)==8){$user_ban="#$user_ban";}
            else{$user_ban="";}

            $Allp = DB::table('Private')->
            select('ban')->
            where('Num', $my_id)->
            limit(1)->
            get();
            $nrp = $Allp->count();
            if($nrp==0){
                DB::table('Private')->insert([
                    'Num' => $my_id, 'ban' => $user_ban
                ]);
            }
            else{
                foreach ($Allp as $All) {
                    $user_ban0 = $All->ban;
                }
                if($user_ban0){$user_ban=$user_ban0.="$user_ban";}
                DB::table('Private')
                    ->where('Num', $my_id)
                    ->update(['ban' => $user_ban]);

            }

            $ban_n = substr_count($user_ban,"#");
            if($ban_n>0){
                $ban_pages = explode("#", $user_ban);
                $b=1;
                for($a=$ban_n; $a>0; $a--){

                    $pageb=$ban_pages[$a];

                    $filename = "storage/last_visit/$pageb.txt";
                    $whattoread = @fopen($filename, "r");
                    $file_contents = fread($whattoread, filesize($filename)); 		 fclose($whattoread);
                    $pageq = explode("#!:*&", $file_contents);

                    $Imb=$pageq[1]; $Prizb=$pageq[2];
                    $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}

                    if($b==3){echo"<div id=\"hid_ban\" style=\"display: none;\">";}
                    $ppi = __('messages.pref_page'); $ppi.="i";
                    $delete = __('messages.Delete');
                    $show_all = __('messages.show_all');
                    echo"<div style=\"margin: 7px 0px 7px 0px;\" id=\"$t3\"><a href=/$ppi$pageb>$Imb $Prizb</a> <a href=## onclick=user_ban_delp('$pageb','$t3')> <font size=0.5>$delete</font></a></div>";
                    $b++;
                }
            }
            if($b>3){
                echo"</div><div id=\"hid_ban2\"><a href=## onclick=ban_see()>$show_all ($ban_n)</a></div>";
            }
        }
    }




    function user_ban_delp(Request $request)
    {
        $user_ban = $request['user_ban'];
        if(Auth::user()) {

            $my_id = Auth::user()->id;
            if(strlen($user_ban)==8){

                $Allp = DB::table('Private')->
                select('ban')->
                where('Num', $my_id)->
                limit(1)->
                get();

                foreach ($Allp as $All) {
                    $user_bans = $All->ban;
                }

                $user_bans = str_replace("#$user_ban", '', $user_bans);
                $affected = DB::table('Private')
                    ->where('Num', $my_id)
                    ->update(['ban' => $user_bans]);

                if($affected){$unlock = __('messages.unlock'); echo"$unlock";}
            }
        }
    }



    function q_a_i(Request $request)
    {
        $id = $request['id'];
        $set_q = $request['set_q'];
        if(Auth::user()) {

            $my_id = Auth::user()->id;
            $Alla = DB::table('City_Admin2')->
            where('id', $id)->
            where('Num', $my_id)->
            limit(1)->
            get();
            $nra = $Alla->count();

            if ($nra > 0) {

                $Allp = DB::table('Privatec')->
                select('set_q')->
                where('id', $id)->
                limit(1)->
                get();
                $nrp = $Allp->count();
                if($nrp==0){
                    $aff = DB::table('Privatec')->insert([
                        'id' => $id, 'set_q' => $set_q
                    ]);
                }
                else {

                    $aff = DB::table('Privatec')
                        ->where('id', $id)
                        ->update(['set_q' => $set_q]);
                }
                if($aff){$myemlpass = __('messages.myemlpass'); echo"$myemlpass";}
            }
        }
    }






    function del_adm(Request $request)
    {
        $id = $request['id'];
        if(Auth::user()) {

            $my_id = Auth::user()->id;
            $Alla = DB::table('City_Admin2')->
            where('id', $id)->
            where('Num', $my_id)->
            limit(1)->
            get();
            $nra = $Alla->count();

            if ($nra > 0) {

                $aff = DB::table('City_Admin2')->
                                where('id', $id)->
                                where('Num', $my_id)->delete();
                if($aff){
                    $deleted_adm = __('messages.deleted_adm');
                    echo"$deleted_adm";
                }
            }
        }
    }




    function adm_pages(Request $request)
    {
        $id = $request['id'];
        $Alla = DB::table('City_Admin2')->
        select('id','Page')->
        where('Num', $id)->
        where('id', '>', 0)->
        orderBy('id', 'asc')->
        get();
        $nra = $Alla->count();
        $id_h = "";
        if ($nra > 0) {

            echo"<div style = \"margin-bottom: 20px; \">";
            foreach ($Alla as $All) {
                $idc = $All->id; $Page = $All->Page;
                $Allc = DB::table('Allcities')->select('City','City2','City3')->
                where('id', $idc)->limit(1)->get();

                foreach ($Allc as $All) {
                    $City = $All->City; $City2 = $All->City2; $City3 = $All->City3;
                }

                $Forum = __('messages.Forum');
                $Foto = __('messages.Foto');
                if($Page == "Memory"){$adm_e = $Forum;}
                if($Page == "Foto"){$adm_e = $Foto;}

                $link_e2 = "";
                if(Auth::user()) {
                    $my_id = Auth::user()->id;
                    if($my_id == $id){
                        $link_e2 = "<a href=/adm/$idc>$adm_e -> </a>";
                    }
                }

                $link_e1 = "<a href=/c$idc>$City</a> ";
                $lan_user = App::currentLocale();
                if ($lan_user=="ru") {
                    $link_e1 = "<a href=/rc$idc>$City2</a>";
                }
                if ($lan_user=="en") {
                    $link_e1 = "<a href=/ec$idc>$City3</a> ";
                }

                if($id_h!="" && $id_h!=$idc){echo"</div>";}
                if($id_h!=$idc){echo"<div style = \"margin-top: 10px; font-size: 14px;\">$link_e1";}
                echo"$link_e2";

                $id_h=$idc;
            }

         echo"</div></div>";

        }
    }



    function be_admin(Request $request)
    {
        $id = $request['id'];
        $page = $request['page'];
        $need_admin = __('messages.need_admin');
        echo "<div style = \"margin: 5px 15px 5px 15px;\">";
        if(Auth::user()) {

            $my_id = Auth::user()->id;
            $Alla = DB::table('City_Admin2')->
            where('id', $id)->
            where('Num', $my_id)->
            where('Page', $page)->
            limit(1)->
            get();
            $nra = $Alla->count();

            if ($nra > 0) {
                $is_admin = __('messages.is_admin');
                echo"$is_admin ";
            }
            else{

                if($page=="Memory") {
                    $Alla = DB::table('Memory')->
                    where('id', $id)->
                    where('avt', $my_id)->
                    get();
                    $nrc = $Alla->count();

                    if ($nrc == 0) {
                        $need_publ = __('messages.need_publ');
                        echo "$need_admin $need_publ";
                    } else {
                        $adm_send = __('messages.adm_send');
                        $Md = date('Y-m-d-H-i-s');
                        $email = Auth::user()->email;
                        $aff = DB::table('City_Admin2')->
                        insert(['Page' => $page, 'bank' => $id, 'Num' => $my_id, 'Md' => $Md, 'mail_admin' => $email]);
                        if ($aff) {
                            $Pmail = "sirov@ukr.net";
                            $subj = "Новий адмін $page $id";

                            $details['email'] = $Pmail;
                            $details['subject'] = $subj;
                            $details['blade'] = 'emails.do_adm';
                            $details['det'] = array('id' => $id, 'Num' => $my_id);
                            $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                            dispatch(new App\Jobs\SendEmailJob($details));

                            echo "$adm_send";
                        }
                    }
                }

                if($page=="Foto") {
                    $Alla = DB::table('Foto')->
                    where('id', $id)->
                    where('avt', $my_id)->
                    get();
                    $nrc = $Alla->count();

                    if ($nrc <= 5) {
                        $need_publ = __('messages.need_foto');
                        echo "$need_admin $need_publ";
                    } else {
                        $adm_send = __('messages.adm_send');
                        $Md = date('Y-m-d-H-i-s');
                        $email = Auth::user()->email;
                        $aff = DB::table('City_Admin2')->
                        insert(['Page' => $page, 'bank' => $id, 'Num' => $my_id, 'Md' => $Md, 'mail_admin' => $email]);
                        if ($aff) {
                            $Pmail = "sirov@ukr.net";
                            $subj = "Новий адмін $page $id";
                            $details['email'] = $Pmail;
                            $details['subject'] = $subj;
                            $details['blade'] = 'emails.do_adm';
                            $details['det'] = array('id' => $id, 'Num' => $my_id);
                            $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                            dispatch(new App\Jobs\SendEmailJob($details));

                            echo "$adm_send";
                        }
                    }
                }
            }
        }
        else{
            $to_answ2 = __('messages.to_answ2');
            echo"$need_admin $to_answ2 ";
        }
        echo "</div>";
    }

    function confirm(Request $request)
    {
        $num = $request['num'];
        $Md = $request['Md'];
        $bank = $request['bank'];
        $eml = $request['eml'];
        $page = $request['page'];

        if(Auth::user()) {

            $ggg = Auth::user()->id;
            if ($ggg == "72372396") {
                $aff = DB::table('City_Admin2')
                    ->where('Md', $Md)
                    ->where('Num', $num)
                    ->update(['id' => $bank]);

                if($aff){
                    echo"done";
                    $bank=$bank+1; $bank=$bank-1;
                    if(is_int($bank)!="true"){die("");}

                    $Allc = DB::table('Allcities')->select('City')->
                    where('id', $bank)->limit(1)->get();

                    foreach ($Allc as $All) {
                        $City = $All->City;
                    }
                    $Alla = DB::table('Citymailpost')->
                    where('id', $bank)->
                    where('mail_visitor', $eml)->
                    get();
                    $nrc = $Alla->count();
                    if($nrc==0){
                        $aff = DB::table('Citymailpost')->insert(['id' => $bank, 'mail_visitor' => $eml]);
                    }

                    if($page=="Foto"){
                        $subj = "$City - доступ на адміністрування фото";
                        $link = "https://1ua.com.ua/fc$bank";
                    }
                    if($page=="Memory"){
                        $subj = "$City - доступ на адміністрування записів";
                        $link = "https://1ua.com.ua/c$bank";
                    }
                    if (filter_var($eml, FILTER_VALIDATE_EMAIL)) {
                        $details['email'] = $eml;
                        $details['subject'] = $subj;
                        $details['blade'] = 'emails.do_adm2';
                        $details['det'] = array('link' => $link, 'City' => $City);
                        $details['unsub'] = "<$eml>, <https://1ua.com.ua/unsubscribe/$eml/$bank>";
                        dispatch(new App\Jobs\SendEmailJob($details));
                    }

                }
            }
        }
    }




    function del_adm2(Request $request)
    {
        $Md = $request['Md'];
        if(Auth::user()) {

            $ggg = Auth::user()->id;
            if ($ggg == "72372396") {
                $aff = DB::table('City_Admin2')->
                where('Md', $Md)->delete();
                if($aff){echo"done";}
            }
        }
    }








    public function life(Request $request)
    {
        $id = $request['id'];
        $npass1 = $request['npass1'];
        $theme = $request['theme'];

        if($theme=="avto"||$theme=="biz"||$theme=="serv"||$theme=="loc"||$theme=="med"||$theme=="sub"||$theme=="sch"){}else{die("");}
        $id=$id+1; $id=$id-1;
        if(is_int($id)!="true"){die("");}

        $npass2=$npass1+1;
        if($npass1==1){$shift=0;}
        else {$shift=$npass1-1; $shift=$shift*10;}
        $lan = App::currentLocale();

        if ($lan == "ua"){
            $Alls = DB::table('Allcities')->select('domen', 'City', 'status', 'vol_karta', 'face_karta',
                'City_m', 'City_o', 'City_r', 'City_d')->
            where('id', $id)->
            limit(1)->get();
            $cq1 = "ua";
        }
        if ($lan == "ru"){
            $Alls = DB::table('Allcities')->select('domen', 'City2', 'status', 'vol_karta', 'face_karta',
                'rod', 'dat', 'vin', 'tvor', 'predl')->
            where('id', $id)->
            limit(1)->get();
            $cq1 = "ru";
        }
        $nrseest = $Alls->count();

        if($nrseest==0){die("");}
        foreach ($Alls as $All) {
            $domen = $All->domen;
            $status = $All->status;
            $vol_karta = $All->vol_karta;

            if ($lan == "ua"){
                $City = $All->City;
                $City_m = $All->City_m;
                $City_o = $All->City_o;
                $City_r = $All->City_r;
                $City_d = $All->City_d;

                if ($status){
                    if ($status==1){$ss=1; $statusnv="Місто"; $statusn="місто"; $statusr="міста"; $statusd="місту"; $statusm="місті"; $statuso="містом"; $statuspro="міської";}
                    if ($status==2){$ss=2; $statusnv="Смт"; $statusn="смт"; $statusr="смт"; $statusd="смт"; $statusm="смт"; $statuso="смт"; $statuspro="селищної";}
                    if ($status==3){$ss=3; $statusnv="Селище"; $statusn="селище"; $statusr="селища"; $statusd="селищу"; $statusm="селищі"; $statuso="селищем"; $statuspro="селищної";}
                    if ($status==4){$ss=4; $statusnv="Село"; $statusn="село"; $statusr="села"; $statusd="селу"; $statusm="селі"; $statuso="селом"; $statuspro="сільської";}
                    if ($status==5){$ss=5; $statusnv="Хутір"; $statusn="хутір"; $statusr="хутора"; $statusd="хутору"; $statusm="хуторі"; $statuso="хутором"; $statuspro="хутірської";}
                }
                else{
                    if (!$vol_karta||$vol_karta<20000){$ss=4; $statusnv="Село"; $statusn="село"; $statusr="села"; $statusd="селу"; $statusm="селі"; $statuso="селом"; $statuspro="сільської";}
                    if ($vol_karta>=20000&&$vol_karta<50000){$ss=2; $statusnv="Місто (село)"; $statusn="місто (село)"; $statusr="міста (села)"; $statusd="місту (селу)"; $statusm="місті (селі)"; $statuso="містом (селом)"; $statuspro="міської (сільської)";}
                    if ($vol_karta>=50000){$ss=1; $statusnv="Місто"; $statusn="місто"; $statusr="міста"; $statusd="місту"; $statusm="місті"; $statuso="містом"; $statuspro="міської";}
                }

            }
            if ($lan == "ru"){
                $City2 = $All->City2; $City = $City2;
                $rod = $All->rod;
                $dat = $All->dat;
                $vin = $All->vin;
                $tvor = $All->tvor;
                $predl = $All->predl;

                if ($status){
                    if ($status==1){$ss=1; $statusnv="Город"; $statusn="город"; $statusne="городе"; $statusny="городу"; $statusr="города"; $statusno="городом"; $statuspro="городского";}
                    if ($status==2){$ss=2; $statusnv="Пгт"; $statusn="пгт"; $statusne="пгт"; $statusny="пгт";$statusr="пгт"; $statusno="пгт"; $statuspro="поселочного";}
                    if ($status==3){$ss=3; $statusnv="Поселок"; $statusn="поселок"; $statusne="поселку";  $statusny="поселку";  $statusr="поселка"; $statusno="поселком"; $statuspro="поселочного";}
                    if ($status==4){$ss=4; $statusnv="Село"; $statusn="село"; $statusne="селе"; $statusny="селу"; $statusr="села"; $statusno="селом"; $statuspro="сельского";}
                    if ($status==5){$ss=5; $statusnv="Хутор"; $statusn="хутор"; $statusne="хуторе"; $statusny="хутору"; $statusr="хутора"; $statusno="хутором"; $statuspro="хуторского";}
                }

                else{
                    if (!$vol_karta||$vol_karta<20000){$ss=4; $statusnv="Село"; $statusn="село"; $statusne="селе"; $statusny="селу"; $statusr="села"; $statusno="селом"; $statuspro="сельского";}
                    if ($vol_karta>=20000&&$vol_karta<50000){$ss=2; $statusnv="Город (село)"; $statusn="город (село)"; $statusne="городе (селе)"; $statusny="городу (селу)"; $statusr="города (села)"; $statusno="городом (селом)"; $statuspro="городского (сельского)";}
                    if ($vol_karta>=50000){$ss=1; $statusnv="Город"; $statusn="город"; $statusne="городе"; $statusny="городу"; $statusr="города"; $statusno="городом"; $statuspro="городского";}
                }

                if(strlen($rod)>2){$rod=$rod;} else{$rod="$statusr $City2";}
                if(strlen($dat)>2){$dat=$dat;} else{$dat="$statusny $City2";}
                if(strlen($vin)>2){$vin=$vin;} else{$vin="$statusn $City2";}
                if(strlen($tvor)>2){$tvor=$tvor;} else{$tvor="$statusno $City2";}
                if(strlen($predl)>2){$predl=$predl;} else{$predl="$statusne $City2";}

            }
        }


        if($id==23334 || $id==73918){
            $Alls = DB::table('life')->
            select('link',$cq1)->
            where($theme, 2)->
            whereNull('non_vis')->
            orderBy('id', 'desc')->
            skip($shift)->take(11)->
            get();
        }
        else{
            $Alls = DB::table('life')->
            select('link',$cq1)->
            where($theme, 2)->
            orderBy('id', 'desc')->
            skip($shift)->take(11)->
            get();
        }
        $nr = $Alls->count();
        $take_need=1;
        echo"<table>";
        foreach ($Alls as $All) {
            if($take_need<11){
                $link = $All->link;
                $ua = $All->$cq1;
                if ($lan == "ua"){
                    $ua = str_replace("$", "", $ua);
                    $ua = str_replace("City_d", $City_d, $ua);
                    $ua = str_replace("City_r", $City_r, $ua);
                    $ua = str_replace("City_o", $City_o, $ua);
                    $ua = str_replace("City_m", $City_m, $ua);
                    $ua = str_replace("City", $City, $ua);
                    $ua = str_replace("statusnv", $statusnv, $ua);
                    $ua = str_replace("statusn", $statusn, $ua);
                    $ua = str_replace("statusr", $statusr, $ua);
                    $ua = str_replace("statusd", $statusd, $ua);
                    $ua = str_replace("statusm", $statusm, $ua);
                    $ua = str_replace("statuso", $statuso, $ua);
                    $ua = str_replace("statuspro", $statuspro, $ua);
                    $ua = str_replace("domen", $domen, $ua);

                    $ntag=substr_count($ua, '{');

                    for($ntag0=1;$ntag0<=$ntag;$ntag0++){

                        $position = strpos($ua, "{"); $content = substr($ua, $position+1);
                        $position = strpos($content, "}"); $content = substr($content, 0, $position);

                        $content2 = "|$content";
                        $ntag2=substr_count($content2, '|');
                        $words = explode("|", $content2);
                        $zn=rand(1,$ntag2);
                        $word=$words[$zn];
                        $contentr="{"; $contentr.=$content; $contentr.="}";
                        $ua = str_replace("$contentr", "$word", $ua);
                    }
                }
                if ($lan == "ru"){

                    $ua = str_replace("$", "", $ua);
                    $ua = str_replace("rod", $rod, $ua);
                    $ua = str_replace("dat", $dat, $ua);
                    $ua = str_replace("vin", $vin, $ua);
                    $ua = str_replace("tvor", $tvor, $ua);
                    $ua = str_replace("predl", $predl, $ua);
                    $ua = str_replace("City", $City2, $ua);
                    $ua = str_replace("statusnv", $statusnv, $ua);
                    $ua = str_replace("statusne", $statusne, $ua);
                    $ua = str_replace("statusny", $statusny, $ua);
                    $ua = str_replace("statusr", $statusr, $ua);
                    $ua = str_replace("statusno", $statusno, $ua);
                    $ua = str_replace("statuspro", $statuspro, $ua);
                    $ua = str_replace("statusn", $statusn, $ua);
                    $ua = str_replace("domen", $domen, $ua);


                    $ntag=substr_count($ua, '{');

                    for($ntag0=1;$ntag0<=$ntag;$ntag0++){

                        $position = strpos($ua, "{"); $content = substr($ua, $position+1);
                        $position = strpos($content, "}"); $content = substr($content, 0, $position);

                        $content2 = "|$content";
                        $ntag2=substr_count($content2, '|');
                        $words = explode("|", $content2);
                        $zn=rand(1,$ntag2);
                        $word=$words[$zn];
                        $contentr="{"; $contentr.=$content; $contentr.="}";
                        $ua = str_replace("$contentr", "$word", $ua);

                    }

                }

                echo"
                <tr><td width=235 height=10 align=center style=\"cursor: pointer;\"  onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\"><table><tr><td width=200 align=left>
                    <a href=/$domen/$lan/$link>$ua</a><br />
                    </td></tr></table></td></tr>
                ";
            }
            $take_need++;
        }
        echo"</table>";

        if($nr==11){
            $nnext =  __('messages.nnext');
            $t1="qwertyuiopasdfghjklzxcvbnm"; $t2="";
            for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t2.="$t1[$z]";}
            echo"<div id=$t2>
                <table style=\"cursor: pointer;\">
                    <tr><td width=235 align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\"
                     onClick=\"life($npass2,'$theme','$t2',$id)\";><a><b>$nnext</b> </a></td></tr>
                </table><br />
            </div>";
        }
        else{echo"<br />";}

    }



    function status(Request $request)
    {
        $status = $request['status'];
        $id = $request['id'];
        $ctrl_hss= mb_strtolower($status);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
			$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        if(Auth::user()) {
            $Allc = DB::table('Allcities')->select('ab')->
            where('id', $id)->limit(1)->get();
            $nc = 0;
            foreach ($Allc as $All) {
                $ab = $All->ab;
                $nc++;
            }
            if ($nc != 0) {
                $pagec = explode("#!", $ab);

                $City7=$pagec[1]; $City27=$pagec[2];
                $obl7=$pagec[3]; $ray7=$pagec[4];  $vol7=$pagec[6];
                $nrf7=$pagec[7]; $nrm7=$pagec[8]; $nrv7=$pagec[9]; $nrp7=$pagec[10]; $City37=$pagec[11]; $domen7=$pagec[12];
                $new_ab = "#!$City7#!$City27#!$obl7#!$ray7#!$status#!$vol7#!$nrf7#!$nrm7#!$nrv7#!$nrp7#!$City37#!$domen7";

                $affected = DB::table('Allcities')
                    ->where('id', $id)
                    ->update(['status' => $status, 'ab' => $new_ab]);
                if($affected){echo"ok";}
            }
        }
    }

    public function life_sitemap(Request $request)
    {
        if (Auth::user()) {
            $id = Auth::user()->id;
            if($id == 72372396){
                $theme = $request['q'];
                $q=$theme;
                $ua="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
                $ru="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";

                $Allc = DB::table('Allcities')->select('domen')->
                where('id', '>', 0)->get();
                foreach ($Allc as $All) {
                    $domen = $All->domen;
                    $ua.="  <url>
    <loc>https://1ua.com.ua/$domen/ua/$theme</loc>
  </url>
";
                    $ru.="  <url>
    <loc>https://1ua.com.ua/$domen/ru/$theme</loc>
  </url>
";
                }

                $ua.="
</urlset>";
                $ru.="
</urlset>";
                $themeua = "sm/$theme";
                $themeru = "sm/$theme";
                $themeua .="ua.xml";
                $themeru .="ru.xml";
                $dmn = "https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2F";
                $themeua2 = $dmn.=$theme.="ua.xml";
                $themeru2 = $dmn.=$theme.="ru.xml";

        Storage::disk('public')->put($themeua, $ua);
        Storage::disk('public')->put($themeru, $ru);

        $memory_contents = Storage::disk('public')->get('sitemap.xml');
        $Md_tod = date('Y-m-d');

        if (mb_strstr((string)$memory_contents, (string)$q) != "") {
            echo"sitemap already sended before";
        }
        else{
            $memory_contents_new = str_replace("</sitemapindex>", "   <sitemap>
      <loc>https://1ua.com.ua/$themeua</loc>
             <lastmod>$Md_tod</lastmod>
   </sitemap>
   <sitemap>
      <loc>https://1ua.com.ua/$themeru</loc>
             <lastmod>$Md_tod</lastmod>
   </sitemap>
</sitemapindex>", $memory_contents);

            Storage::disk('public')->put('sitemap.xml', $memory_contents_new);

        print file_get_contents($themeua2).'<br/>';
        print file_get_contents($themeru2).'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsitemap.xml').'<br/>';


        print file_get_contents($themeua2).'<br/>';
        print file_get_contents($themeru2).'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sitemap.xml').'<br/>';
            echo"<br />just sended";
        }



            }
        }
    }



    function getCities(Request $request) {
        $query = $request['query'];
        $lan = __('messages.lan');
        $qc="City";
        $lc="";
        if($lan == "ru"){$qc="City2"; $lc="r";}
        if($lan == "en"){$qc="City3"; $lc="e";}


        $Allm = DB::table('Allcities')
            ->select('id', 'domen', $qc, 'obl', 'oblc', 'rayc')
            ->where($qc, 'like', '%' . $query . '%')
            ->orderBy('vol_karta', 'desc')
            ->get();

        $cities = [];
        foreach ($Allm as $row){

            $id = $row->id;
			$domen = $row->domen;
            $City = $row->$qc;
			$City = "<a href=/$domen/$lan><b>$City</b></a>";
            $obln = $row->obl;
            $oblc = $row->oblc;
            $rayc = $row->rayc;
            if($id==$rayc){$rayc="";}
            if($id==$oblc){$obln="";}

			$obl="";
            if($obln>0) {
                $oi = "messages.ooo$obln";
				$obl = " <a href=/$lc";
				$obl.="se";
				$obl.=$obln; $obl.=">(";
				$obl.=__($oi); $obl.=")</a>";
            }
            if($rayc>0) {

                $Allc = DB::table('Allcities')
                    ->select($qc, 'domen')
                    ->where('id', '=', $rayc)
                    ->get();
                foreach ($Allc as $row) {
                    $ryc = $row->$qc;
					$rycd = $row->domen;
					$rc = "messages.raycent";
					$rayc = " - ";
					$rayc.=__($rc);
					$rayc.=": <a href=/$rycd/$lan>$ryc</a>";
                }
            }

        $cities[] = ['сity' => $City, 'obl' => $obl, 'rayc' => $rayc ];
        }
        return response()->json($cities);
}



    function stats_obl(Request $request) {
        $results = DB::table('stat')
            ->select('id', 'views')
            ->where('id', '<', 26)
            ->where('id', '>', 0)
            ->get();

        return response()->json($results);
    }

    function stats_ray(Request $request) {
        $obl = $request['obl'];

        $results = DB::table('stat')
            ->select('id', 'views')
            ->where('obl', '=', $obl)
            ->get();

        return response()->json($results);

    }

    function stats_id(Request $request) {
        $rayc = $request['rayc'];

        $results = DB::table('stat')
            ->select('city_id', 'views')
            ->where('id', '=', $rayc)
            ->where('city_id', '>', 0)
            ->get();

        return response()->json($results);


    }

}
