<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

    use HasFactory;

    protected $table = 'movies';

    protected $fillable = [
        'nome',
        'sinopse',
        'ano',
        'imagem',
        'link',
    ];

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'movie_categorias', 'movie_id', 'categorias_id');
    }
}
