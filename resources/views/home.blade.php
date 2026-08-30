@extends('layouts.app')

@guest
 @php  $title = __('messages.stepreg'); @endphp
@else
    @php
        $Alls = DB::table('users')->select('id', 'Im', 'Priz')->
            where('id', Auth::user()->id)->
          limit(1)->
            get();
            foreach ($Alls as $All) { $Im=$All->Im; $Priz=$All->Priz;  }
        $title = "$Im $Priz";
    @endphp

@endguest

@section('title_block') @php echo $title; @endphp @endsection
@section('content')

@guest

                @php $stepreg2 = __('messages.stepreg2');  @endphp
                        <style>TABLE { COLOR:#29476b; FONT-FAMILY: "Verdana"}
                        A { color : #2a507e; font-family : Verdana; text-decoration : none; }
                        A:Active { color : #FF9966; } A:Hover { color : #000000; } </style>
                        <div align='center'>
                        <table style="width:100%;"><tr><td align=center width=500>
                            <table><tr><td align=left width=450><br /><br /><h3> {{ $stepreg2 }}</h3><br /><br /><br />
                            </td></tr></table>
                         </td></tr></table>
                        </div>
@else
    @php $stepreg4 = __('messages.stepreg4');
    $lanem = App::currentLocale();
  if($lanem == "ua"){$pre = "i";}
  if($lanem == "ru"){$pre = "ri";}
  if($lanem == "en"){$pre = "ei";}
  $id = Auth::user()->id;
  $link="$pre$id";
     @endphp
    <br /><br /><br /><div align='center'><a href =/{{$link}} > {{ $stepreg4 }} </a></div><br /><br /><br />
@php
echo "<html><head><meta http-equiv='refresh' content='1; url=/$link'></head></html>";
@endphp



@endguest




@endsection
