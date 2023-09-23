<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Actividad</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
   <div class="row datos-e">
                                    <div class="col-md-6 dat1">
                                        <label class="control-label ">Empresa:</label>
                                        <p class="form-control-static">{!!$activitiesQuery->name_business !!}</p>
                                    </div>
                                    <div class="col-md-6 dat1">
                                        <label class="control-label ">Agente:</label>
                                        <p class="form-control-static">{!!$activitiesQuery->full_name !!}</p>
                                    </div>
                                    <div class="col-md-6 dat1">
                                        <label class="control-label ">Tipo de Actividad:</label>
                                        <p class="form-control-static">{!!$activitiesQuery->text !!}</p>
                                    </div>
                                    <div class="col-md-6 dat1">
                                        <label class="control-label ">Fecha:</label>
                                        <p class="form-control-static">{{$activitiesQuery->final_date }} </p>
                                    </div>
                                    <div class="col-md-6 dat1">
                                        <label class="control-label ">Hora:</label>
                                        <p class="form-control-static">{{$activitiesQuery->final_hour }}</p>
                                    </div>
                                    <div class="col-md-6 dat1">
                                        <label class="control-label ">Descripcion:</label>
                                        <p class="form-control-static">{!!$activitiesQuery->description !!}</p>
                                    </div>
                                   <!-- <div class="col-md-6 dat1">
                                        <label class="control-label ">Documento:</label>
                                        <p class="form-control-static"><a href="">Ver</a></p>
                                    </div>-->
                                    <hr>
                                     <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Comentario</label>
                            <textarea class="form-control" cols="3" id="description"></textarea>
                        </div>
                    </div>
                                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">¿Como finalizo la actividad?</label>
                            <div class="color-act">
                                @foreach($SubActivity as $subActivity)
                                <label class="btn" style="background-color:{{$subActivity->color}};">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="subtype_{{$subActivity->pkActivities_subtype}}" name="subActivity" value="{{$subActivity->pkActivities_subtype}}" class="custom-control-input">
                                        <label class="custom-control-label" for="subtype_{{$subActivity->pkActivities_subtype}}">{!!$subActivity->text!!}</label>
                                    </div>
                                </label>
                               @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button class="btn btn-success btn_finishDB" data-id="{{ $activitiesQuery->pkActivities }}"><span class="ti-check"></span> Finalizar</button>
                    </div>
                                    
            
                                </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>