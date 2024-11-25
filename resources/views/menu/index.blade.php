<!-- メニュー画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メニュー</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- jQueryの読み込み -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto bg-white min-h-screen">
        <!-- ナビゲーションヘッダー -->
        <header class="px-4 py-3 border-b">
            <div class="flex items-center">
                <button class="p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <h1 class="ml-2 text-lg font-semibold">中央駅南口店で受け取り</h1>
            </div>
        </header>

        <!-- メニューグリッド -->
        <div class="grid grid-cols-2 gap-4 p-4">
            @foreach($menuItems as $item)
            <div class="flex flex-col items-center">
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="w-32 h-32 object-contain">
                <p class="mt-2 text-sm text-center">{{ $item->name }}</p>

                <!-- アイテムをカートに追加するフォーム -->
                <form class="add-to-cart-form" data-item-id="{{ $item->id }}">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <input type="number" name="quantity" value="1" min="1" class="w-12 mt-2 text-center">
                    <button type="submit" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded">カートに追加</button>
                </form>
            </div>
            @endforeach
        </div>



        <!-- カートボタン -->
        <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t">
            <div class="max-w-md mx-auto">
                <a href="{{ route('cart.view') }}" class="w-full bg-yellow-400 text-black py-3 px-6 rounded-md font-medium">
                    カートを確認
                </a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // フォームの送信を非同期で行う
            $('.add-to-cart-form').on('submit', function(event) {
                event.preventDefault(); // フォームの通常送信を防ぐ

                var form = $(this);
                var itemId = form.find('input[name="item_id"]').val();
                var quantity = form.find('input[name="quantity"]').val();

                $.ajax({
                    url: '{{ route('cart.add') }}', // POST先のURL
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRFトークン
                        item_id: itemId,
                        quantity: quantity
                    },
                    success: function(response) {
                        alert('アイテムがカートに追加されました');
                        // 必要に応じてカートのアイコンを更新したりする処理
                    },
                    error: function(xhr, status, error) {
                        alert('カートへの追加に失敗しました');
                    }
                });
            });
        });
    </script>
</body>
</html>
