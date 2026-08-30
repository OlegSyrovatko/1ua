@extends('layouts.app')
@section('title_block'){{ __('messages.mtit') }}@endsection
@section('content')
    <script src="{{ "/js/i.js" }}" defer></script>
    <script src="{{ "/js/allcities2.js" }}" defer></script>
    @php
 //   phpinfo();
// print_r(get_loaded_extensions());


if(Auth::user()) {

       $ggg =  Auth::user()->id;
    if($ggg == "72372396"){

        $obl=5;
        $time_h="";
        $selected_cities_h = "";
        $true_link = 0;
            $Allq = DB::table('Allcities')
                ->select('id', 'rayc', 'City', 'City2', 'City_m', 'City_o', 'City_r', 'City_d', 'rod', 'dat', 'vin', 'tvor', 'predl')
                ->where('obl', $obl)
                ->where('id', '!=' , 147651) // 25
                ->where('id', '!=' , 31900) //20
                ->where('id', '!=' , 145188) //12
                ->where('id', '!=' , 145329) //12
                ->where('id', '!=' , 145217) //12
                ->where('id', '!=' , 150714) //10
                ->where('id', '!=' , 150665) //10
                ->where('id', '!=' , 437) //10
                ->where('id', '!=' , 150712) //10
                ->where('id', '!=' , 442) //10
                ->where('id', '!=' , 142298) //8
                ->where('id', '!=' , 141982) //8
                ->where('id', '!=' , 144137) // 5
                ->where('id', '!=' , 25613) // 14
                ->where('id', '!=' , 78500) // 16
                ->where('id', '!=' , 33559) // для всіх


                ->where('vol_karta', '>' , 7000)
                ->get();
            $Allcs = $Allq->count();
            echo "Всіх міст $Allcs <br />";
            $row=0;
            foreach ($Allq as $Alq) {
                $id[$row] = $Alq->id; $rayc[$row] = $Alq->rayc; $City[$row] = $Alq->City; $City2[$row] = $Alq->City2;
                $City_m[$row] = $Alq->City_m; $City_o[$row] = $Alq->City_o; $City_r[$row] = $Alq->City_r; $City_d[$row] = $Alq->City_d;
                $rod[$row] = $Alq->rod; $dat[$row] = $Alq->dat; $vin[$row] = $Alq->vin; $tvor[$row] = $Alq->tvor; $predl[$row] = $Alq->predl;
                $row++;
            }

            $filename = "storage/obl_news/$obl.html";
            if (filesize($filename) > 0) {
                $whattoread = @fopen($filename, "r");
                $content = fread($whattoread, filesize($filename));
                fclose($whattoread);

            $start = "<article>";
            $position = strpos($content, $start); $content = substr($content, $position+9);

            $finish = "</article>";
            $position = strpos($content, $finish); $content = substr($content, 0, $position);

            $pagec = explode("<section class=\"im\">", $content);
            $count_news = substr_count($content, "<section class=\"im\">");
            echo"count_news $count_news <br><br>";

            for($n=1; $n<=$count_news; $n++){
                $contentpol=$pagec[$n];
                if($n!=4){
                $start = "<time class="; $position = strpos($contentpol, $start); $time = substr($contentpol, $position+17);
                $start = ">"; $position = strpos($time, $start); $time = substr($time, $position+1);
                $finish = "</time>"; $position = strpos($time, $finish); $time = substr($time, 0, $position);
                echo"time $time<br />";
                if(mb_strstr($time,":")==""){break;}
                // if($time_h != "" && $time_h!=$time){break;}
                // $time_h=$time;

                $start = "<a href="; $position = strpos($contentpol, $start); $contentpol = substr($contentpol, $position+9); $contentpol2=$contentpol;
                $finish = "\" class"; $position = strpos($contentpol, $finish); $link = substr($contentpol, 0, $position);

                $start = "_blank"; $position = strpos($contentpol2, $start); $contentpol2 = substr($contentpol2, $position+9);
                $start = ">"; $position = strpos($contentpol2, $start); $contentpol2 = substr($contentpol2, $position+1);
                $finish = "</a>"; $position = strpos($contentpol2, $finish); $news_text = substr($contentpol2, 0, $position);
                echo"link $link news_text $news_text <br />";
                if($true_link==0){
                    $Md = date('Y-m-d');
                    $Allad = DB::table('local_news')->select('obl')->
                    where('obl', $obl)->
                    where('link', $link)->
                    limit(1)->get();
                    $Alladn = $Allad->count();
                    if($Alladn == 0){
                        DB::table('local_news')
                        ->insert(['obl' => $obl, 'date' => $Md, 'link' => $link]);
                    }
                    else{break;}
                }
                $true_link++;

                for($nn=0; $nn<$Allcs; $nn++){

                    $rec = "false";
                    if(mb_strlen($City[$nn])>1){if(mb_strstr($news_text,$City[$nn])!=""){$rec = "true";}}
                    if(mb_strlen($City2[$nn])>1){if(mb_strstr($news_text,$City2[$nn])!=""){$rec = "true";}}
                    if(mb_strlen($City_m[$nn])>1){if(mb_strstr($news_text,$City_m[$nn])!=""){$rec = "true";}}
                    if(mb_strlen($City_o[$nn])>1){if(mb_strstr($news_text,$City_o[$nn])!=""){$rec = "true";}}
                    if(mb_strlen($City_r[$nn])>1){if(mb_strstr($news_text,$City_r[$nn])!=""){$rec = "true";}}
                    if(mb_strlen($City_d[$nn])>1){if(mb_strstr($news_text,$City_d[$nn])!=""){$rec = "true";}}
                    if(mb_strlen($rod[$nn])>1){if(mb_strstr($news_text,$rod[$nn])!=""){$rec = "true";}}
                    if(mb_strlen($dat[$nn])>1){if(mb_strstr($news_text,$dat[$nn])!=""){$rec = "true";}}
                    if(mb_strlen($vin[$nn])>1){if(mb_strstr($news_text,$vin[$nn])!=""){$rec = "true";}}
                    if(mb_strlen($tvor[$nn])>1){if(mb_strstr($news_text,$tvor[$nn])!=""){$rec = "true";}}
                    if(mb_strlen($predl[$nn])>1){if(mb_strstr($news_text,$predl[$nn])!=""){$rec = "true";}}

                    if($obl==1){
                        if(mb_strstr($news_text,"Крым")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Крим")!=""){$rec = "false";}
                    }
                    if($obl==2){
                        if(mb_strstr($news_text,"Волин")!=""){$rec = "false";}
                    }
                    if($obl==3){
                        if(mb_strstr($news_text,"Винничина")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Винницк")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Вінницьк")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Вінничина")!=""){$rec = "false";}
                    }
                    if($obl==4){
                        if(mb_strstr($news_text,"Днепров")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Дніпров")!=""){$rec = "false";}
                    }
                    if($obl==5){
                        if(mb_strstr($news_text,"Донецкая")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Донетч")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Донецька")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Донечч")!=""){$rec = "false";}
                    }
                    if($obl==6){
                        if(mb_strstr($news_text,"Житомирс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Житомирщ")!=""){$rec = "false";}
                    }
                    if($obl==7){
                        if(mb_strstr($news_text,"Закарпа")!=""){$rec = "false";}
                    }
                    if($obl==8){
                        if(mb_strstr($news_text,"Запорожс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Запоріз")!=""){$rec = "false";}
                    }
                    if($obl==9){

                    }
                    if($obl==10){
                        if(mb_strstr($news_text,"Киевс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Киевщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Київс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Київщ")!=""){$rec = "false";}
                    }
                    if($obl==11){

                    }
                    if($obl==12){
                        if(mb_strstr($news_text,"Львовс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Львовщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Львівс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Львівщ")!=""){$rec = "false";}
                    }
                    if($obl==13){
                        if(mb_strstr($news_text,"Луганщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Луганска")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Луганська")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Луганщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Луганcьку")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Луганску")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Луганcку")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Луганcько")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Луганcко")!=""){$rec = "false";}
                    }
                    if($obl==14){
                        if(mb_strstr($news_text,"Николаевс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Николаевщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Миколаївс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Миколаївщ")!=""){$rec = "false";}
                    }
                    if($obl==15){
                        if(mb_strstr($news_text,"Одеск")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Одесщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Одесь")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Одещ")!=""){$rec = "false";}
                    }
                    if($obl==16){
                        if(mb_strstr($news_text,"Полтавс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Полтавщ")!=""){$rec = "false";}
                    }
                    if($obl==17){
                        if(mb_strstr($news_text,"Ровнен")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Рівнен")!=""){$rec = "false";}
                    }
                    if($obl==18){
                        if(mb_strstr($news_text,"Сумс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Сумщ")!=""){$rec = "false";}
                    }
                    if($obl==19){
                        if(mb_strstr($news_text,"Тернопольс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Тернопольщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Тернопільс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Тернопільщ")!=""){$rec = "false";}
                    }
                    if($obl==20){
                        if(mb_strstr($news_text,"Хмельнич")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Хмельницка")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Хмельнич")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Хмельницька")!=""){$rec = "false";}
                    }
                    if($obl==21){
                        if(mb_strstr($news_text,"Харьковщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Харьковс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Харківщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Харківс")!=""){$rec = "false";}
                    }
                    if($obl==22){
                        if(mb_strstr($news_text,"Херсонщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Херсонс")!=""){$rec = "false";}
                    }
                    if($obl==23){
                        if(mb_strstr($news_text,"Черніве")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Чернови")!=""){$rec = "false";}
                    }
                    if($obl==24){
                        if(mb_strstr($news_text,"Черкащ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Черкась")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Черкасск")!=""){$rec = "false";}
                    }
                    if($obl==25){
                        if(mb_strstr($news_text,"Чернігівщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Черниговщ")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Черниговс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Чернігівс")!=""){$rec = "false";}
                        if(mb_strstr($news_text,"Десн")!=""){$rec = "false";}
                    }


                    if($rec == "true")
                    {
                        if(mb_strstr($selected_cities_h,"$id[$nn]")==""){
                            $selected_cities_h .="#$id[$nn]";
                        }
                        $idn=$id[$nn];
                        $fff = $rayc[$nn];
                        $raycc[$idn][$n] = $rayc[$nn];
                        $selected_news[$idn][$n] = "<a href=$link target=_blank>$news_text</a><br /> ";
                        $selected_news_mail[$idn][$n] = "$news_text<br /> ";
                    }
                }}
            }
            $pagec = explode("#", $selected_cities_h);
            $count_ids = substr_count($selected_cities_h, "#");
            echo"<br><br>selected_cities_h $selected_cities_h
            <br><br>count_ids $count_ids <br><br>";

            for($n=1; $n<=$count_ids; $n++){
                $idn=$pagec[$n];

                echo"<br><br> idn $idn<br> ";
                $aa = $selected_news[$idn];
                $bb = $selected_news_mail[$idn];
                $cc = $raycc[$idn];

                $na = 1; $nb = 1; $nc = 1;
                $new_text = "";
                $new_text_mail = "";
                $shut_tag = "off";
                foreach ($aa as $row) {
                    if($na==8){
                        $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}
	                    $new_text.= "<div id=\"$t3\" style=\"display: none;\">";
	                    $shut_tag = "on";
	                }
	                $new_text.= "$row<br>";
	                $na++;
                }
                foreach ($bb as $row) {
	                if($nb<=7){
	                    $new_text_mail.= "$row ";
	                }
	                $nb++;
                }
                foreach ($cc as $row) {
	                $rayc = $row;
                }
                if($shut_tag == "on"){
                    $t1="qwertyuiopasdfg"; $t4=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t4.="$t1[$z]";}
                    $new_text.= "</div><div id=\"$t4\"> <a onclick=mem_arguem('$t3','$t4')>читати далі...</a></div>";

                }
                $new_text = "<noindex>$new_text</noindex>";
                echo"new_text $new_text<br><br> new_text_mail $new_text_mail ";
                $Md = date('Y-m-d-H-i-s');
                DB::table('Memory')->insert([
                    'id' => $idn, 'obl' => $obl, 'ray' => $rayc, 'Aboutec' => $new_text, 'Md' => $Md
                ]); //

                DB::table('News')->insert([
                    'act' => "$obl", 'obl' => "$obl", 'ualine' => $new_text, 'ruline' => $new_text, 'enline' => $new_text, 'Nd' => $Md
                ]);

            }



        }
/*
        $Allus = DB::table('users')->select('Num')->
        whereNull('id')->
        limit(500000)->
        get();

        foreach ($Allus as $Allu) {
            $Num = $Allu->Num;


            $affected = DB::table('users')
                ->where('Num', $Num)
                ->update(
                    ['id' => $Num]);
        }

*/


/*

            $cookie = "";
            function curl($url, $cookie=false, $headers=false, $post=false)
            {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, $headers);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt ($ch, CURLOPT_COOKIE, $cookie);
                curl_setopt($ch, CURLOPT_PROXY, '45.82.139.34:80');
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
                curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1');
                if ($post)
                {
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                }
                $response = curl_exec ($ch);
                curl_close($ch);
                return $response;
            }
            // $cookie="user=sirov%40ukr.net;passw=sirolp";
            $cookie="__cf_bm=X0Cl5bsaCNzzRPjJJ6gEN0ofM6i2LmccqCP.sHRbB0s-1647118807-0-AV/7rt4qMJWleZj3q5cn4QMDUaFfz/RBfSkfxjdbD96eHV2iUIEyDUxheGqySqsHpXUtwSS7xAMrCKXgqed5TGA=;lang=uk;pcity=303016980;scr=9;sfr=9;snr=9;uid=Cj1tBGItCddeqCSFBsxWAg==;un_lang=ua;un_news_region=9";

            $content = curl("https://ukr.net/",$cookie);
            // $content = curl("https://1ua.com.ua/",$cookie);
            echo"ввв $content<br /><br />";
*/


        // !!!!!!!!!!!!!!!!!!!!!розкоментувати після перенесення залишків  каталога last_visit і запустити один раз!!!!!!!!!!!!!!!!!!!!!!!
/*
            $Allu = DB::table('users')->select('Num', 'Im','Priz','avatar')->
             get();
            foreach ($Allu as $Alu) {
                $id=$Alu->Num; $Imu=$Alu->Im; $Prizu=$Alu->Priz; $avataru=$Alu->avatar; if($avataru<10){$avataru=7;}

                  $filename = "storage/last_visit/$id.txt";
                 if (file_exists($filename) && filesize($filename) > 0) {

                        $whattoread = @fopen($filename, "r");
                        $file_contents = fread($whattoread, filesize($filename)); fclose($whattoread);

                         $pageq = explode("#!:*&", $file_contents);

                        if(isset($pageq[4])){$lanu=$pageq[4]; } else {$lanu="ua";}
                        if(isset($pageq[5])){$pageu=$pageq[5]; } else {$pageu="";}

                } else {$lanu="ua"; $pageu=""; }
                       // echo" $id $Imu $Prizu $avataru $lanu $pageu<br />";

                 $filename2 = "storage/last_visit2/$id.txt";
                 if (file_exists($filename2)) {}
                 else{
                     $newfile = @fopen($filename2, "a");
                     @fwrite($newfile, "#!:*&$Imu#!:*&$Prizu#!:*&$avataru#!:*&$lanu#!:*&$pageu");
                     fclose($newfile);

                 }
            }
*/
    }
}


    @endphp




