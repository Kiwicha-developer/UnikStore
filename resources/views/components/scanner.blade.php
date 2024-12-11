
<div class="modal fade" id="typeScanModal" tabindex="-1" aria-labelledby="typeScanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 mb-2">
                        <button class="btn btn-info w-100 text-center" style="aspect-ratio: 1" onclick="playVideo()" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#camaraModal">
                            <i class="bi bi-camera" style="font-size: 5rem"></i> 
                            <p>C&aacute;mara</p>
                        </button>
                    </div>
                    <div class="col-6 mb-2">
                        <button class="btn btn-success w-100 text-center" style="aspect-ratio: 1" {!!$multiple == true ? 'onclick="clearListScan()" data-bs-target="#escanerModal"' : ''!!}  data-bs-dismiss="modal" data-bs-toggle="modal" >
                            <i class="bi bi-upc-scan" style="font-size: 5rem"></i> 
                            <p>Escaner</p>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="codesScanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="codesScanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
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
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-list-scan-codes"><i class="bi bi-check-lg"></i> Proceder</button>
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
                <div class="row pt-2" id="scan-row-response">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" onclick="listCodesModal()" data-bs-toggle="modal" data-bs-target="#codesScanModal" class="btn btn-success"
                data-bs-dismiss="modal"><i class="bi bi-floppy-fill"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<x-camera_modal />
@if($multiple == true)
    <script src="{{asset('js/scanner.js')}}"></script>
@else

@endif

