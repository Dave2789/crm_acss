<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class BondRecord extends Model {
        public    $timestamps   = false;
	protected $table 	= 'bond_record';
	protected $primaryKey 	= "pkBound_record";
	protected $fillable	= array(
                                  'slcTypeMont',
                                  'montRep',
                                  'montMet',
                                  'dateBon',
                                  'status');
}