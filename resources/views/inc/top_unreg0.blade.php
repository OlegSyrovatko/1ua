@section('top_unreg')


<!-- Authentication Links -->


<div class="menu"; style="width: 100%; margin: 0 auto; text-align: center;">

    <table style="width:100%;"><tr><td align=center class=fcom0>

            @guest
        <div class="layer1" >
             <table style="width:100%; margin:7px 0px 7px 0px; "><tr>
                <td style="width:33.33%;">
                    <table style="width:100%;"><tr><td class=fcomblue><ul class=intop_right><li><a href=/index.php>1ua.com.ua</a> </li></ul></td></tr></table>
                </td>
                @if (Route::has('register'))
                    <td style="width:33.33%;">

                        <table style="width:100%;"><tr><td class=fcomblue><ul class=intop><li><a class="nav-link" href="{{ route('register') }}/{{ __('messages.lan') }}">{{ __('messages.reg') }}</a></li></ul></td></tr></table>
                    </td>
                @endif
                @if (Route::has('login'))
                    <td style="width:33.33%;">
                        <table style="width:100%;"><tr><td class=fcomblue><ul class=intop_left><li><a class="nav-link" href="{{ route('login') }}/{{ __('messages.lan') }}">{{ __('messages.logn') }}</a></ul></td></tr></table>
                    </td>
                @endif
            </tr>
            </table>

        </div>
        <div class="layer1"><div class="hidblok">
            <table style="width:100%;"><tr><td align=center width=418>
                <form method="POST" name=login3 action="/login">
                <table><tr><td>
                            @csrf
                                E-mail: </td><td><div class="box"><input id="email" style="width: 120px; height: 6px;" size=20 maxlength=50 type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus></div>

                    </td><td>{{ __('messages.passw') }}: </td><td> <div class="box"><input style="width: 120px; height: 6px;" id="password" size=20 maxlength=50  type="password" name="password" required autocomplete="current-password"></div>

                    </td><td width="150" align="center"><input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('messages.remember') }}<br />
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('messages.fogpas') }}
                                </a>
                            @endif
                    </td><td class=fcomblue width="100"><ul class=intop><li><a href="javascript:document.forms.login3.submit();">{{ __('messages.logon') }}</a></li></ul>
                 </td></tr></table>
                </form>
             </td></tr></table>
        </div></div>
        <div class="clear"></div>



        @else
            @php
            if(strlen(Auth::user()->domen)>2){$userlink=Auth::user()->domen;
                if (App::isLocale('ua')) $userlink="/$userlink";
                if (App::isLocale('ru')) $userlink="/$userlink/ru";
                if (App::isLocale('en')) $userlink="/$userlink/en";
            }
            else{$myid = Auth::user()->id;
                if (App::isLocale('ua')) $userlink="/i$myid";
                if (App::isLocale('ru')) $userlink="/ri$myid";
                if (App::isLocale('en')) $userlink="/ei$myid";
            }
            $name_e = Auth::user()->Im;
            $menu_e = "<td class=fcomblue><ul class=intop><li><a class=\"nav-link\" href=\"$userlink\">$name_e</a></li></ul></td>";
            if (Auth::user()) {
                $myid = Auth::user()->id;
                $memory_contents = Auth::user()->abin;

                $mesall = strstr($memory_contents,"mes");
                list($mess) = sscanf($mesall, "mes%d");
                if($mess>0){$unreadmessage=$mess; $unreadm="(<b>$mess</b>)";}
                $frall = strstr($memory_contents,"fr");
                list($fr) = sscanf($frall, "fr%d");
                if($fr>0){
                    $pref_page = __('messages.pref_page');
                    $infriends0 = "infriends";
                    $infriends_link = "$pref_page$infriends0/$myid/date";
                    $new_friends = __('messages.new_friends');
                    $menu_new = "<td align=center><a href=\"/$infriends_link\"><b>$new_friends</b> (<b style=\"color:red;\">+$fr</b>)</a></td>";
                    $rrr = rand(0,1);
                    if($rrr==0){$menu_e=$menu_new;}
                }

            }
            @endphp
            <table style="width:100%;"><tr>
                <td style="width:20%;">
                    <table style="width:100%;"><tr><td class=fcomblue><ul class=intop><li><a href=/index.php>1ua.com.ua</a></li></ul></td></tr></table>
                </td>
                <td style="width:20%;">
                        <table style="width:100%;"><tr><td class=fcomblue><ul class=intop><li><a class="nav-link" href="/{{__('messages.pref_page')}}searc">{{ __('messages.cities') }}</a></li></ul></td></tr></table>
                </td>
                <td style="width:20%;">
                    <table style="width:100%;"><tr><td class=fcomblue><ul class=intop><li><a class="nav-link" href="/{{__('messages.pref_page')}}infp">{{ __('messages.people0') }}</a></li></ul></td></tr></table>
                </td>
                <td style="width:20%;">
                    <table style="width:100%;"><tr>@php echo"$menu_e"; @endphp</tr></table>
                </td>
                <td style="width:20%;">
                    <table style="width:100%;"><tr><td class=fcomblue><ul class=intop><li><a class="nav-link" href="/settings"><div class="hidblokwide">&#9776;</div><div class="hidblok">{{ __('messages.Settings') }}</div></a></li></ul></td></tr></table>
                </td>
                </tr>
            </table>

        @endguest

     </td></tr></table>

</div>


