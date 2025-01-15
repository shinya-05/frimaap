<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PurchaseController extends Controller
{
    public function index(Item $item)
    {
        $order = Order::where('user_id', Auth::id())
        ->where('item_id', $item->id)
        ->first();

        // 初期値を `Order` テーブルのデータから取得し、なければユーザー情報を使用
        $address = $order->shipping_address ?? Auth::user()->address ?? '未登録';
        $postalCode = $order->postal_code ?? Auth::user()->postal_code ?? '未登録';
        $buildingName = $order->building_name ?? Auth::user()->building_name ?? '未登録';

        return view('purchase', compact('item', 'address', 'postalCode', 'buildingName'));
    }


   public function store(Request $request, Item $item)
    {
        // Stripeの秘密キーを設定
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // Stripe Checkout Sessionを作成
        $checkoutSession = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->title,
                    ],
                    'unit_amount' => $item->price * 1, // 金額（最小単位）
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', ['item' => $item->id]),
            'cancel_url' => route('purchase.index', ['item' => $item->id]),
        ]);

        // Stripeの決済画面にリダイレクト
        return redirect($checkoutSession->url);
    }

    public function success(Request $request, Item $item)
    {
        // 注文情報を保存
        Order::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'item_id' => $item->id,
            ],
            [
                'payment_method' => $request->input('payment_method'),
                'shipping_address' => $request->input('shipping_address', Auth::user()->address),
                'postal_code' => $request->input('postal_code', Auth::user()->postal_code),
                'building_name' => $request->input('building_name', Auth::user()->building_name),
            ]
        );

        // 商品のステータスを「sold」に更新
        $item->update(['status' => 'sold']);

        return redirect()->route('home');
    }

    public function editAddress(Item $item)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('item_id', $item->id)
            ->first();

        $address = $order->shipping_address ?? Auth::user()->address ?? '';
        $postalCode = $order->postal_code ?? Auth::user()->postal_code ?? '';
        $buildingName = $order->building_name ?? Auth::user()->building_name ?? '';

        return view('address', compact('item', 'address', 'postalCode', 'buildingName'));
    }

    public function updateAddress(Request $request, Item $item)
    {
        Order::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'item_id' => $item->id,
            ],
            [
                'postal_code' => $request->input('postal_code'),
                'shipping_address' => $request->input('address'),
                'building_name' => $request->input('building_name'),
            ]
        );

        return redirect()->route('purchase.index', ['item' => $item->id]);
    }
}
