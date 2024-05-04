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
@endsection