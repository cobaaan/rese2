@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}" />
<link rel="stylesheet" href="{{ asset('css/review.css') }}" />
@endsection

@section('content')
@if(isset($shopModal))
<div class="modal">
    <div class="modal__back">
        <div class="modal__header">
            <h2 class="modal__header--ttl">レビュー 一覧</h2>
            <form action="/shop_detail" method="get">
                @csrf
                <input type="hidden" name="id" value="{{ $requests['id'] }}">
                <input type="hidden" name="name" value="{{ $requests['name'] }}">
                <input type="hidden" name="area" value="{{ $requests['area'] }}">
                <input type="hidden" name="genre" value="{{ $requests['genre'] }}">
                <input type="hidden" name="description" value="{{ $requests['description'] }}">
                <input type="hidden" name="image_path" value="{{ $requests['image_path'] }}">
                <button class="modal__header--btn">×</button>
            </form>
        </div>
        @foreach ($reviews as $review)
        <div class="modal__content">
            <div class="modal__content--header">
                <h2 class="modal__content--name">{{ $user[$review['user_id'] - 1]->name }} 様</h2>
                <div class="review__area modal__content--star">
                    <p class="star{{ $review['rate'] }}"></p>
                </div>
            </div>
            <p class="modal__content--comment-ttl">コメント</p>
            <p class="modal__content--comment">{{ $review['comment'] }}</p>
        </div>
        @endforeach
    </div>
</div>
@endif
<div class="content">
    <div class="shop">
        <div class="shop__header">
            <h2 class="shop__name">{{ $requests['name'] }}</h2>
            <div class="review__area shop__header--rate">
                <form action="/modal" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $requests['id'] }}">
                    <input type="hidden" name="name" value="{{ $requests['name'] }}">
                    <input type="hidden" name="area" value="{{ $requests['area'] }}">
                    <input type="hidden" name="genre" value="{{ $requests['genre'] }}">
                    <input type="hidden" name="description" value="{{ $requests['description'] }}">
                    <input type="hidden" name="image_path" value="{{ $requests['image_path'] }}">
                    <button class="review__area--btn">レビューを見る</button>
                    <p class="{{ $averageRatings[$requests['id']] }}"></p>
                </form>
            </div>
        </div>
        <img class="shop__img" src="{{ $requests['image_path'] }}">
        <div class="shop__tag">
            <p class="shop__area-genre">#{{ $requests['area'] }}</p>
            <p class="shop__area-genre">#{{ $requests['genre'] }}</p>
        </div>
        <p class="shop__description">{{ $requests['description'] }}</p>
    </div>
    
    <div class="reserve">
        <h2 class="reserve__ttl">予約</h2>
        <form action="/reserve" method="post">
            @csrf
            <input type="hidden" name="page" value="shop_detail">
            <input type="hidden" name="user_id" value="{{ $auth }}">
            <input type="hidden" name="name" value="{{ $requests['name'] }}">
            <input type="hidden" name="image_path" value="{{ $requests['image_path'] }}">
            <input type="hidden" name="area" value="{{ $requests['area'] }}">
            <input type="hidden" name="genre" value="{{ $requests['genre'] }}">
            <input type="hidden" name="description" value="{{ $requests['description'] }}">
            <input type="hidden" name="shop_id" value="{{ $requests['id'] }}">
            <input type="hidden" name="id" value="{{ $requests['id'] }}">
            <input class="reserve__date" type="date" name="date" value="{{ old('date') }}" min="{{ $dt->format('Y-m-d') }}">
            <div class="form__subject--error reserve__date--error">
                @error('date')
                <p class="error__message">{{ $errors->first('date') }}</p>
                @enderror
            </div>
            
            <select name="time">
                @for($i = 00; $i < 24; $i++)
                <option value={{ $i }}>{{ $i }}</option>
                @endfor
            </select>
            <select name="minute">
                <option value="00">00</option>
                <option value="30">30</option>
            </select>
            <div class="form__subject--error reserve__date--error">
                @error('time')
                <p class="error__message">{{ $errors->first('time') }}</p>
                @enderror
            </div>
            <select class="reserve__number" name="number" value="{{ old('number') }}">
                <div class="form__subject--error reserve__date--error">
                    @error('number')
                    <p class="error__message">{{ $errors->first('number') }}</p>
                    @enderror
                </div>
                @for($i = 1; $i < 10; $i++)
                <option value="{{ $i }}">{{ $i }}人</option>
                @endfor
                <option value="10">10人以上</option>
            </select>
            <div class="reserve__confirm">
                <table>
                    <tr>
                        <td>Shop</td>
                        <td>{{ $requests['name'] }}</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>あとで設定</td>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <td>あとで設定</td>
                    </tr>
                    <tr>
                        <td>Number</td>
                        <td>あとで設定</td>
                    </tr>
                </table>
            </div>
            <button class="reserve__btn">予約する</button>
        </form>
    </div>
</div>

<!--
    <div>
        @foreach ($reviews as $review)
        <div class="review">
            <h2 class="review__name">{{ $user[$review['user_id'] - 1]->name }}</h2>
            <div class="review__area">
                <p class="star{{ $review['rate'] }}"></p>
            </div>
            <p class="review__comment">{{ $review['comment'] }}</p>
        </div>
        @endforeach
    </div>
    
-->
@endsection