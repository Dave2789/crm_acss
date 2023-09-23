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
                        <h4 class="text-themecolor">Configurar Comisi&oacute;n</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Comisiones</li>
                                <li class="breadcrumb-item active">Configurar Comisi&oacute;n</li>
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
                                            <div class="col-md-12">
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
                                                    <label class="control-label">Menor o igual que*</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                        </div>
                                                        <input type="text" id="less_to" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Comisi&oacute;n *</label>
                                                    <div class="input-group">
                                                        <input type="text" id="comition_less" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon11">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Mayor o igual que*</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                        </div>
                                                        <input disabled pe="text" id="higher_or_equal_to" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Menor o igual que*</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                        </div>
                                                        <input disabled type="text" id="less_or_equal_to" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Comisi&oacute;n *</label>
                                                    <div class="input-group">
                                                        <input disabled type="text" id="comition_higher_less" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon11">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-2 text-center" id="activeComition" style="margin-top:10px">
                                                <div class="form-actions mt-3">
                                                     <button type="button" class="btn btn-success" id="btn_activeComition">Activar</button>
                                                 </div>
                                            </div>

                                            <div class="col-2 text-center" id="desactiveComition" style="margin-top:10px; display:none">
                                                <div class="form-actions mt-3">
                                                     <button type="button" class="btn btn-success" id="btn_desactiveComition">Desactivar</button>
                                                 </div>
                                            </div>
                                            <input type="hidden" value="0" id="isActive">
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Mayor que *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                        </div>
                                                        <input type="text" id="higher_to" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Comisi&oacute;n *</label>
                                                    <div class="input-group">
                                                        <input type="text" id="comition_higher" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon11">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             

                                                <div class="col-md-6">

                                               <label class="control-label">Mes de la comisión*</label>
                                               <div class="input-group">
                                                   <div class="input-group-prepend">
                                                       <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                   </div>
                                                   <input type="month" id="dateBon" class="form-control vigencia" value="{{date('Y-m')}}">
                                               </div>
                                           </div>
                                           
                                           <div class="col-12 text-center">
                                               <div class="form-actions mt-3">
                                                    <button type="button" class="btn btn-success" id="btn_addComition"> <i class="fa fa-check"></i> Agregar</button>
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