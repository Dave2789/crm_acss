<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class WorkPlan extends Model {
        public    $timestamps   = false;
	protected $table 	= 'workplan';
	protected $primaryKey 	= "pkWorkplan";
	protected $fillable	= array(
                                  'fkUser',
                                  'qtyCallsHour',
                                  'qtyHourMonth',
                                  'callsFaild',
                                  'callsLinked',
                                  'penalty',
                                  'montBase',
                                  'typeChange',
                                  'typeCurrency',
                                  'date',
                                  'hour',
                                  'status');
}