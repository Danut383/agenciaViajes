@extends("components.layout")
@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => [
        "Inicio" => url("/"),
        "Hoteles" => url("/catalogos/hoteles")
    ]])
    @endcomponent
    <!--Encabezado de la pagina-->
    @include('extras.headerH')  

    <!--SECCIÓN DE ENCABEZADO TABLA-->
    <div class="table-responsive txt-expand">
            <table class="table table-bordered" id="maintable">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">HABITACIONES DISPONIBLES</th>
                        <th scope="col" class="text-center">TELÉFONO</th>
                        <th scope="col" class="text-center">NOMBRE</th>
                        <th scope="col" class="text-center">ESTRELLAS</th>            
                        <th scope="col" class="text-center">CIUDAD</th>
                        <th scope="col" class="text-center action-column" style="width: 20px;">ACCIONES</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hoteles as $hotel)
                        <tr id="row-{{ $loop->index }}" class="{{ $loop->index % 2 == 0 ? 'table-primary' : 'table-secondary' }}">
                            <td class="text-center">{{ $hotel->habitacionesDisponiblesTotales }}</td>
                            <td class="text-center">{{ $hotel->telefono }}</td>
                            <td class="text-center">{{ $hotel->nombre }}</td>
                            <td class="text-center">
                                @for ($i = 0; $i < $hotel->numEstrellas; $i++)
                                    <i><img src="{{ asset('fastar.svg') }}" style="width: 18px; height: 18px;"></i>
                                @endfor
                            </td>
                            <td class="text-center">{{ $hotel->ciudad }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalModificarHotel" data-id="{{ $hotel->IDHotel }}">
                                <img src="{{ asset('editar.png') }}" alt="MOD" style="width: 24px; height: 24px; margin-right: 5px;">
                                </button>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('catalogos.hotelesAgregarGet') 
    
     <!-- Modal para Modificar Hotel -->
     <div class="modal fade" id="modalModificarHotel" tabindex="-1" aria-labelledby="modalModificarHotelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalModificarHotelLabel">MODIFICAR HOTEL</h5>
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
                    { "width": "20px", "targets": 5 }
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
                var hotelId = $(this).data('id');
                
                $.ajax({
                    url: '/catalogos/hoteles/' + hotelId,
                    type: 'GET',
                    success: function(data) {
                        var modalBody = `
                        <form method="POST" action="/catalogos/hoteles/${data.IDHotel}/modificar" style="font-size: 20px;">
                        @csrf
                        @method('POST')

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="${data.nombre}" required style="font-size: 19px;">
                            </div>
                            <div class="col-md-4">
                                <label for="ciudad" class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad" value="${data.ciudad}" required style="font-size: 19px;">
                            </div>
                            <div class="col-md-4">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="${data.telefono}" required style="font-size: 19px;">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="numEstrellas" class="form-label">Número de Estrellas</label>
                                <input type="number" class="form-control" id="numEstrellas" name="numEstrellas" value="${data.numEstrellas}" min="1" max="5" required style="font-size: 19px;">
                            </div>
                            <div class="col-md-4">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required style="font-size: 19px;">
                                    <option value="1" ${data.estado == 1 ? 'selected' : ''}>Activo</option>
                                    <option value="0" ${data.estado == 0 ? 'selected' : ''}>Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="singleRooms" class="form-label">Habitaciones Individuales</label>
                                <input type="number" class="form-control" id="singleRooms" name="singleRooms" value="${data.singleRooms}" required style="font-size: 20px;">
                            </div>
                            <div class="col-md-4">
                                <label for="doubleRooms" class="form-label">Habitaciones Dobles</label>
                                <input type="number" class="form-control" id="doubleRooms" name="doubleRooms" value="${data.doubleRooms}" required style="font-size: 20px;">
                            </div>
                            <div class="col-md-4">
                                <label for="familyRooms" class="form-label">Habitaciones Familiares</label>
                                <input type="number" class="form-control" id="familyRooms" name="familyRooms" value="${data.familyRooms}" required style="font-size: 20px;">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </div>
                    </form>
                        `;
                        $('#modalModificarHotel .modal-body').html(modalBody);
                        $('#modalModificarHotel').modal('show');
                    },
                    error: function() {
                        alert('Error al obtener los datos del hotel.');
                    }
                });
            });
        });
    </script>
@endsection