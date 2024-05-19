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
        <div class="ham" id="ham">
            <div class="ham__line">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <h2 class="ham__ttl">Rese</h2>
        </div>
        <div class="cross" id="cross">
            <a href="/" class="cross__txt">×</a>
        </div>
        @auth
        <nav class="ham__nav" id="nav">
            <ul class="ham__nav--menu">
                <li class="ham__nav--link">
                    <form action="/" method="get">
                        @csrf
                        <button class="ham__nav--link-txt">Home</button>
                    </form>
                </li>
                <li class="ham__nav--link">
                    <form action="/logout" method="post">
                        @csrf
                        <button class="ham__nav--link-txt">Logout</button>
                    </form>
                </li>
                <li class="ham__nav--link">
                    <form action="/my_page" method="get">
                        @csrf
                        <button class="ham__nav--link-txt">Mypage</button>
                    </form>
                </li>
                @if ($auth->role === 'admin')
                <li class="ham__nav--link">
                    <form action="/admin_register" method="get">
                        @csrf
                        <button class="ham__nav--link-txt">AdminRegister</button>
                    </form>
                </li>
                <li class="ham__nav--link">
                    <form action="/user_all" method="get">
                        @csrf
                        <button class="ham__nav--link-txt">UserAll</button>
                    </form>
                </li>
                @endif
                @if ($auth->role === 'shopManager')
                <li class="ham__nav--link">
                    <form action="/shop_manager" method="get">
                        @csrf
                        <button class="ham__nav--link-txt">ShopManager</button>
                    </form>
                </li>
                <li class="ham__nav--link">
                    <form action="/shop_reserve" method="get">
                        @csrf
                        <button class="ham__nav--link-txt">ShopReserve</button>
                    </form>
                </li>
                @endif
            </ul>
        </nav>
        @else
        <nav class="ham__nav" id="nav">
            <ul class="ham__nav--menu">
                <li class="ham__nav--link">
                    <form action="/" method="get">
                        @csrf
                        <button class="ham__nav--link-txt">Home</button>
                    </form>
                </li>
                <li class="ham__nav--link">
                    <form action="/register" method="get">
                        @csrf
                        <button class="ham__nav--link-txt">Registration</button>
                    </form>
                </li>
                <li class="ham__nav--link">
                    <form action="/login" method="get">
                        @csrf
                        <button class="ham__nav--link-txt">Login</button>
                    </form>
                </li>
            </ul>
        </nav>
        @endauth
        @yield('header')
    </header>
    @yield('content')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ham = document.getElementById('ham');
            const nav = document.getElementById('nav');
            const cross = document.getElementById('cross');
            
            ham.addEventListener('click', () => {
                if (ham.classList.contains("is-active")) {
                    ham.classList.remove('is-active');
                    nav.classList.remove('is-active')
                    cross.classList.remove('is-active');
                } else {
                    ham.classList.add('is-active');
                    nav.classList.add('is-active')
                    cross.classList.add('is-active');
                }
            })
        });
        
        nav.addEventListener('click', () => {
            ham.classList.remove('is-active');
            nav.classList.remove('is-active')
            cross.classList.remove('is-active');
        });
    </script>
</body>
</html>