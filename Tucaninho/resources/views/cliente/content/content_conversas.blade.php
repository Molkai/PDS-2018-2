@extends('cliente.painel_cliente')

@section('title')
    Conversas
@endsection

@section('styles')
@endsection

@section('scripts')
  <script>
    $(".clickable-row").css('cursor', 'pointer');
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
  </script>
@endsection

@section('content')
  <div class="container-fluid">
      @include('components.painel_navbar')
      <!-- Project One -->
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Agente</th>
            <th scope="col">Ultima Mensagem</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
  </div>
@endsection
