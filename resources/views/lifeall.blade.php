@extends('layouts.app')

@php
$index_go = "index,follow";
$my_domen = $_SERVER['SERVER_NAME'];
$lan = App::currentLocale();
$canonical = "https://";
$canonical.=$my_domen;
$subdomen = "/lifeua";
$subdomen0 = "lifeua";
if($lan == "ru"){
    $subdomen = "/liferu";
    $subdomen0 = "liferu";
}
$canonical .= $subdomen;
$canonical .= "/";
$canonical .= $topic ;



$amp = "amp";
if(isset($_POST['topic'])){
    $topic = $_POST['topic'];
}
else if(isset($topic)){}else {$topic = "";}




    $cq1 = "ua";
    $cq2 = "uatext";
    $life_link = "lifeua";
    if (App::isLocale('ru')){
            $cq1 = "ru";
            $cq2 = "rutext";
            $life_link = "liferu";
    }
    $Allss = DB::table('lifeall')->select('id')->
    get();
    $nrr = $Allss->count();
    $lc = $nrr;
    $lc_page=round($lc/100+0.49);


    $Alls = DB::table('lifeall')->select($cq1, $cq2, 'id', 'r_kol', 'r_gol', 'amp_img')->
    where('link', $topic)->
    limit(1)->
    get();
    $nrc = $Alls->count();
    $keywords = "";
    if($nrc==0){
            $title = __('messages.unknown_page');
            $description = $title;
            $ua = __('messages.unknown_page');
            $amp_img = "";
    }
    else{
        $title = "";
        $description = "";
        foreach ($Alls as $All) {
            $ua = $All->$cq1;
            $mytxt = $All->$cq2;
            $id = $All->id;
            $r_kol = $All->r_kol;
            $r_gol = $All->r_gol;
			$amp_img = $All->amp_img;

            $id1=$id-1; $id2=$id+1; $id3=$id-2;
             $uatag = str_ireplace("{", "", $ua);
             $uatag = str_ireplace("}", "", $uatag);
             $uatag = str_ireplace("?|", "? ", $uatag);
             $keywords = str_ireplace("|", ", ", $uatag);
             $description = $description.= "$keywords";
        }

        $ntag=substr_count($ua, '{');

        for($ntag0=1;$ntag0<=$ntag;$ntag0++){

            $position = strpos($ua, "{"); $content = substr($ua, $position+1);
            $position = strpos($content, "}"); $content = substr($content, 0, $position);

            $content2 = "|$content";
            $ntag2=substr_count($content2, '|');
            $words = explode("|", $content2);
            $zn=rand(1,$ntag2);
            $word=$words[$zn];
            $contentr="{"; $contentr.=$content; $contentr.="}";
            $title = str_replace("$contentr", "$word", $ua);
        }
    }


@endphp





@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('title_block'){{$ua}}@endsection

@section('robots'){{$index_go}}@endsection
@section('canonical'){{$canonical}}@endsection
@section('amp'){{$amp}}@endsection
@section('index')index@endsection
@section('amp_img'){{ $amp_img }} @endsection
@section('image'){{ $amp_img }}@endsection
@section('content')


@php

if($nrc>0){

		$views = (int) \Illuminate\Support\Facades\Redis::get("life_views:all$id");
		$ip = getenv('REMOTE_ADDR');
    if (strstr($ip,"66.249.")=="" && \Illuminate\Support\Facades\Redis::set("dedup:lifall:$id", 1, 'EX', 60, 'NX')){
        \Illuminate\Support\Facades\Redis::incr("life_views:all$id");
    }

    $all_records = __('messages.all_records');

    echo"
<section class=\"sear-tit \" style=\"margin: 15px auto; text-align: center; \">
    <amp-ad width=\"100vw\" height=\"320\"
            type=\"adsense\"
            data-ad-client=\"ca-pub-7495053896041990\"
            data-ad-slot=\"7275245359\"
            data-auto-format=\"rspv\"
            data-full-width=\"\"
			role=\"complementary\">
        <div overflow=\"\"></div>
    </amp-ad>
    <a style=\"padding: 5px 50px; \" href=/$life_link/$lc_page>$all_records ($lc)</a>
</section>
<br />

<section id=news style = \"max-width:900px; margin:0 auto; overflow: hidden; width: 93%; text-align: left; font-size: 14px; line-height:22px;\">
";


$ntag=substr_count($mytxt, '{');

for($ntag0=1;$ntag0<=$ntag;$ntag0++){

  $position = strpos($mytxt, "{"); $content = substr($mytxt, $position+1);
  $position = strpos($content, "}"); $content = substr($content, 0, $position);

$content2 = "|$content";
$ntag2=substr_count($content2, '|');
$words = explode("|", $content2);
$zn=rand(1,$ntag2);
$word=$words[$zn];
$contentr="{"; $contentr.=$content; $contentr.="}";
$mytxt = str_replace("$contentr", "$word", $mytxt);

}
$views=$views+1;

echo"$mytxt";
$view = __('messages.views');
echo"
<div style=\"display: inline-block; \">
    <span style=\" display: flex; align-items: center; gap: 5px; padding: 8px; border-radius: 10px; background-color: #fff; \">
        <img src=\"/images/magnifying.jpg\" alt='$view' width=\"22\" height=\"22\">
        <b style=\"font-size:16px;\">$views</b>
    </span>
</div>
<br /><br /><br /><br />
</section>
";


}

