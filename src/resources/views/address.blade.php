@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/setup.css')}}">
@endsection

@section('main')
<div class="main-container">
    <h1 class="main-ttl">住所の変更</h1>
    <form action="{{ route('purchase.updateAddress', ['item' => $item->id]) }}" method="post" >
    @csrf
        <div class="input-container">
            <label class="input-container__label" for="postal_code">郵便番号</label>
            <input class="input-container__input" type="text" name="postal_code" value="{{ old('postal_code', $postalCode) }}">
            @error('postal_code')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <div class="input-container">
            <label class="input-container__label" for="address">住所</label>
            <input class="input-container__input" type="text" name="address" value="{{ old('address', $address) }}">
            @error('address')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <div class="input-container">
            <label class="input-container__label" for="building_name">建物名</label>
            <input class="input-container__input" type="text" name="building_name" value="{{ old('building_name', $buildingName) }}">
            @error('building_name')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <div class="btn-container">
            <input type="submit" value="更新する">
      </div>
    </form>
</div>



@endsection