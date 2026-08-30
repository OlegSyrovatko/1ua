<?php

// use App\Models\Allcitie;
namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App;
use Illuminate\Support\Facades\Storage;


class smlController extends Controller
{
    public function sml(Request $request)
    {
        $purp = $request['purp'];
        if($purp=="default"){

            $animal = __('messages.animal');
            $celebration = __('messages.celebration');
            $dans = __('messages.dans');
            $drink = __('messages.drink');
            $fools = __('messages.fools');
            $love = __('messages.love');
            $main = __('messages.main');
            $role = __('messages.role');
            $sport = __('messages.sport');
            $txt = __('messages.txt');
            $zlo = __('messages.zlo');
            $girl = __('messages.girl');

            $sml_e = "<img src=/sml/2.gif onclick=smlin(this.src)>
            <img src=/sml/3.gif onclick=smlin(this.src)>
            <img src=/sml/4.gif onclick=smlin(this.src)>
            <img src=/sml/6.gif onclick=smlin(this.src)>
            <img src=/sml/7.gif onclick=smlin(this.src)>
            <img src=/sml/9.gif onclick=smlin(this.src)>
            <img src=/sml/11.gif onclick=smlin(this.src)>
            <img src=/sml/10.gif onclick=smlin(this.src)>
            <img src=/sml/19.gif onclick=smlin(this.src)>
            <img src=/sml/18.gif onclick=smlin(this.src)>
            <img src=/sml/16.gif onclick=smlin(this.src)>
            <img src=/sml/22.gif onclick=smlin(this.src)>
            <img src=/sml/24.gif onclick=smlin(this.src)>
            <img src=/sml/25.gif onclick=smlin(this.src)>
            <img src=/sml/35.gif onclick=smlin(this.src)>
            <img src=/sml/31.gif onclick=smlin(this.src)>
            <img src=/sml/42.gif onclick=smlin(this.src)>
            <img src=/sml/8.gif onclick=smlin(this.src)>
            <img src=/sml/29.gif onclick=smlin(this.src)>
            <img src=/sml/36.gif onclick=smlin(this.src)>
            <img src=/sml/40.gif onclick=smlin(this.src)>
            <img src=/sml/26.gif onclick=smlin(this.src)>

            <br /><h5>
<a onclick=sml_red('animal')>$animal</a>
<a onclick=sml_red('celebration')>$celebration</a>
<a onclick=sml_red('dans&music')>$dans</a>
<a onclick=sml_red('drink&eat')>$drink</a>
<a onclick=sml_red('fools')>$fools</a>
            $love: <a onclick=sml_red('love')>1</a> <a onclick=sml_red('love2')>2</a>
            $main: <a onclick=sml_red('main')>1</a> <a onclick=sml_red('main2')>2</a> <a onclick=sml_red('main3')>3</a> <a onclick=sml_red('main4')>4</a>
            $role: <a onclick=sml_red('role')>1</a> <a onclick=sml_red('role2')>2</a> <a onclick=sml_red('role3')>3</a> <a onclick=sml_red('role4')>4</a> <a onclick=sml_red('role5')>5</a> <a onclick=sml_red('role6')>6</a>
            $sport: <a onclick=sml_red('sport')>1</a> <a onclick=sml_red('sport2')>2</a> <a onclick=sml_red('sport3')>3</a>
<a onclick=sml_red('txt')>$txt</a>
<a onclick=sml_red('zlo')>$zlo</a>
<a onclick=sml_red('girl')>$girl</a>
</h5><br />";
        }
        return $sml_e;
    }




