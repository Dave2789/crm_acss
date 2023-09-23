<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Commercial_campaigns;
use App\Models\Agent_by_campaign;
use App\Models\Business;
use App\Models\Business_by_commercial_campaigns;
use Illuminate\Http\Request;
use App\Permissions\UserPermits;

class CommercialCampaignsController extends Controller {

    private $UserPermits;
    
	public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->UserPermits = new UserPermits();
        }
        
        public function commercialCampaignsCreateView()
        {
            $userLike       = '';
            $usersQuery     = DB::table("users")
                                ->whereRaw('users.status = 1 '.$userLike)
                                ->get();
            
            $typesQuery     = DB::table("campaigns_type")
                                ->where('campaigns_type.status', '=', 1)
                                ->get();
            
            
            return view('campanas.crearCampana', ["usersQuery" => $usersQuery, "typesQuery" => $typesQuery]);
        }
        
        public function commercialCampaignsCreateDB (Request $request) 
        {
            $name               = htmlentities ($request->input("name"));
            $code               = $request->input("code");
            $agentMain          = $request->input("agentMain");
            $startDate          = $request->input("startDate");
            $endDate            = $request->input("endDate");
            $type               = $request->input("type");
            $description        = htmlentities ($request->input("description"));
            $agentSecondary     = $request->input("agentSecondary");
            $fileBusiness       = $request->file('fileBusiness');
            $date               = date("Y-m-d");
            $flag               = "true";
            $message            = "true";
            $infoFileArray      = array();
            $insertBusinessQuery   = "INSERT INTO `business_by_commercial_campaigns` (fkCommercial_campaigns,fkBusiness,status) VALUES ";
            
            DB::beginTransaction();
              
            try { 
                if($fileBusiness != ''){ 
                    if(file_exists ($fileBusiness)){
                        $nameFile = $fileBusiness->getClientOriginalName();
                        if($nameFile!=''){
                            $ext            = $fileBusiness->extension();
                            if(($ext == 'txt') || ($ext == 'csv')){
                                
                                $insertCommercialCampaigns                  = new Commercial_campaigns;
                                $insertCommercialCampaigns->code            = $code;
                                $insertCommercialCampaigns->name            = $name;
                                $insertCommercialCampaigns->fkUser          = $agentMain;
                                $insertCommercialCampaigns->start_date      = $startDate;
                                $insertCommercialCampaigns->end_date        = $endDate;
                                $insertCommercialCampaigns->register_date   = $date;
                                $insertCommercialCampaigns->description     = $description;
                                $insertCommercialCampaigns->fkCampaigns_type= $type;
                                $insertCommercialCampaigns->status          = 1;
                                
                                if($insertCommercialCampaigns->save()){
                                    if((strpos($agentSecondary, ",") !== FALSE)){
                                        $agentsArray = explode(",", $agentSecondary);
                                        foreach ($agentsArray as $agentInfo) {
                                            $insertAgentByCampaign                          = new Agent_by_campaign;
                                            $insertAgentByCampaign->fkCommercial_campaigns  = $insertCommercialCampaigns->pkCommercial_campaigns;
                                            $insertAgentByCampaign->fkUser                  = $agentInfo;
                                            $insertAgentByCampaign->status                  = 1;
                                            
                                            if($insertAgentByCampaign->save()){
                                                
                                            }else{
                                                $flag = "false";
                                                $message .= "Error al agregar agente secundario con identificador: ".$agentInfo." \n";
                                            }
                                        }
                                    }else{
                                        if($agentSecondary != ""){
                                            $insertAgentByCampaign                          = new Agent_by_campaign;
                                            $insertAgentByCampaign->fkCommercial_campaigns  = $insertCommercialCampaigns->pkCommercial_campaigns;
                                            $insertAgentByCampaign->fkUser                  = $agentSecondary;
                                            $insertAgentByCampaign->status                  = 1;
                                            
                                            if($insertAgentByCampaign->save()){
                                                
                                            }else{
                                                $flag = "false";
                                                $message .= "Error al agregar agente secundario con identificador: ".$agentSecondary." \n";
                                            }
                                        }
                                    }
                                    
                                    $pathFile       = $fileBusiness->getRealPath();
                                    $fp             = fopen($pathFile, "r");
                                    $flagAux        = 0;
                                    while (($row = fgetcsv($fp)) !== false) {
                                        if($flagAux!=0){
                                            foreach ($row as $key => $field) {
                                                if($field!=""){
                                                    switch ($key) {
                                                        case 0:  
                                                            $insertBusinessQuery .= " (".$insertCommercialCampaigns->pkCommercial_campaigns.",".$field.",1), ";
                                                        break;

                                                    }
                                                }
                                            }              
                                        }
                                        $flagAux++;
                                    }
                                    fclose($fp); 
                                    unlink($pathFile);
                                    
                                    $insertBusinessQuery              = rtrim($insertBusinessQuery, ", ").";";
                                    
                                    if(DB::insert(DB::raw($insertBusinessQuery))){ 
                    
                                    }else{ 
                                        $flag = "false";
                                        $message .= "Error al agregar empresas \n";
                                    }
                                }else{
                                    $flag           = "false";
                                    $message    .= "Error al crear registro \n";
                                }
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
    
        public function commercialCampaignsView () 
         {
            $sales      = array();
            $quotation  = array();
            $oportunity = array();
            $arrayPermition = array();
            
            $arrayPermition["viewCampaign"]  = $this->UserPermits->getPermition("viewCampaign");
            $arrayPermition["editCampaign"]  = $this->UserPermits->getPermition("editCampaign");
            $arrayPermition["deleteCampaign"]  = $this->UserPermits->getPermition("deleteCampaign");
            
        $campaignsQuery     = DB::table("commercial_campaigns")
                                ->join('campaigns_type','campaigns_type.pkCampaigns_type','=','commercial_campaigns.fkCampaigns_type')
                                ->join('users','users.pkUser','=','commercial_campaigns.fkUser')
                                ->join('user_type','user_type.pkUser_type','=','users.fkUser_type')
                                ->where('commercial_campaigns.status', '=', 1)
                                ->where('campaigns_type.status', '=', 1)
                                ->where('users.status', '=', 1)
                                ->where('user_type.status', '=', 1)
                                ->select(
                                    'commercial_campaigns.pkCommercial_campaigns AS pkCommercial_campaigns',
                                    'commercial_campaigns.code AS code',
                                    'commercial_campaigns.name AS name',
                                    'commercial_campaigns.fkUser AS fkUser',
                                    'commercial_campaigns.start_date AS start_date',
                                    'commercial_campaigns.end_date AS end_date',
                                    'commercial_campaigns.register_date AS register_date',
                                    'commercial_campaigns.final_date AS final_date',
                                    'commercial_campaigns.fkCampaigns_type AS fkCampaigns_type',
                                    'commercial_campaigns.description AS description',
                                    'campaigns_type.name AS type_name',
                                    'users.full_name AS full_name',
                                    'user_type.name AS type_user_name'
                                )
                                ->get();
        
        foreach($campaignsQuery as $itemCampany){
            $companynByCampain = DB::table('business_by_commercial_campaigns')
                                   ->select('fkBusiness')
                                   ->where('fkCommercial_campaigns','=',$itemCampany->pkCommercial_campaigns)
                                   ->where("status", "=", "1")
                                   ->get();
            
            foreach($companynByCampain as $item){
                
                $bussines = DB::table('business as b')
                       ->join('categories as c','c.pkCategory','=','b.fkCategory')
                       ->leftjoin('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->leftjoin('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
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
                                         . ' AND q.opportunities_status = 1 ) as oportunityOpen')
                               )
                       ->where('b.status','=',1)
                       ->where('b.pkBusiness','=',$item->fkBusiness)
                       ->first();
                
                if(!empty($bussines->pkBusiness)){
                
                    if(!isset($sales[$itemCampany->pkCommercial_campaigns])){
                        //ventas
                        $sales[$itemCampany->pkCommercial_campaigns] = array("salesPay"   => $bussines->salesPay,
                                                                            "salesLoss"  => $bussines->salesLoss);   
                  
                        //cotizaciones
                        if(!isset($quotation[$itemCampany->pkCommercial_campaigns]["quotations"])){
                                 $quotation[$itemCampany->pkCommercial_campaigns] = array("quotations"   => $bussines->quotations);
                        }
                        
                        if(!isset($oportunity[$itemCampany->pkCommercial_campaigns]["oportunityAproved"])){
                                 $oportunity[$itemCampany->pkCommercial_campaigns] = array("oportunityAproved"   => $bussines->oportunityAproved,
                                                                                           "oportunityLoss"  => $bussines->salesLoss,
                                                                                           "oportunityOpen"  => $bussines->oportunityOpen);  
                        }
                    }else{
                        $sales[$itemCampany->pkCommercial_campaigns]["salesPay"] =  $sales[$itemCampany->pkCommercial_campaigns]["salesPay"] + $bussines->salesPay;
                        $sales[$itemCampany->pkCommercial_campaigns]["salesLoss"] =  $sales[$itemCampany->pkCommercial_campaigns]["salesLoss"] + $bussines->salesLoss;
                        
                        if(isset($quotation[$itemCampany->pkCommercial_campaigns]["quotations"])){
                            $quotation[$itemCampany->pkCommercial_campaigns]["quotations"] =  $quotation[$itemCampany->pkCommercial_campaigns]["quotations"] + $bussines->quotations;
                        }
                        
                        if(isset($oportunity[$itemCampany->pkCommercial_campaigns]["oportunityAproved"])){
                            $oportunity[$itemCampany->pkCommercial_campaigns]["oportunityAproved"] =  $oportunity[$itemCampany->pkCommercial_campaigns]["oportunityAproved"] + $bussines->oportunityAproved;
                            $oportunity[$itemCampany->pkCommercial_campaigns]["oportunityLoss"] =  $oportunity[$itemCampany->pkCommercial_campaigns]["oportunityLoss"] + $bussines->oportunityLoss;
                            $oportunity[$itemCampany->pkCommercial_campaigns]["oportunityOpen"] =  $oportunity[$itemCampany->pkCommercial_campaigns]["oportunityOpen"] + $bussines->oportunityOpen;
                        }
                    }
                }
            }
            
        }

        
        return view('campanas.verCampanas',["campaignsQuery" => $campaignsQuery
                                           ,"sales"          => $sales
                                           ,"quotation"      => $quotation
                                           ,"oportunity"     => $oportunity
                                           ,"arrayPermition" => $arrayPermition]);
    }
    
        public function commercialCampaignsViewDetail ($campaign) 
         {
            
        $campaningName = DB::table("commercial_campaigns")
                            ->select('name')
                            ->where('pkCommercial_campaigns','=',$campaign)
                            ->first();
        
        $campaignsQuery     = DB::table("commercial_campaigns")
                                ->join('campaigns_type','campaigns_type.pkCampaigns_type','=','commercial_campaigns.fkCampaigns_type')
                                ->join('users','users.pkUser','=','commercial_campaigns.fkUser')
                                ->join('user_type','user_type.pkUser_type','=','users.fkUser_type')
                                ->where('commercial_campaigns.pkCommercial_campaigns', '=', $campaign)
                                ->where('commercial_campaigns.status', '=', 1)
                                ->where('campaigns_type.status', '=', 1)
                                ->where('users.status', '=', 1)
                                ->where('user_type.status', '=', 1)
                                ->select(
                                    'commercial_campaigns.pkCommercial_campaigns AS pkCommercial_campaigns',
                                    'commercial_campaigns.code AS code',
                                    'commercial_campaigns.name AS name',
                                    'commercial_campaigns.fkUser AS fkUser',
                                    'commercial_campaigns.start_date AS start_date',
                                    'commercial_campaigns.end_date AS end_date',
                                    'commercial_campaigns.register_date AS register_date',
                                    'commercial_campaigns.final_date AS final_date',
                                    'commercial_campaigns.fkCampaigns_type AS fkCampaigns_type',
                                    'commercial_campaigns.description AS description',
                                    'campaigns_type.name AS type_name',
                                    'users.full_name AS full_name',
                                    'user_type.name AS type_user_name'
                                )
                                ->get();
        
        $agentsQuery     = DB::table("agent_by_campaign")
                                ->join('users','users.pkUser','=','agent_by_campaign.fkUser')
                                ->join('user_type','user_type.pkUser_type','=','users.fkUser_type')
                                ->where('agent_by_campaign.fkCommercial_campaigns', '=', $campaign)
                                ->where('agent_by_campaign.status', '=', 1)
                                ->where('users.status', '=', 1)
                                ->where('user_type.status', '=', 1)
                                ->select(
                                    'users.full_name AS full_name',
                                    'user_type.name AS type_user_name'
                                )
                                ->get();
        
       $bussines    = DB::table("business_by_commercial_campaigns")
                                ->join('business as b','b.pkBusiness','=','business_by_commercial_campaigns.fkBusiness')
                                ->join('categories as c','c.pkCategory','=','b.fkCategory')
                                ->join('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                                ->join('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                                ->where('business_by_commercial_campaigns.fkCommercial_campaigns', '=', $campaign)
                                ->where('business_by_commercial_campaigns.status', '=', 1)
                                ->where('b.status', '=', 1)
                                 ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,DB::raw('(SELECT fkBusiness_status'
                                            . ' FROM status_by_bussines'
                                            . ' WHERE status = 1'
                                            . ' AND fkBusiness = b.pkBusiness order by fkBusiness_status DESC LIMIT 1) as stateType')
                               ,'b.date_register'
                               ,DB::raw('(SELECT execution_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                         . ' AND a.execution_date IS NULL'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                         . ' AND a.execution_date IS NULL'
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
                                         ,DB::raw('(SELECT SUM(number_places)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesPlaces')
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesMont')
                                             
                               )
                                ->get();
        
        
        
        return view('campanas.verDetalleCampana',["campaignsQuery"  => $campaignsQuery, 
                                                  "agentsQuery"     => $agentsQuery, 
                                                  "campaningName"   => $campaningName,
                                                  "campaign"        => $campaign,
                                                  "bussines"        => $bussines]);
    }
    
        public function updateCampaign(Request $request){
             $pkCampaning  = $request->input("pkCampaning");
            
            $campaning    = DB::table('commercial_campaigns')
                          ->select('pkCommercial_campaigns'
                                  ,'code'
                                  ,'name'
                                  ,'fkUser'
                                  ,'start_date'
                                  ,'end_date'
                                  ,'register_date'
                                  ,'final_date'
                                  ,'description'
                                  ,'fkCampaigns_type')
                          ->where('status','=',1)
                          ->where('pkCommercial_campaigns','=',$pkCampaning)
                          ->first();
            
            $userLike       = '';
            $usersQuery     = DB::table("users")
                                ->whereRaw('users.status = 1 '.$userLike)
                                ->get();
            
            $typesQuery     = DB::table("campaigns_type")
                                ->where('campaigns_type.status', '=', 1)
                                ->get();
            
            $agenByCampaning = DB::table('agent_by_campaign')
                                  ->where('status', '=', 1)
                                  ->where('fkCommercial_campaigns','=',$pkCampaning)
                                  ->get();

               $view = view('campanas.editarCampana', array(
                    "campaning"           => $campaning,
                    "usersQuery"          => $usersQuery,
                    "typesQuery"          => $typesQuery,
                    "agenByCampaning"          => $agenByCampaning,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function updateCampaignDB(Request $request){
           $name               = htmlentities ($request->input("name"));
            $code               = $request->input("code");
            $agentMain          = $request->input("agentMain");
            $startDate          = $request->input("startDate");
            $endDate            = $request->input("endDate");
            $type               = $request->input("type");
            $pkCompaning        = $request->input("pkCompaning");
            $description        = htmlentities ($request->input("description"));
            $agentSecondary     = $request->input("agentSecondary");
            $flag               = "true";
            $message            = "true";

            
            DB::beginTransaction();
              
            try { 
      
                                $updateCampaning = DB::table("commercial_campaigns")
                                            ->where("pkCommercial_campaigns", "=" ,$pkCompaning)
                                            ->update(['code'             => $code
                                                     ,'name'             => $name
                                                     ,'fkUser'           => $agentMain
                                                     ,'start_date'       => $startDate
                                                     ,'end_date'         => $endDate
                                                     ,'description'      => $description
                                                     ,'fkCampaigns_type' => $type]);

                                $updateAgent = DB::table("agent_by_campaign")
                                             ->where("fkCommercial_campaigns", "=" ,$pkCompaning)
                                             ->update(['status' => 0]);
                                
                                 
                                
                                    if((strpos($agentSecondary, ",") !== FALSE)){
                                        $agentsArray = explode(",", $agentSecondary);
                                        foreach ($agentsArray as $agentInfo) {
                                            $insertAgentByCampaign                          = new Agent_by_campaign;
                                            $insertAgentByCampaign->fkCommercial_campaigns  = $pkCompaning;
                                            $insertAgentByCampaign->fkUser                  = $agentInfo;
                                            $insertAgentByCampaign->status                  = 1;
                                            
                                            if($insertAgentByCampaign->save()){
                                                
                                            }else{
                                                $flag = "false";
                                                $message .= "Error al agregar agente secundario con identificador: ".$agentInfo." \n";
                                            }
                                        }
                                    }else{
                                        if($agentSecondary != ""){
                                            $insertAgentByCampaign                          = new Agent_by_campaign;
                                            $insertAgentByCampaign->fkCommercial_campaigns  = $pkCompaning;
                                            $insertAgentByCampaign->fkUser                  = $agentSecondary;
                                            $insertAgentByCampaign->status                  = 1;
                                            
                                            if($insertAgentByCampaign->save()){
                                                
                                            }else{
                                                $flag = "false";
                                                $message .= "Error al agregar agente secundario con identificador: ".$agentSecondary." \n";
                                            }
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
        
        public function udateBusinessByCampaning(Request $request){
 
            $idCampaning        = $request->input("idCampaning");
            $fileBusiness       = $request->file('fileBusiness');
            $date               = date("Y-m-d");
            $flag               = "true";
            $message            = "true";
            $infoFileArray      = array();
            $user               = Session::get('pkUser');
            $insertBusinessQuery   = "INSERT INTO `business_by_commercial_campaigns` (fkCommercial_campaigns,fkBusiness,status) VALUES ";
            
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
                                                    switch ($row[0]) {
                                                        case -1: 
                                                          
                                                            $update = DB::table("business_by_commercial_campaigns")
                                                                         ->where("fkBusiness", "=" ,$row[1])
                                                                         ->where("fkCommercial_campaigns", "=" ,$idCampaning)
                                                                         ->update(['status' => 0]);
                                                                   if($update >= 1){
                                                                  
                                                                  }else{
                                                                      $flag = "false";
                                                                      $message .= "Error al quitar empresas \n"; 
                                                                  }
                                                            
                                                         break;
                                                    
                                                         case 1:  
                                                       
                                                             $bussiness = DB::table('business')
                                                                            ->select('pkBusiness')
                                                                            ->where('pkBusiness','=',$row[1])
                                                                            ->first();
                                                             
                                                             if(!empty($bussiness->pkBusiness)){
                                                             $insertBusinessQuery .= " (".$idCampaning.",".$row[1].",1), ";    
                                                               }
                                                             else {
                                                                  $insertBusiness = new Business;
                                                                  $insertBusiness->fkLevel_interest = 1;
                                                                  $insertBusiness->rfc = $row[2];
                                                                  $insertBusiness->name = $row[2];
                                                                  $insertBusiness->mail = '';
                                                                  $insertBusiness->address = $row[3];
                                                                  $insertBusiness->number = 1;
                                                                  $insertBusiness->postal_code = 1;
                                                                  $insertBusiness->country = $row[4];
                                                                  $insertBusiness->city = $row[5];
                                                                  $insertBusiness->state = $row[6];
                                                                  $insertBusiness->country = 1;
                                                                  $insertBusiness->phone = '';
                                                                  $insertBusiness->mobile_phone = '';
                                                                  $insertBusiness->fkComercial_business = $row[10];
                                                                  $insertBusiness->fkCategory = $row[8];
                                                                  $insertBusiness->fkUser = $user;
                                                                  $insertBusiness->fKOrigin = $row[9];
                                                                  $insertBusiness->image = '';
                                                                  $insertBusiness->fkBusiness_type = 1;
                                                                  $insertBusiness->fkBusiness_status = 1;
                                                                  $insertBusiness->is_active = 1;
                                                                  $insertBusiness->date_register = $date;
                                                                  $insertBusiness->stateType = 1;
                                                                  $insertBusiness->status = 1;
                                                                  if($insertBusiness->save()){
                                                                    $insertBusinessQuery .= " (".$idCampaning.",".$insertBusiness->pkBusiness.",1), "; 
                                                                  }else{
                                                                      $flag = "false";
                                                                      $message .= "Error al crear empresas \n"; 
                                                                  }
                                                         }

                                               break;

                                                    }       
                                          }
                                        }
                                        $flagAux++;
                                    }
                                    fclose($fp); 
                                    unlink($pathFile);
                                    
                                    $insertBusinessQuery              = rtrim($insertBusinessQuery, ", ").";";
                                    
                                    if(DB::insert(DB::raw($insertBusinessQuery))){ 
                    
                                    }else{ 
                                        $flag = "false";
                                        $message .= "Error al agregar empresas \n";
                                    }

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
        
        public function deleteCampaning(Request $request){
            $pkCampaning         = $request->input("pkCampaning");
            
            $categoriesUpdate   = DB::table("commercial_campaigns")
                                    ->where('pkCommercial_campaigns','=',$pkCampaning)
                                    ->where('status','=',1)
                                    ->update(array("status" => 0));
            
            if($categoriesUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function viewCampaningAgent(Request $request){
            $pkCampaning  = $request->input("pkCampaning");
            
            $nameCampaning = DB::table('commercial_campaigns as c')
                                ->select('name')
                                ->where('status', '=', 1)
                                ->where('pkCommercial_campaigns','=',$pkCampaning)
                                ->first();
                                                        
            
            $agenByCampaning = DB::table('agent_by_campaign as a')
                                  ->join('users as u','u.pkUser','=','a.fkUser')
                                  ->where('a.status', '=', 1)
                                  ->where('a.fkCommercial_campaigns','=',$pkCampaning)
                                  ->get();

            $view = view('campanas.viewAgentByCampaning', array(
                         "agenByCampaning"           => $agenByCampaning,
                         "nameCampaning"             =>  $nameCampaning
                          ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function deleteBusinessCampaign (Request $request)
        {
            $pkBusiness             = $request->input("pkBusiness");
            $pkBusinessCampaign     = $request->input("pkBusinessCampaign");
            
            $deleteCampaning = DB::table('business_by_commercial_campaigns')
                                    ->where('fkCommercial_campaigns', '=', $pkBusinessCampaign)
                                    ->where('fkBusiness', '=', $pkBusiness)
                                    ->where('status', '=', 1)
                                  ->update(array("status" => 0));
            
            if($deleteCampaning >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
}
