{{-- resources/views/reportes/resultadoReservaciones.blade.php --}}
@extends('components.layout')

@section('content')
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent

    <h1>RESERVACIONES DESDE {{ $fecha_inicio }} HASTA {{ $fecha_fin }}</h1>
    <table class="table">
        <thead>
            <tr>
                <th>FOLIO RESERVACIÓN</th>
                <th>CLIENTE</th>
                <th>FECHA DE RESERVACIÓN</th>
                <th>ESTADO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservaciones as $reservacion)
                <tr>
                    <td class="text-center">{{ $reservacion->IDReservacion }}</td>
                    <td class="text-center">{{ optional($reservacion->cliente)->nombre }}</td>
                    <td class="text-center">{{ $reservacion->fechaReservacion }}</td>
                    <td class="text-center">{{ $reservacion->estado == 1 ? 'ACTIVO' : 'INACTIVO' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="d-flex justify-content-center">
        <a href="{{ route('reportes.reservaspdf.view', ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin]) }}" class="btn btn-primary" style="margin-right: 10px;" target="_blank">VER PDF</a>
        <a href="{{ route('reportes.descargar-pdf', ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin]) }}" class="btn btn-success ml-2" style="margin-left: 10px;">DESCARGAR PDF</a>
    </div>
@endsection