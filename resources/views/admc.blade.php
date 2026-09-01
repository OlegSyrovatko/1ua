@extends('layouts.app')

@php
$title = __('messages.adm_panel');

$index_go="noindex,follow";

if(isset($_POST['id'])){$id = $_REQUEST['id'];}
else if(isset($id)){}else {$id = 0;}
if($id>0){

    if (App::isLocale('ua')){$cq = "City";}
    if (App::isLocale('ru')){$cq = "City2";}
    if (App::isLocale('en')){$cq = "City3";}

    $Alls = DB::table('Allcities')->select('id', 'obl', $cq)->
    where('id', $id)->
    limit(1)->
    get();

    $nrc = $Alls->count();
    foreach ($Alls as $All) {
        $id = $All->id;
        $City = $All->$cq;
        $obl = $All->obl;
    }
    if($nrc>0){$title .= " $City";}
}
else{$title = __('messages.unknown_page');}
@endphp

@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection


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


        function ipban() {

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
            });
            var ipban = document.getElementById('ipban').value;
            var formData = {
                ipban: ipban,
                id: {{$id}},
            };
            $.ajax({
                type: 'POST',
                url: '/ipban',
                data: formData,
                cache: false,
                success:function(data){
                    document.getElementById('ipban').value=data;
                    document.getElementById("ipban").style.color="green";
                    setTimeout(() => {document.getElementById("ipban").style.color="black";}, 1000);

                }
            });
        }

        function user_ban() {

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
            });
            var user_ban = document.getElementById('user_ban').value;
            var formData = {
                user_ban: user_ban,
                id: {{$id}},
            };
            $.ajax({
                type: 'POST',
                url: '/user_ban',
                data: formData,
                cache: false,
                success:function(data){
                    document.getElementById('user_ban2').innerHTML=data;
                    document.getElementById('user_ban').value="";
                }
            });
        }

        function user_ban_del(Num,ddiv) {

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
            });
            var formData = {
                user_ban: Num,
                id: {{$id}},
            };
            $.ajax({
                type: 'POST',
                url: '/user_ban_del',
                data: formData,
                cache: false,
                success:function(data){
                    document.getElementById(ddiv).innerHTML=data;
                }
            });
        }
        function ban_see(Num,ddiv) {
            document.getElementById("hid_ban").style.display = 'block';
            document.getElementById("hid_ban2").style.display = 'none';
        }

        function q_a_i() {

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
            });

            var set_q = document.getElementById('set_q').value;
            var formData = {
                set_q: set_q,
                id: {{$id}},
            };

            $.ajax({
                type: 'POST',
                url: '/q_a_i',
                data: formData,
                cache: false,
                success:function(data){
                    document.getElementById("set_q2").innerHTML=data;
                    setTimeout(() => {document.getElementById('set_q2').innerHTML="";}, 2000);
                }
            });
        }

        function del_adm() {

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
            });

            var formData = {
                id: {{$id}},
            };

            $.ajax({
                type: 'POST',
                url: '/del_adm',
                data: formData,
                cache: false,
                success:function(data){
                    document.getElementById("del_adm").innerHTML=data;
                }
            });
        }


    </script>


    @php
