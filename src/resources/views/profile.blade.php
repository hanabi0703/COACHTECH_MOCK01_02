@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection
@section('js')
    <script src="{{ asset('/js/preview.js') }}"></script>
    <script src="{{ asset('/js/tab_change.js') }}"></script>
@endsection

@section('content')
<div class="profile__content">
    <div class="profile__header">
            <figure class="profile-figure">
                <img src="{{ asset('storage/images/'. $profile['image']) }}" alt="">
            </figure>
            <div class="profile__name">
                <p>{{ $profile['name'] }}</p>
            </div>
        <div class="profile__edit-button">
            <a href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>
        <ul class="tab__list">
            <li class="tab__title active">出品した商品</li>
            <li class="tab__title">購入した商品</li>
        </ul>
    <div class="tab__panel active">
        <ul class="products-list">
        @foreach ($products as $product)
            <li>
                <a href="{{ route('product.detail', ['id'=>$product->id]) }}" class="product-list__link">
                <div class="products-list__item">
                        <img src="{{ asset('storage/images/'. $product->image) }}" alt="">
                    <div class="products-list_text">
                        <span class="">{{$product->name}}</span>
                    </div>
                </div>
                </a>
            </li>
        @endforeach
        </ul>
    </div>
    <div class="tab__panel">
        <ul class="products-list">
        @foreach ($purchases as $purchase)
            <li>
                <a href="{{ route('product.detail', ['id'=>$purchase->id]) }}" class="product-list__link">
                <div class="products-list__item">
                        <img src="{{ asset('storage/images/'. $purchase->image) }}" alt="">
                    <div class="products-list_text">
                        <span class="">{{$purchase->name}}</span>
                    </div>
                </div>
                </a>
            </li>
        @endforeach
        </ul>
    </div>
</div>
@endsection