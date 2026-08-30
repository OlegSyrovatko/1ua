@extends('layouts.app')
@php
global $cwindowonload;
$cwindowonload = "go";
$my_domen = $_SERVER['SERVER_NAME'];
$start_time = microtime(true);

if($domen != "0") {

        $Alls = DB::table('Allcities')->select('id')->
        where('domen', $domen)->
      limit(1)->
        get();
            $nd=0;
        foreach ($Alls as $All) {  $id=$All->id; $nd++;}
        if($nd==0){$title = __('messages.unknown_page');}
}
if( $id == "0") {$nd=0; $title = __('messages.unknown_page');
                    $description = $title;
            $keywords = $title;
            $rayc=""; $City="";  $City2=""; $City3=""; $sumr="";
             $obl=""; $status="";  $x="";  $y=""; $z="";
              $vol_karta=""; $face_karta=""; $oblc=""; $apps="";
               $City_m=""; $City_o=""; $City_r=""; $City_d="";
                $rod=""; $vin=""; $dat=""; $tvor=""; $predl="";
                $domen=""; $places=""; $questions=""; $ab="";
              $index_go = "noindex,follow"; $path1 = ""; $fpath=""; $flinka = "";
              $nrf7=""; $nrm7=""; $nrv7=""; $nrp7=""; $City_s="";
              $City_in=""; $City_of=""; $City_by=""; $City_to="";
}

else{
    $Alls = DB::table('Allcities')->
    select('rayc', 'City', 'City2', 'City3', 'sumr', 'obl', 'status', 'x', 'y', 'z', 'vol_karta', 'map_w', 'map_h', 'face_karta', 'oblc',
    'apps', 'City_m', 'City_o', 'City_r', 'City_d', 'rod', 'vin', 'dat', 'tvor',
     'predl', 'domen', 'places', 'questions', 'ab')->
        where('id', $id)-> limit(1)-> get();
            $nd=0;
        foreach ($Alls as $All) {
            $rayc=$All->rayc; $City1=$All->City;  $City2=$All->City2;  $City3=$All->City3;  $sumr=$All->sumr;
             $obl=$All->obl; $status=$All->status;  $x=$All->x;  $y=$All->y;  $z=$All->z;
              $vol_karta=$All->vol_karta; $map_w=$All->map_w; $map_h=$All->map_h; $face_karta=$All->face_karta;  $oblc=$All->oblc;  $apps=$All->apps;
               $City_m=$All->City_m;  $City_o=$All->City_o; $City_r=$All->City_r;  $City_d=$All->City_d;
                $rod=$All->rod; $vin=$All->vin;  $dat=$All->dat;  $tvor=$All->tvor;  $predl=$All->predl;
                $domen=$All->domen;  $places=$All->places; $questions=$All->questions;  $ab=$All->ab;
                $pagec = explode("#!", $ab); $nrf7=$pagec[7]; $nrm7=$pagec[8]; $nrv7=$pagec[9]; $nrp7=$pagec[10];

          $lanem = App::currentLocale();  if(!$lanem){$lanem = "ua";}
        if($lanem == "ua"){$City_in=$City_m; $City_of=$City_r; $City_by=$City_o; $City_to=$City_d;}
        if($lanem == "ru"){$City_in=$predl; $City_of=$rod; $City_by=$tvor; $City_to=$predl;}
        if($lanem == "en"){$City_in="in $City3";$City_of="of $City3"; $City_by="by $City3";$City_to="to $City3";}
            $nd++;

        }
        if($nd==0){
            $title = __('messages.unknown_page');
            $description = $title;
            $keywords = $title;
            $rayc=""; $City="";  $City2=""; $City3=""; $sumr="";
             $obl=""; $status="";  $x="";  $y=""; $z="";
              $vol_karta=""; $face_karta=""; $oblc=""; $apps="";
               $City_m=""; $City_o=""; $City_r=""; $City_d="";
                $rod=""; $vin=""; $dat=""; $tvor=""; $predl="";
                $domen=""; $places=""; $questions=""; $ab="";
              $index_go = "noindex,follow"; $path1 = ""; $fpath=""; $flinka = "";
              $nrf7=""; $nrm7=""; $nrv7=""; $nrp7=""; $City_s="";
              $City_in=""; $City_of=""; $City_by=""; $City_to="";

        }
        else {
             if ($status){
                if ($status==1){$ss=1;
                    $statusn=__('messages.statusn1');
                    $statusnv=__('messages.statusnv1');
                    $statusr=__('messages.statusr1');
                    $statusd=__('messages.statusd1');
                    $statusm=__('messages.statusm1');
                    $statuso=__('messages.statuso1');
                    $statuspro=__('messages.statuspro1');
                }
                if ($status==2){$ss=2;
                    $statusn=__('messages.statusn2');
                    $statusnv=__('messages.statusnv2');
                    $statusr=__('messages.statusr2');
                    $statusd=__('messages.statusd2');
                    $statusm=__('messages.statusm2');
                    $statuso=__('messages.statuso2');
                    $statuspro=__('messages.statuspro2');
                }
                if ($status==3){$ss=3;
                    $statusn=__('messages.statusn3');
                    $statusnv=__('messages.statusnv3');
                    $statusr=__('messages.statusr3');
                    $statusd=__('messages.statusd3');
                    $statusm=__('messages.statusm3');
                    $statuso=__('messages.statuso3');
                    $statuspro=__('messages.statuspro3');
                }
                if ($status==4){$ss=4;
                    $statusn=__('messages.statusn4');
                    $statusnv=__('messages.statusnv4');
                    $statusr=__('messages.statusr4');
                    $statusd=__('messages.statusd4');
                    $statusm=__('messages.statusm4');
                    $statuso=__('messages.statuso4');
                    $statuspro=__('messages.statuspro4');
                }
                if ($status==5){$ss=5;
                    $statusn=__('messages.statusn5');
                    $statusnv=__('messages.statusnv5');
                    $statusr=__('messages.statusr5');
                    $statusd=__('messages.statusd5');
                    $statusm=__('messages.statusm5');
                    $statuso=__('messages.statuso5');
                    $statuspro=__('messages.statuspro5');
                }
            }
            else{
                if (!$vol_karta||$vol_karta<20000){$ss=4;
                        $statusn=__('messages.statusn4');
                        $statusnv=__('messages.statusnv4');
                        $statusr=__('messages.statusr4');
                        $statusd=__('messages.statusd4');
                        $statusm=__('messages.statusm4');
                        $statuso=__('messages.statuso4');
                        $statuspro=__('messages.statuspro4');
                }
                if ($vol_karta>=20000&&$vol_karta<50000){$ss=2;
                        $statusn=__('messages.statusn6');
                        $statusnv=__('messages.statusnv6');
                        $statusr=__('messages.statusr6');
                        $statusd=__('messages.statusd6');
                        $statusm=__('messages.statusm6');
                        $statuso=__('messages.statuso6');
                        $statuspro=__('messages.statuspro6');
                }
                if ($vol_karta>=50000){$ss=1;
                        $statusn=__('messages.statusn1');
                        $statusnv=__('messages.statusnv1');
                        $statusr=__('messages.statusr1');
                        $statusd=__('messages.statusd1');
                        $statusm=__('messages.statusm1');
                        $statuso=__('messages.statuso1');
                        $statuspro=__('messages.statuspro1');
                }
            }

            if(mb_strlen($rod)>2){} else{$rod="$statusr $City2";}
            if(mb_strlen($dat)>2){} else{$dat="$statusd $City2";}
            if(mb_strlen($vin)>2){} else{$vin="$statusn $City2";}
            if(mb_strlen($tvor)>2){} else{$tvor="$statuso $City2";}
            if(mb_strlen($predl)>2){} else{$predl="$statusm $City2";}



    $ob_user2 = __('messages.Region3');
    $City=$City1; $City_s="City";
    if (App::isLocale('ru')){$City=$City2; $City_s="City2";}
    if (App::isLocale('en')){$City=$City3; $City_s="City3";}

              for ($i = 0; $i <= 25; $i++){
                 $ni2 = "messages.oo$i"; $ii = "$i";
                   if($obl == $ii){ $nii2 = __($ni2); if($obl == "1"){ $ob_user2 = "";}
                   $obl_user2 = "$nii2 $ob_user2";
                   $obl_user="<a href=/se$i>$nii2 $ob_user2</a>";
                      if (App::isLocale('ru')){ $obl_user="<a href=/rse$i>$nii2 $ob_user2</a>";}
                      if (App::isLocale('en')){ $obl_user="<a href=/ese$i>$nii2 $ob_user2</a>";}

                   }
              }
$news = __('messages.news'); $gr_site = __('messages.gr_site');
if($id==$oblc){$title = "$statusnv $City";}
else if($id==$rayc){$title = "$statusnv $City $obl_user2 - $news";}
else{$title = "$statusnv $City $obl_user2 - $gr_site: $news";}

$index_go = "index,follow";

$description1 = __('messages.c1_description');
$description2 = __('messages.c2_description');
$description = "$description1 $statusr $description2";
$keywords1 = __('messages.c1_keywords');
$keywords2 = __('messages.c2_keywords');
$in = __('messages.in');
$keywords = "$statusnv $City $obl_user2 $keywords1 $in $statusm $City_in, $statuso $City_by, $statusd $City_to $keywords2 $statusr";

$flink1 = "/storage/karta/$obl/$id.jpg";
$flink0 = "/storage/karta/$obl/face_$id.jpg";
$file1 = public_path($flink1);
$file0 = public_path($flink0);
$tmap = __('messages.tmap');
$map_w = $map_w/1.2;
$map_h = $map_h/1.2;

if(file_exists($file0)){
    $fpath = $flink0;
    $flinka = "<section class=\"fcom margin-bottom pad10-5\">
        <h4>$tmap $City_of</h4><br />
        <a href=\"$flink1\">
            <div class=\"scale\">
                <img width=$map_w height=$map_h alt=\"$tmap $City_of\" title=\"$statusnv $City\" src=\"$flink0\">
            </div>
        </a>
    </section>";
}
else if(file_exists($file1)){
    $fpath = $flink1;
    $flinka = "<section class=\"fcom margin-bottom pad10-5\">
        <h4>$tmap $City_of</h4><br />
        <div class=\"scale\">
            <img width=$map_w height=$map_h alt=\"$tmap $City_of\" title=\"$statusnv $City\" src=\"$flink1\">
        </div>
    </section>";
}
else {$fpath = "";  $flinka = "";}

}


}
@endphp


