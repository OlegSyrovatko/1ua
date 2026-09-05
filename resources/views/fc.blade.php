@extends('layouts.app')
@php

$album = str_ireplace("@s@l@", "/", $album);
$album = str_ireplace("@q@w@", "?", $album);
$lan = __('messages.lan');
global $cwindowonload;
$cwindowonload = "go";


$nd=0; $design = "all";
if($namef && $namef !="0") {
    $Alln = DB::table('Foto')->
    select('id', 'Fd', 'Formf', 'album','Nameg','w','h','Adrf','Datef','avt','x','y','views','r_gol','r_kol','rh')->
    where('Namef', $namef)-> limit(1)-> get();
    $Allnn = $Alln->count();
    if($Allnn==0){$id="0"; $domen="0";}
    foreach ($Alln as $Aln) {
            $id=$Aln->id;
            $Fd=$Aln->Fd;
            $Formf=$Aln->Formf;
            $album=$Aln->album;
            $Nameg = $Aln->Nameg;
			$w = $Aln->w;
			$h = $Aln->h;
            $M3 = $Aln->Adrf;
            $M4 = $Aln->Datef;
            $avt = $Aln->avt;
            $x = $Aln->x;
            $y = $Aln->y;
            $views = $Aln->views;
            $r_gol = $Aln->r_gol;
            $r_kol = $Aln->r_kol;
            $rh = $Aln->rh;
            if($w== -1 ){$w=200;}
            if($h== -1 ){$h="auto";}
    }
    $design = "alone";
}
if($domen && $domen !="0") {
    $Alls = DB::table('Allcities')->
    select('id', 'domen', 'rayc', 'City', 'City2', 'City3', 'sumr', 'obl', 'status', 'x', 'y', 'z', 'vol_karta', 'face_karta', 'oblc',
    'apps', 'City_m', 'City_o', 'City_r', 'City_d', 'rod', 'dat', 'tvor',
     'predl', 'ab', 'sumr', 'closersf')->
        where('domen', $domen)-> limit(1)-> get();
}
else if($id && $id !="0") {
    $Alls = DB::table('Allcities')->
    select('id', 'domen', 'rayc', 'City', 'City2', 'City3', 'sumr', 'obl', 'status', 'x', 'y', 'z', 'vol_karta', 'face_karta', 'oblc',
    'apps', 'City_m', 'City_o', 'City_r', 'City_d', 'rod', 'dat', 'tvor',
     'predl', 'ab', 'sumr', 'closersf')->
        where('id', $id)-> limit(1)-> get();
}
else {$nd=0; $id="0"; $domen="0";}

