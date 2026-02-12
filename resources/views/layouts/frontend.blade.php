<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

@include('home-fronted.include.header')

@yield('content')

@include('home-fronted.include.footer')

</body>
</html>
