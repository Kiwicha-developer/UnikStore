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
    <h3>{{ $title }}</h3>
    <table>
        <tbody>
            @foreach ($series as $index => $serie)
                @if ($index % 4 == 0)
                    <tr>
                @endif
                <td>{{ $serie }}</td>
                @if ($index % 4 == 3 || $index == count($series) - 1)
                    @if ($index % 4 != 3)
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