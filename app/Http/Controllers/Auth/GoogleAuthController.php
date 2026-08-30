<?php
namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $email = $user->getEmail();
            $gid = $user->getId();
            $usertitles = $user->getName();

            $nameParts = explode(' ', $usertitles);
            if (count($nameParts) > 1) {
                $firstName = $nameParts[0];
                $lastName = implode(' ', array_slice($nameParts, 1));
            } else {
                $firstName = $nameParts[0];
                $lastName = '';
            }

            $userAvatar = $user->getAvatar();
            $highQualityAvatarUrl200 = str_replace("=s96-c", "=s200-c", "$userAvatar ");
            $highQualityAvatarUrl200 = file_get_contents($highQualityAvatarUrl200);

            $Allb0 = DB::table('users')->select('passw')->
            whereNull('google_id')->
            where('email', $email)->
            get();
            $Allbn0 = $Allb0->count();
            if ($Allbn0 == 0) {
                DB::table('users')->
                where('email', $email)->
                update(['google_id ' => $gid]);
            }


            $Allb = DB::table('users')->select('passw')->
            where('email', $email)->
            where('google_id', $gid)->
            get();
            $Allbn = $Allb->count();

            $passw = "";
            if ($Allbn > 0) {
                foreach ($Allb as $All) {
                    $passw = $All->passw;
                }
            }
            $Allb2 = DB::table('users')->select('passw')->
            where('email', $email)->
            get();
            $Allbn2 = $Allb2->count();
            if ($Allbn2 == 0) {

                do {
                    $Num = mt_rand(1, 9900000);
                    $Num = $Num + 20000000;
                } while (DB::table('users')->where('Num', $Num)->exists());
                $id = $Num;
                $Ip = $_SERVER['REMOTE_ADDR'];
                $position = strpos($email, "@");
                $psw = substr($email, 0, $position);

                // $image =  file_get_contents("https://graph.facebook.com/$fid/picture?type=large");
                if ($userAvatar) {

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
                    Storage::disk('public')->put($from_path, $highQualityAvatarUrl200);
                    $image_resize = Image::make(storage_path('app/public/tmp/' . $SRC_f0));


                    $size = getimagesize(Storage::path('public/tmp/') . $SRC_f0);
                    $w = $size[0];
                    $h = $size[1];
                    $hw = $h / $w;
                    if ($w >= 200) {
                        $new_h = round(200 * $hw);
                        $h_px = $new_h;
                        $w_px = 200;
                        $image_resize->resize(200, $new_h);
                    } else {
                        $h_px = $h;
                        $w_px = $w;
                    }
                    $path1 = $image_resize->save(Storage::path('public/avatar/b') . $SRC_f0);

                    if ($w >= 100) {
                        $new_h = round(100 * $hw);
                        $image_resize->resize(100, $new_h);
                    }
                    $path2 = $image_resize->save(Storage::path('public/avatar/') . $SRC_f0);

                    if ($w >= 50) {
                        $new_h = round(50 * $hw);
                        $image_resize->resize(50, $new_h);
                    }
                    $path3 = $image_resize->save(Storage::path('public/avatar/s') . $SRC_f0);

                    Storage::disk('public')->copy('default.txt', "last_visit/$id.txt");
                    Storage::disk('public')->prepend("last_visit/$id.txt", "#!:*&$firstName#!:*&$lastName#!:*&$Num_av#!:*&ua#!:*&/infp#!:*&$h_px");

                    if ($path1 && $path2 && $path3) {
                        Storage::disk('public')->delete($from_path);
                    }
                } else {
                    $Num_av = 0;
                    $w_px = 0;
                    $h_px = 0;
                }


                DB::table('users')->insert(['id' => $id, 'google_id' => $gid, 'Num' => $Num, 'Im' => $firstName, 'Priz' => $lastName,
                    'email' => $email, 'aktiv' => 1,
                    'avatar' => $Num_av,
                    'avx' => $w_px,'avy' => $h_px,
                    'password' => Hash::make($psw), 'passw' => $psw, 'Md' => date('Y-n-j-H-i'), 'Ip' => $Ip]);

            }


            if ($Allbn2 == 0){
//                return view('auth/login_google')->with([
//                    'email' => $email,
//                    'psw' => $psw
//                ]);
                return redirect()->route('googleauthin', ['email' => $email, 'psw' => $psw]);
            }
            if($Allbn>0 && mb_strlen($passw)>0) {
                return redirect()->route('googleauthin', ['email' => $email, 'psw' => $passw]);
            }


            // return redirect()->intended('/home');

        } catch (\Exception $e) {
            echo"$e";
            // Обробка помилки
            // return redirect('/googleauth');
        }

    }
}
