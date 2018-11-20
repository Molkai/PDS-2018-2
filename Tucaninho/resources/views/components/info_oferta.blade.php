<p class="h4">R$ {{ $oferta->preco }}</p>
<p>{{ $oferta->descricao }}</p>
@if($displayButton==true)
    <small class="text-muted float-right">Posted by {{$oferta->email_agente}}</small>
    <br>
    <button type="button" class="btn btn-warning">Aceitar Oferta</button>
@else
    <small class="text-muted float-right">Sent to {{$oferta->email_cliente}}</small>

@endif
<button type="button" class="btn btn-warning" id="messageBtn">Mensagens</button>
<hr>
<div id="messagesDiv">
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
</div>
<hr>
