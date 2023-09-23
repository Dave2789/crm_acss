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
                        <h4 class="text-themecolor">Configurar precio</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Configurar</li>
                                <li class="breadcrumb-item active">Configurar precio</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Empresa -->
                <div class="row">
                    <div class="col-12">
                        <!-- Crear Empresa -->
                        <div class="card">
                            <div class="card-body">
                                <form>
                                    <div class="row pt-3">
                                      <div class="col-12 mb-3"><small id="emailHelp" class="form-text text-muted">* Campos obligatorios.</small></div>
                                      
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Precio de los lugares *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                  </div>
                                                    @if(isset($price->price))
                                                    <input id="pricePlace" type="text" class="form-control" placeholder="0" value="{{$price->price}}">
                                                    @else
                                                     <input id="pricePlace" type="text" class="form-control" placeholder="0">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                      
                                      <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Iva *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11">%</span>
                                                  </div>
                                                    @if(isset($price->iva))
                                                    <input id="priceIva" type="text" class="form-control" placeholder="0" value="{{$price->iva}}">
                                                    @else
                                                     <input id="priceIva" type="text" class="form-control" placeholder="0">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                      

                                        <div class="col-md-12 text-right">
                                            <button type="button" class="btn btn-success" id="addConfig"><span class="ti-check"></span>Guardar</button>
                                        </div>
                                    </div>
                                </form>
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

</body>
</html>