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
                        <h4 class="text-themecolor">Pre-Factura</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{!!url()->previous()!!}" class="text-light btn btn-primary btn-sm" ><span class="ti-arrow-left"></span> Regresar</a>
                        </div>
                    </div>
                </div>

                <!-- Detalle -->
                <div class="row">
                    <div class="col-12">
                        
                    </div>
                    <div class="col-sm-12">
                        <h3 class="title-section">Facturación Electrónica</h3>
                        <div class="card">
                            <div class="prefactura">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img class="img-fluid" src="/images/logo-color.png" style="max-height:50px;">
                                    </div>
                                    <div class="col-sm-5">
                                        <ul class="sin-type text-center">
                                            <li>Abrevius, S. A. de C. V.</li>
                                            <li>ABR170915L36</li>
                                            <li>AV. ECONOMOS 6271 Col. RINCONADA DEL PARQUE</li>
                                            <li>Zapopan Zapopan, Jalisco, México C.P. 45030</li>
                                            <li><a href="mailto:administracion@abrevius.com">administracion@abrevius.com</a></li>
                                            <li><strong><a href="tel:+525512090653">Tel. (55) 12 09 06 53</a></strong></li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <div class="fa-subt">Factura Electrónica - I</div>
                                        <div>
                                            <div class="fa-title">Folio Fiscal:</div> 
                                            <p>N/A</p>
                                        </div>
                                        <div>
                                            <div class="fa-title">Serie y Folio:</div> 
                                            <p> {!!$infoFacture->serie!!} - N/A</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="fa-title">Nombre:</div>
                                        <div>{!!$infoFacture->razon !!} </div>
                                        <div class="fa-title">Uso de CFDI:</div>
                                        <div>{!!$infoFacture->c_UsoCFDI!!} - {!! $infoFacture->Descripción !!}</div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="fa-title">RFC:</div>
                                        <div>{!! $infoFacture->rfc !!} </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="fa-title text-center">Regimen Fiscal:</div>
                                        <div class="text-center">601-General de Ley Personas Morales</div>
                                        <div class="fa-title text-center">Fecha y hora de emisión:</div>
                                        <div class="text-center">{!!date('Y-m-d\TH:i:s')!!}</div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table color-table muted-table">
                                                <thead>
                                                    <tr>
                                                        <th>Clave SAT</th>
                                                        <th>Cantidad</th>
                                                        <th>Código</th>
                                                        <th>Descripción</th>
                                                        <th>Unidad</th>
                                                        <th>P. Unitario</th>
                                                        <th>Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($QuotationCourse as $QuotationCourseInfo)
                                                    <tr>
                                                        <td>{!!$infoFacture->claveser !!}</td>
                                                        <td>{!!$QuotationCourseInfo->places !!}</td>
                                                        <td></td>
                                                        <td>{!!$QuotationCourseInfo->description!!}</td>
                                                        <td>{!!$infoFacture->claveunit !!} {!!$infoFacture->nameunit !!}</td>
                                                        <td>$ {!!number_format($QuotationCourseInfo->price / $QuotationCourseInfo->places,2) !!}</td>
                                                        <td>$ {!!number_format($QuotationCourseInfo->price,2) !!}</td>
                                                    </tr>
                                                @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">
                                                            <div><small>002 IVA Traslado</small></div>
                                                        </td>
                                                        <td class="text-right">
                                                            <div><small>Tasa {!! $iva !!}%</small></div>
                                                        </td>
                                                        <td class="text-right">
                                                            <div><small>$ {!!number_format($infoFacture->price * ($iva/100),2 )!!}</small></div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9 col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div><span class="fa-subt">Cantidad con letra</span></div>
                                            </div>
                                            <div class="col-sm-8 text-center">
                                                <span class="mayus"> <strong>{!! $numf !!} PESOS 00/100 MXN</strong></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div><span class="fa-subt">Expedida en: </span>45030</div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div><span class="fa-subt">Forma de pago: </span>{!!$infoFacture->paymentcode!!} - {!!$infoFacture->paymentname!!}</div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div><span class="fa-subt">Cuenta de Pago: </span></div>
                                            </div>
                                        </div>
                                       <!-- <div><span class="fa-subt">Condiciones de Pago: </span>{!!$infoFacture->contiditionname !!}</div>-->
                                        <div><span class="fa-subt">Comentario: </span>{!!$infoFacture->comment !!}</div>
                                        <div><span class="fa-subt">Método de Pago: </span>{!!$infoFacture->methodcode!!} - {!! $infoFacture->methodname!!}</div>
                                    </div>
                                    <div class="col-md-3 col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div><span class="fa-subt">Subtotal</span></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="text-right">$ {!!number_format($infoFacture->price,2) !!}</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div><span class="fa-subt">Descuento</span></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="text-right"> $0.00</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div><span class="fa-subt">IVA {!!$iva!!}%</span></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="text-right"> $ {!!number_format($infoFacture->price * ($iva/100),2 )!!}</div>
                                            </div>
                                        </div>
                                       <!-- <div class="row">
                                            <div class="col-sm-6">
                                                <div><span class="fa-subt">IVA Ret. 0%</span></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="text-right"> $16.00</div>
                                            </div>
                                        </div>-->
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div><span class="fa-subt">Total</span></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="text-right">$ {!!number_format($total,2) !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-success" id="btnUpdateFacture" data-id="{!!$id!!}"><span class="ti-check"></span> Facturar</button>
                                   </div>
                                </div>
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


    @include('includes.scripts')
    
</body>
</html>