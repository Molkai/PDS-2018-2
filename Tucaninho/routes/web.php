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

    Route::get('/pagamento/{encrypted_email_cliente}/{encrypted_email_agente}/{encrypted_pedido_id}/{encrypted_preco}', 'PedidosController@aceitaOferta');

    Route::post('/pagamento', 'PedidosController@confirmaPagamento');

    Route::get('/cancela_compra/{encrypted_email_cliente}/{encrypted_email_agente}/{encrypted_pedido_id}', 'PedidosController@cancelaCompra');

    Route::get('/cliente/dados_cadastro', 'ClienteController@carregaDadosCliente');

    Route::post('/cliente/atualiza_cadastro', 'ClienteController@alterarDados');

    Route::post('/cliente/avalia', 'AgenteController@atualizaAvaliacao');

    Route::get('/cliente/edita/{encrypted_pedido_id}', 'PedidosController@alteraPedido');

    Route::post('/cliente/edita', 'PedidosController@efetuaAlteracaoPedido');
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

    Route::post('/agente/upload_voucher', 'PedidosController@uploadVoucher');

    Route::get('/agente/dados_cadastro', 'AgenteController@carregaDadosAgente');

    Route::post('/agente/atualiza_cadastro', 'AgenteController@alterarDados');

    Route::post('/agente/avalia', 'ClienteController@atualizaAvaliacao');
});

Route::post('/cliente/login', 'ClienteAuth\ClienteLoginController@authenticate');

Route::post('/cliente/register', 'ClienteAuth\ClienteRegisterController@create');

Route::post('/cliente/recuperar', 'ClienteController@enviaEmailRecCliente');

Route::post('/cliente/alterar_senha', 'ClienteController@alterarSenha');

Route::post('/agente/login', 'AgenteAuth\AgenteLoginController@authenticate');

Route::post('/agente/register', 'AgenteAuth\AgenteRegisterController@create');

Route::post('/agente/recuperar', 'AgenteController@enviaEmailRecAgente');

Route::post('/agente/alterar_senha', 'AgenteController@alterarSenha');

Route::get('/cliente/recuperar/{encrypted_token}', 'ClienteController@recuperarSenha')->name('cliente.recuperar_senha');

Route::get('/cliente/cancelar_rec/{encrypted_email}', 'ClienteController@cancelarRecSenha')->name('cliente.cancelar_recuperacao');

Route::get('/agente/recuperar/{encrypted_token}', 'AgenteController@recuperarSenha')->name('agente.recuperar_senha');

Route::get('/agente/cancelar_rec/{encrypted_email}', 'AgenteController@cancelarRecSenha')->name('agente.cancelar_recuperacao');

Route::get('/download_file/{cliente}/{agente}/{pedido_id}/{fileName}', 'MensagemController@downloadFile');

Route::get('/download_voucher/{cliente}/{agente}/{pedido_id}/{fileName}', 'PedidosController@downloadVoucher');
