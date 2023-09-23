<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Campaigns_type;
use Illuminate\Http\Request;

class CampaignsTypeController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewCampaignsType()
        {
            $campaignsTypeQuery  = DB::table("campaigns_type")
                                    ->where('campaigns_type.status','=',1)
                                    ->get();
            
            
            return view('catalogos.tiposCampana', ["campaignsTypeQuery" => $campaignsTypeQuery]);
        }
        
        public function addCampaignsType (Request $request) 
        {
            $name = $request->input("name");
            
            
            $insertCampaignsType             = new Campaigns_type;
            $insertCampaignsType->name       = htmlentities ($name);
            $insertCampaignsType->status     = 1;
            
            if($insertCampaignsType->save()){
                return "true";
            }else{
                return "false";
            }
        }
        
        
        public function viewupdateCampaignsType(Request $request){
            $pkCampaignsType  = $request->input("pkCampaignsType");
            
            $businessTypeQuery  = DB::table('campaigns_type')
                                        ->select('pkCampaigns_type'
                                                ,'name')
                                        ->where('status','=',1)
                                        ->where('pkCampaigns_type','=',$pkCampaignsType)
                                        ->first();
            
               $view = view('catalogos.editarTipoDeCampana', array(
                    "businessTypeQuery" => $businessTypeQuery,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));            
        }
        
        public function updateCampaignsType (Request $request) 
        {
            $pkCampaignsType        = $request->input("idMethod");
            $name               = htmlentities ($request->input("name"));
            
      
            $campaignsTypeUpdate   = DB::table("campaigns_type")
                                    ->where('pkCampaigns_type','=',$pkCampaignsType)
                                    ->where('status','=',1)
                                    ->update(array("name" => $name));
            
            if($campaignsTypeUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function deleteCampaignsType (Request $request) 
        {
            $pkCampaignsType         = $request->input("pkCampaignsType");
            
            $campaignsTypeUpdate   = DB::table("campaigns_type")
                                    ->where('campaigns_type.pkCampaigns_type','=',$pkCampaignsType)
                                    ->where('campaigns_type.status','=',1)
                                    ->update(array("status" => 0));
            
            if($campaignsTypeUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
	
}
