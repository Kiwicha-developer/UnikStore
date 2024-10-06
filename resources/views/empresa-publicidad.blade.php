@extends('layouts.app')

@section('title', 'Web | '. $empresa->nombreComercial)

@section('content')
    <div class="container">
        <br>
        <div class="row">
            <div class="col-6">
                <h3><a href="{{route('publicidad')}}" class="text-secondary"><i class="bi bi-arrow-left-circle"></i></a> WEB: <span class="text-secondary">{{$empresa->nombreComercial}}</span></h3>
            </div> 
            <div class="col-6 text-end">
                <h3>{{$empresa->rucEmpresa}}</h3>
            </div>
        </div>
        <br>
        <form action="{{route('updatepublicacion')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row border shadow pt-2 mb-2">
            <h4>BANNERS</h4>
            <div class="col-md-12">
                <div class="row">
                    <h5>Principales: </h5>
                    @foreach($empresa->Publicidad->where('tipoPublicidad','BANNER') as $banner)
                    <div class="col-md-4 mb-2" id="previewImage-{{$banner->idPublicidad}}">
                        <input class="d-none input-edit" name="img[{{$banner->idPublicidad}}]" type="file" accept="image/webp" id="img-public-{{$banner->idPublicidad}}" onchange="changeImageBanner(event,{{$banner->idPublicidad}})">
                        <img src="{{ asset('storage/'.$banner->imagenPublicidad) }}?{{ time() }}" alt="Click to upload" id="triggerImage-{{$banner->idPublicidad}}" class="w-100 border border-secondary rounded-3" style="cursor: pointer; object-fit: cover;">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <h5>Verticales: </h5>
                    @foreach($empresa->Publicidad->where('tipoPublicidad','VERTICAL') as $banner)
                    <div class="col-md-3 mb-2" id="previewImage-{{$banner->idPublicidad}}">
                        <input class="d-none input-edit" name="img[{{$banner->idPublicidad}}]" type="file" accept="image/webp" id="img-public-{{$banner->idPublicidad}}" onchange="changeImageVertical(event,{{$banner->idPublicidad}})">
                        <img src="{{ asset('storage/'.$banner->imagenPublicidad) }}?{{ time() }}" alt="Click to upload" id="triggerImage-{{$banner->idPublicidad}}" class="w-100 border border-secondary rounded-3" style="cursor: pointer; object-fit: cover;">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <h5>Campa&ntildea: </h5>
                    @foreach($empresa->Publicidad->where('tipoPublicidad','CAMPANIA') as $banner)
                    <div class="col-md-12 mb-2" id="previewImage-{{$banner->idPublicidad}}">
                        <input class="d-none input-edit" name="imgPubli[{{$banner->idPublicidad}}]" type="file" accept="image/webp" id="img-public-{{$banner->idPublicidad}}" onchange="changeImage(event,{{$banner->idPublicidad}})">
                        <img src="{{ asset('storage/'.$banner->imagenPublicidad) }}?{{ time() }}" alt="Click to upload" id="triggerImage-{{$banner->idPublicidad}}" class="w-100 border border-secondary rounded-3" style="cursor: pointer; object-fit: cover;">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row border shadow pt-2 pb-2 mb-2">
            <div class="col-12">
                <h4>REDES SOCIALES</h4>
                <input name="empresa" value="{{$empresa->idEmpresa}}" type="hidden" class="form-control">
            </div>
            @foreach($empresa->EmpresaRedSocial as $red)
            <div class="col-4 mb-2">
                <div class="row ms-1 me-1 pt-2 pb-2 border border-secondary rounded-3">
                    <div class="col-9">
                        <h6>{{$red->RedSocial->plataforma}}</h6>
                        <div class="input-group input-group-sm mb-3">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Enlace:</span>
                          <input type="text" name="enlaces[{{$red->idRedSocial}}]" class="form-control" value="{{$red->enlace}}" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>
                    <div class="col-3" >
                        <input class="d-none input-edit" name="imgRed[{{$red->idRedSocial}}]" type="file" accept="image/webp" id="img-red-{{$red->idRedSocial}}" onchange="changeImageRedSocial(event,{{$red->idRedSocial}})">
                        <img src="{{ asset('storage/'.$red->imagen) }}?{{ time() }}" alt="Click to upload" id="triggerImageRed-{{$red->idRedSocial}}" class="w-100 border border-secondary rounded-3" style="cursor: pointer; object-fit: cover;">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-success" type="submit">Guardar <i class="bi bi-floppy"></i></button>
            </div>
        </div>
        </form>
        <br>
        <br>
    </div>
    <script>
        @foreach($empresa->Publicidad as $publi)
            document.getElementById('triggerImage-{{$publi->idPublicidad}}').addEventListener('click', function() {
                document.getElementById('img-public-{{$publi->idPublicidad}}').click();
            });
        @endforeach
        @foreach($empresa->EmpresaRedSocial as $red)
            document.getElementById('triggerImageRed-{{$red->idRedSocial}}').addEventListener('click', function() {
                document.getElementById('img-red-{{$red->idRedSocial}}').click();
            });
        @endforeach
        
        function changeImageBanner(event, id) {
            const file = event.target.files[0];
            const triggerImage = document.getElementById('triggerImage-' + id);
        
            if (file) {
                const reader = new FileReader();
        
                reader.onload = function(e) {
                    const img = new Image();
                    img.src = e.target.result;
        
                    img.onload = function() {
                        const maxWidth = 1920 ; // Ancho máximo permitido
                        const maxHeight = 740; // Alto máximo permitido
        
                        if (img.width > maxWidth || img.height > maxHeight) {
                            alert('La imagen no coincide con las dimensiones permitidas ' + maxWidth + ' x ' + maxHeight + ' píxeles.');
                            return;
                        }
        
                        // Si la imagen cumple con las dimensiones, actualiza la vista previa
                        triggerImage.src = e.target.result;
                    }
                }
        
                reader.readAsDataURL(file);
            }
        }
        
        function changeImageVertical(event, id) {
            const file = event.target.files[0];
            const triggerImage = document.getElementById('triggerImage-' + id);
        
            if (file) {
                const reader = new FileReader();
        
                reader.onload = function(e) {
                    const img = new Image();
                    img.src = e.target.result;
        
                    img.onload = function() {
                        const maxWidth = 800 ; // Ancho máximo permitido
                        const maxHeight = 1200; // Alto máximo permitido
        
                        if (img.width > maxWidth || img.height > maxHeight) {
                            alert('La imagen no coincide con las dimensiones permitidas ' + maxWidth + ' x ' + maxHeight + ' píxeles.');
                            return;
                        }
        
                        // Si la imagen cumple con las dimensiones, actualiza la vista previa
                        triggerImage.src = e.target.result;
                    }
                }
        
                reader.readAsDataURL(file);
            }
        }
        
        function changeImageRedSocial(event, id) {
            const file = event.target.files[0];
            const triggerImage = document.getElementById('triggerImageRed-' + id);
        
            if (file) {
                const reader = new FileReader();
        
                reader.onload = function(e) {
                    const img = new Image();
                    img.src = e.target.result;
        
                    img.onload = function() {
                        const maxWidth = 150 ; // Ancho máximo permitido
                        const maxHeight = 150; // Alto máximo permitido
        
                        if (img.width > maxWidth || img.height > maxHeight) {
                            alert('La imagen no coincide con las dimensiones permitidas ' + maxWidth + ' x ' + maxHeight + ' píxeles.');
                            return;
                        }
        
                        // Si la imagen cumple con las dimensiones, actualiza la vista previa
                        triggerImage.src = e.target.result;
                    }
                }
        
                reader.readAsDataURL(file);
            }
        }
        
        function changeImage(event, id) {
            const file = event.target.files[0];
            const triggerImage = document.getElementById('triggerImage-' + id);
        
            if (file) {
                const reader = new FileReader();
        
                reader.onload = function(e) {
                    triggerImage.src = e.target.result;
                }
        
                reader.readAsDataURL(file);
            }
        }
        
    </script>
@endsection