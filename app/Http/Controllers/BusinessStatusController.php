<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Business_status;
use Illuminate\Http\Request;

class BusinessStatusController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewBusinessStatus()
        {
            $businessStatusQuery    = DB::table("business_status")
                                    ->where('business_status.status','=',1)
                                    ->get();
            
            
            return view('catalogos.estatusEmpresa', ["businessStatusQuery" => $businessStatusQuery]);
        }
        
        public function addBusinessStatus (Request $request) 
        {
            $name = $request->input("name");
            
            
            $insertBusinessStatus = new Business_status;
            $insertBusinessStatus->name = htmlentities ($name);
            $insertBusinessStatus->status = 1;
            
            if($insertBusinessStatus->save()){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function BusinessStatus(Request $request){
              $pkBusiness_status  = $request->input("pkBusiness_status");
            
            $businesStatus    = DB::table('business_status')
                          ->select('pkBusiness_status'
                                  ,'name')
                          ->where('status','=',1)
                          ->where('pkBusiness_status','=',$pkBusiness_status)
                          ->first();
            
               $view = view('catalogos.editEstatusEmpresa', array(
                    "businesStatus" => $businesStatus ,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function updateBusinessStatus (Request $request) 
        {
            $pkBusinessStatus       = $request->input("idEstate");
            $name                   = $request->input("name");
            
            $businessStatusUpdate   = DB::table("business_status")
                                    ->where('business_status.pkBusiness_status','=',$pkBusinessStatus)
                                    ->where('business_status.status','=',1)
                                    ->update(array("name" => $name));
            
            if($businessStatusUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function deleteBusinessStatus (Request $request) 
        {
            $pkBusinessStatus       = $request->input("pkBusinessStatus");
            
            $businessStatusUpdate   = DB::table("business_status")
                                    ->where('business_status.pkBusiness_status','=',$pkBusinessStatus)
                                    ->where('business_status.status','=',1)
                                    ->update(array("status" => 0));
            
            if($businessStatusUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
	
}
