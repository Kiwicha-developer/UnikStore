@extends('layouts.app')

@section('title', 'Nueva Publicación')

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-8 col-md-10">
            <h2><a href="{{route('publicaciones',[now()->format('Y-m')])}}" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> Nueva Publicaci&oacuten</h2>
        </div>
        <div class="col-4 col-md-2 text-end">
            <img src="{{ asset('storage/'.$plataforma->imagenPlataforma) }}" alt="plataforma" style="width:80%" class="rounded-2">
        </div>
    </div>
    <br>
    <form action="{{route('insertpublicacion')}}" method="POST">
        @csrf
    <div class="row border shadow rounded-3 pt-2 pb-2">
        <div class="col-md-9 mb-2">
            <label class="form-label">Titulo:</label>
            <input type="text" name="titulo" value="{{old('titulo')}}" class="form-control" aria-describedby="basic-addon1" id="titulo-public">
            <input type="hidden"  name="idplataforma" value="{{$plataforma->idPlataforma}}">
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label">SKU:</label>
            <input type="text" value="{{old('sku')}}" name="sku" class="form-control" aria-describedby="basic-addon1" id="sku-public">
        </div>
        <div class="col-md-4 mb-2">
            <label class="form-label">Producto:</label>
            <input type="text" value="{{old('producto')}}" id="search" name="producto" placeholder="Buscar por modelo..." autocomplete="off" class="form-control" id="producto-public">
            <input type="hidden" value="{{old('idproducto')}}" value="0" name="idproducto" id="hidden-product">
            <ul class="list-group" id="suggestions" style="position:absolute"></ul>
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label">Cuenta:</label>
            <select name="cuenta" class="form-select" id="cuenta-public">
                <option value="" {{old('cuenta') == '' ? 'selected' : ''}} >-Elige una cuenta-</option>
                @foreach($plataforma->CuentasPlataforma as $cuenta)
                    <option value="{{$cuenta->idCuentaPlataforma}}" {{old('cuenta') == $cuenta->idCuentaPlataforma ? 'selected' : '' }}>{{$cuenta->nombreCuenta}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <label class="form-label">Fecha de publicaci&oacuten:</label>
            <input type="date" name="fecha" value="{{old('fecha')}}" class="form-control" id="fecha-public">
        </div>
        <div class="col-6 col-md-2 mb-2">
            <label class="form-label">Precio:</label>
            <input type="number" value="{{old('precio')}}" name="precio" class="form-control" step="0.01" aria-describedby="basic-addon1" id="precio-public">
        </div>
    </div>
    <div class="row mt-2 mb-2">
        <div class="col-md-12 text-center">
            <button type="submit" id="btnSave" class="btn btn-success">Guardar <i class="bi bi-floppy"></i></button>
        </div>
    </div>
    </form>
</div>
<script>
    function validateData(){
        let titulo = document.getElementById('titulo-public').value;
        let sku = document.getElementById('sku-public').value;
        let producto = document.getElementById('search').value;
        let cuenta = document.getElementById('cuenta-public').value;
        let fecha = document.getElementById('fecha-public').value;
        let precio = document.getElementById('precio-public').value;
        let disabled = false;
        
        if(titulo == ''){
            disabled = true;
        }
        
        if(sku == ''){
            disabled = true;
        }
        
        if(producto == ''){
            disabled = true;
        }
        
        if(cuenta == ''){
            disabled = true;
        }
        
        if(fecha == ''){
            disabled = true;
        }
        
        if(precio == ''){
            disabled = true;
        }
        
        return disabled;
    }

    function dissableButton(){
        let btnSave = document.getElementById('btnSave');
        if(validateData()){
            btnSave.classList.add('disabled');
        }else{
            btnSave.classList.remove('disabled');
        }
        
    }

    document.addEventListener('DOMContentLoaded', function() {
         dissableButton();   
      });
      
    document.getElementById('titulo-public').addEventListener('input', dissableButton);
    document.getElementById('sku-public').addEventListener('input', dissableButton);
    document.getElementById('cuenta-public').addEventListener('input', dissableButton);
    document.getElementById('fecha-public').addEventListener('input', dissableButton);
    document.getElementById('precio-public').addEventListener('input', dissableButton);
    document.getElementById('search').addEventListener('input', dissableButton);
</script>
<script>
document.getElementById('search').addEventListener('input', function() {
    let query = this.value;

    if (query.length > 2) { // Comenzar la búsqueda después de 3 caracteres
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `/productos/searchmodelproduct?query=${query}`, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let data = JSON.parse(xhr.responseText);
                let suggestions = document.getElementById('suggestions');
                suggestions.innerHTML = '';

                    data.forEach(item => {
                    let li = document.createElement('li');
                    li.textContent = item.modelo;
                    li.classList.add('list-group-item');
                    li.classList.add('hover-sistema-uno');
                    li.style.cursor = "pointer";
                    
                    li.addEventListener('click', function() {
                        document.getElementById('search').value = this.textContent;
                        document.getElementById('hidden-product').value = item.idProducto;
                        suggestions.innerHTML = ''; // Limpiar sugerencias después de seleccionar una
                    });

                    suggestions.appendChild(li);
                });
            }
        };
        xhr.send();
    } else {
        document.getElementById('suggestions').innerHTML = ''; // Limpiar si hay menos de 3 caracteres
    }
});
</script>
@endsection