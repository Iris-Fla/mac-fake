<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カートの確認</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto bg-white min-h-screen">
        <h1 class="text-xl font-semibold px-4 py-3 border-b">カートの中身</h1>
        <div class="p-4">
            @if(count($cart) > 0)
                @foreach($cart as $itemId => $item)
                    <div class="flex items-center justify-between py-2">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-contain">
                        <div class="flex-1 ml-2">
                            <p class="font-medium">{{ $item['name'] }}</p>
                            <p class="text-sm">{{ $item['quantity'] }} x ¥{{ number_format($item['price']) }}</p>
                        </div>
                        <p class="font-medium">¥{{ number_format($item['price'] * $item['quantity']) }}</p>
                    </div>
                    <hr class="my-2">
                @endforeach
                <div class="mt-4 text-lg font-semibold">
                    合計金額: ¥{{ number_format(array_sum(array_map(function($item) {
                        return $item['price'] * $item['quantity'];
                    }, $cart))) }}
                </div>
            @else
                <p>カートにはアイテムがありません。</p>
            @endif
        </div>
    </div>
</body>