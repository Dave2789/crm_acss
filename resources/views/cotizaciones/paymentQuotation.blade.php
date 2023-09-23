<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Facturar cotización folio# {{$folio}}</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
      <form class="p-3">
        <div class="row justify-content-center">
          <div class="col-sm-6">
            <div class="form-group">
              <label class="control-label">Nombre (Raz&oacute;n Social) *</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                </div>
                <input type="text" id="social" class="form-control" value="{{ $infoFacture->razon}}">
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
                  <input type="text"  id="rfc" class="form-control" value="{{$infoFacture->rfc}}">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <select id="slccfdi" class="form-control custom-select"tabindex="1">
                <option value="-1">Selecciona el Uso de CFDI *</option>
               @foreach($usocfdi as $usocfdiInfo)
                @if($infoFacture->cfdi == $usocfdiInfo->id)
                <option selected value="{{$usocfdiInfo->id}}">{{$usocfdiInfo->c_UsoCFDI}} - {{$usocfdiInfo->Descripción }}</option>
                @else
                <option value="{{$usocfdiInfo->id}}">{{$usocfdiInfo->c_UsoCFDI}} - {{$usocfdiInfo->Descripción }}</option>
                @endif
               @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <select id="payment" class="form-control custom-select"tabindex="1">
                <option value="-1">Selecciona Forma de Pago *</option>
                  @foreach($payment  as $paymentInfo)
                   @if($infoFacture->payment == $paymentInfo->pkPayment_forms_billing)
                   <option selected value="{{$paymentInfo->pkPayment_forms_billing }}">{{$paymentInfo->code}} - {!!$paymentInfo->name !!}</option>
                @else
                <option value="{{$paymentInfo->pkPayment_forms_billing }}">{{$paymentInfo->code}} - {!!$paymentInfo->name !!}</option>
                @endif
              
               @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <select id="method" class="form-control custom-select"tabindex="1">
                <option value="-1">Selecciona Método de Pago *</option>
                 @foreach($method  as $methodInfo)
                  @if($infoFacture->method == $methodInfo->pkPayment_methods_billing)
                  <option selected value="{{$methodInfo->pkPayment_methods_billing }}">{{$methodInfo->code}} - {!!$methodInfo->name !!}</option>
                @else
                <option value="{{$methodInfo->pkPayment_methods_billing }}">{{$methodInfo->code}} - {!!$methodInfo->name !!}</option>
                @endif
                
                 @endforeach
              </select>
            </div>
          </div>
       
          <div class="col-sm-6">
            <div class="form-group">
    
                  <input type="text" id="condition" class="form-control" value="Inmediatamente">
                </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
    
                  <input type="text" id="comment" class="form-control" placeholder="Comentarios">
                </div>
          </div>
          <div class="col-12">
            <div class="row f-cot">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label">Serie *</label>
                  <input type="text" id="serie" class="form-control" value="A">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label">Producto *</label>
                  <select id="slcProduct" class="form-control custom-select"tabindex="1">
                    <option value="-1">Selecciona la Clave de Producto *</option>
                    @foreach($claveser  as $claveserInfo)
                       <option selected value="{{$claveserInfo->pkF4_c_claveserv }}">{{$claveserInfo->code}} - {!!$claveserInfo->name !!}</option>
                     @endforeach
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label">Unidad *</label>
                  <select id="slcUnity" class="form-control custom-select"tabindex="1">
                    <option value="-1">Selecciona la Clave de Unidad *</option>
                     @foreach($claveuni  as $claveuniInfo)
                       <option selected value="{{$claveuniInfo->pkF4_c_claveunity }}">{{$claveuniInfo->code}} - {!!$claveuniInfo->name !!}</option>
                     @endforeach
                  </select>
                </div>
              </div>

          </div>

          @foreach($QuotationCourse as $QuotationCourseInfo)
          <div class="row f-cot">
          <div class="col-sm-1">
                <div class="form-group">
                  <label class="control-label">Lugares: </label><br />
                  <label>{{$QuotationCourseInfo->places }}  </label>
                </div>
            </div>

          <div class="col-sm-9">
                <div class="form-group">
                  <label class="control-label">Descripcion: </label><br />
             <input type="text" id="descFact" data-id="{{ $QuotationCourseInfo->pk_quotation_by_courses}}" class="form-control descFact" value="{{$QuotationCourseInfo->code }} {!!$QuotationCourseInfo->name !!} ">
                </div>
            </div>
            
            <div class="col-sm-2">
                <div class="form-group">
                  <label class="control-label">Precio: </label><br />
                  <label>{{number_format($QuotationCourseInfo->price,2) }}</label>
                </div>
            </div>
        </div>
        @endforeach
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
          </div>-->
        </div>
        <div class="col-md-12 text-right">
          <a href="#" id="viewbtnPrefacture" data-id="{{$quotation->pkQuotations}}" class="btn btn-info">Ver pre-factura</a>
        <!--  <button type="button" class="btn btn-success" id="btnUpdateFacture" data-id="{{$quotation->pkQuotations}}"><span class="ti-check"></span> Facturar</button>-->
        </div>
      </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>
