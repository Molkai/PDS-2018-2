@extends('cliente.painel_cliente')

@section('title')
    Novo Pedido
@endsection

@section('styles')
  <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
  <style>
    #obsCard{
        background-color: #d3d3d3;
        margin-bottom: 0;
    }

    #addDataBtn{
        display: none;
    }
  </style>
@endsection


@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js" integrity="sha256-dHf/YjH1A4tewEsKUSmNnV05DDbfGN3g7NMq86xgGh8=" crossorigin="anonymous"></script>
  <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
  <script>
        let numLinks = 1;
        let numDatas = 1;
        function linkExpr() {
            $('input[type="url"]').on('blur', function(){
                var string = $(this).val();
                if (!string.match(/^https?:/) && !string.match(/^www\./) && string.length) {
                    string = "http://www." + string;
                    $(this).val(string);
                }else if (string.match(/^www\./) && string.length){
                    string = "http://" + string;
                    $(this).val(string);
                }
            });
        };
        $(document).ready(function(){
            $('#preco').val("R$");
            $('#preco').inputmask("numeric", {
                radixPoint: ",",
                groupSeparator: ".",
                digits: 2,
                autoGroup: true,
                prefix: 'R$ ', //Space after $, this will not truncate the first character.
                rightAlign: false,
                oncleared: function () { self.Value(''); }
            });
            $('#submit_pedido').click(function() {
                var precoNum = $('#preco').val();
                precoNum = precoNum.replace(/\./g, '');
                precoNum = precoNum.replace(',', '.');
                precoNum = precoNum.replace('R', '');
                precoNum = precoNum.replace('$', '');
                console.log((parseFloat(precoNum)).toFixed(2));
                $("input[name='preco']").val((parseFloat(precoNum).toFixed(2)));
            });
            linkExpr();
        });

        $(function(){
            $("#tipo_viagem").change(function(){
                if($(this).val() == 0){
                    $("#obs").text("Apenas viagem de ida para um destino dentro do país.");
                    $("#addDataBtn").hide();
                }
                else if($(this).val() == 1){
                    $("#obs").text("Apenas viagem de ida para um destino fora do país.");
                    $("#addDataBtn").hide();
                }
                else if($(this).val() == 2){
                    $("#obs").text("Viagem de ida e volta.");
                    $("#addDataBtn").hide();
                }
                else if($(this).val() == 3){
                    $("#obs").text("Viagem com mais de um trajeto de avião.");
                    $("#addDataBtn").show();
                }
                else if($(this).val() == 4){
                    $("#obs").text("Viagem para andar pelo mundo, podendo utilizar varios trajetos de  avião (Minimo de 3 trajetos de avião).");
                    $("#addDataBtn").show();
                }
            });
        });

        function somaQnt(){
            $("#disabledInput").val(parseInt($("#qnt_adultos option:selected").val()) + parseInt($("#qnt_criancas option:selected").val()) + parseInt($("#qnt_bebes option:selected").val()));
        }
        $(function() { // LINKS
        // Remove button click
            $(document).on(
                'click',
                '[data-role="dynamic-fields"][id="links"] > .form-inline [data-role="remove"]',
                function(e) {
                    numLinks--;
                    e.preventDefault();
                    $(this).closest('.form-inline').remove();
                    $("input[type='url']").each(function(index){
                        $(this).attr('name', 'link'+((numLinks-1)-index));
                    });
                }
            );
            // Add button click
            $(document).on(
                'click',
                '[data-role="dynamic-fields"][id="links"]  > .form-inline [data-role="add"]',
                function(e) {
                    numLinks++;
                    e.preventDefault();
                    var container = $(this).closest('[data-role="dynamic-fields"][id="links"]');
                    new_field_group = container.children().filter('.form-inline:first-child').clone();
                    new_field_group.find('input').each(function(){
                        $(this).val('');
                    });
                    let num = parseInt(new_field_group.find('input').attr('name').slice(4))+1;
                    new_field_group.find('input').attr('name', 'link'+num);
                    new_field_group.find('button').attr('class', 'btn btn-danger').attr('data-role', 'remove').find('i').attr('class', 'fa fa-minus');
                    container.prepend(new_field_group);
                    linkExpr();
                }
            );
        });
        $(function() { // DATAS
        // Remove button click
            $(document).on(
                'click',
                '[data-role="dynamic-fields"][id="datas"] > .form [data-role="remove"]',
                function(e) {
                    numDatas--;
                    e.preventDefault();
                    $(this).closest('.form').remove();
                    $(".data").each(function(index){
                        $(this).attr('name', 'data'+((numDatas-1)-index));
                    });
                    $(".pais").each(function(index){
                        $(this).attr('name', 'pais'+((numDatas-1)-index));
                    });
                    $(".cidade").each(function(index){
                        $(this).attr('name', 'cidade'+((numDatas-1)-index));
                    });
                    $(".aeroporto").each(function(index){
                        $(this).attr('name', 'aeroporto'+((numDatas-1)-index));
                    });
                    $(".trecho").each(function(index){
                        $(this).text("Trecho " + (numDatas-index) + ":");
                    });
                }
            );
            // Add button click
            $(document).on(
                'click',
                '[data-role="dynamic-fields"][id="datas"]  > .form [data-role="add"]',
                function(e) {
                    numDatas++;
                    e.preventDefault();
                    var container = $(this).closest('[data-role="dynamic-fields"][id="datas"]');
                    new_field_group = container.children().filter('.form:first-child').clone();

                    new_field_group.find('p').text("Trecho " + numDatas + ":");

                    let strNumData = "data" + (numDatas - 2).toString();
                    let strNumPais = "pais" + (numDatas - 2).toString();
                    let strNumCidade = "cidade" + (numDatas - 2).toString();
                    let strNumAeroporto = "aeroporto" + (numDatas - 2).toString();
                    new_field_group.find('input').each(function(){
                        var num;
                        $(this).val('');
                        if($(this).attr('name') == strNumData){
                            num = parseInt($(this).attr('name').slice(4))+1;
                            $(this).attr('name', 'data'+num);
                        }else if($(this).attr('name') == strNumPais){
                            num = parseInt($(this).attr('name').slice(4))+1;
                            $(this).attr('name', 'pais'+num);
                        }else if($(this).attr('name') == strNumCidade){
                            num = parseInt($(this).attr('name').slice(6))+1;
                            $(this).attr('name', 'cidade'+num);
                        }else if($(this).attr('name') == strNumAeroporto){
                            num = parseInt($(this).attr('name').slice(9))+1;
                            $(this).attr('name', 'aeroporto'+num);
                        }
                    });
                    new_field_group.find('button').attr('class', 'btn btn-danger').attr('data-role', 'remove').find('i').attr('class', 'fa fa-minus');
                    container.prepend(new_field_group);
                }
            );
        });
  </script>
