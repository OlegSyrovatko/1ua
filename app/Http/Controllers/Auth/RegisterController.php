<?php

namespace App\Http\Controllers\Auth;

// use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

use App\Http\Controllers\Controller;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App;
use Illuminate\Support\Facades\Mail;
use App\Rules\NoBadWords;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'Im' => ['required', 'string', 'min:3', 'max:255', new NoBadWords()],
            'Priz' => ['required', 'string', 'min:3', 'max:255', new NoBadWords()],
            'Who' => ['required', 'string', 'min:3', 'max:255', new NoBadWords()],
            'sex' => ['required', 'digits_between:1,2'],
            'obl' => ['required', 'max:2'],
            'idc' => ['required', 'max:7'],
            'Wherer' => ['required', 'string', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'readed' => ['accepted'],
        ]);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
   // protected function createNum (){
    //    return $Num;
   // }







    protected function create(array $data)
    {
         do {
           $Num = mt_rand( 1,9000000 ); $Num = $Num + 70000000 ;
         } while ( \DB::table( 'users' )->where( 'Num', $Num )->exists() );
        $id = $Num;
        $Ip = $_SERVER['REMOTE_ADDR'];

        $to = trim($data['email']);
            $fcei1 = substr($to, 3, 1); $fcei2 = substr($to, 7, 1);
            $fcii1 = substr($id, 2, 1); $fcii2 = substr($id, 4, 1); $fcii3 = substr($id, 6, 1);

        $pasm = $data['password'];
        //$lanem = $data['lanem'];

        $lanem = App::currentLocale();
          if(!$lanem){$lanem = "ua";}
        $lsend = "https://1ua.com.ua/email/confirm/$Num/$fcii1$fcei1$fcii2$fcei2$fcii3/$lanem";

        if($lanem == "ua"){
            $blade = "emails.register";
            $them = "Підтвердження реєстрації на 1ua";
            }
        if($lanem == "ru"){
            $blade = "emails.rregister";
            $them = "Подтверждение регистрации на 1ua";
        }
        if($lanem == "en"){
            $blade = "emails.eregister";
            $them = "1ua: confirmation of registration";
        }
        // $subject = "=?utf8?b?" . base64_encode($them) . "?=";

        Mail::send($blade, array('lsend' => $lsend, 'pasm' => $pasm, 'to' => $to),
            function($message) use ($to, $them) {$message->subject($them)->to($to);});

            $ctrl_hss= mb_strtolower($data['Im']);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
						$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $ctrl_hss= mb_strtolower($data['Priz']);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
						$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $ctrl_hss= mb_strtolower($data['Who']);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
						$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $ctrl_hss= mb_strtolower($data['idc']);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
						$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $ctrl_hss= mb_strtolower($data['Wherer']);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
						$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}
            $ctrl_hss= mb_strtolower($data['email']);
			if (preg_match("/<[^<]+>/", $ctrl_hss)) {exit;}
						$ctrl_hss2=$ctrl_hss.=">";
			if (preg_match("/<[^<]+>/", $ctrl_hss2)) {exit;}



        return User::create([
            'id' => $id,
            'Num' => $Num,
            'Im' => $data['Im'],
            'Priz' => $data['Priz'],
            'sex' => $data['sex'],
            'Who' => $data['Who'],
            'obl' => $data['obl'],
            'idc' => $data['idc'],
            'Wherer' => $data['Wherer'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'passw' => $pasm,
            'Md' => date('Y-n-j-H-i'),
            'Ip' => $Ip,
        ]);


    }
}
