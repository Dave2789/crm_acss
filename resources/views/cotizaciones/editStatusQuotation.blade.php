<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Modificar Estatus Cotización folio# {{$folio}}</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            <div class="row pt-3">
                <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label">Estatus cotización</label>
                    <select id="slcStatus" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
                      @if($quotation->quotations_status == 1)
                      <option selected value="1">Creada</option>
                      @else
                      <option value="1">Creada</option>
                      @endif
                     
                      @if($quotation->quotations_status == 2)
                      <option selected value="2">Rechazada</option>
                      @else
                      <option value="2">Rechazada</option>
                      @endif
                      
                       @if($quotation->quotations_status == 3)
                      <option selected value="3">Cancelada</option>
                      @else
                      <option value="3">Cancelada</option>
                      @endif
                      
                       @if($quotation->quotations_status == 4)
                      <option selected value="4">Cerrar</option>
                      @else
                      <option value="4">Cerrar como Venta</option>
                      @endif                           
                    </select>
                  </div>
                </div>
                
                <div id="optionQuotation" class="col-md-12">
                  <h3>Seleccione una opción</h3>
                  <div class="row">
                   @foreach($oportunity as $item)
                    <div class="col-md-3 col-sm-2">
                        <label class="btn">
                           <div class="custom-control custom-radio">
                              <input type="radio"  name="options" id="customRadio{{$item->pkQuotations_detail }}" class="custom-control-input" value="{{$item->pkQuotations_detail }}">
                             
                              <label class="custom-control-label" for="customRadio{{$item->pkQuotations_detail }}">
                                <ul class="opciones-cot">
                                  @if($item->type == 1)
                                   <li class="mr-1">Tipo: <strong>Promoción</strong> </li>
                                   @else
                                    <li class="mr-1">Tipo: <strong>Normal</strong> </li>
                                   @endif
                                   <li class="mr-1"> Lugares: <strong>{{ $item->number_places }}</strong> </li>
                                    @if($quotation->withIva == 1)
                                    <li class="mr-1"> Precio: <strong>$ {{ number_format($item->price + ($item->price * $item->iva/100),2) }}</strong></li>
                                   @else
                                    <li class="mr-1"> Precio: <strong>$ {{ number_format($item->price,2) }}</strong></li>
                                   @endif
                                    <li class="mr-1"> Vigencia: <strong>{{ $item->date}}</strong></li>
                                </ul>
                             </label>
                            
                          </div> 
                       </label>
                      </div>
                   @endforeach
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <h3 class="title-section">Crear Factura</h3>
                      <form class="p-3">
                        <div class="row justify-content-center mt-3">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Nombre (Raz&oacute;n Social) *</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                </div>
                                <input type="text" id="social" class="form-control" value="{!! $quotation->bussines!!}">
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">RFC *</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                </div>
                                  <input style="text-transform:uppercase;" type="text" id="rfc" class="form-control" value="{{$quotation->rfc}}">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <select id="slccfdi" class="form-control custom-select"tabindex="1">
                                <option value="-1">Selecciona el Uso de CFDI</option>
                               @foreach($usocfdi as $usocfdiInfo)
                               <option value="{{$usocfdiInfo->id }}">{{$usocfdiInfo->c_UsoCFDI}} - {{$usocfdiInfo->Descripción }}</option>
                               @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <select id="payment" class="form-control custom-select"tabindex="1">
                                <option value="-1">Selecciona Forma de Pago *</option>
                                  @foreach($payment  as $paymentInfo)
                               <option value="{{$paymentInfo->pkPayment_forms_billing }}">{!!$paymentInfo->code!!} - {!!$paymentInfo->name !!}</option>
                               @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <select id="method" class="form-control custom-select"tabindex="1">
                                <option value="-1">Selecciona Método de Pago *</option>
                                 @foreach($method  as $methodInfo)
                                 <option value="{{$methodInfo->pkPayment_methods_billing }}">{!!$methodInfo->code!!} - {!!$methodInfo->name !!}</option>
                                 @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <select id="condition" class="form-control custom-select"tabindex="1">
                                <option value="-1">Selecciona Condición de Pago *</option>
                                 @foreach($condition  as $conditionInfo)
                                  <option value="{{$conditionInfo->pkPayment_condition_billing }}">{!! $conditionInfo->name !!}</option>
                                 @endforeach
                              </select>
                            </div>
                          </div>
                         
                          <div class="col-12">
                           <!--  <div class="row f-cot">
                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label class="control-label">Serie</label>
                                  <input type="text" id="serie" class="form-control" value="A">
                                </div>
                              </div>
                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label class="control-label">Producto</label>
                                  <select id="slcProduct" class="form-control custom-select"tabindex="1">
                                    <option value="-1">Selecciona la Clave de Producto</option>
                                    @foreach($claveser  as $claveserInfo)
                                      <option value="{{$claveserInfo->pkF4_c_claveserv }}">{!!$claveserInfo->code!!} - {!!$claveserInfo->name !!}</option>
                                     @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label class="control-label">Unidad</label>
                                  <select id="slcUnity" class="form-control custom-select"tabindex="1">
                                    <option value="-1">Selecciona la Clave de Unidad</option>
                                     @foreach($claveuni  as $claveuniInfo)
                                      <option value="{{$claveuniInfo->pkF4_c_claveunity }}">{!!$claveuniInfo->code!!} - {!!$claveuniInfo->name !!}</option>
                                     @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label class="control-label">Número de Identificación (SKU)</label>
                                  <input type="text" id="numIden" class="form-control" value="">
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label class="control-label">Descripción</label>
                                  <input type="text" id="desc" class="form-control" value="">
                                </div>
                              </div>
                              <!--<div class="col-sm-4">
                                <div class="form-group">
                                  <label class="control-label">Cantidad *</label>
                                  <input type="number" id="" class="form-control" value="">
                                </div>
                              </div>-->
                              <!--  <div class="col-sm-4">
                                <div class="form-group">
                                  <label class="control-label">Valor Unitario *</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                      </div>
                                      <input type="text"  id="rfc" class="form-control" value="">
                                    </div>
                                </div>
                              </div>
                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label class="control-label">Subtotal</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                      </div>
                                      <input type="text"  id="rfc" class="form-control" value="">
                                    </div>
                                </div>
                              </div>
                              <div class="col-sm-4">
                                <div class="form-group">
                                  <label class="control-label">Total</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                      </div>
                                      <input type="text"  id="rfc" class="form-control" value="">
                                    </div>
                                </div>
                              </div>
                            </div>-->
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>    
                </div>    

                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-success" id="btnUpdateStateQuotation" data-id="{{ $quotation->pkQuotations }}"><span class="ti-check"></span> Modificar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>
