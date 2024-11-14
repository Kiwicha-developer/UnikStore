@extends('layouts.app')

@section('title', 'Documento | '.$documento->Preveedor->nombreProveedor)

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-6">
            <h2><a href="{{route('documentos',[now()->format('Y-m')])}}" class="text-secondary"><i class="bi bi-filter-circle"></i></a> {{$documento->Preveedor->razSocialProveedor}}</h2>
        </div>
        <div class="col-6 col-md-6 ">
            <h2 class="text-end d-none d-sm-none d-md-block">{{$documento->numeroComprobante}}</h2>
            <h2 class="d-block d-sm-none">{{$documento->numeroComprobante}}</h2>
        </div>
        <div class="col-md-6 d-none d-md-block">
            <h4 class="text-secondary">RUC: {{$documento->Preveedor->rucProveedor}}</h4>
        </div>
        <div class="col-6 col-md-6 text-end">
            <h4 class="text-secondary">{{$documento->TipoComprobante->descripcion}}</h4>
        </div>
    </div>
    <br>
    <form action="{{route('insertingreso',[encrypt($documento->idComprobante)])}}" id="form-create-doc" method="POST">
        @csrf
    <div class="row">
        <div class="col-md-12 mb-3">
            @if($validate)
            <div class="row mb-2">
                <div class="col-6 col-md-2">
                    <label class="form-label">Moneda:</label>
                    <select class="form-select" name="comprobante[moneda]">
                        <option value="SOL">Soles</option>
                        <option value="DOLAR">Dolares</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                  <label class="form-label" style="color:red" id="select-label-adquisicion">Adquisici&oacuten</label>
                  <select class="form-select" onchange="changeLabel(this,'select-label-adquisicion')" id="select-adquisicion" name="comprobante[adquisicion]">
                      <option class="text-danger" value="" selected>-Elige una adquisici&oacuten-</option>
                      @foreach($adquisiciones as $ad)
                      <option value="{{$ad['value']}}">{{$ad['name']}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label" style="color:red" id="select-label-almacen">Almac&eacuten</label>
                    <select class="form-select" onchange="changeLabel(this,'select-label-almacen')" id="select-almacen" name="comprobante[almacen]">
                        <option class="text-danger" value="">-Elige una ubicaci&oacuten-</option>
                        @foreach($ubicaciones as $ubi)
                        <option value="{{$ubi->idAlmacen}}">{{$ubi->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-none d-md-block">
                </div>
                <div class="col-6 col-md-2 text-end">
                    <label class="form-label">Importe Total:</label>
                    <input type="number" id="importe-total-comprobante" name="comprobante[total]" step="0.01" class="form-control" value="0.00" readonly>
                </div>
            </div>
            @else
                @if(count($pdf) > 0)
                    <div class="col-md-12 mb-4">
                        <button type="button" class="btn btn-danger" onclick="openPdfInNewWindow()"><i class="bi bi-file-earmark-pdf"></i> Series</button>
                    </div>
                @endif
            @endif
            <ul class="list-group" id="ul-ingreso" style="max-height: 60vh;overflow-x: hidden; overflow-y: auto;">
              @if($validate)
              <li class="list-group-item bg-sistema-uno text-light text-center fw-normal fs-5" style="position:sticky;top:0;z-index:1000">
                <div class="row text-center">
                    <div class="col-1 col-md-1">
                        <small class="d-none d-md-inline">Cant.</small>
                        <small class="d-md-none">#</small>
                    </div>
                    <div class="col-4 col-md-3 text-start">
                        <small>Producto</small>
                    </div>
                    <div class="col-2 d-none d-md-block">
                        <small>U.M.</small>
                    </div>
                    <div class="col-2 col-md-2">
                        <small class="d-none d-md-inline">Precio Unitario</small>
                        <small class="d-md-none">P.U</small>
                    </div>
                    <div class="col-2 col-md-2">
                        <small class="d-none d-md-inline">Precio Total</small>
                        <small class="d-md-none">P.T</small>
                    </div>
                    <div class="col-3 col-md-2 text-end">
                        <button type="button" class="btn h-100 pt-0 pb-0 hidden-button text-light border hover-sistema-uno" data-bs-toggle="modal" data-bs-target="#registerModal"><i class="bi bi-cart-plus-fill fs-4"></i></button>
                    </div>
                </div>
              </li>
              <li class="list-group-item pt-0 pb-0 ps-0 pe-0" id="li-btn-add">
                  <div class="row w-100 h-100 ms-0 me-0">
                    
                </div>
              </li>
              @else
              <li class="list-group-item bg-sistema-uno text-light text-center fw-normal fs-6" style="position:sticky;top:0;z-index:1000">
                <div class="row w-100">
                    <div class="col-5 col-md-6 text-start">
                        <small>Producto</small>
                    </div>
                    <div class="col-md-1 d-none d-sm-none d-md-block">
                        <small>Cantidad</small>
                    </div>
                    <div class="col-md-2 d-none d-sm-none d-md-block">
                        <small>UM</small>
                    </div>
                    <div class="col-3 col-md-1">
                        <small>Precio</small>
                    </div>
                    <div class="col-4 col-md-2">
                        <small>Costo Total</small>
                    </div>
                </div>
              </li>
              <li class="list-group-item list-group-item-secondary pt-0 pb-0 ps-0 pe-0">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                @php $cont = 1; @endphp
                @foreach($documento->DetalleComprobante as $detalle)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-heading-{{$cont}}">
                      <button class="accordion-button collapsed border-bottom list-group-item-secondary ps-3 pe-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$cont}}" aria-expanded="false" aria-controls="flush-collapse-{{$cont}}">
                        <div class="row text-center w-100">
                            <div class="col-12 col-md-6 text-start fw-bold mb-2">
                                {{$detalle->Producto->nombreProducto}}
                            </div>
                            <div class="col-2 col-md-1">
                                {{count($detalle->RegistroProducto)}}
                            </div>
                            <div class="col-3 col-md-2">
                                {{$detalle->medida}}
                            </div>
                            <div class="col-3 col-md-1">
                                {{number_format($detalle->precioUnitario, 2)}}
                            </div>
                            <div class="col-4 col-md-2">
                                {{number_format($detalle->precioCompra, 2)}}
                            </div>
                        </div>
                      </button>
                    </h2>
                    <div id="flush-collapse-{{$cont}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$cont}}" data-bs-parent="#accordionFlushExample">
                      <div class="accordion-body ps-0 pe-0 pt-0 pb-0">
                        <ul class="list-group" style="position: relative;">
                            @foreach($detalle->RegistroProducto as $registro)
                            <li class="list-group-item">
                                <div class="row text-center {{$registro->estado == 'INVALIDO' ? 'text-danger text-decoration-line-through' : ''}}">
                                    <div class="col-6 col-md-3 text-start">
                                        <label class="text-secondary fw-italic">Numero de Serie</label>
                                        <p>{{$registro->numeroSerie}}</p>
                                    </div>
                                    <div class="col-4 col-md-2">
                                        <label class="text-secondary fw-italic">Estado</label>
                                        <p>{{$registro->estado}}</p>
                                    </div>
                                    <div class="col-md-6 d-none d-sm-none d-md-block">
                                        <label class="text-secondary fw-italic">Observaciones</label>
                                        <p>{{$registro->observacion ? $registro->observacion : 'Sin observaciones'}}</p>
                                    </div>
                                    <div class="col-2 col-md-1 text-end d-flex align-items-center">
                                        <button type="button" onclick="sendIdToDelete({{$registro->idRegistro}})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-trash-fill"></i></button>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                  @php $cont++; @endphp
                @endforeach
                </div>
              </li>
              @endif
            </ul>
        </div>
        @if($validate)
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center">
            <button type="button" onclick="validateSeries({{$documento->idProveedor}})" class="btn btn-success" id="btnSubmit"  disabled><i class="bi bi-floppy-fill"></i> Registrar</button>
        </div>
        <div class="col-md-3 text-end">
            <button type="button" onclick="generatePlantilla()" class="btn bg-success text-light">Plantilla <i class="bi bi-file-earmark-excel-fill"></i></button>
        </div>
        @endif
    </div>
    </form>
    <!-- Modal -->
    <form action="{{route('deleteingreso')}}" method="POST">
        @csrf
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <div class="row">
                  <h5 id="deleteModalLabel">Seguro de Eliminar?</h5>
                  <br>
                  <small class="text-secondary" >El registro se invalidara pero no se eliminara de la Base de datos.</small>
              </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-footer">
              <input type="hidden" value="" id="input-delete-ingreso" name="idingreso">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
    </form>
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <div class="row">
                  <h5 id="registerModalLabel">Agregar Producto</h5>
              </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-12  mb-3">
                    <label class="form-label">Producto:</label>
                    <input type="text" class="form-control input-modal-product" data-id="" data-cod="" value="" id="modal-hidden-product" placeholder="Encuentra un producto valido..." disabled>
                </div>
                <div class="col-md-12  mb-3" style="position:relative">
                    <label class="form-label">Buscar Producto:</label>
                    <input type="text" class="form-control" oninput="searchProduct(this)" placeholder="Modelo..." id="modal-input-product">
                    <ul class="list-group" id="suggestions-product" style="position:absolute;z-index:999;top:100%">
                        
                    </ul>
                </div>
                <div class="col-6 col-md-6">
                    <label class="form-label">Unidad de Medida</label>
                    <select class="form-select input-modal-product" id="modal-select-medida">
                        <option value="">-Elige una medida-</option>
                        @foreach($medidas as $medida)
                        <option value="{{$medida['value']}}">{{$medida['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-6  mb-3">
                  <label class="form-label">Precio por unidad:</label>
                    <input type="number" step="0.01" class="form-control input-modal-product" value="" id="modal-input-price">
                </div>
                
            </div>
          </div>
          <div class="modal-footer">
              <input type="hidden" value="" id="input-delete-ingreso" name="idingreso">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" id="btnIngreso" class="btn btn-success" data-bs-dismiss="modal">Agregar</button>
          </div>
        </div>
      </div>
    </div>
    <br>
    <input type="file" onchange="readExcel(this)" id="excel-file" class="d-none" /> <!--Input reusable -->
</div>
<script src="{{ route('js.documento-scripts') }}"></script>
<script>
    function openPdfInNewWindow() {
        var url = "{{route('generarSeriesPdf',[$documento->idComprobante])}}";
        window.open(url, '', 'width=800,height=600,scrollbars=yes,location=no,toolbar=no,status=no');
    }
</script>
<script>
    var listData = '';
    function readExcel(input) { 
        const file = input.files[0]; 
        if (file) { 
            const reader = new FileReader(); 
            reader.onload = function(event) { 
                const data = event.target.result; 
                const workbook = XLSX.read(data, { type: "binary" }); 
                const sheetName = workbook.SheetNames[0]; 
                const worksheet = workbook.Sheets[sheetName]; 
                const jsonData = XLSX.utils.sheet_to_json(worksheet); 
                const key = jsonData[0] ? Object.keys(jsonData[0])[0] : null;
                const values = Object.values(jsonData);
                if(key === 'SERIES'){
                    values.forEach(function(x){
                        console.log(x.SERIES); 
                        createItemList(listData,x.SERIES);
                        countProducts(listData);
                        updateBtnAdd();
                    });
                    listData = '';
                }else{
                    alert('Plantilla incorrecta, porfavor usa la plantilla ubicada en la parte inferior.');
                    listData = '';
                }
                input.value = '';
                console.log(jsonData); 
            }; 
        reader.readAsBinaryString(file); 
        } 
        input.value = '';
    }

    function setIdList (id){
        listData = id;
    }

    function generatePlantilla(){
        const headers = ["SERIES","!!Solo coloca valores en la columna de series!!"];

        // Crear una fila de datos vacíos para las cabeceras
        const data = [headers]; // Solo cabeceras, sin datos

        // Crear la hoja de trabajo a partir de las cabeceras
        const ws = XLSX.utils.aoa_to_sheet(data);

        // Crear un libro de trabajo y agregar la hoja
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Plantilla");

        // Escribir el archivo Excel y permitir su descarga
        XLSX.writeFile(wb, "plantilla_series.xlsx");
    }
    
    function validateSeries(idProveedor){
        let inputSeries = document.querySelectorAll('.input-serial');
        let series = [];

        inputSeries.forEach(function(x){
            series.push(x.value);
        });

        let seriesParams = series.map(s => `serial[]=${encodeURIComponent(s)}`).join('&');

        let xhr = new XMLHttpRequest();
            xhr.open('GET', `/documento/validateseries?${seriesParams}&proveedor=${idProveedor}`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let data = JSON.parse(xhr.responseText);
                    if(data.valid){
                        Swal.fire({
                            title: 'Numeros de serie ya registrados!!',
                            text: data.series,
                            icon: 'warning',
                            iconColor: '#00b1b9',
                            confirmButtonText: 'Aceptar', 
                            customClass: {
                                confirmButton: 'btn-primary',  
                            },
                            reverseButtons: true
                            });
                    }else{
                        confirmForm();
                    }
                    console.log(typeof data.series);
                }
            };
            xhr.send();
    }

    function confirmForm(){
        let formDocumento = document.getElementById('form-create-doc');
        Swal.fire({
        title: '!!No podras modificar el documento despues!!',
        text: '¿Estás seguro de que deseas continuar?',
        icon: 'warning',
        iconColor: '#00b1b9',
        showCancelButton: true, 
        confirmButtonText: 'Aceptar',  
        cancelButtonText: 'Cancelar', 
        customClass: {
            confirmButton: 'btn-primary',  
            cancelButton: 'btn btn-danger'
        },
        reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                formDocumento.submit();
            }
        });
    }
</script>

@endsection