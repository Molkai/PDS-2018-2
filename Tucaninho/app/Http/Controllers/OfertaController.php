<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Oferta;
use App\Http\Requests\OfertaRequest;

class OfertaController extends Controller {
    public function cadastraOferta(OfertaRequest $request){
        $user = Auth::guard('agente')->user();

        $dados = ['pedido_id' => $request->pedido_id, 'email_cliente' => $request->email_cliente,
                  'email_agente' => $user->email_agente, 'descricao' => $request->descricao, 'preco' => $request->preco];

        Oferta::create($dados);

        return redirect()->action('PedidosController@listaPedidosAgente');
    }
}
