<?php
    $array_nome_agente = explode(" ", \Auth::guard('agente')->user()->nome_agente, 2);
    $primeiro_nome_agente = $array_nome_agente[0]
?>

@extends('layout_geral')

@section('title')
    @yield('title')
@endsection

@section('styles')
  @yield('styles')
@endsection

@section('func_del_user')
    $("#deletaAgente").click(function(e){
        if(!confirm('Você tem certeza que deseja deletar a sua conta?'))
            e.preventDefault();
        else
            window.location = "{{action('AgenteController@deletar', [encrypt(\Auth::guard('agente')->user()->email_agente)])}}";
    });
@endsection

@section('scripts')
  @yield('scripts')
@endsection

@section('sidebar')
  <li class="sidebar-brand">
      <a style="{pointer-events: none;}">
          Bem Vindo, {{$primeiro_nome_agente}}
      </a>
  </li>
  <li>
      <a href="{{action('PedidosController@listaPedidosAgente')}}">Pedidos</a>
  </li>
  <li>
      <a href="{{action('AgenteController@carregaDadosAgente')}}">Alterar dados</a>
  </li>
  <li>
      <a id="deletaAgente" href="#">Deletar Conta</a>
  </li>
  <li>
      <a href="{{action('AgenteController@logout')}}">Logout</a>
  </li>
@endsection

@section('content')
  @yield('content')
@endsection
