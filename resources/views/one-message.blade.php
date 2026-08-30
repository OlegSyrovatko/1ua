@extends('layouts.app')
@section('title_block'){{ $data->subject }}@endsection

@section('content')
    <h1>{{ $data->subject }}</h1>

    <div class="fcom0">
        {{ $data->message }}<br />
        {{ $data->name }} {{ $data->email }}<br />
        {{ $data->created_at }}
        <a href ="{{ route('contact-update', $data->id) }}"><button>Редагувати</button></a>
        <a href ="{{ route('contact-delete', $data->id) }}"><button>Видалити</button></a>
    </div>

@endsection


