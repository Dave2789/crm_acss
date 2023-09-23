<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Quotation_detail extends Model {
        public    $timestamps   = false;
	protected $table 	= 'quotations_detail';
	protected $primaryKey 	= "pkQuotations_detail";
	protected $fillable	= array(
                                  'fkQuotations',
                                  'number_places',
                                  'price',
                                  'type',
                                  'date',
                                  'status');
}