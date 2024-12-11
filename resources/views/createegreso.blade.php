@extends('layouts.app')

@section('title', 'Nuevo Egreso')

@section('content')
<div class="container">
    <div class="bg-secondary" id="hidden-body"
        style="position:fixed;left:0;width:100vw;height:100vh;z-index:998;opacity:0.5;display:none">
    </div>
    <br>
    <div class="row">
        <div class="col-5 col-md-7">
            <h2><a href="{{route('egresos', [now()->format('Y-m')])}}" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> Nuevos egresos</h2>
        </div>
        <div class="col-7 col-md-5">
            <div class="input-group mb-3" style="z-index:1000">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Serial Number..." id="search" >
                <ul class="list-group w-100" style="position:absolute;top:100%;z-index:1000" id="suggestions">
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection