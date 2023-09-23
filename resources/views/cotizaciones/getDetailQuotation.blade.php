<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="modalAgentesCLabel">Opciones cotización folio# {{$folioInfo->folio}}</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <div class="modal-body px-4">
      
            <input type="hidden" id="iva" value="{{$folioInfo->withIva }}">
        <h3 class="box-title m-t-30">Información de la cotización</h3>
            <hr class="m-t-0 m-b-10">
            <div class="row datos-e">
                <div class="col-md-6 dat1">
                    <label class="control-label ">Empresa:</label>
                    <p class="form-control-static"> {!! $folioInfo->bussines !!}</p>
                </div>
                <div class="col-md-6 dat1">
                    <label class="control-label ">Agente asignado:</label>
                    <p class="form-control-static"> {!! $folioInfo->asing !!} </p>
                </div>
                <div class="col-md-6 dat1">
                    <label class="control-label ">Contacto:</label>
                    <p class="form-control-static">{!! $folioInfo->contact !!}</p>
                </div>
                <div class="col-md-6 dat1">
                    <label class="control-label">Nivel de interés:</label>
                    <p class="form-control-static">{!! $folioInfo->level !!}</p>
                </div>
                <div class="col-md-6 dat1">
                    <label class="control-label">Tipo de pago:</label>
                    <p class="form-control-static">{!! $folioInfo->payment !!}</p>
                </div>
                <div class="col-md-6 dat1">
                    <label class="control-label">Campaña:</label>
                    @if(!empty($folioInfo->campaning))
                    <p class="form-control-static">{!! $folioInfo->campaning !!}</p>
                    @else
                    <p class="form-control-static">  Ninguna campaña agregada </p>
                    @endif
                </div>
                <div class="col-md-6 dat1">
                    <label class="control-label">Iva:</label>
                    @if($folioInfo->withIva == 1)
                    <p class="form-control-static">Con iva</p>
                    @else
                     <p class="form-control-static">Sin iva</p>
                    @endif
                </div>
               
            </div>
         <div class="table-responsive">
             <table id="" class="table display table-bordered table-striped no-wrap">
                 <thead>
                     <tr>
                         <th># Cotización</th>
                         <th>Lugares</th>
                         <th>Precio</th>
                         <th>Tipo</th>
                         <th>Vigencia</th>
                         <th>Eliminar</th>
                     </tr>
                 </thead>
                 <tbody>
                         @foreach($quotation as $item)
                          <tr>
                         <td>
                             {{$folioInfo->folio}}
                         </td>
                         <td>
                             {{$item->number_places }}
                         </td>
                         <td>
                            $ {{number_format($item->price,2) }}
                         </td>
                         <td>
                            @if($item->type == 0)
                            <span>Precio lista </span>
                            @else
                             <span>Promoción </span>
                            @endif
                         </td>
                         <td>
                             {{$item->date }}
                         </td>
                          <td>
                              <button type="button" class="btn btn-danger btn-sm btn_deleteDetailQuotation" data-quo="{{$item->fkQuotations}}" data-id="{{$item->pkQuotations_detail}}"><span class="ti-close"></span></button>
                         </td>
                            </tr>
                         @endforeach
                 </tbody>
             </table>
         </div>
            
             <div class="col-md-12" id="addContentOPcion">
                 @if($folioInfo->withIva == 1)
                 <input type="radio" name="iva2" checked value="1" style="display: none;">
                 @else 
                 <input type="radio" name="iva2" value="0" style="display: none;">
                 @endif
                <div class="contentNewOpcion">
                    <div class="row" style="background:#dadada;padding: 5px 10px;margin-bottom: 15px;margin-top:30px;">
                        <div class="col-sm-4">
                            <div class="nav-small-cap">- - - NUEVA OPCIÓN</div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group d-flex mb-0">
                                <label class="control-label mr-5 mb-0">Tipo de precio *</label>
                                <div class="custom-control custom-radio mr-4">
                                    <input type="radio" class="custom-control-input typePriceN" name="typePrice11"  value="0" id="rNormal">
                                    <label class="custom-control-label mb-0" for="rNormal">Normal</label>
                                </div>
                                <div class="custom-control custom-radio mr-4">
                                    <input type="radio" class="custom-control-input typePriceP" name="typePrice11" checked value="1" id="rPromo">
                                    <label class="custom-control-label mb-0" for="rPromo">Promoción</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                       
                   <div id="coursesQuotationC_1" class="coursesQuotationC">
  
                       <div class="row coursesQuotationC_1 coursesQuotationC_detail" data-id="1">
                          
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Cantidad de colaboradores / lugares
                                    
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>
                                    </div>
                                    <input id="qtyEmployeeQC_1_1" data-op="1"  type="number" data-id="1" class="form-control qtyEmployeeQC" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-top: 40px">
                            <div class="form-group">
                                      <label class="control-label">Cursos
                                      </label>
     
                                        <select id="slcCourseQC_1_1" class="form-control slcCourseQC">
                                            <option value="-1">Sin definir</option>
                                            @foreach($courses as $item)
                                            <option value="{{ $item->pkCourses }}">{{$item->code }} - {!! $item->name!!}</option>
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
                                  <input id="precioUC_1_1" data-id="0" data-iva-="0"
                                     type="text" class="form-control precioUC"
                                     placeholder="$ 0.00">
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
                                    <input id="precioQC_1_1" data-id="0" type="text"  class="form-control precioQC" placeholder="$ 0.00">
                                </div>
                            </div>
                        </div>
                        </div>
                     </div>
                  <input type="hidden" id="countQuotationC_1" value="2"/>
                        <div class="col-12 text-right">
                               <div class="form-group">
                                <div  style="margin-top: 10px;"><button type="button" data-id="1" class="btn btn-secondary addMoreCourseQuotationConvert" id="addMoreCourseQuotationConvert"><span class="ti-plus"></span> Agregar Más Cursos</button></div>
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
                                     <input id="subQC_1" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control subQC" placeholder="$ 0.00">  
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
                                    <input id="descQC_1" disabled="true" data-id="0" data-iva="0" type="text"  class="form-control descQC" placeholder="$ 0.00">  
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
                                     <input id="totalQC_1" disabled="true" data-row="1" data-id="0" data-iva="0" type="text"  class="form-control totalQC" placeholder="$ 0.00">  
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
                                    <button type="button" style="margin-top:30px" class="btn btn-secondary recalcularQC" data-id="1" id="recalcular">Recalcular</button>
                                </div>
                            </div>
                                                            
                           </div>  
                        <div class="col-sm-6">
                            <label class="control-label">Vigencia</label>
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
                    <div class="add-user"><button type="button" class="btn btn-secondary addMoreOpcion" id="addMoreOpcion3"><span class="ti-plus"></span> Agregar Más Opciones</button></div>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-success" id="btn_addOptionsBussines" data-id="{{$folioInfo->pkQuotations}}"><span class="ti-check"></span>Guardar opciones</button>
            </div>
   
         
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</div>