<?php namespace App\Permissions;

use DB;
use Input;
use Session;

class UserPermits {
    /* métodos y/o atributos */
    public function pagePrincipal(){
        $permition = Session::get('permition');
            
            if ($permition->permition->dashboard == 1) {
                return "true";
            } else {
                return "false";
            }
    }
    
    private function search($module,$function){
        
        foreach($module as $key => $item){
           if($key == $function){
            
               return $item;
           }else{
               if(is_object($item)){
                   if($this->search($item,$function) > 0){
                  return $this->search($item,$function); 
                   }else{
                     $this->search($item,$function);   
                   }
               }
            }    
         }
         return -1;
    }
        
    public function getPermition($function){
        $permition = Session::get('permition'); 
        $isadmin = Session::get("isAdmin");
        $resp = 0;
        
     if($isadmin == 0){
      $resp = $this->search($permition->permition,$function);
     }else{
      $resp = 1;   
      }

      return $resp;
    
   }

}