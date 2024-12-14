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
            <div class="col-8">
                <h4>Datos del Cliente</h4>
            </div>
            <div class="col-4">
                <input type="text" class="form-control form-control-sm" placeholder="Nro Documento">
            </div>
        </div>
    </form>
</div>
@endsection