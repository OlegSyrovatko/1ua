@extends('layouts.app')
@php

function setGlobalLoad() {
    global $iwindowonload;
    $iwindowonload = "go";
}


// $domen = "0";

/*
$id = 0;




$id = 74291982;
$id = 72372396;

$id = 74442708;
$id = 72741169;

// $domen = "dsdsds";
*/


$Who = "";
$av_img0 = "";
$av_img1 = "";
$online_e = "";
$online_class="";
$fill="#111";

    if($domen != "0") {

            $Alls = DB::table('users')->select('id')->
            where('domen', $domen)->
          limit(1)->
            get();
                $nd=0;
            foreach ($Alls as $All) {  $id=$All->id; $nd++;}
            if($nd==0){$title = __('messages.unknown_page');}
    }
    if( $id == "0") {$nd=0; $title = __('messages.unknown_page');}

    else{
        $Alls = DB::table('users')->
        select('domen', 'Im', 'Priz', 'Bat', 'avatar', 'avx', 'avy', 'l_visit', 'Who', 'sex',
         'partner', 'bday', 'bmonth', 'byear', 'bday_visib', 'political', 'religion', 'tabak', 'alkoh', 'insign', 'mtel',
         'Wherer', 'idc', 'Adr', 'aktiv', 'rate', 'Md', 'questions', 'ab')->
            where('Num', $id)-> limit(1)-> get();
                $nd=0;
            foreach ($Alls as $All) {
                $domen=$All->domen; $Im=$All->Im; $Priz=$All->Priz; $Bat=$All->Bat;
                $avatar=$All->avatar;
                $avx=$All->avx; $avy=$All->avy;


                $l_visitm=$All->l_visit; $Who=$All->Who;
                $sex=$All->sex; $partner=$All->partner; $bday=$All->bday; $bmonth=$All->bmonth; $byear=$All->byear; $bday_visib=$All->bday_visib;
                $political=$All->political; $religion=$All->religion; $tabak=$All->tabak; $alkoh=$All->alkoh; $insign=$All->insign;
                $mtel=$All->mtel; $Wherer=$All->Wherer; $idc=$All->idc; $Adr=$All->Adr; $rate=$All->rate; $Md=$All->Md; $aktiv=$All->aktiv;
                $questions=$All->questions; $ab=$All->ab;
                $nd++;


                $l_visit = substr($l_visitm, 0, 16);
                $from=strtotime($l_visit);
                $Md_is_online = date('Y-m-d H:i');
                $to=strtotime($Md_is_online);
                $razn=($to-$from)/60;
                if ($razn<=5){
                    $online_class = "big-av-conteiner-online";
                    $fill="#3B9947";
                    $online_e = __('messages.online');
                }

            }
            if($nd==0){
                $title = __('messages.unknown_page');
                $Im=""; $Priz=""; $avatar=""; $Bat=""; $l_visitm=""; $aktiv=0; $ab="";
            }
            else {$title = "$Im $Priz"; }
              if ($avatar>0){
                  $path0 = "/storage/avatar/$avatar.jpg";
                  $path1 = "/storage/avatar/b$avatar.jpg";
                  $av_img0 = "<div class=\"av-conteiner scale $online_class\">
                        <img id=av_img0 src=\"$path0\" width=\"100\" height=\"100\" alt=\"$title, $Who $online_e\">
                    </div>";

                  $av_img1 = "<div class=\"scale av-shadow av-conteiner $online_class\">
                    <img id=av_img1 src=\"$path1\" width=\"150\" height=\"150\" alt=\"$title, $Who $online_e\">
                  </div>";
                    if($avx<200 || $avy<100){
                        $av_img1=$av_img0;
                    }

              }
              else {
                  $path0="/7.jpg";
                  $path1="/b7.jpg";

                  $av_img0="<svg class=\"av-shadow\" style=\"border-radius: 50%; fill:$fill;\"
                    width=\"150\" height=\"150\" aria-label=\"$title, $Who $online_e\">
                        <use href=\"/images/icons.svg#icon-username\"></use>
                    </svg>";
					$av_img1=$av_img0;
              }


     $Num = $id;

    if (Auth::user()){
        $my_id = Auth::user()->id;
    } else {
        $isfriend = ""; $my_id = "999999999999999";
    }


    $a_fr=0; $a_rin=0; $a_onl=0; $a_our=0;

    $Allfrn = DB::table('Friends')->
    select('Argue','Num1','Num2')->
    where('Num1', '=', $id)->
    orwhere('Num2', '=', $id)->
    get();
    $nrfr = $Allfrn->count();

    $fr_avt=""; $fr_avt2 = "";

	if(Auth::user()&&$id!=$my_id){
        $Alls = DB::table('Friends')->select('Num1', 'Num2')->
        where(function($query1) use ($my_id) {
            $query1->where('Num1', $my_id)
                  ->where('Argue', '=', 2);
        })->
        orWhere(function($query2) use ($my_id) {
            $query2->where('Num2', $my_id)
                  ->where('Argue', '=', 2);
        })->
        get();

        $Numfr = "";
        foreach ($Alls as $All) { $Num1=$All->Num1; $Num2=$All->Num2;
         if($Num1==$my_id){$Numfr=$Num2;} else{$Numfr=$Num1; }
          $fr_avt2.= " $Numfr";  }
	}

    $Numfr = "";
    $time_sec=time();
    if($nrfr!=0){
        $group_fr = array('friend');
        $group_in = array('friend');
        $group_onl = array('friend');
        $group_our = array('friend');

        /*
        if($Numm&&$Num==$Numm){
        $a_tdp=0; $a_tmp=0;
        $Bd = date('Y-m-d');
        $filename = "bg/bday/$Bd.txt";
        $whattoread = @fopen($filename, "r");
        $today_p = fread($whattoread, filesize($filename));

        fclose($whattoread);
        $group_fr_bdtd = array('friend');

        $Bd_future = date('Y-m-d', strtotime('+1 days'));
        $filename = "bg/bday/$Bd_future.txt";
        $whattoread = @fopen($filename, "r");
        $tomorrow_p = fread($whattoread, filesize($filename));
        fclose($whattoread);
        $group_fr_bdtm = array('friend');
        }
        */

        foreach ($Allfrn as $Allf) {
            $Num1 = $Allf->Num1;
            $Num2 = $Allf->Num2;
            $Argue = $Allf->Argue;

            if($Num2==$my_id && $Argue==1 && $my_id==$id){
                 $group_in['friend'][$a_rin]=$Num1;
            $a_rin++;
            }

            if($Argue==2){

                if($Num1==$id){$Numfr=$Num2;}
                else{$Numfr=$Num1;}
                $fr_avt.= " $Numfr";
                /*
                if($Numm>0&&$id==$Numm){
                    $isfriend_bdtd = strstr($today_p, $Numfr);
                    if($isfriend_bdtd!=""){$group_fr_bdtd['friend'][$a_tdp]=$Numfr; $a_tdp++;}
                    $isfriend_bdtm = strstr($tomorrow_p, $Numfr);
                    if($isfriend_bdtm!=""){$group_fr_bdtm['friend'][$a_tmp]=$Numfr; $a_tmp++;}
                }
                */
                $group_fr['friend'][$a_fr]=$Numfr;
                $filename = "storage/last_visit/$Numfr.txt";
                if (file_exists($filename) && filesize($filename) > 0) {
                    $time_file=filemtime($filename); $t=$time_sec-$time_file;
                }
                if ($t<=500){
                     $group_onl['friend'][$a_onl]=$Numfr;
                $a_onl++;
                }

                $isfriend2 = mb_strstr($fr_avt2, $Numfr);
                if($isfriend2!=""&&($my_id>0&&$id!=$my_id)){
                     $group_our['friend'][$a_our]=$Numfr;
                $a_our++;
                }

            $a_fr++;

            }

        }
    }
    if($my_id>0 && $id != $my_id){
        $isfriend = mb_strstr($fr_avt, $my_id);
    }




    $Alls = DB::table('Private')->select('Page', 's_l_visit', 'l_visit', 'Forum', 'set_q', 'ipban', 'ban')->
        where('Num', $id)->
      limit(1)->
        get();
            $pr=0;
        foreach ($Alls as $All) { $Sh_Page=$All->Page; $s_l_visit=$All->s_l_visit; $l_visit_priv=$All->l_visit;
         $Forum=$All->Forum; $set_q=$All->set_q; $ipban=$All->ipban; $ban=$All->ban;
         $pr++; }
        if($pr==0) {$Sh_Page=1; $Forum=1; $s_l_visit=1; $l_visit_priv=1; $set_q="a"; $ipban=""; $ban="";}



    $Privatpass="stop";
    if($Sh_Page==1 || !$Sh_Page){$Privatpass="go";}
     else{if($Sh_Page==2 && Auth::user()){$Privatpass="go";}
      else{
        if($Sh_Page==3 && ($id==$my_id || $isfriend != "")){ $Privatpass="go"; }
        else if($Sh_Page==4&&$Num==$my_id){$Privatpass="go";}
      }
     }

     if (Auth::user()){
        if ($ban){
          if(strstr((string)$ban, (string)$my_id)!=""){$Privatpass="stop";}
        }
     }

    $Qpass="stop";
    if($set_q=="a"){$Qpass="go";}
     else{if($set_q=="b" && Auth::user()){$Qpass="go";}
      else{
        if($set_q=="c" && $isfriend != ""){ $Qpass="go"; }
      }
     }
     if($aktiv != 1){$Qpass="stop";}
     $ip = $_SERVER['REMOTE_ADDR'];
        if(strstr($ipban, $ip)!=""){$Qpass="stop";}

    }

    if($nd == 0){
        $path0="/7.jpg";
        $path1="/b7.jpg";
    }
