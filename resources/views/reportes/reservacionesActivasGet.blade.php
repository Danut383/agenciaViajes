@extends('components.layout')

@section('content')
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent

    <h1>Filtrar Reservaciones por Fecha</h1>
    <form action="{{ route('reportes.reservaciones-por-periodo') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required class="form-control">
        </div>
        <div class="form-group">
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Generar Reporte</button>
    </form>
    
    <a href="{{ route('reportes.reservaciones-activas') }}" class="btn btn-secondary mt-3">Ver Reservaciones Activas</a>
@endsection

