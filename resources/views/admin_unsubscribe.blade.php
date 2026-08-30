@extends('layouts.app')
@section('title_block'){{ __('messages.unsubscribe4') }}@endsection

@section('content')


<div align = center>

    @php

$fcei1 = substr($email, 3, 1);
$fcei2 = substr($email, 7, 1);
$pas2 = "$fcei1$fcei2";

if (filter_var($email, FILTER_VALIDATE_EMAIL) && $pas==$pas2) {

    $Allc = DB::table('users')->select('domen','Im','Priz', 'adm_send')->
    where('email', $email)->get();

    foreach ($Allc as $All) {

        $domen=$All->domen; $Im=$All->Im; $Priz=$All->Priz; $adm_send=$All->adm_send;


        $lan_user = App::currentLocale();
        if(!$lan_user){$lan_user = "ua";}
        if($lan_user=="ua"){$pref="";}
        if($lan_user=="ru"){$pref="/ru";}
        if($lan_user=="en"){$pref="/en";}

        if($adm_send == '1'){
            $u6 = __('messages.unsubscribe6');
            echo"<center><br /><br /><br /><br /><br /><table><tr><td width=300 align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
            <table><tr><td width=280 align=center><br /><a href=/$domen$pref><b>$Im $Priz</b></a> <br /> $u6<br /><br />
            </td></tr></table>
            </td></tr></table></center><br /><br /><br /><br /><br />";
        }
        else{
             $affected = DB::table('users')
            ->where('domen',$domen)
            ->update(['adm_send' => '1']);
            if ($affected) {
                $u5 = __('messages.unsubscribe5');
                echo"<center><br /><br /><br /><br /><br /><table><tr><td width=300 align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
                <table><tr><td width=280 align=center><br /><a href=/$domen$pref><b>$Im $Priz</b></a> <br /> $u5<br /><br />
                </td></tr></table>
                </td></tr></table></center><br /><br /><br /><br /><br />";
            }
        }
    }
}
else {$res = __('messages.subscr3');

    echo"<center><br /><br /><br /><br /><br /><table><tr><td width=300 align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
<table><tr><td width=280 align=center><br />  $res<br /><br />
</td></tr></table>
</td></tr></table></center><br /><br /><br /><br /><br />";
}
    @endphp
</div>


@endsection
