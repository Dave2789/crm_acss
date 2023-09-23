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
                        <h4 class="text-themecolor">Actividades</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Actividades</li>
                            </ol>
                        
                        </div>
                    </div>
                </div>
          @if($arrayPermition["viewJob"] == 1)
                <!-- Tablas -->
                <div class="row">
                    <div class="col-12">
                        <!-- Campañas -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Actividades</h4>
                               
                                <div class="row">  
                                     @if(Session::get("isAdmin") == 1)
                                     
                                      <div class="col-4 mb-3">
                                        <select class="form-control custom-select" id="status_activity" data-placeholder="Selecciona la Actividad" tabindex="1">
                                            <option value="-1">Estatus actividad</option>        
                                            <option value="1">Realizadas</option> 
                                            <option value="2">Pendientes</option> 
                                        </select>
                                    </div>
                                     
                                    <div class="col-4 mb-3">
                                        <select class="form-control custom-select" id="agent" data-placeholder="Selecciona la Actividad" tabindex="1">
                                            <option value="-1">Agente</option>        
                                            @foreach($users as $userInfo)
                                            <option value="{{ $userInfo->pkUser }}">{!! $userInfo->full_name !!} ( {!! $userInfo->type !!} )</option>   
                                            @endforeach
                                        </select>
                                    </div>
                                    

                                    <div class="col-4 mb-3">
                                        <select class="form-control custom-select" id="type_activitys" data-placeholder="Selecciona la Actividad" tabindex="1">
                                            <option value="-1">Tipo Actividad</option>   
                                            @foreach($activityType as $activityInfo)
                                            <option value="{{ $activityInfo->pkActivities_type }}">{!! $activityInfo->text !!}</option>   
                                            @endforeach
                                        </select>
                                    </div>
                                     
                                     @else
                                      <div class="col-12 mb-3">
                                        <select class="form-control custom-select" id="type_activitys" data-placeholder="Selecciona la Actividad" tabindex="1">
                                            <option value="-1">Tipo Actividad</option>   
                                            @foreach($activityType as $activityInfo)
                                            <option value="{{ $activityInfo->pkActivities_type }}">{!! $activityInfo->text !!}</option>   
                                            @endforeach
                                        </select>
                                    </div>
                                      @endif
                                    
                                    <div class="col-6"> 
                                        <div class="form-group">
                                            <label class="control-label" >Fecha Desde</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                </div>
                                                <input type="date" id="date_start" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    
                                     <div class="col-6"> 
                                        <div class="form-group">
                                            <label class="control-label" >Fecha Hasta</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                </div>
                                                <input type="date" id="date_finish" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    
                                     <div class="col-12 text-right"> 
                                         <button type="button" class="dt-button buttons-excel buttons-html5 btn btn-primary mr-1" id="search_activity">Buscar</button>
                                    </div>
                                </div>
                           
                                
                                
                                <div class="table-responsive m-t-40" id="actividadesDiv">
                                        <div class="dt-buttons">
                                              <!--  <button type="button" data-id="0" class="dowloadExcelActivity dt-button buttons-excel buttons-html5 btn btn-primary mr-1" tabindex="0" aria-controls="activeEmp">
                                                    <span>Excel</span>
                                                </button> -->
                                            </div>
                                             <div id="activeEmp_filter" class="dataTables_filter">
                                                 <label>Buscar:<input id="seacrhActivitys" type="search" class="form-control form-control-sm" placeholder="" aria-controls="activeEmp">
                                                </label>
                                            </div>
                                    <table id="actividades" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Empresa</th>
                                                <th>Proceso</th>
                                                <th>Agente</th>
                                                <th>Tipo de<br>actividad</th>
                                                <th>Registró</th>
                                                <th>Finaliza</th>
                                                <th>Comentario</th>
                                                  @if($arrayPermition["finishJob"] == 1) 
                                                <th>Finalizar<br>Actividad</th>
                                                @endif
                                                 @if($arrayPermition["editJob"] == 1) 
                                                <th></th>
                                                @endif
                                               @if($arrayPermition["deleteJob"] == 1)
                                                <th></th>
                                               @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activitiesQuery as $activitiesInfo)
                                             @if(empty($activitiesInfo->execution_date))
                                             <tr>
                                             @else
                                              <tr style="background-color:#ddf9e0">
                                              @endif
                                                <td>{{html_entity_decode($activitiesInfo->name_business)}}</td>
                                                <td>
                                                    @if($activitiesInfo->pkOpportunities != "" && $activitiesInfo->pkOpportunities != null)
                                                    Oportunidad de negocio
                                                    @else
                                                        @if($activitiesInfo->pkQuotations != "" && $activitiesInfo->pkQuotations != null)
                                                        Cotización
                                                        @else
                                                        Actividad Inicial
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{html_entity_decode($activitiesInfo->full_name)}}<br>({{html_entity_decode($activitiesInfo->type_name)}})</td>
                                                <td><span class="badge badge-pill text-white" style="background-color: {{$activitiesInfo->color}}!important">{{html_entity_decode($activitiesInfo->text)}}</span></td>
                                                <td>{{$activitiesInfo->register_date}} {{$activitiesInfo->register_hour}}</td>
                                                <td>{{$activitiesInfo->final_date}} {{$activitiesInfo->final_hour}}</td>
                                                <td class="t-column" style="min-width:400px;">{{html_entity_decode($activitiesInfo->description)}}</td>
                                                 @if($arrayPermition["finishJob"] == 1)
                                                @if(empty($activitiesInfo->execution_date))
                                                <td> <button type="button" class="btn btn-primary btn-sm btn_FinisActivity" data-id="{{ $activitiesInfo->pkActivities }}">Finalizar</button>  </td>
                                               @else
                                               <td><strong>Actividad Finalizada</strong>
                                                   <br>
                                                <div class="color-show color-sm" style="background-color:{{ $activitiesInfo->subActivityColor }};"></div> {!! $activitiesInfo->subActivity !!}
                                                <br>
                                                {!! $activitiesInfo->comment!!}
                                               </td>
                                               @endif
                                                @endif
                                                 @if($arrayPermition["editJob"] == 1)
                                                <td><a href="#" class="btn_editActivity" data-id="{{$activitiesInfo->pkActivities}}"><span class="ti-pencil"></span></a></td>
                                                 @endif
                                                @if($arrayPermition["deleteJob"] == 1)
                                                <td><a href="#" class="deleteAvtivity" data-id="{{$activitiesInfo->pkActivities}}"><span class="ti-trash"></span></a></td>
                                               @endif
                                              </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="dataTables_info" id="oporNeg_info" role="status" aria-live="polite">Mostrando {{$activitiesQuery->currentPage()}} a {{ $activitiesQuery->perPage() }} de {{$activitiesQuery->total()}} registros</div>
                                            <div class="dataTables_paginate paging_simple_numbers">
                                                {{$activitiesQuery->links() }}  
                                            </div>
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
    @include('includes.scripts')
    <script>
        $(function () {
            $('#actividades').DataTable({
                dom: 'Bfrtip',
                "paging":   false,
                "info":     false,
                 "searching": false,
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