<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Business;
use App\Models\Contacts_by_business;
use Illuminate\Http\Request;
use App\Permissions\UserPermits;

class CalendarController extends Controller {

    private $UserPermits;
    
	public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->UserPermits = new UserPermits();
        }
        
        public function viewCalendar()
        {
            $arrayPermition = array();
            $arrayPermition["viewCalendar"]  = $this->UserPermits->getPermition("viewCalendar");
            $arrayPermition["addActivity"]   = $this->UserPermits->getPermition("addActivity");
            
            $agentes = DB::table('users')
                         ->where('status','=',1)
                         ->get();
            
            $agent = -1;
            
            return view('calendario.calendario')->with("agentes",$agentes)
                                                ->with("agent",$agent)
                                                ->with("arrayPermition",$arrayPermition);
        }
        
        public function viewCalendarFilter($id)
        {
            
            $arrayPermition = array();
            $arrayPermition["viewCalendar"]  = $this->UserPermits->getPermition("viewCalendar");
            $arrayPermition["addActivity"]   = $this->UserPermits->getPermition("addActivity");
            
            $agentes = DB::table('users')
                         ->where('status','=',1)
                         ->get();
            
            $agent = $id;
            
            return view('calendario.calendario')->with("agentes",$agentes)
                                                ->with("agent",$agent)
                                                ->with("arrayPermition",$arrayPermition);
        }
        
        public function getDaysActivity(Request $request){
            
             $agent      = $request->input("agent");
             if($agent < 0){
              $agent = Session::get('pkUser'); 
             }
             
             $event = array();
            
            $activitys = DB::table('activities as a')
                           ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                           ->join('users as u','u.pkUser','=','a.fkUser')
                           ->select('a.pkActivities'
                                   ,'a.description'
                                   ,'u.full_name as name'
                                   ,'t.text as activityType'
                                   ,'t.color'
                                   ,'a.final_date'
                                   ,'a.execution_date'
                                   ,'a.final_hour')
                           ->where('a.status','=',1)
                           ->where('t.pkActivities_type','>',0)
                           ->where('u.pkUser','=',$agent)
                           ->get();
            $cont = 0;
            
            foreach($activitys as $infoActivity){
              if(empty($infoActivity->execution_date )){
               $event[$cont] =  array("id"     => $infoActivity->pkActivities
                                      ,"title" => $infoActivity->activityType
                                      ,"start" => $infoActivity->final_date
                                      ,"backgroundColor" => $infoActivity->color
                                                           );
                     $cont++;  
              }
            }
          
                   return \Response::json(array(
                                  "event" => $event
                                )); 
                
        }
        
        public function getDetailActivity(Request $request){
             $pkActivity  = $request->input("pkActivity");
            
     $activitiesQuery = DB::table("activities")
                                    ->join('business','business.pkBusiness','=','activities.fkBusiness')
                                    ->join('users','users.pkUser','=','activities.fkUser')
                                    ->join('user_type','user_type.pkUser_type','=','users.fkUser_type')
                                    ->join('activities_type','activities_type.pkActivities_type','=','activities.fkActivities_type')
                                    ->where('activities.status','=',1)
                                    ->where('business.status','=',1)
                                    ->where('users.status','=',1)
                                    ->where('user_type.status','=',1)
                                    ->where('activities_type.status','=',1)
                                    ->where('activities_type.pkActivities_type','>',0)
                                    ->where('activities.pkActivities','=',$pkActivity)
                                    ->orderBy("final_date","desc")
                                    ->orderBy("final_hour","desc")
                                    ->select(
                                            "activities.pkActivities AS pkActivities",
                                            "activities.fkActivities_type AS fkActivities_type",
                                            "activities.description AS description",
                                            "activities.register_date AS register_date",
                                            "activities.register_hour AS register_hour",
                                            "activities.final_date AS final_date",
                                            "activities.final_hour AS final_hour",
                                            "activities.document AS document",
                                            "activities.execution_date",
                                            "activities.pkOpportunities AS pkOpportunities",
                                            "activities.pkQuotations AS pkQuotations",
                                            "business.name AS name_business",
                                            "users.full_name AS full_name",
                                            "user_type.name AS type_name",
                                            "activities_type.text AS text",
                                            "activities_type.color AS color"
                                    )->first();

                  $SubActivity = DB::table('activities as a')
                             ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                             ->join('activities_subtype as s','s.fkActivities_type','=','t.pkActivities_type')
                             ->select('a.pkActivities'
                                     ,'s.text'
                                     ,'s.color'
                                     ,'s.pkActivities_subtype')
                             ->where('s.status','=',1)
                             ->where('a.status','=',1)
                             ->where('a.pkActivities','=',$activitiesQuery->pkActivities)
                             ->get();
     
               $view = view('calendario.viewDetailActivity', array(
                    "activitiesQuery" => $activitiesQuery,
                    "SubActivity"     => $SubActivity
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
        }
        
        public function getCreateActivity(Request $request){
           
            $businessQuery      = DB::table("business")
                                    ->where('status','=',1)
                                    ->orderBy("name","asc")
                                    ->get();
            
            $usersQuery      = DB::table("users")
                                    ->join('user_type','user_type.pkUser_type','=','users.fkUser_type')
                                    ->where('users.status','=',1)
                                    ->where('user_type.status','=',1)
                                    ->orderBy("users.full_name","asc")
                                    ->select(
                                    'users.pkUser as pkUser',
                                    'users.full_name as full_name',
                                    'user_type.name as type_name'
                                    )
                                    ->get();
            
            $activitiesTypeQuery      = DB::table("activities_type")
                                    ->where('status','=',1)
                                    ->where('pkActivities_type','>',0)
                                    ->orderBy("text","asc")
                                    ->get();
            
               $view = view('calendario.createCalendario', array(
                    "businessQuery"         => $businessQuery,
                    "usersQuery"            => $usersQuery,
                    "activitiesTypeQuery"   => $activitiesTypeQuery
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
      
	
}
