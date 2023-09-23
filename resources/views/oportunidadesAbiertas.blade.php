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
                        <h4 class="text-themecolor">Reporte de Oportunidades de Negocio Abiertas</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte de Oportunidades de Negocio Abiertas</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Detalle -->
                <div class="row">
                    <div class="col-12">
                        <div class="btn btn-primary f-right mb-3">
                            <a href="/" class="text-light" ><span class="ti-arrow-left"></span> Regresar</a>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <h3 class="title-section">Oportunidades de Negocio Abiertas</h3>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 col-12">
                                        <h5 class="card-title">Junio 2019</h5>
                                        <h6 class="card-subtitle">Reporte Mensual</h6>
                                    </div>
                                    <div class="col-sm-4 col-6 align-self-center display-6 text-right">
                                        <h2 class="text-info">$23,690</h2>
                                    </div>
                                    <div class="col-sm-4 col-6 align-self-center text-right">
                                        <div class="ml-auto">
                                            <select class="form-control b-0">
                                                <option>Enero</option>
                                                <option value="1">Febrero</option>
                                                <option value="2" selected="">Junio</option>
                                                <option value="3">Abril</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover no-wrap" id="oportunidadesAbiertas">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Agente</th>
                                            <th>Cantidad</th>
                                            <th>Monto</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div data-label="60%" class="css-bar css-bar-30 css-bar-sm css-bar-info">
                                                    <img src="/assets/images/users/1.jpg" alt="User">
                                                </div>
                                            </td>
                                            <td>Juan López</td>
                                            <td><span>540</span></td>
                                            <td><span class="badge badge-info badge-pill">$22,004.00</span> </td>
                                            <th class="text-left">
                                                <a href="#modalOportunidadesAbiertas" data-toggle="modal" data-target="#modalOportunidadesAbiertas" class="btn btn-secondary btn-sm"><i class="ti-eye"></i> Ver</a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div data-label="10%" class="css-bar css-bar-10 css-bar-sm css-bar-info">
                                                    <img src="/assets/images/users/2.jpg" alt="User">
                                                </div>
                                            </td>
                                            <td>Pedro Ramírez</td>
                                            <td><span>540</span></td>
                                            <td><span class="badge badge-info badge-pill">$12,004.00</span> </td>
                                            <th class="text-left">
                                                <a href="#modalOportunidadesAbiertas" data-toggle="modal" data-target="#modalOportunidadesAbiertas" class="btn btn-secondary btn-sm"><i class="ti-eye"></i> Ver</a>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
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

     <!-- Modal TOP Agentes -->
    <div class="modal fade modal-gde" id="modalOportunidadesAbiertas" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Oportunidades de Negocio Abiertas de Junio 2019</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3><img src="/images/usuarios/user.jpg" style="max-height:40px"> Juan López</h3>
            <div class="table-responsive">
                <table class="table table-hover no-wrap" id="detoportunidadesAbiertas">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Cantidad de<br>Oportunidades Abiertas</th>
                            <th>Cantidad<br>de Lugares</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Empresa 2</td>
                            <td>15-Jun-19</td>
                            <td><span class="text-info">20</span></td>
                            <td>250</td>
                            <td><span class="badge badge-info badge-pill">$18,004.00</span> </td>
                        </tr>
                        <tr>
                            <td>Empresa 3</td>
                            <td>15-Jun-19</td>
                            <td><span class="text-info">20</span></td>
                            <td>250</td>
                            <td><span class="badge badge-info badge-pill">$3,004.00</span> </td>
                        </tr>
                        <tr>
                            <td>Empresa 4</td>
                            <td>15-Jun-19</td>
                            <td><span class="text-info">20</span></td>
                            <td>250</td>
                            <td><span class="badge badge-info badge-pill">$8,004.00</span> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>


    @include('includes.scripts')
    <script>
        $(function () {
            $('#oportunidadesAbiertas').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            }); 
            $('#detoportunidadesAbiertas').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });    
            $('.buttons-excel').addClass('btn btn-primary mr-1');
        });

    </script>
    <!-- End scripts  -->
    
</body>
</html>