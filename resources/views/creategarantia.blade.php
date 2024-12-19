@extends('layouts.app')

@section('title', 'Nueva Garantia')

@section('content')
<div class="container">
    <br>
    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-8">
                <h2>Nueva Garantia</h2>
            </div>
            <div class="col-4 text-end">
                <input type="text" class="form-control" placeholder="Nro del comprobante.." required>
            </div>
        </div>
        <br>
        <div class="row border shadow rounded-3 pt-3 pb-2">
            <div class="col-8 mb-3">
                <h4>Datos del Cliente</h4>
            </div>
            <div class="col-4 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nro Documento">
                    <x-btn_modal_cliente :clases="'btn-outline-success'" :documentos="$tipoDocumentos" :spanClass="'d-none'"/>
                </div>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">Nombres:</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-3 mb-3">
                <label class="form-label">Apellido Paterno:</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-3 mb-3">
                <label class="form-label">Apellido Materno:</label>
                <input type="text" class="form-control">
            </div>
        </div>
    </form>
</div>
@endsection