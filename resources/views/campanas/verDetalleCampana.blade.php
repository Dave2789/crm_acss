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
                        <h4 class="text-themecolor">Campaña <i>{!! $campaningName->name !!}</i></h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Campañas</li>
                                <li class="breadcrumb-item active">Campaña <i>{!! $campaningName->name !!}</i></li>
                            </ol>
                            <a href="/commercialCampaignsView" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-arrow-left"></i> Regresar</a>
                        </div>
                    </div>
                </div>

                <!-- Empresa -->
                <div class="row">
                    <div class="col-12">
                        <!-- Crear Empresa -->
                        <div class="card">
                            <form id="">
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row pt-3 datos-e">
                                            <div class="col-12">
                                                <h4>Información de la campaña</h4>
                                                <hr>
                                            </div>
                                           @foreach($campaignsQuery as $campaignsInfo)
                                           <div class="col-md-6 dat1">
                                                    <label class="control-label">Nombre de la Campaña:</label>
                                                    <p class="form-control-static">{{html_entity_decode($campaignsInfo->name)}}</p>
                                            </div>
                                            <div class="col-md-6 dat1">
                                                    <label class="control-label">Código de la Campaña:</label>
                                                    <p class="form-control-static">{{$campaignsInfo->code}}</p>
                                            </div>
                                            <div class="col-md-6 dat1">
                                                    <label class="control-label">Agente Encargado:</label>
                                                    <p class="form-control-static">{{html_entity_decode($campaignsInfo->full_name)}} ({{html_entity_decode($campaignsInfo->type_user_name)}})</p>
                                            </div>
                                            <div class="col-md-6 dat1">
                                                    <label class="control-label">Fecha de Inicio:</label>
                                                    <p class="form-control-static">{{$campaignsInfo->start_date}}</p>
                                            </div>
                                            <div class="col-md-6 dat1">
                                                    <label class="control-label">Fecha Final:</label>
                                                    <p class="form-control-static">{{$campaignsInfo->end_date}}</p>
                                            </div>
                                           <div class="col-md-6 dat1">
                                                    <label class="control-label">Fecha de Registro:</label>
                                                    <p class="form-control-static">{{$campaignsInfo->register_date}}</p>
                                            </div>
                                            <div class="col-md-6 dat1">
                                                    <label class="control-label">Fecha En Que Finalizó:</label>
                                                    <p class="form-control-static">{{$campaignsInfo->final_date}}</p>
                                            </div>
                                            <div class="col-md-6 dat1">
                                                    <label class="control-label">Tipo:</label>
                                                    <p class="form-control-static">{!!$campaignsInfo->type_name!!}</p>
                                            </div>
                                            <div class="col-md-6 dat1">
                                                    <label class="control-label">Descripción:</label>
                                                    <p class="form-control-static">{{html_entity_decode($campaignsInfo->description)}}</p>
                                            </div>
                                           @endforeach
                                            
                                            <div class="col-md-6 dat1">
                                                    <label class="control-label">Agentes:</label>
                                                    <ul class="form-control-static">
                                                        @foreach($agentsQuery as $agentsInfo)
                                                        <li>{{html_entity_decode($agentsInfo->full_name)}} ({{html_entity_decode($agentsInfo->type_user_name)}})</li>
                                                        @endforeach
                                                    </ul>
                                            </div>
                                            <div class="col-12">
                                                <h4>Empresas</h4>
                                                <hr>
                                                <div class="table-responsive m-t-20">
                                            <table id="activeEmp" class="table display table-bordered table-striped no-wrap">
                                                <thead>
                                                    <tr>
                                                        <th>Empresa</th>
                                                        <th>Contacto</th>
                                                        <th>Origen</th>
                                                        <th>Categoría</th>
                                                        <th>Giro</th>
                                                        <th>Estatus</th>
                                                        <th>Ventas</th>
                                                        <th>Cotizaciones</th>
                                                        <th>Oportunidades<br>de Negocio</th>
                                                        <th>Fecha de <br>último contacto</th>
                                                        <!--<th>Siguiente actividad</th>
                                                        <th>Fecha de vencimiento<br>siguiente actividad</th>-->
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($bussines as $item)
                                                    <tr>
                                                        <td>
                                                            <a href="/detEmpresa/{{$item->pkBusiness}}">{!! $item->name !!}</a>
                                                        </td>
                                                         <td>
                                                             @if(!empty($item->nameContact))
                                                            <div>{!!$item->nameContact!!}<br>
                                                                <small><span class="ti-email"></span>{{$item->mailContact}}</small><br>
                                                                @if(!empty($item->phoneContact))
                                                                <small><span class="ti-headphone"></span> {{$item->phoneContact}}</small>
                                                                @endif
                                                                 @if(!empty($item->mobile_phone))
                                                                <small><span class="ti-mobile"></span> {{$item->mobile_phone}}</small>
                                                                 @endif
                                                                   <small><a href="#" class="viewBussinesContact" data-id="{{$item->pkBusiness}}"><span class="ti-user"></span> Ver todos</a></small>
                                                            </div>
                                                             @else
                                                              <div>
                                                               N/A<br>
                                                                 <small><a href="#" class="viewBussinesContact" data-id="{{$item->pkBusiness}}"><span class="ti-user"></span> Agregar</a></small>
                                                              </div>
                                                             @endif
                                                        </td>
                                                         <td>
                                                          {{ html_entity_decode($item->fKOrigin) }}
                                                        </td>
                                                         <td>
                                                          {{ html_entity_decode($item->category) }}
                                                        </td>
                                                          <td>
                                                          {{ html_entity_decode($item->giro) }}
                                                        </td>
                                                          <td>
                                                         @if(($item->stateType == Null) || ($item->stateType == 3))
                                                         <span class="label label-danger">Prospectos</span>
                                                         @endif
                                                          @if(($item->stateType == 4) || ($item->stateType == 6))
                                                         <span class="label label-warning">Lead</span>
                                                         @endif
                                                          @if($item->stateType == 9)
                                                         <span class="label label-success">Cliente</span>
                                                         @endif
                                                        </td>
                                                          <td>
                                                           <span class="label label-success">{{ $item->salesPay }} </span> 
                                                           <span class="label label-danger"> {{ $item->salesLoss }}</span> </td>
                                                            <td>    
                                                 
                                                        <span class="label label-info"> {{ $item->quotations }}</span></td>
                                            <td>  
                                                <span class="label label-success">{{ $item->oportunityAproved }}</span>
                                               <span class="label label-info"> {{ $item->oportunityOpen }}</span>
                                                 <span class="label label-danger"> {{ $item->oportunityLoss }}</span>
                                              </td>
                                                           <td>
                                                     @if(!empty($item->lastActivity))
                                                     <span> {!!$item->lastActivity!!} </span>
                                                     @else
                                                      <span>-</span>
                                                     @endif
                                                 </td>
                                                  <!--<td>
                                                       @if(!empty($item->nextActivity))
                                                     <span>   {!!$item->nextActivity!!} </span>
                                                     @else
                                                      <span>-</span>
                                                     @endif
                                               
                                                </td>
                                                 <td>
                                                       @if(!empty($item->finalActivity))
                                                     <span>{!!$item->finalActivity!!} </span>
                                                     @else
                                                      <span>-</span>
                                                     @endif
                                                 
                                                </td>-->
                                                          <td>
                                                            <button class="btn btn-danger btn-sm btn_deleteBussinesOfCampaign" data-id="{{$item->pkBusiness}}" data-campaign-id="{{$campaign}}"><span class="ti-close"></span></button>   
                                                          </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                            </div>
                                        </div><!--/row-->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>

                <!-- End Page Content -->

            </div><!-- End Container fluid  -->
        </div><!-- End Page wrapper  -->

        @include('includes.footer')
        <!-- End footer -->
    </div><!-- End Wrapper -->
 <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditCategoria" class="modalEditCategoria"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditCategoria" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalEditCat" role="document">
       
      </div>
    </div>

    @include('includes.scripts')
<script>
    $(function () {
            $('#detCampanaEmpresas').DataTable({
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