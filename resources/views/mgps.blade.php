@extends('layouts.app')

@php
if(isset($_POST['id'])){$id = $_REQUEST['id'];}

@endphp


@section('content')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1IdWsdhaIEnazOKZ_HL4l5x_R4LZLmqc&callback=initMap&libraries=&v=weekly"
        async
    ></script>

    @php
        $Allb = DB::table('Allcities')->select('x','y','z')->
    where('id', $id)->limit(1)->get();
    foreach ($Allb as $All) {
         $x = $All->x; $y = $All->y; $mas = $All->z; if(!$mas){$mas=14;}
    }
    @endphp

    <br />
    <div align="center">
    <div  id="map" style="width:70%;height:600px;"></div>


    <textarea  style="display: none;" ID=Aboutefm_txt><img border=0 SRC=''></textarea>

    <script>
        function m_no_rec(id) {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
            });
            var formData = {
                id: id
            };
            $.ajax({
                type: 'POST',
                url: '/m_no_rec',
                data: formData,
                cache: false,
                success:function(data){
                    document.getElementById('m_no_rec').innerHTML=data;
                }
            });
        }
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

                    $.ajaxSetup({
                        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                    });
                    var formData = {
                        id: {{$id}}, x: x, y: y, z: zzoom
                    };

                    $.ajax({
                        type: 'POST',
                        url: '/mrec',
                        data: formData,
                        cache: false,
                        success:function(data){}
                    });

                    infoWindow.setContent(textonmap);
                    infoWindow.open(map);
            });
        }

    </script>

    </div>

    <div id="m_no_rec"><a onclick="m_no_rec({{$id}})">m_no_rec</a></div>
@endsection
