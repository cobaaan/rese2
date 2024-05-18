@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
@endsection

@section('content')
<div>
    <h2 class="ttl">{{ $auth['name'] }}さん</h2>
</div>
<div class="body">
    <div class="left">
        <h2 class="body__ttl">予約状況</h2>
        @if(!is_null($futureReservations))
        <?php $counter = 0; ?>
        @foreach($futureReservations as $futureReservation)
        <div class="left__content">
            <div class="left__content--header">
                <i class="bi bi-clock"></i>
                <p class="left__content--ttl">予約{{ $counter + 1 }}</p>
                <form action="/cancel" method="post"  class="left__content--cross">
                    @csrf
                    <input type="hidden" name="id" value="{{ $futureReservation->id }}">
                    <button class="left__content--btn bi bi-x-circle"></button>
                </form>
            </div>
            <?php $counter++; ?>
            <table>
                <tr>
                    <td>Shop</td>
                    <td>{{ $shops[$futureReservation->shop_id - 1]->name }}</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>{{ $futureReservation->date }}</td>
                </tr>
                <tr>
                    <td>Time</td>
                    <td>{{ $futureReservation->time }}</td>
                </tr>
                <tr>
                    <td>Number</td>
                    <td>{{ $futureReservation->number }}</td>
                </tr>
            </table>
            
            <form action="/change_reserve" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $futureReservation->id }}">
                <button class="left__content--change-btn">変更</button>
            </form>
        </div>
        @endforeach
        @endif
    </div>
    
    <div class="center">
        <h2 class="body__ttl">お気に入り店舗</h2>
        <div class="center__content">
            @if(!is_null($favorites))
            <div class="center__content">
                @foreach ($favorites as $favorite)
                <div class="card">
                    <img class="card__img" src="{{ $shops[$favorite->shop_id - 1]->image_path }}">
                    <div>
                        <div class="card__ttl">{{ $shops[$favorite->shop_id - 1]->name }}</div>
                        <div class="card__tag">
                            <div>#{{ $shops[$favorite->shop_id - 1]->area }}</div>
                            <div>#{{ $shops[$favorite->shop_id - 1]->genre }}</div>
                        </div>
                        <div>
                            <form class="card__form" method="post" action="?">
                                @csrf
                                <input type="hidden" name="id" value="{{ $shops[$favorite->shop_id - 1]->id }}">
                                <input type="hidden" name="name" value="{{ $shops[$favorite->shop_id - 1]->name }}">
                                <input type="hidden" name="area" value="{{ $shops[$favorite->shop_id - 1]->area }}">
                                <input type="hidden" name="genre" value="{{ $shops[$favorite->shop_id - 1]->genre }}">
                                <input type="hidden" name="description" value="{{ $shops[$favorite->shop_id - 1]->description }}">
                                <input type="hidden" name="image_path" value="{{ $shops[$favorite->shop_id - 1]->image_path }}">
                                <div class="card__form--footer">
                                    <button class="card__form--btn" formaction="/shop_detail">詳しく見る</button>
                                    <button class="card__form--heart"  method="POST" formaction="{{ route('favorite.toggle', $shops[$favorite->shop_id - 1]) }}"><img  class="card__form--heart-red" src="image/life.png"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    
    <div class="right">
        <h2 class="body__ttl">来店済み</h2>
        <div class="right__content">
            @if(!is_null($pastReservations))
            <div class="right__content">
                @foreach ($pastReservations as $pastReservation)
                <div class="card right__card">
                    <img class="card__img" src="{{ $shops[$pastReservation->shop_id - 1]->image_path }}">
                    <div>
                        <div class="card__ttl">{{ $shops[$pastReservation->shop_id - 1]->name }}</div>
                        <div>
                            <div class="card__date-time">来店日時 {{ $pastReservation->date }} {{ $pastReservation->time }}</div>
                        </div>
                        <div>
                            <div class="card__date-time">人数 {{ $pastReservation->number }}人</div>
                        </div>
                        <div class="card__footer">
                            <div class="card__footer--qr">
                                
                            </div>
                            <div class="card__footer--btn">
                                <form class="card__form" method="get" action="/review">
                                    @csrf
                                    <input type="hidden" name="reserve_id" value="{{ $pastReservation->id }}">
                                    <input type="hidden" name="shop_id" value="{{ $pastReservation->shop_id }}">
                                    <button class="card__form--btn">レビュー</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection