@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reviewList.css') }}" />
@endsection

@section('content')
<div class="main">
    <h2 class="main__ttl">Review List</h2>
    
    <ul class="main__list--index">
        <li class="main__list--item txt__id">ID</li>
        <li class="main__list--item txt__name">名前</li>
        <li class="main__list--item txt__comment">レビュー</li>
        <li class="main__list--item txt__btn"></li>
    </ul>
    
    @foreach($reviews as $comment)
    <ul class="main__list" data-id="{{ $comment->id }}" data-name="{{ $comment->user->name }}" data-comment="{{ $comment->comment }}">
        <li class="main__list--item txt__id">{{ $comment->id }}</li>
        <li class="main__list--item txt__name">{{ $comment->user->name }}</li>
        <li class="main__list--item txt__comment">{{ $comment->comment }}</li>
        <li class="main__list--item txt__btn">
            <button class="main__list--item-btn" onclick="openModal({{ $comment->id }})">削除</button>
        </li>
        
        <section id="modal-{{ $comment->id }}" class="modal">
            <h2 class="modal__ttl">このレビューを削除しますか？</h2>
            <p class="modal__txt">レビュー ID : {{ $comment->id }}</p>
            <p class="modal__txt">レビューしたユーザー : {{ $comment->user->name }}</p>
            <p class="modal__txt">レビュー : {{ $comment->comment }}</p>
            <div class="modal__buttons">
                <form action="/review/delete/admin" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $comment->id }}">
                    <button class="modal__btn modal__btn--delete">削除する</button>
                </form>
                <button class="modal__btn modal__btn--close" onclick="closeModal({{ $comment->id }})">閉じる</button>
            </div>
        </section>
        
        <div id="mask-{{ $comment->id }}" class="mask" onclick="closeModal({{ $comment->id }})" disabled></div>
    </ul>
    @endforeach
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById('modal-' + id);
        const mask = document.getElementById('mask-' + id);
        modal.style.display = 'block';
        mask.style.display = 'block';
    }
    
    function closeModal(id) {
        const modal = document.getElementById('modal-' + id);
        const mask = document.getElementById('mask-' + id);
        modal.style.display = 'none';
        mask.style.display = 'none';
    }
</script>
@endsection