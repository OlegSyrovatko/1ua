
<?php


 // Проверяем, определено ли оно, чтобы избежать конфликтов
if( ! function_exists('my_test') ){
    function my_test(){
        return 'hello world';
    }
}

function db_date($M6){
    $secm = substr($M6, 14, 2); $hourm = substr($M6, 11, 2);  $timep="$hourm:$secm";

    $fM6 = substr($M6, 0, 10);
    $Md_tod = date('Y-m-d');
    $Md_yes = date('Y-m-d', strtotime('-1 days'));
    $Md_yes_yes = date('Y-m-d', strtotime('-2 days'));
    if($fM6==$Md_tod){$M6_e=__('messages.today'); $M6_e.= " $timep"; }
    else if($fM6==$Md_yes){$M6_e=__('messages.yesterday'); $M6_e.= " $timep";}
    else if($fM6==$Md_yes_yes){$M6_e=__('messages.yesterday2');}
    else {
        $daym = substr($M6, 8, 2); $monm = substr($M6, 5, 2); $yem = substr($M6, 0, 4);

        for ($a=0; $a<13; $a++){$aa = "$a";
            if($aa=="$monm"){ $mon_e = "messages.mmon$a"; $monm = __($mon_e); }
        }

        if(substr($daym, 0, 1)==0){$daym = substr($daym, 1, 1);}

        $M6_e="$daym $monm $yem";}
    return $M6_e;
}


function weather_date(){
    $daym = date('j');
    $monm = date('m');
    $yem = date('Y');

    for ($a=0; $a<13; $a++){$aa = "$a";
        if($aa=="$monm"){ $mon_e = "messages.mmon$a"; $monm = __($mon_e); }
    }
    if(substr($daym, 0, 1)==0){$daym = substr($daym, 1, 1);}
    $M6_e="$daym $monm $yem";
    return $M6_e;
}


function avt($avt,$Numm)
{
    $filename = "storage/last_visit/$avt.txt";
    if (file_exists($filename) && filesize($filename) > 0) {
        $whattoread = @fopen($filename, "r");
        $file_contents = fread($whattoread, filesize($filename));
        fclose($whattoread);
        $pageq = explode("#!:*&", $file_contents);
        $q_Im = $pageq[1];
        $q_Priz = $pageq[2];
        $Num_aq = $pageq[3];
        $av_height = isset($pageq[6]) ? $pageq[6] : null;
        $av_width = isset($pageq[7]) ? $pageq[7] : null;
        if (!is_int($av_height)) {$av_height="auto";}
        if (!is_int($av_width)) {$av_width=200;}

        if ($Num_aq < 10) {
            $Num_aq = 7;
        }

        $time_file = filemtime($filename);
        $time_sec=time();
        $t = $time_sec - $time_file;
        $online = "";
        if ($t <= 500 && $Numm != $avt) {
            $online = "online";
        }
        $pref_page = __('messages.pref_page'); $ppref_page = $pref_page .="i";

        $user_icon = generateUserIcon($Num_aq, $q_Im, $q_Priz, "forum", $av_width, $av_height, $online);
        $aavt = "<a href=/$ppref_page$avt>$user_icon <b>$q_Im $q_Priz</b></a>";

    } else {
        $aavt = "";
    }
    return $aavt;
}



function getDescriptionAttribute($string) {
    $pattern = "~(https?://\S+)|([^\s@]+@[^\s@]+)|(\+\d+)~";

    return preg_replace_callback($pattern, function($matches) {

        $template = '<a href="%1$s%2$s" rel="noopener nofollow" target="_blank">%2$s</a>';

        if ($matches[1] !== "") return sprintf($template, "", $matches[1]);
        if ($matches[2] !== "") return sprintf($template, "mailto:", $matches[2]);
        if ($matches[3] !== "") return sprintf($template, "tel:", $matches[3]);
    }, $string);
}


