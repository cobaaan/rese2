@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}" />
<link rel="stylesheet" href="{{ asset('css/review_star.css') }}" />
@endsection

@section('content')
<section id="modal">
    <div class="modal__header">
        <h2 class="modal__header--ttl">口コミ一覧</h2>
        <button class="modal__header--btn" id="close">×</button>
    </div>
    @foreach ($reviews as $review)
    <div class="modal__content">
        <div class="modal__content--header">
            <h2 class="modal__content--name">{{ $user[$review['user_id'] - 1]->name }} 様</h2>
            <div class="review__area modal__content--star">
                <p class="star{{ $review['rate'] }}"></p>
            </div>
        </div>
        <p class="modal__content--comment-ttl">コメント</p>
        <p class="modal__content--comment">{{ $review['comment'] }}</p>
    </div>
    @endforeach
</section>
<div id="mask"></div>

<section id="modal-delete" class="modal-delete">
    <h2 class="modal-delete__ttl">レビューを削除しますか？</h2>
    <div class="modal-delete__btn">
        <form action="/review/delete" method="post">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $requests['id'] }}">
            <button class="modal-delete__btn--delete">削除する</button>
        </form>
        <button class="modal-delete__btn--close" onclick="closeModal()">閉じる</button>
    </div>
</section>
<div id="mask-delete" class="mask-delete" onclick="closeModal()" disabled></div>

