@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/change_reserve.css') }}" />
@endsection

@section('content')
<div class="content">
    <div class="current">
        <div class="">
            <h2 class="current__ttl">現在の予約</h2>
            <table>
                <tr>
                    <td>Shop</td>
                    <td>{{ $shops[$reserves[0]->shop_id - 1]->name }}</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>{{ $reserves[0]->date }}</td>
                </tr>
                <tr>
                    <td>Time</td>
                    <td>{{ $reserves[0]->time }}</td>
                </tr>
                <tr>
                    <td>Number</td>
                    <td>{{ $reserves[0]->number }}</td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="reserve">
        <h2 class="reserve__ttl">予約の変更</h2>
        <form action="/update_reserve" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $reserves[0]->id }}">
            <input type="hidden" name="user_id" value="{{ $auth->id }}">
            <input type="hidden" name="shop_id" value="{{ $reserves[0]->id - 1 }}">
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
                        <td>{{ $shops[$reserves[0]->shop_id - 1]->name }}</td>
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