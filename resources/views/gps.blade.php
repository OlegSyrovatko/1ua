@extends('layouts.app')

@php

$title = __('messages.gps_tit');
$description = __('messages.gps_des');
$keywords = __('messages.blogall_key');
$index_go="index,follow";

if(isset($_POST['nf'])){$nf = $_REQUEST['nf'];}
else if(isset($nf)){}else {$nf = 2;}
$Namef = $nf;

        $Allb = DB::table('Foto')->select('id','x','y','z','Fd','Formf')->
        where('Namef', $nf)->limit(1)->get();
        foreach ($Allb as $All) {
            $id = $All->id; $x = $All->x; $y = $All->y; $z = $All->z; $Fd = $All->Fd;
            $Formf = $All->Formf;
        }
        $nd = $Allb->count();
        if($nd==0){
            $title = __('messages.unknown_page');
            $description = $title;
            $keywords = $title;
        }
        else{
            $monm = substr($Fd, 5, 2); $yem = substr($Fd, 0, 4);
            if ($monm<10){$monmf = substr($Fd, 6, 1);}
            else{$monmf=$monm;}
            if($yem<=2007){$yem = "2005-2007"; $monmf="";}
            $katalogb = "Photos/$yem$monmf/b$Namef.$Formf";
            $katalog = "Photos/$yem$monmf/$Namef.$Formf";
            $katalogs = "Photos/$yem$monmf/s$Namef.$Formf";


            if (Storage::disk('public')->exists($katalogb)) {
                $katalogface = Storage::disk('public')->url($katalogb);
            } elseif (Storage::disk('public')->exists($katalog)) {
                $katalogface = Storage::disk('public')->url($katalog);
            } else {
                $katalogface = "https://1ua.com.ua/images/no_photo.jpg";
            }

            $katalogface = str_replace("http:", "https:", $katalogface);


            $size = @getimagesize($katalogface);

            if ($size !== false && isset($size[0])) {
                $wmain = $size[0];
            } else {
                $wmain = 480;
            }
			$katalogfaces = getKatalogs($katalogs, $katalog);

            $Allc = DB::table('Allcities')->select('domen', 'City', 'City2', 'City3', 'oblc', 'rayc', 'vol_karta', 'x', 'y', 'z', 'status')->
            where('id', $id)->limit(1)->get();
            foreach ($Allc as $All) {
                $domen = $All->domen; $City = $All->City; $City2 = $All->City2; $City3 = $All->City3;
                $oblc = $All->oblc; $rayc = $All->rayc; $vol_karta = $All->vol_karta;
                $xc = $All->x; $yc = $All->y; $mas = $All->z; $status = $All->status;
            }

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
                $description = str_replace("Фото", "Фото $in_ad", $description);
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
                $description = str_replace("Фото", "Фото $in_ad", $description);
            }
            if($lan=="en"){
                $City = $City3;
                $in_ad = "in $City3";
                $statusne = "";
                $description = str_replace("Photo", "Photo $in_ad", $description);
                $title = "$City3 - $title";
            }
        }

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

    @if($nd==0)

        @php $unnp2 = __('messages.unknown_page'); @endphp


        <br /><br /><br /><div align='center'><table class=fcom><tr><td align=center>
                        <div style="align-content: center; padding-right: 30px; padding-left: 30px" >
                            <h4><br />{{  $unnp2 }}<br /><br /><a href="javascript:history.go(-1)">{{  __('messages.unknown_page4') }}</a><br /><br /></h4>
                        </div>
                    </td></tr></table></div><br /><br /><br /><br />

    @else

@php
    $no_mark = __('messages.no_mark');
    $do_mark = __('messages.do_mark');
    $on_mark = __('messages.on_mark');

    if((!$x) && (!$y)){
        $textonmap="$no_mark $statusne <br />$do_mark";
        $x = $xc; $y = $yc;
    }

    else if(($x) && ($y)){
        $textonmap=$on_mark;
    }

	if($x&&$y){$mas=15;}
	if($id==$rayc){$mas=$mas+1;}
	if($id==$oblc){$mas=$mas+1;}
	if($z){$mas=$z;}

$difkv=$vol_karta/600000;
$difk=0.2+$difkv;

