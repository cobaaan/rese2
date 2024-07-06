@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}" />
@endsection

@section('content')
<div class="content">
    <div class="shop">
        @foreach($reserves as $reserve)
        <h2 class="shop__name">{{ $reserve->shop->name }}</h2>
        <h2 class="shop__date-time">{{ $reserve['date'] . " " . substr($reserve['time'], 0, 5) . " 来店" }}</h2>
        <img class="shop__img" src="{{ $reserve->shop->image_path }}">
        <div class="shop__tag">
            <p class="shop__area-genre">#{{ $reserve->shop->area->area }}</p>
            <p class="shop__area-genre">#{{ $reserve->shop->genre->genre }}</p>
        </div>
        <p class="shop__description">{{ $reserve->shop->description }}</p>
        @endforeach
    </div>
    <div class="review">
        <h2 class="review__ttl">レビュー</h2>
        <form class="review__form" action="/review/post" method="post">
            @csrf
            <p class="review__txt">5段階評価</p>
            <select class="review__select" name="rate">
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
            <p class="review__txt">レビュー</p>
            <div class="review__textarea">
                <textarea class="review__textarea--input" name="comment" rows="5" cols="60" maxlength="1000" placeholder="レビューを書いてください"></textarea>
                
                @error('comment')
                <p class="error__message">{{ $errors->first('comment') }}</p>
                @enderror
                
            </div>
            <input type="hidden" name="user_id" value="{{ $auth->id }}">
            <input type="hidden" name="shop_id" value="{{ $requests['shop_id'] }}">
            <input type="hidden" name="reserve_id" value="{{ $requests['reserve_id'] }}">
            <button class="review__btn">レビューする</button>
        </form>
    </div>
</div>
@endsection