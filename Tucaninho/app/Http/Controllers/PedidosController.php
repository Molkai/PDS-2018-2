<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pedido;
use App\Oferta;
use Carbon\Carbon;

class PedidosController extends Controller {
    public function listaPedidosCliente(){
        $user = Auth::guard('cliente')->user();
        $pedidos = Pedido::where('email_cliente', $user->email_cliente)
                      ->orderBy('pedido_id', 'desc')
                      ->get();
        return view('cliente.content.content_pedidos')->with('pedidos', $pedidos);
    }

    public function listaPedidosAgente(){
        $pedidos = Pedido::orderBy('pedido_id', 'desc')->orderBy('email_cliente', 'asc')->get();
        return view('agente.content.content_pedidos')->with('pedidos', $pedidos);
    }

    public function cadastraPedido(Request $request){
        $user = Auth::guard('cliente')->user();
        /*
            $s = 'link';
            while(true)
                if(!isset($request[$s.$i]))
                    break;
                Links::create($match)
                $i++
        */
        $dados = ['pedido_id' => Carbon::now('America/Sao_Paulo'), 'email_cliente' => $user->email_cliente, 'url' => $request->link, 'descricao' => $request->descricao, 'qnt_adultos' => $request->qnt_adultos, 'qnt_criancas' => $request->qnt_criancas, 'qnt_bebes' => $request->qnt_bebes, 'tipo_viagem' => $request->tipo_viagem, 'tipo_passagem' => $request->tipo_passagem, 'preferencia'=> $request->preferencia, 'preco' => $request->preco];

        Pedido::create($dados);
        return redirect()->action('PedidosController@listaPedidosCliente');
    }

    public function detalhesPedidoCliente($id){
        $user = Auth::guard('cliente')->user();
        $match = ['pedido_id' => decrypt($id), 'email_cliente' => $user->email_cliente];
        $pedido = Pedido::where($match)->first();
        /*
            $links =  Link::where($match)->get();
        */

        return view('cliente.content.content_detalhes_pedidos')->with('pedido', $pedido);
    }

    public function detalhesPedidoAgente($id, $email){
        $match = ['pedido_id' => decrypt($id), 'email_cliente' => decrypt($email)];
        $pedido = Pedido::where($match)->first();
        /*
        $match['email_agente'] = $user->email_agente;
        $oferta = Oferta::where($match)->first();
        if($oferta!=null)
            return view('agente.content.content_detalhes_pedidos')->with(['pedido' => $pedido[0], 'oferta' => $oferta]);
        */
        return view('agente.content.content_detalhes_pedidos')->with('pedido', $pedido);
    }
}
