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
                                          <a href="/dowloadXML/{{$item->pkQuotations}}"><span class="ti-file">
                                             </span>XML Factura</a><br>
                                          <a href="/dowloadPDF/{{$item->pkQuotations}}" style="color: darkred;"><span
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
                                          <img style="max-height: 40px;" src="/images/business/{{$item->image}}"
                                             class="rounded-circle">
                                          @else
                                          <img style="max-height: 40px;" src="/images/business/em.jpg"
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
                                       <div><img style="max-height: 40px;" src="/images/usuarios/user.jpg"
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
                                    <td class="text-center btn_viewQuotation" data-id="{{$item->pkQuotations }}">
                                       @if($item->quotation_status < 4) <span class="cursor-h"><i class="ti-plus"></i>
                                          Agregar</span>
                                          @else
                                          <span>No editable</span>
                                          @endif
                                    </td>
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
