@extends('layouts.app')
@section('title_block'){{ __('messages.mtit') }}@endsection
@php
    global $indexwindowonload;
    $indexwindowonload = "go";
    $index_go = "index,follow";
    $description = __('messages.meta-index-desc');
    $keywords = __('messages.meta-index-keys');

    $my_domen = $_SERVER['SERVER_NAME'];
    $lan = App::currentLocale();
    $canonical = "https://";
    $canonical.=$my_domen;
    if($lan == "ru" || $lan == "en"){$canonical.= "/"; $canonical .= $lan;}
@endphp
@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('canonical'){{$canonical}}@endsection
@section('content')

    @php
 //   phpinfo();
// print_r(get_loaded_extensions());

if(Auth::user()) {

       $ggg =  Auth::user()->id;
    if($ggg == "72372396"){
$start_time = microtime(true);

/*

$qq = "2024%";
        $Alltest = DB::table('Foto')
        ->select('Namef', 'Fd')
        // ->where('Fd', 'like', $qq)
        ->where('w', '=', 0)
        ->orderBy('Fd', 'asc')
        ->limit(10000)
         ->get();
        $Alltestn = $Alltest->count();
        // echo "Кількість рядків : " . $Alltestn . "<br>" ;

        foreach ($Alltest as $Alf) {
            $Namef=$Alf->Namef;
            $Fd=$Alf->Fd;
            // echo"$Fd $Namef";
            $wh = DB::table('foto_size_no_null')
            ->select('w','h')
            ->where('Namef', '=', $Namef)
            ->limit(1)
             ->get();
             $whn = $wh->count();
             if($whn==0){
                DB::table('Foto')
                ->where('Namef', $Namef)
                ->update(['w' => -1, 'h' => -1]);
             }
             else{
                foreach ($wh as $l) {
                $w=$l->w;
                $h=$l->h;
                DB::table('Foto')
                ->where('Namef', $Namef)
                ->update(['w' => $w, 'h' => $h]);
            }
             }


		}
*/
/*
$qq = "2016%";
        $Alltest = DB::table('Foto')
        ->select('Namef','Fd','Formf')
        ->where('Fd', 'like', $qq)
        ->where('w', '=', -1)
        ->orderBy('Fd', 'asc')
        ->limit(100)
         ->get();
        $Alltestn = $Alltest->count();
        echo "Кількість рядків $qq: " . $Alltestn . "<br>" ;

        foreach ($Alltest as $Alf) {
            $Namef=$Alf->Namef;
            $M6=$Alf->Fd;
            $M7=$Alf->Formf;

            $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
            if ($monm<10){$monmf = substr($M6, 6, 1);}
            else{$monmf=$monm;}
            if($yem<=2007){$yem = "2005-2007"; $monmf="";}

            $filename = "Photos/$yem$monmf/b$Namef.$M7";
            if (Storage::disk('s3')->exists($filename)) {
                $absolutePath = Storage::disk('s3')->url($filename);
                 echo" exists  $filename  ";

                    $imageInfo = getimagesize($absolutePath);
                if ($imageInfo !== false) {
                    $avheight = $imageInfo[1];
                    $avw = $imageInfo[0];
                    echo" w $avw h $avheight ";
                    // DB::table('Foto') ->where('Namef', $Namef) ->update(['h' => $avheight, 'w' => $avw]);
                } else {
                    echo "Не вдалося отримати інформацію про зображення.";
                    // DB::table('Foto') ->where('Namef', $Namef)  ->update(['h' => -1, 'w' => -1]);
                }

            }

            else{
                echo"<b>no exists</b> M6 $M6  nf$Namef  ";
                // echo" M6 $M6  nf$Namef  ";
                 // DB::table('Foto') ->where('Namef', $Namef)  ->update(['h' => -1, 'w' => -1]);

            }
		}

        $e_time = microtime(true);
$rt = $e_time - $start_time;
// echo"rt $rt";

*/





        // пошук і оновлення висоти Fotop в таблицю
        /*
        $Alltest = DB::table('Fotop')
        ->select('Namef','Fd','Formf')
        // ->where('Num', '=', "72372396")
        ->where('w', '=', 0)
        ->orderBy('Fd', 'desc')
        ->limit(200)
         ->get();
        $Alltestn = $Alltest->count();
        echo "Кількість рядків: " . $Alltestn;

        foreach ($Alltest as $Alf) {
            $Namef=$Alf->Namef;
            $M6=$Alf->Fd;
            $M7=$Alf->Formf;

            $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
            if ($monm<10){$monmf = substr($M6, 6, 1);}
            else{$monmf=$monm;}
            if($yem<=2007){$yem = "2005-2007"; $monmf="";}

            $katalogb = "Fotop/$yem$monmf/b$Namef.$M7";

            if (Storage::disk('public')->exists($katalogb)) {
                $katalogface=Storage::disk('public')->url($katalogb);
                $imageInfo = getimagesize($katalogface);

                if ($imageInfo) {
                    $avheight = $imageInfo[1];
                    $avw = $imageInfo[0];
                    echo"ni$Namef w $avw h $avheight ";

                    DB::table('Fotop')
                    ->where('Namef', $Namef)
                    ->update(['h' => $avheight, 'w' => $avw]);
                }

            }
            else{
               echo"no exists ni$Namef  ";
               // <img src=/storage/$imagePath0><br />

                    DB::table('Fotop')
                    ->where('Namef', $Namef)
                    ->update(['h' => -1, 'w' => -1]);

            }
		}
        */



// пошук і оновлення висоти аватоарк в таблицю



/*
        $Alltest = DB::table('users')
        ->select('id','avatar')
        // ->where('id', '=', "72372396")
        ->where('avx', '=', 0)
        ->where('avatar', '>', 0)
        ->orderBy('Md', 'desc')
        ->limit(1000)
         ->get();
        $Alltestn = $Alltest->count();
       //  echo "Кількість рядків: " . $Alltestn;

        foreach ($Alltest as $Alf) {
            $idtest=$Alf->id;
            $test_a=$Alf->avatar;
            $imagePath0 = 'avatar/b' . $test_a . '.jpg';

            if (Storage::disk('public')->exists($imagePath0)) {
                $katalog_url = Storage::disk('public')->url($imagePath0);
                $imageInfo = getimagesize($katalog_url);

                if ($imageInfo) {
                    $avheight = $imageInfo[0];

                    echo"$avheight ";
                    $textToAdd = "#!:*&$avheight";
                    $filetest = "storage/last_visit/$idtest.txt";
                    file_put_contents($filetest, $textToAdd, FILE_APPEND);

                    DB::table('users')
                    ->where('id', $idtest)
                    ->update(['avx' => $avheight]);
                }
                else{
                    DB::table('users')
                    ->where('id', $idtest)
                    ->update(['avx' => 0, 'avatar' => 0]);

                }

            }
            else{
                echo"no exists $test_a <img src=/storage/$imagePath0><br /> ";
                    DB::table('users')
                    ->where('id', $idtest)
                    ->update(['avy' => 0, 'avatar' => 0]);
            }
		}
*/

/*
        $Alltest = DB::table('Friends')
        ->select('Num2')
        // ->where('Num1', '=', "72372396")
        ->where('avx2', '=', 0)
        ->where('avatar2', '>', 10)
        ->orderBy('Md', 'desc')
        ->limit(5000)
         ->get();
        $Alltestn = $Alltest->count();
        echo "Кількість рядків: " . $Alltestn;

        foreach ($Alltest as $Alf) {
            $idtest=$Alf->Num2;
            // echo"idtest $idtest ";
            $Alltestava = DB::table('users')
            ->select('avx', 'avatar')
            ->where('id', '=', $idtest)
            ->limit(1)
             ->get();
             $Alltestu = $Alltestava->count();

            foreach ($Alltestava as $Alfa) {
                $avx=$Alfa->avx;
                $av=$Alfa->avatar;
                // echo"avx $avx av $av <br />";
                DB::table('Friends')
                ->where('Num2', $idtest)
                ->update(['avx2' => $avx]);
            }
		}
*/



/*
$results = DB::table('Memory')
    ->select('id','City', DB::raw('COUNT(*) as row_count'))
    ->where('id', '!=', 78498)
	->where('Md', '<', now()->subYear())
	->whereNull('City2')
	->whereNull('avt')
	->whereNull('Ip')
	->whereNull('Nameg')
	->whereNull('Whog')
	->groupBy('id', 'City')
    ->having('row_count', '>', 90)
    ->orderByDesc('row_count')
    ->limit(2)
    ->get();


foreach ($results as $result) {
    $idToDelete = $result->id;
    $CityToDelete = $result->City;
	$row_count = $result->row_count;
    echo " <a href=\"c$idToDelete\" target=_blank> rows $row_count,  id $idToDelete - $CityToDelete</a><br /> ";


    DB::table('Memory')
        ->where('id', $idToDelete)
        ->whereNull('City2')
        ->whereNull('avt')
        ->whereNull('Ip')
        ->whereNull('Nameg')
        ->whereNull('Whog')
        ->where('Md', '<', now()->subYear()) // now() повертає поточну дату та час, subYear() віднімає один рік
        ->delete();


}
		*/

    }
}
@endphp

