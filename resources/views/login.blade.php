<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible">
        <title>Document</title>
    </head>
    <body>
    <div class="wrapper">
        <div class="container">
            <h1>会員ログイン</h1>
            <p>mutsuki@mutu.com</p>
            <br>
            <p>mutsuki</p>
            <form class="form" action="{{ route('login') }}" method="POST">
                @csrf
                <input name="email">
                <input type="password" name="password">
                <button type="'submit" id="login-button">Login</button>
            </form>
        </div>
    </div>
</body>
</html>