<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Places_by_courses extends Model {
        public    $timestamps   = false;
	protected $table 	= 'places_by_courses';
	protected $primaryKey 	= "pkPlaces_by_courses";
	protected $fillable	= array('code',
                                  'name',
                                  'places',
                                  'status');
}