<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class BondBase extends Model {
        public    $timestamps   = false;
	protected $table 	= 'bond_base';
	protected $primaryKey 	= "pkBond_base";
	protected $fillable	= array(
                                  'pkBond_base',
                                  'montRec',
                                  'porcentBon',
                                  'montMin',
                                  'porcentPenalty',
                                  'porcentFirst',
                                  'dateBon',
                                  'status');
}