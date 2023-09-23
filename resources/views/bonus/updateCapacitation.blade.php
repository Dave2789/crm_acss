<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar capacitaci&oacute;n</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="#">
            <div class="form-body">
                <div class="card-body">
                    <div class="row pt-3 px-3">
                        <div class="col-12 mb-3"><small id="emailHelp" class="form-text text-muted">* Campos obligatorios.</small></div>
                         
                          <div  id="courses">
                              @php $cont = 1;  @endphp
                              @foreach($Bond as $infoBound)
                                              <div class="contentNewOpcion" >
                                                     <button type="button" class="btn btn-danger btn-sm btn_deleteNewCourse float-right"><span class="ti-close"></span></button>
                                                  <div class="row">   
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Curso</label>
                                                    
                                                     <select id="slcCourse" class="form-control custom-select slcCourse"  tabindex="1">
                                                            <option value="-1">Seleccione un curso</option>
                                                        @foreach($courses as $item)
                                                         @if($infoBound->pkCourse == $item->pkCourses)
                                                         <option selected value="{{$item->pkCourses}}">{!!$item->code!!} - {!!$item->name!!}</option>
                                                         @else
                                                          <option value="{{$item->pkCourses}}">{!!$item->code!!} - {!!$item->name!!}</option>
                                                         @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Otro</label>
                                                    <div class="input-group">
                                                        <input type="text" id="other" class="form-control other" value="{!! $infoBound->nameCourse !!}">
                                                        <div class="input-group-append">
                                                          
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                      
                                            
                                             <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Penalizaci&oacute;n *</label>
                                                    <div class="input-group">
                                                        <input type="text" id="penality" class="form-control penality" value="{{ $infoBound->penality }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon11">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                      
                                            <div class="col-md-3">

                                                      <div class="form-group">
                                                          <label class="control-label">Fecha Límite</label>
                                                          <div class="input-group">
                                                              <div class="input-group-prepend">
                                                                  <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                              </div>
                                                              <input type="date" id="date_{{$cont}}" class="form-control date" value="{{ $infoBound->expiration }}">
                                                          </div>
                                                      </div>   
                                                  </div>
                                                      
                                                       <div class="col-md-2">

                                                      <div class="form-group">
                                                          <label class="control-label">Hora Límite</label>
                                                          <div class="input-group">
                                                             <input class="form-control hour" type="time" id="hour_{{$cont}}"  value="{{ $infoBound->expiration_hour }}">
                                                          </div>
                                                      </div>   
                                                  </div>
                                                      
                                              </div>
                                              </div>
                              @php $cont++;  @endphp
                              @endforeach
                                          </div>
                          <input type="hidden" id="count" value="{{$cont}}"/>
                         <div class="col-12">
                                                <div class="form-group">
                                                    <div class="add-user"><button type="button" class="btn btn-secondary" id="addMoreCourses" ><span class="ti-plus"></span> Agregar Más Cursos</button></div>
                                                </div>
                                            </div>

                    </div>

                </div><!--/row-->
            </div>
            <div class="form-actions text-center">
                <div class="card-body">
                    <button type="button" class="btn btn-success" id="btn_addMoreCourses" data-user="{{ $infoBound->fkUser}}" data-id="{{ $infoBound->fkCapacitation}}"> <i class="fa fa-check"></i> Modificar</button>
                </div>
            </div>
    </div>
</form>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
</div>