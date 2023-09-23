<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Añadir D&iacute;as festivos</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="col-md-12">                                           

            <div class="row">
                <div class="col-md-12" id="addContentOPcionDay">

                </div>

                <div class="col-12">
                    <div class="form-group">
                        <div class="add-user"><button type="button" class="btn btn-secondary" id="addDayFestive"><span class="ti-plus"></span> Agregar d&iacute;a festivo</button></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <div class="card-body">
                <button type="button" class="btn btn-success" id="btn_addFestiveDays" data-id="{!!$pkWorkingPlan!!}"> <i class="fa fa-check"></i> Agregar</button>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="backDaysFestive" data-id="{!!$pkWorkingPlan !!}">Regresar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
    </div>
</div>
