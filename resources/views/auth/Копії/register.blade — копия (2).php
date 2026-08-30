@extends('layouts.app')
@section('title_block'){{ __('messages.reg') }}@endsection
@section('content')


    <script src="{{ asset('/js/allcities.js') }}" defer></script>
    <script type="text/javascript">


        function before_reg()
        {

            var r1=document.getElementById("example4").value;
            var r2=document.getElementById("example3").value;
            var r3=document.getElementById("example5").value;
            var r4=document.getElementById("who").value;
            var r5=document.getElementById("Adr").value;
            var r6=document.getElementById("mail").value;
            var r7 = " ";
            var rer = r1+r7+r2+r7+r3+r7+r4+r7+r5+r7+r6;
            var rerl = rer.length;


            rer = rer.toLowerCase();



            if(rerl<25){
                alert("Здається, Ви ввели не повну або не вірну інформацію, введіть правдиву інформацію. Пам'ятайте, що після завершення реєстрації Ви можете приховати Вашу сторінку");
                return false;
            }


            if(sValue2>0){document.getElementById("id").value=sValue2;}
            else{alert("Виберіть населений пункт із списку після введення декількох букв");  document.getElementById("example2").focus(); return false;}

            if(document.getElementById("readed").checked){} else {alert("Ознайомтесь, будь ласка, з правилами сайту і проставте відповідну відмітку"); return false;}



            var n1 = rer.search("хуй");
            var n2 = rer.search("пизд");
            var n3 = rer.search("конч");
            var n4 = rer.search("сперм");
            var n5 = rer.search("вафл");
            var n6 = rer.search("шлюх");
            var n7 = rer.search("fuck");
            var n8 = rer.search("гом");
            var n9 = rer.search("бля");
            var n10 = rer.search("манд");
            var n11 = rer.search("член");
            var n12 = rer.search("еба");
            var n13 = rer.search("єба");
            var n14 = rer.search("суч");
            var n15 = rer.search("сук");
            var n16 = rer.search("дроч");
            var n17 = rer.search("писк");
            var n18 = rer.search("піськ");
            var n19 = rer.search("урод");
            var n20 = rer.search("соса");
            var n21 = rer.search("ублюд");
            var n22 = rer.search("соси");
            var n23 = rer.search("сран");
            var n24 = rer.search("срак");
            var n25 = rer.search("срат");
            var n26 = rer.search("хуев");
            var n27 = rer.search("костр");
            var n28 = rer.search("блев");
            var n29 = rer.search("трах");
            var n30 = rer.search("влагал");
            var n31 = rer.search("онан");


            if(n1>0||n2>0||n3>0||n4>0||n5>0||n6>0||n7>0||n8>0||n9>0||n10>0||n11>0||n12>0||n13>0||n14>0||n15>0||n16>0||n17>0||n18>0||n19>0||n20>0||n21>0||n22>0||n23>0||n24>0||n25>0||n26>0||n27>0||n28>0||n29>0||n30>0||n31>0){
                alert("В записах присутні нецезурні словосполучення. Виправте їх, будь ласка ");  return false;
            }



        }


    </script>

    <div align = center>
    <table><tr><td width=620 align=center class=fcom onMouseOver="this.style.background='white'" onMouseOut="this.style='fcom'">
                <table><tr><td width=5></td><td valign=top><align = center width=600>

                    <form method="POST" name=register3 action="{{ route('register') }}">
                    <table>
                        @csrf
                    <tr><td width=250 align=right><h3><label for="Im" >{{ __('messages.Im') }}:</label></h3></td><td>
                                <input id="Im" type="text" class="form-control @error('Im') is-invalid @enderror" name="Im" value="{{ old('Im') }}" required autocomplete="Im" autofocus>
                     </td></tr>
                     <tr><td width=250 align=right><h3><label for="Priz" >{{ __('messages.Priz') }}: </label></h3></td><td>
                                <input id="Priz" type="text" class="form-control @error('Priz') is-invalid @enderror" name="Priz" value="{{ old('Priz') }}" required autocomplete="Priz">
                     </td></tr>
                     <tr><td width=250 align=right><h3><label for="sex" >{{ __('messages.sex') }}: </label></h3></td><td>
                             <div class="box"><select style="width: 185px;" name="sex" id=sex class="form-control @error('sex') is-invalid @enderror" value="{{ old('sex') }}">
                                 <option value=>{{ __('messages.sexn1') }}</option>
                                 <option value=1>{{ __('messages.sexn2') }}</option>
                                 <option value=2>{{ __('messages.sexn3') }}</option>
                                 </select></div>
                     </td></tr>
                     <tr><td width=250 align=right><h3><label for="Who" >{{ __('messages.Whon') }}: </label></h3></td><td>
                             <input id="Who" type="text" class="form-control @error('Who') is-invalid @enderror" name="Who" value="{{ old('Who') }}" required autocomplete="Who">
                     </td></tr>
                     <tr><td width=250 align=right><h3><label for="Wherer" >{{ __('messages.Place') }}: </label></h3></td><td>
                             <div class="box"><select style="width: 185px;" name="Wherer" id=Wherer class="form-control @error('Wherer') is-invalid @enderror" value="{{ old('Wherer') }}">
                                 <option value=проживання>{{ __('messages.Place1') }}</option>
                                 <option value=навчання>{{ __('messages.Place2') }}</option>
                                 <option value=роботи>{{ __('messages.Place3') }}</option>
                                 <option value=відпочинку>{{ __('messages.Place4') }}</option>
                                 <option value=народження>{{ __('messages.Place5') }}</option>
                                 </select></div>
                      </td></tr>
                      <tr><td width=250 align=right><h3><label for="obl" >{{ __('messages.Region') }}: </label></h3></td><td>
                              <div class="box"><select style="width: 185px;" name="obl" id=obl class="form-control @error('obl') is-invalid @enderror" value="{{ old('obl') }}">
                                      @for ($i = 1; $i <= 25; $i++)
                                          {{ $ni = "messages.o$i" }}
                                          <option value={{ $i }}>{{ __($ni) }}</option>
                                      @endfor
                                  </select></div>
                      </td></tr>
                      <tr><td width=250 align=right><div id=hrayc style="display: none;">
                                  <h3><label for="rayc" >{{ __('messages.regionalcenter') }}: </label></h3></div></td><td>
                              <div id=hrayc2 style="display: none;">
                                <div class="box"><select style="width: 185px;" name="rayc" id=rayc class="form-control @error('rayc') is-invalid @enderror" value="{{ old('rayc') }}">
                                    </select></div>
                              </div>
                         </td></tr>
                      <tr><td width=250 align=right><div id=hidc style="display: none;">
                                  <h3><label for="idc" >{{ __('messages.Cityvil') }}: </label></h3></div></td><td>
                              <div id=hidc2 style="display: none;">
                              <div class="box"><select style="width: 185px;" name="idc" id=idc class="form-control @error('idc') is-invalid @enderror" value="{{ old('idc') }}">
                                    </select></div>
                              </div>
                      </td></tr>
                        <tr><td width=250 align=right><h3><label for="email" >{{ __('E-mail') }}:</label></h3></td><td>
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                     </td></tr>

                      <tr><td width=250 align=right><h3><label for="password" >{{ __('messages.passw') }}:</label></h3></td><td>
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                          </td></tr>
                        <tr><td width=250 align=right><h3><label for="password-confirm" >{{ __('messages.ppassw') }}:</label></h3></td><td>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </td></tr>
                        <tr><td width=250 align=right>
                            </td><td class=fcomblue><ul class=intopbig><li><a href="javascript:document.forms.register3.submit();">{{ __('messages.reg') }}</a></li></ul>
                            </td></tr>
                     </table>

                    </form>

                            <div id=passw2 ></div><a id=passw><font color = red> passw</font></a>

            </td><td width=5></td></tr></table><br>
            </td></tr></table>
</div>

@endsection
