<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Cources_by_capacitation extends Model {
        public    $timestamps   = false;
	protected $table 	= 'courses_by_capacitation';
	protected $primaryKey 	= "pkCourses_by_capacitation";
	protected $fillable	= array(
                                  'fkCapacitation',
                                  'nameCourse',
                                  'penality',
                                  'status');
}