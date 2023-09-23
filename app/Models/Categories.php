<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {
        public    $timestamps   = false;
	protected $table 	= 'categories';
	protected $primaryKey 	= "pkCategory";
	protected $fillable	= array(
                                  'name',
                                  'status');
}