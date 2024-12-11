    var inputsModalProduct = document.querySelectorAll('.input-modal-product');
    var arrayEstados = @json($estados);
    
    var index = 1;
    var totalComprobante = 0;
    
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

        if (!productInput.value.trim()) {
            return;
        }
        
        let liBtnAdd = document.getElementById('li-btn-add');//posiublemente borrar
        
        let ulIngreso = document.getElementById('ul-ingreso');

        let liProduct = createLi(['list-group-item','list-group-item-dark'],'header-list-product-' + index);

        let inputHiddenProduct = createInput(null,'header-hidden-product-' + index,'hidden',index,null);
        inputHiddenProduct.dataset.medida = selectModalMedida.value;
        inputHiddenProduct.dataset.price = inputModalPrice.value;
        inputHiddenProduct.dataset.id = productInput.dataset.id;
        
        let inputDetalleProducto = createInput(null,null,'hidden',productInput.dataset.id,'detalle['+index+'][producto]');
        let inputDetalleMedida = createInput(null,null,'hidden',selectModalMedida.value,'detalle['+index+'][medida]');
        let inputDetallePrecioUnitario = createInput(null,null,'hidden',inputModalPrice.value,'detalle['+index+'][preciounitario]');
        let inputDetallePrecioTotal = createInput(null,'header-hidden-preciototal-' + index,'hidden',0,'detalle['+index+'][preciototal]');
        
        let divRow = createDiv(['row'],null);

        let divRowOptions = createDiv(['row','collapse'],'collapse-product-'+index);

        let divColOptions = createDiv(['col-8','text-end','pe-0'],null);
        let divColDelete = createDiv(['col-4','text-start'],null);
        
        let divColCantidad = createDiv(['col-1','col-md-1','text-center'],null);
        let h5Cantidad = createH5(null,'header-cantidad-product-' + inputHiddenProduct.value,'0');
        divColCantidad.appendChild(h5Cantidad);
        
        let divColProduct = createDiv(['col-4','col-md-5','col-lg-3','d-flex','truncate'],null);
        let h5Product = createH5(['h-100','text-uppercase'],null,productInput.value + "&nbsp;");
        let smallProduct = document.createElement('small');
        smallProduct.classList.add('d-none','d-md-block');
        smallProduct.textContent = productInput.dataset.cod;
        divColProduct.appendChild(h5Product);
        divColProduct.appendChild(smallProduct);
        
        let divColMedida = createDiv(['d-none','d-lg-block','col-lg-2','text-center'],null);
        let pMedida = createParrafo(null,null,selectModalMedida.value);
        divColMedida.appendChild(pMedida);
        
        let divColPrecioUnitario = createDiv(['col-2','col-md-2','text-center'],null);
        let pPrecioUnitario = createParrafo(null,'header-preciounitario-product-' + inputHiddenProduct.value,inputModalPrice.value);
        pPrecioUnitario.dataset.price = inputModalPrice.value;
        divColPrecioUnitario.appendChild(pPrecioUnitario);

        let divColPrecioTotal = createDiv(['col-2','col-md-2','text-center'],null);
        let h5TotalPrice = createH5(null,'header-preciototal-product-' + inputHiddenProduct.value,'0');
        h5TotalPrice.dataset.total = '0';
        divColPrecioTotal.appendChild(h5TotalPrice);
        
        let divColButtons = createDiv(['col-3','col-md-2','pe-0','ps-0','text-end'],null);
        let buttonAdd = createButton(['btn', 'btn-success', 'btn-sm'],
                                        null,
                                        '<i class="bi bi-plus-lg"></i>',
                                        'button',
                                        [() => createItemList(inputHiddenProduct.value, ''),() => countProducts(inputHiddenProduct.value)]
                                    );
        let buttonDelete = createButton(['btn','btn-danger','me-2','btn-sm'],
                                            null,
                                            '<i class="bi bi-trash"></i> Eliminar',
                                            'button',
                                            [() => deleteItem(liProduct),() => deleteList(inputHiddenProduct.value),() => countProducts(inputHiddenProduct.value)]
                                        );
        let buttonExcel = createButton(['btn','bg-success','ms-2','btn-sm','text-light'],
                                            null,
                                            '<i class="bi bi-filetype-xlsx"></i> Excel',
                                            'button',
                                            [() => excelButton(inputHiddenProduct.value)]
                                        );
        
        divColDelete.appendChild(buttonDelete);
        divColOptions.innerHTML = '<x-btn-scan :class="'btn-warning btn-sm'" :spanClass="'d-none d-md-inline'"/>';
        divColOptions.appendChild(buttonExcel);
        let buttonOption = document.createElement('button');
        buttonOption.type = 'button';
        buttonOption.dataset.bsToggle = 'collapse';
        buttonOption.dataset.bsTarget = '#collapse-product-'+index;
        buttonOption.ariaExpanded = 'false';
        buttonOption.ariaControls = 'collapse-product-'+index;
        buttonOption.classList.add('btn','btn-sm','btn-secondary','me-2');
        buttonOption.innerHTML = '<i class="bi bi-three-dots-vertical"></i>';
        //divColButtons.innerHTML = '<x-btn-scan :class="'btn-warning btn-sm'" :spanClass="'d-none d-md-inline'"/>';
        //divColButtons.appendChild(buttonDelete);
        //divColButtons.appendChild(buttonExcel);
        divColButtons.appendChild(buttonOption);
        divColButtons.appendChild(buttonAdd);
        
        divRow.appendChild(divColCantidad);
        divRow.appendChild(divColProduct);
        divRow.appendChild(divColMedida);
        divRow.appendChild(divColPrecioUnitario);
        divRow.appendChild(divColPrecioTotal);
        divRow.appendChild(divColButtons);
        divRowOptions.appendChild(divColDelete);
        divRowOptions.appendChild(divColOptions);
        liProduct.appendChild(inputDetalleProducto);
        liProduct.appendChild(inputHiddenProduct);
        liProduct.appendChild(inputDetalleMedida);
        liProduct.appendChild(inputDetallePrecioUnitario);inputDetallePrecioTotal
        liProduct.appendChild(inputDetallePrecioTotal);
        liProduct.appendChild(divRow);
        liProduct.appendChild(divRowOptions);
        ulIngreso.appendChild(liProduct);
        
        index++;
        
        inputsModal.forEach(function(x){
            x.value = "";
        });
    }

    function excelButton(id){
        let inputFile = document.getElementById('excel-file');
        inputFile.accept = '.xls,.xlsx';
        inputFile.click();
        setIdList(id);
    }
    
    function createItemList(id,serial){
        let headerLi = document.getElementById('header-list-product-' + id);
        let headerHidden = document.getElementById('header-hidden-product-' + id);
        
        cont = document.querySelectorAll('.item-list-product-' + id).length ;
        
        let liItem = createLi(['list-group-item','item-list-product-' + id],null);

        let divRow = createDiv(['row'],null);
        
        let divColSerialNumber = createDiv(['col-6','col-md-4','col-lg-3'],null);
        let divInputGroup = createDiv(['input-group','input-group-sm'],null);
        let inputSerialNumber = createInput(['form-control','form-control-sm','input-serial', 'input-serial-' + id],null,'text',serial ? serial : null,'detalle['+id+'][ingreso]['+cont+'][serialnumber]');
        inputSerialNumber.placeholder="Serial number..";
        let divInputGroupText = createDiv(['input-group-text'],null);
        let checkSerialNumber = createInput(['form-check-input','check-serial-' + id],null,'checkbox',null,null);
        checkSerialNumber.addEventListener('change', function() {disabledSerialNumber(this,inputSerialNumber);});
        divInputGroupText.appendChild(checkSerialNumber);
        divInputGroup.appendChild(inputSerialNumber);
        divInputGroup.appendChild(divInputGroupText);
        divColSerialNumber.appendChild(divInputGroup);
        
        let divColEstado = createDiv(['col-4','col-md-2'],null);
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
        
        let divColObservacion = createDiv(['d-none','d-md-block','col-md-5','col-lg-6'],null);
        let inputObservacion = createInput(['form-control','form-control-sm'],null,'text',null,'detalle['+id+'][ingreso]['+cont+'][observacion]');
        inputObservacion.placeholder="Observaciones...";
        divColObservacion.appendChild(inputObservacion);
        
        let divColDelete = createDiv(['col-2','col-md-1','text-end'],null);
        let btnDelete = createButton(['btn','btn-danger','btn-sm'],null,'<i class="bi bi-x-lg"></i>','button',[ () => deleteItem(liItem),
                                                                                                                () => countProducts(id)
                                                                                                                ]);
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
        let selectMoneda = document.getElementById('select-moneda');
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

        if(selectMoneda.value == ''){
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
        let selectMoneda = document.getElementById('select-moneda');
        
        inputsForm.forEach(function(x){
            x.addEventListener('input',validateRegistro);
        });
        selectsForm.forEach(function(x){
            x.addEventListener('change',validateRegistro);
        });
        selectAdquisicion.addEventListener('change',validateRegistro);
        selectAlmacen.addEventListener('change',validateRegistro);
        selectMoneda.addEventListener('change',validateRegistro);
    }
    
    function updateBtnAdd(){
        updateValidate();
        validateRegistro();
    }
    
    function countProducts(id){
        let importeTotal = 0;
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
        totalComprobante = importeTotal.toFixed(2);
        updateTotalProductos();
    }

    function updateTotalProductos(){
        let inputImporteTotal = document.getElementById('importe-total-comprobante');
        let inputDescuento = document.getElementById('importe-descuento-comprobante');
        inputImporteTotal.value = totalComprobante - inputDescuento.value;
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
    document.getElementById('importe-descuento-comprobante').addEventListener('blur', updateTotalProductos);;
    
    document.addEventListener('DOMContentLoaded', function() {
        validateDisabledRegistro();
        validateRegistro();
    });

    function openPdfInNewWindow() {
        var url = "{{route('generarSeriesPdf',[$documento->idComprobante])}}";
        window.open(url, '', 'width=800,height=600,scrollbars=yes,location=no,toolbar=no,status=no');
    }

    var listData = '';
    function readExcel(input) { 
        const file = input.files[0]; 
        if (file) { 
            const reader = new FileReader(); 
            reader.onload = function(event) { 
                const data = event.target.result; 
                const workbook = XLSX.read(data, { type: "binary" }); 
                const sheetName = workbook.SheetNames[0]; 
                const worksheet = workbook.Sheets[sheetName]; 
                const jsonData = XLSX.utils.sheet_to_json(worksheet); 
                const key = jsonData[0] ? Object.keys(jsonData[0])[0] : null;
                const values = Object.values(jsonData);
                if(key === 'SERIES'){
                    values.forEach(function(x){
                        if(x.SERIES == 'nulo'){
                            createItemList(listData,'0');
                        }else{
                            createItemList(listData,x.SERIES);
                        }
                        countProducts(listData);
                        invalidarChecks(listData);
                        updateBtnAdd();
                    });
                    listData = '';
                }else{
                    alert('Plantilla incorrecta, porfavor usa la plantilla ubicada en la parte inferior.');
                    listData = '';
                }
                input.value = '';
            }; 
        reader.readAsBinaryString(file); 
        } 
        input.value = '';
    }

    function setIdList (id){
        listData = id;
    }

    function invalidarChecks(id){
        let inputsText = document.querySelectorAll('.input-serial-'+id);
        let checks = document.querySelectorAll('.check-serial-'+id);

        inputsText.forEach(function(x){
            x.readOnly = true;
        });

        checks.forEach(function(x){
            x.checked = true;
        });
    }

    function generatePlantilla(){
        const headers = ["SERIES","!!Solo coloca valores en la columna de series(si no tiene serie coloca la palabra 'nulo')!!"];

        // Crear una fila de datos vacíos para las cabeceras
        const data = [headers]; // Solo cabeceras, sin datos

        // Crear la hoja de trabajo a partir de las cabeceras
        const ws = XLSX.utils.aoa_to_sheet(data);

        // Crear un libro de trabajo y agregar la hoja
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Plantilla");

        // Escribir el archivo Excel y permitir su descarga
        XLSX.writeFile(wb, "plantilla_series.xlsx");
    }
    
    function validateSeries(idProveedor){
        let inputSeries = document.querySelectorAll('.input-serial');
        let series = [];

        inputSeries.forEach(function(x){
            series.push(x.value);
        });

        let seriesParams = series.map(s => `serial[]=${encodeURIComponent(s)}`).join('&');

        let xhr = new XMLHttpRequest();
            xhr.open('GET', `/documento/validateseries?${seriesParams}&proveedor=${idProveedor}`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let data = JSON.parse(xhr.responseText);
                    if(data.valid){
                        Swal.fire({
                            title: 'Numeros de serie ya registrados!!',
                            text: data.series,
                            icon: 'warning',
                            iconColor: '#00b1b9',
                            confirmButtonText: 'Aceptar', 
                            customClass: {
                                confirmButton: 'btn-primary',  
                            },
                            reverseButtons: true
                            });
                    }else{
                        confirmForm();
                    }
                    console.log(typeof data.series);
                }
            };
            xhr.send();
    }

    function confirmForm(){
        let formDocumento = document.getElementById('form-create-doc');
        Swal.fire({
        title: '!!No podras modificar el documento despues!!',
        text: '¿Estás seguro de que deseas continuar?',
        icon: 'warning',
        iconColor: '#00b1b9',
        showCancelButton: true, 
        confirmButtonText: 'Aceptar',  
        cancelButtonText: 'Cancelar', 
        customClass: {
            confirmButton: 'btn-primary',  
            cancelButton: 'btn btn-danger'
        },
        reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                formDocumento.submit();
            }
        });
    }

    function deleteForm(idComprobante){
        let formDelete = document.getElementById('form-deletecomprobante');
        let hiddenDelete = document.getElementById('hidden-form-deletecomprobante');
        
        Swal.fire({
        title: '¿Seguro de eliminar este documento?',
        text: '!Esta acción no se podra revertir !',
        icon: 'warning',
        iconColor: '#00b1b9',
        showCancelButton: true, 
        confirmButtonText: 'Aceptar',  
        cancelButtonText: 'Cancelar', 
        customClass: {
            confirmButton: 'btn btn-danger',  
            cancelButton: 'btn btn-secondary'
        },
        reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                hiddenDelete.value = idComprobante;
                formDelete.submit();
            }
        });
    }
