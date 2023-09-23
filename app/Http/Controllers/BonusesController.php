<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\AgentByBond;
use App\Models\BondBase;
use App\Models\BondRecord;
use App\Models\BondTecho;
use App\Models\Comition;
use App\Models\Capacitation;
use App\Models\Cources_by_capacitation;
use App\Models\Penality_by_bond;
use Illuminate\Http\Request;

class BonusesController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function createBonBase()
        {
            $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->get();
            
                    
            return view('bonus.createBonues', ["agent" => $agent]);
        }
        
        public function addBono(Request $request){
            
        $slcAgent       = json_decode($request->input("slcAgent"));
        $montRec        = str_replace("$","", str_replace(",","",$request->input("montRec")));
        //$porcentBon     = $request->input("porcentBon");
        $montMin        = str_replace("$","", str_replace(",","",$request->input("montMin")));
        $porcentPenalty = $request->input("porcentPenalty");
        $porcentFirst   = $request->input("porcentFirst");
        $dateBon        = $request->input("dateBon");
        $fech           = $dateBon."-01";
        $penality       = json_decode($request->input("penality"));

        $flag = "true";
        $message = "true";

        $monthActual = explode("-", $dateBon);
        $monthInitial = $monthActual[0] . '-' . $monthActual[1] . '-01';
        $monthFinish = $monthActual[0] . '-' . $monthActual[1] . '-31';

        $agentsArrayAux = array();
        
        foreach ($slcAgent as $item) {
            if (!empty($item)) {
                $agentsArrayAux[] = $item;
            }
        }
        
        $searchBonus = DB::table('bond_base as b')
                ->join('agent_by_bond as a','a.fkBond','=','b.pkBond_base')
                ->select('b.pkBond_base')
                ->whereDate('b.dateBon', '>=', $monthInitial)
                ->whereDate('b.dateBon', '<=', $monthFinish)
                ->where('a.typeBond','=',1)
                ->whereIn('a.fkUser',$agentsArrayAux)
                ->where('a.status','=',1)
                ->where('b.status','=',1)
                ->first();


        if (empty($searchBonus)) {
            DB::beginTransaction();

            try {                

                $BondBase = new BondBase;
                $BondBase->montRec = $montRec;
                //$BondBase->porcentBon = '';//$porcentBon;
                $BondBase->montMin = $montMin;
                $BondBase->porcentPenalty = $porcentPenalty;
                $BondBase->porcentFirst = $porcentFirst;
                $BondBase->dateBon = $fech;
                $BondBase->status = 1;

                if ($BondBase->save()) {

                    
                    foreach ($penality as $penalityInfo) {  

                      foreach($penalityInfo->slcAgent as $agent){

                        $penality_by_bond              = new Penality_by_bond;
                        $penality_by_bond->fkBond_base = $BondBase->pkBond_base;
                        $penality_by_bond->fkUser      = $agent;
                        $penality_by_bond->penality    = $penalityInfo->porcentPenalty;
                        $penality_by_bond->status      = 1;

                        if ($penality_by_bond->save()) {
                            
                        } else {
                            $flag = "false";
                            $message .= "Error al crear dias \n";
                        }
                    }
                }

                    // return $arrayContacts;
                    foreach ($slcAgent as $item) {

                        if (!empty($item)) {
                            
                            $AgentByBond = new AgentByBond;
                            $AgentByBond->fkUser = $item;
                            $AgentByBond->fkBond = $BondBase->pkBond_base;
                            $AgentByBond->typeBond = 1;
                            $AgentByBond->status = 1;

                            if ($AgentByBond->save()) {
                                
                            } else {
                                $flag = "false";
                                $message .= "Error al crear dias \n";
                            }
                        }
                    }

                } else {
                    $flag = "false";
                    $message .= "Error al crear registro \n";
                }

                if ($flag == "true") {
                    DB::commit();
                    return \Response::json(array(
                                "valid" => "true"
                    ));
                } else {
                    DB::rollback();
                    return \Response::json(array(
                                "valid" => "false"
                                , "error" => "Error al cargar plan de trabajo"
                    ));
                }
            } catch (\Exception $e) {
                DB::rollback();
                //return "Error del sistema, favor de contactar al desarrollador";
                return \Response::json(array(
                            "valid" => "false"
                            , "error" => $e->getMessage()
                ));
            }
        } else {
            return \Response::json(array(
                        "valid" => "false"
                        , "error" => "Este bonus ya esta configurado para este mes"));
        }
       }
       
        public function viewBonBase(){
            
             $years = array();
             $penality = array();
            
            $bound = DB::table('bond_base')
                       ->select('pkBond_base'
                               ,'montRec'
                               ,'porcentBon'
                               ,'montMin'
                               ,'porcentPenalty'
                               ,'porcentFirst'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b %Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%Y') as year"))
                       ->where('status','=',1)
                       ->orderby('dateBon','desc')
                       ->get();
            
             foreach($bound as $item){

                 $penalty = DB::table('penality_by_bond as p')
                         ->join('users as u','u.pkUser','=','p.fkUser')
                         ->select('p.fkUser'
                                 ,'p.penality'
                                 ,'u.full_name')
                         ->where('p.status','=',1)
                         ->where('p.fkBond_base','=',$item->pkBond_base)
                         ->get();

                $penality[$item->pkBond_base] = $penalty;
                
                if(!isset($years[$item->year])){
                    $years[$item->year] = $item->year;
                }
                
            }
            
            return view('bonus.viewBonus', ["bound" => $bound
                                           ,"year"  => $years
                                           ,"penality" => $penality]);
            
        }
        
	public function viewAgentByBono(Request $request){
           $pkBonus  = $request->input("idBonus");
            
            $agentBond  = DB::table('agent_by_bond as a')
                          ->join('users as u','u.pkUser','=','a.fkUser')
                          ->select('a.pkAgentByBond'
                                   ,'a.fkUser'
                                   ,'u.full_name as name'
                                   ,'a.typeBond')
                          ->where('a.status','=',1)
                          ->where('u.status','=',1)
                          ->where('a.typeBond','=',1)
                          ->where('a.fkBond','=',$pkBonus)
                          ->get();
           
            
               $view = view('bonus.getAgentByBound', array(
                    "agentBond" => $agentBond,
                    "pkBonus" => $pkBonus
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function delteBono(Request $request){
             $pkBond             = $request->input("pkBond");

            $workinPlanUpdate    = DB::table("bond_base")
                                          ->where('pkBond_base','=',$pkBond)
                                          ->update(array("status" => 0));
            
            if($workinPlanUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function viewUpdateByBono(Request $request){
             $pkBonus  = $request->input("idBonus");
            
            $Bond  = DB::table('bond_base')
                          ->select('pkBond_base'
                                   ,'montRec'
                                   ,'porcentBon'
                                   ,'montMin'
                                   ,'porcentPenalty'
                                   ,'porcentFirst'
                                   ,'dateBon')
                          ->where('.status','=',1)
                          ->where('pkBond_base','=',$pkBonus)
                          ->first();
           
              $agentBond  = DB::table('agent_by_bond as a')
                          ->join('users as u','u.pkUser','=','a.fkUser')
                          ->select('a.pkAgentByBond'
                                   ,'a.fkUser'
                                   ,'u.full_name as name'
                                   ,'a.typeBond')
                          ->where('a.status','=',1)
                          ->where('u.status','=',1)
                          ->where('a.typeBond','=',1)
                          ->where('a.fkBond','=',$pkBonus)
                          ->get();
              
            $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->get();

            $penalty = DB::table('penality_by_bond as p')
                         ->select('fkUser'
                                 ,'penality')
                         ->where('status','=',1)
                         ->where('fkBond_base','=',$pkBonus)
                         ->get();
            
               $view = view('bonus.updateBond', array(
                    "Bond" => $Bond,
                    "agent" => $agent,
                    "agentBond" => $agentBond,
                    "penalty" => $penalty
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));     
        }
        
        public function updateByBono(Request $request){
        $slcAgent       = json_decode($request->input("slcAgent"));
        $montRec        = str_replace("$","", str_replace(",","",$request->input("montRec")));
        //$porcentBon     = $request->input("porcentBon");
        $montMin        = str_replace("$","", str_replace(",","",$request->input("montMin")));
        $porcentPenalty = $request->input("porcentPenalty");
        $porcentFirst   = $request->input("porcentFirst");
        $dateBon        = $request->input("dateBon");
        $pkBond         = $request->input("pkBond");
        $penality       = json_decode($request->input("penality"));

        $flag = "true";


            DB::beginTransaction();

            try {                
                
                $update = DB::table("bond_base")
                             ->where("pkBond_base", "=" ,$pkBond)
                             ->update(['montRec'        => $montRec
                                     //,'porcentBon'     => $porcentBon
                                     ,'montMin'        => $montMin
                                    // ,'porcentPenalty' => $porcentPenalty
                                     ,'porcentFirst'   => $porcentFirst]
                                         );

                    $updatePenality = DB::table("penality_by_bond")
                                        ->where("fkBond_base", "=" ,$pkBond)
                                        ->update(['status' => 0]);

                        if($updatePenality >= 1){

                            foreach ($penality as $penalityInfo) {  

                                foreach($penalityInfo->slcAgent as $agent){
          
                                  $penality_by_bond              = new Penality_by_bond;
                                  $penality_by_bond->fkBond_base = $pkBond;
                                  $penality_by_bond->fkUser      = $agent;
                                  $penality_by_bond->penality    = $penalityInfo->porcentPenalty;
                                  $penality_by_bond->status      = 1;
          
                                  if ($penality_by_bond->save()) {
                                      
                                  } else {
                                      $flag = "false";
                                      //$message .= "Error al crear dias \n";
                                  }
                              }
                          }
                        }else{
                          $flag = "false";
                        }

                     
                    $updateAgent = DB::table("agent_by_bond")
                                 ->where("fkBond", "=" ,$pkBond)
                                 ->where("typeBond","=",1)
                                 ->update(['status' => 0]);
                    
                 if($updateAgent >= 1){
                    // return $arrayContacts;
                    foreach ($slcAgent as $item) {

                        if (!empty($item)) {

                            $AgentByBond = new AgentByBond;
                            $AgentByBond->fkUser = $item;
                            $AgentByBond->fkBond = $pkBond;
                            $AgentByBond->typeBond = 1;
                            $AgentByBond->status = 1;

                            if ($AgentByBond->save()) {
                                
                            } else {
                                $flag = "false";
                            }
                        }
                    }
                }

               
                if ($flag == "true") {
                    DB::commit();
                    return \Response::json(array(
                                "valid" => "true"
                    ));
                } else {
                    DB::rollback();
                    return \Response::json(array(
                                "valid" => "false"
                                , "error" => "Error al cargar plan de trabajo"
                    ));
                }
            } catch (\Exception $e) {
                DB::rollback();
                //return "Error del sistema, favor de contactar al desarrollador";
                return \Response::json(array(
                            "valid" => "false"
                            , "error" => $e->getMessage()
                ));
            }

        }
        
        public function createBonRecord(Request $request){
            
           $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->get();

            return view('bonus.createBonuesRecord', ["agent" => $agent]);  
        }
        
        public function addBonoRecord(Request $request){
        $slcAgent       = json_decode($request->input("slcAgent"));
        $montRep        = str_replace("$","", str_replace(",","",$request->input("montRep")));
        $montMet        = str_replace("$","", str_replace(",","",$request->input("montMet")));
        $slcTypeMont    = $request->input("slcTypeMont");
        $dateBon        = $request->input("dateBon");
        $fech           = $dateBon."-01";

        $flag = "true";
        $message = "true";

        $monthActual = explode("-", $dateBon);
        $monthInitial = $monthActual[0] . '-' . $monthActual[1] . '-01';
        $monthFinish = $monthActual[0] . '-' . $monthActual[1] . '-31';

        $searchBonus = DB::table('bond_record')
                ->select('pkBound_record')
                ->whereDate('dateBon', '>=', $monthInitial)
                ->whereDate('dateBon', '<=', $monthFinish)
                ->where('status','=',1)
                ->get();


        if (sizeof($searchBonus) <= 0) {
            DB::beginTransaction();

            try {                

                $BondRecord = new BondRecord;
                $BondRecord->slcTypeMont = $slcTypeMont;
                $BondRecord->montRep = $montRep;
                $BondRecord->montMet = $montMet;
                $BondRecord->dateBon = $fech;
                $BondRecord->status = 1;

                if ($BondRecord->save()) {

                    // return $arrayContacts;
                    foreach ($slcAgent as $item) {

                        if (!empty($item)) {

                            $AgentByBond = new AgentByBond;
                            $AgentByBond->fkUser = $item;
                            $AgentByBond->fkBond = $BondRecord->pkBound_record;
                            $AgentByBond->typeBond = 2;
                            $AgentByBond->status = 1;

                            if ($AgentByBond->save()) {
                                
                            } else {
                                $flag = "false";
                                $message .= "Error al crear dias \n";
                            }
                        }
                    }

                } else {
                    $flag = "false";
                    $message .= "Error al crear registro \n";
                }

                if ($flag == "true") {
                    DB::commit();
                    return \Response::json(array(
                                "valid" => "true"
                    ));
                } else {
                    DB::rollback();
                    return \Response::json(array(
                                "valid" => "false"
                                , "error" => "Error al cargar plan de trabajo"
                    ));
                }
            } catch (\Exception $e) {
                DB::rollback();
                //return "Error del sistema, favor de contactar al desarrollador";
                return \Response::json(array(
                            "valid" => "false"
                            , "error" => $e->getMessage()
                ));
            }
        } else {
            return \Response::json(array(
                        "valid" => "false"
                        , "error" => "Este bonus ya esta configurado para este mes"));
        } 
        }
        
        public function viewBonoRecord(){
            
            $years = array();
            
            $bound = DB::table('bond_record')
                       ->select('pkBound_record'
                               ,'slcTypeMont'
                               ,'montRep'
                               ,'montMet'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b %Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%Y') as year"))
                       ->where('status','=',1)
                       ->orderby('dateBon','desc')
                       ->get();
            
            foreach($bound as $item){
                
                if(!isset($years[$item->year])){
                    $years[$item->year] = $item->year;
                }
                
            }
            
            return view('bonus.viewBonusRecord', ["bound" => $bound
                                                 ,"year"  => $years]);
            
        }
        
        public function viewAgentByBonoRecord(Request $request){
             $pkBonus  = $request->input("idBonus");
            
            $agentBond  = DB::table('agent_by_bond as a')
                          ->join('users as u','u.pkUser','=','a.fkUser')
                          ->select('a.pkAgentByBond'
                                   ,'a.fkUser'
                                   ,'u.full_name as name'
                                   ,'a.typeBond')
                          ->where('a.status','=',1)
                          ->where('u.status','=',1)
                          ->where('a.typeBond','=',2)
                          ->where('a.fkBond','=',$pkBonus)
                          ->get();
            
            
           
            
               $view = view('bonus.getAgentByBound', array(
                    "agentBond" => $agentBond,
                    "pkBonus" => $pkBonus
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function delteBonoRecord(Request $request){
              $pkBond             = $request->input("pkBond");

            $workinPlanUpdate    = DB::table("bond_record")
                                          ->where('pkBound_record','=',$pkBond)
                                          ->update(array("status" => 0));
            
            if($workinPlanUpdate >= 1){
                return "true";
            }else{
                return "false";
            } 
        }
        
        public function viewUpdateByBonoRecord(Request $request){
              $pkBonus  = $request->input("idBonus");
            
            $Bond  = DB::table('bond_record')
                          ->select('pkBound_record'
                                   ,'slcTypeMont'
                                   ,'montRep'
                                   ,'montMet'
                                   ,'dateBon')
                          ->where('.status','=',1)
                          ->where('pkBound_record','=',$pkBonus)
                          ->first();
           
              $agentBond  = DB::table('agent_by_bond as a')
                          ->join('users as u','u.pkUser','=','a.fkUser')
                          ->select('a.pkAgentByBond'
                                   ,'a.fkUser'
                                   ,'u.full_name as name'
                                   ,'a.typeBond')
                          ->where('a.status','=',1)
                          ->where('u.status','=',1)
                          ->where('a.typeBond','=',2)
                          ->where('a.fkBond','=',$pkBonus)
                          ->get();
              
            $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->get();
            
               $view = view('bonus.updateBondRecord', array(
                    "Bond" => $Bond,
                    "agent" => $agent,
                    "agentBond" => $agentBond
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
        }
        
        public function updateByBonoRecord(Request $request){
        $slcAgent       = json_decode($request->input("slcAgent"));
        $montRep        = str_replace("$","", str_replace(",","",$request->input("montRep")));
        $montMet        = str_replace("$","", str_replace(",","",$request->input("montMet")));
        $slcTypeMont    = $request->input("slcTypeMont");
        $pkBond         = $request->input("pkBond");
  
        $flag = "true";
        $message = "true";

            DB::beginTransaction();

            try {                
                
                 $update = DB::table("bond_record")
                             ->where("pkBound_record", "=" ,$pkBond)
                             ->update(['slcTypeMont' => $slcTypeMont
                                      ,'montRep'     => $montRep
                                      ,'montMet'     => $montMet]);


                      $updateAgent = DB::table("agent_by_bond")
                                 ->where("fkBond", "=" ,$pkBond)
                                 ->where("typeBond","=",2)
                                 ->update(['status' => 0]);
                    
                    // return $arrayContacts;
                    foreach ($slcAgent as $item) {

                        if (!empty($item)) {

                            $AgentByBond = new AgentByBond;
                            $AgentByBond->fkUser = $item;
                            $AgentByBond->fkBond = $pkBond;
                            $AgentByBond->typeBond = 2;
                            $AgentByBond->status = 1;

                            if ($AgentByBond->save()) {
                                
                            } else {
                                $flag = "false";
                                $message .= "Error al crear dias \n";
                            }
                        }
                    }


                if ($flag == "true") {
                    DB::commit();
                    return \Response::json(array(
                                "valid" => "true"
                    ));
                } else {
                    DB::rollback();
                    return \Response::json(array(
                                "valid" => "false"
                                , "error" => "Error al bonus"
                    ));
                }
            } catch (\Exception $e) {
                DB::rollback();
                //return "Error del sistema, favor de contactar al desarrollador";
                return \Response::json(array(
                            "valid" => "false"
                            , "error" => $e->getMessage()
                ));
            }
        
        }
        
        public function getMontRecord(Request $request){
  
            $years  = $request->input("years");
            $month  = array();
            
            $yearInitial = $years.'-01'.'-01';
            $yearFinish  = $years.'-12'.'-31';
         
            $bound = DB::table('bond_record')
                       ->select('pkBound_record'
                               ,'slcTypeMont'
                               ,'montRep'
                               ,'montMet'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b/%Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%m') as month"))
                       ->where('status','=',1)
                       ->where('dateBon','>=',$yearInitial)
                       ->where('dateBon','<=',$yearFinish)
                       ->get();

            foreach($bound as $item){
                
                $nameMonth = "";
                
                switch ($item->month) {
                    case '01':
                     $nameMonth = "Enero";
                        break;
                    case '02':
                     $nameMonth = "Febrero";
                        break;
                    case '03':
                     $nameMonth = "Marzo";
                        break;
                    case '04':
                     $nameMonth = "Abril";
                        break;
                    case '05':
                     $nameMonth = "Mayo";
                        break;
                    case '06':
                     $nameMonth = "Junio";
                        break;
                    case '07':
                     $nameMonth = "Julio";
                        break;
                    case '08':
                     $nameMonth = "Agosto";
                        break;
                    case '09':
                     $nameMonth = "Septiembre";
                        break;
                    case '10':
                     $nameMonth = "Octubre";
                        break;
                    case '11':
                     $nameMonth = "Noviembre";
                        break;
                    case '12':
                     $nameMonth = "Diciembre";
                        break;

                    default:
                        break;
                }
                
                if(!isset($month[$item->month])){
                    $month[$item->month] = array("pkMonth"   => $item->month
                                               ,"nameMonth" => $nameMonth);
                }
                
            }
            

               $view = view('bonus.getMonth', array(
                    "month" => $month,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                )); 
       
        }
        
        public function getMontBase(Request $request){
  
            $years  = $request->input("years");
            $month  = array();
            
            $yearInitial = $years.'-01'.'-01';
            $yearFinish  = $years.'-12'.'-31';
         
            $bound = DB::table('bond_base')
                       ->select('pkBond_base'
                               ,'montRec'
                               ,'porcentBon'
                               ,'montMin'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b/%Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%m') as month"))
                       ->where('status','=',1)
                       ->where('dateBon','>=',$yearInitial)
                       ->where('dateBon','<=',$yearFinish)
                       ->get();

            foreach($bound as $item){
                
                $nameMonth = "";
                
                switch ($item->month) {
                    case '01':
                     $nameMonth = "Enero";
                        break;
                    case '02':
                     $nameMonth = "Febrero";
                        break;
                    case '03':
                     $nameMonth = "Marzo";
                        break;
                    case '04':
                     $nameMonth = "Abril";
                        break;
                    case '05':
                     $nameMonth = "Mayo";
                        break;
                    case '06':
                     $nameMonth = "Junio";
                        break;
                    case '07':
                     $nameMonth = "Julio";
                        break;
                    case '08':
                     $nameMonth = "Agosto";
                        break;
                    case '09':
                     $nameMonth = "Septiembre";
                        break;
                    case '10':
                     $nameMonth = "Octubre";
                        break;
                    case '11':
                     $nameMonth = "Noviembre";
                        break;
                    case '12':
                     $nameMonth = "Diciembre";
                        break;

                    default:
                        break;
                }
                
                if(!isset($month[$item->month])){
                    $month[$item->month] = array("pkMonth"   => $item->month
                                               ,"nameMonth" => $nameMonth);
                }
                
            }
            

               $view = view('bonus.getMonth', array(
                    "month" => $month,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                )); 
       
        }
        
        public function getMontTecho(Request $request){
  
            $years  = $request->input("years");
            $month  = array();
            
            $yearInitial = $years.'-01'.'-01';
            $yearFinish  = $years.'-12'.'-31';
         
            $bound = DB::table('bonus_techo')
                       ->select('pkBonus_techo'
                               ,'montMet'
                               ,'montRep'
                               ,'slcTypeMont'
                               ,'montPen'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b/%Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%m') as month"))
                       ->where('status','=',1)
                       ->where('dateBon','>=',$yearInitial)
                       ->where('dateBon','<=',$yearFinish)
                       ->get();

            foreach($bound as $item){
                
                $nameMonth = "";
                
                switch ($item->month) {
                    case '01':
                     $nameMonth = "Enero";
                        break;
                    case '02':
                     $nameMonth = "Febrero";
                        break;
                    case '03':
                     $nameMonth = "Marzo";
                        break;
                    case '04':
                     $nameMonth = "Abril";
                        break;
                    case '05':
                     $nameMonth = "Mayo";
                        break;
                    case '06':
                     $nameMonth = "Junio";
                        break;
                    case '07':
                     $nameMonth = "Julio";
                        break;
                    case '08':
                     $nameMonth = "Agosto";
                        break;
                    case '09':
                     $nameMonth = "Septiembre";
                        break;
                    case '10':
                     $nameMonth = "Octubre";
                        break;
                    case '11':
                     $nameMonth = "Noviembre";
                        break;
                    case '12':
                     $nameMonth = "Diciembre";
                        break;

                    default:
                        break;
                }
                
                if(!isset($month[$item->month])){
                    $month[$item->month] = array("pkMonth"   => $item->month
                                               ,"nameMonth" => $nameMonth);
                }
                
            }
            

               $view = view('bonus.getMonth', array(
                    "month" => $month,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                )); 
       
        }
        
        public function searchBonusRecord(Request $request){
            
             $year   = $request->input("year");
             $month  = $request->input("month");
             
             $yearInitial = $year.'-01'.'-01';
             $yearFinish  = $year.'-12'.'-31';
             
             $monthInitial = $year.'-'.$month.'-01';
             $monthFinish  = $year.'-'.$month.'-31';

             
            $bound = DB::table('bond_record')
                       ->select('pkBound_record'
                               ,'slcTypeMont'
                               ,'montRep'
                               ,'montMet'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b %Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%Y') as year"))
                       ->where('status','=',1)
                       ->orderby('dateBon','desc');
            
            if(($year > 0) && ($month < 0)){
             $bound =  $bound->where('dateBon','>=',$yearInitial)
                             ->where('dateBon','<=',$yearFinish);
            }
            
            if($month > 0){
               $bound =  $bound->where('dateBon','>=',$monthInitial)
                               ->where('dateBon','<=',$monthFinish); 
            }
            
               $bound =  $bound->get();

         
               $view = view('bonus.getBonus', array(
                         "bound" => $bound,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                )); 
        }
        
        public function searchBonusBase(Request $request){
              $year   = $request->input("year");
             $month  = $request->input("month");
             
             $yearInitial = $year.'-01'.'-01';
             $yearFinish  = $year.'-12'.'-31';
             
             $monthInitial = $year.'-'.$month.'-01';
             $monthFinish  = $year.'-'.$month.'-31';

             
           $bound = DB::table('bond_base')
                       ->select('pkBond_base'
                               ,'montRec'
                               ,'porcentBon'
                               ,'montMin'
                               ,'porcentPenalty'
                               ,'porcentFirst'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b %Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%Y') as year"))
                       ->where('status','=',1)
                       ->orderby('dateBon','desc');
            
            if(($year > 0) && ($month < 0)){
             $bound =  $bound->where('dateBon','>=',$yearInitial)
                             ->where('dateBon','<=',$yearFinish);
            }
            
            if($month > 0){
               $bound =  $bound->where('dateBon','>=',$monthInitial)
                               ->where('dateBon','<=',$monthFinish); 
            }
            
               $bound =  $bound->get();

               foreach($bound as $item){

                $penalty = DB::table('penality_by_bond as p')
                        ->join('users as u','u.pkUser','=','p.fkUser')
                        ->select('p.fkUser'
                                ,'p.penality'
                                ,'u.full_name')
                        ->where('p.status','=',1)
                        ->where('p.fkBond_base','=',$item->pkBond_base)
                        ->get();

               $penality[$item->pkBond_base] = $penalty;

           }

         
               $view = view('bonus.getBonusBase', array(
                         "bound"    => $bound,
                         "penality" => $penality
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function searchBonusTecho(Request $request){
              $year   = $request->input("year");
             $month  = $request->input("month");
             
             $yearInitial = $year.'-01'.'-01';
             $yearFinish  = $year.'-12'.'-31';
             
             $monthInitial = $year.'-'.$month.'-01';
             $monthFinish  = $year.'-'.$month.'-31';

             
           $bound = DB::table('bonus_techo')
                       ->select('pkBonus_techo'
                               ,'montMet'
                               ,'montRep'
                               ,'slcTypeMont'
                               ,'montPen'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b %Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%Y') as year"))
                       ->where('status','=',1)
                       ->orderby('dateBon','desc');
            
            if(($year > 0) && ($month < 0)){
             $bound =  $bound->where('dateBon','>=',$yearInitial)
                             ->where('dateBon','<=',$yearFinish);
            }
            
            if($month > 0){
               $bound =  $bound->where('dateBon','>=',$monthInitial)
                               ->where('dateBon','<=',$monthFinish); 
            }
            
               $bound =  $bound->get();

         
               $view = view('bonus.getBonusTecho', array(
                         "bound" => $bound,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function createBonTecho(){
           $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->get();
            
                    
            return view('bonus.createBonuesTecho', ["agent" => $agent]);  
        }
        
        public function addBonoTecho(Request $request){
        $slcAgent       = json_decode($request->input("slcAgent"));
        $montRep        = str_replace("$","", str_replace(",","",$request->input("montRep")));
        $montMet        = str_replace("$","", str_replace(",","",$request->input("montMet")));
        $slcTypeMont    = $request->input("slcTypeMont");
        $montPen        = $request->input("montPen");
        $dateBon        = $request->input("dateBon");
        $fech           = $dateBon."-01";

 
        $flag = "true";
        $message = "true";

        $monthActual = explode("-", $dateBon);
        $monthInitial = $monthActual[0] . '-' . $monthActual[1] . '-01';
        $monthFinish = $monthActual[0] . '-' . $monthActual[1] . '-31';

        $searchBonus = DB::table('bonus_techo')
                ->select('pkBonus_techo')
                ->whereDate('dateBon', '>=', $monthInitial)
                ->whereDate('dateBon', '<=', $monthFinish)
                ->where('status','=',1)
                ->get();


        if (sizeof($searchBonus) <= 0) {
            DB::beginTransaction();

            try {                

                $BondTecho = new BondTecho;
                $BondTecho->montMet = $montMet;
                $BondTecho->montRep = $montRep;
                $BondTecho->slcTypeMont = $slcTypeMont;
                $BondTecho->montPen = $montPen;
                $BondTecho->dateBon = $fech;
                $BondTecho->status = 1;

                if ($BondTecho->save()) {

                    // return $arrayContacts;
                    foreach ($slcAgent as $item) {

                        if (!empty($item)) {

                            $AgentByBond = new AgentByBond;
                            $AgentByBond->fkUser = $item;
                            $AgentByBond->fkBond = $BondTecho->pkBonus_techo;
                            $AgentByBond->typeBond = 3;
                            $AgentByBond->status = 1;

                            if ($AgentByBond->save()) {
                                
                            } else {
                                $flag = "false";
                                $message .= "Error al crear dias \n";
                            }
                        }
                    }

                } else {
                    $flag = "false";
                    $message .= "Error al crear registro \n";
                }

                if ($flag == "true") {
                    DB::commit();
                    return \Response::json(array(
                                "valid" => "true"
                    ));
                } else {
                    DB::rollback();
                    return \Response::json(array(
                                "valid" => "false"
                                , "error" => "Error al cargar plan de trabajo"
                    ));
                }
            } catch (\Exception $e) {
                DB::rollback();
                //return "Error del sistema, favor de contactar al desarrollador";
                return \Response::json(array(
                            "valid" => "false"
                            , "error" => $e->getMessage()
                ));
            }
        } else {
            return \Response::json(array(
                        "valid" => "false"
                        , "error" => "Este bonus ya esta configurado para este mes"));
          }   
        }
        
        public function viwbonosTecho(){
           $years = array();
            
            $bound = DB::table('bonus_techo')
                       ->select('pkBonus_techo'
                               ,'montMet'
                               ,'montRep'
                               ,'slcTypeMont'
                               ,'montPen'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b %Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%Y') as year"))
                       ->where('status','=',1)
                       ->orderby('dateBon','desc')
                       ->get();
            
            foreach($bound as $item){
                
                if(!isset($years[$item->year])){
                    $years[$item->year] = $item->year;
                }
                
            }
            
            return view('bonus.viewBonusTecho', ["bound" => $bound
                                                 ,"year"  => $years]);  
        }
        
        public function delteBonoTecho(Request $request){
            $pkBond             = $request->input("pkBond");

            $workinPlanUpdate    = DB::table("bonus_techo")
                                          ->where('pkBonus_techo','=',$pkBond)
                                          ->update(array("status" => 0));
            
            if($workinPlanUpdate >= 1){
                return "true";
            }else{
                return "false";
            }  
        }
        
        public function viewAgentBondTecho(Request $request){
            $pkBonus  = $request->input("idBonus");
            
            $agentBond  = DB::table('agent_by_bond as a')
                          ->join('users as u','u.pkUser','=','a.fkUser')
                          ->select('a.pkAgentByBond'
                                   ,'a.fkUser'
                                   ,'u.full_name as name'
                                   ,'a.typeBond')
                          ->where('a.status','=',1)
                          ->where('u.status','=',1)
                          ->where('a.typeBond','=',3)
                          ->where('a.fkBond','=',$pkBonus)
                          ->get();
            
               $view = view('bonus.getAgentByBound', array(
                    "agentBond" => $agentBond,
                    "pkBonus" => $pkBonus
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
        }
        
        public function viewUpdateByBonoTecho(Request $request){
            $pkBonus  = $request->input("idBonus");
            
            $Bond  = DB::table('bonus_techo')
                          ->select('pkBonus_techo'
                                   ,'montMet'
                                   ,'montRep'
                                   ,'slcTypeMont'
                                   ,'montPen'
                                   ,'dateBon')
                          ->where('.status','=',1)
                          ->where('pkBonus_techo','=',$pkBonus)
                          ->first();
           
              $agentBond  = DB::table('agent_by_bond as a')
                          ->join('users as u','u.pkUser','=','a.fkUser')
                          ->select('a.pkAgentByBond'
                                   ,'a.fkUser'
                                   ,'u.full_name as name'
                                   ,'a.typeBond')
                          ->where('a.status','=',1)
                          ->where('u.status','=',1)
                          ->where('a.typeBond','=',3)
                          ->where('a.fkBond','=',$pkBonus)
                          ->get();
              
            $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->get();
            
               $view = view('bonus.updateBondTecho', array(
                    "Bond" => $Bond,
                    "agent" => $agent,
                    "agentBond" => $agentBond
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
        }
        
        public function updateByBonoTecho(Request $request){
         $slcAgent       = json_decode($request->input("slcAgent"));
        $montRep        = str_replace("$","", str_replace(",","",$request->input("montRep")));
        $montMet        = str_replace("$","", str_replace(",","",$request->input("montMet")));
        $slcTypeMont    = $request->input("slcTypeMont");
        $montPen        = $request->input("montPen");
        $pkBond         = $request->input("pkBond");
 
        $flag = "true";
        $message = "true";

            DB::beginTransaction();

            try {                

                $update = DB::table("bonus_techo")
                             ->where("pkBonus_techo", "=" ,$pkBond)
                             ->update(['montMet'     => $montMet
                                      ,'montRep'     => $montRep
                                      ,'slcTypeMont' => $slcTypeMont
                                      ,'montPen'     => $montPen]);

   
                    $updateAgent = DB::table("agent_by_bond")
                                 ->where("fkBond", "=" ,$pkBond)
                                 ->where("typeBond","=",3)
                                 ->update(['status' => 0]);
                    // return $arrayContacts;
                    foreach ($slcAgent as $item) {

                        if (!empty($item)) {

                            $AgentByBond = new AgentByBond;
                            $AgentByBond->fkUser = $item;
                            $AgentByBond->fkBond = $pkBond;
                            $AgentByBond->typeBond = 3;
                            $AgentByBond->status = 1;

                            if ($AgentByBond->save()) {
                                
                            } else {
                                $flag = "false";
                                $message .= "Error al crear dias \n";
                            }
                        }
                    }


                if ($flag == "true") {
                    DB::commit();
                    return \Response::json(array(
                                "valid" => "true"
                    ));
                } else {
                    DB::rollback();
                    return \Response::json(array(
                                "valid" => "false"
                                , "error" => "Error al cargar plan de trabajo"
                    ));
                }
            } catch (\Exception $e) {
                DB::rollback();
                //return "Error del sistema, favor de contactar al desarrollador";
                return \Response::json(array(
                            "valid" => "false"
                            , "error" => $e->getMessage()
                ));
            }
    
        }
        
        public function createComition(Request $request){
            $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->get();
            
                    
            return view('bonus.createComition', ["agent" => $agent]);   
        }
        
        public function addcomition(Request $request){
        $slcAgent            = json_decode($request->input("slcAgent"));
        $higher_to           = str_replace("$","", str_replace(",","",$request->input("higher_to")));
        $higher_or_equal_to  = str_replace("$","", str_replace(",","",$request->input("higher_or_equal_to")));
        $less_or_equal_to    = str_replace("$","", str_replace(",","",$request->input("less_or_equal_to")));
        $less_to             = str_replace("$","", str_replace(",","",$request->input("less_to")));
        
        $comition_higher       = $request->input("comition_higher");
        $comition_higher_less  = $request->input("comition_higher_less");
        $comition_less         = $request->input("comition_less");
        $dateBon               = $request->input("dateBon");
        $fech                  = $dateBon."-01";
                    
 
        $flag = "true";
        $message = "true";

        $monthActual = explode("-", $dateBon);
        $monthInitial = $monthActual[0] . '-' . $monthActual[1] . '-01';
        $monthFinish = $monthActual[0] . '-' . $monthActual[1] . '-31';
        
           $searchBonus = DB::table('comition as c')
               // ->join('agent_by_bond as b','b.fkBond','=','c.pkComition')
                ->select('c.pkComition')
                ->whereDate('c.dateBon', '>=', $monthInitial)
                ->whereDate('c.dateBon', '<=', $monthFinish)
                ->where('c.status','=',1)
                //->where('b.status','=',1)
                //->where('b.type','=',4)
                ->get();


        if (sizeof($searchBonus) <= 0) {
            DB::beginTransaction();

            try {                

                $Comition                       = new Comition;
                $Comition->higher_to            = $higher_to;
                $Comition->higher_or_equal_to   = $higher_or_equal_to;
                $Comition->less_or_equal_to     = $less_or_equal_to;
                $Comition->less_to              = $less_to;
                $Comition->comition_higher      = $comition_higher;
                $Comition->comition_higher_less = $comition_higher_less;
                $Comition->comition_less        = $comition_less;
                $Comition->dateBon              = $fech;
                $Comition->status               = 1;

                if ($Comition->save()) {

                    // return $arrayContacts;
                    foreach ($slcAgent as $item) {

                        if (!empty($item)) {

                            $AgentByBond = new AgentByBond;
                            $AgentByBond->fkUser = $item;
                            $AgentByBond->fkBond = $Comition->pkComition;
                            $AgentByBond->typeBond = 4;
                            $AgentByBond->status = 1;

                            if ($AgentByBond->save()) {
                                
                            } else {
                                $flag = "false";
                                $message .= "Error al crear dias \n";
                            }
                        }
                    }

                } else {
                    $flag = "false";
                    $message .= "Error al crear registro \n";
                }

                if ($flag == "true") {
                    DB::commit();
                    return \Response::json(array(
                                "valid" => "true"
                    ));
                } else {
                    DB::rollback();
                    return \Response::json(array(
                                "valid" => "false"
                                , "error" => "Error al cargar plan de trabajo"
                    ));
                }
            } catch (\Exception $e) {
                DB::rollback();
                //return "Error del sistema, favor de contactar al desarrollador";
                return \Response::json(array(
                            "valid" => "false"
                            , "error" => $e->getMessage()
                ));
            }
        } else {
            return \Response::json(array(
                        "valid" => "false"
                        , "error" => html_entity_decode ("La comisi&oacute;n ya est&aacute; configurada para este mes")));
          }   
        
        }
        
        public function updateByBonoComit(Request $request){
        $slcAgent            = json_decode($request->input("slcAgent"));
        $higher_to           = str_replace("$","", str_replace(",","",$request->input("higher_to")));
        $higher_or_equal_to  = str_replace("$","", str_replace(",","",$request->input("higher_or_equal_to")));
        $less_or_equal_to    = str_replace("$","", str_replace(",","",$request->input("less_or_equal_to")));
        $less_to             = str_replace("$","", str_replace(",","",$request->input("less_to")));
        
        $comition_higher       = $request->input("comition_higher");
        $comition_higher_less  = $request->input("comition_higher_less");
        $comition_less         = $request->input("comition_less");
        $dateBon               = $request->input("dateBon");
        $fech                  = $dateBon."-01";
        $id                    = $request->input("id");
                    
 
        $flag = "true";
        $message = "true";

            DB::beginTransaction();

            try {                

                
                $update = DB::table("comition")
                            ->where("pkComition", "=" ,$id)
                            ->update(['higher_to' => $higher_to
                                     ,'higher_or_equal_to' => $higher_or_equal_to
                                     ,'less_or_equal_to' => $less_or_equal_to
                                     ,'less_to' => $less_to
                                     ,'comition_higher' => $comition_higher
                                     ,'comition_higher_less' => $comition_higher_less
                                     ,'comition_less' => $comition_less]);
                

                if ($update >= 1) {

                    $updateAgent = DB::table("agent_by_bond")
                                      ->where("fkBond", "=" ,$id)
                                      ->where("typeBond", "=" ,4)
                                      ->update(['status' => 0]);
                    // return $arrayContacts;
                    foreach ($slcAgent as $item) {

                        if (!empty($item)) {

                            $AgentByBond = new AgentByBond;
                            $AgentByBond->fkUser = $item;
                            $AgentByBond->fkBond = $id;
                            $AgentByBond->typeBond = 4;
                            $AgentByBond->status = 1;

                            if ($AgentByBond->save()) {
                                
                            } else {
                                $flag = "false";
                                $message .= "Error al crear dias \n";
                            }
                        }
                    }

                } else {
                    $flag = "false";
                    $message .= "Error al crear registro \n";
                }

                if ($flag == "true") {
                    DB::commit();
                    return \Response::json(array(
                                "valid" => "true"
                    ));
                } else {
                    DB::rollback();
                    return \Response::json(array(
                                "valid" => "false"
                                , "error" => "Error al cargar plan de trabajo"
                    ));
                }
            } catch (\Exception $e) {
                DB::rollback();
                //return "Error del sistema, favor de contactar al desarrollador";
                return \Response::json(array(
                            "valid" => "false"
                            , "error" => $e->getMessage()
                ));
            }
  
        
        }
        
        public function viewComition(){
             $years = array();
             
            $bound = DB::table('comition')
                       ->select('pkComition'
                               ,'higher_to'
                               ,'higher_or_equal_to'
                               ,'less_or_equal_to'
                               ,'less_to'
                               ,'comition_higher'
                               ,'comition_higher_less'
                               ,'comition_less'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b %Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%Y') as year"))
                       ->where('status','=',1)
                       ->orderby('dateBon','desc')
                       ->get();
            
            foreach($bound as $item){
                
                if(!isset($years[$item->year])){
                    $years[$item->year] = $item->year;
                }
                
                
            }
            
            return view('bonus.viewComition', ["bound" => $bound
                                                 ,"year"  => $years]);   
        }
        
        public function createPenalization(){
             $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->get();
             
             $courses = DB::table('courses')
                          ->select('pkCourses'
                                  ,'name','code')
                         ->where('status','=',1)
                         ->get();
            
                    
            return view('bonus.createIncumplimet', ["agent"   => $agent
                                                   ,"courses" => $courses]);  
        }
        
        public function getCourses(){
            
             $courses = DB::table('courses')
                          ->select('pkCourses'
                                  ,'name','code')
                         ->where('status','=',1)
                         ->get();
             
             $option = '<option value="-1">Seleccione un curso</option>';
             
             foreach($courses as $item){
                 
                 $option .= '<option value="'.$item->pkCourses.'">'.$item->code.' - '.html_entity_decode ($item->name).'</option>';
                 
             }
             
              return \Response::json(array(
                                "valid"   => "true"
                               ,"courses" => $option
                    ));
        }
        
        public function addCourses(Request $request){
        $slcAgent       = json_decode($request->input("slcAgent"));
        $dateBon        = $request->input("dateBon");
        $fech           = date("Y-m-d");
        $arrayOptions       = json_decode($request->input('arrayOptions'));
     
        $flag = "true";
        $message = "true";


        
            DB::beginTransaction();

            try {                

                $BondTecho = new Capacitation;
                $BondTecho->dateBon = $fech;
                $BondTecho->status = 1;

                if ($BondTecho->save()) {

                    // return $arrayContacts;
                    foreach ($slcAgent as $infoAgent) {

                        foreach($arrayOptions as $item){
                                        
                            
                                       $quotation_detail                  = new Cources_by_capacitation;
                                       $quotation_detail->fkCapacitation  = $BondTecho->pkCapacitation;
                                        if($item[0] > 0){
                                       $quotation_detail->pkCourse        = $item[0];
                                        }
                                        else{
                                         $quotation_detail->nameCourse    = $item[1];   
                                        }
                                       $quotation_detail->fkUser          = $infoAgent;
                                       $quotation_detail->penality        = $item[2];
                                       $quotation_detail->isView          = 0;
                                       $quotation_detail->expiration      = $item[3];
                                       $quotation_detail->expiration_hour = $item[4];
                                       $quotation_detail->status          = 1;
                                       
                                        if($quotation_detail->save()){
                                        }else{
                                         $flag         = "false";  
                                          $message    .= "Error al crear registro contactos \n";
                                        }
                                     
                                    }
                    }
                    
                     

                } else {
                    $flag = "false";
                    $message .= "Error al crear registro \n";
                }

                if ($flag == "true") {
                    DB::commit();
                    return \Response::json(array(
                                "valid" => "true"
                    ));
                } else {
                    DB::rollback();
                    return \Response::json(array(
                                "valid" => "false"
                                , "error" => "Error al cargar plan de trabajo"
                    ));
                }
            } catch (\Exception $e) {
                DB::rollback();
                //return "Error del sistema, favor de contactar al desarrollador";
                return \Response::json(array(
                            "valid" => "false"
                            , "error" => $e->getMessage()
                ));
            }  
        }
        
        public function viewcapacitation(){
             $years = array();
            
            $bound = DB::table('capacitation as c')
                       ->join('courses_by_capacitation as a','a.fkCapacitation','=','c.pkCapacitation')
                       ->join('users as u','u.pkUser','=','a.fkUser')
                       ->select('c.pkCapacitation'
                               ,'u.full_name'
                               ,'u.pkUser'
                               ,DB::raw("DATE_FORMAT(c.dateBon, '%b %Y') as date")
                               ,DB::raw("DATE_FORMAT(c.dateBon, '%Y') as year"))
                       ->where('c.status','=',1)
                       ->where('a.status','=',1)
                       ->distinct()
                       ->get(['fkUser']);
            
            foreach($bound as $item){
                
                if(!isset($years[$item->year])){
                    $years[$item->year] = $item->year;
                }
                
            }
            
            return view('bonus.viewCapacitation', ["bound" => $bound
                                                 ,"year"  => $years]);   
        }
        
        public function viewCources(Request $request){
             $pkBonus  = $request->input("idBonus");
             $pkUser  = $request->input("pkUser");
             
            
            $agentBond  = DB::table('courses_by_capacitation as a')
                          ->leftjoin('courses as c','c.pkCourses','=','a.pkCourse')
                          ->select('a.pkCourses_by_capacitation'
                                   ,'a.fkCapacitation'
                                   ,'a.nameCourse'
                                   ,'c.name'
                                   ,'c.code'
                                   ,'a.isView'
                                   ,'a.document'
                                   ,'a.pkCourse'
                                   ,'a.expiration_hour'
                                   ,DB::raw("DATE_FORMAT(a.expiration, '%d/%m/%Y') as expiration")
                                   ,'a.penality')
                          ->where('a.status','=',1)
                          ->where('a.fkUser','=',$pkUser)
                          ->where('a.fkCapacitation','=',$pkBonus)
                          ->get();
            
               $view = view('bonus.getCources', array(
                    "agentBond" => $agentBond,
                    "pkBonus" => $pkBonus
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));     
        }
        
        public function getMontCapacitation(Request $request){
            $years  = $request->input("years");
            $month  = array();
            
            $yearInitial = $years.'-01'.'-01';
            $yearFinish  = $years.'-12'.'-31';
         
            $bound = DB::table('capacitation as c')
                       ->join('courses_by_capacitation as a','a.fkCapacitation','=','c.pkCapacitation')
                       ->join('users as u','u.pkUser','=','a.fkUser')
                       ->select('c.pkCapacitation'
                               ,'u.full_name'
                               ,'u.pkUser'
                               ,DB::raw("DATE_FORMAT(c.dateBon, '%b %Y') as date")
                               ,DB::raw("DATE_FORMAT(c.dateBon, '%Y') as year")
                               ,DB::raw("DATE_FORMAT(dateBon, '%m') as month"))
                       ->where('c.status','=',1)
                       ->where('a.status','=',1)
                       ->distinct()
                       ->get(['fkUser']);
                  
            foreach($bound as $item){
                
                $nameMonth = "";
                
                switch ($item->month) {
                    case '01':
                     $nameMonth = "Enero";
                        break;
                    case '02':
                     $nameMonth = "Febrero";
                        break;
                    case '03':
                     $nameMonth = "Marzo";
                        break;
                    case '04':
                     $nameMonth = "Abril";
                        break;
                    case '05':
                     $nameMonth = "Mayo";
                        break;
                    case '06':
                     $nameMonth = "Junio";
                        break;
                    case '07':
                     $nameMonth = "Julio";
                        break;
                    case '08':
                     $nameMonth = "Agosto";
                        break;
                    case '09':
                     $nameMonth = "Septiembre";
                        break;
                    case '10':
                     $nameMonth = "Octubre";
                        break;
                    case '11':
                     $nameMonth = "Noviembre";
                        break;
                    case '12':
                     $nameMonth = "Diciembre";
                        break;

                    default:
                        break;
                }
                
                if(!isset($month[$item->month])){
                    $month[$item->month] = array("pkMonth"   => $item->month
                                               ,"nameMonth" => $nameMonth);
                }
                
            }
            

               $view = view('bonus.getMonth', array(
                    "month" => $month,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function searchCapacitation(Request $request){
            $year   = $request->input("year");
             $month  = $request->input("month");
             
             $yearInitial = $year.'-01'.'-01';
             $yearFinish  = $year.'-12'.'-31';
             
             $monthInitial = $year.'-'.$month.'-01';
             $monthFinish  = $year.'-'.$month.'-31';

             
          $bound = DB::table('capacitation as c')
                       ->join('courses_by_capacitation as a','a.fkCapacitation','=','c.pkCapacitation')
                       ->join('users as u','u.pkUser','=','a.fkUser')
                       ->select('c.pkCapacitation'
                               ,'u.full_name'
                               ,'u.pkUser'
                               ,DB::raw("DATE_FORMAT(c.dateBon, '%b %Y') as date")
                               ,DB::raw("DATE_FORMAT(c.dateBon, '%Y') as year"));
            
            if(($year > 0) && ($month < 0)){
             $bound =  $bound->where('dateBon','>=',$yearInitial)
                             ->where('dateBon','<=',$yearFinish);
            }
            
            if($month > 0){
               $bound =  $bound->where('dateBon','>=',$monthInitial)
                               ->where('dateBon','<=',$monthFinish); 
            }
            
               $bound =  $bound->where('c.status','=',1)
                       ->where('a.status','=',1)
                       ->distinct()
                       ->get(['fkUser']);

         
               $view = view('bonus.getCapacitation', array(
                         "bound" => $bound,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
        }
        
        public function updateCourseview(Request $request){
            
            $pkBond             = $request->input("pkBond");

            $workinPlanUpdate    = DB::table("courses_by_capacitation")
                                          ->where('pkCourses_by_capacitation','=',$pkBond)
                                          ->update(array("isView" => 1));
            
            if($workinPlanUpdate >= 1){
                return "true";
            }else{
                return "false";
            }   
        }
        
        public function deleteCourses(Request $request){
            $pkBond             = $request->input("pkBond");
            $pkUser             = $request->input("pkUser");

            $workinPlanUpdate    = DB::table("courses_by_capacitation")
                                          ->where('fkCapacitation','=',$pkBond)
                                          ->where('fkUser','=',$pkUser)
                                          ->update(array("status" => 0));
            
            if($workinPlanUpdate >= 1){
                return "true";
            }else{
                return "false";
            }   
        }
        
        public function viewUpdateByCourse(Request $request){
            $pkBonus  = $request->input("idBonus");
            $pkUser   = $request->input("pkUser");
            
            $Bond  = DB::table('courses_by_capacitation as a')
                          ->leftjoin('courses as c','c.pkCourses','=','a.pkCourse')
                          ->select('a.pkCourses_by_capacitation'
                                   ,'a.fkCapacitation'
                                   ,'a.nameCourse'
                                   ,'c.name'
                                   ,'c.code'
                                   ,'a.fkUser'
                                   ,'a.isView'
                                   ,'a.expiration'
                                   ,'a.expiration_hour'
                                   ,'a.pkCourse'
                                   ,'a.penality')
                          ->where('a.status','=',1)
                          ->where('a.fkUser','=',$pkUser)
                          ->where('a.fkCapacitation','=',$pkBonus)
                          ->get();
    
            $courses = DB::table('courses')
                          ->select('pkCourses'
                                  ,'name','code')
                         ->where('status','=',1)
                         ->get();
            
               $view = view('bonus.updateCapacitation', array(
                    "Bond" => $Bond,
                    "courses" => $courses
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));     
        }
        
        public function addMoreCourses(Request $request){
        
        $id                 = $request->input("id");
        $user               = $request->input("user");
        $arrayOptions       = json_decode($request->input('arrayOptions'));
         
        $flag = "true";
        $message = "true";




            DB::beginTransaction();

            try {                

              $update = DB::table("courses_by_capacitation")
               ->where("fkCapacitation", "=" ,$id)
               ->where("fkUser", "=" ,$user)
               ->update(['status' => 0]);
              
                if ($update >= 0) {

                        foreach($arrayOptions as $item){
                                        
                                 
                                       $quotation_detail                  = new Cources_by_capacitation;
                                       $quotation_detail->fkCapacitation  = $id;
                                        if($item[0] > 0){
                                       $quotation_detail->pkCourse        = $item[0];
                                        }
                                        else{
                                         $quotation_detail->nameCourse    = $item[1];   
                                        }
                                       $quotation_detail->fkUser          = $user;
                                       $quotation_detail->penality        = $item[2];
                                       $quotation_detail->expiration      = $item[3];
                                       $quotation_detail->expiration_hour = $item[4];
                                       $quotation_detail->isView          = 0;
                                       $quotation_detail->status          = 1;
                                       
                                        if($quotation_detail->save()){
                                        }else{
                                         $flag         = "false";  
                                          $message    .= "Error al crear registro contactos \n";
                                        }
                                     
                                    }


                } else {
                    $flag = "false";
                    $message .= "Error al crear registro \n";
                }

                if ($flag == "true") {
                    DB::commit();
                    return \Response::json(array(
                                "valid" => "true"
                    ));
                } else {
                    DB::rollback();
                    return \Response::json(array(
                                "valid" => "false"
                                , "error" => "Error al cargar plan de trabajo"
                    ));
                }
            } catch (\Exception $e) {
                DB::rollback();
                //return "Error del sistema, favor de contactar al desarrollador";
                return \Response::json(array(
                            "valid" => "false"
                            , "error" => $e->getMessage()
                ));
            }
       
        }
        
        public function getMontComition(Request $request){
            $years  = $request->input("years");
            $month  = array();
            
            $yearInitial = $years.'-01'.'-01';
            $yearFinish  = $years.'-12'.'-31';
         
            $bound = DB::table('comition')
                       ->select('pkComition'
                               ,'higher_to'
                               ,'higher_or_equal_to'
                               ,'less_or_equal_to'
                               ,'less_to'
                               ,'comition_higher'
                               ,'comition_higher_less'
                               ,'comition_less'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b/%Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%m') as month"))
                       ->where('status','=',1)
                       ->where('dateBon','>=',$yearInitial)
                       ->where('dateBon','<=',$yearFinish)
                       ->get();

            foreach($bound as $item){
                
                $nameMonth = "";
                
                switch ($item->month) {
                    case '01':
                     $nameMonth = "Enero";
                        break;
                    case '02':
                     $nameMonth = "Febrero";
                        break;
                    case '03':
                     $nameMonth = "Marzo";
                        break;
                    case '04':
                     $nameMonth = "Abril";
                        break;
                    case '05':
                     $nameMonth = "Mayo";
                        break;
                    case '06':
                     $nameMonth = "Junio";
                        break;
                    case '07':
                     $nameMonth = "Julio";
                        break;
                    case '08':
                     $nameMonth = "Agosto";
                        break;
                    case '09':
                     $nameMonth = "Septiembre";
                        break;
                    case '10':
                     $nameMonth = "Octubre";
                        break;
                    case '11':
                     $nameMonth = "Noviembre";
                        break;
                    case '12':
                     $nameMonth = "Diciembre";
                        break;

                    default:
                        break;
                }
                
                if(!isset($month[$item->month])){
                    $month[$item->month] = array("pkMonth"   => $item->month
                                               ,"nameMonth" => $nameMonth);
                }
                
            }
            

               $view = view('bonus.getMonth', array(
                    "month" => $month,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function searchBonusComition(Request $request){
              $year   = $request->input("year");
             $month  = $request->input("month");

             $years = array();
             
             $yearInitial = $year.'-01'.'-01';
             $yearFinish  = $year.'-12'.'-31';
             
             $monthInitial = $year.'-'.$month.'-01';
             $monthFinish  = $year.'-'.$month.'-31';

             
           $bound = DB::table('comition')
                       ->select('pkComition'
                               ,'higher_to'
                               ,'higher_or_equal_to'
                               ,'less_or_equal_to'
                               ,'less_to'
                               ,'comition_higher'
                               ,'comition_higher_less'
                               ,'comition_less'
                               ,DB::raw("DATE_FORMAT(dateBon, '%b %Y') as date")
                               ,DB::raw("DATE_FORMAT(dateBon, '%Y') as year"))
                       ->where('status','=',1)
                       ->orderby('dateBon','desc');
            
            if(($year > 0) && ($month < 0)){
             $bound =  $bound->where('dateBon','>=',$yearInitial)
                             ->where('dateBon','<=',$yearFinish);
            }
            
            if($month > 0){
               $bound =  $bound->where('dateBon','>=',$monthInitial)
                               ->where('dateBon','<=',$monthFinish); 
            }
            
               $bound =  $bound->get();

               foreach($bound as $item){
                
                if(!isset($years[$item->year])){
                    $years[$item->year] = $item->year;
                }
            }

         
               $view = view('bonus.getComition', array(
                         "bound" => $bound,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function viewAgentBondComit(Request $request){
            $pkBonus  = $request->input("idBonus");
            
            
            $agentBond  = DB::table('agent_by_bond as a')
                          ->join('users as u','u.pkUser','=','a.fkUser')
                          ->select('a.pkAgentByBond'
                                   ,'a.fkUser'
                                   ,'u.full_name as name'
                                   ,'a.typeBond')
                          ->where('a.status','=',1)
                          ->where('u.status','=',1)
                          ->where('a.typeBond','=',4)
                          ->where('a.fkBond','=',$pkBonus)
                          ->get();
            
               $view = view('bonus.getAgentByBound', array(
                    "agentBond" => $agentBond,
                    "pkBonus" => $pkBonus
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
        }
        
        public function viewUpdateByBonoComit(Request $request){
            $pkBonus  = $request->input("idBonus");
            
            $Bond  =  DB::table('comition')
                       ->select('pkComition'
                               ,'higher_to'
                               ,'higher_or_equal_to'
                               ,'less_or_equal_to'
                               ,'less_to'
                               ,'comition_higher'
                               ,'comition_higher_less'
                               ,'comition_less'
                               ,'dateBon'
                               )
                          ->where('.status','=',1)
                          ->where('pkComition','=',$pkBonus)
                          ->first();
           
              $agentBond  = DB::table('agent_by_bond as a')
                          ->join('users as u','u.pkUser','=','a.fkUser')
                          ->select('a.pkAgentByBond'
                                   ,'a.fkUser'
                                   ,'u.full_name as name'
                                   ,'a.typeBond')
                          ->where('a.status','=',1)
                          ->where('u.status','=',1)
                          ->where('a.typeBond','=',4)
                          ->where('a.fkBond','=',$pkBonus)
                          ->get();
              
            $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->get();
            
               $view = view('bonus.updateComition', array(
                    "Bond" => $Bond,
                    "agent" => $agent,
                    "agentBond" => $agentBond
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));     
        }
        
        public function delteBonoComit(Request $request){
            $pkBond             = $request->input("pkBond");

            $workinPlanUpdate    = DB::table("comition")
                                          ->where('pkComition','=',$pkBond)
                                          ->update(array("status" => 0));
            
            if($workinPlanUpdate >= 1){
                return "true";
            }else{
                return "false";
            }  
        }
        
        public function addDocumentByUser(Request $request){
                $pkBonus  = $request->input("idBonus");
            
          
            
               $view = view('bonus.uploadDocument', array(
                    "pkBonus" => $pkBonus,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function addDocumentByUserDB(Request $request) {

        $image = $request->file('image');
        $id = $request->input("id");
        $flag = "true";


        if ($image != '') {
            if (file_exists($image)) {
                $nameFile = $image->getClientOriginalName();
                if ($nameFile != '') {
                    $ext = $image->extension();

                    $destinationPath = base_path('/public_html/images/training/');
                    $image->move($destinationPath, 'training' . $id . '.' . $ext);


                    $fileUpdate = DB::table('courses_by_capacitation')
                            ->where('pkCourses_by_capacitation', '=', $id)
                            ->where('status', '=', 1)
                            ->update(array("document" => 'training' . $id . '.' . $ext));

                    if($fileUpdate >= 1) {
                        
                    } else {
                        $flag = "false";
                    }
                }
            }
        }else{
            $flag = "false"; 
        }
        
       return $flag;
    }

   public function getAgent(){

       $selectAgent = "";
        $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->get();

            
          $selectAgent .= '<select class=" slcAgent form-control custom-select" multiple data-placeholder="Elige Categoría" tabindex="1">';            
            foreach($agent as $item){
              $selectAgent .=  '<option value="'.$item->pkUser.'">'.$item->full_name.'</option>';
            }
           
             $selectAgent .= '</select>';

             return $selectAgent; 


   }
   

}
