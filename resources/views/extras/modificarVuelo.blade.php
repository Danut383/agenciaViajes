<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="modalVueloLabel{{ $vuelo->IDVuelo }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVueloLabel{{ $vuelo->IDVuelo }}">MODIFICAR VUELO NÚMERO: {{ $vuelo->IDVuelo }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{ url('/catalogos/vuelos/'.$vuelo->IDVuelo.'/modificar') }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fechaHraSalida" class="form-label">Fecha y Hora de Salida</label>
                        <input type="datetime-local" class="form-control @error('fechaHraSalida') is-invalid @enderror" id="fechaHraSalida" name="fechaHraSalida" value="{{ $vuelo->fechaHraSalida }}" required>
                        @error('fechaHraSalida')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="fechaHraLlegada" class="form-label">Fecha y Hora de Llegada</label>
                        <input type="datetime-local" class="form-control @error('fechaHraLlegada') is-invalid @enderror" id="fechaHraLlegada" name="fechaHraLlegada" value="{{ $vuelo->fechaHraLlegada }}" required>
                        @error('fechaHraLlegada')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="origen" class="form-label">Origen</label>
                        <input type="text" class="form-control @error('origen') is-invalid @enderror" id="origen" name="origen" value="{{ $vuelo->origen }}" required>
                        @error('origen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="destino" class="form-label">Destino</label>
                        <input type="text" class="form-control @error('destino') is-invalid @enderror" id="destino" name="destino" value="{{ $vuelo->destino }}" required>
                        @error('destino')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="plazasPrimeraClase" class="form-label">Plazas Primera Clase</label>
                        <input type="number" class="form-control @error('plazasPrimeraClase') is-invalid @enderror" id="plazasPrimeraClase" name="plazasPrimeraClase" value="{{ $vuelo->plazasPrimeraClase }}" min="0" required>
                        @error('plazasPrimeraClase')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="plazasEjecutiva" class="form-label">Plazas Ejecutiva</label>
                        <input type="number" class="form-control @error('plazasEjecutiva') is-invalid @enderror" id="plazasEjecutiva" name="plazasEjecutiva" value="{{ $vuelo->plazasEjecutiva }}" min="0" required>
                        @error('plazasEjecutiva')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="plazasEconomica" class="form-label">Plazas Económica</label>
                        <input type="number" class="form-control @error('plazasEconomica') is-invalid @enderror" id="plazasEconomica" name="plazasEconomica" value="{{ $vuelo->plazasEconomica }}" min="0" required>
                        @error('plazasEconomica')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="1" {{ $vuelo->estado ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$vuelo->estado ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
            </div>
        </div>
    </div>
</div>
