<!doctype html>
<html @yield('amp') lang="@php
    $loc=app()->getLocale();
    if($loc=="ua"){echo"uk";}
    else{echo $loc;}
@endphp">

@php
    $css_file = "/css/app75.css";

 @endphp
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="robots" content="@yield('robots')" />
    <meta name="facebook-domain-verification" content="x86v38nq0ps3jyiidq0ki4qg4g9mqu" />
    <meta property="og:image" content="@yield('image')" />
    <title>@yield('title_block')</title>
    @if (View::hasSection('amp'))
	<style amp-boilerplate>
        body{
            -webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;
            -moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;
            -ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;
            animation:-amp-start 8s steps(1,end) 0s 1 normal both}
        @-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
        @-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
        @-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
        @-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
        @keyframes -amp-start{from{visibility:hidden}to{visibility:visible}
        }


	</style>
        @hasSection('amp_img')
            <link rel="preload" as="image" href="@yield('amp_img')">
        @endif
        <style amp-custom>
            body {
                background-color: #f2f2f2;
                COLOR:#29476b;
                font-family: Verdana;
            }
            .body {
                list-style-type: square;
            }

            img {
                max-width: 100%;
                width: auto\9; /* ie8 */
                vertical-align: top;
            }
            .img {
                max-width: 100%;
                height: auto;
            }

            body, form { margin:0; padding:0; }
            ul { padding-left:0;}

            a {
                color: #2a507e;
                text-decoration: none;
                cursor: pointer;
                transition: color 0.3s ease;
            }
            a:Active {
                color: #ff9966;
            }
            a:Hover {
                color: #000000;
            }


            .scale img {
                transition: 0.5s;
                display: block;
            }
            .scale img:hover {
                transform: scale(1.1);
            }


            .colored{
                color: #2a507e;
                background: rgb(242, 242, 255);
                transition: color 0.3s ease;
                transition: background 0.3s ease;
            }
            .colored:hover {
                background: white;
                color: #111;
            }

            h1 {
                font-size: 170%;
                font-style: normal;
                font-variant: normal;
                font-weight: 500;
                margin:10px 0 10px 0;
            }
            h2 {
                font-size: 150%;
                font-style: normal;
                font-variant: normal;
                font-weight: 500;
                margin:9px 0 9px 0;
            }

            h3 {
                font-size: 130%;
                font-style: normal;
                font-variant: normal;
                font-weight: 500;
                margin:8px 0 8px 0;
            }
            h4 {
                font-size: 120%;
                font-style: normal;
                font-variant: normal;
                font-weight: 400;
                margin:2px 0 2px 0;
            }
            h5 {
                font-size: 110%;
                font-style: normal;
                font-variant: normal;
                font-weight: 400;
                margin:2px 0 2px 0;
                line-height: 1.5;
            }
            h6 {
                font-size:50%;
                font-family: Verdana, sans-serif;
                color:gray;
            }


            .fcom  {

                background: rgb(242,242,255); /* Old browsers */
                /* IE9 SVG, needs conditional override of 'filter' to 'none' */
                background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2YyZjJmZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNlMWUzZjIiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+); /* FF3.6+ */ /* Chrome,Safari4+ */ /* Chrome10+,Safari5.1+ */ /* Opera 11.10+ */ /* IE10+ */
                background: linear-gradient(to bottom,  rgba(242,242,255,1) 0%,rgba(225,227,242,1) 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2f2ff', endColorstr='#e1e3f2',GradientType=0 ); /* IE6-8 */
                box-shadow: 2px 2px 6px 1px rgba(0,0,0,0.53);
            }



            .fcom0  {
                border: groove #2a507e;
                border-width: 1px;
                background: white;
                box-shadow: 2px 2px 6px 1px rgba(0,0,0,0.53);
            }

            .fcomblue {
                border: groove #2a507e;
                border-width: 1px;
                border-radius: 3px;
                background: rgb(135,197,221);
                background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzM1NmFhMCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiMzNTZhYTAiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+); /* FF3.6+ */ /* Chrome,Safari4+ */ /* Chrome10+,Safari5.1+ */ /* Opera 11.10+ */ /* IE10+ */
                background: linear-gradient(to bottom, rgba(53,106,160,1) 0%,rgba(53,106,160,1) 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#356aa0', endColorstr='#356aa0',GradientType=0 ); /* IE6-8 */
                box-shadow: 0 0;
                transition: box-shadow 0.3s ease;
            }
            .fcomblue:hover {
                box-shadow: 2px 2px 6px 1px rgba(0,0,0,0.53);
            }


            .intop  {
                text-align: center;
                line-height: 7px;
                margin:0;
                list-style: none;
                height: 100%;
                padding: 5px 0 0 0;
            }


            ul.intop li {
                display: inline;
                padding-top:10px; margin:0;
            }
            ul.intop_left li {
                display: inline;
                padding-top:0; margin:0;
            }
            ul.intop_right li {
                display: inline;
                padding-top:0; margin:0;
            }

            ul.intop a {
                font-weight: bold;
                font-size:11px;
                height: 13px;
                display:block;
                margin: auto 0;
                padding: 2px;
                color: #DAE1E8;
                transition: color 0.3s ease;
            }
            ul.intop a:hover {
                color: white;
                text-decoration:underline;
            }
            td.intop a {
                font-weight: bold;
                font-size:12px;
                height: 13px;
                display:block;
                margin: auto 0;
                padding: 2px;
                color: #DAE1E8;
                transition: color 0.3s ease;
            }
            @media screen and (max-width: 400px) {
                td.intop a {
                    font-size: 11px;
                }
            }
            td.intop a:hover {
                color: white;
                text-decoration:underline;
            }
            button.intop a {
                font-weight: bold;
                font-size:12px;
                height: 13px;
                display:block;
                margin: auto 0;
                padding: 2px;
                color: #DAE1E8;
                transition: color 0.3s ease;
            }
            button.intop a:hover {
                color: white;
                text-decoration:underline;
            }



            @media screen and (min-width: 768px) {
                TABLE, div, section { FONT-SIZE: 12px;}
            }
            @media screen and (max-width: 768px) {
                .hidblok {display: none;}
                li.hidblok {display: none;}
                TABLE, div, section { FONT-SIZE: 13.5px;}
            }

            @media screen and (min-width: 769px) {
                .hidblokwide {display: none;}
                li.hidblokwide {display: none;}
            }
            @media screen and (max-width: 990px) {
                .hidblok-extra-wide {display: none;}
                li.hidblok-extra-wide {display: none;}
            }
            @media screen and (min-width: 990px) {
                li.enter {display: none;}
            }
            @media screen and (max-width: 440px) {
                li.forgot-pwd {display: none;}
            }



            .menu {
                display: flex;
                align-items: center;
                justify-content: center;
                position: fixed;
                text-align: center;
                width: 100%;
                gap: 20px;
                top: 0;
                z-index: 101;
                padding: 10px 20px 10px 0;
            }


            .submenu{
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 7px;
                width: 100%;
            }
            @media screen and (min-width: 768px) {
                .submenu{width: 50%; }
            }
            @media screen and (min-width: 1300px) {
                .submenu{gap: 15px;}
            }

            .intopmenu  {

                text-align: center;
                line-height: 7px;
                margin:0;
                list-style: none;
                height: 100%;
                padding: 0;
            }

            ul.intopmenu a {
                font-weight: bold;
                font-size:13px;
                line-height: 1.14;
                height: 22px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 4px 8px 4px 8px;
                color: #DAE1E8;
            }
            @media screen and (min-width: 1200px) {
                ul.intopmenu a {
                    padding: 4px 30px 4px 30px;
                }
            }
            ul.intopmenu a:hover {color: white; text-decoration:underline;}

            .menu-item:hover {
                background: white;
            }


            .maxwide {
                text-align: center;
                max-width: 990px;
                margin: 0 auto;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                gap: 10px;
            }

            #viber, #whatsapp, #facebook, #telegram, #twitter {
                fill: black;
                transition: fill 0.3s;
            }

            #viber:hover,
            #viber:focus{
                fill: #7360F2;
            }
            #whatsapp:hover,
            #whatsapp:focus{
                fill: #25D366;
            }
            #facebook:hover,
            #facebook:focus{
                fill: #1877F2;
            }
            #telegram:hover,
            #telegram:focus{
                fill: #27A6E7;
            }
            #twitter:hover,
            #twitter:focus{
                fill: #2DAAE1;
            }
            #social-madia{
                padding-top: 10px;
                display: flex;
                gap: 10px;
            }
            .social-madia{
                padding-top: 10px;
                display: flex;
                flex-wrap: wrap;
                gap: 7px;
            }

            .sear-tit {
                padding: 0 15px 5px;
                max-width: 438px;
                margin-bottom: 10px;
                line-height: 40px;
            }
            .sear-tit a {
                padding: 10px;
                color: rgb(242, 242, 255);
                font-size: 14px;
                font-weight: bold;
                border-radius: 3px;
                background-color: #356AA0;
                transition: color, box-shadow 0.3s ease;
            }
            .sear-tit a:hover {
                color: #fff;
                box-shadow: 2px 2px 6px 1px rgba(0,0,0,0.53);
                text-decoration:underline;
            }


            p {
                text-indent: 0;
            }
            p a {
                padding: 1px;
                color: rgb(242, 242, 255);
                background-color: #356AA0;
                text-decoration: none;
                transition: color, box-shadow 0.3s ease;
            }
            p a:hover {
                color: #fff;
                box-shadow: 2px 2px 6px 1px rgba(0,0,0,0.53);
                text-decoration:underline;
            }
        </style>
	<noscript>
		<style amp-boilerplate>
		body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}
		</style>
	</noscript>

    @else
        <link rel="stylesheet" href="{{$css_file}}">
    @endif
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="canonical" href="@yield('canonical')" />

    @if (View::hasSection('amp'))
        <script async src="https://cdn.ampproject.org/v0.js"></script>
    @else
        <script src="/js/jquery-3.5.1.min.js" defer></script>
    @endif
    @stack('scripts')
