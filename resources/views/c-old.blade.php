@extends('layouts.app')
@php
global $cwindowonload;
$cwindowonload = "go";

// $domen="nosivka";
// $domen="kolona";
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
    select('rayc', 'City', 'City2', 'City3', 'sumr', 'obl', 'status', 'x', 'y', 'z', 'vol_karta', 'face_karta', 'oblc',
    'apps', 'City_m', 'City_o', 'City_r', 'City_d', 'rod', 'vin', 'dat', 'tvor',
     'predl', 'domen', 'places', 'questions', 'ab')->
        where('id', $id)-> limit(1)-> get();
            $nd=0;
        foreach ($Alls as $All) {
            $rayc=$All->rayc; $City1=$All->City;  $City2=$All->City2;  $City3=$All->City3;  $sumr=$All->sumr;
             $obl=$All->obl; $status=$All->status;  $x=$All->x;  $y=$All->y;  $z=$All->z;
              $vol_karta=$All->vol_karta; $face_karta=$All->face_karta;  $oblc=$All->oblc;  $apps=$All->apps;
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

if(file_exists($file0)){ $fpath = $flink0;
$flinka = "<table><tr><td height=5></td></tr></table>
<table><tr><td align=center width=220 class=fcom><div style='margin: 5px 5px 5px 5px;'><h4>$tmap $City_of</h4></div><a href=\"$flink1\"><div class=\"scale\"><img title=\"$statusnv $City\" src=$flink0></div></a><br /><br /></td></tr></table>";}
else if(file_exists($file1)){ $fpath = $flink1;
$flinka = "<table><tr><td height=5></td></tr></table>
<table><tr><td align=center width=220 class=fcom><div style='margin: 5px 5px 5px 5px;'><h4>$tmap  $City_of</h4></div><div class=\"scale\"><img title=\"$statusnv $City\" src=$flink1></div><br /><br /></td></tr></table>";}
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

                $u1at="<table><tr><td height=5></td></tr></table><table><tr><td width=220 class=fcom style=\"cursor: pointer;\" class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"document.location='/$domen/$lan/$link'\">
                <div style=\"margin: 5px 8px 10px 10px; \">
                <a href=/$domen/$lan/$link>$u1a...</a>
                </div></td></tr></table>";

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

                $u2at="<table><tr><td height=5></td></tr></table><table><tr><td width=220 class=fcom style=\"cursor: pointer;\" class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"document.location='/$domen/$lan/$link'\">
                <div style=\"margin: 5px 8px 10px 10px; \">
                <a href=/$domen/$lan/$link>$u2a...</a>
                </div></td></tr></table>";
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

                $u3at="<table><tr><td height=5></td></tr></table><table><tr><td width=220 class=fcom style=\"cursor: pointer;\" class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"document.location='/$domen/$lan/$link'\">
                <div style=\"margin: 5px 8px 10px 10px; \">
                <a href=/$domen/$lan/$link>$u3a...</a>
                </div></td></tr></table>";
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

                $u1at="<table><tr><td height=5></td></tr></table><table><tr><td width=220 class=fcom style=\"cursor: pointer;\" class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"document.location='/$domen/$lan/$link'\">
                <div style=\"margin: 5px 8px 10px 10px; \">
                <a href=/$domen/$lan/$link>$u1a...</a>
                </div></td></tr></table>";

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

                $u2at="<table><tr><td height=5></td></tr></table><table><tr><td width=220 class=fcom style=\"cursor: pointer;\" class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"document.location='/$domen/$lan/$link'\">
                <div style=\"margin: 5px 8px 10px 10px; \">
                <a href=/$domen/$lan/$link>$u2a...</a>
                </div></td></tr></table>";
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

                $u3at="<table><tr><td height=5></td></tr></table><table><tr><td width=220 class=fcom style=\"cursor: pointer;\" class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"document.location='/$domen/$lan/$link'\">
                <div style=\"margin: 5px 8px 10px 10px; \">
                <a href=/$domen/$lan/$link>$u3a...</a>
                </div></td></tr></table>";

            }
            }
        }
    }
    @endphp


        <div  align = center>

        <div class="layermaxwide">
            <div class="layercityuser1">

    @php
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

    <table>
        <tr><td width=230 height=30 align=left style="cursor: pointer;" class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'" onClick="document.location='/{{ __('messages.pref_page') }}sp{{$id}}'"><a><h4>&nbsp;&nbsp;{{ __('messages.people') }} {{$statusp}} </h4></a></td></tr>
        <tr><td width=230 height=30 align=left style="cursor: pointer;" class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'" onClick="document.location='/{{$domen}}/foto/{{ __('messages.lan') }}/'"><a><h4>&nbsp;&nbsp;{{ __('messages.Foto') }} {{$statusf}} </h4></a></td></tr>
        <tr><td width=230 height=30 align=left style="cursor: pointer;" class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'" onClick="document.location='/{{$link_mc}}{{$id}}'"><a><h4>&nbsp;&nbsp;{{ __('messages.gps_tit') }}</h4></a></td></tr>
        <tr><td width=230 height=30 align=left style="cursor: pointer;" class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'" onClick="document.location='/{{$domen}}/forum/{{ __('messages.lan') }}/0/0'"><a><h4>&nbsp;&nbsp;{{ __('messages.records') }} {{$statusmm}} </h4></a></td></tr>
        <tr><td width=230 height=30 align=left style="cursor: pointer;" class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'" onClick="document.location='/{{$link_se}}{{$obl}}'"><a><h4>&nbsp;&nbsp;{{ __($oblname) }}</h4></a></td></tr>
        </table>

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
            echo"<table><tr><td align=left width=230 class=fcom>
            <div style=\"margin: 5px 8px 5px 10px; \"><h4>$City -
            <select id=\"status\" onchange=status($id)>
            <option value=1"; if($ss==1){echo" selected";} echo">$statusn1</option>
            <option value=2"; if($ss==2){echo" selected";} echo">$statusn2</option>
            <option value=3"; if($ss==3){echo" selected";} echo">$statusn3</option>
            <option value=4"; if($ss==4){echo" selected";} echo">$statusn4</option>
            <option value=5"; if($ss==5){echo" selected";} echo">$statusn5</option>
            </select></h4></div>
            </td></tr></table>";
        }
    }
}
@endphp

