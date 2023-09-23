<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Capacitation extends Model {
        public    $timestamps   = false;
	protected $table 	= 'capacitation';
	protected $primaryKey 	= "pkCapacitation";
	protected $fillable	= array(
                                  'dateBon',
                                  'status');
}