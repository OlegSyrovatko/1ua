@section('top_unreg')
<header class="menu fcom0">
	@guest

		<ul class="submenu intopmenu" >
			<li class="fcomblue hidblok min-text">
				<a href="/">1ua.com.ua</a>
			</li>
			<li class="fcomblue hidblokwide min-text">
				<a href="/">1ua</a>
			</li>
			@if (Route::has('register'))
				<li class="fcomblue min-text">
					<a href="{{ route('register') }}/{{ __('messages.lan') }}">{{ __('messages.reg') }}
                        @if (View::hasSection('amp')) / {{ __('messages.enter') }} @endif

                    </a>
				</li>
			@endif
			@if (Route::has('login'))
				<li class="enter fcomblue min-text">
					<a href="{{ route('login') }}/{{ __('messages.lan') }}">{{ __('messages.logn') }}</a>
				</li>
				<li class="hidblok-extra-wide fcomblue">

						<a href=/googleauth>{{__('messages.genter')}}</a>
				</li>
				@if (Route::has('password.request'))
					<li class="forgot-pwd fcomblue min-text">
						<a class="btn btn-link" href="{{ route('password.request') }}">
							<b>{{ __('messages.fogpas') }}</b>
						</a>
					</li>
				@endif
			@endif
		</ul>
		@if (!View::hasSection('amp'))
			<div class="hidblok-extra-wide">
				<form method="POST" name=login3 action="/login">
					@csrf
					<div class=reg-form>
						<label class="box login-input">E-mail: <input id="email" size=18 maxlength=50 type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus></label>
						<label class="box login-input">{{ __('messages.passw') }}: <input id="password" size=18 maxlength=50 type="password" name="password" required autocomplete="current-password"></label>
						<label class="box"><input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('messages.remember') }}</label>
						<a class = "auth-button" href="javascript:document.forms.login3.submit();">{{ __('messages.logon') }}</a>
					</div>
				</form>
			</div>
		@endif
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
		$menu_e = "<a href=\"$userlink\">$name_e</a>";
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
				$menu_new = "<td align=center><a href=\"/$infriends_link\"><b>$new_friends</b> (<b class=\"red;\">+$fr</b>)</a></td>";
				$rrr = rand(0,1);
				if($rrr==0){$menu_e=$menu_new;}
			}
		}
		@endphp
		<ul class="submenu intopmenu" >
			<li class="fcomblue min-text hidblok"><a href="/">1ua.com.ua</a></li>
			<li class="fcomblue min-text hidblokwide"><a href="/">1ua</a></li>
			<li class="fcomblue min-text"><a href="/{{__('messages.pref_page')}}searc">{{ __('messages.cities') }}</a></li>
			<li class="fcomblue min-text"><a href="/{{__('messages.pref_page')}}infp">{{ __('messages.people0') }}</a></li>
			<li class="fcomblue min-text">@php echo"$menu_e"; @endphp</li>
			<li class="fcomblue min-text hidblokwide"><a class="nav-link" href="/settings">&#9776;</a></li>
			<li class="fcomblue min-text hidblok"><a class="nav-link" href="/settings">{{ __('messages.Settings') }}</a></li>
		</ul>
	@endguest

</header>


