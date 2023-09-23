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
                        <h4 class="text-themecolor">Formas de Pago</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Formas de Pago</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Tablas -->
                <div class="row">
                    <div class="col-12">
                        <!-- Formas de Pago -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Formas de Pago</h4>
                                <div class="f-right mb-3">
                                    <button type="button" data-toggle="modal" data-target="#modalCrearPago" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Crear nueva</button>
                                </div>
                                <div class="table-responsive m-t-40">
                                    <table id="oporNeg" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paymentMethodsQuery as $paymentMethodsInfo)
                                            <tr>
                                                <td>{{html_entity_decode($paymentMethodsInfo->name)}}</td>
                                                <td>
                                                    <button class="btn btn-info btn-sm btn_updatePaymentMethod" data-id="{{$paymentMethodsInfo->pkPayment_methods}}"><span class="ti-pencil"></span></button>
                                                    <button class="btn btn-danger btn-sm btn_deletePaymentMethod" data-id="{{$paymentMethodsInfo->pkPayment_methods}}"><span class="ti-close"></span></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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

    <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalCrearPago" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Nueva Forma de Pago</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="row pt-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <input type="text" id="nameAddPaymentMethod" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button class="btn btn-success btn_addPaymentMethod"><span class="ti-check"></span> Crear</button>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditPago" class="modalEditPago"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditPago" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalPago" role="document">
       
      </div>
    </div>
       
    @include('includes.scripts')
    <script>
        $(function () {
            $('#oporNeg').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });    
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
        });
    </script>
    <!-- End scripts  -->
</body>


</html>