@extends('!layout.layout')

@section('title', 'Flix Screen')

@section('content')

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif



    <div class="container">
        <div class="movie-info">
            <div class="movie-image">
                @if($movies->imagem)
                    <img src="{{ asset('storage/' . $movies->imagem) }}" alt="{{ $movies->nome }}" width="100">
                @else
                    Sem imagem
                @endif
            </div>
            <div class="movie-details">
                <h1>{{ $movies->nome }}</h1>
                <p> {{ $movies->ano }}</p>
                <fieldset>
                    <legend>Sinopse:</legend>
                    {{ $movies->sinopse }}
                </fieldset>
                <p class="sinopse-spacing">Trailer: {{ $movies->link }}</p>
                <p>Gênero(s):
                    @if ($movies->generos->count() > 0)
                        {{ $movies->generos->pluck('nome')->implode(', ') }}
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
        max-width: 800px;
        margin: 0 auto;
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
        display: block;
        margin-bottom: 10px;
        max-width: 100%;
        height: auto;
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
