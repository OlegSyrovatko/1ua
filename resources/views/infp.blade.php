@extends('layouts.app')

@php
$title = __('messages.p_title');
$description = __('messages.p_description');
$keywords = __('messages.p_keywords');
$index_go="index,follow";

if(isset($_POST['idc'])){$idc = $_REQUEST['idc'];}
else if(isset($idc)){}else {$idc = "";}
if(isset($_POST['obl'])){$obl = $_REQUEST['obl'];}
else if(isset($obl)){}else {$obl = "";}
if(isset($_POST['id'])){$id = $_REQUEST['id'];}
else if(isset($id)){}else {$id = "";}


                    if($_REQUEST){
                        $Im = $_REQUEST['Im'] ?? ''; $Bat = $_REQUEST['Bat']; $Priz = $_REQUEST['Priz'];
                        $Who = $_REQUEST['Who']; $sex = $_REQUEST['sex']; $email_seek = $_REQUEST['email_seek'];
                        $partner = $_REQUEST['partner']; $aktivn = $_REQUEST['aktivn'];
                        if(isset($_POST['ava']) && $_POST['ava']!="") {$ava = "Yes"; $q_s[15] = ['avatar', '>', 10];}
                        else {$ava = ""; }
                        $political = $_REQUEST['political']; $tabak = $_REQUEST['tabak']; $alkoh = $_REQUEST['alkoh'];
                        $insign = $_REQUEST['insign']; $religion = $_REQUEST['religion'];
                        $obl = $_REQUEST['obl'];
                        // if(isset($_POST['rayc'])){$rayc = $_REQUEST['rayc'];  } else {$rayc = "";}
                        if(isset($_POST['idc'])){$idc = $_REQUEST['idc'];  } else {$idc = "";}
                        $sort = $_REQUEST['sort'];
                        $skip = $_REQUEST['skip']; $skip50 = $skip*20;

                        if(mb_strlen($Im)>0){$Ims = "%$Im%"; $q_s[0] = ['Im', 'like', $Ims]; }
                        if(mb_strlen($Bat)>0){$Bats = "%$Im%"; $q_s[1] = ['Bat', 'like', $Bats]; }
                        if(mb_strlen($Priz)>0){$Prizs = "%$Priz%"; $q_s[2] = ['Priz', 'like', $Prizs]; }
                        if(mb_strlen($Who)>0){$Whos = "%$Who%"; $q_s[3] = ['Who', 'like', $Whos]; }
                        if(mb_strlen($email_seek)>0){ $q_s[4] = ['email', '=', $email_seek]; }
                        if(mb_strlen($insign)>0){$insigns = "%$insign%"; $q_s[5] = ['insign', 'like', $insigns]; }
                        if(mb_strlen($religion)>0){$religions = "%$religion%"; $q_s[6] = ['religion', 'like', $religions]; }
                        if($sex>0){ $q_s[7] = ['sex', '=', $sex]; }
                        if($partner>0){ $q_s[8] = ['partner', '=', $partner]; }
                        if($political>0){ $q_s[9] = ['political', '=', $political]; }
                        if($tabak>0){ $q_s[10] = ['tabak', '=', $tabak]; }
                        if($alkoh>0){ $q_s[11] = ['alkoh', '=', $alkoh]; }
                        if($aktivn){
                            if($aktivn==1){$q_s[12] = ['aktiv', '=', 1];}
                            if($aktivn==2){$Md_lv = date('Y-m-d', strtotime('-365 days')); $q_s[12] = ['l_visit', '>', $Md_lv];}
                            if($aktivn==3){$Md_lv = date('Y-m-d', strtotime('-30 days')); $q_s[12] = ['l_visit', '>', $Md_lv];}
                            if($aktivn==4){$Md_lv = date('Y-m-d', strtotime('-7 days')); $q_s[12] = ['l_visit', '>', $Md_lv];}
                            if($aktivn==5){$Md_lv = date('Y-m-d', strtotime('-1 days')); $q_s[12] = ['l_visit', '>', $Md_lv];}
                            if($aktivn==6){$Md_lv = date('Y-m-d-H-i', strtotime('-1 hours')); $q_s[12] = ['l_visit', '>', $Md_lv];}
                            if($aktivn==7){$Md_lv = date('Y-m-d-H-i', strtotime('-5 minutes')); $q_s[12] = ['l_visit', '>', $Md_lv];}
                        }
                        if($obl>0){ $q_s[13] = ['obl', '=', $obl]; }
                        if($idc>0){ $q_s[14] = ['idc', '=', $idc];}
                        if(isset($q_s)){}else {$q_s[0] = ['Num', '<>', 0];}

                         $Alls = DB::table('users')->
                            select('Num', 'domen', 'avatar', 'Priz', 'Im', 'Bat', 'sex', 'Who', 'Wherer', 'idc', 'aktiv', 'Md', 'l_visit', 'ab')->
                            where($q_s)->
                            orderBy($sort, 'desc')->
                            skip($skip50)->take(21)->
                            get();
                    }
                    else if($id>0 || $idc>0 || $obl>0){

                        if(isset($_POST['sort'])){$sort = $_REQUEST['sort'];}
                        if(isset($_POST['skip'])){$skip = $_REQUEST['skip'];} else{$skip = 0;}
                         if($id>0){ $q_s[1] = ['id', '=', $id]; $idc = ""; $obl = ""; $limit = 1; $skip50=0;}
                         if($idc>0){ $q_s[2] = ['idc', '=', $idc]; $id = "";  $obl = "";  $limit = 21;  $skip50 = $skip*20;}
                         if($obl>0){ $q_s[3] = ['obl', '=', $obl]; $id = ""; $idc = "";  $limit = 21;  $skip50 = $skip*20;}

                         $Alls = DB::table('users')->
                            select('Num', 'domen', 'avatar', 'Priz', 'Im', 'Bat', 'sex', 'Who', 'Wherer', 'idc', 'aktiv', 'Md', 'l_visit', 'ab') ->
                            where($q_s)->
                            orderBy($sort, 'desc')->
                            skip($skip50)->take($limit)->
                            get();
                         $Im = ""; $Bat = ""; $Priz = ""; $Who = ""; $sex = ""; $email_seek = ""; $partner = "";
                           $political = ""; $tabak = ""; $alkoh = "";
                          $insign = ""; $religion = "";  $ava = ""; $aktivn = "";

                    }
                    else{$sort="rate";
                         $Im = ""; $Bat = ""; $Priz = ""; $Who = ""; $sex = ""; $email_seek = ""; $partner = "";
                          $political = ""; $tabak = ""; $alkoh = "";
                          $insign = ""; $religion = ""; $obl = "";  $idc = "";
                         $ava = ""; $aktivn = ""; $id = "";
                         $q_s = ""; $skip=0;
                         $Alls = DB::table('users')->
                            select('Num', 'domen', 'avatar', 'Priz', 'Im', 'Bat', 'sex', 'Who', 'Wherer', 'idc', 'aktiv', 'Md', 'l_visit', 'ab')->
                            orderBy('rate', 'desc')->
                            limit(21)->
                            get();
                    }

