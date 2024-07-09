@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}" />
@endsection

@section('content')
<div class="content">
    <p class="content__ttl">{{ $message }}</p>
    <form action="/" method="get">
        @csrf
        <button class="content__btn">戻る</button>
    </form>
</div>
@endsection