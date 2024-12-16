function sendDataToEdit(spect,tipo,title,sugerencias){
    let tituloModal = document.getElementById('title-modal-editespecificacion');
    let hiddenModal = document.getElementById('hidden-modal-editespecificacion');
    let tipoSelectModal = document.getElementById('tipo-modal-editespecificacion');
    let divFiltros = document.getElementById('filtros-modal-editespecificacion');

    tituloModal.textContent = title;
    hiddenModal.value = spect;
    tipoSelectModal.value = tipo;
    divFiltros.innerHTML = '';

    if(tipo == 'FILTRO'){
        createSugerencias(sugerencias,divFiltros);
    }
}

function createSugerencias(object,container){
    let rowCab = createDiv(['row'],null);
    let divColLabel = createDiv(['col-6'],null);
    let divColBtnAdd = createDiv(['col-6','text-end'],null);
    
    let labelFiltros = document.createElement('label');
    labelFiltros.classList.add('form-label','mt-2');
    labelFiltros.textContent = 'Sugerencias:';
    divColLabel.appendChild(labelFiltros);

    let btnAddSugerencia = createButton(['btn','btn-success','btn-sm','mt-2'],null,'<i class="bi bi-plus-lg"></i>','button',null);
    btnAddSugerencia.addEventListener('click',function(){
        let newLiSugerencia = document.createElement('li');
        newLiSugerencia.classList.add('list-group-item','pt-0','pb-0','ps-0','pe-0');

        let newInputGroup = document.createElement('div');
        newInputGroup.classList.add('input-group');

        let newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.classList.add('form-control','border-0');
        newInput.name = 'createsugerencia[]';
        newInputGroup.appendChild(newInput);

        let btnRemoveInput = document.createElement('button');
        btnRemoveInput.classList.add('btn','btn-outline-danger');
        btnRemoveInput.innerHTML = '<i class="bi bi-x-lg"></i>';
        btnRemoveInput.type = 'button';
        btnRemoveInput.addEventListener('click',function(event){
            newLiSugerencia.remove();
        });
        newInputGroup.appendChild(btnRemoveInput);

        newLiSugerencia.appendChild(newInputGroup);
        listaSugerencias.appendChild(newLiSugerencia);
    });
    divColBtnAdd.appendChild(btnAddSugerencia);

    let listaSugerencias = document.createElement('ul');
    listaSugerencias.classList.add('list-group','mt-2');

    if(object != null){
        Object.values(object).forEach((valor) => {
            let liSugerencia = document.createElement('li');
            liSugerencia.classList.add('list-group-item','pt-0','pb-0','ps-0','pe-0');
    
            let inputGroup = document.createElement('div');
            inputGroup.classList.add('input-group');
    
            let inputSugerencia = document.createElement('input');
            inputSugerencia.type = 'text';
            inputSugerencia.classList.add('form-control','border-0');
            inputSugerencia.value = valor.sugerencia;
            inputSugerencia.name = 'updatesugerencia['+ valor.idSugerencia +']';
            inputGroup.appendChild(inputSugerencia);
    
            let btnDeleteSugerencia = document.createElement('button');
            btnDeleteSugerencia.classList.add('btn','btn-outline-danger');
            btnDeleteSugerencia.innerHTML = '<i class="bi bi-x-lg"></i>';
            btnDeleteSugerencia.type = 'button';
            btnDeleteSugerencia.addEventListener('click',function(event){
                sendDataToRemoveSugerencia(valor.idSugerencia);
            });
            inputGroup.appendChild(btnDeleteSugerencia);
    
            console.log( valor);
            liSugerencia.appendChild(inputGroup);
            listaSugerencias.appendChild(liSugerencia);
        });
    }
    
    rowCab.appendChild(divColLabel);
    rowCab.appendChild(divColBtnAdd);
    
    container.appendChild(rowCab);
    container.appendChild(listaSugerencias);
}

function changeOperacionModal(valor){
    let inputOperacion = document.getElementById('operacion-modal-editespecificacion');

    inputOperacion.value = valor;
}