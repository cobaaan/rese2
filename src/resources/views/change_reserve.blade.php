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
            <input type="hidden" name="page" value="change_reserve">
            <input type="hidden" name="id" value="{{ $reserves[0]->id }}">
            <input type="hidden" name="user_id" value="{{ $auth->id }}">
            <input type="hidden" name="shop_id" value="{{ $reserves[0]->id - 1 }}">
            <input class="reserve__date" type="date" name="date" value="{{ old('date') }}" min="{{ $dt->format('Y-m-d') }}" id="date">
            <div class="form__subject--error reserve__date--error">
                @error('date')
                <p class="error__message">{{ $errors->first('date') }}</p>
                @enderror
            </div>
            <div class="reserve__time">
                <select name="time" class="reserve__time--time" id="time">
                    @for($i = 00; $i < 24; $i++)
                    <option value={{ $i }}>{{ $i }}</option>
                    @endfor
                </select>
                <p class="reserve__time--colon">:</p>
                <select name="minute" class="reserve__time--minute" id="minute">
                    <option value="00">00</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div class="form__subject--error reserve__date--error">
                @error('time')
                <p class="error__message">{{ $errors->first('time') }}</p>
                @enderror
            </div>
            <select class="reserve__number" name="number" value="{{ old('number') }}" id="number">
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
                        <td id="confirmDate"></td>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <td id="confirmTime"></td>
                    </tr>
                    <tr>
                        <td>Number</td>
                        <td id="confirmNumber"></td>
                    </tr>
                </table>
            </div>
            <button class="reserve__btn">予約する</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');
        const minuteInput = document.getElementById('minute');
        const numberInput = document.getElementById('number');
        
        const confirmDate = document.getElementById('confirmDate');
        const confirmTime = document.getElementById('confirmTime');
        const confirmNumber = document.getElementById('confirmNumber');
        
        function updateConfirm() {
            confirmDate.textContent = dateInput.value || '年/月/日';
            confirmTime.textContent = timeInput.value  + ':' + minuteInput.value;
            confirmNumber.textContent = numberInput.value  + '人';
        }
        
        dateInput.addEventListener('input', updateConfirm);
        timeInput.addEventListener('input', updateConfirm);
        minuteInput.addEventListener('input', updateConfirm);
        numberInput.addEventListener('input', updateConfirm);
        
        updateConfirm();
    });
</script>

@endsection