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
                        <h4 class="text-themecolor">Crear Notificación</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Notificación</li>
                                <li class="breadcrumb-item active">Crear Notificación</li>
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
                                <form id="createAlert" action="/createAlertDB">
                                    <div class="row pt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Título</label>
                                                <input type="text" id="title" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Fecha</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                    </div>
                                                    <input type="date" id="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Mensaje</label>
                                                <textarea class="form-control" id="message" cols="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="control-label">Agregar un cliente / prospecto</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                                  </div>
                                                     <input autocomplete="off" type="text" data-id="-1" id="slcBussines" class="autocomplete_bussines form-control" placeholder="Escribe el nombre de la empresa">
                                                </div>
                                                   <div  class="search-header-bussines">
                                                    </div>
                                                    <div class="search__border"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Asignado a</label>
                                                <select class="form-control" id="users" multiple="">
                                                    @foreach($usersQuery as $usersInfo)
                                                    <option value="{!!$usersInfo->pkUser!!}">{!!html_entity_decode($usersInfo->full_name)!!} ({!!html_entity_decode($usersInfo->type_user_name)!!})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="control-label"><i class="ti-link"></i> Adjuntar archivo desde su computadora</label>
                                            <input id="file" type="file">
                                          </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-success"><span class="ti-check"></span> Crear</button>
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