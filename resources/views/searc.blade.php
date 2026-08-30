@extends('layouts.app')

@php
$title = __('messages.searc_tit');
$description = __('messages.searc_des');
$keywords = __('messages.searc_keyw');
$index_go="index,follow";

if(isset($_POST['idcc'])){$idcc = $_REQUEST['idcc'];}
else if(isset($idcc)){}else {$idcc = "";}
if(isset($_POST['obl'])){$obl = $_REQUEST['obl'];}
else if(isset($obl)){}else {$obl = "";}


        if($_REQUEST){

            $obl = $_REQUEST['obl'];
            if(isset($_POST['idcc'])){$idcc = $_REQUEST['idcc'];  } else {$idcc = "";}
            $sort = $_REQUEST['sort']; if($sort=="sumr"){$sort2="desc";} else {$sort2="asc";}
            $skip = $_REQUEST['skip']; $skip50 = $skip*20;

            if($obl>0){ $q_s[0] = ['obl', '=', $obl]; }
            if($idcc>0){ $q_s[1] = ['rayc', '=', $idcc];}
            if(isset($q_s)){}else {$q_s[0] = ['id', '<>', 0];}

             $Alls = DB::table('Allcities')->
                select('City', 'City2', 'City3', 'obl', 'rayc', 'status', 'vol_karta', 'id', 'ab')->
                where($q_s)->
                orderBy($sort, $sort2)->
                skip($skip50)->take(21)->
                get();
                $Alln = $Alls->count();
        }
        else if($idcc>0 || $obl>0){

            if(isset($_POST['sort'])){$sort = $_REQUEST['sort'];}
            if(isset($_POST['skip'])){$skip = $_REQUEST['skip'];} else{$skip = 0;}
             if($idcc>0){ $q_s[1] = ['rayc', '=', $idcc]; $obl = "";  $limit = 21;  $skip50 = $skip*20;}
             if($obl>0){ $q_s[2] = ['obl', '=', $obl]; $idcc = "";  $limit = 21;  $skip50 = $skip*20;}

             $Alls = DB::table('Allcities')->
                select('City', 'City2', 'City3', 'obl', 'rayc', 'status', 'vol_karta', 'id', 'ab') ->
                where($q_s)->
                orderBy($sort, 'desc')->
                skip($skip50)->take($limit)->
                get();
             $Alln = $Alls->count();
        }
        else{$sort="sumr";
            $obl = "";  $idcc = "";

             $q_s = ""; $skip=0;
             $Alls = DB::table('Allcities')->
                select('City', 'City2', 'City3', 'obl', 'rayc', 'status', 'vol_karta', 'id', 'ab')->
                orderBy('sumr', 'desc')->
                limit(21)->
                get();
             $Alln = $Alls->count();
        }

if($obl>0 && $obl<26){
            $ob_user2 = __('messages.Region2');
            $ob_user3 = __('messages.Region3');
          for ($i = 0; $i <= 25; $i++){
             $ni2 = "messages.o$i"; $ni3 = "messages.oo$i"; $ii = "$i";
               if($obl == $ii){ $nii2 = __($ni2); $nii3 = __($ni3); if($obl == "1"){ $ob_user2 = ""; $ob_user3 = "";}
               $obl_user2 = " $nii2 $ob_user2"; $obl_user3 = " $nii3 $ob_user3";
              if (App::isLocale('ru')){ $obl_user="<a href=/rse$i>$nii2 $ob_user2</a>";}
              else if (App::isLocale('en')){  $obl_user="<a href=/ese$i>$nii2 $ob_user2</a>";}
              else {$obl_user="<a href=/se$i>$nii2 $ob_user2</a>";}
               }
          }
$keywords = $keywords.=" $obl_user2";
$title = "$obl_user2 - $title";
} else {$obl_user = ""; $obl_user2 = "";}

