@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}" />
@endsection

@section('content')
<div class="content">
    <div class="shop">
        <div class="shop__header">
            <h2 class="shop__name">{{ $shops[$requests['shop_id'] - 1]->name }}</h2>
            <h2 class="shop__date-time">{{ $reserves[0]['date'] . " " . $reserves[0]['time'] . " 来店" }}</h2>
        </div>
        <img class="shop__img" src="{{ $shops[$requests['shop_id'] - 1]->image_path }}">
        <div class="shop__tag">
            <p class="shop__area-genre">#{{ $shops[$requests['shop_id'] - 1]->area }}</p>
            <p class="shop__area-genre">#{{ $shops[$requests['shop_id'] - 1]->genre }}</p>
        </div>
        <p class="shop__description">{{ $shops[$requests['shop_id'] - 1]->description }}</p>
    </div>
    <div class="reserve">
        <h2 class="reserve__ttl">レビュー</h2>
        <form class="reserve__form" action="/review_post" method="post">
            @csrf
            <p class="reserve__txt">5段階評価</p>
            <select class="reserve__select" name="rate">
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
            <p class="reserve__txt">レビュー</p>
            <div class="reserve__textarea">
                <textarea class="reserve__textarea--input" name="comment" rows="5" cols="60" placeholder="レビューを書いてください"></textarea>
                <div class="form__subject--error">
                    @error('comment')
                    <p class="error__message">{{ $errors->first('comment') }}</p>
                    @enderror
                </div>
            </div>
            <input type="hidden" name="user_id" value="{{ $auth->id }}">
            <input type="hidden" name="shop_id" value="{{ $requests['shop_id'] }}">
            <input type="hidden" name="reserve_id" value="{{ $reserves[0]->id }}">
            <button class="reserve__btn">レビューする</button>
        </form>
    </div>
</div>
@endsection