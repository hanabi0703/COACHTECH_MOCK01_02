@extends('layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('button')
<!-- <nav class="header-nav">
    <a class="header-nav__link" href="/register">register</a>
    <a class="header-nav__link" href="/login">login</a>
</nav> -->
@endsection

@section('title', 'COACHTECH')

@section('content')
<div class="login__content-base">
    <div class="login-form__heading">
        <h2>ログイン</h2>
    </div>
    <div class="login__content">
    <form class="form"  action="{{ route('login')}}" method="post" novalidate>
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" value="{{ old('email') }}" />
                </div>
                <div class="form__error">
                @error('email')
                {{ $message }}
                @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">パスワード</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="password" name="password" />
                </div>
                <div class="form__error">
                @error('password')
                {{ $message }}
                @enderror
                </div>
            </div>
        </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">ログインする</button>
            </div>
    </form>
    <a class="login__register_link" href="/register">会員登録はこちら</a>
    </div>
</div>
@endsection