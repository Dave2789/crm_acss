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
                        <h4 class="text-themecolor">Empresas por Tipo</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Empresas por Tipo</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Detalle -->
                <div class="row">
                    <div class="col-12">
                        <div class="btn btn-primary f-right mb-3">
                            <a href="/" class="text-light" ><span class="ti-arrow-left"></span> Regresar</a>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <h3 class="title-section">Empresas <span class="italic">Tipo 1</span> de Junio 2019</h3>
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-hover no-wrap" id="empresasTipo">
                                    <thead>
                                        <tr>
                                            <th>Empresa</th>
                                            <th>Contacto</th>
                                            <th>Origen</th>
                                            <th>Categoría</th>
                                            <th>Giro</th>
                                            <th>Lead / Cliente</th>
                                            <th>Fecha de<br>último contacto</th>
                                            <th>Siguiente<br>actividad</th>
                                            <th>Vencimiento<br>siguiente actividad</th>
                                            <th>Perfil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img style="max-height: 30px;" src="{{ asset('assets/images/usuarios/user.jpg')}}" class="rounded-circle"> AppendCloud
                                            </td>
                                            <td>
                                                <div>Alan Arellano<br>
                                                    <small><span class="ti-email"></span> alan@appendcloud.com</small><br>
                                                    <small><span class="ti-mobile"></span> 333 333 2252</small>
                                                </div>
                                            </td>
                                            <td>Mailing</td>
                                            <td>Categoría 1</td>
                                            <td>Giro 1</td>
                                            <td class="text-center"><span class="text-success ti-check"></span></td>
                                            <td>25 Jun 19</td>
                                            <td><span class="badge" style="background-color:coral;">Llamada de cierre</span></td>
                                            <td>25 Jul 19</td>
                                            <td><a href="/detEmpresa"><span class="ti-bookmark"></span></a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img style="max-height: 30px;" src="{{ asset('assets/images/usuarios/user.jpg')}}" class="rounded-circle"> Empresa 2
                                            </td>
                                            <td>
                                                <div>Beatriz Valdez<br>
                                                    <small><span class="ti-email"></span> contacto@empresa2.com</small><br>
                                                    <small><span class="ti-mobile"></span> 332 525 2452</small>
                                                </div>
                                            </td>
                                            <td>Mailing</td>
                                            <td>Categoría 2</td>
                                            <td>Giro 3</td>
                                            <td class="text-center"><span class="text-danger ti-close"></span></td>
                                            <td>25 Jun 19</td>
                                            <td><span class="badge" style="background-color:pink;">Enviar cotización</span></td>
                                            <td>25 Jul 19</td>
                                            <td><a href="/detEmpresa"><span class="ti-bookmark"></span></a></td>
                                        </tr>
                                    </tbody>
                                </table>
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
    <script>
        $(function () {
            $('#empresasTipo').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });    
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
        });
    </script>
    <!-- End scripts  -->
    
</body>
</html>