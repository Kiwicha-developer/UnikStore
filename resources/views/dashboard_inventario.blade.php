@extends('layouts.app')

@section('title', $data['pestania'])

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-12">
            <h2><a href="{{route('dashboard')}}" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> {{ $data['titulo']}} <i class="bi bi-{{$data['icon']}}"></i></h2>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <ul class="list-group" style="position: relative;overflow-y:auto;overflow-x:hidden;height:70vh">
                <li class="list-group-item {{$data['color']}} text-light" style="position: sticky;top:0;z-index:800">
                    <div class="row text-center ">
                        <div class="col-md-3">
                            <p class="mb-0">Producto</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-0">Serie</p>
                        </div>
                        <div class="col-md-1">
                            <p class="mb-0">Almac&eacute;n</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-0">Observaci&oacute;n</p>
                        </div>
                        <div class="col-md-2">
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
                            <div class="col-md-3 text-start">
                                <small class="fw-bold">{{$registro->DetalleComprobante->Producto->modelo}} <em class="text-secondary fw-normal">{{$registro->DetalleComprobante->Producto->codigoProducto}}</em></small>
                            </div>
                            <div class="col-md-3">
                                <small>{{$registro->numeroSerie}}</small>
                            </div>
                            <div class="col-md-1">
                                <small>{{$registro->Almacen->descripcion}}</small>
                            </div>
                            <div class="col-md-3" style="position: relative">
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
                            
                            <div class="col-md-2">
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
    
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Obtenemos todos los elementos con el atributo 'data-toggle="collapse"'
        const collapseTriggers = document.querySelectorAll('[data-toggle="collapse"]');

        // Función para cerrar todos los colapsables
        function closeAllCollapses() {
            const allCollapses = document.querySelectorAll('.collapse');
            allCollapses.forEach(function (collapse) {
                // Si el colapsable está abierto, lo cerramos
                if (collapse.classList.contains('show')) {
                    collapse.classList.remove('show');
                }
            });
        }

        // Escuchamos el clic en el documento
        document.addEventListener('click', function (event) {
            // Si el clic no está dentro del colapsable ni en el botón que lo activa
            const isClickInsideCollapse = event.target.closest('.collapse');
            const isClickInsideToggle = event.target.closest('[data-toggle="collapse"]');

            if (!isClickInsideCollapse && !isClickInsideToggle) {
                closeAllCollapses(); // Cerramos todos los colapsables
            }
        });

        // Evitar que el clic en el botón colapsable cierre el colapsable
        collapseTriggers.forEach(function (trigger) {
            trigger.addEventListener('click', function (event) {
                event.stopPropagation(); // Previene el cierre al hacer clic en el botón
            });
        });
    });
</script>

@endsection