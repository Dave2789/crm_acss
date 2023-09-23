<!DOCTYPE>
<html>
    <head>
        <meta charset="UTF-8"> 
        <title>Correo de Formulario</title>        
          <style>
            body{
                background-color:#fff;
                color:#000000;
                font-family: san-serif, Helvetica;
                padding: 0;
                margin: 0;
            }
            td{
                padding:5px;
                text-align:center;
                width:auto;
                font-size: 13px;
            }
            th{
                text-align:center;
                color:#FFF;
                background-color:#184383;
                font-size:14px;
                font-family: Helvetica;
                font-weight: 300;
            }
            td .txtP{
                color:#000;
                background-color:#efeeee;
                width:200px;
            }
            table .contenido {
                text-align:left;
            }
            .contenido td{
                text-align:right;
                font-size: 15px;
            }
            td .txt{
                color:#333;
                background-color:#fff;
                width:100%;
            }
            td .titulo{
                text-align:right;
                color:#184383;
                background-color:#fff;
                font-size:14px;
            }
            .link {
                border-bottom: 2px solid #184383;
                padding: 5px 15px;
                color: #184383;
                text-decoration: none;
                line-height: 1;
                text-align: center;
                font-size: 14px;
                border-radius: 0;
            }
            .link:hover {
                border-bottom: 2px solid #af853c;
            }
        </style>
    </head>
    <body>
        <table style='border-top: 5px solid #184383;text-align: center;min-width: 100%;'>
            <tr>
                <td align='center'>
                    <img src='https://abrevius.com/wp-content/uploads/2016/05/abrevius-logo-dakve.png' width='187' height='68' alt='logo' border='0'/>
                </td>
            </tr>
        </table>

        <table align='center' style='padding:10px; max-width: 600px;border-top: 1px solid #184383;'>
            <tr>
                <td align='center' valign='top'>
                    <br>
                    <table border='0' align='center' cellpadding='0' cellspacing='0'>
                        <tr>
                            <td>
                                <p style='text-align:center; font-size:18px;'><strong>Cotización folio: {!! $fkQuotation !!} cerrada</br>
                                    </strong> </p>
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td>
                                <table id="tableVerDetPedidosV" class="display">
                                                            <thead>
                                                                <tr>
                                                                    <th>Monto</th>
                                                                    <th>Lugares</th>
              
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                         
                                                                <tr>
                                                                    <td class='txtP'>{{ number_format($mont,2) }}</td>
                                                                    <td class='txtP'>{{ $places }}</td>
                                                                </tr>
                                                           
                                                            </tbody>
                                                        </table>
                            </td></tr>

                        
                    </table>
        </table>
    </body>
</html>