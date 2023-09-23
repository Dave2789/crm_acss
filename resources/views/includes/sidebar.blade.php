<!-- Left Sidebar - style you can find in sidebar.scss  -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @if( (Session::get("isAdmin") == 1) || (Session::get("permition")->permition->companySearch == 1))
                <li class="buscar-side">
                    <!--buscador reemplazar por el de la plantilla-->
                    <div class="search">
                        <div class="search__form app-search d-block d-sm-none">
                            <input class="search__input main-input-text-search-header form-control" name="search" placeholder="Buscar empresas" aria-label="Site search" type="text" autocomplete="off">
                            <div  class="search-header">

                            </div>
                            <div class="search__border"></div>

                        </div>
                    </div>
                    <!--buscador reemplazar por el de la plantilla-->
                </li>
                @endif
                <!--li class="nav-small-cap">--- PERSONAL</li-->
                @if( (Session::get("isAdmin") == 1) || (Session::get("permition")->permition->dashboard == 1))
                <li> <a class="waves-effect waves-dark" href="/dashboard" aria-expanded="false"><i class="icon-speedometer"></i></i><span class="hide-menu">Dashboard</span></a></li>
                @endif
                 @if( (Session::get("isAdmin") == 1) || (Session::get("permition")->permition->pipeline == 1))
                <li> <a class="waves-effect waves-dark" href="/viewPipeline" aria-expanded="false"><i class="ti-control-forward"></i></i><span class="hide-menu">Pipeline</span></a></li>
               @endif
               @if( (Session::get("isAdmin") == 1) ||
              (Session::get("permition")->permition->callPending->viewcallPending == 1)||
              (Session::get("permition")->permition->callPending->editcallPending == 1)||
              (Session::get("permition")->permition->callPending->deletecallPending == 1)
              ) 
                <li> <a class="waves-effect waves-dark" href="/viewPendingCalls" aria-expanded="false"><i class="ti-mobile"></i></i><span class="hide-menu">Llamadas pendientes</span></a></li>
               @endif
                 @if( (Session::get("isAdmin") == 1) || 
                 (Session::get("permition")->permition->bussines->quotes->viewQuotes == 1) ||
                 (Session::get("permition")->permition->bussines->quotes->money == 1) ||
                 (Session::get("permition")->permition->bussines->quotes->invoice == 1) ||
                 (Session::get("permition")->permition->bussines->quotes->editQuotes == 1) ||
                 (Session::get("permition")->permition->bussines->quotes->changeQuotes == 1) ||
                 (Session::get("permition")->permition->bussines->opportunities->viewOpportunities == 1) ||
                 (Session::get("permition")->permition->bussines->opportunities->editOpportunities == 1) ||
                 (Session::get("permition")->permition->bussines->opportunities->changeOpportunities == 1) ||
                 (Session::get("permition")->permition->bussines->opportunities->deleteOpportunities == 1) 
                 )
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-light-bulb"></i><span class="hide-menu">Negocios</span></a>
                    <ul aria-expanded="false" class="collapse">
                         @if( (Session::get("isAdmin") == 1) || 
                 (Session::get("permition")->permition->bussines->quotes->viewQuotes == 1) ||
                 (Session::get("permition")->permition->bussines->quotes->money == 1) ||
                 (Session::get("permition")->permition->bussines->quotes->invoice == 1) ||
                 (Session::get("permition")->permition->bussines->quotes->editQuotes == 1) ||
                 (Session::get("permition")->permition->bussines->quotes->changeQuotes == 1)
                 )
                        <li><a href="/verCotizaciones">Ver Cotizaciones</a></li>
                        @endif
                        @if( (Session::get("isAdmin") == 1) || 
                 (Session::get("permition")->permition->bussines->opportunities->viewOpportunities == 1) ||
                 (Session::get("permition")->permition->bussines->opportunities->editOpportunities == 1) ||
                 (Session::get("permition")->permition->bussines->opportunities->changeOpportunities == 1) ||
                 (Session::get("permition")->permition->bussines->opportunities->deleteOpportunities == 1)
                 )
                        <li><a href="/verOportunidades">Ver Oportunidades de Negocio</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                  @if( (Session::get("isAdmin") == 1) || (Session::get("permition")->permition->calendar->viewCalendar == 1) ||(Session::get("permition")->permition->calendar->addActivity == 1))
                <li> <a class="waves-effect waves-dark" href="/calendario" aria-expanded="false"><i class="ti-calendar"></i></i><span class="hide-menu">Calendario</span></a></li>
                @endif
                  @if( (Session::get("isAdmin") == 1) || (Session::get("permition")->permition->sendMail == 1))
                <li> <a class="waves-effect waves-dark" href="/viewSendMail" aria-expanded="false"><i class="ti-email"></i></i><span class="hide-menu">Env&iacute;o de correo</span></a></li>
                @endif
                
                  @if((Session::get("isAdmin") == 1) || 
                  (Session::get("permition")->permition->company->viewCompany == 1) ||
                  (Session::get("permition")->permition->company->addCompany == 1) ||
                  (Session::get("permition")->permition->company->editCompany == 1) ||
                  (Session::get("permition")->permition->company->deleteCompany == 1)
                  )
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-bookmark"></i><span class="hide-menu">Empresas</span></a>
                    
                    <ul aria-expanded="false" class="collapse">
                        @if((Session::get("isAdmin") == 1) || (Session::get("permition")->permition->company->addCompany == 1))
                        <li><a href="/businessCreateView">Crear Empresa</a></li>
                        @endif
                          @if((Session::get("isAdmin") == 1) || (Session::get("permition")->permition->company->viewCompany == 1))
                        <li> <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Ver Empresas</a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="/verEmpresas">Todas</a></li>
                                <li><a href="/verEmpresasProspecto">Prospectos</a></li>
                                <li><a href="/verEmpresasLeads">Leads</a></li>
                                <li><a href="/verEmpresasCliente">Clientes</a></li>

                            </ul>
                        </li>
                        @endif
                          @if((Session::get("isAdmin") == 1) || (Session::get("permition")->permition->company->viewCompany == 1))
                        <li><a href="/cargarEmpresas">Carga Masiva</a></li>
                        @endif
                        <li><a href="/descargarCorreos">Descargar Correos</a></li>
                    </ul>
                </li>
                @endif
                  @if((Session::get("isAdmin") == 1) || (Session::get("permition")->permition->campaign->viewCampaign == 1))
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layers"></i><span class="hide-menu">Campañas</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="/commercialCampaignsCreateView">Crear Campaña</a></li>
                        @if((Session::get("isAdmin") == 1) || (Session::get("permition")->permition->campaign->viewCampaign == 1))
                        <li><a href="/commercialCampaignsView">Ver Campañas</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                    @if( (Session::get("isAdmin") == 1) ||
                    (Session::get("permition")->permition->job->viewJob == 1) ||
                    (Session::get("permition")->permition->job->finishJob == 1) ||
                    (Session::get("permition")->permition->job->editJob == 1) ||
                    (Session::get("permition")->permition->job->deleteJob == 1)
                    )
               <li> <a class="waves-effect waves-dark" href="/activityView" aria-expanded="false"><i class="ti-notepad"></i></i><span class="hide-menu">Actividades</span></a></li>
                     @endif
                     
                      @if((Session::get("isAdmin") == 1) ||
                      (Session::get("permition")->permition->admin->workplan->addWorkplan == 1) ||
                      (Session::get("permition")->permition->admin->workplan->viewWorkplan == 1) ||
                      (Session::get("permition")->permition->admin->workplan->deleteWorkplan == 1) ||
                      (Session::get("permition")->permition->admin->configBonus == 1)||
                      (Session::get("permition")->permition->admin->sales == 1)||
                      (Session::get("permition")->permition->admin->activity == 1)||
                      (Session::get("permition")->permition->admin->config == 1)
                      )
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Admin</span></a>
                    <ul aria-expanded="false" class="collapse">
                        @if((Session::get("isAdmin") == 1) ||
                      (Session::get("permition")->permition->admin->workplan->addWorkplan == 1)||
                      (Session::get("permition")->permition->admin->workplan->viewWorkplan == 1)||
                      (Session::get("permition")->permition->admin->workplan->deleteWorkplan == 1)
                      )
                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"></i><span class="hide-menu">Plan de Trabajo</span></a>
                            <ul aria-expanded="false" class="collapse">
                                  @if((Session::get("isAdmin") == 1) || (Session::get("permition")->permition->admin->workplan->addWorkplan == 1))
                                <li><a href="/plandetrabajo">Crear Plan de Trabajo</a></li>
                                @endif
                                 @if((Session::get("isAdmin") == 1) || (Session::get("permition")->permition->admin->workplan->viewWorkplan == 1))
                                <li><a href="/verplandetrabajo">Ver Plan de Trabajo</a></li>
                                @endif
                                @if((Session::get("isAdmin") == 1) ||(Session::get("permition")->permition->admin->configBonus == 1))
                                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu"> Bonos</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Bono Base</span></a>
                                            <ul aria-expanded="false" class="collapse">
                                                <li><a href="/bonoBase">Configurar Bono Base</a></li>
                                                <li><a href="/viwbonosBase">Ver Bono Base</a></li>
                                            </ul>
                                        </li>
                                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Bono Record</span></a>
                                            <ul aria-expanded="false" class="collapse">
                                                <li><a href="/bonoRecord">Configurar Bono Record</a></li>
                                                <li><a href="/viwbonosRecord">Ver Bono Record</a></li>
                                            </ul>
                                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Bono Techo</span></a>
                                            <ul aria-expanded="false" class="collapse">
                                                <li><a href="/bonoTecho">Configurar Bono Techo</a></li>
                                                <li><a href="/viwbonosTecho">Ver Bono Techo</a></li>
                                            </ul>

                                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Capacitaci&oacute;n</span></a>
                                            <ul aria-expanded="false" class="collapse">
                                                <li><a href="/penalizacion">Crear Capacitaci&oacute;n</a></li>
                                                <li><a href="/viewcapacitation">Ver Capacitaci&oacute;n</a></li>
                                            </ul>

                                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Comisi&oacute;n</span></a>
                                            <ul aria-expanded="false" class="collapse">
                                                <li><a href="/comision">Configurar Comisi&oacute;n</a></li>
                                                <li><a href="/viewComition">Ver Comisiones</a></li>
                                            </ul>
                                    </ul>

                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        <li> <a class="waves-effect waves-dark" href="/salesByAgent" aria-expanded="false"></i><span class="hide-menu">Ventas por Agentes</span></a></li>
                        @if((Session::get("isAdmin") == 1) ||(Session::get("permition")->permition->admin->activity == 1))
                        <li> <a class="waves-effect waves-dark" href="/actividad" aria-expanded="false"></i><span class="hide-menu">Actividad</span></a></li>
                        @endif
                        @if((Session::get("isAdmin") == 1) ||(Session::get("permition")->permition->admin->config == 1)) 
                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Configuraci&oacute;n</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="/viewUserType">Tipos de Usuario</a></li>
                                <li><a href="/viewCreateUser">Crear Usuario</a></li>
                                <li><a href="/viewUser">Ver Usuarios</a></li>
                                <li><a href="/viewActivityType">Tipos de Actividad</a></li>
                                <li><a href="/viewActivitySubtype">Subtipos de Actividad</a></li>
                                <li><a href="/cargarLlamadas">Importar llamadas agente</a></li>
                                <li><a href="/viewCursos">Cursos</a></li>
                                <li><a href="/configPrice">Configurar Precio Lugar</a></li>
                                <li><a href="/cargarDescuentos">Cargar Descuentos Lugares</a></li>
                                <li><a href="/viewPaymentMethods">Formas de Pago</a></li>
                                <li><a href="/viewCategories">Categorías</a></li>
                                <li><a href="/viewCommercialBusiness">Giros</a></li>
                                <li><a href="/cargarGiros">Cargar Giros</a></li>
                                <li><a href="/viewBusinessStatus">Estatus de empresa</a></li>
                                <li><a href="/viewLevelInterest">Nivel de Interés</a></li>
                                <li><a href="/viewOrigin">Origen de Empresa</a></li>
                                <li><a href="/viewCampaignsType">Tipos de Campaña</a></li>
                                <li><a href="/viewCreateDocument">Documentos</a></li>
                                @if( (Session::get("isAdmin") == 1))
                              <!--  <li><a href="/syncCRMold">Sincronizar CRM Viejo</a></li>.>>-->
                                <li><a href="/syncCap">Sincronizar Capacitación</a></li>
                              <!--   <li><a href="/addActivities">Sincronizar Actividades</a></li>-->
                                @endif
                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>
               @endif
                      
              @if( (Session::get("isAdmin") == 1) ||
              (Session::get("permition")->permition->notificationC->addNotification == 1)||
              (Session::get("permition")->permition->notificationC->viewNotification == 1)||
              (Session::get("permition")->permition->notificationC->deleteNotification == 1)
              ) 
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-bell"></i><span class="hide-menu">Notificaciones</span></a>
                    <ul aria-expanded="false" class="collapse">
                         @if( (Session::get("isAdmin") == 1) ||(Session::get("permition")->permition->notificationC->addNotification == 1)) 
                        <li><a href="/alertCreateView">Crear Notificación</a></li>
                        @endif
                        @if( (Session::get("isAdmin") == 1) ||(Session::get("permition")->permition->notificationC->viewNotification == 1)) 
                        <li><a href="/alertView">Ver Notificaciones</a></li>
                        @endif
                    </ul>
                </li>
               
               @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

<!-- right-sidebar -->
<div class="right-sidebar">
    <div class="slimscrollright">
        <div class="rpanel-title">Agentes conectados<span><i class="ti-close right-side-toggle"></i></span> </div>
        <div class="r-panel-body" id="chatOnline">



        </div>
    </div>
</div><!-- End Right sidebar -->