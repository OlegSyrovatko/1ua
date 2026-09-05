@extends('layouts.app')

@php

$description = __('messages.lifeall_des');
// Шаблонні статті: той самий текст для 25 855 населених пунктів, з підстановкою назви
// міста/відмінка — Google це не індексує (перевірено: 0 результатів на кілька slug'ів),
// тож noindex прибирає ризик "scaled content abuse", контент лишається доступним людям.
$index_go="noindex,follow";
$lan = App::currentLocale();

if(isset($_POST['topic'])){$topic = $_REQUEST['topic'];}
else if(isset($topic)){}else {$topic = "";}
if(isset($_POST['domen'])){$domen = $_REQUEST['domen'];}
else if(isset($domen)){}else {$domen = "";}

    if ($lan == "ua"){
        $Alls = DB::table('Allcities')->select('id', 'City', 'obl', 'status', 'vol_karta', 'face_karta', 'oblc', 'rayc',
         'City_m', 'City_o', 'City_r', 'City_d', 'x', 'y')->
        where('domen', $domen)->
        limit(1)->get();
        $cq1 = "ua";
        $cq2 = "uatext";
        $life_link = "liferu";
    }
    if ($lan == "ru"){
          $Alls = DB::table('Allcities')->select('id', 'City2', 'obl', 'status', 'vol_karta', 'face_karta', 'oblc', 'rayc',
         'rod', 'dat', 'vin', 'tvor', 'predl', 'x', 'y')->
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
            $uatag = $title;

    }
    else{
        $title = "";
        $keywords = "";
        $rod = "";
        $dat = "";
        $vin = "";
        $tvor = "";
        $predl = "";
        $City2 = "";

        $statusnv="";
        $statusn="";
        $statusne="";
        $statusny="";
        $statusr="";
        $statusno="";
        $uatag = "";
        foreach ($Alls as $All) {
            $idc = $All->id;
            $obl = $All->obl;
            $status = $All->status;
            $vol_karta = $All->vol_karta;
            $face_karta = $All->face_karta;
            $oblc = $All->oblc;
            $rayc = $All->rayc;
            $x = $All->x;
            $y = $All->y;

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

                if($obl==1){$obln = "АР Крим"; $oablni = "АР Крим";}
                if($obl==2){$obln = "Волинська область"; $oablni = "Волинської області";}
                if($obl==3){$obln = "Вінницька область"; $oablni = "Вінницької області";}
                if($obl==4){$obln = "Дніпропетровська область"; $oablni = "Дніпропетровської області";}
                if($obl==5){$obln = "Донецька область"; $oablni = "Донецької області";}
                if($obl==6){$obln = "Житомирська область"; $oablni = "Житомирської області";}
                if($obl==7){$obln = "Закарпатська область"; $oablni = "Закарпатської області";}
                if($obl==8){$obln = "Запорізька область"; $oablni = "Запорізької області";}
                if($obl==9){$obln = "Івано-Франківська область"; $oablni = "Івано-Франківської області";}
                if($obl==10){$obln = "Київська область"; $oablni = "Київської області";}
                if($obl==11){$obln = "Кіровоградська область"; $oablni = "Кіровоградської області";}
                if($obl==12){$obln = "Львівська область"; $oablni = "Львівської області";}
                if($obl==13){$obln = "Луганська область"; $oablni = "Луганської області";}
                if($obl==14){$obln = "Миколаївська область"; $oablni = "Миколаївської області";}
                if($obl==15){$obln = "Одеська область"; $oablni = "Одеської області";}
                if($obl==16){$obln = "Полтавська область"; $oablni = "Полтавської області";}
                if($obl==17){$obln = "Рівненська область"; $oablni = "Рівненської області";}
                if($obl==18){$obln = "Сумська область"; $oablni = "Сумської області";}
                if($obl==19){$obln = "Тернопільська область"; $oablni = "Тернопільської області";}
                if($obl==20){$obln = "Хмельницька область"; $oablni = "Хмельницької області";}
                if($obl==21){$obln = "Харківська область"; $oablni = "Харківської області";}
                if($obl==22){$obln = "Херсонська область"; $oablni = "Херсонської області";}
                if($obl==23){$obln = "Чернівецька область"; $oablni = "Чернівецької області";}
                if($obl==24){$obln = "Черкаська область"; $oablni = "Черкаської області";}
                if($obl==25){$obln = "Чернігівська область"; $oablni = "Чернігівської області";}
            }
            if ($lan == "ru"){
                $City2 = $All->City2;
                $rod = $All->rod;
                $dat = $All->dat;
                $vin = $All->vin;
                $tvor = $All->tvor;
                $predl = $All->predl;
                $City = $City2;


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


                if(mb_strlen($rod)>2){} else{$rod="$statusr $City2";}
                if(mb_strlen($dat)>2){} else{$dat="$statusny $City2";}
                if(mb_strlen($vin)>2){} else{$vin="$statusn $City2";}
                if(mb_strlen($tvor)>2){} else{$tvor="$statusno $City2";}
                if(mb_strlen($predl)>2){} else{$predl="$statusne $City2";}

                if($obl==1){$obln = "АР Крым";}
                if($obl==2){$obln = "Волынская область";}
                if($obl==3){$obln = "Винницкая область";}
                if($obl==4){$obln = "Днепропетровская область";}
                if($obl==5){$obln = "Донецкая область";}
                if($obl==6){$obln = "Житомирская область";}
                if($obl==7){$obln = "Закарпатская область";}
                if($obl==8){$obln = "Запорожская область";}
                if($obl==9){$obln = "Ивано-Франковская область";}
                if($obl==10){$obln = "Киевская область";}
                if($obl==11){$obln = "Кропивницкая область";}
                if($obl==12){$obln = "Львовская область";}
                if($obl==13){$obln = "Луганская область";}
                if($obl==14){$obln = "Николаевская область";}
                if($obl==15){$obln = "Одесская область";}
                if($obl==16){$obln = "Полтавская область";}
                if($obl==17){$obln = "Ровненская область";}
                if($obl==18){$obln = "Сумская область";}
                if($obl==19){$obln = "Тернопольская область";}
                if($obl==20){$obln = "Хмельницкая область";}
                if($obl==21){$obln = "Харьковская область";}
                if($obl==22){$obln = "Херсонская область";}
                if($obl==23){$obln = "Черновицкая область";}
                if($obl==24){$obln = "Черкасская область";}
                if($obl==25){$obln = "Черниговская область";}
                if($obl==1){$oablni = "АР Крым";}
                if($obl==2){$oablni = "Волынской области";}
                if($obl==3){$oablni = "Винницкой области";}
                if($obl==4){$oablni = "Днепропетровской области";}
                if($obl==5){$oablni = "Донецкой области";}
                if($obl==6){$oablni = "Житомирской области";}
                if($obl==7){$oablni = "Закарпатской области";}
                if($obl==8){$oablni = "Запорожской области";}
                if($obl==9){$oablni = "Ивано-Франковской области";}
                if($obl==10){$oablni = "Киевской области";}
                if($obl==11){$oablni = "Кировоградской области";}
                if($obl==12){$oablni = "Львовской области";}
                if($obl==13){$oablni = "Луганской области";}
                if($obl==14){$oablni = "Николаевской области";}
                if($obl==15){$oablni = "Одесской области";}
                if($obl==16){$oablni = "Полтавской области";}
                if($obl==17){$oablni = "Ровненской области";}
                if($obl==18){$oablni = "Сумской области";}
                if($obl==19){$oablni = "Тернопольской области";}
                if($obl==20){$oablni = "Хмельницкой области";}
                if($obl==21){$oablni = "Харьковской области";}
                if($obl==22){$oablni = "Херсонской области";}
                if($obl==23){$oablni = "Чернивецкой области";}
                if($obl==24){$oablni = "Черкасской области";}
                if($obl==25){$oablni = "Черниговской области";}

            }
        }

        $cq1 = "ua";
        $cq2 = "uatext";
        $life_link = "lifeua";
        if (App::isLocale('ru')){
                $cq1 = "ru";
                $cq2 = "rutext";
                $life_link = "liferu";
        }
        $Allss = DB::table('life')->select('id')->
        get();
        $nrr = $Allss->count();
        $lc = $nrr;
        $lc_page=round($lc/100+0.49);

        if($idc==23334 || $idc==73918){
            $Alls = DB::table('life')->select($cq1, $cq2, 'id', 'r_kol', 'r_gol', 'avto', 'biz', 'serv', 'loc', 'med', 'sub', 'sch')->
            where('link', $topic)->
            whereNull('non_vis')->
            limit(1)->
            get();
        }
        else{
            $Alls = DB::table('life')->select($cq1, $cq2, 'id', 'r_kol', 'r_gol', 'avto', 'biz', 'serv', 'loc', 'med', 'sub', 'sch')->
            where('link', $topic)->
            limit(1)->
            get();
        }
        $nrl = $Alls->count();

        if($nrl==0){ echo"gggggggggg";
                $title = __('messages.unknown_page');
                $uatag = "";
                $description = $title;
        }
        else{
            $title = "";
            $keywords = "";
            foreach ($Alls as $All) {
                $ua = $All->$cq1;
                $mytxt = $All->$cq2;
                $id = $All->id;
                $r_kol = $All->r_kol;
                $r_gol = $All->r_gol;
                $avto = $All->avto; $biz = $All->biz; $serv = $All->serv; $loc = $All->loc; $med = $All->med; $sub = $All->sub; $sch = $All->sch;
                 $uatag = str_ireplace("{", "", $ua);
                 $uatag = str_ireplace("}", "", $uatag);
                 $uatag = str_ireplace("?|", "? ", $uatag);
                 $keywords = str_ireplace("|", ", ", $uatag);
                 $description = $description.= "$keywords";
            }
            if ($lan == "ua"){
                 $uatag = str_ireplace("{", "", $ua);
                 $uatag = str_ireplace("}", "", $uatag);
                 $uatag = str_ireplace("?|", "? ", $uatag);
                 $uatag = str_ireplace("|", ", ", $uatag);
                 $uatag = str_replace("$", "", $uatag);
                 $uatag = str_replace("City_d", $City_d, $uatag);
                 $uatag = str_replace("City_r", $City_r, $uatag);
                 $uatag = str_replace("City_o", $City_o, $uatag);
                 $uatag = str_replace("City_m", $City_m, $uatag);
                 $uatag = str_replace("City", $City, $uatag);
                 $uatag = str_replace("statusnv", $statusnv, $uatag);
                 $uatag = str_replace("statusn", $statusn, $uatag);
                 $uatag = str_replace("statusr", $statusr, $uatag);
                 $uatag = str_replace("statusd", $statusd, $uatag);
                 $uatag = str_replace("statusm", $statusm, $uatag);
                 $uatag = str_replace("statuso", $statuso, $uatag);
                 $uatag = str_replace("statuspro", $statuspro, $uatag);

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

                $ntag=substr_count($ua, '{');

                for($ntag0=1;$ntag0<=$ntag;$ntag0++){

                  $position = strpos($ua, "{"); $content = substr($ua, $position+1);
                  $position = strpos($content, "}"); $content = substr($content, 0, $position);

                $content2 = "|$content";
                $ntag2=substr_count($content2, '|');
                $words = explode("|", $content2);
                $zn=1;
                $word=$words[$zn];
                $contentr="{"; $contentr.=$content; $contentr.="}";
                $ua = str_replace("$contentr", "$word", $ua);
                }

                 $mytxt = str_replace("$", "", $mytxt);
                 $mytxt = str_replace("City_d", $City_d, $mytxt);
                 $mytxt = str_replace("City_r", $City_r, $mytxt);
                 $mytxt = str_replace("City_o", $City_o, $mytxt);
                 $mytxt = str_replace("City_m", $City_m, $mytxt);
                 $mytxt = str_replace("City", $City, $mytxt);
                 $mytxt = str_replace("statusnv", $statusnv, $mytxt);
                 $mytxt = str_replace("statusn", $statusn, $mytxt);
                 $mytxt = str_replace("statusr", $statusr, $mytxt);
                 $mytxt = str_replace("statusd", $statusd, $mytxt);
                 $mytxt = str_replace("statusm", $statusm, $mytxt);
                 $mytxt = str_replace("statuso", $statuso, $mytxt);
                 $mytxt = str_replace("statuspro", $statuspro, $mytxt);
                 $mytxt = str_replace("oablni", $oablni, $mytxt);
                 $mytxt = str_replace("obln", $obln, $mytxt);
                 $mytxt = str_replace("xkarta", $x, $mytxt);
                 $mytxt = str_replace("ykarta", $y, $mytxt);
                 $mytxt = str_replace("domen", $domen, $mytxt);

                 $ntag = substr_count($mytxt, '{');

                for($ntag0 = 1; $ntag0 <= $ntag; $ntag0++) {

                    $position = strpos($mytxt, "{");
                    $content = substr($mytxt, $position + 1);
                    $position = strpos($content, "}");
                    $content = substr($content, 0, $position);

                    $content2 = "|".$content;
                    $ntag2 = substr_count($content2, '|');
                    $words = explode("|", $content2);
                    $zn=1;
                    $word = $words[$zn];

                    $contentr = "{".$content."}";
                    $mytxt = str_replace($contentr, $word, $mytxt);
                }

                 $title = "$City - $ua";
                 $description = "Новини $statusr $City $uatag";
            }
            if ($lan == "ru"){

                 $uatag = str_ireplace("{", "", $ua);
                 $uatag = str_ireplace("}", "", $uatag);
                 $uatag = str_ireplace("?|", "? ", $uatag);
                 $uatag = str_ireplace("|", ", ", $uatag);
                 $uatag = str_replace("$", "", $uatag);
                 $uatag = str_replace("rod", $rod, $uatag);
                 $uatag = str_replace("dat", $dat, $uatag);
                 $uatag = str_replace("vin", $vin, $uatag);
                 $uatag = str_replace("tvor", $tvor, $uatag);
                 $uatag = str_replace("predl", $predl, $uatag);
                 $uatag = str_replace("City", $City2, $uatag);
                 $uatag = str_replace("statusnv", $statusnv, $uatag);
                 $uatag = str_replace("statusne", $statusne, $uatag);
                 $uatag = str_replace("statusny", $statusny, $uatag);
                 $uatag = str_replace("statusr", $statusr, $uatag);
                 $uatag = str_replace("statusno", $statusno, $uatag);
                 $uatag = str_replace("statuspro", $statuspro, $uatag);
                 $uatag = str_replace("statusn", $statusn, $uatag);

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

                $ntag=substr_count($ua, '{');

                for($ntag0=1;$ntag0<=$ntag;$ntag0++){

                  $position = strpos($ua, "{"); $content = substr($ua, $position+1);
                  $position = strpos($content, "}"); $content = substr($content, 0, $position);

                $content2 = "|$content";
                $ntag2=substr_count($content2, '|');
                $words = explode("|", $content2);
                $zn=1;
                $word=$words[$zn];
                $contentr="{"; $contentr.=$content; $contentr.="}";
                $ua = str_replace("$contentr", "$word", $ua);
                }

                 $mytxt = str_replace("podat", "#s655dfb7hbw4t", $mytxt);
                 $mytxt = str_replace("$", "", $mytxt);
                 $mytxt = str_replace("rod", $rod, $mytxt);
                 $mytxt = str_replace("dat", $dat, $mytxt);
                 $mytxt = str_replace("vin", $vin, $mytxt);
                 $mytxt = str_replace("tvor", $tvor, $mytxt);
                 $mytxt = str_replace("predl", $predl, $mytxt);
                 $mytxt = str_replace("City", $City2, $mytxt);
                 $mytxt = str_replace("statusnv", $statusnv, $mytxt);
                 $mytxt = str_replace("statusne", $statusne, $mytxt);
                 $mytxt = str_replace("statusny", $statusny, $mytxt);
                 $mytxt = str_replace("statusr", $statusr, $mytxt);
                 $mytxt = str_replace("statusno", $statusno, $mytxt);
                 $mytxt = str_replace("statuspro", $statuspro, $mytxt);
                 $mytxt = str_replace("statusn", $statusn, $mytxt);
                 $mytxt = str_replace("obln", $obln, $mytxt);
                 $mytxt = str_replace("oablni", $oablni, $mytxt);
                 $mytxt = str_replace("xkarta", $x, $mytxt);
                 $mytxt = str_replace("ykarta", $y, $mytxt);
                 $mytxt = str_replace("domen", $domen, $mytxt);
                 $mytxt = str_replace("#s655dfb7hbw4t", "podat", $mytxt);

                 $ntag = substr_count($mytxt, '{');

                for($ntag0 = 1; $ntag0 <= $ntag; $ntag0++) {

                    $position = strpos($mytxt, "{");
                    $content = substr($mytxt, $position + 1);
                    $position = strpos($content, "}");
                    $content = substr($content, 0, $position);

                    $content2 = "|".$content;
                    $ntag2 = substr_count($content2, '|');
                    $words = explode("|", $content2);
                    $zn=1;
                    $word = $words[$zn];

                    $contentr = "{".$content."}";
                    $mytxt = str_replace($contentr, $word, $mytxt);
                }

                 $title = "$City2 - $ua";
                 $description = "Новости $statusr $City2 $uatag";
            }

			$Alldb = DB::table('life-cities')->select('topic', 'keywords', 'description', 'text')->
			where('id', $idc)->
			where('link', $topic)->
			where('lan', $cq1)->
			limit(1)->
			get();
			$nrl_db = $Alldb->count();

			if($nrl_db > 0){
				foreach ($Alldb as $Adb) {
					$title = $Adb->topic;
					$uatag = $Adb->keywords;
					$description = $Adb->description;
					$mytxt = $Adb->text;
				}
			}

        }
    }


