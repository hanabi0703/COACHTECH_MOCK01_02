@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/purchase.js') }}"></script>
@endsection


@section('content')
<div class="purchase__content">
    <form class="purchase-form" action="/buy" method="post" enctype="multipart/form-data">
        @csrf
    <div class="purchase__input__contents">
        <div class="purchase-form__content__top">
            <input type="hidden" name="id" value="{{ $product['id'] }}"/>
            <figure class="purchase-figure">
                <img src="{{ asset('storage/images/'. $product->image) }}" alt="">
            </figure>
            <div class="purchase__detail">
                <p>{{ $product['name'] }}</p>
                <p>¥{{ $product['price'] }}</p>
            </div>
        </div>
        <div class="purchase-form__content">
            <div class="purchase__title">
                <h3>支払い方法</h3>
            </div>
            <select class="purchase__content__payment" name="payment" value="選択してください" id="payment">
                <option value="1">コンビニ払い</option>
                <option value="2">カード払い</option>
            </select>
        </div>
        <div class="purchase-form__content">
            <div class="purchase__title">
                <h3>配送先</h3>
                <a class="purchase__link" href="{{ route('purchase.address', ['id'=>$product->id]) }}">変更する</a>
            </div>
            <div class="purchase__content__address">
                <input type="hidden" name="post_code" value="{{ $profile['post_code'] }}"/>
                <input type="hidden" name="address" value="{{ $profile['address'] }}"/>
                <input type="hidden" name="building" value="{{ $profile['building'] }}"/>
                <p>〒{{ $profile['post_code'] }}</p>
                <p>{{ $profile['address'] }}{{ $profile['building'] }}</p>
            </div>
        </div>
    </div>
    <div class="purchase__display__contents">
        <div class="purchase__display__content">
            <div class="purchase__display">
                <span>商品代金</span>
                <p>¥{{ $product['price'] }}</p>
            </div>
        </div>
        <div class="purchase__display__content">
            <div class="purchase__display">
                <span>支払い方法</span>
                <div id="Box1">
                    <p>コンビニ払い</p>
                </div>
                <div id="Box2" style="display: none;">
                    <p>カード払い</p>
                </div>
            </div>
    </div>
    <button class="form__button-submit" type="submit">購入する</button>
    </form>
</div>
@endsection