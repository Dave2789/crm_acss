<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Payment_methods;
use Illuminate\Http\Request;

class PaymentMethodsController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewPaymentMethods()
        {
            $paymentMethodsQuery    = DB::table("payment_methods")
                                    ->where('payment_methods.status','=',1)
                                    ->get();
            
            
            return view('catalogos.formasPago', ["paymentMethodsQuery" => $paymentMethodsQuery]);
        }
        
        public function addPaymentMethods (Request $request) 
        {
            $name = $request->input("name");
            
            
            $insertPaymentMethods = new Payment_methods;
            $insertPaymentMethods->name = htmlentities ($name);
            $insertPaymentMethods->status = 1;
            
            if($insertPaymentMethods->save()){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function viewupdatePaymentMethods(Request $request){
             $pkPayment_methods  = $request->input("pkPayment_methods");
            
            $pymentMethods   = DB::table('payment_methods')
                          ->select('pkPayment_methods'
                                  ,'name')
                          ->where('status','=',1)
                          ->where('pkPayment_methods','=',$pkPayment_methods)
                          ->first();
            
               $view = view('catalogos.editarFormasPago', array(
                    "pymentMethods" => $pymentMethods,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));      
        }
        
        public function updatePaymentMethods (Request $request) 
        {
            $pkPaymentMethods   = $request->input("idMethod");
            $name               = $request->input("name");
            
            $paymentMethodsUpdate   = DB::table("payment_methods")
                                    ->where('payment_methods.pkPayment_methods','=',$pkPaymentMethods)
                                    ->where('payment_methods.status','=',1)
                                    ->update(array("name" => $name));
            
            if($paymentMethodsUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function deletePaymentMethods (Request $request) 
        {
            $pkPaymentMethods         = $request->input("pkPaymentMethod");
            
            $paymentMethodsUpdate   = DB::table("payment_methods")
                                    ->where('payment_methods.pkPayment_methods','=',$pkPaymentMethods)
                                    ->where('payment_methods.status','=',1)
                                    ->update(array("status" => 0));
            
            if($paymentMethodsUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
	
}
