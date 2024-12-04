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
        }
        th, td {
            border: 0.5px solid #000;
            font-size: 10px;
            text-align: center;
            padding: 5px;
        }
        th {
            background-color: #ffffff;
        }

        .header{
            background-color: #dddddd;
        }

        .index{
            width: 10px;
        }
    </style>
</head>
<body>
    <h3>{{ $title }}</h3>
    <table>
        <thead>
            <tr>
                <th class="index header">#</th>
                <th class="header">Codigo</th>
                <th class="header">Modelo</th>
                @foreach ($almacenes as $almacen)
                <th class="header">{{$almacen->descripcion}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $count = 1;
            @endphp
            @foreach ($productos as $producto)
                <tr>
                    <th class="index">{{$count}}</th>
                    <th>{{$producto->codigoProducto}}</th>
                    <th>{{$producto->modelo}}</th>
                    @foreach ($producto->Inventario->sortBy('idAlmacen') as $inventario)
                        <th>{{$inventario->stock}}</th>
                    @endforeach
                </tr>
                @php
                    $count ++;
                @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>