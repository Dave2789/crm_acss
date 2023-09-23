<?php namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Info_facture extends Model {
        public    $timestamps   = false;
	protected $table 	= 'info_facture';
	protected $primaryKey 	= "pkInfoFacture";
	protected $fillable	= array(
                                  'fkOrder',
                                  'rfc',
                                  'rfc',
                                  'razon',
                                  'serie',
                                  'dateFact',
                                  'cfdi',
                                  'payment',
                                  'method',
                                  'conditionPayment',
                                  'productKey',
                                  'unitKey',
                                  'numIdentification',
                                 'description',
                                  'status');
}