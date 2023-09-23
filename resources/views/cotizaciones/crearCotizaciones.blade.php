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
                        <h4 class="text-themecolor">Crear Cotización</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Cotizaciones</li>
                                <li class="breadcrumb-item active">Crear Cotización</li>
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
                                        <!-- <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Nombre de la cotización</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-write"></i></span>
                                                  </div>
                                                  <input type="text" id="name" class="form-control">
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
                                                     <input autocomplete="off" type="text" data-id="-1" id="slcBussines" class="autocomplete_bussines form-control" placeholder="Escribe el nombre de la empresa">
                                                </div>
                                                   <div  class="search-header-bussines">
                                                    </div>
                                                    <div class="search__border"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="control-label">Contacto</label>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Agente a asignar</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-user"></i></span>
                                                  </div>
                                                  <select id="slcAgent" class="form-control custom-select" data-placeholder="Elige Agente" tabindex="1">
                                                     <option value="-1">Selecciona un Agente</option>
                                                    @foreach($agent as $item)
                                                    <option value="{{ $item->pkUser }}">{!! $item->full_name!!}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Nivel de interés</label>
                                                <select id="level" class="form-control custom-select" data-placeholder="Elige Nivel de interés" tabindex="1">
                                                    <option value="-1">Selecciona un nivel</option>
                                                    @foreach($level as $item)
                                                    <option value="{{ $item->pkLevel_interest }}">{!! $item->text!!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Forma de pago</label>
                                                <select id="slcPayment" class="form-control custom-select" data-placeholder="Elige el estatus" tabindex="1">
                                                  <option value="-1">Selecciona una forma de pago</option>
                                                    @foreach($payment as $item)
                                                    <option value="{{ $item->pkPayment_methods }}">{!! $item->name!!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                       <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Vigencia</label>
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                  </div>
                                                  <input type="date" id="vigency" class="form-control" placeholder="0">
                                                </div>
                                            </div>-->
                                        </div>
                                        <div class="col-md-12" id="addContentOPcion">
                                            <div class="contentNewOpcion">
                                            <div class="nav-small-cap mb-2">- - - OPCIONES</div>
                                                <div class="form-row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Cantidad de lugares</label>
                                                            <div class="input-group">
                                                              <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon11"><i class="fas fa-hashtag"></i></span>
                                                              </div>
                                                              <input type="number" id="qtyPlaces_1" data-id="1" class="form-control qtyPlaces">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Precio total</label>
                                                            <div class="input-group">
                                                              <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon11"><i class="ti-money"></i></span>
                                                              </div>
                                                              <input type="text" id="precio_1" class="form-control price" placeholder="$ 0.00">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo de precio</label>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input typePriceN" name="typePrice1"  value="0" id="rNormal">
                                                                <label class="custom-control-label" for="rNormal">Normal</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input typePriceP" name="typePrice1"  value="1" id="rPromo">
                                                                <label class="custom-control-label" for="rPromo">Promoción</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="control-label">Nueva Vigencia</label>
                                                        <div class="input-group">
                                                          <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-calendar"></i></span>
                                                          </div>
                                                          <input type="date" id="vigencia" class="form-control vigencia">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="count" value="2"/>
                                        <div class="col-12">
                                                <div class="form-group">
                                                    <div class="add-user"><button type="button" class="btn btn-secondary" id="addMoreOpcion"><span class="ti-plus"></span> Agregar Más Opciones</button></div>
                                                </div>
                                            </div>
                                        <div class="col-md-12 text-right">
                                            <button type="button" class="btn btn-success" id='btnCreateQuotation'><span class="ti-check"></span> Crear</button>
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