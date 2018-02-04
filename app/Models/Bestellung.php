<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Bestellung extends Model
{
	protected $table = "Bestellungen";

	public function produkte() {
		return $this->hasMany('App\BestellungProdukt', 'Bestellung_ID', 'id');
	}
}
