<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\User_type;
use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewCreateUser()
        {
            
            $typeUser = DB::table('user_type')
                          ->select('pkUser_type'
                                  ,'name')
                          ->where('status','=',1)
                          ->get();
                    
            return view('users.createUser')->with('typeUser',$typeUser);
        }
        
        public function addCreateUserDB(Request $request){
            
             $group             = $request->input('group');
             $type              = $request->input('type');
             $name              = $request->input('name');
             $username          = $request->input('username');
             $extension         = $request->input('extension');
             $email             = $request->input('email');
             $password          = $request->input('password');
             $image             = $request->file('image');
             $permition         = $request->input('permition');

             $date               = date("Y-m-d");
             $flag               = "true";
          
            DB::beginTransaction();
             
            try { 
                if($image != ''){ 
                    if(file_exists ($image)){
                        $nameFile = $image->getClientOriginalName();
                        if($nameFile!=''){
                            $ext            = $image->extension();
                            
                            if(($ext == 'png') ||($ext == 'jpg')||($ext == 'jpeg')){
                                
                                $insertUsers                    = new Users;
                                $insertUsers->username          = $username;
                                $insertUsers->password          = $password;
                                $insertUsers->mail              = $email;
                                $insertUsers->full_name         = $name;
                                if($group == 1){
                                $insertUsers->fkUser_type     = 1;   
                                }
                                else{
                                    $insertUsers->fkUser_type       = $type;
                                }
                                $insertUsers->privileges        = $permition;
                                $insertUsers->register_date     = $date;
                                $insertUsers->phone_extension   = $extension;
                                $insertUsers->image             = "";
                                $insertUsers->connected         = 0;
                                $insertUsers->status            = 1;

                                
                                if($insertUsers->save()){
                                    
                                    $destinationPath = $_SERVER['DOCUMENT_ROOT'].'/images/usuarios/';
                                    $image->move($destinationPath, 'usersa_'.$insertUsers->pkUser.'.'.$ext);
                                   
                                
                                    $fileUpdate         = DB::table('users')
                                                                ->where('pkUser','=',$insertUsers->pkUser)
                                                                ->where('status','=',1)
                                                                ->update(array("image" => 'usersa_'.$insertUsers->pkUser.'.'.$ext));
                                    
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
                }
                else{
                     $insertUsers                    = new Users;
                                $insertUsers->username          = $username;
                                $insertUsers->password          = $password;
                                $insertUsers->mail              = $email;
                                $insertUsers->full_name         = $name;
                                if($group == 1){
                                $insertUsers->fkUser_type     = 1;   
                                }
                                else{
                                    $insertUsers->fkUser_type       = $type;
                                }
                                $insertUsers->privileges        = $permition;
                                $insertUsers->register_date     = $date;
                                $insertUsers->phone_extension   = $extension;
                                $insertUsers->image             = "";
                                $insertUsers->connected         = 0;
                                $insertUsers->status            = 1;

                                
                                if($insertUsers->save()){
                                
                                }else{
                                    $flag = "false";
                                }

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
        
        public function viewUser(){
            
            $users = DB::table('users as u')
                       ->leftjoin('user_type as t','t.pkUser_type','=','u.fkUser_type')
                       ->select('u.username'
                               ,'u.password'
                               ,'u.pkUser'
                               ,'u.mail'
                               ,'u.full_name'
                               ,'u.privileges'
                               ,'u.phone_extension'
                               ,'u.color'
                               ,'t.name as type'
                               ,'u.image')
                       ->where('u.status','=',1)
                       ->get();
            
           return view('users.viewUser')->with('users',$users);
        }
        
        public function deleteUser(Request $request){
            $pkUser       = $request->input("pkUser");
            
            
            $userDelete = DB::table("users")
                             ->where('pkUser','=',$pkUser)
                             ->where('status','=',1)
                             ->update(array("status" => 0));
            
            if($userDelete >= 1){
                return "true";
            }else{
                return "false";
            }
             
        }
        
        public function updateUser(Request $request){
            $pkUser  = $request->input("pkUser");
            
        $users  = DB::table('users as u')
                       ->leftjoin('user_type as t','t.pkUser_type','=','u.fkUser_type')
                       ->select('u.username'
                               ,'u.password'
                               ,'u.pkUser'
                               ,'u.mail'
                               ,'u.full_name'
                               ,'u.privileges'
                               ,'u.phone_extension'
                               ,'u.color'
                               ,'t.name as type'
                               ,'u.image')
                          ->where('u.status','=',1)
                          ->where('u.pkUser','=',$pkUser)
                          ->first();
            
               $view = view('users.updateUser', array(
                    "users" => $users,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
        }
        
        public function updateUserDB(Request $request){
             
             $pkUser            = $request->input('pkUser');
             $name              = $request->input('name');
             $username          = $request->input('username');
             $extension         = $request->input('extension');
             $email             = $request->input('email');
             $color             = $request->input('color');
             $password          = $request->input('password');
             $image             = $request->file('image');

             $date               = date("Y-m-d");
             $flag               = "true";
             
            DB::beginTransaction();
             
            try { 
                if($image != ''){ 
                    if(file_exists ($image)){
                        $nameFile = $image->getClientOriginalName();
                        if($nameFile!=''){
                            $ext            = $image->extension();
                            
                            if(($ext == 'png') ||($ext == 'jpg')||($ext == 'jpeg')){
                                
                                
                                    $destinationPath = $_SERVER['DOCUMENT_ROOT'].'/images/usuarios/';

                                    $image->move($destinationPath, 'users_'.$pkUser.'.'.$ext);
                                
                                $updateUser = DB::table("users")
                                                 ->where("pkUser", "=" ,$pkUser)
                                                 ->update(['username' => $username
                                                         ,'password'  => $password
                                                         ,'mail'      => $email
                                                         ,'color'     => $color
                                                         ,'full_name' => $name
                                                         ,'phone_extension' => $extension
                                                         ,'image' => 'users_'.$pkUser.'.'.$ext
                                                          ]);
                                    
                                    if($updateUser >= 1){     
                                        
                                    }else{
                                    // $flag = "false";   
                                    }

                            }
                        }
                    }
                }else{
                    $updateUser = DB::table("users")
                                                 ->where("pkUser", "=" ,$pkUser)
                                                 ->update(['username' => $username
                                                         ,'password' => $password
                                                         ,'mail' => $email
                                                         ,'color'     => $color
                                                         ,'full_name' => $name
                                                         ,'phone_extension' => $extension
                                                          ]);
                                    
                                    if($updateUser >= 1){     
                                        
                                    }else{
                                     $flag = "false";   
                                    }

                }
                
                if($flag == "true"){
                    DB::commit();
                 return "true";
                }else{
                    DB::rollback(); 
                    return "false";
                }
        } catch (\Exception $e) {
                DB::rollback(); 
                //return "Error del sistema, favor de contactar al desarrollador";
                return $e->getMessage();
        }  
         
        }
        
        public function updatePermition(Request $request){
            
             $pkUser  = $request->input("pkUser");
             $permition = array();
            
            $typeUser = DB::table('user_type')
                          ->select('pkUser_type'
                                  ,'name')
                          ->where('status','=',1)
                          ->get(); 
           
            
        $user  = DB::table('users as u')
                       ->join('user_type as t','t.pkUser_type','=','u.fkUser_type')
                       ->select('u.username'
                               ,'u.password'
                               ,'u.pkUser'
                               ,'u.mail'
                               ,'u.full_name'
                               ,'u.privileges'
                               ,'u.phone_extension'
                               ,'u.color'
                               ,'u.privileges'
                               ,'u.fkUser_type'
                               ,'t.name as type'
                               ,'u.image')
                          ->where('u.status','=',1)
                          ->where('u.pkUser','=',$pkUser)
                          ->first();
        
               $permition = json_decode($user->privileges);
            
               $view = view('users.updatePermition', array(
                    "user"      => $user,
                    "typeUser"  => $typeUser,
                    "permition" => $permition->permition,
                    "pkUser"    => $pkUser
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));   
            
        }
        
        public function updatePermitionDB(Request $request){
           
            
        $group = $request->input('group');
        $type = $request->input('type');
        $pkUser = $request->input('pkUser');
        $permition = $request->input('permition');
        $typeUser;
        
        if($group == 1){
         $typeUser  = 1;   
         }else{
          $typeUser  = $type;       
         }
        

        $updateUser = DB::table("users")
                ->where("pkUser", "=", $pkUser)
                ->update(['fkUser_type'   => $typeUser
                        , 'privileges' => $permition
                         ]);

        if ($updateUser >= 1) {
            return "true";
        } else {
            return "false";
        }
        
         return "false";
    }
        
        
	
}
