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
    @if($pagina == 'web')
    <div class="row border shadow rounded-3 pt-2 pb-2" id="correos-empresa">
        <form action="{{route('updatecorreos')}}" method="POST">
             @csrf
        <div class="col-md-12">
            <div class="row ">
                <div class="col-8 col-md-6">
                    <h3>Correos Web</h3>
                    <p class="text-secondary">Correos corporativos registrados para la web.</p>
                </div>
                <div class="col-4 col-md-6 text-end">
                    <button class="btn btn-success" type="submit" id="btnSaveCorreos"> <i class="bi bi-floppy"></i></button>
                    <button class="btn btn-secondary" type="button" onclick="correosEmpresaDisabled()"> <i class="bi bi-pencil"></i></button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                @foreach($empresas as $empresa)
                <div class="col-md-6">
                    <label>{{$empresa->nombreComercial}}:</label>
                    <input type="text" name="correos[{{$empresa->idEmpresa}}]" class="form-control input-edit" value="{{$empresa->correoEmpresa}}">
                </div>
                @endforeach
            </div>
        </div>
        </form>
    </div>
    <br>
    <div class="row border shadow rounded-3 pt-2 pb-2">
        <div class="col-md-12">
            <div class="row ">
                <div class="col-md-12">
                    <h3>Datos Bancarios</h3>
                    <p class="text-secondary">N&uacutemeros de cuenta registrados para la web.</p>
                </div>
            </div>
        </div><div class="col-md-12">
            <div class="row ">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @foreach($empresas as $empresa)
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-empresa-{{$empresa->idEmpresa}}" aria-expanded="false" aria-controls="flush-empresa-{{$empresa->idEmpresa}}">
                            <h5>{{$empresa->nombreComercial}}</h5>
                          </button>
                        </h2>
                        <div id="flush-empresa-{{$empresa->idEmpresa}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                              <ul class="list-group">
                                <li class="list-group-item bg-sistema-uno text-light">
                                    <div class="row text-center">
                                        <div class="col-md-2">
                                            <h6>Bancos</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6>N&uacutemeros de cuenta</h6>
                                        </div>
                                        <div class="col-md-2">
                                            <h6>Tipo</h6>
                                        </div>
                                        <div class="col-md-1">
                                            <h6>Moneda</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <h6>Titular</h6>
                                        </div>
                                        <div class="col-md-1">
                                            <h6>Editar</h6>
                                        </div>
                                    </div>
                                </li>
                                @foreach($empresa->CuentasTransferencia->sortBy('idBanco') as $cuenta)
                                <li class="list-group-item {{$cuenta->tipoCuenta == 'INTERBANCARIA' ? 'bg-list' : ''}}">
                                    <div class="row">
                                        <div class="col-md-2 fw-bold">
                                            <small style="color:{{$cuenta->Banco->colorBanco}}">{{$cuenta->Banco->nombreBanco}}</small>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <small>{{$cuenta->numeroCuenta}}</small>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <small>{{$cuenta->tipoCuenta}}</small>
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <small>{{$cuenta->tipoMoneda}}</small>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <small>{{$cuenta->titular}}</small>
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <button class="btn" data-bs-toggle="modal" data-bs-target="#cuentasBancariasModal"><i class="bi bi-pencil"></i></button>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                          </div>
                        </div>
                      </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
    <br>
    @endif
    @if ($pagina == 'calculos')
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
    @endif
    @if ($pagina == 'especificaciones')
    <div id="caracteristicas-container">
        <div class="row">
            <div class="col-md-6">
                <h3 class="mt-2">Especificaciones 
                    <a class="fs-4" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createSpectModal">
                        <i class="bi bi-plus-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Nueva especificacion"></i>
                    </a>
                </h3>
            </div>
            <div class="col-md-6 text-end pt-2">
                <a class="fs-4 text-secondary" onclick="viewCategoriasXGrupos()" href="javascript:void(0)"  data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Categorias y Grupos">
                    <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
            <div class="col-md-12 text-secondary">
                <small>Especificaciones generales para todos los grupos.</small>
            </div>
            <div class="col-md-12 mt-2">
                <ul class="list-group">
                    <li class="list-group-item bg-sistema-uno text-light">
                        <div class="row">
                            <div class="col-md-3">
                                <h6>Especificacion</h6>
                            </div>
                            <div class="col-md-8 text-center">
                                <h6>Grupos</h6>
                            </div>
                        </div>
                    </li>
                    @foreach ($caracteristicas as $caracteristica)
                        <li class="list-group-item">
                            <div class="row h-100">
                                <div class="col-md-3">
                                    <strong>{{$caracteristica->especificacion}}</strong>
                                </div>
                                <div class="col-md-8 text-secondary text-center">
                                    @foreach ($caracteristica->Caracteristicas_Grupo as $grupo)
                                    {{ $loop->index  == 0 ? '' : ' | '}}
                                    <small class="text-decoration-underline">{{$grupo->GrupoProducto->nombreGrupo}}</small>
                                    @endforeach
                                </div>
                                <div class="col-md-1 text-end">
                                    <button class="btn btn-danger {{count($caracteristica->Caracteristicas_Grupo) == 0 ? '' : 'd-none'}}"><i class="bi bi-trash3-fill"></i></button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div id="category-container">
        @foreach ($categorias as $categoria)
        <div class="row div-spect" data-category="{{$categoria->idCategoria}}">
            <div class="col-md-9 d-flex align-items-center pt-1">
                <a class="fs-4 text-secondary" href="javascript:void(0)" onclick="viewCaracteristicas()" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Caracteristicas"><i class="bi bi-arrow-left-circle"></i></a>
                <h3 class="mt-2 ms-1"><i class="{{$categoria->iconCategoria}}"></i> {{$categoria->nombreCategoria}}</h3>
            </div>
            <div class="col-md-3 d-flex align-items-center justify-content-end">
                <div class="btn-group dropstart">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorias
                    </button>
                    <ul class="dropdown-menu">
                        @foreach ($categorias as $cat)
                            <li><a class="dropdown-item" href="#" onclick="viewDivSpect({{$cat->idCategoria}})">{{$cat->nombreCategoria}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-12 text-secondary">
                <small>Especificaciones asignadas para cada grupo.</small>
            </div>
            @foreach ($categoria->GrupoProducto as $grupo)
            <div class="col-md-12 mt-2">
                <div class="row border shadow rounded-3 mb-3">
                    <div class="col-md-6 d-flex align-items-center border-bottom border-secondary">
                        <h5 class="pt-1">{{$grupo->nombreGrupo}}</h5>
                    </div>
                    <div class="col-md-6 border-bottom border-secondary text-end pt-1 pb-1">
                        <button class="btn btn-sm btn-success" onclick="sendGrupoToModal({{$grupo->idGrupoProducto}},'{{$grupo->nombreGrupo}}')" data-bs-toggle="modal" data-bs-target="#spectXGrupoModal">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                    <div class="col-md-12 bg-list">
                        <div class="row pt-2 pe-2 pb-1">
                            @foreach ($grupo->Caracteristicas_Grupo as $caracteristica)
                            <div class="col-md-2 mb-1">
                                <div class="row ms-1 h-100 border bg-light rounded-2 truncate">
                                    <small>
                                        <a href="javascript:void(0)" class="text-dark link-danger">
                                            <i class="bi bi-x-lg "></i></a>
                                        {{$caracteristica->Caracteristicas->especificacion}}
                                    </small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
    </div>
    @endforeach
    </div>
    @endif
    <!-- Modal -->
    @if($pagina == 'calculos')
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
    @endif
    @if($pagina == 'web')
        <div class="modal fade" id="cuentasBancariasModal" tabindex="-1" aria-labelledby="cuentasBancariasModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cuentasBancariasModalLabel">Example</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ps-0 pe-0 pt-0">
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
    @endif
    @if ($pagina == 'especificaciones')
    <form action="{{route('insertcaracteristicaxgrupo')}}" method="POST">
        @csrf
        <div class="modal fade" id="spectXGrupoModal" tabindex="-1" aria-labelledby="spectXGrupoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="spectXGrupoModalLabel">Agregar Especificaci&oacute;n <span id="title-modal-addespecificacionxgrupo"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="grupo" value="" id="hidden-modal-addespecificacionxgrupo-grupo">
                                <input type="hidden" name="caracteristica" value="" id="hidden-modal-addespecificacionxgrupo-especificacion">
                                <input class="form-control" type="text" placeholder="Busca una caracteristica..." id="text-modal-addespecificacionxgrupo" readonly>
                            </div>
                            <div class="col-md-12 mt-3">
                                <input class="form-control" oninput="inputSearch(this);disableButtonSave();" type="text" placeholder="busca aqui!!">
                                <ul class="list-group" id="modal-addespecificacionxgrupo-results" style="position:absolute;top:100%;z-index:1000"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btn-modal-addespecificacionxgrupo"><i class="bi bi-floppy"></i> Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="{{route('createcaracteristica')}}" method="POST">
        @csrf
    <div class="modal fade" id="createSpectModal" tabindex="-1" aria-labelledby="createSpectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSpectModalLabel">Agregar Especificaci&oacute;n</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Especificacion:</label>
                            <input type="text" name="descripcion" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    @endif
    <br>
</div>
<script>
    let isDisabledCalGeneral = false;
    let isDisabledCorreos = false;

    @if($pagina == 'web')
        function correosEmpresaDisabled() {
            let btnSaveCorreo = document.getElementById('btnSaveCorreos');
            let divCorreoEmpresa = document.getElementById('correos-empresa');
            let btnEditCorreoEmpresa = divCorreoEmpresa.querySelectorAll('.input-edit'); 
        
            isDisabledCorreos= !isDisabledCorreos;
            
            if(isDisabledCorreos){
                btnSaveCorreo.style.display = 'none';
            }else{
                btnSaveCorreo.style.display = 'inline-flex';
            }
        
            btnEditCorreoEmpresa.forEach(function(x) {
                x.disabled = isDisabledCorreos;
            });
        }
    @endif
    
    @if($pagina == 'calculos')
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
    @endif
    
    @if ($pagina == 'especificaciones')
        var dataSpects = Object.values(@json($caracteristicas));
        
        function viewDivSpect(idCategory){
            let divSpects = document.querySelectorAll('.div-spect');
            divSpects.forEach(function(x){
                if(x.dataset.category == idCategory){
                    x.style.display = 'flex';
                }else{
                    x.style.display = 'none';
                }
            });
        }

        function viewCaracteristicas(){
            let categoryContainer = document.getElementById('category-container');
            let caracteristicasContainer = document.getElementById('caracteristicas-container');

            caracteristicasContainer.style.display = 'block';
            categoryContainer.style.transition = 'transform 0.5s ease, opacity 0.5s ease'; // Asegúrate de añadir la transición
            categoryContainer.style.transform = 'translateX(100%)'; // Comillas alrededor de la transformación
            categoryContainer.style.opacity = '0';
            

            setTimeout(() => {
                categoryContainer.style.display = 'none';
                caracteristicasContainer.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
                caracteristicasContainer.style.transform = 'translateX(0)';
                caracteristicasContainer.style.opacity = '1';
            }, 500);
        }

        function viewCategoriasXGrupos(){
            let categoryContainer = document.getElementById('category-container');
            let caracteristicasContainer = document.getElementById('caracteristicas-container');

            categoryContainer.style.display = 'block';
            caracteristicasContainer.style.transition = 'transform 0.5s ease, opacity 0.5s ease'; // Asegúrate de añadir la transición
            caracteristicasContainer.style.transform = 'translateX(-100%)'; // Comillas alrededor de la transformación
            caracteristicasContainer.style.opacity = '0';
            

            setTimeout(() => {
                caracteristicasContainer.style.display = 'none';
                categoryContainer.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
                categoryContainer.style.transform = 'translateX(0)';
                categoryContainer.style.opacity = '1';
            }, 500);
        }

        function sendGrupoToModal(id,title){
            let inputHidden = document.getElementById('hidden-modal-addespecificacionxgrupo-grupo');
            let spanTitle = document.getElementById('title-modal-addespecificacionxgrupo');
            let inputHiddeSpect = document.getElementById('hidden-modal-addespecificacionxgrupo-especificacion'); 
            let textSpect = document.getElementById('text-modal-addespecificacionxgrupo');
            inputHidden.value = '';
            inputHiddeSpect.value = '';
            textSpect.value = '';

            spanTitle.textContent = title;
            inputHidden.value = id;
        }

        function disableButtonSave(){
            let btnModalCaracteristicas = document.getElementById('btn-modal-addespecificacionxgrupo');
            let inputHiddenGrupo = document.getElementById('hidden-modal-addespecificacionxgrupo-grupo');
            let inputHiddenCar = document.getElementById('hidden-modal-addespecificacionxgrupo-especificacion');
            let disabled = false;

            if(inputHiddenGrupo.value == ''){
                disabled = true;
            }

            if(inputHiddenCar.value == ''){
                disabled = true;
            }

            btnModalCaracteristicas.disabled = disabled;
        }

        function search(query) {
            return dataSpects.filter(item => item.especificacion.toLowerCase().includes(query.toLowerCase())).slice(0, 5);
        }

        function inputSearch(input){
            const query = input.value;
            const results = search(query);
            const resultsContainer = document.getElementById('modal-addespecificacionxgrupo-results');
            resultsContainer.innerHTML = '';

            if(query.length > 0){
                results.forEach(item => {
                    const li = document.createElement('li');
                    li.style.cursor = "pointer";
                    li.classList.add('list-group-item', 'hover-sistema-uno');
                    li.textContent = `${item.especificacion}`;

                    li.addEventListener('click', function() {
                            document.getElementById('hidden-modal-addespecificacionxgrupo-especificacion').value = item.idCaracteristica; 
                            document.getElementById('text-modal-addespecificacionxgrupo').value = item.especificacion;
                            disableButtonSave();
                            resultsContainer.innerHTML = ''; 
                        });
                    resultsContainer.appendChild(li);
                });
            }else {
                resultsContainer.innerHTML = '';
            }
        }
    @endif
    
    document.addEventListener('DOMContentLoaded', function() {
        @switch($pagina)
            @case('web')
                correosEmpresaDisabled();
                @break
            @case('calculos')
                calculateGeneralDisabled();
                let oldCategoryComision = document.getElementById('categoryModalComision').value;
                viewElementsComision(oldCategoryComision);
                @break
            @case('especificaciones')
                viewDivSpect(1);
                disableButtonSave();
                document.getElementById('caracteristicas-container').style.display = 'none';
                document.getElementById('caracteristicas-container').style.transform = 'translateX(-100%)';
                document.getElementById('caracteristicas-container').style.opacity = '0';
                @break
            @default
        @endswitch
        
    });
</script>
@endsection