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

    public function deletaOferta(Request $request){
        $match = ['pedido_id' => $request->id, 'email_cliente' => $request->email_cliente, 'email_agente' => $request->email_agente];

        $oferta = Oferta::where($match)->first();

        if($oferta==null) return response()->json('Ocorreu um erro.');

        $oferta->delete();

        return response()->json('Sucesso.');
    }

    public function atualizaOferta(OfertaRequest $request){
        $user = Auth::guard('agente')->user();

        $dados = ['descricao' => $request->descricao, 'preco' => $request->preco];

        $oferta = Oferta::where('pedido_id', $request->pedido_id)
                        ->where('email_cliente', $request->email_cliente)
                        ->where('email_agente', $user->email_agente)
                        ->first();

        $oferta->update($dados);

        return redirect()->action('PedidosController@detalhesPedidoAgente', [encrypt($request->pedido_id), encrypt($request->email_cliente)]);
    }
}
