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
                        <h4 class="text-themecolor">Env&iacute;o de Correos</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item">Correo</li>
                                <li class="breadcrumb-item active">Enviar correo</li>
                            </ol>
                        </div>
                    </div>
                </div> 
           @if($arrayPermition["sendMail"] == 1)
                <!-- Empresa -->
                <div class="row">
                    <div class="col-12">
                        <!-- Crear Empresa -->
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Nuevo correo</h3>
                                <div class="form-group">
                                    <input class="form-control" id="destinity" placeholder="Para:">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="subject" placeholder="Asunto:">
                                </div>
                                  <div class="form-group">
                                     <textarea class="textarea_editor form-control" id="message" rows="15" placeholder="Escriba su mensaje..."></textarea>
                                   </div>
                                 <div class="form-group">
                                       <div class="form-group">
                                                    <label class="control-label">Adjuntar documento del sistema</label>
                                                    <select id="document" class="form-control custom-select" data-placeholder="Agente para el que se asigna" tabindex="1">
                                                        <option value="-1">Selecciona un documento</option>
                                                        @foreach($document as $documentInfo)
                                                        <option value="{{$documentInfo->pkDocument }}">{!! $documentInfo->document !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                    </div>
                                  <div class="form-group">
                                        <label class="control-label"><i class="ti-link"></i> Adjuntar archivo desde su computadora</label>
                                        <input id="file" type="file" multiple />
                                    </div>
                                <button type="button" id="sendmail" class="btn btn-success m-t-20"><i class="fa fa-envelope-o"></i> Enviar</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
             @else
                <div class="row">
                    <div class="col-12">
                        <!-- Campañas -->
                        <div class="card">
                            <div class="card-body">
                                Acceso denegado, no tiene permiso para esta sección
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
    
 <script>
    $(document).ready(function() {
        $('.textarea_editor').wysihtml5();
    });
    </script>
    <!-- End scripts  -->

</body>
</html>