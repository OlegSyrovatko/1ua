<html><body>
<P style="font-size:11pt;  color:#006699;">
    Доброго часу доби!
	<br /><br />
	@php
	echo"$theme";
	@endphp

	<br /><br />Переглянути інформацію Ви зможете на сторінці:
<br /><a href=https://1ua.com.ua/{{$domen}}>https://1ua.com.ua/{{$domen}}</a>
<br />(знизу сторінки можна налаштувати параметри сповіщень)
<br /><br /><br />З повагою,
<br />Адміністрація 1ua.com.ua
</p>
<P style="font-size:9pt; color:grey;">
Для видалення всіх сповіщень населеного пункту {{$City}} перейдіть по посиланню:
<br /><a href=https://1ua.com.ua/unsubscribe/{{$email}}/{{$id}}>https://1ua.com.ua/unsubscribe/{{$email}}/{{$id}}</a>
<br />Цей лист відісланий роботом. Відповідати на нього не потрібно.
</P>
</body></html>
