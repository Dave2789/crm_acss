<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Opportunity_by_Courses extends Model {
        public    $timestamps   = false;
	protected $table 	= 'opportunity_by_courses';
	protected $primaryKey 	= "pk_opportunity_by_courses";
	protected $fillable	= array(
                                  'fkOpportunities',
                                  'fkCourses',
                                  'status');
}