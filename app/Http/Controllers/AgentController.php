<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\User_type;
use App\Models\Calls;
use Illuminate\Http\Request;

class AgentController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        private function getCallsPerMonthView($month, $year, $days,$callsPerHour,$hoursPermition,$daysFestive) {

        //se obtine los dias que trae el mes
        $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
       // $festiveDay = array();
        //arreglo con los dias del mes y cuantos tiene el mes
        $daysWeek     = array("Lunes"     => array("num" => 0, "type" => -1,)
                             ,"Martes"    => array("num" => 0, "type" => -1,)
                             ,"Miercoles" => array("num" => 0, "type" => -1,)
                             ,"Jueves"    => array("num" => 0, "type" => -1,)
                             ,"Viernes"   => array("num" => 0, "type" => -1,)
                             ,"Sabado"    => array("num" => 0, "type" => -1,)
                             ,"Domingo"   => array("num" => 0, "type" => -1,));
        
         //marcamos inicio y fin dell mes
        $monthInitial = strtotime($year.'-'.$month.'-01');
        $monthFinish  =  strtotime(date("d-m-Y",strtotime($year.'-'.$month.'-'.$numDaysMonth.""))); 
 
       /* foreach($daysFestive as $item){
            return
        }*/

          //se recorre todo el mes
        for ($i = $monthInitial; $i <= $monthFinish; $i += 86400) {
            //Sacar el dia de la semana con el modificador N de la funcion date
            $dia = date('N', $i);
            
            switch ($dia) {
                case 1:
                    $daysWeek["Lunes"]["num"]  =  $daysWeek["Lunes"]["num"] + 1;
                 break;
                case 2:
                    $daysWeek["Martes"]["num"] =  $daysWeek["Martes"]["num"] + 1;
                 break;
                case 3:
                    $daysWeek["Miercoles"]["num"] =  $daysWeek["Miercoles"]["num"] + 1;
                 break;
                case 4:
                    $daysWeek["Jueves"]["num"] =  $daysWeek["Jueves"]["num"] + 1;
                 break;
                case 5:
                    $daysWeek["Viernes"]["num"] =  $daysWeek["Viernes"]["num"] + 1;
                 break;
                case 6:
                    $daysWeek["Sabado"]["num"] =  $daysWeek["Sabado"]["num"] + 1;
                 break;
                case 7:
                    $daysWeek["Domingo"]["num"] =  $daysWeek["Domingo"]["num"] + 1;
                 break;

                default:
                    break;
            }
          
        }
        
                 foreach ($days as $itemDay) {
            switch ($itemDay->day) {
                case 1:
                    $daysWeek["Lunes"]["type"]  = $itemDay->type; 
                    break;
                case 2:
                    $daysWeek["Martes"]["type"] = $itemDay->type;
                    break;
                case 3:
                    $daysWeek["Miercoles"]["type"] = $itemDay->type;
                    break;
                case 4:
                    $daysWeek["Jueves"]["type"] = $itemDay->type;
                    break;
                case 5:
                    $daysWeek["Viernes"]["type"] = $itemDay->type;
                    break;
                case 6:
                    $daysWeek["Sabado"]["type"] = $itemDay->type;
                    break;
                case 7:
                    $daysWeek["Domingo"]["type"] = $itemDay->type;
                    break;

                default:
                    break;
            }
        }

        $hourPerMont = 0;
        $hourToday   = 0;

               
                foreach ($daysWeek as $itemDays) {
                    if ($itemDays["type"] > 0) {
                         $hourPerMont = $hourPerMont + ($itemDays["num"] * $itemDays["type"]);
                        /*if ($itemDays["type"] == 1) {
                            $hourPerMont = $hourPerMont + ($itemDays["num"] * 8);
                        } else {
                            $hourPerMont = $hourPerMont + ($itemDays["num"] * 4);
                        }*/
                    }
                }
                
       
               $CallPerMont = ($hourPerMont - $hoursPermition) * ($callsPerHour);

            return $CallPerMont;
    
