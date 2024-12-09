<script src="https://unpkg.com/@zxing/library@latest"></script>
<link rel="stylesheet" href="{{asset('css/scanner.css')}}">
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
                    <div class="col-3">
                        <button class="btn btn-dark rounded-circle border" onclick="changeButton(this)" id="torch-btn">
                            <i class="bi bi-lightbulb-fill"></i>
                        </button>
                    </div>
                    <div class="col-9 text-end">
                        <button type="button"  data-bs-toggle="modal" data-bs-target="#codesScanModal" class="btn btn-info" id="btn-modal-camera-uno"
                        data-bs-dismiss="modal"><i class="bi bi-floppy"></i> Guardar</button>
                        <button type="button" class="btn btn-success" id="btn-modal-camera-dos"><i class="bi bi-plus-square" ></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/camera.js')}}"></script>