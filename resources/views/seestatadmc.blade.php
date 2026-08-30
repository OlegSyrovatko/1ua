@extends('layouts.app')

@php
$title = __('messages.admc_tit');
$description = __('messages.admc_des');
$keywords = __('messages.admc_key');
$index_go="index,follow";

if(isset($_POST['nav'])){$nav = $_REQUEST['nav'];}
else if(isset($nav)){}else {$nav = 2;}

 $npass0=$nav-10; if($npass0<1){$npass0=1;}
 $npass2=$nav+10;
 $npass01=$npass0+9;
 $npass21=$npass2+9;

$nav = $nav-1;


@endphp

@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection


@section('content')
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

    @php
    $Allb = DB::table('users')->select('Num','Im','Priz','avatar','l_visit','ratingmemory')->
    orderBy('ratingmemory', 'desc')->where('ratingmemory', '>', 200)->skip($nav)->take(10)->get();
    $online = __('messages.online');

echo"
<div align = center>
<h3><b>$title</b></h3><br />
    <table><tr><td width=468 align=center class=fcombold>
    <br />
    <table><tr><td width=435 align=left>";

    $Md_is_online = date('Y-m-d H:i');
    $pref_page = __('messages.pref_page'); $ppref_page = $pref_page .="i";
    $points = __('messages.points');
    $lan = __('messages.lan');
    foreach ($Allb as $All) {
        $avt = $All->Num; $summem = $All->ratingmemory; $summem = round($summem/100);
        $M3 = $All->Im; $M2 = $All->Priz;
        $Num_a = $All->avatar;  if($Num_a<10){$Num_a=7;}
        $l_visit = $All->l_visit;
        $from=strtotime($l_visit);
        $to=strtotime($Md_is_online);
        $razn=($to-$from)/60;
        $on_line_block="";
        if ($razn<=5){$on_line_block="<br /><font color=green><b>$online</b></font>";}
        $nav_e=$nav+1;
        echo"<table class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
        <tr><td width=115 align=center>
            <div style='margin: 10px 5px 10px 10px;'>
                <a href=/$ppref_page$avt><img SRC=\"/storage/avatar/$Num_a.jpg\" border=0></a>
            </div>
        </td><td width=325 align=left>
            <div style='margin: 10px 10px 10px 5px;'>
        <b>№$nav_e <a href=\"/$ppref_page$avt\";>$M3 $M2 </a></b>$on_line_block<br />$summem $points<br />";

        $Alla = DB::table('City_Admin2')->select('id')
            ->where('Num', $avt)->where('Page', 'Memory')->whereNotNull('id')
            ->groupBy('id')
            ->orderBy('Md','asc')->get();
        $Alladn = $Alla->count();
        if($Alladn==0){
            $Alla = DB::table('Memory')
            ->select('id')
            ->where('avt',$avt)
            ->groupBy('id')
            ->orderBy('Md','asc')
            ->get();
        }
        foreach ($Alla as $Ala) {
            $id = $Ala->id;
        	$Allb = DB::table('Allcities')->select('ab')->
			where('id', $id)->limit(1)->get();
			foreach ($Allb as $All) {
				$ab = $All->ab;
				$pagec = explode("#!", $ab);
				$City1=$pagec[1]; $City2=$pagec[2]; $City3=$pagec[11]; $domen=$pagec[12];
				if($lan=="ua"){echo" <a href=\"/$domen\"> $City1</a>";}
				if($lan=="ru"){echo" <a href=\"/$domen/ru\"> $City2</a>";}
				if($lan=="en"){echo" <a href=\"/$domen/en\"> $City3</a>";}
			}
        }

        echo"</div></td></tr></table>";

        if(!$M3){$nav--;}

        echo"<br />";

        $nav ++;

    }

    $adv_adm1 = __('messages.adv_adm1');
    $adv_adm2 = __('messages.adv_adm2');
    $adv_adm3 = __('messages.adv_adm3');
    $adv_adm4 = __('messages.adv_adm4');
    $adv_adm5 = __('messages.adv_adm5');

    echo"</td></tr></table>
    </td></tr></table>

<table style=\"cursor: pointer;\"><tr><td width=230 align=center class=fcombold onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"document.location='/seestatadmc/$npass0'\">
<a href=/seestatadmc/$npass0><b>$npass0-$npass01</b></a>
</td>
<td width=230 align=center class=fcombold onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" onClick=\"document.location='/seestatadmc/$npass2'\">
 <a href=/seestatadmc/$npass2><b>$npass2-$npass21</b></a></td></tr></table>

<br />
<table><tr><td width=468 align=center class=fcombold onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\"><br />
$adv_adm1 <br />$adv_adm2<br /><br />
$adv_adm3<br /> $adv_adm4<br /><br />
$adv_adm5
<br /><br />
</td></tr></table>
<br />

</div>";

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

    <br /><br />
@endsection
