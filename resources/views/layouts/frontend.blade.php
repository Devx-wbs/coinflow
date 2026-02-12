<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

@include('home-fronted.include.header')

@yield('content')

@include('home-fronted.include.footer')

</body>
</html>
