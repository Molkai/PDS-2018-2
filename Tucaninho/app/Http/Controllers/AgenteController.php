<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\RecuperarSenha;
use App\Agente;
use Session;

class AgenteController extends Controller
{
    public function logout(){
        Auth::guard('agente')->logout();
        return redirect('/');
    }

    public function deletar($encrypted_email){
        $email = decrypt($encrypted_email);

        $agente = Agente::where('email_agente', $email)->first();
        if($agente===null){
            Session::put('erro', 'Falha ao excluir a conta.');
            return redirect()->action('PedidosController@listaPedidosAgente');
        }
        Auth::guard('agente')->logout();
        $agente->delete();
        return redirect('/')->with('success', 'Conta deletada com sucesso.');
    }

    public function enviaEmailRecAgente(Request $request){
        $email = $request->email;

        $agente = Agente::where('email_agente', $email)->first();
        if($agente==null) return redirect('/')->with('erro', 'Verifique se a conta está registrada.');
        $token = str_random(128);
        $agente->token = $token;
        $agente->update();

        $url_recuperar = route('agente.recuperar_senha', ['encrypted_token' => encrypt($token)]);
        $url_cancelar = route('agente.cancelar_recuperacao', ['encrypted_email_cliente' => encrypt($email)]);

        Mail::to($email)->send(new RecuperarSenha($url_recuperar, $url_cancelar));

        return redirect('/')->with(['success' => 'Email de recuperação enviado com sucesso.']);
    }

    public function recuperarSenha($encrypted_token){
        $token = decrypt($encrypted_token);

        $agente = Agente::where('token', $token)->first();

        if($agente==null) return redirect('/')->with('erro', 'Ocorreu um erro na recuperação da senha.');

        $email_agente = $agente->email_agente;

        $agente->token = null;

        $agente->update();

        return view('recuperar_senha')->with(['email' => $email_agente, 'usuario' => 'agente']);
    }

    public function cancelarRecSenha($encrypted_email){
        $email = decrypt($encrypted_email);

        $agente = Agente::where('email_agente', $email)->first();

        if($agente==null || $agente->token==null) return redirect('/')->with('erro', 'Ocorreu um erro no cancelamento da recuperação de senha.');

        $agente->token = null;

        $agente->update();

        return redirect('/')->with(['success' => 'Operação de recuperação de senha cancelada com sucesso.']);
    }

    public function alterarSenha(Request $request){
        $agente = Agente::where('email_agente', $request->email)->first();

        $agente->senha_agente = Hash::make($request->pwd);

        $agente->update();

        return redirect('/')->with(['success' => 'Senha alterada com sucesso.']);
    }

    public function alterarDados(Request $request){
        if(strcmp($request->nome_antigo, $request->name) == 0)
            $request->name = null;
        if(strcmp($request->email_antigo, $request->email) == 0)
            $request->email = null;
        else{
            $agente = Agente::where('email_agente', $request->email)->first();
            if($agente != null)
                return back()->with(['erro' => 'Já existe esse email.']);
        }
        $agente = Agente::where('email_agente', $request->email_antigo)->first();

        if(!isset($request->email) && !isset($request->name) && !isset($request->pwd))
            return back()->with(['erro' => 'Nada foi alterado.']);
        if(isset($request->email))
            $agente->email_agente = $request->email;
        if(isset($request->name))
            $agente->nome_agente = $request->name;
        if(isset($request->pwd))
            $agente->senha_agente = Hash::make($request->pwd);

        $agente->update();

        return redirect('/')->with(['success' => 'Dados alterados com sucesso.']);
    }

    public function carregaDadosAgente(){
        $agente = Auth::guard('agente')->user();

        return view("agente.content.content_alterar_dados")->with(['agente' => $agente]);
    }

    public function atualizaAvaliacao(Request $request){
        $agente = Agente::where('email_agente', $request->email_agente)->first();

        $agente->nota = (($agente->nota*$agente->qntAvaliacoes)+$request->nota)/($agente->qntAvaliacoes+1);
        $agente->qntAvaliacoes += 1;

        $agente->save();

        $pedido = \App\Pedido::where('pedido_id', $request->pedido_id)
                            ->where('email_cliente', $request->email_cliente)
                            ->first();

        $pedido->estado = 4;
        $pedido->save();

        return back()->with('success', 'Avaliação enviada com sucesso.');
    }
}
