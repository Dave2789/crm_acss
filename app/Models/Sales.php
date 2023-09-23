<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Sales extends Model {
        public    $timestamps   = false;
	protected $table 	= 'sales';
	protected $primaryKey 	= "pkSales";
	protected $fillable	= array(
                                  'idWordpress',
                                  'mont',
                                  'places',
                                  'currency',
                                  'typePayment',
                                  'status');
}