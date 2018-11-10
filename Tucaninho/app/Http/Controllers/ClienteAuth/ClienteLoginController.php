<?php

namespace App\Http\Controllers\ClienteAuth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginUsuarioRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClienteLoginController extends Controller
{
    public function authenticate(LoginUsuarioRequest $request){
      $credentials = ['email_cliente' => $request->email, 'password' => $request->pwd];

      if(Auth::guard('cliente')->attempt($credentials)) {
        return redirect('/cliente/pedidos');
      }

      return redirect('/');
    }
}
