@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('main')
<div class="profile">
    <div class="profile-image">
        <img src="{{ asset('storage/' . $user->profile_image ?? 'default-profile.png') }}" alt="プロフィール画像">
    </div>
    <div class="profile-info">
        <h2>{{ $user->name }}</h2>
        <a href="{{ route('profile.setup') }}" class="btn btn-outline-primary">プロフィールを編集</a>
    </div>
</div>

    <!-- タブメニュー -->
<div class="nav-tabs">
    <a class="nav-link {{ request('page') === 'sell' || !request('page') ? 'active' : '' }}" href="{{ route('mypage', ['page' => 'sell']) }}">出品した商品</a>
    <a class="nav-link {{ request('page') === 'buy' ? 'active' : '' }}" href="{{ route('mypage', ['page' => 'buy']) }}">購入した商品</a>
</div>

<!-- 商品リスト -->
<div class="item-container">
    <!-- 出品した商品 -->
    @if (request('page') === 'sell' || !request('page'))
        <div class="tab-active" id="sold-items">
            @forelse ($soldItems as $item)
                <div class="item-card">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}">
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
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}">
                    <h3>{{ $item->title }}</h3>
                </div>
            @empty
                <p>購入した商品はありません。</p>
            @endforelse
        </div>
    @endif
</div>
@endsection
