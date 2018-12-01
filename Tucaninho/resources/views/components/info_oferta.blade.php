<p class="h4">R$ {{ $oferta->preco }}</p>
<p>{{ $oferta->descricao }}</p>
@if($displayButton==true)
    <small class="text-muted float-right">Posted by {{$oferta->email_agente}}</small>
    <br>
    <button type="button" class="btn btn-warning aceita_oferta" data-oferta="{{action('PedidosController@aceitaOferta', [encrypt($oferta->email_cliente), encrypt($oferta->email_agente), encrypt($oferta->pedido_id), encrypt($oferta->preco)])}}">Aceitar Oferta</button>
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
    <form id="sendMessageForm" method="get" action="#" role="form">
        <div class="row content-center">
            <div class="col-xl-11">
                <div class="form-group">
                    <textarea id="message" name="message" class="form-control message-text" rows="2" required="required" maxlength="1000"></textarea>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-xl-1">
                <div class="form-group">
                    <input type="submit" class="btn btn-warning btn-send btn-send-message" value="enviar" data-id="{{ $oferta->pedido_id }}" data-agente="{{ $oferta->email_agente }}">
                </div>
            </div>
        </div>
    </form>
</div>
<hr>
