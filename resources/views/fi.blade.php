@extends('layouts.app')
@php

$album = str_ireplace("@s@l@", "/", $album);
$album = str_ireplace("@q@w@", "?", $album);
$lan = __('messages.lan');
global $iwindowonload;
$iwindowonload = "go";


$nd=0; $design = "all";  $Allbn=0;
if($namef && $namef !="0") {
    $Alln = DB::table('Fotop')->
    select('Num', 'Fd', 'w', 'h', 'Sh', 'Formf', 'album','avt','views','r_gol','r_kol','rh')->
    where('Namef', $namef)-> limit(1)-> get();
    $Allnn = $Alln->count();
    if($Allnn==0){$id="0"; $domen="0";}
    else{
        foreach ($Alln as $Aln) {
            $id=$Aln->Num;
            $Sh=$Aln->Sh;
            $Fd=$Aln->Fd;
			$w=$Aln->w;
			$h=$Aln->h;
            $Formf=$Aln->Formf;
            $album=$Aln->album;
            $avt = $Aln->avt;
            $views = $Aln->views;
            $r_gol = $Aln->r_gol;
            $r_kol = $Aln->r_kol;
            $rh = $Aln->rh;
        }
        $design = "alone";
        if (Auth::user()){

            $Alls = DB::table('Friends')->select('Num1', 'Num2')->
            where(function($query1) use ($id) {
                $query1->where('Num1', $id)
                      ->where('Argue', '=', 2);
            })->
            orWhere(function($query2) use ($id) {
                $query2->where('Num2', $id)
                      ->where('Argue', '=', 2);
            })->
            get();
                $fr_avt="";  $Numfr = "";
            foreach ($Alls as $All) { $Num1=$All->Num1; $Num2=$All->Num2;
             if($Num1==$id){$Numfr=$Num2;} else{$Numfr=$Num1; }
              $fr_avt.= " $Numfr";  }

            $my_id = Auth::user()->id; $my_id2 = "$my_id";
            $isfriend = strstr("$fr_avt", "$my_id2");
        } else {$isfriend = ""; $my_id = "999999999999999";}

        $Privatpass="stop";
        if($Sh==1){$Privatpass="go";}
         else{if($Sh==2 && Auth::user()){$Privatpass="go";}
          else{
            if($Sh==3 && ($id==$my_id || $isfriend != "")){ $Privatpass="go"; }
            else if($Sh==4&&$id==$my_id){$Privatpass="go";}
          }
         }
    if($Privatpass=="stop"){$id="0"; $domen="0";}
    }


}
if($domen && $domen !="0") {
    $Alls = DB::table('users')->
     select('id', 'domen', 'Im', 'Priz', 'Bat', 'avatar', 'Who', 'l_visit', 'avx', 'avy',
      'Wherer', 'idc', 'Adr', 'aktiv', 'rate', 'Md')->
       where('domen', $domen)-> limit(1)-> get();
}
else if($id && $id !="0") {
    $Alls = DB::table('users')->
     select('id', 'domen', 'Im', 'Priz', 'Bat', 'avatar', 'Who', 'l_visit',
      'Wherer', 'idc', 'Adr', 'aktiv', 'rate', 'Md')->
       where('Num', $id)-> limit(1)-> get();
}
else {$nd=0; $id="0"; $domen="0"; }
$online_e = "";
$online_class="";
$fill="#111";

if($id != "0" || $domen != "0"){
    foreach ($Alls as $All) {
        $id=$All->id; $domen=$All->domen; $Im=$All->Im; $Priz=$All->Priz; $Bat=$All->Bat; $Who=$All->Who; $avatar=$All->avatar;
        $Wherer=$All->Wherer; $idc=$All->idc; $Adr=$All->Adr; $rate=$All->rate; $Md=$All->Md; $aktiv=$All->aktiv;
		$l_visitm=$All->l_visit;
		$l_visit = substr($l_visitm, 0, 16);
		$from=strtotime($l_visit);
		$Md_is_online = date('Y-m-d H:i');
		$to=strtotime($Md_is_online);
		$razn=($to-$from)/60;
		if ($razn<=5){
			$online_class = "big-av-conteiner-online";
			$fill="#3B9947";
			$online_e = __('messages.online');
		}
		$nd++; $Num = $id;
    }
}
if($nd==0){
$title = __('messages.unknown_page');
$description = $title;
$keywords = $title;
$Im=""; $Priz=""; $avatar=""; $Bat=""; $l_visitm=""; $aktiv=0;
    $index_go = "noindex,follow";
}
else {

    $title0 = __('messages.Foto'); $title = $title0.=" - $Im $Priz";
    if($album){$title = "$album - $Im $Priz";}
		  if ($avatar>0){
			  $path0 = "/storage/avatar/$avatar.jpg";
			  $av_img0 = "<div class=\"av-conteiner scale $online_class\">
					<img id=av_img0 src=\"$path0\" width=\"100\" height=\"100\" alt=\"$title, $Who $online_e\">
				</div>";
		  }
		  else {
			  $av_img0="<svg class=\"av-shadow\" style=\"border-radius: 50%; fill:$fill;\"
				width=\"150\" height=\"150\" aria-label=\"$title, $Who $online_e\">
					<use href=\"/images/icons.svg#icon-username\"></use>
				</svg>";

		  }
    $admpass="off";
    if (Auth::user()){

        $Alls = DB::table('Friends')->select('Num1', 'Num2')->
        where(function($query1) use ($Num) {
            $query1->where('Num1', $Num)
                  ->where('Argue', '=', 2);
        })->
        orWhere(function($query2) use ($Num) {
            $query2->where('Num2', $Num)
                  ->where('Argue', '=', 2);
        })->
        get();
            $fr_avt="";  $Numfr = "";
        foreach ($Alls as $All) { $Num1=$All->Num1; $Num2=$All->Num2;
         if($Num1==$Num){$Numfr=$Num2;} else{$Numfr=$Num1; }
          $fr_avt.= " $Numfr";  }

        $my_id = Auth::user()->id; $my_id2 = "$my_id";
        $isfriend = strstr("$fr_avt", "$my_id2");
    } else {$isfriend = ""; $my_id = "999999999999999";}
    if($my_id == $id){ $admpass="ok";}

    $Alls = DB::table('Private')->select('Page', 'Forum',  'ipban')->
        where('Num', $id)->limit(1)->get();
            $pr=0;
        foreach ($Alls as $All) { $Sh_Page=$All->Page;
         $Forum=$All->Forum; $ipban=$All->ipban;
         $pr++; }
        if($pr==0) {$Sh_Page=1; $Forum=1; $ipban="";}

        $Privatpass="stop";
        if($Sh_Page==1 || !$Sh_Page){$Privatpass="go";}
         else{if($Sh_Page==2 && Auth::user()){$Privatpass="go";}
          else{
            if($Sh_Page==3 && ($id==$my_id || $isfriend != "")){ $Privatpass="go"; }
            else if($Sh_Page==4&&$Num==$my_id){$Privatpass="go";}
          }
         }

         if($aktiv != 1){$Privatpass="stop";}
         $ip = $_SERVER['REMOTE_ADDR'];
        if(strstr($ipban, $ip)!=""){$Privatpass="stop";}

        if($Privatpass=="go"){$index_go="index,follow";}
        if($Privatpass=="stop"){$index_go="noindex,follow";}

        $description = __('messages.fp_desc');
        $keywords3 = __('messages.fp_keyw');
        $keywords = "$Im $Priz, $keywords3";
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
    @elseif($Sh_Page==5)
        @php $unnp2 = __('messages.del_page'); @endphp
        <section id="hidpage" class="fcom0">
			<h4>{{  __('messages.del_page') }}</h4>
			<a href="javascript:history.go(-1)">{{  __('messages.unknown_page4') }}</a>
		</section>
    @elseif($Privatpass=="stop")
		<section id="hidpage" class="fcom0">
		    @php echo"$av_img0"; @endphp
             <b>{{$Im}} {{$Priz}}</b>
            {{ __('messages.hid_page') }}
		</section>
        @php $link = "spid$id";
            echo "<html><head><meta http-equiv='refresh' content='3; url=/$link'></head></html>"; @endphp
    @else

    @php
    $pref_page = __('messages.pref_page');
    $ppref_page = $pref_page .="i";
    $time_sec=time();

    $id = $id + 1; $id = $id - 1;
    if (is_int($id) != "true") { die("");}

    if($my_id==$id){$v_s=4;  $aheight = 235; }
    else{
        if($my_id == "999999999999999"){$v_s=1;}
        else if($my_id>0){$v_s=2;
            if($isfriend!=""){$v_s=3;}
        }
    }
    @endphp

    <section class="ph-menu-container">
        <ul class="menu-list menu-list-photo">
            <li class="fcom menu-item">
                <a href="/{{$domen}}/{{ __('messages.lan') }}/" >
                    <h1>{{ $Im }} {{$Priz}} </h1>
                </a>
            </li>
            <li class="fcom menu-item">
                <a href="##" onClick="max_albp('{{$id}}','date','{{$domen}}')" rel="noopener noreferrer">
                    <h2>{{ __('messages.albumsf') }} </h2>
                </a>
            </li>
            <li class="fcom menu-item">
                <a href="##" onClick="comment_p('{{$id}}','0','1')" rel="noopener noreferrer">
                    <h3>{{ __('messages.Comment') }} </h3>
                </a>
            </li>
        </ul>
        @auth
            @if ($my_id==$id)
                <script type="text/javascript">
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
                                    var shfoto = document.getElementById("shfoto").value;
                                    formData.append('alb', alb);
                                    formData.append('shfoto', shfoto);

                                    $.ajax({
                                        type:'POST',
                                        url: "{{ url('load_fotop')}}",
                                        data: formData,
                                        cache:false,
                                        contentType: false,
                                        processData: false,
                                        success:function(data){
                                            document.getElementById("load_fotop").innerHTML=data;
                                            document.getElementById("load_on").style.display = 'none';
                                        }
                                    });
                                }
                            }
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

                <form class="fcom0 margin-top" id='fsearch' method="POST" action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <label for="files" class="custom-file-input">{{ __('messages.ch-photo') }}</label>
                    <input type="file" id="files" name="files[]" class="un-display" onchange="displayFileName(this)" accept="image/jpeg" placeholder="Choose files" multiple>

                    <span class="file-name margin-file" id="file-name"></span>
                    <div id="load_hid" class="margin-top">
                        {{ __('messages.Album') }}: <input type=text id=album0 size=26 maxlength = 45 value="{{$alb_e}}"><br />
                        {{ __('messages.swown') }}: <SELECT name=shfoto id=shfoto>
                            <OPTION value="1" >{{ __('messages.Pr_show1') }}</OPTION>
                            <OPTION value="2" >{{ __('messages.Pr_show2') }}</OPTION>
                            <OPTION value="3" >{{ __('messages.Pr_show3') }}</OPTION>
                            <OPTION value="4" >{{ __('messages.Pr_show4') }}</OPTION>
                        </SELECT>
                    </div>
                    <div id="load_on">
                        {{ __('messages.Loading_wait') }}<br />
                        <img SRC="/images/upload.gif"><br />
                        {{ __('messages.Loading_wait2') }}
                    </div>
                    <button type="submit" class="custom-file-input ml10" id="submit">{{ __('messages.add_foto') }}</button>
                    <div id="load_fotop" ></div>
                </form>
            @endif
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
        <div class="centered" id=foto_in>  </div>

    </section>


    @if ($design == "alone")
        <section  class="centered">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                    crossorigin="anonymous"></script>
            <!-- для людей -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-7495053896041990"
                 data-ad-slot="4081061255"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </section>
        @php
            $memory_contents = Storage::disk('public')->get('delseeffile.txt');
            $pc="p";
            if (strstr($memory_contents,"$pc$namef")==""){
                $memory_contents.="$pc$namef";
                Storage::disk('public')->put('delseeffile.txt', $memory_contents);
                DB::table('Fotop')->where('Namef', $namef)->increment('views', 1);
            }
            $namef=$namef+1; $namef=$namef-1;
            if(is_int($namef)!="true"){die("");}

                 $M6nf=$Fd; $M6nf0=$M6nf; $M7nf=$Formf; $albumnext=$album;

                $monm = substr($Fd, 5, 2); $yem = substr($M6nf, 0, 4);

            if ((int)$monm<10){$monmf = substr($M6nf, 6, 1);}
            else{$monmf=$monm;}
            if((int)$yem<=2007){$yem = "2005-2007"; $monmf="";}
                        $katalogbmain = "Fotop/$yem$monmf/b$namef.$Formf";
                        $katalogmain = "Fotop/$yem$monmf/$namef.$Formf";
                        if (Storage::disk('public')->exists($katalogbmain)) {
                            $katalog_main=Storage::disk('public')->url($katalogbmain);
                        }
                        else{
                            $katalog_main=Storage::disk('public')->url($katalogmain);
                        }


           $abf_out = view('inc.abfp', ['id' => $id, 'Namef' => $namef, 'admpass' => $admpass,
            'domen' => $domen, 'M6' => $Fd, 'M7' => $Formf, 'w' => $w, 'h' => $h, 'avt' => $avt,  'alb' => $album,
            'views' => $views, 'r_gol' => $r_gol, 'r_kol' => $r_kol, 'rh' => $rh, 'design' => 'alone', 'alb_des' => 'default']);

            $pref_l = __('messages.pref_page');
            $fpref_l = $pref_l .="ni";

            $f1=1;
            $groupf = array('Namef','Fd','Formf');
            $Alln = DB::table('Fotop')->
            select('Namef', 'Fd', 'Formf')->
             where('Num', $id)->
             where('Sh', '<=', $v_s)->
             where('album', $album)->
              orderBy('Fd', 'desc')->get();
            $nal = $Alln->count();
            foreach ($Alln as $Aln) {
                $groupf['Namef'][$f1]=$Aln->Namef;  $groupf['Fd'][$f1]=$Aln->Fd; $groupf['Formf'][$f1]=$Aln->Formf;
                if($groupf['Namef'][$f1]==$namef){ $f_is=$f1;}

                $f1++;
            }

            $f_isback=$f_is-1;
            $f_isgo=$f_is+1;


            $Namef_first=$groupf['Namef'][1];

            if($f_isback>0){
                $namef=$groupf['Namef'][$f_isback]; $M6nf=$groupf['Fd'][$f_isback]; $M7nf=$groupf['Formf'][$f_isback];
                $monm = substr($M6nf, 5, 2); $yem = substr($M6nf, 0, 4);
                if ((int)$monm<10){$monmf = substr($M6nf, 6, 1);}
                else{$monmf=$monm;}
                if((int)$yem<=2007){$yem = "2005-2007"; $monmf="";}
                    $katalogb = "Fotop/$yem$monmf/b$namef.$M7nf";
                    $katalog = "Fotop/$yem$monmf/$namef.$M7nf";
                if (Storage::disk('public')->exists($katalogb)) {
                    $katalogfnf=Storage::disk('public')->url($katalogb);
                }
                else{$katalogfnf=Storage::disk('public')->url($katalog);}
                $lb1="<img src=$katalogfnf>";
                $back="onClick=\"document.location='$fpref_l$namef'\" style=\"cursor: pointer;\""; $backlf="$fpref_l$namef";
            }else{$lb1="";}

            if($f_isgo<=$nal && $f_isgo>0){
                $namef=$groupf['Namef'][$f_isgo]; $M6nf=$groupf['Fd'][$f_isgo]; $M7nf=$groupf['Formf'][$f_isgo];
                $monm = substr($M6nf, 5, 2); $yem = substr($M6nf, 0, 4);
                if ((int)$monm<10){$monmf = substr($M6nf, 6, 1);}
                else{$monmf=$monm;}
                if((int)$yem<=2007){$yem = "2005-2007"; $monmf="";}
                    $katalogb = "Fotop/$yem$monmf/b$namef.$M7nf";
                    $katalog = "Fotop/$yem$monmf/$namef.$M7nf";
                    if (Storage::disk('public')->exists($katalogb)) {
                        $katalogfnf=Storage::disk('public')->url($katalogb);
                    }
                    else{$katalogfnf=Storage::disk('public')->url($katalog);}
                    $lg1="<img src=$katalogfnf>";
                $go="onClick=\"document.location='$fpref_l$namef'\" style=\"cursor: pointer;\""; $golf="$fpref_l$namef";
            } else{$lg1="";}

                if($f_isgo<=$nal && $f_isgo>0){} else{$namef=$Namef_first;}
                $goisfoto="$fpref_l$namef";

            $nextl="$lg1 $lb1";
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

        $nextl = "";

        $Allb = DB::table('Fotop')->select('Namef', 'Fd', 'Formf', 'w', 'h', 'avt', 'album', 'views', 'r_gol', 'r_kol', 'rh')
            ->where('Num', $id)
            ->when($album, function ($query) use ($album) {
                return $query->where('album', $album);
            })
            ->where('Sh', '<=', $v_s)
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
                    <!-- для людей -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-7495053896041990"
                         data-ad-slot="4081061255"
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
                $M6 = $Alb->Fd;
                $M7 = $Alb->Formf;
				$w = $Alb->w;
				$h = $Alb->h;
                $avt = $Alb->avt;
                $alb = $Alb->album;
                $views = $Alb->views;
                $r_gol = $Alb->r_gol;
                $r_kol = $Alb->r_kol;
                $rh = $Alb->rh;

                echo view('inc.abfp', ['id' => $id, 'Namef' => $Namef, 'admpass' => $admpass,
                    'domen' => $domen,
                    'M6' => $M6, 'M7' => $M7, 'w' => $w, 'h' => $h, 'avt' => $avt, 'alb' => $alb,
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
                    <!-- для людей -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-7495053896041990"
                         data-ad-slot="4081061255"
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
                $next_e = __('messages.nnext');
                $next_div = "nextf_div2";
                @endphp
                    <section id={{$next_div}} class="fcombold mt15 centered" onMouseOver=fotop('{{$id}}','{{$domen}}','{{$Namef_a}}','2') >
                    <a href=## onclick=fotop('{{$id}}','{{$domen}}','{{$Namef_a}}','2') rel="noopener noreferrer">
                        <h3>{{$next_e}} {{$alb_e}}</h3>
                    </a>
            </section>
            @endif

            </section>
        @endif



        @php
        $g_insert="off";
        $Allg = DB::table('gpf')->select('Numg', 'Im', 'Priz', 'Num_a', 'Vd')->
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
            if($Numm!=$id && $Numm>0 && $nguests==1){

                $filename0 = "storage/last_visit/$id.txt";
                $whattoread0 = @fopen($filename0, "r");
                $memory_contents0 = fread($whattoread0, filesize($filename0)); 		 fclose($whattoread0);
                $notices = explode("#!:*&", $memory_contents0);
                $lan_user=$notices[4]; $page_user=$notices[5];

                $time_sec=time();
                $time_file0=filemtime($filename0);
                $t=$time_sec-$time_file0;
                if ($t<=50000){
                $sexm = Auth::user()->sex;
                $Num_am = Auth::user()->avatar;
                if($Num_am<10){$Num_am=7;}
                $Imm = Auth::user()->Im;
                $Prizm = Auth::user()->Priz;
                if($sexm==1){$sexm_e1="зайшов"; $sexm_e2="посетил";} else if($sexm==2){$sexm_e1="зайшла"; $sexm_e2="посетила";} else{$sexm_e1="зайшов (ла)"; $sexm_e2="посетил (ла)";}

                    if($lan_user=="ua"){
                        $r_else="<table><tr><td valign=top width=160>
                            <b><font color=white>Новий гість</font></b><br>
                            <a href=/i$Numm>
                            <img  style=\"margin: 2px 8px 8px 0px; \" border=0 SRC=/storage/avatar/s$Num_am.jpg align=left>
                            </a><a href=/i$Numm><font color=white>$Imm $Prizm</font></a><br>
                            $sexm_e1 на сторінку <a href=/fi$id><font color=white>Ваших фото</font></a> і дивиться їх :)
                        </td></tr></table>";
                    }
                    if($lan_user=="ru"){
                        $r_else="<table><tr><td valign=top width=160>
                            <b><font color=white>Новый гость</font></b><br>
                            <a href=/ri$Numm>
                            <img style=\"margin: 2px 8px 8px 0px; \" border=0 SRC=/storage/avatar/s$Num_am.jpg align=left>
                            </a><a href=/ri$Numm><font color=white>$Imm $Prizm</font></a><br>
                            $sexm_e2 страницу <a href=/rfi$id><font color=white>Ваших фото</font></a> и смотрит их :)
                        </td></tr></table>";
                    }
                    if($lan_user=="en"){
                        $r_else="<table><tr><td valign=top width=160>
                            <b><font color=white>New Guest</font></b><br>
                            <a href=/ei$Numm>
                            <img style=\"margin: 2px 8px 8px 0px; \" border=0 SRC=/storage/avatar/s$Num_am.jpg align=left>
                            </a><a href=/ei$Numm><font color=white>$Imm $Prizm</font></a><br>
                            visited <a href=/efi$id><font color=white>Your photos</font></a> and watch them :)
                        </td></tr></table>";
                    }

                    \Illuminate\Support\Facades\Redis::lpush("notice:$id", $r_else);

                }
            }
        if($Allgn==0 && $Numm>0 && $nguests==1 && $Numm != $id){$g_insert="on";}


        if($Allgn>0){

            $guests = __('messages.guests_page');
            $online = __('messages.online');
            $delete = __('messages.delete');
            $lan = App::currentLocale();

            echo"<section class=\"fcom0 city-center-block centeredm mt15\" >
                <h3>$guests</h3>
                <ul id=guests>";
                $nrow=1; $ng=1;
                foreach ($Allg as $Alg) {
                    if($ng<11){
                        $avtc = $Alg->Numg; $Img = $Alg->Im; $Prizg = $Alg->Priz;
                        $Num_a = $Alg->Num_a; if($Num_a>0){} else{$Num_a=7;} $Vd = $Alg->Vd;
                        if($ng==1 && $Numm>0 && $nguests==1 && $Numm!=$id){
                            if($avtc!=$Numm ){$g_insert="on";}
                            else{
                                $Num_a = Auth::user()->avatar;
                                if($Num_a=='0' || !$Num_a ){$Num_a=7;}
                                $Vd_now = date('Y-m-d H:i:s');
                                $aff_upd = DB::table('gpf')
                                ->where('Vd', $Vd)
                                ->where('Num', $id)
                                ->where('Numg', $Numm)
                                ->update(['Vd' => $Vd_now, 'Num_a' => $Num_a]);
                                if($aff_upd){$Vd = $Vd_now;}
                            }
                        }

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

                        if($Numm==$id||$Numm==$avtc){
                            echo"$Vd_e <a onclick=fguesp_del('$avtc','$Vds','$t3','$id') rel=\"noopener noreferrer\">$delete</a>";
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
                        $g_ins = DB::table('gpf')->
                        insert(['Num' => $id, 'Numg' => $Numm, 'Im' => $Imm, 'Priz' => $Prizm, 'Num_a' => $avatar, 'Vd' => $Vd_now]);
                        $g_insert="off";
                    }

                    if($ng==12){
                        $t1="qwertyuiopasdfghjklzxcvbnm"; $t2="";
                        for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t2.="$t1[$z]";}
                        $pregg=0;
                        if($g_ins){$pregg=1;}
                        echo "
                        <section id=$t2 class=\"forum-menu fcom forum-menu-guest colored mt15\" onClick=fguesp('0','$t2','$pregg','$id')>
                            <b>" . __('messages.nnext') . "</b>
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
            $g_ins = DB::table('gpf')->
            insert(['Num' => $id, 'Numg' => $Numm, 'Im' => $Imm, 'Priz' => $Prizm, 'Num_a' => $avatar, 'Vd' => $Vd_now]);
        }
        @endphp
    @endif

    @if($Allbn>0 || $design == "alone")

        <section class="fcom city-center-block centeredm mt15" >
            <h4>{{__('messages.sharing')}}:</h4>
            @php
                $lan = App::currentLocale();
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

    @endif



    <section class="un-display">
        <div id="fc">{{$_SERVER['REQUEST_URI']}}</div>
        <div id="rate">{{$rate}}</div>
        <div id="id_page">{{$id}}</div>
        <div rel="nofollow"> @php  echo"$nextl"; @endphp</div>
    </section>
    @endif



    <br /><br />
@endsection
