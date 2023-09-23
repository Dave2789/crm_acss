<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Abrevius</p>
    </div>
</div>
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- Logo -->
        <div class="navbar-header">
            @if(Session::get("fkUserType") == 1)
            <a class="navbar-brand" href="/dashboard">
                <b>
                    <!-- Light Logo icon -->
                    <img src="{{asset ('assets/images/logo-abrevius.png')}}" alt="Abrevius" class="light-logo" />
                </b>
                <!-- Logo text -->
                <span>  
                    <img src="{{asset ('assets/images/logo-abrevius-text.png')}}" class="light-logo" alt="Abrevius" style="min-height:35px;margin-top:-10px;" /></span> 
            </a>
            @else
           @if(Session::get("fkUserType") == 12)
             <a class="navbar-brand" href="/verCotizaciones">
                <b>
                    <!-- Light Logo icon -->
                    <img src="{{asset('assets/images/logo-abrevius.png')}}" alt="Abrevius" class="light-logo" />
                </b>
                <!-- Logo text -->
                <span>  
                    <img src="{{asset('assets/images/logo-abrevius-text.png')}}" class="light-logo" alt="Abrevius" style="min-height:35px;margin-top:-10px;" /></span> 
            </a>
            @else
             <a class="navbar-brand" href="/viewProfileAgent/{{ Session::get('pkUser') }}">
                <b>
                    <!-- Light Logo icon -->
                    <img src="{{asset('assets/images/logo-abrevius.png')}}" alt="Abrevius" class="light-logo" />
                </b>
                <!-- Logo text -->
                <span>  
                    <img src="{{asses('assets/images/logo-abrevius-text.png')}}" class="light-logo" alt="Abrevius" style="min-height:35px;margin-top:-10px;" /></span> 
            </a>
            @endif
            @endif
        </div>

        <!-- End Logo  -->
        <div class="navbar-collapse">
            <!-- toggle and nav items -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                @if( (Session::get("isAdmin") == 1) || (Session::get("permition")->permition->companySearch == 1))
                <li>
                    <!--buscador reemplazar por el de la plantilla-->
                    <div class="search">
                        <div class="search__form app-search d-none d-md-block d-lg-block">
                            <input class="search__input main-input-text-search-header form-control" name="search" placeholder="Buscar empresas" aria-label="Site search" type="text" autocomplete="off">
                            <div  class="search-header">

                            </div>
                            <div class="search__border"></div>

                        </div>
                    </div>
                    <!--buscador reemplazar por el de la plantilla-->
                </li>
                @endif
            </ul>

            <!-- User profile and search -->
            <ul class="navbar-nav my-lg-0">
                <!-- Comment -->
                 @if( (Session::get("isAdmin") == 1) || (Session::get("permition")->permition->notification == 1))
                <li class="nav-item dropdown viewDetailNotification" >
                    <a class="nav-link dropdown-toggle waves-effect waves-dark viewDetailNotification" id="viewDetailNotification" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-comment"></i>
                                <div class="notify viewDetailNotification"> 
                                    <span class="heartbit">
                            
                            </span> <span class="point"></span>
                                </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown notificationUser viewDetailNotification">
                     
                    </div>
                </li><!-- End Comment -->
                @endif
                <!-- User Profile -->
                <li class="nav-item dropdown u-pro">
                    @if(!empty(Session::get('image')))
                    <a class="nav-link waves-effect waves-dark profile-pic" href="/viewProfileAgent/{{Session::get('pkUser')}}"><img src="/images/usuarios/{{Session::get('image')}}" alt="Usuario" class=""> Mi perfil</a>
                    @else 
                    <a class="nav-link waves-effect waves-dark profile-pic" href="/viewProfileAgent/{{Session::get('pkUser')}}"><img src="/images/usuarios/user.jpg" alt="Usuario" class=""> Mi perfil</a>
                    @endif
                </li>
                <!-- End User Profile -->
                <li class="nav-item"> <a class="nav-link  waves-effect waves-light" href="/logout"><i class="fa fa-power-off text-danger"></i></a></li>
             <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
            </ul>
        </div>
        
    </nav>
</header>
