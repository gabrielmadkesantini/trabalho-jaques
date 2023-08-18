<div style="text-align: center; margin-top: 5%">

    <h1>Editar filme</h1>

    @if (session('sucesso'))
    <div>{{session('sucesso')}}</div>
@endif

    @if ($errors)
    @foreach ($errors->all() as $erro)
        {{$erro}} <br>
        @endforeach
    @endif

    <form action="{{ url()->current()}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="nome" placeholder="Titulo do filme" value="{{old('nome', $movie->nome ?? '')}}"><br>
       <textarea name="sinopse" cols="40" rows="5" placeholder="Sinopse do filme">{{old('sinopse', $movie->sinopse ?? '')}}</textarea>
       <input type="text" name="link" placeholder="Link" value="{{old('link', $movie->link ?? '')}}"> <br>

        <fieldset style="margin-left: 40%; margin-right: 40%">
            <legend style="text-align: left">Ano:</legend>
            <input type="date" name="ano" value="{{old('ano', $movie->ano ?? '')}}"> <br>
        </fieldset>

        @if($movie->imagem)
        <label for="imagem">Imagem atual do filme:</label> <br>
        <img src="{{ asset('storage/' . $movie->imagem) }}" alt="Imagem antiga do filme" width="200">

        <br>
    @endif

    <div>
        <label for="imagem">Nova imagem do filme:</label> <br>
        <input type="file" name="imagem">
    </div> <br>

        <label for="generos">Selecione os gêneros:</label> <br>
<select name="generos[]" multiple>
    @foreach ($generos as $genero)
        <option value="{{ $genero->id }}" @if(in_array($genero->id, $movie->generos->pluck('id')->toArray())) selected @endif>
            {{ $genero->nome }}
        </option>
    @endforeach
</select>
<br>
        <input type="submit" value="Salvar">
    </form>

    <a href="{{route('movie.view')}}">Voltar</a>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
    }

    div {
        text-align: center;
        margin-top: 5%;
    }

    h1 {
        color: #AD9064;
    }

    div > label {
        color: #8A577F;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    select,
    input[type="file"] {
        width: 80%;
        padding: 8px;
        margin: 5px 0;
        border: 1px solid #AD9064;
        border-radius: 5px;
    }

    input[type="submit"] {
        background-color: #AD9064;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #8A577F;
    }

    a {
        color: #AD9064;
        text-decoration: none;
    }

    a:hover {
        color: #8A577F;
    }

    img {
        max-width: 100%;
        height: auto;
    }
</style>

