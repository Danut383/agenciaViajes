{{-- resources/views/reportes/reservacionesPorPeriodo.blade.php --}}
@extends('components.layout')

@section('content')
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent

    <div class="container">
    <div class="card mt-4 mb-4 p-3">
        <h1>Filtrar Reservaciones por Fecha</h1>
    </div>
</div>
<br>
    <form action="{{ route('reportes.reservaciones-por-periodo') }}" method="POST">
    @csrf
    <div class="form-group row justify-content-center">
        <div class="col-md-4">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required class="form-control">
        </div>
    </div>
    <div class="form-group row justify-content-center">
        <div class="col-md-4">
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required class="form-control">
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-4 text-center">
            <button type="submit" class="btn btn-primary">Generar Reporte</button>
        </div>
    </div>
</form>

@endsection