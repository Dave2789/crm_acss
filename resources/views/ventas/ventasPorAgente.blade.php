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
                        <h4 class="text-themecolor">Ventas por Agentes</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Ventas por Agentes</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Tablas -->
                <div class="row">
                    <div class="col-sm-12">
                       <!-- <div class="card">
                            <div class="card-body">
                                <div class="vend-mes">
                                    <h3 class="title-section">Vendedor del mes</h3>
                                    <div class="vend-info">
                                        <div>
                                            <a href="">Juan Carlos Pérez González</a>
                                            <span class="lug-vend"><strong>160</strong> lugares</span>
                                            <span class="f-right text-success">$ 10,000.00</span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Ranking de ventas por agente</h5>
                            </div>
                            <div class="table-responsive">
                                <table id="tableAgentesT" class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Nombre</th>
                                            <th>Lugares<br>vendidos</th>
                                            <th>Monto<br>vendido</th>
                                            <th>&Uacute;ltima actividad<br>registrada</th>
                                            <th>Fecha en que<br>se realiz&oacute;</th>
                                            <th>Actividad<br>pendiente</th>
                                            <th>Fecha para<br>realizar actividad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $cont=1; @endphp
                                        @foreach($agent as $item)
                                          <tr>
                                            <td class="text-center">{!!$cont!!}</td>
                                            <td class="txt-oflo">
                                            <a href="/viewProfileAgent/{!!$item->pkUser!!}"><img class="rounded-circle" style="max-height:40px;" src="/images/usuarios/{!!$item->image!!}">{!!$item->full_name!!}</a></td>
                                            <td>
                                                 @if(!empty($item->salesPlaces))
                                                <span class="text-success">{!!$item->salesPlaces!!}</span>
                                                @else
                                                 <span class="text-success">0</span>
                                                @endif
                                            </td>
                                            <td>
                                                 @if(!empty($item->salesMont))
                                                <span class="badge badge-success badge-pill">$ {!!number_format($item->salesMont,2)!!}</span>
                                                 @else
                                                  <span class="badge badge-success badge-pill">$ 0</span>
                                                 @endif
                                            </td>
                                            <td>
                                                @if(!empty($item->lastActivityType))
                                                <div style="color:{!!$item->lastActivityColor!!};">
                                               <span class="{!!$item->lastActivityIcon!!}"></span> {!! $item->lastActivityType!!}
                                               </div>
                                                @else
                                                <span class="text-success">N/A</span> 
                                                @endif
                                            </td>
                                             <td>
                                                @if(!empty($item->finalDayLastActivity))
                                                <span class="text-success">{!!$item->finalDayLastActivity!!}</span> 
                                                @else
                                                <span class="text-success">N/A</span> 
                                                @endif
                                            </td>
                                             <td>
                                                @if(!empty($item->nextActivityText))
                                                <div style="color:{!!$item->nextActivityColor!!};">
                                               <span class="{!!$item->nextActivityIcon!!}"></span> {!! $item->nextActivityText!!}
                                               </div>
                                                @else
                                                <span class="text-success">N/A</span> 
                                                @endif
                                            </td>
                                             <td>
                                                @if(!empty($item->finalDayNexActivity))
                                                <span class="text-success">{!!$item->finalDayNexActivity!!}</span> 
                                                @else
                                                <span class="text-success">N/A</span> 
                                                @endif
                                            </td>
                                        </tr>
                                        @php $cont++; @endphp
                                        @endforeach
                                      
                                    </tbody>
                                </table>
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
                    <table id="tableAgentesT" class="table display table-bordered table-striped no-wrap">
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
 
            // responsive table
             $(function () {
            $('#tableAgentesT').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });    
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
            
        });
        
            $(function () {
            $('#tableAgentesC').DataTable({
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