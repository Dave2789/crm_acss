<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Giro</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row pt-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Nombre</label>
                    <input type="text" id="nameEditCommercialBusiness" class="form-control" value="{{ html_entity_decode($Commercial_business->name) }}">
                </div>
            </div>
            <div class="col-md-12 text-right">
                <button class="btn btn-success btn_editCommercialBusiness" data-id="{{$Commercial_business->pkCommercial_business }}" ><span class="ti-check"></span> Modificar</button>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>