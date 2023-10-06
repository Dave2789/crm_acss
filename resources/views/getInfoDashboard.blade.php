<div class="col-lg-6 col-sm-12 cuadros">
    <!-- Ventas -->
    <h3 class="title-section">Ventas</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>{!!$sales["total"]!!}  <span class="text-success f-right">$ {!!number_format($sales["mount"],2)!!}</span></h3>
                            <h6 class="card-subtitle">Realizadas</h6></div>
                        <div class="col-12">

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- Cotizaciones -->
    <h3 class="title-section">Cotizaciones <span class="text-right f-right"></span></h3>
    <div class="card-group">
        <div class="card">
            <!--<a href="/cotizacionesCerradas">-->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h3>{!!$quotationsClose["total"]!!} <span class="small">{!!round($quotationsClose["percent"],2)!!}%</span></h3>
                                <h6 class="card-subtitle">Pagadas</h6>
                                <h3 class="text-success mb-0">$ {!!number_format($quotationsClose["mount"],2)!!}</h3>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {!! round($quotationsClose['percent'],2)!!}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--</a>-->
        </div>
        <div class="card">
            <!--<a href="/cotizacionesAbiertas">-->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h3>{!!$quotationsOpen["total"]!!} <span class="small">{!!round($quotationsOpen["percent"],2)!!}%</span></h3>
                                <h6 class="card-subtitle">Abiertas</h6>
                                <h3 class="text-cyan mb-0">$ {!!number_format($quotationsOpen["mount"],2)!!}</h3>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-cyan" role="progressbar" style="width: {!!round($quotationsOpen['percent'],2)!!}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--</a>-->
        </div>
        <div class="card">
            <!--<a href="/cotizacionesDescartadas">-->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h3>{!!$quotationsRejected["total"]!!} <span class="small">{!!round($quotationsRejected["percent"],2)!!}%</span></h3>
                                <h6 class="card-subtitle">Descartadas</h6>
                                <h3 class="text-danger mb-0">$ {!!number_format($quotationsRejected["mount"],2)!!}</h3>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {!!  round($quotationsRejected['percent'],2)!!}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--</a>-->
        </div>
    </div>
    <!-- Oportunidades -->
    <h3 class="title-section">Oportunidades</h3>
    <div class="card-group">
        <div class="card">
            <!--<a href="/oportunidadesConvertidas">-->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>{!!$opportunitiesClose["total"]!!} <span class="small">{!!round($opportunitiesClose["percent"],2)!!}%</span></h3>
                            <h6 class="card-subtitle">Convertidas a cotización</h6>
                            <h3 class="text-success mb-0">$ {!!number_format($opportunitiesClose["mount"],2)!!}</h3>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {!! round($opportunitiesClose['percent'],2)!!}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--</a>-->
        </div>
        <div class="card">
            <!--<a href="/oportunidadesAbiertas">-->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>{!!$opportunitiesOpen["total"]!!} <span class="small">{!!round($opportunitiesOpen["percent"],2)!!}%</span></h3>
                            <h6 class="card-subtitle">Abiertas</h6>
                            <h3 class="text-cyan mb-0">$ {!!number_format($opportunitiesOpen["mount"],2)!!}</h3>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-cyan" role="progressbar" style="width: {!! round($opportunitiesOpen['percent'],2) !!}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--</a>-->
        </div>
        <div class="card">
            <!--<a href="/oportunidadesPerdidas">-->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>{!!$opportunitiesRejected["total"]!!} <span class="small">{!!round($opportunitiesRejected["percent"],2)!!}%</span></h3>
                            <h6 class="card-subtitle">Perdidas</h6>
                            <h3 class="text-danger mb-0">$ {!!number_format($opportunitiesRejected["mount"],2)!!}</h3>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {!!round($opportunitiesRejected['percent'],2) !!}%; height: 6px;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--</a>-->
        </div>
    </div>
</div>
<!-- Empresas -->
<div class="col-lg-6 col-sm-12 empresas-dash">
    <h3 class="title-section">Empresas</h3>
    <div class="row">
        <div class="col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-info"><i class="ti-layout-menu-v"></i> Nivel de interés en cotizaciones</h3>
                    <hr>
                    @foreach($levelInterestQuery as $levelInterestInfo)
                    <!--<a href="#">-->
                        <div class="d-flex no-block align-items-center">
                            <p class="text-muted">{!!$levelInterestInfo->text!!}</p>
                            <div class="ml-auto">
                                <h2 class="counter badge badge-pill text-white" style="background-color:{!!$levelInterestInfo->color !!}">
                                    @if(isset($arrayLevelInterest[$levelInterestInfo->pkLevel_interest]))
                                        {{ $arrayLevelInterest[$levelInterestInfo->pkLevel_interest]->nivel }}
                                    @else
                                        0
                                    @endif
                                </h2>
                            </div>
                        </div>
                    <!--</a>-->
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-purple"><i class="ti-layers"></i> Categorías</h3>
                    <hr>
                    @foreach($categoriesQuery as $categoriesInfo)
                    <!--<a href="/empresasTipo/{!! $categoriesInfo->pkCategory !!}">-->
                        <div class="d-flex no-block align-items-center">
                            <p class="text-muted">{!!$categoriesInfo->name!!}</p>
                            <div class="ml-auto">
                                <h2 class="counter text-purple">
                                    @if(isset($arrayCategories[$categoriesInfo->pkCategory]))
                                    {!!$arrayCategories[$categoriesInfo->pkCategory]!!}
                                    @else
                                    0
                                    @endif
                                </h2>
                            </div>
                        </div>
                    <!--</a>-->
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-cyan"><i class="ti-money"></i> Forma de Pago</h3>
                    <hr>
                    @foreach($paymentMethodsQuery as $paymentMethodsInfo)
                    <!--<a href="#">-->
                        <div class="d-flex no-block align-items-center">
                            <p class="text-muted">{!!$paymentMethodsInfo->name!!}</p>
                            <div class="ml-auto">
                                <h2 class="counter text-cyan">
                                    @if(isset($arrayPaymentMethods[$paymentMethodsInfo->pkPayment_methods]))
                                    {!!$arrayPaymentMethods[$paymentMethodsInfo->pkPayment_methods]!!}
                                    @else
                                    0
                                    @endif
                                </h2>
                            </div>
                        </div>
                    <!--</a>-->
                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-primary"><i class="ti-layout-menu-v"></i> Estatus</h3>
                    <hr>
                    <a href="/verEmpresasProspecto">
                        <div class="d-flex no-block align-items-center">
                            <p class="text-muted">Prospectos</p>
                            <div class="ml-auto">
                                <h2 class="counter badge badge-warning badge-pill">
                                    @if(isset($typeCountBusiness["prospect"]))
                                    {!!$typeCountBusiness["prospect"]!!}
                                    @else
                                    0
                                    @endif
                                </h2>
                            </div>
                        </div>
                    </a>
                    <a href="/verEmpresasLeads">
                        <div class="d-flex no-block align-items-center">
                            <p class="text-muted">Leads</p>
                            <div class="ml-auto">
                                <h2 class="counter badge badge-info badge-pill">
                                    @if(isset($typeCountBusiness["lead"]))
                                    {!!$typeCountBusiness["lead"]!!}
                                    @else
                                    0
                                    @endif
                                </h2>
                            </div>
                        </div>
                    </a>
                    <a href="/verEmpresasCliente">
                        <div class="d-flex no-block align-items-center">
                            <p class="text-muted">Clientes</p>
                            <div class="ml-auto">
                                <h2 class="counter badge badge-success badge-pill">
                                    @if(isset($typeCountBusiness["client"]))
                                    {!!$typeCountBusiness["client"]!!}
                                    @else
                                    0
                                    @endif
                                </h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>