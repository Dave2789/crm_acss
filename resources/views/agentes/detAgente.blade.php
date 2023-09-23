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
                        <h4 class="text-themecolor">Perfil del Agente</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Perfil del Agente</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Detalle -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-2 col-2 px-0">
                                        <img src="/images/usuarios/{{$agentInfo->image}}" class="img-circle img-fluid"/>
                                    </div>
                                    <div class="col-sm-10">
                                        <h4 class="card-title mt-0">{!! $agentInfo->full_name !!}</h4>
                                        <h6 class="card-subtitle">{!! $agentInfo->type !!}</h6>
                                    </div>
                                </div>
                                <div class="ag-ventas">
                                    <div class="card">
                                        <div class="cuenta-ag">
                                            <h5 class="m-b-0 c-title" style="background-color:#138e44;">Ventas</h5>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h6>Realizadas</h6>
                                                    <span>
                                                        <font class="font-medium badge badge-pill badge-success">{{ $agentInfo->salesPay }} </font>
                                                    </span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h6>Perdidas</h6>
                                                    <span>
                                                        <font class="font-medium font-medium badge badge-pill badge-danger"> {{ $agentInfo->salesLoss }}</font>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="cuenta-ag">
                                            <h5 class="m-b-0 c-title" style="background-color:#13ae75;">Cotizaciones</h5>
                                            <div class="row">
                                               <!--   <div class="col-sm-4">
                                                    <h6>Pagadas</h6>
                                                    <span>
                                                        <font class="font-medium badge badge-pill badge-success">400 </font>
                                                    </span>
                                                </div>-->
                                                <div class="col-sm-12">
                                                    <h6>En proceso</h6>
                                                    <span>
                                                        <font class="font-medium badge badge-pill badge-info">{{ $agentInfo->quotations }} </font>
                                                    </span>
                                                </div>
                                               <!-- <div class="col-sm-4">
                                                    <h6>Perdidas</h6>
                                                    <span>
                                                        <font class="font-medium badge badge-pill badge-danger">200 </font>
                                                    </span>
                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="cuenta-ag">
                                            <h5 class="m-b-0 c-title" style="background-color:#0aaeae;">Oportunidades de negocio</h5>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h6>Convertidas</h6>
                                                    <span>
                                                        <font class="font-medium badge badge-pill badge-success">{{ $agentInfo->oportunityAproved }} </font>
                                                    </span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h6>Abiertas</h6>
                                                    <span>
                                                        <font class="font-medium badge badge-pill badge-info">{{ $agentInfo->oportunityOpen }} </font>
                                                    </span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h6>Perdidas</h6>
                                                    <span>
                                                        <font class="font-medium badge badge-pill badge-danger">{{ $agentInfo->oportunityLoss }} </font>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                
                                   <div class="ag-bonos">
                                       <h3 class="my-2">Ventas: <strong> $ {{ number_format($salary["totalVent"],2)}} </strong></h3>
                                   </div>
                                
                                <div class="ag-bonos">
                                    <h3 class="my-2">Bonos</h3>
                                    <div class="row ag-llamadas align-self-center mb-1">
                                        <div class="col-sm-6 text-right">
                                            Monto Base Asignado:
                                        </div>
                                        <div class="col-sm-6">

                                            <span class="">$ {{ number_format($salary["montBase"],2) }} </span>
                                        </div>
                                    </div>
                                    <div class="row ag-llamadas align-self-center mb-1">
                                        <div class="col-sm-6 text-right">
                                            Monto Base Alcanzado:
                                        </div>
                                        <div class="col-sm-6">

                                            <span class="">$ {{ number_format($salary["montReal"],2) }}</span>
                                        </div>
                                    </div>
                                    <div class="row ag-llamadas align-self-center mb-1">
                                        <div class="col-sm-6 text-right">
                                            Bonos:
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-success">$ {{ number_format($salary["totalBonusBase"] + $salary["totalBonusRecord"] + $salary["totalBonusTecho"],2) }}</span>
                                        </div>
                                    </div>
                                    <div class="row ag-llamadas align-self-center mb-1">
                                        <div class="col-sm-6 text-right">
                                            Penalizaci&oacute;n:
                                        </div>
                                        <div class="col-sm-6">
                                            @if(!empty($PenalitationCourse))
                                            <span class="text-danger">$ {{ number_format($salary["penality"] + $PenalitationCourse ,2) }}</span>
                                            @else
                                            <span class="text-danger">$ 0.00</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row ag-llamadas align-self-center mb-1">
                                        <div class="col-sm-6 text-right">
                                            Comisión:
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-success">$ {{ number_format($salary["comition"],2) }}</span>
                                        </div>
                                    </div>
                                    @if($salary["isBonusbase"] == 1)
                                    <div class="row ag-llamadas align-self-center mb-1">
                                        <div class="col-sm-6 text-right">
                                            Bono Base
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-info">$ {{ number_format($salary["montRecBase"],2) }}</span>
                                            <div class="progress mt-1">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ round($salary["porcentBase"]) }}%;height:15px;" role="progressbar">{{ round($salary["porcentBase"]) }}%</div>
                                            </div>
                                        </div>
                                       <!-- <div class="col-12 bg-success mt-1 text-white px-1 py-1 text-center">
                                            <span class="ti-money"></span> Primero en alcanzar las ventas 
                                        </div>-->
                                    </div>
                                    @else
                                    <div class="row ag-llamadas align-self-center mb-1">
                                        <div class="col-sm-6 text-right">
                                            Bono Base
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-danger">  No configurado </span>
                                        </div>
                                       <!-- <div class="col-12 bg-success mt-1 text-white px-1 py-1 text-center">
                                            <span class="ti-money"></span> Primero en alcanzar las ventas 
                                        </div>-->
                                    </div>
                                    @endif
                                    
                                    @if($salary["isBonusRecord"] == 1)
                                    <div class="row ag-llamadas align-self-center mb-1">
                                        <div class="col-sm-6 text-right">
                                            Bono Record
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-success">$ {{ number_format($salary["montRecRecord"],2) }}</span>
                                            <div class="progress mt-1">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ round($salary["porcentRecord"]) }}%;height:15px;" role="progressbar">{{ round($salary["porcentRecord"]) }}%</div>
                                            </div>
                                        </div>

                                    </div>
                                    @else 
                                    <div class="row ag-llamadas align-self-center mb-1">
                                        <div class="col-sm-6 text-right">
                                            Bono Record
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-danger">  No configurado </span>
                                        </div>

                                    </div>
                                    @endif
                                    
                                     @if($salary["isBonusTecho"] == 1)
                                    <div class="row ag-llamadas align-self-center mb-1">
                                        <div class="col-sm-6 text-right">
                                            Bono Techo
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-success">$ {{ number_format($salary["montRecTecho"],2) }}</span>
                                            <div class="progress mt-1">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ round($salary["porcentTecho"]) }}%;height:15px;" role="progressbar">{{ round($salary["porcentTecho"]) }}%</div>
                                            </div>
                                        </div>
                                    </div>
                                    @else 
                                    <div class="row ag-llamadas align-self-center mb-1">
                                        <div class="col-sm-6 text-right">
                                            Bono Techo
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-danger">  No configurado </span>
                                        </div>
                                    </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div><!-- / Column -->
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-9 col-md-7" style="max-height: 600px; overflow-y: scroll;">
                        <div class="card act-ag">
                            <div class="card-body">
                                <div class="mb-4">
                                    <h5 class="card-title">Actividades Pendientes</h5>
                                </div>
                                <div class="row">  
                                      <div class="col-12">
                                        <select data-id="{{ $pkUser}}" class="form-control custom-select" id="slcTypeActivity" data-placeholder="Selecciona la Actividad" tabindex="1">                                          
                                            <option value="-1">Todas las actividad</option>
                                             @foreach($typeActivity as $typeActivityInfo)
                                             <option value="{{$typeActivityInfo->pkActivities_type  }}">{!! $typeActivityInfo->text !!}</option>
                                             @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="steamline m-t-40" id="activityPending">
                                    @foreach($activitiesQuery as $activitiesInfo)
                                    <div class="sl-item">
                                        <div class="sl-left bg-info" style="background-color: {{$activitiesInfo->color}}!important;"> <i class="{{$activitiesInfo->icon}}"></i>
                                        </div>
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
                                            <a target="_blank" href="/detEmpresa/{{ $activitiesInfo->pkBusiness}}"> <small class="pl-2 text-muted"><i class="ti-bookmark"></i> {{html_entity_decode($activitiesInfo->business_name)}}</small></a>
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
                    
                    <div class="col-lg-4 col-xlg-9 col-md-7" style="max-height: 600px; overflow-y: scroll;">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Actividades Realizadas</h5>
                                 <div class="message-box">
                                <div class="message-widget message-scroll">
                                    <!-- Message -->
                                    @foreach($lastActivitiesQuery as $lastActivitiesInfo)
                                    <a>
                                        <div class="user-img">
                                            <span class="round" style="background-color: {{$lastActivitiesInfo->color}}!important;"> <i class="{{$lastActivitiesInfo->icon}}"></i></span>
                                            <span class="profile-status away pull-right"></span>
                                        </div>
                                        <div class="mail-contnet">
                                            <h5>{!!$lastActivitiesInfo->text!!}</h5>
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

                        <div class="row">
                            <!-- Column -->
                            <div class="col-lg-12 col-xlg-3 col-md-5">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        
                                        <div class="ag-bonos">
        
                                            <div class="row ag-llamadas align-self-center mb-1">
                                               <div class="col-sm-3"> 
                                                 <div class="row">
                                                  <div class="col-sm-6 text-right">
                                                    Monto Base:
                                                </div>
                                                <div class="col-sm-6">
        
                                                    <span class="">$ {{ number_format($salary["montBase"],2) }} </span>
                                                </div>
                                                 </div>
                                                 <div class="row">
                                                   <div class="col-sm-6 text-right">
                                                    Monto Base Real:
                                                   </div>
                                                  <div class="col-sm-6">
        
                                                    <span class="">$ {{ number_format($salary["montReal"],2) }}</span>
                                                   </div>
                                                 </div>
                                              </div>
        
                                              <div class="col-sm-3"> 
                                                <div class="row">
                                                 <div class="col-sm-6 text-right">
                                                   <b> Total Bonos: </b>
                                                </div>
                                                  <div class="col-sm-6">
                                                    <span class="text-success">$ {{ number_format($salary["totalBonusBase"] + $salary["totalBonusRecord"] + $salary["totalBonusTecho"],2) }}</span>
                                                  </div>
        
                                                  <div class="col-sm-6 text-right">
                                                    Bono Base:
                                                </div>
                                                  <div class="col-sm-6">
                                                    <span class="text-info">$ {{ number_format($salary["totalBonusBase"],2) }}</span>
                                                  </div>
        
                                                  <div class="col-sm-6 text-right">
                                                    Bono Record:
                                                </div>
                                                  <div class="col-sm-6">
                                                    <span class="text-info">$ {{ number_format($salary["totalBonusRecord"],2) }}</span>
                                                  </div>
        
                                                <div class="col-sm-6 text-right">
                                                    Bono Techo:
                                                </div>
                                                  <div class="col-sm-6">
                                                    <span class="text-info">$ {{ number_format($salary["totalBonusTecho"],2) }}</span>
                                                  </div>
        
        
                                                 </div>
        
                                               </div>
        
                                              <div class="col-sm-4"> 
                                                 <div class="row">
                                                    <div class="col-sm-6 text-right">
                                                        <b> Total penalizaci&oacute;n: </b>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        @if(isset($salary["penalityBase"]) && isset($salary["penalityTecho"]))
                                                        <span class="text-danger">$ {{ number_format($salary["penalityBase"] + $salary["penalityTecho"] + $PenalitationCourse ,2) }}</span>
                                                        @else 
                                                        <span class="text-info">$ 0.00 </span>
                                                        @endif
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                 <div class="col-sm-6 text-right">
                                                   Base:
                                                </div>
                                                  <div class="col-sm-6">
                                                    @if(isset($salary["penalityBase"]))
                                                    <span class="text-info">$ {{ number_format($salary["penalityBase"],2)}}</span>
                                                    @else 
                                                    <span class="text-info">$ 0.00 </span>
                                                    @endif
                                                  </div>
                                                 </div>
        
                                                 <div class="row">
                                                  <div class="col-sm-6 text-right">
                                                    Techo:
                                                </div>
                                                  <div class="col-sm-6">
                                                      @if(isset($salary["penalityTecho"]))
                                                    <span class="text-info">$ {{ number_format($salary["penalityTecho"],2) }}</span>
                                                     @else 
                                                     <span class="text-info">$ 0.00 </span>
                                                     @endif
                                                  </div>
                                                 </div>
        
                                                 <div class="row">
                                                  <div class="col-sm-6 text-right">
                                                   Capacitación:
                                                </div>
                                                  <div class="col-sm-6">
                                                      @if(!empty($PenalitationCourse))
                                                    <span class="text-info">$ {{ number_format($PenalitationCourse,2) }}</span>
                                                    @else 
                                                    <span class="text-info">$ 0.00</span>
                                                    @endif
                                                  </div>
                                                 </div>
        
                                               </div>
        
                                               <div class="col-sm-2"> 
                                                <div class="row">
                                                   <div class="col-sm-7 text-right">
                                                    Comisión:
                                                   </div>
                                                 <div class="col-sm-5">
                                                    <span class="text-success">$ {{ number_format($salary["comition"],2) }}</span>
                                                </div>
                                              </div>
        
                                            </div>
                                            <div class="ag-bonos">
                                                @if(isset($salary["penalityBase"]) && isset($salary["penalityTecho"]) && !empty($PenalitationCourse))
                                                <h4 class="card-title mt-0">Salario Total: <strong> $ {{ number_format( ($salary["montReal"] + $salary["totalBonusBase"] + $salary["totalBonusRecord"] + $salary["totalBonusTecho"] + $salary["comition"] ) - ($salary["penalityBase"] + $salary["penalityTecho"] + $PenalitationCourse) ,2)}}</strong></h3>
                                                @else 
                                                <h4 class="card-title mt-0">Salario Total: <strong> $ {{ number_format( ($salary["montReal"] + $salary["totalBonusBase"] + $salary["totalBonusRecord"] + $salary["totalBonusTecho"] + $salary["comition"] ),2)}}</strong></h3>
                                                @endif
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- / Column -->
                        </div>
                        </div>
                    
                    <div class="col-lg-12 mt-3">
                        <div class="card">
                            <div class="card-body p-b-0">
                                <h4 class="card-title">Registro de Actividades</h4>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#llamadas-agente" role="tab"><span class="hidden-sm-up"><i class="ti-headphone-alt"></i></span> <span class="hidden-xs-down">Llamadas</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#bonos-agente" role="tab"><span class="hidden-sm-up"><i class="ti-medall"></i></span> <span class="hidden-xs-down">Bonos</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#capacitation" role="tab"><span class="hidden-sm-up"><i class="ti-medall"></i></span> <span class="hidden-xs-down">Capacitaci&oacute;n</span></a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="llamadas-agente" role="tabpanel">
                                    <div class="p-20">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4>- - - Estatus de las llamadas</h4>
                                                <div class="row justify-content-between ag-llamadas mt-3">
                                                    <div class="col-lg-12">
                                                        <div class="card">
                                                            <div class="d-flex flex-row">
                                                                <div class="p-10" style="background-color:#ff0080;">
                                                                    <h3 class="text-white box m-b-0"><i class="ti-mobile"></i></h3></div>
                                                                <div class="align-self-center m-l-20" style="width: 100%;">
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <h2 class="m-b-0" style="color:#ff0080;">{{ $arrayWorkPlan[$pkWorkplan]["qtyCallsToday"] }}</h2>
                                                                            <h5 class="text-muted m-b-0">Llamadas para realizar hoy</h5>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <h3 class="m-b-0 text-info">{{ $arrayWorkPlan[$pkWorkplan]["qtyHourMonth"] }}</h3>
                                                                            <h5 class="text-muted m-b-0">Llamadas para realizar en el mes</h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   <div class="col-sm-5">
                                                        <div class="card">
                                                                <h5 class="card-title m-b-0">Llamadas registradas en sistema</h5>
                                                                <hr>
                                                                <div class="row p-b-10">
                                                                    <div class="col p-r-0">
                                                                        <div>
                                                                            <h1 class="font-light text-success">{{ $arrayWorkPlan[$pkWorkplan]["callSystem"] }} <span class="text-muted"> Realizadas</span></h1>
                                                                            
                                                                        </div>
                                                                        <div>
                                                                            <h1 class="font-light text-danger">{{ $arrayWorkPlan[$pkWorkplan]["qtyHourMonth"] - $arrayWorkPlan[$pkWorkplan]["callSystem"] }} <span class="text-muted"> Faltantes</span></h1>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col text-right align-self-center">
                                                                        <?php
                                                                        if($arrayWorkPlan[$pkWorkplan]["qtyHourMonth"] > 0){
                                                                          $percentCallsDone = ($arrayWorkPlan[$pkWorkplan]["callSystem"] * 100) / $arrayWorkPlan[$pkWorkplan]["qtyHourMonth"];
                                                                        }else{
                                                                          $percentCallsDone = 0; 
                                                                        }
                                                                        ?>
                                                                        <!--<div data-label="{{round($percentCallsDone)}}%" class="css-bar m-b-0 css-bar-success css-bar-20"><i class="mdi mdi-account-circle"></i></div>-->
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <div class="card">
                                                                <h5 class="card-title m-b-0">Llamadas cargadas al sistema</h5>
                                                                <hr>
                                                                <div class="row p-b-10">
                                                                    <div class="col p-r-0">
                                                                        <div>
                                                                            <h1 class="font-light text-success">{{ $arrayWorkPlan[$pkWorkplan]["callRegister"] }}<span class="text-muted"> Realizadas</span></h1>
                                                                            
                                                                        </div>
                                                                        <div>
                                                                            <h1 class="font-light text-danger">{{ $arrayWorkPlan[$pkWorkplan]["qtyHourMonth"] -$arrayWorkPlan[$pkWorkplan]["callRegister"] }}<span class="text-muted"> Faltantes</span></h1>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col text-right align-self-center">
                                                                        <?php
                                                                        if($arrayWorkPlan[$pkWorkplan]["qtyHourMonth"] > 0){
                                                                          $percentCallsDone =  ($arrayWorkPlan[$pkWorkplan]["callRegister"] * 100) / $arrayWorkPlan[$pkWorkplan]["qtyHourMonth"];
                                                                        }else{
                                                                          $percentCallsDone = 0; 
                                                                        }
                                                                        ?>
                                                                        <!--<div data-label="{{round($percentCallsDone)}}%" class="css-bar m-b-0 css-bar-success css-bar-20"><i class="mdi mdi-account-circle"></i></div>-->
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       <!-- <div class="card">
                                            <div class="card-body">
                                                <h4 class="mb-2">Vol&uacute;men de llamadas General y Promedio Mensual del Sistema</h4>
                                                <table class="table ag-llamadas">
                                                    <thead>
                                                        <tr>
                                                            <th>Total a realizar</th>
                                                            <th>Cantidad Realizada</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                               Total de llamadas por mes:
                                                                <span class="text-info">  {{ $arrayWorkPlan[$pkWorkplan]["qtyHourMonth"] }} </span>100% 
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-sm-3 text-right">
                                                                        <span class="text-info">{{ $arrayWorkPlan[$pkWorkplan]["callSystem"] }}   </span>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="progress mt-1">
                                                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $arrayWorkPlan[$pkWorkplan]['callSystemPorcent'] }}%;height:15px;" role="progressbar"> {{ $arrayWorkPlan[$pkWorkplan]["callSystemPorcent"] }}% </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Llamadas enlazadadas:
                                                                <span class="text-success">{{ $arrayWorkPlan[$pkWorkplan]["callLinkedTotal"] }} </span>{{ $arrayWorkPlan[$pkWorkplan]["callsLinked"] }}%
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-sm-3 text-right">
                                                                        <span class="text-success">{{ $arrayWorkPlan[$pkWorkplan]["callsLinkedActual"] }} </span>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="progress mt-1">
                                                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{  $arrayWorkPlan[$pkWorkplan]['callLinkedActualPorcent'] }}%;height:15px;" role="progressbar"> {{ $arrayWorkPlan[$pkWorkplan]["callLinkedActualPorcent"] }}% </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Llamadas fallidas:
                                                                <span class="text-danger">{{ $arrayWorkPlan[$pkWorkplan]["callLinkedFaild"] }} </span>{{ $arrayWorkPlan[$pkWorkplan]["callsFaild"] }}%
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-sm-3 text-right">
                                                                        <span class="text-danger">{{ $arrayWorkPlan[$pkWorkplan]["callsFiledActual"] }} </span>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="progress mt-1">
                                                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $arrayWorkPlan[$pkWorkplan]['callFaildActualPorcent']  }}%;height:15px;" role="progressbar"> {{ $arrayWorkPlan[$pkWorkplan]["callFaildActualPorcent"] }}%
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @if($arrayWorkPlan[$pkWorkplan]["callsFaild"] < $arrayWorkPlan[$pkWorkplan]["callFaildActualPorcent"])
                                                        <tr>
                                                            <td>
                                                                <i class="ti-face-sad"></i> Penalizaci&oacute;n:
                                                                <span class="text-danger">-{{ $arrayWorkPlan[$pkWorkplan]["penalty"] }} %</span>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>-->
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="mb-2">Vol&uacute;men de llamadas General y Promedio Mensual</h4>
                                                <table class="table ag-llamadas">
                                                    <thead>
                                                        <tr>
                                                            <th>Total a realizar</th>
                                                            <th>Cantidad Realizada</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                Total de llamadas por mes:
                                                                <span class="text-info">{{ $arrayWorkPlan[$pkWorkplan]["qtyHourMonth"] }} </span>100%
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-sm-3 text-right">
                                                                        <span class="text-info">{{ $arrayWorkPlan[$pkWorkplan]["callRegister"] }} </span>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="progress mt-1">
                                                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $arrayWorkPlan[$pkWorkplan]['callRegisterPorcent'] }}%;height:15px;" role="progressbar"> {{ $arrayWorkPlan[$pkWorkplan]["callRegisterPorcent"] }} %</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Llamadas enlazadadas:
                                                                <span class="text-success">{{ $arrayWorkPlan[$pkWorkplan]["callLinkedTotal"] }} </span>{{ $arrayWorkPlan[$pkWorkplan]["callsLinked"] }}%
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-sm-3 text-right">
                                                                        <span class="text-success">{{ $arrayWorkPlan[$pkWorkplan]["callsLinkedActualR"] }}</span>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="progress mt-1">
                                                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $arrayWorkPlan[$pkWorkplan]['callLinkedActualPorcentR'] }}%;height:15px;" role="progressbar">{{ $arrayWorkPlan[$pkWorkplan]["callLinkedActualPorcentR"] }}%</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Llamadas fallidas:
                                                                <span class="text-danger">{{ $arrayWorkPlan[$pkWorkplan]["callLinkedFaild"] }} </span>{{ $arrayWorkPlan[$pkWorkplan]["callsFaild"] }}%
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-sm-3 text-right">
                                                                        <span class="text-danger">{{ $arrayWorkPlan[$pkWorkplan]["callsFiledActualR"] }}</span>
                                                                    </div>
                                                                    <div class="col-sm-9">
                                                                        <div class="progress mt-1">
                                                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $arrayWorkPlan[$pkWorkplan]['callFaildActualPorcentR'] }}%;height:15px;" role="progressbar">{{ $arrayWorkPlan[$pkWorkplan]["callFaildActualPorcentR"] }}%</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @if($arrayWorkPlan[$pkWorkplan]["callsFaild"] < $arrayWorkPlan[$pkWorkplan]["callFaildActualPorcentR"])
                                                        <tr>
                                                            <td>
                                                                <i class="ti-face-sad"></i>  Penalizaci&oacute;n:
                                                                <span class="text-danger">-{{ $arrayWorkPlan[$pkWorkplan]["penalty"]}}%</span>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane  p-20" id="bonos-agente" role="tabpanel">
                                    <div class="row bonos-ag">
                                        @if(isset($arrayWorkPlan[$pkWorkplan]["bonds"]))
                                        <div class="col-md-4">
                                            @if(isset($arrayWorkPlan[$pkWorkplan]["bonds"]["base"]))
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Bono Rompe Base</h4>
                                                    <hr>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Meta:
                                                        </div>
                                                        <div class="col-sm-6">
                                                            $ <span>{{ number_format($arrayWorkPlan[$pkWorkplan]["bonds"]["base"]["montRec"],2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Mínimo:
                                                        </div>
                                                        <div class="col-sm-6">
                                                            $ <span>{{ number_format($arrayWorkPlan[$pkWorkplan]["bonds"]["base"]["montMin"],2) }} </span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Mis ventas actuales:
                                                        </div>
                                                        <div class="col-sm-6 text-success">
                                                            $ <span>{{ number_format($salary["totalVent"],2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Bono:
                                                        </div>
                                                        <div class="col-sm-6 text-success">
                                                            $ <span>{{ number_format($salary["totalBonusBase"],2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                           Penalización:
                                                        </div>
                                                        <div class="col-sm-6 text-danger">
                                                            $ <span>{{ number_format($salary["penalityBase"],2) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="col-md-4">
                                            @if(isset($arrayWorkPlan[$pkWorkplan]["bonds"]["record"]))
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Bono Rompe Record</h4>
                                                    <hr>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Meta:
                                                        </div>
                                                        <div class="col-sm-6">
                                                            $ <span>{{number_format($arrayWorkPlan[$pkWorkplan]["bonds"]["record"]["montMet"],2)}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Ventas actuales conjunto:
                                                        </div>
                                                        <div class="col-sm-6">
                                                            $ <span>{{ number_format($salary["totalVentGroup"],2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Mis ventas:
                                                        </div>
                                                        <div class="col-sm-6 text-success">
                                                            $ <span>{{ number_format($salary["totalVent"],2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Bono:
                                                        </div>
                                                        <div class="col-sm-6 text-success">
                                                            $ <span>{{ number_format($salary["totalBonusRecord"],2) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="col-md-4">
                                            @if(isset($arrayWorkPlan[$pkWorkplan]["bonds"]["techo"]))
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>Bono Rompe Techo</h4>
                                                    <hr>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Meta:
                                                        </div>
                                                        <div class="col-sm-6">
                                                           $ <span>{{number_format($arrayWorkPlan[$pkWorkplan]["bonds"]["techo"]["montMet"],2)}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Mínimo:
                                                        </div>
                                                        <div class="col-sm-6">
                                                            $ <span>{{number_format($arrayWorkPlan[$pkWorkplan]["bonds"]["techo"]["montRep"],2)}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Mis ventas Actuales:
                                                        </div>
                                                        <div class="col-sm-6 text-success">
                                                            $ <span>{{ number_format($salary["totalVentPromo"],2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Bono:
                                                        </div>
                                                        <div class="col-sm-6 text-success">
                                                            $ <span>{{ number_format($salary["totalBonusTecho"],2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                           Penalización:
                                                        </div>
                                                        <div class="col-sm-6 text-danger">
                                                            $ <span>{{ number_format($salary["penalityTecho"],2) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        @else
                                        <span>Sin bonos configurados</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane  p-20" id="capacitation" role="tabpanel">
                                    <div class="row bonos-ag">
                                        <div class="table-responsive">
                                            <table id="oporNeg3" class="table table-hover no-wrap">
                                                <thead>
                                                    <tr>
                                                        <th>Curso</th>
                                                        <th>Estatus</th>
                                                        <th>Penalizaci&oacute;n %</th>
                                                        <th>Fecha l&iacute;mite</th>
                                                        <th>Subir documento</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   @if(!empty($course))
                                                    @foreach($course as $item)
                                                    <tr>
                                                         @if(!empty($item->pkCourse))
                                                            <td>{{$item->code}} - {!!$item->name!!}</td>
                                                            @else
                                                             <td>{{$item->code}} - {!!$item->nameCourse !!}</td>
                                                            @endif
                                                        @if($item->isView == 1)
                                                        <td>Realizado </td>
                                                        @else
                                                        <td>Sin realizar</td>
                                                        @endif
                                                        <td>{{$item->penality}}</td>
                                                         <td>{{$item->expiration}} {{$item->expiration_hour}}</td>
                                                       @if(empty($item->document))
                                                        <td>  <button type="button" class="btn btn-secondary btn-uploadDocument" data-id="{{ $item->pkCourses_by_capacitation}}"><span class="ti-check-box"></span></button></td>
                                                       @else
                                                       <td>Archivo cargado</td>
                                                       @endif
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div>
                                <div class="btn btn-primary btn-sm f-right m-2">
                                  <a href="/salesByAgent" class="text-light" ><span class="ti-arrow-left"></span> Regresar</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="oporNeg" class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th>Empresa</th>
                                            <th>Ventas</th>
                                            <th>Cotizaciones</th>
                                            <th>Oportunidades<br>de Negocio</th>
                                            <th>Lugares</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($arrayBusinessData as $pkBusiness => $data)
                                        <tr>
                                            <td><a href="/detEmpresa/{{$data["pkBusiness"]}}"> {!!$data["name"]!!} </a></td>
                                            <td>
                                                <span class="label label-success">{{ $data["salesPay"] }} </span> 
                                                <span class="label label-danger"> {{ $data["salesLoss"] }}</span> 
                                            </td>
                                            <td>
                                            <span class="label label-info"> {{ $data["quotations"] }}</span>     
                                            </td>
                                            <td>  
                                                <span class="label label-success">{{ $data["oportunityAproved"] }}</span> 
                                                <span class="label label-info"> {{ $data["oportunityOpen"] }}</span>
                                                <span class="label label-danger"> {{ $data["oportunityLoss"] }}</span>
                                              </td>
                                            <td>
                                                @if(!empty($item->salesPlaces))
                                                {{ $data["salesPlaces"]}}
                                                @else
                                                <span>0</span>
                                                @endif
                                            </td>
                                            <td>
                                              @if(!empty($data["salesMont"]))
                                               <span class="text-success">$ {{ number_format($data["salesMont"],2)}}</span>
                                                @else
                                               <span class="text-success">$ 0</span>
                                                @endif
                                             </td>
                                        </tr>
                                        
                                        @endforeach
                                       
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


    @include('includes.scripts')

    <!-- End scripts  -->
    
    <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditUsuario" class="modalEditUsuario"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditUsuario" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalUsuario" role="document">
       
      </div>
    </div>
       
           <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditPago" class="modalEditPago"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditPago" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalPago" role="document">
       
      </div>
    </div>

    <!-- Ventas -->
    <div class="modal fade modal-gde" id="modalVentasAgente" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Ventas</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3><img src="/images/usuarios/user.jpg" style="max-height:40px"> AppendCloud</h3>
            <div class="table-responsive">
                <table class="table table-hover no-wrap">
                    <thead>
                        <tr>
                            <th>Fecha y Hora</th>
                            <th>Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>15-Jun-19 12:20 pm</td>
                            <td><a href=""><span class="ti-write"></span> Ver</a> </td>
                        </tr>
                        <tr>
                            <td>15-Jun-19 12:20 pm</td>
                            <td><a href=""><span class="ti-write"></span> Ver</a> </td>
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
    <!-- Cotizaciones -->
    <div class="modal fade modal-gde" id="modalCotizacionesAgente" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Cotizaciones</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3><img src="/images/usuarios/user.jpg" style="max-height:40px"> AppendCloud</h3>
            <div class="table-responsive">
                <table class="table table-hover no-wrap">
                    <thead>
                        <tr>
                            <th>Fecha y Hora</th>
                            <th>Estatus</th>
                            <th>Nivel de<br>Interés</th>
                            <th>Última <br>actividad</th>
                            <th>Siguiente <br>actividad</th>
                            <th>Vencimiento<br>siguiente actividad</th>
                            <th>Documento</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>15-Jun-19 12:20 pm</td>
                            <td><span class="badge badge-success">Cerrada</span></td>
                            <td>Nivel 1</td>
                            <td>Llamada de oferta</td>
                            <td>Email con propuesta</td>
                            <td>18-Jun-19</td>
                            <td><a href=""><span class="ti-write"></span> Ver</a> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>15-Jun-19 12:20 pm</td>
                            <td><span class="badge badge-info">Abierta</span></td>
                            <td>Nivel 2</td>
                            <td>Llamada de oferta</td>
                            <td>Email con propuesta</td>
                            <td>18-Jun-19</td>
                            <td><a href=""><span class="ti-write"></span> Ver</a> </td>
                            <td class="text-center"><a href=""><span class="ti-pencil"></span></a> </td>
                        </tr>
                        <tr>
                            <td>15-Jun-19 12:20 pm</td>
                            <td><span class="badge badge-danger">Descartada</span></td>
                            <td>Nivel 2</td>
                            <td>Llamada de oferta</td>
                            <td>Email con propuesta</td>
                            <td>18-Jun-19</td>
                            <td><a href=""><span class="ti-write"></span> Ver</a> </td>
                            <td></td>
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
    <!-- Oportunidades -->
    <div class="modal fade modal-gde" id="modalOportunidadesAgente" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Oportunidades</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3><img src="/images/usuarios/user.jpg" style="max-height:40px"> AppendCloud</h3>
            <div class="table-responsive">
                <table class="table table-hover no-wrap">
                    <thead>
                        <tr>
                            <th>Fecha y Hora</th>
                            <th>Estatus</th>
                            <th>Nivel de<br>Interés</th>
                            <th>Última <br>actividad</th>
                            <th>Siguiente <br>actividad</th>
                            <th>Vencimiento<br>siguiente actividad</th>
                            <th>Documento</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>15-Jun-19 12:20 pm</td>
                            <td><span class="badge badge-success">Convertida</span></td>
                            <td>Nivel 1</td>
                            <td>Llamada de oferta</td>
                            <td>Email con propuesta</td>
                            <td>18-Jun-19</td>
                            <td><a href=""><span class="ti-write"></span> Ver</a> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>15-Jun-19 12:20 pm</td>
                            <td><span class="badge badge-info">Abierta</span></td>
                            <td>Nivel 2</td>
                            <td>Llamada de oferta</td>
                            <td>Email con propuesta</td>
                            <td>18-Jun-19</td>
                            <td><a href=""><span class="ti-write"></span> Ver</a> </td>
                            <td class="text-center"><a href=""><span class="ti-pencil"></span></a> </td>
                        </tr>
                        <tr>
                            <td>15-Jun-19 12:20 pm</td>
                            <td><span class="badge badge-danger">Descartada</span></td>
                            <td>Nivel 2</td>
                            <td>Llamada de oferta</td>
                            <td>Email con propuesta</td>
                            <td>18-Jun-19</td>
                            <td><a href=""><span class="ti-write"></span> Ver</a> </td>
                            <td></td>
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
        
         $(function () {
            $('#oporNeg2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });    
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
        });
        
        $(function () {
            $('#oporNeg3').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });    
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
        });
    </script>
</body>
</html>