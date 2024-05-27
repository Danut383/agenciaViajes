<!DOCTYPE html>
<html>
<head>
    <title class="title">SUCURSALES GENERALES</title>
    <style>
        .title {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 class="title">SUCURSALES GENERALES</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>DIRECCIÓN</th>
                <th>CIUDAD</th>
                <th>PROVINCIA</th>
                <th>ESTADO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sucursales as $sucursal)
                <tr>
                    <td>{{ $sucursal->IDSucursal }}</td>
                    <td>{{ $sucursal->nombreSucursal }}</td>
                    <td>{{ $sucursal->direccion }}</td>
                    <td>{{ $sucursal->ciudad }}</td>
                    <td>{{ $sucursal->provincia }}</td>
                    <td>{{ $sucursal->estado == 1 ? 'ACTIVO' : 'INACTIVO' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
