@extends('agente.painel_agente')

@section('title')
    Detalhes do Pedido
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

    <script type='text/javascript'>
        $(document).ready(function(){
            $('#preco,#disabledPreco').val("R$");
            $('#preco,#disabledPreco').inputmask("numeric", {
                radixPoint: ",",
                groupSeparator: ".",
                digits: 2,
                autoGroup: true,
                prefix: 'R$ ', //Space after $, this will not truncate the first character.
                rightAlign: false,
                oncleared: function () { self.Value(''); }
            });
            $('#submeter_oferta').click(function() {
                var precoNum = $('#disabledPreco').val();
                precoNum = precoNum.replace(/\./g, '');
                precoNum = precoNum.replace(',', '.');
                precoNum = precoNum.replace('R', '');
                precoNum = precoNum.replace('$', '');
                $("input[name='preco']").val((parseFloat(precoNum)).toFixed(2));
            });
        });

        $(function() {
           $('#realizar_oferta').click(function() {
                $(this).hide();
            });
        });

       $(function() {
           $('#cancelar_oferta').click(function() {
                $("#preco").val("");
                $("#disabledPreco").val("");
                $("#descricao").val("");
                $('#oferta').collapse("hide");
                $('#realizar_oferta').show("slow");
            });
        });

       $(function() {
           $('#preco').change(function() {
                var precoNum = $('#preco').val();
                precoNum = precoNum.replace(/\./g, '');
                precoNum = precoNum.replace(',', '.');
                precoNum = precoNum.replace('R', '');
                precoNum = precoNum.replace('$', '');
                $("#disabledPreco").val((parseFloat(precoNum)*1.1).toFixed(2));
            });
        });
    </script>
@endsection

@section('content')

    @if(isset($errors))
        @foreach($errors->all() as $message)
            {{ $message }}
        @endforeach
    @endif
  <!-- Page Content -->
  <div class="container-fluid">
    @include('components.painel_navbar')

    <div class="row">

      <!-- /.col-lg-3 -->

      <div class="col-md-12">

        @include('components.info_pedido', ['pedido' => $pedido, 'links' => $links])


        @if($oferta==null)
            <div class="row">
                    <div class="col-xl-12 py-5">
                        <div class="card collapse multi-collapse" id="oferta">
                            <div class="card-body" id="contact-form">
                                <h3 class="card-title">Realizar Oferta</h3>

                                <!-- formulário de oferta -->
                                <form method="post" action="{{action('OfertaController@cadastraOferta')}}" role="form">
                                    @csrf

                                    <div class="controls">

                                        <!-- campo -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="preco">O preço da sua oferta:</label>
                                                    <input id="preco" class="form-control" name="plainPreco" required="required">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- campo -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="disabledPreco">Preço final a ser pago, calculado a partir da taxa de serviço do Tucaninho:</label>
                                                    <input class="form-control"  id="disabledPreco" type="text" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="preco">

                                        <!-- campo -->
                                         <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="descricao">Descreva os detalhes da sua oferta:</label>
                                                    <textarea id="descricao" name="descricao" class="form-control" placeholder="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente dicta fugit fugiat hic aliquam itaque facere, soluta. *" rows="4" required="required" data-error="Nos deixe uma mensagem." maxlength="1000"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <input type="hidden" name="email_cliente" value="{{$pedido->email_cliente}}">
                                    <input type="hidden" name="pedido_id" value="{{$pedido->pedido_id}}">

                                    <button type="submit" id="submeter_oferta" class="btn btn-outline-success">
                                        Submeter
                                    </button>
                                </form>

                                <button type="button" id="cancelar_oferta" class="btn btn-outline-danger">
                                    Cancelar
                                </button>
                                <!-- ./formulário de oferta -->
                            </div>
                        </div>

                        <button type="button" class="btn btn-warning btn-lg btn-block" id="realizar_oferta" data-toggle="collapse" data-target="#oferta" aria-expanded="false" aria-controls="oferta">
                            Fazer uma oferta
                        </button>

                    </div>
                </div>
            @else
                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Oferta
                    </div>
                    <div class="card-body">
                        @include('components.info_oferta', ['oferta' => $oferta, 'displayButton' => false])
                    </div>
                </div>
            @endif

      </div>
      <!-- /.col-lg-9 -->

    </div>

  </div>
  <!-- /.container -->
@endsection
