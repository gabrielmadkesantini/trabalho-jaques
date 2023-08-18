<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\filmeController;
use App\Models\Categorias;
use App\Models\Genero;
use App\Models\filme;
use App\Models\filmeGen;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['get', 'post'], '/', function (Request $request) {

    $userId = null;
    if (Auth::check()) {
        $userId = $request->user()->id;
    }



    $generos = Categorias::all();
    $moviesQuery = Movie::query();

    if ($request->isMethod('POST')) {
        $busca = $request->busca;

        // Filtra os filmes pelo nome
        $moviesQuery->where('nome', 'LIKE', "%{$busca}%");
    }

    if ($request->has('genero_id')) {
        // Filtra os filmes pelo gênero selecionado
        $genero_id = $request->input('genero_id');
        $moviesQuery->whereHas('genero', function ($query) use ($genero_id) {
            $query->where('genero.id', $genero_id); // Especifique a tabela correta usando o alias 'generos.id'
        });
    }

    $movies = $moviesQuery->get();

    // Carregar os gêneros para cada filme encontrado
    $movies->load('genero');

    $movies = Movie::select('movie.id', 'movie.nome', DB::raw('GROUP_CONCAT(genero.nome SEPARATOR ", ") AS generos'))
        ->join('genero', 'movie.id', '=', 'genero.id')
        ->join('genero as genero2', 'genero.id', '=', 'genero2.id')
        ->groupBy('movie.id', 'movie.nome')
        ->get();



    // Definir $generoSelecionado como null
    $generoSelecionado = null;

    return view('welcome', compact('movies', 'generos', 'generoSelecionado'))->with('movies', $movies);
})->name('home');

Route::get('/genero/{nome}', [filmeController::class, 'moviesPorGenero'])->name('movies.genero');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'regSuccess'])->name('register.addSuccess');

Route::get('/new-movie', [filmeController::class, 'movie'])->name('movie')->middleware('auth');
Route::post('/new-movie', [filmeController::class, 'newmovie'])->name('movie.newmovie');

Route::get('/new-movie/movie/view', [filmeController::class, 'searchmovie'])->name('movie.view')->middleware('auth');
Route::post('/new-movie/movie/view', [filmeController::class, 'searchmovie'])->name('movie.viewTable');

Route::get('/new-movie/movie/movie-page/{movies}', [filmeController::class, 'moviePage'])->name('movie.moviePage');

Route::get('/new-movie/movie/edit/{movies}', [filmeController::class, 'editmovie'])->name('movie.edit')->middleware('auth');
Route::post('/new-movie/movie/edit/{movies}', [filmeController::class, 'editSavemovie'])->name('movie.editSave');

Route::get('/new-movie/movie/delete/{movie}', [filmeController::class, 'deletemovie'])->name('movie.delete')->middleware('auth');
Route::delete('/new-movie/movie/delete/{movie}', [filmeController::class, 'deleteConfirmmovie'])->name('movie.deleteConfirm')->middleware('auth');

Route::get('/new-movie/genre', [filmeController::class, 'genre'])->name('genre')->middleware('auth');
Route::post('/new-movie/genre', [filmeController::class, 'newGenre'])->name('genre.newGenre');

Route::get('/new-movie/genre/new', [filmeController::class, 'search'])->name('genre.view')->middleware('auth');
Route::post('/new-movie/genre/new', [filmeController::class, 'search'])->name('genre.viewTable');

Route::get('/new-movie/genre/edit/{genero}', [filmeController::class, 'edit'])->name('genre.edit')->middleware('auth');
Route::post('/new-movie/genre/edit/{genero}', [filmeController::class, 'editSave'])->name('genre.editSave');

Route::get('/new-movie/genre/delete/{genero}', [filmeController::class, 'delete'])->name('genre.delete')->middleware('auth');
Route::delete('/new-movie/genre/delete/{genero}', [filmeController::class, 'deleteConfirm'])->name('genre.deleteConfirm');
