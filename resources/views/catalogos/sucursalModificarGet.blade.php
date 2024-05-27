{{-- resources/views/catalogos/sucursalModificarGet.blade.php --}}
@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent
    <div class="container">
        <div class="card mt-4 mb-4 p-3">
        <div class="row">
            <div class="form-group my-3">
                <h1>MODIFICAR SUCURSAL NÚMERO: {{$sucursal->IDSucursal}}</h1>
            </div>
        </div>
    </div>
    </div>
    <form method="post" action="{{ url('/catalogos/sucursales/'.$sucursal->IDSucursal.'/modificar') }}">
        @csrf
        @method('POST') <!-- Esto especifica que el formulario realiza una solicitud POST -->

        <div class="row my-4">
            <div class="form-group mb-3 col-md-6">
                <label for="codigoSucursal">Código de Sucursal:</label>
                <input type="text" class="form-control" name="codigoSucursal" id="codigoSucursal" value="{{ $sucursal->codigoSucursal }}" required>
            </div>
            <div class="form-group mb-3 col-md-6">
                <label for="nombreSucursal">Nombre de Sucursal:</label>
                <input type="text" class="form-control" name="nombreSucursal" id="nombreSucursal" value="{{ $sucursal->nombreSucursal }}" required>
            </div>
            <div class="form-group mb-3 col-md-6">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" name="direccion" id="direccion" value="{{ $sucursal->direccion }}" required>
            </div>
            <div class="form-group mb-3 col-md-6">
                <label for="noExt">Número Exterior:</label>
                <input type="text" class="form-control" name="noExt" id="noExt" value="{{ $sucursal->noExt }}" required>
            </div>
            <div class="form-group mb-3 col-md-6">
                <label for="ciudad">Ciudad:</label>
                <input type="text" class="form-control" name="ciudad" id="ciudad" value="{{ $sucursal->ciudad }}" required>
            </div>
            <div class="form-group mb-3 col-md-6">
                <label for="provincia">Provincia:</label>
                <input type="text" class="form-control" name="provincia" id="provincia" value="{{ $sucursal->provincia }}" required>
            </div>
            <div class="form-group mb-3 col-md-6">
                <label for="estado">Estado:</label>
                <select class="form-control" name="estado" id="estado" required>
                    <option value="1" {{ $sucursal->estado ? 'selected' : '' }}>ACTIVO</option>
                    <option value="0" {{ !$sucursal->estado ? 'selected' : '' }}>INACTIVO</option>
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

