<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Document extends Model {
        public    $timestamps   = false;
	protected $table 	= 'documents';
	protected $primaryKey 	= "pkDocument";
	protected $fillable	= array(
                                  'name',
                                  'document',
                                  'status');
}