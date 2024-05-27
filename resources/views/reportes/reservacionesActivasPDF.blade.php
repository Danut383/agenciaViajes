<head>
    <title>Reservaciones Activas</title>
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
<h1 class="title">Reservaciones Activas</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>CLIENTE</th>
                <th>SUCURSAL</th>
                <th>FECHA</th>
                <th>ESTADO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservaciones as $reservacion)
                <tr>
                    <td>{{ $reservacion->IDReservacion }}</td>
                    <td>{{ optional($reservacion->cliente)->nombre }}</td>
                    <td class="text-center">{{ $reservacion->sucursal->nombreSucursal }}</td>
                    <td>{{ $reservacion->fechaReservacion }}</td>
                    <td>{{ $reservacion->estado == 1 ? 'ACTIVO' : 'INACTIVO'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>