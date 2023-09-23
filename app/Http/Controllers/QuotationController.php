<?php namespace App\Http\Controllers;
ini_set('allow_url_fopen',1);
use DB;
use Input;
use Session;
use App\Models\Quotation_detail;
use App\Models\Quotation;
use App\Models\Activities;
use App\Models\Status_by_bussines;
use App\Models\Quotation_by_Courses;
use App\Models\Info_facture;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Permissions\UserPermits;
use App\Models\Alerts;
use App\Models\Users_per_alert;
use App\Helpers\helper;

class QuotationController extends Controller {

      private $UserPermits;
      private $helper;
      
	public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->UserPermits = new UserPermits();
            $this->helper = new helper();
        }

          /*     private $host     = "correo.treebes.com";
        private $username = "atencion@abrevius.com";
        private $password = "atencion.1234";*/
        
        private $host     = "mail.abrevia.com.mx";
        private $username = "info@abrevia.com.mx";
        private $password = "&*YD*_B4mz[]";

   
        
        private function createAlert($title, $message, $users, $fkQuotation) {

        $date = date("Y-m-d");
        $hour = date("H:i:s");
        $flag = "true";
        DB::beginTransaction();

        try {

            $insertAlert = new Alerts;
            $insertAlert->fkUser = Session::get("pkUser");
            $insertAlert->title = $title;
            $insertAlert->comment = $message;
            $insertAlert->type = 2;
            $insertAlert->fkQuotation = $fkQuotation;
            $insertAlert->date = $date;
            $insertAlert->hour = $hour;
            $insertAlert->status = 1;

            if ($insertAlert->save()) {
                
                foreach($users as $userInfo){
                
                        $insertAlertUser = new Users_per_alert;
                        $insertAlertUser->fkAlert = $insertAlert->pkAlert;
                        $insertAlertUser->fkUser_assigned = $userInfo->pkUser;
                        $insertAlertUser->view = 0;
                        $insertAlertUser->status = 1;

                        if ($insertAlertUser->save()) {
                            
                        } else {
                            $flag = "false";
                            $messageReturn .= "Error al agregar notificaci\u00F3n a usuario: " . $users . " \n";
                        }

                }
            } else {
                $flag = "false";
                $messageReturn .= "Error al agregar notificaci\u00F3n   \n";
            }

            if ($flag == "true") {
                DB::commit();
                return "true";
            } else {
                DB::rollback();
                return "false";
            }
        } catch (\Exception $e) {
            DB::rollback();
            //return "Error del sistema, favor de contactar al desarrollador";
            return $e->getMessage();
        }
    }
    
        private function sendMail($title, $message, $users, $fkQuotation,$places,$mont){
          $destinity         = $users;
          $subject           = $title;

     
          try {


            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->host;             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->username;      // SMTP username
            $mail->Password = $this->password;                    // SMTP password
            $mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;

            $mail->setFrom('info@abrevia.com.mx', 'Abrevius');
            $mail->addAddress('development@appendcloud.com');     // Add a recipient
            $mail->addReplyTo('info@abrevia.com.mx', 'Abrevius');
            
            foreach($destinity as $info){
               $mail->addCC($info->mail);
            }
            
               $view = view('emails.senMail', array(
                    "fkQuotation" => $fkQuotation,
                    "places" => $places,
                    "mont" => $mont,
                   
                        ))->render();

            
            $meesage2 = $view;

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8'; // Set email format to HTML// Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $meesage2;
            $mail->send();
            
            return "true";
        } catch (Exception $ex) {
             return "false";
        }
        }

        public function createOpportunity()
        {
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
            
            $payment    = DB::table('payment_methods')
                             ->select('pkPayment_methods'
                                     ,'name')
                             ->where('status','=',1)
                             ->get();
            
            return view('cotizaciones.crearCotizaciones',["bussines" => $bussines
                                                        ,"agent" => $agent
                                                        ,"payment" => $payment
                                                        ,"level" => $level]);
        }
        
        public function addQuotationDB(Request $request){
            
            $name               = htmlentities ($request->input("name"));
            $slcBussines        = $request->input("slcBussines");
            $slcContact         = $request->input("slcContact");
            $slcAgent           = $request->input("slcAgent");
            $level              = $request->input("level");
            $slcPayment         = $request->input("slcPayment");
            $campaning          = $request->input("campaning");
            $vigency            = $request->input("vigency");
            $iva                = $request->input("iva"); 
      
         
            $agentPro   = 0;
            
            $property   = DB::table('business')
                            ->select('pkBusiness'
                                    ,'fkUser')
                            ->where('pkBusiness','=',$slcBussines)
                            ->first();
            
             if(!empty($property->pkBusiness)){
               $agentPro   = $property->fkUser;
            }
            
          
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
                                $Quotation->folio                = $folio;
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
                                                
                                             //obtener precio curso
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
                                    $statusBussines = new Status_by_bussines;
                                    $statusBussines->fkBusiness        =  $slcBussines;
                                    $statusBussines->fkOpportunities   =  0;
                                    $statusBussines->fkQuotations      =  $Quotation->pkQuotations;
                                    $statusBussines->fkBusiness_status =  6;
                                    $statusBussines->status            =  1;
                    
                                         if($statusBussines->save()){                       
                                            }else{
                                        $flag = "false";     
                                         }
                                         
                    $insertActivity = new Activities;
                    $insertActivity->fkBusiness = $Quotation->fkBusiness;
                    $insertActivity->fkUser = $Quotation->asing;
                    $insertActivity->fkActivities_type = -2;
                    $insertActivity->description = "Cotizaci&oacute;n con folio: ".$Quotation->folio." creada";
                    $insertActivity->register_date = $DateTime[0];
                    $insertActivity->register_hour = $DateTime[1];
                    $insertActivity->document = "";
                    $insertActivity->status = 1; 
                  

                    if ($insertActivity->save()) {
                        
                    } else {
                        $flag = "false";
                        $message .= "Error al cargar actividad \n";
                    }
                    
                                }else{
                                    $flag           = "false";
                                    $message    .= "Error al crear registro \n";
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
        
        public function getContactBussines(Request $request){
            $slcBussines  = $request->input("slcBussines");
         
            $contact    = DB::table('contacts_by_business')
                                 ->select('pkContact_by_business'
                                  ,'name')
                                 ->where('status','=',1)
                                 ->get();
            
               $view = view('oportunidades.getContact', array(
                    "contact" => $contact,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));  
        }
        
        public function viewQuotation(Request $request){
            
          $montArray = array();
          $arrayPermition = array();
          
          $arrayPermition["viewQuotes"]   = $this->UserPermits->getPermition("viewQuotes");
          $arrayPermition["money"]        = $this->UserPermits->getPermition("money");
          $arrayPermition["invoice"]      = $this->UserPermits->getPermition("invoice");
          $arrayPermition["editQuotes"]   = $this->UserPermits->getPermition("editQuotes");
          $arrayPermition["changeQuotes"] = $this->UserPermits->getPermition("changeQuotes");
          $arrayPermition["deleteQuotes"] = $this->UserPermits->getPermition("deleteQuotes");
          
          $sales = 0;
          $open  = 0;
          $close = 0;
          $cancel = 0;

          $fechStart = date("Y") . "-01-01";
          $fechFinish = date("Y") . "-12-31";  
          
          
          //*** Para obtener total de cotizaciones abiertas y pendientes de pago de la opcion con el monto mas bajo
          $quotationMonth = 0;
          $quotationsArray = array();
          $quotationsQuery = DB::table('quotations')
                                ->join('business as b','b.pkBusiness','=','quotations.fkBusiness')
                                ->where('quotations.status','=',1)
                                ->where('b.status','=',1)
                                ->where(function ($query) {
                                      $query->where('quotations_status', '=', '1')
                                            ->orWhere('quotations_status', '=', '4');
                                  })
                                ->whereDate('register_day','>=',$fechStart)
                                ->whereDate('register_day','<=',$fechFinish)
                                ->select('pkQuotations','quotations_status','withIva')
                                ->get();
          
          foreach ($quotationsQuery as $quotationsInfo) {
              if($quotationsInfo->quotations_status == '1'){
                  $quotationsDetailQuery = DB::table('quotations_detail')
                                            ->where('fkQuotations','=',$quotationsInfo->pkQuotations)
                                            ->where('status','=',1)
                                            ->select('price','iva')
                                            ->get();
              }else{
                  $quotationsDetailQuery = DB::table('quotations_detail')
                                            ->where('fkQuotations','=',$quotationsInfo->pkQuotations)
                                            ->where('isSelected','=',1)
                                            ->where('status','=',1)
                                            ->select('price','iva')
                                            ->get();
              }
              
              
                foreach ($quotationsDetailQuery as $quotationsDetailInfo) {
                    
                    if($quotationsInfo->withIva < 1){
                        $newPriceIVA = $quotationsDetailInfo->price;
                    }else{
                        $newPriceIVA = $this->helper->getPriceWithIvaQuotation($quotationsDetailInfo->price, $quotationsDetailInfo->iva);
                    }
                                        
                    if(isset($quotationsArray[$quotationsInfo->pkQuotations])){
                        if($quotationsArray[$quotationsInfo->pkQuotations] > $newPriceIVA){
                            $quotationsArray[$quotationsInfo->pkQuotations] = $newPriceIVA;
                        }
                    }else{
                        $quotationsArray[$quotationsInfo->pkQuotations] = $newPriceIVA;
                    }
                }
          }
        
          foreach ($quotationsArray as $key => $value) {
              $quotationMonth = $quotationMonth + $value;
          }
          //****
          
          $agent     = DB::table('users')
                           ->select('full_name'
                                   ,'pkUser')
                           ->where('status','=',1)
                           ->where('fkUser_type','!=',1)
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
                                    ,'o.folio'
                                    ,'f.pdf'
                                    ,'f.xml'
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
                                    ,'o.money_in_account'
                                    ,'o.withIva'
                                    ,'o.quotations_status as quotation_status'
                                    ,DB::raw("(CASE WHEN o.quotations_status = 1 THEN 'Abierta' 
                                                    WHEN o.quotations_status = 2 THEN 'Rechazada'
                                                    WHEN o.quotations_status = 3 THEN 'Cancelada'
                                                    WHEN o.quotations_status = 4 THEN 'Revisión de pago'
                                                    WHEN o.quotations_status = 5 THEN 'Pagada'
                                                    ELSE 'N/A' END) as quotations_status"))
                            ->where('o.status','=',1)
                            ->where('b.status','=',1)
                            ->whereDate('o.register_day','>=',$fechStart)
                            ->whereDate('o.register_day','<=',$fechFinish)
                            ->orderby('register_day','desc')
                            ->orderby('register_hour','desc')
                            ->get();
          
          $cont = 0;
          $cont2 = 0;
          
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
                   $price = 0;
                   
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

                   $documents = DB::table('info_facture as i')
                         ->select('pdf'
                                 ,'xml'
                                 ,'pay')
                         ->where('fkOrder','=',$item->pkQuotations)
                         ->where('status','=',1)
                         ->first();

                    $pdf = "";
                    $xml = "";
                    $pay = "";

                    if(!empty($documents->pay)){
                        $pdf = $documents->pdf;
                        $xml = $documents->xml;
                        $pay = $documents->pay;
                    }
                
                  $montArray[$item->pkQuotations]["price"][$montInfo->pkQuotations_detail] = array("price"      => $price
                                                                                                  ,"isSelected" => $montInfo->isSelected
                                                                                                  ,"num"        => $montInfo->pkQuotations_detail
                                                                                                  ,"type"       => $type
                                                                                                  ,"pdf"        => $pdf
                                                                                                  ,"xml"        => $xml
                                                                                                  ,"pay"        => $pay);
                  
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
            
         
                 //dd($montArray);
             return view('cotizaciones.verCotizaciones', ["quotation"      => $quotation
                                                         ,"montInfo"       => $montArray
                                                         ,"quotationMonth" => $quotationMonth
                                                         ,"agent"          => $agent
                                                         ,"arrayPermition" => $arrayPermition
                                                         ,"coursesQuotation" => $coursesQuotation]);
            
        }
        
        public function updateQuotation(Request $request) 
        {
            $pkQuotations         = $request->input("pkQuotations");
            
            $folio = DB::table('quotations')
                       ->select('folio')
                       ->where('pkQuotations','=',$pkQuotations)
                       ->first();

            
            $quotation   = DB::table('quotations as q')
                            ->join('business as b','b.pkBusiness','=','q.fkBusiness')
                           ->leftjoin('commercial_campaigns as c','c.pkCommercial_campaigns','=','q.fkCampaign')
                            ->select('q.pkQuotations'
                                    ,'q.name'
                                    ,'b.name as bussines'
                                    ,'b.pkBusiness as idbussines'
                                    ,'q.fkOpportunities'
                                    ,'q.fkBusiness'
                                    ,'q.fkUser'
                                    ,'q.asing'
                                    ,'q.fkPayment_methods'
                                    ,'q.withIva'
                                    ,'q.fkCampaign'
                                    ,'c.name as campaign'
                                    ,'q.fkContact_by_business'
                                    ,'q.fkLevel_interest'
                                    ,'q.quotations_status'
                                    ,'q.final_date')
                              ->where('q.pkQuotations','=',$pkQuotations)
                              ->first();
            
              
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
            
            $level      = DB::table('level_interest')
                             ->select('pkLevel_interest'
                                     ,'text')
                             ->where('status','=',1)
                             ->get();
            
            $contact           = DB::table('contacts_by_business')
                                   ->select('pkContact_by_business'
                                            ,'name')
                                   ->where('fkBusiness','=',$quotation->fkBusiness)
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
            

              $view = view('cotizaciones.editarQuotation', array(
                    "bussines"        => $bussines,
                    "agent"           => $agent,
                    "level"           => $level,
                    "quotation"       => $quotation,
                    "contact"         => $contact,
                    "companis"        => $companis,
                    "payment"         => $payment,
                    "folio"           => $folio->folio
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));     
        }
        
        public function updateQuotationDB(Request $request){
            $name               = htmlentities ($request->input("name"));
            $slcBussines        = $request->input("slcBussines");
            $slcContact         = $request->input("slcContact");
            $slcAgent           = $request->input("slcAgent");
            $level              = $request->input("level");
            $slcPayment         = $request->input("slcPayment");
            $campaning          = $request->input("campaning");
            $iva                = $request->input("iva");
            $pkQuotations       = $request->input("pkQuotations");
            
            
            $arrayOptions       = json_decode($request->input('arrayOptions'));
            $startDateUTC = date("Y-m-d H:i:s");
            $DateTime = explode(" ", $startDateUTC);
            $flag               = "true";
            $message            = "true";
            DB::beginTransaction();
             
            try { 
                
                $updateQuotation = DB::table("quotations")
                                      ->where("pkQuotations", "=" ,$pkQuotations)
                                      ->update(['name'                  => $name
                                               ,'fkBusiness'            => $slcBussines
                                               ,'fkUser'                => $slcAgent
                                               ,'fkContact_by_business' => $slcContact
                                               ,'withIva'               => $iva
                                               ,'fkPayment_methods'     => $slcPayment
                                               ,'fkCampaign'            => $campaning
                                               ,'fkLevel_interest'      => $level
                                                ]);

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
        
        public function deleteQuotation(Request $request) 
        {

            if( ($this->UserPermits->getPermition("deleteQuotes") == 1) || Session::get("isAdmin") == 1){
            // dd("valido");  
           $pkQuotations         = $request->input("pkQuotations");
            
            $categoriesUpdate   = DB::table("quotations")
                                    ->where('pkQuotations','=',$pkQuotations)
                                    ->where('status','=',1)
                                    ->update(array("status" => 0));
            
            if($categoriesUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }else{
            // dd("invalido");  
          return "falseNoPermition";  
         }
        }
        
        public function viewDetailQuotation(Request $request){
           $idQuotation  = $request->input("idQuotation");
            
           $folios = DB::table('quotations as o')
                        ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->leftjoin('users as u','u.pkUser','=','o.fkUser')
                            ->leftjoin('users as a','a.pkUser','=','o.asing')
                            ->leftjoin('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->leftjoin('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->leftjoin('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
                            ->leftjoin('commercial_campaigns as co','co.pkCommercial_campaigns','=','o.fkCampaign')
                            ->select('o.pkQuotations'
                                    ,'o.name'
                                    ,'o.folio'
                                    ,'o.quotations_status as statusQ'
                                    ,'b.name as bussines'
                                    ,'b.image as image'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'p.name as payment'
                                    ,'co.name as campaning'
                                    ,'b.country'
                                    ,'b.state'
                                    ,'b.pkBusiness'
                                    ,'o.final_date'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'a.full_name as asing'
                                    ,'o.money_in_account'
                                    ,'o.withIva')
                       ->where('o.pkQuotations','=',$idQuotation)
                       ->where('o.status','=',1)
                       ->first();
                   
            $quotation  = DB::table('quotations_detail')
                          ->select('pkQuotations_detail'
                                  ,'fkQuotations'
                                  ,'number_places'
                                  ,'price'
                                  ,'type'
                                  ,'iva'
                                  ,'date')
                          ->where('status','=',1)
                          ->where('fkQuotations','=',$idQuotation)
                          ->get();

            foreach($quotation as $quotationInfo){
               if($folios->withIva == 1){
                $quotationInfo->price = $this->helper->getPriceWithIvaQuotation($quotationInfo->price,$quotationInfo->iva);
               }
            }   

            $courses     = DB::table('courses')
                           ->select('pkCourses'
                                   ,'name'
                                   ,'code')
                           ->where('status','=',1)
                           ->orderby('code','asc')
                           ->get();
    
               $view = view('cotizaciones.getDetailQuotation', array(
                    "quotation"   => $quotation,
                    "idQuotation" => $idQuotation, 
                    "folioInfo"   => $folios,
                    "courses"     => $courses
                   ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));           
        }
        
        public function deleteDetailQuotation(Request $request){
           $pkQuotationsDetail         = $request->input("pkQuotationsDetail");

           $quotation = DB::table('quotations_detail')
                          ->select('fkQuotations')
                          ->where('status','=',1)
                          ->where('pkQuotations_detail','=',$pkQuotationsDetail)
                          ->first();

           $totalDetails = DB::table('quotations_detail')
                            ->where('status','=',1)
                            ->where('fkQuotations','=',$quotation->fkQuotations)
                            ->count();

           if($totalDetails > 1){
      
            $categoriesUpdate   = DB::table("quotations_detail")
                                    ->where('pkQuotations_detail','=',$pkQuotationsDetail)
                                    ->where('status','=',1)
                                    ->update(array("status" => 0));
            
            if($categoriesUpdate >= 1){
                return "true";
            }else{
                return "false";
            }  
         }else{
            return "false2"; 
         }
        }
        
        public function addDetailQuotation(Request $request){
             
            $idQuotation   = $request->input("idQuotation");
            $arrayOptions  = json_decode($request->input('arrayOptions'));
            $startDateUTC  = date("Y-m-d H:i:s");
            $iva           = $request->input("iva");
            $DateTime      = explode(" ", $startDateUTC);
            $flag          = "true";
            $message       = "true";


            DB::beginTransaction();
            
            try { 
                                     foreach($arrayOptions as $item){
                                     
                                          $totalPrice = 0;
                                          $totalQty   = 0;
                                       
                                        
                                       $quotation_detail                = new Quotation_detail;
                                       $quotation_detail->fkQuotations  = $idQuotation;
                                       $quotation_detail->number_places = 0;
                                       $quotation_detail->price         = 0;
                                       $quotation_detail->type          = $item[0];
                                       $quotation_detail->iva           = $this->helper->getIva();
                                       $quotation_detail->isSelected    = 0;
                                       $quotation_detail->date          = $item[1];
                                       $quotation_detail->status        = 1;
                                       
                                        if($quotation_detail->save()){
                                              foreach($item[2] as $courses){
                                                  
                                                $price = $this->createQuotation($courses->qty, $item[3],$iva,$item[0],$item[4],$item[5]);
                                               
                                             $quotation_cources                      = new Quotation_by_Courses;
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
        
        public function updateStatus(Request $request) 
        {
            $pkQuotations         = $request->input("pkQuotations");
            
            $folio = DB::table('quotations')
                       ->select('folio')
                       ->where('pkQuotations','=',$pkQuotations)
                       ->first();
           
            $quotation   = DB::table('quotations as q')
                            ->join('business as b','b.pkBusiness','=','q.fkBusiness')
                            ->select('q.pkQuotations'
                                    ,'q.name'
                                    ,'q.fkOpportunities'
                                    ,'q.fkBusiness'
                                    ,'q.fkUser'
                                    ,'q.withIva'
                                    ,'q.fkContact_by_business'
                                    ,'q.fkLevel_interest'
                                    ,'q.quotations_status'
                                    ,'q.final_date'
                                    ,'b.name as bussines'
                                    ,'b.rfc')
                              ->where('q.pkQuotations','=',$pkQuotations)
                              ->first();
              
           $oportunity = DB::table('quotations_detail')
                           ->select('number_places'
                                   ,'price'
                                   ,'iva'
                                   ,'type'
                                   ,DB::raw("DATE_FORMAT(date, '%d/%m/%Y') as date")
                                   ,'pkQuotations_detail')
                           ->where('fkQuotations','=',$pkQuotations)
                           ->where('status','=',1)
                           ->get();
           
           $payment = DB::table('payment_forms_billing')
                        ->select('pkPayment_forms_billing'
                                ,'code'
                                ,'name')
                        ->where('status','=',1)
                        ->get();
           
           $method = DB::table('payment_methods_billing')
                        ->select('pkPayment_methods_billing'
                                ,'code'
                                ,'name')
                        ->where('status','=',1)
                        ->get();
           
           $condition = DB::table('payment_condition_billing')
                        ->select('pkPayment_condition_billing'
                                ,'code'
                                ,'name')
                        ->where('status','=',1)
                        ->get();
            
           $usocfdi = DB::table('f4_c_usocfdi')
                        ->select('id'
                                ,'c_UsoCFDI'
                                ,'Descripción')
                        ->where('status','=',1)
                        ->get();
           
           $claveser = DB::table('f4_c_claveserv')
                        ->select('pkF4_c_claveserv'
                                ,'code'
                                ,'name')
                        ->where('status','=',1)
                        ->get();
           
           $claveuni = DB::table('f4_c_claveunity')
                        ->select('pkF4_c_claveunity'
                                ,'code'
                                ,'name')
                        ->where('status','=',1)
                        ->get();
           

              $view = view('cotizaciones.editStatusQuotation', array(
                    "quotation"     => $quotation,
                    "oportunity"    => $oportunity,
                    "payment"       => $payment,
                    "method"        => $method,
                    "condition"     => $condition,
                    "usocfdi"       => $usocfdi,
                    "claveser"      => $claveser,
                    "claveuni"      => $claveuni,
                    "folio"         => $folio->folio
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));     
        }
        
        public function updateStatusDB(Request $request){
            $status        = $request->input("status");
            $option        = $request->input("option");
            $pkQuotation   = $request->input("pkQuotation");
            
            $serie         = $request->input("serie");
            $slccfdi       = $request->input("slccfdi");
            $payment       = $request->input("payment");
            $method        = $request->input("method");
            $condition     = $request->input("condition");
            $rfc           = $request->input("rfc");
            $social        = $request->input("social");
            $slcProduct    = $request->input("slcProduct");
            $slcUnity      = $request->input("slcUnity");
            $numIden       = $request->input("numIden");
            $desc          = $request->input("desc");
            
            $startDateUTC = date("Y-m-d H:i:s");
            $DateTime = explode(" ", $startDateUTC);
           
            $flag               = "true";
            $message            = "true";
            DB::beginTransaction();
             
            try { 
                

                 if($status == 4){
                $updateQuotation = DB::table("quotations")
                                      ->where("pkQuotations", "=" ,$pkQuotation)
                                      ->update(['quotations_status'   => $status
                                               ,'final_date' => $DateTime[0]
                                              ]);
                
                                       $infoFacture                      = new Info_facture;
                                       $infoFacture->fkOrder             = $pkQuotation;
                                       $infoFacture->rfc                 = $rfc;
                                       $infoFacture->razon               = $social;
                                       $infoFacture->cfdi                = $slccfdi;
                                       $infoFacture->payment             = $payment;
                                       $infoFacture->method              = $method;
                                       $infoFacture->conditionPayment    = $condition;
                                       $infoFacture->status              = 1;
                                       
                                       if($infoFacture->save()){
                                        }else{
                                         $flag         = "false";  
                                          $message    .= "Error al crear registro contactos \n";
                                        }
                
                 }
                 else{
                   $updateQuotation = DB::table("quotations")
                                      ->where("pkQuotations", "=" ,$pkQuotation)
                                      ->update(['quotations_status'   => $status]);   
                 }
                 
                if($updateQuotation >= 1){
                    
                    if($status == 4){
                      $updateQuotationOption = DB::table("quotations_detail")
                                      ->where("pkQuotations_detail", "=" ,$option)
                                      ->update(['isSelected'   =>1]); 
                      
                      if($updateQuotationOption >= 1){
                          
                      }else{
                       // $flag = "false";
                      //  $message = "error al modificar opcion";  
                      }
                    }
                  
                     $statusText = "";
                  if($status == 1){
                       $statusText = "Creada";
                  }elseif($status == 2){
                       $statusText = "Rechazada";
                  }elseif($status == 3){
                       $statusText = "Cancelada";
                  }elseif($status == 4){
                       $statusText = "Revisar";
                  }elseif($status == 5){
                       $statusText = "Pagada";
                  }
                  
                
                  $quotationres = DB::table('quotations')
                             ->select('fkBusiness'
                                     ,'fkUser'
                                     ,'withIva'
                                     ,'folio')
                             ->where('status','=',1)
                             ->where('pkQuotations','=',$pkQuotation)
                             ->first();
                             if($status >= 4){
                  $quotationdetail = DB::table('quotations_detail')
                                        ->select('price'
                                                ,'number_places')
                                        ->where('pkQuotations_detail','=',$option)
                                        ->first();

                      $price = 0;
                          //dd($option);
                    if($quotationres->withIva == 1){
                       $price =    $this->helper->getPriceWithIva($quotationdetail->price);
                     }else{
                       $price = $quotationdetail->price;
                    }
                }
            
                  if($status == 4){
                    $insertActivity = new Activities;
                    $insertActivity->fkBusiness = $quotationres->fkBusiness;
                    $insertActivity->fkUser = $quotationres->fkUser;
                    $insertActivity->fkActivities_type = -2;
                    $insertActivity->description = "Cotización con Folio # ".$quotationres->folio." en revision de pago con ".$quotationdetail->number_places ." lugares y un monto de $ ".$price;
                    $insertActivity->register_date = $DateTime[0];
                    $insertActivity->register_hour = $DateTime[1];
                    $insertActivity->document = "";
                    $insertActivity->status = 1;
                  }else{
                     $insertActivity = new Activities;
                    $insertActivity->fkBusiness = $quotationres->fkBusiness;
                    $insertActivity->fkUser = $quotationres->fkUser;
                    $insertActivity->fkActivities_type = -2;
                    $insertActivity->description = "Cotización Folio # ".$quotationres->folio." ".$statusText;
                    $insertActivity->register_date = $DateTime[0];
                    $insertActivity->register_hour = $DateTime[1];
                    $insertActivity->document = "";
                    $insertActivity->status = 1; 
                  }

                    if ($insertActivity->save()) {
                        
                    } else {
                        $flag = "false";
                        $message .= "Error al cargar actividad \n";
                    }

                    
                }else{
                 $flag = "false";
                 $message = "error al modificar estado";
                }

                if($flag == "true"){
                    if($status == 4){ 
                     
                     $messagesTitle  = "Se ha cerrado una cotización";
                     $messagesAlert  = "Cotización con folio #: ".$quotationres->folio." en revision de pago con ".$quotationdetail->number_places ." lugares y un monto de $ ".number_format($price,2);
                    
                     $users = DB::table('users')
                                ->where('privileges','like','%"money":"1"%')
                                ->where('status','=',1)
                                ->get();
                     
                      $alert = $this->createAlert($messagesTitle,$messagesAlert,$users,$pkQuotation);
                      $mail = $this->sendMail($messagesTitle,$messagesAlert,$users,$quotationres->folio, $quotationdetail->number_places,$price);
                    // return $alert;
                    /* if($alert == "true" && $mail == "true"){
                     
                     }else{
                      $flag == "false";   
                     }*/
                  //   $messageTitle   = "";
                  /*  $infoEmail = DB::table('quotations as q')
                                   ->join('business as b','b.pkBusiness','=','q.fkBusiness')
                                   ->join('quotations_detail as d','d.fkQuotations','=','q.pkQuotations')
                                   ->join('users as u','u.pkUser','=','q.fkUser')
                                   ->where('q.status','=',1)
                                   ->where('b.status','=',1)
                                   ->where('d.status','=',1)
                                   ->where('d.pkQuotations_detail','=',$option)
                                   ->where('q.pkQuotations','=',$pkQuotation)
                                   ->first();
                    
                    
                    $mail = new PHPMailer(true);
                    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = $this->host;             // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = $this->username;      // SMTP username
                    $mail->Password = $this->password;                    // SMTP password
                    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 465;
                    
                    $mail->setFrom('info@entornodepruebas.com', 'Abrevius');
                    $mail->addAddress('development@appendcloud.com');     // Add a recipient
                    $mail->addReplyTo('info@entornodepruebas.com', 'Abrevius');
                    //$mail->addCC('development@appendcloud.com');

                    $meesage = view('emails.quotation', array(
                        "infoEmail"   => $infoEmail
                            ))->render();


                    $mail->isHTML(true);                
                    $mail->CharSet = 'UTF-8'; // Set email format to HTML// Set email format to HTML
                    $mail->Subject = "Cotizaci&oacute;n";
                    $mail->Body = $meesage;
                    $mail->send();*/
                   }
                    
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
        
	public function paymetQuotation(Request $request) 
        {
            $pkQuotations         = $request->input("pkQuotations");
            
            $folio = DB::table('quotations')
                       ->select('folio')
                       ->where('pkQuotations','=',$pkQuotations)
                       ->first();
           
            $quotation   = DB::table('quotations')
                            ->select('pkQuotations'
                                    ,'name'
                                    ,'fkOpportunities'
                                    ,'fkBusiness'
                                    ,'fkUser'
                                    ,'fkContact_by_business'
                                    ,'fkLevel_interest'
                                    ,'quotations_status'
                                    ,'final_date')
                              ->where('pkQuotations','=',$pkQuotations)
                              ->first();
            
            $infoFacture = DB::table('info_facture')
                             ->where('status','=',1)
                             ->where('fkOrder','=',$pkQuotations)
                             ->first();
            
            $payment = DB::table('payment_forms_billing')
                        ->select('pkPayment_forms_billing'
                                ,'code'
                                ,'name')
                        ->where('status','=',1)
                        ->get();
           
           $method = DB::table('payment_methods_billing')
                        ->select('pkPayment_methods_billing'
                                ,'code'
                                ,'name')
                        ->where('status','=',1)
                        ->get();
           
           $condition = DB::table('payment_condition_billing')
                        ->select('pkPayment_condition_billing'
                                ,'code'
                                ,'name')
                        ->where('status','=',1)
                        ->get();
            
           $usocfdi = DB::table('f4_c_usocfdi')
                        ->select('id'
                                ,'c_UsoCFDI'
                                ,'Descripción')
                        ->where('status','=',1)
                        ->get();
           
           $claveser = DB::table('f4_c_claveserv')
                        ->select('pkF4_c_claveserv'
                                ,'code'
                                ,'name')
                        ->where('status','=',1)
                        ->get();
           
           $claveuni = DB::table('f4_c_claveunity')
                        ->select('pkF4_c_claveunity'
                                ,'code'
                                ,'name')
                        ->where('status','=',1)
                        ->get();

            $QuotationCourse = DB::table('quotations_detail as q')
                                ->join('quotation_by_courses as d','d.fkQuotationDetail','=','q.pkQuotations_detail')
                                ->leftjoin('courses as c','c.pkCourses','=','d.fkCourses')
                                ->select('c.code'
                                        ,'d.pk_quotation_by_courses'
                                        ,'c.name'
                                        ,'d.places'
                                        ,'d.price')
                                ->where('q.fkQuotations','=',$pkQuotations)
                                ->where('q.isSelected','=',1)
                                ->where('q.status','=',1)
                                ->where('d.status','=',1)
                                ->get();
            
              $view = view('cotizaciones.paymentQuotation', array(
                                  "quotation"       => $quotation,
                                  "infoFacture"     => $infoFacture,
                                  "payment"         => $payment,
                                  "method"          => $method,
                                  "condition"       => $condition,
                                  "usocfdi"         => $usocfdi,
                                  "claveser"        => $claveser,
                                  "claveuni"        => $claveuni,
                                  "QuotationCourse" => $QuotationCourse,
                                  "folio"           => $folio->folio
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));     
        }
        
        public function paymetQuotationDB(Request $request){
            
            $pkQuotations   = $request->input("pkQuotations");
            $social        = $request->input("social");
            $rfc           = $request->input("rfc");
            $address       = $request->input("address");
            $phone         = $request->input("phone");
            $mail          = $request->input("mail");
            $cfdi          = $request->input("cfdi");
            $document      = $request->file('document');
            $slcPayment    = $request->input("slcPayment");
            $paymentDocument = "";
            
            $startDateUTC = date("Y-m-d H:i:s");
            $DateTime = explode(" ", $startDateUTC);
           
            $flag               = "true";
            $message            = "true";
            DB::beginTransaction();
            
            try { 
                
                 if($document != ''){ 
                    if(file_exists ($document)){
                        $nameFile = $document->getClientOriginalName();
                        if($nameFile!=''){
                            $ext            = $document->extension();
                            
                            if(($ext == 'png') ||($ext == 'jpg')||($ext == 'jpeg')||($ext == 'pdf')){
                
                                   $destinationPath = base_path('/public/images/business/');
                                    $document->move($destinationPath, 'paymentComprobant'.$pkQuotations.'.'.$ext);
                                    
                                    $paymentDocument = "paymentComprobant".$pkQuotations.".".$ext;
                                   
                            }
                        }
                    }
                 }
                 
                $updateQuotation = DB::table("quotations")
                                      ->where("pkQuotations", "=" ,$pkQuotations)
                                      ->update(['quotations_status' => 5
                                               ,'business_name'     => $social
                                               ,'rfc'               => $rfc
                                               ,'address'           => $address
                                               ,'phone'             => $phone
                                               ,'email'             => $mail
                                               ,'cfdi'              => $cfdi
                                               ,'payment'           => $paymentDocument
                                               ,'fkPayment_methods' => $slcPayment]);
                 
                if($updateQuotation >= 1){
                    
                     $statusText = "Pagada";
                  
                  $quotationres = DB::table('quotations')
                             ->select('fkBusiness'
                                     ,'fkUser')
                             ->where('status','=',1)
                             ->where('pkQuotations','=',$pkQuotations)
                             ->first();
                  
                  $quotationdetail = DB::table('quotations_detail')
                                        ->select('price'
                                                ,'number_places')
                                        ->where('fkQuotations','=',$pkQuotations)
                                        ->where('isSelected','=',1)
                                        ->first();
                  
                    $insertActivity = new Activities;
                    $insertActivity->fkBusiness = $quotationres->fkBusiness;
                    $insertActivity->fkUser = $quotationres->fkUser;
                    $insertActivity->fkActivities_type = -2;
                    $insertActivity->description = "Cotización ".$statusText. " con # ".$quotationdetail->number_places ." asientos y un costo de $ ".$quotationdetail->price;
                    $insertActivity->register_date = $DateTime[0];
                    $insertActivity->register_hour = $DateTime[1];
                    $insertActivity->document = "";
                    $insertActivity->status = 1;

                    if ($insertActivity->save()) {
                        
                    } else {
                        $flag = "false";
                        $message .= "Error al cargar actividad \n";
                    }

                }else{
                 $flag = "false";
                 $message = "error al modificar estado";
                }

                if($flag == "true"){

                    DB::commit();
                    return "true";
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
        
        public function viewQuotationFormat($pkQuotation){
            
             $cursesArray = array();
            
              $infoEmail = DB::table('quotations as q')
                                   ->leftjoin('business as b','b.pkBusiness','=','q.fkBusiness')
                                   ->leftjoin('users as u','u.pkUser','=','q.fkUser')
                                   ->where('q.status','=',1)
                                   ->where('b.status','=',1)
                                   ->where('q.pkQuotations','=',$pkQuotation)
                                   ->first();
              
              $infoDetailQuotation = DB::table('quotations_detail')
                                       ->select('number_places'
                                               ,'price'
                                               ,'iva'
                                               ,'isSelected'
                                               ,'pkQuotations_detail'
                                               ,DB::raw("DATE_FORMAT(date, '%d de %b, %Y') as date")
                                               ,DB::raw("(CASE WHEN type = 0 THEN 'Precio Lista' 
                                                     WHEN type = 1 THEN 'Promocion'
                                                     ELSE 'N/A' END) as type")
                                               )
                                      ->where('fkQuotations','=',$pkQuotation)
                                      ->where('fkQuotations','=',$pkQuotation)
                                      ->where('status','=',1)
                                      ->where('isSelected','=',1)
                                      ->get();
              
           
              foreach($infoDetailQuotation as $info){
                  
                     if($infoEmail->withIva){
                    $info->price = $this->helper->getPriceWithIvaQuotation($info->price,$info->iva);
                  }
              
                  
                  $courses = DB::table('quotation_by_courses as q')
                               ->join('courses as c','c.pkCourses','=','q.fkCourses')
                               ->select('c.name'
                                       ,'c.code'
                                       ,'c.link'
                                       ,'q.places')
                               ->where('q.fkQuotationDetail','=',$info->pkQuotations_detail)
                               ->where('q.status','=',1)
                               ->get();
                  
                  $cursesArray[$info->pkQuotations_detail] = $courses;
              }
              
              
              return view('cotizaciones.quotationDocument')->with('infoEmail',$infoEmail)
                                                               ->with('infoDetailQuotation',$infoDetailQuotation)
                                                               ->with('cursesArray',$cursesArray);
              
        }
        
        public function viewQuotationFormatOpen($pkQuotation){
            
            $cursesArray = array();
            
              $infoEmail = DB::table('quotations as q')
                                   ->leftjoin('business as b','b.pkBusiness','=','q.fkBusiness')
                                   ->leftjoin('users as u','u.pkUser','=','q.fkUser')
                                   ->where('q.status','=',1)
                                   ->where('b.status','=',1)
                                   ->where('q.pkQuotations','=',$pkQuotation)
                                   ->first();
              
              $infoDetailQuotation = DB::table('quotations_detail')
                                       ->select('number_places'
                                               ,'price'
                                               ,'iva'
                                               ,'pkQuotations_detail'
                                               ,DB::raw("DATE_FORMAT(date, '%d de %b, %Y') as date")
                                               ,DB::raw("(CASE WHEN type = 0 THEN 'Precio Lista' 
                                                     WHEN type = 1 THEN 'Promocion'
                                                     ELSE 'N/A' END) as type")
                                               )
                                      ->where('fkQuotations','=',$pkQuotation)
                                      ->where('status','=',1)
                                      ->get();
              
           
              foreach($infoDetailQuotation as $info){
                  
                     if($infoEmail->withIva){
                    $info->price = $this->helper->getPriceWithIvaQuotation($info->price,$info->iva);
                  }
              
                  
                  $courses = DB::table('quotation_by_courses as q')
                               ->join('courses as c','c.pkCourses','=','q.fkCourses')
                               ->select('c.name'
                                       ,'c.code'
                                       ,'c.link'
                                       ,'q.places')
                               ->where('q.fkQuotationDetail','=',$info->pkQuotations_detail)
                               ->where('q.status','=',1)
                               ->get();
                  
                  $cursesArray[$info->pkQuotations_detail] = $courses;
              }
              
                            
 
              return view('cotizaciones.quotationDocumentOpen')->with('infoEmail',$infoEmail)
                                                               ->with('infoDetailQuotation',$infoDetailQuotation)
                                                               ->with('cursesArray',$cursesArray);
              
        }
        
        public function verCotizacionesFacturar(){
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
                                                    WHEN o.quotations_status = 5 THEN 'Pendiente de pago'
                                                    WHEN o.quotations_status = 6 THEN 'Pagada'
                                                     WHEN o.quotations_status = 7 THEN 'Facturada'
                                                    ELSE 'N/A' END) as quotations_status"))
                            ->where('o.status','=',1)
                            ->where('o.quotations_status','=',6)
                            ->get();
            
             return view('cotizaciones.verCotizaciones', ["quotation" => $quotation]); 
        }
        
        public function searchQuotations(Request $request){
         
            $status     = $request->input("status");
            $agent      = $request->input("agent");
            $fechStart  = $request->input("fechStart");
            $fechFinish = $request->input("fechFinish");

            $arrayPermition["viewQuotes"]   = $this->UserPermits->getPermition("viewQuotes");
            $arrayPermition["money"]        = $this->UserPermits->getPermition("money");
            $arrayPermition["invoice"]      = $this->UserPermits->getPermition("invoice");
            $arrayPermition["editQuotes"]   = $this->UserPermits->getPermition("editQuotes");
            $arrayPermition["changeQuotes"] = $this->UserPermits->getPermition("changeQuotes");
            $arrayPermition["deleteQuotes"] = $this->UserPermits->getPermition("deleteQuotes");

            $day   = $request->input("day");
            $month = $request->input("month");
            $year  = $request->input("year");

            if(empty($fechStart) && empty($fechFinish)){
                if ($day > 0) {
                    $fechStart = date("Y-m-d");
                    $fechFinish = date("Y-m-d");
                }
                if ($month > 0) {
                    $fechStart = date("Y-m") . "-01";
                    $month = date("Y-m");
                    $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
                    $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));
                    $fechFinish = $last_day;
                }
                if ($year > 0) {
                    $fechStart = date("Y") . "-01-01";
                    $fechFinish = date("Y") . "-12-31";
                }
            }
                  
            $montArray = array();
            
             $quotation = DB::table('quotations as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->leftjoin('users as u','u.pkUser','=','o.fkUser')
                            ->leftjoin('users as a','a.pkUser','=','o.asing')
                            ->leftjoin('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->leftjoin('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->select('o.pkQuotations'
                                    ,'o.name'
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
                                    ,'o.money_in_account'
                                    ,'o.withIva'
                                    ,'o.quotations_status as quotation_status'
                                    ,DB::raw("(CASE WHEN o.quotations_status = 1 THEN 'Abierta' 
                                                    WHEN o.quotations_status = 2 THEN 'Rechazada'
                                                    WHEN o.quotations_status = 3 THEN 'Cancelada'
                                                    WHEN o.quotations_status = 4 THEN 'Revisión de pago'
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
                                         . ' ORDER BY pkInfoFacture desc limit 1) as pay'));
              $conditionDateAux="";              
          if((!empty($fechStart)) && (!empty($fechFinish))){
             $conditionDateAux .= ' AND ((o.final_date >= "'.$fechStart.'" AND o.final_date<= "'.$fechFinish.'" )  or (o.register_day >= "'.$fechStart.'" and o.register_day <= "'.$fechFinish.'"))';   
            }    
        
                            
             
              if($status > 0){
             $quotation = $quotation->where('o.quotations_status','=',$status);   
            }
            
             if($agent > 0){
             $quotation = $quotation->where('o.fkUser','=',$agent);   
            }
           /*
            
            if(!empty($fechStart)){
             $quotation = $quotation->whereDate('o.register_day','>=',$fechStart);   
            }
            
            if(!empty($fechFinish)){
             $quotation = $quotation->whereDate('o.register_day','<=',$fechFinish);   
            }
             */
            
       $quotation =    $quotation->where('o.status','=',1)
                            ->whereRaw('b.status =1 '.$conditionDateAux)
                            ->where('u.status','=',1)
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
                                    $price = 0;
                                    
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
                 
                                    $documents = DB::table('info_facture as i')
                                          ->select('pdf'
                                                  ,'xml'
                                                  ,'pay')
                                          ->where('fkOrder','=',$item->pkQuotations)
                                          ->where('status','=',1)
                                          ->first();
                 
                                     $pdf = "";
                                     $xml = "";
                                     $pay = "";
                 
                                     if(!empty($documents->pay)){
                                         $pdf = $documents->pdf;
                                         $xml = $documents->xml;
                                         $pay = $documents->pay;
                                     }
                                 
                                   $montArray[$item->pkQuotations]["price"][$montInfo->pkQuotations_detail] = array("price"      => $price
                                                                                                                   ,"isSelected" => $montInfo->isSelected
                                                                                                                   ,"num"        => $montInfo->pkQuotations_detail
                                                                                                                   ,"type"       => $type
                                                                                                                   ,"pdf"        => $pdf
                                                                                                                   ,"xml"        => $xml
                                                                                                                   ,"pay"        => $pay);
                                   
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

          //*** Para obtener total de cotizaciones abiertas y pendientes de pago de la opcion con el monto mas bajo
          $quotationMonth = 0;
          $conditionDate   = "";
          $quotationsArray = array();
          

          if($status > 0){
             $conditionDate .= ' AND quotations.quotations_status= '.$status.' ';   
            }
            
             if($agent > 0){ 
             $conditionDate .= ' AND quotations.fkUser= '.$agent.' '; 
            }
           
            
            if((!empty($fechStart)) && (!empty($fechFinish))){
             $conditionDate .= ' AND ((quotations.final_date >= "'.$fechStart.'" AND quotations.final_date<= "'.$fechFinish.'" )  or (register_day >= "'.$fechStart.'" and register_day <= "'.$fechFinish.'"))';   
            }
            
            $quotationsQuery = DB::table('quotations')
                                ->join('business as b','b.pkBusiness','=','quotations.fkBusiness')
                                ->where('quotations.status','=',1)
                                
                                ->whereRaw('quotations.status=1 '.$conditionDate)
                                ->select('pkQuotations','quotations_status','withIva')
                                ->get();
            

            
          
          foreach ($quotationsQuery as $quotationsInfo) {
              if($quotationsInfo->quotations_status == '1'){
                  $quotationsDetailQuery = DB::table('quotations_detail')
                                            ->where('fkQuotations','=',$quotationsInfo->pkQuotations)
                                            ->where('status','=',1)
                                            ->select('price','iva')
                                            ->get();
              }else{
                  $quotationsDetailQuery = DB::table('quotations_detail')
                                            ->where('fkQuotations','=',$quotationsInfo->pkQuotations)
                                            ->where('isSelected','=',1)
                                            ->where('status','=',1)
                                            ->select('price','iva')
                                            ->get();
              }
              
              
                foreach ($quotationsDetailQuery as $quotationsDetailInfo) {
                    
                    if($quotationsInfo->withIva < 1){
                        $newPriceIVA = $quotationsDetailInfo->price;
                    }else{
                        $newPriceIVA = $this->helper->getPriceWithIvaQuotation($quotationsDetailInfo->price, $quotationsDetailInfo->iva);
                    }
                                        
                    if(isset($quotationsArray[$quotationsInfo->pkQuotations])){
                        if($quotationsArray[$quotationsInfo->pkQuotations] > $newPriceIVA){
                            $quotationsArray[$quotationsInfo->pkQuotations] = $newPriceIVA;
                        }
                    }else{
                        $quotationsArray[$quotationsInfo->pkQuotations] = $newPriceIVA;
                    }
                }
          }
        
          foreach ($quotationsArray as $key => $value) {
              $quotationMonth = $quotationMonth + $value;
          }
          //****
              
               $view = view('cotizaciones.getQuotation', array(
                    "quotation" => $quotation
                   ,"montInfo"  => $montArray
                   ,"arrayPermition" => $arrayPermition
                        ))->render();
        
            return \Response::json(array(
                                  "valid"   => "true",
                                  "view"    => $view,
                                  "total"   => $quotationMonth
                                ));   
            
        }
        
        public function getPriceQuotation(Request $request){
            
            $qtyPlaces      = $request->input("qtyPlaces");
            $placesTotal    = $request->input("places");
            $type           = $request->input("type");
            $totalPrice     = str_replace(",","",$request->input("total"));
           
          // dd($totalPrice);
           
            $priceIva    = 0;
            $subtotalIva = 0;
            $totalIva    = 0;
            $descIva     = 0;
            
    if(empty($totalPrice)){
            $pricePerPlaces = DB::table('price_places')
                                ->select('pkPrice_place'
                                         ,'price')
                                ->where('status','=',1)
                                ->first();
            
            $priceBase = $qtyPlaces * (float) $pricePerPlaces->price;
            
            $subtotal = $placesTotal * (float) $pricePerPlaces->price;
            $total    = $subtotal;
            $desc     = 0;
            $haveDesc = "";
            

            if($type == 1){
               
            $haveDescQ  = DB::table('discount_places')
                           ->select('pkDiscount_places'
                                   ,'cantPlaces'
                                   ,'discount')
                           ->where('status','=',1)
                           ->where(function ($query)  use ($placesTotal){
                           $query->where('cantPlaces','<=',$placesTotal);
                                //->Where('cantPlaces','<=',$placesTotal);
                             })
                          // ->orderby('discount','desc')
                           ->get();
                             
              foreach($haveDescQ as $haveDescInfo){
                  $descAux = $haveDescInfo->discount;
                  if($descAux <= $haveDescInfo->discount){
                      
                     $haveDesc =  (double) $haveDescInfo->discount;
                     $descAux = $haveDesc;
                  }
              }
            
             if(!empty($haveDesc)){
                 $desc      = ($subtotal * $haveDesc) / 100;
                 $total     =  $subtotal - $desc;
                 
             }

            }

             $priceIva    = $this->helper->getPriceWithIva($priceBase);
              $subtotalIva = $this->helper->getPriceWithIva($subtotal);
              $descIva     = $this->helper->getPriceWithIva($desc);
              $totalIva    = $this->helper->getPriceWithIva($total);

              $priceUnit    =  $this->helper->getPriceUnit($subtotal,$placesTotal,$qtyPlaces);
              $priceUnitIva =  $this->helper->getPriceWithIva($priceUnit);
        }
        else{

            $priceIva=  $placesTotal / (double) $totalPrice;
            $desc      =  0;
            $subtotalIva  =  (double) $totalPrice; 
            $totalIva      =  (double) $totalPrice;

            $priceBase   = $this->helper->getPriceWithNotIva($priceIva);
            $subtotal = $this->helper->getPriceWithNotIva($subtotalIva);
            $descIva     = $this->helper->getPriceWithNotIva($desc);
            $total    = $this->helper->getPriceWithNotIva($totalIva);

            $priceUnitIva =  $this->helper->getPriceUnit($totalIva,$placesTotal,$qtyPlaces);
            $priceUnit    =  $this->helper->getPriceWithNotIva($priceUnitIva);
 
        }

            

             return \Response::json(array(
                                  "priceIva"     => $priceIva,
                                  "price"        => $priceBase,
                                  "priceUnit"    => $priceUnit,
                                  "priceUnitIva" => $priceUnitIva,
                                  "subtotal"     => $subtotal,
                                  "descuento"    => $desc,
                                  "total"        => $total,
                                  "subtotalIva"  => $subtotalIva,
                                  "descuentoIva" => $descIva,
                                  "totalIva"     => $totalIva 
                                ));
        }
        
        public function setPaymentInCount(Request $request){
          $pkQuotation       = $request->input("pkQuotation");
          $flag              = "true";
          $startDateUTC = date("Y-m-d H:i:s");
          $DateTime = explode(" ", $startDateUTC);
          
          
           DB::beginTransaction();
            
            try { 
            $quotationInfo   = DB::table("quotations")
                                    ->where('pkQuotations','=',$pkQuotation)
                                    ->where('status','=',1)
                                    ->update(array("quotations_status" => 5));
            
            if($quotationInfo >= 1){
                    
                     $statusText = "Pagada";
                  
                  $quotationres = DB::table('quotations')
                             ->select('fkBusiness'
                                     ,'fkUser'
                                     ,'withIva'
                                     ,'folio')
                             ->where('status','=',1)
                             ->where('pkQuotations','=',$pkQuotation)
                             ->first();
                  
                  $quotationdetail = DB::table('quotations_detail')
                                        ->select('price'
                                                ,'number_places')
                                        ->where('fkQuotations','=',$pkQuotation)
                                        ->where('isSelected','=',1)
                                        ->first();

                   $bussines = DB::table('business')
                                        ->select('name')
                                        ->where('pkBusiness','=',$quotationres->fkBusiness)
                                        ->first();

                    $price = 0;

                    if($quotationres->withIva == 1){
                       $price =    $this->helper->getPriceWithIva($quotationdetail->price);
                     }else{
                       $price = $quotationdetail->price;
                    }
                 
                    $insertActivity = new Activities;
                    $insertActivity->fkBusiness = $quotationres->fkBusiness;
                    $insertActivity->fkUser = $quotationres->fkUser;
                    $insertActivity->fkActivities_type = -2;
                    $insertActivity->description = "Venta cerrada en empresa ".$bussines->name ." con folio #: " . $quotationres->folio . ", con # " . $quotationdetail->number_places . " lugares y un monto de $ " . number_format($price,2);
                    $insertActivity->register_date = $DateTime[0];
                    $insertActivity->register_hour = $DateTime[1];
                    $insertActivity->document = "";
                    $insertActivity->status = 1;
                    
                     if($insertActivity->save()) {
                         
                         $statusUpdate   = DB::table("status_by_bussines")
                                    ->where('fkQuotations','=',$pkQuotation)
                                    ->where('status','=',1)
                                    ->update(array("fkBusiness_status" => 9));
                         
                        
                         if ($statusUpdate >= 0) {
                        $messagesTitle = "Se ha cerrado una venta";
                        $messagesAlert = "Cotización de la empresa ".$bussines->name ." con folio: " . $quotationres->folio . " con # " . $quotationdetail->number_places . " lugares y un monto de $ " . number_format($price,2);

                        $users = DB::table('users')
                                ->where('status','=',1)
                                ->get();

                        $alert = $this->createAlert($messagesTitle, $messagesAlert, $users, $pkQuotation);
                        $mail = $this->sendMail($messagesTitle,$messagesAlert,$users,$quotationres->folio, $quotationdetail->number_places,$price);
                        
                         if($alert == "true" && $mail == "true"){
                     
                     }else{
                      $flag == "false aqui 4";   
                     }
                        
                    } else {
                        $flag = "false aqui 2: ".$statusUpdate;
                    }
                } else {
                    $flag = "false aqui 1";
                }

        $monthActual = date('m');
        $yearActual = date('Y');
        $numDaysMonth = cal_days_in_month(CAL_GREGORIAN, $monthActual, $yearActual); 

        $dayActual = $yearActual."-".$monthActual."-1";
        $dayFinish = $yearActual."-".$monthActual."-".$numDaysMonth;
        //ver si usuario ha llegado a la meta del bono
         $meta = DB::table('agent_by_bond as a')
                   ->join('bond_base as b',function($join){
                     $join->on('b.pkBond_base', '=', 'a.fkBond')
                          ->where('a.typeBond','=',1);
                    })
                   ->select('b.montRec'
                           ,'b.firstAgent'
                           ,'b.pkBond_base')
                   ->whereDate('b.dateBon','>=',$dayActual)
                   ->whereDate('b.dateBon','<=',$dayFinish)
                   ->where('b.status','=',1)
                   ->where('a.status','=',1)
                   ->where('a.fkUser','=', $quotationres->fkUser)
                   ->first();

         $sales = DB::table('quotations as q')
                    ->join('quotations_detail as d',function($join){
                     $join->on('d.fkQuotations', '=', 'q.pkQuotations')
                          ->where('d.isSelected','=',1);
                    })
                    ->whereDate('q.final_date','>=',$dayActual)
                    ->whereDate('q.final_date','<=',$dayFinish)
                    ->where('q.quotations_status','=',5)
                    ->sum('d.price');

        $salesReal = $sales;// + $quotationdetail->price;

            if(!empty($meta->firstAgent)){
                
                if($meta->montRec <= $salesReal){
  
                    $updateFirst = DB::table("bond_base")
                                 ->where("pkBond_base", "=" ,$meta->pkBond_base)
                                 ->update(['firstAgent' => $quotationres->fkUser]);
                    
                    if($updateFirst >= 1){

                        $nameUsers = DB::table('users')
                                        ->select('full_name')
                                        ->where('pkUser','=',$quotationres->fkUser)
                                        ->first();

                        $title = "Bono base alcanzado por ".$nameUsers->full_name;
                        $messages = "Felicidades el vendedor ".$nameUsers->full_name." a sido el primero en alcanzar el Bono base";

                        $alertBond = $this->createAlert($title, $messages, $users, $pkQuotation);

                        if($alertBond == "true"){
                     
                        }else{
                         $flag == "false not alert bond";   
                        }

                    }else{
                       $flag = "false line x";    
                    }


                }
            }

            }else{
               $flag = "false sin datos";  
            }
            
            if($flag == "true"){
                DB::commit();
                return "true";
            }else{
                 DB::rollback(); 
                return "false xx quien".$flag;
            }   
            
            }catch (\Exception $e) {
                DB::rollback(); 
                //return "Error del sistema, favor de contactar al desarrollador";
                return $e->getMessage();
          }   
              
        }
        
        public function viewPreFacture($id){
            
            $total = 0;
            $iva   = 0;
            $infoFacture = DB::table('quotations as q')
                           ->join('quotations_detail as d','d.fkQuotations','=','q.pkQuotations')
                           ->join('info_facture as i','i.fkOrder','=','q.pkQuotations')
                           ->leftjoin('f4_c_usocfdi as u','u.id','=','i.cfdi')
                           ->leftjoin('f4_c_claveserv as s','s.pkF4_c_claveserv','=','i.productKey')
                           ->leftjoin('f4_c_claveunity as c','c.pkF4_c_claveunity','=','i.unitKey')
                           ->leftjoin('payment_forms_billing as p','p.pkPayment_forms_billing','=','i.payment')
                           ->leftjoin('payment_methods_billing as m','m.pkPayment_methods_billing','=','i.method')
                           ->leftjoin('payment_condition_billing as b','b.pkPayment_condition_billing','=','i.conditionPayment')
                           ->select('q.folio'
                                   ,'q.withIva'
                                   ,'d.number_places'
                                   ,'d.price'
                                   ,'d.iva'
                                   ,'i.rfc'
                                   ,'i.razon'
                                   ,'i.serie'
                                   ,'i.dateFact'
                                   ,'i.comment'
                                   ,'i.cfdi'
                                   ,'i.payment'
                                   ,'i.method'
                                   ,'i.conditionPayment'
                                   ,'i.productKey'
                                   ,'i.unitKey'
                                   ,'i.numIdentification'
                                   ,'i.description'
                                   ,'u.c_UsoCFDI'
                                   ,'u.Descripción'
                                   ,'s.code as claveser'
                                   ,'s.name as nameser'
                                   ,'c.code as claveunit'
                                   ,'c.name as nameunit'
                                   ,'p.code as paymentcode'
                                   ,'p.name as paymentname'
                                   ,'m.code as methodcode'
                                   ,'m.name as methodname'
                                   ,'b.code as contiditioncode'
                                   ,'b.name as contiditionname')
                          ->where('d.isSelected','=',1)
                          ->where('d.status','=',1)
                          ->where('q.status','=',1)
                          ->where('i.status','=',1)
                          ->where('q.pkQuotations','=',$id)
                          ->first();
            
            if($infoFacture->withIva){
                $total = $this->helper->getPriceWithIvaQuotation($infoFacture->price,$infoFacture->iva);
                $iva   = $infoFacture->iva;
            }else{
                $total   = $infoFacture->price;
            }
            
             $numf = $this->milmillon((string)$total);

             $QuotationCourse = DB::table('quotations_detail as q')
             ->join('quotation_by_courses as d','d.fkQuotationDetail','=','q.pkQuotations_detail')
             ->leftjoin('courses as c','c.pkCourses','=','d.fkCourses')
             ->select('c.code'
                     ,'d.pk_quotation_by_courses'
                     ,'c.name'
                     ,'d.description'
                     ,'d.places'
                     ,'d.price')
             ->where('q.fkQuotations','=',$id)
             ->where('q.isSelected','=',1)
             ->where('q.status','=',1)
             ->where('d.status','=',1)
             ->get();
             
           return view('cotizaciones.prefactura')->with('infoFacture',$infoFacture)
                                                 ->with('numf',$numf)
                                                 ->with('total',$total)
                                                 ->with('iva',$iva)
                                                 ->with('id',$id)
                                                 ->with('QuotationCourse',$QuotationCourse);
        }
        
        public function prefacture(Request $request){

            $flag          = "true";
            $pkQuotations  = $request->input("pkQuotation");
            $seriea        = $request->input("serie");
            $slccfdi       = $request->input("slccfdi");
            $payment       = $request->input("payment");
            $method        = $request->input("method");
            $condition     = $request->input("condition");
            $rfca          = $request->input("rfc");
            $social        = $request->input("social");
            $slcProduct    = $request->input("slcProduct");
            $slcUnity      = $request->input("slcUnity");
            $numIden       = $request->input("numIden");
            $comment       = $request->input("comment");
            $desc          = json_decode($request->input("description"));
            $Fecha         = date('Y-m-d\TH:i:s');
            $day           = date('Y-m-d');

           $updateInfoFacture = DB::table("info_facture")
                        ->where("fkOrder", "=" ,$pkQuotations)
                        ->update(['rfc'        => $rfca
                                 ,'razon'      => $social
                                 ,'serie'      => $seriea
                                 ,'dateFact'   => $Fecha
                                 ,'date_pre'   => $Fecha
                                 ,'cfdi'       => $slccfdi
                                 ,'payment'    => $payment
                                 ,'method'     => $method
                                 ,'conditionPayment'  => $condition
                                 ,'comment'    => $comment
                                 ,'productKey' => $slcProduct
                                 ,'unitKey'    => $slcUnity]);
                                 
            if($updateInfoFacture >= 1){

                foreach($desc as $key => $descInfo){
                  $updateInfo = DB::table("quotation_by_courses")
                                  ->where("pk_quotation_by_courses", "=" ,$descInfo->id)
                                  ->update(['description' => $descInfo->desc]);
              }

            }else{
                $flag = "false";
            }
         
            return $flag;

        }

        public function generateInvoice(Request $request) 
        {
            $pkQuotations   = $request->input("pkQuotation");
             
            $seriea         = $request->input("serie");
            $slccfdi       = $request->input("slccfdi");
            $payment       = $request->input("payment");
            $method        = $request->input("method");
            $condition     = $request->input("condition");
            $rfca          = $request->input("rfc");
            $social        = $request->input("social");
            $slcProduct    = $request->input("slcProduct");
            $slcUnity      = $request->input("slcUnity");
            $numIden       = $request->input("numIden");
            $desc          = $request->input("desc");
            
            $infoFacture = DB::table('quotations as q')
                           ->leftjoin('quotations_detail as d','d.fkQuotations','=','q.pkQuotations')
                           ->leftjoin('info_facture as i','i.fkOrder','=','q.pkQuotations')
                           ->leftjoin('f4_c_usocfdi as u','u.id','=','i.cfdi')
                           ->leftjoin('f4_c_claveserv as s','s.pkF4_c_claveserv','=','i.productKey')
                           ->leftjoin('f4_c_claveunity as c','c.pkF4_c_claveunity','=','i.unitKey')
                           ->leftjoin('payment_forms_billing as p','p.pkPayment_forms_billing','=','i.payment')
                           ->leftjoin('payment_methods_billing as m','m.pkPayment_methods_billing','=','i.method')
                           ->leftjoin('payment_condition_billing as b','b.pkPayment_condition_billing','=','i.conditionPayment')
                           ->select('q.folio'
                                   ,'q.withIva'
                                   ,'d.iva'
                                   ,'d.number_places'
                                   ,'d.price'
                                   ,'i.rfc'
                                   ,'i.razon'
                                   ,'i.serie'
                                   ,'i.dateFact'
                                   ,'i.cfdi'
                                   ,'i.payment'
                                   ,'i.method'
                                   ,'i.conditionPayment'
                                   ,'i.productKey'
                                   ,'i.unitKey'
                                   ,'i.numIdentification'
                                   ,'i.description'
                                   ,'i.comment'
                                   ,'u.c_UsoCFDI'
                                   ,'u.Descripción'
                                   ,'s.code as claveser'
                                   ,'s.name as nameser'
                                   ,'c.code as claveunit'
                                   ,'c.name as nameunit'
                                   ,'p.code as paymentcode'
                                   ,'p.name as paymentname'
                                   ,'m.code as methodcode'
                                   ,'m.name as methodname'
                                   ,'b.code as contiditioncode'
                                   ,'b.name as contiditionname')
                          ->where('d.isSelected','=',1)
                          ->where('d.status','=',1)
                          ->where('q.status','=',1)
                          ->where('i.status','=',1)
                          ->where('q.pkQuotations','=',$pkQuotations)
                          ->first();

            
                          $QuotationCourse = DB::table('quotations_detail as q')
                          ->join('quotation_by_courses as d','d.fkQuotationDetail','=','q.pkQuotations_detail')
                          ->leftjoin('courses as c','c.pkCourses','=','d.fkCourses')
                          ->select('c.code'
                                  ,'d.pk_quotation_by_courses'
                                  ,'c.name'
                                  ,'d.description'
                                  ,'d.places'
                                  ,'d.price')
                          ->where('q.fkQuotations','=',$pkQuotations)
                          ->where('q.isSelected','=',1)
                          ->where('q.status','=',1)
                          ->where('d.status','=',1)
                          ->get();
            
            try{
                
                $iva                        = 0;
                $ivaPrice                   = 0.0;
              //  $usuario                    = 'demo2013';
              //  $contrasenia                = 'demo2019';
                $usuario                    = 'ABR170915L36';
                $contrasenia                = '51082';
                $serie                      = $infoFacture->serie;
                $idTipoComprobante          = '1';
                $Fecha                      = date('Y-m-d\TH:i:s');
                $SubTotal                   = $infoFacture->price;
                $Moneda                     = 'MXN';
                $Total                      = $infoFacture->price;
                $FormaPago                  = $infoFacture->paymentcode;//catalogo
                $MetodoPago                 = $infoFacture->methodcode;//catalogo
                $CondicionesDePago          = $infoFacture->conditionPayment;//catalogo
                $rfc                        = $infoFacture->rfc;//catalogo
                $usfdi                      = $infoFacture->c_UsoCFDI;//catalogo
                $name                       = $infoFacture->razon;
                $comment                    = $infoFacture->comment;
                
                $service                    = $infoFacture->claveser;
                $unity                      = $infoFacture->claveunit;
                $unityName                  = $infoFacture->nameunit;

                $concepto = "";
                $import                     = $infoFacture->price;
                //
                $totalCount = sizeof($QuotationCourse);
                $cont = 1;
                $ivaFact = $infoFacture->iva/100;
               
                foreach($QuotationCourse as $QuotationCourseInfo){

                    $NoIdentificacion           = $infoFacture->nameunit;
                    $description                = $desc;
                    $valorunit                  = $infoFacture->price;
                    $importIva = $QuotationCourseInfo->price * $infoFacture->iva/100;
         if($cont < $totalCount){
          $concepto .=    '  { '
                        . '       "ClaveProdServ": "'.$service.'",'
                        . '       "ClaveUnidad": "'.$unity.'",'
                       // . '     "NoIdentificacion": "'.$NoIdentificacion.'",'//Codigo del servicio o producto SKU
                        . '       "Cantidad": "'.$QuotationCourseInfo->places  .'",'
                        . '       "Unidad":  "'.$unityName.'",'
                        . '       "Descripcion": "'.$QuotationCourseInfo->description.'",'
                        . '       "ValorUnitario": "'.number_format($QuotationCourseInfo->price / $QuotationCourseInfo->places,2).'",'
                        . '       "Importe": "'.number_format($QuotationCourseInfo->price,2).'",'
                        . '       "Impuestos": {'
                        . '           "Traslados":  {'
                        . '               "Traslado": [{'
                        . '                   "Base": "'.number_format($QuotationCourseInfo->price,2).'",'
                        . '                   "Impuesto": "002",'
                        . '                   "TipoFactor": "Tasa",'
                        . '                   "TasaOCuota": "'.$ivaFact.'",'
                        . '                   "Importe": "'.number_format($importIva,2).'"'
                        . '               }]'
                        . '           }'
                        . '        }'
                        . '   },';
                
            }else{
                $concepto .=    '  { '
                    . '       "ClaveProdServ": "'.$service.'",'
                    . '       "ClaveUnidad": "'.$unity.'",'
                   // . '     "NoIdentificacion": "'.$NoIdentificacion.'",'//Codigo del servicio o producto SKU
                    . '       "Cantidad": "'.$QuotationCourseInfo->places  .'",'
                    . '       "Unidad": "'.$unityName.'",'
                    . '       "Descripcion": "'.$QuotationCourseInfo->description.'",'
                    . '       "ValorUnitario": "'.number_format($QuotationCourseInfo->price / $QuotationCourseInfo->places ,2).'",'
                    . '       "Importe": "'.number_format($QuotationCourseInfo->price,2).'",'
                    . '       "Impuestos": {'
                    . '           "Traslados":  {'
                    . '               "Traslado": [{'
                    . '                   "Base": "'.number_format($QuotationCourseInfo->price,2).'",'
                    . '                   "Impuesto": "002",'
                    . '                   "TipoFactor": "Tasa",'
                    . '                   "TasaOCuota": "'.$ivaFact.'",'
                    . '                   "Importe": "'.number_format($importIva,2).'"'
                    . '               }]'
                    . '           }'
                    . '        }'
                    . '   }';
            }
            $cont++;
        }
        
                
                if($infoFacture->withIva){
                  $Total    = number_format($this->helper->getPriceWithIvaQuotation($infoFacture->price,$infoFacture->iva),2);
                  $SubTotal = number_format($infoFacture->price,2);
                  $ivaPrice = number_format($infoFacture->price * ($infoFacture->iva/100),2);
                  $iva      = $infoFacture->iva / 100;
                }
               
            
                
               //     $url        = "http://devportal.kbill.mx/KbillService.svc?wsdl";
                      $url        = "https://wsemisionv3.kbill.mx/KbillService.svc?wsdl";
                 
                $params     = array(
                                    'encoding' => 'UTF-8',
                                    'verifyhost' => false
                                );
                
                $client     = new \SoapClient($url, $params);
                
                $response   = $client->Emision([
                                                'usuario'             => $usuario, 
                                                'contrasenia'         => $contrasenia, 
                                                'serie'               => $serie, 
                                                'idTipoComprobante'   => $idTipoComprobante, 
                                                'comprobanteCFDi'     => '{'
                                                                        . '"Fecha": "'.$Fecha.'",'
                                                                        . '"SubTotal": "'.$SubTotal.'",'
                                                                        . '"Moneda": "'.$Moneda.'",'
                                                                        . '"Total": "'.$Total.'",'
                                                                        . '"FormaPago": "'.$FormaPago.'",'
                                                                        . '"MetodoPago": "'.$MetodoPago.'",'
                                                                        . '"Comentario": "'.$comment.'",'
                                                                        . '"CondicionesDePago": "'.$CondicionesDePago.'",'
                                                                        . '"TipoCambio": "1",'
                                                                        . '"Receptor": {'
                                                                        . '   "Rfc":  "'.$rfc.'",'
                                                                        . '   "Nombre": "'.$name.'",'
                                                                        . '   "UsoCFDI": "'.$usfdi.'"},'
                                                                        . '"Conceptos": {'
                                                                        .' "Concepto": ['
                                                                            .$concepto
                                                                        . ']'
                                                                        . '}, '
                                                                        . '"Impuestos": {'
                                                                        . '   "TotalImpuestosTrasladados": "'.$ivaPrice.'",'
                                                                        . '   "Traslados": {'
                                                                        . '       "Traslado": [{'
                                                                        . '           "Impuesto": "002",'
                                                                        . '           "TipoFactor": "Tasa",'
                                                                        . '           "TasaOCuota": "'.$ivaFact.'",'
                                                                        . '           "Importe": "'.$ivaPrice.'"'
                                                                        . '       }]'
                                                                        . '   }'
                                                                        . '}'
                                                                        . '}'
                                                ]);
              //  return $response;
                 
                $resp = json_decode($response->EmisionResult);
           
               if($resp->response){
                   
                   $update = DB::table("info_facture")
                               ->where("fkOrder", "=" ,$pkQuotations)
                               ->where("status", "="  ,1)
                               ->update(['xml' => $resp->data->urlXML
                                        ,'pdf' => $resp->data->urlPDF]);
                   
                   $updateFacture = DB::table("quotations")
                               ->where("pkQuotations", "=" ,$pkQuotations)
                               ->where("status", "="  ,1)
                               ->update(['money_in_account' => 1]);
                   
                   return \Response::json(array(
                                  "valid"   => "true",
                                  "folio"   => $resp->data->folio,
                                  "UUID"    => $resp->data->UUID
                                ));     
               }else{
                   return \Response::json(array(
                                  "valid"    => "false",
                                   "message" => $resp->message
                                ));   
               }
                
            } catch (SoapFault $fail){
               return \Response::json(array(
                                  "valid"    => "false",
                                   "message" => $fail
                                ));
            }
            return $response;
        }
        
        private function unidad($numuero){
            $numu= "";
	switch ($numuero)
	{
		case 9:
		{
			$numu = "NUEVE";
			break;
		}
		case 8:
		{
			$numu = "OCHO";
			break;
		}
		case 7:
		{
			$numu = "SIETE";
			break;
		}		
		case 6:
		{
			$numu = "SEIS";
			break;
		}		
		case 5:
		{
			$numu = "CINCO";
			break;
		}		
		case 4:
		{
			$numu = "CUATRO";
			break;
		}		
		case 3:
		{
			$numu = "TRES";
			break;
		}		
		case 2:
		{
			$numu = "DOS";
			break;
		}		
		case 1:
		{
			$numu = "UN";
			break;
		}		
		case 0:
		{
			$numu = "";
			break;
		}		
	}
	return $numu;	
}

        private function decena($numdero){
	
		if ($numdero >= 90 && $numdero <= 99)
		{
			$numd = "NOVENTA ";
			if ($numdero > 90)
				$numd = $numd."Y ".($this->unidad($numdero - 90));
		}
		else if ($numdero >= 80 && $numdero <= 89)
		{
			$numd = "OCHENTA ";
			if ($numdero > 80)
				$numd = $numd."Y ".($this->unidad($numdero - 80));
		}
		else if ($numdero >= 70 && $numdero <= 79)
		{
			$numd = "SETENTA ";
			if ($numdero > 70)
				$numd = $numd."Y ".($this->unidad($numdero - 70));
		}
		else if ($numdero >= 60 && $numdero <= 69)
		{
			$numd = "SESENTA ";
			if ($numdero > 60)
				$numd = $numd."Y ".($this->unidad($numdero - 60));
		}
		else if ($numdero >= 50 && $numdero <= 59)
		{
			$numd = "CINCUENTA ";
			if ($numdero > 50)
				$numd = $numd."Y ".($this->unidad($numdero - 50));
		}
		else if ($numdero >= 40 && $numdero <= 49)
		{
			$numd = "CUARENTA ";
			if ($numdero > 40)
				$numd = $numd."Y ".($this->unidad($numdero - 40));
		}
		else if ($numdero >= 30 && $numdero <= 39)
		{
			$numd = "TREINTA ";
			if ($numdero > 30)
				$numd = $numd."Y ".($this->unidad($numdero - 30));
		}
		else if ($numdero >= 20 && $numdero <= 29)
		{
			if ($numdero == 20)
				$numd = "VEINTE ";
			else
				$numd = "VEINTI".($this->unidad($numdero - 20));
		}
		else if ($numdero >= 10 && $numdero <= 19)
		{
			switch ($numdero){
			case 10:
			{
				$numd = "DIEZ ";
				break;
			}
			case 11:
			{		 		
				$numd = "ONCE ";
				break;
			}
			case 12:
			{
				$numd = "DOCE ";
				break;
			}
			case 13:
			{
				$numd = "TRECE ";
				break;
			}
			case 14:
			{
				$numd = "CATORCE ";
				break;
			}
			case 15:
			{
				$numd = "QUINCE ";
				break;
			}
			case 16:
			{
				$numd = "DIECISEIS ";
				break;
			}
			case 17:
			{
				$numd = "DIECISIETE ";
				break;
			}
			case 18:
			{
				$numd = "DIECIOCHO ";
				break;
			}
			case 19:
			{
				$numd = "DIECINUEVE ";
				break;
			}
			}	
		}
		else
			$numd = $this->unidad($numdero);
	return $numd;
}

	private function centena($numc){
		if ($numc >= 100)
		{
			if ($numc >= 900 && $numc <= 999)
			{
				$numce = "NOVECIENTOS ";
				if ($numc > 900)
					$numce = $numce.($this->decena($numc - 900));
			}
			else if ($numc >= 800 && $numc <= 899)
			{
				$numce = "OCHOCIENTOS ";
				if ($numc > 800)
					$numce = $numce.($this->decena($numc - 800));
			}
			else if ($numc >= 700 && $numc <= 799)
			{
				$numce = "SETECIENTOS ";
				if ($numc > 700)
					$numce = $numce.($this->decena($numc - 700));
			}
			else if ($numc >= 600 && $numc <= 699)
			{
				$numce = "SEISCIENTOS ";
				if ($numc > 600)
					$numce = $numce.($this->decena($numc - 600));
			}
			else if ($numc >= 500 && $numc <= 599)
			{
				$numce = "QUINIENTOS ";
				if ($numc > 500)
					$numce = $numce.($this->decena($numc - 500));
			}
			else if ($numc >= 400 && $numc <= 499)
			{
				$numce = "CUATROCIENTOS ";
				if ($numc > 400)
					$numce = $numce.($this->decena($numc - 400));
			}
			else if ($numc >= 300 && $numc <= 399)
			{
				$numce = "TRESCIENTOS ";
				if ($numc > 300)
					$numce = $numce.($this->decena($numc - 300));
			}
			else if ($numc >= 200 && $numc <= 299)
			{
				$numce = "DOSCIENTOS ";
				if ($numc > 200)
					$numce = $numce.($this->decena($numc - 200));
			}
			else if ($numc >= 100 && $numc <= 199)
			{
				if ($numc == 100)
					$numce = "CIEN ";
				else
					$numce = "CIENTO ".($this->decena($numc - 100));
			}
		}
		else
			$numce = $this->decena($numc);
		
		return $numce;	
}

	private function miles($nummero){
		if ($nummero >= 1000 && $nummero < 2000){
			$numm = "MIL ".($this->centena($nummero%1000));
		}
		if ($nummero >= 2000 && $nummero <10000){
			$numm = $this->unidad(Floor($nummero/1000))." MIL ".($this->centena($nummero%1000));
		}
		if ($nummero < 1000)
			$numm = $this->centena($nummero);
		
		return $numm;
	}

	private function decmiles($numdmero){
		if ($numdmero == 10000)
			$numde = "DIEZ MIL";
		if ($numdmero > 10000 && $numdmero <20000){
			$numde = $this->decena(Floor($numdmero/1000))."MIL ".($this->centena($numdmero%1000));		
		}
		if ($numdmero >= 20000 && $numdmero <100000){
			$numde = $this->decena(Floor($numdmero/1000))." MIL ".($this->miles($numdmero%1000));		
		}		
		if ($numdmero < 10000)
			$numde = $this->miles($numdmero);
		
		return $numde;
	}		

	private function cienmiles($numcmero){
		if ($numcmero == 100000)
			$num_letracm = "CIEN MIL";
		if ($numcmero >= 100000 && $numcmero <1000000){
			$num_letracm = $this->centena(Floor($numcmero/1000))." MIL ".($this->centena($numcmero%1000));		
		}
		if ($numcmero < 100000)
			$num_letracm = $this->decmiles($numcmero);
		return $num_letracm;
	}	
	
	private function millon($nummiero){
		if ($nummiero >= 1000000 && $nummiero <2000000){
			$num_letramm = "UN MILLON ".($this->cienmiles($nummiero%1000000));
		}
		if ($nummiero >= 2000000 && $nummiero <10000000){
			$num_letramm = $this->unidad(Floor($nummiero/1000000))." MILLONES ".($this->cienmiles($nummiero%1000000));
		}
		if ($nummiero < 1000000)
			$num_letramm = $this->cienmiles($nummiero);
		
		return $num_letramm;
	}	

	private function decmillon($numerodm){
		if ($numerodm == 10000000)
			$num_letradmm = "DIEZ MILLONES";
		if ($numerodm > 10000000 && $numerodm <20000000){
			$num_letradmm = $this->decena(Floor($numerodm/1000000))."MILLONES ".($this->cienmiles($numerodm%1000000));		
		}
		if ($numerodm >= 20000000 && $numerodm <100000000){
			$num_letradmm = $this->decena(Floor($numerodm/1000000))." MILLONES ".($this->millon($numerodm%1000000));		
		}
		if ($numerodm < 10000000)
			$num_letradmm = $this->millon($numerodm);
		
		return $num_letradmm;
	}

	private function cienmillon($numcmeros){
		if ($numcmeros == 100000000)
			$num_letracms = "CIEN MILLONES";
		if ($numcmeros >= 100000000 && $numcmeros <1000000000){
			$num_letracms = $this->centena(Floor($numcmeros/1000000))." MILLONES ".($this->millon($numcmeros%1000000));		
		}
		if ($numcmeros < 100000000)
			$num_letracms = $this->decmillon($numcmeros);
		return $num_letracms;
	}	

	private function milmillon($nummierod){

		if ($nummierod >= 1000000000 && $nummierod <2000000000){
			$num_letrammd = "MIL ".($this->cienmillon($nummierod%1000000000));
		}
		if ($nummierod >= 2000000000 && $nummierod <10000000000){
			$num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".($this->cienmillon($nummierod%1000000000));
		}
		if ($nummierod < 1000000000)
			$num_letrammd = $this->cienmillon($nummierod);
		
		return $num_letrammd;
	}	
			        
        public function dowloadPDF($id){
            
            $pdf = DB::table('info_facture')
                     ->select('pdf')
                     ->where('status','=',1)
                     ->where('fkOrder','=',$id)
                     ->first();
      
             header("Content-disposition: attachment; filename=factura_cotizacion_".$id.".pdf");
             header("Content-type: application/pdf");
             readfile($pdf->pdf);
             exit;
        }
        
        public function dowloadXML($id){
            
            $pdf = DB::table('info_facture')
                     ->select('xml')
                     ->where('status','=',1)
                     ->where('fkOrder','=',$id)
                     ->first();
                     
             header("Content-type: application/xml");
             header("Content-disposition: attachment; filename=factura_cotizacion_".$id.".xml");
             readfile($pdf->xml);
             exit;
        }
        
        public function addpayment(Request $request){
              $image    = $request->file('image');
              $id       = $request->input('id');
              $flag = "true";
              
              if($image != ''){ 
                    if(file_exists ($image)){
                        $nameFile = $image->getClientOriginalName();
                        if($nameFile!=''){
                            $ext            = $image->extension();
                            
                            if(($ext == 'png') ||($ext == 'jpg')||($ext == 'jpeg') || ($ext == 'pdf')){

                                    
                                    $destinationPath = base_path('/public/images/payment/');
                                    $image->move($destinationPath, 'pago'.$nameFile);
                                   
                                
                                    $fileUpdate         = DB::table('info_facture')
                                                                ->where('fkOrder','=',$id)
                                                                ->where('status','=',1)
                                                                ->update(array("pay" => 'pago'.$nameFile));
                                    
                                    if($fileUpdate > 0){     
                                        
                                    }else{
                                     $flag = "false";   
                                    }
         
                            }
                        }
                    }
                }else{
                 $flag = "false";    
                }
                
                if($flag == "true"){
                      return \Response::json(array(
                                  "valid"       => "true",
                                ));   
                }else{
                   return \Response::json(array(
                                  "valid"       => "false",
                                ));   
                }
        }
        
        public function getCoursesQuotation(Request $request){
            
           $selectCourse = "";
           $count         = $request->input('count');
            
           $corses = DB::table('courses')
                        ->select('pkCourses'
                                ,'name'
                                ,'code')
                        ->where('status','=',1)
                        ->orderby('code','asc')
                        ->get();
           
          $selectCourse .= '<select id="slcCourseQ_'.$count.'_1" class="form-control slcCourseQ">'
                          .'<option value="-1">Sin definir</option>';
            
            foreach($corses as $item){
              $selectCourse .=  '<option value="'.$item->pkCourses.'">'.$item->code.'-'.$item->name.'</option>';
            }
           
             $selectCourse .= '</select>';
                     
                return $selectCourse;
           
        }
        
        public function getCoursesQuotation2(Request $request){
            
           $selectCourse = "";
           $count         = $request->input('count');
            
           $corses = DB::table('courses')
                        ->select('pkCourses'
                                ,'name'
                                ,'code')
                        ->where('status','=',1)
                        ->orderby('code','asc')
                        ->get();
           
          $selectCourse .= '<select id="slcCourseQC_'.$count.'_1" class="form-control slcCourseQC">'
                          .'<option value="-1">Sin definir</option>';
            
            foreach($corses as $item){
              $selectCourse .=  '<option value="'.$item->pkCourses.'">'.$item->code.'-'.$item->name.'</option>';
            }
           
             $selectCourse .= '</select>';
                     
                return $selectCourse;
           
        }
        
        public function generateBreakdown(Request $request){
             $pkQuotations         = $request->input("pkQuotation");
             $cursesArray          = array();
        
             $quotationDetail   = DB::table('quotations_detail')
                                      ->select('pkQuotations_detail'
                                              ,DB::raw("(CASE WHEN type = 0 THEN 'Precio Lista' 
                                                     WHEN type = 1 THEN 'Promocion'
                                                     ELSE 'N/A' END) as type")
                                             ,'price'
                                             ,'number_places')
                                      ->where('fkQuotations','=',$pkQuotations)
                                      ->get();
             
             foreach($quotationDetail as $info){
                  
                  $courses = DB::table('quotation_by_courses as q')
                               ->join('courses as c','c.pkCourses','=','q.fkCourses')
                               ->select('c.name'
                                       ,'c.code'
                                       ,'c.link'
                                       ,'q.pk_quotation_by_courses'
                                       ,'q.places')
                               ->where('q.fkQuotationDetail','=',$info->pkQuotations_detail)
                               ->where('q.status','=',1)
                               ->get();
                  
                  $cursesArray[$info->pkQuotations_detail] = $courses;
              }
                        
            
              $view = view('cotizaciones.generateBreakdown', array(
                    "cursesArray"     => $cursesArray,
                    "quotationDetail" => $quotationDetail,
                    "pkQuotations"    => $pkQuotations,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                )); 
        }
        
        public function generateBreakdownDB(Request $request){
            
             $arrayOptions       = json_decode($request->input('arrayOptions'));
             $pkQuotation        = $request->input("pkQuotation");
             $flag               = "true";
            
              
            try { 
                
                $updateQuotation = DB::table("quotations")
                                 ->where("pkQuotations", "=" ,$pkQuotation)
                                 ->update(['dropdown' => 1]);
                
               if($updateQuotation >=  1){
                 
                foreach($arrayOptions as $arrayOptionsInfo){
                   
                    $update = DB::table("quotation_by_courses")
                                 ->where("pk_quotation_by_courses", "=" ,$arrayOptionsInfo[0])
                                 ->update(['places' => $arrayOptionsInfo[1]]);
                    
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
         
        public function removeBreakdown(Request $request){
            
        
             $pkQuotation        = $request->input("pkQuotation");
             $flag               = "true";
            
              
            try { 
                
                $updateQuotation = DB::table("quotations")
                                 ->where("pkQuotations", "=" ,$pkQuotation)
                                 ->update(['dropdown' => 0]);
                
               if($updateQuotation >=  1){
                 
               
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
        
        public function sendMailQuotation(Request $request){
             $pkQuotations         = $request->input("pkQuotation");
             $type         = $request->input("type");

             $bussines = DB::table('quotations as q')
                                   ->join('business as b','b.pkBusiness','=','q.fkBusiness')
                                   ->select('b.pkBusiness'
                                           ,'q.folio')
                                   ->where('b.status','=',1)
                                   ->where('q.status','=',1)
                                   ->where('q.pkQuotations','=',$pkQuotations)
                                   ->first();
          
             $bussines_contact = DB::table('contacts_by_business')
                                   ->select('name'
                                           ,'pkContact_by_business'
                                           ,'mail')
                                   ->where('fkBusiness','=',$bussines->pkBusiness)
                                   ->where('status','=',1)
                                   ->get();
              
              $view = view('cotizaciones.getSendMail', array(
                    "bussines_contact" => $bussines_contact,
                    "pkQuotations"     => $pkQuotations,
                    "bussines"         => $bussines,
                    "type"             => $type
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                )); 
        }
        
        public function sendMailQuotationDB(Request $request){
                        
             $cursesArray         = array();
             $pkQuotation         = $request->input("pkQuotation");
             $destinity           = $request->input("destinity");
             $copia               = $request->input("copia");
             $copiaO              = $request->input("copiaO");
             $subject             = $request->input("subject");
             $messageDet          = $request->input("message");
             $type                = $request->input("type");
             $mails               = json_decode($request->input('message'));

             $pkUser            = Session::get("pkUser");

             $emailSend = DB::table('users')
                             ->select('mail')
                             ->where('pkUser','=',$pkUser)
                             ->where('status','=',1)
                             ->first();
            
             try{
              $infoEmail = DB::table('quotations as q')
                                   ->leftjoin('business as b','b.pkBusiness','=','q.fkBusiness')
                                   ->leftjoin('users as u','u.pkUser','=','q.fkUser')
                                   ->where('q.status','=',1)
                                   ->where('b.status','=',1)
                                   ->where('q.pkQuotations','=',$pkQuotation)
                                   ->first();
              
              $infoDetailQuotation = DB::table('quotations_detail')
                                       ->select('number_places'
                                               ,'price'
                                               ,'iva'
                                               ,'isSelected'
                                               ,'pkQuotations_detail'
                                               ,DB::raw("DATE_FORMAT(date, '%d de %b, %Y') as date")
                                               ,DB::raw("(CASE WHEN type = 0 THEN 'Precio Lista' 
                                                     WHEN type = 1 THEN 'Promocion'
                                                     ELSE 'N/A' END) as type")
                                               )
                                      ->where('fkQuotations','=',$pkQuotation)
                                      ->where('status','=',1)
                                      ->get();
              
              foreach($infoDetailQuotation as $info){

                if($infoEmail->withIva){
                    $info->price = $this->helper->getPriceWithIvaQuotation($info->price,$info->iva);
                  }
                  
                  $courses = DB::table('quotation_by_courses as q')
                               ->join('courses as c','c.pkCourses','=','q.fkCourses')
                               ->select('c.name'
                                       ,'c.code'
                                       ,'c.link'
                                       ,'q.places')
                               ->where('q.fkQuotationDetail','=',$info->pkQuotations_detail)
                               ->where('q.status','=',1)
                               ->get();
                  
                  $cursesArray[$info->pkQuotations_detail] = $courses;
              }
                         
              $view = view('emails.quotation', array(
                    "infoEmail"           => $infoEmail,
                    "infoDetailQuotation" => $infoDetailQuotation,
                    "cursesArray"         => $cursesArray,
                    "type"                => $type
                        ))->render();
              
              
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->host;             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->username;      // SMTP username
            $mail->Password = $this->password;                    // SMTP password
           // $mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
           // $mail->Port = 587;
              $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
              $mail->Port = 465;

            $mail->setFrom($emailSend->mail, 'Abrevius');
            $mail->addAddress($destinity);     // Add a recipient
            if(!empty($copia)){
            $mail->addCC($copia);
            
            }
            if(!empty($copiaO)){
           $mail->addBCC($copiaO);
            }
            
            $mail->addReplyTo($emailSend->mail, 'Abrevius');
            

            $meesageAdd = $messageDet."<br />".$view;
            $meesage = $meesageAdd;
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8'; // Set email format to HTML// Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $meesage;
            $mail->send();
                  
            return "true";
              } catch (Exception $ex) {
                  return $ex->getMessage();
              }

        }
        
        
}
