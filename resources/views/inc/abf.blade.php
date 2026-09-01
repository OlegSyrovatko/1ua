@php
$time_sec=time();
if(Auth::user()){$Numm = Auth::user()->id;} else{$Numm="0000000000";}

/*
            $Nameg = $Alb->Nameg;
            $City = $Alb->City;
            $M3 = $Alb->Adrf;
            $M4 = $Alb->Datef;
            $M6 = $Alb->Fd;
            $M7 = $Alb->Formf;
            $avt = $Alb->avt;
            $alb = $Alb->album;
            $x = $Alb->x;
            $y = $Alb->y;
            $views = $Alb->views;
            $r_gol = $Alb->r_gol;
            $r_kol = $Alb->r_kol;
*/
        $M5 = $Namef;
        $avtfoto=$avt;
        $pref_page = __('messages.pref_page');

        $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
        if ($monm<10){$monmf = substr($M6, 6, 1);}
        else{$monmf=$monm;}
        if($yem<=2007){$yem = "2005-2007"; $monmf="";}

        if($design!= "alone"){

            $katalog = "Photos/$yem$monmf/$Namef.$M7";
			$katalogb = "Photos/$yem$monmf/b$Namef.$M7";
			$katalogface = getKatalogface($katalog, $katalogb);
            $wcmain = "200px";

        }
        else{
            $katalogface = "";
            $wcmain = "400px";

        }
		if($avt>10){
		    $page = last_visit_read($avt);
            if ($page) {
                $Im=$page['im']; $Priz=$page['priz'];
                $ppref_page = $pref_page .="i";
                $M2 = "<b><a href=/$pref_page$avt>$Im $Priz </b></a>";
            }
		    else{$M2 = $Nameg; $avt=0;}
		}
		else{$M2 = $Nameg; $avt=0;}

        $M6_e= db_date($M6);
        $lan = __('messages.lan');

