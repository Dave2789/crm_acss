<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Courses extends Model {
        public    $timestamps   = false;
	protected $table 	= 'courses';
	protected $primaryKey 	= "pkCourses";
	protected $fillable	= array(
                                  'code',
                                  'name',
                                  'status');
}