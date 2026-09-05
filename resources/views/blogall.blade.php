@extends('layouts.app')

@php
$title = __('messages.blogall_tit');
$description = __('messages.blogall_des');
$keywords = __('messages.gps_key');
$index_go="index,follow";

if(isset($_POST['npass1'])){$npass1 = $_REQUEST['npass1'];}
else if(isset($id)){}else {$npass1 = 1;}

@endphp

@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection

@section('content')
<div align="center">
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
    $Alls = DB::table('lifeall')->select('id')->
    get();
    $nrr = $Alls->count();

    // if((!$npass1)||$npass1==0){$npass1=1;}

    // $npass1=$npass1+1; $npass1=$npass1-1;
    // if(is_int($npass1)!="true"){die("");}

    $npass1 = filter_var($npass1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if (!$npass1) {
        $npass1 = 1;
    }

    $limit = substr($nrr, strlen($nrr)-2, 2);
    $limit10="";
    if($limit=="00"){$limit=100; $limit10=1;}

    $nrr_pages=intval($nrr/100);
    if($limit10!=1){$nrr_pages=$nrr_pages+1;}

    if($npass1==$nrr_pages){$shift=0;}
    else{
    $shift=$limit + 100*($nrr_pages - $npass1-1);
    $limit=100;
    }



    $l1=$npass1-3;
    $l2=$npass1+3;
    if($l2>$nrr_pages){$l2=$nrr_pages;}

        $cq = "uatext";
    $life_link = "lifeua";
    if (App::isLocale('ru')){
        $cq = "rutext";
        $life_link = "liferu";
    }

echo"<table><tr><td align=center width=535><table width=100%><tr>";

if($l2!=$nrr_pages){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$life_link/$nrr_pages><b><font color=white>$nrr_pages</font></b></a></li></ul> </td>";}
if(($nrr_pages-$l2)>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}

for($l2; $l1<=$l2; $l2--){

if($l2>0 && $l2<=$nrr_pages){

	if($npass1!=$l2){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$life_link/$l2><b><font color=white>$l2</font></b></a></li></ul> </td>";}
	else{echo"<td class=fcom0 align=center> <b>$l2</b> </td>";}
}

}
if($l2>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}
if($l2>0){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$life_link/1><b><font color=white>1</font></b></a></li></ul> </td>";}


echo"</tr></table>

</td></tr></table>";



echo"<div id=news class=\"content\">

<br /><br />
<table>";


    $Allc = DB::table('lifeall')->
    select($cq, 'link')->
    orderBy('id', 'desc')->
    skip($shift)->take($limit)->
    get();

    foreach ($Allc as $All) {
        $ua = $All->$cq;
        $link = $All->link;

        $ntag=substr_count($ua, '{');

        for($ntag0=1;$ntag0<=$ntag;$ntag0++){

            $position = strpos($ua, "{"); $content = substr($ua, $position+1);
            $position = strpos($content, "}"); $content = substr($content, 0, $position);

            $content2 = "|$content";
            $ntag2=substr_count($content2, '|');
            $words = explode("|", $content2);
            // Було rand() — той самий текст на тій самій URL показувався по-різному щоразу
            // (класичний "spun content", який Google занижує в видачі). Тепер завжди перший
            // варіант — стабільний, детермінований текст для однієї сторінки.
            $zn=1;
            $word=$words[$zn];
            $contentr="{"; $contentr.=$content; $contentr.="}";
            $ua = str_replace("$contentr", "$word", $ua);
        }

        $ua = str_replace("<p style='text-indent: 45px;'>", "", $ua);
        $ua = str_replace("</p>", "", $ua);

        $ua = substr($ua, 0, 300);
        for($nseek=1;$nseek<20;$nseek++){
             $rest = substr($ua, -$nseek);
             if(strstr($rest, " ")!=""){$nseek2=$nseek; $nseek=20;}
        }

        $ua = substr($ua, 0, 300-$nseek2);

        echo"<tr><td width=535 height=30 align=center style=\"cursor: pointer;\" class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\"><table><tr><td width=500 align=left>
        <a href=/$life_link/$link>$ua...</a><br /><br />
        </td></tr></table></td></tr>";
        }

    echo"</table>";

    $l1=$npass1-3;
    $l2=$npass1+3;
    if($l2>$nrr_pages){$l2=$nrr_pages;}

echo"<br /><table><tr><td align=center width=535><table width=100%><tr>";


if($l2!=$nrr_pages){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$life_link/$nrr_pages><b><font color=white>$nrr_pages</font></b></a></li></ul> </td>";}
if(($nrr_pages-$l2)>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}

for($l2; $l1<=$l2; $l2--){

if($l2>0 && $l2<=$nrr_pages){

	if($npass1!=$l2){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$life_link/$l2><b><font color=white>$l2</font></b></a></li></ul> </td>";}
	else{echo"<td class=fcom0 align=center> <b>$l2</b> </td>";}
}

}
if($l2>1){echo"<td class=fcom0 align=center> <b>...</b> </td>";}
if($l2>0){echo"<td class=fcomblue align=center><ul class=intop><li> <a href=/$life_link/1><b><font color=white>1</font></b></a></li></ul> </td>";}


echo"</tr></table>

</td>

</tr></table><br />";




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
</div>
@endsection
