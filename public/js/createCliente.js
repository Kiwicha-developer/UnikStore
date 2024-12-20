const formNewCliente = document.getElementById('modal-form-create-cliente');
let objectCliente = null;
    function changeTipeDoc(input) {
        let modalNewClient = document.getElementById('nuevoClienteModal');
        let nombre = modalNewClient.querySelector('.client-name');
        let apePaterno = modalNewClient.querySelector('.client-apel-patern');
        let apeMaterno = modalNewClient.querySelector('.client-apel-matern');
        let documento = modalNewClient.querySelector('.client-document');

        switch (input.value) {
            case '1':
                apePaterno.style.display = 'block';
                apeMaterno.style.display = 'block';
                documento.textContent = 'DNI:';
                nombre.textContent = 'Nombres:';
                break;
            case '2':
                apePaterno.style.display = 'block';
                apeMaterno.style.display = 'block';
                documento.textContent = 'Carné:';
                nombre.textContent = 'Nombres:';
                break;
            case '3':
                apePaterno.style.display = 'none';
                apeMaterno.style.display = 'none';
                documento.textContent = 'RUC:';
                nombre.textContent = 'Razon Social:';
                break;
            default:
                apePaterno.style.display = 'block';
                apeMaterno.style.display = 'block';
                documento.textContent = 'Nro Documento:';
                nombre.textContent = 'Nombres:';
        }
    }

    function sendFormNewCliente(){
        let responseConfirm = confirm('¿Estas seguro?');

        if(responseConfirm == false){
            return;
        }

        const formData = new FormData(formNewCliente);

        fetch('/cliente/create', { 
            method: 'POST',
            body: formData
        })
        .then(response => { 
            if (response.ok) { 
                return response.json(); 
            } else { 
                throw new Error('Error al registrar.'); 
            } 
        })
        .then(data => {
            objectCliente = data;
            alertBootstrap('Cliente '+data.numeroDocumento+' registrado.', 'success');
        }) 
        .catch(error => {
            console.log('error: ' + error);
            alertBootstrap('error: ' + error, 'danger');
        });
    }

    function getCliente(){
        return objectCliente;
    }