function my_load()
{
    $load = sys_getloadavg();
    $vvv = $load[0]; echo"n $vvv";
}


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
/*
function my_avatar($fid,$id,$first_namef,$last_name)
{
    $image =  file_get_contents("https://graph.facebook.com/$fid/picture?type=large");
    if($image){

        $a = 0;
        while ($a < 2) {
            $a = 0;
            $Num_av = round(rand(1, 9000000));
            $Num_av = $Num_av + 10000000;
            $SRC_f = "/avatar/$Num_av.jpg";
            $SRC_fb = "/avatar/b$Num_av.jpg";
            $SRC_f0 = "$Num_av.jpg";
            if (Storage::disk('public')->exists($SRC_f)) {
                $msg = "<P> Файл $Num_av не створений!  </p>";
            } else {
                $msg = "<P> Файл $Num_av створений!</p>";
                $a = 2;
            }
            $a++;
        }

        $SRC_f0 = "$Num_av.jpg";
        $from_path = "tmp/$Num_av.jpg";
        Storage::disk('public')->put($from_path, $image);
		$image_resize = Image::make(storage_path('app/public/tmp/'.$SRC_f0));

        Storage::disk('public')->copy('default.txt', "last_visit/$id.txt");
        Storage::disk('public')->prepend("last_visit/$id.txt", "#!:*&$first_namef#!:*&$last_name#!:*&$Num_av#!:*&ua#!:*&/infp");

        $size = getimagesize(Storage::path('public/tmp/') . $SRC_f0);
		$w = $size[0];
		$h = $size[1];
		$hw = $h / $w;

		if ($w > 200) {
			$new_h = round(200 * $hw);
			$image_resize->resize(200, $new_h);
		}
		 $path1 = $image_resize->save(Storage::path('public/avatar/b') . $SRC_f0);

		if ($w > 100) {
			$new_h = round(100 * $hw);
			$image_resize->resize(100, $new_h);
		}
		 $path2 = $image_resize->save(Storage::path('public/avatar/') . $SRC_f0);

		if ($w > 50) {
			$new_h = round(50 * $hw);
			$image_resize->resize(50, $new_h);
		}
		 $path3 = $image_resize->save(Storage::path('public/avatar/s') . $SRC_f0);

		if ($path1 && $path2 && $path3) {
			Storage::disk('public')->delete($from_path);
		}
    }
    else{$Num_av=0;}
    return $Num_av;

}


function getKatalogfaceAmazon($katalog, $katalogb)
{
    $key = 'katalog_face_' . $katalog;

    if (Cache::has($key)) {
        $katalog_main = Cache::get($key);
    }
    else {
        $katalog_main = Cache::remember($key, 86400, function () use ($katalog, $katalogb) {
            if (Storage::disk('s3')->exists($katalog)) {
                $ref = Storage::disk('s3')->url($katalog);
            }
            else if (Storage::disk('s3')->exists($katalogb)) {
                $ref = Storage::disk('s3')->url($katalogb);
            }
            else {
                $ref = "/images/no_photo_s.jpg";
            }

            $ref = str_replace("http:", "https:", $ref);

            return [
                'katalog' => $ref,
            ];
        });
    }

    return $katalog_main['katalog'];
}


function getKatalogs($katalogs, $katalog)
{
	$key = 'katalog_s_' . $katalogs;

	if (Cache::has($key)) {
		$katalog_main = Cache::get($key);
	}
	else {
		$katalog_main = Cache::remember($key, 86400, function () use ($katalogs, $katalog) {
			if (Storage::disk('s3')->exists($katalogs)) {
				$ref = Storage::disk('s3')->url($katalogs);
			}
			else if (Storage::disk('s3')->exists($katalog)) {
				$ref = Storage::disk('s3')->url($katalog);
			}
			else {
				$ref = "/images/no_photo_s.jpg";
			}

			$ref = str_replace("http:", "https:", $ref);
	
			return [
				'katalogs' => $ref,
			];
		});
	}

	return $katalog_main['katalogs'];
}

function getKatalog($katalog)
{
	$key = 'katalog_' . $katalog;

	if (Cache::has($key)) {
		$katalog_main = Cache::get($key);
	}
	else {
		$katalog_main = Cache::remember($key, 86400, function () use ($katalog) {
			if (Storage::disk('s3')->exists($katalog)) {
				$ref = Storage::disk('s3')->url($katalog);
			}
			else {
				$ref = "https://1ua.com.ua/images/no_photo.jpg";
			}

			$ref = str_replace("http:", "https:", $ref);

			return [
				'katalog' => $ref,
			];
		});
	}

	return $katalog_main['katalog'];
}

*/
function getKatalogface($katalog, $katalogb)
{
    try {
        if (Storage::disk('public')->exists($katalog)) {
            $ref = Storage::disk('public')->url($katalog);
        } elseif (Storage::disk('public')->exists($katalogb)) {
            $ref = Storage::disk('public')->url($katalogb);
        } else {
            $ref = "/images/no_photo_s.jpg";
        }
    } catch (\Throwable $e) {
        $ref = "/images/no_photo_s.jpg";
    }

    return str_replace("http:", "https:", $ref);
}

