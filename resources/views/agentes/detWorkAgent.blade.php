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
                        <h4 class="text-themecolor">Agente</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Agente</li>
                            </ol>
                        </div>
                    </div>
                </div>
               

                <!-- Detalle -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="col-md-12 align-self-center text-right" style="margin-top: 5px">
                                <div class="d-flex justify-content-end align-items-center">
                                    <a href="/verplandetrabajo" class="text-light btn btn-primary btn-sm"><span class="ti-arrow-left"></span> Regresar</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-2 col-2 px-0">
                                        <img src="/images/usuarios/{{$agentInfo->image}}" class="img-circle img-fluid"/>
                                    </div>
                                    <div class="col-sm-10">
                                    <h5 class="card-title mt-0">Mes: {{$workPlan->month}} del {{$workPlan->year}}</h5>
                                        <h4 class="card-title mt-0">{!! $agentInfo->full_name !!}</h4>
                                        <h6 class="card-subtitle">{!! $agentInfo->type !!}</h6>
                                    </div>
                                </div>

                                   <div class="ag-bonos">
                                       <h3 class="my-2">Ventas: <strong> $ {{ number_format($salary["totalVent"],2)}} </strong></h3>
                                   </div>

                                 
                                
                                   <div class="ag-bonos">
        
                                    <div class="row ag-llamadas align-self-center mb-1">
                                       <div class="col-sm-3"> 
                                         <div class="row">
                                          <div class="col-sm-6 text-right">
                                            Monto Base Configurado:
                                        </div>
                                        <div class="col-sm-6">

                                            <span class="">$ {{ number_format($salary["montBase"],2) }} {{$workPlan->moneda}}</span>
                                        </div>
                                         </div>
                                         <div class="row">
                                           <div class="col-sm-6 text-right">
                                            Monto Base Alcanzado:
                                           </div>
                                          <div class="col-sm-6">

                                            <span class="">$ {{ number_format($salary["montReal"],2) }} {{$workPlan->moneda}}</span>
                                           </div>
                                         </div>
                                      </div>

                                      <div class="col-sm-3"> 
                                        <div class="row">
                                        

                                          <div class="col-sm-6 text-right">
                                            Bono Base:
                                        </div>
                                          <div class="col-sm-6">
                                            <span class="text-info">$ {{ number_format($salary["totalBonusBase"],2) }} {{$workPlan->moneda}}</span>
                                          </div>

                                          <div class="col-sm-6 text-right">
                                            Bono Record:
                                        </div>
                                          <div class="col-sm-6">
                                            <span class="text-info">$ {{ number_format($salary["totalBonusRecord"] / $workPlan->typeChange,2) }} {{$workPlan->moneda}}</span>
                                          </div>

                                        <div class="col-sm-6 text-right">
                                            Bono Techo:
                                        </div>
                                          <div class="col-sm-6">
                                            <span class="text-info">$ {{ number_format($salary["totalBonusTecho"] / $workPlan->typeChange,2) }} {{$workPlan->moneda}}</span>
                                          </div>

                                          <div class="col-sm-6 text-right">
                                            <b style="font-weight:bold"> Total Bonos: </b>
                                         </div>
                                           <div class="col-sm-6">
                                             <span class="text-success">$ {{ number_format(($salary["totalBonusBase"] + $salary["totalBonusRecord"] + $salary["totalBonusTecho"]) / $workPlan->typeChange,2) }} {{$workPlan->moneda}}</span>
                                           </div>
                                           
                                         </div>

                                       </div>

                                      <div class="col-sm-4"> 
                                       
                                         <div class="row">
                                         <div class="col-sm-6 text-right">
                                           Base:
                                        </div>
                                          <div class="col-sm-6">
                                            @if(isset($salary["penalityBase"]))
                                                
                                                <span class="text-info">$ {{ number_format($salary["penalityBase"] ,2)}} {{$workPlan->moneda}}</span>
                                            @else 
                                            <span class="text-info">$ 0.00 {{$workPlan->moneda}}</span>
                                            @endif
                                          </div>
                                         </div>

                                         <div class="row">
                                          <div class="col-sm-6 text-right">
                                            Techo:
                                        </div>
                                          <div class="col-sm-6">
                                              @if(isset($salary["penalityTecho"]))
                                            <span class="text-info">$ {{ number_format($salary["penalityTecho"],2) }} {{$workPlan->moneda}}</span>
                                             @else 
                                             <span class="text-info">$ 0.00 {{$workPlan->moneda}}</span>
                                             @endif
                                          </div>
                                         </div>

                                         <div class="row">
                                          <div class="col-sm-6 text-right">
                                           Capacitación:
                                        </div>
                                          <div class="col-sm-6">
                                              @if(!empty($PenalitationCourse))
                                            <span class="text-info">$ {{ number_format($PenalitationCourse,2) }} {{$workPlan->moneda}}</span>
                                            @else 
                                            <span class="text-info">$ 0.00 {{$workPlan->moneda}}</span>
                                            @endif
                                          </div>
                                         </div>
                                         <div class="row">
                                            <div class="col-sm-6 text-right">
                                                <b style="font-weight:bold"> Total penalizaci&oacute;n: </b>
                                            </div>
                                            <div class="col-sm-6">
                                                @if(isset($salary["penalityBase"]) && isset($salary["penalityTecho"]))
                                                <span class="text-danger">$ {{ number_format(($salary["penalityBase"] + $salary["penalityTecho"] + $PenalitationCourse)  ,2) }} {{$workPlan->moneda}}</span>
                                                @else 
                                                <span class="text-info">$ 0.00 {{$workPlan->moneda}}</span>
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
                                            <span class="text-success">$ {{ number_format($salary["comition"] / $workPlan->typeChange,2) }} {{$workPlan->moneda}}</span>
                                        </div>
                                      </div>

                                    </div>
                                    <div class="ag-bonos">
                                        <?php
                                        $penalityBase = 0;
                                        if(isset($salary["penalityBase"])){
                                            $penalityBase = $salary["penalityBase"];
                                        }
                                        
                                        $penalityTecho = 0;
                                        if(isset($salary["penalityTecho"])){
                                            $penalityTecho = $salary["penalityTecho"];
                                        }
                                        
                                        if(empty($PenalitationCourse)){
                                            $PenalitationCourse = 0;
                                        }
                                        
                                        ?>
                                        <h4 class="card-title mt-0">Salario Total: <strong> $ {{ number_format( $salary["montReal"] + ((( + $salary["totalBonusBase"] + $salary["totalBonusRecord"] + ($salary["totalBonusTecho"] + $salary["comition"] ) ) - ($penalityBase + $penalityTecho + $PenalitationCourse)) / $workPlan->typeChange) ,2)}} {{$workPlan->moneda}}</strong></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- / Column -->
                    <!-- Column -->
              
                    
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
                                                                            @if($arrayWorkPlan[$pkWorkplan]["callSystem"] > $arrayWorkPlan[$pkWorkplan]["qtyHourMonth"])
                                                                            <h1 class="font-light text-danger">0 <span class="text-muted"> Faltantes</span></h1>
                                                                            @else 
                                                                            <h1 class="font-light text-danger">{{ $arrayWorkPlan[$pkWorkplan]["qtyHourMonth"] - $arrayWorkPlan[$pkWorkplan]["callSystem"] }} <span class="text-muted"> Faltantes</span></h1>
                                                                            @endif
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
                                                                            @if( $arrayWorkPlan[$pkWorkplan]["callRegister"] > $arrayWorkPlan[$pkWorkplan]["qtyHourMonth"])
                                                                            <h1 class="font-light text-danger">0 <span class="text-muted"> Faltantes</span></h1>
                                                                            @else 
                                                                            <h1 class="font-light text-danger">{{ $arrayWorkPlan[$pkWorkplan]["qtyHourMonth"] -$arrayWorkPlan[$pkWorkplan]["callRegister"] }}<span class="text-muted"> Faltantes</span></h1>
                                                                            @endif
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
                                                            $ <span>{{ number_format($salary["totalBonusBase"],2) }} {{$workPlan->moneda}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                           Penalización:
                                                        </div>
                                                        <div class="col-sm-6 text-danger">
                                                            $ <span>{{ number_format($salary["penalityBase"],2) }} {{$workPlan->moneda}}</span>
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
                                                            $ <span>{{ number_format($salary["totalBonusRecord"],2) }} {{$workPlan->moneda}}</span>
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
                                                           <span> Una venta por volumen </span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                            Mis ventas Actuales por volumen:
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
                                                            $ <span>{{ number_format($salary["totalBonusTecho"],2) }} {{$workPlan->moneda}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row ag-llamadas">
                                                        <div class="col-sm-6">
                                                           Penalización:
                                                        </div>
                                                        <div class="col-sm-6 text-danger">
                                                            $ <span>{{ number_format($salary["penalityTecho"],2) }} {{$workPlan->moneda}}</span>
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
                                                        <td>Penalizado</td>
                                                        @endif
                                                        <td>{{$item->penality}} </td>
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