<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mensagem;
use Carbon\Carbon;
use Storage;

class MensagemController extends Controller
{
    public function cadastraMensagemCliente(Request $request){
        $user = Auth::guard('cliente')->user();
        $mensagem_id = Carbon::now('America/Sao_Paulo');

        $dados = ['pedido_id' => $request->pedido_id, 'email_cliente' => $user->email_cliente,
                  'email_agente' => $request->email_agente, 'mensagem_id' => $mensagem_id, 'isCliente' => true];

        if(!$request->hasFile('fileToUpload')){
            $dados['mensagem'] = $request->Mensagem;
        }

        else{
            $file = $request->file('fileToUpload');
            if(!$file->isValid()) return null;

            $path = $file->store('/'.str_replace(['@', '.'], ['', ''], $user->email_cliente).'/'.str_replace(['@', '.'], ['', ''], $request->email_agente).'/'.str_replace([' ', '-', ':'], ['', '', ''],$request->pedido_id), 'dropbox');

            $dados['mensagem'] = $file->getClientOriginalName();
            $dados['isFile'] = true;
            $dados['fileName'] = $path;
        }

        $mensagem = Mensagem::create($dados);

        return response()->json($mensagem);
    }

    public function cadastraMensagemAgente(Request $request){
        $user = Auth::guard('agente')->user();
        $mensagem_id = Carbon::now('America/Sao_Paulo');

        $dados = ['pedido_id' => $request->pedido_id, 'email_cliente' => $request->email_cliente,
                  'email_agente' => $user->email_agente, 'mensagem_id' => $mensagem_id, 'isCliente' => false];

        if(!$request->hasFile('fileToUpload')){
            $dados['mensagem'] = $request->Mensagem;
        }

        else{
            $file = $request->file('fileToUpload');
            if(!$file->isValid()) return null;

            $path = $file->store('/'.str_replace(['@', '.'], ['', ''], $request->email_cliente).'/'.str_replace(['@', '.'], ['', ''], $user->email_agente).'/'.str_replace([' ', '-', ':'], ['', '', ''],$request->pedido_id), 'dropbox');

            $dados['mensagem'] = $file->getClientOriginalName();
            $dados['isFile'] = true;
            $dados['fileName'] = $path;
        }

        $mensagem = Mensagem::create($dados);

        return response()->json($mensagem);
    }

    public function downloadFile($cliente, $agente, $pedido_id, $fileName){
        return Storage::disk('dropbox')->download($cliente.'/'.$agente.'/'.$pedido_id.'/'.$fileName);
    }
}
