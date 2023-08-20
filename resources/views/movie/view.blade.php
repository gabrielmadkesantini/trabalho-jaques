@extends('!layout.layout')

@section('title', 'Flix Screen')

@section('content')

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@php
    $caminhoImagem = public_path('storage/' . $movies->imagem);
    $infoImagem = getimagesize($caminhoImagem);

    $largura = $infoImagem[0]; // Índice 0 contém a largura
    $altura = $infoImagem[1]; // Índice 1 contém a altura
@endphp

    <div class="container">
        <div class="movie-info">
            <div class="movie-image">
                @if($movies->imagem)
                <div class='img-container'>
                    <img src="{{ asset('storage/' . $movies->imagem) }}" alt="{{ $movies->nome }} width={{$largura - $largura*0.4}}" height={{$altura - $altura*0.4}}>
                </div>
                    @else
                    Sem imagem
                @endif
                <h1 style="margin-top:10px">{{ $movies->nome }}</h1>
                <p> Lançado em {{ $movies->ano }}</p>
                <a href="{{route('home')}}"><button>Voltar</button></a>

            </div>
            <div class="movie-details">

                <iframe width="{{560 - 560*0.2}}" height="{{315 - 315*0.2}}" src="{{ $movies->link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
               
                <fieldset>
                    <legend>Sinopse:</legend>
                    {{ $movies->sinopse }}
                </fieldset>
                
                <p>Gênero(s):
                    @if ($categorias)
                        {{ $categorias }}
                    @else
                        Nenhum gênero associado
                    @endif
                </p>

            </div>

        </div>
    </div>



<style>
    body, h1, p, fieldset, img, button {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #fff;
    }

    
    .container {
        display: flex;
        margin: auto;
        width: 800px;
        padding: 20px;
        background-color: #f0f0f0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 35px;
    }

    .movie-info {
        display: flex;
    }

    .movie-image {
        flex: 0 0 100px;
        margin-right: 20px;
    }

    .movie-details {
        display: flex;
        flex-direction: column;
        width: 500px
        flex-direction: column;
        flex: 1;
    }

    .sinopse-spacing {
        margin-top: 10px;
    }

    h1 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    img {
        position: absolute; 
    width: auto; 
    height: 100%;
    left: 50%; 
    top: 50%;
    transform: translate(-50%, -50%);
    }

    p {
        margin-bottom: 5px;
    }

    fieldset {
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 15px;

    }

    legend {
        font-size: 18px;
        font-weight: bold;
    }

    legend{
        margin-bottom: -10px;
    }

.img-container {
    width: 15vw; 
    height: 40vh; 
    overflow: hidden;
    position: relative; 
    border: 1px solid #ccc; }

    .add-button {
        display: inline-block;
        padding: 10px 20px;
        margin-top: 20px;
        background-color: #AD9064;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .add-button:hover {
        background-color: #94774b;
    }

    .price-box {
        flex: 0 0 120px;
        text-align: center;
        padding: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 20px;
    }

    .buy-button {
        display: inline-block;
        padding: 10px 20px;
        margin-top: 20px;
        background-color: #B392AC;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .buy-button:hover {
        background-color: #8a577f;
        color: #fff;

    }

    @media screen and (max-width: 600px) {
        .container {
            padding: 10px;
        }
        .movie-info {
            flex-direction: column;
        }
        .movie-image {
            margin-right: 0;
            margin-bottom: 10px;
        }
    }

</style>


@endsection
