@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_all.css') }}" />
@endsection

@section('content')
<div class="content">
    <table>
        <tr>
            <th class="name">お名前</th>
            <th class="role">ロール</th>
            <th class="mail">Eメールアドレス</th>
            <th></th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td class="name">{{ $user->name }}</td>
            <td class="role">{{ $user->role }}</td>
            <td class="mail">{{ $user->email }}</td>
            <td>
                <form action="/mail_form" method="post">
                    @csrf
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <button class="btn">メール送信</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    
</div>
@endsection