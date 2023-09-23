<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Business_by_commercial_campaigns extends Model {
        public    $timestamps   = false;
	protected $table 	= 'business_by_commercial_campaigns';
	protected $primaryKey 	= "pkBusiness_by_commercial_campaigns";
	protected $fillable	= array(
                                  'fkCommercial_campaigns',
                                  'fkBusiness',
                                  'fkOpportunities',
                                  'fkQuotations',
                                  'status');
}