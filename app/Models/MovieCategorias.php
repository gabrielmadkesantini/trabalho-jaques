<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieCategorias extends Model
{
    use HasFactory;
    use HasFactory;

    public function filme()
    {
        return $this->belongsTo('App\Models\Movie');
    }
    public function categorias()
    {
        return $this->belongsTo('App\Models\Categorias');
    }
    protected $fillable = [
        'movie_id',
        'categorias_id',
    ];
}
