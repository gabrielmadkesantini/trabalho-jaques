<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\MovieCategorias;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;



class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function movie()
    {
        $movies = Movie::all();
        // dd($movies);
        return view("movie.movie", ["movie" => $movies]);
    }

    public function filter(Request $request)
    {
        $nome = $request->input('name');
        $ano = $request->input('ano');


        $result = DB::table('movies')->where('nome', 'LIKE', '%' . $nome . '%')->where('ano', 'LIKE', '%' . $ano . '%')->get();

        $otherResult = Movie::all();

        if (!$result) {
            return redirect()->route("home", ['movies' => $result]);
        } else {
            return redirect()->route("home", ['movies' => $otherResult]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function insertMoviePage()
    {
        $categorias =  Categorias::all();

        return view("movie.insert", ["categorias" => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|min:3',
            'ano' => 'required',
            'sinopse' => 'string|required',
            'link' => 'string',
            'imagem' => [
                'image',
                Rule::dimensions()->maxWidth(2048)->maxHeight(2048),
                Rule::file()->max(2048),
            ],
        ]);
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('filme', 'public');
            $dados['imagem'] = $imagemPath;
        } else {
            $dados['imagem'] = '';
        }

        $filme = Movie::create($dados);

        $generoIds = $request->input('categorias');
        $filme->categorias()->sync($generoIds);

        return redirect()->route('movie')->with('sucesso', 'Filme adicionado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function showByName(Request $request)
    {
        if ($request->isMethod('POST')) {
            $busca = $request->busca;

            $movies = Movie::where('nome', 'LIKE', "%{$busca}%")
                ->orWhere('id', $busca)
                ->orderBy('id')
                ->get();
        } else {
            $movies = Movie::all();
        }

        return view('movie.movie', [
            'movie' => $movies,
        ]);
    }

    public function searchMovieByCategory(Request $request, $nome)
    {
        $userId = null;
        if (Auth::check()) {
            $userId = $request->user()->id;
        }

        $filmesQuery = Movie::query();

        // Filtra os filme pelo gênero selecionado
        $filmesQuery->whereHas('categorias', function ($query) use ($nome) {
            $query->where('categorias.nome', $nome);
        });

        $movies = $filmesQuery->get();

        // Carregar os gêneros para cada Filme encontrado
        $movies->load('categorias');

        $categoriaselecionado = Categorias::where('nome', $nome)->first();

        // Carregar todos os gêneros
        $categorias = Categorias::all();

        $filme = Movie::select('movie.id', 'movie.nome', DB::raw('GROUP_CONCAT(categorias.nome SEPARATOR ", ") AS categorias'))
            ->join('Filme_gens', 'filme.id', '=', 'Filme_gens.filme_id')
            ->join('categorias', 'Filme_gens.genero_id', '=', 'categorias.id')
            ->groupBy('filme.id', 'filme.nome')
            ->get();

        $categoriaselecionado = Movie::where('nome', $nome)->first();

        return view('genres.' . Str::slug($nome), compact('filme', 'categorias', 'movies', 'categoriaselecionado'));
    }

    public function editPage(string $id)
    {
        $movie = Movie::find($id);
        $categorias = Categorias::all();
        return view('movie.edit', [
            'movie' => $movie,
            'categorias' => $categorias
        ]);
    }

    public function edit(Request $request, string $id)
    {
        $filme = Movie::find($id);
        if (!$filme) {
            return redirect()->route('movie')->with('erro', 'Filme não encontrado!');
        }
        $dados = $request->validate([
            'nome' => 'required|min:3',
            'ano' => 'required',
            'sinopse' => 'string|required',
            'link' => 'string',
            'imagem' => [
                'image',
                Rule::dimensions()->maxWidth(2048)->maxHeight(2048),
                Rule::file()->max(2048),
            ],
        ]);
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('filme', 'public');
            $dados['imagem'] = $imagemPath;
        } else {
            $dados['imagem'] = '';
        }

        $categorias = $request->input('categorias');

        $filme->nome = $request->input('nome');
        $filme->ano = $request->input('ano');
        $filme->sinopse = $request->input('sinopse');
        $filme->link = $request->input('link');
        $filme->imagem = $dados['imagem'];
        $filme->save();

        $filme->categorias()->sync($categorias);

        return redirect()->route('movie')->with('sucesso', 'Filme atualizado com sucesso!');
    }

    public function moviePage(string $id)
    {
        $movie = Movie::find($id);
        $categorias = MovieCategorias::join('categorias', 'movie_categorias.categorias_id', '=', 'categorias.id')
            ->where('movie_categorias.movie_id', $movie->id)
            ->select('categorias.*')
            ->get();


        return view('movie.view', ['movies' => $movie, 'categorias' => $categorias[0]->name]);
    }

    public function update(Request $request, Movie $movies)
    {
        $rules = [
            'nome' => [
                'required',
                Rule::unique('filme')->ignore($movies->id),
            ],
            'sinopse' => 'required',
            'ano' => 'required',
            'link' => 'required',
        ];

        // Verifica se foi enviada uma nova imagem
        if ($request->hasFile('imagem')) {
            // Se sim, adiciona as regras de validação da imagem
            $rules['imagem'] = [
                'image',
                Rule::dimensions()->maxWidth(2048)->maxHeight(2048),
                Rule::file()->max(2048),
            ];
        }

        $dados = $request->validate($rules);

        if ($request->hasFile('imagem')) {
            // Remove a imagem anterior, caso exista
            if ($movies->imagem) {
                Storage::disk('public')->delete($movies->imagem);
            }

            // Armazena a nova imagem e atualiza o campo no banco de dados
            $imagemPath = $request->file('imagem')->store('filme', 'public');
            $dados['imagem'] = $imagemPath;
        } else {
            // Caso não tenha sido enviada uma nova imagem, mantemos o valor atual
            $dados['imagem'] = $movies->imagem;
        }

        $movies->update($dados);

        // Atualize os gêneros associados ao Filme
        $generoIds = $request->input('categorias');
        $movies->categorias()->sync($generoIds);

        return redirect()->route('movie.view')->with('sucesso', 'Filme alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = DB::table('movies')
            ->where('id', $id)
            ->delete();

        return  redirect()->route('home')->with('sucesso', 'Filme excluido com sucesso!');
    }
}
