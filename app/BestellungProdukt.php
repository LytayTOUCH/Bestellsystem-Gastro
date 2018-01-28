<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BestellungProdukt extends Model
{
    protected $table="Bestellungen_Produkte";

    public function Bestellung() {
		return $this->hasMany('App\Bestellung', 'Bestellung_ID', 'id');
	}
}
