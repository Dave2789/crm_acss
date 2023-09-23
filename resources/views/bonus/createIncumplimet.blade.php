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
                        <h4 class="text-themecolor">Configurar Capacitaci&oacute;n</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Capacitaci&oacute;n</li>
                                <li class="breadcrumb-item active">Configurar Capacitaci&oacute;n</li>
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

                                          <div  id="courses">
                                              <div class="contentNewOpcion" >
                                                  <div class="row">   
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Curso</label>
                                                    
                                                     <select id="slcCourse" class="form-control custom-select slcCourse"  tabindex="1">
                                                            <option value="-1">Seleccione un curso</option>
                                                        @foreach($courses as $item)
                                                        <option value="{{$item->pkCourses}}">{!!$item->code!!} - {!!$item->name!!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Otro</label>
                                                    <div class="input-group">
                                                        <input type="text" id="other" class="form-control other">
                                                        <div class="input-group-append">
                                                          
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                             <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Penalizaci&oacute;n *</label>
                                                    <div class="input-group">
                                                        <input type="text" id="penality" class="form-control penality">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon11">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                      
                                                  <div class="col-md-3">

                                                      <div class="form-group">
                                                          <label class="control-label">Fecha Límite</label>
                                                          <div class="input-group">
                                                              <div class="input-group-prepend">
                                                                  <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                              </div>
                                                              <input type="date" id="date_1" class="form-control date">
                                                          </div>
                                                      </div>   
                                                  </div>
                                                      
                                                      <div class="col-md-2">

                                                      <div class="form-group">
                                                          <label class="control-label">Hora Límite</label>
                                                          <div class="input-group">
                                                             <input class="form-control hour" type="time" id="hour_1" >
                                                          </div>
                                                      </div>   
                                                  </div>
                                                     
                                             
                                              </div>
                                              </div>
                                          </div>
                                             <input type="hidden" id="count" value="2"/>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="add-user"><button type="button" class="btn btn-secondary" id="addMoreCourses"><span class="ti-plus"></span> Agregar Más Cursos</button></div>
                                                </div>
                                            </div>
                                            
                                               <!-- <div class="col-md-6">

                                               <label class="control-label">Mes para ver cursos*</label>
                                               <div class="input-group">
                                                   <div class="input-group-prepend">
                                                       <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                   </div>
                                                   <input type="month" id="dateBon" class="form-control vigencia" value="{{date('Y-m')}}">
                                               </div>
                                           </div>-->
                                           
                                           <div class="col-12 text-center">
                                               <div class="form-actions mt-3">
                                                    <button type="button" class="btn btn-success" id="btn_addCapacitation"> <i class="fa fa-check"></i> Agregar</button>
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