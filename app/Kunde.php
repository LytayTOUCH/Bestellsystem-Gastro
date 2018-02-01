<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kunde extends Model
{
    protected $table="Kunden";

    public function tisch() {
    	return $this->hasOne('App\Tisch', 'id', 'Tisch_ID');
    }

    public static function offeneBestellungenCount($kundenId) {
        $kunde = Kunde::find($kundenId);
        $count = 0;
        foreach($kunde->bestelltes as $bestellung) {
            if($bestellung->Erledigt == false) {
                $count++;
            }
        }
        return $count;
    }

    public function bestelltes() {
    	return $this->hasManyThrough(
    		'App\Bestellung', 
    		'App\KundeBestellung',
    		'Kunden_ID',
            'id'
    	);
    }


}
