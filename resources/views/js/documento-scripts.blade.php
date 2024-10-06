
    var inputsModalProduct = document.querySelectorAll('.input-modal-product');
    var arrayUbicaciones = @json($ubicaciones);
    var arrayEstados = @json($estados);
    var arrayAdquisiciones = @json($adquisiciones);
    
    var index = 1;
    
    function sendIdToDelete(id){
        let inputDelete = document.getElementById('input-delete-ingreso');
        inputDelete.value = id;
    }
    
    function validateDisabledRegistro(){
        let btnModalProduct = document.getElementById('btnIngreso');
        let disabledBtn = false;
        
        inputsModalProduct.forEach(function(x){
            if(x.value == ''){
                disabledBtn = true;
            }
        });
        
        btnModalProduct.disabled = disabledBtn;
    }
    
    function searchProduct(inputElement){
        let query = inputElement.value;
        
        function handleClickOutside(event) {
            let suggestions = document.getElementById('suggestions-product');
            if (!suggestions.contains(event.target) && event.target !== inputElement) {
                suggestions.innerHTML = ''; // Limpiar sugerencias si se hace clic fuera del input
            }
        }
    
        // Agregar el manejador de clics al documento
        document.addEventListener('click', handleClickOutside);
        
        if (query.length > 2) { // Comenzar la búsqueda después de 3 caracteres
            document.getElementById('modal-hidden-product').value = "";
            let xhr = new XMLHttpRequest();
            xhr.open('GET', `/productos/searchmodelproduct?query=${query}`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let data = JSON.parse(xhr.responseText);
                    let suggestions = document.getElementById('suggestions-product');
                    suggestions.innerHTML = '';
    
                        data.forEach(item => {
                        let li = document.createElement('li');
                        li.textContent = item.modelo;
                        li.classList.add('list-group-item');
                        li.classList.add('hover-sistema-uno');
                        li.style.cursor = "pointer";
                        
                        li.addEventListener('click', function() {
                            inputElement.value = this.textContent;
                            document.getElementById('modal-hidden-product').value = item.modelo;
                            document.getElementById('modal-hidden-product').dataset.id = item.idProducto;
                            document.getElementById('modal-hidden-product').dataset.cod = item.codigoProducto;
                            validateDisabledRegistro();
                            suggestions.innerHTML = ''; // Limpiar sugerencias después de seleccionar una
                        });
    
                        suggestions.appendChild(li);
                    });
                }
            };
            xhr.send();
        } else {
            document.getElementById('suggestions-product').innerHTML = ''; // Limpiar si hay menos de 3 caracteres
            document.getElementById('modal-hidden-product').value = "";
        }
    }
    
    function createProductList(){
        let productInput = document.getElementById('modal-hidden-product');
        let modalDiv = document.getElementById('registerModal');
        let inputsModal = modalDiv.querySelectorAll('input');
        let selectModalMedida = document.getElementById('modal-select-medida');
        let inputModalPrice = document.getElementById('modal-input-price');
        
        let liBtnAdd = document.getElementById('li-btn-add');
        
        let ulIngreso = document.getElementById('ul-ingreso');
        
        let liProduct = document.createElement('li');
        liProduct.classList.add('list-group-item','list-group-item-dark');
        liProduct.id = 'header-list-product-' + index;
        
        let inputHiddenProduct = document.createElement('input');
        inputHiddenProduct.type = "hidden";
        inputHiddenProduct.value = index;
        inputHiddenProduct.dataset.medida = selectModalMedida.value;
        inputHiddenProduct.dataset.price = inputModalPrice.value;
        inputHiddenProduct.dataset.id = productInput.dataset.id;
        inputHiddenProduct.id = 'header-hidden-product-' + index;
        
        let inputDetalleProducto = document.createElement('input');
        inputDetalleProducto.type = 'hidden';
        inputDetalleProducto.value = productInput.dataset.id;
        inputDetalleProducto.name = 'detalle['+index+'][producto]';
        
        let inputDetalleMedida = document.createElement('input');
        inputDetalleMedida.type = 'hidden';
        inputDetalleMedida.value = selectModalMedida.value;
        inputDetalleMedida.name = 'detalle['+index+'][medida]';
        
        let inputDetallePrecioUnitario = document.createElement('input');
        inputDetallePrecioUnitario.type = 'hidden';
        inputDetallePrecioUnitario.value = inputModalPrice.value;
        inputDetallePrecioUnitario.name = 'detalle['+index+'][preciounitario]';
        
        let inputDetallePrecioTotal = document.createElement('input');
        inputDetallePrecioTotal.type = 'hidden';
        inputDetallePrecioTotal.value = 0;
        inputDetallePrecioTotal.name = 'detalle['+index+'][preciototal]';
        inputDetallePrecioTotal.id = 'header-hidden-preciototal-' + index;
        
        let divRow = document.createElement('div');
        divRow.classList.add('row');
        
        let divColCantidad = document.createElement('div');
        divColCantidad.classList.add('col-md-1','text-center');
        let h5Cantidad = document.createElement('h5');
        h5Cantidad.textContent = 0;
        h5Cantidad.id = 'header-cantidad-product-' + inputHiddenProduct.value;
        divColCantidad.appendChild(h5Cantidad);
        
        let divColProduct = document.createElement('div');
        divColProduct.classList.add('col-md-4','d-flex');
        let h5Product = document.createElement('h5');
        h5Product.classList.add('h-100','text-uppercase');
        h5Product.innerHTML  = productInput.value + "&nbsp;";
        let smallProduct = document.createElement('small');
        smallProduct.textContent = productInput.dataset.cod;
        divColProduct.appendChild(h5Product);
        divColProduct.appendChild(smallProduct);
        
        let divColMedida = document.createElement('div');
        divColMedida.classList.add('col-md-2','text-center');
        let pMedida = document.createElement('p');
        pMedida.textContent = selectModalMedida.value;
        divColMedida.appendChild(pMedida);
        
        let divColPrecioUnitario = document.createElement('div');
        divColPrecioUnitario.classList.add('col-md-2','text-center');
        let pPrecioUnitario = document.createElement('p');
        pPrecioUnitario.textContent = inputModalPrice.value;
        pPrecioUnitario.dataset.price = inputModalPrice.value;
        pPrecioUnitario.id = 'header-preciounitario-product-' + inputHiddenProduct.value;
        divColPrecioUnitario.appendChild(pPrecioUnitario);
        
        let divColPrecioTotal = document.createElement('div');
        divColPrecioTotal.classList.add('col-md-2','text-center');
        let h5TotalPrice = document.createElement('h5');
        h5TotalPrice.textContent = '0';
        h5TotalPrice.dataset.total = '0';
        h5TotalPrice.id = 'header-preciototal-product-' + inputHiddenProduct.value;
        divColPrecioTotal.appendChild(h5TotalPrice);
        
        let divColButtons = document.createElement('div');
        divColButtons.classList.add('col-md-1','pe-0','ps-0','text-end');
        let buttonAdd = document.createElement('button');
        buttonAdd.classList.add('btn','btn-success','btn-sm');
        buttonAdd.type = 'button';
        buttonAdd.innerHTML = '<i class="bi bi-plus-lg"></i>';
        buttonAdd.addEventListener('click', function() {createItemList(inputHiddenProduct.value);countProducts(inputHiddenProduct.value);});
        let buttonDelete = document.createElement('button');
        buttonDelete.classList.add('btn','btn-danger','me-2','btn-sm');
        buttonDelete.type = 'button';
        buttonDelete.innerHTML = '<i class="bi bi-trash"></i>';
        buttonDelete.addEventListener('click', function() {deleteItem(liProduct);deleteList(inputHiddenProduct.value);countProducts(inputHiddenProduct.value);});
        divColButtons.appendChild(buttonDelete);
        divColButtons.appendChild(buttonAdd);
        
        divRow.appendChild(divColCantidad);
        divRow.appendChild(divColProduct);
        divRow.appendChild(divColMedida);
        divRow.appendChild(divColPrecioUnitario);
        divRow.appendChild(divColPrecioTotal);
        divRow.appendChild(divColButtons);
        liProduct.appendChild(inputDetalleProducto);
        liProduct.appendChild(inputHiddenProduct);
        liProduct.appendChild(inputDetalleMedida);
        liProduct.appendChild(inputDetallePrecioUnitario);inputDetallePrecioTotal
        liProduct.appendChild(inputDetallePrecioTotal);
        liProduct.appendChild(divRow);
        ulIngreso.appendChild(liProduct);
        
        index++;
        
        inputsModal.forEach(function(x){
            x.value = "";
        });
    }
    
    function createItemList(id){
        let headerLi = document.getElementById('header-list-product-' + id);
        let headerHidden = document.getElementById('header-hidden-product-' + id);
        
        cont = document.querySelectorAll('.item-list-product-' + id).length ;
        
        let liItem = document.createElement('li');
        liItem.classList.add('list-group-item','item-list-product-' + id);
        
        let divRow = document.createElement('div');
        divRow.classList.add('row');
        
        let divColSerialNumber = document.createElement('div');
        divColSerialNumber.classList.add('col-md-3');
        let divInputGroup = document.createElement('div');
        divInputGroup.classList.add('input-group','input-group-sm');
        let inputSerialNumber = document.createElement('input');
        inputSerialNumber.classList.add('form-control','form-control-sm','input-serial');
        inputSerialNumber.type="text";
        inputSerialNumber.placeholder="Serial number..";
        inputSerialNumber.name = 'detalle['+id+'][ingreso]['+cont+'][serialnumber]';
        let divInputGroupText = document.createElement('div');
        divInputGroupText.classList.add('input-group-text');
        let checkSerialNumber = document.createElement('input');
        checkSerialNumber.type = 'checkbox';
        checkSerialNumber.addEventListener('change', function() {disabledSerialNumber(this,inputSerialNumber);});
        checkSerialNumber.classList.add('form-check-input');
        divInputGroupText.appendChild(checkSerialNumber);
        divInputGroup.appendChild(inputSerialNumber);
        divInputGroup.appendChild(divInputGroupText);
        divColSerialNumber.appendChild(divInputGroup);
        
        let divColEstado = document.createElement('div');
        divColEstado.classList.add('col-md-2');
        let selectEstado = document.createElement('select');
        selectEstado.classList.add('form-select','form-select-sm');
        selectEstado.name = 'detalle['+id+'][ingreso]['+cont+'][estado]';
        arrayEstados.forEach(function(x){
            let optionEstado = document.createElement('option');
            optionEstado.textContent = x['name'];
            optionEstado.value = x['value'];
            selectEstado.appendChild(optionEstado);
        });
        selectEstado.value = 'NUEVO';
        divColEstado.appendChild(selectEstado);
        
        let divColObservacion = document.createElement('div');
        divColObservacion.classList.add('col-md-6');
        let inputObservacion = document.createElement('input');
        inputObservacion.classList.add('form-control','form-control-sm');
        inputObservacion.type="text";
        inputObservacion.name = 'detalle['+id+'][ingreso]['+cont+'][observacion]';
        inputObservacion.placeholder="Observaciones...";
        divColObservacion.appendChild(inputObservacion);
        
        let divColDelete = document.createElement('div');
        divColDelete.classList.add('col-md-1','text-end');
        let btnDelete = document.createElement('button');
        btnDelete.classList.add('btn','btn-danger','btn-sm');
        btnDelete.innerHTML = '<i class="bi bi-x-lg"></i>' ;
        btnDelete.type="button";
        btnDelete.addEventListener('click', function() {deleteItem(liItem);countProducts(id);});
        divColDelete.appendChild(btnDelete);
        
        divRow.appendChild(divColSerialNumber);
        divRow.appendChild(divColEstado);
        divRow.appendChild(divColObservacion);
        divRow.appendChild(divColDelete);
        liItem.appendChild(divRow);
        headerLi.after(liItem);
        updateBtnAdd();
    }
    
    function deleteItem(input){
        input.remove();
        updateBtnAdd();
    }
    
    function deleteList(id){
        let items = document.querySelectorAll('.item-list-product-' + id);
        items.forEach(function(x){
            x.remove();
        });
        updateBtnAdd();
    }
    
    function validateRegistro(){
        let divForm = document.getElementById('ul-ingreso');
        let inputsForm = divForm.querySelectorAll('.input-serial');
        let selectsForm = divForm.querySelectorAll('select');
        let selectAdquisicion = document.getElementById('select-adquisicion');
        let labelAdquisicion = document.getElementById('select-label-adquisicion');
        let selectAlmacen = document.getElementById('select-almacen');
        let btnRegistro = document.getElementById('btnSubmit');
        let disabledBtn = false;
        
        inputsForm.forEach(function(x){
            if(x.value == ''){
                disabledBtn = true;
            }
        });
        
        selectsForm.forEach(function(x){
            if(x.value == ''){
                disabledBtn = true;
            }
        });
        
        if(inputsForm.length < 1){
            disabledBtn = true;
        }
        
        if(selectAdquisicion.value == ''){
                disabledBtn = true;
        }
        
        if(selectAlmacen.value == ''){
            disabledBtn = true;
        }
        btnRegistro.disabled = disabledBtn;
    }
    
    function changeLabel(input,id){
        let label = document.getElementById(id);
        if(input.value == ''){
            label.style.color = 'red';
        }else{
            label.style.color = 'black';
        }
    }
    
    function updateValidate(){
        let divForm = document.getElementById('ul-ingreso');
        let inputsForm = divForm.querySelectorAll('.input-serial');
        let selectsForm = divForm.querySelectorAll('select');
        let selectAdquisicion = document.getElementById('select-adquisicion');
        let selectAlmacen = document.getElementById('select-almacen');
        
        inputsForm.forEach(function(x){
            x.addEventListener('input',validateRegistro);
        });
        selectsForm.forEach(function(x){
            x.addEventListener('change',validateRegistro);
        });
        selectAdquisicion.addEventListener('change',validateRegistro);
        selectAlmacen.addEventListener('change',validateRegistro);
    }
    
    function updateBtnAdd(){
        updateValidate();
        validateRegistro();
    }
    
    function exceptionCountProducts(id){
        
    }
    
    function countProducts(id){
        let importeTotal = 0;
        let inputImporteTotal = document.getElementById('importe-total-comprobante');
        inputImporteTotal.value = importeTotal.toFixed(2);
        let productos = document.querySelectorAll('[id^="header-preciototal-product-"]');
        
        let items = document.querySelectorAll('.item-list-product-' + id);
        let cant = document.getElementById('header-cantidad-product-' + id);
        
        let precioUni = document.getElementById('header-preciounitario-product-'+ id);
        let precioTot = document.getElementById('header-preciototal-product-'+id);
        let hiddenPrecioTot = document.getElementById('header-hidden-preciototal-'+id);
        
        cant.textContent = items.length;
        precioTot.textContent = items.length * precioUni.dataset.price;
        precioTot.dataset.total = items.length * precioUni.dataset.price;
        hiddenPrecioTot.value = items.length * precioUni.dataset.price;
        
        productos.forEach(function(x){
            importeTotal += parseFloat(x.dataset.total);
        });
        
        inputImporteTotal.value = importeTotal.toFixed(2);
    }
    
    function disabledSerialNumber(check,input){
        if(check.checked){
            input.readOnly = true;
            input.value = 0;
        }else{
            input.readOnly = false;
            input.value = '';
        }
        updateBtnAdd();
    }

    document.getElementById('btnIngreso').addEventListener('click', createProductList);
    document.getElementById('btnIngreso').addEventListener('click', updateBtnAdd);
    document.getElementById('modal-input-price').addEventListener('input', validateDisabledRegistro);
    document.getElementById('modal-input-product').addEventListener('input', validateDisabledRegistro);
    document.getElementById('modal-select-medida').addEventListener('change', validateDisabledRegistro);
    
    document.addEventListener('DOMContentLoaded', function() {
        validateDisabledRegistro();
        validateRegistro();
    });