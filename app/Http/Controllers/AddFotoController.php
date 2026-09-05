<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use File;

class AddFotoController extends Controller
{
    //         $_mktmy = microtime(true);
// echo"<br /> "; $_mktmy2 = microtime(true); echo round($_mktmy2 - $_mktmy,2);


    public function max_alb(Request $request)
    {

        $id = $request['id'];
        $purp = $request['purp'];
        $domen = $request['domen'];
        $lan = __('messages.lan');
        $id = $id + 1;
        $id = $id - 1;
        if (is_int($id) != "true") {
            die("");
        }


        $admpass="off"; $aheight = 200; $my_id="";
        if(Auth::user()) {
            $my_id = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if ($Alladn > 0) {
                $admpass = "ok"; $aheight = 230;
            }
        }


        $Allb = DB::table('Foto')->select('Namef','Formf','album','Face','Fd')->
        where('id', $id)->get();
        $Allbn = $Allb->count();



        if($Allbn>0){
            if($Allbn>5) {
                $a_sort = __('messages.a_sort');
                $d_sort = __('messages.d_sort');
                $c_sort = __('messages.c_sort');
                if($purp=="alf"){
                    $alfd = "<table style=\"display: inline-block; margin: 0 auto;\"><tr><td width=400 height=23 class=fcom valign=center align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                    <b>$a_sort</b>
                    </td></tr></table>";
                }
                else{
                    $alfd = "<table style=\"display: inline-block; margin: 0 auto;\">
                                <tr><td class=\"fcomblue\" width=400>
                                        <ul class=\"intop\"><li><a onclick=all_alb('$id','alf','$domen')> $a_sort</a></li></ul>
                                    </td></tr>
                            </table>";
                }
                if($purp=="date"){
                    $dated = "<table style=\"display: inline-block; margin: 0 auto;\"><tr><td width=400 height=23 class=fcom valign=center align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                        <b>$d_sort</b>
                    </td></tr></table>";
                }
                else{
                    $dated = "<table style=\"display: inline-block; margin: 0 auto;\">
                                <tr><td class=\"fcomblue\" width=400>
                                        <ul class=\"intop\"><li><a onclick=all_alb('$id','date','$domen')> $d_sort</a></li></ul>
                                    </td></tr>
                            </table>";
                }
                if($purp=="kol"){
                    $kold = "<table style=\"display: inline-block; margin: 0 auto;\"><tr><td width=400 height=23 class=fcom valign=center align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                        <b>$c_sort</b>
                    </td></tr></table>";
                    }
                else{$kold = "<table style=\"display: inline-block; margin: 0 auto;\">
                                <tr><td class=\"fcomblue\" width=400>
                                        <ul class=\"intop\"><li><a onclick=all_alb('$id','kol','$domen')> $c_sort</a></li></ul>
                                    </td></tr>
                            </table>";
                }
                echo "<table style=\"display: inline-block; margin: 0 auto;\"><tr><td align='center'>
                        <div class=\"layermaxwideadm\"  style=\"max-width: 1077px; overflow: hidden; text-align: center;\">
                            <div class=layerfoto>
                                $alfd
                            </div>
                            <div class=layerfoto>
                                $dated
                            </div>
                            <div class=layerfoto>
                                $kold
                            </div>
                        </div>
                    </td></tr></table>
                    ";
            }

            $all_f = array('Namef','Formf','album','Face','Fd');

            $all_n=0;
            foreach ($Allb as $All) {

                $Namef = $All->Namef; $Formf = $All->Formf; $albumm = $All->album; $Face = $All->Face; $Fd = $All->Fd;
                $all_f['Namef'][$all_n]=$Namef;
                $all_f['Formf'][$all_n]=$Formf;
                $all_f['album'][$all_n]=$albumm;
                $all_f['Face'][$all_n]=$Face;
                $all_f['Fd'][$all_n]=$Fd;
                $all_f['n'][$all_n]=$all_n;
                $all_n++;
            }
            if($purp=="date") {
                array_multisort($all_f['album'], SORT_ASC,
                    $all_f['Fd'], SORT_ASC,
                    $all_f['Face'], $all_f['Namef'], $all_f['Formf']);
            }
            else{
                array_multisort($all_f['album'], SORT_ASC,
                    $all_f['Face'], SORT_ASC,
                    $all_f['Fd'], SORT_ASC,
                    $all_f['Namef'], $all_f['Formf']);
            }

                $all_f2 = array('Namef','Formf','album','Face','Fd','n');
                $all_fa = array('n','album','nf','Fd');

                $all_a=0; $albumh=""; $nf=1; $all_a_old = "";
                $nf_old = ""; $all_n2_old = ""; $albumm_old = ""; $Fdm_old = "";

                for($all_n2=0; $all_n2<$all_n; $all_n2++){

                      $all_f2['Namef'][$all_n2]=$all_f['Namef'][$all_n2];
                      $all_f2['Formf'][$all_n2]=$all_f['Formf'][$all_n2];
                      $all_f2['album'][$all_n2]=$all_f['album'][$all_n2];
                      $all_f2['Face'][$all_n2] =$all_f['Face'][$all_n2];
                      $all_f2['Fd'][$all_n2] = $all_f['Fd'][$all_n2];
                      $all_f2['n'][$all_n2] = $all_n2;
                      $albumm=$all_f['album'][$all_n2]; $albumm="*&^%$#$albumm*&^%$#";
                      $Fdm=$all_f['Fd'][$all_n2];
                      if (mb_strstr("$albumh","$albumm")==""){$nf_old2 = (int)$nf_old+1;
                          $all_fa['nf'][$all_a_old]=$nf_old2;
                          $all_fa['n'][$all_a_old]=$all_n2_old;
                          $all_fa['album'][$all_a_old]=$albumm_old;
                          $all_fa['Fd'][$all_a_old]=$Fdm_old;
                          $all_a_old=$all_a;
                          $albumh.=" $albumm";
                          $all_a++; $nf=0;

                      }
                        $nf_old = $nf; $all_n2_old = $all_n2; $albumm_old = $albumm; $Fdm_old = $Fdm;
                      $nf++;
                }
                $nf_old2 = (int)$nf_old+1;
                $all_fa['nf'][$all_a_old]=$nf_old2;
                $all_fa['n'][$all_a_old]=$all_n2_old;
                $all_fa['album'][$all_a_old]=$albumm_old;
                $all_fa['Fd'][$all_a_old]=$Fdm_old;

                $all_a=$all_a-1; $all_af=$all_a;

            if($purp=="kol") {
                array_multisort($all_fa['nf'], SORT_DESC, $all_fa['album'], $all_fa['Fd'], $all_fa['n']);
            }
            if($purp=="date") {
                array_multisort($all_fa['Fd'], SORT_DESC, $all_fa['album'], $all_fa['nf'], $all_fa['n']);
            }
            if($purp=="alf") {
                array_multisort($all_fa['album'], SORT_ASC, $all_fa['nf'], $all_fa['Fd'], $all_fa['n']);
            }
            echo "<table style=\"display: inline-block; margin: 0 auto;\"><tr><td align='center'>";

        $aun=1;
        $updated = __('messages.updated');
        $see_min = __('messages.see_min');
        $comments = __('messages.Comment');

        for($au=0; $au<=$all_a; $au++) {

			 $nalbum=$all_fa['n'][$au]; $nf=$all_fa['nf'][$au];
			 $Namef=$all_f2['Namef'][$nalbum]; $Formf=$all_f2['Formf'][$nalbum];
			 $Fd=$all_f2['Fd'][$nalbum]; $t_u=$all_f2['album'][$nalbum];
			$M6_e= db_date($Fd);

			$max_dn = "$updated<br /> $M6_e";

			$monm = substr($Fd, 5, 2); $yem = substr($Fd, 0, 4);
			if ($monm<10){$monmf = substr($Fd, 6, 1);}
			else{$monmf=$monm;}
			  $katalogs = "Photos/$yem$monmf/s$Namef.$Formf";
			  $katalog = "Photos/$yem$monmf/$Namef.$Formf";
			$katalogface = getKatalogs($katalogs, $katalog);

            $album_l = str_ireplace("/", "@s@l@", $t_u);
            $album_l = str_ireplace("?", "@q@w@", $album_l);
            if(mb_strlen($t_u)>35){$t_u = mb_substr($t_u, 0, 35); $t_u.= "...";}

			if ($aun == 1){
			    echo "<div class=\"layermaxwideadm\"  style=\"max-width: 1085px; overflow: hidden; text-align: center;\">";}
			if ($aun == 1 || $aun == 3 || $aun == 5) {
			    echo "<div class=layerfoto style=\"max-height: 400px; overflow: hidden; \"><table><tr height=$aheight>";}

            $t1="qwertyuiopasdfghjklzxcvbnm"; $t3="";
            for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}

            echo"
			<td width=175 class=fcom valign=top align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
				<div id=\"$t3\" style=\"max-width: 170px; \">

					<div style=\"max-width: 170px; margin: 8px 8px 8px 8px; \">
					<b><a href=\"/$domen/foto/$lan/$album_l\">$t_u</a> ($nf)</b>
					</div>
					<div style=\"max-width: 170px; margin: 8px 8px 8px 8px; \">
						<table><tr><td class=fcom valign=center>
							<div style=\"max-height: 70px; max-width: 100px; overflow: hidden; \">
								<a href=\"/$domen/foto/$lan/$album_l\"><img border=0 width=100 SRC=\"$katalogface\"></a>
							</div>
						</td></tr></table>
						<div style=\"max-width: 170px; margin: 8px 0px 8px 0px; \">
                        $max_dn<br />
						<a href=## onclick=\"all_ac($Namef , 1)\";>$see_min </a><br />
						<a href=## onclick=\"comment_c('$id', '$Namef', '1')\";>$comments... </a><br />";

						if($admpass=="ok" || $my_id == "72372396"){
                            $Delete = __('messages.Delete');
                            $Ed = __('messages.Ed');
                            $yesd = __('messages.yesd');
                            $no = __('messages.no');
                            $fdelshure = __('messages.fdelshure');
						$dalb = "adel_alb$Namef";
						echo"<DIV id=\"del_alb0$Namef\"> <a onclick=red_alb('$Namef','del_alb0$Namef','$t3')> $Ed</a>
						 <a onclick=$dalb.style.display='block';> $Delete </a></DIV>

						<table><tr><td width=155>
						<DIV id=\"$dalb\" style=\"display: none;\">
						$fdelshure <br />
						<b><a onclick=del_alb('$Namef','$t3')>$yesd</a>
						 <a onclick=$dalb.style.display='none';>$no</a></b> </DIV></b></td></tr></table>";
						}
               echo"</div></div>
				</div>
			</td>";


             if ($aun == 2 || $aun == 4 || $aun == 6) {echo "</tr></table></div>";}
			 if ($aun == 6) {echo "</div>";}
                   $aun++;

                    if ($aun == 7) {
                        $aun = 1;
                    }
            }
            if($aun==2){echo"<td width=175></td></tr></table></div><div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div><div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div>";}
            if($aun==3){echo"<div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div><div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div>";}
            if($aun==4){echo"<td width=175></td></tr></table></div><div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div>";}
            if($aun==5){echo"<div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div>";}
            if($aun==6){echo"<td width=175></td></tr></table></div>";}
            echo"</div>";

            }

			else {
                $no_alb = __('messages.no_alb');

                echo"<table><tr><td width=400 height=23 class=fcom valign=center align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                    <b>$no_alb</b>
                    </td></tr></table>";
			}

