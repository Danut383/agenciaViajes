<div class="modal fade" id="modalAgregarSucursal" tabindex="-1" aria-labelledby="modalAgregarSucursalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarSucursalLabel">AGREGAR SUCURSAL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ url('/catalogos/sucursales/agregar') }}" style="font-size: 18px;">
                        @csrf
                        <div class="row my-4">
                            <div class="form-group mb-3 col-md-6">
                                <label for="codigoSucursal">Código de Sucursal:</label>
                                <input type="number" class="form-control" name="codigoSucursal" id="codigoSucursal" value="{{ $ultimoCodigo }}" min="{{ $ultimoCodigo }}" required autocomplete="off">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="nombreSucursal">Nombre de Sucursal:</label>
                                <input type="text" class="form-control" name="nombreSucursal" id="nombreSucursal" value="{{ old('nombreSucursal') }}" required>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" name="direccion" id="direccion" value="{{ old('direccion') }}" required>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="noExt">Número Exterior:</label>
                                <input type="text" class="form-control" name="noExt" id="noExt" value="{{ old('noExt') }}" required>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="ciudad">Ciudad:</label>
                                <input type="text" class="form-control" name="ciudad" id="ciudad" value="{{ old('ciudad') }}" required>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="provincia">Provincia:</label>
                                <input type="text" class="form-control" name="provincia" id="provincia" value="{{ old('provincia') }}" required>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="estado">Estado:</label>
                                <select class="form-control" name="estado" id="estado" required>
                                    <option value="1" {{ old('estado') == 1 ? 'selected' : '' }}>ACTIVO</option>
                                    <option value="0" {{ old('estado') == 0 ? 'selected' : '' }}>INACTIVO</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary">GUARDAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
