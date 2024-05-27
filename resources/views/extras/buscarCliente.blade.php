<div class="container">
<div class="card mt-4 mb-4 p-3">
    <div class="row my-4">
        <div class="col">
            <h1>CLIENTES</h1>
        </div>
        <div class="col-auto">
            <form method="GET" action="{{ url('catalogos/clientes') }}" class="form-inline">
                <div class="form-group">
                    <label for="cliente_id" class="mr-2">FILTRAR POR CLIENTE:</label>
                    <select class="form-control" id="cliente_id" name="NIFCliente" onchange="this.form.submit()">
                        <option value="">MOSTRAR TODOS LOS CLIENTES</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->NIFCliente }}" {{ request('NIFCliente') == $cliente->NIFCliente ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="col-auto titlebar-commands">
            <a class="btn btn-primary" href="{{ url('/catalogos/clientes/agregar') }}">AGREGAR</a>
        </div>
    </div>
</div>
</div>