@extends('layouts.app')
@section('title_block'){{ __('messages.Passrecovery') }}@endsection
@section('content')

    <script src="{{ "/js/emailremind.js" }}" defer></script>

        @php
        $url=$_SERVER["REQUEST_URI"];
        $idbd = substr($url, -14, 8);
        $my_key = substr($url, -5, 5);
        @endphp

    <table style="width:100%;"><tr><td align=center width=418>
                <h2>{{ __('messages.Passrecovery') }}</h2><br />
                <br />
<div class="box"><input type="password" id="passw3"  placeholder="{{ __('messages.passw') }}"  autofocus></div><br />
<div class="box"><input type="password" id="passw32"  placeholder="{{ __('messages.ppassw') }}"></div>
<input type="hidden" id="idbd"  value="{{ __($idbd) }}">
<input type="hidden" id="my_key"  value="{{ __($my_key) }}">

<br /><br />
<table width="200"><tr><td class=fcomblue><ul class=intopbig><li><a id=passset>{{ __('messages.Passset') }}</a></li></ul></td></tr></table>
<br /><br />
<h2><div id=setpassw ></div></h2>
</td></tr></table><br /><br /><br /><br /><br />
@endsection
