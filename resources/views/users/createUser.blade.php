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
                            <h4 class="text-themecolor">Crear Usuarios</h4>
                        </div>
                        <div class="col-md-7 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                    <li class="breadcrumb-item">Usuarios</li>
                                    <li class="breadcrumb-item active">Crear Usuario</li>
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
                                            <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label class="control-label">Nombre Completo *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                                                        </div>
                                                        <input type="text" id="name" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="form-group">
                                                    <label class="control-label">Numero de extensión *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-headphone-alt"></i></span>
                                                        </div>
                                                        <input type="text" id="extension" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--div class="col-md-6">
                                               <div class="form-group">
                                                    <label class="control-label">Nombre de usuario *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                                                        </div>
                                                        <input type="text" id="username" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div-->
                                            <div class="col-md-6">
                                               <div class="form-group">
                                                    <label class="control-label">Correo <small>(Con este correo se podrá iniciar sesión)</small>*</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-email"></i></span>
                                                        </div>
                                                        <input type="text" id="email" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="form-group">
                                                    <label class="control-label">Contraseña *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-lock"></i></span>
                                                        </div>
                                                        <input type="text" id="password" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Imagen</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-image"></i></span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="image">
                                                            <label class="custom-file-label" for="inputGroupFile01">Elegir Imagen</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-md-6">
                                                <label>Grupo de Usuario</label>
                                                <select class="form-control custom-select" id="typeGroupUser" data-placeholder="Selecciona la Actividad" tabindex="1">
                                                    <option value="-1">
                                                        Selecciona grupo de usuario
                                                    </option>
                                                    <option value="1">Super Administrador</option>
                                                     <option value="2">Usuario</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row pt-3" id="permitionUser" style="display: none;">
                                            <div class="col-md-12 pt-3">
                                                <h4 class="title-section">Permisos de usuarios</h4>
                                            </div>
                                              
                                            <div class="col-md-12">
                                                <select class="form-control custom-select" id="typeUser" data-placeholder="Selecciona la Actividad" tabindex="1">
                                                    <option value="-1">
                                                        Selecciona tipo de usuario
                                                    </option>
                                                    @foreach($typeUser as $typeUserInfo)
                                                    <option value="{!!$typeUserInfo->pkUser_type!!}">{!!$typeUserInfo->name!!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 m-t-20 mb-3">
                                                <p>Selecciona las secciones que podrá ver el usuario que estás creando</p>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="permit">
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="dashboard" data-id="dashboard" data-children="-1">
                                                                    <label class="custom-control-label" for="dashboard">Dashboard</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="pipeline" data-id="pipeline" data-children="-1">
                                                                    <label class="custom-control-label" for="pipeline">Pipeline</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="notification" data-id="notification" data-children="-1">
                                                                    <label class="custom-control-label" for="notification">Notificaciones del header</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="bussinesSearch" data-id="companySearch" data-children="-1">
                                                                    <label class="custom-control-label" for="bussinesSearch">Buscador de empresas</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="sendMail" data-id="sendMail" data-children="-1">
                                                                    <label class="custom-control-label" for="sendMail">Env&iacute;o de correos</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="permit">
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="admin" data-id="admin" data-children="1">
                                                                    <label class="custom-control-label" for="admin">Admin</label>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="workplan" data-id="workplan" data-parent="admin" data-children="2"> 
                                                                    <label class="custom-control-label" for="workplan">Plan de trabajo</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addWorkplan" data-id="addWorkplan" data-parent="workplan" data-children="0">
                                                                    <label class="custom-control-label" for="addWorkplan">Crear plan de trabajo</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewWorkplan" data-id="viewWorkplan" data-parent="workplan" data-children="0">
                                                                    <label class="custom-control-label" for="viewWorkplan">Ver plan de trabajo</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteWorkplan" data-id="deleteWorkplan" data-parent="workplan" data-children="0">
                                                                    <label class="custom-control-label" for="deleteWorkplan">Eliminar plan de trabajo</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="configBonus" data-id="configBonus" data-parent="admin" data-children="0">
                                                                    <label class="custom-control-label" for="configBonus">Configuraci&oacute;n de bonos</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="sales" data-id="sales" data-parent="admin" data-children="0">
                                                                    <label class="custom-control-label" for="sales">Ventas por agente</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="activity" data-id="activity" data-parent="admin" data-children="0">
                                                                    <label class="custom-control-label" for="activity">Actividad</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="config" data-id="config" data-parent="admin" data-children="0">
                                                                    <label class="custom-control-label" for="config">Configuraci&oacute;n</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="permit">
                                                            <div class="form-grou m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="calendar" data-id="calendar" data-children="1">
                                                                    <label class="custom-control-label" for="calendar">Calendario</label>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewCalendar" data-id="viewCalendar" data-parent="calendar" data-children="0">
                                                                    <label class="custom-control-label" for="viewCalendar">Ver actividades</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addActivity" data-id="addActivity" data-parent="calendar" data-children="0">
                                                                    <label class="custom-control-label" for="addActivity">A&ntilde;adir actividad</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="permit">
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="negocios" data-id="bussines" data-children="1">
                                                                    <label class="custom-control-label" for="negocios">Negocios</label>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="quotes" data-id="quotes" data-parent="bussines" data-children="2">
                                                                    <label class="custom-control-label" for="quotes">Cotizaciones</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewQuotes" data-id="viewQuotes" data-parent="quotes" data-children="0">
                                                                    <label class="custom-control-label" for="viewQuotes">Ver cotizaciones</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="money" data-id="money" data-parent="quotes" data-children="0">
                                                                    <label class="custom-control-label" for="money">Validar dinero en cuenta</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="invoice" data-id="invoice" data-parent="quotes" data-children="0">
                                                                    <label class="custom-control-label" for="invoice">Facturar cotizaci&oacute;n</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editQuotes" data-id="editQuotes" data-parent="quotes" data-children="0">
                                                                    <label class="custom-control-label" for="editQuotes">Editar</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="changeQuotes" data-id="changeQuotes" data-parent="quotes" data-children="0">
                                                                    <label class="custom-control-label" for="changeQuotes">Cambiar estatus</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteQuotes" data-id="deleteQuotes" data-parent="quotes" data-children="0">
                                                                    <label class="custom-control-label" for="deleteQuotes">Eliminar cotizaciones</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="opportunities" data-id="opportunities" data-parent="bussines" data-children="2">
                                                                    <label class="custom-control-label" for="opportunities">Oportunidades de negocio</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewOpportunities" data-id="viewOpportunities" data-parent="opportunities" data-children="0">
                                                                    <label class="custom-control-label" for="viewOpportunities">Ver oportunidades</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editOpportunities" data-id="editOpportunities" data-parent="opportunities" data-children="0">
                                                                    <label class="custom-control-label" for="editOpportunities">Editar</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="changeOpportunities" data-id="changeOpportunities" data-parent="opportunities" data-children="0">
                                                                    <label class="custom-control-label" for="changeOpportunities">Cambiar estatus</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-5">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteOpportunities" data-id="deleteOpportunities" data-parent="opportunities" data-children="0">
                                                                    <label class="custom-control-label" for="deleteOpportunities">Eliminar oportunidad</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="permit">
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="job" data-id="job" data-children="1">
                                                                    <label class="custom-control-label" for="job">Actividades</label>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewJob" data-id="viewJob" data-parent="job" data-children="0">
                                                                    <label class="custom-control-label" for="viewJob">Ver actividades</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="finishJob"  data-id="finishJob" data-parent="job" data-children="0">
                                                                    <label class="custom-control-label" for="finishJob">Finalizar actividades</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editJob" data-id="editJob" data-parent="job" data-children="0">
                                                                    <label class="custom-control-label" for="editJob">Editar actividades</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteJob" data-id="deleteJob" data-parent="job" data-children="0">
                                                                    <label class="custom-control-label" for="deleteJob">Eliminar actividades</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="permit">
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="company" data-id="company" data-children="1">
                                                                    <label class="custom-control-label" for="company">Empresas</label>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewCompany" data-id="viewCompany" data-parent="company" data-children="0">
                                                                    <label class="custom-control-label" for="viewCompany">Ver empresas</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addCompany" data-id="addCompany" data-parent="company" data-children="0">
                                                                    <label class="custom-control-label" for="addCompany">Registrar empresas</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editCompany" data-id="editCompany" data-parent="company" data-children="0">
                                                                    <label class="custom-control-label" for="editCompany">Editar empresas</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteCompany" data-id="deleteCompany" data-parent="company" data-children="0">
                                                                    <label class="custom-control-label" for="deleteCompany">Eliminar empresas</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="permit">
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="campaign" data-id="campaign" data-children="1">
                                                                    <label class="custom-control-label" for="campaign">Campa&ntilde;as</label>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewCampaign" data-id="viewCampaign" data-parent="campaign" data-children="0">
                                                                    <label class="custom-control-label" for="viewCampaign">Ver campa&ntilde;as</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editCampaign" data-id="editCampaign" data-parent="campaign" data-children="0">
                                                                    <label class="custom-control-label" for="editCampaign">Editar campa&ntilde;a</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteCampaign" data-id="deleteCampaign" data-parent="campaign" data-children="0">
                                                                    <label class="custom-control-label" for="deleteCampaign">Eliminar campa&ntilde;as</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="permit">
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="notificationC" data-id="notificationC" data-children="1">
                                                                    <label class="custom-control-label" for="notificationC">Notificaciones del menú</label>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="addNotification" data-id="addNotification" data-parent="notificationC" data-children="0">
                                                                    <label class="custom-control-label" for="addNotification">Crear notificaciones</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewNotification" data-id="viewNotification" data-parent="notificationC" data-children="0">
                                                                    <label class="custom-control-label" for="viewNotification">Ver notificaciones</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deleteNotification" data-id="deleteNotification" data-parent="notificationC" data-children="0">
                                                                    <label class="custom-control-label" for="deleteNotification">Eliminar notificaciones</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="permit">
                                                            <div class="form-group m-b-10">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="callPending" data-id="callPending" data-children="1">
                                                                    <label class="custom-control-label" for="callPending">Llamadas pendientes</label>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="viewcallPending" data-id="viewcallPending" data-parent="callPending" data-children="0">
                                                                    <label class="custom-control-label" for="viewcallPending">Ver llamadas pendientes</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="editcallPending" data-id="editcallPending" data-parent="callPending" data-children="0">
                                                                    <label class="custom-control-label" for="editcallPending">Editar llamadas pendientes</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-b-10 pl-2">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input checkPermition" name="pres" value="0" id="deletecallPending" data-id="deletecallPending" data-parent="callPending" data-children="0">
                                                                    <label class="custom-control-label" for="deletecallPending">Eliminar llamadas pendientes</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right pt-3">
                                            <button type="button" class="btn btn-success" id='btnCreateUser'><span class="ti-check"></span> Crear</button>
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