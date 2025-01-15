@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css')}}">
@endsection

@section('main')
<div class="main-container">
    <!-- バリデーションエラーの表示 -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="main-ttl">商品の出品</h2>
    <form action="/sell" method="post" enctype="multipart/form-data">
        @csrf
        <div class="input-container">
            <label for="product_image">商品画像</label>
            <div class="image-upload-box">
                <img id="preview" src="#" alt="画像プレビュー" style="display: none;">
                <input type="file" id="product_image" name="product_image" accept="image/*">
                <span class="image-upload-button">画像を選択する</span>
            </div>
            @error('image_path')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="input-container">
            <h2>商品の詳細</h2>

            <!-- カテゴリー -->
            <label for="category">カテゴリー</label>
            <div class="category-tags">
                @foreach ($categories as $category)
                    <label>
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        <span>{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('categories')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <!-- 商品の状態 -->
            <label for="condition">商品の状態</label>
            <select class="condition" id="condition" name="condition" required>
                <option value="" disabled selected>選択してください</option>
                @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition') == $condition->id ? 'selected' : '' }}>
                        {{ $condition->name }}
                    </option>
                @endforeach
            </select>
            @error('condition')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>


        <div class="input-container">
            <h2>商品名と説明</h2>

            <label class="input-container__label" for="title">商品名</label>
            <input class="input-container__input" type="text" name="title" value="{{ old('title') }}">
            @error('title')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <label class="input-container__label" for="brand">ブランド名</label>
            <input class="input-container__input" type="text" name="brand" value="{{ old('brand') }}">
            @error('brand')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <label class="input-container__label" for="description">商品の説明</label>
            <textarea class="input-container__input" name="description"  rows="4" value="{{ old('description') }}"></textarea>
            @error('description')
                <p class="error-message">{{ $message }}</p>
            @enderror


            <label class="input-container__label" for="price">販売価格</label>
            <div class="price-input">
                <span class="currency-symbol">¥</span>
                <input type="number" name="price" min="0" value="{{ old('price') }}">
            </div>
            @error('price')
                <p class="error-message">{{ $message }}</p>
            @enderror

        <div class="btn-container">
            <input type="submit" value="出品する">
        </div>
    </form>
</div>

<script>
    document.getElementById('product_image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // プレビューを表示
            };

            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none'; // プレビューを非表示
        }
    });
</script>

@endsection
