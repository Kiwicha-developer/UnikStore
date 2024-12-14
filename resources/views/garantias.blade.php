@extends('layouts.app')

@section('title', 'Garantias')

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-8">
            <h2>Productos en Garant&iacute;a</h2>
        </div>
        <div class="col-4 text-end">
            <a class="btn btn-success" href="{{route('creategarantia')}}" target="_blank">Nueva garant&iacute;a</a>
        </div>
    </div>
    <br>
    <div class="row">
        {{$garantias}}
    </div>
</div>
@endsection