@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection
@section('image'){{$fpath}}@endsection

@section('content')


@if($nd==0)

    @if($domen != "0") @php $unnp2 = __('messages.unknown_page2'); @endphp
    @else @php  $unnp2 = __('messages.unknown_page3'); @endphp
    @endif

    <br /><br /><br /><div align='center'><table class=fcom><tr><td align=center>
                    <div style="align-content: center; padding-right: 30px; padding-left: 30px" >
                        <h4><br />{{  $unnp2 }}<br /><br /><a href="javascript:history.go(-1)">{{  __('messages.unknown_page4') }}</a><br /><br /></h4>
                    </div>
                    </td></tr></table></div><br /><br /><br /><br />

@else

    @php $admpass="off"; @endphp
    @guest @php $my_id = ""; @endphp @else
        @php $my_id = Auth::user()->Num;

            $Allad = DB::table('City_Admin2')->select('id')->
    where('Num', $my_id)->where('Page', 'Memory')->where('id', $id)->
    limit(1)->get();
    $Alladn = $Allad->count();
    if($Alladn>0){$admpass="ok";}

        @endphp
    @endguest


@php

$lan = App::currentLocale();
$pref_page = __('messages.pref_page');
$pref_page_f = $pref_page.="nf";
$u1at = "";
$u2at = "";
$u3at = "";
if($lan=="ua" || $lan=="ru"){
    $cq2 = "uatext";
    if ($lan=="ru"){
            $cq2 = "rutext";
    }
    if($id==23334 || $id==73918){
        $Alll = DB::table('life')->
        select($cq2, 'id', 'link')->
        where('actualid', 2)->
        whereNull('non_vis')->
        inRandomOrder()->
        limit(3)->
        get();
    }
    else{
        $Alll = DB::table('life')->
        select($cq2, 'id', 'link')->
        where('actualid', 2)->
        inRandomOrder()->
        limit(3)->
        get();
    }

    $nractlifes = $Alll->count();
    $id_first=0;
    $idrest=0;

    foreach ($Alll as $All) {
        $idl = $All->id;
        $ua = $All->$cq2;
        $link = $All->link;
        $id_first++;

        if($lan=="ua"){
            if($id_first==1){

             $u1a = str_replace("$", "", $ua);
             $u1a = str_replace("City_d", $City_d, $u1a);
             $u1a = str_replace("City_r", $City_r, $u1a);
             $u1a = str_replace("City_o", $City_o, $u1a);
             $u1a = str_replace("City_m", $City_m, $u1a);
             $u1a = str_replace("City", $City, $u1a);
             $u1a = str_replace("statusnv", $statusnv, $u1a);
             $u1a = str_replace("statusn", $statusn, $u1a);
             $u1a = str_replace("statusr", $statusr, $u1a);
             $u1a = str_replace("statusd", $statusd, $u1a);
             $u1a = str_replace("statusm", $statusm, $u1a);
             $u1a = str_replace("statuso", $statuso, $u1a);
             $u1a = str_replace("statuspro", $statuspro, $u1a);
             $u1a = str_replace("domen", $domen, $u1a);


            $ntag=substr_count($u1a, '{');

            for($ntag0=1;$ntag0<=$ntag;$ntag0++){

              $position = strpos($u1a, "{"); $content = substr($u1a, $position+1);
              $position = strpos($content, "}"); $content = substr($content, 0, $position);

            $content2 = "|$content";
            $ntag2=substr_count($content2, '|');
            $words = explode("|", $content2);
            $zn=rand(1,$ntag2);
            $word=$words[$zn];
            $contentr="{"; $contentr.=$content; $contentr.="}";
            $u1a = str_replace("$contentr", "$word", $u1a);

            }


            $u1a = str_replace("<p style='text-indent: 45px;'>", "", $u1a);
            $u1a = str_replace("</p>", "", $u1a);
            $nseek2 = 1;
            $u1a = substr($u1a, 0, 300);
            for($nseek=1;$nseek<20;$nseek++){
             $rest = substr($u1a, -$nseek);
             if(strstr($rest, " ")!=""){$nseek2=$nseek; $nseek=20;}
            }

            $u1a = substr($u1a, 0, 300-$nseek2);

            $u1at="<section class=\"fcom city-block\">
            <a href=/$domen/$lan/$link>$u1a...</a>
            </section>";

            }
            if($id_first==2){

             $u2a = str_replace("$", "", $ua);
             $u2a = str_replace("City_d", $City_d, $u2a);
             $u2a = str_replace("City_r", $City_r, $u2a);
             $u2a = str_replace("City_o", $City_o, $u2a);
             $u2a = str_replace("City_m", $City_m, $u2a);
             $u2a = str_replace("City", $City, $u2a);
             $u2a = str_replace("statusnv", $statusnv, $u2a);
             $u2a = str_replace("statusn", $statusn, $u2a);
             $u2a = str_replace("statusr", $statusr, $u2a);
             $u2a = str_replace("statusd", $statusd, $u2a);
             $u2a = str_replace("statusm", $statusm, $u2a);
             $u2a = str_replace("statuso", $statuso, $u2a);
             $u2a = str_replace("statuspro", $statuspro, $u2a);
             $u2a = str_replace("domen", $domen, $u2a);


            $ntag=substr_count($u2a, '{');

            for($ntag0=1;$ntag0<=$ntag;$ntag0++){

              $position = strpos($u2a, "{"); $content = substr($u2a, $position+1);
              $position = strpos($content, "}"); $content = substr($content, 0, $position);

            $content2 = "|$content";
            $ntag2=substr_count($content2, '|');
            $words = explode("|", $content2);
            $zn=rand(1,$ntag2);
            $word=$words[$zn];
            $contentr="{"; $contentr.=$content; $contentr.="}";
            $u2a = str_replace("$contentr", "$word", $u2a);

            }


            $u2a = str_replace("<p style='text-indent: 45px;'>", "", $u2a);
            $u2a = str_replace("</p>", "", $u2a);
            $nseek2 = 1;
            $u2a = substr($u2a, 0, 300);
            for($nseek=1;$nseek<20;$nseek++){
             $rest = substr($u2a, -$nseek);
             if(strstr($rest, " ")!=""){$nseek2=$nseek; $nseek=20;}
            }

            $u2a = substr($u2a, 0, 300-$nseek2);

            $u2at="<section class=\"fcom city-block\">
            <a href=/$domen/$lan/$link>$u2a...</a>
            </section>";
            }
            if($id_first==3){



             $u3a = str_replace("$", "", $ua);
             $u3a = str_replace("City_d", $City_d, $u3a);
             $u3a = str_replace("City_r", $City_r, $u3a);
             $u3a = str_replace("City_o", $City_o, $u3a);
             $u3a = str_replace("City_m", $City_m, $u3a);
             $u3a = str_replace("City", $City, $u3a);
             $u3a = str_replace("statusnv", $statusnv, $u3a);
             $u3a = str_replace("statusn", $statusn, $u3a);
             $u3a = str_replace("statusr", $statusr, $u3a);
             $u3a = str_replace("statusd", $statusd, $u3a);
             $u3a = str_replace("statusm", $statusm, $u3a);
             $u3a = str_replace("statuso", $statuso, $u3a);
             $u3a = str_replace("statuspro", $statuspro, $u3a);
             $u3a = str_replace("domen", $domen, $u3a);


            $ntag=substr_count($u3a, '{');

            for($ntag0=1;$ntag0<=$ntag;$ntag0++){

              $position = strpos($u3a, "{"); $content = substr($u3a, $position+1);
              $position = strpos($content, "}"); $content = substr($content, 0, $position);

            $content2 = "|$content";
            $ntag2=substr_count($content2, '|');
            $words = explode("|", $content2);
            $zn=rand(1,$ntag2);
            $word=$words[$zn];
            $contentr="{"; $contentr.=$content; $contentr.="}";
            $u3a = str_replace("$contentr", "$word", $u3a);

            }


            $u3a = str_replace("<p style='text-indent: 45px;'>", "", $u3a);
            $u3a = str_replace("</p>", "", $u3a);
            $nseek2 = 1;
            $u3a = substr($u3a, 0, 300);
            for($nseek=1;$nseek<20;$nseek++){
             $rest = substr($u3a, -$nseek);
             if(strstr($rest, " ")!=""){$nseek2=$nseek; $nseek=20;}
            }

            $u3a = substr($u3a, 0, 300-$nseek2);

            $u3at="<section class=\"fcom city-block\">
            <a href=/$domen/$lan/$link>$u3a...</a>
            </section>";
}
        }

        if($lan=="ru"){
            if($id_first==1){


             $u1a = str_replace("$", "", $ua);
             $u1a = str_replace("rod", $rod, $u1a);
             $u1a = str_replace("dat", $dat, $u1a);
             $u1a = str_replace("vin", $vin, $u1a);
             $u1a = str_replace("tvor", $tvor, $u1a);
             $u1a = str_replace("predl", $predl, $u1a);
             $u1a = str_replace("City", $City2, $u1a);
             $u1a = str_replace("statusnv", $statusnv, $u1a);
             $u1a = str_replace("statusne", $statusm, $u1a);
             $u1a = str_replace("statusny", $statusd, $u1a);
             $u1a = str_replace("statusr", $statusr, $u1a);
             $u1a = str_replace("statusno", $statuso, $u1a);
             $u1a = str_replace("statuspro", $statuspro, $u1a);
             $u1a = str_replace("statusn", $statusn, $u1a);
             $u1a = str_replace("domen", $domen, $u1a);


            $ntag=substr_count($u1a, '{');

            for($ntag0=1;$ntag0<=$ntag;$ntag0++){

              $position = strpos($u1a, "{"); $content = substr($u1a, $position+1);
              $position = strpos($content, "}"); $content = substr($content, 0, $position);

            $content2 = "|$content";
            $ntag2=substr_count($content2, '|');
            $words = explode("|", $content2);
            $zn=rand(1,$ntag2);
            $word=$words[$zn];
            $contentr="{"; $contentr.=$content; $contentr.="}";
            $u1a = str_replace("$contentr", "$word", $u1a);

            }


            $u1a = str_replace("<p style='text-indent: 45px;'>", "", $u1a);
            $u1a = str_replace("</p>", "", $u1a);

            $u1a = substr($u1a, 0, 300);
            $nseek2 = 1;
            for($nseek=1;$nseek<20;$nseek++){
             $rest = substr($u1a, -$nseek);
             if(strstr($rest, " ")!=""){$nseek2=$nseek; $nseek=20;}
            }

            $u1a = substr($u1a, 0, 300-$nseek2);

            $u1at="<section class=\"fcom city-block\">
            <a href=/$domen/$lan/$link>$u1a...</a>
            </section>";

            }
            if($id_first==2){


             $u2a = str_replace("$", "", $ua);
             $u2a = str_replace("rod", $rod, $u2a);
             $u2a = str_replace("dat", $dat, $u2a);
             $u2a = str_replace("vin", $vin, $u2a);
             $u2a = str_replace("tvor", $tvor, $u2a);
             $u2a = str_replace("predl", $predl, $u2a);
             $u2a = str_replace("City", $City2, $u2a);
             $u2a = str_replace("statusnv", $statusnv, $u2a);
             $u2a = str_replace("statusne", $statusm, $u2a);
             $u2a = str_replace("statusny", $statusd, $u2a);
             $u2a = str_replace("statusr", $statusr, $u2a);
             $u2a = str_replace("statusno", $statuso, $u2a);
             $u2a = str_replace("statuspro", $statuspro, $u2a);
             $u2a = str_replace("statusn", $statusn, $u2a);
             $u2a = str_replace("domen", $domen, $u2a);


            $ntag=substr_count($u2a, '{');

            for($ntag0=1;$ntag0<=$ntag;$ntag0++){

              $position = strpos($u2a, "{"); $content = substr($u2a, $position+1);
              $position = strpos($content, "}"); $content = substr($content, 0, $position);

            $content2 = "|$content";
            $ntag2=substr_count($content2, '|');
            $words = explode("|", $content2);
            $zn=rand(1,$ntag2);
            $word=$words[$zn];
            $contentr="{"; $contentr.=$content; $contentr.="}";
            $u2a = str_replace("$contentr", "$word", $u2a);

            }


            $u2a = str_replace("<p style='text-indent: 45px;'>", "", $u2a);
            $u2a = str_replace("</p>", "", $u2a);
            $nseek2 = 1;
            $u2a = substr($u2a, 0, 300);
            for($nseek=1;$nseek<20;$nseek++){
             $rest = substr($u2a, -$nseek);
             if(strstr($rest, " ")!=""){$nseek2=$nseek; $nseek=20;}
            }

            $u2a = substr($u2a, 0, 300-$nseek2);

            $u2at="<section class=\"fcom city-block\">
            <a href=/$domen/$lan/$link>$u2a...</a>
            </section>";
            }
            if($id_first==3){


             $u3a = str_replace("$", "", $ua);
             $u3a = str_replace("rod", $rod, $u3a);
             $u3a = str_replace("dat", $dat, $u3a);
             $u3a = str_replace("vin", $vin, $u3a);
             $u3a = str_replace("tvor", $tvor, $u3a);
             $u3a = str_replace("predl", $predl, $u3a);
             $u3a = str_replace("City", $City2, $u3a);
             $u3a = str_replace("statusnv", $statusnv, $u3a);
             $u3a = str_replace("statusne", $statusm, $u3a);
             $u3a = str_replace("statusny", $statusd, $u3a);
             $u3a = str_replace("statusr", $statusr, $u3a);
             $u3a = str_replace("statusno", $statuso, $u3a);
             $u3a = str_replace("statuspro", $statuspro, $u3a);
             $u3a = str_replace("statusn", $statusn, $u3a);
             $u3a = str_replace("domen", $domen, $u3a);


            $ntag=substr_count($u3a, '{');

            for($ntag0=1;$ntag0<=$ntag;$ntag0++){

              $position = strpos($u3a, "{"); $content = substr($u3a, $position+1);
              $position = strpos($content, "}"); $content = substr($content, 0, $position);

            $content2 = "|$content";
            $ntag2=substr_count($content2, '|');
            $words = explode("|", $content2);
            $zn=rand(1,$ntag2);
            $word=$words[$zn];
            $contentr="{"; $contentr.=$content; $contentr.="}";
            $u3a = str_replace("$contentr", "$word", $u3a);

            }


            $u3a = str_replace("<p style='text-indent: 45px;'>", "", $u3a);
            $u3a = str_replace("</p>", "", $u3a);
            $nseek2 = 1;
            $u3a = substr($u3a, 0, 300);
            for($nseek=1;$nseek<20;$nseek++){
             $rest = substr($u3a, -$nseek);
             if(strstr($rest, " ")!=""){$nseek2=$nseek; $nseek=20;}
            }

            $u3a = substr($u3a, 0, 300-$nseek2);

            $u3at="<section class=\"fcom city-block\">
            <a href=/$domen/$lan/$link>$u3a...</a>
            </section>";

        }
        }
    }
}


