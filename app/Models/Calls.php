<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Calls extends Model {
        public    $timestamps   = false;
	protected $table 	= 'calls';
	protected $primaryKey 	= "pkCalls";
	protected $fillable	= array(
                                  'date',
                                  'source',
                                  'destination',
                                  'srcChannel',
                                  'dstChannel',
                                  'statusCall',
                                  'duration',
                                  'status');
}