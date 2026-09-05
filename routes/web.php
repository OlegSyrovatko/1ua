<?php
// use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\GoogleAuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



/*
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/contact/all/{id}',
    'App\Http\Controllers\ContController@ShowOneMessage'
)->name('contact-data-one');

Route::get('/contact/all/{id}/update',
    'App\Http\Controllers\ContController@updateMessage'
)->name('contact-update');

Route::post('/contact/all/{id}/update',
    'App\Http\Controllers\ContController@updateMessageSubmit'
)->name('contact-update-submit');

Route::get('/contact/all/{id}/delete',
    'App\Http\Controllers\ContController@deleteMessage'
)->name('contact-delete');

Route::get('/contact/all', 'App\Http\Controllers\ContController@allData')->name('contact-data');
Route::post('/contact/submit', 'App\Http\Controllers\ContController@smt')->name('contact-form');
*/



Route::get('/ua', function () {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('index'); });
Route::get('/ru', function () {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('index'); });
Route::get('/en', function () {session(['my_locale' => 'en']);App::setLocale('en'); return view('index'); });

Route::get('/register/ua', function () {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('auth/register'); });
Route::get('/register/ru', function () {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('auth/register'); });
Route::get('/register/en', function () {session(['my_locale' => 'en']);App::setLocale('en'); return view('auth/register'); });

Route::get('/login/ua', function () {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('auth/login'); });
Route::get('/login/ru', function () {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('auth/login'); });
Route::get('/login/en', function () {session(['my_locale' => 'en']);App::setLocale('en'); return view('auth/login'); });

Route::get('/googleauthin/{email}/{psw}', function ($email, $psw) {
    return view('auth/login_google', ['email' => $email, 'psw' => $psw]);
})->name('googleauthin');

Route::get('/rules/ua', function () {return view('rules'); });
Route::get('/rules/ru', function () {return view('rrules'); });
Route::get('/rules/en', function () {return view('erules'); });

Route::get('/policy/ua', function () {return view('policy'); });
Route::get('/policy/ru', function () {return view('rpolicy'); });
Route::get('/policy/en', function () {return view('epolicy'); });

Route::get('/email/confirm/{id}/{key}/{lanem}', 'App\Http\Controllers\AddScriptController@emailconfirm');


