@extends('layouts.app')
@section('title_block'){{ __('messages.settings') }}@endsection

@section('content')

    @guest

    @else

        <script src="{{ "/js/adm.js" }}" defer></script>


        <div  align = center>
<div class="layermaxwideadm" >

    <div class="adm1">
        <table>
            <tr><td align=center valign=top width=480 class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'">
<br />
                    @php
                            $avatar = Auth::user()->avatar;
                        if ($avatar>0){$path0 = "/storage/avatar/b$avatar.jpg"; }
                        else {$path0="/b7.jpg";}
                    @endphp

                    <div id="avload" > <img src = "{{ $path0 }}">
                        <div id=load_on style="text-align: center; padding-right: 5px; padding-left: 5px; display: none;">
                            <h5>{{ __('messages.Loading_wait') }}<br />
                                <img SRC="/images/upload.gif"><br />
                                {{ __('messages.Loading_wait2') }}</h5>
                        </div>
                    </div>

                    <input id="image" style="width: 90%" accept="image/jpeg" type=file name="image"
                           onchange=load_av.style.display='block';>
                    <div id="load_av" style="display: none;"><table>
                        <tr><td class="fcomblue" width=100>
                                <ul class="intop"><li><a id=av_load >{{ __('messages.Refresh') }}</a></li></ul>
                            </td></tr>
                        </table></div>


                    @php

                    if (Auth::user()->avatar>0){$del = __('messages.Delete'); echo"<table>
                        <tr><td class=\"fcomblue\" width=100>
                                <ul class=\"intop\"><li><a id=av_delete > $del </a></li></ul>
                            </td></tr>
                    </table>";
                     }

                    @endphp
                    <br /><br />



                    @php
                        $wh_domen=$_SERVER["HTTP_HOST"]; $id = Auth::user()->id; $allid = $wh_domen; $allid.="/"; $allid.= __('messages.pref_page'); $allid.="i"; $allid.=$id;
                        $domen=Auth::user()->domen;
                        if($domen){
                    $doment="."; $doment.=$domen; $domene = explode(".", $doment); $domen1=$domene[1]; $domen2=$domene[2];
                    } else{$domen1 = ""; $domen2 = "";}
                    @endphp
                    <h4>{{ __('messages.Num_page') }}:</h4> {{ $allid }} <br />
                    {{ __('messages.Num_advise') }}

                    <table><tr><td align=right>
                                <b>{{ $wh_domen }}</b>/<br />
                                <input type="text" id="domen1" SIZE=9 maxlength = 20 value="{{ $domen1 }}"><b>.</b>
                                <input type="text" id="domen2" SIZE=14 maxlength = 30 value="{{ $domen2 }}">
                                <br />
                            </td></tr></table>
                    <table>
                        <tr><td class="fcomblue" width=180>
                                <ul class="intop"><li><a id=ch_adress >{{ __('messages.ch_adress') }}</a></li></ul>
                            </td></tr>
                    </table>
                    <div id=chadress ></div>
                    <br />

                </td></tr></table>

        <table>
            <tr><td align=center valign=top width=480 class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'">

                        <h3>{{ __('messages.news_to_users') }}</h3>
                    <table><tr><td align="left" width=180>
                        {{ __('messages.sh_news_to_users') }}<br /><br />
                        @php
                        $s_news=Auth::user()->show_news;
                        $nfriend=substr($s_news, 0, 1);
                        $nforum=substr($s_news, 1, 1);
                        $nfoto=substr($s_news, 2, 1);
                        $ncoment=substr($s_news, 3, 1);
                        $nratef=substr($s_news, 4, 1);
                        $napps=substr($s_news, 6, 1);
                        $nowns=substr($s_news, 8, 1);
                        $nvideo=substr($s_news, 9, 1);
                        $nguests=substr($s_news, 10, 1);

                        if($nfriend==""){$nfriend=1;}
                        if($nforum==""){$nforum=1;}
                        if($nfoto==""){$nfoto=1;}
                        if($ncoment==""){$ncoment=1;}
                        if($nratef==""){$nratef=1;}
                        if($napps==""){$napps=1;}
                        if($nowns==""){$nowns=1;}
                        if($nvideo==""){$nvideo=1;}
                        if($nguests==""){$nguests=1;}

                        @endphp
                                    <b>
                                        <input type=checkbox id=cnowns @php if($nowns!=0){echo"checked";}@endphp> <img src=/images/nowns.png> {{ __('messages.n_os') }}<br />
                                        <input type=checkbox id=cnfriend @php if($nfriend!=0){echo"checked";}@endphp> <img src=/images/nfriend.png> {{ __('messages.Friends') }}<br />
                                        <input type=checkbox id=cnfoto @php if($nfoto!=0){echo"checked";}@endphp> <img src=/images/nfoto.png> {{ __('messages.Foto') }}<br />
                                        <input type=checkbox id=cnvideo @php if($nvideo!=0){echo"checked";}@endphp> <img src=/images/nvideo.png> {{ __('messages.Video') }}<br />
                                        <input type=checkbox id=cnapps @php if($napps!=0){echo"checked";}@endphp> <img src=/images/napps.png> {{ __('messages.App') }}<br />
                                        <input type=checkbox id=cnratef @php if($nratef!=0){echo"checked";}@endphp> <img src=/on.png> {{ __('messages.Est') }}<br />
                                        <input type=checkbox id=cnforum @php if($nforum!=0){echo"checked";}@endphp> <img src=/images/nforum.png> {{ __('messages.Forum') }}<br />
                                        <input type=checkbox id=cncoment @php if($ncoment!=0){echo"checked";}@endphp> <img src=/images/ncoment.png> {{ __('messages.Comment') }}<br />
                                        <input type=checkbox id=cnguests @php if($nguests!=0){echo"checked";}@endphp> <img src=/images/nguests.png> {{ __('messages.Guests') }}<br />
                                    </b>
                                    <table><tr><td class="fcomblue" width=120>
                                                <ul class="intop"><li><a id=setnews>{{ __('messages.save') }}</a></li></ul>
                                            </td></tr></table>
                                    <div style="padding-right: 5px; padding-left: 5px;"><div id=set_news ></div></div>
                                    <br />
                     </td></tr></table>
                </td></tr></table>
        <br /><br />
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                crossorigin="anonymous"></script>
        <!-- Адаптивный -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-7495053896041990"
             data-ad-slot="5938872690"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

    </div>



    <div class="adm3">


        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                crossorigin="anonymous"></script>
        <!-- Адаптивный -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-7495053896041990"
             data-ad-slot="5938872690"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>


        <table>
            <tr><td align=right valign=top width=480 class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'">
             <div style="padding-right: 3px; padding-left: 3px;">
                 <br />
                 <table><tr><td width=220 class=fcomblue><ul class=intop><li><a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                             {{ __('messages.logout_big') }}
                         </a>
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                             @csrf
                         </form>
                 </ul></td></tr></table>
                 <br />
                    <div align="center"><h3>{{ __('messages.mydata') }}</h3></div>

                    {{ __('messages.Im') }}: <input type="text" id="Im" SIZE=20 maxlength = 25 value="{{ Auth::user()->Im }}"><br />
                    {{ __('messages.Bat') }}: <input type="text" id="Bat" SIZE=20 maxlength = 25 value="{{ Auth::user()->Bat }}"><br />
                    {{ __('messages.Priz') }}: <input type="text" id="Priz" SIZE=20 maxlength = 25 value="{{ Auth::user()->Priz }}"><br />
                    {{ __('messages.Who') }}: <input type="text" id="Who" SIZE=20 maxlength = 25 value="{{ Auth::user()->Who }}">
                    <input type="hidden" id="badw" value="{{ __('messages.badwords') }}">
                    <table>
                        <tr><td class="fcomblue" width=220>
                                <ul class="intop"><li><a id=ch_reg>{{ __('messages.ch_reg') }}</a></li></ul>
                            </td></tr>
                    </table>
                    <div style="padding-right: 5px; padding-left: 5px;"><div id=chreg ></div></div>
                    <br />
                    {{ __('messages.eml_lgn') }}: <input type="text" id="email" SIZE=20 maxlength = 50 value="{{ Auth::user()->email }}"><br />
                    {{ __('messages.passw') }}: <input type="password" id="passw" SIZE=20 maxlength = 50 ><br />
                    {{ __('messages.ppassw') }}: <input type="password" id="passw2" SIZE=20 maxlength = 50 ><br />
                    <table>
                        <tr><td class="fcomblue" width=220>
                                <ul class="intop"><li><a id=ch_eml_lgn>{{ __('messages.ch_eml_lgn') }}</a></li></ul>
                            </td></tr>
                    </table>
                    <div id=chemllgn ></div>







        <br />
         <table><tr><td align=right>
                     {{ __('messages.do_data') }} <div style="color: green" > (+20 {{ __('messages.votes') }})</div>

                 {{ __('messages.sex') }}:
                     <select id="sex">
                     <option value=0 @php if(Auth::user()->sex==0||!Auth::user()->sex){echo" selected";} @endphp>{{ __('messages.sexn1') }}</option>
                     <option value=1 @php if(Auth::user()->sex==1){echo" selected";} @endphp>{{ __('messages.sexn2') }}</option>
                     <option value=2 @php if(Auth::user()->sex==2){echo" selected";} @endphp>{{ __('messages.sexn3') }}</option>
                 </select>
                 <br /><table><tr><td>{{ __('messages.fam_st') }}:
                     <select id="partner">
                         <option value=0 @php if((Auth::user()->partner==0) || (!Auth::user()->partner)){echo" selected";} @endphp>{{ __('messages.partner0') }}</option>
                         <option value=1 @php if(Auth::user()->partner==1) {echo" selected";} @endphp>@php if((Auth::user()->sex==0) || (!Auth::user()->sex)){echo __('messages.partner1'); } if(Auth::user()->sex==1){echo __('messages.partner11'); } if(Auth::user()->sex==2){ echo __('messages.partner21'); } @endphp </option>
                         <option value=2 @php if(Auth::user()->partner==2) {echo" selected";} @endphp>@php if((Auth::user()->sex==0) || (!Auth::user()->sex)){echo __('messages.partner2'); } if(Auth::user()->sex==1){echo __('messages.partner12'); } if(Auth::user()->sex==2){ echo __('messages.partner22'); } @endphp </option>
                         <option value=3 @php if(Auth::user()->partner==3) {echo" selected";} @endphp>@php if((Auth::user()->sex==0) || (!Auth::user()->sex)){echo __('messages.partner3'); } if(Auth::user()->sex==1){echo __('messages.partner13'); } if(Auth::user()->sex==2){ echo __('messages.partner23'); } @endphp </option>
                         <option value=4 @php if(Auth::user()->partner==4) {echo" selected";} @endphp>@php if((Auth::user()->sex==0) || (!Auth::user()->sex)){echo __('messages.partner4'); } if(Auth::user()->sex==1){echo __('messages.partner14'); } if(Auth::user()->sex==2){ echo __('messages.partner24'); } @endphp </option>
                         <option value=5 @php if(Auth::user()->partner==5) {echo" selected";} @endphp>@php if((Auth::user()->sex==0) || (!Auth::user()->sex)){echo __('messages.partner5'); } if(Auth::user()->sex==1){echo __('messages.partner5'); } if(Auth::user()->sex==2){ echo __('messages.partner5'); } @endphp </option>
                         <option value=6 @php if(Auth::user()->partner==6) {echo" selected";} @endphp>@php if((Auth::user()->sex==0) || (!Auth::user()->sex)){echo __('messages.partner6'); } if(Auth::user()->sex==1){echo __('messages.partner6'); } if(Auth::user()->sex==2){ echo __('messages.partner6'); } @endphp </option>
                     </select>
                             </td></tr></table>
                     <table><tr><td>{{ __('messages.bday') }}: @php if((Auth::user()->bday==0) || (!Auth::user()->bmonth) || (Auth::user()->bmonth==0) || (!Auth::user()->byear) || (Auth::user()->byear==0) || (!Auth::user()->bday) || (Auth::user()->bday_visib==2)){ echo"</td><td><div style=\"color: green\" ><img src=\"/up.gif\">+5</div>"; } @endphp
                             </td></tr></table>
                     {{ __('messages.dayn') }}: <select id="bday">
                         @php for ($a=0; $a<32; $a++){ echo"<option value=$a";
                            if(Auth::user()->bday==$a){echo" selected";}
                            if($a==0){echo ">"; echo __('messages.chopt'); }
                            else{ echo">$a";}
                            echo "</option>";} @endphp
                     </select>
                     <br />

                     {{ __('messages.mon') }}: <select id="bmonth">
                         @php for ($a=0; $a<13; $a++){ echo"<option value=$a";
                            if(Auth::user()->bmonth==$a){echo" selected";}
                            if($a==0){echo ">"; echo __('messages.chopt'); }
                            else{ echo">"; $mon_e = "messages.mon$a"; echo __($mon_e); }
                            echo "</option>";} @endphp
                     </select>
                     <br />

                     {{ __('messages.yearn') }}: <select id="byear">
                         @php $ty=date('Y')-7; for ($a=1930; $a<$ty; $a++){ echo"<option value=$a";
                            if(Auth::user()->byear==$a){echo" selected";}
                            if($a==1930){echo ">"; echo __('messages.chopt'); }
                            else{ echo">$a";}
                            echo "</option>";} @endphp
                     </select>
                     <br />

                     <select id="bday_visib">
                         <option value=0 @php if(Auth::user()->bday_visib==0||!Auth::user()->bday_visib){echo" selected";} @endphp>{{ __('messages.showbd1') }}</option>
                         <option value=1 @php if(Auth::user()->bday_visib==1){echo" selected";} @endphp>{{ __('messages.showbd2') }}</option>
                         <option value=2 @php if(Auth::user()->bday_visib==2){echo" selected";} @endphp>{{ __('messages.showbd3') }}</option>
                     </select>

                     <br /><table><tr><td align="right">{{ __('messages.polit') }}:@php if((Auth::user()->political==0) || (!Auth::user()->political) ){ echo"</td><td width=7><img src=\"/up.gif\"></td><td><div style=\"color: green\">+3</div></td><td>"; } @endphp
                      <select id="political">
                         @php for ($a=0; $a<10; $a++){ echo"<option value=$a";
                            if(Auth::user()->political==$a){echo" selected";}
                             echo">"; $pol_e = "messages.polit$a"; echo __($pol_e);
                            echo "</option>";} @endphp
                     </select></td></tr></table>

                     {{ __('messages.tab') }}:
                     <select id="tabak">
                         @php for ($a=0; $a<6; $a++){ echo"<option value=$a";
                            if(Auth::user()->tabak==$a){echo" selected";}
                             echo">"; $tab_e = "messages.tab_alk$a"; echo __($tab_e);
                            echo "</option>";} @endphp
                     </select>

                     <br />{{ __('messages.alk') }}:
                     <select id="alkoh">
                         @php for ($a=0; $a<6; $a++){ echo"<option value=$a";
                            if(Auth::user()->alkoh==$a){echo" selected";}
                             echo">"; $tab_e = "messages.tab_alk$a"; echo __($tab_e);
                            echo "</option>";} @endphp
                     </select>

                     <br /><table><tr><td>{{ __('messages.insign') }}:
                     <input type="text" id="insign" SIZE=15 maxlength = 70 value="{{ Auth::user()->insign }}"></td></tr></table>

                     <table><tr><td>{{ __('messages.religion') }}:
                     <input type="text" id="religion" SIZE=15 maxlength = 70 value="{{ Auth::user()->religion }}"></td></tr></table>

                     <table><tr><td>{{ __('messages.mtel') }}:
                     <input type="text" id="mtel" SIZE=15 maxlength = 50 value="{{ Auth::user()->mtel }}"></td></tr></table>


                     <table>
                         <tr><td class="fcomblue" width=180>
                                 <ul class="intop"><li><a id=chdata >{{ __('messages.save_data') }}</a></li></ul>
                             </td></tr>
                     </table>
                     <div id=ch_data></div>

                 </td></tr></table>

                 <br />
        </div>
        </td></tr></table><br /><br />
    </div>












    <div class="adm2">
        <table>
            <tr><td align=center valign=top width=470 class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'">

                    <table><tr><td width=455 align=center>
                                <h3>{{ __('messages.Reg_place') }}</h3>

              <div id=ch_adr style="text-align: left; padding-left: 10px; padding-right: 10px;">
              @php
              $hid_bl = "";
              if(Auth::user()->idc>0){

                $Alls = DB::table('Allcities')->select('obl', 'domen', 'rayc', 'City', 'City2', 'City3')->
                where('id', Auth::user()->idc)->
          	limit(1)->
                get();

                foreach ($Alls as $All) {
                    $obl=$All->obl; $idc=Auth::user()->idc; $domenc=$All->domen; $rayc=$All->rayc;
                    $City = $All->City; $City2 = $All->City2; $City3 = $All->City3;
                }

                 if(Auth::user()->Wherer == "проживання"){$wher_e=__('messages.Place1');}
                 if(Auth::user()->Wherer == "навчання"){$wher_e=__('messages.Place2');}
                 if(Auth::user()->Wherer == "роботи"){$wher_e=__('messages.Place3');}
                 if(Auth::user()->Wherer == "відпочинку"){$wher_e=__('messages.Place4');}
                 if(Auth::user()->Wherer == "народження"){$wher_e=__('messages.Place5');}
                $wher_e0=__('messages.Place');
                echo"<br /><h4>";
                echo" $wher_e0 $wher_e: "; $lan_pref = "messages.Region2";
                if (App::isLocale('ru')){$lsc="/ru"; $addl = "r"; $Ct=$City2;}
                else if (App::isLocale('en')){$lsc="/en"; $addl = "e"; $Ct=$City3;}
                else{$lsc=""; $addl = ""; $Ct=$City;}
                echo Auth::user()->Adr;
                echo " <a href=/$domenc$lsc>$Ct</a> ";
                $oi = "messages.o$obl"; echo "<a href=/$addl"; echo "se$obl>"; echo __($oi); echo " "; if($obl>1){$oi2 = "messages.Region2"; echo __($oi2); }
                echo"</a></h4>";
                $edie_e = __('messages.Edit');
                echo"<div id=red_enter0><a id=adr_edit>$edie_e</a></div>";
                $hid_bl = " style=\"display: none;\"";
                }

                else{$obl=0; $idc=0; $rayc=0;
                    $City = ""; $City2 = ""; $City3 = "";}
                @endphp
                </div>
                                <br /><div id=red_enter @php echo"$hid_bl"; @endphp ><table>
                                    <tr><td align="right"><label for="Wherer" >{{ __('messages.Place') }}: </label></td><td>
                                            <select id=Wherer >
                                                    <option value=проживання>{{ __('messages.Place1') }}</option>
                                                    <option value=навчання>{{ __('messages.Place2') }}</option>
                                                    <option value=роботи>{{ __('messages.Place3') }}</option>
                                                    <option value=відпочинку>{{ __('messages.Place4') }}</option>
                                                    <option value=народження>{{ __('messages.Place5') }}</option>
                                                </select>
                                        </td></tr>

                                    <tr><td align="right">{{ __('messages.Region') }}:</td><td>
                                            <select id="obl">
                                                   @php for ($i = 0; $i <= 25; $i++){
                                                     $ni = "messages.o$i"; $no = "messages.chopt";
                                                    echo"<option value=$i>";
                                                       if($i==0){echo __($no);}
                                                        else{echo __($ni);}
                                                    echo"</option>";
                                                    } @endphp

                                            </select>
                                       </td></tr>
                        <tr><td align="right"><div id=hrayc style="display: none;">
                                    <label for="rayc" >{{ __('messages.regionalcenter') }}: </label></div></td><td>
                                <div id=hrayc2 style="display: none;">
                                   <select id=rayc > </select>
                                </div>
                            </td></tr>
                                    <tr><td align="right"><div id=hidc style="display: none;">
                                               <label for="idc" >{{ __('messages.Cityvil') }}: </label></div></td><td>
                                            <div id=hidc2 style="display: none;">
                                                <select id=idc > </select>
                                            </div>
                                        </td></tr>
                                    <tr><td align="right"><label for="email" >{{ __('messages.Adr') }}:</label></td><td>
                                            <input id="Adr" type="text">
                                        </td></tr>
                                </table>
                                <table>
                                    <tr><td class="fcomblue" width=180>
                                            <ul class="intop"><li><a id=chadrr >{{ __('messages.save_adr') }}</a></li></ul>
                                        </td></tr>
                                </table>
                                <br />
                                </div>

                                </td></tr></table>
                            </td></tr></table>





                            <table>
                                    <tr><td align=center valign=top width=470 class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'">
                                    <table><tr><td width=455 align=center>

                                                @php
                                                      $Alls = DB::table('Private')->select('Page', 'Forum', 'do_mess', 'l_visit', 's_l_visit', 'ipban', 'ban', 'set_q')->
                                                      where('Num', Auth::user()->id)->
                                                    limit(1)->
                                                      get();
                                                        $npr=0;
                                                      foreach ($Alls as $All) {
                                                          $Page=$All->Page; $Forum=$All->Forum; $do_mess=$All->do_mess;
                                                          $l_visit=$All->l_visit; $s_l_visit=$All->s_l_visit;
                                                           $ipban = $All->ipban; $ban = $All->ban; $set_q = $All->set_q;
                                                          $npr++;
                                                      }
                                                      if($npr==0){$Page=1; $Forum=1; $do_mess=2; $l_visit=1; $s_l_visit=1;
                                                           $ipban=""; $ban=""; $set_q="a";}

                                                 @endphp

                         <h3>{{ __('messages.Private_Page') }}</h3>

                        <div style="padding-left: 7px; padding-right: 7px; text-align-all: right; ">
                            <table><tr><td align=right width=455>

                            <br />{{ __('messages.mypage_show') }}:
                            <select id="mypage_show">
                                @php for ($a=1; $a<6; $a++){ echo"<option value=$a";
                            if($Page==$a){echo" selected";}
                            echo">"; $tab_e = "messages.Pr_show$a"; echo __($tab_e);
                            echo "</option>";} @endphp
                            </select>
                            <br />{{ __('messages.mypage_do_forum') }}:
                            <select id="mypage_do_forum">
                                @php for ($a=1; $a<5; $a++){ echo"<option value=$a";
                            if($Forum==$a){echo" selected";}
                            echo">"; $tab_e = "messages.Pr_show$a"; echo __($tab_e);
                            echo "</option>";} @endphp
                            </select>
                            <br />{{ __('messages.lvisit_do') }}:
                            <select id="s_l_visit">
                                @php
                                    echo"<option value=1"; if($s_l_visit==1){echo" selected";} echo">";
                                   $tab_e = "messages.l_visit1"; echo __($tab_e); echo "</option>";
                                    echo"<option value=2"; if($s_l_visit==2){echo" selected";} echo">";
                                   $tab_e = "messages.l_visit2"; echo __($tab_e); echo "</option>";
                                @endphp
                            </select>
                            <br />{{ __('messages.lvisit_do') }}:
                            <select id="l_visit">
                                @php for ($a=1; $a<5; $a++){ echo"<option value=$a";
                            if($l_visit==$a){echo" selected";}
                            echo">"; $tab_e = "messages.Pr_show$a"; echo __($tab_e);
                            echo "</option>";} @endphp
                            </select>
                            <br />{{ __('messages.do_message') }}:
                            <select id="do_message">
                                @php for ($a=2; $a<5; $a++){ echo"<option value=$a";
                            if($do_mess==$a){echo" selected";}
                            echo">"; if($a==4){$tab_e = "messages.Pr_show44";} else {$tab_e = "messages.Pr_show$a";} echo __($tab_e);
                            echo "</option>";} @endphp
                            </select>
                            <br />{{ __('messages.set_q') }}:
                            <select id="set_q">
                                @php for ($a=1; $a<5; $a++){
                            if($a==1){$aa="a";} if($a==2){$aa="b";} if($a==3){$aa="c";} if($a==4){$aa="d";}
                            echo"<option value=$aa";
                            if($set_q==$aa){echo" selected";}
                            echo">"; if($a==4){$tab_e = "messages.Pr_show44";} else {$tab_e = "messages.Pr_show$a";} echo __($tab_e);
                            echo "</option>";} @endphp
                            </select>
                            <br />{{ __('messages.set_q_ip') }}: <input id="ipban" type="text" value="{{ $ipban }}">
                            <br />
                                        <div style="padding-right: 5px; padding-left: 5px;"><div id=set_private ></div></div>

                            <table><tr><td class="fcomblue" width=120>
                                        <ul class="intop"><li><a id=setprivate>{{ __('messages.save') }}</a></li></ul>
                                    </td></tr></table>



                                    @php
                                        $user_ban = __('messages.user_ban');
                                        $user_enter = __('messages.user_enter');
                                        $lock = __('messages.lock');
                                        echo"<br /><br /><h4>$user_ban</h4>
                                            <input type=\"text\" id=\"linku\" SIZE=35 maxlength = 70 placeholder=\"$user_enter\">
                                        <table><tr><td class=\"fcomblue\" width=120>
                                            <ul class=\"intop\"><li><a onclick=user_banp()>$lock</a></li></ul>
                                        </td></tr></table>
                                        <div id=user_ban2>";

                                        $user_ban = $ban;
                                        $ban_n = substr_count($user_ban,"#");
                                        if($ban_n>0){
                                            $ban_pages = explode("#", $user_ban);
                                            $b=1;
                                            for($a=$ban_n; $a>0; $a--){

                                            $pageb=$ban_pages[$a];

                                            $filename = "storage/last_visit/$pageb.txt";
                                            $whattoread = @fopen($filename, "r");
                                            $file_contents = fread($whattoread, filesize($filename)); 		 fclose($whattoread);
                                            $pageq = explode("#!:*&", $file_contents);

                                            $Imb=$pageq[1]; $Prizb=$pageq[2];
                                            $t1="qwertyuiopasdfg"; $t3=""; for($i=0;$i<4;$i++){$z=rand(0,strlen($t1)-1);$t3.="$t1[$z]";}

                                            if($b==3){echo"<div id=\"hid_ban\" style=\"display: none;\">";}
                                            $ppi = __('messages.pref_page'); $ppi.="i";
                                            $delete = __('messages.Delete');
                                            $show_all = __('messages.show_all');
                                            echo"<div id=\"$t3\" style=\"margin: 7px 0px 7px 0px;\"><a href=/$ppi$pageb>$Imb $Prizb</a> <a href=## onclick=user_ban_delp('$pageb','$t3')> <font size=0.5>$delete</font></a></div>";
                                            $b++;
                                            }
                                            if($b>3){
                                                echo"</div><div id=\"hid_ban2\"><a href=## onclick=ban_see()>$show_all ($ban_n)</a></div>";
                                            }
                                        }

                                        echo"</div>";

                                    @endphp


                         </td></tr></table><br />
                        </div>

                    </td></tr></table>

             </td></tr>
        </table>







        <table>
            <tr><td align=center valign=top width=470 class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'">
                    <table><tr><td width=455 align=center>

                                <h3>{{ __('messages.note_e') }}</h3>

                                <div style="padding-left: 7px; padding-right: 7px; text-align-all: right; ">
                                    <table><tr><td align=right width=455>

                                                <br />{{ __('messages.note_e1') }}:
                                                <select id="ntfriend">
                                                    @php for ($a=0; $a<4; $a++){ echo"<option value=$a";
                                                    if(Auth::user()->friend==$a){echo" selected";}
                                                    echo">"; $tab_e = "messages.note_es$a"; echo __($tab_e);
                                                    echo "</option>";} @endphp
                                                </select>
                                                <br />{{ __('messages.note_e2') }}:
                                                <select id="ntmail">
                                                    @php for ($a=0; $a<4; $a++){ echo"<option value=$a";
                                                    if(Auth::user()->mail==$a){echo" selected";}
                                                    echo">"; $tab_e = "messages.note_es$a"; echo __($tab_e);
                                                    echo "</option>";} @endphp
                                                </select>
                                                <br />{{ __('messages.note_e3') }}:
                                                <select id="ntforum">
                                                    @php for ($a=0; $a<4; $a++){ echo"<option value=$a";
                                                    if(Auth::user()->forum==$a){echo" selected";}
                                                    echo">"; $tab_e = "messages.note_es$a"; echo __($tab_e);
                                                    echo "</option>";} @endphp
                                                </select>
                                                <br />{{ __('messages.note_e4') }}:
                                                <select id="ntfrating">
                                                    @php for ($a=1; $a<4; $a++){ echo"<option value=$a";
                                                    if(Auth::user()->frating==$a){echo" selected";}
                                                    echo">"; $tab_e = "messages.note_es$a"; echo __($tab_e);
                                                    echo "</option>";} @endphp
                                                </select>
                                                <br />{{ __('messages.note_e5') }}:
                                                <select id="ntcomment">
                                                    @php for ($a=0; $a<4; $a++){ echo"<option value=$a";
                                                    if(Auth::user()->comment==$a){echo" selected";}
                                                    echo">"; $tab_e = "messages.note_es$a"; echo __($tab_e);
                                                    echo "</option>";} @endphp
                                                </select>
                                                <br />{{ __('messages.note_e6') }}: <input type=checkbox id=ntbd_send @php if(Auth::user()->bd_send!=1){echo"checked";}@endphp>
                                                <br />{{ __('messages.note_e7') }}: <input type=checkbox id=ntadm_send @php if(Auth::user()->adm_send!='1'){echo"checked";}@endphp>

                                                <table><tr><td class="fcomblue" width=320>
                                                            <ul class="intop"><li><a id=setnote>{{ __('messages.note_e8') }}</a></li></ul>
                                                        </td></tr></table>
                                                <div style="padding-right: 5px; padding-left: 5px;"><div id=set_note ></div></div>
                                            </td></tr></table>
                                </div>


                                <br /><br /><br />

                                <b><a target="_blank" href="/rules/{{ __('messages.lan') }}">{{ __('messages.rules2') }}</a> / <a target="_blank" href="/policy/{{ __('messages.lan') }}">{{__('messages.lic_cookie4')}}</a></b>
                                <br /><br />
                                <table border=0><tr valign=top height=14>
                                        <td width=30 align=center>
                                            @if (App::isLocale('en'))<img src="/images/flag-en.png" title = "english language" border=0>
                                            @else <a class=enover href="/settings/en" title = "english language"></a>
                                            @endif
                                        </td>
                                        <td width=30 align=center>
                                            @if (App::isLocale('ua'))<img src="/images/flag-uk.gif" title = "українська мова" border=0>
                                            @else <a class=uaover href="/settings/ua" title = "українська мова"></a>
                                            @endif
                                        </td>
                                        <td width=30 align=center>
                                            @if (App::isLocale('ru'))<img src="/images/flag-ru.gif" title = "русский язык" border=0>
                                            @else <a class=ruover href="/settings/ru" title = "русский язык"></a>
                                            @endif
                                        </td>
                                    </tr></table>

                            </td></tr></table>

                </td></tr>
        </table>



        <br /><br />
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7495053896041990"
                crossorigin="anonymous"></script>
        <!-- Адаптивный -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-7495053896041990"
             data-ad-slot="5938872690"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>



    </div>



    <div class="clear"></div>
</div>
</div>
        <br ><br ><br ><br >
    @endguest

@endsection


