<script src="https://unpkg.com/@zxing/library@latest"></script>
<link rel="stylesheet" href="{{asset('css/scanner.css')}}">
<button class="btn btn-warning" id="btn-scan-barcode" data-bs-toggle="modal" data-bs-target="#typeScanModal">
    <i class="bi bi-qr-code"></i> <span class="d-none d-md-inline">Escanear</span>
</button>
<div class="modal fade" id="typeScanModal" tabindex="-1" aria-labelledby="typeScanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-2">
                        <button class="btn btn-info w-100" onclick="playVideo()" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#camaraModal"><i class="bi bi-camera"></i> C&aacute;mara</button>
                    </div>
                    <div class="col-12 col-md-6 mb-2">
                        <button class="btn btn-success w-100" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#escanerModal"><i class="bi bi-upc-scan"></i> Escaner</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="camaraModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="camaraModalLabel " aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="camaraModalLabel">Escanear Código de Barras</h1>
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
                                    <h5 id="resultado-codes-camera">No hay codigo</h5>
                                    <input type="hidden" name="" id="hidden-resultado-codes-camera">
                            </div>
                            <div class="col-12">
                                <h6 class="text-danger" id="error-codes"></h6>
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
                        <button type="button" onclick="listCodesModal()" data-bs-toggle="modal" data-bs-target="#codesScanModal" class="btn btn-info"
                        data-bs-dismiss="modal"><i class="bi bi-floppy"></i> Guardar</button>
                        <button type="button" onclick="addModalCodesCamera()" class="btn btn-success"><i class="bi bi-plus-square"></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="codesScanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="codesScanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="scanModalLabel">C&oacute;digos escaneados</h1>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <ul class="list-group" id="list-codes-saved">
                            <h5 class="text-center text-secondary">Sin codigos</h5>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-general-codes"> Guardar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="escanerModal" tabindex="-1" aria-labelledby="escanerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="escanerModalLabel">Escanear Código de Barras</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
            </div>
            <div class="modal-body" style="height: 70vh">
                <div class="row">
                    <div class="col-8 text-start text-secondary">
                        <small>Series</small>
                    </div>
                    <div class="col-4 text-end text-secondary">
                        <small>Español</small>
                    </div>
                    <div class="col-12 pb-0">
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="barcode-input" placeholder="Escanea un código de barras" autofocus>
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" id="check-lenguaje-scan" type="checkbox" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 pt-0 text-start text-danger">
                        <small id="duplicity-code"></small>
                    </div>
                </div>
                <div class="row">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" onclick="listCodesModal()" data-bs-toggle="modal" data-bs-target="#codesScanModal" class="btn btn-success"
                data-bs-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>
<audio id="beepSound" src="{{asset('sounds/beep.mp3')}}" preload="auto"></audio>
<script src="{{asset('js/scanner.js')}}"></script>
