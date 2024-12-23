<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            font-size: 10px;
            border: 0.5px solid #000;
            padding: 5px;
            background-color: #f7f7f7;
            width: calc(100% / 6);
        }
        .text-end {
            text-align:right;
        }
        .name-data {
            font-weight: bold; 
        }
        .img-cab {
            width:100% ;
            height: auto;
        }
        .cel-img {
            padding: 0 !important;
        }
        .footerDiv {
            width: 100%;
            text-align: right;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th class="cel-img" colspan="6">
                    <img class="img-cab" src="{{$cabecera}}" alt="">
                </th>
            </tr>
            <tr>
                <th colspan="6"><u>{{$title}}</u></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="1" class="name-data">
                    C&oacute;digo :
                </td>
                <td colspan="3">
                    {{1000000 . $garantia->idGarantia}}
                </td>
                <td colspan="2" class="text-end">
                    {{$garantia->fechaGarantia->translatedFormat('l j F Y')}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Datos Cliente :
                </td>
                <td colspan="4">

                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Nombres :
                </td>
                <td colspan="5">
                    {{$garantia->Cliente->nombre . ' ' . $garantia->Cliente->apellidoPaterno . ' ' . $garantia->Cliente->apellidoMaterno}}
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    {{$garantia->Cliente->TipoDocumento->descripcion}} :
                </td>
                <td colspan="2">
                    {{$garantia->Cliente->numeroDocumento}}
                </td>
                <td colspan="1" class="name-data">
                    Celular :
                </td>
                <td colspan="2">
                    {{$garantia->Cliente->telefono}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    N&uacute;mero de Comprobante :
                </td>
                <td colspan="4">
                    {{$garantia->numeroComprobante}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Datos Producto :
                </td>
                <td colspan="4">

                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Marca :
                </td>
                <td colspan="1">
                    {{$garantia->RegistroProducto->DetalleComprobante->Producto->MarcaProducto->nombreMarca}}
                </td>
                <td colspan="1" class="name-data">
                    Modelo :
                </td>
                <td colspan="3">
                    {{$garantia->RegistroProducto->DetalleComprobante->Producto->modelo}}
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Serie :
                </td>
                <td colspan="5">
                    {{$garantia->RegistroProducto->numeroSerie}}
                </td>
            </tr>
            <tr>
                <td colspan="6" class="name-data">
                    Componentes Recepcionados :
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    {{$garantia->recepcion}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Estado F&iacute;sico :
                </td>
                <td colspan="4">
                    {{$garantia->estado}}
                </td>
            </tr>
            <tr>
                
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Falla Presentada :
                </td>
                <td colspan="4">
                    {{$garantia->falla}}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="footerDiv">
        <img src="{{$firma}}" style="width: 150px" alt="">
    </div>
    <br>
    <br>
    <table>
        <thead>
            <tr>
                <th class="cel-img" colspan="6">
                    <img class="img-cab" src="{{$cabecera}}" alt="">
                </th>
            </tr>
            <tr>
                <th colspan="6"><u>{{$title}}</u></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="1" class="name-data">
                    C&oacute;digo :
                </td>
                <td colspan="3">
                    {{1000000 + $garantia->idGarantia}}
                </td>
                <td colspan="2" class="text-end">
                    {{$garantia->fechaGarantia->translatedFormat('l j F Y')}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Datos Cliente :
                </td>
                <td colspan="4">

                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Nombres :
                </td>
                <td colspan="5">
                    {{$garantia->Cliente->nombre . ' ' . $garantia->Cliente->apellidoPaterno . ' ' . $garantia->Cliente->apellidoMaterno}}
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    {{$garantia->Cliente->TipoDocumento->descripcion}} :
                </td>
                <td colspan="2">
                    {{$garantia->Cliente->numeroDocumento}}
                </td>
                <td colspan="1" class="name-data">
                    Celular :
                </td>
                <td colspan="2">
                    {{$garantia->Cliente->telefono}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    N&uacute;mero de Comprobante :
                </td>
                <td colspan="4">
                    {{$garantia->numeroComprobante}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Datos Producto :
                </td>
                <td colspan="4">

                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Marca :
                </td>
                <td colspan="1">
                    {{$garantia->RegistroProducto->DetalleComprobante->Producto->MarcaProducto->nombreMarca}}
                </td>
                <td colspan="1" class="name-data">
                    Modelo :
                </td>
                <td colspan="3">
                    {{$garantia->RegistroProducto->DetalleComprobante->Producto->modelo}}
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Serie :
                </td>
                <td colspan="5">
                    {{$garantia->RegistroProducto->numeroSerie}}
                </td>
            </tr>
            <tr>
                <td colspan="6" class="name-data">
                    Componentes Recepcionados :
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    {{$garantia->recepcion}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Estado F&iacute;sico :
                </td>
                <td colspan="4">
                    {{$garantia->estado}}
                </td>
            </tr>
            <tr>
                
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Falla Presentada :
                </td>
                <td colspan="4">
                    {{$garantia->falla}}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="footerDiv">
        <img src="{{$firma}}" style="width: 150px" alt="">
    </div>
</body>
</html>