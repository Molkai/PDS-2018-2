<?php

namespace App\Http\Controllers\AgenteAuth;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterAgenteRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Agente;

class AgenteRegisterController extends Controller{
    public function create(RegisterAgenteRequest $request){
        $agente = new Agente;
        $agente->email_agente = $request->email;
        $agente->nome_agente = $request->nome;
        $agente->senha_agente = Hash::make($request->pwd);

        $credentials = ['email_agente' => $request->email, 'password' => $request->pwd];

        if($agente->save()){
            if(Auth::guard('agente')->attempt($credentials))
                return redirect('/agente/pedidos')->with(['success' => 'Usuário cadastrado com sucesso.']);
        }
        return redirect('/')->with(['erro' => 'Ocorreu uma falha durante o registro do usuário.']);
    }
}
