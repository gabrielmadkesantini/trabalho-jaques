<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Categorias;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categorias::all();
        return view('categorias.view', ["categorias => $categorias"]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorias.view');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Categorias::create($request->validate(["name" => "required"]));
        return redirect()->route('home') . with("sucesso", "Categoria criada com sucesso");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorias $categ)
    {
        return view('categorias.edit', ["categorias" => $categ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorias $categoria)
    {
        $categoria->update($request->validate(["name" => "required"]));
        return redirect()->route('categorias.view') . with("sucesso", "Categoria alterada com sucesso");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorias $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.view') . with("sucesso", "Categoria deletada com sucesso");
    }
}
