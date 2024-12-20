let serial = '';
let timeoutId; 
let valueSerial = '';

function scannInput(e){
    let barcode = e.target.value; // Obtiene el código escaneado
    
    if (barcode) {
        barcode = changeCharEngToEs(barcode);
      
      serial += barcode;

      e.target.value = '';

      clearTimeout(timeoutId);

      timeoutId = setTimeout(() => {
        valueSerial = serial;
        console.log('peruba'+valueSerial);
        serial = '';
        scanOperations();
      }, 100);
    }
}

function getSerial(){
    return valueSerial;
}

function checkSerialChange(input,idInput){
    let inputSearch = document.getElementById(idInput);

    if(input.checked){
        inputSearch.value = '';
        inputSearch.addEventListener('input', scannInput);
        inputSearch.focus();
    }else{
        inputSearch.removeEventListener('input', scannInput);
    }
}