<div class="content">
    <div class="shop">
        @php
        $admin = auth('admin')->user();
        $manager = auth('manager')->user();
        $user = auth('web')->user();
        @endphp
        <h2 class="shop__name">{{ $requests['name'] }}</h2>
        <img class="shop__img" src="{{ asset($requests['image_path']) }}">
        <div class="shop__tag">
            <p class="shop__area-genre">#{{ $requests['area'] }}</p>
            <p class="shop__area-genre">#{{ $requests['genre'] }}</p>
        </div>
        <p class="shop__description">{{ $requests['description'] }}</p>
        <button class="review__area--btn" id="open">全ての口コミ情報</button>
        
        @if(!is_null($user) && is_null($myReview))
        <form action="/review" method="get">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $requests['id'] }}">
            <button class="shop__review--post">口コミを投稿する</button>
        </form>
        @elseif(!is_null($user) && !is_null($myReview))
        
        <div class="shop__review">
            <form class="shop__review--form" action="/review" method="get">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $requests['id'] }}">
                <button class="shop__review--update">口コミを編集</button>
            </form>
            
            <button class="shop__review--delete" onclick="openModal()">口コミを削除</button>
            
            <div class="review__area shop__header--rate">
                <p class="review__area--star star{{ $myReview->rate }}"></p>
                <p class="shop__review--comment">{{ $myReview->comment }}</p>
            </div>
        </div>
        @endif
    </div>
    
    <div class="reserve">
        <h2 class="reserve__ttl">予約</h2>
        <form action="/reserve" method="post" id="reserveForm">
            @csrf
            <input class="reserve__date" type="date" name="date" value="{{ old('date') }}" min="{{ $dt->format('Y-m-d') }}" id="date">
            <div class="form__subject--error reserve__date--error">
                @error('date')
                <p class="error__message">{{ $errors->first('date') }}</p>
                @enderror
            </div>
            <div class="reserve__time">
                <select name="time" class="reserve__time--time" id="time">
                    @for($i = 00; $i < 24; $i++)
                    <option value={{ $i }}>{{ $i }}</option>
                    @endfor
                </select>
                <p class="reserve__time--colon">:</p>
                <select name="minute" class="reserve__time--minute" id="minute">
                    <option value="00">00</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div class="form__subject--error reserve__date--error">
                @error('time')
                <p class="error__message">{{ $errors->first('time') }}</p>
                @enderror
            </div>
            <select class="reserve__number" name="number" value="{{ old('number') }}" id="number">
                <div class="form__subject--error reserve__date--error">
                    @error('number')
                    <p class="error__message">{{ $errors->first('number') }}</p>
                    @enderror
                </div>
                @for($i = 1; $i < 10; $i++)
                <option value="{{ $i }}">{{ $i }}人</option>
                @endfor
                <option value="10">10人以上</option>
            </select>
            <div class="reserve__confirm">
                <table class="reserve__confirm--table">
                    <tr>
                        <td class="reserve__confirm--txt">Shop</td>
                        <td class="reserve__confirm--txt">{{ $requests['name'] }}</td>
                    </tr>
                    <tr>
                        <td class="reserve__confirm--txt">Date</td>
                        <td class="reserve__confirm--txt" id="confirmDate"></td>
                    </tr>
                    <tr>
                        <td class="reserve__confirm--txt">Time</td>
                        <td class="reserve__confirm--txt" id="confirmTime"></td>
                    </tr>
                    <tr>
                        <td class="reserve__confirm--txt">Number</td>
                        <td class="reserve__confirm--txt" id="confirmNumber"></td>
                    </tr>
                </table>
            </div>
            @auth
            <input type="hidden" name="user_id" value="{{ $auth['id'] }}">
            @endauth
            <input type="hidden" name="page" value="shop_detail">
            <input type="hidden" name="name" value="{{ $requests['name'] }}">
            <input type="hidden" name="image_path" value="{{ $requests['image_path'] }}">
            <input type="hidden" name="area" value="{{ $requests['area'] }}">
            <input type="hidden" name="genre" value="{{ $requests['genre'] }}">
            <input type="hidden" name="description" value="{{ $requests['description'] }}">
            <input type="hidden" name="shop_id" value="{{ $requests['id'] }}">
            <input type="hidden" name="id" value="{{ $requests['id'] }}">
            <input type="hidden" name="is_visit" value=0>
            <button class="reserve__btn">予約する</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('modal-delete');
        const mask = document.getElementById('mask-delete');
        modal.style.display = 'block';
        mask.style.display = 'block';
    }
    
    function closeModal() {
        const modal = document.getElementById('modal-delete');
        const mask = document.getElementById('mask-delete');
        modal.style.display = 'none';
        mask.style.display = 'none';
    }
    
    const open = document.querySelector('#open');
    const close = document.querySelector('#close');
    const modal = document.querySelector('#modal');
    const mask = document.querySelector('#mask');
    const showKeyframes = {
        opacity: [0, 1],
        visibility: 'visible',
        display: 'block',
    };
    const hideKeyframes = {
        opacity: [1, 0],
        visibility: 'hidden',
        display: 'none',
    };
    const options = {
        duration: 800,
        easing: 'ease',
        fill: 'forwards',
    };
    
    open.addEventListener('click', () => {
        modal.animate(showKeyframes, options);
        mask.animate(showKeyframes, options);
    });
    
    close.addEventListener('click', () => {
        modal.animate(hideKeyframes, options);
        mask.animate(hideKeyframes, options);
    });
    
    mask.addEventListener('click', () => {
        close.click();
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');
        const minuteInput = document.getElementById('minute');
        const numberInput = document.getElementById('number');
        const confirmDate = document.getElementById('confirmDate');
        const confirmTime = document.getElementById('confirmTime');
        const confirmNumber = document.getElementById('confirmNumber');
        
        function updateConfirm() {
            confirmDate.textContent = dateInput.value || '年/月/日';
            confirmTime.textContent = `${timeInput.value || '00'}:${minuteInput.value || '00'}`;
            confirmNumber.textContent = numberInput.options[numberInput.selectedIndex].text || 'あとで設定';
        }
        
        dateInput.addEventListener('input', updateConfirm);
        timeInput.addEventListener('input', updateConfirm);
        minuteInput.addEventListener('input', updateConfirm);
        numberInput.addEventListener('change', updateConfirm);
        
        updateConfirm();
    });
</script>
@endsection
