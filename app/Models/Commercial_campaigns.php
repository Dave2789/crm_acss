<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Commercial_campaigns extends Model {
        public    $timestamps   = false;
	protected $table 	= 'commercial_campaigns';
	protected $primaryKey 	= "pkCommercial_campaigns";
	protected $fillable	= array(
                                  'code',
                                  'name',
                                  'fkUser',
                                  'start_date',
                                  'end_date',
                                  'register_date',
                                  'final_date',
                                  'fkCampaigns_type',
                                  'description',
                                  'status');
}