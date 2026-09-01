@extends('layouts.app')
@php
$theme = str_ireplace("@s@l@", "/", $theme);
$theme = str_ireplace("@q@w@", "?", $theme);
$lan = __('messages.lan');

$Forum2 = __('messages.Forum2');
$Forum3 = __('messages.Forum3');
$no_records = __('messages.no_records');


$nd=0;
if($idrec>0){
                $Num=0;
                $Alls = DB::table('Memoryp')->
            select('Num')-> where('idrec', $idrec)-> limit(1)-> get();
                foreach ($Alls as $All) { $Num=$All->Num; $id = $Num; }

            $domen=0;
            $Alls = DB::table('users')->
            select('domen')->where('Num', $Num)->limit(1)-> get();
                foreach ($Alls as $All) { $domen=$All->domen;}

}
if($domen) {

    $Alls = DB::table('users')->
     select('Num', 'Im', 'Priz', 'Bat', 'avatar',
      'Wherer', 'idc', 'Adr', 'aktiv', 'rate', 'Md')->
       where('domen', $domen)-> limit(1)-> get();
        $nd=0;
    foreach ($Alls as $All) {
        $id=$All->Num; $Im=$All->Im; $Priz=$All->Priz; $Bat=$All->Bat; $avatar=$All->avatar;
        $Wherer=$All->Wherer; $idc=$All->idc; $Adr=$All->Adr; $rate=$All->rate; $Md=$All->Md; $aktiv=$All->aktiv;

        $nd++; $Num = $id;
    }

    if($nd==0){
        $title = __('messages.unknown_page');
        $description = $title;
        $keywords = $title;
        $Im=""; $Priz=""; $avatar=""; $Bat=""; $l_visitm=""; $aktiv=0;
            $index_go = "noindex,follow";
            $path0="/7.jpg";
            $path1="/b7.jpg";
    }
    else {$title0 = __('messages.Blog'); $title = $title0.=" - $Im $Priz";
        if ($avatar>0){$path0 = "/storage/avatar/$avatar.jpg"; $path1 = "/storage/avatar/b$avatar.jpg"; }
        else {$path0="/7.jpg"; $path1="/b7.jpg";}

        if (Auth::user()){

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


        $Alls = DB::table('Private')->select('Page', 'Forum',  'ipban')->
            where('Num', $id)->limit(1)->get();
                $pr=0;
            foreach ($Alls as $All) { $Sh_Page=$All->Page;
             $Forum=$All->Forum; $ipban=$All->ipban;
             $pr++; }
            if($pr==0) {$Sh_Page=1; $Forum=1; $ipban="";}

            $Privatpass="stop";
            if($Sh_Page==1 || !$Sh_Page){$Privatpass="go";}
             else{if($Sh_Page==2 && Auth::user()){$Privatpass="go";}
              else{
                if($Sh_Page==3 && ($id==$my_id || $isfriend != "")){ $Privatpass="go"; }
                else if($Sh_Page==4&&$Num==$my_id){$Privatpass="go";}
              }
             }


             if($aktiv != 1){$Privatpass="stop";}
             $ip = $_SERVER['REMOTE_ADDR'];
            if(strstr($ipban, $ip)!=""){$Privatpass="stop";}

            if($Privatpass=="go"){$index_go="index,follow";}
            if($Privatpass=="stop"){$index_go="noindex,follow";}

    $description = __('messages.irec_description');
    $keywords = __('messages.irec_keywords');
    }
}
else{
    $title = __('messages.unknown_page');
    $description = $title;
    $keywords = $title;
    $Im=""; $Priz=""; $avatar=""; $Bat=""; $l_visitm=""; $aktiv=0;
        $index_go = "noindex,follow";
        $path0="/7.jpg";
        $path1="/b7.jpg";
}


@endphp
@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection
@section('image'){{$path1}}@endsection

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
    @elseif($Sh_Page==5)
        @php $unnp2 = __('messages.del_page'); @endphp
        <br /><br /><br /><div align='center'><table class=fcom><tr><td align=center>
                        <div style="align-content: center; padding-right: 30px; padding-left: 30px" >
                            <h4><br />{{  __('messages.del_page') }}<br /><br /><a href="javascript:history.go(-1)">{{  __('messages.unknown_page4') }}</a><br /><br /></h4>
                        </div>
                    </td></tr></table></div><br /><br /><br /><br />
    @elseif($Privatpass=="stop")
                <br /><br /><br /><div align='center'><table class=fcom><tr><td align=center>
                        <div style="align-content: center; padding-right: 30px; padding-left: 30px" >
                            <table><tr><td><img src = "{{$path0}}"></td><td width="20"></td><td><br /><h4><b>{{$Im}} {{$Priz}}</b><br />
                            <br />{{ __('messages.hid_page') }} <br /><br /><a href="javascript:history.go(-1)">{{  __('messages.unknown_page4') }}</a><br /><br /></h4>
                            </td></tr></table>
                        </div>
                    </td></tr></table></div><br /><br /><br /><br />
        @php $link = "spid$id";
            echo "<html><head><meta http-equiv='refresh' content='3; url=/$link'></head></html>"; @endphp
    @else
        <div  align = center>


    @php

    $pref_page = __('messages.pref_page'); $ppref_page = $pref_page .="i";
    $time_sec=time();

    if($theme=="0" && $page=="0"){$nthem=1000;} else {$nthem = 5; }
    if($idrec>0){$nthem = 5; }

    $Allt = DB::table('Memoryp')
    ->where('Num',$id)
    ->Where(function($query) {
     $query->whereNotNull('theme')
         ->Where('theme','!=','');
    })
     ->select('theme',DB::raw('MAX(Md) AS mmd'), 'avt', 'Aboutep')
    ->orderBy('mmd','Desc')
    ->groupBy('theme')
    ->limit($nthem)
    ->get();
        $Alltn = $Allt->count();
        if($Alltn>0){$Forum = __('messages.Forum');
        echo"
        <table><tr><td width=535 class=fcom align = center>
            <div style=\"maxwidth: 505px; overflow: hidden; margin: 5px 15px 0px 15px;\">
            <table><tr><td width=505 align = center><h2>$Forum <a href=/$domen/$lan>$Im $Priz</a></h2><h4>$Forum2</h4><br /></td></tr></table>
            <table><tr><td width=505 align = left>";

            $ntop = 1;
            foreach ($Allt as $All) {
                $them=$All->theme; $M6=$All->mmd; $avt=$All->avt; $Aboute=$All->Aboutep;

                if(mb_strlen($them)>0){

                     if((int)$avt>0){
                        $pageq = last_visit_read($avt);
                        if ($pageq) {
                            $q_Im=$pageq['im']; $q_Priz=$pageq['priz'];
                             $t = last_visit_ts_diff($pageq);
                             if ($t<=500 && $my_id!=$avt){$online = __('messages.online'); $qonl = " <font color=green>$online</font>";} else {$qonl = "";}
                            $aavt = "<a href=/$ppref_page$avt>$q_Im  $q_Priz</a>$qonl";
                         }else {$aavt = "";}
                    }else {$aavt = ""; }

                $M6_e= db_date($M6);

                    if (preg_match("/<[^<]+>/",$Aboute) != 0){$Abt = "";}
                    else { $Abt = mb_substr($Aboute, 0, 30); $Abt.="...";}

                    $theml = str_ireplace("/", "@s@l@", $them);  $theml = str_ireplace("?", "@q@w@", $theml);
                    echo"<a href=\"/$domen/forum/$lan/0/$theml\"><b>$them</b> $Abt</a>
                    <table><tr><td width=150> $M6_e </td><td>$aavt</td></tr></table><br />";

                }
                $ntop++;
                if($ntop==6 && ($theme!="0" || $page!="0")){  $Forum3 = __('messages.Forum3');
                echo "<a href =\"/$domen/forum/$lan/0/0\"><b>$Forum3 </b></a><br /><br />";
                break;
                }
            }
            echo"</td></tr></table></div></td></tr></table>";
        }




        $id = $id + 1; $id = $id - 1;
        if (is_int($id) != "true") { die("");}
        $page = $page + 1; $page = $page - 1;

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
                 $Allm =DB::table('Memoryp')->select('Num')
                ->where('theme',$theme)
                ->where('Num',$id)
                ->orderBy('Md','Desc')
                ->get();
                $nrr = $Allm->count();

                if($nrr==0){

                    $theme_s = "%$theme%";
                        $Allm =DB::table('Memoryp')->select('Num')
                    ->orWhere(function($query) use ($theme_s, $theme) {
                     $query->where('Aboutep', 'like', $theme_s)
                     ->orWhere('theme',$theme);
                    })
                    ->where('Num',$id)
                    ->orderBy('Md','Desc')
                    ->get();
                    $nrr = $Allm->count();
                }
        }
        else{
            $Allm =DB::table('Memoryp')->select('Num')
                 ->orWhere(function($query) {
                     $query->whereNull('theme')
                         ->orWhere('theme','');
                 })
                ->where('Num',$id)
                ->orderBy('Md','Desc')
                ->get();
                $nrr = $Allm->count();
        }


            if($Alltn==0 && $nrr>0){$Forum = __('messages.Forum');
                        echo"<br /><table><tr><td width=535 class=fcom align = center>
            <div style=\"maxwidth: 505px; overflow: hidden; margin: 5px 15px 5px 15px;\">
            <table><tr><td width=505 align = center><h2> $Forum <a href=/$domen/$lan>$Im $Priz</a></h2></td></tr></table>
            </div></td></tr></table>";
            }
            if($nrr == 0){$Forum = __('messages.Forum');
                        echo"<br /><br /><br /><table><tr><td width=535 class=fcom align = center>
            <div style=\"maxwidth: 505px; overflow: hidden; margin: 5px 15px 0px 15px;\">
            <table><tr><td width=505 align = center><h2> $Forum <a href=/$domen/$lan>$Im $Priz</a></h2><h4>$no_records</h4><br /></td></tr></table>
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




            @if($my_id>0 && $my_id!=999999999999999)
                <script>
                    function sml_red(purp) {
                        $.ajaxSetup({
                            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                        });
                        var formData = {
                            purp: purp
                        };
                        $.ajax({
                            type: 'POST',
                            url: '/sml_add',
                            data: formData,
                            cache: false,
                            success:function(data){
                                document.getElementById('app_mem_add').innerHTML=data;
                            }
                        });
                    }
                    function smlin(sml) {
                        sml=sml.replace(".gif", ".gif>");
                        var memt = document.getElementById('memt').value;
                        if(memt){memt = memt + " "; }
                        memt = memt + sml;
                        var txt = document.getElementById('memt');
                        txt.value = memt;
                    }

                </script>
                <table><tr><td height=2></td></tr></table>
                <div id="memt_res"></div>
                <table><tr><td width=535 class=fcom>
                            <div id=\"m$t2\" style="maxwidth: 505px; overflow: hidden; margin: 10px 15px 0px 15px;">
                                <table><tr><td width=295 align=center>
                                            <textarea ID="memt" rows=2 cols=40 placeholder="{{__('messages.mem_in_t')}}" onFocus="clearsp('memt','mem_add');"></textarea>
                                        </td></tr></table>
                                <div id="mem_add" style="display: none;">
                                    <input id="theme_in" size=47 maxlength = 70 placeholder="{{__('messages.mem_in_tem')}}" value="{{$theme_in}}">
                                    <table><tr><td class="fcomblue" width=200>
                                                <ul class="intop"><li><a href = ### onclick=mem_addp('{{$id}}')> {{__('messages.Add')}} </a></li></ul>
                                            </td><td width="1"></td><td><a onclick=smlp('default')>&nbsp;<img border=0 src=/sml/2.gif title='{{__('messages.sml')}}'> &nbsp;</a></td></tr></table>

                                    <div id="app_mem"></div>
                                    <div id="app_mem_add"></div>
                                </div><br />
                            </div>
                        </td></tr></table>
            @endif



            @php



            echo"<div style = \"margin: 5px 0px 0px 0px;\"><table align=center><tr>
            <td align=center width=177 class=$qwans_st><b><a href=\"/$domen/forum/$lan/0/qwans\">$qwans</a></b></td>
            <td align=center width=177 class=$enterv_st><b><a href=\"/$domen/forum/$lan/0/enterv \">$enterv</a></b></td>
            <td align=center width=177 class=$All_rec_st><b><a href=\"/$domen/forum/$lan/0/0\">$All_rec</a></b></td></tr>
            </table></div>
            ";


if($idrec>0){

         $Allm =DB::table('Memoryp')->select('afisha', 'theme', 'idrec','Aboutep','r_gol','r_kol','rh','Md','Ip','avt')
    ->where('idrec',$idrec)
    ->limit(1)->get();

         foreach ($Allm as $All) {
    $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutep; $r_gol=$All->r_gol;
    $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt; $rh=$All->rh;

    echo view('inc.memoryp', ['id' => $id, 'afisha' => $afisha, 'themeg' => $themeg, 'idrec' => $idrec, 'M1' => $M1,
        'r_gol' => $r_gol, 'r_kol' => $r_kol, 'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'rh' => $rh, 'purp' => 'def']);
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

                     $Allm =DB::table('Memoryp')->select('afisha', 'theme', 'idrec','Aboutep','r_gol','r_kol','rh','Md','Ip','avt')
                    ->where('theme',$theme)
                    ->where('Num',$id)
                    ->orderBy('Md','Desc')
                    ->skip($shift)->take($limit)
                    ->get();
                    $nrr2 = $Allm->count();

                    if($nrr2==0){
                        $theme_s = "%$theme%";
                            $Allm =DB::table('Memoryp')->select('afisha', 'theme', 'idrec','Aboutep','r_gol','r_kol','rh','Md','Ip','avt')
                        ->orWhere(function($query) use ($theme_s, $theme) {
                         $query->where('Aboutep', 'like', $theme_s)
                         ->orWhere('theme',$theme);
                        })
                        ->where('Num',$id)
                        ->orderBy('Md','Desc')
                        ->skip($shift)->take($limit)
                        ->get();
                    }
            }
            else{
                $Allm =DB::table('Memoryp')->select('afisha', 'theme', 'idrec','Aboutep','r_gol','r_kol','rh','Md','Ip','avt')
                 ->orWhere(function($query) {
                     $query->whereNull('theme')
                         ->orWhere('theme','');
                 })
                ->where('Num',$id)
                ->orderBy('Md','Desc')
                ->skip($shift)->take($limit)
                ->get();
            }

            foreach ($Allm as $All) {
                $afisha=$All->afisha; $themeg=$All->theme; $idrec=$All->idrec; $M1=$All->Aboutep; $r_gol=$All->r_gol;
                $r_kol=$All->r_kol; $M6=$All->Md; $Ipmp=$All->Ip; $avt=$All->avt; $rh=$All->rh;

                echo view('inc.memoryp', ['id' => $id, 'afisha' => $afisha, 'themeg' => $themeg, 'idrec' => $idrec, 'M1' => $M1,
                    'r_gol' => $r_gol, 'r_kol' => $r_kol, 'M6' => $M6, 'Ipmp' => $Ipmp, 'avt' => $avt, 'rh' => $rh, 'purp' => 'def']);
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



    <br /><br />
@endsection
