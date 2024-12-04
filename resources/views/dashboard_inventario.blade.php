@extends('layouts.app')

@section('title', $data['pestania'])

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-12">
            <h2><a href="{{route('dashboard')}}" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> {{ $data['titulo']}} <i class="bi bi-{{$data['icon']}}"></i></h2>
        </div>
    </div>
    <br>
    <div id="container-registros-dashboard">
        <x-lista_registros_dashboard :data="$data" :registros="$registros" :container="'container-registros-dashboard'"/>
    </div>
</div>
<script src="{{asset('js/dashboard-inventario.js')}}"></script>
@endsection