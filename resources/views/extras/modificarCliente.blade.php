<div class="modal fade" id="modalCliente{{ $cliente->NIFCliente }}" tabindex="-1" aria-labelledby="modalClienteLabel{{ $cliente->NIFCliente }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalClienteLabel{{ $cliente->NIFCliente }}">MODIFICAR CLIENTE: {{ $cliente->NIFCliente }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/catalogos/clientes/'.$cliente->NIFCliente.'/modificar') }}">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label for="nombre" class="form-label">NOMBRE:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cliente->nombre }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">CIUDAD:</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ $cliente->ciudad }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">EMAIL:</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $cliente->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">TELÉFONO:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $cliente->telefono }}" required>
                    </div>
                    
                    <div class="mb-3">
                    <label for="estado">Estado:</label>
                        <select class="form-control" name="estado" id="estado" required>
                            <option value="1" {{ $cliente->estado ? 'selected' : '' }}>ACTIVO</option>
                            <option value="0" {{ !$cliente->estado ? 'selected' : '' }}>INACTIVO</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
