@extends('layouts.app')

@section('title', 'Documentos')

@section('content')
<div class="container">
    <div class="bg-secondary" id="hidden-body" style="position:fixed;left:0;width:100vw;height:100vh;z-index:998;opacity:0.5;display:none">
    </div>
    <br>
    <div class="row">
        <div class="col-md-8">
            <h2><a href="{{route('ingresos', [now()->format('Y-m')])}}" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> Traslados</h2>
        </div>
        <div class="col-md-4">
            <div class="input-group mb-3" style="z-index:1000">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Serial Number..." id="search" >
                <ul class="list-group w-100" style="position:absolute;top:100%;z-index:1000" id="suggestions">
                </ul>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <ul class="list-group" id="lista-traslado" style="visibility: hidden">
                <li class="list-group-item bg-sistema-uno text-light">
                    <div class="row pt-1 text-center">
                        <div class="col-md-3">
                            <h6>Producto</h6>
                        </div>
                        <div class="col-md-2">
                            <h6>Serie</h6>
                        </div>
                        <div class="col-md-2">
                            <h6>Estado</h6>
                        </div>
                        <div class="col-md-2">
                            <h6>Origen</h6>
                        </div>
                        <div class="col-md-2">
                            <h6>Destino</h6>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="row" id="aviso-vacio">
        <div class="col-12 d-flex justify-content-center align-items-center text-secondary text-decoration-underline" style="height:70vh">
            <h4>Añade una serie para su traslado</h4>
        </div>
    </div>
</div>
<script>
    document.getElementById('search').addEventListener('input', function() {
        let query =  this.value;
        let hiddenBody = document.getElementById('hidden-body');
        if(query.length > 2){
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
                            smallProduct.textContent = item.Proveedor.nombreProveedor;
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
                                
                                addProductoSerial(item);
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
        }else {
        document.getElementById('suggestions').innerHTML = ''; // Limpiar si hay menos de 3 caracteres
        hiddenBody.style.display = 'none';
        }
        
    });

    function addProductoSerial(object){
        let ulTraslado = document.getElementById('lista-traslado');

        let itemTraslado = document.createElement('li');
        itemTraslado.classList.add('list-group-item','item-traslado');
        
        let divRow = document.createElement('div');
        divRow.classList.add('row','text-center');

        let divColProducto = document.createElement('div');
        divColProducto.classList.add('col-md-3');
        divColProducto.innerHTML = "<strong>Modelo</strong> <small>Codigo</small>";

        let divColSerie = document.createElement('div');
        divColSerie.classList.add('col-md-2');
        divColSerie.innerHTML = '<small>Numero de serie</small>';

        let divColEstado = document.createElement('div');
        divColEstado.classList.add('col-md-2');
        divColEstado.innerHTML = '<small>Estado</small>';

        divRow.appendChild(divColProducto); 
        divRow.appendChild(divColSerie); 
        divRow.appendChild(divColEstado); 
        itemTraslado.appendChild(divRow);
        ulTraslado.appendChild(itemTraslado);
        validateProductos();
        console.log(JSON.stringify(object));
    }

    function validateProductos(){
        let itemsProductos = document.querySelectorAll('.item-traslado');
        let ulTraslado = document.getElementById('lista-traslado');
        let avisoVacio = document.getElementById('aviso-vacio');
        if(itemsProductos.length > 0){
            ulTraslado.style.visibility = 'visible';
            avisoVacio.style.display = 'none';
        }else{
            ulTraslado.style.visibility = 'hidden';
            avisoVacio.style.display = 'block';
        }
    }

    function hideSuggestions(event) {
        let suggestions = document.getElementById('suggestions');
        let hiddenBody = document.getElementById('hidden-body');
        if (!suggestions.contains(event.target) && event.target.id !== 'search') {
            suggestions.innerHTML = ''; // Oculta las sugerencias
            hiddenBody.style.display = 'none';
        }
    }
    document.addEventListener('click', hideSuggestions);
</script>
@endsection