<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar notificaciones</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            <div class="row pt-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Título</label>
                        <input type="text" id="title" class="form-control" value="{!!$alert->title!!}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Mensaje</label>
                        <textarea class="form-control" id="message" cols="3"> {!!$alert->comment!!}</textarea>
                    </div>
                </div>
                      <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Agregar un cliente / prospecto</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                            </div>
                            <input autocomplete="off" type="text" data-id="{!! $alert->pkBusiness!!}" value="{!! $alert->name!!}" id="slcBussines" class="autocomplete_bussines form-control" placeholder="Escribe el nombre de la empresa">
                        </div>
                        <div  class="search-header-bussines">
                        </div>
                        <div class="search__border"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Usuarios</label>
                        <select class="form-control" id="users" multiple="">
                           @foreach($usersQuery as $usersInfo)
                              <?php $band = true; ?>
                            @foreach($usersQuerybyNotification as $infoAlert)
                             @if($infoAlert->fkUser_assigned == $usersInfo->pkUser)
                             <option selected value="{!!$usersInfo->pkUser!!}">{!!html_entity_decode($usersInfo->full_name)!!} ({!!html_entity_decode($usersInfo->type_user_name)!!})</option>
                              <?php $band = false; ?>
                             @endif
                              @endforeach
                               @if($band)
                                 <option value="{!!$usersInfo->pkUser!!}">{!!html_entity_decode($usersInfo->full_name)!!} ({!!html_entity_decode($usersInfo->type_user_name)!!})</option>
                               @endif
                           @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-success" id="btn_editAlert" data-id="{!!$alert->pkAlert!!}"><span class="ti-check"></span> Modificar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>