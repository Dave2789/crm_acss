<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.head')
    <link href="{{ asset('assets/css/pages/login-register-lock.css')}}" rel="stylesheet">
</head>

<body class="skin-default fixed-layout">
 
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Elite admin</p>
        </div>
    </div>
    <!-- Main wrapper - style you can find in pages.scss -->
    <section id="wrapper">
        <div class="login-register" style="background-image:url({{asset('assets/images/login2.jpg')}});">
            <div class="login-box card">
                <div class="login-logo">
                    <img src="{{asset('assets/images/logo-abrevius.png')}}" class="img-fluid"><img src="{{asset('assets/images/logo-abrevius-text.png')}}" class="img-fluid">
                    <p class="text-white mb-0">Call Center System</p>
                </div>
                <div class="card-body">
                    <form class="form-horizontal form-material" id="login-form" >
                        <h3 class="text-center m-b-20">Iniciar Sesión</h3>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" id="username" type="text" required="" placeholder="Usuario"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" id="password" type="password" required="" placeholder="Contraseña"> </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <button class="btn btn-block btn-lg btn-warning btn-rounded" type="submit">Ingresar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    @include('includes.scripts')
    <!-- End scripts  -->
</body>

</html>