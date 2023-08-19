<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('movies')->insert([
            [
                'nome' => 'Filme A',
                'sinopse' => 'Sinopse do Filme A',
                'ano' => '2023-01-01',
                'imagem' => 'imagem_a.jpg',
                'link' => 'https://link.filmea.com',
            ],
            [
                'nome' => 'Filme B',
                'sinopse' => 'Sinopse do Filme B',
                'ano' => '2023-02-01',
                'imagem' => 'imagem_b.jpg',
                'link' => 'https://link.filmeb.com',
            ],
        ]);
    }
}
