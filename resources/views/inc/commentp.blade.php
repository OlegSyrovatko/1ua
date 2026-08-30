@php
if(Auth::user()){$Numm = Auth::user()->id;} else{$Numm="0000000000";}


 $Allcm = DB::table('Memoryfp')->select('idrec','Aboutef', 'Md', 'avt')->
 orderBy('Md', 'asc')->
 where('Num', $M5)->get();
 $nrf2 = $Allcm->count();

 if ($nrf2 > 0){

     $delm=1; $hidc=1; $hidc_up=$nrf2;

     foreach ($Allcm as $All) {
         if(($nrf2>2)&&($hidc==2)){echo"<div id=\"hc$M5\" class=\"un-display\">";}

         $idrec = $All->idrec; $M11 = $All->Aboutef; $M6m = $All->Md; $avtc = $All->avt;
         $M6m_e= db_date($M6m);

         if($avtc>0){
            $qavt = avt($avtc,$Numm);
        } else {$qavt = "";  }

        $M11 = preg_replace_callback(
            '/(https?:\/\/[^\s<]+[^.,:;"\')\]\s<])/u',
            function ($matches) {
                $url = $matches[0];
                $shortUrl = (strlen($url) > 30) ? substr($url, 0, 35) . "..." : $url;
                return '<a target="_blank" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"><b>' . htmlspecialchars($shortUrl, ENT_QUOTES, 'UTF-8') . '</b></a>';
            },
            $M11
        );

            $t1="qwertyuiopasdfghjklzxcvbnm";
            $t3="";
            for($i=0;$i<4;$i++){
            $z=rand(0,strlen($t1)-1);
            $t3.="$t1[$z]";
            }
            $t2="a$t3";
        echo"
        <div id=\"$t3\" class=\"mt5\" style\"max-width: 400px; \">
            <table><tr><td>$qavt $M11</td></tr></table>
            <span class=\"mt10\">$M6m_e</span> ";

           if($admpass=="ok" || ($avtc==$Numm&&$avtc>10) || $avtc==$Numm || $Numm=="72372396"){
               echo"<a onclick=$t2.style.display='block';>" . __('messages.Delete') . "</a>
                <div id=\"$t2\" style=\"display: none;\">" . __('messages.confirm') . "<br />
                <table><tr><td align=left width=100><b><a onclick=\"comm_delp('$t3','$idrec'); return false;\">" . __('messages.yes'). "</a></b></td>
                <td align=right width=100><b><a onclick=$t2.style.display='none';>" . __('messages.cancel') . "</a></b><br /></td></tr></table></div>";
            }

        echo"</div>";

           if(($nrf2>2)&&($hidc_up==2)){
               echo"</div>
                <div id=shc$M5 class=\"fcom centered m55010 pointed\" onClick=mem_not_delmp('shc$M5','hc$M5')>
                    <b>" . __('messages.see_all') . " $nrf2 ". __('messages.comments') . "</b>
                </div>";
           }

        $delm++; $hidc++; $hidc_up--;
     }
     if($red=="on"){
         $Ed = __('messages.Ed');

        echo "<br /><div id=\"rbc00$M5\" ><a onclick=mem_arguemp('rbc0$M5','rbc00$M5')><b>$Ed?</b></a></div>
        <div id=\"rbc0$M5\" style=\"display: none;\">
        <textarea id=\"rcm$M5\" rows=3 style=\"width: 95%;\"
         onFocus=clearsp('rcm$M5','rbc$M5');>$M11</textarea>
        <div id=\"rbc$M5\" style=\"display: none;\">
            <table><tr><td class=\"fcomblue\" width=100>
                <ul class=\"intop\"><li><a onclick=\"comm_redp('$idrec','rcm$M5','in$M5')\">$Ed</a></li></ul>
            </td></tr></table>
        </div>
        </div><br />";
    }
     echo"<br />";
 }




@endphp



