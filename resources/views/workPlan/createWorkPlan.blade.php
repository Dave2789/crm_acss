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
                            <h4 class="text-themecolor">Crear plan de trabajo</h4>
                        </div>
                        <div class="col-md-7 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                    <li class="breadcrumb-item">Plan de trabajo</li>
                                    <li class="breadcrumb-item active">Crear nuevo plan de trabajo</li>
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
                                                    <div class="form-group">
                                                        <label class="control-label">Agente *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="ti-user"></i></span>
                                                            </div>
                                                            <select id="slcAgent" class="form-control custom-select" data-placeholder="Elige Categoría" tabindex="1">
                                                                <option value="-1">Selecciona un agente</option>
                                                                @foreach($agent as $item)
                                                                <option value="{!!$item->pkUser!!}">{!!$item->full_name!!}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Llamadas por hora *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon11"><i class="ti-timer"></i></span>
                                                            </div>
                                                            <input type="text" id="callsPerHour" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label class="control-label">Horas por mes *</label>
                                                         <div class="input-group">
                                                             <div class="input-group-prepend">
                                                                 <span class="input-group-text" id="basic-addon11"><i class="ti-home"></i></span>
                                                             </div>
                                                             <input type="text" id="hourPerMont" class="form-control">
                                                         </div>
                                                     </div>
                                                 </div>-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Porcentaje mínimo de Llamadas enlazadas *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon11"><i class="ti-stats-up"></i></span>
                                                            </div>
                                                            <input type="text" id="callsLinked" class="form-control">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="basic-addon11">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Porcentaje máximo de Llamadas Fallidas*</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon11"><i class="ti-stats-down"></i></span>
                                                            </div>
                                                            <input type="text" id="callsFaild" class="form-control">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="basic-addon11">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Porcentaje de Penalizaci&oacute;n *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon11"><i class="ti-face-sad"></i></span>
                                                            </div>
                                                            <input type="text" id="penalty" class="form-control">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="basic-addon11">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Monto base *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                            </div>
                                                            <input type="text" id="montBase" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Tipo de cambio *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                            </div>
                                                            <input type="text" id="typeChange" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Moneda *</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon11"><i class="ti-target"></i></span>
                                                            </div>
                                                            <select id="slctypeCurrency" class="form-control custom-select" data-placeholder="Selecciona el Giro de la empresa" tabindex="1">
                                                                <option value="-1">Selecciona una modena</option>
                                                                @foreach($currency as $item)
                                                                <option value="{!!$item->CurrencyISO!!}">{!!$item->CurrencyName!!} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">

                                                    <label class="control-label">Fecha de plan de trabajo*</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                        </div>
                                                        <input type="month" id="datePlan" class="form-control vigencia" value="{!!date('Y-m')!!}">
                                                    </div>
                                                </div>


                                                <div class="col-md-12 mt-4">
                                                    <div class="nav-small-cap mb-3">- - - Semana laboral</div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="pres" value="0" id="all">
                                                                    <label class="custom-control-label" for="all">Todos los días</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="pres" value="1" id="Lunes">
                                                                    <label class="custom-control-label" for="Lunes">Lunes</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="input-group">
                                                                <input id="slcLunes" class="form-control" type="number" name="quantity" min="1" max="8">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon11">Hrs
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="pres" value="2" id="Martes">
                                                                    <label class="custom-control-label" for="Martes">Martes</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="input-group">
                                                                <input id="slcMartes" class="form-control" type="number" name="quantity" min="1" max="8">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon11">Hrs
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="pres" value="3" id="Miercoles">
                                                                    <label class="custom-control-label" for="Miercoles">Mi&eacute;rcoles</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="input-group">
                                                                <input id="slcMiercoles" class="form-control" type="number" name="quantity" min="1" max="8">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon11">Hrs
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="pres" value="4" id="jueves">
                                                                    <label class="custom-control-label" for="jueves">Jueves</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="input-group">
                                                                <input id="slcJueves" class="form-control" type="number" name="quantity" min="1" max="8">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon11">Hrs
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="pres" value="5" id="viernes">
                                                                    <label class="custom-control-label" for="viernes">Viernes</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="input-group">
                                                                <input id="slcViernes" class="form-control" type="number" name="quantity" min="1" max="8">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon11">Hrs
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="pres" value="6" id="Sabado">
                                                                    <label class="custom-control-label" for="Sabado">Sábado</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="input-group">
                                                                <input id="slcSabado" class="form-control" type="number" name="quantity" min="1" max="8">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon11">Hrs
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="pres" value="7" id="Domingo">
                                                                    <label class="custom-control-label" for="Domingo">Domingo</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="input-group">
                                                                <input id="slcDomingo" class="form-control" type="number" name="quantity" min="1" max="8">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon11">Hrs
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 text-center">     
                                                        <div class="form-actions">
                                                            <div class="card-body">
                                                                <button type="button" class="btn btn-success" id="btn_addWorkPlan"> <i class="fa fa-check"></i> Agregar</button>
                                                            </div>
                                                        </div>                                      

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