@extends('Home_template.index')

@section('Conteudo')
    <h1>Processar Pagamento</h1>
    <p>Insira as informações do seu cartão para realizar o pagamento.</p>

    <form action="{{ route('pagamento.finalizar') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome no Cartão:</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="cartao">Número do Cartão:</label>
            <input type="text" name="cartao" class="form-control" maxlength="16" required>
        </div>
        <div class="form-group">
            <label for="data_validade">Data de Validade (MM/AA):</label>
            <input type="text" name="data_validade" class="form-control" maxlength="5" required>
        </div>
        <div class="form-group">
            <label for="cvv">CVV:</label>
            <input type="text" name="cvv" class="form-control" maxlength="3" required>
        </div>
        <button type="submit" class="btn btn-primary">Finalizar Pagamento</button>
    </form>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
@endsection
