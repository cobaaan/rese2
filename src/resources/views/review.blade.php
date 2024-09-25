@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}" />
@endsection

@section('content')
<div class="content">
    <div class="shop">
        <p class="shop__index">今回のご利用はいかがでしたか？</p>
        
        <div class="card">
            <img class="card__img" src="{{ $shop->image_path }}">
            <p class="card__ttl">{{ $shop->name }}</p>
            
            @php
            $color = 'card__form--heart-img';
            @endphp
            @auth
            @foreach($favorites as $favorite)
            @if($favorite['user_id'] === $auth->id && $favorite['shop_id'] === $shop->id)
            @php
            $color = 'card__form--heart-red';
            @endphp
            @endif
            @endforeach
            <form method="post" action="?" class="card__form--heart-1">
                @csrf
                <button class="card__form--heart" method="POST" formaction="{{ route('favorite.toggle', $shop->id) }}"><img class="{{ $color }}" src="image/life.jpg"></button>
            </form>
            @endauth
            
            <div class="card__tag">
                <div>#{{ $shop->area->area }}</div>
                <div>#{{ $shop->genre->genre }}</div>
            </div>
            
            <form class="card__form" method="post" action="?">
                @csrf
                <input type="hidden" name="id" value="{{ $shop->id }}">
                <input type="hidden" name="name" value="{{ $shop->name }}">
                <input type="hidden" name="area" value="{{ $shop->area->area }}">
                <input type="hidden" name="genre" value="{{ $shop->genre->genre }}">
                <input type="hidden" name="description" value="{{ $shop->description }}">
                <input type="hidden" name="image_path" value="{{ $shop->image_path }}">
                <button class="card__form--btn" formaction="/shop/detail">詳しく見る</button>
            </form>
        </div>
    </div>
    
    <div class="line"></div>
    
    <div class="review">
        @if(empty($review))
        <form class="review__form" action="/review/post" method="post" enctype="multipart/form-data">
            @csrf
            <div class="review__index">
                <p class="review__index--ttl">体験を評価してください</p>
                @if($errors->has('rate'))
                <p class="error__message">{{ $errors->first('rate') }}</p>
                @endif
            </div>
            <div class="star-rating">
                <span class="star" data-value="5">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="1">&#9733;</span>
            </div>
            <input type="hidden" name="rate" id="ratingValue" value="">
            
            <div class="review__index">
                <p class="review__index--ttl">口コミを投稿</p>
                @if($errors->has('comment'))
                <p class="error__message">{{ $errors->first('comment') }}</p>
                @endif
            </div>
            <textarea class="review__comment" maxlength="400" name="comment"></textarea>
            <div class="review__comment--count">
                <p class="review__comment--count-number">0</p>
                <p class="review__comment--count-txt">/400（最大文字数）</p>
            </div>
            
            <div class="review__index">
                <p class="review__index--ttl">画像の追加</p>
                @if($errors->has('image_path'))
                <p class="error__message">{{ $errors->first('image_path') }}</p>
                @endif
            </div>
            <label class="review__file">
                クリックして写真を追加<br><span class="review__file--subtitle">またはドラッグ&ドロップ</span>
                <input type="file" name="image_path" id="fileInput" accept=".png, .jpeg">
            </label>
            <p class="review__file--name"></p>
            
            <input type="hidden" name="user_id" value="{{ $auth->id }}">
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <button class="review__submit">口コミを投稿</button>
        </form>
        @else
        <form action="/review/update" method="post" enctype="multipart/form-data">
            @csrf
            <div class="review__index">
                <p class="review__index--ttl">体験を評価してください</p>
                @if($errors->has('rate'))
                <p class="error__message">{{ $errors->first('rate') }}</p>
                @endif
            </div>
            <div class="star-rating">
                @for ($i = 5; $i >= 1; $i--)
                <span class="star {{ $review->rate == $i ? 'selected' : '' }}" data-value="{{ $i }}">&#9733;</span>
                @endfor
            </div>
            <input type="hidden" name="rate" id="ratingValue" value="{{ $review->rate }}">
            
            <div class="review__index">
                <p class="review__index--ttl">口コミを投稿</p>
                @if($errors->has('comment'))
                <p class="error__message">{{ $errors->first('comment') }}</p>
                @endif
            </div>
            <textarea class="review__comment" maxlength="400" name="comment">{{ $review->comment }}</textarea>
            <div class="review__comment--count">
                <p class="review__comment--count-number">0</p>
                <p class="review__comment--count-txt">/400（最大文字数）</p>
            </div>
            
            <div class="review__index">
                <p class="review__index--ttl">画像の追加</p>
                @if($errors->has('image_path'))
                <p class="error__message">{{ $errors->first('image_path') }}</p>
                @endif
            </div>
            <label class="review__file">
                クリックして写真を追加<br><span class="review__file--subtitle">またはドラッグ&ドロップ</span>
                <input type="file" name="image_path" id="fileInput" accept=".png, .jpeg">
            </label>
            <p class="review__file--name">{{ $review->image_path }}</p>
            <input type="hidden" name="existing_image_path" value="{{ $review->image_path }}">
            <input type="hidden" name="user_id" value="{{ $auth->id }}">
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <button class="review__submit">口コミを編集</button>
        </form>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('ratingValue');
        
        const initialRating = ratingInput.value;
        stars.forEach(star => {
            if (star.getAttribute('data-value') <= initialRating) {
                star.classList.add('selected');
            }
        });
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-value');
                ratingInput.value = rating;
                
                stars.forEach(star => {
                    star.classList.remove('selected');
                });
                this.classList.add('selected');
                
                let previousSibling = this.previousElementSibling;
                while (previousSibling) {
                    previousSibling.classList.add('selected');
                    previousSibling = previousSibling.previousElementSibling;
                }
            });
            
            star.addEventListener('mouseout', function() {
                stars.forEach(star => {
                    star.classList.remove('selected');
                });
                
                const currentRating = ratingInput.value;
                stars.forEach(star => {
                    if (star.getAttribute('data-value') <= currentRating) {
                        star.classList.add('selected');
                    }
                });
            });
        });
    });
    
    const textarea = document.querySelector('.review__comment');
    
    const string_count = document.querySelector('.review__comment--count-number');
    
    textarea.addEventListener('keyup', onKeyUp);
    
    function onKeyUp() {
        var inputText = textarea.value;
        string_count.innerText = inputText.length;
    }
    
    document.getElementById('fileInput').addEventListener('change', function() {
        const fileList = this.files;
        const fileNamesContainer = document.querySelector('.review__file--name');
        
        let fileNames = [];
        for (let i = 0; i < fileList.length; i++) {
            fileNames.push(fileList[i].name);
        }
        
        fileNamesContainer.textContent = fileNames.join(', ');
    });
</script>
@endsection