<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('storage/logos/logosysredondo.webp')}}" type="image/webp">
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <script src="{{ asset('js/sweetalert/sweetalert2.min.js') }}"></script>
    <title>Unik logistika</title>

</head>
<body style="background: url('{{asset('storage/login-fondo/new-font.jpg')}}')no-repeat;">
@if(session('alerta'))
    <script>
        Swal.fire({
            title: '¡Usuario no encontrado!',
            text: '{{ session('alerta') }}',
            icon: 'warning',
            iconColor: '#00b1b9',
            confirmButtonText: 'Aceptar',
            customClass: {
                confirmButton: 'btn-primary' // Clase personalizada para el botón de confirmación
            }
        });
    </script>
@endif
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <div class="wrapper pt-0 pe-0 ps-0 pb-0">
                    <div class="row ms-0 me-0">
                        <div class="col-md-6 pt-3 pb-3 text-center">
                            <div class="row text-start ms-2 pe-2">
                                <div class="col-3 ps-0 pe-0">
                                    <img alt="logo" src="{{asset('storage/logos/logosysfondo.webp')}}" style="width:100%">
                                </div>
                                <div class="col-9 d-flex align-items-center">
                                    <h4>Unik Technology</h4>
                                </div>
                            </div>
                            <div class="row ms-2 pe-2">
                                <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                <div class="input-box">
                                    <input type ="text" placeholder="Usuario" name="user" required>
                                </div>
                                <div class="input-box">
                                    <input type ="password" placeholder="Contraseña" name="pass" required>
                                </div>
                                <div class="remember-forgot">
                                       <small class="ms-3">No compartas tu contrase&ntildea !!</small>
                                </div>
                                <button type="submit" class="btn">Ingresar</button>
                            </div>
                        </div>
                        <div class="col-md-6 d-none d-sm-none d-md-block ps-0 pe-0 rounded-end">
                            <img alt="logo" src="{{asset('storage/login/loginbanner.webp')}}" class="rounded-end" style="width:100%">
                        </div>
                        <div class="register-link">
                     
                        <!--</div> -->
                    </div>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>