@endphp

@section('description'){{$description}}@endsection
@section('keywords'){{$uatag}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection

@section('content')
<div align="center">

@php
if(Auth::user()) {

    $admin =  Auth::user()->id;
    if($admin == 72372396){
        echo"<script>
function life_sitemap() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name=\"csrf-token\"]').attr('content')}
    });
    var sss = 1;
    var formData = {
        q:'$topic'
    };
    $.ajax({
        type: 'POST',
        url: '/life_sitemap',
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(\"life_sitemap\").innerHTML = data;
        }
    });
}
</script>
    <input type=\"button\" value=\"life_sitemap\" onclick=\"life_sitemap()\">
    <div id=\"life_sitemap\"></div>";

    }

}
@endphp



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

else if((int)$nrl == 0){
if ($lan == "ua"){
    echo"
    <center>
    <br /><br /><br /><br /><br /><br /><br /><br />
    <table><tr><td width=300 align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
    <table><tr><td width=280 align=center>
    <br />Такої теми на сайті немає<br /> Почніть пошук з <a href=/$domen/blog/ua/2> <b>списку тем</b></a><br /><br />
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
    <br />Такой темы нет на сайте <br /> Начните поиск с <a href=/$domen/blog/ru/2> <b>списка тем</b></a><br /><br />
    </td></tr></table>
    </td></tr></table>
    <br /><br />
    </center>";
}
}

