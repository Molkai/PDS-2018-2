<div class="modal fade" id="modalAgenteLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modalAgenteId">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgenteTitle">Login Agente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeBtnAgente">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="id_loginAgentdiv">
                    <form class="form-horizontal" id="formLoginAgente" action="{{action('AgenteAuth\AgenteLoginController@authenticate')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 form-control-static">
                                <input type="email" name="email" class="form-control" id="emailLoginAgente" placeholder="Insira o email aqui" maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 form-control-static">
                                <input type="password" name="pwd" class="form-control" id="pwdAgente" placeholder="Insira a senha aqui" maxlength="30" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-default" id="entrar">Entrar</button>
                        </div>
                    </form>
                    <form class="form-horizontal" id="formCadastroAgente" method="post" action="{{action('AgenteAuth\AgenteRegisterController@create')}}">
                        @csrf
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 form-control-static">
                            <input type="email" name="email" class="form-control" id="emailAgente" placeholder="Insira o email aqui" maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 form-control-static">
                                <input type="text" name="nome" class="form-control" id="nomeAgente" placeholder="Insira o seu nome aqui" maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 form-control-static">
                                <input type="password" name="pwd" class="form-control" id="pwdCadastroAgente" placeholder="Insira a senha aqui" maxlength="30" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 form-control-static">
                                <input type="password" name="pwd2" class="form-control" id="pwd2Agente" placeholder="Confirme a sua senha" maxlength="30" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-default" id="cadastrar">Cadastrar</button>
                        </div>
                    </form>
                    <form class="form-horizontal" id="formSenhaAgente" method="post" action="{{action('AgenteController@enviaEmailRecAgente')}}">
                        @csrf
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 form-control-static">
                                <input type="email" name="email" class="form-control" id="emailSenhaAgente" placeholder="Insira o email aqui" maxlength="100" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-default" id="enviar">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="fa-stack fa-lg" id="facebookIcon">
                    <i class="far fa-circle fa-stack-2x""></i>
                    <i class="fab fa-facebook-f fa-stack-1x fa-inverse" id="fbF"></i>
                </a>
                <button type="button" class="btn btn-default" id="loginAgente">Login</button>
                <button type="button" class="btn btn-default" id="esqSenhaAgente">Esqueceu a senha?</button>
                <button type="button" class="btn btn-default" id="cadastroAgente">Cadastrar-se</button>
            </div>
        </div>
    </div>
</div>
