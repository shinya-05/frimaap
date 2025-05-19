@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('main')

@php
    $score = $user->average_score;
@endphp


<div class="profile">
    <div class="profile-image">
        <img src="{{ asset('storage/' . $user->profile_image ?? 'default-profile.png') }}" alt="プロフィール画像">
    </div>
    <div class="profile-info">
        <h2>{{ $user->name }}</h2>
        <div class="user-rating">
            @for ($i = 1; $i <= 5; $i++)
                @if ($score >= $i)
                    <span class="star filled">★</span>
                @elseif ($score > $i - 1)
                    <span class="star filled-half">★</span>
                @else
                    <span class="star">★</span>
                @endif
            @endfor
        </div>
    </div>
    <div class="edit-button">
        <a href="{{ route('profile.setup') }}" class="btn btn-outline-primary">プロフィールを編集</a>
    </div>
</div>

    <!-- タブメニュー -->
<div class="nav-tabs">
    <a class="nav-link {{ request('page') === 'sell' || !request('page') ? 'active' : '' }}" href="{{ route('mypage', ['page' => 'sell']) }}">出品した商品</a>
    <a class="nav-link {{ request('page') === 'buy' ? 'active' : '' }}" href="{{ route('mypage', ['page' => 'buy']) }}">購入した商品</a>
    <a class="nav-link {{ request('page') === 'trading' ? 'active' : '' }}" href="{{ route('mypage', ['page' => 'trading']) }}">
    取引中の商品
    @if ($tradingItems->sum(fn($item) => $item->messages->count()) > 0)
        <span class="tab-badge">
            {{ $tradingItems->sum(fn($item) => $item->messages->count()) }}
        </span>
    @endif
</a>

</div>

<!-- 商品リスト -->
<div class="item-container">
    <!-- 出品した商品 -->
    @if (request('page') === 'sell' || !request('page'))
        <div class="tab-active" id="sold-items">
            @forelse ($soldItems as $item)
                <div class="item-card">
                    <img src="{{ Str::startsWith($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path ?? 'default-image.png') }}" alt="商品画像">
                    <h3>{{ $item->title }}</h3>
                </div>
            @empty
                <p>出品した商品はありません。</p>
            @endforelse
        </div>
    @endif

    <!-- 購入した商品 -->
    @if (request('page') === 'buy')
        <div class="tab-active" id="purchased-items">
            @forelse ($purchasedItems as $item)
                <div class="item-card">
                    <img src="{{ Str::startsWith($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path ?? 'default-image.png') }}" alt="商品画像">
                    <h3>{{ $item->title }}</h3>
                </div>
            @empty
                <p>購入した商品はありません。</p>
            @endforelse
        </div>
    @endif

    <!-- 取引中の商品 -->
    @if (request('page') === 'trading')
        <div class="tab-active" id="trading-items">
            @forelse ($tradingItems as $item)
                <div class="item-card" style="position: relative;">
                    <a href="{{ route('trade.show', $item) }}">
                        <div style="position: relative;">
                            <img src="{{ Str::startsWith($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path ?? 'default-image.png') }}" alt="商品画像">

                            @if ($item->messages->count() > 0)
                                <span class="message-badge">{{ $item->messages->count() }}</span>
                            @endif
                        </div>
                        <h3>{{ $item->title }}</h3>
                    </a>
                </div>
            @empty
                <p>取引中の商品はありません。</p>
            @endforelse
        </div>
        @endif
</div>
@endsection
