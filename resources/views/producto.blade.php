@extends('layouts.app')

@section('title', 'Producto | '.$producto->codigoProducto)

@section('og_title', 'Título de Ejemplo para Open Graph')
@section('og_description', 'Descripción de ejemplo que aparece en la vista previa.')
@section('og_image', 'https://www.tusitio.com/imagenes/ejemplo.jpg')
@section('og_url', url()->current()) <!-- La URL actual de la página -->
@section('og_type', 'article')

@section('content')
<div class="container">
    <br>
    <form action="{{route('updateproduct',[encrypt($producto->idProducto)])}}" method="POST" enctype="multipart/form-data">
        @csrf
    <div class="row">
        <div class="col-10 col-md-6 d-flex align-items-center">
            <h3><a href="javascript:void(0);" onclick="history.back();" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> PRODUCTO: <span class="text-secondary">{{$producto->codigoProducto}}</span></h3>
        </div>
        <div class="col-2 col-md-6 text-end pt-2">
            <h5><a class="btn btn-secondary" href="{{route('details',[$producto->idProducto])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Especificaciones"><i class="bi bi-layers"></i></a></h5>
        </div>
    </div>
    <br>
    <div class="editButton row border shadow rounded-3 pt-3 pb-3 mb-3">
        <div class="row">
            <div class="col-6">
                <h3>Datos generales</h3>
            </div>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-info text-light btn-edit">Editar <i class="bi bi-pencil"></i></button>
            </div>
        </div>
        <div class="mb-3 col-12 col-md-6">
            <label class="form-label">Titulo</label>
            <input type="text" name="titulo" class="form-control input-edit" value="{{$producto->nombreProducto}}" aria-describedby="basic-addon1" maxlength="200" disabled>
        </div>
        <div class="mb-3 col-6 col-md-3">
        <label for="marca-product" class="form-label">Marca:</label>
            <select name="marca" id="marca-product" class="form-select input-edit" disabled>
                @foreach($marcas as $marca)
                    <option value="{{ $marca['idMarca'] }}"
                        {{$producto->idMarca == $marca['idMarca'] ? 'selected' : ''}}>
                        {{ $marca['nombreMarca'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 col-6 col-md-3">
            <label for="grupo-product" class="form-label">Grupo:</label>
            <select name="grupo" id="grupo-product" class="form-select " disabled>
                @foreach($grupos as $grupo)
                    <option value="{{ $grupo['idGrupoProducto'] }}"
                        {{ $producto->idGrupo == $grupo['idGrupoProducto'] ? 'selected' : '' }}>
                        {{ $grupo['nombreGrupo'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 col-6 col-md-2">
            <label for="estado-product" class="form-label">Estado:</label>
            <select name="estado" id="estado-product" class="form-select input-edit" disabled>
              <option value="DISPONIBLE" {{ $producto->estadoProductoWeb == 'DISPONIBLE' ? 'selected' : '' }}>DISPONIBLE</option>
              <option value="AGOTADO" {{ $producto->estadoProductoWeb == 'AGOTADO' ? 'selected' : '' }}>AGOTADO</option>
              <option value="OFERTA" {{ $producto->estadoProductoWeb == 'OFERTA' ? 'selected' : '' }}>OFERTA</option>
              <option value="EXCLUSIVO" {{ $producto->estadoProductoWeb == 'EXCLUSIVO' ? 'selected' : '' }}>EXCLUSIVO</option>
              <option value="DESCONTINUADO" {{ $producto->estadoProductoWeb == 'DESCONTINUADO' ? 'selected' : '' }}>DESCONTINUADO</option>
            </select>
        </div>
        <div class="mb-3 col-6 col-md-2">
            <label for="garantia-product" class="form-label">Garantia:</label>
            <select name="garantia" id="garantia-product" class="form-select input-edit" disabled>
              <option value="No tiene" {{$producto->garantia == 'No tiene' ? 'selected' : ''}}>No tiene</option>
              <option value="3 meses" {{$producto->garantia == '3 meses' ? 'selected' : ''}}>3 meses</option>
              <option value="6 meses" {{$producto->garantia == '6 meses' ? 'selected' : ''}}>6 meses</option>
              <option value="12 meses" {{$producto->garantia == '12 meses' ? 'selected' : ''}}>12 meses</option>
              <option value="24 meses" {{$producto->garantia == '24 meses' ? 'selected' : ''}}>24 meses</option>
              <option value="36 meses" {{$producto->garantia == '36 meses' ? 'selected' : ''}}>36 meses</option>
            </select>
        </div>
    </div>
    <div class="editButton row border shadow rounded-3 pt-3 pb-3 mb-3 mt-3">
        <div class="row">
            <div class="col-6 col-md-4">
                <h3>Precios:</h3>
            </div>
            <div class="col-6 col-md-8 text-end">
                <button type="button" class="btn btn-info text-light btn-edit">Editar <i class="bi bi-pencil"></i></button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6 col-md-6">
                <div class="row">
                    <h5>Precio producto</h5>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="select-tipoprecio" class="form-label">Moneda:</label>
                        <select class="form-select" onchange="changeTC()" name="tipoprecio" id="select-tipoprecio">
                            <option value="DOLAR" selected>Dolares</option>
                            <option value="SOL">Soles</option>
                          </select>
                    </div>
                    <div class="col-md-8"></div>
                    <div class="mb-3 col-md-6">
                        <label for="precio-producto" class="form-label">Sin IGV:</label>
                         <input type="number" name="precio" value="{{number_format($producto->precioDolar, 2, '.', '')}}"id="precio-product"  aria-label="Last name" class="form-control input-edit price-product" step="0.01" disabled>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="mb-3 col-md-6">
                        <label for="precio-producto" class="form-label">Con IGV:</label>
                         <input type="number"  value="{{number_format($producto->precioDolar * $igv, 2, '.', '')}}" id="precio-product-igv"   class="form-control input-edit price-product" step="0.01" disabled>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="row">
                    <h5>Precio venta</h5>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="precio-producto" class="form-label">Utilidad:</label>
                         <input type="number"  value="{{number_format($producto->gananciaExtra, 2, '.', '')}}" name="ganancia" id="precio-product-ganancia"  class="form-control input-edit price-product" step="0.01" disabled>
                    </div>
                    <div class="col-md-8"></div>
                    <div class="mb-3 col-md-4">
                        <label for="precio-producto" class="form-label">Precio Calculado:</label>
                         <input type="number"  value="" id="precio-product-calculado" class="form-control price-product" step="0.01" disabled>
                    </div>
                    <div class="col-md-8"></div>
                        <div class="row" id="div-total-price">
                        </div>
                    <div class="col-md-8"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="editButton row border shadow rounded-3 pt-3 pb-3 mb-3 mt-3">
        <div class="row">
            <div class="col-6">
                <h3>Datos clave</h3>
            </div>
            <div class="col-6 text-end">
                @foreach ($user->Accesos as $access)
                    @if($access->idVista  == 7)
                        <button type="button" class="btn btn-info text-light btn-edit">Editar <i class="bi bi-pencil"></i></button>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label">UPC/EAN</label>
            <input type="text" name="upc" class="form-control input-edit" value="{{$producto->UPC}}" aria-describedby="basic-addon1" maxlength="13" disabled>
            <small id="upcError" class="text-danger"></small>
        </div>
        <div class="col-md-3">
            <label class="form-label">Modelo</label>
            <input type="text" name="modelo" class="form-control input-edit" value="{{$producto->modelo}}" aria-describedby="basic-addon1" maxlength="70" disabled>
        </div>
        <div class="col-md-2">
            <label class="form-label">Part Number</label>
            <input type="text" name="partnumber" class="form-control input-edit" value="{{$producto->partNumber}}" aria-describedby="basic-addon1" maxlength="50" disabled>
        </div>
    </div>
    <div class="editButton row border shadow rounded-3 pt-3 pb-3 mb-3 mt-3">
        <div class="row">
            <div class="col-6">
                <h3>Inventario disponible</h3>
            </div>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-info text-light btn-edit">Editar <i class="bi bi-pencil"></i></button>
                @php
                    $ingresoEdit = "";
                @endphp
                @foreach ($user->Accesos as $access)
                    @if($access->idVista  == 8)
                    @php
                        $ingresoEdit = "input-edit";
                    @endphp
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-6 col-md-2">
            <label  class="form-label">Stock Minimo:</label>
            <input name="stockminimo" value="{{$producto->stockMin}}" type="number" class="form-control input-edit" disabled>
        </div>
        @foreach($producto->Inventario as $inventario)
        <div class="col-6 col-md-2">
            <label class="form-label">Stock {{$inventario->Almacen->descripcion}}:</label>
            <input name="stock[{{$inventario->idAlmacen}}]" value="{{$inventario->stock}}" type="number" class="form-control {{$ingresoEdit}}"  disabled>
        </div>
        @endforeach
        <div class="col-6 col-md-2">
            <label class="form-label">Stock {{$producto->Inventario_Proveedor->Preveedor->nombreProveedor}}:</label>
            <input name="stockproveedor" value="{{$producto->Inventario_Proveedor->stock}}" type="number" class="form-control input-edit" disabled>
        </div>
        <div class="col-6 col-md-3">
            <label for="grupo-product" id="proveedor-label" class="form-label">Proveedor:</label>
            <select name="proveedor" id="proveedor-product" class="form-select input-edit" disabled>
                @foreach($proveedor as $pro)
                    <option  value="{{ $pro['idProveedor'] }}"
                        {{ $producto->Inventario_Proveedor->Preveedor->idProveedor == $pro['idProveedor'] ? 'selected' : '' }}>
                        {{ $pro['nombreProveedor'] }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="editButton row border shadow rounded-3 pt-3 pb-3 mb-3 mt-3">
        <div class="row">
            <div class="col-6">
                <h3>Detalles</h3>
            </div>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-info text-light btn-edit">Editar <i class="bi bi-pencil"></i></button>
            </div>
        </div>
        <div class="col-md-6">
            <h5>Imagenes</h5>
            <label for="desc-producto" class="form-label" ><i class="bi bi-exclamation-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="Las imagenes tardan en actualizar"></i> Solo imagenes en formato 1000 x 1000px</label>
            <div class="row">
                <div class="col-6 mb-3 img-div" id="previewImage1" data-bs-toggle="tooltip" data-bs-placement="top" title="Imagen de cabecera">
                    <input class="d-none input-edit img-input" name="imgone" type="file" accept="image/*" id="imgone-product" onchange="changeImage(event,this,'previewImage1','triggerImage1')" disabled>
                    <img src="{{$producto->publicImages()[0]}}" alt="Click to upload" id="triggerImage1" class="w-100 border border-secondary rounded-3 img-preview" style="cursor: pointer; object-fit: cover;">
                </div>
                <div class="col-6 mb-3 img-div" id="previewImage2">
                    <input class="d-none input-edit img-input" name="imgtwo"  type="file" accept="image/*" id="imgtwo-product" onchange="changeImage(event,this,'previewImage2','triggerImage2')" disabled>
                    <img src="{{$producto->publicImages()[1]}}" alt="Click to upload" id="triggerImage2" class="w-100 border border-secondary rounded-3 img-preview" style="cursor: pointer; object-fit: cover;">
                </div>
                <div class="col-6 img-div" id="previewImage3">
                     <input class="d-none input-edit img-input" name="imgtree" type="file" accept="image/*" id="imgtree-product" onchange="changeImage(event,this,'previewImage3','triggerImage3')" disabled>
                    <img src="{{$producto->publicImages()[2]}}" alt="Click to upload" id="triggerImage3" class="w-100 border border-secondary rounded-3 img-preview" style="cursor: pointer; object-fit: cover;">
                </div>
                <div class="col-6 img-div" id="previewImage4">
                    <input class="d-none input-edit img-input" name="imgfour" type="file" accept="image/*" id="imgfour-product" onchange="changeImage(event,this,'previewImage4','triggerImage4')" disabled>
                    <img src="{{$producto->publicImages()[3]}}" alt="Click to upload" id="triggerImage4" class="w-100 border border-secondary rounded-3 img-preview" style="cursor: pointer; object-fit: cover;">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="desc-producto" class="form-label" >Descripción:</label>
            <textarea name="descripcion" type="text" maxlength="5000" id="desc-producto" class="form-control input-edit" style=" width: 100%;max-height: 660px;overflow-y: auto;" oninput="autoResize(this)" disabled>{{ $producto->descripcionProducto }}</textarea>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-12">
            <button type="submit" class="btn btn-success" id="btnSave" disabled>Guardar <i class="bi bi-floppy"></i></button>
        </div>
    </div>
    </form>
    <br>
    <br>
</div>
<script src="{{ route('js.update-product-scripts',[$tc]) }}"></script>
@endsection