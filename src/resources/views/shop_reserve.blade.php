@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_reserve.css') }}" />
@endsection

@section('content')
@if(isset($shop))
<div>
    <h2 class="shop-name">{{ $shop->name }}</h2>
    <div class="today">
        <h2 class="ttl">本日のご予約</h2>
        <div class="content">
            <div class="content--head">
                <div class="name">お名前</div>
                <div class="date">日付</div>
                <div class="time">時間</div>
                <div class="number">人数</div>
                <div class="email">メールアドレス</div>
            </div>
            @foreach($todayReserves as $today)
            <div class="content--item">
                <div class="name">{{ $users[$today->user_id - 1]->name }}　　様</div>
                <div class="date">{{ $today->date }}</div>
                <div class="time">{{ $today->time }}</div>
                <div class="number">{{ $today->number }}</div>
                <div class="email">{{ $users[$today->user_id - 1]->email }}</div>
                <form action="/mail_form" method="post">
                    @csrf
                    <input type="hidden" name="shop_name" value="{{ $shop->name }}">
                    <input type="hidden" name="name" value="{{ $users[$today->user_id - 1]->name }}">
                    <input type="hidden" name="date" value="{{ $today->date }}">
                    <input type="hidden" name="time" value="{{ $today->time }}">
                    <input type="hidden" name="number" value="{{ $today->number }}">
                    <input type="hidden" name="email" value="{{ $users[$today->user_id - 1]->email }}">
                    <button class="btn">メール送信</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="future">
        <h2 class="ttl">明日以降のご予約</h2>
        <div class="content">
            <div class="content--head">
                <div class="name">お名前</div>
                <div class="date">日付</div>
                <div class="time">時間</div>
                <div class="number">人数</div>
                <div class="email">メールアドレス</div>
            </div>
            @foreach($futureReserves as $future)
            <div class="content--item">
                <div class="name">{{ $users[$future->user_id - 1]->name }}　　様</div>
                <div class="date">{{ $future->date }}</div>
                <div class="time">{{ $future->time }}</div>
                <div class="number">{{ $future->number }}</div>
                <div class="email">{{ $users[$future->user_id - 1]->email }}</div>
                <form action="/mail_form" method="post">
                    @csrf
                    <input type="hidden" name="shop_name" value="{{ $shop->name }}">
                    <input type="hidden" name="name" value="{{ $users[$future->user_id - 1]->name }}">
                    <input type="hidden" name="date" value="{{ $future->date }}">
                    <input type="hidden" name="time" value="{{ $future->time }}">
                    <input type="hidden" name="number" value="{{ $future->number }}">
                    <input type="hidden" name="email" value="{{ $users[$future->user_id - 1]->email }}">
                    <button class="btn">メール送信</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    
    
    <div class="past">
        <h2 class="ttl">過去のご予約</h2>
        <div class="content">
            <div class="content--head">
                <div class="name">お名前</div>
                <div class="date">日付</div>
                <div class="time">時間</div>
                <div class="number">人数</div>
                <div class="email">メールアドレス</div>
            </div>
            @foreach($pastReserves as $past)
            <div class="content--item">
                <div class="name">{{ $users[$past->user_id - 1]->name }}　　様</div>
                <div class="date">{{ $past->date }}</div>
                <div class="time">{{ $past->time }}</div>
                <div class="number">{{ $past->number }}</div>
                <div class="email">{{ $users[$past->user_id - 1]->email }}</div>
                <form action="/mail_form" method="post">
                    @csrf
                    <input type="hidden" name="shop_name" value="{{ $shop->name }}">
                    <input type="hidden" name="name" value="{{ $users[$past->user_id - 1]->name }}">
                    <input type="hidden" name="date" value="{{ $past->date }}">
                    <input type="hidden" name="time" value="{{ $past->time }}">
                    <input type="hidden" name="number" value="{{ $past->number }}">
                    <input type="hidden" name="email" value="{{ $users[$past->user_id - 1]->email }}">
                    <button class="btn">メール送信</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</div>
@else
<h2 class="ttl">店舗情報が登録されていません。</h2>
<h2 class="ttl">ShopManagerにて店舗情報を登録してください。</h2>
@endif
@endsection