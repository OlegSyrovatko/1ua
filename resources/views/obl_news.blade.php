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

<script type="text/javascript">
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
						url: "/load_obl_news",
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

</script>



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