            echo"</td></tr></table>";
        // echo"<br />  $purp "; $_mktmy2 = microtime(true); echo round($_mktmy2 - $_mktmy,2);

    }







    public function max_albp(Request $request)
    {

        $id = $request['id'];
        $purp = $request['purp'];
        $domen = $request['domen'];
        $lan = __('messages.lan');
        $id = $id + 1;
        $id = $id - 1;
        if (is_int($id) != "true") {
            die("");
        }

        $admpass="off";
        $aheight = 200;
        $my_id="";
        if (Auth::user()){
            $Num = $id;
            $Alls = DB::table('Friends')->select('Num1', 'Num2')->
            where(function($query1) use ($Num) {
                $query1->where('Num1', $Num)
                    ->where('Argue', '=', 2);
            })->
            orWhere(function($query2) use ($Num) {
                $query2->where('Num2', $Num)
                    ->where('Argue', '=', 2);
            })->
            get();
            $fr_avt="";  $Numfr = "";
            foreach ($Alls as $All) { $Num1=$All->Num1; $Num2=$All->Num2;
                if($Num1==$Num){$Numfr=$Num2;} else{$Numfr=$Num1; }
                $fr_avt.= " $Numfr";  }
            $my_id = Auth::user()->id; $my_id2 = "$my_id";
            $isfriend = strstr("$fr_avt", "$my_id2");
        } else {$isfriend = ""; $my_id = "999999999999999";}

        if($my_id==$id){$v_s=4;  $aheight = 245; $admpass="ok";}
        else{
            if($my_id == "999999999999999"){$v_s=1;}
            else if($my_id>0){$v_s=2;
                if($isfriend!=""){$v_s=3;}
            }
        }

        $Allb = DB::table('Fotop')->select('Namef','Formf','album','Face','Fd','Sh')->
        where('Num', $id)->
        where('Sh', '<=', $v_s)->
        get();
        $Allbn = $Allb->count();


        if($Allbn>0){
            if($Allbn>5) {
                $a_sort = __('messages.a_sort');
                $d_sort = __('messages.d_sort');
                $c_sort = __('messages.c_sort');
                if($purp=="alf"){
                    $alfd = "<table style=\"display: inline-block; margin: 0 auto;\"><tr><td width=400 height=23 class=fcom valign=center align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                    <b>$a_sort</b>
                    </td></tr></table>";
                }
                else{
                    $alfd = "<table style=\"display: inline-block; margin: 0 auto;\">
                                <tr><td class=\"fcomblue\" width=400>
                                        <ul class=\"intop\"><li><a onclick=max_albp('$id','alf','$domen')> $a_sort</a></li></ul>
                                    </td></tr>
                            </table>";
                }
                if($purp=="date"){
                    $dated = "<table style=\"display: inline-block; margin: 0 auto;\"><tr><td width=400 height=23 class=fcom valign=center align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                        <b>$d_sort</b>
                    </td></tr></table>";
                }
                else{
                    $dated = "<table style=\"display: inline-block; margin: 0 auto;\">
                                <tr><td class=\"fcomblue\" width=400>
                                        <ul class=\"intop\"><li><a onclick=max_albp('$id','date','$domen')> $d_sort</a></li></ul>
                                    </td></tr>
                            </table style=\"display: inline-block; margin: 0 auto;\">";
                }
                if($purp=="kol"){
                    $kold = "<table style=\"display: inline-block; margin: 0 auto;\"><tr><td width=400 height=23 class=fcom valign=center align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                        <b>$c_sort</b>
                    </td></tr></table>";
                }
                else{$kold = "<table style=\"display: inline-block; margin: 0 auto;\">
                                <tr><td class=\"fcomblue\" width=400>
                                        <ul class=\"intop\"><li><a onclick=max_albp('$id','kol','$domen')> $c_sort</a></li></ul>
                                    </td></tr>
                            </table>";
                }
                echo "<table style=\"display: inline-block; margin: 0 auto;\"><tr><td align='center' >
                        <div class=\"layermaxwideadm\"  style=\"margin: 0 auto; max-width: 1077px; overflow: hidden; text-align: center;\">
                            <div class=layerfoto>
                                $alfd
                            </div>
                            <div class=layerfoto>
                                $dated
                            </div>
                            <div class=layerfoto>
                                $kold
                            </div>
                        </div>
                    </td></tr></table>
                    ";
            }
            $all_f = array('Namef','Formf','album','Face','Fd','Fd','Sh');

            $all_n=0;
            foreach ($Allb as $All) {

                $Namef = $All->Namef; $Formf = $All->Formf; $albumm = $All->album; $Face = $All->Face; $Fd = $All->Fd; $Sh = $All->Sh;
                $all_f['Namef'][$all_n]=$Namef;
                $all_f['Formf'][$all_n]=$Formf;
                $all_f['album'][$all_n]=$albumm;
                $all_f['Face'][$all_n]=$Face;
                $all_f['Fd'][$all_n]=$Fd;
                $all_f['Sh'][$all_n]=$Sh;
                $all_f['n'][$all_n]=$all_n;
                $all_n++;
            }
            if($purp=="date") {
                array_multisort($all_f['album'], SORT_ASC,
                    $all_f['Fd'], SORT_ASC,
                    $all_f['Face'], $all_f['Namef'], $all_f['Formf'], $all_f['Sh']);
            }
            else{
                array_multisort($all_f['album'], SORT_ASC,
                    $all_f['Face'], SORT_ASC,
                    $all_f['Fd'], SORT_ASC,
                    $all_f['Namef'], $all_f['Formf'], $all_f['Sh']);
            }
            $all_f2 = array('Namef','Formf','album','Face','Fd','Sh','n');
            $all_fa = array('n','album','nf','Fd','Sh');

            $all_a=0; $albumh=""; $nf=1; $all_a_old = "";
            $nf_old = ""; $all_n2_old = ""; $albumm_old = ""; $Fdm_old = "";  $Shm_old = "";

            for($all_n2=0; $all_n2<$all_n; $all_n2++){

                $all_f2['Namef'][$all_n2]=$all_f['Namef'][$all_n2];
                $all_f2['Formf'][$all_n2]=$all_f['Formf'][$all_n2];
                $all_f2['album'][$all_n2]=$all_f['album'][$all_n2];
                $all_f2['Face'][$all_n2] =$all_f['Face'][$all_n2];
                $all_f2['Fd'][$all_n2] = $all_f['Fd'][$all_n2];
                $all_f2['Sh'][$all_n2] = $all_f['Sh'][$all_n2];
                $all_f2['n'][$all_n2] = $all_n2;
                $albumm=$all_f['album'][$all_n2]; $albumm="*&^%$#$albumm*&^%$#";
                $Fdm=$all_f['Fd'][$all_n2];
                $Shm=$all_f['Sh'][$all_n2];
                if (mb_strstr("$albumh","$albumm")==""){$nf_old2 = (int)$nf_old+1;
                    $all_fa['nf'][$all_a_old]=$nf_old2;
                    $all_fa['n'][$all_a_old]=$all_n2_old;
                    $all_fa['album'][$all_a_old]=$albumm_old;
                    $all_fa['Fd'][$all_a_old]=$Fdm_old;
                    $all_fa['Sh'][$all_a_old]=$Shm_old;
                    $all_a_old=$all_a;
                    $albumh.=" $albumm";
                    $all_a++; $nf=0;

                }
                $nf_old = $nf; $all_n2_old = $all_n2; $albumm_old = $albumm; $Fdm_old = $Fdm; $Shm_old = $Shm;
                $nf++;
            }
            $nf_old2 = (int)$nf_old+1;
            $all_fa['nf'][$all_a_old]=$nf_old2;
            $all_fa['n'][$all_a_old]=$all_n2_old;
            $all_fa['album'][$all_a_old]=$albumm_old;
            $all_fa['Fd'][$all_a_old]=$Fdm_old;
            $all_fa['Sh'][$all_a_old]=$Shm_old;

            $all_a=$all_a-1; $all_af=$all_a;

            if($purp=="kol") {
                array_multisort($all_fa['nf'], SORT_DESC, $all_fa['album'], $all_fa['Fd'], $all_fa['n'], $all_fa['Sh']);
            }
            if($purp=="date") {
                array_multisort($all_fa['Fd'], SORT_DESC, $all_fa['album'], $all_fa['nf'], $all_fa['n'], $all_fa['Sh']);
            }
            if($purp=="alf") {
                array_multisort($all_fa['album'], SORT_ASC, $all_fa['nf'], $all_fa['Fd'], $all_fa['n'], $all_fa['Sh']);
            }
            echo "<table style=\"display: inline-block; margin: 0 auto;\"><tr><td align='center'>";

            $aun=1;
            $updated = __('messages.updated');
            $see_min = __('messages.see_min');
            $comments = __('messages.Comment');

            for($au=0; $au<=$all_a; $au++) {

                $nalbum=$all_fa['n'][$au]; $nf=$all_fa['nf'][$au];
                $Namef=$all_f2['Namef'][$nalbum]; $Formf=$all_f2['Formf'][$nalbum];
                $Fd=$all_f2['Fd'][$nalbum]; $t_u=$all_f2['album'][$nalbum]; $Sh=$all_f2['Sh'][$nalbum];
                $M6_e= db_date($Fd);

                $max_dn = "$updated<br /> $M6_e";

                $monm = substr($Fd, 5, 2); $yem = substr($Fd, 0, 4);
                if ($monm<10){$monmf = substr($Fd, 6, 1);}
                else{$monmf=$monm;}
                $katalog = "Fotop/$yem$monmf/s$Namef.$Formf";
                $katalogb = "Fotop/$yem$monmf/$Namef.$Formf";

                if (Storage::disk('public')->exists($katalog)) {
                    $katalogface=Storage::disk('public')->url($katalog);
                }
                else if (Storage::disk('public')->exists($katalogb)) {
                    $katalogface=Storage::disk('public')->url($katalogb);
                }
                else{$katalogface="/alb.jpg";}


                $album_l = str_ireplace("/", "@s@l@", $t_u);
                $album_l = str_ireplace("?", "@q@w@", $album_l);
                if(mb_strlen($t_u)>35){$t_u = mb_substr($t_u, 0, 35); $t_u.= "...";}

                if ($aun == 1){
                    echo "<div class=\"layermaxwideadm\"  style=\"max-width: 1085px; overflow: hidden; text-align: center;\">";}
                if ($aun == 1 || $aun == 3 || $aun == 5) {
                    echo "<div class=layerfoto style=\"max-height: 420px; overflow: hidden; \"><table><tr height=$aheight>";}

                $t1="qwertyuiopasdfghjklzxcvbnm"; $t3="";
                for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}
                echo"
			<td width=175 class=fcom valign=top align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
				<div id=\"$t3\" style=\"max-width: 170px; \">

					<div style=\"max-width: 170px; margin: 8px 8px 8px 8px; \">
					<b><a href=\"/$domen/foto/$lan/$album_l\">$t_u</a> ($nf)</b>
					</div>
					<div style=\"max-width: 170px; margin: 8px 8px 8px 8px; \">
						<table><tr><td class=fcom valign=center>
							<div style=\"max-height: 70px; max-width: 100px; overflow: hidden; \">
								<a href=\"/$domen/foto/$lan/$album_l\"><img border=0 width=100 SRC=\"$katalogface\">
							</div>
						</td></tr></table>
						<div style=\"max-width: 170px; margin: 8px 0px 8px 0px; \">
                        $max_dn<br />
						<a href=## onclick=\"all_ap($Namef, 1)\";>$see_min </a><br />
						<a href=## onclick=\"comment_p('$id','$Namef','1')\";>$comments... </a><br />";

                if($admpass=="ok" || $my_id == "72372396"){
                    $Delete = __('messages.Delete');
                    $Ed = __('messages.Ed');
                    $yesd = __('messages.yesd');
                    $no = __('messages.no');
                    $fdelshure = __('messages.fdelshure');
                    $dalb = "adel_alb$Namef";
                    $swown = __('messages.swown');
                    if($Sh==1){$Pr_show1 = __('messages.Pr_show1'); $swown = "$swown: $Pr_show1";}
                    if($Sh==2){$Pr_show2 = __('messages.Pr_show2'); $swown = "$swown: $Pr_show2";}
                    if($Sh==3){$Pr_show3 = __('messages.Pr_show3'); $swown = "$swown: $Pr_show3";}
                    if($Sh==4){$Pr_show4 = __('messages.Pr_show4'); $swown = "$swown: $Pr_show4";}
                    echo"$swown<br /><DIV id=\"del_alb0$Namef\"> <a onclick=red_albp('$Namef','del_alb0$Namef','$t3')> $Ed</a>
						 <a onclick=$dalb.style.display='block';> $Delete </a></DIV>

						<table><tr><td width=155>
						<DIV id=\"$dalb\" style=\"display: none;\">
						$fdelshure <br />
						<b><a onclick=del_albp('$Namef','$t3')>$yesd</a>
						 <a onclick=$dalb.style.display='none';>$no</a></b> </DIV></td></tr></table>";
                }
                echo"</div></div>
				</div>
			</td>";


                if ($aun == 2 || $aun == 4 || $aun == 6) {echo "</tr></table></div>";}
                if ($aun == 6) {echo "</div>";}
                $aun++;

                if ($aun == 7) {
                    $aun = 1;
                }
            }
            if($aun==2){echo"<td width=175></td></tr></table></div><div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div><div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div>";}
            if($aun==3){echo"<div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div><div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div>";}
            if($aun==4){echo"<td width=175></td></tr></table></div><div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div>";}
            if($aun==5){echo"<div class=\"layerfoto\"><table><tr valign=top><td width=175></td><td width=175></td></tr></table></div>";}
            if($aun==6){echo"<td width=175></td></tr></table></div>";}
            echo"</div>";


        }

        else {
            $no_alb = __('messages.no_alb');
            echo"<table><tr><td width=400 height=23 class=fcom valign=center align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                    <b>$no_alb</b>
                    </td></tr></table>";
        }
        echo"</td></tr></table>";


    }





    public function red_alb(Request $request)
    {
        $Namef = $request['Namef'];
        $t3 = $request['t3'];
        $r_f0 = "del_alb0$Namef";
        $Namef=$Namef+1; $Namef=$Namef-1;
        if(is_int($Namef)!="true"){die("");}

        $Allb = DB::table('Foto')->select('album','id')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {$album = $All->album; $id = $All->id;}

        $admpass="off";
        if(Auth::user()) {
            $my_id = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if ($Alladn > 0) {
                $admpass = "ok";
            }
        }

        if($admpass=="ok"){

            $Allb = DB::table('Foto')->select('album')->
            where('id', $id)->
            groupBy('album')->
            orderBy('album', 'asc')->
            get();

            $Album = __('messages.Album');
            $Move = __('messages.Move');
            $edit = __('messages.edit2');

            echo"<br>
                $Album: <INPUT TYPE=text name=\"albt$t3\" id=\"albt$t3\" SIZE=20 maxlength=45 value=\"$album\"><br />
                $Move: <SELECT name=\"albs$t3\" id=\"albs$t3\">";
            foreach ($Allb as $All) {$album2 = $All->album; $album3 = $album2;
                if(mb_strlen($album2)>18){$album3 = mb_substr($album2, 0, 18); $album3.= "...";}
                echo"<OPTION value=\"$album2\""; if ($album==$album2){echo" selected";} echo"> $album3</OPTION>";
            }
            echo"</SELECT>";

            echo"<table>
                <tr><td class=\"fcomblue\" width=100>
                     <ul class=\"intop\"><li><a onclick=do_red_alb('$Namef','$t3','albt$t3','albs$t3')> $edit</a></li></ul>
                    </td></tr>
                 </table>";
        }
    }




    public function do_red_alb(Request $request)
    {

        $Namef = $request['Namef'];
        $albt = $request['albt'];
        $albs = $request['albs'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }
        $albt = strip_tags($albt);
        $albs = strip_tags($albs);
        $ctrl_hss= $albt;
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
						$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        $ctrl_hss= mb_strtolower($albs);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
						$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}

        $Allb = DB::table('Foto')->select('album','id')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {$album = $All->album; $id = $All->id;}

        $Allc = DB::table('Allcities')->select('domen')->
        where('id', $id)->limit(1)->get();
        foreach ($Allc as $All) {$domen = $All->domen;}

        $admpass="off";
        if(Auth::user()) {
            $my_id = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if ($Alladn > 0) {
                $admpass = "ok";
            }
        }

        if($admpass=="ok"){

            $alb_move = __('messages.alb_move');
            $alb_rename = __('messages.alb_rename');
            $lan = __('messages.lan');
            if($albt!=$album&&$albt!=""){$albc=$albt; $ch_e="$alb_rename:<br>";}
            else{$albc=$albs; $ch_e="$alb_move:<br>";}

            $affected = DB::table('Foto')
                ->where('id', $id)
                ->where('album', $album)
                ->update(['album' => $albc]);

            $affected2 = DB::table('Memoryf')
                ->where('id', $id)
                ->where('album', $album)
                ->update(['album' => $albc]);

            if ($affected) { echo"<div style=\"max-width: 160px; margin: 8px 8px 8px 8px; \">
                <br /><br /> $ch_e <b><a href=\"/$domen/foto/$lan/$albc\">$albc</a></b> </div><br /><br />";}

        }

    }






    public function red_albp(Request $request)
    {
        $Namef = $request['Namef'];
        $t3 = $request['t3'];
        $Namef=$Namef+1; $Namef=$Namef-1;
        if(is_int($Namef)!="true"){die("");}

        $Allb = DB::table('Fotop')->select('album','Num','Sh')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {$album = $All->album; $id = $All->Num; $Sh = $All->Sh;}

        $admpass="off";
        if(Auth::user()) {
            $my_id = Auth::user()->Num;
            if ($my_id == $id) {
                $admpass = "ok";
            }
        }

            if($admpass=="ok"){

                $Allb = DB::table('Fotop')->select('album')->
                where('Num', $id)->
                groupBy('album')->
                orderBy('album', 'asc')->
                get();

                $Album = __('messages.Album');
                $Move = __('messages.Move');
                $edit = __('messages.edit2');
                $swown = __('messages.swown');
                $Pr_show1 = __('messages.Pr_show1');
                $Pr_show2 = __('messages.Pr_show2');
                $Pr_show3 = __('messages.Pr_show3');
                $Pr_show4 = __('messages.Pr_show4');
                echo"<br>
                    $Album: <INPUT TYPE=text name=\"albt$t3\" id=\"albt$t3\" SIZE=20 maxlength=45 value=\"$album\"><br />
                    $Move: <SELECT name=\"albs$t3\" id=\"albs$t3\">";
                foreach ($Allb as $All) {$album2 = $All->album; $album3 = $album2;
                    if(mb_strlen($album2)>18){$album3 = mb_substr($album2, 0, 18); $album3.= "...";}
                    echo"<OPTION value=\"$album2\""; if ($album==$album2){echo" selected";} echo"> $album3</OPTION>";
                }
                $swown1 = ""; if($Sh==1){ $swown1 = "selected";}
                $swown2 = ""; if($Sh==2){ $swown2 = "selected";}
                $swown3 = ""; if($Sh==3){ $swown3 = "selected";}
                $swown4 = ""; if($Sh==4){ $swown4 = "selected";}
                echo"</SELECT>
                <br>$swown:
                <SELECT name=\"sh$t3\" id=\"sh$t3\">
                <OPTION value=1 $swown1>$Pr_show1</OPTION>
                <OPTION value=2 $swown2>$Pr_show2</OPTION>
                <OPTION value=3 $swown3>$Pr_show3</OPTION>
                <OPTION value=4 $swown4>$Pr_show4</OPTION>
                </SELECT>

                <table>
                <tr><td class=\"fcomblue\" width=100>
                     <ul class=\"intop\"><li><a onclick=do_red_albp('$Namef','$t3','albt$t3','albs$t3','sh$t3')> $edit</a></li></ul>
                    </td></tr>
                 </table>";
            }

    }





    public function do_red_albp(Request $request)
    {

        $Namef = $request['Namef'];
        $albt = $request['albt'];
        $albs = $request['albs'];
        $Sh = $request['shs'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }
        $albt = strip_tags($albt);
        $albs = strip_tags($albs);
        $ctrl_hss= $albt;
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
						$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        $ctrl_hss= mb_strtolower($albs);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
						$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
        $Allb = DB::table('Fotop')->select('album','Num')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {$album = $All->album; $id = $All->Num;}



        $admpass="off";
        if(Auth::user()) {
            $domen = Auth::user()->domen;
            $my_id = Auth::user()->Num;

            if ($my_id == $id) {
                $admpass = "ok";
            }
        }

        if($admpass=="ok"){

            $alb_move = __('messages.albp_move');
            $alb_rename = __('messages.albp_rename');
            $lan = __('messages.lan');
            if($albt!=$album&&$albt!=""){$albc=$albt; $ch_e="$alb_rename:<br>";}
            else{$albc=$albs; $ch_e="$alb_move:<br>";}

            $affected = DB::table('Fotop')
                ->where('Num', $id)
                ->where('album', $album)
                ->update(['album' => $albc,'Sh' => $Sh]);

            DB::table('Memoryfp')
                ->where('Nump', $id)
                ->where('album', $album)
                ->update(['album' => $albc,'Sh' => $Sh]);

            if ($affected) { echo"<div style=\"max-width: 160px; margin: 8px 0px 8px 0px; \">
                <br /><br /> $ch_e <b><a href=\"/$domen/foto/$lan/$albc\">$albc</a></b> </div><br /><br />";}

        }

    }








    public function all_ac(Request $request)
    {
        $Namef = $request['Namef'];
        $page = $request['page'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }
        $Namefgo = $Namef;
        $pagego = $page+1;
        if($page==1) {$skip=0;}
        else{$skip = ($page-1)*90;}

        $Allb = DB::table('Foto')->select('album','id')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {$album = $All->album; $id = $All->id;}

        $Allb = DB::table('Foto')->select('Namef', 'Fd', 'Formf')->
        where('id', $id)->
        where('album', $album)->
        orderBy('Fd', 'desc')->
        skip($skip)->take(91)->
        get();
        $Allbn = $Allb->count();
        if($Allbn==91){$next_e = __('messages.nnext');}
        else {$next_e = "";}
        if($Allbn>0){

        if($page==1){echo"<br /><div class=\"layermaxwideadm\" align = center><b>$album</b></div>";}
        echo"<div align = center>";}


        $aun = 1; $a=1;
        foreach ($Allb as $Alb) {
            if($a<91){
                $Namef = $Alb->Namef; $Fd = $Alb->Fd; $Formf = $Alb->Formf;

                if ($aun == 1){
                    echo "<div class=\"layermaxwideadm\" align = center>";
                }

                    if ($aun == 1 || $aun == 4 || $aun == 7) {
                        echo "<div class=layerfoto align = center style=\"height: 70px; overflow: hidden; \">
                            <table><tr height=70>";
                    }

                    echo"
                    <td width=100 class=fcom valign=top align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">";

                    $monm = substr($Fd, 5, 2); $yem = substr($Fd, 0, 4);
                    if ($monm<10){$monmf = substr($Fd, 6, 1);}
                    else{$monmf=$monm;}
                    if($yem<=2007){$yem = "2005-2007"; $monmf="";}

                    $katalogs = "Photos/$yem$monmf/s$Namef.$Formf";
                    $katalog = "Photos/$yem$monmf/$Namef.$Formf";
					$katalogface = getKatalogs($katalogs, $katalog);

                    echo"<a onclick=abf('$id','$Namef')>
                            <div style=\"height: 70px; overflow: hidden\">
                                <img border=0 width=100 src=$katalogface>
                            </div>
                        </a>";

                    echo"</td>";

                    if ($aun == 3 || $aun == 6 || $aun == 9) {echo "</tr></table></div>";}
                if ($aun == 9) {echo "</div>";}
                    $aun++;

                    if ($aun == 10) {
                        $aun = 1;
                    }

            }
            $a++;
        }


        if ($aun == 2 || $aun == 5 || $aun == 8) {
            echo "<td width=100><img border=0 width=100 src=></td>
            <td width=100><img border=0 width=100 src=></td>";
        }
        if ($aun == 3 || $aun == 6 || $aun == 9) {
            echo "<td width=100><img border=0 width=100 src=></td>";
        }

        if ($aun != 1 || $aun != 4 || $aun != 7) {echo "</tr></table>";}
        if ($aun == 2 || $aun == 3) {echo "</div><div class=layerfoto style=\" height: 60px;\"></div>
        <div class=layerfoto style=\"height: 60px;\"></div>";}
        if ($aun == 4) {echo "<div class=layerfoto style=\" height: 60px;\"></div>
        <div class=layerfoto style=\" height: 60px; \"></div>";}
        if ($aun == 5 || $aun == 6) {echo "</div><div class=layerfoto style=\"height: 60px;\"></div>";}
        if ($aun == 7) {echo "<div class=layerfoto style=\"height: 60px; \"></div>";}
        if ($aun == 8 || $aun == 9) {echo "</div>";}

        if ($aun !=  1 ) {echo "</div>";}


        if($Allbn>0){echo"</div>";}

        if($a==92) { $next_div = "next_div$pagego";
            echo "<div class=\"layermaxwideadm\" id=$next_div>
            <table width=100% style=\"cursor: pointer; \">
            <tr><td align=center height=50 class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\"
             onClick=\"all_ac($Namefgo,$pagego)\";><b>$next_e</b></td></tr>
             </table>
             </div>";
        }
    }






    public function all_ap(Request $request)
    {
        $Namef = $request['Namef'];
        $page = $request['page'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }
        $Namefgo = $Namef;
        $pagego = $page+1;
        if($page==1) {$skip=0;}
        else{$skip = ($page-1)*90;}



        $Allb = DB::table('Fotop')->select('album','Num')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {$album = $All->album; $id = $All->Num;}

        $admpass="off";
        if (Auth::user()){
            $Num = $id;
            $Alls = DB::table('Friends')->select('Num1', 'Num2')->
            where(function($query1) use ($Num) {
                $query1->where('Num1', $Num)
                    ->where('Argue', '=', 2);
            })->
            orWhere(function($query2) use ($Num) {
                $query2->where('Num2', $Num)
                    ->where('Argue', '=', 2);
            })->
            get();
            $fr_avt="";  $Numfr = "";
            foreach ($Alls as $All) { $Num1=$All->Num1; $Num2=$All->Num2;
                if($Num1==$Num){$Numfr=$Num2;} else{$Numfr=$Num1; }
                $fr_avt.= " $Numfr";  }
            $my_id = Auth::user()->id; $my_id2 = "$my_id";
            $isfriend = strstr("$fr_avt", "$my_id2");
        } else {$isfriend = ""; $my_id = "999999999999999";}

        if($my_id==$id){$v_s=4;  $aheight = 235; $admpass="ok";}
        else{
            if($my_id == "999999999999999"){$v_s=1;}
            else if($my_id>0){$v_s=2;
                if($isfriend!=""){$v_s=3;}
            }
        }



        $Allb = DB::table('Fotop')->select('Namef', 'Fd', 'Formf')->
        where('Num', $id)->
        where('album', $album)->
        where('Sh', '<=', $v_s)->
        orderBy('Fd', 'desc')->
        skip($skip)->take(91)->
        get();
        $Allbn = $Allb->count();
        if($Allbn==91){$next_e = __('messages.nnext');}
        else {$next_e = "";}
        if($Allbn>0){


            if($page==1){echo"<br /><div class=\"layermaxwideadm\" align = center><b>$album</b></div>";}
            echo"<div align = center>";}


        $aun = 1; $a=1;
        foreach ($Allb as $Alb) {
            if($a<91){
                $Namef = $Alb->Namef; $Fd = $Alb->Fd; $Formf = $Alb->Formf;

                if ($aun == 1){
                    echo "<div class=\"layermaxwideadm\" align = center>";
                }

                if ($aun == 1 || $aun == 4 || $aun == 7) {
                    echo "<div class=layerfoto align = center style=\"height: 70px; overflow: hidden; \">
                            <table><tr height=70>";
                }

                echo"
                    <td width=100 class=fcom valign=top align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">";

                $monm = substr($Fd, 5, 2); $yem = substr($Fd, 0, 4);
                if ($monm<10){$monmf = substr($Fd, 6, 1);}
                else{$monmf=$monm;}
                if($yem<=2007){$yem = "2005-2007"; $monmf="";}
                $katalog = "Fotop/$yem$monmf/s$Namef.$Formf";
                $katalogb = "Fotop/$yem$monmf/$Namef.$Formf";

                if (Storage::disk('public')->exists($katalog)) {
                    $katalogface=Storage::disk('public')->url($katalog);
                }
                else if (Storage::disk('public')->exists($katalogb)) {
                    $katalogface=Storage::disk('public')->url($katalogb);
                }
                else{$katalogface="/alb.jpg";}

                echo"<a onclick=abfp('$id','$Namef')>
                            <div style=\"height: 70px; overflow: hidden\">
                                <img border=0 width=100 src=$katalogface>
                            </div>
                        </a>";

                echo"</td>";

                if ($aun == 3 || $aun == 6 || $aun == 9) {echo "</tr></table></div>";}
                if ($aun == 9) {echo "</div>";}
                $aun++;

                if ($aun == 10) {
                    $aun = 1;
                }

            }
            $a++;
        }


        if ($aun == 2 || $aun == 5 || $aun == 8) {
            echo "<td width=100><img border=0 width=100 src=></td>
            <td width=100><img border=0 width=100 src=></td>";
        }
        if ($aun == 3 || $aun == 6 || $aun == 9) {
            echo "<td width=100><img border=0 width=100 src=></td>";
        }

        if ($aun != 1 || $aun != 4 || $aun != 7) {echo "</tr></table>";}
        if ($aun == 2 || $aun == 3) {echo "</div><div class=layerfoto style=\" height: 60px;\"></div>
        <div class=layerfoto style=\"height: 60px;\"></div>";}
        if ($aun == 4) {echo "<div class=layerfoto style=\" height: 60px;\"></div>
        <div class=layerfoto style=\" height: 60px; \"></div>";}
        if ($aun == 5 || $aun == 6) {echo "</div><div class=layerfoto style=\"height: 60px;\"></div>";}
        if ($aun == 7) {echo "<div class=layerfoto style=\"height: 60px; \"></div>";}
        if ($aun == 8 || $aun == 9) {echo "</div>";}

        if ($aun !=  1 ) {echo "</div>";}


        if($Allbn>0){echo"</div>";}

        if($a==92) { $next_div = "next_div$pagego";
            echo "<div class=\"layermaxwideadm\" id=$next_div>
            <table width=100% style=\"cursor: pointer; \">
            <tr><td align=center height=50 class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\"
             onClick=\"all_ap($Namefgo,$pagego)\";><b>$next_e</b></td></tr>
             </table>
             </div>";
        }
    }







    public function comment_c(Request $request)
    {
        $Namef = $request['Namef'];
        $page = $request['page'];
        $id = $request['id'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }
        $id = $id + 1;
        $id = $id - 1;
        if (is_int($id) != "true") {
            die("");
        }
        $Namefgo = $Namef;
        $pagego = $page+1;
        if($page==1) {$skip=0;}
        else{$skip = ($page-1)*20;}


        if($Namef>0){

            $Allb = DB::table('Foto')->select('album','id')->
            where('Namef', $Namef)->limit(1)->get();
            foreach ($Allb as $All) {$album = $All->album; $id = $All->id;}

            $Allb = DB::table('Memoryf')->select('Num', 'Aboutef', 'Md', 'avt', 'Fd', 'Formf')->
            where('id', $id)->
            where('album', $album)->
            orderBy('Md', 'desc')->
            skip($skip)->take(21)->
            get();

        }
        else{

            $Allb = DB::table('Memoryf')->select('Num', 'Aboutef', 'Md', 'avt', 'Fd', 'Formf')->
            where('id', $id)->
            orderBy('Md', 'desc')->
            skip($skip)->take(21)->
            get();

        }

        $Allbn = $Allb->count();



        if($Allbn==21){$next_e = __('messages.nnext');}
        else {$next_e = "";}


        if($page==1 && $Namef>0){
            echo"<br /><div align = center><b>$album</b></div>";
        }
        if($Allbn == 0){
            $no_comment = __('messages.no_comment');
            echo"<br /><div align = center><b>$no_comment</b></div><br />";
        }

        if($Allbn>0){

            echo"<div align = center>";

            $aun = 1;
            foreach ($Allb as $Alb) {

                if($aun<21){

                    $Namef = $Alb->Num; $Fd = $Alb->Fd; $Formf = $Alb->Formf;
                    $Aboutef = $Alb->Aboutef; $Md = $Alb->Md; $avt = $Alb->avt;


                        if ($aun == 1) {
                            echo "<table>";
                        }

                        echo"<tr height=70><td width=120 class=fcom valign=top align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">";

                        $monm = substr($Fd, 5, 2); $yem = substr($Fd, 0, 4);
                        if ($monm<10){$monmf = substr($Fd, 6, 1);}
                        else{$monmf=$monm;}
                        if($yem<=2007){$yem = "2005-2007"; $monmf="";}

                        $katalogs = "Photos/$yem$monmf/s$Namef.$Formf";
                        $katalog = "Photos/$yem$monmf/$Namef.$Formf";
						$katalogface = getKatalogs($katalogs, $katalog);

                        echo"<div style=\"margin: 8px 8px 8px 8px; \"><a onclick=abf('$id','$Namef')>
                                <div style=\"height: 70px; overflow: hidden\">
                                    <img border=0 width=100 src=$katalogface>
                                </div>
                            </a></div>";
                    $M6_e= db_date($Md);
                    if (Auth::user()){$Numm = Auth::user()->id;}
                    else{$Numm=1;}

                    $qavt = avt($avt,$Numm);
                    $n_Aboutef = mb_strlen($Aboutef);
                        echo"</td><td width='280' class=fcom valign=top align=left onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                           <div style=\" margin: 6px 8px 8px 8px; width: 250px; overflow: hidden;\">";
                            if($n_Aboutef>70){
                                echo"<table><tr><td>$qavt $Aboutef  </td></tr>
                                <tr><td align='right'><span style='color: grey'> $M6_e </span></td></tr>";
                            }
                            else{
                                echo"<table><tr valign='top'><td>$qavt </td><td align='left' width='280'>
                                        <table>
                                            <tr><td width='280'>$Aboutef  </td></tr>
                                            <tr><td align='right'><span style='color: grey'> $M6_e </span></td></tr>
                                        </table>
                                </td></tr>";
                            }
                            echo"</table>
                            </div></td></tr>";
                }

               $aun++;
            }

            if($Allbn>0){echo"</table>";}

            if($aun==22) { $next_div = "next_div$pagego";
                echo "<div id=$next_div>
                <table width=100% style=\"cursor: pointer; \">
                <tr><td align=center height=50 class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\"
                 onClick=\"comment_c($id,$Namefgo,$pagego)\";><b>$next_e</b></td></tr>
                 </table>
                 </div></div>";
            }

        }


    }





    public function comment_p(Request $request)
    {
        $Namef = $request['Namef'];
        $page = $request['page'];
        $id = $request['id'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }
        $id = $id + 1;
        $id = $id - 1;
        if (is_int($id) != "true") {
            die("");
        }
        $Namefgo = $Namef;
        $pagego = $page+1;
        if($page==1) {$skip=0;}
        else{$skip = ($page-1)*20;}



        $admpass="off";
        if (Auth::user()){
            $Num = $id;
            $Alls = DB::table('Friends')->select('Num1', 'Num2')->
            where(function($query1) use ($Num) {
                $query1->where('Num1', $Num)
                    ->where('Argue', '=', 2);
            })->
            orWhere(function($query2) use ($Num) {
                $query2->where('Num2', $Num)
                    ->where('Argue', '=', 2);
            })->
            get();
            $fr_avt="";  $Numfr = "";
            foreach ($Alls as $All) { $Num1=$All->Num1; $Num2=$All->Num2;
                if($Num1==$Num){$Numfr=$Num2;} else{$Numfr=$Num1; }
                $fr_avt.= " $Numfr";  }
            $my_id = Auth::user()->id; $my_id2 = "$my_id";
            $isfriend = strstr("$fr_avt", "$my_id2");
        } else {$isfriend = ""; $my_id = "999999999999999";}

        if($my_id==$id){$v_s=4;   $admpass="ok";}
        else{
            if($my_id == "999999999999999"){$v_s=1;}
            else if($my_id>0){$v_s=2;
                if($isfriend!=""){$v_s=3;}
            }
        }


        if($Namef>0){
            $Allb = DB::table('Fotop')->select('album','Num')->
            where('Namef', $Namef)->limit(1)->get();
            foreach ($Allb as $All) {$album = $All->album; $id = $All->Num;}

            $Allb = DB::table('Memoryfp')->select('Num', 'Aboutef', 'Md', 'avt', 'Fd', 'Formf')->
            where('Nump', $id)->
            where('Sh', '<=', $v_s)->
            where('album', $album)->
            orderBy('Md', 'desc')->
            skip($skip)->take(21)->
            get();
        }
        else{
            $Allb = DB::table('Memoryfp')->select('Num', 'Aboutef', 'Md', 'avt', 'Fd', 'Formf')->
            where('Nump', $id)->
            where('Sh', '<=', $v_s)->
            orderBy('Md', 'desc')->
            skip($skip)->take(21)->
            get();
        }
        $Allbn = $Allb->count();

        if($Allbn==21){$next_e = __('messages.nnext');}
        else {$next_e = "";}


        if($page==1 && $Namef>0){
            echo"<br /><div align = center><b>$album</b></div>";
        }
        if($Allbn == 0){
            $no_comment = __('messages.no_comment');
            echo"<br /><div align = center><b>$no_comment</b></div><br />";
        }
        if($Allbn>0){

            echo"<div align = center>";

            $aun = 1;
            foreach ($Allb as $Alb) {

                if($aun<21){

                    $Namef = $Alb->Num; $Fd = $Alb->Fd; $Formf = $Alb->Formf;
                    $Aboutef = $Alb->Aboutef; $Md = $Alb->Md; $avt = $Alb->avt;


                    if ($aun == 1) {
                        echo "<table>";
                    }

                    echo"<tr height=70><td width=120 class=fcom valign=top align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">";

                    $monm = substr($Fd, 5, 2); $yem = substr($Fd, 0, 4);
                    if ($monm<10){$monmf = substr($Fd, 6, 1);}
                    else{$monmf=$monm;}
                    if($yem<=2007){$yem = "2005-2007"; $monmf="";}
                    $katalog = "Fotop/$yem$monmf/s$Namef.$Formf";
                    $katalogb = "Fotop/$yem$monmf/$Namef.$Formf";

                    if (Storage::disk('public')->exists($katalog)) {
                        $katalogface=Storage::disk('public')->url($katalog);
                    }
                    else if (Storage::disk('public')->exists($katalogb)) {
                        $katalogface=Storage::disk('public')->url($katalogb);
                    }
                    else{$katalogface="/alb.jpg";}

                    echo"<div style=\"margin: 8px 8px 8px 8px; \"> <a onclick=abfp('$id','$Namef')>
                                <div style=\" height: 70px; overflow: hidden\">
                                    <img border=0 width=100 src=$katalogface>
                                </div>
                            </a></div>";
                    $M6_e= db_date($Md);
                    if (Auth::user()){$Numm = Auth::user()->id;}
                    else{$Numm=1;}

                    $qavt = avt($avt,$Numm);
                    $n_Aboutef = mb_strlen($Aboutef);
                    echo"</td><td width='280' class=fcom valign=top align=left onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                           <div style=\" margin: 6px 8px 8px 8px; width: 250px; overflow: hidden;\">";
                    if($n_Aboutef>70){
                        echo"<table><tr><td>$qavt $Aboutef  </td></tr>
                                <tr><td align='right'><span style='color: grey'> $M6_e </span></td></tr>";
                    }
                    else{
                        echo"<table><tr valign='top'><td>$qavt </td><td align='left' width='300'>
                                        <table>
                                            <tr><td width='280'>$Aboutef  </td></tr>
                                            <tr><td align='right'><span style='color: grey'> $M6_e </span></td></tr>
                                        </table>
                                </td></tr>";
                    }
                    echo"</table>
                            </div></td></tr>";
                }

                $aun++;
            }

            if($Allbn>0){echo"</table>";}

            if($aun==22) { $next_div = "next_div$pagego";
                echo "<div id=$next_div>
                <table width=100% style=\"cursor: pointer; \">
                <tr><td align=center height=50 class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\"
                 onClick=\"comment_p($id,$Namefgo,$pagego)\";><b>$next_e</b></td></tr>
                 </table>
                 </div></div>";
            }
        }

    }










    public function abf(Request $request)
    {
        $Namef = intval($request['Namef']);
        if (is_int($Namef) != "true") {
            die("");
        }
        $id = intval($request['id']);
        if (is_int($id) != "true") {
            die("");
        }

        $admpass="off";
        if(Auth::user()) {
            $my_id = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if ($Alladn > 0) {
                $admpass = "ok"; $aheight = 230;
            }
        }

        $Allc = DB::table('Allcities')->select('domen')->
        where('id', $id)->limit(1)->get();
        foreach ($Allc as $All) {
            $domen = $All->domen;
        }

        $memory_contents = Storage::disk('public')->get('delseeffile.txt');
        $pc="c";
        if (strstr($memory_contents,"$pc$Namef")==""){
            $memory_contents.="$pc$Namef";
            Storage::disk('public')->put('delseeffile.txt', $memory_contents);

            DB::table('Foto')->where('Namef', $Namef)->increment('views', 1);

        }

        $Allb = DB::table('Foto')->select('Nameg','City','Adrf','Datef','Fd','Formf','w','h','avt','album','x','y','views','r_gol','r_kol','rh')->
        where('Namef', $Namef)->limit(1)->get();
        $Allbn = $Allb->count();

        foreach ($Allb as $Alb) {

            $Nameg = $Alb->Nameg;
            $City = $Alb->City;
            $M3 = $Alb->Adrf;
            $M4 = $Alb->Datef;
            $M6 = $Alb->Fd;
            $M7 = $Alb->Formf;
            $w = $Alb->w;
            $h = $Alb->h;
            $avt = $Alb->avt;
            $alb = $Alb->album;
            $x = $Alb->x;
            $y = $Alb->y;
            $views = $Alb->views;
            $r_gol = $Alb->r_gol;
            $r_kol = $Alb->r_kol;
            $rh = $Alb->rh;
        }

        // popup (клік по фото в стрічці новин/hero) рендериться легкою inc.abf_popup (велике фото,
        // без стрічки коментарів) замість важкої inc.abf (тонка карточка 200px + Memoryf-коментарі)
        echo view('inc.abf_popup', ['id' => $id, 'Namef' => $Namef, 'admpass' => $admpass, 'Nameg' => $Nameg,
            'City' => $City, 'domen' => $domen, 'M3' => $M3, 'M4' => $M4,
            'M6' => $M6, 'M7' => $M7, 'w' => $w, 'h' => $h, 'avt' => $avt, 'x' => $x, 'y' => $y, 'alb' => $alb,
            'views' => $views, 'r_gol' => $r_gol, 'r_kol' => $r_kol, 'rh' => $rh, 'design' => 'default', 'alb_des' => 'default']);



    }

    // Стрічка коментарів для popup (/abf) підвантажується окремим запитом ПІСЛЯ того, як фото вже
    // показане — саме запит до Memoryf і по одному запиту на кожного автора коментаря були причиною
    // затримки відкриття popup. Викликається з abf() в public/js/allcities19.js.
    public function abf_comments(Request $request)
    {
        $Namef = intval($request['Namef']);
        if (is_int($Namef) != "true") {
            die("");
        }
        $id = intval($request['id']);
        if (is_int($id) != "true") {
            die("");
        }

        $admpass = "off";
        if (Auth::user()) {
            $my_id = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
            limit(1)->get();
            if ($Allad->count() > 0) {
                $admpass = "ok";
            }
        }

        $avt = DB::table('Foto')->where('Namef', $Namef)->value('avt');

        echo view('inc.comment', ['M5' => $Namef, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'off']);
    }



    public function abfp(Request $request)
    {

        $Namef = intval($request['Namef']);
        if (is_int($Namef) != "true") {
            die("");
        }
        $id = intval($request['id']);
        if (is_int($id) != "true") {
            die("");
        }

        $admpass="off";
        if (Auth::user()){
            $my_id = Auth::user()->id;
        } else { $my_id = "999999999999999";}

        if ($my_id == $id) {
            $admpass = "ok";
            $domen = Auth::user()->domen;
        }
        else{
            $Allc = DB::table('users')->select('domen')->
            where('id', $id)->limit(1)->get();
            foreach ($Allc as $All) {
                $domen = $All->domen;
            }
        }

        $memory_contents = Storage::disk('public')->get('delseeffile.txt');
        $pc="p";
        if (strstr($memory_contents,"$pc$Namef")==""){
            $memory_contents.="$pc$Namef";
            Storage::disk('public')->put('delseeffile.txt', $memory_contents);

            DB::table('Fotop')->where('Namef', $Namef)->increment('views', 1);

        }

        $Allb = DB::table('Fotop')->select('Fd','Formf','w','h','avt','album','views','r_gol','r_kol','rh')->
        where('Namef', $Namef)->limit(1)->get();
        $Allbn = $Allb->count();

        foreach ($Allb as $Alb) {
            $M6 = $Alb->Fd;
            $M7 = $Alb->Formf;
            $avt = $Alb->avt;
            $alb = $Alb->album;
            $views = $Alb->views;
            $r_gol = $Alb->r_gol;
            $r_kol = $Alb->r_kol;
            $w = $Alb->w;
            $h = $Alb->h;
            $rh = $Alb->rh;
        }

        // popup рендериться легкою inc.abfp_popup (велике фото, без стрічки коментарів)
        echo view('inc.abfp_popup', ['id' => $id, 'Namef' => $Namef, 'admpass' => $admpass, 'domen' => $domen,
            'M6' => $M6, 'M7' => $M7, 'w' => $w, 'h' => $h, 'avt' => $avt, 'alb' => $alb,
            'views' => $views, 'r_gol' => $r_gol, 'r_kol' => $r_kol, 'rh' => $rh, 'design' => 'default', 'alb_des' => 'default']);

    }

    // Аналог abf_comments() для особистих фото (Fotop) — підвантажується з abfp() окремим запитом.
    public function abfp_comments(Request $request)
    {
        $Namef = intval($request['Namef']);
        if (is_int($Namef) != "true") {
            die("");
        }
        $id = intval($request['id']);
        if (is_int($id) != "true") {
            die("");
        }

        $admpass = "off";
        if (Auth::user()) {
            $my_id = Auth::user()->id;
            if ($my_id == $id) {
                $admpass = "ok";
            }
        }

        $avt = DB::table('Fotop')->where('Namef', $Namef)->value('avt');

        echo view('inc.commentp', ['M5' => $Namef, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'off']);
    }

    // Легкий стан зірки оцінки для "великих" фото прямо в стрічці новин (index.blade.php,
    // групи <=3 фото). Пошук за Namef — первинний ключ Foto/Fotop, тобто точковий, без сканування.
    // Викликається асинхронно ПІСЛЯ показу сторінки (як і /abf_comments), щоб не сповільнювати
    // першу видачу головної. design='popup' — та сама причина, що й для popup: без кнопок "поділитись".
    public function news_rating_state(Request $request)
    {
        $Namef = intval($request['Namef']);
        if (is_int($Namef) != "true") {
            die("");
        }
        $type = ($request['type'] === 'fotop') ? 'fotop' : 'foto';

        if (Auth::user()) {
            $Numm = Auth::user()->id;
        } else {
            $Numm = "0000000000";
        }

        if ($type === 'fotop') {
            $row = DB::table('Fotop')->select('r_gol', 'r_kol', 'rh')->where('Namef', $Namef)->first();
        } else {
            $row = DB::table('Foto')->select('r_gol', 'r_kol', 'rh')->where('Namef', $Namef)->first();
        }

        if (!$row) {
            return "";
        }

        $r_gol = $row->r_gol;
        $r_kol = $r_gol ? $row->r_kol : 0;
        $rh = $row->rh;

        // Світлий фон стрічки (не темне фото-підложка, як у popup) — інший неактивний колір зірки
        $color_star = "#c7c7c7";
        if ($r_kol > 0) { $color_star = "#356AA0"; }
        if ($r_kol > 1) { $color_star = "gold"; }
        if ($r_kol > 4) { $color_star = "orange"; }
        $rect = "shine";
        if (mb_strstr("$rh", "$Numm") != "") {
            $rect = "";
        }

        $fn = ($type === 'fotop') ? 'rate_addp' : 'rate_add';
        $fh = ($type === 'fotop') ? 'rate_hp' : 'rate_h';

        // Префікс "n" — щоб id не збігався з popup-версією (d$Namef/r$Namef), якщо те саме
        // фото одночасно відкрите і великою карткою в стрічці, і в popup.
        echo "<svg class=\"star-container\" width=\"18\" height=\"18\" onclick=\"$fn('nd$Namef',$Namef,'popup')\" rel=\"noopener noreferrer\">
            <use class=\"star\" fill=\"$color_star\" href=\"/images/icons.svg#icon-star-full\"></use>
            <rect class=\"$rect\" fill=\"white\"></rect>
        </svg>
        <a href=\"##\" onclick=\"$fh('nr$Namef',$Namef)\" rel=\"noopener noreferrer\">$r_kol</a>";
    }








    // Перевірка "чи можна коментувати" ДО показу поля вводу (фото людей, Fotop) — та сама логіка
    // приватності (Private.Forum, Friends), що й у comm_addp, але без запису коментаря. Викликається
    // асинхронно ПІСЛЯ показу сторінки/попапу, щоб поле коментаря не блимало і не сповільнювало вивід.
    public function comm_allowp(Request $request)
    {
        $Namef = intval($request['Namef']);
        if (is_int($Namef) != "true") {
            die("0");
        }
        if (!Auth::user()) {
            die("0");
        }
        $Numm = Auth::user()->id;

        $Allb = DB::table('Fotop')->select('Num', 'avt')->where('Namef', $Namef)->limit(1)->get();
        $id = null; $whom = null;
        foreach ($Allb as $All) {
            $id = $All->Num;
            $whom = $All->avt;
        }
        if (!$id) {
            die("0");
        }

        $sq = 0;
        $Allq = DB::table('Private')->select('ban')->
        where('Num', $whom)->limit(1)->get();
        foreach ($Allq as $Alq) {
            $ComForBan = $Alq->ban;
            $sq++;
        }
        if ($sq == 0) {
            $ComForBan = "";
        }

        $sq = 0;
        $Forum = 1;
        $Allq = DB::table('Private')->select('ban', 'Forum')->
        where('Num', $id)->limit(1)->get();
        foreach ($Allq as $Alq) {
            $Ban = $Alq->ban;
            $Forum = $Alq->Forum;
            $sq++;
        }
        if ($sq == 0) {
            $Ban = "";
        }

        if (mb_strstr((string)$ComForBan, (string)$Numm) != "" || mb_strstr((string)$Ban, (string)$Numm) != "") {
            die("0");
        }

        $Privatpass = "stop";
        if (!$Forum || $Forum == 0 || $Forum == 1 || $Forum == 2) {
            $Privatpass = "go";
        } else {
            $Alls = DB::table('Friends')->select('Num1', 'Num2')->
            where(function ($query1) use ($id) {
                $query1->where('Num1', $id)
                    ->where('Argue', '=', 2);
            })->
            orWhere(function ($query2) use ($id) {
                $query2->where('Num2', $id)
                    ->where('Argue', '=', 2);
            })->
            get();
            $fr_avt = "";
            $Numfr = "";
            foreach ($Alls as $All) {
                $Num1 = $All->Num1;
                $Num2 = $All->Num2;
                if ($Num1 == $id) {
                    $Numfr = $Num2;
                } else {
                    $Numfr = $Num1;
                }
                $fr_avt .= " $Numfr";
            }
            $isfriend = strstr("$fr_avt", "$Numm");

            if ($Forum == 3 && ($id == $Numm || $isfriend != "")) {
                $Privatpass = "go";
            } else {
                if ($Forum == 4 && $id == $Numm) {
                    $Privatpass = "go";
                }
            }
        }

        echo $Privatpass == "go" ? "1" : "0";
    }

    public function foto(Request $request)
    {
        $Namef = $request['Namef'];
        $page = $request['page'];
        $id = $request['id'];
        $domen = $request['domen'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }
        $id = $id + 1;
        $id = $id - 1;
        if (is_int($id) != "true") {
            die("");
        }
        $skip = ($page-1)*30;

        if($Namef>0){

            $Allb = DB::table('Foto')->select('album')->
            where('Namef', $Namef)->limit(1)->get();
            foreach ($Allb as $All) {$album = $All->album; }

            $Allb = DB::table('Foto')->select('Namef','Nameg','City','Adrf','Datef','Fd','Formf','w','h','avt','album','x','y','views','r_gol','r_kol','rh')->
            where('id', $id)->
            where('album', $album)->
            orderBy('Fd', 'desc')->
            skip($skip)->take(31)->
            get();
            $alb_a = $album;
            $alb_e = $album;
            $Namef_a = $Namef;
        }
        else{

            $Allb = DB::table('Foto')->select('Namef','Nameg','City','Adrf','Datef','Fd','Formf','w','h','avt','album','x','y','views','r_gol','r_kol','rh')->
            where('id', $id)->
            orderBy('Fd', 'desc')->
            skip($skip)->take(31)->
            get();
            $alb_a = "default";
            $alb_e = "";
            $Namef_a = 0;

        }

        $Allbn = $Allb->count();
        if($Allbn>0){

            $admpass="off";
            if(Auth::user()) {
                $my_id = Auth::user()->Num;
                $Allad = DB::table('City_Admin2')->select('id')->
                where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
                limit(1)->get();
                $Alladn = $Allad->count();
                if ($Alladn > 0) {
                    $admpass = "ok"; $aheight = 230;
                }
            }

            echo"
			<ul class=\"flist\">";

        }

        $nfm = 1;
        foreach ($Allb as $Alb) {
            if($nfm<31){

                $Namef = $Alb->Namef;
                $Nameg = $Alb->Nameg;
                $City = $Alb->City;
                $M3 = $Alb->Adrf;
                $M4 = $Alb->Datef;
                $M6 = $Alb->Fd;
                $M7 = $Alb->Formf;
                $w = $Alb->w;
                $h = $Alb->h;
                $avt = $Alb->avt;
                $alb = $Alb->album;
                $x = $Alb->x;
                $y = $Alb->y;
                $views = $Alb->views;
                $r_gol = $Alb->r_gol;
                $r_kol = $Alb->r_kol;
                $rh = $Alb->rh;

                echo view('inc.abf', ['id' => $id, 'Namef' => $Namef, 'w' => $w, 'h' => $h, 'admpass' => $admpass, 'Nameg' => $Nameg,
                    'City' => $City, 'domen' => $domen, 'M3' => $M3, 'M4' => $M4,
                    'M6' => $M6, 'M7' => $M7, 'avt' => $avt, 'x' => $x, 'y' => $y, 'alb' => $alb,
                    'views' => $views, 'r_gol' => $r_gol, 'r_kol' => $r_kol, 'rh' => $rh, 'design' => 'default', 'alb_des' => $alb_a]);

            }
            $nfm++;
        }

        if($Allbn>0){echo"</ul>";}
        if($nfm==32){

            $next_e = __('messages.nnext');
            $page = $page+1;
            $next_div = "nextf_div$page";
            echo"<section id=$next_div class=\"fcombold mt15 centered\" onMouseOver=foto('$id','$domen','$Namef_a','$page')>
                 <a href=## onclick=foto('$id','$domen','$Namef_a','$page') rel=\"noopener noreferrer\"><h3>$next_e $alb_e</h3> </a>
            </section>";
        }
    }



    public function fotop(Request $request)
    {
        $Namef = $request['Namef'];
        $page = $request['page'];
        $id = $request['id'];
        $domen = $request['domen'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }
        $id = $id + 1;
        $id = $id - 1;
        if (is_int($id) != "true") {
            die("");
        }
        $skip = ($page-1)*30;


        $admpass="off";
        if (Auth::user()){
            $Num = $id;
            $Alls = DB::table('Friends')->select('Num1', 'Num2')->
            where(function($query1) use ($Num) {
                $query1->where('Num1', $Num)
                    ->where('Argue', '=', 2);
            })->
            orWhere(function($query2) use ($Num) {
                $query2->where('Num2', $Num)
                    ->where('Argue', '=', 2);
            })->
            get();
            $fr_avt="";  $Numfr = "";
            foreach ($Alls as $All) { $Num1=$All->Num1; $Num2=$All->Num2;
                if($Num1==$Num){$Numfr=$Num2;} else{$Numfr=$Num1; }
                $fr_avt.= " $Numfr";  }
            $my_id = Auth::user()->id; $my_id2 = "$my_id";
            $isfriend = strstr("$fr_avt", "$my_id2");
        } else {$isfriend = ""; $my_id = "999999999999999";}

        if($my_id==$id){$v_s=4;  $aheight = 235; $admpass="ok";}
        else{
            if($my_id == "999999999999999"){$v_s=1;}
            else if($my_id>0){$v_s=2;
                if($isfriend!=""){$v_s=3;}
            }
        }


        if($Namef>0){

            $Allb = DB::table('Fotop')->select('album')->
            where('Namef', $Namef)->limit(1)->get();
            foreach ($Allb as $All) {$album = $All->album; }

            $Allb = DB::table('Fotop')->select('Namef','Fd','w','h','Formf','avt','album','views','r_gol','r_kol','rh')->
            where('Num', $id)->
            where('album', $album)->
            where('Sh', '<=', $v_s)->
            orderBy('Fd', 'desc')->
            skip($skip)->take(31)->
            get();
            $alb_a = $album;
            $alb_e = $album;
            $Namef_a = $Namef;
        }
        else{

            $Allb = DB::table('Fotop')->select('Namef','Fd','Formf','w','h','avt','album','views','r_gol','r_kol','rh')->
            where('Num', $id)->
            where('Sh', '<=', $v_s)->
            orderBy('Fd', 'desc')->
            skip($skip)->take(31)->
            get();
            $alb_a = "default";
            $alb_e = "";
            $Namef_a = 0;

        }

        $Allbn = $Allb->count();

        if($Allbn>0){
            echo"<ul class=\"flist\">";
        }

        $nfm = 1;
        foreach ($Allb as $Alb) {
            if($nfm<31){

                $Namef = $Alb->Namef;
                $M6 = $Alb->Fd;
                $M7 = $Alb->Formf;
                $avt = $Alb->avt;
                $alb = $Alb->album;
                $views = $Alb->views;
                $w = $Alb->w;
                $h = $Alb->h;
                $r_gol = $Alb->r_gol;
                $r_kol = $Alb->r_kol;
                $rh = $Alb->rh;

                echo view('inc.abfp', ['id' => $id, 'Namef' => $Namef, 'admpass' => $admpass,
                    'domen' => $domen,
                    'M6' => $M6, 'M7' => $M7, 'avt' => $avt, 'alb' => $alb, 'w' => $w, 'h' => $h,
                    'views' => $views, 'r_gol' => $r_gol, 'r_kol' => $r_kol, 'rh' => $rh, 'design' => 'default', 'alb_des' => $alb_a]);

            }
            $nfm++;
        }

        if($Allbn>0){echo"</ul>";}

        if($nfm==32){
            $next_e = __('messages.nnext');
            $page = $page+1;
            $next_div = "nextf_div$page";
            echo"<section id=$next_div class=\" fcombold mt15 centered\" onMouseOver=fotop('$id','$domen','$Namef_a','$page') >
                        <a href=## onclick=fotop('$id','$domen','$Namef_a','$page') rel=\"noopener noreferrer\"><h3>$next_e $alb_e</h3> </a>
                    </section>";
        }
    }








    public function red_foto(Request $request)
    {
        $Namef = $request['Namef'];
        $t3 = "r$Namef";
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }

        $Allb = DB::table('Foto')->select('album', 'id', 'Adrf', 'Datef', 'Publ', 'Face','Fd','Formf','avt')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {
            $album = $All->album;
            $id = $All->id;
            $Adrf = $All->Adrf;
            $Datef = $All->Datef;
            $Publ = $All->Publ;
            $Face = $All->Face;
            $M6 = $All->Fd;
            $Formf = $All->Formf;
            $avt = $All->avt;
        }

        $admpass = "off";
        $my_id = Auth::user()?->id;
        if (Auth::user()) {
            $Allad = DB::table('City_Admin2')->
            where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
            limit(1)->get();
            if ($Allad->count() > 0) {
                $admpass = "ok";
            }
        }

        if ($admpass == "ok" || $avt == $my_id) {

            $Allb = DB::table('Foto')->select('album')->
            where('id', $id)->
            groupBy('album')->
            orderBy('album', 'asc')->
            get();

            $Album = __('messages.Album');
            $Move = __('messages.Move');
            $edit = __('messages.edit2');
            $publ_for = __('messages.publ_for');
            $notpubl_for = __('messages.notpubl_for');
            $face = __('messages.face');
            $adr_shot = __('messages.adr_shot');
            $date_shot = __('messages.date_shot');

            echo "
            <br /> $adr_shot<br /><INPUT TYPE=text id=\"Adrf$t3\" SIZE=20 maxlength=45 value=\"$Adrf\"><br />
            <br />$date_shot<br /><INPUT TYPE=text id=\"Datef$t3\" SIZE=20 maxlength=45 value=\"$Datef\"><br />
            <br />$Move: <br /><select style='margin: 0px 0px 0px 0px; padding:0px;' id=\"albs$t3\">";
            foreach ($Allb as $All) {
                $album2 = $All->album;
                $album3 = $album2;
                if (mb_strlen($album2) >18) {
                    $album3 = mb_substr($album2, 0, 18);
                    $album3 .= "...";
                }
                echo "<option value=\"$album2\""; if($album == $album2){echo " selected";}echo ">$album3</option>";
            }
            echo "</select>";

            if ($admpass == "ok") {
                $monm = substr($M6, 5, 2);
                $yem = substr($M6, 0, 4);
                if ((int)$monm < 10) {
                    $monmf = substr($M6, 6, 1);
                } else {
                    $monmf = $monm;
                }
                if ((int)$yem <= 2007) {
                    $yem = "2005-2007";
                    $monmf = "";
                }
                $katalog = "Photos/$yem$monmf/s$Namef.$Formf";

                if (Storage::disk('public')->exists($katalog) && $Face != "1") {
                    echo "<br /><br /><a onclick=face_fc('$Namef','r$Namef')> $face</a>";
                }

                if($Publ>0){echo"<br /><br /><a onclick=publ_fc('$Namef','r$Namef')>$notpubl_for</a>";}
                else{echo"<br /><br /><a onclick=publ_fc('$Namef','r$Namef')> $publ_for</a>";}
            }

            echo "<br /><br /><table>
                <tr><td class=\"fcomblue\" width=100>
                     <ul class=\"intop\"><li><a onclick=do_red_foto('$Namef','$t3','albs$t3','Adrf$t3','Datef$t3')> $edit</a></li></ul>
                </td></tr>
                 </table>";
        }
    }


    function do_red_foto(Request $request)
    {

        $Namef = $request['Namef'];

        $albs = $request['albs'];
        $Adrf = $request['Adrf'];
        $Datef = $request['Datef'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }

        $albs = strip_tags($albs);
        $Adrf = strip_tags($Adrf);
        $Datef = strip_tags($Datef);


        $Allb = DB::table('Foto')->select('album', 'id', 'avt')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {
            $album = $All->album;
            $id = $All->id;
            $avt = $All->avt;
        }

        $Allc = DB::table('Allcities')->select('domen')->
        where('id', $id)->limit(1)->get();
        foreach ($Allc as $All) {
            $domen = $All->domen;
        }

        $my_id = Auth::user()->id;
        $admpass = "off";
        if (Auth::user()) {
            $Allad = DB::table('City_Admin2')->select('id')->
            where('id', $my_id)->where('Page', 'Foto')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if ($Alladn > 0) {
                $admpass = "ok";
            }
        }

        if ($admpass == "ok" || $avt==$my_id) {


            $lan = __('messages.lan');

            if($albs != $album){
                $foto_move = __('messages.foto_move');
                $ch_e = "$foto_move <b><a href=\"/$domen/foto/$lan/$albs\">$albs</a></b><br />";
            }
            else{
                $ch_e = __('messages.foto_ch');
            }

            $affected = DB::table('Foto')
                ->where('Namef', $Namef)
                ->update(['album' => $albs, 'Adrf' => $Adrf, 'Datef' => $Datef]);

            if ($affected) {
                echo "<br /><br /> $ch_e  <br /><br />";

                echo "<html><head><meta http-equiv='refresh' content='1; url=/" . __('messages.pref_page') . "nf$Namef'></head></html>";
            }

        }

    }










    function publ_fc(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }

        $Allb = DB::table('Foto')->select('album', 'id', 'Publ')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {
            $album = $All->album;
            $id = $All->id;
            $Publ = $All->Publ;
        }

        $Allb = DB::table('Foto')->select('id')->
        where('id', $id)->
        where('Publ', '1')->
        get();
        $Publn = $Allb->count();
        if($Publn>10){

            $ch_e = __('messages.max_publ');
            echo "<br /><br /> $ch_e  <br /><br />";
        }
        else{

            $admpass = "off";
            if (Auth::user()) {
                $my_id = Auth::user()->id;
                $Allad = DB::table('City_Admin2')->select('id')->
                where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
                limit(1)->get();
                $Alladn = $Allad->count();
                if ($Alladn > 0) {
                    $admpass = "ok";
                }
            }

            if ($admpass == "ok") {
                if($Publ == 1){$Publ_s = '0'; $ch_e = __('messages.notpubl_fored');}
                else{$Publ_s = '1'; $ch_e = __('messages.publ_fored');}

                $affected = DB::table('Foto')
                    ->where('Namef', $Namef)
                    ->update(['Publ' => $Publ_s]);

                if ($affected) {
                    echo "<br /><br /> $ch_e  <br /><br />";
                    if($Publ != 1) {
                        echo "<html><head><meta http-equiv='refresh' content='2; url=/" . __('messages.pref_page') . "c$id'></head></html>";
                    }
                }
            }
        }
    }




    function face_fc(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }

        $Allb = DB::table('Foto')->select('id','album')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {
            $id = $All->id;
            $album = $All->album;
        }

        $admpass = "off";
        if (Auth::user()) {
            $my_id = Auth::user()->id;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if ($Alladn > 0) {
                $admpass = "ok";
            }
        }

        if ($admpass == "ok") {

            DB::table('Foto')
                ->where('id', $id)
                ->where('album', $album)
                ->update(['Face' => '0']);

            $affected = DB::table('Foto')
                ->where('Namef', $Namef)
                ->update(['Face' => '1']);

            if ($affected) {$ch_e = __('messages.Faced');
                echo "<br /><br /> $ch_e  <br /><br />";
            }
        }
    }










    public function red_fotop(Request $request)
    {
        $Namef = $request['Namef'];
        $t3 = "r$Namef";
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }

        $Allb = DB::table('Fotop')->select('album', 'Num', 'Publ', 'Face','Fd','Formf')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {
            $album = $All->album;
            $id = $All->Num;
            $Publ = $All->Publ;
            $Face = $All->Face;
            $M6 = $All->Fd;
            $Formf = $All->Formf;
        }

        $admpass = "off";
        if (Auth::user()) {
            $my_id = Auth::user()->Num;
            if($my_id == $id || $my_id ==72372396) {
                $admpass = "ok";
            }
        }

        if ($admpass == "ok") {

            $Allb = DB::table('Fotop')->select('album')->
            where('Num', $id)->
            groupBy('album')->
            orderBy('album', 'asc')->
            get();

            $Move = __('messages.Move');
            $edit = __('messages.edit2');
            $publ_for = __('messages.publ_for');
            $notpubl_for = __('messages.notpubl_for');
            $face = __('messages.face');

            echo "<br />
            $Move: <select style='margin: 0px 0px 0px 0px; padding:0px;' id=\"albs$t3\">";
            foreach ($Allb as $All) {
                $album2 = $All->album;
                $album3 = $album2;
                if (mb_strlen($album2) >18) {
                    $album3 = mb_substr($album2, 0, 18);
                    $album3 .= "...";
                }
                echo "<option value=\"$album2\""; if($album == $album2){echo " selected";}echo ">$album3</option>";
            }
            echo "</select>";

            $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
            if ((int)$monm<10){$monmf = substr($M6, 6, 1);}
            else{$monmf=$monm;}
            if((int)$yem<=2007){$yem = "2005-2007"; $monmf="";}
            $katalog = "Fotop/$yem$monmf/s$Namef.$Formf";
            if (Storage::disk('public')->exists($katalog) && $Face!="1") {
                echo"<br /><br /><a onclick=face_fp('$Namef','r$Namef')> $face</a>";
            }

            if($Publ>0){echo"<br /><br /><a onclick=publ_fp('$Namef','r$Namef')>$notpubl_for</a><br><br />";}
            else{echo"<br /><br /><a onclick=publ_fp('$Namef','r$Namef')> $publ_for</a><br><br />";}


            echo "<table>
                <tr><td class=\"fcomblue\" width=100>
                     <ul class=\"intop\"><li><a onclick=do_red_fotop('$Namef','$t3','albs$t3')> $edit</a></li></ul>
                </td></tr>
                 </table><br />";
        }

    }


    function do_red_fotop(Request $request)
    {

        $Namef = $request['Namef'];
        $albs = $request['albs'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }

        $albs = strip_tags($albs);

        $Allb = DB::table('Fotop')->select('album', 'Num')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {
            $album = $All->album;
            $id = $All->Num;
        }

        $Allc = DB::table('users')->select('domen')->
        where('id', $id)->limit(1)->get();
        foreach ($Allc as $All) {
            $domen = $All->domen;
        }

        $admpass = "off";
        if (Auth::user()) {
            $my_id = Auth::user()->Num;
            if($my_id == $id || $my_id ==72372396) {
                $admpass = "ok";
            }
        }

        if ($admpass == "ok") {
            $lan = __('messages.lan');

            if($albs != $album){
                $foto_move = __('messages.foto_move');
                $ch_e = "$foto_move <b><a href=\"/$domen/foto/$lan/$albs\">$albs</a></b><br />";
            }
            else{
                $ch_e = __('messages.foto_ch');
            }

            $affected = DB::table('Fotop')
                ->where('Namef', $Namef)
                ->update(['album' => $albs]);

            if ($affected) {
                echo "<br /><br /> $ch_e  <br /><br />";
                echo "<html><head><meta http-equiv='refresh' content='1; url=/" . __('messages.pref_page') . "ni$Namef'></head></html>";
            }

        }

    }










    function publ_fp(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }

        $Allb = DB::table('Fotop')->select('Num', 'Publ')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {
            $id = $All->Num;
            $Publ = $All->Publ;
        }

        $Allb = DB::table('Fotop')->select('Num')->
        where('Num', $id)->
        where('Publ', '1')->
        get();
        $Publn = $Allb->count();
        if($Publn>10){

            $ch_e = __('messages.max_publ');
            echo "<br /><br /> $ch_e  <br /><br />";
        }
        else{

            $admpass = "off";
            if (Auth::user()) {
                $my_id = Auth::user()->Num;
                if($my_id == $id || $my_id ==72372396) {
                    $admpass = "ok";
                }
            }

            if ($admpass == "ok") {
                if($Publ == 1){$Publ_s = '0'; $ch_e = __('messages.notpubl_fored');}
                else{$Publ_s = '1'; $ch_e = __('messages.publ_fored');}

                $affected = DB::table('Fotop')
                    ->where('Namef', $Namef)
                    ->update(['Publ' => $Publ_s]);

                if ($affected) {
                    echo "<br /><br /> $ch_e  <br /><br />";
                    if($Publ != 1) {
                        echo "<html><head><meta http-equiv='refresh' content='2; url=/" . __('messages.pref_page') . "i$id'></head></html>";
                    }
                }
            }
        }
    }




    function face_fp(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }

        $Allb = DB::table('Fotop')->select('Num','album')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {
            $id = $All->Num;
            $album = $All->album;
        }

        $admpass = "off";
        if (Auth::user()) {
            $my_id = Auth::user()->Num;
            if($my_id == $id || $my_id ==72372396) {
                $admpass = "ok";
            }
        }

        if ($admpass == "ok") {

            DB::table('Fotop')
                ->where('Num', $id)
                ->where('album', $album)
                ->update(['Face' => '0']);

            $affected = DB::table('Fotop')
                ->where('Namef', $Namef)
                ->update(['Face' => '1']);

            if ($affected) {$ch_e = __('messages.Faced');
                echo "<div style=\"max-width: 160px; margin: 8px 8px 8px 8px; \">
                <br /><br /> $ch_e  </div><br /><br />";
            }
        }
    }






    public function load_foto(Request $request)
    {
        if(Auth::user()) {

            $validatedData = $request->validate([
                'files' => 'required',
                'files.*' => 'mimes:jpg,jpeg'
            ]);

            $album = $request->alb;
            if(!$album){$album="Наші фото";}
            $Adrf = $request->Adrf;
            $Datef = $request->Datef;
            $id = $request->id;
            $lan = __('messages.lan');
            $pagego_main = "";

            $pr = " ";
            $All=$pr;  $All=$All.=$Adrf; $All=$All.=$pr; $All=$All.=$Datef; $All=$All.=$pr;
            $All=$All.=$album; $All=$All.=$pr; $All = mb_strtolower($All);

            $Allf = DB::table('Foto')->select('id')->
            where('id', $id)->where('album', $album)->
            get();
            $Allfn = $Allf->count();

            $Numm = Auth::user()->id;
            $sq=0;
            $Allq = DB::table('Privatec')->select('ComForBan')->
            where('id', $id)->limit(1)->get();
            foreach ($Allq as $Alq) {$ComForBan=$Alq->ComForBan; $sq++; }
            if($sq==0){ $ComForBan = "";}

            if ($id>0){ $page="foto"; $idin = $id;
                $Allq = DB::table('Allcities')->select('City','obl','domen')->
                where('id', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {$City=$Alq->City; $obl=$Alq->obl; $domen=$Alq->domen; }
            }
            else{$page="main";}

            $f_ban = __('messages.f_ban');
            $limit_f = __('messages.limit_f');
            $limit_lenf = __('messages.limit_lenf');
            $abuse_ban = __('messages.abuse_ban');
            $no_coord = __('messages.no_coord');
            $no_coord_tips = __('messages.no_coord_tips');
            $no_ukraine = __('messages.no_ukraine');
            $aff = "";
            $aff2 = "";

            if (mb_strstr($All,"хуй")!=""||mb_strstr($All,"пизд")!=""||mb_strstr($All," конч")!=""||mb_strstr($All,"сперм")!=""||mb_strstr($All,"вафл")!=""||mb_strstr($All,"шлюх")!=""||mb_strstr($All,"fuck")!=""||mb_strstr($All," гом")!=""||mb_strstr($All," бля")!=""||mb_strstr($All," манд")!=""||mb_strstr($All,"член")!=""||mb_strstr($All," еба")!=""||mb_strstr($All," єба")!=""||mb_strstr($All,"суч")!=""||mb_strstr($All,"сук")!=""||mb_strstr($All,"дроч")!=""||mb_strstr($All," писк")!=""||mb_strstr($All," піськ")!=""||mb_strstr($All,"урод")!=""||mb_strstr($All,"ублюд")!=""||mb_strstr($All,"соса")!=""||mb_strstr($All,"соси")!=""||mb_strstr($All,"сран")!=""||mb_strstr($All,"срак")!=""||mb_strstr($All,"срат")!=""||mb_strstr($All,"хуев")!=""||mb_strstr($All,"костр")!=""||mb_strstr($All,"блев")!=""||mb_strstr($All,"яйц")!=""||mb_strstr($All," трах")!=""||mb_strstr($All,"влагал")!=""||mb_strstr($All," онан")!=""){
                echo"<br /><table class=fcom><tr><td align=center><p style=\" color:red; margin: 8px 8px 8px 8px; \">$abuse_ban</p></td></tr></table><br /><br />";
            }
            else if(mb_strstr($ComForBan, $Numm)!=""){echo"<br /><table class=fcom><tr><td align=center><p style=\" color:red; margin: 8px 8px 8px 8px;\">$f_ban</p></td></tr></table><br /><br />";}

            else if($Allfn>500){echo"<br /><table class=fcom><tr><td align=center><p style=\" color:red; margin: 8px 8px 8px 8px;\"> $limit_f </p></td></tr></table><br /><br />";}

            else {

                for ($xf = 0; $xf < $request->TotalFiles; $xf++) {
                    $my_f = "files$xf";
                    if ($request->hasFile($my_f)) {

                        $image = $request->file($my_f);
                        $image_resize = Image::make($image->getRealPath());
                        $name = $image->getClientOriginalName();
                        $Lenf = $image->getSize();

                        $Alllf = DB::table('Foto')->select('id')->
                        where('id', $id)->where('album', $album)->where('Lenf', $Lenf)->
                        get();
                        $Alllfn = $Alllf->count();

                        if ($Alllfn > 0) {
                            echo "<br /><table class=fcom><tr><td align=center><p style=\" color:red; margin: 8px 8px 8px 8px;\">$name $limit_lenf</p></td></tr></table><br /><br />";
                        } else {

                            $a = 0;
                            while ($a < 2) {
                                $Namef = round(rand(1, 999999));
                                $Namef = $Namef + 1000000;
                                $Alnf = DB::table('Foto')->select('id')->
                                where('Namef', $Namef)->
                                get();
                                $Alnfn = $Alnf->count();
                                if ($Alnfn == 0) {
                                    $a = 2;
                                } // Файл $Namef створений! $a++;
                            }
                            $katd = date('Yn');
                            $Fd = date('Y-n-j-H-i');
                            $new_file = "$Namef.jpg";
                            $new_pathb = "Photos/$katd/b$new_file";
                            $new_path = "Photos/$katd/$new_file";
                            $new_paths = "Photos/$katd/s$new_file";
                            $image_resize->save(Storage::path('/public/tmp/') . $new_file);
                            $path = $image->store('public/tmp');

                            $x = 0;
                            $y = 0;
                            $data = Image::make(Storage::path($path))->exif();

                            if (isset($data['GPSLatitude']) && $data['GPSLatitude'][0] != "0/0" && $data['GPSLongitude'][0] != "0/0") {
                                $y = eval('return ' . $data['GPSLatitude'][0] . ';')
                                    + (eval('return ' . $data['GPSLatitude'][1] . ';') / 60)
                                    + (eval('return ' . $data['GPSLatitude'][2] . ';') / 3600);
                                $x = eval('return ' . $data['GPSLongitude'][0] . ';')
                                    + (eval('return ' . $data['GPSLongitude'][1] . ';') / 60)
                                    + (eval('return ' . $data['GPSLongitude'][2] . ';') / 3600);

                            }

                            if($y==0 && $x==0 && $id==0){
                                echo"<table class=fcom><tr><td align=left style=\"padding: 8px 8px 8px 8px;\">
                                        <p style=\"color:red; margin: 0 0 8px 0;\"><b>$no_coord</b></p>
                                        <p style=\"margin: 0;\">$no_coord_tips</p>
                                        </td></tr></table><br />";
                            }
                            else {

                                $Allxyn=1;
                                if($y>0 && $x>0 && $id==0){

                                    $x0=$x-0.1;$x1=$x+0.1; $y0=$y-0.1;$y1=$y+0.1;
                                    $road=9000000;
                                    $Allxy = DB::table('Allcities')->select('id', 'domen', 'City', 'City2', 'City3', 'vol_karta', 'obl', 'x', 'y')->
                                    where('x', '>', $x0)->where('x', '<', $x1)->where('y', '>', $y0)->where('y', '<', $y1)->
                                    get();
                                    foreach ($Allxy as $Al) {
                                        $idm=$Al->id; $oblm=$Al->obl; $domenm=$Al->domen;
                                        $Citym=$Al->City; $Citym2=$Al->City2; $Citym3=$Al->City3;
                                        $xx=$Al->x; $yy=$Al->y;
                                        $vol_karta=round(($Al->vol_karta)/24);
                                        $xl=abs($xx-$x); $yl=abs($yy-$y);
                                        $xyl=round(($xl*$xl+$yl*$yl)*1000000);
                                        $xyl=$xyl-$vol_karta;
                                        if($xyl<$road){
                                            $road=$xyl; $idin=$idm; $City=$Citym; $City2=$Citym2;$City3=$Citym3;
                                            $obl=$oblm; $domen=$domenm;
                                            $pagego = "$domen/foto/$lan/";
                                        }
                                    }
                                    if (mb_strstr($pagego_main,$domen)==""){
                                        if ($lan == "ua") {
                                            $pagego_main.="<a target=_blank href=/$pagego><b>$City</a></b> ";
                                        }
                                        if ($lan == "ru") {
                                            $pagego_main.="<a target=_blank href=/$pagego><b>$City2</a></b> ";
                                        }
                                        if ($lan == "en") {
                                            $pagego_main.="<a target=_blank href=/$pagego><b>$City3</a></b> ";
                                        }
                                    }
                                    $Allxyn = $Allxy->count();
                                }

                                if ($Allxyn == 0 && $id==0){
                                    echo"<table class=fcom><tr><td align=center><p style=\" color:red; margin: 8px 8px 8px 8px;\">
                                        $no_ukraine</p></td></tr></table><br />";
                                }
                                else{

                                    $size = getimagesize(Storage::path('/public/tmp/') . $new_file);
                                    $w = $size[0];
                                    $h = $size[1];
                                    $w_bd = $w;
                                    $h_bd = $h;
                                    $hw = $h / $w;

                                    if ($w > 800) {
                                        $new_h = round(800 * $hw);
                                        $image_resize->resize(800, $new_h);
                                    }
                                    $image_resize->save(Storage::path('/public/tmp/b') . $new_file);
                                    $from_path = "tmp/b$new_file";
                                    $from_file = Storage::disk('public')->get($from_path);

                                    $aff = Storage::disk('public')->put($new_pathb, $from_file);
                                    if ($aff) {
                                        Storage::disk('public')->delete($from_path);
                                    }

                                    if ($w > 200) {
                                        $new_h = round(200 * $hw);
                                        $image_resize->resize(200, $new_h);
                                    }
                                    $image_resize->save(Storage::path('/public/tmp/') . $new_file);
                                    $from_path = "tmp/$new_file";
                                    $from_file = Storage::disk('public')->get($from_path);

                                    $aff = Storage::disk('public')->put($new_path, $from_file);
                                    if ($aff) {
                                        Storage::disk('public')->delete($from_path);
                                    }

                                    if ($w > 100) {
                                        $new_h = round(100 * $hw);
                                        $image_resize->resize(100, $new_h);
                                    }
                                    $path3 = $image_resize->save(Storage::path('/public/tmp/s') . $new_file);
                                    $from_path = "tmp/s$new_file";
                                    $from_file = Storage::disk('public')->get($from_path);

                                    $aff = Storage::disk('public')->put($new_paths, $from_file);
                                    if ($aff) {
                                        Storage::disk('public')->delete($from_path);
                                    }

                                    $Numm = Auth::user()->id;
                                    $Imm = Auth::user()->Im;
                                    $Prizm = Auth::user()->Priz;
                                    $email = Auth::user()->email;
                                    $Nameg="$Imm $Prizm";
                                    $ip = getenv('REMOTE_ADDR');
                                    if($x>0 && $y>0){$z=16;} else{$z=0;}
                                    // echo "id $id All $All album $album Adrf $Adrf Datef $Datef <br />";
                                    $aff2 = DB::table('Foto')->insert(['id' => $idin, 'City' => $City, 'obl' => $obl,
                                        'Nameg' => $Nameg, 'Adrf' => $Adrf, 'Datef' => $Datef, 'Namef' => $Namef,
                                        'Lenf' => $Lenf, 'Formf' => 'jpg', 'w'=> $w_bd, 'h'=> $h_bd, 'Face' => '0', 'Publ' => '0',
                                        'mail_admin' => $email, 'avt' => $Numm, 'album' => $album, 'Fd' => $Fd,
                                        'ip' => $ip, 'x' => $x,'y' => $y,'z' => $z]);

                                    $show_news = Auth::user()->show_news;
                                    if (!$show_news) {
                                        $nfoto = 1;
                                    } else {
                                        $nfoto = substr($show_news, 2, 1);
                                    }
                                    if($nfoto==1){
                                        $sexm = Auth::user()->sex;
                                        if(!$sexm){$sexm=0;}
                                        $katalogb = "Photos/$katd/$Namef.jpg";
                                        $katalogface = Storage::disk('public')->url($katalogb);
										$katalogface = str_replace("http:", "https:", $katalogface);

                                        $avheight = "auto";
                                        $imageInfo = getimagesize($katalogface);
                                        if ($imageInfo) {
                                            $avheight = $imageInfo[1] / 2;
                                        }

                                        $ualine="<a href=## onclick=abf('$idin','$Namef')><div class=\"scale\"><img loading=\"lazy\" width=\"100\" height=\"$avheight\" alt=\"$album\" SRC=$katalogface></div></a>";

                                        $theme="fotoc#&~$domen#&~$album";

                                        DB::table('News')->insert(['act' => 'nfoto', 'obl' => $obl, 'Im' => $Imm, 'Priz' => $Prizm,
                                        'sex' => $sexm, 'ualine' => $ualine, 'theme' => $theme, 'avt' => $Numm,
                                        'Nd' => $Fd]);
                                    }

                                   // echo "успішно id $id Lenf $Lenf x $x y $y w $w h $h "; //
                                } // не за межами Укр
                            } // не без координат і не без id
                        } // Lenf нема в базі
                    } // if ($request->hasFile($my_f)) {
                } // for ($x = 0; $x < $request->TotalFiles; $x++) {

                $dfiles = Storage::disk('public')->files('tmp');
                foreach ($dfiles as $dfile) {
                 Storage::disk('public')->delete($dfile);
                }
                if($aff && $aff2 ){
                    if($page=="foto"){
                        $pagego = "$domen/foto/$lan/$album";
                        echo "<html><head><meta http-equiv='refresh' content='0; url=/$pagego'></head></html>";
                    }
                    if($page=="main"){
                        $Add_foto_main = __('messages.Add_foto_main');
                        echo "$Add_foto_main $album $pagego_main";
                    }
                }
            } // else { умови бану
        } // if(Auth::user()) {
    } // public function load_foto






    public function load_fotop(Request $request)
    {
        if(Auth::user()) {


            $validatedData = $request->validate([
                'files' => 'required',
                'files.*' => 'mimes:jpg,jpeg'
            ]);
            $album = $request->alb;
            if(!$album){$album="Мої фото";}
            $Sh = $request->shfoto;
            $id = Auth::user()->id;
            $domen = Auth::user()->domen;
            $Numm = $id;
            $lan = __('messages.lan');
            $pagego_main = "";

            $pr = " ";
            $All=$pr;
            $All=$All.=$album; $All=$All.=$pr; $All = mb_strtolower($All);

            $Allf = DB::table('Fotop')->select('Num')->
            where('Num', $id)->where('album', $album)->
            get();
            $Allfn = $Allf->count();

            $limit_f = __('messages.limit_f');
            $limit_lenf = __('messages.limit_lenf');
            $abuse_ban = __('messages.abuse_ban');
            $aff2 = "";


            if (mb_strstr($All,"хуй")!=""||mb_strstr($All,"пизд")!=""||mb_strstr($All," конч")!=""||mb_strstr($All,"сперм")!=""||mb_strstr($All,"вафл")!=""||mb_strstr($All,"шлюх")!=""||mb_strstr($All,"fuck")!=""||mb_strstr($All," гом")!=""||mb_strstr($All," бля")!=""||mb_strstr($All," манд")!=""||mb_strstr($All,"член")!=""||mb_strstr($All," еба")!=""||mb_strstr($All," єба")!=""||mb_strstr($All,"суч")!=""||mb_strstr($All,"сук")!=""||mb_strstr($All,"дроч")!=""||mb_strstr($All," писк")!=""||mb_strstr($All," піськ")!=""||mb_strstr($All,"урод")!=""||mb_strstr($All,"ублюд")!=""||mb_strstr($All,"соса")!=""||mb_strstr($All,"соси")!=""||mb_strstr($All,"сран")!=""||mb_strstr($All,"срак")!=""||mb_strstr($All,"срат")!=""||mb_strstr($All,"хуев")!=""||mb_strstr($All,"костр")!=""||mb_strstr($All,"блев")!=""||mb_strstr($All,"яйц")!=""||mb_strstr($All," трах")!=""||mb_strstr($All,"влагал")!=""||mb_strstr($All," онан")!=""){
                echo"<br /><table class=fcom><tr><td align=center><p style=\" color:red; margin: 8px 8px 8px 8px; \">$abuse_ban</p></td></tr></table><br /><br />";
            }
            else if($Allfn>500){echo"<br /><table class=fcom><tr><td align=center><p style=\" color:red; margin: 8px 8px 8px 8px;\"> $limit_f </p></td></tr></table><br /><br />";}

            else {

                for ($xf = 0; $xf < $request->TotalFiles; $xf++) {
                    $my_f = "files$xf";
                    if ($request->hasFile($my_f)) {

                        $image = $request->file($my_f);
                        $image_resize = Image::make($image->getRealPath());
                        $name = $image->getClientOriginalName();
                        $Lenf = $image->getSize();

                        $Alllf = DB::table('Fotop')->select('Num')->
                        where('Num', $id)->where('album', $album)->where('Lenf', $Lenf)->
                        get();
                        $Alllfn = $Alllf->count();

                        if ($Alllfn > 0) {
                            echo "<br /><table class=fcom><tr><td align=center><p style=\" color:red; margin: 8px 8px 8px 8px;\">$name $limit_lenf</p></td></tr></table><br /><br />";
                        } else {

                            $a = 0; $Namef=0;
                            while ($a < 2) {
                                $Namef = round(rand(1, 999999));
                                $Namef = (int)$Namef + 7000000;
                                $Alnf = DB::table('Fotop')->select('Num')->
                                where('Namef', $Namef)->
                                get();
                                $Alnfn = $Alnf->count();
                                if ($Alnfn == 0) {
                                    $a = 2;
                                } // Файл $Namef створений!
                            }
                            $katd = date('Yn');
                            $Fd = date('Y-n-j-H-i');
                            $new_file = "$Namef.jpg";
                            $new_pathb = "Fotop/$katd/b$new_file";
                            $new_path = "Fotop/$katd/$new_file";
                            $new_paths = "Fotop/$katd/s$new_file";


                            $katalogmake = "public/Fotop/$katd";
                                if(!File::exists($katalogmake)) {
                                Storage::makeDirectory($katalogmake);

                            }

                            $image_resize->save(Storage::path('/public/tmp/') . $new_file);
                            $path = $image->store('public/tmp');

                            $size = getimagesize(Storage::path('/public/tmp/') . $new_file);
                            $w = $size[0];
                            $h = $size[1];
                            $w_bd = $w;
                            $h_bd = $h;
                            $hw = $h / $w;

                            if ($w > 800) {
                                $new_h = round(800 * $hw);
                                $image_resize->resize(800, $new_h);
                            }
                            $path = "public/Fotop/$katd/b$new_file";
                            $image_resize->save(Storage::path($path));

                            if ($w > 200) {
                                $new_h = round(200 * $hw);
                                $image_resize->resize(200, $new_h);
                            }
                            $path = "public/Fotop/$katd/$new_file";
                            $image_resize->save(Storage::path($path));

                            if ($w > 100) {
                                $new_h = round(100 * $hw);
                                $image_resize->resize(100, $new_h);
                            }
                            $path = "public/Fotop/$katd/s$new_file";
                            $image_resize->save(Storage::path($path));

                            $Numm = Auth::user()->id;
                            $Imm = Auth::user()->Im;
                            $Prizm = Auth::user()->Priz;
                            $email = Auth::user()->email;
                            $Nameg="$Imm $Prizm";
                            $ip = getenv('REMOTE_ADDR');

                            $aff2 = DB::table('Fotop')->insert(['Num' => $id, 'avt' => $id, 'Namef' => $Namef,
                                'Lenf' => $Lenf, 'w'=> $w_bd, 'h'=> $h_bd, 'Formf' => 'jpg','album' => $album, 'Fd' => $Fd,
                                'ip' => $ip, 'Sh' => $Sh, 'Face' => '0', 'Publ' => '0', 'Coment' => '2']);

                            $show_news = Auth::user()->show_news;
                            if (!$show_news) {
                                $nfoto = 1;
                            } else {
                                $nfoto = substr($show_news, 2, 1);
                            }
                            if($nfoto==1 && $Sh!=4){
                                $main_page=0;
                                if($Sh==2){$main_page=2;} if($Sh>2){$main_page=3;}

                                $sexm = Auth::user()->sex;
                                $mail_admin = Auth::user()->email;
                                if(!$sexm){$sexm=0;}
                                $katalogb = "Fotop/$katd/$Namef.jpg";
                                $katalogface=Storage::disk('public')->url($katalogb);

								$my_domen = $_SERVER['SERVER_NAME'];
								$avheight = "auto";
								if($my_domen=="1ua.com.ua"){
									$imageInfo = getimagesize($katalogface);
									if ($imageInfo) {
										$avheight = $imageInfo[1] / 2;
									}
								}

                                $ualine="<a href=## onclick=abfp('$id','$Namef')><div class=\"scale\"><img width=\"100\" height=\"$avheight\" alt=\"$album\" loading=\"lazy\" SRC=$katalogface></div></a>";

                                $theme="fotop#&~$domen#&~$album";

                                DB::table('News')->insert(['act' => 'nfoto', 'Im' => $Imm, 'Priz' => $Prizm,
                                    'sex' => $sexm, 'ualine' => $ualine, 'theme' => $theme, 'avt' => $Numm,
                                    'Nd' => $Fd, 'main_page' => $main_page]);

                                $theme = "$Nameg - нові фото";
                                $mailput = "fotolist$id";
                                $q_s1[0] = ['foto', 1];
                                $q_s2[0] = ['foto', 1];
                                $q_s3[0] = ['foto', 1];

                                $filename = "sixhours.txt";
                                $truestat_file_contents = Storage::disk('public')->get($filename);
                                $lastmail = strstr($truestat_file_contents, $mailput);

                                if ($lastmail == "") {
                                    $q_s2[0] = ['foto', 2];
                                    Storage::disk('public')->append($filename, $mailput);
                                }

                                $filename = "oneday.txt";
                                $truestat_file_contents = Storage::disk('public')->get($filename);
                                $lastmail = strstr($truestat_file_contents, $mailput);

                                if ($lastmail == "") {
                                    $q_s3[0] = ['foto', 3];
                                    Storage::disk('public')->append($filename, $mailput);
                                }

                                $Allm = DB::table('Mailpost')
                                    ->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3) {
                                        $query->whereNull('foto')
                                            ->orWhere($q_s1)
                                            ->orWhere($q_s2)
                                            ->orWhere($q_s3);
                                    })
                                    ->where('Nump', $id)
                                    ->select('Pmail')
                                    ->get();

                                foreach ($Allm as $Alm) {

                                    $Pmail = trim($Alm->Pmail);
                                    if($mail_admin != $Pmail){
                                        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {

                                            $details['email'] = $Pmail;
                                            $details['subject'] = "$Nameg - нові фото";
                                            $details['Nameg'] = $Nameg;
                                            $details['blade'] = "emails.user_fotos";
                                            $details['det'] = array('theme' => $theme, 'id' => $id, 'Nameg' => $Nameg, 'domen' => $domen, 'email' => $Pmail);
                                            $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                                            dispatch(new App\Jobs\SendEmailJob($details));
                                        }
                                    }
                                }
                            }

                            // echo "успішно id $id Lenf $Lenf x $x y $y w $w h $h "; //

                        } // Lenf нема в базі
                    } // if ($request->hasFile($my_f)) {
                } // for ($x = 0; $x < $request->TotalFiles; $x++) {

                $dfiles = Storage::disk('public')->files('tmp');
                foreach ($dfiles as $dfile) {
                    Storage::disk('public')->delete($dfile);
                }

                if($aff2){

                $pagego = "$domen/foto/$lan/$album";
                echo "<html><head><meta http-equiv='refresh' content='0; url=/$pagego'></head></html>";

                }
            } // else { умови бану
        } // if(Auth::user()) {
    } // public function load_foto





    public function load_obl_news(Request $request)
    {

        $validatedData = $request->validate([
            'files' => 'required'
        ]);
        $tt = $request->TotalFiles;

        for ($xf = 0; $xf < $request->TotalFiles; $xf++) {
            $my_f = "files$xf";

            if ($request->hasFile($my_f)) {


                $image = $request->file($my_f);
                // $image_resize = Image::make($image->getRealPath());
                $name = $image->getClientOriginalName();

                $path = Storage::putFileAs('public/obl_news', $image, $name);
                if($path){echo" $name <br />";}
            } //

        } //

    } //




    public function load_map_village(Request $request)
    {

        $validatedData = $request->validate([
            'files' => 'required'
        ]);
        $tt = $request->TotalFiles;

        for ($xf = 0; $xf < $request->TotalFiles; $xf++) {
            $my_f = "files$xf";

            if ($request->hasFile($my_f)) {


                $image = $request->file($my_f);
                // $image_resize = Image::make($image->getRealPath());
                $name = $image->getClientOriginalName();

                $path = Storage::putFileAs('public/karta', $image, $name);
                if($path){echo" $name <br />";}
            } //
        } //
    } //

    function mrec(Request $request)
    {
        $id = $request['id'];
        $x = $request['x'];
        $y = $request['y'];
        $z = $request['z'];
        DB::table('Allcities')
            ->where('id', $id)
            ->update(['x' => $x, 'y' => $y, 'z' => $z]);
    }

    function m_no_rec(Request $request)
    {
        $id = $request['id'];

         $aff = DB::table('Allcities')
            ->where('id', $id)
            ->update(['vol_karta2' => '3']);
        if($aff){echo"m_no_rec $id";}
    }



    // Виключення фото з добірки на головній сторінці (hero). Доступно адміну (id 72372396)
    // або автору самого фото — бо автоматичний відбір за рейтингом/переглядами іноді підхоплює
    // фото не в тему (портрети людей тощо), і автор має право прибрати саме своє фото.
    function hero_hide_foto(Request $request)
    {
        if (!Auth::user()) {
            return "";
        }

        $Namef = (int) $request['Namef'];
        if ($Namef <= 0) {
            return "";
        }

        $myId = Auth::user()->id;
        if ($myId != 72372396) {
            $avt = DB::table('Foto')->where('Namef', $Namef)->value('avt');
            if ($avt === null || $myId != $avt) {
                return "";
            }
        }

        $filename = storage_path('app/public/hero_excluded_photos.txt');
        $existing = file_exists($filename) ? file_get_contents($filename) : "";
        $ids = array_filter(explode(',', $existing));
        if (!in_array((string)$Namef, $ids)) {
            $ids[] = (string)$Namef;
            file_put_contents($filename, implode(',', $ids));
        }

        // добірки на головній (era-pool і trending) генеруються командою hero_build раз на добу
        // за розкладом; тут ставимо перезапуск у чергу (database queue, воркер уже працює), щоб
        // виключення підхопилось найближчим часом, а сам клік не чекав ~5с на повний перерахунок.
        // poolOnly=true: знімок/cooldown "найпопулярніше за добу" НЕ чіпаємо (інакше кожен клік
        // на "прибрати фото" збивав би годинник приросту переглядів) — приховане фото просто
        // вирізається з уже готового списку трендів, а сам тренд перезбирається лише за розкладом.
        \App\Jobs\RebuildHeroDataJob::dispatch(true);

        return "ok";
    }

    function del_foto(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }


        $Allb = DB::table('Foto')->select('id','avt','Fd','Formf')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {
            $id = $All->id; $avt = $All->avt; $M6 = $All->Fd;
            $M7 = $All->Formf;
        }

        $filename = "storage/oneday.txt";
        $whattoread = @fopen($filename, "r");
        $truestat_file_contents = fread($whattoread, filesize($filename));
        fclose($whattoread);
        $mailput = "f_del$id";

        if(substr_count($truestat_file_contents,$mailput)>10){
            $ch_e = __('messages.del_alert_lot');
            echo "<div style=\"max-width: 180px; margin: 8px 8px 8px 8px; \">
               <br /> <b>$ch_e</b>  </div><br />";
        }
        else{

            $newfile = @fopen($filename, "a");
            @fwrite($newfile, $mailput);
            fclose($newfile);


            $admpass = "off";
            $my_id = 0;
            if (Auth::user()) {
                $my_id = Auth::user()->Num;
                $Allad = DB::table('City_Admin2')->select('id')->
                where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
                limit(1)->get();
                $Alladn = $Allad->count();
                if ($Alladn > 0) {
                    $admpass = "ok";
                }
            }

            if ($admpass == "ok" || $my_id ==$avt || $my_id=="72372396") {

                $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
                if ($monm<10){$monmf = substr($M6, 6, 1);}
                else{$monmf=$monm;}
                if($yem<=2007){$yem = "2005-2007"; $monmf="";}
                $fdel = "/Photos/$yem$monmf/s$Namef.$M7";
                $affected1 = Storage::disk('public')->delete($fdel);
                $fdel = "/Photos/$yem$monmf/$Namef.$M7";
                $affected2 = Storage::disk('public')->delete($fdel);
                $fdel = "/Photos/$yem$monmf/b$Namef.$M7";
                $affected3 = Storage::disk('public')->delete($fdel);

                $affected4 = DB::table('Foto')->where('Namef', $Namef)->delete();
                DB::table('Memoryf')->where('Num', $Namef)->delete();
                $theme_news="c$Namef";
                $like_s = "%$Namef%";
                DB::table('News')->where('act', 'ncoment')->where('theme', $theme_news)->delete();
                DB::table('News')->where('act', 'nfoto')->where('ualine', 'like', $like_s)->delete();
                DB::table('News')->where('act', 'nratef')->where('ualine', 'like', $like_s)->delete();

                if ($affected1 && $affected2 && $affected3 && $affected4) {
                    $ch_e = __('messages.del_foto');
                    echo "<div style=\"max-width: 160px; margin: 8px 8px 8px 8px; \">
                   <br /> <b>$ch_e</b>  </div><br />";
                }

            }
        }
    }






    function del_fotop(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }

        $Allb = DB::table('Fotop')->select('Num','avt','Fd','Formf')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {
            $id = $All->Num; $avt = $All->avt; $M6 = $All->Fd;
            $M7 = $All->Formf;
        }

        $my_id = 0;
        if (Auth::user()) {
            $my_id = Auth::user()->Num;
        }

        $filename = "storage/oneday.txt";
        $whattoread = @fopen($filename, "r");
        $truestat_file_contents = fread($whattoread, filesize($filename));
        fclose($whattoread);
        $mailput = "f_del$id";

        if(substr_count($truestat_file_contents,$mailput)>10){
            $ch_e = __('messages.del_alert_lot');
            echo "<div style=\"max-width: 180px; margin: 8px 8px 8px 8px; \">
               <br /> <b>$ch_e</b>  </div><br />";
        }
        else {

            $newfile = @fopen($filename, "a");
            @fwrite($newfile, $mailput);
            fclose($newfile);


            if ($my_id == $id || $my_id == $avt || $my_id == "72372396") {

                $monm = substr($M6, 5, 2);
                $yem = substr($M6, 0, 4);
                if ($monm < 10) {
                    $monmf = substr($M6, 6, 1);
                } else {
                    $monmf = $monm;
                }
                if ($yem <= 2007) {
                    $yem = "2005-2007";
                    $monmf = "";
                }
                $fdel = "Fotop/$yem$monmf/s$Namef.$M7";
                $affected1 = Storage::disk('public')->delete($fdel);
                $fdel = "Fotop/$yem$monmf/$Namef.$M7";
                $affected2 = Storage::disk('public')->delete($fdel);
                $fdel = "Fotop/$yem$monmf/b$Namef.$M7";
                $affected3 = Storage::disk('public')->delete($fdel);

                $affected4 = DB::table('Fotop')->where('Namef', $Namef)->delete();
                DB::table('Memoryfp')->where('Num', $Namef)->delete();
                $theme_news = "p$Namef";
                $like_s = "%$Namef%";
                DB::table('News')->where('act', 'ncoment')->where('theme', $theme_news)->delete();
                DB::table('News')->where('act', 'nfoto')->where('ualine', 'like', $like_s)->delete();
                DB::table('News')->where('act', 'nratef')->where('ualine', 'like', $like_s)->delete();

                if ($affected1 && $affected2 && $affected3 && $affected4) {
                    $ch_e = __('messages.del_foto');
                    echo "<div style=\"max-width: 160px; margin: 8px 8px 8px 8px; \">
                   <br /> <b>$ch_e</b>  </div><br />";
                }

            }
        }
    }









    function del_alb(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }

        $Allb = DB::table('Foto')->select('id','album')->
        where('Namef', $Namef)->limit(1)->get();
        foreach ($Allb as $All) {
            $id = $All->id; $album = $All->album;
        }

        $admpass = "off";
        $my_id = 0;
        if (Auth::user()) {
            $my_id = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if ($Alladn > 0) {
                $admpass = "ok";
            }
        }

        if ($admpass == "ok" || $my_id == "72372396") {

            $Allb = DB::table('Foto')->select('Namef','Fd','Formf')->
            where('id', $id)->where('album', $album)->get();
            $Allbn = $Allb->count();

            if($Allbn>20 && $my_id != "72372396"){

                $ch_e = __('messages.del_alert_alb');
                echo "<div style=\"max-width: 160px; margin: 8px 8px 8px 8px; \">
                   <br /> <b>$ch_e</b>  </div><br />";

                $details['email'] = "sirov@ukr.net";
                $details['subject'] = "Delete $album";
                $details['blade'] = "emails.delete_fotos";
                $details['det'] = array('id' => $id, 'album' => $album);
                $details['unsub'] = "<sirov@ukr.net>, <https://1ua.com.ua/unsubscribe/sirov@ukr.net/$id>";
                dispatch(new App\Jobs\SendEmailJob($details));
            }
            else{

                foreach ($Allb as $All) {

                    $Namef = $All->Namef;
                    $M7 = $All->Formf;
                    $M6 = $All->Fd;

                    $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
                    if ($monm<10){$monmf = substr($M6, 6, 1);}
                    else{$monmf=$monm;}
                    if($yem<=2007){$yem = "2005-2007"; $monmf="";}
                    $fdel = "/Photos/$yem$monmf/s$Namef.$M7";
                    $affected1 = Storage::disk('public')->delete($fdel);
                    $fdel = "/Photos/$yem$monmf/$Namef.$M7";
                    $affected2 = Storage::disk('public')->delete($fdel);
                    $fdel = "/Photos/$yem$monmf/b$Namef.$M7";
                    $affected3 = Storage::disk('public')->delete($fdel);

                    $affected4 = DB::table('Foto')->where('Namef', $Namef)->delete();
                    DB::table('Memoryf')->where('Num', $Namef)->delete();
                    $theme_news="c$Namef";
                    $like_s = "%$Namef%";
                    DB::table('News')->where('act', 'ncoment')->where('theme', $theme_news)->delete();
                    DB::table('News')->where('act', 'nfoto')->where('ualine', 'like', $like_s)->delete();
                    DB::table('News')->where('act', 'nratef')->where('ualine', 'like', $like_s)->delete();

                }

                if ($affected1 && $affected2 && $affected3 && $affected4) {
                    $ch_e = __('messages.del_alb');
                    echo "<div style=\"max-width: 160px; margin: 8px 8px 8px 8px; \">
                       <br /> <b>$ch_e</b>  </div><br />";
                }

            }
        }
    }





    function del_albp(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }

        $Allb = DB::table('Fotop')->select('Num','album')->
        where('Namef', $Namef)->limit(1)->get();

        foreach ($Allb as $All) {
            $id = $All->Num; $album = $All->album;
        }

        $my_id = 0;
        if (Auth::user()) {
            $my_id = Auth::user()->Num;
        }

        if ($my_id == $id || $my_id == "72372396") {

            $Allb = DB::table('Fotop')->select('Namef','Fd','Formf')->
            where('Num', $id)->where('album', $album)->get();
            $Allbn = $Allb->count();

            if($Allbn>20 && $my_id != "72372396"){

                $ch_e = __('messages.del_alert_alb');
                echo "<div style=\"max-width: 160px; margin: 8px 8px 8px 8px; \">
                   <br /> <b>$ch_e</b>  </div><br />";

                $details['email'] = "sirov@ukr.net";
                $details['subject'] = "Delete $album";
                $details['blade'] = "emails.delete_fotos";
                $details['det'] = array('id' => $id, 'album' => $album);
                $details['unsub'] = "<sirov@ukr.net>, <https://1ua.com.ua/unsubscribe/sirov@ukr.net/$id>";
                dispatch(new App\Jobs\SendEmailJob($details));
            }
            else{
                foreach ($Allb as $All) {

                    $Namef = $All->Namef;
                    $M7 = $All->Formf;
                    $M6 = $All->Fd;

                    $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
                    if ($monm<10){$monmf = substr($M6, 6, 1);}
                    else{$monmf=$monm;}
                    if($yem<=2007){$yem = "2005-2007"; $monmf="";}
                    $fdel = "Fotop/$yem$monmf/s$Namef.$M7";
                    $affected1 = Storage::disk('public')->delete($fdel);
                    $fdel = "Fotop/$yem$monmf/$Namef.$M7";
                    $affected2 = Storage::disk('public')->delete($fdel);
                    $fdel = "Fotop/$yem$monmf/b$Namef.$M7";
                    $affected3 = Storage::disk('public')->delete($fdel);

                    $affected4 = DB::table('Fotop')->where('Namef', $Namef)->delete();
                    DB::table('Memoryfp')->where('Num', $Namef)->delete();
                    $theme_news="p$Namef";
                    $like_s = "%$Namef%";
                    DB::table('News')->where('act', 'ncoment')->where('theme', $theme_news)->delete();
                    DB::table('News')->where('act', 'nfoto')->where('ualine', 'like', $like_s)->delete();
                    DB::table('News')->where('act', 'nratef')->where('ualine', 'like', $like_s)->delete();

                }
                if ( $affected1 && $affected2 && $affected3 && $affected4) {
                    $ch_e = __('messages.del_alb');
                    echo "<div style=\"max-width: 160px; margin: 8px 8px 8px 8px; \">
                       <br /> <b>$ch_e</b>  </div><br />";
                }
            }
        }
    }







    function fview(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }
        $pc = $request['pc'];
        $views = $request['views'];
        $views = $views+1;
        $affected = "";
        $memory_contents = Storage::disk('public')->get('delseeffile.txt');
        if (strstr($memory_contents,"$pc$Namef")==""){
                $memory_contents.="$pc$Namef";

            Storage::disk('public')->put('delseeffile.txt', $memory_contents);

            if($pc=="p"){
                DB::table('Fotop')->where('Namef', $Namef)->increment('views', 1);
            }
            if($pc=="c"){
                DB::table('Foto')->where('Namef', $Namef)->increment('views', 1);
            }

        }
        $view = __('messages.views');
        echo"<svg title='$view' alt='$view' width=\"18\" height=\"18\"><use href=\"/images/icons.svg#icon-magnifying-glass\"></use></svg>
         <b>$views</b>";

    }






    function rate_add(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1; $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {die("");}
        $design = $request['rate'];
        $rate = 5;
        $lan = __('messages.lan');

        if (Auth::user()) {

            $Allb = DB::table('Foto')->select('id','r_gol','r_kol','avt','Fd','Formf','rh')->
            where('Namef', $Namef)->limit(1)->get();

            foreach ($Allb as $All) {
                $id = $All->id; $r_gol = $All->r_gol; $r_kol = $All->r_kol; $avt = $All->avt; $Fd = $All->Fd;
                $Formf = $All->Formf; $rh = $All->rh; $whom = $avt;
            }

            if($lan == "en"){$pr="e";}
            else if($lan == "ru"){$pr="r";}
            else{$pr="";}

            $prlink = $pr; $prlink.="nf"; $prlink.=$Namef;
            $Numm = Auth::user()->id;
            $sq=0;
            $Allq = DB::table('Private')->select('ban')->
            where('Num', $whom)->limit(1)->get();
            foreach ($Allq as $Alq) {$ComForBan=$Alq->ban; $sq++; }
            if($sq==0){ $ComForBan = "";}
            if(mb_strstr((string)$ComForBan, (string)$Numm)=="") {

                // у popup (клік по зірці в модальному вікні перегляду фото) кнопки "поділитись
                // в соцмережах" зайві й виглядають як накладка — показуємо коротке повідомлення
                // без згадки про соцмережі замість звичайного тексту + iconок "поділитись"
                $sharing = ($design == 'popup') ? '' : sharing($Namef, $design, 'nf');

                if($Numm==$avt){
                    $ch_e = ($design == 'popup') ? __('messages.mark_own_popup') : __('messages.mark_own');
                    echo "<span style='font-size: 13px;'>$ch_e </span> $sharing  ";
                }
                else{
                    if(mb_strstr((string)$rh, (string)$Numm)!="") {
                        $ch_e = ($design == 'popup') ? __('messages.mark_once_popup') : __('messages.mark_once');
                        echo "<span style='font-size: 13px;'> $ch_e </span> $sharing ";
                    }
                    else{
                        $rhn=$rh.=":*$Numm*$rate";
                        $Newr_gol = $r_gol + $rate; $Newr_kol = $r_kol+1; $rr=round($Newr_gol/$Newr_kol);
                        $affected = DB::table('Foto')
                            ->where('Namef', $Namef)
                            ->update(['r_gol' => $Newr_gol, 'r_kol' => $Newr_kol, 'rh' => $rhn]);

                        if($affected){

                            $sexm = Auth::user()->sex;
                            $Imm = Auth::user()->Im;
                            $Prizm = Auth::user()->Priz;
                            $Num_am = Auth::user()->avatar;
                            if ((!$Num_am) || $Num_am < 10) {
                                $Num_am = 7;
                            }
                            if(!$sexm){$sexm=0;}

                            $yem = substr($Fd, 0, 4);
                            $monm = substr($Fd, 5, 2);
                            if ($monm<10){$monmf = substr($Fd, 6, 1);}
                            else{$monmf=$monm;}
                            if($yem<=2007){$yem = "2005-2007"; $monmf="";}


                            $katalog = "Photos/$yem$monmf/$Namef.$Formf";
                            $katalogface = getKatalog($katalog);

                            $show_news = Auth::user()->show_news;
                            if (!$show_news) {
                                $nratef = 1;
                            } else {
                                $nratef=substr($show_news, 4, 1);
                            }
                            if($nratef==1) {

                                $ualine="<a href=## onclick=abf('$id','$Namef')><img width='100' loading=\"lazy\" SRC=$katalogface></a>";
                                $Nd = date('Y-n-j-H-i');

                                DB::table('News')->insert(['act' => 'nratef', 'Im' => $Imm, 'Priz' => $Prizm,
                                    'sex' => $sexm, 'ualine' => $ualine, 'theme' => $rate, 'avt' => $Numm, 'whom' => $whom,
                                    'Nd' => $Nd]);

                            }


                            if($avt>0){

                                $lv0 = last_visit_read($avt);
                                $lan_user = $lv0['lang'] ?? "ua";
                                $t = last_visit_ts_diff($lv0);
                                if ($t <= 50000) {

                                    if($rate>=1){$star1="on";}else{$star1="off";}
                                    if($rate>=2){$star2="on";}else{$star2="off";}
                                    if($rate>=3){$star3="on";}else{$star3="off";}
                                    if($rate>=4){$star4="on";}else{$star4="off";}
                                    if($rate>=5){$star5="on";}else{$star5="off";}
                                    if ($lan_user == "ua") {
                                        $qu_in = "";
                                    }
                                    if ($lan_user == "ru") {
                                        $qu_in = "r";
                                    }
                                    if ($lan_user == "en") {
                                        $qu_in = "e";
                                    }
                                    $prlink2 = $qu_in; $prlink2.="nf"; $prlink2.=$Namef;
                                    $prlink3  = avt($Numm,$Numm);
                                    $prlink3 = str_replace("scale", "", $prlink3);
                                    $prlink3 = str_replace("av-shadow", "", $prlink3);

                                    $r_else="<table><tr><td width=100 valign=top align=right>
                                        <table>
                                        <tr><td><a href=/$prlink2><img border=0 width=100 SRC=\"$katalogface\" align=left></a></td></tr>
                                        <tr><td align=right>

                                        <img src=\"/$star1.png\" border=0><img src=\"/$star2.png\" border=0><img src=\"/$star3.png\" border=0><img src=\"/$star4.png\" border=0><img src=\"/$star5.png\" border=0>

                                        </td></tr>
                                        </table>
                                        </td>
                                        <td valign=top>
                                        $prlink3
                                        </td></tr></table>";

                                    \Illuminate\Support\Facades\Redis::lpush("notice:$avt", $r_else);
                                }


                                $Allq = DB::table('users')->select('frating', 'email')->
                                where('id', $avt)->limit(1)->get();
                                foreach ($Allq as $Alq) {
                                    $frating = $Alq->frating;
                                    $emailu = $Alq->email;
                                }

                                $mailgo = "off";
                                $mailput = "frating$avt";
                                if (!$frating || $frating == 0) {
                                    $frating = 1;
                                }
                                if ($frating == 1) {

                                    $filename = "storage/sixhours.txt";
                                    $whattoread = @fopen($filename, "r");
                                    $truestat_file_contents = fread($whattoread, filesize($filename));
                                    fclose($whattoread);
                                    $lastmail = strstr($truestat_file_contents, $mailput);

                                    if ($lastmail == "") {
                                        $mailgo = "on";
                                        $newfile = @fopen($filename, "a");
                                        @fwrite($newfile, $mailput);
                                        fclose($newfile);
                                    }
                                }
                                else if ($frating == 2) {

                                    $filename = "storage/oneday.txt";
                                    $whattoread = @fopen($filename, "r");
                                    $truestat_file_contents = fread($whattoread, filesize($filename));
                                    fclose($whattoread);

                                    $lastmail = strstr($truestat_file_contents, $mailput);

                                    if ($lastmail == "") {
                                        $mailgo = "on";
                                        $newfile = @fopen($filename, "a");
                                        @fwrite($newfile, $mailput);
                                        fclose($newfile);
                                    }
                                }



                                if ($mailgo == "on") {
                                    if ($lan_user == "ua") {
                                        if($sexm==1){$sexm_e1="поставив"; $sexm_e2="змінив";}
                                        else if($sexm==2){$sexm_e1="поставила"; $sexm_e2="змінила";}
                                        else{$sexm_e1="поставив (ла)"; $sexm_e2="змінив (ла)";}
                                        $subj = "$Imm $Prizm $sexm_e1 оцінку Вашій фотографії...";
                                        $blade = "emails.foto_mark";
                                    }
                                    if ($lan_user == "ru") {
                                        if($sexm==1){$sexm_e1="поставил"; $sexm_e2="изменил";}
                                        else if($sexm==2){$sexm_e1="поставила"; $sexm_e2="изменила";}
                                        else{$sexm_e1="поставил (ла)"; $sexm_e2="изменил (ла)";}
                                        $subj = "$Imm $Prizm $sexm_e1 оценку Вашей фотографии...";
                                        $blade = "emails.rfoto_mark";
                                    }
                                    if ($lan_user == "en") {
                                        $subj = "$Imm $Prizm put an assessment of Your photo...";
                                        $sexm_e1 = "";
                                        $sexm_e2 = "";
                                        $blade = "emails.efoto_mark";
                                    }

                                    if (filter_var($emailu, FILTER_VALIDATE_EMAIL)) {
                                        $Nameg = "$Imm $Prizm";
                                        $details['email'] = trim($emailu);
                                        $details['subject'] = $subj;
                                        $details['blade'] = $blade;
                                        $details['det'] = array('Namef' => $Namef, 'Nameg' => $Nameg, 'sexm_e2' => $sexm_e2);
                                        $details['unsub'] = "";
                                        dispatch(new App\Jobs\SendEmailJob($details));
                                    }
                                }

                            }



                            $r_gol=$Newr_gol; $r_kol=$Newr_kol;
                            $r_gol2=round($r_gol/$r_kol,2); $r_gol=round($r_gol/$r_kol);
                            if($r_gol>0.5){$star1="on";}else{$star1="off";}
                            if($r_gol>1.5){$star2="on";}else{$star2="off";}
                            if($r_gol>2.5){$star3="on";}else{$star3="off";}
                            if($r_gol>3.5){$star4="on";}else{$star4="off";}
                            if($r_gol>4.5){$star5="on"; $star55="onm";}else{$star5="off"; $star55="offm";}

                            $color_star = "#356AA0";
                            if($r_kol>1){$color_star = "gold";}
                            if($r_kol>4){$color_star = "orange";}
                            $p_size = 18;
                            if($design == "alone"){$p_size = 24;}
                            echo"<a onclick=rate_h('r$Namef',$Namef)>
                                <svg class=\"star-container\" width=\"$p_size\" height=\"$p_size\">
                                  <use class=\"star\" fill=\"$color_star\" href=\"/images/icons.svg#icon-star-full\"></use>
                                </svg></a>
                                <a onclick=rate_h('r$Namef',$Namef)><b>$r_kol</b>
                             ";

                        }
                    }
                }
            }
            else{
                $ch_e = __('messages.mark_ban');
                echo "<div> $ch_e  </div>";
            }
        }
        else{
            $ch_e = __('messages.mark_need_reg');
            echo "<div> $ch_e  </div>";
        }
    }






    function rate_addp(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1; $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {die("");}
        $design = $request['rate'];
        $rate = 5;
        $lan = __('messages.lan');

        if (Auth::user()) {

            $Allb = DB::table('Fotop')->select('Num','r_gol','r_kol','avt','Fd','Formf','rh','Sh')->
            where('Namef', $Namef)->limit(1)->get();

            foreach ($Allb as $All) {
                $id = $All->Num; $r_gol = $All->r_gol; $r_kol = $All->r_kol; $avt = $All->avt; $Fd = $All->Fd;
                $Formf = $All->Formf; $rh = $All->rh; $Newsratefp = $All->Sh; $whom = $avt;
            }


            $Numm = Auth::user()->id;
            $sq=0;
            $Allq = DB::table('Private')->select('ban')->
            where('Num', $whom)->limit(1)->get();
            foreach ($Allq as $Alq) {$ComForBan=$Alq->ban; $sq++; }
            if($sq==0){ $ComForBan = "";}
            if(mb_strstr((string)$ComForBan, (string)$Numm)=="") {

            // у popup (клік по зірці в модальному вікні перегляду фото) кнопки "поділитись
            // в соцмережах" зайві й виглядають як накладка — показуємо лише текстове повідомлення
            $sharing = ($design == 'popup') ? '' : sharing($Namef, $design, 'ni');

                if($Numm==$avt){
                    $ch_e = ($design == 'popup') ? __('messages.mark_own_popup') : __('messages.mark_own');
                    echo "<span style='font-size: 13px;'>$ch_e </span> $sharing  ";
                }
                else{
                    if(mb_strstr((string)$rh, (string)$Numm)!="") {
                        $ch_e = ($design == 'popup') ? __('messages.mark_once_popup') : __('messages.mark_once');
                        echo "<span style='font-size: 13px;'> $ch_e </span> $sharing ";
                    }
                    else{
                        $rhn=$rh.=":*$Numm*$rate";
                        $Newr_gol = $r_gol + $rate; $Newr_kol = $r_kol+1; $rr=round($Newr_gol/$Newr_kol);
                        $affected = DB::table('Fotop')
                            ->where('Namef', $Namef)
                            ->update(['r_gol' => $Newr_gol, 'r_kol' => $Newr_kol, 'rh' => $rhn]);

                        if($affected){

                            $sexm = Auth::user()->sex;
                            $Imm = Auth::user()->Im;
                            $Prizm = Auth::user()->Priz;
                            $Num_am = Auth::user()->avatar;
                            if ((!$Num_am) || $Num_am < 10) {
                                $Num_am = 7;
                            }
                            if(!$sexm){$sexm=0;}

                            $yem = substr($Fd, 0, 4);
                            $monm = substr($Fd, 5, 2);
                            if ($monm<10){$monmf = substr($Fd, 6, 1);}
                            else{$monmf=$monm;}
                            if($yem<=2007){$yem = "2005-2007"; $monmf="";}


                            $katalogb = "Fotop/$yem$monmf/$Namef.$Formf";
                            $katalogface=Storage::disk('public')->url($katalogb);

                            $show_news = Auth::user()->show_news;
                            if (!$show_news) {
                                $nratef = 1;
                            } else {
                                $nratef=substr($show_news, 4, 1);
                            }
                            if($Newsratefp==""){$Newsratefp=1;}

                            if($nratef==1&&$Newsratefp<3) {

                                if($Newsratefp==2){$main_page=2;}
                                $ualine="<a href=## onclick=abfp('$id','$Namef')><img loading=\"lazy\" width='100' SRC=$katalogface></a>";
                                $Nd = date('Y-n-j-H-i');

                                DB::table('News')->insert(['act' => 'nratef', 'Im' => $Imm, 'Priz' => $Prizm,
                                    'sex' => $sexm, 'ualine' => $ualine, 'theme' => $rate, 'avt' => $Numm, 'whom' => $whom,
                                    'Nd' => $Nd, 'main_page' => $Newsratefp]);

                            }



                            if($avt>0){

                                $lv0 = last_visit_read($avt);
                                $lan_user = $lv0['lang'] ?? "ua";
                                $t = last_visit_ts_diff($lv0);
                                if ($t <= 50000) {

                                    if($rate>=1){$star1="on";}else{$star1="off";}
                                    if($rate>=2){$star2="on";}else{$star2="off";}
                                    if($rate>=3){$star3="on";}else{$star3="off";}
                                    if($rate>=4){$star4="on";}else{$star4="off";}
                                    if($rate>=5){$star5="on";}else{$star5="off";}
                                    if ($lan_user == "ua") {
                                        $qu_in = "";
                                    }
                                    if ($lan_user == "ru") {
                                        $qu_in = "r";
                                    }
                                    if ($lan_user == "en") {
                                        $qu_in = "e";
                                    }
                                    $prlink2 = $qu_in; $prlink2.="ni"; $prlink2.=$Namef;
                                    $prlink3  = avt($Numm,$Numm);
                                    $prlink3 = str_replace("scale", "", $prlink3);
                                    $prlink3 = str_replace("av-shadow", "", $prlink3);

                                    $r_else="<table><tr><td width=100 valign=top align=right>
                                        <table>
                                        <tr><td><a href=/$prlink2><img border=0 width=100 SRC=\"$katalogface\" align=left></a></td></tr>
                                        <tr><td align=right>

                                        <img src=\"/$star1.png\" border=0><img src=\"/$star2.png\" border=0><img src=\"/$star3.png\" border=0><img src=\"/$star4.png\" border=0><img src=\"/$star5.png\" border=0>

                                        </td></tr>
                                        </table>
                                        </td>
                                        <td valign=top>
                                        $prlink3
                                        </td></tr></table>";

                                    \Illuminate\Support\Facades\Redis::lpush("notice:$avt", $r_else);
                                }



                                $Allq = DB::table('users')->select('frating', 'email')->
                                where('id', $avt)->limit(1)->get();
                                foreach ($Allq as $Alq) {
                                    $frating = $Alq->frating;
                                    $emailu = $Alq->email;
                                }

                                $mailgo = "off";
                                $mailput = "frating$avt";
                                if (!$frating || $frating == 0) {
                                    $frating = 1;
                                }
                                if ($frating == 1) {

                                    $filename = "storage/sixhours.txt";
                                    $whattoread = @fopen($filename, "r");
                                    $truestat_file_contents = fread($whattoread, filesize($filename));
                                    fclose($whattoread);
                                    $lastmail = strstr($truestat_file_contents, $mailput);

                                    if ($lastmail == "") {
                                        $mailgo = "on";
                                        $newfile = @fopen($filename, "a");
                                        @fwrite($newfile, $mailput);
                                        fclose($newfile);
                                    }
                                }
                                else if ($frating == 2) {

                                    $filename = "storage/oneday.txt";
                                    $whattoread = @fopen($filename, "r");
                                    $truestat_file_contents = fread($whattoread, filesize($filename));
                                    fclose($whattoread);

                                    $lastmail = strstr($truestat_file_contents, $mailput);

                                    if ($lastmail == "") {
                                        $mailgo = "on";
                                        $newfile = @fopen($filename, "a");
                                        @fwrite($newfile, $mailput);
                                        fclose($newfile);
                                    }
                                }



                                if ($mailgo == "on") {
                                    if ($lan_user == "ua") {
                                        if($sexm==1){$sexm_e1="поставив"; $sexm_e2="змінив";}
                                        else if($sexm==2){$sexm_e1="поставила"; $sexm_e2="змінила";}
                                        else{$sexm_e1="поставив (ла)"; $sexm_e2="змінив (ла)";}
                                        $subj = "$Imm $Prizm $sexm_e1 оцінку Вашій фотографії...";
                                        $blade = "emails.fotop_mark";
                                    }
                                    if ($lan_user == "ru") {
                                        if($sexm==1){$sexm_e1="поставил"; $sexm_e2="изменил";}
                                        else if($sexm==2){$sexm_e1="поставила"; $sexm_e2="изменила";}
                                        else{$sexm_e1="поставил (ла)"; $sexm_e2="изменил (ла)";}
                                        $subj = "$Imm $Prizm $sexm_e1 оценку Вашей фотографии...";
                                        $blade = "emails.rfotop_mark";
                                    }
                                    if ($lan_user == "en") {
                                        $subj = "$Imm $Prizm put an assessment of Your photo...";
                                        $sexm_e1 = "";
                                        $sexm_e2 = "";
                                        $blade = "emails.efotop_mark";
                                    }
                                    if (filter_var($emailu, FILTER_VALIDATE_EMAIL)) {
                                        $Nameg = "$Imm $Prizm";
                                        $details['email'] = trim($emailu);
                                        $details['subject'] = $subj;
                                        $details['blade'] = $blade;
                                        $details['det'] = array('Namef' => $Namef, 'Nameg' => $Nameg, 'sexm_e2' => $sexm_e2);
                                        $details['unsub'] = "";
                                        dispatch(new App\Jobs\SendEmailJob($details));
                                    }
                                }


                            }


                            $r_gol=$Newr_gol; $r_kol=$Newr_kol;
                            $r_gol2=round($r_gol/$r_kol,2); $r_gol=round($r_gol/$r_kol);
                            if($r_gol>0.5){$star1="on";}else{$star1="off";}
                            if($r_gol>1.5){$star2="on";}else{$star2="off";}
                            if($r_gol>2.5){$star3="on";}else{$star3="off";}
                            if($r_gol>3.5){$star4="on";}else{$star4="off";}
                            if($r_gol>4.5){$star5="on"; $star55="onm";}else{$star5="off"; $star55="offm";}

                            $color_star = "#356AA0";
                            if($r_kol>1){$color_star = "gold";}
                            if($r_kol>4){$color_star = "orange";}
                            $p_size = 18;
                            if($design == "alone"){$p_size = 24;}
                            echo"<a onclick=rate_hp('r$Namef',$Namef)>
                                <svg class=\"star-container\" width=\"$p_size\" height=\"$p_size\">
                                  <use class=\"star\" fill=\"$color_star\" href=\"/images/icons.svg#icon-star-full\"></use>
                                </svg></a>
                                <a onclick=rate_hp('r$Namef',$Namef)><b>$r_kol</b>
                             ";
                        }
                    }
                }
            }
            else{
                $ch_e = __('messages.mark_ban');
                echo "<div> $ch_e  </div>";
            }
        }
        else{
            $ch_e = __('messages.mark_need_reg');
            echo "<div> $ch_e  </div>";
        }

    }







    function rate_h(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1; $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {die("");}

        if (Auth::user()) {
            $Numm = Auth::user()->id;
		}
		else{$Numm = 999999;}

        $Allb = DB::table('Foto')->select('rh')->
        where('Namef', $Namef)->limit(1)->get();

        foreach ($Allb as $All) {
            $rh = $All->rh;
        }

        $n=substr_count($rh, ':');
        if($n>0){
            echo "<div style='display: flex; gap: 5px; align-items: center; justify-content: center; flex-wrap: wrap; padding: 7px; margin: 0 auto;'>";
            $v_page = explode(":", $rh);

            for($a=1; $a<=$n; $a++){

                $page=$v_page[$a];
                $page = explode("*", $page);

                $avt=$page[1]; $rate=$page[2];

                $avt_e  = avt($avt,$Numm);
                echo "<div style=\"border: 1px solid; padding: 5px; width: 160px;\">$avt_e </div>";

            }
             echo "</div>";
        }

        else{
            $ch_e = __('messages.mark_history');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }

    }





    function rate_hp(Request $request)
    {
        $Namef = $request['Namef'];
        $Namef = $Namef + 1; $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {die("");}

        if (Auth::user()) {
            $Numm = Auth::user()->id;
        }
        else{$Numm = 999999;}

        $Allb = DB::table('Fotop')->select('rh')->
        where('Namef', $Namef)->limit(1)->get();

        foreach ($Allb as $All) {
            $rh = $All->rh;
        }

        $n=substr_count($rh, ':');
        if($n>0){
            echo "<div style='display: flex; gap: 5px; align-items: center; justify-content: center; flex-wrap: wrap; padding: 7px; margin: 0 auto;'>";
            $v_page = explode(":", $rh);

            for($a=1; $a<=$n; $a++){

                $page=$v_page[$a];
                $page = explode("*", $page);

                $avt=$page[1]; $rate=$page[2];

                $avt_e  = avt($avt,$Numm);
                echo "<div style=\"border: 1px solid; padding: 5px; width: 160px;\">$avt_e </div>";

            }
            echo "</div>";
        }

        else{
            $ch_e = __('messages.mark_history');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }

    }




    function comm_add(Request $request)
    {
        $Namef = $request['M5'];
        $Aboutef = $request['Aboutef'];
        $Aboutef = getDescriptionAttribute($Aboutef);
        $Aboutef = nl2br($Aboutef);
        $Namef = $Namef + 1; $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {die("");}
        $abuse_ban = __('messages.abuse_ban');
        $lan = __('messages.lan');

        if(Auth::user()) {
            $ctrl_hss = $Aboutef;
            $my_id = Auth::user()->id;

            $ctrl_hss = htmlspecialchars_decode($ctrl_hss, ENT_QUOTES);
            $ctrl_hss = strip_tags($ctrl_hss); // Видаляє HTML

            if (preg_match("/<[^<]+>/", $ctrl_hss) && $my_id != 29724907) { exit; }

            $ctrl_hss2 = $ctrl_hss . ">";
            if (preg_match("/<[^<]+>/", $ctrl_hss2) && $my_id != 29724907) { exit; }

            $Aboutef = preg_replace_callback(
                '/(https?:\/\/[^\s<]+[^.,:;"\')\]\s<])/u',
                function ($matches) {
                    $url = $matches[0];
                    $shortUrl = (strlen($url) > 35) ? substr($url, 0, 35) . "..." : $url;


                    $urlParts = explode('/', rtrim($shortUrl, '/'));
                    $lastPart = array_pop($urlParts); // Остання частина URL
                    $boldUrl = implode('/', $urlParts) . '/<b>' . $lastPart . '</b>'; // Додаємо жирний стиль

                    return '<a target="_blank" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($boldUrl, ENT_QUOTES, 'UTF-8') . '</a>';
                },
                $ctrl_hss
            );

            $Aboutef = htmlspecialchars_decode($Aboutef, ENT_QUOTES);

            if (!$Aboutef) {
                $ask_err = __('messages.comm_err');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }
            else if (mb_strlen($Aboutef) > 500) {
                $ask_err = __('messages.ask_err2');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }

            else if (mb_strstr($Aboutef,"хуй")!=""||mb_strstr($Aboutef,"пизд")!=""||mb_strstr($Aboutef," конч")!=""||mb_strstr($Aboutef,"вафл")!=""||mb_strstr($Aboutef,"шлюх")!=""||mb_strstr($Aboutef,"fuck")!=""||mb_strstr($Aboutef," гом")!=""||mb_strstr($Aboutef," бля")!=""||mb_strstr($Aboutef," манд")!=""||mb_strstr($Aboutef,"член")!=""||mb_strstr($Aboutef," еба")!=""||mb_strstr($Aboutef," єба")!=""||mb_strstr($Aboutef,"суч")!=""||mb_strstr($Aboutef,"сук")!=""||mb_strstr($Aboutef,"дроч")!=""||mb_strstr($Aboutef," писк")!=""||mb_strstr($Aboutef," піськ")!=""||mb_strstr($Aboutef,"урод")!=""||mb_strstr($Aboutef,"ублюд")!=""||mb_strstr($Aboutef,"соса")!=""||mb_strstr($Aboutef,"соси")!=""||mb_strstr($Aboutef,"сран")!=""||mb_strstr($Aboutef,"срак")!=""||mb_strstr($Aboutef,"срат")!=""||mb_strstr($Aboutef,"хуев")!=""||mb_strstr($Aboutef,"костр")!=""||mb_strstr($Aboutef,"блев")!=""||mb_strstr($Aboutef,"яйц")!=""||mb_strstr($Aboutef," трах")!=""||mb_strstr($Aboutef,"влагал")!=""||mb_strstr($Aboutef," онан")!=""){

                $bad_words="<font color=red>";
                if (strstr($Aboutef,"хуй")!=""){$bad_words.=" хуй";}
                if (strstr($Aboutef,"пизд")!=""){$bad_words.=" пизд";}
                if (strstr($Aboutef,"сперм")!=""){$bad_words.=" сперм";}
                if (strstr($Aboutef,"шлюх")!=""){$bad_words.=" шлюх";}
                if (strstr($Aboutef,"гом")!=""){$bad_words.=" гом";}
                if (strstr($Aboutef,"бля")!=""){$bad_words.=" бля";}
                if (strstr($Aboutef,"еба")!=""){$bad_words.=" еба";}
                if (strstr($Aboutef,"єба")!=""){$bad_words.=" єба";}
                if (strstr($Aboutef,"сук")!=""){$bad_words.=" сукa";}
                if (strstr($Aboutef,"дроч")!=""){$bad_words.=" дроч";}
                if (strstr($Aboutef,"піськ")!=""){$bad_words.=" піськ";}
                if (strstr($Aboutef,"ублюд")!=""){$bad_words.=" ублюд";}
                if (strstr($Aboutef,"сран")!=""){$bad_words.=" сран";}
                if (strstr($Aboutef,"срак")!=""){$bad_words.=" срак";}
                if (strstr($Aboutef,"срат")!=""){$bad_words.=" срат";}
                if (strstr($Aboutef,"хуев")!=""){$bad_words.=" хуев";}
                if (strstr($Aboutef,"трах")!=""){$bad_words.=" трах";}
                if (strstr($Aboutef,"онан")!=""){$bad_words.=" онан";}
                if (strstr($Aboutef,"хуя")!=""){$bad_words.=" хуя";}
                $bad_words.="</font>";

                echo"s235*64@75<table><tr><td align=center><p style=\"margin: 8px 0px 8px 0px; \">$abuse_ban: $bad_words</p></td></tr></table>";
            }
            else {

                $Allb = DB::table('Foto')->select('id', 'City', 'obl', 'album', 'avt','Fd','Formf','rh')->
                where('Namef', $Namef)->limit(1)->get();

                foreach ($Allb as $All) {
                    $id = $All->id; $City = $All->City; $obl = $All->obl; $album = $All->album;
                    $avt = $All->avt; $Fd = $All->Fd; $Formf = $All->Formf; $rh = $All->rh; $whom = $avt;
                }

                $allusersn = "";
                $nmark=substr_count($rh, ':');
                if($nmark>0){
                    $v_page = explode(":", $rh);
                    for($a=1; $a<=$nmark; $a++){
                        $pm=$v_page[$a]; $pm = explode("*", $pm); $avtm=$pm[1];
                        if (mb_strstr($allusersn,"$avtm")==""){$allusersn.=" $avtm ";}
                    }
                }

                $admpass = "off";
                $my_id = Auth::user()->Num;
                $Allad = DB::table('City_Admin2')->select('Num')->
                where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
                limit(1)->get();
                $Alladn = $Allad->count();
                if ($Alladn > 0) {
                    $admpass = "ok";
                    foreach ($Allad as $All) {
                        $Num_adm = $All->Num;
                        if (mb_strstr($allusersn,"$Num_adm")==""){$allusersn.=" $Num_adm ";}
                    }
                }

                if (mb_strstr($allusersn,"$whom")==""){$allusersn.=" $whom ";}


                if($lan == "en"){$pr="e";}
                else if($lan == "ru"){$pr="r";}
                else{$pr="";}

                $prlink = $pr; $prlink.="nf"; $prlink.=$Namef;
                $Numm = Auth::user()->id;
                $sq=0;
                $Allq = DB::table('Private')->select('ban')->
                where('Num', $whom)->limit(1)->get();
                foreach ($Allq as $Alq) {$ban=$Alq->ban; $sq++; }
                if($sq==0){ $ban = "";}

                $sq=0;
                $Allq = DB::table('Privatec')->select('ComForBan')->
                where('id', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {$ComForBan=$Alq->ComForBan; $sq++; }
                if($sq==0){ $ComForBan = "";}

                if(mb_strstr((string)$ComForBan, (string)$Numm)=="" && mb_strstr((string)$ban, (string)$Numm)=="" ) {

                    $ip = getenv('REMOTE_ADDR');
                    $Md = date('Y-n-j-H-i-s');
                    $aff = DB::table('Memoryf')->insert(['id' => $id, 'Num' => $Namef, 'avt' => $Numm, 'Aboutef' => $Aboutef,
                        'Md' => $Md, 'Ip' => $ip, 'album' => $album, 'Formf' => $Formf, 'Fd' => $Fd]);

                    if($aff){

                        $sexm = Auth::user()->sex;
                        $Imm = Auth::user()->Im;
                        $Prizm = Auth::user()->Priz;
                        $Num_am = Auth::user()->avatar;
                        if ((!$Num_am) || $Num_am < 10) {
                            $Num_am = 7;
                        }
                        if(!$sexm){$sexm=0;}
                        $sex = "$sexm$Num_am";

                        $yem = substr($Fd, 0, 4);
                        $monm = substr($Fd, 5, 2);
                        if ($monm<10){$monmf = substr($Fd, 6, 1);}
                        else{$monmf=$monm;}
                        if($yem<=2007){$yem = "2005-2007"; $monmf="";}

                        $katalog = "Photos/$yem$monmf/$Namef.$Formf";
                        $katalogface = getKatalog($katalog);

						$katalogface = str_replace("http:", "https:", $katalogface);
                        $show_news = Auth::user()->show_news;
                        if (!$show_news) {
                            $ncoment = 1;
                        } else {
                            $ncoment=substr($show_news, 3, 1);
                        }
                        if($ncoment==1) {

                            $Allcm = DB::table('Memoryf')->select('avt')->
                            where('Num', $Namef)->get();
                            foreach ($Allcm as $All) {
                                $avt_other = $All->avt;
                                if (mb_strstr($allusersn,"$avt_other")==""){$allusersn.=" $avt_other ";}
                            }

                            $theme = "c$Namef";

                            $forum_alt = "";
                            $pattern = '/https?:\/\/|www\.|<[^>]*>|&[#a-z0-9]+;/i';
                            if (!preg_match($pattern, $Aboutef)) {
                                $forum_alt = mb_strlen($Aboutef) > 100 ? mb_substr($Aboutef, 0, 100) . "..." : $Aboutef;
                            }

							$my_domen = $_SERVER['SERVER_NAME'];
							$avheight = "auto";
							if($my_domen=="1ua.com.ua"){
								$imageInfo = getimagesize($katalogface);
								if ($imageInfo) {
									$avheight = $imageInfo[1] / 2;
								}
							}
                            $ualine="<a href=## onclick=abf('$id','$Namef')><div class=\"scale\"><img width=\"100\" height=\"$avheight\" alt=\"$forum_alt\" SRC=$katalogface></div></a>";

                            DB::table('News')->insert(['act' => 'ncoment', 'obl' => $obl, 'Im' => $Imm, 'Priz' => $Prizm,
                                'sex' => $sex, 'ualine' => $ualine, 'theme' => $theme, 'avt' => $Numm, 'whom' => $allusersn,
                                'forum' => $Aboutef, 'avt_fr' => $Numm, 'Nd' => $Md]);

                        }



                        if($avt>0 && $avt != $Numm){

                            $lv0 = last_visit_read($avt);
                            $lan_user = $lv0['lang'] ?? "ua";
                            $t = last_visit_ts_diff($lv0);
                            if ($t <= 50000) {


                                if ($lan_user == "ua") {
                                    $qu_in = "";
                                }
                                if ($lan_user == "ru") {
                                    $qu_in = "r";
                                }
                                if ($lan_user == "en") {
                                    $qu_in = "e";
                                }
                                $prlink2 = $qu_in; $prlink2.="nf"; $prlink2.=$Namef;
                                $prlink3  = avt($Numm,$Numm);
                                $prlink3 = str_replace("scale", "", $prlink3);
                                $prlink3 = str_replace("av-shadow", "", $prlink3);

                                $r_else="<table><tr><td width=100 valign=top align=right>
                                        <table>
                                        <tr><td><a href=/$prlink2><img border=0 width=100 SRC=\"$katalogface\" align=left></a></td></tr>
                                        </table>
                                        </td>
                                        <td valign=top width=150>
                                        $prlink3
                                        <div style=\"width: 150px; overflow: hidden\">$Aboutef</div>
                                        </td></tr></table>";

                                \Illuminate\Support\Facades\Redis::lpush("notice:$avt", $r_else);
                            }


                            $Allq = DB::table('users')->select('comment', 'email')->
                            where('id', $avt)->limit(1)->get();
                            foreach ($Allq as $Alq) {
                                $comment = $Alq->comment;
                                $emailu = $Alq->email;
                            }

                            $mailgo = "off";
                            $mailput = "comment$avt";
                            if (!$comment || $comment == 0) {
                                $mailgo="on";
                            }
                            if ($comment == 1) {

                                $filename = "storage/sixhours.txt";
                                $whattoread = @fopen($filename, "r");
                                $truestat_file_contents = fread($whattoread, filesize($filename));
                                fclose($whattoread);
                                $lastmail = strstr($truestat_file_contents, $mailput);

                                if ($lastmail == "") {
                                    $mailgo = "on";
                                    $newfile = @fopen($filename, "a");
                                    @fwrite($newfile, $mailput);
                                    fclose($newfile);
                                }
                            }
                            else if ($comment == 2) {

                                $filename = "storage/oneday.txt";
                                $whattoread = @fopen($filename, "r");
                                $truestat_file_contents = fread($whattoread, filesize($filename));
                                fclose($whattoread);

                                $lastmail = strstr($truestat_file_contents, $mailput);

                                if ($lastmail == "") {
                                    $mailgo = "on";
                                    $newfile = @fopen($filename, "a");
                                    @fwrite($newfile, $mailput);
                                    fclose($newfile);
                                }
                            }


                            if ($mailgo == "on") {
                                if ($lan_user == "ua") {
                                    if($sexm==1){$sexm_e1="додав"; $sexm_e2="прокоментував";}
                                    else if($sexm==2){$sexm_e1="додала"; $sexm_e2="прокоментувала";}
                                    else{$sexm_e1="додав (ла)"; $sexm_e2="прокоментував (ла)";}

                                    $subj = "$Imm $Prizm $sexm_e2 Вашу фотографію...";
                                    $blade = "emails.foto_comment";
                                }
                                if ($lan_user == "ru") {
                                    if($sexm==1){$sexm_e1="добавил"; $sexm_e2="прокомментировал";}
                                    else if($sexm==2){$sexm_e1="добавила"; $sexm_e2="прокомментировала";}
                                    else{$sexm_e1="добавил (ла)"; $sexm_e2="прокомментировал (ла)";}

                                    $subj = "$Imm $Prizm $sexm_e2 Вашу фотографию...";
                                    $blade = "emails.rfoto_comment";
                                }
                                if ($lan_user == "en") {
                                    $subj = "$Imm $Prizm commented on Your photo...";
                                    $sexm_e1 = "";
                                    $sexm_e2 = "";
                                    $blade = "emails.efoto_comment";
                                }
                                $Nameg = "$Imm $Prizm";
                                if (filter_var($emailu, FILTER_VALIDATE_EMAIL)) {
                                    $details['email'] = trim($emailu);
                                    $details['subject'] = $subj;
                                    $details['blade'] = $blade;
                                    $details['det'] = array('Namef' => $Namef, 'Nameg' => $Nameg, 'sexm_e1' => $sexm_e1);
                                    $details['unsub'] = "";
                                    dispatch(new App\Jobs\SendEmailJob($details));
                                }
                            }
                        }


                        $mailput = "comment_i$id";
                        $q_s1[0] = ['comment', 1];
                        $q_s2[0] = ['comment', 1];
                        $q_s3[0] = ['comment', 1];

                        $filename = "storage/sixhours.txt";
                        $whattoread = @fopen($filename, "r");
                        $truestat_file_contents = fread($whattoread, filesize($filename));

                        fclose($whattoread);
                        $lastmail = strstr($truestat_file_contents, $mailput);

                        if ($lastmail == "") {
                            $q_s2[0] = ['comment', 2];
                            $newfile = @fopen($filename, "a");
                            @fwrite($newfile, $mailput);
                            fclose($newfile);
                        }

                        $filename = "storage/oneday.txt";
                        $whattoread = @fopen($filename, "r");
                        $truestat_file_contents = fread($whattoread, filesize($filename));
                        fclose($whattoread);

                        $lastmail = strstr($truestat_file_contents, $mailput);

                        if ($lastmail == "") {
                            $q_s3[0] = ['forum', 3];
                            $newfile = @fopen($filename, "a");
                            @fwrite($newfile, $mailput);
                            fclose($newfile);
                        }

                        $Allm = DB::table('Citymailpost')
                            ->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3) {
                                $query->whereNull('forum')
                                    ->orWhere($q_s1)
                                    ->orWhere($q_s2)
                                    ->orWhere($q_s3);
                            })
                            ->where('id', $id)
                            ->select('mail_visitor')
                            ->get();

                        $myemail = Auth::user()->email;
                        foreach ($Allm as $Alm) {

                            $Pmail = trim($Alm->mail_visitor);
                            if($myemail!=$Pmail){
                                if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                    $subj = "Доданий коментар до фото $City";
                                    if ($sexm == 1) {
                                        $sexm_e1 = "додав";
                                    } else if ($sexm == 2) {
                                        $sexm_e1 = "додала";
                                    } else {
                                        $sexm_e1 = "додав (ла)";
                                    }
                                    $Nameg = "$Imm $Prizm";
                                    $details['email'] = $Pmail;
                                    $details['subject'] = $subj;
                                    $details['blade'] = 'emails.commentfc';
                                    $details['det'] = array('City' => $City, 'Nameg' => $Nameg, 'Namef' => $Namef, 'id' => $id, 'sexm_e1' => $sexm_e1, 'Pmail' => $Pmail);
                                    $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                                    dispatch(new App\Jobs\SendEmailJob($details));
                                }
                            }
                        }

                        echo view('inc.comment', ['M5' => $Namef, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'on']);

                    }
                }
                else{
                    $ask_err = __('messages.comm_ban');
                    echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
                }
            }
        }
        else{
            $ch_e = __('messages.comment_need_reg');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }
    }









    function comm_red(Request $request)
    {
        $idrec = $request['idrec'];
        $Aboutef = $request['Aboutef'];
        $Aboutef = getDescriptionAttribute($Aboutef);
        $Aboutef = nl2br($Aboutef);
        $idrec = $idrec + 1; $idrec = $idrec - 1;
        if (is_int($idrec) != "true") {die("");}
        $abuse_ban = __('messages.abuse_ban');

        if(Auth::user()) {
            $ctrl_hss = $Aboutef;
            $my_id = Auth::user()->id;

            $ctrl_hss = htmlspecialchars_decode($ctrl_hss, ENT_QUOTES);
            $ctrl_hss = strip_tags($ctrl_hss); // Видаляє HTML

            if (preg_match("/<[^<]+>/", $ctrl_hss) && $my_id != 29724907) { exit; }

            $ctrl_hss2 = $ctrl_hss . ">";
            if (preg_match("/<[^<]+>/", $ctrl_hss2) && $my_id != 29724907) { exit; }

            $Aboutef = preg_replace_callback(
                '/(https?:\/\/[^\s<]+[^.,:;"\')\]\s<])/u',
                function ($matches) {
                    $url = $matches[0];
                    $shortUrl = (strlen($url) > 35) ? substr($url, 0, 35) . "..." : $url;


                    $urlParts = explode('/', rtrim($shortUrl, '/'));
                    $lastPart = array_pop($urlParts); // Остання частина URL
                    $boldUrl = implode('/', $urlParts) . '/<b>' . $lastPart . '</b>'; // Додаємо жирний стиль

                    return '<a target="_blank" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($boldUrl, ENT_QUOTES, 'UTF-8') . '</a>';
                },
                $ctrl_hss
            );

            $Aboutef = htmlspecialchars_decode($Aboutef, ENT_QUOTES);

            if (!$Aboutef) {
                $ask_err = __('messages.comm_err');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }
            else if (mb_strlen($Aboutef) > 500) {
                $ask_err = __('messages.ask_err2');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }

            else if (mb_strstr($Aboutef,"хуй")!=""||mb_strstr($Aboutef,"пизд")!=""||mb_strstr($Aboutef," конч")!=""||mb_strstr($Aboutef,"вафл")!=""||mb_strstr($Aboutef,"шлюх")!=""||mb_strstr($Aboutef,"fuck")!=""||mb_strstr($Aboutef," гом")!=""||mb_strstr($Aboutef," бля")!=""||mb_strstr($Aboutef," манд")!=""||mb_strstr($Aboutef,"член")!=""||mb_strstr($Aboutef," еба")!=""||mb_strstr($Aboutef," єба")!=""||mb_strstr($Aboutef,"суч")!=""||mb_strstr($Aboutef,"сук")!=""||mb_strstr($Aboutef,"дроч")!=""||mb_strstr($Aboutef," писк")!=""||mb_strstr($Aboutef," піськ")!=""||mb_strstr($Aboutef,"урод")!=""||mb_strstr($Aboutef,"ублюд")!=""||mb_strstr($Aboutef,"соса")!=""||mb_strstr($Aboutef,"соси")!=""||mb_strstr($Aboutef,"сран")!=""||mb_strstr($Aboutef,"срак")!=""||mb_strstr($Aboutef,"срат")!=""||mb_strstr($Aboutef,"хуев")!=""||mb_strstr($Aboutef,"костр")!=""||mb_strstr($Aboutef,"блев")!=""||mb_strstr($Aboutef,"яйц")!=""||mb_strstr($Aboutef," трах")!=""||mb_strstr($Aboutef,"влагал")!=""||mb_strstr($Aboutef," онан")!=""){

                $bad_words="<font color=red>";
                if (strstr($Aboutef,"хуй")!=""){$bad_words.=" хуй";}
                if (strstr($Aboutef,"пизд")!=""){$bad_words.=" пизд";}
                if (strstr($Aboutef,"сперм")!=""){$bad_words.=" сперм";}
                if (strstr($Aboutef,"шлюх")!=""){$bad_words.=" шлюх";}
                if (strstr($Aboutef,"гом")!=""){$bad_words.=" гом";}
                if (strstr($Aboutef,"бля")!=""){$bad_words.=" бля";}
                if (strstr($Aboutef,"еба")!=""){$bad_words.=" еба";}
                if (strstr($Aboutef,"єба")!=""){$bad_words.=" єба";}
                if (strstr($Aboutef,"сук")!=""){$bad_words.=" сукa";}
                if (strstr($Aboutef,"дроч")!=""){$bad_words.=" дроч";}
                if (strstr($Aboutef,"піськ")!=""){$bad_words.=" піськ";}
                if (strstr($Aboutef,"ублюд")!=""){$bad_words.=" ублюд";}
                if (strstr($Aboutef,"сран")!=""){$bad_words.=" сран";}
                if (strstr($Aboutef,"срак")!=""){$bad_words.=" срак";}
                if (strstr($Aboutef,"срат")!=""){$bad_words.=" срат";}
                if (strstr($Aboutef,"хуев")!=""){$bad_words.=" хуев";}
                if (strstr($Aboutef,"трах")!=""){$bad_words.=" трах";}
                if (strstr($Aboutef,"онан")!=""){$bad_words.=" онан";}
                if (strstr($Aboutef,"хуя")!=""){$bad_words.=" хуя";}
                $bad_words.="</font>";

                echo"s235*64@75<table><tr><td align=center><p style=\"margin: 8px 0px 8px 0px; \">$abuse_ban: $bad_words</p></td></tr></table>";
            }
            else {
                $idrec = $request['idrec'];
                $Aboutef = $request['Aboutef'];

                $my_id = Auth::user()->id;

                $Allb = DB::table('Memoryf')->select('id', 'Num', 'avt', 'Md')->
                where('idrec', $idrec)->limit(1)->get();
                foreach ($Allb as $All) {
                    $id = $All->id;  $Namef = $All->Num; $avtc = $All->avt; $Md = $All->Md;
                }
                $Allb = DB::table('Foto')->select('avt')->
                where('Namef', $Namef)->limit(1)->get();
                foreach ($Allb as $All) {
                    $avt = $All->avt;
                }

                $admpass = "off";
                $Allad = DB::table('City_Admin2')->select('Num')->
                where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
                limit(1)->get();
                $Alladn = $Allad->count();
                if ($Alladn > 0) {
                    $admpass = "ok";
                }

                $Numm = Auth::user()->id;
                $sq=0;
                $Allq = DB::table('Privatec')->select('ComForBan')->
                where('id', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {$ComForBan=$Alq->ComForBan; $sq++; }
                if($sq==0){ $ComForBan = "";}

                if(mb_strstr((string)$ComForBan, (string)$Numm)=="") {

                    $affected = DB::table('Memoryf')
                        ->where('idrec', $idrec)
                        ->update(['Aboutef' => $Aboutef]);

                    $theme = "c$Namef";
                    DB::table('News')
                        ->where('act', 'ncoment')
                        ->where('avt', $avtc)
                        ->where('Nd', $Md)
                        ->where('theme', $theme)
                        ->update(['forum' => $Aboutef]);

                    if($affected){
                        echo view('inc.comment', ['M5' => $Namef, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'on']);
                    }

                }
                else{
                    $ask_err = __('messages.comm_ban');
                    echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
                }

            }
        }
        else{
            $ch_e = __('messages.comment_need_reg');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }
    }












    function comm_addp(Request $request)
    {
        $Namef = $request['M5'];
        $Aboutef = $request['Aboutef'];
        $Aboutef = getDescriptionAttribute($Aboutef);
        $Aboutef = nl2br($Aboutef);
        $Namef = $Namef + 1;
        $Namef = $Namef - 1;
        if (is_int($Namef) != "true") {
            die("");
        }
        $abuse_ban = __('messages.abuse_ban');
        $lan = __('messages.lan');


        if (Auth::user()) {
            $ctrl_hss = $Aboutef;
            $my_id = Auth::user()->id;

            $ctrl_hss = htmlspecialchars_decode($ctrl_hss, ENT_QUOTES);
            $ctrl_hss = strip_tags($ctrl_hss); // Видаляє HTML

            if (preg_match("/<[^<]+>/", $ctrl_hss) && $my_id != 29724907) { exit; }

            $ctrl_hss2 = $ctrl_hss . ">";
            if (preg_match("/<[^<]+>/", $ctrl_hss2) && $my_id != 29724907) { exit; }

            $Aboutef = preg_replace_callback(
                '/(https?:\/\/[^\s<]+[^.,:;"\')\]\s<])/u',
                function ($matches) {
                    $url = $matches[0];
                    $shortUrl = (strlen($url) > 35) ? substr($url, 0, 35) . "..." : $url;


                    $urlParts = explode('/', rtrim($shortUrl, '/'));
                    $lastPart = array_pop($urlParts); // Остання частина URL
                    $boldUrl = implode('/', $urlParts) . '/<b>' . $lastPart . '</b>'; // Додаємо жирний стиль

                    return '<a target="_blank" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($boldUrl, ENT_QUOTES, 'UTF-8') . '</a>';
                },
                $ctrl_hss
            );

            $Aboutef = htmlspecialchars_decode($Aboutef, ENT_QUOTES);


            if (!$Aboutef) {
                $ask_err = __('messages.comm_err');
                echo "s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }
            else if (mb_strlen($Aboutef) > 5000) {
                $ask_err = __('messages.ask_err2');
                echo "s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }
            else if (mb_strstr($Aboutef, "хуй") != "" || mb_strstr($Aboutef, "пизд") != "" || mb_strstr($Aboutef, " конч") != "" || mb_strstr($Aboutef, "вафл") != "" || mb_strstr($Aboutef, "шлюх") != "" || mb_strstr($Aboutef, "fuck") != "" || mb_strstr($Aboutef, " гом") != "" || mb_strstr($Aboutef, " бля") != "" || mb_strstr($Aboutef, " манд") != "" || mb_strstr($Aboutef, "член") != "" || mb_strstr($Aboutef, " еба") != "" || mb_strstr($Aboutef, " єба") != "" || mb_strstr($Aboutef, "суч") != "" || mb_strstr($Aboutef, "сук") != "" || mb_strstr($Aboutef, "дроч") != "" || mb_strstr($Aboutef, " писк") != "" || mb_strstr($Aboutef, " піськ") != "" || mb_strstr($Aboutef, "урод") != "" || mb_strstr($Aboutef, "ублюд") != "" || mb_strstr($Aboutef, "соса") != "" || mb_strstr($Aboutef, "соси") != "" || mb_strstr($Aboutef, "сран") != "" || mb_strstr($Aboutef, "срак") != "" || mb_strstr($Aboutef, "срат") != "" || mb_strstr($Aboutef, "хуев") != "" || mb_strstr($Aboutef, "костр") != "" || mb_strstr($Aboutef, "блев") != "" || mb_strstr($Aboutef, "яйц") != "" || mb_strstr($Aboutef, " трах") != "" || mb_strstr($Aboutef, "влагал") != "" || mb_strstr($Aboutef, " онан") != "") {

                $bad_words="<font color=red>";
                if (strstr($Aboutef,"хуй")!=""){$bad_words.=" хуй";}
                if (strstr($Aboutef,"пизд")!=""){$bad_words.=" пизд";}
                if (strstr($Aboutef,"сперм")!=""){$bad_words.=" сперм";}
                if (strstr($Aboutef,"шлюх")!=""){$bad_words.=" шлюх";}
                if (strstr($Aboutef,"гом")!=""){$bad_words.=" гом";}
                if (strstr($Aboutef,"бля")!=""){$bad_words.=" бля";}
                if (strstr($Aboutef,"еба")!=""){$bad_words.=" еба";}
                if (strstr($Aboutef,"єба")!=""){$bad_words.=" єба";}
                if (strstr($Aboutef,"сук")!=""){$bad_words.=" сукa";}
                if (strstr($Aboutef,"дроч")!=""){$bad_words.=" дроч";}
                if (strstr($Aboutef,"піськ")!=""){$bad_words.=" піськ";}
                if (strstr($Aboutef,"ублюд")!=""){$bad_words.=" ублюд";}
                if (strstr($Aboutef,"хуев")!=""){$bad_words.=" хуев";}
                if (strstr($Aboutef,"трах")!=""){$bad_words.=" трах";}
                if (strstr($Aboutef,"онан")!=""){$bad_words.=" онан";}
                if (strstr($Aboutef,"хуя")!=""){$bad_words.=" хуя";}
                $bad_words.="</font>";

                echo "s235*64@75<table><tr><td align=center><p style=\"margin: 8px 0px 8px 0px; \">$abuse_ban: $bad_words</p></td></tr></table>";
            }
            else {

                $Allb = DB::table('Fotop')->select('Num', 'album', 'avt', 'Fd', 'Formf', 'rh', 'Sh')->
                where('Namef', $Namef)->limit(1)->get();

                foreach ($Allb as $All) {
                    $id = $All->Num;
                    $album = $All->album;
                    $avt = $All->avt;
                    $Fd = $All->Fd;
                    $Formf = $All->Formf;
                    $rh = $All->rh;
                    $Sh = $All->Sh;
                    $whom = $avt;
                }

                $allusersn = "";
                $nmark = substr_count($rh, ':');
                if ($nmark > 0) {
                    $v_page = explode(":", $rh);
                    for ($a = 1; $a <= $nmark; $a++) {
                        $pm = $v_page[$a];
                        $pm = explode("*", $pm);
                        $avtm = $pm[1];
                        if (mb_strstr($allusersn, "$avtm") == "") {
                            $allusersn .= " $avtm ";
                        }
                    }
                }


                if (mb_strstr($allusersn, "$whom") == "") {
                    $allusersn .= " $whom ";
                }

                if ($lan == "en") {
                    $pr = "e";
                } else if ($lan == "ru") {
                    $pr = "r";
                } else {
                    $pr = "";
                }

                $prlink = $pr;
                $prlink .= "ni";
                $prlink .= $Namef;
                $Numm = Auth::user()->id;
                $sq = 0;
                $Allq = DB::table('Private')->select('ban')->
                where('Num', $whom)->limit(1)->get();
                foreach ($Allq as $Alq) {
                    $ComForBan = $Alq->ban;
                    $sq++;
                }
                if ($sq == 0) {
                    $ComForBan = "";
                }

                $sq = 0;
                $Forum = 1;
                $Allq = DB::table('Private')->select('ban', 'Forum')->
                where('Num', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {
                    $Ban = $Alq->ban;
                    $Forum = $Alq->Forum;
                    $sq++;
                }
                if ($sq == 0) {
                    $Ban = "";
                }

                $admpass = "off";
                if ($id == $Numm) {
                    $admpass = "ok";
                }

                $Privatpass = "stop";
                if (!$Forum || $Forum == 0 || $Forum == 1 || $Forum == 2) {
                    $Privatpass = "go";
                } else {

                    $Alls = DB::table('Friends')->select('Num1', 'Num2')->
                    where(function ($query1) use ($id) {
                        $query1->where('Num1', $id)
                            ->where('Argue', '=', 2);
                    })->
                    orWhere(function ($query2) use ($id) {
                        $query2->where('Num2', $id)
                            ->where('Argue', '=', 2);
                    })->
                    get();
                    $fr_avt = "";
                    $Numfr = "";
                    foreach ($Alls as $All) {
                        $Num1 = $All->Num1;
                        $Num2 = $All->Num2;
                        if ($Num1 == $id) {
                            $Numfr = $Num2;
                        } else {
                            $Numfr = $Num1;
                        }
                        $fr_avt .= " $Numfr";
                    }
                    $my_id = Auth::user()->id;
                    $my_id2 = "$my_id";
                    $isfriend = strstr("$fr_avt", "$my_id2");

                    if ($Forum == 3 && ($id == $Numm || $isfriend != "")) {
                        $Privatpass = "go";
                    } else {
                        if ($Forum == 4 && $id == $Numm) {
                            $Privatpass = "go";
                        }
                    }
                }


                if (mb_strstr((string)$ComForBan, (string)$Numm) == "" && mb_strstr((string)$Ban, (string)$Numm) == "") {
                    if ($Privatpass == "go") {

                        $ip = getenv('REMOTE_ADDR');
                        $Md = date('Y-n-j-H-i-s');
                        $aff = DB::table('Memoryfp')->insert(['Nump' => $id, 'Num' => $Namef, 'avt' => $Numm, 'Aboutef' => $ctrl_hss,
                            'Md' => $Md, 'Ip' => $ip, 'album' => $album, 'Formf' => $Formf, 'Fd' => $Fd, 'Sh' => $Sh]);

                        if ($aff) {

                            $sexm = Auth::user()->sex;
                            $Imm = Auth::user()->Im;
                            $Prizm = Auth::user()->Priz;
                            $Num_am = Auth::user()->avatar;
                            if ((!$Num_am) || $Num_am < 10) {
                                $Num_am = 7;
                            }
                            if (!$sexm) {
                                $sexm = 0;
                            }
                            $sex = "$sexm$Num_am";

                            $yem = substr($Fd, 0, 4);
                            $monm = substr($Fd, 5, 2);
                            if ($monm < 10) {
                                $monmf = substr($Fd, 6, 1);
                            } else {
                                $monmf = $monm;
                            }
                            if ($yem <= 2007) {
                                $yem = "2005-2007";
                                $monmf = "";
                            }

                            $katalogb = "Fotop/$yem$monmf/$Namef.$Formf";
                            $katalogface = Storage::disk('public')->url($katalogb);

                            $show_news = Auth::user()->show_news;
                            if (!$show_news) {
                                $ncoment = 1;
                            } else {
                                $ncoment = substr($show_news, 3, 1);
                            }
                            if ($ncoment == 1) {

                                $Allcm = DB::table('Memoryfp')->select('avt')->
                                where('Num', $Namef)->get();
                                foreach ($Allcm as $All) {
                                    $avt_other = $All->avt;
                                    if (mb_strstr($allusersn, "$avt_other") == "") {
                                        $allusersn .= " $avt_other ";
                                    }
                                }

                                $theme = "p$Namef";

                                $forum_alt = "";
                                $pattern = '/https?:\/\/|www\.|<[^>]*>|&[#a-z0-9]+;/i';
                                if (!preg_match($pattern, $Aboutef)) {
                                    $forum_alt = mb_strlen($Aboutef) > 100 ? mb_substr($Aboutef, 0, 100) . "..." : $Aboutef;
                                }

								$my_domen = $_SERVER['SERVER_NAME'];
								$avheight = "auto";
								if($my_domen=="1ua.com.ua"){
									$imageInfo = getimagesize($katalogface);
									if ($imageInfo) {
										$avheight = $imageInfo[1] / 2;
									}
								}
								$ualine="<a href=## onclick=abfp('$id','$Namef')><div class=\"scale\"><img width=\"100\" height=\"$avheight\" alt=\"$forum_alt\" SRC=$katalogface></div></a>";



                                DB::table('News')->insert(['act' => 'ncoment', 'Im' => $Imm, 'Priz' => $Prizm,
                                    'sex' => $sex, 'ualine' => $ualine, 'theme' => $theme, 'avt' => $Numm, 'whom' => $allusersn,
                                    'forum' => $Aboutef, 'avt_fr' => $Numm, 'Nd' => $Md]);

                            }


                            if ($avt > 0 && $avt != $Numm) {

                                $lv0 = last_visit_read($avt);
                                $lan_user = $lv0['lang'] ?? "ua";
                                $t = last_visit_ts_diff($lv0);
                                if ($t <= 50000) {


                                    if ($lan_user == "ua") {
                                        $qu_in = "";
                                    }
                                    if ($lan_user == "ru") {
                                        $qu_in = "r";
                                    }
                                    if ($lan_user == "en") {
                                        $qu_in = "e";
                                    }
                                    $prlink2 = $qu_in;
                                    $prlink2 .= "ni";
                                    $prlink2 .= $Namef;
                                    $prlink3  = avt($Numm,$Numm);
                                    $prlink3 = str_replace("scale", "", $prlink3);
                                    $prlink3 = str_replace("av-shadow", "", $prlink3);

                                    $r_else = "<table><tr><td width=100 valign=top align=right>
                                        <table>
                                        <tr><td><a href=/$prlink2><img border=0 width=100 SRC=\"$katalogface\" align=left></a></td></tr>
                                        </table>
                                        </td>
                                        <td valign=top width=150>
                                        $prlink3
                                        <div style=\"width: 150px; overflow: hidden\">$Aboutef</div>
                                        </td></tr></table>";

                                    \Illuminate\Support\Facades\Redis::lpush("notice:$avt", $r_else);
                                }


                                $Allq = DB::table('users')->select('comment', 'email')->
                                where('id', $avt)->limit(1)->get();
                                foreach ($Allq as $Alq) {
                                    $comment = $Alq->comment;
                                    $emailu = $Alq->email;
                                }

                                $mailgo = "off";
                                $mailput = "comment$avt";
                                if (!$comment || $comment == 0) {
                                    $mailgo = "on";
                                }
                                if ($comment == 1) {

                                    $filename = "storage/sixhours.txt";
                                    $whattoread = @fopen($filename, "r");
                                    $truestat_file_contents = fread($whattoread, filesize($filename));
                                    fclose($whattoread);
                                    $lastmail = strstr($truestat_file_contents, $mailput);

                                    if ($lastmail == "") {
                                        $mailgo = "on";
                                        $newfile = @fopen($filename, "a");
                                        @fwrite($newfile, $mailput);
                                        fclose($newfile);
                                    }
                                } else if ($comment == 2) {

                                    $filename = "storage/oneday.txt";
                                    $whattoread = @fopen($filename, "r");
                                    $truestat_file_contents = fread($whattoread, filesize($filename));
                                    fclose($whattoread);

                                    $lastmail = strstr($truestat_file_contents, $mailput);

                                    if ($lastmail == "") {
                                        $mailgo = "on";
                                        $newfile = @fopen($filename, "a");
                                        @fwrite($newfile, $mailput);
                                        fclose($newfile);
                                    }
                                }


                                if ($mailgo == "on") {
                                    if ($lan_user == "ua") {
                                        if ($sexm == 1) {
                                            $sexm_e1 = "додав";
                                            $sexm_e2 = "прокоментував";
                                        } else if ($sexm == 2) {
                                            $sexm_e1 = "додала";
                                            $sexm_e2 = "прокоментувала";
                                        } else {
                                            $sexm_e1 = "додав (ла)";
                                            $sexm_e2 = "прокоментував (ла)";
                                        }

                                        $subj = "$Imm $Prizm $sexm_e2 Вашу фотографію...";
                                        $blade = "emails.fotop_comment";
                                    }
                                    if ($lan_user == "ru") {
                                        if ($sexm == 1) {
                                            $sexm_e1 = "добавил";
                                            $sexm_e2 = "прокомментировал";
                                        } else if ($sexm == 2) {
                                            $sexm_e1 = "добавила";
                                            $sexm_e2 = "прокомментировала";
                                        } else {
                                            $sexm_e1 = "добавил (ла)";
                                            $sexm_e2 = "прокомментировал (ла)";
                                        }

                                        $subj = "$Imm $Prizm $sexm_e2 Вашу фотографию...";
                                        $blade = "emails.rfotop_comment";
                                    }
                                    if ($lan_user == "en") {
                                        $subj = "$Imm $Prizm commented on Your photo...";
                                        $sexm_e1 = "";
                                        $sexm_e2 = "";
                                        $blade = "emails.efotop_comment";
                                    }
                                    if (filter_var($emailu, FILTER_VALIDATE_EMAIL)) {
                                        $Nameg = "$Imm $Prizm";
                                        $details['email'] = trim($emailu);
                                        $details['subject'] = $subj;
                                        $details['blade'] = $blade;
                                        $details['det'] = array('Namef' => $Namef, 'Nameg' => $Nameg, 'sexm_e1' => $sexm_e1);
                                        $details['unsub'] = "";
                                        dispatch(new App\Jobs\SendEmailJob($details));
                                    }
                                }
                                if ($mailgo == "on") {
                                    if ($lan_user == "ua") {
                                        if ($sexm == 1) {
                                            $sexm_e1 = "додав";
                                            $sexm_e2 = "прокоментував";
                                        } else if ($sexm == 2) {
                                            $sexm_e1 = "додала";
                                            $sexm_e2 = "прокоментувала";
                                        } else {
                                            $sexm_e1 = "додав (ла)";
                                            $sexm_e2 = "прокоментував (ла)";
                                        }

                                        $subj = "$Imm $Prizm $sexm_e2 Вашу фотографію...";
                                        $blade = "emails.fotop_comment";
                                    }
                                    if ($lan_user == "ru") {
                                        if ($sexm == 1) {
                                            $sexm_e1 = "добавил";
                                            $sexm_e2 = "прокомментировал";
                                        } else if ($sexm == 2) {
                                            $sexm_e1 = "добавила";
                                            $sexm_e2 = "прокомментировала";
                                        } else {
                                            $sexm_e1 = "добавил (ла)";
                                            $sexm_e2 = "прокомментировал (ла)";
                                        }

                                        $subj = "$Imm $Prizm $sexm_e2 Вашу фотографию...";
                                        $blade = "emails.rfotop_comment";
                                    }
                                    if ($lan_user == "en") {
                                        $subj = "$Imm $Prizm commented on Your photo...";
                                        $sexm_e1 = "";
                                        $sexm_e2 = "";
                                        $blade = "emails.efotop_comment";
                                    }
                                    $Nameg = "$Imm $Prizm";
                                    if (filter_var($emailu, FILTER_VALIDATE_EMAIL)) {
                                        $details['email'] = trim($emailu);
                                        $details['subject'] = $subj;
                                        $details['blade'] = $blade;
                                        $details['det'] = array('Namef' => $Namef, 'Nameg' => $Nameg, 'sexm_e1' => $sexm_e1);
                                        $details['unsub'] = "";
                                        dispatch(new App\Jobs\SendEmailJob($details));
                                    }
                                }
                            }


                            if ($id == $Numm) {
                                $mailput = "comment_i$id";
                                $q_s1[0] = ['comment', 1];
                                $q_s2[0] = ['comment', 1];
                                $q_s3[0] = ['comment', 1];

                                $filename = "storage/sixhours.txt";
                                $whattoread = @fopen($filename, "r");
                                $truestat_file_contents = fread($whattoread, filesize($filename));

                                fclose($whattoread);
                                $lastmail = strstr($truestat_file_contents, $mailput);

                                if ($lastmail == "") {
                                    $q_s2[0] = ['comment', 2];
                                    $newfile = @fopen($filename, "a");
                                    @fwrite($newfile, $mailput);
                                    fclose($newfile);
                                }

                                $filename = "storage/oneday.txt";
                                $whattoread = @fopen($filename, "r");
                                $truestat_file_contents = fread($whattoread, filesize($filename));
                                fclose($whattoread);

                                $lastmail = strstr($truestat_file_contents, $mailput);

                                if ($lastmail == "") {
                                    $q_s3[0] = ['forum', 3];
                                    $newfile = @fopen($filename, "a");
                                    @fwrite($newfile, $mailput);
                                    fclose($newfile);
                                }

                                $Allm = DB::table('Mailpost')
                                    ->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3) {
                                        $query->whereNull('forum')
                                            ->orWhere($q_s1)
                                            ->orWhere($q_s2)
                                            ->orWhere($q_s3);
                                    })
                                    ->where('Nump', $id)
                                    ->select('Pmail')
                                    ->get();

                                $myemail = Auth::user()->email;
                                foreach ($Allm as $Alm) {

                                    $Pmail = trim($Alm->Pmail);
                                    if ($myemail != $Pmail) {

                                        $Nameg = "$Imm $Prizm";
                                        $subj = "Доданий коментар до фото $Nameg";
                                        if ($sexm == 1) {
                                            $sexm_e1 = "додав";
                                        } else if ($sexm == 2) {
                                            $sexm_e1 = "додала";
                                        } else {
                                            $sexm_e1 = "додав (ла)";
                                        }
                                        if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                            $details['email'] = $Pmail;
                                            $details['subject'] = $subj;
                                            $details['blade'] = 'emails.commentfp';
                                            $details['det'] = array('Nameg' => $Nameg, 'Namef' => $Namef, 'id' => $id, 'sexm_e1' => $sexm_e1, 'Pmail' => $Pmail);
                                            $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$id>";
                                            dispatch(new App\Jobs\SendEmailJob($details));
                                        }
                                    }
                                }
                            }
                            echo view('inc.commentp', ['M5' => $Namef, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'on']);
                        }
                    }

                    else {
                        $ask_err = __('messages.comm_block');
                        echo "s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
                    }
                }
                else {
                    $ask_err = __('messages.comm_ban');
                    echo "s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
                }
            }
        }
        else{
            $ch_e = __('messages.comment_need_reg');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }
    }






    function comm_redp(Request $request)
    {
        $idrec = $request['idrec'];
        $Aboutef = $request['Aboutef'];
        $Aboutef = getDescriptionAttribute($Aboutef);
        $Aboutef = nl2br($Aboutef);
        $idrec = $idrec + 1; $idrec = $idrec - 1;
        if (is_int($idrec) != "true") {die("");}
        $abuse_ban = __('messages.abuse_ban');


        if(Auth::user()) {
            $ctrl_hss = $Aboutef;
            $my_id = Auth::user()->id;

            $ctrl_hss = htmlspecialchars_decode($ctrl_hss, ENT_QUOTES);
            $ctrl_hss = strip_tags($ctrl_hss); // Видаляє HTML

            if (preg_match("/<[^<]+>/", $ctrl_hss) && $my_id != 29724907) { exit; }

            $ctrl_hss2 = $ctrl_hss . ">";
            if (preg_match("/<[^<]+>/", $ctrl_hss2) && $my_id != 29724907) { exit; }

            $Aboutef = preg_replace_callback(
                '/(https?:\/\/[^\s<]+[^.,:;"\')\]\s<])/u',
                function ($matches) {
                    $url = $matches[0];
                    $shortUrl = (strlen($url) > 35) ? substr($url, 0, 35) . "..." : $url;


                    $urlParts = explode('/', rtrim($shortUrl, '/'));
                    $lastPart = array_pop($urlParts); // Остання частина URL
                    $boldUrl = implode('/', $urlParts) . '/<b>' . $lastPart . '</b>'; // Додаємо жирний стиль

                    return '<a target="_blank" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($boldUrl, ENT_QUOTES, 'UTF-8') . '</a>';
                },
                $ctrl_hss
            );

            $Aboutef = htmlspecialchars_decode($Aboutef, ENT_QUOTES);
            if (!$Aboutef) {
                $ask_err = __('messages.comm_err');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }
            else if (mb_strlen($Aboutef) > 500) {
                $ask_err = __('messages.ask_err2');
                echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
            }

            else if (mb_strstr($Aboutef,"хуй")!=""||mb_strstr($Aboutef,"пизд")!=""||mb_strstr($Aboutef," конч")!=""||mb_strstr($Aboutef,"вафл")!=""||mb_strstr($Aboutef,"шлюх")!=""||mb_strstr($Aboutef,"fuck")!=""||mb_strstr($Aboutef," гом")!=""||mb_strstr($Aboutef," бля")!=""||mb_strstr($Aboutef," манд")!=""||mb_strstr($Aboutef,"член")!=""||mb_strstr($Aboutef," еба")!=""||mb_strstr($Aboutef," єба")!=""||mb_strstr($Aboutef,"суч")!=""||mb_strstr($Aboutef,"сук")!=""||mb_strstr($Aboutef,"дроч")!=""||mb_strstr($Aboutef," писк")!=""||mb_strstr($Aboutef," піськ")!=""||mb_strstr($Aboutef,"урод")!=""||mb_strstr($Aboutef,"ублюд")!=""||mb_strstr($Aboutef,"соса")!=""||mb_strstr($Aboutef,"соси")!=""||mb_strstr($Aboutef,"сран")!=""||mb_strstr($Aboutef,"срак")!=""||mb_strstr($Aboutef,"срат")!=""||mb_strstr($Aboutef,"хуев")!=""||mb_strstr($Aboutef,"костр")!=""||mb_strstr($Aboutef,"блев")!=""||mb_strstr($Aboutef,"яйц")!=""||mb_strstr($Aboutef," трах")!=""||mb_strstr($Aboutef,"влагал")!=""||mb_strstr($Aboutef," онан")!=""){

                $bad_words="<font color=red>";
                if (strstr($Aboutef,"хуй")!=""){$bad_words.=" хуй";}
                if (strstr($Aboutef,"пизд")!=""){$bad_words.=" пизд";}
                if (strstr($Aboutef,"сперм")!=""){$bad_words.=" сперм";}
                if (strstr($Aboutef,"шлюх")!=""){$bad_words.=" шлюх";}
                if (strstr($Aboutef,"гом")!=""){$bad_words.=" гом";}
                if (strstr($Aboutef,"бля")!=""){$bad_words.=" бля";}
                if (strstr($Aboutef,"еба")!=""){$bad_words.=" еба";}
                if (strstr($Aboutef,"єба")!=""){$bad_words.=" єба";}
                if (strstr($Aboutef,"сук")!=""){$bad_words.=" сукa";}
                if (strstr($Aboutef,"дроч")!=""){$bad_words.=" дроч";}
                if (strstr($Aboutef,"піськ")!=""){$bad_words.=" піськ";}
                if (strstr($Aboutef,"ублюд")!=""){$bad_words.=" ублюд";}
                if (strstr($Aboutef,"сран")!=""){$bad_words.=" сран";}
                if (strstr($Aboutef,"срак")!=""){$bad_words.=" срак";}
                if (strstr($Aboutef,"срат")!=""){$bad_words.=" срат";}
                if (strstr($Aboutef,"хуев")!=""){$bad_words.=" хуев";}
                if (strstr($Aboutef,"трах")!=""){$bad_words.=" трах";}
                if (strstr($Aboutef,"онан")!=""){$bad_words.=" онан";}
                if (strstr($Aboutef,"хуя")!=""){$bad_words.=" хуя";}
                $bad_words.="</font>";

                echo"s235*64@75<table><tr><td align=center><p style=\"margin: 8px 0px 8px 0px; \">$abuse_ban: $bad_words</p></td></tr></table>";
            }
            else {
                $idrec = $request['idrec'];
                $Aboutef = $request['Aboutef'];

                $my_id = Auth::user()->id;

                $Allb = DB::table('Memoryfp')->select('Nump', 'Num', 'avt', 'Md')->
                where('idrec', $idrec)->limit(1)->get();
                foreach ($Allb as $All) {
                    $id = $All->Nump; $Namef = $All->Num; $avtc = $All->avt; $Md = $All->Md;
                }
                $Allb = DB::table('Fotop')->select('avt')->
                where('Namef', $Namef)->limit(1)->get();
                foreach ($Allb as $All) {
                    $avt = $All->avt;
                }

                $admpass = "off";

                if ($my_id == $id) {
                    $admpass = "ok";
                }

                $Numm = Auth::user()->id;
                $sq = 0;
                $Forum = 1;
                $Allq = DB::table('Private')->select('ban', 'Forum')->
                where('Num', $id)->limit(1)->get();
                foreach ($Allq as $Alq) {
                    $Ban = $Alq->ban;
                    $Forum = $Alq->Forum;
                    $sq++;
                }
                if ($sq == 0) {
                    $Ban = "";
                }

                if(mb_strstr((string)$Ban, (string)$Numm)=="") {

                    $affected = DB::table('Memoryfp')
                        ->where('idrec', $idrec)
                        ->update(['Aboutef' => $Aboutef]);

                    $theme = "p$Namef";
                    DB::table('News')
                        ->where('act', 'ncoment')
                        ->where('avt', $avtc)
                        ->where('Nd', $Md)
                        ->where('theme', $theme)
                        ->update(['forum' => $Aboutef]);

                    if($affected){
                        echo view('inc.commentp', ['M5' => $Namef, 'admpass' => $admpass, 'avt' => $avt, 'red' => 'on']);
                    }

                }
                else{
                    $ask_err = __('messages.comm_ban');
                    echo"s235*64@75<table><tr><td align=center><p style=\" color:red; margin: 8px 0px 8px 0px; \">$ask_err</p></td></tr></table>";
                }

            }
        }
        else{
            $ch_e = __('messages.comment_need_reg');
            echo "<div style=\"margin: 8px 8px 8px 8px; \"> $ch_e  </div>";
        }
    }











    function comm_del(Request $request)
    {

        $idrec = $request['idrec'];
        $idrec = $idrec + 1; $idrec = $idrec - 1;
        if (is_int($idrec) != "true") {die("");}


        if(Auth::user()) {

            $my_id = Auth::user()->id;

			$Allb = DB::table('Memoryf')->select('id', 'Num', 'avt', 'Md')->
			where('idrec', $idrec)->limit(1)->get();
			foreach ($Allb as $All) {
				$id = $All->id;  $Namef = $All->Num; $avtc = $All->avt; $Md = $All->Md;
			}

			$Allb = DB::table('Foto')->select('avt')->
			where('Namef', $Namef)->limit(1)->get();
			foreach ($Allb as $All) {
			$avt = $All->avt;
			}

			$admpass = "off";
			$Allad = DB::table('City_Admin2')->select('Num')->
			where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
			limit(1)->get();
			$Alladn = $Allad->count();
			if ($Alladn > 0) {
				$admpass = "ok";
			}

			if ($admpass=="ok"||($avtc==$my_id&&$avtc>10)||($avt==$my_id&&$avt>10)|| $my_id=="72372396"){

				$aff = DB::table('Memoryf')->where('idrec', $idrec)->delete();
				$theme_news="c$Namef";
				DB::table('News')->
				where('act', 'ncoment')->
				where('avt', $avtc)->
				where('Nd', $Md)->
				where('theme', $theme_news)->
				delete();
				if($aff){
					$ch_e = __('messages.comment_del');
					echo " $ch_e ";
				}

			}

        }
        else{
            $ch_e = __('messages.comment_del_need_reg');
            echo " $ch_e ";
        }

    }





    function comm_delp(Request $request)
    {
        $idrec = $request['idrec'];
        $idrec = $idrec + 1; $idrec = $idrec - 1;
        if (is_int($idrec) != "true") {die("");}

        if(Auth::user()) {

            $my_id = Auth::user()->id;

            $Allb = DB::table('Memoryfp')->select('Nump', 'Num', 'avt', 'Md')->
            where('idrec', $idrec)->limit(1)->get();
            foreach ($Allb as $All) {
                $id = $All->Nump;  $Namef = $All->Num; $avtc = $All->avt; $Md = $All->Md;
            }

            $Allb = DB::table('Fotop')->select('avt')->
            where('Namef', $Namef)->limit(1)->get();
            foreach ($Allb as $All) {
                $avt = $All->avt;
            }

            if ($id==$my_id||($avtc==$my_id&&$avtc>10)||($avt==$my_id&&$avt>10)|| $my_id=="72372396"){

                $aff = DB::table('Memoryfp')->where('idrec', $idrec)->delete();
                $theme_news="p$Namef";
                DB::table('News')->
                where('act', 'ncoment')->
                where('avt', $avtc)->
                where('Nd', $Md)->
                where('theme', $theme_news)->
                delete();
                if($aff){
                    $ch_e = __('messages.comment_del');
                    echo " $ch_e ";
                }
            }

        }
        else{
            $ch_e = __('messages.comment_del_need_reg');
            echo " $ch_e ";
        }

    }


    function rec(Request $request)
    {
        $namef = $request['namef'];
        $x = $request['x'];
        $y = $request['y'];
        $z = $request['z'];

        DB::table('Foto')
            ->where('Namef', $namef)
            ->update(['x' => $x, 'y' => $y, 'z' => $z]);
    }


    function fotoonmap(Request $request)
    {
        $page = $request['page'];
        $x0 = $request['x0'];
        $x1 = $request['x1'];
        $y0 = $request['y0'];
        $y1 = $request['y1'];

        if(!$page){$page=0; $shift=0; echo"<br />";}
        else{$shift=$page*15;}
        $page=$page+1;

        $Allc = DB::table('Foto')->
        select('Namef', 'Fd', 'Formf', 'x', 'y')->
        where('x', '>', $x0)->
        where('x', '<', $x1)->
        where('y', '>', $y0)->
        where('y', '<', $y1)->
        orderBy('Fd', 'desc')->
        skip($shift)->take(15)->
        get();
        $nr = $Allc->count();

        $lan = __('messages.lan');
        if($lan=="ua"){$prel="nf";}
        if($lan=="ru"){$prel="rnf";}
        if($lan=="en"){$prel="enf";}

        echo"<table>";
        if($nr==0){
            if($lan=="ua"){
                echo"<tr valign=center><td width=5></td><td align=center> <font color=white><b><br /><br />Фото на заданій площині відсутні.
            <br /> Перемістіть межі прямокутника, <br />  щоб побачити фото на іншій місцевості<br />або виберіть інший населений пункт,<br />щоб побачити фото сусідньої області</font></b></td><td width=5></td></tr>";}

            if($lan=="ru"){
                echo"<tr valign=center><td width=5></td><td align=center> <font color=white><b><br /><br />Фото на заданной плоскости отсутствуют.
            <br /> Переместите пределы прямоугольника, <br />  чтобы посмотреть фото на другой местности<br />или выберите другой населенный пункт,<br />чтобы увидеть фото соседней области</font></b></td><td width=5></td></tr>";}

            if($lan=="en"){
                echo"<tr valign=center><td width=5></td><td align=center> <font color=white><b><br /><br />Photo on a given plane missing.
            <br /> Move the boundaries of the rectangle, <br /> or select another locality<br />to see a photo of a neighboring area</font></b></td><td width=5></td></tr>";}
        }
        else{
            $nf=0;
            foreach ($Allc as $All) {
                $nf++;
                $Namef = $All->Namef;
                $Fd = $All->Fd;
                $Formf = $All->Formf;
                $x = $All->x; $y = $All->y;
                $prel_e="$prel$Namef";

                $monm = substr($Fd, 5, 2); $yem = substr($Fd, 0, 4);
                if ($monm<10){$monmf = substr($Fd, 6, 1);}
                else{$monmf=$monm;}
                if($yem<=2007){$yem = "2005-2007"; $monmf="";}

                $katalog = "Photos/$yem$monmf/$Namef.$Formf";
                $katalogb = "Photos/$yem$monmf/b$Namef.$Formf";
                $katalogface = getKatalogface($katalog, $katalogb);

                $gps_tit = __('messages.gps_tit');

                echo"<tr><td";
                if($nf>10 && $nr==15){ echo" onMouseOver=fmnext('$page','$x0','$x1','$y0','$y1')";}
                echo"><a href=$prel_e target=blank onmouseover = markshow('$y','$x')><img width=200 src=$katalogface>
                <br />

                <div class=\"hidblokwide\" align=center>
                    <a onclick=markshow('$y','$x')><b><font color=white>$gps_tit </font></b></a><br />
                </div><br />";
                if($nf==15){
                    $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}
                    $nnext = __('messages.nnext');
                    echo" <div id='$t3' align=center>
                    <a onclick=fmnext('$page','$x0','$x1','$y0','$y1','$t3')><b><font color=white>$nnext </font></b></a><br /><br />
                    </div>";
                }
                echo"</td></tr>";

            }

        }
        echo"</table>";

    }

    function guesc(Request $request)
    {
        $page = $request['page'];
        $id = $request['id'];
        $preg = $request['preg'];

        $page=$page+1; $page=$page-1;
        if(is_int($page)!="true"){die("");}
        $id=$id+1; $id=$id-1;
        if(is_int($id)!="true"){die("");}
        $preg=$preg+1; $preg=$preg-1;
        if(is_int($preg)!="true"){die("");}

        $shift=$page*100+10+$preg;
        $page=$page+1;

        $admpass="off";
        $Numm = 0;
        if(Auth::user()) {
            $Numm = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $Numm)->where('Page', 'Memory')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if($Alladn>0){$admpass="ok";}
        }

        $Allg = DB::table('gc')->select('Numg', 'Im', 'Priz', 'Num_a', 'Vd')->
        where('Num', $id)->
        orderBy('Vd', 'desc')->
        skip($shift)->take(101)->get();
        $Allgn = $Allg->count();

        if($Allgn>0){

            $delete = __('messages.delete');
            $lan = App::currentLocale();

             $ng=1;
            foreach ($Allg as $Alg) {
                if($ng<101){
                    $avtc = $Alg->Numg; $Img = $Alg->Im; $Prizg = $Alg->Priz;
                    $Num_a = $Alg->Num_a; if($Num_a>0){} else{$Num_a=7;} $Vd = $Alg->Vd;


                    if($avtc>0){
                        $aavt = avt($avtc,$Numm);
                        $aavt = str_replace("forum-avatar", "center-avatar", $aavt);
                        $aavt = str_replace("<br />", "", $aavt);
                        $aavt = str_replace("</svg>", "</svg><br />", $aavt);
                        $aavt = str_replace("</div>", "</div><br />", $aavt);
                    }

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
                        $Vd_e="<p class=grey>$Vd_e</p>";}
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

            if($ng==102){
                $nnext = __('messages.nnext');
                $t1="qwertyuiopasdfghjklzxcvbnm"; $t2="";
                for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t2.="$t1[$z]";}

                echo"<section id=$t2 class=\"forum-menu fcom forum-menu-guest colored mt15\" onClick=guesc('$page','$t2','$preg','$id')>
                        <b>$nnext</b>
                    </section>";

            }
        }

    }




    function guesc_del(Request $request)
    {
        $avt = $request['avt'];
        $id = $request['id'];
        $Vd = $request['Vd'];
        $Vd = str_replace("*", " ", $Vd);
        $id=$id+1; $id=$id-1;
        if(is_int($id)!="true"){die("");}
        $avt=$avt+1; $avt=$avt-1;
        if(is_int($avt)!="true"){die("");}

        if(Auth::user()) {

            $admpass="off";
            $Numm = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $Numm)->where('Page', 'Memory')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if($Alladn>0){$admpass="ok";}

            if($admpass=="ok" || $avt==$Numm) {
                $aff = DB::table('gc')->
                where('Num', $id)->
                where('Numg', $avt)->
                where('Vd', $Vd)->
                delete();

                if($aff){
                    $g_del = __('messages.g_del');
                    echo "<font size=1>$g_del</font>";
                }
            }
        }
    }






    function fguesc(Request $request)
    {
        $page = $request['page'];
        $id = $request['id'];
        $preg = $request['preg'];

        $page=$page+1; $page=$page-1;
        if(is_int($page)!="true"){die("");}
        $id=$id+1; $id=$id-1;
        if(is_int($id)!="true"){die("");}
        $preg=$preg+1; $preg=$preg-1;
        if(is_int($preg)!="true"){die("");}

        $shift=$page*100+10+$preg;
        $page=$page+1;

        $admpass="off";
        $Numm = 0;
        if(Auth::user()) {
            $Numm = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $Numm)->where('Page', 'Foto')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if($Alladn>0){$admpass="ok";}
        }

        $Allg = DB::table('gcf')->select('Numg', 'Im', 'Priz', 'Num_a', 'Vd')->
        where('Num', $id)->
        orderBy('Vd', 'desc')->
        skip($shift)->take(101)->get();
        $Allgn = $Allg->count();

        if($Allgn>0){

            $delete = __('messages.delete');
            $lan = App::currentLocale();

            $ng=1;
            foreach ($Allg as $Alg) {
                if($ng<101){
                    $avtc = $Alg->Numg; $Img = $Alg->Im; $Prizg = $Alg->Priz;
                    $Num_a = $Alg->Num_a; if($Num_a>0){} else{$Num_a=7;} $Vd = $Alg->Vd;

                    if($avtc>0){
                        $aavt = avt($avtc,$Numm);
                        $aavt = str_replace("forum-avatar", "center-avatar", $aavt);
                        $aavt = str_replace("<br />", "", $aavt);
                        $aavt = str_replace("</svg>", "</svg><br />", $aavt);
                        $aavt = str_replace("</div>", "</div><br />", $aavt);
                    }

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
                        $Vd_e="<p class=grey>$Vd_e</p>";}
                    else{$Vd_e="";}

                    $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}


                    echo"<li id=\"$t3\" class=\"colored centered\">$aavt";


                    if($admpass=="ok"||$Numm==$avtc){
                        echo"$Vd_e <a onclick=fguesc_del('$avtc','$Vds','$t3','$id') rel=\"noopener noreferrer\"> $delete</a>";
                    }
                    echo"</li>";
                }
                $ng++;
            }
            echo"</table>";

            if($ng==102){
                $t1="qwertyuiopasdfghjklzxcvbnm"; $t2="";
                for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t2.="$t1[$z]";}
                echo"<section id=$t2 class=\"forum-menu fcom forum-menu-guest colored mt15\" onClick=fguesc('$page','$t2','$preg','$id')>
                        <b>" . __('messages.nnext'). "</b>
                     </section>";
            }
        }
    }




    function fguesc_del(Request $request)
    {
        $avt = $request['avt'];
        $id = $request['id'];
        $Vd = $request['Vd'];
        $Vd = str_replace("*", " ", $Vd);
        $id=$id+1; $id=$id-1;
        if(is_int($id)!="true"){die("");}
        $avt=$avt+1; $avt=$avt-1;
        if(is_int($avt)!="true"){die("");}

        if(Auth::user()) {

            $admpass="off";
            $Numm = Auth::user()->Num;
            $Allad = DB::table('City_Admin2')->select('id')->
            where('Num', $Numm)->where('Page', 'Foto')->where('id', $id)->
            limit(1)->get();
            $Alladn = $Allad->count();
            if($Alladn>0){$admpass="ok";}

            if($admpass=="ok" || $avt==$Numm) {
                $aff = DB::table('gcf')->
                where('Num', $id)->
                where('Numg', $avt)->
                where('Vd', $Vd)->
                delete();

                if($aff){
                    $g_del = __('messages.g_del');
                    echo "<font size=1>$g_del</font>";
                }
            }
        }
    }




    function guesp(Request $request)
    {
        $page = $request['page'];
        $id = $request['id'];
        $preg = $request['preg'];

        $page=$page+1; $page=$page-1;
        if(is_int($page)!="true"){die("");}
        $id=$id+1; $id=$id-1;
        if(is_int($id)!="true"){die("");}
        $preg=$preg+1; $preg=$preg-1;
        if(is_int($preg)!="true"){die("");}

        $shift=$page*100+10+$preg;
        $page=$page+1;


        $Numm = 0;
        if(Auth::user()) {
            $Numm = Auth::user()->Num;
        }

        $Allg = DB::table('gp')->select('Numg', 'Im', 'Priz', 'Num_a', 'Vd')->
        where('Num', $id)->
        orderBy('Vd', 'desc')->
        skip($shift)->take(101)->get();
        $Allgn = $Allg->count();

        if($Allgn>0){


            $delete = __('messages.delete');
            $lan = App::currentLocale();

             $ng=1;
            foreach ($Allg as $Alg) {
                if($ng<101){
                    $avtc = $Alg->Numg; $Img = $Alg->Im; $Prizg = $Alg->Priz;
                    $Num_a = $Alg->Num_a; if($Num_a>0){} else{$Num_a=7;} $Vd = $Alg->Vd;

                    if($avtc>0){
                        $aavt = avt($avtc,$Numm);
                        $aavt = str_replace("forum-avatar", "center-avatar", $aavt);
                        $aavt = str_replace("<br />", "", $aavt);
                        $aavt = str_replace("</svg>", "</svg><br />", $aavt);
                        $aavt = str_replace("</div>", "</div><br />", $aavt);
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
                        $Vd_e="<p class=grey>$Vd_e</p>";
                    }
                    else{$Vd_e="";}

                    $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}

                    echo"<li id=\"$t3\" class=\"colored\">$aavt";

                    if($Numm==$id||$Numm==$avtc){
                        echo"$Vd_e<a href=## onclick=guesp_del('$avtc','$Vds','$t3','$id') rel=\"noopener noreferrer\"> $delete</a>";
                    }
                    echo"</li>";
                }
                $ng++;
            }


            if($ng==102){
                $nnext = __('messages.nnext');
                $t1="qwertyuiopasdfghjklzxcvbnm"; $t2="";
                for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t2.="$t1[$z]";}
                echo"<section id=$t2 class=\"forum-menu fcom forum-menu-guest colored mt15\" onClick=guesp('$page','$t2','$preg','$id')>
                        <b>$nnext</b>
                    </section>";
            }
        }
    }




    function guesp_del(Request $request)
    {
        $avt = $request['avt'];
        $id = $request['id'];
        $Vd = $request['Vd'];
        $Vd = str_replace("*", " ", $Vd);
        $id=$id+1; $id=$id-1;
        if(is_int($id)!="true"){die("");}
        $avt=$avt+1; $avt=$avt-1;
        if(is_int($avt)!="true"){die("");}

        if(Auth::user()) {
            $Numm = Auth::user()->Num;

            if($id==$Numm || $avt==$Numm) {
                $aff = DB::table('gp')->
                where('Num', $id)->
                where('Numg', $avt)->
                where('Vd', $Vd)->
                delete();

                if($aff){
                    $g_del = __('messages.g_del');
                    echo "<font size=1>$g_del</font>";
                }
            }
        }
    }




    function fguesp(Request $request)
    {
        $page = $request['page'];
        $id = $request['id'];
        $preg = $request['preg'];

        $page=$page+1; $page=$page-1;
        if(is_int($page)!="true"){die("");}
        $id=$id+1; $id=$id-1;
        if(is_int($id)!="true"){die("");}
        $preg=$preg+1; $preg=$preg-1;
        if(is_int($preg)!="true"){die("");}

        $shift=$page*100+10+$preg;
        $page=$page+1;

        $Numm = 0;
        if(Auth::user()) {
            $Numm = Auth::user()->Num;
        }

        $Allg = DB::table('gpf')->select('Numg', 'Im', 'Priz', 'Num_a', 'Vd')->
        where('Num', $id)->
        orderBy('Vd', 'desc')->
        skip($shift)->take(101)->get();
        $Allgn = $Allg->count();

        if($Allgn>0){

            $delete = __('messages.delete');
            $lan = App::currentLocale();

             $ng=1;
            foreach ($Allg as $Alg) {
                if($ng<101){
                    $avtc = $Alg->Numg; $Img = $Alg->Im; $Prizg = $Alg->Priz;
                    $Num_a = $Alg->Num_a; if($Num_a>0){} else{$Num_a=7;} $Vd = $Alg->Vd;

                    if($avtc>0){
                        $aavt = avt($avtc,$Numm);
                        $aavt = str_replace("forum-avatar", "center-avatar", $aavt);
                        $aavt = str_replace("<br />", "", $aavt);
                        $aavt = str_replace("</svg>", "</svg><br />", $aavt);
                        $aavt = str_replace("</div>", "</div><br />", $aavt);
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
                        $Vd_e="<p class=grey>$Vd_e</p>";}
                    else{$Vd_e="";}

                    $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}

                    echo"<li id=\"$t3\" class=\"colored centered\">$aavt";

                    if($Numm==$id||$Numm==$avtc){
                        echo"$Vd_e<br /><a onclick=fguesp_del('$avtc','$Vds','$t3','$id') rel=\"noopener noreferrer\"> $delete</a>";
                     }
                    echo"</li>";
                }
                $ng++;
            }

            if($ng==102){
                $nnext = __('messages.nnext');
                $t1="qwertyuiopasdfghjklzxcvbnm"; $t2="";
                for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t2.="$t1[$z]";}
                echo"<section id=$t2 class=\"forum-menu fcom forum-menu-guest colored mt15\" onClick=fguesp('$page','$t2','$preg','$id')>
                        <b>$nnext</b>
                    </section>";
            }
        }
    }




    function fguesp_del(Request $request)
    {
        $avt = $request['avt'];
        $id = $request['id'];
        $Vd = $request['Vd'];
        $Vd = str_replace("*", " ", $Vd);
        $id=$id+1; $id=$id-1;
        if(is_int($id)!="true"){die("");}
        $avt=$avt+1; $avt=$avt-1;
        if(is_int($avt)!="true"){die("");}

        if(Auth::user()) {
            $Numm = Auth::user()->Num;

            if($id==$Numm || $avt==$Numm) {
                $aff = DB::table('gpf')->
                where('Num', $id)->
                where('Numg', $avt)->
                where('Vd', $Vd)->
                delete();

                if($aff){
                    $g_del = __('messages.g_del');
                    echo "<font size=1>$g_del</font>";
                }
            }
        }
    }







}


