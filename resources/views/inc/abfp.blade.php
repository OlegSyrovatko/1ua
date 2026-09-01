@php
$time_sec=time();
if(Auth::user()){$Numm = Auth::user()->id;} else{$Numm="0000000000";}

/*
    $M6 = $Alb->Fd;
    $M7 = $Alb->Formf;
    $avt = $Alb->avt;
    $alb = $Alb->album;
    $views = $Alb->views;
    $r_gol = $Alb->r_gol;
    $r_kol = $Alb->r_kol;
    'w' => $w 'h' => $h
*/
    $M5 = $Namef;
    $avtfoto=$avt;
    $pref_page = __('messages.pref_page');

    $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
    if ($monm<10){$monmf = substr($M6, 6, 1);}
    else{$monmf=$monm;}
    if($yem<=2007){$yem = "2005-2007"; $monmf="";}

    if($design!= "alone"){
        $katalogb = "Fotop/$yem$monmf/$M5.$M7";
            $katalogface=Storage::disk('public')->url($katalogb);
            $wcmain = "200px";
    }
    else{
        $katalogface = "";
        $wcmain = "400px";
    }
    if($avt>10 && $avt!=$id){
        $page = last_visit_read($avt);
        if ($page) {
            $Im=$page['im']; $Priz=$page['priz'];
            $ppref_page = $pref_page .="i";
            $M2 = "<a href=/$pref_page$avt><b>$Im $Priz </b></a><br />";
        }
        else{$M2 = ""; $avt=0;}
    }
    else{$M2 = ""; $avt=0;}

    $M6_e= db_date($M6);
    $lan = __('messages.lan');



if($design == "alone"){echo"<div "; } else{echo"<li ";}
echo"class=\"fcom0 menu-item ";
if($design == "alone"){echo"alone-ph non-cursor"; } else{echo"responsive-image-block";}
echo"\" id=\"delf$M5\">";

    $pref_page = __('messages.pref_page');
    $added = __('messages.added');
    $fpref_page = $pref_page .="ni";
	$p_size = 24;
    if($design!= "alone"){
		$p_size = 18;
		$height = round(200*$h/$w);
		 if($alb_des == "default"){echo  "<a href=\"/$domen/foto/$lan/$alb\" class=\"mb15\">" . __('messages.Album') . ": <b>$alb</b></a>";}
        echo  "<a href=\"/$fpref_page$M5\" onmouseover=fview('$M5','fv$M5','$views')>
        <img class=\"pimg\" width=200 height=$height alt=\"$alb\" src=\"$katalogface\"></a>";
    }
    echo"<span class=\"centered mt15\">$M2 $M6_e </span>
	<ul class=\"fmenu\">";

		if($admpass=="ok" || $Numm=="72372396"){
			$dalb = "del_alb$M5";
			echo"
			<li>
				<a onclick=red_fotop('$M5','r$M5')>
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
			<svg class=\"star-container\" width=\"$p_size\" height=\"$p_size\" onclick=rate_addp('d$M5',$M5,'$design') rel=\"noopener noreferrer\">
			  <use class=\"star\" fill=\"$color_star\" href=\"/images/icons.svg#icon-star-full\"></use>
			  <rect class=\"$rect\" fill=\"white\"></rect>
			</svg>
            <a href=## onclick=rate_hp('r$M5',$M5) rel=\"noopener noreferrer\"> $bb1 $r_kol $bb2 </a>
		</li>
	</ul>
	<div class=\"centeredm\" id=\"r$M5\"></div>";
	if($admpass=="ok" || $Numm=="72372396"){
		echo"<div id=\"$dalb\" class=\"un-display mb15\">
			<table><tr><td>" . __('messages.fdelshure2') . "<br /><br />
				<b><a onclick=del_fotop('$M5','delf$M5')>" . __('messages.yes') . "</a>&nbsp;&nbsp;&nbsp;
				 <a onclick=$dalb.style.display='none';>" . __('messages.cancel'). "</a></b>
			 </td></tr></table>
		</div>
    ";
	}

    echo"<div id=\"in$M5\" style=\"max-width: $wcmain; overflow: hidden; margin: 0 auto;\">";
     echo view('inc.commentp', ['M5' => $M5, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'off']);
    echo"</div>";

    if(Auth::user()){
        echo "<textarea id=\"cm$M5\" rows=2  style=\"width: 97%; max-width: $wcmain; margin: 0 auto;\" placeholder=\"" . __('messages.comment_in') . "\"
         onFocus=clearsp('cm$M5','bc$M5');></textarea>
        <div id=\"bc$M5\" class=\"un-display centeredm\">
            <table><tr><td class=\"fcomblue intop com-button\">
                <a onclick=\"comm_addp($M5,'cm$M5','in$M5')\">" . __('messages.Add') . "</a>
            </td></tr></table>
        </div>";
    }
	if($design == "alone"){echo"<br />"; }

if($design == "alone"){echo"</div>"; } else{echo"</li>";}
@endphp



