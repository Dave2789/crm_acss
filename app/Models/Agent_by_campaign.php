<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Agent_by_campaign extends Model {
        public    $timestamps   = false;
	protected $table 	= 'agent_by_campaign';
	protected $primaryKey 	= "pkAgent_by_campaign";
	protected $fillable	= array(
                                  'fkCommercial_campaigns',
                                  'fkUser',
                                  'status');
}