<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bestellung extends Model
{
	protected $table = "Bestellungen";

	public function BestellungProdukte() {
		return $this->hasMany('App\BestellungProdukt');
	}
}
