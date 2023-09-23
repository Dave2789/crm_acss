<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Activities_subtype;
use Illuminate\Http\Request;

class ActivitySubtypeController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewActivitySubtype()
        {
            $activityTypeQuery    = DB::table("activities_type")
                                    ->where('activities_type.status','=',1)
                                    ->where('activities_type.pkActivities_type','>',0)
                                    ->orderBy('activities_type.text', 'ASC')
                                    ->get();
            
            
            $activitySubtypeQuery    = DB::table("activities_subtype")
                                    ->join('activities_type','activities_type.pkActivities_type','=','activities_subtype.fkActivities_type')
                                    ->where('activities_subtype.status','=',1)
                                    ->where('activities_type.status','=',1)
                                    ->select(
                                            'activities_subtype.pkActivities_subtype as pkActivities_subtype',
                                            'activities_subtype.text as text',
                                            'activities_subtype.color as color',
                                            'activities_type.text as name',
                                            'activities_subtype.status_type as status_type'
                                    )
                                    ->get();
            
            
            return view('catalogos.subtiposActividad', ["activityTypeQuery" => $activityTypeQuery, "activitySubtypeQuery" => $activitySubtypeQuery]);
        }
        
        public function addActivitySubtype (Request $request) 
        {
            $fkActivityType     = $request->input("fkActivityType");
            $text               = $request->input("name");
            $color              = $request->input("color");
            $slctypeCall        = $request->input("slctypeCall");
            
            $insertActivitySubtype                      = new Activities_subtype;
            $insertActivitySubtype->fkActivities_type   = $fkActivityType;
            $insertActivitySubtype->text                = htmlentities ($text);
            $insertActivitySubtype->color               = $color;
            $insertActivitySubtype->status_type         = $slctypeCall;
            $insertActivitySubtype->status              = 1;
            
            if($insertActivitySubtype->save()){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function viewupdateaddActivitySubtype(Request $request){
            $pkActivities_subtype  = $request->input("pkActivities_subtype");
            
            $activityTypeQuery    = DB::table("activities_type")
                                    ->where('activities_type.status','=',1)
                                     ->where('pkActivities_type','>',0)
                                    ->orderBy('activities_type.text', 'ASC')                                   
                                    ->get();
            
            $activitySubType    = DB::table('activities_subtype')
                          ->select('pkActivities_subtype'
                                  ,'fkActivities_type'
                                  ,'text'
                                  ,'color'
                                  ,'status_type')
                          ->where('status','=',1)
                          ->where('pkActivities_subtype','=',$pkActivities_subtype)
                          ->first();
            
               $view = view('catalogos.editarsubtiposActividad', array(
                    "activitySubType" => $activitySubType,
                    "activityTypeQuery" => $activityTypeQuery
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));       
        }
        public function updateActivitySubtype (Request $request) 
        {
            $pkActivitiesSubtype        = $request->input("idSubType");
            $fkActivityType             = $request->input("fkActivityType");
            $text                       = $request->input("text");
            $color                      = $request->input("color");
            
            $activitySubtypeUpdate     = DB::table("activities_subtype")
                                    ->where('activities_subtype.pkActivities_subtype','=',$pkActivitiesSubtype)
                                    ->where('activities_subtype.status','=',1)
                                    ->update(array("fkActivities_type" => $fkActivityType, "text" => $text, "color" => $color));
            
            if($activitySubtypeUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function deleteActivitySubtype (Request $request) 
        {
            $pkActivitiesSubtype         = $request->input("pkActivitiesSubtype");
            
            $activitySubtypeUpdate   = DB::table("activities_subtype")
                                    ->where('activities_subtype.pkActivities_subtype','=',$pkActivitiesSubtype)
                                    ->where('activities_subtype.status','=',1)
                                    ->update(array("status" => 0));
            
            if($activitySubtypeUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
	
}
