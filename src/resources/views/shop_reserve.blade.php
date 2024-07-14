@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_reserve.css') }}" />
@endsection

@section('content')
@if(isset($shop))
<div class="body">
    <h2 class="shop-name">{{ $shop->name }}</h2>
    <div class="today">
        <h2 class="ttl">本日のご予約</h2>
        <div class="content">
            <div class="content--head">
                <p class="name">お名前</p>
                <p class="date">日付</p>
                <p class="date__mobile">日付</p>
                <p class="time">時間</p>
                <p class="number">人数</p>
                <p class="email">メールアドレス</p>
            </div>
            @foreach($todayReserves as $today)
            <div class="content--item">
                <p class="name">{{ $today->user->name }}様</p>
                <p class="date">{{ $today->date }}</p>
                <p class="date__mobile">{{ substr($today->date, 5, 2) . "/" . substr($today->date, 8, 2)}}</p>
                <p class="time">{{ substr($today->time, 0, 5) }}</p>
                <p class="number">{{ $today->number }}</p>
                <p class="email">{{ $today->user->email }}</p>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="future">
        <h2 class="ttl">明日以降のご予約</h2>
        <div class="content">
            <div class="content--head">
                <p class="name">お名前</p>
                <p class="date">日付</p>
                <p class="date__mobile">日付</p>
                <p class="time">時間</p>
                <p class="number">人数</p>
                <p class="email">メールアドレス</p>
            </div>
            @foreach($futureReserves as $future)
            <div class="content--item">
                <p class="name">{{ $future->user->name }}様</p>
                <p class="date">{{ $future->date }}</p>
                <p class="date__mobile">{{ substr($future->date, 5, 2) . "/" . substr($future->date, 8, 2)}}</p>
                <p class="time">{{ substr($future->time, 0, 5) }}</p>
                <p class="number">{{ $future->number }}</p>
                <p class="email">{{ $future->user->email }}</p>
            </div>
            @endforeach
        </div>
    </div>
    
    
    <div class="past">
        <h2 class="ttl">過去のご予約</h2>
        <div class="content">
            <div class="content--head">
                <p class="name">お名前</p>
                <p class="date">日付</p>
                <p class="date__mobile">日付</p>
                <p class="time">時間</p>
                <p class="number">人数</p>
                <p class="email">メールアドレス</p>
            </div>
            @foreach($pastReserves as $past)
            <div class="content--item">
                <p class="name">{{ $past->user->name }}様</p>
                <p class="date">{{ $past->date }}</p>
                <p class="date__mobile">{{ substr($past->date, 5, 2) . "/" . substr($past->date, 8, 2)}}</p>
                <p class="time">{{ substr($past->time, 0, 5) }}</p>
                <p class="number">{{ $past->number }}</p>
                <p class="email">{{ $past->user->email }}</p>
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