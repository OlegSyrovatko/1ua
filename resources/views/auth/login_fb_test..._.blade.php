@extends('layouts.app')
@section('title_block'){{ __('messages.login') }}@endsection

<br /><br /><br /><br />

<div class="hidblokwide">
        <table style="width:100%;"><tr><td align=center width=418>
                    <form method="POST" name=login3 action="{{ route('login') }}">
                        @csrf
                    <table><tr><td align=right>
                                E-mail:</td><td><div class="box"><input id="email" size=20 maxlength=50  type="email"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus></div></td></tr>
                        <tr><td>{{ __('messages.passw') }}:</td><td><div class="box"><input id="password" size=20 maxlength=50  type="password" name="password" required autocomplete="current-password"></div></td></tr>
                            <tr><td></td><td><input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('messages.remember') }}<br /><br /> </td></tr>
                            <tr><td></td><td class=fcomblue><ul class=intop><li><a href="javascript:document.forms.login3.submit();">{{ __('messages.logon') }}</a></li></ul>


                            </td></tr></table><br />
                    </form>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('messages.fogpas') }}
                        </a>

                    @endif
                </td></tr></table>
    </div>

<br /><br />
    <table style="width:100%;"><tr>
                <td align=center valign=center >
                    <table style="width:90%;"><tr><td align=center>

                                <h4>{{ __('messages.ulogin_not_work') }}</h4> <br />

                                <div id="fb-root"></div>
                                <div id="fb-root"></div>

                                @php
                                if (App::isLocale('ua')){$alen = "uk_UA";}
                                if (App::isLocale('ru')){$alen = "ru_RU";}
                                if (App::isLocale('en')){$alen = "en_GB";}
                                @endphp
                                <script>

                                    function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
                                        console.log('statusChangeCallback');
                                        console.log(response);                   // The current login status of the person.
                                        if (response.status === 'connected') {   // Logged into your webpage and Facebook.
                                            testAPI();
                                        } else {                                 // Not logged into your webpage or we are unable to tell.
                                            document.getElementById('status').innerHTML = 'Please log ' +
                                                'into this webpage.';
                                        }
                                    }


                                    function checkLoginState() {               // Called when a person is finished with the Login Button.
                                        FB.getLoginStatus(function(response) {   // See the onlogin handler
                                            statusChangeCallback(response);
                                        });
                                    }


                                    window.fbAsyncInit = function() {
                                        FB.init({
                                            appId      : '136596823089802',
                                            cookie     : true,                     // Enable cookies to allow the server to access the session.
                                            xfbml      : true,                     // Parse social plugins on this webpage.
                                            version    : 'v14.0'           // Use this Graph API version for this call.
                                        });


                                        FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
                                            statusChangeCallback(response);        // Returns the login status.
                                        });
                                    };

                                    function testAPI() {

                                        // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
                                        console.log('Welcome!  Fetching your information.... ');
                                        FB.api('/home', function(response) {


                                            console.log('Successful login for: ' + response.name);
                                            document.getElementById('status').innerHTML =
                                                'Thanks for logging in, ' + response.name + '!';

                                        });
                                    }

                                </script>

                                <div class="fb-login-button" data-width="" data-size="large" data-button-type="login_with" data-layout="default" data-auto-logout-link="true" data-use-continue-as="true"></div>
                                <div id="status">
                                </div>



                                <div id="fb-root"></div>
                                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/{{$alen}}/sdk.js#xfbml=1&version=v14.0&appId=136596823089802&autoLogAppEvents=1" nonce="oYzbRhKF"></script>

                            </td></tr></table>
                </td></tr></table>

