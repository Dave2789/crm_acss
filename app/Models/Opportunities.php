<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Opportunities extends Model {
        public    $timestamps   = false;
	protected $table 	= 'opportunities';
	protected $primaryKey 	= "pkOpportunities";
	protected $fillable	= array(
                                  'folio',
                                  'color',
                                  'icon',
                                  'fkBusiness',
                                  'fkUser',
                                  'fkContact_by_business',
                                  'fkLevel_interest',
                                  'number_employees',
                                  'number_courses',
                                  'number_places',
                                  'price_total',
                                  'fkPayment_methods',
                                  'opportunities_status',
                                  'final_date',
                                  'status');
}