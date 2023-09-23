<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar campaña</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form >
            <div class="form-body">
                <div class="card-body">
                    <div class="row pt-3">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nombre de la Campaña</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-layers"></i></span>
                                    </div>
                                    <input type="text" id="name" class="form-control" value="{!!$campaning->name !!}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Código de la Campaña</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>
                                    </div>
                                    <input type="text" id="code" class="form-control" value="{{$campaning->code}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Agente Encargado</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                                    </div>
                                    <select class="form-control custom-select" id="agentMain" data-placeholder="Selecciona el agente" tabindex="1">
                                        <option value="-1">Selecciona un agente</option>
                                        @foreach($usersQuery as $usersInfo)
                                         @if($campaning->fkUser == $usersInfo->pkUser)
                                         <option selected value="{{$usersInfo->pkUser}}">{{html_entity_decode($usersInfo->full_name)}}</option>
                                         @else
                                          <option value="{{$usersInfo->pkUser}}">{{html_entity_decode($usersInfo->full_name)}}</option>
                                         @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Fecha de Inicio</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                    </div>
                                    <input type="date" id="startDate" class="form-control" value="{{$campaning->start_date}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Fecha Final</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                    </div>
                                    <input type="date" id="endDate" class="form-control" value="{{$campaning->end_date}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tipo</label>
                                <select class="form-control custom-select" id="type" data-placeholder="Selecciona el tipo de Campaña" tabindex="1">
                                    <option value="-1">Selecciona el tipo de campaña</option>
                                    @foreach($typesQuery as $typesInfo)
                                     @if($campaning->fkCampaigns_type == $typesInfo->pkCampaigns_type)
                                     <option selected value="{{$typesInfo->pkCampaigns_type}}">{{html_entity_decode($typesInfo->name)}}</option>
                                     @else
                                       <option value="{{$typesInfo->pkCampaigns_type}}">{{html_entity_decode($typesInfo->name)}}</option>
                                     @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Descripción</label>
                                <textarea class="form-control" id="description" placeholder="Breve descripción de la campaña" cols="3">{!! $campaning->description !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Agentes</label>
                                <select id="agentSecondary" class="form-control" multiple="">
                                    @foreach($usersQuery as $usersInfo)
                                       <?php $band = true; ?>
                                          @foreach($agenByCampaning as $item2)
                                           @if($item2->fkUser == $usersInfo->pkUser)
                                             <option selected value="{{$usersInfo->pkUser}}">{{html_entity_decode($usersInfo->full_name)}}</option>
                                             <?php $band = false; ?>
                                             @endif
                                              @endforeach
                                              @if($band)
                                             <option value="{{$usersInfo->pkUser}}">{{html_entity_decode($usersInfo->full_name)}}</option>
                                           @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div><!--/row-->
                </div>
                <div class="form-actions">
                    <div class="card-body">
                        <button type="button" class="btn btn-success" id="btn_updateCompanydb" data-id="{{ $campaning->pkCommercial_campaigns }}"> <i class="fa fa-check"></i> Modificar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>