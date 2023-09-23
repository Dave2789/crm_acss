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
                        <h4 class="text-themecolor">Descargar Correos</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Empresas</li>
                                <li class="breadcrumb-item active">Descargar Correos</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Empresa -->
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <!-- Filtros -->
                            <div class="col-5 card">
                                <div class="card-body">
                                    <h4 class="card-title">Giro</h4>
                                    <div class=" row">
                                        <select id="slcGiro" class="custom-select form-control input-sm m-b-10">
                                            <option value="-1">Todos</option>
                                            @foreach($giros as $item)
                                            <option value="{!!$item->pkCommercial_business!!}">{!!$item->name!!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="exampleSorting"></div>
                                </div>
                            </div><!-- Column -->
                            <div class="col-5 card">
                                <div class="card-body">
                                    <h4 class="card-title">Tipo</h4>
                                    <div class=" row">
                                        <select id="slcType" class="custom-select form-control input-sm m-b-10">
                                            <option value="-1">Todos</option>
                                            <option value="3">Prospecto</option>
                                            <option value="4">Leads</option>
                                            <option value="9">Clientes</option>
                                        </select>
                                    </div>
                                    <div id="exampleSorting"></div>
                                </div>
                            </div><!-- Column -->
                            <div class="col-2 card">
                                <div class="card-body m-t-20">
                                    <h4 class="card-title"></h4>
                                    <button class="btn btn-primary" type="button" id="dowloadBussines">Descargar</button>
                                </div>
                            </div><!-- Column -->
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