Route::group(['middleware'=>'language'],function ()
{

    Route::get('/', function () { return view('index'); });
    Route::get('/test', function () { return view('test'); });
    Auth::routes();

    Route::post('rayc', 'App\Http\Controllers\AddScriptController@rayc');
    Route::post('idc', 'App\Http\Controllers\AddScriptController@idc');

    // тимч. скрипт для експорту паролів
    Route::post('passw', 'App\Http\Controllers\AddScriptController@addpassword');

    Route::post('emailremind', 'App\Http\Controllers\AddScriptController@emailremind');
    Route::get('/password/{id}/{key}', function () {return view('/auth/passwords/newpassword');});
    Route::post('setpassw', 'App\Http\Controllers\AddScriptController@setpassw');
    Route::post('ch_reg', 'App\Http\Controllers\AddScriptController@ch_reg');
    Route::post('ch_eml_lgn', 'App\Http\Controllers\AddScriptController@ch_eml_lgn');
    Route::get('/emlupd/{id}/{email}/{key}', function () {return view('/auth/new_emale');});

    Route::get('/googleauth', [GoogleAuthController::class, 'redirectToGoogle']);
    Route::get('/googleauth/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

    Route::post('ch_domen', 'App\Http\Controllers\AddScriptController@ch_domen');
    Route::post('setnews', 'App\Http\Controllers\AddScriptController@setnews');
    Route::post('ch_data', 'App\Http\Controllers\AddScriptController@ch_data');
    Route::post('avload', 'App\Http\Controllers\AddScriptController@avload');
    Route::post('del_ava', 'App\Http\Controllers\AddScriptController@del_ava');
    Route::post('chadrr', 'App\Http\Controllers\AddScriptController@chadrr');
    Route::post('setprivate', 'App\Http\Controllers\AddScriptController@setprivate');
    Route::post('del_all_followers', 'App\Http\Controllers\AddScriptController@del_all_followers');
    Route::post('setnote', 'App\Http\Controllers\AddScriptController@setnote');
    Route::post('setonline', 'App\Http\Controllers\AddScriptController@setonline');
    Route::post('up_vote', 'App\Http\Controllers\AddScriptController@up_vote');
    Route::post('up_votec', 'App\Http\Controllers\AddScriptController@up_votec');
    Route::post('question_inc', 'App\Http\Controllers\AddScriptController@question_inc');
    Route::post('question_inp', 'App\Http\Controllers\AddScriptController@question_inp');
    Route::post('load_notice', 'App\Http\Controllers\AddScriptController@load_notice');
    Route::post('del_notice', 'App\Http\Controllers\AddScriptController@del_notice');
    Route::post('ban_qc', 'App\Http\Controllers\AddScriptController@ban_qc');
    Route::post('del_qc', 'App\Http\Controllers\AddScriptController@del_qc');
    Route::post('ask_publc', 'App\Http\Controllers\AddScriptController@ask_publc');
    Route::post('ban_qp', 'App\Http\Controllers\AddScriptController@ban_qp');
    Route::post('del_qp', 'App\Http\Controllers\AddScriptController@del_qp');
    Route::post('ask_publp', 'App\Http\Controllers\AddScriptController@ask_publp');
    Route::post('mailadd', 'App\Http\Controllers\AddScriptController@mailadd');
    Route::post('mailchange', 'App\Http\Controllers\AddScriptController@mailchange');
    Route::post('mailchangeset', 'App\Http\Controllers\AddScriptController@mailchangeset');
    Route::post('maildel', 'App\Http\Controllers\AddScriptController@maildel');
    Route::post('mailaddc', 'App\Http\Controllers\AddScriptController@mailaddc');
    Route::post('mailchangec', 'App\Http\Controllers\AddScriptController@mailchangec');
    Route::post('mailchangecset', 'App\Http\Controllers\AddScriptController@mailchangecset');
    Route::post('maildelc', 'App\Http\Controllers\AddScriptController@maildelc');
    Route::post('maildelc', 'App\Http\Controllers\AddScriptController@maildelc');
    Route::post('delmc', 'App\Http\Controllers\AddScriptController@delmc');
    Route::post('fastenc', 'App\Http\Controllers\AddScriptController@fastenc');
    Route::post('delmp', 'App\Http\Controllers\AddScriptController@delmp');
    Route::post('fastenp', 'App\Http\Controllers\AddScriptController@fastenp');
    Route::post('memc', 'App\Http\Controllers\AddScriptController@memc');
    Route::post('memp', 'App\Http\Controllers\AddScriptController@memp');
    Route::post('sml_in', 'App\Http\Controllers\smlController@sml');
    Route::post('sml_add', 'App\Http\Controllers\smlController@sml_add');
    Route::post('mem_add', 'App\Http\Controllers\AddScriptController@mem_add');
    Route::post('mem_addp', 'App\Http\Controllers\AddScriptController@mem_addp');
    Route::post('radar', 'App\Http\Controllers\AddScriptController@radar');
    Route::post('max_alb', 'App\Http\Controllers\AddFotoController@max_alb');
    Route::post('max_albp', 'App\Http\Controllers\AddFotoController@max_albp');
    Route::post('red_alb', 'App\Http\Controllers\AddFotoController@red_alb');
    Route::post('red_albp', 'App\Http\Controllers\AddFotoController@red_albp');
    Route::post('do_red_alb', 'App\Http\Controllers\AddFotoController@do_red_alb');
    Route::post('do_red_albp', 'App\Http\Controllers\AddFotoController@do_red_albp');
    Route::post('all_ac', 'App\Http\Controllers\AddFotoController@all_ac');
    Route::post('all_ap', 'App\Http\Controllers\AddFotoController@all_ap');
    Route::post('abf', 'App\Http\Controllers\AddFotoController@abf');
    Route::post('abfp', 'App\Http\Controllers\AddFotoController@abfp');
    Route::post('abf_comments', 'App\Http\Controllers\AddFotoController@abf_comments');
    Route::post('abfp_comments', 'App\Http\Controllers\AddFotoController@abfp_comments');
    Route::post('news_rating_state', 'App\Http\Controllers\AddFotoController@news_rating_state');
    Route::post('comm_allowp', 'App\Http\Controllers\AddFotoController@comm_allowp');
    Route::post('comment_c', 'App\Http\Controllers\AddFotoController@comment_c');
    Route::post('comment_p', 'App\Http\Controllers\AddFotoController@comment_p');
    Route::post('foto', 'App\Http\Controllers\AddFotoController@foto');
    Route::post('fotop', 'App\Http\Controllers\AddFotoController@fotop');
    Route::post('red_foto', 'App\Http\Controllers\AddFotoController@red_foto');
    Route::post('red_fotop', 'App\Http\Controllers\AddFotoController@red_fotop');
    Route::post('do_red_foto', 'App\Http\Controllers\AddFotoController@do_red_foto');
    Route::post('do_red_fotop', 'App\Http\Controllers\AddFotoController@do_red_fotop');
    Route::post('face_fc', 'App\Http\Controllers\AddFotoController@face_fc');
    Route::post('face_fp', 'App\Http\Controllers\AddFotoController@face_fp');
    Route::post('publ_fc', 'App\Http\Controllers\AddFotoController@publ_fc');
    Route::post('publ_fp', 'App\Http\Controllers\AddFotoController@publ_fp');
    Route::post('load_foto', 'App\Http\Controllers\AddFotoController@load_foto');
    Route::post('load_fotop', 'App\Http\Controllers\AddFotoController@load_fotop');
    Route::post('load_obl_news', 'App\Http\Controllers\AddFotoController@load_obl_news');
    Route::post('load_map_village', 'App\Http\Controllers\AddFotoController@load_map_village');
    Route::post('hero_hide_foto', 'App\Http\Controllers\AddFotoController@hero_hide_foto');
    Route::post('del_foto', 'App\Http\Controllers\AddFotoController@del_foto');
    Route::post('del_fotop', 'App\Http\Controllers\AddFotoController@del_fotop');
    Route::post('del_alb', 'App\Http\Controllers\AddFotoController@del_alb');
    Route::post('del_albp', 'App\Http\Controllers\AddFotoController@del_albp');
    Route::post('fview', 'App\Http\Controllers\AddFotoController@fview');
    Route::post('rate_add', 'App\Http\Controllers\AddFotoController@rate_add');
    Route::post('rate_addp', 'App\Http\Controllers\AddFotoController@rate_addp');
    Route::post('rate_h', 'App\Http\Controllers\AddFotoController@rate_h');
    Route::post('rate_hp', 'App\Http\Controllers\AddFotoController@rate_hp');
    Route::post('rate_addm', 'App\Http\Controllers\AddScriptController@rate_addm');
    Route::post('rate_addmp', 'App\Http\Controllers\AddScriptController@rate_addmp');
    Route::post('rate_hm', 'App\Http\Controllers\AddScriptController@rate_hm');
    Route::post('rate_hmp', 'App\Http\Controllers\AddScriptController@rate_hmp');
    Route::post('comm_add', 'App\Http\Controllers\AddFotoController@comm_add');
    Route::post('comm_addp', 'App\Http\Controllers\AddFotoController@comm_addp');
    Route::post('comm_red', 'App\Http\Controllers\AddFotoController@comm_red');
    Route::post('comm_redp', 'App\Http\Controllers\AddFotoController@comm_redp');
    Route::post('comm_del', 'App\Http\Controllers\AddFotoController@comm_del');
    Route::post('comm_delp', 'App\Http\Controllers\AddFotoController@comm_delp');
    Route::post('commm_add', 'App\Http\Controllers\AddScriptController@commm_add');
    Route::post('commm_addp', 'App\Http\Controllers\AddScriptController@commm_addp');
    Route::post('commm_red', 'App\Http\Controllers\AddScriptController@commm_red');
    Route::post('commm_redp', 'App\Http\Controllers\AddScriptController@commm_redp');
    Route::post('commm_del', 'App\Http\Controllers\AddScriptController@commm_del');
    Route::post('commm_delp', 'App\Http\Controllers\AddScriptController@commm_delp');
    Route::post('del_adm', 'App\Http\Controllers\AddScriptController@del_adm');
    Route::post('adm_pages', 'App\Http\Controllers\AddScriptController@adm_pages');
    Route::post('be_admin', 'App\Http\Controllers\AddScriptController@be_admin');
    Route::post('del_adm2', 'App\Http\Controllers\AddScriptController@del_adm2');
    Route::post('confirm', 'App\Http\Controllers\AddScriptController@confirm');
    Route::post('stat', 'App\Http\Controllers\AddScriptController@stat');
    Route::post('news', 'App\Http\Controllers\AddScriptController@news');
    Route::post('top_ask', 'App\Http\Controllers\AddScriptController@top_ask');
    Route::post('answer_interview', 'App\Http\Controllers\AddScriptController@answer_interview');
    Route::post('top_askp', 'App\Http\Controllers\AddScriptController@top_askp');
    Route::post('answer_interviewp', 'App\Http\Controllers\AddScriptController@answer_interviewp');
    Route::post('ipban', 'App\Http\Controllers\AddScriptController@ipban');
    Route::post('user_ban', 'App\Http\Controllers\AddScriptController@user_ban');
    Route::post('user_ban_del', 'App\Http\Controllers\AddScriptController@user_ban_del');
    Route::post('user_banp', 'App\Http\Controllers\AddScriptController@user_banp');
    Route::post('user_ban_delp', 'App\Http\Controllers\AddScriptController@user_ban_delp');
    Route::post('q_a_i', 'App\Http\Controllers\AddScriptController@q_a_i');
    Route::post('rec', 'App\Http\Controllers\AddFotoController@rec');
    Route::post('life_sitemap', 'App\Http\Controllers\AddScriptController@life_sitemap');

    Route::post('mrec', 'App\Http\Controllers\AddFotoController@mrec');
    Route::post('m_no_rec', 'App\Http\Controllers\AddFotoController@m_no_rec');


    Route::post('fotoonmap', 'App\Http\Controllers\AddFotoController@fotoonmap');
    Route::post('guesp', 'App\Http\Controllers\AddFotoController@guesp');
    Route::post('guesc', 'App\Http\Controllers\AddFotoController@guesc');
    Route::post('fguesp', 'App\Http\Controllers\AddFotoController@fguesp');
    Route::post('fguesc', 'App\Http\Controllers\AddFotoController@fguesc');
    Route::post('guesp_del', 'App\Http\Controllers\AddFotoController@guesp_del');
    Route::post('guesc_del', 'App\Http\Controllers\AddFotoController@guesc_del');
    Route::post('fguesp_del', 'App\Http\Controllers\AddFotoController@fguesp_del');
    Route::post('fguesc_del', 'App\Http\Controllers\AddFotoController@fguesc_del');
    Route::post('life', 'App\Http\Controllers\AddScriptController@life');
    Route::post('status', 'App\Http\Controllers\AddScriptController@status');

    Route::get('stats_obl', 'App\Http\Controllers\AddScriptController@stats_obl');
    Route::get('stats_ray', 'App\Http\Controllers\AddScriptController@stats_ray');
    Route::get('stats_id', 'App\Http\Controllers\AddScriptController@stats_id');

    Route::get('/admin_unsubscribe/{email}/{pas}', function ($email,$pas) {
        return view('admin_unsubscribe', ['email' => $email,'pas' => $pas]);});
    Route::get('/unsubscribe/{email}/{id}', function ($email,$id) {
        return view('unsubscribe', ['email' => $email,'id' => $id]);})->where('id', '[0-9]+');
    Route::get('/settings', function () {return view('adm');});
    Route::get('/home', function () {return view('home');});
    Route::get('/fb_reg', function () {return view('auth/fb_reg');});
    Route::get('/spid{id}', function ($id) { return view('infp', ['id' => $id,'idc' => '0','obl' => '0','sort' => 'rate']);})->where('id', '[0-9]+');
    Route::post('/infp', function () {return view('infp', ['id' => '0']);})->name('infp_seek');
    Route::post('/searc', function () {return view('searc');})->name('searc_seek');
    Route::get('/adm/{id}', function ($id) {return view('admc', ['id' => $id]);})->where('id', '[0-9]+');


    Route::post('frie', 'App\Http\Controllers\LoadController@frie');
    Route::post('add_fr', 'App\Http\Controllers\LoadController@add_fr');
    Route::post('del_fr', 'App\Http\Controllers\LoadController@del_fr');
    Route::post('ref_fr', 'App\Http\Controllers\LoadController@ref_fr');
    Route::post('redo', 'App\Http\Controllers\LoadController@redo');

	Route::post('weather', 'App\Http\Controllers\LoadController@weather');
	Route::post('weather_now', 'App\Http\Controllers\LoadController@weather_now');


    Route::get('get-cities', 'App\Http\Controllers\AddScriptController@getCities');

});


Route::get('/sitemap.xml', 'App\Http\Controllers\LoadController@sitemap');

Route::get('/sm/{sm}', function ($sm) {return view('sm', ['sm' => $sm]);})->where('sm', '[a-zA-Z0-9\.]+');

Route::get('/send-email', 'App\Http\Controllers\FeedbackController@send');
Route::get('/ssend-email', 'App\Http\Controllers\ShippedController@send');
Route::get('email-test', function() {
    $details['email'] = 'v74799782@gmail.com'; // sirov@ukr.net
    $details['subj'] = 'my subj';
    dispatch(new App\Jobs\SendEmailJob($details));
    dd('done');
});
Route::get('/obl_news', function () {return view('obl_news');});
Route::get('/map_village', function () {return view('map_village');});

Route::get('/settings/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'ua', 'ru'])) { abort(400); }
       session(['my_locale' => $locale]);
      App::setLocale($locale); return view('adm');
});

