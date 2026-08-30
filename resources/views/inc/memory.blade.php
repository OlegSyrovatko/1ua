@php
$time_sec=time();
if(Auth::user()){$Numm = Auth::user()->id;} else{$Numm="999999";}

     //   $afisha=$All->afisha; $idrec=$All->idrec; $M1=$All->Aboutec; $M2=$All->Nameg; $M3=$All->Whog; $r_gol=$All->r_gol;
     //    $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt;
     $M5 = $idrec;
     $lan_user = App::currentLocale();
if($lan_user == "ru"){$M1 = str_replace("читати далі", "читать дальше", $M1);}
if($lan_user == "en"){$M1 = str_replace("читати далі", "read more", $M1);}


if(strstr($M1,"youtube.com/watch?v=")!=""){
$M1 = str_replace("http://www.youtube.com/watch", "", $M1);
$M1 = str_replace("http://youtube.com/watch", "", $M1);
$M1 = str_replace("https://www.youtube.com/watch", "", $M1);
$M1 = str_replace("https://youtube.com/watch", "", $M1);
$M1 = str_replace("www.youtube.com/watch", "", $M1);
$M1 = str_replace("youtube.com/watch", "", $M1);
$start = "?v="; $position = strpos($M1, $start); $link = substr($M1, $position+3, 11);
$M1 = str_replace("?v=", "", $M1);
$M1 = str_replace("$link", "<iframe title=\"YouTube video player\" width=\"340\" height=\"256\" src=\"http://www.youtube.com/embed/$link\" frameborder=\"0\" allowfullscreen></iframe>", $M1);
}

else if(strstr($M1,"youtu.be/")!=""){
$M1 = str_replace("http://www.youtu", "", $M1);
$M1 = str_replace("http://youtu.", "", $M1);
$M1 = str_replace("https://www.youtu", "", $M1);
$M1 = str_replace("https://youtu.", "", $M1);
$M1 = str_replace("www.youtu.", "", $M1);
$M1 = str_replace("youtu.", "", $M1);
$start = "be/"; $position = strpos($M1, $start); $link = substr($M1, $position+3, 11);
$M1 = str_replace("be/", "", $M1);
$M1 = str_replace("$link", "<iframe title=\"YouTube video player\" width=\"340\" height=\"256\" src=\"http://www.youtube.com/embed/$link\" frameborder=\"0\" allowfullscreen></iframe>", $M1);
}

            if((int)$avt>0){
                $aavt = avt($avt,$Numm);
            }else {if($Ipmp){$aavt = "Ip: $Ipmp";} else{$aavt = "";}
                if($M2){
                    $aavt = "<div style=\"float:left;  margin: 0px 10px 8px 0px;\"<div style=\"height: 50px; overflow: hidden; \">
                    <img SRC=/storage/avatar/s7.jpg></div><div style = \"font-size: 12px;\">$M2 <br />$M3</div></div>";
                }
            }
         if(mb_strlen($themeg)>0){  $themem = __('messages.theme'); $theme_e = "<b>$themem: $themeg</b><br />";  }
         else{$theme_e = "";}
        $M11 = "<table style=\"maxwidth: 100%;\"><tr><td>$aavt $theme_e $M1</td></tr></table>";
        if(strstr($M1,"%^&@#")!=""){

            $positionaa = strpos($M1, "<b>%^&@#</b>"); $quest_t = substr($M1, $positionaa+15, 1500); $quest_t2 = $quest_t;
            $positionbb = strpos($quest_t, "<b>&@#%^</b>");   $quest_t = substr($quest_t, 0, $positionbb);
            $positionaa = strpos($quest_t2, "<b>&@#%^</b>"); $answ_t = substr($quest_t2, $positionaa+14, 1500);

            if(substr($answ_t, 0, 1) == "-"){$answ_t = substr($answ_t, 1, 1500);}
            if (strlen($answ_t)==0){$answ_t = "-";}


            $avtall = strstr($M1,"*&^@");
            list($avt_old) = sscanf($avtall, "*&^@%d");
            if((int)$avt_old>0){
                $qavt = avt($avt_old,$Numm);
            }else {$qavt = "";}

    $answ5 = __('messages.answ5');    $quest = __('messages.quest');
    $M11 = "<section class=\"forum-answser\">
            <div class=\"mw225\"><b>$quest</b><br />$qavt $quest_t</div>
            <div class=\"mw225\"><b>$answ5</b><br />$aavt $answ_t </div>
        </section>";
    }

