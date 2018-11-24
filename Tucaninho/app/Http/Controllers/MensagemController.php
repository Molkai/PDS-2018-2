<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mensagem;
use Carbon\Carbon;

class MensagemController extends Controller
{
    public function cadastraMensagemCliente(Request $request){
        $user = Auth::guard('cliente')->user();
        $mensagem_id = Carbon::now('America/Sao_Paulo');

        $dados = ['pedido_id' => $request->pedido_id, 'email_cliente' => $user->email_cliente,
                  'email_agente' => $request->email_agente, 'mensagem_id' => $mensagem_id, 'mensagem' => $request->Mensagem, 'isCliente' => true];

        $mensagem = Mensagem::create($dados);

        return response()->json($mensagem);
    }

    public function cadastraMensagemAgente(Request $request){
        $user = Auth::guard('agente')->user();
        $mensagem_id = Carbon::now('America/Sao_Paulo');

        $dados = ['pedido_id' => $request->pedido_id, 'email_cliente' => $request->email_cliente,
                  'email_agente' => $user->email_agente, 'mensagem_id' => $mensagem_id, 'mensagem' => $request->Mensagem, 'isCliente' => false];

        $mensagem = Mensagem::create($dados);

        return response()->json($mensagem);
    }
}