<div  align = center>
<div class="centermain" style="display: table; text-align: center;">
    <div class="layermain">

        <table style="width:100%; max-width: 445px;"><tr><td class=fcom0 align=center width="445">
        <script>
        function stat(id,purp) {

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
            });
            var formData = {
                id:id, purp:purp
            };
            $.ajax({
                type: 'POST',
                url: '/stat',
                data: formData,
                cache: false,
                success:function(data){
                    document.getElementById("stat").innerHTML=data;
                }
            });
        }
        </script>
		@php



        $fff = ""; $All_ratef = 0; $All_ratem = 0;
        $Allb = DB::table('stat')->select('id','perc_f','perc_m')->
        where('id', '<', '26')->orderBy('perc_f','desc')->limit(25)->get();
        $All_rate = 0;
        $ntbl=0;
        foreach ($Allb as $All) {
            $id = $All->id; $perc_f = $All->perc_f; $perc_m = $All->perc_m;
            $All_ratef = $All_ratef+$perc_f;
            $All_ratem = $All_ratem+$perc_m;

            $oi = "messages.ooo$id"; $obl =__($oi); $link = "<a onclick=stat('$id','memory')>$obl </a>";
            if($ntbl==0){$fff .="<tr>";}
            $fff .="<td><div style='margin: 5px 15px 5px 15px;'>$link $perc_f% </div></td>";
            $ntbl++;
            if($ntbl==2){$fff .="</tr>"; $ntbl=0;}

        }

        $All_ratef = round($All_ratef/25);
        $All_ratem = round($All_ratem/25);
        $Photos = __('messages.Foto');
        $Memorys = __('messages.records');
        $our_purp = __('messages.our_purp');
        $all_cities = __('messages.all_cities');
        $pref_page = __('messages.pref_page');
        $pref_page2 = $pref_page.="searc";
        echo "
        <br /><h1>$our_purp</h1>
        <h4><a href=/$pref_page2>$all_cities</a></h4><br />
        <br /><div id=stat>
        <table><tr><td width=150 height=23 class=fcom valign=center align=center onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
        <b>$Photos $All_ratef%</b>
        </td>
        <td class=\"fcomblue\" width=150>
                            <ul class=\"intop\"><li><a onclick=stat('0','memory')> $Memorys $All_ratem%</a></li></ul>
                        </td></tr>
        </table><br />";
        echo"<table>$fff</table></div>";


		@endphp


            @guest
            @else

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
                                var id = 0;

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

            </script>



            <br />
                        <div class=hidblokwide> <div style='margin: 5px 15px 5px 15px;'>{{__('messages.do_fotos')}}</div>
				<table><tr><td align=right width = 1180>
					<table><tr><td>
						<table><tr><td width=5></td><td align=right>
							<form id='search' method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
								@csrf
								<table>
									<tr><td>
										</td><td>
											<input type="file" name="files[]"  style="width: 90%" accept="image/jpeg" id="files" placeholder="Choose files" multiple  onchange=load_hid.style.display='block';>
										</td><td>
											<button type="submit" class="fcomblue" id="submit"><ul class="intopbig"><li><a>{{ __('messages.add_foto') }}</a></li></ul></button>

										</td></tr>
								</table>
							</form>
							<div id="load_hid" style="display: none;">
								{{ __('messages.Album') }}:<input type=text id=album0 size=23 maxlength = 45 value=""><br />
								{{ __('messages.adr_shot') }}:<input type=text id=Adrf0 size=23 maxlength = 50><br />
								{{ __('messages.date_shot') }}:<input type=text id=Datef0 size=23 maxlength = 23><br />
							</div>

							<div id="load_on" style="display: none;">
								<table><tr><td align=right width = 400>
											{{ __('messages.Loading_wait') }}<br />
											<img SRC="/images/upload.gif"><br />
											{{ __('messages.Loading_wait2') }}
										</td></tr></table>
								<br />
							</div>

						</td><td width=5></td></tr></table>
					</td></tr></table>
					<div id="load_foto"  style=" margin: 8px 8px 8px 8px;"></div>
				</td></tr></table>
			</div>



            @endguest


        <br />
        </td></tr></table>

        <table style="width:100%; max-width: 445px;"><tr><td class=fcom0 align=center width="445">

            @php

            $pref_page = __('messages.pref_page');
            $of_users = __('messages.of_users');
            $pref_page_inf = $pref_page.="infp";
            $pref_page = __('messages.pref_page');
            $pref_page_sear = $pref_page.="searc";
            $pref_page = __('messages.pref_page');
            $pref_page_i = $pref_page.="i";
            $of_Cityvil = __('messages.of_Cityvil');
            $join_us = __('messages.join_us');
            $lan = __('messages.lan');
            $filename = "storage/allstat.txt";
            $whattoread = @fopen($filename, "r");
            $file_contents = fread($whattoread, filesize($filename)); fclose($whattoread);

            $reg = strstr($file_contents,"reg");
            list($reg) = sscanf($reg, "reg%d");
            $Allc = strstr($file_contents,"Allc");
            list($Allc) = sscanf($Allc, "Allc%d");

            $we_up = __('messages.we_up');
            echo"<br /><h2>$we_up</h2><br />";
            echo"<table><tr><td class=\"fcomblue\" width=165>
                <ul class=\"intop\"><li><a href=/$pref_page_inf>$of_users: $reg</a></li></ul>
            </td>";
            if(Auth::user()) {
                echo"<td class=\"fcomblue\" width=165>
                    <ul class=\"intop\"><li><a href=/$pref_page_sear>$of_Cityvil: $Allc</a></li></ul>
                </td>";
            }
            else{
                echo"<td class=\"fcomblue\" width=165>
                    <ul class=\"intop\"><li><a href=/register/$lan>$join_us</a></li></ul>
                </td>";
            }
            echo"</tr>
                </table><br />";


            echo"</b><br /><table><tr>";
                $Allu = DB::table('users')
                ->select('Num', 'Im', 'Priz', 'avatar')
                ->where('avatar',">",0)
                ->orderBy('l_visit','desc')
                ->limit(5)
                ->get();
            foreach ($Allu as $All) {
                $avt = $All->Num;
                $Im = $All->Im;
                $Priz = $All->Priz;
                $Num_a = $All->avatar;
                echo"<td valign=top align=center><div style=\"width: width: 100%; max-width: 75px; overflow: hidden\">
                    <a href=/$pref_page_i$avt><div style=\"height: 50px; overflow: hidden\">
                    <div class=\"scale\">
                        <img border=0 SRC=/storage/avatar/s$Num_a.jpg></div></div></a><a href=/$pref_page_i$avt>
                        <font size=1>$Im $Priz</font></a><br />
                    </div>
                </td>";

            }

            	echo"</tr></table><br />";
            $usefull_links = __('messages.usefull_links');
            if($lan=="ua"){echo"<a href=/lifeua/1>$usefull_links</a><br /><br />";}
            if($lan=="ru"){echo"<a href=/liferu/1>$usefull_links</a><br /><br />";}
            @endphp

        </td></tr></table>


    </div>

    <div class="layermain2">
        <table style="width:100%; max-width: 445px;"><tr><td class=fcom0 align=center valign=top width="445">
            <script>
                function ffnews(page) {

                    var go_news="";
                    if(document.getElementById('cnforum').checked){go_news=go_news+"1";} else{go_news=go_news+"0";}
                    if(document.getElementById('cnfoto').checked){go_news=go_news+"1";} else{go_news=go_news+"0";}
                    if(document.getElementById('cnratef').checked){go_news=go_news+"1";} else{go_news=go_news+"0";}
                    if(document.getElementById('cncoment').checked){go_news=go_news+"1";} else{go_news=go_news+"0";}
                    var oblnew = document.getElementById('oblnew').value;

                    if(oblnew>=1){
                        if(oblnew>=1 && oblnew<10){
                            go_news=go_news+"0";
                        }
                        go_news=go_news+oblnew;
                    } else{go_news=go_news+"00";}

                    var exp = new Date();
                    var oneYearFromNow = exp.getTime() + (365*24*60*60*1000);
                    exp.setTime (oneYearFromNow);
                    document.cookie = "go_news=" + go_news +"; expires=" + exp.toGMTString();

                    $.ajaxSetup({
                        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                    });
                    var formData = {
                        go_news:go_news, page:0,
                    };
                    $.ajax({
                        type: 'POST',
                        url: '/news',
                        data: formData,
                        cache: false,
                        success:function(data){
                            document.getElementById("news").innerHTML=data;
                        }
                    });

                }
                function news(page) {

                    var next_div = "next_div" + page;
                    document.getElementById(next_div).style.display = 'none';

                    $.ajaxSetup({
                        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
                    });
                    var formData = {
                        page:page,
                    };
                    $.ajax({
                        type: 'POST',
                        url: '/news',
                        data: formData,
                        cache: false,
                        success:function(data){
                            document.getElementById("news").innerHTML+=data;
                        }
                    });

                }
            </script>
            @php


            $ua_news = __('messages.1ua_news');
            $nFoto = __('messages.Foto');
            $nEst =  __('messages.Est');
            $nForum = __('messages.Forum');
            $nComment = __('messages.Comment');
            $loc_news = __('messages.loc_news');
            $lan = __('messages.lan');
            $writen = __('messages.writen');
            $writen2 = __('messages.writen2');
            $added1 = __('messages.added1');
            $added2 = __('messages.added2');
            $pref_page = __('messages.pref_page');
            $pref_page_i = $pref_page.="i";
            $Someone = __('messages.Someone');
            $in_album = __('messages.in_album');
            $fotom = __('messages.fotom');
            $appreciated1 = __('messages.appreciated1');
            $appreciated2 = __('messages.appreciated2');

            echo"<br /><h1>$ua_news</h1>";
            if(isset($_COOKIE['go_news'])){$go_news = $_COOKIE['go_news'];} else {$go_news = "111100";}
            $nforum = substr($go_news, 0, 1);
            $nfoto = substr($go_news, 1, 1);
            $nratef = substr($go_news, 2, 1);
            $ncoment = substr($go_news, 3, 1);
            $lnews = substr($go_news, 4, 2);
            $lnews1 = substr($lnews, 0, 1);
            if($lnews1==0){$lnews2 = substr($go_news, 5, 1);} else{$lnews2=$lnews;}
            echo"<table><tr><td><div style='margin: 5px 5px 5px 0px;'>
                    <input type=checkbox onchange=ffnews() id=cnforum"; if($nforum!="0"){echo" checked";} echo"> <img src=/images/nforum.png> $nForum <br />
                    <input type=checkbox onchange=ffnews() id=cnfoto";  if($nfoto!="0"){echo" checked";} echo"> <img src=/images/nfoto.png> $nFoto<br />
                    <input type=checkbox onchange=ffnews() id=cnratef"; if($nratef!="0"){echo" checked";} echo"> <img src=/on.png> $nEst <br />
                    <input type=checkbox onchange=ffnews() id=cncoment"; if($ncoment!="0"){echo" checked";} echo"> <img src=/images/ncoment.png> $nComment<br />
            </div></td>
            <td><div style='margin: 5px 0px 5px 5px;'>";

               echo"$loc_news<br /><select id=oblnew onchange=ffnews()>";
               for ($i = 0; $i <= 25; $i++){
                 $ni = "messages.ooo$i"; $no = "messages.chopt";
                echo"<option value=$i";
                if((int)$lnews2 == $i){echo" selected";}
                echo">";
                   if($i==0){echo __($no);}
                    else{echo __($ni);}
                echo"</option>";
                }

            echo"</select>
            </div></td></tr></table>

            <br />
            </td></tr></table>

            <div id=news style='margin: 10px 0px 10px 0px;'>";


            $q_s1[0] = ['act', 100];
            $q_s2[0] = ['act', 100];
            $q_s3[0] = ['act', 100];
            $q_s4[0] = ['act', 100];
            $q_s_mainp[0] = ['main_page', "!=", '3'];
            $q_s_mainp2[0] = ['main_page', "!=", '2'];
            if(Auth::user()) {
                $my_id =  Auth::user()->id;
                $q_s34[0] = ['whom', 'like', $my_id];
                $q_s_mainp2[0] = ['main_page', "!=", '3'];
            }
            else{
                $q_s34[0] = ['whom', '>', 0];
            }
            $q_s5[0] = ['act', 100];
            $q_s6[0] = ['act', 100];
            $q_s7[0] = ['act', 100];
            if($nforum!="0"){$q_s1[0] = ['act', 'nforum'];}
            if($nfoto!="0"){$q_s2[0] = ['act', 'nfoto'];}
            if($nratef!="0"){$q_s3[0] = ['act', 'nratef']; $q_s4[0] = ['act', 'nratem']; }
            if($ncoment!="0"){$q_s5[0] = ['act', 'ncoment']; $q_s6[0] = ['act', 'ncomentm']; }
            if(Auth::user()) {
            }
            else{
                $q_s3[0] = ['act', 100];
                $q_s4[0] = ['act', 100];
            }
            if($lnews!="00"){
                $lnews_obl = (int)$lnews;
                $q_s7[0] = ['act', (string)$lnews_obl];
            }

            $Alln = DB::table('News')->select('act','obl','avt','Im','Priz','sex','theme','ualine','ruline','enline',
                'Nd','whom','forum','avt_fr')->
                orWhere(function ($query)
                 use ($q_s1, $q_s2, $q_s3, $q_s4, $q_s34, $q_s5, $q_s6, $q_s7) {
                    $query->whereNull('act')
                        ->orWhere($q_s1)
                        ->orWhere($q_s2)
                        // ->orWhere(function ($query) use ($q_s2,$q_s22){$query->Where($q_s2)->Where($q_s22);})
                        ->orWhere(function ($query) use ($q_s3,$q_s34){$query->Where($q_s3)->Where($q_s34);})
                        ->orWhere(function ($query) use ($q_s4,$q_s34){$query->Where($q_s4)->Where($q_s34);})
                        ->orWhere($q_s5)
                        ->orWhere($q_s6)
                        ->orWhere($q_s7);
                })
                ->Where($q_s_mainp)
                ->Where($q_s_mainp2)->
                orderBy('Nd', 'desc')->
                take(61)->
                get();

                $Allnn = $Alln->count();
                if($Allnn>0) {

                    $nfm = 1;  $Nd_f_h=""; $act_old = ""; $titleh="";
                    $fortable = "shut"; $afortable = "shut"; $afmtable="shut";
                    $fotable = "shut"; $afotable="shut"; $acttable="shut";
                    $linef="go"; $nforum_e3 = ""; $nfoto_e3 = ""; $nratef_e3 = ""; $ncoment_e3="";

                    foreach ($Alln as $Alb) {
                        if ($nfm < 61) {

                            $theme = $Alb->theme; $ualine = $Alb->ualine; $ruline = $Alb->ruline; $enline = $Alb->enline;
                            $act = $Alb->act; $obl = $Alb->obl; $avt = $Alb->avt; $Im = $Alb->Im; $Priz = $Alb->Priz; $sex = $Alb->sex;
                            $Nd = $Alb->Nd; $whom = $Alb->whom; $forum = $Alb->forum; $avt_fr = $Alb->avt_fr;

                            if($lan=="en" && mb_strlen($enline)>1){$ualine = $enline;}
                            else if($lan=="ru" && mb_strlen($ruline)>1){$ualine = $ruline;}

                            $monm = substr($Nd, 5, 2);
                            if($monm == "1") {$monm = "січня"; $monmr = "января"; $monme = "January"; } if($monm == "2") {$monm = "лютого";   $monmr = "февраля";$monme = "February";} if($monm == "3") {$monm = "березня";$monmr = "марта";$monme = "March";}
                            if($monm == "4") {$monm = "квітня";$monmr = "апреля";$monme = "April";}     if($monm == "5") {$monm = "травня";   $monmr = "мая";    $monme = "May";     } if($monm == "6") {$monm = "червня"; $monmr = "июня"; $monme = "June"; }
                            if($monm == "7") {$monm = "липня"; $monmr = "июля"; $monme = "July"; }      if($monm == "8") {$monm = "серпня";   $monmr = "августа";$monme = "August";  } if($monm == "9") {$monm = "вересня";$monmr = "сентября";$monme = "September";}
                            if($monm == "10"){$monm = "жовтня";$monmr = "октября";$monme = "October";}  if($monm == "11"){$monm = "листопада";$monmr = "ноября"; $monme = "November";} if($monm == "12"){$monm = "грудня"; $monmr = "декабря"; $monme = "December"; }

                            if($lan=="en"){$monm_lv=$monme;}
                            else if($lan=="ru"){$monm_lv=$monmr;}
                            else{$monm_lv=$monm;}
                            $daym_lv = substr($Nd, 8, 2); if(substr($daym_lv, 0, 1)==0){$daym_lv = substr($daym_lv, 1, 1);}

                            $Nd_is = date('Y-m-d');
                            $Nd_past1 = date('Y-m-d', strtotime('-1 days'));
                            $Nd_past2 = date('Y-m-d', strtotime('-2 days'));
                            $Nd_f = substr($Nd, 0, 10);
                            $hourm_lv = substr($Nd, 11, 2); $min_lv = substr($Nd, 14, 2);
                            if(substr($hourm_lv, 0, 1)==0){$hourm_lv = substr($Nd, 12, 1);}

                            if($Nd_f==$Nd_is){$title="Сьогодні"; $titler="Сегодня"; $titlee="Today";
                                if($lan=="en"){$title=$titlee;}
                                else if($lan=="ru"){$title=$titler;}
                            }
                            else if($Nd_f==$Nd_past1){$title="Вчора"; $titler="Вчера"; $titlee="Yestarday";
                                if($lan=="en"){$title=$titlee;}
                                else if($lan=="ru"){$title=$titler;}
                            }
                            else if($Nd_f==$Nd_past2){$title="Позавчора"; $titler="Позавчера"; $titlee="Day before yesterday";
                                if($lan=="en"){$title=$titlee;}
                                else if($lan=="ru"){$title=$titler;}
                            }
                            else{$title="$daym_lv $monm_lv ";}

                            $time="<font color=grey>$hourm_lv:$min_lv</font>";
                            if($titleh!=$title||$act_old!=$act) {

                                if($afmtable=="open"){echo"</td></tr></table></div>"; $afmtable="shut";}
                                if($fotable=="open"){echo"</tr>"; $fotable="shut"; $nrowf=1;}
                                if($afotable=="open"){echo"</table>"; $afotable="shut"; $nrowf=1;}
                                if($fortable=="open"){echo"</tr>"; $fortable="shut";}
                                if($afortable=="open"){echo"</table>"; $afortable="shut"; $nrowfr=1;}
                                if($acttable=="open"){echo"</td></tr></table></div>"; $acttable="shut";}
                                /*

                                if($actvtable=="open"){echo"</td></tr></table></div>"; $actvtable="shut";}
                                */
                                if($nfm==1 || $Nd_f_h!=$Nd_f){echo"<br /><h3>$title</h3>";}
                                $linef="go";
                            }



                            if($act=="nratef"){

                                if($sex=="1"){$nratef_e1=$appreciated1;}
                                else if($sex=="2"){$nratef_e1=$appreciated2;}
                                else{$nratef_e1="";}

                                $nratef_e2 = "$avt";

                                if($nratef_e2!=$nratef_e3 || $titleh!=$title){
                                if($fortable=="open"){echo"</tr>"; $fortable="shut";}
                                if($afortable=="open"){echo"</table>"; $afortable="shut";}

                                $time_e=$time;	$nrowfr=1;
                                echo"<table><tr><td height='5'></td></tr></table>
                                <table class=fcom0><tr><td align=left width=392>
                                    <div style=\"margin: 2px 5px 2px 5px; \">
                                        <b><a href=/$pref_page_i$avt>$Im $Priz</a></b> $nratef_e1
                                    </div>
                                </td>
                                <td width=40 align=right valign=top><div style=\"margin: 2px 1px 2px 0px; \">$time_e </div></td></tr></table>";
                                echo"<table>"; $afortable="open";

                                 }

                                $nratef_e3 = "$avt";
                                    if($theme>0.5){$star1="on";}else{$star1="off";}
                                    if($theme>1.5){$star2="on";}else{$star2="off";}
                                    if($theme>2.5){$star3="on";}else{$star3="off";}
                                    if($theme>3.5){$star4="on";}else{$star4="off";}
                                    if($theme>4.5){$star5="on";}else{$star5="off";}

                                if($nrowfr==1){echo"<tr>"; $fortable="open";}
                                echo"<td align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\" valign=center><div style=\"height: 80px; overflow: hidden; \">
                                <img src=$star1.png border=0><img src=$star2.png border=0><img src=$star3.png border=0><img src=$star4.png border=0><img src=$star5.png border=0><br />$ualine</div></td>";
                                        $nrowfr++;

                                if($nrowfr==5){$nrowfr=1; echo"</tr>"; $fortable="shut";}

                            }




                            if($act=="ncoment"){

                                $sex2=substr($sex, 0, 1);
                                if($sex2==7){$Num_a=substr($sex, 0, 8);}
                                else{$Num_a=substr($sex, 1, 8);}
                                if($sex2=="1"||$avt==0){$e1="$writen:";}
                                else if($sex2=="2"){$e1="$writen2:";}
                                else{$e1="";}

                                $ncoment_e2 = "$theme";

                                if($ncoment_e2!=$ncoment_e3){$linec="go";
                                 if($acttable=="open"){echo"</td></tr></table></div>"; $acttable="shut";}
                                }

                                if($linec=="go"){
                                 $ncoment_e="<table><tr><td height='5'></td></tr></table>
                                 <div class=fcom0 style=\"width: 440; max-width: 440px; overflow: hidden\">
                                 <table><tr valign=top>
                                 <td align=right rowspan=3><div style=\"width: 100px; margin: 5px 5px 2px 5px; overflow: hidden\">$ualine <br /></div>";

                                $ncoment_eee="</td><td align=right>";

                                 $acttable="open"; $linec="stop";
                                }
                                else{$ncoment_e="";$ncoment_eee="";}
                                $ncoment_e3 = "$theme";

                                echo"$ncoment_e $ncoment_eee <table><tr><td width=290>
                                <table><tr><td>
                                    <div style=\"float:left; margin: 0px 5px 2px 0px; \">
                                    <a href=/$pref_page_i$avt><div style=\"height: 50px; overflow: hidden\">
                                    <img border=0 SRC=/storage/avatar/s$Num_a.jpg align=left></div></a></div> <a href=/$pref_page_i$avt><b>$Im $Priz</b></a> $e1<br />
                                    $forum
                                 </td></tr></table>
                                <div style=\"float:right\">$time</div></td></tr></table>";


                            }




                            if($act=="ncomentm"){

                                $sex2=substr($sex, 0, 1);
                                if($sex2==7){$Num_a=substr($sex, 0, 8);}
                                else{$Num_a=substr($sex, 1, 8);}
                                if($sex2=="1"||$avt==0){$e1="$writen:";}
                                else if($sex2=="2"){$e1="$writen2:";}
                                else{$e1="";}

                                    $ua_e="<a href=\"";
                                    $tof = strtok($theme,"#&~");
                                    $tf=1;
                                    $ttheme = ""; $tpage = "";  $tnpage = "";
                                    $name1=""; $name2=""; $name3="";
                                    while($tof) {
                                        if($tf==1){$tpage=$tof;}
                                        if($tf==2){$tnpage=$tof;}
                                        if($tf==3){$name1=$tof;}
                                        if($tf==4){$name2=$tof;}
                                        if($tf==5){$name3=$tof;}
                                        if($tf==6){$ttheme=$tof;}
                                        $tof = strtok("#&~");
                                        $tf++;
                                    }
                                    $nname="";
                                    if($lan=="en"){$ua_e.="e";}
                                    else if($lan=="ru"){$ua_e.="r";}
                                    if($tpage=="c"){
                                        $ua_e.="rec$tnpage";
                                        $nname = $name1;
                                        if($lan=="en"){$nname = $name3;}
                                        if($lan=="ru"){$nname = $name2;}
                                    }
                                    else{
                                        $ua_e.="recp$tnpage";
                                        $nname = "$name1 $name2";
                                    }
                                    $ua_e.="\">";
                                    $ua_e.="$nname $ttheme</a>";

                                    echo"<table><tr><td height='5'></td></tr></table>
                                    <table class=fcom0><tr><td>
                                        <table><tr><td align=left width=387>
                                            <div style=\"margin: 2px 5px 2px 5px; \">
                                                <b><a href=/$pref_page_i$avt>$Im $Priz</a></b> $e1
                                            </div>
                                        </td>
                                        <td width=40 align=right valign=top><div style=\"margin: 2px 1px 2px 0px; \">$time </div></td></tr>
                                        </table>
                                        <table>
                                        <tr valign=top><td align=right width=100>
                                            <div style=\"width: 102px; overflow: hidden; margin: 5px 0px 2px 2px;\">
                                             $ua_e</div>
                                        </td><td align=right>
                                            <table><tr valign=top><td width=260><div style=\"margin: 2px 5px 2px 2px;  max-width: 260px; overflow: hidden\">$ualine $forum</div></td></tr></table>
                                        </td></tr></table>
                                    </td></tr></table>";

                            }


/*
                            if($act=="nfoto"){

                                if($sex=="1"){$nfoto_e1=$added1;}
                                else if($sex=="2"){$nfoto_e1=$added2;}
                                else{$nfoto_e1="-";}
                                $themef=$theme;

                                if(mb_strlen($themef)>12){
                                    $theme_e="<a href=\"";
                                    $tokf = strtok($themef,"#&~");
                                    $tn=1;

                                    while($tokf) {
                                        if($tn==1){
                                            if($tokf=="fotop"){$ide="fi";}
                                            else{$ide="fc";}
                                        }
                                        if($tn==2){
                                            if((int)$tokf>0){
                                                $domengo="stop";
                                                $theme_e.="/$ide$tokf";
                                            }
                                            else{
                                                $domengo="go";
                                                $theme_e.="/$tokf
                                                /foto/$lan/";
                                            }
                                        }
                                        if($tn==3){
                                            if($obl>0){
                                                 $ni = "messages.ooo$obl";
                                                 $fno_e=__($ni); $fno_e="($fno_e)";
                                            }
                                            else{$fno_e="";}
                                            if($domengo=="go"){
                                                $tokf = str_ireplace(" з panoramio.com", "", $tokf);
                                                $theme_e.="$tokf";
                                            }
                                            $theme_e.="\"> $in_album <b>$tokf$fno_e</b></a>";
                                        }
                                    $tokf = strtok("#&~");
                                    $tn++;
                                    }
                                }
                                else{$theme_e="";}


                                $nfoto_e2 = "$avt$theme";

                                if($nfoto_e2!=$nfoto_e3 || $titleh!=$title){
                                    if($fotable=="open"){echo"</tr>"; $fotable="shut";}
                                    if($afotable=="open"){echo"</table>"; $afotable="shut";}
                                    $time_e=$time;	$nrowf=1;

                                    echo"<table><tr><td height='5'></td></tr></table>
                                    <table class=fcom0><tr><td align=left width=400>
                                        <div style=\"margin: 2px 5px 2px 5px; \">
                                            <b><a href=/$pref_page_i$avt>$Im $Priz</a></b> $nfoto_e1 $fotom$theme_e:
                                        </div>
                                    </td>
                                    <td width=40 align=right valign=top><div style=\"margin: 2px 1px 2px 0px; \">$time_e </div></td></tr></table>";

                                    echo"<table>";
                                    $afotable="open";
                                }

                                $nfoto_e3 = "$avt$theme";
                                $ualine = str_replace('<img b', '<div class="scale"><img b', $ualine);
                                // $ualine = str_replace('=100', '=90', $ualine);
                                $ualine = str_replace('></a>', '></a></div>', $ualine);

                                if($nrowf==1){echo"<tr>"; $fotable="open";}
                                echo"<td align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                                        <div style=\"height: 70px; overflow: hidden\">$ualine</div>
                                 </td>";
                                    $nrowf++;

                                if($nrowf==5){
                                    $nrowf=1; echo"</tr>";
                                    $fotable="shut";
                                }

                            }
*/


                            if($act=="nratem"){

                                if($sex=="1"){$nratef_e1=$appreciated1;}
                                else if($sex=="2"){$nratef_e1=$appreciated2;}
                                else{$nratef_e1="";}

                                $ua_e="<a href=\"";
                                $tof = strtok($theme,"#&~");
                                $tf=1; $ttheme = ""; $tpage = "";  $tnpage = "";
                                while($tof) {
                                    if($tf==1){$mark=$tof;}
                                    if($tf==2){$tpage=$tof;}
                                    if($tf==3){$tnpage=$tof;}
                                    if($tf==4){$ttheme=$tof;}
                                    $tof = strtok("#&~");
                                    $tf++;
                                }

                                if($lan=="en"){$ua_e.="e";}
                                else if($lan=="ru"){$ua_e.="r";}
                                if($tpage=="c"){$ua_e.="c$tnpage";}
                                else{$ua_e.="i$tnpage";}
                                $ua_e.="\">";

                                if($tnpage<1000000){
                                    $City="";
                                    $Allc = DB::table('Allcities')->select('City','City2','City3')->
                                    where('id', $tnpage)->limit(1)->get();
                                    foreach ($Allc as $All) {
                                        $City = $All->City; $City2 = $All->City2; $City3 = $All->City3;
                                    }
                                    $Citydrn = $City;
                                    if($lan=="en"){$Citydrn = $City3;}
                                    if($lan=="ru"){$Citydrn = $City2;}
                                    $ua_e.="$Citydrn $ttheme</a>";
                                }
                                else{
                                    $Imn=""; $Prizn="";
                                    $Allc = DB::table('users')->select('Im','Priz')->
                                    where('id', $tnpage)->limit(1)->get();
                                    foreach ($Allc as $All) {
                                        $Imn = $All->Im; $Prizn = $All->Priz;
                                    }
                                    $ua_e.="$Imn $Prizn $ttheme</a>";
                                }

                                if($mark>0.5){$star1="on";}else{$star1="off";}
                                if($mark>1.5){$star2="on";}else{$star2="off";}
                                if($mark>2.5){$star3="on";}else{$star3="off";}
                                if($mark>3.5){$star4="on";}else{$star4="off";}
                                if($mark>4.5){$star5="on";}else{$star5="off";}

                                echo"<table><tr><td height='5'></td></tr></table>
                                <table class=fcom0><tr><td>
                                    <table><tr><td align=left width=387>
                                        <div style=\"margin: 2px 5px 2px 5px; \">
                                            <b><a href=/$pref_page_i$avt>$Im $Priz</a></b> $nratef_e1
                                        </div>
                                    </td>
                                    <td width=40 align=right valign=top><div style=\"margin: 2px 1px 2px 0px; \">$time </div></td></tr>
                                    </table>
                                    <table>
                                    <tr valign=top><td align=right width=110>
                                        <div style=\"width: 100px; overflow: hidden; margin: 5px 2px 2px 2px;\">
                                        <img src=/$star1.png border=0><img src=/$star2.png border=0><img src=/$star3.png border=0><img src=/$star4.png border=0><img src=/$star5.png border=0>
                                        <br /> $ua_e</div>
                                    </td><td align=right>
                                        <table><tr valign=top><td width=300><div style=\"margin: 2px 5px 2px 5px;  max-width: 305px; overflow: hidden\">$ualine</div></td></tr></table>
                                    </td></tr></table>
                                </td></tr></table>";


                            }




                            if($act=="nforum"){

                                $sex2=substr($sex, 0, 1);
                                if($sex2==7){$Num_a=substr($sex, 0, 8);}
                                else{$Num_a=substr($sex, 1, 8);}
                                if($sex2=="1"||$avt==0){$e1="$writen:";}
                                else if($sex2=="2"){$e1="$writen2:";}
                                else{$e1="";}

                                $nforum_e2 = "$theme";

                                if($nforum_e2!=$nforum_e3){$linef="go";
                                    if($afmtable=="open"){echo"</td></tr></table></div>"; $afmtable="shut";}
                                }

                                if($linef=="go"){

                                    $ua_e="<a href=\"";
                                    $tof = strtok($theme,"#&~");
                                    $tf=1; $ttheme = ""; $tpage = "";  $tnpage = "";
                                    while($tof) {
                                        if($tf==1){$tpage=$tof;}
                                        if($tf==2){$tnpage=$tof;}
                                        if($tf==3){$ttheme=$tof;}
                                        $tof = strtok("#&~");
                                        $tf++;
                                    }
                                        if((int)($tnpage)>0){
                                            if($lan=="en"){$ua_e.="e";}
                                            else if($lan=="ru"){$ua_e.="r";}
                                            if($tpage=="c"){$ua_e.="c$tnpage";}
                                            else{$ua_e.="i$tnpage";}
                                        }
                                        else{
                                            $ua_e.="/$tnpage/forum/$lan/0/";
                                            if(mb_strlen($ttheme)>0){$ua_e.="$ttheme";}
                                            else{$ua_e.="0";}
                                        }

                                        $ua_e.="\">";

                                    $ualine = str_replace("<a>","$ua_e","$ualine");

                                    $nforum_e="<table><tr><td height='5'></td></tr></table>
                                    <div><table><tr valign=top>
                                    <td align=right rowspan=5 width=110 class=fcom0>
                                        <div style='margin: 2px 5px 2px 5px; max-width: 95px; overflow: hidden;'>$ualine </div>";
                                    $nforum_eee="</td><td align=right class=fcom0>";

                                    $afmtable="open"; $linef="stop";
                                }
                                else{$nforum_e=""; $nforum_eee="";}
                                $nforum_e3 = "$theme";

                                $av_avt = "";
                                if($avt>7){if ($Num_a==0){$Num_a=7;}
                                    $av_avt = "<a href=/$pref_page_i$avt><div style=\"height: 50px; float:left; overflow: hidden; margin: 2px 5px 2px 0px;\" align=left>
                                    <img border=0 SRC=/storage/avatar/s$Num_a.jpg></div></a> <a href=/$pref_page_i$avt> <b>$Im $Priz</b></a>";
                                }
                                else {
                                    $av_avt=$Someone;
                                    $e1="$writen:";
                                }
                                $ualine_e2="<table><tr valign=top><td width=275><div style='margin: 0px 5px 2px 2px;'>$av_avt  $e1</div>";

                                $avtall = strstr($forum,"*&^@");
                                list($avt_old) = sscanf($avtall, "*&^@%d");

                                if($avt_old>0){
                                    $filename = "storage/last_visit/$avt_old.txt";
                                    $whattoread = @fopen($filename, "r");
                                    $file_contents = fread($whattoread, filesize($filename)); fclose($whattoread);
                                    $pageq = explode("#!:*&", $file_contents);

                                    $Imq=$pageq[1]; $Prizq=$pageq[2]; $Num_aq=$pageq[3];  if($Num_aq<10){$Num_aq=7;}

                                    $forum=str_replace("*&^@$avt_old",
                                    "<a href=/$pref_page_i$avt_old><div style=\"height: 50px; float:left; overflow: hidden; margin: 2px 5px 2px 0px;\"><img border=0 SRC=/storage/avatar/s$Num_aq.jpg></div></a>
                                    <a href=/$pref_page_i$avt_old>$Imq $Prizq</a><br />", $forum);
                                }
                                else{$forum=str_replace("*&^@", "", $forum);}

                                $quest = __('messages.quest');
                                $answ5 = __('messages.answ5');
                                $forum=str_replace("%^&@#", "$quest: <br />", $forum);
                                $forum=str_replace("&@#%^", "$answ5: <br />", $forum);

                                echo"$nforum_e";
                                echo"$nforum_eee $ualine_e2</td><td align=right width=40>$time</td></tr>
                                <tr valign=top><td colspan=2><div style=\"margin: 0px 5px 2px 2px; max-width: 250px; overflow: hidden; \">$forum </div></td></tr></table>";

                            }



                            if((int)$act>0 && (int)$act<26){
                                echo"<table><tr><td height='5'></td></tr></table>
                                <table style=\"width:100%; max-width: 445px;\"><tr><td class=fcom0 align=left valign=top width=\"445\">
                                    <table><tr><td width=\"405\">
                                        <div style=\"margin: 2px 5px 2px 5px; max-width: 390px; overflow: hidden; \">$ualine </div>
                                    </td>
                                    <td align=right valign=top width=40>$time</td>
                                    </tr></table>
                                 </td></tr></table>";
                            }

                             $Nd_f_h=$Nd_f; $act_old = $act; $titleh = $title;
                        }
                        $nfm++;
                    } // перелік всіх новин

                    if($afmtable=="open"){echo"</td></tr></table></div>"; $afmtable="shut";}
                    if($fotable=="open"){echo"</tr>"; $fotable="shut";}
                    if($afotable=="open"){echo"</table>"; $afotable="shut";}
                    if($fortable=="open"){echo"</tr>"; $fortable="shut";}
                    if($afortable=="open"){echo"</table>"; $afortable="shut";}
                    if($acttable=="open"){echo"</td></tr></table></div>"; $acttable="shut";}
                    /*
                    if($frtable=="open"){echo"</tr>"; $frtable="shut";}
                    if($arptable=="open"){echo"</td><td width=5></td></tr></table></td></tr></table>"; $arptable="shut";}
                    if($actvtable=="open"){echo"</td></tr></table></div>"; $actvtable="shut";}
                    */

                    if($nfm==62){
                        $next_e = __('messages.nnext');
                        $next_div = "next_div2";
                        echo"<div id=$next_div><br /><table><tr>
                                <td width=440 class=fcom align=center onMouseOver=news(2)>
                                    <a href=## onclick=news(2)><h3>$next_e </h3> </a>
                                </td></tr></table></div>";
                    }
                } // if($Allnn>0) {
                else{
                    $no_news = __('messages.no_news');
                    echo"<table style=\"width:100%; max-width: 445px;\"><tr><td class=fcom0 align=center valign=top width=\"445\">
                            <br /><b>$no_news</b><br /><br />
                        </td></tr></table>";
                }

            echo"</div>";


            @endphp

    </div>
    <div class="clear"></div>
</div>




    <table><tr><td width=455 align=center>

        <br /><br />
        <table border=0><tr valign=top height=14>
                <td width=30 align=center>
                    @if (App::isLocale('en'))<img src="/flag-en.png" title = "english language" border=0>
                    @else <a class=enover href="/en" title = "english language"></a>
                    @endif
                </td>
                <td width=30 align=center>
                    @if (App::isLocale('ua'))<img src="/flag-uk.gif" title = "українська мова" border=0>
                    @else <a class=uaover href="/ua" title = "українська мова"></a>
                    @endif
                </td>
                <td width=30 align=center>
                    @if (App::isLocale('ru'))<img src="/flag-ru.gif" title = "русский язык" border=0>
                    @else <a class=ruover href="/ru" title = "русский язык"></a>
                    @endif
                </td>
            </tr></table>

    </td></tr></table>

</div>
@endsection
