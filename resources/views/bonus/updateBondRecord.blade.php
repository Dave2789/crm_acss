<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Bono Record</h2>
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
                                <label class="control-label">Monto meta a romper *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input type="text" id="montMet" class="form-control" value="{{$Bond->montMet }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Porcentaje a repartir *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input type="text" id="montRep" class="form-control" value="{{$Bond->montRep }}">
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-md-2">
                            <label class="control-label">Tipo *</label>
                            <select id="slcTypeMont" class="form-control custom-select"  tabindex="1">
                                @if($Bond->slcTypeMont == 1)
                                <option selected value="1">Porcentaje %</option>
                                @else
                                <option value="1">Porcentaje %</option>
                                @endif
                                
                                 @if($Bond->slcTypeMont == 2)
                                 <option selected value="2">Monto $</option>
                                @else
                                <option value="2">Monto $</option>
                                @endif
                                
                            </select>
                        </div>-->

                    </div>

                </div><!--/row-->
            </div>
            <div class="form-actions text-center">
                <div class="card-body">
                    <button type="button" class="btn btn-success" id="btn_updateBondRecord" data-id="{{$Bond->pkBound_record }}"> <i class="fa fa-check"></i> Modificar</button>
                </div>
            </div>
    </div>
</form>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
</div>