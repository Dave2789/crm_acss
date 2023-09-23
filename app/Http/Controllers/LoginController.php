<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\User_type;
use Illuminate\Http\Request;
use App\Permissions\UserPermits;

class LoginController extends Controller {

	public function __construct()
	{
		//$this->middleware('guest');
	}
        
        public function showLoginForm()
        {
            return view('login');
        }
        

	public function login(Request $request)
	{
        $flag = "false";
        $username = $request->input('username');
        $password = $request->input('pass');

        $usersQuery = DB::table("users")
                ->where('users.mail', '=', $username)
                ->where('users.password', '=', $password)
                ->where('users.status', '=', 1)
                ->get();

            if(\sizeof($usersQuery) > 0){
        foreach ($usersQuery as $userQuery) {
            $userType = User_type::find($userQuery->fkUser_type);
            $flag = "true";



            Session::put('pkUser', $userQuery->pkUser);
            Session::put('fullName', $userQuery->full_name);
            Session::put('userName', $userQuery->full_name);
            Session::put('image', $userQuery->image);
            Session::put('fkUserType', $userQuery->fkUser_type);
            Session::put('type', $userType->name);

            //numero de visitas
            $numVisit = DB::table('visits')
                    ->where('pkVisit', '=', 1)
                    ->first();

            $totalVisit = $numVisit->num_visit + 1;

            $updateNumVisit = DB::table("visits")
                    ->where("pkVisit", "=", 1)
                    ->update(['num_visit' => $totalVisit]);

            if ($updateNumVisit >= 1) {
                
            } else {
                $flag = "false";
            }

            //agente conectado
            $updateConcect = DB::table("users")
                    ->where("pkUser", "=",$userQuery->pkUser)
                    ->update(['connected' => 1]);
        }

        if ($userQuery->fkUser_type == 1) {
            Session::put('isAdmin', "1");
        } else {
            Session::put('isAdmin', "0");
            Session::put('permition', json_decode($userQuery->privileges));

            $UserPermits = new UserPermits();
            
            if($UserPermits->pagePrincipal() == "true") {
                return \Response::json(array("valid" => $flag
                            , "page" => 1));
            }else {
                
               if($userQuery->fkUser_type == 12){
                 return \Response::json(array("valid" => $flag
                            , "page" => 2
                            , "idUser" => $userQuery->pkUser));
               }else{

                if($userQuery->fkUser_type == 10){
              
                    return \Response::json(array("valid" => $flag
                               , "page" => 3
                               , "idUser" => $userQuery->pkUser));
                  }

                  return \Response::json(array("valid" => $flag
                            , "page" => 0
                            , "idUser" => $userQuery->pkUser)); 
               }
            }
            }
        }
        
         return \Response::json(array("valid" => $flag
                                     , "page" => 1));
    }
        
        public function logout () 
        {
            $idUser = Session::get("pkUser");
           
            $updateConcect  = DB::table("users")
                                ->where("pkUser", "=" ,$idUser)
                                ->update(['connected' => 0]);

            Session::flush();
            
            return redirect('/');
        }
}
