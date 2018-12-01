<html>
    <head>
        <title>Pagamento</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
        <link href='custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body>

        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-lg-offset-2">

                    <h1>Informações do Pagamento </h1>

                    <p class="lead">Preencha os campos abaixo para pode concluir seu pagamento.</p>


                    <form id="contact-form" method="post" action="{{action('PedidosController@confirmaPagamento')}}" role="form">

                        @csrf

                        <div class="messages"></div>

                        <div class="controls">

                            <div>
                                <h2>
                                    <p class="text-muted">Total a pagar<strong> R$ {{$preco}}</strong></p>
                                </h2>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="form_name">Núm. do cartão *</label>
                                        <input id="form_name" type="text" name="numCartao" class="form-control" placeholder="Por favor digite seu primeiro nome *" maxlength="16" required="obrigatório" data-error="Primeiro nome obrigatório.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="form_lastname">Cód. de segurança:</label>
                                        <input id="form_lastname" type="text" name="codSeg" maxlength="3" class="form-control" placeholder="Por favor digite seu Sobrenome *" required="obrigatório" data-error="Sobrenome obrigatório.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-6 form-group">
                                        <label for="form_need">Mês</label>
                                        <select id="form_need" name="mes" class="form-control" required="required" data-error="Você deve escolher uma forma de pagamento!.">
                                            <option value="1">01</option>
                                            <option value="2">02</option>
                                            <option value="3">03</option>
                                            <option value="4">04</option>
                                            <option value="5">05</option>
                                            <option value="6">06</option>
                                            <option value="7">07</option>
                                            <option value="8">08</option>
                                            <option value="9">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="form_need">Ano</label>
                                        <select id="form_need" name="ano" class="form-control" required="required" data-error="Você deve escolher uma forma de pagamento!.">
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_phone">Nome do Titular</label>
                                        <input id="form_phone" type="tel" name="name" class="form-control" placeholder="Por favor digite seu Telefone" required="required">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-warning btn-send" value="Concluir">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-muted"><strong>*</strong> Campos obrigatórios, dúvida contate <a href="https://google.com" target="_blank">Tucaninho</a>.</p>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="email_cliente" value="{{$email_cliente}}">
                        <input type="hidden" name="email_agente" value="{{$email_agente}}">
                        <!--<input type="hidden" name="pedido_id" value="{{$pedido_id}}">-->

                    </form>

                </div><!-- /.8 -->

            </div> <!-- /.row-->

        </div> <!-- /.container-->

        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js" integrity="sha256-dHf/YjH1A4tewEsKUSmNnV05DDbfGN3g7NMq86xgGh8=" crossorigin="anonymous"></script>
        <script src="contact-3.js"></script>
    </body>
</html>
