<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
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

    $nome = $request->input('nome', '');
    $ano = $request->input('ano', '');


    $param = $request->input('categoria');
    $categorias = Categorias::all();

    if ($param && $nome && $ano) {
        $movies = Movie::whereHas('categorias', function ($query) use ($param) {
            $query->where('name', $param);
        })->where('nome', 'LIKE', '%' . $nome . '%')->where('ano', 'LIKE', '%' . $ano . '%')->get();
    } else if ($nome && $ano) {
        $movies = Movie::where('nome', 'LIKE', '%' . $nome . '%')->where('ano', 'LIKE', '%' . $ano . '%')->get();
    } else if ($nome) {
        $movies = Movie::where('nome', 'LIKE', '%' . $nome . '%')->get();
    } else if ($ano) {
        $movies = Movie::where('nome', 'LIKE', '%' . $ano . '%')->get();
    } else if ($param) {
        $movies = Movie::whereHas('categorias', function ($query) use ($param) {
            $query->where('name', $param);
        })->get();
    } else {
        $movies = Movie::all();
    }


    return view('welcome', compact('movies', 'categorias', 'nome', 'ano'));
})->name('home');

Route::get('/genero/{name}', [MovieController::class, 'moviesPorGenero'])->name('movies.genero');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'confirmLogin'])->name('login.confirm');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.addSuccess');

Route::get('/new-movie', [MovieController::class, 'movie'])->name('movie')->middleware('auth');
Route::post('/new-movie', [MovieController::class, 'filter'])->name('movie.search');

Route::get('/new-movie/movie/view', [MovieController::class, 'insertMoviePage'])->name('movie.insert')->middleware('auth');
Route::post('/new-movie/movie/view', [MovieController::class, 'store'])->name('movie.viewTable');

Route::get('/new-movie/movie/movie-page/{movies}', [MovieController::class, 'moviePage'])->name('movie.moviePage');

Route::get('/new-movie/movie/edit/{movies}', [MovieController::class, 'editPage'])->name('movie.edit')->middleware('auth');
Route::post('/new-movie/movie/edit/{movies}', [MovieController::class, 'edit'])->name('movie.editSave');

Route::get('/new-movie/movie/delete/{movie}', [MovieController::class, 'destroy'])->name('movie.delete')->middleware('auth');

Route::get('/new-movie/genre', [MovieController::class, 'genre'])->name('genre')->middleware('auth');
Route::post('/new-movie/genre', [MovieController::class, 'newGenre'])->name('genre.newGenre');

Route::get('/new-movie/genre/new', [MovieController::class, 'search'])->name('genre.view')->middleware('auth');
Route::post('/new-movie/genre/new', [MovieController::class, 'search'])->name('genre.viewTable');

Route::get('/new-movie/genre/edit/{genero}', [MovieController::class, 'edit'])->name('genre.edit')->middleware('auth');
Route::post('/new-movie/genre/edit/{genero}', [MovieController::class, 'editSave'])->name('genre.editSave');

Route::get('/new-movie/genre/delete/{genero}', [MovieController::class, 'delete'])->name('genre.delete')->middleware('auth');
Route::delete('/new-movie/genre/delete/{genero}', [MovieController::class, 'deleteConfirm'])->name('genre.deleteConfirm');
