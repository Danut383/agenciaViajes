{{-- resources/views/movimientos/reservacionesGet.blade.php --}}
@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent
    
    <div class="container">
        <div class="card mt-4 mb-4 p-3">
            <div class="d-flex justify-content-between align-items-center my-4">
                <div>
                    <h1>RESERVACIONES</h1>
                </div>
                <div><br>
                    <a class="btn btn-edit" href="{{ url('movimientos/reservaciones/agregar') }}">
                    <img src="{{ asset('add4.png') }}" alt="MOD" >
                    </a>
                </div>
            </div>
        </div>

        <!-- Tabla de reservaciones -->
        <div class="table-responsive">
            <table class="table txt-expand" id="maintable">
                <thead>
                    <tr>
                        <th scope="col" class="col-1 text-center">CLIENTE</th>
                        <th scope="col" class="col-2 text-center">SUCURSAL</th>
                        <th scope="col" class="col-1 text-center">ORIGEN DE VUELO</th>
                        <th scope="col" class="col-2 text-center">DESTINO DE VUELO</th>
                        <th scope="col" class="col-1 text-center">BOLETOS</th>
                        <th scope="col" class="col-2 text-center">HOTEL</th>
                        <th scope="col" class="col-1 text-center">TIPO HABITACIÓN</th>
                        <th scope="col" class="col-1 text-center">NÚMERO PERSONAS</th>
                        <th scope="col" class="col-2 text-center">REGISTRO PARA RESERVACIÓN</th>
                        <th scope="col" class="col-2 text-center">MODIFICAR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservaciones as $reservacion)
                        <tr>
                            <td class="text-center col-1">{{ $reservacion->cliente->nombre ?? 'NO DEFINIDO' }}</td>
                            <td class="text-center col-2">{{ $reservacion->sucursal->nombreSucursal ?? 'NO DEFINIDO' }}</td>
                            <td class="text-center col-1">{{ $reservacion->detailReservVueloHotel->vuelo->origen ?? 'NO RESERVÓ' }}</td>
                            <td class="text-center col-2">{{ $reservacion->detailReservVueloHotel->vuelo->destino ?? 'NO RESERVÓ' }}</td>
                            <td class="text-center col-1">
                                @if($reservacion->detailReservVueloHotel && $reservacion->detailReservVueloHotel->boletos)
                                    <a class="btn btn-outline-primary btn-md" href="#" data-bs-toggle="modal" data-bs-target="#boletosModal{{ $reservacion->IDReservacion }}" style="width: 52px;">
                                        {{ count(json_decode($reservacion->detailReservVueloHotel->boletos)) }} 
                                    </a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="boletosModal{{ $reservacion->IDReservacion }}" tabindex="-1" aria-labelledby="boletosModalLabel{{ $reservacion->IDReservacion }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="boletosModalLabel{{ $reservacion->IDReservacion }}">Detalles de Boletos</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @foreach (json_decode($reservacion->detailReservVueloHotel->boletos) as $boleto)
                                                        <p>Boleto de {{ $boleto->cantidad }}x {{ $clasesVuelo[$boleto->clase]->descripcionClase ?? 'Clase no definida' }}</p>
                                                    @endforeach
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    0
                                @endif
                            </td>
                            <td class="text-center col-2">{{ $reservacion->detailReservVueloHotel->hotel->nombre ?? 'NO RESERVÓ' }}</td>
                            <td class="text-center col-1">
                                @php
                                    $tipoHabitacion = $reservacion->detailReservVueloHotel->tipoHabitacion ?? 'NO RESERVÓ';
                                    $tipoHabitacionMap = [
                                        'single' => 'INDIVIDUAL',
                                        'double' => 'DOBLE',
                                        'family' => 'FAMILIAR'
                                    ];
                                @endphp
                                {{ $tipoHabitacionMap[$tipoHabitacion] ?? $tipoHabitacion }}
                            </td>
                            <td class="text-center col-1">{{ $reservacion->detailReservVueloHotel->numeroPersonas ?? '0' }}</td>
                            <td class="text-center col-2">{{ \Carbon\Carbon::parse($reservacion->fechaReservacion)->format('d-m-Y H:i') }}</td>
                            <td class="text-center col-2">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalModificarReservacion{{ $reservacion->IDReservacion }}"><strong>RESERVA</strong></button>
                                    @if($reservacion->detailReservVueloHotel && $reservacion->detailReservVueloHotel->IDVuelo)
                                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalModificarVuelo{{ $reservacion->IDReservacion }}"><strong>VUELO</strong></button>
                                    @endif
                                    @if($reservacion->detailReservVueloHotel && $reservacion->detailReservVueloHotel->IDHotel)
                                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalModificarHotel{{ $reservacion->IDReservacion }}"><strong>HOTEL</strong></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @include('movimientos.reservacionesModificarGet', ['reservacion' => $reservacion, 'clientes' => $clientes, 'sucursales' => $sucursales])
                        @include('movimientos.reservacionVueloModificarGet', ['reservacion' => $reservacion, 'vuelos' => $vuelos, 'clasesVuelo' => $clasesVuelo])
                        @include('movimientos.reservacionesHotelModificarGet', ['reservacion' => $reservacion, 'hoteles' => $hoteles, 'regimenesHospedaje' => $regimenesHospedaje])
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts para DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <style>
        .table thead th:nth-child(odd),
        .table tbody td:nth-child(odd) {
            background-color: #e9ecef;
        }
        .table thead th:nth-child(even),
        .table tbody td:nth-child(even) {
            background-color: #f8f9fa;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#maintable').DataTable({
                "paging": true,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                "pageLength": 5,
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
        });
    </script>
@endsection
