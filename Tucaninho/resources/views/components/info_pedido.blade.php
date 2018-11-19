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
    <hr>
    <p class="card-text">{{ $pedido->descricao }}</p>

  </div>
</div>
