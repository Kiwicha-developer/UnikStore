<div class="row">
    <div class="col-md-12">
        @if(!$documentos->isEmpty())
        <ul class="list-group" style="overflow-x: hidden;overflow-y:auto;height: 60vh">
            <li class="list-group-item bg-sistema-uno text-light" style="position: sticky;top:0;z-index:800">
                <div class="row text-center">
                    <div class="col-6 col-md-3 text-start">
                        <small>Proveedor</small>
                    </div>
                    <div class="col-md-2 d-none d-sm-none d-md-block">
                        <small>Documento</small>
                    </div>
                    <div class="col-md-2 text-start d-none d-sm-none d-md-block">
                        <small>Numero</small>
                    </div>
                    <div class="col-3 col-md-1">
                        <small>Registros</small>
                    </div>
                    <div class="col-md-1 d-none d-sm-none d-md-block">
                        <small>Usuario</small>
                    </div>
                    <div class="col-md-1 d-none d-sm-none d-md-block">
                        <small>Estado</small>
                    </div>
                    <div class="col-3 col-md-2">
                        <small class=" d-none d-sm-none d-md-inline">Fecha de creaci&oacuten</small>
                        <small class=" d-inline d-sm-inline d-md-none">Documento</small>
                    </div>
                </div>
            </li>
            @foreach($documentos as $documento)
            <li class="list-group-item">
                <div class="row text-center">
                    <div class="col-8 col-md-3 text-start">
                        <small class="fw-bold">{{$documento->Preveedor->razSocialProveedor}}</small>
                    </div>
                    <div class="col-4 col-md-2">
                        <small>{{$documento->TipoComprobante->descripcion}}</small>
                    </div>
                    <div class="col-6 col-md-2 text-start">
                        <small><a href="{{route('documento',[encrypt($documento->idComprobante),0])}}"
                                class="decoration-link">{{$documento->numeroComprobante}}</a></small>
                    </div>
                    <div class="col-3 col-md-1">
                        <small>{{$documento->DetalleComprobante->count()}}</small>
                    </div>
                    <div class="col-md-1 d-none d-sm-none d-md-block">
                        <small>{{$documento->Usuario->user}}</small>
                    </div>
                    <div class="col-md-1 d-none d-sm-none d-md-block {{$documento->estado == "REGISTRADO"
                        ? 'text-success' : ($documento->estado == "INVALIDO" ? 'text-danger' : 'text-warning')}}">
                        <small>{{$documento->estado}}</small>
                    </div>
                    <div class="col-3 col-md-2">
                        <small>{{$documento->fechaRegistro->format('Y-m-d')}}</small>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <br>
        <x-paginacion :justify="'end'" :coleccion="$documentos" :container="$container"/>
        @else
        <div class="row align-items-center" style="height:80vh">
            <x-aviso_no_encontrado :mensaje="''" />
        </div>
        @endif
    </div>
</div>