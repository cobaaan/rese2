@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mail_form.css') }}" />
@endsection

@section('content')
<div>
    <div class="info">
        <div class="info__left">
            <div class="info__left--header">
                <h2 class="info__left--ttl">メールの送信</h2>
                <p class="info__left--to">To {{ $requests['email'] }}</p>
            </div>
            <div>
                <form action="/send_mail" method="post">
                    @csrf
                    <input type="hidden" name="name" value="{{ $requests['name'] }}">
                    <input type="hidden" name="email" value="{{ $requests['email'] }}">
                    <input class="form__subject" type="text" name="subject" placeholder="件名">
                    <div class="form__subject--error">
                        @error('subject')
                        <p class="error__message">{{ $errors->first('subject') }}</p>
                        @enderror
                    </div>
                    <br>
                    <textarea class="form__body" name="body" id="" cols="80" rows="10" placeholder="送信内容">{{ $requests['name'] }} 様</textarea>
                    <div class="form__subject--error">
                        @error('body')
                        <p class="error__message">{{ $errors->first('body') }}</p>
                        @enderror
                    </div>
                    <br>
                    <button class="form__btn">送信</button>
                </form>
            </div>
        </div>
        <div class="info__content">
            <h2 class="ttl">お客様情報</h2>
            <div>
                <div class="info__content--item">お名前: {{ $requests['name'] }} 様</div>
                @if(isset($requests['date']) && isset($requests['time']))
                <div class="info__content--item">来店日時: {{ $requests['date'] }}  {{ $requests['time'] }}</div>
                @endif
                @if(isset($requests['number']))
                <div class="info__content--item">人数: {{ $requests['number'] }}</div>
                @endif
                @if(isset($requests['role']))
                <div class="info__content--item">Role: {{ $requests['role'] }}</div>
                @endif
            </div>
        </div>
    </div>
    
</div>
@endsection