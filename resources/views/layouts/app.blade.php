<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'T��tulo por defecto')</title>
    <link rel="icon" href="{{asset('storage/logos/logosysredondo.webp')}}" type="image/webp">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{route('js.header-scripts')}}"></script>
</head>
<style>

    .text-danger{
        color: #f34646 !important;
    }
    .truncate{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .bg-sistema-uno{
        background-color:#043e69;
    }
    
    .bg-sistema-dos{
        background-color:#00b1b9 !important;
    }
    
    .btn-success{
        background-color:#00b1b9 !important;
        border-color: #00b1b9 !important;
    }

    .btn-primary{
        background-color:#043e69 !important;
        border-color: #043e69 !important;
    }
    
    .btn-danger{
        background-color:#f34646 !important;
        border-color: #f34646 !important;
    }
    
    .btn-info{
        background-color:#34b277 !important;
        border-color: #34b277 !important;
        color: white !important;
    }
    
    .btn-warning{
        background-color:#6740a1 !important;
        border-color: #6740a1 !important;
        color: white !important;
    }
    
    .btn-warning:hover {
    background-color: #5c3a8e !important; /* Color de fondo en hover (puedes ajustarlo) */
    border-color: #5c3a8e !important; /* Color del borde en hover */
    }
    
    .btn-warning:focus, .btn-warning.focus {
        box-shadow: 0 0 0 0.2rem rgba(103, 64, 161, 0.5) !important; /* Sombra en foco */
    }
    
    .text-sistema-uno{
        color:#1c328a;
    }
    
    .hover-sistema-uno:hover{
        background-color:#00b1b9;
        color: white;
    }
    
    .bg-sistema-light{
        background-color:#2ca3c6;
    }
    
    .bg-list{
        background-color:#dfdfdf;
    }
    
    .menu-border {
        border-color: #6790b9;
    }
    
    .link-sistema{
        color: black;
        text-decoration: none;
    }
    
    .link-sistema:hover{
        color: #00b1b9;
        text-decoration: underline;
    }

    .link-danger:hover{
        color: red !important;
    }
    
    .decoration-link{
        color: #00b1b9;
    }
    
    .link-hover:hover{
        text-decoration: underline !important;
    }
    
    .hidden-button:active {
        outline: none !important;
        box-shadow: none !important;
    }
    
    .hidden-button {
        outline: none !important;
        box-shadow: none !important;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: transparent !important;
        color: inherit !important;
        box-shadow: none !important;
    }
    
    .accordion-button:focus, .accordion-button.active {
        box-shadow: none;
        background-color: transparent;
        color: inherit;
    }
    
    .offcanvas {
        z-index: 9999; /* Cambia este valor seg��n tus necesidades */
    }
    
    @media (max-width: 576px) { /* Para dispositivos con un ancho m��ximo de 576px */
    .offcanvas {
        width:75%;
    }
    
    .modal {
        z-index: 9990 !important; /* Establece el z-index para todos los modales */
    }
}
    
</style>
<body>
    @if(session('title') && session('message') && session('icon') && session('button'))
        <script>
            Swal.fire({
                title: '{{ session('title') }}!',
                text: '{{ session('message') }}',
                icon: '{{ session('icon') }}',
                iconColor: '#00b1b9',
                confirmButtonText: 'Aceptar',
                customClass: {
                    confirmButton: '{{ session('button') }}' // Clase personalizada para el botón de confirmación
                }
            });
    </script>
    @endif
    <header>
            <div class="text-light bg-sistema-uno">
                <div class="container">
                    <div class="row" style="z-index:9000">
                        <div class="col-2 col-md-1">
                            <a class="btn text-light hidden-button" data-bs-toggle="offcanvas" href="#offcanvasDashboard" role="button" aria-controls="offcanvasDashboard">
                              <i class="bi bi-list" style="font-size:2rem"></i>
                            </a>
                        </div>
                        <div class="col-6 col-md-9 d-flex justify-content-start align-items-center">
                            <img class="d-none d-sm-block" alt="logo" src="{{asset('storage/logos/logosysfondo.webp')}}" style="width:50px">
                            <h5 class="d-none d-sm-flex justify-content-start align-items-center mb-0 h-100">Unik Technology &nbsp;<span class="text-secondary"> v1.12</span></h5>
                        </div>
                        <div class="col-4 col-md-2" style="position:relative;z-index:9000">
                            <div class="row h-100 d-flex align-items-center text-end pt-2" id="header-user-nav" style="cursor:pointer">
                                    <h5 class="w-100"><i class="bi bi-person-circle"></i> {{$user->user}}</h5>
                            </div>
                            <div class="border shadow pt-2 pb-3 rounded-3 bg-light" style="position:absolute;width:100%;left:-10%;z-index:9000;display:none" id="options-user">
                                <div class="row text-dark text-center">
                                    <div class="col-md-12 mt-1">
                                        <small>
                                            <a href="#" onclick="getIdPass({{ $user->idUser }},'id-modal-bandeja'); return false;" class=" text-decoration-none text-secondary link-hover" data-bs-toggle="modal" data-bs-target="#modalBandeja">
                                                <i class="bi bi-journal-bookmark-fill" ></i> Pendientes
                                            </a>
                                        </small>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <small>
                                            <a href="#" onclick="getIdPass({{ $user->idUser }},'id-modal-password'); return false;" class="text-decoration-none text-secondary link-hover" data-bs-toggle="modal" data-bs-target="#modalNewPass">
                                                <i class="bi bi-arrow-clockwise"></i> Reestablecer Contrase&ntildea
                                            </a>
                                        </small>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <small><a href="{{route('login')}}" class="text-danger text-decoration-none link-hover"><i class="bi bi-escape"></i> Cerrar Sesi&oacuten</a></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </header>
    <nav>
        <div class="offcanvas offcanvas-start bg-sistema-uno" tabindex="-1" id="offcanvasDashboard" aria-labelledby="offcanvasExampleLabel">
          <div class="offcanvas-header">
            <img class="d-sm-none" alt="logo" src="{{asset('storage/logos/logosysfondo.webp')}}" style="width:50px">
            <div class="row d-block d-sm-none">
                <h5 class=" text-light justify-content-start align-items-center mb-0 h-100 w-100">Unik Technology</h5>
                <small class="text-secondary">v1.12</small>
            </div>
            <h5 class="d-none d-sm-flex offcanvas-title text-light">Men&uacute;</h5>
            <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body ">
              <ul class="list-group list-group-flush ">
                  <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('dashboard')}}" class="btn text-light">Dashboard <i class="bi bi-house-fill"></i></a></li>
                  <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('calculadora')}}" class="btn text-light">Calculadora <i class="bi bi-calculator"></i></a></li>
                  @foreach ($user->Accesos as $access)
                      @switch($access->idVista)
                        @case(1)
                            <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('publicaciones',[now()->format('Y-m')])}}" class="btn text-light">Publicaciones <i class="bi bi-megaphone-fill"></i></a></li>
                              @break
                        @case(2)
                            <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('productos',[encrypt(1),encrypt(1)])}}" class="btn text-light">Productos <i class="bi bi-box-fill"></i></a></li>
                              @break
                        @case(3)
                            <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('documentos', [now()->format('Y-m')])}}" class="btn text-light">Registros <i class="bi bi-folder-fill"></i></a></li>
                              @break
                        @case(4)
                            <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('plataformas')}}" class="btn text-light">Plataformas <i class="bi bi-shop"></i></a></li>
                              @break
                        @case(5)
                            <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('publicidad')}}" class="btn text-light">Web <i class="bi bi-globe"></i></a></li>
                              @break
                        @case(6)
                            <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('usuarios')}}" class="btn text-light">Usuarios <i class="bi bi-person-fill"></i></a></li>
                              @break
                        @case(7)
                            <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('configweb')}}" class="btn text-light">Configuraci&oacuten <i class="bi bi-gear-fill"></i></a></li>
                              @break
                      @endswitch
                  @endforeach
                </ul>
          </div>
        </div>
    </nav>
    <main class="content">
        @yield('content')

        <!-- Modal -->
