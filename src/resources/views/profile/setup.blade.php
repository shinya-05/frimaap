@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/setup.css')}}">
@endsection

@section('main')
<div class="main-container">
  <h1 class="main-ttl">プロフィール設定</h1>
  <form action="{{ route('profile.complete') }}" method="post" >
  @csrf
    <div class="image-container">
      <div class="profile-image">
        <img id="profile-preview" src="/path/to/default-image.jpg" alt="プロフィール画像">
      </div>
      <label class="profile-image-upload">
        <input type="file" name="profile_image" id="profile-input" style="display: none;" accept="image/*">
                画像を選択する
      </label>
      @error('profile_image')
      <p>{{ $message }}</p>
      @enderror
    </div>
    <div class="input-container">
      <label class="input-container__label" for="name">ユーザー名</label>
      <input class="input-container__input" type="text" name="name" value="{{ old('name', $user->name) }}">
      @error('name')
      <p>{{ $message }}</p>
      @enderror
    </div>
    <div class="input-container">
      <label class="input-container__label" for="postal_code">郵便番号</label>
      <input class="input-container__input" type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
      @error('postal_code')
      <p>{{ $message }}</p>
      @enderror
    </div>
    <div class="input-container">
      <label class="input-container__label" for="address">住所</label>
      <input class="input-container__input" type="text" name="address" value="{{ old('address', $user->address) }}">
      @error('address')
      <p>{{ $message }}</p>
      @enderror
    </div>
    <div class="input-container">
      <label class="input-container__label" for="building_name">建物名</label>
      <input class="input-container__input" type="text" name="building_name" value="{{ old('building_name', $user->building_name) }}">
      @error('building_name')
      <p>{{ $message }}</p>
      @enderror
    </div>
    <div class="btn-container">
      <input type="submit" value="更新する">
    </div>
  </form>
</div>

<script>
    // JavaScript for real-time image preview
    document.getElementById('profile-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection