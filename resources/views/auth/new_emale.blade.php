@extends('layouts.app')
@section('title_block'){{ __('messages.Passrecovery') }}@endsection
@section('content')


        @php
        $url=$_SERVER["REQUEST_URI"];

        $start = "emlupd/"; $position = strpos($url, $start);  $idbd = substr($url, $position+7); $emailbd = $idbd;
        $finish = "/"; $position = strpos($idbd, $finish); $idbd = substr($idbd, 0, $position);

        $start = "/"; $position = strpos($emailbd, $start); $emailbd = substr($emailbd, $position+1); $key = $emailbd;
        $finish = "/"; $position = strpos($emailbd, $finish); $emailbd = substr($emailbd, 0, $position);

        $start = "/"; $position = strpos($key, $start); $key = substr($key, $position+1);

                $Alls2 = DB::table('users')->select('email')->
                where('Num', $idbd)->
                limit(1)->
                get();
                $nem = 0;
                foreach ($Alls2 as $All) { $emailbd0 = $All->email; $nem++; }

                    $idbd2 = $idbd*3;
                    $fcei1 = substr($emailbd, 3, 1); $fcei2 = substr($emailbd, 7, 1);
                   $fcii1 = substr($idbd2, 2, 1); $fcii2 = substr($idbd2, 4, 1); $fcii3 = substr($idbd2, 6, 1);
                    $key2 = "$fcii1$fcei1$fcii2$fcei2$fcii3";
                    if($key == $key2){
            $affected = DB::table('users')
                ->where('Num', $idbd)
                ->update(['email' => $emailbd]);

            if($nem>0){
             $affected2 = DB::table('Citymailpost')
                ->where('mail_visitor', $emailbd0)
                ->update(['mail_visitor' => $emailbd]);
             $affected3 = DB::table('Mailpost')
                ->where('Pmail', $emailbd0)
                ->update(['Pmail' => $emailbd]);
             $affected4 = DB::table('City_Admin2')
                ->where('mail_admin', $emailbd0)
                ->update(['mail_admin' => $emailbd]);
             }
            if($affected){ $success = __('messages.myemlupds');}
            else {$success = __('messages.notemailconfirm');}
        } else {$success = __('messages.notemailconfirm');}
        @endphp





    <table style="width:100%;"><tr><td align=center width=418>
                <h2>{{ __($success) }}</h2><br />
                <br />

<br /><br />

</td></tr></table><br /><br /><br /><br /><br />
@endsection
