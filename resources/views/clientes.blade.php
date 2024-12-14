@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-8">
            <h2><i class="bi bi-person-standing"></i> Clientes</h2>
        </div>
        <div class="col-4 text-end">
            <x-btn_modal_cliente :clases="'btn-success'"/>
        </div>
    </div>
</div>
@endsection