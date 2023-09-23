<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Nivel de Interés</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row pt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Texto</label>
                    <input type="text" id="textEditLevelInterest" class="form-control" value="{{ html_entity_decode($level->text) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Color</label>
                    <input type="color" id="colorEditLevelInterest" class="form-control" value="{{$level->color }}">
                </div>
            </div>
            <div class="col-md-12 text-right">
                <button class="btn btn-success btn_editLevelInterest" data-id="{{$level->pkLevel_interest}}"><span class="ti-check"></span> Modificar</button>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>