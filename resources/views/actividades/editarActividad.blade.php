<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Actividades</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form >
            <div class="row pt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Empresa</label>
                        <select class="form-control custom-select" id="activityBusiness" data-placeholder="Selecciona una empresa" tabindex="1">
                            <option value="-1">Selecciona una empresa</option>
                            @foreach($businessQuery as $businessInfo)
                             @if($activity->fkBusiness == $businessInfo->pkBusiness)
                             <option selected value="{{$businessInfo->pkBusiness}}">{{html_entity_decode($businessInfo->name)}}</option>
                            @else
                              <option value="{{$businessInfo->pkBusiness}}">{{html_entity_decode($businessInfo->name)}}</option>
                            @endif
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Negocios abiertos</label>
                        <select class="form-control custom-select" id="type_event_business" data-placeholder="Selecciona el tipo de negocio" tabindex="1">
                            {!!$option!!}
                            
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Agente</label>
                        <select class="form-control custom-select" id="userAgent" data-placeholder="Selecciona el Agente" tabindex="1">
                            <option value="-1">Seleccionar agente</option>
                            @foreach($usersQuery as $usersInfo)
                             @if($activity->fkUser == $usersInfo->pkUser)
                             <option selected value="{{$usersInfo->pkUser}}">{{html_entity_decode($usersInfo->full_name)}} ({{html_entity_decode($usersInfo->type_name)}})</option>
                             @else
                              <option value="{{$usersInfo->pkUser}}">{{html_entity_decode($usersInfo->full_name)}} ({{html_entity_decode($usersInfo->type_name)}})</option>
                             @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Tipo de Actividad</label>
                        <select class="form-control custom-select" id="type_activity" data-placeholder="Selecciona la Actividad" tabindex="1">
                            <option value="-1">Selecciona el tipo de actividad</option>
                            @foreach($activitiesTypeQuery as $activitiesTypeInfo)
                            @if($activity->fkActivities_type == $activitiesTypeInfo->pkActivities_type)
                            <option selected value="{{$activitiesTypeInfo->pkActivities_type}}">{!!$activitiesTypeInfo->text!!}</option>
                            @else
                             <option value="{{$activitiesTypeInfo->pkActivities_type}}">{!!$activitiesTypeInfo->text!!}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Texto</label>
                        <textarea class="form-control" cols="3" id="description"  placeholder="Descripción de la actividad">{!!$activity->description!!}</textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" >Fecha</label>
                        <input type="date" id="date" class="form-control" value="{{$activity->final_date}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" >Hora</label>
                        <input type="time" id="hour" class="form-control" value="{{$activity->final_hour}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Adjuntar documento</label>
                        <div class="custom-file">
                            
                            <input type="file" id="document" class="custom-file-input" id="customFileLang" lang="es">
                            <label class="custom-file-label form-control" for="customFileLang">Seleccionar Archivo</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-success" id="btn_updateActivity" data-id="{{$activity->pkActivities}}"><span class="ti-check"></span> Modificar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>