<form action="{{route('updatepass')}}"  method="POST">
    @csrf
   <div class="modal fade" id="modalNewPass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title " id="modalNewPassLabel">Reestablecer contraseña</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
           <div class="row">
               <div class="col-12 mb-2">
                   <input type="hidden" name="id" value="" class="form-control" id="id-modal-password">
                   <label class="form-label">Nueva contraseña</label>
                   <input type="password" name="pass" class="form-control" id="pass-modal-password">
                   <small id="passwordError" class="text-danger"></small>
               </div>
               <div class="col-12">
                   <label class="form-label">Confirmar contraseña</label>
                   <input type="password" name="confirmpass" class="form-control" id="confirmpass-modal-password">
                   <small id="confirmPasswordError" class="text-danger"></small>
               </div>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" onclick="cancelarModal()" data-bs-dismiss="modal">Cancelar</button>
           <button type="submit" id="btn-reestablecer-modal-password" class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i> Reestablecer</button>
         </div>
       </div>
     </div>
   </div>
   </form>
   <form action="{{route('updatebandeja')}}" method="post">
    @csrf
        <div class="modal fade" id="modalBandeja" tabindex="-1" aria-labelledby="bandejaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="bandejaModalLabel">Pendientes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="height: 300px">
                            <div class="col-md-12 h-100">
                                <input type="hidden" name="id" value="" class="form-control" id="id-modal-bandeja">
                                <textarea name="bandeja" type="text" maxlength="3000" class="form-control h-100" style="width: 100%; overflow-y: auto;">{{$user->bandeja}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
   </form>
    </main>
    <footer>
    </footer>  
    @stack('scripts')
    {{-- <script>
        function viewUser(){
            let options = document.getElementById('options-user');
            options.style.display = 'block';
        }
        
        function hideUser(){
            let options = document.getElementById('options-user');
            options.style.display = 'none';
        }
        
        document.getElementById('header-user-nav').addEventListener('mouseover',viewUser);
        document.getElementById('header-user-nav').addEventListener('mouseout',hideUser);
        
        document.getElementById('options-user').addEventListener('mouseover',viewUser);
        document.getElementById('options-user').addEventListener('mouseout',hideUser);
    </script> --}}
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>
</html>