Route::get('/lifeua/{topic}', function ($topic) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('lifeall', ['topic' => $topic]);})->where('topic', '[a-z_-]+');
Route::get('/liferu/{topic}', function ($topic) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('lifeall', ['topic' => $topic]);})->where('topic', '[a-z_-]+');

Route::get('/lifeua/{npass1}', function ($npass1) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('blogall', ['npass1' => $npass1]);})->where('npass1', '[0-9]+');
Route::get('/liferu/{npass1}', function ($npass1) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('blogall', ['npass1' => $npass1]);})->where('npass1', '[0-9]+');
Route::get('/lifeua', function () {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('blogall', ['npass1' => 1]);});
Route::get('/liferu', function () {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('blogall', ['npass1' => 1]);});


Route::get('/gps/{nf}', function ($nf) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('gps', ['nf' => $nf]);})->where('nf', '[0-9]+');
Route::get('/rgps/{nf}', function ($nf) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('gps', ['nf' => $nf]);})->where('nf', '[0-9]+');
Route::get('/egps/{nf}', function ($nf) {session(['my_locale' => 'en']);App::setLocale('en'); return view('gps', ['nf' => $nf]);})->where('nf', '[0-9]+');
Route::get('/mgps/{id}', function ($id) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('mgps', ['id' => $id]);})->where('nf', '[0-9]+');
Route::get('/cgps/{id}', function ($id) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('cgps', ['id' => $id]);});


Route::get('/seestatadmf/{nav}', function ($nav) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('seestatadmf', ['nav' => $nav]);})->where('nav', '[0-9]+');
Route::get('/rseestatadmf/{nav}', function ($nav) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('seestatadmf', ['nav' => $nav]);})->where('nav', '[0-9]+');
Route::get('/eseestatadmf/{nav}', function ($nav) {session(['my_locale' => 'en']);App::setLocale('en'); return view('seestatadmf', ['nav' => $nav]);})->where('nav', '[0-9]+');

Route::get('/seestatadmc/{nav}', function ($nav) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('seestatadmc', ['nav' => $nav]);})->where('nav', '[0-9]+');
Route::get('/rseestatadmc/{nav}', function ($nav) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('seestatadmc', ['nav' => $nav]);})->where('nav', '[0-9]+');
Route::get('/eseestatadmc/{nav}', function ($nav) {session(['my_locale' => 'en']);App::setLocale('en'); return view('seestatadmc', ['nav' => $nav]);})->where('nav', '[0-9]+');


Route::get('/spo{obl}', function ($obl) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('infp', ['idc' => '0','id' => '0','obl' => $obl,'sort' => 'rate']);})->where('obl', '[0-9]+');
Route::get('/rspo{obl}', function ($obl) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('infp', ['idc' => '0','id' => '0','obl' => $obl,'sort' => 'rate']);})->where('obl', '[0-9]+');
Route::get('/espo{obl}', function ($obl) {session(['my_locale' => 'en']);App::setLocale('en'); return view('infp', ['idc' => '0','id' => '0','obl' => $obl,'sort' => 'rate']);})->where('obl', '[0-9]+');
Route::get('/sp{idc}', function ($idc) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('infp', ['idc' => $idc,'id' => '0','obl' => '0','sort' => 'rate']);})->where('idc', '[0-9]+');
Route::get('/rsp{idc}', function ($idc) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('infp', ['idc' => $idc,'id' => '0','obl' => '0','sort' => 'rate']);})->where('idc', '[0-9]+');
Route::get('/esp{idc}', function ($idc) {session(['my_locale' => 'en']);App::setLocale('en'); return view('infp', ['idc' => $idc,'id' => '0','obl' => '0','sort' => 'rate']);})->where('idc', '[0-9]+');
Route::get('/infp', function () {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('infp');});
Route::get('/rinfp', function () {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('infp');});
Route::get('/einfp', function () {session(['my_locale' => 'en']);App::setLocale('en'); return view('infp');});

