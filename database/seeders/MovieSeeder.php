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
                'nome' => 'A menina que roubava livros',
                'sinopse' => 'Alguma texto aqui',
                'ano' => 2023,
                'imagem' => 'https://2.bp.blogspot.com/-TOCRLYBV3N4/UsbbAXBZmkI/AAAAAAAAPuM/DbPHOcuv6HA/s1600/A-Menina-Que-Roubava-Livros-capa-filme-1.jpg',
                'link' => 'https://www.youtube.com/embed/FzNrBC-tF7A',
            ],
            [
                'nome' => 'Carros 2',
                'sinopse' => 'Alguma texto aqui',
                'ano' => 2023,
                'imagem' => 'https://upload.wikimedia.org/wikipedia/pt/7/7e/Carros_2_P%C3%B4ster.jpg',
                'link' => 'https://www.youtube.com/embed/8M2NvKPW_VE',
            ],
        ]);
    }
}
