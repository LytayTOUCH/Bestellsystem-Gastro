<?php

namespace App\Models\Bestellungen;
use Illuminate\Database\Eloquent\Model;

class BestellungProdukt extends Model
{
    protected $table="Bestellungen_Produkte";

    public function bestellung() {
		return $this->hasOne('App\Models\Bestellungen\Bestellung', 'id', 'Bestellung_ID');
	}

	public function produkt() {
		return $this->hasOne('App\Models\Produkte\Produkt', 'id', 'Produkt_ID');
	}
}
