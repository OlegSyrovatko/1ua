<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App;
class obl_future_news25 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obl_future_news25';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'obl_future_news25';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $load = sys_getloadavg();
        $load_now = $load[0];
        $obl = 25;
        $Mdo = date('Y-m-d');
        $Alladn = DB::table('local_news')
            ->where('obl', $obl)
            ->where('date', $Mdo)
            ->limit(1)
            ->count();

        if($load_now<6 && $Alladn==0) {
            if ($obl == 1) {
                $not_oblc = 234;
            }
            if ($obl == 2) {
                $not_oblc = 224;
            }
            if ($obl == 3) {
                $not_oblc = 187;
            }
            if ($obl == 4) {
                $not_oblc = 247;
            }
            if ($obl == 5) {
                $not_oblc = 298;
            }
            if ($obl == 6) {
                $not_oblc = 342;
            }
            if ($obl == 7) {
                $not_oblc = 373;
            }
            if ($obl == 8) {
                $not_oblc = 383;
            }
            if ($obl == 9) {
                $not_oblc = 414;
            }
            if ($obl == 10) {
                $not_oblc = 233;
            }
            if ($obl == 11) {
                $not_oblc = 471;
            }
            if ($obl == 12) {
                $not_oblc = 557;
            }
            if ($obl == 13) {
                $not_oblc = 520;
            }
            if ($obl == 14) {
                $not_oblc = 585;
            }
            if ($obl == 15) {
                $not_oblc = 614;
            }
            if ($obl == 16) {
                $not_oblc = 644;
            }
            if ($obl == 17) {
                $not_oblc = 665;
            }
            if ($obl == 18) {
                $not_oblc = 687;
            }
            if ($obl == 19) {
                $not_oblc = 712;
            }
            if ($obl == 20) {
                $not_oblc = 787;
            }
            if ($obl == 21) {
                $not_oblc = 741;
            }
            if ($obl == 22) {
                $not_oblc = 764;
            }
            if ($obl == 23) {
                $not_oblc = 853;
            }
            if ($obl == 24) {
                $not_oblc = 811;
            }
            if ($obl == 25) {
                $not_oblc = 838;
            }
            $time_h = "";
            $selected_cities_h = "";
            $true_link = 0;
            $Allq = DB::table('Allcities')
                ->select('id', 'rayc', 'City', 'City2', 'City_m', 'City_o', 'City_r', 'City_d', 'rod', 'dat', 'vin', 'tvor', 'predl')
                ->where('obl', $obl)
				->where('id', '!=', 147732)
				->where('id', '!=', 147905)
                ->where('id', '!=', 33559) 
				->where('id', '!=', 147651) 
				->where('id', '!=', 147755) 
				->where('id', '!=', 33215) 
                ->where('vol_karta', '>', 7000)
                ->get();
            $Allcs = $Allq->count();
            echo "Всіх міст $Allcs <br />";
            $row = 0;
            foreach ($Allq as $Alq) {
                $id[$row] = $Alq->id;
                $rayc[$row] = $Alq->rayc;
                $City[$row] = $Alq->City;
                $City2[$row] = $Alq->City2;
                $City_m[$row] = $Alq->City_m;
                $City_o[$row] = $Alq->City_o;
                $City_r[$row] = $Alq->City_r;
                $City_d[$row] = $Alq->City_d;
                $rod[$row] = $Alq->rod;
                $dat[$row] = $Alq->dat;
                $vin[$row] = $Alq->vin;
                $tvor[$row] = $Alq->tvor;
                $predl[$row] = $Alq->predl;
                $row++;
            }

            $filename = "obl_news/$obl.html";
            $content = Storage::disk('public')->get($filename);


            $start = "<article>";
            $position = strpos($content, $start);
            $content = substr($content, $position + 9);

            $finish = "</article>";
            $position = strpos($content, $finish);
            $content = substr($content, 0, $position);

            $pagec = explode("<section class=\"im\">", $content);
            $count_news = substr_count($content, "<section class=\"im\">");
            echo "count_news $count_news <br><br>";

            for ($n = 1; $n <= $count_news; $n++) {
                $contentpol = $pagec[$n];
                if ($n != 4) {
                    $start = "<time class=";
                    $position = strpos($contentpol, $start);
                    $time = substr($contentpol, $position + 17);
                    $start = ">";
                    $position = strpos($time, $start);
                    $time = substr($time, $position + 1);
                    $finish = "</time>";
                    $position = strpos($time, $finish);
                    $time = substr($time, 0, $position);
                    if (mb_strstr($time, ":") == "") {
                        break;
                    }

                    $start = "<a href=";
                    $position = strpos($contentpol, $start);
                    $contentpol = substr($contentpol, $position + 9);
                    $contentpol2 = $contentpol;
                    $finish = "\" class";
                    $position = strpos($contentpol, $finish);
                    $link = substr($contentpol, 0, $position);

                    $start = "_blank";
                    $position = strpos($contentpol2, $start);
                    $contentpol2 = substr($contentpol2, $position + 9);
                    $start = ">";
                    $position = strpos($contentpol2, $start);
                    $contentpol2 = substr($contentpol2, $position + 1);
                    $finish = "</a>";
                    $position = strpos($contentpol2, $finish);
                    $news_text = substr($contentpol2, 0, $position);

                    if ($true_link == 0) {
                        $Md = date('Y-m-d');
                        $Allad = DB::table('local_news')->select('obl')->
                        where('obl', $obl)->
                        where('link', $link)->
                        limit(1)->get();
                        $Alladn = $Allad->count();
                        if ($Alladn == 0) {
                            DB::table('local_news')
                                ->insert(['obl' => $obl, 'date' => $Md, 'link' => $link]);
                        } else {
                            break;
                        }
                    }
                    $true_link++;

                    for ($nn = 0; $nn < $Allcs; $nn++) {

                        $rec = "false";
                        if (mb_strlen($City[$nn]) > 1) {
                            if (mb_strstr($news_text, $City[$nn]) != "") {
                                $rec = "true";
                            }
                        }
                        if (mb_strlen($City2[$nn]) > 1) {
                            if (mb_strstr($news_text, $City2[$nn]) != "") {
                                $rec = "true";
                            }
                        }
                        if (mb_strlen($City_m[$nn]) > 1) {
                            if (mb_strstr($news_text, $City_m[$nn]) != "") {
                                $rec = "true";
                            }
                        }
                        if (mb_strlen($City_o[$nn]) > 1) {
                            if (mb_strstr($news_text, $City_o[$nn]) != "") {
                                $rec = "true";
                            }
                        }
                        if (mb_strlen($City_r[$nn]) > 1) {
                            if (mb_strstr($news_text, $City_r[$nn]) != "") {
                                $rec = "true";
                            }
                        }
                        if (mb_strlen($City_d[$nn]) > 1) {
                            if (mb_strstr($news_text, $City_d[$nn]) != "") {
                                $rec = "true";
                            }
                        }
                        if (mb_strlen($rod[$nn]) > 1) {
                            if (mb_strstr($news_text, $rod[$nn]) != "") {
                                $rec = "true";
                            }
                        }
                        if (mb_strlen($dat[$nn]) > 1) {
                            if (mb_strstr($news_text, $dat[$nn]) != "") {
                                $rec = "true";
                            }
                        }
                        if (mb_strlen($vin[$nn]) > 1) {
                            if (mb_strstr($news_text, $vin[$nn]) != "") {
                                $rec = "true";
                            }
                        }
                        if (mb_strlen($tvor[$nn]) > 1) {
                            if (mb_strstr($news_text, $tvor[$nn]) != "") {
                                $rec = "true";
                            }
                        }
                        if (mb_strlen($predl[$nn]) > 1) {
                            if (mb_strstr($news_text, $predl[$nn]) != "") {
                                $rec = "true";
                            }
                        }

                        if ($obl == 1) {
                            if (mb_strstr($news_text, "Крым") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Крим") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 2) {
                            if (mb_strstr($news_text, "Волин") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 3) {
                            if (mb_strstr($news_text, "Винничина") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Винницк") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Вінницьк") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Вінничина") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 4) {
                            if (mb_strstr($news_text, "Днепров") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Дніпров") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 5) {
                            if (mb_strstr($news_text, "Донецкая") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Донецкой") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Донецька о") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Донецько") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Донетч") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Донецькі") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Донечч") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 6) {
                            if (mb_strstr($news_text, "Житомирс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Житомирщ") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 7) {
                            if (mb_strstr($news_text, "Закарпа") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 8) {
                            if (mb_strstr($news_text, "Запорожс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Запоріз") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 9) {
                            if (mb_strstr($news_text, "Франковс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Франковщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Франківс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Франківщ") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 10) {
                            if (mb_strstr($news_text, "Киевс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Киевщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Київс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Київщ") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 11) {
                            if (mb_strstr($news_text, "Кропивн") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 12) {
                            if (mb_strstr($news_text, "Львовс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Львовщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Львівс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Львівщ") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 13) {
                            if (mb_strstr($news_text, "Луганщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Луганска") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Луганська") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Луганщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Луганcьку") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Луганску") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Луганcку") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Луганcько") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Луганcко") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 14) {
                            if (mb_strstr($news_text, "Николаевс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Николаевщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Миколаївс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Миколаївщ") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 15) {
                            if (mb_strstr($news_text, "Одеск") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Одесщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Одесь") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Одещ") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 16) {
                            if (mb_strstr($news_text, "Полтавс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Полтавщ") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 17) {
                            if (mb_strstr($news_text, "Ровнен") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Рівнен") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 18) {
                            if (mb_strstr($news_text, "Сумс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Сумщ") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 19) {
                            if (mb_strstr($news_text, "Тернопольс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Тернопольщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Тернопільс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Тернопільщ") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 20) {
                            if (mb_strstr($news_text, "Хмельнич") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Хмельницка") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Хмельнич") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Хмельницька") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 21) {
                            if (mb_strstr($news_text, "Харьковщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Харьковс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Харківщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Харківс") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 22) {
                            if (mb_strstr($news_text, "Херсонщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Херсонс") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 23) {
                            if (mb_strstr($news_text, "Черніве") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Чернови") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 24) {
                            if (mb_strstr($news_text, "Черкащ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Черкась") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Черкасск") != "") {
                                $rec = "false";
                            }
                        }
                        if ($obl == 25) {
                            if (mb_strstr($news_text, "Чернігівщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Черниговщ") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Черниговс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Чернігівс") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "Десн") != "") {
                                $rec = "false";
                            }
                            if (mb_strstr($news_text, "мікрорай") != "") {
                                $rec = "false";
                            }
                        }


                        if ($rec == "true") {
                            if (mb_strstr($selected_cities_h, "$id[$nn]") == "") {
                                $selected_cities_h .= "#$id[$nn]";
                            }
                            $idn = $id[$nn];
                            $fff = $rayc[$nn];
                            $raycc[$idn][$n] = $rayc[$nn];
                            $selected_news[$idn][$n] = "<a href=$link target=_blank>$news_text</a><br /> ";
                            $selected_news_mail[$idn][$n] = "$news_text \n ";
                        }
                    }
                }
            }
            $pagec = explode("#", $selected_cities_h);
            $count_ids = substr_count($selected_cities_h, "#");
            echo "<br><br>selected_cities_h $selected_cities_h
        <br><br>count_ids $count_ids <br><br>";

            for ($n = 1; $n <= $count_ids; $n++) {
                $idn = $pagec[$n];

                echo "<br><br> idn $idn<br> ";
                $aa = $selected_news[$idn];
                $bb = $selected_news_mail[$idn];
                $cc = $raycc[$idn];

                $na = 1;
                $nb = 1;
                $nc = 1;
                $new_text = "";
                $new_text_mail = "";
                $shut_tag = "off";
                foreach ($aa as $row) {
                    if ($na == 8) {
                        $t1 = "qwertyuiopasdfg";
                        $t3 = "";
                        for ($i = 0; $i < 4; $i++) {
                            $z = rand(0, strlen($t1) - 1);
                            $t3 .= "$t1[$z]";
                        }
                        $new_text .= "<div id=\"$t3\" style=\"display: none;\">";
                        $shut_tag = "on";
                    }
                    $new_text .= "$row <br />";
                    $na++;
                }
                foreach ($bb as $row) {
                    if ($nb <= 7) {
                        if (mb_strstr($new_text_mail, $row) == "") {
                            $new_text_mail .= "$row <br />";
                        }
                    }
                    $nb++;
                }
                foreach ($cc as $row) {
                    $rayc = $row;
                }
                if ($shut_tag == "on") {
                    $t1 = "qwertyuiopasdfg";
                    $t4 = "";
                    for ($i = 0; $i < 4; $i++) {
                        $z = rand(0, strlen($t1) - 1);
                        $t4 .= "$t1[$z]";
                    }
                    $new_text .= "</div><div id=\"$t4\"> <a onclick=mem_arguem('$t3','$t4')>читати далі...</a></div>";

                }
                $new_text = "<noindex>$new_text</noindex>";
                echo "new_text $new_text<br><br> new_text_mail $new_text_mail ";
                $Md = date('Y-m-d-H-i-s');
				
				
				$time = date('H:i');
				$Allc = DB::table('Allcities')->select('City', 'City2', 'City3', 'map_w', 'map_h')->
                where('id', $idn)->limit(1)->get();

                foreach ($Allc as $All) {
                    $City = $All->City;
					$City2 = $All->City2;
					$City11 = $All->City3;
                    $map_w = $All->map_w;
					$map_h = $All->map_h;
                }


				$flink1 = "/storage/karta/$obl/$idn.jpg";
				$flink0 = "/storage/karta/$obl/face_$idn.jpg";
				$file1 = public_path($flink1);
				$file0 = public_path($flink0);
				$map_w = $map_w/2.0212766;
				$map_h = $map_h/2.0212766;
				$src_ua = "";
				$src_ru = "";
				$src_en = "";
				if(file_exists($file0)){
					$src_ua = "<br /><a href='/c$idn' class=\"scale\">
								 <img  width=$map_w height=$map_h alt=\"Топографічна карта - $City\" title=\"Топографічна карта - $City\" src=\"$flink0\">
							   </a>";
					$src_ru = "<br /><a href='/rc$idn' class=\"scale\">
								 <img width=$map_w height=$map_h alt=\"Топографическая карта - $City2\" title=\"Топографическая карта - $City2\" src=\"$flink0\">
							   </a>";
					$src_en = "<br /><a href='/ec$idn' class=\"scale\">
								 <img width=$map_w height=$map_h alt=\"Topographic map - $City11\" title=\"Topographic map - $City11\" src=\"$flink0\">
							   </a>";
				}
				else if(file_exists($file1)){
					$src_ua = "<br /><a href='/c$idn' class=\"scale\">
								 <img width=$map_w height=$map_h alt=\"Топографічна карта - $City\" title=\"Топографічна карта - $City\" src=\"$flink1\">
							   </a>";
					$src_ru = "<br /><a href='/rc$idn' class=\"scale\">
								 <img width=$map_w height=$map_h alt=\"Топографическая карта - $City2\" title=\"Топографическая карта - $City2\" src=\"$flink1\">
							   </a>";
					$src_en = "<br /><a href='/ec$idn' class=\"scale\">
								 <img width=$map_w height=$map_h alt=\"Topographic map - $City11\" title=\"Topographic map - $City11\" src=\"$flink1\">
							   </a>";
				}
				$new_text_ua = "<table class=\"margin-top\"><tr valign=top><td align=right width=110 class=\"fcom0\">
								<h3 class=\"nforum-h3\">
									<a href=\"c$idn\"><b>$City</b></a> $src_ua
								</h3>
							</td><td align=left width=318 class=\"fcom0 td-rel forum-news\">
							<div class=\"time-mem\">$time</div>
							  <div class=\"forum-com-content\">$new_text</div>
						 </td></tr></table>";
				$new_text_ru = "<table class=\"margin-top\"><tr valign=top><td align=right width=110 class=\"fcom0\">
						<h3 class=\"nforum-h3\">
							<a href=\"rc$idn\"><b>$City2</b></a> $src_ru
						</h3>
					</td><td align=left width=318 class=\"fcom0 td-rel forum-news\">
					<div class=\"time-mem\">$time</div>
					  <div class=\"forum-com-content\">$new_text</div>
				 </td></tr></table>";
				$new_text_en = "<table class=\"margin-top\"><tr valign=top><td align=right width=110 class=\"fcom0\">
						<h3 class=\"nforum-h3\">
							<a href=\"ec$idn\"><b>$City11</b></a> $src_en
						</h3>
					</td><td align=left width=318 class=\"fcom0 td-rel forum-news\">
					<div class=\"time-mem\">$time</div>
					  <div class=\"forum-com-content\">$new_text</div>
				 </td></tr></table>";
				
                $aff = DB::table('Memory')->insert([
                    'id' => $idn, 'obl' => $obl, 'ray' => $rayc, 'Aboutec' => $new_text, 'Md' => $Md
                ]);
				
                DB::table('News')->insert([
                    'act' => "$obl", 'obl' => "$obl", 'ualine' => $new_text_ua, 'ruline' => $new_text_ru, 'enline' => $new_text_en, 'Nd' => $Md
                ]);
				
                if ($aff) {

                    $Allab = DB::table('Allcities')->select('ab', 'closers')->
                    where('id', $idn)->
                    get();
                    foreach ($Allab as $Allcab) {
                        $ab = $Allcab->ab;
                        $closers = $Allcab->closers;
                    }

                    $pagecab = explode("#!", $ab);
                    $City = $pagecab[1];
                    $City2 = $pagecab[2];
                    $status = $pagecab[5];
                    $vol_karta = $pagecab[6];
                    $City3 = $pagecab[11];
                    $domen = $pagecab[12];

                    if ($status) {
                        if ($status == 1) {
                            $statusm = "міста";
                            $statusm2 = "города";
                            $statusm3 = "City";
                        }
                        if ($status == 2) {
                            $statusm = "смт";
                            $statusm2 = "смт";
                            $statusm3 = "Town";
                        }
                        if ($status == 3) {
                            $statusm = "селища";
                            $statusm2 = "селения";
                            $statusm3 = "Village";
                        }
                        if ($status == 4) {
                            $statusm = "села";
                            $statusm2 = "села";
                            $statusm3 = "Village";
                        }
                        if ($status == 5) {
                            $statusm = "хутора";
                            $statusm2 = "хутора";
                            $statusm3 = "Hamlet";
                        }
                    } else {
                        if (!$vol_karta || $vol_karta < 20000) {
                            $statusm = "села";
                            $statusm2 = "села";
                            $statusm3 = "Village";
                        }
                        if ($vol_karta >= 20000 && $vol_karta < 50000) {
                            $statusm = "міста (села)";
                            $statusm2 = "городе (селе)";
                            $statusm3 = "Town";
                        }
                        if ($vol_karta >= 50000) {
                            $statusm = "міста";
                            $statusm2 = "города";
                            $statusm3 = "Сity";
                        }
                    }

                    echo "<br /><br />$idn Новини з $statusm $City <br>
                     Новости с $statusm2 $City2 <br />
                     News from $City3 $statusm3 <br />";
                    $closerd_q = "all";
                    if ($idn == 234 || $idn == 224 || $idn == 187 || $idn == 247 || $idn == 298 || $idn == 342 || $idn == 373 || $idn == 383 || $idn == 414 ||
                        $idn == 233 || $idn == 471 || $idn == 557 || $idn == 520 || $idn == 585 || $idn == 614 || $idn == 644 || $idn == 665 ||
                        $idn == 687 || $idn == 712 || $idn == 787 || $idn == 741 || $idn == 764 || $idn == 853 || $idn == 811 || $idn == 838 || $idn == 254) {
                        $closers = "#$idn";
                        $closerd_q = "one";
                    }

                    $closerse = explode("#", $closers);
                    $closersen = substr_count($closers, '#');
                    $allusersm = " d ";

                    if ($closersen > 0) {
                        echo "Проживаючі:";
                    }
                    for ($a = 1; $a < $closersen + 1; $a++) {
                        $allusersm = "";
                        $idm = $closerse[$a];

                        if ($closerd_q == "all") {
                            $Allu = DB::table('users')->select('Num', 'Im', 'email')
                                ->orWhere(function ($query) use ($idm) {
                                    $query->where('idc', $idm)
                                        ->orWhere('idrayc', $idm);
                                })
                                ->where('idc', '!=', $not_oblc)
                                ->where('idc', '!=', 254)
                                ->where('adm_send', '!=', '1')
                                ->WhereNotNull('email')
                                ->get();
                        }
                        if ($closerd_q == "one") {
                            $Allu = DB::table('users')->select('Num', 'Im', 'email')
                                ->where('idc', $idm)
                                ->where('adm_send', '!=', '1')
                                ->WhereNotNull('email')
                                ->get();
                        }

                        foreach ($Allu as $Alu) {
                            $Numx = $Alu->Num;
                            $Imx = $Alu->Im;
                            $mail_adminx = $Alu->email;
                            $allusersm .= " $mail_adminx";

                            $lv = last_visit_read($Numx);
                            $lan_user = $lv['lang'] ?? "ua";

                            $mail_out = $new_text_mail;
                            $br_n = substr_count($new_text_mail, "<br />");
                            if ($lan_user == "ua") {
                                $blade = "emails.city_newsme";
                                $subj = "Новини з $statusm $City";
                                if ($br_n > 1) {
                                    $mail_out = "$new_text_mail
                                 <br /> та інші новини ";
                                }
                            }
                            if ($lan_user == "ru") {
                                $blade = "emails.rcity_newsme";
                                $subj = "Новости с $statusm2 $City2";
                                if ($br_n > 1) {
                                    $mail_out = "$new_text_mail
                                 <br /> и другие новости ";
                                }
                            }
                            if ($lan_user == "en") {
                                $blade = "emails.ecity_newsme";
                                $subj = "News from $City3 $statusm3";
                                if ($br_n > 1) {
                                    $mail_out = "$new_text_mail
                                 <br /> and others news ";
                                }
                            }
                            $Pmail = trim($mail_adminx);
                            if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
                                $fcei1 = substr($Pmail, 3, 1);
                                $fcei2 = substr($Pmail, 7, 1);
                                $pas2 = "$fcei1$fcei2";

                                $details['email'] = $Pmail;
                                $details['subject'] = $subj;
                                $details['blade'] = $blade;
                                $details['det'] = array('Im' => $Imx, 'theme' => $mail_out, 'domen' => $domen, 'pas' => $pas2, 'email' => $Pmail);
                                $details['unsub'] = "<https://1ua.com.ua/admin_unsubscribe/$Pmail/$pas2>";
                                dispatch((new App\Jobs\SendEmailJob($details))->onQueue('low'));
                                echo "$Numx $Imx  $mail_adminx lan $lan_user<br />";
                            }
                        } // проживаючі

                    } // перелік сусідніх міст


                    $mailput = "forumlist$idn";
                    $q_s1[0] = ['forum', 1];
                    $q_s2[0] = ['forum', 1];
                    $q_s3[0] = ['forum', 1];

                    $filename = "sixhours.txt";
                    $truestat_file_contents = Storage::disk('public')->get($filename);
                    $lastmail = strstr($truestat_file_contents, $mailput);

                    if ($lastmail == "") {
                        $q_s2[0] = ['forum', 2];
                        Storage::disk('public')->append($filename, $mailput);
                    }

                    $filename = "oneday.txt";
                    $truestat_file_contents = Storage::disk('public')->get($filename);
                    $lastmail = strstr($truestat_file_contents, $mailput);

                    if ($lastmail == "") {
                        $q_s3[0] = ['forum', 3];
                        Storage::disk('public')->append($filename, $mailput);
                    }

                    $Allm = DB::table('Citymailpost')
                        ->orWhere(function ($query) use ($q_s1, $q_s2, $q_s3) {
                            $query->whereNull('forum')
                                ->orWhere($q_s1)
                                ->orWhere($q_s2)
                                ->orWhere($q_s3);
                        })
                        ->where('id', $idn)
                        ->select('mail_visitor')
                        ->get();

                    foreach ($Allm as $Alm) {

                        $Pmail = trim($Alm->mail_visitor);
                        if (strstr($allusersm, "$Pmail") == "") {
                            if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {

                                $mail_out = $new_text_mail;
                                $br_n = substr_count($new_text_mail, "<br />");
                                if ($br_n > 1) {
                                    $mail_out = "$new_text_mail
								 <br /> та інші новини ";
                                }

                                $details['email'] = $Pmail;
                                $details['subject'] = "Новини з $statusm $City";
                                $details['City'] = $City;
                                $details['blade'] = "emails.city_news";
                                $details['det'] = array('theme' => $mail_out, 'id' => $idn, 'domen' => $domen, 'City' => $City, 'email' => $Pmail);
                                $details['unsub'] = "<https://1ua.com.ua/unsubscribe/$Pmail/$idn>";
                                dispatch((new App\Jobs\SendEmailJob($details))->onQueue('low'));
                            }
                        }
                    } // підписники


                } // якщо вставилась новина
				
            } // перелік міст з новинами


        }

    }
}