    public function sml_add(Request $request)
    {
        $purp = $request['purp'];
        if($purp=="animal"){
            $sml_e = "<img src=/sml/animal/1.gif onclick=smlin(this.src)>
<img src=/sml/animal/10.gif onclick=smlin(this.src)>
<img src=/sml/animal/11.gif onclick=smlin(this.src)>
<img src=/sml/animal/12.gif onclick=smlin(this.src)>
<img src=/sml/animal/13.gif onclick=smlin(this.src)>
<img src=/sml/animal/14.gif onclick=smlin(this.src)>
<img src=/sml/animal/15.gif onclick=smlin(this.src)>
<img src=/sml/animal/16.gif onclick=smlin(this.src)>
<img src=/sml/animal/17.gif onclick=smlin(this.src)>
<img src=/sml/animal/18.gif onclick=smlin(this.src)>
<img src=/sml/animal/19.gif onclick=smlin(this.src)>
<img src=/sml/animal/2.gif onclick=smlin(this.src)>
<img src=/sml/animal/20.gif onclick=smlin(this.src)>
<img src=/sml/animal/21.gif onclick=smlin(this.src)>
<img src=/sml/animal/22.gif onclick=smlin(this.src)>
<img src=/sml/animal/23.gif onclick=smlin(this.src)>
<img src=/sml/animal/24.gif onclick=smlin(this.src)>
<img src=/sml/animal/25.gif onclick=smlin(this.src)>
<img src=/sml/animal/26.gif onclick=smlin(this.src)>
<img src=/sml/animal/27.gif onclick=smlin(this.src)>
<img src=/sml/animal/28.gif onclick=smlin(this.src)>
<img src=/sml/animal/29.gif onclick=smlin(this.src)>
<img src=/sml/animal/3.gif onclick=smlin(this.src)>
<img src=/sml/animal/30.gif onclick=smlin(this.src)>
<img src=/sml/animal/4.gif onclick=smlin(this.src)>
<img src=/sml/animal/5.gif onclick=smlin(this.src)>
<img src=/sml/animal/6.gif onclick=smlin(this.src)>
<img src=/sml/animal/7.gif onclick=smlin(this.src)>
<img src=/sml/animal/8.gif onclick=smlin(this.src)>
<img src=/sml/animal/9.gif onclick=smlin(this.src)>";
        }
        if($purp=="celebration"){
            $sml_e = "<img src=/sml/celebration/1.gif onclick=smlin(this.src)>
<img src=/sml/celebration/10.gif onclick=smlin(this.src)>
<img src=/sml/celebration/11.gif onclick=smlin(this.src)>
<img src=/sml/celebration/12.gif onclick=smlin(this.src)>
<img src=/sml/celebration/13.gif onclick=smlin(this.src)>
<img src=/sml/celebration/14.gif onclick=smlin(this.src)>
<img src=/sml/celebration/15.gif onclick=smlin(this.src)>
<img src=/sml/celebration/16.gif onclick=smlin(this.src)>
<img src=/sml/celebration/17.gif onclick=smlin(this.src)>
<img src=/sml/celebration/18.gif onclick=smlin(this.src)>
<img src=/sml/celebration/19.gif onclick=smlin(this.src)>
<img src=/sml/celebration/2.gif onclick=smlin(this.src)>
<img src=/sml/celebration/20.gif onclick=smlin(this.src)>
<img src=/sml/celebration/21.gif onclick=smlin(this.src)>
<img src=/sml/celebration/22.gif onclick=smlin(this.src)>
<img src=/sml/celebration/23.gif onclick=smlin(this.src)>
<img src=/sml/celebration/24.gif onclick=smlin(this.src)>
<img src=/sml/celebration/25.gif onclick=smlin(this.src)>
<img src=/sml/celebration/26.gif onclick=smlin(this.src)>
<img src=/sml/celebration/27.gif onclick=smlin(this.src)>
<img src=/sml/celebration/28.gif onclick=smlin(this.src)>
<img src=/sml/celebration/29.gif onclick=smlin(this.src)>
<img src=/sml/celebration/3.gif onclick=smlin(this.src)>
<img src=/sml/celebration/30.gif onclick=smlin(this.src)>
<img src=/sml/celebration/31.gif onclick=smlin(this.src)>
<img src=/sml/celebration/32.gif onclick=smlin(this.src)>
<img src=/sml/celebration/33.gif onclick=smlin(this.src)>
<img src=/sml/celebration/34.gif onclick=smlin(this.src)>
<img src=/sml/celebration/35.gif onclick=smlin(this.src)>
<img src=/sml/celebration/36.gif onclick=smlin(this.src)>
<img src=/sml/celebration/37.gif onclick=smlin(this.src)>
<img src=/sml/celebration/38.gif onclick=smlin(this.src)>
<img src=/sml/celebration/39.gif onclick=smlin(this.src)>
<img src=/sml/celebration/4.gif onclick=smlin(this.src)>
<img src=/sml/celebration/5.gif onclick=smlin(this.src)>
<img src=/sml/celebration/6.gif onclick=smlin(this.src)>
<img src=/sml/celebration/7.gif onclick=smlin(this.src)>
<img src=/sml/celebration/8.gif onclick=smlin(this.src)>
<img src=/sml/celebration/9.gif onclick=smlin(this.src)>";
        }
        if($purp=="dans&music"){
            $sml_e = "<img src=/sml/dans&music/1.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/10.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/11.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/12.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/13.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/14.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/15.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/16.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/17.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/18.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/19.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/2.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/20.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/21.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/22.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/23.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/24.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/25.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/26.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/27.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/3.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/4.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/5.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/6.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/7.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/8.gif onclick=smlin(this.src)>
<img src=/sml/dans&music/9.gif onclick=smlin(this.src)>";
        }
        if($purp=="drink&eat"){
            $sml_e = "<img src=/sml/drink&eat/1.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/10.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/11.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/12.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/13.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/14.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/15.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/16.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/17.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/18.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/19.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/2.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/20.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/21.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/22.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/23.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/24.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/25.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/3.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/4.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/5.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/6.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/7.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/8.gif onclick=smlin(this.src)>
<img src=/sml/drink&eat/9.gif onclick=smlin(this.src)>";
        }
        if($purp=="fools"){
            $sml_e = "<img src=/sml/fools/1.gif onclick=smlin(this.src)>
<img src=/sml/fools/10.gif onclick=smlin(this.src)>
<img src=/sml/fools/11.gif onclick=smlin(this.src)>
<img src=/sml/fools/12.gif onclick=smlin(this.src)>
<img src=/sml/fools/13.gif onclick=smlin(this.src)>
<img src=/sml/fools/14.gif onclick=smlin(this.src)>
<img src=/sml/fools/15.gif onclick=smlin(this.src)>
<img src=/sml/fools/16.gif onclick=smlin(this.src)>
<img src=/sml/fools/17.gif onclick=smlin(this.src)>
<img src=/sml/fools/18.gif onclick=smlin(this.src)>
<img src=/sml/fools/19.gif onclick=smlin(this.src)>
<img src=/sml/fools/2.gif onclick=smlin(this.src)>
<img src=/sml/fools/20.gif onclick=smlin(this.src)>
<img src=/sml/fools/21.gif onclick=smlin(this.src)>
<img src=/sml/fools/22.gif onclick=smlin(this.src)>
<img src=/sml/fools/23.gif onclick=smlin(this.src)>
<img src=/sml/fools/24.gif onclick=smlin(this.src)>
<img src=/sml/fools/25.gif onclick=smlin(this.src)>
<img src=/sml/fools/26.gif onclick=smlin(this.src)>
<img src=/sml/fools/27.gif onclick=smlin(this.src)>
<img src=/sml/fools/28.gif onclick=smlin(this.src)>
<img src=/sml/fools/29.gif onclick=smlin(this.src)>
<img src=/sml/fools/3.gif onclick=smlin(this.src)>
<img src=/sml/fools/30.gif onclick=smlin(this.src)>
<img src=/sml/fools/31.gif onclick=smlin(this.src)>
<img src=/sml/fools/32.gif onclick=smlin(this.src)>
<img src=/sml/fools/33.gif onclick=smlin(this.src)>
<img src=/sml/fools/34.gif onclick=smlin(this.src)>
<img src=/sml/fools/35.gif onclick=smlin(this.src)>
<img src=/sml/fools/36.gif onclick=smlin(this.src)>
<img src=/sml/fools/37.gif onclick=smlin(this.src)>
<img src=/sml/fools/38.gif onclick=smlin(this.src)>
<img src=/sml/fools/39.gif onclick=smlin(this.src)>
<img src=/sml/fools/4.gif onclick=smlin(this.src)>
<img src=/sml/fools/40.gif onclick=smlin(this.src)>
<img src=/sml/fools/41.gif onclick=smlin(this.src)>
<img src=/sml/fools/42.gif onclick=smlin(this.src)>
<img src=/sml/fools/43.gif onclick=smlin(this.src)>
<img src=/sml/fools/44.gif onclick=smlin(this.src)>
<img src=/sml/fools/5.gif onclick=smlin(this.src)>
<img src=/sml/fools/6.gif onclick=smlin(this.src)>
<img src=/sml/fools/7.gif onclick=smlin(this.src)>
<img src=/sml/fools/8.gif onclick=smlin(this.src)>
<img src=/sml/fools/9.gif onclick=smlin(this.src)>";
        }
        if($purp=="girl"){
            $sml_e = "<img src=/sml/girl/1.gif onclick=smlin(this.src)>
<img src=/sml/girl/10.gif onclick=smlin(this.src)>
<img src=/sml/girl/11.gif onclick=smlin(this.src)>
<img src=/sml/girl/12.gif onclick=smlin(this.src)>
<img src=/sml/girl/13.gif onclick=smlin(this.src)>
<img src=/sml/girl/14.gif onclick=smlin(this.src)>
<img src=/sml/girl/15.gif onclick=smlin(this.src)>
<img src=/sml/girl/16.gif onclick=smlin(this.src)>
<img src=/sml/girl/17.gif onclick=smlin(this.src)>
<img src=/sml/girl/18.gif onclick=smlin(this.src)>
<img src=/sml/girl/19.gif onclick=smlin(this.src)>
<img src=/sml/girl/2.gif onclick=smlin(this.src)>
<img src=/sml/girl/20.gif onclick=smlin(this.src)>
<img src=/sml/girl/21.gif onclick=smlin(this.src)>
<img src=/sml/girl/22.gif onclick=smlin(this.src)>
<img src=/sml/girl/23.gif onclick=smlin(this.src)>
<img src=/sml/girl/24.gif onclick=smlin(this.src)>
<img src=/sml/girl/25.gif onclick=smlin(this.src)>
<img src=/sml/girl/26.gif onclick=smlin(this.src)>
<img src=/sml/girl/27.gif onclick=smlin(this.src)>
<img src=/sml/girl/28.gif onclick=smlin(this.src)>
<img src=/sml/girl/29.gif onclick=smlin(this.src)>
<img src=/sml/girl/3.gif onclick=smlin(this.src)>
<img src=/sml/girl/30.gif onclick=smlin(this.src)>
<img src=/sml/girl/31.gif onclick=smlin(this.src)>
<img src=/sml/girl/32.gif onclick=smlin(this.src)>
<img src=/sml/girl/33.gif onclick=smlin(this.src)>
<img src=/sml/girl/34.gif onclick=smlin(this.src)>
<img src=/sml/girl/35.gif onclick=smlin(this.src)>
<img src=/sml/girl/36.gif onclick=smlin(this.src)>
<img src=/sml/girl/37.gif onclick=smlin(this.src)>
<img src=/sml/girl/38.gif onclick=smlin(this.src)>
<img src=/sml/girl/39.gif onclick=smlin(this.src)>
<img src=/sml/girl/4.gif onclick=smlin(this.src)>
<img src=/sml/girl/40.gif onclick=smlin(this.src)>
<img src=/sml/girl/5.gif onclick=smlin(this.src)>
<img src=/sml/girl/6.gif onclick=smlin(this.src)>
<img src=/sml/girl/7.gif onclick=smlin(this.src)>
<img src=/sml/girl/8.gif onclick=smlin(this.src)>
<img src=/sml/girl/9.gif onclick=smlin(this.src)>";
        }
        if($purp=="love"){
            $sml_e = "<img src=/sml/love/33.gif onclick=smlin(this.src)>
<img src=/sml/love/34.gif onclick=smlin(this.src)>
<img src=/sml/love/35.gif onclick=smlin(this.src)>
<img src=/sml/love/36.gif onclick=smlin(this.src)>
<img src=/sml/love/37.gif onclick=smlin(this.src)>
<img src=/sml/love/38.gif onclick=smlin(this.src)>
<img src=/sml/love/39.gif onclick=smlin(this.src)>
<img src=/sml/love/4.gif onclick=smlin(this.src)>
<img src=/sml/love/40.gif onclick=smlin(this.src)>
<img src=/sml/love/41.gif onclick=smlin(this.src)>
<img src=/sml/love/42.gif onclick=smlin(this.src)>
<img src=/sml/love/43.gif onclick=smlin(this.src)>
<img src=/sml/love/44.gif onclick=smlin(this.src)>
<img src=/sml/love/45.gif onclick=smlin(this.src)>
<img src=/sml/love/46.gif onclick=smlin(this.src)>
<img src=/sml/love/47.gif onclick=smlin(this.src)>
<img src=/sml/love/48.gif onclick=smlin(this.src)>
<img src=/sml/love/49.gif onclick=smlin(this.src)>
<img src=/sml/love/5.gif onclick=smlin(this.src)>
<img src=/sml/love/50.gif onclick=smlin(this.src)>
<img src=/sml/love/51.gif onclick=smlin(this.src)>
<img src=/sml/love/52.gif onclick=smlin(this.src)>
<img src=/sml/love/53.gif onclick=smlin(this.src)>
<img src=/sml/love/54.gif onclick=smlin(this.src)>
<img src=/sml/love/55.gif onclick=smlin(this.src)>
<img src=/sml/love/56.gif onclick=smlin(this.src)>
<img src=/sml/love/57.gif onclick=smlin(this.src)>
<img src=/sml/love/58.gif onclick=smlin(this.src)>";
        }
        if($purp=="love2"){
            $sml_e = "<img src=/sml/love2/1.gif onclick=smlin(this.src)>
<img src=/sml/love2/10.gif onclick=smlin(this.src)>
<img src=/sml/love2/11.gif onclick=smlin(this.src)>
<img src=/sml/love2/12.gif onclick=smlin(this.src)>
<img src=/sml/love2/13.gif onclick=smlin(this.src)>
<img src=/sml/love2/14.gif onclick=smlin(this.src)>
<img src=/sml/love2/15.gif onclick=smlin(this.src)>
<img src=/sml/love2/16.gif onclick=smlin(this.src)>
<img src=/sml/love2/17.gif onclick=smlin(this.src)>
<img src=/sml/love2/18.gif onclick=smlin(this.src)>
<img src=/sml/love2/19.gif onclick=smlin(this.src)>
<img src=/sml/love2/2.gif onclick=smlin(this.src)>
<img src=/sml/love2/20.gif onclick=smlin(this.src)>
<img src=/sml/love2/21.gif onclick=smlin(this.src)>
<img src=/sml/love2/22.gif onclick=smlin(this.src)>
<img src=/sml/love2/23.gif onclick=smlin(this.src)>
<img src=/sml/love2/24.gif onclick=smlin(this.src)>
<img src=/sml/love2/25.gif onclick=smlin(this.src)>
<img src=/sml/love2/26.gif onclick=smlin(this.src)>
<img src=/sml/love2/27.gif onclick=smlin(this.src)>
<img src=/sml/love2/28.gif onclick=smlin(this.src)>
<img src=/sml/love2/29.gif onclick=smlin(this.src)>
<img src=/sml/love2/3.gif onclick=smlin(this.src)>
<img src=/sml/love2/30.gif onclick=smlin(this.src)>
<img src=/sml/love2/31.gif onclick=smlin(this.src)>
<img src=/sml/love2/32.gif onclick=smlin(this.src)>
<img src=/sml/love2/6.gif onclick=smlin(this.src)>
<img src=/sml/love2/7.gif onclick=smlin(this.src)>
<img src=/sml/love2/8.gif onclick=smlin(this.src)>
<img src=/sml/love2/9.gif onclick=smlin(this.src)>";
        }
        if($purp=="main"){
            $sml_e = "<img src=/sml/main/1.gif onclick=smlin(this.src)>
<img src=/sml/main/10.gif onclick=smlin(this.src)>
<img src=/sml/main/100.gif onclick=smlin(this.src)>
<img src=/sml/main/101.gif onclick=smlin(this.src)>
<img src=/sml/main/102.gif onclick=smlin(this.src)>
<img src=/sml/main/103.gif onclick=smlin(this.src)>
<img src=/sml/main/104.gif onclick=smlin(this.src)>
<img src=/sml/main/105.gif onclick=smlin(this.src)>
<img src=/sml/main/106.gif onclick=smlin(this.src)>
<img src=/sml/main/107.gif onclick=smlin(this.src)>
<img src=/sml/main/108.gif onclick=smlin(this.src)>
<img src=/sml/main/109.gif onclick=smlin(this.src)>
<img src=/sml/main/11.gif onclick=smlin(this.src)>
<img src=/sml/main/110.gif onclick=smlin(this.src)>
<img src=/sml/main/111.gif onclick=smlin(this.src)>
<img src=/sml/main/112.gif onclick=smlin(this.src)>
<img src=/sml/main/113.gif onclick=smlin(this.src)>
<img src=/sml/main/114.gif onclick=smlin(this.src)>
<img src=/sml/main/115.gif onclick=smlin(this.src)>
<img src=/sml/main/116.gif onclick=smlin(this.src)>
<img src=/sml/main/117.gif onclick=smlin(this.src)>
<img src=/sml/main/118.gif onclick=smlin(this.src)>
<img src=/sml/main/119.gif onclick=smlin(this.src)>
<img src=/sml/main/12.gif onclick=smlin(this.src)>
<img src=/sml/main/120.gif onclick=smlin(this.src)>
<img src=/sml/main/121.gif onclick=smlin(this.src)>
<img src=/sml/main/122.gif onclick=smlin(this.src)>
<img src=/sml/main/123.gif onclick=smlin(this.src)>
<img src=/sml/main/124.gif onclick=smlin(this.src)>
<img src=/sml/main/125.gif onclick=smlin(this.src)>
<img src=/sml/main/126.gif onclick=smlin(this.src)>
<img src=/sml/main/127.gif onclick=smlin(this.src)>
<img src=/sml/main/128.gif onclick=smlin(this.src)>
<img src=/sml/main/129.gif onclick=smlin(this.src)>
<img src=/sml/main/13.gif onclick=smlin(this.src)>
<img src=/sml/main/130.gif onclick=smlin(this.src)>
<img src=/sml/main/131.gif onclick=smlin(this.src)>
<img src=/sml/main/132.gif onclick=smlin(this.src)>
<img src=/sml/main/133.gif onclick=smlin(this.src)>
<img src=/sml/main/134.gif onclick=smlin(this.src)>
<img src=/sml/main/135.gif onclick=smlin(this.src)>
<img src=/sml/main/136.gif onclick=smlin(this.src)>
<img src=/sml/main/137.gif onclick=smlin(this.src)>
<img src=/sml/main/138.gif onclick=smlin(this.src)>
<img src=/sml/main/139.gif onclick=smlin(this.src)>
<img src=/sml/main/14.gif onclick=smlin(this.src)>
<img src=/sml/main/140.gif onclick=smlin(this.src)>
<img src=/sml/main/141.gif onclick=smlin(this.src)>
<img src=/sml/main/142.gif onclick=smlin(this.src)>
<img src=/sml/main/143.gif onclick=smlin(this.src)>
<img src=/sml/main/144.gif onclick=smlin(this.src)>
<img src=/sml/main/145.gif onclick=smlin(this.src)>
<img src=/sml/main/146.gif onclick=smlin(this.src)>
<img src=/sml/main/147.gif onclick=smlin(this.src)>";
        }
        if($purp=="main2"){
            $sml_e = "<img src=/sml/main2/148.gif onclick=smlin(this.src)>
<img src=/sml/main2/149.gif onclick=smlin(this.src)>
<img src=/sml/main2/15.gif onclick=smlin(this.src)>
<img src=/sml/main2/150.gif onclick=smlin(this.src)>
<img src=/sml/main2/151.gif onclick=smlin(this.src)>
<img src=/sml/main2/152.gif onclick=smlin(this.src)>
<img src=/sml/main2/153.gif onclick=smlin(this.src)>
<img src=/sml/main2/154.gif onclick=smlin(this.src)>
<img src=/sml/main2/155.gif onclick=smlin(this.src)>
<img src=/sml/main2/156.gif onclick=smlin(this.src)>
<img src=/sml/main2/157.gif onclick=smlin(this.src)>
<img src=/sml/main2/158.gif onclick=smlin(this.src)>
<img src=/sml/main2/159.gif onclick=smlin(this.src)>
<img src=/sml/main2/16.gif onclick=smlin(this.src)>
<img src=/sml/main2/160.gif onclick=smlin(this.src)>
<img src=/sml/main2/161.gif onclick=smlin(this.src)>
<img src=/sml/main2/162.gif onclick=smlin(this.src)>
<img src=/sml/main2/163.gif onclick=smlin(this.src)>
<img src=/sml/main2/164.gif onclick=smlin(this.src)>
<img src=/sml/main2/165.gif onclick=smlin(this.src)>
<img src=/sml/main2/166.gif onclick=smlin(this.src)>
<img src=/sml/main2/167.gif onclick=smlin(this.src)>
<img src=/sml/main2/168.gif onclick=smlin(this.src)>
<img src=/sml/main2/169.gif onclick=smlin(this.src)>
<img src=/sml/main2/17.gif onclick=smlin(this.src)>
<img src=/sml/main2/170.gif onclick=smlin(this.src)>
<img src=/sml/main2/171.gif onclick=smlin(this.src)>
<img src=/sml/main2/172.gif onclick=smlin(this.src)>
<img src=/sml/main2/173.gif onclick=smlin(this.src)>
<img src=/sml/main2/174.gif onclick=smlin(this.src)>
<img src=/sml/main2/175.gif onclick=smlin(this.src)>
<img src=/sml/main2/176.gif onclick=smlin(this.src)>
<img src=/sml/main2/177.gif onclick=smlin(this.src)>
<img src=/sml/main2/178.gif onclick=smlin(this.src)>
<img src=/sml/main2/179.gif onclick=smlin(this.src)>
<img src=/sml/main2/18.gif onclick=smlin(this.src)>
<img src=/sml/main2/180.gif onclick=smlin(this.src)>
<img src=/sml/main2/181.gif onclick=smlin(this.src)>
<img src=/sml/main2/182.gif onclick=smlin(this.src)>
<img src=/sml/main2/183.gif onclick=smlin(this.src)>
<img src=/sml/main2/184.gif onclick=smlin(this.src)>
<img src=/sml/main2/185.gif onclick=smlin(this.src)>
<img src=/sml/main2/186.gif onclick=smlin(this.src)>
<img src=/sml/main2/19.gif onclick=smlin(this.src)>
<img src=/sml/main2/2.gif onclick=smlin(this.src)>";
        }
        if($purp=="main3"){
            $sml_e = "<img src=/sml/main3/20.gif onclick=smlin(this.src)>
<img src=/sml/main3/21.gif onclick=smlin(this.src)>
<img src=/sml/main3/22.gif onclick=smlin(this.src)>
<img src=/sml/main3/23.gif onclick=smlin(this.src)>
<img src=/sml/main3/24.gif onclick=smlin(this.src)>
<img src=/sml/main3/25.gif onclick=smlin(this.src)>
<img src=/sml/main3/26.gif onclick=smlin(this.src)>
<img src=/sml/main3/27.gif onclick=smlin(this.src)>
<img src=/sml/main3/28.gif onclick=smlin(this.src)>
<img src=/sml/main3/29.gif onclick=smlin(this.src)>
<img src=/sml/main3/3.gif onclick=smlin(this.src)>
<img src=/sml/main3/30.gif onclick=smlin(this.src)>
<img src=/sml/main3/31.gif onclick=smlin(this.src)>
<img src=/sml/main3/32.gif onclick=smlin(this.src)>
<img src=/sml/main3/33.gif onclick=smlin(this.src)>
<img src=/sml/main3/34.gif onclick=smlin(this.src)>
<img src=/sml/main3/35.gif onclick=smlin(this.src)>
<img src=/sml/main3/36.gif onclick=smlin(this.src)>
<img src=/sml/main3/37.gif onclick=smlin(this.src)>
<img src=/sml/main3/38.gif onclick=smlin(this.src)>
<img src=/sml/main3/39.gif onclick=smlin(this.src)>
<img src=/sml/main3/4.gif onclick=smlin(this.src)>
<img src=/sml/main3/40.gif onclick=smlin(this.src)>
<img src=/sml/main3/41.gif onclick=smlin(this.src)>
<img src=/sml/main3/42.gif onclick=smlin(this.src)>
<img src=/sml/main3/43.gif onclick=smlin(this.src)>
<img src=/sml/main3/44.gif onclick=smlin(this.src)>
<img src=/sml/main3/45.gif onclick=smlin(this.src)>
<img src=/sml/main3/46.gif onclick=smlin(this.src)>
<img src=/sml/main3/47.gif onclick=smlin(this.src)>
<img src=/sml/main3/48.gif onclick=smlin(this.src)>
<img src=/sml/main3/49.gif onclick=smlin(this.src)>
<img src=/sml/main3/5.gif onclick=smlin(this.src)>
<img src=/sml/main3/50.gif onclick=smlin(this.src)>
<img src=/sml/main3/51.gif onclick=smlin(this.src)>
<img src=/sml/main3/52.gif onclick=smlin(this.src)>
<img src=/sml/main3/53.gif onclick=smlin(this.src)>
<img src=/sml/main3/54.gif onclick=smlin(this.src)>
<img src=/sml/main3/55.gif onclick=smlin(this.src)>
<img src=/sml/main3/56.gif onclick=smlin(this.src)>
<img src=/sml/main3/57.gif onclick=smlin(this.src)>
<img src=/sml/main3/58.gif onclick=smlin(this.src)>
<img src=/sml/main3/59.gif onclick=smlin(this.src)>
<img src=/sml/main3/6.gif onclick=smlin(this.src)>
<img src=/sml/main3/60.gif onclick=smlin(this.src)>";
        }
        if($purp=="main4"){
            $sml_e = "<img src=/sml/main4/61.gif onclick=smlin(this.src)>
<img src=/sml/main4/62.gif onclick=smlin(this.src)>
<img src=/sml/main4/63.gif onclick=smlin(this.src)>
<img src=/sml/main4/64.gif onclick=smlin(this.src)>
<img src=/sml/main4/65.gif onclick=smlin(this.src)>
<img src=/sml/main4/66.gif onclick=smlin(this.src)>
<img src=/sml/main4/67.gif onclick=smlin(this.src)>
<img src=/sml/main4/68.gif onclick=smlin(this.src)>
<img src=/sml/main4/69.gif onclick=smlin(this.src)>
<img src=/sml/main4/7.gif onclick=smlin(this.src)>
<img src=/sml/main4/70.gif onclick=smlin(this.src)>
<img src=/sml/main4/71.gif onclick=smlin(this.src)>
<img src=/sml/main4/72.gif onclick=smlin(this.src)>
<img src=/sml/main4/73.gif onclick=smlin(this.src)>
<img src=/sml/main4/74.gif onclick=smlin(this.src)>
<img src=/sml/main4/75.gif onclick=smlin(this.src)>
<img src=/sml/main4/76.gif onclick=smlin(this.src)>
<img src=/sml/main4/77.gif onclick=smlin(this.src)>
<img src=/sml/main4/78.gif onclick=smlin(this.src)>
<img src=/sml/main4/79.gif onclick=smlin(this.src)>
<img src=/sml/main4/8.gif onclick=smlin(this.src)>
<img src=/sml/main4/80.gif onclick=smlin(this.src)>
<img src=/sml/main4/81.gif onclick=smlin(this.src)>
<img src=/sml/main4/82.gif onclick=smlin(this.src)>
<img src=/sml/main4/83.gif onclick=smlin(this.src)>
<img src=/sml/main4/84.gif onclick=smlin(this.src)>
<img src=/sml/main4/85.gif onclick=smlin(this.src)>
<img src=/sml/main4/86.gif onclick=smlin(this.src)>
<img src=/sml/main4/87.gif onclick=smlin(this.src)>
<img src=/sml/main4/88.gif onclick=smlin(this.src)>
<img src=/sml/main4/89.gif onclick=smlin(this.src)>
<img src=/sml/main4/9.gif onclick=smlin(this.src)>
<img src=/sml/main4/90.gif onclick=smlin(this.src)>
<img src=/sml/main4/91.gif onclick=smlin(this.src)>
<img src=/sml/main4/92.gif onclick=smlin(this.src)>
<img src=/sml/main4/93.gif onclick=smlin(this.src)>
<img src=/sml/main4/94.gif onclick=smlin(this.src)>
<img src=/sml/main4/95.gif onclick=smlin(this.src)>
<img src=/sml/main4/96.gif onclick=smlin(this.src)>
<img src=/sml/main4/97.gif onclick=smlin(this.src)>
<img src=/sml/main4/98.gif onclick=smlin(this.src)>
<img src=/sml/main4/99.gif onclick=smlin(this.src)>";
        }
        if($purp=="role"){
            $sml_e = "<img src=/sml/role/1.gif onclick=smlin(this.src)>
<img src=/sml/role/10.gif onclick=smlin(this.src)>
<img src=/sml/role/100.gif onclick=smlin(this.src)>
<img src=/sml/role/101.gif onclick=smlin(this.src)>
<img src=/sml/role/102.gif onclick=smlin(this.src)>
<img src=/sml/role/103.gif onclick=smlin(this.src)>
<img src=/sml/role/104.gif onclick=smlin(this.src)>
<img src=/sml/role/105.gif onclick=smlin(this.src)>
<img src=/sml/role/106.gif onclick=smlin(this.src)>
<img src=/sml/role/107.gif onclick=smlin(this.src)>
<img src=/sml/role/108.gif onclick=smlin(this.src)>
<img src=/sml/role/109.gif onclick=smlin(this.src)>
<img src=/sml/role/11.gif onclick=smlin(this.src)>
<img src=/sml/role/110.gif onclick=smlin(this.src)>
<img src=/sml/role/111.gif onclick=smlin(this.src)>
<img src=/sml/role/112.gif onclick=smlin(this.src)>
<img src=/sml/role/113.gif onclick=smlin(this.src)>
<img src=/sml/role/114.gif onclick=smlin(this.src)>
<img src=/sml/role/115.gif onclick=smlin(this.src)>
<img src=/sml/role/116.gif onclick=smlin(this.src)>";
        }
        if($purp=="role2"){
            $sml_e = "<img src=/sml/role2/119.gif onclick=smlin(this.src)>
<img src=/sml/role2/12.gif onclick=smlin(this.src)>
<img src=/sml/role2/120.gif onclick=smlin(this.src)>
<img src=/sml/role2/121.gif onclick=smlin(this.src)>
<img src=/sml/role2/122.gif onclick=smlin(this.src)>
<img src=/sml/role2/123.gif onclick=smlin(this.src)>
<img src=/sml/role2/124.gif onclick=smlin(this.src)>
<img src=/sml/role2/125.gif onclick=smlin(this.src)>
<img src=/sml/role2/126.gif onclick=smlin(this.src)>
<img src=/sml/role2/127.gif onclick=smlin(this.src)>
<img src=/sml/role2/128.gif onclick=smlin(this.src)>
<img src=/sml/role2/129.gif onclick=smlin(this.src)>
<img src=/sml/role2/13.gif onclick=smlin(this.src)>
<img src=/sml/role2/130.gif onclick=smlin(this.src)>
<img src=/sml/role2/131.gif onclick=smlin(this.src)>
<img src=/sml/role2/132.gif onclick=smlin(this.src)>
<img src=/sml/role2/133.gif onclick=smlin(this.src)>
<img src=/sml/role2/134.gif onclick=smlin(this.src)>
<img src=/sml/role2/135.gif onclick=smlin(this.src)>
<img src=/sml/role2/136.gif onclick=smlin(this.src)>
<img src=/sml/role2/137.gif onclick=smlin(this.src)>
<img src=/sml/role2/138.gif onclick=smlin(this.src)>";
        }
        if($purp=="role3"){
            $sml_e = "<img src=/sml/role3/139.gif onclick=smlin(this.src)>
<img src=/sml/role3/14.gif onclick=smlin(this.src)>
<img src=/sml/role3/140.gif onclick=smlin(this.src)>
<img src=/sml/role3/141.gif onclick=smlin(this.src)>
<img src=/sml/role3/142.gif onclick=smlin(this.src)>
<img src=/sml/role3/143.gif onclick=smlin(this.src)>
<img src=/sml/role3/144.gif onclick=smlin(this.src)>
<img src=/sml/role3/145.gif onclick=smlin(this.src)>
<img src=/sml/role3/146.gif onclick=smlin(this.src)>
<img src=/sml/role3/147.gif onclick=smlin(this.src)>
<img src=/sml/role3/15.gif onclick=smlin(this.src)>
<img src=/sml/role3/16.gif onclick=smlin(this.src)>
<img src=/sml/role3/17.gif onclick=smlin(this.src)>
<img src=/sml/role3/18.gif onclick=smlin(this.src)>
<img src=/sml/role3/19.gif onclick=smlin(this.src)>
<img src=/sml/role3/2.gif onclick=smlin(this.src)>
<img src=/sml/role3/20.gif onclick=smlin(this.src)>
<img src=/sml/role3/21.gif onclick=smlin(this.src)>
<img src=/sml/role3/22.gif onclick=smlin(this.src)>
<img src=/sml/role3/23.gif onclick=smlin(this.src)>
<img src=/sml/role3/24.gif onclick=smlin(this.src)>
<img src=/sml/role3/25.gif onclick=smlin(this.src)>
<img src=/sml/role3/26.gif onclick=smlin(this.src)>
<img src=/sml/role3/27.gif onclick=smlin(this.src)>
<img src=/sml/role3/28.gif onclick=smlin(this.src)>
<img src=/sml/role3/29.gif onclick=smlin(this.src)>
<img src=/sml/role3/3.gif onclick=smlin(this.src)>
<img src=/sml/role3/30.gif onclick=smlin(this.src)>
<img src=/sml/role3/31.gif onclick=smlin(this.src)>
<img src=/sml/role3/32.gif onclick=smlin(this.src)>
<img src=/sml/role3/33.gif onclick=smlin(this.src)>
<img src=/sml/role3/34.gif onclick=smlin(this.src)>
<img src=/sml/role3/35.gif onclick=smlin(this.src)>
<img src=/sml/role3/36.gif onclick=smlin(this.src)>
<img src=/sml/role3/37.gif onclick=smlin(this.src)>
<img src=/sml/role3/38.gif onclick=smlin(this.src)>
<img src=/sml/role3/39.gif onclick=smlin(this.src)>
<img src=/sml/role3/4.gif onclick=smlin(this.src)>";
        }
        if($purp=="role4"){
            $sml_e = "<img src=/sml/role4/40.gif onclick=smlin(this.src)>
<img src=/sml/role4/41.gif onclick=smlin(this.src)>
<img src=/sml/role4/42.gif onclick=smlin(this.src)>
<img src=/sml/role4/43.gif onclick=smlin(this.src)>
<img src=/sml/role4/44.gif onclick=smlin(this.src)>
<img src=/sml/role4/45.gif onclick=smlin(this.src)>
<img src=/sml/role4/46.gif onclick=smlin(this.src)>
<img src=/sml/role4/47.gif onclick=smlin(this.src)>
<img src=/sml/role4/48.gif onclick=smlin(this.src)>
<img src=/sml/role4/49.gif onclick=smlin(this.src)>
<img src=/sml/role4/5.gif onclick=smlin(this.src)>
<img src=/sml/role4/50.gif onclick=smlin(this.src)>
<img src=/sml/role4/51.gif onclick=smlin(this.src)>
<img src=/sml/role4/52.gif onclick=smlin(this.src)>
<img src=/sml/role4/53.gif onclick=smlin(this.src)>
<img src=/sml/role4/54.gif onclick=smlin(this.src)>
<img src=/sml/role4/55.gif onclick=smlin(this.src)>
<img src=/sml/role4/56.gif onclick=smlin(this.src)>
<img src=/sml/role4/57.gif onclick=smlin(this.src)>
<img src=/sml/role4/58.gif onclick=smlin(this.src)>
<img src=/sml/role4/59.gif onclick=smlin(this.src)>
<img src=/sml/role4/6.gif onclick=smlin(this.src)>
<img src=/sml/role4/60.gif onclick=smlin(this.src)>
<img src=/sml/role4/61.gif onclick=smlin(this.src)>";
        }
        if($purp=="role5"){
            $sml_e = "<img src=/sml/role5/62.gif onclick=smlin(this.src)>
<img src=/sml/role5/63.gif onclick=smlin(this.src)>
<img src=/sml/role5/64.gif onclick=smlin(this.src)>
<img src=/sml/role5/65.gif onclick=smlin(this.src)>
<img src=/sml/role5/66.gif onclick=smlin(this.src)>
<img src=/sml/role5/67.gif onclick=smlin(this.src)>
<img src=/sml/role5/68.gif onclick=smlin(this.src)>
<img src=/sml/role5/69.gif onclick=smlin(this.src)>
<img src=/sml/role5/7.gif onclick=smlin(this.src)>
<img src=/sml/role5/70.gif onclick=smlin(this.src)>
<img src=/sml/role5/71.gif onclick=smlin(this.src)>
<img src=/sml/role5/72.gif onclick=smlin(this.src)>
<img src=/sml/role5/73.gif onclick=smlin(this.src)>
<img src=/sml/role5/74.gif onclick=smlin(this.src)>
<img src=/sml/role5/75.gif onclick=smlin(this.src)>
<img src=/sml/role5/76.gif onclick=smlin(this.src)>
<img src=/sml/role5/77.gif onclick=smlin(this.src)>
<img src=/sml/role5/78.gif onclick=smlin(this.src)>
<img src=/sml/role5/79.gif onclick=smlin(this.src)>
<img src=/sml/role5/8.gif onclick=smlin(this.src)>
<img src=/sml/role5/80.gif onclick=smlin(this.src)>
<img src=/sml/role5/81.gif onclick=smlin(this.src)>
<img src=/sml/role5/82.gif onclick=smlin(this.src)>";
        }
        if($purp=="role6"){
            $sml_e = "<img src=/sml/role6/117.gif onclick=smlin(this.src)>
<img src=/sml/role6/118.gif onclick=smlin(this.src)>
<img src=/sml/role6/83.gif onclick=smlin(this.src)>
<img src=/sml/role6/84.gif onclick=smlin(this.src)>
<img src=/sml/role6/85.gif onclick=smlin(this.src)>
<img src=/sml/role6/86.gif onclick=smlin(this.src)>
<img src=/sml/role6/87.gif onclick=smlin(this.src)>
<img src=/sml/role6/88.gif onclick=smlin(this.src)>
<img src=/sml/role6/89.gif onclick=smlin(this.src)>
<img src=/sml/role6/9.gif onclick=smlin(this.src)>
<img src=/sml/role6/90.gif onclick=smlin(this.src)>
<img src=/sml/role6/91.gif onclick=smlin(this.src)>
<img src=/sml/role6/92.gif onclick=smlin(this.src)>
<img src=/sml/role6/93.gif onclick=smlin(this.src)>
<img src=/sml/role6/94.gif onclick=smlin(this.src)>
<img src=/sml/role6/95.gif onclick=smlin(this.src)>
<img src=/sml/role6/96.gif onclick=smlin(this.src)>
<img src=/sml/role6/97.gif onclick=smlin(this.src)>
<img src=/sml/role6/98.gif onclick=smlin(this.src)>
<img src=/sml/role6/99.gif onclick=smlin(this.src)>";
        }
        if($purp=="sport"){
            $sml_e = "<img src=/sml/sport/1.gif onclick=smlin(this.src)>
<img src=/sml/sport/10.gif onclick=smlin(this.src)>
<img src=/sml/sport/11.gif onclick=smlin(this.src)>
<img src=/sml/sport/12.gif onclick=smlin(this.src)>
<img src=/sml/sport/13.gif onclick=smlin(this.src)>
<img src=/sml/sport/14.gif onclick=smlin(this.src)>
<img src=/sml/sport/15.gif onclick=smlin(this.src)>
<img src=/sml/sport/16.gif onclick=smlin(this.src)>
<img src=/sml/sport/17.gif onclick=smlin(this.src)>
<img src=/sml/sport/18.gif onclick=smlin(this.src)>
<img src=/sml/sport/19.gif onclick=smlin(this.src)>
<img src=/sml/sport/2.gif onclick=smlin(this.src)>
<img src=/sml/sport/20.gif onclick=smlin(this.src)>
<img src=/sml/sport/21.gif onclick=smlin(this.src)>
<img src=/sml/sport/22.gif onclick=smlin(this.src)>
<img src=/sml/sport/23.gif onclick=smlin(this.src)>
<img src=/sml/sport/24.gif onclick=smlin(this.src)>
<img src=/sml/sport/25.gif onclick=smlin(this.src)>
<img src=/sml/sport/26.gif onclick=smlin(this.src)>
<img src=/sml/sport/27.gif onclick=smlin(this.src)>
<img src=/sml/sport/28.gif onclick=smlin(this.src)>
<img src=/sml/sport/29.gif onclick=smlin(this.src)>";
        }
        if($purp=="sport2"){
            $sml_e = "<img src=/sml/sport2/3.gif onclick=smlin(this.src)>
<img src=/sml/sport2/30.gif onclick=smlin(this.src)>
<img src=/sml/sport2/31.gif onclick=smlin(this.src)>
<img src=/sml/sport2/32.gif onclick=smlin(this.src)>
<img src=/sml/sport2/33.gif onclick=smlin(this.src)>
<img src=/sml/sport2/34.gif onclick=smlin(this.src)>
<img src=/sml/sport2/35.gif onclick=smlin(this.src)>
<img src=/sml/sport2/36.gif onclick=smlin(this.src)>
<img src=/sml/sport2/37.gif onclick=smlin(this.src)>
<img src=/sml/sport2/38.gif onclick=smlin(this.src)>
<img src=/sml/sport2/39.gif onclick=smlin(this.src)>
<img src=/sml/sport2/4.gif onclick=smlin(this.src)>
<img src=/sml/sport2/40.gif onclick=smlin(this.src)>
<img src=/sml/sport2/41.gif onclick=smlin(this.src)>
<img src=/sml/sport2/42.gif onclick=smlin(this.src)>
<img src=/sml/sport2/43.gif onclick=smlin(this.src)>
<img src=/sml/sport2/44.gif onclick=smlin(this.src)>
<img src=/sml/sport2/45.gif onclick=smlin(this.src)>
<img src=/sml/sport2/46.gif onclick=smlin(this.src)>
<img src=/sml/sport2/47.gif onclick=smlin(this.src)>
<img src=/sml/sport2/48.gif onclick=smlin(this.src)>
<img src=/sml/sport2/49.gif onclick=smlin(this.src)>
<img src=/sml/sport2/5.gif onclick=smlin(this.src)>
<img src=/sml/sport2/50.gif onclick=smlin(this.src)>";
        }
        if($purp=="sport3"){
            $sml_e = "<img src=/sml/sport3/51.gif onclick=smlin(this.src)>
<img src=/sml/sport3/52.gif onclick=smlin(this.src)>
<img src=/sml/sport3/53.gif onclick=smlin(this.src)>
<img src=/sml/sport3/54.gif onclick=smlin(this.src)>
<img src=/sml/sport3/55.gif onclick=smlin(this.src)>
<img src=/sml/sport3/56.gif onclick=smlin(this.src)>
<img src=/sml/sport3/57.gif onclick=smlin(this.src)>
<img src=/sml/sport3/58.gif onclick=smlin(this.src)>
<img src=/sml/sport3/59.gif onclick=smlin(this.src)>
<img src=/sml/sport3/6.gif onclick=smlin(this.src)>
<img src=/sml/sport3/60.gif onclick=smlin(this.src)>
<img src=/sml/sport3/61.gif onclick=smlin(this.src)>
<img src=/sml/sport3/62.gif onclick=smlin(this.src)>
<img src=/sml/sport3/63.gif onclick=smlin(this.src)>
<img src=/sml/sport3/7.gif onclick=smlin(this.src)>
<img src=/sml/sport3/8.gif onclick=smlin(this.src)>
<img src=/sml/sport3/9.gif onclick=smlin(this.src)>";
        }
        if($purp=="txt"){
            $sml_e = "<img src=/sml/txt/1.gif onclick=smlin(this.src)>
<img src=/sml/txt/10.gif onclick=smlin(this.src)>
<img src=/sml/txt/11.gif onclick=smlin(this.src)>
<img src=/sml/txt/12.gif onclick=smlin(this.src)>
<img src=/sml/txt/13.gif onclick=smlin(this.src)>
<img src=/sml/txt/14.gif onclick=smlin(this.src)>
<img src=/sml/txt/15.gif onclick=smlin(this.src)>
<img src=/sml/txt/16.gif onclick=smlin(this.src)>
<img src=/sml/txt/17.gif onclick=smlin(this.src)>
<img src=/sml/txt/18.gif onclick=smlin(this.src)>
<img src=/sml/txt/19.gif onclick=smlin(this.src)>
<img src=/sml/txt/2.gif onclick=smlin(this.src)>
<img src=/sml/txt/20.gif onclick=smlin(this.src)>
<img src=/sml/txt/21.gif onclick=smlin(this.src)>
<img src=/sml/txt/22.gif onclick=smlin(this.src)>
<img src=/sml/txt/23.gif onclick=smlin(this.src)>
<img src=/sml/txt/24.gif onclick=smlin(this.src)>
<img src=/sml/txt/25.gif onclick=smlin(this.src)>
<img src=/sml/txt/26.gif onclick=smlin(this.src)>
<img src=/sml/txt/27.gif onclick=smlin(this.src)>
<img src=/sml/txt/28.gif onclick=smlin(this.src)>
<img src=/sml/txt/29.gif onclick=smlin(this.src)>
<img src=/sml/txt/3.gif onclick=smlin(this.src)>
<img src=/sml/txt/30.gif onclick=smlin(this.src)>
<img src=/sml/txt/31.gif onclick=smlin(this.src)>
<img src=/sml/txt/32.gif onclick=smlin(this.src)>
<img src=/sml/txt/33.gif onclick=smlin(this.src)>
<img src=/sml/txt/34.gif onclick=smlin(this.src)>
<img src=/sml/txt/35.gif onclick=smlin(this.src)>
<img src=/sml/txt/36.gif onclick=smlin(this.src)>
<img src=/sml/txt/37.gif onclick=smlin(this.src)>
<img src=/sml/txt/38.gif onclick=smlin(this.src)>
<img src=/sml/txt/39.gif onclick=smlin(this.src)>
<img src=/sml/txt/4.gif onclick=smlin(this.src)>
<img src=/sml/txt/40.gif onclick=smlin(this.src)>
<img src=/sml/txt/41.gif onclick=smlin(this.src)>
<img src=/sml/txt/42.gif onclick=smlin(this.src)>
<img src=/sml/txt/43.gif onclick=smlin(this.src)>
<img src=/sml/txt/44.gif onclick=smlin(this.src)>
<img src=/sml/txt/45.gif onclick=smlin(this.src)>
<img src=/sml/txt/46.gif onclick=smlin(this.src)>
<img src=/sml/txt/47.gif onclick=smlin(this.src)>
<img src=/sml/txt/48.gif onclick=smlin(this.src)>
<img src=/sml/txt/49.gif onclick=smlin(this.src)>
<img src=/sml/txt/5.gif onclick=smlin(this.src)>
<img src=/sml/txt/50.gif onclick=smlin(this.src)>
<img src=/sml/txt/51.gif onclick=smlin(this.src)>
<img src=/sml/txt/52.gif onclick=smlin(this.src)>
<img src=/sml/txt/53.gif onclick=smlin(this.src)>
<img src=/sml/txt/54.gif onclick=smlin(this.src)>
<img src=/sml/txt/55.gif onclick=smlin(this.src)>
<img src=/sml/txt/56.gif onclick=smlin(this.src)>
<img src=/sml/txt/57.gif onclick=smlin(this.src)>
<img src=/sml/txt/58.gif onclick=smlin(this.src)>
<img src=/sml/txt/59.gif onclick=smlin(this.src)>
<img src=/sml/txt/6.gif onclick=smlin(this.src)>
<img src=/sml/txt/60.gif onclick=smlin(this.src)>
<img src=/sml/txt/61.gif onclick=smlin(this.src)>
<img src=/sml/txt/62.gif onclick=smlin(this.src)>
<img src=/sml/txt/63.gif onclick=smlin(this.src)>
<img src=/sml/txt/7.gif onclick=smlin(this.src)>
<img src=/sml/txt/8.gif onclick=smlin(this.src)>
<img src=/sml/txt/9.gif onclick=smlin(this.src)>";
        }
        if($purp=="zlo"){
            $sml_e = "<img src=/sml/zlo/1.gif onclick=smlin(this.src)>
<img src=/sml/zlo/10.gif onclick=smlin(this.src)>
<img src=/sml/zlo/11.gif onclick=smlin(this.src)>
<img src=/sml/zlo/12.gif onclick=smlin(this.src)>
<img src=/sml/zlo/13.gif onclick=smlin(this.src)>
<img src=/sml/zlo/14.gif onclick=smlin(this.src)>
<img src=/sml/zlo/15.gif onclick=smlin(this.src)>
<img src=/sml/zlo/16.gif onclick=smlin(this.src)>
<img src=/sml/zlo/17.gif onclick=smlin(this.src)>
<img src=/sml/zlo/18.gif onclick=smlin(this.src)>
<img src=/sml/zlo/19.gif onclick=smlin(this.src)>
<img src=/sml/zlo/2.gif onclick=smlin(this.src)>
<img src=/sml/zlo/20.gif onclick=smlin(this.src)>
<img src=/sml/zlo/21.gif onclick=smlin(this.src)>
<img src=/sml/zlo/22.gif onclick=smlin(this.src)>
<img src=/sml/zlo/23.gif onclick=smlin(this.src)>
<img src=/sml/zlo/24.gif onclick=smlin(this.src)>
<img src=/sml/zlo/25.gif onclick=smlin(this.src)>
<img src=/sml/zlo/26.gif onclick=smlin(this.src)>
<img src=/sml/zlo/27.gif onclick=smlin(this.src)>
<img src=/sml/zlo/3.gif onclick=smlin(this.src)>
<img src=/sml/zlo/4.gif onclick=smlin(this.src)>
<img src=/sml/zlo/5.gif onclick=smlin(this.src)>
<img src=/sml/zlo/6.gif onclick=smlin(this.src)>
<img src=/sml/zlo/7.gif onclick=smlin(this.src)>
<img src=/sml/zlo/8.gif onclick=smlin(this.src)>
<img src=/sml/zlo/9.gif onclick=smlin(this.src)>";
        }

        return $sml_e;
    }




}

