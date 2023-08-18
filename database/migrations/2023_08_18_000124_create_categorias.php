<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    protected $connection = "mysql";

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        $generos = ['Aventura', 'Terror', 'Horror', 'Ficção', 'Geek', 'Infantil', 'Anime', 'Romance', 'Variados'];


        foreach ($generos as $genero) {
            DB::table('genero')->insert([
                'nome' => $genero,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
