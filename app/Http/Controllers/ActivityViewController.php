<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Activities;
use Illuminate\Http\Request;

class ActivityViewController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        private function convertName ($name) 
        {
            $newName = str_replace("&ntilde;", "\u00F1", str_replace("&Ntilde;", "\u00D1", str_replace("&Uacute;", "\u00DA", str_replace("&Oacute;", "\u00D3", str_replace("&Iacute;", "\u00CD", str_replace("&Eacute;", "\u00C9", str_replace("&Aacute;", "\u00C1", str_replace("&uacute;", "\u00FA", str_replace("&oacute;", "\u00F3", str_replace("&iacute;", "\u00ED", str_replace("&eacute;", "\u00E9", str_replace("&aacute;", "\u00E1", $name))))))))))));
        
            return $newName;
        }


        public function activity()
        {
            $date                   = date("Y-m-d");
            $hour                   = date("H:i:s");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            
            
            $lastActivitiesQuery    = DB::table('activities')
                                        ->join('activities_type', function ($join) {
                                            $join->on('activities_type.pkActivities_type', '=', 'activities.fkActivities_type');
                                        })
                                        ->join('activities_subtype', function ($join) {
                                            $join->on('activities_subtype.pkActivities_subtype', '=', 'activities.fkActivities_subtype');
                                        })
                                        ->join('users', function ($join) {
                                            $join->on('users.pkUser', '=', 'activities.fkUser');
                                        })
                                        ->join('business', function ($join) {
                                            $join->on('business.pkBusiness', '=', 'activities.fkBusiness');
                                        })
                                        ->where('activities.status', '=', 1)
                                        ->where('activities_type.status', '=', 1)
                                        ->where('activities_subtype.status', '=', 1)
                                        ->where('users.status', '=', 1)
                                        ->where('business.status', '=', 1)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('execution_date', '>=', "".$startDate."")
                                                  ->where('execution_date', '<=', "".$endDate."");
                                        })
                                        ->where('activities.fkActivities_type', '>', 0)
                                        ->select(
                                                'activities.fkActivities_type AS fkActivities_type',
                                                'activities.fkActivities_subtype AS fkActivities_subtype',
                                                'activities.description AS description',
                                                'activities.execution_date AS execution_date',
                                                'activities.execution_hour AS execution_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'activities_subtype.text AS text_subtype',
                                                'activities_subtype.color AS color_subtype',
                                                'users.full_name AS full_name',
                                                'users.color AS user_color',
                                                'business.name AS business_name')
                                        ->orderBy("execution_date", "desc")
                                        ->orderBy("execution_hour", "desc")
                                        ->get(); 
                                        
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
                                        ->where('activities.status', '=', 1)
                                        ->where('activities_type.status', '=', 1)
                                        ->where('users.status', '=', 1)
                                        ->where('business.status', '=', 1)
                                        ->where('activities.execution_date', '=', NULL)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('final_date', '>=', "".$startDate."")
                                                  ->where('final_date', '<=', "".$endDate."");
                                        })
                                        ->where('activities.fkActivities_type', '>', 0)
                                        ->select(
                                                'activities.fkActivities_type AS fkActivities_type',
                                                'activities.description AS description',
                                                'activities.pkActivities',
                                                'activities.final_date AS final_date',
                                                'activities.final_hour AS final_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'users.full_name AS full_name',
                                                'users.color AS user_color',
                                                'business.name AS business_name')
                                        ->orderBy("final_date", "asc")
                                        ->orderBy("final_hour", "asc")
                                        ->get();                             
            
            $usersQuery             = DB::table('users')
                                            ->select('pkUser','full_name','color')
                                            ->where('status','=',1)
                                            ->where('fkUser_type','!=',1)//QUE NO SEA SUPERUSUARIO
                                            ->get();                            
            
            $typeActivitiesQuery    = DB::table('activities_type')
                                            ->select('pkActivities_type','text'
                                                    ,'color')
                                            ->where('pkActivities_type','>',0)
                                            ->where('status','=',1)
                                            ->get(); 
            
            $subtypeActivitiesQuery = DB::table('activities_subtype')
                                            ->select('pkActivities_subtype','text'
                                                    ,'color')
                                            ->where('status','=',1)
                                            ->where('fkActivities_type','=',1)// LLAMADAS
                                            ->get(); 
            

            
            $totalActivities        = 0;
            $typeActivityArray      = array();
            $subtypeActivityArray   = array();
            $activitiesArray        = array();
            $activitiesByAgentArray = array();
            $namesTypeActivities    = "";
            $colorsTypeActivities   = "";
            $totalTypeActivities    = "";
            $contTypeActivities     = 0;
            $namesSubtypeActivities    = "";
            $colorsSubtypeActivities   = "";
            $totalSubtypeActivities    = "";
            $contSubtypeActivities     = 0;
                                        
            foreach ($lastActivitiesQuery as $lastActivitiesInfo) {
                if(isset($typeActivityArray[$lastActivitiesInfo->fkActivities_type])){
                    $typeActivityArray[$lastActivitiesInfo->fkActivities_type]++;
                }else{
                    $typeActivityArray[$lastActivitiesInfo->fkActivities_type] = 1;
                }
                
                if(isset($subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype])){
                    $subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype]++;
                }else{
                    $subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype] = 1;
                }
                
                if(isset($activitiesByAgentArray[$lastActivitiesInfo->full_name]["total"])){
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["total"]++;
                }else{
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["total"]    = 1;
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["color"]    = $lastActivitiesInfo->user_color;
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["name"]     = $lastActivitiesInfo->full_name;
                }
                
                if(isset($activitiesByAgentArray[$lastActivitiesInfo->full_name][$lastActivitiesInfo->fkActivities_type])){
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name][$lastActivitiesInfo->fkActivities_type]++;
                }else{
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name][$lastActivitiesInfo->fkActivities_type] = 1;
                }
               
                $totalActivities++;
            }
            
            foreach ($activitiesQuery as $activitiesInfo) {
                if(isset($typeActivityArray[$activitiesInfo->fkActivities_type])){
                    $typeActivityArray[$activitiesInfo->fkActivities_type]++;
                }else{
                    $typeActivityArray[$activitiesInfo->fkActivities_type] = 1;
                }
                
                if(isset($subtypeActivityArray[0])){
                    $subtypeActivityArray[0]++;
                }else{
                    $subtypeActivityArray[0] = 1;
                }
                
                $totalActivities++;
            }
            
            $contGraphicPie     = 0;
            $dataGraphicPie     = "";
            $dataGraphicPieTwo  = "";
            $userHightTotal     = 0;
            $userHight          = "";
            

            
            foreach ($usersQuery as $usersInfo) {
                if($contGraphicPie < 1){
                    if(isset($activitiesByAgentArray[$usersInfo->full_name]["total"])){
                        $dataGraphicPie .= '{
                                                label: "'.$this->convertName($usersInfo->full_name).'",
                                                data: '.$activitiesByAgentArray[$usersInfo->full_name]["total"].',
                                                color: "'.$activitiesByAgentArray[$usersInfo->full_name]["color"].'"
                                            }';
                        if($userHightTotal < $activitiesByAgentArray[$usersInfo->full_name]["total"]){
                            $userHight      = $usersInfo->full_name;
                            $userHightTotal = $activitiesByAgentArray[$usersInfo->full_name]["total"];
                        }
                    }else{
                       $dataGraphicPie  .= ' {
                                                label: "'.$this->convertName($usersInfo->full_name).'",
                                                data: 0,
                                                color: "#aaaaaa"
                                            }';
                    }
                }else{
                    if(isset($activitiesByAgentArray[$usersInfo->full_name]["total"])){
                        $dataGraphicPie .= ',{
                                                label: "'.$this->convertName($usersInfo->full_name).'",
                                                data: '.$activitiesByAgentArray[$usersInfo->full_name]["total"].',
                                                color: "'.$activitiesByAgentArray[$usersInfo->full_name]["color"].'"
                                            }';
                        
                        if($userHightTotal < $activitiesByAgentArray[$usersInfo->full_name]["total"]){
                            $userHight      = $usersInfo->full_name;
                            $userHightTotal = $activitiesByAgentArray[$usersInfo->full_name]["total"];
                        }
                    }else{
                       $dataGraphicPie  .= ',{
                                                label: "'.$this->convertName($usersInfo->full_name).'",
                                                data: 0,
                                                color: "#aaaaaa"
                                            }';
                    }
                }
                $contGraphicPie++;
            }
          
            foreach ($typeActivitiesQuery as $typeActivitiesInfo) {
                if($contTypeActivities > 0){
                    $namesTypeActivities  .= ",'".$typeActivitiesInfo->text."'";
                    $colorsTypeActivities .= ",'".$typeActivitiesInfo->color."'";
                    
                    if(isset($typeActivityArray[$typeActivitiesInfo->pkActivities_type])){
                        $totalTypeActivities .= ",".$typeActivityArray[$typeActivitiesInfo->pkActivities_type]."";
                    }else{
                        $totalTypeActivities .= ",0";
                    }
                }else{
                    $colorsTypeActivities .= "'".$typeActivitiesInfo->color."'";
                    $namesTypeActivities  .= "'".$typeActivitiesInfo->text."'";
                    
                    if(isset($typeActivityArray[$typeActivitiesInfo->pkActivities_type])){
                        $totalTypeActivities .= $typeActivityArray[$typeActivitiesInfo->pkActivities_type];
                    }else{
                        $totalTypeActivities .= "0";
                    }
                }
                
                if($contTypeActivities < 1){
                    if(isset($activitiesByAgentArray[$userHight][$typeActivitiesInfo->pkActivities_type])){
                        $dataGraphicPieTwo .= '{
                                                label: "'.$this->convertName($typeActivitiesInfo->text).'",
                                                data: '.$activitiesByAgentArray[$userHight][$typeActivitiesInfo->pkActivities_type].',
                                                color: "'.$typeActivitiesInfo->color.'"
                                            }';
                    }else{
                       $dataGraphicPieTwo  .= ' {
                                                label: "'.$this->convertName($typeActivitiesInfo->text).'",
                                                data: 0,
                                                color: "'.$typeActivitiesInfo->color.'"
                                            }';
                    }
                }else{
                    if(isset($activitiesByAgentArray[$userHight][$typeActivitiesInfo->pkActivities_type])){
                        $dataGraphicPieTwo .= ',{
                                                label: "'.$this->convertName($typeActivitiesInfo->text).'",
                                                data: '.$activitiesByAgentArray[$userHight][$typeActivitiesInfo->pkActivities_type].',
                                                color: "'.$typeActivitiesInfo->color.'"
                                            }';
                    }else{
                       $dataGraphicPieTwo  .= ',{
                                                label: "'.$this->convertName($typeActivitiesInfo->text).'",
                                                data: 0,
                                                color: "'.$typeActivitiesInfo->color.'"
                                            }';
                    }
                }
                $contTypeActivities++;
            }
            
            foreach ($subtypeActivitiesQuery as $subtypeActivitiesInfo) {
                if($contSubtypeActivities > 0){
                    $namesSubtypeActivities  .= ",'".$subtypeActivitiesInfo->text."'";
                    $colorsSubtypeActivities .= ",'".$subtypeActivitiesInfo->color."'";
                    
                    if(isset($subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype])){
                        $totalSubtypeActivities .= ",".$subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype]."";
                    }else{
                        $totalSubtypeActivities .= ",0";
                    }
                }else{
                    $colorsSubtypeActivities .= "'#E4DAD8'";
                    $namesSubtypeActivities  .= "'Pendiente'";
                    
                    if(isset($subtypeActivityArray[0])){
                        $totalSubtypeActivities .= $subtypeActivityArray[0];
                    }else{
                        $totalSubtypeActivities .= "0";
                    }
                    
                    $colorsSubtypeActivities .= ",'".$subtypeActivitiesInfo->color."'";
                    $namesSubtypeActivities  .= ",'".$subtypeActivitiesInfo->text."'";
                    
                    if(isset($subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype])){
                        $totalSubtypeActivities .= ",".$subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype];
                    }else{
                        $totalSubtypeActivities .= ",0";
                    }
                }
                
                $contSubtypeActivities++;
            }
            
            $namesTypeActivities    = $this->convertName($namesTypeActivities);
            $namesSubtypeActivities = $this->convertName($namesSubtypeActivities);
            
            $agent = DB::table('users')
                        ->select('pkUser'
                                ,'full_name')
                        ->where('status','=',1)
                        ->where('pkUser','!=',1)
                        ->get();
            
            $campaning = DB::table('commercial_campaigns')
                           ->select('pkCommercial_campaigns'
                                   ,'name')
                           ->where('status','=',1)
                           ->get();
            
            $activities = DB::table('activities_type')
                            ->select('pkActivities_type'
                                    ,'text'
                                    ,'icon')
                            ->where('status','=',1)
                            ->where('pkActivities_type','>',0)
                            ->get();
         
            
            return view('actividad.actividad', [
                                      "lastActivitiesQuery"     => $lastActivitiesQuery,
                                      "activitiesQuery"         => $activitiesQuery,
                                      "date"                    => $date,
                                      "hour"                    => $hour,
                                      "activitiesArray"         => $activitiesArray,
                                      "namesTypeActivities"     => $namesTypeActivities,
                                      "colorsTypeActivities"    => $colorsTypeActivities,
                                      "totalTypeActivities"     => $totalTypeActivities,
                                      "namesSubtypeActivities"  => $namesSubtypeActivities,
                                      "colorsSubtypeActivities" => $colorsSubtypeActivities,
                                      "totalSubtypeActivities"  => $totalSubtypeActivities,
                                      "dataGraphicPie"          => $dataGraphicPie,
                                      "dataGraphicPieTwo"       => $dataGraphicPieTwo,
                                      "userHight"               => $userHight,
                                      "agent"                   => $agent,
                                      "campaning"               => $campaning,
                                      "activities"              => $activities
            ]);
        }
        
        public function loadPieGraphicTypeActivities (Request $request) 
        {
            $text                   = htmlentities ($request->input("text"));
            $date                   = date("Y-m-d");
            $hour                   = date("H:i:s");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            
            
            $lastActivitiesQuery    = DB::table('activities')
                                        ->join('activities_type', function ($join) {
                                            $join->on('activities_type.pkActivities_type', '=', 'activities.fkActivities_type');
                                        })
                                        ->join('activities_subtype', function ($join) {
                                            $join->on('activities_subtype.pkActivities_subtype', '=', 'activities.fkActivities_subtype');
                                        })
                                        ->join('users', function ($join) {
                                            $join->on('users.pkUser', '=', 'activities.fkUser');
                                        })
                                        ->join('business', function ($join) {
                                            $join->on('business.pkBusiness', '=', 'activities.fkBusiness');
                                        })
                                        ->where('activities.status', '=', 1)
                                        ->where('pkActivities_type','>',0)
                                        ->where('activities_type.status', '=', 1)
                                        ->where('activities_type.text', '=', $text)
                                        ->where('activities_subtype.status', '=', 1)
                                        ->where('users.status', '=', 1)
                                        ->where('business.status', '=', 1)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('execution_date', '>=', "".$startDate."")
                                                  ->where('execution_date', '<=', "".$endDate."");
                                        })
                                        ->select(
                                                'activities.fkActivities_type AS fkActivities_type',
                                                'activities.fkActivities_subtype AS fkActivities_subtype',
                                                'activities.description AS description',
                                                'activities.execution_date AS execution_date',
                                                'activities.execution_hour AS execution_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'activities_subtype.text AS text_subtype',
                                                'activities_subtype.color AS color_subtype',
                                                'users.full_name AS full_name',
                                                'users.color AS user_color',
                                                'business.name AS business_name')
                                        ->orderBy("execution_date", "desc")
                                        ->orderBy("execution_hour", "desc")
                                        ->get(); 
                                        
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
                                        ->where('activities.status', '=', 1)
                                        ->where('activities_type.text', '=', $text)
                                        ->where('activities_type.status', '=', 1)
                                        ->where('users.status', '=', 1)
                                        ->where('business.status', '=', 1)
                                        ->where('pkActivities_type','>',0)
                                        ->where('activities.execution_date', '=', NULL)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('final_date', '>=', "".$startDate."")
                                                  ->where('final_date', '<=', "".$endDate."");
                                        })
                                        ->select(
                                                'activities.fkActivities_type AS fkActivities_type',
                                                'activities.description AS description',
                                                'activities.final_date AS final_date',
                                                'activities.final_hour AS final_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'users.full_name AS full_name',
                                                'users.color AS user_color',
                                                'business.name AS business_name')
                                        ->orderBy("final_date", "desc")
                                        ->orderBy("final_hour", "desc")
                                        ->get(); 
                                        
            $subtypeActivitiesQuery = DB::table('activities_subtype')
                                            ->join('activities_type', function ($join) {
                                                $join->on('activities_type.pkActivities_type', '=', 'activities_subtype.fkActivities_type');
                                            })
                                            ->select('activities_subtype.pkActivities_subtype as pkActivities_subtype','activities_subtype.text as text'
                                                    ,'activities_subtype.color as color')
                                            ->where('activities_subtype.status','=',1)
                                            ->where('activities_subtype.status','=',1)
                                            ->where('activities_type.text','=',$text)
                                            ->where('pkActivities_type','>',0)
                                            ->get();                             
            
            $subtypeActivityArray      = array();
            $namesSubtypeActivities    = "";
            $colorsSubtypeActivities   = "";
            $totalSubtypeActivities    = "";
            $contSubtypeActivities     = 0;
                                        
            foreach ($lastActivitiesQuery as $lastActivitiesInfo) {
                if(isset($subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype])){
                    $subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype]++;
                }else{
                    $subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype] = 1;
                }
            }
            
            foreach ($activitiesQuery as $activitiesInfo) {
                if(isset($subtypeActivityArray[0])){
                    $subtypeActivityArray[0]++;
                }else{
                    $subtypeActivityArray[0] = 1;
                }
            }
            
            foreach ($subtypeActivitiesQuery as $subtypeActivitiesInfo) {
                if($contSubtypeActivities > 0){
                    $namesSubtypeActivities  .= ',"'.$subtypeActivitiesInfo->text.'"';
                    $colorsSubtypeActivities .=',"'.$subtypeActivitiesInfo->color.'"';
                    
                    if(isset($subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype])){
                        $totalSubtypeActivities .= ",".$subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype]."";
                    }else{
                        $totalSubtypeActivities .= ",0";
                    }
                }else{
                    $colorsSubtypeActivities .= '"#E4DAD8"';
                    $namesSubtypeActivities  .= '"Pendiente"';
                    
                    if(isset($subtypeActivityArray[0])){
                        $totalSubtypeActivities .= $subtypeActivityArray[0];
                    }else{
                        $totalSubtypeActivities .= "0";
                    }
                    
                    $colorsSubtypeActivities .= ',"'.$subtypeActivitiesInfo->color.'"';
                    $namesSubtypeActivities  .= ',"'.$subtypeActivitiesInfo->text.'"';
                    
                    if(isset($subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype])){
                        $totalSubtypeActivities .= ",".$subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype];
                    }else{
                        $totalSubtypeActivities .= ",0";
                    }
                }
                
                $contSubtypeActivities++;
            }
            
            $namesSubtypeActivities = $this->convertName($namesSubtypeActivities);
            
            
            $string = '{"labels":['.$namesSubtypeActivities.'],
                        "datasets":[{
                            "label":"'.$text.'",
                            "data":['.$totalSubtypeActivities.'],
                            "backgroundColor":['.$colorsSubtypeActivities.']}
                        ]}';
            
            return \Response::json(array(
                                      "text"         => $text,
                                      "data"         => $string
            ));  
            
        }
        
        public function loadPieGraphicAgents (Request $request) 
        {
            $text           = htmlentities ($request->input("text"));
            
            $contGraphicPie     = 0;
            $dataGraphicPie     = "";
            $userHightTotal     = 0;
            $userHight          = "";
            $date                   = date("Y-m-d");
            $hour                   = date("H:i:s");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            $activitiesByAgentArray = array();
            
            $lastActivitiesQuery    = DB::table('activities')
                                        ->join('activities_type', function ($join) {
                                            $join->on('activities_type.pkActivities_type', '=', 'activities.fkActivities_type');
                                        })
                                        ->join('activities_subtype', function ($join) {
                                            $join->on('activities_subtype.pkActivities_subtype', '=', 'activities.fkActivities_subtype');
                                        })
                                        ->join('users', function ($join) {
                                            $join->on('users.pkUser', '=', 'activities.fkUser');
                                        })
                                        ->join('business', function ($join) {
                                            $join->on('business.pkBusiness', '=', 'activities.fkBusiness');
                                        })
                                        ->where('activities.status', '=', 1)
                                        ->where('activities_type.status', '=', 1)
                                        ->where('users.full_name', '=', $text)
                                        ->where('activities_subtype.status', '=', 1)
                                        ->where('users.status', '=', 1)
                                        ->where('business.status', '=', 1)
                                        ->where('pkActivities_type','>',0)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('execution_date', '>=', "".$startDate."")
                                                  ->where('execution_date', '<=', "".$endDate."");
                                        })
                                        ->select(
                                                'activities.fkActivities_type AS fkActivities_type',
                                                'activities.fkActivities_subtype AS fkActivities_subtype',
                                                'activities.description AS description',
                                                'activities.execution_date AS execution_date',
                                                'activities.execution_hour AS execution_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'activities_subtype.text AS text_subtype',
                                                'activities_subtype.color AS color_subtype',
                                                'users.full_name AS full_name',
                                                'users.color AS user_color',
                                                'business.name AS business_name')
                                        ->orderBy("execution_date", "desc")
                                        ->orderBy("execution_hour", "desc")
                                        ->get();
            
            foreach ($lastActivitiesQuery as $lastActivitiesInfo) {
                if(isset($activitiesByAgentArray[$lastActivitiesInfo->fkActivities_type]["total"])){
                    $activitiesByAgentArray[$lastActivitiesInfo->fkActivities_type]["total"]++;
                }else{
                    $activitiesByAgentArray[$lastActivitiesInfo->fkActivities_type]["total"]    = 1;
                    $activitiesByAgentArray[$lastActivitiesInfo->fkActivities_type]["color"]    = $lastActivitiesInfo->color;
                    $activitiesByAgentArray[$lastActivitiesInfo->fkActivities_type]["name"]     = $lastActivitiesInfo->text;
                }
            }
            
            $typeActivitiesQuery    = DB::table('activities_type')
                                            ->select('pkActivities_type','text'
                                                    ,'color')
                                            ->where('status','=',1)
                                            ->where('pkActivities_type','>',0)
                                            ->get();
            
            foreach ($typeActivitiesQuery as $typeActivitiesInfo) {
                if($contGraphicPie < 1){
                    if(isset($activitiesByAgentArray[$typeActivitiesInfo->pkActivities_type]["total"])){
                        $dataGraphicPie .= '[{
                                                "label": "'.$this->convertName($typeActivitiesInfo->text).'",
                                                "data": '.$activitiesByAgentArray[$typeActivitiesInfo->pkActivities_type]["total"].',
                                                "color": "'.$activitiesByAgentArray[$typeActivitiesInfo->pkActivities_type]["color"].'"
                                            }';
                    }else{
                       $dataGraphicPie  .= '[{
                                                "label": "'.$this->convertName($typeActivitiesInfo->text).'",
                                                "data": 0,
                                                "color": "#aaaaaa"
                                            }';
                    }
                }else{
                    if(isset($activitiesByAgentArray[$typeActivitiesInfo->pkActivities_type]["total"])){
                        $dataGraphicPie .= ',{
                                                "label": "'.$this->convertName($typeActivitiesInfo->text).'",
                                                "data": '.$activitiesByAgentArray[$typeActivitiesInfo->pkActivities_type]["total"].',
                                                "color": "'.$activitiesByAgentArray[$typeActivitiesInfo->pkActivities_type]["color"].'"
                                            }';
                    }else{
                       $dataGraphicPie  .= ',{
                                                "label": "'.$this->convertName($typeActivitiesInfo->text).'",
                                                "data": 0,
                                                "color": "#aaaaaa"
                                            }';
                    }
                }
                $contGraphicPie++;
            }
            
            return \Response::json(array(
                                      "text"         => $text,
                                      "data"         => $dataGraphicPie."]"
            )); 
        }
        
        public function loadModalSubActivity(Request $request){
           
            $text                   = htmlentities ($request->input("text"));
            $activity               = htmlentities ($request->input("activity"));
            
            $date                   = date("Y-m-d");
            $hour                   = date("H:i:s");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;

            
            $subActivities = DB::table('activities as a')
                               ->join('business as b','b.pkBusiness','=','a.fkBusiness')
                               ->join('users as u','u.pkUser','=','a.fkUser')
                               ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                               ->join('activities_subtype as s','s.pkActivities_subtype','=','a.fkActivities_subtype')
                               ->select('b.name as bussines'
                                        ,'u.full_name as agent'
                                        ,'t.text as type'
                                        ,'s.text as subtype'
                                        ,'a.description'
                                        ,DB::raw("DATE_FORMAT(execution_date, '%d/%m/%Y') as execution_date")
                                        ,'execution_hour'
                                        ,'a.comment')
                               ->where('s.text','=',$text)
                               ->get();
            
              $view = view('actividad.getModalSubActivity', array(
                    "subActivities" => $subActivities,
                    "activity"      => $activity,
                    "text"          => $text
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                )); 
            
        }
        
        public function loadModalActivityByAgent(Request $request){
            
            $text                   = htmlentities ($request->input("text"));
            $user                   = htmlentities ($request->input("user"));

            $date                   = date("Y-m-d");
            $hour                   = date("H:i:s");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            
            $subActivities = DB::table('activities as a')
                               ->join('business as b','b.pkBusiness','=','a.fkBusiness')
                               ->join('users as u','u.pkUser','=','a.fkUser')
                               ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                               ->join('activities_subtype as s','s.pkActivities_subtype','=','a.fkActivities_subtype')
                               ->select('b.name as bussines'
                                        ,'u.full_name as agent'
                                        ,'t.text as type'
                                        ,'s.text as subtype'
                                        ,'a.description'
                                        ,DB::raw("DATE_FORMAT(execution_date, '%d/%m/%Y') as execution_date")
                                        ,'execution_hour'
                                        ,'a.comment')
                               ->where('t.text','=',$text)
                               ->where('u.full_name','=',$user)
                               ->get();
            
            
              $view = view('actividad.getModalActivityAgent', array(
                    "subActivities" => $subActivities,
                    "text" => $text,
                    "user" => $user
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                )); 
        }
        
        public function seachArcivityAgent(Request $request){
            
            
            $date                   = date("Y-m-d");
            $hour                   = date("H:i:s");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            $agent                  = $request->input("Agent");
            
            
            $lastActivitiesQuery    = DB::table('activities')
                                        ->join('activities_type', function ($join) {
                                            $join->on('activities_type.pkActivities_type', '=', 'activities.fkActivities_type');
                                        })
                                        ->join('activities_subtype', function ($join) {
                                            $join->on('activities_subtype.pkActivities_subtype', '=', 'activities.fkActivities_subtype');
                                        })
                                        ->join('users', function ($join) {
                                            $join->on('users.pkUser', '=', 'activities.fkUser');
                                        })
                                        ->join('business', function ($join) {
                                            $join->on('business.pkBusiness', '=', 'activities.fkBusiness');
                                        })
                                        ->where('activities.status', '=', 1)
                                        ->where('activities_type.status', '=', 1)
                                        ->where('activities_subtype.status', '=', 1)
                                        ->where('users.status', '=', 1)
                                        ->where('business.status', '=', 1)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('execution_date', '>=', "".$startDate."")
                                                  ->where('execution_date', '<=', "".$endDate."");
                                        })
                                        ->where('activities.fkActivities_type', '>', 0)
                                        ->select(
                                                'activities.fkActivities_type AS fkActivities_type',
                                                'activities.fkActivities_subtype AS fkActivities_subtype',
                                                'activities.description AS description',
                                                'activities.execution_date AS execution_date',
                                                'activities.execution_hour AS execution_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'activities_subtype.text AS text_subtype',
                                                'activities_subtype.color AS color_subtype',
                                                'users.full_name AS full_name',
                                                'users.color AS user_color',
                                                'business.name AS business_name');
                                        
                                        if($agent > 0){
                                         $lastActivitiesQuery = $lastActivitiesQuery->where('users.pkUser','=',$agent);   
                                        }
                                        
                                         $lastActivitiesQuery = $lastActivitiesQuery->orderBy("execution_date", "desc")
                                        ->orderBy("execution_hour", "desc")
                                        ->get(); 
                                        
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
                                        ->where('activities.status', '=', 1)
                                        ->where('activities_type.status', '=', 1)
                                        ->where('users.status', '=', 1)
                                        ->where('business.status', '=', 1)
                                        ->where('activities.execution_date', '=', NULL)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('final_date', '>=', "".$startDate."")
                                                  ->where('final_date', '<=', "".$endDate."");
                                        })
                                        ->where('activities.fkActivities_type', '>', 0)
                                        ->select(
                                                'activities.fkActivities_type AS fkActivities_type',
                                                'activities.description AS description',
                                                'activities.pkActivities',
                                                'activities.final_date AS final_date',
                                                'activities.final_hour AS final_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'users.full_name AS full_name',
                                                'users.color AS user_color',
                                                'business.name AS business_name');
                                        
                                         if($agent > 0){
                                         $activitiesQuery = $activitiesQuery->where('users.pkUser','=',$agent);   
                                        }
                                        
                                         $activitiesQuery = $activitiesQuery->orderBy("final_date", "desc")
                                        ->orderBy("final_hour", "desc")
                                        ->get();                             
            
                                    
                                        
            $usersQuery             = DB::table('users')
                                            ->select('pkUser','full_name','color')
                                            ->where('status','=',1)
                                            ->where('fkUser_type','!=',1)//QUE NO SEA SUPERUSUARIO
                                            ->get();                            
            
            $typeActivitiesQuery    = DB::table('activities_type')
                                            ->select('pkActivities_type','text'
                                                    ,'color')
                                            ->where('pkActivities_type','>',0)
                                            ->where('status','=',1)
                                            ->get(); 
            
            $subtypeActivitiesQuery = DB::table('activities_subtype')
                                            ->select('pkActivities_subtype','text'
                                                    ,'color')
                                            ->where('status','=',1)
                                            ->where('fkActivities_type','=',2)// LLAMADAS
                                            ->get(); 
            

            
            $totalActivities        = 0;
            $typeActivityArray      = array();
            $subtypeActivityArray   = array();
            $activitiesArray        = array();
            $activitiesByAgentArray = array();
            $namesTypeActivities    = "";
            $colorsTypeActivities   = "";
            $totalTypeActivities    = "";
            $contTypeActivities     = 0;
            $namesSubtypeActivities    = "";
            $colorsSubtypeActivities   = "";
            $totalSubtypeActivities    = "";
            $contSubtypeActivities     = 0;
                                        
            foreach ($lastActivitiesQuery as $lastActivitiesInfo) {
                if(isset($typeActivityArray[$lastActivitiesInfo->fkActivities_type])){
                    $typeActivityArray[$lastActivitiesInfo->fkActivities_type]++;
                }else{
                    $typeActivityArray[$lastActivitiesInfo->fkActivities_type] = 1;
                }
                
                if(isset($subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype])){
                    $subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype]++;
                }else{
                    $subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype] = 1;
                }
                
                if(isset($activitiesByAgentArray[$lastActivitiesInfo->full_name]["total"])){
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["total"]++;
                }else{
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["total"]    = 1;
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["color"]    = $lastActivitiesInfo->user_color;
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["name"]     = $lastActivitiesInfo->full_name;
                }
                
                if(isset($activitiesByAgentArray[$lastActivitiesInfo->full_name][$lastActivitiesInfo->fkActivities_type])){
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name][$lastActivitiesInfo->fkActivities_type]++;
                }else{
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name][$lastActivitiesInfo->fkActivities_type] = 1;
                }
               
                $totalActivities++;
            }
            
            foreach ($activitiesQuery as $activitiesInfo) {
                if(isset($typeActivityArray[$activitiesInfo->fkActivities_type])){
                    $typeActivityArray[$activitiesInfo->fkActivities_type]++;
                }else{
                    $typeActivityArray[$activitiesInfo->fkActivities_type] = 1;
                }
                
                if(isset($subtypeActivityArray[0])){
                    $subtypeActivityArray[0]++;
                }else{
                    $subtypeActivityArray[0] = 1;
                }
                
                $totalActivities++;
            }
            
            

            
         $view = view('actividad.getActivityAgent', array(
                                      "lastActivitiesQuery"     => $lastActivitiesQuery,
                                      "activitiesQuery"         => $activitiesQuery,
                                      "date"                    => $date,
                                      "hour"                    => $hour,
                                      "activitiesArray"         => $activitiesArray,
                                      "namesTypeActivities"     => $namesTypeActivities,
                                      "colorsTypeActivities"    => $colorsTypeActivities,
                                      "totalTypeActivities"     => $totalTypeActivities,
                                      "namesSubtypeActivities"  => $namesSubtypeActivities,
                                      "colorsSubtypeActivities" => $colorsSubtypeActivities,
                                      "totalSubtypeActivities"  => $totalSubtypeActivities
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
            
        }

    public function actividadSearch(Request $request){
       
            $date                   = date("Y-m-d");
            $hour                   = date("H:i:s");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;

            $typeActivity           = $request->input("typeActivity");
            $typeCampaning          = $request->input("typeCampaning");
            $dateInitial            = $request->input("dateInitial");
            $dateFinish             = $request->input("dateFinish");

            if(!empty($dateInitial)){
                $startDate = $dateInitial;
            }

            if(!empty($dateFinish)){
                $endDate =   $dateFinish;
            }
            
            
            $lastActivitiesQuery    = DB::table('activities')
                                        ->join('activities_type', function ($join) {
                                            $join->on('activities_type.pkActivities_type', '=', 'activities.fkActivities_type');
                                        })
                                        ->join('activities_subtype', function ($join) {
                                            $join->on('activities_subtype.pkActivities_subtype', '=', 'activities.fkActivities_subtype');
                                        })
                                        ->join('users', function ($join) {
                                            $join->on('users.pkUser', '=', 'activities.fkUser');
                                        })
                                        ->join('business', function ($join) {
                                            $join->on('business.pkBusiness', '=', 'activities.fkBusiness');
                                        })
                                        ->where('activities.status', '=', 1)
                                        ->where('activities_type.status', '=', 1)
                                        ->where('activities_subtype.status', '=', 1)
                                        ->where('users.status', '=', 1)
                                        ->where('business.status', '=', 1)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('execution_date', '>=', "".$startDate."")
                                                  ->where('execution_date', '<=', "".$endDate."");
                                        })
                                        ->where('activities.fkActivities_type', '>', 0)
                                        ->select(
                                                'activities.fkActivities_type AS fkActivities_type',
                                                'activities.fkActivities_subtype AS fkActivities_subtype',
                                                'activities.description AS description',
                                                'activities.execution_date AS execution_date',
                                                'activities.execution_hour AS execution_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'activities_subtype.text AS text_subtype',
                                                'activities_subtype.color AS color_subtype',
                                                'users.full_name AS full_name',
                                                'users.color AS user_color',
                                                'business.name AS business_name')
                                        ->orderBy("execution_date", "desc")
                                        ->orderBy("execution_hour", "desc");

                                        if($typeCampaning > 0){
                                            $lastActivitiesQuery = $lastActivitiesQuery->where('activities.fkCampaign','=',$typeCampaning); 
                                        }

                                        if($typeActivity > 0){
                                            $lastActivitiesQuery = $lastActivitiesQuery->where('activities.fkActivities_type','=',$typeActivity);
                                        }

                                        
                                        $lastActivitiesQuery  = $lastActivitiesQuery->get(); 
                                        
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
                                        ->where('activities.status', '=', 1)
                                        ->where('activities_type.status', '=', 1)
                                        ->where('users.status', '=', 1)
                                        ->where('business.status', '=', 1)
                                        ->where('activities.execution_date', '=', NULL)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('final_date', '>=', "".$startDate."")
                                                  ->where('final_date', '<=', "".$endDate."");
                                        })
                                        ->where('activities.fkActivities_type', '>', 0)
                                        ->select(
                                                'activities.fkActivities_type AS fkActivities_type',
                                                'activities.description AS description',
                                                'activities.pkActivities',
                                                'activities.final_date AS final_date',
                                                'activities.final_hour AS final_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'users.full_name AS full_name',
                                                'users.color AS user_color',
                                                'business.name AS business_name');

                                     if($typeCampaning > 0){
                                            $activitiesQuery = $activitiesQuery->where('activities.fkCampaign','=',$typeCampaning); 
                                        }

                                        if($typeActivity > 0){
                                            $activitiesQuery = $activitiesQuery->where('activities.fkActivities_type','=',$typeActivity);
                                        }

                                        
           $activitiesQuery  = $activitiesQuery->orderBy("final_date", "desc")
                                                       ->orderBy("final_hour", "desc")
                                                       ->get();
                                                                     
            
            $usersQuery             = DB::table('users')
                                            ->select('pkUser','full_name','color')
                                            ->where('status','=',1)
                                            ->where('fkUser_type','!=',1)//QUE NO SEA SUPERUSUARIO
                                            ->get();                            
            
            if($typeActivity < 0){
            $typeActivitiesQuery    = DB::table('activities_type')
                                            ->select('pkActivities_type','text'
                                                    ,'color')
                                            ->where('pkActivities_type','>',0)
                                            ->where('status','=',1)
                                            ->get(); 
            }else{
               $typeActivitiesQuery    = DB::table('activities_type')
                                            ->select('pkActivities_type','text'
                                                    ,'color')
                                            ->where('pkActivities_type','=',$typeActivity)
                                            ->where('status','=',1)
                                            ->get();   
            }
            
            $subtypeActivitiesQuery = DB::table('activities_subtype')
                                            ->select('pkActivities_subtype','text'
                                                    ,'color')
                                            ->where('status','=',1)
                                            ->where('fkActivities_type','=',1)// LLAMADAS
                                            ->get(); 
            

            
            $totalActivities        = 0;
            $typeActivityArray      = array();
            $subtypeActivityArray   = array();
            $activitiesArray        = array();
            $activitiesByAgentArray = array();
            $namesTypeActivities    = "";
            $colorsTypeActivities   = "";
            $totalTypeActivities    = "";
            $contTypeActivities     = 0;
            $namesSubtypeActivities    = "";
            $colorsSubtypeActivities   = "";
            $totalSubtypeActivities    = "";
            $contSubtypeActivities     = 0;
                                        
            foreach ($lastActivitiesQuery as $lastActivitiesInfo) {
                if(isset($typeActivityArray[$lastActivitiesInfo->fkActivities_type])){
                    $typeActivityArray[$lastActivitiesInfo->fkActivities_type]++;
                }else{
                    $typeActivityArray[$lastActivitiesInfo->fkActivities_type] = 1;
                }
                
                if(isset($subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype])){
                    $subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype]++;
                }else{
                    $subtypeActivityArray[$lastActivitiesInfo->fkActivities_subtype] = 1;
                }
                
                if(isset($activitiesByAgentArray[$lastActivitiesInfo->full_name]["total"])){
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["total"]++;
                }else{
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["total"]    = 1;
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["color"]    = $lastActivitiesInfo->user_color;
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name]["name"]     = $lastActivitiesInfo->full_name;
                }
                
                if(isset($activitiesByAgentArray[$lastActivitiesInfo->full_name][$lastActivitiesInfo->fkActivities_type])){
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name][$lastActivitiesInfo->fkActivities_type]++;
                }else{
                    $activitiesByAgentArray[$lastActivitiesInfo->full_name][$lastActivitiesInfo->fkActivities_type] = 1;
                }
               
                $totalActivities++;
            }
            
            foreach ($activitiesQuery as $activitiesInfo) {
                if(isset($typeActivityArray[$activitiesInfo->fkActivities_type])){
                    $typeActivityArray[$activitiesInfo->fkActivities_type]++;
                }else{
                    $typeActivityArray[$activitiesInfo->fkActivities_type] = 1;
                }
                
                if(isset($subtypeActivityArray[0])){
                    $subtypeActivityArray[0]++;
                }else{
                    $subtypeActivityArray[0] = 1;
                }
                
                $totalActivities++;
            }
            
            $contGraphicPie     = 0;
            $dataGraphicPie     = "";
            $dataGraphicPieTwo  = "";
            $userHightTotal     = 0;
            $userHight          = "";
            

            
            foreach ($usersQuery as $usersInfo) {
                if($contGraphicPie < 1){
                    if(isset($activitiesByAgentArray[$usersInfo->full_name]["total"])){
                        $dataGraphicPie .= '{
                                                label: "'.$this->convertName($usersInfo->full_name).'",
                                                data: '.$activitiesByAgentArray[$usersInfo->full_name]["total"].',
                                                color: "'.$activitiesByAgentArray[$usersInfo->full_name]["color"].'"
                                            }';
                        if($userHightTotal < $activitiesByAgentArray[$usersInfo->full_name]["total"]){
                            $userHight      = $usersInfo->full_name;
                            $userHightTotal = $activitiesByAgentArray[$usersInfo->full_name]["total"];
                        }
                    }else{
                       $dataGraphicPie  .= ' {
                                                label: "'.$this->convertName($usersInfo->full_name).'",
                                                data: 0,
                                                color: "#aaaaaa"
                                            }';
                    }
                }else{
                    if(isset($activitiesByAgentArray[$usersInfo->full_name]["total"])){
                        $dataGraphicPie .= ',{
                                                label: "'.$this->convertName($usersInfo->full_name).'",
                                                data: '.$activitiesByAgentArray[$usersInfo->full_name]["total"].',
                                                color: "'.$activitiesByAgentArray[$usersInfo->full_name]["color"].'"
                                            }';
                        
                        if($userHightTotal < $activitiesByAgentArray[$usersInfo->full_name]["total"]){
                            $userHight      = $usersInfo->full_name;
                            $userHightTotal = $activitiesByAgentArray[$usersInfo->full_name]["total"];
                        }
                    }else{
                       $dataGraphicPie  .= ',{
                                                label: "'.$this->convertName($usersInfo->full_name).'",
                                                data: 0,
                                                color: "#aaaaaa"
                                            }';
                    }
                }
                $contGraphicPie++;
            }
          
            foreach ($typeActivitiesQuery as $typeActivitiesInfo) {
                if($contTypeActivities > 0){
                    $namesTypeActivities  .= ",'".$typeActivitiesInfo->text."'";
                    $colorsTypeActivities .= ",'".$typeActivitiesInfo->color."'";
                    
                    if(isset($typeActivityArray[$typeActivitiesInfo->pkActivities_type])){
                        $totalTypeActivities .= ",".$typeActivityArray[$typeActivitiesInfo->pkActivities_type]."";
                    }else{
                        $totalTypeActivities .= ",0";
                    }
                }else{
                    $colorsTypeActivities .= "'".$typeActivitiesInfo->color."'";
                    $namesTypeActivities  .= "'".$typeActivitiesInfo->text."'";
                    
                    if(isset($typeActivityArray[$typeActivitiesInfo->pkActivities_type])){
                        $totalTypeActivities .= $typeActivityArray[$typeActivitiesInfo->pkActivities_type];
                    }else{
                        $totalTypeActivities .= "0";
                    }
                }
                
                if($contTypeActivities < 1){
                    if(isset($activitiesByAgentArray[$userHight][$typeActivitiesInfo->pkActivities_type])){
                        $dataGraphicPieTwo .= '{
                                                label: "'.$this->convertName($typeActivitiesInfo->text).'",
                                                data: '.$activitiesByAgentArray[$userHight][$typeActivitiesInfo->pkActivities_type].',
                                                color: "'.$typeActivitiesInfo->color.'"
                                            }';
                    }else{
                       $dataGraphicPieTwo  .= ' {
                                                label: "'.$this->convertName($typeActivitiesInfo->text).'",
                                                data: 0,
                                                color: "'.$typeActivitiesInfo->color.'"
                                            }';
                    }
                }else{
                    if(isset($activitiesByAgentArray[$userHight][$typeActivitiesInfo->pkActivities_type])){
                        $dataGraphicPieTwo .= ',{
                                                label: "'.$this->convertName($typeActivitiesInfo->text).'",
                                                data: '.$activitiesByAgentArray[$userHight][$typeActivitiesInfo->pkActivities_type].',
                                                color: "'.$typeActivitiesInfo->color.'"
                                            }';
                    }else{
                       $dataGraphicPieTwo  .= ',{
                                                label: "'.$this->convertName($typeActivitiesInfo->text).'",
                                                data: 0,
                                                color: "'.$typeActivitiesInfo->color.'"
                                            }';
                    }
                }
                $contTypeActivities++;
            }
            
            foreach ($subtypeActivitiesQuery as $subtypeActivitiesInfo) {
                if($contSubtypeActivities > 0){
                    $namesSubtypeActivities  .= ",'".$subtypeActivitiesInfo->text."'";
                    $colorsSubtypeActivities .= ",'".$subtypeActivitiesInfo->color."'";
                    
                    if(isset($subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype])){
                        $totalSubtypeActivities .= ",".$subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype]."";
                    }else{
                        $totalSubtypeActivities .= ",0";
                    }
                }else{
                    $colorsSubtypeActivities .= "'#E4DAD8'";
                    $namesSubtypeActivities  .= "'Pendiente'";
                    
                    if(isset($subtypeActivityArray[0])){
                        $totalSubtypeActivities .= $subtypeActivityArray[0];
                    }else{
                        $totalSubtypeActivities .= "0";
                    }
                    
                    $colorsSubtypeActivities .= ",'".$subtypeActivitiesInfo->color."'";
                    $namesSubtypeActivities  .= ",'".$subtypeActivitiesInfo->text."'";
                    
                    if(isset($subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype])){
                        $totalSubtypeActivities .= ",".$subtypeActivityArray[$subtypeActivitiesInfo->pkActivities_subtype];
                    }else{
                        $totalSubtypeActivities .= ",0";
                    }
                }
                
                $contSubtypeActivities++;
            }
            
            $namesTypeActivities    = $this->convertName($namesTypeActivities);
            $namesSubtypeActivities = $this->convertName($namesSubtypeActivities);
            
            $agent = DB::table('users')
                        ->select('pkUser'
                                ,'full_name')
                        ->where('status','=',1)
                        ->where('pkUser','!=',1)
                        ->get();
            
            $campaning = DB::table('commercial_campaigns')
                           ->select('pkCommercial_campaigns'
                                   ,'name')
                           ->where('status','=',1)
                           ->get();
            
            $activities = DB::table('activities_type')
                            ->select('pkActivities_type'
                                    ,'text'
                                    ,'icon')
                            ->where('status','=',1)
                            ->where('pkActivities_type','>',0)
                            ->get();
 
          $view = view('actividad.getGraficActivity', array(
                                     "valid"                   => "true",
                                      "lastActivitiesQuery"     => $lastActivitiesQuery,
                                      "activitiesQuery"         => $activitiesQuery,
                                      "date"                    => $date,
                                      "hour"                    => $hour,
                                      "activitiesArray"         => $activitiesArray,
                                      "namesTypeActivities"     => $namesTypeActivities,
                                      "colorsTypeActivities"    => $colorsTypeActivities,
                                      "totalTypeActivities"     => $totalTypeActivities,
                                      "namesSubtypeActivities"  => $namesSubtypeActivities,
                                      "colorsSubtypeActivities" => $colorsSubtypeActivities,
                                      "totalSubtypeActivities"  => $totalSubtypeActivities,
                                      "dataGraphicPie"          => $dataGraphicPie,
                                      "dataGraphicPieTwo"       => $dataGraphicPieTwo,
                                      "userHight"               => $userHight,
                                      "agent"                   => $agent,
                                      "campaning"               => $campaning,
                                      "activities"              => $activities
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
            
    }
}
