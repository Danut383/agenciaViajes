{{-- resources/views/reportes/indexGet.blade.php --}}
@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent

    <div class="row my-4">
        <div class="col">
            <h1>Reportes</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <a href="{{ url('/reportes/sucursales-clientes') }}" class="btn-menu text-center" >Reporte Gráfico de Sucursales y Clientes</a>
            </div>

            <div class="col-md-4 mb-3">
                <a href="{{ url('/reportes/sucursales-generales') }}" class="btn-menu text-center">Reporte Sucursales Activas</a>
            </div>

            <div class="col-md-4 mb-3">
                <a href="{{ url('/reportes/reservaciones-por-periodo') }}" class="btn-menu text-center">Reporte de Reservaciones por Periodo</a>
            </div>

            <div class="col-md-4 mb-3">
                <a href="{{ url('/reportes/reservaciones-activas') }}" class="btn-menu text-center">Reporte de Reservaciones Activas</a>
            </div>

        </div>
    </div>
@endsection
