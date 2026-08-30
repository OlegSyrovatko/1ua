@extends('layouts.app')

@php
if(isset($_POST['id'])){$id = $_REQUEST['id'];}
else if(isset($id)){}else {$id = 0;}
if(isset($_POST['purp'])){$purp = $_REQUEST['purp'];}
else if(isset($purp)){}else {$purp = "friends";}
if(isset($_POST['sort'])){$sort = $_REQUEST['sort'];}
else if(isset($sort)){}else {$sort = "visit";}
$time_sec=time();

if(Auth::user()) {
    $Numm =  Auth::user()->id;
} else{$Numm = 0;}

$Num = $id;
$description = "";
$keywords = "";
$title = "";
$friends = __('messages.friends');
$Friends = __('messages.Friends');
$infriends = __('messages.infriends');
$ourfriends = __('messages.ourfriends');
$Infriends = __('messages.Infriends');
$Ourfriends = __('messages.Ourfriends');
$pref_page = __('messages.pref_page');
$friends_key = __('messages.friends_key');
$recalculate = __('messages.recalculate');
$hid_page = __('messages.hid_page');
$add_fr = __('messages.add_fr');
$del_fr = __('messages.del_fr');
$refuse = __('messages.refuse');
$Delete = __('messages.Delete');
$No = __('messages.cancel');
$confirm = __('messages.confirm');

$friends0 = "friends";
$ourfriends0 = "ourfriends";
$infriends0 = "infriends";
$friends_link = "$pref_page$friends0";
$ourfriends_link = "$pref_page$ourfriends0";
$infriends_link = "$pref_page$infriends0";
$Privatpass="stop";
$unknown = "off";
$index_go = "index,follow";
$purp_fr="";
$purp_in="";
$purp_2f="";
$recall = "";
$nr=0;

$filename0 = "storage/last_visit/$id.txt";
if (file_exists($filename0) && filesize($filename0) > 0) {
    $whattoread0 = @fopen($filename0, "r");
    $memory_contents0 = fread($whattoread0, filesize($filename0));
    fclose($whattoread0);
    $page = explode("#!:*&", $memory_contents0);
    $Imp=$page[1]; $Prizp=$page[2]; $Num_ap=$page[3];


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
        $isfriend = mb_strstr("$fr_avt", "$my_id2");
    } else {$isfriend = ""; $my_id = "999999999999999";}

    $Alls = DB::table('Private')->select('Page', 'ipban', 'ban')->
        where('Num', $id)->
      limit(1)->
        get();
            $pr=0;
        foreach ($Alls as $All) { $Sh_Page=$All->Page; $ipban=$All->ipban; $ban=$All->ban;
         $pr++; }
        if($pr==0) {$Sh_Page=1; $ipban=""; $ban="";}


    if($Sh_Page==1 || !$Sh_Page){$Privatpass="go";}
     else{if($Sh_Page==2 && Auth::user()){$Privatpass="go";}
      else{
        if($Sh_Page==3 && ($id==$my_id || $isfriend != "")){ $Privatpass="go"; }
        else if($Sh_Page==4&&$Num==$my_id){$Privatpass="go";}
      }
     }

     if (Auth::user()){
        if ($ban){
          if(mb_strstr((string)$ban, (string)$my_id)!=""){$Privatpass="stop";}
        }
     }
     else if($purp=="ourfriends"){
         $Privatpass="stop";
     }

     if($Privatpass == "stop"){
        $title="$Imp $Prizp $hid_page";
        $description = $title;
        $keywords="$Imp $Prizp: $friends_key";
        $index_go = "noindex,nofollow";
     }

    else{
        if($purp=="friends"){
            $purp_fr="<table><tr><td height=25 valign=center class=fcombold align=center width=170><b>$friends</b></td></tr></table>";
            if($Numm>0&&$Numm==$id){
                $purp_in="<table><tr><td class=fcomblue width=170>
                <ul class=intop><li><a href = \"/$infriends_link/$id/date\">$infriends</a></li></ul>
                </td></tr></table>";
            }
            if($Numm>0&&$Numm!=$id){
                $purp_2f="<table><tr><td class=fcomblue width=170>
                <ul class=intop><li><a href = \"/$ourfriends_link/$id/visit\">$ourfriends</a></li></ul>
                </td></tr></table>";
            }
            $title="$Friends - $Imp $Prizp";
            $purp_0=$Friends;
            $description = $title;
            $keywords="$Imp $Prizp: $friends, $friends_key";
        }
        if($purp=="infriends"){
            $purp_fr="<table><tr><td class=fcomblue width=170>
            <ul class=intop><li><a href = \"/$friends_link/$id/date\">$friends</a></li></ul>
            </td></tr></table>";
            if($Numm>0&&$Numm==$id){
                $recall=" <a onclick=redo()>($recalculate)</a>";
                $purp_in="<table><tr><td height=25 valign=center class=fcombold align=center width=170><b>$infriends</b></td></tr></table>";
            }
            else{
                $Privatpass="stop";
            }
            if($Numm>0&&$Numm!=$id){
                $purp_2f="<table><tr><td class=fcomblue width=170>
                <ul class=intop><li><a href = \"/$ourfriends_link/$id/visit\">$ourfriends</a></li></ul>
                </td></tr></table>";
            }
            $title="$Infriends - $Imp $Prizp ";
            $purp_0=$Infriends;
            $description = $title;
            $keywords="$Imp $Prizp: $infriends, $friends_key";
        }
        if($purp=="ourfriends"){
            $purp_fr="<table><tr><td class=fcomblue width=170>
            <ul class=intop><li><a href = \"/$friends_link/$id/date\">$friends</a></li></ul>
            </td></tr></table>";

            if($Numm>0&&$Numm!=$id){
                $purp_2f="<table><tr><td height=25 valign=center class=fcombold align=center width=170><b>$ourfriends</b></td></tr></table>";
                $title="$Ourfriends - $Imp $Prizp ";
                $description = $title;
                $purp_0=$Ourfriends;
                $keywords="$Imp $Prizp: $ourfriends, $friends_key";
            }
        }
    }
}
else{
    $title = __('messages.unknown_page');
    $description = $title;
    $keywords = $title;
    $unknown = "on";
}





@endphp


@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('title_block'){{$title}}@endsection
@section('robots'){{$index_go}}@endsection



@section('content')

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

    <script>
    function frie(npass1,dp) {

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });

        var formData = {
            npass1: npass1, purp: "{{$purp}}", sort: "{{$sort}}", id: {{$id}}
        };
        $.ajax({
            type: 'POST',
            url: '/frie',
            data: formData,
            cache: false,
            success:function(data){
                document.getElementById("friends").innerHTML+=data;
                document.getElementById(dp).style.display = 'none';
            }
        });

    }


</script>

