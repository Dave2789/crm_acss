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
                        <h4 class="text-themecolor">Actividad</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Actividad</li>
                             
                            </ol>
                        </div>
                    </div>
                </div>
                
                
                <div class="row">
                    
                     <div class="col-10 card">
                                <div class="card-body">
                                    <h4 class="card-title">Filtrar por</h4>
                                    <div class=" row">
                                        <select id="agent" class="custom-select form-control input-sm m-b-10">
                                            <option value="-1">Agente</option>
                                            @foreach($agent as $agentInfo)
                                            <option value="{{$agentInfo->pkUser }}">{!!$agentInfo->full_name!!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="exampleSorting"></div>
                                </div>
                            </div><!-- Column -->
                             <div class="col-2 card">
                                 <div class="card-body" style="margin-top: 10px">
                                  <button type="button" class="dt-button buttons-excel buttons-html5 btn btn-primary mr-1" id="search_activiy_agent">Buscar</button>
                                </div>
                            </div><!-- Column -->
                            <div id="activitysAgent" class="row" style="width: 100%;">
                    <div class="col-md-6 col-12">
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4 class="card-title m-b-0">Actividades Pendientes</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="/calendario" class="pull-right btn btn-circle btn-success"><i class="ti-calendar"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body steamline-scroll">
                                <!-- To do list widgets -->
                                <div class="steamline m-t-40">
                                    @foreach($activitiesQuery as $activitiesInfo)
                                    <div class="sl-item">
                                        <div class="sl-left bg-info" style="background-color: {{$activitiesInfo->color}}!important;"> <i class="{{$activitiesInfo->icon}}"></i></div>
                                        <div class="sl-right">
                                            <div class="font-medium">
                                                <a class="a-black">{{html_entity_decode($activitiesInfo->text)}} </a> <!-- CLIC PERMITE FINALIZAR LA ACTIVIDAD -->
                                                <?php 
                                                $dateNow        = strtotime($date);
                                                $dateAux        = strtotime($activitiesInfo->final_date);
                                                
                                                $hourNow        = strtotime($hour);
                                                $hourAux        = strtotime($activitiesInfo->final_hour);
                                                
                                                $fechaUno       = new DateTime($hour);
                                                $fechaDos       = new DateTime($activitiesInfo->final_hour);

                                                $dateInterval   = $fechaUno->diff($fechaDos);
                                                $time           = $dateInterval->format('%H').PHP_EOL;
                                              
                                                ?>
                                               
                                                @if($dateNow == $dateAux)
                                                    @if($time <= 3)
                                                    <span class="badge badge-pill badge-danger float-right">Urgente</span>
                                                    @else
                                                    <span class="badge badge-pill badge-warning float-right">Hoy</span>
                                                    @endif
                                                @else
                                                    @if(($dateNow >= $dateAux) && ($hourNow > $hourAux))
                                                    <span class="badge badge-pill badge-danger float-right" style="background-color: #red!important;">Actividad no realizada</span>
                                                    @else
                                                    <span class="badge badge-pill badge-info float-right">Después</span>
                                                    @endif
                                                @endif
                                            </div>
                                            <p>{{html_entity_decode($activitiesInfo->description)}}</p>
                                            <p>
                                                <small class="text-muted"><i class="ti-calendar"></i> {{$activitiesInfo->final_date}} {{$activitiesInfo->final_hour}}</small>
                                                <small class="pl-2 text-muted"><i class="ti-user"></i> {{html_entity_decode($activitiesInfo->full_name)}}</small>
                                                <small class="pl-2 text-muted"><i class="ti-bookmark"></i> {{html_entity_decode($activitiesInfo->business_name)}}</small> 
                                            </p>
                                            <p>
                                                <button type="button" class="btn btn-primary btn-sm btn_FinisActivity" data-id="{{ $activitiesInfo->pkActivities }}">Finalizar</button>
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Actividades realizadas</h5>
                            <div class="message-box steamline-scroll">
                                <div class="message-widget">
                                    <!-- Message -->
                                    @foreach($lastActivitiesQuery as $lastActivitiesInfo)
                                    <a>
                                        <div class="user-img">
                                            <span class="round" style="background-color: {{$lastActivitiesInfo->color}}!important;"> <i class="{{$lastActivitiesInfo->icon}}"></i></span>
                                            <span class="profile-status away pull-right"></span>
                                        </div>
                                        <div class="mail-contnet">
                                            <h5>{{$lastActivitiesInfo->text}}</h5>
                                            <span class="mail-desc">{{html_entity_decode($lastActivitiesInfo->description)}}</span>
                                            <p>
                                                <small class="text-muted"><i class="ti-calendar"></i> {{$lastActivitiesInfo->execution_date}} {{$lastActivitiesInfo->execution_hour}}</small>
                                                <small class="pl-2 text-muted"><i class="ti-user"></i> {{html_entity_decode($lastActivitiesInfo->full_name)}}</small>
                                                <small class="pl-2 text-muted"><i class="ti-bookmark"></i> {{html_entity_decode($lastActivitiesInfo->business_name)}}</small>
                                            </p>
                                            <span class="badge badge-pill badge-danger float-right" style="background-color: {{$lastActivitiesInfo->color_subtype}}!important;"> {{html_entity_decode($lastActivitiesInfo->text_subtype)}}</span>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                   </div>
                </div>    
                 
                
                
                <div class="row">
                    <div class="col-12">
                        <!-- Filtros -->
                        <div class="row">
                            <h3 class="title-section">Actividades comerciales</h3>
                            <div class="col-md-2 col-6 card">
                                <div class="card-body">
                                    <h4 class="card-title">Filtrar por</h4>
                                    <div class=" row">
                                        <select id="typeActivity" class="custom-select form-control input-sm m-b-10">
                                            <option value="-1"> Tipo de Actividad</option>
                                          @foreach($activities as $activitiesInfo)
                                            <option value="{{$activitiesInfo->pkActivities_type }}">{!!$activitiesInfo->text!!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="exampleSorting"></div>
                                </div>
                            </div><!-- Column -->
                            <div class="col-md-3 col-6 card">
                                <div class="card-body">
                                    <h4 class="card-title">Campaña</h4>
                                    <div class=" row">
                                        <select id="typeCampaning" class="custom-select form-control input-sm m-b-10">
                                             <option value="-1"> Tipo de Campaña</option>
                                            @foreach($campaning as $campaningInfo)
                                            <option value="{{$campaningInfo->pkCommercial_campaigns }}">{!!$campaningInfo->name!!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="exampleSorting"></div>
                                </div>
                            </div><!-- Column -->
                            <!-- Column -->
                            <div class="col-md-5 col-12 card">
                                <div class="card-body">
                                    <h4 class="card-title">Fechas</h4>
                                    <div class="form-row">
                                        <div class="col-6">
                                          <input type="date" id="dateInitial" class="form-control">
                                        </div>
                                        <div class="col-6">
                                          <input type="date" id="dateFinish" class="form-control">
                                        </div>
                                      </div>
                                </div>
                            </div><!-- Column -->
                            <div class="col-2 card">
                                <div class="card-body" style="margin-top: 10px">
                                 <button type="button" class="dt-button buttons-excel buttons-html5 btn btn-primary mr-1" id="search_comercial_activiy_agent">Buscar</button>
                               </div>
                           </div><!-- Column -->
                        </div>
                    </div>
                  <div id="activityComercial" class="col-md-12">
                  <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Actividades</h4>
                                <div>
                                    <canvas id="typeActivities" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" id="title_subactivity">Llamadas</h4>
                                <div>
                                    <canvas id="subtypeActivities" height="150"></canvas>
                                </div>
                              <!--  <a id="subActivityModal" data-id="0" href="#modalDetActividad" data-toggle="modal" data-target="#modalDetActividad"><span class="ti-eye"></span></a>-->
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-12">
                        <h3 class="title-section">Actividades ejecutadas por agente </h3>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Todos los agentes</h4>
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="totalActivitiesByAgent"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" id="title_agentActivities">Actividades de:  {{html_entity_decode($userHight)}}</h4>
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="activitiesByAgent" data-id="{{$userHight}}"></div>
                                </div>
                               <!-- <a href="#modalDetAgente" data-toggle="modal" data-target="#modalDetAgente"><span class="ti-eye"></span></a>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <!-- End Page Content -->

            </div><!-- End Container fluid  -->
        </div><!-- End Page wrapper  -->

        
          <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditPago" class="modalEditPago"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditPago" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalPago" role="document">
       
      </div>
    </div>
        @include('includes.footer')
        <!-- End footer -->
    </div><!-- End Wrapper -->
    
  <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalDetActividad" class="modalDetActividad"></button>
    <!-- Modal Detalle Actividad -->
    <div class="modal fade modal-gde" id="modalDetActividad" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalContDetActividad" role="document">
        
      </div>
    </div>

    <!-- Modal Agentes Campañas -->
    <div class="modal fade modal-gde" id="agregarActividad" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Agregar Actividad reciente</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h5 class=" mb-4 mt-3">Información de la actividad</h5>
            <hr>
            <form action="#">
                <div class="form-body">
                    <div class="card-body">
                        <div class="row pt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                    <label class="control-label">Agente</label>
                                    <select class="form-control custom-select" data-placeholder="Selecciona el agente" tabindex="1">
                                        <option value="">Agente 1</option>
                                        <option value="">Agente 2</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Empresa</label>
                                    <select class="form-control custom-select" data-placeholder="Selecciona la empresa" tabindex="1">
                                        <option value="">Empresa 1</option>
                                        <option value="">Empresa 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tipo de actividad</label>
                                    <select class="form-control custom-select" data-placeholder="Selecciona el tipo de actividad" tabindex="1">
                                        <option value="">Actividad 1</option>
                                        <option value="">Actividad 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Fecha y Hora</label>
                                    <input class="form-control" type="datetime-local" value="2019-08-19T13:45:00" id="example-datetime-local-input">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Comentario</label>
                                    <textarea class="form-control" cols="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Documento</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio1">Oportunidad</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio2">Cotización</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio2">Contacto inicial a empresa</label>
                                    </div>
                                    <div class="input-group mt-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputGroupFile01">
                                            <label class="custom-file-label" for="inputGroupFile01">Elegir Imagen</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--/row-->
                    </div>
                    <div class="form-actions">
                        <div class="card-body text-right">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Agregar</button>
                        </div>
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

    @include('includes.scripts')
    <script>
        $(function () {
            // responsive table
            $('#config-table').DataTable({
                            });
             $('#tableDetAgente').DataTable({
                            });
             $('#tableDetActividad').DataTable({
                            });
                            
            new Chart(document.getElementById("typeActivities"),
            {
                "type":"pie",
                "data":{"labels":[<?php echo $namesTypeActivities; ?>],
                        "datasets":[{
                            "label":"Actividades",
                            "data":[<?php echo $totalTypeActivities; ?>],
                            "backgroundColor":[<?php echo $colorsTypeActivities; ?>]}
                        ]},
                options: {
                    legend:{
                        onClick: function(event, item){
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                data: { "text": item.text},
                                url: '/loadPieGraphicTypeActivities',
                                beforeSend: function () {
                                },
                                success: function (response) {
                                    $("#title_subactivity").html(response.text);
                                    $("#subActivityModal").data('id',response.text);
                                    var obj = JSON.parse(response.data);
                                    Char2.data = obj;
                                    Char2.update();
                                }
                            });                        
                        }
                    }
                }
            });
            
            var Char2 = new Chart(document.getElementById("subtypeActivities"),
            {
                "type":"pie",
                "data":{"labels":[<?php echo $namesSubtypeActivities; ?>],
                "datasets":[{
                    "label":"Llamadas",
                    "data":[<?php echo $totalSubtypeActivities; ?>],
                    "backgroundColor":[<?php echo $colorsSubtypeActivities; ?>]}
                ]},
                 options: {
                    legend:{
                        onClick: function(event, item){
                            // console.log($("#title_subactivity").text()); 
                             var activity = $("#title_subactivity").text();
                             $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                data: { "text": item.text,"activity":activity },
                                url: '/loadModalSubActivity',
                                beforeSend: function () {
                                },
                                success: function (response) {
                                    $('#modalContDetActividad').empty();
                                    $('#modalContDetActividad').html(response.view);
                                    $('.modalDetActividad').trigger('click');
                                }
                            });   
                        }
                    }
                }    
            });
                
        });
        
        
        $(function () {
        
            var data1 = [<?php echo $dataGraphicPie; ?>];
    
            var data2 = [<?php echo $dataGraphicPieTwo; ?>];
            
         
  
    
            $.plot($("#totalActivitiesByAgent"), data1, {
                series: {
                    pie: {
                        innerRadius: 0.5
                        , show: true
                    }
                }
                , grid: {
                    hoverable: true,
                    clickable: true
                }
                , color: null
                , tooltip: true
                , tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20
                        , y: 0
                    }
                    , defaultTheme: false
                }
            });
            
            $("#totalActivitiesByAgent").bind("plotclick", function(event, pos, obj) {
                if (!obj) { return;}
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    data: { "text": obj.series.label},
                    url: '/loadPieGraphicAgents',
                    beforeSend: function () {
                    },
                    success: function (response) {
                        $("#title_agentActivities").html("Actividades de: "+response.text);
                        $("#activitiesByAgent").data("id",response.text);
                        
                        var obj2 = JSON.parse(response.data);
                        plot.setData(obj2);
                        plot.setupGrid();
                        plot.draw();
                    }
                });      
            });

            var plot =  $.plot($("#activitiesByAgent"), data2, {
                series: {
                    pie: {
                        innerRadius: 0.5
                        , show: true
                    }
                }
                , grid: {
                    hoverable: true,
                    clickable: true
                }
                , color: null
                , tooltip: true
                , tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20
                        , y: 0
                    }
                    , defaultTheme: false
                }
            });
            
            $("#activitiesByAgent").bind("plotclick", function(event, pos, obj) {
                if (!obj) { return;}
                     console.log( );
                     console.log(obj);
                     
                   $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    data: { "text": obj.series.label
                           ,"user": $("#activitiesByAgent").data("id")},
                    url: '/loadModalActivityByAgent',
                    beforeSend: function () {
                    },
                    success: function (response) {
                       $('#modalContDetActividad').empty();
                                    $('#modalContDetActividad').html(response.view);
                                    $('.modalDetActividad').trigger('click');
                    }
                });   
                     
            });
        });
    </script>
    <!-- End scripts  -->
</body>

</html>