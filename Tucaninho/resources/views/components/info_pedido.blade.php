@switch($pedido->tipo_viagem)
    @case('0')
        <?php $viagem = 'Ida Doméstica' ?>
    @break
    @case('1')
        <?php $viagem = 'Ida Internacional' ?>
    @break
    @case('2')
        <?php $viagem = 'Retorno (Ida e Volta)' ?>
    @break
    @case('3')
        <?php $viagem = 'Múltiplas Paradas' ?>
    @break
    @default
        <?php $viagem = 'Volta ao Mundo' ?>
@endswitch

@switch($pedido->tipo_passagem)
    @case('0')
        <?php $passagem = 'Econômica' ?>
    @break
    @case('1')
        <?php $passagem = 'Econômica Premium' ?>
    @break
    @case('2')
        <?php $passagem = 'Executiva' ?>
    @break
    @default
        <?php $passagem = 'Primeira Classe' ?>
@endswitch

<div class="card">
  <div class="card-body">
    <h3 class="card-title">Detalhes do Pedido</h3>
    <h4>R${{ $pedido->preco }}</h4>
    @foreach($links as $link)
        <p class="card-text"><b>URL:</b> <a href="{{ $link->url }}">{{ $link->url }}</a></p>
    @endforeach
    <?php $i=0; ?>
    @foreach($datas as $data)
        @if($i%3==0)
            <div class="row my-4">
        @endif
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><strong>Trecho {{$i+1}}</strong></h5>
                    <p><strong>Data:</strong> {{$data->data}}</p>
                    <p><strong>País:</strong> {{$data->pais}}</p>
                    <p><strong>Cidade:</strong> {{$data->cidade}}</p>
                    <p><strong>Aeroporto:</strong> {{$data->aeroporto}}</p>
                </div>
            </div>
        </div>
        @if($i%3==2)
            </div>
        @endif
        <?php $i++ ?>
    @endforeach
    @if($i%3!=0)
        </div>
    @endif
    <div class="row">
        <p class="col-md-3 card-text"><b>Tipo da viagem:</b> {{ $viagem }}</p>
        <p class="col-md-3 card-text"><b>Classe:</b> {{ $passagem }}</p>
    </div>
    <div class="row">
        <p class="col-md-3 card-text"><b>Quantidade adultos:</b> {{ $pedido->qnt_adultos }}</p>
        <p class="col-md-3 card-text"><b>Quantidade crianças:</b> {{ $pedido->qnt_criancas }}</p>
        <p class="col-md-3 card-text"><b>Quantidade bebês:</b> {{ $pedido->qnt_bebes }}</p>
    </div>
    @if($pedido->preferencia!='')
        <p class="card-text"><b>Preferências:</b> {{ $pedido->preferencia }}</p>
    @endif
    @if((isset($estado_cliente) && $estado_cliente>=3)||(isset($estado_agente) && $estado_agente>=3))
        <p class="card-text"><b>Voucher:</b> <a href="{{action('PedidosController@downloadVoucher', explode('/', $pedido->filePath))}}">{{ $pedido->fileName }}</a></p>
    @endif
    <hr>
    <p class="card-text">{{ $pedido->descricao }}</p>

    @if(isset($estado_agente) && $estado_agente==2)
        <form id="voucherForm" method="post" action="{{action('PedidosController@uploadVoucher')}}" role="form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="email_cliente" value="{{ $pedido->email_cliente }}">
            <input type="hidden" name="email_agente" value="{{ $email_agente }}">
            <input type="hidden" name="pedido_id" value="{{ $pedido->pedido_id }}">
            <label class="btn btn-outline-dark">
                <input type="file" id="file_voucher" required="required" name="fileToUpload" style="display:none"
                onchange="$('#label_voucher').html(this.files[0].name)">
                Anexar o Voucher...
            </label>
            <span class="label label-info" id="label_voucher"></span>
            <input type="submit" class="btn btn-warning" value="Enviar Voucher" id="envia_voucher">
        </form>
    @elseif(isset($estado_agente) && $estado_agente==3)
        <form id="avaliacaoForm" class="form-inline" method="post" action="{{action('ClienteController@atualizaAvaliacao')}}" role="form">
            @csrf
            <input type="hidden" name="email_cliente" value="{{ $pedido->email_cliente }}">
            <input type="hidden" name="pedido_id" value="{{ $pedido->pedido_id }}">
            <input type="hidden" name="email_agente" value="{{ $email_agente }}">
            <div class="form-group">
                <select class="form-control input-sm" name="nota">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div>&nbsp&nbsp</div>
            <input type="submit" class="btn btn-warning" value="Avaliar Cliente" id="envia_voucher">
        </form>
    @endif

  </div>
</div>
