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
                        <h4 class="text-themecolor">Notificaciones</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Notificaciones</li>
                            </ol>
                             @if($arrayPermition["addNotification"] == 1)
                            <a href="/alertCreateView" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Crear nueva</a>
                             @endif
                        </div>
                    </div>
                </div>
      @if($arrayPermition["viewNotification"] == 1)
                <!-- Tablas -->
                <div class="row">
                    <div class="col-12">
                        <!-- Campañas -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Notificaciones Enviadas</h4>
                                <div class="table-responsive m-t-40">
                                    <table id="tNotificaciones" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Título</th>
                                                <th>Fecha</th>
                                                <th>Asignó</th>
                                                <th>Reciben </th>
                                                <th>Mensaje</th>
                                                <th>Documento</th>
                                                <th>Cliente</th>
                                                <th>Estado</th>
                                                 @if($arrayPermition["deleteNotification"] == 1)
                                                <th>Eliminar</th>
                                                 @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($alertsQuery as $alertsInfo)
                                            <tr>
                                                <td class="t-column" style="width: 200px;">{!!html_entity_decode($alertsInfo->title)!!}
                                                </td>
                                                
                                                <td>{!!$alertsInfo->date!!}<br>{!!$alertsInfo->hour!!}</td>
                                                <td>{!! $alertsInfo->full_name!!}</td>
                                                <td>
                                                    <ul class="form-control-static p-0">
                                                    @foreach($usersPerAlert[$alertsInfo->pkAlert] as $usersPerAlertInfo)
                                                        <li>
                                                            {!!html_entity_decode($usersPerAlertInfo["name"])!!}<br>({!!html_entity_decode($usersPerAlertInfo["type"])!!})<br>
                                                            @if($usersPerAlertInfo["view"] < 1)
                                                            <span class="ti-close"></span>  Sin ver
                                                            @else
                                                                @if($usersPerAlertInfo["view"] == 1)
                                                                <span class="ti-check"></span> Vista
                                                                @else
                                                                <span class="ti-close"></span> Inició sesión pero no la vio
                                                                @endif
                                                            @endif
                                                            {!!html_entity_decode($usersPerAlertInfo["date"])!!} {!!html_entity_decode($usersPerAlertInfo["hour"])!!}
                                                        </li>
                                                    @endforeach
                                                    </ul>
                                                </td>
                                                <td class="t-column" style="width: 400px;">{!!html_entity_decode($alertsInfo->comment)!!}</td>
                                                <td><a href="/images/alerts/{!!$alertsInfo->document!!}" download> {!!$alertsInfo->document !!} </a></td>
                                                <td>{!!$alertsInfo->name !!}</td>
                                                <td>Enviada</td>
                                               <!-- <td>
                                                    <a href="#" class="btn btn-sm btn-primary btn_editNotification" data-id="{!!$alertsInfo->pkAlert!!}"><span class="ti-pencil"></span></a>
                                                </td>-->
                                                 <td>
                                                   @if($arrayPermition["deleteNotification"] == 1)
                                                    <a href="#" data-id="{!!$alertsInfo->pkAlert!!}" class="btn btn-sm btn-danger btn_deleteAlert"><span class="ti-trash"></span></a>
                                                  @endif
                                                 </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Notificaciones Recibidas</h4>
                                <div class="table-responsive m-t-40">
                                    <table id="tNotificacionesRecibidas" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Título</th>
                                                <th>Mensaje</th>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Enviada por</th>
                                                <th>Estado</th>
                                                <th>Vista</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($usersPerAlertReceived as $usersPerAlertReceivedInfo)
                                            <tr>
                                                <td class="t-column" style="width: 200px;">{!!html_entity_decode($usersPerAlertReceivedInfo["title"])!!}</td>
                                                <td class="t-column" style="width: 200px;">{!!html_entity_decode($usersPerAlertReceivedInfo["comment"])!!}</td>
                                                <td>{!!$usersPerAlertReceivedInfo["date"]!!}</td>
                                                <td>{!!$usersPerAlertReceivedInfo["hour"]!!}</td>
                                                <td>{!!html_entity_decode($usersPerAlertReceivedInfo["full_name"])!!}<br>({!!html_entity_decode($usersPerAlertReceivedInfo["type_name"])!!})</td>
                                                
                                                    @if($usersPerAlertReceivedInfo["view"] < 1)
                                                    <th class="text-center text-info"><span class="ti-close"></span>  Sin ver</th>
                                                    @else
                                                        @if($usersPerAlertReceivedInfo["view"] == 1)
                                                        <th class="text-center text-success"><span class="ti-check"></span> Vista</th>
                                                        @else
                                                        <th class="text-center text-info"><span class="ti-close"></span> Inició sesión pero no la vió</th>
                                                        @endif
                                                    @endif
                                                    
                                                <td>{!!$usersPerAlertReceivedInfo["dateview"]!!} <br>{!!$usersPerAlertReceivedInfo["hourview"]!!}</td>        
                                                
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
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
   <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditAlert" class="modalEditAlert"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditAlert" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalAlert" role="document">
       
      </div>
    </div>
    @include('includes.scripts')
    <script>
        $(function () {
            $('#tNotificaciones').DataTable({
                dom: 'Bfrtip',
                 "order": [],
                buttons: [
                    'excel'
                ]
            });  
            $('#tNotificacionesRecibidas').DataTable({
                dom: 'Bfrtip',
                 "order": [],
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