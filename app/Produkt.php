<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produkt extends Model
{
    protected $table = "Produkte";

    public function kategorie() {
    	return $this->hasOne('App\Kategorie', 'id', 'category');
    }
}
