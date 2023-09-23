<?php namespace App\Http\Controllers;

use DB;
use Input;

use App\Models\Alerts;
use App\Models\Users_per_alert;
use App\Models\Activities;
use Illuminate\Http\Request;

class BillingController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function generateInvoice() 
        {
            try{
                
                
                $usuario                    = '';
                $contrasenia                = '';
                $serie                      = 'A';
                $idTipoComprobante          = '1';
                $Fecha                      = '2019-09-16T09:00:00';
                $SubTotal                   = '100.00';
                $Moneda                     = 'MXN';
                $Total                      = '116.00';
                $FormaPago                  = '03';//catalogo
                $MetodoPago                 = 'PUE';//catalogo
                $CondicionesDePago          = '';//catalogo
               
                
                
                $url        = "http://devportal.kbill.mx/KbillService.svc?wsdl";
                $params     = array(
                                    'encoding' => 'UTF-8',
                                    'verifyhost' => false
                                );
                
                $client     = new \SoapClient($url, $params);
                
                $response   = $client->Emision([
                                                'usuario'             => 'demo2013', 
                                                'contrasenia'         => 'demo2019', 
                                                'serie'               => 'A', 
                                                'idTipoComprobante'   => '1', 
                                                'comprobanteCFDi'     => '{'
                                                                        . '"Fecha": "2019-09-30T09:10:23",'
                                                                        . '"SubTotal": "100.00",'
                                                                        . '"Moneda": "MXN",'
                                                                        . '"Total": "100.00",'
                                                                        . '"FormaPago": "01",'
                                                                        . '"MetodoPago": "PUE",'
                                                                        . '"CondicionesDePago": "Inmediatamente",'
                                                                        . '"TipoCambio": "1",'
                                                                        . '"Receptor": {'
                                                                        . '   "Rfc":  "CTR801211M15",'
                                                                        . '   "Nombre": "RAFAEL ALEJANDRO HERNÁNDEZ PALACIOS",'
                                                                        . '   "UsoCFDI": "G01"},'
                                                                        . '"Conceptos": {'
                                                                        . '   "Concepto": [{ '
                                                                        . '       "ClaveProdServ": "84111506",'
                                                                        . '       "ClaveUnidad": "ACT",'
                                                                        . '       "NoIdentificacion": "00001",'//Codigo del servicio o producto SKU
                                                                        . '       "Cantidad": "1",'
                                                                        . '       "Unidad":  "Servicio",'
                                                                        . '       "Descripcion": "Servicios de asesoramiento sobre la puesta en marcha de empresas nuevas",'
                                                                        . '       "ValorUnitario": "100",'
                                                                        . '       "Importe": "100",  '
                                                                        . '       "Impuestos": {'
                                                                        . '           "Traslados":  {'
                                                                        . '               "Traslado": [{'
                                                                        . '                   "Base": "100",'
                                                                        . '                   "Impuesto": "002",'
                                                                        . '                   "TipoFactor": "Tasa",'
                                                                        . '                   "TasaOCuota": "0.160000",'
                                                                        . '                   "Importe":  "16"'
                                                                        . '               }]'
                                                                        . '           },'
                                                                        . '           "Retenciones": {'
                                                                        . '               "Retencion": [{'
                                                                        . '                   "Base": "100",'
                                                                        . '                   "Impuesto": "002",'
                                                                        . '                   "TipoFactor": "Tasa",'
                                                                        . '                   "TasaOCuota":  "0.160000",'
                                                                        . '                   "Importe": "16"}]'
                                                                        . '           }'
                                                                        . '       }'
                                                                        . '   }]'
                                                                        . '}, '
                                                                        . '"Impuestos": {'
                                                                        . '   "TotalImpuestosRetenidos": "16",'
                                                                        . '   "TotalImpuestosTrasladados": "16",'
                                                                        . '   "Retenciones": {'
                                                                        . '       "Retencion": [{'
                                                                        . '           "Impuesto": "002",'
                                                                        . '           "Importe": "16"'
                                                                        . '       }]'
                                                                        . '   }, '
                                                                        . '   "Traslados": {'
                                                                        . '       "Traslado": [{'
                                                                        . '           "Impuesto": "002",'
                                                                        . '           "TipoFactor": "Tasa",'
                                                                        . '           "TasaOCuota": "0.160000",'
                                                                        . '           "Importe": "16"'
                                                                        . '       }]'
                                                                        . '   }'
                                                                        . '}'
                                                                        . '}'
                                                ]);
                
                dd($response);
            } catch (SoapFault $fail){
                
            }
            return "hola";
        }
        
        
        
        
	
}
