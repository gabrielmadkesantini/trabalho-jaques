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
    public function genero()
    {
        return $this->belongsTo('App\Models\Genero');
    }
    protected $fillable = [
        'movie_id',
        'genero_id',
    ];
}
