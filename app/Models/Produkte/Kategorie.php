<?php

namespace App\Models\Produkte;
use Illuminate\Database\Eloquent\Model;

class Kategorie extends Model
{
    protected $table = 'Kategorien';

    public function produkte() {
    	return $this->hasMany('App\Produkt', 'category', 'id');
    }
}
