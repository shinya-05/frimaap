@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('main')
<div class="purchase-page">
    <!-- 左側: 商品情報 -->
    <div class="left-column">
        <div class="product-summary">
            <div class="product-summary__img">
                <img src="{{ Str::startsWith($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path ?? 'default-image.png') }}" alt="商品画像">
            </div>
            <div class="product-summary__information">
                <h1 class="product-title">{{ $item->title }}</h1>
                <p class="product-price">¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        <div class="payment-method">
            <h2>支払い方法</h2>
            <form action="{{ route('purchase.store', ['item' => $item->id]) }}" method="POST">
                @csrf
                <select name="payment_method" id="payment-method-select" required>
                    <option value="" disabled selected>選択してください</option>
                    <option value="クレジットカード">クレジットカード</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                </select>
        </div>

        <div class="shipping-info">
            <div class="shipping-info__title">
                <h2>配送先</h2>
                <a href="{{ route('purchase.addressEdit', ['item' => $item->id]) }}" class="change-address">変更する</a>
            </div>
            <p>〒 {{ $postalCode }}</p>
            <p>{{ $address }}</p>
            <p>{{ $buildingName }}</p>
        </div>
    </div>

    <!-- 右側: 注文情報 -->
    <div class="right-column">
        <div class="order-summary">
            <table class="order-summary__table">
                <tr>
                    <th class="order-summary__header">商品代金</th>
                    <td class="order-summary__data">¥{{ number_format($item->price) }}</td>
                </tr>
                <tr>
                    <th class="order-summary__header">支払い方法</th>
                    <td class="order-summary__data">
                        <span id="payment-method-display">選択してください</span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="purchase-button__container">
            <button type="submit" class="purchase-button">購入する</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('payment-method-select').addEventListener('change', function () {
        // 選択した支払い方法を取得
        const selectedPaymentMethod = this.value;
        // 支払い方法を表示するエリアに反映
        document.getElementById('payment-method-display').textContent = selectedPaymentMethod;
    });
</script>

@endsection

