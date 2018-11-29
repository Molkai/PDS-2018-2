<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pedido;
use App\Mensagem;
use App\Oferta;
use App\Url;
use App\Data;
use App\Http\Requests\PedidoRequest;
use Carbon\Carbon;

class PedidosController extends Controller {
    public function listaPedidosCliente(){
        $user = Auth::guard('cliente')->user();
        $pedidos = Pedido::where('email_cliente', $user->email_cliente)
                      ->orderBy('pedido_id', 'desc')
                      ->get();
        $this->verificaExpirou($pedidos, TRUE);
        return view('cliente.content.content_pedidos')->with('pedidos', $pedidos);
    }

    public function listaPedidosAgente(){
        $pedidos = Pedido::orderBy('pedido_id', 'desc')->orderBy('email_cliente', 'asc')->get();
        $this->verificaExpirou($pedidos, TRUE);
        return view('agente.content.content_pedidos')->with('pedidos', $pedidos);
    }

    public function cadastraPedido(PedidoRequest $request){
        $user = Auth::guard('cliente')->user();
        $pedido_id = Carbon::now('America/Sao_Paulo');

        $dados = ['pedido_id' => $pedido_id, 'email_cliente' => $user->email_cliente, 'descricao' => $request->descricao, 'qnt_adultos' => $request->qnt_adultos, 'qnt_criancas' => $request->qnt_criancas, 'qnt_bebes' => $request->qnt_bebes, 'tipo_viagem' => $request->tipo_viagem, 'tipo_passagem' => $request->tipo_passagem, 'preferencia'=> $request->preferencia, 'preco' => $request->preco, 'expirou' => 0];
        Pedido::create($dados);

        $link = 'link';
        $i = 0;
        while (true) {
            if(!isset($request[$link.$i]))
                break;
            $dados = ['pedido_id' => $pedido_id, 'email_cliente' => $user->email_cliente, 'url' => $request[$link.$i]];
            Url::create($dados);
            $i++;
        }

        $i = 0;
        if($request->tipo_viagem == 2){
            $dados = ['pedido_id' => $pedido_id, 'email_cliente' => $user->email_cliente, 'data' => $request['data'.$i], 'pais' => $request['pais'.$i], 'cidade' => $request['cidade'.$i], 'aeroporto' => $request['aeroporto'.$i], 'paisDestino' => $request['paisDestino'.$i], 'cidadeDestino' => $request['cidadeDestino'.$i], 'aeroportoDestino' => $request['aeroportoDestino'.$i]];
            Data::create($dados);
            $dados = ['pedido_id' => $pedido_id, 'email_cliente' => $user->email_cliente, 'data' => $request['dataRetorno'.$i], 'pais' => $request['paisDestino'.$i], 'cidade' => $request['cidadeDestino'.$i], 'aeroporto' => $request['aeroportoDestino'.$i], 'paisDestino' => $request['pais'.$i], 'cidadeDestino' => $request['cidade'.$i], 'aeroportoDestino' => $request['aeroporto'.$i]];
            Data::create($dados);
            $i++;
        }
        while (true) {
            if(!isset($request['data'.$i]))
                break;
            $dados = ['pedido_id' => $pedido_id, 'email_cliente' => $user->email_cliente, 'data' => $request['data'.$i], 'pais' => $request['pais'.$i], 'cidade' => $request['cidade'.$i], 'aeroporto' => $request['aeroporto'.$i], 'paisDestino' => $request['paisDestino'.$i], 'cidadeDestino' => $request['cidadeDestino'.$i], 'aeroportoDestino' => $request['aeroportoDestino'.$i]];
            Data::create($dados);
            $i++;
        }

        return redirect()->action('PedidosController@listaPedidosCliente');
    }

    public function detalhesPedidoCliente($id){
        $user = Auth::guard('cliente')->user();
        $match = ['pedido_id' => decrypt($id), 'email_cliente' => $user->email_cliente];
        $pedido = Pedido::where($match)->first();
        $links = Url::where($match)->get();
        $ofertas = Oferta::where($match)->get();
        $datas = Data::where($match)->get();
        $m = Mensagem::where($match)->orderBy('mensagem_id', 'asc')->get();
        $mensagens = [];
        foreach ($ofertas as $oferta) {
            $mensagens[$oferta->email_agente] = [];
        }
        foreach ($m as $me) {
            array_push($mensagens[$me->email_agente], $me);
        }

        $this->verificaExpirou($pedido, FALSE);

        return view('cliente.content.content_detalhes_pedidos')->with(['pedido' => $pedido, 'links' => $links, 'ofertas' => $ofertas, 'datas' => $datas, 'mensagens' => $mensagens]);
    }

    public function detalhesPedidoAgente($id, $email){
        $match = ['pedido_id' => decrypt($id), 'email_cliente' => decrypt($email)];
        $pedido = Pedido::where($match)->first();
        $links = Url::where($match)->get();
        $datas = Data::where($match)->get();

        $user = Auth::guard('agente')->user();
        $match['email_agente'] = $user->email_agente;
        $oferta = Oferta::where($match)->first();
        $mensagens = Mensagem::where($match)->orderBy('mensagem_id', 'asc')->get();

        $this->verificaExpirou($pedido, FALSE);

        return view('agente.content.content_detalhes_pedidos')->with(['pedido' => $pedido, 'links' => $links, 'oferta' => $oferta, 'datas' => $datas, 'mensagens' => $mensagens]);
    }

    public function deleteRow(Request $request){
        $match = ['pedido_id' => $request->id, 'email_cliente' => $request->email_cliente];
        $pedido = Pedido::where($match)->first();

        if($pedido==null) return response()->json('Ocoreu um erro.');

        $pedido->delete();

        return response()->json('Sucesso.');
    }

    public function verificaExpirou($pedidos, $collection){
        $date = Carbon::now('America/Sao_Paulo');
        if($collection){
            foreach ($pedidos as $pedido) {
                if($pedido->expirou===FALSE && Carbon::parse($pedido->pedido_id, 'America/Sao_Paulo')->addDay()->lt($date)){
                    $pedido->expirou = TRUE;
                }
            }
        }
        else{
            if($pedidos->expirou===FALSE && Carbon::parse($pedidos->pedido_id, 'America/Sao_Paulo')->addDay()->lt($date)){
                $pedidos->expirou = TRUE;
            }
        }
    }
}
