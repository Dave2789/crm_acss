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
                        <h4 class="text-themecolor">Ventas por Campaña y Agentes</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Ventas por Campaña y Agentes</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Tablas -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Top 10 de Agentes</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                            <th>Monto</th>
                                            <th>Ver detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="txt-oflo">
                                                <a href="/detAgente"><img class="rounded-circle" style="max-height:40px;" src="/images/usuarios/user.jpg"> Juan López</a></td>
                                            <td><span class="text-success">10,500</span></td>
                                            <td><span class="badge badge-success badge-pill">$24,520</span> </td>
                                            <td class="txt-oflo"><a href="/detAgente"><span class="ti-user"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td class="txt-oflo"><a href="/detAgente"><img class="rounded-circle" style="max-height:40px;" src="/images/usuarios/user.jpg"> Karla Ramírez</a></td>
                                            <td><span class="text-success">9,500</span></td>
                                            <td><span class="badge badge-success badge-pill">$18,520</span> </td>
                                            <td class="txt-oflo"><a href="/detAgente"><span class="ti-user"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td class="txt-oflo"><a href="/detAgente"><img class="rounded-circle" style="max-height:40px;" src="/images/usuarios/user.jpg"> Pedro Perez</a></td>
                                            <td><span class="text-success">,500</span></td>
                                            <td><span class="badge badge-success badge-pill">$16,520</span> </td>
                                            <td class="txt-oflo"><a href="/detAgente"><span class="ti-user"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td class="txt-oflo"><a href="/detAgente"><img class="rounded-circle" style="max-height:40px;" src="/images/usuarios/user.jpg"> Agente 4</a></td>
                                            <td><span class="text-success">7,500</span></td>
                                            <td><span class="badge badge-success badge-pill">$14,520</span> </td>
                                            <td class="txt-oflo"><a href="/detAgente"><span class="ti-user"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td class="txt-oflo"><a href="/detAgente"><img class="rounded-circle" style="max-height:40px;" src="/images/usuarios/user.jpg"> Agente 5</a></td>
                                            <td><span class="text-success">6,500</span></td>
                                            <td><span class="badge badge-success badge-pill">$12,520</span> </td>
                                            <td class="txt-oflo"><a href="/detAgente"><span class="ti-user"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">6</td>
                                            <td class="txt-oflo"><a href="/detAgente"><img class="rounded-circle" style="max-height:40px;" src="/images/usuarios/user.jpg"> Agente 6</a></td>
                                            <td><span class="text-success">5,500</span></td>
                                            <td><span class="badge badge-success badge-pill">$11,520</span> </td>
                                            <td class="txt-oflo"><a href="/detAgente"><span class="ti-user"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">7</td>
                                            <td class="txt-oflo"><a href="/detAgente"><img class="rounded-circle" style="max-height:40px;" src="/images/usuarios/user.jpg"> Agente 7</a></td>
                                            <td><span class="text-success">4,500</span></td>
                                            <td><span class="badge badge-success badge-pill">$9,520</span> </td>
                                            <td class="txt-oflo"><a href="/detAgente"><span class="ti-user"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">8</td>
                                            <td class="txt-oflo"><a href="/detAgente"><img class="rounded-circle" style="max-height:40px;" src="/images/usuarios/user.jpg"> Agente 8</a></td>
                                            <td><span class="text-success">3,500</span></td>
                                            <td><span class="badge badge-success badge-pill">$7,520</span> </td>
                                            <td class="txt-oflo"><a href="/detAgente"><span class="ti-user"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">9</td>
                                            <td class="txt-oflo"><a href="/detAgente"><img class="rounded-circle" style="max-height:40px;" src="/images/usuarios/user.jpg"> Agente 9</a></td>
                                            <td><span class="text-success">2,500</span></td>
                                            <td><span class="badge badge-success badge-pill">$4,520</span> </td>
                                            <td class="txt-oflo"><a href="/detAgente"><span class="ti-user"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">10</td>
                                            <td class="txt-oflo"><a href="/detAgente"><img class="rounded-circle" style="max-height:40px;" src="/images/usuarios/user.jpg"> Agente 10</a></td>
                                            <td><span class="text-success">1,500</span></td>
                                            <td><span class="badge badge-success badge-pill">$2,520</span> </td>
                                            <td class="txt-oflo"><a href="/detAgente"><span class="ti-user"></span></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <!-- Campañas -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Campañas </h4>
                                <h6 class="card-subtitle">Listado de campañas</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="config-table" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Fecha<br>Inicial</th>
                                                <th>Fecha<br>Final</th>
                                                <th>Ventas</th>
                                                <th>Cotizaciones<br>Directas</th>
                                                <th>Oportunidades<br> de Negocio</th>
                                                <th>Agente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>001</td>
                                                <td>Mailing</td>
                                                <td>12-05-19</td>
                                                <td>20-05-19</td>
                                                <td>
                                                    <span class="label label-success">158</span>
                                                    <span class="label label-info">20</span>
                                                    <span class="label label-danger">80</span>
                                                </td>
                                                <td>541</td>
                                                <td>
                                                    <span class="label label-success">585</span>
                                                    <span class="label label-info">50</span>
                                                    <span class="label label-danger">280</span>
                                                </td>
                                                <td><a href="#modalAgentesC" data-toggle="modal" data-target="#modalAgentesC">Karla López</a></td>
                                            </tr>
                                            <tr>
                                                <td>002</td>
                                                <td>Expo negocios</td>
                                                <td>12-05-19</td>
                                                <td>12-05-19</td>
                                                <td>
                                                    <span class="label label-success">158</span>
                                                    <span class="label label-info">50</span>
                                                    <span class="label label-danger">80</span>
                                                </td>
                                                <td>8,415</td>
                                                <td>
                                                    <span class="label label-success">585</span>
                                                    <span class="label label-info">20</span>
                                                    <span class="label label-danger">280</span>
                                                </td>
                                                <td><a href="#modalAgentesC" data-toggle="modal" data-target="#modalAgentesC"><span class="ti-user"></span> Ver agentes</a></td>
                                            </tr>
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

    <!-- Modal Agentes Campañas -->
    <div class="modal fade modal-gde" id="modalAgentesC" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Campaña "Mailing"</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <h3><img src="/images/usuarios/user.jpg" class="img-fluid" style="max-height:40px;"> Karla López</h3>
                <div class="table-responsive m-t-40 table-ab">
                    <table id="tableAgentesC" class="table display table-bordered table-striped no-wrap">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha<br>y hora</th>
                                <th>Estatus</th>
                                <th>Nivel de<br>Interés</th>
                                <th>Última<br>actividad</th>
                                <th>Siguiente<br>actividad</th>
                                <th>Vencimiento de la<br>siguiente actividad</th>
                                <th>Documento</th>
                                <th>Editar<br>cotización</th>
                                <th>Editar oportunidad<br>de negocio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>AppendCloud</td>
                                <td>12-05-19 12:08pm</td>
                                <td><span class="label label-info">Activa</span></td>
                                <td>Nivel 1</td>
                                <td>Llamada de venta</td>
                                <td>Llamada de cierre</td>
                                <td>17-05-19</td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-file"></span></a>
                                </td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-write"></span></a>
                                </td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-light-bulb"></span></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Empresa 3</td>
                                <td>12-05-19 12:08pm</td>
                                <td><span class="label label-success">Cerrada</span></td>
                                <td>Nivel 1</td>
                                <td>Llamada de venta</td>
                                <td>Llamada de cierre</td>
                                <td>17-05-19</td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-file"></span></a>
                                </td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-write"></span></a>
                                </td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-light-bulb"></span></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row m-t-40">
                <h3><img src="/images/usuarios/user.jpg" class="img-fluid" style="max-height:40px;"> Juan Pérez</h3>
                <div class="table-responsive m-t-40 table-ab">
                    <table id="tableAgentesC" class="table display table-bordered table-striped no-wrap">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha<br>y hora</th>
                                <th>Estatus</th>
                                <th>Nivel de<br>Interés</th>
                                <th>Última<br>actividad</th>
                                <th>Siguiente<br>actividad</th>
                                <th>Vencimiento de la<br>siguiente actividad</th>
                                <th>Documento</th>
                                <th>Editar<br>cotización</th>
                                <th>Editar oportunidad<br>de negocio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Empresa 1</td>
                                <td>12-05-19 12:08pm</td>
                                <td><span class="label label-info">Activa</span></td>
                                <td>Nivel 1</td>
                                <td>Llamada de venta</td>
                                <td>Llamada de cierre</td>
                                <td>17-05-19</td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-file"></span></a>
                                </td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-write"></span></a>
                                </td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-light-bulb"></span></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Empresa 2</td>
                                <td>12-05-19 12:08pm</td>
                                <td><span class="label label-success">Cerrada</span></td>
                                <td>Nivel 1</td>
                                <td>Llamada de venta</td>
                                <td>Llamada de cierre</td>
                                <td>17-05-19</td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-file"></span></a>
                                </td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-write"></span></a>
                                </td>
                                <td class="text-center">
                                    <a href="#"><span class="ti-light-bulb"></span></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Empresas Campañas -->
    <div class="modal fade modal-gde" id="modalEmpresasC" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Campaña "Mailing"</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3>Empresas</h3>
            <div class="table-responsive m-t-40 table-ab">
                <table id="tableEmpresasC" class="table display table-bordered table-striped no-wrap">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Estatus</th>
                            <th>Fecha</th>
                            <th>Lugares</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AppendCloud</td>
                            <td>Oportunidad de negocio</td>
                            <td>15-05-19</td>
                            <td>15</td>
                            <td class="text-center"><a href="/detEmpresa"><span class="ti-eye"></span></a></td>
                        </tr>
                        <tr>
                            <td>Cámara de Comercio</td>
                            <td>Cotización directa</td>
                            <td>15-05-19</td>
                            <td>200</td>
                            <td class="text-center"><a href="/detEmpresa"><span class="ti-eye"></span></a></td>
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

    <!-- Modal TOP Agentes -->
    <div class="modal fade modal-gde" id="modalTopAgentes" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Agentes con más ventas</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-1">
                    <img src="/images/usuarios/user.jpg" class="img-fluid">
                </div>
                <div class="col-11">
                    <h3>Juan López</h3>
                </div>
                <hr>
            </div>
            <div class="table-responsive m-t-40 table-ab">
                <table id="tableAgentesC" class="table display table-bordered table-striped no-wrap">
                    <thead>
                        <tr>
                            <th>Ventas</th>
                            <th>Cotizaciones</th>
                            <th>Oportunidades de negocio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <span class="label label-success">158</span>
                                <span class="label label-danger">80</span>
                            </td>
                            <td>541</td>
                            <td>
                                <span class="label label-success">585</span>
                                <span class="label label-danger">280</span>
                            </td>
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
            // responsive table
            $('#config-table').DataTable({
                            });
            $('#tableAgentesC').DataTable({
                            });
            $('#tableEmpresasC').DataTable({
                            });
        });

    </script>
    <!-- End scripts  -->
</body>


</html>