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
                    <input type="text" name="correos[{{$empresa->idEmpresa}}]" maxlength="50" class="form-control input-edit" value="{{$empresa->correoEmpresa}}">
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
                    <p class="text-secondary">N&uacute;meros de cuenta registrados para la web.</p>
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
                                        <div class="col-3 col-md-2 text-start">
                                            <h6>Bancos</h6>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <h6>N&uacutemeros de cuenta</h6>
                                        </div>
                                        <div class="col-3 col-md-2">
                                            <h6>Tipo</h6>
                                        </div>
                                        <div class="col-md-1 text-start d-none d-md-block">
                                            <h6>Moneda</h6>
                                        </div>
                                        <div class="col-md-3 d-none d-md-block">
                                            <h6>Titular</h6>
                                        </div>
                                        <div class="col-md-1 d-none d-md-block">
                                            <h6>Editar</h6>
                                        </div>
                                    </div>
                                </li>
                                @foreach($empresa->CuentasTransferencia->sortBy('idBanco') as $cuenta)
                                <li class="list-group-item {{$cuenta->tipoCuenta == 'INTERBANCARIA' ? 'bg-list' : ''}}">
                                    <div class="row">
                                        <div class="col-3 col-md-2 fw-bold">
                                            <small style="color:{{$cuenta->Banco->colorBanco}}">{{$cuenta->Banco->nombreBanco}}</small>
                                        </div>
                                        <div class="col-6 col-md-3 text-center">
                                            <small>{{$cuenta->numeroCuenta}}</small>
                                        </div>
                                        <div class="col-3 col-md-2 text-center truncate">
                                            <small>{{$cuenta->tipoCuenta}}</small>
                                        </div>
                                        <div class="col-3 col-md-1 text-start">
                                            <small>{{$cuenta->tipoMoneda}}</small>
                                        </div>
                                        <div class="col-6 col-md-3 text-center">
                                            <small>{{$cuenta->titular}}</small>
                                        </div>
                                        <div class="col-3 col-md-1 text-center">
                                            <button class="btn" onclick="sendDataToModalCuentas({{$cuenta->idCuentaBancaria}},'{{$cuenta->Banco->nombreBanco}}','{{$cuenta->tipoCuenta}}','{{$cuenta->titular}}','{{$cuenta->numeroCuenta}}')" 
                                                data-bs-toggle="modal" data-bs-target="#cuentasBancariasModal">
                                                <i class="bi bi-pencil"></i>
                                            </button>
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
    <form action="{{route('updatecuentasbancarias')}}" method="POST">
        @csrf
        <div class="modal fade" id="cuentasBancariasModal" tabindex="-1" aria-labelledby="cuentasBancariasModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <h5 class="modal-title" id="cuentasBancariasModalLabel">Cuenta <span id="span-modal-cuenta"></span></h5>
                        <small id="small-modal-cuenta" class="text-secondary"></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Titular:</label>
                            <input type="text" class="form-control" maxlength="50" name="titular" value="" id="input-titular-modal-cuenta">
                            <input type="hidden" name="id" id="hidden-modal-cuenta" value="">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Numero de cuenta:</label>
                            <input type="text" class="form-control" maxlength="30" name="cuenta" value="" id="input-cuenta-modal-cuenta">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
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

    function sendDataToModalCuentas(id,banco,tipo,titular,cuenta){
        let spanModal = document.getElementById('span-modal-cuenta');
        let smallModal = document.getElementById('small-modal-cuenta');
        let inputTitular = document.getElementById('input-titular-modal-cuenta');
        let inputCuenta = document.getElementById('input-cuenta-modal-cuenta');
        let hiddenModal = document.getElementById('hidden-modal-cuenta');

        spanModal.textContent = banco;
        smallModal.textContent = tipo;
        inputTitular.value = titular;
        inputCuenta.value = cuenta;
        hiddenModal.value = id;
    }

    document.addEventListener('DOMContentLoaded', function() {
        correosEmpresaDisabled();
    });
</script>
@endsection