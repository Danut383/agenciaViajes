@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent

    <h1>AGREGAR RESERVACIÓN</h1>
    
    <form id="reservacionForm" action="{{ url('/movimientos/reservaciones/agregar') }}" method="POST" class="container" style="font-size: 21px;">
        @csrf
        <br>
        <!-- SECCIÓN PARA SELECCIÓN DE INFORMACIÓN -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="cliente">CLIENTE:</label>
                    <select class="form-control" id="cliente" name="NIFCliente" required style="font-size: 20px;">
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->NIFCliente }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sucursal">SUCURSAL:</label>
                    <select class="form-control" id="sucursal" name="IDSucursal" required style="font-size: 20px;">
                        @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->IDSucursal }}">{{ $sucursal->nombreSucursal }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fechaReservacion">FECHA DE RESERVACIÓN:</label>
                    <input type="datetime-local" class="form-control" id="fechaReservacion" name="fechaReservacion" required style="font-size: 20px;">
                </div>
            </div>
        </div>

        <!-- SECCIÓN PARA CHECKBOX Y CAMPOS DE VUELO -->
        <div class="row">
            <div class="col-md-6">
                <br>
                <input type="checkbox" id="checkVuelo" name="checkVuelo" value="on" checked style="font-size: 21px;">
                <label for="checkVuelo">REGISTRAR VUELO</label>
                <br><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vuelo">ORIGEN </label>
                            <label for="division" style="margin-left: 32px;">---</label>
                            <label for='destinoV' style="margin-left: 28px;">DESTINO:</label>
                            <select class="form-control" id="IDVuelo" name="IDVuelo" style="font-size: 20px;">
                                <option value="">Seleccione un vuelo</option>
                                @foreach($vuelos as $vuelo)
                                    <option value="{{ $vuelo->IDVuelo }}" data-origen="{{ $vuelo->origen }}" data-destino="{{ $vuelo->destino }}" style="font-size: 20px;">
                                        {{ $vuelo->origen }} / {{ $vuelo->destino }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" id="origen" name="origen" style="font-size: 21px;">
                            <input type="hidden" id="destino" name="destino" style="font-size: 21px;">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="numBoletos">NÚMERO DE BOLETOS:</label>
                        <select class="form-control" id="numBoletos" name="numBoletos" style="width: 72px; margin-left: 114px; font-size: 20px;">
                            @for ($i = 1; $i <= 9; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="fechahoraSalida">FECHA Y HORA DE SALIDA:</label>
                        <input type="datetime-local" class="form-control" id="fechahoraSalida" name="fechahoraSalida" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fechahoraLlegada">FECHA Y HORA DE LLEGADA:</label>
                        <input type="datetime-local" class="form-control" id="fechahoraLlegada" name="fechahoraLlegada" readonly>
                    </div>
                </div>
                <br>
                <div id="boletosContainer" class="row"></div>
                <br>
            </div>

            <!-- SECCIÓN PARA CHECKBOX Y CAMPOS DE HOTEL -->
            <div class="col-md-6">
                <br>
                <input type="checkbox" id="checkHotel" name="checkHotel" checked>
                <label for="checkHotel">REGISTRAR ESTADÍA EN HOTEL</label>
                <br><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hotel">HOTEL:</label>
                            <select class="form-control" id="hotel" name="IDHotel" style="font-size: 20px;">
                                <option value="">Seleccionar hotel</option>
                                @foreach($hoteles as $hotel)
                                    <option value="{{ $hotel->IDHotel }}">{{ $hotel->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="regimenHospedaje">RÉGIMEN DE HOSPEDAJE:</label>
                            <select class="form-control" id="regimenHospedaje" name="IDRegimenHospedaje" style="font-size: 20px;">
                                <option value="">Seleccionar régimen</option>
                                @foreach($regimenesHospedaje as $regimen)
                                    <option value="{{ $regimen->IDRegimenH }}">{{ $regimen->descripcionRegimen }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fechaHoraRegimen">FECHA Y HORA DE INICIO DEL RÉGIMEN:</label>
                            <input type="datetime-local" class="form-control" id="fechaHoraRegimen" name="fechaHoraRegimen" style="font-size: 20px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fechaHoraRegFin">FECHA Y HORA FIN DEL RÉGIMEN:</label>
                            <input type="datetime-local" class="form-control" id="fechaHoraRegFin" name="fechaHoraRegFin" style="font-size: 20px;">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipoHabitacion" style="margin-left: 64px;">TIPO DE HABITACIÓN:</label>
                            <select class="form-control" id="tipoHabitacion" name="tipoHabitacion" style="width: 120px; margin-left: 80px; font-size: 19px;">
                                <option value="single">Individual</option>
                                <option value="double">Doble</option>
                                <option value="family">Familiar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="numeroPersonas">NÚMERO DE PERSONAS:</label>
                            <input type="number" class="form-control" id="numeroPersonas" name="numeroPersonas" min="1" max="5" style="width: 64px; margin-left: 116px; font-size: 20px;">
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">GUARDAR</button>
                </div>
            </div>
        </div>
        

        <br>
        <!-- Catalogar botón para estado y su debido guardar -->
        <div class="row">
            <div class="col-md-12"></div> <!-- Espacio vacío, además se oculta en el siguiente div, con la propiedad agregada de hidden -->
            <div class="col-md-2 hidden">   
                <div class="form-group">
                    <label for="estado">ESTADO:</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option value="1">ACTIVO</option>
                        <option value="0">INACTIVO</option>
                    </select> 
                </div>    
            </div>    
        </div>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const destinoInput = document.getElementById('destino');
        const origenInput = document.getElementById('origen');
        const vueloInput = document.getElementById('IDVuelo');
        const numBoletosSelect = document.getElementById('numBoletos');
        const boletosContainer = document.getElementById('boletosContainer');
        const fechahoraSalidaInput = document.getElementById('fechahoraSalida');
        const fechahoraLlegadaInput = document.getElementById('fechahoraLlegada');
        const checkVuelo = document.getElementById('checkVuelo');
        const checkHotel = document.getElementById('checkHotel');

        var clasesVuelo = @json($clasesVuelo);
        var vuelos = @json($vuelos);

        function generateBoletos(numBoletos) {
            if (boletosContainer) {
                boletosContainer.innerHTML = '';
                if (numBoletos > 0) {
                    for (let i = 0; i < numBoletos; i++) {
                        let boletoCard = document.createElement('div');
                        boletoCard.className = 'col-md-4';
                        let claseOptions = '';
                        clasesVuelo.forEach(function(clase) {
                            claseOptions += `<option value="${clase.IDClaseVuelo}">${clase.descripcionClase}</option>`;
                        });
                        boletoCard.innerHTML = `
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Boleto ${i + 1}</h5>
                                    <div class="form-group">
                                        <label for="boletos_${i}_clase">Clase del Boleto:</label>
                                        <select style="width: 168px; margin-left: -6px;" class="form-control" id="boletos_${i}_clase" name="boletos[${i}][clase]" required>
                                            ${claseOptions}
                                        </select>
                                    </div>
                                    <input type="hidden" id="boletos_${i}_cantidad" name="boletos[${i}][cantidad]" value="1">
                                </div>
                            </div>
                        `;
                        boletosContainer.appendChild(boletoCard);
                    }
                }
            } else {
                console.error('boletosContainer not found');
            }
        }

        function handleVueloToggle() {
            const vueloSelects = document.querySelectorAll('#fechahoraLlegada, #destino, #origen, #fechahoraSalida, #IDVuelo, #numBoletos');
            const numBoletosSelect = document.getElementById('numBoletos');
            if (checkVuelo.checked) {
                vueloSelects.forEach(select => {
                    select.disabled = false;
                    select.required = true;
                });
                if (numBoletosSelect) {
                    numBoletosSelect.value = 1; // Establecer el valor a 1
                    generateBoletos(1); // Generar 1 boleto automáticamente
                }
            } else {
                vueloSelects.forEach(select => {
                    select.disabled = true;
                    select.required = false;
                    select.value = '';
                });
                generateBoletos(0); // Limpiar boletos
            }
        }

        if (checkVuelo) {
            checkVuelo.addEventListener('change', function() {
                handleVueloToggle();
            });
        }

        if (checkHotel) {
            checkHotel.addEventListener('change', handleHotelToggle);
        }

        if (numBoletosSelect) {
            numBoletosSelect.addEventListener('change', function() {
                generateBoletos(parseInt(this.value));
            });
        }

        if (vueloInput) {
            vueloInput.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const IDVuelo = selectedOption.value;
                const origen = selectedOption.getAttribute('data-origen');
                const destino = selectedOption.getAttribute('data-destino');

                if (origen && destino) {
                    origenInput.value = origen;
                    destinoInput.value = destino;
                    fetchHorarios(IDVuelo);
                } else {
                    console.log('Origen o destino no están definidos.');
                }
            });
        }

        handleVueloToggle();
        handleHotelToggle();
    });

    function handleHotelToggle() {
        const hotelSelects = document.querySelectorAll('#hotel, #regimenHospedaje, #fechaHoraRegimen, #fechaHoraRegFin, #tipoHabitacion, #numeroPersonas');
        hotelSelects.forEach(select => {
            select.disabled = !document.getElementById('checkHotel').checked;
            select.required = document.getElementById('checkHotel').checked;
            if (!document.getElementById('checkHotel').checked) {
                select.value = '';
            }
        });
    }

    function fetchHorarios(IDVuelo) {
        fetch(`/movimientos/reservaciones/horarios/${IDVuelo}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                updateFechasHoras(data);
            })
            .catch(error => console.error('Error fetching horarios:', error));
    }

    function updateFechasHoras(horarios) {
        const fechahoraSalidaInput = document.getElementById('fechahoraSalida');
        const fechahoraLlegadaInput = document.getElementById('fechahoraLlegada');
        const fechaHoraRegimenInput = document.getElementById('fechaHoraRegimen');
        const fechaHoraRegFinInput = document.getElementById('fechaHoraRegFin');

        if (fechahoraSalidaInput && fechahoraLlegadaInput) {
            // Convertir fechas a formato datetime-local
            fechahoraSalidaInput.value = new Date(horarios.fechahoraSalida).toISOString().slice(0, 16);
            fechahoraLlegadaInput.value = new Date(horarios.fechahoraLlegada).toISOString().slice(0, 16);
        }

        if (fechaHoraRegimenInput && fechaHoraRegFinInput) {
            // Convertir fechas a formato datetime-local
            fechaHoraRegimenInput.value = new Date(horarios.fechaHoraRegimen).toISOString().slice(0, 16);
            fechaHoraRegFinInput.value = new Date(horarios.fechaHoraRegFin).toISOString().slice(0, 16);
        }
    }


</script>
@endsection
