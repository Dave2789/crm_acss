<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar oportunidad #{!!$oportunity->folio!!}</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body px-5">
        <form>
            <div class="row pt-3">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label">Empresa *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                            </div>
                            <input autocomplete="off" type="text" data-id="{!! $oportunity->idBussines!!}" id="slcBussines" value="{!!$oportunity->bussiness!!}" class="autocomplete_bussines2 form-control" readonly>
                        </div>
                        <div  class="search-header-bussines2">
                        </div>
                        <div class="search__border"></div>
                    </div>

                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label">Contacto</label>
                        <select id="slcContact" class="form-control custom-select" data-placeholder="Elige empresa" tabindex="1">
                            <option value="-1">Selecciona un contacto</option>
                            @foreach($contact as $item)
                            @if($oportunity->fkContact_by_business == $item->pkContact_by_business)
                            <option selected value="{!! $item->pkContact_by_business !!}">{!! $item->name!!}</option>
                            @else
                            <option value="{!! $item->pkContact_by_business !!}">{!! $item->name!!}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button type="button" class="btn btn-success btn-addContact2 m-t-30" style="font-size: 13px;padding:3px 5px;line-height: 1.1;">Agregar<br> Contacto</button> 
                    </div>
                </div>
               
                <div id="coursesOportunityEdit">
                    @php  $cont = 1;     @endphp
                     @foreach($oportunityDetail[$oportunity->pkOpportunities] as $oportunityDetailInfo)
                            <div class="row coursesOportunityEdit" data-id="{!!$cont!!}">
                                <div class="col-md-12"><button type="button" class="btn btn-danger btn-sm btn_deleteNewCourseOportunity float-right" data-id="4"><span class="ti-close"></span></button></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">Cantidad de colaboradores / lugares
                                    <span class="text-primary tooltip-test" href="#" data-toggle="tooltip" data-html="true" title="Detectar la cantidad de empleados que tiene la empresa: - Cantidad total de su personal. - Cantidad de personal que requiere capacitar. - Del Personal a Capacitar, todos son internos o tambien son externos (contratistas). * * Atención: No todas las empresas requieren Contratistas."><i class="ti-info-alt"></i>
                                    </span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>
                                    </div>
                                    <input id="qtyEmployeeOpEdit_{!!$cont!!}" value="{!!$oportunityDetailInfo['qtyPlaces']!!}" type="number" data-id="{!!$cont!!}" class="form-control qtyEmployeeOpEdit" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                      <label class="control-label">Cursos
                                      <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar la Cantidad de Riesgos que la empresa tiene o la cantidad de Cursos que necesita: • ¿En su empresa tienen identificadas las actividades con riesgo de accidente laboral?. • ¿Su personal ocupacionalmente expuesto conoce las medidas de seguridad que debe seguir ante los riesgos que están presentes en sus actividades laborales?. Si contesta sí o no, preguntar… • ¿Usted sabe a cuantos riesgos está expuesto su personal operativo / sus instaladores / sus técnicos / incluso su personal administrativo?"><i class="ti-info-alt"></i>
                                       </span>
                                      </label>
                                        <br>
                                        <!--<div class="btn-group" style="width: 100%;" >
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;">
                                                Selecciona cursos
                                            </a>
                                            <ul class="dropdown-menu" style="width: 100%; height: 300px; overflow-y: scroll;" id="checkLink" data-id="10">
                                                @foreach($courses as $item)
                                                <li class="form-check dropdown-item br-txt" style="padding: 5px 0 5px 30px;">
                                                    <input class="form-check-input defaultCheck1_1" type="checkbox" value="{!! $item->pkCourses !!}" >
                                                    <label class="form-check-label" for="defaultCheck1">{!!$item->code !!} - {!! $item->name!!}</label>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>-->
                                        <select id="slcCourseOpEdit_{!!$cont!!}" class="form-control">
                                            <option value="-1">Sin definir</option>
                                            @foreach($courses as $item)
                                             @if($item->pkCourses == $oportunityDetailInfo['course'])
                                            <option selected value="{!! $item->pkCourses !!}">{!!$item->code !!} - {!! $item->name!!}</option>
                                            @else
                                            <option value="{!! $item->pkCourses !!}">{!!$item->code !!} - {!! $item->name!!}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Precio total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input id="precioOpEdit_{!!$cont!!}" data-id="{!! $oportunityDetailInfo['price'] !!}" type="text" value="{!! number_format($oportunityDetailInfo["priceIva"],2) !!}" class="form-control price2" placeholder="$ 0.00">
                                </div>
                            </div>
                        </div>
                        </div>
                      @php  $cont++;     @endphp
                     @endforeach
                        </div>
                  <input type="hidden" id="countOportunityEdit" value="{!!$cont!!}"/>
                  
                        <div class="col-12 text-right">
                               <div class="form-group">
                                <div  style="margin-top: 15px;"><button type="button" class="btn btn-secondary" id="addMoreCourseOportunityEdit"><span class="ti-plus"></span> Agregar Más Cursos</button></div>
                              </div>
                            </div>
                  
                           <div class="row">
                                 <div class="col-md-3">
                               <div class="form-group">
                                <label class="control-label">Subtotal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input id="subOpD_1" disabled="true" value="{!! number_format($subtotal,2)!!}" data-id="0" data-iva="0" type="text"  class="form-control subOpD" placeholder="$ 0.00">  
                                </div>
                               </div>
                            </div>
                                 <div class="col-md-3">
                                <div class="form-group">
                                <label class="control-label">Descuento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input id="descOpD_1" value="{!! number_format($desc,2) !!}" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control descOpD" placeholder="$ 0.00">  
                                </div>
                                </div>
                            </div>
                                 <div class="col-md-3">
                                <div class="form-group">
                                <label class="control-label">Total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input id="totalOpD_1" value="{!! number_format($total,2) !!}" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control totalOpD" placeholder="$ 0.00">  
                                </div>
                                </div>
                            </div>
                                  
                                   <div class="col-md-2">
                                <div class="form-group">
                                    <button type="button" style="margin-top:30px" class="btn btn-secondary recalcularOPD" data-id="1" id="recalcular">Recalcular</button>
                                </div>
                            </div>
                           </div>
          
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Cuándo requiere capacitar
                            <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar la Detectar la fecha en que planean llevar a cabo la capacitación, por ejemplo: • Señor ¿para cuándo o en qué fecha requiere capacitar a su personal?. • ¿En qué fecha tiene planeado iniciar la capacitación de su personal?. • ¿Tiene ya una fecha estimada para iniciar los cursos de capacitación para su personal?"><i class="ti-info-alt"></i>
                            </span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                            </div>
                            <input id="requicapas" type="text"  class="form-control" value="{!!$oportunity->training!!}">
                        </div>
                    </div>
                </div>
               
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Tiene presupuesto
                            <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar si la empresa cuenta con presupuesto para Capacitación: • Señor ¿Cuánto considera usted que su empresa debería invertir en la capacitación de su personal?. • ¿Cuentan con presupuesto para llevar a cabo la capacitación de su personal?. • ¿Tiene considerado algún monto de inversión para realizar la capacitación de su personal?. • ¿Su empresa tiene contemplado partida presupuestal para capacitación de sus empleados?. • ¿Tiene presupuesto para este curso o Capacitación?"><i class="ti-info-alt"></i>
                            </span>
                        </label>
                        <div class="form-row">
                            <div class="d-flex">
                                 @if($oportunity->isBudget == 1)
                                <div class="custom-control custom-radio mr-4">
                                    <input checked type="radio" class="custom-control-input" name="pres" value="1" id="customradio1">
                                    <label class="custom-control-label" for="customradio1">Sí</label>
                                </div>
                                <div class="custom-control custom-radio mr-4">
                                    <input type="radio" class="custom-control-input" name="pres" value="0" id="customradio2">
                                    <label class="custom-control-label" for="customradio2">No</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="pres" value="2" id="customradio3">
                                    <label class="custom-control-label" for="customradio3">Sin Definir</label>
                                </div>
                                 @endif
                                  @if($oportunity->isBudget == 0)
                                <div class="custom-control custom-radio mr-4">
                                    <input  type="radio" class="custom-control-input" name="pres" value="1" id="customradio1">
                                    <label class="custom-control-label" for="customradio1">Sí</label>
                                </div>
                                <div class="custom-control custom-radio mr-4">
                                    <input checked type="radio" class="custom-control-input" name="pres" value="0" id="customradio2">
                                    <label class="custom-control-label" for="customradio2">No</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="pres" value="2" id="customradio3">
                                    <label class="custom-control-label" for="customradio3">Sin Definir</label>
                                </div>
                                 @endif
                                 @if($oportunity->isBudget == 2)
                                <div class="custom-control custom-radio mr-4">
                                    <input  type="radio" class="custom-control-input" name="pres" value="1" id="customradio1">
                                    <label class="custom-control-label" for="customradio1">Sí</label>
                                </div>
                                <div class="custom-control custom-radio mr-4">
                                    <input  type="radio" class="custom-control-input" name="pres" value="0" id="customradio2">
                                    <label class="custom-control-label" for="customradio2">No</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input checked type="radio" class="custom-control-input" name="pres" value="2" id="customradio3">
                                    <label class="custom-control-label" for="customradio3">Sin Definir</label>
                                </div>
                                 @endif
                            </div>
                            <textarea id="comentPresupuestos" class="form-control" cols="1">{!! $oportunity->budgetComent !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Necesidades y temores
                            <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar Problema a resolver. La Propuesta de Valor de Abrevius esta diseñada para resolver la gran mayoría de los Problemas en capacitación de las empresas, el Asesor deberá estar alerta para detectarlos, tomar nota y atacar por ahí para cerrar la venta, por ejemplo: • No tengo tiempo para distraer a mi personal para tomar el curso. • Requiero juntar a mis empleados que están fuera de la ciudad para la capacitación. • Cuento con poco presupuesto. • Debo dividir en grupos a los trabajadores para irlos capacitando en diferentes días y horarios. • No tengo el flujo suficiente en este momento para gastar en los cursos. • Requiero la Constancia hoy de urgencia. --Ejemplos de Preguntas para detectar Sus 'temores' o 'problemas': • Señor, ¿Cual es el/los requerimiento(s) más importante(s) que su empresa busca para adquirir/contratar capacitación?. • ¿Qué es lo que busca para decidir contratar la capacitación?"><i class="ti-info-alt"></i>
                            </span>
                        </label>
                        <textarea id="necesites" class="form-control" cols="3">{!! $oportunity->necesites !!}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Comentarios</label>
                        <textarea id="comments" class="form-control" cols="3">{!! $oportunity->comment !!}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Agente</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                            </div>
                            <select id="slcAgent" class="form-control custom-select" data-placeholder="Elige Agente" tabindex="1">
                                @foreach($agent as $item)
                              @if($oportunity->fkUser == $item->pkUser)
                              <option selected value="{!! $item->pkUser !!}">{!! $item->full_name!!}</option>
                              @else
                               <option value="{!! $item->pkUser !!}">{!! $item->full_name!!}</option>
                              @endif
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Nivel de interés</label>
                        <select id="level" class="form-control custom-select" data-placeholder="Elige Nivel de interés" tabindex="1">
                            <option value="-1">Selecciona un nivel</option>
                            @foreach($level as $item)
                               @if($oportunity->fkLevel_interest == $item->pkLevel_interest)
                               <option selected value="{!! $item->pkLevel_interest !!}">{!! $item->text!!}</option>
                               @else
                               <option value="{!! $item->pkLevel_interest !!}">{!! $item->text!!}</option>
                               @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Forma de pago</label>
                        <select id="slcPayment" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
                           <option value="-1">Selecciona una forma de pago</option>
                            @foreach($payment as $item)
                             @if($oportunity->fkPayment_methods == $item->pkPayment_methods)
                             <option selected value="{!! $item->pkPayment_methods !!}">{!! $item->name!!}</option>
                            @else
                             <option value="{!! $item->pkPayment_methods !!}">{!! $item->name!!}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Campaña</label>
                        <select id="campaning" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
                            @if(sizeof($companis) > 0)
                            <option value="-1">Selecciona una campaña</option>
                            @foreach($companis as $item)
                            @if($oportunity->fkCampaign == $item->pkCommercial_campaigns)
                            <option selected value="{!! $item->pkCommercial_campaigns !!}">{!! $item->name!!}</option>
                             @else
                             <option value="{!! $item->pkCommercial_campaigns !!}">{!! $item->name!!}</option>
                             @endif
                           @endforeach
                            @else
                            <option value="-1">No existen campañas actualmente</option>
                            @endif
                        </select>
                    </div>
                </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Estatus oportunidad *</label>
                        <select id="slcStatus" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
                            @if($oportunity->opportunities_status == 1)
                            <option selected value="1">Creada</option>
                            @else
                            <option value="1">Creada</option>
                            @endif
                            
                             @if($oportunity->opportunities_status == 2)
                            <option selected value="3">Cancelada</option>
                            @else
                            <option value="3">Cancelada</option>
                            @endif
                            
                            @if($oportunity->opportunities_status == 2)
                            <option selected value="2">Rechazada</option>
                            @else
                            <option value="2">Rechazada</option>
                            @endif
                           
                           
                        </select>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-success" id="btn_editOportunitydb" data-id="{!!$oportunity->pkOpportunities !!}"><span class="ti-check"></span> Modificar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>

<!-- Convertir -->
<button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modaladdContact" class="modaladdContact"></button>
<div class="modal fade modal-gde" id="modaladdContact" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
    <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalAgentesCLabel">Nuevo contacto</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addContentContact">
                    <div class="contentNewContact row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" id="nameContact" class="form-control nameContact">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Cargo / Puesto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-medall"></i></span>
                                    </div>
                                    <input type="text" id="cargo" class="form-control cargo">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Correo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-email"></i></span>
                                    </div>
                                    <input type="email" id="email" class="form-control email">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Teléfono fijo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-headphone-alt"></i></span>
                                    </div>
                                    <input type="text" id="phone" class="form-control phone" placeholder="Incluir código de área">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Extensión</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-plus"></i></span>
                                    </div>
                                    <input type="text" id="extension" class="form-control extension">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Teléfono móvil</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-mobile"></i></span>
                                    </div>
                                    <input type="text" id="cel" class="form-control cel">
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-success" id="addContactBussines"><span class="ti-check"></span> Crear Contacto</button>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModalAddContact" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>