Route::get('/sed{idcc}', function ($idcc) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('searc', ['idcc' => $idcc,'obl' => '0','sort' => 'sumr']);})->where('idcc', '[0-9]+');
Route::get('/rsed{idcc}', function ($idcc) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('searc', ['idcc' => $idcc,'obl' => '0','sort' => 'sumr']);})->where('idcc', '[0-9]+');
Route::get('/esed{idcc}', function ($idcc) {session(['my_locale' => 'en']);App::setLocale('en'); return view('searc', ['idcc' => $idcc,'obl' => '0','sort' => 'sumr']);})->where('idcc', '[0-9]+');
Route::get('/se{oblc}', function ($oblc) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('searc', ['idc' => '0','obl' => $oblc,'sort' => 'sumr']);})->where('oblc', '[0-9]+');
Route::get('/rse{oblc}', function ($oblc) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('searc', ['idc' => '0','obl' => $oblc,'sort' => 'sumr']);})->where('oblc', '[0-9]+');
Route::get('/ese{oblc}', function ($oblc) {session(['my_locale' => 'en']);App::setLocale('en'); return view('searc', ['idc' => '0','obl' => $oblc,'sort' => 'sumr']);})->where('oblc', '[0-9]+');
Route::get('/searc', function () {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('searc');});
Route::get('/rsearc', function () {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('searc');});
Route::get('/esearc', function () {session(['my_locale' => 'en']);App::setLocale('en'); return view('searc');});

Route::get('mc{idc}', function ($id) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('mview', ['id' => $id]);})->where('id', '[0-9]+');
Route::get('rmc{idc}', function ($id) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('mview', ['id' => $id]);})->where('id', '[0-9]+');
Route::get('emc{idc}', function ($id) {session(['my_locale' => 'en']);App::setLocale('en'); return view('mview', ['id' => $id]);})->where('id', '[0-9]+');

Route::get('c{idc}', function ($idc) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('c', ['id' => $idc,'domen' => 0]);})->where('idc', '[0-9]+');
Route::get('rc{idc}', function ($idc) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('c', ['id' => $idc,'domen' => 0]);})->where('idc', '[0-9]+');
Route::get('ec{idc}', function ($idc) {session(['my_locale' => 'en']);App::setLocale('en'); return view('c', ['id' => $idc,'domen' => 0]);})->where('idc', '[0-9]+');

Route::get('i{id}', function ($id) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('i', ['id' => $id,'domen' => 0]);})->where('id', '[0-9]+');
Route::get('ri{id}', function ($id) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('i', ['id' => $id,'domen' => 0]);})->where('id', '[0-9]+');
Route::get('ei{id}', function ($id) {session(['my_locale' => 'en']);App::setLocale('en'); return view('i', ['id' => $id,'domen' => 0]);})->where('id', '[0-9]+');

