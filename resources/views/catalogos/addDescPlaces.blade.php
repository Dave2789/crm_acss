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
                        <h4 class="text-themecolor">Importar Descuentos</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Configuracion</li>
                                <li class="breadcrumb-item active">Importar Descuentos</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Empresa -->
                <div class="row">
                    <div class="col-12">
                        <!-- Crear Empresa -->
                        <div class="card">
                            <form action="#">
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row pt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Subir Archivo</label>
                                                    <div class="input-group">
                                                      <div class="custom-file">                
                                                          <input type="file" class="custom-file-input" id="fileBusiness">                
                                                          <label class="custom-file-label" for="inputGroupFile01">Buscar</label>          
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--/row-->
                                    </div>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <button type="button" id="saveMasiveDesc" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="form-body">
                                <div class="card-body">
                                        <h4>Promociones</h4>
                                     <div class="table-responsive m-t-40" id="cotizacionesDiv">
                                       <table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
                                         <thead>
                                            <tr>
                                                <th>Cantidad de lugares</th>
                                                <th>Descuento %</th>
                                                <th>Editar</th>
                                                <th>Eliminar</th>
                                               </tr>
                                              </thead>
                                               <tbody>
                                           
                                                @foreach($promotion as $promotionInfo)
                                                 <tr>
                                                  <td>{{$promotionInfo->cantPlaces }} </td>
                                                  <td>{{$promotionInfo->discount }} %</td>
                                                 <td class="text-center updatePromotion" data-id="{{$promotionInfo->pkDiscount_places }}" style="cursor: pointer">
                                                    <span class="ti-pencil"></span>
                                                 </td>
                                                 <td class="text-center">
                                                    <button class="btn btn-danger btn-sm btn_deletePromotion" data-id="{{ $promotionInfo->pkDiscount_places}}"><span class="ti-close"></span></button> 
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

    <!-- End scripts  -->
    
</body>
</html>