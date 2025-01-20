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
            <h1>Login</h1>
            <form class="form" action="{{ route('login') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="mutsuki@mutu.com">
                <input type="password" name="password" placeholder="mutsuki">
                <button type="'submit" id="login-button">Login</button>
            </form>
        </div>
    </div>
</body>
</html>