<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Comition extends Model {
        public    $timestamps   = false;
	protected $table 	= 'comition';
	protected $primaryKey 	= "pkComition";
	protected $fillable	= array(
                                  'higher_to',
                                  'higher_or_equal_to',
                                  'less_or_equal_to',
                                  'less_to',
                                  'comition_higher',
                                  'comition_higher_less',
                                  'comition_less',
                                  'dateBon',
                                  'status');
}