$M6_e= db_date($M6);

$t1="qwertyuiopasdfghjklzxcvbnm";
$t2="";
for($i=0;$i<4;$i++){
$z=rand(0,strlen($t1)-1);
$t2.="$t1[$z]";
}
    $my_id = ""; $del_e = "";
if($admpass=="ok"||($avt==$Numm&&$avt>10)){

     $Delete = __('messages.Delete');
     $confirm = __('messages.confirm');
     $yesd = __('messages.yes');
     $no = __('messages.cancel');
	$del_e = "<div id=\"unsel$t2\">
			<a onclick=\"mem_arguem('d$t2','unsel$t2'); return false;\">$Delete</a>
		</div>
		<div id=\"d$t2\" style=\"display: none;\">
			$confirm <b><br /><a onclick=\"mem_delm('$idrec','m$t2','$id'); return false;\">$yesd</a><br />
			<a onclick=mem_not_delm('d$t2','unsel$t2')> $no</a></b>
		</div>";
}
    $fasten_e = "";
if($admpass=="ok"){
    if($afisha == 1){
		$fasten = __('messages.unfasten');
		$afisha_s=0;
		}
	else{
		$fasten = __('messages.fasten');
		$afisha_s=1;
	}
        $fasten_e = "<div id=\"unsel$idrec\"><a href=## onclick=\"publ('$idrec','$id','$afisha_s')\">$fasten</a></div>";
}

