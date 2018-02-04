<?php

namespace App\Models\Bestellungen;
use Illuminate\Database\Eloquent\Model;

class Bestellung extends Model
{
	protected $table = "Bestellungen";

	public function produkte() {
		return $this->hasMany('App\Models\Bestellungen\BestellungProdukt', 'Bestellung_ID', 'id');
	}
}
