<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Activities;
use App\Models\Status_by_bussines;
use Illuminate\Http\Request;
use App\Permissions\UserPermits;

class ActivityController extends Controller {

    private $UserPermits;
    
	public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->UserPermits = new UserPermits();
        }
        
        public function activityCreateView()
        {
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
            
            return view('actividades.crearActividad',["businessQuery" => $businessQuery, "usersQuery" => $usersQuery, "activitiesTypeQuery" => $activitiesTypeQuery]);
        }
        
        
        public function selectOportunitiesAndQuotations (Request $request) 
        {
            $pkBusiness         = $request->input("pkBusiness");
            $option             = '<option value="-1">Selecciona el tipo de negocio</option><option value="0_N">Prospecto</option>';
            
            $opportunitiesQuery = DB::table("opportunities")
                                    ->where('fkBusiness','=',$pkBusiness)
                                    ->where('opportunities_status','!=',2)
                                    ->where('status','=',1)
                                    ->orderBy("name","asc")
                                    ->get();
            
            $quotationsQuery    = DB::table("quotations")
                                    ->where('fkBusiness','=',$pkBusiness)
                                    ->where('status','=',1)
                                    ->orderBy("name","asc")
                                    ->get();
            
            foreach ($opportunitiesQuery as $opportunitiesInfo) {
                $option .= '<option value="'.$opportunitiesInfo->pkOpportunities.'_o">Folio #'.html_entity_decode($opportunitiesInfo->folio).'(Oportunidad)</option>';
            }
            
            foreach ($quotationsQuery as $quotationsInfo) {
                $option .= '<option value="'.$quotationsInfo->pkQuotations.'_c">Folio #'.html_entity_decode($quotationsInfo->folio).'(Cotizaci&oacute;n)</option>';
            }
            
            return $option;
        }
        
        public function activityCreateDB (Request $request) 
        {
            $activityBusiness       = $request->input("activityBusiness");
            $type_event_business    = $request->input("type_event_business");
            $userAgent              = $request->input("userAgent");
            $type_activity          = $request->input("type_activity");
            $description            = htmlentities ($request->input("description"));
            $date                   = $request->input("date");
            $hour                   = $request->input("hour");
            $document               = $request->file('document');
            $campaning              = $request->input('campaning');
            $dateRegister           = date("Y-m-d");
            $hourRegister           = date("H:i:s");
            $path                   = "";
            $flag = "true";
            
            $type_event_businessAux = explode("_", $type_event_business);
            $typeBusiness           = $type_event_businessAux[1];
            
                            $ExistActivity = DB::table('activities')
                                   ->where('fkBusiness','=',$activityBusiness)
                                   ->first();
                
                if(empty($ExistActivity->pkActivities)){
                    $statusBussines = new Status_by_bussines;
                    $statusBussines->fkBusiness        =  $activityBusiness;
                    $statusBussines->fkOpportunities   =  0;
                    $statusBussines->fkQuotations      =  0;
                    $statusBussines->fkBusiness_status =  3;
                    $statusBussines->status            =  1;
                    
                     if($statusBussines->save()){                       
                     }else{
                      $flag = "false";     
                     } 
                }
            
            $insertActivity                 = new Activities;
            $insertActivity->fkBusiness     = $activityBusiness;
            if($typeBusiness != 'N'){
                if($typeBusiness == 'o'){
                    $insertActivity->pkOpportunities    = $type_event_businessAux[0];
                }else{
                    $insertActivity->pkQuotations       = $type_event_businessAux[0];
                }
            }
            
            if($type_activity == 2){
                $insertActivity->fkUser             = $userAgent;
                $insertActivity->fkActivities_type  = $type_activity;
                $insertActivity->description        = $description;
                $insertActivity->register_date      = $dateRegister;
                $insertActivity->register_hour      = $hourRegister;
                $insertActivity->fkCampaign         = $campaning;
                $insertActivity->final_date         = $dateRegister;
                $insertActivity->final_hour         = $hourRegister;
                $insertActivity->execution_date     = $dateRegister;
                $insertActivity->execution_hour     = $hourRegister;
                $insertActivity->document           = $path;
                $insertActivity->status             = 1;
            }else{
                $insertActivity->fkUser             = $userAgent;
                $insertActivity->fkActivities_type  = $type_activity;
                $insertActivity->description        = $description;
                $insertActivity->register_date      = $dateRegister;
                $insertActivity->register_hour      = $hourRegister;
                $insertActivity->fkCampaign         = $campaning;
                $insertActivity->final_date         = $date;
                $insertActivity->final_hour         = $hour;
                $insertActivity->document           = $path;
                $insertActivity->status             = 1;
            }
           
            
            if($insertActivity->save()){
                if($document != ''){ 
                    if(file_exists ($document)){
                        $nameFile = $document->getClientOriginalName();
                        if($nameFile!=''){
                            $ext            = $document->extension();
                            if(($ext == 'txt') || ($ext == 'csv') || ($ext == 'pdf')  || ($ext == 'xlsx')  || ($ext == 'png')  || ($ext == 'jpg')  || ($ext == 'jpeg') || ($ext == 'doc') || ($ext == 'docx')){
                            //$path               = $document->storeAs('/files/file',$nameFile.'.'.$ext);
                            $path = $document->storeAs('/files/file', $nameFile );
                            /*$destinationPath = public_path().'/files/file/';
                            $nameFile = str_replace(" ", "_", $nameFile); 
                            $document->move($destinationPath, $nameFile);*/

                            $actUpdate  = DB::table("activities")                                   
                            ->where('pkActivities', '=', $insertActivity->pkActivities)
                            ->update(array("document"  =>  $nameFile
                                       ));
                            }
                        }
                    }
                }
              
                
                return $flag;
            }else{
                return $flag;
            }
        }
       
        public function activityView () 
        {
            $activitiesArray = array();
            $arrayPermition = array();
            
            $arrayPermition["viewJob"]    = $this->UserPermits->getPermition("viewJob");
            $arrayPermition["finishJob"]  = $this->UserPermits->getPermition("finishJob");
            $arrayPermition["editJob"]    = $this->UserPermits->getPermition("editJob");
            $arrayPermition["deleteJob"]  = $this->UserPermits->getPermition("deleteJob");
            
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
                                    ->orderBy("register_date","desc")
                                    ->orderBy("register_hour","desc")
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
                                            ,"activities.comment"
                                            ,DB::raw('(SELECT text'
                                              . ' FROM activities_subtype as s'
                                              . ' WHERE s.status = 1'
                                              . ' AND s.pkActivities_subtype = activities.fkActivities_subtype) as subActivity')
                                            ,DB::raw('(SELECT color'
                                              . ' FROM activities_subtype as s'
                                              . ' WHERE s.status = 1'
                                              . ' AND s.pkActivities_subtype = activities.fkActivities_subtype) as subActivityColor')
                                    )
                                    ->paginate(50);
            
            $activitiesTypeQuery      = DB::table("activities_type")
                                    ->join('activities_subtype','activities_subtype.fkActivities_type','=','activities_type.pkActivities_type')
                                    ->where('activities_type.status','=',1)
                                    ->where('activities_subtype.status','=',1)
                                    ->get();
           
            
            foreach ($activitiesTypeQuery as $activitiesTypeInfo) {
                $activitiesArray[$activitiesTypeInfo->pkActivities_type][] = array("name" => $activitiesTypeInfo->text, "id" => $activitiesTypeInfo->pkActivities_subtype);
            }
            
            $users = DB::table('users as u')
                       ->join('user_type as t','t.pkUser_type','=','u.fkUser_type')
                       ->select('pkUser'
                               ,'full_name'
                               ,'name as type')
                        ->where('u.status','=',1)
                        ->where('t.status','=',1)
                        ->orderby('full_name','asc')
                        ->get();

            
               $activityType = DB::table('activities_type as t')
                              ->select('pkActivities_type'
                                      ,'text'
                                      ,'color'
                                      ,'icon')
                             ->where('pkActivities_type','>',0)
                             ->where('status','=',1)
                              ->orderby('text','asc')
                             ->get();
            
            return view('actividades.verActividades',["activitiesQuery" => $activitiesQuery, 
                                                      "activitiesArray" => $activitiesArray,
                                                      "users"           => $users,
                                                      "activityType"    => $activityType,
                                                      "arrayPermition"  => $arrayPermition]);
        }
        
        public function deleteAvtivity (Request $request) 
        {
            $pkActivity       = $request->input("pkActivity");
            
            
            $activitiesTypeQuery = DB::table("activities")
                                    ->where('pkActivities','=',$pkActivity)
                                    ->where('status','=',1)
                                    ->update(array("status" => 0));
            
            if($activitiesTypeQuery >= 1){
                return "true";
            }else{
                return "false";
            }
            
             
        }
        
        public function updateAvtivity(Request $request){
            $pkActivity  = $request->input("pkActivity");
            
            $activity    = DB::table('activities')
                          ->select('pkActivities'
                                  ,'fkBusiness'
                                  ,'pkOpportunities'
                                  ,'pkQuotations'
                                  ,'fkUser'
                                  ,'description'
                                  ,'fkActivities_type'
                                  ,'execution_date'
                                  ,'execution_hour'
                                  ,'final_date'
                                  ,'final_hour'
                                  ,'fkActivities_subtype'
                                  ,'document')
                          ->where('status','=',1)
                          ->where('pkActivities','=',$pkActivity)
                          ->first();
            
            
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
            

            $option             = '<option value="0_N">Prospecto</option>';
            
            $opportunitiesQuery = DB::table("opportunities")
                                    ->where('fkBusiness','=',$activity->fkBusiness)
                                    ->where('opportunities_status','!=',2)
                                    ->where('status','=',1)
                                    ->orderBy("name","asc")
                                    ->get();
            
            $quotationsQuery    = DB::table("quotations")
                                    ->where('fkBusiness','=',$activity->fkBusiness)
                                    ->where('status','=',1)
                                    ->orderBy("name","asc")
                                    ->get();
            
            foreach ($opportunitiesQuery as $opportunitiesInfo) {
                if($opportunitiesInfo->pkOpportunities == $activity->pkOpportunities){
                  $option .= '<option selected value="'.$opportunitiesInfo->pkOpportunities.'_o">Folio #'.html_entity_decode($opportunitiesInfo->folio).'(Oportunidad)</option>';
                } else{
                  $option .= '<option value="'.$opportunitiesInfo->pkOpportunities.'_o">Folio #'.html_entity_decode($opportunitiesInfo->folio).'(Oportunidad)</option>';
                }
                
            }
            
            foreach ($quotationsQuery as $quotationsInfo) {
                 if($activity->pkQuotations == $quotationsInfo->pkQuotations){
                   $option .= '<option selected value="'.$quotationsInfo->pkQuotations.'_c">Folio #'.html_entity_decode($quotationsInfo->folio).'(Cotizaci&oacute;n)</option>';
                 }else{
                   $option .= '<option value="'.$quotationsInfo->pkQuotations.'_c">Folio #'.html_entity_decode($quotationsInfo->folio).'(Cotizaci&oacute;n)</option>';
                 }
                }
            

            
               $view = view('actividades.editarActividad', array(
                    "activity"            => $activity,
                    "businessQuery"       => $businessQuery,
                    "usersQuery"          => $usersQuery,
                    "activitiesTypeQuery" => $activitiesTypeQuery,
                    "option"              => $option,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
        }
        
        public function updateAvtivityDB(Request $request){
            $activityBusiness = $request->input("activityBusiness");
        $type_event_business = $request->input("type_event_business");
        $userAgent = $request->input("userAgent");
        $type_activity = $request->input("type_activity");
        $description = htmlentities($request->input("description"));
        $date = $request->input("date");
        $hour = $request->input("hour");
        $pkActivity = $request->input("pkActivity");
        $document = $request->file('document');
        $dateRegister = date("Y-m-d");
        $hourRegister = date("H:i:s");
        $path = "";
        $flag = "true";

        $type_event_businessAux = explode("_", $type_event_business);
        $typeBusiness = $type_event_businessAux[1];

        DB::beginTransaction();

        try {


            if ($typeBusiness != 'N') {
                if ($typeBusiness == 'o') {

                    $updateOportunity = DB::table("activities")
                            ->where("pkActivities", "=", $pkActivity)
                            ->update(['pkOpportunities' => $type_event_businessAux[0]
                                     ,'pkQuotations'    => 0]);
                    
    
                } else {
                    $updateQuotations = DB::table("activities")
                            ->where("pkActivities", "=", $pkActivity)
                            ->update(['pkQuotations'   => $type_event_businessAux[0]
                                     ,'pkOpportunities' => 0]);
                    

                }
            }

                  $updateActivity = DB::table("activities")
                            ->where("pkActivities", "=", $pkActivity)
                            ->update(['fkBusiness'   => $activityBusiness
                                     ,'fkUser' => $userAgent
                                     ,'fkActivities_type' => $type_activity
                                     ,'description' => $description
                                     ,'final_date' => $date
                                     ,'final_hour' => $hour]);
                

            if ($document != '') {
                if (file_exists($document)) {
                    $nameFile = $document->getClientOriginalName();
                    if ($nameFile != '') {
                        $ext = $document->extension();
                        if(($ext == 'txt') || ($ext == 'csv') || ($ext == 'pdf')  || ($ext == 'xlsx')  || ($ext == 'png')  || ($ext == 'jpg')  || ($ext == 'jpeg') || ($ext == 'doc') || ($ext == 'docx')){
                            $path = $document->storeAs('/files/file', $nameFile . '.' . $ext);
                            
                            $updateDocument = DB::table("activities")
                            ->where("pkActivities", "=", $pkActivity)
                            ->update(['document'   => $path]);
                            
                             if($updateDocument >= 1){          
                            }else{
                             $flag = "false";    
                              }
                        }
                    }
                }
            }

            if ($flag == "true") {
                DB::commit();
                return $flag;
            } else {
                DB::rollback();
                return $flag;
            }
        } catch (Exception $ex) {
            DB::rollback();
            //return "Error del sistema, favor de contactar al desarrollador";
            return $e->getMessage();
        }
    }
    
        public function finishActivity(Request $request){
            
              $pkActivity = $request->input("pkActivity");
              
              $pkUser = Session::get('pkUser');
              
            $SubActivity = DB::table('activities as a')
                             ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                             ->join('activities_subtype as s','s.fkActivities_type','=','t.pkActivities_type')
                             ->select('a.pkActivities'
                                     ,'s.text'
                                     ,'s.color'
                                     ,'s.pkActivities_subtype')
                             ->where('s.status','=',1)
                             ->where('a.status','=',1)
                             ->where('a.pkActivities','=',$pkActivity)
                             ->get();
            
            
             $view = view('actividad.finishActivity', array(
                    "SubActivity" => $SubActivity,
                    "pkActivity"  => $pkActivity
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function finishActivityDB(Request $request){
        
        $description     = $request->input("description");
        $subtypeActivity = $request->input("subtypeActivity");
        $pkActivy        = $request->input("pkActivy");
        
        $actividad = DB::table('activities')
                    ->select('description'
                            ,'fkActivities_type'
                            ,'fkBusiness'
                            ,'fkUser')
                    ->where('status','=',1)
                    ->where('pkActivities','=',$pkActivy)
                    ->first();

         $startDateUTC = date("Y-m-d H:i:s");
         $DateTime = explode(" ", $startDateUTC);
            
            $categoriesUpdate   = DB::table("activities")
                                    ->where('pkActivities','=',$pkActivy)
                                    ->where('status','=',1)
                                    ->update(array("fkActivities_subtype" => $subtypeActivity
                                                   ,"comment"             => $description
                                                   ,"execution_date"      => $DateTime[0]
                                                   ,"execution_hour"      => $DateTime[1]));
            
            if($categoriesUpdate >= 1){

                $insertActivity = new Activities;
                $insertActivity->fkBusiness = $actividad->fkBusiness;
                $insertActivity->fkUser = $actividad->fkUser;
                $insertActivity->fkActivities_type = -3;
                $insertActivity->description    = "Actividad ".$actividad->description." se a marcado como finalizada";
                $insertActivity->register_date  = $DateTime[0];
                $insertActivity->register_hour  = $DateTime[1];
                $insertActivity->document = "";
                $insertActivity->status = 1; 

                if ($insertActivity->save()) {
                        
                } else {
                    $flag = "false";
                  
                }


                return "true";
            }else{
                return "false";
            }
        }
        
        public function seachArcivity(Request $request){
            $activitiesArray = array();
            $text       = "";
            $agent      = $request->input("Agent");
            $status     = $request->input("status");
            $type       = $request->input("type");
            $fechStart  = $request->input("fechStart");
            $fechFinish = $request->input("fechFinish");
            
            $activitiesQuery = DB::table("activities")
                                    ->join('business','business.pkBusiness','=','activities.fkBusiness')
                                    ->join('users','users.pkUser','=','activities.fkUser')
                                    ->join('activities_type','activities_type.pkActivities_type','=','activities.fkActivities_type')
                                    ->join('user_type','user_type.pkUser_type','=','users.fkUser_type')
                                    ->where('activities.status','=',1)
                                    ->where('business.status','=',1)
                                    ->where('users.status','=',1)
                                    ->where('user_type.status','=',1)
                                    ->where('activities_type.status','=',1)
                                    ->where('activities_type.pkActivities_type','>',0)
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
                                    );
            
            if($agent > 0){
             $activitiesQuery = $activitiesQuery->where('users.pkUser','=',$agent);   
            }
            
             if($type > 0){
             $activitiesQuery = $activitiesQuery->where('activities_type.pkActivities_type','=',$type);   
            }
            
            if($status > 0){
                if($status == 1){
             $activitiesQuery = $activitiesQuery->where('activities.execution_date','!=',"");  
                }
                if($status == 2){
                    $activitiesQuery = $activitiesQuery->where('activities.execution_date','=',NULL);    
                }
            }
            
            if(!empty($fechStart)){
             $activitiesQuery = $activitiesQuery->whereDate('activities.register_date','>=',$fechStart);   
            }
            
            if(!empty($fechFinish)){
             $activitiesQuery = $activitiesQuery->whereDate('activities.register_date','<=',$fechFinish);   
            }
            
            
              $activitiesQuery =    $activitiesQuery->get();
            
            $activitiesTypeQuery      = DB::table("activities_type")
                                    ->join('activities_subtype','activities_subtype.fkActivities_type','=','activities_type.pkActivities_type')
                                    ->where('activities_type.status','=',1)
                                    ->where('activities_subtype.status','=',1)
                                    ->get();
           
            
            foreach ($activitiesTypeQuery as $activitiesTypeInfo) {
                $activitiesArray[$activitiesTypeInfo->pkActivities_type][] = array("name" => $activitiesTypeInfo->text, "id" => $activitiesTypeInfo->pkActivities_subtype);
            }
            
               $view = view('actividades.getActivity', array(
                    "activitiesQuery" => $activitiesQuery, 
                    "activitiesArray" => $activitiesArray,
                    "text" => $text,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
            
        }

        
        public function viewPendingCalls () 
        {

            $arrayPermition["viewcallPending"]    = $this->UserPermits->getPermition("viewcallPending");
            $arrayPermition["editcallPending"]    = $this->UserPermits->getPermition("editcallPending");
            $arrayPermition["deletecallPending"]  = $this->UserPermits->getPermition("deletecallPending");


            $month            = date("Y-m");
            $aux              = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day         = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate        = date("Y-m")."-01";
            $endDate          = $last_day;
            $pkUser           = Session::get('pkUser');
            $isAdmin          = Session::get('isAdmin');
            $today            = date("Y-m-d");

            $auxMonth         = date('Y-m-d', strtotime("{$month} - 2 month"));
          //  $yearFinish = date('Y')."-12-31";
        
            if($isAdmin == 1){
            $activitiesQuery    = DB::table('activities')
                                            ->join('activities_type', function ($join) {
                                                $join->on('activities_type.pkActivities_type', '=', 'activities.fkActivities_type');
                                            })
                                            ->join('users', function ($join) {
                                                $join->on('users.pkUser', '=', 'activities.fkUser');
                                            })
                                            ->join('business', function ($join) {
                                                $join->on('business.pkBusiness', '=', 'activities.fkBusiness');
                                            })
                                            ->leftjoin('commercial_campaigns', function ($join) {
                                                $join->on('commercial_campaigns.pkCommercial_campaigns', '=', 'activities.fkCampaign');
                                            })
                                            ->where('activities.status', '=', 1)
                                            ->where('activities_type.status', '=', 1)
                                            ->where('users.status', '=', 1)
                                            ->where('business.status', '=', 1)
                                            ->where('activities.execution_date', '=', NULL)
                                            ->where(function ($query) use($startDate, $endDate,$auxMonth,$today ) {
                                                $query->whereDate('activities.final_date', '>=', $auxMonth );
                                                      //->whereDate('activities.final_date', '<=', $today );
                                            })
                                            ->where('activities_type.pkActivities_type', '=', '1')
                                            ->select(
                                                    'activities.pkActivities  AS pkActivities',
                                                    'activities.description AS description',
                                                    'activities.final_date AS final_date',
                                                    DB::raw("DATE_FORMAT(activities.final_date, '%d de %b, %Y') as final_dateact"),
                                                    'activities.final_hour AS final_hour',
                                                    'activities_type.text AS text',
                                                    'activities_type.color AS color',
                                                    'activities_type.icon AS icon',
                                                    'users.full_name AS full_name',
                                                    'business.name AS business_name',
                                                    'business.pkBusiness AS pkBusiness',
                                                    'commercial_campaigns.name AS campaning')
                                            ->orderBy("activities.final_date", "asc")
                                            ->orderBy("activities.final_hour", "asc")
                                            ->get();  
            }else{
                $activitiesQuery    = DB::table('activities')
                ->join('activities_type', function ($join) {
                    $join->on('activities_type.pkActivities_type', '=', 'activities.fkActivities_type');
                })
                ->join('users', function ($join) {
                    $join->on('users.pkUser', '=', 'activities.fkUser');
                })
                ->join('business', function ($join) {
                    $join->on('business.pkBusiness', '=', 'activities.fkBusiness');
                })
                ->leftjoin('commercial_campaigns', function ($join) {
                    $join->on('commercial_campaigns.pkCommercial_campaigns', '=', 'activities.fkCampaign');
                })
                ->where('activities.status', '=', 1)
                ->where('activities_type.status', '=', 1)
                ->where('users.status', '=', 1)
                ->where('business.status', '=', 1)
                ->where('activities.execution_date', '=', NULL)
                ->where(function ($query) use($startDate, $endDate,$auxMonth,$today ) {
                    $query->whereDate('activities.final_date', '>=', $auxMonth );
                })
                ->where('activities_type.pkActivities_type', '=', '1')
                ->where('users.pkUser', '=', $pkUser)
                ->select(
                        'activities.pkActivities  AS pkActivities',
                        'activities.description AS description',
                        'activities.final_date AS final_date',
                        DB::raw("DATE_FORMAT(activities.final_date, '%d de %b, %Y') as final_dateact"),
                        'activities.final_hour AS final_hour',
                        'activities_type.text AS text',
                        'activities_type.color AS color',
                        'activities_type.icon AS icon',
                        'users.full_name AS full_name',
                        'business.name AS business_name',
                        'business.pkBusiness AS pkBusiness',
                        'commercial_campaigns.name AS campaning')
                        ->orderBy("activities.final_date", "asc")
                        ->orderBy("activities.final_hour", "asc")
                ->get();    
            }

                         

                   $users = DB::table('users as u')
                       ->join('user_type as t','t.pkUser_type','=','u.fkUser_type')
                       ->select('pkUser'
                               ,'full_name'
                               ,'name as type')
                        ->where('u.status','=',1)
                        ->where('t.status','=',1)
                        ->orderby('full_name','asc')
                        ->get();

                                       
            
             return view('actividades.verLlamadasPendientes',["activitiesQuery" => $activitiesQuery
                                                             ,"arrayPermition"  => $arrayPermition
                                                             ,"users"           => $users]);
        }

        public function searchPendingCalls(Request $request){

           
            
            $idUser           = $request->input("idUser");

            $month            = date("Y-m");
            $aux              = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day         = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate        = date("Y-m")."-01";
            $endDate          = $last_day;
            $today            = date("Y-m-d");
            $auxMonth         = date('Y-m-d', strtotime("{$month} - 2 month"));
        
        if($idUser > 0){
            $activitiesQuery    = DB::table('activities')
                                            ->join('activities_type', function ($join) {
                                                $join->on('activities_type.pkActivities_type', '=', 'activities.fkActivities_type');
                                            })
                                            ->join('users', function ($join) {
                                                $join->on('users.pkUser', '=', 'activities.fkUser');
                                            })
                                            ->join('business', function ($join) {
                                                $join->on('business.pkBusiness', '=', 'activities.fkBusiness');
                                            })
                                            ->leftjoin('commercial_campaigns', function ($join) {
                                                $join->on('commercial_campaigns.pkCommercial_campaigns', '=', 'activities.fkCampaign');
                                            })
                                            ->where('activities.status', '=', 1)
                                            ->where('activities_type.status', '=', 1)
                                            ->where('users.status', '=', 1)
                                            ->where('business.status', '=', 1)
                                            ->where('activities.execution_date', '=', NULL)
                                            ->where(function ($query) use($startDate, $endDate,$auxMonth) {
                                                $query->whereDate('activities.final_date', '>=', $auxMonth );
                                            })
                                            ->where('activities_type.pkActivities_type', '=', '1')
                                            ->where('users.pkUser', '=', $idUser)
                                            ->select(
                                                    'activities.pkActivities  AS pkActivities',
                                                    'activities.description AS description',
                                                    DB::raw("DATE_FORMAT(activities.final_date, '%d de %b, %Y') as final_dateact"),
                                                    'activities.final_hour AS final_hour',
                                                    'activities.final_hour AS final_date',
                                                    'activities_type.text AS text',
                                                    'activities_type.color AS color',
                                                    'activities_type.icon AS icon',
                                                    'users.full_name AS full_name',
                                                    'business.name AS business_name',
                                                    'business.pkBusiness AS pkBusiness',
                                                    'commercial_campaigns.name AS campaning')
                                                    ->orderBy("activities.final_date", "asc")
                                                    ->orderBy("activities.final_hour", "asc")
                                            ->get();  
        }else{
             $activitiesQuery    = DB::table('activities')
                                            ->join('activities_type', function ($join) {
                                                $join->on('activities_type.pkActivities_type', '=', 'activities.fkActivities_type');
                                            })
                                            ->join('users', function ($join) {
                                                $join->on('users.pkUser', '=', 'activities.fkUser');
                                            })
                                            ->join('business', function ($join) {
                                                $join->on('business.pkBusiness', '=', 'activities.fkBusiness');
                                            })
                                            ->leftjoin('commercial_campaigns', function ($join) {
                                                $join->on('commercial_campaigns.pkCommercial_campaigns', '=', 'activities.fkCampaign');
                                            })
                                            ->where('activities.status', '=', 1)
                                            ->where('activities_type.status', '=', 1)
                                            ->where('users.status', '=', 1)
                                            ->where('business.status', '=', 1)
                                            ->where('activities.execution_date', '=', NULL)
                                            ->where(function ($query) use($startDate, $endDate, $auxMonth) {
                                                $query->whereDate('activities.final_date', '>=', $auxMonth );
                                            })
                                            ->where('activities_type.pkActivities_type', '=', '1')
                                            ->select(
                                                    'activities.pkActivities  AS pkActivities',
                                                    'activities.description AS description',
                                                    DB::raw("DATE_FORMAT(activities.final_date, '%d de %b, %Y') as final_dateact"),
                                                    'activities.final_hour AS final_hour',
                                                    'activities.final_hour AS final_date',
                                                    'activities_type.text AS text',
                                                    'activities_type.color AS color',
                                                    'activities_type.icon AS icon',
                                                    'users.full_name AS full_name',
                                                    'business.name AS business_name',
                                                    'business.pkBusiness AS pkBusiness',
                                                    'commercial_campaigns.name AS campaning')
                                                    ->orderBy("activities.final_date", "asc")
                                                    ->orderBy("activities.final_hour", "asc")
                                            ->get();  
        }


                        $view = view('actividades.getLlamadasPendientes', array(
                            "activitiesQuery" => $activitiesQuery
                                ))->render();
                
                    return \Response::json(array(
                                          "valid"       => "true",
                                          "view"        => $view
                                        ));   


        }

    public function seachArcivityText(Request $request){

        $text     = $request->input("text");
         $activitiesArray = array();
            $arrayPermition = array();
            
            $arrayPermition["viewJob"]    = $this->UserPermits->getPermition("viewJob");
            $arrayPermition["finishJob"]  = $this->UserPermits->getPermition("finishJob");
            $arrayPermition["editJob"]    = $this->UserPermits->getPermition("editJob");
            $arrayPermition["deleteJob"]  = $this->UserPermits->getPermition("deleteJob");
            
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
                                    ->orderBy("register_date","desc")
                                    ->orderBy("register_hour","desc")
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
                                            ,"activities.comment"
                                            ,DB::raw('(SELECT text'
                                              . ' FROM activities_subtype as s'
                                              . ' WHERE s.status = 1'
                                              . ' AND s.pkActivities_subtype = activities.fkActivities_subtype) as subActivity')
                                            ,DB::raw('(SELECT color'
                                              . ' FROM activities_subtype as s'
                                              . ' WHERE s.status = 1'
                                              . ' AND s.pkActivities_subtype = activities.fkActivities_subtype) as subActivityColor')
                                    )
                                    ->where('business.name','like', "%".htmlentities($text)."%")
                                    ->get();
            
            $activitiesTypeQuery      = DB::table("activities_type")
                                    ->join('activities_subtype','activities_subtype.fkActivities_type','=','activities_type.pkActivities_type')
                                    ->where('activities_type.status','=',1)
                                    ->where('activities_subtype.status','=',1)
                                    ->get();
           
            
            foreach ($activitiesTypeQuery as $activitiesTypeInfo) {
                $activitiesArray[$activitiesTypeInfo->pkActivities_type][] = array("name" => $activitiesTypeInfo->text, "id" => $activitiesTypeInfo->pkActivities_subtype);
            }
            
    
               $view = view('actividades.getActivity', array(
                    "activitiesQuery" => $activitiesQuery, 
                    "activitiesArray" => $activitiesArray,
                    "text" => $text,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
    }
}
