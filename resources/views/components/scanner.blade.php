<script src="https://unpkg.com/@zxing/library@latest"></script>
<style>
    /* Estilos opcionales para el video y el contenedor */
    #video {
        width: 100%;
        height: auto;
        object-fit: cover; /* El video cubre el área sin deformarse */
        object-position: center;
        clip-path: inset(5% 0% 5% 0%);
    }

    @media (max-width: 576px) {
        #video {
            width: 100%;
            clip-path: inset(15% 0% 15% 0%);
            position: absolute; 
            top: 50%;
            left:50%;
            transform: translate(-50%, -50%);
        }

        #video-container{
            height:200px;
            overflow: hidden;
            position: relative;
        }
    }


    #resultado {
        margin-top: 20px;
        font-size: 20px;
        font-weight: bold;
    }

    #scannerLine {
        position: absolute;
        top: 0; /* Centramos la línea en el medio */
        width: 100%;
        height: 2px;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 3;
        animation: scanLine 2s infinite; /* Animación de movimiento */
    }

    @keyframes scanLine {
        0% {
            top: 0%;
        }
        50% {
            top: 50%; /* Moverse hacia abajo */
        }
        100% {
            top: 100%;
        }
    }

    #scannerFrame{
        background: rgba(0, 0, 0, 0.3);
        border: 2px dashed rgba(255, 255, 255, 0.7);
        position: absolute;
        top:45%;
        left:50%;
        transform: translate(-50%, -50%);
        height: 100px;
        width: 80%;
    }
    
    #torch-btn{
        display: none;
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
                    <div class="col-md-6 mb-2">
                        <button type="button" onclick="playVideo()" class="btn btn-info w-100 btn-lg"
                            data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#scanModal"><i
                                class="bi bi-camera"></i> Camara</button>
                    </div>
                    <div class="col-md-6 ">
                        <button type="button" class="btn btn-warning w-100 btn-lg" data-bs-dismiss="modal"><i
                                class="bi bi-upc-scan"></i> Escaner</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="scanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="scanModalLabel">Escanear Código de Barras</h1>
                <button type="button" onclick="stopVideo()" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12" style="position: relative">
                                <div id="video-container">
                                    <video id="video" width="100%" height="auto" autoplay>
                                    </video>
                                </div>
                                
                                <div id="scannerFrame">
                                    <div id="scannerLine"></div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row pt-md-3">
                            <div class="col-12 mb-2">
                                <select id="videoSource" class="form-select" onchange="chooseDevice()">
                                    <option value="">-Dispositivos-</option>
                                </select>
                            </div>
                            <div class="col-12 pt-2 border rounded-3 bg-sistema-uno text-white text-center">
                                    <h6 class="text-white-50">C&oacute;digo</h6>
                                    <h5 id="resultado-codes">No hay codigo</h5>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                

            </div>
            <div class="modal-footer ps-0 pe-0">
                <div class="row w-100">
                    <div class="col-4">
                        <button class="btn btn-dark rounded-circle border" onclick="changeButton(this)" id="torch-btn">
                            <i class="bi bi-lightbulb-fill"></i>
                        </button>
                    </div>
                    <div class="col-8 text-end">
                        <button type="button" onclick="stopVideo()" class="btn btn-secondary"
                        data-bs-dismiss="modal">Guardar</button>
                        <button type="button" onclick="stopVideo()" class="btn btn-primary" data-bs-dismiss="modal">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<audio id="beepSound" src="{{asset('sounds/beep.mp3')}}" preload="auto"></audio>
<script>
    let toggleTorch = true;
    let currentStream = null;
    let currentTrack = null;
    let arrayCodes = [];
    const codeReader = new ZXing.BrowserMultiFormatReader();
    const videoElement = document.getElementById('video');
    const resultadoDiv = document.getElementById('resultado-codes');

    function playVideo() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            // Solicitamos acceso a la cámara
            navigator.mediaDevices.getUserMedia({
                    video: {facingMode: "environment" }
        
                })
                .then(function(stream) {
                    videoElement.srcObject = stream;
                    currentStream = stream;
                    currentTrack = stream.getVideoTracks()[0];
                    const capabilities = currentTrack.getCapabilities();

                    if (capabilities.torch) {
                        // Si la cámara tiene soporte para linterna, la activamos
                        document.getElementById('torch-btn').style.display = "block";
                    }else{
                        document.getElementById('torch-btn').style.display = "none";
                    }
                    startScanning(); 
                })
                .catch(function(err) {
                    console.error("Error con la cámara delantera: ", err);
                    // Si falla con la delantera, intentar con la trasera
                    navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(stream) {
                        videoElement.srcObject = stream;
                        currentStream = stream;
                        startScanning(); // Iniciar escaneo con ZXing
                    })
                    .catch(function(err) {
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
            console.log(currentStream);
            videoElement.srcObject = null;

            currentStream = null;
        } else {
            alert('No se ha iniciado la cámara.');
        }
    }

    function activateTorch(bool){
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

    function changeButton(input){
        if(toggleTorch){
            input.classList.add('btn-light');
            input.classList.remove('btn-dark');
            activateTorch(true);
            toggleTorch = false;
        }else{
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
                resultadoDiv.textContent = `Código escaneado: ${result.text}`;
                playBeepSound();
                arrayCodes.push(result.text);
                console.log("Código detectado:", result.text);
                console.log('Formato del código:', result.format);
            }
            if (err && !(err instanceof ZXing.NotFoundException)) {
                console.error(err);
            }
        });
        
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
                    }else{
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
</script>
