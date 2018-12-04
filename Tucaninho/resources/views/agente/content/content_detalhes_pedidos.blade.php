<?php
    function includeAsJsString($template, $var)
    {
        $string = view($template, ['pedido' => $var]);
        return str_replace("\n", '', $string);
    }
?>

@extends('agente.painel_agente')

@section('title')
    Detalhes do Pedido
@endsection

@section('scripts')
    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

    <script type='text/javascript'>
        $(document).ready(function(){
            $('#messagesDiv').hide();
            $('#form-oferta').hide();
            $('#preco,#disabledPreco').val("R$");
            $('#preco,#disabledPreco').inputmask("numeric", {
                radixPoint: ",",
                groupSeparator: ".",
                digits: 2,
                autoGroup: true,
                prefix: 'R$ ', //Space after $, this will not truncate the first character.
                rightAlign: false,
                oncleared: function () { self.Value(''); }
            });
            $('#submeter_oferta').click(function() {
                var precoNum = $('#disabledPreco').val();
                precoNum = precoNum.replace(/\./g, '');
                precoNum = precoNum.replace(',', '.');
                precoNum = precoNum.replace('R', '');
                precoNum = precoNum.replace('$', '');
                $("input[name='preco']").val((parseFloat(precoNum)).toFixed(2));
            });
            @if($oferta!=null)
                $("#altera_oferta").click(function(e){
                    e.preventDefault();
                    $("#card_oferta").hide();
                    $('#form-oferta').show();
                    $('#descricao').val('{{$oferta->descricao}}');
                    $('#preco').val('{{$oferta->preco/1.1}}');
                    $('#disabledPreco').val('{{$oferta->preco}}');
                });

                $(".btn-send-message").click(function(e) {
                    e.preventDefault();
                    let email_cliente = '{{$oferta->email_cliente}}';
                    let pedido_id = '{{$oferta->pedido_id}}';
                    let mensagem = $(".message-text").val();
                    let fileName = $(".fileToUpload").val();
                    if(fileName!=''){
                        let send = new FormData($(".sendMessageForm")[0]);
                        $.ajax({
                            url: "{{action('MensagemController@cadastraMensagemAgente')}}",
                            type: 'POST',
                            data: send,
                            success: function(data) {
                                if(data!==null)
                                    $('.messagesCardsDiv').append('<br> <div class="card col-xl-6" style="background-color: lightgreen;"> <div class="col-xl-12"> <a href="/download_file/'+data.fileName+'">'+data.mensagem+'</a> </div> </div>');
                                $(".message-text").val('');
                                $(".fileToUpload").val('');
                                $(".label-info").text('');
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                        }).fail(function(data){
                            console.log(data);
                        });
                        return;
                    }
                    if(mensagem=='')
                        return;
                    $.post(
                        "{{action('MensagemController@cadastraMensagemAgente')}}",
                        {
                            email_cliente: email_cliente,
                            pedido_id: pedido_id,
                            Mensagem: mensagem,
                            _token: '{{csrf_token()}}'
                        },
                        function(data){
                            if(!(data===null))
                                $('.messagesCardsDiv').append('<br> <div class="card col-xl-6" style="background-color: lightgreen;"> <div class="col-xl-12"> <p class="otherText">'+data.mensagem+'</p> </div> </div>');
                            $(".message-text").val('');
                        },
                        "json"
                    ).fail(function(data){
                        console.log(data);
                    });
                });
            @endif
        });

        $('.messagesDiv').hide();
        $(function() {
            $('.messageBtn').click(function() {
                if($('.messagesDiv').is(':visible'))
                    $('.messagesDiv').hide();
                else
                    $('.messagesDiv').show()
            });
        });

        $(function() {
           $('#realizar_oferta').click(function() {
                $(this).hide();
            });
        });

       $(function() {
           $('#cancelar_oferta').click(function() {
                $("#preco").val("");
                $("#disabledPreco").val("");
                $("#descricao").val("");
                $('#realizar_oferta').show("slow");
            });
        });

       $(function() {
           $('#preco').change(function() {
                var precoNum = $('#preco').val();
                precoNum = precoNum.replace(/\./g, '');
                precoNum = precoNum.replace(',', '.');
                precoNum = precoNum.replace('R', '');
                precoNum = precoNum.replace('$', '');
                $("#disabledPreco").val((parseFloat(precoNum)*1.1).toFixed(2));
            });
        });

        $(function() {
           $('#remove_oferta').click(function(e) {
                e.preventDefault();
                if(confirm("Você tem certeza que quer remover essa oferta?")){
                    let id = $(this).data("id");
                    let email_cliente = $(this).data("cliente");
                    let email_agente = $(this).data("agente");
                    $.post(
                        "{{action('OfertaController@deletaOferta')}}",
                        {
                            id: id,
                            email_agente: email_agente,
                            email_cliente: email_cliente,
                            _token: '{{csrf_token()}}'
                        },
                        function(data){
                            if(data==='Sucesso.'){
                                alert("Sucesso");
                                location.reload();
                            }
                        },
                        "json"
                    ).fail(function(data){
                        console.log(data);
                    });
                }
                else{
                    alert("Operação cancelada.");
                }
            });
        });
    </script>
@endsection

@section('content')
  <!-- Page Content -->
  <div class="container-fluid">
    @include('components.painel_navbar')

    <div class="row">

      <!-- /.col-lg-3 -->

      <div class="col-md-12" id="conteudo">

        @include('components.info_pedido', ['pedido' => $pedido, 'estado_agente' => (isset($oferta)?$oferta->estado:null), 'links' => $links, 'datas' => $datas, 'email_agente' => (isset($oferta)?$oferta->email_agente:null)])


        @if($pedido->estado==0 && $oferta==null)
            @include('components.form_oferta', ['displayButton' => true])
        @elseif($oferta!=null)
            <div class="card card-outline-secondary my-4" id="card_oferta">
                <div class="card-header">
                    Oferta
                    <a href="#"><i class="fas fa-pen" id="altera_oferta"></i></a>
                    <a href="#" style="text-align: right; float: right;"><i class="far fa-trash-alt" id="remove_oferta" data-cliente="{{$oferta->email_cliente}}" data-agente="{{$oferta->email_agente}}" data-id="{{$oferta->pedido_id}}"></i></a>
                </div>
                <div class="card-body">
                    @include('components.info_oferta', ['oferta' => $oferta, 'displayButton' => false, 'mensagens' => $mensagens, 'isCliente' => false])
                </div>
            </div>
            <div class="card-body" id="form-oferta">
                @include('components.form_oferta', ['displayButton' => false])
            </div>
        @endif

      </div>
      <!-- /.col-lg-9 -->

    </div>

  </div>
  <!-- /.container -->
@endsection
