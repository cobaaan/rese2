@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_all.css') }}" />
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/review_star.css') }}" />
@endsection

@section('header')
<div class="sort">
    <select class="sort__form" name="sort" id="sortSelect">
        <option value="" selected>並び替え</option>
        <option value="random">ランダム</option>
        <option value="high">評価が高い順</option>
        <option value="low">評価が低い順</option>
    </select>
</div>

<div class="search">
    <div class="search__form">
        <select class="search__area" name="area" id="areaSelect">
            <option value="" selected>All area</option>
            @foreach ($areas as $area)
            <option value="{{ $area->area }}">{{ $area->area }}</option>
            @endforeach
        </select>
        <select class="search__genre" name="genre" id="genreSelect">
            <option value="" selected>All genre</option>
            @foreach ($genres as $genre)
            <option value="{{ $genre->genre }}">{{ $genre->genre }}</option>
            @endforeach
        </select>
        <input class="search__text" type="text" name="text" value="{{ old('text') }}" id="searchText" placeholder="Search...">
    </div>
</div>
@endsection

@section('content')
<div class="shop" id="shopList">
    @foreach ($shops as $shop)
    <div class="card" data-area="{{ $shop->area->area }}" data-genre="{{ $shop->genre->genre }}" data-name="{{ $shop->name }}" data-rating="{{ $shop->reviews->avg('rate') }}">
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
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const shopList = document.getElementById('shopList');
        let shops = Array.from(shopList.getElementsByClassName('card'));
        
        const originalOrder = [...shops];
        
        document.querySelector('.sort__form').addEventListener('change', function () {
            const sortValue = this.value;
            shops = Array.from(shopList.getElementsByClassName('card'));
            
            if (sortValue === 'high') {
                shops.sort((a, b) => {
                    if (b.dataset.rating == 0) return -1;
                    if (a.dataset.rating == 0) return 1;
                    return b.dataset.rating - a.dataset.rating;
                });
            } else if (sortValue === 'low') {
                shops.sort((a, b) => {
                    if (a.dataset.rating == 0) return 1;
                    if (b.dataset.rating == 0) return -1;
                    return a.dataset.rating - b.dataset.rating;
                });
            } else if (sortValue === 'random') {
                shops.sort(() => 0.5 - Math.random());
            } else if (sortValue === '') {
                shops = originalOrder;
            }
            
            shopList.innerHTML = '';
            shops.forEach(shop => shopList.appendChild(shop));
        });
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const areaSelect = document.getElementById('areaSelect');
        const genreSelect = document.getElementById('genreSelect');
        const searchText = document.getElementById('searchText');
        const shopList = document.getElementById('shopList');
        const shopCards = shopList.getElementsByClassName('card');
        
        function filterShops() {
            const area = areaSelect.value.toLowerCase();
            const genre = genreSelect.value.toLowerCase();
            const text = searchText.value.toLowerCase();
            
            Array.from(shopCards).forEach(function(card) {
                const cardArea = card.getAttribute('data-area').toLowerCase();
                const cardGenre = card.getAttribute('data-genre').toLowerCase();
                const cardName = card.getAttribute('data-name').toLowerCase();
                console.log('cardarea:', cardArea);
                const matchesArea = area === '' || cardArea.includes(area);
                const matchesGenre = genre === '' || cardGenre.includes(genre);
                const matchesText = text === '' || cardName.includes(text);
                
                if(matchesArea && matchesGenre && matchesText) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        areaSelect.addEventListener('change', filterShops);
        genreSelect.addEventListener('change', filterShops);
        searchText.addEventListener('input', filterShops);
    });
</script>
@endsection