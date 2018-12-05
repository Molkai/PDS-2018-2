<div class="row">
    <div class="col-xl-12 py-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Alterar dados cadastrais</h3>

                <!-- formulário de oferta -->
                <form method="post" action="{{action('AgenteController@alterarDados')}}" role="form" id="form-cadastro">
                    @csrf

                    <div class="controls">

                        <!-- campo -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">email: </label>
                                    <input id="email" class="form-control" name="email" required="required" value="{{isset($agente)?$agente->email_agente:$cliente->email_cliente}}">
                                </div>
                            </div>
                        </div>

                        <!-- campo -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Nome">Nome:</label>
                                    <input class="form-control" type="text" name="name" id="name" required="required" value="{{isset($agente)?$agente->nome_agente:$cliente->nome_cliente}}">
                                </div>
                            </div>
                        </div>

                        <!-- campo -->
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd">Senha:</label>
                                    <input class="form-control" type="password" name="pwd" id="pwd" maxlength="30" required="required" value="{{isset($agente)?$agente->senha_agente:$cliente->senha_cliente}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd2">Confirme a senha:</label>
                                    <input class="form-control" type="password" name="pwd2" id="pwd2" maxlength="30" required="required" value="{{isset($agente)?$agente->senha_agente:$cliente->senha_cliente}}">
                                </div>
                            </div>
                        </div>

                    </div>
                     <input type="hidden" name="email_antigo" id="email_antigo" value="{{isset($agente)?$agente->email_agente:$cliente->email_cliente}}">

                    <button type="submit" id="submeter_oferta" class="btn btn-outline-success">
                        Alterar
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
