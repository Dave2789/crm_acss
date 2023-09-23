<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class WorkingDays extends Model {
        public    $timestamps   = false;
	protected $table 	= 'working_days';
	protected $primaryKey 	= "pkWorking_day";
	protected $fillable	= array(
                                  'fkWorkinPlan',
                                  'day',
                                  'type',
                                  'status');
}