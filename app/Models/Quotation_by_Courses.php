<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Quotation_by_Courses extends Model {
        public    $timestamps   = false;
	protected $table 	= 'quotation_by_courses';
	protected $primaryKey 	= "pk_quotation_by_courses";
	protected $fillable	= array(
                                  'fkQuotationDetail',
                                  'fkCourses',
                                  'status');
}