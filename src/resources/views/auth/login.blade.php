@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/fortify.css') }}" />
@endsection

@section('content')
<div class="content">
    <h2 class="content__ttl">Login</h2>
    <div>
        <form action="/login" method="post">
            @csrf
            <div class="form__content">
                <div class="form__content--item">
                    <div class="form__email form__content--left"></div>
                    <input class="form__input form__content--right" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                </div>
                <div class="error">
                    @if($errors->has('email'))
                    <div class="error__txt">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="form__content--item">
                    <div class="form__pass form__content--left"></div>
                    <input class="form__input form__content--right" type="password" name="password" placeholder="Password">
                </div>
                <div class="error">
                    @if($errors->has('password'))
                    <div class="error__txt">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="form__content--item">
                    <div></div>
                    <button class="form__btn">ログイン</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection