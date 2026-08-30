<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>@yield('title_block')</title>
    <link rel="stylesheet" href=/css/app.css>
</head>
<body>
@include('inc.top_unreg')

<div>
@include('inc.messages')
</div>

@yield('content')

@include('inc.down')

</body>
</html>
