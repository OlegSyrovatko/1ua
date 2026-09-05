@extends('layouts.app')



@section('content')
<div align="center">

<script type="text/javascript">
	// jQuery підключається з defer (layouts/app.blade.php), а цей інлайн-скрипт виконується
	// одразу під час парсингу — РАНІШЕ, ніж відпрацює defer-скрипт jQuery, і "$" тут ще не
	// існує. DOMContentLoaded настає вже ПІСЛЯ виконання всіх defer-скриптів.
	document.addEventListener('DOMContentLoaded', function () {
	$(document).ready(function (e) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$('#search').submit(function(e) {
			e.preventDefault();
			var formData = new FormData(this);

			let TotalFiles = $('#files')[0].files.length;
			if(TotalFiles == 0){alert("{{ __('messages.ch_foto') }}");}
			else{
				if (TotalFiles>30){}
				else{

					let files = $('#files')[0];
					for (let i = 0; i < TotalFiles; i++) {
						formData.append('files' + i, files.files[i]);
					}

					formData.append('TotalFiles', TotalFiles);

					$.ajax({
						type:'POST',
						url: "/load_map_village",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,
						success:function(data){
							document.getElementById("load_obl_news").innerHTML=data;
						}
					});
				}
			}
		});
	});
	});

</script>



    <br />
    <div align="center">


        @php

/*
            $Allb = DB::table('Allcities')->select('id', 'City', 'obl', 'x', 'y')->
    where(['vol_karta2' => '1'])->
    limit(10)->
    get();
    $Allbn = $Allb->count();
*/

           //     echo"<a href=https://www.google.com/maps/@$y,$x,14z/data=!3m1!1e3 target=_blank >$obl $City </a><br />";


            $Allb = DB::table('Allcities')->select('id','City','obl','x','y','z')->
    where('vol_karta2', '1')->
    limit(10)
        // ->where('id', $id)->limit(1)
        ->get();
        foreach ($Allb as $All) {
             $id = $All->id; $City = $All->City; $x = $All->x; $y = $All->y; $mas = $All->z; $obl = $All->obl;
            DB::table('Allcities')
            ->where('id', $id)
            ->update(['vol_karta2' => '2']);

            if(!$mas){$mas=14;}
             echo"<div  id=\"map$id\" style=\"width:50%;height:500px;\"></div>
            <br /><a target=_blank href=https://1ua.com.ua/mgps/$id>______ $id ____ $City _map____________</a><br /><br />
            <script
                src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyA1IdWsdhaIEnazOKZ_HL4l5x_R4LZLmqc&callback=initMap$id&libraries=&v=weekly\"
                async
            ></script>

            <script>
                function initMap$id() {
                    const myLatlng = { lat: $y, lng: $x };
                    const map = new google.maps.Map(document.getElementById(\"map$id\"), {
                        zoom: $mas,
                        center: myLatlng,
                    });
                    map.setMapTypeId(google.maps.MapTypeId.HYBRID);

                    let infoWindow = new google.maps.InfoWindow({
                        content: textonmap,
                        position: myLatlng,
                    });
                    infoWindow.open(map);


                }

            </script>
             ";

        }
        @endphp


    </div>




<br /><br /><br />
<table><tr><td align=right width = 1180>
			<table><tr><td class=fcom0><table><tr><td width=5></td><td align=right>
									<form id='search' method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
										@csrf
										<table>
											<tr><td>
												</td><td>
													<input type="file" name="files[]"  style="width: 90%"  id="files" placeholder="Choose files" multiple  onchange=load_hid.style.display='block';>
												</td><td>
													<button type="submit" class="fcomblue" id="submit"><ul class="intopbig"><li><a>Завантажити</a></li></ul></button>

												</td></tr>
										</table>
									</form>


								</td><td width=5></td></tr></table>
					</td></tr></table>
		</td></tr></table>

<div id="load_obl_news" ></div>





    <br /><br />
</div>
@endsection