if(Auth::user()) {

    $my_id = Auth::user()->id;
    $Alla = DB::table('City_Admin2')->
    where('id', $id)->
    where('Num', $my_id)->
    limit(1)->
    get();
    $nra = $Alla->count();
    $adm_need = __('messages.adm_need');

    if ($nra==0){echo"<div align=center><h4>$adm_need</h4></div><br /><br /><br /><br /><br />";}
    else{
    $title = __('messages.adm_panel');

    $pp = __('messages.pref_page'); $pp.="c";


    for ($i = 0; $i <= 25; $i++){
       if($obl == "$i"){
            $ni2 = "messages.ooo$i";
            $nii2 = __($ni2);
            if (App::isLocale('ru')){ $obl_user="<a href=/rse$i>$nii2 </a>";}
            else if (App::isLocale('en')){  $obl_user="<a href=/ese$i>$nii2</a>";}
            else {$obl_user="<a href=/se$i>$nii2 </a>";}
       }
    }

    $Allp = DB::table('Privatec')->select('ComForBan', 'ipban', 'set_q')->
    where('id', $id)->
    limit(1)->
    get();

    $nrp = $Allp->count();
    foreach ($Allp as $All) {
        $ComForBan = $All->ComForBan;
        $ipban = $All->ipban;
        $set_q = $All->set_q;
    }
    if($nrp==0){
        $ComForBan = "";
        $ipban = "";
        $set_q = "";
    }

    $title = __('messages.adm_panel');
    $lock = __('messages.lock');
    $ip_ban2 = __('messages.ip_ban2');
    $user_ban = __('messages.user_ban');
    $user_enter = __('messages.user_enter');
    $ban_enter = __('messages.ban_enter');
    $q_a_i = __('messages.q_a_i');

    echo"<div align=center>
    <table><tr><td width=408 align=center class=fcombold>
    <br /><br /><h2>$title<br />
    <a href=/$pp$id>$City</a> $obl_user
    </h2><br />
        <table><tr><td width=375 align=left>";

    echo"<h4>$ip_ban2</h4>
    <input id=\"ipban\" SIZE=50 maxlength = 500 type=\"text\" value=\"$ipban\" placeholder=\"$ban_enter\">
    <table><tr><td class=\"fcomblue\" width=120>
        <ul class=\"intop\"><li><a onclick=ipban()>$lock</a></li></ul>
    </td></tr></table><br /><br />
    ";

    echo"<h4>$user_ban</h4>
    <input id=\"user_ban\" SIZE=50 maxlength = 70 type=\"text\" placeholder=\"$user_enter\">
    <table><tr><td class=\"fcomblue\" width=120>
        <ul class=\"intop\"><li><a onclick=user_ban()>$lock</a></li></ul>
    </td></tr></table>
    <div id=user_ban2>
    ";
        $user_ban = $ComForBan;
        $ban_n = substr_count($user_ban,"#");
    if($ban_n>0){
        $ban_pages = explode("#", $user_ban);
        $b=1;
        for($a=$ban_n; $a>0; $a--){

            $pageb=$ban_pages[$a];

            $pageq = last_visit_read($pageb);
            $Imb = $pageq['im'] ?? ''; $Prizb = $pageq['priz'] ?? '';
            $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}

            if($b==3){echo"<div id=\"hid_ban\" style=\"display: none;\">";}
            $ppi = __('messages.pref_page'); $ppi.="i";
            $delete = __('messages.Delete');
            $show_all = __('messages.show_all');
            echo"<div id=\"$t3\" style=\"margin: 7px 0px 7px 0px;\"><a href=/$ppi$pageb>$Imb $Prizb</a> <a href=## onclick=user_ban_del('$pageb','$t3')> <font size=0.5>$delete</font></a></div>";
            $b++;
        }
        if($b>3){
            echo"</div><div id=\"hid_ban2\"><a href=## onclick=ban_see()>$show_all ($ban_n)</a></div>";
        }
    }
    $Pr_show1 = "messages.Pr_show1";
    $Pr_show2 = "messages.Pr_show2";
    $Pr_show55 = "messages.Pr_show55";
    $del_adm = __('messages.del_adm');
    echo"</div><br /><br /><h4>$q_a_i</h4>
           <select id=\"set_q\" onchange=q_a_i()>";
            echo"<option value='a'"; if($set_q=='a'){echo" selected";} echo">"; echo __($Pr_show1); echo "</option>";
            echo"<option value='b'"; if($set_q=='b'){echo" selected";} echo">"; echo __($Pr_show2); echo "</option>";
            echo"<option value='c'"; if($set_q=='c'){echo" selected";} echo">"; echo __($Pr_show55); echo "</option>";
    echo"</select>

    <div id=set_q2></div><br /><br />

    <div id=del_adm><a href=## onclick=del_adm()>$del_adm </a></div><br /><br />

        </td></tr></table>
    </td></tr></table>
    <br />

    </div>";


    }
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

    <br /><br />
@endsection
