<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Alerts;
use App\Models\Users_per_alert;
use Illuminate\Http\Request;
use App\Permissions\UserPermits;

class AlertController extends Controller {
    
    private $UserPermits;

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->UserPermits = new UserPermits();
        }
        
        public function alertCreateView()
        {
            $usersQuery     = DB::table("users")
                                ->join('user_type','user_type.pkUser_type','=','users.fkUser_type')
                                ->where('users.status', '=', 1)
                                ->where('user_type.status', '=', 1)
                                ->select(
                                    'users.pkUser AS pkUser',
                                    'users.full_name AS full_name',
                                    'user_type.name AS type_user_name'
                                )
                                ->get();
            
            
            return view('notificaciones.crearNotificacion',["usersQuery" => $usersQuery]);
        }
        
        public function createAlertDB (Request $request) 
        {
            $title              = htmlentities ($request->input("title"));
            $message            = htmlentities ($request->input("message"));
            $slcBussines        = $request->input("slcBussines");
            $users              = $request->input("users");
            $file               = $request->file("file");
            $date               = date("Y-m-d");
            $hour               = date("H:i:s");
            $messageReturn      = "true";
            $flag               = "true";
            
            DB::beginTransaction();
              
            try { 
            
            $insertAlert                = new Alerts;
            $insertAlert->fkUser        = Session::get("pkUser");
            $insertAlert->title         = $title;
            $insertAlert->comment       = $message;
            $insertAlert->fkBussiness   = $slcBussines;
            $insertAlert->date          = $date;
            $insertAlert->hour          = $hour;
            $insertAlert->status        = 1;
            
            if($insertAlert->save()){
                if((strpos($users, ",") !== FALSE)){
                    $usersArray = explode(",", $users);
                    foreach ($usersArray as $usersInfo) {
                        $insertAlertUser                        = new Users_per_alert;
                        $insertAlertUser->fkAlert               = $insertAlert->pkAlert;
                        $insertAlertUser->fkUser_assigned       = $usersInfo;
                        $insertAlertUser->view                  = 0;
                        $insertAlertUser->status                = 1;

                        if($insertAlertUser->save()){

                        }else{
                            $flag = "false";
                            $messageReturn .= "Error al agregar notificaci\u00F3n a usuario: ".$usersInfo." \n";
                        }
                    }
                }else{
                    if($users != ""){
                        $insertAlertUser                        = new Users_per_alert;
                        $insertAlertUser->fkAlert               = $insertAlert->pkAlert;
                        $insertAlertUser->fkUser_assigned       = $users;
                        $insertAlertUser->view                  = 0;
                        $insertAlertUser->status                = 1;

                        if($insertAlertUser->save()){

                        }else{
                            $flag = "false";
                            $messageReturn .= "Error al agregar notificaci\u00F3n a usuario: ".$users." \n";
                        }
                    }
                }

                if($file != ''){ 
                    if(file_exists ($file)){
                        $nameFile = $file->getClientOriginalName();
                        if($nameFile!=''){
                            $ext            = $file->extension();
                            
                            if(($ext == 'png') ||($ext == 'jpg')||($ext == 'jpeg')||($ext == 'pdf')||($ext == 'docx')){
    
                                $destinationPath = $_SERVER['DOCUMENT_ROOT'].'/images/alerts/';
                                $file->move($destinationPath, 'documento'.$date.'.'.$ext);
    
                                $updateDocument = DB::table("alerts")
                                            ->where("pkAlert", "=" ,$insertAlert->pkAlert)
                                             ->update(['document' => 'documento'.$date.'.'.$ext]);
                         
                                       if($updateDocument >= 1){
                                      }else{
                                         $flag = "false";    
                                      }
                            
                            }
                        }
                    }
                }

                }else{
                $flag = "false";
                $messageReturn .= "Error al agregar notificaci\u00F3n   \n";
            }

            
            
            if($flag == "true"){
                DB::commit();
                return $messageReturn;
            }else{
                DB::rollback(); 
                return $messageReturn;
            }
        } catch (\Exception $e) {
                DB::rollback(); 
                //return "Error del sistema, favor de contactar al desarrollador";
                return $e->getMessage();
        }  
            
            
    }
    
        public function alertView () 
        {
        $usersPerAlert          = array();
        $usersPerAlertReceived  = array();
        
        $arrayPermition = array();
        $arrayPermition["addNotification"]     = $this->UserPermits->getPermition("addNotification");
        $arrayPermition["viewNotification"]    = $this->UserPermits->getPermition("viewNotification");
        $arrayPermition["deleteNotification"]  = $this->UserPermits->getPermition("deleteNotification");
        
        $alertsQuery    = DB::table("alerts")
                                ->join('users','users.pkUser','=','alerts.fkUser')
                                ->leftjoin('business','business.pkBusiness','=','alerts.fkBussiness')
                                ->where('alerts.fkUser', '=', Session::get("pkUser"))
                                ->where('alerts.status', '=', 1)
                                ->orderby('alerts.date','desc')
                                ->orderby('alerts.hour','desc')
                                ->get();
        
        $alertSendQuery = DB::table("alerts")
                                ->join('users_per_alert','users_per_alert.fkAlert','=','alerts.pkAlert')
                                ->join('users','users.pkUser','=','users_per_alert.fkUser_assigned')
                                ->join('user_type','user_type.pkUser_type','=','users.fkUser_type')
                                ->where('alerts.fkUser', '=', Session::get("pkUser"))
                                ->where('alerts.status', '=', 1)
                                ->where('users_per_alert.status', '=', 1)
                                ->where('users.status', '=', 1)
                                ->where('user_type.status', '=', 1)
                                ->select(
                                        'alerts.pkAlert AS pkAlert',
                                        'alerts.document AS document',
                                        'users_per_alert.view AS view',
                                        'users_per_alert.date AS date',
                                        'users_per_alert.hour AS hour',
                                        'users.full_name AS full_name',
                                        'user_type.name AS type_name'
                                )
                                ->orderby('alerts.date','desc')
                                ->orderby('alerts.hour','desc')
                                ->get();
        
        $alertReceivedQuery = DB::table("alerts")
                                ->join('users_per_alert','users_per_alert.fkAlert','=','alerts.pkAlert')
                                ->join('users','users.pkUser','=','alerts.fkUser')
                                ->join('user_type','user_type.pkUser_type','=','users.fkUser_type')
                                ->where('users_per_alert.fkUser_assigned', '=', Session::get("pkUser"))
                                ->where('alerts.status', '=', 1)
                                ->where('users_per_alert.status', '=', 1)
                                ->where('users.status', '=', 1)
                                ->where('user_type.status', '=', 1)
                                ->select(
                                        'alerts.pkAlert AS pkAlert',
                                        'alerts.title AS title',
                                        'alerts.document AS document',
                                        'alerts.comment AS comment',
                                        'alerts.date AS dateOne',
                                        'alerts.hour AS hourOne',
                                        'users_per_alert.view AS view',
                                        'users_per_alert.date AS date',
                                        'users_per_alert.hour AS hour',
                                        'users.full_name AS full_name',
                                        'user_type.name AS type_name'
                                )
                                ->orderby('alerts.date','desc')
                                ->orderby('alerts.hour','desc')
                                ->get();
        
        foreach ($alertSendQuery as $alertSendInfo) {
            $usersPerAlert[$alertSendInfo->pkAlert][] = array("name" => $alertSendInfo->full_name, 
                                                                    "type" => $alertSendInfo->type_name,
                                                                    "view" => $alertSendInfo->view, 
                                                                    "date" => $alertSendInfo->date, 
                                                                    "hour" => $alertSendInfo->hour
            );
        }
        
        foreach ($alertReceivedQuery as $alertReceivedInfo) {
            $usersPerAlertReceived[] = array(
                                            "pkAlert" => $alertReceivedInfo->pkAlert, 
                                            "title" => $alertReceivedInfo->title, 
                                            "comment" => $alertReceivedInfo->comment, 
                                            "date" => $alertReceivedInfo->dateOne, 
                                            "hour" => $alertReceivedInfo->hourOne, 
                                            "view" => $alertReceivedInfo->view, 
                                            "dateview" => $alertReceivedInfo->date, 
                                            "hourview" => $alertReceivedInfo->hour, 
                                            "full_name" => $alertReceivedInfo->full_name, 
                                            "type_name" => $alertReceivedInfo->type_name
            );
        }
        
        
        
        return view('notificaciones.verNotificaciones',["alertsQuery" => $alertsQuery, "usersPerAlert" => $usersPerAlert
                                                      , "usersPerAlertReceived" => $usersPerAlertReceived
                                                      , "arrayPermition" => $arrayPermition]);
    }
       
        public function deleteAlert (Request $request) 
        {
        $flag               = "true";
        $pkAlert            = htmlentities ($request->input("pkAlert"));
        
        
        DB::beginTransaction();
              
        try { 
            $alertsUpdate   = DB::table("alerts")
                                ->where('alerts.pkAlert', '=', $pkAlert)
                                ->where('alerts.status', '=', 1)
                                ->update(array("status" => 0));
            
            if($alertsUpdate >= 1){
                
            }else{
                $flag = "false";
            }
            
            $alertsUserUpdate   = DB::table("users_per_alert")
                                ->where('users_per_alert.fkAlert', '=', $pkAlert)
                                ->where('users_per_alert.status', '=', 1)
                                ->update(array("status" => 0));
            
            if($alertsUserUpdate >= 1){
                
            }else{
                $flag = "false";
            }
        
            if($flag == "true"){
                DB::commit();
                return $flag;
            }else{
                DB::rollback(); 
                return $flag;
            }
        } catch (\Exception $e) {
                DB::rollback(); 
                //return "Error del sistema, favor de contactar al desarrollador";
                return $e->getMessage();
        }  
    }
    
        public function updateAlert(Request $request){
            $pkAlert  = $request->input("pkAlert");
            
            $alert   = DB::table('alerts as a')
                         ->leftjoin('business as b','b.pkBusiness','=','fkBussiness')
                          ->select('a.pkAlert'
                                  ,'a.fkUser'
                                  ,'a.title'
                                  ,'a.comment'
                                  ,'a.date'
                                  ,'b.name'
                                  ,'b.pkBusiness'
                                  ,'a.hour')
                          ->where('a.status','=',1)
                          ->where('a.pkAlert','=',$pkAlert)
                          ->first();
            
            $usersQuery     = DB::table("users")
                                ->join('user_type','user_type.pkUser_type','=','users.fkUser_type')
                                ->where('users.status', '=', 1)
                                ->where('user_type.status', '=', 1)
                                ->select(
                                    'users.pkUser AS pkUser',
                                    'users.full_name AS full_name',
                                    'user_type.name AS type_user_name'
                                )
                                ->get();
            
            
 $usersQuerybyNotification     = DB::table("users_per_alert")
                                ->select(
                                    'fkUser_assigned'
                                )
                                ->get();
            
               $view = view('notificaciones.editarNotificacion', array(
                    "alert" => $alert,
                    "usersQuery" => $usersQuery,
                    "usersQuerybyNotification" => $usersQuerybyNotification,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));     
        }
        
        public function updateAlertDB(Request $request){
           $title              = htmlentities ($request->input("title"));
            $message            = htmlentities ($request->input("message"));
            $users              = $request->input("users");
            $date               = date("Y-m-d");
            $hour               = date("H:i:s");
            $messageReturn      = "true";
            $slcBussines        = $request->input("slcBussines");
            $flag               = "true";
            $pkAlert              = $request->input("pkAler");
            DB::beginTransaction();
              
            try { 
                
                 $updateAlert         = DB::table('users_per_alert')
                                      ->where('fkAlert','=',$pkAlert)
                                      ->where('status','=',1) 
                                      ->update(["status" => 0]);
                 
                 if($updateAlert >= 1){ 
                
             }else{
                $flag = "false";
            }
            
             $updateAlert         = DB::table('alerts')
                                      ->where('pkAlert','=',$pkAlert)
                                      ->where('status','=',1) 
                                      ->update(["title" => $title
                                               ,"fkBussiness" => $slcBussines
                                               ,"comment" => $message]);
            
                if((strpos($users, ",") !== FALSE)){
                    $usersArray = explode(",", $users);
                    foreach ($usersArray as $usersInfo) {
                        $insertAlertUser                        = new Users_per_alert;
                        $insertAlertUser->fkAlert               = $pkAlert;
                        $insertAlertUser->fkUser_assigned       = $usersInfo;
                        $insertAlertUser->view                  = 0;
                        $insertAlertUser->status                = 1;

                        if($insertAlertUser->save()){

                        }else{
                            $flag = "false";
                            $messageReturn .= "Error al agregar notificaci\u00F3n a usuario: ".$usersInfo." \n";
                        }
                    }
                }else{
                    if($users != ""){
                        $insertAlertUser                        = new Users_per_alert;
                        $insertAlertUser->fkAlert               = $pkAlert;
                        $insertAlertUser->fkUser_assigned       = $users;
                        $insertAlertUser->view                  = 0;
                        $insertAlertUser->status                = 1;

                        if($insertAlertUser->save()){

                        }else{
                            $flag = "false";
                            $messageReturn .= "Error al agregar notificaci\u00F3n a usuario: ".$users." \n";
                        }
                    }
                }
               
            
            if($flag == "true"){
                DB::commit();
                return $messageReturn;
            }else{
                DB::rollback(); 
                return $messageReturn;
            }
        } catch (\Exception $e) {
                DB::rollback(); 
                //return "Error del sistema, favor de contactar al desarrollador";
                return $e->getMessage();
        }   
        }            
            
	
}
