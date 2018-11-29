<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::middleware('clienteAuth')->group(function(){
  Route::get('/cliente/pedidos', 'PedidosController@listaPedidosCliente');

  Route::get('/cliente/logout', 'ClienteController@logout');

  Route::get('/cliente/deletar/{encrypted_email}', 'ClienteController@deletar');

  Route::get('/cliente/pedidos/detalhes/{id}', 'PedidosController@detalhesPedidoCliente');

  Route::get('/cliente/novo', function(){
      return view('cliente.content.content_novo_pedido');
  });

  Route::post('/cliente/cria_mensagem', 'MensagemController@cadastraMensagemCliente');

  Route::post('/cliente/novo', 'PedidosController@cadastraPedido');

  Route::post('/cliente/remove_row', 'PedidosController@deleteRow');
});

Route::middleware('agenteAuth')->group(function(){
    Route::get('/agente/pedidos', 'PedidosController@listaPedidosAgente');

    Route::get('/cliente/pedidos/detalhes/{email}/{id}', 'PedidosController@detalhesPedidoAgente');

    Route::post('agente/novo', 'OfertaController@cadastraOferta');

    Route::post('agente/atualiza', 'OfertaController@atualizaOferta');

    Route::get('/agente/logout', 'AgenteController@logout');

    Route::get('/agente/deletar/{encrypted_email}', 'AgenteController@deletar');

    Route::post('/agente/deleta_oferta', 'OfertaController@deletaOferta');

    Route::post('/agente/cria_mensagem', 'MensagemController@cadastraMensagemAgente');
});

Route::post('/cliente/login', 'ClienteAuth\ClienteLoginController@authenticate');

Route::post('/cliente/register', 'ClienteAuth\ClienteRegisterController@create');

Route::post('/cliente/recuperar', 'ClienteController@enviaEmailRecCliente');

Route::post('/cliente/alterar_senha', 'ClienteController@alterarSenha');

Route::post('/agente/login', 'AgenteAuth\AgenteLoginController@authenticate');

Route::post('/agente/register', 'AgenteAuth\AgenteRegisterController@create');

Route::get('/cliente/recuperar/{encrypted_token}', 'ClienteController@recuperarSenha')->name('cliente.recuperar_senha');

Route::get('/cliente/cancelar_rec/{encrypted_email}', 'ClienteController@cancelarRecSenha')->name('cliente.cancelar_recuperacao');
