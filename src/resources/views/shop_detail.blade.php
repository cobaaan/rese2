@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}" />
@endsection

@section('content')
<div class="content">
    <div class="shop">
        <h2 class="shop__name">{{ $requests['name'] }}</h2>
        <img class="shop__img" src="{{ $requests['image'] }}">
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
            <input type="hidden" name="user_id" value="{{ $auth }}">
            <input type="hidden" name="shop_id" value="{{ $requests['id'] }}">
            <input class="reserve__date" type="date" name="date" value="{{ old('date') }}" min="{{ $dt->format('Y-m-d') }}">
            <input class="reserve__time" type="time" name="time" value="{{ old('time') }}">
            <select class="reserve__number" name="number" value="{{ old('number') }}">
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
@endsection