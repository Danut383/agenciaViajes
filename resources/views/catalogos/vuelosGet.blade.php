@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => [
        "Inicio" => url("/"),
        "Vuelos" => url("/catalogos/vuelos")
    ]])
    @endcomponent

    <div class="container txt-expand">
        <div class="card mt-4 mb-4 p-3">
            <div class="row my-4 align-items-center">
                <div class="col">
                    <h1 class="text-center">VUELOS</h1>
                </div>
            </div>
            <div class="col">
            <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalAgregarVuelo" style="margin-left: 1142px;">
                <img src="{{ asset('add4.png') }}" alt="MOD">
            </button>
            </div>
        </div>
    </div>

    <div class="table-responsive txt-expand">
        <table class="table table-bordered" id="maintable">
            <thead>
                <tr>
                    <th scope="col" class="text-center" style="width: 64px;">NÚMERO DE VUELO</th>
                    <th scope="col" class="text-center">FECHA Y HORA DE SALIDA</th>
                    <th scope="col" class="text-center">FECHA Y HORA DE LLEGADA</th>
                    <th scope="col" class="text-center action-column" style="width: 20px;">ACCIONES</th>
                    <th scope="col" class="text-center">ORIGEN</th>
                    <th scope="col" class="text-center">DESTINO</th>
                    <th scope="col" class="text-center">ASIENTOS DISPONIBLES</th>
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
                @foreach($vuelos as $vuelo)
                    <tr id="row-{{ $loop->index }}" class="{{ $loop->index % 2 == 0 ? 'table-primary' : 'table-secondary' }}">
                        <td class="text-center">
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <span>{{ $vuelo->IDVuelo }}</span>
                            </div>
                        </td>
                        <td class="text-center">{{ date('d-m-Y H:i', strtotime($vuelo->fechaHraSalida)) }}</td>
                        <td class="text-center">{{ date('d-m-Y H:i', strtotime($vuelo->fechaHraLlegada)) }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalVuelo" data-id="{{ $vuelo->IDVuelo }}">
                                <img src="{{ asset('editar.png') }}" alt="MOD" style="width: 24px; height: 24px; margin-right: 5px;">
                            </button>
                        </td>
                        <td class="text-center">{{ $vuelo->origen }}</td>
                        <td class="text-center">{{ $vuelo->destino }}</td>
                        <td class="text-center">{{ $vuelo->plazasDisponiblesTotales }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal para agregar vuelo-->
    @include('catalogos.vuelosAgregarGet')
    <!-- Modal para editar vuelo-->
    <div class="modal fade" id="modalVuelo" tabindex="-1" aria-labelledby="modalVueloLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVueloLabel">MODIFICAR VUELO</h5>
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
            $.fn.dataTable.ext.type.order['datetime-dd-mm-yyyy-pre'] = function (d) {
                if (!d) {
                    return 0;
                }
                var parts = d.split(' ');
                var date = parts[0].split('-');
                var time = parts[1].split(':');
                return new Date(date[2], date[1] - 1, date[0], time[0], time[1]).getTime();
            };

            var table = $('#maintable').DataTable({
                "order": [],
                "paging": true,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                "pageLength": 5,
                "columnDefs": [
                    {
                        "targets": 0,
                        "render": function(data, type, row) {
                            var idVuelo = $(data).find('span').text().trim();
                            return parseInt(idVuelo);
                        },
                        "type": "num"
                    },
                    { "type": "datetime-dd-mm-yyyy", "targets": [1, 2] },
                    { "type": "string", "targets": [4, 5] },
                    { "type": "num", "targets": 6 },
                    { "width": "20px", "targets": 3 }
                ],
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
                var vueloId = $(this).data('id');
                
                $.ajax({
                    url: '/catalogos/vuelos/' + vueloId,
                    type: 'GET',
                    success: function(data) {
                        var modalBody = `
                        <form method="POST" action="/catalogos/vuelos/${data.IDVuelo}/modificar">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fechaHraSalida" class="form-label">Fecha y Hora de Salida</label>
                                <input type="datetime-local" class="form-control" id="fechaHraSalida" name="fechaHraSalida" value="${data.fechaHraSalida}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="fechaHraLlegada" class="form-label">Fecha y Hora de Llegada</label>
                                <input type="datetime-local" class="form-control" id="fechaHraLlegada" name="fechaHraLlegada" value="${data.fechaHraLlegada}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="origen" class="form-label">Origen</label>
                                <input type="text" class="form-control" id="origen" name="origen" value="${data.origen}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="destino" class="form-label">Destino</label>
                                <input type="text" class="form-control" id="destino" name="destino" value="${data.destino}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="plazasPrimeraClase" class="form-label">Plazas Primera Clase</label>
                                <input type="number" class="form-control" id="plazasPrimeraClase" name="plazasPrimeraClase" value="${data.plazasPrimeraClase}" min="0" max="400" required>
                            </div>
                            <div class="col-md-4">
                                <label for="plazasEjecutiva" class="form-label">Plazas Ejecutiva</label>
                                <input type="number" class="form-control" id="plazasEjecutiva" name="plazasEjecutiva" value="${data.plazasEjecutiva}" min="0" max="400" required>
                            </div>
                            <div class="col-md-4">
                                <label for="plazasEconomica" class="form-label">Plazas Económica</label>
                                <input type="number" class="form-control" id="plazasEconomica" name="plazasEconomica" value="${data.plazasEconomica}" min="0" max="400" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3" style="margin-left: 325px;">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="1" ${data.estado ? 'selected' : ''}>Activo</option>
                                    <option value="0" ${!data.estado ? 'selected' : ''}>Inactivo</option>
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
                        $('#modalVuelo .modal-body').html(modalBody);
                        $('#modalVuelo').modal('show');
                    },
                    error: function() {
                        alert('Error al obtener los datos del vuelo.');
                    }
                });
            });
        });
    </script>
@endsection
