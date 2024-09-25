@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/csvImport.css') }}" />
@endsection

@section('content')
<div class="content">
    <h2 class="content__ttl">NewShopCreate</h2>
    <p class="content__txt">csvファイルを選択して店舗を作成します。</p>
    <form action="/shop/create/admin" method="post" enctype="multipart/form-data">
        @csrf
        <input class="content__input" type="file" accept=".csv" name="csv_file">
        <p class="error__message">{{ $errors->first('csv_file') }}</p>
        <button class="content__btn">送信</button>
    </form>
    
    @if($errors->has('manager_id'))
    <p class="error__message--csv">{{ $errors->first('manager_id') }}</p>
    @endif
    @if($errors->has('name'))
    <p class="error__message--csv">{{ $errors->first('name') }}</p>
    @endif
    @if($errors->has('area'))
    <p class="error__message--csv">{{ $errors->first('area') }}</p>
    @endif
    @if($errors->has('genre'))
    <p class="error__message--csv">{{ $errors->first('genre') }}</p>
    @endif
    @if($errors->has('description'))
    <p class="error__message--csv">{{ $errors->first('description') }}</p>
    @endif
    @if($errors->has('image_url'))
    <p class="error__message--csv">{{ $errors->first('image_url') }}</p>
    @endif
</div>
@endsection