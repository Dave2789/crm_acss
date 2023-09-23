<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Añadir Permiso</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-6">                                           
                <div class="form-group">
                    <label class="control-label">D&iacute;a</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                        </div>
                        <input type="date" id="vigencia" class="form-control vigencia">
                    </div>
                </div>

            </div>

            <div class="col-md-6">                                           
                <div class="form-group">
                    <label class="control-label">Horas de permiso</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>
                        </div>
                        <input id="qtyhours" type="number" class="form-control" placeholder="0">
                    </div>
                </div>

            </div>

            <div class="col-md-12">                                           
                <div class="form-group">
                    <label class="control-label">Comentario</label>
                    <textarea id="comment" class="form-control" cols="3"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <div class="card-body">
                    <button type="button" class="btn btn-success" id="btn_addPermitionDays" data-id="{!!$pkWorkingPlan!!}"> <i class="fa fa-check"></i> Agregar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="backDays" data-id="{!!$pkWorkingPlan !!}">Regresar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
    </div>
</div>
