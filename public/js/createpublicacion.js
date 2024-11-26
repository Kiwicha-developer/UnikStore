function validateData() {
    let titulo = document.getElementById('titulo-public').value;
    let sku = document.getElementById('sku-public').value;
    let producto = document.getElementById('search').value;
    let cuenta = document.getElementById('cuenta-public').value;
    let fecha = document.getElementById('fecha-public').value;
    let precio = document.getElementById('precio-public').value;
    let disabled = false;

    if (titulo == '') {
        disabled = true;
    }

    if (sku == '') {
        disabled = true;
    }

    if (producto == '') {
        disabled = true;
    }

    if (cuenta == '') {
        disabled = true;
    }

    if (fecha == '') {
        disabled = true;
    }

    if (precio == '') {
        disabled = true;
    }

    return disabled;
}

function dissableButton() {
    let btnSave = document.getElementById('btnSave');
    if (validateData()) {
        btnSave.classList.add('disabled');
    } else {
        btnSave.classList.remove('disabled');
    }

}

document.addEventListener('DOMContentLoaded', function () {
    dissableButton();
});

document.getElementById('titulo-public').addEventListener('input', dissableButton);
document.getElementById('sku-public').addEventListener('input', dissableButton);
document.getElementById('cuenta-public').addEventListener('input', dissableButton);
document.getElementById('fecha-public').addEventListener('input', dissableButton);
document.getElementById('precio-public').addEventListener('input', dissableButton);
document.getElementById('search').addEventListener('input', dissableButton);

document.getElementById('search').addEventListener('input', function () {
    let query = this.value;

    if (query.length > 2) { // Comenzar la búsqueda después de 3 caracteres
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `/productos/searchmodelproduct?query=${query}`, true);
        xhr.onreadystatechange = function () {
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

                    li.addEventListener('click', function () {
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