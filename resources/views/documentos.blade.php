@extends('layouts.app')

@section('title', 'Documentos')

@section('content')
<div class="container">
    <div class="bg-secondary" id="hidden-body" style="position:fixed;left:0;width:100vw;height:100vh;z-index:998;opacity:0.5;display:none">
    </div>
    <br>
    <div class="row">
        <div class="col-6 col-md-5 text-end" style="position:relative;z-index:999">
            <div class="input-group mb-3" >
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" placeholder="Nro documento" id="search">
              <ul class="list-group w-100" style="position:absolute;top:100%;z-index:1000" id="suggestions">
              </ul>
            </div>
        </div>
        <div class="col-md-4 d-none d-sm-none d-md-block"></div>
        <div class="col-6 col-md-3 text-end">
            <input type="month" class="form-control" id="month" name="month" placeholder="MM-YYYY" value="{{$fecha->format('Y-m')}}" >
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-6 col-md-6">
            <h2><i class="bi bi-folder-fill"></i> Documentos <span class="text-capitalize text-secondary fw-light" ><em>({{$fecha->translatedFormat('F')}})</em></span></h2>
        </div>
        <div class="col-6 col-md-6 text-end">
            <a href="{{route('ingresos', [now()->format('Y-m')])}}" class="btn btn-info mb-2"><i class="bi bi-file-earmark-plus-fill"></i> Ingresos</a>
            <a href="{{route('egresos', [now()->format('Y-m')])}}" class="btn btn-warning mb-2"><i class="bi bi-file-earmark-minus-fill"></i> Egresos</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            @if(!$documentos->isEmpty())
            <ul class="list-group">
              <li class="list-group-item bg-sistema-uno text-light" style="position: sticky;top:0;z-index:800">
                <div class="row text-center">
                    <div class="col-6 col-md-3 text-start">
                        <small>Proveedor</small>
                    </div>
                    <div class="col-md-2 d-none d-sm-none d-md-block">
                        <small>RUC</small>
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
                    <div class="col-md-2 d-none d-sm-none d-md-block">
                        <small>{{$documento->Preveedor->rucProveedor}}</small>
                    </div>
                    <div class="col-4 col-md-2">
                        <small>{{$documento->TipoComprobante->descripcion}}</small>
                    </div>
                    <div class="col-6 col-md-2 text-start">
                        <small><a href="{{route('documento',[encrypt($documento->idComprobante),0])}}" class="decoration-link">{{$documento->numeroComprobante}}</a></small>
                    </div>
                    <div class="col-3 col-md-1">
                        <small>{{$documento->DetalleComprobante->count()}}</small>
                    </div>
                    <div class="col-3 col-md-2">
                        <small>{{$documento->fechaRegistro->format('Y-m-d')}}</small>
                    </div>
                </div>
              </li>
              @endforeach
            </ul>
            <br>
            <br>
            @else
            <div class="row align-items-center" style="height:80vh">
                <x-aviso_no_encontrado :mensaje="''"/>
            </div>
        </div>
    </div>
    @endif
</div>
<script>
    document.getElementById('month').addEventListener('change', function() {
        let selectedMonth = this.value;
        let url = "/documentos/" + selectedMonth;
        
        if(selectedMonth == ""){
            alert('Fecha no valida.');
        }else{
            window.location.href = url;
        }
        
    });
    
    document.getElementById('month').addEventListener('keydown', function(event) {
        // Evita que la acción de borrado ocurra si se presiona Backspace o Delete
        if (event.key === 'Backspace' || event.key === 'Delete') {
            event.preventDefault();
        }
    });
</script>
<script>
const baseUrl = "{{ route('documento', ['id' => 'dummyId', 'bool' => 'dummyBool']) }}";
document.getElementById('search').addEventListener('input', function() {
    let query = this.value;
    let hiddenBody = document.getElementById('hidden-body');
    if (query.length > 2) { // Comenzar la b��squeda despu��s de 3 caracteres
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `/documento/searchdocument?query=${query}`, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let data = JSON.parse(xhr.responseText);
                let suggestions = document.getElementById('suggestions');
                hiddenBody.style.display = 'block';
                suggestions.innerHTML = '';

                    data.forEach(item => {
                        let li = document.createElement('li');
                        li.classList.add('list-group-item', 'hover-sistema-uno');
                        li.style.cursor = "pointer";
                        
                        let divRow = document.createElement('div');
                        divRow.classList.add('row');
                        
                        let divColProv = document.createElement('div');
                        divColProv.classList.add('col-12','col-md-4', 'text-start');
                        let smallProv = document.createElement('small');
                        smallProv.textContent = item.preveedor.nombreProveedor;
                        divColProv.appendChild(smallProv);
                        
                        let divColNum = document.createElement('div');
                        divColNum.classList.add('col-6','col-md-4');
                        let smallNum = document.createElement('small');
                        smallNum.textContent = item.numeroComprobante;
                        divColNum.appendChild(smallNum);
                        
                        let divColDate = document.createElement('div');
                        divColDate.classList.add('col-6','col-md-4');
                        let smallDate = document.createElement('small');
                        smallDate.textContent = item.fechaPersonalizada;
                        divColDate.appendChild(smallDate);
                        
                        li.addEventListener('click', function() {
                            document.getElementById('search').value = item.numeroComprobante; // Mostrar solo el n��mero de documento
                            suggestions.innerHTML = ''; // Limpiar sugerencias despu��s de seleccionar una
                            let encryptedId = item.encryptId; // Encriptar el ID del documento
                            let boolValue = 0; // Valor del par��metro booleano (ajusta si es necesario)
                            let url = baseUrl.replace('dummyId', encryptedId).replace('dummyBool', boolValue); // Reemplazar los marcadores de posici��n
                        
                            window.location.href = url;
                        });
                        
                        divRow.appendChild(divColProv);
                        divRow.appendChild(divColNum);
                        divRow.appendChild(divColDate);
                        li.appendChild(divRow);
                        suggestions.appendChild(li);
                    });
            }
        };
        xhr.send();
    } else {
        document.getElementById('suggestions').innerHTML = ''; // Limpiar si hay menos de 3 caracteres
        hiddenBody.style.display = 'none';
    }
});

function hideSuggestions(event) {
    let suggestions = document.getElementById('suggestions');
    let hiddenBody = document.getElementById('hidden-body');
    if (!suggestions.contains(event.target) && event.target.id !== 'search') {
        suggestions.innerHTML = ''; // Oculta las sugerencias
        hiddenBody.style.display = 'none';
    }
}

// A�0�9adir manejador de eventos para el clic en el documento
document.addEventListener('click', hideSuggestions);
</script>
@endsection