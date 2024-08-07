@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
@endsection

@section('content')
<div class="content">
    <h2 class="content__ttl">Login</h2>
    <form action="/login" method="post">
        @csrf
        <div class="form__content">
            <div class="form__content--item">
                <i class="form__content--icon bi bi-envelope-fill"></i>
                <input class="form__content--input form__content--right" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
            </div>
            
            @if($errors->has('email'))
            <p class="error__txt">{{ $errors->first('email') }}</p>
            @endif
            
            <div class="form__content--item">
                <i class="form__content--icon bi bi-file-lock-fill"></i>
                <input class="form__content--input form__content--right" type="password" name="password" placeholder="Password">
            </div>
            
            @if($errors->has('password'))
            <p class="error__txt">{{ $errors->first('password') }}</p>
            @endif
            
            <button class="form__content--btn">ログイン</button>
        </div>
    </form>
</div>
@endsection