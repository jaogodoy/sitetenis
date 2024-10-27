@extends('Admintemplate.index')

@section('admin_template')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Produtos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">produtos</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Lista de produtos
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Novo
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Quantidade</th>
                            <th>Preço</th>
                            <th>Gênero</th>
                            <th>Imagem</th> <!-- Nova coluna para imagem -->
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produtos as $linha)
                            <tr>
                                <td>{{ $linha->id }}</td>
                                <td>{{ $linha->produto_nome }}</td>
                                <td>{{ $linha->produto_descricao }}</td>
                                <td>{{ $linha->categoria->categoria_nome }}</td>
                                <td>{{ $linha->produto_quantidade }}</td>
                                <td>R$ {{ number_format($linha->produto_preco, 2, ',', '.') }}</td>
                                <td>{{ ucfirst($linha->produto_genero) }}</td>
                                <td>
                                    @if ($linha->produto_imagem)
                                        <img src="{{ asset('storage/' . $linha->produto_imagem) }}" alt="{{ $linha->produto_nome }}" style="width: 50px; height: auto;">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal{{ $linha->id }}">
                                        <i class='fa fa-pencil'></i>
                                    </a>
                                    |
                                    <a href='{{ route('produto_excluir', ['produto' => $linha->id]) }}' class='btn btn-danger'
                                       onclick="event.preventDefault(); document.getElementById('delete-form{{ $linha->id }}').submit();">
                                        <i class='fa fa-trash'></i>
                                    </a>
                                    <form id="delete-form{{ $linha->id }}" action="{{ route('produto_excluir', ['produto' => $linha->id]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal de Edição -->
                            <div class="modal fade" id="editModal{{ $linha->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $linha->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('produto_update', ['produto' => $linha->id]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $linha->id }}">Editar produto</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="categoria_id" name="categoria_id" required>
                                                        <option value="">Selecione uma categoria</option>
                                                        @foreach($categorias as $item)
                                                            <option value="{{ $item->id }}" {{ $item->id == $linha->categoria_id ? 'selected' : '' }}>
                                                                {{ $item->categoria_nome }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="categoria_id">Categoria</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="produto_nome" name="produto_nome" value="{{ $linha->produto_nome }}" placeholder="Digite o nome do produto" required>
                                                    <label for="produto_nome">Nome do produto</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="produto_descricao" name="produto_descricao" value="{{ $linha->produto_descricao }}" placeholder="Digite a descrição">
                                                    <label for="produto_descricao">Descrição</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="produto_quantidade" name="produto_quantidade" value="{{ $linha->produto_quantidade }}" placeholder="Digite a quantidade" required>
                                                    <label for="produto_quantidade">Quantidade</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="number" step="0.01" class="form-control" id="produto_preco" name="produto_preco" value="{{ $linha->produto_preco }}" placeholder="Digite o preço" required>
                                                    <label for="produto_preco">Preço</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="produto_genero" name="produto_genero" required>
                                                        <option value="masculino" {{ $linha->produto_genero == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                                        <option value="feminino" {{ $linha->produto_genero == 'feminino' ? 'selected' : '' }}>Feminino</option>
                                                    </select>
                                                    <label for="produto_genero">Gênero</label>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="produto_imagem" class="form-label">Imagem do Produto</label>
                                                    <input type="file" class="form-control" id="produto_imagem" name="produto_imagem" accept="image/*">
                                                    @if ($linha->produto_imagem)
                                                        <img src="{{ asset('storage/' . $linha->produto_imagem) }}" alt="{{ $linha->produto_nome }}" style="width: 150px; height: auto; margin-top: 10px;">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal para Adicionar Novo Produto -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('novo_produto') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Novo produto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="categoria_id" name="categoria_id" required>
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categorias as $item)
                                        <option value="{{ $item->id }}">{{ $item->categoria_nome }}</option>
                                    @endforeach
                                </select>
                                <label for="categoria_id">Categoria</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="produto_nome" name="produto_nome" placeholder="Digite o nome do produto" required>
                                <label for="produto_nome">Nome do produto</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="produto_descricao" name="produto_descricao" placeholder="Digite a descrição">
                                <label for="produto_descricao">Descrição</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="produto_quantidade" name="produto_quantidade" placeholder="Digite a quantidade" required>
                                <label for="produto_quantidade">Quantidade</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="number" step="0.01" class="form-control" id="produto_preco" name="produto_preco" placeholder="Digite o preço" required>
                                <label for="produto_preco">Preço</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-select" id="produto_genero" name="produto_genero" required>
                                    <option value="masculino">Masculino</option>
                                    <option value="feminino">Feminino</option>
                                </select>
                                <label for="produto_genero">Gênero</label>
                            </div>

                            <div class="mb-3">
                                <label for="produto_imagem" class="form-label">Imagem do Produto</label>
                                <input type="file" class="form-control" id="produto_imagem" name="produto_imagem" accept="image/*" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
