<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メニュー</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
            
            <!-- タブメニュー -->
            <div class="flex space-x-4 mt-2 border-b">
                <button class="px-4 py-2 text-red-500 border-b-2 border-red-500">おすすめ</button>
                <button class="px-4 py-2">セット</button>
                <button class="px-4 py-2">クーポン</button>
                <button class="px-4 py-2">バーガー</button>
            </div>
        </header>

        <!-- メニューグリッド -->
        <div class="grid grid-cols-2 gap-4 p-4">
            @foreach($menuItems as $item)
            <div class="flex flex-col items-center">
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="w-32 h-32 object-contain">
                <p class="mt-2 text-sm text-center">{{ $item->name }}</p>
            </div>
            @endforeach
        </div>

        <!-- カートボタン -->
        <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t">
            <div class="max-w-md mx-auto">
                <button class="w-full bg-yellow-400 text-black py-3 px-6 rounded-md font-medium">
                    レジに進む
                </button>
            </div>
        </div>
    </div>
</body>
</html>