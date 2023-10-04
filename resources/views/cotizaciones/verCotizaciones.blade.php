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
                  <h4 class="text-themecolor">Cotizaciones</h4>
               </div>
               <div class="col-md-7 align-self-center text-right">
                  <div class="d-flex justify-content-end align-items-center">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                        <li class="breadcrumb-item active">Cotizaciones</li>
                     </ol>

                  </div>
               </div>
            </div>
            @if($arrayPermition["viewQuotes"] == 1)
            <!-- Tablas -->
            <div class="row">
               <div class="col-12">

                  <!-- Campañas -->
                  <div class="card">
                     <div class="card-body">
                        <h4 class="card-title">Cotizaciones <span class="f-right text-success totalQuotation">$
                              {{number_format($quotationMonth,2) }}</span></h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                           <label class="btn btn-secondary searchInfoQuotation" data-id="1">
                              <input type="radio" name="options2" id="option1" autocomplete="off" checked=""> Día
                           </label>
                           <label class="btn btn-secondary searchInfoQuotation" data-id="2">
                              <input type="radio" name="options2" id="option2" autocomplete="off"> Mes
                           </label>
                           <label class="btn btn-secondary searchInfoQuotation active" data-id="3">
                              <input type="radio" name="options2" id="option3" autocomplete="off"> Año
                           </label>
                        </div>
                        <hr>
                        <div class="row">
                           <div class="col-md-3 col-sm-6 m-t-30">
                              <select class="form-control custom-select" id="status"
                                 data-placeholder="Selecciona la Actividad" tabindex="1">
                                 <option value="-1">Estatus</option>
                                 <option value="1">Abiertas</option>
                                 <option value="4">Revision</option>
                                 <option value="5">Pagada</option>
                                 <option value="2">Rechazadas</option>
                                 <option value="3">Canceladas</option>
                              </select>
                           </div>
                           <div class="col-md-3 col-sm-6 m-t-30">
                              <select class="form-control custom-select" id="agent"
                                 data-placeholder="Selecciona la Actividad" tabindex="1">
                                 <option value="-1">Agente</option>
                                 @foreach($agent as $info)
                                 <option value="{{$info->pkUser }}">{!!$info->full_name!!}</option>
                                 @endforeach
                              </select>
                           </div>

                           <div class="col-md-3 col-sm-6">
                              <div class="form-group">
                                 <label class="control-label">Fecha Desde</label>
                                 <div class="input-group">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text" id="basic-addon11"><i
                                             class="ti-calendar"></i></span>
                                    </div>
                                    <input type="date" id="date_start" class="form-control">
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-3 col-sm-6">
                              <div class="form-group">
                                 <label class="control-label">Fecha Hasta</label>
                                 <div class="input-group">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text" id="basic-addon11"><i
                                             class="ti-calendar"></i></span>
                                    </div>
                                    <input type="date" id="date_finish" class="form-control">
                                 </div>
                              </div>
                           </div>

                           <div class="col-12 text-right">
                              <button type="button" class="dt-button buttons-excel buttons-html5 btn btn-primary mr-1"
                                 id="search_quotation">Buscar</button>
                           </div>
                        </div>
                        <div class="table-responsive m-t-40" id="cotizacionesDiv">
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
                                       {{ $item->register_day }}<br>{{ $item->register_hour }}
                                    </td>
                                    <td>
                                       <div class="c-folio  badge badge-pill badge-dark"><small>folio: #</small>
                                          {{$item->folio }}</div>
                                       <div class="c-docs">
                                          <div>
                                             <hr style="margin:7px;"><small>DOCUMENTOS:</small></div>
                                          @if($item->quotation_status > 1)
                                          @if( ($item->quotation_status == 4 || $item->quotation_status == 5) &&
                                          $item->money_in_account == 0)
                                          <a href="/viewQuotationFormatOpen/{{$item->pkQuotations }}" target="_blank"
                                             class="text-warning"><span class="ti-file-pdf"> </span>Cotización</a>
                                          <br>
                                          <a href="/viewQuotationFormat/{{$item->pkQuotations }}" target="_blank"
                                             class="text-success"><span class="ti-check"> </span>Cotización Aprobada</a>
                                          @endif
                                          @if($item->money_in_account == 1)
                                          <a href="/viewQuotationFormatOpen/{{$item->pkQuotations }}" target="_blank"
                                             class="text-warning"><span class="ti-file-pdf"> </span>Cotización</a><br>
                                          <a href="/viewQuotationFormat/{{$item->pkQuotations }}" target="_blank"
                                             class="text-success"><span class="ti-check"> </span>Cotización
                                             Aprobada</a><br>
                                          <a href="/dowloadXML/{{$item->pkQuotations}}" target="_blank"><span class="ti-file">
                                             </span>XML Factura</a><br>
                                          <a href="{{$item->pdf}}" target="_blank" style="color: darkred;"><span
                                                class="ti-file"> </span>PDF Factura</a>

                                          @endif
                                          @else
                                          <a href="/viewQuotationFormatOpen/{{$item->pkQuotations }}" target="_blank"
                                             class="text-warning"><span class="ti-file-pdf"> </span>Cotización</a>
                                          @endif
                                       </div>
                                    </td>
                                    <td class="text-center">
                                       <div>
                                          @if(!empty($item->image))
                                          <img style="max-height: 40px;" src="{{ asset('assets/images/business/' . $item->image)}}"
                                             class="rounded-circle">
                                          @else
                                          <img style="max-height: 40px;" src="{{ asset('assets/images/business/em.jpg')}}"
                                             class="rounded-circle">
                                          @endif
                                       </div>
                                       <a href="/detEmpresa/{{ $item->pkBusiness }}"> {!!$item->bussines !!} </a>
                                    </td>

                                    @if($montInfo["$item->pkQuotations"]["status"] >= 4)
                                    <td>
                                       @foreach($montInfo["$item->pkQuotations"]["price"] as $price)
                                       @if($price["isSelected"] == 1)
                                       <span class="text-success">
                                          <n>{{$price["type"]}}: </n> $ {{number_format($price["price"],2)}}
                                       </span>
                                       @endif
                                       @endforeach
                                    </td>
                                    @else
                                    <td>
                                       @foreach($montInfo["$item->pkQuotations"]["price"] as $price)
                                       <span class="text-success">
                                          <n># {{$price["num"]}} {{$price["type"]}} :</n> $
                                          {{number_format($price["price"],2)}} <br>
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
                                                <td> {{ $detail["qtyPlaces"] }}</td>
                                                <td> {!! $detail["course"] !!}</td>
                                                <td> $ {{number_format($detail["price"],2)}}</td>

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
                                          style="background-color:{{$item->color }}">{{$item->level }}</span>
                                    </td>
                                    <td>{!! $item->state !!} <br>{!! $item->country !!}</td>
                                    <td>
                                       {{$item->quotations_status }}
                                    </td>
                                    <td style="min-width:150px;">
                                       Asignado:
                                       <div><img style="max-height: 40px;" src="{{ asset('assets/images/usuarios/user.jpg')}}"
                                             class="rounded-circle">{!!$item->agent !!} </div>
                                       <hr style="margin:7px;">
                                       Atendió:<br>
                                       {{  $item->asing}}
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
                                             class="custom-control-input Checkbox" id="check_{{$item->pkQuotations}}"
                                             data-id="{{ $item->pkQuotations }}">
                                             @else
                                             <input type="checkbox" checked="" onclick="javascript: return false;"
                                                class="custom-control-input" id="check_{{$item->pkQuotations}}"
                                                data-id="{{ $item->pkQuotations }}">
                                             @endif
                                             <label class="custom-control-label"
                                                for="check_{{$item->pkQuotations}}"></label>
                                       </div>
                                       @else
                                       <span></span>
                                       @endif
                                    </td>
                                    @endif
                                    @if($arrayPermition["editQuotes"] == 1)
                                   
                                       @if($item->quotation_status < 4)
                                       <td class="text-center btn_viewQuotation" data-id="{{$item->pkQuotations }}">
                                       <span class="cursor-h"><i class="ti-plus"></i>
                                          Agregar</span>
                                       </td>
                                          @else
                                       <td>
                                          <span>No editable</span>
                                       </td>
                                          @endif
                                  
                                    @endif
                                    @if($arrayPermition["changeQuotes"] == 1 || $arrayPermition["invoice"] == 1)
                                    <td class="text-center" data-id="{{$item->pkQuotations }}">
                                       @if($item->quotation_status < 4 ) <span class="updateStatus cursor-h"
                                          data-id="{{$item->pkQuotations }}"><i class="ti-reload"></i> Cambiar
                                          Estatus</span>
                                          @else
                                          @if($arrayPermition["invoice"] == 1)
                                          @if( ($item->quotation_status == 4 || $item->quotation_status == 5) &&
                                          $item->money_in_account == 0)
                                          <span class="paymentQuotation cursor-h" data-id="{{$item->pkQuotations }}"><i
                                                class="ti-file"></i> Facturación</span>

                                          @else
                                          <span>Facturada<br><small>No es editable</small></span>
                                          @endif
                                          <hr style="margin:7px;">
                                          @if(!empty($montInfo["$item->pkQuotations"]["pay"]))
                                          <a href="/images/payment/{{$montInfo["$item->pkQuotations"]["pay"]}}"
                                             target="_blank"> <span class="cursor-h"><i class="ti-image"></i> ver
                                                comprobante de pago</span></a>
                                          @else
                                          <a href="modalPago" class="modalpay" data-toggle="modal"
                                             data-target="#modalPago" data-id="{{$item->pkQuotations}}"> <span
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
                                             data-id="{{$item->pkQuotations }}"></span>
                        </div>

                        @else
                        <div></div>
                        @endif
                        </td>
                        @endif
                        @if($arrayPermition["deleteQuotes"] == 1)
                        <td class="text-center">
                           @if($item->quotation_status < 5) <button class="btn btn-danger btn-sm btn_deleteQuotation"
                              data-id="{{ $item->pkQuotations}}"><span class="ti-close"></span></button>
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

   <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditUsuario"
      class="modalEditUsuario"></button>
   <!-- Convertir -->
   <div class="modal fade modal-gde" id="modalEditUsuario" tabindex="-1" role="dialog"
      aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalUsuario" role="document">

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

   <!-- Modal Agentes Campañas -->
   <div class="modal fade modal-gde" id="modalConvertir" tabindex="-1" role="dialog"
      aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h2 class="modal-title" id="modalAgentesCLabel">Convertir a Cotización</h2>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form>
                  <div class="row pt-3">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label">Precio</label>
                           <input type="text" id="precio" class="form-control" placeholder="$ 0.00">
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <div class="nav-small-cap mb-2">- - - PROMOCIÓN</div>
                           <div class="form-row">
                              <div class="col-sm-6">
                                 <label class="control-label">Precio</label>
                                 <input type="text" id="precio" class="form-control" placeholder="$ 0.00">
                              </div>
                              <div class="col-sm-6">
                                 <label class="control-label">Vigencia</label>
                                 <input type="date" id="vigencia" class="form-control">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 text-right">
                        <button class="btn btn-success"><span class="ti-check"></span> Actualizar</button>
                     </div>
                     <div class="col-md-6">
                        <button class="btn btn-dark"><span class="ti-close"></span> Descartar</button>
                     </div>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
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
                     Última Actividad:
                     @if(!empty($item->lastActivity))
                     <span> {{$item->lastActivity}} </span>
                     @else
                     <span>-</span>
                     @endif
                  </div>
                  <div>
                     Siguiente Actividad:
                     @if(!empty($item->nextActivity))
                     <span> {{$item->nextActivity}} </span>
                     @else
                     <span>-</span>
                     @endif
                     <div>
                        Vencimiento:
                        @if(!empty($item->finalActivity))
                        <span>{{$item->finalActivity}} </span>
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
         scrollX: true,
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