<table><tr><td height=5></td></tr></table>
<table><tr><td align=center width=220 class=fcom>
<br /><table><tr><td width=140 align=left>
@php
    $nnext = __('messages.nnext');
    $rnext = __('messages.rnext');
    $onext = __('messages.onext');
    $lnc = __('messages.lan');
    $pref_page = __('messages.pref_page'); $pref_page2=$pref_page; $pref_o=$pref_page.="se"; $pref_d=$pref_page2.="sed";

        if($oblc==$id){ $rt_e = __('messages.ratings_u');
                $Allr = DB::table('Allcities')->select($City_s,'domen')->
                    orderBy('sumr', 'desc')->limit(10)->get();
        $rnext="<br /><a href=/searc>$nnext</a><br /><br /><a href=/$pref_o$obl>$onext</a><br />";
        }
        else if($rayc==$id){ $rt_e = __('messages.ratings_o');
                $Allr = DB::table('Allcities')->select($City_s,'domen')->
                    where('obl', $obl)->
                    orderBy('sumr', 'desc')->limit(10)->get();
        $rnext="<a href=/$pref_o$obl>$nnext</a><br /><br /><a href=/$pref_d$rayc>$rnext</a><br />";
        }
        else { $rt_e = __('messages.ratings_r');
                $Allr = DB::table('Allcities')->select($City_s,'domen')->
                    where('obl', $obl)->where('rayc', $rayc)->
                    orderBy('sumr', 'desc')->limit(10)->get();
        $rnext="<br /><a href=/$pref_d$rayc>$nnext</a><br />";
        }

            echo"<h4><center>$rt_e</center></h4><br /><table>";
                        $nc=0;
    foreach ($Allr as $Alr) { $C_r=$Alr->$City_s; $domenr=$Alr->domen; $nc++; if($domenr==$domen){$C_r="<b>$C_r</b>";}
    echo"<tr><td valign=center height=15>$nc) <a href=/$domenr/$lnc>$C_r</a> </td></tr>";
                    }
        echo"</table><b>$rnext</b>";

@endphp

</td></tr></table>
<br />
</td></tr></table>


    @php
    if ($nrp7 > 0){
    $seek_day = date('Y-m-d', strtotime('-300 days'));
    $Allu = DB::table('users')->select('Num','Im','Priz','Md')->
    where('idc', $id)->where('Md', '>', $seek_day)->
    orderBy('Md', 'desc')->limit(10)->get();
    $Allrn = $Allu->count();

    if($Allrn>0){

    $to_new_users = __('messages.to_new_users'); $to_new_users2 = __('messages.to_new_users2');
    $pr_p = __('messages.pref_page'); $pr_p2=$pr_p; $pr_pi=$pr_p.="i"; $pr_pu = $pr_p2.="sp";
        echo"<table><tr><td height=5></td></tr></table><table><tr><td align=center width=220 class=fcom><br />
        <h4> $to_new_users <br /><a href=/$pr_pu$id> $to_new_users2
       <br /> $City_of</a></h4><br /><table><tr><td align=left>";

                            foreach ($Allu as $Alu) { $Num=$Alu->Num; $M3=$Alu->Im; $M2=$Alu->Priz; $Mdreg=$Alu->Md;
                            $need_day = date('Y-m-d', strtotime('-30 days'));
                            if($need_day<$Mdreg){$tag_on="<b>"; $tag_of="</b>";} else {$tag_on=""; $tag_of="";}
                            echo" <a href=/$pr_pi$Num>$tag_on $M3 $M2 $tag_of</a> <br /><br />";
                            }

                            echo"</td></tr></table></td></tr></table>";

    }
    }







    if($nrf7>0){

        $Allf = DB::table('Foto')->select('Namef', 'Formf', 'Fd')->
        where('id', $id)->
        where('Publ', '1')->
        get();
        $Allfn = $Allf->count();
        if($Allfn==0){echo"$u1at $u2at";}
        if($Allfn>0){
            foreach ($Allf as $Alf) {
                $M5=$Alf->Namef;
                $M7=$Alf->Formf;
                $M6=$Alf->Fd;

                $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
                if ($monm<10){$monmf = substr($M6, 6, 1);}
                else{$monmf=$monm;}
                if($yem<=2007){$yem = "2005-2007"; $monmf="";}

                $katalogface = "Photos/$yem$monmf/$M5.$M7";
                $key = 'katalog_face_' . $katalogface;

                if (Cache::has($key)) {
                    $katalog_face = Cache::get($key);
                } else {
                    $katalog_face = Cache::remember($key, 86400, function () use ($katalogface) {
                        $katalog = Storage::disk('s3')->url($katalogface);
                        $katalog = str_replace("http:", "https:", $katalog);
                        return [
                            'katalog' => $katalog,
                        ];
                    });
                }
                $katalogface = $katalog_face['katalog'];

                echo"<table><tr><td height=5></td></tr></table>
                <table><tr><td align=center width=220 class=fcom>
                <div class=hidblok><table><tr><td height=5></td></tr></table></div>
                <a onclick=abf($id,$M5)><img loading=\"lazy\" src=$katalogface></a>
                <div class=hidblok><table><tr><td height=5></td></tr></table></div>
                </td></tr></table>";
            }
        }

    }
    else{echo"$u1at";}

    @endphp
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                    crossorigin="anonymous"></script>
            <!-- Адаптивный -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-7495053896041990"
                 data-ad-slot="5938872690"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
    <!--
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                        crossorigin="anonymous"></script>
                        -->
                <!-- Адаптивный -->
				<!--
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-7495053896041990"
                     data-ad-slot="5938872690"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
				-->
