@extends('cliente.painel_cliente')

@section('title')
    Detalhes do Pedido
@endsection

@section('content')
    <!-- Page Content -->
    <div class="container-fluid">
        @include('components.painel_navbar')

        <div class="row">

            <div class="col-md-12">

                @include('components.info_pedido', ['pedido' => $pedido, 'links' => $links, 'datas' => $datas])

                @if(count($ofertas)>0)
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">
                            Ofertas
                        </div>
                        <div class="card-body">
                            @foreach($ofertas as $oferta)
                                @include('components.info_oferta', ['oferta' => $oferta, 'displayButton' => true])
                                @include('components.conversa_remetente')
                                <br>
                                @include('components.conversa_destinatario')
                                <hr>
                                <form id="sendMessageForm" method="post" action="" role="form">
                                    <div class="row content-center">
                                        <div class="col-xl-8">
                                            <div class="form-group">
                                                <input id="msg" name="mensagem" class="form-control" required="required" data-error="Não é possivel enviar mensagens vazias.">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-warning btn-send" value="enviar">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>

    </div>

@endsection
