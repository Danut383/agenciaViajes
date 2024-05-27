{{-- resources/views/reportes/reservacionesActivasPdf.blade.php --}}
<!DOCTYPE html>
<html>
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
<body>
    <h1 class="title">RESERVACIONES DESDE {{ $fecha_inicio }} HASTA {{ $fecha_fin }}</h1>
    <table>
        <thead>
            <tr>
                <th>Folio de reserva</th>
                <th>Cliente</th>
                <th>Fecha de Reservación</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservaciones as $reservacion)  
                <tr>
                    <td>{{ $reservacion->IDReservacion }}</td>
                    <td>{{ $reservacion->cliente->nombre }}</td>
                    <td>{{ $reservacion->fechaReservacion }}</td>
                    <td>{{ $reservacion->estado == 1 ? 'ACTIVO' : 'INACTIVO' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>