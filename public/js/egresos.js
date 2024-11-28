function sendDetailModal(json) {

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
    } else {
        inputEgreso.disabled = false;
        inputEgreso.value = '';
        inputNumberOrder.disabled = false;
        inputNumberOrder.value = '';
        hiddenEgreso.value = '';
    }
}

function validateEgreso() {
    let inputsEgreso = document.querySelectorAll('.input-egreso');
    let disabledInput = false;

    inputsEgreso.forEach(function (x) {
        if (x.value == '') {
            disabledInput = true;
        }
    });

    return disabledInput;
}

function handleBtnRegistrar() {
    let btnRegEgreso = document.getElementById('btnRegistrarEgreso');

    btnRegEgreso.disabled = validateEgreso();
}

document.addEventListener('DOMContentLoaded', function () {
    handleBtnRegistrar();
});

document.getElementById('check-sku-egreso').addEventListener('change', checkSku);
document.getElementById('check-sku-egreso').addEventListener('change', handleBtnRegistrar);

let allInputsEgreso = document.querySelectorAll('.input-egreso');
allInputsEgreso.forEach(function (x) {
    x.addEventListener('input', handleBtnRegistrar);
});

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
                        suggestions.innerHTML =
                            ''; // Limpiar sugerencias después de seleccionar una
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
                        suggestions.innerHTML =
                            ''; // Limpiar sugerencias después de seleccionar una
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

document.getElementById('month').addEventListener('change', function () {
    let selectedMonth = this.value;

    if (selectedMonth == "") {
        alert('Fecha no valida.');
    } else {
        let url = "/egresos/" + selectedMonth;

        window.location.href = url;
    }
});

document.getElementById('month').addEventListener('keydown', function (event) {
    // Evita que la acci贸n de borrado ocurra si se presiona Backspace o Delete
    if (event.key === 'Backspace' || event.key === 'Delete') {
        event.preventDefault();
    }
});

function viewModalEgreso(titulo,jsonRegistro,jsonEgreso,jsonPublicacion){
    let modalEgreso = new bootstrap.Modal(document.getElementById('detailEgresoModal'));
    let labelTitulo = document.getElementById('modal-egreso-titulo');
    let labelSerialNumber = document.getElementById('modal-egreso-serialnumber');
    let labelEstado = document.getElementById('modal-egreso-estado');
    let labelUsuario = document.getElementById('modal-egreso-usuario');
    let divFecha = document.getElementById('modal-egreso-fecha');
    let divPublicacion = document.getElementById('modal-egreso-observacion');
    let textAreaObservacion = document.getElementById('modal-egreso-observacion');
    console.log(jsonPublicacion);

    labelSerialNumber.textContent = jsonRegistro.numeroSerie;
    labelEstado.textContent = jsonRegistro.estado;
    labelTitulo.textContent = titulo;
    textAreaObservacion.value = jsonRegistro.observacion;

    if(jsonRegistro.estado == 'ENTREGADO'){
        divFecha.innerHTML = '<p class="mb-0"><small><strong>Fecha Compra:</strong> '+stringDate(jsonEgreso.fechaCompra)+'</small></p>'+
                            '<p class="mt-0 mb-0"><small><strong>Fecha Despacho:</strong>'+stringDate(jsonEgreso.fechaDespacho)+'</small></p>';
    }else{
        divFecha.innerHTML = '<p class="mb-0"><small><strong>Fecha Devolución:</strong> '+stringDate(jsonEgreso.fechaCompra)+'</small></p>';
    }

    if(jsonPublicacion == null){
        divPublicacion.innerHTML = '<strong class="text-secondary">Sin publicación</strong>';
    }

    modalEgreso.show();
}

function stringDate(date){
    let fecha = new Date(date);
    let day = fecha.getDate().toString().padStart(2, '0');
    let month = (fecha.getMonth() + 1).toString().padStart(2, '0');
    let year = fecha.getFullYear();

    return `${day}/${month}/${year}`;
} 