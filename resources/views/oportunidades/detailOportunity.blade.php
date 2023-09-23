<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Detalle de la Oportunidad de Negocio</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="c-act">
            <p>Cantidad de Empleados: <strong>{!!$oportunity->number_employees !!}</strong></p>
            <p>Cursos Interesados: <strong>{!!$oportunity->number_courses !!}</strong></p>
            <div class=" mb-4">
                Última actividad: 
                @if(!empty($oportunity->lastActivity))
                <span> {!!$oportunity->lastActivity!!} </span>
                @else
                <span>-</span>
                @endif
            </div>
            <div>
                Siguiente tarea:
                @if(!empty($oportunity->nextActivity))
                <span>   {!!$oportunity->nextActivity!!} </span>
                @else
                <span>N/A</span>
                @endif
                <div>
                    Vencimiento:
                    @if(!empty($oportunity->finalActivity))
                    <span>{!!$oportunity->finalActivity!!} </span>
                    @else
                    <span>-</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>