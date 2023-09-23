<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Business_status extends Model {
        public    $timestamps   = false;
	protected $table 	= 'business_status';
	protected $primaryKey 	= "pkBusiness_status";
	protected $fillable	= array(
                                  'name',
                                  'status');
}