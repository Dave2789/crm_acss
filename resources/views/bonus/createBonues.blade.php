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
                        <h4 class="text-themecolor">Configurar Bonos Base</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Bonos</li>
                                <li class="breadcrumb-item active">Configurar Bonos Base</li>
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
                                        <div class="row pt-3 px-3">
                                            <div class="col-12 mb-3"><small id="emailHelp" class="form-text text-muted">* Campos obligatorios.</small></div>
                                            
                                            <div class="col-md-6">

                                               <label class="control-label">Mes del Bono*</label>
                                               <div class="input-group">
                                                   <div class="input-group-prepend">
                                                       <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                   </div>
                                                   <input type="month" id="dateBon" class="form-control vigencia" value="{{date('Y-m')}}">
                                               </div>
                                           </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Agente *</label>
                                                    <select id="slcAgent" class="form-control custom-select"  tabindex="1" multiple>
                                                        @foreach($agent as $item)
                                                        <option value="{{$item->pkUser}}">{!!$item->full_name!!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Monto Meta *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                        </div>
                                                        <input type="text" id="montRec" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Porcentaje de Bono "Primer Agente" *</label>
                                                    <div class="input-group">
                                                        <input type="text" id="porcentFirst" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon11">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Porcentaje del Sueldo Base a Obtener *</label>
                                                    <div class="input-group">
                                                        <input type="text" id="porcentBon" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon11">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Monto m&iacute;nimo *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                        </div>
                                                        <input type="text" id="montMin" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                          <!--  <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Porcentaje de Penalizaci&oacute;n *</label>
                                                    <div class="input-group">
                                                        <input type="text" id="porcentPenalty" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon11">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->
                                            <h4 class="title-section">Penalizaci&oacute;n</h4>
                                            <div class="agents" id="agents">
                                               <div class="Addagents row">
                                                 <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                           <label class="control-label">Agente*</label>
                                                                <select class="form-control custom-select slcAgent" multiple data-placeholder="Elige Categoría" tabindex="1">
                                                                      
                                                                        @foreach($agent as $item)
                                                                        <option value="{{$item->pkUser}}">{!!$item->full_name!!}</option>
                                                                        @endforeach
                                                                    </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                            <label class="control-label">Porcentaje de Penalizaci&oacute;n *</label>
                                                            <div class="input-group">
                                                                <input type="text"  class="form-control porcentPenalty">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon11">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        

                                        <div class="col-md-12 text-right">
                                                <button type="button" class="btn btn-info"
                                                   id='addNewPenalitation'>Agregar penalizacion</button>
                                             </div>
                                           
                                           <div class="col-12 text-center">
                                               <div class="form-actions mt-3">
                                                    <button type="button" class="btn btn-success" id="btn_addBon"> <i class="fa fa-check"></i> Agregar</button>
                                                </div>
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


    @include('includes.scripts')

    <!-- End scripts  -->

</body>
</html>