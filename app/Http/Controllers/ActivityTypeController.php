<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Activities_type;
use Illuminate\Http\Request;

class ActivityTypeController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewActivityType()
        {
            $activityTypeQuery    = DB::table("activities_type")
                                    ->where('activities_type.status','=',1)
                                    ->where('activities_type.pkActivities_type','>',0)
                                    ->get();
            
            
            return view('catalogos.tiposActividad', ["activityTypeQuery" => $activityTypeQuery]);
        }
        
        public function addActivityType (Request $request) 
        {
            $text   = $request->input("name");
            $color  = $request->input("color");
            $icon   = $request->input("icon");
            
            
            $insertActivityType = new Activities_type;
            $insertActivityType->text   = htmlentities ($text);
            $insertActivityType->color  = $color;
            $insertActivityType->icon  = $icon;
            $insertActivityType->status = 1;
            
            if($insertActivityType->save()){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function viewupdateActivityType(Request $request){
               $pkActivities_type  = $request->input("pkActivities_type");
            
            $activityType    = DB::table('activities_type')
                          ->select('pkActivities_type'
                                  ,'text'
                                  ,'color')
                          ->where('status','=',1)
                          ->where('pkActivities_type','=',$pkActivities_type)
                          ->first();
            
               $view = view('catalogos.editTypeActivity', array(
                    "activityType" => $activityType,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));          
        }
        
        public function updateActivityType (Request $request) 
        {
            $pkActivitiesType        = $request->input("idType");
            $text              = $request->input("text");
            $color             = $request->input("color");
            $icon   = $request->input("icon");
            
            $activityTypeUpdate     = DB::table("activities_type")
                                    ->where('activities_type.pkActivities_type','=',$pkActivitiesType)
                                    ->where('activities_type.status','=',1)
                                    ->update(array("text" => $text, "color" => $color, "icon" => $icon));
            
            if($activityTypeUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function deleteActivityType (Request $request) 
        {
            $pkActivitiesType         = $request->input("pkActivitiesType");
            
            $activityTypeUpdate   = DB::table("activities_type")
                                    ->where('activities_type.pkActivities_type','=',$pkActivitiesType)
                                    ->where('activities_type.status','=',1)
                                    ->update(array("status" => 0));
            
            if($activityTypeUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
	
}
