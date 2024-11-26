@extends('layouts.app')

@section('title', 'Nuevo usuario')

@section('content')
<div class="container">
    <br>
    <br>
    <div class="row">
        <div class="col-12">
            <h2><a href="{{route('usuarios')}}" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> Nuevo Usuario</h2>
        </div>
    </div>
    <br>
    <form action="{{route('createuser')}}" method="POST" autocomplete="off">
        @csrf
    <div class="row border shadow rounded-3 pt-2 pb-2">
        <div class="col-md-12">
            <label for="user" class="form-label" >Nombre de usuario:</label>
            <input type="text" value="" class="form-control" id="user" name="user" autocomplete="nope" required>
        </div>
        <div class="col-md-6">
            <label for="pass" class="form-label" >Contraseña:</label>
            <input type="password" value="" class="form-control" id="pass" name="pass" autocomplete="new-password" required>
            <small id="passwordError" class="text-danger"></small>
        </div>
        <div class="col-md-6">
            <label for="confirmpass" class="form-label" >Confirmar contraseña:</label>
            <input type="password" value="" class="form-control" id="confirmpass" name="confirmpass" autocomplete="new-password" required>
            <small id="confirmPasswordError" class="text-danger"></small>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-success" type="submit" id="btnRegistrar"><i class="bi bi-person-plus-fill"></i> Registrar</button>
        </div>
    </div>
    </form>
    </div>
</div>
<script src="{{asset('js/createuser.js')}}"></script>
@endsection