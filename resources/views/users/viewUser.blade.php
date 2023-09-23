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
                            <h4 class="text-themecolor">Ver Usuarios</h4>
                        </div>
                        <div class="col-md-7 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                                    <li class="breadcrumb-item">Usuarios</li>
                                    <li class="breadcrumb-item active">Ver Usuario</li>
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
                                <h4 class="card-title">Usuarios</h4>
                                 <div class="row">  
                               
                                 </div>
                                <div class="table-responsive m-t-40" id="cotizacionesDiv">
                                    <table id="cotizaciones" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Usuario</th>
                                                <th>Tipo</th>
                                                <th>Color</th>
                                                <th>Correo</th>
                                                <th>Contrase&ntilde;a</th>
                                                <th>Extensión</th>
                                                <th>Permisos</th>
                                                <th>Editar</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                            @foreach($users as $usersInfo)
                                            <tr>
                                                <td>
                                                    <img src="/images/usuarios/{!! $usersInfo->image !!}" class="img-fluid" style="max-width: 60px;">
                                                </td>
                                            <td><a href="/viewProfileAgent/{!!$usersInfo->pkUser!!}">{!! $usersInfo->full_name !!} </a></td>
                                                <!--td>{!! $usersInfo->username !!} </td-->
                                                <td>{!! $usersInfo->type !!} </td>
                                                <td><div class="color-show" style="background-color:{{$usersInfo->color}};"></div> </td>
                                                <td>{!! $usersInfo->mail !!} </td>
                                                <td>{!! $usersInfo->password !!} </td>
                                                <td>{!! $usersInfo->phone_extension !!} </td>
                                                
                                                <td class="updatePermition text-center" data-id="{!!$usersInfo->pkUser !!}" style="cursor: pointer">
                                                   <span class="ti-clipboard"> </span>
                                                </td>
                                                 <td class="text-center updateUser" data-id="{!!$usersInfo->pkUser !!}" style="cursor: pointer">
                                                    <span class="ti-pencil"></span>
                                                 </td>
                                                 <td class="text-center">
                                                    <button class="btn btn-danger btn-sm btn_deleteUser" data-id="{!!$usersInfo->pkUser!!}"><span class="ti-close"></span></button> 
                                                 </td>
                                                 </tr>
                                                @endforeach
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>                              
                        </div>
                    </div>

                </div>

                <!-- End Page Content -->

            </div><!-- End Container fluid  -->
        </div><!-- End Page wrapper  -->
   <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditCategoria" class="modalEditCategoria"></button>
       <!-- Convertir -->
    <div class="modal fade modal-gde" id="modalEditCategoria" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
      <div class="modal-dialog modal-abrevius" id="modalEditCat" role="document">
       
      </div>
    </div>
        @include('includes.footer')
        <!-- End footer -->
    </div><!-- End Wrapper -->
    @include('includes.scripts')

    <!-- End scripts  -->

</body>
</html>