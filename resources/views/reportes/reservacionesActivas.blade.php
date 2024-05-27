@extends('components.layout')
@section('content')
@component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent
    <h1>Reservaciones Activas</h1>
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
                    <td class="text-center">{{ $reservacion->IDReservacion }}</td>
                    <td class="text-center">{{ optional($reservacion->cliente)->nombre }}</td>
                    <td class="text-center">{{ $reservacion->sucursal->nombreSucursal }}</td>
                    <td class="text-center">{{ $reservacion->fechaReservacion }}</td>
                    <td class="text-center">{{ $reservacion->estado == 1 ? 'ACTIVO' : 'INACTIVO' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('grafica-reservaciones-sucursal') }}" class="btn btn-primary">VER GRÁFICA</a>
    <a href="{{ route('download-reservaciones-activas-pdf') }}" class="btn btn-success">DESCARGAR PDF</a>
    
@endsection
