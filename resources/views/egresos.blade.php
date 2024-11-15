@extends('layouts.app')

@section('title', 'Egresos')
@php
    setlocale(LC_TIME, 'es_ES.UTF-8');
@endphp

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-8">
            <h2><a href="{{route('documentos', [now()->format('Y-m')])}}" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> <i class="bi bi-file-earmark-minus-fill"></i> Egresos<span class="text-capitalize text-secondary fw-light"><em>({{$fecha->translatedFormat('F')}})</em></span></h2>
        </div>
        <div class="col-md-2 text-end">
            <input type="month" class="form-control" id="month" name="month" value="{{$fecha->format('Y-m')}}" >
        </div>
        <div class="col-md-2 text-end">
            <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#egresoModal"><i class="bi bi-plus-lg"></i> Nuevo Egreso</a>
        </div>
    </div>
    <br>
    <div class="row">
        <ul class="list-group">
            <li class="list-group-item bg-sistema-uno text-light">
                <div class="row text-center">
                    <div class="col-md-1">
                        <small>Usuario</small>
                    </div>
                    <div class="col-md-3">
                        <small>Nro Orden</small>
                    </div>
                    <div class="col-md-2">
                        <small>SKU</small>
                    </div>
                    <div class="col-md-2">
                        <small>Serial Number</small>
                    </div>
                    <div class="col-md-2">
                        <small>Producto</small>
                    </div>
                    <div class="col-md-1">
                        <small>Pedido</small>
                    </div>
                    <div class="col-md-1">
                        <small>Despacho</small>
                    </div>
                </div>
            </li>
            @foreach($egresos as $egreso)
            <li class="list-group-item">
                <div class="row text-center">
                    <div class="col-md-1">
                        <small>{{$egreso->Usuario->user}}</small>
                    </div>
                    <div class="col-md-3">
                        <small>{{is_null($egreso->numeroOrden) ? 'No aplica' : $egreso->numeroOrden}}</small>
                    </div>
                    <div class="col-md-2">
                        <small>{{is_null($egreso->Publicacion) || is_null($egreso->Publicacion->sku) ? 'No aplica' : $egreso->Publicacion->sku}}</small>
                    </div>
                    <div class="col-md-2">
                        <small>{{$egreso->RegistroProducto->numeroSerie}}</small>
                    </div>
                    <div class="col-md-2">
                        <small><a href="{{route('producto',[encrypt($egreso->RegistroProducto->DetalleComprobante->Producto->idProducto)])}}">{{$egreso->RegistroProducto->DetalleComprobante->Producto->codigoProducto}}</a></small>
                    </div>
                    <div class="col-md-1">
                        <small>{{$egreso->fechaCompra->format('d/m/y')}}</small>
                    </div>
                    <div class="col-md-1">
                        <small>{{$egreso->fechaDespacho->format('d/m/y')}}</small>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    <!-- Modal -->
    <form action="{{route('insertegreso')}}"  method="POST">
            @csrf
    <div class="modal fade" id="egresoModal" tabindex="-1" aria-labelledby="egresoModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="egresoModalLabel">Nuevo Egreso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-8 mb-2" style="position:relative">
                    <label>Numero de Serie</label>
                    <input type="text" oninput="searchRegistro(this)" name="serialnumber" placeholder="Serial Number" class="form-control input-egreso" id="input-serial-number">
                    <input type="hidden" value="" name="idregistro" id="hidden-product-serial-number">
                    <ul class="list-group" id="suggestions-serial-number" name="idregistro" style="position:absolute;z-index:1000;top:100%;left:0;width:100%"></ul>
                </div>
                <div class="col-md-4">
                    <label>Almacén</label>
                    <select class="form-select input-egreso" name="almacen">
                        <option value="">-Elige un almacén-</option>
                        @foreach ($almacenes as $almacen)
                            <option value="{{$almacen->idAlmacen}}">{{$almacen->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <label>SKU</label>
                        </div>
                        <div class="col-md-6 text-end text-secondary">
                            <label>No aplica</label>
                        </div>
                    </div>
                    <div class="input-group" style="position:relative">
                      <input type="text" oninput="searchPublicacion(this)" name="sku" class="form-control input-egreso" id="input-sku-egreso" placeholder="SKU de una publicacion">
                      <input type="hidden" id="hidden-publicacion-sku" name="idpublicacion" value="">
                      <div class="input-group-text">
                        <input class="form-check-input mt-0"  type="checkbox" id="check-sku-egreso" value="No aplica">
                      </div>
                      <ul class="list-group" id="suggestions-sku" style="position:absolute;z-index:1000;top:100%;left:0;width:100%"></ul>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <label>Numero de Orden</label>
                    <input type="text" placeholder="Nro de Orden" id="input-numero-orden" name="numeroorden" class="form-control input-egreso">
                </div>
                <div class="col-md-6 mb-2">
                    <label>Fecha de pedido</label>
                    <input type="date" name="fechapedido" class="form-control input-egreso">
                </div>
                <div class="col-md-6 mb-2">
                    <label>Fecha de despacho</label>
                    <input type="date" name="fechadespacho" class="form-control input-egreso">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" id="btnRegistrarEgreso" class="btn btn-success"><i class="bi bi-floppy"></i> Registrar</button>
          </div>
        </div>
      </div>
    </div>
    </form>
</div>
<script>
    function checkSku(){
        let checkSku = document.getElementById('check-sku-egreso');
        let inputEgreso = document.getElementById('input-sku-egreso');
        let hiddenEgreso = document.getElementById('hidden-publicacion-sku');
        let inputNumberOrder = document.getElementById('input-numero-orden');
        
        if(checkSku.checked){
            inputEgreso.disabled = true;
            inputEgreso.value = checkSku.value;
            inputNumberOrder.disabled = true;
            inputNumberOrder.value = checkSku.value;
            hiddenEgreso.value = 'NULO';
        }else{
            inputEgreso.disabled = false;
            inputEgreso.value = '';
            inputNumberOrder.disabled = false;
            inputNumberOrder.value = '';
            hiddenEgreso.value = '';
        }
    }
    
    function validateEgreso(){
        let inputsEgreso = document.querySelectorAll('.input-egreso');
        let disabledInput = false;
        
        inputsEgreso.forEach(function(x){
            if(x.value == ''){
                disabledInput = true;
            }
        });
        
        return disabledInput;
    }
    
    function handleBtnRegistrar(){
        let btnRegEgreso = document.getElementById('btnRegistrarEgreso');
        
        btnRegEgreso.disabled = validateEgreso();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        handleBtnRegistrar();
    });
    
    document.getElementById('check-sku-egreso').addEventListener('change',checkSku);
    document.getElementById('check-sku-egreso').addEventListener('change',handleBtnRegistrar);
    
    let allInputsEgreso = document.querySelectorAll('.input-egreso');
    allInputsEgreso.forEach(function(x){
        x.addEventListener('input',handleBtnRegistrar);
    });
</script>
<script>
    function searchRegistro(inputElement){
        let query = inputElement.value;
        
        function handleClickOutside(event) {
            let suggestions = document.getElementById('suggestions-serial-number');
            if (!suggestions.contains(event.target) && event.target !== inputElement) {
                suggestions.innerHTML = ''; // Limpiar sugerencias si se hace clic fuera del input
            }
        }
    
        // Agregar el manejador de clics al documento
        document.addEventListener('click', handleClickOutside);
        
        if (query.length > 2) { // Comenzar la búsqueda después de 3 caracteres
            document.getElementById('hidden-product-serial-number').value = "";
            let xhr = new XMLHttpRequest();
            xhr.open('GET', `/egresos/searchregistro?query=${query}`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let data = JSON.parse(xhr.responseText);
                    let suggestions = document.getElementById('suggestions-serial-number');
                    suggestions.innerHTML = '';
    
                        data.forEach(item => {
                        let li = document.createElement('li');
                        li.classList.add('list-group-item','pe-0');
                        li.classList.add('hover-sistema-uno','text-truncate');
                        li.style.cursor = "pointer";
                        
                        let divRow = document.createElement('div');
                        divRow.classList.add('row','w-100');
                        
                        let colSerie = document.createElement('div');
                        colSerie.classList.add('col-md-8');
                        colSerie.textContent = item.numeroSerie;
                        
                        let colAlmacen = document.createElement('div');
                        colAlmacen.classList.add('col-md-4','text-end');
                        colAlmacen.textContent = item.almacen;
                        
                        let colProducto = document.createElement('div');
                        colProducto.classList.add('col-md-12');
                        let smallProducto = document.createElement('em');
                        smallProducto.textContent = item.nombreProducto;
                        smallProducto.style.fontSize = '12px';
                        colProducto.appendChild(smallProducto);
                        
                        divRow.appendChild(colSerie);
                        divRow.appendChild(colAlmacen);
                        divRow.appendChild(colProducto);
                        li.appendChild(divRow);
                        
                        li.addEventListener('click', function() {
                            inputElement.value = item.numeroSerie;
                            document.getElementById('hidden-product-serial-number').value = item.idRegistroProducto;
                            suggestions.innerHTML = ''; // Limpiar sugerencias después de seleccionar una
                        });
    
                        suggestions.appendChild(li);
                    });
                }
            };
            xhr.send();
        } else {
            document.getElementById('suggestions-serial-number').innerHTML = ''; // Limpiar si hay menos de 3 caracteres
            document.getElementById('hidden-product-serial-number').value = "";
        }
    }
    
    function searchPublicacion(inputElement){
        let query = inputElement.value;
        
        function handleClickOutside(event) {
            let suggestions = document.getElementById('suggestions-sku');
            if (!suggestions.contains(event.target) && event.target !== inputElement) {
                suggestions.innerHTML = ''; // Limpiar sugerencias si se hace clic fuera del input
            }
        }
    
        // Agregar el manejador de clics al documento
        document.addEventListener('click', handleClickOutside);
        
        if (query.length > 2) { // Comenzar la búsqueda después de 3 caracteres
            document.getElementById('hidden-publicacion-sku').value = "";
            let xhr = new XMLHttpRequest();
            xhr.open('GET', `/searchpublicacion?query=${query}`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let data = JSON.parse(xhr.responseText);
                    let suggestions = document.getElementById('suggestions-sku');
                    suggestions.innerHTML = '';
    
                        data.forEach(item => {
                        let li = document.createElement('li');
                        li.classList.add('list-group-item','pe-0');
                        li.classList.add('hover-sistema-uno','text-truncate');
                        li.style.cursor = "pointer";
                        
                        let divRow = document.createElement('div');
                        divRow.classList.add('row','w-100');
                        
                        let colSerie = document.createElement('div');
                        colSerie.classList.add('col-md-8');
                        colSerie.textContent = item.sku;
                        
                        let colAlmacen = document.createElement('div');
                        colAlmacen.classList.add('col-md-4','text-end');
                        colAlmacen.textContent = item.fechaPublicacion;
                        
                        let colProducto = document.createElement('div');
                        colProducto.classList.add('col-md-12');
                        let smallProducto = document.createElement('em');
                        smallProducto.textContent = item.titulo;
                        smallProducto.style.fontSize = '12px';
                        colProducto.appendChild(smallProducto);
                        
                        divRow.appendChild(colSerie);
                        divRow.appendChild(colAlmacen);
                        divRow.appendChild(colProducto);
                        li.appendChild(divRow);
                        
                        li.addEventListener('click', function() {
                            inputElement.value = item.sku;
                            document.getElementById('hidden-publicacion-sku').value = item.idPublicacion;
                            suggestions.innerHTML = ''; // Limpiar sugerencias después de seleccionar una
                        });
    
                        suggestions.appendChild(li);
                    });
                }
            };
            xhr.send();
        } else {
            document.getElementById('suggestions-sku').innerHTML = ''; // Limpiar si hay menos de 3 caracteres
            document.getElementById('hidden-publicacion-sku').value = "";
        }
    }
</script>
<script>
    document.getElementById('month').addEventListener('change', function() {
        let selectedMonth = this.value;
        
        if(selectedMonth == ""){
            alert('Fecha no valida.');
        }else{
            let url = "/egresos/" + selectedMonth;
        
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