$M11 = str_replace("<a onclick=mem_arguem", "<a href=##  rel=\"noopener noreferrer\" onclick=mem_arguem", $M11);
if($avt>0){
        $M11 = preg_replace_callback(
        '/(https?:\/\/[^\s<]+[^.,:;"\')\]\s<])/u',
        function ($matches) {
            $url = $matches[0];
            $shortUrl = (strlen($url) > 35) ? substr($url, 0, 35) . "..." : $url;
            return '<a target="_blank" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"><b>' . htmlspecialchars($shortUrl, ENT_QUOTES, 'UTF-8') . '</b></a>';
        },
        $M11
    );
}
echo"<section id=\"m$t2\" class=\"fcom city-center-forum\">
    $M11
    <section class=\"mem-menu\">
        <p>$M6_e</p>
        $fasten_e";

        @endphp
        <div id="d{{$M5}}{{$purp}}" class="" style="display: flex; gap: 10px; align-items: center;">
        @php
            if (!$r_gol){$r_gol=0; $r_gol2=0; $r_kol=0;}
            else{$r_gol2=round($r_gol/$r_kol,2); $r_gol=round($r_gol/$r_kol);}
            if($r_gol>0.5){$star1="on";}else{$star1="off";}
            if($r_gol>1.5){$star2="on";}else{$star2="off";}
            if($r_gol>2.5){$star3="on";}else{$star3="off";}
            if($r_gol>3.5){$star4="on";}else{$star4="off";}
            if($r_gol>4.5){$star5="on"; $star55="onm";}else{$star5="off"; $star55="offm";}
            $nrand = rand(111,99999999);
            $M5_1=$nrand+1; $M5_1="i$M5_1"; $M5_2=$nrand+2; $M5_2="i$M5_2"; $M5_3=$nrand+3; $M5_3="i$M5_3"; $M5_4=$nrand+4; $M5_4="i$M5_4"; $M5_5=$nrand+5; $M5_5="i$M5_5";
            $Mm5_5=$nrand+5; $Mm5_5="im$Mm5_5";

             if (mb_strstr("$rh",$Numm)!=""){$bb1="<b>"; $bb2="</b>";}
             else{$bb1=""; $bb2="";}
             $est1 = __('messages.esteem1');
             $est2 = __('messages.esteem2');
             $est3 = __('messages.esteem3');
             $est4 = __('messages.esteem4');
             $est5 = __('messages.esteem5');

            echo"
            <div class=hidblok>
                <a href=## onclick=rate_addm('d$M5$purp',$M5,1) onMouseOver=\"return ch(1,$nrand,0)\"; onMouseOut=\"return ch(1,$nrand,1)\"; rel=\"noopener noreferrer\"><img alt=\"$est1\" src=\"/$star1.png\" name=$M5_1 width=13 height=13></a><a href=## onclick=rate_addm('d$M5$purp',$M5,2) onMouseOver=\"return ch(2,$nrand,0)\"; onMouseOut=\"return ch(2,$nrand,1)\"; rel=\"noopener noreferrer\"><img alt=\"$est2\" src=\"/$star2.png\" name=$M5_2 width=13 height=13></a><a href=## onclick=rate_addm('d$M5$purp',$M5,3) onMouseOver=\"return ch(3,$nrand,0)\"; onMouseOut=\"return ch(3,$nrand,1)\"; rel=\"noopener noreferrer\"><img alt=\"$est3\" src=\"/$star3.png\" name=$M5_3 width=13 height=13></a><a href=## onclick=rate_addm('d$M5$purp',$M5,4) onMouseOver=\"return ch(4,$nrand,0)\"; onMouseOut=\"return ch(4,$nrand,1)\"; rel=\"noopener noreferrer\"><img alt=\"$est4\" src=\"/$star4.png\" name=$M5_4 width=13 height=13></a><a href=## onclick=rate_addm('d$M5$purp',$M5,5) onMouseOver=\"return ch(5,$nrand,0)\"; onMouseOut=\"return ch(5,$nrand,1)\"; rel=\"noopener noreferrer\"><img alt=\"$est5\" src=\"/$star5.png\" name=$M5_5 width=13 height=13></a>
            </div>
            <div class=hidblokwide>
                <a href=## onclick=rate_addm('d$M5$purp',$M5,5) onMouseOver=\"return ch2(5,$nrand,0)\"; onMouseOut=\"return ch2(5,$nrand,1)\"; rel=\"noopener noreferrer\"><img alt=\"$est5\" src=\"/$star55.png\" name=$Mm5_5 width=25 height=25></a>
            </div>
            <a href=## onclick=rate_hm('r$M5$purp',$M5) rel=\"noopener noreferrer\"> $bb1($r_gol2|$r_kol)$bb2</a>
        </div>

        $del_e
    </section>
     <div id=\"r$M5$purp\"></div>";


    echo"<section id=\"m$t2\" class=\"com-block\">";

    if($purp == "main"){$indiv = "tin$M5"; $fromdiv = "tcm$M5";}
    if($purp == "def"){$indiv = "din$M5"; $fromdiv = "dcm$M5";}

    echo"<section id=\"$indiv\" style=\"margin-left: 10px; max-width: 300px; overflow: hidden; \">";
    echo view('inc.commment', ['M5' => $M5, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'off', 'purp' => $purp]);
    echo"</section>";


    if(Auth::user()){
        $comment_in = __('messages.comment_in');
        $Add = __('messages.Add');
        echo "<textarea id=\"$fromdiv\" rows=1 class=\"ml10 w250\" placeholder=\"$comment_in\"
         onFocus=clearsq('$fromdiv','bc$M5$purp');></textarea>
        <div id=\"bc$M5$purp\" class=\"un-display ml10\">
            <table><tr><td class=\"fcomblue intop com-button\">
                <a onclick=\"commm_add($M5,'$fromdiv','$indiv','$purp')\">$Add</a>
            </td></tr></table>
        </div>";
    }

    echo"</section>
</section>";


@endphp



