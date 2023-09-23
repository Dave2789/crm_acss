<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Contacts_by_business;
use App\Models\Opportunities;
use App\Models\Quotation_detail;
use App\Models\Quotation;
use App\Models\Opportunity_by_Courses;
use App\Models\Quotation_by_Courses;
use App\Models\Activities;
use App\Models\Status_by_bussines;
use Illuminate\Http\Request;
use App\Permissions\UserPermits;
use App\Helpers\helper;

class OpportunityController extends Controller {

    private $UserPermits;
    
	public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->UserPermits = new UserPermits();
            $this->helper = new helper();
            //se agregan los permisos del usuario
        }
        
        public function viewOpportunity()
        {
            
            $bussines  = DB::table('business')
                           ->select('name'
                                   ,'pkBusiness')
                           ->where('status','=',1)
                           ->get();
            
            $courses   = DB::table('courses')
                           ->select('pkCourses'
                                   ,'name')
                           ->where('status','=',1)
                           ->get();
            
            $agent     = DB::table('users')
                           ->select('full_name'
                                   ,'pkUser')
                           ->where('status','=',1)
                           ->where('fkUser_type','!=',1)
                           ->get();
            
            $level      = DB::table('level_interest')
                             ->select('pkLevel_interest'
                                     ,'text')
                             ->where('status','=',1)
                             ->get();
            
            $payment    = DB::table('payment_methods')
                             ->select('pkPayment_methods'
                                     ,'name')
                             ->where('status','=',1)
                             ->get();
            
            

            return view('oportunidades.crearOportunidades', ["bussines" => $bussines
                                                ,"courses" => $courses
                                                ,"agent"   => $agent
                                                ,"level"   => $level
                                                ,"payment" => $payment]);
        }
        
        public function addbusinessContactDB(Request $request){
            
            $slcBussines = $request->input("slcBussines");
            $nameContact = $request->input("nameContact");
            $cargo       = $request->input("cargo");
            $email       = $request->input("email");
            $phone       = $request->input("phone");
            $extension   = $request->input("extension");
            $cel         = $request->input("cel");
           
            
            $insertContacts  = new Contacts_by_business;
            $insertContacts->fkBusiness    = $slcBussines;
            $insertContacts->name          = $nameContact;
            $insertContacts->mail          = $email;
            $insertContacts->area          = $cargo;
            $insertContacts->phone         = $phone;
            $insertContacts->mobile_phone  = $cel;
            $insertContacts->status        = 1;
            
             if($insertContacts->save()){
              $contact    = DB::table('contacts_by_business')
                                 ->select('pkContact_by_business'
                                  ,'name')
                                 ->where('status','=',1)
                                 ->where('fkBusiness','=',$slcBussines)
                                 ->get();
            
               $view = view('oportunidades.getContact', array(
                    "contact" => $contact,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));
            }else{
               return \Response::json(array(
                                  "valid"       => "false"
                                ));
            }
            
             
        }
        
        public function getContactBussines(Request $request){
            $slcBussines  = $request->input("slcBussines");
         
            $contact    = DB::table('contacts_by_business')
                                 ->select('pkContact_by_business'
                                  ,'name')
                                 ->where('status','=',1)
                                 ->where('fkBusiness','=',$slcBussines)
                                 ->get();
            
               $view = view('oportunidades.getContact', array(
                    "contact" => $contact,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function addOportunityDB(Request $request) 
        {
            
            $date         = date("Y-m-d");
            $startDateUTC = date("Y-m-d H:i:s");
            $flag         = "true";
        
            $DateTime = explode(" ", $startDateUTC);
            $slcBussines = $request->input("slcBussines");
            $slcContact  = $request->input("slcContact");
           // $qtyEmployee = $request->input("qtyEmployee");
            $slcCourse   = json_decode($request->input("slcCourse"));
            //$qtyPlace    = $request->input("qtyPlace");
            $slcAgent    = $request->input("slcAgent");
           // $mont        = str_replace("$","", str_replace(",","",$request->input("mont")));
            $presu       = $request->input("customradio1");
            $necesites   = $request->input("necesites");
            $comments    = $request->input("comments");
            $level       = $request->input("level");
            $slcPayment  = $request->input("slcPayment");
            $campaning  = $request->input("campaning");
            $comentPresupuesto  = $request->input("comentPresupuesto");
            $requicapa  = $request->input("requicapa");
            $totalqty   = $request->input("totalqty");
        
 
            $name  = $request->input("name");
            $numCourses = count($slcCourse);
            $agentPro   = 0;
       
            $property   = DB::table('business')
                            ->select('pkBusiness'
                                    ,'fkUser')
                            ->where('pkBusiness','=',$slcBussines)
                            ->first();
            
             if(!empty($property->pkBusiness)){
               $agentPro   = $property->fkUser;
            }
            
             $folio = 1;
            
            $lastId = DB::table('opportunities')
                        ->select('pkOpportunities')
                        ->orderby('pkOpportunities','desc')
                        ->first();
            
            
        if(!empty($lastId->pkOpportunities)){
            $folio = $lastId->pkOpportunities+1;
        }
        
          DB::beginTransaction();
          try{
              
            $totalPrice = 0;
            $totalQty   = 0;
        
            $Opportunities                        = new Opportunities;
            $Opportunities->folio                 = $folio;
            $Opportunities->color                 = "#0000A0";
            $Opportunities->icon                  = "ti-folder";
            $Opportunities->fkBusiness            = $slcBussines;
            $Opportunities->fkUser                = $agentPro;
            $Opportunities->asing                 = $slcAgent;
            $Opportunities->fkContact_by_business = $slcContact;
            $Opportunities->fkLevel_interest      = $level;
            $Opportunities->number_employees      = 0;
            $Opportunities->number_courses        = $numCourses;
            $Opportunities->number_places         = 0;
            $Opportunities->price_total           = 0;
            $Opportunities->iva                   = $this->helper->getIva();
            $Opportunities->opportunities_status  = 1;
            $Opportunities->necesites             = $necesites;
            $Opportunities->comment               = $comments;
            $Opportunities->fkPayment_methods     = $slcPayment;
            if($campaning > 0){
            $Opportunities->fkCampaign            = $campaning;
            }
            $Opportunities->isBudget              = $presu;
            $Opportunities->budgetComent          = $comentPresupuesto;
            $Opportunities->training              = $requicapa;
            $Opportunities->register_day          = $DateTime[0];
            $Opportunities->register_hour         = $DateTime[1];
            $Opportunities->final_date            = $date;
            $Opportunities->status                = 1;
            
            if($Opportunities->save()){
                foreach($slcCourse as $item){
                    
                     $price = $this->createOportunity($item->qty,$totalqty);
                    
                    $courses = new Opportunity_by_Courses;
                    $courses->fkOpportunities =  $Opportunities->pkOpportunities;
                    $courses->fkCourses       =  $item->course;
                    $courses->price           =  $price;
                    $courses->qtyPlaces       =  $item->qty;
                    $courses->status          =  1;
                    
                    if($courses->save()){   
                        $totalPrice = $totalPrice + $price;
                        $totalQty   = $totalQty + $item->qty;
                    }else{
                      $flag = "false";   
                    }
                }
                
                $updateOport = DB::table("opportunities")
                                 ->where("pkOpportunities", "=" ,$Opportunities->pkOpportunities)
                                 ->update(['price_total'   => $totalPrice
                                          ,'number_places' => $totalQty]);
                
                $statusPrev = DB::table('status_by_bussines')
                                ->select('pkStatus_by_bussines')
                                ->where('fkBusiness','=',$slcBussines)
                                ->where('fkOpportunities','=',0)
                                ->where('fkQuotations','=',0)
                                ->where('fkBusiness_status','=',3)
                                ->first();
                
                
                if(!empty($statusPrev->pkStatus_by_bussines)){
                    
                     $updateOportunity = DB::table("status_by_bussines")
                                            ->where("pkStatus_by_bussines", "=" ,$statusPrev->pkStatus_by_bussines)
                                            ->update(['fkBusiness_status' => 4
                                                     ,'fkOpportunities' => $Opportunities->pkOpportunities]);
                }else{
                  $statusBussines = new Status_by_bussines;
                    $statusBussines->fkBusiness        =  $slcBussines;
                    $statusBussines->fkOpportunities   =  $Opportunities->pkOpportunities;
                    $statusBussines->fkQuotations      =  0;
                    $statusBussines->fkBusiness_status =  4;
                    $statusBussines->status            =  1;
                    
                     if($statusBussines->save()){                       
                     }else{
                      $flag = "false";     
                     }   
                }
                // 
                    $insertActivity = new Activities;
                    $insertActivity->fkBusiness = $Opportunities->fkBusiness;
                    $insertActivity->fkUser = $Opportunities->asing;
                    $insertActivity->fkActivities_type = -1;
                    $insertActivity->description = "Oportunidad con folio: ".$Opportunities->folio." creada";
                    $insertActivity->register_date = $DateTime[0];
                    $insertActivity->register_hour = $DateTime[1];
                    $insertActivity->document = "";
                    $insertActivity->status = 1; 
                  

                    if ($insertActivity->save()) {
                        
                    } else {
                        $flag = "false";
                    }        
                   
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
          }catch (\Exception $e) {
                DB::rollback(); 
                //return "Error del sistema, favor de contactar al desarrollador";
                return $e->getMessage();
        }  
        }
        
        private function createOportunity($qtyPlaces,$totalqty){
            
            
            $priceIva    = 0;

            $pricePerPlaces = DB::table('price_places')
                                ->select('pkPrice_place'
                                         ,'price')
                                ->where('status','=',1)
                                ->first();
            
            $priceBase = $qtyPlaces * (float) $pricePerPlaces->price;
            
            $haveDesc = "";
            if(1 == 2){
            $haveDescQ  = DB::table('discount_places')
                           ->select('pkDiscount_places'
                                   ,'cantPlaces'
                                   ,'discount')
                           ->where('status','=',1)
                           ->where(function ($query)  use ($totalqty){
                           $query->where('cantPlaces','<=',$totalqty);
                                //->Where('cantPlaces','<=',$placesTotal);
                             })
                          // ->orderby('discount','desc')
                           ->get();
                             
              foreach($haveDescQ as $haveDescInfo){
                  $descAux = $haveDescInfo->discount;
                  if($totalqty >= $haveDescInfo->discount && $descAux <= $haveDescInfo->discount){
                      
                     $haveDesc =  $haveDescInfo->discount;
                     $descAux = $haveDesc;
                  }
              }
            
             if(!empty($haveDesc)){
                 $desc      = ($priceBase * $haveDesc) / 100;
                 $priceBase =  $priceBase - $desc;
                 
             }
            }

             return $priceBase;
        
        }
        
        private function createQuotation($qtyPlaces,$totalPlaces, $iva,$type,$editTotal,$totalPrice){
            
          if($editTotal == 0){ 
            $priceIva    = 0;

            $pricePerPlaces = DB::table('price_places')
                                ->select('pkPrice_place'
                                         ,'price')
                                ->where('status','=',1)
                                ->first();
            
            $priceBase = $qtyPlaces * (float) $pricePerPlaces->price;
           
            $haveDesc = "";
            if($type == 1){
            $haveDescQ  = DB::table('discount_places')
                           ->select('pkDiscount_places'
                                   ,'cantPlaces'
                                   ,'discount')
                           ->where('status','=',1)
                           ->where(function ($query)  use ($totalPlaces){
                           $query->where('cantPlaces','<=',$totalPlaces);
                                //->Where('cantPlaces','<=',$placesTotal);
                             })
                          // ->orderby('discount','desc')
                           ->get();
                             
                       
                             
              foreach($haveDescQ as $haveDescInfo){
                  $descAux = $haveDescInfo->discount;
                  if($descAux <= $haveDescInfo->discount){
                     // dd($haveDescInfo->discount);
                     $haveDesc =  (double) $haveDescInfo->discount;
                     $descAux = $haveDesc;
                  }
              }
             
             if(!empty($haveDesc)){
                 $desc      = ($priceBase * $haveDesc) / 100;
                 $priceBase =  $priceBase - $desc;
                 
             }
            }
        }else{
            $priceUnit = $totalPrice / $totalPlaces;
            $priceBase = $priceUnit * $qtyPlaces;
        }
              
             return $priceBase;
        
      
        }
        
        public function viewTableOportunity(Request $request){
            
            $arrayPermition = array();
            
            $arrayPermition["view"]   = $this->UserPermits->getPermition("viewOpportunities");
            $arrayPermition["edit"]   = $this->UserPermits->getPermition("editOpportunities");
            $arrayPermition["change"] = $this->UserPermits->getPermition("changeOpportunities");
            $arrayPermition["delete"] = $this->UserPermits->getPermition("deleteOpportunities");
            
            $totalMount = 0;
            
            $agent     = DB::table('users')
                           ->select('full_name'
                                   ,'pkUser')
                           ->where('status','=',1)
                           ->where('fkUser_type','!=',1)
                           ->get();
            
            $montWithIva = [];
           
            $oportunity = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->leftjoin('users as u','u.pkUser','=','o.fkUser')
                            ->leftjoin('users as a','a.pkUser','=','o.asing')
                            ->leftjoin('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->leftjoin('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->leftjoin('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
                            ->select('o.pkOpportunities'
                                    ,'o.name'
                                    ,'b.name as bussines'
                                    ,'o.folio'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'b.image'
                                    ,'b.state'
                                    ,'b.country'
                                    ,'b.pkBusiness'
                                    ,'a.full_name as asing'
                                    ,'o.opportunities_status as opportunities_statu'
                                    ,DB::raw("(CASE WHEN o.opportunities_status = 1 THEN 'Abierta' 
                                                    WHEN o.opportunities_status = 2 THEN 'Rechazada'
                                                    WHEN o.opportunities_status = 3 THEN 'Cancelada'
                                                    WHEN o.opportunities_status = 5 THEN 'Cotizada'
                                                    ELSE 'N/A' END) as opportunities_status")
                                    ,'o.number_employees'
                                    ,'o.number_places'
                                    ,'o.number_courses'
                                    ,'o.price_total'
                                    ,'o.necesites'
                                    ,'o.iva'
                                    ,'o.comment'
                                    ,'p.name as typePayment'
                                    ,'o.isBudget')
                            ->where('o.status','=',1)
                            ->where('b.status','=',1)
                            ->orderby('register_day','desc')
                            ->orderby('register_hour','desc')
                            ->get();
            
            $oportunityDetail = array();
            
               foreach($oportunity as $item){
                   
                  $price = $this->helper->getPriceWithIvaQuotation($item->price_total,$item->iva);
                
                  $montWithIva[$item->pkOpportunities] = $price;
                  
                  if($item->opportunities_status == "Abierta"){
                      $totalMount = $totalMount + $price;
                  }
                  
                   $detail = DB::table('opportunity_by_courses as o')
                              ->leftjoin('courses as c','c.pkCourses','=','o.fkCourses')
                              ->select('c.name as course'
                                      ,'c.code as code'
                                      ,'o.price'
                                      ,'o.qtyPlaces'
                                      ,'o.pk_opportunity_by_courses')
                              ->where('o.status','=',1)
                              ->where('o.fkOpportunities','=',$item->pkOpportunities)
                              ->get();
               
                        foreach($detail as $itemDetail){
                          if($itemDetail->price > 0){
                      $oportunityDetail[$item->pkOpportunities][$itemDetail->pk_opportunity_by_courses] = array("course"    => $itemDetail->code." - ".$itemDetail->course
                                                                   ,"price"     => $this->helper->getPriceWithIvaQuotation($itemDetail->price,$item->iva)
                                                                   ,"qtyPlaces" => $itemDetail->qtyPlaces);
                      }else{
                         $oportunityDetail[$item->pkOpportunities][$itemDetail->pk_opportunity_by_courses] = array("course"    => $itemDetail->code." - ".$itemDetail->course
                                                                   ,"price"     => $itemDetail->price
                                                                   ,"qtyPlaces" => $itemDetail->qtyPlaces);  
                      }
                        }
           }
            
            // dd($arrayPermition["view"]);
            
             return view('oportunidades.verOportunidades', ["oportunity"     => $oportunity
                                                           ,"totalMount"     => $totalMount
                                                           ,"agent"          => $agent
                                                           ,"montWithIva"    => $montWithIva
                                                           ,"arrayPermition" => $arrayPermition
                                                           ,"oportunityDetail" => $oportunityDetail]);
            
        }
        
        public function updateOportunity(Request $request) 
        {
          $pkOportunity         = $request->input("pkOportunity");
           
          $oportunity   = DB::table('opportunities as o')
                          ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                          ->select('o.pkOpportunities'
                                  ,'o.fkBusiness'
                                  ,'o.folio'
                                  ,'o.name'
                                  ,'b.name as bussiness'
                                  ,'b.pkBusiness as idBussines'
                                  ,'o.fkUser'
                                  ,'o.fkCampaign'
                                  ,'o.fkContact_by_business'
                                  ,'o.fkLevel_interest'
                                  ,'o.number_employees'
                                  ,'o.number_courses'
                                  ,'o.number_places'
                                  ,'o.price_total'
                                  ,'o.iva'
                                  ,'o.opportunities_status'
                                  ,'o.necesites'
                                  ,'o.training'
                                  ,'o.comment'
                                  ,'o.fkPayment_methods'
                                  ,'o.isBudget'
                                  ,'o.budgetComent'
                                  ,'o.final_date'
                                  ,'o.register_day'
                                  ,'o.register_hour')
                            ->where('o.pkOpportunities','=',$pkOportunity)
                            ->first();
          
         // $oportunity->price_total = $this->helper->getPriceWithIvaQuotation($oportunity->price_total,$oportunity->iva);
          
          $coursesByOportunity = DB::table('opportunity_by_courses')
                       ->where('fkOpportunities','=',$pkOportunity)
                       ->where('status','=',1)
                       ->get();
          
            
        $bussines  = DB::table('business')
                         ->select('name'
                                 ,'pkBusiness')
                         ->where('status','=',1)
                         ->get();
          
          $courses   = DB::table('courses')
                         ->select('pkCourses'
                                 ,'name'
                                 ,'code')
                         ->where('status','=',1)
                         ->orderby('code','asc')
                         ->get();
          
          $date      = date("Y-m-d");
          $companis   = DB::table('commercial_campaigns')
                         ->select('pkCommercial_campaigns'
                                 ,'name')
                         ->where('status','=',1)
                         ->whereDate('start_date','<=',$date)
                         ->whereDate('end_date','>=',$date)
                         ->get();
          
            $campaning = DB::table('commercial_campaigns as c')
                         ->join('business_by_commercial_campaigns as d','d.fkCommercial_campaigns','=','c.pkCommercial_campaigns')
                         ->select('c.name')
                         ->where('c.status','=',1)
                         ->where('d.status','=',1)
                         ->where('d.fkBusiness','=',$oportunity->fkBusiness)
                         ->get();
          
          $agent     = DB::table('users')
                         ->select('full_name'
                                 ,'pkUser')
                         ->where('status','=',1)
                         ->where('fkUser_type','!=',1)
                         ->get();
          
          $level      = DB::table('level_interest')
                           ->select('pkLevel_interest'
                                   ,'text')
                           ->where('status','=',1)
                           ->get();
          
          $payment    = DB::table('payment_methods')
                           ->select('pkPayment_methods'
                                   ,'name')
                           ->where('status','=',1)
                           ->get();
          
          $contact           = DB::table('contacts_by_business')
                                 ->select('pkContact_by_business'
                                          ,'name')
                                 ->where('fkBusiness','=',$oportunity->fkBusiness)
                                 ->get();
          
          $oportunityDetail = array();
          
                               
                 $detail = DB::table('opportunity_by_courses as o')
                            ->leftjoin('courses as c','c.pkCourses','=','o.fkCourses')
                            ->select('o.fkCourses as course'
                                    ,'o.price'
                                    ,'o.qtyPlaces'
                                    ,'o.pk_opportunity_by_courses')
                            ->where('o.status','=',1)
                            ->where('o.fkOpportunities','=',$oportunity->pkOpportunities)
                            ->get();
                 
                 $subtotal = 0;
                 $total    = 0;
                 $desc     = 0;
                 
                  $pricePerPlaces = DB::table('price_places')
                              ->select('pkPrice_place'
                                       ,'price')
                              ->where('status','=',1)
                              ->first();
          
        
             
                      foreach($detail as $itemDetail){
                          
                            $price = $itemDetail->qtyPlaces * (float) $pricePerPlaces->price;
                          
                        if($itemDetail->price > 0){
                    $oportunityDetail[$oportunity->pkOpportunities][$itemDetail->pk_opportunity_by_courses] = array("course"    => $itemDetail->course
                                                                 ,"price"     => $price
                                                                 ,"priceIva"  => $this->helper->getPriceWithIvaQuotation($price,$oportunity->iva)
                                                                 ,"qtyPlaces" => $itemDetail->qtyPlaces);
                    
                    
                            $subtotal = $subtotal + $this->helper->getPriceWithIvaQuotation($price,$oportunity->iva); 
                    }else{
                       $oportunityDetail[$oportunity->pkOpportunities][$itemDetail->pk_opportunity_by_courses] = array("course"    => $itemDetail->course
                                                                 ,"price"     => $price
                                                                 ,"priceIva"     => $price
                                                                 ,"qtyPlaces" => $itemDetail->qtyPlaces);  
                       
                        $subtotal = $subtotal + $price; 
                    }
                   
                    
                      }
                      
                      $totalqty = $oportunity->number_places;
                      
                        $haveDescQ  = DB::table('discount_places')
                         ->select('pkDiscount_places'
                                 ,'cantPlaces'
                                 ,'discount')
                         ->where('status','=',1)
                         ->where(function ($query)  use ($totalqty){
                         $query->where('cantPlaces','<=',$totalqty);
                              //->Where('cantPlaces','<=',$placesTotal);
                           })
                        // ->orderby('discount','desc')
                         ->get();
                           
            foreach($haveDescQ as $haveDescInfo){
                $descAux = $haveDescInfo->discount;
                if($totalqty >= $haveDescInfo->discount && $descAux <= $haveDescInfo->discount){
                    
                   $haveDesc =  $haveDescInfo->discount;
                   $descAux = $haveDesc;
                }
            }
          
           if(!empty($haveDesc)){
               $desc  = ($subtotal * $haveDesc) / 100;
               //$desc  =  $this->helper->getPriceWithIvaQuotation($desc,$oportunity->iva);
               $total =  $subtotal - $desc;
              // $total = $this->helper->getPriceWithIvaQuotation($total,$oportunity->iva);
           }
       
     
            $view = view('oportunidades.editOportunidad', array(
                  "bussines"        => $bussines,
                  "courses"         => $courses,
                  "agent"           => $agent,
                  "level"           => $level,
                  "payment"         => $payment,
                  "oportunity"      => $oportunity,
                  "contact"         => $contact,
                  "campaning"       => $campaning,
                  "companis"        => $companis,
                  "subtotal"        => $subtotal,
                  "desc"            => $desc,
                  "total"           => $total,
                  "coursesByOportunity" => $coursesByOportunity,
                  "oportunityDetail"    => $oportunityDetail
                      ))->render();
      
          return \Response::json(array(
                                "valid"       => "true",
                                "view"        => $view
                              ));        
        }
        
        public function updateOportunityDB(Request $request){
            
            $date         = date("Y-m-d");
            $startDateUTC = date("Y-m-d H:i:s");
            $flag         = "true";
        
            $DateTime = explode(" ", $startDateUTC);
           
            
           DB::beginTransaction();
          try{  
            
            $slcBussines = $request->input("slcBussines");
            $slcContact  = $request->input("slcContact");
            $slcCourse   = json_decode($request->input("slcCourse"));
            $slcAgent    = $request->input("slcAgent");
            $presu       = $request->input("customradio1");
            $necesites   = $request->input("necesites");
            $comments    = $request->input("comments");
            $level       = $request->input("level");
            $slcPayment  = $request->input("slcPayment");
            $name        = $request->input("name");
            $slcStatus   = $request->input("slcStatus");
            $pkOpportunities = $request->input("pkOpportunities");
            $comentPresupuestos  = $request->input("comentPresupuestos");
            $requicapas  = $request->input("requicapas");
            $numCourses  = count($slcCourse);
            
             $totalPrice = 0;
            $totalQty   = 0;
            
            $statusAnt = DB::table('opportunities')
                           ->select('opportunities_status')
                           ->where('pkOpportunities','=',$pkOpportunities)
                           ->first();
            
            $update = DB::table("opportunities")
                        ->where("pkOpportunities", "=" ,$pkOpportunities)
                        ->update(['name'                  => $name
                                 ,'fkBusiness'            => $slcBussines
                                 ,'fkUser'                => $slcAgent
                                 ,'fkContact_by_business' => $slcContact
                                 ,'fkLevel_interest'      => $level
                                 ,'number_courses'        => $numCourses
                                 ,'necesites'             => $necesites
                                 ,'comment'               => $comments
                                 ,'fkPayment_methods'     => $slcPayment
                                 ,'isBudget'              => $presu
                                 ,'budgetComent'          => $comentPresupuestos
                                 ,'training'              => $requicapas
                                 ,'opportunities_status'  => $slcStatus
                                 ,'final_date'            => $date]);

            
              if($statusAnt != $slcStatus){
                  
                  $statusText = "";
                  if($slcStatus == 1){
                       $statusText = "Abierta";
                  }elseif($slcStatus == 2){
                       $statusText = "Rechazada";
                  }elseif($slcStatus == 3){
                       $statusText = "Cancelada";
                  }
                  
                    $insertActivity = new Activities;
                    $insertActivity->fkBusiness = $slcBussines;
                    $insertActivity->fkUser = $slcAgent;
                    $insertActivity->fkActivities_type = -1;
                    $insertActivity->description = "Oportunidad ".$statusText;
                    $insertActivity->register_date = $DateTime[0];
                    $insertActivity->register_hour = $DateTime[1];
                    $insertActivity->document = "";
                    $insertActivity->status = 1;

                    if ($insertActivity->save()) {
                        
                    } else {
                        $flag = "false";
                        $message .= "Error al cargar actividad \n";
                    }
                }
                
 
            
                $deleteCoursesPrev = DB::table("opportunity_by_courses")
                            ->where('fkOpportunities', '=', $pkOpportunities)
                            ->where('status', '=', 1)
                            ->update(array("status" => 0));
                
             if ($deleteCoursesPrev >= 1) {
                 
                 foreach($slcCourse as $item){
                    
                    $courses = new Opportunity_by_Courses;
                    $courses->fkOpportunities =  $pkOpportunities;
                    $courses->fkCourses       =  $item->course;
                    $courses->price           =  $item->price;
                    $courses->qtyPlaces       =  $item->qty;
                    $courses->status          =  1;
                    
                    if($courses->save()){   
                        $totalPrice = $totalPrice + $item->price;
                        $totalQty   = $totalQty + $item->qty;
                    }else{
                      $flag = "false";   
                    }
                }
                
                $updateOport = DB::table("opportunities")
                                 ->where("pkOpportunities", "=" ,$pkOpportunities)
                                 ->update(['price_total'   => $totalPrice
                                          ,'number_places' => $totalQty]);
                
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
            
            }catch (\Exception $e) {
                DB::rollback(); 
                //return "Error del sistema, favor de contactar al desarrollador";
                return $e->getMessage();
          }  
       }
        
        public function deleteOportunity(Request $request) 
        {
             if( ($this->UserPermits->getPermition("deleteOpportunities") == 1) || Session::get("isAdmin") == 1){
                    
           $pkOportunity         = $request->input("pkOportunity");
            
            $categoriesUpdate   = DB::table("opportunities")
                                    ->where('pkOpportunities','=',$pkOportunity)
                                    ->where('status','=',1)
                                    ->update(array("status" => 0));
            
            if($categoriesUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
             }else{
                return "falseNoPermition";
             }
        }
        
        public function convertToQuotation(Request $request){
           $pkOportunity         = $request->input("pkOportunity");
           
           
            $oportunity   = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->select('o.pkOpportunities'
                                    ,'o.fkBusiness'
                                    ,'o.name'
                                    ,'b.name as bussinesName'
                                    ,'o.fkUser'
                                    ,'o.asing'
                                    ,'o.fkContact_by_business'
                                    ,'o.fkLevel_interest'
                                    ,'o.fkCampaign'
                                    ,'o.number_employees'
                                    ,'o.number_courses'
                                    ,'o.number_places'
                                    ,'o.price_total'
                                    ,'o.opportunities_status'
                                    ,'o.necesites'
                                    ,'o.comment'
                                    ,'o.iva'
                                    ,'o.fkPayment_methods'
                                    ,'o.isBudget'
                                    ,'o.final_date'
                                    ,'o.register_day'
                                    ,'o.register_hour')
                              ->where('o.pkOpportunities','=',$pkOportunity)
                              ->first();
            
              
          $bussines  = DB::table('business')
                           ->select('name'
                                   ,'pkBusiness')
                           ->where('status','=',1)
                           ->get();
            
            $courses   = DB::table('courses')
                           ->select('pkCourses'
                                   ,'name'
                                   ,'code')
                           ->where('status','=',1)
                           ->orderby('code','asc')
                           ->get();
            
            $agent     = DB::table('users')
                           ->select('full_name'
                                   ,'pkUser')
                           ->where('status','=',1)
                           ->where('fkUser_type','!=',1)
                           ->get();
            
            $level      = DB::table('level_interest')
                             ->select('pkLevel_interest'
                                     ,'text')
                             ->where('status','=',1)
                             ->get();
            
            $payment    = DB::table('payment_methods')
                             ->select('pkPayment_methods'
                                     ,'name')
                             ->where('status','=',1)
                             ->get();
            
            $date      = date("Y-m-d");
            
              $companis   = DB::table('commercial_campaigns')
                           ->select('pkCommercial_campaigns'
                                   ,'name')
                           ->where('status','=',1)
                           ->whereDate('start_date','<=',$date)
                           ->whereDate('end_date','>=',$date)
                           ->get();
            
            $contact           = DB::table('contacts_by_business')
                                   ->select('pkContact_by_business'
                                            ,'name')
                                   ->where('fkBusiness','=',$oportunity->fkBusiness)
                                   ->get();
            
               $oportunityDetail = array();
            
                                 
                   $detail = DB::table('opportunity_by_courses as o')
                              ->leftjoin('courses as c','c.pkCourses','=','o.fkCourses')
                              ->select('o.fkCourses as course'
                                      ,'o.price'
                                      ,'o.qtyPlaces'
                                      ,'o.pk_opportunity_by_courses')
                              ->where('o.status','=',1)
                              ->where('o.fkOpportunities','=',$oportunity->pkOpportunities)
                              ->get();
                              $pricePerPlaces = DB::table('price_places')
                              ->select('pkPrice_place'
                                       ,'price')
                              ->where('status','=',1)
                              ->first();     
                  
                    $subtotal = 0;
                 $total    = 0;
                 $desc     = 0;
             
                      foreach($detail as $itemDetail){
                          
                           $price = $itemDetail->qtyPlaces * (float) $pricePerPlaces->price;
                           $priceUnit = $price / $itemDetail->qtyPlaces;
                           $priceUnit = $this->helper->getPriceWithIvaQuotation($priceUnit,$oportunity->iva);

                        if($itemDetail->price > 0){
                    $oportunityDetail[$oportunity->pkOpportunities][$itemDetail->pk_opportunity_by_courses] = array("course"    => $itemDetail->course
                                                                 ,"price"     => $price
                                                                 ,"priceUnit" => $priceUnit
                                                                 ,"priceIva"  => $this->helper->getPriceWithIvaQuotation($price,$oportunity->iva)
                                                                 ,"qtyPlaces" => $itemDetail->qtyPlaces);
                    
                      $subtotal = $subtotal + $this->helper->getPriceWithIvaQuotation($price,$oportunity->iva); 
                    }else{
                       $oportunityDetail[$oportunity->pkOpportunities][$itemDetail->pk_opportunity_by_courses] = array("course"    => $itemDetail->course
                                                                 ,"price"     => $price
                                                                 ,"priceIva"     => $price
                                                                 ,"qtyPlaces" => $itemDetail->qtyPlaces);  
                       $subtotal = $subtotal + $price; 
                    }
                      }
          
                       $totalqty = $oportunity->number_places;
                      
                        $haveDescQ  = DB::table('discount_places')
                         ->select('pkDiscount_places'
                                 ,'cantPlaces'
                                 ,'discount')
                         ->where('status','=',1)
                         ->where(function ($query)  use ($totalqty){
                         $query->where('cantPlaces','<=',$totalqty);
                              //->Where('cantPlaces','<=',$placesTotal);
                           })
                        // ->orderby('discount','desc')
                         ->get();
                
            foreach($haveDescQ as $haveDescInfo){
                $descAux = $haveDescInfo->discount;
                if($totalqty >= $haveDescInfo->discount && $descAux <= $haveDescInfo->discount){
                    
                   $haveDesc =  $haveDescInfo->discount;
                   $descAux = $haveDesc;
                }
            }
          
           if(!empty($haveDesc) && 1 == 2){
               $desc  = ($subtotal * $haveDesc) / 100;
               //$desc  =  $this->helper->getPriceWithIvaQuotation($desc,$oportunity->iva);
               $total =  $subtotal - $desc;
              // $total = $this->helper->getPriceWithIvaQuotation($total,$oportunity->iva);
           }else{
            $total =  $subtotal;
           }
           
          

             
           $view = view('oportunidades.convertirCotizacion', array(
            "bussines"         => $bussines,
            "courses"          => $courses,
            "agent"            => $agent,
            "level"            => $level,
            "payment"          => $payment,
            "oportunity"       => $oportunity,
            "contact"          => $contact,
            "companis"         => $companis,
            "subtotal"        => $subtotal,
            "desc"            => $desc,
            "total"           => $total,
            "oportunityDetail" => $oportunityDetail
                ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function convertToQuotationDB(Request $request){
            $name               = htmlentities ($request->input("name"));
            $slcBussines        = $request->input("slcBussines");
            $slcContact         = $request->input("slcContact");
            $slcAgent           = $request->input("slcAgent");
            $level              = $request->input("level");
            $slcPayment         = $request->input("slcPayment");
            $vigency            = $request->input("vigency");
            $iva                = $request->input("iva");
            $campaning          = $request->input("campaning");
            $idOportunity       = $request->input("idOportunity");
            
            $agentPro   = 0;
      
            $property   = DB::table('business')
                            ->select('pkBusiness'
                                    ,'fkUser')
                            ->where('pkBusiness','=',$slcBussines)
                            ->first();
            
             if(!empty($property->pkBusiness)){
               $agentPro   = $property->fkUser;
            }
       
            $folioOportunity = DB::table('opportunities')
                                 ->select('folio')
                                 ->where('pkOpportunities','=',$idOportunity)
                                 ->first();
          
            
            $arrayOptions       = json_decode($request->input('arrayOptions'));
            $startDateUTC = date("Y-m-d H:i:s");
            $DateTime = explode(" ", $startDateUTC);
            $flag               = "true";
            $message            = "true";
            DB::beginTransaction();
            
            $folio = 1;
            
            $lastId = DB::table('quotations')
                        ->select('pkQuotations')
                        ->orderby('pkQuotations','desc')
                        ->first();
        
  
        if(!empty($lastId->pkQuotations)){
            $folio = $lastId->pkQuotations+1;
        }
             
            try { 
                
            

                                $Quotation                       = new Quotation;
                               $Quotation->folio                 = $folio;
                                $Quotation->color                = "#64CF30";
                                $Quotation->icon                 = "ti-star";
                                $Quotation->fkOpportunities      = 0;
                                $Quotation->fkBusiness           = $slcBussines;
                                $Quotation->fkUser               = $agentPro;
                                $Quotation->asing                = $slcAgent;
                                $Quotation->fkContact_by_business= $slcContact;
                                $Quotation->fkLevel_interest     = $level;
                                $Quotation->quotations_status    = 1;
                                if($campaning > 0){
                                $Quotation->fkCampaign           = $campaning;
                                }
                                $Quotation->fkPayment_methods    = $slcPayment;
                                $Quotation->register_day         = $DateTime[0];
                                $Quotation->register_hour        = $DateTime[1];
                                $Quotation->withIva              = $iva;
                                $Quotation->status               = 1;
                                
                                if($Quotation->save()){
                 
                                   // return $arrayContacts;
                                    foreach($arrayOptions as $item){
                                       
                                             $totalPrice = 0;
                                             $totalQty   = 0;
                                        
                                       $quotation_detail                = new Quotation_detail;
                                       $quotation_detail->fkQuotations  = $Quotation->pkQuotations;
                                       $quotation_detail->number_places = 0;
                                       $quotation_detail->price         = 0;
                                       $quotation_detail->iva           = $this->helper->getIva();
                                       $quotation_detail->type          = $item[0];
                                       $quotation_detail->isSelected    = 0;
                                       $quotation_detail->date          = $item[1];
                                       $quotation_detail->status        = 1;
                                       
                                        if($quotation_detail->save()){
                                             foreach($item[2] as $courses){
                                              $price = $this->createQuotation($courses->qty, $item[3],$iva,$item[0],$item[4],$item[5]);
                                                   
                                             $quotation_cources                     = new Quotation_by_Courses;
                                             $quotation_cources->fkQuotationDetail  = $quotation_detail->pkQuotations_detail;
                                             $quotation_cources->fkCourses          = $courses->course;
                                             $quotation_cources->places             = $courses->qty;
                                             $quotation_cources->price              = $price;
                                             $quotation_cources->status             = 1;
                                            
                                              if($quotation_cources->save()){
                                                  
                                                  $totalPrice = $totalPrice + $price;
                                                  $totalQty   = $totalQty + $courses->qty;
                                        }else{
                                         $flag         = "false";  
                                          $message    .= "Error al crear registro cursos \n";
                                        }
                                        }

                                        }else{
                                         $flag         = "false";  
                                          $message    .= "Error al crear registro contactos \n";
                                        }
                                       
                                      $updateDetail = DB::table("quotations_detail")
                                                         ->where("pkQuotations_detail", "=" ,$quotation_detail->pkQuotations_detail)
                                                         ->update(['price'   => $totalPrice
                                                                  ,'number_places' => $totalQty]);
                                      
                                      if($updateDetail >= 1){
                                          
                                      }else{
                                       $flag = "false";     
                                      }
                                    }
                                    
                                    $updateOportunity = DB::table("opportunities")
                                                          ->where("pkOpportunities", "=" ,$idOportunity)
                                                          ->update(['opportunities_status' => 5]);
                                    
                                    if($updateOportunity > 0){
                                        
                                         $insertActivity                     = new Activities;
                                         $insertActivity->fkBusiness         = $slcBussines;
                                         $insertActivity->fkUser             = $slcAgent;
                                         $insertActivity->fkActivities_type  = -1;
                                         $insertActivity->description        = "Oportunidad # ".$folioOportunity->folio." convertida a cotizacion # ".$folio;
                                         $insertActivity->register_date      = $DateTime[0];
                                         $insertActivity->register_hour      = $DateTime[1];
                                         $insertActivity->document           = "";
                                         $insertActivity->status             = 1;
                                         
                                           if($insertActivity->save()){
                                               
                                           }else{
                                              $flag           = "false"; 
                                              $message    .= "Error al cargar actividad \n";   
                                           }
                                           
                                          $updateOportunity = DB::table("status_by_bussines")
                                                          ->where("fkOpportunities", "=" ,$idOportunity)
                                                          ->update(['fkQuotations' => $Quotation->pkQuotations,
                                                                    'fkBusiness_status' => 6]);
                                        
                                    }else{
                                      $flag           = "false";
                                      $message    .= "Error al actualizar oportunidad \n";   
                                    }
                                    
                                }else{
                                    $flag           = "false";
                                    $message    .= "Error al crear registro \n";
                                }

                if($flag == "true"){
                    DB::commit();
                    return $flag;
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
        
        public function searchOportunity(Request $request){
         
            $status     = $request->input("status");
            $agent      = $request->input("agent");
            $fechStart  = $request->input("fechStart");
            $fechFinish = $request->input("fechFinish");
      
             $arrayPermition = array();
            
            $arrayPermition["view"]   = $this->UserPermits->getPermition("viewOpportunities");
            $arrayPermition["edit"]   = $this->UserPermits->getPermition("editOpportunities");
            $arrayPermition["change"] = $this->UserPermits->getPermition("changeOpportunities");
            $arrayPermition["delete"] = $this->UserPermits->getPermition("deleteOpportunities");
            
            $totalMount = 0;
            $montWithIva = [];
            
            $oportunityDetail = array();
            
              $oportunity = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->leftjoin('users as u','u.pkUser','=','o.fkUser')
                            ->leftjoin('users as a','a.pkUser','=','o.asing')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->leftjoin('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
                            ->select('o.pkOpportunities'
                                    ,'o.name'
                                    ,'b.name as bussines'
                                    ,'o.folio'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'b.image'
                                    ,'b.state'
                                    ,'b.country'
                                    ,'b.pkBusiness'
                                    ,'a.full_name as asing'
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
                                    ,DB::raw("(CASE WHEN o.opportunities_status = 1 THEN 'Abierta' 
                                                    WHEN o.opportunities_status = 2 THEN 'Rechazada'
                                                    WHEN o.opportunities_status = 3 THEN 'Cancelada'
                                                    WHEN o.opportunities_status = 5 THEN 'Cotizada'
                                                    ELSE 'N/A' END) as opportunities_status")
                                    ,'o.number_employees'
                                    ,'o.number_places'
                                    ,'o.number_courses'
                                    ,'o.price_total'
                                    ,'o.necesites'
                                    ,'o.iva'
                                    ,'o.comment'
                                    ,'p.name as typePayment'
                                    ,'o.isBudget');
                            
             
              if($status > 0){
             $oportunity = $oportunity->where('o.opportunities_status','=',$status);   
            }
           
            if($agent > 0){
            $oportunity = $oportunity->where('o.fkUser','=',$agent);    
            }
            
            if(!empty($fechStart)){
             $oportunity = $oportunity->whereDate('o.register_day','>=',$fechStart);   
            }
            
            if(!empty($fechFinish)){
             $oportunity = $oportunity->whereDate('o.register_day','<=',$fechFinish);   
            }
             
            
            $oportunity = $oportunity->where('o.status','=',1)
                                     ->where('b.status','=',1)
                                     ->where('u.status','=',1)
                                     ->orderby('o.register_day','desc')
                                     ->orderby('o.register_hour','desc')
                                     ->get();
            
      
              foreach($oportunity as $item){
                   
                  $price = $this->helper->getPriceWithIvaQuotation($item->price_total,$item->iva);
                
                  $montWithIva[$item->pkOpportunities] = $price;
                  
                  if($item->opportunities_status != "Cotizada"){
                      $totalMount = $totalMount + $price;
                  }
                  
                  $detail = DB::table('opportunity_by_courses as o')
                              ->join('courses as c','c.pkCourses','=','o.fkCourses')
                              ->select('c.name as course'
                                      ,'o.price'
                                      ,'o.qtyPlaces'
                                      ,'o.pk_opportunity_by_courses')
                              ->where('o.status','=',1)
                              ->where('c.status','=',1)
                              ->where('o.fkOpportunities','=',$item->pkOpportunities)
                              ->get();
               
                        foreach($detail as $itemDetail){
                          if($itemDetail->price > 0){
                      $oportunityDetail[$item->pkOpportunities][$itemDetail->pk_opportunity_by_courses] = array("course"    => $itemDetail->course
                                                                   ,"price"     => $this->helper->getPriceWithIvaQuotation($itemDetail->price,$item->iva)
                                                                   ,"qtyPlaces" => $itemDetail->qtyPlaces);
                      }else{
                         $oportunityDetail[$item->pkOpportunities][$itemDetail->pk_opportunity_by_courses] = array("course"    => $itemDetail->course
                                                                   ,"price"     => $itemDetail->price
                                                                   ,"qtyPlaces" => $itemDetail->qtyPlaces);  
                      }
                        }
           }
              
               $view = view('oportunidades.getOportunity', array(
                    "oportunity"     => $oportunity
                   ,"montWithIva"    => $montWithIva
                   ,"arrayPermition" => $arrayPermition
                   ,"oportunityDetail" => $oportunityDetail
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view,
                                  "totalMount"  => $totalMount
                                ));   
            
        }
        
        public function viewDetailOportunity(Request $request){
            
             $idOPortunity     = $request->input("idOPortunity");
             
              $oportunity = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->leftjoin('users as u','u.pkUser','=','o.fkUser')
                            ->leftjoin('users as a','a.pkUser','=','o.asing')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->leftjoin('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
                            ->select('o.pkOpportunities'
                                    ,'o.name'
                                    ,'b.name as bussines'
                                    ,'o.folio'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'b.image'
                                    ,'b.state'
                                    ,'b.country'
                                    ,'a.full_name as asing'
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
                                    ,'o.number_employees'
                                    ,'o.number_places'
                                    ,'o.number_courses'
                                    ,'o.price_total'
                                    ,'o.necesites'
                                    ,'o.comment'
                                    ,'p.name as typePayment'
                                    ,'o.isBudget')
                            ->where('o.status','=',1)
                            ->where('b.status','=',1)
                            ->where('u.status','=',1)
                            ->where('pkOpportunities','=',$idOPortunity)
                            ->orderby('register_day','desc')
                            ->orderby('register_hour','desc')
                            ->first();
              
                 $view = view('oportunidades.detailOportunity', array(
                    "oportunity" => $oportunity
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));    
             
        }
        
        public function getTotalOportunity(Request $request){
            
            $status     = $request->input("status");
            $total      = 0;
            
            $oportunity = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->leftjoin('users as u','u.pkUser','=','o.fkUser')
                            ->leftjoin('users as a','a.pkUser','=','o.asing')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->leftjoin('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
                            ->select('o.price_total'
                                    ,'o.iva')
                            ->where('o.status','=',1)
                            ->where('b.status','=',1)
                            ->where('opportunities_status','=',$status)
                            ->get();
            
               foreach($oportunity as $item){
                   
                  $total = $this->helper->getPriceWithIvaQuotation($item->price_total,$item->iva);

           }
            
             return \Response::json(array("valid"       => "true",
                                          "oportunity"  => $total
                                         ));   
            
        }
        
        public function getCoursesOportunity(Request $request){
            
            $selectCourse = '';
           
            $courses = DB::table('courses')
                         ->select('pkCourses'
                                 ,'code'
                                 ,'name')
                         ->where('status','=',1)
                         ->orderby('code','ASC')
                         ->get();
            
            foreach($courses as $item){
              $selectCourse .=  '<option value="'.$item->pkCourses.'">'.$item->code.'-'.$item->name.'</option>';
            }
            
            return $selectCourse;
        }
	
}