</div>

<div class="layercityuser3">

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

        echo"
        <table><tr><td class=fcom width=220>
            <div id=dask style=\"margin: 5px 8px 0px 8px; \">
                <table><tr><td>
                    <div style='margin: 5px 5px 5px 5px;'>
                        <div style=\"float:left\">
                            <div style=\"margin: 0px 7px 5px 0px; \">
                                <img width=50 border=0 SRC=/images/mast.png>
                            </div>
                        </div>
                    </div>
                        $enter_e
                </td></tr></table>
                <table><tr><td>
                    <table><tr><td width=220 align=center>
                        <table><tr><td class=fcomblue width=70 valign=center><ul class=intop><li>
                            <a onclick=top_ask($id,0)>$lets_go</a></li></ul>
                        </td></tr></table><br />
                    </td></tr></table>
                </td></tr></table>
            </div>
        </td></tr></table>";
    }


    echo"$flinka ";





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
    $iconUrl = "https://openweathermap.org/img/wn/$iconCode.png";


$M6_e = weather_date();
$weather = __('messages.weather');
$daysfuture = __('messages.5days');
    $weatherLayout = "<table><tr><td height=5></td></tr></table>
    <table><tr><td align=center width=220 class=fcom0>
    <div id=\"weather\">
        <h2>$weather</h2>
        <div id=\"weather__degree\">{$temperature}&#186;</div>

        <div id=\"weather__cloud\">
            {$cloud}
        </div>
        <div id=\"weather__location\">
            <div>
                <svg width=\"18\" height=\"23\" viewBox=\"0 0 14 16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                <path d=\"M7.00001 0.125C5.35957 0.126935 3.78688 0.779452 2.62692 1.93941C1.46696 3.09938 0.814442 4.67207 0.812507 6.3125C0.810542 7.65306 1.24843 8.95725 2.05901 10.025C2.05901 10.025 2.22776 10.2472 2.25532 10.2793L7.00001 15.875L11.7469 10.2764C11.7717 10.2466 11.941 10.025 11.941 10.025L11.9416 10.0233C12.7517 8.95603 13.1894 7.65245 13.1875 6.3125C13.1856 4.67207 12.5331 3.09938 11.3731 1.93941C10.2131 0.779452 8.64044 0.126935 7.00001 0.125ZM7.00001 8.5625C6.555 8.5625 6.11998 8.43054 5.74997 8.18331C5.37996 7.93607 5.09157 7.58467 4.92128 7.17354C4.75098 6.7624 4.70642 6.31 4.79324 5.87355C4.88006 5.43709 5.09435 5.03618 5.40902 4.72151C5.72368 4.40684 6.1246 4.19255 6.56105 4.10573C6.99751 4.01892 7.44991 4.06347 7.86104 4.23377C8.27218 4.40407 8.62358 4.69246 8.87081 5.06247C9.11805 5.43248 9.25001 5.86749 9.25001 6.3125C9.24926 6.90901 9.01197 7.48087 8.59017 7.90267C8.16838 8.32446 7.59652 8.56176 7.00001 8.5625Z\" fill=\"white\"/>
          </svg>
            </div>
            <div>{$cityName}</div>
        </div>

        <img id=\"weather__image\" src=\"{$iconUrl}\" alt=\"{$description}\" />
        <div id=\"weather__time\"><br />$M6_e</div>
        <br />
        <a onClick=weatherWeek('$x','$y')><div id=\"weather__location\">$daysfuture</div><br /></a>

    </div>
    <div id=\"weather-week\"></div>
    </td></tr></table>";

    echo $weatherLayout;
}