if($obl>0 && $obl<26){
            $ob_user2 = __('messages.Region3');
          for ($i = 0; $i <= 25; $i++){
             $ni2 = "messages.oo$i"; $ii = "$i";
               if($obl == $ii){ $nii2 = __($ni2); if($obl == "1"){ $ob_user2 = "";}
               $obl_user2 = " $nii2 $ob_user2";
              if (App::isLocale('ru')){ $obl_user="<a href=/rse$i>$nii2 $ob_user2</a>";}
              else if (App::isLocale('en')){  $obl_user="<a href=/ese$i>$nii2 $ob_user2</a>";}
              else {$obl_user="<a href=/se$i>$nii2 $ob_user2</a>";}
               }
          }
$keywords = $keywords.=" $obl_user2";
$title = $title.=" $obl_user2";
} else {$obl_user = ""; $obl_user2 = "";}

if($idc>0){
            $Allc = DB::table('Allcities')->select('ab')->
                where('id', $idc)->limit(1)->get();
                $nc=0;
                foreach ($Allc as $All) { $ab=$All->ab; $nc++;}
                if($nc!=0){
                    $pagec = explode("#!", $ab);
                    $status=$pagec[5]; $vol_karta=$pagec[6];
                     $City=$pagec[1]; $City2=$pagec[2]; $City3=$pagec[11]; $domen=$pagec[12];

                    if ($status){
                        if ($status==1){$statusr=__('messages.statusr1');}
                        if ($status==2){$statusr=__('messages.statusr2');}
                        if ($status==3){$statusr=__('messages.statusr3');}
                        if ($status==4){$statusr=__('messages.statusr4');}
                        if ($status==5){$statusr=__('messages.statusr5');}
                    }
                    else{
                    if (!$vol_karta||$vol_karta<20000){$statusr=__('messages.statusr5');}
                    if ($vol_karta>=20000&&$vol_karta<50000){$statusr=__('messages.statusr6');}
                    if ($vol_karta>=50000){$statusr=__('messages.statusr1');}
                    }


                           if (App::isLocale('ru')){$c_user2="$statusr $City2"; $c_user="<a href=/$domen/ru>$statusr $City2</a>";}
                          else if (App::isLocale('en')){ $c_user2="$statusr $City3"; $c_user="<a href=/$domen/en>of $City3 $statusr</a>";}
                          else {$c_user2 = "$statusr $City"; $c_user="<a href=/$domen>$statusr $City</a>";}
                    $keywords = $keywords.=" $c_user2";
                    $title = $title.=" $c_user2";
                } else {$c_user = ""; $c_user2 = "";}
}                else {$c_user = ""; $c_user2 = "";}


