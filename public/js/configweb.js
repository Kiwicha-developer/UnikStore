let isDisabledCalGeneral = false;
    let isDisabledCorreos = false;

    function correosEmpresaDisabled() {
        let btnSaveCorreo = document.getElementById('btnSaveCorreos');
        let divCorreoEmpresa = document.getElementById('correos-empresa');
        let btnEditCorreoEmpresa = divCorreoEmpresa.querySelectorAll('.input-edit'); 
    
        isDisabledCorreos= !isDisabledCorreos;
        
        if(isDisabledCorreos){
            btnSaveCorreo.style.display = 'none';
        }else{
            btnSaveCorreo.style.display = 'inline-flex';
        }
    
        btnEditCorreoEmpresa.forEach(function(x) {
            x.disabled = isDisabledCorreos;
        });
    }

    function sendDataToModalCuentas(id,banco,tipo,titular,cuenta){
        let spanModal = document.getElementById('span-modal-cuenta');
        let smallModal = document.getElementById('small-modal-cuenta');
        let inputTitular = document.getElementById('input-titular-modal-cuenta');
        let inputCuenta = document.getElementById('input-cuenta-modal-cuenta');
        let hiddenModal = document.getElementById('hidden-modal-cuenta');

        spanModal.textContent = banco;
        smallModal.textContent = tipo;
        inputTitular.value = titular;
        inputCuenta.value = cuenta;
        hiddenModal.value = id;
    }

    document.addEventListener('DOMContentLoaded', function() {
        correosEmpresaDisabled();
    });