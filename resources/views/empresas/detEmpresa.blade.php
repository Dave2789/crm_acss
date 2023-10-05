<!DOCTYPE html>
<html lang="es">

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
                  <h4 class="text-themecolor">Empresas</h4>
               </div>
               <div class="col-md-7 align-self-center text-right">
                  <div class="d-flex justify-content-end align-items-center">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                        <li class="breadcrumb-item active">Empresas</li>
                     </ol>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-12">
                  <!-- información de la empresa -->
                  <div class="card">
                     <div class="card-body">
                        <div class="form-body">
                           <div class="row align-items-end">
                              <div class="col-md-1 col-sm-2">
                                 @if(!empty($Bussiness->image))
                                 <img src="{{ asset('assets/images/business/' . $Bussiness->image)}}" class="img-fluid">
                                 @else 
                                 <img src="{{ asset('assets/images/business/em.jpg')}}" class="img-fluid">
                                 @endif
                              </div>
                              <div class="col-md-11 col-sm-10">
                                 <h2>{!!$Bussiness->name!!}
                                    @if($Bussiness->status == 0)
                                    <span class="text-danger" style="font-size:13px;margin-left:10px;">Inactiva</span>
                                    @endif
                                 </h2>
                              </div>
                           </div>

                           <div class="row">
                              <div class="col-sm-6">
                                 <h3 class="box-title m-t-30">Información de la empresa</h3>
                                 <hr class="m-t-0 m-b-10">
                                 <div class="row datos-e">
                                    <div class="col-md-12 dat1">
                                       <label class="control-label ">Ciudad / Estado:</label>
                                       <p class="form-control-static">{!!$Bussiness->city!!} / {!!$Bussiness->state!!}
                                       </p>
                                    </div>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label ">País:</label>
                                       <p class="form-control-static">{!!$Bussiness->country!!} </p>
                                    </div>
                                    <!--<div class="col-md-12 dat1">
                                       <label class="control-label ">Domicilio:</label>
                                       <p class="form-control-static">{!!$Bussiness->address!!} </p>
                                    </div>-->
                                    <div class="col-md-12 dat1">
                                       <label class="control-label">Página Web:</label>
                                       <p class="form-control-static">{!!$Bussiness->web!!}</p>
                                    </div>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label ">Giro o rubro:</label>
                                       <p class="form-control-static">{!!$Bussiness->giro!!} </p>
                                    </div>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label ">Categoría:</label>
                                       <p class="form-control-static">{!!$Bussiness->category!!} </p>
                                    </div>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label ">Campaña:</label>
                                       <p class="form-control-static">
                                          @foreach($campaning as $info)
                                          {!!$info->name!!}<br>
                                          @endforeach
                                       </p>
                                    </div>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label ">Propietario:</label>
                                       <p class="form-control-static">{!! $Bussiness->full_name!!}</p>
                                    </div>
                                    <!--<div class="col-md-12 dat1">
                                       <label class="control-label">RFC:</label>
                                       <p class="form-control-static"> {!!$Bussiness->rfc!!}</p>
                                    </div>-->
                                    <div class="col-md-12 dat1">
                                       <label class="control-label ">Email:</label>
                                       <p class="form-control-static">{!!$Bussiness->mail!!} </p>
                                    </div>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label ">Teléfono:</label>
                                       <p class="form-control-static">{!! $Bussiness->phone !!}</p>
                                    </div>
                                    <!--<div class="col-md-12 dat1">
                                       <label class="control-label ">Origen:</label>
                                       <p class="form-control-static">{!!$Bussiness->origin!!} </p>
                                    </div>-->
                                    <div class="col-md-12 dat1">
                                       <button class="btn btn-sm btn-primary btn_updateBussines mr-2"
                                          data-id="{!!$Bussiness->pkBusiness !!}"><span class="ti-pencil"></span>
                                          Editar</button>
                                       <button class="btn btn-sm btn-secondary viewBussinesContact"
                                          data-id="{!!$Bussiness->pkBusiness !!}"><span class="ti-plus"></span>
                                          Contactos</button>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <h3 class="box-title m-t-30">Contactos</h3>
                                 <hr class="m-t-0 m-b-10">
                                 @php $cont = 1; @endphp
                                 @if(!empty($contact))
                                 @foreach($contact as $item)
                                 <div class="row datos-e">
                                    <h4>Contacto {!!$cont!!}</h4>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label "><i class="ti-user"></i> Nombre:</label>
                                       <p class="form-control-static">{!! $item->name !!}</p>
                                    </div>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label "><i class="ti-medall"></i> Cargo:</label>
                                       <p class="form-control-static">{!! $item->area !!}</p>
                                    </div>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label "><i class="ti-email"></i> Correo:</label>
                                       <p class="form-control-static">{!! $item->mail !!}</p>
                                    </div>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label "><i class="ti-headphone-alt"></i> Teléfono
                                          Fijo:</label>
                                       <p class="form-control-static">{!! $item->phone !!}</p>
                                    </div>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label "><i class="ti-plus"></i> Extensión:</label>
                                       <p class="form-control-static">{!! $item->extension !!}</p>
                                    </div>
                                    <div class="col-md-12 dat1">
                                       <label class="control-label"><i class="ti-mobile"></i> Teléfono Móvil:</label>
                                       <p class="form-control-static">{!! $item->mobile_phone !!}</p>
                                    </div>
                                 </div>
                                 @php $cont++; @endphp
                                 @endforeach
                                 @else
                                 <h3 class="box-title"></h3>
                                 @endif
                              </div>
                           </div>
                           <!--/row-->
                        </div>
                     </div>
                  </div>

                  <!-- Abiertos -->
                  <div class="card">
                     <!-- cotizaciones -->
                     <div class="card-body">
                        <h3>Cotizaciones</h3>
                        <div class="table-responsive m-t-10">
                           <table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
                              <thead>
                                 <tr>
                                    <th>Fecha</th>
                                    <th>Información</th>
                                    <th>Empresa</th>
                                    <th>Precio total</th>
                                    <th>Lugares</th>
                                    <th>Nivel de<br>inter&eacute;s</th>
                                    <th>Estado / País</th>
                                    <th>Estatus</th>
                                    <th>Agente</th>
                                    <th>Actividades</th>
                                    @if($arrayPermition["money"] == 1)
                                    <th>Confirmar<br>Pago</th>
                                    @endif
                                    @if($arrayPermition["editQuotes"] == 1)
                                    <th>Agregar<br>opciones</th>
                                    @endif
                                    @if($arrayPermition["changeQuotes"] == 1 || $arrayPermition["invoice"] == 1)
                                    <th>Modificar<br>Estatus</th>
                                    @endif
                                    @if($arrayPermition["editQuotes"] == 1)
                                    <th>Editar</th>
                                    @endif
                                    @if($arrayPermition["deleteQuotes"] == 1)
                                    <th>Eliminar</th>
                                    @endif

                                 </tr>
                              </thead>
                              <tbody>

                                 @foreach($quotation as $item)
                                 <tr>
                                    <td>
                                       {!! $item->register_day !!}<br>{!! $item->register_hour !!}
                                    </td>
                                    <td>
                                       <div class="c-folio  badge badge-pill badge-dark"><small>folio: #</small>
                                          {!!$item->folio !!}</div>
                                       <div class="c-docs">
                                          <div>
                                             <hr style="margin:7px;"><small>DOCUMENTOS:</small></div>
                                          @if($item->quotation_status > 1)
                                          @if( ($item->quotation_status == 4 || $item->quotation_status == 5) &&
                                          $item->money_in_account == 0)
                                          <a href="/viewQuotationFormatOpen/{!!$item->pkQuotations !!}" target="_blank"
                                             class="text-warning"><span class="ti-file-pdf"> </span>Cotización</a>
                                          <br>
                                          <a href="/viewQuotationFormat/{!!$item->pkQuotations !!}" target="_blank"
                                             class="text-success"><span class="ti-check"> </span>Cotización Aprobada</a>
                                          @endif
                                          @if($item->money_in_account == 1)
                                          <a href="/viewQuotationFormatOpen/{!!$item->pkQuotations !!}" target="_blank"
                                             class="text-warning"><span class="ti-file-pdf"> </span>Cotización</a><br>
                                          <a href="/viewQuotationFormat/{!!$item->pkQuotations !!}" target="_blank"
                                             class="text-success"><span class="ti-check"> </span>Cotización
                                             Aprobada</a><br>
                                          <a href="{!!$item->xml!!}" target="_blank" download="factura.xml"><span class="ti-file">
                                             </span>XML Factura</a><br>
                                          <a href="{!!$item->pdf!!}" target="_blank" style="color: darkred;"><span
                                                class="ti-file"> </span>PDF Factura</a>

                                          @endif
                                          @else
                                          <a href="/viewQuotationFormatOpen/{!!$item->pkQuotations !!}" target="_blank"
                                             class="text-warning"><span class="ti-file-pdf"> </span>Cotización</a>
                                          @endif
                                       </div>
                                    </td>
                                    <td class="text-center">
                                       <div>

                                             @if(!empty($item->image))
                                             <img style="max-height: 40px;" src="{{ asset('assets/images/business/' . $item->image)}}" class="rounded-circle"> 
                                             @else 
                                             <img style="max-height: 40px;" src="{{ asset('assets/images/business/em.jpg')}}" class="rounded-circle"> 
                                             @endif
                                          
                                          
                                          </div>
                                       <a href="/detEmpresa/{!! $item->pkBusiness !!}"> {!!$item->bussines !!} </a>
                                    </td>

                                    @if($montInfo["$item->pkQuotations"]["status"] >= 4)
                                    <td>
                                       @foreach($montInfo["$item->pkQuotations"]["price"] as $price)
                                       @if($price["isSelected"] == 1)
                                       <span class="text-success">
                                          <n>{!!$price["type"]!!}: </n> $ {!!number_format($price["price"],2)!!}
                                       </span>
                                       @endif
                                       @endforeach
                                    </td>
                                    @else
                                    <td>
                                       @foreach($montInfo["$item->pkQuotations"]["price"] as $price)
                                       <span class="text-success">
                                          <n># {!!$price["num"]!!} {!!$price["type"]!!} :</n> $
                                          {!!number_format($price["price"],2)!!} <br>
                                       </span>
                                       @endforeach
                                    </td>
                                    @endif

                                    <td>
                                       <table class="table display table-bordered table-striped no-wrap">
                                          <thead>
                                             <tr>
                                                <th>#</th>
                                                <th>Tipo</th>
                                                <th>Lugares</th>
                                                <th>Curso</th>
                                                <th>Precio</th>
                                                
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @if(isset($coursesQuotation[$item->pkQuotations]))
                                             @foreach($coursesQuotation[$item->pkQuotations] as $coursesQuotationInfo)
                                             @foreach($coursesQuotationInfo as $detail)

                                             <tr>
                                                @if(isset($detail["qtyPlaces"]))
                                                <td> {!!$detail["num"] !!}</td>
                                                @if($detail["type"] == 0)
                                                <td>Lista</td>
                                                @else
                                                <td>Promocion</td>
                                                @endif
                                                <td> {!! $detail["qtyPlaces"] !!}</td>
                                                <td> {!! $detail["course"] !!}</td>
                                                <td> ${!!number_format($detail["price"],2)!!}</td>
                                                
                                                @endif
                                             </tr>

                                             @endforeach
                                             @endforeach
                                             @endif
                                          </tbody>
                                       </table>
                                    </td>

                                    <td class="text-center align-self-center">
                                       <span class="badge"
                                          style="background-color:{!!$item->color !!}">{!!$item->level !!}</span>
                                    </td>
                                    <td>{!! $item->state !!} <br>{!! $item->country !!}</td>
                                    <td>
                                       {!!$item->quotations_status !!}
                                    </td>
                                    <td style="min-width:150px;">
                                       Asignado:
                                       <div><img style="max-height: 40px;" src="{{ asset('assets/images/usuarios/user.jpg')}}"
                                             class="rounded-circle">{!!$item->agent !!} </div>
                                       <hr style="margin:7px;">
                                       Atendió:<br>
                                       {!!  $item->asing!!}
                                    </td>
                                    <td>
                                       <a href="modalVerActividades" data-toggle="modal"
                                          data-target="#modalVerActividades"><i class="ti-eye"></i>
                                          Ver<br>actividades</a>
                                    </td>
                                    @if($arrayPermition["money"] == 1)
                                    <td class="text-center">
                                       @if($item->quotation_status == 5 || $item->quotation_status == 4)
                                       <div class="custom-control custom-checkbox mb-3">
                                          @if($item->quotation_status < 5) <input type="checkbox"
                                             class="custom-control-input Checkbox" id="check_{!!$item->pkQuotations!!}"
                                             data-id="{!! $item->pkQuotations !!}">
                                             @else
                                             <input type="checkbox" checked="" onclick="javascript: return false;"
                                                class="custom-control-input" id="check_{!!$item->pkQuotations!!}"
                                                data-id="{!! $item->pkQuotations !!}">
                                             @endif
                                             <label class="custom-control-label"
                                                for="check_{!!$item->pkQuotations!!}"></label>
                                       </div>
                                       @else
                                       <span></span>
                                       @endif
                                    </td>
                                    @endif
                                    @if($arrayPermition["editQuotes"] == 1)
                                
                                       @if($item->quotation_status < 4) <span class="cursor-h"><i class="ti-plus"></i>
                                          <td class="text-center btn_viewQuotation" data-id="{!!$item->pkQuotations !!}">
                                          Agregar</span>
                                       </td>
                                          @else
                                       <td>
                                          <span>No editable</span>
                                          @endif
                                       </td>
                                    </td>
                                    @endif
                                    @if($arrayPermition["changeQuotes"] == 1 || $arrayPermition["invoice"] == 1)
                                    <td class="text-center" data-id="{!!$item->pkQuotations !!}">
                                       @if($item->quotation_status < 4 ) <span class="updateStatus cursor-h"
                                          data-id="{!!$item->pkQuotations !!}"><i class="ti-reload"></i> Cambiar
                                          Estatus</span>
                                          @else
                                          @if($arrayPermition["invoice"] == 1)
                                          @if( ($item->quotation_status == 4 || $item->quotation_status == 5) &&
                                          $item->money_in_account == 0)
                                          <span class="paymentQuotation cursor-h" data-id="{!!$item->pkQuotations !!}"><i
                                                class="ti-file"></i> Facturación</span>

                                          @else
                                          <span>Facturada<br><small>No es editable</small></span>
                                          @endif
                                          <hr style="margin:7px;">
                                          @if(!empty($item->pay))
                                          <a href="/images/payment/{!!$item->pay!!}" target="_blank"> <span
                                                class="cursor-h"><i class="ti-image"></i> ver comprobante de
                                                pago</span></a>
                                          @else
                                          <a href="modalPago" class="modalpay" data-toggle="modal"
                                             data-target="#modalPago" data-id="{!!$item->pkQuotations!!}"> <span
                                                class="cursor-h"><i class="ti-image"></i> Agregar<br>comprobante de
                                                pago</span></a>
                                          @endif
                                          @endif
                                    </td>
                                    @endif
                                    @endif
                                    @if($arrayPermition["editQuotes"] == 1)
                                    <td class="text-center">
                                       @if($item->quotation_status < 4) <div class="btn btn-primary btn-sm">
                                          <span class="ti-pencil updateQuotation"
                                             data-id="{!!$item->pkQuotations !!}"></span>
                        </div>

                        @else
                        <div></div>
                        @endif
                        </td>
                        @endif
                        @if($arrayPermition["deleteQuotes"] == 1)
                        <td class="text-center">
                           @if($item->quotation_status < 5) <button class="btn btn-danger btn-sm btn_deleteQuotation"
                              data-id="{!! $item->pkQuotations!!}"><span class="ti-close"></span></button>
                              @else
                              <span>No eliminable</span>
                              @endif
                        </td>
                        @endif
                        </tr>
                        @endforeach

                        </tbody>
                        </table>
                     </div>
                  </div>
                  <!-- oportunidades -->
                  <div class="card-body">
                     <h3>Oportunidades de negocio</h3>
                     <div class="table-responsive m-t-10">
                        <table id="oporNeg" class="table display table-bordered table-striped no-wrap">
                           <thead>
                              <tr>
                                 <th>Fecha</th>
                                 <th>Folio</th>
                                 <th>Empresa</th>
                                 <th>Precio total</th>
                                 <th>Lugares</th>
                                 <th>Estado / País</th>
                                 <th>Nivel de<br>inter&eacute;s</th>
                                 <th>Estatus</th>
                                 <th>Agente</th>
                                 <th>Tiene<br>Presupuesto</th>
                                 @if($arrayPermition["change"] == 1)
                                 <th>Convertir a<br>cotización</th>
                                 @endif
                                 <th>Detalle</th>
                                 @if($arrayPermition["edit"] == 1)
                                 <th>Editar</th>
                                 @endif
                                 @if($arrayPermition["delete"] == 1)
                                 <th>Eliminar</th>
                                 @endif
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($oportunity as $item)
                              <tr>
                                 <td>{!!$item->register_day !!}<br>{!!$item->register_hour !!}</td>
                                 <td>{!!$item->folio !!}</td>
                                 <td class="text-center">
                                       @if(!empty($item->image))
                                       <img style="max-height: 40px;" src="{{ asset('assets/images/business/' . $item->image)}}" class="rounded-circle">
                                       @else
                                       <img style="max-height: 40px;" src="{{ asset('assets/images/business/em.jpg')}}" class="rounded-circle"> 
                                       @endif
                                   
                                    <div>
                                       <a href="/detEmpresa/{!! $item->pkBusiness !!}">{!!$item->bussines !!}</a>
                                    </div>
                                 </td>
                                 <td><span class="label label-success">$
                                       {!!number_format($montWithIva[$item->pkOpportunities],2) !!}</span></td>
                                 <td class="text-center">
                                    <table id="oporNeg" class="table display table-bordered table-striped no-wrap">
                                       <thead>
                                          <tr>
                                             <th>Lugares</th>
                                             <th>Curso</th>
                                             <th>Precio</th>

                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach($oportunityDetail[$item->pkOpportunities] as $oportunityDetailInfo)
                                          <tr>
                                             @if(isset($oportunityDetailInfo["qtyPlaces"]))
                                             <td> {!!$oportunityDetailInfo["qtyPlaces"] !!}</td>
                                             <td width="50px"> {!!$oportunityDetailInfo["course"] !!}</td>
                                             <td> ${!!number_format($oportunityDetailInfo["price"],2)!!}</td>

                                             @endif
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>



                                 </td>
                                 <td>{!!$item->state !!} / {!!$item->country !!}</td>
                                 <td>
                                    <span class="badge badge-pill text-white"
                                       style="background-color:{!!$item->color !!}">{!!$item->level !!}</span>
                                 </td>
                                 <td>
                                    {!!$item->opportunities_status!!}
                                 </td>
                                 <td style="min-width:150px;">
                                    Asignado:
                                    @if(isset($item->agent))
                                    <br><strong>{!!$item->agent!!}</strong>
                                    @else
                                    <br><strong></strong>
                                    @endif
                                    <hr style="margin:7px;">
                                    Atendió:
                                    <br>
                                    @if(isset($item->asing))
                                    <strong>{!!$item->asing  !!}</strong>
                                    @else
                                    <strong></strong>
                                    @endif

                                 </td>
                                 <th class="text-center">
                                    @if($item->isBudget == 0)
                                    <span class="ti-close text-danger">
                                       @endif

                                       @if($item->isBudget == 1)
                                       <span class="ti-check text-success">
                                          @endif

                                          @if($item->isBudget == 2)
                                          <span class="text-warning">Sin definir</span>
                                          @endif

                                 </th>
                                 @if($arrayPermition["change"] == 1)
                                 @if($item->opportunities_statu != 5)
                                 <td class="text-center"><span class="convertToQuotation cursor-h"
                                       data-id="{!! $item->pkOpportunities!!}"><span class="ti-write">
                                       </span>Convertir</span></td>
                                 @else
                                 <td class="text-center"><span>Oportunidad cotizada </span></td>
                                 @endif
                                 <td>
                                    <a href="#" data-id="{!!$item->pkOpportunities!!}" class="viewDetailOportunity"><i
                                          class="ti-eye"></i> Ver<br>detalle</a>
                                 </td>
                                 @endif
                                 <td class="text-center">
                                    @if($arrayPermition["edit"] == 1)
                                    @if($item->opportunities_statu != 5)
                                    <a href="#" data-id="{!! $item->pkOpportunities!!}"
                                       class="btn btn-primary btn-sm btn_editOportunity"> <span class="ti-pencil">
                                       </span></a>
                                    @else
                                    <span> No editable </span>
                                    @endif
                                    @endif
                                 </td>

                                 <td class="text-center">
                                    @if($arrayPermition["delete"] == 1)
                                    @if($item->opportunities_statu != 5)
                                    <button class="btn btn-danger btn-sm btn_deleteOportunity"
                                       data-id="{!! $item->pkOpportunities!!}">
                                       <span class="ti-close"></span></button>
                                    @else
                                    <span> No eliminable </span>
                                    @endif
                                    @endif
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <!-- Menús -->
               <div class="card">
                  <div class="card-body">
                     <div class="tabs-cliente customvtab">
                        <div class="row">
                           <div class="col-md-2 col-sm-3">
                              <ul class="nav nav-tabs tabs-vertical" role="tablist">

                                 <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#crearOportE" role="tab"><span
                                          class="hidden-sm-up"><i class="ti-light-bulb"></i></span> <span
                                          class="hidden-xs-down">Crear Oportunidad de Negocio</span></a>
                                 </li>

                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#crearCotE" role="tab"><span
                                          class="hidden-sm-up"><i class="ti-write"></i></span> <span
                                          class="hidden-xs-down">Crear Cotización</span></a>
                                 </li>
                                 <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#registarActE" role="tab"><span
                                          class="hidden-sm-up"><i class="ti-notepad"></i></span> <span
                                          class="hidden-xs-down">Registrar una actividad</span></a>
                                 </li>
                              </ul>
                           </div>
                           <div class="col-md-10 col-sm-9">
                              <!-- Tab panes -->
                              <div class="tab-content">
                                 <div class="tab-pane active" id="crearOportE" role="tabpanel">
                                    <div class="p-20">
                                       <h3>Crear Oportunidad de Negocio</h3>
                                       <form>
                                          <div class="row pt-3">
                                             <div class="col-md-5">
                                                <div class="form-group">
                                                   <label class="control-label">Empresa *</label>
                                                   <div class="input-group">
                                                      <div class="input-group-prepend">
                                                         <span class="input-group-text" id="basic-addon11"><i
                                                               class="ti-bookmark"></i></span>
                                                      </div>
                                                      <input autocomplete="off" type="text" data-id="{!!$id!!}"
                                                         id="slcBussines2" value="{!!$Bussiness->name!!}"
                                                         class="autocomplete_bussines2 form-control" readonly>
                                                   </div>
                                                   <div class="search-header-bussines2">
                                                   </div>
                                                   <div class="search__border"></div>
                                                </div>

                                             </div>
                                             <div class="col-md-5">
                                                <div class="form-group">
                                                   <label class="control-label">Contacto</label>
                                                   <select id="slcContact2" class="form-control custom-select"
                                                      data-placeholder="Elige empresa" tabindex="1">
                                                      <option value="-1">Selecciona un contacto</option>
                                                      @foreach($contact as $item)
                                                      <option value="{!!$item->pkContact_by_business!!}">{!! $item->name
                                                         !!} </option>
                                                      @endforeach
                                                   </select>
                                                </div>

                                             </div>
                                             <div class="col-md-2">
                                                <div class="form-group">
                                                   <button type="button" class="btn btn-success btn-addContact2 m-t-30" style="font-size: 13px;padding:3px 5px;line-height: 1.1;">Agregar
                                                      Contacto</button>
                                                </div>
                                             </div>
                                             <div id="coursesOportunity">
                                                <div class="row coursesOportunity" data-id="1">
                                                   <div class="col-md-5">
                                                      <div class="form-group">
                                                         <label class="control-label">Cantidad de colaboradores /
                                                            lugares
                                                            <span class="text-primary" href="#" data-toggle="tooltip"
                                                               data-html="true" title="Detectar la cantidad de empleados que tiene la empresa: 
                                      <ul class='sin-type'>
                                      <li>- Cantidad total de su personal</li>
                                      <li>- Cantidad de personal que requiere capacitar</li>
                                      <li>- Del Personal a Capacitar, todos son internos o tambien son externos (contratistas) </li>
                                      </ul>
                                      * * Atención: No todas las empresas requieren Contratistas."><i
                                                                  class="ti-info-alt"></i>
                                                            </span>
                                                         </label>
                                                         <div class="input-group">
                                                            <div class="input-group-prepend">
                                                               <span class="input-group-text" id="basic-addon11"><i
                                                                     class="fas fa-hashtag"></i></span>
                                                            </div>
                                                            <input id="qtyEmployeeOp_1" type="number" data-id="1"
                                                               class="form-control qtyEmployeeOp" placeholder="0">
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label class="control-label">Cursos
                                                            <span class="text-primary" href="#" data-toggle="tooltip"
                                                               data-html="true" title="Detectar la Cantidad de Riesgos que la empresa tiene o la cantidad de Cursos que necesita:
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
                                                            <option value="{!! $item->pkCourses !!}">{!!$item->code !!} -
                                                               {!! $item->name!!}</option>
                                                            @endforeach
                                                         </select>
                                                      </div>

                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label class="control-label">Precio total</label>
                                                         <div class="input-group">
                                                            <div class="input-group-prepend">
                                                               <span class="input-group-text" id="basic-addon11"><i
                                                                     class="ti-money"></i></span>
                                                            </div>
                                                            <input id="precioOp_1" data-id="0" type="text"
                                                               class="form-control price2" placeholder="$ 0.00">
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <input type="hidden" id="countOportunity" value="2" />
                                             <div class="col-12 text-right">
                                                <div class="form-group">
                                                   <div style="margin-top: 15px;"><button type="button"
                                                         class="btn btn-secondary" id="addMoreCourseOportunity"><span
                                                            class="ti-plus"></span> Agregar Más Cursos</button></div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label class="control-label">Subtotal</label>
                                                      <div class="input-group">
                                                         <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i
                                                                  class="ti-money"></i></span>
                                                         </div>
                                                         <input id="subOp_1" disabled="true" data-id="0" data-iva="0"
                                                            type="text" class="form-control subOp" placeholder="$ 0.00">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label class="control-label">Descuento</label>
                                                      <div class="input-group">
                                                         <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i
                                                                  class="ti-money"></i></span>
                                                         </div>
                                                         <input id="descOp_1" disabled="true" data-id="0" data-iva="0"
                                                            type="text" class="form-control descOp"
                                                            placeholder="$ 0.00">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label class="control-label">Total</label>
                                                      <div class="input-group">
                                                         <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i
                                                                  class="ti-money"></i></span>
                                                         </div>
                                                         <input id="totalOp_1" disabled="true" data-id="0" data-iva="0"
                                                            type="text" class="form-control totalOp"
                                                            placeholder="$ 0.00">
                                                      </div>
                                                   </div>
                                                </div>

                                                <div class="col-md-2">
                                                   <div class="form-group">
                                                      <button type="button" style="margin-top:30px"
                                                         class="btn btn-secondary recalcularOP" data-id="1"
                                                         id="recalcular">Recalcular</button>
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
                                                      <span class="text-primary" href="#" data-toggle="tooltip"
                                                         data-html="true" title="Detectar la Detectar la fecha en que planean llevar a cabo la capacitación, por ejemplo: 
                                          <ul class='sin-type'>
                                          <li>• Señor ¿para cuándo o en qué fecha requiere capacitar a su personal?</li>
                                          <li>• ¿En qué fecha tiene planeado iniciar la capacitación de su personal?</li>
                                          <li>• ¿Tiene ya una fecha estimada para iniciar los cursos de capacitación para su personal?</li>
                                          </ul>"><i class="ti-info-alt"></i>
                                                      </span>
                                                   </label>
                                                   <div class="input-group">
                                                      <div class="input-group-prepend">
                                                         <span class="input-group-text" id="basic-addon11"><i
                                                               class="ti-calendar"></i></span>
                                                      </div>
                                                      <input id="requicapa" type="text" class="form-control">
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
                                                      <span class="text-primary" href="#" data-toggle="tooltip"
                                                         data-html="true" title="Detectar si la empresa cuenta con presupuesto para Capacitación:
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
                                                            <input type="radio" class="custom-control-input"
                                                               name="pres2" value="1" id="customradio12">
                                                            <label class="custom-control-label"
                                                               for="customradio12">Sí</label>
                                                         </div>
                                                         <div class="custom-control custom-radio mr-4">
                                                            <input type="radio" class="custom-control-input"
                                                               name="pres2" value="0" id="customradio22">
                                                            <label class="custom-control-label"
                                                               for="customradio22">No</label>
                                                         </div>
                                                         <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                               name="pres2" value="2" id="customradio222">
                                                            <label class="custom-control-label" for="customradio222">Sin
                                                               Definir</label>
                                                         </div>
                                                      </div>
                                                      <textarea id="comentPresupuesto" class="form-control"
                                                         cols="1"></textarea>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">Necesidades y temores
                                                      <span class="text-primary" href="#" data-toggle="tooltip"
                                                         data-html="true" title="Detectar Problema a resolver. La Propuesta de Valor de Abrevius esta diseñada para resolver la gran mayoría de los Problemas en capacitación de las empresas, el Asesor deberá estar alerta para detectarlos, tomar nota y atacar por ahí para cerrar la venta, por ejemplo:
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
                                                         <span class="input-group-text" id="basic-addon11"><i
                                                               class="ti-user"></i></span>
                                                      </div>
                                                      <select id="slcAgent2" class="form-control custom-select"
                                                         data-placeholder="Elige Agente" tabindex="1">
                                                         <option value="-1">Selecciona un Agente</option>
                                                         @foreach($agent as $item)
                                                         <option value="{!! $item->pkUser !!}">{!! $item->full_name!!}
                                                         </option>
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">Nivel de interés</label>
                                                   <select id="level2" class="form-control custom-select"
                                                      data-placeholder="Elige Nivel de interés" tabindex="1">
                                                      <option value="-1">Selecciona un nivel</option>
                                                      @foreach($level as $item)
                                                      <option value="{!! $item->pkLevel_interest !!}">{!! $item->text!!}
                                                      </option>
                                                      @endforeach
                                                   </select>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">Forma de pago</label>
                                                   <select id="slcPayment2" class="form-control custom-select"
                                                      data-placeholder="Elige el estatus" tabindex="1">
                                                      <option value="-1">Selecciona una forma de pago</option>
                                                      @foreach($payment as $item)
                                                      <option value="{!! $item->pkPayment_methods !!}">{!! $item->name!!}
                                                      </option>
                                                      @endforeach
                                                   </select>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">Campaña</label>
                                                   <select id="campaning" class="form-control custom-select"
                                                      data-placeholder="Elige el estatus" tabindex="1">
                                                      @if(sizeof($companis) > 0)
                                                      <option value="-1">Selecciona una campaña</option>
                                                      @foreach($companis as $item)
                                                      <option value="{!! $item->pkCommercial_campaigns !!}">{!!
                                                         $item->name!!}</option>
                                                      @endforeach
                                                      @else
                                                      <option value="-1">No existen campañas actualmente</option>
                                                      @endif
                                                   </select>
                                                </div>
                                             </div>
                                             <div class="col-md-12 text-right">
                                                <button type="button" class="btn btn-success"
                                                   id="createOportunity2"><span class="ti-check"></span> Crear</button>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>

                                 <div class="tab-pane p-20" id="crearCotE" role="tabpanel">
                                    <h3>Nueva Cotización</h3>
                                    <form>
                                       <div class="row pt-3">
                                          <!--   <div class="col-md-12">
                          <div class="form-group">
                              <label class="control-label">Nombre de la cotización</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon11"><i class="ti-write"></i></span>
                                </div>
                                <input type="text" id="name3" class="form-control">
                              </div>
                          </div>
                      </div>-->
                                          <div class="col-md-5">

                                             <div class="form-group">
                                                <label class="control-label">Empresa *</label>
                                                <div class="input-group">
                                                   <div class="input-group-prepend">
                                                      <span class="input-group-text" id="basic-addon11"><i
                                                            class="ti-bookmark"></i></span>
                                                   </div>
                                                   <input autocomplete="off" type="text" data-id="{!!$id!!}"
                                                      id="slcBussines3" class="autocomplete_bussines3 form-control"
                                                      value="{!!$Bussiness->name!!}" readonly>
                                                </div>
                                                <div class="search-header-bussines3">
                                                </div>
                                                <div class="search__border"></div>
                                             </div>

                                          </div>
                                          <div class="col-md-5">
                                             <div class="form-group">
                                                <label class="control-label">Contacto</label>
                                                <select id="slcContact3" class="form-control custom-select"
                                                   data-placeholder="Elige empresa" tabindex="1">
                                                   <option value="-1">Selecciona un contacto</option>
                                                   @foreach($contact as $item)
                                                   <option value="{!!$item->pkContact_by_business!!}">{!! $item->name !!}
                                                   </option>
                                                   @endforeach
                                                </select>
                                             </div>

                                          </div>
                                          <div class="col-md-2">
                                             <div class="form-group">
                                                <button type="button"
                                                   class="btn btn-success btn-addContact m-t-30" style="font-size: 13px;padding:3px 5px;line-height: 1.1;">Agregar
                                                   Contacto</button>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="control-label">Agente a asignar</label>
                                                <div class="input-group">
                                                   <div class="input-group-prepend">
                                                      <span class="input-group-text" id="basic-addon11"><i
                                                            class="ti-user"></i></span>
                                                   </div>
                                                   <select id="slcAgent3" class="form-control custom-select"
                                                      data-placeholder="Elige Agente" tabindex="1">
                                                      <option value="-1">Selecciona un Agente</option>
                                                      @foreach($agentQuotation as $item)
                                                      <option value="{!! $item->pkUser !!}">{!! $item->full_name!!}</option>
                                                      @endforeach
                                                   </select>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="control-label">Nivel de interés</label>
                                                <select id="level3" class="form-control custom-select"
                                                   data-placeholder="Elige Nivel de interés" tabindex="1">
                                                   <option value="-1">Selecciona un nivel</option>
                                                   @foreach($level as $item)
                                                   <option value="{!! $item->pkLevel_interest !!}">{!! $item->text!!}
                                                   </option>
                                                   @endforeach
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-group">
                                                <label class="control-label">Forma de pago</label>
                                                <select id="slcPayment3" class="form-control custom-select"
                                                   data-placeholder="Elige el estatus" tabindex="1">
                                                   <option value="-1">Selecciona una forma de pago</option>
                                                   @foreach($payment as $item)
                                                   <option value="{!! $item->pkPayment_methods !!}">{!! $item->name!!}
                                                   </option>
                                                   @endforeach
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-group">
                                                <label class="control-label">Campaña</label>
                                                <select id="campaningq" class="form-control custom-select"
                                                   data-placeholder="Elige el estatus" tabindex="1">
                                                   @if(sizeof($companis) > 0)
                                                   <option value="-1">Selecciona una campaña</option>
                                                   @foreach($companis as $item)
                                                   <option value="{!! $item->pkCommercial_campaigns !!}">{!!
                                                      $item->name!!}</option>
                                                   @endforeach
                                                   @else
                                                   <option value="-1">No existen campañas actualmente</option>
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
                                                         <input checked="true" type="radio" class="custom-control-input"
                                                            name="iva" value="1" id="withIva">
                                                         <label class="custom-control-label" for="withIva">Sí</label>
                                                      </div>
                                                      <div class="custom-control custom-radio mr-4">
                                                         <input type="radio" class="custom-control-input" name="iva"
                                                            value="0" id="withNoIva">
                                                         <label class="custom-control-label" for="withNoIva">No</label>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-12" id="addContentOPcion2">
                                             <div class="contentNewOpcion2">
                                                <div class="row" style="background:#dadada;padding: 5px 10px;margin-bottom: 15px;">
                                                   <div class="col-sm-4">
                                                      <div class="nav-small-cap mb-0">- - - OPCIÓN 1</div>
                                                   </div>
                                                   <div class="col-sm-8">
                                                      <div class="form-group d-flex mb-0">
                                                         <label class="control-label mr-5 mb-0">Tipo de precio</label>
                                                         <div class="custom-control custom-radio mr-4">
                                                            <input type="radio" class="custom-control-input typePriN"
                                                               name="typePrice21" checked value="0" id="rNorma">
                                                            <label class="custom-control-label"
                                                               for="rNorma">Normal</label>
                                                         </div>
                                                         <div class="custom-control custom-radio mr-4">
                                                            <input type="radio" class="custom-control-input typePriP"
                                                               name="typePrice21" value="1" id="rProm">
                                                            <label class="custom-control-label"
                                                               for="rProm">Promoción</label>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="form-row">

                                                   <div id="coursesQuotation_1" class="coursesQuotation">
                                                      <div class="row coursesQuotation_1 coursesQuotation_detail"
                                                         data-id="1">
                                                         <div class="col-md-2">
                                                            <div class="form-group">
                                                               <label class="control-label">Cantidad de colaboradores /
                                                                  lugares

                                                               </label>
                                                               <div class="input-group">
                                                                  <div class="input-group-prepend">
                                                                     <span class="input-group-text"
                                                                        id="basic-addon11"><i
                                                                           class="fas fa-hashtag"></i></span>
                                                                  </div>
                                                                  <input id="qtyEmployeeQ_1_1" type="number" data-op="1"
                                                                     data-id="1" class="form-control qtyEmployeeQ"
                                                                     placeholder="0">
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-4" style="margin-top: 40px">
                                                            <div class="form-group">
                                                               <label class="control-label">Cursos

                                                               </label>

                                                               <select id="slcCourseQ_1_1"
                                                                  class="form-control slcCourseQ">
                                                                  <option value="-1">Sin definir</option>
                                                                  @foreach($courses as $item)
                                                                  <option value="{!! $item->pkCourses !!}">
                                                                     {!!$item->code !!} - {!! $item->name!!}</option>
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
                                                                  <input id="precioU_1_1" data-id="0" data-iva-="0"
                                                                     type="text" class="form-control precioU"
                                                                     placeholder="$ 0.00">
                                                               </div>
                                                            </div>
                                                         </div>

                                                         <div class="col-md-3" style="margin-top: 40px">
                                                            <div class="form-group">
                                                               <label class="control-label">Precio total</label>
                                                               <div class="input-group">
                                                                  <div class="input-group-prepend">
                                                                     <span class="input-group-text"
                                                                        id="basic-addon11"><i
                                                                           class="ti-money"></i></span>
                                                                  </div>
                                                                  <input id="precioQ_1_1" data-id="0" data-iva-="0"
                                                                     type="text" class="form-control precioQ"
                                                                     placeholder="$ 0.00">
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="col-12 text-right">
                                                      <div class="form-group">
                                                         <div style="margin-top:0px;"><button type="button"
                                                               class="btn btn-secondary addMoreCourseQuotation"
                                                               data-id="1" id="addMoreCourseQuotation"><span
                                                                  class="ti-plus"></span> Agregar Más Cursos</button>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="row">
                                                      <div class="col-md-3">
                                                         <div class="form-group">
                                                            <label class="control-label">Subtotal</label>
                                                            <div class="input-group">
                                                               <div class="input-group-prepend">
                                                                  <span class="input-group-text" id="basic-addon11"><i
                                                                        class="ti-money"></i></span>
                                                               </div>
                                                               <input id="subQ_1" disabled="true" data-id="0"
                                                                  data-iva="0" type="text" class="form-control subQ"
                                                                  placeholder="$ 0.00">
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-3">
                                                         <div class="form-group">
                                                            <label class="control-label">Descuento</label>
                                                            <div class="input-group">
                                                               <div class="input-group-prepend">
                                                                  <span class="input-group-text" id="basic-addon11"><i
                                                                        class="ti-money"></i></span>
                                                               </div>
                                                               <input id="descQ_1" disabled="true" data-id="0"
                                                                  data-iva="0" type="text" class="form-control descQ"
                                                                  placeholder="$ 0.00">
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-3">
                                                         <div class="form-group">
                                                            <label class="control-label">Total</label>
                                                            <div class="input-group">
                                                               <div class="input-group-prepend">
                                                                  <span class="input-group-text" id="basic-addon11"><i
                                                                        class="ti-money"></i></span>
                                                               </div>
                                                               <input id="totalQ_1" data-row="1" disabled="true" data-id="0"
                                                                  data-iva="0" type="text" class="form-control totalQ"
                                                                  placeholder="$ 0.00">
                                                            </div>
                                                         </div>
                                                      </div>

                                                      <div class="col-md-1" >
                                                         <div class="form-group">

                                                            <button type="button" style="margin-top:30px; display:none"
                                                            class="btn btn-danger CanceleditTotal" data-id="1"
                                                            id="CanceleditTotal_1"><span class="ti-close"></span></button>

                                                            <button type="button" style="margin-top:30px;display:block"
                                                               class="btn btn-primary editTotal" data-id="1"
                                                               id="editTotal_1"><span class="ti-pencil-alt"></span></button>
                                                         </div>
                                                      </div>
                                                      
                                                      <input type="hidden" id="editQ_1" class="editQ" value="0">

                                                      <div class="col-md-2">
                                                         <div class="form-group">
                                                            <button type="button" style="margin-top:30px"
                                                               class="btn btn-secondary recalcular" data-id="1"
                                                               id="recalcular">Recalcular</button>
                                                         </div>
                                                      </div>

                                                   </div>
                                                   <input type="hidden" id="countQuotation_1" value="2" />


                                                   <div class="col-sm-6">
                                                      <label class="control-label">Vigencia Opción 1</label>
                                                      <div class="input-group">
                                                         <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i
                                                                  class="ti-calendar"></i></span>
                                                         </div>
                                                         <input type="date" id="vigencia"
                                                            class="form-control vigencia2">
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <input type="hidden" id="count2" value="2" />
                                          <div class="col-12">
                                             <div class="form-group">
                                                <div class="add-user" style="margin-top: 15px;"><button type="button"
                                                      class="btn btn-secondary" id="addMoreOpcion2"><span
                                                         class="ti-plus"></span> Agregar Más Opciones</button></div>
                                             </div>
                                          </div>
                                          <div class="col-md-12 text-right">
                                             <button type="button" class="btn btn-success"
                                                id='btnCreateQuotation2'><span class="ti-check"></span> Crear</button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>

                                 <div class="tab-pane p-20" id="registarActE" role="tabpanel">
                                    <div class="pt-3">
                                       <h3>Registar una actividad</h3>
                                       <form id="createActivity" action="/createActivity">
                                          <div class="row pt-3">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">Empresa</label>
                                                   <div class="input-group">
                                                      <div class="input-group-prepend">
                                                         <span class="input-group-text" id="basic-addon11"><i
                                                               class="ti-bookmark"></i></span>
                                                      </div>
                                                      <select class="form-control custom-select" id="activityBusiness"
                                                         data-placeholder="Selecciona una empresa" tabindex="1"
                                                         readonly>

                                                         @foreach($businessQuery as $businessInfo)
                                                         @if($Bussiness->pkBusiness == $businessInfo->pkBusiness)
                                                         <option selected value="{!!$businessInfo->pkBusiness!!}">
                                                            {!!html_entity_decode($businessInfo->name)!!}</option>
                                                         @endif
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">Negocios abiertos</label>
                                                   <select class="form-control custom-select" id="type_event_business"
                                                      data-placeholder="Selecciona el tipo de negocio" tabindex="1">
                                                      {!! $option !!}
                                                   </select>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">Agente</label>
                                                   <div class="input-group">
                                                      <div class="input-group-prepend">
                                                         <span class="input-group-text" id="basic-addon11"><i
                                                               class="ti-user"></i></span>
                                                      </div>
                                                      <select class="form-control custom-select" id="userAgent"
                                                         data-placeholder="Selecciona el Agente" tabindex="1">
                                                         <option value="-1">Seleccionar agente</option>
                                                         @foreach($usersQuery as $usersInfo)
                                                         <option value="{!!$usersInfo->pkUser!!}">
                                                            {!!html_entity_decode($usersInfo->full_name)!!}
                                                            ({!!html_entity_decode($usersInfo->type_name)!!})</option>
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">Tipo de Actividad</label><br>
                                                   <!--div class="color-act">
                                                              <label class="btn" style="background-color:coral;">
                                                                  <div class="custom-control custom-radio">
                                                                      <input type="radio" id="customRadio1" name="options" value="male" class="custom-control-input">
                                                                      <label class="custom-control-label" for="customRadio1">Llamadas</label>
                                                                  </div>
                                                              </label>
                                                              <label class="btn" style="background-color:pink;">
                                                                  <div class="custom-control custom-radio">
                                                                      <input type="radio" id="customRadio2" name="options" value="female" class="custom-control-input">
                                                                      <label class="custom-control-label" for="customRadio2">Visitas</label>
                                                                  </div>
                                                              </label>
                                                              <label class="btn" style="background-color:darksalmon;">
                                                                  <div class="custom-control custom-radio">
                                                                      <input type="radio" id="customRadio3" name="options" value="n/a" class="custom-control-input">
                                                                      <label class="custom-control-label" for="customRadio3">Email</label>
                                                                  </div>
                                                              </label>
                                                          </div-->
                                                   <select class="form-control custom-select" id="type_activity"
                                                      data-placeholder="Selecciona la Actividad" tabindex="1">
                                                      <option value="-1">Selecciona el tipo de actividad</option>
                                                      @foreach($activitiesTypeQuery as $activitiesTypeInfo)
                                                      <option value="{!!$activitiesTypeInfo->pkActivities_type!!}">
                                                         {!!$activitiesTypeInfo->text!!}</option>
                                                      @endforeach
                                                   </select>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">Texto</label>
                                                   <textarea style="resize:auto" class="form-control" rows="4" id="description"
                                                      placeholder="Descripción de la actividad"></textarea>
                                                </div>
                                             </div>
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                   <label class="control-label">Fecha</label>
                                                   <div class="input-group">
                                                      <div class="input-group-prepend">
                                                         <span class="input-group-text" id="basic-addon11"><i
                                                               class="ti-calendar"></i></span>
                                                      </div>
                                                      <input type="date" id="date" class="form-control">
                                                   </div><br/>
                                                   <span>Nota: El registro de esta actividad se verá reflejada en el calendario </span>
                                                </div>
                                             </div>
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                   <label class="control-label">Hora</label>
                                                   <div class="input-group">
                                                      <div class="input-group-prepend">
                                                         <span class="input-group-text" id="basic-addon11"><i
                                                               class="ti-time"></i></span>
                                                      </div>
                                                      <input type="time" id="hour" class="form-control">
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label">Adjuntar documento</label>
                                                   <div class="input-group">
                                                      <div class="input-group-prepend">
                                                         <span class="input-group-text" id="basic-addon11"><i
                                                               class="ti-image"></i></span>
                                                      </div>
                                                      <div class="custom-file">
                                                         <input type="file" id="document" class="custom-file-input"
                                                            id="customFileLang" lang="es">
                                                         <label class="custom-file-label form-control"
                                                            for="customFileLang">Seleccionar Archivo</label>
                                                      </div>
                                                   </div>
                                                </div>
                                                
                                             </div>
                                             <div class="col-md-4">
                                             <div class="form-group">
                                                <label class="control-label">Campaña</label>
                                                <select id="campaningAc" class="form-control custom-select"
                                                   data-placeholder="Elige el estatus" tabindex="1">
                                                   @if(sizeof($companis) > 0)
                                                   <option value="-1">Selecciona una campaña</option>
                                                   @foreach($companis as $item)
                                                   <option value="{!! $item->pkCommercial_campaigns !!}">{!!
                                                      $item->name!!}</option>
                                                   @endforeach
                                                   @else
                                                   <option value="-1">No existen campañas actualmente</option>
                                                   @endif
                                                </select>
                                             </div>
                                          </div>
                                             <div class="col-md-12 text-right">
                                                <button class="btn btn-success"><span class="ti-check"></span>Crear</button>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Timeline -->
               <div class="card">
                  <div class="card-body">
                     <h3 class="card-title">Línea del tiempo</h3>
                     <div>
                        <select class="form-control custom-select" id="slcSearchLine"
                           data-placeholder="Selecciona la Actividad" tabindex="1">
                           <option value="-1">Selecciona el tipo de actividad</option>
                           @foreach($arrayFilter as $activities)
                           <option data-bu="{!!$Bussiness->pkBusiness !!}" data-id="{!!$activities['type']!!}"
                              value="{!!$activities['id']!!}">{!!$activities['desc']!!}</option>
                           @endforeach
                        </select>
                     </div>
                     <ul class="timeline">
                        @php $cont = 0; @endphp
                        @foreach($arrayLineTime as $item)
                        @if($cont%2==0)
                        <li>
                           @else
                        <li class="timeline-inverted">
                           @endif
                           <div class="timeline-badge" style="background-color:{!!$item['color']!!}"><i class="{!!$item['icon']!!}"></i> </div>
                           <div class="timeline-panel">
                              <div class="timeline-heading">
                                 <h4 class="timeline-title">{!! $item["desc"]!!}</h4>
                                 <p>
                                    <small class="text-muted"><i class="ti-calendar"></i> {!!$item["register_day"]!!} {!! $item["register_hour"]!!} </small>
                                    <small class="pl-2 text-muted"><i class="ti-user"></i> {!!$item["full_name"] !!}</small> 
                                    <small class="pl-2 text-muted"><i class="{{ $item['icon'] }}"></i> {{ $item['type_name'] }} </small> 
                                    <a href="/calendario/{{ $item['moth'] }}" target="_blank" class="pull-right btn btn-circle btn-success"><i class="ti-calendar"></i></a>
                                 </p>
                              </div>
                              <div class="timeline-body">
                                @if(!empty($item["document"]))
                                  <a href="/files/file/{{$item["document"]}}" download><i class="ti-download"></i> Descargar adjunto</a>
                                  @endif
                              </div>
                           </div>
                        </li>
                        @php $cont++; @endphp
                        @endforeach

                     </ul>
                  </div>
               </div>
            </div>

         </div>

         <!-- End Page Content -->

      </div><!-- End Container fluid  -->
   </div><!-- End Page wrapper  -->

   @include('includes.footer')
   <!-- End footer -->
   </div><!-- End Wrapper -->

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

   <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditUsuario"
      class="modalEditUsuario"></button>
   <!-- Convertir -->
   <div class="modal fade modal-gde" id="modalEditUsuario" tabindex="-1" role="dialog"
      aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalUsuario" role="document">

      </div>
   </div>

   <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditCategoria"
      class="modalEditCategoria"></button>
   <!-- Convertir -->
   <div class="modal fade modal-gde" id="modalEditCategoria" tabindex="-1" role="dialog"
      aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalEditCat" role="document">

      </div>
   </div>

   <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h2 class="modal-title" id="modalAgentesCLabel">Agregar comprobante de pago</h2>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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

   <!-- Modal Actividades -->
   <div class="modal fade" id="modalVerActividades" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h2 class="modal-title" id="modalAgentesCLabel">Actividades de la cotización</h2>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="c-act">
                  <div class=" mb-4">
                     Última actividad:
                     @if(!empty($item->lastActivity))
                     <span> {!!$item->lastActivity!!} </span>
                     @else
                     <span>-</span>
                     @endif
                  </div>
                  <div>
                     Siguiente actividad:
                     @if(!empty($item->nextActivity))
                     <span> {!!$item->nextActivity!!} </span>
                     @else
                     <span>-</span>
                     @endif
                     <div>
                        Vencimiento:
                        @if(!empty($item->finalActivity))
                        <span>{!!$item->finalActivity!!} </span>
                        @else
                        <span>-</span>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
         </div>
      </div>
   </div>


   @include('includes.scriptSnGrafic')
   <script>
   $(function() {
      $('#cotizaciones').DataTable({
         dom: 'Bfrtip',
         "order": [],
         buttons: [
            'excel'
         ]
      });
      $('#oporNeg').DataTable({
         dom: 'Bfrtip',
         "order": [],
         buttons: [
            'excel'
         ]
      });
      $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
         'btn btn-primary mr-1');
   });
   </script>

   <!-- End scripts  -->
</body>


</html>