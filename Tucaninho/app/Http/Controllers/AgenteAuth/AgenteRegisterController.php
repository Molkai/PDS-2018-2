<?php

namespace App\Http\Controllers\AgenteAuth;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterAgenteRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Agente;

class AgenteRegisterController extends Controller{
    public function create(RegisterAgenteRequest $request){
        $agente = new Agente;
        $agente->email_agente = $request->email;
        $agente->nome_agente = $request->nome;
        $agente->senha_agente = Hash::make($request->pwd);

        if($agente->save())
            return redirect('/');
        return 'Falha no registro';
    }
}
