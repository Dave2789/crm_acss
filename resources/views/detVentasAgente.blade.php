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
                        <h4 class="text-themecolor">Reporte de Ventas Realizadas por Agente</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte de Ventas Realizadas por Agente</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Detalle -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> <img src="{{ asset('assets/images/users/5.jpg')}}" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10">Juan López</h4>
                                    <h6 class="card-subtitle">Vendedor</h6>
                                    <div class="text-left">
                                        <a href="javascript:void(0)" class="link"><i class="ti-stats-up"></i> Ventas 
                                            <span class="f-right">
                                                <font class="font-medium text-success">254 </font>
                                                <font class="font-medium text-danger"> 24</font>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="text-left">
                                        <a href="javascript:void(0)" class="link"><i class="ti-write"></i> Cotizaciones 
                                            <span class="f-right">
                                                <font class="font-medium text-success">154 </font>
                                                <font class="font-medium text-info"> 9</font>
                                                <font class="font-medium text-danger"> 14</font>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="text-left">
                                        <a href="javascript:void(0)" class="link"><i class="ti-light-bulb"></i> Oportunidades de negocio 
                                            <span class="f-right">
                                                <font class="font-medium text-success">54 </font>
                                                <font class="font-medium text-info"> 24</font>
                                                <font class="font-medium text-danger"> 14</font>
                                            </span>
                                        </a>
                                    </div>
                                </center>
                            </div>
                            <div><hr> </div>
                            <div class="card-body">
                                <h5 class="card-title">Actividades pendientes</h5>
                                <div class="steamline m-t-40">
                                    <div class="sl-item">
                                        <div class="sl-left bg-info"> <i class="ti-email"></i></div>
                                        <div class="sl-right">
                                            <div class="font-medium">
                                                <a href="/calendario" class="a-black">Email a vendedores </a>
                                                <a href="" class="ml-2">
                                                    <span class="px-1 text-success float-right"><i class="ti-check"></i></span>
                                                </a>
                                                <span class="badge badge-pill badge-danger float-right">Urgente</span>
                                            </div>
                                            <p>Enviar correo con plan mensual</p>
                                            <p>
                                                <small class="text-muted"><i class="ti-calendar"></i> 11 Jun 2019, 11:00 am</small>
                                                <small class="pl-2 text-muted"><i class="ti-user"></i> Juan López</small>
                                                <small class="pl-2 text-muted"><i class="ti-bookmark"></i> AppendCloud</small> 
                                            </p>
                                        </div>
                                    </div>
                                    <div class="sl-item">
                                        <div class="sl-left bg-info"><i class="ti-email"></i></div>
                                        <div class="sl-right">
                                            <div class="font-medium">
                                                <a href="/calendario" class="a-black">Enviar documentos a Empresa 2 </a>
                                                <a href="" class="ml-2">
                                                    <span class="px-1 text-success float-right"><i class="ti-check"></i></span>
                                                </a>
                                                <span class="badge badge-pill badge-warning float-right">Hoy</span>
                                            </div>
                                            <p>Enviar factura de último pago</p>
                                            <p>
                                                <small class="text-muted"><i class="ti-calendar"></i> 11 Jun 2019, 04:00 pm</small>
                                                <small class="pl-2 text-muted"><i class="ti-user"></i> Karla Ramírez</small>
                                                <small class="pl-2 text-muted"><i class="ti-bookmark"></i> AppendCloud</small> 
                                            </p>
                                        </div>
                                    </div>
                                    <div class="sl-item">
                                        <div class="sl-left bg-success"> <i class="ti-user"></i></div>
                                        <div class="sl-right">
                                            <div class="font-medium">
                                                <a href="/calendario" class="a-black">Visitar AppendCloud </a>
                                                <a href="" class="ml-2"><span class="px-1 text-success float-right"><i class="ti-check"></i></span></a>
                                                <span class="badge badge-pill badge-info float-right">Después</span>
                                            </div>
                                            <p>Visita para mostrar cursos</p>
                                            <p>
                                                <small class="text-muted"><i class="ti-calendar"></i> 12 Jun 2019, 11:00 am</small>
                                                <small class="pl-2 text-muted"><i class="ti-user"></i> Juan López</small>
                                                <small class="pl-2 text-muted"><i class="ti-bookmark"></i> AppendCloud</small> 
                                            </p>
                                        </div>
                                    </div>
                                    <div class="sl-item">
                                        <div class="sl-left bg-warning"> <i class="ti-mobile"></i></div>
                                        <div class="sl-right">
                                            <div class="font-medium">
                                                <a href="/calendario" class="a-black">Llamar a empresa 3</a>
                                                <a href="" class="ml-2">
                                                    <span class="px-1 text-success float-right"><i class="ti-check"></i></span>
                                                </a>
                                                <span class="badge badge-pill badge-info float-right">Después</span>
                                            </div>
                                            <p>Llamar por la tarde unicamente</p>
                                            <p>
                                                <small class="text-muted"><i class="ti-calendar"></i> 13 Jun 2019, 11:00 am</small>
                                                <small class="pl-2 text-muted"><i class="ti-user"></i> Juan López</small>
                                                <small class="pl-2 text-muted"><i class="ti-bookmark"></i> AppendCloud</small> 
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="f-right">
                                    <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Agregar actividad</button>
                                </div>
                            </div>
                            <div><hr> </div>
                            <div class="card-body">
                                <h5 class="card-title">Últimas acciones registradas</h5>
                                <div class="message-box">
                                    <div class="message-widget message-scroll">
                                        <!-- Message -->
                                        <a href="javascript:void(0)">
                                            <div class="user-img">
                                                <span class="round"><i class="ti-mobile"></i></span>
                                                <span class="profile-status away pull-right"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>Llamada a AppendCloud</h5>
                                                <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem
                                                    Ipsum has been.</span>
                                                <p>
                                                    <small class="text-muted"><i class="ti-calendar"></i> 13 Jun 2019, 11:00 am</small>
                                                    <small class="pl-2 text-muted"><i class="ti-bookmark"></i> AppendCloud</small> 
                                                </p>
                                                <span class="time">No contestó</span>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)">
                                            <div class="user-img">
                                                <span class="round"><i class="ti-mobile"></i></span>
                                                <span class="profile-status away pull-right"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>Llamada a Empresa 2</h5>
                                                <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem
                                                    Ipsum has been.</span>
                                                <p>
                                                    <small class="text-muted"><i class="ti-calendar"></i> 13 Jun 2019, 11:00 am</small>
                                                    <small class="pl-2 text-muted"><i class="ti-bookmark"></i> Empresa 2</small> 
                                                </p>
                                                <span class="time">Venta</span>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)">
                                            <div class="user-img">
                                                <span class="round"><i class="ti-email"></i></span>
                                                <span class="profile-status away pull-right"></span>
                                            </div>
                                            <div class="mail-contnet">
                                                <h5>Email a Empresa 3</h5>
                                                <span class="mail-desc">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem
                                                    Ipsum has been.</span>
                                                <p>
                                                    <small class="text-muted"><i class="ti-calendar"></i> 13 Jun 2019, 11:00 am</small>
                                                    <small class="pl-2 text-muted"><i class="ti-bookmark"></i> Empresa 3</small> 
                                                </p>
                                                <span class="time">Llamar por la tarde</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div>
                                <div class="btn btn-primary btn-sm f-right m-2">
                                <a href="/" class="text-light" ><span class="ti-arrow-left"></span> Regresar</a>
                                </div>
                            </div>
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-sm-4 col-12">
                                        <h3>Junio 2019</h3>
                                        <h5 class="font-light m-t-0">Reporte mensual</h5>
                                    </div>
                                    <div class="col-sm-4 col-6 align-self-center display-6 text-right">
                                        <h2 class="text-success">$83,690</h2>
                                    </div>
                                    <div class="col-sm-4 col-6 align-self-center text-right">
                                        <select class="form-control b-0">
                                            <option>Enero</option>
                                            <option value="1">Febrero</option>
                                            <option value="2" selected="">Junio</option>
                                            <option value="3">Abril</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Fecha</th>
                                            <th>Cantidad</th>
                                            <th>Lugares</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">Empresa 2</td>
                                            <td>15-Jun-19</td>
                                            <td><span class="badge badge-success badge-pill">20</span> </td>
                                            <td>250</td>
                                            <td><span class="text-success">$58,004.00</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Empresa 3</td>
                                            <td>15-Jun-19</td>
                                            <td><span class="badge badge-success badge-pill">2</span> </td>
                                            <td>40</td>
                                            <td><span class="text-success">$18,004.00</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Empresa 4</td>
                                            <td>15-Jun-19</td>
                                            <td><span class="badge badge-success badge-pill">1</span> </td>
                                            <td>580</td>
                                            <td><span class="text-success">$8,004.00</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
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