@endphp

@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection


@section('content')

<div align = center>

<table><tr><td>
<div class="layermaxwide">
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

<div class="layer1">

@php


    $fr_avt = "";
    if (Auth::user()) {
        $my_id = Auth::user()->id;
        $Allfr = DB::table('Friends')->select('Num1', 'Num2')->
        where(function ($query1) use ($my_id) {
        $query1->where('Num1', $my_id)
            ->where('Argue', '=', 2);
        })->
        orWhere(function ($query2) use ($my_id) {
        $query2->where('Num2', $my_id)
            ->where('Argue', '=', 2);
        })->
        get();
        $fr_avt = "";
        $Numfr = "";
        foreach ($Allfr as $All) {
        $Num1 = $All->Num1;
        $Num2 = $All->Num2;
        if ($Num1 == $my_id) {
            $Numfr = $Num2;
        } else {
            $Numfr = $Num1;
        }
        $fr_avt .= " $Numfr";
        }
    }

    if($obl>0 || $idc>0){
        echo"<table><tr><td width=538 class=fcom0><div style=\"padding-left: 15px; padding-right: 15px; padding-top: 5px;  padding-bottom: 5px;\">";
        $people =__('messages.people');
            if($obl>0){echo"<h2>$people $obl_user</h2>";}
            if($idc>0){echo"<h2>$people $c_user </h2>";}
           echo"</div></td></tr></table>";
    }
      $t_is = date('Y-m-d H:i:s');
          $tot=strtotime($t_is);

                    $nu = 0;
    foreach ($Alls as $All) {
        $Num=$All->Num; $Imp=$All->Im; $Batp=$All->Bat; $Prizp=$All->Priz;
        $domenp=$All->domen; $Nump=$All->Num; $avatarp=$All->avatar;
         $sexp=$All->sex; $Whop=$All->Who;
         $Whererp=$All->Wherer; $idcp=$All->idc; $aktivp=$All->aktiv; $M6=$All->Md; $l_visitp=$All->l_visit;
          $abp=$All->ab;
          $nu++;

            $daym = substr($M6, 8, 2); $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);
            $fM6 = substr($M6, 0, 10);
            $Md_tod = date('Y-m-d');
            $Md_yes = date('Y-m-d', strtotime('-1 days'));

            if($fM6==$Md_tod){$M6_e=__('messages.today');}
            else if($fM6==$Md_yes){$M6_e=__('messages.yesterday');}
            else {
                for ($a=0; $a<13; $a++){$aa = "$a";
                    if($aa=="$monm"){ $mon_e = "messages.mmon$a"; $monm = __($mon_e); }
                }
                if(substr($daym, 0, 1)==0){$daym = substr($daym, 1, 1);}
                $M6_e="$daym $monm $yem";
            }



            if($idcp>0){

                $Allcu = DB::table('Allcities')->select('ab')->
                    where('id', $idcp)->limit(1)->get();
                    $cn=0;
                    $ab = '';
                    foreach ($Allcu as $All) { $ab=$All->ab; $cn++;}
                    if ($cn!=0){
                    $pagec = explode("#!", $ab);
                     $City=$pagec[1]; $City2=$pagec[2]; $City3=$pagec[11]; $oblu=$pagec[3]; $domen=$pagec[12];
                     $status=$pagec[5]; $vol_karta=$pagec[6];

                if ($status){
                    if ($status==1){$statusn=__('messages.statusm1');}
                    if ($status==2){$statusn=__('messages.statusm2');}
                    if ($status==3){$statusn=__('messages.statusm3');}
                    if ($status==4){$statusn=__('messages.statusm4');}
                    if ($status==5){$statusn=__('messages.statusm5');}
                }
                else{
                if (!$vol_karta||$vol_karta<20000){$statusn=__('messages.statusm4');}
                if ($vol_karta>=20000&&$vol_karta<50000){$statusn=__('messages.statusm6');}
                if ($vol_karta>=50000){$statusn=__('messages.statusm1');}
                }

                if($Whererp == "проживання"){$Whererp = __('messages.Pplace1'); }
                if($Whererp == "навчання"){$Whererp = __('messages.Pplace2'); }
                if($Whererp == "роботи"){$Whererp = __('messages.Pplace3'); }
                if($Whererp == "відпочинку"){$Whererp = __('messages.Pplace4'); }
                if($Whererp == "народження"){if($sexp==2){$Whererp = __('messages.Pplace6');} else{$Whererp = __('messages.Pplace5');} }

                if (App::isLocale('ru')){$Ct="<a href =/$domen/ru><b>$statusn $City2</b></a>";}
                else if (App::isLocale('en')){$Ct="<a href =/$domen/en><b>$statusn $City3</b></a>";}
                else{$Ct="<a href =/$domen><b>$statusn $City</b></a>";}

                $ob_user2 = __('messages.Region3');
                  for ($i = 0; $i <= 25; $i++){
                     $ni = "messages.oo$i"; $ni2 = "messages.oo$i"; $ii = "$i";
                       if($oblu == $ii){$nii = __($ni); $nii2 = __($ni2); if($oblu == "1"){ $ob_user2 = "";}
                       $obl_user = "<a href =/se$i><b>$nii $ob_user2</b></a>";
                       }
                  }
                $in = __('messages.in');
                    }
                    else{
                        $Whererp=""; $in=""; $Ct=""; $obl_user="";
                    }
            }
            else{
                $Whererp=""; $in=""; $Ct=""; $obl_user="";
            }

                        $fromt=strtotime($l_visitp);
                        $min5s=$tot-$fromt;
                     if ($min5s<200){$l_visit_e=__('messages.online');
                          $l_visit_e="<div style=\"color:green;\"><b>$l_visit_e</b></div> ";
                     } else {$l_visit_e="";}


                     if (App::isLocale('ru')){if($domenp){$plink = "$domenp/ru";} else {$plink = "ri$Num";}}
                    else if (App::isLocale('en')){if($domenp){$plink = "$domenp/en";} else {$plink = "ei$Num";}}
                    else {if($domenp){$plink = "$domenp";} else {$plink = "i$Num";}}

                            if ($avatarp>0){$path0 = "/storage/avatar/$avatarp.jpg"; }
                            else {$path0="/7.jpg";}

                            if($abp){ $pagep = explode("#!", $abp);
                            $nnrf=$pagep[1]; $nnrm=$pagep[2]; $nnrv=$pagep[3]; $nnra=$pagep[4];}
                            else {$nnrf=""; $nnrm=""; $nnrv=""; $nnra="";}

                  if ($nnrf>0){$statusfp="$nnrf <img src=/images/ifoto.png>";} else{$statusfp="";}
                  if ($nnrm>0){$statusmp="$nnrm <img src=/images/iforum.png>";} else{$statusmp="";}
                  if ($nnrv>0){$statusvp="$nnrv <img src=/images/ivideo.png>";} else{$statusvp="";}
                //  if ($nnra>0){$statuspp="$nnra <img src=/images/iaudio.png>";} else{$statuspp="";}
            if($nu<21){
                echo"<table><tr><td align=center class=fcom width=538 onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                <div style=\"padding: 7px;\">";
                echo"<table><tr valign=top><td width=100><div class=\"scale\">
                <a href =/$plink><img style = \"min-width: 100px;\" title=\"$Imp $Prizp\" src=\"$path0\"></a></div></td>
                <td align=left width=423>";

                echo"<div class=\"layer1\"><div style=\"width: 170px; overflow: hidden; padding: 3px;\">
                <h4><a href =/$plink><b>$Imp $Batp $Prizp</b></a><br />$l_visit_e $Whop</h4>
                $statusfp $statusmp $statusvp";

                if (Auth::user()) {
                    $add_fr = __('messages.add_fr');
                    $del_fr = __('messages.del_fr');
                    $Delete = __('messages.Delete');
                    $No = __('messages.cancel');
                    $confirm = __('messages.confirm');
                    $add_frl = "<div style=\"margin: 10px 0px 0px 0px;\" id=\"add_fr$Num\"><a onclick=add_fr('add_fr$Num','$Num')><b> $add_fr</b></a><br /></div>";
                    $del_frl = "<div style=\"margin: 10px 0px 0px 0px;\" id=\"del_fr0$Num\"><a onclick=del_fr0('del_fr0$Num','del_fr$Num')> $del_fr</a></div>
                    <div id=\"del_fr$Num\" style=\"display: none; margin: 10px 0px 0px 0px;\"> $confirm <b><a href=### onclick=del_fr('del_fr$Num','$Num')>$Delete</a></b>
                    <br /><br /><a onclick=del_fr1('del_fr0$Num','del_fr$Num')>$No</a><br /><br /> </div>";

                    $Num2 = "$Num";
                    $isfriend = mb_strstr("$fr_avt", "$Num");
                    if($Num!=$my_id && $isfriend == ""){
                        echo"<b>$add_frl</b>";
                    }
                    if($Num!=$my_id && $isfriend != ""){
                        echo"<b>$del_frl</b>";
                    }
                }

                echo"</div></div>";

                $regd = __('messages.regd');
                echo"<div class=\"layer1\"><div style=\"width: 170px; overflow: hidden; padding: 3px;\">
                <h4>$Whererp $in<br /> $Ct<br /> $obl_user <br />$regd<br /> $M6_e </h4>
                </div></div>";

                echo" <br /><br /></div></td></tr></table></div></td></tr></table>";
             }
        }