else {


$views = (int) \Illuminate\Support\Facades\Redis::get("life_views:$id");
$ip = getenv('REMOTE_ADDR');
if (strstr($ip,"66.249.")=="" && \Illuminate\Support\Facades\Redis::set("dedup:lif:$id", 1, 'EX', 60, 'NX')){
    \Illuminate\Support\Facades\Redis::incr("life_views:$id");
}


$all_records = __('messages.all_records');

echo"<br />
<table width=93% style=\"max-width: 600px;\"><tr>
<td class=\"fcomblue\" width=93%  align=center><ul class=intop><li> <a href=/$domen/blog/$lan/><b><font color=white>$all_records ($lc)</font></b></a></li></ul> </td>
</tr></table>
<br />


<div id=news style = \"max-width:600px; margin:0 auto; overflow: hidden; width: 93%; text-align: left; font-size: 85%;\">
<table><tr><td>";


if (strstr($mytxt,"#foto_close")!=""){

$x = (float)$x;
$y = (float)$y;
$x0=$x-0.3;$x1=$x+0.3;
$y0=$y-0.15;$y1=$y+0.15;


      $Allf = DB::table('Allcities')->
      select('id', 'City', 'City2', 'domen', 'ab')->
    where('x', '>', $x0)->
    where('x', '<', $x1)->
    where('y', '>', $y0)->
    where('y', '<', $y1)->
    get();

    $t_repl="";
    $t_repln="0";

    foreach ($Allf as $All) {
        $idc = $All->id;
        $City = $All->City;
        $City2 = $All->City2;
        $domenf = $All->domen;
        $ab = $All->ab;
        if($lan=="ru"){$City=$City2;}
     $pagec = explode("#!", $ab);
    $nrf=$pagec[7]; if(!$nrf){$nrf=0;}

    if($t_repln==0){}else{ if($nrfh==0){}else{ $t_repl.="";}}
    if($nrf>0){$t_repl.="<p style='text-indent: 45px;'><a href=/$domenf/foto/$lan target=_blank><b>$City</b> ($nrf фото)</a></p>"; $t_repln=1; }
    $nrfh=$nrf;
}

$mytxt = str_replace("#foto_close", $t_repl, $mytxt);

}


if (strstr($mytxt,"#cartpage")!=""){
$mview_tit =  __('messages.$mview_tit');
$llink = "mc$idc";
if($lan=="ru"){$llink = "rmc$idc";}
$mytxt = str_replace("#cartpage", "<a target=_blank href=/$llink><b>$mview_tit</b></a>", $mytxt);

}



/*
if (strstr($mytxt,"#video_close")!=""){

$x0=$x-0.3;$x1=$x+0.3;
$y0=$y-0.15;$y1=$y+0.15;


$stmt = $pdo->prepare('SELECT id, City, ab FROM Allcities where x>:x0 and x<:x1 and y>:y0 and y<:y1 order by City asc');
$stmt->execute(array('x0' => $x0,'x1' => $x1,'y0' => $y0,'y1' => $y1));

$t_repl="";
$t_repln="0";

while ($row = $stmt->fetch(PDO::FETCH_LAZY))
{$idf=$row['id']; $City=$row['City']; $ab=$row['ab'];

     $pagec = explode("#!", $ab);
    $nrf=$pagec[9]; if(!$nrf){$nrf=0;}

    if($t_repln==0){}else{ if($nrfh==0){}else{ $t_repl.="";}}
    if($nrf>0){$t_repl.="<p style='text-indent: 45px;'><a href=/vc$idf target=_blank><b>$City</b> ($nrf відео)</a></p>"; $t_repln=1; }
    $nrfh=$nrf;
}

$mytxt = str_replace("#video_close", $t_repl, $mytxt);

}
*/
/*
if($nrl_db == 0){

$ntag=substr_count($mytxt, '{');

for($ntag0=1;$ntag0<=$ntag;$ntag0++){

  $position = strpos($mytxt, "{"); $content = substr($mytxt, $position+1);
  $position = strpos($content, "}"); $content = substr($content, 0, $position);

$content2 = "|$content";
$ntag2=substr_count($content2, '|');
$words = explode("|", $content2);
$zn=rand(1,$ntag2);
$word=$words[$zn];
$contentr="{"; $contentr.=$content; $contentr.="}";
$mytxt = str_replace("$contentr", "$word", $mytxt);
}

DB::table('life-cities')->insert([
    'id' => $idc,
    'link' => $topic,
    'lan' => $cq1,
    'topic' => $title,
    'keywords' => $uatag,
    'description' => $description,
    'text' => $mytxt
]);

}
*/
$views = (int)$views;
$views++;
$view = __('messages.views');


echo"$mytxt
<br /><img src=/images/zoom.png title='$view'> <font size=3><b>$views</b></font>";

echo"</td></tr></table></div>";


$q_s1[0] = ['avto', 5];
$q_s2[0] = ['avto', 5];
$q_s3[0] = ['avto', 5];
$q_s4[0] = ['avto', 5];
$q_s5[0] = ['avto', 5];
$q_s6[0] = ['avto', 5];
$q_s7[0] = ['avto', 5];
if($avto==2){$q_s1[0] = ['avto', 2];}
if($biz==2){$q_s2[0] = ['biz', 2];}
if($serv==2){$q_s3[0] = ['serv', 2];}
if($loc==2){$q_s4[0] = ['loc', 2];}
if($med==2){$q_s5[0] = ['med', 2];}
if($sub==2){$q_s6[0] = ['sub', 2];}
if($sch==2){$q_s7[0] = ['sch', 2];}

if($idc==23334 || $idc==73918){
$Allm = DB::table('life')
->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3, $q_s4, $q_s5, $q_s6, $q_s7) {
    $query->whereNull('non_vis')
        ->orWhere($q_s1)
        ->orWhere($q_s2)
        ->orWhere($q_s3)
        ->orWhere($q_s4)
        ->orWhere($q_s5)
        ->orWhere($q_s6)
        ->orWhere($q_s7);
})
->select($cq1,'link')
->orderBy('id', 'desc')
->limit(7)
->get();
}
else{
$Allm = DB::table('life')
->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3, $q_s4, $q_s5, $q_s6, $q_s7) {
    $query->where('avto', 5)
        ->orWhere($q_s1)
        ->orWhere($q_s2)
        ->orWhere($q_s3)
        ->orWhere($q_s4)
        ->orWhere($q_s5)
        ->orWhere($q_s6)
        ->orWhere($q_s7);
})
->select($cq1,'link')
->orderBy('id', 'desc')
->limit(7)
->get();
}

