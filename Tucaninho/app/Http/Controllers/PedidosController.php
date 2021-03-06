<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pedido;
use App\Mensagem;
use App\Oferta;
use App\Url;
use App\Data;
use App\Cliente;
use App\Agente;
use App\Http\Requests\PedidoRequest;
use Carbon\Carbon;
use Storage;
use Session;

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
        foreach ($pedidos as $pedido) {
            $cliente = Cliente::where('email_cliente', $pedido->email_cliente)->first();
            if($cliente->qntAvaliacoes==0)
                $pedido['nota'] = 'Sem Avaliações';
            else
                $pedido['nota'] = $cliente->nota;
        }
        return view('agente.content.content_pedidos')->with('pedidos', $pedidos);
    }

    public function cadastraPedido(PedidoRequest $request){
        $user = Auth::guard('cliente')->user();
        $pedido_id = Carbon::now('America/Sao_Paulo');

        $dados = ['pedido_id' => $pedido_id, 'email_cliente' => $user->email_cliente, 'descricao' => $request->descricao, 'qnt_adultos' => $request->qnt_adultos, 'qnt_criancas' => $request->qnt_criancas, 'qnt_bebes' => $request->qnt_bebes, 'tipo_viagem' => $request->tipo_viagem, 'tipo_passagem' => $request->tipo_passagem, 'preferencia'=> $request->preferencia, 'preco' => $request->preco];
        Pedido::create($dados);

        $link = 'link';
        $i = 0;
        while (isset($request[$link.$i])) {
            $url_exists = Url::where('pedido_id', $pedido_id)
                            ->where('email_cliente', $user->email_cliente)
                            ->where('url', $request[$link.$i])
                            ->exists();
            if(!$url_exists){
                $dados = ['pedido_id' => $pedido_id, 'email_cliente' => $user->email_cliente, 'url' => $request[$link.$i]];
                Url::create($dados);
            }
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

        Session::put('success', 'Pedido registrado com sucesso.');

        return redirect()->action('PedidosController@detalhesPedidoCliente', [encrypt($pedido_id)]);
    }

    public function detalhesPedidoCliente($id){
        $user = Auth::guard('cliente')->user();
        $match = ['pedido_id' => decrypt($id), 'email_cliente' => $user->email_cliente];
        $pedido = Pedido::where($match)->first();
        $links = Url::where($match)->get();
        if($pedido->estado==2){
            $ofertas = Oferta::where($match)->where('estado', 2)->get();
            $m = Mensagem::where($match)->where('email_agente', $ofertas[0]->email_agente)->orderBy('mensagem_id', 'asc')->get();
        }
        else{
            $ofertas = Oferta::where($match)->get();
            $m = Mensagem::where($match)->orderBy('mensagem_id', 'asc')->get();
        }
        $datas = Data::where($match)->get();
        $mensagens = [];
        foreach ($ofertas as $oferta) {
            $mensagens[$oferta->email_agente] = [];
            $agente = Agente::where('email_agente', $oferta->email_agente)->first();
            if($agente->qntAvaliacoes==0)
                $oferta['nota'] = 'Sem Avaliações';
            else
                $oferta['nota'] = $agente->nota;
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
        if($oferta!=null){
            $cliente = Cliente::where('email_cliente', $oferta->email_cliente)->first();
            if($cliente->qntAvaliacoes==0)
                $oferta['nota'] = 'Sem Avaliações';
            else
                $oferta['nota'] = $cliente->nota;
        }
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

    public function aceitaOferta($encrypted_email_cliente, $encrypted_email_agente, $encrypted_pedido_id, $encrypted_preco){
        return view('pagamento')->with(['email_cliente' => decrypt($encrypted_email_cliente), 'email_agente' => decrypt($encrypted_email_agente), 'pedido_id' => decrypt($encrypted_pedido_id), 'preco' => decrypt($encrypted_preco)]);
    }

    public function confirmaPagamento(Request $request){
        $email_cliente = $request->email_cliente;
        $email_agente = $request->email_agente;
        $pedido_id = $request->pedido_id;

        $pedido = Pedido::where('email_cliente', $email_cliente)
                        ->where('pedido_id', $pedido_id)
                        ->first();
        $pedido->estado = 2;
        $pedido->save();

        $oferta = Oferta::where('email_agente', $email_agente)
                        ->where('email_cliente', $email_cliente)
                        ->where('pedido_id', $pedido_id)
                        ->first();
        $oferta->estado = 2;
        $oferta->save();

        Session::put('success', 'Pagamento confirmado.');

        return redirect()->action('PedidosController@detalhesPedidoCliente', [encrypt($pedido_id)]);
    }

    public function cancelaCompra($encrypted_email_cliente, $encrypted_email_agente, $encrypted_pedido_id){
        $email_cliente = decrypt($encrypted_email_cliente);
        $email_agente = decrypt($encrypted_email_agente);
        $pedido_id = decrypt($encrypted_pedido_id);

        $pedido = Pedido::where('email_cliente', $email_cliente)
                        ->where('pedido_id', $pedido_id)
                        ->first();
        $pedido->estado = 0;
        $pedido->save();

        $oferta = Oferta::where('email_agente', $email_agente)
                        ->where('email_cliente', $email_cliente)
                        ->where('pedido_id', $pedido_id)
                        ->first();
        $oferta->estado = 0;
        $oferta->save();

        return back()->with('success', 'Compra cancelada.');
    }

    public function uploadVoucher(Request $request){
        $email_cliente = $request->email_cliente;
        $email_agente = $request->email_agente;
        $pedido_id = $request->pedido_id;

        $pedido = Pedido::where('pedido_id', $pedido_id)
                        ->where('email_cliente', $email_cliente)
                        ->first();

        if(!$request->hasFile('fileToUpload') || !$request->file('fileToUpload')->isValid())
            return back()->with('erro', 'Ocorreu um erro no envio do voucher.');

        $file = $request->file('fileToUpload');

        $path = $file->store('/'.str_replace(['@', '.'], ['', ''], $email_cliente).'/'.str_replace(['@', '.'], ['', ''], $email_agente).'/'.str_replace([' ', '-', ':'], ['', '', ''],$pedido_id), 'dropbox');

        $pedido->fileName = $file->getClientOriginalName();
        $pedido->filePath = $path;
        $pedido->estado = 3;
        $pedido->save();

        $oferta = Oferta::where('pedido_id', $pedido_id)
                        ->where('email_cliente', $email_cliente)
                        ->where('email_agente', $email_agente)
                        ->first();

        $oferta->estado=3;
        $oferta->save();

        Oferta::where('pedido_id', $pedido_id)
                ->where('email_cliente', $email_cliente)
                ->where('estado', '<>', 3)
                ->delete();

        return back()->with('success', 'Voucher enviado com sucesso.');
    }

    public function downloadVoucher($cliente, $agente, $pedido_id, $fileName){
        return Storage::disk('dropbox')->download($cliente.'/'.$agente.'/'.$pedido_id.'/'.$fileName);
    }

    public function alteraPedido($encrypted_pedido_id){
        $pedido_id = decrypt($encrypted_pedido_id);
        $user = Auth::guard('cliente')->user();

        $pedido = Pedido::where('email_cliente', $user->email_cliente)
                        ->where('pedido_id', $pedido_id)
                        ->first();

        $links = Url::where('email_cliente', $user->email_cliente)
                        ->where('pedido_id', $pedido_id)
                        ->get();

        $datas = Data::where('email_cliente', $user->email_cliente)
                        ->where('pedido_id', $pedido_id)
                        ->get();

        if($pedido==null) return back()->with('erro', 'O pedido procurado não foi encontrado.');

        return view('cliente.content.content_novo_pedido')->with(['pedido' => $pedido, 'datas' => $datas, 'links' => $links]);
    }

    public function efetuaAlteracaoPedido(PedidoRequest $request){
        $user = Auth::guard('cliente')->user();
        $pedido_id = $request->pedido_id;

        $pedido = Pedido::where('email_cliente', $user->email_cliente)
                        ->where('pedido_id', $pedido_id)
                        ->first();



        $dados = ['descricao' => $request->descricao, 'qnt_adultos' => $request->qnt_adultos, 'qnt_criancas' => $request->qnt_criancas, 'qnt_bebes' => $request->qnt_bebes, 'tipo_viagem' => $request->tipo_viagem, 'tipo_passagem' => $request->tipo_passagem, 'preferencia'=> $request->preferencia, 'preco' => $request->preco];
        $pedido->update($dados);

        $link = 'link';
        $i = 0;
        Url::where('pedido_id', $pedido_id)
            ->where('email_cliente', $user->email_cliente)
            ->delete();
        while (isset($request[$link.$i])) {
            $url_exists = Url::where('pedido_id', $pedido_id)
                            ->where('email_cliente', $user->email_cliente)
                            ->where('url', $request[$link.$i])
                            ->exists();
            if(!$url_exists){
                $dados = ['pedido_id' => $pedido_id, 'email_cliente' => $user->email_cliente, 'url' => $request[$link.$i]];
                Url::create($dados);
            }
            $i++;
        }

        $i = 0;
        Data::where('pedido_id', $pedido_id)
            ->where('email_cliente', $user->email_cliente)
            ->delete();
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

        Session::put('success', 'Pedido alterado com sucesso.');

        return redirect()->action('PedidosController@detalhesPedidoCliente', [encrypt($pedido_id)]);
    }

    public function verificaExpirou($pedidos, $collection){
        $date = Carbon::now('America/Sao_Paulo');
        if($collection){
            foreach ($pedidos as $pedido) {
                if($pedido->estado==0 && Carbon::parse($pedido->pedido_id, 'America/Sao_Paulo')->addDay()->lt($date)){
                    $pedido->estado = 1;
                }
            }
        }
        else{
            if($pedidos->estado==0 && Carbon::parse($pedidos->pedido_id, 'America/Sao_Paulo')->addDay()->lt($date)){
                $pedidos->estado = 1;
            }
        }
    }
}