Route::get('friends/{id}/{sort}', function ($id,$sort) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('friends', ['purp' => 'friends','id' => $id,'sort' => $sort]);})->where('id', '[0-9]+');
Route::get('rfriends/{id}/{sort}', function ($id,$sort) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('friends', ['purp' => 'friends','id' => $id,'sort' => $sort]);})->where('id', '[0-9]+');
Route::get('efriends/{id}/{sort}', function ($id,$sort) {session(['my_locale' => 'en']);App::setLocale('en'); return view('friends', ['purp' => 'friends','id' => $id,'sort' => $sort]);})->where('id', '[0-9]+');
Route::get('ourfriends/{id}/{sort}', function ($id,$sort) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('friends', ['purp' => 'ourfriends','id' => $id,'sort' => $sort]);})->where('id', '[0-9]+');
Route::get('rourfriends/{id}/{sort}', function ($id,$sort) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('friends', ['purp' => 'ourfriends','id' => $id,'sort' => $sort]);})->where('id', '[0-9]+');
Route::get('eourfriends/{id}/{sort}', function ($id,$sort) {session(['my_locale' => 'en']);App::setLocale('en'); return view('friends', ['purp' => 'ourfriends','id' => $id,'sort' => $sort]);})->where('id', '[0-9]+');
Route::get('infriends/{id}/{sort}', function ($id,$sort) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('friends', ['purp' => 'infriends','id' => $id,'sort' => $sort]);})->where('id', '[0-9]+');
Route::get('rinfriends/{id}/{sort}', function ($id,$sort) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('friends', ['purp' => 'infriends','id' => $id,'sort' => $sort]);})->where('id', '[0-9]+');
Route::get('einfriends/{id}/{sort}', function ($id,$sort) {session(['my_locale' => 'en']);App::setLocale('en'); return view('friends', ['purp' => 'infriends','id' => $id,'sort' => $sort]);})->where('id', '[0-9]+');


Route::get('fc{idfc}', function ($idfc) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fc', ['id' => $idfc,'domen' => 0,'album' => '0','namef' => '0']);})->where('idfc', '[0-9]+');
Route::get('rfc{idfc}', function ($idfc) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('fc', ['id' => $idfc,'domen' => 0,'album' => '0','namef' => '0']);})->where('idfc', '[0-9]+');
Route::get('efc{idfc}', function ($idfc) {session(['my_locale' => 'en']);App::setLocale('en'); return view('fc', ['id' => $idfc,'domen' => 0,'album' => '0','namef' => '0']);})->where('idfc', '[0-9]+');

Route::get('ni{idfn}', function ($idfn) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fi', ['id' => 0,'domen' => 0,'album' => '0','namef' => $idfn]);})->where('idfn', '[0-9]+');
Route::get('rni{idfn}', function ($idfn) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('fi', ['id' => 0,'domen' => 0,'album' =>'0','namef' => $idfn]);})->where('idfn', '[0-9]+');
Route::get('eni{idfn}', function ($idfn) {session(['my_locale' => 'en']);App::setLocale('en'); return view('fi', ['id' => 0,'domen' => 0,'album' => '0','namef' => $idfn]);})->where('idfn', '[0-9]+');

Route::get('nf{idfcn}', function ($idfcn) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fc', ['id' => 0,'domen' => 0,'album' => '0','namef' => $idfcn]);})->where('idfcn', '[0-9]+');
Route::get('rnf{idfcn}', function ($idfcn) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('fc', ['id' => 0,'domen' => 0,'album' => '0','namef' => $idfcn]);})->where('idfcn', '[0-9]+');
Route::get('enf{idfcn}', function ($idfcn) {session(['my_locale' => 'en']);App::setLocale('en'); return view('fc', ['id' => 0,'domen' => 0,'album' => '0','namef' => $idfcn]);})->where('idfcn', '[0-9]+');

Route::get('fi{idf}', function ($idf) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fi', ['id' => $idf,'domen' => 0,'album' => '0','namef' => '0']);})->where('idf', '[0-9]+');
Route::get('rfi{idf}', function ($idf) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('fi', ['id' => $idf,'domen' => 0,'album' =>'0','namef' => '0']);})->where('idf', '[0-9]+');
Route::get('efi{idf}', function ($idf) {session(['my_locale' => 'en']);App::setLocale('en'); return view('fi', ['id' => $idf,'domen' => 0,'album' => '0','namef' => '0']);})->where('idf', '[0-9]+');

Route::get('rec{idrec}', function ($idrec) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('records', ['idrec' => $idrec,'domen' => 0,'page' => '0','theme' => '0','id' => '0']);})->where('idrec', '[0-9]+');
Route::get('rrec{idrec}', function ($idrec) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('records', ['idrec' => $idrec,'domen' => 0,'page' =>'0','theme' => '0','id' => '0']);})->where('idrec', '[0-9]+');
Route::get('erec{idrec}', function ($idrec) {session(['my_locale' => 'en']);App::setLocale('en'); return view('records', ['idrec' => $idrec,'domen' => 0,'page' => '0','theme' => '0','id' => '0']);})->where('idrec', '[0-9]+');

Route::get('recp{idrecp}', function ($idrecp) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('recordsp', ['idrec' => $idrecp,'domen' => 0,'page' => '0','theme' => '0','id' => '0']);})->where('idrecp', '[0-9]+');
Route::get('rrecp{idrecp}', function ($idrecp) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('recordsp', ['idrec' => $idrecp,'domen' => 0,'page' =>'0','theme' => '0','id' => '0']);})->where('idrecp', '[0-9]+');
Route::get('erecp{idrecp}', function ($idrecp) {session(['my_locale' => 'en']);App::setLocale('en'); return view('recordsp', ['idrec' => $idrecp,'domen' => 0,'page' => '0','theme' => '0','id' => '0']);})->where('idrecp', '[0-9]+');


