@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}" />
<link rel="stylesheet" href="{{ asset('css/shop_modal.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
@endsection

@section('content')

<section id="modal">
    @if (session('flash_alert'))
    <p class="alert alert-danger">{{ session('flash_alert') }}</p>
    @elseif(session('status'))
    <p class="alert alert-success">{{ session('status') }}</p>
    @endif
    <div class="modal__ttl">事前決済</div>
    <div id="card-errors" class="text-danger"></div>
    <form id="card-form" action="{{ route('payment.store') }}" method="POST">
        @csrf
        <div class="modal__content">
            <label for="card_number">カード番号</label>
            <div id="card-number" class="form__control"></div>
        </div>
        <div class="modal__content">
            <label for="card_expiry">有効期限</label>
            <div id="card-expiry" class="form__control"></div>
        </div>
        <div class="modal__content">
            <label for="card-cvc">セキュリティコード</label>
            <div id="card-cvc" class="form__control"></div>
        </div>
        <div class="modal__content">
            <label for="card-amount">支払い価格</label><br>
            <input type="number" name="amount" id="card-amount" class="form__control form__control--number" placeholder="1000" required min="100">
        </div>
        @if($errors->has('amount'))
        <p>{{ $erros->first('amount') }}</p>
        @endif
        <button class="mt-3 btn btn-primary" type="submit">支払い</button>
    </form>
    <button id="close" class="cancel__btn">キャンセル</button>
</section>

<div id="mask"></div>


<h2 class="ttl">{{ $auth['name'] }}さん</h2>

<div class="body">
    <div class="left">
        <h2 class="body__ttl">予約状況</h2>
        @if(!is_null($futureReservations))
        <?php $counter = 0; ?>
        @foreach($futureReservations as $futureReservation)
        <div class="left__content">
            <div class="left__content--header">
                <i class="left__content--header-icon bi bi-clock"></i>
                <p class="left__content--ttl">予約{{ $counter + 1 }}</p>
                <form action="/reserve/cancel" method="post"  class="left__content--cross">
                    @csrf
                    <input type="hidden" name="id" value="{{ $futureReservation->id }}">
                    <button class="left__content--btn bi bi-x-circle"></button>
                </form>
            </div>
            <?php $counter++; ?>
            <table class="left__content--table">
                <tr>
                    <td class="left__content--txt">Shop</td>
                    <td class="left__content--txt">{{ $futureReservation->shop->name }}</td>
                </tr>
                <tr>
                    <td class="left__content--txt">Date</td>
                    <td class="left__content--txt">{{ $futureReservation->date }}</td>
                </tr>
                <tr>
                    <td class="left__content--txt">Time</td>
                    <td class="left__content--txt">{{ substr($futureReservation->time, 0, 5) }}</td>
                </tr>
                <tr>
                    <td class="left__content--txt">Number</td>
                    <td class="left__content--txt">{{ $futureReservation->number }}</td>
                </tr>
            </table>
            <div class="card__footer">
                <div class="card__footer--qr">
                    {!! QrCode::size(100)->generate(route('visit', ['id' => $futureReservation->id])) !!}
                </div>
                <div class="card__footer--btn">
                    <button type="menu" class="left__content--change-btn open">事前決済</button>
                    <form class="card__footer--form" action="?" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $futureReservation->id }}">
                        <button class="left__content--change-btn" formaction="/reserve/change">変更</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <div class="center">
        <h2 class="body__ttl">お気に入り店舗</h2>
        <div class="center__content">
            @if(!is_null($favorites))
            <div class="center__content">
                @foreach ($favorites as $favorite)
                <div class="card">
                    <img class="card__img" src="{{ $favorite->shop->image_path }}">
                    <div class="card__ttl">{{ $favorite->shop->name }}</div>
                    <div class="card__tag">
                        <div>#{{ $favorite->shop->area->area }}</div>
                        <div>#{{ $favorite->shop->genre->genre }}</div>
                    </div>
                    <div>
                        <form class="card__form" method="post" action="?">
                            @csrf
                            <input type="hidden" name="id" value="{{ $favorite->shop->id }}">
                            <input type="hidden" name="name" value="{{ $favorite->shop->name }}">
                            <input type="hidden" name="area" value="{{ $favorite->shop->area->area }}">
                            <input type="hidden" name="genre" value="{{ $favorite->shop->genre->genre }}">
                            <input type="hidden" name="description" value="{{ $favorite->shop->description }}">
                            <input type="hidden" name="image_path" value="{{ $favorite->shop->image_path }}">
                            <div class="card__form--footer">
                                <button class="card__form--btn" formaction="/shop/detail">詳しく見る</button>
                                <button class="card__form--heart"  method="POST" formaction="{{ route('favorite.toggle', $shops[$favorite->shop_id - 1]) }}"><img  class="card__form--heart-red" src="image/life.jpg"></button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="right">
        <h2 class="body__ttl">来店済み</h2>
        @if(!is_null($pastReservations))
        <div class="right__content">
            @foreach ($pastReservations as $pastReservation)
            <div class="right__card">
                <img class="card__img" src="{{ $pastReservation->shop->image_path }}">
                <div>
                    <div class="card__ttl">{{ $pastReservation->shop->name }}</div>
                    <div class="card__date-time">来店日時 {{ $pastReservation->date }} {{ substr($pastReservation->time, 0, 5) }}</div>
                    <div class="card__date-time">人数 {{ $pastReservation->number }}人</div>
                    <form class="right__card--form" method="get" action="/review">
                        @csrf
                        <input type="hidden" name="reserve_id" value="{{ $pastReservation->id }}">
                        <input type="hidden" name="shop_id" value="{{ $pastReservation->shop_id }}">
                        <button class="card__form--btn">レビュー</button>
                    </form>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const close = document.querySelector('#close');
    const modal = document.querySelector('#modal');
    const mask = document.querySelector('#mask');
    const showKeyframes = {
        opacity: [0, 1],
        visibility: 'visible',
    };
    const hideKeyframes = {
        opacity: [1, 0],
        visibility: 'hidden',
    };
    const options = {
        duration: 800,
        easing: 'ease',
        fill: 'forwards',
    };
    
    document.querySelectorAll('.open').forEach(button => {
        button.addEventListener('click', () => {
            modal.animate(showKeyframes, options);
            mask.animate(showKeyframes, options);
        });
    });
    
    close.addEventListener('click', () => {
        modal.animate(hideKeyframes, options);
        mask.animate(hideKeyframes, options);
    });
    
    mask.addEventListener('click', () => {
        close.click();
    });
    
    const stripe_public_key = "{{ config('stripe.stripe_public_key') }}"
    const stripe = Stripe(stripe_public_key);
    const elements = stripe.elements();
    
    var cardNumber = elements.create('cardNumber');
    cardNumber.mount('#card-number');
    cardNumber.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    var cardExpiry = elements.create('cardExpiry');
    cardExpiry.mount('#card-expiry');
    cardExpiry.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    var cardCvc = elements.create('cardCvc');
    cardCvc.mount('#card-cvc');
    cardCvc.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    var form = document.getElementById('card-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        var errorElement = document.getElementById('card-errors');
        if (event.error) {
            errorElement.textContent = event.error.message;
        } else {
            errorElement.textContent = '';
        }
        
        stripe.createToken(cardNumber).then(function(result) {
            if (result.error) {
                errorElement.textContent = result.error.message;
            } else {
                stripeTokenHandler(result.token);
            }
        });
    });
    
    function stripeTokenHandler(token) {
        var form = document.getElementById('card-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script>
@endsection
