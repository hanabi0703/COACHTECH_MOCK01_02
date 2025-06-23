@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/js/preview.js') }}"></script>
    <script src="{{ asset('/js/category_switch.js') }}"></script>
@endsection

@section('content')
<div class="sell__content">
    <div class="sell__header">
        <h2>商品の出品</h2>
    </div>
    <form class="sell-form" action="/sell" method="post" enctype="multipart/form-data">
        @csrf
    <div class="sell__contents">
        <input type="hidden" name="id" value=""/>
        <span class="sell-form__title">商品画像</span>
        <div class="sell-figure">
            <figure id="figure" style="display:none" class="sell-input__preview">
                <img id="figureImage">
            </figure>
            <figure id="existfigure" class="sell-input__exist">
            </figure>
            <label class="sell-input-label">
                画像を選択する
            <input id="input" type="file" name="image" value=""/>
            </label>
            <div class="form__error">
                @error('image')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="sell-form__section">
            <div class="sell-form__content">
                <h3>商品の詳細</h3>
                <span class="sell-form__title">カテゴリー</span>
                <div class="sell__content__categories">
                    @foreach ($categories as $category)
                    <label class="category__content category-input__parent">
                        <input class="category-input" type="checkbox" name="category_ids[]" value="{{$category->id}}"/>
                    {{$category->name}}
                    </label>
                    @endforeach
                </div>
                <div class="form__error">
                    @error('category_ids')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="sell-form__content">
                <span class="sell-form__title">商品の状態</span>
                <select class="sell-form__category" name="condition_id">
                <option value="">選択してください</option>
                @foreach ($conditions as $condition)
                <option value="{{ $condition['id'] }}">{{ $condition['name'] }}</option>
                @endforeach
                </select>
                <div class="form__error">
                    @error('condition_id')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="sell-form__section">
            <div class="sell-form__content input__box">
                <h3>商品名と説明</h3>
                <span class="sell-form__title">商品名</span>
                <input type="text" name="name" value="{{ old('name') }}"/>
                <div class="form__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="sell-form__content input__box">
                <span class="sell-form__title">商品の説明</span>
                <textarea name="description" class="textarea-content">{{ old('description') }}</textarea>
                <div class="form__error">
                    @error('description')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="sell-form__content">
                <span class="sell-form__title input__box">販売価格</span>
                <div class="sell-form-input__box">
                    <div class="yen__svg" style="background-image: url('{{ asset('storage/images/yen.svg') }}')">
                    </div>
                    <input class="sell-form__price" type="text" name="price" value="{{ old('price') }}"/>
                </div>
                <div class="form__error">
                    @error('price')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
    </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">出品する</button>
        </div>
    </form>
</div>
@endsection