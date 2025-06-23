@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit_address.css') }}">
@endsection

@section('content')
<div class="edit__address__content">
    <div class="edit__header">
        <h2>住所の変更</h2>
    </div>
    <form class="edit_address-form" action="{{ route('product.purchase', ['id'=>$product->id]) }}" method="post">
                @csrf
        <div class="edit-form__contents">
            <div class="edit-form__content">
                <input type="hidden" name="id" value="{{ $product['id'] }}"/>
                <div class="edit-form__content">
                    <span>郵便番号</span>
                    <input type="text" name="post_code" value=""/>
                <div class="form__error">
                    @error('post_code')
                        {{ $message }}
                    @enderror
                </div>
                </div>
            </div>
            <div class="edit-form__content">
                <span>住所</span>
                <input type="text" name="address" value=""/>
                <div class="form__error">
                    @error('address')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="edit-form__content">
                <span>建物名</span>
                <input type="text" name="building" value=""/>
                <div class="form__error">
                    @error('building')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
    <button class="form__button-submit" type="submit">更新する</button>
    </form>
</div>
@endsection