<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Business_origin extends Model {
        public    $timestamps   = false;
	protected $table 	= 'business_origin';
	protected $primaryKey 	= "pkBusiness_origin";
	protected $fillable	= array(
                                  'name',
                                  'status');
}