<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Alerts extends Model {
        public    $timestamps   = false;
	protected $table 	= 'alerts';
	protected $primaryKey 	= "pkAlert";
	protected $fillable	= array(
                                  'fkUser',
                                  'title',
                                  'comment',
                                  'date',
                                  'hour',
                                  'status');
}