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
            width: 100px; /* Ancho fijo para todas las celdas */
            height: 20px; /* Alto fijo para todas las celdas */
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <h3>{{$producto->nombreProducto}}</h3>
    <h3 style="color: #555555">{{$producto->modelo}} (<em>{{$producto->codigoProducto}}</em>)</h3>
    <table>
        <tbody>
            @foreach ($registros as $index => $reg)
                @if ($index % 4 == 0)
                    <tr>
                @endif
                <td>
                    <div>
                        <small>{{ $reg->numeroSerie }}</small>
                    </div>
                    
                </td>
                @if ($index % 4 == 3 || $index == count($registros) - 1)
                    @if ($index % 3 != 3)
                        @for ($i = 0; $i < 3 - ($index % 4); $i++)
                            <td></td>
                        @endfor
                    @endif
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>