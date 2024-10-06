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
        <div class="col-md-8">
            <label for="user" class="form-label" >Nombre de usuario:</label>
            <input type="text" value="" class="form-control" id="user" name="user" autocomplete="nope" required>
        </div>
        <div class="col-md-4">
            <label for="cargo" class="form-label" >Rol:</label>
            <select name="cargo" id="cargo" class="form-select">
                <option value="" selected>-Elige un rol-</option>
                @foreach($cargos as $cargo)
                    <option value="{{ $cargo->idCargo }}">
                        {{ $cargo->descCargo }}
                    </option>
                @endforeach
            </select>
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
<script>
        function validateForm() {
            let isValid = true;
            
            const user = document.getElementById('user').value.trim();
            const pass = document.getElementById('pass').value.trim();
            const confirmpass = document.getElementById('confirmpass').value.trim();
            const cargo = document.getElementById('cargo').value.trim();
            
            const errorPass = document.getElementById('passwordError');
            let numberRegex = /[0-9]/;
            let caracterRegex = /(?=.*[\W_])/;
            
            if (user == '') {
                isValid = false;
            }
            
            if (pass == '') {
                isValid = false;
                errorPass.textContent = '';
            } else if (pass.length < 8) {
                isValid = false;
                errorPass.textContent = 'La contraseña debe tener al menos 8 caracteres.';
            } else if (!numberRegex.test(pass)) {
                isValid = false;
                errorPass.textContent = 'La contraseña debe contener al menos un numero.';
            } else if (!caracterRegex.test(pass)) {
                isValid = false;
                errorPass.textContent = 'La contraseña debe contener al menos un carácter especial.';
            } else {
                errorPass.textContent = ''; // Limpiar mensaje de error si la contraseña es válida
            }
            
            if (confirmpass == '') {
                isValid = false;
                confirmPasswordError.textContent = '';
            } else if (confirmpass.length < 8) {
                isValid = false;
                confirmPasswordError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
            } else if (!numberRegex.test(confirmpass)) {
                isValid = false;
                confirmPasswordError.textContent = 'La contraseña debe contener al menos un numero.';
            } else if (!caracterRegex.test(confirmpass)) {
                isValid = false;
                confirmPasswordError.textContent = 'La contraseña debe contener al menos un carácter especial.';
            } else if(confirmpass != pass){
                confirmPasswordError.textContent = 'La contraseña no coincide';
            }else {
                confirmPasswordError.textContent = '';
            }
            
            
            if (cargo == '') {
                isValid = false;
            }

            return isValid;
        }
        
        function disableButton() {
            let btnRegistrar = document.getElementById('btnRegistrar');
            if (validateForm()) {
                btnRegistrar.classList.remove('disabled');
            } else {
                btnRegistrar.classList.add('disabled');
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            disableButton();

            document.getElementById('user').addEventListener('input', disableButton);
            document.getElementById('pass').addEventListener('input', disableButton);
            document.getElementById('confirmpass').addEventListener('input', disableButton);
            document.getElementById('cargo').addEventListener('input', disableButton);
             
        });
</script>

@endsection