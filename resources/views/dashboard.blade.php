@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <br>    
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="row pt-2 pb-2 border shadow rounded-3">
                    <h4>Inventario</h4>
                    <small class="mb-2 text-secondary">Seguimiento de Productos registrados.</small>
                    @foreach ($registros as $registro)
                        <div class="col-md-2">
                            <a href="" class="text-decoration-none">
                                <div class="card {{$registro['bg']}} text-light mb-3" style="max-width: 18rem;">
                                    <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-12 truncate">
                                            <h5>{{$registro['titulo']}}</h5>
                                        </div>
                                        <div class="col-md-12" style="position: relative">
                                            <i class="bi bi-{{$registro['icon']}} text-transparent" style="position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%);font-size:3rem"></i>
                                            <h1 style="position: relative; z-index: 1;">{{$registro['cantidad']}}</h1>
                                        </div>
                                        <div class="col-md-12 truncate">
                                            <small>{{$registro['fecha']}}.</small>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-9 mt-3">
                publicaciones mas antiguas coming soon...
            </div>
            <div class="col-md-3 mt-3">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="row border shadow rounded-3 pt-2 pb-2">
                            <div class="col-9">
                                <h4 class="mb-0">Almacenes</h4>
                                <small class="text-secondary">Cantidad de productos en los almacenes</small>
                            </div>
                            <div class="col-3 text-end">
                                <button class="btn btn-outline-danger btn-sm"><i class="bi bi-file-pdf"></i></button>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="card text-bg-light mb-3" style="max-width: auto;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="grafico-pastel" >
                                                    <div class="total-items">
                                                        <div class="d-inline">
                                                            <h1>{{$inventario}}</h1>
                                                            <small class="text-secondary">Items en existencias</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-start mt-2">
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($stock as $key => $value)
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <i class="bi bi-circle-fill" style="color: {{$colors[$key]}}"></i> {{$value['almacen']->descripcion}}
                                                                </div>
                                                                <div class="col-6 text-end">
                                                                    <span>{{$value['cantidad']}}</span>
                                                                </div>
                                                            </div>
                                                            
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="row border shadow rounded-3">
                            <div class="col-md-12 ps-0 pe-0">
                                <div class="card" style="width: 100%;">
                                    <div class="card-header">
                                      <h5>Por agotar</h5>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                      <li class="list-group-item">An item</li>
                                      <li class="list-group-item">A second item</li>
                                      <li class="list-group-item">A third item</li>
                                    </ul>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>
    <style>
        .grafico-pastel{
            background: conic-gradient(
                @php
                    $startRange = 0;
                    $total = count($stock);
                @endphp
                @foreach ($stock as $key => $value)
                @php
                    $pastel = ($value['cantidad'] * 100) / $inventario;
                @endphp
                {{$colors[$key]}} {{$startRange}}% {{$startRange + $pastel}}% {{$key < ($total-  1) ? ',' : ''}}
                @php
                    $startRange = $startRange + $pastel;
                @endphp
                @endforeach
                );
        }
    </style>
@endsection