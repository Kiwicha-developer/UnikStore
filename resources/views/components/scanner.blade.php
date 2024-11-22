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
<div class="row pt-2 pb-2">
    <button class="btn btn-warning" data-bs-toggle="modal" id="btn-scan-barcode" data-bs-target="#scanModal">
        <i class="bi bi-upc-scan"></i> Escanear
    </button>
    
</div>
<div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="scanModalLabel">Escanear Código de Barras</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <video id="video" width="100%" height="auto" autoplay></video>
                    </div>
                    <div class="col-12 col-md-6" id="resultado-codes">

                    </div>
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button type="button" onclick="stopVideo()" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="stopVideo()" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    let currentStream = null;

    document.getElementById('btn-scan-barcode').addEventListener('click', function (event) {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            const codeReader = new ZXing.BrowserBarcodeReader();
            const videoElement = document.getElementById('video');
            const resultadoDiv = document.getElementById('resultado');

            // Iniciar la cámara y guardar el stream
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    videoElement.srcObject = stream;
                    currentStream = stream; // Guardamos el stream para poder detenerlo más tarde

                    // Iniciar el escaneo de códigos de barras
                    codeReader.decodeFromVideoDevice(null, videoElement, (result, err) => {
                        if (result) {
                            resultadoDiv.textContent = `Código escaneado: ${result.text}`;
                        }
                        if (err && !(err instanceof ZXing.NotFoundException)) {
                            console.error(err);
                        }
                    });
                })
                .catch(function (err) {
                    alert('Error al acceder a la cámara: ' + err);
                });
        } else {
            alert('Tu navegador no soporta acceso a la cámara');
        }
    });

    function stopVideo(){
        console.log(currentStream);
        
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop()); 
            const videoElement = document.getElementById('video');
            videoElement.srcObject = null; // Desasociar el stream

            // Limpiar el stream actual
            currentStream = null;
        }
    }
    
</script>