@php
if(Auth::user()){$Numm = Auth::user()->id;} else{$Numm="0000000000";}

$Allcm = DB::table('Memorym')->select('idrec2','Aboutef', 'Md', 'avt')->
orderBy('Md', 'asc')->
where('idrec', $M5)->get();
$nrf2 = $Allcm->count();

if ($nrf2 > 0){

    $delm=1; $hidc=1; $hidc_up=$nrf2;

    foreach ($Allcm as $All) {
        if(($nrf2>2)&&($hidc==2)){echo"<div id=\"hc$M5$purp\" style=\"display: none;\">";}

        $M11 = $All->Aboutef; $idrec = $All->idrec2; $M6m = $All->Md; $avtc = $All->avt;

        $M6m_e= db_date($M6m);

       if($avtc>0){
            $qavt = avt($avtc,$Numm);
       } else {$qavt = "";  }

                $t1="qwertyuiopasdfghjklzxcvbnm";
                $t3="";
                for($i=0;$i<4;$i++){
                $z=rand(0,strlen($t1)-1);
                $t3.="$t1[$z]";
                }

       echo"
       <div style=\"margin: 5px \"></div>
           <div id=\"$t3\">
           <table><tr><td width=400>$qavt  $M11
           <br /><font color = gray>$M6m_e</font>";

            $confirm = __('messages.confirm');
            $Delete = __('messages.Delete');
            $Ed = __('messages.Ed');
            $yesd = __('messages.yes');
            $no = __('messages.cancel');

          if($admpass=="ok"||($avtc==$Numm&&$avtc>10)||$avt==$Numm || $Numm=="72372396"){
                $t1="qwertyuiopasdfghjklzxcvbnm";
                $t2="";
                for($i=0;$i<4;$i++){
                $z=rand(0,strlen($t1)-1);
                $t2.="$t1[$z]";
                }
              echo" <a onclick=$t2.style.display='block';>$Delete</a>
               <div id=\"$t2\" style=\"display: none;\">$confirm<br />
               <table><tr><td align=left width=100><b><a onclick=\"commm_del('$t3','$idrec'); return false;\">$yesd</a></b></td>
               <td align=right width=100><b><a onclick=$t2.style.display='none';>$no</a></b><br /></td></tr></table></div>";
         }

        echo"</td></tr></table>
        </div>";

          if(($nrf2>2)&&($hidc_up==2)){

              $see_all = __('messages.see_all');
              $cmts = __('messages.comments');
              echo"</div>

           <div id=shc$M5$purp class=\"see-more-comm fcom colored\"
                onClick=mem_not_delm('shc$M5$purp','hc$M5$purp')><b>$see_all $nrf2 $cmts</b></td></tr>
           </div>";
          }

       $delm++; $hidc++; $hidc_up--;
    }
    if($red=="on"){
        $Ed = __('messages.Ed');
        if($purp == "main"){$indiv = "tin$M5"; $fromdiv = "trcm$M5";}
        if($purp == "def"){$indiv = "din$M5"; $fromdiv = "drcm$M5";}
        echo "<br /><div id=\"rbc00$M5\" ><a onclick=mem_arguem('rbc0$M5','rbc00$M5')><b>$Ed?</b></a></div>
        <div id=\"rbc0$M5\" class=\"un-display\">
            <textarea id=\"$fromdiv\" rows=3 style=\"width: 250px;\"
             onFocus=clearsq('$fromdiv','rbc$M5');>$M11</textarea>
            <div id=\"rbc$M5\" style=\"display: none;\">
                <table><tr><td class=\"fcomblue intop wide-button\">
                    <a onclick=\"commm_red('$idrec','$fromdiv','$indiv','$purp')\">$Ed</a>
                </td></tr></table>
            </div>
        </div><br />";
    }
}




@endphp



