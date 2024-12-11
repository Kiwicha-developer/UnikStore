let toggleTorch = true;
let currentStream = null;
let currentTrack = null;
const codeReader = new ZXing.BrowserMultiFormatReader();
const videoElement = document.getElementById('video');
const textResultadosCamera = document.getElementById('resultado-codes-camera');
const hiddenResultadosCamera = document.getElementById('hidden-resultado-codes-camera');
const messageError = document.getElementById('error-codes');

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

function playBeepSound() {
    const beep = document.getElementById("beepSound");
    beep.play(); // Reproducir el beep
}

listDevices();