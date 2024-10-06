@extends('layouts.app')

@section('title', 'Ingresos')

@section('content')
<div class="container">
    <div class="bg-secondary" id="hidden-body" style="position:fixed;left:0;width:100vw;height:100vh;z-index:998;opacity:0.5;display:none">
    </div>
    <br>
    <div class="row">
        <div class="col-12 col-md-5 text-end" style="position:relative;z-index:999">
            <div class="input-group mb-3" >
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" placeholder="Serial Number..." id="search">
              <ul class="list-group w-100" style="position:absolute;top:100%;z-index:1000" id="suggestions">
              </ul>
            </div>
        </div>
        <div class="col-6 col-md-9">
            <h2><a href="{{route('documentos', [now()->format('Y-m')])}}" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> <i class="bi bi-file-earmark-plus-fill"></i> Ingresos <span class="text-capitalize text-secondary fw-light" ><em>({{$fecha->translatedFormat('F')}})</em></span></h2>
        </div>
        <div class="col-6 col-md-3 text-end">
            <input type="month" class="form-control" id="month" name="month" value="{{$fecha->format('Y-m')}}" >
        </div>
    </div>
    <br>
    <div class="row mb-2">
        <div class="col-4 col-md-2">
            <select class="form-select form-select-sm" id="select-user">
              <option value="TODOS" selected>Todos</option>
              @foreach($usuarios as $usuario)
                <option value="{{$usuario->idUser}}">{{$usuario->user}}</option>
              @endforeach
            </select>
        </div>
        <div class="col-8 col-md-10 text-end">
            <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#ingresoModal"><i class="bi bi-file-earmark-plus"></i> Nuevo Registro</a>
        </div>
    </div>
    @if(!$registros->isEmpty())
    <div class="row">
        <div class="col-md-12">
            <ul class="list-group">
              <li class="list-group-item bg-sistema-uno text-light">
                  <div class="row text-center">
                    <div class="col-4 col-md-2 text-start">
                        <small>Producto</small>
                    </div>
                    <div class="col-4 col-md-2">
                        <small>Comprobante</small>
                    </div>
                    <div class="col-md-1 d-none d-sm-none d-md-block">
                        <small>Usuario</small>
                    </div>
                    <div class="col-md-2 d-none d-sm-none d-md-block">
                        <small>Nro Serie</small>
                    </div>
                    <div class="col-md-2 d-none d-sm-none d-md-block">
                        <small>Precio</small>
                    </div>
                    <div class="col-md-1 d-none d-sm-none d-md-block">
                        <small>Adquisicion</small>
                    </div>
                    <div class="col-md-1 d-none d-sm-none d-md-block">
                        <small>Estado</small>
                    </div>
                    <div class="col-4 col-md-1">
                        <small>Registro</small>
                    </div>
                </div>    
              </li>
              @foreach($registros as $registro)
              <li class="list-group-item list-ingreso-{{$registro->idUser}} list-ingreso-all {{$registro->RegistroProducto->estado == 'INVALIDO' ? 'text-decoration-line-through text-danger' : ''}}">
                <div class="row text-center">
                    <div class="col-4 col-md-2 text-start">
                        <small data-bs-toggle="tooltip" data-bs-placement="top" title="{{$registro->RegistroProducto->DetalleComprobante->Producto->nombreProducto}}">
                            <a class="decoration-link" href="{{route('producto',[encrypt($registro->RegistroProducto->DetalleComprobante->Producto->idProducto)])}}">{{$registro->RegistroProducto->DetalleComprobante->Producto->codigoProducto}}</a>
                        </small>
                    </div>
                    <div class="col-4 col-md-2">
                        <small data-bs-toggle="tooltip" data-bs-placement="top" title="{{$registro->RegistroProducto->DetalleComprobante->Comprobante->Preveedor->nombreProveedor}}">
                            <a class="decoration-link" href="{{route('documento',[encrypt($registro->RegistroProducto->DetalleComprobante->Comprobante->idComprobante),0])}}">{{$registro->RegistroProducto->DetalleComprobante->Comprobante->numeroComprobante}}</a>
                        </small>
                    </div>
                    <div class="col-4 col-md-1">
                        <small>{{$registro->Usuario->user}}</small>
                    </div>
                    <div class="col-4 col-md-2">
                        <small>{{$registro->RegistroProducto->numeroSerie}}</small>
                    </div>
                    <div class="col-4 col-md-2">
                        <small>{{$registro->RegistroProducto->DetalleComprobante->Comprobante->moneda == 'DOLAR' ? '$ ' : 'S/. '}}{{number_format($registro->RegistroProducto->DetalleComprobante->precioUnitario, 2)}}</small>
                    </div>
                    <div class="col-md-1 d-none d-sm-none d-md-block">
                        <small>{{$registro->RegistroProducto->DetalleComprobante->Comprobante->adquisicion}}</small>
                    </div>
                    <div class="col-4 col-md-1 d-none d-sm-none d-md-block">
                        <small>{{$registro->RegistroProducto->estado}}</small>
                    </div>
                    <div class="col-4 col-md-1">
                        <small>{{$registro->fechaIngreso->format('d/m/Y')}}</small>
                    </div>
                </div>    
              </li>
              @endforeach
            </ul>
        </div>
    </div>
    @else
    <div class="row align-items-center" style="height:80vh">
        <x-aviso_no_encontrado :mensaje="''"/>
    </div>
    @endif
    <!-- Modal -->
    <form action="{{route('insertcomprobante')}}" method="POST">
        @csrf
