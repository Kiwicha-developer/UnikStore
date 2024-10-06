@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="container">
    <br>
    <br>
    <div class="row">
        <div class="col-6">
            <h2><i class="bi bi-person-fill"></i> Usuarios</h2>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('nuevousuario')}}" class="btn btn-success"><i class="bi bi-person-plus-fill"></i> Nuevo usuario</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12 col-md-3 mb-3">
            <div class="row border shadow rounded-3 pt-2 pb-2 ps-1">
                <h4>Roles</h4>
                <ul class="list-group list-group-flush">
                    @foreach($cargos as $cargo)
                        <li class="list-group-item">{{$cargo->descCargo}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-1">
            
        </div>
        <div class="col-12 col-md-8">
            @php $color ='';
            $estado = '';
            @endphp
            @foreach($usuarios as $us)
            <div class="row w-100 border shadow rounded-3 ms-0 pt-2 pb-2 mb-3">
                <div class="col-5 col-md-7">
                    <h4><i class="bi bi-person-badge"></i> {{$us->user}}</h4>
                </div>
                <div class="col-5 col-md-4 pt-1">
                    <h5 class="text-end {{ $us->estadoUsuario == true ? 'text-success' : 'text-danger' }}">{{ $us->estadoUsuario == true ? 'ACTIVO' : 'INACTIVO' }}</h5>
                </div>
                <div class="col-1 col-md-1">
                    <button class="btn btn-info text-light" onclick="getUser({{$us->idUser}},'{{ $us->user }}',{{$us->Cargo->idCargo}},{{$us->estadoUsuario}})" data-clicked="false" type="button" data-bs-toggle="modal" data-bs-target="#modalUpdateUser"><i class="bi bi-pencil-fill"></i></button>
                </div>
                <div class="col-5 col-md-7 pt-2">
                    <h6 class="text-secondary">{{$us->Cargo->descCargo}}</h6>
                </div>
                <div class="col-7 col-md-4 pt-2">
                    <h6 class="text-secondary text-end"><a href="#" data-clicked="false" onclick="getIdPass({{$us->idUser}})" type="button" data-bs-toggle="modal" data-bs-target="#modalNewPass">Reestablecer contraseña</a></h6>
                </div>
            </div>
            @endforeach
        </div>
    </div>
<!-- Modal -->
<form action="{{route('updatepass')}}" id="form-create"  method="POST">
 @csrf
<div class="modal fade" id="modalNewPass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="modalNewPassLabel">Reestablecer contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12 mb-2">
                <input type="hidden" name="id" value="1" class="form-control" id="idModal">
                <label class="form-label">Nueva contraseña</label>
                <input type="password" name="pass" class="form-control" id="pass">
                <small id="passwordError" class="text-danger"></small>
            </div>
            <div class="col-12">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="confirmpass" class="form-control" id="confirmpass">
                <small id="confirmPasswordError" class="text-danger"></small>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancelarModal()" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" id="btnReestablecer" class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i> Reestablecer</button>
      </div>
    </div>
  </div>
</div>
</form>
<form action="{{route('updateuser')}}" id="form-create"  method="POST">
 @csrf
<div class="modal fade" id="modalUpdateUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="modalUpdateUserLabel">Modificar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12 mb-2">
                <input type="hidden" name="id" value="1" class="form-control" id="idUpdate">
                <label class="form-label">Usuario</label>
                <input type="text" name="user" class="form-control" id="userUpdate">
            </div>
            <div class="col-md-6">
                <label for="cargo" class="form-label" >Rol:</label>
                <select name="cargo" id="cargoUpdate" class="form-select">
                    @foreach($cargos as $cargo)
                        <option value="{{ $cargo->idCargo }}">
                            {{ $cargo->descCargo }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="estado" class="form-label" >Estado:</label>
                <select name="estado" id="estadoUpdate" id="cargo" class="form-select">
                    <option value="true">ACTIVO</option>
                    <option value="false">INACTIVO</option>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancelarModal()" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" id="btnReestablecer" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Actualizar</button>
      </div>
    </div>
  </div>
</div>
</form>
</div>
<script>
    function getIdPass(id){
        let inputHidden = document.getElementById('idModal');
        
        inputHidden.value = id;
    }
    
    function getUser(id,user,idCargo,estado){
        let inputHidden = document.getElementById('idUpdate');
        let inputUser = document.getElementById('userUpdate');
        let selectCargo = document.getElementById('cargoUpdate');
        let selectEstado = document.getElementById('estadoUpdate');
        
        inputHidden.value = id;
        inputUser.value = user;
        selectCargo.value = idCargo;
        
        if(estado){
            selectEstado.value = 'true';
        }else{
            selectEstado.value = 'false';
        }
    }
    
    function cancelarModal(){
        let pass = document.getElementById('pass');
        let validatepass = document.getElementById('confirmpass');
        let passError =  document.getElementById('passwordError');
        let confirmPasswordError =  document.getElementById('confirmPasswordError');
        
        pass.value = '';
        validatepass.value = '';
        passError.textContent = '';
        confirmPasswordError.textContent = '';
    }
    
    function validateModal() {
        let isValid = true;
        
        const pass = document.getElementById('pass').value.trim();
        const validatepass = document.getElementById('confirmpass').value.trim();
        const passError =  document.getElementById('passwordError');
        const confirmPasswordError =  document.getElementById('confirmPasswordError');
        
        let numberRegex = /[0-9]/;
        let caracterRegex = /(?=.*[\W_])/;
        
        if (pass == '') {
            isValid = false;
            passError.textContent = '';
        } else if (pass.length < 8) {
            isValid = false;
            passError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
        } else if (!numberRegex.test(pass)) {
            isValid = false;
            passError.textContent = 'La contraseña debe contener al menos un numero.';
        } else if (!caracterRegex.test(pass)) {
            isValid = false;
            passError.textContent = 'La contraseña debe contener al menos un carácter especial.';
        } else {
            passError.textContent = ''; // Limpiar mensaje de error si la contraseña es válida
        }
        
        if (validatepass == '') {
            isValid = false;
            confirmPasswordError.textContent = '';
        } else if (validatepass.length < 8) {
            isValid = false;
            confirmPasswordError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
        } else if (!numberRegex.test(validatepass)) {
            isValid = false;
            confirmPasswordError.textContent = 'La contraseña debe contener al menos un numero.';
        } else if (!caracterRegex.test(validatepass)) {
            isValid = false;
            confirmPasswordError.textContent = 'La contraseña debe contener al menos un carácter especial.';
        } else if(validatepass != pass){
            confirmPasswordError.textContent = 'La contraseña no coincide';
        }else {
            confirmPasswordError.textContent = '';
        }
        
        return isValid;
    }
    
    function disableReestablecer() {
        let btnRes = document.getElementById('btnReestablecer');
        if (validateModal()) {
            btnRes.classList.remove('disabled');
        } else {
            btnRes.classList.add('disabled');
        }
    }
    
    
    document.addEventListener('DOMContentLoaded', function() {
        disableReestablecer();
        

        document.getElementById('pass').addEventListener('input', disableReestablecer);
        document.getElementById('confirmpass').addEventListener('input', disableReestablecer);
    });
</script>
@endsection