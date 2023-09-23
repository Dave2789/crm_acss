<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use Session;
use App\Models\Contacts_by_business;
use App\Models\Status_by_bussines;
use App\Models\Sales;
use App\Models\Places_by_courses;
use App\Models\Courses;
use App\Models\User_type;
use App\Models\Users;
use App\Models\Business;
use App\Models\Agent_by_campaign;
use App\Models\Business_by_commercial_campaigns;
use App\Helpers\helper;
use App\Models\Quotation_detail;
use App\Models\Quotation;
use App\Models\Quotation_by_Courses;
use App\Models\Activities;

class ConnectController extends \App\Http\Controllers\Controller {
    
     private $value = "password#AppWeb12Ms";
     private $helper;

  public function __construct(){
      $this->helper = new helper();
         }
         
    private function write_log2($cadena){ 
            
	    $arch = fopen(realpath('.') . "/logs/logCRMViejo_" . date("Y-m-d") . ".txt", "a+");
        $cadena = str_replace("<br />", "\r\n", $cadena);
        fwrite($arch, "[" . date("Y-m-d H:i:s.u") . "]\r\n" . $cadena . "\n");
        fclose($arch);
    }

    private function write_log3($cadena){ 
            
	    $arch = fopen(realpath('.') . "/logs/logCap_" . date("Y-m-d") . ".txt", "a+");
        $cadena = str_replace("<br />", "\r\n", $cadena);
        fwrite($arch, "[" . date("Y-m-d H:i:s.u") . "]\r\n" . $cadena . "\n");
        fclose($arch);
    }
   public function syncCRMold(){

    // $courses  = $this->getCourses();
     $bussines = $this->BussinnesAdd();
     $sales    = $this->addSales();
     $messages = "";

      if($courses == "true"){
      $messages .= "cursos sincronizado correctamente";
     }else{
      $messages .= "error al sincronizar cursos";
     }

     if($bussines == "true"){
      $messages .= "empresas sincronizado correctamente";
    }else{
      $messages .= "error al sincronizar empresas";
    }

    if($sales == "true"){
      $messages .= "cotizaciones sincronizado correctamente";
    }else{
      $messages .= "error al sincronizar cotizaciones";
    }
    
  //$this->addActivities();
      $this->write_log2($messages);

      return $messages;
   }

   public function syncCap(){

    $bussines = $this->syncBussines();
    $sales    = $this->syncSales();
    $messages = "";

    if($bussines == "true"){
      $messages .= "empresas sincronizado correctamente";
    }else{
      $messages .= "error al sincronizar empresas";
    }

    if($sales == "true"){
      $messages .= "cotizaciones sincronizado correctamente";
    }else{
      $messages .= "error al sincronizar cotizaciones";
    }

      $this->write_log3($messages);

      return $messages;

   }

//sincroniza empresas capacitacion
   public function syncBussines() {

       // $output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($value), 'cmoe', MCRYPT_MODE_CBC, md5(md5($value))));
        $token = $this->value;
        $flag               = "true";
        //$data = array('token' => $token);
        //$resp = \Crypt::decrypt($token);

        //$payload = json_encode($data);
          DB::beginTransaction();
try {
        // Prepare new cURL resource
        $ch = curl_init();
        
         if ($ch === false) {
        throw new \Exception('failed to initialize');
        }
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'token='.$token);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, "https://crm.abrevius.com/public/getBussinesBySales");

        // Submit the POST request
        $result = curl_exec($ch);

          if ($result === false) {
        throw new \Exception(curl_error($ch), curl_errno($ch));
    }
        // Close cURL session handle
        curl_close($ch);
        
        $resp = json_decode($result);
 