<div class="modal fade" id="ingresoModal" tabindex="-1" aria-labelledby="ingresoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ingresoModalLabel">Nuevo Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-6 col-md-6">
                <label>Proveedor</label>
                <select class="form-select" id="proveedor-select" name="proveedor">
                    <option value="" {{old('proveedor') == '' ? 'selected' : ''}}>-Elige un proveedor-</option>
                    @foreach($proveedores as $proveedor)
                    <option value="{{$proveedor['idProveedor']}}" {{old('proveedor') == $proveedor['idProveedor'] ? 'selected' : ''}}>{{$proveedor['nombreProveedor']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-6">
                <label>Documento</label>
                <select class="form-select" id="documento-select" name="tipocomprobante">
                    <option value="" {{old('tipocomprobante') == '' ? 'selected' : ''}}>-Elige un documento-</option>
                    @foreach($documentos as $doc)
                    <option value="{{$doc->idTipoComprobante}}" {{old('tipocomprobante') == $doc->idTipoComprobante ? 'selected' : ''}}>{{$doc->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label>Nro Documento</label>
                <input type="text" class="form-control" id="documento-number" name="numerocomprobante" value="{{old('numerocomprobante')}}">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" id="btn-save"><i class="bi bi-floppy"></i> Registrar</button>
      </div>
    </div>
  </div>
</div>
</form>
<div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <h5 id="titleproduct-modal-detail">[titulo del producto]</h5>
            </div>
            <div class="col-6 text-secondary">
                <h6 id="serialnumber-modal-detail">[numero de serie]</h6>
            </div>
            <div class="col-6 text-end">
                <span id="user-modal-detail">[usuario]</span>
            </div>
            <div class="col-6">
                <span id="state-modal-detail">[Estado]</span>
            </div>
            <div class="col-6 text-end">
                <span id="date-modal-detail">[fechadeingreso]</span>
            </div>
            <div class="col-6">
                <strong>Observaciones</strong>
                <p id="obs-modal-detail">[observaciones]</p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</div>
<script>
document.getElementById('search').addEventListener('input', function() {
    let query = this.value;
    let hiddenBody = document.getElementById('hidden-body');
    if (query.length > 2) { // Comenzar la b��squeda despu��s de 3 caracteres
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `/ingresos/searchingresos?query=${query}`, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let data = JSON.parse(xhr.responseText);
                let suggestions = document.getElementById('suggestions');
                hiddenBody.style.display = 'block';
                suggestions.innerHTML = '';

                    data.forEach(item => {
                        let li = document.createElement('li');
                        li.classList.add('list-group-item', 'hover-sistema-uno');
                        li.style.cursor = "pointer";
                        
                        let divRow = document.createElement('div');
                        divRow.classList.add('row');
                        
                        let divColProduct = document.createElement('div');
                        divColProduct.classList.add('col-4','col-md-4', 'text-start');
                        let smallProduct = document.createElement('small');
                        smallProduct.textContent = item.Registro.detalle_comprobante.producto.codigoProducto;
                        divColProduct.appendChild(smallProduct);
                        
                        let divColSerial = document.createElement('div');
                        divColSerial.classList.add('col-4','col-md-4');
                        let smallSerial = document.createElement('small');
                        smallSerial.textContent = item.numeroSerie;
                        divColSerial.appendChild(smallSerial);
                        
                        let divColDate = document.createElement('div');
                        divColDate.classList.add('col-4','col-md-4');
                        let smallDate = document.createElement('small');
                        smallDate.textContent = item.fechaIngresoPerso;
                        divColDate.appendChild(smallDate);
                        
                        li.addEventListener('click', function() {
                            document.getElementById('search').value = item.numeroSerie; 
                            suggestions.innerHTML = ''; 
                            dataModalDetalle(item.Registro.detalle_comprobante.producto.nombreProducto,
                                            item.numeroSerie,
                                            item.Registro.estado,
                                            item.Usuario.user,
                                            item.fechaIngresoPerso,
                                            item.Registro.observacion);
                        });
                        
                        divRow.appendChild(divColProduct);
                        divRow.appendChild(divColSerial);
                        divRow.appendChild(divColDate);
                        li.appendChild(divRow);
                        suggestions.appendChild(li);
                    });
            }
        };
        xhr.send();
    } else {
        document.getElementById('suggestions').innerHTML = ''; // Limpiar si hay menos de 3 caracteres
        hiddenBody.style.display = 'none';
    }
});

function dataModalDetalle(producto,serie,estado,usuario,fecha,obser){
    let myModal = new bootstrap.Modal(document.getElementById('detalleModal'));
    let titleProduct = document.getElementById('titleproduct-modal-detail');
    let serialNumber = document.getElementById('serialnumber-modal-detail');
    let state = document.getElementById('state-modal-detail');
    let user = document.getElementById('user-modal-detail');
    let date = document.getElementById('date-modal-detail');
    let observacion = document.getElementById('obs-modal-detail');
    
    titleProduct.textContent = producto;
    serialNumber.textContent = serie;
    state.textContent = estado;
    user.textContent = usuario;
    date.textContent = fecha;
    observacion.textContent = obser ? obser: 'Sin observaciones';
    
    myModal.show();
}

function hideSuggestions(event) {
    let suggestions = document.getElementById('suggestions');
    let hiddenBody = document.getElementById('hidden-body');
    if (!suggestions.contains(event.target) && event.target.id !== 'search') {
        suggestions.innerHTML = ''; // Oculta las sugerencias
        hiddenBody.style.display = 'none';
    }
}

// A�0�9adir manejador de eventos para el clic en el documento
document.addEventListener('click', hideSuggestions);
</script>
<script>
    function validateForm(){
        let proveedor = document.getElementById('proveedor-select').value;
        let documento = document.getElementById('documento-select').value;
        let numeroDocumento = document.getElementById('documento-number').value;
        let disabled = false;
        
        if(proveedor == ''){
            disabled = true;
        }
        
        if(documento == ''){
            disabled = true;
        }
        
        if(numeroDocumento == ''){
            disabled = true;
        }
        
        return disabled;
    }
    
    function disableButton(){
        let btnSave = document.getElementById('btn-save');
        btnSave.disabled = validateForm();
    }
    
    @if(!$registros->isEmpty())
    function hiddenList(){
        let selectUser = document.getElementById('select-user').value;
        let listIngresos = document.querySelectorAll('.list-ingreso-all');
        let listIngresosSelected = document.querySelectorAll('.list-ingreso-' + selectUser);
        
        listIngresos.forEach(function(x){
            x.style.display = 'none';
        });
        
        if(selectUser == 'TODOS'){
            listIngresos.forEach(function(x){
                x.style.display = 'block';
            });
        }else{
            listIngresosSelected.forEach(function(x){
                x.style.display = 'block';
            });
        }
    }
    @endif
    
    
    @if(!$registros->isEmpty())  
    document.getElementById('select-user').addEventListener('change',hiddenList);
    @endif
       
    document.getElementById('proveedor-select').addEventListener('change', disableButton);
    document.getElementById('documento-select').addEventListener('change', disableButton);
    document.getElementById('documento-number').addEventListener('input', disableButton);
    
    document.addEventListener('DOMContentLoaded', function() {
         disableButton();
         @if(!$registros->isEmpty())
         hiddenList();
         @endif
      });
</script>
<script>
    document.getElementById('month').addEventListener('change', function() {
        let selectedMonth = this.value;
        let url = "/ingresos/" + selectedMonth;
        
        if(selectedMonth == ""){
            alert('Fecha no valida.');
        }else{
            window.location.href = url;
        }
        
    });
    
    document.getElementById('month').addEventListener('keydown', function(event) {
        // Evita que la acci贸n de borrado ocurra si se presiona Backspace o Delete
        if (event.key === 'Backspace' || event.key === 'Delete') {
            event.preventDefault();
        }
    });
</script>
@endsection