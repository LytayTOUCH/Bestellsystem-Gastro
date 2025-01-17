<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\Bestellungen\Kunde;

class Tisch extends Model
{
    protected $table = "Tische";

    public function kunden() {
        return $this->hasMany('App\Kunde', 'Tisch_ID', 'id');
    }

    /* 
    Check if a table is already reserved or blocked by another customer
    */
    public static function IsTableBlocked($tableId) {
    	if(is_integer($tableId)) {
	    	$kundenTisch = Kunde::where('Tisch_ID', $tableId)->
				where('Abgerechnet', false)->first();

			if($kundenTisch !== null) {
				return true;
			} else {
				return false;
			}
	    } else {
	    	throw new Exception("Error Processing Request", 1);
	    }
    }

    /*
	Get the customer id of the selected table
	returns 0 when no customer @ table
    */
    public static function GetKundeFromTable($tableId) {
    	if(is_integer($tableId)) {
    		$kunde = Kunde::where('Tisch_ID', $tableId)->
    			where('Abgerechnet', false)->first();

    		if($kunde !== null) {
    			return $kunde->id;
    		} else {
    			return 0;
    		}
    	} else {
    		throw new Exception("Error Processing Request", 1);
    	}
    }
}
