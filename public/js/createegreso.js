const validateIconSku = document.getElementById('sku-modal-egreso-validate');
var path = window.assetUrl;

function searchPublicacion(inputElement) {
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
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let data = JSON.parse(xhr.responseText);
                let suggestions = document.getElementById('suggestions-sku');
                suggestions.innerHTML = '';

                data.forEach(item => {
                    let li = document.createElement('li');
                    li.classList.add('list-group-item', 'pe-0');
                    li.classList.add('hover-sistema-uno', 'text-truncate');
                    li.style.cursor = "pointer";

                    let divRow = document.createElement('div');
                    divRow.classList.add('row', 'w-100');

                    let colSerie = document.createElement('div');
                    colSerie.classList.add('col-md-8');
                    colSerie.textContent = item.sku;

                    let colAlmacen = document.createElement('div');
                    colAlmacen.classList.add('col-md-4', 'text-end');
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

                    li.addEventListener('click', function () {
                        inputElement.value = item.sku;
                        document.getElementById('hidden-publicacion-sku').value = item
                            .idPublicacion;
                        suggestions.innerHTML = ''; // Limpiar sugerencias después de seleccionar una
                        validateIconSku.classList.remove('bi-exclamation-circle', 'text-danger');
                        validateIconSku.classList.add('bi-check-circle', 'text-success');
                    });

                    suggestions.appendChild(li);
                });
            }
        };
        xhr.send();
    } else {
        document.getElementById('suggestions-sku').innerHTML = ''; // Limpiar si hay menos de 3 caracteres
        document.getElementById('hidden-publicacion-sku').value = "";
        validateIconSku.classList.add('bi-exclamation-circle', 'text-danger');
        validateIconSku.classList.remove('bi-check-circle', 'text-success');
    }
}

function checkSku() {
    let checkSku = document.getElementById('check-sku-egreso');
    let inputEgreso = document.getElementById('input-sku-egreso');
    let hiddenEgreso = document.getElementById('hidden-publicacion-sku');
    let inputNumberOrder = document.getElementById('input-numero-orden');

    if (checkSku.checked) {
        inputEgreso.disabled = true;
        inputEgreso.value = checkSku.value;
        inputNumberOrder.disabled = true;
        inputNumberOrder.value = checkSku.value;
        hiddenEgreso.value = 'NULO';
        validateIconSku.classList.remove('bi-exclamation-circle', 'text-danger');
        validateIconSku.classList.add('bi-check-circle', 'text-success');
    } else {
        inputEgreso.disabled = false;
        inputEgreso.value = '';
        inputNumberOrder.disabled = false;
        inputNumberOrder.value = '';
        hiddenEgreso.value = '';
        validateIconSku.classList.add('bi-exclamation-circle', 'text-danger');
        validateIconSku.classList.remove('bi-check-circle', 'text-success');
    }
}

function searchRegistro(inputElement) {
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
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let data = JSON.parse(xhr.responseText);
                let suggestions = document.getElementById('suggestions-serial-number');
                suggestions.innerHTML = '';


                data.forEach(item => {
                    let li = document.createElement('li');
                    li.classList.add('list-group-item', 'pe-0');
                    li.classList.add('hover-sistema-uno', 'text-truncate');
                    li.style.cursor = "pointer";

                    let divRow = document.createElement('div');
                    divRow.classList.add('row', 'w-100');

                    let colSerie = document.createElement('div');
                    colSerie.classList.add('col-md-8');
                    colSerie.textContent = item.numeroSerie;

                    let colAlmacen = document.createElement('div');
                    colAlmacen.classList.add('col-md-4', 'text-end');
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

                    li.addEventListener('click', function () {
                        inputElement.value = item.numeroSerie;
                        document.getElementById('hidden-product-serial-number').value = item
                            .idRegistroProducto;
                        suggestions.innerHTML =''; 
                        rowSerialExists.style.display = 'flex';
                        rowSerialVacio.style.display = 'none';
                        updateDataRowSerial(item);
                    });

                    suggestions.appendChild(li);
                });
            }
        };
        xhr.send();
    } else {
        document.getElementById('suggestions-serial-number').innerHTML = ''; // Limpiar si hay menos de 3 caracteres
        document.getElementById('hidden-product-serial-number').value = "";
        rowSerialExists.style.display = 'none';
        rowSerialVacio.style.display = '';
    }
}


document.getElementById('check-sku-egreso').addEventListener('change', checkSku);