<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class PermitionDays extends Model {
        public    $timestamps   = false;
	protected $table 	= 'pemition_day';
	protected $primaryKey 	= "pkPermitionDay";
	protected $fillable	= array('fkWorkinPlan',
                                  'day',
                                  'hours',
                                  'comment',
                                  'status');
}