if($design == "alone"){echo"<div "; } else{echo"<li ";}
echo"class=\"fcom0 menu-item ";
if($design == "alone"){echo"alone-ph non-cursor"; } else{echo"responsive-image-block";}
echo"\" id=\"delf$M5\">";

    $pref_page = __('messages.pref_page');
    $Album = __('messages.Album');
    $adr_shot = __('messages.adr_shot');
    $date_shot = __('messages.date_shot');
    $added = __('messages.added');
    $avtor = __('messages.avtor');
    $publed = __('messages.publed');

    $fpref_page = $pref_page .="nf";
    $p_size = 24;
    if($design!= "alone"){
        $p_size = 18;
        if($w>0){$height = round(200*$h/$w);}
        else{$height = "auto";}
         if($alb_des == "default"){echo  "<a href=\"/$domen/foto/$lan/$alb\" class=\"mb15\">" . __('messages.Album') . ": <b>$alb</b></a>";}
        echo  "<a href=\"/$fpref_page$M5\" onmouseover=fviewc('$M5','fv$M5','$views')>
        <img loading=\"lazy\" class=\"pimg\" width=200 height=$height alt=\"$alb\" src=\"$katalogface\"></a>";
    }



    if(strstr($alb,"інтернет") != "" || strstr($alb,"panoramio") != ""){$avt_ee="$publed:"; $M3_e="";}
    else{$avt_ee="$avtor:"; $M3_e="$adr_shot: ";}
    if($M4){
        echo"<span class=\"mt5\">$date_shot: $M4</span>";
    }
    if($M3){echo"<span class=\"mt5\">$M3_e$M3</span>";}
    echo"<span class=\"mt5\">$avt_ee $M2</span>";
    echo"<span class=\"mt5\"> $M6_e </span>";

    $auth_gap = "";
    $views_gap = "";
    if($admpass=="ok" || $Numm=="72372396" || $Numm==$avt){
        $auth_gap = "fmenu-auth";
    }
    if($views>99){$views_gap = "fmenu-views";}
    if($design == "alone"){
        $auth_gap = "";
        $views_gap = "";
    }
    echo"
    <ul class=\"fmenu $auth_gap $views_gap\" style=\"gap: 10;\">";

        if($admpass=="ok" || $Numm=="72372396" || $Numm==$avt){

            $dalb = "del_alb$Namef";
            echo"
            <li>
                <a onclick=red_foto('$M5','r$M5')>
                    <svg width=\"$p_size\" height=\"$p_size\"><use href=\"/images/icons.svg#icon-pencil\"></use></svg>
                </a>
            </li>
            <li>
                <a onclick=$dalb.style.display='block';>
                    <svg width=\"$p_size\" height=\"$p_size\"><use href=\"/images/icons.svg#icon-bin\"></use></svg>
                </a>
            </li>";
        }

        $view = __('messages.views');

        echo"
        <li id=\"fv$M5\" class=\"fview\">
            <svg title='$view' alt='$view' width=\"$p_size\" height=\"$p_size\"><use href=\"/images/icons.svg#icon-magnifying-glass\"></use></svg>
            $views
        </li>

        <li>";
            if($lan=="ua"){$gps_e="gps";}
            if($lan=="ru"){$gps_e="rgps";}
            if($lan=="en"){$gps_e="egps";}

            $p_size_m = $p_size+5;
            $loc = __('messages.location');
            if($x>0 && $y>0){
                echo"<a href=/$gps_e/$M5 aria-label=\"$loc #$M5\">
                    <svg class=\"mt5\" alt='" . __('messages.location'). " #$M5' width=\"$p_size_m\" height=\"$p_size_m\" >
                      <use href=\"/images/icons-map.svg#google-maps\"></use>
                    </svg>
                </a>";
            }
            else{
                echo"<a href=/$gps_e/$M5 aria-label=\"$loc #$M5\">
                    <svg class=\"mt5\" alt='" . __('messages.location'). " #$M5' width=\"$p_size_m\" height=\"$p_size_m\" >
                      <use href=\"/images/icons-map.svg#google-maps-null\"></use>
                    </svg>
                </a>";
            }
    echo"</li>
        <li id=\"d$M5\" class=\"fstar\">";

            if (!$r_gol){ $r_kol=0;}
            $color_star = "";
            $rect = "shine";
            if($r_kol>0){$color_star = "#356AA0";}
            if($r_kol>1){$color_star = "gold";}
            if($r_kol>4){$color_star = "orange";}

            $bb1 = ""; $bb2 = "";
            if (mb_strstr("$rh","$Numm")!=""){
                $rect = ""; $bb1 = "<b>"; $bb2 = "</b>";
                }
            echo"
            <svg class=\"star-container\" width=\"$p_size\" height=\"$p_size\" onclick=rate_add('d$M5',$M5,'$design') rel=\"noopener noreferrer\">
              <use class=\"star\" fill=\"$color_star\" href=\"/images/icons.svg#icon-star-full\"></use>
              <rect class=\"$rect\" fill=\"white\"></rect>
            </svg>
            <a href=## onclick=rate_h('r$M5',$M5) rel=\"noopener noreferrer\"> $bb1 $r_kol $bb2 </a>
        </li>
    </ul>

    <div class=\"centeredm\" id=\"r$M5\"></div>";
    if($admpass=="ok" || $Numm=="72372396" || $Numm==$avt){
        echo"<div id=\"$dalb\" class=\"un-display mb15\">
            <table><tr><td>" . __('messages.fdelshure2') . "<br /><br />
                <b><a onclick=del_foto('$Namef','delf$Namef')>" . __('messages.yes') . "</a>&nbsp;&nbsp;&nbsp;
                 <a onclick=$dalb.style.display='none';>" . __('messages.cancel'). "</a></b>
             </td></tr></table>
        </div>
    ";
    }


    echo"<div id=\"in$M5\" style=\"max-width: $wcmain; overflow: hidden; margin: 0 auto;\">";
    echo view('inc.comment', ['M5' => $M5, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'off']);
    echo"</div>";

     if(Auth::user()){
        echo "<textarea id=\"cm$M5\" rows=2 style=\"width: 95%; max-width: $wcmain; margin: 0 auto;\" placeholder=\"" . __('messages.comment_in') . "\"
         onFocus=clearsq('cm$M5','bc$M5');></textarea>
        <div id=\"bc$M5\" class=\"un-display centeredm\">
            <table><tr><td class=\"fcomblue intop com-button\">
                <a onclick=\"comm_add($M5,'cm$M5','in$M5')\">" . __('messages.Add') . "</a>
            </td></tr></table>
        </div>";
     }
     if($design == "alone"){echo"<br />"; }

if($design == "alone"){echo"</div>"; } else{echo"</li>";}

@endphp



