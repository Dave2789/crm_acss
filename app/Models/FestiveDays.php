<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class FestiveDays extends Model {
        public    $timestamps   = false;
	protected $table 	= 'festive_days';
	protected $primaryKey 	= "pkFestive_Days";
	protected $fillable	= array(
                                  'fkWorkinPlan',
                                  'day',
                                  'status');
}