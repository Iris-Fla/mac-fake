<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class CartController extends Controller
{
    // カートにアイテムを追加
    public function add(Request $request)
    {
        $itemId = $request->input('item_id');
        $quantity = $request->input('quantity', 1);

        // アイテムをデータベースから取得
        $item = MenuItem::findOrFail($itemId);

        // セッションにカートがなければ作成
        if (!session()->has('cart')) {
            session()->put('cart', []);
        }

        // カートにアイテムを追加（アイテムがすでにカートにあれば数量を増加）
        $cart = session()->get('cart');
        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] += $quantity;
        } else {
            $cart[$itemId] = [
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $quantity,
                'image' => $item->image_path
            ];
        }

        // 更新したカートをセッションに保存
        session()->put('cart', $cart);

        // 非同期リクエストなので、JSONレスポンスを返す
        return response()->json([
            'message' => 'アイテムがカートに追加されました',
            'cart' => session('cart') // 更新されたカートの内容も返すことができます
        ]);
    }

    // カートの内容を表示
    public function view()
    {
        $cart = session()->get('cart', []);
        return view('cart.view', compact('cart'));
    }

    // チェックアウトページ（注文確認）
    // public function checkout()
    // {
    //     $cart = session()->get('cart', []);
    //     return view('checkout.index', compact('cart'));
    // }
}
