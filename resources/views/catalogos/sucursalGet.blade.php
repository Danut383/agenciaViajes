@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent
<div class="container">
<div class="card mt-4 mb-4 p-3">    
    <div class="row my-4">
        <div class="col text-center">
            <h1>SUCURSALES</h1>
        </div>

        <div class="col-auto titlebar-commands">
            <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalAgregarSucursal">
            <img src="{{ asset('add4.png') }}" alt="MOD" >
            </button>
        </div>
    </div>
</div>
</div>

    <div class="table-responsive">
        <table class="table table-bordered txt-expand" id="maintable">
            <thead>
                <tr>
                    <th scope="col">CÓDIGO</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">DIRECCIÓN</th>
                    <th scope="col">CIUDAD</th>
                    <th scope="col">PROVINCIA</th>
                    <th scope="col">ESTADO</th>
                    <th scope="col">ACCIONES</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($sucursales as $sucursal)
                    <tr id="row-{{ $loop->index }}" class="{{ $loop->index % 2 == 0 ? 'table-primary' : 'table-secondary' }}">
                        <td class="text-center">{{ $sucursal->codigoSucursal }}</td>
                        <td class="text-center">{{ $sucursal->nombreSucursal }}</td>
                        <td class="text-center">{{ $sucursal->direccion }} {{ $sucursal->noExt }}</td>
                        <td class="text-center">{{ $sucursal->ciudad }}</td>
                        <td class="text-center">{{ $sucursal->provincia }}</td>
                        <td class="text-center">{{ $sucursal->estado ? 'DISPONIBLE' : 'NO DISPONIBLE' }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-edit" style="font-size: 16px;" data-bs-toggle="modal" data-bs-target="#modalModificarSucursal" data-id="{{ $sucursal->IDSucursal }}">
                            <img src="{{ asset('editar.png') }}" alt="MOD" style="width: 24px; height: 24px; margin-right: 5px;">
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal para Agregar Sucursal -->
    @include('catalogos.sucursalAgregarGet')

    <!-- Modal para Modificar Sucursal -->
    <div class="modal fade" id="modalModificarSucursal" tabindex="-1" aria-labelledby="modalModificarSucursalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalModificarSucursalLabel">MODIFICAR SUCURSAL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- El contenido del modal se llenará dinámicamente -->
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
            var table = $('#maintable').DataTable({
                "order": [],
                "paging": true,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                "pageLength": 5,
                "columnDefs": [
                    { "width": "20px", "targets": 6 }
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

            $('#maintable thead tr:eq(1) th').each(function() {
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
            $('#maintable').on('click', '.btn-edit', function() {
                var sucursalId = $(this).data('id');
                
                $.ajax({
                    url: '/catalogos/sucursales/' + sucursalId,
                    type: 'GET',
                    success: function(data) {
                        var modalBody = `
                        <form method="POST" action="/catalogos/sucursales/${data.IDSucursal}/modificar" style="font-size: 18px;">
                        @csrf
                        @method('POST')

                        <div class="row my-4">
                            <div class="form-group mb-3 col-md-6">
                                <label for="codigoSucursal">Código de Sucursal:</label>
                                <input type="text" class="form-control" name="codigoSucursal" id="codigoSucursal" value="${data.codigoSucursal}" required style="font-size: 20px;">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="nombreSucursal">Nombre de Sucursal:</label>
                                <input type="text" class="form-control" name="nombreSucursal" id="nombreSucursal" value="${data.nombreSucursal}" required style="font-size: 20px;">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" name="direccion" id="direccion" value="${data.direccion}" required style="font-size: 19px;">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="noExt">Número Exterior:</label>
                                <input type="text" class="form-control" name="noExt" id="noExt" value="${data.noExt}" required style="font-size: 20px;">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="ciudad">Ciudad:</label>
                                <input type="text" class="form-control" name="ciudad" id="ciudad" value="${data.ciudad}" required style="font-size: 20px;">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="provincia">Provincia:</label>
                                <input type="text" class="form-control" name="provincia" id="provincia" value="${data.provincia}" required style="font-size: 20px;">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="estado">Estado:</label>
                                <select class="form-control" name="estado" id="estado" required style="font-size: 20px;">
                                    <option value="1" ${data.estado == 1 ? 'selected' : ''}>ACTIVO</option>
                                    <option value="0" ${data.estado == 0 ? 'selected' : ''}>INACTIVO</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
                            </div>
                        </div>
                    </form>
                        `;
                        $('#modalModificarSucursal .modal-body').html(modalBody);
                        $('#modalModificarSucursal').modal('show');
                    },
                    error: function() {
                        alert('Error al obtener los datos de la sucursal.');
                    }
                });
            });
        });
    </script>
@endsection
