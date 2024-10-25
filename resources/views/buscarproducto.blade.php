@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="container">
    @if($productos->isNotEmpty())
    <br>
    <div class="row">
        <div class="col-md-8">
            <h2><a href="javascript:void(0)" onclick="window.history.back()" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> Productos encontrados:</h2>
        </div>
        <div class="col-md-4">
            <x-buscador_producto />
        </div>
    </div>
    <br>
    <div>
        <x-lista_producto :productos="$productos" :tc="$tc"/>
    </div>
    @else
    <div class="row d-flex justify-content-between align-items-center" style="height: 80vh;">
        <x-aviso_no_encontrado :mensaje="''"/>
    </div>
    @endif
</div>
@endsection