@endphp

    @if($nu==0)
        @php
        $no_p_results =__('messages.no_p_results'); $no_p_results2 =__('messages.no_p_results2');
        echo"<br /><br /><h3>$no_p_results <br />$no_p_results2</h3><br /><br /><br />";
        $Num=""; $Imp="";  $Batp=""; $Prizp=""; $domenp=""; $Nump=""; $avatarp="";
         $sexp=""; $Whop=""; $Whererp=""; $idcp=""; $aktivp=""; $M6=""; $l_visitp=""; $abp="";
        @endphp

    @elseif($nu>1)
        <table><tr><td align=center width=538>
            <div class="layer1" style="text-align:center;">


            </div>
            <div class="layer1" style="text-align:center;">
                <form name=psee2 action="{{ route('infp_seek') }}" method="post">
                    @csrf
                    <input type="hidden" name="Im" id="Im"  value="{{$Im}}">
                    <input type="hidden" name="Bat" id="Bat" value="{{$Bat}}">
                    <input type="hidden" name="Priz" id="Priz" value="{{$Priz}}">
                    <input type="hidden" name="Who" id="Who" value="{{$Who}}"><br />
                    <input type="hidden" name="email_seek" id="email_seek" value="{{$email_seek}}">
                    <input type="hidden" name="sex" id="sex" value="{{$sex}}">
                    <input type="hidden" name="partner" id="partner" value="{{$partner}}">
                    <input type="hidden" name="political" id="political" value="{{$political}}">
                    <input type="hidden" name="tabak" id="tabak" value="{{$tabak}}">
                    <input type="hidden" name="alkoh" id="alkoh" value="{{$alkoh}}">
                    <input type="hidden" name="insign" id="insign" value="{{$insign}}">
                    <input type="hidden" name="religion" id="religion" value="{{$religion}}">
                    <input type="hidden" name="aktivn" id="aktivn" value="{{$aktivn}}">
                    <input type="hidden" name="obl" value={{$obl}}>
                    @php if($idc==""){$idc=0; $idc=$idc+1; $idc=$idc-1;} @endphp
                    <input type="hidden" name="idc" value={{$idc}}>
                    <input type="hidden" name="ava" id="ava" value="{{$ava}}">
                    <input type="hidden" name="skip" id="skip"  value="">
                    @php $skipb=$skip-1;  $skipn=$skip+1;          @endphp
                    <input type="hidden" name="skipb" id="skip"  value={{$skipb}}>
                    <input type="hidden" name="skipn" id="skip"  value={{$skipn}}>
                    <input type="hidden" name="sort" id="sort"  value={{$sort}}>
                @php $sort2 = __('messages.sort2'); $sort3 = __('messages.sort3');

                if($sort=="Md"){
                echo"<table><tr><td height=25 valign=center class=fcombold align=center width=240><b>$sort3</b></td></tr></table>
                <table><tr><td class=fcomblue width=240><ul class=intop><li><a onclick=form_send2('rate')>$sort2</a></li></ul></td></tr></table>";
                }
                if($sort=="rate"){
                echo"<table><tr><td class=fcomblue width=240> <ul class=intop><li><a onclick=form_send2('Md')>$sort3</a></li></ul></td></tr></table>
                <table><tr><td height=25 valign=center class=fcombold align=center width=240><b>$sort2</b></td></tr></table>
                ";
                }
                if($skip!=0){  $back = __('messages.back');
                echo"<table><tr><td class=fcomblue width=240> <ul class=intop><li><a onclick=form_send('$skipb')>$back</a></li></ul></td></tr></table>";
                }
                if($nu==21){  $next = __('messages.next');
                echo"<table><tr><td class=fcomblue width=240> <ul class=intop><li><a onclick=form_send('$skipn')>$next</a></li></ul></td></tr></table>";
                }
                 @endphp
                </form>
            </div>
        </td></tr></table>

    @endif