if($idcc>0){
            $Allc = DB::table('Allcities')->select('ab')->
                where('id', $idcc)->limit(1)->get();
                $nc=0;
                foreach ($Allc as $All) { $ab=$All->ab; $nc++;}
                if($nc!=0){
                    $pagec = explode("#!", $ab);
                    $status=$pagec[5]; $vol_karta=$pagec[6];
                     $City=$pagec[1]; $City2=$pagec[2]; $City3=$pagec[11]; $domen=$pagec[12];

                    if ($status){
                        if ($status==1){$statusr=__('messages.statusnv1'); $statusm=__('messages.statusm1');}
                        if ($status==2){$statusr=__('messages.statusnv2'); $statusm=__('messages.statusm2');}
                        if ($status==3){$statusr=__('messages.statusnv3'); $statusm=__('messages.statusm3');}
                        if ($status==4){$statusr=__('messages.statusnv4'); $statusm=__('messages.statusm4');}
                        if ($status==5){$statusr=__('messages.statusnv5'); $statusm=__('messages.statusm5');}
                    }
                    else{
                    if (!$vol_karta||$vol_karta<20000){$statusr=__('messages.statusnv5'); $statusm=__('messages.statusm5');}
                    if ($vol_karta>=20000&&$vol_karta<50000){$statusr=__('messages.statusnv6'); $statusm=__('messages.statusm6');}
                    if ($vol_karta>=50000){$statusr=__('messages.statusnv1'); $statusm=__('messages.statusm1');}
                    }

                    $ray_r=__('messages.ray_r');
                           if (App::isLocale('ru')){
                               $c_user2="$statusr $City2"; $c_user3="$statusm $City2";
                               $c_user="$title $ray_r <a href=/$domen/ru>$statusm $City2</a>";}
                          else if (App::isLocale('en')){
                              $c_user2="$City3 $statusr"; $c_user3="$City3 $statusm ";
                              $c_user="$title $ray_r of <a href=/$domen/en> $City3 $statusm</a>";}
                          else {$c_user2 = "$statusr $City"; $c_user3="$statusm $City";
                          $c_user="$title $ray_r <br /><a href=/$domen> $statusm $City</a>";}

                    $description = $description.=" $ray_r of $c_user3";
                    $title = "$c_user2 - $title";
                } else {$c_user = ""; $c_user2 = ""; $c_user3 = ""; $City_s ="";}
}                else {$c_user = ""; $c_user2 = ""; $c_user3 = ""; $City_s ="";}

@endphp

@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection


@section('content')

<script>


    function active(arrea, status)
    {
        if (!status)
        {
            document.getElementById(arrea).style.visibility = "visible";
            document.getElementById(arrea+'_text').style.visibility = "visible";
        }
        if (status == 1)
        {
            document.getElementById(arrea).style.visibility = "visible";
        }

    }

    function inactive(arrea, status)
    {
        if (!status)
        {
            document.getElementById(arrea).style.visibility = "hidden";
            document.getElementById(arrea+'_text').style.visibility = "hidden";
        }
        if (status == 1)
        {
            document.getElementById(arrea).style.visibility = "hidden";
        }
    }

    function build_arrea(arrea, name_arrea, x, y)
    { x=x+30;
        var str='';
        str+='<div id="'+arrea+'" style="visibility : hidden; position : absolute; margin-top: '+y+'px; margin-left: '+x+'px; ">';
        str+='<img src="map/'+arrea+'.gif" border="0"></div>';
        if ((arrea == 'kc') || (arrea == 'sv')) {y=y-12; x=x-10;};
        if (x>=74) {x=x-90;} else {x=x-5;}; if (y<=35) {y=y+75;};
        str+='<div id="'+arrea+'_text" style="visibility : hidden; position : absolute; margin-top: '+(y-35)+'px; margin-left: '+x+'px; "><table cellpadding="0" cellspacing="0" border="0">';
        str+='<tr><td class="left"><img src="images/1x1.gif" width="1" height="1"></td><td bgcolor="#DDE2F5" class="content" style="padding: 2px">'+name_arrea+'</td><td class="right"><img src="images/1x1.gif" width="1" height="1"></td></tr>';

        str+='</table></div>'
        str+='';
        document.write(str);
    }

</script>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
        crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-7495053896041990"
     data-ad-slot="9818842788"></ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br />