if($id != "0" || $domen != "0"){
    foreach ($Alls as $All) {
         $id=$All->id; $domen=$All->domen;  $rayc=$All->rayc; $City1=$All->City;  $City2=$All->City2;  $City3=$All->City3;
         $obl=$All->obl; $status=$All->status;
          $vol_karta=$All->vol_karta;  $face_karta=$All->face_karta;  $oblc=$All->oblc;  $apps=$All->apps;
           $City_m=$All->City_m;  $City_o=$All->City_o;  $City_r=$All->City_r;  $City_d=$All->City_d;
            $rod=$All->rod;  $dat=$All->dat;  $tvor=$All->tvor;  $predl=$All->predl;
              $ab=$All->ab; $rate=$All->sumr; $closersf=$All->closersf;
            $pagec = explode("#!", $ab); $nrm7=$pagec[8];

      $lanem = App::currentLocale();  if(!$lanem){$lanem = "ua";}
    if($lanem == "ua"){$City_in=$City_m; $City_of=$City_r; $City_by=$City_o; $City_to=$City_d;}
    if($lanem == "ru"){$City_in=$predl; $City_of=$rod; $City_by=$tvor; $City_to=$predl;}
    if($lanem == "en"){$City_in="in $City3";$City_of="of $City3"; $City_by="by $City3";$City_to="to $City3";}
        $nd++;
    }
}
if($nd==0){
    $title = __('messages.unknown_page');
    $description = $title;
    $keywords = $title;
    $rayc=""; $City="";  $City2=""; $City3="";
     $obl=""; $status="";
      $vol_karta=""; $face_karta=""; $oblc=""; $apps="";
       $City_m=""; $City_o=""; $City_r=""; $City_d="";
        $rod=""; $dat=""; $tvor=""; $predl="";
        $id="";  $ab="";
      $index_go = "noindex,follow"; $path1 = ""; $fpath=""; $flinka = "";
       $nrm7=""; $City_s="";
      $City_in=""; $City_of=""; $City_by=""; $City_to=""; $rate = ""; $closersf = "";


}
else {
 if ($status){
    if ($status==1){
        $statusn=__('messages.statusn1');
        $statusnv=__('messages.statusnv1');
        $statusr=__('messages.statusr1');
        $statusd=__('messages.statusd1');
        $statusm=__('messages.statusm1');
        $statuso=__('messages.statuso1');
        $statuspro=__('messages.statuspro1');
    }
    if ($status==2){
        $statusn=__('messages.statusn2');
        $statusnv=__('messages.statusnv2');
        $statusr=__('messages.statusr2');
        $statusd=__('messages.statusd2');
        $statusm=__('messages.statusm2');
        $statuso=__('messages.statuso2');
        $statuspro=__('messages.statuspro2');
    }
    if ($status==3){
        $statusn=__('messages.statusn3');
        $statusnv=__('messages.statusnv3');
        $statusr=__('messages.statusr3');
        $statusd=__('messages.statusd3');
        $statusm=__('messages.statusm3');
        $statuso=__('messages.statuso3');
        $statuspro=__('messages.statuspro3');
    }
    if ($status==4){
        $statusn=__('messages.statusn4');
        $statusnv=__('messages.statusnv4');
        $statusr=__('messages.statusr4');
        $statusd=__('messages.statusd4');
        $statusm=__('messages.statusm4');
        $statuso=__('messages.statuso4');
        $statuspro=__('messages.statuspro4');
    }
    if ($status==5){
        $statusn=__('messages.statusn5');
        $statusnv=__('messages.statusnv5');
        $statusr=__('messages.statusr5');
        $statusd=__('messages.statusd5');
        $statusm=__('messages.statusm5');
        $statuso=__('messages.statuso5');
        $statuspro=__('messages.statuspro5');
    }
}
else{
    if (!$vol_karta||$vol_karta<20000){
            $statusn=__('messages.statusn4');
            $statusnv=__('messages.statusnv4');
            $statusr=__('messages.statusr4');
            $statusd=__('messages.statusd4');
            $statusm=__('messages.statusm4');
            $statuso=__('messages.statuso4');
            $statuspro=__('messages.statuspro4');
    }
    if ($vol_karta>=20000&&$vol_karta<50000){
            $statusn=__('messages.statusn6');
            $statusnv=__('messages.statusnv6');
            $statusr=__('messages.statusr6');
            $statusd=__('messages.statusd6');
            $statusm=__('messages.statusm6');
            $statuso=__('messages.statuso6');
            $statuspro=__('messages.statuspro6');
    }
    if ($vol_karta>=50000){
            $statusn=__('messages.statusn1');
            $statusnv=__('messages.statusnv1');
            $statusr=__('messages.statusr1');
            $statusd=__('messages.statusd1');
            $statusm=__('messages.statusm1');
            $statuso=__('messages.statuso1');
            $statuspro=__('messages.statuspro1');
    }
}



$ob_user2 = __('messages.Region3');

          for ($i = 0; $i <= 25; $i++){
             $ni2 = "messages.oo$i"; $ii = "$i";
               if($obl == $ii){ $nii2 = __($ni2); if($obl == "1"){ $ob_user2 = "";}
               $obl_user2 = "$nii2 $ob_user2";
              if (App::isLocale('ru')){ $obl_user="<a href=/rse$i>$nii2 $ob_user2</a>"; $City=$City2; $City_s="City2"; if(mb_strlen($rod)>2){$City_r = $rod;} else{$City_r=$City2;}}
              else if (App::isLocale('en')){  $obl_user="<a href=/ese$i>$nii2 $ob_user2</a>"; $City=$City3; $City_s="City3"; $City_r = "of $City3";}
              else {$obl_user="<a href=/se$i>$nii2 $ob_user2</a>"; $City=$City1; $City_s="City";}
               }
          }
        $Foto = __('messages.Foto');
        if($id==$oblc || $id==$rayc){$title = "$Foto $statusr $City";}
        else{$title = "$Foto $statusr $City $obl_user2";}
        if($album){$title = "$album - $City";}

        $index_go = "index,follow";

        $description = __('messages.fc_desc');
        $keywords3 = __('messages.fc_keyw');
        $keywords = "$statusnv $City, $keywords3";
        if($album){$keywords = "$album, $keywords";}
}

@endphp
@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('title_block'){{$title}}@endsection

