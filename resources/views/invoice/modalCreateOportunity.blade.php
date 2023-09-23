<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Crear Oportunidad de Negocio</h2>
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
                                    <input autocomplete="off" type="text" data-id="{!!$id!!}" id="slcBussines2" value="{!!$Bussiness->name!!}" class="autocomplete_bussines2 form-control" readonly>
                                </div>
                                <div  class="search-header-bussines2">
                                </div>
                                <div class="search__border"></div>
                            </div>

                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">Contacto</label>
                                <select id="slcContact2" class="form-control custom-select" data-placeholder="Elige empresa" tabindex="1">
                                    <option value="-1">Selecciona un contacto</option>
                                    @foreach($contact as $item)
                                    <option value="{!!$item->pkContact_by_business!!}" >{!! $item->name !!} </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-success btn-addContact2 m-t-30" style="font-size: 13px;padding:3px 5px;line-height: 1.1;">Agregar<br>Contacto</button> 
                            </div>
                        </div>
                        <div id="coursesOportunity">
                            <div class="row coursesOportunity" data-id="1">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">Cantidad de colaboradores / lugares
                                    <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar la cantidad de empleados que tiene la empresa: 
                                      <ul class='sin-type'>
                                      <li>- Cantidad total de su personal</li>
                                      <li>- Cantidad de personal que requiere capacitar</li>
                                      <li>- Del Personal a Capacitar, todos son internos o tambien son externos (contratistas) </li>
                                      </ul>
                                      * * Atención: No todas las empresas requieren Contratistas."><i class="ti-info-alt"></i>
                                </span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>
                                    </div>
                                    <input id="qtyEmployeeOp_1" type="number" data-id="1" class="form-control qtyEmployeeOp" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                      <label class="control-label">Cursos
                                      <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar la Cantidad de Riesgos que la empresa tiene o la cantidad de Cursos que necesita:
                                          <ul class='sin-type'>
                                          <li>• ¿En su empresa tienen identificadas las actividades con riesgo de accidente laboral?</li> 
                                          <li>• ¿Su personal ocupacionalmente expuesto conoce las medidas de seguridad que debe seguir ante los riesgos que están presentes en sus actividades laborales?</li>
                                          <li>Si contesta sí o no, preguntar….<br>• ¿Usted sabe a cuantos riesgos está expuesto su personal operativo / sus instaladores / sus técnicos / incluso su personal administrativo?</li>
                                          </ul>
                                          "><i class="ti-info-alt"></i>
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
                                        <select id="slcCourseOp_1" class="form-control">
                                            <option value="-1">Sin definir</option>
                                            @foreach($courses as $item)
                                            <option value="{!! $item->pkCourses !!}">{!!$item->code !!} - {!! $item->name!!}</option>
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
                                    <input id="precioOp_1" data-id="0" type="text"  class="form-control price2" placeholder="$ 0.00">
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                          <input type="hidden" id="countOportunity" value="2"/>
                        <div class="col-12 text-right">
                               <div class="form-group">
                                <div  style="margin-top: 15px;"><button type="button" class="btn btn-secondary" id="addMoreCourseOportunity"><span class="ti-plus"></span> Agregar Más Cursos</button></div>
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
                                     <input id="subOp_1" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control subOp" placeholder="$ 0.00">  
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
                                    <input id="descOp_1" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control descOp" placeholder="$ 0.00">  
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
                                     <input id="totalOp_1" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control totalOp" placeholder="$ 0.00">  
                                </div>
                                </div>
                            </div>
                                  
                                   <div class="col-md-3">
                                <div class="form-group">
                                    <button type="button" style="margin-top:30px" class="btn btn-secondary recalcularOP" data-id="1" id="recalcular">Recalcular</button>
                                </div>
                            </div>
                           </div>
                       <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Cantidad de lugares</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>
                                    </div>
                                    <input id="qtyPlaces2_10" data-id="10" type="number" class="form-control qtyPlaces2" placeholder="0">
                                </div>
                            </div>
                        </div>-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Cuándo requiere capacitar
                                    <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar la Detectar la fecha en que planean llevar a cabo la capacitación, por ejemplo: 
                                          <ul class='sin-type'>
                                          <li>• Señor ¿para cuándo o en qué fecha requiere capacitar a su personal?</li>
                                          <li>• ¿En qué fecha tiene planeado iniciar la capacitación de su personal?</li>
                                          <li>• ¿Tiene ya una fecha estimada para iniciar los cursos de capacitación para su personal?</li>
                                          </ul>"><i class="ti-info-alt"></i>
                                    </span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                    </div>
                                    <input id="requicapa" type="text"  class="form-control">
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Monto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input id="precio2_10" data-id="0" type="text"  class="form-control price2" placeholder="$ 0.00">
                                </div>
                            </div>
                        </div>-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tiene presupuesto
                                    <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar si la empresa cuenta con presupuesto para Capacitación:
                                          <ul class='sin-type'>
                                          <li>• Señor ¿Cuánto considera usted que su empresa debería invertir en la capacitación de su personal? </li>
                                          <li>• ¿Cuentan con presupuesto para llevar a cabo la capacitación de su personal?</li>
                                          <li>• ¿Tiene considerado algún monto de inversión para realizar la capacitación de su personal?</li>
                                          <li>• ¿Su empresa tiene contemplado partida presupuestal para capacitación de sus empleados?</li>
                                          <li>• ¿Tiene presupuesto para este curso o Capacitación?</li>
                                          </ul>"><i class="ti-info-alt"></i>
                                    </span>
                                </label>
                                <div class="form-row">
                                    <div class="d-flex">
                                        <div class="custom-control custom-radio mr-4">
                                            <input type="radio" class="custom-control-input" name="pres2" value="1" id="customradio12">
                                            <label class="custom-control-label" for="customradio12">Sí</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-4">
                                            <input type="radio" class="custom-control-input" name="pres2" value="0" id="customradio22">
                                            <label class="custom-control-label" for="customradio22">No</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="pres2" value="2" id="customradio222">
                                            <label class="custom-control-label" for="customradio222">Sin Definir</label>
                                        </div>
                                    </div>
                                    <textarea id="comentPresupuesto" class="form-control" cols="1"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Necesidades y temores
                                    <span class="text-primary" href="#" data-toggle="tooltip" data-html="true" title="Detectar Problema a resolver. La Propuesta de Valor de Abrevius esta diseñada para resolver la gran mayoría de los Problemas en capacitación de las empresas, el Asesor deberá estar alerta para detectarlos, tomar nota y atacar por ahí para cerrar la venta, por ejemplo:
                                          <ul class='sin-type'>
                                          <li>• No tengo tiempo para distraer a mi personal para tomar el curso </li>
                                          <li>• Requiero juntar a mis empleados que están fuera de la ciudad para la capacitación</li>
                                          <li>• Cuento con poco presupuesto</li>
                                          <li>• Debo dividir en grupos a los trabajadores para irlos capacitando en diferentes días y horarios</li>
                                          <li>• No tengo el flujo suficiente en este momento para gastar en los cursos</li>
                                          <li>• Requiero la Constancia hoy de urgencia</li>
                                          </ul>
                                          Ejemplos de Preguntas para detectar Sus 'temores' o 'problemas':
                                          <ul class='sin-type'>
                                          <li>• Señor, ¿Cual es el/los requerimiento(s) más importante(s) que su empresa busca para adquirir/contratar capacitación? </li>
                                          <li>• ¿Qué es lo que busca para decidir contratar la capacitación? </li>
                                          </ul>"><i class="ti-info-alt"></i>
                                    </span>
                                </label>
                                <textarea id="necesites2" class="form-control" cols="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Comentarios</label>
                                <textarea id="comments2" class="form-control" cols="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Agente</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                                    </div>
                                    <select id="slcAgent2" class="form-control custom-select" data-placeholder="Elige Agente" tabindex="1">
                                        <option value="-1">Selecciona un Agente</option>
                                        @foreach($agent as $item)
                                        <option value="{!! $item->pkUser !!}">{!! $item->full_name!!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nivel de interés</label>
                                <select id="level2" class="form-control custom-select" data-placeholder="Elige Nivel de interés" tabindex="1">
                                    <option value="-1">Selecciona un nivel</option>
                                    @foreach($level as $item)
                                    <option value="{!! $item->pkLevel_interest !!}">{!! $item->text!!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Forma de pago</label>
                                <select id="slcPayment2" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
                                    <option value="-1">Selecciona una forma de pago</option>
                                    @foreach($payment as $item)
                                    <option value="{!! $item->pkPayment_methods !!}">{!! $item->name!!}</option>
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
                                    <option value="{!! $item->pkCommercial_campaigns !!}">{!! $item->name!!}</option>
                                    @endforeach
                                    @else
                                    <option value="-1">No existen campañas actualmente</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-success" id="createOportunity2"><span class="ti-check"></span> Crear</button>
                        </div>
                    </div>
                </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>