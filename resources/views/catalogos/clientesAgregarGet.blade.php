<!-- Modal para Agregar Cliente -->
<div class="modal fade" id="modalAgregarCliente" tabindex="-1" aria-labelledby="modalAgregarClienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarClienteLabel">AGREGAR CLIENTE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ url('/catalogos/clientes/agregar') }}">
                        @csrf

                        <div class="row my-4">
                            <div class="form-group mb-3 col-6">
                                <label for="nombre">NOMBRE:</label>
                                <input type="text" maxlength="32" class="form-control" name="nombre" placeholder="Ingrese nombre completo" id="nombre" required autofocus>
                            </div>

                            <div class="form-group mb-3 col-6">
                                <label for="ciudad">CIUDAD:</label>
                                <input type="text" maxlength="30" class="form-control" name="ciudad" placeholder="Ingrese la ciudad" id="ciudad" required>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="form-group mb-3 col-6">
                                <label for="telefono">TELÉFONO:</label>
                                <input type="text" maxlength="32" class="form-control" name="telefono" placeholder="Ingrese el teléfono" id="telefono" required>
                            </div>

                            <div class="form-group mb-3 col-6">
                                <label for="email">EMAIL:</label>
                                <input type="email" maxlength="50" class="form-control" name="email" placeholder="Ingrese el email" id="email" required>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="form-group mb-3 col-6">
                                <label for="estado">ESTADO:</label>
                                <select name="estado" id="estado" class="form-control" required>
                                    <option value="1">ACTIVO</option>
                                    <option value="0">INACTIVO</option>
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