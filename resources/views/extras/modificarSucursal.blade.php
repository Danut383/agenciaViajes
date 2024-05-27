{{-- extras/modificarSucursal.blade.php --}}
<div class="modal fade" id="modalSucursal{{ $sucursal->IDSucursal }}" tabindex="-1" aria-labelledby="modalSucursalLabel{{ $sucursal->IDSucursal }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSucursalLabel{{ $sucursal->IDSucursal }}">MODIFICAR SUCURSAL: {{ $sucursal->nombreSucursal }}, CON EL CÓDIGO: {{$sucursal->codigoSucursal}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/catalogos/sucursales/'.$sucursal->IDSucursal.'/modificar') }}">
                    @csrf
                    @method('POST')
                    <div class="row my-4">
                        <div class="form-group mb-3 col-md-6">
                            <label for="codigoSucursal{{ $sucursal->IDSucursal }}">Código de Sucursal:</label>
                            <input type="text" class="form-control" name="codigoSucursal" id="codigoSucursal{{ $sucursal->IDSucursal }}" value="{{ $sucursal->codigoSucursal }}" required>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="nombreSucursal{{ $sucursal->IDSucursal }}">Nombre de Sucursal:</label>
                            <input type="text" class="form-control" name="nombreSucursal" id="nombreSucursal{{ $sucursal->IDSucursal }}" value="{{ $sucursal->nombreSucursal }}" required>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="direccion{{ $sucursal->IDSucursal }}">Dirección:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion{{ $sucursal->IDSucursal }}" value="{{ $sucursal->direccion }}" required>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="noExt{{ $sucursal->IDSucursal }}">Número Exterior:</label>
                            <input type="text" class="form-control" name="noExt" id="noExt{{ $sucursal->IDSucursal }}" value="{{ $sucursal->noExt }}" required>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="ciudad{{ $sucursal->IDSucursal }}">Ciudad:</label>
                            <input type="text" class="form-control" name="ciudad" id="ciudad{{ $sucursal->IDSucursal }}" value="{{ $sucursal->ciudad }}" required>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="provincia{{ $sucursal->IDSucursal }}">Provincia:</label>
                            <input type="text" class="form-control" name="provincia" id="provincia{{ $sucursal->IDSucursal }}" value="{{ $sucursal->provincia }}" required>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="estado{{ $sucursal->IDSucursal }}">Estado:</label>
                            <select class="form-control" name="estado" id="estado{{ $sucursal->IDSucursal }}" required>
                                <option value="1" {{ $sucursal->estado ? 'selected' : '' }}>ACTIVO</option>
                                <option value="0" {{ !$sucursal->estado ? 'selected' : '' }}>INACTIVO</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
