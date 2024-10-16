<div class="lista_producto">
    <div class="text-end" style="position:fixed;top:0;width:200px;z-index:1000">
            <div class="alert alert-info alert-dismissible fade show" role="alert" id="myAlert" style="display: none;">
              ¡Texto copiado!
            </div>
        </div>
    <div class="row">
        <div class="col-6 col-md-3">
            <select onchange="viewProductsList(this.value)" class="form-select form-select-sm" id="select-state-product">
              <option value="TODOS" selected>Todos</option>
              <option value="DISPONIBLE">DISPONIBLE(S)</option>
              <option value="AGOTADO">AGOTADO(S)</option>
              <option value="EXCLUSIVO">EXCLUSIVO(S)</option>
              <option value="OFERTA">OFERTA(S)</option>
              <option value="DESCONTINUADO">DESCONTINUADO(S)</option>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
                <ul class="list-group ">
                        <li class="list-group-item d-flex bg-sistema-uno text-light" style="position:sticky; top: 0;z-index:800">
                            <div class="row w-100 h-100 d-flex justify-content-center align-items-center" >
                                <div class="col-6 col-md-4 text-center">
                                    <h6>Producto</h6>
                                </div>
                                <div class="col-md-1 d-none d-sm-block text-center">
                                    <h6>Modelo</h6>
                                </div>
                                <div class="col-1 d-none d-sm-block text-center">
                                    <h6>UPC</h6>
                                </div>
                                <div class="col-1 d-none d-sm-block text-center">
                                    <h6>Garantía</h6>
                                </div>
                                <div class="col-2 col-md-1 text-center">
                                    <h6>Marca</h6>
                                </div>
                                <div class="col-4 col-md-1 text-center">
                                    <h6><a style="cursor:pointer" onclick="changePriceList()">Precio <i class="bi bi-caret-down-fill"></i></a></h6>
                                </div>
                                <div class="col-2 d-none d-sm-block text-center">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Stock</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Proveedor</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none d-sm-block col-md-1 truncate">
                                    <h6>Descripción</h6>
                                </div>
                            </div>
                        </li>
                    @foreach($productos as $pro)
                        <li class="list-group-item justify-content-between align-items-center li-item-product-{{$pro->estadoProductoWeb}} li-item-product-all">
                            <div class="row w-100 ">
                                <div class="col-2 col-md-1 text-center" style="position:relative;cursor:pointer">
                                    <img onmouseover="mostrarImg({{ $pro->idProducto }})" onmouseout="ocultarImg({{ $pro->idProducto }})" src="{{ asset('storage/'.$pro->imagenProducto1) }}" alt="Tooltip Imagen" style="width:100%" class="rounded-3">
                                    <div class="border border-secondary rounded-3 justify-content-top" style="width: 200px;position: absolute;z-index: 900;top:0;left:100%;display:none" id="img-{{$pro->idProducto}}">
                                        <img src="{{ asset('storage/'.$pro->imagenProducto1) }}" alt="Tooltip Imagen" style="width:100%" class="rounded-3">
                                    </div>
                                </div>
                                <div class="col-10 col-md-3"  data-bs-toggle="tooltip" data-bs-placement="top" title="Cod: {{$pro->codigoProducto}}">
                                    <a class="link-sistema fw-bold"  href="{{route('producto',[encrypt($pro->idProducto)])}}">
                                        <small>{{$pro->nombreProducto}}</small>
                                    </a>
                                    
                                </div>
                                <div class="col-6 col-md-1 text-center" >
                                    <small  style="cursor:pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="SN: {{ $pro->partNumber == 0 ? 'Sin Part Number' : $pro->partNumber}}">
                                        {{$pro->modelo}}
                                    </small>
                                </div>
                                <div class="col-6 col-md-1 d-none d-sm-block text-center">
                                    <small>{{$pro->UPC == 0 ? 'Sin UPC' : $pro->UPC}}</small>
                                </div>
                                <div class="col-3 col-md-1 d-none d-sm-block text-center">
                                    <small>{{$pro->garantia}}</small>
                                </div>
                                <div class="col-3 col-md-1 text-center">
                                    <small>{{$pro->MarcaProducto->nombreMarca}}</small>
                                </div>
                                <div class="col-2 col-md-1 text-center">
                                    <small data-value="{{$pro->precioDolar}}" class="price-list-product">${{$pro->precioDolar}}</small>
                                </div>
                                <div class="col-6 d-none d-sm-block col-md-2">
                                    <div class="row text-center">
                                        <div class="col-6">
                                             @php
                                                $hayStock = false;
                                            @endphp
                                        
                                            @foreach($pro->Inventario as $inventario)
                                                @if($inventario->stock > 0)
                                                    <small>{{ $inventario->Almacen->descripcion }}</small>
                                                    <br>
                                                    <small>{{ $inventario->stock }}</small>
                                                    @php
                                                        $hayStock = true;
                                                        break; // Termina el bucle cuando se encuentra inventario con stock
                                                    @endphp
                                                @endif
                                            @endforeach
                                        
                                            @if(!$hayStock)
                                                <small>Sin stock</small>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <small>{{$pro->Inventario_Proveedor->Preveedor->nombreProveedor}}</small>
                                            <br>
                                            <small>{{$pro->Inventario_Proveedor->stock}}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 col-md-1 text-end">
                                    <textarea style="position: absolute; left: -9999px;opacity: 0" id="descripcion-{{$pro->idProducto}}">{{$pro->descripcionProducto}}</textarea>
                                    <button class="btn text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Click para copiar la descripción" onclick="copiarTexto({{$pro->idProducto}})">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
    </div>
    <script src="{{ route('js.list-product-scripts',[$tc]) }}"></script>
    <script>
        
    </script>
</div>