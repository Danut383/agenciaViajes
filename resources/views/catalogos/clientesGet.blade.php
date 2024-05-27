@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => [
        "Inicio" => url("/"),
        "Clientes" => url("/catalogos/clientes")
    ]])
    @endcomponent

    <div class="container txt-expand">
        <div class="card mt-2 mb-4">
            <div class="row my-4 align-items-center">
               
                    <h1 class="text-center" style="margin-top: 32px;">CLIENTES</h1>
           
                <div class="col" >
                    <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalAgregarCliente"style="margin-left: 1142px; width: 96px;">
                        <img src="{{ asset('add4.png') }}" alt="MOD" >
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive txt-expand">
            <table class="table table-bordered" id="maintableC">
                <thead>
                    <tr>
                        <th scope="col">NIF CLIENTE</th>
                        <th scope="col">NOMBRE</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col">TELÉFONO</th>
                        <th scope="col" class="text-center action-column" style="width: 20px;">ACCIONES</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($clientes as $cliente)
                    <tr id="row-{{ $loop->index }}" class="{{ $loop->index % 2 == 0 ? 'table-primary' : 'table-secondary' }}">
                        <td class="text-center">{{ $cliente->NIFCliente }}</td>
                        <td class="text-center">{{ $cliente->nombre }}</td>
                        <td class="text-center">{{ $cliente->email }}</td>
                        <td class="text-center">{{ $cliente->telefono }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalCliente" data-id="{{ $cliente->NIFCliente }}">
                            <img src="{{ asset('editar.png') }}" alt="MOD" style="width: 24px; height: 24px; margin-right: 5px;">
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
                        <!-- Modal registro cliente -->
            @include('catalogos.clientesAgregarGet')

                        <!-- Modal busqueda cliente-->
            <div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="modalClienteLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalClienteLabel">MODIFICAR CLIENTE</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- El contenido del modal se llenará dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .action-column {
            width: 20px !important;
            text-align: center;
        }
    </style>

    <script>
  $(document).ready(function() {
    var table = $('#maintableC').DataTable({
        "order": [],
        "paging": true,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        "pageLength": 5,
        "columnDefs": [
            { "width": "20px", "targets": 4 }
        ],
        "createdRow": function(row, data, dataIndex) {
            if (dataIndex % 2 == 0) {
                $(row).addClass('table-primary');
            } else {
                $(row).addClass('table-secondary');
            }
        },
        "language": {
            "decimal": ",",
            "thousands": ".",
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });

    $('#maintableC thead tr:eq(1) th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" />');
    });

    table.columns().every(function() {
        var that = this;
        $('input', this.header()).on('keyup change', function() {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

    // Evento para abrir el modal y cargar datos con AJAX
    $('#maintableC').on('click', '.btn-edit', function() {
        var clienteId = $(this).data('id');
        
        $.ajax({
            url: '/catalogos/clientes/' + clienteId,
            type: 'GET',
            success: function(data) {
                var modalBody = `
                <form method="POST" action="/catalogos/clientes/${data.NIFCliente}/modificar">
                @csrf
                @method('POST')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="${data.nombre}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="${data.email}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="${data.telefono}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" value="${data.ciudad}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="1" ${data.estado == 1 ? 'selected' : ''}>Activo</option>
                            <option value="0" ${data.estado == 0 ? 'selected' : ''}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </form>
                `;
                $('#modalCliente .modal-body').html(modalBody);
                $('#modalCliente').modal('show');
            },
            error: function() {
                alert('Error al obtener los datos del cliente.');
            }
        });
    });
});
    </script>
@endsection
