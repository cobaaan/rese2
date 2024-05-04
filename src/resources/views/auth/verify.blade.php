@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/fortify.css') }}" />
@endsection

@section('content')
<div class="content">
    <h2 class="content__ttl">Verify</h2>
    <div class="verify">
        <form action="{{ route('verification.send') }}" method="post">
            @csrf
            <div>
                <p>認証メールの再送信</p>
                <button>再送信</button>
            </div>
        </form>
        <form action="/register" method="get">
            @csrf
            <div>
                <p>アカウントの作り直しはこちら</p>
                <button>再作成</button>
            </div>
        </form>
        <form action="/" method="get">
            @csrf
            <div>
                <p>メール確認後ページ遷移しない場合はこちら</p>
                <button>ホーム</button>
            </div>
        </form>
    </div>
</div>
@endsection