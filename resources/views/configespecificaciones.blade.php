@extends('layouts.app')

@section('title', 'Configuración')

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-12">
            <h2><i class="bi bi-gear-fill"></i> Configuraci&oacuten</h2>
        </div>
    </div>
    <br>
    <div class="col-md-12">
        <x-nav_config :pag="$pagina" />
    </div>
    <br>
    <div id="caracteristicas-container">
        
    </div>
    <div id="category-container">
        
    </div>
    <br>
    <br>
    
    
    
   
    <form action="{{route('removesugerencia')}}" method="post" id="form-delete-sugerencia">
        @csrf
        <input type="hidden" name="sugerencia" value="" id="hidden-delete-sugerencia">
    </form>
</div>
<script>
     

     function sendDataToRemoveSugerencia(idSugerencia) {
        // Mostrar un cuadro de confirmación
        let confirmDelete = confirm("¿Estás seguro de que quieres eliminar esta sugerencia?");

        // Si el usuario confirma la eliminación
        if (confirmDelete) {
            // Obtén el formulario y el campo oculto
            let formDelete = document.getElementById('form-delete-sugerencia');
            let inputHide = document.getElementById('hidden-delete-sugerencia');
            
            // Establece el valor del campo oculto con el idSugerencia
            inputHide.value = idSugerencia;
            
            // Envía el formulario
            formDelete.submit();
        }
    }

        function changeOperacionModal(valor){
            let inputOperacion = document.getElementById('operacion-modal-editespecificacion');

            inputOperacion.value = valor;
        }

        function viewCaracteristicas(){
            let categoryContainer = document.getElementById('category-container');
            let caracteristicasContainer = document.getElementById('caracteristicas-container');

            caracteristicasContainer.style.display = 'block';
            categoryContainer.style.transition = 'transform 0.5s ease, opacity 0.5s ease'; // Asegúrate de añadir la transición
            categoryContainer.style.transform = 'translateX(100%)'; // Comillas alrededor de la transformación
            categoryContainer.style.opacity = '0';
            

            setTimeout(() => {
                categoryContainer.style.display = 'none';
                caracteristicasContainer.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
                caracteristicasContainer.style.transform = 'translateX(0)';
                caracteristicasContainer.style.opacity = '1';
            }, 500);
        }

        function viewCategoriasXGrupos(){
            let categoryContainer = document.getElementById('category-container');
            let caracteristicasContainer = document.getElementById('caracteristicas-container');

            categoryContainer.style.display = 'block';
            caracteristicasContainer.style.transition = 'transform 0.5s ease, opacity 0.5s ease'; // Asegúrate de añadir la transición
            caracteristicasContainer.style.transform = 'translateX(-100%)'; // Comillas alrededor de la transformación
            caracteristicasContainer.style.opacity = '0';
            

            setTimeout(() => {
                caracteristicasContainer.style.display = 'none';
                categoryContainer.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
                categoryContainer.style.transform = 'translateX(0)';
                categoryContainer.style.opacity = '1';
            }, 500);
        }

        

        

        
        

        

       

        document.addEventListener('DOMContentLoaded', function() {
                disableButtonSave();
                document.getElementById('caracteristicas-container').style.display = 'none';
                document.getElementById('caracteristicas-container').style.transform = 'translateX(-100%)';
                document.getElementById('caracteristicas-container').style.opacity = '0';
        
    });
</script>
@endsection