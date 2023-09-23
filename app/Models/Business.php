<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Business extends Model {
        public    $timestamps   = false;
	protected $table 	= 'business';
	protected $primaryKey 	= "pkBusiness";
	protected $fillable	= array(
                                  'fkLevel_interest',
                                  'rfc',
                                  'name',
                                  'mail',
                                  'address',
                                  'number',
                                  'postal_code',
                                  'city',
                                  'state',
                                  'country',
                                  'phone',
                                  'mobile_phone',
                                  'fkComercial_business',
                                  'fkCategory',
                                  'fkUser',
                                  'fKOrigin',
                                  'image',
                                  'fkBusiness_type',
                                  'fkBusiness_status',
                                  'is_active',
                                  'status');
}