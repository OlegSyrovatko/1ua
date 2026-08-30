<html><body>
<P style="font-size:11pt;  color:#006699;">
Доброго часу доби, {{$Im}}!
    <br /><br />
    @php
        echo"$theme";
    @endphp

<br /><br />Переглянути інформацію Ви зможете на сторінці:
<br /><a href=https://1ua.com.ua/{{$domen}}>https://1ua.com.ua/{{$domen}}</a>

<br /><br /><br />З повагою,
<br />Адміністрація 1ua.com.ua
</p>
<P style="font-size:9pt; color:grey;">
<br />Для відписки від подібних листів потрібно зняти відмітку "Листи від адміністрації сайту"
<br />або перейти за адресою:
<br /><a href=https://1ua.com.ua/admin_unsubscribe/{{$email}}/{{$pas}}>https://1ua.com.ua/admin_unsubscribe/{{$email}}/{{$pas}}</a>
<br />Цей лист відісланий роботом. Відповідати на нього не потрібно.</p>
</P>
</body></html>
