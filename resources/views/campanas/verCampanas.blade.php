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
                        <h4 class="text-themecolor">Ver Campañas</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Campañas</li>
                                <li class="breadcrumb-item active">Ver Campañas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            @if($arrayPermition["viewCampaign"] == 1)
                <!-- Tablas -->
                <div class="row">
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
                                                <th>Fecha <br>Inicial</th>
                                                <th>Fecha <br>Final</th>
                                                <th>Fecha <br>Registro</th>
                                                <th>Fecha <br>Finalizó</th>
                                                <th>Tipo de<br>Campaña</th>
                                                <th>Agente <br>Principal</th>
                                                <th>Ventas</th>
                                                <th>Cotizaciones</th>
                                                <th>Oportunidades<br> de Negocio</th>
                                                <th>Agentes</th>
                                                <th></th>
                                                 @if($arrayPermition["editCampaign"] == 1)
                                                <th></th>
                                                @endif
                                                <th></th>
                                                @if($arrayPermition["deleteCampaign"] == 1)
                                                <th></th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($campaignsQuery as $campaignsInfo)
                                            <tr>
                                                <td>{{$campaignsInfo->code}}</td>
                                                <td>{{html_entity_decode($campaignsInfo->name)}}</td>
                                                <td>{{$campaignsInfo->start_date}}</td>
                                                <td>{{$campaignsInfo->end_date}}</td>
                                                <td>{{$campaignsInfo->register_date}}</td>
                                                <td>{{$campaignsInfo->final_date}}</td>
                                                <td>{!!$campaignsInfo->type_name!!}</td>
                                                <td>{{html_entity_decode($campaignsInfo->full_name)}}<br>
                                                    <small>({{html_entity_decode($campaignsInfo->type_user_name)}})</small>
                                                </td>
                                                <td>
                                                    @if(isset( $sales[$campaignsInfo->pkCommercial_campaigns]["salesPay"]))
                                                    <span class="label label-success">{{ $sales[$campaignsInfo->pkCommercial_campaigns]["salesPay"] }}</span>
                                                    @else
                                                    <span class="label label-success">0</span>
                                                    @endif
                                                    
                                                     @if(isset($sales[$campaignsInfo->pkCommercial_campaigns]["salesLoss"]))
                                                    <span class="label label-danger">{{ $sales[$campaignsInfo->pkCommercial_campaigns]["salesLoss"] }}</span>
                                                    @else
                                                     <span class="label label-danger">0</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="label label-success">0</span>
                                                     @if(isset($quotation[$campaignsInfo->pkCommercial_campaigns]["quotations"]))
                                                    <span class="label label-info">{{$quotation[$campaignsInfo->pkCommercial_campaigns]["quotations"]}}</span>
                                               
                                                     @else
                                                   <span class="label label-info">0</span>  
                                                     @endif
                                                </td>
                                                <td>
                                                      @if(isset($oportunity[$campaignsInfo->pkCommercial_campaigns]["oportunityAproved"]))
                                                    <span class="label label-success">{{$oportunity[$campaignsInfo->pkCommercial_campaigns]["oportunityAproved"]}}</span>
                                                  @else
                                                    <span class="label label-success">0</span>
                                                   @endif
                                                    
                                                    @if(isset($oportunity[$campaignsInfo->pkCommercial_campaigns]["oportunityOpen"]))
                                                    <span class="label label-info">{{$oportunity[$campaignsInfo->pkCommercial_campaigns]["oportunityOpen"]}}</span>
                                                    @else
                                                    <span class="label label-info">0</span>
                                                    @endif
                                                     @if(isset($oportunity[$campaignsInfo->pkCommercial_campaigns]["oportunityLoss"]))
                                                       <span class="label label-danger">{{$oportunity[$campaignsInfo->pkCommercial_campaigns]["oportunityLoss"]}}</span>
                                                     @else
                                                       <span class="label label-danger">0</span>
                                                     @endif
                                                  
                                                </td>

                                                <td><a href="#" class="viewAgent" data-id="{{ $campaignsInfo->pkCommercial_campaigns }}">Ver todos</a></td>
                                                 <td><a href="#" class="saveCsv" data-id="{{ $campaignsInfo->pkCommercial_campaigns }}"><span class="ti-bookmark"></span></a></td>
                                                 @if($arrayPermition["editCampaign"] == 1)
                                                 <td><a href="#" class="btnEditCampaigns" data-id="{{ $campaignsInfo->pkCommercial_campaigns }}"><span class="ti-pencil"></span></a></td>
                                                 @endif
                                                 <td><a href="/commercialCampaignsViewDetail/{{$campaignsInfo->pkCommercial_campaigns}}"><span class="ti-eye"></span></a></td>
                                                 @if($arrayPermition["deleteCampaign"] == 1)
                                                <td><a href="#" class="deleteCampaning" data-id="{{ $campaignsInfo->pkCommercial_campaigns }}"><span class="ti-trash"></span></a></td>
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
            <h3>Listado de agentes</h3>
            <div id="accordion" class="accordion-ag">
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                      Juan Pérez
                    </button>
                  </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body">
                    <div class="table-responsive m-t-40 table-ab mb-5">
                        <table id="tJuanCampana" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>Fecha<br>y Hora</th>
                                    <th>Estatus</th>
                                    <th>Nivel de<br>Interés</th>
                                    <th>Última<br>actividad</th>
                                    <th>Siguiente<br>actividad</th>
                                    <th>Fecha vencimiento de la<br>siguiente actividad</th>
                                    <th>Documento</th>
                                    <th>Editar<br>Cotización</th>
                                    <th>Editar Oportunidad<br>de Negocio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>AppendCloud</td>
                                    <td>16-Jul-19 02:16 pm</td>
                                    <td><span class="label label-success">Cerrada</span></td>
                                    <td>Nivel 2</td>
                                    <td>Llamada de cierre</td>
                                    <td>Agenda del curso</td>
                                    <td>25-Jul-19</td>
                                    <td><a href=""><span class="ti-file"></span></a></td>
                                    <td><a href=""><span class="ti-write"></span></a></td>
                                    <td><a href=""><span class="ti-light-bulb"></span></a></td>
                                </tr>
                                <tr>
                                    <td>Empresa 2</td>
                                    <td>16-Jul-19 02:16 pm</td>
                                    <td><span class="label label-danger">Descartada</span></td>
                                    <td>Nivel 2</td>
                                    <td>Llamada de cierre</td>
                                    <td>Agenda del curso</td>
                                    <td>25-Jul-19</td>
                                    <td><a href=""><span class="ti-file"></span></a></td>
                                    <td><a href=""><span class="ti-write"></span></a></td>
                                    <td><a href=""><span class="ti-light-bulb"></span></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Karla López
                    </button>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                  <div class="card-body">
                    <div class="table-responsive m-t-40 table-ab">
                        <table id="tKarlaCampana" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>Fecha<br>y Hora</th>
                                    <th>Estatus</th>
                                    <th>Nivel de<br>Interés</th>
                                    <th>Última<br>actividad</th>
                                    <th>Siguiente<br>actividad</th>
                                    <th>Fecha vencimiento de la<br>siguiente actividad</th>
                                    <th>Documento</th>
                                    <th>Editar<br>Cotización</th>
                                    <th>Editar Oportunidad<br>de Negocio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>AppendCloud</td>
                                    <td>16-Jul-19 02:16 pm</td>
                                    <td><span class="label label-success">Cerrada</span></td>
                                    <td>Nivel 2</td>
                                    <td>Llamada de cierre</td>
                                    <td>Agenda del curso</td>
                                    <td>25-Jul-19</td>
                                    <td><a href=""><span class="ti-file"></span></a></td>
                                    <td><a href=""><span class="ti-write"></span></a></td>
                                    <td><a href=""><span class="ti-light-bulb"></span></a></td>
                                </tr>
                                <tr>
                                    <td>Empresa 2</td>
                                    <td>16-Jul-19 02:16 pm</td>
                                    <td><span class="label label-info">Abierta</span></td>
                                    <td>Nivel 2</td>
                                    <td>Llamada de cierre</td>
                                    <td>Agenda del curso</td>
                                    <td>25-Jul-19</td>
                                    <td><a href=""><span class="ti-file"></span></a></td>
                                    <td><a href=""><span class="ti-write"></span></a></td>
                                    <td><a href=""><span class="ti-light-bulb"></span></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  </div>
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

    <!-- Modal Agentes Campañas -->
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
                <table id="config-table" class="table display table-bordered table-striped no-wrap">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Estatus</th>
                            <th>Fecha</th>
                            <th>Lugares</th>
                            <th>Agregar<br>Actividad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AppendCloud</td>
                            <td>Oportunidad de negocio</td>
                            <td>15-05-19</td>
                            <td>15</td>
                            <th class="add-user"><a href=""><span class="ti-plus"></span></a></th>
                        </tr>
                        <tr>
                            <td>Cámara de Comercio</td>
                            <td>Cotización directa</td>
                            <td>15-05-19</td>
                            <td>200</td>
                            <th class="add-user"><a href=""><span class="ti-plus"></span></a></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="">
                <a class="btn btn-primary" href="#"><span class="ti-download"></span> Descargar Correos</a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    
       <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditActivity" class="modalEditActivity"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditActivity" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalActivity" role="document">
       
      </div>
    </div>

    @include('includes.scripts')
    <script>
        $(function () {
            $('#config-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });    
            $('#tJuanCampana').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });
            $('#tKarlaCampana').DataTable({
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