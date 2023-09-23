<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Level_interest extends Model {
        public    $timestamps   = false;
	protected $table 	= 'level_interest';
	protected $primaryKey 	= "pkLevel_interest";
	protected $fillable	= array(
                                  'text',
                                  'color',
                                  'status');
}