<div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Modificar Promocion</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row pt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Lugares</label>
                        <input type="text" id="places" class="form-control" value="{{ html_entity_decode($PromotionsWorking->cantPlaces) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Descuento</label>
                        <input type="text" id="discount" class="form-control" value="{{$PromotionsWorking->discount }}">
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button class="btn btn-success btn_editPromotion" data-id="{{$PromotionsWorking->pkDiscount_places}}"><span class="ti-check"></span> Modificar</button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>