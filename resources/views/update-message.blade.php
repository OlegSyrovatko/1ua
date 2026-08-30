@extends('layouts.app')
@section('title_block')Оновлення запису@endsection

@section('content')
<div align=center>
<table><tr><td width=500 align=center class=fcom0>
 <table><tr><td><td width=5></td><td align="center">
             <h1>Оновлення запису </h1>

             <form action="{{ route('contact-update-submit', $data->id) }}" method="post">
                 @csrf
<table>
<tr><td align=right><label for "name">Введіть ім'я:</label></td><td>
        <input type = "text" name="name" value="{{$data->name }}" placeholder="Введіть ім'я" id="name"></td></tr>
<tr><td align=right><label for "email">Введіть email:</label></td><td>
        <input type = "text" name="email" value="{{$data->email }}" placeholder="Введіть email" id="email"></td></tr>
<tr><td align=right><label for "subject">Тема повідомлення:</label></td><td>
        <input type = "text" name="subject" value="{{$data->subject }}" placeholder="Тема повідомлення" id="subject"></td></tr>
<tr><td align=right><label for "message">Повідомлення:</label></td><td>
        <textarea name="message" placeholder="Введіть повідомлення" id="message">{{$data->message }}</textarea></td></tr>
<tr><td align=right></td><td>
        <button type ="submit">Оновити</button></td></tr>
</table>

</form>
</td><td width=5></td></td></tr></table>
</td></tr></table>
</div>

<br /><br /><br />

@endsection


