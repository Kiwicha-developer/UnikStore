@if( !$registros->isEmpty())
    <div class="row">
        <div class="col-md-12">
            <ul class="list-group" style="position: relative;overflow-y:auto;overflow-x:hidden;height:70vh">
                <li class="list-group-item {{$data['color']}} text-light" style="position: sticky;top:0;z-index:800">
                    <div class="row text-center ">
                        <div class="col-6 col-md-3">
                            <p class="mb-0">Producto</p>
                        </div>
                        <div class="col-md-3 d-none d-md-block">
                            <p class="mb-0">Serie</p>
                        </div>
                        <div class="col-3 col-md-1">
                            <p class="mb-0">Almac&eacute;n</p>
                        </div>
                        <div class="col-md-3 d-none d-md-block">
                            <p class="mb-0">Observaci&oacute;n</p>
                        </div>
                        <div class="col-3 col-md-2">
                            <p class="mb-0">
                            @switch($data['pestania'])
                                @case('Nuevos')
                                    Ingreso
                                    @break
                                @case('Entregados')
                                    Egreso
                                    @break
                                @case('Devoluciones')
                                    Devolucion
                                    @break
                                @case('Abiertos')
                                    Apertura
                                    @break
                                @case('Defectuosos')
                                    Defecto
                                    @break
                                @case('Rotos')
                                    Daño
                                    @break
                                @default
                            @endswitch
                            </p>
                        </div>
                    </div>
                </li>
                @php
                    $cont = 0;
                @endphp
                @foreach ($registros as $registro)
                    <li class="list-group-item">
                        <div class="row text-center">
                            <div class="col-12 col-md-4 col-lg-3 text-start">
                                <small class="fw-bold">{{$registro->DetalleComprobante->Producto->modelo}} <br class="d-none d-md-block d-lg-none"><em class="text-secondary fw-normal">{{$registro->DetalleComprobante->Producto->codigoProducto}}</em></small>
                            </div>
                            <div class="col-6 col-md-5 col-lg-3 text-start text-md-center">
                                <small>{{$registro->numeroSerie}}</small>
                            </div>
                            <div class="col-3 col-md-1">
                                <small>{{$registro->Almacen->descripcion}}</small>
                            </div>
                            <div class="col-md-3 d-none d-lg-block" style="position: relative">
                                @if($registro->observacion != null || $registro->observacion != '')
                                <small><a href="javascript:void(0)" class="link-sistema" data-bs-toggle="collapse" data-bs-target="#collapseExample-{{$cont}}" role="button" aria-expanded="false" aria-controls="collapseExample-{{$cont}}">
                                    Observaci&oacute;n
                                </a></small>
                                <div class="collapse pt-2" id="collapseExample-{{$cont}}" style="position: absolute; top: 100%; left: 0; width: 100%;z-index:700">
                                    <div class="card card-body">
                                        {{$registro->observacion}}
                                    </div>
                                </div>
                                @else
                                <small>Sin observaci&oacute;n</small>
                                @endif
                                    
                                
                            </div>
                            
                            <div class="col-3 text-end text-md-center col-md-2">
                                @switch($data['pestania'])
                                    @case('Nuevos')
                                        <small>{{$registro->IngresoProducto->fechaIngreso->format('d/m/Y')}}</small>
                                        @break
                                    @case('Entregados')
                                        <small>{{$registro->EgresoProducto ? $registro->EgresoProducto->fechaDespacho->format('d/m/Y') : 'Sin Egreso'}}</small>
                                        @break
                                    @case('Devoluciones')
                                        <small>{{$registro->fechaMovimiento->format('d/m/Y')}}</small>
                                        @break
                                    @case('Abiertos')
                                        <small>{{$registro->fechaMovimiento->format('d/m/Y')}}</small>
                                        @break
                                    @case('Defectuosos')
                                        <small>{{$registro->fechaMovimiento->format('d/m/Y')}}</small>
                                        @break
                                    @case('Rotos')
                                        <small>{{$registro->fechaMovimiento->format('d/m/Y')}}</small>
                                        @break
                                    @default
                                @endswitch
                            </div>
                        </div>
                    </li>
                    @php
                        $cont ++;
                    @endphp
                @endforeach
            </ul>
        </div>
    </div>
@else
    <div class="row align-items-center" style="height:70vh">
        <x-aviso_no_encontrado :mensaje="''" />
    </div>
@endif
<br>
<x-paginacion :justify="'end'" :coleccion="$registros" :container="$container"/>