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
    <div class="row border shadow rounded-3 pt-2 mb-4">
        <div class="col-9 col-md-8 border-bottom border-secondary">
            <h3>Almacenes</h3>
            <small class="text-secondary">Configuracion de almacen relacionado al inventario .</small>
        </div>
        <div class="col-3 col-md-4 border-bottom border-secondary text-end"  data-bs-toggle="modal" data-bs-target="#almacenModal">
            <button class="btn btn-success"><i class="bi bi-house-add-fill"></i></button>
        </div>
        <div class="col-md-12 pt-2 mb-0 bg-list">
            <div class="row">
                @foreach ($almacenes as $almacen)
                <div class="col-6 col-md-3 pb-2">
                    <div class="row bg-light border ms-2 me-2 pt-2">
                        <h5><i class="bi bi-house-door"></i>{{$almacen->descripcion}}</h5>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row border shadow rounded-3 pt-2  mb-4">
        <div class="col-9 col-md-8 border-bottom border-secondary">
            <h3>Proveedores</h3>
            <small class="text-secondary">Configuracion de proveedores para los ingresos y seguimiento de stock.</small>
        </div>
        <div class="col-3 col-md-4 border-bottom border-secondary text-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#proveedorModal"><i class="bi bi-plus-lg"></i> <i class="bi bi-truck"></i></button>
        </div>
        <div class="col-md-12 pt-2 pb-2 bg-list">
            <div class="row">
                @foreach ($proveedores as $proveedor)
                <div class="col-md-3 pb-2">
                    <div class="row bg-light border ms-2 me-2 pt-2 h-100">
                        <h5>{{$proveedor->nombreProveedor}}</h5>
                        <small class="text-secondary">{{$proveedor->razSocialProveedor}}</small>
                        <small>{{$proveedor->rucProveedor}}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!--Modals -->
    <form action="{{route('createalmacen')}}" id="form-almacen" method="POST">
        @csrf
    <div class="modal fade" id="almacenModal" tabindex="-1" aria-labelledby="almacenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="almacenModalLabel">Nuevo almacen</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" maxlength="50" class="form-control" name="descripcion" placeholder="Nombre del Almacen" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" onclick="validateForm('form-almacen')"><i class="bi bi-floppy-fill"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <form action="{{route('createproveedor')}}" id="form-proveedor" method="POST">
        @csrf
    <div class="modal fade" id="proveedorModal" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="proveedorModalLabel">Nuevo proveedor</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="" class="form-label">Raz&oacute;n Social:</label>
                        <input type="text" class="form-control" value="" name="razonsocial" placeholder="EMPRESA S.A.C" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Nombre Comercial:</label>
                        <input type="text" class="form-control" value="" name="nombrecomercial" placeholder="Nombre Empresa" required>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">RUC:</label>
                        <input type="text" maxlength="11" class="form-control" value="" name="ruc" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" id="btn-modal-proveedor" onclick="validateForm('form-proveedor')"><i class="bi bi-floppy-fill"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </form>
</div>
<script src="{{asset('js/configinventario.js')}}"></script>
@endsection