$sq=0;
$Allq = DB::table('Privatec')->select('set_q','ipban','ComForBan')->
where('id', $id)->limit(1)->get();
foreach ($Allq as $Alq) { $set_q=$Alq->set_q; $ipban=$Alq->ipban; $ComForBan=$Alq->ComForBan; $sq++; }
if($sq==0){$set_q=""; $ipban = ""; $ComForBan = "";}
 $go_q="stop";
if($set_q=="a" || (!$set_q)){$go_q="go";}
if($set_q=="b" && Auth::user()){$go_q="go";}
if($set_q=="c"){$go_q="stop";}
         $ip = $_SERVER['REMOTE_ADDR'];
 if(strstr($ipban, $ip)!=""){$go_q="stop";}
 if(Auth::user()) {
     $my_id2 = Auth::user()->id;
     if(mb_strstr((string)$ComForBan, (string)$my_id2)!=""){$go_q="stop";}
 }

@endphp


<section class="maxwide">
    <section class="cityuser1">

        @php
            $pref_page = __('messages.pref_page');
            $pref_page2=$pref_page;
            $pref_o=$pref_page.="se";
            $pref_d=$pref_page2.="sed";

            if($nrf7>0){$statusf="($nrf7)";} else{$statusf="";}
            if($nrm7>0){$statusmm="($nrm7)";} else{$statusmm="";}
            if ($nrv7>0){$statusv="($nrv7)";} else{$statusv="";}
            if ($nrp7>0){$statusp="($nrp7)";} else{$statusp="";}
            $oblname = "messages.ooo"; $oblname.=$obl;
            $lan = __('messages.lan');
        $link_mc = "mc";
        $link_se = "se";
        if($lan=="ru"){
            $link_mc = "rmc";
            $link_se = "rse";
        }
        if($lan=="en"){
            $link_mc = "emc";
            $link_se = "ese";
        }
        @endphp
        <section class="fcom city-block centered">
            <h1>{{$statusn}} {{$City}}</h1><h2>
                    @php $admcenter = __('messages.admcenter');  $raycenter = __('messages.raycenter');
                    if ($oblc==$id){echo" $admcenter <br /><a href=/$pref_o$obl> $obl_user2</a>";}
                    else if ($rayc==$id){echo"  <a href=/$pref_d$rayc> $raycenter</a>";}
                    @endphp
                </h2>

            @php
                $raycent = __('messages.raycent'); $oblcent = __('messages.oblcent');
             if($rayc!=$id){
                $Allr = DB::table('Allcities')->select($City_s,'domen')->
                where('id', $rayc)->limit(1)->get();
                $raycn=0;
                foreach ($Allr as $Alr) {
                    $Cityray=$Alr->$City_s; $domenr=$Alr->domen;
                    $raycn++;
                }
                if($raycn>0){echo"<h2><a href=/$domenr/$lan>$raycent $Cityray</a></h2>";}
            }
             if($oblc!=$id){
                $Allo = DB::table('Allcities')->select($City_s,'domen')->
                where('id', $oblc)->limit(1)->get();
                $oblcn=0;
                foreach ($Allo as $Alo) {
                    $Cityobl=$Alo->$City_s; $domeno=$Alo->domen;
                    $oblcn++;
                }
                if($oblcn>0){echo"<h2><a href=/$domeno/$lan>$oblcent $Cityobl</a></h2>";}
            }

            @endphp
        </section>
        <ul class="menu-list ">
            <li class="fcom menu-item">
                <a href="/{{ __('messages.pref_page') }}sp{{$id}}">
                    <h3>{{ __('messages.people') }} {{$statusp}}</h3>
                </a>
            </li>
            <li class="menu-item fcom">
                <a href="/{{$domen}}/foto/{{ __('messages.lan') }}/">
                    <h3>{{ __('messages.Foto') }} {{$statusf}}</h3>
                </a>
            </li>
            <li class="menu-item fcom">
                <a href="/{{$link_mc}}{{$id}}">
                    <h3>{{ __('messages.gps_tit') }}</h3>
                </a>
            </li>
            <li class="menu-item fcom">
                <a href="/{{$domen}}/forum/{{ __('messages.lan') }}/0/0">
                    <h3>{{ __('messages.records') }} {{$statusmm}}</h3>
                </a>
            </li>
            <li class="menu-item fcom">
                <a href="/{{$link_se}}{{$obl}}">
                    <h3>{{ __($oblname) }}</h3>
                </a>
            </li>
        </ul>

        @php
        $Allb = DB::table('City_Admin2')->select('Num')->
        where('id', $id)->where('Page', 'Memory')->get();
        $Allbn = $Allb->count();

        if(Auth::user()) {
            if($vol_karta<80000||!$vol_karta){
                if($admpass=="ok"||$Allbn==0){

                    $statusn1 = __('messages.statusn1');
                    $statusn2 = __('messages.statusn2');
                    $statusn3 = __('messages.statusn3');
                    $statusn4 = __('messages.statusn4');
                    $statusn5 = __('messages.statusn5');
                    echo"
                    <section class=\"fcom city-block\">$City -
                    <select id=\"status\" onchange=status($id)>
                    <option value=1"; if($ss==1){echo" selected";} echo">$statusn1</option>
                    <option value=2"; if($ss==2){echo" selected";} echo">$statusn2</option>
                    <option value=3"; if($ss==3){echo" selected";} echo">$statusn3</option>
                    <option value=4"; if($ss==4){echo" selected";} echo">$statusn4</option>
                    <option value=5"; if($ss==5){echo" selected";} echo">$statusn5</option>
                    </select></section>
                    ";
                }
            }
        }
        @endphp


        <section class="fcom city-block">
        @php
            $nnext = __('messages.nnext');
            $rnext = __('messages.rnext');
            $onext = __('messages.onext');

                if($oblc==$id){ $rt_e = __('messages.ratings_u');
                        $Allr = DB::table('Allcities')->select($City_s,'domen')->
                            orderBy('sumr', 'desc')->limit(10)->get();
                $rnext="<a class=\"city-rating-a\"  href=/searc>$nnext</a><br /><br /> <a class=\"city-rating-a\" href=/$pref_o$obl>$onext</a>";
                }
                else if($rayc==$id){ $rt_e = __('messages.ratings_o');
                        $Allr = DB::table('Allcities')->select($City_s,'domen')->
                            where('obl', $obl)->
                            orderBy('sumr', 'desc')->limit(10)->get();
                $rnext="<a class=\"city-rating-a\" href=/$pref_o$obl>$nnext</a><br /><br /> <a class=\"city-rating-a\" href=/$pref_d$rayc>$rnext</a> ";
                }
                else { $rt_e = __('messages.ratings_r');
                        $Allr = DB::table('Allcities')->select($City_s,'domen')->
                            where('obl', $obl)->where('rayc', $rayc)->
                            orderBy('sumr', 'desc')->limit(10)->get();
                $rnext="<a class=\"city-rating-a\" href=/$pref_d$rayc>$nnext</a>";
                }

                echo"<h3><center>$rt_e</center></h3><ol class=\"city_rating\">";
                foreach ($Allr as $Alr) {
                    $C_r=$Alr->$City_s;
                    $domenr=$Alr->domen;
                    if($domenr==$domen){$C_r="<b>$C_r</b>";}
                    echo"<li> <a href=/$domenr/$lan>$C_r</a> </li>";
                }
                echo"</ol><br />$rnext<br /><br />";

        @endphp

        </section>


        @php
        if ($nrp7 > 0){
            $seek_day = date('Y-m-d', strtotime('-300 days'));
            $Allu = DB::table('users')->select('Num','Im','Priz','Md')->
            where('idc', $id)->where('Md', '>', $seek_day)->
            orderBy('Md', 'desc')->limit(10)->get();
            $Allrn = $Allu->count();

            if($Allrn>0){

                $to_new_users = __('messages.to_new_users');
                $to_new_users2 = __('messages.to_new_users2');
                $pr_p = __('messages.pref_page');
                $pr_p2=$pr_p; $pr_pi=$pr_p.="i"; $pr_pu = $pr_p2.="sp";
                echo"<section class=\"fcom city-block\">
                 <h4><center>$to_new_users <a href=/$pr_pu$id>$to_new_users2  $City_of</a></center></h4>
               <ul class=\"city_rating non-list\">";

                foreach ($Allu as $Alu) {
                    $Num=$Alu->Num;
                    $M3=$Alu->Im;
                    $M2=$Alu->Priz;
                    $Mdreg=$Alu->Md;
                    $need_day = date('Y-m-d', strtotime('-30 days'));
                    if($need_day<$Mdreg){
                        $tag_on="<b>"; $tag_of="</b>";
                    }
                    else {
                        $tag_on=""; $tag_of="";
                    }
                    echo"<li><a href=/$pr_pi$Num>$tag_on $M3 $M2 $tag_of</a></li>";
                }
                echo"</ul></section>";
            }
        }

        if($nrf7==0){echo"$u1at";}

        @endphp


    </section>




    <section class="cityuser2">

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

        @if($go_q=="go")
            <section class="fcom city-center-block">
                <div id="question_in"> </div>
                <textarea ID=question rows=2 cols=30 placeholder="{{__('messages.quest1')}}" onFocus="clearss('question');"></textarea>
                <table><tr>
                    @auth
                        <td class="fcomblue intop ind-button">
                            <a href=## onclick=question('me','{{$id}}','/question_inc')>{{__('messages.quest4')}}</a>
                        </td>
                    @endauth
                    <td class="fcomblue intop ind-button">
                        <a href=## onclick=question('anonim','{{$id}}','/question_inc') rel="noopener noreferrer"> {{__('messages.quest6')}}</a>
                    </td>
                </tr></table>
            </section>
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
        <section class="fcom city-center-block">
            <h3>{{__('messages.subscr1')}}</h3>
            <p>{{__('messages.subscr2')}}</p>

            <section id="sub-city">
                <label style="display: flex; flex-direction: column; align-items: flex-start" required autocomplete="email" autofocus>
                    <b>E-mail:</b>
                    <input type="text" id="Pmail" value="{{$my_mail_e}}" size=14>
                </label>
                <label style="display: flex; flex-direction: column; align-items: flex-start">
                    <b>{{__('messages.chopt')}}:</b>
                    <select id="mailnp">
                        <option value="/mailaddc">{{__('messages.Add')}}</option>
                        <option value="/mailchangec">{{__('messages.Set')}}</option>
                        <option value="/maildelc">{{__('messages.Delete')}}</option>
                    </select>
                </label>
                <input type="hidden" name="id" id="id" value="{{$id}}">
                <table><tr><td class="fcomblue intop short-button">
                            <a href="##" onclick="dataSelect()" rel="noopener noreferrer">
                                {{__('messages.Go')}}
                            </a>
                        </td></tr></table>
            </section>
            <div id=mailfield></div>
        </section>
        <a style="display: inline-block; margin-bottom: 10px; " 
        target="_blank" href="https://play.google.com/store/apps/details?id=com.syrovatko.saferoad">
            <video style="width: 320px; height: 100px; object-fit: cover; border-radius: 8px;" 
                autoplay loop muted>
                <source src="/storage/saferoad.mp4" type="video/mp4">
                Ваш браузер не підтримує відео.
            </video>
        </a>



        @php

        if($nrf7>0){
			$s_time = microtime(true);
            $latest_photo = __('messages.latest-photo');

            echo"<section class=\"fcom city-center-block\">
                <h3><a aria-label=\"$latest_photo $City\" href=\"/$domen/foto/$lan/\">$latest_photo</h3>
                <section class=\"city-center-foto\">";
                    $Allf = DB::table('Foto')->select('Namef', 'Formf', 'Fd')->
                    where('id', $id)->
                    orderBy('Fd', 'desc')->
                    limit(4)->
                    get();

                    foreach ($Allf as $Alf) {
                        $M5=$Alf->Namef;
                        $M7=$Alf->Formf;
                        $M6=$Alf->Fd;

                        $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
                        if ($monm<10){$monmf = substr($M6, 6, 1);}
                        else{$monmf=$monm;}
                        if($yem<=2007){$yem = "2005-2007"; $monmf="";}

                        $katalogface = "Photos/$yem$monmf/$M5.$M7";
                        $katalog = Storage::disk('public')->url($katalogface);
                        $katalogface = str_replace("http:", "https:", $katalog);

                        if(Auth::user()) {
                            $flink = "onclick=abf($id,$M5)";
                        }
                        else{
                            $flink = "href=\"$pref_page_f$M5\"";
                        }

                        echo "
                            <a $flink>
                                <div class=\"scale ccf-item fcom0\">
                                    <img width=\"auto\" height=\"100\" alt=\"$City - $latest_photo\" src=\"$katalogface\">
                                </div>
                            </a>
                        ";

                    }
                echo"</section>";
				if(Auth::check() && Auth::user()->id == 72372396) {
					$e_time = microtime(true);
					$execution_time = $e_time - $s_time;
					echo "<br > Блок виконався за " . $execution_time . " секунд";
				}
				$s_time = microtime(true);
                $Allf = DB::table('Foto')->select('Namef', 'Formf', 'Fd')->
                where('id', $id)->
                where('Publ', '1')->
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

                        $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
                        if ($monm<10){$monmf = substr($M6, 6, 1);}
                        else{$monmf=$monm;}
                        if($yem<=2007){$yem = "2005-2007"; $monmf="";}

                        $katalogface = "Photos/$yem$monmf/$M5.$M7";
                        $katalog = Storage::disk('public')->url($katalogface);
                        $katalogface = str_replace("http:", "https:", $katalog);

                        if(Auth::user()) {
                            $flink = "onclick=abf($id,$M5)";
                        }
                        else{
                            $flink = "href=\"$pref_page_f$M5\"";
                        }


                        echo "
                            <a $flink>
                                <div class=\"scale ccf-item fcom0\">
                                    <img width=\"auto\" height=\"100\" alt=\"$City - $selected_photo\" src=\"$katalogface\">
                                </div>
                            </a>
                        ";
                    }
                    echo"</section>";
                }

            echo"</section>";
			if(Auth::check() && Auth::user()->id == 72372396) {
				$e_time = microtime(true);
				$execution_time = $e_time - $s_time;
				echo "<br > Блок виконався за " . $execution_time . " секунд";
			}
        }






        $questions_n = substr_count($questions,"#!^:*&");

        if((int)$questions_n>0){
			echo"<ul>";
            $questions = explode("#!^:*&", $questions);

            for($q=100;$q<=$questions_n+99; $q++){

                echo"<li id=\"q_box$q\" class=\"fcom city-center-block ques-in\">";

                    $ques=$questions[$q-99];
                    $pref_page = __('messages.pref_page');
                    $pref_pagei = $pref_page.="i";
                     $question_n = substr_count($ques,"#!:*&");
                     $question = explode("#!:*&", $ques);
                     if(isset($question[1])){$q_question=$question[1];} else{$q_question="";}
                     if(isset($question[2])){$q_data=$question[2];} else{$q_data="";}
                     if(isset($question[3])){$q_avt=$question[3];} else{$q_avt="";}
                     $q_data=$question[2];
                     $q_avt=$question[3];
                     if($question_n==3){$q_ip="";} else {
                        if(isset($question[4])){$q_ip=$question[4];} else{$q_ip="";}
                     }

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
                            if(($admpass=="ok" || $my_id=72372396) && mb_strlen($q_ip)>5){
                                echo"<div id=\"ban$q\">
                                    <a onclick=ban_qc('ban$q','$q_ip','$id')> $block Ip</a>
                                </div>";
                            }
                            echo"</div>";
                        }
                    echo"<div class=\"forum-content ques-in-item mw355\">
                        <b>$q_question</b>";

                        if($go_q=="go"){
                            $qenter = __('messages.qenter');
                            $answ = __('messages.answ');
                            echo"<div id=\"q_err$q\"></div>
                            <textarea id=\"ask$q\" class=\"pl5\" rows=1 cols=25 placeholder=\"$qenter\" onFocus=\"clearsq('ask$q','dcmes$q');\"></textarea>
                            <div id=\"dcmes$q\" class=\"un-display\">
                                <table><tr><td class=\"fcomblue intop wide-button\">
                                    <a href = ### onclick=askc('q_box$q','ask$q','$q','$id')> $answ </a>
                                </td></tr></table>
                            </div>";
                        }
                    echo"</div>";

                    if(($q_avt>0 && $my_id>0 && $q_avt==$my_id) || $admpass=="ok"){
                        $Delete = __('messages.Delete');
                        echo"<br /><a onclick=del_qc('q_box$q','$q','$id')>$Delete</a>";
                    }

                echo"</li>";

            } //for($q=100;$q<=$questions_n+99;$q++){
			echo"</ul>";
        } // if($questions_n>0){

