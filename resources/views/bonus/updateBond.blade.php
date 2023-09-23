<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar bonus base</h2>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Agente *</label>
                                <select id="slcAgent" class="form-control custom-select"  tabindex="1" multiple>
                                   @foreach($agent as $agentInfo)
                                       <?php $band = true; ?>
                                          @foreach($agentBond as $item)
                                           @if($item->fkUser == $agentInfo->pkUser)
                                           <option selected value="{{ $agentInfo->pkUser }}">{!! $agentInfo->full_name!!}</option>
                                             <?php $band = false; ?>
                                             @endif
                                              @endforeach
                                              @if($band)
                                          <option value="{{ $agentInfo->pkUser }}">{!! $agentInfo->full_name!!}</option>
                                           @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Monto Meta *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input type="text" id="montRec"  class="form-control" value="{{$Bond->montRec}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Porcentaje de Bono "Primer Agente" *</label>
                                <div class="input-group">
                                    <input type="text" id="porcentFirst" class="form-control" value="{{$Bond->porcentFirst}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon11">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Porcentaje del Sueldo Base a Obtener *</label>
                                <div class="input-group">
                                    <input type="text" id="porcentBon" class="form-control" value="{{$Bond->porcentBon}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon11">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Monto m&iacute;nimo *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input type="text" id="montMin" class="form-control" value="{{$Bond->montMin}}">
                                </div>
                            </div>
                        </div>

                       <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Porcentaje de penalizaci&oacute;n *</label>
                                <div class="input-group">
                                    <input type="text" id="porcentPenalty" class="form-control" value="{{$Bond->porcentPenalty}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon11">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div><!--/row-->

                        <h4 class="title-section">Penalizaci&oacute;n</h4>
                                            <div class="agents" id="agents">
                                                @foreach($penalty as $penaltyInfo)
                                               <div class="Addagents row">
                                                    <div class="col-md-12"><button type="button" class="btn btn-danger btn-sm btn_deleteNewCourseOportunity float-right" data-id="4"><span class="ti-close"></span></button></div>
                                                 <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                           <label class="control-label">Agente*</label>
                                                                <select class="form-control custom-select slcAgent" multiple data-placeholder="Elige Categoría" tabindex="1">
                                                                      
                                                                        @foreach($agent as $item)
                                                                         @if($penaltyInfo->fkUser == $item->pkUser)
                                                                         <option selected value="{{$item->pkUser}}">{!!$item->full_name!!}</option>
                                                                         @else 
                                                                         <option value="{{$item->pkUser}}">{!!$item->full_name!!}</option>
                                                                         @endif
                                                                        @endforeach
                                                                    </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                            <label class="control-label">Porcentaje de Penalizaci&oacute;n *</label>
                                                            <div class="input-group">
                                                            <input type="text" value="{{$penaltyInfo->penality }}" class="form-control porcentPenalty">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon11">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        
                    </div>
            </div>
            <div class="form-actions text-center">
                <div class="card-body">
                    <button type="button" class="btn btn-success" id="btn_updateBondBase" data-id="{{$Bond->pkBond_base }}"> <i class="fa fa-check"></i> Modificar</button>
                </div>
            </div>
    </div>
</form>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
</div>