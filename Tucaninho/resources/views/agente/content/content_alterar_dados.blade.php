@extends('agente.painel_agente')

@section('title')
    Dados cadastrais
@endsection

@section('styles')
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#form-cadastro").submit(function compSenha(event){
                if($("#pwd").val() != $("#pwd2").val()){
                    $("#pwd").val("");
                    $("#pwd2").val("");
                    alert("As senhas são diferentes!");
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="container-fluid">
        @include('components.painel_navbar')

        <div class="row">

            <div class="col-md-12">
                @include('components.form_alterar_cadastro', ['agente' => $agente])
            </div>
        </div>
    </div>
@endsection
