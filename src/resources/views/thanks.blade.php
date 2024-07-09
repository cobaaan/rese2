@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}" />
@endsection

@section('content')
<div class="content">
    <p class="content__ttl">{{ $message }}</p>
    <form action="/" method="get">
        @csrf
        <button class="content__btn">{{ $message1 }}</button>
    </form>
</div>
@endsection