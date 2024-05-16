@extends('layouts/menu')

@section('css')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}" />
@endsection

@section('content')
<div class="menu">
    <form action="?" method="post">
        @csrf
        <div>
            <button class="menu__btn" formaction="/">Home</button>
        </div>
        <div>
            <button class="menu__btn" formaction="/logout">Logout</button>
        </div>
        <div>
            <button class="menu__btn" formaction="/my_page">Mypage</button>
        </div>
    </form>
</div>
<div class="menu">
    <form action="?" method="get">
        @csrf
        @if ($auth->role === 'admin')
        <div>
            <button class="menu__btn" formaction="/admin_register">AdminPage</button><br>
            <button class="menu__btn" formaction="/user_all">AllUsersPage</button>
        </div>
        @elseif($auth->role === 'shopManager')
        <div>
            <button class="menu__btn" formaction="/shop_manager">ShopManagePage</button>
        </div>
        <div>
            <button class="menu__btn" formaction="/shop_reserve">ReservePage</button>
        </div>
        @endif
    </form>
</div>
@endsection