$s_time = microtime(true);


        @endphp


        <section class="fcom city-center-block">

            <div class="map-block">
                @php
                    $x_max=0.19; $y_max=0.2;
                    $x0=$x-0.125;$x1=$x+0.125;
                    $y0=$y-0.1;$y1=$y+0.1;
                    $xpic_max=235;
                    $ypic_max=370;
                    $mapk="";

                    $Cityq = "City";
                    if($lan=="ru"){
                        $Cityq = "City2";
                    }
                    if($lan=="en"){
                        $Cityq = "City3";
                    }
                    $Allc = DB::table('Allcities')->select('id', $Cityq, 'domen', 'rayc', 'x', 'y')->
                    where('x', '>', $x0)->
                    where('x', '<', $x1)->
                    where('y', '>', $y0)->
                    where('y', '<', $y1)->
                    get();
                    foreach ($Allc as $All) {
                        $Citym = $All->$Cityq;
                        if($Citym == $City){$Citym = "<b>$Citym</b>";}
                        $domen_neib = $All->domen;
                        $idm = $All->id; $raycxy = $All->rayc; $xx = $All->x; $yy = $All->y;
                        if($xx>0 && $yy>0){

                            $xx=$xx-$x0; $yy=abs($yy-$y0);
                            $xpic=round($xpic_max*$xx/$x_max); $ypic=abs(round($ypic_max*$yy/$y_max)-$ypic_max)+4;

                            $ball = ($idm == $raycxy) ? "icon-red" : (($rayc == $raycxy) ? "icon-blue" : "icon-grey");

                            $ypic20 = $ypic-22;
                            $xpicn = $xpic+5;
                            $ypicn = $ypic+5;
                            echo"
                            <nav id=\"i{$idm}\" class=\"$ball icon\" style=\" margin-top: {$ypic}px; margin-left: {$xpic}px;\"></nav>
                            <aside id=\"ont{$idm}\" class=\"aside-text\" style=\" margin-top: {$ypic20}px; margin-left: {$xpic}px;\">
                                {$Citym}
                            </aside>";

                            $mapk=$mapk.="
                            <area onmouseover=\"act($idm, '$ball')\" onmouseout=\"inact($idm, '$ball')\" shape=circle coords=$xpicn,$ypicn,11 href=/$domen_neib/$lan>";
                        }
                    }
                @endphp
                <section id=main2 class="city-map">
                    <img src="/images/360x390.png" width=360 height=390 alt="{{__('messages.mmap')}}" useMap=#Map2>
                    <map name=Map2>
                        @php echo"$mapk"; @endphp
                    </map>
                </section>
            </div>

        </section>

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

        @php
    if(Auth::check() && Auth::user()->id == 72372396) {
        $end_time = microtime(true);
        $execution_time = $end_time - $s_time;
        echo "<br > мапа по точках" . $execution_time . " секунд";
    }

$s_time = microtime(true);

    $Allm =DB::table('Memory')->select('afisha', 'theme', 'idrec','Aboutec','Nameg','Whog','r_gol','r_kol','rh','Md','Ip','avt')
    ->where('id',$id)->where('afisha','1')
    ->orderBy('Md','Desc')
    ->limit(100)
    ->get();
    $Afishan = $Allm->count();

    if ($Afishan>0) {
        $fast_e = __('messages.fastens');
        $hide = __('messages.hide');
        if(isset($_COOKIE['achide'])){
            $achide = $_COOKIE['achide'];
        } else {$achide = "";}
        if($achide=="0"){
            $hstyle2 = "style=\"display: none;\" ";
            $hstyle3 = "display: none;";
        } else {$hstyle2 = ""; $hstyle3 = "";}

    echo"<section class=\"fcom city-center-block\">
            <a href=## onclick=ashow() rel=\"noopener noreferrer\"><h4>$fast_e</h4></a>
        </section>
        <div id=\"hidafisha\" style=\"$hstyle3 margin: 0 10px 10px 0; text-align: right; \"><a href=## onclick=ahide() rel=\"noopener noreferrer\"><b>$hide</b></a></div>
        <section id=\"afisha\" $hstyle2>";

            foreach ($Allm as $All) {
                $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutec; $M2=$All->Nameg; $M3=$All->Whog; $r_gol=$All->r_gol;
                 $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt; $rh=$All->rh;

                 echo view('inc.memory', ['id' => $id, 'afisha' => $afisha, 'themeg' => $themeg, 'idrec' => $idrec, 'M1' => $M1, 'M2' => $M2, 'M3' => $M3, 'r_gol' => $r_gol, 'r_kol' => $r_kol,
                 'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'admpass' => $admpass, 'rh' => $rh, 'purp' => 'main']);
            }
        echo"</section>";

    }

		if(Auth::check() && Auth::user()->id == 72372396) {
		$end_time = microtime(true);
		$execution_time = $end_time - $s_time;
		echo "<br > афіша " . $execution_time . " секунд";
		}


/*
    if($obl==25 || $obl==18 || $obl==2){
        $hide = __('messages.hide');
        $radar1 = __('messages.radar1'); $radar2 = __('messages.radar2');

        echo"
        <table align=center><tr><td height=4></td></tr></table>
        <table><tr><td align=center width=535 class=fcom align=center>
        <a onclick=rshow($obl)><h4>$radar1</h4></a>
        </td></tr></table>
        ";

        if(isset($_COOKIE['rhide'])){$rhide = $_COOKIE['rhide'];} else {$rhide = "";}
        if($rhide=="1"){

             $rstyle2 = "";
            if($obl==25){$rfile = "storage/apps/radar_chernigiv.png";}
            if($obl==18){$rfile = "storage/apps/radar_sumy.png";}
            if($obl==2){$rfile = "storage/apps/radar_volyn.png";}

            $kfilesize = filesize($rfile);
            if($kfilesize>500){
                $_mkt = microtime(true);
                $timed = round($_mkt);
                $r_src = "/$rfile?$timed";
                $r_content = "
                <table><tr><td align=center width=535 class=fcom align=center>
                <table><tr><td width=500 align=center>
                <a href=\"$r_src\"><img width = 500 border=0 SRC=\"$r_src\"></a>
                <br />$radar2 <br /><br />
                </td></tr></table>
                </td></tr></table>";
            } else{$r_content = "";}

        }
        else {
            $rstyle2 = "style=\"display: none;\" "; $r_content = "";
        }

        echo"
        <table><tr><td width=530 align=right>
        <div id=\"hidradar\" $rstyle2><a onclick=rhide()><b>$hide</b></a></div>
        </td><td width=5></td></tr></table>
        <div id=\"radar\" $rstyle2>
        $r_content
        </div>
        ";
    }

*/


$s_time = microtime(true);


$Allt = DB::table('Memory')
->where('id',$id)
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
    echo"<section class=\"fcom city-center-block theme-go\">

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
        echo"</select></label>

        <table>
            <tr><td class=\"fcomblue intop wide-button\">
                <a href=## onclick=memt($id,$rayc); rel=\"noopener noreferrer\"> $go</a>
            </td></tr>
        </table>

    </section>";
            		if(Auth::check() && Auth::user()->id == 72372396) {
		$end_time = microtime(true);
		$execution_time = $end_time - $s_time;
		echo "<br > вибірка новин" . $execution_time . " секунд";
		}
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

    @if($my_id>0)
        @if(mb_strstr($ComForBan, $my_id)=="")
                <div id="memt_res"></div>
            <section class="fcom city-center-block">

                <textarea ID="memt" rows=2 cols=40 placeholder="{{__('messages.mem_in_t')}}" onFocus="clearsq('memt','mem_add');"></textarea>

                <div id="mem_add" style="display: none;">
                    <input id="theme_in" size=44 maxlength = 70 placeholder="{{__('messages.mem_in_tem')}}">
                    <table>
                        <tr>
                            <td class="fcomblue intop wide-button">
                                <a href = ## onclick=mem_add('{{$id}}')> {{__('messages.Add')}} </a>
                            </td>
                            <td>
                                <a onclick=sml('default')>&nbsp;<img src=/sml/2.gif title='{{__('messages.sml')}}'> &nbsp;</a>
                            </td>
                        </tr>
                    </table>

                    <div id="app_mem"></div>
                    <div id="app_mem_add"></div>
                </div>

            </section>
        @endif
    @endif







    @php
        $s_time = microtime(true);


         $Allm =DB::table('Memory')->select('afisha', 'theme', 'idrec','Aboutec','Nameg','Whog','r_gol','r_kol','rh','Md','Ip','avt')
          ->orWhere(function($query) {
             $query->whereNull('theme')
                   ->orWhere('theme','');
          })
         ->where('id',$id)
         ->orWhere('ray',$rayc)
         ->orderBy('Md','Desc')
         ->limit(11)
         ->get();
         $nr = $Allm->count();

         $qwans = __('messages.qwans');
         $enterv = __('messages.enterv');
         $unsort = __('messages.unsort');

         if($nr>0){
             echo"<section id=\"mem\">";

             if($nr==11){
                 echo"
                 <ul class=\"forum-menu\">
                     <li class=\"fcom forum-menu-item w39 colored\" onclick=\"mem($id,$rayc,'%^&@#',1,'Desc');\">
                         <b>$qwans</b>
                     </li>
                     <li class=\"fcom forum-menu-item w22 colored\" onclick=\"mem($id,$rayc,'*&^@72438484',1,'Desc');\">
                         <b>$enterv</b>
                     </li>
                     <li class=\"fcom forum-menu-item w39 colored\" onclick=\"mem($id,$rayc,'',1,'Asc');\">
                         <b>$unsort</b>
                     </li>
                 </ul>
                ";
             }

             $nm=1;
             foreach ($Allm as $All) {
                 if($nm<11){
                     $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutec; $M2=$All->Nameg; $M3=$All->Whog; $r_gol=$All->r_gol;
                      $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt; $rh=$All->rh;

                      echo view('inc.memory', ['id' => $id, 'afisha' => $afisha, 'themeg' => $themeg, 'idrec' => $idrec, 'M1' => $M1, 'M2' => $M2, 'M3' => $M3, 'r_gol' => $r_gol, 'r_kol' => $r_kol,
                      'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'admpass' => $admpass, 'rh' => $rh, 'purp' => 'def']);
                  }
                  else { $nnext = __('messages.nnext');
                     echo "<ul class=\"forum-menu\" id=fnext2>
                         <li class=\"fcombold forum-menu-item w100\" onMouseOver=mem($id,$rayc,'',2,'Desc'); onClick=mem($id,$rayc,'',2,'Desc');\">
                             <b>$nnext</b>
                         </li>
                     </ul>";
                  }
              $nm++;
             }
             echo"</section>";
         }
		if(Auth::check() && Auth::user()->id == 72372396) {
		$end_time = microtime(true);
		$execution_time = $end_time - $s_time;
		echo "<br > записи" . $execution_time . " секунд";
		}
     @endphp







        @php

    $lan = App::currentLocale();
    if($lan=="ua" || $lan=="ru"){
        $cq2 = "uatext";
        if ($lan=="ru"){
        $cq2 = "rutext";
        }
        if($id==23334 || $id==73918){
            $Allt = DB::table('life')->
            select($cq2, 'link')->
           // where('actualid', 2)->
            whereNull('non_vis')->
            orderBy('id', 'desc')->
            limit(7)->
            get();
        }
        else{
            $Allt = DB::table('life')->
            select($cq2, 'link')->
           // where('actualid', 2)->
            orderBy('id', 'desc')->
            limit(7)->
            get();
        }


		$nrow_for_margin = 1;
		$for_margin = "";
		echo"<ul>";
        foreach ($Allt as $All) {
        $ua = $All->$cq2;
        $link = $All->link;
            if($lan=="ua"){

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


                $ua = str_replace("<p style='text-indent: 45px;'>", "", $ua);
                $ua = str_replace("</p>", "", $ua);

                $ua = substr($ua, 0, 300);
                for($nseek=1;$nseek<20;$nseek++){
                 $rest = substr($ua, -$nseek);
                 if(strstr($rest, " ")!=""){$nseek2=$nseek; $nseek=20;}
                }

                $ua = substr($ua, 0, 300-$nseek2);
            }
            if($lan=="ru"){

                 $ua = str_replace("$", "", $ua);
                 $ua = str_replace("rod", $rod, $ua);
                 $ua = str_replace("dat", $dat, $ua);
                 $ua = str_replace("vin", $vin, $ua);
                 $ua = str_replace("tvor", $tvor, $ua);
                 $ua = str_replace("predl", $predl, $ua);
                 $ua = str_replace("City", $City2, $ua);
                 $ua = str_replace("statusnv", $statusnv, $ua);
                 $ua = str_replace("statusne", $statusm, $ua);
                 $ua = str_replace("statusny", $statusd, $ua);
                 $ua = str_replace("statusr", $statusr, $ua);
                 $ua = str_replace("statusno", $statuso, $ua);
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


                $ua = str_replace("<p style='text-indent: 45px;'>", "", $ua);
                $ua = str_replace("</p>", "", $ua);

                $ua = substr($ua, 0, 300);
                for($nseek=1;$nseek<20;$nseek++){
                 $rest = substr($ua, -$nseek);
                 if(strstr($rest, " ")!=""){$nseek2=$nseek; $nseek=20;}
                }

                $ua = substr($ua, 0, 300-$nseek2);
            }
			if($nrow_for_margin == 1){
				$for_margin = "style=\"margin-top: 35px\"";
				$nrow_for_margin++;
			};

            echo"<li class=\"fcom city-center-forum colored pointed\" $for_margin onClick=\"document.location='/$domen/$lan/$link'\">
                    $ua...
            </li>";
			$for_margin = "";
        }
		echo"</ul>";
        $all_blog_records =  __('messages.all_blog_records');

        echo"<section class=\"fcombold city-center-block colored pointed w100 mw535\" onClick=\"document.location='/$domen/blog/$lan/2'\">
               <a href=\"/$domen/blog/$lan/2\"><b>$all_blog_records</b></a>
        </section>";
    }

        $life_avto =  __('messages.life_avto');
        $life_buss =  __('messages.life_buss');
        $life_serv =  __('messages.life_serv');
        $life_med =  __('messages.life_med');
        $life_loc =  __('messages.life_loc');
        $life_subs =  __('messages.life_subs');
        $life_scool =  __('messages.life_scool');
        $life_good =  __('messages.life_good');

        echo"
        <section class=\"fcom city-center-block\" >
            <h3> $life_good</h3>
			<section class=\"forum-answser\">
				<section class=\"mw225 pointed\" id=\"useful-links\">
					<a href=## onClick=\"life(1,'avto','','$id')\" rel=\"noopener noreferrer\">$life_avto </a>
					<a href=## onClick=\"life(1,'biz','','$id')\" rel=\"noopener noreferrer\">$life_buss</a>
					<a href=## onClick=\"life(1,'serv','','$id')\" rel=\"noopener noreferrer\">$life_serv</a>
					<a href=## onClick=\"life(1,'med','','$id')\" rel=\"noopener noreferrer\">$life_med</a>
					<a href=## onClick=\"life(1,'loc','','$id')\" rel=\"noopener noreferrer\">$life_loc</a>
					<a href=## onClick=\"life(1,'sub','','$id')\" rel=\"noopener noreferrer\">$life_subs</a>
					<a href=## onClick=\"life(1,'sch','','$id')\" rel=\"noopener noreferrer\">$life_scool $statusr</a>
				</section>
				<section class=\"mw225\" id=aboute_life>

				</section>
			</section>
        </section>";




$s_time = microtime(true);

    $g_insert="off";
    $Allg = DB::table('gc')->select('Numg', 'Im', 'Priz', 'Num_a', 'Vd')->
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

    if($Allgn==0 && $Numm>0 && $nguests==1){$g_insert="on";}
    if($Allgn>0){

        $guests = __('messages.guests');
        $delete = __('messages.delete');
        $lan = App::currentLocale();

        $guests_e="$guests $statusr $City";
        if($lan == "en"){$guests_e="$guests of $City $statusr";}
        echo"<section class=\"fcom0 city-center-block\" >
            <h3>$guests_e</h3>
            <ul id=guests>";
             $ng=1;
            foreach ($Allg as $Alg) {
                if($ng<11){
                    $avtc = $Alg->Numg; $Img = $Alg->Im; $Prizg = $Alg->Priz;
                    $Num_a = $Alg->Num_a; if($Num_a>0){} else{$Num_a=7;} $Vd = $Alg->Vd;
                    if($ng==1 && $Numm>0 && $nguests==1){
                            if($avtc!=$Numm){$g_insert="on";}
                            else{
                                $Num_a = Auth::user()->avatar;
                                if($Num_a=='0' || !$Num_a ){$Num_a=7;}
                                $Vd_now = date('Y-m-d H:i:s');
                                $aff_upd = DB::table('gc')
                                ->where('Vd', $Vd)
                                ->where('Num', $id)
                                ->where('Numg', $Numm)
                                ->update(['Vd' => $Vd_now, 'Num_a' => $Num_a]);
                                if($aff_upd){$Vd = $Vd_now;}
                            }
                        }
                    $qonl = "";
                    if($avtc>0){
                        $aavt = avt($avtc,$Numm);
                        $aavt = str_replace("forum-avatar", "center-avatar", $aavt);
                        $aavt = str_replace("<br />", "", $aavt);
                        $aavt = str_replace("</svg>", "</svg><br />", $aavt);
                        $aavt = str_replace("</div>", "</div><br />", $aavt);
                    }
                    if($Vd){
                        $Vds = str_replace(" ", "*", $Vd);
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
                        $Vd_e="<p class=grey>$Vd_e</p>";
                    }
                    else{$Vd_e="";}

                    $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}

                    echo"<li id=\"$t3\" class=\"colored\">$aavt";
                        if($admpass=="ok"||$Numm==$avtc){
                            echo"$Vd_e<a href=## onclick=guesc_del('$avtc','$Vds','$t3','$id') rel=\"noopener noreferrer\"> $delete</a>";
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
                     if($avatar=='0'){$avatar=7;}
                    $g_ins = DB::table('gc')->
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
                        <section id=$t2 class=\"forum-menu fcom forum-menu-guest colored mt15\" onClick=guesc('0','$t2','$pregg','$id')>
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
         if($avatar=='0'){$avatar=7;}
        $g_ins = DB::table('gc')->
        insert(['Num' => $id, 'Numg' => $Numm, 'Im' => $Imm, 'Priz' => $Prizm, 'Num_a' => $avatar, 'Vd' => $Vd_now]);
    }



		if(Auth::check() && Auth::user()->id == 72372396) {
		$end_time = microtime(true);
		$execution_time = $end_time - $s_time;
		echo "<br >гості " . $execution_time . " секунд";
		}
$s_time = microtime(true);

        if($Allbn>0){

            $publdiv="off";
            foreach ($Allb as $Alb) {
                $Num = $Alb->Num;
                $Allu = DB::table('users')->select('Im', 'Priz', 'avatar', 'l_visit', 'avy', 'avx')
                ->where('id', $Num)
                ->where('aktiv', 1)
                ->limit(1)
                ->get();
                $Allun = $Allu->count();
                if($Allun>0){

                    foreach ($Allu as $Alu) {
                        $Im = $Alu->Im; $Priz = $Alu->Priz; $Num_a = $Alu->avatar; $l_visit = $Alu->l_visit;
                        $avy = $Alu->avy;
                        $avx = $Alu->avx;
                        $from=strtotime($l_visit);
                        $Md_is_online = date('Y-m-d H:i');
                        $to=strtotime($Md_is_online);
                        $razn=($to-$from)/60;
                        $online="";
                        if ($razn<=5){
                            $online="online";
                        }
                        if((int)$Num_a>10){}
                        else{$Num_a=7;}
                        $pref_page = __('messages.pref_page'); $ppref_page = $pref_page .="i";
                        $avae = generateUserIcon($Num_a, $Im, $Priz, "forum", $avx, $avy, $online);

                            $Alla = DB::table('users')->select('id')->
                            where('ratingmemory', '>', 0)->orderBy('ratingmemory','Desc')->get();
                            $nav = 1;
                            foreach ($Alla as $Ala) {
                                $avt0 = $Ala->id;
                                if($avt0==$Num){break;}
                                $nav++;
                            }
                            $takes = __('messages.takes');
                            $place = __('messages.place');
                            $ppage = __('messages.pref_page');
                            $adm_panel_e = "";
                            if(Auth::user()) {
                                $my_id =  Auth::user()->id;
                                if($my_id==$Num){
                                    $adm_panel = __('messages.adm_panel');
                                    $adm_panel_e = "<a href=/adm/$id>$adm_panel</a>";
                                }
                            }
                            $seestatadmf_page=$ppage.="seestatadmc";
                        $nicn = "<section class=\"admcity-item\">
                            <a href=\"/$pref_page$Num\";><b>$Im $Priz</b></a>

                            <span>$takes <b><a href=/$seestatadmf_page/$nav>$nav $place</a></b></span>
                            <b>$adm_panel_e</b>
                        </section>";

                        if($publdiv=="off"){
                            $publdiv="on";
                            $adm_page = __('messages.adm_page');
                            echo"<section class=\"fcom city-center-block\">
                             <h3>$adm_page</h3>
                             <ul class=\"non-list admcity\">";
                        }
                        echo"<li>$avae $nicn</li>";
                    }
                }
            }
            if($publdiv=="on"){
                echo"</ul></section>";
            }
        }
		if(Auth::check() && Auth::user()->id == 72372396) {
		$end_time = microtime(true);
		$execution_time = $end_time - $s_time;
		echo "<br >адміни " . $execution_time . " секунд";
		}
        @endphp
        @auth
            @if($admpass=="off")
                <section class="fcom city-center-block">
                    <div id="be_admin"><a onclick="be_admin('{{$id}}','Memory')"><h4>{{__('messages.be_admin')}}</h4></a></div>
                </section>
            @endif
        @endauth


        <section class="fcom city-center-block">
            <h4>{{__('messages.sharing')}}:</h4>
            @php
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




    </section>
    <section class="cityuser3" >

        @php



        /*
                $filename = "obl_news/top_$obl.txt";
            $memory_contentsa = Storage::disk('public')->get($filename);
            if (mb_strlen($memory_contentsa)>100) {
                $news10 = __('messages.News10'); $news10upd = __('messages.News10upd');
                echo"<table><tr><td class=fcom align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                <br /><b>$news10 $obl_user2</b><br /><br />
                <table><tr><td width=95% align=left>";
                echo" $memory_contentsa <font color=gray>$news10upd</font><br />
                </td></tr></table><br />
                </td></tr></table>";
            }
        */


        if($go_q=="go"){
            $enter_e = "";
            $greet = __('messages.greet');
            $enter_e .= "$greet, ";
            if(Auth::user()) {
                $my_im =  Auth::user()->Im;
                $enter_e .= "$my_im, ";
            }
            $inter_go = __('messages.inter_go');
            $enter_e .= "$inter_go $statusr <br /><br />";
            $doyouknow = __('messages.doyouknow');
            $enter_e .= "<div style=\"margin: 0px 5px 5px 5px; \"> <b>$doyouknow $statusn $City?</b></div>";
            $lets_go = __('messages.yes');
            $enter_alt = __('messages.enterv');

            echo"
            <section id=dask class=\"fcom city-block pad10\">
                <img class=\"img-interv\" width=50 height=65 alt=\"$enter_alt\" SRC=/images/mast.png>
                $enter_e
                <table><tr><td class=\"fcomblue intop small-button\">
                    <a href=## onclick=top_ask($id,0) rel=\"noopener noreferrer\">$lets_go</a>
                </td></tr></table>
            </section>";
        }


echo"$flinka ";




if(Auth::user()) {
	$s_time = microtime(true);
	function fetchWeather($x, $y) {
	global $apiKey, $latitude, $longitude;

	$apiKey = "6e0df8e82af781ce5f5883bfecde10de";

	$url = "https://api.openweathermap.org/data/2.5/weather?lat=$y&lon=$x&appid=$apiKey";
	$response = file_get_contents($url);

	if ($response === false) {
		// Handle error
		echo "An error occurred while fetching the weather data.";
		return;
	}

	$data = json_decode($response, true);

	$cityName = $data['name'];
	$temperature = round($data['main']['temp'] - 273.15); // Convert from Kelvin to Celsius and round to the nearest integer
	$cloud = $data['weather'][0]['main'];
	$description = $data['weather'][0]['description'];
	$iconCode = $data['weather'][0]['icon'];
	$iconUrl = "https://openweathermap.org/img/wn/$iconCode@2x.png";


	$M6_e = weather_date();
	$weather = __('messages.weather');
	$daysfuture = __('messages.5days');



	$weatherLayout = "
	<section id=\"weather\" class=\"fcom0 city-block\">

		<h3>$weather</h3>
		<div id=\"weather__degree\">{$temperature}&#186;</div>

		<div id=\"weather__cloud\">
			{$cloud}
		</div>
		<div class=\"weather__location\">
			<svg width=\"18\" height=\"23\" viewBox=\"0 0 14 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
				<path d=\"M7.00001 0.125C5.35957 0.126935 3.78688 0.779452 2.62692 1.93941C1.46696 3.09938 0.814442 4.67207 0.812507 6.3125C0.810542 7.65306 1.24843 8.95725 2.05901 10.025C2.05901 10.025 2.22776 10.2472 2.25532 10.2793L7.00001 15.875L11.7469 10.2764C11.7717 10.2466 11.941 10.025 11.941 10.025L11.9416 10.0233C12.7517 8.95603 13.1894 7.65245 13.1875 6.3125C13.1856 4.67207 12.5331 3.09938 11.3731 1.93941C10.2131 0.779452 8.64044 0.126935 7.00001 0.125ZM7.00001 8.5625C6.555 8.5625 6.11998 8.43054 5.74997 8.18331C5.37996 7.93607 5.09157 7.58467 4.92128 7.17354C4.75098 6.7624 4.70642 6.31 4.79324 5.87355C4.88006 5.43709 5.09435 5.03618 5.40902 4.72151C5.72368 4.40684 6.1246 4.19255 6.56105 4.10573C6.99751 4.01892 7.44991 4.06347 7.86104 4.23377C8.27218 4.40407 8.62358 4.69246 8.87081 5.06247C9.11805 5.43248 9.25001 5.86749 9.25001 6.3125C9.24926 6.90901 9.01197 7.48087 8.59017 7.90267C8.16838 8.32446 7.59652 8.56176 7.00001 8.5625Z\" fill=\"white\"/>
			</svg>
			{$cityName}
		</div>

		<img id=\"weather__image\" width=70 height=70 src=\"{$iconUrl}\" alt=\"{$description}\" />
		<div id=\"weather__time\"><br />$M6_e</div>
		<br />
		<div class=\"weather__location\">
			<a href=## onclick=weatherWeek('$x','$y') rel=\"noopener noreferrer\">$daysfuture</a>
		</div><br />

		<div id=\"weather-week\"></div>
	</section>";

	echo $weatherLayout;
	}
	fetchWeather($x, $y);

	if(Auth::check() && Auth::user()->id == 72372396) {
		$end_time = microtime(true);
		$execution_time = $end_time - $s_time;
		echo "<br >погода " . $execution_time . " секунд";
	}

}


@endphp

@guest
    <section id="weather" class="fcom0 city-block">
        <div class="weather__location">
            <a href=## onclick=weatherWeek('{{$x}}','{{$y}}') rel="noopener noreferrer">{{__('messages.5days')}}</a>
        </div>
        <div id="weather-week"></div>
    </section>
@endguest
@php

if($nrf7==0){echo"$u2at $u3at";}

        $end_time = microtime(true);
        $execution_time = $end_time - $start_time;


		if(Auth::check() && Auth::user()->id == 72372396) {
			echo "<br > Скрипт виконався за " . $execution_time . " секунд";
	   }

        @endphp


    </section>

</section>

<div style="display: none;" id="fc">{{$_SERVER['REQUEST_URI']}}</div>
<div style="display: none;" id="rate">{{$sumr}}</div>
<div style="display: none;" id="id_page">{{$id}}</div>
<div style="display: none;" id="rayc_page">{{$rayc}}</div>
<div style="display: none;" id="obl_page">{{$obl}}</div>
@endif



    <br /><br />
@endsection
