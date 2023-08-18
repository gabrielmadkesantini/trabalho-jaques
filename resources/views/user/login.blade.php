<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        @if (session('sucesso'))
            <div>{{ session('sucesso') }}</div>
        @endif

        @if (session('erro'))
            <div>{{ session('erro') }}</div>
        @endif

        @if ($errors)
            @foreach ($errors->all() as $erro)
                {{ $erro }} <br>
            @endforeach
        @endif

        <form action="{{ route('login.confirm') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email"> <br>
            <input type="password" name="password" placeholder="Senha">
            <br><br>
            <input type="submit" value="Entrar">
        </form>

        <p>Não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
        <p><a href="{{ route('home') }}">Voltar</a></p>
    </div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 400px;
        text-align: center;
        margin: auto;
    }

    h1 {
        color: #ff9999;
    }

    form {
        margin-top: 20px;
    }

    input[type="email"],
    input[type="password"] {
        width: 90%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    input[type="submit"] {
        background-color: #ff9999;
        color: #fff;
        padding: 12px 30px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 15px;
        width: 100%;
    }

    input[type="submit"]:hover {
        background-color: #F789A0;
    }

    a {
        color: #ffe084;
        text-decoration: none;
    }

    a:hover {
        color: #FFCC33;
    }

    div.success {
        color: green;
    }

    div.error {
        color: red;
    }
</style>
