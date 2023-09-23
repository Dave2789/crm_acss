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
                        <h4 class="text-themecolor">Crear Nueva Campaña</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Campañas</li>
                                <li class="breadcrumb-item active">Crear Nueva Campaña</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Empresa -->
                <div class="row">
                    <div class="col-12">
                        <!-- Crear Empresa -->
                        <div class="card">
                            <form id="createCampaign" action="/commercialCampaignsCreateDB">
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row pt-3">
                                           
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Nombre de la Campaña</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-layers"></i></span>
                                                        </div>
                                                        <input type="text" id="name" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                               <div class="form-group">
                                                    <label class="control-label">Código de la Campaña</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>
                                                        </div>
                                                        <input type="text" id="code" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Agente Encargado</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                                                        </div>
                                                        <select class="form-control custom-select" id="agentMain" data-placeholder="Selecciona el agente" tabindex="1">
                                                            <option value="-1">Selecciona un agente</option>
                                                            @foreach($usersQuery as $usersInfo)
                                                                <option value="{{$usersInfo->pkUser}}">{{html_entity_decode($usersInfo->full_name)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Fecha de Inicio</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                        </div>
                                                        <input type="date" id="startDate" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Fecha Final</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                        </div>
                                                        <input type="date" id="endDate" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Tipo</label>
                                                    <select class="form-control custom-select" id="type" data-placeholder="Selecciona el tipo de Campaña" tabindex="1">
                                                        <option value="-1">Selecciona el tipo de campaña</option>
                                                        @foreach($typesQuery as $typesInfo)
                                                            <option value="{{$typesInfo->pkCampaigns_type}}">{{html_entity_decode($typesInfo->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Descripción</label>
                                                    <textarea class="form-control" id="description" placeholder="Breve descripción de la campaña" cols="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Agentes</label>
                                                    <select id="agentSecondary" class="form-control" multiple="">
                                                        @foreach($usersQuery as $usersInfo)
                                                            <option value="{{$usersInfo->pkUser}}">{{html_entity_decode($usersInfo->full_name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Cargar Excel</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-file"></i></span>
                                                        </div>
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
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Crear</button>
                                        </div>
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