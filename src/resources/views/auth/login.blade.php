@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-form__page">
    <div class="login-form__inner">
        <div class="login-form__heading">
            <h2>Login</h2>
        </div>

        <div class="login-form__main">
            <form class="form" action="/login" method="post" novalidate>
                @csrf
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label-item">メールアドレス</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com">
                        </div>
                        <div class="form__error">
                            @error('email')
                            @if(strpos($message, '入力') !== false)
                            {{ $message }}
                            @endif
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label-item">パスワード</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="password" name="password" placeholder="例: coachtech1106">
                        </div>
                        <div class="form__error">
                            @error('password')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
        </div>

        <div class="form__button">
            <button class="form__button-submit" type="submit">ログイン</button>
        </div>
        </form>
    </div>
</div>
</div>
@endsection