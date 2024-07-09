@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mail_form.css') }}" />
@endsection

@section('content')
<div class="info">
    <h2 class="info__ttl">メールの一斉送信</h2>
    <form action="/mail/send" method="post">
        @csrf
        <input class="form__subject" type="text" name="subject" placeholder="件名">
        <br>
        
        @error('subject')
        <p class="error__message">{{ $errors->first('subject') }}</p>
        @enderror
        <br>
        
        <textarea class="form__body" name="body" rows="10" placeholder="送信内容"></textarea>
        <br>
        
        @error('body')
        <p class="error__message">{{ $errors->first('body') }}</p>
        @enderror
        <br>
        
        <button class="form__btn">送信</button>
    </form>
</div>
@endsection