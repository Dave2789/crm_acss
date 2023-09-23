<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Tipo de Actividad</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row pt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Texto</label>
                    <input type="text" id="textEditActivityType" class="form-control" value="{{ html_entity_decode($activityType->text) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Color</label>
                    <input type="color" id="colorEditActivityType" class="form-control" value="{{ html_entity_decode($activityType->color) }}">
                </div>
            </div>
            <div class="col-md-6">
                        <label class="control-label">Ícono</label>
                        <div class="icons-show card">
                            <div class="icon-list-demo row">
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-mobile"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-email"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-headphone-alt"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-light-bulb"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-trash"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-user"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-link"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-desktop"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-star"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-settings"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-calendar"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-time"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-pencil"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-briefcase"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-book"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-wallet"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-pin-alt"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-star"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-lock"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-eye"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-location-arrow"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-search"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-folder"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-write"></i></button></div>
                            </div>
                        </div>
                    </div>
            <div class="col-md-12 text-right">
                <button class="btn btn-success btn_editActivityType" data-id="{{$activityType->pkActivities_type }}"><span class="ti-check"></span> Modificar</button>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>