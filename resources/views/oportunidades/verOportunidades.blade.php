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
                        <h4 class="text-themecolor">Oportunidades de Negocio</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Oportunidades de Negocio</li>
                            </ol>
                         
                        </div>
                    </div>
                </div>
             @if($arrayPermition["view"] == 1)
                <!-- Tablas -->
                <div class="row">
                    <div class="col-12">
                        <!-- Campañas -->
                        <div class="card">
                            <div class="card-body">
                          
                                  
                             <div class="btn-group mb-2">
                                        <a href="#" class="btn btn-sm btn-secondary changeTotal" data-id="-1">Todas</a>
                                        <a href="#" class="btn btn-sm btn-info changeTotal" data-id="1">Abiertas</a>
                                        <a href="#" class="btn btn-sm btn-success changeTotal" data-id="5">Cotizadas</a>
                                        <a href="#" class="btn btn-sm btn-danger changeTotal" data-id="3">Descartadas</a>
                                      </div>
                                <h4 class="card-title">Oportunidades de negocio <span class="f-right text-success" id="totalOportunity">$ {!! number_format($totalMount,2) !!}</span> </h4>
                                   
                                <hr>
                                 <div class="row">  
                                     
                                  <div class="col-6 m-t-30">
                                        <select class="form-control custom-select" id="agent" data-placeholder="Selecciona la Actividad" tabindex="1">
                                            <option value="-1">Agente</option> 
                                            @foreach($agent as $info)
                                            <option value="{!!$info->pkUser !!}">{!!$info->full_name!!}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                     
                                <div class="col-6 m-t-30">
                                        <select class="form-control custom-select" id="status" data-placeholder="Selecciona la Actividad" tabindex="1">
                                            <option value="-1">Estatus</option> 
                                            <option value="1">Abiertas</option>
                                            <option value="3">Canceladas</option>
                                            <option value="2">Rechazadas</option>
                                            <option value="5">Cotizadas</option>
                                        </select>
                                    </div>
                                     

                                    <div class="col-6 mt-3"> 
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
                                    
                                     <div class="col-6 mt-3"> 
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
                                         <button type="button" class="dt-button buttons-excel buttons-html5 btn btn-primary mr-1" id="search_oportunity">Buscar</button>
                                    </div>
                                 </div>
                                <div class="table-responsive m-t-40" id="oporNegDiv">
                                    <table id="oporNeg" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Folio</th>
                                                <th>Empresa</th>
                                                <th>Precio total</th>
                                                <th>Lugares</th>
                                                <th>Estado / País</th>
                                                <th>Nivel de<br>inter&eacute;s</th>
                                                <th>Estatus</th>
                                                <th>Agente</th>
                                                <th>Tiene<br>Presupuesto</th>
                                                 @if($arrayPermition["change"] == 1)
                                                <th>Convertir a<br>cotización</th>
                                                @endif
                                                <th>Detalle</th>
                                                @if($arrayPermition["edit"] == 1)
                                                <th>Editar</th>
                                                @endif
                                                @if($arrayPermition["delete"] == 1)   
                                                  <th>Eliminar</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($oportunity as $item)
                                            <tr>
                                                <td>{!!$item->register_day !!}<br>{!!$item->register_hour !!}</td>
                                                <td>{!!$item->folio !!}</td>
                                                <td class="text-center">
                                                        @if(!empty($item->image))
                                                        <img style="max-height: 40px;" src="/images/business/{!!$item->image!!}" class="rounded-circle">
                                                        class="rounded-circle">
                                                        @else
                                                        <img style="max-height: 40px;" src="/images/business/em.jpg" class="rounded-circle">
                                                        @endif
                                                   
                                                    <div>
                                                        <a href="/detEmpresa/{!! $item->pkBusiness !!}">{!!$item->bussines !!}</a>
                                                    </div>
                                                </td>
                                                <td><span class="label label-success">$ {!!number_format($montWithIva[$item->pkOpportunities],2) !!}</span></td>
                                                <td class="text-center">
                                                     <table id="oporNeg" class="table display table-bordered table-striped no-wrap">
                                                       <thead>
                                                        <tr>
                                                            <th>Lugares</th>
                                                             <th>Curso</th>
                                                             <th>Precio</th>
                                                             
                                                        </tr>
                                                         </thead>
                                                        <tbody>
                                                             @foreach($oportunityDetail[$item->pkOpportunities] as $oportunityDetailInfo)
                                                             <tr>
                                                                 @if(isset($oportunityDetailInfo["qtyPlaces"]))
                                                                 <td> {!!$oportunityDetailInfo["qtyPlaces"] !!}</td>
                                                                 <td> {!!$oportunityDetailInfo["course"] !!}</td>
                                                                 <td> $ {!!number_format($oportunityDetailInfo["price"],2) !!}</td>
                                                                 
                                                                 @endif
                                                             </tr>
                                                             @endforeach
                                                        </tbody>
                                                     </table>
                                            
                                                   
                                                
                                                </td>
                                                <td>{!!$item->state !!} / {!!$item->country !!}</td>
                                                <td>
                                                 <span class="badge badge-pill text-white" style="background-color:{!!$item->color !!}">{!!$item->level !!}</span>
                                                </td>
                                                <td>
                                                    {!!$item->opportunities_status!!}
                                                </td>
                                                <td style="min-width:150px;">
                                                    Asignado:
                                                    @if(isset($item->agent))
                                                    <br><strong>{!!$item->agent!!}</strong>
                                                    @else
                                                     <br><strong></strong>
                                                    @endif
                                                    <hr style="margin:7px;">
                                                    Atendió:
                                                    <br>
                                                     @if(isset($item->asing))
                                                    <strong>{!!$item->asing  !!}</strong>
                                                    @else
                                                    <strong></strong>
                                                    @endif
                                                    
                                                </td>
                                                <th class="text-center">
                                                    @if($item->isBudget == 0)
                                                    <span class="ti-close text-danger">
                                                    @endif
                                                    
                                                    @if($item->isBudget == 1)
                                                    <span class="ti-check text-success">
                                                    @endif
                                                    
                                                    @if($item->isBudget == 2)
                                                    <span class="text-warning">Sin definir</span>
                                                    @endif
                                                    
                                                </th>
                                               @if($arrayPermition["change"] == 1)
                                                @if($item->opportunities_statu != 5)
                                                <td class="text-center"><span class="convertToQuotation cursor-h"  data-id="{!! $item->pkOpportunities!!}"><span class="ti-write"> </span>Convertir</span></td>
                                                @else
                                                <td class="text-center"><span>Oportunidad cotizada </span></td>
                                                @endif
                                                 <td>
                                                     <a href="#" data-id="{!!$item->pkOpportunities!!}" class="viewDetailOportunity"><i class="ti-eye"></i> Ver<br>detalle</a>
                                                </td> 
                                                @endif
                                                <td class="text-center">
                                                  @if($arrayPermition["edit"] == 1)
                                                    @if($item->opportunities_statu != 5)
                                                       <a href="#" data-id="{!! $item->pkOpportunities!!}" class="btn btn-primary btn-sm btn_editOportunity"> <span class="ti-pencil"> </span></a>
                                                         @else
                                                      <span> No editable </span>
                                                        @endif
                                                  @endif
                                                </td>
                                                
                                                <td class="text-center">
                                                   @if($arrayPermition["delete"] == 1)    
                                                     @if($item->opportunities_statu != 5)
                                                    <button class="btn btn-danger btn-sm btn_deleteOportunity" data-id="{!! $item->pkOpportunities!!}">
                                                        <span class="ti-close"></span></button>
                                                         @else
                                                          <span> No eliminable </span>
                                                     @endif
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
                </div>
               @else
                <div class="row">
                    <div class="col-12">
                        <!-- Campañas -->
                        <div class="card">
                            <div class="card-body">
                                Acceso denegado, no tiene permiso para esta sección
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

    <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditCategoria" class="modalEditCategoria"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditCategoria" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalEditCat" role="document">
       
      </div>
    </div>

    @include('includes.scripts')
    <script>
        $(function () {
            $('#oporNeg').DataTable({
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