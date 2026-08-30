@extends('layouts.app')
@php
$theme = str_ireplace("@s@l@", "/", $theme);
$theme = str_ireplace("@q@w@", "?", $theme);
$lan = __('messages.lan');
$no_records = __('messages.no_records');
$nd=0;


if($idrec>0){
                $id=0;
                $Alls = DB::table('Memory')->
            select('id')-> where('idrec', $idrec)-> limit(1)-> get();
                foreach ($Alls as $All) { $id=$All->id;}

                $domen=0;
            $Alls = DB::table('Allcities')->
            select('domen')->where('id', $id)->limit(1)-> get();
                foreach ($Alls as $All) { $domen=$All->domen;}

}
if($domen) {

            $Alls = DB::table('Allcities')->
            select('id', 'rayc', 'City', 'City2', 'City3', 'sumr', 'obl', 'status', 'x', 'y', 'z', 'vol_karta', 'face_karta', 'oblc',
            'apps', 'City_m', 'City_o', 'City_r', 'City_d', 'rod', 'dat', 'tvor',
             'predl', 'ab', 'sumr')->
                where('domen', $domen)-> limit(1)-> get();
                    $nd=0;
                foreach ($Alls as $All) {
                     $id=$All->id; $rayc=$All->rayc; $City1=$All->City;  $City2=$All->City2;  $City3=$All->City3;
                     $obl=$All->obl; $status=$All->status;
                      $vol_karta=$All->vol_karta;  $face_karta=$All->face_karta;  $oblc=$All->oblc;  $apps=$All->apps;
                       $City_m=$All->City_m;  $City_o=$All->City_o;  $City_r=$All->City_r;  $City_d=$All->City_d;
                        $rod=$All->rod;  $dat=$All->dat;  $tvor=$All->tvor;  $predl=$All->predl;
                          $ab=$All->ab; $rate=$All->sumr;
                        $pagec = explode("#!", $ab); $nrm7=$pagec[8];

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
                    $rayc=""; $City="";  $City2=""; $City3="";
                     $obl=""; $status="";
                      $vol_karta=""; $face_karta=""; $oblc=""; $apps="";
                       $City_m=""; $City_o=""; $City_r=""; $City_d="";
                        $rod=""; $dat=""; $tvor=""; $predl="";
                        $id="";  $ab="";
                      $index_go = "noindex,follow"; $path1 = ""; $fpath=""; $flinka = "";
                       $nrm7=""; $City_s="";
                      $City_in=""; $City_of=""; $City_by=""; $City_to=""; $rate = "";

                }
                else {
                     if ($status){
                        if ($status==1){
                            $statusn=__('messages.statusn1');
                            $statusnv=__('messages.statusnv1');
                            $statusr=__('messages.statusr1');
                            $statusd=__('messages.statusd1');
                            $statusm=__('messages.statusm1');
                            $statuso=__('messages.statuso1');
                            $statuspro=__('messages.statuspro1');
                        }
                        if ($status==2){
                            $statusn=__('messages.statusn2');
                            $statusnv=__('messages.statusnv2');
                            $statusr=__('messages.statusr2');
                            $statusd=__('messages.statusd2');
                            $statusm=__('messages.statusm2');
                            $statuso=__('messages.statuso2');
                            $statuspro=__('messages.statuspro2');
                        }
                        if ($status==3){
                            $statusn=__('messages.statusn3');
                            $statusnv=__('messages.statusnv3');
                            $statusr=__('messages.statusr3');
                            $statusd=__('messages.statusd3');
                            $statusm=__('messages.statusm3');
                            $statuso=__('messages.statuso3');
                            $statuspro=__('messages.statuspro3');
                        }
                        if ($status==4){
                            $statusn=__('messages.statusn4');
                            $statusnv=__('messages.statusnv4');
                            $statusr=__('messages.statusr4');
                            $statusd=__('messages.statusd4');
                            $statusm=__('messages.statusm4');
                            $statuso=__('messages.statuso4');
                            $statuspro=__('messages.statuspro4');
                        }
                        if ($status==5){
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
                        if (!$vol_karta||$vol_karta<20000){
                                $statusn=__('messages.statusn4');
                                $statusnv=__('messages.statusnv4');
                                $statusr=__('messages.statusr4');
                                $statusd=__('messages.statusd4');
                                $statusm=__('messages.statusm4');
                                $statuso=__('messages.statuso4');
                                $statuspro=__('messages.statuspro4');
                        }
                        if ($vol_karta>=20000&&$vol_karta<50000){
                                $statusn=__('messages.statusn6');
                                $statusnv=__('messages.statusnv6');
                                $statusr=__('messages.statusr6');
                                $statusd=__('messages.statusd6');
                                $statusm=__('messages.statusm6');
                                $statuso=__('messages.statuso6');
                                $statuspro=__('messages.statuspro6');
                        }
                        if ($vol_karta>=50000){
                                $statusn=__('messages.statusn1');
                                $statusnv=__('messages.statusnv1');
                                $statusr=__('messages.statusr1');
                                $statusd=__('messages.statusd1');
                                $statusm=__('messages.statusm1');
                                $statuso=__('messages.statuso1');
                                $statuspro=__('messages.statuspro1');
                        }
                    }



            $ob_user2 = __('messages.Region3');

                      for ($i = 0; $i <= 25; $i++){
                         $ni2 = "messages.oo$i"; $ii = "$i";
                           if($obl == $ii){ $nii2 = __($ni2); if($obl == "1"){ $ob_user2 = "";}
                           $obl_user2 = "$nii2 $ob_user2";
                          if (App::isLocale('ru')){ $obl_user="<a href=/rse$i>$nii2 $ob_user2</a>"; $City=$City2; $City_s="City2"; if(mb_strlen($rod)>2){$City_r = $rod;} else{$City_r=$City2;}}
                          else if (App::isLocale('en')){  $obl_user="<a href=/ese$i>$nii2 $ob_user2</a>"; $City=$City3; $City_s="City3"; $City_r = "of $City3";}
                          else {$obl_user="<a href=/se$i>$nii2 $ob_user2</a>"; $City=$City1; $City_s="City";}
                           }
                      }
        $news = __('messages.news');  $Forum = __('messages.Forum');
        if($id==$oblc){$title = "$Forum $statusr $City";}
        else if($id==$rayc){$title = "$Forum $statusr $City $obl_user2 - $news";}
        else{$title = "$Forum $statusr $City $obl_user2: $news";}

        $index_go = "index,follow";

        $description1 = __('messages.Forum');
        $description3 = __('messages.c3_description');
        $description = "$description1 $statusr $description3";
        $keywords1 = __('messages.c1_keywords');
        $keywords3 = __('messages.c3_keywords');
        $in = __('messages.in');
        $keywords = "$statusnv $City $obl_user2, $keywords1 $in $statusm $City_in, $statuso $City_by, $statusd $City_to, $keywords3 $statusr";

        $flink1 = "/storage/karta/$obl/$id.jpg";
        $flink0 = "/storage/karta/$obl/face_$id.jpg";
        $file1 = public_path($flink1);
        $file0 = public_path($flink0);
        $tmap = __('messages.tmap');

        if(file_exists($file0)){ $fpath = $flink0;
        $flinka = "<table><tr><td align=center width=220 class=fcom><h4>$tmap $City_of</h4><a href=\"$flink1\"><div class=\"scale\"><img title=\"$statusnv $City\" src=$flink0></div></a><br /><br /></td></tr></table><br />";}
        else if(file_exists($file1)){ $fpath = $flink1;
        $flinka = "<table><tr><td align=center width=220 class=fcom><h4>$tmap  $City_of</h4><div class=\"scale\"><img title=\"$statusnv $City\" src=$flink1></div><br /><br /></td></tr></table><br />";}
        else {$fpath = "";  $flinka = "";}

        }


}
else{

        $title = __('messages.unknown_page');
    $description = $title;
    $keywords = $title;
    $rayc=""; $City="";  $City2=""; $City3="";
     $obl=""; $status="";
      $vol_karta=""; $face_karta=""; $oblc=""; $apps="";
       $City_m=""; $City_o=""; $City_r=""; $City_d="";
        $rod=""; $dat=""; $tvor=""; $predl="";
        $id="";  $ab="";
      $index_go = "noindex,follow"; $path1 = ""; $fpath=""; $flinka = "";
      $nrm7=""; $City_s="";
      $City_in=""; $City_of=""; $City_by=""; $City_to=""; $rate = "";

}
@endphp
@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection
@section('image'){{$fpath}}@endsection

@section('content')

    @if($nd==0)

        @if($domen) @php $unnp2 = __('messages.unknown_page2'); @endphp
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

                    $sq=0;
        $Allq = DB::table('Privatec')->select('ComForBan')->
            where('id', $id)->limit(1)->get();
            foreach ($Allq as $Alq) { $ComForBan=$Alq->ComForBan; $sq++; }
            if($sq==0){$ComForBan = "";}

            @endphp
        @endguest

    <div  align = center>

    @php

    $pref_page = __('messages.pref_page'); $ppref_page = $pref_page .="i";
    $time_sec=time();

    if($theme=="0" && $page=="0"){$nthem=1000;} else {$nthem = 5; }
    if($idrec>0){$nthem = 5; }

    $Allt = DB::table('Memory')
    ->where('id',$id)
    ->Where(function($query) {
     $query->whereNotNull('theme')
         ->Where('theme','!=','');
    })
     ->select('theme',DB::raw('MAX(Md) AS mmd'), 'avt', 'Nameg', 'Whog', 'Aboutec')
    ->orderBy('mmd','Desc')
    ->groupBy('theme')
    ->limit($nthem)
    ->get();
        $Alltn = $Allt->count();
        if($Alltn>0){$Forum = __('messages.Forum'); $Forum2 = __('messages.Forum2'); $lan = __('messages.lan');
        echo"<br /><table><tr><td width=535 class=fcom align = center>
            <div style=\"maxwidth: 505px; overflow: hidden; margin: 5px 15px 0px 15px;\">
            <table><tr><td width=505 align = center><h2>$Forum <a href=/$domen/$lan>$City_r</a></h2><h4>$Forum2</h4><br /></td></tr></table>
            <table><tr><td width=505 align = left>";

            $ntop = 1;
            foreach ($Allt as $All) {
                $them=$All->theme; $M6=$All->mmd; $avt=$All->avt; $Nameg=$All->Nameg;
                $Whog=$All->Whog; $Aboute=$All->Aboutec;
                if(mb_strlen($them)>0){

                     if((int)$avt>0){
                        $filename = "storage/last_visit/$avt.txt";
                        if (file_exists($filename) && filesize($filename) > 0) {
                            $whattoread = @fopen($filename, "r");
                            $file_contents = fread($whattoread, filesize($filename)); fclose($whattoread);
                             $pageq = explode("#!:*&", $file_contents);
                            $q_Im=$pageq[1]; $q_Priz=$pageq[2];
                             $time_file=filemtime($filename); $t=$time_sec-$time_file;
                             if ($t<=500 && $my_id!=$avt){$online = __('messages.online'); $qonl = " <font color=green>$online</font>";} else {$qonl = "";}
                            $aavt = "<a href=/$ppref_page$avt>$q_Im  $q_Priz</a>$qonl";
                         }else {$aavt = "";}
                    }else {$aavt = "$Nameg ($Whog)"; }

                     $M6_e= db_date($M6);

                    if (preg_match("/<[^<]+>/",$Aboute) != 0){$Abt = "";}
                    else { $Abt = mb_substr($Aboute, 0, 30); $Abt.="...";}

                     $theml = str_ireplace("/", "@s@l@", $them); $theml = str_ireplace("?", "@q@w@", $theml);
                    echo"<a href=\"/$domen/forum/$lan/0/$theml\"><b>$them</b> $Abt</a>
                    <table><tr><td width=150> $M6_e </td><td>$aavt</td></tr></table><br />";



                }
                $ntop++;
                if($ntop==6 && ($theme!="0" || $page!="0")){  $Forum3 = __('messages.Forum3');
                echo "<a href =\"/$domen/forum/$lan/0/0\"><b>$Forum3 $statusr</b></a><br /><br />";
                break;
                }
            }
            echo"</td></tr></table></div></td></tr></table>";
        }



        $page = (int)$page + 1; $page = (int)$page - 1;


            $qwans = __('messages.qwans');
            $enterv = __('messages.enterv');
            $All_rec = __('messages.All_rec');
            if($theme != "") {
                if($theme == "qwans"){$theme ="%^&@#";}
                if($theme == "enterv"){$theme ="*&^@72438484";}
                if($theme=="*&^@72438484"){$theme_e=$enterv;}
                else if($theme=="%^&@#"){$theme_e=$qwans;}
                else{$theme_e=$theme;}

            }


        if ($theme){
                 $Allm =DB::table('Memory')->select('id')
                ->where('theme',$theme)
                ->where('id',$id)
                ->orderBy('Md','Desc')
                ->get();
                $nrr = $Allm->count();

                if($nrr==0){

                    $theme_s = "%$theme%";
                        $Allm =DB::table('Memory')->select('id')
                    ->orWhere(function($query) use ($theme_s, $theme) {
                     $query->where('Aboutec', 'like', $theme_s)
                     ->orWhere('theme',$theme);
                    })
                    ->where('id',$id)
                    ->orderBy('Md','Desc')
                    ->get();
                    $nrr = $Allm->count();
                }
        }
        else{
            $Allm =DB::table('Memory')->select('id')
                 ->orWhere(function($query) {
                     $query->whereNull('theme')
                         ->orWhere('theme','');
                 })
                ->where('id',$id)
                ->orderBy('Md','Desc')
                ->get();
                $nrr = $Allm->count();
        }
            if($Alltn==0 && $nrr>0){$Forum = __('messages.Forum');
                        echo"<br /><table><tr><td width=535 class=fcom align = center>
            <div style=\"maxwidth: 505px; overflow: hidden; margin: 5px 15px 5px 15px;\">
            <table><tr><td width=505 align = center><h2> $Forum <a href=/$domen/$lan>$City_r</a></h2></td></tr></table>
            </div></td></tr></table>";
            }
            if($nrr == 0){$Forum = __('messages.Forum');
                        echo"<br /><br /><br /><table><tr><td width=535 class=fcom align = center>
            <div style=\"maxwidth: 505px; overflow: hidden; margin: 5px 15px 0px 15px;\">
            <table><tr><td width=505 align = center><h2> $Forum <a href=/$domen/$lan>$City_r</a></h2><h4>$no_records</h4><br /></td></tr></table>
            </div></td></tr></table>";
            }
            $tfull = "fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\"";
            $tnull = "fcom0";
            if($theme=="0"){$All_rec_st = $tnull;} else{$All_rec_st = $tfull;}
            if($theme=="%^&@#"){$qwans_st = $tnull;} else{$qwans_st = $tfull;}
            if($theme=="*&^@72438484"){$enterv_st = $tnull;} else{$enterv_st = $tfull;}
            if($theme=="0" || $theme=="%^&@#" || $theme=="*&^@72438484"){$theme_in = ""; }
            else{$theme_in = $theme; }
            if($idrec>0){$All_rec_st = $tfull;}


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
                                    <input id="theme_in" size=47 maxlength = 70 placeholder="{{__('messages.mem_in_tem')}}" value="{{$theme_in}}">
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





@php

        echo"<div style = \"margin: 5px 0px 0px 0px;\"><table align=center><tr>
            <td align=center width=177 class=$qwans_st><b><a href=\"/$domen/forum/$lan/0/qwans\">$qwans</a></b></td>
            <td align=center width=177 class=$enterv_st><b><a href=\"/$domen/forum/$lan/0/enterv \">$enterv</a></b></td>
            <td align=center width=177 class=$All_rec_st><b><a href=\"/$domen/forum/$lan/0/0\">$All_rec</a></b></td></tr>
            </table></div>
            ";





if($idrec>0){

     $Allm =DB::table('Memory')->select('afisha', 'theme', 'idrec','Aboutec','Nameg','Whog','r_gol','r_kol','rh','Md','Ip','avt')
    ->where('idrec',$idrec)
    ->limit(1)->get();

             foreach ($Allm as $All) {
            $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutec; $M2=$All->Nameg; $M3=$All->Whog; $r_gol=$All->r_gol;
            $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt; $rh=$All->rh;

            echo view('inc.memory', ['id' => $id, 'afisha' => $afisha, 'themeg' => $themeg, 'idrec' => $idrec, 'M1' => $M1, 'M2' => $M2, 'M3' => $M3, 'r_gol' => $r_gol, 'r_kol' => $r_kol,
                'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'admpass' => $admpass, 'rh' => $rh, 'purp' => 'def']);
        }

 }
else{
    if((!$page)||$page==0){$page=1;}



    $limit = substr($nrr, strlen($nrr)-1, 1);
    if($limit==0){$limit=10; $limit10=1;} else{$limit10="";}


    $nrr_pages=intval($nrr/10);
    if($limit10!=1){$nrr_pages=$nrr_pages+1;}

    if($page==$nrr_pages){$shift=0;}
    else{
    $shift=$limit + 10*($nrr_pages - $page-1);
    $limit=10;
    }




    $l1=$page-3;
    $l2=$page+3;
    if($l2>$nrr_pages){$l2=$nrr_pages;}

    echo"<br /><table><tr><td align=center width=535><table width=100%><tr>";
    if($l2!=$nrr_pages){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=\"/$domen/forum/$lan/$nrr_pages/$theme\"><b><font color=white>$nrr_pages</font></b></a></li></ul> </td>";}
    if(($nrr_pages-$l2)>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}

    for($l2; $l1<=$l2; $l2--){

    if($l2>0 && $l2<=$nrr_pages){

        if($page!=$l2){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=\"/$domen/forum/$lan/$l2/$theme\"><b><font color=white>$l2</font></b></a></li></ul> </td>";}
        else{echo"<td class=fcom0 align=center> <b>$l2</b> </td>";}
    }

    }
    if($l2>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}
    if($l2>0){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=\"/$domen/forum/$lan/1/$theme\"><b><font color=white>1</font></b></a></li></ul> </td>";}
    echo"</tr></table>
    </td>
    </tr></table><br />";



            if ($theme){

                     $Allm =DB::table('Memory')->select('afisha', 'theme', 'idrec','Aboutec','Nameg','Whog','r_gol','r_kol','rh','Md','Ip','avt')
                    ->where('theme',$theme)
                    ->where('id',$id)
                    ->orderBy('Md','Desc')
                    ->skip($shift)->take($limit)
                    ->get();
                    $nrr2 = $Allm->count();

                    if($nrr2==0){
                        $theme_s = "%$theme%";
                            $Allm =DB::table('Memory')->select('afisha', 'theme', 'idrec','Aboutec','Nameg','Whog','r_gol','r_kol','rh','Md','Ip','avt')
                        ->orWhere(function($query) use ($theme_s, $theme) {
                         $query->where('Aboutec', 'like', $theme_s)
                         ->orWhere('theme',$theme);
                        })
                        ->where('id',$id)
                        ->orderBy('Md','Desc')
                        ->skip($shift)->take($limit)
                        ->get();
                    }
            }
            else{
                $Allm =DB::table('Memory')->select('afisha', 'theme', 'idrec','Aboutec','Nameg','Whog','r_gol','r_kol','rh','Md','Ip','avt')
                     ->orWhere(function($query) {
                         $query->whereNull('theme')
                             ->orWhere('theme','');
                     })
                    ->where('id',$id)
                    ->orderBy('Md','Desc')
                    ->skip($shift)->take($limit)
                    ->get();
            }

            foreach ($Allm as $All) {
                $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutec; $M2=$All->Nameg; $M3=$All->Whog; $r_gol=$All->r_gol;
                $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt; $rh=$All->rh;

                echo view('inc.memory', ['id' => $id, 'afisha' => $afisha, 'themeg' => $themeg, 'idrec' => $idrec, 'M1' => $M1, 'M2' => $M2, 'M3' => $M3, 'r_gol' => $r_gol, 'r_kol' => $r_kol,
                    'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'admpass' => $admpass, 'rh' => $rh, 'purp' => 'def']);
            }

    $l1=$page-3;
    $l2=$page+3;
    if($l2>$nrr_pages){$l2=$nrr_pages;}

    echo"<br /><table><tr><td align=center width=535><table width=100%><tr>";
    if($l2!=$nrr_pages){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=\"/$domen/forum/$lan/$nrr_pages/$theme\"><b><font color=white>$nrr_pages</font></b></a></li></ul> </td>";}
    if(($nrr_pages-$l2)>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}

    for($l2; $l1<=$l2; $l2--){

    if($l2>0 && $l2<=$nrr_pages){

        if($page!=$l2){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=\"/$domen/forum/$lan/$l2/$theme\"><b><font color=white>$l2</font></b></a></li></ul> </td>";}
        else{echo"<td class=fcom0 align=center> <b>$l2</b> </td>";}
    }

    }
    if($l2>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}
    if($l2>0){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=\"/$domen/forum/$lan/1/$theme\"><b><font color=white>1</font></b></a></li></ul> </td>";}


    echo"</tr></table>
    </td>
    </tr></table>";
}
    @endphp
        <br /><br />
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

        <div style="display: none;" id="fc">{{$_SERVER['REQUEST_URI']}}</div>
        <div style="display: none;" id="rate">{{$rate}}</div>
        <div style="display: none;" id="id_page">{{$id}}</div>

    @endif
@endsection
