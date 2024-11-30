@extends('layouts.app')

@section('main')
@if (session('result'))
<div class="flash_message">
  {{ session('result') }}
</div>
@endif
<h2 class="main-ttl">プロフィール設定</h2>
<form action="{{ route('profile.complete') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="input-container">
    <input type="file" name="profile_image" id="profile_image" accept="image/*">
    @error('profile_image')
    <p>{{ $message }}</p>
    @enderror
  </div>
  <div class="input-container">
    <input type="text" placeholder="名前" name="name" value="{{ old('name') }}">
    @error('name')
    <p>{{ $message }}</p>
    @enderror
  </div>
  <div class="input-container">
    <input type="text" placeholder="郵便番号" name="postal_code" value="{{ old('postal_code') }}">
    @error('postal_code')
    <p>{{ $message }}</p>
    @enderror
  </div>
  <div class="input-container">
    <input type="text" placeholder="住所" name="address" value="{{ old('address') }}">
    @error('address')
    <p>{{ $message }}</p>
    @enderror
  </div>
  <div class="input-container">
    <input type="text" placeholder="建物名" name="building_name" value="{{ old('building_name') }}">
    @error('building_name')
    <p>{{ $message }}</p>
    @enderror
  </div>
  <div class="btn-container">
    <input type="submit" value="更新する">
  </div>
</form>
<a class="transition-link" href="/login">ログインはこちら</a>
@endsection