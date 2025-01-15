@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('main')
<div class="nav-tabs">
    <!-- 「おすすめ」のリンク -->
    <a href="{{ route('home', ['page' => 'home', 'search' => request('search')]) }}" 
       class="nav-link {{ request('page') === 'home' || !request('page') ? 'active' : '' }}">おすすめ</a>

    <!-- 「マイリスト」のリンク -->
    <a href="{{ route('home', ['page' => 'mylist', 'search' => request('search')]) }}" 
       class="nav-link {{ request('page') === 'mylist' ? 'active' : '' }}">マイリスト</a>
</div>

<div class="search-results">
    @if(request('search'))
        <p>「{{ request('search') }}」の検索結果</p>
    @endif
</div>

<div class="item-container">
    @foreach ($items as $item)
        <div class="item-card">
            <a href="{{ route('show', ['id' => $item->id]) }}">
                <img src="{{ Str::startsWith($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}">
                @if ($item->status === 'sold')
                    <div class="sold-overlay">sold</div>
                @endif
                <h3>{{ $item->title }}</h3>
            </a>
        </div>
    @endforeach
</div>


@endsection