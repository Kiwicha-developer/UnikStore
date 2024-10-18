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
    @foreach ($categorias as $categoria)
    <div class="row border shadow rounded-3 pt-2 mb-4">
        <div class="col-md-8 border-bottom border-secondary">
            <h3><i class="{{$categoria->iconCategoria}}"></i> {{$categoria->nombreCategoria}}  </h3>
        </div>
        <div class="col-md-4 border-bottom border-secondary text-end">
            <button class="btn btn-success"><i class="bi bi-house-add-fill"></i></button>
        </div>
        <div class="col-md-12 pt-2 mb-0 bg-list">
            <div class="row">
                @foreach ($categoria->GrupoProducto as $grupo)
                <div class="col-md-2 pb-2">
                    <div class="row bg-light border rounded-3 ms-2 me-2 pt-2">
                        <h6>{{$grupo->nombreGrupo}}</h6>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
    <br>
    <div class="row border shadow rounded-3 pt-2 mb-4">
        <div class="col-md-8 border-bottom border-secondary">
            <h3>Marcas</h3>
        </div>
        <div class="col-md-4 border-bottom border-secondary text-end">
            <button class="btn btn-success"><i class="bi bi-house-add-fill"></i></button>
        </div>
        <div class="col-md-12 pt-2 mb-0 bg-list">
            <div class="row">
                @foreach ($marcas as $marca)
                <div class="col-md-2 pb-2">
                    <div class="row bg-light text-center border rounded-3 ms-2 me-2 pt-2">
                        <h5>{{$marca->nombreMarca}}</h5>
                        <img src="{{asset('storage/'. $marca->imagenMarca)}}" alt="" class="border ps-0 pe-0">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection