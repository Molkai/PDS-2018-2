<?php

namespace App\Http\Controllers\AgenteAuth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginUsuarioRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AgenteLoginController extends Controller {
    public function authenticate(LoginUsuarioRequest $request){
      $credentials = ['email_agente' => $request->email, 'password' => $request->pwd];

      if(Auth::guard('agente')->attempt($credentials)) {
        return redirect('/agente/pedidos');
      }

      return redirect('/')->with(['erro' => 'Verifique se seu email está registrado e se sua senha está correta.']);
    }
}