fetchWeather($x, $y);



    if($nrf7>0){
        $last_limit=3;
        if($Allfn==0){echo"$u3at";}
        if($Allfn>3){$last_limit=$Allfn;}
        $Allf = DB::table('Foto')->select('Namef', 'Formf', 'Fd')->
        where('id', $id)->
        orderBy('Fd', 'desc')->
        limit($last_limit)->
        get();
        $Allfn = $Allf->count();
        if($Allfn>0){
            foreach ($Allf as $Alf) {
                $M5=$Alf->Namef;
                $M7=$Alf->Formf;
                $M6=$Alf->Fd;

                $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
                if ($monm<10){$monmf = substr($M6, 6, 1);}
                else{$monmf=$monm;}
                if($yem<=2007){$yem = "2005-2007"; $monmf="";}

                $katalogface = "Photos/$yem$monmf/$M5.$M7";
                $key = 'katalog_face_' . $katalogface;

                if (Cache::has($key)) {
                    $katalog_face = Cache::get($key);
                } else {
                    $katalog_face = Cache::remember($key, 86400, function () use ($katalogface) {
                        $katalog = Storage::disk('s3')->url($katalogface);
                        $katalog = str_replace("http:", "https:", $katalog);
                        return [
                            'katalog' => $katalog,
                        ];
                    });
                }
                $katalogface = $katalog_face['katalog'];

                echo"<table><tr><td height=5></td></tr></table>
                <table><tr><td align=center width=220 class=fcom>
                <div class=hidblok><table><tr><td height=5></td></tr></table></div>
                <a onclick=abf($id,$M5)><img loading=\"lazy\" src=$katalogface></a>
                <div class=hidblok><table><tr><td height=5></td></tr></table></div>
                </td></tr></table>";
            }
        }
    }
    else{echo"$u2at $u3at";}


    @endphp


    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
            crossorigin="anonymous"></script>

    <!-- Адаптивный -->

    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7495053896041990"
         data-ad-slot="5938872690"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

</div>




<div class="layercityuser2">



<table align=center><tr><td align=center width=532 class=fcom>
    <br />
    <table><tr><td width=520 align=center>


                <div class="layer1">

                <b><h1>{{$statusn}} {{$City}}</h1><h3>
                       @php $admcenter = __('messages.admcenter');  $raycenter = __('messages.raycenter');
                        if ($oblc==$id){echo" $admcenter <br /><a href=/$pref_o$obl> $obl_user2</a>";}
                        else if ($rayc==$id){echo"  <a href=/$pref_d$rayc> $raycenter</a>";}
                        @endphp
                 </h3></b>

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
                        if($raycn>0){echo"<h3><a href=/$domenr/$lnc>$raycent $Cityray</a></h3>";}
                    }
                     if($oblc!=$id){
                        $Allo = DB::table('Allcities')->select($City_s,'domen')->
                        where('id', $oblc)->limit(1)->get();
                        $oblcn=0;
                        foreach ($Allo as $Alo) {
                            $Cityobl=$Alo->$City_s; $domeno=$Alo->domen;
                            $oblcn++;
                        }
                        if($oblcn>0){echo"<h3><a href=/$domeno/$lnc>$oblcent $Cityobl</a></h3>";}
                    }
                    echo"<br />";

                 @endphp

                </div>

                <div class="layer1">

                   @if($go_q=="go")

                        <div id="question_in"> </div>
                        <table><tr><td width=295 align=center>
                        <textarea ID=question rows=2 cols=30 placeholder="{{__('messages.quest1')}}" onFocus="clearss('question');"></textarea>
                        </td></tr></table>

                      <table><tr><td valign=top>
                        @guest @else
                                <table>
                                <tr><td class="fcomblue" width=90>
                                <ul class="intop"><li><a onclick=question('me','{{$id}}','/question_inc')>{{__('messages.quest4')}}</a></li></ul>
                                </td></tr>
                                </table>
                        @endguest

                        </td><td valign=center><b>{{__('messages.quest5')}}</b></td><td valign=top>

                        <table>
                        <tr><td class="fcomblue" width=90>
                        <ul class="intop"><li><a onclick=question('anonim','{{$id}}','/question_inc')> {{__('messages.quest6')}}</a></li></ul>
                        </td></tr>
                        </table>
                      </td></tr></table>
                   @endif

            </div>

    </td></tr></table>

</td></tr></table>