        return $daysWeek;
    }
    
        private function getCallsPerday($month, $year, $days,$callsPerHour,$callsPerMonth,$callsInSystem){
            
            $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $CallInSyste = sizeof($callsInSystem);
            $totalCallsInMonth = $callsPerMonth - $CallInSyste;
            $today = date("d");
            $dayL  = date("N");
            $monthInitial = strtotime($year.'-'.$month.'-'.$today);
            $monthFinish  = strtotime(date("d-m-Y",strtotime($year.'-'.$month.'-'.$numDaysMonth."+ 1 days")));    
            
            //num cuantas veces existe en el mes
            $daysWeek     = array("Lunes"     => array("num" => 0, "type" => -1,"today" => 0)
                             ,"Martes"    => array("num" => 0, "type" => -1,"today" => 0)
                             ,"Miercoles" => array("num" => 0, "type" => -1,"today" => 0)
                             ,"Jueves"    => array("num" => 0, "type" => -1,"today" => 0)
                             ,"Viernes"   => array("num" => 0, "type" => -1,"today" => 0)
                             ,"Sabado"    => array("num" => 0, "type" => -1,"today" => 0)
                             ,"Domingo"   => array("num" => 0, "type" => -1,"today" => 0));
            
            
             for ($i = $monthInitial; $i <= $monthFinish; $i += 86400) {
            //Sacar el dia de la semana con el modificador N de la funcion date
            $dia = date('N', $i);
            
            switch ($dia) {
                case 1:
                    $daysWeek["Lunes"]["num"]  =  $daysWeek["Lunes"]["num"] + 1;
                 break;
                case 2:
                    $daysWeek["Martes"]["num"] =  $daysWeek["Martes"]["num"] + 1;
                 break;
                case 3:
                    $daysWeek["Miercoles"]["num"] =  $daysWeek["Miercoles"]["num"] + 1;
                 break;
                case 4:
                    $daysWeek["Jueves"]["num"] =  $daysWeek["Jueves"]["num"] + 1;
                 break;
                case 5:
                    $daysWeek["Viernes"]["num"] =  $daysWeek["Viernes"]["num"] + 1;
                 break;
                case 6:
                    $daysWeek["Sabado"]["num"] =  $daysWeek["Sabado"]["num"] + 1;
                 break;
                case 7:
                    $daysWeek["Domingo"]["num"] =  $daysWeek["Domingo"]["num"] + 1;
                 break;

                default:
                    break;
            }
          
        }
        
           foreach ($days as $itemDay) {
            switch ($itemDay->day) {
                case 1:
                    $daysWeek["Lunes"]["type"]  = $itemDay->type; 
                    break;
                case 2:
                    $daysWeek["Martes"]["type"] = $itemDay->type;
                    break;
                case 3:
                    $daysWeek["Miercoles"]["type"] = $itemDay->type;
                    break;
                case 4:
                    $daysWeek["Jueves"]["type"] = $itemDay->type;
                    break;
                case 5:
                    $daysWeek["Viernes"]["type"] = $itemDay->type;
                    break;
                case 6:
                    $daysWeek["Sabado"]["type"] = $itemDay->type;
                    break;
                case 7:
                    $daysWeek["Domingo"]["type"] = $itemDay->type;
                    break;

                default:
                    break;
            }
        }
        
         switch ($dayL) {
                case 1:
                    $daysWeek["Lunes"]["today"]  =  1;
                 break;
                case 2:
                    $daysWeek["Martes"]["today"] = 1;
                 break;
                case 3:
                    $daysWeek["Miercoles"]["today"] = 1;
                 break;
                case 4:
                    $daysWeek["Jueves"]["today"] = 1;
                 break;
                case 5:
                    $daysWeek["Viernes"]["today"] =  1;
                 break;
                case 6:
                    $daysWeek["Sabado"]["today"] =  1;
                 break;
                case 7:
                    $daysWeek["Domingo"]["today"] =  1;
                 break;

                default:
                    break;
            }
          
        
        
        $hourPerMont = 0;
        $hourToday   = 0;

                foreach ($daysWeek as $itemDays) {
                    if ($itemDays["type"] > 0) {
                        
                         $hourPerMont = $hourPerMont + ($itemDays["num"] * $itemDays["type"]);
                         if($itemDays["today"] == 1){
                               $hourToday = $itemDays["type"];
                          }
                        
                     /*   if ($itemDays["type"] == 1) {
                            $hourPerMont = $hourPerMont + ($itemDays["num"] * 8);
                             if($itemDays["today"] == 1){
                               $hourToday = 8;
                          }
                          
                        } else {
                            $hourPerMont = $hourPerMont + ($itemDays["num"] * 4);
                            if($itemDays["today"] == 1){
                               $hourToday = 4;
                          }
                        }*/
                         
                    }
                }
                
                if($hourPerMont > 0){
                $CallPerMont = round(($totalCallsInMonth / $hourPerMont) * $hourToday);
                }else{
                $CallPerMont = round($totalCallsInMonth * $hourToday);    
                }

            return $CallPerMont;
            
        }
        
        private function bonds($month, $year, $agent){
            
            $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $today = date("d");

            $monthInitial = $year.'-'.$month.'-1';
            $monthFinish  = $year.'-'.$month.'-'.$numDaysMonth;
            
            $bods      = array();
            
            $bond_base = DB::table('bond_base as b')
                           ->join('agent_by_bond as a','a.fkBond','=','b.pkBond_base')
                           ->select('b.pkBond_base'
                                   ,'b.montRec'
                                   //,'b.porcentBon'
                                   ,'b.montMin'
                                   ,'b.firstAgent'
                                   ,'b.porcentPenalty'
                                   ,'b.porcentFirst')
                           ->where('b.status','=',1)
                           ->where('a.status','=',1)
                           ->where('a.typeBond','=',1)
                           ->where('a.fkUser','=',$agent)
                           ->whereDate('b.dateBon','>=',$monthInitial)
                           ->whereDate('b.dateBon','<=',$monthFinish)
                           ->first();

        if(!empty($bond_base->pkBond_base)){
            $bondPenality = DB::table('penality_by_bond')
                              ->select('penality')
                              ->where('status','=',1)
                              ->where('fkUser','=',$agent)
                              ->where('fkBond_base','=',$bond_base->pkBond_base)
                              ->first();    
        

            
            if(!empty($bond_base->pkBond_base)){
                $bods["base"] = array("pkBond_base"     => $bond_base->pkBond_base
                                     ,"montRec"         => $bond_base->montRec
                                     //,"porcentBon"      => $bond_base->porcentBon
                                     ,"montMin"         => $bond_base->montMin
                                     ,"firstAgent"      => $bond_base->firstAgent
                                     ,"porcentPenalty"  => $bondPenality->penality
                                     ,"porcentFirst"    => $bond_base->porcentFirst);
            }
        }
            
            $bond_record = DB::table('bond_record as b')
                            ->join('agent_by_bond as a','a.fkBond','=','b.pkBound_record')
                           ->select('b.pkBound_record'
                                   ,'b.slcTypeMont'
                                   ,'b.montRep'
                                   ,'b.montMet')
                           ->where('b.status','=',1)
                           ->where('a.status','=',1)
                           ->where('a.typeBond','=',2)
                           ->where('a.fkUser','=',$agent)
                           ->whereDate('b.dateBon','>=',$monthInitial)
                           ->whereDate('b.dateBon','<=',$monthFinish)
                           ->first();
            
             if(!empty($bond_record->pkBound_record)){
                $bods["record"] = array("pkBound_record"  => $bond_record->pkBound_record
                                       ,"montVent"        => $bond_record->montMet
                                       ,"slcTypeMont"     => $bond_record->slcTypeMont
                                       ,"montRep"         => $bond_record->montRep
                                       ,"montMet"         => $bond_record->montMet);
            }
            
            $bonus_techo = DB::table('bonus_techo as b')
                           ->join('agent_by_bond as a','a.fkBond','=','b.pkBonus_techo')
                           ->select('b.pkBonus_techo'
                                   ,'b.montMet'
                                   ,'b.montRep'
                                   ,'b.slcTypeMont'
                                   ,'b.montPen')
                           ->where('b.status','=',1)
                           ->where('a.status','=',1)
                           ->where('a.typeBond','=',3)
                           ->where('a.fkUser','=',$agent)
                           ->whereDate('b.dateBon','>=',$monthInitial)
                           ->whereDate('b.dateBon','<=',$monthFinish)
                           ->first();
            
            
              if(!empty($bonus_techo->pkBonus_techo)){
                $bods["techo"] = array("pkBonus_techo"   => $bonus_techo->pkBonus_techo
                                       ,"montMet"        => $bonus_techo->montMet
                                       ,"montRep"        => $bonus_techo->montRep
                                       ,"slcTypeMont"    => $bonus_techo->slcTypeMont
                                       ,"montPen"        => $bonus_techo->montPen);
            }
            
            return $bods;
        }
        
        private function viewSalary($month, $year, $agent, $montBase, $montReal,$bonds){
            
            $salary         = array();
            
            $totalSaleGroup = 0;
            $totalSale      = 0;
            $totalSalePromo = 0;
            
            $bondBase       = 0;
            $totalBase      = 0;
            $porcentBase    = 0;
            $montRecBase    = 0;
            
            $bondRecord     = 0;
            $totalRecord    = 0;
            $porcentRecord  = 0;
            $montRecRecord  = 0;
            
            $bondTecho      = 0;
            $totalTecho     = 0;
            $porcentTecho   = 0;
            $montRecTecho   = 0;
            
            $penality       = 0;
            $penalityBase   = 0;
            $penalityTecho = 0;
            $comition       = 0;
            
            $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $monthInitial = $year.'-'.$month.'-1';
            $monthFinish  = $year.'-'.$month.'-'.$numDaysMonth;
            
            
            
            $sales = DB::table('quotations as q')
                       ->join('quotations_detail as d','d.fkQuotations','=','q.pkQuotations')
                       ->select(DB::raw("SUM(d.price) as price"))
                       ->where('q.status','=',1)
                       ->where('d.status','=',1)
                       ->where('d.isSelected','=',1)
                       ->where('q.fkUser','=',$agent)
                       ->where('q.quotations_status','=',5)
                       ->whereDate('final_date','>=',$monthInitial)
                       ->whereDate('final_date','<=',$monthFinish)
                       ->first();

            if(!empty($sales->price)){
             $totalSale     = $sales->price;   
            }
            
            $comitionsearch = DB::table('comition as c')
                          ->join('agent_by_bond as a','a.fkBond','=','c.pkComition')
                          ->select('c.pkComition'
                                  ,'c.higher_to'
                                  ,'c.higher_or_equal_to'
                                  ,'c.less_or_equal_to'
                                  ,'c.less_to'
                                  ,'c.comition_higher'
                                  ,'c.comition_higher_less'
                                  ,'c.comition_less')
                           ->where('a.status','=',1)
                           ->where('a.typeBond','=',4)
                           ->where('a.fkUser','=',$agent)
                          ->whereDate('c.dateBon','>=',$monthInitial)
                          ->whereDate('c.dateBon','<=',$monthFinish)
                          ->first();
            
         
            if(!empty($comitionsearch->pkComition)){
                
                if($totalSale > 0){
                    
            if($totalSale > $comitionsearch->higher_to){
              $comition  = ($totalSale * $comitionsearch->comition_higher ) / 100;
            }
            if(($comitionsearch->higher_or_equal_to > 0) && ($comitionsearch->less_or_equal_to > 0)){
                if($totalSale >= $comitionsearch->higher_or_equal_to || $totalSale <= $comitionsearch->less_or_equal_to){
                    $comition = ($totalSale * $comitionsearch->comition_higher_less ) / 100;
                }
            }
            
            if($totalSale <= $comitionsearch->less_to){
                $comition = ($totalSale * $comitionsearch->comition_less ) / 100;
              }
             }
            }
            
            $salesPromo = DB::table('quotations as q')
                       ->join('quotations_detail as d','d.fkQuotations','=','q.pkQuotations')
                       ->select(DB::raw("SUM(d.price) as price"))
                       ->where('q.status','=',1)
                       ->where('d.status','=',1)
                       ->where('d.isSelected','=',1)
                       ->where('d.type','=',1)
                       ->where('q.fkUser','=',$agent)
                       ->where('q.quotations_status','=',5)
                       ->whereDate('final_date','>=',$monthInitial)
                       ->whereDate('final_date','<=',$monthFinish)
                       ->first();
            
         if(isset($bonds["record"])){
            $agentInBonusRecord = DB::table('agent_by_bond')
                                    ->select('fkUser')
                                    ->where('status','=',1)
                                    ->where('typeBond','=',2)
                                    ->where('fkBond','=',$bonds["record"]["pkBound_record"])
                                    ->get();
            
           foreach($agentInBonusRecord as $infoUser){
               
                $sales = DB::table('quotations as q')
                       ->join('quotations_detail as d','d.fkQuotations','=','q.pkQuotations')
                       ->select(DB::raw("SUM(d.price) as price"))
                       ->where('q.status','=',1)
                       ->where('d.status','=',1)
                       ->where('d.isSelected','=',1)
                       //->where('q.fkUser','=',$infoUser->fkUser)
                       ->where('q.quotations_status','=',5)
                       ->whereDate('final_date','>=',$monthInitial)
                       ->whereDate('final_date','<=',$monthFinish)
                       ->first();
                
                if(!empty($sales->price))
                $totalSaleGroup = $sales->price;//$totalSaleGroup +  $sales->price;
           }
         }
            
            if(!empty($salesPromo->price)){
             $totalSalePromo     = $salesPromo->price;   
            }
            
           if(isset($bonds["base"])){
               $montRecBase    = $bonds["base"]["montRec"];
                $bondBase       = 1;
                if(($bonds["base"]["montRec"] <= $totalSale) && ($bonds["base"]["firstAgent"] == $agent)){
                  
                   $totalBase      =  ($montReal * $bonds["base"]["porcentFirst"] ) / 100; 
        
                }
                
                if($bonds["base"]["montMin"] >= $totalSale){
                   $penality      = ($montReal * $bonds["base"]["porcentPenalty"] ) / 100; 
                   $penalityBase  = ($montReal * $bonds["base"]["porcentPenalty"] ) / 100;
                }
                
              $porcentBase =   (100 * $totalSale) / $bonds["base"]["montRec"];
              if($porcentBase > 100){
                  $porcentBase = 100;
              }
           }
           
           if(isset($bonds["record"])){
               $montRecRecord  = $bonds["record"]["montMet"];
                $bondRecord       = 1;
             if($bonds["record"]["montMet"] <= $totalSaleGroup){
                   $percentSales = ($totalSale * 100) / $totalSaleGroup;
                   
                 //  if($bonds["record"]["slcTypeMont"] == 1){
                   $totalRecordAux      = ($totalSaleGroup * $bonds["record"]["montRep"] ) / 100; 
                   $totalRecord         = ($totalRecordAux * $percentSales) / 100;
                //   }else{
                   //$totalRecord      = $bonds["record"]["montRep"];    
                  // }
                }
                
                  $porcentRecord =   (100 * $totalSaleGroup) / $bonds["record"]["montMet"];
               if($porcentRecord > 100){
                  $porcentRecord = 100;
              }
           }
           
           if(isset($bonds["techo"])){
               $montRecTecho   = $bonds["techo"]["montMet"];
               $bondTecho       = 1;
              if($bonds["techo"]["montMet"] <= $totalSalePromo){
                   
                  if($bonds["techo"]["slcTypeMont"] == 1){
                   $totalTecho      = ($totalSalePromo * $bonds["techo"]["montRep"] ) / 100; 
                   }else{
                   $totalTecho      = $bonds["techo"]["montRep"];    
                   }
                }
                
                if($totalSalePromo <= 0){
                   $penality      = ($montReal * $bonds["techo"]["montPen"] ) / 100; 
                   $penalityTecho      = ($montReal * $bonds["techo"]["montPen"] ) / 100; 
                }   
                
                 $porcentTecho =   (100 * $totalSalePromo) / $bonds["techo"]["montMet"];
               if($porcentTecho > 100){
                  $porcentTecho = 100;
              }
              
           }
            
           $salary = array("montBase"       => $montBase
                          ,"montReal"       => $montReal
                          ,"isBonusbase"    => $bondBase
                          ,"totalBonusBase" => $totalBase
                          ,"montRecBase"    => $montRecBase
                          ,"porcentBase"    => $porcentBase
                          ,"isBonusRecord"  => $bondRecord
                          ,"totalBonusRecord" => $totalRecord
                          ,"montRecRecord"    => $montRecRecord
                          ,"porcentRecord"    => $porcentRecord
                          ,"isBonusTecho"    => $bondTecho
                          ,"totalBonusTecho" => $totalTecho
                          ,"montRecTecho"    => $montRecTecho
                          ,"porcentTecho"    => $porcentTecho
                          ,"penality"        => $penality
                          ,"penalityBase"    => $penalityBase
                          ,"penalityTecho"   => $penalityTecho
                          ,"comition"        => $comition
                          ,"totalVent"       => $totalSale
                          ,"totalVentPromo"  => $totalSalePromo
                          ,"totalVentGroup"  => $totalSaleGroup
                   );
            
            return $salary;
        }
        
        private function course($month, $year, $agent){
            
            $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $monthInitial = $year.'-'.$month.'-1';
            $monthFinish  = $year.'-'.$month.'-'.$numDaysMonth;
                      
            $agentBond  = DB::table('capacitation as ca')
                          ->join('courses_by_capacitation as a','a.fkCapacitation','=','ca.pkCapacitation')
                          ->leftjoin('courses as c','c.pkCourses','=','a.pkCourse')
                          ->select('a.pkCourses_by_capacitation'
                                   ,'a.fkCapacitation'
                                   ,'a.nameCourse'
                                   ,'c.name'
                                   ,'c.code'
                                   ,'a.document'
                                   ,'a.isView'
                                   ,'a.pkCourse'
                                   ,'a.expiration_hour'
                                   ,DB::raw("DATE_FORMAT(a.expiration, '%d/%m/%Y') as expiration")
                                   ,'a.penality')
                          ->where('a.status','=',1)
                          ->where('a.fkUser','=',$agent)
                          ->whereDate('a.expiration','>=',$monthInitial)
                          ->whereDate('a.expiration','<=',$monthFinish)
                          ->get();
          
             return $agentBond;
        }
        
        private function coursePenalitation($month, $year, $agent,$montReal){
            
            $numDaysMonth   = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $monthInitial   = $year.'-'.$month.'-1';
            $monthFinish    = $year.'-'.$month.'-'.$numDaysMonth;
            
            $date           = date("Y-m-d");
            $hour           = date("H:i:s");
            
            $penalitation   = 0;
                      
            $agentBond      = DB::table('courses_by_capacitation')
                                    ->select('penality')
                                    ->where('status','=',1)
                                    ->where('fkUser','=',$agent)
                                    ->where('isView','=',0)
                                    ->whereDate('expiration','>=',$monthInitial)
                                    ->whereDate('expiration','<=',$monthFinish)
                                    ->get();
            
            foreach($agentBond as $item){
                $penalitation = $penalitation + (($montReal * $item->penality) / 100);  
            }
            
             return $penalitation;
        }

        public function salesByAgent(){
            
            $arrayCallByUser = array();
            
            $agent = DB::table('users as u')
                       ->select('u.full_name'
                               ,'u.mail'
                               ,'u.pkUser'
                               ,'u.image'
                               ,DB::raw('(SELECT t.color'
                                         . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkUser = u.pkUser'
                                       . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivityColor')
                               ,DB::raw('(SELECT t.text'
                                         . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkUser = u.pkUser'
                                       . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivityType')
                               ,DB::raw('(SELECT t.icon'
                                         . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkUser = u.pkUser'
                                       . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivityIcon')
                                ,DB::raw('(SELECT execution_date'
                                         . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'   
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkUser = u.pkUser'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as finalDayLastActivity')
                               ,DB::raw('(SELECT color'
                                        . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkUser = u.pkUser'
                                         . ' AND a.execution_date IS NULL'
                                       . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivityColor')
                               ,DB::raw('(SELECT  icon'
                                       . ' FROM activities as a'
                                           . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'                                       
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkUser = u.pkUser'
                                         . ' AND a.execution_date IS NULL'
                                       . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivityIcon')
                                ,DB::raw('(SELECT  text'
                                        . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'                                       
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkUser = u.pkUser'
                                         . ' AND a.execution_date IS NULL'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivityText')
                               ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                        . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'   
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkUser = u.pkUser'
                                         . ' AND a.execution_date IS NULL'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as finalDayNexActivity')
                               ,DB::raw('(SELECT SUM(number_places)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.quotations_status = 5) as salesPlaces')
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.quotations_status = 5) as salesMont')
                                )
                       ->where('fkUser_type','!=',1)
                       ->where('u.status','=',1)
                       ->orderby('salesMont','DESC')
                       ->take(10)
                       ->get();

            /*
            $allAgent = DB::table('users as u')
                       ->select('u.full_name'
                               ,'u.mail'
                               ,'u.pkUser'
                               ,'u.image'
                               ,'u.phone_extension'
                             ,DB::raw('(SELECT t.color'
                                         . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkUser = u.pkUser'
                                       . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivityColor')
                               ,DB::raw('(SELECT t.text'
                                         . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkUser = u.pkUser'
                                       . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivityType')
                               ,DB::raw('(SELECT t.icon'
                                         . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkUser = u.pkUser'
                                       . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivityIcon')
                                ,DB::raw('(SELECT execution_date'
                                         . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'   
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkUser = u.pkUser'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as finalDayLastActivity')
                               ,DB::raw('(SELECT color'
                                        . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkUser = u.pkUser'
                                         . ' AND a.execution_date IS NULL'
                                       . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivityColor')
                               ,DB::raw('(SELECT  icon'
                                       . ' FROM activities as a'
                                           . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'                                       
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkUser = u.pkUser'
                                         . ' AND a.execution_date IS NULL'
                                       . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivityIcon')
                                ,DB::raw('(SELECT  text'
                                        . ' FROM activities as a'
                                         . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'                                       
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkUser = u.pkUser'
                                         . ' AND a.execution_date IS NULL'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivityText')
                               ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                        . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'   
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkUser = u.pkUser'
                                         . ' AND a.execution_date IS NULL'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as finalDayNexActivity')
                               ,DB::raw('(SELECT SUM(number_places)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.quotations_status = 5) as salesPlaces')
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.quotations_status = 5) as salesMont')
                                )
                       ->where('fkUser_type','!=',1)
                       ->where('u.status','=',1)
                       ->get();*/
            /*
           foreach($allAgent as $infoUser){
               
             $calls = DB::table('calls')
                        ->where('source','=',$infoUser->phone_extension)
                        ->count();
                     
             $callsRegister = DB::table('activities')
                                ->where('fkActivities_type','=',2)
                                ->count();
             
             $arrayCallByUser[$infoUser->pkUser] = array("calls"          => $calls
                                                        ,"callsRegister"  => $callsRegister
                                                        ,"diferent"       => $callsRegister - $calls);
                     
           }*/

            
            return view('ventas.ventasPorAgente')->with('agent',$agent);
                                                 //->with('allAgent',$allAgent)
                                                 //->with('arrayCallByUser',$arrayCallByUser);
        }
        
        public function viewProfileAgent($id){
                
                $agentInfo = DB::table('users as u')
                               ->join('user_type as t','t.pkUser_type','=','u.fkUser_type')
                               ->select('u.full_name'
                                       ,'u.mail'
                                       ,'u.pkUser'
                                       ,'u.image'
                                       ,'t.name as type'
                                        ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.quotations_status = 2) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . '  AND q.fkUser = u.pkUser'
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.opportunities_status = 2) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.opportunities_status = 1) as oportunityOpen')
                                       )
                                ->where('u.pkUser','=',$id)
                                ->where('u.status','=','1')
                                ->first();
                
              //  dd($agentInfo);
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
                                        ->where('activities.fkUser', '=', $id)
                                        ->select(
                                                'activities.description AS description',
                                                'activities.execution_date AS execution_date',
                                                'activities.execution_hour AS execution_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'activities_subtype.text AS text_subtype',
                                                'activities_subtype.color AS color_subtype',
                                                'users.full_name AS full_name',
                                                'business.name AS business_name')
                                        ->orderBy("execution_date", "asc")
                                        ->orderBy("execution_hour", "asc")
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
                                        ->where('activities.fkUser', '=', $id)
                                        ->select(
                                                'activities.pkActivities  AS pkActivities',
                                                'activities.description AS description',
                                                'activities.final_date AS final_date',
                                                'activities.final_hour AS final_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'users.full_name AS full_name',
                                                'business.name AS business_name'
                                                ,'business.pkBusiness AS pkBusiness')
                                        ->orderBy("final_date", "asc")
                                        ->orderBy("final_hour", "asc")
                                        ->get();                           
                
                $activitiesAuxQuery = DB::table('activities')
                                        ->where('activities.status', '=', 1)
                                        ->where('activities.fkUser', '=', $id)
                                        ->select('fkBusiness')
                                        ->groupBy("fkBusiness")
                                        ->get();       
                
                $arrayBusinessData = array();
                                        
                foreach ($activitiesAuxQuery as $activitiesAuxInfo) {
                    $usersActivities = DB::table('business as b')
                                     ->select('b.name'
                                       ,'b.pkBusiness'
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 2)) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 2)) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 1)) as oportunityOpen')
                                         ,DB::raw('(SELECT SUM(number_places)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1 and d.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesPlaces')
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1 and d.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesMont')
                                             )
                                     ->where('pkBusiness','=',$activitiesAuxInfo->fkBusiness)
                                     ->where('status','=',1)
                                     ->first();
                    
                    if(!empty($usersActivities->pkBusiness)){
                        $arrayBusinessData[$usersActivities->pkBusiness] = array(
                                                                            "pkBusiness"              => $usersActivities->pkBusiness,
                                                                            "name"                    => $usersActivities->name,
                                                                            "salesPay"                => $usersActivities->salesPay,
                                                                            "salesLoss"               => $usersActivities->salesLoss,
                                                                            "quotations"              => $usersActivities->quotations,
                                                                            "oportunityAproved"       => $usersActivities->oportunityAproved,
                                                                            "oportunityLoss"          => $usersActivities->oportunityLoss,
                                                                            "oportunityOpen"          => $usersActivities->oportunityOpen,
                                                                            "salesPlaces"             => $usersActivities->salesPlaces,
                                                                            "salesMont"               => $usersActivities->salesMont
                                                  
                        );
                    }
                }                        
                                        
                $month = date("m");
                $year = date("Y");
                $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
                
                $monthInitial = $year.'-'.$month.'-01';
                $monthFinish  = $year.'-'.$month.'-'.$numDaysMonth;
                $course = "";
                $PenalitationCourse = "";
                
                //PLAN DE TRABAJO MES DEL AGENTE
                $workPlan = DB::table('workplan as w')
                          ->join('users as u','u.pkUser','=','w.fkUser')
                          ->join('currency as c','c.CurrencyISO','=','w.typeCurrency')
                          ->select('u.full_name as agent'
                                  ,'w.pkWorkplan'
                                  ,'w.fkUser'
                                  ,'w.qtyCallsHour'
                                  ,'w.qtyHourMonth'
                                  ,'w.callsFaild'
                                  ,'w.callsLinked'
                                  ,'w.penalty'
                                  ,'w.montBase'
                                  ,'w.typeChange'
                                  ,'w.typeCurrency'
                                  ,'c.CurrencyName as moneda'
                                  ,DB::raw("DATE_FORMAT(dateMonth, '%b/%Y') as date")
                                  ,DB::raw("DATE_FORMAT(dateMonth, '%m') as month")
                                  ,DB::raw("DATE_FORMAT(dateMonth, '%Y') as year")
                                  ,'w.hour')
                          ->where('w.status','=',1)
                          ->where('w.fkUser','=',$id)
                          ->whereDate('w.dateMonth','>=',$monthInitial)
                          ->whereDate('w.dateMonth','<=',$monthFinish)
                          ->first();
                
                $pkWorkin = 0;
    
                if(!empty($workPlan->pkWorkplan)){
                    
                $pkWorkin = $workPlan->pkWorkplan;
                 //DIAS TRABAJADOS
               $days = DB::table('working_days')
                         ->select('day'
                                 ,'type')
                         ->where('fkWorkinPlan','=',$workPlan->pkWorkplan)
                         ->where('status','=',1)
                         ->get();
               //DIAS FESTIVOS
               $daysFestive = DB::table('festive_days')
                         ->where('fkWorkinPlan','=',$workPlan->pkWorkplan)
                         ->where('status','=',1)
                         ->get();
               //LLAMADAS EN SYSTEMA
               $callsInSystem = DB::table('activities')
                                   ->where('fkActivities_type','=',1)
                                   ->where('status','=',1)
                                   ->where('execution_date','!=',"")
                                   ->where('fkUser','=',$workPlan->fkUser)
                                   ->whereDate('execution_date','>=',$monthInitial)
                                   ->whereDate('execution_date','<=',$monthFinish)
                                   ->get();
               //LLAMADAS FALLIDAS EN SYSTEMA
               $callsInSystemFaild = DB::table('activities as a')
                                   ->join('activities_subtype as s','s.pkActivities_subtype','=','a.fkActivities_subtype')
                                   ->select('a.pkActivities')
                                   ->where('a.fkActivities_type','=',1)
                                   ->where('a.status','=',1)
                                   ->where('a.execution_date','!=',"")
                                   ->where('s.status_type','=',2)
                                   ->where('a.fkUser','=',$workPlan->fkUser)
                                   ->whereDate('execution_date','>=',$monthInitial)
                                   ->whereDate('execution_date','<=',$monthFinish)
                                   ->groupby('a.pkActivities')
                                   ->get();
               //LLAMADAS ENLAZADAS EN SYSTEMA
               $callsInSystemLinked = DB::table('activities as a')
                                   ->join('activities_subtype as s','s.pkActivities_subtype','=','a.fkActivities_subtype')
                                   ->select('a.pkActivities')
                                   ->where('a.fkActivities_type','=',1)
                                   ->where('a.status','=',1)
                                   ->where('a.execution_date','!=',"")
                                   ->where('s.status_type','=',1)
                                   ->where('a.fkUser','=',$workPlan->fkUser)
                                   ->whereDate('execution_date','>=',$monthInitial)
                                   ->whereDate('execution_date','<=',$monthFinish)
                                   ->orderby('a.pkActivities')
                                   ->groupby('a.pkActivities')
                                   ->get();
               
               //PERMISOS
               $permition = DB::table('pemition_day')
                               ->select(DB::raw("SUM(hours) as hours"))
                               ->where('fkWorkinPlan','=',$workPlan->pkWorkplan)
                               ->where('status','=',1)
                               ->first();
               
               //
               $usersSource = DB::table('users')
                                ->select('phone_extension')
                                ->where('status','=',1)
                                ->where('pkUser','=',$workPlan->fkUser)
                                ->first();
                       
               //LLAMADAS REGISTRO
               $callsInRegister = DB::table('calls')
                                   ->where('status','=',1)
                                   ->where('source','=',$usersSource->phone_extension)
                                   ->whereDate('date','>=',$monthInitial)
                                   ->whereDate('date','<=',$monthFinish)
                                   ->get();
               
                //LLAMADAS ENLAZADAS REGISTRO
               $callsLinkedInRegister = DB::table('calls')
                                   ->where('status','=',1)
                                   ->where('status_type','=',1)
                                   ->where('source','=',$usersSource->phone_extension)
                                   ->whereDate('date','>=',$monthInitial)
                                   ->whereDate('date','<=',$monthFinish)
                                   ->get();
               
                //LLAMADAS PERDIDAS REGISTRO
               $callsFailedInRegister = DB::table('calls')
                                   ->where('status','=',1)
                                   ->where('status_type','=',2)
                                   ->where('source','=',$usersSource->phone_extension)
                                   ->whereDate('date','>=',$monthInitial)
                                   ->whereDate('date','<=',$monthFinish)
                                   ->get();
               
               
               
               
                $callsSystem      = sizeof($callsInSystem);
                $callsSystemFaild = sizeof($callsInSystemFaild);
                $callsSystemLiked = sizeof($callsInSystemLinked);     
                
                $callsRegister      = sizeof($callsInRegister);
                $callsRegisterFaild = sizeof($callsFailedInRegister);
                $callsRegisterLiked = sizeof($callsLinkedInRegister);  
                
              
               //dd();
              $calltomonth = $this->getCallsPerMonthView($workPlan->month, $workPlan->year, $days, $workPlan->qtyCallsHour,$permition->hours,$daysFestive); 
              //$callstoday  = $this->getCallsPerday($workPlan->month, $workPlan->year,$days, $workPlan->qtyCallsHour, $calltomonth,$callsInSystem);
              $callstoday  = $this->getCallsPerday($workPlan->month, $workPlan->year,$days, $workPlan->qtyCallsHour, $calltomonth,$callsInRegister);
              $bonds       = $this->bonds($workPlan->month, $workPlan->year,$workPlan->fkUser);
              $course      = $this->course($workPlan->month, $workPlan->year,$workPlan->fkUser);
              
      
              
              $monthBaseReal = 0;
              
             // return $bonds;
              if($callsSystemFaild > 0){
              $callLinkedActual = round((100 * $callsSystemLiked ) / $callsSystem);
              $callLinkedFaildActual = round((100 * $callsSystemFaild ) / $callsSystem);
              }else{
              $callLinkedActual = 0;
              $callLinkedFaildActual = 0;  
              }
              
              
              if($callsRegister > 0){
               $callLinkedActualRegister     = round((100 * $callsRegisterLiked ) / $callsRegister);
              $callLinkedFaildActualRegister = round((100 * $callsRegisterFaild ) / $callsRegister);
              }else{
                $callLinkedActualRegister    = 0;
              $callLinkedFaildActualRegister = 0;
              }
              
              
              $porcentCall = round((100 * $callsSystem ) / $calltomonth);
              $porcentCallRegiter = round((100 * $callsRegister ) / $calltomonth);
              
              $mountBaseAux = $workPlan->montBase;
              
              if($porcentCallRegiter < 100){
                  $workPlan->montBase = ($porcentCallRegiter * $workPlan->montBase) / 100;
              }
              
              $callLinkedTotal = round(($calltomonth * $workPlan->callsLinked) / 100);
              $callLinkedFaild = round(($calltomonth * $workPlan->callsFaild) / 100);
              
              $callLinkedTotalRegister = round(($calltomonth * $callsRegisterLiked) / 100);
              $callLinkedFaildRegister = round(($calltomonth * $callsRegisterFaild) / 100);
              
            
              
            
              
              if( ($workPlan->callsFaild < $callLinkedFaildActualRegister) || $callsRegister <= 0){
                    $monthBaseReal = $workPlan->montBase;//$workPlan->montBase - ( ($workPlan->montBase * $workPlan->penalty) / 100);
                  }else{
                    $monthBaseReal = $workPlan->montBase;
                  }
              
             $salary       = $this->viewSalary($workPlan->month, $workPlan->year,$workPlan->fkUser,$mountBaseAux,$monthBaseReal,$bonds);
             $PenalitationCourse  = $this->coursePenalitation($workPlan->month, $workPlan->year,$workPlan->fkUser, $monthBaseReal);
             
              
             

              $arrayWorkPlan[$workPlan->pkWorkplan] = array("pkWorkplan"         => $workPlan->pkWorkplan
                                                       ,"date"                    => $workPlan->date
                                                       ,"agent"                   => $workPlan->agent
                                                       ,"qtyCallsHour"            => $workPlan->qtyCallsHour 
                                                       ,"qtyHourMonth"            => $calltomonth
                                                       ,"qtyCallsToday"           => $callstoday
                                                       ,"callsLinked"             => $workPlan->callsLinked
                                                       ,"callsFaild"              => $workPlan->callsFaild
                                                       ,"penalty"                 => $workPlan->penalty
                                                       ,"montBase"                => $workPlan->montBase
                                                       ,"typeChange"              => $workPlan->typeChange
                                                       ,"moneda"                  => $workPlan->moneda
                                                       ,"callSystem"              => $callsSystem
                                                       ,"callSystemPorcent"       => $porcentCall
                                                       ,"callLinkedTotal"         => $callLinkedTotal
                                                       ,"callLinkedFaild"         => $callLinkedFaild
                                                       ,"callLinkedActualPorcent" => $callLinkedActual
                                                       ,"callFaildActualPorcent"  => $callLinkedFaildActual
                                                       ,"callsLinkedActual"       => $callsSystemLiked
                                                       ,"callsFiledActual"        => $callsSystemFaild
                                                       ,"callRegister"            => $callsRegister
                                                       ,"callRegisterPorcent"      => $porcentCallRegiter
                                                       ,"callsLinkedActualR"       => $callsRegisterLiked
                                                       ,"callsFiledActualR"        => $callsRegisterFaild
                                                       ,"callLinkedActualPorcentR" => $callLinkedActualRegister
                                                       ,"callFaildActualPorcentR"  => $callLinkedFaildActualRegister
                                                       ,"bonds"                    => $bonds
                                                       );
         
             // dd($arrayWorkPlan);
                }else{
                 $arrayWorkPlan[0] = array("pkWorkplan"                           => 0
                                                       ,"date"                    => "N/A"
                                                       ,"agent"                   => "N/A"
                                                       ,"qtyCallsHour"            => 0
                                                       ,"qtyHourMonth"            => 0
                                                       ,"qtyCallsToday"           => 0
                                                       ,"callsLinked"             => 0
                                                       ,"callsFaild"              => 0
                                                       ,"penalty"                 => "N/A"
                                                       ,"montBase"                => 0
                                                       ,"typeChange"              => "N/A"
                                                       ,"moneda"                  => "N/A"
                                                       ,"callSystem"              => 0
                                                       ,"callSystemPorcent"       => 0
                                                       ,"callLinkedTotal"         => 0
                                                       ,"callLinkedFaild"         => 0
                                                       ,"callLinkedActualPorcent" => 0
                                                       ,"callFaildActualPorcent"  => 0
                                                       ,"callsLinkedActual"       => 0
                                                       ,"callsFiledActual"        => 0
                                                       ,"callRegister"            => 0
                                                       ,"callRegisterPorcent"      => 0
                                                       ,"callsLinkedActualR"       => 0
                                                       ,"callsFiledActualR"        => 0
                                                       ,"callLinkedActualPorcentR" => 0
                                                       ,"callFaildActualPorcentR"  => 0);   
                 
                 
                 $salary = array("montBase" =>0
                          ,"montReal"       => 0
                          ,"isBonusbase"    => 0
                          ,"totalBonusBase" => 0
                          ,"montRecBase"    => 0
                          ,"porcentBase"    => 0
                          ,"isBonusRecord"  => 0
                          ,"totalBonusRecord" => 0
                          ,"montRecRecord"    => 0
                          ,"porcentRecord"    => 0
                          ,"isBonusTecho"    => 0
                          ,"totalBonusTecho" => 0
                          ,"montRecTecho"    => 0
                          ,"porcentTecho"    => 0
                          ,"penality"        => 0
                          ,"comition"        => 0
                          ,"totalVent"       => 0
                          ,"totalVentPromo"  => 0
                          ,"totalVentGroup"  => 0);
                }
                
                //tipos de actividad

                $typeActivity = DB::table('activities_type')
                                 ->select('text'
                                         ,'color'
                                         ,'icon'
                                         ,'pkActivities_type')
                                  ->where('status','=',1)
                                  ->where('pkActivities_type','>',0)
                                  ->get();

                return view('agentes.detAgente')->with('agentInfo',$agentInfo)
                                                ->with('lastActivitiesQuery',$lastActivitiesQuery)
                                                ->with('activitiesQuery',$activitiesQuery)
                                                ->with('arrayBusinessData',$arrayBusinessData)
                                                ->with('date',$date)
                                                ->with('hour',$hour)
                                                ->with('pkUser',$id)
                                                ->with('pkWorkplan',$pkWorkin)
                                                ->with('arrayWorkPlan',$arrayWorkPlan)
                                                ->with('salary',$salary)
                                                ->with('course',$course)
                                                ->with('typeActivity',$typeActivity)
                                                ->with('PenalitationCourse',$PenalitationCourse);
            }

            public function viewWorkinAgent($id,$month,$year){
                
                $agentInfo = DB::table('users as u')
                               ->join('user_type as t','t.pkUser_type','=','u.fkUser_type')
                               ->select('u.full_name'
                                       ,'u.mail'
                                       ,'u.pkUser'
                                       ,'u.image'
                                       ,'t.name as type'
                                        ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.quotations_status = 2) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . '  AND q.fkUser = u.pkUser'
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.opportunities_status = 2) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q inner join business as b on b.pkBusiness=q.fkBusiness'
                                         . ' WHERE q.status = 1 and b.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.opportunities_status = 1) as oportunityOpen')
                                       )
                                ->where('u.pkUser','=',$id)
                                ->where('u.status','=','1')
                                ->first();
                
              //  dd($agentInfo);
 
               // $month = date("m");
               // $year = date("Y");
                $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
                
                $monthInitial = $year.'-'.$month.'-01';
                $monthFinish  = $year.'-'.$month.'-'.$numDaysMonth;
                $course = "";
                $PenalitationCourse = "";
                
                //PLAN DE TRABAJO MES DEL AGENTE
                $workPlan = DB::table('workplan as w')
                          ->join('users as u','u.pkUser','=','w.fkUser')
                          ->join('currency as c','c.CurrencyISO','=','w.typeCurrency')
                          ->select('u.full_name as agent'
                                  ,'w.pkWorkplan'
                                  ,'w.fkUser'
                                  ,'w.qtyCallsHour'
                                  ,'w.qtyHourMonth'
                                  ,'w.callsFaild'
                                  ,'w.callsLinked'
                                  ,'w.penalty'
                                  ,'w.montBase'
                                  ,'w.typeChange'
                                  ,'w.typeCurrency'
                                  ,'c.CurrencyISO as moneda'
                                  ,DB::raw("DATE_FORMAT(dateMonth, '%b/%Y') as date")
                                  ,DB::raw("DATE_FORMAT(dateMonth, '%m') as month")
                                  ,DB::raw("DATE_FORMAT(dateMonth, '%Y') as year")
                                  ,'w.hour')
                          ->where('w.status','=',1)
                          ->where('w.fkUser','=',$id)
                          ->whereDate('w.dateMonth','>=',$monthInitial)
                          ->whereDate('w.dateMonth','<=',$monthFinish)
                          ->first();
                
                $pkWorkin = 0;
    
                if(!empty($workPlan->pkWorkplan)){
                    
                $pkWorkin = $workPlan->pkWorkplan;
                 //DIAS TRABAJADOS
               $days = DB::table('working_days')
                         ->select('day'
                                 ,'type')
                         ->where('fkWorkinPlan','=',$workPlan->pkWorkplan)
                         ->where('status','=',1)
                         ->get();
               //DIAS FESTIVOS
               $daysFestive = DB::table('festive_days')
                         ->where('fkWorkinPlan','=',$workPlan->pkWorkplan)
                         ->where('status','=',1)
                         ->get();
               //LLAMADAS EN SYSTEMA
               $callsInSystem = DB::table('activities')
                                   ->where('fkActivities_type','=',1)
                                   ->where('status','=',1)
                                   ->where('execution_date','!=',"")
                                   ->where('fkUser','=',$workPlan->fkUser)
                                   ->whereDate('execution_date','>=',$monthInitial)
                                   ->whereDate('execution_date','<=',$monthFinish)
                                   ->get();
               //LLAMADAS FALLIDAS EN SYSTEMA
               $callsInSystemFaild = DB::table('activities as a')
                                   ->join('activities_subtype as s','s.pkActivities_subtype','=','a.fkActivities_subtype')
                                   ->select('a.pkActivities')
                                   ->where('a.fkActivities_type','=',1)
                                   ->where('a.status','=',1)
                                   ->where('a.execution_date','!=',"")
                                   ->where('s.status_type','=',2)
                                   ->where('a.fkUser','=',$workPlan->fkUser)
                                   ->whereDate('execution_date','>=',$monthInitial)
                                   ->whereDate('execution_date','<=',$monthFinish)
                                   ->groupby('a.pkActivities')
                                   ->get();
               //LLAMADAS ENLAZADAS EN SYSTEMA
               $callsInSystemLinked = DB::table('activities as a')
                                   ->join('activities_subtype as s','s.pkActivities_subtype','=','a.fkActivities_subtype')
                                   ->select('a.pkActivities')
                                   ->where('a.fkActivities_type','=',1)
                                   ->where('a.status','=',1)
                                   ->where('a.execution_date','!=',"")
                                   ->where('s.status_type','=',1)
                                   ->where('a.fkUser','=',$workPlan->fkUser)
                                   ->whereDate('execution_date','>=',$monthInitial)
                                   ->whereDate('execution_date','<=',$monthFinish)
                                   ->orderby('a.pkActivities')
                                   ->groupby('a.pkActivities')
                                   ->get();
               
               //PERMISOS
               $permition = DB::table('pemition_day')
                               ->select(DB::raw("SUM(hours) as hours"))
                               ->where('fkWorkinPlan','=',$workPlan->pkWorkplan)
                               ->where('status','=',1)
                               ->first();
               
               //
               $usersSource = DB::table('users')
                                ->select('phone_extension')
                                ->where('status','=',1)
                                ->where('pkUser','=',$workPlan->fkUser)
                                ->first();
                       
               //LLAMADAS REGISTRO
               $callsInRegister = DB::table('calls')
                                   ->where('status','=',1)
                                   ->where('source','=',$usersSource->phone_extension)
                                   ->whereDate('date','>=',$monthInitial)
                                   ->whereDate('date','<=',$monthFinish)
                                   ->get();
               
                //LLAMADAS ENLAZADAS REGISTRO
               $callsLinkedInRegister = DB::table('calls')
                                   ->where('status','=',1)
                                   ->where('status_type','=',1)
                                   ->where('source','=',$usersSource->phone_extension)
                                   ->whereDate('date','>=',$monthInitial)
                                   ->whereDate('date','<=',$monthFinish)
                                   ->get();
               
                //LLAMADAS PERDIDAS REGISTRO
               $callsFailedInRegister = DB::table('calls')
                                   ->where('status','=',1)
                                   ->where('status_type','=',2)
                                   ->where('source','=',$usersSource->phone_extension)
                                   ->whereDate('date','>=',$monthInitial)
                                   ->whereDate('date','<=',$monthFinish)
                                   ->get();
               
               
               
               
                $callsSystem      = sizeof($callsInSystem);
                $callsSystemFaild = sizeof($callsInSystemFaild);
                $callsSystemLiked = sizeof($callsInSystemLinked);     
                
                $callsRegister      = sizeof($callsInRegister);
                $callsRegisterFaild = sizeof($callsFailedInRegister);
                $callsRegisterLiked = sizeof($callsLinkedInRegister);  
                
                //$callsInRegister VS $calltomonth  $workPlan->montBase
              
               //dd();
              $calltomonth = $this->getCallsPerMonthView($workPlan->month, $workPlan->year, $days, $workPlan->qtyCallsHour,$permition->hours,$daysFestive); 
              //$callstoday  = $this->getCallsPerday($workPlan->month, $workPlan->year,$days, $workPlan->qtyCallsHour, $calltomonth,$callsInSystem);
              $callstoday  = $this->getCallsPerday($workPlan->month, $workPlan->year,$days, $workPlan->qtyCallsHour, $calltomonth,$callsInRegister);
              $bonds       = $this->bonds($workPlan->month, $workPlan->year,$workPlan->fkUser);
              $course      = $this->course($workPlan->month, $workPlan->year,$workPlan->fkUser);
              
      
              
              $monthBaseReal = 0;
              
             // return $bonds;
              if($callsSystemFaild > 0){
              $callLinkedActual = round((100 * $callsSystemLiked ) / $callsSystem);
              $callLinkedFaildActual = round((100 * $callsSystemFaild ) / $callsSystem);
              }else{
              $callLinkedActual = 0;
              $callLinkedFaildActual = 0;  
              }
              
              
              if($callsRegister > 0){
               $callLinkedActualRegister     = round((100 * $callsRegisterLiked ) / $callsRegister);
              $callLinkedFaildActualRegister = round((100 * $callsRegisterFaild ) / $callsRegister);
              }else{
                $callLinkedActualRegister    = 0;
              $callLinkedFaildActualRegister = 0;
              }
              
              
              $porcentCall = (100 * $callsSystem ) / $calltomonth; 
              $porcentCallRegiter = (100 * $callsRegister ) / $calltomonth;
              
              $mountBaseAux = $workPlan->montBase;
              
              if($porcentCallRegiter < 100){
                  $workPlan->montBase = ($porcentCallRegiter * $workPlan->montBase) / 100;
              }
              
              $callLinkedTotal = round(($calltomonth * $workPlan->callsLinked) / 100);
              $callLinkedFaild = round(($calltomonth * $workPlan->callsFaild) / 100);
              
              $callLinkedTotalRegister = round(($calltomonth * $callsRegisterLiked) / 100);
              $callLinkedFaildRegister = round(($calltomonth * $callsRegisterFaild) / 100);
              
              
                if( ($workPlan->callsFaild < $callLinkedFaildActualRegister) || $callsRegister <= 0){
                    $monthBaseReal = $workPlan->montBase - ( ($workPlan->montBase * $workPlan->penalty) / 100);
                  }else{
                    $monthBaseReal = $workPlan->montBase;
                  }

              
             $salary       = $this->viewSalary($workPlan->month, $workPlan->year,$workPlan->fkUser,$mountBaseAux,$monthBaseReal,$bonds);
             $PenalitationCourse  = $this->coursePenalitation($workPlan->month, $workPlan->year,$workPlan->fkUser, $monthBaseReal);
             
              
               
              $arrayWorkPlan[$workPlan->pkWorkplan] = array("pkWorkplan"         => $workPlan->pkWorkplan
                                                       ,"date"                    => $workPlan->date
                                                       ,"agent"                   => $workPlan->agent
                                                       ,"qtyCallsHour"            => $workPlan->qtyCallsHour 
                                                       ,"qtyHourMonth"            => $calltomonth
                                                       ,"qtyCallsToday"           => $callstoday
                                                       ,"callsLinked"             => $workPlan->callsLinked
                                                       ,"callsFaild"              => $workPlan->callsFaild
                                                       ,"penalty"                 => $workPlan->penalty
                                                       ,"montBase"                => $workPlan->montBase
                                                       ,"typeChange"              => $workPlan->typeChange
                                                       ,"moneda"                  => $workPlan->moneda
                                                       ,"callSystem"              => $callsSystem
                                                       ,"callSystemPorcent"       => round($porcentCall,2)
                                                       ,"callLinkedTotal"         => $callLinkedTotal
                                                       ,"callLinkedFaild"         => $callLinkedFaild
                                                       ,"callLinkedActualPorcent" => $callLinkedActual
                                                       ,"callFaildActualPorcent"  => $callLinkedFaildActual
                                                       ,"callsLinkedActual"       => $callsSystemLiked
                                                       ,"callsFiledActual"        => $callsSystemFaild
                                                       ,"callRegister"            => $callsRegister
                                                       ,"callRegisterPorcent"      => round($porcentCallRegiter,2)
                                                       ,"callsLinkedActualR"       => $callsRegisterLiked
                                                       ,"callsFiledActualR"        => $callsRegisterFaild
                                                       ,"callLinkedActualPorcentR" => $callLinkedActualRegister
                                                       ,"callFaildActualPorcentR"  => $callLinkedFaildActualRegister
                                                       ,"bonds"                    => $bonds
                                                       );
         
             // dd($arrayWorkPlan);
                }else{
                 $arrayWorkPlan[0] = array("pkWorkplan"                           => 0
                                                       ,"date"                    => "N/A"
                                                       ,"agent"                   => "N/A"
                                                       ,"qtyCallsHour"            => 0
                                                       ,"qtyHourMonth"            => 0
                                                       ,"qtyCallsToday"           => 0
                                                       ,"callsLinked"             => 0
                                                       ,"callsFaild"              => 0
                                                       ,"penalty"                 => "N/A"
                                                       ,"montBase"                => 0
                                                       ,"typeChange"              => "N/A"
                                                       ,"moneda"                  => "N/A"
                                                       ,"callSystem"              => 0
                                                       ,"callSystemPorcent"       => 0
                                                       ,"callLinkedTotal"         => 0
                                                       ,"callLinkedFaild"         => 0
                                                       ,"callLinkedActualPorcent" => 0
                                                       ,"callFaildActualPorcent"  => 0
                                                       ,"callsLinkedActual"       => 0
                                                       ,"callsFiledActual"        => 0
                                                       ,"callRegister"            => 0
                                                       ,"callRegisterPorcent"      => 0
                                                       ,"callsLinkedActualR"       => 0
                                                       ,"callsFiledActualR"        => 0
                                                       ,"callLinkedActualPorcentR" => 0
                                                       ,"callFaildActualPorcentR"  => 0);   
                 
                 
                 $salary = array("montBase" =>0
                          ,"montReal"       => 0
                          ,"isBonusbase"    => 0
                          ,"totalBonusBase" => 0
                          ,"montRecBase"    => 0
                          ,"porcentBase"    => 0
                          ,"isBonusRecord"  => 0
                          ,"totalBonusRecord" => 0
                          ,"montRecRecord"    => 0
                          ,"porcentRecord"    => 0
                          ,"isBonusTecho"    => 0
                          ,"totalBonusTecho" => 0
                          ,"montRecTecho"    => 0
                          ,"porcentTecho"    => 0
                          ,"penality"        => 0
                          ,"comition"        => 0
                          ,"totalVent"       => 0
                          ,"totalVentPromo"  => 0
                          ,"totalVentGroup"  => 0);
                }
                
                //tipos de actividad

                $typeActivity = DB::table('activities_type')
                                 ->select('text'
                                         ,'color'
                                         ,'icon'
                                         ,'pkActivities_type')
                                  ->where('status','=',1)
                                  ->where('pkActivities_type','>',0)
                                  ->get();

                return view('agentes.detWorkAgent')->with('agentInfo',$agentInfo)
                                                ->with('pkUser',$id)
                                                ->with('workPlan',$workPlan)
                                                ->with('pkWorkplan',$pkWorkin)
                                                ->with('arrayWorkPlan',$arrayWorkPlan)
                                                ->with('salary',$salary)
                                                ->with('course',$course)
                                                ->with('typeActivity',$typeActivity)
                                                ->with('PenalitationCourse',$PenalitationCourse);
            }


        public function filterActivity(Request $request){
               
            $idType           = $request->input("idState");
            $id               = $request->input("id");
            $date             = date("Y-m-d");
            $hour             = date("H:i:s");
            $startYear        = date("Y")."-01-01";
            $endYear          = date("Y")."-12-31";
            $month            = date("Y-m");
            $aux              = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day         = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate        = date("Y-m")."-01";
            $endDate          = $last_day;
        
        
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
            ->where('activities.fkUser', '=', $id)
            ->where('activities_type.pkActivities_type', '=', $idType)
            ->select(
                    'activities.pkActivities  AS pkActivities',
                    'activities.description AS description',
                    'activities.final_date AS final_date',
                    'activities.final_hour AS final_hour',
                    'activities_type.text AS text',
                    'activities_type.color AS color',
                    'activities_type.icon AS icon',
                    'users.full_name AS full_name',
                    'business.name AS business_name')
            ->orderBy("final_date", "asc")
            ->orderBy("final_hour", "asc")
            ->get();      
            
             $view = view('agentes.getActivityPending', array(
                    "activitiesQuery"  => $activitiesQuery
                    ,"date"            => $date
                    ,"hour"            => $hour)
                     )->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
            
        public function viewSalesAgent(Request $request){
            
            $idBussines         = $request->input("idBussines");
            $idUsers            = $request->input("idUsers");
            
            $SalesByAgent  = DB::table('quotations as q')
                               ->join('quotations_detail as d','d.fkQuotations','=','q.pkQuotations')
                               ->select('pkQuotations'
                                        ,'q.folio'
                                        ,'q.register_day'
                                        ,'q.register_hour'
                                        ,'d.price'
                                        ,'d.number_places')
                               ->where('q.status','=',1)
                               ->where('fkUser','=',$idUsers)
                               ->where('fkBusiness','=',$idBussines)
                               ->where('d.isSelected','=',1)
                               ->get();
            
             $view = view('agentes.viewSalesAgent', array(
                    "SalesByAgent"  => $SalesByAgent
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));      
        }
        
        public function viewSalesLostAgent(Request $request){
            $idBussines         = $request->input("idBussines");
            $idUsers            = $request->input("idUsers");
            
            $SalesByAgent  = DB::table('quotations as q')
                               ->select('pkQuotations'
                                        ,'q.folio'
                                        ,'q.register_day'
                                        ,'q.register_hour')
                               ->where('q.status','=',1)
                               ->where('fkUser','=',$idUsers)
                               ->where('fkBusiness','=',$idBussines)
                               ->where('q.quotations_status','=',4)
                               ->get();
            
             $view = view('agentes.viewSalesLostAgent', array(
                    "SalesByAgent"  => $SalesByAgent
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
        }
        
        public function viewOpenQuotation(Request $request){
             $idBussines         = $request->input("idBussines");
             $idUsers            = $request->input("idUsers");
            
            $SalesByAgent = DB::table('quotations as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->join('users as u','u.pkUser','=','o.fkUser')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->select('o.pkQuotations'
                                    ,'o.name'
                                    ,'o.folio'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'o.final_date'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'o.quotations_status as quotation_status'
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                                    ,DB::raw("(CASE WHEN o.quotations_status = 1 THEN 'Creada' 
                                                    WHEN o.quotations_status = 2 THEN 'Abierta'
                                                    WHEN o.quotations_status = 3 THEN 'Rechazada'
                                                    WHEN o.quotations_status = 4 THEN 'Cancelada'
                                                    WHEN o.quotations_status = 5 THEN 'Cerrada'
                                                    ELSE 'N/A' END) as quotations_status"))
                               ->where('o.status','=',1)
                               ->where('o.fkUser','=',$idUsers)
                               ->where('o.fkBusiness','=',$idBussines)
                               ->where('o.quotations_status','=',2)
                               ->orwhere('o.quotations_status','=',1)
                            ->get();
        
            
             $view = view('agentes.viewOpenQuotation', array(
                    "SalesByAgent"  => $SalesByAgent
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function viewAprovedOportunity(Request $request){
             $idBussines         = $request->input("idBussines");
             $idUsers            = $request->input("idUsers");
             
              $oportunity = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->join('users as u','u.pkUser','=','o.fkUser')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->join('courses as cu','cu.pkCourses','=','o.number_courses')
                            ->leftjoin('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
                            ->select('o.pkOpportunities'
                                    ,'o.name'
                                    ,'o.folio'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'o.opportunities_status as opportunities_statu'
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                                    ,DB::raw("(CASE WHEN o.opportunities_status = 1 THEN 'Creada' 
                                                    WHEN o.opportunities_status = 2 THEN 'Abierta'
                                                    WHEN o.opportunities_status = 3 THEN 'Rechazada'
                                                    WHEN o.opportunities_status = 4 THEN 'Cancelada'
                                                    WHEN o.opportunities_status = 5 THEN 'Cotizada'
                                                    ELSE 'N/A' END) as opportunities_status")
                                    ,'o.number_employees'
                                    ,'cu.name as course'
                                    ,'o.number_places'
                                    ,'o.price_total'
                                    ,'o.necesites'
                                    ,'o.comment'
                                    ,'p.name as typePayment'
                                    ,'o.isBudget')
                               ->where('o.status','=',1)
                               ->where('o.fkUser','=',$idUsers)
                               ->where('o.fkBusiness','=',$idBussines)
                               ->where('o.opportunities_status','=',5)
                            ->get();
             
              $view = view('agentes.viewOportunityAproved', array(
                    "oportunity"  => $oportunity
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function viewOpenOportunity(Request $request){
             $idBussines         = $request->input("idBussines");
             $idUsers            = $request->input("idUsers");
             
              $oportunity = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->join('users as u','u.pkUser','=','o.fkUser')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->join('courses as cu','cu.pkCourses','=','o.number_courses')
                            ->leftjoin('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
                            ->select('o.pkOpportunities'
                                    ,'o.name'
                                    ,'o.folio'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'o.opportunities_status as opportunities_statu'
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                                    ,DB::raw("(CASE WHEN o.opportunities_status = 1 THEN 'Creada' 
                                                    WHEN o.opportunities_status = 2 THEN 'Abierta'
                                                    WHEN o.opportunities_status = 3 THEN 'Rechazada'
                                                    WHEN o.opportunities_status = 4 THEN 'Cancelada'
                                                    WHEN o.opportunities_status = 5 THEN 'Cotizada'
                                                    ELSE 'N/A' END) as opportunities_status")
                                    ,'o.number_employees'
                                    ,'cu.name as course'
                                    ,'o.number_places'
                                    ,'o.price_total'
                                    ,'o.necesites'
                                    ,'o.comment'
                                    ,'p.name as typePayment'
                                    ,'o.isBudget')
                               ->where('o.status','=',1)
                               ->where('o.fkUser','=',$idUsers)
                               ->where('o.fkBusiness','=',$idBussines)
                               ->where('o.opportunities_status','=',2)
                               ->orwhere('o.opportunities_status','=',1)
                            ->get();
             
              $view = view('agentes.viewOportunityOpen', array(
                    "oportunity"  => $oportunity
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function viewLossOportunity(Request $request){
             $idBussines         = $request->input("idBussines");
             $idUsers            = $request->input("idUsers");
             
              $oportunity = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->join('users as u','u.pkUser','=','o.fkUser')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->join('courses as cu','cu.pkCourses','=','o.number_courses')
                            ->leftjoin('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
                            ->select('o.pkOpportunities'
                                    ,'o.name'
                                    ,'o.folio'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'o.opportunities_status as opportunities_statu'
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                                    ,DB::raw("(CASE WHEN o.opportunities_status = 1 THEN 'Creada' 
                                                    WHEN o.opportunities_status = 2 THEN 'Abierta'
                                                    WHEN o.opportunities_status = 3 THEN 'Rechazada'
                                                    WHEN o.opportunities_status = 4 THEN 'Cancelada'
                                                    WHEN o.opportunities_status = 5 THEN 'Cotizada'
                                                    ELSE 'N/A' END) as opportunities_status")
                                    ,'o.number_employees'
                                    ,'cu.name as course'
                                    ,'o.number_places'
                                    ,'o.price_total'
                                    ,'o.necesites'
                                    ,'o.comment'
                                    ,'p.name as typePayment'
                                    ,'o.isBudget')
                               ->where('o.status','=',1)
                               ->where('o.fkUser','=',$idUsers)
                               ->where('o.fkBusiness','=',$idBussines)
                               ->where('o.opportunities_status','=',4)
                               ->orwhere('o.opportunities_status','=',3)
                            ->get();
             
              $view = view('agentes.viewOportunityLost', array(
                    "oportunity"  => $oportunity
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function saveMasiveCallsDB(Request $request){
           
            $fileBusiness       = $request->file('fileBusiness');
            $date               = date("Y-m-d");
            $flag               = "true";
            $message            = "true";
            $infoFileArray      = array();
            $user               = Session::get('pkUser');
            
            DB::beginTransaction();
              
            try { 
                if($fileBusiness != ''){ 
                    if(file_exists ($fileBusiness)){
                        $nameFile = $fileBusiness->getClientOriginalName();
                        if($nameFile!=''){
                            $ext            = $fileBusiness->extension();
                            if(($ext == 'txt') || ($ext == 'csv')){
                   
                                    $pathFile       = $fileBusiness->getRealPath();
                                    $fp             = fopen($pathFile, "r");
                                    $flagAux        = 0;
                                    while (($row = fgetcsv($fp)) !== false) {
                                        
                                        if($flagAux!=0){
                                            if(!empty($row[0])){
                                                $statusCall = 0;
                                                switch ($row[7]) {
                                                    case 'NO ANSWER':
                                                     $statusCall = 2;
                                                        break;
                                                     case 'ANSWERED':
                                                     $statusCall = 1;
                                                        break;
                                                     case 'FAILED':
                                                     $statusCall = 2;
                                                        break;
                                                   case 'BUSY':
                                                     $statusCall = 2;
                                                        break;
                                                    default:
                                                        break;
                                                }
                                                $dateAuxArray     = explode(" ",$row[0]);
                                                if(strpos($dateAuxArray[0], "/") !== FALSE){
                                                    $dateAuxArray2    = explode("/",$dateAuxArray[0]);
                                                    $newDateInsert    = $dateAuxArray2[2]."-".$dateAuxArray2[1]."-".$dateAuxArray2[0]." ".$dateAuxArray[1];
                                                }else{
                                                    $newDateInsert    = $row[0];
                                                }
                                                
                                                

                                                $callsQuery       = DB::table('calls')
                                                                      ->select('pkCalls')
                                                                      ->where('status','=',1)
                                                                      ->where('date','=',$newDateInsert)
                                                                      ->where('source','=',$row[1])
                                                                      ->first();

                                                if(empty($callsQuery)){
                                                    $insertBusiness              = new Calls;
                                                    $insertBusiness->date        = $newDateInsert;
                                                    $insertBusiness->source      = $row[1];
                                                    $insertBusiness->destination = $row[3];
                                                    $insertBusiness->srcChannel  = $row[4];
                                                    $insertBusiness->dstChannel  = $row[6];
                                                    $insertBusiness->statusCall  = $row[7];
                                                    $insertBusiness->duration    = $row[8];
                                                    $insertBusiness->status_type = $statusCall;
                                                    $insertBusiness->status      = 1;

                                                    if($insertBusiness->save()){

                                                    }else{
                                                        $flag = "false";
                                                        $message = "Error al cargar Llamadas \n"; 
                                                    } 
                                                }
                                            }
                                        }
                                        $flagAux++;
                                    }
                                    fclose($fp); 
                                    unlink($pathFile);
 
                            }else{
                                $flag           = "false";
                                $message    = "Error en formato de archivo \n";
                            }
                        }else{
                            $flag           = "false";
                            $message    = "Error en nombre de archivo \n";
                        }
                    }else{
                        $flag           = "false";
                        $message    = "Error en la carga del archivo \n";
                    }
                }else{
                    $flag           = "false";
                    $message    = "Error no existe el archivo \n";
                }
                
                
                if($flag == "true"){
                    DB::commit();
                    return $message;
                }else{
                    DB::rollback(); 
                    return $message;
                }
            } catch (\Exception $e) {
                DB::rollback(); 
                //return "Error del sistema, favor de contactar al desarrollador";
                return $e->getMessage();
           }    
        }

        public function deleteCalls(Request $request){

          $pkWorkinPlan             = $request->input("pkWorkinPlan");

          $workPlan = DB::table('workplan as w')
          ->join('users as u','u.pkUser','=','w.fkUser')
          ->join('currency as c','c.CurrencyISO','=','w.typeCurrency')
          ->select('u.full_name as agent'
                  ,'w.pkWorkplan'
                  ,'w.fkUser'
                  ,'w.qtyCallsHour'
                  ,'w.qtyHourMonth'
                  ,'w.callsFaild'
                  ,'w.callsLinked'
                  ,'w.penalty'
                  ,'w.montBase'
                  ,'w.typeChange'
                  ,'w.typeCurrency'
                  ,'c.CurrencyName as moneda'
                  ,DB::raw("DATE_FORMAT(dateMonth, '%b/%Y') as date")
                  ,DB::raw("DATE_FORMAT(dateMonth, '%m') as month")
                  ,DB::raw("DATE_FORMAT(dateMonth, '%Y') as year")
                  ,'w.hour')
          ->where('w.status','=',1)
          ->where('w.pkWorkplan','=',$pkWorkinPlan)
          ->first();

                $month = $workPlan->month;
                $year  = $workPlan->year;
                $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
                
                $monthInitial = $year.'-'.$month.'-01';
                $monthFinish  = $year.'-'.$month.'-'.$numDaysMonth;

              $deleteCalls   = DB::table("calls")
                                  ->whereDate('date','>=',$monthInitial)
                                  ->whereDate('date','<=',$monthFinish)
                                  ->update(array("status" => 0));

              if($deleteCalls >= 1){
               return "true";
              }else{
                return "false";
              }

        }
       
	
}
