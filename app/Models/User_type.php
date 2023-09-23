<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class User_type extends Model {
        public    $timestamps   = false;
	protected $table 	= 'user_type';
	protected $primaryKey 	= "pkUser_type";
	protected $fillable	= array(
                                  'name',
                                  'fingerPrint',
                                  'status');
}