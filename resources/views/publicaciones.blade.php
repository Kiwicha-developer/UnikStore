@extends('layouts.app')

@section('title', 'Publicaciones')

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-12 col-md-8">
            <h2><i class="bi bi-megaphone-fill"></i> Publicaciones</h2>
        </div>
        <div class="col-6 col-md-2 text-end">
            <input type="month" class="form-control" id="month" name="month" value="{{$fecha->format('Y-m')}}" >
        </div>
        <div class="col-6 col-md-2 text-end">
            <div class="btn-group dropstart">
              <button type="button" class="btn btn-success" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-plus-lg"></i> Nueva
              </button>
              <ul class="dropdown-menu">
                  @foreach($plataformas as $plataforma)
                    <li><a class="dropdown-item" href="{{route('createpublicacion',[encrypt($plataforma->idPlataforma)])}}">
                        <img src="{{ asset('storage/'.$plataforma->imagenPlataforma) }}" alt="plataforma" style="height:2rem" class="rounded-2"> {{$plataforma->nombrePlataforma}}
                    </a></li>
                  @endforeach
              </ul>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <ul class="list-group">
              <li class="list-group-item bg-sistema-uno text-light pb-0" style="position:sticky; top: 0;z-index:800">
                  <div class="row text-center ">
                      <div class="col-4 col-md-1">
                          <h6>Seller</h6>
                      </div>
                      <div class="col-md-1 d-none d-sm-block">
                          <h6>Usuario</h6>
                      </div>
                      <div class="col-md-2 d-none d-sm-block">
                          <h6>Cuenta</h6>
                      </div>
                      <div class="col-4 col-md-2">
                          <h6>SKU</h6>
                      </div>
                      <div class="col-4 col-md-2">
                          <h6>Producto</h6>
                      </div>
                      <div class="col-md-1 d-none d-sm-block">
                          <h6>Precio</h6>
                      </div>
                      <div class="col-md-1 d-none d-sm-block">
                          <h6>Estado</h6>
                      </div>
                      <div class="col-md-1 d-none d-sm-block">
                          <h6>Actualizado</h6>
                      </div>
                  </div>
              </li>
              @foreach($publicaciones as $public)
              <li class="list-group-item">
                  <div class="row text-center">
                      <div class="col-4 col-md-1">
                          <img src="{{ asset('storage/'.$public->CuentasPlataforma->Plataforma->imagenPlataforma) }}" alt="Tooltip Imagen" style="width:100%" class="rounded-3">
                      </div>
                      <div class="col-md-1 d-none d-sm-block">
                          <small>{{$public->Usuario->user}}</small>
                      </div>
                      <div class="col-md-2 d-none d-sm-block">
                          <small>{{$public->CuentasPlataforma->nombreCuenta}}</small>
                      </div>
                      <div class="col-4 col-md-2">
                          <small data-bs-toggle="tooltip" data-bs-placement="top" title="{{$public->titulo}}">{{$public->sku}}</small>
                      </div>
                      <div class="col-4 col-md-2">
                          <small data-bs-toggle="tooltip" data-bs-placement="top" title="{{$public->Producto->modelo}}">
                            <a href="{{route('producto',[encrypt($public->Producto->idProducto)])}}" class="decoration-link">{{$public->Producto->codigoProducto}}</a>
                        </small>
                      </div>
                      <div class="col-md-1 d-none d-sm-block">
                          <small>{{number_format($public->precioPublicacion,2)}}</small>
                      </div>
                      <div class="col-6 col-md-1">
                          <small >
                              <a href="#" onclick="ShareId({{$public->idPublicacion}})" class="{{$public->estado == 1 ? 'text-success' : ($public->estado == 0 ? 'text-danger ' : 'text-danger text-decoration-line-through')}}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    {{$public->estado == 1 ? 'Activo' : ($public->estado == 0 ? 'Inactivo' : 'Borrado')}}
                                </a>
                          </small>
                      </div>
                      <div class="col-6 col-md-1">
                          <small>{{$public->fechaPublicacion->format('d/m/Y')}}</small>
                      </div>
                  </div>
              </li>
              @endforeach
            </ul>
        </div>
    </div>
    <!-- Modal -->
    <form id="estadoForm" action="{{route('update-estado-publicacion')}}" method="POST">
        @csrf
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">&#191;Estas seguro(a) de deshabilitar/habilitar la publicaci&oacuten?<span id="proba"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-footer ">
              <div class="row w-100">
                  <div class="col-4 col-md-4 d-flex align-items-end ps-0">
                      <small><a type="button" class="text-danger mb-0" onclick="sendData('delete')"> Borrar publicaci&oacuten</a></small>
                  </div>
                  <div class="col-8 col-md-8 text-end">
                      <input type="hidden" id="hidden-id" name="id">
                      <input type="hidden" id="hidden-data" name="data">
                      <button type="button" class="btn btn-warning" onclick="sendData('change')"><i class="bi bi-check2"></i> Actualizar</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> No</button>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    </form>
</div>
<script>
    function sendData(data) {
        // Establece el valor de un campo oculto en el formulario
        document.getElementById('hidden-data').value = data;
        
        // Puedes agregar l���gica adicional aqu��� si es necesario
        
        // Env���a el formulario
        document.getElementById('estadoForm').submit();
      }

    function ShareId(id){
        let inputId = document.getElementById('hidden-id');
        
        inputId.value = id;
    }
</script>
<script>
    document.getElementById('month').addEventListener('change', function() {
        let selectedMonth = this.value;
        let url = "/registro-publicaciones/" + selectedMonth;
        
        if(selectedMonth == ""){
            alert('Fecha no valida.');
        }else{
            window.location.href = url;
        }
        
    });
    
    document.getElementById('month').addEventListener('keydown', function(event) {
        // Evita que la acci贸n de borrado ocurra si se presiona Backspace o Delete
        if (event.key === 'Backspace' || event.key === 'Delete') {
            event.preventDefault();
        }
    });
</script>
@endsection