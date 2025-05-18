<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\TradeMessage;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EvaluationReceived;
use App\Http\Requests\StoreTradeMessageRequest;


class TradeController extends Controller
{
    public function show(Item $item)
    {
        $messages = TradeMessage::where('item_id', $item->id)
            ->with('user')
            ->orderBy('created_at')
            ->get();

        // ✅ 未読→既読に変更
        TradeMessage::where('item_id', $item->id)
            ->where('user_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $otherTradingItems = Item::where('status', 'trading')
            ->where(function ($query) use ($item) {
                $query->where('user_id', auth()->id())
                    ->orWhereHas('orders', function ($q) {
                        $q->where('user_id', auth()->id());
                    });
            })
            ->where('id', '!=', $item->id)
            ->get();

        return view('trade.chat', compact('item', 'messages', 'otherTradingItems'));
    }

    public function storeMessage(StoreTradeMessageRequest $request, Item $item)
    {
        $data = [
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('chat_images', 'public');
        }

        TradeMessage::create($data);

        return back();
    }

    public function complete(Item $item)
    {
        $item->status = 'sold';
        $item->save();

        // ✅ 評価フォームが表示されるよう、再びチャット画面に戻す
        return redirect()->route('trade.show', $item)->with('success', '取引が完了しました。');
}


    public function update(Request $request, TradeMessage $message)
    {
        $this->authorize('update', $message); // ユーザー自身かチェック
        $message->update(['message' => $request->message]);
        return back()->with('success', 'メッセージを更新しました。');
    }

    public function destroy(TradeMessage $message)
    {
        $this->authorize('delete', $message); // ユーザー自身かチェック
        $message->delete();
        return back()->with('success', 'メッセージを削除しました。');
    }

    public function storeEvaluation(Request $request, Item $item)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $evaluatorId = auth()->id();
        $itemOwnerId = $item->user_id;
        $firstOrder = $item->orders->first();
        $buyerId = $firstOrder ? $firstOrder->user_id : null;

        $evaluatedId = $evaluatorId === $buyerId ? $itemOwnerId : $buyerId;

        $already = Evaluation::where('item_id', $item->id)
            ->where('evaluator_id', $evaluatorId)
            ->exists();

        if ($already) {
            return redirect()->route('trade.show', $item)->with('error', 'すでに評価済みです。');
    }

        $evaluation = Evaluation::create([
            'item_id' => $item->id,
            'evaluator_id' => $evaluatorId,
            'evaluated_id' => $evaluatedId,
            'score' => $request->score,
            'comment' => $request->comment,
        ]);

    // ✅ 正しい相手にメールを送信
        if ($evaluation->evaluatedUser && $evaluation->evaluatedUser->email) {
        Mail::to($evaluation->evaluatedUser->email)->send(new EvaluationReceived($evaluation));
        }

        return redirect()->route('home')->with('success', '評価を送信しました！');
    }


}
