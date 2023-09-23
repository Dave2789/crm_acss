<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Business_type;
use App\Models\Business_origin;
use Illuminate\Http\Request;

class BusinessOriginController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewOrigin()
        {
            $businessTypeQuery  = DB::table("business_origin")
                                    ->where('status','=',1)
                                    ->get();
            
            
            return view('catalogos.origenesEmpresa', ["businessTypeQuery" => $businessTypeQuery]);
        }
        
        public function addBusinessType (Request $request) 
        {
            $name = $request->input("name");
            
            
            $insertBusinessType             = new Business_origin;
            $insertBusinessType->name       = htmlentities ($name);
            $insertBusinessType->status     = 1;
            
            if($insertBusinessType->save()){
                return "true";
            }else{
                return "false";
            }
        }
        
        
        public function viewupdateBusinessType(Request $request){
            $pkBusiness_type  = $request->input("pkPayment_methods");
            
            $businessTypeQuery  = DB::table('business_origin')
                                        ->select('pkBusiness_origin'
                                                ,'name')
                                        ->where('status','=',1)
                                        ->where('pkBusiness_origin','=',$pkBusiness_type)
                                        ->first();
            
               $view = view('catalogos.editarTipoEmpresa', array(
                    "businessTypeQuery" => $businessTypeQuery,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));            
        }
        
        public function updateBusinessType (Request $request) 
        {
            $pkUserType        = $request->input("idMethod");
            $name               = htmlentities ($request->input("name"));
            
      
            $userTypeUpdate   = DB::table("business_origin")
                                    ->where('pkBusiness_origin','=',$pkUserType)
                                    ->where('status','=',1)
                                    ->update(array("name" => $name));
            
            if($userTypeUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function deleteBusinessType (Request $request) 
        {
            $pkBusiness_type         = $request->input("pkBusinessType");
            
            $businessTypeUpdate   = DB::table("business_origin")
                                    ->where('pkBusiness_origin','=',$pkBusiness_type)
                                    ->where('status','=',1)
                                    ->update(array("status" => 0));
            
            if($businessTypeUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
	
}
