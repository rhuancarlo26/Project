@extends('app')
@section('content')

    @if(session('mensagem'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{session('mensagem')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(!empty($lists))

        <div>        
            <div class="container-fluid">
                <div class='row'  style="margin-left: -83px; width: 74.6rem;">
                    <div class="col-md-12">
                        <form method="get" action="">
                        
                            <div class="card-box">
                                <div class="check-form form-row">  
                                    <div class="col-md-4 form-group">
                                        <label for="treinamento" class="col-md-4 col-form-label">Treinamento</label>  
                                        <select name="treinamento" id="treinamento" class="form-control">
                                            
                                            <option value="" >--Selecione--</option>
                                            
                                            @foreach($tipo_t as $tipo)
                                                <option type="checkbox" value="{{$tipo->id}}">{{$tipo->tipo_treinamento}}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                            <label for="produto" class="col-md-4 col-form-label">Produto</label>
                                            <select name="produto" id="produto" class="form-control">

                                                <option value="" >--Selecione--</option>

                                                @foreach($prod as $produto)
                                                    <option value="{{$produto->id}}">{{$produto->tipo_produto}}</option>
                                                @endforeach
                                                
                                            </select>
                                    </div>
                                    
                                    <div class="col-md-4 form-group">
                                            <label for="data_inicio" class="col-md-4 col-form-label">Data inicio</label>
                                            <input class="form-control col-md-10" type="date" name="data_inicio" id="p_data_inicio"   value="">
                                    </div>

                                    <!-- Botão Filtrar -->
                                    <div class="col-md-12">
                                        <input type="submit" value="Filtrar" class='btn btn-primary' style="width:100px;">
                                    </div>
                                                        
                                </div>
                            </div>
                        </form>   
                    </div>
                </div>

                <div class="row"  style="margin-left: -83px; width: 74.6rem;">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="text-right" style="margin-bottom:20px;">
                                <i data-toggle="modal" data-target="#modal" id='novo_treinamento' class="btn btn-outline-success new" style="margin-right: auto; ">Novo Treinamento</i>
                            </div>   
                            
                                <table class="table" style='background: white;'>
                                    <tr>
                                        <th>Treinamento</th>
                                        <th>Produto</th>
                                        <th>Data Inicio</th>
                                        <th>Data Fim</th>
                                        <th>Carga Horária</th>
                                        <th>Analista de Treinamento</th>
                                        <th>Objetivo</th>
                                        <th>Ação</th>
                                                                    
                                    </tr>

                                    @foreach($lists as $item)
                                        <tr align="left">
                                            <form  id="treinamento" action="" method="POST">
                                                @csrf
                                                                                        
                                                <td>{{$item->tipo_t->tipo_treinamento}}</td>
                                                <td>{{$item->produto->tipo_produto}}</td>
                                                <td>{{date( 'd/m/Y' , strtotime($item->data_inicio))}}</td>
                                                <td>{{date( 'd/m/Y' , strtotime($item->data_fim))}}</td>
                                                <td>{{$item->carga_horaria}}</td>
                                                <td>{{$item->controle->nome}}</td>
                                                <!-- <td>{{$item->controle->nome}}</td> -->
                                                <td>{{$item->objetivo}}</td>
                                                <td>      
                                                    <a>
                                                        <i class="fa fa-eye view" style="color: rgba(9, 195, 170, 0.972)" id="{{$item->id}}"></i>
                                                    </a>    
                                                </td>
        
                                            </form>    
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div> 
                    </div> 
                </div>
            </div>        
        </div> 

    @endif
 
    <!-- Modal Novo Treinamento -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"  style="height: 700px; overflow-y: scroll;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar Treinamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <form action="{{route('store')}}" method="POST">
                        @csrf
                        
                        <div class="card-box">
                            <div class="check-form form-row">  
                                
                                <div class="col-md-6 form-group" align="center">
                                    <label for="mt_treinamento" class="col-md-6 col-form-label">Tipo de Treinamento</label>  
                                    <select name="mt_treinamento" id="mt_treinamento" class="form-control @error('mt_treinamento') is-invalid @enderror">
                                        <option value="" >--Selecione--</option>
                                        @foreach($tipo_t as $tipo_t)
                                            <option value="{{$tipo_t->id}}">{{$tipo_t->tipo_treinamento}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group" align="center">
                                    <label for="produto" class="col-md-6 col-form-label">Produto</label>
                                    <select name="m_produto" id="id_produto" class="form-control">
                                        <option value="" >--Selecione--</option>
                                        @foreach($prod as $produto)
                                            <option value="{{$produto->id}}">{{$produto->tipo_produto}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                                        
                                <div class="col-md-4 form-group">
                                    <label for="mdata_inicio" class="col-md-5 col-form-label">Data inicio</label>
                                    <input class="form-control col-md-10" type="date" name="mdata_inicio" id="data_inicio"  placeholder="dd/mm/aaaa" value="">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="mdata_fim" class="col-md-5 col-form-label">Data fim</label>
                                    <input class="form-control col-md-10" type="date" name="mdata_fim" id="data_fim"  placeholder="dd/mm/aaaa" value="">
                                </div>

                                <div class="col-md-4 form-group" >
                                    <label for="carga_h" class="col-md-7 col-form-label">Carga Horária</label>
                                    <input class="form-control col-md-10" type="time" name="carga_h" id="carga_horaria" placeholder="dd/mm/aaaa" value="">
                                </div>

                                <div class="col-md-6 form-group" >
                                    <label for="m_analista" class="col-md-6 col-form-label">Analista</label>  
                                    <select name="m_analista" id="m_analista" class="form-control">
                                        <option value="" >--Selecione--</option>
                                        @foreach($analista as $item)
                                        
                                            <option value="{{$item->id_registro}}">{{$item->nome}}</option>
                                        
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group" >
                                    <label for="objetivo" class="col-md-6 col-form-label">Objetivo</label>  
                                    <input type="text" name="objetivo" id="objetivo" class="form-control col-md-10">
                                </div>
                                
                                <div class="text-right">
                                    <i data-toggle="modal" data-target="#colaborador" id='novo_colaborador' class="remixicon-add-fill" >Adicionar Colaborador</i>
                                </div> 

                            </div>

                            <!-- Lista colaboradores e adiciona participante -->
                            <div class="check-form form-row" style="margin-top:10px;">

                                <div class="col-md-6 form-group" >
                                    <select name="trein_part[]" id="adicionar" multiple>
                                        <option value="">--Selecione--</option>
                                        @foreach($cp as $cp)
                                            <option value="{{$cp->id_registro}}">{{$cp->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                                                                                      
                            </div> 

                            
                            <!-- <input type="text" name="id_registro" id="id_registro"></input> -->
                            
                            
                        </div>
                                                    
                        <div class="modal-footer">
                            <br><br>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-outline-success" id="salvar">Salvar</button>
                        </div>                    
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function() {
            
            $(document).ready(function () {
                $('#adicionar').select2({
                    dropdownParent: $('#modal')
                });
            });
            

            $('#adicionar').hide();
           
            $(document).on('click','#novo_colaborador',function(event){
                if($( "#adicionar" ).is( ":visible" )==false){
                    $('#adicionar').show();
                }
                else{
                    $('#adicionar').hide();
                }     
            });
                        
            
        });   
        
        
        //Visualizar dados do treinamento
        var id = 0
    
        document.querySelectorAll("i.view").forEach( function(button) {
            
            button.addEventListener("click", function(event) {
                const el = event.target || event.srcElement;
                id = el.id;
            });
        });
        
        $(function(){            
            $(document).on('click','.view',function(event){            
                event.preventDefault();         
                var dados = {id:id}             
             
                $.ajax({    
                    method: "get",
                    url: "{{ route('visualizar')}}",
                    data: dados, // Dados a serem enviados
                    dataType:'json',
                    success: function(response){

                        if(response.success == true){
                            var treinamento = response.result.id_tipo_treinamento
                            var produto = response.result.id_produto
                            var data_inicio = response.result.data_inicio
                            var data_fim = response.result.data_fim
                            var carga = response.result.carga_horaria
                            var analista = response.result.analista_resp
                            var objetivo = response.result.objetivo
                            var adicionarc = response.colaborador.id_colaborador
                            

                                       
                            $('#modal').modal('show');
                            $('#modal').ready(function(){  
                                document.getElementById('salvar').style.display = 'none'    
                                $('#mt_treinamento').show()
                                $('#id_produto').show()
                                $('#data_inicio').show()
                                $('#data_fim').show()
                                $('#carga_horaria').show()
                                $('#m_analista').show()
                                $('#objetivo').show()
                                $('#adicionar').show()
                                $('#id_registro').show()
                                document.getElementById('adicionar').style.display = 'none'  
                                document.getElementById('novo_colaborador').style.display = 'none' 
                                                                
                                
                                
                                $('#mt_treinamento').attr("disabled", true);
                                $('#id_produto').attr("disabled", true);
                                $('#data_inicio').attr("disabled", true);
                                $('#data_fim').attr("disabled", true);
                                $('#carga_horaria').attr("disabled", true);
                                $('#m_analista').attr("disabled", true)
                                $('#objetivo').attr("disabled", true)
                                $('#adicionar').attr("disabled", true)
                                $('#id_registro').attr("disabled", true)

                                $('#mt_treinamento').val(treinamento)
                                $('#id_produto').val(produto)
                                $('#data_inicio').val(data_inicio)
                                $('#data_fim').val(data_fim)
                                $('#carga_horaria').val(carga)
                                $('#m_analista').val(analista)
                                $('#objetivo').val(objetivo)
                                $('#adicionar').val(adicionarc)
 
                                        
                            });
                        }
                        else{

                            alert('Não há informações a listar, por favor, redefina as buscas!')
                        } 
                        
                    }
                });
            })
        })
         

    </script> 

    

 
    

@endsection



