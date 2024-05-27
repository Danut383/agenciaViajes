<div class="modal fade" id="modalModificarReservacion{{ $reservacion->IDReservacion }}" tabindex="-1" aria-labelledby="modalModificarReservacionLabel{{ $reservacion->IDReservacion }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarReservacionLabel{{ $reservacion->IDReservacion }}">MODIFICAR RESERVACIÓN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reservaciones.update', ['IDReservacion' => $reservacion->IDReservacion]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="text-center">DATOS DEL CLIENTE: {{ $reservacion->cliente->NIFCliente }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-4"><strong>CLIENTE:</strong> {{ $reservacion->cliente->nombre }}</div>
                                <div class="col-md-4"><strong>EMAIL:</strong> {{ $reservacion->cliente->email }}</div>
                                <div class="col-md-4"><strong>TELÉFONO:</strong> {{ $reservacion->cliente->telefono }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="sucursal">SUCURSAL:</label>
                        <select class="form-control" id="sucursal" name="IDSucursal" required>
                            @foreach($sucursales as $sucursal)
                                <option value="{{ $sucursal->IDSucursal }}" {{ $sucursal->IDSucursal == $reservacion->IDSucursal ? 'selected' : '' }}>
                                    {{ $sucursal->nombreSucursal }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="fechaReservacion">FECHA DE RESERVACIÓN:</label>
                        <input type="datetime-local" class="form-control" id="fechaReservacion" name="fechaReservacion" value="{{ \Carbon\Carbon::parse($reservacion->fechaReservacion)->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="estado">ESTADO:</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="1" {{ $reservacion->estado == 1 ? 'selected' : '' }}>ACTIVO</option>
                            <option value="0" {{ $reservacion->estado == 0 ? 'selected' : '' }}>INACTIVO</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
