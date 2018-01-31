<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BestellungProdukt extends Model
{
    protected $table="Bestellungen_Produkte";

    public function bestellung() {
		return $this->hasOne('App\Bestellung', 'id', 'Bestellung_ID');
	}

	public function produkt() {
		return $this->hasOne('App\Produkt', 'id', 'Produkt_ID');
	}
}
