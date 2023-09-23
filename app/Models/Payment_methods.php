<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Payment_methods extends Model {
        public    $timestamps   = false;
	protected $table 	= 'payment_methods';
	protected $primaryKey 	= "pkPayment_methods";
	protected $fillable	= array(
                                  'name',
                                  'status');
}