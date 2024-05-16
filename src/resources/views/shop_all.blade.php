@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop.css') }}" />
<link rel="stylesheet" href="{{ asset('css/review.css') }}" />
@endsection

@section('header')
<div class="search">
    <form class="search__form" action="/search" method="post">
        @csrf
        <select class="search__area" name="area" id="">
            <option value="" selected>All area</option>
            @foreach ($shopAreas as $shopArea)
            <option value="{{ $shopArea->area }}">{{ $shopArea->area }}</option>
            @endforeach
        </select>
        <select class="search__genre" name="genre" id="">
            <option value="" selected>All genre</option>
            @foreach ($shopGenres as $shopGenre)
            <option value="{{ $shopGenre->genre }}">{{ $shopGenre->genre }}</option>
            @endforeach
        </select>
        <input class="search__text" type="text" name="text" value="" placeholder="Search...">
        <button class="search__btn">Search</button>
    </form>
</div>
@endsection

@section('content')
<div class="shop">
    @foreach ($shops as $shop)
    <div class="card">
        <img class="card__img" src="{{ $shop->image_path }}">
        <div>
            <div class="card__ttl">{{ $shop->name }}</div>
            <div class="card__tag">
                <div>#{{ $shop->area }}</div>
                <div>#{{ $shop->genre }}</div>
            </div>
            <div>
                <form class="card__form" method="post" action="?">
                    @csrf
                    <input type="hidden" name="id" value="{{ $shop->id }}">
                    <input type="hidden" name="name" value="{{ $shop->name }}">
                    <input type="hidden" name="area" value="{{ $shop->area }}">
                    <input type="hidden" name="genre" value="{{ $shop->genre }}">
                    <input type="hidden" name="description" value="{{ $shop->description }}">
                    <input type="hidden" name="image_path" value="{{ $shop->image_path }}">
                    
                    <button class="card__form--btn" formaction="/shop_detail">詳しく見る</button>
                    
                    <button class="review__btn" formaction="/shop_detail">
                        <div class="review__area">
                            <p class="{{ $averageRatings[$shop->id] }}"></p>
                        </div>
                    </button>
                    @php
                    $color = 'card__form--heart-img';
                    @endphp
                    
                    @if(isset($auths))
                    @foreach($favorites as $favorite)
                    @if($favorite['user_id'] === $auths->id && $favorite['shop_id'] === $shop->id)
                    @php
                    $color = 'card__form--heart-red';
                    @endphp
                    @endif
                    @endforeach
                    
                    <button class="card__form--heart"  method="POST" formaction="{{ route('favorite.toggle', $shop->id) }}"><img  class="{{ $color }}" src="image/life.png"></button>
                    
                    @endif
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection