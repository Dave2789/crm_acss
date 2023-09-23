<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Convertir a cotizaci&oacute;n</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body px-5">
        <form>
            <div class="row pt-3">
                <!-- <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Nombre de la cotización</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-write"></i></span>
                          </div>
                          <input type="text" id="name" class="form-control">
                        </div>
                    </div>
                </div>-->

                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label">Empresa *</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                            </div>
                            <input autocomplete="off" value="{!!$oportunity->bussinesName!!}" data-id="{!!$oportunity->fkBusiness!!}" type="text" data-id="-1" id="slcBussines" class="autocomplete_bussines form-control" readonly>
                        </div>
                        <div  class="search-header-bussines">
                        </div>
                        <div class="search__border"></div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label">Contacto *</label>
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
                        <button type="button" class="btn btn-success btn-addContact m-t-30" style="font-size: 13px;padding:3px 5px;line-height: 1.1;">Agregar <br>Contacto</button> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Agente a asignar *</label>
                        <select id="slcAgent" class="form-control custom-select" data-placeholder="Elige Agente" tabindex="1">
                            <option value="-1">Selecciona un Agente</option>
                            @foreach($agent as $item)
                            @if($oportunity->asing == $item->pkUser)
                            <option selected value="{!! $item->pkUser !!}">{!! $item->full_name!!}</option>
                            @else
                            <option value="{!! $item->pkUser !!}">{!! $item->full_name!!}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Nivel de interés *</label>
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Forma de pago *</label>
                        <select id="slcPayment" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
                            <option value="-1">Selecciona una forma de pago</option>
                            @foreach($payment as $item)
                            @if($item->pkPayment_methods == $oportunity->fkPayment_methods)
                            <option selected value="{!! $item->pkPayment_methods !!}">{!! $item->name!!}</option>
                            @else
                            <option value="{!! $item->pkPayment_methods !!}">{!! $item->name!!}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Campaña</label>
                        <select id="campaningq" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Cotización con IVA
                        </label>
                        <div class="form-row">
                            <div class="d-flex">
                                <div class="custom-control custom-radio mr-4">
                                    <input checked="true" type="radio" class="custom-control-input" name="iva2" value="1" id="withIva2">
                                    <label class="custom-control-label" for="withIva2">Sí</label>
                                </div>
                                <div class="custom-control custom-radio mr-4">
                                    <input type="radio" class="custom-control-input" name="iva2" value="0" id="withNoIva2">
                                    <label class="custom-control-label" for="withNoIva2">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                     <div class="form-group">
                         <label class="control-label">Vigencia</label>
                         <div class="input-group">
                           <div class="input-group-prepend">
                             <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                           </div>
                           <input type="date" id="vigency" class="form-control" placeholder="0">
                         </div>
                     </div>-->
            </div>
            <div class="col-md-12" id="addContentOPcion">
                <div class="contentNewOpcion">
                    <div class="row" style="background:#dadada;padding: 5px 10px;margin-bottom: 15px;">
                        <div class="col-sm-4">
                            <div class="nav-small-cap">- - - OPCIÓN 1</div>
                        </div>
                        <div class="col-sm-88">
                            <div class="form-group d-flex mb-0">
                                <label class="control-label mr-5 mb-0">Tipo de precio *</label>
                                <div class="custom-control custom-radio mr-4">
                                    <input type="radio" class="custom-control-input typePriceN" name="typePrice11" checked value="0" id="rNormal">
                                    <label class="custom-control-label mb-0" for="rNormal">Normal</label>
                                </div>
                                <div class="custom-control custom-radio mr-4">
                                    <input type="radio" class="custom-control-input typePriceP" name="typePrice11"  value="1" id="rPromo">
                                    <label class="custom-control-label mb-0" for="rPromo">Promoción</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                       
                        
                    @php  $cont = 1;     @endphp
                   <div id="coursesQuotationC_1" class="coursesQuotationC">
                     @foreach($oportunityDetail[$oportunity->pkOpportunities] as $oportunityDetailInfo)
                       
                            <div class="row coursesQuotationC_1 coursesQuotationC_detail" data-id="{!!$cont!!}">
                                
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Cantidad de colaboradores / lugares
                                    
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>
                                    </div>
                                    <input id="qtyEmployeeQC_1_{!!$cont!!}" data-op="1" value="{!!$oportunityDetailInfo['qtyPlaces']!!}" type="number" data-id="{!!$cont!!}" class="form-control qtyEmployeeQC" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-top: 40px">
                            <div class="form-group">
                                      <label class="control-label">Cursos
                                      </label>
     
                                        <select id="slcCourseQC_1_{!!$cont!!}" class="form-control slcCourseQC">
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
                        <div class="col-md-3" style="margin-top: 40px">
                            <div class="form-group">
                               <label class="control-label">Precio Unitario</label>
                               <div class="input-group">
                                  <div class="input-group-prepend">
                                     <span class="input-group-text"
                                        id="basic-addon11"><i
                                           class="ti-money"></i></span>
                                  </div>
                                  <input id="precioUC_1_{!!$cont!!}" data-id="0" data-iva-="0"
                                     type="text" class="form-control precioUC"
                                placeholder="$ 0.00" value="{!! number_format($oportunityDetailInfo['priceUnit'],2) !!}">
                               </div>
                            </div>
                         </div>
                        <div class="col-md-3" style="margin-top: 40px">
                            <div class="form-group">
                                <label class="control-label">Precio total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                    </div>
                                    <input id="precioQC_1_{!!$cont!!}" data-id="{!! $oportunityDetailInfo['price'] !!}" data-iva="{!!$oportunityDetailInfo['priceIva'] !!}" type="text" value="{!!number_format($oportunityDetailInfo['priceIva'],2) !!}" class="form-control precioQC" placeholder="$ 0.00">
                                </div>
                            </div>
                        </div>
                        </div>
                      @php  $cont++;     @endphp
                     @endforeach
                        </div>
                  <input type="hidden" id="countQuotationC_1" value="{!!$cont!!}"/>
                        <div class="col-12 text-right">
                               <div class="form-group">
                                <div  style="margin-top: 15px;"><button type="button" data-id="1" class="btn btn-secondary addMoreCourseQuotationConvert" id="addMoreCourseQuotationConvert"><span class="ti-plus"></span> Agregar Más Cursos</button></div>
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
                                    <input id="subQC_1" value="{!!number_format($subtotal,2) !!}" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control subQC" placeholder="$ 0.00">  
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
                                    <input id="descQC_1" value="{!!number_format($desc,2) !!}" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control descQC" placeholder="$ 0.00">  
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
                                     <input id="totalQC_1" value="{!!number_format($total,2) !!}" disabled="true" data-row="1" data-id="0" data-iva="0" type="text"  class="form-control totalQC" placeholder="$ 0.00">  
                                </div>
                                </div>
                            </div>

                            <div class="col-md-1" >
                                <div class="form-group">

                                   <button type="button" style="margin-top:30px; display:none"
                                   class="btn btn-danger CanceleditTotalC" data-id="1"
                                   id="CanceleditTotalC_1"><span class="ti-close"></span></button>

                                   <button type="button" style="margin-top:30px;display:block"
                                      class="btn btn-primary editTotalC" data-id="1"
                                      id="editTotalC_1"><span class="ti-pencil-alt"></span></button>
                                </div>
                             </div>
                             
                             <input type="hidden" id="editQC_1" class="editQC" value="0">
                                  
                                   <div class="col-md-2">
                                <div class="form-group">
                                    <button type="button" style="margin-top:30px" class="btn btn-secondary recalcularQC" data-id="1" id="recalcularQC">Recalcular</button>
                                </div>
                            </div>
                                                            
                           </div>  
                      
                        <div class="col-sm-6">
                            <label class="control-label">Vigencia opción 1</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                </div>
                                <input type="date" id="vigencia" class="form-control vigencia">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="count" value="2"/>
            <div class="col-12 mt-4">
                <div class="form-group">
                    <div class="add-user"><button type="button" class="btn btn-secondary addMoreOpcion" id="addMoreOpcion"><span class="ti-plus"></span> Agregar Más Opciones</button></div>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-success" id="btnConvertQuotation" data-id="{!!$oportunity->pkOpportunities!!}"><span class="ti-check"></span> Convertir</button>
            </div>
    </div>
</form>
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
                        <button type="button" class="btn btn-success"  id="addContactBussines"><span class="ti-check"></span> Crear Contacto</button>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModalAddContact" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>