@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')
<div class="product__detail__content">
    <div class="detail__figure">
            <input type="hidden" name="id" value="{{ $product['id'] }}"/>
            <div class="detail-figure">
                <figure id="existFigure" class="detail__figure-exist">
                    <img src="{{ asset('storage/images/'. $product->image) }}" alt="">
                </figure>
                <figure id="figure" style="display:none">
                    <img id="figureImage">
                </figure>
            </div>
    </div>
    <div class="detail__contents">
        <div class="detail__content">
            <p class="product__name">{{ $product['name'] }}</p>
        </div>
        <div class="error">
        @error('name')
            {{ $message }}
        @enderror
        </div>
        <div class="detail__content price__contents">
            <p class="product__price">¥{{ $product['price'] }}</p>
            <p class="product__tax">(税込)</p>
        </div>
        <div class="error">
        @error('price')
            {{ $message }}
        @enderror
        </div>
        <div class="detail__content__info">
            <div class="detail__content__favorite">
                <form action="{{ route('product.like', ['id'=>$product->id]) }}" method="POST">
                    @csrf
                    <button type="submit">
                        <div class="detail__svg
{{ $isLiked ? 'hidden' : 'active' }}" style="background-image: url('{{ asset('storage/images/star_white.svg') }}')">
                        </div>
                        <div class="detail__svg
{{ $isLiked ? 'active' : 'hidden' }}" style="background-image: url('{{ asset('storage/images/star_black.svg') }}')">
                        </div>

                    </button>
                </form>
                <p class="like__count">{{ $likeCount }}</p>
            </div>
            <div class="detail__content__comment">
                <div class="detail__svg"style="background-image: url('{{ asset('storage/images/comment.svg') }}')">
                </div>
                <p>{{ $commentCount }}</p>

            </div>
        </div>
    <form class="purchase-form" action="{{ route('product.purchase', ['id'=>$product->id]) }}" method="get">
        <div class="detail-form__button">
            <button class="form__button-submit 
            <?php
            if ($product['is_sold_out'] == '1') {
            echo 'sold__out';
            }
            ?>" type="submit" 
            <?php
            if ($product['is_sold_out'] == '1') {
            echo 'disabled';
            }
            ?>>
            購入手続きへ</button>
        </div>
    </form>
        <div class="detail__content">
            <h2>商品説明</h2>
            <p name="description" class="p-content">{{ $product['description'] }}</p>
        </div>
        <div class="error">
        @error('description')
            {{ $message }}
        @enderror
        </div>
        <div class="detail__content">
            <h2>商品の情報</h2>
            <div class="detail__content__category">
                <span class="detail__title">カテゴリー</span>
                <div class="category__contents">
                    @foreach ($product->categories as $category)
                    <label class="category__content">
                        <p>{{$category->name}}</p>
                    </label>
                    @endforeach
                </div>
                <div class="error">
                @error('category_id')
                    {{ $message }}
                @enderror
                </div>
            </div>
            <div class="detail__content__condition">
            <span class="detail__title">商品の状態</span>
                    <p>
                    <?php
                        if ($product['condition_id'] == '1') {
                        echo '良好';
                        } else if ($product['condition_id'] == '2') {
                        echo '目立った傷や汚れなし';
                        }  else if ($product['condition_id'] == '3') {
                        echo 'やや傷や汚れあり';
                        } else if ($product['condition_id'] == '4') {
                        echo '状態が悪い';
                        }
                        ?>
                    </p>
                <div class="error">
                @error('condition_id')
                    {{ $message }}
                @enderror
                </div>
        </div>
        <div class="detail__comment">
            <h2>コメント</h2>
            @foreach ($comments as $comment)
            <label class="comment__content">
                <figure class="comment__profile-figure">
                    <img src="{{ asset('storage/images/'. $comment->image) }}" alt="">
                </figure>
                <div class="comment__profile__name">
                    <p>{{ $comment->name }}</p>
                </div>
            </label>
            <div class="comment__comment">
                <p>{{$comment->comment}}</p>
            </div>
            @endforeach
            <div>
            <form class="comment-form" action="{{ route('product.comment', ['id'=>$product->id])}}" method="post">
            @csrf
            <span>商品へのコメント</span>
            <textarea name="comment" placeholder="コメントを入力" value="{{ old('comment') }}" ></textarea>
            <div class="form__error">
            @error('comment')
                {{ $message }}
            @enderror
            </div>
            <button class="form__button-submit" type="submit">コメントを送信する</button>
        </form>
    </div>
    </div>
</div>
@endsection