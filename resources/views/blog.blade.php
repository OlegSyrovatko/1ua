@extends('layouts.app')

@php
$title = __('messages.blogall_tit');
$description = __('messages.blogall_des');
$keywords = __('messages.gps_key');
$index_go="index,follow";
$lan = App::currentLocale();

if(isset($_POST['npass1'])){$npass1 = $_REQUEST['npass1'];}
else if(isset($npass1)){}else {$npass1 = 2;}

if(isset($_POST['domen'])){$domen = $_REQUEST['domen'];}
else if(isset($domen)){}else {$domen = "";}

    if ($lan == "ua"){
        $Alls = DB::table('Allcities')->select('id', 'City', 'obl', 'status', 'vol_karta', 'face_karta', 'oblc', 'rayc',
         'City_m', 'City_o', 'City_r', 'City_d')->
        where('domen', $domen)->
        limit(1)->get();
        $cq1 = "ua";
        $cq2 = "uatext";
        $life_link = "liferu";
    }
    if ($lan == "ru"){
          $Alls = DB::table('Allcities')->select('id', 'City2', 'obl', 'status', 'vol_karta', 'face_karta', 'oblc', 'rayc',
         'rod', 'dat', 'vin', 'tvor', 'predl')->
        where('domen', $domen)->
        limit(1)->get();
            $cq1 = "ru";
            $cq2 = "rutext";
            $life_link = "liferu";
    }
    $nrc = $Alls->count();
    if($nrc==0){
            $title = __('messages.unknown_page');
            $keywords = "";
            $description = $title;
    }
    else{
        $title = "";
        $keywords = "";
        foreach ($Alls as $All) {
            $idc = $All->id;
            $obl = $All->obl;
            $status = $All->status;
            $vol_karta = $All->vol_karta;
            $face_karta = $All->face_karta;
            $oblc = $All->oblc;
            $rayc = $All->rayc;

            if ($lan == "ua"){
                $City = $All->City;
                $City_m = $All->City_m;
                $City_o = $All->City_o;
                $City_r = $All->City_r;
                $City_d = $All->City_d;
            }
            if ($lan == "ru"){
                $City2 = $All->City2; $City = $City2;
                $rod = $All->rod;
                $dat = $All->dat;
                $vin = $All->vin;
                $tvor = $All->tvor;
                $predl = $All->predl;
            }
        }

		if ($lan == "ua"){
			if ($status){
				if ($status==1){$ss=1; $statusnv="Місто"; $statusn="місто"; $statusr="міста"; $statusd="місту"; $statusm="місті"; $statuso="містом"; $statuspro="міської";}
				if ($status==2){$ss=2; $statusnv="Смт"; $statusn="смт"; $statusr="смт"; $statusd="смт"; $statusm="смт"; $statuso="смт"; $statuspro="селищної";}
				if ($status==3){$ss=3; $statusnv="Селище"; $statusn="селище"; $statusr="селища"; $statusd="селищу"; $statusm="селищі"; $statuso="селищем"; $statuspro="селищної";}
				if ($status==4){$ss=4; $statusnv="Село"; $statusn="село"; $statusr="села"; $statusd="селі"; $statusm="селі"; $statuso="селом"; $statuspro="сільської";}
				if ($status==5){$ss=5; $statusnv="Хутір"; $statusn="хутір"; $statusr="хутора"; $statusd="хутору"; $statusm="хуторі"; $statuso="хутором"; $statuspro="хутірської";}
			}
			else{
			if (!$vol_karta||$vol_karta<20000){$ss=4; $statusnv="Село"; $statusn="село"; $statusr="села"; $statusd="селі"; $statusm="селі"; $statuso="селом"; $statuspro="сільської";}
			if ($vol_karta>=20000&&$vol_karta<50000){$ss=2; $statusnv="Місто (село)"; $statusn="місто (село)"; $statusr="міста (села)"; $statusd="місту (селу)"; $statusm="місті (селі)"; $statuso="містом (селом)"; $statuspro="міської (сільської)";}
			if ($vol_karta>=50000){$ss=1; $statusnv="Місто"; $statusn="місто"; $statusr="міста"; $statusd="місту"; $statusm="місті"; $statuso="містом"; $statuspro="міської";}
			}
			$description = "Життя, новини, форум, блог, щоденник";
			$keywords = "Публікації $statusr $City, жителі у $statusm $City_m, громада, мешканці, день";
			$title = "$City - блог $statusr";
		}

		if ($lan == "ru"){

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
			$description = "Жизнь $statusr $City2, новости, форум, блог, дневник";
			$keywords = "Публикации $statusr $City2, жители в $statusne $City2, общество, жители, день";
			$title = "$City2 - блог $statusr";
		}

    }
@endphp

@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection

@section('content')
<div align="center">
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




@php

if((int)$nrc == 0){

	if ($lan == "ua"){
		echo"
		<center>
		<br /><br /><br /><br /><br /><br /><br /><br />
		<table><tr><td width=300 align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
		<table><tr><td width=280 align=center>
		<br />Такої сторінки $domen на сайті немає<br /> Почніть пошук з <a href=/> <b>головної сторінки</b></a><br /><br />
		</td></tr></table>
		</td></tr></table>
		<br /><br />
		</center>";
	}
	if ($lan == "ru"){
		echo"
		<center>
		<br /><br /><br /><br /><br /><br /><br /><br />
		<table><tr><td width=300 align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
		<table><tr><td width=280 align=center>
		<br />Такой страницы $domen нет на сайте <br /> Начните поиск с <a href=/> <b>главной страницы</b></a><br /><br />
		</td></tr></table>
		</td></tr></table>
		<br /><br />
		</center>";
	}
}


