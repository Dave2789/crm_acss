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
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Bread crumb and right sidebar toggle -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Dashboard</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <h3 class="m-b-0" style="margin-right:20px;"><i class="ti-world text-cyan"></i> {!!$numVisit!!} <small style="font-weight:300;">Entradas</small></h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                            <!--button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button-->
                        </div>
                    </div>
                </div>
                <!-- End Bread crumb and right sidebar toggle -->
    @if($arrayPermition["dashboard"] == 1)
                <div class="card">
                    
                    <!--div class="col-md-3">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-cyan">
                                    <h3 class="text-white box m-b-0"><i class="ti-world"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-cyan">{!!$numVisit!!}</h3>
                                    <h5 class="text-muted m-b-0">Entradas</h5>
                                </div>
                            </div>
                        </div>
                    </div-->
                    <!-- Filtros -->
                    
           
                    <div class="row filtros-sm">
                        <div class="col-md-12">
                            <div class="btn-time">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                  <label class="btn btn-secondary searchInfo" data-id="1">
                                      <input type="radio" name="searchInfor" id="option1" class="searchInfor" value="1" autocomplete="off"> Día
                                  </label>
                                  <label class="btn btn-secondary searchInfo active" data-id="2">
                                      <input type="radio" name="searchInfor" id="option2" class="searchInfor" value="2" autocomplete="off" checked> Mes
                                  </label>
                                  <label class="btn btn-secondary searchInfo" data-id="3">
                                      <input type="radio" name="searchInfor" id="option3" class="searchInfor" value="3" autocomplete="off"> Año
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <div class="card-body">
                                <h4 class="card-title">Usuario</h4>
                                <div class=" row">
                                    <select id="pkUser" class="custom-select form-control input-sm m-b-10">
                                        <option value="-1">Todos</option>
                                        @foreach($users as $userInfo)
                                        <option value="{!! $userInfo->pkUser !!}">{!!$userInfo->full_name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="exampleSorting"></div>
                            </div>
                        </div><!-- Usuario -->
                        <div class="col-md-2 col-6 card">
                            <div class="card-body">
                                <h4 class="card-title">Giro</h4>
                                <div class=" row">
                                    <select id="pkGiro" class="custom-select form-control input-sm m-b-10">
                                        <option value="-1">Todos</option>
                                       @foreach($giros as $giroInfo)
                                        <option value="{!! $giroInfo->pkCommercial_business !!}">{!!$giroInfo->name!!}</option>
                                       @endforeach
                                    </select>
                                </div>
                                <div id="exampleSorting"></div>
                            </div>
                        </div><!-- Giro -->
                        <div class="col-md-2 col-6 card">
                            <div class="card-body">
                                <h4 class="card-title">Campaña</h4>
                                <div class=" row">
                                    <select id="pkCampanin" class="custom-select form-control input-sm m-b-10">
                                        <option value="-1">Todas</option>
                                        @foreach($campanias as $campaniaInfo)
                                        <option value="{!! $campaniaInfo->pkCommercial_campaigns !!}">{!!$campaniaInfo->name !!}</option>
                                       @endforeach
                                    </select>
                                </div>
                                <div id="exampleSorting"></div>
                            </div>
                        </div><!-- Campaña -->
                        <div class="col-md-4 col-12 card">
                            <div class="card-body">
                                <h4 class="card-title">Fechas</h4>
                                <div class="form-row">
                                    <div class="col-6">
                                      <input type="date" id="startDay" class="form-control">
                                    </div>
                                    <div class="col-6">
                                      <input type="date" id="finishDay" class="form-control">
                                    </div>
                                  </div>
                            </div>
                        </div><!-- Fechas -->
                        <div class="col-md-2 mt-sm-5 mb-3 mb-sm-0 text-right text-sm-left"> 
                            <button type="button" class="dt-button buttons-excel buttons-html5 btn btn-primary mr-1" id="search_dashboard">Buscar</button>
                        </div>
                    </div>
                    <!-- Datos -->
                    <div class="row" id="infoChange">
                        <div class="col-lg-6 col-sm-12 cuadros">
                            <!-- Ventas -->
                            <h3 class="title-section">Ventas</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3>{!!$sales["total"]!!}  <span class="text-success f-right">$ {!!number_format($sales["mount"],2)!!}</span></h3>
                                                    <h6 class="card-subtitle">Realizadas</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cotizaciones -->
                            <h3 class="title-section">Cotizaciones <span class="text-right f-right"></span></h3>
                            <div class="card-group">
                                <div class="card">
                                    <!--<a href="/cotizacionesCerradas">-->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div>
                                                        <h3>{!!$quotationsClose["total"]!!} <span class="small">{!!round($quotationsClose["percent"],2)!!}%</span></h3>
                                                        <h6 class="card-subtitle">Pagadas</h6>
                                                        <h3 class="text-success mb-0">$ {!!number_format($quotationsClose["mount"],2)!!}</h3>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: {!! round($quotationsClose['percent'],2)!!}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!--</a>-->
                                </div>
                                <div class="card">
                                    <!--<a href="/cotizacionesAbiertas">-->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div>
                                                        <h3>{!!$quotationsOpen["total"]!!} <span class="small">{!!round($quotationsOpen["percent"],2)!!}%</span></h3>
                                                        <h6 class="card-subtitle">Abiertas</h6>
                                                        <h3 class="text-cyan mb-0">$ {!!number_format($quotationsOpen["mount"],2)!!}</h3>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-cyan" role="progressbar" style="width: {!!round($quotationsOpen['percent'],2)!!}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!--</a>-->
                                </div>
                                <div class="card">
                                    <!--<a href="/cotizacionesDescartadas">-->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div>
                                                        <h3>{!!$quotationsRejected["total"]!!} <span class="small">{!!round($quotationsRejected["percent"],2)!!}%</span></h3>
                                                        <h6 class="card-subtitle">Descartadas</h6>
                                                        <h3 class="text-danger mb-0">$ {!!number_format($quotationsRejected["mount"],2)!!}</h3>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {!!  round($quotationsRejected['percent'],2)!!}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!--</a>-->
                                </div>
                            </div>
                            <!-- Oportunidades -->
                            <h3 class="title-section">Oportunidades</h3>
                            <div class="card-group">
                                <div class="card">
                                    <!--<a href="/oportunidadesConvertidas">-->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3>{!!$opportunitiesClose["total"]!!} <span class="small">{!!round($opportunitiesClose["percent"],2)!!}%</span></h3>
                                                    <h6 class="card-subtitle">Convertidas a cotización</h6>
                                                    <h3 class="text-success mb-0">$ {!!number_format($opportunitiesClose["mount"],2)!!}</h3>
                                                </div>
                                                <div class="col-12">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: {!! round($opportunitiesClose['percent'],2)!!}%;height:6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!--</a>-->
                                </div>
                                <div class="card">
                                    <!--<a href="/oportunidadesAbiertas">-->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3>{!!$opportunitiesOpen["total"]!!} <span class="small">{!!round($opportunitiesOpen["percent"],2)!!}%</span></h3>
                                                    <h6 class="card-subtitle">Abiertas</h6>
                                                    <h3 class="text-cyan mb-0">$ {!!number_format($opportunitiesOpen["mount"],2)!!}</h3>
                                                </div>
                                                <div class="col-12">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-cyan" role="progressbar" style="width: {!! round($opportunitiesOpen['percent'],2) !!}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!--</a>-->
                                </div>
                                <div class="card">
                                    <!--<a href="/oportunidadesPerdidas">-->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3>{!!$opportunitiesRejected["total"]!!} <span class="small">{!!round($opportunitiesRejected["percent"],2)!!}%</span></h3>
                                                    <h6 class="card-subtitle">Perdidas</h6>
                                                    <h3 class="text-danger mb-0">$ {!!number_format($opportunitiesRejected["mount"],2)!!}</h3>
                                                </div>
                                                <div class="col-12">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {!!round($opportunitiesRejected['percent'],2) !!}%; height: 6px;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!--</a>-->
                                </div>
                            </div>
                        </div>
                        <!-- Empresas -->
                        <div class="col-lg-6 col-sm-12 empresas-dash">
                            <h3 class="title-section">Empresas</h3>
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="text-info"><i class="ti-layout-menu-v"></i> Nivel de interés en cotizaciones</h3>
                                            <hr>
                                            @foreach($levelInterestQuery as $levelInterestInfo)
                                                <!--<a href="#">-->
                                                    <div class="d-flex no-block align-items-center">
                                                        <p class="text-muted">{!!$levelInterestInfo->text!!}</p>
                                                        <div class="ml-auto">
                                                            <h2 class="counter badge badge-pill text-white" style="background-color:{!!$levelInterestInfo->color !!}">
                                                                @if(isset($arrayLevelInterest[$levelInterestInfo->pkLevel_interest]))
                                                                    {!!$arrayLevelInterest[$levelInterestInfo->pkLevel_interest]!!}
                                                                @else
                                                                0
                                                                @endif
                                                            </h2>
                                                        </div>
                                                    </div>
                                                <!--</a>-->
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="text-purple"><i class="ti-layers"></i> Categorías</h3>
                                            <hr>
                                            @foreach($categoriesQuery as $categoriesInfo)
                                                <!--<a href="/empresasTipo/{!! $categoriesInfo->pkCategory !!}">-->
                                                    <div class="d-flex no-block align-items-center">
                                                        <p class="text-muted">{!!$categoriesInfo->name!!}</p>
                                                        <div class="ml-auto">
                                                            <h2 class="counter text-purple">
                                                                @if(isset($arrayCategories[$categoriesInfo->pkCategory]))
                                                                    {!!$arrayCategories[$categoriesInfo->pkCategory]!!}
                                                                @else
                                                                0
                                                                @endif
                                                            </h2>
                                                        </div>
                                                    </div>
                                                <!--</a>-->
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="text-cyan"><i class="ti-money"></i> Forma de Pago</h3>
                                            <hr>
                                            @foreach($paymentMethodsQuery as $paymentMethodsInfo)
                                                <!--<a href="#">-->
                                                    <div class="d-flex no-block align-items-center">
                                                        <p class="text-muted">{!!$paymentMethodsInfo->name!!}</p>
                                                        <div class="ml-auto">
                                                            <h2 class="counter text-cyan">
                                                                @if(isset($arrayPaymentMethods[$paymentMethodsInfo->pkPayment_methods]))
                                                                    {!!$arrayPaymentMethods[$paymentMethodsInfo->pkPayment_methods]!!}
                                                                @else
                                                                0
                                                                @endif
                                                            </h2>
                                                        </div>
                                                    </div>
                                                <!--</a>-->
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="text-primary"><i class="ti-layout-menu-v"></i> Estatus</h3>
                                            <hr>
                                            <a href="/verEmpresasProspecto">
                                                <div class="d-flex no-block align-items-center">
                                                    <p class="text-muted">Prospectos</p>
                                                    <div class="ml-auto">
                                                        <h2 class="counter badge badge-warning badge-pill">
                                                            @if(isset($typeCountBusiness["prospect"]))
                                                                {!!$typeCountBusiness["prospect"]!!}
                                                            @else
                                                            0
                                                            @endif
                                                        </h2>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="/verEmpresasLeads">
                                                <div class="d-flex no-block align-items-center">
                                                    <p class="text-muted">Leads</p>
                                                    <div class="ml-auto">
                                                        <h2 class="counter badge badge-info badge-pill">
                                                            @if(isset($typeCountBusiness["lead"]))
                                                                {!!$typeCountBusiness["lead"]!!}
                                                            @else
                                                            0
                                                            @endif
                                                        </h2>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="/verEmpresasCliente">
                                                <div class="d-flex no-block align-items-center">
                                                    <p class="text-muted">Clientes</p>
                                                    <div class="ml-auto">
                                                        <h2 class="counter badge badge-success badge-pill">
                                                            @if(isset($typeCountBusiness["client"]))
                                                                {!!$typeCountBusiness["client"]!!}
                                                            @else
                                                            0
                                                            @endif
                                                        </h2>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="nav-small-cap">--- GRÁFICAS</div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ventas</h4>
                                <div class="ct-bar-chart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Cotizaciones</h4>
                                <ul class="list-inline text-right">
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5 text-success"></i>Cerradas</h5>
                                    </li>
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5 text-info"></i>Abiertas</h5>
                                    </li>
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5 text-danger"></i>Descartadas</h5>
                                    </li>
                                </ul>
                                <div id="quotationsBar"></div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Oportunidades de negocio</h4>
                                <ul class="list-inline text-right">
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5 text-success"></i>Convertidas a cotización</h5>
                                    </li>
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5 text-info"></i>Abiertas</h5>
                                    </li>
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5 text-danger"></i>Descartadas</h5>
                                    </li>
                                </ul>
                                <div id="opportunitiesBar"></div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <h3 class="title-section">Cursos</h3>
                    </div>
                    <div class="col-sm-7">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-flag-alt"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h5 class="text-muted m-b-0">Total de cursos registrados en el sistema</h5>
                                    <h3 class="m-b-0 text-info">{!! $numCurse !!}</h3>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Cursos y Lugares</h4>
                                <div id="bar-chart" style="width:100%; height:400px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Lugares m&aacute;s vendidos por curso</h5>
                            </div>
                             <div style="padding: 10px;" class="btn-group btn-group-toggle" data-toggle="buttons">
                                 <!-- FALTA Y NO SE DEBEN DAR NOMBRES NI IDENTIFICADORES QUE NO SEAN PROPIOS DE LA SECCION -->
                              <label class="btn btn-secondary optionsPlaces" data-id="1">
                                  <input type="radio" name="optionsPlaces" id="option1" value="1" autocomplete="off" > Día
                              </label>
                              <label class="btn btn-secondary optionsPlaces active" data-id="2">
                                <input type="radio" name="optionsPlaces" id="option2" value="2" autocomplete="off"> Mes
                              </label>
                              <label class="btn btn-secondary optionsPlaces" data-id="3">
                                <input type="radio" name="optionsPlaces" id="option3" value="3" autocomplete="off"> Año
                              </label>
                            </div>
                            
                            <div class="table-responsive" id="cousemore">
                                <div class="text-right" style="padding: 10px;">
                                    <h4>Total de lugares vendidos: {!! $totalCourse !!}</h4>
                                </div>
                                <table class="table table-hover no-wrap" id="mas-vendidos">
                                    <thead>
                                        <tr>
                                            <th>Curso</th>
                                            <th>Lugares</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($courseMore as $courseMoreInfo)
                                        <tr>
  
                                            <td class="txt-oflo br-txt">{!! $courseMoreInfo->name !!}</td>
                                            <td><span class="text-success">{!! $courseMoreInfo->places !!}</span></td>
                                          
                                        </tr>
                                       @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
                </div>
                <!-- End Page Content -->
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
            </div><!-- End Container fluid  -->
        </div><!-- End Page wrapper  -->

        @include('includes.footer')
        <!-- End footer -->
    </div><!-- End Wrapper -->

    @include('includes.scripts')
    <!-- End scripts  -->
    <script type="text/javascript">
        $(function() {

            Morris.Bar({
                element: 'quotationsBar',
                data: [
                    {<?php echo $monthValues[0]; ?>},
                    {<?php echo $monthValues[1]; ?>},
                    {<?php echo $monthValues[2]; ?>},
                    {<?php echo $monthValues[3]; ?>},
                    {<?php echo $monthValues[4]; ?>},
                    {<?php echo $monthValues[5]; ?>},
                    {<?php echo $monthValues[6]; ?>},
                    {<?php echo $monthValues[7]; ?>},
                    {<?php echo $monthValues[8]; ?>},
                    {<?php echo $monthValues[9]; ?>},
                    {<?php echo $monthValues[10]; ?>},
                    {<?php echo $monthValues[11]; ?>}
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c'],
                labels: ['Cerrada', 'Abierta', 'Descartadas'],
                barColors:['#55ce63', '#009efb', '#e46a76'],
                hideHover: 'auto',
                gridLineColor: '#eef0f2',
                resize: true
            });
            
            Morris.Bar({
                element: 'opportunitiesBar',
                data: [
                    {<?php echo $monthValuesOport[0]; ?>},
                    {<?php echo $monthValuesOport[1]; ?>},
                    {<?php echo $monthValuesOport[2]; ?>},
                    {<?php echo $monthValuesOport[3]; ?>},
                    {<?php echo $monthValuesOport[4]; ?>},
                    {<?php echo $monthValuesOport[5]; ?>},
                    {<?php echo $monthValuesOport[6]; ?>},
                    {<?php echo $monthValuesOport[7]; ?>},
                    {<?php echo $monthValuesOport[8]; ?>},
                    {<?php echo $monthValuesOport[9]; ?>},
                    {<?php echo $monthValuesOport[10]; ?>},
                    {<?php echo $monthValuesOport[11]; ?>}
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c'],
                labels: ['Cerrada', 'Abierta', 'Descartadas'],
                barColors:['#55ce63', '#009efb', '#e46a76'],
                hideHover: 'auto',
                gridLineColor: '#eef0f2',
                resize: true
            });
    });
    </script>
    <script>
        $(function () {
            $('#mas-vendidos').DataTable({
                dom: 'Bfrtip',
                 "order": [],
                buttons: [
                    'excel'
                ]
            });    
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
        });

    </script>
    
    <script>

        var ene = <?php echo $salesTotal['01']; ?>;
        var feb = <?php echo $salesTotal['02']; ?>;
        var mar = <?php echo $salesTotal['03']; ?>;
        var abr = <?php echo $salesTotal['04']; ?>;
        var may = <?php echo $salesTotal['05']; ?>;
        var jun = <?php echo $salesTotal['06']; ?>;
        var jul = <?php echo $salesTotal['07']; ?>;
        var ago = <?php echo $salesTotal['08']; ?>;
        var sep = <?php echo $salesTotal['09']; ?>;
        var oct = <?php echo $salesTotal['10']; ?>;
        var nov = <?php echo $salesTotal['11']; ?>;
        var dic = <?php echo $salesTotal['12']; ?>;

        var enep = <?php echo $salesTotalRejectArray['01']; ?>;
        var febp = <?php echo $salesTotalRejectArray['02']; ?>;
        var marp = <?php echo $salesTotalRejectArray['03']; ?>;
        var abrp = <?php echo $salesTotalRejectArray['04']; ?>;
        var mayp = <?php echo $salesTotalRejectArray['05']; ?>;
        var junp = <?php echo $salesTotalRejectArray['06']; ?>;
        var julp = <?php echo $salesTotalRejectArray['07']; ?>;
        var agop = <?php echo $salesTotalRejectArray['08']; ?>;
        var sepp = <?php echo $salesTotalRejectArray['09']; ?>;
        var octp = <?php echo $salesTotalRejectArray['10']; ?>;
        var novp = <?php echo $salesTotalRejectArray['11']; ?>;
        var dicp = <?php echo $salesTotalRejectArray['12']; ?>;

        // Bar chart
        var data = {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            series: [
                [
                    { meta: 'Ventas', value: ene },
                    { meta: 'Ventas', value: feb },
                    { meta: 'Ventas', value: mar },
                    { meta: 'Ventas', value: abr },
                    { meta: 'Ventas', value: may },
                    { meta: 'Ventas', value: jun },
                    { meta: 'Ventas', value: jul },
                    { meta: 'Ventas', value: ago },
                    { meta: 'Ventas', value: sep },
                    { meta: 'Ventas', value: oct },
                    { meta: 'Ventas', value: nov },
                    { meta: 'Ventas', value: dic },
                ],
                [
                    { meta: 'Descartados', value: enep },
                    { meta: 'Descartados', value: febp },
                    { meta: 'Descartados', value: marp },
                    { meta: 'Descartados', value: abrp },
                    { meta: 'Descartados', value: mayp },
                    { meta: 'Descartados', value: junp },
                    { meta: 'Descartados', value: julp },
                    { meta: 'Descartados', value: agop },
                    { meta: 'Descartados', value: sepp },
                    { meta: 'Descartados', value: octp },
                    { meta: 'Descartados', value: novp },
                    { meta: 'Descartados', value: dicp },
                ]
            ]
        };

        var customTooltip = function (valor) {
            var val = parseFloat(valor).toFixed(2);
            var ventas = new Intl.NumberFormat('es-MX', { maximumFractionDigits: 2 }).format(val);
            return '$ ' + ventas  + ' MXN';
        };

        var options = {
            seriesBarDistance: 10,
            plugins: [
                Chartist.plugins.tooltip({
                    transformTooltipTextFnc: customTooltip
                })
            ]
        };

        var responsiveOptions = [
            ['screen and (max-width: 640px)', {
                seriesBarDistance: 5,

                axisX: {
                    labelInterpolationFnc: function (value) {
                        return value[0];
                    }
                }
            }]
        ];

        var ventas_graf = new Chartist.Bar('.ct-bar-chart', data, options, responsiveOptions);


    </script>
    
    <script>
        
        
        var coursesEn = <?php echo $places_and_courses['01']['courses']; ?>;
        var coursesFe = <?php echo $places_and_courses['02']['courses']; ?>;
        var coursesMa = <?php echo $places_and_courses['03']['courses']; ?>;
        var coursesAb = <?php echo $places_and_courses['04']['courses']; ?>;
        var coursesM  = <?php echo $places_and_courses['05']['courses']; ?>;
        var coursesJ  = <?php echo $places_and_courses['06']['courses']; ?>;
        var coursesJu = <?php echo $places_and_courses['07']['courses']; ?>;
        var coursesA  = <?php echo $places_and_courses['08']['courses']; ?>;
        var coursesSe = <?php echo $places_and_courses['09']['courses']; ?>;
        var coursesOc = <?php echo $places_and_courses['10']['courses']; ?>;
        var coursesNo = <?php echo $places_and_courses['11']['courses']; ?>;
        var coursesDi = <?php echo $places_and_courses['12']['courses']; ?>;
        
        
        var placesEn = <?php echo $places_and_courses['01']['places']; ?>;
        var placesFe = <?php echo $places_and_courses['02']['places']; ?>;
        var placesMa = <?php echo $places_and_courses['03']['places']; ?>;
        var placesAb = <?php echo $places_and_courses['04']['places']; ?>;
        var placesM  = <?php echo $places_and_courses['05']['places']; ?>;
        var placesJ  = <?php echo $places_and_courses['06']['places']; ?>;
        var placesJu = <?php echo $places_and_courses['07']['places']; ?>;
        var placesA  = <?php echo $places_and_courses['08']['places']; ?>;
        var placesSe = <?php echo $places_and_courses['09']['places']; ?>;
        var placesOc = <?php echo $places_and_courses['10']['places']; ?>;
        var placesNo = <?php echo $places_and_courses['11']['places']; ?>;
        var placesDi = <?php echo $places_and_courses['12']['places']; ?>;
        
        var myChart = echarts.init(document.getElementById('bar-chart'));

// specify chart configuration item and data
option = {
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['Cursos','Lugares']
    },
    toolbox: {
        show : true,
        feature : {
            
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    color: ["#55ce63", "#009efb"],
    calculable : true,
    xAxis : [
        {
            type : 'category',
            data : ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'Cursos',
            type:'bar',
            data:[coursesEn, coursesFe, coursesMa, coursesAb, coursesM, coursesJ, coursesJu, coursesA,coursesSe,coursesOc, coursesNo, coursesDi],
            markPoint : {
                data : [
                    {type : 'max', name: 'Max'},
                    {type : 'min', name: 'Min'}
                ]
            },
            markLine : {
                data : [
                    {type : 'average', name: 'Average'}
                ]
            }
        },
        {
            name:'Lugares',
            type:'bar',
            data:[placesEn, placesFe,placesMa, placesAb, placesM,placesJ, placesJu, placesA, placesSe, placesOc, placesNo, placesDi],
            markPoint : {
                data : [
                    {type : 'max', name: 'Max'},
                    {type : 'min', name: 'Min'}
                ]
            },
            markLine : {
                data : [
                    {type : 'average', name : 'Average'}
                ]
            }
        }
    ]
};


// use configuration item and data specified to show chart
myChart.setOption(option, true), $(function() {
            function resize() {
                setTimeout(function() {
                    myChart.resize()
                }, 100)
            }
            $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
        });

        </script>
</body>

</html>