function getKatalogs($katalogs, $katalog)
{
    try {
        if (Storage::disk('public')->exists($katalogs)) {
            $ref = Storage::disk('public')->url($katalogs);
        } elseif (Storage::disk('public')->exists($katalog)) {
            $ref = Storage::disk('public')->url($katalog);
        } else {
            $ref = "/images/no_photo_s.jpg";
        }
    } catch (\Throwable $e) {
        $ref = "/images/no_photo_s.jpg";
    }

    return str_replace("http:", "https:", $ref);
}

function getKatalog($katalog)
{
    try {
        if (Storage::disk('public')->exists($katalog)) {
            $ref = Storage::disk('public')->url($katalog);
        } else {
            $ref = "https://1ua.com.ua/images/no_photo.jpg";
        }
    } catch (\Throwable $e) {
        $ref = "https://1ua.com.ua/images/no_photo.jpg";
    }

    return str_replace("http:", "https:", $ref);
}



function generateUserIcon($Num_a, $Im, $Priz, $place, $av_width, $av_height, $online)
{

    $user_1ua = __('messages.user_1ua');


    $fill="#111";
    $online_e = "";
    $online_class="";
    if($online == "online"){
        $online_class = "av-conteiner-online";
        $fill="#3B9947";
        $online_e = __('messages.online');
    }

    if ($Num_a <10){
        $user_icon = "<svg style=\"border-radius: 50%;  fill:$fill;\" class='forum-avatar av-shadow' width=\"50\" height=\"50\" aria-label=\"$Priz $Im, $user_1ua $online_e\">
            <use href=\"/images/icons.svg#icon-username\"></use>
        </svg>";
    }
    else{

        if($place == "forum"){
            $user_icon = "<div class='scale forum-avatar av-shadow av-conteiner $online_class'>
                <img width=\"50\" height=\"50\" class='img-container' alt=\"$Priz $Im, $user_1ua $online_e\" src=\"/storage/avatar/$Num_a.jpg\">
            </div>";
        }
        else if($place == "center"){
            $user_icon = "<div class='scale center-avatar av-shadow av-conteiner $online_class'>
                <img width=\"50\" height=\"50\" class='img-container' alt=\"$Priz $Im, $user_1ua $online_e\" src=\"/storage/avatar/$Num_a.jpg\">
            </div>";
        }
        else{
            $user_icon = "<div class='scale av-shadow av-conteiner'>
                <img width=\"50\" height=\"50\" class='img-container' alt=\"$Priz $Im, $user_1ua $online_e\" src=\"/storage/avatar/$Num_a.jpg\">
            </div>";
        }
    }

    return $user_icon;
}



function sharing($Namef, $design, $page){
    $lan = __('messages.lan');
    if ($lan == "en") {
        $pr = "e";
    } else if ($lan == "ru") {
        $pr = "r";
    } else {
        $pr = "";
    }

    $sh_link = "https%3A%2F%2F1ua.com.ua%2F";
    $sh_link .= $pr;
    $sh_link .= $page;
    $sh_link .= $Namef;

    $l_size = 22;
    $ll_size = 25;
    if ($design == "alone") {
        $l_size = 30;
        $ll_size = 32;
    }

    $sharing = "<noindex class=\"social-madia\">
                <a target=\"_blank\" style=\"margin-top: -2px;\" aria-label=\" . __('messages.share-fb') . \" href=\"https://www.facebook.com/sharer.php?u={{$sh_link}}\">
                    <svg id=facebook width=$ll_size height=$ll_size><use href=\"/images/icons.svg#icon-facebook\"></use></svg>
                </a>
                <a target=\"_blank\" aria-label=\" . __('messages.share-tg') . \" href=\"https://telegram.me/share/url?url=$sh_link\">
                    <svg id=telegram width=$l_size height=$l_size><use href=\"/images/icons.svg#icon-telegram\"></use></svg>
                </a>
                <a target=\"_blank\" aria-label=\" . __('messages.share-vb') . \" href=\"viber://forward?text=$sh_link\">
                    <svg id=viber width=$l_size height=$l_size><use href=\"/images/icons.svg#icon-viber\"></use></svg>
                </a>
                <a target=\"_blank\" aria-label=\" . __('messages.share-tt') . \" href=\"https://twitter.com/intent/tweet?url=$sh_link\">
                    <svg id=twitter width=$l_size height=$l_size><use href=\"/images/icons.svg#icon-twitter\"></use></svg>
                </a>
                <a target=\"_blank\" aria-label=\" . __('messages.share-wu') . \" href=\"https://api.whatsapp.com/send?text=$sh_link\">
                    <svg id=whatsapp width=$l_size height=$l_size><use href=\"/images/icons.svg#icon-whatsapp\"></use></svg>
                </a>
            </noindex>";
    return $sharing;
}

