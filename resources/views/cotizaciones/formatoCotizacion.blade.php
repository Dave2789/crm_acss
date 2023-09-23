<!DOCTYPE html>
<html lang="es">

<head>
    <!--@include('includes.head')-->
</head>
<style type="text/css">
  .top-cot {
    background: #ffdc00 !important;
  }
  .tit-cot {
    background-color: #e9ecef;
    color: #666;
    text-align: center;
    padding: 5px;
    line-height: 1.1;
    font-size: 14px;
    font-weight: 600;
    border: 1px solid #dadada;
  }
  .hr-white-50 {
    border-top: 2px solid #ffffff;
    width: 50%;
    float: right;
  }
  .txt-cot {
    background-color: #ffffff;
    color: #666;
    padding: 5px;
    font-size: 14px;
    font-weight: 400;
    border: 1px solid #dadada;
    height: 100%;
}

.line-dotted {
    margin-bottom: 5px;
}
.line-cot {
    margin-bottom: 5px;
    background-color: #ffffff;
}
.line-dotted:after {
    content: "";
    border-bottom: 1px dotted #666;
    position: absolute;
    width: 90%;
    margin-top: 15px;
    margin-left: 5px;
}
.title-cond {
    background: #ffdc00;
    color: #666;
    text-align: left;
    padding: 5px;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.1;
}
.br-txt {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal !important;
}
.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -10px;
    margin-left: -10px;
}
.align-items-end {
    align-items: flex-end!important;
}
.col-sm-8 {
    flex: 0 0 66.66667%;
    max-width: 66.66667%;
}
.col-sm-4 {
    flex: 0 0 33.33333%;
    max-width: 33.33333%;
}
.col-md-5 {
    flex: 0 0 41.66667%;
    max-width: 41.66667%;
    position: relative;
}
.col-12, .col-md-12 {
    flex: 0 0 100%;
    max-width: 100%;
}
.img-fluid {
    max-width: 100%;
    height: auto;
}
.text-right {
    text-align: right!important;
}
.col-md-7 {
    flex: 0 0 58.33333%;
    max-width: 58.33333%;
}
.text-center {
    text-align: center!important;
}
.col-md-7 {
    flex: 0 0 58.33333%;
    max-width: 58.33333%;
}
</style>

<body class="skin-default fixed-layout">
  <!-- Main wrapper - style you can find in pages.scss -->
  <div id="main-wrapper">
    <!-- @include('includes.header')-->
    <!-- End Topbar header -->

    <!-- @include('includes.sidebar')-->
    <!-- End Left Sidebar  -->

    <!-- Page wrapper  -->
    <div class="page-wrapper">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <div class="row top-cot">
              <div class="col-md-5 px-0">
                <img src="images/logo-cot.png" class="img-fluid">
              </div>
              <div class="col-md-7 text-right">
                <h3 class="mt-3">Cotización # 000</h3>
                <p>Fecha: dd/mmm/aaaa</p>
                <hr class="hr-white-50">
              </div>
              <div class="col-md-12 text-center">
                <h2>Empresa Tal, S.A. de C.V</h2>
              </div>
            </div>
            <div>
              <table id="" class="" style="width:100%;">
                <thead>
                  <tr>
                    <th class="tit-cot">Producto</th>
                    <th class="tit-cot">Cantidad</th>
                    <th class="tit-cot">Precio</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="txt-cot">
                      <div >
                        <div><strong>Opción 1:</strong> Precio normal</div>
                        <div>40 lugares</div>
                        <p class="mt-3">Para usar <a href="#">vía monedero</a> en cualquiera de los cursos disponibles en la plataforma abrevius.com, entre ellos:</p>
                        <div class="row align-items-end">
                          <div class="col-sm-8">
                            <div class="line-dotted">C000 Seguridad en Solo para cursos dentro de la plataforma blablabalabal</div>
                          </div>
                          <div class="col-sm-4">
                            <div class="line-cot">/ XX lugares</div>
                          </div>
                        </div>
                        <div class="row align-items-end">
                          <div class="col-sm-8">
                            <div class="line-dotted">C000 Seguridad en C000 Seguridad en Solo para cursos dentro de la plataforma blablabalabal</div>
                          </div>
                          <div class="col-sm-4">
                            <div class="line-cot">/ XX lugares</div>
                          </div>
                        </div>
                        <div class="row align-items-end">
                          <div class="col-sm-8">
                            <div class="line-dotted">C000 Seguridad en </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="line-cot">/ XX lugares</div>
                          </div>
                        </div>
                        <div class="row align-items-end">
                          <div class="col-sm-8">
                            <div class="line-dotted">C000 Seguridad en C000 Seguridad en </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="line-cot">/ XX lugares</div>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <div class="col-sm-9 nota-cot">
                            <ul>
                              <li>*Precio Opción 1 vigente hasta el <span class="undeline">30 de octubre, 2019</span>.</li>
                              <li>*Solo para cursos dentro de la plataforma <i>Abrevius.com</i></li>
                            </ul>
                          </div>
                          <div class="col-sm-3 text-center">
                            <a href="#"><i>Ver aquí catálogo de cursos disponibles</i></a>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="txt-cot" style="position: relative;z-index:1;">
                      <div style="padding-top: 70%;">40 lugares</div>
                    </td>
                    <td class="txt-cot" style="position: relative;z-index:2;">
                      <div  style="padding-top: 50%;">
                        <p>Total</p>
                        <p>*$0,000.00</p>
                        <p><small>(IVA Incluido)</small></p>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="row mt-3">
              <div class="col-12">
                <div class="cond-cot">
                  <h4 class="title-cond">Forma de pago  y condiciones:</h4>
                  <ul>
                    <li>Transferencia Bancaria / Pago anticipado <a href="#"><small>¿Qué otras formas de pago hay?</small></a></li>
                    <li>Precios en MXP</li>
                    <li>Aplica para cualquier curso disponible de la plataforma abrevius bajo los Términos y Condiciones comerciales establecidos. <a href="#">/Ver aquí catálogo de cursos disponibles</a></li>
                  </ul>
                </div>

                <div class="cond-cot">
                  <h4 class="title-cond">Realizar pago en:</h4>
                  <p>En caso de favorecernos con su preferencia, su empresa podrá realizar el pago vía transferencia bancaria a los siguientes datos:<br>Abrevius, S.A. de C.V. - BBVA  /  Número de cuenta: 0111202383  / CLABE: 012 320 00111202383 3</p>
                </div>

                <div class="cond-cot">
                  <h4 class="title-cond">Notificar pago:</h4>
                  <p>Una vez realizada la transferencia favor de enviar al correo administracion@abrevius.com:</p>
                  <ul>
                    <li>El comprobante bancario</li>
                    <li>Mencionar el numero de Cotización que está pagando</li>
                    <li>Sus datos de facturación con alta del SAT (clientes nuevos)</li>
                  </ul>
                </div>
                <div class="text-right">
                  <a href="#">Ventajas de tomar nuestros cursos</a>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <img src="/images/bottom-cot.jpg" class="img-fluid" style="min-width: 100%;">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Wrapper -->

  </div>
  <!-- @include('includes.footer')-->
  <!-- End footer -->

  <!-- @include('includes.scripts')-->
  <!-- End scripts  -->
</body>


</html>
