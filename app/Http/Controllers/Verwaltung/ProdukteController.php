<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

class ProdukteController extends AuthController
{
    public function index() {
    	return view("verwaltung.produkte.index");
    }
}