<section id="ind-whole">
    <!-- google для головної сторінки -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
            crossorigin="anonymous"></script>

    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7495053896041990"
         data-ad-slot="4050982189"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <section class="mw450">
        <section class="ind-section fcom0">

            <section class="margin-top">
                <input type="text" class="search-input" id="cityInput" placeholder="{{__('messages.city_search')}}"><br />
                <ul class="non-list search-ul" id="cityDropdown"></ul>
            </section>

		@php

        $fff = ""; $All_ratef = 0; $All_ratem = 0;
        $Allb = DB::table('stat')->select('id','perc_f','perc_m','views')->
        where('id', '<', '26')->
        where('id', '>', '0')->
        orderBy('views','desc')->limit(25)->get();
        $All_rate = 0;

        foreach ($Allb as $All) {
            $id = $All->id; $perc_f = $All->perc_f; $perc_m = $All->perc_m; $views = $All->views;
            $All_ratef = $All_ratef+$perc_f;
            $All_ratem = $All_ratem+$perc_m;
            if(Auth::user()) {$mem_obl_link = "onclick=stat('$id','memory') rel=\"noopener noreferrer\"";}
            else{
                $ua_oble="";
                if($lan=="en"){$ua_oble="e";}
                else if($lan=="ru"){$ua_oble="r";}
                $mem_obl_link = "href=/" . $ua_oble . "se$id";
            }
            $oi = "messages.ooo$id"; $obl =__($oi);
            $link = "<a $mem_obl_link><div class=\"mb5\">$obl</div>";
            $link2 = "</a>";
            $fff .="<li class=\"stat-td\">$link
                <div class=\"stats-item\">$perc_f% </div>";
            if($views==0){$display="display: none;";}
            else{$display="";}
                $fff .="<div id=\"genOblViews$id\" class=\"stats-item stats-item-view\" style=\"$display\">
                        <svg style=\"margin-right: -2px;\" title='" . __('messages.views') . "' alt='" . __('messages.views') . "' width=\"12\" height=\"12\"><use href=\"/images/icons.svg#icon-magnifying-glass\"></use></svg>
                        <span id=\"oblViews$id\"> $views</span><span class=\"in-dif\" id=\"inDif$id\" ></span>
                    </div>";

                $fff .="$link2
            </li>";
        }

        $pref_page = __('messages.pref_page');
        $pref_page2 = $pref_page.="searc";
        if(Auth::user()) {$mem_link = "onclick=stat('0','memory') rel=\"noopener noreferrer\"";}
        else{
			$ua_uae="";
			if($lan=="en"){$ua_uae="e";}
			else if($lan=="ru"){$ua_uae="r";}
			$mem_link = "href=/" . $ua_uae . "searc";
			}
        @endphp

        <h1>{{__('messages.our_purp')}}</h1>
        <h2 class="h2-less"><a href=/{{$pref_page2}}>{{__('messages.all_cities')}}</a></h2>
        <div class="un-display" id="export_id"></div>
        <div id="stat">
            <table class="stat-tb">
                <tr><td class="fcom ind-button" onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'">
                    <b>{{__('messages.Foto')}} {{round($All_ratef/25)}}%</b>
                </td>
                <td class="fcomblue intop ind-button">
                    <a {{$mem_link}}> {{__('messages.records')}} {{round($All_ratem/25)}}%</a>
                </td></tr>
            </table>

            <ul class="stat-list">@php echo"$fff"; @endphp</ul>

        </div>


            @auth
                <div class="hidblokwide">
                    <div class="ind-txt">{{__('messages.do_fotos')}}</div>
                     <form id='search'  method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                        @csrf
                        <table class="righted-block margin-top">
                            <tr><td>
                                <input type="file" class="nineth-width" name="files[]" accept="image/jpeg" id="files" placeholder="Choose files" multiple  onchange=load_hid.style.display='block';>
                            </td><td >
                                <button type="submit" class="fcomblue intop ind-button-load" id="submit"><a>{{ __('messages.add_foto') }}</a></button>
                            </td></tr>
                        </table>
                    </form>
                    <div id="load_min" class="un-display margin-top">{{ __('messages.ch_foto') }}</div>
                    <div id="load_max" class="un-display margin-top">{{ __('messages.ch_foto10') }}</div>
                    <div id="load_hid" class="righted un-display margin-top">
                        {{ __('messages.Album') }}:<input type=text id=album0 size=23 maxlength=45 value=""><br />
                        {{ __('messages.adr_shot') }}:<input type=text id=Adrf0 size=23 maxlength=50><br />
                        {{ __('messages.date_shot') }}:<input type="date" max="{{date('Y-m-d')}}" id=Datef0 size=23 maxlength = 23><br />
                    </div>
                    <div id="load_on" class="un-display margin-top">
                        {{ __('messages.Loading_wait') }}<br />
                        <img SRC="/images/upload.gif"><br />
                        {{ __('messages.Loading_wait2') }}
                    </div>
                    <div id="load_foto"></div>
				</div>
            @endauth
        </section>



        <section class="ind-section fcom0 margin-top">

            @php

                $pref_page = __('messages.pref_page');
                $of_users = __('messages.of_users');
                $pref_page_inf = $pref_page.="infp";
                $pref_page = __('messages.pref_page');
                $pref_page_sear = $pref_page.="searc";
                $pref_page = __('messages.pref_page');
                $pref_page_i = $pref_page.="i";
                $of_Cityvil = __('messages.of_Cityvil');
                $join_us = __('messages.join_us');
                $filename = "storage/allstat.txt";
                $whattoread = @fopen($filename, "r");
                $file_contents = fread($whattoread, filesize($filename)); fclose($whattoread);

                $reg = strstr($file_contents,"reg");
                list($reg) = sscanf($reg, "reg%d");
                $Allc = strstr($file_contents,"Allc");
                list($Allc) = sscanf($Allc, "Allc%d");
            @endphp

            <h2>{{__('messages.we_up')}}</h2>
            <table class="margin-top">
                <tr>
                    <td class="fcomblue intop ind-button-padd min-text">
                        <a href=/{{$pref_page_inf}}>{{$of_users}}: {{$reg}}</a>
                    </td>
                    @auth
                        <td class="fcomblue intop ind-button-padd min-text">
                            <a href=/{{$pref_page_sear}}>{{$of_Cityvil}}: {{$Allc}}</a>
                        </td>
                    @endauth
                    @guest
                        <td class="fcomblue intop ind-button-padd min-text">
                            <a href=/register/{{$lan}}>{{$join_us}}</a>
                        </td>
                    @endguest
                </tr>
            </table>
            <br />
            <ul class="online-users">
            @php
                $Allu = DB::table('users')
                ->select('Num', 'Im', 'Priz', 'avatar', 'avx', 'avy')
                ->where('avatar',">",0)
                ->orderBy('l_visit','desc')
                ->limit(5)
                ->get();
            foreach ($Allu as $All) {
                $avt = $All->Num;
                $Im = $All->Im;
                $Priz = $All->Priz;
                $Num_a = $All->avatar;
                $avy = $All->avy;
                $avx = $All->avx;
				$user_icon = generateUserIcon($Num_a, $Im, $Priz, "online-users", $avx, $avy, "");

                echo"<li>
                        <a href=/$pref_page_i$avt>
							$user_icon
							<br />$Im
						</a>
                    </li>";
            }
            echo"</ul>";
            @endphp

        </section>

        <table class="fcom0 margin-top"><tr><td align=center width=438>
            @php
                $usefull_links = __('messages.usefull_links');
                if($lan=="ua"){echo"<a href=/lifeua/1>$usefull_links</a>";}
                if($lan=="ru"){echo"<a href=/liferu/1>$usefull_links</a>";}
            @endphp
        </td></tr></table>


        <!-- google для головної сторінки -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-7495053896041990"
             data-ad-slot="4050982189"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

    </section>
    <section class="mw450">

        <section class="ind-section fcom0">
            @php
                $writen = __('messages.writen');
                $writen2 = __('messages.writen2');
                $added1 = __('messages.added1');
                $added2 = __('messages.added2');
                $pref_page = __('messages.pref_page');
                $pref_page_i = $pref_page.="i";
                $Someone = __('messages.Someone');
                $in_album = __('messages.in_album');
                $fotom = __('messages.fotom');
                $appreciated1 = __('messages.appreciated1');
                $appreciated2 = __('messages.appreciated2');

                if(isset($_COOKIE['go_news'])){$go_news = $_COOKIE['go_news'];} else {$go_news = "111100";}
                $nforum = substr($go_news, 0, 1);
                $nfoto = substr($go_news, 1, 1);
                $nratef = substr($go_news, 2, 1);
                $ncoment = substr($go_news, 3, 1);
                $lnews = substr($go_news, 4, 2);
                $lnews1 = substr($lnews, 0, 1);
                if($lnews1==0){$lnews2 = substr($go_news, 5, 1);} else{$lnews2=$lnews;}
            @endphp
            <h1>{{__('messages.1ua_news')}}</h1>
            <nav id="news_block">
                <ul class="news_forum_ul">
                    <li><label class="news_forum_li">
                            <input type=checkbox onchange=ffnews(); id="cnforum" @php if($nforum!="0"){echo" checked";} @endphp >
                            <svg width="24" height="24"><use href="/images/icons.svg#icon-forum"></use></svg> {{__('messages.Forum')}}
                        </label></li>
                    <li><label class="news_forum_li">
                            <input type=checkbox onchange=ffnews(); id="cnfoto" @php if($nfoto!="0"){echo" checked";} @endphp>
                            <svg width="24" height="24"><use href="/images/icons.svg#icon-photo"></use></svg> {{__('messages.Foto')}}
                        </label></li>
                    <li @guest class="un-display" @endguest><label class="news_forum_li">
                            <input type=checkbox onchange=ffnews(); id="cnratef" @php if($nratef!="0"){echo" checked";}  @endphp>
                            <svg width="24" height="24"><use href="/images/icons.svg#icon-star-full"></use></svg> {{__('messages.Est')}}
                        </label></li>
                    <li><label class="news_forum_li">
                            <input type=checkbox onchange=ffnews(); id="cncoment" @php if($ncoment!="0"){echo" checked";} @endphp>
                            <svg width="24" height="24"><use href="/images/icons.svg#icon-comment"></use></svg>  {{__('messages.Comment')}}
                        </label></li>
                </ul>
                <aside id="news_forum_select">
                    <label><h2>{{__('messages.loc_news')}}</h2>
                        <select id="oblnew" onchange=ffnews()>;
                            @php
                                for ($i = 0; $i <= 25; $i++){
                                    $ni = "messages.ooo$i"; $no = "messages.chopt";
                                    echo"<option value=$i";
                                    if((int)$lnews2 == $i){echo" selected";}
                                    echo">";
                                    if($i==0){echo __($no);}
                                        else{echo __($ni);}
                                    echo"</option>";
                                }
                            @endphp
                        </select>
                    </label><br /><br />
                </aside>
            </nav>
        </section>

        <section id=news_result>

            @php
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
                if($ncoment!="0"){$q_s5[0] = ['act', 'ncoment'];
                $q_s6[0] = ['act', 'ncomentm'];
                }
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
                    orWhere(function ($query)
                     use ($q_s1, $q_s2, $q_s3, $q_s4, $q_s34,
                     $q_s5,
                      $q_s6,
                      $q_s7) {
                        $query->whereNull('act')
                            ->orWhere($q_s1)
                            ->orWhere($q_s2)
                            // ->orWhere(function ($query) use ($q_s2,$q_s22){$query->Where($q_s2)->Where($q_s22);})
                            ->orWhere(function ($query) use ($q_s3,$q_s34){$query->Where($q_s3)->Where($q_s34);})
                            ->orWhere(function ($query) use ($q_s4,$q_s34){$query->Where($q_s4)->Where($q_s34);})
                            ->orWhere($q_s5)
                            ->orWhere($q_s6)
                            ->orWhere($q_s7);
                    })
                    ->Where($q_s_mainp)
                    ->Where($q_s_mainp2)->
                    orderBy('Nd', 'desc')->
                    take(61)->
                    get();

                    $Allnn = $Alln->count();
                    if($Allnn>0) {

                        $nfm = 1;  $Nd_f_h=""; $act_old = ""; $titleh="";
                        $fortable = "shut"; $afortable = "shut"; $afmtable="shut";
                        $fotable = "shut"; $afotable="shut"; $acttable="shut";
                        $linef="go";  $nforum_e3 = ""; $nfoto_e3 = ""; $nratef_e3 = ""; $ncoment_e3="";

                        foreach ($Alln as $Alb) {
                            if ($nfm < 61) {

                                $theme = $Alb->theme; $ualine = $Alb->ualine; $ruline = $Alb->ruline; $enline = $Alb->enline;
                                $act = $Alb->act; $obl = $Alb->obl; $avt = $Alb->avt; $Im = $Alb->Im; $Priz = $Alb->Priz; $sex = $Alb->sex;
                                $Nd = $Alb->Nd; $whom = $Alb->whom; $forum = $Alb->forum; $avt_fr = $Alb->avt_fr;

                            $forum = preg_replace_callback(
                                '/(https?:\/\/[^\s<]+[^.,:;"\')\]\s<])/u',
                                function ($matches) {
                                    $url = $matches[0];
                                    $shortUrl = (strlen($url) > 35) ? substr($url, 0, 35) . "..." : $url;
                                    return '<a target="_blank" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"><b>' . htmlspecialchars($shortUrl, ENT_QUOTES, 'UTF-8') . '</b></a>';
                                },
                                $forum
                            );

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
                                    if($nfm==1 || $Nd_f_h!=$Nd_f){echo"<br /><h2>$title</h2>";}
                                    $linef="go"; $linec="go";
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

                                    $av_height="auto";
                                    $av_width=200;
                                    $page = last_visit_read($avt);
                                    if ($page) {
                                        $av_height = $page['av_h'] ?? null;
                                        $av_width = $page['av_w'] ?? null;
                                    }
                                    $online = "";
                                    $t = last_visit_ts_diff($page);
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
                                        $tf=1;
                                        $ttheme = "";
                                        $tpage = "";
                                        $tnpage = "";
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

                                    if($avt>7){
                                        $av_height="auto";
                                        $av_width=200;
                                        $page = last_visit_read($avt);
                                        if ($page) {
                                            $av_height = $page['av_h'] ?? null;
                                            $av_width = $page['av_w'] ?? null;
                                        }
                                        $online = "";
                                        $t = last_visit_ts_diff($page);
                                        if ($t <= 500 && $my_id != $avt) {
                                            $online = "online";
                                        }
                                        $user_icon = generateUserIcon($Num_a, $Im, $Priz, "forum", $av_width, $av_height, $online);
                                        $av_avt = "<a href=/$pref_page_i$avt>$user_icon <b>$Im $Priz</b></a>";
                                    }

                                    $avtall = mb_strstr($forum,"*&^@");
                                    list($avt_old) = sscanf($avtall, "*&^@%d");

                                    if($avt_old>0){

                                        $pageq = last_visit_read($avt_old);

                                        $Imq = $pageq['im'] ?? ''; $Prizq = $pageq['priz'] ?? ''; $Num_aq = $pageq['avatar'] ?? '';

                                        $av_height = $pageq['av_h'] ?? "auto";
                                        $av_width = $pageq['av_w'] ?? 200;

                                        $online = "";
                                        $t = last_visit_ts_diff($pageq);
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
                        } // перелік всіх новин

                        if($afmtable=="open"){echo"</td></tr></table>"; $afmtable="shut";}
                        if($fotable=="open"){echo"</tr>"; $fotable="shut";}
                        if($afotable=="open"){echo"</table>"; $afotable="shut";}
                        if($fortable=="open"){echo"</tr>"; $fortable="shut";}
                        if($afortable=="open"){echo"</table>"; $afortable="shut";}
                        if($acttable=="open"){echo"</td></tr></table>"; $acttable="shut";}
                        /*
                        if($frtable=="open"){echo"</tr>"; $frtable="shut";}
                        if($arptable=="open"){echo"</td><td width=5></td></tr></table></td></tr></table>"; $arptable="shut";}
                        if($actvtable=="open"){echo"</td></tr></table></div>"; $actvtable="shut";}
                        */

                        if($nfm==62){
                            $next_e = __('messages.nnext');
                            $next_div = "next_div2";
                            echo"<div id=$next_div><br /><table><tr>
                                    <td width=440 class=fcom align=center onMouseOver=news(2)>
                                        <a href=## onclick=news(2) rel=\"noopener noreferrer\"><h3 class=\"font18\">$next_e </h3> </a>
                                    </td></tr></table></div>";
                        }
                    } // if($Allnn>0) {
                    else{
                        $no_news = __('messages.no_news');
                        echo"<table class=\"no_news\"><tr><td class=fcom0 align=center valign=top width=\"445\">
                                <br /><b>$no_news</b><br /><br />
                            </td></tr></table>";
                    }


            @endphp
            <!-- google для головної сторінки -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-7495053896041990"
                 data-ad-slot="4050982189"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </section>

    </section>
    <nav class="margin-top30 langs">
        @if (App::isLocale('en'))<img loading="lazy" width="22" height="14" src="/images/flag-en.png" title = "english language" alt = "english language">
        @else <a class="enover" href="/en" title = "english language"></a>
        @endif
        @if (App::isLocale('ua'))<img loading="lazy" width="22" height="14" src="/images/flag-uk.gif" title = "українська мова" alt = "українська мова">
        @else <a class="uaover" href="/ua" title = "українська мова"></a>
        @endif
        @if (App::isLocale('ru'))<img loading="lazy" width="22" height="14" src="/images/flag-ru.gif" title = "русский язык"  alt = "русский язык">
        @else <a class="ruover" href="/ru" title = "русский язык"></a>
        @endif
    </nav>
</section>


@endsection
