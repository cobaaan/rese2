@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mail_form.css') }}" />
@endsection

@section('content')
<div class="info">
    <h2 class="info__ttl">メールの一斉送信</h2>
    <div>
        <form action="/mail/send" method="post">
            @csrf
            <input class="form__subject" type="text" name="subject" placeholder="件名">
            <div class="form__subject--error">
                @error('subject')
                <p class="error__message">{{ $errors->first('subject') }}</p>
                @enderror
            </div>
            <br>
            <textarea class="form__body" name="body" id="" cols="70" rows="10" placeholder="送信内容"></textarea>
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
@endsection