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



                            </td></tr></table>
                </td></tr></table>

