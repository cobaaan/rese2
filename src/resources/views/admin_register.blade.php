@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_register.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
@endsection

@section('content')
<div class="content">
    <h2 class="content__ttl">Registration</h2>
    <form action="/admin/create" method="post">
        @csrf
        <div class="form__content">
            <div class="form__content--item">
                <i class="form__content--icon bi bi-person-fill"></i>
                <input class="form__content--input form__content--right" type="text" name="name" value="{{ old('name') }}" placeholder="Username">
            </div>
            
            @if($errors->has('name'))
            <p class="error__txt">{{ $errors->first('name') }}</p>
            @endif
            
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
            
            <div class="form__content--item">
                <i class="form__content--icon bi bi-exclude"></i>
                <select class="form__content--input form__content--right" name="role">
                    <option value="admin">Admin</option>
                    <option value="manager">ShopManager</option>
                    <option value="user">User</option>
                </select>
            </div>
            
            <button class="form__content--btn">登録</button>
        </div>
    </form>
</div>
@endsection