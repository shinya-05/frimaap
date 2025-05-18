<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user()->load('evaluationsReceived'); // ← これで評価データも取得される

        $soldItems = $user->items; // 出品した商品
        $purchasedItems = $user->orders()->with('item')->get()->pluck('item'); // 購入した商品

        // ✅ 取引中（出品側）
        $tradingSoldItems = $user->items()
            ->where(function ($query) {
                $query->where('status', 'trading')
                    ->orWhere(function ($q) {
                        $q->where('status', 'sold')
                            ->whereDoesntHave('evaluations', function ($subQuery) {
                                $subQuery->where('evaluator_id', Auth::id());
                            });
                    });
            })
            ->get();

        // ✅ 取引中（購入側）
        $tradingPurchasedItems = $user->orders()
            ->with('item')
            ->whereHas('item', function($query) {
                $query->where('status', 'trading');
            })
            ->get()
            ->pluck('item');

        // ✅ 取引中すべてを統合・未読メッセージ付きで読み込み
        $tradingItems = $tradingSoldItems
            ->merge($tradingPurchasedItems)
            ->load(['messages' => function ($query) {
                $query->where('is_read', false)
                    ->where('user_id', '!=', Auth::id());
            }])
            ->filter(function ($item) {
                $evaluatedUserIds = $item->evaluations->pluck('evaluator_id');
                return $evaluatedUserIds->contains(Auth::id()) === false;
            })
            ->sortByDesc(function ($item) {
                return $item->messages->count();
            });

        return view('mypage', compact('user', 'soldItems', 'purchasedItems', 'tradingItems'));
    }

}
