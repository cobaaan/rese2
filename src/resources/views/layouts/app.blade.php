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
        <div class="header-area">
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <a href="/" class="header-area-ttl">Rese</a>
        </div>
        @auth
        @if($auth->role === 'user')
        <ul class="slide-menu" id="slide-menu">
            <li>
                <form action="/" method="get">
                    @csrf
                    <button class="ham__nav--link-txt">Home</button>
                </form>
            </li>
            <li>
                <form action="/my_page" method="get">
                    @csrf
                    <button class="ham__nav--link-txt">Mypage</button>
                </form>
            </li>
            <li>
                <form action="/logout" method="post">
                    @csrf
                    <button class="ham__nav--link-txt">Logout</button>
                </form>
            </li>
        </ul>
        @elseif($auth->role === 'shopManager')
        <ul class="slide-menu" id="slide-menu">
            <li>
                <form action="/shop/manager" method="get">
                    @csrf
                    <button class="ham__nav--link-txt">ShopManager</button>
                </form>
            </li>
            <li>
                <form action="/shop/reserve" method="get">
                    @csrf
                    <button class="ham__nav--link-txt">ShopReserve</button>
                </form>
            </li>
            <li>
                <form action="/logout" method="post">
                    @csrf
                    <button class="ham__nav--link-txt">Logout</button>
                </form>
            </li>
        </ul>
        @elseif($auth->role === 'admin')
        <ul class="slide-menu" id="slide-menu">
            <li>
                <form action="/admin/register" method="get">
                    @csrf
                    <button class="ham__nav--link-txt">AdminRegister</button>
                </form>
            </li>
            <li>
                <form action="/mail/form" method="get">
                    @csrf
                    <button class="ham__nav--link-txt">SendMail</button>
                </form>
            </li>
            <li>
                <form action="/logout" method="post">
                    @csrf
                    <button class="ham__nav--link-txt">Logout</button>
                </form>
            </li>
        </ul>
        @endif
        @else
        <ul class="slide-menu" id="slide-menu">
            <li>
                <form action="/" method="get">
                    @csrf
                    <button class="ham__nav--link-txt">Home</button>
                </form>
            </li>
            <li>
                <form action="/register" method="get">
                    @csrf
                    <button class="ham__nav--link-txt">Registration</button>
                </form>
            </li>
            <li>
                <form action="/login" method="get">
                    @csrf
                    <button class="ham__nav--link-txt">Login</button>
                </form>
            </li>
        </ul>
        @endauth
        
        @yield('header')
    </header>
    @yield('content')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hamburger = document.getElementById('hamburger');
            const slideMenu = document.getElementById('slide-menu');
            
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                slideMenu.classList.toggle('active');
            });
        });
    </script>
</body>
</html>