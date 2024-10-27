<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Produto;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::where("categoria_ativo", "1")->get();


        return view('categoria.index', compact('categorias') );
    }


    public function IncluirCategoria(Request $request)
    {
        $categoria_nome = $request->input("categoria_nome");
        $categoria_descricao = $request->input("categoria_descricao");

        $nova = new Categoria;
        $nova->categoria_nome = $categoria_nome;
        $nova->categoria_descricao = $categoria_descricao;
        $nova->categoria_ativo = 1;
        $nova->save();

        return redirect('/categoria');

    }


    public function ExecutaAlteracao(Request $request)
    {
        $dado_nome = $request->input("categoria_nome");
        $dado_desc = $request->input("categoria_descricao");
        $dado_id = $request->input('id');

        $categoria = Categoria::where("id", $dado_id)->first();
        $categoria->categoria_nome = $dado_nome;
        $categoria->categoria_descricao = $dado_desc;
        $categoria->save();

        return redirect('/categoria');
    }

    /**
     * Update the specified resource in storage.
     */
    public function BuscarAlteracao(Request $request, string $id)
    {
        $categoria = Categoria::where("id", $id)->first();

        return view('categoria.alterar', compact('categoria'));
    }


    public function ExcluirCategoria($id)
    {
        $categoria = Categoria::where("id", $id)->first();
        $categoria->categoria_ativo = 0;
        $categoria->save();

        return redirect('/categoria');
    }

    public function search(Request $request)
{
    $searchTerm = $request->input('search');

    // Realiza a busca com base no nome da categoria
    $categorias = Categoria::where('categoria_nome', 'like', '%' . $searchTerm . '%')
                            ->where('categoria_ativo', 1)
                            ->get();

    return view('categoria.index', compact('categorias'));
}

}
