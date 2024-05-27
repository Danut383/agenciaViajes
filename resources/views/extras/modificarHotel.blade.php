<div class="modal fade" id="exampleModal{{ $hotel->IDHotel }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center justify-content-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">MODIFICAR HOTEL NÚMERO: {{ $hotel->IDHotel }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="post" action="{{ url('/catalogos/hoteles/'.$hotel->IDHotel.'/modificar') }}">
                    @csrf

                    <div class="row my-4">
                        <!-- Columna izquierda -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="nombre">NOMBRE DEL HOTEL:</label>
                                <input type="text" class="form-control w-100" id="nombre" name="nombre" value="{{ $hotel->nombre }}" placeholder="NOMBRE DEL HOTEL" required autofocus>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="ciudad">CIUDAD:</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ $hotel->ciudad }}" placeholder="CIUDAD" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="singleRooms">HABITACIONES INDIVIDUALES:</label>
                                <input type="number" class="form-control" id="singleRooms" name="singleRooms" value="{{ $hotel->singleRooms }}" placeholder="INDIVIDUALES" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="doubleRooms">HABITACIONES DOBLES:</label>
                                <input type="number" class="form-control" id="doubleRooms" name="doubleRooms" value="{{ $hotel->doubleRooms }}" placeholder="DOBLES" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="familyRooms">HABITACIONES FAMILIARES:</label>
                                <input type="number" class="form-control" id="familyRooms" name="familyRooms" value="{{ $hotel->familyRooms }}" placeholder="FAMILIARES" required>
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="telefono">TELÉFONO:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $hotel->telefono }}" placeholder="+52 3121231456" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="estado">ESTADO:</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="1" {{ $hotel->estado == 1 ? 'selected' : '' }}>ESTÁ ACTIVO</option>
                                    <option value="0" {{ $hotel->estado == 0 ? 'selected' : '' }}>ESTÁ INACTIVO</option>
                                </select>
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="numEstrellas">NÚMERO DE ESTRELLAS:</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" id="numEstrellas" value="{{ $hotel->numEstrellas }}" name="numEstrellas" placeholder="1-5" min="1" max="5" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
