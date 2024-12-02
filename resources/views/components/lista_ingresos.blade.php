@if(!$registros->isEmpty())
<div class="row">
    <div class="col-md-12" style="overflow-x: hidden;overflow-y:auto;height: 60vh">
        <ul class="list-group">
            <li class="list-group-item bg-sistema-uno text-light" style="position: sticky;top:0;z-index:800">
                <div class="row text-center">
                    <div class="col-3 col-md-2 text-start">
                        <small>Producto</small>
                    </div>
                    <div class="col-lg-2 d-none d-lg-block">
                        <small>Comprobante</small>
                    </div>
                    <div class="col-lg-1 d-none d-lg-block">
                        <small>Usuario</small>
                    </div>
                    <div class="col-6 col-lg-3">
                        <small>Nro Serie</small>
                    </div>
                    <div class="col-md-2 col-lg-1 d-none d-md-block">
                        <small>Precio</small>
                    </div>
                    <div class="col-lg-1 d-none d-lg-block">
                        <small>Adquisicion</small>
                    </div>
                    <div class="col-lg-1 d-none d-lg-block">
                        <small>Estado</small>
                    </div>
                    <div class="col-3 col-md-2 col-lg-1 text-end">
                        <small>Registro</small>
                    </div>
                </div>
            </li>
            @foreach($registros as $registro)
            <li
                class="list-group-item list-ingreso-{{$registro->idUser}} list-ingreso-all {{$registro->RegistroProducto->estado == 'INVALIDO' ? 'text-decoration-line-through text-danger' : ''}}">
                <div class="row text-center">
                    <div class="col-3 col-md-2 text-start">
                        <small data-bs-toggle="tooltip" data-bs-placement="top"
                            title="{{$registro->RegistroProducto->DetalleComprobante->Producto->nombreProducto}}">
                            <a class="decoration-link"
                                href="{{route('producto',[encrypt($registro->RegistroProducto->DetalleComprobante->Producto->idProducto)])}}">{{$registro->RegistroProducto->DetalleComprobante->Producto->codigoProducto}}</a>
                        </small>
                    </div>
                    <div class="col-lg-2 d-none d-lg-block">
                        <small data-bs-toggle="tooltip" data-bs-placement="top"
                            title="{{$registro->RegistroProducto->DetalleComprobante->Comprobante->Preveedor->nombreProveedor}}">
                            <a class="decoration-link"
                                href="{{route('documento',[encrypt($registro->RegistroProducto->DetalleComprobante->Comprobante->idComprobante),0])}}">{{$registro->RegistroProducto->DetalleComprobante->Comprobante->numeroComprobante}}</a>
                        </small>
                    </div>
                    <div class="col-lg-1 d-none d-lg-block">
                        <small>{{$registro->Usuario->user}}</small>
                    </div>
                    <div class="col-6 col-lg-3">
                        <small>
                            <a class="decoration-link" href="javascript:void(0)"
                                onclick="dataModalDetalle({{ json_encode($registro) }})">
                                {{$registro->RegistroProducto->numeroSerie}}
                            </a>
                        </small>
                    </div>
                    <div class="col-md-2 col-lg-1 d-none d-md-block">
                        <small>{{$registro->RegistroProducto->DetalleComprobante->Comprobante->moneda == 'DOLAR' ? '$ '
                            : 'S/. '}}{{number_format($registro->RegistroProducto->DetalleComprobante->precioUnitario,
                            2)}}</small>
                    </div>
                    <div class="col-md-1 d-none d-lg-block">
                        <small>{{$registro->RegistroProducto->DetalleComprobante->Comprobante->adquisicion}}</small>
                    </div>
                    <div class="col-lg-1 d-none d-lg-block">
                        <small>
                            {{ $registro->RegistroProducto->estado }}
                        </small>
                    </div>
                    <div class="col-3 col-md-2 col-lg-1 text-end">
                        <small>{{$registro->fechaIngreso->format('d/m/Y')}}</small>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<br>
@else
<div class="row align-items-center" style="height:80vh">
    <x-aviso_no_encontrado :mensaje="''" />
</div>
@endif
<x-paginacion :justify="'end'" :coleccion="$registros" :container="$container"/>