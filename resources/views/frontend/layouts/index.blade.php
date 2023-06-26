<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CM-Sniffer</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <style>
    </style>
    @yield('css')
</head>

<body>
    @yield('content')
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @yield('js')
</body>

</html>
