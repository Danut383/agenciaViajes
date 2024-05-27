@extends('components.layout')
@section('content')
@component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent
    <h1>LISTA DE SUCURSALES GENERALES</h1>
    <table class="table">
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
                    <td class="text-center">{{ $sucursal->IDSucursal }}</td>
                    <td class="text-center">{{ $sucursal->nombreSucursal }}</td>
                    <td class="text-center">{{ $sucursal->direccion }}</td>
                    <td class="text-center">{{ $sucursal->ciudad }}</td>
                    <td class="text-center">{{ $sucursal->provincia }}</td>
                    <td class="text-center">{{ $sucursal->estado == 1 ? 'ACTIVO' : 'INACTIVO' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <a href="{{ url('/reportes/sucursales-generales-pdf/view') }}" class="btn btn-primary" style="margin-right: 10px;" target="_blank">VER PDF</a>
        <a href="{{ url('/reportes/sucursales-generales-pdf/download') }}" class="btn btn-success ml-2" style="margin-left: 10px;">DESCARGAR PDF</a>
    </div>
@endsection