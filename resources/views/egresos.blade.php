@extends('layouts.app')

@section('title', 'Egresos')
@php
    setlocale(LC_TIME, 'es_ES.UTF-8');
@endphp

@section('content')
    <div class="container">
        <div class="bg-secondary" id="hidden-body"
            style="position:fixed;left:0;width:100vw;height:100vh;z-index:998;opacity:0.5;display:none">
        </div>
        <br>
        <div class="row">
            <div class="col-6 col-md-7 col-lg-5">
                <div class="input-group mb-3" style="z-index:1000">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" oninput="searchEgreso(this)" placeholder="Serial Number..." id="search">
                    <ul class="list-group w-100" style="position:absolute;top:100%;z-index:1000" id="suggestions-egresos">
                    </ul>
                </div>
            </div>
            <div class="col-md-3 d-none d-lg-block"></div>
            <div class="col-6 col-md-5 col-lg-4 text-end">
                <input type="month" class="form-control" id="month" name="month"
                    value="{{ $fecha->format('Y-m') }}">
            </div>
            <div class="col-8 col-md-8">
                <h2><a href="{{ route('documentos', [now()->format('Y-m')]) }}" class="text-secondary"><i
                            class="bi bi-arrow-left-circle"></i></a> <i class="bi bi-file-earmark-minus-fill"></i>
                    Egresos<span
                        class="text-capitalize text-secondary fw-light"><em>({{ $fecha->translatedFormat('F') }})</em></span>
                </h2>
            </div>

            <div class="col-4 col-md-4 text-end">
                <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#egresoModal"><i
                        class="bi bi-plus-lg"></i> Nuevo <span class="d-none d-md-inline">Egreso</span> </a>
            </div>
        </div>
        <br>
        <div id="container-lista-egresos">
            <x-lista_egresos :egresos="$egresos" :container="'container-lista-egresos'" />
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
                                        <div class="col-6">
                                            <label>SKU</label>
                                        </div>
                                        <div class="col-6 text-end text-secondary">
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
                                <div class="col-6 mb-2">
                                    <label>Fecha de pedido</label>
                                    <input type="date" name="fechapedido" class="form-control input-egreso">
                                </div>
                                <div class="col-6 mb-2">
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
        <form action="{{route('devolucionegreso')}}" method="post" id="form-detail-egreso">
            @csrf
            <div class="modal fade" id="detailEgresoModal" tabindex="-1" aria-labelledby="detailEgresoModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" id="modal-egreso-transaccion" name="transaccion">
                                    <input type="hidden" id="modal-egreso-id" name="idegreso">
                                    <h5 id="modal-egreso-titulo"></h5>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <h6 id="modal-egreso-serialnumber"></h6>
                                </div>
                                <div class="col-md-6 text-secondary text-end">
                                    <h6 id="modal-egreso-estado"></h6>
                                </div>
                                <div class="col-md-6" id="modal-egreso-fecha">
                                    <p class="mb-0"><strong></strong></p>
                                    <p class="mt-0"><strong></strong></p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <small><strong></strong></small>
                                    <p class="mb-0"><small id="modal-egreso-usuario"></small></p>
                                </div>
                                <div class="col-md-12 mt-1" id="modal-egreso-publicidad">
                                    
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Observacion:</label>
                                    <textarea class="form-control" maxlength="500" id="modal-egreso-observacion" name="observacion"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row w-100 pe-0 ps-0">
                                <div class="col-md-6 ps-0">
                                    <button type="button" onclick="formDetailEgreso('devolucion')" class="btn btn-warning"><i class="bi bi-arrow-clockwise"></i> Devoluci&oacute;n</button>
                                </div>
                                <div class="col-md-6 pe-0 text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Cerrar</button>
                                    <button type="button" onclick="formDetailEgreso('update')" class="btn btn-primary"><i class="bi bi-floppy"></i> Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="{{asset('js/egresos.js')}}"></script>
@endsection
