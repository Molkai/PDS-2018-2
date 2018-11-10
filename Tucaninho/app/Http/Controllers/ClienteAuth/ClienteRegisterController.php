<?php

namespace App\Http\Controllers\ClienteAuth;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterClienteRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Cliente;

class ClienteRegisterController extends Controller{
  public function create(RegisterClienteRequest $request){
    $cliente = new Cliente;
    $cliente->email_cliente = $request->email;
    $cliente->nome_cliente = $request->nome;
    $cliente->senha_cliente = Hash::make($request->pwd);

    if($cliente->save())
      return redirect('/');
    return 'Falha no registro';
  }
}
