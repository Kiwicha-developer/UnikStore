@extends('layouts.app')

@section('title', 'Documentos')

@section('content')
<div class="container">
    <div class="bg-secondary" id="hidden-body" style="position:fixed;left:0;width:100vw;height:100vh;z-index:998;opacity:0.5;display:none">
    </div>
    <br>
    <div class="row">
        <div class="col-md-5">
            <div class="input-group mb-3" style="z-index:1000">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Serial Number..." id="search" >
                <ul class="list-group w-100" style="position:absolute;top:100%;z-index:1000" id="suggestions">
                </ul>
            </div>
        </div>
        <div class="col-md-7"></div>
        <div class="col-md-10">
            <h2><a href="{{route('documentos', [now()->format('Y-m')])}}" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> Traslados</h2>
        </div>
        <div class="col-md-2">
            {{-- <x-scanner/> --}}
        </div>
    </div>
    <br>
    <div class="row">
        <form action="{{route('updateregistroalmacen')}}" method="post">
            @csrf
            <div class="col-12">
                <ul class="list-group" id="lista-traslado" style="visibility: hidden;overflow:auto">
                    <li class="list-group-item bg-sistema-uno text-light">
                        <div class="row pt-1 text-center">
                            <div class="col-md-4">
                                <h6>Producto</h6>
                            </div>
                            <div class="col-md-2">
                                <h6>Serie</h6>
                            </div>
                            <div class="col-md-1">
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
            <br>
            <div class="col-md-12 text-center" id="btn-reubicar" style="display: none">
                <button type="submit" class="btn btn-success"><i class="bi bi-arrow-left-right" ></i> Reubicar</button>
            </div>
        </form>
    </div>
    <div class="row" id="aviso-vacio">
        <div class="col-12 d-flex justify-content-center align-items-center text-secondary text-decoration-underline" style="height:60vh">
            <h4>Añade una serie para su traslado</h4>
        </div>
    </div>
    
</div>
<script>
    var almacenes = @json($almacenes);
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
                            divRow.classList.add('row','text-center');
                            
                            let divColProduct = document.createElement('div');
                            divColProduct.classList.add('col-4','col-md-3', 'text-start');
                            let smallProduct = document.createElement('small');
                            smallProduct.textContent = item.Proveedor.nombreProveedor;
                            divColProduct.appendChild(smallProduct);
                            
                            let divColSerial = document.createElement('div');
                            divColSerial.classList.add('col-4','col-md-6');
                            let smallSerial = document.createElement('small');
                            smallSerial.textContent = item.numeroSerie;
                            divColSerial.appendChild(smallSerial);
                            
                            let divColDate = document.createElement('div');
                            divColDate.classList.add('col-4','col-md-3','text-end');
                            let smallDate = document.createElement('small');
                            smallDate.textContent = item.fechaIngresoPerso;
                            divColDate.appendChild(smallDate);
                            
                            li.addEventListener('click', function() {
                                document.getElementById('search').value = ''; 
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
        if(validateDuplicity(object.Registro.numeroSerie)){
            alert('Producto ya agregado');
            return;
        }
        let ulTraslado = document.getElementById('lista-traslado');

        let itemTraslado = document.createElement('li');
        itemTraslado.classList.add('list-group-item','item-traslado');
        itemTraslado.setAttribute('data-serie', object.Registro.numeroSerie);
        
        let divRow = document.createElement('div');
        divRow.classList.add('row','text-center');

        let divColProducto = document.createElement('div');
        divColProducto.classList.add('col-md-4','text-start');
        divColProducto.innerHTML = "<strong>"+object.Producto.modelo+"</strong><br><small class='text-secondary'>"+object.Producto.codigoProducto+"</small>";

        let divColSerie = document.createElement('div');
        divColSerie.classList.add('col-md-2');
        divColSerie.innerHTML = '<small>'+object.Registro.numeroSerie+'</small><br><small class="text-secondary">'+object.Proveedor.nombreProveedor+'</small>';

        let divColEstado = document.createElement('div');
        divColEstado.classList.add('col-md-1');
        divColEstado.innerHTML = '<small>'+object.Registro.estado+'</small>';

        let divColOrigen = document.createElement('div');
        divColOrigen.classList.add('col-md-2');
        divColOrigen.innerHTML = "<select class='form-select form-select-sm' disabled>"+
                                "<option selected>"+object.Almacen.descripcion+"</option>"
                                +"</select>";

        let divColDestino = document.createElement('div');
        divColDestino.classList.add('col-md-2');
        let selectDestino = document.createElement('select');
        selectDestino.name = 'traslado['+object.idRegistro+']'
        selectDestino.classList.add('form-select','form-select-sm');
        let defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '-elige un destino-';
        selectDestino.appendChild(defaultOption);
        almacenes.forEach(almacen => {
            if(object.Almacen.idAlmacen != almacen.idAlmacen){
                let optionDestino = document.createElement('option');
                optionDestino.value = almacen.idAlmacen;
                optionDestino.textContent = almacen.descripcion;
                selectDestino.appendChild(optionDestino);
            }
        });
        divColDestino.appendChild(selectDestino);

        let divColBtnDelete = document.createElement('div');
        divColBtnDelete.classList.add('col-md-1');
        let btnDelete = document.createElement('button');
        btnDelete.classList.add('btn','btn-danger','btn-sm');
        btnDelete.type = 'button';
        btnDelete.innerHTML = '<i class="bi bi-trash-fill"></i>';
        btnDelete.addEventListener('click',function(event){
            itemTraslado.remove();
            validateProductos();
        });
        divColBtnDelete.appendChild(btnDelete);

        divRow.appendChild(divColProducto); 
        divRow.appendChild(divColSerie); 
        divRow.appendChild(divColEstado); 
        divRow.appendChild(divColOrigen); 
        divRow.appendChild(divColDestino); 
        divRow.appendChild(divColBtnDelete); 
        itemTraslado.appendChild(divRow);
        ulTraslado.appendChild(itemTraslado);
        validateProductos();
    }

    function validateProductos(){
        let itemsProductos = document.querySelectorAll('.item-traslado');
        let ulTraslado = document.getElementById('lista-traslado');
        let avisoVacio = document.getElementById('aviso-vacio');
        let btnReubicar = document.getElementById('btn-reubicar');

        if(itemsProductos.length > 0){
            ulTraslado.style.visibility = 'visible';
            ulTraslado.style.height = '70vh';
            avisoVacio.style.display = 'none';
            btnReubicar.style.display = 'block';
        }else{
            ulTraslado.style.visibility = 'hidden';
            ulTraslado.style.height = '0';
            avisoVacio.style.display = 'block';
            btnReubicar.style.display = 'none';
        }
    }

    function validateDuplicity(serial){
        let itemsProductos = document.querySelectorAll('.item-traslado');
        if(itemsProductos.length > 0){
            for (let i = 0; i < itemsProductos.length; i++) {
                if (itemsProductos[i].dataset.serie == serial) {
                     return true; 
                } 
            }
        }
        return false;
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