          if($resp->valid == "true"){
         //   dd($resp->respuesta);
              foreach ($resp->respuesta as $infoBussines) {
                  
                  $date = explode(" ", $infoBussines->createDay);
                   $validBusssines = DB::table('business')
                                       ->select('pkBusiness')
                                       ->where('rfc', '=', htmlentities($infoBussines->rfc))
                                       ->orwhere('name','=', htmlentities($infoBussines->name))
                                       ->first();

                   if(empty($validBusssines->pkBusiness)){
                    $insertBusiness = new Business;
                    $insertBusiness->rfc = $infoBussines->rfc;
                    $insertBusiness->name = htmlentities ($infoBussines->name);
                    $insertBusiness->mail = $infoBussines->email;
                    $insertBusiness->address = htmlentities ($infoBussines->street) . "," . $infoBussines->numEx . "," . $infoBussines->col . "," . $infoBussines->cp;
                    $insertBusiness->number = 1;
                    $insertBusiness->postal_code = $infoBussines->cp;
                    $insertBusiness->city = $infoBussines->mun;
                    $insertBusiness->state = $infoBussines->state;
                    $insertBusiness->country = $infoBussines->country;
                    $insertBusiness->web = $infoBussines->web;
                    $insertBusiness->phone = '';
                    $insertBusiness->mobile_phone = '';
                    $insertBusiness->fkComercial_business = 0;
                    $insertBusiness->fkCategory = 0;
                    $insertBusiness->fkUser = 0;
                    $insertBusiness->fKOrigin = 0;
                    $insertBusiness->image = '';
                    $insertBusiness->fkBusiness_type = 1;
                    $insertBusiness->fkBusiness_status = 1;
                    $insertBusiness->is_active = 1;
                    $insertBusiness->date_register = $date[0];
                    $insertBusiness->stateType = 1;
                    $insertBusiness->status = 1;

                    if ($insertBusiness->save()) {

                        $insertContacts = new Contacts_by_business;
                        $insertContacts->fkBusiness = $insertBusiness->pkBusiness;
                        $insertContacts->name = htmlentities ($infoBussines->nameResp);
                        $insertContacts->mail = $infoBussines->email;
                        $insertContacts->area = htmlentities ($infoBussines->area);
                        $insertContacts->phone = $infoBussines->phone;
                        $insertContacts->mobile_phone = $infoBussines->cel;
                        $insertContacts->status = 1;

                        if ($insertContacts->save()) {
                            
                        } else {
                            $flag = "false";
                        }

                        $statusBussines = new Status_by_bussines;
                        $statusBussines->fkBusiness = $insertBusiness->pkBusiness;
                        $statusBussines->fkOpportunities = 0;
                        $statusBussines->fkQuotations = 0;
                        $statusBussines->fkBusiness_status = 9;
                        $statusBussines->status = 1;

                        if ($statusBussines->save()) {
                            
                        } else {
                            $flag = "false";
                        }
                    } else {
                        $flag = "false";
                    }

                   }
                }
                
                if($flag == "true"){
                     DB::commit();
                  return "true";    
                }else{
                      DB::rollback(); 
                return "ERROR AL AGREGAR EMPRESAS";    
                }
            }else{
                return "ERROR TOKEN INVALIDO";
            }
        }catch(Exception $e) {

    trigger_error(sprintf(
        'Curl failed with error #%d: %s',
        $e->getCode(), $e->getMessage()),
        E_USER_ERROR);

}
    }
    //sincroniza ventas capacitacion
   public function syncSales(){
         // $output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($value), 'cmoe', MCRYPT_MODE_CBC, md5(md5($value))));
        $token = $this->value;
        $flag               = "true";
        //$data = array('token' => $token);
        //$resp = \Crypt::decrypt($token);

        //$payload = json_encode($data);
          DB::beginTransaction();
try {
        // Prepare new cURL resource
        $ch = curl_init('https://crm.abrevius.com/public/getSales');
        
         if ($ch === false) {
        throw new \Exception('failed to initialize');
        }
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'token='.$token);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Submit the POST request
        $result = curl_exec($ch);

          if ($result === false) {
        throw new \Exception(curl_error($ch), curl_errno($ch));
    }
        // Close cURL session handle
        curl_close($ch);
        
        $resp = json_decode($result);
  /// dd($result);
          if($resp->valid == "true"){
             
              foreach ($resp->respuesta as $infoSales) {
                 //dd($infoSales);
                  $date = explode(" ", $infoSales->post_date);
  
                   $validSales = DB::table('sales')
                                       ->select('pkSales')
                                       ->where('idWordpress','=',$infoSales->id)
                                       ->first();

                   if(empty($validSales->pkSales)){
                       if($infoSales->typePayment == 'bacs' || $infoSales->typePayment == 'mercadopago'){
                           //dd("entra");
                    $insertBusiness              = new Sales;
                    $insertBusiness->idWordpress = $infoSales->id;
                    $insertBusiness->nameCourse  = $infoSales->nameCourse;
                    $insertBusiness->mont        = $infoSales->price;
                    $insertBusiness->places      = $infoSales->places;   
                    $insertBusiness->currency    = $infoSales->currency; 
                    $insertBusiness->typePayment = $infoSales->typePayment;
                    $insertBusiness->day         = $date[0];
                    $insertBusiness->status      = 1;

                    if ($insertBusiness->save()) {

                    } else {
                        $flag = "false";
                    }

                   }
                }
              }
                
                if($flag == "true"){
                     DB::commit();
                     return "true";   
                }else{
                      DB::rollback(); 
                return "ERROR AL AGREGAR EMPRESAS";    
                }
            }else{
                return "ERROR TOKEN INVALIDO";
            }
        }catch(Exception $e) {

    trigger_error(sprintf(
        'Curl failed with error #%d: %s',
        $e->getCode(), $e->getMessage()),
        E_USER_ERROR);

} 
   }
   
   //sincroniza curso courses ya no se utiliza
   public function syncCources(){
         // $output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($value), 'cmoe', MCRYPT_MODE_CBC, md5(md5($value))));
        $token = $this->value;
        $flag               = "true";
        //$data = array('token' => $token);
        //$resp = \Crypt::decrypt($token);

        //$payload = json_encode($data);
          DB::beginTransaction();
try {
        // Prepare new cURL resource
        $ch = curl_init('https://crm.abrevius.com/public/getCources');
        
         if ($ch === false) {
        throw new \Exception('failed to initialize');
        }
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'token='.$token);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Submit the POST request
        $result = curl_exec($ch);

          if ($result === false) {
        throw new \Exception(curl_error($ch), curl_errno($ch));
    }
        // Close cURL session handle
        curl_close($ch);
        
        $resp = json_decode($result);
  /// dd($result);
          if($resp->valid == "true"){
              
              Places_by_courses::query()->truncate();
             
              foreach ($resp->respuesta as $key => $infoPlaces) {
                 //dd($infoSales);
                  

                           //dd("entra");
                    $insertBusiness            = new Places_by_courses;
                    $insertBusiness->code      = $key;
                    $insertBusiness->name      = $infoPlaces->name;
                    $insertBusiness->places    = $infoPlaces->qty;
                    $insertBusiness->status    = 1;

                    if ($insertBusiness->save()) {

                    } else {
                        $flag = "false";
                    }

              }
                
                if($flag == "true"){
                     DB::commit();
                  return "SYNC REALIZADA CON EXITO";    
                }else{
                      DB::rollback(); 
                return "ERROR AL AGREGAR EMPRESAS";    
                }
            }else{
                return "ERROR TOKEN INVALIDO";
            }
        }catch(Exception $e) {

    trigger_error(sprintf(
        'Curl failed with error #%d: %s',
        $e->getCode(), $e->getMessage()),
        E_USER_ERROR);

} 
   }
   
   //cursos del viejo crm
   public function getCourses(){
     $flag = "true";
     $error = "";
     $courses =  DB::connection('mysqlOld')
                     ->table('t_cursos')
                     ->select('idcurso'
                             ,'nombre_curso')
                     ->get();
     
     foreach($courses as $coursesInfo){
         $code = explode(" ",$coursesInfo->nombre_curso,2);
         
         $existCourse = DB::table('courses')
                          ->select('code')
                          ->where('code','=',$code[0])
                          ->first();
         
          if(empty($existCourse->code)){
            $insertCourses = new Courses;
            $insertCourses->code = $code[0];
            $insertCourses->name = htmlentities ($code[1]);
            $insertCourses->status = 1;
            
            if($insertCourses->save()){
              
            }else{
                return "false";
                $error .= "en".$code;
            }
          }
     }
     
     if($flag == "true"){
         return "true";
     }else{
       return $error;  
     }
     
   }
   //tipos de usuario del viejo crm
   public function typeUsers(){
     $flag = "true";
     $error = "";
     
     $cargo =  DB::connection('mysqlOld')
                     ->table('t_cargo')
                     ->select('idcargo'
                             ,'nombre_cargo')
                     ->get();
     
       foreach($cargo as $cargoInfo){         
            $insertUserType = new User_type;
            $insertUserType->name = htmlentities ($cargoInfo->nombre_cargo);
            $insertUserType->status = 1;
            
            if($insertUserType->save()){
              
            }else{
                return "false";
                $error .= "en".$code;
            }
     }
     
     if($flag == "true"){
         return "true";
     }else{
       return $error;  
     }
   }
   //usuarios del viejo crm
   public function Users(){
     $flag = "true";
     $error = "";
     $permition = '{"permition":{"dashboard":"0","pipeline":"0","notification":"0","companySearch":"0","sendMail":"0","bussines":{"quotes":{"viewQuotes":"0","money":"0","invoice":"0","editQuotes":"0","changeQuotes":"0","deleteQuotes":"0"},"opportunities":{"viewOpportunities":"0","editOpportunities":"0","changeOpportunities":"0","deleteOpportunities":"0"}},"calendar":{"viewCalendar":"0","addActivity":"0"},"company":{"viewCompany":"1","addCompany":"0","editCompany":"0","deleteCompany":"0"},"campaign":{"viewCampaign":"0","editCampaign":"0","deleteCampaign":"0"},"job":{"viewJob":"0","finishJob":"0","editJob":"0","deleteJob":"0"},"admin":{"workplan":{"addWorkplan":"0","viewWorkplan":"0","deleteWorkplan":"0"},"configBonus":"0","sales":"0","activity":"0","config":"0"},"notificationC":{"addNotification":"0","viewNotification":"0","deleteNotification":"0"}}}';
     $date = date("Y-m-d");
     $user =  DB::connection('mysqlOld')
                     ->table('usuario')
                     ->get();
    
       foreach($user as $userInfo){         
           
          $type = DB::table('user_type')
                   ->select('pkUser_type')
                   ->where('name','=',$userInfo->cargo)
                   ->first();
                  
                                $insertUsers                    = new Users;
                                $insertUsers->username          = $userInfo->nombre;
                                $insertUsers->password          = $userInfo->login;
                                $insertUsers->mail              = $userInfo->correo;
                                $insertUsers->full_name         = $userInfo->apellidopaterno." ".$userInfo->apellidomaterno." ".$userInfo->nombre;
                                $insertUsers->fkUser_type       = $type->pkUser_type;
                                $insertUsers->privileges        = $permition;
                                $insertUsers->register_date     = $date;
                                $insertUsers->image             = $userInfo->imagen;
                                $insertUsers->connected         = 0;
                                $insertUsers->status            = 1;

                                
                                if($insertUsers->save()){
                                
                                }else{
                                    $flag = "false";
                                }
     }
     
     if($flag == "true"){
         return "true";
     }else{
       return $error;  
     }
   }
   //empresas del viejo crm
   public function BussinnesAdd(){
     $flag = "true";
     $error = "";
    
     $date = date("Y-m-d");
     $bussines =  DB::connection('mysqlOld')
                     ->table('t_contacto')
                     ->get();
    DB::beginTransaction();
     try{
         
       foreach($bussines as $bussinesInfo){         
           
          $giroOld  = DB::connection('mysqlOld')
                   ->table('t_giro')
                   ->select('codigo_giro')
                   ->where('idgiro','=',$bussinesInfo->idgiro)
                   ->first();
          
           $giroNew  = DB::table('commercial_business')
                   ->select('pkCommercial_business')
                   ->where('name','like','%'.$giroOld->codigo_giro.'%')
                   ->first();

                    $validBusssines = DB::table('business')
                                       ->select('pkBusiness')
                                       ->where('rfc', '=', htmlentities($bussinesInfo->razonsocial))
                                       ->orwhere('name','=', htmlentities($bussinesInfo->razonsocial))
                                       ->first();

                   if(empty($validBusssines->pkBusiness)){
  
                                $insertBusiness                       = new Business;
                                $insertBusiness->name                 = htmlentities($bussinesInfo->razonsocial);
                                $insertBusiness->mail                 = $bussinesInfo->correo;
                                $insertBusiness->address              = htmlentities($bussinesInfo->calle);
                                $insertBusiness->number               = 1;
                                $insertBusiness->postal_code          = 1;
                                $insertBusiness->city                 = htmlentities($bussinesInfo->ciudad);
                                $insertBusiness->state                = htmlentities($bussinesInfo->estado);
                                $insertBusiness->country              = htmlentities($bussinesInfo->pais);
                                $insertBusiness->web                  = $bussinesInfo->web;
                                $insertBusiness->phone                = $bussinesInfo->telefono;
                                $insertBusiness->mobile_phone         = '';
                                $insertBusiness->fkComercial_business = $bussinesInfo->idgiro;
                                $insertBusiness->fkCategory           = $bussinesInfo->idcategoria;
                                $insertBusiness->fkUser               = $bussinesInfo->idpropietario;
                                $insertBusiness->fKOrigin             = 1;
                                $insertBusiness->image                = $bussinesInfo->imagen;
                                $insertBusiness->fkBusiness_type      = 1;
                                $insertBusiness->fkBusiness_status    = 1;
                                $insertBusiness->is_active            = 1;
                                $insertBusiness->date_register        = $date;
                                $insertBusiness->stateType            = 1;
                                $insertBusiness->status               = 1;
                                
                                if($insertBusiness->save()){
                                    
                                    if(!empty($bussinesInfo->idcampania)){
                                            $insertAgentByCampaign                          = new Business_by_commercial_campaigns;
                                            $insertAgentByCampaign->fkCommercial_campaigns  = $bussinesInfo->idcampania;
                                            $insertAgentByCampaign->fkBusiness              = $insertBusiness->pkBusiness;
                                            $insertAgentByCampaign->status                  = 1;
                                            
                                             if($insertAgentByCampaign->save()){
                                                
                                            }else{
                                                $flag = "false";
                                               
                                            }
                                            
                                    }
                                    
                                    $contacts = DB::connection('mysqlOld')
                                                   ->table('t_personas_contacto')
                                                   ->where('idcontacto','=',$bussinesInfo->idcliente)
                                                   ->get();
                                    
                                     foreach($contacts as $item){
                                    
                                       $insertContacts                = new Contacts_by_business;
                                       $insertContacts->fkBusiness    = $insertBusiness->pkBusiness;
                                       $insertContacts->name          = htmlentities($item->nombre_contacto);
                                       $insertContacts->mail          = $item->correo_contacto;
                                       $insertContacts->area          = htmlentities($item->cargo_contacto);
                                       $insertContacts->phone         = $item->telefono_contacto;
                                       $insertContacts->mobile_phone  = $item->movil_contacto;
                                       $insertContacts->status        = 1;
                                       
                                        if($insertContacts->save()){
                                        }else{
                                         $flag         = "false";  
                                          $message    .= "Error al crear registro contactos \n";
                                        }
                                     
                                    }
                                
                                }else{
                                    $flag = "false";
                                }
                              }
     }
     }
      catch (Exception $ex) {
       $flag = "false";
       $error = $ex;
     }
     
     if($flag == "true"){
           DB::commit();
         return "true";
     }else{
          DB::rollback(); 
       return $error;  
     }
   }
   
   private function write_log($cadena){ 
            
	    $arch = fopen(realpath('.') . "/logs/log_" . date("Y-m-d") . ".txt", "a+");
        $cadena = str_replace("<br />", "\r\n", $cadena);
        fwrite($arch, "[" . date("Y-m-d H:i:s.u") . "]\r\n" . $cadena . "\n");
        fclose($arch);
    }
//ventas del viejo crm
   public function addSales(){
        $flag = "true";
        $error = "";
        $haveBussines;
        $messages = "";

        $date = date("Y-m-d");
        $sales = DB::connection('mysqlOld')
                ->table('t_sales')
                ->get();
        DB::beginTransaction();
        try {

            foreach ($sales as $salesInfo) {
             
              $existSales = DB::table('quotations')
                              ->select('pkQuotations')
                              ->where('folio','=',$salesInfo->codigo)
                              ->first();

               if(empty($existSales->pkQuotations)){
                $client = DB::connection('mysqlOld')
                        ->table('t_contacto')
                        ->select('razonsocial')
                        ->where('idcliente', '=', $salesInfo->idcustomer)
                        ->first();
                
               if(!empty($client->razonsocial)){
                   
                $clientId = DB::table('business')
                        ->select('pkBusiness'
                                , 'fkUser')
                        ->where('name', '=', html_entity_decode($client->razonsocial))
                        ->orwhere('name', '=', $client->razonsocial)
                        ->first();
                
                $haveBussines = 1;

               }else{
                 $haveBussines = 0;  
                  
               }

               if($haveBussines){
                   
                
                   if(isset($clientId->pkBusiness)){
                $campaning = DB::table('business_by_commercial_campaigns')
                        ->select('pkBusiness_by_commercial_campaigns')
                        ->where('fkBusiness', '=', $clientId->pkBusiness)
                        ->first();      

                $Quotation = new Quotation;
                $Quotation->folio = $salesInfo->codigo;
                $Quotation->color = "#64CF30";
                $Quotation->icon = "ti-star";
                $Quotation->fkOpportunities = 0;
                $Quotation->fkBusiness = $clientId->pkBusiness;
                $Quotation->fkUser = $salesInfo->idusuario;
                $Quotation->asing = $clientId->fkUser;
                $Quotation->fkLevel_interest = 2;

                if ($salesInfo->estado == "cerrada") {
                    $Quotation->quotations_status = 5;
                } else if ($salesInfo->estado == "curso") {
                    $Quotation->quotations_status = 1;
                } else if ($salesInfo->estado == "modificada") {
                    $Quotation->quotations_status = 1;
                } else if ($salesInfo->estado == "descartada") {
                    $Quotation->quotations_status = 2;
                }
                  
                $Quotation->fkCampaign = 0;
                  

                $Quotation->register_day  = $salesInfo->fecha;
                $Quotation->final_date    = $salesInfo->fecha;
                $Quotation->register_hour = "16:15:15";
                $Quotation->withIva = 1;
                $Quotation->status = 1;

                if ($Quotation->save()) {

                    $quotation_detail = new Quotation_detail;
                    $quotation_detail->fkQuotations = $Quotation->pkQuotations;
                    $quotation_detail->number_places = $salesInfo->cantidadlugares;
                    $quotation_detail->price = $salesInfo->oportunidad / 1.16;
                    $quotation_detail->iva = $this->helper->getIva();
                    $quotation_detail->type = 0;
                    $quotation_detail->isSelected = 1;
                    $quotation_detail->date = $salesInfo->fecha;
                    $quotation_detail->status = 1;

                    if ($quotation_detail->save()) {

                        $cursosByQuotation = DB::connection('mysqlOld')
                                                ->table('t_curso_customer')
                                                ->where('idsale', '=', $salesInfo->idsales)
                                                ->get();

                        foreach ($cursosByQuotation as $courses) {

                            $quotation_cources = new Quotation_by_Courses;
                            $quotation_cources->fkQuotationDetail = $quotation_detail->pkQuotations_detail;
                            $quotation_cources->fkCourses = $courses->idcurso;
                            $quotation_cources->status = 1;

                            if ($quotation_cources->save()) {
                                
                            } else {
                                $flag = "false";
                            }
                        }
                        
                               if($salesInfo->estado == "cerrada"){
                                    $statusBussines = new Status_by_bussines;
                                    $statusBussines->fkBusiness        =  $clientId->pkBusiness;
                                    $statusBussines->fkOpportunities   =  0;
                                    $statusBussines->fkQuotations      =  $Quotation->pkQuotations;
                                    $statusBussines->fkBusiness_status =  9;
                                    $statusBussines->status            =  1;
                               }else{
                                    $statusBussines = new Status_by_bussines;
                                    $statusBussines->fkBusiness        =  $clientId->pkBusiness;
                                    $statusBussines->fkOpportunities   =  0;
                                    $statusBussines->fkQuotations      =  $Quotation->pkQuotations;
                                    $statusBussines->fkBusiness_status =  6;
                                    $statusBussines->status            =  1; 
                               }
                    
                                         if($statusBussines->save()){                       
                                            }else{
                                        $flag = "false";     
                                         }
                    } else {
                        $flag = "false";
                    }
                 }
                }
               }else{
                   //logs
                 
                $messages .=  "idsale:".$salesInfo->idsales."<br />"
                             ."codigo".$salesInfo->codigo."<br />"
                             ."num. empleados".$salesInfo->cantidadempleados."<br />"
                             ."num. cursos".$salesInfo->cantidadrecursos."<br />"
                             ."num. lugares".$salesInfo->cantidadlugares."<br />"
                             ."precio".$salesInfo->oportunidadconpeso."<br />"
                             ."capacitar".$salesInfo->capacitar."<br />"
                             ."presupuesto".$salesInfo->presupuesto."<br />"
                             ."necesidades".$salesInfo->necesidades."<br />"
                             ."comentariosTLV".$salesInfo->comentariosTLV."<br />"
                             ."empresa".$salesInfo->idcustomer."<br />"
                             ."vendedor".$salesInfo->idusuario."<br />"
                             ."estado".$salesInfo->estado."<br />"
                             ."fecha".$salesInfo->fecha."<br /><br /><br />"
                        ; 
               }
              }
            }
        } catch (Exception $ex) {
            $flag = "false";
            $error = $ex;
        }

        if ($flag == "true") {
            DB::commit();
           $this->write_log($messages);
            return "true";
        } else {
            DB::rollback();
            return $error;
        }
    }
    //actividades del viejo crm
   public function addActivities(){
       
        $flag = "true";
        $error = "";
        $date = date("Y-m-d");
        $haveBussines;
        
        $activity = DB::connection('mysqlOld')
                       ->table('t_timeline')
                       ->get();
        
          DB::beginTransaction();

       
          
        try{

        foreach ($activity as $activityInfo) {

          $activityExist = DB::table('activities')
          ->select('pkOldCrm')
          ->where('status','=',1)
          ->where('pkOldCrm','=',$activityInfo->idtime)
          ->first();

            if(empty($activityExist->pkOldCrm)){
                $client = DB::connection('mysqlOld')
                        ->table('t_contacto')
                        ->select('razonsocial')
                        ->where('idcliente', '=', $activityInfo->idcustomer)
                        ->first();
                
               if(!empty($client->razonsocial)){


                $clientId = DB::table('business')
                        ->select('pkBusiness'
                                , 'fkUser')
                        ->where('name', '=', htmlentities($client->razonsocial))
                        ->orwhere('name', '=', $client->razonsocial)
                        ->first();
                
                $haveBussines = 1;

               }else{
                 $haveBussines = 0;  
                  
               }
               
               $pkActividad = 0;
                       
               if($activityInfo->tipo == "comunicacion"){
                  $pkActividad = 2; 
               }
               
               elseif($activityInfo->tipo == "llamada"){
                  $pkActividad = 1; 
               }
               
               elseif($activityInfo->tipo == "oportunidad"){
                  $pkActividad = -1; 
               }
               
               elseif($activityInfo->tipo == "tarea"){
                   $pkActividad = 3;
               }
               if(isset($clientId->pkBusiness)){
                        $ExistActivity = DB::table('activities')
                                              ->where('fkBusiness','=',$clientId->pkBusiness)
                                              ->first();
                           
                           $ExistQuotation = DB::table('quotations')
                                                ->where('fkBusiness','=',$clientId->pkBusiness)
                                                ->first();
                
                if(empty($ExistActivity->pkActivities) && empty($ExistQuotation->pkQuotations) ){
                   $statusBussines = new Status_by_bussines;
                    $statusBussines->fkBusiness        =  $clientId->pkBusiness;
                    $statusBussines->fkOpportunities   =  0;
                    $statusBussines->fkQuotations      =  0;
                    $statusBussines->fkBusiness_status =  3;
                    $statusBussines->status            =  1;
                    
                     if($statusBussines->save()){                       
                     }else{
                      $flag = "false";     
                     } 
                }
              }

          if(isset($clientId->pkBusiness)){
            
            $insertActivity = new Activities;
            $insertActivity->fkBusiness = $clientId->pkBusiness;
            $insertActivity->pkOldCrm = $activityInfo->idtime;
            $insertActivity->fkUser = $clientId->fkUser;
            $insertActivity->fkActivities_type = $pkActividad;
            $insertActivity->description = $activityInfo->detalle;

            if($activityInfo->tipo == "llamada"){
            $insertActivity->register_date =  $activityInfo->fecha_llamada;
            $insertActivity->register_hour = $activityInfo->hora_llamada;
            $insertActivity->final_date = $activityInfo->fecha_llamada;
            $insertActivity->final_hour = $activityInfo->hora_llamada;
            
          }else{
              $insertActivity->register_date =  $activityInfo->fecha;
              $insertActivity->register_hour = $activityInfo->hora;
              $insertActivity->final_date    = $activityInfo->fecha_vencimiento;
              $insertActivity->final_hour    = $activityInfo->hora_vencimiento;
            }
            $insertActivity->status = 1;
            
             if($insertActivity->save()){
                 
             }else{
               $flag = "false";   
             }
        }
      }
    }
        } catch (Exception $ex) {
            $flag = "false";
            $this->write_log2($error); 
             DB::rollback();
            $error = $ex;
        }
        
        if ($flag == "true") {
              DB::commit();
              $this->write_log2("actividad sincronizada correctamente");
            return "true";
        } else {
             DB::rollback();
             $this->write_log2($error);
            return $error;
        }
    }

}
