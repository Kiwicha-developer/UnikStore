@extends('layouts.app')

@section('title', 'Configuraci¨®n')

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2><i class="bi bi-gear-fill"></i> Configuraci&oacuten</h2>
        </div>
    </div>
    <br>
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
    <div class="row border shadow rounded-3">
        <div class="col-md-12">
            <h3>Rangos de comisiones</h3>
        </div>
    </div>
    
    <!-- Modal -->
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
    <br>
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
    
    document.addEventListener('DOMContentLoaded', function() {
        let oldCategoryComision = document.getElementById('categoryModalComision').value;
        viewElementsComision(oldCategoryComision);
        
        calculateGeneralDisabled();
        correosEmpresaDisabled();
    });
</script>
@endsection