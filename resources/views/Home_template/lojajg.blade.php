@extends('Home_template.index')

@section('Conteudo')
    <h1>Produtos</h1>

    <h2>Masculinos</h2>
    <div class="row">
        @foreach ($produtosMasculinos as $produto)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if ($produto->produto_imagem)
                        <img src="{{ asset('storage/' . $produto->produto_imagem) }}" class="card-img-top" alt="{{ $produto->produto_nome }}">
                    @else
                        <img src="placeholder-image.jpg" class="card-img-top" alt="Imagem não disponível"> <!-- Adicione uma imagem de placeholder se a imagem não estiver disponível -->
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $produto->produto_nome }}</h5>
                        <p class="card-text">R$ {{ number_format($produto->produto_preco, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h2>Femininos</h2>
    <div class="row">
        @foreach ($produtosFemininos as $produto)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if ($produto->produto_imagem)
                        <img src="{{ asset('storage/' . $produto->produto_imagem) }}" class="card-img-top" alt="{{ $produto->produto_nome }}">
                    @else
                        <img src="placeholder-image.jpg" class="card-img-top" alt="Imagem não disponível"> <!-- Adicione uma imagem de placeholder se a imagem não estiver disponível -->
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $produto->produto_nome }}</h5>
                        <p class="card-text">R$ {{ number_format($produto->produto_preco, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
