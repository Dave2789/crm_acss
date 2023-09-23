<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class DiscountPlaces extends Model {
        public    $timestamps   = false;
	protected $table 	= 'discount_places';
	protected $primaryKey 	= "pkDiscount_places";
	protected $fillable	= array(
                                  'cantPlaces',
                                  'discount',
                                  'date',
                                  'status');
}