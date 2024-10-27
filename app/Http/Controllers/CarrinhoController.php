<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Produto;

class CarrinhoController extends Controller
{
    public function adicionar(Request $request, $id)
    {
        $produto = Produto::find($id);
        $carrinho = Session::get('carrinho', []);

        if(isset($carrinho[$id])) {
            $carrinho[$id]['quantidade']++;
        } else {
            $carrinho[$id] = [
                "nome" => $produto->produto_nome,
                "quantidade" => 1,
                "preco" => $produto->produto_preco,
                "imagem" => $produto->produto_imagem
            ];
        }

        Session::put('carrinho', $carrinho);
        return redirect()->route('exibir.carrinho')->with('success', 'Produto adicionado ao carrinho!');
    }

    public function exibirCarrinho()
    {
        $carrinho = Session::get('carrinho', []);
        return view('Home_template.carrinho', compact('carrinho'));
    }

    public function remover($id)
    {
        $carrinho = Session::get('carrinho', []);

        if(isset($carrinho[$id])) {
            unset($carrinho[$id]);
            Session::put('carrinho', $carrinho);
        }

        return redirect()->route('exibir.carrinho')->with('success', 'Produto removido do carrinho!');
    }

    public function atualizarQuantidade(Request $request, $id)
    {
        $carrinho = Session::get('carrinho', []);
        if(isset($carrinho[$id])) {
            $carrinho[$id]['quantidade'] = $request->quantidade;
            Session::put('carrinho', $carrinho);
        }

        return redirect()->route('exibir.carrinho')->with('success', 'Quantidade atualizada!');
    }
}

