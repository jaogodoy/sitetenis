<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\ClientAuth;
use App\Http\Middleware\Authenticate;

// Rotas de Admin
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register']);

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit'); // Aqui está o nome da rota para o submit

// Rotas de Cliente
Route::get('/client/register', [ClientAuthController::class, 'showRegisterForm'])->name('client.register');
Route::post('/client/register', [ClientAuthController::class, 'register']);

Route::get('/client/login', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
Route::post('/client/login', [ClientAuthController::class, 'login'])->name('client.login.submit'); // Nome da rota para o submit







Route::get('/adm', function () {return view('Admintemplate.index');});
Route::get('/', function () {return view('Home_template.index');})->name('home');
Route::get('/homem', [ProdutoController::class, 'produtosMasculinos']);
Route::get('/mulher', [ProdutoController::class, 'produtosFemininos']);






Route::middleware(['auth', ClientAuth::class])->group(function () {
    Route::get('/client/dashboard', function () {
        return view('Home_template.index'); // Crie a view client.dashboard
    })->name('client.dashboard');

    Route::post('/carrinho/adicionar/{produto}', [CarrinhoController::class, 'adicionar'])->name('adicionar.carrinho');
    Route::get('/carrinho', [CarrinhoController::class, 'exibirCarrinho'])->name('exibir.carrinho');
    Route::post('/carrinho/remover/{produto}', [CarrinhoController::class, 'remover'])->name('remover.carrinho');
    Route::post('/carrinho/atualizar/{produto}', [CarrinhoController::class, 'atualizarQuantidade'])->name('atualizar.carrinho');
    Route::get('/finalizacao', function () { return view('Home_template.finalizacao'); });

Route::get('/pagamento', [PagamentoController::class, 'index'])->name('processar.pagamento');
Route::post('/pagamento/finalizar', [PagamentoController::class, 'finalizar'])->name('pagamento.finalizar');



Route::get('/pagamento/sucesso', function () {
    return view('Home_template.sucesso');
})->name('pagamento.sucesso');

Route::get('/pagamento/falha', function () {
    return view('Home_template.falha');
})->name('pagamento.falha');



});


Route::middleware(['auth', AdminAuth::class])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('Admintemplate.index'); // Crie a view admin.dashboard
    })->name('admin.dashboard');

    Route::get('/categoria', [ CategoriaController::class, 'index' ])->name('categoria');
    Route::get("/categoria/exc/{id}", [ CategoriaController::class, 'ExcluirCategoria' ])->name('categoria_ex');
    Route::get("/categoria/upd/{id}",[ CategoriaController::class, 'BuscarAlteracao' ])->name('categoria_upd');

    Route::post('/categoria', [ CategoriaController::class, 'IncluirCategoria' ]);
    Route::post('/categoria/upd', [ CategoriaController::class, 'ExecutaAlteracao' ]);

    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::post('/produtos', [ProdutoController::class, 'salvarNovoProduto'])->name('novo_produto');
    Route::put('/produtos/{produto}', [ProdutoController::class, 'salvarAlterarProduto'])->name('produto_update');
    Route::get('/produtos/{produto}', [ProdutoController::class, 'detalhesProduto'])->name('produto_detalhes');
    Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produto_excluir');


});