else{

    echo"<br />
    <table width=47%><tr>
            <td class=\"fcomblue\" width=47% align=center><ul class=intop><li> <a href=/$domen/$lan><b><font color=white>$City</font></b></a></li></ul> </td>
        </tr></table>
    <br />";


    if($idc==23334 || $idc==73918){
        $Alls = DB::table('life')->select('id')->
        whereNull('non_vis')->
        get();
    }
    else{
        $Alls = DB::table('life')->select('id')->
        get();
    }
        $nrr = $Alls->count();
        $limit10 = "";
        // if((!$npass1)||$npass1==0){$npass1=1;}

        // $npass1=$npass1+1; $npass1=$npass1-1;
        // if(is_int($npass1)!="true"){die("");}
        $npass1 = filter_var($npass1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if (!$npass1) {
            $npass1 = 1;
        }

        $limit = substr($nrr, strlen($nrr)-2, 2);
        if($limit=="00"){$limit=100; $limit10=1;}

        $nrr_pages=intval($nrr/100);
        if($limit10!=1){$nrr_pages=$nrr_pages+1;}

        if($npass1==$nrr_pages){$shift=0;}
        else{
        $shift=$limit + 100*($nrr_pages - $npass1-1);
        $limit=100;
        }


	$l1=$npass1-3;
	$l2=$npass1+3;
	if($l2>$nrr_pages){$l2=$nrr_pages;}

	echo"<table><tr><td align=center width=535><table width=100%><tr>";

	if($l2!=$nrr_pages){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$domen/blog/$lan/$nrr_pages><b><font color=white>$nrr_pages</font></b></a></li></ul> </td>";}
	if(($nrr_pages-$l2)>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}

	for($l2; $l1<=$l2; $l2--){

	if($l2>0 && $l2<=$nrr_pages){

		if($npass1!=$l2){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$domen/blog/$lan/$l2><b><font color=white>$l2</font></b></a></li></ul> </td>";}
		else{echo"<td class=fcom0 align=center> <b>$l2</b> </td>";}
	}

	}
	if($l2>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}
	if($l2>0){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$domen/blog/$lan/1><b><font color=white>1</font></b></a></li></ul> </td>";}

	echo"</tr></table>
	</td></tr></table>";


    echo"<div id=news class=\"content\">

    <br /><br />
    <table>";


    if($idc==23334 || $idc==73918){
        $Allc = DB::table('life')->
        select($cq2, 'link')->
        whereNull('non_vis')->
        orderBy('id', 'desc')->
        skip($shift)->take($limit)->
        get();
    }
    else{
        $Allc = DB::table('life')->
        select($cq2, 'link')->
        orderBy('id', 'desc')->
        skip($shift)->take($limit)->
        get();
    }


    foreach ($Allc as $All) {
        $ua = $All->$cq2;
        $link = $All->link;

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


            $ua = str_replace("<p style='text-indent: 45px;'>", "", $ua);
            $ua = str_replace("</p>", "", $ua);

            $ua = substr($ua, 0, 300);
            $nseek2=20;
            for($nseek=1;$nseek<20;$nseek++){
             $rest = substr($ua, -$nseek);
             if(strstr($rest, " ")!=""){$nseek2=$nseek; $nseek=20;}
            }

            $ua = substr($ua, 0, 300-$nseek2);
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


            $ua = str_replace("<p style='text-indent: 45px;'>", "", $ua);
            $ua = str_replace("</p>", "", $ua);

            $ua = substr($ua, 0, 300);
            $nseek2=20;
            for($nseek=1;$nseek<20;$nseek++){
             $rest = substr($ua, -$nseek);
             if(strstr($rest, " ")!=""){$nseek2=$nseek; $nseek=20;}
            }

            $ua = substr($ua, 0, 300-$nseek2);

        }

        echo"<tr><td width=535 height=30 style=\"cursor: pointer;\" class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
        <div style=\"margin: 8px 15px 15px 15px; \">
        <a href=/$domen/$lan/$link>$ua...</a>
        </div></td></tr>";
    }

    echo"</table>";

    $l1=$npass1-3;
    $l2=$npass1+3;
    if($l2>$nrr_pages){$l2=$nrr_pages;}

	echo"<br /><table><tr><td align=center width=535><table width=100%><tr>";

	if($l2!=$nrr_pages){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$domen/blog/$lan/$nrr_pages><b><font color=white>$nrr_pages</font></b></a></li></ul> </td>";}
	if(($nrr_pages-$l2)>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}

	for($l2; $l1<=$l2; $l2--){

		if($l2>0 && $l2<=$nrr_pages){
			if($npass1!=$l2){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$domen/blog/$lan/$l2><b><font color=white>$l2</font></b></a></li></ul> </td>";}
			else{echo"<td class=fcom0 align=center> <b>$l2</b> </td>";}
		}

	}
	if($l2>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}
	if($l2>0){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$domen/blog/$lan/1><b><font color=white>1</font></b></a></li></ul> </td>";}

	echo"</tr></table></td>
	</tr></table><br />";

}

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

    <br /><br />
</div>
@endsection
