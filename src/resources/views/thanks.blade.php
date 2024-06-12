@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}" />
@endsection

@section('content')
<div class="content">
    <div>
        <p class="content__ttl">{{ $message }}</p>
        <form action="/" method="get">
            @csrf
            <div class="content__form">
                <button class="content__btn">戻る</button>
            </div>
        </div>
    </form>
</div>
</div>
@endsection