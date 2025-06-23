@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit_profile.css') }}">
@endsection
@section('js')
    <script src="{{ asset('/js/preview.js') }}"></script>
@endsection


@section('content')
<div class="edit__profile__content">
    <div class="edit__header">
        <h2>プロフィール設定</h2>
    </div>
    <form class="edit__profile-form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="edit__contents">
            <input type="hidden" name="id" value="{{ $user['id'] }}"/>
            <div class="edit-form__content-img">
                <figure id="existFigure" class="edit__figure-exist">
                    <img src="{{ asset('storage/images/'. $profile->image) }}" alt="">
                </figure>
                <figure id="figure" style="display:none">
                    <img id="figureImage">
                </figure>
                <label class="edit__profile-input-label">
                画像を選択する
                <input id="input" type="file" name="image" value="{{ $profile->image }}"/>
                </label>
                <div class="form__error">
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="edit-form__content">
                <span>ユーザー名</span>
                <input type="text" name="name" value="{{ $profile['name'] }}"/>
                <div class="form__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="edit-form__content">
                <span>郵便番号</span>
                <input type="text" name="post_code" value="{{ $profile['post_code'] }}"/>
                <div class="form__error">
                    @error('post_code')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="edit-form__content">
                <span>住所</span>
                    <input type="text" name="address" value="{{ $profile['address'] }}"/>
                <div class="form__error">
                    @error('address')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="edit-form__content">
                <span>建物名</span>
                    <input type="text" name="building" value="{{ $profile['building'] }}"/>
                <div class="form__error">
                    @error('building')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection