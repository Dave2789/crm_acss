<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Editar cotización folio# {{$folio}}</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            <div class="row pt-3">
                @if($quotation->quotations_status < 5)
               <!-- <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Nombre</label>
                        <input type="text" id="name" class="form-control" value="{!!$quotation->name!!}">
                    </div>
                </div>-->
                <div class="col-md-5">
                    <div class="form-group">
                                                <label class="control-label">Empresa *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                                  </div>
                                                     <input type="text" data-id="{{$quotation->idbussines}}" id="slcBussines" class="autocomplete_bussines form-control" value="{!! $quotation->bussines !!}">
                                                </div>
                                                   <div  class="search-header-bussines">
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
                            @if($quotation->fkContact_by_business == $item->pkContact_by_business)
                            <option selected value="{{ $item->pkContact_by_business }}">{!! $item->name!!}</option>
                            @else
                            <option value="{{ $item->pkContact_by_business }}">{!! $item->name!!}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="col-md-2">
                    <div class="form-group mt-4">
                        <button type="button" class="btn btn-success btn-addContact">Agregar Contacto</button> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Agente a asignar</label>
                        <select id="slcAgent" class="form-control custom-select" data-placeholder="Elige Agente" tabindex="1">
                            <option value="-1">Selecciona un Agente</option>
                            @foreach($agent as $item)
                               @if($quotation->asing == $item->pkUser)
                               <option selected value="{{ $item->pkUser }}">{!! $item->full_name!!}</option>
                            @else
                             <option  value="{{ $item->pkUser }}">{!! $item->full_name!!}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Nivel de interés</label>
                        <select id="level" class="form-control custom-select" data-placeholder="Elige Nivel de interés" tabindex="1">
                            <option value="-1">Selecciona un nivel</option>
                            @foreach($level as $item)
                             @if($quotation->fkLevel_interest == $item->pkLevel_interest)
                             <option selected value="{{ $item->pkLevel_interest }}">{!! $item->text!!}</option>
                            @else
                             <option value="{{ $item->pkLevel_interest }}">{!! $item->text!!}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Forma de pago</label>
                            <select id="slcPayment" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
                                <option value="-1">Selecciona una forma de pago</option>
                                @foreach($payment as $paymentInfo)
                                 @if($quotation->fkPayment_methods == $paymentInfo->pkPayment_methods)
                                 <option selected value="{{ $paymentInfo->pkPayment_methods }}">{!! $paymentInfo->name!!}</option>
                                @else
                                 <option value="{{ $paymentInfo->pkPayment_methods }}">{!! $paymentInfo->name!!}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Campaña</label>
                            <select id="campaning" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
                                @if(sizeof($companis) > 0)
                                <option value="-1">Selecciona una campaña</option>
                                 @foreach($companis as $item)
                                   @if($item->pkCommercial_campaigns == $quotation->fkCampaign)
                                    <option selected value="{{ $item->pkCommercial_campaigns }}">{!! $item->name!!}</option>
                                   @else
                                   <option value="{{ $item->pkCommercial_campaigns }}">{!! $item->name!!}</option>
                                   @endif
                                  @endforeach
                                @else
                                    @if(empty($quotation->campaign))
                                     <option value="-1">No existen campañas actualmente</option>
                                      @else
                                     <option value="-1">{!! $quotation->campaign !!}</option> 
                                    @endif
                                @endif
                            </select>
                        </div>
                    </div>
                       <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Cotizaci&oacute;n con IVA
                            </label>
                               <div class="form-row">
                                   <div class="d-flex">
                                       <div class="custom-control custom-radio mr-4">
                                           @if($quotation->withIva == 1)
                                          <input checked="true" type="radio" class="custom-control-input" name="ivaM" value="1" id="withIva2">
                                           @else
                                            <input  type="radio" class="custom-control-input" name="ivaM" value="1" id="withIva2">
                                           @endif
                                              <label class="custom-control-label" for="withIva2">Sí</label>
                                                </div>
                                                                  <div class="custom-control custom-radio mr-4">
                                                                      @if($quotation->withIva == 0)
                                                                      <input checked="true" type="radio" class="custom-control-input" name="ivaM" value="0" id="withNoIva2">
                                                                      @else
                                                                       <input type="radio" class="custom-control-input" name="ivaM" value="0" id="withNoIva2">
                                                                      @endif
                                                                      <label class="custom-control-label" for="withNoIva2">No</label>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
               <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Vigencia</label>
                        <input type="date" id="vigency" class="form-control" placeholder="0" value="{{$quotation->final_date }}">
                    </div>
                </div>-->
                  
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-success" id="btnUpdateQuotation" data-id="{{ $quotation->pkQuotations }}"><span class="ti-check"></span> Modificar</button>
                </div>
               @else
               <!-- updtae estatus-->
               <div class="row pt-3">
               <!-- <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Nombre</label>
                        <input type="text" id="name" class="form-control" value="{!!$quotation->name!!}">
                    </div>
                </div>-->
                <div class="col-md-6">
                    <div class="form-group">
                                                <label class="control-label">Raz&oacute;n Social *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                                  </div>
                                                    <input type="text" id="social" class="form-control" value="{!!$bussines->name!!}">
                                                </div>
                  
                                            </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">RFC *</label>
                          <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                                  </div>
                                                      <input type="text"  id="rfc" class="form-control" value="{{$bussines->rfc}}">
                                                </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Domicilio *</label>
                         <div class="input-group">
                           <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                 </div>
                                   <input type="text"  class="form-control" id="address" value="{!!$bussines->address!!}">
                                </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Tel&eacute;fono *</label>
                         <div class="input-group">
                           <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                 </div>
                                    <input type="text" id="phone" class="form-control" value="{{$bussines->phone}}">
                                </div>
                    </div>
                </div>
               
               <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Correo *</label>
                         <div class="input-group">
                           <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                 </div>
                                    <input type="text" id="mail"  class="form-control" value="{{$bussines->mail}}">
                                </div>
                    </div>
                </div>
               
               <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Uso de CFDI *</label>
                         <div class="input-group">
                           <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                 </div>
                                    <input type="text" id="cfdi" class="form-control" >
                                </div>
                    </div>
                </div>
               
               <div class="col-md-6">
                     <div class="form-group">
                                                <label class="control-label">Comprobante de pago *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-image"></i></span>
                                                  </div>
                                                  <div class="custom-file">
                                                    <input type="file" id="document" class="custom-file-input" lang="es">
                                                  <label class="custom-file-label form-control" for="customFileLang">Seleccionar Archivo</label>
                                                </div>
                                                </div>
                                            </div>
                </div>
            
                <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Forma de pago *</label>
                                                <select id="slcPayment" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
                                                  <option value="-1">Selecciona una forma de pago</option>
                                                    @foreach($payment as $item)
                                                    <option value="{{ $item->pkPayment_methods }}">{!! $item->name!!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                  
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-success" id="btnpaymentQuotation" data-id="{{ $quotation->pkQuotations }}"><span class="ti-check"></span> Pagar</button>
                </div>
            </div>
               
               @endif
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
                              <input type="text" id="nameContact" class="form-control nameContact">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label">Cargo / Puesto</label>
                              <input type="text" id="cargo" class="form-control cargo">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label">Correo</label>
                              <input type="email" id="email" class="form-control email">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label">Teléfono fijo</label>
                              <input type="text" id="phone" class="form-control phone" placeholder="Incluir código de área">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label">Extensión</label>
                              <input type="text" id="extension" class="form-control extension">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label">Teléfono móvil</label>
                              <input type="text" id="cel" class="form-control cel">
                          </div>
                      </div>
                  </div>  
              </div>
              <div class="col-12">
                  <div class="form-group">
                    <button type="button" class="btn btn-secondary"  id="btn_addcontactBussines2">Crear Contacto</button>
                  </div>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalAddContact" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>