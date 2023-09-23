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
                        <h4 class="text-themecolor">Llamadas pendientes</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Llamadas pendientes</li>
                            </ol>
                        
                        </div>
                    </div>
                </div>
          @if($arrayPermition["viewcallPending"] == 1)
                <!-- Tablas -->
                <div class="row">
                    <div class="col-12">
                        <!-- Campañas -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Llamadas pendientes</h4>
                                <div class="row">
                                  <div class="col-6 mb-3">
                                        <select class="form-control custom-select" id="slcAgentCallLost" data-placeholder="Selecciona la Actividad" tabindex="1">
                                            <option value="-1">Todos los Agentes</option>        
                                            @foreach($users as $userInfo)
                                            @if(Session::get('isAdmin') == 0 && Session::get('pkUser') == $userInfo->pkUser)
                                            <option selected value="{{ $userInfo->pkUser }}">{!! $userInfo->full_name !!} ( {!! $userInfo->type !!} )</option>   
                                            @else
                                            <option value="{{ $userInfo->pkUser }}">{!! $userInfo->full_name !!} ( {!! $userInfo->type !!} )</option>   
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive m-t-40" id="actividadesDiv">
                                    <table id="actividades" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Acciones</th>
                                                <th>Fecha de vencimiento</th>
                                                <th>Hora de Vencimiento</th>
                                                <th>Empresa</th>
                                                <th>Campaña</th>
                                                <th>Usuario</th>
                                                <th>Asignado</th>
                                                <th>Comentario</th>
                                                <th>Título</th>
                                               <!-- <th>Detalle</th>-->
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activitiesQuery as $activitiesInfo)
                                            <tr>
                                                 <td>
                                                @if($arrayPermition["editcallPending"] == 1)
                                                <a href="#" class="btn_editActivity" data-id="{{$activitiesInfo->pkActivities}}"><span class="ti-pencil"></span></a>
                                                @endif
                                                @if($arrayPermition["deletecallPending"] == 1)
                                                <a href="#" class="deleteAvtivity" data-id="{{$activitiesInfo->pkActivities}}"><span class="ti-trash"></span></a>
                                                @endif
                                                </td>
                                                <td data-order="{{$activitiesInfo->final_date}}">{{$activitiesInfo->final_dateact}}</td>
                                                <td>{{$activitiesInfo->final_hour}}</td>
                                                <td>
                                                   <a target="_blank" href="/detEmpresa/{{$activitiesInfo->pkBusiness  }}">{!! $activitiesInfo->business_name !!}</a>
                                                </td>
                                                @if(!empty($activitiesInfo->campaning))
                                                <td>{!!$activitiesInfo->campaning!!}</td>
                                                @else
                                                <td>N/A</td>
                                                @endif
                                                <td>{!!$activitiesInfo->full_name!!}</td>
                                                <td>{!!$activitiesInfo->full_name!!}</td>
                                                <td class="t-column" style="min-width:400px;">{!!$activitiesInfo->description!!}</td>
                                                <td>{!!$activitiesInfo->text!!}</td>
                                               <!--  <td>{!!$activitiesInfo->text!!}</td>-->
                                               
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
    <div class="modal fade modal-gde" id="modalConvertir" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
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

    
     <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditActivity" class="modalEditActivity"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditActivity" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalActivity" role="document">
       
      </div>
    </div>

             <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditPago" class="modalEditPago"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditPago" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalPago" role="document">
       
      </div>
    </div>
    @include('includes.scriptSnGrafic')
    <script>
        $(function () {
            $('#actividades').DataTable({
                dom: 'Bfrtip',
                 "order": [],
                buttons: ['copy'
                        ,'excel'
                        ,'csv'
                        ,'pdf'
                ]
            });    
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
        });
    </script>
    <!-- End scripts  -->
</body>


</html>