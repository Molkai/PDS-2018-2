@extends('cliente.painel_cliente')

@section('title')
    Novo Pedido
@endsection

@section('styles')
  <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
@endsection


@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js" integrity="sha256-dHf/YjH1A4tewEsKUSmNnV05DDbfGN3g7NMq86xgGh8=" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

  <script>

  </script>
@endsection

@section('content')

  <div class="container-fluid">
    @include('components.painel_navbar')

      <div class="row">
            <div class="card">
                <div class="col-xl-12">
                    <h1 class="myText" align="left"> Você disse</h1>
                    <p class="otherText">Mensagem aqui!!!</p>
                </div>
            </div>
            <div class="card">
                <div class="col-xl-12" align="right">
                    <h1 class="myText"> Ele disse</h1>
                    <p class="otherText">Mensagem aqui!!!</p>
                </div>
            </div>
        </div>
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

  </div>
@endsection
