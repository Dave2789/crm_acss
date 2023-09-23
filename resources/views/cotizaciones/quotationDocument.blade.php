<!DOCTYPE html>
<html lang="en">

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
                    <div class="card">
                        <div class="card-body">
                            <div class="row top-cot">
                                <div class="col-md-5 px-0">
                                    <img src="/images/logo-cot.png" class="img-fluid">
                                </div>
                                <div class="col-md-7 text-right">
                                    <h3 class="mt-3">Cotización # {{ $infoEmail->folio }}</h3>
                                    <p>Fecha: {{ $infoEmail->register_day }}</p>
                                    <hr class="hr-white-50">
                                </div>
                                <div class="col-md-12 text-center">
                                    <h2>{!! $infoEmail->name !!}</h2>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-8 col-sm-6 px-0">
                                    <div class="tit-cot">Producto</div>
                                </div>
                                <div class="col-md-2 col-sm-3 px-0">
                                    <div class="tit-cot">Cantidad</div>
                                </div>
                                <div class="col-md-2 col-sm-3 px-0">
                                    <div class="tit-cot">Precio</div>
                                </div>
                            </div>
                            @php $cont = 1; @endphp
                            @php $band = true; @endphp
                            @foreach($infoDetailQuotation as $infoDetail)
                            <div class="row">
                                <div class="col-md-8 col-sm-6 p-0">
                                    <div class="txt-cot">
                                        <div><strong>Opción {{$cont}}: </strong> {{ $infoDetail->type }}</div>
                                        <div>{{ $infoDetail->number_places }} lugares</div>
                                        @if($cont <= 1)
                                        <p class="mt-3">Para usar <a href="https://abrevius.com/paquete-por-volumen/">vía monedero</a> en cualquiera de los cursos disponibles en la plataforma abrevius.com, entre ellos:</p>
                                        @else
                                         <p class="mt-3">Para usarlos <a href="https://abrevius.com/paquete-por-volumen/">vía monedero</a> en cualquiera de los cursos el día y la hora que quiera durante un año o hasta agotar sus lugares en abrevius.com, entre ellos:</p>
                                        @endif
                                        @if(!empty(sizeof($cursesArray[$infoDetail->pkQuotations_detail])))
                                        @foreach($cursesArray[$infoDetail->pkQuotations_detail] as $infoCourse)

                                        <div class="row align-items-end">
                                            <div class="col-sm-8">
                                                <div class="line-dotted"><a href="{{$infoCourse->link}}">{{ $infoCourse->code }} {!! $infoCourse->name !!}</a></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="line-cot">   {{ $infoCourse->places }} lugares</div>
                                            </div>
                                        </div>

                                        @endforeach
                                        @else
                                        @php $band = false; @endphp

                                        @foreach($cursesArray[$infoDetail->pkQuotations_detail] as $infoCourse)
                                        @if(!empty(sizeof($infoCourse)))
                                        <div class="row align-items-end">
                                            <div class="col-sm-8">
                                                <div class="line-dotted"><a href="{{$infoCourse->link}}">{{ $infoCourse->code }} {!! $infoCourse->name !!}</a></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="line-cot">   {{ $infoCourse->places }} lugares</div>
                                            </div>
                                        </div>
                                         @endif
                                        @endforeach


                                        @endif
                                        <div class="row mt-3">
                                            <div class="col-sm-9 nota-cot">
                                                <ul>
                                                     @if($cont <= 1)
                                                    <li>*Precio Opción {{$cont}} vigente hasta el <span class="undeline">{{ $infoDetail->date }}</span>.</li>
                                                    <li>*Solo para cursos dentro de la plataforma <i>Abrevius.com</i></li>
                                                    @else
                                                     <li>*Precio de promoción Opción {{$cont}} vigente hasta el <span class="undeline">{{ $infoDetail->date }}</span>.</li>
                                                    <li>*Cantidad de lugares para agotarse dentro del periodo máximo de un año o antes,lo primero que suceda a partir de la fecha de compra.</li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="col-sm-3 text-center">
                                                <a href="https://abrevius.com/all-courses/"><i>Ver aquí catálogo de cursos disponibles</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-3 text-center p-0">
                                    <div class="txt-cot" style="padding-top: 70%;">{{ $infoDetail->number_places }} lugares</div>
                                </div>
                                <div class="col-md-2 col-sm-3 text-center p-0">
                                    <div class="txt-cot" style="padding-top: 50%;">
                                        <p>Total</p>
                                        <p>*$ {{ number_format( $infoDetail->price ,2) }}</p>
                                        @if($infoEmail->withIva == 1)
                                        <p><small>(IVA Incluido)</small></p>
                                       
                                        @else 
                                        <p><small>+ IVA</small></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @php $cont++; @endphp
                            @endforeach
                            <!--   -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="cond-cot">
                                        <h4 class="title-cond">Forma de pago  y condiciones:</h4>
                                        <ul>
                                            <li>Transferencia Bancaria / Pago anticipado <a href="https://abrevius.com/que-formas-de-pago-hay-disponibles/"><small>¿Qué otras formas de pago hay?</small></a></li>
                                            <li>Precios en MXP</li>
                                            <li>Aplica para cualquier curso disponible de la plataforma abrevius bajo los Términos y Condiciones comerciales establecidos. <a href="https://abrevius.com/cursos/Fichas/CatCursos.pdf">/Ver aquí catálogo de cursos disponibles</a></li>
                                        </ul>
                                    </div>

                                    <div class="cond-cot">
                                        <h4 class="title-cond">Realizar pago en:</h4>
                                        <p>En caso de favorecernos con su preferencia, su empresa podrá realizar el pago vía transferencia bancaria a los siguientes datos:<br>Abrevius, S.A. de C.V. - BBVA  /  Número de cuenta: 0111202383  / CLABE: 012 320 00111202383 3</p>
                                    </div>

                                    <div class="cond-cot">
                                        <h4 class="title-cond">Notificar pago:</h4>
                                        <p>Una vez realizada la transferencia favor de enviar al correo atencion@abrevius.com:</p>
                                        <ul>
                                            <li>El comprobante bancario</li>
                                            <li>Mencionar el numero de Cotización que está pagando</li>
                                            <li>Sus datos de facturación con alta del SAT (clientes nuevos)</li>
                                        </ul>
                                    </div>
                                    <div class="text-right">
                                        <a href="https://abrevius.com/cursos/Fichas/ventajas.pdf">Ventajas de tomar nuestros cursos</a>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <img src="/images/bottom-cot.jpg" class="img-fluid" style="min-width: 100%;">
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="btn-group f-right" style="display: block">
                                    <button class="btn btn-warning btn_viewQuotation" data-id="{{$infoEmail->pkQuotations }}">Editar</button>

                                    @if(!$band)
                                    @if($infoEmail->dropdown <= 0)
                                   <!-- <button class="btn btn-info btn-generate-breakdown" data-id="{{$infoEmail->pkQuotations }}">Generar desglose</button>-->
                                    @else
                                   <!--   <button class="btn btn-info btn-remove-breakdown" data-id="{{$infoEmail->pkQuotations }}">Remover desglose</button>-->
                                    @endif
                                    @endif
                                    <button class="btn btn-success btn-send-mail" data-open="0" data-id="{{$infoEmail->pkQuotations }}">Enviar correo</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- End Wrapper -->

        </div>

        <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditCategoria" class="modalEditCategoria"></button>
        <!-- Convertir -->
        <div class="modal fade modal-gde" id="modalEditCategoria" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
            <div class="modal-dialog modal-abrevius" id="modalEditCat" role="document">

            </div>
        </div>

        <button type="button" style="visibility: hidden" data-toggle="modal" data-target="#modalEditUsuario" class="modalEditUsuario"></button>
        <!-- Convertir -->
        <div class="modal fade modal-gde" id="modalEditUsuario" tabindex="-1" role="dialog" aria-labelledby="modalAgentesCLabel" aria-hidden="true">
            <div class="modal-dialog modal-abrevius" id="modalUsuario" role="document">

            </div>
        </div>
        @include('includes.footer')
        <!-- End footer -->

        @include('includes.scripts')
        <!-- End scripts  -->
    </body>


</html>
