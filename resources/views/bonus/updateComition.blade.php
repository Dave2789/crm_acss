<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Comisi&oacute;n</h2>
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
                                <label class="control-label">Menor o igual que*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input type="text" id="less_to" class="form-control" value="{{$Bond->less_to}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Comisi&oacute;n *</label>
                                <div class="input-group">
                                    <input type="text" id="comition_less" class="form-control" value="{{$Bond->comition_less}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon11">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Mayor o igual que  *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input disabled type="text" id="higher_or_equal_to" class="form-control" value="{{$Bond->higher_or_equal_to}}">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Menor o igual que  *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input disabled type="text" id="less_or_equal_to" class="form-control" value="{{$Bond->less_or_equal_to}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Comisi&oacute;n *</label>
                                <div class="input-group">
                                    <input disabled type="text" id="comition_higher_less" class="form-control" value="{{$Bond->comition_higher_less}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon11">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-2 text-center" id="activeComition" style="margin-top:10px">
                            <div class="form-actions mt-3">
                                 <button type="button" class="btn btn-success" id="btn_activeComition">Activar</button>
                             </div>
                        </div>

                        <div class="col-2 text-center" id="desactiveComition" style="margin-top:10px; display:none">
                            <div class="form-actions mt-3">
                                 <button type="button" class="btn btn-success" id="btn_desactiveComition">Desactivar</button>
                             </div>
                        </div>
                        <input type="hidden" value="0" id="isActive">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Mayor que *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input type="text" id="higher_to" class="form-control" value="{{$Bond->higher_to}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Comisi&oacute;n *</label>
                                <div class="input-group">
                                    <input type="text" id="comition_higher" class="form-control" value="{{$Bond->comition_higher}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon11">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        


                    </div>

                </div><!--/row-->
            </div>
            <div class="form-actions text-center">
                <div class="card-body">
                    <button type="button" class="btn btn-success" id="btn_updateComition" data-id="{{$Bond->pkComition }}"> <i class="fa fa-check"></i> Modificar</button>
                </div>
            </div>
    </div>
</form>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
</div>