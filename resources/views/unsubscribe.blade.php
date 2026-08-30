@extends('layouts.app')
@section('title_block'){{ __('messages.unsubscribe4') }}@endsection

@section('content')


<div align = center>

    @php

    $id=$id+1; $id=$id-1;
if(is_int($id)!="true"){die("");}
$Pmail = $email;

if (filter_var($Pmail, FILTER_VALIDATE_EMAIL)) {
if($id>=70000000){

	    $Allc = DB::table('users')->select('domen','Im','Priz')->
                        where('id', $id)->limit(1)->get();
                        $nc=0;
                        foreach ($Allc as $All) { $domen=$All->domen; $Im=$All->Im; $Priz=$All->Priz; $nc++;}


                    $lan_user = App::currentLocale();
                    if(!$lan_user){$lan_user = "ua";}
                    if($lan_user=="ua"){$pref="";}
                    if($lan_user=="ru"){$pref="/ru";}
                    if($lan_user=="en"){$pref="/en";}


            $affected = DB::table('Mailpost')
                ->where('Nump', $id)->where('Pmail', $Pmail)
                ->delete();

	$u0 = __('messages.unsubscribe0');
    $u2 = __('messages.unsubscribe2');
    $u22 = __('messages.unsubscribe22');
    $u3 = __('messages.unsubscribe3');
    if($affected && $nc>0) {
        $res = "$u0<br /> <a href=/$domen$pref><b>$Im $Priz</b></a> <br /><br />$u2<br /><br />$u3 ;)";
    }
    else if($nc>0) {
        $res = "$u0<br /> <a href=/$domen$pref><b>$Im $Priz</b></a> <br /><br />$u22";
    }


}

else{

    $Allc = DB::table('Allcities')->select('ab')->
                        where('id', $id)->limit(1)->get();
                        $nc=0;
                        foreach ($Allc as $All) { $ab=$All->ab; $nc++;}
                        if($nc!=0){
                            $pagec = explode("#!", $ab);

                            $City=$pagec[1]; $City2=$pagec[2];  $City11=$pagec[11]; $domen=$pagec[12];
                    $lan_user = App::currentLocale();
                    if(!$lan_user){$lan_user = "ua";}
                    if($lan_user=="ua"){$Citym=$City; $pref="";}
                    if($lan_user=="ru"){$Citym=$City2; $pref="/ru";}
                    if($lan_user=="en"){$Citym=$City11; $pref="/en";}
            }


            $affected = DB::table('Citymailpost')
                ->where('id', $id)->where('mail_visitor', $Pmail)
                ->delete();
    $u1 = __('messages.unsubscribe1');
    $u2 = __('messages.unsubscribe2');
    $u22 = __('messages.unsubscribe22');
    $u3 = __('messages.unsubscribe3');
    if($affected && $nc>0) {
        $res = "$u1<br /> <a href=/$domen$pref><b>$Citym</b></a> <br /><br />$u2<br /><br />$u3 ;)";
    }
    else if($nc>0) {
        $res = "$u1<br /> <a href=/$domen$pref><b>$Citym</b></a> <br /><br />$u22";
    }


}
}
else {$res = __('messages.subscr3');}

    echo"<center><br /><br /><br /><br /><br /><table><tr><td width=300 align=center class=fcom onMouseOver=\"this.style.background='white'\" onMouseOut=\"this.style='fcom'\">
<table><tr><td width=280 align=center><br />  $res<br /><br />
</td></tr></table>
</td></tr></table></center><br /><br /><br /><br /><br />";

    @endphp
</div>


@endsection
