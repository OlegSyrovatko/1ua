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


@php
$fenter = __('messages.fenter');
$params = array(
'client_id'     => '136596823089802',
'redirect_uri'  => 'https://1ua.com.ua/fb_reg',
'scope'         => 'email',
'response_type' => 'code',
'state'         => '123'
);
$url = 'https://www.facebook.com/dialog/oauth?' . urldecode(http_build_query($params));
// <a href="https://www.facebook.com/dialog/oauth?client_id=136596823089802&redirect_uri=https://1ua.com.ua/fb_reg&scope=email&response_type=code">ggggggggg</a>
@endphp
        <table>
            <tr><td class=fcomblue width=300><ul class=intop><li><a href="{{$url}}">{{__('messages.fenter')}}</a></li></ul></td></tr>
            <tr><td class=fcomblue width=300><ul class=intop><li><a href=/googleauth>{{__('messages.genter')}}</a></li></ul></td></tr>
        </table>

    </td></tr></table>
</td></tr></table>

