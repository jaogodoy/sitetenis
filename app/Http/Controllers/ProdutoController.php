<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::where("produto_ativo", "1")->with('categoria')->get();
        $categorias = Categoria::where("categoria_ativo", "1")->get();

        return view('produtos.index', compact('produtos', 'categorias'));
    }

    public function salvarNovoProduto(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'produto_nome' => 'required|string|max:30',
            'produto_quantidade' => 'required|integer',
            'produto_descricao' => 'nullable|string',
            'produto_imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif|max:2048',
        ]);

        $data = $request->all();

        // Manipulação da imagem
        if ($request->hasFile('produto_imagem')) {
            $data['produto_imagem'] = $request->file('produto_imagem')->store('imagens/produtos', 'public');
        }

        Produto::create($data);

        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
    }

    public function detalhesProduto(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    public function formularioAlterar(Produto $produto)
    {
        $categorias = Categoria::all();
        return view('produtos.edit', compact('produto', 'categorias'));
    }

    public function salvarAlterarProduto(Request $request, Produto $produto)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'produto_nome' => 'required|string|max:255',
            'produto_quantidade' => 'required|integer',
            'produto_descricao' => 'nullable|string',
            'produto_imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif|max:2048',
        ]);

        $data = $request->all();

        // Manipulação da imagem
        if ($request->hasFile('produto_imagem')) {
            // Se já tiver uma imagem, excluí-la do storage
            if ($produto->produto_imagem) {
                Storage::disk('public')->delete($produto->produto_imagem);
            }
            $data['produto_imagem'] = $request->file('produto_imagem')->store('imagens/produtos', 'public');
        }

        $produto->update($data);

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        // Se existir uma imagem, excluí-la do storage
        if ($produto->produto_imagem) {
            Storage::disk('public')->delete($produto->produto_imagem);
        }

        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto removido com sucesso!');
    }

    public function produtosMasculinos()
    {
        $produtosMasculinos = Produto::where('produto_genero', 'masculino')->get();
        return view('Home_template.homem', compact('produtosMasculinos'));
    }

    public function produtosFemininos()
{
    $produtosFemininos = Produto::where('produto_genero', 'feminino')->get();
    return view('Home_template.mulher', compact('produtosFemininos'));
}


}
