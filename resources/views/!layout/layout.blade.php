<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Flix Screen</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/css/style.css" rel="stylesheet">
    
</head>

<body>
    </div> <br><br>
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-semi-bold">
                </h1>
            </a>
        </div>
        <div class="col-lg-6 col-6 text-left">
            <form action="{{ route('home') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="nome" value='' class="form-control" placeholder="Buscar filme">
                    <div class="input-group-append">
                    <input type="text" name="ano" value='' class="form-control" placeholder="Buscar por ano">
                    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-6 text-right">
            @if (Auth::user())
                <div style="display: inline-block;">
                    {{ Auth::user()->name }} <br>
                    <a href="{{ route('logout') }}">Logout</a>
                </div>

                @if (Auth::user() && Auth::user()->admin)
                    <br> <a href="{{ route('movie') }}">Gerenciar filmes</a>
                    <br> <a href="{{ route('movie.insert') }}">Novo filme</a>
                @endif
            @else
                <a href="{{ route('login') }}"><i class="fas fas fa-user-circle text-primary"></i></a>
            @endif
        </div>
    </div>
    </div>

    @yield('content')
</body>
</html>
