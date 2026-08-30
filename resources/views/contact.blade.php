@extends('layouts.app')
@section('title_block')Зворотній зв'язок@endsection

@section('content')
<div align=center>
<table><tr><td width=500 align=center class=fcom0>
 <table><tr><td><td width=5></td><td align="center">
             <h1>Зворотній зв'язок </h1>

             <form action="{{ route('contact-form') }}" method="post">
                 @csrf
<table>
<tr><td align=right><label for "name">Введіть ім'я:</label></td><td>
        <input type = "text" name="name" placeholder="Введіть ім'я" id="name" value="{{ old('name') }}" required></td></tr>
<tr><td align=right><label for "email">Введіть email:</label></td><td>
        <input type = "text" name="email" placeholder="Введіть email" id="email" value="{{ old('email') }}" required></td></tr>
<tr><td align=right><label for "subject">Тема повідомлення:</label></td><td>
        <input type = "text" name="subject" placeholder="Тема повідомлення" id="subject" value="{{ old('subject') }}" required></td></tr>
<tr><td align=right><label for "message">Повідомлення:</label></td><td>
        <textarea name="message" placeholder="Введіть повідомлення" id="message"  required>{{ old('message') }}</textarea></td></tr>
<tr><td align=right></td><td>
        <button type ="submit">Відправити</button></td></tr>
</table>

</form>
</td><td width=5></td></tr></table>
</td></tr></table>
</div>

<br /><br /><br />

@endsection


