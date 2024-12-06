
let toggleTorch = true;
let currentStream = null;
let currentTrack = null;
let arrayCodes = [];
const codeReader = new ZXing.BrowserMultiFormatReader();
const videoElement = document.getElementById('video');
const textResultadosCamera = document.getElementById('resultado-codes-camera');
const hiddenResultadosCamera = document.getElementById('hidden-resultado-codes-camera');
const messageError = document.getElementById('error-codes');
const messageDuplicity = document.getElementById('duplicity-code');
const checkLenguaje = document.getElementById('check-lenguaje-scan');

function playVideo() {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Solicitamos acceso a la cámara
        navigator.mediaDevices.getUserMedia({
            video: { facingMode: "environment" }

        })
            .then(function (stream) {
                videoElement.srcObject = stream;
                currentStream = stream;
                currentTrack = stream.getVideoTracks()[0];
                const capabilities = currentTrack.getCapabilities();

                if (capabilities.torch) {
                    // Si la cámara tiene soporte para linterna, la activamos
                    document.getElementById('torch-btn').style.display = "block";
                } else {
                    document.getElementById('torch-btn').style.display = "none";
                }
                startScanning();
            })
            .catch(function (err) {
                console.error("Error con la cámara delantera: ", err);
                // Si falla con la delantera, intentar con la trasera
                navigator.mediaDevices.getUserMedia({
                    video: true
                })
                    .then(function (stream) {
                        videoElement.srcObject = stream;
                        currentStream = stream;
                        startScanning(); // Iniciar escaneo con ZXing
                    })
                    .catch(function (err) {
                        alert('No se puede acceder a la cámara.');
                    });
            });
    } else {
        alert('Tu navegador no soporta la cámara web.');
    }
}

function stopVideo() {
    if (currentStream) {
        stopScanning();
        currentStream.getTracks().forEach(track => track.stop());
        videoElement.srcObject = null;

        currentStream = null;
    }
}

function activateTorch(bool) {
    currentTrack.applyConstraints({
        advanced: [{
            torch: bool  // Activar el flash
        }]
    })
        .then(() => {
            console.log("Linterna activada");
        })
        .catch((err) => {
            console.error("Error al activar la linterna:", err);
        });
}

function changeButton(input) {
    if (toggleTorch) {
        input.classList.add('btn-light');
        input.classList.remove('btn-dark');
        activateTorch(true);
        toggleTorch = false;
    } else {
        input.classList.add('btn-dark');
        input.classList.remove('btn-light');
        activateTorch(false);
        toggleTorch = true;
    }
}

function listDevices() {
    navigator.mediaDevices.enumerateDevices()
        .then(devices => {
            // Filtramos solo los dispositivos de tipo video
            const videoDevices = devices.filter(device => device.kind === 'videoinput');

            // Creamos las opciones en el select
            const select = document.getElementById('videoSource');
            videoDevices.forEach(device => {
                const option = document.createElement('option');
                option.value = device.deviceId;
                option.textContent = device.label ||
                    `Cámara ${select.length + 1}`; // Si no tiene label, mostramos algo por defecto
                select.appendChild(option);
            });
        })
        .catch(err => console.error('Error al enumerar dispositivos:', err));
}

function startScanning() {
    // Usamos ZXing para decodificar los códigos de barras desde el video
    arrayCodes = [];
    const scannerFrame = document.getElementById("scannerFrame");
    const frameRect = scannerFrame.getBoundingClientRect();
    codeReader.decodeFromVideoDevice(null, videoElement, (result, err) => {
        if (result) {
            textResultadosCamera.textContent = result.text;
            hiddenResultadosCamera.value = result.text;
            playBeepSound();
            // arrayCodesCamera.push(result.text);
            console.log("Código detectado:", result.text);
            console.log('Formato del código:', result.format);
        }
        if (err && !(err instanceof ZXing.NotFoundException)) {
            console.error(err);
        }
    },
        {
            // Puedes usar más trabajadores si el escáner tiene problemas en dispositivos de gama baja
            numOfWorkers: 4, // Ajusta el número de trabajadores para mayor precisión y rendimiento
            decoderWorker: ZXing.BrowserBarcodeReader.decodeWorker,
            decodeInRealTime: true, // Decodificación en tiempo real para mejorar la precisión
            highlightScanRegion: true,  // Resalta el área de escaneo
            scanRegion: frameRect,
            maxNumOfDecodersPerFrame: 1, // Limitar la cantidad de decodificadores por cuadro
            delay: 500, // Aumentar el retraso entre intentos de lectura (mejora la precisión pero puede hacer más lento el escaneo)
        }
    );

}

