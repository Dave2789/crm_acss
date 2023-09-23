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
                                <center class="m-t-30"> <img src="/images/usuarios/{{$agentInfo->image}}" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10">{!! $agentInfo->full_name !!}</h4>
                                    <h6 class="card-subtitle">{{ $agentInfo->type }}</h6>
                                     <h6 class="card-subtitle">{{ $agentInfo->mail }}</h6>
                                      <h6 class="card-subtitle">{{ $agentInfo->phone_extension }}</h6>
                                    <div class="text-left">
                                        <a href="javascript:void(0)" class="link"><i class="ti-stats-up"></i> {{ $agentInfo->type }}
                                            <span class="f-right">
                                                <font class="font-medium text-success">{{ $agentInfo->salesPay }} </font>
                                                <font class="font-medium text-danger"> {{ $agentInfo->salesLoss }}</font>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="text-left">
                                        <a href="javascript:void(0)" class="link"><i class="ti-write"></i> Cotizaciones 
                                            <span class="f-right">
                                              
                                                <font class="font-medium text-info"> {{ $agentInfo->quotations }}</font>
                                               
                                            </span>
                                        </a>
                                    </div>
                                    <div class="text-left">
                                        <a href="javascript:void(0)" class="link"><i class="ti-light-bulb"></i> Oportunidades de negocio 
                                            <span class="f-right">
                                                <font class="font-medium text-success">{{ $agentInfo->oportunityAproved }} </font>
                                                <font class="font-medium text-info"> {{ $agentInfo->oportunityOpen }}</font>
                                                <font class="font-medium text-danger"> {{ $agentInfo->oportunityLoss }}</font>
                                            </span>
                                        </a>
                                    </div>
                                </center>
                            </div>

                    </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-9 col-md-7" style="max-height: 350px; overflow-y: scroll;">
                        <div class="card">
                         <div class="card-body">
                                <h5 class="card-title">Actividades pendientes</h5>
                                    <div class="steamline m-t-40">
                                    @foreach($activitiesQuery as $activitiesInfo)
                                    <div class="sl-item">
                                        <div class="sl-left bg-info" style="background-color: {{$activitiesInfo->color}}!important;"> <i class="{{$activitiesInfo->icon}}"></i></div>
                                        <div class="sl-right">
                                            <div class="font-medium">
                                                <a href="#" class="a-black">{{html_entity_decode($activitiesInfo->text)}} </a> <!-- CLIC PERMITE FINALIZAR LA ACTIVIDAD -->
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
                                               
                                                @if($dateNow == $date)
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
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                               </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-xlg-9 col-md-7" style="max-height: 350px; overflow-y: scroll;">
                           <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Últimas acciones registradas</h5>
                                 <div class="message-box">
                                <div class="message-widget message-scroll">
                                    <!-- Message -->
                                    @foreach($lastActivitiesQuery as $lastActivitiesInfo)
                                    <a href="javascript:void(0)">
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

                    <!-- Column -->
                    <div class="col-lg-12">
                              <div class="card">
                            <div>
                               
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
                                        @foreach($usersActivities as $item)
                                        @if($item->salesPay != 0 ||  $item->salesLoss != 0 ||  $item->quotations != 0 ||
                                        $item->oportunityAproved != 0 || $item->oportunityLoss != 0 ||  $item->oportunityOpen != 0)
                                        <tr>
                                            <td><a href="/detEmpresa/{{$item->pkBusiness}}"> {!!$item->name!!} </a></td>
                                            <td><a href="#modalVentasAgente" data-toggle="modal" data-target="#modalVentasAgente">
                                                  
                                             <a href="#" class="viewAprovedQuotation" data-id="{{$item->pkBusiness}}" data-user="{{$pkUser}}"> <span class="label label-success">{{ $agentInfo->salesPay }} </span> </a>
                                             <a href="#" class="viewLossQuotation" data-id="{{$item->pkBusiness}}" data-user="{{$pkUser}}"> <span class="label label-danger"> {{ $agentInfo->salesLoss }}</span> </a>
                                                   
                                                </a></td>
                                            <td><a href="#modalCotizacionesAgente" data-toggle="modal" data-target="#modalCotizacionesAgente">
                                                   
                                                    <a href="#" class="viewOpenQuotation" data-id="{{$item->pkBusiness}}" data-user="{{$pkUser}}">  
                                                        <span class="label label-info"> {{ $agentInfo->quotations }}</span>
                                                    </a>
                                                   
                                                </a></td>
                                            <td>  
                                                <a href="#" class="viewAprovedOportunity" data-id="{{$item->pkBusiness}}" data-user="{{$pkUser}}">  <span class="label label-success">{{ $agentInfo->oportunityAproved }}</span></a> 
                                                <a href="#" class="viewOpenOportunity" data-id="{{$item->pkBusiness}}" data-user="{{$pkUser}}">  <span class="label label-info"> {{ $agentInfo->oportunityOpen }}</span></a> 
                                                <a href="#" class="viewLossOportunity" data-id="{{$item->pkBusiness}}" data-user="{{$pkUser}}">  <span class="label label-danger"> {{ $agentInfo->oportunityLoss }}</span></a> 
                                              </td>
                                            <td>
                                                @if(!empty($item->salesPlaces))
                                                {{ $item->salesPlaces}}
                                                @else
                                                <span>0</span>
                                                @endif
                                            </td>
                                            <td>
                                              @if(!empty($item->salesMont))
                                               <span class="text-success">$ {{ $item->salesMont}}</span>
                                                @else
                                               <span class="text-success">$ 0</span>
                                                @endif
                                             </td>
                                        </tr>
                                        @endif
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
    </script>
</body>
</html>