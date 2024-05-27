<div class="modal fade" id="modalAgregarHotel" tabindex="-1" aria-labelledby="modalAgregarHotelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarHotelLabel">AGREGAR HOTEL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/catalogos/hoteles/agregar') }}" style="font-size: 18px;">
                    @csrf
                    <div class="row my-4">
                        <div class="form-group mb-3 col-md-6">
                            <label for="nombre">NOMBRE DEL HOTEL:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="NOMBRE DEL HOTEL" required autofocus>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="ciudad">CIUDAD:</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="CIUDAD" required>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="form-group mb-3 col-md-4">
                            <label for="telefono">TELÉFONO:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="+52 3121231456" required>
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="numEstrellas">NÚMERO DE ESTRELLAS:</label>
                            <input type="number" class="form-control" id="numEstrellas" name="numEstrellas" placeholder="1-5" min="1" max="5" required>
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="estado">ESTADO:</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="1">ACTIVO</option>
                                <option value="0">INACTIVO</option>
                            </select>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="form-group mb-3 col-md-4" style="margin-top: -28px;">
                            <label for="singleRooms">HABITACIONES INDIVIDUALES:</label>
                            <input type="number" class="form-control" id="singleRooms" name="singleRooms" placeholder="INDIVIDUALES" required>
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="doubleRooms">HABITACIONES DOBLES:</label>
                            <input type="number" class="form-control" id="doubleRooms" name="doubleRooms" placeholder="DOBLES" required>
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="familyRooms">HABITACIONES FAMILIARES:</label>
                            <input type="number" class="form-control" id="familyRooms" name="familyRooms" placeholder="FAMILIARES" required>
                        </div>
                    </div>
                    <div class="form-group mb-3 text-center">
                        <button type="submit" class="btn btn-primary">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
