<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Commercial_business extends Model {
        public    $timestamps   = false;
	protected $table 	= 'commercial_business';
	protected $primaryKey 	= "pkCommercial_business";
	protected $fillable	= array(
                                  'name',
                                  'status');
}