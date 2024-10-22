@extends('layouts.app')

@section('title', 'Configuración')

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2><i class="bi bi-gear-fill"></i> Configuraci&oacuten</h2>
        </div>
    </div>
    <br>
    <div class="col-md-12">
        <x-nav_config :pag="$pagina" />
    </div>
    <br>
    <div class="row border shadow rounded-3 pt-2 pb-2" id="calculos-generales">
        <form action="{{route('updatecalculos')}}" method="POST">
             @csrf
        <div class="col-md-12">
            <div class="row">
                <div class="col-8 col-md-6">
                    <h3>Calculos Generales</h3>
                    <p class="text-secondary">Valores que se aplican a los precios de manera general.</p>
                </div>
                <div class="col-4 col-md-6 text-end">
                    <button class="btn btn-success" type="submit" id="btnSaveCalculos"> <i class="bi bi-floppy"></i></button>
                    <button class="btn btn-secondary" type="button" onclick="calculateGeneralDisabled()"> <i class="bi bi-pencil"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-4 col-md-2">
                    <label>IGV:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1">%</span>
                      <input type="number" class="form-control input-edit" name="igv" placeholder="IGV" step="0.01" aria-describedby="basic-addon1" value="{{$calculos->igv}}" >
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <label>T. Facturaci&oacuten:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1">%</span>
                      <input type="number" class="form-control input-edit" name="facturacion" placeholder="Faturacion" step="0.01"  aria-describedby="basic-addon1" value="{{$calculos->facturacion}}" >
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <label><i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="La tasa de cambio se actualiza diariamente"></i> T.C:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1">$</span>
                      <input type="number" class="form-control" placeholder="T.C." step="0.01" aria-describedby="basic-addon1" value="{{$calculos->tasaCambio}}" disabled>
                    </div>
                </div>
                @foreach($empresas as $empresa)
                    <div class="col-6 col-md-3">
                        <label>{{$empresa->nombreComercial}}:</label>
                        <div class="input-group mb-3">
                          <span class="input-group-text" id="basic-addon1">%</span>
                          <input type="number" class="form-control input-edit" name="empresas[{{$empresa->idEmpresa}}]" placeholder="Comision" step="0.01" aria-describedby="basic-addon1" value="{{$empresa->comision}}" >
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </form>
    </div>
    <br>
    <div class="row border shadow rounded-3 pt-2 pb-2">
        <div class="col-md-12">
            <div class="row border-bottom">
                <div class="col-8 col-md-7">
                    <h3>Comisiones por Productos</h3>
                    <p class="text-secondary">Porcentaje aplicado a los precios por su costo.</p>
                </div>
                <div class="col-4 col-md-5 text-end">
                    <div class="btn-group dropstart">
                      <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorias
                      </button>
                      <ul class="dropdown-menu">
                          @foreach($categorias as $categoria)
                            <li><a onclick="viewElementsComision({{$categoria->idCategoria}})" class="dropdown-item" style="cursor:pointer">
                                {{$categoria->nombreCategoria}}
                            </a></li>
                          @endforeach
                      </ul>
                    </div>
                </div>
            </div>
        </div>
        @foreach($categorias as $categoria)
        <div class="col-md-12 divCategory-{{$categoria->idCategoria}}" style="display:none">
            <div class="row pt-2 pb-2 text-center">
                <h4>{{$categoria->nombreCategoria}} <i class="{{$categoria->iconCategoria}}"></i></h4>
            </div>
            <ul class="list-group">
                <li class="list-group-item bg-sistema-uno text-light d-none d-sm-block">
                    <div class="row">
                        <div class="col-md-2">
                            <h6>Grupo</h6>
                        </div>
                        @foreach($rangos as $rango)
                        <div class="col-md-1 text-center">
                            <h6>{{$rango->descripcion}}</h6>
                        </div>
                        @endforeach
                    </div>
                </li>
               @foreach($categoria->GrupoProducto()->select('idGrupoProducto','nombreGrupo')->get() as $grupo)
                <li class="list-group-item pt-0 pb-0" style="border-color: #bcbcbc;">
                    <div class="row h-100 mb-0" id="div-comision-{{$grupo->idGrupoProducto}}">
                        <div class="col-12 col-md-2 pt-2 d-none d-sm-block">
                            <h6>{{$grupo->nombreGrupo}}</h6>
                        </div>
                        <div class="col-12 d-block d-sm-none text-center">
                            <h6>{{$grupo->nombreGrupo}}</h6>
                        </div>
                        @foreach($grupo->Comision as $comision)
                        <div class="col-6 pt-2 pb-2 {{$comision->idRango % 2 == 0 ? 'bg-list' : '' }} d-block d-sm-none text-center">
                            {{$comision->RangoPrecio->descripcion}}
                        </div>
                        <div class="col-6 col-md-1 pt-2 pb-2 {{$comision->idRango % 2 == 0 ? 'bg-list' : '' }} text-center">
                            <small>{{$comision->comision}} %</small>
                            <input type="hidden" class="hidden-comision" data-descripcion="{{$comision->RangoPrecio->descripcion}}" data-rango="{{$comision->idRango}}" value="{{$comision->comision}}">
                        </div>
                        @endforeach
                        <div class="col-12 col-md-1 pt-1 pb-1 text-center">
                            <button type="button" class="btn btn-info btn-sm text-light" onclick="modalComision('{{$grupo->nombreGrupo}}',{{$grupo->idGrupoProducto}},{{$categoria->idCategoria}})" data-bs-toggle="modal" data-bs-target="#comisionModal">Edit</button>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
    <br>
    <div class="row border shadow rounded-3 pt-2 pb-2">
        <div class="col-md-12">
            <h3>Calculos por Plataforma</h3>
            <p class="text-secondary">Valores que se aplican a los precios por plataforma digital.</p>
        </div>
        <div class="col-md-12">
            <ul class="list-group">
                @foreach ($plataformas as $plataforma)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-1">
                                <img src="{{asset('storage/'. $plataforma->imagenPlataforma)}}" alt="" class="border w-100">
                            </div>
                            <div class="col-md-7">
                                <h4>{{$plataforma->nombrePlataforma}}</h4>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-sm btn-success"><i class="bi bi-trash-fill"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <ul class="list-group list-group-flush" >
                                @foreach ($plataforma->ComisionPlataforma as $comision)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="text-secondary">Comision</label>
                                                <h6>{{$comision->comision}}</h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <label class="text-secondary">Flete</label>
                                                <h6>{{$comision->flete}}</h6>
                                            </div>
                                            <div class="col-md-4 text-end d-flex align-items-center justify-content-end">
                                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <br>
    <form action="{{route('updatecomision')}}" method="POST">
        @csrf
        <div class="modal fade" id="comisionModal" tabindex="-1" aria-labelledby="comisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comisionModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ps-0 pe-0 pt-0">
                <ul class="list-group list-group-flush ">
                    @foreach($rangos as $rango)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <h6>{{$rango->descripcion}}</h6>
                            </div>
                            <div class="col-6 col-md-6">
                                <input type="number" name="comision[{{$rango->idRango}}]" class="form-control" id="comisionModalList-{{$rango->idRango}}" step="0.01">
                                
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="grupo" id="comisionHiddenGrup" value="">
                <input type="hidden" id="categoryModalComision" name="category" value="{{ old('category', 1) }}">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Actualizar <i class="bi bi-floppy"></i></button>
            </div>
            </div>
        </div>
        </div>
        </form>
