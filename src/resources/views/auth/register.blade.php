@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/fortify.css') }}" />
@endsection

@section('content')
<div class="content">
    <h2 class="content__ttl">Registration</h2>
    <div>
        <form action="/register" method="post">
            @csrf
            <div class="form__content">
                <div class="form__content--item">
                    <div class="form__user form__content--left"></div>
                    <input class="form__input form__content--right" type="text" name="name" value="{{ old('name') }}" placeholder="Username">
                </div>
                <div class="error">
                    @if($errors->has('name'))
                    <div class="error__txt">{{ $errors->first('name') }}</div>
                    @endif
                </div>
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
                    <div><input type="hidden" name="role" value="admin"></div>
                    <button class="form__btn">登録</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection