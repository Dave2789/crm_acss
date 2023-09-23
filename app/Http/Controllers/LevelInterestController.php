<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Level_interest;
use Illuminate\Http\Request;

class LevelInterestController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewLevelInterest()
        {
            $levelInterestQuery    = DB::table("level_interest")
                                    ->where('level_interest.status','=',1)
                                    ->get();
            
            
            return view('catalogos.nivelesInteres', ["levelInterestQuery" => $levelInterestQuery]);
        }
        
        public function addLevelInterest (Request $request) 
        {
            $text   = $request->input("name");
            $color  = $request->input("color");
            
            
            $insertLevelInterest = new Level_interest;
            $insertLevelInterest->text   = htmlentities ($text);
            $insertLevelInterest->color  = $color;
            $insertLevelInterest->status = 1;
            
            if($insertLevelInterest->save()){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function LevelInterest(Request $request){
             $pkLevel_interest  = $request->input("pkLevel_interest");
            
            $level    = DB::table('level_interest')
                          ->select('pkLevel_interest'
                                  ,'text'
                                  ,'color')
                          ->where('status','=',1)
                          ->where('pkLevel_interest','=',$pkLevel_interest)
                          ->first();
            
               $view = view('catalogos.editarNiveles', array(
                    "level" => $level,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));      
        }
        
        public function updateLevelInterest (Request $request) 
        {
            $pkLevelInterest        = $request->input("idLevel");
            $text              = $request->input("text");
            $color             = $request->input("color");
            
            $levelInterestUpdate     = DB::table("level_interest")
                                    ->where('level_interest.pkLevel_interest','=',$pkLevelInterest)
                                    ->where('level_interest.status','=',1)
                                    ->update(array("text" => $text, "color" => $color));
            
            if($levelInterestUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function deleteLevelInterest (Request $request) 
        {
            $pkLevelInterest         = $request->input("pkLevelInterest");
            
            $levelInterestUpdate   = DB::table("level_interest")
                                    ->where('level_interest.pkLevel_interest','=',$pkLevelInterest)
                                    ->where('level_interest.status','=',1)
                                    ->update(array("status" => 0));
            
            if($levelInterestUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
	
}
