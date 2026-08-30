@extends('layouts.app')

@php
$title = __('messages.mview_tit');
$description = __('messages.mview_des');
$keywords = __('messages.mview_key');
$index_go="index,follow";

global $mview_windowonload;
$mview_windowonload = "go";

if(isset($_POST['id'])){$id = $_REQUEST['id'];}
else if(isset($id)){}else {$id = 0;}

$Allc = DB::table('Allcities')->select('domen', 'City', 'City2', 'City3', 'rayc', 'vol_karta', 'x', 'y', 'z', 'status')->
where('id', $id)->limit(1)->get();
foreach ($Allc as $All) {
    $domen = $All->domen;
    $City = $All->City; $City2 = $All->City2; $City3 = $All->City3;
    $rayc = $All->rayc; $vol_karta = $All->vol_karta;
    $x = $All->x; $y = $All->y; $z = $All->z; $status = $All->status;
}
$nd = $Allc->count();
if($nd==0){
    $title = __('messages.unknown_page');
    $description = $title;
    $keywords = $title;
}
else{
    $lan = __('messages.lan');
     if($lan=="ua"){
         if ($status){
            if ($status==1){$statusne="міста";}
            if ($status==2){$statusne="смт";}
            if ($status==3){$statusne="селища";}
            if ($status==4){$statusne="села";}
            if ($status==5){$statusne="хутора";}
        }
        else{
            if (!$vol_karta||$vol_karta<20000){ $statusne="села";}
            if ($vol_karta>=20000&&$vol_karta<50000){$statusne="міста (села)";}
            if ($vol_karta>=50000){ $statusne="міста";}
        }
        $in_ad = "$statusne $City";
        $title = "$City - $title";
        $keywords = "$City, $keywords";
        $description = str_replace("Фознімки", "Фознімки $in_ad", $description);
    }
    if($lan=="ru"){
        if ($status){
            if ($status==1){$statusne="города";}
            if ($status==2){$statusne="пгт"; }
            if ($status==3){$statusne="поселка";}
            if ($status==4){$statusne="села";}
            if ($status==5){$statusne="хутора";}
        }
        else{
            if (!$vol_karta||$vol_karta<20000){$statusne="села";}
            if ($vol_karta>=20000&&$vol_karta<50000){$statusne="города (села)";}
            if ($vol_karta>=50000){$statusne="города";}
        }
        $City = $City2;
        $in_ad = "$statusne $City2";
        $title = "$City2 - $title";
        $keywords = "$City, $keywords";
        $description = str_replace("Фотографии,", "Фотографии $in_ad", $description);
    }
    if($lan=="en"){
        $City = $City3;
        $in_ad = "in $City3";
        $statusne = "";
        $description = str_replace("Photos", "Photos $in_ad", $description);
        $title = "$City3 - $title";
        $keywords = "$City, $keywords";
    }
}
		$xr=0.03; $yr=0.02;
        if($z==13 || $z==12){$xr=0.03; $yr=0.02;}
        if($z==14){$xr=0.015; $yr=0.009;}

        $x0f=$x-$xr; $x1f=$x+$xr;
        $y0f=$y-$yr; $y1f=$y+$yr;

        $z11 = $z-1;
// $x = 49.8453;
// $y = 32.7552;
@endphp

@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection
@push('scriptsdown')
    <script>
        window.onload = loadScript;
    </script>
@endpush
@push('scripts')
<script>

    function loadScript() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA1IdWsdhaIEnazOKZ_HL4l5x_R4LZLmqc&signed_in=true&language=uk&' +
            'callback=initialize';
        document.body.appendChild(script);
    }


    var map;
    var infoWindow;

    function initialize() {
        var mapOptions = {
            center: new google.maps.LatLng(49, 31.75),
            zoom: 6
        };
        map = new google.maps.Map(document.getElementById('map'),
            mapOptions);

    map = new google.maps.Map(document.getElementById('map'), mapOptions);


        const image =
            "https://1ua.com.ua/images/red_marker.png";

        const beachMarker = new google.maps.Marker({
            position: { lat: {{$y}}, lng: {{$x}} },
            map,
            icon: image,
        });

    // Define an info window on the map.
    infoWindow = new google.maps.InfoWindow();
    }

</script>
@endpush
 
@section('content')

    <div id=map style="max-width: 950px; height: 750px" class=fcom></div>
    <br /><br />
@endsection
