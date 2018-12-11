<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modalClass">
            <div class="modal-header">
                <h5 class="modal-title modalTitle">Login Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeBtn">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="id_logindiv">
                    <form class="form-horizontal" id="formLogin" action="{{action('ClienteAuth\ClienteLoginController@authenticate')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 form-control-static">
                                <input type="email" name="email" class="form-control" id="emailLogin" placeholder="Insira o email aqui" maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 form-control-static">
                                <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Insira a senha aqui" maxlength="30" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-default greenBtn" id="entrar">Entrar</button>
                        </div>
                    </form>
                    <form class="form-horizontal formCadastro" id="formCadastro" method="post" action="{{action('ClienteAuth\ClienteRegisterController@create')}}">
                        @csrf
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 form-control-static">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Insira o email aqui" maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 form-control-static">
                                <input type="text" name="nome" class="form-control" id="nome" placeholder="Insira o seu nome aqui" maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 form-control-static">
                                <input type="password" name="pwd" class="form-control" id="pwdCadastro" placeholder="Insira a senha aqui" maxlength="30" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 form-control-static">
                                <input type="password" name="pwd2" class="form-control" id="pwd2" placeholder="Confirme a sua senha" maxlength="30" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-default greenBtn" id="cadastrar">Cadastrar</button>
                        </div>
                    </form>
                    <form class="form-horizontal formSenha" id="formSenha" method="post" action="{{action('ClienteController@enviaEmailRecCliente')}}">
                        @csrf
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 form-control-static">
                                <input type="email" name="email" class="form-control" id="emailSenha" placeholder="Insira o email aqui" maxlength="100" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-default greenBtn" id="enviar">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default goldBtn loginBtn" id="login">Login</button>
                <button type="button" class="btn btn-default blueBtn" id="esqSenha">Esqueceu a senha?</button>
                <button type="button" class="btn btn-default goldBtn" id="cadastro">Cadastrar-se</button>
            </div>
        </div>
    </div>
</div>
