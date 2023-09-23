<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Activities_type extends Model {
        public    $timestamps   = false;
	protected $table 	= 'activities_type';
	protected $primaryKey 	= "pkActivities_type";
	protected $fillable	= array(
                                  'text',
                                  'color',
                                  'status');
}