if($lan=="ua"){$mc_e="mc"; $nf_e="nf";}
if($lan=="ru"){$mc_e="rmc"; $nf_e="rnf";}
if($lan=="en"){$mc_e="emc"; $nf_e="enf";}

@endphp
<div><textarea  style="display: none;  overflow-y: hidden;" ID=Aboutefm_txt><a href=/{{$nf_e}}{{$Namef}}><img border=0 width='auto' SRC='{{$katalogfaces}}'></textarea></div>
<div  align = center>
    <div class="layermaxwideadm" align = center style="max-width: 1077px; overflow: hidden;">
        <div class=layerfoto align = center>
            <table>
                <tr><td width=1077 height=30 align=center style="cursor: pointer;" class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'" onClick=location.href="/{{$domen}}/{{$lan}}"><a><h4>{{$City}} </h4></a></td></tr>
            </table>
        </div>
        <div class=layerfoto align = center>
            <table>
                <tr><td width=1077 height=30 align=center style="cursor: pointer;" class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'" onClick=location.href="/{{$domen}}/foto/{{$lan}}"><a><h4>{{ __('messages.all_photos') }} {{$statusne}} </h4></a></td></tr>
            </table>
        </div>
        <div class=layerfoto align = center>
            <table>
                <tr><td width=1077 height=30 align=center style="cursor: pointer;" class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'" onClick=location.href="/{{$mc_e}}{{$id}}"><a><h4>{{ __('messages.cartography') }} </h4></a></td></tr>
            </table>
        </div>

    </div>

    @php
        echo"<br /><div style=\" margin: 0px 15px 0px 15px;\"><table><tr><td><h3>$textonmap</h3></td></tr></table></div>";
        $to_large = __('messages.to_large');
        $to_small = __('messages.to_small');
        $to_move = __('messages.to_move');


    @endphp

    <br />
    <div id="map" style="width:100%;height:500px;"></div>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1IdWsdhaIEnazOKZ_HL4l5x_R4LZLmqc&callback=initMap&libraries=&v=weekly&language=uk"
        async
    ></script>
    <div class=hidblok>
        <table><tr><td>
            <div style='margin: 15px 15px 15px 15px;'>
                {{$to_large}} <b>+</b><br />
                {{$to_small}}<br />
                {{$to_move}}<br />
            </div>
        </td></tr></table>
    </div><br />
    <a href=/{{$nf_e}}{{$Namef}}><img width='{{$wmain}}' src={{$katalogface}} border=0></a><br /><br />


    <script>

        function initMap() {
            const myLatlng = { lat: {{$y}}, lng: {{$x}} };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: {{$mas}},
                center: myLatlng,
            });
            map.setMapTypeId(google.maps.MapTypeId.HYBRID);

            var textonmap = document.getElementById("Aboutefm_txt").value;

            // Create the initial InfoWindow.
            let infoWindow = new google.maps.InfoWindow({
                content: textonmap,
                position: myLatlng,
            });
            infoWindow.open(map);
            // Configure the click listener.
            map.addListener("click", (mapsMouseEvent) => {
                // Close the current InfoWindow.
                infoWindow.close();
                // Create a new InfoWindow.
                infoWindow = new google.maps.InfoWindow({
                    position: mapsMouseEvent.latLng,
                });

                var zzoom = map.getZoom();
                var x = mapsMouseEvent.latLng.lng();
                var y = mapsMouseEvent.latLng.lat();
                var xc = {{$xc}}; var xcd=Math.abs(x-xc);
                var yc = {{$yc}}; var ycd=Math.abs(y-yc);

                if(zzoom<15){alert("{{  __('messages.too_small') }} {{$statusne}} {{$City}}");}
                else if(xcd > {{$difk}}||ycd > {{$difk}}){alert("{{  __('messages.too_back') }}");}
                else{

                    $.ajaxSetup({
                        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                    });
                    var formData = {
                        namef: {{$Namef}}, x: x, y: y, z: zzoom,
                    };
                    $.ajax({
                        type: 'POST',
                        url: '/rec',
                        data: formData,
                        cache: false,
                        success:function(data){}
                    });

                    infoWindow.setContent(textonmap);
                    infoWindow.open(map);
                }

            });
        }

    </script>


</div>
@php


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
    @endif
@endsection
