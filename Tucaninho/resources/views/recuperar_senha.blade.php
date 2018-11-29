<form method="post" action="{{$usuario=='cliente'?action('ClienteController@alterarSenha'):action('AgenteController@alterarSenha')}}">
    @csrf
    <input type="password" name="pwd">
    <input type="hidden" name="email" value="{{$email}}">
    <button type="submit">Enviar</button>
</form>
