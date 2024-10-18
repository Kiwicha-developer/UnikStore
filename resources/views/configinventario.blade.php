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
        <div class="col-md-8 border-bottom border-secondary">
            <h3>Almacenes</h3>
        </div>
        <div class="col-md-4 border-bottom border-secondary text-end">
            <button class="btn btn-success"><i class="bi bi-house-add-fill"></i></button>
        </div>
        <div class="col-md-12 pt-2 mb-0 bg-list">
            <div class="row">
                @foreach ($almacenes as $almacen)
                <div class="col-md-3 pb-2">
                    <div class="row bg-light border ms-2 me-2 pt-2">
                        <h5><i class="bi bi-house-door"></i>{{$almacen->descripcion}}</h5>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row border shadow rounded-3 pt-2  mb-4">
        <div class="col-md-8 border-bottom border-secondary">
            <h3>Proveedores</h3>
        </div>
        <div class="col-md-4 border-bottom border-secondary text-end">
            <button class="btn btn-success"><i class="bi bi-plus-lg"></i> <i class="bi bi-truck"></i></button>
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
</div>
@endsection