</div>

                <div class="layer1">
                    <table>
                        <tr><td align=right valign=top width=480 class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'">
                    <div style="padding-right: 5px; padding-left: 5px;">
                        <div align="center"><h3>{{ __('messages.mydata') }}</h3></div>
                        <form name=psee action="{{ route('infp_seek') }}" method="post">
                            @csrf
                        {{ __('messages.Im') }}: <input type="text" name="Im" id="Im" SIZE=20 maxlength = 25 value="{{$Im}}"><br />
                        {{ __('messages.Bat') }}: <input type="text" name="Bat" id="Bat" SIZE=20 maxlength = 25 value="{{$Bat}}"><br />
                        {{ __('messages.Priz') }}: <input type="text" name="Priz" id="Priz" SIZE=20 maxlength = 25 value="{{$Priz}}"><br />
                        {{ __('messages.Who') }}: <input type="text" name="Who" id="Who" SIZE=20 maxlength = 25 value="{{$Who}}"><br />
                        E-Mail: <input type="text" name="email_seek" id="email_seek" SIZE=20 maxlength = 25 value="{{$email_seek}}">
                        <br />{{ __('messages.sex') }}:
                        <select id="sex" name="sex">
                            <option value=0 @php if($sex==0){echo"selected";} @endphp>{{ __('messages.chopt') }}</option>
                            <option value=1 @php if($sex==1){echo"selected";} @endphp>{{ __('messages.sexn2') }}</option>
                            <option value=2 @php if($sex==2){echo"selected";} @endphp>{{ __('messages.sexn3') }}</option>
                        </select>
                        <br />{{ __('messages.fam_st') }}:
                        <select id="partner" name="partner">
                            <option value=0 @php if($partner==0){echo"selected";} @endphp>{{ __('messages.chopt') }}</option>
                            <option value=1 @php if($partner==1){echo"selected";} @endphp>{{ __('messages.partner1') }}</option>
                            <option value=2 @php if($partner==2){echo"selected";} @endphp>{{ __('messages.partner2') }}</option>
                            <option value=3 @php if($partner==3){echo"selected";} @endphp>{{ __('messages.partner3') }}</option>
                            <option value=4 @php if($partner==4){echo"selected";} @endphp>{{ __('messages.partner4') }}</option>
                            <option value=5 @php if($partner==5){echo"selected";} @endphp>{{ __('messages.partner5') }}</option>
                            <option value=6 @php if($partner==6){echo"selected";} @endphp>{{ __('messages.partner6') }}</option>
                        </select>


                        <br />{{ __('messages.polit') }}: <select id="political" name="political">
                            @php for ($a=0; $a<10; $a++){$aa = "$a";  echo"<option value=$a";
                            if($political=="$aa"){echo" selected";}
                             echo">"; $pol_e = "messages.polit$a"; echo __($pol_e);
                            echo "</option>";} @endphp
                        </select>

                        <br /> {{ __('messages.tab1') }}:
                        <select id="tabak" name="tabak">
                            @php for ($a=0; $a<6; $a++){$aa = "$a";  echo"<option value=$a";
                            if($tabak=="$aa"){echo" selected";}
                             echo">"; $tab_e = "messages.tab_alk$a"; echo __($tab_e);
                            echo "</option>";} @endphp
                        </select>

                        <br />{{ __('messages.alk1') }}:
                        <select id="alkoh" name="alkoh">
                            @php for ($a=0; $a<6; $a++){$aa = "$a";  echo"<option value=$a";
                            if($alkoh=="$aa"){echo" selected";}
                             echo">"; $tab_e = "messages.tab_alk$a"; echo __($tab_e);
                            echo "</option>";} @endphp
                        </select>

                        <br />{{ __('messages.insign') }}:
                        <input type="text" id="insign" name="insign" SIZE=15 maxlength = 70 value="{{$insign}}">

                        <br />{{ __('messages.religion') }}:
                        <input type="text" id="religion" name="religion" SIZE=15 maxlength = 70 value="{{$religion}}">

                        <br />{{ __('messages.aktivn') }}:
                        <select id="aktivn" name="aktivn">
                            @php for ($a=0; $a<8; $a++){$aa = "$a";  echo"<option value=$a";
                        if($aktivn=="$aa"){echo" selected";}
                         echo">"; $aktivn_e = "messages.aktivn$a"; echo __($aktivn_e);
                        echo "</option>";} @endphp
                        </select>

                        <br />{{ __('messages.Region') }}:
                                <select id="obl" name="obl">
                                    @php for ($i = 0; $i <= 25; $i++){$ii = "$i";
                                                     $ni = "messages.o$i"; $no = "messages.chopt";
                                                    echo"<option value=$i"; if($obl=="$ii"){echo" selected";} echo">";
                                                       if($i==0){echo __($no);}
                                                        else{echo __($ni);}
                                                    echo"</option>";
                                                    } @endphp
                                </select>

                        <table><tr><td><div id=hrayc style="display: none;">
                            <label for="rayc" >{{ __('messages.regionalcenter') }}: </label></div></td><td>
                                <div id=hrayc2 style="display: none;">
                                    <select id="rayc"  name="rayc"> </select>
                                </div></td></tr></table>

                        <table><tr><td><div id=hidc style="display: none;">
                            {{ __('messages.Cityvil') }}: </div></td><td>
                                <div id=hidc2 style="display: none;">
                                    <select id="idc" name="idc"> </select>
                                </div></td></tr></table>
                            {{ __('messages.sort') }}:
                            <select id="sort" name="sort">
                                <option value="rate" @php if($sort=="rate"){echo"selected";} @endphp>{{ __('messages.sort1') }}</option>
                                <option value="Md" @php if($sort=="Md"){echo"selected";} @endphp>{{ __('messages.sort3') }}</option>
                            </select>
                            <input type="hidden" name="skip" id="skip"  value="0">
                                <table>
                                    <tr><td>{{ __('messages.with_photo') }}:<input type=checkbox name=ava id=ava  @php if($ava=="Yes"){echo"checked";} @endphp > </td>
                                        <td class="fcomblue" width=130>
                                            <ul class="intop"><li><a href="javascript:document.forms.psee.submit();">{{ __('messages.p_title') }}</a></li></ul>
                                        </td></tr>
                                </table>
                        </form>
                        <br />
                        </div>
                   </td></tr></table>
                </div>

            </div>
        </td></tr></table>
        </div>



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








    <br /><br />
@endsection
