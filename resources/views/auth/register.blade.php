@extends('layouts.app')
@section('title_block'){{ __('messages.reg') }}@endsection
@section('content')
@section('description'){{__('messages.reg')}} {{__('messages.online')}} @endsection
@php
    global $regwindowonload;
    $regwindowonload = "go";

@endphp


<section class="registration-form">
    <h1>{{ __('messages.reg') }}</h1>

    <form method="POST" name=register onsubmit=""  action="{{ route('register') }}" >
@csrf
		<label for="Im" class=mt15>{{ __('messages.Im') }}:</label>
		<input id="Im" type="text" name="Im" class="auth-el @if ($errors->has('Im')) auth-el-err @endif" value="{{ old('Im') }}" required autocomplete="Im" autofocus>
		@if ($errors->has('Im'))
			<span class="error">{{ $errors->first('Im') }}</span>
		@endif

		<label for="Priz" class=mt10>{{ __('messages.Priz') }}: </label>
		<input id="Priz" type="text" name="Priz" class="auth-el @if ($errors->has('Priz')) auth-el-err @endif" value="{{ old('Priz') }}" required autocomplete="Priz">
		@if ($errors->has('Priz'))
		 <span class="error">{{ $errors->first('Priz') }}</span>
		@endif

		<label for="sex" class=mt10>{{ __('messages.sex') }}: </label>
		<select name="sex" id="sex" class="auth-el @if ($errors->has('sex')) auth-el-err @endif">
			<option value=>{{ __('messages.sexn1') }}</option>
			<option value=1 @if (old('sex') == "1") selected @endif>{{ __('messages.sexn2') }}</option>
			<option value=2 @if (old('sex') == "2") selected @endif>{{ __('messages.sexn3') }}</option>
		</select>
		@if ($errors->has('sex'))
		 <span class="error">{{ $errors->first('sex') }}</span>
		@endif
		<label for="Who" class=mt10>{{ __('messages.Whon') }}: </label>
		<input id="Who" type="text" name="Who" class="auth-el @if ($errors->has('Who')) auth-el-err @endif" value="{{ old('Who') }}" required autocomplete="Who">
		@if ($errors->has('Who'))
		 <span class="error">{{ $errors->first('Who') }}</span>
		@endif

		<label for="Wherer" class=mt10>{{ __('messages.Place') }}: </label>
		<select name="Wherer" id=Wherer class="auth-el form-control @if ($errors->has('Wherer')) auth-el-err @endif">
			<option value="проживання" @if (old('Wherer') == "проживання") selected @endif>{{ __('messages.Place1') }}</option>
			<option value="навчання" @if (old('Wherer') == "навчання") selected @endif>{{ __('messages.Place2') }}</option>
			<option value="роботи" @if (old('Wherer') == "роботи") selected @endif>{{ __('messages.Place3') }}</option>
			<option value="відпочинку" @if (old('Wherer') == "відпочинку") selected @endif>{{ __('messages.Place4') }}</option>
			<option value="народження" @if (old('Wherer') == "народження") selected @endif>{{ __('messages.Place5') }}</option>
		</select>
		@if ($errors->has('Wherer'))
		 <span class="error">{{ $errors->first('Wherer') }}</span>
		@endif

		<label for="obl" class=mt10>{{ __('messages.Region') }}: </label>
        <select name="obl" id=obl class="auth-el form-control @if ($errors->has('obl')) auth-el-err @endif">
			<option value=>{{ __('messages.sexn1') }}</option>
			@for ($i = 1; $i <= 25; $i++)
			  {{ $ni = "messages.o$i" }}
			  <option value="{{ $i }}" @if (old('obl') == $i) selected @endif >{{ __($ni) }}</option>
			@endfor
		</select>
		@if ($errors->has('obl'))
		  <span class="error">{{ $errors->first('obl') }}</span>
		@endif
		<div id=hrayc class="mt10 un-display">
			<label for="rayc" >{{ __('messages.regionalcenter') }}: </label>
			<select name="rayc" id=rayc class="auth-el form-control @if ($errors->has('rayc')) auth-el-err @endif">
			</select>
            <input id="qrayc" type="hidden"  value="{{ old('rayc') }}">
			@if ($errors->has('rayc'))
			  <span class="error">{{ $errors->first('rayc') }}</span>
			@endif
        </div><div id=hrayc2 style="display: none;"></div>

		<div id=hidc class="mt10 @if(old('obl')) @else un-display @endif">
			<label for="idc" >{{ __('messages.Cityvil') }}: </label>
			<select name="idc" id=idc class="auth-el form-control @if ($errors->has('idc')) auth-el-err @endif">
			</select>
            <input id="qidc" type="hidden" value="{{ old('idc') }}">
			@if ($errors->has('idc'))
			  <span class="error">{{ $errors->first('idc') }}</span>
			@endif
        </div><div id=hidc2 style="display: none;"></div>

		<label for="emailreg" class="mt10">{{ __('E-mail') }}:</label>
		<input id="emailreg" type="text" name="email" class="auth-el @if ($errors->has('email')) auth-el-err @endif" value="{{ old('email') }}" required autocomplete="email">
		@if ($errors->has('email'))
			<span class="error">{{ $errors->first('email') }}</span>
		@endif


		<label for="passwordreg" class="mt10">{{ __('messages.passw') }}:</label>
		<input id="passwordreg" type="password" name="password" class="auth-el @if ($errors->has('password')) auth-el-err @endif"  required autocomplete="password">
		@if ($errors->has('password'))
			<span class="error">{{ $errors->first('password') }}</span>
		@endif

        <label for="password-confirm" class="mt10">{{ __('messages.ppassw') }}:</label>
        <input id="password-confirm" type="password"  name="password_confirmation" class="auth-el @if ($errors->has('password')) auth-el-err @endif" required autocomplete="new-password"></div>

        <label for="readed" id="auth-la-check">
        <input type=checkbox name=readed id=readed  @if (old('readed')) checked @endif class = "mt15">
                @if ($errors->has('readed'))
                    <span class="error">{{ $errors->first('readed') }}</span>
                @endif

                {{ __('messages.rules1') }} <a class="auth-links" target="_blank" href="/rules/{{ __('messages.lan') }}">{{ __('messages.rules2') }}</a> {{ __('messages.rules3') }}
                {{__('messages.lic_cookie45')}} <a class="auth-links" target="_blank" href="/policy/{{ __('messages.lan') }}"> {{__('messages.lic_cookie455')}}</a>
        </label>
        <button class = "auth-button mt15" onclick="document.forms.register.submit();" type="submit">{{ __('messages.reg') }}</button>


    </form>

</section>
<br /><br /><br /><br /><br />

@endsection
