<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\CommentRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
{
    // クエリパラメータ "page" を取得
    $page = $request->input('page', 'home'); // デフォルトは "home"

    // 初期クエリを作成
    $query = Item::query();

    // マイリストの場合
    if ($page === 'mylist' && Auth::check()) {
        $query->whereHas('favoritedBy', function ($q) {
            $q->where('user_id', Auth::id());
        });
    }

    // 検索キーワードがある場合
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->input('search') . '%');
    }

    // 商品を取得
    $items = $query->latest()->get();

    // ビューにデータを渡す
    return view('index', compact('items'));
}



    //コメント処理
    public function comment(CommentRequest $request, Item $item)
    {
        Comment::create([
        'user_id' => Auth::id(),
        'item_id' => $item->id,
        'content' => $request->input('content'),
        ]);

        return redirect()->route('show', $item->id);
        //ルートモデルバインディング により、{item} の値が Item モデルを使って自動的に $item に渡される。
    }

    //お気に入り機能
    public function toggleFavorite(Request $request, Item $item)
    {
        $user = Auth::user();

        if ($user->favorites()->where('item_id', $item->id)->exists()) {
            //中間テーブルで商品IDが存在するか確認
            $user->favorites()->detach($item->id);
            //お気に入り解除
            $isFavorited = false;
        } else {
            $user->favorites()->attach($item->id);
            //お気に入り追加
            $isFavorited = true;
        }

        return response()->json(['isFavorited' => $isFavorited, 'favoritesCount' => $item->favoritedBy()->count()]);
    }

    //商品詳細画面表示
    public function show($id)  //$idはルートから渡されるパラメータ
    {
        $item = Item::with('categories', 'condition')->findOrFail($id);
        //itemsテーブルからIDが一致するか確認
        $comments = Comment::where('item_id', $id)->with('user')->get();
        //idが一致するか確認、ユーザーも

        return view('item', compact('item', 'comments'));
    }

    //出品画面表示
    public function sell()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('sell', compact('categories', 'conditions'));
    }

    //出品処理
    public function store(StoreItemRequest $request)
    {
        $item = Item::create([
            'user_id' => Auth::id(),
            'condition_id' => $request->input('condition'),
            'title' => $request->input('title'),
            'brand' => $request->input('brand'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'status' => 'sale',
        ]);

        $item->categories()->attach($request->input('categories'));
        //多対多リレーションの中間テーブルにデータを追加

        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('product_images', 'public');
            $item->image_path = $path;
            $item->save();
        }

        return redirect('/');

    }


}
