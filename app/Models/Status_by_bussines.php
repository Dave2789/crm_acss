<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Status_by_bussines extends Model {
        public    $timestamps   = false;
	protected $table 	= 'status_by_bussines';
	protected $primaryKey 	= "pkStatus_by_bussines";
	protected $fillable	= array(
                                  'fkBusiness',
                                  'fkOpportunities',
                                  'fkQuotations',
                                  'fkBusiness_status',
                                  'status');
}