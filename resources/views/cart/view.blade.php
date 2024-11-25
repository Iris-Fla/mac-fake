<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>カートの確認</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto bg-white min-h-screen">
        <!-- ナビゲーションヘッダー -->
        <header class="px-4 py-3 border-b">
            <div class="flex items-center">
                <a href="{{ url()->previous() }}" class="p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="ml-2 text-lg font-semibold">カートの中身</h1>
            </div>
        </header>

        <!-- カートの内容 -->
        <div class="p-4" id="cart-items">
            @if(count($cart) > 0)
                @foreach($cart as $itemId => $item)
                    <div class="flex items-center justify-between py-4 border-b" id="cart-item-{{ $itemId }}">
                        <div class="flex items-center flex-1">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-contain">
                            <div class="ml-4">
                                <p class="font-medium">{{ $item['name'] }}</p>
                                <p class="text-sm text-gray-600">数量: {{ $item['quantity'] }}</p>
                                <p class="text-sm font-medium">¥{{ number_format($item['price']) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center ml-4">
                            <p class="font-medium mr-4">¥{{ number_format($item['price'] * $item['quantity']) }}</p>
                            <button 
                                class="delete-item-btn text-red-500 hover:text-red-700 p-2"
                                data-item-id="{{ $itemId }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach

                <!-- 合計金額 -->
                <div class="mt-6 px-4" id="cart-total">
                    <div class="flex justify-between items-center text-lg font-semibold">
                        <span>合計金額:</span>
                        <span>¥{{ number_format(array_sum(array_map(function($item) {
                            return $item['price'] * $item['quantity'];
                        }, $cart))) }}</span>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-600">カートにはアイテムがありません。</p>
                    <a href="{{ url()->previous() }}" class="mt-4 inline-block text-blue-500">メニューに戻る</a>
                </div>
            @endif
        </div>

        <!-- 注文ボタン -->
        @if(count($cart) > 0)
            <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t">
                <div class="max-w-md mx-auto">
                    <button class="w-full bg-yellow-400 text-black py-3 px-6 rounded-md font-medium">
                        注文する
                    </button>
                </div>
            </div>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // 削除ボタンのクリックイベント
            $('.delete-item-btn').on('click', function() {
                const itemId = $(this).data('item-id');
                const itemElement = $(`#cart-item-${itemId}`);

                if (confirm('この商品をカートから削除してもよろしいですか？')) {
                    $.ajax({
                        url: `/cart/${itemId}`,
                        method: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                // アイテムを画面から削除
                                itemElement.fadeOut(300, function() {
                                    $(this).remove();
                                    
                                    // カートが空になった場合
                                    if ($('[id^="cart-item-"]').length === 0) {
                                        $('#cart-items').html(`
                                            <div class="text-center py-8">
                                                <p class="text-gray-600">カートにはアイテムがありません。</p>
                                                <a href="{{ url()->previous() }}" class="mt-4 inline-block text-blue-500">メニューに戻る</a>
                                            </div>
                                        `);
                                        $('.fixed.bottom-0').remove(); // 注文ボタンを削除
                                    } else {
                                        // 合計金額を更新
                                        $('#cart-total').html(`
                                            <div class="flex justify-between items-center text-lg font-semibold">
                                                <span>合計金額:</span>
                                                <span>¥${new Intl.NumberFormat('ja-JP').format(response.total)}</span>
                                            </div>
                                        `);
                                    }
                                });
                            } else {
                                alert('削除に失敗しました');
                            }
                        },
                        error: function() {
                            alert('削除中にエラーが発生しました');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>