<div class="row">
    <div class="col-md-12">
        @if(!$documentos->isEmpty())
        <ul class="list-group" style="overflow-x: hidden;overflow-y:auto;height: 60vh">
            <li class="list-group-item bg-sistema-uno text-light" style="position: sticky;top:0;z-index:800">
                <div class="row text-center">
                    <div class="col-8 col-md-4 col-lg-3 text-start">
                        <small>Proveedor</small>
                    </div>
                    <div class="col-1 col-lg-1">
                        <small>Reg<span class="d-none d-lg-inline">istros</span></small>
                    </div>
                    <div class="col-md-2 col-lg-2 d-none d-md-block">
                        <small>Documento</small>
                    </div>
                    <div class="col-md-3 col-lg-2 text-start d-none d-md-block">
                        <small>Numero</small>
                    </div>
                    <div class="col-lg-1 d-none d-lg-block">
                        <small>Usuario</small>
                    </div>
                    <div class="col-lg-1 d-none d-lg-block">
                        <small>Estado</small>
                    </div>
                    <div class="col-3 col-md-2 text-end text-md-center">
                        <small class=" d-none d-md-inline">Creaci&oacuten</small>
                        <small class=" d-inline d-md-none">Documento</small>
                    </div>
                </div>
            </li>
            @foreach($documentos as $documento)
            <li class="list-group-item">
                <div class="row text-center">
                    <div class="col-8 col-md-4 col-lg-3 text-start">
                        <small class="fw-bold">{{$documento->Preveedor->razSocialProveedor}}</small>
                    </div>
                    <div class="col-1 col-lg-1">
                        <small>{{$documento->DetalleComprobante->count()}}</small>
                    </div>
                    <div class="col-3 col-md-2 text-md-center text-end col-lg-2">
                        <small>{{$documento->TipoComprobante->descripcion}}</small>
                    </div>
                    <div class="col-9 col-md-3 col-lg-2 text-start">
                        <small><a href="{{route('documento',[encrypt($documento->idComprobante),0])}}"
                                class="decoration-link">{{$documento->numeroComprobante}}</a></small>
                    </div>
                    <div class="col-lg-1 d-none d-lg-block">
                        <small>{{$documento->Usuario->user}}</small>
                    </div>
                    <div class="col-lg-1 d-none d-lg-block {{$documento->estado == "REGISTRADO"
                        ? 'text-success' : ($documento->estado == "INVALIDO" ? 'text-danger' : 'text-warning')}}">
                        <small>{{$documento->estado}}</small>
                    </div>
                    <div class="col-3 col-md-2 text-lg-center text-end col-lg-2">
                        <small>{{$documento->fechaRegistro->format('Y-m-d')}}</small>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <br>
        @else
        <div class="row align-items-center" style="height:80vh">
            <x-aviso_no_encontrado :mensaje="''" />
        </div>
        @endif
        <x-paginacion :justify="'end'" :coleccion="$documentos" :container="$container"/>
    </div>
</div>