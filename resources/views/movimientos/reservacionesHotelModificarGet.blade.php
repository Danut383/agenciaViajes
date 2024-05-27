<div class="modal fade" id="modalModificarHotel{{ $reservacion->IDReservacion }}" tabindex="-1" aria-labelledby="modalModificarHotelLabel{{ $reservacion->IDReservacion }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarHotelLabel{{ $reservacion->IDReservacion }}">MODIFICAR HOTEL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rhotel.update', ['IDReservacion' => $reservacion->IDReservacion]) }}" method="POST">
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
                        <label for="IDHotel">HOTEL:</label>
                        <select class="form-control" id="IDHotel" name="IDHotel" required>
                            @foreach($hoteles as $hotel)
                                <option value="{{ $hotel->IDHotel }}" {{ $reservacion->detailReservVueloHotel && $hotel->IDHotel == $reservacion->detailReservVueloHotel->IDHotel ? 'selected' : '' }}>
                                    {{ $hotel->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="IDRegimenHospedaje">RÉGIMEN DE HOSPEDAJE:</label>
                        <select class="form-control" id="IDRegimenHospedaje" name="IDRegimenHospedaje" required>
                            @foreach($regimenesHospedaje as $regimen)
                                <option value="{{ $regimen->IDRegimenH }}" {{ $reservacion->detailReservVueloHotel && $regimen->IDRegimenH == $reservacion->detailReservVueloHotel->IDRegimenHospedaje ? 'selected' : '' }}>
                                    {{ $regimen->descripcionRegimen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="horaRegimen">HORA DE INICIO DE HOSPEDAJE:</label>
                        <input type="time" class="form-control" id="horaRegimen" name="horaRegimen" value="{{ $reservacion->detailReservVueloHotel ? \Carbon\Carbon::parse($reservacion->detailReservVueloHotel->fechaHoraRegimen)->format('H:i') : '' }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="horaRegFin">HORA DE FIN DE HOSPEDAJE:</label>
                        <input type="time" class="form-control" id="horaRegFin" name="horaRegFin" value="{{ $reservacion->detailReservVueloHotel ? \Carbon\Carbon::parse($reservacion->detailReservVueloHotel->fechaHoraRegFin)->format('H:i') : '' }}" required>
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
