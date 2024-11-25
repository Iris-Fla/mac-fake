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

    // カートからアイテムを削除
    public function remove(Request $request, $itemId)
    {
        try {
            $cart = session()->get('cart', []);

            // カートに指定されたアイテムが存在するか確認
            if (!isset($cart[$itemId])) {
                return response()->json([
                    'success' => false,
                    'message' => '指定されたアイテムが見つかりません'
                ], 404);
            }

            // カートからアイテムを削除
            unset($cart[$itemId]);
            // 更新したカートをセッションに保存
            session()->put('cart', $cart);

            // カートの合計金額を計算
            $total = array_sum(array_map(function($item) {
                return $item['price'] * $item['quantity'];
            }, $cart));

            return response()->json([
                'success' => true,
                'message' => 'アイテムがカートから削除されました',
                'cart' => $cart,
                'total' => $total
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'アイテムの削除中にエラーが発生しました'
            ], 500);
        }
    }
    public function del(Request $request, $itemId) {

    }

    // チェックアウトページ（注文確認）
    // public function checkout()
    // {
    //     $cart = session()->get('cart', []);
    //     return view('checkout.index', compact('cart'));
    // }
}