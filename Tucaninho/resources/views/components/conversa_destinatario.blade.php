@if($mensagem->isFile)
<div class="card col-xl-6 offset-xl-6" style="background-color: lightgray;">
    <div class="col-xl-12" align="right">
        <a href="{{action('MensagemController@downloadFile', explode('/', $mensagem->fileName))}}">{{$mensagem->mensagem}}</a>
    </div>
</div>
@else
<div class="card col-xl-6 offset-xl-6" style="background-color: lightgray;">
    <div class="col-xl-12" align="right">
        <p class="otherText">{{$mensagem->mensagem}}</p>
    </div>
</div>
@endif