@section('content')

    @if($nd==0)

        @if($domen) @php $unnp2 = __('messages.unknown_page2'); @endphp
        @else @php  $unnp2 = __('messages.unknown_page3'); @endphp
        @endif

		<section id="hidpage" class="fcom0">
			<h4>{{  $unnp2 }}</h4>
			<a href="javascript:history.go(-1)">{{  __('messages.unknown_page4') }}</a>
        </section>

    @else
        @php $admpass="off"; @endphp
        @guest @php $my_id = ""; @endphp @else
            @php $my_id = Auth::user()->Num;
                $Allad = DB::table('City_Admin2')->select('id')->
        where('Num', $my_id)->where('Page', 'Foto')->where('id', $id)->
        limit(1)->get();
        $Alladn = $Allad->count();
        if($Alladn>0){$admpass="ok";}

                    $sq=0;
        $Allq = DB::table('Privatec')->select('ComForBan')->
            where('id', $id)->limit(1)->get();
            foreach ($Allq as $Alq) { $ComForBan=$Alq->ComForBan; $sq++; }
            if($sq==0){$ComForBan = "";}

            @endphp
        @endguest



    @php

    $pref_page = __('messages.pref_page'); $ppref_page = $pref_page .="i";
    $time_sec=time();

        $id = intval($id);
        if (is_int($id) != "true") { die("");}


    @endphp
        <section class="ph-menu-container">
			@php
				$lan = __('messages.lan');
						$link_mc = "mc";
						if($lan=="ru"){
							$link_se = "rse";
						}
						if($lan=="en"){
							$link_se = "ese";
						}
			@endphp
			<ul class="menu-list menu-list-photo">
				<li class="fcom menu-item">
					<a href="/{{$domen}}/{{ __('messages.lan') }}/" >
						<h1>{{$City}} </h1>
					</a>
				</li>
				<li class="fcom menu-item">
					<a href="/{{$link_mc}}{{$id}}" >
						<h2>{{__('messages.gps_tit')}} </h2>
					</a>
				</li>
				<li class="fcom menu-item">
					<a href="##" onClick="all_alb('{{$id}}','date','{{$domen}}')" rel="noopener noreferrer">
						<h2>{{ __('messages.albumsf') }} </h2>
					</a>
				</li>
				<li class="fcom menu-item">
					<a href="##" onClick="comment_c('{{$id}}','0','1')" rel="noopener noreferrer">
						<h3>{{ __('messages.Comment') }} </h3>
					</a>
				</li>
			</ul>


        @auth
            <script type="text/javascript">
                // jQuery підключається з defer (шаром layouts/app.blade.php), а цей інлайн-скрипт
                // виконується одразу під час парсингу сторінки — тобто РАНІШЕ, ніж відпрацює
                // defer-скрипт jQuery, і "$" тут ще не існує. DOMContentLoaded гарантовано настає
                // вже ПІСЛЯ виконання всіх defer-скриптів, тому чекаємо саме на нього.
                document.addEventListener('DOMContentLoaded', function () {
                $(document).ready(function (e) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#fsearch').submit(function(e) {
                        e.preventDefault();
                        var formData = new FormData(this);

                        let TotalFiles = $('#files')[0].files.length;
                        if(TotalFiles == 0){alert("{{ __('messages.ch_foto') }}");}
                        else{
                            if (TotalFiles>10){alert("{{ __('messages.ch_foto10') }}");}
                            else{
                                document.getElementById("load_on").style.display = 'block';
                                let files = $('#files')[0];
                                for (let i = 0; i < TotalFiles; i++) {
                                    formData.append('files' + i, files.files[i]);
                                }

                                formData.append('TotalFiles', TotalFiles);

                                var alb = document.getElementById("album0").value;
								var Adrf = document.getElementById("Adrf0").value;
								var Datef = document.getElementById("Datef0").value;
								var id = {{ $id }};
                                formData.append('alb', alb);
								formData.append('Adrf', Adrf);
								formData.append('Datef', Datef);
								formData.append('id', id);
                                $.ajax({
                                    type:'POST',
                                    url: "{{ url('load_foto')}}",
                                    data: formData,
                                    cache:false,
                                    contentType: false,
                                    processData: false,
                                    success:function(data){
                                        document.getElementById("load_foto").innerHTML=data;
                                        document.getElementById("load_on").style.display = 'none';
                                    }
                                });
                            }
                        }
                    });
                });
                });
                function displayFileName(input) {
                    var fileNames = [];

                    for (var i = 0; i < input.files.length; i++) {
                        fileNames.push(input.files[i].name);
                    }

                    document.getElementById('file-name').innerHTML = fileNames.join(', ');
                    load_hid.style.display = 'block';
                    var searchElement = document.getElementById('fsearch');
                    searchElement.style.justifyContent = 'flex-end';
                    document.getElementById('submit').style.marginTop = '10px';
                }
            </script>

            @if($album) @php $alb_e = $album; @endphp
            @else @php $alb_e = ""; @endphp @endif
			@php $maxtoday = date('Y-m-d'); @endphp
            <form class="fcom0 margin-top" id='fsearch' method="POST" action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <label for="files" class="custom-file-input">{{ __('messages.ch-photo') }}</label>
                {{-- Без accept="image/jpeg": на Android з цим атрибутом Chrome відкриває системний
                     Photo Picker, який вирізає GPS з EXIF для приватності. Без accept частіше
                     показується класичний діалог із пунктом "Файли", що не чіпає метадані.
                     Тип файлу все одно перевіряється на сервері (mimes:jpg,jpeg). --}}
                <input type="file" id="files" name="files[]" class="un-display" onchange="displayFileName(this)" placeholder="Choose files" multiple>

                <span class="file-name margin-file" id="file-name"></span>
                <div id="load_hid" class="margin-top">
                    {{ __('messages.Album') }}: <input type=text id=album0 size=23 maxlength = 45 value="{{$alb_e}}"><br />
					{{ __('messages.adr_shot') }}:<input type=text id=Adrf0 size=23 maxlength = 50><br />
					{{ __('messages.date_shot') }}:<input type="date" max="{{$maxtoday}}" id=Datef0 size=23 maxlength = 23><br />
                </div>
                <div id="load_on">
                    {{ __('messages.Loading_wait') }}<br />
                    <img SRC="/images/upload.gif"><br />
                    {{ __('messages.Loading_wait2') }}
                </div>
                <button type="submit" class="custom-file-input ml10" id="submit">{{ __('messages.add_foto') }}</button>
                <div id="load_foto" ></div>
            </form>
		@endauth

        @if($album)
            <ul class="menu-list menu-list-photo">
                <li class="fcom menu-item">
                    <a href="/{{$domen}}/foto/{{$lan}}/{{$album}}">
						<h3> {{__('messages.Album')}}: {{$album}} </h3>
					</a>
                </li>
                <li class="fcom menu-item">
					<a href="/{{$domen}}/foto/{{$lan}}/">
						<h3> {{ __('messages.goout_a') }} </h3>
					</a>
                </li>
            </ul>
        @endif
			<section class="centered" id=foto_in>  </section>

        </section>

        @if ($design == "alone")
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                    crossorigin="anonymous"></script>
            <!-- фото міст -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-7495053896041990"
                 data-ad-slot="2276822707"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            @php
                $memory_contents = Storage::disk('public')->get('delseeffile.txt');
                $pc="c";
                if (strstr($memory_contents,"$pc$namef")==""){
                    $memory_contents.="$pc$namef";
                    Storage::disk('public')->put('delseeffile.txt', $memory_contents);
                    DB::table('Foto')->where('Namef', $namef)->increment('views', 1);
                }
                $namef=intval($namef);
                if(is_int($namef)!="true"){die("");}

                     $M6nf=$Fd; $M6nf0=$M6nf; $M7nf=$Formf; $albumnext=$album;

                    $monm = substr($Fd, 5, 2); $yem = substr($M6nf, 0, 4);

                if ((int)$monm<10){$monmf = substr($M6nf, 6, 1);}
                else{$monmf=$monm;}
                if((int)$yem<=2007){$yem = "2005-2007"; $monmf="";}

                $katalogbmain = "Photos/$yem$monmf/b$namef.$Formf";
                $katalogmain = "Photos/$yem$monmf/$namef.$Formf";
                
                try {
                    if (Storage::disk('public')->exists($katalogbmain)) {
                        $katalog = Storage::disk('public')->url($katalogbmain);
                    } elseif (Storage::disk('public')->exists($katalogmain)) {
                        $katalog = Storage::disk('public')->url($katalogmain);
                    } else {
                        $katalog = "https://1ua.com.ua/images/no_photo.jpg";
                    }
                } catch (\Throwable $e) {
                    $katalog = "https://1ua.com.ua/images/no_photo.jpg";
                }

                $katalog_main = str_replace("http:", "https:", $katalog);



                 $abf_out = view('inc.abf', ['id' => $id, 'Namef' => $namef, 'admpass' => $admpass, 'Nameg' => $Nameg,
                'City' => $City, 'domen' => $domen, 'M3' => $M3, 'M4' => $M4,
                'M6' => $Fd, 'M7' => $Formf, 'w' => $w, 'h' => $h, 'avt' => $avt, 'x' => $x, 'y' => $y, 'alb' => $album,
                'views' => $views, 'r_gol' => $r_gol, 'r_kol' => $r_kol, 'rh' => $rh, 'design' => 'alone', 'alb_des' => 'default']);

                $pref_l = __('messages.pref_page');
                $fpref_l = $pref_l .="nf";

                $f1=1;
                $groupf = array('Namef','Fd','Formf');
                $Alln = DB::table('Foto')->
                select('Namef', 'Fd', 'Formf')->
                 where('id', $id)->
                 where('album', $album)->
                orderBy('Fd', 'desc')->get();
                $nal = $Alln->count();
                foreach ($Alln as $Aln) {
                    $groupf['Namef'][$f1]=$Aln->Namef;  $groupf['Fd'][$f1]=$Aln->Fd; $groupf['Formf'][$f1]=$Aln->Formf;
                    if($groupf['Namef'][$f1]==$namef){$f_is=$f1;}

                    $f1++;
                }

                $f_isback=$f_is-1;
                $f_isgo=$f_is+1;
                $Namef_first=$groupf['Namef'][1];

                if($f_isback>0){
                    $namef=$groupf['Namef'][$f_isback]; $M6nf=$groupf['Fd'][$f_isback]; $M7nf=$groupf['Formf'][$f_isback];
                    $back="onClick=\"document.location='$fpref_l$namef'\" style=\"cursor: pointer;\""; $backlf="$fpref_l$namef";
                }

                if($f_isgo<=$nal && $f_isgo>0){
                    $namef=$groupf['Namef'][$f_isgo]; $M6nf=$groupf['Fd'][$f_isgo]; $M7nf=$groupf['Formf'][$f_isgo];
                    $go="onClick=\"document.location='$fpref_l$namef'\" style=\"cursor: pointer;\""; $golf="$fpref_l$namef";
                }

                if($f_isgo<=$nal && $f_isgo>0){} else{$namef=$Namef_first;}
                $goisfoto="$fpref_l$namef";

                $f1 = $f1 - 1;

            $nback = __('messages.nback');
            $nnext = __('messages.nnext');
            $inn = __('messages.inn');
            $end_album = __('messages.end_album');
            @endphp
        <section class="hidblokwide ph-menu-container centered" >
            <ul class="menu-list ph-nav">
                <li class="fcom menu-item lph-nav" @php if($f_isback>0){echo"$back";} @endphp >
                    <h4>
                        @php
                            if($f_isback>0){echo"$nback";
                                if($f1>1){echo" ($f_isback $inn $f1)";}
                            }
                            else {echo" $end_album ";}
                        @endphp
                    </h4>
                </li>
                <li class="fcom menu-item rph-nav" @php if($f_isgo<=$nal && $f_isgo>0){echo"$go";} @endphp >
                    <h4>
                        @php
                            if($f_isgo<=$nal && $f_isgo>0){
                                echo"$nnext";
                                if($f1>1){
                                    echo" ($f_isgo $inn $f1)";
                                }
                            }
                            else {echo" $end_album";}
                        @endphp
                    </h4>
                </li>
            </ul>
            <a href="{{$goisfoto}}"><img alt="{{$title}}"  class="img" width="{{$w}}" height="{{$h}}" src = {{$katalog_main}}></a>
        </section>
        <section class="hidblok ph-menu-container">
            <ul class="menu-list ph-nav-b" style="margin-bottom: 0;">
                <li class="fcom menu-item pointed lph-nav-b"
                    @php if($f_isback>0){echo"$back";} @endphp >
                    <h3>@php
                            if($f_isback>0){
                                echo"$nback";
                                if($f1>1){
                                    echo"($f_isback $inn $f1)";
                                }
                            }
                            else {echo" $end_album ";}
                        @endphp
                    </h3>
                </li>
                <li class="fcom menu-item pointed ph-nav-b-center">
                    <a href="{{$goisfoto}}">
                        <img class="img" alt="{{$title}}" width="{{$w}}" height="{{$h}}" src = {{$katalog_main}}>
                    </a>
                </li>
                <li class="fcom menu-item pointed  rph-nav-b"
                    @php if($f_isgo<=$nal && $f_isgo>0){echo"$go";}@endphp >
                    <h3>@php
                            if($f_isgo<=$nal && $f_isgo>0){
                                echo"$nnext ";
                                if($f1>1){echo" ($f_isgo $inn $f1) ";}
                            }
                            else {echo" $end_album ";}
                        @endphp
                    </h3>
                </li>
            </ul>

        </section>

        <section class="ph-menu-container centered" >
            @php
                echo $abf_out;
            @endphp
        </section>
        @else
            @php


            if(!$album){
                $closersfn=substr_count($closersf, 'f#o#to');
                if($closersfn>0 ){
                    echo"<section class=\"centered ph-menu-container\" >
                    <div  class=\"fcom0 menu-ph-closed\" >
                        <h4 class=\"mb10\">Найближчі населені пункти (кількість фото):</h4>";
                        $closersfx = explode("f#o#to", $closersf);

                        $dlf_text="";
                        for($nfe=1; $nfe<=$closersfn; $nfe++){

                            $abff=$closersfx[$nfe];
                            $lf = explode("&&", $abff);
                            $dlf=$lf[1]; $clf=$lf[2]; $nlf=$lf[5];
                            $dlf_text.="<a style = \"margin-right:10px;\" href=/$dlf/foto/$lan/>$clf - $nlf</a> ";
                        }
                        $place_lr = substr($dlf_text, strlen($dlf_text)-2, 2);
                        if($place_lr==", "){$dlf_text=substr($dlf_text,0, strlen($dlf_text)-2);}
                    echo"$dlf_text</div></section>";
                }
            }

            $Allb = DB::table('Foto')->select('Namef', 'Nameg', 'City', 'Adrf', 'Datef',  'Fd', 'Formf', 'w', 'h', 'avt', 'album', 'x', 'y', 'views', 'r_gol', 'r_kol', 'rh')
                ->where('id', $id)
                ->when($album, function ($query) use ($album) {
                    return $query->where('album', $album);
                })
                ->orderBy('Fd', 'desc')
                ->limit(31)
                ->get();

            if($album){
                $alb_a = $album;
                $alb_e = $album;
            } else{
                $alb_a = "default";
                $alb_e = "";
            }

            $Allbn = $Allb->count();
            @endphp
            @if($Allbn>0)
                <section id=foto class="fsection">
                    <section  class="centered">
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                                crossorigin="anonymous"></script>
                        <!-- фото міст -->
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-7495053896041990"
                             data-ad-slot="2276822707"
                             data-ad-format="auto"
                             data-full-width-responsive="true"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </section>
                    <ul class="flist">
            @endif
                @php

                $nfm = 1;
                foreach ($Allb as $Alb) {
                    if($nfm<31){
                        $Namef = $Alb->Namef;
                        $Nameg = $Alb->Nameg;
                        $City = $Alb->City;
                        $M3 = $Alb->Adrf;
                        $M4 = $Alb->Datef;
                        $M6 = $Alb->Fd;
                        $M7 = $Alb->Formf;
                        $w = $Alb->w;
                        $h = $Alb->h;
                        $avt = $Alb->avt;
                        $alb = $Alb->album;
                        $x = $Alb->x;
                        $y = $Alb->y;
                        $views = $Alb->views;
                        $r_gol = $Alb->r_gol;
                        $r_kol = $Alb->r_kol;
                        $rh = $Alb->rh;

                        echo view('inc.abf', ['id' => $id, 'Namef' => $Namef, 'admpass' => $admpass, 'Nameg' => $Nameg,
                            'City' => $City, 'domen' => $domen, 'M3' => $M3, 'M4' => $M4,
                            'M6' => $M6, 'M7' => $M7, 'w' => $w, 'h' => $h, 'avt' => $avt, 'x' => $x, 'y' => $y, 'alb' => $alb,
                            'views' => $views, 'r_gol' => $r_gol, 'r_kol' => $r_kol, 'design' => 'default', 'alb_des' => $alb_a, 'rh' => $rh]);
                    }
                    $nfm++;
                }

                @endphp
            @if($Allbn>0)
                </ul>
                @if($nfm>10)
                    <section  class="centered">
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                                crossorigin="anonymous"></script>
                        <!-- фото міст -->
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-7495053896041990"
                             data-ad-slot="2276822707"
                             data-ad-format="auto"
                             data-full-width-responsive="true"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </section>
                @endif
                @if($nfm==32)
                    @php
                        if($album){$Namef_a = $Namef;}
                        else{$Namef_a = 0;}

                    @endphp
                    <section id=nextf_div2 class="fcombold mt15 centered" onMouseOver=foto('{{$id}}','{{$domen}}','{{$Namef_a}}','2') >
                        <a href=## onclick=foto('{{$id}}','{{$domen}}','{{$Namef_a}}','2') rel="noopener noreferrer">
                            <h3>{{__('messages.nnext')}} {{$alb_e}}</h3>
                        </a>
                    </section>
                @endif

                </section>
            @endif
        @endif


        @php

            $g_insert="off";
              $Allg = DB::table('gcf')->select('Numg', 'Im', 'Priz', 'Num_a', 'Vd')->
              where('Num', $id)->
              orderBy('Vd', 'desc')->limit(11)->get();
              $Allgn = $Allg->count();

                  $Numm = 0;
                  $nguests = 0;
                  if(Auth::user()) {
                      $Numm =  Auth::user()->id;
                      $show_news = Auth::user()->show_news;
                      if (!$show_news) {
                          $nguests = 1;
                      } else {
                          $nguests = substr($show_news, 10, 1);
                      }
                  }

              if($Allgn==0 && $Numm>0 && $nguests==1){$g_insert="on";}
              if($Allgn>0){

                  $guests = __('messages.guests');
                  $online = __('messages.online');
                  $delete = __('messages.delete');
                  $lan = App::currentLocale();

                  $guests_e="$guests $statusr $City";
                  if($lan == "ru"){$guests_e="$guests $statusr $City2";}
                  if($lan == "en"){$guests_e="$guests of $City $statusr";}
                  echo"
                  <section class=\"fcom0 city-center-block centeredm mt15\" >
                      <h3>$guests_e</h3>
                      <ul id=guests>";
                       $ng=1;
                      foreach ($Allg as $Alg) {
                          if($ng<11){
                              $avtc = $Alg->Numg; $Img = $Alg->Im; $Prizg = $Alg->Priz;
                              $Num_a = $Alg->Num_a; if($Num_a>0){} else{$Num_a=7;} $Vd = $Alg->Vd;
                              if($ng==1 && $Numm>0 && $nguests==1){
                                      if($avtc!=$Numm){$g_insert="on";}
                                      else{
                                          $Num_a = Auth::user()->avatar;
                                          if($Num_a=='0' || !$Num_a ){$Num_a=7;}
                                          $Vd_now = date('Y-m-d H:i:s');
                                          $aff_upd = DB::table('gcf')
                                          ->where('Vd', $Vd)
                                          ->where('Num', $id)
                                          ->where('Numg', $Numm)
                                          ->update(['Vd' => $Vd_now, 'Num_a' => $Num_a]);
                                          if($aff_upd){$Vd = $Vd_now;}
                                      }
                                  }
                              $qonl = "";
                                if($avtc>0){
                                    $aavt = avt($avtc,$Numm);
                                    $aavt = str_replace("forum-avatar", "center-avatar", $aavt);
                                    $aavt = str_replace("<br />", "", $aavt);
                                    $aavt = str_replace("</svg>", "</svg><br />", $aavt);
                                    $aavt = str_replace("</div>", "</div><br />", $aavt);
                                }

                              $pref_page = __('messages.pref_page'); $ppref_page = $pref_page .="i";
                              if($Vd){$Vds = str_replace(" ", "*", $Vd);
                              $Vd_e = substr($Vd, 0, strlen($Vd)-3);

                              $gdata = substr($Vd_e, 0, 10);
                              $gtime = substr($Vd_e, 10, 6);
                                  $Nd_today = date('Y-m-d');
                                  $Nd_past = date('Y-m-d', strtotime('-1 days'));
                                  if($gdata==$Nd_past){
                                      $Vd_e="Вчора"; $titler="Вчера"; $titlee="Yestarday";
                                      if($lan=="en"){$Vd_e=$titlee;}
                                      else if($lan=="ru"){$Vd_e=$titler;}
                                  }
                                  else if($gdata==$Nd_today){
                                      $Vd_e=$gtime;
                                  }
                                  else{
                                      $Vd_e=$gdata;
                                  }
                              $Vd_e="<p class=grey>$Vd_e</p>";}
                              else{$Vd_e="";}

                              $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}

                              echo"<li id=\"$t3\" class=\"colored centered\" >$aavt";

                              if($Numm==$avtc){$nameg="$Img";}

                              if($admpass=="ok"||$Numm==$avtc){
                                  echo"$Vd_e <a onclick=fguesc_del('$avtc','$Vds','$t3','$id') rel=\"noopener noreferrer\"> $delete</a>";
                              }
                              echo"</li>";
                          }

                          $ng++;
                      }
                       echo"</ul>";

                          $g_ins = "";
                          if($g_insert=="on"){
                              $Vd_now = date('Y-m-d H:i:s');
                              $Imm = Auth::user()->Im;
                              $Prizm = Auth::user()->Priz;
                              $avatar = Auth::user()->avatar;
                               if($avatar=='0'){$avatar=7;}
                              $g_ins = DB::table('gcf')->
                              insert(['Num' => $id, 'Numg' => $Numm, 'Im' => $Imm, 'Priz' => $Prizm, 'Num_a' => $avatar, 'Vd' => $Vd_now]);
                              $g_insert="off";
                          }

                          if($ng==12){
                              $t1="qwertyuiopasdfghjklzxcvbnm"; $t2="";
                              for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t2.="$t1[$z]";}
                              $pregg=0;
                              if($g_ins){$pregg=1;}
                              echo"
                              <section id=$t2 class=\"forum-menu fcom forum-menu-guest colored mt15\" onClick=fguesc('0','$t2','$pregg','$id')
                                  onClick=fguesc('0','$t2','$pregg','$id')><b>" . __('messages.nnext') . "</b>
                              </section>";
                          }

                    echo"</div>
                </section>";
              }
              if($g_insert=="on"){
                  $Vd_now = date('Y-m-d H:i:s');
                  $Imm = Auth::user()->Im;
                  $Prizm = Auth::user()->Priz;
                  $avatar = Auth::user()->avatar;
                   if($avatar=='0'){$avatar=7;}
                  $g_ins = DB::table('gcf')->
                  insert(['Num' => $id, 'Numg' => $Numm, 'Im' => $Imm, 'Priz' => $Prizm, 'Num_a' => $avatar, 'Vd' => $Vd_now]);
              }



            $Allb = DB::table('City_Admin2')->select('Num')->
            where('id', $id)->where('Page', 'Foto')->get();
            $Allbn = $Allb->count();
            if($Allbn>0){$publdiv="off";

              foreach ($Allb as $Alb) {
                  $Num = $Alb->Num;
                  $Allu = DB::table('users')->select('Im', 'Priz', 'avatar', 'l_visit', 'avy', 'avx')->
                  where('id', $Num)->where('aktiv', 1)->limit(1)->get();
                  $Allun = $Allu->count();
                  if($Allun>0){

                      foreach ($Allu as $Alu) {
                          $Im = $Alu->Im; $Priz = $Alu->Priz; $Num_a = $Alu->avatar; $l_visit = $Alu->l_visit;
                          $avy = $Alu->avy;
                          $avx = $Alu->avx;
                          $from=strtotime($l_visit);
                          $Md_is_online = date('Y-m-d H:i');
                          $to=strtotime($Md_is_online);
                          $razn=($to-$from)/60;
                          $online="";
                            if ($razn<=5){
                                $online="online";
                            }

                          if((int)$Num_a>10){}
                          else{$Num_a=7;}
                          $pref_page = __('messages.pref_page'); $ppref_page = $pref_page .="i";

                          $avae = generateUserIcon($Num_a, $Im, $Priz, "forum", $avx, $avy, $online);

                              $Alla = DB::table('users')->select('id')->
                              where('ratingfoto', '>', 0)->orderBy('ratingfoto','Desc')->get();
                              $nav = 1;
                              foreach ($Alla as $Ala) {
                                  $avt0 = $Ala->id;
                                  if($avt0==$Num){break;}
                                  $nav++;
                              }
                              $takes = __('messages.takes');
                              $place = __('messages.place');
                              $ppage = __('messages.pref_page');
                              $adm_panel_e = "";
                              if(Auth::user()) {
                                  $my_id =  Auth::user()->id;
                                  if($my_id==$Num){
                                      $adm_panel = __('messages.adm_panel');
                                      $adm_panel_e = "<br /><a href=/adm/$id>$adm_panel</a>";
                                  }
                              }
                              $seestatadmf_page=$ppage.="seestatadmf";

                          $nicn = "<section class=\"admcity-item\">
                            <a href=\"/$pref_page$Num\"><b>$Im $Priz</b></a>
                            <span>$takes <b><a href=/$seestatadmf_page/$nav>$nav $place</a></b></span>
                            <b>$adm_panel_e</b>
                        </section>";

                          if($publdiv=="off"){ $publdiv="on";
                              echo"<section class=\"fcom city-center-block centeredm mt15\">
                             <h3>" . __('messages.adm_page') . "</h3>
                             <ul class=\"non-list admcity\">";
                          }
                          echo"<li>$avae $nicn</li>";
                      }
                  }
              }
              if($publdiv=="on"){echo"</ul></section>";}
            }
        @endphp

        @if($admpass=="off")
            <section class="fcom city-center-block centeredm mt15">
                 <div id="be_admin">
                     <a href="##" onclick="be_admin('{{$id}}','Foto')" rel="noopener noreferrer"><h4>{{__('messages.be_admin')}}</h4></a>
                 </div>
            </section>
        @endif



        <section class="fcom city-center-block centeredm mt15">
            <h4>{{__('messages.sharing')}}:</h4>
            @php
                $wh_domen=$_SERVER["HTTP_HOST"];
                $sh_link = "https%3A%2F%2F$wh_domen%2F$domen%2Ffoto%2F$lan";
            @endphp
            <noindex id="social-madia">
                <a target="_blank" style="margin-top: -2px;" aria-label="{{__('messages.share-fb')}}" href="https://www.facebook.com/sharer.php?u={{$sh_link}}">
                    <svg id="facebook" width="39" height="39"><use href="/images/icons.svg#icon-facebook"></use></svg>
                </a>
                <a target="_blank" aria-label="{{__('messages.share-tg')}}" href="https://telegram.me/share/url?url={{$sh_link}}">
                    <svg id="telegram" width="36" height="36"><use href="/images/icons.svg#icon-telegram"></use></svg>
                </a>
                <a target="_blank" aria-label="{{__('messages.share-vb')}}" href="viber://forward?text={{$sh_link}}">
                    <svg id="viber" width="36" height="36"><use href="/images/icons.svg#icon-viber"></use></svg>
                </a>
                <a target="_blank" aria-label="{{__('messages.share-tt')}}" href="https://twitter.com/intent/tweet?url={{$sh_link}}">
                    <svg id="twitter" width="36" height="36"><use href="/images/icons.svg#icon-twitter"></use></svg>
                </a>
                <a target="_blank" aria-label="{{__('messages.share-wu')}}" href="https://api.whatsapp.com/send?text={{$sh_link}}">
                    <svg id="whatsapp" width="36" height="36"><use href="/images/icons.svg#icon-whatsapp"></use></svg>
                </a>

            </noindex>
        </section>

        <div style="display: none;" id="fc">{{$_SERVER['REQUEST_URI']}}</div>
        <div style="display: none;" id="rate">{{$rate}}</div>
        <div style="display: none;" id="id_page">{{$id}}</div>
        <div style="display: none;" id="rayc_page">{{$rayc}}</div>
        <div style="display: none;" id="obl_page">{{$obl}}</div>
    @endif
@endsection
