<html><body>
<P style="font-size:11pt;  color:#006699;">
    Доброго времени суток, {{$Im}}!
    <br /><br />
    @php
        echo"$theme";
    @endphp
    <br /><br />Просмотреть информацию Вы сможете на странице:
    <br /><a href=https://1ua.com.ua/{{$domen}}/ru>https://1ua.com.ua/{{$domen}}/ru</a>

    <br /><br /><br />С уважением,
    <br />Администрация 1ua.com.ua
</p>
<P style="font-size:9pt; color:grey;">
    <br />Для отписки от подобных писем нужно снять отметку "Письма от администрации сайта"
	<br />или перейти по адресу:
<br /><a href=https://1ua.com.ua/admin_unsubscribe/{{$email}}/{{$pas}}>https://1ua.com.ua/admin_unsubscribe/{{$email}}/{{$pas}}</a>
    <br />Это письмо отправлено роботом. Отвечать на него не нужно.</p>
</P>
</body></html>
