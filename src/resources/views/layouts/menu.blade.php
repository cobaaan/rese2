<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    @yield('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <title>Rese</title>
</head>
<body>
    <header>
        <form action="/" method="get">
            @csrf
            <button class="menu__btn">
                <span class="square_btn"></span>
            </button>
        </form>
        @yield('header')
    </header>
    @yield('content')
</body>
</html>