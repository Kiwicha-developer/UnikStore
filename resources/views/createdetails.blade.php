@extends('layouts.app')

@section('title', 'Especificaciones | '.$producto->codigoProducto)

@section('content')
<div class="container">
    <br>
    <br>
    <div class="row ">
        <div class="col-6">
            <h2><a href="{{route('producto',[encrypt($producto->idProducto)])}}" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> ESPECIFICACIONES <em class="text-secondary fw-normal">({{$producto->codigoProducto}})</em></h2>
        </div>
         <div class="col-6 text-end">
            <a class="btn bg-sistema-uno text-light" href="{{route('productos',[encrypt($producto->GrupoProducto->idCategoria),encrypt($producto->idGrupo)])}}">Productos <i class="bi bi-box-fill"></i></a>
        </div>
    </div>
    <br>
    <div class="row border shadow rounded-3 pt-2">
        <div class="col-12 col-md-10 text-start d-flex justify-content-between align-items-center">
            <h3>{{$producto->nombreProducto}}</h3>
        </div>
        <div class="col-3 col-md-2">
            <img src="{{ asset('storage/'.$producto->MarcaProducto->imagenMarca) }}" alt="imagen marca" style="width:100%" class="rounded-3">
        </div>
        <div class="col-9">
            
        </div>
        <div class="col-4 col-md-8">
            <h5>{{$producto->estadoProductoWeb}}</h5>
        </div>
        <div class="col-8 col-md-4 text-end">
                <h5 data-bs-toggle="tooltip" data-bs-placement="bottom" title="Modelo">{{$grupo['nombreGrupo']}}: {{$producto->modelo}}</h4>
        </div>
        
    </div>
    <br>
    
    <br>
    <form action="{{route('insertorupdatedetails')}}"  method="POST">
        @csrf
    <input type="hidden" name="idproducto" value="{{$producto->idProducto}}">
    <div class="row" id="containerDivs">
        @foreach($caracteristicasxproducto as $car)
            <div class="input-group mb-3">
                    <span class="input-group-text update-details label-car bg-sistema-light text-light">{{$car->especificacion}}:</span>
                    <input type="text" name="updatecaracteristicas[{{ $car->idCaracteristica }}]" class="form-control" placeholder="Caracteristica" value="{{$car->caracteristicaProducto}}" aria-label="" aria-describedby="" maxlength="100">
            </div>
        @endforeach
    </div>
    
    <div class="row" >
        <div class="col-12">
            <div class="input-group">
              <select class="form-select" id="caracteristicaSelect" aria-label="">
                <option value="none" selected>Caracteristica</option>
                @foreach($caracteristicasxgrupo as $car)
                    <option value="{{$car->idCaracteristica}}">{{$car->especificacion}}</option>
                @endforeach
              </select>
              <button class="btn btn-outline-secondary" onclick="addDiv()" id="btnAddDetail" type="button">Agregar</button>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-success" >Guardar <i class="bi bi-floppy"></i></button>
        </div>
    </div>
    </form>
    <br>
    <br>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let btnAdd = document.getElementById('btnAddDetail');
        let select = document.getElementById('caracteristicaSelect');
        
        // Función para actualizar el estado del botón
        function updateButtonState() {
            let selectedCar = select.options[select.selectedIndex];
            let carValue = selectedCar.value;
            
            if (carValue === 'none') {
                btnAdd.classList.add('disabled');
                btnAdd.disabled = true;
            } else {
                btnAdd.classList.remove('disabled');
                btnAdd.disabled = false;
            }
        }
        
        function addDiv() {
            var selectedOption = select.options[select.selectedIndex];
            var selectedValue = selectedOption.value;
            var selectedText = selectedOption.text;
            
            if (selectedValue === 'none') {
                return; // No hacer nada si se selecciona la opción predeterminada
            }
            
            let newDiv = document.createElement('div');
            let newSpan = document.createElement('span');
            let newInput = document.createElement('input');
            
            newDiv.className = 'input-group mb-3';
            
            newSpan.className = 'input-group-text update-details label-car bg-sistema-light text-light';
            newSpan.textContent = selectedText;
            
            newInput.className = 'form-control';
            newInput.type = 'text';
            newInput.maxLength  = 100;
            newInput.placeholder = 'Característica';
            newInput.name = 'insertcaracteristicas[' + selectedValue + ']';
            
            
            
            newDiv.appendChild(newSpan);
            newDiv.appendChild(newInput);
            document.getElementById('containerDivs').appendChild(newDiv);
            
            hiddenSelect(selectedOption);
            
            select.value = 'none';
            
            updateButtonState();
            sizeLabel();
        }
        
        function hiddenSelect(option) {
            option.classList.add('hidden');
            option.style.display = 'none';
        }
        
        function sizeLabel(){
            let lblCar = document.querySelectorAll('.label-car');
            lblCar.forEach(function(label) {
                if (window.innerWidth < 576) { 
                    label.style.width = "40%";
                } else { 
                    label.style.width = "15%";
                }
            });
        }
    
        // Inicializar el estado del botón al cargar
        updateButtonState();
        sizeLabel();
    
        // Agregar un evento para cuando se cambie la selección
        select.addEventListener('change', updateButtonState);
        
        // Agregar un evento para el botón
        btnAdd.addEventListener('click', addDiv);
    });
</script>
@endsection