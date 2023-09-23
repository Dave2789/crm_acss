<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class ConfigPrice extends Model {
        public    $timestamps   = false;
	protected $table 	= 'price_places';
	protected $primaryKey 	= "pkPrice_place";
	protected $fillable	= array(
                                  'price',
                                  'status');
}