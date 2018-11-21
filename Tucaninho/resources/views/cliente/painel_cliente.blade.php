<?php
    $array_nome_cliente = explode(" ", \Auth::guard('cliente')->user()->nome_cliente, 2);
    $primeiro_nome_cliente = $array_nome_cliente[0]
?>

@extends('layout_geral')

@section('title')
    @yield('title')
@endsection

@section('styles')
  @yield('styles')
@endsection

@section('func_del_user')
    $("#deletaCliente").click(function(e){
        if(!confirm('Você tem certeza que deseja deletar a sua conta?'))
            e.preventDefault();
        else
            window.location = "{{action('ClienteController@deletar', [encrypt(\Auth::guard('cliente')->user()->email_cliente)])}}";
    });
@endsection

@section('scripts')
  @yield('scripts')
@endsection

@section('sidebar')
  <li class="sidebar-brand">
      <a style="{pointer-events: none;}">
          Bem Vindo, {{$primeiro_nome_cliente}}
      </a>
  </li>
  <li>
      <a href="{{action('PedidosController@listaPedidosCliente')}}">Pedidos</a>
  </li>
  <li>
      <a href="/cliente/novo">Novo Pedido</a>
  </li>
  <li>
      <a id="deletaCliente" href="#">Deletar Conta</a>
  </li>
  <li>
      <a href="{{action('ClienteController@logout')}}">Logout</a>
  </li>
@endsection

@section('content')
  @yield('content')
@endsection
