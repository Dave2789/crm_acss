<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Contacto</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div id="addContentContact">
            <div class="contentNewContact row px-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Nombres y Apellidos</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" id="nameContactw" class="form-control nameContact" value="{!!$contact->name!!}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Cargo / Puesto</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-medall"></i></span>
                            </div>
                            <input type="text" id="cargow" class="form-control cargo" value="{!!$contact->area!!}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Correo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-email"></i></span>
                            </div>
                            <input type="email" id="emailw" class="form-control email" value="{!!$contact->mail!!}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Teléfono fijo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-headphone-alt"></i></span>
                            </div>
                            <input type="text" id="phonew" class="form-control phone" placeholder="Incluir código de área" value="{!!$contact->phone!!}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Extensión</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-plus"></i></span>
                            </div>
                            <input type="text" id="extensionw" class="form-control extension" value="{!!$contact->extension!!}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Teléfono móvil</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-mobile"></i></span>
                            </div>
                            <input type="text" id="celw" class="form-control cel" value="{!!$contact->mobile_phone!!}">
                        </div>
                    </div>
                </div>
                  <button type="button" class="btn btn-primary float-right btnUpdateContactDB" data-id="{!!$contact->pkContact_by_business!!}"> Modificar</button>
            </div>  
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-secondary float-right" id="btn_returnContact" data-id="{!!$contact->fkBusiness!!}"> regresar</button>
    </div>
</div>