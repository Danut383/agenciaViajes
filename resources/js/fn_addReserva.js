document.addEventListener('DOMContentLoaded', function() {
    const destinoInput = document.getElementById('destino');
    const origenInput = document.getElementById('origen');
    const vueloInput = document.getElementById('IDVuelo');
    const respuestaV = document.getElementById('respuestaV');
    const numBoletosSelect = document.getElementById('numBoletos');
    const boletosContainer = document.getElementById('boletosContainer');
    const fechahoraSalidaDisplay = document.getElementById('fechahoraSalidaDisplay');
    const fechahoraLlegadaSelect = document.getElementById('fechahoraLlegada');
    const checkVuelo = document.getElementById('checkVuelo');
    const checkHotel = document.getElementById('checkHotel');
    const reservacionForm = document.getElementById('reservacionForm');

    var clasesVuelo = window.clasesVuelo;
    var vuelos = window.vuelos;

    if (checkVuelo) {
        checkVuelo.addEventListener('change', handleVueloToggle);
    }

    if (checkHotel) {
        checkHotel.addEventListener('change', handleHotelToggle);
    }

    if (numBoletosSelect) {
        numBoletosSelect.addEventListener('change', function() {
            generateBoletos(parseInt(this.value));
        });
    }

    function generateBoletos(numBoletos) {
    const boletosContainer = document.getElementById('boletosContainer');
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

    if (vueloInput) {
        vueloInput.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const IDVuelo = selectedOption.value;
            const origen = selectedOption.getAttribute('data-origen');
            const destino = selectedOption.getAttribute('data-destino');

            if (origen && destino) {
                origenInput.value = origen;
                destinoInput.value = destino;
                fetchHorarios(origen, destino, IDVuelo);
            } else {
                console.log('Origen o destino no están definidos.');
            }

            if (IDVuelo) {
                respuestaV.textContent = `ID Vuelo: ${IDVuelo}`;
            } else {
                respuestaV.textContent = 'No se ha seleccionado un vuelo válido.';
            }
        });
    }

    if (fechahoraLlegadaSelect) {
        fechahoraLlegadaSelect.addEventListener('change', function() {
            updateFechahoraSalida();
        });
    }

    reservacionForm.addEventListener('submit', function(event) {
        console.log('IDVuelo before submit:', vueloInput.value);
    });

    handleVueloToggle();
    handleHotelToggle();
    fetchRoutes();
    generateBoletos(numBoletosSelect ? parseInt(numBoletosSelect.value) || 0 : 0);
});

function handleVueloToggle() {
    const vueloSelects = document.querySelectorAll('#fechahoraLlegada, #destino, #origen, #fechahoraSalida, #IDVuelo, #numBoletos');
    if (document.getElementById('checkVuelo').checked) {
        vueloSelects.forEach(select => {
            select.disabled = false;
            select.required = true;
        });
        if (numBoletosSelect) {
            generateBoletos(parseInt(numBoletosSelect.value || 1));
        }
    } else {
        vueloSelects.forEach(select => {
            select.disabled = true;
            select.required = false;
            select.value = '';
        });
        generateBoletos(0);
    }
}

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

function fetchRoutes() {
    fetch(`/vuelos/routes`)
        .then(response => response.json())
        .then(data => {
            if (vueloInput) {
                vueloInput.innerHTML = '<option value="">Seleccione un vuelo</option>';
                data.forEach(route => {
                    const option = document.createElement('option');
                    option.value = route.IDVuelo;
                    option.text = `${route.origen} / ${route.destino}`;
                    option.setAttribute('data-origen', route.origen);
                    option.setAttribute('data-destino', route.destino);
                    vueloInput.appendChild(option);
                });

                if (vueloInput.options.length > 0) {
                    vueloInput.selectedIndex = 0;
                    vueloInput.dispatchEvent(new Event('change'));
                }
            }
        })
        .catch(error => console.error('Error fetching routes:', error));
}

function fetchHorarios(origen, destino, IDVuelo) {
    fetch(`/vuelos/horarios/${encodeURIComponent(origen)}/${encodeURIComponent(destino)}/${encodeURIComponent(IDVuelo)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
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
    const fechahoraSalidaDisplay = document.getElementById('fechahoraSalidaDisplay');
    const fechahoraLlegadaSelect = document.getElementById('fechahoraLlegada');

    if (fechahoraSalidaDisplay && fechahoraLlegadaSelect) {
        fechahoraSalidaDisplay.dataset.horarios = JSON.stringify(horarios);
        fechahoraLlegadaSelect.innerHTML = '';
        horarios.forEach(horario => {
            const llegadaOption = document.createElement('option');
            llegadaOption.value = horario.fechahoraLlegada;
            llegadaOption.text = horario.fechahoraLlegada;
            fechahoraLlegadaSelect.appendChild(llegadaOption);
        });

        if (fechahoraLlegadaSelect.options.length > 0) {
            fechahoraLlegadaSelect.selectedIndex = 0;
            fechahoraLlegadaSelect.dispatchEvent(new Event('change'));
        }
    } else {
        console.error('Elements not found');
    }
}

function updateFechahoraSalida() {
    const fechahoraSalidaDisplay = document.getElementById('fechahoraSalidaDisplay');
    const fechahoraLlegadaSelect = document.getElementById('fechahoraLlegada');
    const fechahoraSalidaSelect = document.getElementById('fechahoraSalida');

    const selectedLlegada = fechahoraLlegadaSelect.value;
    const horarios = JSON.parse(fechahoraSalidaDisplay.dataset.horarios);

    const selectedHorario = horarios.find(horario => horario.fechahoraLlegada === selectedLlegada);
    if (selectedHorario) {
        fechahoraSalidaDisplay.innerText = selectedHorario.fechahoraSalida;
        if (fechahoraSalidaSelect) {
            fechahoraSalidaSelect.value = selectedHorario.fechahoraSalida;
        }
    }
}

