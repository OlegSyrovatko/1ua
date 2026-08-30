@extends('layouts.app')
@section('title_block'){{ __('messages.mtit') }}@endsection
@php
$index_go = "index,follow";
$description = __('messages.meta-index-desc');
$keywords = __('messages.meta-index-keys');

$my_domen = $_SERVER['SERVER_NAME'];
$lan = App::currentLocale();
$canonical = "https://";
$canonical.=$my_domen;
if($lan == "ru" || $lan == "en"){$canonical.= "/"; $canonical .= $lan;}
$amp = "amp";
@endphp
@section('description'){{$description}}@endsection
@section('keywords'){{$keywords}}@endsection
@section('robots'){{$index_go}}@endsection
@section('canonical'){{$canonical}}@endsection
@section('amp'){{$amp}}@endsection
@section('index')index@endsection




@endsection
