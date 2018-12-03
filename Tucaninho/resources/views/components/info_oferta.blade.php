<p class="h4">R$ {{ $oferta->preco }}</p>
<p>{{ $oferta->descricao }}</p>
@if($displayButton==true)
    <small class="text-muted float-right">Posted by {{$oferta->email_agente}}</small>
    <br>
    @if($estado=='outro')
        <button type="button" class="btn btn-warning aceita_oferta" data-oferta="{{action('PedidosController@aceitaOferta', [encrypt($oferta->email_cliente), encrypt($oferta->email_agente), encrypt($oferta->pedido_id), encrypt($oferta->preco)])}}">Aceitar Oferta</button>
    @else
        <button type="button" class="btn btn-danger" id="cancela_compra"  data-href="{{action('PedidosController@cancelaCompra', [encrypt($oferta->email_cliente), encrypt($oferta->email_agente), encrypt($oferta->pedido_id)])}}">Cancelar Compra</button>
    @endif
@else
    <small class="text-muted float-right">Sent to {{$oferta->email_cliente}}</small>

@endif
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
