<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\WorkPlan;
use App\Models\WorkingDays;
use App\Models\FestiveDays;
use App\Models\PermitionDays;
use App\Models\ConfigPrice;
use App\Models\DiscountPlaces;
use Illuminate\Http\Request;

class WorkPlanController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
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
            if($totalSale > $comitionsearch->pkComition){
              $comition  = ($totalSale * $comitionsearch->comition_higher ) / 100;
            }
            if($totalSale >= $comitionsearch->higher_or_equal_to || $totalSale <= $comitionsearch->less_or_equal_to){
                $comition = ($totalSale * $comitionsearch->comition_higher_less ) / 100;
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
                       ->where('q.fkUser','=',$infoUser->fkUser)
                       ->where('q.quotations_status','=',5)
                       ->whereDate('final_date','>=',$monthInitial)
                       ->whereDate('final_date','<=',$monthFinish)
                       ->first();
                
                if(!empty($sales->price))
                $totalSaleGroup = $totalSaleGroup +  $sales->price;
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
                   $totalTecho      = ($montReal * $bonds["techo"]["montRep"] ) / 100; 
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
        //llamadas por dia
        //obtener dias de tiempo completo  del mes
        //obtener dias de medio tiempo del mes
        //retornar horas en total del mes
        private function getCallsPerMonth($month, $year, $days) {

        //se obtine los dias que trae el mes
        $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
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
        $monthFinish  = strtotime($year.'-'.$month.'-'.$numDaysMonth);
        

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
            switch ($itemDay->idDay) {
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

        // return $days;
      
        return $daysWeek;
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
        $monthFinish  =  strtotime(date("d-m-Y",strtotime($year.'-'.$month.'-'.$numDaysMonth."+ 1 days"))); 
 
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
            $monthToday = date("m");
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
             if($monthToday == $month){
             return $CallPerMont;
             
             }else{
             return "N/A";    
             }
             
            
        }

        public function createWorkPlan()
        {
            $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->orderby('full_name','asc')
                       ->get();
            
            $currency = DB::table('currency')
                          ->select('CurrencyName'
                                  ,'Money'
                                  ,'Symbol'
                                  ,'CurrencyISO')
                          ->orderby('CurrencyName','asc')
                          ->get();
           
            return view('workPlan.createWorkPlan')->with('agent',$agent)
                                                  ->with('currency',$currency);
        }
        
	public function addWorkPlandDB(Request $request){
            
        $slcAgent           = $request->input("slcAgent");
        $callsPerHour       = $request->input("callsPerHour");
        $callsLinked        = $request->input("callsLinked");
        $callsFaild         = $request->input("callsFaild");
        $penalty            = $request->input("penalty");
        $datePlan           = str_replace('"', '',$request->input("datePlan"));
        $montBase           = str_replace("$", "", str_replace(",", "", $request->input("montBase")));
        $typeChange         = str_replace("$", "", str_replace(",", "", $request->input("typeChange")));
        $slctypeCurrency    = $request->input("slctypeCurrency");
        $arrayDays          = json_decode($request->input('arrayDays'));
        $days               = json_decode($request->input('days'));
        $fech               = $datePlan."-01";


        $startDateUTC       = date("Y-m-d H:i:s");
        $DateTime           = explode(" ", $startDateUTC);
        $flag               = "true";
        $message            = "true";

        $monthActual        = explode("-", $datePlan);
        $monthInitial       = $monthActual[0] . '-' . $monthActual[1] . '-01';
        $monthFinish        = $monthActual[0] . '-' . $monthActual[1] . '-31';

        $searchPlan         = DB::table('workplan')
                                    ->select('pkWorkplan'
                                            , 'fkUser'
                                            , 'date')
                                    ->whereDate('dateMonth', '>=', $monthInitial)
                                    ->whereDate('dateMonth', '<=', $monthFinish)
                                    ->where('fkUser', '=', $slcAgent)
                                    ->where('status','=',1)
                                    ->get();


        if (sizeof($searchPlan) <= 0) {
            DB::beginTransaction();

            try {

                $arraydayPerMonth = $this->getCallsPerMonth($monthActual[1], $monthActual[0], $days);
                $hourPerMont = 0;

                foreach ($arraydayPerMonth as $itemDays) {
                    if ($itemDays["type"] > 0) {
                        if ($itemDays["type"] == 1) {
                            $hourPerMont = $hourPerMont + ($itemDays["num"] * 8);
                        } else {
                            $hourPerMont = $hourPerMont + ($itemDays["num"] * 4);
                        }
                    }
                }
                $CallPerMont = $hourPerMont * $callsPerHour;
                

                $WorkPlan = new WorkPlan;
                $WorkPlan->fkUser = $slcAgent;
                $WorkPlan->qtyCallsHour = $callsPerHour;
                $WorkPlan->qtyHourMonth = $CallPerMont;
                $WorkPlan->callsFaild = $callsFaild;
                $WorkPlan->callsLinked = $callsLinked;
                $WorkPlan->penalty = $penalty;
                $WorkPlan->montBase = $montBase;
                $WorkPlan->typeChange = $typeChange;
                $WorkPlan->typeCurrency = $slctypeCurrency;
                $WorkPlan->date = $DateTime[0];
                $WorkPlan->hour = $DateTime[1];
                $WorkPlan->dateMonth = $fech;
                $WorkPlan->status = 1;

                if ($WorkPlan->save()) {

                    // return $arrayContacts;
                    foreach ($days as $aux => $item) {

                        if (!empty($item)) {

                            $WorkingDays = new WorkingDays;
                            $WorkingDays->fkWorkinPlan = $WorkPlan->pkWorkplan;
                            $WorkingDays->day = $item->idDay;
                            $WorkingDays->type = $item->type;
                            $WorkingDays->status = 1;

                            if ($WorkingDays->save()) {
                                
                            } else {
                                $flag = "false";
                                $message .= "Error al crear dias \n";
                            }
                        }
                    }

                 /*   foreach ($arrayDays as $item) {
                        if (!empty($item)) {

                            $WorkingDaysFestive = new FestiveDays;
                            $WorkingDaysFestive->fkWorkinPlan = $WorkPlan->pkWorkplan;
                            $WorkingDaysFestive->day = $item->vigencia;
                            $WorkingDaysFestive->status = 1;

                            if ($WorkingDaysFestive->save()) {
                                
                            } else {
                                $flag = "false";
                                $message .= "Error al crear dias \n";
                            }
                        }
                    }*/
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
                        , "error" => "El usuario selecionado ya tiene configurado el plan de trabajo este mes"));
        }
    }
      
        public function viewWorkPlan(Request $request){
            
            $arrayWorkPlan = array();
            $hoursPermition = 0;
            
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
                          ->get();
            
                
                
            
            foreach($workPlan as $item){
                $month = $item->month;
                $year = $item->year;
                
                $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $item->month, $item->year); 
                
                $monthInitial = $year.'-'.$month.'-01';
                $monthFinish  = $year.'-'.$month.'-'.$numDaysMonth;

                $PenalitationCourse = "";
                
               $days = DB::table('working_days')
                         ->select('day'
                                 ,'type')
                         ->where('fkWorkinPlan','=',$item->pkWorkplan)
                         ->where('status','=',1)
                         ->get();
               
               $daysFestive = DB::table('festive_days')
                         ->where('fkWorkinPlan','=',$item->pkWorkplan)
                         ->where('status','=',1)
                         ->get();
               
               $callsInSystem = DB::table('activities')
                                   ->where('fkActivities_type','=',1)
                                   ->where('status','=',1)
                                   ->where('execution_date','!=',"")
                                   ->where('fkUser','=',$item->fkUser)
                                   ->whereDate('execution_date','>=',$monthInitial)
                                   ->whereDate('execution_date','<=',$monthFinish)
                                   ->get();
               
               $permition = DB::table('pemition_day')
                               ->select(DB::raw("SUM(hours) as hours"))
                               ->where('fkWorkinPlan','=',$item->pkWorkplan)
                               ->where('status','=',1)
                               ->first();
               
               //dd();
              $calltomonth = $this->getCallsPerMonthView($item->month, $item->year, $days, $item->qtyCallsHour,$permition->hours,$daysFestive); 
              $callstoday  = $this->getCallsPerday($item->month, $item->year,$days, $item->qtyCallsHour, $calltomonth,$callsInSystem);
             

              $pkWorkin = $item->pkWorkplan;
              //DIAS TRABAJADOS
            $days = DB::table('working_days')
                      ->select('day'
                              ,'type')
                      ->where('fkWorkinPlan','=',$item->pkWorkplan)
                      ->where('status','=',1)
                      ->get();
            //DIAS FESTIVOS
            $daysFestive = DB::table('festive_days')
                      ->where('fkWorkinPlan','=',$item->pkWorkplan)
                      ->where('status','=',1)
                      ->get();
            //LLAMADAS EN SYSTEMA
            $callsInSystem = DB::table('activities')
                                ->where('fkActivities_type','=',1)
                                ->where('status','=',1)
                                ->where('execution_date','!=',"")
                                ->where('fkUser','=',$item->fkUser)
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
                                ->where('a.fkUser','=',$item->fkUser)
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
                                ->where('a.fkUser','=',$item->fkUser)
                                ->whereDate('execution_date','>=',$monthInitial)
                                ->whereDate('execution_date','<=',$monthFinish)
                                ->orderby('a.pkActivities')
                                ->groupby('a.pkActivities')
                                ->get();
            
            //PERMISOS
            $permition = DB::table('pemition_day')
                            ->select(DB::raw("SUM(hours) as hours"))
                            ->where('fkWorkinPlan','=',$item->pkWorkplan)
                            ->where('status','=',1)
                            ->first();
            
            //
            $usersSource = DB::table('users')
                             ->select('phone_extension')
                             ->where('status','=',1)
                             ->where('pkUser','=',$item->fkUser)
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
               
              $bonds       = $this->bonds($item->month, $item->year,$item->fkUser);
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
               $porcentCallRegiter = round((100 * $callsRegister ) / $calltomonth,1);
               
               $mountBaseAux = $item->montBase;
              
                if($porcentCallRegiter < 100){
                    $item->montBase = ($porcentCallRegiter * $item->montBase) / 100;
                }
               
               $callLinkedTotal = round(($calltomonth * $item->callsLinked) / 100);
               $callLinkedFaild = round(($calltomonth * $item->callsFaild) / 100);
               
               $callLinkedTotalRegister = round(($calltomonth * $callsRegisterLiked) / 100);
               $callLinkedFaildRegister = round(($calltomonth * $callsRegisterFaild) / 100);
               
             
                   if( ($item->callsFaild < $callLinkedFaildActualRegister) || $callsRegister <= 0){
                    $monthBaseReal = $item->montBase - ( ($item->montBase * $item->penalty) / 100);
                  }else{
                    $monthBaseReal = $item->montBase;
                  }

            $salary       = $this->viewSalary($item->month, $item->year,$item->fkUser,$mountBaseAux,$monthBaseReal,$bonds);
            $PenalitationCourse  = $this->coursePenalitation($item->month, $item->year,$item->fkUser, $monthBaseReal);


              $arrayWorkPlan[$item->pkWorkplan] = array("pkWorkplan"         => $item->pkWorkplan
                                                       ,"date"               => $item->date
                                                       ,"month"              => $item->month
                                                       ,"year"               => $item->year
                                                       ,"PenalitationCourse" => $PenalitationCourse
                                                       ,"salary"             => $salary
                                                       ,"agent"              => $item->agent
                                                       ,"qtyCallsHour"       => $item->qtyCallsHour 
                                                       ,"qtyHourMonth"       => $calltomonth
                                                       ,"qtyCallsToday"      => $callstoday
                                                       ,"callsLinked"        => $item->callsLinked
                                                       ,"callsFaild"         => $item->callsFaild
                                                       ,"penalty"            => $item->penalty
                                                       ,"montBase"           => $item->montBase
                                                       ,"typeChange"         => $item->typeChange
                                                       ,"fkUser"             => $item->fkUser
                                                       ,"moneda"             => $item->moneda);
            }
            
         
             return view('workPlan.viewWorkPlan')->with('workPlan',$arrayWorkPlan);
        }
        
        public function viewWorkingPlan(Request $request){
            
            $pkWorkingPlan  = $request->input("idWorkinPlan");
            
            $daysWorking  = DB::table('working_days')
                          ->select('pkWorking_day'
                                  , DB::raw("(CASE   WHEN day = 1 THEN 'Lunes' 
                                                     WHEN day = 2 THEN 'Martes'
                                                     WHEN day = 3 THEN 'Miércoles'
                                                     WHEN day = 4 THEN 'Jueves'
                                                     WHEN day = 5 THEN 'Viernes'
                                                     WHEN day = 6 THEN 'Sábado'
                                                     WHEN day = 7 THEN 'Domingo'
                                                     ELSE 'N/A' END) as day")

                                  ,'type', 'day as dayAux')
                          ->where('status','=',1)
                          ->where('fkWorkinPlan','=',$pkWorkingPlan)
                          ->orderBy('dayAux','ASC')
                          ->get();
           
            
               $view = view('workPlan.getDaysWorking', array(
                    "daysWorking" => $daysWorking,
                    "pkWorkingPlan" => $pkWorkingPlan
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));         
        }
        
        public function deleteWorkinPlan(Request $request){
            
            $pkWorkinPlan             = $request->input("pkWorkinPlan");

            $workinPlanUpdate    = DB::table("workplan")
                                          ->where('pkWorkplan','=',$pkWorkinPlan)
                                          ->update(array("status" => 0));
            
            if($workinPlanUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function updateWorkinPlan(Request $request){
            
           $pkWorkingPlan  = $request->input("idWorkinPlan");
            
            $daysWorking  = DB::table('workplan')
                          ->select('pkWorkplan'
                                  ,'fkUser'
                                  ,'qtyCallsHour'
                                  ,'qtyHourMonth'
                                  ,'callsLinked'
                                  ,'callsFaild'
                                  ,'penalty'
                                  ,'montBase'
                                  ,'typeChange'
                                  ,'typeCurrency')
                          ->where('status','=',1)
                          ->where('pkWorkplan','=',$pkWorkingPlan)
                          ->first();
           
            $agent = DB::table('users')
                       ->select('pkUser'
                               ,'full_name')
                       ->where('status','=',1)
                       ->orderby('full_name','asc')
                       ->get();
            
            $currency = DB::table('currency')
                          ->select('CurrencyName'
                                  ,'Money'
                                  ,'Symbol'
                                  ,'CurrencyISO')
                          ->orderby('CurrencyName','asc')
                          ->get();
            
               $view = view('workPlan.updateWorkPlan', array(
                    "daysWorking" => $daysWorking,
                    "agent"       => $agent,
                    "currency"       => $currency
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
        }
        
        public function updateWorkinPlanDB(Request $request){
            
           $pkWorkinPlan             = $request->input("idWorkin");
           
            $slcAgent           = $request->input("slcAgent");
            $callsPerHour       = $request->input("callsPerHour");
            $hourPerMont        = $request->input("hourPerMont");
            $callsLinked        = $request->input("callsLinked");
            $callsFaild         = $request->input("callsFaild");
            $penalty            = $request->input("penalty");
            $montBase           = str_replace("$","", str_replace(",","",$request->input("montBase")));
            $typeChange         = str_replace("$","", str_replace(",","",$request->input("typeChange")));
            $slctypeCurrency    = $request->input("slctypeCurrency");
                    
            $workinPlanUpdate    = DB::table("workplan")
                                          ->where('pkWorkplan','=',$pkWorkinPlan)
                                          ->update(array("fkUser" => $slcAgent
                                                        ,"qtyCallsHour" => $callsPerHour
                                                        ,"callsLinked" => $callsLinked
                                                        ,"callsFaild" => $callsFaild
                                                        ,"penalty" => $penalty
                                                        ,"montBase" => $montBase
                                                        ,"typeChange" => $typeChange
                                                        ,"typeCurrency" => $slctypeCurrency
                                                   ));
            
            if($workinPlanUpdate >= 1){
                return "true";
            }else{
                return "false";
            } 
        }
        
        public function viewFestiveDays(Request $request){
           $pkWorkingPlan  = $request->input("idWorkinPlan");
            
            $daysWorking  = DB::table('festive_days')
                          ->select('pkFestive_Days'
                                   ,DB::raw("DATE_FORMAT(day, '%d/%m/%Y') as day"))
                          ->where('status','=',1)
                          ->where('fkWorkinPlan','=',$pkWorkingPlan)
                          ->get();
           
            
               $view = view('workPlan.getFestiveDays', array(
                    "daysWorking" => $daysWorking,
                    "pkWorkingPlan" => $pkWorkingPlan
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function deleteDaysWorkin(Request $request){
              
            $pkWorkinPlan             = $request->input("pkWorkinPlan");

            $workinPlanUpdate    = DB::table("working_days")
                                          ->where('pkWorking_day','=',$pkWorkinPlan)
                                          ->update(array("status" => 0));
            
            if($workinPlanUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function addDaysWorkin(Request $request){
             $pkWorkingPlan  = $request->input("idWorkinPlan");
             
             $arrayDaysFal = array("1"=>"Lunes"
                                  ,"2"=>"Martes"
                                  ,"3"=>"Miercoles"
                                  ,"4"=>"Jueves"
                                  ,"5"=>"Viernes"
                                  ,"6"=>"Sabado"
                                  ,"7"=>"Domingo");
            
         $daysWorking  = DB::table('working_days')
                          ->select('pkWorking_day'
                                   ,'day'
                                  ,'type')
                          ->where('status','=',1)
                          ->where('fkWorkinPlan','=',$pkWorkingPlan)
                          ->get();
         
              foreach($daysWorking as $info){
                   unset( $arrayDaysFal[$info->day]);       
              }
           
            
               $view = view('workPlan.addDaysWorkin', array(
                    "daysWorking"   => $daysWorking,
                    "pkWorkingPlan" => $pkWorkingPlan,
                    "arrayDaysFal"  => $arrayDaysFal
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function addDaysWorkinDB(Request $request){
        
        $flag = "true";
        $idWorkinPlan = $request->input("idDays");
        $days = json_decode($request->input('days'));


        DB::beginTransaction();

        try {


            // return $arrayContacts;
            foreach ($days as $aux => $item) {

                if (!empty($item)) {

                    $WorkingDays = new WorkingDays;
                    $WorkingDays->fkWorkinPlan = $idWorkinPlan;
                    $WorkingDays->day = $item->idDay;
                    $WorkingDays->type = $item->type;
                    $WorkingDays->status = 1;

                    if ($WorkingDays->save()) {
                        
                    } else {
                        $flag = "false";
                        $message .= "Error al crear dias \n";
                    }
                }
            }
            
         

            if ($flag == "true") {
                
                 $daysWorking  = DB::table('working_days')
                                  ->select('pkWorking_day'
                                  , DB::raw("(CASE   WHEN day = 1 THEN 'Lunes' 
                                                     WHEN day = 2 THEN 'Martes'
                                                     WHEN day = 3 THEN 'Miércoles'
                                                     WHEN day = 4 THEN 'Jueves'
                                                     WHEN day = 5 THEN 'Viernes'
                                                     WHEN day = 6 THEN 'Sábado'
                                                     WHEN day = 7 THEN 'Domingo'
                                                     ELSE 'N/A' END) as day")

                                  ,'type')
                          ->where('status','=',1)
                          ->where('fkWorkinPlan','=',$idWorkinPlan)
                          ->get();
           
            
                $view = view('workPlan.getDaysWorking', array(
                    "daysWorking" => $daysWorking,
                    "pkWorkingPlan" => $idWorkinPlan
                        ))->render();
               
                DB::commit();
                return \Response::json(array(
                             "valid"       => "true",
                             "view"        => $view
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
    
        public function deleteDaysFestive(Request $request){
            
           $pkWorkinPlan             = $request->input("pkWorkinPlan");

            $workinPlanUpdate    = DB::table("festive_days")
                                          ->where('pkFestive_Days','=',$pkWorkinPlan)
                                          ->update(array("status" => 0));
            
            if($workinPlanUpdate >= 1){
                return "true";
            }else{
                return "false";
            }   
        }
        
        public function addDaysFestive(Request $request){
               $pkWorkingPlan  = $request->input("idWorkinPlan");
             
               $view = view('workPlan.addFestiveDays', array(
                    "pkWorkingPlan" => $pkWorkingPlan
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function addDaysFestiveDB(Request $request){
        $flag = "true";
        $idWorkinPlan = $request->input("idDays");
        $arrayDays    = json_decode($request->input('arrayDays'));

     
        DB::beginTransaction();

        try {


            // return $arrayContacts;
            foreach ($arrayDays as $item) {
                if (!empty($item)) {

                    $WorkingDays = new FestiveDays;
                    $WorkingDays->fkWorkinPlan = $idWorkinPlan;
                    $WorkingDays->day = $item->vigencia;
                    $WorkingDays->status = 1;

                    if ($WorkingDays->save()) {
                        
                    } else {
                        $flag = "false";
                        $message .= "Error al crear dias \n";
                    }
                }
            }
            
         

            if ($flag == "true") {
                
                  $daysWorking  = DB::table('festive_days')
                          ->select('pkFestive_Days'
                                   ,DB::raw("DATE_FORMAT(day, '%d/%m/%Y') as day"))
                          ->where('status','=',1)
                          ->where('fkWorkinPlan','=',$idWorkinPlan)
                          ->get();
           
            
               $view = view('workPlan.getFestiveDays', array(
                    "daysWorking" => $daysWorking,
                    "pkWorkingPlan" => $idWorkinPlan
                        ))->render();
               
                DB::commit();
                return \Response::json(array(
                             "valid"       => "true",
                             "view"        => $view
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
        
        public function addPermission(Request $request){
               $pkWorkingPlan  = $request->input("idWorkinPlan");
             
               $view = view('workPlan.addPermition', array(
                    "pkWorkingPlan" => $pkWorkingPlan
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function viewPermission(Request $request){
              $pkWorkingPlan  = $request->input("idWorkinPlan");
              
              $permition = DB::table('pemition_day')
                             ->select('pkPermitionDay'
                                     ,DB::raw("DATE_FORMAT(day, '%d/%m/%Y') as day")
                                     ,'hours'
                                     ,'comment')
                             ->where('status','=',1)
                             ->where('fkWorkinPlan','=',$pkWorkingPlan)
                             ->orderby('day','desc')
                             ->orderby('hours','desc')
                             ->get();
                      
             
               $view = view('workPlan.getPermitionDays', array(
                    "pkWorkingPlan" => $pkWorkingPlan
                   ,"permition"     => $permition
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));      
        }
        
        public function addPermissionDB(Request $request){
            
          $flag = "true";
          $idWorkinPlan = $request->input("idWorkinPlan");
          $vigencia     = $request->input("vigencia");
          $qtyhours     = $request->input("qtyhours");
          $comment      = $request->input("comment");
       

     
        DB::beginTransaction();

        try {

                    $WorkingDays                = new PermitionDays;
                    $WorkingDays->fkWorkinPlan  = $idWorkinPlan;
                    $WorkingDays->day           = $vigencia;
                    $WorkingDays->hours         = $qtyhours;
                    $WorkingDays->comment       = $comment;
                    $WorkingDays->status        = 1;

                    if ($WorkingDays->save()) {
                        
                    } else {
                        $flag = "false";
                        $message .= "Error al crear permiso \n";
                    }
  

            if ($flag == "true") {
                
                  $permition = DB::table('pemition_day')
                             ->select('pkPermitionDay'
                                     ,DB::raw("DATE_FORMAT(day, '%d/%m/%Y') as day")
                                     ,'hours'
                                     ,'comment')
                             ->where('status','=',1)
                             ->where('fkWorkinPlan','=',$idWorkinPlan)
                             ->orderby('day','desc')
                             ->orderby('hours','desc')
                             ->get();
                      
             
               $view = view('workPlan.getPermitionDays', array(
                    "pkWorkingPlan" => $idWorkinPlan
                   ,"permition"     => $permition
                        ))->render();
               
                DB::commit();
                return \Response::json(array(
                             "valid"       => "true",
                             "view"        => $view
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
        
        public function deletePermission(Request $request){
            
              $pkWorkinPlan             = $request->input("pkWorkinPlan");
              $idWorkinPlan             = $request->input("idWorkinPlan");
              
            
            $workinPlanUpdate    = DB::table("pemition_day")
                                          ->where('pkPermitionDay','=',$pkWorkinPlan)
                                          ->update(array("status" => 0));
            
            if($workinPlanUpdate >= 1){
                  
                  $permition = DB::table('pemition_day')
                             ->select('pkPermitionDay'
                                     ,DB::raw("DATE_FORMAT(day, '%d/%m/%Y') as day")
                                     ,'hours'
                                     ,'comment')
                             ->where('status','=',1)
                             ->where('fkWorkinPlan','=',$idWorkinPlan)
                             ->orderby('day','desc')
                             ->orderby('hours','desc')
                             ->get();
                      
             
               $view = view('workPlan.getPermitionDays', array(
                    "pkWorkingPlan" => $idWorkinPlan
                   ,"permition"     => $permition
                        ))->render();

                        return \Response::json(array(
                             "valid"       => "true",
                             "view"        => $view
                ));
            }else{
                return \Response::json(array(
                    "valid"       => "false",
                    "view"        => $view
       ));
            }    
        }
        
        public function configPrice(){
            
            $price = DB::table('price_places')
                       ->select('pkPrice_place'
                               ,'price'
                               ,'iva')
                       ->where('status','=',1)
                       ->first();
            
            return view('catalogos.configPrice')->with('price',$price);
        }
        
        public function configPriceDB(Request $request){
            
            $pricePlace     = $request->input("pricePlace");
            $priceIva       = $request->input("priceIva");
            
            $configPrice    = DB::table('price_places')
                                ->where('status','=',1)
                                ->first();
            
            if(empty($configPrice)){
            $insertActivitySubtype                      = new ConfigPrice;
            $insertActivitySubtype->price               = $pricePlace;
            $insertActivitySubtype->iva                 = $priceIva;
            $insertActivitySubtype->status              = 1;
            
            if($insertActivitySubtype->save()){
                return "true";
            }else{
                return "false";
            }
          }else{
           $update = DB::table("price_places")
               ->where("pkPrice_place", "=" ,$configPrice->pkPrice_place)
               ->update(['price' => $pricePlace
                        ,'iva'   => $priceIva]);   
           
             if($update >= 1){
                return "true";
                }else{
                return "false";
              }
          }
        }
        
        public function cargarDescuentos(){

            $promotion = DB::table('discount_places')
                            ->select('pkDiscount_places'
                                   ,'cantPlaces'
                                   ,'discount')
                            ->where('status','=',1)
                            ->get();
                            
           return view('catalogos.addDescPlaces')->with('promotion',$promotion);  
        }
        
        public function deleteProMotion(Request $request){

            $pkPromotion            = $request->input("pkPromotion");

            $promotionUpdate    = DB::table("discount_places")
                                          ->where('pkDiscount_places','=',$pkPromotion)
                                          ->update(array("status" => 0));
            
            if($promotionUpdate >= 1){
                return "true";
            }else{
                return "false";
            }

        }

        public function viewUpdatePromotion(Request $request){

            $pkPromotion  = $request->input("pkPromotion");
            
            $PromotionsWorking  = DB::table('discount_places')
                                     ->select('pkDiscount_places'
                                             ,'cantPlaces'
                                             ,'discount')
                                    ->where('status','=',1)
                                    ->where('pkDiscount_places','=',$pkPromotion)
                                    ->first();

               $view = view('catalogos.editDiscountByPlaces', array(
                    "PromotionsWorking" => $PromotionsWorking
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
        }

        public function updatePromotion(Request $request){

            $pkPromotion     = $request->input("pkPromotion");
            $places          = $request->input("places");
            $discount        = $request->input("discount");


            $promotionUpdate    = DB::table("discount_places")
                                          ->where('pkDiscount_places','=',$pkPromotion)
                                          ->update(array("cantPlaces" => $places
                                                        ,"discount"   => $discount));
            
            if($promotionUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }

        public function saveMasiveDescDB(Request $request){
            $fileBusiness       = $request->file('fileBusiness');
            $date               = date("Y-m-d");
            $flag               = "true";
            $message            = "true";
            $infoFileArray      = array();
            
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
                                                
                                                                  $discountPlaces              = new DiscountPlaces;
                                                                  $discountPlaces->cantPlaces  = $row[0];
                                                                  $discountPlaces->discount    = $row[1];
                                                                  $discountPlaces->date        = $date;
                                                                  $discountPlaces->status      = 1;
                                                                  if($discountPlaces->save()){

                                                                  }else{
                                                                      $flag = "false";
                                                                      $message = "Error al crear empresas \n"; 
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

}

