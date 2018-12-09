<?php

namespace App\Http\Controllers\ClienteAuth;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterClienteRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Cliente;

class ClienteRegisterController extends Controller{
  public function create(RegisterClienteRequest $request){
        $cliente = new Cliente;
        $cliente->email_cliente = $request->email;
        $cliente->nome_cliente = $request->nome;
        $cliente->senha_cliente = Hash::make($request->pwd);

        $credentials = ['email_cliente' => $request->email, 'password' => $request->pwd];

        if($cliente->save()){
            if(Auth::guard('cliente')->attempt($credentials))
                return redirect('/cliente/pedidos')->with(['success' => 'Usuário cadastrado com sucesso.']);
        }
        return redirect('/')->with(['erro' => 'Ocorreu uma falha durante o registro do usuário.']);
    }
}
