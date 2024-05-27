
@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent

    <div class="row my-4">
        <div class="col">
            <h1>Reporte de Sucursales y Clientes</h1>
        </div>
    </div>

    <table class="table" id="maintable">
        <thead>
            <tr>
                <th>Nombre del Cliente</th>
                <th>Nombre de la Sucursal</th>
                <th>ID del Vuelo</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha y Hora de Salida</th>
                <th>Fecha y Hora de Llegada</th>
                <th>Clase</th>
                <th>Estado del Vuelo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reporte as $item)
            <tr>
                <td>{{ $item->nombre_cliente }}</td>
                <td>{{ $item->nombre_sucursal }}</td>
                <td>{{ $item->IDVuelo }}</td>
                <td>{{ $item->origen }}</td>
                <td>{{ $item->destino }}</td>
                <td>{{ $item->fechaHraSalida }}</td>
                <td>{{ $item->fechaHraLlegada }}</td>
                <td>{{ $item->IDClaseVuelo }}</td>
                <td>{{ $item->estado == 1 ? 'Activo' : 'Inactivo' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection