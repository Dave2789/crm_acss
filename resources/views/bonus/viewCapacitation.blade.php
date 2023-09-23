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
                        <h4 class="text-themecolor">Ver capacitaciones</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Capacitaci&oacute;n</a></li>
                                <li class="breadcrumb-item active">Capacitaciones</li>
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
                                <h4 class="card-title">Capacitaciones</h4>
                                 <div class="row">  
                                  
                                      <div class="col-6 m-t-30">
                                       <select class="form-control custom-select" id="yearCapacitation" data-placeholder="Selecciona la Actividad" tabindex="1">
                                           <option value="-1">Selecciona Año</option>
                                           @foreach($year as $yearInfo)
                                            <option value="{{ $yearInfo }}">{{ $yearInfo }}</option>
                                           @endforeach
                                       </select>
                                    </div>
                                      <div class="col-6 m-t-30">
                                       <select class="form-control custom-select" id="month" data-placeholder="Selecciona la Actividad" tabindex="1">
                                           <option value="-1">Selecciona Mes</option>
                                       </select>
                                    </div>
                                     
                                      <div class="col-12 text-right mt-2"> 
                                         <button type="button" class="dt-button buttons-excel buttons-html5 btn btn-primary mr-1" id="searchCapacitation">Buscar</button>
                                    </div>
                                 </div>
                                <div class="table-responsive m-t-40" id="cotizacionesDiv">
                                    <table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Agente</th>
                                                <th>Cursos</th>
                                                <th>Editar</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                                @foreach($bound as $boundInfo)
                                                 <tr>
                                                 <td>{!! $boundInfo->date !!} </td>
                                                 <td>{!! $boundInfo->full_name !!}</td>
                                                
                                                <td class="viewCources" data-id="{{$boundInfo->pkCapacitation }}" data-user="{{ $boundInfo->pkUser }}" style="cursor: pointer">
                                                    <span class="ti-eye"></span>
                                                </td>
                                                 <td class="text-center updateCapacitation" data-id="{{$boundInfo->pkCapacitation }}" data-user="{{ $boundInfo->pkUser }}" style="cursor: pointer">
                                                    <span class="ti-pencil"></span>
                                                 </td>
                                                 <td class="text-center">
                                                    <button class="btn btn-danger btn-sm btn_deleteCapacitation" data-id="{{ $boundInfo->pkCapacitation}}" data-user="{{ $boundInfo->pkUser }}"><span class="ti-close"></span></button> 
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