@endsection

@section('content')
  <div class="container-fluid">
    @include('components.painel_navbar')

      <div class="row">

          <div class="col-xl-12 pl-5"> <!-- <div class="col-xl-8 offset-xl-2 py-5"> ORIGINAL-->
                  <h1>Pedido</h1>
                  <p class="lead">Preencha o formulário com as informações necessárias</p>
                  <div class="card mt-4">



                      <div class="card-body">
              <!-- We're going to place the form here in the next step -->
                          <form id="contact-form" method="post" action="{{action('PedidosController@cadastraPedido')}}" role="form">
                              @csrf
                              <div class="messages"></div>

                              <div class="controls">

                                  <div class="row content-justify-center">
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              <label for="preco">O melhor preço que você encontrou:</label>
                                              <input id="preco" class="form-control" required="required" data-error="O preco é obrigatório.">
                                              <input type="hidden" name="preco">
                                              <div class="help-block with-errors"></div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                             <div class="col-md-8">
                                                <label for="links">Insira o(s) link(s) relacionados à sua viagem (hotel, passagem, etc):</label>
                                             </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div data-role="dynamic-fields" id="links">
                                                        <div class="form-inline">
                                                            <div class="form-group">
                                                                <input type="url" name="link0" class="form-control" placeholder="Link..." required="required" max="2000">
                                                            </div>
                                                            <button class="btn btn-primary" data-role="add">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>  <!-- /div.form-inline -->
                                                    </div>  <!-- /div[data-role="dynamic-fields"] -->
                                                </div>
                                            </div>
                                        </div>

                                   <div class="row">
                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="descricao">Descreva os detalhes da sua viagem:</label>
                                              <textarea id="descricao" name="descricao" class="form-control" placeholder="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente dicta fugit fugiat hic aliquam itaque facere, soluta. *" rows="4" required="required" data-error="Nos deixe uma mensagem." maxlength="1000"></textarea>
                                              <div class="help-block with-errors"></div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              <label for="tipo_viagem">Tipo da viagem:</label>
                                              <select id="tipo_viagem" name="tipo_viagem" class="form-control" required="required" data-error="Especifique o tipo da viagem.">
                                                  <option value="0">Ida Doméstica</option>
                                                  <option value="1">Ida Internacional</option>
                                                  <option value="2">Retorno (Ida e Volta)</option>
                                                  <option value="3">Múltiplas Paradas</option>
                                                  <option value="4">Volta ao Mundo</option>
                                              </select>
                                              <div class="help-block with-errors"></div>
                                          </div>
                                      </div>
                                      <div class="col-md-8">
                                          <div class="card mt-4" id="obsCard">
                                            <b><div class="card-body" id="obs">
                                              Apenas viagem de ida para um destino dentro do país.
                                            </div></b>
                                          </div>
                                      </div>
                                  </div>

                                <div class="row">
                                        <div class="col-md-8">
                                           <label for="links">Insira a(s) data(s) da sua viagem:</label>
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div data-role="dynamic-fields" id="datas">
                                                <div class="form">
                                                    <div class="card mt-4">
                                                        <div class="card-body">
                                                            <p class="trecho"> Trecho 1: </p>
                                                            Data: <input type="date" name="data0" class="form-control data" placeholder="dd/mm/aaaa" required="required">
                                                            País: <input type="text" name="pais0" class="form-control pais" placeholder="" required="required" max="100">
                                                            Cidade: <input type="text" name="cidade0" class="form-control cidade" placeholder="" required="required" max="100">
                                                            Aeroporto: <input type="text" name="aeroporto0" class="form-control aeroporto" placeholder="" required="required" max="100">
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" data-role="add" id="addDataBtn">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>  <!-- /div.form-inline -->
                                            </div>  <!-- /div[data-role="dynamic-fields"] -->
                                        </div>
                                    </div>
                                </div>

                                  <div class="row">
                                       <div class="col-md-3">
                                          <label for="form_need">Quantas pessoas irão viajar?</label>
                                       </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-md-2">
                                          <div class="form-group">
                                              <select id="qnt_adultos" name="qnt_adultos" class="form-control" required="required" data-error="Especifique o número de adultos." onchange="somaQnt();">
                                                  <option value="1">1 adulto</option>
                                                  <option value="2">2 adultos</option>
                                                  <option value="3">3 adultos</option>
                                                  <option value="4">4 adultos</option>
                                                  <option value="5">5 adultos</option>
                                                  <option value="6">6 adultos</option>
                                                  <option value="7">7 adultos</option>
                                                  <option value="8">8 adultos</option>
                                                  <option value="9">9 adultos</option>
                                                  <option value="10">10+ adultos</option>
                                              </select>
                                              <div class="help-block with-errors"></div>
                                          </div>
                                      </div>
                                     <div class="col-md-1"> <h2>+</h2> </div>
                                      <div class="col-md-2">
                                          <div class="form-group">
                                              <select id="qnt_criancas" name="qnt_criancas" class="form-control" required="required" data-error="Especifique o número de crianças." onchange="somaQnt();">
                                                  <option value="0">0 crianças</option>
                                                  <option value="1">1 criança</option>
                                                  <option value="2">2 crianças</option>
                                                  <option value="3">3 crianças</option>
                                              </select>
                                              <div class="help-block with-errors"></div>
                                          </div>
                                      </div>
                                      <div class="col-md-1"> <h2>+</h2> </div>
                                      <div class="col-md-2">
                                          <div class="form-group">
                                              <select id="qnt_bebes" name="qnt_bebes" class="form-control" required="required" data-error="Especifique o número de bebês." onchange="somaQnt();">
                                                  <option value="0">0 bebês</option>
                                                  <option value="1">1 bebê</option>
                                                  <option value="2">2 bebês</option>
                                                  <option value="3">3 bebês</option>
                                              </select>
                                              <div class="help-block with-errors"></div>
                                          </div>
                                      </div>
                                      <div class="col-md-1"> <h2>=</h2> </div>
                                      <div class="col-md-1">
                                          <div class="form-group">
                                              <input class="form-control" value="1" id="disabledInput" type="text" disabled>
                                          </div>
                                      </div>
                                      <div class="col-md-2"> <h5>Passageiros</h5>. </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-md-3">
                                          <label for="tipo_passagem">Classe:</label>
                                      </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-md-8">
                                          <div class="form-group">

                                              <div class="radio">
                                                  <label class="radio">
                                                      <input type="radio" name="tipo_passagem" value="0" checked>
                                                      Econômica
                                                  </label>
                                              </div>

                                              <div class="radio">
                                                  <label class="radio">
                                                      <input type="radio" name="tipo_passagem" value="1">
                                                      Econômica Premium
                                                  </label>
                                              </div>

                                              <div class="radio">
                                                  <label class="radio">
                                                      <input type="radio" name="tipo_passagem" value="2">
                                                      Executiva
                                                  </label>
                                              </div>

                                              <div class="radio">
                                                  <label class="radio">
                                                      <input type="radio" name="tipo_passagem" value="3">
                                                      Primeira Classe
                                                  </label>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-md-8">
                                          <div class="form-group">
                                              <label for="preferencia">Companhias aéreas de preferência:</label>
                                              <input id="preferencia" type="text" name="preferencia" class="form-control" placeholder="Azul, TAM, ... (Campo não obrigatório)">
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-md-12">
                                          <input type="submit" id="submit_pedido" class="btn btn-warning btn-send" value="Finalizar pedido">
                                      </div>
                                  </div>

                              </div>

                          </form>
                  </div>
              </div>
          </div>

      </div>

  </div>
@endsection
