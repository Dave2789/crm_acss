<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Users_per_alert extends Model {
        public    $timestamps   = false;
	protected $table 	= 'users_per_alert';
	protected $primaryKey 	= "pkUser_per_alert";
	protected $fillable	= array(
                                  'fkUser_assigned',
                                  'view',
                                  'name',
                                  'date',
                                  'name',
                                  'hour',
                                  'status');
}