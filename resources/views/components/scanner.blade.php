<script src="https://unpkg.com/@zxing/library@latest"></script>
<style>
    /* Estilos opcionales para el video y el contenedor */
    #video {
        width: 100%;
        height: auto;
    }
    #resultado {
        margin-top: 20px;
        font-size: 20px;
        font-weight: bold;
    }
</style>
<h4 class="text-danger">No tocar pruebas</h4>
<div class="row pt-2 pb-2">
    <button class="btn btn-warning" data-bs-toggle="modal" id="btn-scan-barcode" data-bs-target="#typeScanModal">
        <i class="bi bi-upc-scan"></i> Escanear
    </button>
    
</div>

<div class="modal fade" id="typeScanModal" tabindex="-1" aria-labelledby="typeScanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <button type="button" onclick="playVideo()" class="btn btn-info w-100 btn-lg" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#scanModal"><i class="bi bi-camera"></i> Camara</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-warning w-100 btn-lg" data-bs-dismiss="modal"><i class="bi bi-upc-scan"></i> Escaner</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="scanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="scanModalLabel">Escanear Código de Barras</h1>
                <button type="button" onclick="stopVideo()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <select id="videoSource" class="form-select" onchange="chooseDevice()">
                                    <option value="">-Dispositivos-</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <video id="video" width="100%" height="auto" autoplay></video>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-12 col-md-6" id="resultado-codes">

                    </div>
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button type="button" onclick="stopVideo()" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="stopVideo()" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
    <script>
        let currentStream = null;
        const codeReader = new ZXing.BrowserBarcodeReader();
        const videoElement = document.getElementById('video');
        const resultadoDiv = document.getElementById('resultado-codes');

        function playVideo(){
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                // Solicitamos acceso a la cámara
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function (stream) {
                        videoElement.srcObject = stream;
                        currentStream = stream;
                        startScanning(); 
                    })
                    .catch(function (err) {
                        alert('No se puede acceder a la cámara.');
                    });
            } else {
                alert('Tu navegador no soporta la cámara web.');
            }
        }

        function stopVideo(){
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());

                videoElement.srcObject = null;

                currentStream = null;
            } else {
                alert('No se ha iniciado la cámara.');
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
                        option.textContent = device.label || `Cámara ${select.length + 1}`;  // Si no tiene label, mostramos algo por defecto
                        select.appendChild(option);
                    });
                })
                .catch(err => console.error('Error al enumerar dispositivos:', err));
        }

        function startScanning() {
            // Usamos ZXing para decodificar los códigos de barras desde el video
            codeReader.decodeFromVideoDevice(null, videoElement, (result, err) => {
                if (result) {
                    resultadoDiv.textContent = `Código escaneado: ${result.text}`;
                    console.log("Código detectado:", result.text);
                    console.log('Formato del código:', result.format);
                }
                if (err && !(err instanceof ZXing.NotFoundException)) {
                    console.error(err);
                }
            });
        }

    // Función para cambiar el dispositivo de cámara
    function chooseDevice() {
        const deviceId = document.getElementById('videoSource').value;

        if (deviceId) {
            // Detener el video actual
            stopVideo();

            // Solicitar acceso a la cámara seleccionada
            navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: deviceId } } })
                .then(stream => {
                    videoElement.srcObject = stream;
                    currentStream = stream;
                })
                .catch(err => {
                    alert('No se puede acceder a la cámara seleccionada.');
                });
        }
    }
    listDevices();
    </script>