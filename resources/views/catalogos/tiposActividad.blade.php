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
                        <h4 class="text-themecolor">Tipos de Actividad</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Tipos de Actividad</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Tablas -->
                <div class="row">
                    <div class="col-12">
                        <!-- Tipos de Actividad -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Tipos de Actividad</h4>
                                <div class="f-right mb-3">
                                    <button type="button" data-toggle="modal" data-target="#modalCrearActividad" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Crear nuevo</button>
                                </div>
                                <div class="table-responsive m-t-40">
                                    <table id="oporNeg" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Texto</th>
                                                <th>Color</th>
                                                <th>Ícono</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activityTypeQuery as $activityTypeInfo)
                                            <tr>
                                                <td>{{html_entity_decode($activityTypeInfo->text)}}</td>
                                                <td><div class="color-show" style="background-color:{{$activityTypeInfo->color}};"></div></td>
                                                <td><span class="{{$activityTypeInfo->icon}}"></span></td>
                                                <td>
                                                   
                                                    <button class="btn btn-info btn-sm btn_updateActivityType" data-id="{{$activityTypeInfo->pkActivities_type}}"><span class="ti-pencil"></span></button>
                                                   @if($activityTypeInfo->pkActivities_type != 1)
                                                    <button class="btn btn-danger btn-sm btn_deleteActivityType" data-id="{{$activityTypeInfo->pkActivities_type}}"><span class="ti-close"></span></button>
                                                   @else
                                                   <span>No eliminable</span>
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

                <!-- End Page Content -->

            </div><!-- End Container fluid  -->
        </div><!-- End Page wrapper  -->

        @include('includes.footer')
        <!-- End footer -->
    </div><!-- End Wrapper -->

    <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalCrearActividad" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Nuevo Tipo de Actividad</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="row pt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Texto</label>
                            <input type="text" id="textAddActivityType" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Color</label>
                            <input type="color" id="colorAddActivityType" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Ícono</label>
                        <div class="icons-show card">
                            <div class="icon-list-demo row">
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-mobile"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-email"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-headphone-alt"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-light-bulb"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-trash"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-user"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-link"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-desktop"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-star"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-settings"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-calendar"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-time"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-pencil"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-briefcase"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-book"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-wallet"></i></button> </div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-pin-alt"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-star"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-lock"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-eye"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-location-arrow"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-search"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-folder"></i></button></div>
                                <div class="col-3 col-md-1"> <button class="btn btn-light type_activity_ico"><i class="ti-write"></i></button></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button class="btn btn-success btn_addActivityType"><span class="ti-check"></span> Crear</button>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    
    <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditActividad" class="modalEditActividad"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditActividad" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalActividad" role="document">
       
      </div>
    </div>

    @include('includes.scripts')
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
    </script>
    <!-- End scripts  -->
</body>


</html>