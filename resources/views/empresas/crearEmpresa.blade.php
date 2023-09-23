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
                        <h4 class="text-themecolor">Crear Nueva Empresa</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Empresas</li>
                                <li class="breadcrumb-item active">Crear Nueva Empresa</li>
                            </ol>
                        </div>
                    </div>
                </div>
@if($arrayPermition["addCompany"] == 1)
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
                                                    <label class="control-label">Nombre de la empresa (Razón Social) *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                                        </div>
                                                        <input type="text" id="firstName" class="form-control" placeholder="Persona Física o Moral">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">RFC</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                         <span class="input-group-text" id="basic-addon11"><i class="ti-bookmark"></i></span>
                                                        </div>
                                                        <input type="text" id="rfc" class="form-control" >
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
                                                        <input type="text" id="emailEmp" class="form-control" placeholder="correo">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Teléfono</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                         <span class="input-group-text" id="basic-addon11"><i class="ti-headphone-alt"></i></span>
                                                        </div>
                                                        <input type="text" id="phoneBussines" class="form-control" placeholder="Lada + número">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Página Web</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                         <span class="input-group-text" id="basic-addon11"><i class="ti-world"></i></span>
                                                        </div>
                                                        <input type="text" id="web" class="form-control" placeholder="http://">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Propietario</label>
                                                    <select id="propierty" class="form-control custom-select" data-placeholder="Agente para el que se asigna" tabindex="1">
                                                        <option value="-1">Selecciona un agente</option>
                                                        @foreach($agent as $agenInfo)
                                                        <option value="{!!$agenInfo->pkUser !!}">{!! $agenInfo->full_name !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>  
                                            <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label class="control-label">Domicilio</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-home"></i></span>
                                                        </div>
                                                        <input type="text" id="domicilio" class="form-control" placeholder="Calle, número y colonia">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                  <div class="form-group">
                                                    <label class="control-label">Ciudad *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-location-pin"></i></span>
                                                        </div>
                                                        <input type="text" id="city" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                   <div class="form-group">
                                                    <label class="control-label">Estado *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-map-alt"></i></span>
                                                        </div>
                                                         <input type="text" id="state" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                   <label class="control-label">País *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon11"><i class="ti-flag-alt-2"></i></span>
                                                        </div>
                                                           <input type="text" id="country" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Giro *</label>
                                                    <select id="giro" class="form-control custom-select" data-placeholder="Selecciona el Giro de la empresa" tabindex="1">
                                                       <option value="-1">Selecciona un giro</option>
                                                        @foreach($commercial_business as $item)
                                                        <option value="{!!$item->pkCommercial_business!!}">{!!$item->name!!}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Categoría *</label>
                                                    <select id="cat" class="form-control custom-select" data-placeholder="Elige Categoría" tabindex="1">
                                                        <option value="-1">Selecciona una categoría</option>
                                                        @foreach($categories as $item)
                                                        <option value="{!!$item->pkCategory!!}">{!!$item->name!!}</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Origen</label>
                                                    <select id="origen" class="form-control custom-select" data-placeholder="Elige Categoría" tabindex="1">
                                                        <option value="-1">Selecciona un origen</option>
                                                        @foreach($origin as $item)
                                                        <option value="{!!$item->pkBusiness_origin!!}">{!!$item->name!!}</option>
                                                      @endforeach
                                                    </select>
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
                                          
                                            <div class="col-12 ">
                                                <h3 class="title-section mb-4 mt-3">Agregar Contacto(s)</h3>
                                            </div>
                                            <div id="addContentContact">
                                                <div class="contentNewContact row px-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Nombres y Apellidos</label>
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
                                                    <div class="add-user"><button type="button" class="btn btn-secondary"  id="addMoreContact"><span class="ti-user"></span> Agregar Más Contactos</button></div>
                                                </div>
                                            </div>
                                           <input type="hidden" value="1"/>
                                        </div><!--/row-->
                                    </div>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <button type="button" class="btn btn-success" id="btn_addCompany"> <i class="fa fa-check"></i> Crear</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <!-- Campañas -->
                        <div class="card">
                            <div class="card-body">
                                Acceso denegado, no tiene permiso para esta seccion
                            </div>
                        </div>
                    </div>
                </div>
              @endif
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