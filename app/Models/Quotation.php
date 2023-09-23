<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model {
        public    $timestamps   = false;
	protected $table 	= 'quotations';
	protected $primaryKey 	= "pkQuotations";
	protected $fillable	= array(
                                  'name',
                                  'fkOpportunities',
                                  'fkBusiness',
                                  'fkUser',
                                  'fkLevel_interest',
                                  'quotations_status',
                                  'final_date',
                                  'register_day',
                                  'register_hour',
                                  'status');
}