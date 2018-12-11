<p class="h4">R$ {{ $oferta->preco }}</p>
<p>{{ $oferta->descricao }}</p>
@if($displayButton==true)
    <small class="text-muted float-right">Postado por {{$oferta->email_agente}} - {{$oferta->nota}}</small>
    <br>
    @if($estado==0||$estado==1)
        <button type="button" class="btn btn-warning aceita_oferta" data-oferta="{{action('PedidosController@aceitaOferta', [encrypt($oferta->email_cliente), encrypt($oferta->email_agente), encrypt($oferta->pedido_id), encrypt($oferta->preco)])}}">Aceitar Oferta</button>
    @elseif($estado==2)
        <button type="button" class="btn btn-danger" id="cancela_compra"  data-href="{{action('PedidosController@cancelaCompra', [encrypt($oferta->email_cliente), encrypt($oferta->email_agente), encrypt($oferta->pedido_id)])}}">Cancelar Compra</button>
    @elseif($estado==3)
        <form id="avaliacaoForm" class="form-inline" method="post" action="{{action('AgenteController@atualizaAvaliacao')}}" role="form">
            @csrf
            <input type="hidden" name="email_cliente" value="{{ $oferta->email_cliente }}">
            <input type="hidden" name="email_agente" value="{{ $oferta->email_agente }}">
            <input type="hidden" name="pedido_id" value="{{ $oferta->pedido_id }}">
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
            <input type="submit" class="btn btn-warning" value="Avaliar Agente" id="envia_voucher">
        </form>
    @endif
@else
    <small class="text-muted float-right">Enviado para {{$oferta->email_cliente}} - {{$oferta->nota}}</small>

@endif
<br>
<button type="button" class="btn btn-warning messageBtn">Mensagens</button>
<div class="messagesDiv">
    <div class="messagesCardsDiv">
        @foreach($mensagens as $mensagem)
            @if($mensagem->isCliente == $isCliente)
                <br>
                @include('components.conversa_remetente', ['mensagem' => $mensagem])
            @else
                <br>
                @include('components.conversa_destinatario', ['mensagem' => $mensagem])
            @endif
        @endforeach
    </div>
    <hr>
    <form id="sendMessageForm" class="sendMessageForm" method="post" action="#" role="form" enctype="multipart/form-data">
        @csrf
        <div class="row content-center">
            <div class="col-xl-11">
                <div class="form-group">
                    <textarea id="message" name="message" class="form-control message-text" rows="2" required="required" maxlength="1000"></textarea>
                    <div class="help-block with-errors"></div>
                    <label class="btn btn-outline-dark">
                        <input type="file" class="fileToUpload" value="" name="fileToUpload" style="display:none"
                        onchange="$('.label-info:eq('+$('.fileToUpload').index($(this))+')').html(this.files[0].name)">
                        Anexar um arquivo...
                    </label>
                    <span class="label label-info"></span>
                </div>
            </div>
            <input type="hidden" name="email_cliente" value="{{ $oferta->email_cliente }}">
            <input type="hidden" name="email_agente" value="{{ $oferta->email_agente }}">
            <input type="hidden" name="pedido_id" value="{{ $oferta->pedido_id }}">
            <div class="col-xl-1">
                <div class="form-group">
                    <input type="submit" class="btn btn-warning btn-send btn-send-message" value="enviar" data-id="{{ $oferta->pedido_id }}" data-agente="{{ $oferta->email_agente }}">
                </div>
            </div>
        </div>
    </form>
</div>
<hr>
