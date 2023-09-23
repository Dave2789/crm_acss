<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Business_type extends Model {
        public    $timestamps   = false;
	protected $table 	= 'business_type';
	protected $primaryKey 	= "pkBusiness_type";
	protected $fillable	= array(
                                  'name',
                                  'status');
}