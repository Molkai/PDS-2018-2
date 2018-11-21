<p class="h4">R$ {{ $oferta->preco }}</p>
<p>{{ $oferta->descricao }}</p>
@if($displayButton==true)
    <small class="text-muted float-right">Posted by {{$oferta->email_agente}}</small>
    <br>
    <button type="button" class="btn btn-warning">Aceitar Oferta</button>
@else
    <small class="text-muted float-right">Sent to {{$oferta->email_cliente}}</small>

@endif
<button type="button" class="btn btn-warning messageBtn">Mensagens</button>
<hr>
<div class="messagesDiv">
    @include('components.conversa_remetente')
    <br>
    @include('components.conversa_destinatario')
    <hr>
    <form id="sendMessageForm" method="post" action="#" role="form">
        <div class="row content-center">
            <div class="col-xl-11">
                <div class="form-group">
                    <textarea id="message" name="message" class="form-control" rows="2" required="required" maxlength="1000"></textarea>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-xl-1">
                <div class="form-group">
                    <input type="submit" class="btn btn-warning btn-send" value="enviar">
                </div>
            </div>
        </div>
    </form>
</div>
<hr>
