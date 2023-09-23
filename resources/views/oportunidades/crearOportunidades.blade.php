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
                        <h4 class="text-themecolor">Crear Oportunidad de Negocio</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Oportunidad de Negocio</li>
                                <li class="breadcrumb-item active">Crear Oportunidad de Negocio</li>
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
                                         <!--  <div class="col-md-12">
                                          <div class="form-group">
                                                <label class="control-label">Nombre *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-light-bulb"></i></span>
                                                  </div>
                                                  <input type="text" id="name" class=" form-control">
                                                </div>
                                             
                                            </div>
                                            
                                        </div>-->
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="control-label">Empresa *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                                  </div>
                                                     <input autocomplete="off" type="text" data-id="-1" id="slcBussines" class="autocomplete_bussines form-control">
                                                </div>
                                                   <div  class="search-header-bussines">
                                                    </div>
                                                    <div class="search__border"></div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="control-label">Contacto *</label>
                                                <select id="slcContact" class="form-control custom-select" data-placeholder="Elige empresa" tabindex="1">
                                                    <option value="-1">Selecciona un contacto</option>
                                                </select>
                                            </div>
                                            
                                        </div>
                                         <div class="col-md-2">
                                              <div class="form-group">
                                                <button type="button" class="btn btn-success btn-addContact m-t-30">Agregar Contacto</button> 
                                              </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Cantidad de empleados</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>
                                                  </div>
                                                  <input id="qtyEmployee" type="number" class="form-control" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Curso *</label>
                                                <select id="slcCourse" class="form-control custom-select" data-placeholder="Elige Curso" tabindex="1" multiple>
                                                
                                                    @foreach($courses as $item)
                                                    <option value="{!! $item->pkCourses !!}">{!! $item->name!!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Cantidad de lugares *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>
                                                  </div>
                                                  <input id="qtyPlace_1" data-id="1" type="number" class="form-control qtyPlaces" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Agente *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                                                  </div>
                                                  <select id="slcAgent" class="form-control custom-select" data-placeholder="Elige Agente" tabindex="1">
                                                     <option value="-1">Selecciona un Agente</option>
                                                      @foreach($agent as $item)
                                                      <option value="{!! $item->pkUser !!}">{!! $item->full_name!!}</option>
                                                      @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Monto *</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                  </div>
                                                  <input  type="text" id="precio_1" class="form-control price" placeholder="$ 0.00">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Tiene presupuesto</label>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="pres" value="1" id="customradio1">
                                                    <label class="custom-control-label" for="customradio1">Sí</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="pres" value="0" id="customradio2">
                                                    <label class="custom-control-label" for="customradio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Necesidades y temores</label>
                                                <textarea id="necesites" class="form-control" cols="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Comentarios</label>
                                                <textarea id="comments" class="form-control" cols="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Nivel de interés *</label>
                                                <select id="level" class="form-control custom-select" data-placeholder="Elige Nivel de interés" tabindex="1">
                                                    <option value="-1">Selecciona un nivel</option>
                                                    @foreach($level as $item)
                                                    <option value="{!! $item->pkLevel_interest !!}">{!! $item->text!!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Forma de pago *</label>
                                                <select id="slcPayment" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
                                                  <option value="-1">Selecciona una forma de pago</option>
                                                    @foreach($payment as $item)
                                                    <option value="{!! $item->pkPayment_methods !!}">{!! $item->name!!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <button type="button" class="btn btn-success" id="createOportunity"><span class="ti-check"></span> Crear</button>
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

 <!-- Convertir -->
   <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modaladdContact" class="modaladdContact"></button>
    <div class="modal fade modal-gde" id="modaladdContact" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="modalAgentesCLabel">Nuevo contacto</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div id="addContentContact">
                  <div class="contentNewContact row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label">Nombre</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                                </div>
                                <input type="text" id="nameContact" class="form-control nameContact">
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label">Cargo / Puesto</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon11"><i class="ti-medall"></i></span>
                                </div>
                                <input type="text" id="cargo" class="form-control cargo">
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label">Correo</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon11"><i class="ti-email"></i></span>
                                </div>
                                <input type="email" id="email" class="form-control email">
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label">Teléfono fijo</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon11"><i class="ti-headphone-alt"></i></span>
                                </div>
                                <input type="text" id="phone" class="form-control phone" placeholder="Incluir código de área">
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label">Extensión</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon11"><i class="ti-plus"></i></span>
                                </div>
                                <input type="text" id="extension" class="form-control extension">
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="control-label">Teléfono móvil</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon11"><i class="ti-mobile"></i></span>
                                </div>
                                <input type="text" id="cel" class="form-control cel">
                              </div>
                          </div>
                      </div>
                  </div>  
              </div>
              <div class="col-12">
                  <div class="form-group">
                    <button type="button" class="btn btn-success"  id="addContactBussines"><span class="ti-check"></span> Crear Contacto</button>
                  </div>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalAddContact" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    @include('includes.scripts')

    <!-- End scripts  -->

</body>
</html>