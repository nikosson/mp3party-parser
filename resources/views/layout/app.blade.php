<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="css/app.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        @yield('content')

    </div>
</div>

<script src="js/app.js"></script>
</body>
</html>
