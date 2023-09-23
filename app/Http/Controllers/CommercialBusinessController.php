<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Commercial_business;
use Illuminate\Http\Request;

class CommercialBusinessController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewCommercialBusiness()
        {
            $commercialBusinessQuery    = DB::table("commercial_business")
                                            ->where('commercial_business.status','=',1)
                                            ->get();
            
            
            return view('catalogos.giros', ["commercialBusinessQuery" => $commercialBusinessQuery]);
        }
        
        public function addCommercialBusiness (Request $request) 
        {
            $name = $request->input("name");
            
            
            $insertCommercialBusiness = new Commercial_business;
            $insertCommercialBusiness->name = htmlentities ($name);
            $insertCommercialBusiness->status = 1;
            
            if($insertCommercialBusiness->save()){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function CommercialBusiness(Request $request){
               $pkCommercial_business  = $request->input("pkCommercial_business");
            
            $Commercial_business    = DB::table('commercial_business')
                          ->select('pkCommercial_business'
                                  ,'name')
                          ->where('status','=',1)
                          ->where('pkCommercial_business','=',$pkCommercial_business)
                          ->first();
            
               $view = view('catalogos.editarGiros', array(
                    "Commercial_business" => $Commercial_business,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));          
        }
        
        public function updateCommercialBusiness (Request $request) 
        {
            $pkCommercialBusiness        = $request->input("pkCommercialBusiness");
            $name               = $request->input("name");
            
            $commercialBusinessUpdate   = DB::table("commercial_business")
                                    ->where('commercial_business.pkCommercial_business','=',$pkCommercialBusiness)
                                    ->where('commercial_business.status','=',1)
                                    ->update(array("name" => $name));
            
            if($commercialBusinessUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function deleteCommercialBusiness (Request $request) 
        {
            $pkCommercialBusiness         = $request->input("pkCommercialBusiness");
            
            $commercialBusinessUpdate   = DB::table("commercial_business")
                                    ->where('commercial_business.pkCommercial_business','=',$pkCommercialBusiness)
                                    ->where('commercial_business.status','=',1)
                                    ->update(array("status" => 0));
            
            if($commercialBusinessUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function saveMasiveBussinesTypeDB(Request $request){
           
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
                                              if(!empty($row[0]) && $row[0] != ""){
                                                  

                                                                  $insertBusiness = new Commercial_business;;
                                                                  $insertBusiness->name = htmlentities ($row[0]);
                                                                  $insertBusiness->status = 1;
                                                                  if($insertBusiness->save()){

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
