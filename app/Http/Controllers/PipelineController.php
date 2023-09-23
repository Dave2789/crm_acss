<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Alerts;
use App\Models\Users_per_alert;
use Illuminate\Http\Request;
use App\Permissions\UserPermits;
use App\Helpers\helper;

class PipelineController extends Controller {
    
    private $UserPermits;

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->UserPermits = new UserPermits();
            $this->helper = new helper();
        }

        function sortFunction($a, $b) {
                return strtotime($b["register_day"]." ".$b["register_hour"]) - strtotime($a["register_day"]." ".$a["register_hour"]);
          }

          function sortFunctionSale($a, $b) {
                return strtotime($b["final_date"]) - strtotime($a["final_date"]);
          }

          
        
        public function viewPipeline()
        {
            $arrayInitial    = array();
            $arrayOportunity = array();
            $arrayQuotation  = array();
            $arrayQuotationDetail = array();
            $arraySale       = array();
            $arrayPermition  = array();
            $totalOportunity = 0;
            $totalQuotation  = 0;
            $totalSales      = 0;
            $pkUser          = Session::get("pkUser");
            
                    
            $arrayPermition["pipeline"]     = $this->UserPermits->getPermition("pipeline");
            $arrayPermition["viewQuotes"]   = $this->UserPermits->getPermition("viewQuotes");
            $arrayPermition["money"]        = $this->UserPermits->getPermition("money");
            $arrayPermition["invoice"]      = $this->UserPermits->getPermition("invoice");
            $arrayPermition["editQuotes"]   = $this->UserPermits->getPermition("editQuotes");
            $arrayPermition["changeQuotes"] = $this->UserPermits->getPermition("changeQuotes");
            $arrayPermition["deleteQuotes"] = $this->UserPermits->getPermition("deleteQuotes");
            $arrayPermition["view"]   = $this->UserPermits->getPermition("viewOpportunities");
            $arrayPermition["edit"]   = $this->UserPermits->getPermition("editOpportunities");
            $arrayPermition["change"] = $this->UserPermits->getPermition("changeOpportunities");
            $arrayPermition["delete"] = $this->UserPermits->getPermition("deleteOpportunities");

            if(Session::get("fkUserType") == 1){
                $businnes = DB::table('business as b')
                ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                ->leftjoin('business_origin as bo','bo.pkBusiness_origin','=','b.fKOrigin')
                ->select('b.pkBusiness'
                        ,'b.name'
                        ,'b.image'
                        ,'bo.name as nameOrigin'
                        ,'c.name as category'
                        ,'s.fkBusiness'
                        ,'s.pkStatus_by_bussines'
                        ,'s.fkOpportunities'
                        ,'s.fkQuotations'
                        ,'s.fkBusiness_status'
                        ,'g.name as giro')
               ->where('b.status','=',1)
               ->where('s.status','=',1)
               ->where('s.fkBusiness_status','!=',3)
               ->get(); 
            }
            else{
             $businnes = DB::table('business as b')
                           ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                           ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                           ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                           ->leftjoin('business_origin as bo','bo.pkBusiness_origin','=','b.fKOrigin')
                           ->select('b.pkBusiness'
                                   ,'b.name'
                                   ,'b.image'
                                   ,'bo.name as nameOrigin'
                                   ,'c.name as category'
                                   ,'s.fkBusiness'
                                   ,'s.pkStatus_by_bussines'
                                   ,'s.fkOpportunities'
                                   ,'s.fkQuotations'
                                   ,'s.fkBusiness_status'
                                   ,'g.name as giro')
                         ->where('b.status','=',1)
                         ->where('s.status','=',1)
                         ->where('b.fkUser','=',$pkUser)
                         ->where('s.fkBusiness_status','!=',3)
                         ->get();
            }
    
         $arrayTest = array();
                
         
                         foreach($businnes as $itemStatus){
                           switch ($itemStatus->fkBusiness_status) {
                              
                               case 4:
                                 $price = 0;
                                 $infoOportunity = DB::table('opportunities as o')
                                                     ->leftjoin('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                                                     ->select('o.color'
                                                             ,'o.icon'
                                                             ,'o.folio'
                                                             ,'l.text'
                                                             ,'l.color as colorLevel'
                                                             ,'o.number_courses'
                                                             ,'o.number_places'
                                                             ,'o.iva'
                                                             ,'o.price_total'
                                                             ,'o.register_day'
                                                             ,'o.register_hour')
                                                     ->where('o.pkOpportunities','=',$itemStatus->fkOpportunities)
                                                     ->where('o.status','=',1)
                                                     ->orderby('register_day','desc')
                                                     ->orderby('register_hour','desc')
                                                     ->first();
                                   
                                 
                                if(!empty($infoOportunity->folio)){     
                                  $totalOportunity = $totalOportunity + $this->helper->getPriceWithIvaQuotation($infoOportunity->price_total,$infoOportunity->iva);
                                  $price = $this->helper->getPriceWithIvaQuotation($infoOportunity->price_total,$infoOportunity->iva);
                                  
                                  
                                 $arrayOportunity[$itemStatus->pkStatus_by_bussines] = array("name" => $itemStatus->name
                                                                                            ,"fkOpportunities" => $itemStatus->fkOpportunities
                                                                                            ,"color"           => $infoOportunity->color
                                                                                            ,"icon"            => $infoOportunity->icon
                                                                                            ,"folio"           => $infoOportunity->folio
                                                                                            ,"number_courses"  => $infoOportunity->number_places
                                                                                            ,"price_total"     => $price
                                                                                            ,"logo"            => $itemStatus->image
                                                                                            ,"giro"            => $itemStatus->giro
                                                                                            ,"register_day"    => $infoOportunity->register_day
                                                                                            ,"register_hour"   => $infoOportunity->register_hour
                                                                                            ,"level"           => $infoOportunity->text
                                                                                            ,"colorLevel"      => $infoOportunity->colorLevel
                                                                                            ,"register_day"    => $infoOportunity->register_day);
                                      }
                                   break;
                               
                               case 6:
                                   
                                   $infoQuotation = DB::table('quotations as o')
                                       ->leftjoin('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                                       ->leftjoin('info_facture as i','i.fkOrder','=','o.pkQuotations')
                                    ->select('o.color'
                                            , 'o.icon'
                                            , 'o.folio'
                                            ,'l.text'
                                            ,'i.pay'
                                            ,'i.xml'
                                            ,'i.pdf'
                                            ,'o.withIva'
                                            ,'o.register_hour'
                                            ,'o.money_in_account'
                                            ,'l.color as colorLevel'
                                            , 'o.quotations_status as status'
                                            ,DB::raw("(CASE WHEN quotations_status = 1 THEN 'Abierta' 
                                                    WHEN quotations_status = 2 THEN 'Rechazada'
                                                    WHEN quotations_status = 3 THEN 'Cancelada'
                                                    WHEN quotations_status = 4 THEN 'Revision'
                                                    WHEN quotations_status = 5 THEN 'Pagada'
                                                    ELSE 'N/A' END) as quotations_status")
                                            , 'o.register_day')
                                    ->where('o.pkQuotations', '=', $itemStatus->fkQuotations)
                                    ->where(function ($query) {
                                        $query->where('o.quotations_status', '=', '1')
                                              ->orWhere('o.quotations_status', '=', '4');
                                    })
                                    ->where('o.status', '=', 1)
                                    ->orderby('register_day','desc')
                                    ->orderby('register_hour','desc')
                                    ->first();

                                  // dd($itemStatus->fkQuotations);
                                if(!empty($infoQuotation->folio)){    
                                    if($infoQuotation->quotations_status == 'Abierta'){
                                        $detialQuotation = DB::table('quotations_detail')
                                                                ->select('fkQuotations'
                                                                        , 'number_places'
                                                                        , 'price'
                                                                        , 'isSelected'
                                                                        , 'iva'
                                                                        ,DB::raw("(CASE WHEN type = 0 THEN 'Precio Lista' 
                                                                                 WHEN type = 1 THEN 'Promocion'
                                                                                 ELSE 'N/A' END) as type")
                                                                        , 'pkQuotations_detail'
                                                                        , DB::raw("DATE_FORMAT(date, '%d/%b/%Y') as date"))
                                                                ->where('fkQuotations', '=', $itemStatus->fkQuotations)
                                                                ->where('status', '=', 1)
                                                                ->orderByRaw("CAST(price AS DECIMAL(10,2)) asc")
                                                                ->take(1)->get();
                                    }else{
                                        $detialQuotation = DB::table('quotations_detail')
                                                                ->select('fkQuotations'
                                                                        , 'number_places'
                                                                        , 'price'
                                                                        , 'isSelected'
                                                                        , 'iva'
                                                                        ,DB::raw("(CASE WHEN type = 0 THEN 'Precio Lista' 
                                                                                 WHEN type = 1 THEN 'Promocion'
                                                                                 ELSE 'N/A' END) as type")
                                                                        , 'pkQuotations_detail'
                                                                        , DB::raw("DATE_FORMAT(date, '%d/%b/%Y') as date"))
                                                                ->where('fkQuotations', '=', $itemStatus->fkQuotations)
                                                                ->where('isSelected', '=', 1)
                                                                ->where('status', '=', 1)
                                                                ->orderByRaw("CAST(price AS DECIMAL(10,2)) asc")
                                                                ->take(1)->get();
                                    }
                            
                            
                            
                            
                            foreach ($detialQuotation as $infoDetail) {
                                
                                 if ($infoQuotation->withIva) {
                                        $price = $this->helper->getPriceWithIvaQuotation($infoDetail->price, $infoDetail->iva);
                                        $totalQuotation = $totalQuotation + $this->helper->getPriceWithIvaQuotation($infoDetail->price, $infoDetail->iva);
                                    } else {
                                      $price = $infoDetail->price;
                                      $totalQuotation = $totalQuotation + $this->helper->getPriceWithIvaQuotation($infoDetail->price, $infoDetail->iva);//$totalQuotation + $infoDetail->price;   
                                    }
                                    $arrayQuotationDetail[$infoDetail->pkQuotations_detail] = array("number_places" => $infoDetail->number_places
                                                                                              , "price" => $price
                                                                                              , "fkQuotations" => $infoDetail->fkQuotations
                                                                                              , "date" => $infoDetail->date
                                                                                              , "isSelected" => $infoDetail->isSelected
                                                                                              , "type" => $infoDetail->type);
                            }

                            $arrayQuotation[$itemStatus->fkQuotations]        = array("name"            => $itemStatus->name
                                                                                     ,"fkQuotations"    => $itemStatus->fkQuotations
                                                                                     ,"color"           => $infoQuotation->color
                                                                                     ,"icon"            => $infoQuotation->icon
                                                                                     ,"folio"           => $infoQuotation->folio
                                                                                     ,"pay"             => $infoQuotation->pay
                                                                                     ,"money_in_account"=> $infoQuotation->money_in_account
                                                                                     ,"logo"            => $itemStatus->image
                                                                                     ,"quotations_status"  => $infoQuotation->quotations_status
                                                                                     ,"register_day"    => $infoQuotation->register_day
                                                                                     ,"status"          => $infoQuotation->status
                                                                                     ,"giro"            => $itemStatus->giro
                                                                                     ,"register_day"    => $infoQuotation->register_day
                                                                                     ,"register_hour"   => $infoQuotation->register_hour
                                                                                     ,"level"           => $infoQuotation->text
                                                                                     ,"colorLevel"      => $infoQuotation->colorLevel
                                                                                     ,"detail"          => $arrayQuotationDetail);
                                
                               
                                 unset( $arrayQuotationDetail);
                          }
                                   break;
                               
                               case 9:
                                   $price = 0;
                                   $infoQuotation = DB::table('quotations as q')
                                                     ->leftjoin('quotations_detail as d','d.fkQuotations','=','q.pkQuotations')
                                                     ->leftjoin('level_interest as l','l.pkLevel_interest','=','q.fkLevel_interest')
                                                     ->select('q.color'
                                                             ,'q.icon'
                                                             ,'q.folio'
                                                             ,'l.text'
                                                             ,'l.color as colorLevel'
                                                             ,'q.final_date'
                                                             , DB::raw("DATE_FORMAT(final_date, '%d/%b/%Y') as date")
                                                             ,'d.number_places'
                                                             ,'d.iva'
                                                             ,'q.withIva'
                                                             ,'d.price')
                                                     ->where('q.pkQuotations','=',$itemStatus->fkQuotations)
                                                     ->where('q.quotations_status','=',5)
                                                     ->where('q.status','=',1)
                                                     ->where('d.isSelected','=',1)
                                                     
                                                     ->first();
                                    if(!empty($infoQuotation->folio)){  
                                        
                                         if ($infoQuotation->withIva) {
                                    $totalSales = $totalSales + $this->helper->getPriceWithIvaQuotation($infoQuotation->price, $infoQuotation->iva);
                                    $price = $this->helper->getPriceWithIvaQuotation($infoQuotation->price, $infoQuotation->iva);
                                } else {
                                    $totalSales = $totalSales + $this->helper->getPriceWithIvaQuotation($infoQuotation->price, $infoQuotation->iva);//$totalSales + $infoQuotation->price;
                                    $price = $infoQuotation->price;
                                }



                                $arraySale[$itemStatus->pkStatus_by_bussines] = array("name" => $itemStatus->name
                                                                                     ,"fkQuotations"  => $itemStatus->fkQuotations
                                                                                     ,"color"         => $infoQuotation->color
                                                                                     ,"icon"          => $infoQuotation->icon
                                                                                     ,"folio"         => $infoQuotation->folio
                                                                                     ,"final_date"    => $infoQuotation->final_date
                                                                                     ,"date"          => $infoQuotation->date
                                                                                     ,"logo"          => $itemStatus->image
                                                                                     ,"giro"          => $itemStatus->giro
                                                                                     ,"level"         => $infoQuotation->text
                                                                                     ,"colorLevel"    => $infoQuotation->colorLevel
                                                                                     ,"number_places" => $infoQuotation->number_places
                                                                                     ,"price"         => $price);
                                     }
                                   break;

                               default:
                                   break;
                             }
                         }
        
            $month            = date("Y-m");
            $aux              = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day         = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate        = date("Y-m")."-01";
            $endDate          = $aux;



          if(Session::get("fkUserType") == 1){

                $prospect = DB::table('business as b')
                ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                ->join('activities as a','a.fkBusiness','=','b.pkBusiness')
                ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                ->leftjoin('business_origin as bo','bo.pkBusiness_origin','=','b.fKOrigin')
                ->select('b.pkBusiness'
                        ,'b.name'
                        ,'b.image'
                        ,'bo.name as nameOrigin'
                        ,'c.name as category'
                        ,'g.name as giro')
               ->where('b.status','=',1)
               ->where('s.status','=',1)
               ->where('s.fkBusiness_status','=',3)
               ->whereDate('b.date_register','>=',$startDate)
               ->whereDate('b.date_register','<=',$endDate)
               ->groupby('b.pkBusiness')
               ->distinct()
               ->orderby('b.date_register','desc')
               ->get(); 
            }
            else{
                    
             $prospect = DB::table('business as b')
                           ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                           ->join('activities as a','a.fkBusiness','=','b.pkBusiness')
                           ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                           ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                           ->leftjoin('business_origin as bo','bo.pkBusiness_origin','=','b.fKOrigin')
                           ->select('b.pkBusiness'
                                   ,'b.name'
                                   ,'b.image'
                                   ,'bo.name as nameOrigin'
                                   ,'c.name as category'
                                   ,'g.name as giro')
                         ->where('b.status','=',1)
                         ->where('s.status','=',1)
                         ->where('b.fkUser','=',$pkUser)
                         ->where('s.fkBusiness_status','=',3)
                         ->whereDate('b.date_register','>=',$startDate)
                         ->whereDate('b.date_register','<=',$endDate)
                        ->groupby('b.pkBusiness')
                         ->distinct()
                         ->orderby('b.date_register','desc')
                         ->get();
            }
        

        $users = DB::table('users')
                      ->select('full_name'
                              ,'pkUser')
                      ->where('status','=',1)
                      ->where('fkUser_type','!=',1)
                      ->get();

        usort($arrayQuotation,array($this, "sortFunction"));
        usort($arrayOportunity,array($this, "sortFunction"));
        usort($arraySale,array($this, "sortFunctionSale"));
           
            return view('pipeline.viewPipeline')->with('arrayInitial',$arrayInitial)
                                                ->with('arrayOportunity',$arrayOportunity)
                                                ->with('arrayQuotation',$arrayQuotation)
                                                ->with('arraySale',$arraySale)
                                                ->with('arrayPermition',$arrayPermition)
                                                ->with('totalOportunity',$totalOportunity)
                                                ->with('totalQuotation',$totalQuotation)
                                                ->with('users',$users)
                                                ->with('fkUsers',$pkUser)
                                                ->with('prospect',$prospect)
                                                ->with('totalSales',$totalSales);
        }

        public function AgentPipeline($fkUser){
                $arrayInitial    = array();
                $arrayOportunity = array();
                $arrayQuotation  = array();
                $arrayQuotationDetail = array();
                $arraySale       = array();
                $arrayPermition  = array();
                $totalOportunity = 0;
                $totalQuotation  = 0;
                $totalSales      = 0;
               // $pkUser          = Session::get("pkUser");
                
                        
               $arrayPermition["pipeline"]     = $this->UserPermits->getPermition("pipeline");
               $arrayPermition["viewQuotes"]   = $this->UserPermits->getPermition("viewQuotes");
               $arrayPermition["money"]        = $this->UserPermits->getPermition("money");
               $arrayPermition["invoice"]      = $this->UserPermits->getPermition("invoice");
               $arrayPermition["editQuotes"]   = $this->UserPermits->getPermition("editQuotes");
               $arrayPermition["changeQuotes"] = $this->UserPermits->getPermition("changeQuotes");
               $arrayPermition["deleteQuotes"] = $this->UserPermits->getPermition("deleteQuotes");
               $arrayPermition["view"]   = $this->UserPermits->getPermition("viewOpportunities");
               $arrayPermition["edit"]   = $this->UserPermits->getPermition("editOpportunities");
               $arrayPermition["change"] = $this->UserPermits->getPermition("changeOpportunities");
               $arrayPermition["delete"] = $this->UserPermits->getPermition("deleteOpportunities");
                
                if($fkUser < 0){
                        $businnes = DB::table('business as b')
                        ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                        ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                        ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                        ->leftjoin('business_origin as bo','bo.pkBusiness_origin','=','b.fKOrigin')
                        ->select('b.pkBusiness'
                                ,'b.name'
                                ,'b.image'
                                ,'bo.name as nameOrigin'
                                ,'c.name as category'
                                ,'s.fkBusiness'
                                ,'s.pkStatus_by_bussines'
                                ,'s.fkOpportunities'
                                ,'s.fkQuotations'
                                ,'s.fkBusiness_status'
                                ,'g.name as giro')
                       ->where('b.status','=',1)
                       ->where('s.status','=',1)
                       ->where('s.fkBusiness_status','!=',3)
                       ->get(); 
                }else{
                        $businnes = DB::table('business as b')
                        ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                        ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                        ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                        ->leftjoin('business_origin as bo','bo.pkBusiness_origin','=','b.fKOrigin')
                        ->select('b.pkBusiness'
                                ,'b.name'
                                ,'b.image'
                                ,'bo.name as nameOrigin'
                                ,'c.name as category'
                                ,'s.fkBusiness'
                                ,'s.pkStatus_by_bussines'
                                ,'s.fkOpportunities'
                                ,'s.fkQuotations'
                                ,'s.fkBusiness_status'
                                ,'g.name as giro')
                      ->where('b.status','=',1)
                      ->where('s.status','=',1)
                      ->where('b.fkUser','=',$fkUser)
                      ->where('s.fkBusiness_status','!=',3)
                      ->get();    
                }
        
             $arrayTest = array();
      
                 
                             foreach($businnes as $itemStatus){
                               switch ($itemStatus->fkBusiness_status) {
                                case 4:
                                        $price = 0;
                                        $infoOportunity = DB::table('opportunities as o')
                                                            ->leftjoin('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                                                            ->select('o.color'
                                                                    ,'o.icon'
                                                                    ,'o.folio'
                                                                    ,'l.text'
                                                                    ,'l.color as colorLevel'
                                                                    ,'o.number_courses'
                                                                    ,'o.number_places'
                                                                    ,'o.iva'
                                                                    ,'o.price_total'
                                                                    ,'o.register_day'
                                                                    ,'o.register_hour')
                                                            ->where('o.pkOpportunities','=',$itemStatus->fkOpportunities)
                                                            ->where('o.status','=',1)
                                                            ->orderby('register_day','desc')
                                                            ->orderby('register_hour','desc')
                                                            ->first();
                                          
                                        
                                       if(!empty($infoOportunity->folio)){     
                                         $totalOportunity = $totalOportunity + $this->helper->getPriceWithIvaQuotation($infoOportunity->price_total,$infoOportunity->iva);
                                         $price = $this->helper->getPriceWithIvaQuotation($infoOportunity->price_total,$infoOportunity->iva);
                                         
                                         
                                        $arrayOportunity[$itemStatus->pkStatus_by_bussines] = array("name" => $itemStatus->name
                                                                                                   ,"fkOpportunities" => $itemStatus->fkOpportunities
                                                                                                   ,"color"           => $infoOportunity->color
                                                                                                   ,"icon"            => $infoOportunity->icon
                                                                                                   ,"folio"           => $infoOportunity->folio
                                                                                                   ,"number_courses"  => $infoOportunity->number_places
                                                                                                   ,"price_total"     => $price
                                                                                                   ,"logo"            => $itemStatus->image
                                                                                                   ,"giro"            => $itemStatus->giro
                                                                                                   ,"register_day"    => $infoOportunity->register_day
                                                                                                   ,"register_hour"   => $infoOportunity->register_hour
                                                                                                   ,"level"           => $infoOportunity->text
                                                                                                   ,"colorLevel"      => $infoOportunity->colorLevel
                                                                                                   ,"register_day"    => $infoOportunity->register_day);
                                             }
                                          break;
                                      
                                      case 6:
                                          
                                          $infoQuotation = DB::table('quotations as o')
                                              ->leftjoin('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                                              ->leftjoin('info_facture as i','i.fkOrder','=','o.pkQuotations')
                                           ->select('o.color'
                                                   , 'o.icon'
                                                   , 'o.folio'
                                                   ,'l.text'
                                                   ,'i.pay'
                                                   ,'i.xml'
                                                   ,'i.pdf'
                                                   ,'o.withIva'
                                                   ,'o.register_hour'
                                                   ,'o.money_in_account'
                                                   ,'l.color as colorLevel'
                                                   , 'o.quotations_status as status'
                                                   ,DB::raw("(CASE WHEN quotations_status = 1 THEN 'Abierta' 
                                                           WHEN quotations_status = 2 THEN 'Rechazada'
                                                           WHEN quotations_status = 3 THEN 'Cancelada'
                                                           WHEN quotations_status = 4 THEN 'Revision'
                                                           WHEN quotations_status = 5 THEN 'Pagada'
                                                           ELSE 'N/A' END) as quotations_status")
                                                   , 'o.register_day')
                                           ->where('o.pkQuotations', '=', $itemStatus->fkQuotations)
                                           ->where(function ($query) {
                                               $query->where('o.quotations_status', '=', '1')
                                                     ->orWhere('o.quotations_status', '=', '4');
                                           })
                                           ->where('o.status', '=', 1)
                                           ->orderby('register_day','desc')
                                           ->orderby('register_hour','desc')
                                           ->first();
       
                                         // dd($itemStatus->fkQuotations);
                                       if(!empty($infoQuotation->folio)){    
                                           if($infoQuotation->quotations_status == 'Abierta'){
                                               $detialQuotation = DB::table('quotations_detail')
                                                                       ->select('fkQuotations'
                                                                               , 'number_places'
                                                                               , 'price'
                                                                               , 'isSelected'
                                                                               , 'iva'
                                                                               ,DB::raw("(CASE WHEN type = 0 THEN 'Precio Lista' 
                                                                                        WHEN type = 1 THEN 'Promocion'
                                                                                        ELSE 'N/A' END) as type")
                                                                               , 'pkQuotations_detail'
                                                                               , DB::raw("DATE_FORMAT(date, '%d/%b/%Y') as date"))
                                                                       ->where('fkQuotations', '=', $itemStatus->fkQuotations)
                                                                       ->where('status', '=', 1)
                                                                       ->orderByRaw("CAST(price AS DECIMAL(10,2)) asc")
                                                                       ->take(1)->get();
                                           }else{
                                               $detialQuotation = DB::table('quotations_detail')
                                                                       ->select('fkQuotations'
                                                                               , 'number_places'
                                                                               , 'price'
                                                                               , 'isSelected'
                                                                               , 'iva'
                                                                               ,DB::raw("(CASE WHEN type = 0 THEN 'Precio Lista' 
                                                                                        WHEN type = 1 THEN 'Promocion'
                                                                                        ELSE 'N/A' END) as type")
                                                                               , 'pkQuotations_detail'
                                                                               , DB::raw("DATE_FORMAT(date, '%d/%b/%Y') as date"))
                                                                       ->where('fkQuotations', '=', $itemStatus->fkQuotations)
                                                                       ->where('isSelected', '=', 1)
                                                                       ->where('status', '=', 1)
                                                                       ->orderByRaw("CAST(price AS DECIMAL(10,2)) asc")
                                                                       ->take(1)->get();
                                           }
                                   
                                   
                                   
                                   
                                   foreach ($detialQuotation as $infoDetail) {
                                       
                                        if ($infoQuotation->withIva) {
                                               $price = $this->helper->getPriceWithIvaQuotation($infoDetail->price, $infoDetail->iva);
                                               $totalQuotation = $totalQuotation + $this->helper->getPriceWithIvaQuotation($infoDetail->price, $infoDetail->iva);
                                           } else {
                                             $price = $infoDetail->price;
                                             $totalQuotation = $totalQuotation + $this->helper->getPriceWithIvaQuotation($infoDetail->price, $infoDetail->iva);//$totalQuotation + $infoDetail->price;   
                                           }
                                           $arrayQuotationDetail[$infoDetail->pkQuotations_detail] = array("number_places" => $infoDetail->number_places
                                                                                                     , "price" => $price
                                                                                                     , "fkQuotations" => $infoDetail->fkQuotations
                                                                                                     , "date" => $infoDetail->date
                                                                                                     , "isSelected" => $infoDetail->isSelected
                                                                                                     , "type" => $infoDetail->type);
                                   }
       
                                   $arrayQuotation[$itemStatus->fkQuotations]        = array("name"            => $itemStatus->name
                                                                                            ,"fkQuotations"    => $itemStatus->fkQuotations
                                                                                            ,"color"           => $infoQuotation->color
                                                                                            ,"icon"            => $infoQuotation->icon
                                                                                            ,"folio"           => $infoQuotation->folio
                                                                                            ,"pay"             => $infoQuotation->pay
                                                                                            ,"money_in_account"=> $infoQuotation->money_in_account
                                                                                            ,"logo"            => $itemStatus->image
                                                                                            ,"quotations_status"  => $infoQuotation->quotations_status
                                                                                            ,"register_day"    => $infoQuotation->register_day
                                                                                            ,"status"          => $infoQuotation->status
                                                                                            ,"giro"            => $itemStatus->giro
                                                                                            ,"register_day"    => $infoQuotation->register_day
                                                                                            ,"register_hour"   => $infoQuotation->register_hour
                                                                                            ,"level"           => $infoQuotation->text
                                                                                            ,"colorLevel"      => $infoQuotation->colorLevel
                                                                                            ,"detail"          => $arrayQuotationDetail);
                                       
                                      
                                        unset( $arrayQuotationDetail);
                                 }
                                          break;
                                      
                                      case 9:
                                          $price = 0;
                                          $infoQuotation = DB::table('quotations as q')
                                                            ->leftjoin('quotations_detail as d','d.fkQuotations','=','q.pkQuotations')
                                                            ->leftjoin('level_interest as l','l.pkLevel_interest','=','q.fkLevel_interest')
                                                            ->select('q.color'
                                                                    ,'q.icon'
                                                                    ,'q.folio'
                                                                    ,'l.text'
                                                                    ,'l.color as colorLevel'
                                                                    ,'q.final_date'
                                                                    , DB::raw("DATE_FORMAT(final_date, '%d/%b/%Y') as date")
                                                                    ,'d.number_places'
                                                                    ,'d.iva'
                                                                    ,'q.withIva'
                                                                    ,'d.price')
                                                            ->where('q.pkQuotations','=',$itemStatus->fkQuotations)
                                                            ->where('q.quotations_status','=',5)
                                                            ->where('q.status','=',1)
                                                            ->where('d.isSelected','=',1)
                                                            ->first();
                                           if(!empty($infoQuotation->folio)){  
                                               
                                                if ($infoQuotation->withIva) {
                                           $totalSales = $totalSales + $this->helper->getPriceWithIvaQuotation($infoQuotation->price, $infoQuotation->iva);
                                           $price = $this->helper->getPriceWithIvaQuotation($infoQuotation->price, $infoQuotation->iva);
                                       } else {
                                           $totalSales = $totalSales + $this->helper->getPriceWithIvaQuotation($infoQuotation->price, $infoQuotation->iva);//$totalSales + $infoQuotation->price;
                                           $price = $infoQuotation->price;
                                       }
       
       
       
                                       $arraySale[$itemStatus->pkStatus_by_bussines] = array("name" => $itemStatus->name
                                                                                            ,"fkQuotations"  => $itemStatus->fkQuotations
                                                                                            ,"color"         => $infoQuotation->color
                                                                                            ,"icon"          => $infoQuotation->icon
                                                                                            ,"folio"         => $infoQuotation->folio
                                                                                            ,"final_date"    => $infoQuotation->final_date
                                                                                            ,"date"          => $infoQuotation->date
                                                                                            ,"logo"          => $itemStatus->image
                                                                                            ,"giro"          => $itemStatus->giro
                                                                                            ,"level"         => $infoQuotation->text
                                                                                            ,"colorLevel"    => $infoQuotation->colorLevel
                                                                                            ,"number_places" => $infoQuotation->number_places
                                                                                            ,"price"         => $price);
                                            }
                                          break;
       
                                      default:
                                          break;
                                    }
                             }
                        
            
                             $month            = date("Y-m");
                             $aux              = date('Y-m-d', strtotime("{$month} + 1 month"));
                             $last_day         = date('Y-m-d', strtotime("{$aux} - 1 day"));
                             $startDate        = date("Y-m")."-01";
                             $endDate          = $last_day;
    
                             if($fkUser < 0){

                                $prospect = DB::table('business as b')
                                ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                                ->join('activities as a','a.fkBusiness','=','b.pkBusiness')
                                ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                                ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                                ->leftjoin('business_origin as bo','bo.pkBusiness_origin','=','b.fKOrigin')
                                ->select('b.pkBusiness'
                                        ,'b.name'
                                        ,'b.image'
                                        ,'bo.name as nameOrigin'
                                        ,'c.name as category'
                                        ,'g.name as giro')
                               ->where('b.status','=',1)
                               ->where('s.status','=',1)
                               ->where('s.fkBusiness_status','=',3)
                               ->whereDate('b.date_register','>=',$startDate)
                               ->whereDate('b.date_register','<=',$endDate)
                               ->groupby('b.pkBusiness')
                               ->distinct()
                               ->orderby('b.date_register','desc')
                               ->get(); 
                            }
                            else{
                                    
                             $prospect = DB::table('business as b')
                                           ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                                           ->join('activities as a','a.fkBusiness','=','b.pkBusiness')
                                           ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                                           ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                                           ->leftjoin('business_origin as bo','bo.pkBusiness_origin','=','b.fKOrigin')
                                           ->select('b.pkBusiness'
                                                   ,'b.name'
                                                   ,'b.image'
                                                   ,'bo.name as nameOrigin'
                                                   ,'c.name as category'
                                                   ,'g.name as giro')
                                         ->where('b.status','=',1)
                                         ->where('s.status','=',1)
                                         ->where('b.fkUser','=',$fkUser)
                                         ->where('s.fkBusiness_status','=',3)
                                         ->whereDate('b.date_register','>=',$startDate)
                                         ->whereDate('b.date_register','<=',$endDate)
                                         ->groupby('b.pkBusiness')
                                          ->distinct()
                                         ->orderby('b.date_register','desc')
                                         ->get();
                            }
                        
                
                        $users = DB::table('users')
                                      ->select('full_name'
                                              ,'pkUser')
                                      ->where('status','=',1)
                                      ->where('fkUser_type','!=',1)
                                      ->get();
                
                        usort($arrayQuotation,array($this, "sortFunction"));
                        usort($arrayOportunity,array($this, "sortFunction"));
                        usort($arraySale,array($this, "sortFunctionSale"));
               
                return view('pipeline.viewPipeline')->with('arrayInitial',$arrayInitial)
                                                    ->with('arrayOportunity',$arrayOportunity)
                                                    ->with('arrayQuotation',$arrayQuotation)
                                                    ->with('arraySale',$arraySale)
                                                    ->with('arrayPermition',$arrayPermition)
                                                    ->with('totalOportunity',$totalOportunity)
                                                    ->with('totalQuotation',$totalQuotation)
                                                    ->with('users',$users)
                                                    ->with('fkUsers',$fkUser)
                                                    ->with('prospect',$prospect)
                                                    ->with('totalSales',$totalSales);         
        }
        
        public function addOportunityModal(Request $request){
            
            $pkBussines = $request->input("pkBussines");
            
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
            
            
            $courses   = DB::table('courses')
                           ->select('pkCourses'
                                   ,'name'
                                   ,'code')
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
            
            $payment    = DB::table('payment_methods')
                             ->select('pkPayment_methods'
                                     ,'name')
                             ->where('status','=',1)
                             ->get();
            
             $bussines  = DB::table('business')
                           ->select('name'
                                   ,'pkBusiness')
                           ->where('status','=',1)
                           ->get();
             
             $Bussiness = DB::table('business as b')
                           ->join('categories as c','c.pkCategory','=','b.fkCategory')
                           ->join('commercial_business as cb','cb.pkCommercial_business','=','b.fkComercial_business')
                           ->join('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                           ->select('b.name'
                                   ,'address'
                                   ,'city'
                                   ,'state'
                                   ,'country'
                                   ,'web'
                                   ,'image'
                                   ,'mail'
                                   ,'pkBusiness'
                                   ,'c.name as category'
                                   ,'cb.name as giro'
                                   ,'o.name as origin')
                        ->where('b.status','=',1)
                        ->where('b.pkBusiness','=',$pkBussines)
                        ->first();
             
             $contact  = DB::table('contacts_by_business as c')
                          ->select('name'
                                  ,'mail'
                                  ,'area'
                                  ,'phone'
                                  ,'mobile_phone'
                                  ,'pkContact_by_business'
                                  )
                          ->where('status','=',1)
                          ->where('fkBusiness','=',$Bussiness->pkBusiness)
                          ->get();
            
               $view = view('invoice.modalCreateOportunity', array(
                    "agent"   => $agent,
                    "level"   => $level,
                    "courses" => $courses,
                    "payment" => $payment,
                    "bussines" => $bussines,
                    "Bussiness" => $Bussiness,
                    "contact" => $contact,
                    "id" => $pkBussines,
                    "companis" => $companis
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));      
        }
	
}
