@extends('layouts/menu')

@section('css')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}" />
@endsection

@section('content')
<div class="menu">
    <form action="?" method="get">
        @csrf
        <div>
            <button class="menu__btn" formaction="/">Home</button>
        </div>
        <div>
            <button class="menu__btn" formaction="/register">Registration</button>
        </div>
        <div>
            <button class="menu__btn" formaction="/login">Login</button>
        </div>
    </form>
</div>
@endsection