<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">Detalles del Vuelo {{ $vuelo->IDVuelo }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Origen:</strong> {{ $vuelo->origen }}</p>
                <p><strong>Fecha y Hora de Salida:</strong> {{ date('d-m-Y H:i', strtotime($vuelo->fechaHraSalida)) }}</p>
                <p><strong>Destino:</strong> {{ $vuelo->destino }}</p>
                <p><strong>Fecha y Hora de Llegada:</strong> {{ date('d-m-Y H:i', strtotime($vuelo->fechaHraLlegada)) }}</p>
                <p><strong>Plazas Disponibles Primera Clase:</strong> {{ $vuelo->plazasPrimeraClase }}</p>
                <p><strong>Plazas Disponibles Ejecutiva:</strong> {{ $vuelo->plazasEjecutiva }}</p>
                <p><strong>Plazas Disponibles Económica:</strong> {{ $vuelo->plazasEconomica }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
     </div>
</div>