@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/visit.css') }}" />
@endsection

@section('content')
<div class="content">
    <h2 class="content__ttl">来店確認</h2>
    <p class="content__txt">来店済みにする</p>
    <form action="?" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <button class="content__btn" formaction="/shop/visited">はい</button>
        <button class="content__btn" formaction="/">いいえ</button>
    </form>
</div>
@endsection