@php
        $questions_n = substr_count($questions,"#!^:*&");

        if((int)$questions_n>0){
			$questions = explode("#!^:*&", $questions);
			echo"<table align=center><tr><td height=4></td></tr></table>";

            for($q=100;$q<=$questions_n+99; $q++){

                    echo"<table><tr><td width=532 align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                    <div id=\"q_box$q\" style=\"max-width: 530px; overflow: hidden\"><table>";

            $ques=$questions[$q-99];
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
                    $whattoread = @fopen($filename, "r");
                    $file_contents = fread($whattoread, filesize($filename)); fclose($whattoread);
                     $page = explode("#!:*&", $file_contents);

                    $q_Im=$page[1]; $q_Priz=$page[2];
                    // $q_Im  = mb_detect_encoding($q_Im0, array('utf-8', 'cp1251'));
                    // $q_Im = iconv($q_Im,'utf-8//TRANSLIT//IGNORE',$q_Im0);
                    // $q_Priz  = mb_detect_encoding($q_Priz0, array('utf-8', 'cp1251'));
                    // $q_Priz = iconv($q_Priz,'utf-8//TRANSLIT//IGNORE',$q_Priz0);

                    $q_Num_a=$page[3]; if($q_Num_a<10){$q_Num_a=7;}
                }


            $secm = substr($q_data, 14, 2); $hourm = substr($q_data, 11, 2);
            $Md_tod = date('Y-m-d');
            $Md_yes = date('Y-m-d', strtotime('-1 days'));
            $Md_yes_yes = date('Y-m-d', strtotime('-2 days'));

            $fM6 = substr($q_data, 0, 10);
            if($fM6==$Md_tod){$M6_e=__('messages.today');}
            else if($fM6==$Md_yes){$M6_e=__('messages.yesterday');}
            else if($fM6==$Md_yes_yes){$M6_e=__('messages.yesterday2');}
            else {
              $daym = substr($q_data, 8, 2); $monm = substr($q_data, 5, 2); $yem = substr($q_data, 0, 4);
                                               for ($a=1; $a<13; $a++){ if($a<10){$aa = "0$a";} else{$aa = "$a";}
                                                 if($monm == "$aa"){ $monm = "messages.mmon$a"; $monm = __($monm); }
                                              }

                       if(substr($daym, 0, 1)==0){$daym = substr($daym, 1, 1);}

            $M6_e="$daym $monm $yem";}


            echo"<tr><td width=2></td><td width=70 align=center valign=center>$M6_e </td><td width=2></td>";
                if($q_avt>0){
                    $pref_page = __('messages.pref_page');
                    $pref_pagei = $pref_page.="i";
                     echo"<td width=90 align=center>
                    <a href=/$pref_pagei$q_avt><div style=\"height: 50px; overflow: hidden\"><img border=0 SRC=/storage/avatar/s$q_Num_a.jpg></div></a><a href=/$pref_pagei$q_avt>$q_Im $q_Priz</a>
                </td>";}
                else{ $someone = __('messages.quest10'); $block = __('messages.lock');
                    echo"<td width=90 align=center> $someone <p style = \"font-size: 10px;\">$q_ip</p>";
                    if($admpass=="ok" && mb_strlen($q_ip)>5){ echo"<div id=\"ban$q\"><a onclick=ban_qc('ban$q','$q_ip','$id')> $block Ip</a></div>"; }
                    echo"</td>";
                }
            echo"<td width=2></td><td width=335 valign=center><div style=\"maxwidth: 335px; overflow: hidden\"><b>$q_question</b></div>";

            if($go_q=="go"){
                $qenter = __('messages.qenter'); $answ = __('messages.answ');
                echo"<br /><div id=\"q_err$q\"></div><textarea ID=ask$q rows=1 cols=25 placeholder=\"$qenter\" onFocus=\"clearsq('ask$q','dcmes$q');\"></textarea>
                <div id=dcmes$q style=\"display: none;\">
                <table><tr><td class=\"fcomblue\" width=200>
                <ul class=\"intop\"><li><a href = ### onclick=askc('q_box$q','ask$q','$q','$id')> $answ </a></li></ul>
                </td></tr></table></div>";
            }


            if(($q_avt>0 && $my_id>0 && $q_avt==$my_id) || $admpass=="ok"){
                $Delete = __('messages.Delete');
                echo"<br /><a onclick=del_qc('q_box$q','$q','$id')>$Delete</a>";
            }

          echo"</td><td width=2></td></tr></table>
          </div></td></tr></table>
          <table align=center><tr><td height=4></td></tr></table>";

            } //for($q=100;$q<=$questions_n+99;$q++){

        } // if($questions_n>0){
