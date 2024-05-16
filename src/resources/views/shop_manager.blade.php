@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_manage.css') }}" />
@endsection

@section('content')
<div class="content">
    <div class="left">
        <h2 class="left__ttl">登録済み店舗情報</h2>
        @if(isset($shop))
        <div class="left__shop">
            <h2 class="left__name">{{ $shop->name }}</h2>
            <p></p>
            <img class="left__img" src="{{ $shop->image_path }}">
            <div class="left__tag">
                <p class="left__area-genre">#{{ $shop->area }}</p>
                <p class="left__area-genre">#{{ $shop->genre }}</p>
            </div>
            <p class="left__description">{{ $shop->description }}</p>
        </div>
        @else
        <h2 class="comtent__ttl">店舗情報はありません</h2>
        @endif
    </div>
    
    
    
    <div class="right">
        @if(isset($shop))
        <div class="right__content">
            <h2 class="right__ttl">店舗情報の修正</h2>
            <form action="/shop_update" method="post" enctype='multipart/form-data'>
                @csrf
                <div>
                    <p class="right__name">name</p>
                    <input class="right__input" type="text" name="name" value = "{{ old('name') }}">
                    <div class="form__subject--error">
                        @error('name')
                        <p class="error__message">{{ $errors->first('name') }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <p class="right__name">area</p>
                    <input class="right__input" type="text" name="area" value = "{{ old('area') }}">
                    <div class="form__subject--error">
                        @error('area')
                        <p class="error__message">{{ $errors->first('area') }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <p class="right__name">genre</p>
                    <input class="right__input" type="text" name="genre" value = "{{ old('genre') }}">
                    <div class="form__subject--error">
                        @error('genre')
                        <p class="error__message">{{ $errors->first('genre') }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <p class="right__name">description</p>
                    <textarea class="right__textarea" name="description" cols="30" rows="10"></textarea>
                    <div class="form__subject--error">
                        @error('description')
                        <p class="error__message">{{ $errors->first('description') }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <p class="right__name">image</p>
                    <input class="right__file" type="file" name="image">
                    <div class="form__subject--error">
                        @error('image')
                        <p class="error__message">{{ $errors->first('image') }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <div>
                        <input class="right__input" type="hidden" name="shop_id" value = "{{ $shop->id }}">
                        <button class="right__btn">変更</button>
                    </div>
                </div>
            </form>
        </div>
        @else
        
        <div class="right__content">
            <h2 class="right__ttl">店舗の新規登録</h2>
            <form action="/shop_create" method="post" enctype='multipart/form-data'>
                @csrf
                <div>
                    <p class="right__name">name</p>
                    <input class="right__input" type="text" name="name" value = "{{ old('name') }}">
                </div>
                <div>
                    <p class="right__name">area</p>
                    <input class="right__input" type="text" name="area" value = "{{ old('area') }}">
                </div>
                <div>
                    <p class="right__name">genre</p>
                    <input class="right__input" type="text" name="genre" value = "{{ old('genre') }}">
                </div>
                <div>
                    <p class="right__name">description</p>
                    <textarea class="right__textarea" name="description" cols="30" rows="10"></textarea>
                </div>
                <div>
                    <p class="right__name">image</p>
                    <input class="right__file" type="file" name="image">
                </div>
                <div>
                    <input type="hidden" name="user_id" value="{{ $auth->id }}">
                    <div>
                        <button class="right__btn">登録</button>
                    </div>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection