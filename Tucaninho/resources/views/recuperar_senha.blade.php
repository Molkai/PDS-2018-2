<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Tucaninho</title>

        <!-- Bootstrap core CSS -->
        <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

        <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/animation.css')}}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

        <!-- Custom styles for this template -->
        <link href="{{asset('home/css/agency.min.css')}}" rel="stylesheet">

        <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>

        <!-- Plugin JavaScript -->
        <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

        <script src="{{asset('js/bootstrap-notify.min.js')}}"></script>

        <script type="text/javascript">

            $(document).ready(function(){
                $("#formSenha").submit(function compSenha(event){
                    if($("#pwd").val() != $("#pwd2").val()){
                        $("#pwd").val("");
                        $("#pwd2").val("");
                        alert("As senhas são diferentes!");
                        event.preventDefault();
                    }
                });
            });

        </script>
    </head>

    <body>
        <div class="row text-center">
            <div class="col-lg-12">
                <img src="{{asset('home/letoucanv5.png')}}" width="100" height="auto" alt="">
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-12">
                <p style="font-family:'Kaushan Script';font-size: 40px">Tucaninho</p>
            </div>
        </div>
        <div class="row" align="center">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2>Altere a senha da sua conta</h2>
                        </div>
                    </div>
                    <form class="form-horizontal" id="formSenha" method="post" action="{{$usuario=='cliente'?action('ClienteController@alterarSenha'):action('AgenteController@alterarSenha')}}">
                        @csrf
                        <div class="form-group">
                            <p>Nova senha</p>
                            <div class="col-xl-5 col-lg-5 form-control-static">
                                <input class="form-control" type="password" name="pwd" id="pwd" maxlength="30" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <p>Confirme a senha</p>
                            <div class="col-xl-5 col-lg-5 form-control-static">
                                <input class="form-control" type="password" name="pwd2" id="pwd2" maxlength="30" required="required">
                            </div>
                        </div>
                        <input type="hidden" name="email" value="{{$email}}">
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning btn-send">Enviar</button>
                        </div>
                    </form>
                    <br>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript -->
        <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

        <!-- Custom scripts for this template -->
        <script src="{{asset('home/js/agency.min.js')}}"></script>

    </body>
</html>