@endphp


    <table><tr><td height=4></td></tr></table>
    <table align=center><tr><td align=center width=532 class=fcom>
         <br />
         <table><tr><td width=360 align=center>
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
                $Citym = $All->$Cityq; $domen_neib = $All->domen;
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
                <img src="/map/1x1.gif" width=360 height=390 useMap=#Map2>
                <map name=Map2>
                @php echo"$mapk"; @endphp
                </map>
            </section>

        </td></tr></table>
    </td></tr></table>
	<!--
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
            crossorigin="anonymous"></script>
			-->
    <!-- Адаптивный -->
	<!--
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7495053896041990"
         data-ad-slot="5938872690"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
	-->
    @php
        $Allm =DB::table('Memory')->select('afisha', 'theme', 'idrec','Aboutec','Nameg','Whog','r_gol','r_kol','rh','Md','Ip','avt')
        ->where('id',$id)->where('afisha','1')
        ->orderBy('Md','Desc')
        ->limit(100)
        ->get();
        $Afishan = $Allm->count();

        if ($Afishan>0) {$fast_e = __('messages.fastens'); $hide = __('messages.hide');
        if(isset($_COOKIE['achide'])){$achide = $_COOKIE['achide'];} else {$achide = "";}
        if($achide=="0"){ $hstyle2 = "style=\"display: none;\" ";}
        else {$hstyle2 = "";}

        echo"<table align=center><tr><td height=4></td></tr></table>
        <table><tr><td width=535 class=fcom align=center><a onclick=ashow()><h4>$fast_e</h4></a></td></tr></table>
        <table><tr><td width=530 align=right>
            <div id=\"hidafisha\" $hstyle2><a onclick=ahide()><b>$hide</b></a></div>
        </td><td width=5></td></tr></table><div id=\"afisha\" $hstyle2>";

            foreach ($Allm as $All) {
                $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutec; $M2=$All->Nameg; $M3=$All->Whog; $r_gol=$All->r_gol;
                 $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt; $rh=$All->rh;

                 echo view('inc.memory', ['id' => $id, 'afisha' => $afisha, 'themeg' => $themeg, 'idrec' => $idrec, 'M1' => $M1, 'M2' => $M2, 'M3' => $M3, 'r_gol' => $r_gol, 'r_kol' => $r_kol,
                 'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'admpass' => $admpass, 'rh' => $rh, 'purp' => 'main']);
            }
            echo"</div>";
        }




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
        if($Alltn>0){$th_e = __('messages.theme'); $go = __('messages.Go');
        $Alltn_e = round($Alltn/7);
        if ($Alltn_e<1){$Alltn_e=1;}
        echo"<table align=center><tr><td height=4></td></tr></table>
        <table><tr><td width=535 class=fcom align = center>
            <div style=\"maxwidth: 505px; overflow: hidden; margin: 10px 15px 0px 15px;\">
            <table><tr><td valign=center>
            <b>$th_e:</b> </td><td valign=center><select id=\"th\" size=$Alltn_e>";
                foreach ($Allt as $All) {
                    $theme=$All->theme;
                    if(mb_strlen($theme)>0){
                        if(mb_strlen($theme)>25){$theme_e = mb_substr($theme, 0, 25); $theme_e.="...";}
                        else {$theme_e = $theme;}
                        echo"<option value=\"$theme\" >$theme_e</option>";
                    }
                }
            echo"</select> </td><td><table>
                        <tr><td class=\"fcomblue\" width=80>
                        <ul class=\"intop\"><li><a onclick=memt($id,$rayc);> $go</a></li></ul>
                        </td></tr>
                        </table></div>
               </td></tr></table><br />
        </td></tr></table>";
        }
    @endphp



    @if($my_id>0)
        @if(mb_strstr($ComForBan, $my_id)=="")
            <table><tr><td height=2></td></tr></table>
            <div id="memt_res"></div>
            <table><tr><td width=535 class=fcom>
                <div id=\"m$t2\" style="maxwidth: 505px; overflow: hidden; margin: 10px 15px 0px 15px;">
                    <table><tr><td width=295 align=center>
                      <textarea ID="memt" rows=2 cols=40 placeholder="{{__('messages.mem_in_t')}}" onFocus="clearsq('memt','mem_add');"></textarea>
                    </td></tr></table>
                    <div id="mem_add" style="display: none;">
                        <input id="theme_in" size=47 maxlength = 70 placeholder="{{__('messages.mem_in_tem')}}">
                        <table><tr><td class="fcomblue" width=200>
                            <ul class="intop"><li><a href = ### onclick=mem_add('{{$id}}')> {{__('messages.Add')}} </a></li></ul>
                        </td><td width="1"></td><td><a onclick=sml('default')>&nbsp;<img border=0 src=/sml/2.gif title='{{__('messages.sml')}}'> &nbsp;</a></td></tr></table>

                        <div id="app_mem"></div>
                        <div id="app_mem_add"></div>
                    </div> <br />
                </div>
            </td></tr></table>
        @endif
    @endif





    <div id="mem">
        @php
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

                                $nr = $Allm->count();

                        $qwans = __('messages.qwans');
                        $enterv = __('messages.enterv');
                        $unsort = __('messages.unsort');


if($nr==11){echo"<div style = \"margin: 5px 0px 0px 0px;\"><table align=center><tr>
<td align=center width=177 class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=mem($id,$rayc,'%^&@#',1,'Desc');><b><a>$qwans</a></b></td>
<td align=center width=177 class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=mem($id,$rayc,'*&^@72438484',1,'Desc');><b><a>$enterv</a></b></td>
<td align=center width=177 class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=mem($id,$rayc,'',1,'Asc');><b><a>$unsort</a></b></td></tr>
</table></div>
";}

        $nm=1;
        foreach ($Allm as $All) {
            if($nm<11){
                $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutec; $M2=$All->Nameg; $M3=$All->Whog; $r_gol=$All->r_gol;
                 $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt; $rh=$All->rh;

                 echo view('inc.memory', ['id' => $id, 'afisha' => $afisha, 'themeg' => $themeg, 'idrec' => $idrec, 'M1' => $M1, 'M2' => $M2, 'M3' => $M3, 'r_gol' => $r_gol, 'r_kol' => $r_kol,
                 'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'admpass' => $admpass, 'rh' => $rh, 'purp' => 'def']);
             }
             else { $nnext = __('messages.nnext');
                    echo "<div id=fnext2 style = \"margin: 5px 0px 8px 0px;\"><table><tr><td align=center width=535 class=fcombold style=\"cursor: hand\"
                    onMouseOver=mem($id,$rayc,'',2,'Desc'); onClick=mem($id,$rayc,'',2,'Desc');><b><a>$nnext</a></b></td></tr></table></div>" ;
             }
         $nm++;
        }
    @endphp
    </div>

<!--
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
            crossorigin="anonymous"></script>
			-->
    <!-- Адаптивный -->
	<!--
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7495053896041990"
         data-ad-slot="5938872690"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

-->




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


        echo"<table>";
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

            echo"<tr><td height=7></td></tr>
            <tr><td width=535 style=\"cursor: pointer;\" class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\"
            onClick=\"document.location='/$domen/$lan/$link'\">
                <div style=\"margin: 0px 10px 15px 10px; overflow: hidden\">
                    <a href=/$domen/$lan/$link>$ua...</a><br />
                </div>
            </td></tr>";
        }
        echo"</table>";
        $all_blog_records =  __('messages.all_blog_records');
        echo"<table width=100%><tr>
            <tr><td height=7></td></tr>
            <td class=\"fcomblue\" align=center><ul class=intop><li> <a href=/$domen/blog/$lan/2><b><font color=white>$all_blog_records</font></b></a></li></ul> </td>
            </tr></table><br />";





        $life_avto =  __('messages.life_avto');
        $life_buss =  __('messages.life_buss');
        $life_serv =  __('messages.life_serv');
        $life_med =  __('messages.life_med');
        $life_loc =  __('messages.life_loc');
        $life_subs =  __('messages.life_subs');
        $life_scool =  __('messages.life_scool');
        $life_good =  __('messages.life_good');
        echo"
        <table><tr><td height=7></td></tr>
        <tr><td width=535 class=fcom
            <br /><center><h3> $life_good</h3></center><br />

            <table><tr><td align=right width=250>
                <table>
                <tr><td width=240 height=30 align=left style=\"cursor: pointer;\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"life(1,'avto','','$id')\"><a><h4>&nbsp;$life_avto </h4></a></td></tr>
                <tr><td width=240 height=30 align=left style=\"cursor: pointer;\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"life(1,'biz','','$id')\"><a><h4>&nbsp;$life_buss</h4></a></td></tr>
                <tr><td width=240 height=30 align=left style=\"cursor: pointer;\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"life(1,'serv','','$id')\"><a><h4>&nbsp;$life_serv</h4></a></td></tr>
                <tr><td width=240 height=30 align=left style=\"cursor: pointer;\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"life(1,'med','','$id')\"><a><h4>&nbsp;$life_med</h4></a></td></tr>
                <tr><td width=240 height=30 align=left style=\"cursor: pointer;\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"life(1,'loc','','$id')\"><a><h4>&nbsp;$life_loc</h4></a></td></tr>
                <tr><td width=240 height=30 align=left style=\"cursor: pointer;\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"life(1,'sub','','$id')\"><a><h4>&nbsp;$life_subs</h4></a></td></tr>
                <tr><td width=240 height=30 align=left style=\"cursor: pointer;\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"life(1,'sch','','$id')\"><a><h4>&nbsp;$life_scool $statusr </h4></a></td></tr>
                </table>

            </td><td width=1></td><td width=249 align=center>
                <div id=aboute_life></div>
            </td></tr></table><br />
        </td></tr></table><br />";
    }








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
        $online = __('messages.online');
        $delete = __('messages.delete');
        $lan = App::currentLocale();

        $guests_e="$guests $statusr $City";
        if($lan == "en"){$guests_e="$guests of $City $statusr";}
        echo"<table align=center><tr><td height=2></td></tr></table>
        <table align=center><tr><td align=center width=535 class=fcom>
            <h3>$guests_e</h3>
            <div id=guests><table>";
            $nrow=1; $ng=1;
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
                        $filename = "storage/last_visit/$avtc.txt";
                        if (file_exists($filename) && filesize($filename) > 0) {
                           $time_file = filemtime($filename);
                           $time_sec=time();
                           $t = $time_sec - $time_file;
                           if ($t <= 500 && $Numm != $avtc) {
                               $qonl = "<br /><font size=1 color=green>$online</font>";
                           }
                        }
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
                    $Vd_e="<br /> <font size=1 color=grey>$Vd_e</font>";}
                    else{$Vd_e="";}

                    $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}

                    if($nrow==1){echo"<tr valign=top>";}
                    else{echo"</td>";}
                    echo"<td width=75 align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">";
                    $nameg="$Img<br />$Prizg";
                    if($Numm==$avtc){$nameg="$Img";}
                    echo"<div id=\"$t3\" style=\"max-width: 75px; overflow: hidden\">
                    <a href=/$ppref_page$avtc><div class=\"scale\" style=\"height: 50px; overflow: hidden\">
                    <img SRC=/storage/avatar/s$Num_a.jpg border=0></div></a><br />
                    <a href=/$ppref_page$avtc><font size=1>$nameg</font></a>$qonl";
                    if($admpass=="ok"||$Numm==$avtc){ echo"$Vd_e<br /><a onclick=guesc_del('$avtc','$Vds','$t3','$id')> <font size=1>$delete</font></a>";}
                    echo"</div>";

                    $nrow++;
                    if($nrow==6){$nrow=1; echo"</td></tr>";}
                }

                $ng++;
            }
             echo"</table>";

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
                    echo"<div id=$t2>
                        <table align=center><tr><td height=2></td></tr></table>
                        <table style=\"cursor: pointer;\">
                        <tr><td width=390 align=center class=\"fcom\" onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\"
                        onClick=guesc('0','$t2','$pregg','$id')><a><b>$nnext</b></a></td></tr>
                        </table>

                    </div>";
                }

            echo"</div><br />
        </td></tr></table>";
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
    @endphp

    @php $my_mail_e = ""; @endphp
    @guest @else
        @php $my_mail=Auth::user()->email;
                               if (filter_var($my_mail, FILTER_VALIDATE_EMAIL)) {$my_mail_e = $my_mail;}
        @endphp
    @endguest
    <table align=center><tr><td height=2></td></tr></table>
    <table align=center><tr><td align=center width=535 class=fcom>
                <br /><h3>{{__('messages.subscr1')}}</h3> {{__('messages.subscr2')}}

                <br /><br />
                <table>
                    <tr><td>

                            <b>E-mail:</b><input type="text" id="Pmail" value="{{$my_mail_e}}" size=14>
                            <select id="mailnp">
                                <option value="/mailaddc">{{__('messages.Add')}}</option>
                                <option value="/mailchangec">{{__('messages.Set')}}</option>
                                <option value="/maildelc">{{__('messages.Delete')}}</option>
                            </select>
                            <input type="hidden" name="id" id="id"  value="{{$id}}">
                        </td><td><td class="fcomblue" width=65>
                            <ul class="intop"><li><a onclick="dataSelect()">{{__('messages.Go')}}</a></li></ul>
                        </td></tr>
                </table>

                <br /><div id=mailfield></div>
                <br />

            </td></tr></table>



    @php


        if($Allbn>0){$publdiv="off";

            foreach ($Allb as $Alb) {
                $Num = $Alb->Num;
                $Allu = DB::table('users')->select('Im', 'Priz', 'avatar', 'l_visit')->
                where('id', $Num)->where('aktiv', 1)->limit(1)->get();
                $Allun = $Allu->count();
                if($Allun>0){

                    foreach ($Allu as $Alu) {
                        $Im = $Alu->Im; $Priz = $Alu->Priz; $Num_a = $Alu->avatar; $l_visit = $Alu->l_visit;
                        $from=strtotime($l_visit);
                        $Md_is_online = date('Y-m-d H:i');
                        $to=strtotime($Md_is_online);
                        $razn=($to-$from)/60;
                        $on_line_block="";
                        $online = __('messages.online');
                        if ($razn<=5){$on_line_block="<font color=green><b>$online</b></font><br />";}
                        if((int)$Num_a>10){}
                        else{$Num_a=7;}
                        $pref_page = __('messages.pref_page'); $ppref_page = $pref_page .="i";
                        $avae="<table><tr><td><a href=/$pref_page$Num><div style=\"height: 50px; margin: 5px 5px 5px 5px; overflow: hidden\">
                        <img SRC=\"/storage/avatar/s$Num_a.jpg\" border=0></div></a></td><td valign=top>";

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
                                    $adm_panel_e = "<br /><a href=/adm/$id>$adm_panel</a>";
                                }
                            }
                            $seestatadmf_page=$ppage.="seestatadmc";
                        $nicn = "<b><a href=\"/$pref_page$Num\";>$Im $Priz</a></b><br />$on_line_block
                        $takes <b><a href=/$seestatadmf_page/$nav>$nav $place</a>$adm_panel_e</b></td></tr></table>";

                        if($publdiv=="off"){ $publdiv="on";
                            $adm_page = __('messages.adm_page');
                            echo"<br /><table><tr><td class=\"fcom\" width=535 align=center>
                            <br /><h3>$adm_page</h3><br /><table><tr><td width=330 align=center>";
                        }
                        echo"$avae $nicn";
                    }
                }
            }
            if($publdiv=="on"){echo"</td></tr></table><br /><br /></td></tr></table>";}
        }
    @endphp
    @if($admpass=="off")
    <table align=center><tr><td height=2></td></tr></table>
    <table align=center><tr><td align=center width=535 class=fcom>
                <div id="be_admin"><a onclick="be_admin('{{$id}}','Memory')"><h4>{{__('messages.be_admin')}}</h4></a></div>
    </td></tr></table>
    @endif
