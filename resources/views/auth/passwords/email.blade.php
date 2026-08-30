@extends('layouts.app')
@section('title_block'){{ __('messages.Passrecovery') }}@endsection
@section('content')

    <script src="{{ "/js/emailremind.js" }}" defer></script>

    <table style="width:100%;"><tr><td align=center width=418>
        <h2>{{ __('messages.Passrecovery') }}</h2><br />

     <div class="box"><input id="email3" type="email" placeholder="{{ __('E-mail') }}"  autofocus></div>

<br /><br />
<table width="200"><tr><td class=fcomblue><ul class=intopbig><li><a id=passsend>{{ __('messages.Passsend') }}</a></li></ul></td></tr></table>
<br /><br />
<h2><div id=emailremind ></div></h2>
</td></tr></table><br /><br /><br /><br /><br />
@endsection
