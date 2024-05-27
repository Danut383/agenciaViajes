<div class="modal fade" id="modalModificarVuelo{{ $reservacion->IDReservacion }}" tabindex="-1" aria-labelledby="modalModificarVueloLabel{{ $reservacion->IDReservacion }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarVueloLabel{{ $reservacion->IDReservacion }}">MODIFICAR VUELO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('movimientos/reservaciones/' . $reservacion->IDReservacion . '/modificar_vuelo') }}" method="POST">
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
                        <label for="IDVuelo">VUELO:</label>
                        <select class="form-control" id="IDVuelo" name="IDVuelo" required>
                            @foreach ($vuelos as $vuelo)
                                <option value="{{ $vuelo->IDVuelo }}" data-salida="{{ $vuelo->fechaHraSalida }}" data-llegada="{{ $vuelo->fechaHraLlegada }}" {{ $vuelo->IDVuelo == $reservacion->IDVuelo ? 'selected' : '' }}>{{ $vuelo->origen }} - {{ $vuelo->destino }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="fechaHraSalida">FECHA Y HORA DE SALIDA:</label>
                        <input type="datetime-local" class="form-control" id="fechaHraSalida" name="fechaHraSalida" value="{{ \Carbon\Carbon::parse($reservacion->detailReservVueloHotel->fechahoraSalida ?? now())->format('Y-m-d\TH:i') }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="fechaHraLlegada">FECHA Y HORA DE LLEGADA:</label>
                        <input type="datetime-local" class="form-control" id="fechaHraLlegada" name="fechaHraLlegada" value="{{ \Carbon\Carbon::parse($reservacion->detailReservVueloHotel->fechahoraLlegada ?? now())->format('Y-m-d\TH:i') }}" readonly>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const vueloSelect = document.querySelector('#modalModificarVuelo{{ $reservacion->IDReservacion }} #IDVuelo');
        const fechaSalidaInput = document.querySelector('#modalModificarVuelo{{ $reservacion->IDReservacion }} #fechaHraSalida');
        const fechaLlegadaInput = document.querySelector('#modalModificarVuelo{{ $reservacion->IDReservacion }} #fechaHraLlegada');

        vueloSelect.addEventListener('change', function () {
            const selectedOption = vueloSelect.options[vueloSelect.selectedIndex];
            const fechaSalida = selectedOption.getAttribute('data-salida');
            const fechaLlegada = selectedOption.getAttribute('data-llegada');
            
            fechaSalidaInput.value = new Date(fechaSalida).toISOString().slice(0, 16);
            fechaLlegadaInput.value = new Date(fechaLlegada).toISOString().slice(0, 16);
        });
    });
</script>
