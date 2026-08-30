@extends('layouts.app')

@section('title_block') {{ __('messages.fenter') }} @endsection
@section('content')

@guest

<script>

    function sendform() {

        if (history.pushState) {
            var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            var newUrl = baseUrl + '';
            history.pushState(null, null, newUrl);
        }
        else {
            console.warn('History API не поддерживает ваш браузер');
        }

        document.forms.login4.submit();
    }
</script>
    @php

    $Allbn=0;
    $Allbn2=1;
    $еdее = $_SERVER['REQUEST_URI'];
    // echo"еее $еdее";


    if (!empty($_GET['code']))  {
    // var_dump($_GET['state']);

        $params = array(
            'client_id'     => '136596823089802',
            'client_secret' => 'c94a9d550a470b68d23f4a6da20a56ca',
            'redirect_uri'  => 'https://1ua.com.ua/fb_reg',
            'code'          => $_GET['code']
        );

        // Получение access_token
        $data = file_get_contents('https://graph.facebook.com/oauth/access_token?' . urldecode(http_build_query($params)));
        $data = json_decode($data, true);

        if (!empty($data['access_token'])) {
            $params = array(
                'access_token' => $data['access_token'],
                'fields'       => 'id,email,first_name,last_name,link,birthday'
            );

            // Получение данных пользователя
            $info = file_get_contents('https://graph.facebook.com/me?' . urldecode(http_build_query($params)));
            $info = json_decode($info, true);

            // var_dump($info);

            $fid = $info['id'];
            if (isset($info['email'])) {
                $emailf = $info['email'];
            } else {
                $emailf = "";
            }
            $first_namef = $info['first_name'];
            $last_name = $info['last_name'];
            // $gender = $info['gender'];
            // $birthday = $info['birthday'];

            // echo"<br /> fid $fid <br /> emailf $emailf <br /> first_namef $first_namef <br /> last_name $last_name<br />";
            // gender $gender <br /> birthday $birthday <br />
            // echo"<img src=https://graph.facebook.com/5023151984449538/picture?type=large>";


            $Allb0 = DB::table('users')->select('passw')->
            whereNull('fid')->
            where('email', $emailf)->
            get();
            $Allbn0 = $Allb0->count();
            if($Allbn0==0){
                DB::table('users')->
                where('email', $emailf)->
                update(['fid' => $fid]);
            }


            $Allb = DB::table('users')->select('passw')->
            where('email', $emailf)->
            where('fid', $fid)->
            get();
            $Allbn = $Allb->count();
            // echo"Allbn $Allbn";
            $passw = "";
            if($Allbn>0){
                foreach ($Allb as $All) {
                $passw = $All->passw;
                }
            }


            $Allb2 = DB::table('users')->select('passw')->
            where('email', $emailf)->
            get();
            $Allbn2 = $Allb2->count();
			if($Allbn2==0){

				do {
				   $Num = mt_rand( 1,9000000 ); $Num = $Num + 70000000 ;
				} while ( \DB::table( 'users' )->where( 'Num', $Num )->exists() );
				$id = $Num;
				$Ip = $_SERVER['REMOTE_ADDR'];
				$position = strpos($emailf, "@"); $psw = substr($emailf, 0, $position);

               // $Num_av = my_avatar($fid,$id,$first_namef,$last_name);
                $image =  file_get_contents("https://graph.facebook.com/$fid/picture?type=large");
                if($image){

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

                    $SRC_f0 = "$Num_av.jpg";
                    $from_path = "tmp/$Num_av.jpg";
                    Storage::disk('public')->put($from_path, $image);
                    $image_resize = Image::make(storage_path('app/public/tmp/'.$SRC_f0));


                    $size = getimagesize(Storage::path('public/tmp/') . $SRC_f0);
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
                     $path1 = $image_resize->save(Storage::path('public/avatar/b') . $SRC_f0);

                    if ($w >= 100) {
                        $new_h = round(100 * $hw);
                        $image_resize->resize(100, $new_h);
                    }
                     $path2 = $image_resize->save(Storage::path('public/avatar/') . $SRC_f0);

                    if ($w >= 50) {
                        $new_h = round(50 * $hw);
                        $image_resize->resize(50, $new_h);
                    }
                     $path3 = $image_resize->save(Storage::path('public/avatar/s') . $SRC_f0);

                    Storage::disk('public')->copy('default.txt', "last_visit/$id.txt");
                    Storage::disk('public')->prepend("last_visit/$id.txt", "#!:*&$first_namef#!:*&$last_name#!:*&$Num_av#!:*&ua#!:*&/infp#!:*&$h_px");

                    if ($path1 && $path2 && $path3) {
                        Storage::disk('public')->delete($from_path);
                    }
                }
                else{
                    $Num_av=0;
                    $h_px=0;
                }


				$aff = DB::table('users')->insert(['id' => $id, 'fid' => $fid, 'Num' => $Num, 'Im' => $first_namef, 'Priz' => $last_name,
                'email' => $emailf, 'aktiv' => 1,'avatar' => $Num_av,'avx' => $w_px,'avy' => $h_px,
                'password' => Hash::make($psw),'passw' => $psw, 'Md' => date('Y-n-j-H-i'), 'Ip' => $Ip]);

			}

        }
    }

    @endphp
        @if($Allbn>0 && mb_strlen($passw)>0)

            <div align='center'>
                <table style="width:100%;"><tr><td align=center width=500>
                    <table><tr><td align=left width=450><br /><br /><h3> {{ __('messages.fadding') }}</h3><br /><br /><br />
                    </td></tr></table>
                </td></tr></table>

                <form method="POST" name=login4 action="{{ route('login') }}">
                    @csrf
                    <table><tr><td align=right>
                        E-mail:</td><td><div class="box"><input id="email" size=20 maxlength=50  type="email"  name="email" value="{{ $emailf }}" required autofocus></div></td></tr>
                        <tr><td>{{ __('messages.passw') }}:</td><td><div class="box"><input id="password" size=20 maxlength=50  name="password" value="{{ $passw }}" ></div></td></tr>
                        <tr><td></td><td><input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('messages.remember') }}<br /><br /> </td></tr>
                        <tr><td></td><td class=fcomblue><ul class=intop><li><a onclick="sendform()">{{ __('messages.logon') }}</a></li></ul>
                    </td></tr></table><br />
                </form>
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('messages.fogpas') }}
                    </a>

                @endif
            </div>
        @endif
        @if($Allbn2==0)

            <div align='center'>
                <table style="width:100%;"><tr><td align=center width=500>
                            <table><tr><td align=left width=450><br /><br /><h3> {{ __('messages.fadding') }}</h3><br /><br /><br />
                                    </td></tr></table>
                        </td></tr></table>
                <form method="POST" name=login4 action="{{ route('login') }}">
                    @csrf
                    <table><tr><td align=right>
                                E-mail:</td><td><div class="box"><input id="email" size=20 maxlength=50  type="email"  name="email" value="{{ $emailf }}" required autofocus></div></td></tr>
                        <tr><td>{{ __('messages.passw') }}:</td><td><div class="box"><input id="password" size=20 maxlength=50  name="password" value="{{ $psw }}" ></div></td></tr>
                        <tr><td></td><td><input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('messages.remember') }}<br /><br /> </td></tr>
                        <tr><td></td><td class=fcomblue><ul class=intop><li><a onclick="sendform()">{{ __('messages.logon') }}</a></li></ul>
                            </td></tr></table><br />
                </form>
            </div>
        @endif



@else
    @php $stepreg4 = __('messages.stepreg4');
    $lanem = App::currentLocale();
  if($lanem == "ua"){$pre = "i";}
  if($lanem == "ru"){$pre = "ri";}
  if($lanem == "en"){$pre = "ei";}
  $id = Auth::user()->id;
  $link="$pre$id";


     @endphp
    <br /><br /><br /><div align='center'><a href =/{{$link}} > {{ $stepreg4 }} </a></div><br /><br /><br />
@php
echo "<html><head><meta http-equiv='refresh' content='1; url=/$link'></head></html>";
@endphp



@endguest




@endsection
