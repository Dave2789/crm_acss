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
                        <h4 class="text-themecolor">Factura</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Pre-Factura</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Tablas -->
     <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body printableArea">
                            <h3><b>Pre-Factura</b> <span class="pull-right">#{!!$quotation->folio!!}</span></h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
                                            <h3> &nbsp;<b class="text-danger">{!!$quotation->name!!}</b></h3>
                                            <p class="text-muted m-l-5">
                                                {!!$quotation->address!!}
                                            </p>
                                            
                                            <p class="text-muted m-l-5">
                                                <h4>Receptor</h4>
                                            </p>
                                            
                                            <p class="text-muted m-l-5">
                                                <strong>RFC:</strong>   {!!$quotation->rfc!!}
                                            </p>
                                            <p class="text-muted m-l-5">
                                                <strong>Raz&oacute;n Social:</strong>  {!!$quotation->name!!}
                                            </p>
                                            <p class="text-muted m-l-5">
                                               <strong>Uso de CFDI:</strong>  {!!$quotation->cfdi!!}
                                            </p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
                                            <p><b>Fecha de pago :</b> <i class="fa fa-calendar"></i> {!!$quotation->final_date!!}</p>
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-40" style="clear: both;">
                                        <table class="table table-hover">
                                            <thead>
                                                
                                                <tr>
                                                    <th>Cantidad</th>
                                                    <th>Clave de unidad</th>
                                                    <th>Descripci&oacute;n</th>
                                                    <th>Valor Unitario</th>
                                                    <th>Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center"> Unidad de servicio</td>
                                                    <td class="text-center">{!!$quotation->number_places !!} lugares a elegir en cualquiera de 
                                                                           nuestros cursos disponibles en la plataforma abrevius.com</td> 
                                                    <td>$ {!!number_format($quotation->price,2)!!}</td>
                                                     <td>$ {!!number_format($quotation->price,2)!!}</td>
                                                </tr>
                                           
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="pull-right m-t-30 text-right">
                                        <p>Sub - Total amount: {!!number_format($quotation->price,2)!!}</p>
                                        <p>iva (16%) : {!! number_format($quotation->price * .16,2) !!} </p>
                                        <hr>
                                        <h3><b>Total :</b> {!!number_format( ($quotation->price) + ($quotation->price * .16) ,2) !!}</h3>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <div class="text-right">
                                        <button id="sendFacture" class="btn btn-danger" data-id="{!!$quotation->pkQuotations !!}" type="button"> Facturar </button>
                                       <!-- <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>-->
                                    </div>
                                </div>
                            </div>

                <!-- End Page Content -->

            </div><!-- End Container fluid  -->
        </div><!-- End Page wrapper  -->
            </div><!-- End Wrapper -->
                </div><!-- End Wrapper -->
        
 </div><!-- End Wrapper -->
                </div><!-- End Wrapper -->
        
        @include('includes.footer')
        <!-- End footer -->
   
    <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditCategoria" class="modalEditCategoria"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditCategoria" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalEdit" role="document">
       
      </div>
    </div>

    @include('includes.scripts')
    <script>
        $(function () {
            // responsive table
            $('#oporNeg').DataTable({
                            });

    </script>
    <!-- End scripts  -->
</body>


</html>