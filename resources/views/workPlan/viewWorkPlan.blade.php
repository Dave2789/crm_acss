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
                        <h4 class="text-themecolor">Plan de trabajo</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Plan de trabajo</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Tablas -->
                <div class="row">
                    <div class="col-12">
     
                        <!-- Campañas -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Plan de trabajo</h4>
                                 <div class="row">  
                               
                                 </div>
                                <div class="table-responsive m-t-40" id="cotizacionesDiv">
                                    <table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Agente</th>
                                                <th>Llamadas<br>por hora</th>
                                                <th>Llamadas<br>por mes</th>
                                                <th>Llamadas<br>para hoy</th>
                                                <th>Llamadas<br>Enlazadas %</th>
                                                <th>Llamadas<br>Fallidas %</th>
                                                <th>Penalizaci&oacute;n %</th>
                                                <th>Monto base</th>
                                                <th>Tipo<br>de cambio</th>
                                                <th>Moneda</th>
                                                <th>Horario<br>laboral</th>
                                                <th>Permisos</th>
                                                <th>Total a pagar</th>
                                                <th>Ver detalle</th>
                                                <th>Eliminar Llamadas</th>
                                                <th>Editar</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                                @foreach($workPlan as $workInfo)
                                                 <tr>
                                                <td>{!!$workInfo["date"] !!} </td>
                                                <td><a href="/viewWorkinAgent/{!!$workInfo['fkUser']!!}/{!!$workInfo["month"]!!}/{!!$workInfo["year"]!!}">{!!$workInfo["agent"] !!}</a></td>
                                                <td class="text-center">{!!$workInfo["qtyCallsHour"] !!}</td>
                                                <td class="text-center">{!!$workInfo["qtyHourMonth"] !!}</td>
                                                <td class="text-center">{!!$workInfo["qtyCallsToday"] !!}</td>
                                                <td class="text-center">{!!$workInfo["callsLinked"] !!} %</td>
                                                <td class="text-center">{!!$workInfo["callsFaild"] !!} % </td>
                                                <td class="text-center">{!!$workInfo["penalty"] !!} %</td>
                                                <td>$ {!!number_format($workInfo["montBase"],2) !!}</td>
                                                <td>$ {!!number_format($workInfo["typeChange"],2) !!}</td>
                                                <td>{!!$workInfo["moneda"] !!}</td>
                                                <td class="viewDaysWorking text-center" data-id="{!!$workInfo['pkWorkplan'] !!}" style="cursor: pointer">
                                                    <span class="ti-time"></span>
                                                </td>
                                                 <td class="viewPermitionDay text-center" data-id="{!!$workInfo['pkWorkplan'] !!}" style="cursor: pointer">
                                                   <span class="ti-clipboard"> </span>
                                                </td>
                                                
                                                <?php
                                                $penalityBase = 0;
                                                if(isset($workInfo["salary"]["penalityBase"])){
                                                    $penalityBase = $workInfo["salary"]["penalityBase"];
                                                }

                                                $penalityTecho = 0;
                                                if(isset($workInfo["salary"]["penalityTecho"])){
                                                    $penalityTecho = $workInfo["salary"]["penalityTecho"];
                                                }

                                                if(empty($workInfo["PenalitationCourse"])){
                                                    $workInfo["PenalitationCourse"] = 0;
                                                }

                                                ?>
                                                
                                                
                                                <td>$ {!! number_format($workInfo["salary"]["montReal"] + ( (($workInfo["salary"]["totalBonusBase"] + $workInfo["salary"]["totalBonusRecord"] + ($workInfo["salary"]["totalBonusTecho"] + $workInfo["salary"]["comition"]) ) - ($penalityBase + $penalityTecho + $workInfo["PenalitationCourse"])) / $workInfo["typeChange"] ),2) !!}</td>
                                              
                                                
                                                
                                                
                                                
                                                <td> <a href="viewWorkinAgent/{!!$workInfo['fkUser']!!}/{!!$workInfo["month"]!!}/{!!$workInfo["year"]!!}" <span class="ti-eye"> </span></a></td>
                                                <td> <a href="#" class="deleteCalls"  data-id="{!! $workInfo['pkWorkplan']!!}"> <span class="ti-trash"> </span></a></td>
                                                <td class="text-center updateWorkinPlan" data-id="{!!$workInfo['pkWorkplan'] !!}" style="cursor: pointer">
                                                    <span class="ti-pencil"></span>
                                                 </td>
                                                 <td class="text-center">
                                                    <button class="btn btn-danger btn-sm btn_workinPlan" data-id="{!! $workInfo['pkWorkplan']!!}"><span class="ti-close"></span></button> 
                                                 </td>
                                                 </tr>
                                                @endforeach
                                           
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
    
     <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditUsuario" class="modalEditUsuario"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditUsuario" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalUsuario" role="document">
       
      </div>
    </div>


    @include('includes.scripts')
    <script>
        $(function () {
            $('#cotizaciones').DataTable({
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