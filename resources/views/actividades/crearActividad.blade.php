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
                        <h4 class="text-themecolor">Crear Actividades</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Actividades</li>
                                <li class="breadcrumb-item active">Crear Actividades</li>
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
                                <form id="createActivity" action="/createActivity">
                                    <div class="row pt-3">
                                        <div class="col-12 mb-3"><small id="emailHelp" class="form-text text-muted">* Campos obligatorios.</small></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Empresa *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                                  </div>
                                                  <select class="form-control custom-select" id="activityBusiness" data-placeholder="Selecciona una empresa" tabindex="1">
                                                        <option value="-1">Selecciona una empresa</option>
                                                        @foreach($businessQuery as $businessInfo)
                                                        <option value="{{$businessInfo->pkBusiness}}">{{html_entity_decode($businessInfo->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Negocios abiertos *</label>
                                                <select class="form-control custom-select" id="type_event_business" data-placeholder="Selecciona el tipo de negocio" tabindex="1">
                                                    <option value="-1">Selecciona el tipo de negocio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Agente *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                                                  </div>
                                                  <select class="form-control custom-select" id="userAgent" data-placeholder="Selecciona el Agente" tabindex="1">
                                                    <option value="-1">Seleccionar agente</option>
                                                    @foreach($usersQuery as $usersInfo)
                                                        <option value="{{$usersInfo->pkUser}}">{{html_entity_decode($usersInfo->full_name)}} ({{html_entity_decode($usersInfo->type_name)}})</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Tipo de Actividad *</label><br>
                                                <!--div class="color-act">
                                                    <label class="btn" style="background-color:coral;">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="customRadio1" name="options" value="male" class="custom-control-input">
                                                            <label class="custom-control-label" for="customRadio1">Llamadas</label>
                                                        </div>
                                                    </label>
                                                    <label class="btn" style="background-color:pink;">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="customRadio2" name="options" value="female" class="custom-control-input">
                                                            <label class="custom-control-label" for="customRadio2">Visitas</label>
                                                        </div>
                                                    </label>
                                                    <label class="btn" style="background-color:darksalmon;">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="customRadio3" name="options" value="n/a" class="custom-control-input">
                                                            <label class="custom-control-label" for="customRadio3">Email</label>
                                                        </div>
                                                    </label>
                                                </div-->
                                                <select class="form-control custom-select" id="type_activity" data-placeholder="Selecciona la Actividad" tabindex="1">
                                                    <option value="-1">Selecciona el tipo de actividad</option>
                                                    @foreach($activitiesTypeQuery as $activitiesTypeInfo)
                                                        <option value="{{$activitiesTypeInfo->pkActivities_type}}">{!!$activitiesTypeInfo->text!!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Texto *</label>
                                                <textarea class="form-control" cols="3" id="description" placeholder="Descripción de la actividad"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" >Fecha *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                  </div>
                                                  <input type="date" id="date" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" >Hora *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-time"></i></span>
                                                  </div>
                                                  <input type="time" id="hour" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Adjuntar documento</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-image"></i></span>
                                                  </div>
                                                  <div class="custom-file">
                                                    <input type="file" id="document" class="custom-file-input" id="customFileLang" lang="es">
                                                  <label class="custom-file-label form-control" for="customFileLang">Seleccionar Archivo</label>
                                                </div>
                                                </div>
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

</body>
</html>