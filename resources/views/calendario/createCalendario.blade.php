<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Crear Actividad</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
            <div class="row pt-3">
                <div class="col-12 mb-3"><small id="emailHelp" class="form-text text-muted">* Campos obligatorios.</small></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Empresa *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                            </div>
                            <select class="form-control custom-select" id="activityBusiness" data-placeholder="Selecciona una empresa" tabindex="1">
                                <option value="-1">Selecciona una empresa</option>
                                @foreach($businessQuery as $businessInfo)
                                <option value="{{$businessInfo->pkBusiness}}">{{html_entity_decode($businessInfo->name)}}</option>
                                @endforeach
                            </select>
                        </div>                                                
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Negocios abiertos *</label>
                        <select class="form-control custom-select" id="type_event_business" data-placeholder="Selecciona el tipo de negocio" tabindex="1">
                            <option value="-1">Selecciona el tipo de negocio</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Agente *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                            </div>
                            <select class="form-control custom-select" id="userAgent" data-placeholder="Selecciona el Agente" tabindex="1">
                                <option value="-1">Seleccionar agente</option>
                                @foreach($usersQuery as $usersInfo)
                                <option value="{{$usersInfo->pkUser}}">{{html_entity_decode($usersInfo->full_name)}} ({{html_entity_decode($usersInfo->type_name)}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Tipo de Actividad *</label><br>
                        <select class="form-control custom-select" id="type_activity" data-placeholder="Selecciona la Actividad" tabindex="1">
                            <option value="-1">Selecciona el tipo de actividad</option>
                            @foreach($activitiesTypeQuery as $activitiesTypeInfo)
                            <option value="{{$activitiesTypeInfo->pkActivities_type}}">{!!$activitiesTypeInfo->text!!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Texto *</label>
                        <textarea style="resize:auto" class="form-control" rows="3" id="description" placeholder="Descripción de la actividad"></textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" >Fecha</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                            </div>
                            <input type="date" id="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" >Hora</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-time"></i></span>
                            </div>
                            <input type="time" id="hour" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Adjuntar documento</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-image"></i></span>
                            </div>
                            <div class="custom-file">
                                <input type="file" id="document" class="custom-file-input" id="customFileLang" lang="es">
                                <label class="custom-file-label form-control" for="customFileLang">Seleccionar Archivo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button class="btn btn-success" id="createActivityModal"><span class="ti-check"></span> Crear</button>
                </div>
            </div>
    </div>
</div>    