Route::get('{domenc}', function ($domenc) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('c', ['domen' => $domenc,'id' => 0]);})->where('domenc', '[a-z_-]+');
Route::get('{domenc}/ua', function ($domenc) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('c', ['domen' => $domenc,'id' => 0]);})->where('domenc', '[a-z_-]+');
Route::get('{domenc}/ru', function ($domenc) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('c', ['domen' => $domenc,'id' => 0]);})->where('domenc', '[a-z_-]+');
Route::get('{domenc}/en', function ($domenc) {session(['my_locale' => 'en']);App::setLocale('en'); return view('c', ['domen' => $domenc,'id' => 0]);})->where('domenc', '[a-z_-]+');

Route::get('{domen}', function ($domen) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('i', ['domen' => $domen,'id' => 0]);})->where('domen', '[a-zA-Z0-9\.]+');
Route::get('{domen}/ua', function ($domen) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('i', ['domen' => $domen,'id' => 0]);})->where('domen', '[a-zA-Z0-9\.]+');
Route::get('{domen}/ru', function ($domen) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('i', ['domen' => $domen,'id' => 0]);})->where('domen', '[a-zA-Z0-9\.]+');
Route::get('{domen}/en', function ($domen) {session(['my_locale' => 'en']);App::setLocale('en'); return view('i', ['domen' => $domen,'id' => 0]);})->where('domen', '[a-zA-Z0-9\.]+');


Route::get('{domenfc}/foto/ua', function ($domenfc) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fc', ['domen' => $domenfc,'id' => 0,'album' => '0','namef' => '0']);})->where('domenfc', '[a-z_-]+');
Route::get('{domenfc}/foto/ru', function ($domenfc) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('fc', ['domen' => $domenfc,'id' => 0,'album' => '0','namef' => '0']);})->where('domenfc', '[a-z_-]+');
Route::get('{domenfc}/foto/en', function ($domenfc) {session(['my_locale' => 'en']);App::setLocale('en'); return view('fc', ['domen' => $domenfc,'id' => 0,'album' => '0','namef' => '0']);})->where('domenfc', '[a-z_-]+');
Route::get('{domenfc}/foto', function ($domenfc) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fc', ['domen' => $domenfc,'id' => 0,'album' => '0','namef' => '0']);})->where('domenfc', '[a-z_-]+');

Route::get('{domenf}/foto/ua', function ($domenf) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fi', ['domen' => $domenf,'id' => 0,'album' => '0','namef' => '0']);})->where('domenf', '[a-zA-Z0-9\.]+');
Route::get('{domenf}/foto/ru', function ($domenf) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('fi', ['domen' => $domenf,'id' => 0,'album' => '0','namef' => '0']);})->where('domenf', '[a-zA-Z0-9\.]+');
Route::get('{domenf}/foto/en', function ($domenf) {session(['my_locale' => 'en']);App::setLocale('en'); return view('fi', ['domen' => $domenf,'id' => 0,'album' => '0','namef' => '0']);})->where('domenf', '[a-zA-Z0-9\.]+');
Route::get('{domenf}/foto', function ($domenf) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fi', ['domen' => $domenf,'id' => 0,'album' => '0','namef' => '0']);})->where('domenf', '[a-zA-Z0-9\.]+');

Route::get('{domenfc}/foto/{album}', function ($domenfc,$album) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fc', ['domen' => $domenfc,'id' => 0,'album' => $album,'namef' => '0']);})->where('domenfc', '[a-z_-]+', 'album', '[^/]+');
Route::get('{domenfc}/foto/ua/{album}', function ($domenfc,$album) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fc', ['domen' => $domenfc,'id' => 0,'album' => $album,'namef' => '0']);})->where('domenfc', '[a-z_-]+', 'album', '[^/]+');
Route::get('{domenfc}/foto/ru/{album}', function ($domenfc,$album) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('fc', ['domen' => $domenfc,'id' => 0,'album' => $album,'namef' => '0']);})->where('domenfc', '[a-z_-]+', 'album', '[^/]+');
Route::get('{domenfc}/foto/en/{album}', function ($domenfc,$album) {session(['my_locale' => 'en']);App::setLocale('en'); return view('fc', ['domen' => $domenfc,'id' => 0,'album' => $album,'namef' => '0']);})->where('domenfc', '[a-z_-]+', 'album', '[^/]+');

Route::get('{domenf}/foto/{albump}', function ($domenf,$albump) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fi', ['domen' => $domenf,'id' => 0,'album' => $albump,'namef' => '0']);})->where('domenf', '[a-zA-Z0-9\.]+', 'albump', '[^/]+');
Route::get('{domenf}/foto/ua/{albump}', function ($domenf,$albump) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('fi', ['domen' => $domenf,'id' => 0,'album' => $albump,'namef' => '0']);})->where('domenf', '[a-zA-Z0-9\.]+', 'albump', '[^/]+');
Route::get('{domenf}/foto/ru/{albump}', function ($domenf,$albump) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('fi', ['domen' => $domenf,'id' => 0,'album' => $albump,'namef' => '0']);})->where('domenf', '[a-zA-Z0-9\.]+', 'albump', '[^/]+');
Route::get('{domenf}/foto/en/{albump}', function ($domenf,$albump) {session(['my_locale' => 'en']);App::setLocale('en'); return view('fi', ['domen' => $domenf,'id' => 0,'album' => $albump,'namef' => '0']);})->where('domenf', '[a-zA-Z0-9\.]+', 'albump', '[^/]+');


Route::get('{domenbb}/blog/ua', function ($domenbb) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('blog', ['domen' => $domenbb,'npass1' => 2]);})->where('domenbb', '[a-z_-]+');
Route::get('{domenbb}/blog/ru', function ($domenbb) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('blog', ['domen' => $domenbb,'npass1' => 2]);})->where('domenbb', '[a-z_-]+');
Route::get('{domenbb}/blog',    function ($domenbb) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('blog', ['domen' => $domenbb,'npass1' => 2]);})->where('domenbb', '[a-z_-]+');