</div>
<script>
    let isDisabledCalGeneral = false;
    let isDisabledCorreos = false;
    function modalComision(titulo,grupo,categoria){
            let tituloComision = document.getElementById('comisionModalLabel');
            let divComision = document.getElementById('div-comision-' + grupo);
            let listComisiones = divComision.querySelectorAll('.hidden-comision');
            let hiddenGroup = document.getElementById('comisionHiddenGrup');
            let hiddenCategory = document.getElementById('categoryModalComision');
            
            
            listComisiones.forEach(function(x){
                let liComision = document.getElementById('comisionModalList-' + x.dataset.rango);
                
                liComision.value = x.value;
            });
            
            hiddenGroup.value = grupo;
            hiddenCategory.value = categoria;
            
            tituloComision.textContent = 'Comisiones: ' + titulo;
        }

        function viewElementsComision(category){
            @foreach($categorias as $categoria)
                if(category == {{$categoria->idCategoria}}){
                    let divCategory  = document.querySelectorAll('.divCategory-' + {{$categoria->idCategoria}});
                    divCategory.forEach(function(x){
                        x.style.display = 'block';
                    });
                }else{
                    let divCategory  = document.querySelectorAll('.divCategory-' + {{$categoria->idCategoria}});
                    divCategory.forEach(function(x){
                        x.style.display = 'none';
                    });
                }
            @endforeach
        }

        function calculateGeneralDisabled() {
            let btnSaveCalculos = document.getElementById('btnSaveCalculos');
            let divCalculosGenerales = document.getElementById('calculos-generales');
            let btnEditCalcGeneral = divCalculosGenerales.querySelectorAll('.input-edit'); 
        
            isDisabledCalGeneral = !isDisabledCalGeneral;
            
            if(isDisabledCalGeneral){
                btnSaveCalculos.style.display = 'none';
            }else{
                btnSaveCalculos.style.display = 'inline-flex';
            }
        
            btnEditCalcGeneral.forEach(function(x) {
                x.disabled = isDisabledCalGeneral;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            calculateGeneralDisabled();
            let oldCategoryComision = document.getElementById('categoryModalComision').value;
            viewElementsComision(oldCategoryComision);
                
    });
</script>
@endsection