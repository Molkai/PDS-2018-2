<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cliente;

class ClienteController extends Controller {
    public function logout(){
        Auth::guard('cliente')->logout();
        return redirect('/');
    }

    public function deletar($encrypted_email){
        $email = decrypt($encrypted_email);

        $cliente = Cliente::where('email_cliente', $email)->first();
        if($cliente===null) return redirect()->action('PedidosController@listaPedidosCliente');
        Auth::guard('cliente')->logout();
        $cliente->delete();
        return view('home');
    }
}
