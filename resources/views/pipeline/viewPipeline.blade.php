
<!DOCTYPE html>
<html lang="en">

    <head>
        @include('includes.head')
    </head>

    <body class="skin-default fixed-layout">

        <!-- Main wrapper - style you can find in pages.scss -->
        <div id="main-wrapper">
            @include('includes.header')
            <!-- End Topbar header -->

            @include('includes.sidebar')
            <!-- End Left Sidebar  -->

            <!-- Page wrapper  -->
            <div class="page-wrapper">
                <div class="container-fluid">
                    <div class="row page-titles">
                        <div class="col-md-5 align-self-center">
                            <h4 class="text-themecolor">Ver Pipeline</h4>
                        </div>
                        <div class="col-md-7 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    @if(Session::get("fkUserType") == 1)
                                     <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                                    @else
                                     <li class="breadcrumb-item"><a href="/viewProfileAgent/{!!Session::get("pkUser")!!}">Inicio</a></li>
                                    @endif
                                     <li class="breadcrumb-item active">Pipeline</li>
                                </ol>
                            </div>
                        </div>
                    </div>
              @if($arrayPermition["pipeline"] == 1)
                    <!-- Pipeline -->
                    <div class="row pipeline">
                    <select id="slcAgentPipeline" class="custom-select form-control input-sm m-b-10">
                             <option value="-1">Todos los agentes</option>
                             @foreach($users as $usersInfo)
                              @if($fkUsers == $usersInfo->pkUser)
                             <option selected value="{!!$usersInfo->pkUser!!}">{!!$usersInfo->full_name!!}</option>
                              @else
                              <option value="{!!$usersInfo->pkUser!!}">{!!$usersInfo->full_name!!}</option>
                              @endif
                              @endforeach
                        </select>
                    </div>
                    <div class="row pipeline">

                        <div class="col-md-3 col-sm-6 pipe1">
                            <h4 class="pipe-title" style="background-color:#26c6da;">Prospectos</h4>
                            <div class="card scroll-pipe">
                                <div class="card-body">
                                    @foreach($prospect as $itemInitial)
                                    <div class="pipe" style="border-left-color:#26c6da">
                                        <h4 class="card-title">
                                            <span class="pipe-img">
                                                    @if(!empty($itemInitial->image))
                                                    <img class="img-fluid" src="/images/business/{!!$itemInitial->image!!}" class="rounded-circle">
                                                    @else
                                                    <img style="max-height: 40px;" src="/images/business/em.jpg"
                                                    class="rounded-circle">
                                                    @endif

                                            </span>
                                            <span class="pipe-name">
                                                {!! $itemInitial->name !!}
                                            </span>
                                        </h4>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-star"></i> Categoría:</div>
                                            <div class="col-6"><strong>{!! $itemInitial->category !!}</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-target"></i> Giro:</div>
                                            <div class="col-6"><strong>{!! $itemInitial->giro !!}</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-bookmark"></i> Origen:</div>
                                            <div class="col-6"><strong>{!! $itemInitial->nameOrigin !!}</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-user"></i> Contacto(s):</div>
                                            <div class="col-6"><strong><a href="#" class="viewBussinesContact" data-id="{!!$itemInitial->pkBusiness!!}">Ver todos</a></strong></div>
                                        </div>
                                        <div class="text-center mt-2">
                                            <a href="#" class="pipe-a createOportunity" data-id="{!!$itemInitial->pkBusiness!!}" style="background-color:#26c6da;"><i class="ti-light-bulb"></i> Crear Oportunidad de Negocio</a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 pipe2">
                            <h4 class="pipe-title" style="background-color:#0aaeae;">Oportunidades</h4>
                            <div class="pipes">
                                <div class="pipe" style="border-left-color:#0aaeae;">
                                    <h4>Total: $ <strong>{!! number_format($totalOportunity,2) !!}</strong></h4>
                                </div>
                            </div>
                            <div class="card scroll-pipe">
                                <div class="card-body">
                                    <div class="pipes">
                                        @foreach($arrayOportunity as $Oportunity)
                                        <div class="pipe" style="border-left-color:#0aaeae;">
                                            <h4 class="card-title">
                                                <span class="pipe-img">
                                                        @if(!empty($Oportunity['logo']))
                                                        <img class="img-fluid" src="/images/business/{!!$Oportunity['logo']!!}" class="rounded-circle">
                                                        @else
                                                        <img style="max-height: 40px;" src="/images/business/em.jpg"
                                                        class="rounded-circle">
                                                        @endif

                                                </span>
                                                <span class="pipe-name">
                                                    {!! $Oportunity["name"] !!}
                                                </span>
                                            </h4>
                                            <div class="row">
                                                <div class="col-6"><i class="ti-target"></i> Giro:</div>
                                                <div class="col-6"><strong>{!! $Oportunity["giro"] !!}</strong></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6"><i class="fas fa-chart-bar"></i> Interes:</div>
                                                <div class="col-6"><strong><span class="badge badge-pill badge-success" style="background-color: {!! $Oportunity['colorLevel']!!}">{!! $Oportunity["level"] !!}</span></strong></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-7"><i class="ti-light-bulb"></i> Oportunidad:</div>
                                                <div class="col-5"><strong># {!! $Oportunity["folio"]!!}</strong></div>
                                                <!--div class="col-2"><button class="pipe-btn convertToQuotation" style="background-color:#0aaeae;" data-id="{!!$Oportunity['fkOpportunities']!!}"><span class="ti-write"> </span></button></div-->
                                            </div>
                                            <div class="row">
                                                <div class="col-6"><i class="ti-calendar"></i> Fecha:</div>
                                                <div class="col-6"><strong>{!! $Oportunity["register_day"]!!}</strong></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6"><i class="ti-layout-grid3"></i> Lugares:</div>
                                                <div class="col-6"><strong>{!! $Oportunity["number_courses"]!!}</strong></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6"><i class="ti-money"></i> Monto:</div>
                                                <div class="col-6"><strong>$ {!! number_format($Oportunity["price_total"],2)!!}</strong></div>
                                            </div>
                                            <div class="text-center mt-2">
                                               @if($arrayPermition["change"] == 1)
                                                <a href="#" class="pipe-a convertToQuotation" style="background-color:#0aaeae;" data-id="{!!$Oportunity['fkOpportunities']!!}"><i class="ti-write"></i> Convertir a Cotización</a>
                                               @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 pipe3">
                            <h4 class="pipe-title" style="background-color:#13ae75;">Cotizaciones</h4>
                            <div class="pipe" style="border-left-color:#13ae75;">
                                <h4>Total: $ <strong>{!! number_format($totalQuotation,2) !!}</strong></h4>
                            </div>
                            <div class="card scroll-pipe">
                                <div class="card-body">
                                    @foreach($arrayQuotation as $Quotation)
                                    <div class="pipe" style="border-left-color:#13ae75;">
                                        <h4 class="card-title">
                                            <span class="pipe-img">
                                                    @if(!empty($Quotation['logo']))
                                                    <img class="img-fluid" src="/images/business/{!!$Quotation['logo']!!}" class="rounded-circle">
                                                    @else
                                                    <img style="max-height: 40px;" src="/images/business/em.jpg"
                                                    class="rounded-circle">
                                                    @endif

                                            </span>
                                            <span class="pipe-name">
                                                {!! $Quotation["name"] !!}
                                            </span>
                                        </h4>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-write"></i> Cotización:</div>
                                            <div class="col-6"><strong># {!! $Quotation["folio"]!!}</strong></div>
                                            <div class="col-12">  <span class="badge badge-pill badge-success">{!! $Quotation["quotations_status"] !!} </span></div>

                                        </div>
                                        @php $cont = 1; @endphp
                                        @foreach($Quotation["detail"] as $detailInfo)
                                        <hr/>
                                        @if($detailInfo["isSelected"] == 1)
                                        <p><strong>Opci&oacute;n {!!$cont!!}</strong> {!! $detailInfo["type"]!!}   <span class="badge-pill badge-success ti-check"></span></p>
                                        @else
                                        <p><strong>Opci&oacute;n {!!$cont!!}</strong> {!! $detailInfo["type"]!!}</p>
                                        @endif
                                        <div class="row">
                                            <div class="col-6"><i class="ti-target"></i> Giro:</div>
                                            <div class="col-6"><strong>{!! $Quotation["giro"] !!}</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="fas fa-chart-bar"></i> Interes:</div>
                                            <div class="col-6"><strong><span class="badge badge-pill badge-success" style="background-color: {!! $Quotation['colorLevel']!!}">{!! $Quotation["level"] !!}</span></strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-money"></i> Monto:</div>
                                            <div class="col-6"><strong>$ {!! number_format($detailInfo["price"],2)!!}</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-layout-grid3"></i> Lugares:</div>
                                            <div class="col-6"><strong>{!! $detailInfo["number_places"]!!}</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-calendar"></i> Vigencia:</div>
                                            <div class="col-6"><strong>{!! $detailInfo["date"]!!}</strong></div>
                                        </div>
                                        @php $cont++; @endphp
                                        @endforeach


                                        <div class="text-center mt-2">
                                            @if($Quotation["status"] == 1)
                                            <a href="#" class="pipe-a updateStatus" data-id="{!! $Quotation['fkQuotations'] !!}" style="background-color:#13ae75;"><i class="ti-write"></i>Cambiar estatus</a>
                                            @endif

                                              @if($Quotation["status"] >= 4)
                                            @if($Quotation["status"] == 4 || $Quotation["status"] == 5)
                                             @if($arrayPermition["money"] == 1)
                                            <div class="custom-control custom-checkbox mb-3">
                                                @if($Quotation["status"] < 5)
                                                <input type="checkbox" class="custom-control-input Checkbox" id="check_{!!$Quotation['fkQuotations']!!}" data-id="{!! $Quotation['fkQuotations']!!}">
                                                @else
                                                <input type="checkbox" checked="" onclick="javascript: return false;" class="custom-control-input" id="check_{!!$Quotation['fkQuotations']!!}" data-id="{!! $Quotation['fkQuotations'] !!}">
                                                @endif
                                                <label class="custom-control-label" for="check_{!!$Quotation['fkQuotations']!!}">Dinero en cuenta</label>
                                            </div>
                                             @endif
                                            @endif

                                            @if( ($Quotation["status"] == 4 || $Quotation["status"] == 5) &&  $Quotation["money_in_account"] == 0)
                                             @if($arrayPermition["invoice"] == 1)
                                            <span class="paymentQuotation cursor-h" data-id="{!!$Quotation['fkQuotations'] !!}"><i class="ti-file"></i> Facturación</span>
                                             @endif
                                            @else
                                            <span>Facturada<br><small>No es editable</small></span>
                                            @endif
                                            <hr style="margin:7px;">
                                            @if(!empty($Quotation['pay']))
                                            <a href="/images/payment/{!!$Quotation['pay']!!}" target="_blank"> <span class="cursor-h"><i class="ti-image"></i> ver comprobante de pago</span></a>
                                            @else
                                            <a href="modalPago" class="modalpay" data-toggle="modal" data-target="#modalPago" data-id="{!!$Quotation['fkQuotations']!!}"> <span class="cursor-h"><i class="ti-image"></i> Agregar<br>comprobante de pago</span></a>
                                            @endif
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 pipe4">
                            <h4 class="pipe-title" style="background-color:#138e44;">Ventas</h4>
                            <div class="pipe" style="border-left-color:#138e44;">
                                <h4>Total: $ <strong>{!! number_format($totalSales,2) !!}</strong></h4>
                            </div>
                            <div class="card scroll-pipe">
                                <div class="card-body">
                                    @foreach($arraySale as $Sale)
                                    <div class="pipe" style="border-left-color:#138e44;">
                                        <h4 class="card-title">
                                            <span class="pipe-img">
                                                    @if(!empty($Sale['logo']))
                                                    <img class="img-fluid" src="/images/business/{!!$Sale['logo']!!}" class="rounded-circle">
                                                    @else
                                                    <img style="max-height: 40px;" src="/images/business/em.jpg"
                                                    class="rounded-circle">
                                                    @endif

                                            </span>
                                            <span class="pipe-name">
                                                {!! $Sale["name"] !!}
                                            </span>
                                        </h4>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-target"></i> Giro:</div>
                                            <div class="col-6"><strong>{!! $Sale["giro"] !!}</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="fas fa-chart-bar"></i> Interes:</div>
                                            <div class="col-6"><strong><span class="badge badge-pill badge-success" style="background-color: {!! $Sale['colorLevel']!!}">{!! $Sale["level"] !!}</span></strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-receipt"></i> Venta:</div>
                                            <div class="col-6"><strong># {!! $Sale["folio"]!!}</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-calendar"></i> Fecha:</div>
                                            <div class="col-6"><strong>{!! $Sale["date"]!!}</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-layout-grid3"></i> Lugares:</div>
                                            <div class="col-6"><strong>{!! $Sale["number_places"]!!}</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6"><i class="ti-money"></i> Total:</div>
                                            <div class="col-6"><strong>$ {!! number_format($Sale["price"],2)!!}</strong></div>
                                        </div>
                                    </div>
                                    <div class="pipe-bottom"></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                 @else
                <div class="row">
                    <div class="col-12">
                        <!-- Campañas -->
                        <div class="card">
                            <div class="card-body">
                                Acceso denegado, no tiene permiso para esta seccion
                            </div>
                        </div>
                    </div>
                </div>
              @endif
                    <!-- End Page Content -->

                </div><!-- End Container fluid  -->
            </div><!-- End Page wrapper  -->

            @include('includes.footer')
            <!-- End footer -->
        </div><!-- End Wrapper -->


        @include('includes.scripSnGraSnDt')
        <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditCategoria" class="modalEditCategoria"></button>
        <!-- Convertir -->
        <div class="modal fade modal-gde" id="modalEditCategoria" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
            <div class="modal-dialog modal-abrevius" id="modalEditCat" role="document">

            </div>
        </div>

        <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditUsuario" class="modalEditUsuario"></button>
        <!-- Convertir -->
        <div class="modal fade modal-gde" id="modalEditUsuario" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
            <div class="modal-dialog modal-abrevius" id="modalUsuario" role="document">

            </div>
        </div>

          <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
           <div class="modal-dialog modal-abrevius" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h2 class="modal-title" id="modalAgentesCLabel">Agregar comprobante de pago</h2>
                       <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <div class="input-group">
                           <div class="input-group-prepend">
                               <span class="input-group-text" id="basic-addon11"><i class="ti-image"></i></span>
                           </div>
                           <div class="custom-file">
                               <input type="file" class="custom-file-input" id="image">
                               <label class="custom-file-label">Subir archivo</label>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-primary addPay" data-id="0">Agregar</button>
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                   </div>
               </div>
           </div>
       </div>


   <!-- Convertir -->
   <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modaladdContact"
   class="modaladdContact"></button>
<div class="modal fade modal-gde" id="modaladdContact" tabindex="-1" role="dialog"
   aria-labelledby="modalAgentesCLabel" aria-hidden="true" style="z-index: 1051">
   <div class="modal-dialog modal-abrevius" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Nuevo contacto</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div id="addContentContact2">
               <div class="contentNewContact2 row">
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
                              <span class="input-group-text" id="basic-addon11"><i
                                    class="ti-headphone-alt"></i></span>
                           </div>
                           <input type="text" id="phone" class="form-control phone"
                              placeholder="Incluir código de área">
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
                  <button type="button" class="btn btn-success" id="btn_addcontactBussines2"><span
                        class="ti-check"></span> Crear Contacto</button>
               </div>
            </div>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalAddContact"
               data-dismiss="modal">Cerrar</button>
         </div>
      </div>
   </div>
</div>
        <!-- End scripts  -->
    </body>


</html>