function addModalCodesCamera() {
    let code = hiddenResultadosCamera.value;

    if (code != '' && code != null) {
        if (arrayCodes.some(element => element == code)) {
            messageError.textContent = 'Codigo repetido';
            setTimeout(() => { messageError.textContent = ''; }, 1500);
        } else {
            arrayCodes.push(code);
        }
    }
    console.log(arrayCodes);
}



function stopScanning() {
    codeReader.reset();
}

function chooseDevice() {
    const deviceId = document.getElementById('videoSource').value;

    if (deviceId) {
        stopScanning();
        stopVideo();
        navigator.mediaDevices.getUserMedia({
            video: {
                deviceId: {
                    exact: deviceId
                }
            }
        })
            .then(stream => {
                videoElement.srcObject = stream;
                currentStream = stream;
                currentTrack = stream.getVideoTracks()[0];
                const capabilities = currentTrack.getCapabilities();

                if (capabilities.torch) {
                    // Si la cámara tiene soporte para linterna, la activamos
                    document.getElementById('torch-btn').style.display = "block";
                } else {
                    document.getElementById('torch-btn').style.display = "none";
                }

                startScanning();
            })
            .catch(err => {
                alert('No se puede acceder a la cámara seleccionada.');
            });
    }
}

//---------------------------------------------------------------SCANNER---------------------------------------------------------------------
function changeCharEngToEs(inputText) {
    const mapaCaracteres = {
      "'": '-',
    };

    let updateText = inputText;

    for (let [charEng, charEs] of Object.entries(mapaCaracteres)) {
      const regex = new RegExp(`\\${charEng}`, 'g');
      updateText = updateText.replace(regex, charEs);
    }

    return updateText;
  }

  let serial = '';
  let timeoutId; 


document.getElementById('barcode-input').addEventListener('input', function(e) {
    let barcode = e.target.value; // Obtiene el código escaneado
    
    if (barcode) {
        if(!checkLenguaje.checked){
            barcode = changeCharEngToEs(barcode);
        }
      
      serial += barcode;

      e.target.value = '';

      clearTimeout(timeoutId);

      timeoutId = setTimeout(() => {
        addModalCodesScan(serial);
        serial = '';
      }, 1000);
    }
    
  });

  function addModalCodesScan(serie){
    if (arrayCodes.some(element => element == serie)) {
        messageDuplicity.textContent = 'Codigo repetido';
        setTimeout(() => { messageDuplicity.textContent = ''; }, 1500);
    } else {
        arrayCodes.push(serie);
    }
    console.log('Código escaneado corregido:', arrayCodes);
    
  }

//---------------------------------------------------------------GENERALES-------------------------------------------------------------------

function listCodesModal() {
    let ulCodes = document.getElementById('list-codes-saved');

    stopVideo();
    if (arrayCodes.length > 0) {
        ulCodes.innerHTML = '';
        arrayCodes.forEach(function (x, index) {
            let itemCode = document.createElement('li');
            itemCode.classList.add('list-group-item');

            let divRow = document.createElement('div');
            divRow.classList.add('row');

            let divColSerie = document.createElement('div');
            divColSerie.classList.add('col-9', 'text-start');
            divColSerie.textContent = x;

            let divColBtnDelete = document.createElement('div');
            divColBtnDelete.classList.add('col-3', 'text-end');
            let btnDelete = document.createElement('button');
            btnDelete.classList.add('btn', 'btn-danger', 'btn-sm');
            btnDelete.innerHTML = '<i class="bi bi-x-lg"></i>';
            btnDelete.addEventListener('click', function (event) {
                arrayCodes.splice(index, 1);
                itemCode.remove();
                console.log(arrayCodes);
            });
            divColBtnDelete.appendChild(btnDelete);

            divRow.appendChild(divColSerie);
            divRow.appendChild(divColBtnDelete);
            itemCode.appendChild(divRow);
            ulCodes.appendChild(itemCode);
        });
    } else {
        ulCodes.innerHTML = '<h5 class="text-center text-secondary">Sin codigos</h5>';
    }
}

function playBeepSound() {
    const beep = document.getElementById("beepSound");
    beep.play(); // Reproducir el beep
}

function getSerials() {
    return arrayCodes;
}

listDevices();