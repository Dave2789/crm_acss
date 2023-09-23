<?php namespace App\Helpers;

use DB;
use Input;
use Session;

class helper {
    /* métodos y/o atributos */
    public function getPriceWithIva($price){
        
        $priceTotal = 0;
        $ivaPorcent = DB::table('price_places')
                        ->select('iva')
                        ->where('status','=',1)
                        ->first();
        
        $ivaPrice    = ($price * ($ivaPorcent->iva/100));
        
        $priceTotal = $price + $ivaPrice;
        
        return $priceTotal;
    }
    
    public function getIva(){
        
       $ivaPorcent = DB::table('price_places')
                        ->select('iva')
                        ->where('status','=',1)
                        ->first();
       
       return $ivaPorcent->iva;
       
    }
    
    public function getPriceWithIvaQuotation($price,$iva){
     $priceTotal = 0;
     
     $ivaPrice    = ($price * ($iva/100));
        
     $priceTotal = $price + $ivaPrice;
        
     return $priceTotal;   
    }

    public function getPriceWithNotIva($price){
        $priceTotal = 0;
        $ivaPorcent = DB::table('price_places')
                        ->select('iva')
                        ->where('status','=',1)
                        ->first();
        
        $ivaPrice    = ($price / (100 + $ivaPorcent->iva));
      
        $priceTotal = $ivaPrice * 100;
      
        return $priceTotal;
       }
   
    public function getPriceUnit($price,$qtyTotal,$qty){

        $priceUnitTotal = $price / $qtyTotal;
       // $priceUnit      = $priceUnitTotal * $qty;

       return $priceUnitTotal;

    }

}