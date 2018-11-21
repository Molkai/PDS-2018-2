<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Agente;

class AgenteController extends Controller
{
    public function logout(){
        Auth::guard('agente')->logout();
        return redirect('/');
    }

    public function deletar($encrypted_email){
        $email = decrypt($encrypted_email);

        $agente = Agente::where('email_agente', $email)->first();
        if($agente===null) return redirect()->action('PedidosController@listaPedidosAgente');
        Auth::guard('agente')->logout();
        $agente->delete();
        return view('home');
    }
}
