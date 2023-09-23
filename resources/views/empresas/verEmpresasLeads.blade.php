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
                        <h4 class="text-themecolor">Ver Empresas</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Empresas</li>
                                <li class="breadcrumb-item active">Ver Empresas</li>
                            </ol>
                        </div>
                    </div>
                </div>

                 <!-- Filtros -->
                <div class="row">
                    <div class="col-md-2 col-6 card">

                               <div class="card-body">
                            <h4 class="card-title">Estatus</h4>
                            <div class=" row">
                               <select class="form-control custom-select" id="slcViewStatusBussines2" data-placeholder="Selecciona la Actividad" tabindex="1">
                                       <option value="-1">Selecciona un status</option>
                                         <option value="1">Activas</option>      
                                         <option value="0">Inactivas</option>  
                                     </select>
                            </div>
                            <div id="exampleSorting"></div>
                        </div>

                    </div><!-- País -->
                    <div class="col-md-2 col-6 card">
                        <div class="card-body">
                            <h4 class="card-title">Giro</h4>
                            <div class=" row">
                                <select id="pkGiro" class="custom-select form-control input-sm m-b-10">
                                    <option value="-1">Todos</option>
                                    @foreach($giros as $giroInfo)
                                    <option value="{!! $giroInfo->pkCommercial_business !!}">{!! $giroInfo->name !!}</option>
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
                                    <option value="-1">Todos</option>
                                    @foreach($campanias as $campanyInfo)
                                    <option value="{!! $campanyInfo->pkCommercial_campaigns !!}">{!! $campanyInfo->name !!}</option>
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
                                  <input type="date" class="form-control" id="startDay">
                                </div>
                                <div class="col-6">
                                  <input type="date" class="form-control" id="finishDay">
                                </div>
                              </div>
                        </div>
                    </div><!-- Fechas -->
                     <div class="col-md-2  card"> 
                               <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-12 mt-4">
                                         <button type="button" class="dt-button buttons-excel buttons-html5 btn btn-primary mr-1" id="search_bussines_leads">Buscar</button>
                                        </div>
                                      </div>
                                </div>  
                                    </div>
                </div>

                <!-- Tablas -->
                <div class="row">
             
                    <div class="col-12">
                        <!-- Prospectos -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Empresas leads</h4>
                                <div class="row">
                                  <div class="col-sm-6">
                                   
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="btn-group f-right">
                                      <a href="/verEmpresas" class="btn btn-secondary">Todas</a>
                                      <a href="/verEmpresasProspecto" class="btn btn-warning">Prospectos</a>
                                      <a href="/verEmpresasLeads" class="btn btn-info">Leads</a>
                                      <a href="/verEmpresasCliente" class="btn btn-success">Clientes</a>
                                    </div>
                                  </div>
                                    
                                    <div class="col-md-12">
                                        <div class="table-responsive m-t-20" id="activeEmpDiv">
                                                <div class="dt-buttons">
                                                        <button type="button" data-id="4" class="dowloadExcel dt-button buttons-excel buttons-html5 btn btn-primary mr-1" tabindex="0" aria-controls="activeEmp">
                                                            <span>Excel</span>
                                                        </button> 
                                                    </div>
                                                     <div id="activeEmp_filter" class="dataTables_filter">
                                                         <label>Buscar:<input id="seacrhBussines" data-id="4" type="search" class="form-control form-control-sm" placeholder="" aria-controls="activeEmp">
                                                        </label>
                                                    </div>
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
                                                        <th>Siguiente actividad</th>
                                                        <th>Fecha de vencimiento<br>siguiente actividad</th>
                                                        <th>Ver empresa</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($bussines as $item)
                                                
                                                  <tr>
                                                        <td>
                                                            <a href="/detEmpresa/{!!$item->pkBusiness!!}">{!! $item->name !!}</a>
                                                        </td>
                                                         <td>
                                                             @if(!empty($item->nameContact))
                                                            <div>{!!$item->nameContact!!}<br>
                                                                <small><span class="ti-email"></span>{!!$item->mailContact!!}</small><br>
                                                                @if(!empty($item->phoneContact))
                                                                <small><span class="ti-headphone"></span> {!!$item->phoneContact!!}</small>
                                                                @endif
                                                                 @if(!empty($item->mobile_phone))
                                                                <small><span class="ti-mobile"></span> {!!$item->mobile_phone!!}</small>
                                                                 @endif
                                                                 <small><a href="#" class="viewBussinesContact" data-id="{!!$item->pkBusiness!!}"><span class="ti-user"></span> Ver todos</a></small>
                                                            </div>
                                                             @else
                                                              <div>
                                                               N/A<br>
                                                                 <small><a href="#" class="viewBussinesContact" data-id="{!!$item->pkBusiness!!}"><span class="ti-user"></span> Agregar</a></small>
                                                              </div>
                                                             @endif
                                                        </td>
                                                         <td>
                                                          {!! html_entity_decode($item->fKOrigin) !!}
                                                        </td>
                                                         <td>
                                                          {!! html_entity_decode($item->category) !!}
                                                        </td>
                                                          <td>
                                                          {!! html_entity_decode($item->giro) !!}
                                                        </td>
                                                       
                                        
                                            <td><span class="badge badge-info badge-pill">Lead</span> </td>
                                   
                                                          <td>
                                                           <span class="label label-success">{!! $item->salesPay !!} </span> 
                                                           <span class="label label-danger"> {!! $item->salesLoss !!}</span> </td>
                                                            <td>    
                                                 
                                                        <span class="label label-info"> {!! $item->quotations !!}</span></td>
                                            <td>  
                                                <span class="label label-success">{!! $item->oportunityAproved !!}</span>
                                               <span class="label label-info"> {!! $item->oportunityOpen !!}</span>
                                                 <span class="label label-danger"> {!! $item->oportunityLoss !!}</span>
                                              </td>
                                                              <td>
                                                     @if(isset($activities[$item->pkBusiness]["lastActivity"]))
                                                     <span> {!!$activities[$item->pkBusiness]["lastActivity"]!!} </span>
                                                     @else
                                                      <span>N/A</span>
                                                     @endif
                                                 </td>
                                                  <td class="t-column" style="min-width: 400px;">
                                                       @if(isset($activities[$item->pkBusiness]["nextActivity"]))
                                                     <span>   {!!$activities[$item->pkBusiness]["nextActivity"]!!} </span>
                                                     @else
                                                      <span>N/A</span>
                                                     @endif
                                               
                                                </td>
                                                 <td>
                                                       @if(isset($activities[$item->pkBusiness]["finalActivity"]))
                                                     <span>{!!$activities[$item->pkBusiness]["finalActivity"]!!} </span>
                                                     @else
                                                      <span>N/A</span>
                                                     @endif
                                                 
                                                </td>
                                                          <td class="text-center"><a href="/detEmpresa/{!!$item->pkBusiness!!}"><span class="ti-eye"></span></a></td>
                                                          <td>
                                                             <button class="btn btn-info btn-sm btn_updateBussines" data-id="{!!$item->pkBusiness!!}"><span class="ti-pencil"></span></button>
                                                            <button class="btn btn-danger btn-sm btn_deleteBussines" data-id="{!!$item->pkBusiness!!}"><span class="ti-close"></span></button>   
                                                          </td>
                                                    </tr>
                                                 
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="dataTables_info" id="oporNeg_info" role="status" aria-live="polite">Mostrando {!!$bussines->currentPage()!!} a {!! $bussines->perPage() !!} de {!!$bussines->total()!!} registros</div>
                                            <div class="dataTables_paginate paging_simple_numbers">
                                                {!!$bussines->links() !!}  
                                                </div>
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


        <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditCategoria" class="modalEditCategoria"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditCategoria" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalEditCat" role="document">
       
      </div>
    </div>
    @include('includes.scripts')
    <script>
        $(function () {
            $('#agregadasRecientemente').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });
            $('#masCompras').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });  
            $('#activeEmp').DataTable({
                dom: 'Bfrtip',
                "paging":   false,
                "info":     false,
                "searching": false,
                buttons: [
                  
                ]
            });  
            $('#inactiveEmp').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });  
            $('#activeLeads').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            }); 
            $('#inactiveLeads').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });   
            $('#activeClientes').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });   
            $('#inactiveClientes').DataTable({
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