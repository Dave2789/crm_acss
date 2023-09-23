<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class AgentByBond extends Model {
        public    $timestamps   = false;
	protected $table 	= 'agent_by_bond';
	protected $primaryKey 	= "pkAgentByBond";
	protected $fillable	= array(
                                  'fkUser',
                                  'fkBond',
                                  'typeBond',
                                  'status');
}