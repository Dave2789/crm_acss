<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Usuario</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="row">
        <div class="col-12">
            <!-- Crear Empresa -->
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <select class="form-control custom-select" id="typeGroupUser" data-placeholder="Selecciona la Actividad" tabindex="1">
                                    <option value="-1">
                                        Selecciona grupo de usuario
                                    </option>
                                    @if($user->fkUser_type == 1)
                                    <option selected value="1">Super Administrador</option>
                                    <option  value="2">Usuario</option>
                                    @else
                                    <option  value="1">Super Administrador</option>
                                    <option selected value="2">Usuario</option>
                                    @endif
                                   
                                </select>
                            </div>
                        </div>
                        @if($user->fkUser_type == 1)
                        <div class="row pt-3" id="permitionUser" style="display: none;">
                            @else
                             <div class="row pt-3" id="permitionUser" style="display: block;">
                            @endif

                            <div class="col-md-12 pt-3">
                                <h4 class="title-section">Permisos de usuarios</h4>
                            </div>

                            <div class="col-md-12">
                                <select class="form-control custom-select" id="typeUser" data-placeholder="Selecciona la Actividad" tabindex="1">
                                    <option value="-1">
                                        Selecciona tipo de usuario
                                    </option>
                                    @foreach($typeUser as $typeUserInfo)
                                     @if($typeUserInfo->pkUser_type == $user->fkUser_type)
                                    <option selected value="{!!$typeUserInfo->pkUser_type!!}">{!!$typeUserInfo->name!!}</option>
                                    @else
                                     <option value="{!!$typeUserInfo->pkUser_type!!}">{!!$typeUserInfo->name!!}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 m-t-20">
                                <p>Selecciona las secciones que podrá ver el usuario que estás creando</p>
                            </div>

                            <div class="col-12">
                              <div class="row pt-3">
                                <div class="col-md-4">
                                    <div class="permit">
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                @if($permition->dashboard == 1)
                                                <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="dashboard" data-id="dashboard" data-children="-1">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="dashboard" data-id="dashboard" data-children="-1">
                                                @endif
                                                <label class="custom-control-label" for="dashboard">Dashboard</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->pipeline == 1)
                                                 <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="pipeline" data-id="pipeline" data-children="-1">
                                                @else
                                                   <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="pipeline" data-id="pipeline" data-children="-1">
                                                @endif
                                                <label class="custom-control-label" for="pipeline">Pipeline</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->notification == 1)
                                                 <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="notification" data-id="notification" data-children="-1">
                                                @else
                                                  <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="notification" data-id="notification" data-children="-1">
                                                @endif
                                                <label class="custom-control-label" for="notification">Notificaciones</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->companySearch == 1)
                                               <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="bussinesSearch" data-id="companySearch" data-children="-1">
                                                @else
                                               <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="bussinesSearch" data-id="companySearch" data-children="-1">
                                                @endif
                                                <label class="custom-control-label" for="bussinesSearch">Buscador de empresas</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                @if($permition->sendMail == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="sendMail" data-id="sendMail" data-children="-1">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="sendMail" data-id="sendMail" data-children="-1">
                                                @endif
                                                <label class="custom-control-label" for="sendMail">Env&iacute;o de correos</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="permit">
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->admin->workplan->addWorkplan == 1
                                                    ||$permition->admin->workplan->viewWorkplan == 1
                                                    ||$permition->admin->workplan->deleteWorkplan == 1
                                                    ||$permition->admin->configBonus == 1
                                                    ||$permition->admin->sales == 1
                                                    ||$permition->admin->activity == 1
                                                    ||$permition->admin->config == 1)
                                                  <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="admin" data-id="admin" data-children="1">
                                                @else
                                                  <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="admin" data-id="admin" data-children="1">
                                                @endif
                                                <label class="custom-control-label" for="admin">Admin</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->admin->workplan->addWorkplan == 1
                                                    ||$permition->admin->workplan->viewWorkplan == 1
                                                    ||$permition->admin->workplan->deleteWorkplan == 1)
                                                <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="workplan" data-id="workplan" data-parent="admin" data-children="2"> 
                                                @else
                                                   <input  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="workplan" data-id="workplan" data-parent="admin" data-children="2"> 
                                                @endif
                                                <label class="custom-control-label" for="workplan">Plan de trabajo</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->admin->workplan->addWorkplan == 1)
                                                   <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addWorkplan" data-id="addWorkplan" data-parent="workplan" data-children="0">
                                                @else
                                                  <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addWorkplan" data-id="addWorkplan" data-parent="workplan" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="addWorkplan">Crear plan de trabajo</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->admin->workplan->viewWorkplan == 1)
                                                   <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewWorkplan" data-id="viewWorkplan" data-parent="workplan" data-children="0">
                                                @else
                                                  <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewWorkplan" data-id="viewWorkplan" data-parent="workplan" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="viewWorkplan">Ver plan de trabajo</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->admin->workplan->deleteWorkplan == 1)
                                                   <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteWorkplan" data-id="deleteWorkplan" data-parent="workplan" data-children="0">
                                                @else
                                                  <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteWorkplan" data-id="deleteWorkplan" data-parent="workplan" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="deleteWorkplan">Eliminar plan de trabajo</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->admin->configBonus == 1)
                                                  <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="configBonus" data-id="configBonus" data-parent="admin" data-children="0">
                                                @else
                                                  <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="configBonus" data-id="configBonus" data-parent="admin" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="configBonus">Configuraci&oacute;n de bonos</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->admin->sales == 1)
                                                 <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="sales" data-id="sales" data-parent="admin" data-children="0">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="sales" data-id="sales" data-parent="admin" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="sales">Ventas por agente</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->admin->activity == 1)
                                                   <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="activity" data-id="activity" data-parent="admin" data-children="0">
                                                @else
                                                   <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="activity" data-id="activity" data-parent="admin" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="activity">Actividad</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->admin->config == 1)
                                                 <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="config" data-id="config" data-parent="admin" data-children="0">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="config" data-id="config" data-parent="admin" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="config">Configuraci&oacute;n</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="permit">
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->calendar->viewCalendar == 1
                                                    ||$permition->calendar->addActivity == 1)
                                                <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="calendar" data-id="calendar" data-children="1">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="calendar" data-id="calendar" data-children="1">
                                                @endif
                                                <label class="custom-control-label" for="calendar">Calendario</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->calendar->viewCalendar == 1)
                                                <input  checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewCalendar" data-id="viewCalendar" data-parent="calendar" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewCalendar" data-id="viewCalendar" data-parent="calendar" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="viewCalendar">Ver actividades</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->calendar->addActivity == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addActivity" data-id="addActivity" data-parent="calendar" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addActivity" data-id="addActivity" data-parent="calendar" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="addActivity">A&ntilde;adir actividad</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="permit">
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->bussines->quotes->viewQuotes == 1
                                                     || $permition->bussines->quotes->money == 1
                                                     || $permition->bussines->quotes->invoice == 1
                                                     || $permition->bussines->quotes->editQuotes == 1
                                                     || $permition->bussines->quotes->changeQuotes == 1
                                                     || $permition->bussines->quotes->deleteQuotes == 1
                                                     || $permition->bussines->opportunities->viewOpportunities == 1
                                                     || $permition->bussines->opportunities->editOpportunities == 1
                                                     || $permition->bussines->opportunities->changeOpportunities == 1
                                                     || $permition->bussines->opportunities->deleteOpportunities == 1
                                                     )
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="negocios" data-id="bussines" data-children="1">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="negocios" data-id="bussines" data-children="1">
                                                @endif
                                                <label class="custom-control-label" for="negocios">Negocios</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                @if($permition->bussines->quotes->viewQuotes == 1
                                                     || $permition->bussines->quotes->money == 1
                                                     || $permition->bussines->quotes->invoice == 1
                                                     || $permition->bussines->quotes->editQuotes == 1
                                                     || $permition->bussines->quotes->changeQuotes == 1
                                                     || $permition->bussines->quotes->deleteQuotes == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="quotes" data-id="quotes" data-parent="bussines" data-children="2">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="quotes" data-id="quotes" data-parent="bussines" data-children="2">
                                                @endif
                                                <label class="custom-control-label" for="quotes">Cotizaciones</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->bussines->quotes->viewQuotes == 1)
                                                 <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewQuotes" data-id="viewQuotes" data-parent="quotes" data-children="0">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewQuotes" data-id="viewQuotes" data-parent="quotes" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="viewQuotes">Ver cotizaciones</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->bussines->quotes->money == 1)
                                                  <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="money" data-id="money" data-parent="quotes" data-children="0">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="money" data-id="money" data-parent="quotes" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="money">Validar dinero en cuenta</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->bussines->quotes->invoice == 1)
                                                   <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="invoice" data-id="invoice" data-parent="quotes" data-children="0">
                                                @else
                                                  <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="invoice" data-id="invoice" data-parent="quotes" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="invoice">Facturar cotizaci&oacute;n</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->bussines->quotes->editQuotes == 1)
                                                 <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editQuotes" data-id="editQuotes" data-parent="quotes" data-children="0">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editQuotes" data-id="editQuotes" data-parent="quotes" data-children="0">
                                                @endif
                                                
                                                <label class="custom-control-label" for="editQuotes">Editar</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->bussines->quotes->changeQuotes == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="changeQuotes" data-id="changeQuotes" data-parent="quotes" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="changeQuotes" data-id="changeQuotes" data-parent="quotes" data-children="0">
                                                @endif
                                              
                                                <label class="custom-control-label" for="changeQuotes">Cambiar estatus</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                @if($permition->bussines->quotes->deleteQuotes == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteQuotes" data-id="deleteQuotes" data-parent="quotes" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteQuotes" data-id="deleteQuotes" data-parent="quotes" data-children="0">
                                                @endif
                                                
                                                <label class="custom-control-label" for="deleteQuotes">Eliminar cotizaciones</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->bussines->opportunities->viewOpportunities == 1
                                                     || $permition->bussines->opportunities->editOpportunities == 1
                                                     || $permition->bussines->opportunities->changeOpportunities == 1
                                                     || $permition->bussines->opportunities->deleteOpportunities == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="opportunities" data-id="opportunities" data-parent="bussines" data-children="2">
                                                @else 
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="opportunities" data-id="opportunities" data-parent="bussines" data-children="2">
                                                @endif
                                                <label class="custom-control-label" for="opportunities">Oportunidades de negocio</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->bussines->opportunities->viewOpportunities == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewOpportunities" data-id="viewOpportunities" data-parent="opportunities" data-children="0">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewOpportunities" data-id="viewOpportunities" data-parent="opportunities" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="viewOpportunities">Ver oportunidades</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->bussines->opportunities->editOpportunities == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editOpportunities" data-id="editOpportunities" data-parent="opportunities" data-children="0">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editOpportunities" data-id="editOpportunities" data-parent="opportunities" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="editOpportunities">Editar</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->bussines->opportunities->changeOpportunities == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="changeOpportunities" data-id="changeOpportunities" data-parent="opportunities" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="changeOpportunities" data-id="changeOpportunities" data-parent="opportunities" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="changeOpportunities">Cambiar estatus</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-5">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->bussines->opportunities->deleteOpportunities == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteOpportunities" data-id="deleteOpportunities" data-parent="opportunities" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteOpportunities" data-id="deleteOpportunities" data-parent="opportunities" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="deleteOpportunities">Eliminar oportunidad</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="permit">
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->job->viewJob == 1
                                                    ||$permition->job->finishJob == 1
                                                    ||$permition->job->editJob == 1
                                                    ||$permition->job->deleteJob == 1)
                                                  <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="job" data-id="job" data-children="1">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="job" data-id="job" data-children="1">
                                                @endif
                                                <label class="custom-control-label" for="job">Actividades</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                @if($permition->job->viewJob == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewJob" data-id="viewJob" data-parent="job" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewJob" data-id="viewJob" data-parent="job" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="viewJob">Ver actividades</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->job->finishJob == 1)
                                                 <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="finishJob"  data-id="finishJob" data-parent="job" data-children="0">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="finishJob"  data-id="finishJob" data-parent="job" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="finishJob">Finalizar actividades</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->job->editJob == 1)
                                                  <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editJob" data-id="editJob" data-parent="job" data-children="0">
                                                @else
                                                 <input  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editJob" data-id="editJob" data-parent="job" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="editJob">Editar actividades</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->job->deleteJob == 1)
                                                   <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteJob" data-id="deleteJob" data-parent="job" data-children="0">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteJob" data-id="deleteJob" data-parent="job" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="deleteJob">Eliminar actividades</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="permit">
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->company->viewCompany == 1
                                                    ||$permition->company->addCompany == 1
                                                    ||$permition->company->editCompany == 1
                                                    ||$permition->company->deleteCompany == 1)
                                               <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="company" data-id="company" data-children="1">
                                                @else
                                               <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="company" data-id="company" data-children="1">
                                                @endif
                                                <label class="custom-control-label" for="company">Empresas</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->company->viewCompany == 1)
                                               <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewCompany" data-id="viewCompany" data-parent="company" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewCompany" data-id="viewCompany" data-parent="company" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="viewCompany">Ver empresas</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->company->addCompany == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addCompany" data-id="addCompany" data-parent="company" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addCompany" data-id="addCompany" data-parent="company" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="addCompany">Registrar empresas</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->company->editCompany == 1)
                                               <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editCompany" data-id="editCompany" data-parent="company" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editCompany" data-id="editCompany" data-parent="company" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="editCompany">Editar empresas</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->company->deleteCompany == 1)
                                              <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteCompany" data-id="deleteCompany" data-parent="company" data-children="0">
                                                @else
                                               <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteCompany" data-id="deleteCompany" data-parent="company" data-children="0">
                                                @endif
                                                
                                                <label class="custom-control-label" for="deleteCompany">Eliminar empresas</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="permit">
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->campaign->viewCampaign == 1
                                                    ||$permition->campaign->editCampaign == 1
                                                    ||$permition->campaign->deleteCampaign == 1)
                                                 <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="campaign" data-id="campaign" data-children="1">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="campaign" data-id="campaign" data-children="1">
                                                @endif
                                                <label class="custom-control-label" for="campaign">Campa&ntilde;as</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                @if($permition->campaign->viewCampaign == 1)
                                               <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewCampaign" data-id="viewCampaign" data-parent="campaign" data-children="0">
                                                @else
                                               <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewCampaign" data-id="viewCampaign" data-parent="campaign" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="viewCampaign">Ver campa&ntilde;as</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                @if($permition->campaign->editCampaign == 1)
                                                <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editCampaign" data-id="editCampaign" data-parent="campaign" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editCampaign" data-id="editCampaign" data-parent="campaign" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="editCampaign">Editar campa&ntilde;a</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                @if($permition->campaign->deleteCampaign == 1)
                                               <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteCampaign" data-id="deleteCampaign" data-parent="campaign" data-children="0">
                                                @else
                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteCampaign" data-id="deleteCampaign" data-parent="campaign" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="deleteCampaign">Eliminar campa&ntilde;as</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="permit">
                                        <div class="form-group m-b-10">
                                            <div class="custom-control custom-checkbox">
                                                  @if($permition->notificationC->addNotification == 1
                                                    ||$permition->notificationC->viewNotification == 1
                                                    ||$permition->notificationC->deleteNotification == 1)
                                                  <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="notificationC" data-id="notificationC" data-children="1">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="notificationC" data-id="notificationC" data-children="1">
                                                @endif
                                                <label class="custom-control-label" for="notificationC">Notificaciones</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->notificationC->addNotification == 1)
                                                 <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addNotification" data-id="addNotification" data-parent="notificationC" data-children="0">
                                                @else
                                                 <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addNotification" data-id="addNotification" data-parent="notificationC" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="addNotification">Crear notificaciones</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->notificationC->viewNotification == 1)
                                                  <input type="checkbox" checked="true"  class="custom-control-input checkPermition" name="pres" value="0" id="viewNotification" data-id="viewNotification" data-parent="notificationC" data-children="0">
                                                @else
                                                  <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewNotification" data-id="viewNotification" data-parent="notificationC" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="viewNotification">Ver notificaciones</label>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-10 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                 @if($permition->notificationC->deleteNotification == 1)
                                                   <input checked="true"  type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteNotification" data-id="deleteNotification" data-parent="notificationC" data-children="0">
                                                @else
                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteNotification" data-id="deleteNotification" data-parent="notificationC" data-children="0">
                                                @endif
                                                <label class="custom-control-label" for="deleteNotification">Eliminar notificaciones</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="permit">
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                @if($permition->callPending->viewcallPending == 1 || $permition->callPending->editcallPending == 1 || $permition->callPending->deletecallPending == 1)
                                                                    <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="callPending" data-id="callPending" data-children="1">
                                                                @else
                                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="callPending" data-id="callPending" data-children="1">
                                                                @endif
                                                                    <label class="custom-control-label" for="callPending">Llamadas pendientes</label>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                @if($permition->callPending->viewcallPending == 1)
                                                                    <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewcallPending" data-id="viewcallPending" data-parent="callPending" data-children="0">
                                                                @else
                                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewcallPending" data-id="viewcallPending" data-parent="callPending" data-children="0">
                                                                @endif   
                                                                 <label class="custom-control-label" for="viewcallPending">Ver llamadas pendientes</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                @if($permition->callPending->editcallPending == 1)
                                                                    <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editcallPending" data-id="editcallPending" data-parent="callPending" data-children="0">
                                                                @else
                                                                <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editcallPending" data-id="editcallPending" data-parent="callPending" data-children="0">
                                                                @endif
                                                                    <label class="custom-control-label" for="editcallPending">Editar llamadas pendientes</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                @if($permition->callPending->deletecallPending == 1)
                                                                    <input checked="true" type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deletecallPending" data-id="deletecallPending" data-parent="callPending" data-children="0">
                                                                   @else
                                                                   <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deletecallPending" data-id="deletecallPending" data-parent="callPending" data-children="0">
                                                                   @endif
                                                                    <label class="custom-control-label" for="deletecallPending">Eliminar llamadas pendientes</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                </div>
                              </div>
                              
                            </div>
                        </div>
                        <div class="col-md-12 text-right pt-3">
                            <button type="button" class="btn btn-success" id="btnUpdatePermition" data-id="{!!$pkUser!!}"><span class="ti-check"></span> Modificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>