</head>
<body>
@if (!View::hasSection('amp'))
    <script src="{{ "/js/allcities23.js" }}" defer></script>
@endif


@php
    if(isset($_COOKIE['my_cookie'])){$my_cookie = $_COOKIE['my_cookie'];}
    else {$my_cookie = "";}
@endphp
@if($my_cookie !== "0")


        @if (!View::hasSection('amp'))
            <div id="my_cookie" class="cookie fcom">
                <noindex>
                    <p>{{__('messages.lic_cookie1')}} </p>
                    <div onclick="mem_arguem('more-cookies','less-cookies')" id="less-cookies">{{__('messages.nnext')}}</div>
                    <div id="more-cookies" class="un-display"> {{__('messages.lic_cookie2')}}
                        <p> {{__('messages.lic_cookie3')}}</p>
                        <p> <a href="/policy/{{__('messages.lan')}}"><strong>{{__('messages.lic_cookie4')}}</strong></a></p>
                    </div>
                    <p><span onclick=hid_cookie()><b>{{__('messages.lic_cookie5')}}</b></span></p>
                </noindex>
            </div>
        @endif

    </div>
@endif


@php

    /*

    <div id=adbl style="display: none;">
        <div class="adbl" style="width: 100%; margin: 0 auto; text-align: center;">
            <table style="width:100%;"><tr><td style="width:15%;" align=center class=fcom0><br />
                        @if($lan=="ua")<noindex><b>Виялено блокування реклами - єдиного джерела доходу сайту 1ua. <br />Будь ласка, вимкніть (у своєму браузері, операційній системі чи локальній мережі) блокування реклами для нашого сайту. <br />Інакше, ми будемо вимушені блокувати для Вас дані соцмережі.<br /><div class="hidblok"><img height=300 src="/images/adbl.png"></div><br /><a onclick=hid_adbl()> приховати </a></b></noindex>@endif
                        @if($lan=="ru")<noindex><b>Обнаpужена блокиpовка pекламы - единственного источника дохода сайта 1ua.<br /> Пожалуйста, отключите (в своём бpаузеpе, опеpационной системе или локальной сети) блокиpовку pекламы для нашего сайта.<br /> В противном случае, мы будем вынуждены блокиpовать для Вас данные соцсети.<br /><div class="hidblok"><img height=300 src="/images/adbl.png"></div><br /><a onclick=hid_adbl()> скрыть </a></b></noindex>@endif
                        @if($lan=="en")<noindex><b>An ad blocking was detected - the only source of revenue for the 1ua site.<br /> Please disable (in your browser, operating system or local network) blocking of advertising for our site.<br />If you save ad blocking, we will be forced to block social network data for you.<br /><div class="hidblok"><img height=300 src="/images/adbl.png"></div><br /><a onclick=hid_adbl()> hide </a></b></noindex>@endif
                        <br /><br />
                    </td></tr></table>
        </div>
    </div>

    <script>

        function hid_adbl(){
            document.getElementById("adbl").style.display ='none';
        }
        function detectAdb()
        {
            var banner = document.getElementById('adsbygoogle');
            var ch=banner.currentStyle || window.getComputedStyle(banner, null);
            ch=parseInt(ch.height);
            if (isNaN(ch) || (ch == 0))
            {
                document.getElementById("adbl").style.display ='block';
            }

        }
        setTimeout("detectAdb();", 3000);


    </script>
    */
    // $filename = storage_path('app/public/ip.txt');
    // // $filename = "storage/ip.txt";
    $fc = $_SERVER['REQUEST_URI'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $m_new = "$ip $fc ";

    // $newfile = @fopen($filename, "a");

    // // if ($newfile) {
    //     @fwrite($newfile, $m_new);
    //     @fclose($newfile);
    // // }

    $filename = storage_path('app/public/ip.txt');

    $fp = fopen($filename, 'a');

    if ($fp) {
        flock($fp, LOCK_EX);

        fwrite($fp, $m_new);

        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

@endphp

@include('inc.top_unreg')
@auth
    @php
    $lan_user = App::currentLocale();
    if($lan_user){
        $Numm = Auth::user()->id;
        $Imm = Auth::user()->Im;
        $Prizm = Auth::user()->Priz;
        $Num_am = Auth::user()->avatar;
        $Num_aym = Auth::user()->avy;
        $Num_axm = Auth::user()->avx;
        last_visit_write($Numm, $Imm, $Prizm, $Num_am, $lan_user, $fc, $Num_aym, $Num_axm);
    }
    @endphp
@endauth
<main style="margin-top: 65px;">

    @if(strstr($ip,"66.249.")=="" && strstr($ip,"87.250.")=="" && strstr($ip,"94.130.")==""  && strstr($ip,"136.243.")==""
      && strstr($ip,"148.251.")==""  && strstr($ip,"78.46.")==""  && strstr($ip,"5.9.")=="" && strstr($ip,"95.216.")==""
      && strstr($ip,"167.86.")=="" && strstr($ip,"184.72.")=="" && strstr($ip,"95.108.")=="" && strstr($ip,"207.46.")==""
      && strstr($ip,"66.102.")=="" && strstr($ip,"212.109.")=="" && strstr($ip,"82.145.")=="" && strstr($ip,"144.76.")==""
      && strstr($ip,"213.180.")=="" && strstr($ip,"5.189.")=="" && strstr($ip,"173.212.")=="" && strstr($ip,"91.242.")==""
      && strstr($ip,"40.77.")=="" && strstr($ip,"157.55.")=="" && strstr($ip,"89.208.")=="" && strstr($ip,"95.163.")==""
      && strstr($ip,"17.58.")=="" && strstr($ip,"35.153.")=="" && strstr($ip,"5.45.")=="" && strstr($ip,"54.36.")==""
      && strstr($ip,"216.244.")=="" && strstr($ip,"151.80.")=="" && strstr($ip,"5.196.")=="" && strstr($ip,"141.8.")==""
      && strstr($ip,"5.255.")=="" && strstr($ip,"178.154.")=="" && strstr($ip,"37.9.")==""  && strstr($ip,"157.55.39")==""
      && strstr($ip,"207.46.13")=="" && strstr($ip,"40.77.167")=="" && strstr($ip,"?13.66.139")==""
      && strstr($ip,"13.66.144")=="" && strstr($ip,"?52.167.144")=="" && strstr($ip,"13.67.10")==""
      && strstr($ip,"?13.69.66.")=="" && strstr($ip,"13.71.172")=="" && strstr($ip,"139.217.52")==""
      && strstr($ip,"191.233.204")=="" && strstr($ip,"20.36.108")=="" && strstr($ip,"20.43.120")==""
      && strstr($ip,"40.79.131")=="" && strstr($ip,"40.79.186")=="" && strstr($ip,"??52.231.148")==""
      && strstr($ip,"?51.8.235")=="" && strstr($ip,"51.105.67")=="")
        @php $lan = App::currentLocale(); @endphp

    @endif

@auth
    @php
    $_mktmy = microtime(true);

    $my_domen = $_SERVER['SERVER_NAME'];
    $server_ip = $_SERVER['SERVER_ADDR'];
    if($my_domen=="1ua.com.ua" || $server_ip == "75.119.153.245"){
        $ggg = Auth::user()->id;
        if($ggg == "72372396"){
            $load = sys_getloadavg();
            // Округлення кожного значення до 2 знаків після коми
            $load1 = round($load[0], 2);
            $load5 = round($load[1], 2);
            $load15 = round($load[2], 2);

            $ip_header = @file_get_contents(storage_path('app/public/ip.txt'), false, null, 0, 200);
            preg_match('/nip (\d+) nip_google (\d+)#/', (string) $ip_header, $ip_m);
            $nip = $ip_m[1] ?? 0;
            $nip_google = $ip_m[2] ?? 0;

            echo "<center>$load1 $load5 $load15 | $nip ($nip_google)</center>";
        }
    }
    $aktiv = Auth::user()->aktiv;
    $do_aktiv = __('messages.stepreg3');

        if ($aktiv != 1 && strstr($_SERVER['REQUEST_URI'], "/settings")==""){echo"<style>TABLE { COLOR:#29476b; FONT-FAMILY: \"Verdana\"}
             A { color : #2a507e; font-family : Verdana; text-decoration : none; }
                A:Active { color : #FF9966; } A:Hover { color : #000000; } </style>
                <div align='center'><table style=\"width:100%;\"><tr><td align=center width=500>
                <table><tr><td align=left width=450><br /><br /><h3> $do_aktiv</h3><br /><br /><br />
                </td></tr></table></td></tr></table></div>"; exit;
        }
    @endphp
	@if (!View::hasSection('amp'))
		<script>
		function delnotice() {
			$.ajax({
				type: 'POST',
				url: '/del_notice',
				cache: false,
				contentType: false,
				processData: false
			});
			document.getElementById("notice_in").style.display = 'none';
		}


		var el=0;
		var nume=1;
		var numef=0;
		function load_notice() {

			$.ajax({
				type: 'POST',
				url: '/load_notice',
				cache: false,
				contentType: false,
				processData: false,
				success: function (data) {

					el = data.length;
					if (el > 10) {
						document.getElementById("notice_in").style.display = 'block';
						if (nume < 3) {
							if (numef != 0) {
								data= data.replace("<a onclick=mem_arguem('deln','mainn') class=shutover> </a>", "");
							} else {
								numef = 1;
							}
							document.getElementById("notice_in").innerHTML += data;
						} else {
							document.getElementById("notice_in").innerHTML = data;
							nume = 0;
						}
						nume++;
					}
				}
			});
		}
		setInterval(function() {
			if (!document.hidden) {
				load_notice();
			}
		}, 3000);
		</script>
	@endif
@endauth


@yield('content')

@if (!View::hasSection('amp'))
<script>
    function shut_abf() {
        $('#overlay_abf').delay(100).hide(1);
        document.getElementById("abf_load").style.display ='none';
    }
    function shut_main() {
        $('#overlay').delay(100).hide(1);
        document.getElementById("add_load").style.display ='none';
    }

</script>

<div id="abf_load" class="un-display" >
    <div id="f_in" class="popup-body">
    </div>
</div>

<div id="add_load" class="un-display" >
    <div id="add_script_center">
        <table>
            <tr><td align=right width = 800 class=fcom>&nbsp;&nbsp;<span onclick=shut_main();><b>{{__('messages.Close')}}</b></span>&nbsp;&nbsp;
                </td></tr>
            <tr><td>
                <div id="add_script_center2" style="text-align: center; background-color: white; max-height: 500px; overflow-y: auto;"></div>
            </td></tr>
        </table>
    </div>
</div>

<section id="notice_center" >
    @include('inc.messages')
</section>

<a href=# aria-label="{{__('messages.close_pop_up')}}" onclick="shut_main(); return false;"><div id="overlay"></div></a>
<a href=# aria-label="{{__('messages.close_pop_up')}}" onclick="shut_abf(); return false;"><div id="overlay_abf"></div></a>

@guest @else
    <div id="notice_in" style="color: white;  position: fixed; bottom: 50px; left: 50px; z-index : 666666666;"></div>
    @endguest
<br />

<div id="scrollup" class="move_up">
	<img src="/images/up.png" title="{{__('messages.move_up')}}" />
</div>
@endif

    @stack('scriptsdown')
    @php

if(Auth::user()) {
    $Numm =  Auth::user()->id;
    if($Numm == 72372396){
    // echo"<br /><center> "; $_mktmy2 = microtime(true); echo round($_mktmy2 - $_mktmy,5);  echo" </center>";
    }
}
        @endphp
</main>
@include('inc.down')

@if (!View::hasSection('amp'))
	@php
        if(isset($GLOBALS['indexwindowonload'])){
            $indexwindowonload = $GLOBALS['indexwindowonload'];
        }
        else{$indexwindowonload="stop";}
        if(isset($GLOBALS['cwindowonload'])){
            $cwindowonload = $GLOBALS['cwindowonload'];
        }
        else{$cwindowonload="stop";}
        if(isset($GLOBALS['iwindowonload'])){
           $iwindowonload = $GLOBALS['iwindowonload'];
        }
        else{$iwindowonload="stop";}
        if(isset($GLOBALS['mview_windowonload'])){
           $mview_windowonload = $GLOBALS['mview_windowonload'];
        }
        else{$mview_windowonload="stop";}

        if(isset($GLOBALS['regwindowonload'])){
           $regwindowonload = $GLOBALS['regwindowonload'];
        }
        else{$regwindowonload="stop";}
	@endphp

	@if($mview_windowonload == "stop")
		<script>
			window.onload = function() {
				var scrollUp = document.getElementById('scrollup');
				scrollUp.onmouseover = function() {
					scrollUp.style.opacity=0.5;
					scrollUp.style.filter  = 'alpha(opacity=30)';
				};
				scrollUp.onmouseout = function() {
					scrollUp.style.opacity = 0.3;
					scrollUp.style.filter  = 'alpha(opacity=50)';
				};

				scrollUp.onclick = function() {
					window.scrollTo(0,0);
				};

				window.onscroll = function () {
					if (window.pageYOffset > 100 ) {
					scrollUp.style.display = 'block';
					scrollUp.style.opacity = 0.2;
					}
					else {
					scrollUp.style.display = 'none';
					}
				}
            @if($indexwindowonload == "go")

                function getStats() {

                    var oblElements = document.querySelectorAll('[id^="genOblViews"]');
                    var rayElements = document.querySelectorAll('[id^="genRayViews"]');
                    var idElements = document.querySelectorAll('[id^="genIdViews"]');
                    var export_id = document.getElementById("export_id").innerHTML;
                    if (oblElements.length > 0) {

                        $.ajax({
                            url: 'stats_obl',
                            type: 'get',
                            success: function(data) {
                                data.forEach(function(item) {
                                    var id = item.id;
                                    var views = item.views;
                                    var currentViews = parseInt($('#oblViews' + id).text());

                                    $('#oblViews' + id).text(views);
                                    if (views > 0) {
                                        $('#genOblViews' + id).css('display', 'inline-block');
                                    }
                                    var inDif = views - currentViews;
                                    var inDifcss = inDif;
                                    if(inDifcss>10){inDifcss=10;}
                                    if (inDif > 0) {
                                        $('#inDif' + id).fadeOut(function() {
                                            $(this).text('+' + inDif).fadeIn();
                                            var scaleValue = inDifcss*2+3;
                                            var topValue = -20-(inDifcss*3.5);
                                            $('#inDif' + id).css({ 'padding': scaleValue + 'px', 'top': topValue + 'px'}).fadeIn();
                                        });
                                    } else {
                                        $('#inDif' + id).fadeOut();
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }

                        });

                    }
                    else if (rayElements.length > 0) {

                        var formData = {
                            obl: export_id
                        };
                        $.ajax({
                            url: 'stats_ray',
                            type: 'get',
                            data: formData,
                            cache: false,
                            success: function(data) {

                                data.forEach(function(item) {
                                    var id = item.id;
                                    var views = item.views;
                                    var currentViews = parseInt($('#rayViews' + id).text());

                                    $('#rayViews' + id).text(views);
                                    if (views > 0) {
                                        $('#genRayViews' + id).css('display', 'inline-block');
                                    }
                                    var inDif = views - currentViews;

                                    var inDifcss = inDif;
                                    if(inDifcss>10){inDifcss=10;}
                                    if (inDif > 0) {
                                        $('#inDif' + id).fadeOut(function() {
                                            $(this).text('+' + inDif).fadeIn();
                                            var scaleValue = inDifcss*2+3;
                                            var topValue = -20-(inDifcss*3.5);
                                            $('#inDif' + id).css({ 'padding': scaleValue + 'px', 'top': topValue + 'px'}).fadeIn();
                                        });
                                    } else {
                                        $('#inDif' + id).fadeOut();
                                    }

                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }

                        });

                    }
                    else if (idElements.length > 0) {

                        var formData = {
                            rayc: export_id
                        };
                        $.ajax({
                            url: 'stats_id',
                            type: 'get',
                            data: formData,
                            cache: false,
                            success: function(data) {
                                data.forEach(function(item) {
                                    var id = item.city_id;
                                    var views = item.views;
                                    var currentViews = parseInt($('#idViews' + id).text());

                                    $('#idViews' + id).text(views);
                                    if (views > 0) {
                                        $('#genIdViews' + id).css('display', 'inline-block');
                                    }
                                    var inDif = views - currentViews;

                                    var inDifcss = inDif;
                                    if(inDifcss>10){inDifcss=10;}
                                    if (inDif > 0) {
                                        $('#inDif' + id).fadeOut(function() {
                                            $(this).text('+' + inDif).fadeIn();
                                            var scaleValue = inDifcss*2+3;
                                            var topValue = -20-(inDifcss*3.5);
                                            $('#inDif' + id).css({ 'padding': scaleValue + 'px', 'top': topValue + 'px'}).fadeIn();
                                        });
                                    } else {
                                        $('#inDif' + id).fadeOut();
                                    }

                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }

                        });

                    }


                }
                getStats();
                setInterval(function() {
                    if (!document.hidden) {
                        getStats();
                    }
                }, 3000);

            @endif

			@if($iwindowonload == "go")

				$.ajaxSetup({
					headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
				});
					var id_vote=document.getElementById("id_page").innerHTML;
					var rate=document.getElementById("rate").innerHTML;
					var fc=document.getElementById("fc").innerHTML;


					var formData = {
						idpage: id_vote,
						rate: rate,
						fc: fc,
					};

					$.ajax({
						type: 'POST',
						url: '/up_vote',
						data: formData,
						cache: false
					});

			@endif
			@if($cwindowonload == "go")
				$.ajaxSetup({
					headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
				});
                var id_vote=document.getElementById("id_page").innerHTML;
                var rayc_vote=document.getElementById("rayc_page").innerHTML;
                var obl_vote=document.getElementById("obl_page").innerHTML;


                var rate=document.getElementById("rate").innerHTML;
					var fc=document.getElementById("fc").innerHTML;

					var formData = {
                        obl_vote: obl_vote,
                        rayc_vote: rayc_vote,
						idpage: id_vote,
						rate: rate,
						fc: fc,
					};

					$.ajax({
						type: 'POST',
						url: '/up_votec',
						data: formData,
						cache: false
					});
			@endif


            @if($regwindowonload == "go")

                let qobl = document.getElementById("obl").value;
                let qrayc = document.getElementById("qrayc").value;
                let qidc = document.getElementById("qidc").value;

                if(qobl>0){
                    $.ajaxSetup({
                        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                    });
                    var formData = {
                        nobl: qobl,
                        qrayc: qrayc,
                    };

                    document.getElementById("hrayc").style.display ='block';
                    $.ajax({
                        type: 'POST',
                        url: '/rayc',
                        data: formData,
                        cache: false,
                        success:function(data){
                            data = JSON.stringify(data);
                            document.getElementById("rayc").innerHTML=data;

                            if(qrayc>0){
                                document.getElementById("hidc").style.display ='block';
                                $.ajaxSetup({
                                    headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                                });
                                var formData = {
                                    rayc: qrayc,
                                    qidc: qidc,
                                };


                                $.ajax({
                                    type: 'POST',
                                    url: '/idc',
                                    data: formData,
                                    cache: false,
                                    success:function(data){
                                        data = JSON.stringify(data);
                                        document.getElementById("idc").innerHTML=data;

                                    }
                                });
                            }
                        }
                    });
                }

            @endif
			}
		</script>
	@endif
@endif

</body>
</html>
