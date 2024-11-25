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
        <thead>
            <tr>
                <th></th>
            </tr>
        </thead>
    </table>
</body>
</html>