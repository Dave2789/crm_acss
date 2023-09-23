<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Alerts;
use App\Models\Users_per_alert;
use App\Models\Activities;
use Illuminate\Http\Request;

class InvoiceController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewInvoice($pkQuotation) {
            
            $quotation = DB::table('quotations as q')
                           ->join('business as b','b.pkBusiness','=','q.fkBusiness')
                           ->join('quotations_detail as d','d.fkQuotations','=','q.pkQuotations')
                           ->select('q.pkQuotations'
                                   ,'b.name'
                                   ,'b.address'
                                   ,'b.rfc'
                                   ,'q.folio'
                                   ,'q.final_date'
                                   ,'d.price'
                                   ,'q.cfdi'
                                   ,'d.number_places')
                           ->where('d.isSelected','=',1)
                           ->where('q.pkQuotations','=',$pkQuotation)
                           ->first();
            
           return view('invoice.Viewinvoice')->with('quotation',$quotation);
        }
        
        public function invoiceQuotation(Request $request){
           
            $pkQuotation   = $request->input("idQuotation");
            
            $startDateUTC = date("Y-m-d H:i:s");
            $DateTime = explode(" ", $startDateUTC);
           
            $flag               = "true";
            $message            = "true";
            DB::beginTransaction();
             
            try { 

                   $updateQuotation = DB::table("quotations")
                                      ->where("pkQuotations", "=" ,$pkQuotation)
                                      ->update(['quotations_status'   => 7]);   
                 
                if($updateQuotation >= 1){
                                      
                  $quotationres = DB::table('quotations')
                             ->select('fkBusiness'
                                     ,'fkUser'
                                     ,'folio')
                             ->where('status','=',1)
                             ->where('pkQuotations','=',$pkQuotation)
                             ->first();
                  

                    $insertActivity = new Activities;
                    $insertActivity->fkBusiness = $quotationres->fkBusiness;
                    $insertActivity->fkUser = $quotationres->fkUser;
                    $insertActivity->fkActivities_type = -2;
                    $insertActivity->description = "Cotización # ".$quotationres->folio." Facturada";
                    $insertActivity->register_date = $DateTime[0];
                    $insertActivity->register_hour = $DateTime[1];
                    $insertActivity->document = "";
                    $insertActivity->status = 1;
                 
                    if ($insertActivity->save()) {
                        
                        /*$bond = DB::table('bond_base')
                                   ->select('pkBond_base')
                                   ->where('')*/
                        
                    } else {
                        $flag = "false";
                        $message .= "Error al cargar actividad \n";
                    }

                    
                }else{
                 $flag = "false";
                 $message = "error al modificar estado";
                }

                if($flag == "true"){
                  
                    
                    DB::commit();
                    return "true";
                }else{
                    DB::rollback(); 
                    return $message;
                }
          } catch (\Exception $e) {
                DB::rollback(); 
                //return "Error del sistema, favor de contactar al desarrollador";
                return $e->getMessage();
          }     
        }
        
	
}
