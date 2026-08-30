@extends('layouts.app')
@section('title_block'){{ __('messages.login') }}@endsection

<br /><br /><br /><br />
@guest
<script>

    function sendform() {
        var form = document.forms['login4'];
        form.submit();
    }
</script>
<div align='center'>
    <table style="width:100%;"><tr><td align=center width=500>
                <table><tr><td align=left width=450><br /><br /><h3> {{ __('messages.fadding') }}</h3><br /><br /><br />
                        </td></tr></table>
            </td></tr></table>
    <form method="POST" name=login4 action="{{ route('login') }}">
        @csrf
        <table><tr><td align=right>
                    E-mail:</td><td><div class="box"><input id="email" size=20 maxlength=50  type="email"  name="email" value="{{ $email }}" required autofocus></div></td></tr>
            <tr><td>{{ __('messages.passw') }}:</td><td><div class="box"><input id="password" size=20 maxlength=50  name="password" value="{{ $psw }}" ></div></td></tr>
            <tr><td></td><td><input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('messages.remember') }}<br /><br /> </td></tr>
            <tr><td></td><td class=fcomblue><ul class=intop><li><a onclick="sendform()">{{ __('messages.logon') }}</a></li></ul>
                </td></tr></table><br />
    </form>
</div>
@endguest
