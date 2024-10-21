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
        <div class="row">
            <div class="col-md-6">
                <h3 class="mt-2">Especificaciones 
                    <a class="fs-4" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createSpectModal">
                        <i class="bi bi-plus-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Nueva especificacion"></i>
                    </a>
                </h3>
            </div>
            <div class="col-md-6 text-end pt-2">
                <a class="fs-4 text-secondary" onclick="viewCategoriasXGrupos()" href="javascript:void(0)"  data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Categorias y Grupos">
                    <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
            <div class="col-md-12 text-secondary">
                <small>Especificaciones generales para todos los grupos.</small>
            </div>
            <div class="col-md-12 mt-2">
                <ul class="list-group">
                    <li class="list-group-item bg-sistema-uno text-light">
                        <div class="row">
                            <div class="col-md-3">
                                <h6>Especificacion</h6>
                            </div>
                            <div class="col-md-8 text-center">
                                <h6>Grupos</h6>
                            </div>
                        </div>
                    </li>
                    @foreach ($caracteristicas as $caracteristica)
                        <li class="list-group-item">
                            <div class="row h-100">
                                <div class="col-md-3">
                                    <strong>{{$caracteristica->especificacion}}</strong>
                                </div>
                                <div class="col-md-8 text-secondary text-center">
                                    @foreach ($caracteristica->Caracteristicas_Grupo as $grupo)
                                    {{ $loop->index  == 0 ? '' : ' | '}}
                                    <small class="text-decoration-underline">{{$grupo->GrupoProducto->nombreGrupo}}</small>
                                    @endforeach
                                </div>
                                <div class="col-md-1 text-end">
                                    <button class="btn btn-danger {{count($caracteristica->Caracteristicas_Grupo) == 0 ? '' : 'd-none'}}" data-bs-toggle="modal" 
                                        data-bs-target="#removeSpectModal" onclick="sendDataToRemove({{$caracteristica->idCaracteristica}},'{{$caracteristica->especificacion}}')">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div id="category-container">
        <div class="row" >
            <div class="col-md-9 d-flex align-items-center pt-1">
                <a class="fs-4 text-secondary" href="javascript:void(0)" onclick="viewCaracteristicas()" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Caracteristicas"><i class="bi bi-arrow-left-circle"></i></a>
                <h3 class="mt-2 ms-1"><i class="{{$categoria->iconCategoria}}"></i> {{$categoria->nombreCategoria}}</h3>
            </div>
            <div class="col-md-3 d-flex align-items-center justify-content-end">
                <div class="btn-group dropstart">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorias
                    </button>
                    <ul class="dropdown-menu">
                        @foreach ($categorias as $cat)
                            <li><a class="dropdown-item" href="{{route('configespecificaciones',[encrypt($cat->idCategoria)])}}" >{{$cat->nombreCategoria}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-12 text-secondary">
                <small>Especificaciones asignadas para cada grupo.</small>
            </div>
            @foreach ($categoria->GrupoProducto as $grupo)
            <div class="col-md-12 mt-2">
                <div class="row border shadow rounded-3 mb-3">
                    <div class="col-md-6 d-flex align-items-center border-bottom border-secondary">
                        <h5 class="pt-1">{{$grupo->nombreGrupo}}</h5>
                    </div>
                    <div class="col-md-6 border-bottom border-secondary text-end pt-1 pb-1">
                        <button class="btn btn-sm btn-success" onclick="sendGrupoToModal({{$grupo->idGrupoProducto}},'{{$grupo->nombreGrupo}}')" data-bs-toggle="modal" data-bs-target="#spectXGrupoModal">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                    <div class="col-md-12 bg-list">
                        <div class="row pt-2 pe-2 pb-1">
                            @foreach ($grupo->Caracteristicas_Grupo as $caracteristica)
                            <div class="col-md-2 mb-1">
                                <div class="row ms-1 h-100 border bg-light rounded-2 truncate">
                                    <small>
                                        <a href="javascript:void(0)" class="text-dark link-danger" 
                                            onclick="sendDataToDelete({{$caracteristica->idGrupoProducto}},{{$caracteristica->idCaracteristica}},'{{$grupo->nombreGrupo .'-'.$caracteristica->Caracteristicas->especificacion}}')" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteSpectXGrupoModal">
                                            <i class="bi bi-x-lg "></i></a>
                                        {{$caracteristica->Caracteristicas->especificacion}}
                                    </small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
    </div>
    </div>
    <br>
    <br>
    <form action="{{route('insertcaracteristicaxgrupo')}}" method="POST">
        @csrf
        <div class="modal fade" id="spectXGrupoModal" tabindex="-1" aria-labelledby="spectXGrupoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="spectXGrupoModalLabel">Agregar Especificaci&oacute;n <span id="title-modal-addespecificacionxgrupo"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="grupo" value="" id="hidden-modal-addespecificacionxgrupo-grupo">
                                <input type="hidden" name="caracteristica" value="" id="hidden-modal-addespecificacionxgrupo-especificacion">
                                <input class="form-control" type="text" placeholder="Busca una caracteristica..." id="text-modal-addespecificacionxgrupo" readonly>
                            </div>
                            <div class="col-md-12 mt-3">
                                <input class="form-control" oninput="inputSearch(this);disableButtonSave();" type="text" placeholder="busca aqui!!">
                                <ul class="list-group" id="modal-addespecificacionxgrupo-results" style="position:absolute;top:100%;z-index:1000"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btn-modal-addespecificacionxgrupo"><i class="bi bi-floppy"></i> Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="{{route('deletecaracteristicaxgrupo')}}" method="POST">
        @csrf
        <div class="modal fade" id="deleteSpectXGrupoModal" tabindex="-1" aria-labelledby="deleteSpectXGrupoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteSpectXGrupoModalLabel">Estas seguro(a) de borrar esta especificaci&oacute;n?
                            <span class="text-secondary fst-italic" id="title-modal-deleteespecificacionxgrupo"></span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <input type="hidden" value="" id="hidden-modal-deleteespecificacionxgrupo-caracteristica" name="caracteristica">
                        <input type="hidden" value="" id="hidden-modal-deleteespecificacionxgrupo-grupo" name="grupo">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger" id=""><i class="bi bi-trash3-fill"></i> Borrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="{{route('createcaracteristica')}}" method="POST">
        @csrf
    <div class="modal fade" id="createSpectModal" tabindex="-1" aria-labelledby="createSpectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSpectModalLabel">Agregar Especificaci&oacute;n</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Especificacion:</label>
                            <input type="text" name="descripcion" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <form action="{{route('removecaracteristica')}}" method="POST">
        @csrf
    <div class="modal fade" id="removeSpectModal" tabindex="-1" aria-labelledby="removeSpectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeSpectModalLabel">Eliminar Especificaci&oacute;n 
                        <span id="title-modal-deleteespecificacion">gruponame</span>?
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <input type="hidden" value="f" id="hidden-modal-deleteespecificacion" name="caracteristica">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Borrar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<script>
     var dataSpects = Object.values(@json($caracteristicas));


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

        function sendGrupoToModal(id,title){
            let inputHidden = document.getElementById('hidden-modal-addespecificacionxgrupo-grupo');
            let spanTitle = document.getElementById('title-modal-addespecificacionxgrupo');
            let inputHiddeSpect = document.getElementById('hidden-modal-addespecificacionxgrupo-especificacion'); 
            let textSpect = document.getElementById('text-modal-addespecificacionxgrupo');
            inputHidden.value = '';
            inputHiddeSpect.value = '';
            textSpect.value = '';

            spanTitle.textContent = title;
            inputHidden.value = id;
        }

        function disableButtonSave(){
            let btnModalCaracteristicas = document.getElementById('btn-modal-addespecificacionxgrupo');
            let inputHiddenGrupo = document.getElementById('hidden-modal-addespecificacionxgrupo-grupo');
            let inputHiddenCar = document.getElementById('hidden-modal-addespecificacionxgrupo-especificacion');
            let disabled = false;

            if(inputHiddenGrupo.value == ''){
                disabled = true;
            }

            if(inputHiddenCar.value == ''){
                disabled = true;
            }

            btnModalCaracteristicas.disabled = disabled;
        }

        function search(query) {
            return dataSpects.filter(item => item.especificacion.toLowerCase().includes(query.toLowerCase())).slice(0, 5);
        }

        function inputSearch(input){
            const query = input.value;
            const results = search(query);
            const resultsContainer = document.getElementById('modal-addespecificacionxgrupo-results');
            resultsContainer.innerHTML = '';

            if(query.length > 0){
                results.forEach(item => {
                    const li = document.createElement('li');
                    li.style.cursor = "pointer";
                    li.classList.add('list-group-item', 'hover-sistema-uno');
                    li.textContent = `${item.especificacion}`;

                    li.addEventListener('click', function() {
                            document.getElementById('hidden-modal-addespecificacionxgrupo-especificacion').value = item.idCaracteristica; 
                            document.getElementById('text-modal-addespecificacionxgrupo').value = item.especificacion;
                            disableButtonSave();
                            resultsContainer.innerHTML = ''; 
                        });
                    resultsContainer.appendChild(li);
                });
            }else {
                resultsContainer.innerHTML = '';
            }
        }

        function sendDataToDelete(grupo,spect,title){
            let tituloModal = document.getElementById('title-modal-deleteespecificacionxgrupo');
            let hiddenGrupo = document.getElementById('hidden-modal-deleteespecificacionxgrupo-grupo');
            let hiddenSpect = document.getElementById('hidden-modal-deleteespecificacionxgrupo-caracteristica');

            tituloModal.textContent = title;
            hiddenGrupo.value = grupo;
            hiddenSpect.value = spect;
        }

        function sendDataToRemove(spect,title){
            let tituloModal = document.getElementById('title-modal-deleteespecificacion');
            let hiddenModal = document.getElementById('hidden-modal-deleteespecificacion');

            tituloModal.textContent = title;
            hiddenModal.value = spect;
        }

        document.addEventListener('DOMContentLoaded', function() {
                disableButtonSave();
                document.getElementById('caracteristicas-container').style.display = 'none';
                document.getElementById('caracteristicas-container').style.transform = 'translateX(-100%)';
                document.getElementById('caracteristicas-container').style.opacity = '0';
        
    });
</script>
@endsection