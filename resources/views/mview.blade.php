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
    $x = $All->x; $y = $All->y; $z = (int)$All->z; $status = $All->status;
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
    	$xr=0.03; $yr=0.02;
        if($z==13 || $z==12){$xr=0.03; $yr=0.02;}
        if($z==14){$xr=0.015; $yr=0.009;}

        $x0f=$x-$xr; $x1f=$x+$xr;
        $y0f=$y-$yr; $y1f=$y+$yr;

        $z11 = $z-1;
}
	

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
@if($nd>0)
    @push('scripts')
        <script>

            function loadScript() {
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA1IdWsdhaIEnazOKZ_HL4l5x_R4LZLmqc&signed_in=true&language=uk&' +
                    'callback=initialize';
                document.body.appendChild(script);
            }

            var rectangle;
            var map;
            var infoWindow;

            function initialize() {
                var mapOptions = {
                    center: new google.maps.LatLng({{$y}}, {{$x}}),
                    zoom: {{$z11}}
                };
                map = new google.maps.Map(document.getElementById('map'),
                    mapOptions);

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            var bounds = new google.maps.LatLngBounds(
                new google.maps.LatLng({{$y0f}}, {{$x0f}}),
                new google.maps.LatLng({{$y1f}}, {{$x1f}})
            );


            // Define the rectangle and set its editable property to true.
            rectangle = new google.maps.Rectangle({
                bounds: bounds,
                editable: true,
                draggable: true
            });
            rectangle.setMap(map);

            // Add an event listener on the rectangle.
            google.maps.event.addListener(rectangle, 'bounds_changed', showNewRect);

            // Define an info window on the map.
            infoWindow = new google.maps.InfoWindow();
            }
            // Show the new coordinates for the rectangle in an info window.

            /** @this {google.maps.Rectangle} */




            function showNewRect(event) {

                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                markers = [];

                var ne = rectangle.getBounds().getNorthEast();
                var sw = rectangle.getBounds().getSouthWest();

                tempmap.xx0.value=sw.lng();
                tempmap.xx1.value=ne.lng();
                tempmap.yy0.value=sw.lat();
                tempmap.yy1.value=ne.lat();

                // Set the info window's content and position.
                // infoWindow.setContent("Карта змінена");
                // infoWindow.setPosition(ne);
                //  infoWindow.open(map);
            }

            google.maps.event.addDomListener(window, 'load', initialize);

        </script>
    @endpush
@endif
@section('content')

    @if($nd==0)

        @php $unnp2 = __('messages.unknown_page'); @endphp


        <br /><br /><br /><div align='center'><table class=fcom><tr><td align=center>
                        <div style="align-content: center; padding-right: 30px; padding-left: 30px" >
                            <h4><br />{{  $unnp2 }}<br /><br /><a href="javascript:history.go(-1)">{{  __('messages.unknown_page4') }}</a><br /><br /></h4>
                        </div>
                    </td></tr></table></div><br /><br /><br /><br />

    @else

    <script>

        function a(on, off)
        {
            document.getElementById(on).style.visibility = "visible";
            document.getElementById(off).style.visibility = "hidden";
        }

        function ina(on, off)
        {
            document.getElementById(off).style.visibility = "visible";
            document.getElementById(on).style.visibility = "hidden";
        }

        function build_arrea(on, off, name_arrea, x, y, purp)
        {
            var str='';
            str+='<div id="'+on+'" style="visibility : hidden; position : absolute; margin-top: '+y+'px; margin-left: '+x+'px; "><img src="/images/on.png" border="0"></div>';
            str+='<div id="'+off+'" style="position : absolute; margin-top: '+y+'px; margin-left: '+x+'px; "><img src="/images/'+purp+'.png" border="0"></div>';
            str+='<div id="'+on+'_text" style="position : absolute; margin-top: '+(y-20)+'px; margin-left: '+x+'px; "><table cellpadding="0" cellspacing="0" border="0">';
            str+='<tr><td class="left"><img src="images/1x1.gif" width="1" height="1"></td><td bgcolor="#DDE2F5" class="content" style="padding: 2px">'+name_arrea+'</td><td class="right"><img src="/images/1x1.gif" width="1" height="1"></td></tr>';
            str+='</table></div>'
            str+='';
            document.write(str);
        }

    </script>


    <div  align = center>
        <table><tr><td width=950 align=center>

                <script>
                    var xxx0;
                    var xxx1;
                    var yyy0;
                    var yyy1;
                    var xxx0h = {{$x0f}};
                    var xxx1h = {{$x1f}};
                    var yyy0h = {{$y0f}};
                    var yyy1h = {{$y1f}};
                    var ft=1;
                    var pageh=0;

                    var timerId = setInterval(function() {

                        xxx0 = document.tempmap.xx0.value;
                        xxx1 = document.tempmap.xx1.value;
                        yyy0 = document.tempmap.yy0.value;
                        yyy1 = document.tempmap.yy1.value;
                        if(!xxx0){xxx0=xxx0h;}
                        if(!xxx1){xxx1=xxx1h;}
                        if(!yyy0){yyy0=yyy0h;}
                        if(!yyy1){yyy1=yyy1h;}

                        if(ft==1 || xxx0h!=xxx0 || xxx1h!=xxx1 || yyy0h!=yyy0 || yyy1h!=yyy1){ft=0; pageh=0;

                            var pageHeight = document.documentElement.clientHeight;
                            pageHeight=pageHeight-400; var pageHeighte = pageHeight+"px";

                            $.ajaxSetup({
                                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                            });

                            var formData = {
                                page: 0, x0: xxx0, x1: xxx1, y0: yyy0, y1: yyy1,
                            };
                            $.ajax({
                                type: 'POST',
                                url: '/fotoonmap',
                                data: formData,
                                cache: false,
                                success:function(data){
                                    document.getElementById('notice_in_right').innerHTML=data;
                                    if(data.length<300){document.getElementById("notice_in_right").style.height = "150px";}
                                    else{document.getElementById("notice_in_right").style.height = pageHeighte;}
                                    document.getElementById('fnext').style.display = 'none';
                                }
                            });
                        }
                        xxx0h=xxx0; xxx1h=xxx1; yyy0h=yyy0; yyy1h=yyy1;
                    }, 1500);


                    function fmnext(page,x00,x11,y00,y11,dnext){
                        if(pageh!=page){
                            $.ajaxSetup({
                                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                            });
                            var formData = {
                                page: page, x0: xxx0, x1: xxx1, y0: yyy0, y1: yyy1,
                            };
                            document.getElementById(dnext).style.display = 'none';
                            $.ajax({
                                type: 'POST',
                                url: '/fotoonmap',
                                data: formData,
                                cache: false,
                                success:function(data){
                                    document.getElementById('notice_in_right').innerHTML+=data;
                                    if(data.length<300){document.getElementById("notice_in_right").style.height = "150px";}
                                    else{document.getElementById("notice_in_right").style.height = pageHeighte;}

                                }
                            });
                        }
                        pageh=page;
                    }

                    var image = "/images/offz.png";
                    var markers = [];
                    function markshow(y,x) {
                        var yy=y-0.1; yy=yy+0.1; var xx=x-0.1; xx=xx+0.1;
                        var pos = {lat: yy, lng: xx};

                        markers.push(new google.maps.Marker({
                            position: pos, icon: image,
                            map: map,
                            animation: google.maps.Animation.DROP
                        }));
                    }

                </script>



                <div id=map style="max-width: 950px; height: 500px" class=fcom></div>
                <br /><br />

                <div id="notice_in_right" class=scrollbar_right style="color: white; position: fixed; bottom: 15px; right: 15px; z-index : 666666666; width: 220px; height: 20%; overflow-y:scroll;" >

                </div>

                <form method="post" name=tempmap>
                    <input type=hidden NAME=xx0><input type=hidden NAME=xx1><input type=hidden NAME=yy0><input type=hidden NAME=yy1>
                </form>

            </td></tr></table>
        </div>



    <div  align = center>
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

        <div class="layermaxwideadm" align = center style="max-width: 1077px; overflow: hidden;">
            <div class="layer1">

                <table>
                    <tr><td width=1077 height=30 align=center style="cursor: pointer;" class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'" onClick=location.href="/{{$domen}}/{{$lan}}"><a><h4>{{$City}} </h4></a></td></tr>
                    <tr><td width=1077 height=30 align=center style="cursor: pointer;" class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'" onClick=location.href="/{{$domen}}/foto/{{$lan}}"><a><h4>
                                    {{ __('messages.all_photos')}} {{$statusne}} </h4></a></td></tr>
                    <tr><td width=1077 height=50 align=center class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'" >
                            <h4> {{ __('messages.move_show')}}<br />{{ __('messages.move_show2')}}</h4></td></tr>
                </table>
            <br />
            </div>
            <div class="layer1">
            <table><tr><td>
                <DIV style="MARGIN-TOP: 0px; MARGIN-LEFT: 0px; position : absolute;">
                </DIV>
                <script>
                    @php
                        $x_max=0.19; $y_max=0.3;
                        $x0=$x-0.125;$x1=$x+0.125;
                        $y0=$y-0.15;$y1=$y+0.15;
                        $xpic_max=235;
                        $ypic_max=370;
                        $mapk=""; $mapk2="";
                        $Allc = DB::table('Allcities')->select('id', 'City', 'City2', 'City3', 'rayc', 'x', 'y')->
                        where('x', '>', $x0)->
                        where('x', '<', $x1)->
                        where('y', '>', $y0)->
                        where('y', '<', $y1)->
                        get();
                        foreach ($Allc as $All) {
                            $Citym = $All->City; $City2 = $All->City2; $City3 = $All->City3;
                            $link_mc = "mc";
                            if($lan=="ru"){
                                $Citym = $City2;
                                $link_mc = "rmc";
                            }
                            if($lan=="en"){
                                $Citym = $City3;
                                $link_mc = "emc";
                            }
                            $idm = $All->id; $raycxy = $All->rayc; $xx = $All->x; $yy = $All->y;
                            if($xx>0 && $yy>0){

                                $Citym = strtr($Citym, "'", "*");
                                $xx=$xx-$x0; $yy=abs($yy-$y0);
                                $xpic=round($xpic_max*$xx/$x_max); $ypic=abs(round($ypic_max*$yy/$y_max)-$ypic_max);
                                if($idm==$raycxy){$ball="offz";}
                                else if($rayc==$raycxy){$ball="off";}
                                else{$ball="off_ar";}

                                $xpicn=$xpic+4; $ypicn=$ypic+4;
                                echo"build_arrea('on$idm','off$idm','$Citym',$xpic,$ypic,'$ball');";
                                $mapk2=$mapk2.="<area onmouseover=\"a('on$idm','off$idm')\" onmouseout=\"ina('on$idm','off$idm')\" shape=circle coords=$xpicn,$ypicn,9
                                 href=/$link_mc$idm>";
                            }
                        }

                    @endphp
                </script>

                <DIV id=main2 style="MARGIN-TOP: 0px; MARGIN-LEFT: 0px; POSITION: relative; z-index: 90001;">
                    <IMG src="/map/1x1.gif" width=360 height=360 useMap=#Map2 border=0>
                    <MAP name=Map2>
                        @php echo"$mapk2"; @endphp
                    </MAP>
                </DIV>


            </td></tr></table>
                <br /><br /><br /><br /><br /><br />
            </div>

            <div class="clear"></div>



        </div>
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
