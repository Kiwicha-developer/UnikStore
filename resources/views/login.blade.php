<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('storage/logos/logosysredondo.webp')}}" type="image/webp">
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert/sweetalert2.min.css') }}">

    <script src="{{ asset('js/sweetalert/sweetalert2.min.js') }}"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Unik logistika</title>
   <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");
*{
    margin:0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins",sans-serif;
}
body{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: url('{{asset('storage/login-fondo/new-font.jpg')}}')no-repeat;
    background-size: cover;
    background-position: center;
}
.wrapper{
    width: 600px;
    background: transparent;
    border: 2px solid rgba(255, 255, 255, .2);
    backdrop-filter: blur(20px);
    box-shadow: 0 0 10px rgba(0, 0, 0, .2);
    color: #fff;
    border-radius: 10px;
    padding: 30px 40px;
}
.wrapper h1{
    font-size: 36px;
    text-align: center;
}
.wrapper .input-box{
    position: relative;
    width: 100%;
    height: 50px;
    margin: 30px 0;

}
.input-box input{
    width: 100%;
    height: 100%;
    background:  transparent;
    border: none;
    outline: none;
    border: 2px solid rgba(255, 255, 255, .2);
    border-radius: 40px;
    font-size: 16px;
    color: #fff;
    padding: 20px 45px 20px 20px;
}
.input-box input::placeholder{
color: #fff;
}
.input-box i{
position: absolute;
right: 20px;
top: 50%;
transform:translateY(-50%) ;
font-size: 20px;
}
.wrapper .remember-forgot{
    display: flex;
    justify-content: space-between;
    font-size: 14.5px;
    margin: -15px 0 15px;
}
.remember-forgot label input{
    accent-color:#fff ;
    margin-right: 3px;
}
.remember-forgot a{
    color:#fff;
    text-decoration: none;
}
.remember-forgot a:hover{
    text-decoration: underline;
}
.wrapper .btn{
    width: 100%;
    height: 45px;
    background: #fff;
    border: none;
    outline: none;
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    cursor: pointer;
    font-size: 16px;
    color: #333;
    font-weight: 600;
}
.wrapper.register-link{
    font-size: 14.5px;
    text-align: center;
    margin: 20px 0 15px;
}
.register-link p a{
    color: #fff;
    text-decoration: none;
    font-weight: 600;
}
.register-link p a:hover{
    text-decoration: underline;
}
   </style>
</head>
<body>
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