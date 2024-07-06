@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}" />
@endsection

@section('content')
<div class="content">
    <h2 class="content__ttl">Verify</h2>
    <div class="verify">
        <form class="verify__form" action="{{ route('verification.send') }}" method="post">
            @csrf
            <p>認証メールの再送信</p>
            <button class="verify__btn">再送信</button>
        </form>
        <form class="verify__form" action="/logout" method="post">
            @csrf
            <p>アカウントの作り直しはこちら</p>
            <button class="verify__btn">再作成</button>
        </form>
        <form class="verify__form" action="/" method="get">
            @csrf
            <p>メール確認後ページ遷移しない場合はこちら</p>
            <button class="verify__btn">ホーム</button>
        </form>
    </div>
</div>
@endsection