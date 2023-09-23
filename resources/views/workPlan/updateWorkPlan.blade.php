<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar plan de trabajo</h2>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Agente *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                                                        </div>
                                                        <select id="slcAgent" class="form-control custom-select" data-placeholder="Elige Categoría" tabindex="1">
                                                        <option value="-1">Selecciona un agente</option>
                                                        @foreach($agent as $item)
                                                         @if($daysWorking->fkUser == $item->pkUser)
                                                         <option selected value="{!!$item->pkUser!!}">{!!$item->full_name!!}</option>
                                                         @else
                                                         <option value="{!!$item->pkUser!!}">{!!$item->full_name!!}</option>
                                                         @endif
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Llamadas por hora *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-timer"></i></span>
                                                        </div>
                                                        <input type="text" id="callsPerHour" class="form-control" value="{!!$daysWorking->qtyCallsHour !!}">
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Porcentaje Mínimo de Llamadas enlazadas *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-stats-up"></i></span>
                                                        </div>
                                                        <input type="text" id="callsLinked" class="form-control" value="{!!$daysWorking->callsLinked !!}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon11">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Porcentaje Máximo de Llamadas Fallidas *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-stats-down"></i></span>
                                                        </div>
                                                        <input type="text" id="callsFaild" class="form-control" value="{!!$daysWorking->callsFaild !!}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon11">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Porcentaje de Penalizaci&oacute;n *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-face-sad"></i></span>
                                                        </div>
                                                        <input type="text" id="penalty" class="form-control" value="{!!$daysWorking->penalty !!}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon11">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Monto base *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                        </div>
                                                        <input type="text" id="montBase" class="form-control" value="{!!$daysWorking->montBase !!}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Tipo de cambio *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                        </div>
                                                        <input type="text" id="typeChange" class="form-control" value="{!!$daysWorking->typeChange !!}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Moneda *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-target"></i></span>
                                                        </div>
                                                        <select id="slctypeCurrency" class="form-control custom-select" data-placeholder="Selecciona el Giro de la empresa" tabindex="1">
                                                            <option value="-1">Selecciona una modena</option>
                                                            @foreach($currency as $item)
                                                             @if($daysWorking->typeCurrency == $item->CurrencyISO)
                                                             <option selected value="{!!$item->CurrencyISO!!}">{!!$item->CurrencyName!!} </option>
                                                             @else
                                                               <option  value="{!!$item->CurrencyISO!!}">{!!$item->CurrencyName!!} </option>
                                                             @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 text-center">
                                                <div class="form-actions">
                                                    <div class="card-body">
                                                        <button type="button" class="btn btn-success" id="btn_updateWorkPlan" data-id="{!! $daysWorking->pkWorkplan !!}"> <i class="fa fa-check"></i> Modificar</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div><!--/row-->
                                </div>
                        </div>
</form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>