Route::get('{domenb}/blog/ua/{npass1}', function ($domenb,$npass1) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('blog', ['domen' => $domenb,'npass1' => $npass1]);})->where(['domenb' => '[a-z_-]+', 'npass1' => '[0-9]+']);
Route::get('{domenb}/blog/ru/{npass1}', function ($domenb,$npass1) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('blog', ['domen' => $domenb,'npass1' => $npass1]);})->where(['domenb' => '[a-z_-]+', 'npass1' => '[0-9]+']);
Route::get('{domenb}/blog/{npass1}',    function ($domenb,$npass1) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('blog', ['domen' => $domenb,'npass1' => $npass1]);})->where(['domenb' => '[a-z_-]+', 'npass1' => '[0-9]+']);

Route::get('{domenl}/ua/{topic}', function ($domenl,$topicl) {session(['my_locale' => 'ua']);App::setLocale('ua'); return view('life', ['domen' => $domenl,'topic' => $topicl]);})->where('domenl', '[a-z_-]+', 'topicl', '[a-z_-]+');
Route::get('{domenl}/ru/{topic}', function ($domenl,$topicl) {session(['my_locale' => 'ru']);App::setLocale('ru'); return view('life', ['domen' => $domenl,'topic' => $topicl]);})->where('domenl', '[a-z_-]+', 'topicl', '[a-z_-]+');



Route::get('{domencr}/forum/ua/{page}/{theme}', function ($domencr, $page, $theme) {
    session(['my_locale' => 'ua']);App::setLocale('ua');
    return view('records', ['domen' => $domencr,'page' => $page,'theme' => $theme,'idrec' => '0']);})
    ->where('domencr', '[a-z_-]+', 'page', '[0-9]+', 'theme', '[^/]+');

Route::get('{domencr}/forum/ru/{page}/{theme}', function ($domencr, $page, $theme) {
    session(['my_locale' => 'ru']);App::setLocale('ru');
    return view('records', ['domen' => $domencr,'page' => $page,'theme' => $theme,'idrec' => '0']);})
    ->where('domencr', '[a-z_-]+', 'page', '[0-9]+', 'theme', '[^/]+');

Route::get('{domencr}/forum/en/{page}/{theme}', function ($domencr, $page, $theme) {
    session(['my_locale' => 'en']);App::setLocale('en');
    return view('records', ['domen' => $domencr,'page' => $page,'theme' => $theme,'idrec' => '0']);})
    ->where('domencr', '[a-z_-]+', 'page', '[0-9]+', 'theme', '[^/]+');

Route::get('{domencp}/forum/ua/{page}/{theme}', function ($domencp, $page, $theme) {
    session(['my_locale' => 'ua']);App::setLocale('ua');
    return view('recordsp', ['domen' => $domencp,'page' => $page,'theme' => $theme,'idrec' => '0']);})
    ->where('domencp', '[a-zA-Z0-9\.]+', 'page', '[0-9]+', 'theme', '[^/]+');

Route::get('{domencp}/forum/ru/{page}/{theme}', function ($domencp, $page, $theme) {
    session(['my_locale' => 'ru']);App::setLocale('ru');
    return view('recordsp', ['domen' => $domencp,'page' => $page,'theme' => $theme,'idrec' => '0']);})
    ->where('domencp', '[a-zA-Z0-9\.]+', 'page', '[0-9]+', 'theme', '[^/]+');

Route::get('{domencp}/forum/en/{page}/{theme}', function ($domencp, $page, $theme) {
    session(['my_locale' => 'en']);App::setLocale('en');
    return view('recordsp', ['domen' => $domencp,'page' => $page,'theme' => $theme,'idrec' => '0']);})
    ->where('domencp', '[a-zA-Z0-9\.]+', 'page', '[0-9]+', 'theme', '[^/]+');




