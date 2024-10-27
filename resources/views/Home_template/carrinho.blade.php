@extends('Home_template.index')

@section('Conteudo')
    <div class="container mt-4">
        <h1 class="mb-4">Carrinho de Compras</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (empty($carrinho))
            <div class="alert alert-info">Seu carrinho está vazio.</div>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $precoTotal = 0; // Inicializa o preço total
                    @endphp

                    @foreach ($carrinho as $id => $item)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $item['imagem']) }}"
                                     alt="Imagem de {{ $item['nome'] }}"
                                     class="img-thumbnail"
                                     width="50">
                            </td>
                            <td>{{ $item['nome'] }}</td>
                            <td>
                                <form action="{{ route('atualizar.carrinho', $id) }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="number"
                                               name="quantidade"
                                               value="{{ $item['quantidade'] }}"
                                               min="1"
                                               class="form-control">
                                        <button type="submit" class="btn btn-primary">Atualizar</button>
                                    </div>
                                </form>
                            </td>
                            <td>R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('remover.carrinho', $id) }}" method="POST" onsubmit="return confirm('Você tem certeza que deseja remover este item?');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Remover</button>
                                </form>
                            </td>
                        </tr>
                        @php
                            // Adiciona o preço do item multiplicado pela quantidade ao preço total
                            $precoTotal += $item['preco'] * $item['quantidade'];
                        @endphp
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <h5 class="mt-4">Preço Total: R$ {{ number_format($precoTotal, 2, ',', '.') }}</h5>
                <a href="{{ route('processar.pagamento') }}" class="btn btn-success">Finalizar Compra</a>
                <a href="{{ route('home') }}" class="btn btn-secondary">Continuar Comprando</a>
            </div>
        @endif
    </div>
@endsection