if($nrc>0){
    $conditions = [
        ['id', $id1],
        ['id', $id2],
        ['id', $id3],
    ];
    $Allm = DB::table('lifeall')
    ->select($cq1, 'link')
    ->where(function ($query) use ($conditions) {
        foreach ($conditions as $condition) {
            $query->orWhere($condition[0], '=', $condition[1]);
        }
    })
    ->orderBy('id', 'desc')
    ->get();
}
else{
      $Allm = DB::table('lifeall')
    ->select($cq1,'link')
    ->orderBy('id', 'desc')
    ->limit(7)
    ->get();
}


foreach ($Allm as $All) {
    $ua = $All->$cq1;
    $link = $All->link;

    echo"
    <section class=\"sear-tit \" style=\"margin: 0 auto; max-width: 600px;
        line-height: 30px; display: flex; flex-direction: column; gap: 10px; \" >
        <a href=\"/$subdomen0/$link\" style=\"padding: 5px 5px 5px 25px\"><b>$ua </b></a>
    </section>";

}

@endphp


    <br /><br />
	<div data-nosnippet style="margin: 0 auto; text-align: center; font-size: 12px;">
		<h2>{{__('messages.sharing')}}:</h2>
		@php
			$lan = App::currentLocale();
			$wh_domen=$_SERVER["HTTP_HOST"];
			$sh_link = "https%3A%2F%2F$wh_domen%2F$life_link%2F$topic";
		@endphp

		<ul class="scale" style="padding: 2px; margin: 0 auto; display: flex; gap: 15px; justify-content: center; list-style: none;" >
			<li>
				<a style="" target="_blank" href="https://www.facebook.com/sharer.php?u={{$sh_link}}">
					<img
					  alt="facebook"
					  src="/images/fb40.png"
					  width="35"
					  height="35"
					>
				</a>
			</li>
			<li>
				<a target="_blank" href="https://telegram.me/share/url?url={{$sh_link}}">
                    <img
                      alt="telegram"
                      src="/images/tgram40.png"
                      width="35"
                      height="35"
                    >
				</a>
			</li>
			<li>
				<a target="_blank" href="viber://forward?text={{$sh_link}}">
					<img
					  alt="viber"
					  src="/images/viber40.png"
					  width="35"
					  height="35"
					>
				</a>
			</li>
			<li>
				<a target="_blank" href="https://twitter.com/intent/tweet?url={{$sh_link}}">
					<img
					  alt="twitter"
					  src="/images/twitter40.png"
					  width="35"
					  height="35"
					>
				</a>
			</li>
			<li>
				<a target="_blank" href="https://api.whatsapp.com/send?text={{$sh_link}}">
					<img
					  alt="whatsapp"
					  src="/images/wapp40.png"
					  width="35"
					  height="35"
					>
				</a>
			</li>
		</ul>


        <br /><br />
        <amp-ad width="100vw" height="320"
                type="adsense"
                data-ad-client="ca-pub-7495053896041990"
                data-ad-slot="7275245359"
                data-auto-format="rspv"
                data-full-width=""
				role="complementary">
            <div overflow=""></div>
        </amp-ad>
	</div >



@endsection

@endsection
