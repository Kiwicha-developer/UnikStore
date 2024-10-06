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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                            <h5 class="d-none d-sm-flex justify-content-start align-items-center mb-0 h-100">Unik Technology</h5>
                        </div>
                        <div class="col-4 col-md-2" style="position:relative;z-index:9000">
                            <div class="row h-100 d-flex align-items-center text-end pt-2" id="header-user-nav" style="cursor:pointer">
                                <!--<div class="col-9 d-flex align-items-center text-center pt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{$user->Cargo->descCargo}}">-->
                                    <h5 class="w-100"><i class="bi bi-person-circle"></i> {{$user->user}}</h5>
                                <!--<div class="col-3 d-flex align-items-center text-center">-->
                                <!--    <a href="{{route('login')}}" class="text-decoration-none text-light"><i class="bi bi-box-arrow-left" style="font-size:2rem" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cerrar sesión"></i></a>-->
                                <!--</div>-->
                            </div>
                            <div class="border shadow pt-2 pb-3 rounded-3 bg-light" style="position:absolute;width:100%;left:-10%;z-index:9000;display:none" id="options-user">
                                <div class="row text-dark text-center">
                                    <div class="col-md-12 mt-1">
                                        <small><a class=" text-decoration-none text-secondary link-hover"><i class="bi bi-journal-bookmark-fill" ></i> Pendientes</a></small>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <small><a class="text-decoration-none text-secondary link-hover"><i class="bi bi-arrow-clockwise"></i> Reestablecer Contrase&ntildea</a></small>
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
            <h5 class="d-flex d-sm-none text-light justify-content-start align-items-center mb-0 h-100 w-100">Unik Technology</h5>
            <h5 class="d-none d-sm-flex offcanvas-title text-light">Men&uacute;</h5>
            <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body ">
              <ul class="list-group list-group-flush ">
                  <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('dashboard')}}" class="btn text-light">Dashboard <i class="bi bi-house-fill"></i></a></li>
                  <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('publicaciones',[now()->format('Y-m')])}}" class="btn text-light">Publicaciones <i class="bi bi-megaphone-fill"></i></a></li>
                  <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('calculadora')}}" class="btn text-light">Calculadora <i class="bi bi-calculator"></i></a></li>
                  <li class="list-group-item bg-sistema-uno menu-border">
                      <div class="accordion accordion-flush " id="collapseAlmacen">
                      <div class="accordion-item bg-sistema-uno ">
                          <a class="btn text-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseAlmacen" aria-expanded="false" aria-controls="flush-collapseAlmacen">Almacen <i class="bi bi-boxes"></i></a>
                        <div id="flush-collapseAlmacen" class="accordion-collapse collapse" aria-labelledby="flush-collapseAlmacen" data-bs-parent="#collapseAlmacen">
                            <ul class="list-group list-group-flush">
                              <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('productos',[encrypt(1),encrypt(1)])}}" class="btn text-light fw-light"><em>Productos <i class="bi bi-box-fill"></i></em></a></li>
                              <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('documentos', [now()->format('Y-m')])}}" class="btn text-light fw-light"><em>Registros <i class="bi bi-folder-fill"></i></em></a></li>
                            </ul>
                        </div>
                      </div>
                    </li>
                  <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('plataformas')}}" class="btn text-light">Plataformas <i class="bi bi-shop"></i></a></li>
                  <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('publicidad')}}" class="btn text-light">Web <i class="bi bi-globe"></i></a></li>
                  @if($user->idCargo == 1)
                  <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('usuarios')}}" class="btn text-light">Usuarios <i class="bi bi-person-fill"></i></a></li>
                  <li class="list-group-item bg-sistema-uno menu-border"><a href="{{route('config')}}" class="btn text-light">Configuraci&oacuten <i class="bi bi-gear-fill"></i></a></li>
                  @endif
                </ul>
          </div>
        </div>
    </nav>
    <main class="content">
        @yield('content')
    </main>
    <footer>
    </footer>  
    @stack('scripts')
    <script>
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
    </script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>
</html>