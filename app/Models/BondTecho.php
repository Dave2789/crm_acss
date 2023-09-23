<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class BondTecho extends Model {
        public    $timestamps   = false;
	protected $table 	= 'bonus_techo';
	protected $primaryKey 	= "pkBonus_techo";
	protected $fillable	= array(
                                  'montMet',
                                  'montRep',
                                  'slcTypeMont',
                                  'montPen',
                                  'dateBon',
                                  'status');
}