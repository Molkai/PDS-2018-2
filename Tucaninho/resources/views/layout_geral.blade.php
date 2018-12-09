<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('painel/css/simple-sidebar.css')}}" rel="stylesheet">
    <link href="{{asset('painel/css/1-col-portfolio.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/animation.css')}}" rel="stylesheet" type="text/css">
    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-notify.min.js')}}"></script>

    <!-- Menu Toggle Script -->
    <script>
        $(document).ready(function(){
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });

            @yield('func_del_user')

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
        });
    </script>

    @yield('styles')
</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                @yield('sidebar')
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            @yield('content')
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
    @yield('scripts')

</body>

</html>
