@extends('components.layout')

@section('content')
    @component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @endcomponent
    <div class="container">
        <div class="card mt-4 mb-4 p-3">
            <div class="row">
                <div class="form-group my-3">
                    <h1>MODIFICAR DATOS DEL CIENTE: {{ $cliente->NIFCliente }}</h1>
                </div>
            </div>
        </div>
    </div>
    <form method="post" action="{{ url('/catalogos/clientes/' . $cliente->NIFCliente . '/modificar') }}">
        @csrf <!-- Token CSRF para proteger contra ataques de solicitud de sitios cruzados -->

        <div class="form-group">
            <label for="nombre">NOMBRE:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $cliente->nombre }}" autofocus>
        </div>

        <div class="row my-2">
            <div class="form-group mb-3 col-6">
                <label for="ciudad">CIUDAD:</label>
                <input type="text" name="ciudad" id="ciudad" class="form-control" value="{{ $cliente->ciudad }}">
            </div>

            <div class="form-group mb-3 col-6">
                <label for="telefono">TELÉFONO:</label>
                <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $cliente->telefono }}">
            </div>
        </div>

        <div class="row my-2">
            <div class="form-group mb-3 col-6">
                <label for="email">EMAIL:</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $cliente->email }}">
            </div>

            <div class="form-group mb-3 col-6">
                <label for="estado">ESTADO:</label>
                <select class="form-select" name="estado" id="estado" required>
                    <option value="1" {{ $cliente->estado == 1 ? 'selected' : '' }}>ACTIVO</option>
                    <option value="0" {{ $cliente->estado == 0 ? 'selected' : '' }}>INACTIVO</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col text-center">
                <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
            </div>
        </div>
    </form>
@endsection
