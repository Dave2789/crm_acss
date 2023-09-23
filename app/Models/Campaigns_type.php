<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Campaigns_type extends Model {
        public    $timestamps   = false;
	protected $table 	= 'campaigns_type';
	protected $primaryKey 	= "pkCampaigns_type";
	protected $fillable	= array(
                                  'name',
                                  'status');
}