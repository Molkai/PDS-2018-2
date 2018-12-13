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

    <!-- Custom fonts for this template -->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/animation.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="{{asset('home/css/agency.min.css')}}" rel="stylesheet">

    <!-- Login popup style -->
    <link href="{{asset('css/myModal.css')}}" rel="stylesheet">

    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <script src="{{asset('js/bootstrap-notify.min.js')}}"></script>

    <script>
    $(document).ready(function(){
        $("#formCadastro").submit(function compSenha(event){
            if($("#pwdCadastro").val() != $("#pwd2").val()){
                $("#pwdCadastro").val("");
                $("#pwd2").val("");
                alert("As senhas são diferentes!");
                event.preventDefault();
            }
        });

        $("#formCadastroAgente").submit(function compSenha(event){
            if($("#pwdCadastroAgente").val() != $("#pwd2Agente").val()){
                $("#pwdCadastroAgente").val("");
                $("#pwd2Agente").val("");
                alert("As senhas são diferentes!");
                event.preventDefault();
            }
        });

        @if($errors->any())
            $.notify({
                // options
                icon: 'fas fa-exclamation-circle',
                title: '<strong>Erro:</strong>',
                message: '{{$errors->first()}}'
            },{
                // settings
                type: 'danger'
            });
        @endif

        @if(session()->has('success'))
            $.notify({
                // options
                icon: 'fas fa-check-circle',
                title: '<strong>Concluido:</strong>',
                message: '{{session()->pull("success")}}'
            },{
                // settings
                type: 'success'
            });
        @endif

        @if(session()->has('erro'))
            $.notify({
                // options
                icon: 'fas fa-exclamation-circle',
                title: '<strong>Erro:</strong>',
                message: '{{session()->pull("erro")}}'
            },{
                // settings
                type: 'danger'
            });
        @endif
    });

    function modalFunction(){
        $("#exampleModalLong").modal('show');

        $("#closeBtn").click(function(){
            $(".modal").hide();
            $("#formLogin").show();
            $("#esqSenha").show();
            $("#cadastro").show();
            $("#formCadastro").hide();
            $("#formSenha").hide();
            $("#login").hide();

        });

        $("#cadastro").click(function(){
            $("#formLogin").hide();
            $("#esqSenha").hide();
            $("#cadastro").hide();
            $("#formCadastro").show();
            $("#login").show();
        });

        $("#login").click(function(){
            $("#formLogin").show();
            $("#esqSenha").show();
            $("#cadastro").show();
            $("#formCadastro").hide();
            $("#formSenha").hide();
            $("#login").hide();
        });

        $("#esqSenha").click(function(){
            $("#formLogin").hide();
            $("#esqSenha").hide();
            $("#cadastro").hide();
            $("#formSenha").show();
            $("#login").show();
        });
    }

    function modalAgenteFunction(){
        $("#modalAgenteLogin").modal('show');

        $("#closeBtnAgente").click(function(){
            $(".modal").hide();
            $("#formLoginAgente").show();
            $("#esqSenhaAgente").show();
            $("#cadastroAgente").show();
            $("#facebookIcon").show();
            $("#formCadastroAgente").hide();
            $("#formSenhaAgente").hide();
            $("#loginAgente").hide();

        });

        $("#cadastroAgente").click(function(){
            $("#formLoginAgente").hide();
            $("#esqSenhaAgente").hide();
            $("#cadastroAgente").hide();
            $("#formCadastroAgente").show();
            $("#loginAgente").show();
        });

        $("#loginAgente").click(function(){
            $("#formLoginAgente").show();
            $("#esqSenhaAgente").show();
            $("#cadastroAgente").show();
            $("#facebookIcon").show();
            $("#formCadastroAgente").hide();
            $("#formSenhaAgente").hide();
            $("#loginAgente").hide();
        });

        $("#esqSenhaAgente").click(function(){
            $("#formLoginAgente").hide();
            $("#esqSenhaAgente").hide();
            $("#cadastroAgente").hide();
            $("#facebookIcon").hide();
            $("#formSenhaAgente").show();
            $("#loginAgente").show();
        });
    }
    </script>

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">
        <img src="{{asset('home/letoucanv5.png')}}" width="50" height="40" alt="">
        Tucaninho
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav text-uppercase ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#services">Como funciona</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link js-scroll-trigger" id="loginBtn" onclick="modalFunction()">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Header -->
    <header class="masthead">
      <div class="container">
        <div class="intro-text">
          <div class="intro-lead-in">Bem vindo, viajante!</div>
          <div class="intro-heading text-uppercase">Aqui você economiza na sua viagem</div>
          <a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="#services">Me mostre como</a>
        </div>
      </div>
    </header>

    <!-- Services -->
    <section id="services">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading text-uppercase">Como funciona</h2>
            <h3 class="section-subheading text-muted"></h3>
          </div>
        </div>
        <div class="row text-center">
          <div class="col-md-4">
            <span class="fa-stack fa-4x">
              <i class="fas fa-circle fa-stack-2x text-primary"></i>
              <i class="fas fa-address-card fa-stack-1x fa-inverse"></i>
            </span>
            <h4 class="service-heading">Cadastre-se</h4>
            <p class="text-muted">Crie uma conta no nosso sistema para começar.</p>
          </div>
          <div class="col-md-4">
            <span class="fa-stack fa-4x">
              <i class="fas fa-circle fa-stack-2x text-primary"></i>
              <i class="fas fa-edit fa-stack-1x fa-inverse"></i>
            </span>
            <h4 class="service-heading">Faça um pedido</h4>
            <p class="text-muted">Coloque a oferta que você possui atualmente, com as informações que você deseja para sua viagem.</p>
          </div>
          <div class="col-md-4">
            <span class="fa-stack fa-4x">
              <i class="fas fa-circle fa-stack-2x text-primary"></i>
              <i class="fas fa-handshake fa-stack-1x fa-inverse"></i>
            </span>
            <h4 class="service-heading">Feche negócio</h4>
            <p class="text-muted">Receba ofertas para diminuir o preço de sua viagem, e escolha a que for de sua preferencia.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <span class="copyright">Copyright &copy; Tucaninho 2018</span>
          </div>
          <div class="col-md-4 offset-md-4">
            <ul class="list-inline quicklinks">
              <li class="list-inline-item">
                <a href="#" onclick="modalAgenteFunction()" id="loginAgenteBtn">Login do Agente</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    @include('components.modal')
    @include('components.modalAgent')

    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Contact form JavaScript -->
    <script src="{{asset('home/js/jqBootstrapValidation.js')}}"></script>
    <script src="{{asset('home/js/contact_me.js')}}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{asset('home/js/agency.min.js')}}"></script>

  </body>

</html>