<div align = center>
@php
if($unknown == "on"){
    echo" <br /><br /><br /><br /><table><tr><td><h4>$title</h4></td></tr></table>";

}
else if($Privatpass=="stop"){
    echo" <br /><br /><br /><br /><table><tr><td><h4>$hid_page</h4></td></tr></table>";
    $link = "spid$id";
    echo "<html><head><meta http-equiv='refresh' content='3; url=/$link'></head></html>";
}
else{
    $Allf = DB::table('Friends')->select('Num1', 'Im1', 'Priz1', 'avatar1', 'Md', 'Num2', 'Im2', 'Priz2', 'avatar2', 'Argue')->
    where('Num1', $id)->
    orWhere('Num2', $id)->
    get();
    $nrfr = $Allf->count();


    if($Numm==0){$isfriend="";}
    $fr_avt=" "; $fr_avt2=" ";
    $a_fr=0; $a_rin=0; $a_onl=0;

    if($Numm>0&&$id!=$Numm){
		$group_our = array('Im','Priz','friend','avatar','dd','lv'); $a_our=0;

        $Allf2 = DB::table('Friends')->select('Num1','Num2')->
        where(function($query1) use ($Numm) {
            $query1->where('Num1', $Numm)
                  ->where('Argue', '=', 2);
        })->
        orWhere(function($query2) use ($Numm) {
            $query2->where('Num2', $Numm)
                  ->where('Argue', '=', 2);
        })->
        get();
        foreach ($Allf2 as $All) {
            $Num1=$All->Num1; $Num2=$All->Num2;
            if($Numm==$Num2){$fr_avt2.=" $Num1";} else{$fr_avt2.=" $Num2";}
        }
	}

    $group_fr = array('Im','Priz','friend','avatar','dd','lv');
    $group_in = array('Im','Priz','friend','avatar','dd','lv');
    if($nrfr!=0){

        foreach ($Allf as $All) {
            $Num1=$All->Num1; $Im1=$All->Im1; $Priz1=$All->Priz1; $avatar1=$All->avatar1; $dd=$All->Md;
            $Num2=$All->Num2; $Im2=$All->Im2; $Priz2=$All->Priz2; $avatar2=$All->avatar2; $Argue=$All->Argue;


            if($Num2==$my_id&&$Argue==1){
                $group_in['Im'][$a_rin]=$Im1; $group_in['Priz'][$a_rin]=$Priz1; $group_in['friend'][$a_rin]=$Num1; $group_in['avatar'][$a_rin]=$avatar1; $group_in['dd'][$a_rin]=$dd;
                $filename = "storage/last_visit/$Num1.txt";
                $time_file=filemtime($filename);
                $t=$time_sec-$time_file;
                $group_in['lv'][$a_rin]=$t;
            $a_rin++;
            }

            if($Argue==2){

                if($Num1==$Num){$Numfr=$Num2; $Imfr=$Im2; $Prizfr=$Priz2; $avatarfr=$avatar2;}
                else{$Numfr=$Num1; $Imfr=$Im1; $Prizfr=$Priz1; $avatarfr=$avatar1;} $fr_avt.= " $Numfr";

                if($Numm&&$Num!=$Numm){$isfriend = mb_strstr($fr_avt, $Numm);}

                $group_fr['Im'][$a_fr]=$Imfr; $group_fr['Priz'][$a_fr]=$Prizfr; $group_fr['friend'][$a_fr]=$Numfr;
                $group_fr['avatar'][$a_fr]=$avatarfr; $group_fr['dd'][$a_fr]=$dd;
                $filename = "storage/last_visit/$Numfr.txt";
                $time_file=filemtime($filename);
                $t=$time_sec-$time_file;
                $group_fr['lv'][$a_fr]=$t;


                $isfriend2 = mb_strstr($fr_avt2, $Numfr);
                if($isfriend2!=""&&($Numm&&$Num!=$Numm)){
                     $group_our['Im'][$a_our]=$Imfr; $group_our['Priz'][$a_our]=$Prizfr; $group_our['friend'][$a_our]=$Numfr;
                     $group_our['avatar'][$a_our]=$avatarfr; $group_our['dd'][$a_our]=$dd; $group_our['lv'][$a_our]=$t;
                $a_our++;
                }

                $a_fr++;
            }
        }
    }


    if($purp=="friends"){
    $group=$group_fr; $nr=$a_fr;
    }

    if($purp=="infriends"){
    $group=$group_in; $nr=$a_rin;
    }

    if($purp=="ourfriends" && $Numm>0){
    $group=$group_our; $nr=$a_our;
    }


    // if($nr!=0){

        $per_name = __('messages.per_name');
        $per_date = __('messages.per_date');
        $per_visit = __('messages.per_visit');
        $sort_e = __('messages.sort');
        $View = __('messages.View');

    if($nr!=0){
        $friends_link = "$pref_page$purp";

        $ord_i = '';
        $ord_d = '';
        $ord_v = '';

        if (! in_array($sort, ['date', 'visit', 'name'], true)) {
            $sort = 'visit';
        }

        if ($sort=="date"){
            $ord_i="<table><tr><td class=fcomblue width=170>
            <ul class=intop><li><a href = \"/$friends_link/$id/name\">$per_name</a></li></ul>
            </td></tr></table>";
            $ord_d="<table><tr><td height=25 valign=center class=fcombold align=center width=170><b>$per_date</b></td></tr></table>";
            $ord_v="<table><tr><td class=fcomblue width=170>
            <ul class=intop><li><a href = \"/$friends_link/$id/visit\">$per_visit</a></li></ul>
            </td></tr></table>";
            array_multisort($group['dd'], SORT_DESC, $group['lv'], $group['Im'], $group['Priz'], $group['friend'], $group['avatar']);
        }

        if ($sort=="visit"){
            $ord_i="<table><tr><td class=fcomblue width=170>
            <ul class=intop><li><a href = \"/$friends_link/$id/name\">$per_name</a></li></ul>
            </td></tr></table>";
            $ord_d="<table><tr><td class=fcomblue width=170>
            <ul class=intop><li><a href = \"/$friends_link/$id/date\">$per_date</a></li></ul>
            </td></tr></table>";
            $ord_v="<table><tr><td height=25 valign=center class=fcombold align=center width=170><b>$per_visit</b></td></tr></table>";
            array_multisort($group['lv'], SORT_ASC, $group['dd'], $group['Im'], $group['Priz'], $group['friend'], $group['avatar']);
        }

        if ($sort=="name"){
            $ord_i="<table><tr><td height=25 valign=center  class=fcombold align=center width=170><b>$per_name</b></td></tr></table>";
            $ord_d="<table><tr><td class=fcomblue width=170>
            <ul class=intop><li><a href = \"/$friends_link/$id/date\">$per_date</a></li></ul>
            </td></tr></table>";
            $ord_v="<table><tr><td class=fcomblue width=170>
            <ul class=intop><li><a href = \"/$friends_link/$id/visit\">$per_visit</a></li></ul>
            </td></tr></table>";
            array_multisort($group['Im'], SORT_ASC, $group['Priz'], SORT_ASC, $group['lv'], $group['friend'], $group['dd'], $group['avatar']);
        }
    }
    echo"
    <div class=\"layermaxwide\">
        <div class=\"frienduser3\">
            <table><tr><td class=\"fcombold\" align=center width=345><br />
                <table><tr><td align=center width=225>";
                    $my_l = "i";
                    $my_link = "$pref_page$my_l$id";

                    if($Num_ap>10){echo"<b><h2><a href=/$my_link>$Imp $Prizp</a></h2></b><div class=\"scale\" style=\"height: 200px; overflow: hidden\"><a href=/$my_link><img SRC=\"/storage/avatar/b$Num_ap.jpg\" align=center border=0></a></div><br />";}
                        else{echo"<b><h2><a href=/$my_link>$Imp $Prizp</a></h2></b><div class=\"scale\" style=\"height: 180px; overflow: hidden\"><a href=/$my_link><img SRC=\"/storage/avatar/b7.jpg\" align=center border=0></a></div><br />";}

                    if($Num==$Numm||($Numm==0)){$purp_2f="";}
                    echo"<b><br />$View:</b>
                    $purp_fr
                    $purp_in
                    $purp_2f <br />";
                    if($nr!=0){
                        if($nrfr>0){
                        echo"<b>$sort_e:</b>
                        $ord_i
                        $ord_d
                        $ord_v <br />";}
                    }
             echo"</td></tr></table></td></tr></table>
            <br /><br />
        </div>";


        echo"
        <div class=\"frienduser2\">
            <table height=510><tr><td class=\"fcombold\" align=center width=590><br />
                <table><tr><td align=center width=528>";

                    echo"<h1>$purp_0: $nr $recall<br /></h1>";

                    echo"<div id=friends>";

                    $npass1=0;
                    $npass2=$npass1+101;
                    $nrow=1;
                    if($nr<$npass2){$npass2=$nr;}
                    $fdiv = "shut";
                    $arow=1;
                    for($npass1; $npass1<$npass2; $npass1++){
                        if($arow<=100){
                             $Img=$group['Im'][$npass1]; $Prizg=$group['Priz'][$npass1];
                             $Num_a=$group['friend'][$npass1]; $M1=$Num_a; $l_visit=$group['lv'][$npass1]; $Num_ag=$group['avatar'][$npass1];

                            if($nrow==1 || $nrow==3){
                                echo"<div class=\"layer1\"><table style=\"height: 200px; overflow: hidden\"><tr valign=top>";
                                $fdiv = "open";
                            }
                            echo"<td align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">";

                                if($Num_ag<10){$Num_ag=7;}

                                $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}
                                    $f_l = "i";
                                    $f_link = "$pref_page$my_l$M1";
                                    $online = __('messages.online');
                                if ($l_visit<=500){}else{echo"<br />";}
                                echo"<div style=\"width: 128px; overflow: hidden\"><b><a href=/$f_link>";
                                if(mb_strlen($Img)>15){$Img = mb_substr($Img, 0, 15); $Img.="...";}
                                if(mb_strlen($Prizg)>15){$Prizg = mb_substr($Prizg, 0, 15); $Prizg.="...";}
                                echo"$Img<br />$Prizg</a></b><br />";
                                if ($l_visit<=500){echo"<b><font color=green>$online</font></b><br />";}
                                echo"<div class=\"scale\" style=\"height: 100px; overflow: hidden\"><a href=/$f_link><img SRC=/storage/avatar/$Num_ag.jpg border=0></a></div>";

                                if($Numm>0){
                                    $add_frl = "<div id=\"add_fr$M1\"><a onclick=add_fr('add_fr$M1','$M1')><b> $add_fr</b></a><br /></div>";
                                    $del_frl = "<div id=\"del_fr0$M1\"><a onclick=del_fr0('del_fr0$M1','del_fr$M1')> $del_fr</a></div>
                                                    <div id=\"del_fr$M1\" style=\"display: none;\"> $confirm <b><a href=### onclick=del_fr('del_fr$M1','$M1')>$Delete</a></b>
                                                    <br /><br /><a onclick=del_fr1('del_fr0$M1','del_fr$M1')>$No</a><br /><br /> </div>";
                                    $refuse_frl = "<div id=\"refuse_fr$M1\"><a onclick=refuse_fr('refuse_fr$M1','$M1')> <b>$refuse</b> </a><br /></div>";

                                    $my_id = Auth::user()->id;
                                    $my_id2 = "$my_id";
                                    $isfriend = strstr("$fr_avt", "$my_id2");

                                    if($purp=="friends"){
                                        if ($Numm==$Num){
                                        echo"$del_frl";
                                        }
                                        else{
                                            $isfriend2 = mb_strstr($fr_avt2, $M1);
                                            if($isfriend2!=""&&($Numm&&$M1!=$Numm)){echo"$del_frl";}
                                            else{if($Numm!=$M1){echo"$add_frl";}}
                                        }
                                    }

                                    if($purp=="infriends"){if($Numm==$Num){echo"$add_frl $refuse_frl";}} else{}
                                    if($purp=="ourfriends"){echo"$del_frl";}

                                }

                            echo"</div>";
                                $nrow++;
                                echo"</td>";
                            if($nrow==3 || $nrow==5){ echo"</td></tr></table></div>"; $fdiv = "shut"; }
                            if($nrow==5){$nrow=1;}

                        }
                        $arow++;
                    }
                    if($fdiv == "open"){
                        echo"<td width=50%> </td></tr></table></div>";
                    }

                    if($arow==102){
                        $nnext = __('messages.nnext');
                        echo"<div id=dp$npass1><br />
                        <table>
                        <tr><td class=\"fcomblue\" width=530>
                        <ul class=\"intop\"><li><a onClick=frie('$npass1','dp$npass1')>$nnext</a></a></li></ul>
                        </td></tr>
                        </table>
                        <br /><br /></div>";
                    }

                echo"</div>
                <div style=\"height: 20px;\"></div></td></tr></table>
            </td></tr></table>
        </div>
   </div>";

}


@endphp
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


@endsection
