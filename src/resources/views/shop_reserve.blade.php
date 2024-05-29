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
                <div class="date__mobile">日付</div>
                <div class="time">時間</div>
                <div class="number">人数</div>
                <div class="email">メールアドレス</div>
            </div>
            @foreach($todayReserves as $today)
            <div class="content--item">
                <div class="name">{{ $today->user->name }}様</div>
                <div class="date">{{ $today->date }}</div>
                <div class="date__mobile">{{ substr($today->date, 5, 2) . "/" . substr($today->date, 8, 2)}}</div>
                <div class="time">{{ substr($today->time, 0, 5) }}</div>
                <div class="number">{{ $today->number }}</div>
                <div class="email">{{ $today->user->email }}</div>
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
                <div class="date__mobile">日付</div>
                <div class="time">時間</div>
                <div class="number">人数</div>
                <div class="email">メールアドレス</div>
            </div>
            @foreach($futureReserves as $future)
            <div class="content--item">
                <div class="name">{{ $future->user->name }}様</div>
                <div class="date">{{ $future->date }}</div>
                <div class="date__mobile">{{ substr($future->date, 5, 2) . "/" . substr($future->date, 8, 2)}}</div>
                <div class="time">{{ substr($future->time, 0, 5) }}</div>
                <div class="number">{{ $future->number }}</div>
                <div class="email">{{ $future->user->email }}</div>
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
                <div class="date__mobile">日付</div>
                <div class="time">時間</div>
                <div class="number">人数</div>
                <div class="email">メールアドレス</div>
            </div>
            @foreach($pastReserves as $past)
            <div class="content--item">
                <div class="name">{{ $past->user->name }}様</div>
                <div class="date">{{ $past->date }}</div>
                <div class="date__mobile">{{ substr($past->date, 5, 2) . "/" . substr($past->date, 8, 2)}}</div>
                <div class="time">{{ substr($past->time, 0, 5) }}</div>
                <div class="number">{{ $past->number }}</div>
                <div class="email">{{ $past->user->email }}</div>
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