@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('main')

@php
    $firstOrder = $item->orders->first();
    $buyerId = $firstOrder ? $firstOrder->user_id : null;
    $isBuyer = $buyerId === auth()->id();
    $isSeller = $item->user_id === auth()->id();

    $otherUser = $isBuyer ? $item->user : ($firstOrder ? $firstOrder->user : null);

    $alreadyEvaluated = \App\Models\Evaluation::where('item_id', $item->id)
        ->where('evaluator_id', auth()->id())
        ->exists();

    $buyerEvaluated = \App\Models\Evaluation::where('item_id', $item->id)
        ->where('evaluator_id', $buyerId)
        ->exists();
@endphp


<div class="trade-container">
    <div class="sidebar">
        <h3>その他の取引</h3>
        @foreach ($otherTradingItems as $otherItem)
            <a class="item-button" href="{{ route('trade.show', $otherItem) }}">
                {{ $otherItem->title }}
            </a>
        @endforeach
    </div>

    <div class="chat-container">
        <!-- 取引完了ボタン（右上） -->
        @if ($isBuyer)
            <form action="{{ route('trade.complete', $item) }}" method="POST" class="complete-button">
            @csrf
            <button type="submit">取引を完了する</button>
            </form>
        @endif


        <!-- 上部 商品情報 -->
        <div class="top-bar">
            <div class="top-user">
                <img class="top-user-icon" src="{{ asset('storage/' . ($otherUser->profile_image ?? 'default-profile.png')) }}" alt="アイコン">
                <h2>「{{ $otherUser->name ?? '取引相手' }}」 さんとの取引画面</h2>
            </div>
        </div>



        <div class="item-summary">
            <img src="{{ Str::startsWith($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path ?? 'default-image.png') }}" alt="商品画像">
            <div class="item-summary__character">
                <h3>{{ $item->title }}</h3>
                <p>{{ $item->price }}円</p>
            </div>
        </div>

        <!-- メッセージ一覧 -->
        @if ($errors->any())
            <div class="alert alert-danger" style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="chat-messages">
            @foreach ($messages as $msg)
                <div class="message-box {{ $msg->user_id === auth()->id() ? 'message-right' : 'message-left' }}">
                    <div class="message-header">
                        @if ($msg->user_id === auth()->id())
                            <strong>{{ $msg->user->name }}</strong>
                            <img src="{{ asset('storage/' . ($msg->user->profile_image ?? 'default-profile.png')) }}" alt="アイコン">
                        @else
                            <img src="{{ asset('storage/' . ($msg->user->profile_image ?? 'default-profile.png')) }}" alt="アイコン">
                            <strong>{{ $msg->user->name }}</strong>
                        @endif
                    </div>

                    <div class="message-bubble">
                        {{-- 通常メッセージ表示 --}}
                        <div class="message-content" id="message-content-{{ $msg->id }}">
                            {{ $msg->message }}
                            @if ($msg->image_path)
                                <div><img src="{{ asset('storage/' . $msg->image_path) }}" width="100"></div>
                            @endif
                        </div>

                        {{-- 編集フォーム（初期状態は非表示） --}}
                        @if ($msg->user_id === auth()->id())
                            <form action="{{ route('trade.message.update', $msg) }}" method="POST" class="edit-form" id="edit-form-{{ $msg->id }}">
                                @csrf
                                <input type="text" name="message" value="{{ $msg->message }}">
                                <button type="submit">保存</button>
                                <button type="button" onclick="cancelEdit({{ $msg->id }})">キャンセル</button>
                            </form>
                        @endif

                        {{-- 編集・削除ボタン --}}
                        @if ($msg->user_id === auth()->id())
                            <div class="actions">
                                <button type="button" onclick="toggleEdit({{ $msg->id }})">編集</button>

                                <form action="{{ route('trade.message.destroy', $msg) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    <!-- メッセージ投稿フォーム -->
        <!-- メッセージ投稿フォーム -->
        <form action="{{ route('trade.message', $item) }}" method="POST" enctype="multipart/form-data" class="chat-input">
            @csrf
            <textarea id="chat-message" name="message" placeholder="取引メッセージを記入してください"></textarea>

            <!-- 画像追加ボタン -->
            <label for="image" class="image-button">画像を追加</label>
            <input type="file" id="image" name="image">

            <!-- 送信ボタン（紙飛行機アイコン） -->
            <button type="submit" class="send-button" >
                <img src="{{ asset('storage/plane-icon.jpg') }}" alt="送信" />
            </button>
        </form>

        {{-- 購入者の評価フォーム --}}
        @if ($item->status === 'sold' && $isBuyer && !$alreadyEvaluated)
            <div class="evaluation-box">
                <h3 class="evaluation-title">取引が完了しました。</h3>
                <form action="{{ route('trade.evaluate', $item) }}" method="POST">
                    @csrf
                    <p class="evaluation-subtitle">今回の取引相手はどうでしたか？</p>
                    <div class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <input type="radio" id="star{{ $i }}" name="score" value="{{ $i }}">
                            <label for="star{{ $i }}">★</label>
                        @endfor
                    </div>
                    <button type="submit" class="submit-btn">送信する</button>
                </form>
            </div>
        @endif

        {{-- 出品者の評価フォーム（購入者が評価済みなら） --}}
        @if ($item->status === 'sold' && $isSeller && $buyerEvaluated && !$alreadyEvaluated)
            <div class="evaluation-box">
                <h3 class="evaluation-title">取引が完了しました。</h3>
                <form action="{{ route('trade.evaluate', $item) }}" method="POST">
                    @csrf
                    <p class="evaluation-subtitle">今回の取引相手はどうでしたか？</p>
                    <div class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <input type="radio" id="star{{ $i }}" name="score" value="{{ $i }}">
                            <label for="star{{ $i }}">★</label>
                        @endfor
                    </div>
                    <button type="submit" class="submit-btn">送信する</button>
                </form>
            </div>
        @endif
    </div>
</div>

<script>
function toggleEdit(id) {
    document.getElementById('edit-form-' + id).classList.add('active');
    document.getElementById('message-content-' + id).style.display = 'none';
}

function cancelEdit(id) {
    document.getElementById('edit-form-' + id).classList.remove('active');
    document.getElementById('message-content-' + id).style.display = 'block';
}

// 入力値をローカルストレージに保存
const textarea = document.getElementById('chat-message');
const storageKey = 'chat-draft-{{ $item->id }}';

textarea.value = localStorage.getItem(storageKey) || '';

textarea.addEventListener('input', () => {
    localStorage.setItem(storageKey, textarea.value);
});

// 送信時に削除（成功時だけならサーバー側でリダイレクト時に対処）
document.querySelector('form.chat-input').addEventListener('submit', () => {
    localStorage.removeItem(storageKey);
});
</script>

@endsection
