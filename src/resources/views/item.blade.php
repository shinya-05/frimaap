@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('main')
<div class="purchase-page">
    <!-- 商品のメインセクション -->
    <div class="product-main">
        <!-- 商品画像 -->
        <div class="product-image">
            <img src="{{ Str::startsWith($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path ?? 'default-image.png') }}" alt="商品画像">
        </div>

        <!-- 商品情報 -->
        <div class="product-details">
            <h1 class="product-title">{{ $item->title }}</h1>
            <p class="product-brand">{{ $item->brand }}</p>
            <p class="product-price">¥{{ number_format($item->price) }}（税込）</p>

            <!-- お気に入りとコメント -->
            <div class="product-actions">
                <div class="favorites">
                    <span class="favorite-toggle {{ Auth::check() && $item->favoritedBy->contains(Auth::id()) ? 'favorited' : '' }}"
                    data-item-id="{{ $item->id }}">★</span>
                    <span class="favorites-count">{{ $item->favoritedBy->count() }}</span>
                </div>
                <div class="comments">
                    <span>💬{{ $comments->count() }}</span>
                </div>
            </div>

            <!-- 購入ボタン -->
            <div class="purchase-button">
                @if ($item->status === 'sale')
                    <form action="{{ route('purchase.index', ['item' => $item->id]) }}" method="GET" >
                        <button>購入手続きへ</button>
                    </form>
                @else
                    <div class="sold-message">
                        <p>この商品は既に購入されています</p>
                    </div>
                @endif

            </div>

            <!-- 商品説明 -->
            <div class="product-description">
                <h3>商品説明</h3>
                <p>{{ $item->description }}</p>
            </div>

            <!-- 商品の情報 -->
            <div class="product-info">
                <h2>商品の情報</h2>
                <div class="info-row">
                    <p>カテゴリー</p>
                    <div class="category-tags">
                        @foreach ($item->categories as $category)
                        <span class="tag">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="info-row">
                    <p>商品の状態</p>
                    <span class="condition">{{ $item->condition->name }}</span>
                </div>
            </div>


            <!-- コメントセクション -->
            <div class="comment-section">
                <h3>コメント ({{ $comments->count() }})</h3>

                <!-- コメント一覧 -->
                <div class="comment-list">
                    @foreach ($comments as $comment)
                    <div class="comment">
                        <div class="comment-user">
                            <img src="{{ asset('storage/' . $comment->user->profile_image ?? 'default-profile.png') }}" alt="プロフィール画像">
                            <p>{{ $comment->user->name }}</p>
                        </div>
                        <div class="comment-content">
                            {{ $comment->content }}
                        </div>
                    </div>
                    @endforeach
                </div>

        <!-- コメント投稿フォーム -->
                <div class="comment-form">
                    <p class="comment-form__title">商品へのコメント</p>
                    <form action="{{ route('comment', $item->id) }}" method="POST" >
                        @csrf
                        <textarea name="content" class="comment-form__textarea"></textarea>
                        @error('content')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="comment-form__btn">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.favorite-toggle').forEach(function(element) {
        element.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            const url = `/item/${itemId}/favorite`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.isFavorited) {
                    this.classList.add('favorited');
                } else {
                    this.classList.remove('favorited');
                }
                this.nextElementSibling.textContent = data.favoritesCount;
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>

@endsection
