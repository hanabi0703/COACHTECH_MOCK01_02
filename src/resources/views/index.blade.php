@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/js/tab_change.js') }}"></script>
@endsection

@section('button')
    <form class="search-form" action="/products/search" method="get">
        <div class="search-form__item">
            <input class="search-form__item-input" type="text" name="keyword" value="{{ old('keyword') }}">
        </div>
    </form>
@endsection

@section('content')
<div class="index__content">
    <div class="index__heading">
        <ul class="tab__list">
            <li class="tab__title active">おすすめ</li>
            <li class="tab__title">マイリスト</li>
        </ul>
    </div>
    <div class="tab__contents">
        <div class="tab__panel active">
            <ul class="products-list">
            @foreach ($products as $product)
                <li>
                    <a href="{{ route('product.detail', ['id'=>$product->id]) }}" class="product-list__link">
                    <div class="products-list__item">
                        <img src="{{ asset('storage/images/'. $product->image) }}"
                        class="
                        <?php
                        if ($product['is_sold_out'] == '1') {
                        echo 'blur';
                        }
                        ?>
                        "alt="">
                        <?php
                        if ($product['is_sold_out'] == '1') {
                        echo '<p class="product__sold">Sold</p>';
                        }
                        ?>
                        <div class="products-list_text">
                            <span>{{$product->name}}</span>
                        </div>
                    </div>
                    </a>
                </li>
            @endforeach
            </ul>
        </div>
        <div class="tab__panel">
            <ul class="products-list tab__panel">
            @foreach ($likes as $like)
                <li>
                    <a href="{{ route('product.detail', ['id'=>$like->id]) }}" class="product-list__link">
                    <div class="products-list__item">
                        <img src="{{ asset('storage/images/'. $like->image) }}" class="
                        <?php
                        if ($like['is_sold_out'] == '1') {
                        echo 'blur';
                        }
                        ?>
                        "alt="">
                        <?php
                        if ($like['is_sold_out'] == '1') {
                        echo '<p class="product__sold">Sold</p>';
                        }
                        ?>
                        <div class="products-list_text">
                            <span>{{$like->name}}</span>
                        </div>
                    </div>
                    </a>
                </li>
            @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection