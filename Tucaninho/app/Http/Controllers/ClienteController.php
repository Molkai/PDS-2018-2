<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecuperarSenha;
use App\Cliente;
use Illuminate\Support\Facades\Hash;

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

    public function enviaEmailRecCliente(Request $request){
        $email = $request->email;

        $cliente = Cliente::where('email_cliente', $email)->first();
        if($cliente==null) return redirect('/');
        $token = str_random(128);
        $cliente->token = $token;
        $cliente->update();

        $url_recuperar = route('cliente.recuperar_senha', ['encrypted_token' => encrypt($token)]);
        $url_cancelar = route('cliente.cancelar_recuperacao', ['encrypted_email_cliente' => encrypt($email)]);

        Mail::to($email)->send(new RecuperarSenha($url_recuperar, $url_cancelar));

        return redirect('/')->with(['success' => 'Email de recuperação enviado com sucesso.']);
    }

    public function recuperarSenha($encrypted_token){
        $token = decrypt($encrypted_token);

        $cliente = Cliente::where('token', $token)->first();

        if($cliente==null) return redirect('/');

        $email_cliente = $cliente->email_cliente;

        $cliente->token = null;

        $cliente->update();

        return view('recuperar_senha')->with(['email' => $email_cliente, 'usuario' => 'cliente']);
    }

    public function cancelarRecSenha($encrypted_email){
        $email = decrypt($encrypted_email);

        $cliente = Cliente::where('email_cliente', $email)->first();

        if($cliente==null || $cliente->token==null) return redirect('/');

        $cliente->token = null;

        $cliente->update();

        return redirect('/')->with(['success' => 'Operação de recuperação de senha cancelada com sucesso.']);
    }

    public function alterarSenha(Request $request){
        $cliente = Cliente::where('email_cliente', $request->email)->first();

        $cliente->senha_cliente = Hash::make($request->pwd);

        $cliente->update();

        return redirect('/')->with(['success' => 'Senha alterada com sucesso.']);
    }

    public function alterarDados(Request $request){
        $cliente = Cliente::where('email_cliente', $request->email)->first();
        if($cliente != null)
            return back()->with(['erro' => 'Já existe esse email.']);
        $cliente = Cliente::where('email_cliente', $request->email_antigo)->first();

        if(isset($request->email))
            $cliente->email_cliente = $request->email;
        if(isset($request->name))
            $cliente->nome_cliente = $request->name;
        if(isset($request->pwd))
            $cliente->senha_cliente = Hash::make($request->pwd);

        $cliente->update();

        return redirect('/')->with(['success' => 'Dados alterados com sucesso.']);
    }

    public function carregaDadosCliente(){
        $cliente = Auth::guard('cliente')->user();

        return view("cliente.content.content_alterar_dados")->with(['cliente' => $cliente]);
    }

    public function atualizaAvaliacao(Request $request){
        $cliente = Cliente::where('email_cliente', $request->email_cliente)->first();

        $cliente->nota = (($cliente->nota*$cliente->qntAvaliacoes)+$request->nota)/($cliente->qntAvaliacoes+1);
        $cliente->qntAvaliacoes += 1;

        $cliente->save();

        $oferta = \App\Oferta::where('pedido_id', $request->pedido_id)
                            ->where('email_cliente', $request->email_cliente)
                            ->where('email_agente', $request->email_agente)
                            ->first();

        $oferta->estado = 4;
        $oferta->save();

        return back();
    }
}
