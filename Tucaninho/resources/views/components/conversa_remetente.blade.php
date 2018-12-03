@if($mensagem->isFile)
<div class="card col-xl-6" style="background-color: lightgreen;">
    <div class="col-xl-12">
        <a href="{{action('MensagemController@downloadFile', explode('/', $mensagem->fileName))}}">{{$mensagem->mensagem}}</a>
    </div>
</div>
@else
<div class="card col-xl-6" style="background-color: lightgreen;">
    <div class="col-xl-12">
        <p class="otherText">{{$mensagem->mensagem}}</p>
    </div>
</div>
@endif
