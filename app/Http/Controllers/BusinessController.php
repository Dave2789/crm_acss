<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Business;
use App\Models\Contacts_by_business;
use Illuminate\Http\Request;
use App\Permissions\UserPermits;
use App\Helpers\helper;

class BusinessController extends Controller {

    private $UserPermits;
    private $helper;
    
	public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->UserPermits = new UserPermits();
            $this->helper = new helper();
        }
        
        public function businessCreateView()
        {
            $arrayPermition = array();
            $arrayPermition["viewCompany"]    = $this->UserPermits->getPermition("viewCompany");
            $arrayPermition["addCompany"]     = $this->UserPermits->getPermition("addCompany");
            $arrayPermition["editCompany"]    = $this->UserPermits->getPermition("editCompany");
            $arrayPermition["deleteCompany"]  = $this->UserPermits->getPermition("deleteCompany");
            
            $commercial_business  = DB::table("commercial_business")
                                    ->where('commercial_business.status','=',1)
                                    ->get();
            
            $categories        = DB::table("categories")
                                    ->where('categories.status','=',1)
                                    ->get();
            
            $states            = DB::table('entidad')
                                   ->select('nom_ent'
                                           ,'cve_ent')
                                   ->get();
            
            $municipality      = DB::table('municipio')
                                   ->select('nom_mun'
                                           ,'cve_mun')
                                   ->get();
            
            $origin            = DB::table('business_origin')
                                   ->get();
            
            $agent     = DB::table('users')
                           ->select('full_name'
                                   ,'pkUser')
                           ->where('status','=',1)
                           ->where('fkUser_type','!=',1)
                           ->get();
            
            
            return view('empresas.crearEmpresa')->with("states",$states)
                                                ->with("municipality",$municipality)
                                                ->with("commercial_business",$commercial_business)
                                                ->with("categories",$categories)
                                                ->with("origin",$origin)
                                                ->with("agent",$agent)
                                                ->with("arrayPermition",$arrayPermition);
        }
        
        public function getCity(Request $request){
            
            $idState  = $request->input("idState");
         
            $municipality    = DB::table('municipio')
                          ->select('cve_mun'
                                  ,'nom_mun')
                          ->where('cve_ent','=',$idState)
                          ->get();
            
               $view = view('empresas.getMunicipality', array(
                    "municipality" => $municipality,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                )); 
        }
        
        public function addbusinessDB(Request $request){
            
            $firstName          = htmlentities ($request->input("firstName"));
            $domicilio          = htmlentities ($request->input("domicilio"));
            $city               = $request->input("city");
            $state              = $request->input("state");
            $country            = $request->input("country");
            $email              = $request->input("email");
            $giro               = $request->input("giro");
            $cat                = $request->input("cat");
            $web                = $request->input("web");
            $rfc                = $request->input("rfc");
            $phoneBussines      = $request->input("phoneBussines");
            $propierty          = $request->input("propierty");
            $origen             = htmlentities ($request->input("origen"));
            $image              = $request->file('image');
            $user               = Session::get('pkUser');
            $arrayContacts      = json_decode($request->input('arrayContacts'));
            $date               = date("Y-m-d");
            $flag               = "true";
            $message            = "true";
            DB::beginTransaction();
             
            try { 
                if($image != ''){ 
                    if(file_exists ($image)){
                        $nameFile = $image->getClientOriginalName();
                        if($nameFile!=''){
                            $ext            = $image->extension();
                            
                            if(($ext == 'png') ||($ext == 'jpg')||($ext == 'jpeg')){
                                
                                $insertBusiness                       = new Business;
                                $insertBusiness->rfc                  = $rfc;
                                $insertBusiness->name                 = $firstName;
                                $insertBusiness->mail                 = $email;
                                $insertBusiness->address              = $domicilio;
                                $insertBusiness->number               = 1;
                                $insertBusiness->postal_code          = 1;
                                $insertBusiness->city                 = $city;
                                $insertBusiness->state                = $state;
                                $insertBusiness->country              = $country;
                                $insertBusiness->web                  = $web;
                                $insertBusiness->phone                = $phoneBussines;
                                $insertBusiness->mobile_phone         = '';
                                $insertBusiness->fkComercial_business = $giro;
                                $insertBusiness->fkCategory           = $cat;
                                $insertBusiness->fkUser               = $propierty;
                                $insertBusiness->fKOrigin             = $origen;
                                $insertBusiness->image                = '';
                                $insertBusiness->fkBusiness_type      = 1;
                                $insertBusiness->fkBusiness_status    = 1;
                                $insertBusiness->is_active            = 1;
                                $insertBusiness->date_register        = $date;
                                $insertBusiness->stateType            = 1;
                                $insertBusiness->status               = 1;
                                
                                if($insertBusiness->save()){
                                    
                                    $destinationPath = $_SERVER['DOCUMENT_ROOT'].'/images/business/';
                                    $image->move($destinationPath, 'business'.$insertBusiness->rfc.'.'.$ext);
                                   
                                
                                    $fileUpdate         = DB::table('business')
                                                                ->where('pkBusiness','=',$insertBusiness->pkBusiness)
                                                                ->where('status','=',1)
                                                                ->update(array("image" => 'business'.$insertBusiness->rfc.'.'.$ext));
                                    
                                    if($fileUpdate > 0){     
                                        
                                    }else{
                                     $flag = "false";   
                                    }
                                   // return $arrayContacts;
                                    foreach($arrayContacts as $item){
                                    
                                       $insertContacts                = new Contacts_by_business;
                                       $insertContacts->fkBusiness    = $insertBusiness->pkBusiness;
                                       $insertContacts->name          = $item[0];
                                       $insertContacts->mail          = $item[2];
                                       $insertContacts->area          = $item[1];
                                       $insertContacts->phone         = $item[3];
                                       $insertContacts->extension     = $item[4];
                                       $insertContacts->mobile_phone  = $item[5];
                                       $insertContacts->status        = 1;
                                       
                                        if($insertContacts->save()){
                                        }else{
                                         $flag         = "false";  
                                          $message    .= "Error al crear registro contactos \n";
                                        }
                                     
                                    }
                                }else{
                                    $flag           = "false";
                                    $message    .= "Error al crear registro \n";
                                }
                            }
                        }
                    }
                }
                else{
                                $insertBusiness                       = new Business;
                                $insertBusiness->rfc                  = $rfc;
                                $insertBusiness->name                 = $firstName;
                                $insertBusiness->mail                 = $email;
                                $insertBusiness->address              = $domicilio;
                                $insertBusiness->number               = 1;
                                $insertBusiness->postal_code          = 1;
                                $insertBusiness->city                 = $city;
                                $insertBusiness->state                = $state;
                                $insertBusiness->country              = $country;
                                $insertBusiness->web                  = $web;
                                $insertBusiness->phone                = $phoneBussines;
                                $insertBusiness->mobile_phone         = '';
                                $insertBusiness->fkComercial_business = $giro;
                                $insertBusiness->fkCategory           = $cat;
                                $insertBusiness->fkUser               = $propierty;
                                $insertBusiness->fKOrigin             = $origen;
                                $insertBusiness->image                = '';
                                $insertBusiness->fkBusiness_type      = 1;
                                $insertBusiness->fkBusiness_status    = 1;
                                $insertBusiness->is_active            = 1;
                                $insertBusiness->date_register        = $date;
                                $insertBusiness->stateType            = 1;
                                $insertBusiness->status               = 1;
                                
                                if($insertBusiness->save()){
                                 foreach($arrayContacts as $item){
                                    
                                       $insertContacts                = new Contacts_by_business;
                                       $insertContacts->fkBusiness    = $insertBusiness->pkBusiness;
                                       $insertContacts->name          = $item[0];
                                       $insertContacts->mail          = $item[2];
                                       $insertContacts->area          = $item[1];
                                       $insertContacts->phone         = $item[3];
                                       $insertContacts->extension     = $item[4];
                                       $insertContacts->mobile_phone  = $item[5];
                                       $insertContacts->status        = 1;
                                       
                                        if($insertContacts->save()){
                                        }else{
                                         $flag         = "false";  
                                          $message    .= "Error al crear registro contactos \n";
                                        }
                                     
                                    }
                               
                                } else{
                                    $flag           = "false";
                                    $message    .= "Error al crear registro \n";
                                }
                }
                
                if($flag == "true"){
                    DB::commit();
                   return \Response::json(array(
                                  "valid"       => $message,
                                  "id"        => $insertBusiness->pkBusiness
                                ));   
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
        
        public function viewBussines(){
            
            $arrayPermition = array();
            $arrayPermition["viewCompany"]    = $this->UserPermits->getPermition("viewCompany");
            $arrayPermition["addCompany"]     = $this->UserPermits->getPermition("addCompany");
            $arrayPermition["editCompany"]    = $this->UserPermits->getPermition("editCompany");
            $arrayPermition["deleteCompany"]  = $this->UserPermits->getPermition("deleteCompany");

            $type = array();
            $activities = array();
    
            $bussines = DB::table('business as b')
            ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
           ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
           ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
           ->select('b.pkBusiness'
                   ,'b.name'
                   ,'o.name as fKOrigin'
                   ,'c.name as category'
                   ,'g.name as giro'
                   ,'b.stateType'
                   ,'b.date_register'
                   ,'b.status'
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                         ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 3) as initial')
                                        ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND (s.fkBusiness_status = 4 OR s.fkBusiness_status = 6)) as leds')
                                     ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 9) as client')
                                         ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.quotations_status = 2) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 1 OR q.quotations_status = 4)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 2) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 1) as oportunityOpen'))
           ->where('b.status','=',1)
        //   ->groupby('b.pkBusiness')
          // ->distinct()
           ->orderby('b.name','asc')
           ->paginate(30);

           foreach($bussines as $bussinesInfo){
              $activitiesInfo = DB::table('activities as a')
                              ->select('a.execution_date')
                              ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                              ->where('a.status','=',1)
                              ->whereNotNull('a.execution_date')
                              ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                              ->where('t.pkActivities_type','>',0)
                              ->orderby('pkActivities','desc')
                              ->first();

           if(!empty($activitiesInfo->execution_date)){
              $activities[$bussinesInfo->pkBusiness]["lastActivity"] = $activitiesInfo->execution_date;
           }
               $activitiesNext = DB::table('activities as a')
                              ->select('a.description'
                                      ,'a.final_date')
                              ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                              ->where('a.status','=',1)
                              ->whereNull('a.execution_date')
                              ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                              ->where('t.pkActivities_type','>',0)
                              ->orderby('pkActivities','desc')
                              ->first();
           if(!empty($activitiesNext->description)){

              $activities[$bussinesInfo->pkBusiness]["nextActivity"] = $activitiesNext->description;

              $activities[$bussinesInfo->pkBusiness]["finalActivity"] = $activitiesNext->final_date;
           }

           }
         
          $month = date("m");
          $year  = date("Y");
          $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
          
          $monthInitial = $year.'-'.$month.'-01';
          $monthFinish  = $year.'-'.$month.'-'.$numDaysMonth;
        
          $BussinessAddRes = DB::table('business as b')
                       ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
                               ,DB::raw("DATE_FORMAT(date_register, '%d/%m/%Y') as date")
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 3) as initial')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND (s.fkBusiness_status = 4 OR s.fkBusiness_status = 6)) as leds')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 9) as client')
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesMont')
                               )
                        ->where('b.status','=',1)
                        ->whereDate('date_register', '>=', $monthInitial)
                        ->whereDate('date_register', '<=', $monthFinish)
                        ->orderby('b.date_register','DESC')
                        ->get();
          
     
           $BussinessMoreRes = DB::table('business as b')
                       ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
                               ,DB::raw("DATE_FORMAT(date_register, '%d/%m/%Y') as date")
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'                 
                                         . ' AND (final_date >= "'.$monthInitial.'" and final_date <= "'.$monthFinish.'")'
                                         . ' AND q.quotations_status = 5) as salesMont')
                               )
                        ->where('b.status','=',1)
                        ->orderby('b.date_register','DESC')
                        ->get();
           
           $bussinesMoreTotal = 0;
           
           foreach($BussinessMoreRes as $BussinessMoreResInfo){
               
              $bussinesMoreTotal = $bussinesMoreTotal + $BussinessMoreResInfo->salesMont;
           }
           
                
                $giros = DB::table('commercial_business')
                           ->select('pkCommercial_business'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();
                
                $campanias = DB::table('commercial_campaigns')
                           ->select('pkCommercial_campaigns'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();
                 
        return view('empresas.verEmpresas')->with('bussines',$bussines)
                                           ->with('giros',$giros)
                                           ->with('campanias',$campanias)
                                           ->with('BussinessAddRes',$BussinessAddRes)
                                           ->with('BussinessMoreRes',$BussinessMoreRes)
                                           ->with("arrayPermition",$arrayPermition)
                                           ->with("bussinesMoreTotal",$bussinesMoreTotal)
                                           ->with("activities",$activities);
    }
    
        public function viewBussinesProspect(){
            //set_time_limit(15000);
            
            $arrayPermition = array();
            $arrayPermition["viewCompany"]    = $this->UserPermits->getPermition("viewCompany");
            $arrayPermition["addCompany"]     = $this->UserPermits->getPermition("addCompany");
            $arrayPermition["editCompany"]    = $this->UserPermits->getPermition("editCompany");
            $arrayPermition["deleteCompany"]  = $this->UserPermits->getPermition("deleteCompany");
          
            $activities = array();
            $infoQuotation = array();

          $bussines = DB::table('business as b')
                        ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                       )
                                ->where('s.fkBusiness_status', '=', '3')
                                    
                       ->where('b.status','=',1)
                       ->where('s.pkStatus_by_bussines','<',2500)
                       ->where('s.status', '=', 1)
                       ->groupby('b.pkBusiness')
                    //   ->distinct()
                       ->orderby('b.name','asc')
                       
                       ->paginate(100);

                       foreach($bussines as $bussinesInfo){
                        $activitiesInfo = DB::table('activities as a')
                                        ->select('a.execution_date')
                                        ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                                        ->where('a.status','=',1)
                                        ->whereNotNull('a.execution_date')
                                        ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                                        ->where('t.pkActivities_type','>',0)
                                        ->orderby('pkActivities','desc')
                                        ->first(); 
          
                     if(!empty($activitiesInfo->execution_date)){
                        $activities[$bussinesInfo->pkBusiness]["lastActivity"] = $activitiesInfo->execution_date;
                     }
                         $activitiesNext = DB::table('activities as a')
                                        ->select('a.description'
                                                ,'a.final_date')
                                        ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                                        ->where('a.status','=',1)
                                        ->whereNull('a.execution_date')
                                        ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                                        ->where('t.pkActivities_type','>',0)
                                        ->orderby('pkActivities','desc')
                                        ->first();
                     if(!empty($activitiesNext->description)){
          
                        $activities[$bussinesInfo->pkBusiness]["nextActivity"] = $activitiesNext->description;
          
                        $activities[$bussinesInfo->pkBusiness]["finalActivity"] = $activitiesNext->final_date;
                     } 

                     $quotationSales = DB::table('quotations')
                                    ->where('status','=',1)
                                    ->where('quotations_status','=',5)
                                    ->where('fkBusiness','=',$bussinesInfo->pkBusiness)
                                    ->count();


                      $quotationSalesLoss = DB::table('quotations')
                                    ->where('status','=',1)
                                    ->where('quotations_status','=',3)
                                    ->where('fkBusiness','=',$bussinesInfo->pkBusiness)
                                    ->count();

                      $quotation = DB::table('quotations')
                                    ->where('status','=',1)
                                    ->where('quotations_status','=',1)
                                    ->where('fkBusiness','=',$bussinesInfo->pkBusiness)
                                    ->count();
                      
                      $oportunityAproved = DB::table('opportunities')
                                    ->where('status','=',1)
                                    ->where('opportunities_status','=',5)
                                    ->where('fkBusiness','=',$bussinesInfo->pkBusiness)
                                    ->count();

                      $oportunityLoss = DB::table('opportunities')
                                    ->where('status','=',1)
                                    ->where('opportunities_status','=',3)
                                    ->where('fkBusiness','=',$bussinesInfo->pkBusiness)
                                    ->count();

                      $oportunityOpen = DB::table('opportunities')
                                    ->where('status','=',1)
                                    ->where('opportunities_status','=',1)
                                    ->where('fkBusiness','=',$bussinesInfo->pkBusiness)
                                    ->count();

                     $infoQuotation[$bussinesInfo->pkBusiness]["salesPay"] = $quotationSales;
                     $infoQuotation[$bussinesInfo->pkBusiness]["salesLoss"] = $quotationSalesLoss;
                     $infoQuotation[$bussinesInfo->pkBusiness]["quotations"] = $quotation;
                     $infoQuotation[$bussinesInfo->pkBusiness]["oportunityAproved"] = $oportunityAproved;
                     $infoQuotation[$bussinesInfo->pkBusiness]["oportunityLoss"] = $oportunityLoss;
                     $infoQuotation[$bussinesInfo->pkBusiness]["oportunityOpen"] = $oportunityOpen;
                     }     

          
            $giros = DB::table('commercial_business')
                           ->select('pkCommercial_business'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();
                
                $campanias = DB::table('commercial_campaigns')
                           ->select('pkCommercial_campaigns'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();

                 
        return view('empresas.verEmpresasProspecto')->with('bussines',$bussines)
                                                    ->with('campanias',$campanias)
                                                    ->with('giros',$giros)
                                                    ->with('infoQuotation',$infoQuotation)
                                                    ->with("arrayPermition",$arrayPermition)
                                                    ->with("activities",$activities);
       }
       
        public function verEmpresasCliente(){
            
             $arrayPermition = array();
            $arrayPermition["viewCompany"]    = $this->UserPermits->getPermition("viewCompany");
            $arrayPermition["addCompany"]     = $this->UserPermits->getPermition("addCompany");
            $arrayPermition["editCompany"]    = $this->UserPermits->getPermition("editCompany");
            $arrayPermition["deleteCompany"]  = $this->UserPermits->getPermition("deleteCompany");

            $activities = array();
            
           $bussines = DB::table('business as b')
                       ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
                              
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 3)) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 2 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 4 OR q.opportunities_status = 3)) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 1 OR q.opportunities_status = 2)) as oportunityOpen')
                                             
                               )
                       ->where(function($query) {
                                        $query->where('s.fkBusiness_status', '=', '9')
                                              ->where('s.status', '=', 1);
                                    })
                       ->where('b.status','=',1)
                     ->groupby('b.pkBusiness')
                      // ->distinct()
                       ->orderby('b.name','asc')
                       ->paginate(30);

                         foreach($bussines as $bussinesInfo){

              $activitiesInfo = DB::table('activities as a')
                              ->select('a.execution_date')
                              ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                              ->where('a.status','=',1)
                              ->whereNotNull('a.execution_date')
                              ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                              ->where('t.pkActivities_type','>',0)
                              ->orderby('pkActivities','desc')
                              ->first();

           if(!empty($activitiesInfo->execution_date)){
              $activities[$bussinesInfo->pkBusiness]["lastActivity"] = $activitiesInfo->execution_date;
           }
               $activitiesNext = DB::table('activities as a')
                              ->select('a.description'
                                      ,'a.final_date')
                              ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                              ->where('a.status','=',1)
                              ->whereNull('a.execution_date')
                              ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                              ->where('t.pkActivities_type','>',0)
                              ->orderby('pkActivities','desc')
                              ->first();

           if(!empty($activitiesNext->description)){

              $activities[$bussinesInfo->pkBusiness]["nextActivity"] = $activitiesNext->description;

              $activities[$bussinesInfo->pkBusiness]["finalActivity"] = $activitiesNext->final_date;
           }

           }
      

            $giros = DB::table('commercial_business')
                           ->select('pkCommercial_business'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();
                
                $campanias = DB::table('commercial_campaigns')
                           ->select('pkCommercial_campaigns'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();
                 
        return view('empresas.verEmpresasCliente')->with('bussines',$bussines)
                                                  ->with('giros',$giros)
                                                  ->with('campanias',$campanias)
                                                  ->with("arrayPermition",$arrayPermition)
                                                  ->with("activities",$activities);
       }
       
        public function verEmpresasLeads(){
            
             $arrayPermition = array();
            $arrayPermition["viewCompany"]    = $this->UserPermits->getPermition("viewCompany");
            $arrayPermition["addCompany"]     = $this->UserPermits->getPermition("addCompany");
            $arrayPermition["editCompany"]    = $this->UserPermits->getPermition("editCompany");
            $arrayPermition["deleteCompany"]  = $this->UserPermits->getPermition("deleteCompany");

            $activities = array();
            
          $bussines = DB::table('business as b')
                       ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
                            
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 3)) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 2 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 4 OR q.opportunities_status = 3)) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 1 OR q.opportunities_status = 2)) as oportunityOpen')
                                             
                               )
                                ->where(function($query) {
                                        $query->where('s.fkBusiness_status', '=', '4')
                                              ->orwhere('s.fkBusiness_status', '=', '6');
                                    })
                       ->where('s.status', '=', 1)
                       ->where('b.status','=',1)
                    //   ->groupby('b.pkBusiness')
                      // ->distinct()
                       ->orderby('b.name','asc')
                       ->paginate(30);

                       foreach($bussines as $bussinesInfo){
                        $activitiesInfo = DB::table('activities as a')
                                        ->select('a.execution_date')
                                        ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                                        ->where('a.status','=',1)
                                        ->whereNotNull('a.execution_date')
                                        ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                                        ->where('t.pkActivities_type','>',0)
                                        ->orderby('pkActivities','desc')
                                        ->first();
          
                     if(!empty($activitiesInfo->execution_date)){
                        $activities[$bussinesInfo->pkBusiness]["lastActivity"] = $activitiesInfo->execution_date;
                     }
                         $activitiesNext = DB::table('activities as a')
                                        ->select('a.description'
                                                ,'a.final_date')
                                        ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                                        ->where('a.status','=',1)
                                        ->whereNull('a.execution_date')
                                        ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                                        ->where('t.pkActivities_type','>',0)
                                        ->orderby('pkActivities','desc')
                                        ->first();
                     if(!empty($activitiesNext->description)){
          
                        $activities[$bussinesInfo->pkBusiness]["nextActivity"] = $activitiesNext->description;
          
                        $activities[$bussinesInfo->pkBusiness]["finalActivity"] = $activitiesNext->final_date;
                     }
          
                     }
           
         $giros = DB::table('commercial_business')
                           ->select('pkCommercial_business'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();
                
                $campanias = DB::table('commercial_campaigns')
                           ->select('pkCommercial_campaigns'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();
                 
        return view('empresas.verEmpresasLeads')->with('bussines',$bussines)
                                                ->with('giros',$giros)
                                                ->with('campanias',$campanias)
                                                ->with("arrayPermition",$arrayPermition)
                                                ->with("activities",$activities);
       }
    
        public function deleteBusiness(Request $request){
        $pkBusiness         = $request->input("pkBusiness");
            
            $categoriesUpdate   = DB::table("business")
                                    ->where('pkBusiness','=',$pkBusiness)
                                    ->where('status','=',1)
                                    ->update(array("status" => 0));
            
            if($categoriesUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
    }
    
        public function viewupdateBusiness(Request $request){
           $pkBusiness         = $request->input("pkBusiness");
           
            $agent     = DB::table('users')
                           ->select('full_name'
                                   ,'pkUser')
                           ->where('status','=',1)
                           ->where('fkUser_type','!=',1)
                           ->get();
            
            $Bussines   = DB::table('business')
                            ->select('pkBusiness'
                                    ,'rfc'
                                    ,'name'
                                    ,'mail'
                                    ,'address'
                                    ,'city'
                                    ,'state'
                                    ,'country'
                                    ,'fkComercial_business'
                                    ,'fkCategory'
                                    ,'fkUser'
                                    ,'fKOrigin'
                                    ,'phone'
                                    ,'image'
                                    ,'web'
                                    ,'fkBusiness_type'
                                    ,'fkBusiness_status'
                                    ,'is_active'
                                    ,'date_register'
                                    ,'stateType')
                              ->where('pkBusiness','=',$pkBusiness)
                              ->where('status','=',1) 
                              ->first();
            
    
            $commercial_business  = DB::table("commercial_business")
                                    ->where('commercial_business.status','=',1)
                                    ->get();
            
            $categories        = DB::table("categories")
                                    ->where('categories.status','=',1)
                                    ->get();
            
            $states            = DB::table('entidad')
                                   ->select('nom_ent'
                                           ,'cve_ent')
                                   ->get();
            
            $municipality      = DB::table('municipio')
                                   ->select('nom_mun'
                                           ,'cve_mun')
                                   ->where('cve_ent','=',$Bussines->state)
                                   ->get();
            
            $origin            = DB::table('business_origin')
                                   ->get();

              $view = view('empresas.editarEmpresa', array(
                    "Bussines"            => $Bussines,
                    "commercial_business" => $commercial_business,
                    "categories"          => $categories,
                    "states"              => $states,
                    "municipality"        => $municipality,
                    "origin"              => $origin,
                    "agent"               => $agent
                        ))->render();
                  
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));            
            
        }
        
        public function editupdateBusiness(Request $request){
            $firstName          = htmlentities ($request->input("firstName"));
            $domicilio          = htmlentities ($request->input("domicilio"));
            $city               = $request->input("city");
            $state              = $request->input("state");
            $country            = $request->input("country");
            $email              = $request->input("email");
            $giro               = $request->input("giro");
            $cat                = $request->input("cat");
            $web                = $request->input("web");
            $rfc                = $request->input("rfc");
            $phoneBussines      = $request->input("phoneBussines");
            $propierty          = $request->input("propierty");
            $origen             = htmlentities ($request->input("origen"));
            $image              = $request->file('image');
            $user               = Session::get('pkUser');
            $pkBusiness         = $request->input('pkBusiness');
            $flag               = "true";
          
            DB::beginTransaction();

            $propertyActual = DB::table('business')
                                ->select('fkUser')
                                ->where('pkBusiness','=',$pkBusiness)
                                ->first();
            try { 
                if($image != ''){ 
                    if(file_exists ($image)){
                        $nameFile = $image->getClientOriginalName();
                        if($nameFile!=''){
                            $ext            = $image->extension();
                            
                            if(($ext == 'png') ||($ext == 'jpg')||($ext == 'jpeg')){
                               
                                   $destinationPath = $_SERVER['DOCUMENT_ROOT'].'/images/business/';
                                    $image->move($destinationPath, 'businessupdate'.$nameFile.'.'.$ext);
                                
                                    $fileUpdate         = DB::table('business')
                                                                ->where('pkBusiness','=',$pkBusiness)
                                                                ->where('status','=',1) 
                                                                ->update(["image" => 'businessupdate'.$nameFile.'.'.$ext
                                                                              ,"rfc"     => $rfc
                                                                              ,"name"    => $firstName
                                                                              ,"mail"    => $email
                                                                              ,"address" => $domicilio
                                                                              ,"web" => $web
                                                                              ,"phone" => $phoneBussines
                                                                              ,"city" => $city
                                                                              ,"fkUser" => $propierty
                                                                              ,"country"     =>$country
                                                                              ,"state" => $state
                                                                              ,"fkComercial_business" => $giro
                                                                              ,"fkCategory" => $cat
                                                                              ,"fKOrigin" =>  $origen]);
                                    
       
                                    
                                    if($fileUpdate >= 1){     
                                        
                                    }else{
                                     $flag = "false1";   
                                    }
 
                                }else{

                                }
                            }
                        }
                    }else{
                
                          $fileUpdate2         = DB::table('business')
                                                                ->where('pkBusiness','=',$pkBusiness)
                                                                ->where('status','=',1)
                                                                ->update(["rfc"     => $rfc
                                                                              ,"name"    => $firstName
                                                                              ,"mail"    => $email
                                                                              ,"address" => $domicilio
                                                                              ,"web" => $web
                                                                              ,"phone" => $phoneBussines
                                                                              ,"city" => $city
                                                                              ,"fkUser" => $propierty
                                                                              ,"country"     =>$country
                                                                              ,"state" => $state
                                                                              ,"fkComercial_business" => $giro
                                                                              ,"fkCategory" => $cat
                                                                              ,"fKOrigin" =>  $origen]);
                                    
                                    if($fileUpdate2 > 0){     
                                    }else{
                                     $flag = "false2";   
                                    }
                    }

                if($propertyActual->fkUser != $propierty){
                  $UpdateOportunity  = DB::table('opportunities')
                                     ->where('fkBusiness','=',$pkBusiness)
                                     ->where('status','=',1)
                                     ->where('opportunities_status','=',1)
                                     ->update(["fkUser"     => $propierty]);

                  if($UpdateOportunity >= 1){

                  }else{
                    $flag == "false";
                  }

                 $UpdateQuotation  = DB::table('quotations')
                                     ->where('fkBusiness','=',$pkBusiness)
                                     ->where('status','=',1)
                                     ->where('quotations_status','=',1)
                                     ->update(["fkUser"     => $propierty]);

                if($UpdateQuotation >= 1){

                                    }else{
                                      $flag == "false";
                                    }

                 $UpdateQuotation2  = DB::table('quotations')
                                     ->where('fkBusiness','=',$pkBusiness)
                                     ->where('status','=',1)
                                     ->where('quotations_status','=',4)
                                     ->update(["fkUser"     => $propierty]);

                  if($UpdateQuotation2 >= 1){

                                    }else{
                                      $flag == "false";
                                    }
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
        
        public function viewBusinessContact(Request $request){
           $pkBusiness         = $request->input("pkBusiness");
           
        $bussinesContact   = DB::table('contacts_by_business')
                            ->select('pkContact_by_business'
                                    ,'fkBusiness'
                                    ,'name'
                                    ,'pkContact_by_business'
                                    ,'mail'
                                    ,'area'
                                    ,'phone'
                                    ,'extension'
                                    ,'mobile_phone')
                              ->where('fkBusiness','=',$pkBusiness)
                              ->where('status','=',1)
                              ->get();
        
            $busssines    =  DB::table('business')
                               ->select('name'
                                       ,'pkBusiness')
                               ->where('pkBusiness','=',$pkBusiness)
                               ->first();
          

              $view = view('empresas.verContactos', array(
                    "bussinesContact"  => $bussinesContact,
                    "busssines"        => $busssines,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));           
        }
        
        public function deleteBusinessContact(Request $request){
            
            $pkContact         = $request->input("pkContact");
            
            $categoriesUpdate   = DB::table("contacts_by_business")
                                    ->where('pkContact_by_business','=',$pkContact)
                                    ->where('status','=',1)
                                    ->update(array("status" => 0));
            
            if($categoriesUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function addContactBusinessDB(Request $request){

            $arrayContacts      = json_decode($request->input('arrayContacts'));
            $pkBussiness        = $request->input('pkBussiness');
            $flag               = "true";
            $message            = "true";
            DB::beginTransaction();
             
            try { 
                                    foreach($arrayContacts as $item){
                                    
                                       $insertContacts                = new Contacts_by_business;
                                       $insertContacts->fkBusiness    = $pkBussiness;
                                       $insertContacts->name          = $item[0];
                                       $insertContacts->mail          = $item[2];
                                       $insertContacts->area          = $item[1];
                                       $insertContacts->extension     = $item[4];
                                       $insertContacts->phone         = $item[3];
                                       $insertContacts->mobile_phone  = $item[5];
                                       $insertContacts->status        = 1;
                                       
                                        if($insertContacts->save()){
                                        }else{
                                         $flag         = "false";  
                                          $message    .= "Error al crear registro contactos \n";
                                        }
                                     
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
       
        public function detEmpresa($id)
        {
            $arrayPermition = array();
            $oportunity     = array();
            
            $montWithIva = [];
            $arrayPermition["view"]         = $this->UserPermits->getPermition("viewOpportunities");
            $arrayPermition["edit"]         = $this->UserPermits->getPermition("editOpportunities");
            $arrayPermition["change"]       = $this->UserPermits->getPermition("changeOpportunities");
            $arrayPermition["delete"]       = $this->UserPermits->getPermition("deleteOpportunities");
            $arrayPermition["viewQuotes"]   = $this->UserPermits->getPermition("viewQuotes");
            $arrayPermition["money"]        = $this->UserPermits->getPermition("money");
            $arrayPermition["invoice"]      = $this->UserPermits->getPermition("invoice");
            $arrayPermition["editQuotes"]   = $this->UserPermits->getPermition("editQuotes");
            $arrayPermition["changeQuotes"] = $this->UserPermits->getPermition("changeQuotes");
            $arrayPermition["deleteQuotes"] = $this->UserPermits->getPermition("deleteQuotes");
            $arrayPermition["viewJob"]      = $this->UserPermits->getPermition("viewJob");
            $arrayPermition["finishJob"]    = $this->UserPermits->getPermition("finishJob");
            $arrayPermition["editJob"]      = $this->UserPermits->getPermition("editJob");
            $arrayPermition["deleteJob"]    = $this->UserPermits->getPermition("deleteJob");
            
            $montArray = array();
            $Bussiness = DB::table('business as b')
                           ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                           ->leftjoin('commercial_business as cb','cb.pkCommercial_business','=','b.fkComercial_business')
                           ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                           ->leftjoin('users as u','u.pkUser','=','b.fkUser')
                           ->select('b.name'
                                   ,'address'
                                   ,'city'
                                   ,'state'
                                   ,'country'
                                   ,'web'
                                   ,'b.phone'
                                   ,'b.image'
                                   ,'b.mail'
                                   ,'rfc'
                                   ,'u.full_name'
                                   ,'pkBusiness'
                                   ,'b.status'
                                   ,'c.name as category'
                                   ,'cb.name as giro'
                                   ,'o.name as origin')
                        //->where('b.status','=',1)
                        ->where('b.pkBusiness','=',$id)
                        ->first();
            
            
            $contact  = DB::table('contacts_by_business as c')
                          ->select('name'
                                  ,'mail'
                                  ,'area'
                                  ,'phone'
                                  ,'extension'
                                  ,'mobile_phone'
                                  ,'pkContact_by_business'
                                  )
                          ->where('status','=',1)
                          ->where('fkBusiness','=',$Bussiness->pkBusiness)
                          ->get();
            
            $campaning = DB::table('commercial_campaigns as c')
                           ->join('business_by_commercial_campaigns as d','d.fkCommercial_campaigns','=','c.pkCommercial_campaigns')
                           ->select('c.name')
                           ->where('c.status','=',1)
                           ->where('d.status','=',1)
                           ->where('d.fkBusiness','=',$Bussiness->pkBusiness)
                           ->get();
            
              $quotation = DB::table('quotations as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->leftjoin('users as u','u.pkUser','=','o.fkUser')
                            ->leftjoin('users as a','a.pkUser','=','o.asing')
                            ->leftjoin('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->leftjoin('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->leftjoin('info_facture as f','f.fkOrder','=','o.pkQuotations')
                            ->select('o.pkQuotations'
                                    ,'o.name'
                                    ,'f.pdf'
                                    ,'f.xml'
                                    ,'o.folio'
                                    ,'o.quotations_status as statusQ'
                                    ,'b.name as bussines'
                                    ,'b.image as image'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'b.country'
                                    ,'b.state'
                                    ,'b.pkBusiness'
                                    ,'o.final_date'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'a.full_name as asing'
                                    ,'o.withIva'
                                    ,'o.money_in_account'
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
                                                    WHEN o.quotations_status = 2 THEN 'Rechazada'
                                                    WHEN o.quotations_status = 3 THEN 'Cancelada'
                                                    WHEN o.quotations_status = 4 THEN 'Revision'
                                                    WHEN o.quotations_status = 5 THEN 'Pagada'
                                                    ELSE 'N/A' END) as quotations_status")
                                     ,DB::raw('(SELECT pdf'
                                         . ' FROM info_facture as i'
                                         . ' WHERE i.status = 1'
                                         . ' AND i.fkOrder = o.pkQuotations'
                                         . ' ORDER BY pkInfoFacture desc limit 1) as pdf')
                                    ,DB::raw('(SELECT xml'
                                         . ' FROM info_facture as i'
                                         . ' WHERE i.status = 1'
                                         . ' AND i.fkOrder = o.pkQuotations'
                                         . ' ORDER BY pkInfoFacture desc limit 1) as xml')
                                    ,DB::raw('(SELECT pay'
                                         . ' FROM info_facture as i'
                                         . ' WHERE i.status = 1'
                                         . ' AND i.fkOrder = o.pkQuotations'
                                         . ' ORDER BY pkInfoFacture desc limit 1) as pay'))
                            ->where('o.status','=',1)
                            ->where('b.status','=',1)
                            ->where('o.fkBusiness','=',$Bussiness->pkBusiness)
                            ->orderby('register_day','desc')
                            ->orderby('register_hour','desc')
                            ->get();
                  $coursesQuotation = array();
               foreach($quotation as $item){
               
             
                       
               $mont = DB::table('quotations_detail')
                         ->select('price'
                                 ,'pkQuotations_detail'
                                 ,'type'
                                 ,'iva'
                                 ,'isSelected')
                         ->where('fkQuotations','=',$item->pkQuotations)
                         ->where('status','=',1)
                         ->get();
               
               $montArray[$item->pkQuotations]["status"] = $item->statusQ;
             
               foreach($mont as $montInfo){
                   
                   if($montInfo->type == 0){
                       $type = "Lista";
                   }else{
                       $type = "Promocion";
                   }
                   
                if($item->withIva){
                  $price = $this->helper->getPriceWithIvaQuotation($montInfo->price,$montInfo->iva);
                   }else{
                   $price = $montInfo->price;     
                   }
               
              
                  $montArray[$item->pkQuotations]["price"][$montInfo->pkQuotations_detail] = array("price"      => $price
                                                                                                  ,"isSelected" => $montInfo->isSelected
                                                                                                  ,"num"        => $montInfo->pkQuotations_detail
                                                                                                  ,"type"      => $type);
                  
                  foreach($montInfo as $detailQuotation){
                      
                      $courses = DB::table('quotation_by_courses as o')
                                   ->leftjoin('courses as c','c.pkCourses','=','o.fkCourses')
                                   ->select('c.name as course'
                                      ,'c.code as code'
                                      ,'o.price'
                                      ,'o.fkQuotationDetail'
                                      ,'o.places'
                                      ,'o.pk_quotation_by_courses')
                                   ->where('o.status','=',1)
                                   ->where('o.fkQuotationDetail','=',$montInfo->pkQuotations_detail)
                                   ->get();
                      
                       foreach($courses as $itemDetail){
                       if($itemDetail->price > 0 && $item->withIva == 1){
                      $coursesQuotation[$item->pkQuotations][$montInfo->pkQuotations_detail][$itemDetail->pk_quotation_by_courses] = array("course"    => $itemDetail->code." - ".$itemDetail->course
                                                                   ,"price"     => $this->helper->getPriceWithIvaQuotation($itemDetail->price,$montInfo->iva)
                                                                   ,"qtyPlaces" => $itemDetail->places
                                                                   ,"type" => $montInfo->type
                                                                   ,"num" => $itemDetail->fkQuotationDetail);
                      }else{
                      $coursesQuotation[$item->pkQuotations][$montInfo->pkQuotations_detail][$itemDetail->pk_quotation_by_courses] = array("course"    => $itemDetail->code." - ".$itemDetail->course
                                                                   ,"price"     => $itemDetail->price
                                                                   ,"qtyPlaces" => $itemDetail->places
                                                                   ,"type" => $montInfo->type
                                                                   ,"num" => $itemDetail->fkQuotationDetail);
                      }
                       }
               }
               
           }
               }
           
             $oportunityDetail = array();
             
             $oportunity = $oportunity = DB::table('opportunities as o')
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
                                                    WHEN o.opportunities_status = 2 THEN 'Rechazada'
                                                    WHEN o.opportunities_status = 3 THEN 'Cancelada'
                                                    WHEN o.opportunities_status = 5 THEN 'Cotizada'
                                                    ELSE 'N/A' END) as opportunities_status")
                                    ,'o.number_employees'
                                    ,'o.number_places'
                                    ,'o.number_courses'
                                    ,'o.price_total'
                                    ,'o.iva'
                                    ,'o.necesites'
                                    ,'o.comment'
                                    ,'p.name as typePayment'
                                    ,'o.isBudget')
                            ->where('o.status','=',1)
                            ->where('b.status','=',1)
                            ->where('o.fkBusiness','=',$Bussiness->pkBusiness)
                            ->orderby('register_day','desc')
                            ->orderby('register_hour','desc')
                            ->get();
             
                 foreach($oportunity as $item){
                   
                  $price = $this->helper->getPriceWithIvaQuotation($item->price_total,$item->iva);
                
                  $montWithIva[$item->pkOpportunities] = $price;
                  
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
           
    
             //info para crear una cotizacion
             $bussines  = DB::table('business')
                           ->select('name'
                                   ,'pkBusiness')
                           ->where('status','=',1)
                           ->get();
           
           $agent     = DB::table('users')
                           ->select('full_name'
                                   ,'pkUser')
                           ->where('status','=',1)
                           ->where('fkUser_type','!=',1)
                           ->get();
           
           $agentQuotation  = DB::table('users')
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
            
            
            $courses     = DB::table('courses')
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
            
            $payment    = DB::table('payment_methods')
                             ->select('pkPayment_methods'
                                     ,'name')
                             ->where('status','=',1)
                             ->get();
            
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
            
             $option             = '<option value="-1">Selecciona el tipo de negocio</option><option value="0_N">Prospecto</option>';
            
            $opportunitiesQuery = DB::table("opportunities")
                                    ->where('fkBusiness','=',$Bussiness->pkBusiness)
                                    ->where('opportunities_status','!=',2)
                                    ->where('opportunities_status','!=',3)
                                    ->where('opportunities_status','!=',5)
                                    ->where('status','=',1)
                                    ->orderBy("name","asc")
                                    ->get();
            
            $quotationsQuery    = DB::table("quotations")
                                    ->where('fkBusiness','=',$Bussiness->pkBusiness)
                                    ->where('quotations_status','!=',2)
                                    ->where('quotations_status','!=',3)
                                    ->where('quotations_status','!=',5)
                                    ->where('status','=',1)
                                    ->orderBy("name","asc")
                                    ->get();
            
            foreach ($opportunitiesQuery as $opportunitiesInfo) {
                $option .= '<option value="'.$opportunitiesInfo->pkOpportunities.'_o">Folio #'.html_entity_decode($opportunitiesInfo->folio).'(Oportunidad)</option>';
            }
            
            foreach ($quotationsQuery as $quotationsInfo) {
                $option .= '<option value="'.$quotationsInfo->pkQuotations.'_c">Folio #'.html_entity_decode($quotationsInfo->folio).'(Cotizaci&oacute;n)</option>';
            }
            
            $arrayLineTime = [];
            $cont = 0;
            
             $lineTimeOportunity  = DB::table('opportunities as o')
                                       ->join('users as u','u.pkUser','=','o.fkUser')
                                       ->select('o.folio'
                                               ,'u.full_name'
                                               ,'o.register_day'
                                               ,'o.register_hour'
                                               ,'o.pkOpportunities'
                                               ,'o.color'
                                               ,'o.opportunities_status'
                                               ,'o.icon')
                                       ->where('o.fkBusiness','=',$Bussiness->pkBusiness)
                                       ->orderby('register_date','asc')
                                       ->orderby('register_hour','asc')
                                       ->get();
             
              $lineTimeQuotation = DB::table('quotations as q')
                                    ->join('users as u','u.pkUser','=','q.fkUser')
                                    ->select('q.folio'
                                             ,'q.register_day'
                                             ,'u.full_name'
                                             ,'q.color'
                                             ,'q.pkQuotations'
                                             ,'q.icon'
                                             ,'q.quotations_status'
                                             ,'q.register_hour')
                                    ->where('q.fkBusiness','=',$Bussiness->pkBusiness)
                                    ->orderby('register_date','asc')
                                    ->orderby('register_hour','asc')
                                    ->get();
              
                     
            
              $lineTimeActivitys = DB::table('activities as a')
                                    ->leftjoin('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                                    ->join('users as u','u.pkUser','=','a.fkUser')
                                    ->select('a.description'
                                             ,'a.register_date'
                                             ,'u.full_name'
                                             ,'t.color'
                                             ,'t.pkActivities_type'
                                             ,'t.icon'
                                             ,'a.document as document'
                                             ,'a.register_hour')
                                    ->where('a.fkBusiness','=',$Bussiness->pkBusiness)
                                    ->orderby('register_date','asc')
                                    ->orderby('register_hour','asc')
                                    ->get();
              
              
                
              
              foreach($lineTimeActivitys as $itemActivity){
           
                  $arrayLineTime[$cont] = array('desc'         => $itemActivity->description,
                                               'full_name'     => $itemActivity->full_name,
                                               'register_day'  => $itemActivity->register_date,
                                               'register_hour' => $itemActivity->register_hour,
                                               'color'         => $itemActivity->color,
                                               'icon'          => $itemActivity->icon,
                                               'document'          => $itemActivity->document,
                                               'type'          => "actividad");
                          
                  $cont++;
              }

              usort($arrayLineTime,array($this, "sortFunction"));
              
             // dd($arrayLineTime);
              
              $filterTypeActivity = DB::table('activities_type')
                                      ->where('status','=',1)
                                      ->get();
              
               $arrayFilter = [];
               $cont = 0;
               
                foreach($filterTypeActivity as $itemActi){
                     if($itemActi->pkActivities_type > 0){
                   $arrayFilter[$cont] = array('desc'         => $itemActi->text."",
                                               'id'           => $itemActi->pkActivities_type,
                                               'type'         => "actividad");
                   $cont++;
                     }
              }
               
                foreach($lineTimeQuotation as $itemQuotation){
                  $arrayFilter[$cont] = array('desc'         => "Cotizacion folio: ".$itemQuotation->folio."",
                                              'id'           => $itemQuotation->pkQuotations,
                                              'type'         => "quotation");                          
                   $cont++;
              }
              
              foreach($lineTimeOportunity as $itemOportunity){
                      
                   $arrayFilter[$cont] = array('desc'         => "Oportunidad folio: ".$itemOportunity->folio."",
                                               'id'           => $itemOportunity->pkOpportunities,
                                               'type'          => "oportunidad");
                          
                   $cont++;
              }
              
          
              
            return view('empresas.detEmpresa')->with("Bussiness",$Bussiness)
                                              ->with("contact",$contact)
                                              ->with("quotation",$quotation)
                                              ->with("oportunity",$oportunity)
                                              ->with("bussines",$bussines)
                                              ->with("agent",$agent)
                                              ->with("agentQuotation",$agentQuotation)
                                              ->with("id",$id)
                                              ->with("level",$level)
                                              ->with("courses",$courses)
                                              ->with("payment",$payment)
                                              ->with("usersQuery",$usersQuery)
                                              ->with("businessQuery",$businessQuery)
                                              ->with("option",$option)
                                              ->with("arrayLineTime",$arrayLineTime)
                                              ->with("arrayFilter",$arrayFilter)
                                              ->with("companis",$companis)
                                              ->with("campaning",$campaning)
                                              ->with("activitiesTypeQuery",$activitiesTypeQuery)
                                              ->with("montInfo",$montArray)
                                              ->with("montWithIva",$montWithIva)
                                              ->with("arrayPermition",$arrayPermition)
                                              ->with("oportunityDetail",$oportunityDetail)
                                              ->with("coursesQuotation",$coursesQuotation);
        }
        
        function sortFunction($a, $b) {
               return strtotime($b["register_day"]." ".$b["register_hour"]) - strtotime($a["register_day"]." ".$a["register_hour"]);
         }
        
        public function searcher(Request $request) {

        $textSearch = $request->input('textSearch');
        $decodeText = htmlentities($textSearch);
        $textToSearch = $this->mergeTextToSearch($decodeText);

        $bussiness = DB::table('business')
                       ->select('pkBusiness'
                               ,'name')
                       ->where('status','=',1)   
                       ->where(function($query)use($decodeText,$textSearch) {
                               $query->where('name','like','%'.$decodeText.'%')
                       ->orwhere('name','like','%'.$textSearch.'%');
                           })
                       ->get();

        return view('empresas.search', array(
            "bussiness" => $bussiness,
        ));
    }
        
        public function searcherTextBussines(Request $request) {

        $textSearch = $request->input('textSearch');
        $decodeText = htmlentities($textSearch);
        $textToSearch = $this->mergeTextToSearch($decodeText);

        $bussiness = DB::table('business')
                       ->select('pkBusiness'
                               ,'name')
                       ->where('status','=',1)         
                       ->where('name','like','%'.$decodeText.'%')
                       ->where('status','=',1)
                       ->get();

        return view('empresas.searchInput', array(
            "bussiness" => $bussiness,
        ));
    }
   
        private function mergeTextToSearch($textToSearch) {

        $response = array();
        $contPos = 0;
        $text = $this->changingText($textToSearch);

        foreach ($text[0] as $firstName) {
            if (isset($text[1])) {
                foreach ($text[1] as $secondName) {
                    if (isset($text[2])) {
                        foreach ($text[2] as $thirdName) {
                            if (isset($text[3])) {
                                foreach ($text[3] as $fourthName) {
                                    if (isset($text[4])) {
                                        foreach ($text[4] as $fifthName) {
                                            $response[$contPos] = array($firstName, $secondName, $thirdName, $fourthName, $fifthName);
                                            $contPos++;
                                        }
                                    } else {
                                        $response[$contPos] = array($firstName, $secondName, $thirdName, $fourthName);
                                        $contPos++;
                                    }
                                }
                            } else {
                                $response[$contPos] = array($firstName, $secondName, $thirdName);
                                $contPos++;
                            }
                        }
                    } else {
                        $response[$contPos] = array($firstName, $secondName);
                        $contPos++;
                    }
                }
            } else {
                $response[$contPos] = $firstName;
               $contPos++;
            }
        }
        return $response;
    }
    
        private function changingText($text) {

        $textToSearch = explode(" ", $text);
        $response = array();
        $valueTemp = "";

        foreach ($textToSearch AS $key => $value) {
            if (!isset($response[$key])) {
                $response[$key] = array();
            }
            $value = strtolower($value);
            $valueNew = str_replace("&ntilde;", "n", $value);
            array_push($response[$key], $valueNew);
            for ($cont = 0; $cont < strlen($valueNew); $cont++) {
                if (preg_match('/[n]/i', $valueNew[$cont])) {
                    if ($value[$cont] != 'n') {
                        $valueTemp = substr_replace($valueNew, "&" . $valueNew[$cont] . "tilde;", $cont, 1);
                        array_push($response[$key], $valueTemp);
                    }
                }
            }
        }
        return $response;
    }
    
        public function searchBussines($name){
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
                                   ,'rfc'
                                   ,'b.status'
                                   ,'pkBusiness'
                                   ,'c.name as category'
                                   ,'cb.name as giro'
                                   ,'o.name as origin')
                        ->where('b.status','=',1)
                        ->where('b.name','=',$name)
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
            
            $quotation = DB::table('quotations as o')
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
                                    ,'o.money_in_account'
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
                                                    WHEN o.quotations_status = 2 THEN 'Rechazada'
                                                    WHEN o.quotations_status = 3 THEN 'Cancelada'
                                                    WHEN o.quotations_status = 4 THEN 'Revision'
                                                    WHEN o.quotations_status = 5 THEN 'Pagada'
                                                    ELSE 'N/A' END) as quotations_status")
                                     ,DB::raw('(SELECT pdf'
                                         . ' FROM info_facture as i'
                                         . ' WHERE i.status = 1'
                                         . ' AND i.fkOrder = o.pkQuotations'
                                         . ' ORDER BY pkInfoFacture desc limit 1) as pdf')
                                    ,DB::raw('(SELECT xml'
                                         . ' FROM info_facture as i'
                                         . ' WHERE i.status = 1'
                                         . ' AND i.fkOrder = o.pkQuotations'
                                         . ' ORDER BY pkInfoFacture desc limit 1) as xml')
                                     ,DB::raw('(SELECT pay'
                                         . ' FROM info_facture as i'
                                         . ' WHERE i.status = 1'
                                         . ' AND i.fkOrder = o.pkQuotations'
                                         . ' ORDER BY pkInfoFacture desc limit 1) as pay'))
                            ->where('o.status','=',1)
                            ->where('b.status','=',1)
                            ->where('u.status','=',1)
                            ->orderby('register_day','desc')
                            ->orderby('register_hour','desc')
                            ->get();
             
             $oportunity = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->join('users as u','u.pkUser','=','o.fkUser')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->join('courses as cu','cu.pkCourses','=','o.number_courses')
                            ->join('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
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
                            ->where('b.pkBusiness','=',$Bussiness->pkBusiness)
                            ->get();
             
             //info para crear una cotizacion
             $bussines  = DB::table('business')
                           ->select('name'
                                   ,'pkBusiness')
                           ->where('status','=',1)
                           ->get();
           
           $agent     = DB::table('users')
                           ->select('full_name'
                                   ,'pkUser')
                           ->where('status','=',1)
                           ->where('fkUser_type','!=',1)
                           ->where('privileges','like','%paticipate_oportunity:1%')
                           ->get();
            
            $level      = DB::table('level_interest')
                             ->select('pkLevel_interest'
                                     ,'text')
                             ->where('status','=',1)
                             ->get();
            
            
            $courses   = DB::table('courses')
                           ->select('pkCourses'
                                   ,'name')
                           ->where('status','=',1)
                           ->get();
            
            
            $payment    = DB::table('payment_methods')
                             ->select('pkPayment_methods'
                                     ,'name')
                             ->where('status','=',1)
                             ->get();
            
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
                                    ->orderBy("text","asc")
                                    ->get();
            
             $option             = '<option value="-1">Selecciona el tipo de negocio</option><option value="0_N">Prospecto</option>';
            
            $opportunitiesQuery = DB::table("opportunities")
                                    ->where('fkBusiness','=',$Bussiness->pkBusiness)
                                    ->where('opportunities_status','!=',2)
                                    ->where('status','=',1)
                                    ->orderBy("name","asc")
                                    ->get();
            
            $quotationsQuery    = DB::table("quotations")
                                    ->where('fkBusiness','=',$Bussiness->pkBusiness)
                                    ->where('status','=',1)
                                    ->orderBy("name","asc")
                                    ->get();
            
            foreach ($opportunitiesQuery as $opportunitiesInfo) {
                $option .= '<option value="'.$opportunitiesInfo->pkOpportunities.'_o">'.html_entity_decode($opportunitiesInfo->name).'(Oportunidad)</option>';
            }
            
            foreach ($quotationsQuery as $quotationsInfo) {
                $option .= '<option value="'.$quotationsInfo->pkQuotations.'_c">'.html_entity_decode($quotationsInfo->name).'(Cotizaci&oacute;n)</option>';
            }
            
            $arrayLineTime = [];
            $cont = 0;
            
             $lineTimeOportunity  = DB::table('opportunities as o')
                                       ->join('users as u','u.pkUser','=','o.fkUser')
                                       ->select('o.folio'
                                               ,'u.full_name'
                                               ,'o.register_day'
                                               ,'o.register_hour'
                                               ,'o.color'
                                               ,'o.icon')
                                       ->where('o.fkBusiness','=',$Bussiness->pkBusiness)
                                       ->orderby('register_date','asc')
                                       ->orderby('register_hour','asc')
                                       ->get();
             
              $lineTimeQuotation = DB::table('quotations as q')
                                    ->join('users as u','u.pkUser','=','q.fkUser')
                                    ->select('q.folio'
                                             ,'q.register_day'
                                             ,'u.full_name'
                                             ,'q.color'
                                             ,'q.icon'
                                             ,'q.register_hour')
                                    ->where('q.fkBusiness','=',$Bussiness->pkBusiness)
                                    ->orderby('register_date','asc')
                                    ->orderby('register_hour','asc')
                                    ->get();
              
                     
            
              $lineTimeActivitys = DB::table('activities as a')
                                    ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                                    ->join('users as u','u.pkUser','=','a.fkUser')
                                    ->select('a.description'
                                             ,'a.register_date'
                                             ,'u.full_name'
                                             ,'t.color'
                                             ,'t.icon'
                                             ,'a.register_hour')
                                    ->where('a.fkBusiness','=',$Bussiness->pkBusiness)
                                    ->orderby('register_date','asc')
                                    ->orderby('register_hour','asc')
                                    ->get();
              
                foreach($lineTimeQuotation as $itemQuotation){

                  $arrayLineTime[$cont] = array('desc'         => "Cotizacion folio: ".$itemQuotation->folio." creada",
                                               'full_name'     => $itemQuotation->full_name,
                                               'register_day'  => $itemQuotation->register_day,
                                               'register_hour' => $itemQuotation->register_hour,
                                               'color'         => $itemQuotation->color,
                                               'icon'          => $itemQuotation->icon,
                                               'type'          => "quotation");
                          
                   $cont++;
              }
              
              foreach($lineTimeOportunity as $itemOportunity){

                  $arrayLineTime[$cont] = array('desc'         => "Oportunidad folio: ".$itemOportunity->folio." creada",
                                               'full_name'     => $itemOportunity->full_name,
                                               'register_day'  => $itemOportunity->register_day,
                                               'register_hour' => $itemOportunity->register_hour,
                                               'color'         => $itemOportunity->color,
                                               'icon'          => $itemOportunity->icon,
                                               'type'          => "oportunidad");
                          
                   $cont++;
              }
              
              foreach($lineTimeActivitys as $itemActivity){

                  $arrayLineTime[$cont] = array('desc'         => $itemActivity->description,
                                               'full_name'     => $itemActivity->full_name,
                                               'register_day'  => $itemActivity->register_date,
                                               'register_hour' => $itemActivity->register_hour,
                                               'color'         => $itemActivity->color,
                                               'icon'          => $itemActivity->icon,
                                               'type'          => "actividad");
                          
                  $cont++;
              }

              usort($arrayLineTime,array($this, "sortFunction"));
              
             // dd($arrayLineTime);
              
              $filterTypeActivity = DB::table('activities_type')
                                      ->where('status','=',1)
                                      ->get();
              
               $arrayFilter = [];
               $cont = 0;
               
                foreach($filterTypeActivity as $itemActi){
                   $arrayFilter[$cont] = array('desc'         => $itemActi->text."",
                                               'id'           => "",
                                               'type'         => "actividad");
                   $cont++;
              }
               
                foreach($lineTimeQuotation as $itemQuotation){
                  $arrayFilter[$cont] = array('desc'         => "Cotizacion folio: ".$itemQuotation->folio."",
                                              'id'           => "",
                                              'type'         => "quotation");                          
                   $cont++;
              }
              
              foreach($lineTimeOportunity as $itemOportunity){

                   $arrayFilter[$cont] = array('desc'         => "Oportunidad folio: ".$itemOportunity->folio."",
                                               'id'           => "",
                                               'type'          => "oportunidad");
                          
                   $cont++;
              }
              
          
              
            return view('empresas.detEmpresa')->with("Bussiness",$Bussiness)
                                              ->with("contact",$contact)
                                              ->with("quotation",$quotation)
                                              ->with("oportunity",$oportunity)
                                              ->with("bussines",$bussines)
                                              ->with("agent",$agent)
                                              ->with("level",$level)
                                              ->with("courses",$courses)
                                              ->with("payment",$payment)
                                              ->with("usersQuery",$usersQuery)
                                              ->with("businessQuery",$businessQuery)
                                              ->with("option",$option)
                                              ->with("arrayLineTime",$arrayLineTime)
                                              ->with("arrayFilter",$arrayFilter)
                                              ->with("activitiesTypeQuery",$activitiesTypeQuery);
       }
       
        public function saveMasiveBussinesDB(Request $request){
           
            $fileBusiness       = $request->file('fileBusiness');
            $date               = date("Y-m-d");
            $flag               = "true";
            $flagAuxOther            = "false";
            $message            = "";
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
                                                  $giro = '';
                                                  $giros = DB::table('commercial_business')
                                                                            ->where('name','=',htmlentities($row[10]))
                                                                            ->where('status','=',1)
                                                                            ->first();
                                                  
                                                  if(!empty($giros->pkCommercial_business)){
                                                      $giro = $giros->pkCommercial_business;
                                                  }
                                                  
                                                  $category = '';
                                                  $categoria = DB::table('categories')
                                                                            ->where('name','=',htmlentities($row[7]))
                                                                            ->where('status','=',1)
                                                                            ->first();
                                                  
                                                  if(!empty($categoria->pkCategory)){
                                                      $category = $categoria->pkCategory;
                                                  }
                                                  
                                                  $origen = '';
                                                  $origin = DB::table('business_origin')
                                                                            ->where('name','=',htmlentities($row[8]))
                                                                            ->where('status','=',1)
                                                                            ->first();
                                                  
                                                  if(!empty($origin->pkBusiness_origin)){
                                                      $origen = $origin->pkBusiness_origin;
                                                  }
                                                  
                                                  $rfcAux = $row[1];
                                                  $nameAucx = htmlentities($row[0]);
                                                  
                                                  $businessquery = DB::table('business')
                                                                            ->where(function ($query)use($rfcAux, $nameAucx) {
                                                                                $query->where('rfc', '=', $rfcAux)
                                                                                      ->orWhere('name', '=', $nameAucx);
                                                                            })
                                                                            ->where('status','=',1)
                                                                            ->select("name")
                                                                            ->first();
                                                  if(empty($businessquery->name)){
                                                      $insertBusiness = new Business;
                                                                  $insertBusiness->rfc = $row[1];
                                                                  $insertBusiness->name = htmlentities($row[0]);
                                                                  $insertBusiness->mail = '';
                                                                  $insertBusiness->address = htmlentities($row[2]);
                                                                  $insertBusiness->number = 1;
                                                                  $insertBusiness->postal_code = 1;
                                                                  $insertBusiness->country = htmlentities($row[3]);
                                                                  $insertBusiness->city = htmlentities($row[4]);
                                                                  $insertBusiness->state = htmlentities($row[5]);
                                                                  $insertBusiness->web = $row[6];
                                                                  $insertBusiness->phone = '';
                                                                  $insertBusiness->mobile_phone = '';
                                                                  $insertBusiness->fkComercial_business = $giro;
                                                                  $insertBusiness->fkCategory = $category;
                                                                  $insertBusiness->fkUser = $user;
                                                                  $insertBusiness->fKOrigin = $origen;
                                                                  $insertBusiness->image = $row[9];
                                                                  $insertBusiness->fkBusiness_type = $row[11];
                                                                  $insertBusiness->fkBusiness_status = 1;
                                                                  $insertBusiness->is_active = 1;
                                                                  $insertBusiness->date_register = $date;
                                                                  $insertBusiness->stateType = 1;
                                                                  $insertBusiness->status = 1;
                                                                  if($insertBusiness->save()){
                                                                      $name    = ($row[12] == "") ? "N/A" : $row[12];
                                                                      $puesto  = ($row[13] == "") ? "N/A" : $row[13];
                                                                      $phone   = ($row[15] == "") ? "N/A" : $row[15];
                                                                      $movile  = ($row[17] == "") ? "N/A" : $row[17];
                                                                      
                                                                      if(empty($row[14])){
                                                                         $flag = "false";
                                                                        $message .= "Error al ingresar contacto, el correo obligatorio \n";     
                                                                      }
                                                                      else{
                                                                       $insertContacts                = new Contacts_by_business;
                                                                       $insertContacts->fkBusiness    = $insertBusiness->pkBusiness;
                                                                       $insertContacts->name          = $name;
                                                                       $insertContacts->mail          = $row[14];
                                                                       $insertContacts->area          = $puesto;
                                                                       $insertContacts->phone         = $phone;
                                                                       $insertContacts->mobile_phone  = $movile;
                                                                       $insertContacts->status        = 1;
                                                                          
                                                                        if($insertContacts->save()){
                                                                            $flagAuxOther            = "true";
                                                                        }else{
                                                                           $flag = "false";
                                                                      $message .= "Error al ingresar usuario,el correo obligatorio \n";   
                                                                      }
                                                                      
                                                                        }
                                                                      
                                                                  }else{
                                                                      $flag = "false";
                                                                      $message .= "Error al crear empresas \n"; 
                                                                  }
                                                  }else{
                                                                      $flag = "false";
                                                                      $message .= "El RFC o nombre de la empresa ya existe \n"; 
                                                                  }

                                                                   
                                             }else{
                                                  $flag = "false";
                                                  $message .= "Error al crear empresas, no se puede leer la primer celda \n"; 
                                              }
                                        }
                                        $flagAux++;
                                    }
                                    fclose($fp); 
                                    unlink($pathFile);
 
                            }else{
                                $flag           = "false";
                                $message    .= "Error en formato de archivo \n";
                            }
                        }else{
                            $flag           = "false";
                            $message    .= "Error en nombre de archivo \n";
                        }
                    }else{
                        $flag           = "false";
                        $message    .= "Error en la carga del archivo \n";
                    }
                }else{
                    $flag           = "false";
                    $message    .= "Error no existe el archivo \n";
                }
                
                
                if(($flag == "true") && ($flagAuxOther == "true")){
                    DB::commit();
                    return $message;
                }else{
                    DB::rollback(); 
                    return "Error al cargar empresas. ".$message;
                }
            } catch (\Exception $e) {
                DB::rollback(); 
                //return "Error del sistema, favor de contactar al desarrollador";
                return $e->getMessage();
           }   
       }
       
        public function viewDowloadEmail(){
           
           $giros = DB::table('commercial_business')
                      ->where('status','=',1)
                      ->get();
           
          return view('empresas.descargarCorreos')->with('giros',$giros);
                   
           
       }
       
        public function dowloadBussienes($giro,$type){
           
           $giro = $giro;
           $type = $type;
           
           $contactByBussines = DB::table('business as b')
                                  ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                                  ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                                  ->leftjoin('categories as ca','ca.pkCategory','=','b.fkCategory')
                                  ->leftjoin('users as u','u.pkUser','=','b.fkUser')
                                  ->select('b.*'
                                          ,'g.name as giro'
                                          ,'o.name as origin'
                                          ,'u.full_name as propietario'
                                          ,'ca.name as category'
                                        ,DB::raw('(SELECT fkBusiness_status'
                                            . ' FROM status_by_bussines'
                                            . ' WHERE status = 1'
                                            . ' AND fkBusiness = b.pkBusiness order by fkBusiness_status DESC LIMIT 1) as typeBusiness')
                                          )
                                  ->where('b.status','=',1);
           
            if($giro > 0){
            $contactByBussines =  $contactByBussines->where('b.fkComercial_business','=',$giro);    
            }
            $contactByBussines =  $contactByBussines->get();
        
           
                   
            $stylesMainTitle    = array('borders' => array(
                                            'allborders' => array(
                                                'style' => \PHPExcel_Style_Border::BORDER_THIN)
                                        ),
                                        'font' => array(
                                            'bold' => true,
                                            'color'=> array('rgb' => '000000'),
                                            'size' => '10'
                                        ),
                                        'fill' => array(
                                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => 'FFFFFF')                     
                                        ),
                                        'alignment' => array(
                                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                            'vertical'  => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                                        )
                                    );
            $stylesMatrixTitles = array('borders' => array(
                                            'allborders' => array(
                                                'style' => \PHPExcel_Style_Border::BORDER_THIN)
                                        ),
                                        'font' => array(
                                            'bold' => true,
                                            'color'=> array('rgb' => 'FFFFFF'),
                                            'size' => '12'
                                        ),
                                        'fill' => array(
                                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '858484')                     
                                        ),
                                        'alignment' => array(
                                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                            'vertical'  => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                            'wrap'      => true
                                        )
                                    );
            $styleContent   = array('borders' => array(
                                            'allborders' => array(
                                                'style' => \PHPExcel_Style_Border::BORDER_THIN)
                                        ),
                                        'font' => array(
                                            'bold' => false,
                                            'color'=> array('rgb' => '000000'),
                                            'size' => '10'
                                        ),
                                        'alignment' => array(
                                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                                        )
                                    );
            
           

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
          $sheet->SetCellValue('A1',"Numero");
           $sheet->getStyle('A1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('B1',"Nombre");
            $sheet->getStyle('B1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('C1',"rfc");
            $sheet->getStyle('C1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('D1',"domicilio");
            $sheet->getStyle('D1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('E1',"pais");
            $sheet->getStyle('E1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('F1',"ciudad");
            $sheet->getStyle('F1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('G1',"estado");
            $sheet->getStyle('G1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('H1',"web");
            $sheet->getStyle('H1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('I1',"categoria");
            $sheet->getStyle('I1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('J1',"origen");
            $sheet->getStyle('J1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('K1',"imagen");
            $sheet->getStyle('K1')->applyFromArray($stylesMainTitle);
            
             $sheet->SetCellValue('L1',"giro");
            $sheet->getStyle('L1')->applyFromArray($stylesMainTitle);
            
             $sheet->SetCellValue('M1',"type");
            $sheet->getStyle('M1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('N1',"mail");
            $sheet->getStyle('N1')->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('O1',"propietario");
            $sheet->getStyle('O1')->applyFromArray($stylesMainTitle);
            
            /*
             $sheet->SetCellValue('N1',"nombre contacto");
            $sheet->getStyle('N1')->applyFromArray($stylesMainTitle);
            
             $sheet->SetCellValue('O1',"puesto");
            $sheet->getStyle('O1')->applyFromArray($stylesMainTitle);
            
             $sheet->SetCellValue('P1',"correo");
            $sheet->getStyle('P1')->applyFromArray($stylesMainTitle);
            
             $sheet->SetCellValue('Q1',"telefono");
            $sheet->getStyle('Q1')->applyFromArray($stylesMainTitle);
            
             $sheet->SetCellValue('R1',"extension");
            $sheet->getStyle('R1')->applyFromArray($stylesMainTitle);
            
             $sheet->SetCellValue('S1',"telefono movil");
            $sheet->getStyle('S1')->applyFromArray($stylesMainTitle);*/
            
            $cont=2;
             foreach($contactByBussines as $item){

              if($type > 0){

                if($type == $item->typeBusiness){
                       
                  $sheet->SetCellValue('A'.$cont,$item->pkBusiness);
           $sheet->getStyle('A'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('B'.$cont,html_entity_decode($item->name));
            $sheet->getStyle('B'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('C'.$cont,$item->rfc);
            $sheet->getStyle('C'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('D'.$cont,html_entity_decode($item->address));
            $sheet->getStyle('D'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('E'.$cont,html_entity_decode($item->country));
            $sheet->getStyle('E'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('F'.$cont,html_entity_decode($item->city));
            $sheet->getStyle('F'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('G'.$cont,html_entity_decode($item->state));
            $sheet->getStyle('G'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('H'.$cont,$item->web);
            $sheet->getStyle('H'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('I'.$cont,html_entity_decode($item->category));
            $sheet->getStyle('I'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('J'.$cont,html_entity_decode($item->origin));
            $sheet->getStyle('J'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('K'.$cont,$item->image);
            $sheet->getStyle('K'.$cont)->applyFromArray($stylesMainTitle);
            
             $sheet->SetCellValue('L'.$cont,html_entity_decode($item->giro));
            $sheet->getStyle('L'.$cont)->applyFromArray($stylesMainTitle);
            
            
            $typeBusiness = "";
            
            if(($item->typeBusiness == Null) || ($item->typeBusiness == 3)){
                $typeBusiness = "Prospecto";
            }
            
            if(($item->typeBusiness == 4) || ($item->typeBusiness == 6)){
                $typeBusiness = "Lead";
            }
            
            if($item->typeBusiness == 9){
                $typeBusiness = "Cliente";
            }
            
            
             $sheet->SetCellValue('M'.$cont,$typeBusiness);
            $sheet->getStyle('M'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('N'.$cont,$item->mail);
            $sheet->getStyle('N'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('O'.$cont,html_entity_decode($item->propietario));
            $sheet->getStyle('O'.$cont)->applyFromArray($stylesMainTitle);
            /*
             $sheet->SetCellValue('N'.$cont,$item->contact);
            $sheet->getStyle('N'.$cont)->applyFromArray($stylesMainTitle);
            
             $sheet->SetCellValue('O'.$cont,$item->area);
            $sheet->getStyle('O'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('P'.$cont,$item->mailcontact);
            $sheet->getStyle('P'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('Q'.$cont,$item->phonecontact);
            $sheet->getStyle('Q'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('R'.$cont,$item->extensioncontact);
            $sheet->getStyle('R'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('S'.$cont,$item->mobile_phone);
            $sheet->getStyle('S'.$cont)->applyFromArray($stylesMainTitle);
            */
            $cont++;
                }

              }else{
                 
                  $sheet->SetCellValue('A'.$cont,$item->pkBusiness);
           $sheet->getStyle('A'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('B'.$cont,html_entity_decode($item->name));
            $sheet->getStyle('B'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('C'.$cont,$item->rfc);
            $sheet->getStyle('C'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('D'.$cont,html_entity_decode($item->address));
            $sheet->getStyle('D'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('E'.$cont,html_entity_decode($item->country));
            $sheet->getStyle('E'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('F'.$cont,html_entity_decode($item->city));
            $sheet->getStyle('F'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('G'.$cont,html_entity_decode($item->state));
            $sheet->getStyle('G'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('H'.$cont,$item->web);
            $sheet->getStyle('H'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('I'.$cont,html_entity_decode($item->category));
            $sheet->getStyle('I'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('J'.$cont,html_entity_decode($item->origin));
            $sheet->getStyle('J'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('K'.$cont,$item->image);
            $sheet->getStyle('K'.$cont)->applyFromArray($stylesMainTitle);
            
             $sheet->SetCellValue('L'.$cont,html_entity_decode($item->giro));
            $sheet->getStyle('L'.$cont)->applyFromArray($stylesMainTitle);
            
            
            $typeBusiness = "";
            
            if(($item->typeBusiness == Null) || ($item->typeBusiness == 3)){
                $typeBusiness = "Prospecto";
            }
            
            if(($item->typeBusiness == 4) || ($item->typeBusiness == 6)){
                $typeBusiness = "Lead";
            }
            
            if($item->typeBusiness == 9){
                $typeBusiness = "Cliente";
            }
            
            
             $sheet->SetCellValue('M'.$cont,$typeBusiness);
            $sheet->getStyle('M'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('N'.$cont,$item->mail);
            $sheet->getStyle('N'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('O'.$cont,html_entity_decode($item->propietario));
            $sheet->getStyle('O'.$cont)->applyFromArray($stylesMainTitle);
            /*
             $sheet->SetCellValue('N'.$cont,$item->contact);
            $sheet->getStyle('N'.$cont)->applyFromArray($stylesMainTitle);
            
             $sheet->SetCellValue('O'.$cont,$item->area);
            $sheet->getStyle('O'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('P'.$cont,$item->mailcontact);
            $sheet->getStyle('P'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('Q'.$cont,$item->phonecontact);
            $sheet->getStyle('Q'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('R'.$cont,$item->extensioncontact);
            $sheet->getStyle('R'.$cont)->applyFromArray($stylesMainTitle);
            
            $sheet->SetCellValue('S'.$cont,$item->mobile_phone);
            $sheet->getStyle('S'.$cont)->applyFromArray($stylesMainTitle);
            */
            $cont++;
             }
            }
            
          $titleFile      = 'empresas';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$titleFile.'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet,'Excel2007');
            $writer->save('php://output');
            exit;
                 
    }
       
        public function searchBusinessByStatus(Request $request){
            
            $idState       = $request->input('idState');
            
             $bussines = DB::table('business as b')
                       ->join('categories as c','c.pkCategory','=','b.fkCategory')
                       ->join('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->join('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.status'
                               ,'b.date_register'
                                ,DB::raw('(SELECT execution_date'
                                         . ' FROM activities as a'
                                        . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                        . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                         . ' AND a.execution_date IS NULL'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                            . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                         . ' AND a.execution_date IS NULL'
                                         . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 3)) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 2 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 4 OR q.opportunities_status = 3)) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 1 OR q.opportunities_status = 2)) as oportunityOpen')
                                         ,DB::raw('(SELECT SUM(number_places)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesPlaces')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 3) as initial')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND (s.fkBusiness_status = 4 OR s.fkBusiness_status = 6)) as leds')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 9) as client')
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesMont')
                                             
                               )
                       ->where('b.status','=',$idState)
                       ->get();
             
             
              $view = view('empresas.getBussines', array(
                           "bussines"            => $bussines
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));        
             
        }
        
        public function searchBusinessByStatusPros(Request $request){
            
             $idState       = $request->input('idState');
             
             $bussines = DB::table('business as b')
                       ->join('categories as c','c.pkCategory','=','b.fkCategory')
                       ->join('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->join('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
                              ,DB::raw('(SELECT execution_date'
                                         . ' FROM activities as a'
                                        . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                        . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                         . ' AND a.execution_date IS NULL'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                            . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                         . ' AND a.execution_date IS NULL'
                                         . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 3)) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 2 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 4 OR q.opportunities_status = 3)) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 1 OR q.opportunities_status = 2)) as oportunityOpen')
                                         ,DB::raw('(SELECT SUM(number_places)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesPlaces')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 3) as initial')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND (s.fkBusiness_status = 4 OR s.fkBusiness_status = 6)) as leds')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 9) as client')
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesMont')
                                             
                               )
                       ->where('b.status','=',$idState)
                       ->get();
             
                   
              $view = view('empresas.getBussinesProspectos', array(
                           "bussines"            => $bussines
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));        
             
        }
        
        public function searchBusiness(Request $request){
            
             $text       = "";
             $giro       = $request->input("pkGiro");  
             $campany    = $request->input("pkCampanin");  
             $fechStart  = $request->input("startDay");  
             $fechFinish = $request->input("finishDay");  
             $slcViewStatusBussines       = $request->input("slcViewStatusBussines");  
             
             $activities = array();

            $bussines = DB::table('business as b')
                       ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->leftjoin('business_by_commercial_campaigns as ca','ca.fkBusiness','=','b.pkBusiness')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
                               ,'b.status'
                                ,DB::raw('(SELECT execution_date'
                                         . ' FROM activities as a'
                                        . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                        . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                         . ' AND a.execution_date IS NULL'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                            . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                         . ' AND a.execution_date IS NULL'
                                         . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.quotations_status = 2) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.quotations_status = 1) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 2) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 1) as oportunityOpen')
                                         ,DB::raw('(SELECT SUM(number_places)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesPlaces')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 3) as initial')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND (s.fkBusiness_status = 4 OR s.fkBusiness_status = 6)) as leds')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 9) as client')
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesMont')      
                               );
            
            
              if($slcViewStatusBussines >= 0){
              $bussines = $bussines->where('b.status','=',$slcViewStatusBussines);
             }
             
              if($giro > 0){
              $bussines = $bussines->where('b.fkComercial_business','=',$giro);
             }
             
              if($campany > 0){
                $bussines = $bussines->where('ca.fkCommercial_campaigns','=',$campany);    
             }
             
               if(!empty($fechStart)){
                $bussines = $bussines->where('b.date_register','>=',$fechStart);    
             }
             
               if(!empty($fechFinish)){
                $bussines = $bussines->where('b.date_register','<=',$fechFinish);    
             }
            
               $bussines   =  $bussines->orderby('b.date_register','DESC')
                                       ->get();
               
           foreach($bussines as $bussinesInfo){
              $activitiesInfo = DB::table('activities as a')
                              ->select('a.execution_date')
                              ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                              ->where('a.status','=',1)
                              ->whereNotNull('a.execution_date')
                              ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                              ->where('t.pkActivities_type','>',0)
                              ->orderby('pkActivities','desc')
                              ->first();

           if(!empty($activitiesInfo->execution_date)){
              $activities[$bussinesInfo->pkBusiness]["lastActivity"] = $activitiesInfo->execution_date;
           }
               $activitiesNext = DB::table('activities as a')
                              ->select('a.description'
                                      ,'a.final_date')
                              ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                              ->where('a.status','=',1)
                              ->whereNull('a.execution_date')
                              ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                              ->where('t.pkActivities_type','>',0)
                              ->orderby('pkActivities','desc')
                              ->first();
           if(!empty($activitiesNext->description)){

              $activities[$bussinesInfo->pkBusiness]["nextActivity"] = $activitiesNext->description;

              $activities[$bussinesInfo->pkBusiness]["finalActivity"] = $activitiesNext->final_date;
           }

           }
            
                     
              $view = view('empresas.getBussines', array(
                               "bussines"    => $bussines
                               ,"activities"  => $activities
                               ,"text"        => htmlentities($text)
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
            
        }
        
        public function searchBusinessProspect(Request $request){
            
             $text       = "";
             $activities = array();
             $giro       = $request->input("pkGiro");  
             $campany    = $request->input("pkCampanin");  
             $fechStart  = $request->input("startDay");  
             $fechFinish = $request->input("finishDay");  
             $slcViewStatusBussines       = $request->input("slcViewStatusBussines");  
             
            
            $bussines = DB::table('business as b')
                      ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->leftjoin('business_by_commercial_campaigns as ca','ca.fkBusiness','=','b.pkBusiness')
                       ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.status'
                               ,'b.date_register'
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.quotations_status = 2) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.quotations_status = 1) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 2) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 1) as oportunityOpen')
                               );
            
            
              if($slcViewStatusBussines >= 0){
              $bussines = $bussines->where('b.status','=',$slcViewStatusBussines);
             }
             
              if($giro > 0){
              $bussines = $bussines->where('b.fkComercial_business','=',$giro);
             }
             
              if($campany > 0){
                $bussines = $bussines->where('ca.fkCommercial_campaigns','=',$campany);    
             }
             
               if(!empty($fechStart)){
                $bussines = $bussines->where('b.date_register','>=',$fechStart);    
             }
             
               if(!empty($fechFinish)){
                $bussines = $bussines->where('b.date_register','<=',$fechFinish);    
             }
            
               $bussines   =  $bussines->where(function($query) {
                              $query->where('s.fkBusiness_status', '=', '3');
                                })
                                ->where('s.status', '=', 1)
                            //    ->groupby('b.pkBusiness')
                             //   ->distinct()
                               ->orderby('b.name','asc')
                               ->get();
               
            
                                            foreach($bussines as $bussinesInfo){
              $activitiesInfo = DB::table('activities as a')
                              ->select('a.execution_date')
                              ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                              ->where('a.status','=',1)
                              ->whereNotNull('a.execution_date')
                              ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                              ->where('t.pkActivities_type','>',0)
                              ->orderby('pkActivities','desc')
                              ->first();

           if(!empty($activitiesInfo->execution_date)){
              $activities[$bussinesInfo->pkBusiness]["lastActivity"] = $activitiesInfo->execution_date;
           }
               $activitiesNext = DB::table('activities as a')
                              ->select('a.description'
                                      ,'a.final_date')
                              ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                              ->where('a.status','=',1)
                              ->whereNull('a.execution_date')
                              ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                              ->where('t.pkActivities_type','>',0)
                              ->orderby('pkActivities','desc')
                              ->first();
           if(!empty($activitiesNext->description)){

              $activities[$bussinesInfo->pkBusiness]["nextActivity"] = $activitiesNext->description;

              $activities[$bussinesInfo->pkBusiness]["finalActivity"] = $activitiesNext->final_date;
           }

           }
                     
              $view = view('empresas.getBussinesProspectos', array(
                            "bussines"    => $bussines
                               ,"activities"  => $activities
                               ,"text"        => htmlentities($text)
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
            
        }
        
        public function searchBusinessLeads(Request $request){
            
              $text       = "";
             $activities = array();
             $giro       = $request->input("pkGiro");  
             $campany    = $request->input("pkCampanin");  
             $fechStart  = $request->input("startDay");  
             $fechFinish = $request->input("finishDay");  
             $slcViewStatusBussines       = $request->input("slcViewStatusBussines");  
             
            
            $bussines = DB::table('business as b')
                       ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->leftjoin('business_by_commercial_campaigns as ca','ca.fkBusiness','=','b.pkBusiness')
                       ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.status'
                               ,'b.date_register'
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.quotations_status = 2) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.quotations_status = 1) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 2) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 1) as oportunityOpen')     
                               );
            
            
              if($slcViewStatusBussines >= 0){
              $bussines = $bussines->where('b.status','=',$slcViewStatusBussines);
             }
             
              if($giro > 0){
              $bussines = $bussines->where('b.fkComercial_business','=',$giro);
             }
             
              if($campany > 0){
                $bussines = $bussines->where('ca.fkCommercial_campaigns','=',$campany);    
             }
             
               if(!empty($fechStart)){
                $bussines = $bussines->where('b.date_register','>=',$fechStart);    
             }
             
               if(!empty($fechFinish)){
                $bussines = $bussines->where('b.date_register','<=',$fechFinish);    
             }
            
               $bussines   =  $bussines ->where(function($query) {
                                        $query->where('s.fkBusiness_status', '=', '4')
                                              ->orwhere('s.fkBusiness_status', '=', '6');
                                    })
                       ->where('s.status', '=', 1)
                      // ->groupby('b.pkBusiness')
                      // ->distinct()
                       ->orderby('b.name','asc')
                       ->get();
               
            
                     
              $view = view('empresas.getBussinesLeads', array(
                            "bussines"    => $bussines
                               ,"activities"  => $activities
                               ,"text"        => htmlentities($text)
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
            
        }
        
        public function searchBusinessClient(Request $request){
            
             $text       = "";
             $activities = array();
             $giro       = $request->input("pkGiro");  
             $campany    = $request->input("pkCampanin");  
             $fechStart  = $request->input("startDay");  
             $fechFinish = $request->input("finishDay");  
             $slcViewStatusBussines       = $request->input("slcViewStatusBussines");  
             
            
            $bussines = DB::table('business as b')
                      ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->leftjoin('business_by_commercial_campaigns as ca','ca.fkBusiness','=','b.pkBusiness')
                       ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.status'
                               ,'b.date_register'
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.quotations_status = 2) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.quotations_status = 1) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 2) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 1) as oportunityOpen')      
                               );
            
            
              if($slcViewStatusBussines >= 0){
              $bussines = $bussines->where('b.status','=',$slcViewStatusBussines);
             }
             
              if($giro > 0){
              $bussines = $bussines->where('b.fkComercial_business','=',$giro);
             }
             
              if($campany > 0){
                $bussines = $bussines->where('ca.fkCommercial_campaigns','=',$campany);    
             }
             
               if(!empty($fechStart)){
                $bussines = $bussines->where('b.date_register','>=',$fechStart);    
             }
             
               if(!empty($fechFinish)){
                $bussines = $bussines->where('b.date_register','<=',$fechFinish);    
             }
            
               $bussines   =  $bussines->where(function($query) {
                                        $query->where('s.fkBusiness_status', '=', '9')
                                              ->where('s.status', '=', 1);
                                    })
                       ->groupby('b.pkBusiness')
                    //   ->distinct()
                       ->orderby('b.name','asc')
                       ->get();
               
            
                     
              $view = view('empresas.getBussinesClient', array(
                            "bussines"    => $bussines
                               ,"activities"  => $activities
                               ,"text"        => htmlentities($text)
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
            
        }
        
	public function updateContact(Request $request){
           
         $pkContact  = $request->input("pkContact");
             
         $contact = DB::table('contacts_by_business')
                      ->select('pkContact_by_business'
                              ,'name'
                              ,'mail'
                              ,'area'
                              ,'fkBusiness'
                              ,'extension'
                              ,'phone'
                              ,'mobile_phone')
                      ->where('status','=',1)
                      ->where('pkContact_by_business','=',$pkContact)
                      ->first();
         
           $view = view('empresas.updateContact', array(
                           "contact"            => $contact
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
             
        }
        
        public function btnUpdateContactDB(Request $request){
            
          $pkContact     = $request->input("idContact");
          $cel           = $request->input("cel");
          $extension     = $request->input("extension");
          $phone         = $request->input("phone");
          $email         = $request->input("email");
          $cargo         = $request->input("cargo");
          $nameContact   = $request->input("nameContact");
                           
          $update = DB::table("contacts_by_business")
               ->where("pkContact_by_business", "=" ,$pkContact)
               ->update(['name'         => $nameContact
                        ,'mail'         => $email
                        ,'area'         => $cargo
                        ,'extension'    => $extension
                        ,'phone'        => $phone
                        ,'mobile_phone' => $cel]);
          
          if($update >= 1){
              return "true";
          }else{
              return "false"; 
          }

        }
        
        public function searchTimeLine(Request $request){
          $id          = $request->input("id");
          $type        = $request->input("type");
          $bussinesId  = $request->input("bussines");
          
           $arrayLineTime = [];
            $cont = 0;
            
            if($type == "actividad"){
                 $lineTimeActivitys = DB::table('activities as a')
                                    ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                                    ->join('users as u','u.pkUser','=','a.fkUser')
                                    ->select('a.description'
                                             ,'a.register_date'
                                             ,'u.full_name'
                                             ,'t.color'
                                             ,'t.icon'
                                             ,'a.document as document'
                                             ,'a.register_hour')
                                    ->where('a.fkBusiness','=',$bussinesId)
                                    ->where('a.fkActivities_type','=',$id)
                                    ->orderby('register_date','asc')
                                    ->orderby('register_hour','asc')
                                    ->get();
                 
                             
              
              foreach($lineTimeActivitys as $itemActivity){

                  $arrayLineTime[$cont] = array('desc'         => $itemActivity->description,
                                               'full_name'     => $itemActivity->full_name,
                                               'register_day'  => $itemActivity->register_date,
                                               'register_hour' => $itemActivity->register_hour,
                                               'color'         => $itemActivity->color,
                                               'icon'          => $itemActivity->icon,
                                               'document'          => $itemActivity->document,
                                               'type'          => "actividad");
                          
                  $cont++;
              }
            }elseif($type == "quotation"){
                 $lineTimeQuotation = DB::table('quotations as q')
                                    ->join('users as u','u.pkUser','=','q.fkUser')
                                    ->select('q.folio'
                                             ,'q.register_day'
                                             ,'u.full_name'
                                             ,'q.color'
                                             ,'q.icon'
                                             ,'q.register_hour')
                                    ->where('q.fkBusiness','=',$bussinesId)
                                    ->where('q.pkQuotations','=',$id)
                                    ->orderby('register_date','asc')
                                    ->orderby('register_hour','asc')
                                    ->get();
                 
                 foreach($lineTimeQuotation as $itemQuotation){

                  $arrayLineTime[$cont] = array('desc'         => "Cotizacion folio: ".$itemQuotation->folio." creada",
                                               'full_name'     => $itemQuotation->full_name,
                                               'register_day'  => $itemQuotation->register_day,
                                               'register_hour' => $itemQuotation->register_hour,
                                               'color'         => $itemQuotation->color,
                                               'icon'          => $itemQuotation->icon,
                                               'type'          => "quotation");
                          
                   $cont++;
              }
            }
            elseif ($type == "oportunidad") {
                $lineTimeOportunity  = DB::table('opportunities as o')
                                       ->join('users as u','u.pkUser','=','o.fkUser')
                                       ->select('o.folio'
                                               ,'u.full_name'
                                               ,'o.register_day'
                                               ,'o.register_hour'
                                               ,'o.color'
                                               ,'o.icon')
                                       ->where('o.fkBusiness','=',$bussinesId)
                                       ->where('o.pkOpportunities','=',$id)
                                       ->orderby('register_date','asc')
                                       ->orderby('register_hour','asc')
                                       ->get();
                
                  foreach($lineTimeOportunity as $itemOportunity){

                  $arrayLineTime[$cont] = array('desc'         => "Oportunidad folio: ".$itemOportunity->folio." creada",
                                               'full_name'     => $itemOportunity->full_name,
                                               'register_day'  => $itemOportunity->register_day,
                                               'register_hour' => $itemOportunity->register_hour,
                                               'color'         => $itemOportunity->color,
                                               'icon'          => $itemOportunity->icon,
                                               'type'          => "oportunidad");
                          
                   $cont++;
              }
            }

              usort($arrayLineTime,array($this, "sortFunction"));
              
               $view = view('empresas.getTimeLine', array(
                           "arrayLineTime"            => $arrayLineTime
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));
              
        }


        public function dowloadExcel($type){
  
          $contactByBussines = DB::table('business as b')
          ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
         ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
         ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
         ->select('b.pkBusiness'
                 ,'b.name'
                 ,'o.name as fKOrigin'
                 ,'c.name as category'
                 ,'g.name as giro'
                 ,'b.stateType'
                 ,'b.date_register'
                 ,'b.status'
                             ,DB::raw('(SELECT name'
                                       . ' FROM contacts_by_business as cb'
                                       . ' WHERE cb.status = 1'
                                       . ' AND cb.fkBusiness = b.pkBusiness'
                                       . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                             ,DB::raw('(SELECT mail'
                                       . ' FROM contacts_by_business as cb'
                                       . ' WHERE cb.status = 1'
                                       . ' AND cb.fkBusiness = b.pkBusiness'
                                       . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                             ,DB::raw('(SELECT phone'
                                       . ' FROM contacts_by_business as cb'
                                       . ' WHERE cb.status = 1'
                                       . ' AND cb.fkBusiness = b.pkBusiness'
                                       . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                             ,DB::raw('(SELECT mobile_phone'
                                       . ' FROM contacts_by_business as cb'
                                       . ' WHERE cb.status = 1'
                                       . ' AND cb.fkBusiness = b.pkBusiness'
                                       . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                  ,DB::raw('(SELECT count(pkQuotations)'
                                       . ' FROM quotations as q'
                                       . ' WHERE q.status = 1'
                                       . ' AND q.fkBusiness = b.pkBusiness'           
                                       . ' AND q.quotations_status = 5) as salesPay')
                                     ,DB::raw('(SELECT count(pkQuotations)'
                                       . ' FROM quotations as q'
                                       . ' WHERE q.status = 1'
                                       . ' AND q.fkBusiness = b.pkBusiness'   
                                       . ' AND q.quotations_status = 2) as salesLoss')
                                     ,DB::raw('(SELECT count(pkQuotations)'
                                       . ' FROM quotations as q'
                                       . ' WHERE q.status = 1'
                                       . ' AND q.fkBusiness = b.pkBusiness'   
                                       . ' AND (q.quotations_status = 1 OR q.quotations_status = 4)) as quotations')
                                     ,DB::raw('(SELECT count(pkOpportunities)'
                                       . ' FROM opportunities as q'
                                       . ' WHERE q.status = 1'
                                       . ' AND q.fkBusiness = b.pkBusiness'   
                                       . ' AND q.opportunities_status = 5) as oportunityAproved')
                                     ,DB::raw('(SELECT count(pkOpportunities)'
                                       . ' FROM opportunities as q'
                                       . ' WHERE q.status = 1'
                                       . ' AND q.fkBusiness = b.pkBusiness'   
                                       . ' AND q.opportunities_status = 2) as oportunityLoss')
                                     ,DB::raw('(SELECT count(pkOpportunities)'
                                       . ' FROM opportunities as q'
                                       . ' WHERE q.status = 1'
                                       . ' AND q.fkBusiness = b.pkBusiness'   
                                       . ' AND q.opportunities_status = 1) as oportunityOpen')
                                    ,DB::raw('(SELECT fkBusiness_status'
                                           . ' FROM status_by_bussines'
                                           . ' WHERE status = 1'
                                           . ' AND fkBusiness = b.pkBusiness order by fkBusiness_status DESC LIMIT 1) as typeBusiness')
                                         )
         ->where('b.status','=',1)
         //->groupby('b.pkBusiness')
         //->distinct()
         ->orderby('b.name','asc')
         ->get();
                  
           $stylesMainTitle    = array('borders' => array(
                                           'allborders' => array(
                                               'style' => \PHPExcel_Style_Border::BORDER_THIN)
                                       ),
                                       'font' => array(
                                           'bold' => true,
                                           'color'=> array('rgb' => '000000'),
                                           'size' => '10'
                                       ),
                                       'fill' => array(
                                           'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                                           'color' => array('rgb' => 'FFFFFF')                     
                                       ),
                                       'alignment' => array(
                                           'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                           'vertical'  => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                                       )
                                   );
           $stylesMatrixTitles = array('borders' => array(
                                           'allborders' => array(
                                               'style' => \PHPExcel_Style_Border::BORDER_THIN)
                                       ),
                                       'font' => array(
                                           'bold' => true,
                                           'color'=> array('rgb' => 'FFFFFF'),
                                           'size' => '12'
                                       ),
                                       'fill' => array(
                                           'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                                           'color' => array('rgb' => '858484')                     
                                       ),
                                       'alignment' => array(
                                           'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                           'vertical'  => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                           'wrap'      => true
                                       )
                                   );
           $styleContent   = array('borders' => array(
                                           'allborders' => array(
                                               'style' => \PHPExcel_Style_Border::BORDER_THIN)
                                       ),
                                       'font' => array(
                                           'bold' => false,
                                           'color'=> array('rgb' => '000000'),
                                           'size' => '10'
                                       ),
                                       'alignment' => array(
                                           'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                           'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
                                       )
                                   );
           
          
        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
         $sheet->SetCellValue('A1',"Empresa");
          $sheet->getStyle('A1')->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('B1',"Contacto");
           $sheet->getStyle('B1')->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('C1',"Origen");
           $sheet->getStyle('C1')->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('D1',"Categoria");
           $sheet->getStyle('D1')->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('E1',"Giro");
           $sheet->getStyle('E1')->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('F1',"Estatus");
           $sheet->getStyle('F1')->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('G1',"Ventas");
           $sheet->getStyle('G1')->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('H1',"Cotizaciones");
           $sheet->getStyle('H1')->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('I1',"Oportunidades");
           $sheet->getStyle('I1')->applyFromArray($stylesMainTitle);
           
           
           $cont=2;
            foreach($contactByBussines as $item){
        
             if($type > 0){
               $typecomp = $item->typeBusiness;
              
               if($item->typeBusiness == Null){
                $typecomp = 3;
               }

               if($item->typeBusiness == 6){
                $typecomp = 4;
               }
              
               if($type == $typecomp){

                $typeBusiness = "";
           
                if(($item->typeBusiness == Null) || ($item->typeBusiness == 3)){
                    $typeBusiness = "Prospecto";
                }
                
                if(($item->typeBusiness == 4) || ($item->typeBusiness == 6)){
                    $typeBusiness = "Lead";
                }
                
                if($item->typeBusiness == 9){
                    $typeBusiness = "Cliente";
                }

           $sales = "Realizadas: ".$item->salesPay."\n\n";
           $sales .= " Perdidas: ".$item->salesLoss;

           $quotations = "Realizadas: ".$item->quotations."\n";
           
           $oportunity  = "Aprovadas: ".$item->oportunityAproved."\n";
           $oportunity .= " Abiertas: ".$item->oportunityOpen."\n";
           $oportunity .= " Perdidas: ".$item->oportunityLoss."\n";
                      
           $sheet->SetCellValue('A'.$cont,html_entity_decode($item->name));
           $sheet->getStyle('A'.$cont)->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('B'.$cont,html_entity_decode($item->nameContact));
           $sheet->getStyle('B'.$cont)->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('C'.$cont,html_entity_decode($item->fKOrigin));
           $sheet->getStyle('C'.$cont)->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('D'.$cont,html_entity_decode($item->category));
           $sheet->getStyle('D'.$cont)->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('E'.$cont,html_entity_decode($item->giro));
           $sheet->getStyle('E'.$cont)->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('F'.$cont,html_entity_decode($typeBusiness));
           $sheet->getStyle('F'.$cont)->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('G'.$cont,$sales);
           $sheet->getStyle('G'.$cont)->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('H'.$cont,$quotations);
           $sheet->getStyle('H'.$cont)->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('I'.$cont,$oportunity);
           $sheet->getStyle('I'.$cont)->applyFromArray($stylesMainTitle);
          /* 
           $sheet->SetCellValue('J'.$cont,html_entity_decode($item->origin));
           $sheet->getStyle('J'.$cont)->applyFromArray($stylesMainTitle);
           
           $sheet->SetCellValue('K'.$cont,$item->image);
           $sheet->getStyle('K'.$cont)->applyFromArray($stylesMainTitle);
           
            $sheet->SetCellValue('L'.$cont,html_entity_decode($item->giro));
           $sheet->getStyle('L'.$cont)->applyFromArray($stylesMainTitle);*/

           $cont++;
               }
        
             }else{

              $typeBusiness = "";
           
              if(($item->typeBusiness == Null) || ($item->typeBusiness == 3)){
                  $typeBusiness = "Prospecto";
              }
              
              if(($item->typeBusiness == 4) || ($item->typeBusiness == 6)){
                  $typeBusiness = "Lead";
              }
              
              if($item->typeBusiness == 9){
                  $typeBusiness = "Cliente";
              }

              $sales = "Realizadas: ".$item->salesPay."\n\n";
              $sales .= " Perdidas: ".$item->salesLoss;
   
              $quotations = "Realizadas: ".$item->quotations."\n";
              
              $oportunity  = "Aprovadas: ".$item->oportunityAproved."\n";
              $oportunity .= " Abiertas: ".$item->oportunityOpen."\n";
              $oportunity .= " Perdidas: ".$item->oportunityLoss."\n";
                
              $sheet->SetCellValue('A'.$cont,html_entity_decode($item->name));
              $sheet->getStyle('A'.$cont)->applyFromArray($stylesMainTitle);
               
               $sheet->SetCellValue('B'.$cont,html_entity_decode($item->nameContact));
               $sheet->getStyle('B'.$cont)->applyFromArray($stylesMainTitle);
               
               $sheet->SetCellValue('C'.$cont,html_entity_decode($item->fKOrigin));
               $sheet->getStyle('C'.$cont)->applyFromArray($stylesMainTitle);
               
               $sheet->SetCellValue('D'.$cont,html_entity_decode($item->category));
               $sheet->getStyle('D'.$cont)->applyFromArray($stylesMainTitle);
               
               $sheet->SetCellValue('E'.$cont,html_entity_decode($item->giro));
               $sheet->getStyle('E'.$cont)->applyFromArray($stylesMainTitle);
               
               $sheet->SetCellValue('F'.$cont,html_entity_decode($typeBusiness));
               $sheet->getStyle('F'.$cont)->applyFromArray($stylesMainTitle);

               $sheet->SetCellValue('G'.$cont,$sales);
               $sheet->getStyle('G'.$cont)->applyFromArray($stylesMainTitle);
               
               $sheet->SetCellValue('H'.$cont,$quotations);
               $sheet->getStyle('H'.$cont)->applyFromArray($stylesMainTitle);
               
               $sheet->SetCellValue('I'.$cont,$oportunity);
               $sheet->getStyle('I'.$cont)->applyFromArray($stylesMainTitle);
               
              /* $sheet->SetCellValue('H'.$cont,$item->web);
               $sheet->getStyle('H'.$cont)->applyFromArray($stylesMainTitle);
               
               $sheet->SetCellValue('I'.$cont,html_entity_decode($item->category));
               $sheet->getStyle('I'.$cont)->applyFromArray($stylesMainTitle);
               
               $sheet->SetCellValue('J'.$cont,html_entity_decode($item->origin));
               $sheet->getStyle('J'.$cont)->applyFromArray($stylesMainTitle);
               
               $sheet->SetCellValue('K'.$cont,$item->image);
               $sheet->getStyle('K'.$cont)->applyFromArray($stylesMainTitle);
               
                $sheet->SetCellValue('L'.$cont,html_entity_decode($item->giro));
               $sheet->getStyle('L'.$cont)->applyFromArray($stylesMainTitle);*/
           $cont++;
            }
           }

           $titleFile = 'todas_las_empresas';

             if($type == 3){
              $titleFile      = 'empresas_prospecto';
              }
              
              if($type == 4){
                $titleFile      = 'empresas_leds';
              }
              
              if($type == 9){
                $titleFile      = 'empresas_clientes';
              }
           
          
           header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
           header('Content-Disposition: attachment;filename="'.$titleFile.'.xlsx"');
           header('Cache-Control: max-age=0');
           $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet,'Excel2007');
           $writer->save('php://output');
           exit;
                
        }

   public function searchnameBussines(Request $request){
     
    $text  = $request->input("text");
    $type  = $request->input("type");
    $activities = array();

    if($type == 0){
 $bussines = DB::table('business as b')
            ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
           ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
           ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
           ->select('b.pkBusiness'
                   ,'b.name'
                   ,'o.name as fKOrigin'
                   ,'c.name as category'
                   ,'g.name as giro'
                   ,'b.status'
                   ,'b.stateType'
                   ,'b.date_register'
                   ,'b.status'
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.quotations_status = 2) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 1 OR q.quotations_status = 4)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 2) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 1) as oportunityOpen')
                                         ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 3) as initial')
                                        ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND (s.fkBusiness_status = 4 OR s.fkBusiness_status = 6)) as leds')
                                     ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 9) as client'))
           ->where('b.name','like', "%".htmlentities($text)."%")
           ->where('b.status','=', 1)
         //  ->groupby('b.pkBusiness')
          // ->distinct()
           ->orderby('b.name','asc')
           ->paginate(30);

    }

    if($type == 9){
     $bussines = DB::table('business as b')
                       ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
                               ,'b.status'
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 3)) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 2 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 4 OR q.opportunities_status = 3)) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 1 OR q.opportunities_status = 2)) as oportunityOpen')
                                             
                               )
                       ->where(function($query) {
                                        $query->where('s.fkBusiness_status', '=', '9')
                                              ->where('s.status', '=', 1);
                                    })
                       ->where('b.name','like', "%".htmlentities($text)."%")
                       ->where('b.status','=', 1)
                     //  ->groupby('b.pkBusiness')
                      // ->distinct()
                       ->orderby('b.name','asc')
                       ->get();

            }

            if($type == 4){

              $bussines = DB::table('business as b')
              ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
              ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
              ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
              ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
              ->select('b.pkBusiness'
                      ,'b.name'
                      ,'o.name as fKOrigin'
                      ,'c.name as category'
                      ,'g.name as giro'
                      ,'b.stateType'
                      ,'b.date_register'
                      ,'b.status'
                      ,DB::raw('(SELECT name'
                                . ' FROM contacts_by_business as cb'
                                . ' WHERE cb.status = 1'
                                . ' AND cb.fkBusiness = b.pkBusiness'
                                . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                      ,DB::raw('(SELECT mail'
                                . ' FROM contacts_by_business as cb'
                                . ' WHERE cb.status = 1'
                                . ' AND cb.fkBusiness = b.pkBusiness'
                                . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                      ,DB::raw('(SELECT phone'
                                . ' FROM contacts_by_business as cb'
                                . ' WHERE cb.status = 1'
                                . ' AND cb.fkBusiness = b.pkBusiness'
                                . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                      ,DB::raw('(SELECT mobile_phone'
                                . ' FROM contacts_by_business as cb'
                                . ' WHERE cb.status = 1'
                                . ' AND cb.fkBusiness = b.pkBusiness'
                                . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                           ,DB::raw('(SELECT count(pkQuotations)'
                                . ' FROM quotations as q'
                                . ' WHERE q.status = 1'
                                . ' AND q.fkBusiness = b.pkBusiness'           
                                . ' AND q.quotations_status = 5) as salesPay')
                              ,DB::raw('(SELECT count(pkQuotations)'
                                . ' FROM quotations as q'
                                . ' WHERE q.status = 1'
                                . ' AND q.fkBusiness = b.pkBusiness'   
                                . ' AND (q.quotations_status = 4 OR q.quotations_status = 3)) as salesLoss')
                              ,DB::raw('(SELECT count(pkQuotations)'
                                . ' FROM quotations as q'
                                . ' WHERE q.status = 1'
                                . ' AND q.fkBusiness = b.pkBusiness'   
                                . ' AND (q.quotations_status = 2 OR q.quotations_status = 1)) as quotations')
                              ,DB::raw('(SELECT count(pkOpportunities)'
                                . ' FROM opportunities as q'
                                . ' WHERE q.status = 1'
                                . ' AND q.fkBusiness = b.pkBusiness'   
                                . ' AND q.opportunities_status = 5) as oportunityAproved')
                              ,DB::raw('(SELECT count(pkOpportunities)'
                                . ' FROM opportunities as q'
                                . ' WHERE q.status = 1'
                                . ' AND q.fkBusiness = b.pkBusiness'   
                                . ' AND (q.opportunities_status = 4 OR q.opportunities_status = 3)) as oportunityLoss')
                              ,DB::raw('(SELECT count(pkOpportunities)'
                                . ' FROM opportunities as q'
                                . ' WHERE q.status = 1'
                                . ' AND q.fkBusiness = b.pkBusiness'   
                                . ' AND (q.opportunities_status = 1 OR q.opportunities_status = 2)) as oportunityOpen')
                                    
                      )
                       ->where(function($query) {
                               $query->where('s.fkBusiness_status', '=', '4')
                                     ->orwhere('s.fkBusiness_status', '=', '6');
                           })
              ->where('s.status', '=', 1)
              ->where('b.status','=', 1)
              ->where('b.name','like', "%".htmlentities($text)."%")
              //->groupby('b.pkBusiness')
              //->distinct()
              ->orderby('b.name','asc')
              ->get();
          }

          if($type == 3){
 $bussines = DB::table('business as b')
                        ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->join('status_by_bussines as s','s.fkBusiness','=','b.pkBusiness')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.status'
                               ,'b.stateType'
                               ,'b.date_register'
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 3)) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 2 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 4 OR q.opportunities_status = 3)) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 1 OR q.opportunities_status = 2)) as oportunityOpen')
                                             
                               )
                                ->where(function($query) {
                                        $query->where('s.fkBusiness_status', '=', '3');
                                    })
                       ->where('s.status', '=', 1)
                       ->where('b.status','=', 1)
                       ->where('b.name','like', "%".htmlentities($text)."%")
                //       ->groupby('b.pkBusiness')
                  //     ->distinct()
                       ->orderby('b.name','asc')
                       ->get();
          }

                         foreach($bussines as $bussinesInfo){

              $activitiesInfo = DB::table('activities as a')
                              ->select('a.execution_date')
                              ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                              ->where('a.status','=',1)
                              ->whereNotNull('a.execution_date')
                              ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                              ->where('t.pkActivities_type','>',0)
                              ->orderby('pkActivities','desc')
                              ->first();

           if(!empty($activitiesInfo->execution_date)){
              $activities[$bussinesInfo->pkBusiness]["lastActivity"] = $activitiesInfo->execution_date;
           }
               $activitiesNext = DB::table('activities as a')
                              ->select('a.description'
                                      ,'a.final_date')
                              ->join('activities_type as t','t.pkActivities_type','=','a.fkActivities_type')
                              ->where('a.status','=',1)
                              ->whereNull('a.execution_date')
                              ->where('a.fkBusiness','=',$bussinesInfo->pkBusiness)
                              ->where('t.pkActivities_type','>',0)
                              ->orderby('pkActivities','desc')
                              ->first();

           if(!empty($activitiesNext->description)){

              $activities[$bussinesInfo->pkBusiness]["nextActivity"] = $activitiesNext->description;

              $activities[$bussinesInfo->pkBusiness]["finalActivity"] = $activitiesNext->final_date;
           }

           }
      

           if($type == 0){
            $view = view('empresas.getBussinesClient', array(
                                "bussines"    => $bussines
                               ,"activities"  => $activities
                               ,"text"        => htmlentities($text)
                            ))->render();
            }

           if($type == 9){
        $view = view('empresas.getBussinesClient', array(
                            "bussines"    => $bussines
                           ,"activities"  => $activities
                           ,"text"        => htmlentities($text)
                        ))->render();
        }

        if($type == 4){
          $view = view('empresas.getBussinesLeads', array(
            "bussines"    => $bussines
           ,"activities"  => $activities
           ,"text"        => htmlentities($text)
        ))->render();
        }

        if($type == 3){
          $view = view('empresas.getBussinesProspectos', array(
            "bussines"    => $bussines
           ,"activities"  => $activities
           ,"text"        => htmlentities($text)
        ))->render();
        }
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
   }

   public function searchBussinesMoreSale(Request $request){

    $dia = $request->input("day");
    $mes = $request->input("month");
    $anio = $request->input("year");

     if ($dia > 0) {
                $startDate = date("Y-m-d");
                $endDate = date("Y-m-d");
            }
            if ($mes > 0) {
                $startDate = date("Y-m") . "-01";
                $month = date("Y-m");
                $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
                $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));
                $endDate = $last_day;
            }
            if ($anio > 0) {
                $startDate = date("Y") . "-01-01";
                $endDate = date("Y") . "-12-31";
            }

      $BussinessMoreRes = DB::table('business as b')
                       ->leftjoin('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
                               ,DB::raw("DATE_FORMAT(date_register, '%d/%m/%Y') as date")
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND (final_date >= "'.$startDate.'" and final_date <= "'.$endDate.'")'
                                         . ' AND q.quotations_status = 5) as salesMont')
                     )->where('b.status','=',1)
                        ->orderby('b.date_register','DESC')
                        ->get();
           
           $bussinesMoreTotal = 0;
           
           foreach($BussinessMoreRes as $BussinessMoreResInfo){
               
              $bussinesMoreTotal = $bussinesMoreTotal + $BussinessMoreResInfo->salesMont;
           }

            $view = view('empresas.getBussinesMoreSales', array(
                 "BussinessMoreRes" => $BussinessMoreRes,
                 "bussinesMoreTotal" => $bussinesMoreTotal,
          ))->render();
      
          
              return \Response::json(array(
                                    "valid"       => "true",
                                    "view"        => $view
                                  ));  
   }

   public function activeBusiness(Request $request){
    $pkBusiness         = $request->input("pkBusiness");
        
        $categoriesUpdate   = DB::table("business")
                                ->where('pkBusiness','=',$pkBusiness)
                                ->where('status','=',0)
                                ->update(array("status" => 1));
        
        if($categoriesUpdate >= 1){
            return "true";
        }else{
            return "false";
        }
}
}

