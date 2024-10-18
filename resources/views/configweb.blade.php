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
</div>
<script>
    let isDisabledCalGeneral = false;
    let isDisabledCorreos = false;

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
        correosEmpresaDisabled();
    });
</script>
@endsection