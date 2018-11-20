<p class="h4">R$ {{ $oferta->preco }}</p>
<p>{{ $oferta->descricao }}</p>
@if($displayButton==true)
    <small class="text-muted float-right">Posted by {{$oferta->email_agente}}</small>
    <br>
    <button type="button" class="btn btn-warning">Aceitar Oferta</button>
    <button type="button" class="btn btn-warning">Mensagens</button>
@else
    <small class="text-muted float-right">Sent to {{$oferta->email_cliente}}</small>
@endif
<hr>
