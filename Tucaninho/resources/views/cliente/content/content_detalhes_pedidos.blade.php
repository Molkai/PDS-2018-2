@extends('cliente.painel_cliente')

@section('title')
    Detalhes do Pedido
@endsection

@section('scripts')
    <script >
        $('.messagesDiv').hide();
        $(function() {
            $('.messageBtn').click(function() {
                var index = $('.messageBtn').index($(this));
                if($('.messagesDiv:eq('+ index +')').is(':visible'))
                    $('.messagesDiv:eq('+ index +')').hide();
                else
                    $('.messagesDiv:eq('+ index +')').show()
            });
        });

        $(".btn-send-message").click(function(e) {
            e.preventDefault();
            let send;
            var index = $('.btn-send-message').index($(this));
            let email_agente = $(this).data("agente");
            let pedido_id = $(this).data("id");
            let mensagem = $(".message-text:eq("+index+")").val();
            let fileName = $(".fileToUpload:eq("+index+")").val();
            if(fileName!=''){
                send = new FormData($(".sendMessageForm")[index]);
                $.ajax({
                    url: "{{action('MensagemController@cadastraMensagemCliente')}}",
                    type: 'POST',
                    data: send,
                    success: function(data) {
                        if(data!==null)
                            $('.messagesCardsDiv:eq('+index+')').append('<br> <div class="card col-xl-6" style="background-color: lightgreen;"> <div class="col-xl-12"> <a href="/download_file/'+data.fileName+'">'+data.mensagem+'</a> </div> </div>');
                        $(".message-text:eq("+index+")").val('');
                        $(".fileToUpload:eq("+index+")").val('');
                        $(".label-info:eq("+index+")").text('');
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                });
                return;
            }
            else if(mensagem!=''){
                send = { email_agente: email_agente, pedido_id: pedido_id, Mensagem: mensagem, _token: '{{csrf_token()}}' };
            }
            else
                return;
            $.post(
                "{{action('MensagemController@cadastraMensagemCliente')}}",
                send,
                function(data){
                    if(data!==null){
                        $('.messagesCardsDiv:eq('+index+')').append('<br> <div class="card col-xl-6" style="background-color: lightgreen;"> <div class="col-xl-12"> <p class="otherText">'+data.mensagem+'</p> </div> </div>');
                    }
                    $(".message-text:eq("+index+")").val('');
                },
                "json"
            ).fail(function(data){
                console.log(data);
            });
        });

        $(".aceita_oferta").click(function(){
            window.location = $(this).data("oferta");
        });

        $("#cancela_compra").click(function(){
            window.location = $(this).data("href");
        });

    </script>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="container-fluid">
        @include('components.painel_navbar')

        <div class="row">

            <div class="col-md-12">

                @include('components.info_pedido', ['pedido' => $pedido, 'links' => $links, 'datas' => $datas, 'estado_cliente' => $pedido->estado])

                @if(count($ofertas)>0)
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">
                            Ofertas
                        </div>
                        <div class="card-body">
                            @foreach($ofertas as $oferta)
                                @include('components.info_oferta', ['oferta' => $oferta, 'displayButton' => true, 'estado' => $pedido->estado, 'mensagens' => $mensagens[$oferta->email_agente], 'isCliente' => true])
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>

    </div>

@endsection
