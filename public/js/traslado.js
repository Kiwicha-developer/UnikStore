let hiddenBody = document.getElementById('hidden-body');
let suggestionUl = document.getElementById('suggestions');

document.getElementById('search').addEventListener('input', function () {
    let inputQuery = this;
    let query = inputQuery.value;

    if (query.length > 2) {
        let data = null;
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `/ingresos/searchingresos?query=${query}`, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                hiddenBody.style.display = 'block';
                data = JSON.parse(xhr.responseText);

                data.forEach(item => {
                    let liItem = createLi(['list-group-item','hover-sistema-uno'], null);
                    liItem.style.cursor = 'pointer';

                    let rowItem = createDiv(['row'],null);

                    let colSerie = createDiv(['col-12'],null);
                    colSerie.textContent = item.numeroSerie;

                    let colProducto = createDiv(['col-12','text-secondary'],null);
                    colProducto.innerHTML = '<small>'+item.Producto.codigoProducto+'</small>';

                    console.log(item);
                    rowItem.appendChild(colSerie);
                    rowItem.appendChild(colProducto);
                    liItem.appendChild(rowItem);

                    liItem.addEventListener('click',function(){
                        addProductoSerial(item);
                        suggestionUl.innerHTML = '';
                        hiddenBody.style.display = 'none';
                        inputQuery.value = item.numeroSerie;
                    });

                    suggestionUl.appendChild(liItem); 
                });
            }
        };
        xhr.send();
        return data;
    } else {
        suggestionUl.innerHTML = ''; 
        hiddenBody.style.display = 'none';
    }

});

function searchCodeToController(query) {
    let data = null;
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `/ingresos/getoneingreso?query=${query}`, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            data = JSON.parse(xhr.responseText);
            addProductoSerial(data);
        }
    };
    xhr.send();
    return data;
}

function validateSerials() {
    getSerials().forEach(function (x) {
        searchCodeToController(x);
    });

}

function addProductoSerial(object) {
    console.log(object);
    if (object == null || Object.keys(object).length == 0) {
        alertBootstrap('Producto no registrado','warning');
        return;
    }
    if (validateDuplicity(object.Registro.numeroSerie)) {
        alertBootstrap('Producto ' + object.Registro.numeroSerie + ' ya agregado', 'warning');
        return;
    }
    let ulTraslado = document.getElementById('lista-traslado');

    let itemTraslado = createLi(['list-group-item', 'item-traslado'],null);
    itemTraslado.setAttribute('data-serie', object.Registro.numeroSerie);

    let divRow = createDiv(['row', 'text-center'],null);

    let divColProducto = createDiv(['col-10','col-md-4', 'text-start'],null);
    divColProducto.innerHTML = "<strong>" + object.Producto.modelo + "</strong><br class='d-none d-md-inline'><small class='text-secondary d-none d-md-inline'>" + object.Producto.codigoProducto + "</small>";

    let divColLinkDelete = createDiv(['col-2','d-md-none', 'text-end'],null);
    let linkDelete = createLink(['text-danger'],null,'<i class="bi bi-x-lg"></i>','javascript:void(0)',[() => itemTraslado.remove(),() => validateProductos()]);
    divColLinkDelete.appendChild(linkDelete);

    let divColSerie = createDiv(['col-md-2','text-start','text-md-center'],null);
    divColSerie.innerHTML = '<small>' + object.Registro.numeroSerie + '</small><br class="d-none d-md-inline"><small class="text-secondary d-none d-md-inline">' + object.Proveedor.nombreProveedor + '</small>';

    let divColEstado = createDiv(['col-md-1','d-none','d-md-block'],null);
    divColEstado.innerHTML = '<small>' + object.Registro.estado + '</small>';

    let divColOrigen = createDiv(['col-6','col-md-2'],null);
    divColOrigen.innerHTML = '<small class="form-label d-md-none">Origen</small>'+"<select class='form-select form-select-sm' disabled>" +
        "<option selected>" + object.Almacen.descripcion + "</option>"
        + "</select>";

    let divColDestino = createDiv(['col-6','col-md-2'],null);
    let selectDestino = document.createElement('select');
    selectDestino.name = 'traslado[' + object.idRegistro + ']'
    selectDestino.classList.add('form-select', 'form-select-sm');
    let defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = '-elige un destino-';
    selectDestino.appendChild(defaultOption);
    almacenes.forEach(almacen => {
        if (object.Almacen.idAlmacen != almacen.idAlmacen) {
            let optionDestino = document.createElement('option');
            optionDestino.value = almacen.idAlmacen;
            optionDestino.textContent = almacen.descripcion;
            selectDestino.appendChild(optionDestino);
        }
    });
    divColDestino.innerHTML = '<small class="form-label d-md-none">Destino</small>';
    divColDestino.appendChild(selectDestino);

    let divColBtnDelete = createDiv(['col-md-1','text-start','text-md-center','d-none','d-md-block'],null);
    let btnDelete = createButton(['btn', 'btn-danger', 'btn-sm'],null,'<i class="bi bi-trash-fill"></i>','button',[() => itemTraslado.remove(),() => validateProductos()]);
    divColBtnDelete.appendChild(btnDelete);

    divRow.appendChild(divColProducto);
    divRow.appendChild(divColLinkDelete);
    divRow.appendChild(divColSerie);
    divRow.appendChild(divColEstado);
    divRow.appendChild(divColOrigen);
    divRow.appendChild(divColDestino);
    divRow.appendChild(divColBtnDelete);
    itemTraslado.appendChild(divRow);
    ulTraslado.appendChild(itemTraslado);
    validateProductos();
}

function validateProductos() {
    let itemsProductos = document.querySelectorAll('.item-traslado');
    let ulTraslado = document.getElementById('lista-traslado');
    let avisoVacio = document.getElementById('aviso-vacio');
    let btnReubicar = document.getElementById('btn-reubicar');

    if (itemsProductos.length > 0) {
        ulTraslado.style.visibility = 'visible';
        ulTraslado.style.height = '70vh';
        avisoVacio.style.display = 'none';
        btnReubicar.style.display = 'block';
    } else {
        ulTraslado.style.visibility = 'hidden';
        ulTraslado.style.height = '0';
        avisoVacio.style.display = 'block';
        btnReubicar.style.display = 'none';
    }
}

function validateDuplicity(serial) {
    let itemsProductos = document.querySelectorAll('.item-traslado');
    if (itemsProductos.length > 0) {
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

document.getElementById('btn-list-scan-codes').addEventListener('click', function (event) {

    validateSerials();
});