<section id="ind-whole">

    <section>
        @if($obl>0 || $idcc)
            <section class="fcom0 sear-tit" >
                @if($obl>0) <h1>@php echo"$obl_user"; @endphp </h1> @endif
                @if($idcc>0) <h1>@php echo"$c_user"; @endphp</h1> @endif
                @if($Alln==0)

                    <h1>{{__('messages.no_p_results')}}</h1>
                    <h2> {{__('messages.no_p_results2')}}</h2>

                    @php
                        $Num=""; $Imp="";  $Batp=""; $Prizp=""; $domenp=""; $Nump=""; $avatarp="";
                         $sexp=""; $Whop=""; $Whererp=""; $idcp=""; $aktivp=""; $M6=""; $l_visitp=""; $abp="";
                    @endphp
                @endif
            </section>
        @endif
        @php

        $nu = 0;
        if($Alln>0){
            echo"<ul class=\"menu-list \">";
        }

        foreach ($Alls as $All) {
            $City=$All->City; $City2=$All->City2; $City3=$All->City3; $oblm=$All->obl;
            $rayc=$All->rayc; $statusm=$All->status; $vol_kartam=$All->vol_karta;
             $idm=$All->id; $ab=$All->ab;
             if($ab){ $pagec = explode("#!", $ab);
            $nrf=$pagec[7]; $nrm=$pagec[8]; $nrv=$pagec[9]; $nrp=$pagec[10]; $domen=$pagec[12];
            }
             else {$nrf=""; $nrm=""; $nrv=""; $nrp=""; $domen="";}
            if ($nrf>0){
                $statusfp="
                <div class=\"searc-item-item\">
                    $nrf
                    <svg alt='" . __('messages.all_photos'). " ' width=\"14\" height=\"13\" >
                        <use href=\"/images/icons-searc.svg#icon-images\"></use>
                    </svg>
                </div>";
            }
            else{$statusfp="";}
            if ($nrm>0){
                $statusmp="
                <div class=\"searc-item-item\">
                    $nrm
                    <svg alt='" . __('messages.all_records'). " ' width=\"14\" height=\"13\" >
                        <use href=\"/images/icons-searc.svg#icon-bubble\"></use>
                    </svg>
                </div>";
            }
            else{$statusmp="";}
            if ($nrv>0){$statusvp="$nrv <img src=/images/ivideo.png>";} else{$statusvp="";}
            if ($nrp>0){
                $statuspp="
                <div class=\"searc-item-item\">
                    $nrp
                    <svg alt='" . __('messages.people0'). " ' width=\"14\" height=\"13\" >
                        <use href=\"/images/icons-searc.svg#icon-users\"></use>
                    </svg>
                </div>";
            }
            else{$statuspp="";}

                 if ($statusm){
                    if ($statusm==1){$statusn=__('messages.statusn1');}
                    if ($statusm==2){$statusn=__('messages.statusn2');}
                    if ($statusm==3){$statusn=__('messages.statusn3');}
                    if ($statusm==4){$statusn=__('messages.statusn4');}
                    if ($statusm==5){$statusn=__('messages.statusn5');}
                }
                else{
                    if (!$vol_kartam||$vol_kartam<20000){$statusn=__('messages.statusn5');}
                    if ($vol_kartam>=20000&&$vol_kartam<50000){$statusn=__('messages.statusn6');}
                    if ($vol_kartam>=50000){$statusn=__('messages.statusn1');}
                }
                    if (App::isLocale('ru')){
                        $Ct=$City2;
                        $lan = "ru";
                    }
                    else if (App::isLocale('en')){
                        $Ct=$City3;
                        $lan = "en";
                    }
                    else{
                        $Ct=$City;
                        $lan = "";
                    }

                    if($nu<20){
                    echo"<li class=\"fcom searc-item\">
                        <a href=/$domen/$lan>";
                        if($rayc==$idm){echo"<b>";}
                        echo"$Ct ";
                        if($rayc==$idm){echo"</b>";}
                        echo"$statusfp $statusmp $statusvp $statuspp</a>
                    </li>";
                    }
              $nu++;
            }

        @endphp

        @if($Alln>0)
        @php echo"</ul>"; @endphp
            <section class="sear-bott" >

                <form name=psee2 action="{{ route('searc_seek') }}" method="post">
                    @csrf
                    <input type="hidden" name="obl" value={{$obl}}>
                    @php if($idcc==""){$idcc=0; $idcc=$idcc+1; $idcc=$idcc-1;} @endphp
                    <input type="hidden" name="idcc" value={{$idcc}}>

                    <input type="hidden" name="skip" id="skip"  value="">
                    @php $skipb=$skip-1;  $skipn=$skip+1;          @endphp
                    <input type="hidden" name="skipb" id="skip"  value={{$skipb}}>
                    <input type="hidden" name="skipn" id="skip"  value={{$skipn}}>
                    <input type="hidden" name="sort" id="sort"  value={{$sort}}>
                    @php $sort2 = __('messages.sort2'); $sort4 = __('messages.sort4');
                       if (App::isLocale('ru')){ $City_s = "City2"; }
                       else if (App::isLocale('en')){ $City_s = "City3"; }
                       else {$City_s = "City";}

            echo"<ul class=\"searc-nav\">";
                if($sort=="$City_s"){
                    echo"
                    <li><span>$sort4</span></li>
                    <li><a href=## onclick=form_send2('sumr') rel=\"noopener noreferrer\">$sort2</a></li>";
                }
                if($sort=="sumr"){
                    echo"
                    <li><a href=## onclick=form_send2('$City_s') rel=\"noopener noreferrer\">$sort4</a></li>
                    <li><span>$sort2</span></li>";
                }
                if($skip!=0){
                    echo"<li><a href=## onclick=form_send('$skipb') rel=\"noopener noreferrer\">" . __('messages.back') . "</a></li>";
                }
                if($nu==21){
                    echo"<li><a href=## onclick=form_send('$skipn') rel=\"noopener noreferrer\">" . __('messages.next') . "</a></li>";
                }
            echo"</ul>";
                @endphp
                </form>
                <span class="searc-nav-react"> {{__('messages.react')}}</span>
            </section>

        @endif

    </section>

    <section style=" width: 468px;">
        @php
            $pp = __('messages.pref_page');
        @endphp
        <section class="fcom0" style=" padding: 15px; ">
            <h2> {{ __('messages.see-map') }}</h2>
            <section  style="width: 175px; margin: 20px auto 10px; ">

                <DIV style="position: absolute;">
                    <IMG height=119 width=175 alt="{{__('messages.u-map')}}" src="/map/map.gif">
                </DIV>
                <SCRIPT>
                    build_arrea('lug','{{__('messages.ooo13')}}',123,30);
                    build_arrea('don','{{__('messages.ooo5')}}',112,43);
                    build_arrea('zap','{{__('messages.ooo8')}}',90,61);
                    build_arrea('kha','{{__('messages.ooo21')}}',91,25);
                    build_arrea('arc','{{__('messages.ooo1')}}',73,91);
                    build_arrea('khe','{{__('messages.ooo22')}}',64,71);
                    build_arrea('dnp','{{__('messages.ooo4')}}',76,47);
                    build_arrea('pol','{{__('messages.ooo16')}}',65,27);
                    build_arrea('sum','{{__('messages.ooo18')}}',72,0);
                    build_arrea('chg','{{__('messages.ooo25')}}',49,0);
                    build_arrea('mik','{{__('messages.ooo14')}}',48,63);
                    build_arrea('kir','{{__('messages.ooo11')}}',43,50);
                    build_arrea('chk','{{__('messages.ooo24')}}',41,33);
                    build_arrea('kiv','{{__('messages.ooo10')}}',38,14);
                    build_arrea('vin','{{__('messages.ooo3')}}',19,40);
                    build_arrea('zht','{{__('messages.ooo6')}}',18,13);
                    build_arrea('hml','{{__('messages.ooo20')}}',8,29);
                    build_arrea('chn','{{__('messages.ooo23')}}',-4,56);
                    build_arrea('ter','{{__('messages.ooo19')}}',-6,32);
                    build_arrea('vol','{{__('messages.ooo2')}}',-15,7);
                    build_arrea('lvv','{{__('messages.ooo12')}}',-24,28);
                    build_arrea('ifr','{{__('messages.ooo9')}}',-19,43);
                    build_arrea('zak','{{__('messages.ooo7')}}',-30,49);
                    build_arrea('riv','{{__('messages.ooo17')}}',-2,8);
                    build_arrea('ods','{{__('messages.ooo15')}}',30,63);
                    build_arrea('kc','{{__('messages.ooo26')}}',44,25);
                    build_arrea('sv','{{__('messages.ooo27')}}',81,108);
                </SCRIPT>

                <DIV id=main style="position: relative; ">
                    <IMG width=175 height=120 alt="{{__('messages.u-map')}}" src="/map/175x120.png" useMap=#Map>
                    <MAP name=Map>
                        <AREA onmouseover="active('arc',0)" onmouseout="inactive('arc',0)" shape=POLY
                              coords=104,104,119,94,129,101,138,101,145,105,128,113,119,117 href="/{{$pp}}se1">
                        <AREA onmouseover="active('vin',0)" onmouseout="inactive('vin',0)" shape=POLY
                              coords=51,62,54,49,54,41,64,40,69,44,75,62,69,65,63,64,56,60  href="/{{$pp}}se3">
                        <AREA onmouseover="active('vol',0)" onmouseout="inactive('vol',0)" shape=POLY
                              coords=34,9,16,11,18,24,30,37,36,33,37,19 href="/{{$pp}}se2">
                        <AREA onmouseover="active('dnp',0)" onmouseout="inactive('dnp',0)" shape=POLY
                              coords=116,55,123,49,143,57,136,64,118,72,105,68,109,71 href="/{{$pp}}se4">
                        <AREA onmouseover="active('don',0)" onmouseout="inactive('don',0)" shape=POLY
                              coords=151,43,141,54,143,66,149,75,156,71,165,60,156,49 href="/{{$pp}}se5">
                        <AREA onmouseover="active('zht',0)" onmouseout="inactive('zht',0)" shape=POLY
                              coords=47,29,53,42,71,44,71,30,67,14,59,15,51,15 href="/{{$pp}}se6">
                        <AREA onmouseover="active('zak',0)" onmouseout="inactive('zak',0)" shape=POLY
                              coords=4,50,1,61,7,64,20,66,13,56 href="/{{$pp}}se7">
                        <AREA onmouseover="active('zap',0)" onmouseout="inactive('zap',0)" shape=POLY
                              coords=122,75,128,89,144,80,142,64,127,62 href="/{{$pp}}se8">
                        <AREA onmouseover="active('ifr',0)" onmouseout="inactive('ifr',0)" shape=POLY
                              coords=24,43,28,53,34,59,26,68,20,60,12,54,12,53 href="/{{$pp}}se9">
                        <AREA onmouseover="active('kiv',0)" onmouseout="inactive('kiv',0)" shape=POLY
                              coords=80,28,76,33,81,36,84,32,81,27,74,16,66,16,68,43,73,52,84,45,93,34,82,31 href="/{{$pp}}se10">
                        <AREA onmouseover="active('kir',0)" onmouseout="inactive('kir',0)" shape=POLY
                              coords=114,52,105,51,93,53,87,57,75,63,80,65,90,64,101,68,108,66,112,58,114,56 href="/{{$pp}}se11">
                        <AREA onmouseover="active('lug',0)" onmouseout="inactive('lug',0)" shape=POLY
                              coords=151,45,154,31,165,33,176,39,174,49,176,61,170,62,159,54 href="/{{$pp}}se13">
                        <AREA onmouseover="active('lvv',0)" onmouseout="inactive('lvv',0)" shape=POLY
                              coords=21,29,6,42,9,50,14,53,25,42,31,37,23,32 href="/{{$pp}}se12">
                        <AREA onmouseover="active('mik',0)" onmouseout="inactive('mik',0)" shape=POLY
                              coords=81,72,89,81,78,65,94,65,108,72,107,83,95,85 href="/{{$pp}}se14">
                        <AREA onmouseover="active('ods',0)" onmouseout="inactive('ods',0)" shape=POLY
                              coords=68,66,73,80,75,87,67,91,62,107,75,100,89,85,83,73,73,64 href="/{{$pp}}se15">
                        <AREA onmouseover="active('pol',0)" onmouseout="inactive('pol',0)" shape=POLY
                              coords=96,33,107,28,116,28,126,41,118,54,106,50 href="/{{$pp}}se16">
                        <AREA onmouseover="active('riv',0)" onmouseout="inactive('riv',0)" shape=POLY
                              coords=33,36,38,9,41,10,51,15,44,33,43,32 href="/{{$pp}}se17">
                        <AREA onmouseover="active('sum',0)" onmouseout="inactive('sum',0)" shape=POLY
                              coords=104,28,115,27,123,34,126,20,117,14,112,5,111,2,103,7,102,17 href="/{{$pp}}se18">
                        <AREA onmouseover="active('ter',0)" onmouseout="inactive('ter',0)" shape=POLY
                              coords=41,32,39,57,28,51,27,43,34,34 href="/{{$pp}}se19">
                        <AREA onmouseover="active('kha',0)" onmouseout="inactive('kha',0)" shape=POLY
                              coords=153,33,148,25,133,27,122,35,124,50,141,52,153,43 href="/{{$pp}}se21">
                        <AREA onmouseover="active('khe',0)" onmouseout="inactive('khe',0)" shape=POLY
                              coords=95,88,102,88,103,86,99,84,107,82,109,72,112,72,114,71,121,75,124,80,129,88,123,91,113,93,103,95 ref="/{{$pp}}se22">
                        <AREA onmouseover="active('hml',0)" onmouseout="inactive('hml',0)" shape=POLY
                              coords=40,33,53,41,55,52,51,60,43,58,38,45 href="/{{$pp}}se20">
                        <AREA onmouseover="active('chk',0)" onmouseout="inactive('chk',0)" shape=POLY
                              coords=75,60,72,51,79,48,85,46,88,41,96,33,106,50,92,53 href="/{{$pp}}se24">
                        <AREA onmouseover="active('chn',0)" onmouseout="inactive('chn',0)"
                              shape=POLY coords=26,68,33,66,50,58,40,61,34,58 href="/{{$pp}}se23">
                        <AREA onmouseover="active('chg',0)" onmouseout="inactive('chg',0)" shape=POLY
                              coords=105,29,103,17,105,2,94,4,84,5,78,18,86,29,96,32 href="/{{$pp}}se25">
                        <AREA onmouseover="active('kc',0)" onmouseout="inactive('kc',0)"
                              shape=CIRCLE coords=80,31,4 href="/{{$pp}}c233">
                        <AREA onmouseover="active('sv',0)" onmouseout="inactive('sv',0)"
                              shape=CIRCLE coords=118,114,4 href="/{{$pp}}c234">
                    </MAP>
                </DIV>

            </section>
        </section>
    @php
        if($obl){
            $obl=intval($obl);
            $Allr = DB::table('Allcities')->select($City_s, 'rayc')->
             where('obl', $obl)->
             whereRaw('rayc = id')->
            orderBy($City_s, 'asc')->get();
            $Allrn = $Allr->count();
            if ($Allrn>0){
               $pref_page = __('messages.pref_page');
               $sed = $pref_page.="sed";

                echo"
                <section class=\"fcom0 raycs mt10\">
                    <h2>" . __('messages.ray_see') . $obl_user3 . " " . __('messages.ray_see2') . ":</h2>
                    <ul>";

                foreach ($Allr as $Alr) {
                    $City_rr=$Alr->$City_s; $rayc=$Alr->rayc;
                    echo"<li><a href=/$sed$rayc> $City_rr </a></li>";
                }
                echo"</ul>
                </section>";
                }

/*
                    $filename = "obl_news/a_$obl.txt";
                    $memory_contentsa = Storage::disk('public')->get($filename);
                    if (mb_strlen($memory_contentsa)>100) {

                        $news = __('messages.News');
                        echo"<br /><table><tr><td class=fcom width=450 align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                        <br /><b>$news $obl_user3</b><br /><br />
                        <table><tr><td width=400 align=left>
                        <table>";

                        $memory_n = substr_count($memory_contentsa,"#!:*&");
                        $memory_pagea = explode("#!:*&", $memory_contentsa);
                        $page_ah="";
                        $npa=1;
                        for($memory_n; $npa<=$memory_n; $memory_n--){
                        $page_a=$memory_pagea[$memory_n];
                        if($page_ah!=$page_a){echo" $page_a";}
                        $page_ah=$page_a;
                        }
                        echo"</table>
                        </td></tr></table><br />
                        </td></tr></table>";
                    }


                    $filename = "obl_news/top_$obl.txt";
                    $memory_contentsa = Storage::disk('public')->get($filename);
                    if (mb_strlen($memory_contentsa)>100) {
                        $news10 = __('messages.News10'); $news10upd = __('messages.News10upd');
                        echo"<br />
                        <table><tr><td class=fcom width=450 align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                        <br /><b>$news10 $obl_user3</b><br /><br />
                        <table><tr><td width=400 align=left>";
                        echo" $memory_contentsa <font color=gray>$news10upd</font><br />
                        </td></tr></table><br />
                        </td></tr></table>";
                    }
*/
            }
    @endphp
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                crossorigin="anonymous"></script>
        <ins class="adsbygoogle"
             style="display:block; text-align:center;"
             data-ad-layout="in-article"
             data-ad-format="fluid"
             data-ad-client="ca-pub-7495053896041990"
             data-ad-slot="9818842788"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

    </section>

</section>


@endsection
