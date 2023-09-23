<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Activities_subtype extends Model {
        public    $timestamps   = false;
	protected $table 	= 'activities_subtype';
	protected $primaryKey 	= "pkActivities_subtype";
	protected $fillable	= array(
                                  'fkActivities_type',
                                  'text',
                                  'color',
                                  'status');
}