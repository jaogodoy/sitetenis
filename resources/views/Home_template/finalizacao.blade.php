@extends('Home_template.index')

@section('Conteudo')
    <div class="colorlib-product">
        <div class="row">
            <div class="col-sm-10 offset-sm-1 text-center">
                <p class="icon-addcart"><span><i class="icon-check"></i></span></p>
                <h2 class="mb-4">Obrigado por comprar, Seu pedido está completo</h2>
                <p>
                    <a href="{{ url('/jgstore') }}"class="btn btn-primary btn-outline-primary">Home</a>
                </p>
            </div>
        </div>
    </div>
    </div>
@endsection
