<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Penality_by_bond extends Model {
    public    $timestamps   = false;
	protected $table 	    = 'penality_by_bond';
	protected $primaryKey 	= "pkPenality_by_bond";
	protected $fillable	    = array(
                                  'fkBond_base',
                                  'fkUser',
                                  'penality',
                                  'status');
}