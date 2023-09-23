<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Users extends Model {
        public    $timestamps   = false;
	protected $table 	= 'users';
	protected $primaryKey 	= "pkUser";
	protected $fillable	= array(
                                  'fullName',
                                  'userName', 
                                  'password',
                                  'mail',
                                  'fkUser_type',
                                  'privileges',
                                  'register_date',
                                  'phone_extension',
                                  'status');
}