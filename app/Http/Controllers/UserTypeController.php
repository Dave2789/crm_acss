<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\User_type;
use Illuminate\Http\Request;

class UserTypeController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewUserType()
        {
            $userTypeQuery    = DB::table("user_type")
                                    ->where('user_type.status','=',1)
                                    ->get();
            
            
            return view('catalogos.tiposUsuarios', ["userTypeQuery" => $userTypeQuery]);
        }
        
        public function addUserType (Request $request) 
        {
            $name = $request->input("name");
            
            
            $insertUserType = new User_type;
            $insertUserType->name = htmlentities ($name);
            $insertUserType->status = 1;
            
            if($insertUserType->save()){
                return "true";
            }else{
                return "false";
            }
        }
        
        
        public function viewupdateUserType(Request $request){
            $pkUser_type  = $request->input("idUser");
            
            $userType    = DB::table('user_type')
                          ->select('pkUser_type'
                                  ,'name')
                          ->where('status','=',1)
                          ->where('pkUser_type','=',$pkUser_type)
                          ->first();
            
               $view = view('catalogos.editarTiposUsuario', array(
                    "userType" => $userType,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));            
        }
        
        public function updateUserType (Request $request) 
        {
            $pkUserType        = $request->input("idType");
            $name               = htmlentities ($request->input("name"));
            
      
            $userTypeUpdate   = DB::table("user_type")
                                    ->where('user_type.pkUser_type','=',$pkUserType)
                                    ->where('user_type.status','=',1)
                                    ->update(array("name" => $name));
            
            if($userTypeUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function deleteUserType (Request $request) 
        {
            $pkUserType         = $request->input("pkUserType");
            
            $userTypeUpdate   = DB::table("user_type")
                                    ->where('user_type.pkUser_type','=',$pkUserType)
                                    ->where('user_type.status','=',1)
                                    ->update(array("status" => 0));
            
            if($userTypeUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
	
}