foreach ($Allm as $All) {
$ua = $All->$cq1;
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
     $ua = str_replace("obln", $obln, $ua);
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
     $ua = str_replace("statusne", $statusne, $ua);
     $ua = str_replace("statusny", $statusny, $ua);
     $ua = str_replace("statusr", $statusr, $ua);
     $ua = str_replace("statusno", $statusno, $ua);
     $ua = str_replace("statuspro", $statuspro, $ua);
     $ua = str_replace("statusn", $statusn, $ua);
     $ua = str_replace("obln", $obln, $ua);
}
$ntag=substr_count($ua, '{');

for($ntag0=1;$ntag0<=$ntag;$ntag0++){

    $position = strpos($ua, "{"); $content = substr($ua, $position+1);
    $position = strpos($content, "}"); $content = substr($content, 0, $position);

    $content2 = "|$content";
    $ntag2=substr_count($content2, '|');
    $words = explode("|", $content2);
    $zn=1;
    $word=$words[$zn];
    $contentr="{"; $contentr.=$content; $contentr.="}";
    $ua = str_replace("$contentr", "$word", $ua);


    if(strlen($ua)>40){$tsize=1;} else{$tsize=2;}
    echo"<table width=93% style=\"max-width: 600px;\"><tr><td class=\"fcomblue\" align=center>
        <ul class=intop><li> <a href=/$domen/$lan/$link><b><font color=white size=$tsize>$ua </font></b></a> </li></ul>
        </td></tr></table><br />";

}

}
@endphp
    <br /><br />
    <h5>{{__('messages.sharing')}}:</h5>
    @php
        $lan = App::currentLocale();
        $wh_domen=$_SERVER["HTTP_HOST"];
        $sh_link = "https%3A%2F%2F$wh_domen%2F$domen%2F$lan%2F$topic";
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

@php
}
@endphp

</div>
@endsection