</div>


    <table align=center><tr><td height=2></td></tr></table>
    <table align=center><tr><td align=center width=535 class=fcom><br />
    <h4>{{__('messages.sharing')}}:</h4>
    @php
        $wh_domen=$_SERVER["HTTP_HOST"];
        $sh_link = "https%3A%2F%2F$wh_domen%2F$domen%2F$lan";
    @endphp
        <noindex>
            <table><tr>
                <td><div class="scale">
                    <a target="_blank" href="https://www.facebook.com/sharer.php?u={{$sh_link}}">
                    <img width="35" class="scale" src="/images/fb40.png"></a>
                </div></td>
                <td width="2"></td>
                <td><div class="scale">
                    <a target="_blank" href="https://telegram.me/share/url?url={{$sh_link}}">
                    <img width="35" class="scale" src="/images/tgram40.png"></a>
                </div></td>
                <td width="2"></td>
                <td><div class="scale">
                    <a target="_blank" href="viber://forward?text={{$sh_link}}">
                    <img width="35" class="scale" src="/images/viber40.png"></a>
                </div></td>
                <td width="2"></td>
                <td><div class="scale">
                    <a target="_blank" href="https://twitter.com/intent/tweet?url={{$sh_link}}">
                    <img width="35" class="scale" src="/images/twitter40.png"></a>
                </div></td>
                <td width="2"></td>
                <td><div class="scale">
                    <a target="_blank" href="https://api.whatsapp.com/send?text={{$sh_link}}">
                    <img width="35" class="scale" src="/images/wapp40.png"></a>
                </div></td>
            </tr></table>
        </noindex>
    <br />
    </td></tr></table>
<!--
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                    crossorigin="anonymous"></script>
					-->
            <!-- Адаптивный -->
			<!--
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-7495053896041990"
                 data-ad-slot="5938872690"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
-->


</div>
</div>



        <div style="display: none;" id="fc">{{$_SERVER['REQUEST_URI']}}</div>
        <div style="display: none;" id="rate">{{$sumr}}</div>
        <div style="display: none;" id="id_page">{{$id}}</div>
    @endif



    <br /><br />
@endsection
