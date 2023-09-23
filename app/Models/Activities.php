<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Activities extends Model {
        public    $timestamps   = false;
	protected $table 	= 'activities';
	protected $primaryKey 	= "pkActivities";
	protected $fillable	= array(
                                  'fkBusiness',
                                  'pkOpportunities',
                                  'pkQuotations',
                                  'fkUser',
                                  'fkActivities_type',
                                  'description',
                                  'register_date',
                                  'register_hour',
                                  'execution_date',
                                  'execution_hour',
                                  'final_date',
                                  'final_hour',
                                  'fkActivities_subtype',
                                  'status');
}