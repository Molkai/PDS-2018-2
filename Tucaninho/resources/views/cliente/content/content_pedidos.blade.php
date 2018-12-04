@extends('cliente.painel_cliente')

@section('title')
    Pedidos
@endsection

@section('styles')
@endsection

@section('scripts')
  <script>
    let index;

    $(".clickable-row").css('cursor', 'pointer');
    $(".clickable-row").click(function(e) {
        console.log(e.target);
        if(!$(e.target).is('i'))
            window.location = $(this).data("href");
        else{
            index = $("tr").index($(this));
            let id = $(this).data("id");
            let email_cliente = $(this).data("cliente");
            if(confirm("Você tem certeza que quer deletar?")){
                $.post(
                    "{{action('PedidosController@deleteRow')}}",
                    {
                        id: id,
                        email_cliente: email_cliente,
                        _token: '{{csrf_token()}}'
                    },
                    function(data){
                        if(data==='Sucesso.')
                            $("tr:eq('"+index+"')").remove();
                        console.log(data);
                    },
                    "json"
                ).fail(function(data){
                    console.log(data);
                });
            }
            else
                alert("Operação cancelada");
        }
    });
  </script>
@endsection

@section('content')
  <div class="container-fluid">
      @include('components.painel_navbar')
      <!-- Project One -->
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Data</th>
            <th scope="col">Preço</th>
            <th scope="col">Descrição</th>
            <th scope="col">Tempo restante</th>
            <th scope="col">Remover</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pedidos as $pedido)
            <tr class="clickable-row" data-id="{{$pedido->pedido_id}}" data-cliente="{{$pedido->email_cliente}}" data-href="{{action('PedidosController@detalhesPedidoCliente', [encrypt($pedido->pedido_id)])}}">
              <th scope="row">{{\Carbon\Carbon::parse($pedido->pedido_id)->format('d/m/Y - H:i')}}</th>
              <td>{{$pedido->preco}}</td>
              @if(strlen($pedido->descricao)<60)
                <td>{{$pedido->descricao}}</td>
              @else
                <td>{{substr($pedido->descricao, 0, 57).'...'}}</td>
              @endif
              @if($pedido->estado==3)
                <td>Concluido</td>
              @elseif($pedido->estado==2)
                <td>Pendente</td>
              @elseif($pedido->estado==1)
                <td>Expirou</td>
              @else
                <td>{{\Carbon\Carbon::parse($pedido->pedido_id, 'America/Sao_Paulo')->addDay()->diffAsCarbonInterval(\Carbon\Carbon::now('America/Sao_Paulo'))->forHumans('H:i:s')}}</td>
              @endif
              <td><a href="#"><i class="far fa-trash-alt"></i></a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
  </div>
@endsection
