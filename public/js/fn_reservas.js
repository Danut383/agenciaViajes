document.addEventListener('DOMContentLoaded', function() {
    generateBoletos(1); // Generar una tarjeta por defecto al cargar la página
    setupOrigenDestino();
    restoreSelections(); // Restaurar las selecciones de origen y destino si existen
});



document.getElementById('numBoletos').addEventListener('change', function() {
    var numBoletos = parseInt(this.value);
    generateBoletos(numBoletos);
});

function generateBoletos(numBoletos) {
    var boletosContainer = document.getElementById('boletosContainer');
    boletosContainer.innerHTML = '';
    for (var i = 0; i < numBoletos; i++) {
        var boletoCard = document.createElement('div');
        boletoCard.className = 'col-md-4';
        var claseOptions = '';
        clasesVuelo.forEach(function(clase) {
            claseOptions += `<option value="${clase.IDClaseVuelo}">${clase.descripcionClase}</option>`;
        });
        boletoCard.innerHTML = `
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Boleto ${i + 1}</h5>
                    <div class="form-group">
                        <label for="boletos_${i}_clase">Clase del Boleto:</label>
                        <select class="form-control" id="boletos_${i}_clase" name="boletos[${i}][clase]" required>
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
