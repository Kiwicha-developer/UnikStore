@extends('layouts.app')

@section('title', 'Egresos')
@php
    setlocale(LC_TIME, 'es_ES.UTF-8');
@endphp

@section('content')
    <div class="container">
        <br>
        En Mantenimiento (Evitar usar)
        <div class="row">
            <div class="col-6 col-md-5">
                <div class="input-group mb-3" style="z-index:1000">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Serial Number..." id="search">
                    <ul class="list-group w-100" style="position:absolute;top:100%;z-index:1000" id="suggestions">
                    </ul>
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-6 col-md-4 text-end">
                <input type="month" class="form-control" id="month" name="month"
                    value="{{ $fecha->format('Y-m') }}">
            </div>
            <div class="col-md-8">
                <h2><a href="{{ route('documentos', [now()->format('Y-m')]) }}" class="text-secondary"><i
                            class="bi bi-arrow-left-circle"></i></a> <i class="bi bi-file-earmark-minus-fill"></i>
                    Egresos<span
                        class="text-capitalize text-secondary fw-light"><em>({{ $fecha->translatedFormat('F') }})</em></span>
                </h2>
            </div>

            <div class="col-md-4 text-end">
                <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#egresoModal"><i
                        class="bi bi-plus-lg"></i> Nuevo Egreso</a>
            </div>
        </div>
        <br>
        <div class="row">
            <ul class="list-group" style="position: relative;overflow-x:hidden;overflow-y:auto;height:70vh">
                <li class="list-group-item bg-sistema-uno text-light" style="position:sticky;top:0;z-index:800">
                    <div class="row text-center">
                        <div class="col-md-2 text-start">
                            <small>Producto</small>
                        </div>
                        <div class="col-md-2">
                            <small>Nro Orden</small>
                        </div>
                        <div class="col-md-1">
                            <small>Usuario</small>
                        </div>
                        <div class="col-md-2">
                            <small>SKU</small>
                        </div>
                        <div class="col-md-2">
                            <small>Serial Number</small>
                        </div>
                        <div class="col-md-1">
                            <small>Estado</small>
                        </div>
                        <div class="col-md-1">
                            <small>Pedido</small>
                        </div>
                        <div class="col-md-1">
                            <small>Despacho</small>
                        </div>
                    </div>
                </li>
                @foreach ($egresos as $egreso)
                    <li class="list-group-item">
                        <div class="row text-center">
                            <div class="col-md-2 text-start">
                                <small>
                                    <a
                                        href="{{ route('producto', [encrypt($egreso->RegistroProducto->DetalleComprobante->Producto->idProducto)]) }}" class="decoration-link">
                                        {{ $egreso->RegistroProducto->DetalleComprobante->Producto->codigoProducto }}
                                    </a>
                                </small>
                            </div>
                            <div class="col-md-2">
                                <small>{{ is_null($egreso->numeroOrden) ? 'No aplica' : $egreso->numeroOrden }}</small>
                            </div>
                            <div class="col-md-1">
                                <small>{{ $egreso->Usuario->user }}</small>
                            </div>
                            <div class="col-md-2">
                                <small>{{ is_null($egreso->Publicacion) || is_null($egreso->Publicacion->sku) ? 'No aplica' : $egreso->Publicacion->sku }}</small>
                            </div>
                            <div class="col-md-2">
                                <small>{{ $egreso->RegistroProducto->numeroSerie }}</small>
                            </div>
                            <div class="col-md-1">
                                <a href="javascript:void(0)" onclick='viewModalEgreso("{{$egreso->RegistroProducto->DetalleComprobante->Producto->nombreProducto}}",@json($egreso->RegistroProducto),@json($egreso),@json($egreso->Publicacion))' class="decoration-link"><small>{{ $egreso->RegistroProducto->estado }}</small></a>
                            </div>
                            <div class="col-md-1">
                                <small>{{ $egreso->fechaCompra->format('d/m/y') }}</small>
                            </div>
                            <div class="col-md-1">
                                <small>{{ $egreso->fechaDespacho->format('d/m/y') }}</small>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- Modal -->
        <form action="{{ route('insertegreso') }}" method="POST">
            @csrf
            <div class="modal fade" id="egresoModal" tabindex="-1" aria-labelledby="egresoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="egresoModalLabel">Nuevo Egreso</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-2" style="position:relative">
                                    <label>Numero de Serie</label>
                                    <input type="text" oninput="searchRegistro(this)" name="serialnumber"
                                        placeholder="Serial Number" class="form-control input-egreso"
                                        id="input-serial-number">
                                    <input type="hidden" value="" name="idregistro"
                                        id="hidden-product-serial-number">
                                    <ul class="list-group" id="suggestions-serial-number" name="idregistro"
                                        style="position:absolute;z-index:1000;top:100%;left:0;width:100%"></ul>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>SKU</label>
                                        </div>
                                        <div class="col-md-6 text-end text-secondary">
                                            <label>No aplica</label>
                                        </div>
                                    </div>
                                    <div class="input-group" style="position:relative">
                                        <input type="text" oninput="searchPublicacion(this)" name="sku"
                                            class="form-control input-egreso" id="input-sku-egreso"
                                            placeholder="SKU de una publicacion">
                                        <input type="hidden" id="hidden-publicacion-sku" name="idpublicacion"
                                            value="">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" id="check-sku-egreso"
                                                value="No aplica">
                                        </div>
                                        <ul class="list-group" id="suggestions-sku"
                                            style="position:absolute;z-index:1000;top:100%;left:0;width:100%"></ul>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label>Numero de Orden</label>
                                    <input type="text" placeholder="Nro de Orden" id="input-numero-orden"
                                        name="numeroorden" class="form-control input-egreso">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Fecha de pedido</label>
                                    <input type="date" name="fechapedido" class="form-control input-egreso">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Fecha de despacho</label>
                                    <input type="date" name="fechadespacho" class="form-control input-egreso">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btnRegistrarEgreso" class="btn btn-success"><i
                                    class="bi bi-floppy"></i> Registrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal fade" id="detailEgresoModal" tabindex="-1" aria-labelledby="detailEgresoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 id="modal-egreso-titulo">Titulo del producto</h5>
                            </div>
                            <div class="col-md-6 text-secondary">
                                <h6 id="modal-egreso-serialnumber">serial number</h6>
                            </div>
                            <div class="col-md-6 text-secondary text-end">
                                <h6 id="modal-egreso-estado">estado</h6>
                            </div>
                            <div class="col-md-6" id="modal-egreso-fecha">
                                <p class="mb-0"><strong>Fecha Despacho:</strong></p>
                                <p class="mt-0"><strong>Fecha Entrega:</strong></p>
                            </div>
                            <div class="col-md-6 text-end">
                                <small><strong>Usuario:</strong></small>
                                <p class="mb-0"><small id="modal-egreso-usuario">Luiyi</small></p>
                            </div>
                            <div class="col-md-12" id="modal-egreso-observacion">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Observaci&oacute;n:</label>
                                <textarea class="form-control" maxlength="500" id="modal-egreso-observacion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row w-100 pe-0 ps-0">
                            <div class="col-md-6 ps-0">
                                <button type="button" class="btn btn-warning"><i class="bi bi-arrow-clockwise"></i> Devoluci&oacute;n</button>
                            </div>
                            <div class="col-md-6 pe-0 text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Cerrar</button>
                                <button type="button" class="btn btn-primary"><i class="bi bi-floppy"></i> Actualizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/egresos.js')}}"></script>
@endsection
