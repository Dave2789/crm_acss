<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Subtipo de Actividad</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row pt-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Código</label>
                    <select id="activityTypeEdit" class="form-control" >
                        <option value="-1">Selecciona una Actividade</option>
                        @foreach($activityTypeQuery as $activityTypeInfo)
                         @if($activitySubType->fkActivities_type == $activityTypeInfo->pkActivities_type)
                         <option selected value="{{$activityTypeInfo->pkActivities_type}}">{{html_entity_decode($activityTypeInfo->text)}}</option>
                        @else
                          <option value="{{$activityTypeInfo->pkActivities_type}}">{{html_entity_decode($activityTypeInfo->text)}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Sub actividad</label>
                    <input type="text" id="textEditActivitySubtype" class="form-control" value="{{ html_entity_decode($activitySubType->text)}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Color</label>
                    <input type="color" id="colorEditActivitySubtype" class="form-control" value="{{$activitySubType->color }}">
                </div>
            </div>
            
              <div class="col-md-4 slctypeDiv" id="slctypeDiv2">
                  @if(!empty($activitySubType->status_type))
                         <select id="slctypeCall" class="form-control">
                                <option value="-1">Selecciona tipo de Llamada</option>
                                @if($activitySubType->status_type == 1)
                                <option selected value="1">Enlazada</option>
                                @else
                                 <option value="1">Enlazada</option>
                                @endif
                                
                                 @if($activitySubType->status_type == 1)
                                 <option selected value="2">Fallida</option>
                                @else
                                 <option value="2">Fallida</option>
                                @endif
                               
                         </select>
                  @endif
                    </div>
            
            <div class="col-md-12 text-right">
                <button class="btn btn-success btn_editActivitySubtype" data-id="{{$activitySubType->pkActivities_subtype}}"><span class="ti-check"></span> Modificar</button>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>