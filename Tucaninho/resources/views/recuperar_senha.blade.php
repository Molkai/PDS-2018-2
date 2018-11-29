<form method="post" action="{{action('ClienteController@alterarSenha')}}">
    @csrf
    <input type="password" name="pwd">
    <input type="hidden" name="email" value="{{$email}}">
    <button type="submit">Enviar</button>
</form>
