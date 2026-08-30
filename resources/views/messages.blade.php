@extends('layouts.app')
@section('title_block')Повідомлення@endsection

@section('content')
    <h1>Повідомлення</h1>
    @foreach($data as $el)
    <div class="fcom0">
        <h3>{{ $el->subject }}</h3>
        {{ $el->email }}<br />
        {{ $el->created_at }}
        <a href ="{{ route('contact-data-one', $el->id ) }}"><button>Детальніше</button></a>
    </div>
    @endforeach



@endsection


