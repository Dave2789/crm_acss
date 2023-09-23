<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Activities_type;
use Illuminate\Http\Request;
use App\Models\Document;
class DocumentController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewCreateDocument()
        {
           $document = DB::table('documents')
                          ->select('name'
                                  ,'pkDocument'
                                  ,'document'
                                  ,DB::raw("DATE_FORMAT(date, '%d/%m/%Y') as date"))
                          ->where('status','=',1)
                          ->get();
                   
            return view('document.createDocument')->with('document',$document);
        }
        
        public function viewCreateDocumentDB (Request $request) 
        {
            $text   = $request->input("name");
            $image  = $request->file('file');
            $flag   = "true";
            $date   = date("Y-m-d");
  
               DB::beginTransaction();
             
            try { 
                if($image != ''){ 
                    if(file_exists ($image)){
                        $nameFile = $image->getClientOriginalName();
                        if($nameFile!=''){
                            $ext            = $image->extension();
                            
                            if(($ext == 'png') ||($ext == 'jpg')||($ext == 'jpeg') || ($ext == 'pdf')|| ($ext == 'docx')){
                                
                                $insertUsers             = new Document;
                                $insertUsers->name       = $text;
                                $insertUsers->date       = $date;
                                $insertUsers->document   = "";
                                $insertUsers->status     = 1;
                                
                                if($insertUsers->save()){
                                    
                                    $destinationPath = base_path('/public/document/');
                                    $image->move($destinationPath, 'file_'.$insertUsers->name.'.'.$ext);
                                   
                                
                                    $fileUpdate         = DB::table('documents')
                                                                ->where('pkDocument','=',$insertUsers->pkDocument)
                                                                ->where('status','=',1)
                                                                ->update(array("document" => 'file_'.$insertUsers->name.'.'.$ext));
                                    
                                    if($fileUpdate > 0){     
                                        
                                    }else{
                                     $flag = "false";   
                                    }
    
                                }else{
                                    $flag           = "false";
                                    $message    .= "Error al crear registro \n";
                                }
                            }
                        }
                    }
                }else{
                   $flag           = "false"; 
                }

                
                if($flag == "true"){
                    DB::commit();
                 return "true";
                }else{
                    DB::rollback(); 
                    return "fasle";
                }
          } catch (\Exception $e) {
                DB::rollback(); 
                //return "Error del sistema, favor de contactar al desarrollador";
                return $e->getMessage();
          }  
            
        }
        
        public function updateDocument(Request $request){
           $pkDocument  = $request->input("pkDocument");
            
            $document    = DB::table('documents')
                          ->select('pkDocument'
                                  ,'name'
                                  ,'document')
                          ->where('status','=',1)
                          ->where('pkDocument','=',$pkDocument)
                          ->first();
            
               $view = view('document.updateDocument', array(
                    "document" => $document,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));          
        }
        
        public function updateDocumentDB (Request $request) 
        {
            $pkDocument        = $request->input("id");
            $text              = $request->input("name");
    
            
            $activityTypeUpdate     = DB::table("documents")
                                    ->where('pkDocument','=',$pkDocument)
                                    ->where('status','=',1)
                                    ->update(array("name" => $text));
            
            if($activityTypeUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function deleteDocument (Request $request) 
        {
            $pkDocument         = $request->input("pkDocument");
            
            $document   = DB::table("documents")
                                    ->where('pkDocument','=',$pkDocument)
                                    ->where('status','=',1)
                                    ->update(array("status" => 0));
            
            if($document >= 1){
                return "true";
            }else{
                return "false";
            }
        }
	
}