$description = __('messages.i_description');
$keywords = __('messages.i_keywords');
$index_go="index,follow";
@endphp
@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection
@section('image'){{$path1}}@endsection

@section('content')

    @if($nd==0)

        @if($domen != "0") @php $unnp2 = __('messages.unknown_page2'); @endphp
        @else @php  $unnp2 = __('messages.unknown_page3'); @endphp
        @endif

        <section id="hidpage" class="fcom0">
            <h4>{{  $unnp2 }}</h4>
            <a href="javascript:history.go(-1)">{{  __('messages.unknown_page4') }}</a>
        </section>
    @elseif($Sh_Page==5)
        @php $unnp2 = __('messages.del_page'); @endphp
        <section id="hidpage" class="fcom0">
             <h4>{{  __('messages.del_page') }}</h4>
                 <a href="javascript:history.go(-1)">{{  __('messages.unknown_page4') }}</a>
        </section>
    @elseif($Privatpass=="stop")

        <section id="hidpage" class="fcom0" >
                @php echo"$av_img0"; @endphp
             <b>{{$Im}} {{$Priz}}</b>
            {{ __('messages.hid_page') }}
            <a href="javascript:history.go(-1)">{{  __('messages.unknown_page4') }}</a>
        </section>

        @php $link = "spid$id";
           echo "<html><head><meta http-equiv='refresh' content='3; url=/$link'></head></html>";
        @endphp
    @else


        <section class="maxwide">

            <section class="cityuser1">

                @php
                    setGlobalLoad();

                        if($ab){
                            $pagec = explode("#!", $ab);
                               $nnrf=$pagec[1]; $nnrm=$pagec[2]; $nnrv=$pagec[3]; $nnra=$pagec[4]; $nnge=$pagec[5];
                               if(isset($pagec[7])) { $nrp=$pagec[7];}
                               else{$nrp = 0;}
                        }
                        else{$nnrf = 0; $nnrm = 0; $nnrv = 0; $nnra = 0; $nnge = 0; $nrp = 0;}

                            if ($nnrf>0){$statusfp="($nnrf)";} else{$statusfp="";}
                            if ($nnrm>0){$statusmp="($nnrm)";} else{$statusmp="";}
                            if ($nnrv>0){$statusvp="($nnrv)";} else{$statusvp="";}
                            if ($nnra>0){$statuspp="($nnra)";} else{$statuspp="";}
                            if ($nnge>10){$statusge="($nnge)";} else{$statusge="";}
                        $pref_page = __('messages.pref_page');
                        $friends0 = "friends";
                        $friends_link = "$pref_page$friends0/$id/date";

                        if($id==$my_id){$my_friends = __('messages.My_friends');}
                        else{$my_friends = __('messages.Friends');}
                        if($a_fr>0){$my_friends .= " ($a_fr)";}
                @endphp
                <ul class="menu-list ">
                    <li  class="fcom menu-item non-cursor">

                        <div id="avload" style="margin: 15px auto 5px; text-align: center;">
                            @php echo"$av_img1"; @endphp
                            @if($id == $my_id && !$avatar>0)

                                <br />{{ __('messages.load_ava') }}
                                <div id=load_on style="text-align: center; padding-right: 5px; padding-left: 5px; display: none;">
                                    <h5>{{ __('messages.Loading_wait') }}<br />
                                        <img SRC="/images/upload.gif"><br />
                                        {{ __('messages.Loading_wait2') }}</h5>
                                </div>

                                <input id="image" style="width: 90%" accept="image/jpeg" type=file name="image"
                                       onchange=load_av.style.display='block';>
                                <div id="load_av" style="display: none;"><table>
                                        <tr><td class="fcomblue" width=100>
                                                <ul class="intop"><li><a id=av_load >{{ __('messages.Refresh') }}</a></li></ul>
                                            </td></tr>
                                    </table></div>
                            @endif
                        </div>

                        <h1 style="text-align: center;"> {{ $Im }} {{ $Bat }} {{ $Priz }} </h1>
                        @php if($Who){echo"<h2 style=\"text-align: center;\">$Who </h2>";} @endphp
                    </li>
                    @if($id!=$my_id && $my_id!="999999999999999" && $my_id >0 && $isfriend == "")
                        <li id='add_fr' class="fcom menu-item">
                            <a href="##" onClick="add_fr('add_fr','{{$id}}')" rel="noopener noreferrer">
                                <h3>{{ __('messages.add_fr') }} </h3>
                            </a>
                        </li>
                    @endif
					@if($id==$my_id)
						@php
							$fotos_menu = __('messages.my_fotos');
							$records_menu =  __('messages.my_records');
						@endphp
					@else
						@php
							$fotos_menu =  __('messages.all_photos');
							$records_menu =  __('messages.all_records');
						@endphp
					@endif
					<li class="fcom menu-item">
						<a href="/{{$domen}}/foto/{{ __('messages.lan') }}/" >
							<h3>{{ $fotos_menu }} {{$statusfp}} </h3>
						</a>
					</li>
					<li class="fcom menu-item">
						<a href="/{{$domen}}/forum/{{ __('messages.lan') }}/0/0" >
							<h3>{{ $records_menu }} {{$statusmp}} </h3>
						</a>
					</li>

					@if($id==$my_id)
						<li class="fcom menu-item">
							<a href="/settings" >
								<h3> {{ __('messages.my_settings') }} </h3>
							</a>
						</li>
					@endif
					@if($nrp>0)
						<li id='adm_pages' class="fcom menu-item">
                            <a href="##" onClick="adm_pages('{{$id}}')" rel="noopener noreferrer">
                                <h3>{{ __('messages.adm_pages') }} ({{$nrp}}) </h3>
                            </a>
                        </li>
					@endif
                    @if($id!=$my_id && $my_id!="999999999999999" && $my_id >0 && $isfriend != "")
                        <li id='adm_pages' class="fcom menu-item">
                        <div id='del_fr0'>
                                <a href="##" onClick="del_fr0('del_fr0','del_fr')" rel="noopener noreferrer"><h3>{{ __('messages.del_fr') }} </h3></a>
                            </div>
                            <div id="del_fr" class="un-display" >
                                <h3>{{ __('messages.confirm') }} <b><a href="##" onclick=del_fr('del_fr','{{$id}}') rel="noopener noreferrer">{{ __('messages.Delete') }}</a></b>
                                <br /><br /><a onclick=del_fr1('del_fr0','del_fr')>{{ __('messages.cancel') }}</a>
                                </h3>
                            </div>
                        </li>
                    @endif


                @php
                $left_colomn = "";
                $right_colomn = "";

                @endphp
                </ul>
            </section>

            <section class="cityuser2">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                        crossorigin="anonymous"></script>
                <!-- для людей -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-7495053896041990"
                     data-ad-slot="4081061255"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                @if($id == $my_id)

                    @php
                    $questions_n = substr_count($questions,"#!^:*&");
                    $questions = explode("#!^:*&", $questions);

                    if((int)$questions_n>0){

                        for($q=100;$q<=$questions_n+99; $q++){

                        echo"<li id=\"q_box$q\" class=\"fcom city-center-block ques-in\">";
                            $ques=$questions[$q-99];
                            $question_n = substr_count($ques,"#!:*&");
                             $question = explode("#!:*&", $ques);
                             $q_question=$question[1];
                             $q_data=$question[2];
                             $q_avt=$question[3];
                             if($question_n==3){$q_ip="";} else {$q_ip=$question[4];}

                            if((int)$q_avt>0){
                                $filename = "storage/last_visit/$q_avt.txt";
                                $q_Im = "";
                                $q_Priz = "";
                                $q_Num_a = "";
                                $av_height=200;
                                $av_width=200;
                                if (file_exists($filename)) {
                                    $whattoread = @fopen($filename, "r");
                                    $file_contents = fread($whattoread, filesize($filename)); fclose($whattoread);
                                    $page = explode("#!:*&", $file_contents);

                                    $q_Im=$page[1]; $q_Priz=$page[2];
                                    $q_Num_a=$page[3]; if($q_Num_a<10){$q_Num_a=7;}
                                    $av_height = isset($pageq[6]) ? $pageq[6] : null;
                                    $av_width = isset($pageq[7]) ? $pageq[7] : null;
                                    if (!is_int($av_height)) {$av_height="auto";}
                                    if (!is_int($av_width)) {$av_width=200;}
                                }
                                $time_file = filemtime($filename);
                                $time_sec=time();
                                $online = "";
                                $my_id = "";
                                 if(Auth::user()) {
                                    $my_id = Auth::user()->id;
                                 }
                                $t = $time_sec - $time_file;
                                if ($t <= 500 && $my_id != $q_avt) {
                                    $online = "online";
                                }
                            }

                            $secm = substr($q_data, 14, 2);
                            $hourm = substr($q_data, 11, 2);
                            $Md_tod = date('Y-m-d');
                            $Md_yes = date('Y-m-d', strtotime('-1 days'));
                            $Md_yes_yes = date('Y-m-d', strtotime('-2 days'));

                            $fM6 = substr($q_data, 0, 10);
                            if($fM6==$Md_tod){$M6_e=__('messages.today');}
                            else if($fM6==$Md_yes){$M6_e=__('messages.yesterday');}
                            else if($fM6==$Md_yes_yes){$M6_e=__('messages.yesterday2');}
                            else {
                                $daym = substr($q_data, 8, 2); $monm = substr($q_data, 5, 2); $yem = substr($q_data, 0, 4);
                                for ($a=1; $a<13; $a++){
                                   if($a<10){$aa = "0$a";} else{$aa = "$a";}
                                    if($monm == "$aa"){ $monm = "messages.mmon$a"; $monm = __($monm); }
                                }
                                if(substr($daym, 0, 1)==0){$daym = substr($daym, 1, 1);}
                                $M6_e="$daym $monm <br />$yem";
                            }

                            echo"<p>$M6_e</p>";
                            if($q_avt>0){
                                $pref_page = __('messages.pref_page');
                                $pref_pagei = $pref_page.="i";
                                $user_icon = generateUserIcon($q_Num_a, $q_Im, $q_Priz, "center", $av_width, $av_height, $online);
                                echo"<div class=\"scale ques-in-item\">
                                    <a href=/$pref_pagei$q_avt>$user_icon</a>
                                    <a href=/$pref_pagei$q_avt>$q_Im <br />$q_Priz</a>
                                </div>";
                            }
                            else{
                                $someone = __('messages.quest10');
                                $someone = str_replace(" ", "<br />", $someone);
                                $block = __('messages.lock');
                                echo"<div  style\"flex-shrink: 1;\">
                                <p>$someone</p>
                                <p style = \"font-size: 10px;\">$q_ip</p>";
                                if(mb_strlen($q_ip)>5){
                                    echo"<div id=\"ban$q\">
                                        <a onclick=ban_qp('ban$q','$q_ip')> $block Ip</a>
                                    </div>";
                                }
                                echo"</div>";
                            }
                            echo"<div class=\"forum-content ques-in-item mw355\">
                                <b>$q_question</b>";

                                $qenter = __('messages.qenter');
                                $answ = __('messages.answ');
                                echo"<div id=\"q_err$q\"></div>
                                <textarea id=\"ask$q\" class=\"pl5\" rows=1 cols=25 placeholder=\"$qenter\" onFocus=\"clearsp('ask$q','dcmes$q');\"></textarea>
                                <div id=\"dcmes$q\" class=\"un-display\">
                                    <table><tr><td class=\"fcomblue intop wide-button\">
                                        <a href = ### onclick=askp('q_box$q','ask$q','$q')> $answ </a>
                                    </td></tr></table>
                                </div>";

                            echo"</div>";

                            $Delete = __('messages.Delete');
                            echo"<br /><a onclick=del_qp('q_box$q','$q')>$Delete</a>";

                        echo"</li>";

                    } //for($q=100;$q<=$questions_n+99;$q++){

                    } // if($questions_n>0){
                    @endphp

                @endif

                <section class="fcom city-center-block lefted ab-user">
					<p>
					@php

					$Privatpass_lv="stop";
					if($l_visit_priv==1){$Privatpass_lv="go";}
					   else {if($l_visit_priv==2&& Auth::user()){$Privatpass_lv="go";}
						  else {
							if($l_visit_priv==3 && ($id==$my_id ||$isfriend!="")){$Privatpass_lv="go";}
							else if($l_visit_priv==4&&$id==$my_id ){$Privatpass_lv="go";}
						   }
					   }
				   if ($Privatpass_lv=="go" && $l_visitm){
								$lve = __('messages.last_visit');
						 $t_is = date('Y-m-d H:i:s');
						  $tot=strtotime($t_is);
						$fromt=strtotime($l_visitm);
						$min5s=$tot-$fromt;
					 if ($min5s<200){
						  $l_visit_e=""; }
					 else {
						$daym_lv = substr($l_visitm, 8, 2); $monm_lv = substr($l_visitm, 5, 2); $yem_lv = substr($l_visitm, 0, 4);
						$mon_ee = "";
						 for ($a=1; $a<13; $a++){ if($a<10){$aa = "0$a";} else{$aa = "$a";}
							 if($monm_lv == "$aa"){ $mon_e = "messages.mmon$a"; $mon_ee = __($mon_e); }
						  }
					   if(substr($daym_lv, 0, 1)==0){$daym_lv = substr($daym_lv, 1, 1);}

						if($s_l_visit==1){
						$min_lv = substr($l_visitm, 14, 2); $hourm_lv = substr($l_visitm, 11, 2);
						$l_visit_e="$lve: $daym_lv $mon_ee $yem_lv, $hourm_lv:$min_lv<br />";
						}
						if($s_l_visit==2){
						$l_visit_e="$lve: $daym_lv $mon_ee $yem_lv <br />";
						}
					 }

					if($id==$my_id){$l_visit_e="";}

					} else {$l_visit_e = "";}



					if($partner>0){

						echo __('messages.fam_st'); echo": ";
						if($partner==1) {
							if($sex==0 || (!$sex)){echo __('messages.partner1'); }
							if($sex==1){echo __('messages.partner11'); }
							if($sex==2){ echo __('messages.partner21'); }
						}
						if($partner==2) {
							if($sex==0 || (!$sex)){echo __('messages.partner2'); }
							if($sex==1){echo __('messages.partner12'); }
							if($sex==2){ echo __('messages.partner22'); }
						}
					   if($partner==3) {
							if($sex==0 || (!$sex)){echo __('messages.partner3'); }
							if($sex==1){echo __('messages.partner13'); }
							if($sex==2){ echo __('messages.partner23'); }
						}
					   if($partner==4) {
							if($sex==0 || (!$sex)){echo __('messages.partner4'); }
							if($sex==1){echo __('messages.partner14'); }
							if($sex==2){ echo __('messages.partner24'); }
						}
						if($partner==5) {echo __('messages.partner5'); }
						if($partner==6) {echo __('messages.partner6'); }
						echo"<br />";
					}

					if(($bday_visib==0 || $bday_visib==1 || $bday_visib==2 || (!$bday_visib)) && $bday>0 && $bmonth>0){
						if($bday){$bday_e = $bday;} else{$bday_e = "";}
						if($bmonth){
							for ($a=0; $a<13; $a++){$aa = "$a";
								if($aa=="$bmonth"){ $mon_e = "messages.mmon$a"; $mon_e = __($mon_e); }}
							} else{$mon_e = "";}
						if($byear){$byear_e = $byear;} else{$byear_e = "";}
						if($bday_visib==2){}
						if($bday_visib==1){echo __('messages.bday'); echo": $bday_e $mon_e <br />"; }
						if($bday_visib==0 || (!$bday_visib)){

						echo __('messages.bday'); echo": $bday_e $mon_e $byear_e <br /><br />";
						}

					}


					if($idc>0){
						$Allc = DB::table('Allcities')->select('ab', 'domen')->
						where('id', $idc)->limit(1)->get();

						$domenc = '';
						foreach ($Allc as $All) { $ab=$All->ab; $domenc = $All->domen;}
						$pagec = explode("#!", $ab);
						 $City=$pagec[1]; $City2=$pagec[2];
						 if(isset($pagec[11])){$City3=$pagec[11];}
						 else {$City3=$City;}

						$obl = $pagec[3] ?? 0;
                        $domenc = $domenc ?: ($pagec[12] ?? '');
						if($Wherer == "проживання"){$Wherer = __('messages.Place1');}
						if($Wherer == "навчання"){$Wherer = __('messages.Place2'); }
						if($Wherer == "роботи"){$Wherer = __('messages.Place3'); }
						if($Wherer == "відпочинку"){$Wherer = __('messages.Place4'); }
						if($Wherer == "народження"){$Wherer = __('messages.Place5'); }
						$Place = __('messages.Place');
						if (App::isLocale('ru')){$Ct="<a href =/$domenc/ru><b>$City2</b></a>"; $Ccity=$City2;}
						else if (App::isLocale('en')){$Ct="<a href =/$domenc/en><b>$City3</b></a>"; $Ccity=$City3;}
						else{$Ct="<a href =/$domenc><b>$City</b></a>"; $Ccity=$City;}

						$ob_user = __('messages.Region'); $ob_user2 = __('messages.Region3');
						  for ($i = 0; $i <= 25; $i++){
							 $ni = "messages.o$i"; $ni2 = "messages.oo$i"; $ii = "$i";
							   if($obl == $ii){$nii = __($ni); $nii2 = __($ni2); if($obl == "1"){$ob_user = ""; $ob_user2 = "";}
							   $obl_user = "<a href =/se$i><b>$nii $ob_user</b></a>";
							   $obl_user2 = "<a href =/spo$i>$nii2 $ob_user2</a>";
							   }
						  }

						  if (App::isLocale('ru')){$pre_p1="rinfp"; $pre_p2="rsp$idc"; $pre_p=""; }
						  else if (App::isLocale('en')){ $pre_p1="einfp";  $pre_p2="esp$idc"; $pre_p="of"; }
						  else {$pre_p=""; $pre_p1="infp"; $pre_p2="sp$idc";}
						$pep_e = __('messages.people');
						  $ctzns = "<a href=/$pre_p2>$Ccity</a>";
						$pep_ee = "<a href=/$pre_p1>$pep_e</a>";

						echo"$Place $Wherer: $Adr <br /> $Ct $obl_user<br />
						$pep_ee $pre_p $obl_user2 $ctzns<br />";
						echo"<br /><br />";
					}

					if($political>=1){ $polit = __('messages.polit');
							for ($a=0; $a<10; $a++){ $aa = "$a";
							$pol_e = "messages.polit$a";
							if($political==$aa){$pol_ee = __($pol_e);}
							 }
							echo"$polit: $pol_ee <br />";
					}
					if($tabak>=1){ $tab = __('messages.tab1');
							for ($a=0; $a<6; $a++){ $aa = "$a";
							$tabak_e = "messages.tab_alk$a";
							if($tabak==$aa){$tabak_ee = __($tabak_e);}
							 }
							echo"$tab: $tabak_ee <br />";
					}
					if($alkoh>=1){ $alk = __('messages.alk1');
							for ($a=0; $a<6; $a++){ $aa = "$a";
							$alk_e = "messages.tab_alk$a";
							if($alkoh==$aa){$alkoh_ee = __($alk_e);}
							 }
							echo"$alk: $alkoh_ee <br />";
					}
					if($insign){ $ins = __('messages.insign');
							echo"$ins: $insign <br />";
					}
					if($religion){ $rel = __('messages.religion');
							echo"$rel: $religion <br />";
					}
					if($mtel){ $mte = __('messages.mtel');
							echo"$mte: $mtel <br />";
					}

					$M6_e = db_date($Md);
					$crp = __('messages.create_page');
					echo"<br />$l_visit_e $crp: $M6_e </p>";


					@endphp

					@if($id==$my_id)
					@else
						@if($Qpass=="go")
							<div id="question_in"> </div>
							<textarea ID=question rows=2 cols=30 placeholder="{{__('messages.quest1')}}" onFocus="clearssi('question');"></textarea>
							<table class=margin-top5><tr>
								@auth
									<td class="fcomblue intop qwest-button">
										<a href=## onclick=questioni('me','{{$id}}','/question_inp')>{{__('messages.quest4')}}</a>
									</td>
								@endauth
								<td class="fcomblue intop qwest-button">
									<a href=## onclick=question('anonim','{{$id}}','/question_inp') rel="noopener noreferrer"> {{__('messages.quest6')}}</a>
								</td>
							</tr></table>
						@endif
					@endif

				</section>

				@if($id==$my_id)
                @else @php $my_mail_e = ""; @endphp
                @if($aktiv == 1)
                    @guest @else
                        @php $my_mail=Auth::user()->email;
                               if (filter_var($my_mail, FILTER_VALIDATE_EMAIL)) {$my_mail_e = $my_mail;}
                        @endphp
                    @endguest

				<section class="fcom city-center-block">
					<h3>{{__('messages.subscr1')}}</h3>
					<p> {{__('messages.subscr2')}}</p>

					<section id="sub-city">
						<label style="display: flex; flex-direction: column; align-items: flex-start" required autocomplete="email" autofocus>
							<b>E-mail:</b>
							<input type="text" id="Pmail" value="{{$my_mail_e}}" size=14>
						</label>
						<label style="display: flex; flex-direction: column; align-items: flex-start">
							<b>{{__('messages.chopt')}}:</b>
							<select id="mailnp">
								<option value="/mailadd">{{__('messages.Add')}}</option>
								<option value="/mailchange">{{__('messages.Set')}}</option>
								<option value="/maildel">{{__('messages.Delete')}}</option>
							</select>
						</label>
						<input type="hidden" name="id" id="id" value="{{$id}}">
						<table><tr><td class="fcomblue intop short-button">
									<a href="##" onclick="dataSelectp()" rel="noopener noreferrer">
										{{__('messages.Go')}}
									</a>
								</td></tr></table>
					</section>
					<div id=mailfield></div>
				</section>

                @endif
                @endif

				@php
				$my_mail_e = "";
				@endphp
				@auth
					@php
					$my_mail=Auth::user()->email;
					if (filter_var($my_mail, FILTER_VALIDATE_EMAIL)) {
					 $my_mail_e = $my_mail;
					}
					@endphp
				@endauth


                @php
                    if(Auth::user()) {

                    $ggg =  Auth::user()->id;
                        if($ggg == "72372396" && $id==$ggg){

                @endphp
                <script>
                    function del_adm2(Md,page) {
                        $.ajaxSetup({
                            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                        });

                        var formData = {
                            Md:Md
                        };
                        $.ajax({
                            type: 'POST',
                            url: '/del_adm2',
                            data: formData,
                            cache: false,
                            success:function(data){
                                document.getElementById(page).innerHTML=data;
                            }
                        });
                    }
                    function confirm(num,Md,bank,eml,page,dv) {
                        $.ajaxSetup({
                            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                        });

                        var formData = {
                            num:num, Md:Md, bank:bank, eml:eml, page:page
                        };
                        $.ajax({
                            type: 'POST',
                            url: '/confirm',
                            data: formData,
                            cache: false,
                            success:function(data){
                                document.getElementById(dv).innerHTML=data;
                            }
                        });
                    }
                </script>
                @php
                    $Alla = DB::table('City_Admin2')->
                            select('Page','Num','mail_admin','bank','Md')->
                            whereNull('id')->
                            orderBy('Md', 'desc')->
                            get();
                            $nra = $Alla->count();
                            if($nra>0 ){
                                echo"Заявки в адміни $nra <table border=1>";
                                foreach ($Alla as $All) {
                                    $Page = $All->Page;
                                    $Page2 = substr($Page, 0, 1);
                                    $Num = $All->Num;
                                    $mail_admin = $All->mail_admin;
                                    $bank = $All->bank;
                                    $Md = $All->Md;
                                    $Md2 = substr($Md, 5);
                                    $t1="qwertyuiopasdfghjklzxcvbnm"; $t2="";
                                    for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t2.="$t1[$z]";}
                                    $t3 = "2"; $t3 = "$t2$t3";
                                    echo"<tr><td>$Page2</td><td><a href=/i$Num>user</a></td><td>$mail_admin</td><td><a href=/c$bank>$bank</a></td><td>$Md2</td>
                                    <td><div id=\"$t2\"><a onclick=del_adm2('$Md','$t2')>вид.</a></div></td>
                                    <td><div id=\"$t3\"><a onclick=confirm('$Num','$Md','$bank','$mail_admin','$Page','$t3')>затв.</a></div></td></tr>
                                    ";
                                }
                                echo"</table><br />";
                            }
                        }

                    }
                @endphp
                    <a style="display: inline-block; margin-bottom: 10px; " 
                    target="_blank" href="https://play.google.com/store/apps/details?id=com.syrovatko.saferoad">
                        <video style="width: 320px; height: 100px; object-fit: cover; border-radius: 8px;" 
                            autoplay loop muted>
                            <source src="/storage/saferoad.mp4" type="video/mp4">
                            Ваш браузер не підтримує відео.
                        </video>
                    </a>
                @php

                if($nnrf>0){
                    $lan = App::currentLocale();
                    $pref_page = __('messages.pref_page');
                    $pref_page_f = $pref_page.="ni";
                    $latest_photo = __('messages.latest-photo');
                    echo"<section class=\"fcom city-center-block\">
                    <h3><a aria-label=\"$latest_photo $Im $Priz\" href=\"/$domen/foto/$lan/\">$latest_photo</h3>
                    <section class=\"city-center-foto\">";
                    $v_s=1;
                    if($my_id==$id){$v_s=4; }
                    else{
                    if($my_id == "999999999999999"){$v_s=1;}
                    else if($my_id>0){$v_s=2;
                    if($isfriend!=""){$v_s=3;}
                    }
                    }

                    $Allf = DB::table('Fotop')->select('Namef', 'Formf', 'Fd', 'w', 'h')->
                    where('Num', $id)->
                    orderBy('Fd', 'desc')->
                    where('Sh', '<=', $v_s)->
                    limit(4)->
                    get();
                    $Allfn = $Allf->count();

                    if($Allfn>0){
                        foreach ($Allf as $Alf) {
                            $M5=$Alf->Namef;
                            $M7=$Alf->Formf;
                            $M6=$Alf->Fd;
                            $w=$Alf->w;
                            $h=$Alf->h;
                            $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
                            if ($monm<10){$monmf = substr($M6, 6, 1);}
                            else{$monmf=$monm;}
                            if($yem<=2007){$yem = "2005-2007"; $monmf="";}
                            $katalogb = "Fotop/$yem$monmf/$M5.$M7";
                            $katalogface=Storage::disk('public')->url($katalogb);
                            $widthf="auto";
                            if($w>0 && $h>0){
                                $widthf=round(100*$w/$h);
                            }
                            if(Auth::user()) {
                                $flink = "onclick=abfp($id,$M5)";
                            }
                            else{
                                $flink = "href=\"$pref_page_f$M5\"";
                            }

                            echo "
                                <a $flink>
                                    <div class=\"scale ccf-item fcom0\">
                                        <img width=\"$widthf\" height=\"100\" alt=\"$Im $Priz - $latest_photo\" src=\"$katalogface\">
                                    </div>
                                </a>
                            ";
                        }
                        echo"</section>";
                    }


                    $Allf = DB::table('Fotop')->select('Namef', 'Formf', 'Fd', 'w', 'h')->
                    where('Num', $id)->
                    orderBy('Fd', 'desc')->
                    where('Publ', '1')->
                    where('Sh', '<=', $v_s)->
                    get();
                    $Allfn = $Allf->count();

                    if($Allfn>0){
                        $selected_photo = __('messages.selected-photo');
                        echo"<br /><h3>$selected_photo</h3>
                        <section class=\"city-center-foto\">";
                        foreach ($Allf as $Alf) {
                            $M5=$Alf->Namef;
                            $M7=$Alf->Formf;
                            $M6=$Alf->Fd;
                            $w=$Alf->w;
                            $h=$Alf->h;
                            $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
                            if ($monm<10){$monmf = substr($M6, 6, 1);}
                            else{$monmf=$monm;}
                            if($yem<=2007){$yem = "2005-2007"; $monmf="";}
                            $katalogb = "Fotop/$yem$monmf/$M5.$M7";
                            $katalogface=Storage::disk('public')->url($katalogb);
                            $widthf="auto";
                            if($w>0 && $h>0){
                                $widthf=round(100*$w/$h);
                            }
                            if(Auth::user()) {
                                $flink = "onclick=abfp($id,$M5)";
                            }
                            else{
                                $flink = "href=\"$pref_page_f$M5\"";
                            }

                            echo "
                                <a $flink>
                                    <div class=\"scale ccf-item fcom0\">
                                        <img width=\"$widthf\" height=\"100\" alt=\"$Im $Priz - $latest_photo\" src=\"$katalogface\">
                                    </div>
                                </a>
                            ";
                        }
                        echo"</section>";
                    }
                echo"</section>";
                }

                @endphp
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                        crossorigin="anonymous"></script>
                <!-- для людей -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-7495053896041990"
                     data-ad-slot="4081061255"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                @php


                $Allm =DB::table('Memoryp')->select('afisha', 'theme', 'idrec','Aboutep','r_gol','r_kol','rh','Md','Ip','avt')
                ->where('Num',$id)->where('afisha','1')
                ->orderBy('Md','Desc')
                ->limit(100)
                ->get();
                $Afishan = $Allm->count();

                if ($Afishan>0) {
                    $fast_e = __('messages.fastens');
                    $hide = __('messages.hide');
                    $show = __('messages.show');
                    if(isset($_COOKIE['aphide'])){
                        $aphide = $_COOKIE['aphide'];
                    } else {$aphide = "";}
                    if($aphide=="0"){
                        $hstyle2 = "style=\"display: none;\" ";
                        $hstyle3 = "display: none;";
                    }
                    else {$hstyle2 = "";  $hstyle3 = "";}

                    echo"
                    <section class=\"fcom city-center-block\">
                        <a href=## onclick=ashowp() rel=\"noopener noreferrer\"><h4>$fast_e</h4></a>
                    </section>
                    <div id=\"hidafisha\" style=\"$hstyle3 margin: 0 10px 10px 0; text-align: right; \">
                        <a href=## onclick=ahidep() rel=\"noopener noreferrer\"><b>$hide</b></a>
                    </div>
                    <section id=\"afisha\" $hstyle2>";

                    foreach ($Allm as $All) {
                        $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutep; $r_gol=$All->r_gol;
                         $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt; $rh=$All->rh;

                         echo view('inc.memoryp', ['id' => $id, 'afisha' => $afisha, 'themeg' => $themeg, 'idrec' => $idrec, 'M1' => $M1,
                         'r_gol' => $r_gol, 'r_kol' => $r_kol, 'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'rh' => $rh, 'purp' => 'main']);
                    }
                    echo"</section>";
                }




                $Allt = DB::table('Memoryp')
                ->where('Num',$id)
                ->Where(function($query) {
                 $query->whereNotNull('theme')
                     ->Where('theme','!=','');
                })
                 ->select('theme',DB::raw('MAX(Md) AS mmd'))
                ->orderBy('mmd','Desc')
                ->groupBy('theme')
                ->get();
                $Alltn = $Allt->count();
                if($Alltn>0){
                    $th_e = __('messages.theme');
                    $go = __('messages.Go');
                    $Alltn_e = round($Alltn/7);
                    if ($Alltn_e<1){$Alltn_e=1;}
                    echo"
                    <section class=\"fcom city-center-block theme-go\">
                        <label class=\"theme-go theme-go-gap\"><b>$th_e:</b>
                        <select id=\"th\" size=$Alltn_e>";
                            foreach ($Allt as $All) {
                                $theme=$All->theme;
                                if(mb_strlen($theme)>0){
                                    if(mb_strlen($theme)>25){$theme_e = mb_substr($theme, 0, 25); $theme_e.="...";}
                                    else {$theme_e = $theme;}
                                    echo"<option value=\"$theme\" >$theme_e</option>";
                                }
                            }
                        echo"</select>
                        </label>

                        <table>
                            <tr><td class=\"fcomblue intop wide-button\">
                                <a href=## onclick=memtp($id); rel=\"noopener noreferrer\"> $go</a>
                            </td></tr>
                        </table>
                    </section>";

                }
                @endphp



                @if($my_id>0 && $my_id!=999999999999999)
                    <script>
                        function sml_red(purp) {
                            $.ajaxSetup({
                                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                            });
                            var formData = {
                                purp: purp
                            };
                            $.ajax({
                                type: 'POST',
                                url: '/sml_add',
                                data: formData,
                                cache: false,
                                success:function(data){
                                    document.getElementById('app_mem_add').innerHTML=data;
                                }
                            });
                        }
                        function smlin(sml) {
                            sml=sml.replace(".gif", ".gif>");
                            var memt = document.getElementById('memt').value;
                            if(memt){memt = memt + " "; }
                            memt = memt + sml;
                            var txt = document.getElementById('memt');
                            txt.value = memt;
                        }

                    </script>

                    <div id="memt_res"></div>
                    <section class="fcom city-center-block">
                        <textarea ID="memt" rows=2 cols=40 placeholder="{{__('messages.mem_in_t')}}" onFocus="clearsp('memt','mem_add');"></textarea>

                        <div id="mem_add" class="un-display">
                            <input id="theme_in" size=44 maxlength = 70 placeholder="{{__('messages.mem_in_tem')}}">
                            <table>
                                <tr>
                                    <td class="fcomblue intop wide-button">
                                        <a href = ## onclick=mem_addp('{{$id}}')> {{__('messages.Add')}} </a>
                                    </td>
                                    <td>
                                        <a onclick=smlp('default')>&nbsp;<img src=/sml/2.gif title='{{__('messages.sml')}}'> &nbsp;</a>
                                    </td>
                                </tr>
                            </table>
                            <div id="app_mem"></div>
                            <div id="app_mem_add"></div>
                        </div>
                    </section>
                @endif



                @php
                $Allm =DB::table('Memoryp')
                ->select('afisha', 'theme', 'idrec','Aboutep','r_gol','r_kol','rh','Md','Ip','avt')
                 ->orWhere(function($query) {
                    $query->whereNull('theme')
                        ->orWhere('theme','');
                        })
                ->where('Num',$id)
                ->orderBy('Md','Desc')
                ->limit(11)
                ->get();
                $nr = $Allm->count();

                 if($nr>0){
                     echo"<section id=\"mem\">";
                    $qwans = __('messages.qwans');
                    $enterv = __('messages.enterv');
                    $unsort = __('messages.unsort');


                     if($nr==11){
                         echo"
                         <ul class=\"forum-menu\">
                             <li class=\"fcom forum-menu-item w39 colored\" onclick=\"memp($id,'%^&@#',1,'Desc');\">
                                 <b>$qwans</b>
                             </li>
                             <li class=\"fcom forum-menu-item w22 colored\" onclick=\"memp($id,'*&^@72438484',1,'Desc');\">
                                 <b>$enterv</b>
                             </li>
                             <li class=\"fcom forum-menu-item w39 colored\" onclick=\"memp($id,'',1,'Asc');\">
                                 <b>$unsort</b>
                             </li>
                         </ul>
                        ";
                     }

                    $nm=1;
                    foreach ($Allm as $All) {
                        if($nm<11){
                            $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutep; $r_gol=$All->r_gol;
                             $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt; $rh=$All->rh;

                             echo view('inc.memoryp', ['id' => $id, 'themeg' => $themeg, 'afisha' => $afisha, 'idrec' => $idrec, 'M1' => $M1,
                             'r_gol' => $r_gol, 'r_kol' => $r_kol, 'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'rh' => $rh, 'purp' => 'def']);
                         }
                        else { $nnext = __('messages.nnext');
                        echo "<ul class=\"forum-menu\" id=fnext2>
                             <li class=\"fcombold forum-menu-item w100\" onMouseOver=memp($id,'',2,'Desc'); onClick=memp($id,'',2,'Desc');\">
                                 <b>$nnext</b>
                             </li>
                         </ul>";
                        }
                    $nm++;
                    }

                     echo"</section>";
                 }



                    $g_insert="off";
                    $Allg = DB::table('gp')->select('Numg', 'Im', 'Priz', 'Num_a', 'Vd')->
                    where('Num', $id)->
                    orderBy('Vd', 'desc')->limit(11)->get();
                    $Allgn = $Allg->count();

                        $Numm = 0;
                        $nguests = 0;
                        if(Auth::user()) {
                            $Numm =  Auth::user()->id;
                            $show_news = Auth::user()->show_news;
                            if (!$show_news) {
                                $nguests = 1;
                            } else {
                                $nguests = substr($show_news, 10, 1);
                            }
                        }
                    if($Numm!=$id && $Numm>0 && $nguests==1){

                        $filename0 = "storage/last_visit/$id.txt";
                        $whattoread0 = @fopen($filename0, "r");
                        $memory_contents0 = fread($whattoread0, filesize($filename0)); 		 fclose($whattoread0);
                        $notices = explode("#!:*&", $memory_contents0);
                        $lan_user=$notices[4]; $page_user=$notices[5];

                        $time_sec=time();
                        $time_file0=filemtime($filename0);
                        $t=$time_sec-$time_file0;
                        if ($t<=50000){
                        $sexm = Auth::user()->sex;
                        $Num_am = Auth::user()->avatar;
                        if($Num_am<10){$Num_am=7;}
                        $Imm = Auth::user()->Im;
                        $Prizm = Auth::user()->Priz;
                        if($sexm==1){$sexm_e1="зайшов"; $sexm_e2="посетил";} else if($sexm==2){$sexm_e1="зайшла"; $sexm_e2="посетила";} else{$sexm_e1="зайшов (ла)"; $sexm_e2="посетил (ла)";}

                            if($lan_user=="ua"){
                                $r_else="<table><tr><td valign=top width=160>
                                    <b><font color=white>Новий гість</font></b><br>
                                    <a href=/i$Numm>
                                    <img  style=\"margin: 2px 8px 8px 0px; \" border=0 SRC=/storage/avatar/s$Num_am.jpg align=left>
                                    </a><a href=/i$Numm><font color=white>$Imm $Prizm</font></a><br>
                                    $sexm_e1 на Вашу сторінку і дивиться її :)
                                </td></tr></table>";
                            }
                            if($lan_user=="ru"){
                                $r_else="<table><tr><td valign=top width=160>
                                    <b><font color=white>Новый гость</font></b><br>
                                    <a href=/ri$Numm>
                                    <img style=\"margin: 2px 8px 8px 0px; \" border=0 SRC=/storage/avatar/s$Num_am.jpg align=left>
                                    </a><a href=/ri$Numm><font color=white>$Imm $Prizm</font></a><br>
                                    $sexm_e2 Вашу страницу и смотрит на Вас :)
                                </td></tr></table>";
                            }
                            if($lan_user=="en"){
                                $r_else="<table><tr><td valign=top width=160>
                                    <b><font color=white>New Guest</font></b><br>
                                    <a href=/ei$Numm>
                                    <img style=\"margin: 2px 8px 8px 0px; \" border=0 SRC=/storage/avatar/s$Num_am.jpg align=left>
                                    </a><a href=/ei$Numm><font color=white>$Imm $Prizm</font></a><br>
                                    visited your page and looking at You :)
                                </td></tr></table>";
                            }

                            \Illuminate\Support\Facades\Redis::lpush("notice:$id", $r_else);

                        }
                    }

                    if($Allgn==0 && $Numm>0 && $nguests==1 && $Numm != $id){$g_insert="on";}
                    if($Allgn>0){

                        $guests = __('messages.guests_page');
                        $online = __('messages.online');
                        $delete = __('messages.delete');
                        $lan = App::currentLocale();

                        echo"<section class=\"fcom0 city-center-block\" >
                            <h3>$guests</h3>
                            <ul id=guests>";
                            $nrow=1; $ng=1;
                            foreach ($Allg as $Alg) {
                                if($ng<11){
                                    $avtc = $Alg->Numg; $Img = $Alg->Im; $Prizg = $Alg->Priz;
                                    $Num_a = $Alg->Num_a; if($Num_a>0){} else{$Num_a=7;} $Vd = $Alg->Vd;
                                    if($ng==1 && $Numm>0 && $nguests==1 && $Numm!=$id){
                                            if($avtc!=$Numm ){$g_insert="on";}
                                            else{
                                                $Num_a = Auth::user()->avatar;
                                                if($Num_a=='0' || !$Num_a ){$Num_a=7;}
                                                $Vd_now = date('Y-m-d H:i:s');
                                                $aff_upd = DB::table('gp')
                                                ->where('Vd', $Vd)
                                                ->where('Num', $id)
                                                ->where('Numg', $Numm)
                                                ->update(['Vd' => $Vd_now, 'Num_a' => $Num_a]);
                                                if($aff_upd){$Vd = $Vd_now;}
                                            }
                                        }

                                    if($avtc>0){
                                        $aavt = avt($avtc,$Numm);
                                        $aavt = str_replace("forum-avatar", "center-avatar", $aavt);
                                        $aavt = str_replace("<br />", "", $aavt);
                                        $aavt = str_replace("</svg>", "</svg><br />", $aavt);
                                        $aavt = str_replace("</div>", "</div><br />", $aavt);
                                    }

                                    $pref_page = __('messages.pref_page'); $ppref_page = $pref_page .="i";
                                    if($Vd){$Vds = str_replace(" ", "*", $Vd);
                                    $Vd_e = substr($Vd, 0, strlen($Vd)-3);

                                    $gdata = substr($Vd_e, 0, 10);
                                    $gtime = substr($Vd_e, 10, 6);
                                        $Nd_today = date('Y-m-d');
                                        $Nd_past = date('Y-m-d', strtotime('-1 days'));
                                        if($gdata==$Nd_past){
                                            $Vd_e="Вчора"; $titler="Вчера"; $titlee="Yestarday";
                                            if($lan=="en"){$Vd_e=$titlee;}
                                            else if($lan=="ru"){$Vd_e=$titler;}
                                        }
                                        else if($gdata==$Nd_today){
                                            $Vd_e=$gtime;
                                        }
                                        else{
                                            $Vd_e=$gdata;
                                        }
                                    $Vd_e="<p class=grey>$Vd_e</p>";}
                                    else{$Vd_e="";}

                                    $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}

                                    echo"<li id=\"$t3\" class=\"colored\">$aavt";
                                    if($Numm==$id||$Numm==$avtc){
                                        echo"$Vd_e<a href=## onclick=guesp_del('$avtc','$Vds','$t3','$id') rel=\"noopener noreferrer\"> $delete</a>";
                                    }
                                    echo"</li>";
                                }
                                $ng++;
                            }
                             echo"</ul>";

                                $g_ins = "";
                                if($g_insert=="on"){
                                    $Vd_now = date('Y-m-d H:i:s');
                                    $Imm = Auth::user()->Im;
                                    $Prizm = Auth::user()->Priz;
                                    $avatar = Auth::user()->avatar;
                                     if($avatar=='0' || !$avatar ){$avatar=7;}
                                    $g_ins = DB::table('gp')->
                                    insert(['Num' => $id, 'Numg' => $Numm, 'Im' => $Imm, 'Priz' => $Prizm, 'Num_a' => $avatar, 'Vd' => $Vd_now]);
                                    $g_insert="off";
                                }

                                if($ng==12){
                                    $nnext = __('messages.nnext');
                                    $t1="qwertyuiopasdfghjklzxcvbnm"; $t2="";
                                    for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t2.="$t1[$z]";}
                                    $pregg=0;
                                    if($g_ins){$pregg=1;}

                                    echo "
                                    <section id=$t2 class=\"forum-menu fcom forum-menu-guest colored mt15\" onClick=guesp('0','$t2','$pregg','$id')>
                                        <b>$nnext</b>
                                    </section>";

                                }

                                echo"</div>
                            </section>";
                    }
                    if($g_insert=="on"){
                        $Vd_now = date('Y-m-d H:i:s');
                        $Imm = Auth::user()->Im;
                        $Prizm = Auth::user()->Priz;
                        $avatar = Auth::user()->avatar;
                         if($avatar=='0' || !$avatar ){$avatar=7;}
                        $g_ins = DB::table('gp')->
                        insert(['Num' => $id, 'Numg' => $Numm, 'Im' => $Imm, 'Priz' => $Prizm, 'Num_a' => $avatar, 'Vd' => $Vd_now]);
                    }

                @endphp



				<section class="fcom city-center-block">
					<h4>{{__('messages.sharing')}}:</h4>
					@php
						$lan = App::currentLocale();
						$wh_domen=$_SERVER["HTTP_HOST"];
						$sh_link = "https%3A%2F%2F$wh_domen%2F$domen%2F$lan";
					@endphp
					<noindex id="social-madia">
						<a target="_blank" style="margin-top: -2px;" aria-label="{{__('messages.share-fb')}}" href="https://www.facebook.com/sharer.php?u={{$sh_link}}">
							<svg id="facebook" width="39" height="39"><use href="/images/icons.svg#icon-facebook"></use></svg>
						</a>
						<a target="_blank" aria-label="{{__('messages.share-tg')}}" href="https://telegram.me/share/url?url={{$sh_link}}">
							<svg id="telegram" width="36" height="36"><use href="/images/icons.svg#icon-telegram"></use></svg>
						</a>
						<a target="_blank" aria-label="{{__('messages.share-vb')}}" href="viber://forward?text={{$sh_link}}">
							<svg id="viber" width="36" height="36"><use href="/images/icons.svg#icon-viber"></use></svg>
						</a>
						<a target="_blank" aria-label="{{__('messages.share-tt')}}" href="https://twitter.com/intent/tweet?url={{$sh_link}}">
							<svg id="twitter" width="36" height="36"><use href="/images/icons.svg#icon-twitter"></use></svg>
						</a>
						<a target="_blank" aria-label="{{__('messages.share-wu')}}" href="https://api.whatsapp.com/send?text={{$sh_link}}">
							<svg id="whatsapp" width="36" height="36"><use href="/images/icons.svg#icon-whatsapp"></use></svg>
						</a>

					</noindex>
				</section>


                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                        crossorigin="anonymous"></script>
                <!-- для людей -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-7495053896041990"
                     data-ad-slot="4081061255"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>


            </section>

            <section class="cityuser3">
                <ul class="menu-list non-cursor">
                    @php

            if(Auth::user()) {
                $my_id =  Auth::user()->id;
                if($my_id==$id){
                    $enter_e = "";
                    $greet = __('messages.greet');
                    $enter_e .= "$greet, ";
                    if(Auth::user()) {
                    $my_im =  Auth::user()->Im;
                    $enter_e .= "$my_im, ";
                    }
                    $inter_me = __('messages.inter_me');
                    $enter_e .= "$inter_me <br /><br />";
                    $lets_go = __('messages.lets_go');
                    $enterv = __('messages.enterv');

                    echo"
                    <li class=\"fcom menu-item\" id=dask style=\"padding: 10px;\">
                        <table><tr><td>
                            <div style=\"float:left; margin: 0px 7px 5px 0px; \">
                                <img width=70 height=91 alt=\"$enterv\" SRC=/images/mast.png>
                            </div>
                                $enter_e
                            <table><tr><td class=\"fcomblue intop wide-button\">
                                <a href=## onclick=top_askp(0) rel=\"noopener noreferrer\">$lets_go</a>
                            </td></tr></table>
                        </td></tr></table>
                    </li>";
                }
            }



                $pref_page = __('messages.pref_page');
                if($a_fr==0&&$Num==$my_id){
                    $infp_l0 = "infp";

                    $infp_l = "$pref_page$infp_l0";
                    $no_friends = __('messages.no_friends');
                    $find_friends = __('messages.find_friends');
                    $invite_friends = __('messages.invite_friends');

                    echo"<li class=\"fcom menu-item non-cursor\">
                    <br />$no_friends<br /> <a href=/$infp_l><b>$find_friends</b></a> $invite_friends<br /><br />
                      </li>";
                }

                if($a_fr>6){$a_fr_nr=6;} else{$a_fr_nr=$a_fr;}
                if($a_rin>4){$a_rin_nr=4;} else{$a_rin_nr=$a_rin;}
                if($a_our>4){$a_our_nr=4;} else{$a_our_nr=$a_our;}
                if($a_onl>6){$a_onl_nr=6;} else{$a_onl_nr=$a_onl;}

                if ($a_our>0){
                    $ourfriends0 = "ourfriends";
                    $ourfriends_link = "$pref_page$ourfriends0";
                    $Ourfriends = __('messages.Ourfriends');

                    echo"<li class=\"fcom menu-item non-cursor\">

                        <h3><a href=/$ourfriends_link/$id/visit>$Ourfriends ($a_our)</a></h3>
                        <ul class=\"fr-in-user\">";

                        $f_his="";
                        for($a=0; $a<$a_our_nr; $a++){
                            $ah=rand(0,$a_our-1); $Numfr=$group_our['friend'][$ah];
                            $filename = "storage/last_visit/$Numfr.txt";

                            if (mb_strstr($f_his,"$Numfr")=="" && file_exists($filename) && filesize($filename) > 0){
                                $f_his.=" $Numfr ";

                                $frnd = avt($Numfr,$my_id);
                                $frnd = str_replace("forum-avatar", "center-avatar", $frnd);
                                $frnd = str_replace("<b>", "", $frnd);
                                $frnd = str_replace("</b>", "", $frnd);
                                echo"<li class=\"fr-in-user-item\"> $frnd  </li>";
                            }
                        }

                    echo"</ul></li>";
                }

                if ($a_fr>0){
                    $friends0 = "friends";
                    $friends_link = "$pref_page$friends0";
                    $Friends = __('messages.Friends');

                    echo"<li class=\"fcom menu-item non-cursor\">

                    <h3><a href=/$friends_link/$id/visit>$Friends ($a_fr)</a></h3>
                    <ul class=\"fr-in-user\">";

                    $f_his="";
                    for($a=0; $a<$a_fr_nr; $a++){

                        $ah=rand(0,$a_fr-1);  $Numfr=$group_fr['friend'][$ah];
                        $filename = "storage/last_visit/$Numfr.txt";

                        if (mb_strstr($f_his,"$Numfr")=="" && file_exists($filename) && filesize($filename) > 0){
                            $f_his.=" $Numfr ";

                            $frnd = avt($Numfr,$my_id);
                            $frnd = str_replace("forum-avatar", "center-avatar", $frnd);
                            $frnd = str_replace("<b>", "", $frnd);
                            $frnd = str_replace("</b>", "", $frnd);
                            echo"<li>  $frnd </li>";
                        }
                    }
                    echo"</ul></li>";
                }

                if ($a_onl>0){
                    $friends0 = "friends";
                    $friends_link = "$pref_page$friends0";
                    $Friends_online = __('messages.Friends_online');

                    echo"
                    <li class=\"fcom menu-item non-cursor\">

                    <h3><a href=/$friends_link/$id/visit>$Friends_online ($a_onl)</a></h3>
                    <ul class=\"fr-in-user\">";

                    $f_his="";

                    for($a=0; $a<$a_onl_nr; $a++){

						$ah=rand(0,$a_onl-1); $Numfr=$group_onl['friend'][$ah];
						$filename = "storage/last_visit/$Numfr.txt";

						if (mb_strstr($f_his,"$Numfr")=="" && file_exists($filename) && filesize($filename) > 0){
							$f_his.=" $Numfr ";

                            $frnd = avt($Numfr,$my_id);
                            $frnd = str_replace("forum-avatar", "center-avatar", $frnd);
                            $frnd = str_replace("<b>", "", $frnd);
                            $frnd = str_replace("</b>", "", $frnd);
                            echo"<li>  $frnd </li>";
                        }
                    }
                    echo"</ul></li>";
                }

                if ($a_rin>0){
                    $friends0 = "infriends";
                    $friends_link = "$pref_page$friends0";
                    $Infriends = __('messages.Infriends');

                    echo"<li class=\"fcom menu-item non-cursor\">

                    <h3><a href=/$friends_link/$id/visit>$Infriends ($a_rin)</a></h3>
                    <ul class=\"fr-in-user\">";

                    $f_his="";

                    for($a=0; $a<$a_rin_nr; $a++){

						$ah=rand(0,$a_rin-1);
						 $Numfr=$group_in['friend'][$ah];

						$filename = "storage/last_visit/$Numfr.txt";

						if (mb_strstr($f_his,"$Numfr")=="" && file_exists($filename) && filesize($filename) > 0){
							$f_his.=" $Numfr ";

							$frnd = avt($Numfr,$my_id);
							$frnd = str_replace("forum-avatar", "center-avatar", $frnd);
							$frnd = str_replace("<b>", "", $frnd);
							$frnd = str_replace("</b>", "", $frnd);
							echo"<li class=\"fr-in-user-item\"> $frnd  </li>";
						}
                    }

                    echo"</ul></li>";
                }


            echo"$right_colomn";
            @endphp
                </ul>
            </section>



        </section>
        <div style="display: none;" id="fc">{{$_SERVER['REQUEST_URI']}}</div>
        <div style="display: none;" id="rate">{{$rate}}</div>
        <div style="display: none;" id="id_page">{{$id}}</div>
    @endif



    <br /><br />
@endsection
