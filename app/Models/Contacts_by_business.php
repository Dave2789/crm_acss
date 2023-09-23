<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Contacts_by_business extends Model {
        public    $timestamps   = false;
	protected $table 	= 'contacts_by_business';
	protected $primaryKey 	= "pkContact_by_business";
	protected $fillable	= array(
                                  'fkBusiness',
                                  'name',
                                  'mail',
                                  'area',
                                  'phone',
                                  'mobile_phone',
                                  'status');
}